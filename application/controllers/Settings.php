<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
		// --- Add this block for queue methods ---
    $allowed_methods = ['process_sms_queue', 'process_email_queue'];
    $current_method = $this->router->fetch_method();
    
    if (in_array($current_method, $allowed_methods)) {
        // Do not run authentication for these specific methods
        return;
    }
        $this->load->model('Permission_model');
        $this->load->model('Settings_m');
		$this->load->model('Message_queue_model');
    }
	
	public function index()
	{	
		$this->load->view('header');
		$this->load->view('settings/system_permissions');
		$this->load->view('footer');
	}
	
	
	public function sys_user_permissions(){
		$this->load->view('header');
		$this->load->view('settings/system_permissions');
		$this->load->view('footer');
	}
	
	/*public function getPermissionData()
	{

		$user_types = $this->db
			->where('status','active')
			->get('sys_user_type')
			->result();

		$main_modules = $this->db
			->where('status','active')
			->order_by('pm_order')
			->get('sys_permission_main')
			->result();

		$sub_modules = $this->db
			->where('status','active')
			->order_by('ps_order')
			->get('sys_permission_sub')
			->result();

		$modules = [];

		foreach($main_modules as $m){

			$modules[$m->pm_id] = [
				"pm_id"=>$m->pm_id,
				"name"=>$m->pm_name,
				"subs"=>[]
			];

		}

		foreach($sub_modules as $s){

			if(isset($modules[$s->pm_id])){
				$modules[$s->pm_id]['subs'][] = $s;
			}

		}

		$permissions = [];

		foreach($user_types as $ut){

			$this->db->select('pm_id');
			$this->db->where('ut_id',$ut->ut_id);
			$this->db->where('status','active');

			$main = $this->db->get('sys_permission_user_main')->result();

			foreach($main as $m){
				$permissions[$ut->ut_id]['main'][] = $m->pm_id;
			}

			$this->db->select('pm_id,ps_id');
			$this->db->where('ut_id',$ut->ut_id);
			$this->db->where('status','active');

			$subs = $this->db->get('sys_permission_user_sub')->result();

			foreach($subs as $s){
				$permissions[$ut->ut_id]['sub'][$s->pm_id][] = $s->ps_id;
			}

		}

		echo json_encode([
			"user_types"=>$user_types,
			"modules"=>$modules,
			"permissions"=>$permissions
		]);

	}*/
	public function getPermissionData(){

		$this->load->model('Permission_model');
		$user_types = $this->Permission_model->getUserTypes();
		$modules = $this->Permission_model->getModules();

		$permissions = [];

		foreach($user_types as $ut){

			$perms = $this->Permission_model->getUserPermissions($ut->ut_id);

			foreach($perms as $p){

				$permissions[$ut->ut_id][$p->pm_id][] = $p->ps_id;

			}

		}

		echo json_encode(["user_types"=>$user_types,"modules"=>$modules,"permissions"=>$permissions]);

	}

	public function save()
	{
		$ut_id = $this->input->post('ut_id');
		$permissions = $this->input->post('permissions');

		if(empty($ut_id)){
			echo json_encode(['status'=>'error']);
			return;
		}

		$this->load->model('Permission_model');

		/* -------------------------
		   EXISTING PERMISSIONS
		------------------------- */

		$existing = $this->Permission_model->getUserSubPermissions($ut_id);

		$existing_ps = [];

		foreach($existing as $row){
			$existing_ps[] = $row->ps_id;
		}

		$new_ps = [];

		if(!empty($permissions)){
			foreach($permissions as $perm){
				$new_ps[] = $perm['ps_id'];
			}
		}

		/* -------------------------
		   TURN OFF PERMISSIONS
		------------------------- */

		$unchecked = array_diff($existing_ps, $new_ps);

		foreach($unchecked as $ps_id){

			$this->Permission_model->updateSubPermission($ut_id,$ps_id,'delete');

		}

		/* -------------------------
		   TURN ON PERMISSIONS
		------------------------- */

		if(!empty($permissions)){

			foreach($permissions as $perm){

				$pm_id = $perm['pm_id'];
				$ps_id = $perm['ps_id'];

				$exists = $this->Permission_model->checkUserSubPermission($ut_id,$ps_id);

				if($exists){

					$this->Permission_model->updateSubPermission($ut_id,$ps_id,'active');

				}else{

					$this->Permission_model->insertSubPermission(['pm_id'=>$pm_id,'ps_id'=>$ps_id,'ut_id'=>$ut_id,'status'=>'active']);

				}

			}

		}

		/* -------------------------
		   UPDATE MAIN MODULE STATUS
		------------------------- */

		$mainModules = $this->Permission_model->getMainModules();

		foreach($mainModules as $m){

			$activeSubs = $this->Permission_model->countActiveSubPermissions($ut_id,$m->pm_id);

			if($activeSubs > 0){

				$this->Permission_model->updateMainPermission($ut_id,$m->pm_id,'active');

			}else{
			
				$this->Permission_model->updateMainPermission($ut_id,$m->pm_id,'delete');

			}

		}

		echo json_encode(['status'=>'success']);
	}
	
	public function company_profile(){
		$this->load->view('header');
		$this->load->view('settings/com_profile');
		$this->load->view('footer');
	}
	
	
	public function get_com_info()
    {
        $data = $this->db->get('sys_info')->row();
        echo json_encode($data);
    }
	
    public function update_company_info()
    {

		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size']      = 5120;

		// Get company name and sanitize it for filename
		$company_name = $this->input->post('com_name');
		$file_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_name);

		$config['file_name'] = $file_name;

		$this->load->library('upload', $config);

		$data = [
			'company_name'       => $this->input->post('com_name'),
			'company_email_1'    => $this->input->post('com_email'),
			'company_contact_1'  => $this->input->post('com_phone'),
			'company_contact_2'  => $this->input->post('com_phone2'),
			'company_web'        => $this->input->post('com_web'),
			'company_addr'       => $this->input->post('com_addr')
		];

		// Only update logo if new image uploaded
		if (!empty($_FILES['com_logo']['name'])) {
			if ($this->upload->do_upload('com_logo')) {
				$upload = $this->upload->data();
				$data['company_logo'] = $upload['file_name'];
			}
		}
		$this->db->update('sys_info', $data);
		echo json_encode(["stt"=>"ok","msg"=>"Company Info Updated Successfully"]);
        
    }
	
	public function getConfigForm()
	{
		$data = $this->db->order_by('s_c_id','ASC')->get('sys_config')->result_array();

		if(!empty($data)){
			echo json_encode(['stt' => 'ok','data' => $data]);
		}else{
			echo json_encode(['stt' => 'error','msg' => 'No configuration found','data' => []]);
		}
	}
	
	public function updateConfig()
	{
		$configs = $this->input->post('config');

		if(!empty($configs)){

			foreach($configs as $id=>$value){

				$data = [
					'feild_value' => $value,
					'is_enable'   => ($value!='') ? 1 : 0
				];

				$this->db->where('s_c_id',$id);
				$this->db->update('sys_config',$data);

			}

			echo json_encode(['stt'=>'ok','msg'=>'Config Settings Updated Successfully']);

		}else{

			echo json_encode(['stt'=>'error','msg'=>'No Data Found']);

		}
	}
	
	public function sys_config(){
		$this->load->view('header');
		$this->load->view('settings/sys_config');
		$this->load->view('footer');
	}
	
	
	public function get_configs()
	{
		$data = $this->Settings_m->get_config_json();

		echo json_encode($data);
	}
	
	public function save_configs()
	{
		$settings = $this->input->post('changes');

		if (empty($settings))
		{
			echo json_encode([
				'status' => 'error',
				'message' => 'No settings received'
			]);
			return;
		}

		$settings = json_decode($settings, true);

		$result = $this->Settings_m->save_configs($settings);

		echo json_encode([
			'status' => $result ? 'success' : 'error'
		]);
	}
	
	
	
	/**
 * Process only SMS queue
 * Call via cron every minute
 */
public function process_sms_queue() {
    set_time_limit(300);
    $limit = $this->input->get('limit') ?? 10;
    $result = $this->Message_queue_model->process_sms_batch($limit);
    
    log_message('info', 'SMS Queue Processed: ' . json_encode($result));
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
}

/**
 * Process only Email queue
 * Call via cron every hour
 */
public function process_email_queue() {
    set_time_limit(300);
    $limit = $this->input->get('limit') ?? 20;
    $result = $this->Message_queue_model->process_email_batch($limit);
    
    log_message('info', 'Email Queue Processed: ' . json_encode($result));
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
}
}