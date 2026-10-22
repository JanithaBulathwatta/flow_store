<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Controller {

	private static $instance;

	public $load;

	public function __construct()
	{
		self::$instance =& $this;

		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
		$this->_init_tenant_db();
		
		if(isset($_SESSION["country"])) 
			$this->dbv2 = $this->load->database('default', TRUE); 
	}

	// --------------------------------------------------------------------

	public static function &get_instance()
	{
		return self::$instance;
	}
	
	// added by madhushika 2026/06/21
	private function _init_tenant_db() {
		// Check if session is active
		if (session_status() !== PHP_SESSION_ACTIVE) {
			return;
		}
		
		// Check if user is logged in and tenant exists
		if (!isset($_SESSION['login']) || !$_SESSION['login']) {
			return;
		}
		
		if (!isset($_SESSION['tenant_id']) || !isset($_SESSION['tenant_database'])) {
			return;
		}
		
		// Check if we're on a public page (skip tenant switching)
		$nm = strtolower($this->uri->segment(1));
		$public_pages = ['login', 'auth', 'api', 'test1', 'baseapicontroller', 'sms_queue', 'security_settings'];
		if (in_array($nm, $public_pages)) {
			return;
		}
		
		// Get tenant database config from session
		$tenant_database = $_SESSION['tenant_database'];
		$tenant_db_host = isset($_SESSION['tenant_db_host']) ? $_SESSION['tenant_db_host'] : '127.0.0.1';
		$tenant_db_username = isset($_SESSION['tenant_db_username']) ? $_SESSION['tenant_db_username'] : 'dev_erp';
		$tenant_db_password = isset($_SESSION['tenant_db_password']) ? $_SESSION['tenant_db_password'] : 'Dev@p00471Ct';
		
		// Build tenant database config
		$tenant_db_config = array(
			'dsn'       => '',
			'hostname'  => $tenant_db_host,
			'username'  => $tenant_db_username,
			'password'  => $tenant_db_password,
			'database'  => $tenant_database,
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
		
		// Load tenant database
		$tenant_db = $this->load->database($tenant_db_config, TRUE);
		if ($tenant_db) {
			// Override the default database connection
			$this->db = $tenant_db;
			$this->config->set_item('database', $tenant_db_config);
			
			//  CRITICAL: Update all autoloaded models 
			foreach (get_object_vars($this) as $property => $object) {
				if (is_object($object) && property_exists($object, 'db')) {
					$object->db = $tenant_db;
				}
			}
		}
	}
	//desh(2023-10-20)
	//edited by Nadun - permissions 2024-01-11
	public function _remap($m){
		
		$nm = strtolower($this->uri->segment(1));

		
		if($this->session->userdata('login') == true){
			
			//dk 2024-09-11  // check multiple login from same browser
				$this->load->helper('cookie');
				$session_uid = $this->session->userdata('uid');
				$cookie_uid = ($this->input->cookie('cuser_id', TRUE))/8;
				
				// echo("s100");
				// echo $session_uid; echo $cookie_uid;
				// exit();
				// if ($session_uid != $cookie_uid) {
					//die("uav 30");
					// $this->load->model('Login_m');
					// $re = $this->Login_m->logout();
					// $this->load->view('user/uav');
					// exit;
				// }
			
			
			if(empty($this->uri->uri_string())){
				$filteredPermissions = array_values(array_filter($_SESSION['permissions'][0]->sub_permissions, function ($subPermission) {
					return $subPermission->skip_menu == 0;
				}));
				$def_url = (empty($_SESSION["def_url"]) ? $filteredPermissions[0]->ps_url : $_SESSION["def_url"]);
				header('Location: '.$def_url);
			}else if($nm == 'login' || $nm == 'common' || $nm=="Test1" || $nm=='test1' || $nm=="BaseApiController" || $nm == 'sms_queue' || $nm == 'security_settings'){
				$this->$m();
			}else{
				$curr_url = "/".$this->uri->uri_string();
				$permission = $this->Autoload_m->search_permission_array($curr_url);
				$ref_url = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'])['path'] : "no";
				$hiddenPermission = false;
				if($ref_url != "no"){					
					$hiddenPermission = $this->Autoload_m->search_permission_array($ref_url);
					$refSegments = explode('/', trim($ref_url, '/'));
					$refFirstSegment = $refSegments[0];
				}
				if($permission){
					$this->$m();
				}else{
					if($hiddenPermission){
						if($refFirstSegment == $this->uri->segment(1)){
							$this->$m();
						}else{
							die("unauthorized");
						}
					}else{						
						die("unauthorized");
					}
				}
			}
		}elseif($m == "auth"){
			$tx['a']="";
			$this->load->helper('url');
		 
			$this->load->model('Login_m');
			$resp = $this->Login_m->auth();
			$ut_id = $this->session->userdata('ut_id');
			if( $resp == "1" ){
				redirect('/Dash');
			}else{
				$this->load->view('login',$tx);
			}		
		}elseif($nm=="Login" || $nm=='login' || $nm=="Api" || $nm=='api' || $nm=="Test1" || $nm=='test1' || $nm=="BaseApiController" || $nm == 'sms_queue' || $nm == 'security_settings'){
				$this->$m(); 
		}else{ 
			$tx['a']="";
			$this->load->view('login',$tx);
		}
	}

}