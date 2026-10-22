<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends CI_Model {

    private $central_db;
    private $tenant_db;
    private $tenant_data;

    public function __construct() {
        parent::__construct();
        
        // Load central database explicitly - this will NOT be affected by the hook
        $this->central_db = $this->load->database('central', TRUE);
    }

    // Initialize tenant_db from session
    private function _init_tenant_db() {
        if ($this->tenant_db) {
            return $this->tenant_db;
        }
        
        // Check if tenant info exists in session
        if ($this->session->userdata('tenant_id')) {
            $tenant_db_config = array(
                'dsn'       => '',
                'hostname'  => $this->session->userdata('tenant_db_host'),
                'username'  => $this->session->userdata('tenant_db_username'),
                'password'  => $this->session->userdata('tenant_db_password'),
                'database'  => $this->session->userdata('tenant_database'),
                'dbdriver'  => 'mysqli',
                'dbprefix'  => '',
                'pconnect'  => FALSE,
                'db_debug'  => (ENVIRONMENT !== 'production'),
                'cache_on'  => FALSE,
                'cachedir'  => '',
                'char_set'  => 'utf8',
                'dbcollat'  => 'utf8_general_ci',
                'swap_pre'  => '',
                'encrypt'   => FALSE,
                'compress'  => FALSE,
                'stricton'  => FALSE,
                'failover'  => array(),
                'save_queries' => TRUE
            );
            
            $this->tenant_db = $this->load->database($tenant_db_config, TRUE);
        }
        
        return $this->tenant_db;
    }

    public function auth() { 
        // ============================================
        // STEP 1: AUTHENTICATE USING CENTRAL DATABASE
        // ============================================
        
        // Check user in central database
        $this->central_db->group_start();
        $this->central_db->where('username', $_POST['un']);
        $this->central_db->or_where('email', $_POST['un']);
        $this->central_db->group_end();
        $this->central_db->where('status', 'active');
        $central_user = $this->central_db->get('users')->row();
        
        if (!$central_user) {
            return 0; // User not found
        }
        
        // Verify password
        $password_valid = false;
        
        if (password_verify($_POST['pw'], $central_user->password)) {
            $password_valid = true;
        } 
        else if ($_POST['pw'] == $central_user->password) {
            $password_valid = true;
            $this->central_db->where('id', $central_user->id);
            $this->central_db->update('users', [
                'password' => password_hash($_POST['pw'], PASSWORD_DEFAULT)
            ]);
        }
        
        if (!$password_valid) {
            return 0;
        }
        
        // ============================================
        // STEP 2: GET TENANT DETAILS
        // ============================================
        
        $this->central_db->where('id', $central_user->tenant_id);
        $this->central_db->where('status', 'active');
        $tenant = $this->central_db->get('tenants')->row_array();
        
        if (!$tenant) {
            return 0;
        }
        
        $this->tenant_data = $tenant;
        
        // ============================================
        // STEP 3: SWITCH TO TENANT DATABASE
        // ============================================
        
        $db_username = isset($tenant['database_username']) ? $tenant['database_username'] : $tenant['database_username'];
        
        $tenant_db_config = array(
            'dsn'       => '',
            'hostname'  => $tenant['database_host'],
            'username'  => $db_username,
            'password'  => $tenant['database_password'],
            'database'  => $tenant['database_name'],
            'dbdriver'  => 'mysqli',
            'dbprefix'  => '',
            'pconnect'  => FALSE,
            'db_debug'  => (ENVIRONMENT !== 'production'),
            'cache_on'  => FALSE,
            'cachedir'  => '',
            'char_set'  => 'utf8',
            'dbcollat'  => 'utf8_general_ci',
            'swap_pre'  => '',
            'encrypt'   => FALSE,
            'compress'  => FALSE,
            'stricton'  => FALSE,
            'failover'  => array(),
            'save_queries' => TRUE
        );
        
        $this->tenant_db = $this->load->database($tenant_db_config, TRUE);
        
        // ============================================
        // STEP 4: FULL AUTHENTICATION WITH TENANT DB
        // ============================================
        
        $this->tenant_db->join('sys_user_type','sys_user_type.ut_id = user.ut_id','left');
        $this->tenant_db->join('sys_info','sys_info.sys_info_id = user.com','left');
        
        $this->tenant_db->select("*,user.status status, user.com_id com_id, user.owner, sys_user_type.ut_name,stores.store_id");
        $this->tenant_db->join('branches','branches.branch_id=user.branch_id','left');
        //$this->tenant_db->join('staff_info','staff_info.staff_id=user.staff_id','left');
        $this->tenant_db->join('stores','stores.branch_id=branches.branch_id','left');
        
        $this->tenant_db->where('user.email', $_POST['un']);
        $this->tenant_db->where('user.status !=','del');
        $this->tenant_db->where('sys_user_type.status','active');
        
        $user_check = $this->tenant_db->get('user')->row();
        
        if ($user_check) {
            $tenant_password_valid = false;
            
            if (strpos($user_check->password, '$2y$') === 0) {
                if (password_verify($_POST['pw'], $user_check->password)) {
                    $tenant_password_valid = true;
                }
            } else {
                if ($_POST['pw'] == $user_check->password) {
                    $tenant_password_valid = true;
                    $this->tenant_db->where('user_id', $user_check->user_id);
                    $this->tenant_db->update('user', [
                        'password' => password_hash($_POST['pw'], PASSWORD_DEFAULT)
                    ]);
                }
            }
            
            if (!$tenant_password_valid) {
                return 0;
            }
            
            $q = $user_check;
        } else {
            return 0;
        }
        
        //Load system config
        $configs = $this->tenant_db
            ->select('sc_name, sc_value')
            ->where('sc_stt', 'act')
            ->get('sys_config')
            ->result_array();

        $sys_config = [];
        foreach ($configs as $config) {
            $sys_config[$config['sc_name']] = $config['sc_value'];
        }

        $this->session->set_userdata('sys_config', $sys_config);
        
        if ($q != null) {
            
            // Device tracking
            $this->load->model('device_manager/DeviceManager_model');
            $device_status = $this->DeviceManager_model->register_or_update_device($q->user_id);
            
            if ($device_status === 'blocked') {
                return 'blocked'; 
            }
            
            $this->tenant_db->where('com_id',$q->com_id);
            $this->tenant_db->order_by('d_id',"desc");
            $cd = $this->tenant_db->get('com_details')->row();
            
            if($cd)
                $cdstt=$cd->status;
            else
                $cdstt="na";
            
            $sys_user = $q->user_id;
            
            // ============================================
            // STEP 5: STORE SESSION DATA
            // ============================================
            
            // Store tenant info in session (CI session)
            $this->session->set_userdata([
                'tenant_id' => $tenant['id'],
                'tenant_code' => $tenant['tenant_code'],
                'tenant_name' => $tenant['tenant_name'],
                'tenant_database' => $tenant['database_name'],
                'tenant_db_host' => $tenant['database_host'],
                'tenant_db_username' => $db_username,
                'tenant_db_password' => $tenant['database_password'],
                'central_user_id' => $central_user->id
            ]);
            
            // ★★★ CRITICAL: Set $_SESSION directly for core controller ★★★
            $_SESSION['tenant_id'] = $tenant['id'];
            $_SESSION['tenant_code'] = $tenant['tenant_code'];
            $_SESSION['tenant_name'] = $tenant['tenant_name'];
            $_SESSION['tenant_database'] = $tenant['database_name'];
            $_SESSION['tenant_db_host'] = $tenant['database_host'];
            $_SESSION['tenant_db_username'] = $db_username;
            $_SESSION['tenant_db_password'] = $tenant['database_password'];
            $_SESSION['central_user_id'] = $central_user->id;
            $_SESSION['login'] = true;
            
            // YOUR EXISTING SESSION DATA
            $a = array(
                "login"=>true,
                "user_id"=>$q->user_id,
                "uid"=>$q->user_id,
                "central_user_id"=>$central_user->id,
                "ut_name"=>$q->ut_name, 
                "ut_id"=>$q->ut_id,
                "user_name"=>$q->full_name,
                //"staff"=>$q->stf_name,
                "short_name"=>$q->short_name,
                "whereouse_id"=>$q->store_id,
                "status"=>$q->status,
                "user_editable"=>$q->editable,
                "ut_type"=>$q->ut_type,
                "branch"=>$q->branch_id,
                "company_name"=>$q->company_name,
                "company_logo"=>$q->company_logo,
                "company_addr"=>$q->company_addr,
            );

            $this->session->set_userdata($a);
            
            // Also set these in $_SESSION for the core controller
            $_SESSION['user_id'] = $q->user_id;
            $_SESSION['uid'] = $q->user_id;
            $_SESSION['ut_name'] = $q->ut_name;
            $_SESSION['ut_id'] = $q->ut_id;
            $_SESSION['user_name'] = $q->full_name;
            $_SESSION['short_name'] = $q->short_name;
            $_SESSION['whereouse_id'] = $q->store_id;
            $_SESSION['status'] = $q->status;
            $_SESSION['user_editable'] = $q->editable;
            $_SESSION['ut_type'] = $q->ut_type;
            $_SESSION['branch'] = $q->branch_id;
            $_SESSION['company_name'] = $q->company_name;
            $_SESSION['company_logo'] = $q->company_logo;
            $_SESSION['company_addr'] = $q->company_addr;

            // Store system settings
            $this->load->model('Settings_m');
            $this->load->model('Menu_m');
            $b['sys_info'] = $this->Settings_m->getAllSystemInfo();
            $b['permissions'] = $this->Menu_m->getMenuItems($q->ut_id);
            $this->session->set_userdata($b);
            
            // Also set permissions in $_SESSION
            $_SESSION['sys_info'] = $b['sys_info'];
            $_SESSION['permissions'] = $b['permissions'];
            
            // Update login count
            $current_login_count = $central_user->login_count;
            $new_login_count = $current_login_count + 1;
            
            $this->central_db->where('id', $central_user->id);
            $this->central_db->update('users', [
                'login_count' => $new_login_count,
                'last_login' => date('Y-m-d H:i:s'),
                'last_ip' => $this->input->ip_address()
            ]);
            
            $columns = $this->tenant_db->list_fields('user');
            if (in_array('login_count', $columns)) {
                $this->tenant_db->where('user_id', $q->user_id);
                $this->tenant_db->update('user', [
                    'login_count' => $new_login_count,
                    'last_login' => date('Y-m-d H:i:s')
                ]);
            }
            
            // Activity log
            $user_id_fk = $this->session->userdata('user_id');
            $user_type = $this->session->userdata('ut_id');
            $this->Activity_log_m->addLog($user_id_fk,$user_type,'Login Module','Login','Login');
            
            $is_first_login = ($current_login_count == 0);
            
            if ($is_first_login) {
                $this->session->set_userdata('show_security_setup', true);
                $_SESSION['show_security_setup'] = true;
            }
            
            // Return user ID with additional info
            return [
                'status' => 'success',
                'user_id' => $q->user_id * 8,
                'central_user_id' => $central_user->id,
                'is_first_login' => $is_first_login,
                'redirect' => $is_first_login ? 'security_settings' : 'dashboard'
            ];
            
        } else {
            return 0;
        }
    }
    
    public function auth_with_details() {
        // Initialize tenant_db from session
        $this->_init_tenant_db();
        
        if (!$this->tenant_db) {
            return 0;
        }
        
        $this->tenant_db->join('sys_user_type','sys_user_type.ut_id = user.ut_id','left');
        $this->tenant_db->select("user.*,sys_user_type.ut_name");
        $this->tenant_db->where('user.email', $_POST['un']);
        $this->tenant_db->where('user.status !=','del');
        $this->tenant_db->where('user.owner',1);
        $this->tenant_db->where('sys_user_type.status','active');
        
        // Check password with both plain and hashed support
        $user_check = $this->tenant_db->get('user')->row();
        
        if ($user_check) {
            $password_valid = false;
            
            // Check if password is hashed
            if (strpos($user_check->password, '$2y$') === 0) {
                if (password_verify($_POST['pw'], $user_check->password)) {
                    $password_valid = true;
                }
            } else {
                if ($_POST['pw'] == $user_check->password) {
                    $password_valid = true;
                    // Auto-upgrade to hashed
                    $this->tenant_db->where('user_id', $user_check->user_id);
                    $this->tenant_db->update('user', [
                        'password' => password_hash($_POST['pw'], PASSWORD_DEFAULT)
                    ]);
                }
            }
            
            if (!$password_valid) {
                return 0;
            }
            
            return [
                'status'  => 1,
                'user_id' => $user_check->user_id * 8,
                'name'    => $user_check->full_name,
                'email'   => $user_check->email,
                'password'=> $user_check->password,
            ];
        } else {
            return 0;
        }
    }

    public function logout(){ 
        $this->session->sess_destroy();
        
        //for activity log entry
        $user_id_fk = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('ut_id');
        $this->Activity_log_m->addLog($user_id_fk,$user_type,'Login Module','Logout','Logout');
        //end of activity log
        
        return 1;
        echo json_encode(array('status' => 1));
    }
    
    public function change_passwd(){
        // Initialize tenant_db from session
        $this->_init_tenant_db();
        
        if (!$this->tenant_db) {
            echo json_encode(["status" => "error","message" => "Database connection failed"]);
            exit;
        }
        
        $cur_pass = $_POST['cur_pass']; 
        $username = $_POST['user_name'];
        $new_password = $_POST['confirm_password'];
        
        // Use tenant_db for user lookup
        $this->tenant_db->where('email',$username);
        $res = $this->tenant_db->get('user')->row();

        if(!$res){
            echo json_encode(["status" => "error","message" => "The username or password is incorrect."]);
            exit;
        } else {
            // Check current password (supports both plain and hashed)
            $password_valid = false;
            
            if (strpos($res->password, '$2y$') === 0) {
                if (password_verify($cur_pass, $res->password)) {
                    $password_valid = true;
                }
            } else {
                if ($cur_pass == $res->password) {
                    $password_valid = true;
                }
            }
            
            if (!$password_valid) {
                echo json_encode(["status" => "error","message" => "The username or password is incorrect."]);
                exit;
            }
            
            // Hash new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $data = ['password' => $hashed_password];
            $this->tenant_db->where('email', $username);
            $res = $this->tenant_db->update('user', $data);
            
            if($res){
                echo json_encode(["status" => "success","message" => "Password updated successfully"]);
            } else {
                echo json_encode(["status" => "error","message" => "Password updated Failed"]);
            }
        }
    }
}