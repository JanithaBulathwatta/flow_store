<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_m extends CI_Model {

	private $table = "settings";

	//desh(2024-01-22)
    public function getAllSystemInfo(){
        $db = get_tenant_db();
        
        if (!$db) {
            log_message('error', 'Tenant DB not available in Settings_m::getAllSystemInfo');
            return null;
        }
        
        $re = $db->where('status','active')->get('sys_info')->row();
        return $re;
    }
	
	//desh(2024-01-22)
    public function getAllSystemSettings() {
		$db = get_tenant_db();
		
		if (!$db) {
			log_message('error', 'Tenant DB not available in Settings_m::getAllSystemSettings');
			return [];
		}
		
		$ut_id = $this->session->userdata('ut_id');

		$result = $db
			->select('sys_settings.set_id, set_name, COALESCE(set_value, set_default) as set_value')
			->from('sys_settings')
			->join('sys_settings_user', '
				sys_settings_user.set_id = sys_settings.set_id AND 
				sys_settings_user.status = "active" AND 
				sys_settings_user.ut_id = '. $ut_id, 'left')
			->where('sys_settings.status', 'active')
			->get()
			->result();

		$returnArr = array_column($result, 'set_value', 'set_name');

		return $returnArr;
	}

	public function get_vat_rate(){
		$db = get_tenant_db();
		
		if (!$db) {
			return [];
		}
		
		$db->select('vat_rate');
		$res = $db->get('settings')->result();
		return $res;
	}
	
	public function get_nbt_rate(){
		$db = get_tenant_db();
		
		if (!$db) {
			return [];
		}
		
		$db->select('nbt_rate');
		$res = $db->get('settings')->result();
		return $res;
	}
	
    public function insert_settings($data) {
        $db = get_tenant_db();
        
        if (!$db) {
            return false;
        }
        
        $db->insert($this->table, $data);
        return $db->insert_id();
    }

    public function update_settings($id, $data) {
        $db = get_tenant_db();
        
        if (!$db) {
            return false;
        }
        
        $db->where('id', $id);
        return $db->update($this->table, $data);
    }

    public function get_last_settings() {
        $db = get_tenant_db();
        
        if (!$db) {
            return null;
        }
        
        return $db
            ->order_by('id','DESC')
            ->limit(1)
            ->get($this->table)
            ->row();
    }
	
	public function get_config_json() {
		$db = get_tenant_db();
		
		if (!$db) {
			return [];
		}
		
		$query = $db->get('sys_config');
		$rows = $query->result_array();

		foreach ($rows as &$row) {
			// Assign group details based on config name
			switch ($row['sc_name']) {
				case 'sd_sms':
				case 'sms_key':
				case 'sms_sender':
					$row['group'] = 'SMS';
					$row['group_icon'] = 'fa-message';
					$row['group_color'] = '#0ea5e9';
					break;

				case 'return_mode':
				case 'inv_alert_qty':
				case 'credit_mode':
					$row['group'] = 'Operations';
					$row['group_icon'] = 'fa-rotate-left';
					$row['group_color'] = '#8b5cf6';
					break;

				case 'Pack_mod':
				case 'dispatch_mode':
					$row['group'] = 'Dispatch';
					$row['group_icon'] = 'fa-box-open';
					$row['group_color'] = '#f59e0b';
					break;

				case 'tax_rate':
				case 'currency':
				case 'rounding':
					$row['group'] = 'Finance';
					$row['group_icon'] = 'fa-landmark';
					$row['group_color'] = '#10b981';
					break;

				case 'session_ttl':
				case 'otp_exp':
				case 'login_attempts':
					$row['group'] = 'Security';
					$row['group_icon'] = 'fa-shield-halved';
					$row['group_color'] = '#ef4444';
					break;

				default:
					$row['group'] = 'General';
					$row['group_icon'] = 'fa-gear';
					$row['group_color'] = '#6b7280';
			}
		}

		return $rows;
	}
	
	public function save_configs($changes) {
		$db = get_tenant_db();
		
		if (!$db) {
			return false;
		}
		
		$db->trans_begin();

		foreach($changes as $sc_id => $config) {
			$db->where('sc_id', $sc_id);
			$db->update('sys_config', [
				'sc_value' => $config['current']
			]);
		}

		if($db->trans_status() === FALSE) {
			$db->trans_rollback();
			return false;
		}

		$db->trans_commit();
		return true;
	}
	
	/**
	 * Get a specific system config value
	 */
	public function get_sys_config($key, $default = null) {
		$db = get_tenant_db();
		
		if (!$db) {
			return $default;
		}
		
		$db->where('sc_name', $key);
		$db->where('sc_stt', 'act');
		$result = $db->get('sys_config')->row();
		
		return $result ? $result->sc_value : $default;
	}
	
	/**
	 * Get all system configs as key-value array
	 */
	public function get_all_sys_configs() {
		$db = get_tenant_db();
		
		if (!$db) {
			return [];
		}
		
		$db->where('sc_stt', 'act');
		$results = $db->get('sys_config')->result();
		
		$configs = [];
		foreach ($results as $row) {
			$configs[$row->sc_name] = $row->sc_value;
		}
		
		return $configs;
	}
}