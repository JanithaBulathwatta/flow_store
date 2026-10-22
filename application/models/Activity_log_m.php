<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log_m extends CI_Model {
	
	//desh(2023-09-26)
	public function saveLog($module, $activity, $ref_table, $ref_id){
		$log = array(
			'module' => $module,
			'activity' => $activity,
			'ref_table' => $ref_table,
			'ref_id' => $ref_id,
			'handled_by' => $this->session->userdata('user_id')
		);
		
		$this->db->insert('sys_activity_log', $log);
	}
	
	//desh(2023-09-26)
	public function getAllLog(){
		$re = $this->db->select('*')->where('status', 'active')->get('sys_activity_log')->result();
		return $re;
	}
	
	//desh(2023-09-26)
	public function getLogByUserId($user_id) {
		$this->db->select('al_id, user_id, DATE(c_date) c_date');
		$this->db->select('CONCAT("[", GROUP_CONCAT(
			JSON_OBJECT(
				"module", module,
				"activity", activity,
				"c_time", TIME(c_date)
			) 
			SEPARATOR ","
		), "]") AS activity');
		$this->db->where('status', 'active');
		$this->db->where('user_id', $user_id);
		$this->db->order_by('c_date', 'desc');
		$this->db->group_by('DATE(c_date)');
		$result = $this->db->get('sys_activity_log')->result(); 
		return $result;
	}
	
	
	//function for activity log
	/*public function addLog($user_id_fk, $user_type, $module, $action, $action_type)
    {
        $data = [
            'log_uuid'       => $this->generateUUID(),
            'user_id_fk'     => $user_id_fk,
            'user_type'      => $user_type,
            'module'         => $module,
            'action'         => $action,
            'action_type'    => $action_type,

            // Auto-filled fields
            'session_id'     => session_id(),
            'username'       => $this->session->userdata('username'),
            'user_role'      => $this->session->userdata('role'),
            'ip_address'     => $this->input->ip_address(),
            'user_agent'     => $this->input->user_agent(),
            'created_at'     => date('Y-m-d H:i:s'),
            'status'         => 'SUCCESS'
        ];

        return $this->db->insert('activity_log', $data);
    }*/
	
	
	// updated model function
	public function addLog($user_id_fk, $user_type, $module, $action, $action_type, $is_notification = false, $noti_ref = null, $phone = null, $email = null, $msg = null) {
    
    // 1. Insert into activity_log table using the parameters passed
    $log_data = array(
        'user_id_fk'  => $user_id_fk,
        'user_type'   => $user_type,
        'module'      => $module,
        'action'      => $action,
        'action_type' => $action_type,
        'log_uuid'    => $this->generateUUID(),
        
        // Auto-filled fields
        'session_id'  => session_id(),
        'username'    => $this->session->userdata('username'),
        'user_role'   => $this->session->userdata('role'),
        'ip_address'  => $this->input->ip_address(),
        'user_agent'  => $this->input->user_agent(),
        'created_at'  => date('Y-m-d H:i:s'),
        'status'      => 'SUCCESS'
    );
    $this->db->insert('activity_log', $log_data);

    // 2. Only run notification logic if $is_notification is true and $noti_ref is provided
    if ($is_notification === true && !empty($noti_ref)) {
        
        // Check active notification settings matching the noti_ref
        $this->db->where('noti_ref', $noti_ref);
        $this->db->where('is_active', 1);
        $query = $this->db->get('notification_settings');
        
        if ($query->num_rows() > 0) {
            
            $settings = $query->result();
            
            foreach ($settings as $setting) {
                
                // Determine the recipient endpoints based on target_type
                if ($setting->target_type === 'Fixed') {
                    $final_phone = $setting->target_address;
                    $final_email = $setting->target_email_address;
                } else { 
                    $final_phone = $phone;
                    $final_email = $email;
                }
                
                // Check if SMS format is required and a recipient exists
                if ($setting->sms == 1 && !empty($final_phone)) {
                    $sms_data = array(
                        'event_name' => $action,
                        'module'     => $module,
                        'type'       => 'sms',
                        'to'         => $final_phone,
                        'message'    => $msg,
                        'status'     => 'pending'
                    );
                    $this->db->insert('message_queue', $sms_data);
                }
                
                // Check if Email format is required and a recipient exists
                if ($setting->email == 1 && !empty($final_email)) {
                    $email_data = array(
                        'event_name' => $action,
                        'module'     => $module,
                        'type'       => 'email',
                        'to'         => $final_email,
                        'message'    => $msg,
                        'status'     => 'pending'
                    );
                    $this->db->insert('message_queue', $email_data);
                }
            }
        }
    }
}

    private function generateUUID()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

	//activity log function end
	
	/*use this for other model for pass data to this*/
	//$this->load->model('ActivityLogModel');
	//$this->ActivityLogModel->addLog($user_id_fk,$user_type,'User Module','Login','READ');
	/*end function*/
	

	
}

?>