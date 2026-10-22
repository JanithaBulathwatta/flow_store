<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceManager_model extends CI_Model {

    // Fetch all devices with user details for the JS array
	public function get_all_devices() {
		$this->db->select('d.*, u.full_name as user, t.ut_name as role');
		$this->db->from('user_devices d');
		$this->db->join('user u', 'u.user_id = d.user_id', 'left');
		$this->db->join('sys_user_type t', 't.ut_id = u.ut_id', 'left');
		
		//  Hide deleted devices
		$this->db->where('d.status !=', 'deleted');
		
		$results = $this->db->get()->result();

	   //  Logic for Online/Offline
		foreach ($results as $row) {
			$last_seen = strtotime($row->last_seen);
			$five_minutes_ago = time() - 300; 

			// If the database status is 'blocked', keep it as 'blocked'
			if ($row->status === 'blocked') {
				$row->status = 'blocked'; 
			} else {
				//  Overwrite the status property for the UI
				
				$row->status = ($last_seen > $five_minutes_ago) ? 'online' : 'offline';
			}
		}

		return $results;
	}

    // This function captures the device during login
	public function register_or_update_device($user_id) {
		$this->load->library('user_agent');
		
		$ip = $this->input->ip_address();
		$os = $this->agent->platform();
		$browser = $this->agent->browser() . ' ' . $this->agent->version();
		
		
		$type = 'unknown';
		if ($this->agent->is_mobile()) {
			$type = 'mobile';
		} elseif ($this->agent->is_browser()) {
			$type = 'desktop';
		}

		// Check if record exists
		$this->db->where([
			'user_id' => $user_id, 
			'ip_address' => $ip, 
			'os' => $os
		]);
		$existing = $this->db->get('user_devices')->row();

		$data = [
			'user_id'     => $user_id,
			'device_name' => $os . ' ' . $type,
			'model'       => $os . ' Device',
			'device_type' => $type,
			'os'          => $os,
			'browser'     => $browser,
			'ip_address'  => $ip,
			'last_seen'   => date('Y-m-d H:i:s'),
			'status'      => 'active'
		];

		if ($existing) {
			if($existing->status === 'blocked') {
				return 'blocked'; 
			}
			$this->db->where('id', $existing->id)->update('user_devices', $data);
		} else {
			$data['is_active'] = 1;
			$this->db->insert('user_devices', $data);
		}
		return 'allowed';
	}

    public function update_status($id, $data) {
        $this->db->where('id', $id)->update('user_devices', $data);
    }
}