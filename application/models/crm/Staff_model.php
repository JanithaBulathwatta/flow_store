<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'traits/BranchTrait.php';

class Staff_model extends CI_Model {
	use BranchTrait;

    protected $table = 'staff_info';
    //protected $table = 'user';

    public function __construct() {
        parent::__construct();
    }
	
	public function exists($lead_id)
{
    $this->filterByBranch();
        return $this->db
            ->where('staff_id', (int)$lead_id)
            ->count_all_results($this->table) > 0;
    }
	
	public function get_staff(){
    $this->filterByBranch();
		$this->db->where('status','active');
		$res = $this->db->get('staff_info')->result();
		return $res;
	}
	
	/*public function get_all()
	{

		return $this->db
			->select('si.*, b.bank_name')
			->from('staff_info si')
			// Joining with the banks table to get the name
			->join('banks b', 'b.bank_id = si.bank_id', 'left')
			
			// Filters out deleted records to keep the list clean
			->where_in('si.status', array('active', 'inactive')) 
			
			// Latest staff members appear at the top
			->order_by('si.staff_id', 'DESC')
			->get()
			->result();
	}*/
	
	public function get_all($status = 'all')
{
    $this->filterByBranch();
		$this->db
			->select('si.*, b.bank_name')
			->from('staff_info si')
			->join('banks b', 'b.bank_id = si.bank_id', 'left');

		if ($status != 'all') {
			$this->db->where('si.status', $status);
		} else {
			$this->db->where_in('si.status', ['active','inactive']);
		}

		return $this->db
			->order_by('si.staff_id', 'DESC')
			->get()
			->result();
	}
	
	public function create()
	{
    $this->load->library('form_validation');

    $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]');
    $this->form_validation->set_rules('calling_name', 'Calling Name', 'required|trim');
    $this->form_validation->set_rules('phone1', 'Contact Number', 'required|regex_match[/^0[1-9][0-9]{8}$/]');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('ut_id', 'Designation', 'required');
    $this->form_validation->set_rules('branch_id', 'Branch', 'required');
	
    $this->form_validation->set_rules('bank_id', 'Bank name ', 'required');
    $this->form_validation->set_rules('bank_branch', 'Bank Branch', 'required');
    $this->form_validation->set_rules('account_number', 'Account Number', 'required');
   
    if ($this->form_validation->run() == FALSE) {
        echo json_encode(['stt' => 'error', 'msg' => validation_errors(), 'data' => '']);
        return;
    }
    
    // Handle profile photo upload
    $profile_photo_path = NULL;
    if (!empty($_FILES['profile_photo']['name'])) {
        $config['upload_path'] = './uploads/staff_photos/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['max_size'] = 2048;
        $config['file_name'] = 'staff_' . time() . '_' . rand(1000, 9999);
        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('profile_photo')) {
            $upload_data = $this->upload->data();
            $profile_photo_path = 'uploads/staff_photos/' . $upload_data['file_name'];
        }
    }
    
    // Generate staff number
    $year = date('Y');
    $this->db->like('staff_no', 'STF-' . $year . '-', 'after');
    $this->db->order_by('staff_id', 'DESC');
    $this->db->limit(1);
    $last = $this->db->get('staff_info')->row();
    
    if ($last && $last->staff_no) {
        preg_match('/STF-\d{4}-(\d{4})/', $last->staff_no, $matches);
        $count = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
    } else {
        $count = 1;
    }
    
    $staff_no = 'STF-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    
    while($this->db->where('staff_no', $staff_no)->get('staff_info')->num_rows() > 0) {
        $count++;
        $staff_no = 'STF-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

   // Before inserting/updating, prepare the data array
	$data = [
		'staff_no' => $staff_no,
		'full_name' => $this->input->post('full_name'),
		'calling_name' => $this->input->post('calling_name'),
		'gender' => $this->input->post('gender'),
		'dob' => $this->input->post('dob'),
		'nic_passport' => $this->input->post('nic_passport'),
		'blood_group' => $this->input->post('blood_group'),
		'email' => $this->input->post('email'),
		'phone' => $this->input->post('phone'),
		'phone2' => $this->input->post('phone2'),
		'emergency_contact' => $this->input->post('emergency_contact'),
		'address' => $this->input->post('address'),
		'branch_location' => $this->input->post('branch_location'),
		'joining_date' => $this->input->post('joining_date'),
		'reporting_to' => $this->input->post('reporting_to'),
		'employee_type' => $this->input->post('employee_type'),
		'basic_salary' => $this->input->post('basic_salary'),
		'epf_no' => $this->input->post('epf_no'),
		'epf_enabled' => $this->input->post('epf_enabled') ?: 0,
		'epf_employee_pct' => $this->input->post('epf_employee_pct'),
		'epf_employer_pct' => $this->input->post('epf_employer_pct'),
		'etf_employer_pct' => $this->input->post('etf_employer_pct'),
		'internal_notes' => $this->input->post('internal_notes'),
		'profile_photo' => $profile_photo_path,
		'status' => $this->input->post('status'),
		'designation' => $this->input->post('designation'),
		'ut_id' => $this->input->post('ut_id')
	];
	
	// ADD BRANCH ID - get from form input
	$branch_id = $this->input->post('branch_id');
	if ($branch_id) {
		$data['branch_id'] = $branch_id;
	} else {
		// Fallback to session branch_id
		$data = $this->addBranch($data);
	}

// Only add bank fields if bank_id is provided and not empty
$bank_id = $this->input->post('bank_id');
if (!empty($bank_id)) {
    $data['bank_id'] = $bank_id;
    $data['account_no'] = $this->input->post('account_no');
    $data['account_name'] = $this->input->post('account_name');
    $data['bank_branch'] = $this->input->post('bank_branch');
} else {
    // Set to NULL instead of empty string
    $data['bank_id'] = NULL;
    $data['account_no'] = NULL;
    $data['account_name'] = NULL;
    $data['bank_branch'] = NULL;
}

    $this->db->insert('staff_info', $data);
    $insert_id = $this->db->insert_id();

    // Initialize variables
    $user_created = false;
    $sms_result = null;
    $sms_error = null;
    $phone = null;
    $password = null;

    if ($insert_id) {
        
        // Insert allowances
        $allowances = json_decode($this->input->post('allowances', TRUE), true);
        if (!empty($allowances)) {
            foreach ($allowances as $item) {
                if (!empty($item['name']) && $item['amount'] > 0) {
                    $this->db->insert('staff_allowances', [
                        'staff_id' => $insert_id,
                        'allowance_name' => $item['name'],
                        'amount' => $item['amount']
                    ]);
                }
            }
        }
        
        // Insert deductions
        $deductions = json_decode($this->input->post('deductions', TRUE), true);
        if (!empty($deductions)) {
            foreach ($deductions as $item) {
                if (!empty($item['name']) && $item['amount'] > 0) {
                    $this->db->insert('staff_deductions', [
                        'staff_id' => $insert_id,
                        'deduction_name' => $item['name'],
                        'amount' => $item['amount']
                    ]);
                }
            }
        }
		 // Create bank account using existing model
        $bank_id = $this->input->post('bank_id');
        if (!empty($bank_id) && !empty($this->input->post('account_number'))) {
            $this->load->model('BankAccount_model');
            
            // Temporarily store POST data to restore after
            $temp_post = $_POST;
            
            // Set POST data for BankAccount_model
            $_POST = [
                'bank_id' => $bank_id,
                'branch_name' => $this->input->post('bank_branch', TRUE),
                'account_name' => $this->input->post('account_holder', TRUE),
                'account_number' => $this->input->post('account_number', TRUE),
                'account_nickname' => 'Staff - ' . $this->input->post('full_name', TRUE),
                'account_type' => 'savings',
                'opening_balance' => 0,
                'od_limit' => 0
            ];
            
            // Capture output to prevent JSON interference
            ob_start();
            $this->BankAccount_model->create();
            ob_end_clean();
            
            // Restore original POST data
            $_POST = $temp_post;
        }
        
        // Check if user account should be created
        $create_account = $this->input->post('create_account');
        
        if ($create_account == '1' || $create_account == 'true' || $create_account === true) {
            $ut_id = $this->input->post('ut_id');
            $full_name = $this->input->post('full_name');
            $phone = preg_replace('/\D/', '', $this->input->post('phone1'));

		// Convert to international format
		if (preg_match('/^0[0-9]{9}$/', $phone)) {
			$phone = '94' . substr($phone, 1);
		}
            $email = $this->input->post('email');
            $password = $this->input->post('generated_password');
            $account_locked = $this->input->post('account_locked');
            $branch_id = $this->input->post('branch_id');
			
            if (empty($password)) {
                $password = substr(md5(time() . rand(1000, 9999)), 0, 10);
            }
            
            $status = ($account_locked == '1' || $account_locked == 'true') ? 'lock' : 'act';
            
            // Insert user
            $user_data = [
                'ut_id' => $ut_id,
                'full_name' => $full_name,
                'phone' => $phone,
                'branch_id' => $branch_id,
                'staff_id' => $insert_id,
                'email' => $email,
                'address' => NULL,
                'password' => $password,
                'status' => $status,
                'short_name' => substr($full_name, 0, 20),
                'com_id' => 1,
                'owner' => 0
            ];
			
            $this->db->insert('user', $user_data);
            $user_id = $this->db->insert_id();
            
            if ($user_id) {
    $user_created = true;
    
    // Use CI instance to load library (better for models)
    $CI =& get_instance();
    $CI->load->library('SmsSender');
    
    $message = "Welcome! ERP Login - Username: {$email} Password: {$password}";
    
    // Send SMS - exact same as Login controller
    $sms_result = $CI->smssender->send_sms_with_mobi('8989898989', $phone, $message);
    
    // Also write to file for debugging
    file_put_contents('./sms_model_debug.txt', 
        date('Y-m-d H:i:s') . 
        "\nPhone: {$phone}" .
        "\nResult: " . json_encode($sms_result) . 
        "\n---\n", 
        FILE_APPEND
    );
}
        }

        echo json_encode([
            "stt" => "ok", 
            "msg" => "Staff Created Successfully!", 
            "data" => [
                'staff_id' => $insert_id,
                'staff_no' => $staff_no,
                'insert_id' => $insert_id,
                'user_created' => $user_created,
                'sms_result' => $sms_result,
                'sms_error' => $sms_error,
                'phone_used' => $phone,
                'password_used' => $password
            ]
        ]);
    } else {
        echo json_encode(["stt" => "error", "msg" => "Something Went Wrong!", "data" => '']);
    }
	
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Staff Module','Create Staff','INSERT');
		//end of activity log
	
}
	
public function update()
{
    $id = $_POST['lid'];
    
    if (!$this->verifyBranch($this->table, $id, 'staff_id')) {
        echo json_encode(["stt"=>"error", "msg"=>"Unauthorized: Staff not in your branch", "data"=>'']);
        return;
    }
    
    // Handle profile photo upload
    $profile_photo_path = NULL;
    if (!empty($_FILES['profile_photo']['name'])) {
        $config['upload_path'] = './uploads/staff_photos/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['max_size'] = 2048;
        $config['file_name'] = 'staff_' . time() . '_' . rand(1000, 9999);
        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('profile_photo')) {
            $upload_data = $this->upload->data();
            $profile_photo_path = 'uploads/staff_photos/' . $upload_data['file_name'];
        }
    }
    
    $data = [
        'full_name' => $this->input->post('full_name', TRUE),
        'calling_name' => $this->input->post('calling_name', TRUE),
        'gender' => $this->input->post('gender', TRUE),
        'dob' => $this->input->post('dob', TRUE) ?: NULL,
        'nic_passport' => $this->input->post('nic', TRUE),
        'blood_group' => $this->input->post('blood_group', TRUE),
        'email' => $this->input->post('email', TRUE),
        'phone' => $this->input->post('phone1', TRUE),
        'phone2' => $this->input->post('phone2', TRUE),
        'emergency_contact' => $this->input->post('emergency_contact', TRUE),
        'address' => $this->input->post('address', TRUE),
        'branch_location' => $this->input->post('branch', TRUE),
        'joining_date' => $this->input->post('joining_date', TRUE),
        'employee_type' => $this->input->post('emp_type', TRUE),
        'bank_id' => $this->input->post('bank_id', TRUE),
        'account_no' => $this->input->post('account_number', TRUE),
        'account_name' => $this->input->post('account_holder', TRUE),
        'bank_branch' => $this->input->post('bank_branch', TRUE),
        'basic_salary' => $this->input->post('basic_salary', TRUE) ?: 0,
        'epf_enabled' => $this->input->post('epf_enabled', TRUE) ?: 0,
        'epf_employee_pct' => $this->input->post('epf_employee_pct', TRUE) ?: 8.00,
        'epf_employer_pct' => $this->input->post('epf_employer_pct', TRUE) ?: 12.00,
        'etf_employer_pct' => $this->input->post('etf_employer_pct', TRUE) ?: 3.00,
        'internal_notes' => $this->input->post('internal_notes', TRUE),
        'status' => $this->input->post('status', TRUE) ?: 'active',
        'designation' => $this->input->post('designation_text', TRUE) ?: $this->input->post('designation', TRUE),
        'ut_id' => $this->input->post('ut_id', TRUE) ?: NULL,
    ];
    
    if ($profile_photo_path) {
        $data['profile_photo'] = $profile_photo_path;
    }
    
    $this->db->where('staff_id', (int)$id)->update($this->table, $data);
    
    // Update allowances (delete and re-insert)
    $this->db->where('staff_id', $id)->delete('staff_allowances');
    $allowances = json_decode($this->input->post('allowances', TRUE), true);
    if (!empty($allowances)) {
        foreach ($allowances as $item) {
            if (!empty($item['name']) && $item['amount'] > 0) {
                $this->db->insert('staff_allowances', [
                    'staff_id' => $id,
                    'allowance_name' => $item['name'],
                    'amount' => $item['amount']
                ]);
            }
        }
    }
    
    // Update deductions
    $this->db->where('staff_id', $id)->delete('staff_deductions');
    $deductions = json_decode($this->input->post('deductions', TRUE), true);
    if (!empty($deductions)) {
        foreach ($deductions as $item) {
            if (!empty($item['name']) && $item['amount'] > 0) {
                $this->db->insert('staff_deductions', [
                    'staff_id' => $id,
                    'deduction_name' => $item['name'],
                    'amount' => $item['amount']
                ]);
            }
        }
    }
    
    echo json_encode(["stt"=>"ok", "msg"=>"Staff Updated Successfully!", "data"=>$id]);
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'Staff Module','Update Staff','UPDATE');
	//end of activity log
}

	public function get_by_id($id)
{
    $this->filterByBranch(); 
		return $this->db
			->select('
				s.*, 
				b.bank_name,
				b.bank_code
			')
			->from('staff_info s')
			
			->join('banks b', 'b.bank_id = s.bank_id', 'left')
			
			->where('s.staff_id', (int)$id) 
			->get()
			->row(); 
	}
	
	public function delete($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}
		
		// Verify staff belongs to current branch - PASS 'staff_id' as third parameter
    if (!$this->verifyBranch($this->table, $id, 'staff_id')) {
        echo json_encode(['stt' => 'error','msg' => 'Unauthorized: Staff not in your branch','data' => '']);
        return;
    }

		$this->db->where('staff_id', $id);
		$update = $this->db->update('staff_info',['status' => 'delete']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Staff Deleted Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Staff Module','Delete Staff','DELETE');
		//end of activity log
	}
	
	 /**
     * Get staff counts by status
     */
    /*public function get_counts() 
    {
        $query = $this->db->query("
            SELECT 
                COUNT(CASE WHEN status = 'active' THEN 1 END) as active_count,
                COUNT(CASE WHEN status = 'inactive' THEN 1 END) as inactive_count,
                COUNT(CASE WHEN status = 'delete' THEN 1 END) as deleted_count,
                COUNT(*) as total_count
            FROM {$this->table}
        ");
        return $query->row();
    }*/
	
	 /**
     * Get staff counts by status
     */
	public function get_counts() {
		$branch_id = $this->getCurrentBranchId();
		$data = [];
		
		$this->db->where('branch_id', $branch_id);
		$data['all_count'] = $this->db->count_all_results($this->table);
		
		$this->db->where(['branch_id' => $branch_id, 'status' => 'active']);
		$data['active_count'] = $this->db->count_all_results($this->table);
		
		$this->db->where(['branch_id' => $branch_id, 'status' => 'inactive']);
		$data['inactive_count'] = $this->db->count_all_results($this->table);
		
		$this->db->where(['branch_id' => $branch_id, 'status' => 'delete']);
		$data['deleted_count'] = $this->db->count_all_results($this->table);
		
		return (object) $data;
	}
	
	// /**
 // * Create user account for staff member
 // */
// /**
 // * Create user account for staff member
 // */
// private function create_user_account($staff_no, $full_name, $phone, $email, $ut_id, $password, $status)
// {
    // // Check if user already exists
    // $exists = $this->db->where('phone', $phone)->or_where('email', $email)->get('user')->num_rows();
    // if ($exists > 0) {
        // return ['success' => false, 'message' => 'User already exists'];
    // }
    
    // $user_data = [
        // 'ut_id' => $ut_id,
        // 'full_name' => $full_name,
        // 'phone' => $phone,
        // 'email' => $email,
        // 'address' => NULL,
        // 'password' => md5($password),
        // 'status' => $status,
        // 'short_name' => substr($full_name, 0, 20),
        // 'com_id' => 1,
        // 'owner' => 0
    // ];
    
    // $this->db->insert('user', $user_data);
    // $user_id = $this->db->insert_id();
    
    // if ($user_id) {
        // // Send SMS with credentials
        // $this->send_sms_credentials($phone, $phone, $password);
        // return ['success' => true, 'user_id' => $user_id];
    // }
    
    // return ['success' => false, 'message' => 'Failed to create user'];
// }

// private function send_sms_credentials($phone, $username, $password)
// {
    // // Message format
    // $message = "Welcome! Your ERP Login:\nUsername: {$username}\nPassword: {$password}\nLogin at: " . base_url();
    
    // // Use the same SMS library and sender ID from your login controller
    // // '8989898989' is the sender ID used in your forgot password function
    // $sender_id = '8989898989';
    
    // // Load the SMS library (same as in Login controller)
    // $this->load->library('SmsSender');
    
    // // Send SMS
    // $result = $this->smssender->send_sms_with_mobi($sender_id, $phone, $message);
    
    // // Optional: Log the SMS sending result
    // // log_message('info', 'SMS sent to ' . $phone . ' - Result: ' . json_encode($result));
    
    // return $result;
// }
public function get_full_profile($staff_id)
{
    $this->filterByBranch('si');
    $staff = $this->db
        ->select('
            si.*,
            b.bank_name,
            sut.ut_name as designation_name,
            u.status as user_status,
            u.user_id as has_account
        ')
        ->from('staff_info si')
        ->join('banks b', 'b.bank_id = si.bank_id', 'left')
        ->join('sys_user_type sut', 'sut.ut_id = si.ut_id', 'left')
        ->join('user u', 'u.phone = si.phone', 'left')
        ->where('si.staff_id', (int)$staff_id)
        ->get()
        ->row();
    
    if ($staff) {
        // Get allowances
        $staff->allowances = $this->db
            ->where('staff_id', $staff_id)
            ->get('staff_allowances')
            ->result();
        
        // Get deductions
        $staff->deductions = $this->db
            ->where('staff_id', $staff_id)
            ->get('staff_deductions')
            ->result();
			// Get sales summary
        $staff->sales_summary = $this->get_staff_sales_summary($staff_id);
        
        // Get recent sales
        $staff->recent_sales = $this->get_staff_sales($staff_id, 10);
        
        // Get activity log
        $staff->activities = $this->get_staff_activity($staff_id, 15);
        
        // Calculate net salary
        $staff->total_allowances = 0;
        foreach ($staff->allowances as $a) {
            $staff->total_allowances += $a->amount;
        }
        
        $staff->total_deductions = 0;
        foreach ($staff->deductions as $d) {
            $staff->total_deductions += $d->amount;
        }
        
        $staff->epf_employee = $staff->epf_enabled ? ($staff->basic_salary * $staff->epf_employee_pct / 100) : 0;
        $staff->epf_employer = $staff->epf_enabled ? ($staff->basic_salary * $staff->epf_employer_pct / 100) : 0;
        $staff->etf_employer = $staff->epf_enabled ? ($staff->basic_salary * $staff->etf_employer_pct / 100) : 0;
        $staff->net_salary = $staff->basic_salary + $staff->total_allowances - $staff->total_deductions - $staff->epf_employee;
        
        // Calculate age and tenure
        if ($staff->dob) {
            $dob = new DateTime($staff->dob);
            $today = new DateTime();
            $staff->age = $dob->diff($today)->y;
        }
        
        if ($staff->joining_date) {
            $join = new DateTime($staff->joining_date);
            $today = new DateTime();
            $diff = $join->diff($today);
            $staff->tenure = $diff->y . ' yrs ' . $diff->m . ' mos';
        }
    }
    
    return $staff;
}
/**
 * Get sales invoices for a staff member
 */
/**
 * Get sales invoices for a staff member
 */
public function get_staff_sales($staff_id, $limit = 20)
{
    $branch_id = $this->getCurrentBranchId();
    return $this->db
        ->select('
            si.id,
            si.invoice_no,
            si.invoice_date,
            si.total_items,
            si.grand_total,
            si.payment_status,
            si.status,
            c.cus_name as customer_name
        ')
        ->from('sales_invoices si')
        ->join('customer c', 'c.cus_id = si.customer_id', 'left')
         ->where('si.created_by', (int)$staff_id)
        ->where('si.branch_id', $branch_id) 
        ->order_by('si.invoice_date', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get sales summary for a staff member
 */
public function get_staff_sales_summary($staff_id)
{
    $branch_id = $this->getCurrentBranchId();
    // Current month sales
    $this->db
        ->select('COUNT(*) as count, SUM(grand_total) as total')
        ->from('sales_invoices')
        ->where('created_by', (int)$staff_id)
		->where('branch_id', $branch_id)
        ->where('status', 'COMPLETED')
        ->where('MONTH(invoice_date)', date('m'))
        ->where('YEAR(invoice_date)', date('Y'));
    $current_month = $this->db->get()->row();
    
    // Previous month sales
    $this->db
        ->select('SUM(grand_total) as total')
        ->from('sales_invoices')
        ->where('created_by', (int)$staff_id)
		->where('branch_id', $branch_id)
        ->where('status', 'COMPLETED')
        ->where('MONTH(invoice_date)', date('m', strtotime('-1 month')))
        ->where('YEAR(invoice_date)', date('Y', strtotime('-1 month')));
    $prev_month = $this->db->get()->row();
    
    // Total completed invoices
    $this->db
        ->select('COUNT(*) as total_count, SUM(grand_total) as total_revenue')
        ->from('sales_invoices')
        ->where('created_by', (int)$staff_id)
        ->where('status', 'COMPLETED');
    $total = $this->db->get()->row();
    
    // Pending invoices
    $this->db
        ->select('COUNT(*) as count, SUM(grand_total) as total')
        ->from('sales_invoices')
        ->where('created_by', (int)$staff_id)
		->where('branch_id', $branch_id) 
        ->where('payment_status !=', 'PAID')
        ->where('status', 'COMPLETED');
    $pending = $this->db->get()->row();
    
    // Last 7 days sales for chart
    $week_data = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $day_name = date('D', strtotime($date));
        $day_label = date('d M', strtotime($date));
        
        $this->db
            ->select('COUNT(*) as count, COALESCE(SUM(grand_total), 0) as total')
            ->from('sales_invoices')
            ->where('created_by', (int)$staff_id)
			->where('branch_id', $branch_id)
            ->where('DATE(invoice_date)', $date)
            ->where('status', 'COMPLETED');
        $day_data = $this->db->get()->row();
        
        $week_data[] = [
            'day' => $day_name,
            'label' => $day_label,
            'count' => (int)($day_data->count ?? 0),
            'total' => (float)($day_data->total ?? 0)
        ];
    }
    
    return [
        'current_month' => [
            'count' => (int)($current_month->count ?? 0),
            'total' => (float)($current_month->total ?? 0)
        ],
        'prev_month_total' => (float)($prev_month->total ?? 0),
        'total_invoices' => (int)($total->total_count ?? 0),
        'total_revenue' => (float)($total->total_revenue ?? 0),
        'pending' => [
            'count' => (int)($pending->count ?? 0),
            'total' => (float)($pending->total ?? 0)
        ],
        'week_data' => $week_data
    ];
}

/**
 * Get activity log for a staff member
 */
public function get_staff_activity($staff_id, $limit = 20)
{
    // Get staff user info
    $staff = $this->db
        ->select('full_name, phone, email')
        ->where('staff_id', (int)$staff_id)
        ->get('staff_info')
        ->row();
    
    if (!$staff) {
        return [];
    }
    
    // Get activity logs
    return $this->db
        ->select('*')
        ->from('activity_log')
        ->group_start()
            ->where('user_id_fk', (int)$staff_id)
            ->or_where('username', $staff->full_name)
            ->or_where('username', $staff->phone)
            ->or_where('username', $staff->email)
        ->group_end()
        ->order_by('created_at', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Format activity for display
 */
public function format_activity($activity)
{
    $icon_map = [
        'CREATE' => ['icon' => 'fa-plus-circle', 'cls' => 'ad-sale', 'color' => '#10b981'],
        'UPDATE' => ['icon' => 'fa-pen', 'cls' => 'ad-edit', 'color' => '#3d52a0'],
        'DELETE' => ['icon' => 'fa-trash', 'cls' => 'ad-warn', 'color' => '#ef4444'],
        'LOGIN' => ['icon' => 'fa-right-to-bracket', 'cls' => 'ad-login', 'color' => '#0ea5e9'],
        'LOGOUT' => ['icon' => 'fa-right-from-bracket', 'cls' => 'ad-login', 'color' => '#8a94a6'],
        'VIEW' => ['icon' => 'fa-eye', 'cls' => 'ad-print', 'color' => '#14b8a6'],
        'APPROVE' => ['icon' => 'fa-check-circle', 'cls' => 'ad-sale', 'color' => '#10b981'],
        'REJECT' => ['icon' => 'fa-times-circle', 'cls' => 'ad-warn', 'color' => '#ef4444'],
        'PRINT' => ['icon' => 'fa-print', 'cls' => 'ad-print', 'color' => '#8b5cf6'],
        'EXPORT' => ['icon' => 'fa-download', 'cls' => 'ad-print', 'color' => '#f59e0b'],
    ];
    
    $action = $activity->action ?? 'OTHER';
    $config = $icon_map[$action] ?? ['icon' => 'fa-circle', 'cls' => 'ad-login', 'color' => '#8a94a6'];
    
    return [
        'icon' => $config['icon'],
        'cls' => $config['cls'],
        'title' => $activity->module . ' - ' . ($activity->action ?? 'Activity'),
        'description' => $activity->description ?? ($activity->entity_type . ' ' . $activity->action),
        'time' => date('d M Y, h:i A', strtotime($activity->created_at)),
        'badge' => $activity->status ?? null,
        'module' => $activity->module,
        'action_type' => $activity->action_type
    ];
}
public function get_all_with_details()
{
    $this->filterByBranch('si');
    return $this->db
        ->select('
            si.*,
            sut.ut_name as designation_name,
            u.user_id as has_account
        ')
        ->from('staff_info si')
        ->join('sys_user_type sut', 'sut.ut_id = si.ut_id', 'left')
        ->join('user u', 'u.phone = si.phone', 'left')
        ->where_in('si.status', ['active', 'inactive', 'on_leave', 'probation'])
        ->order_by('si.staff_id', 'DESC')
        ->get()
        ->result();
}
}	