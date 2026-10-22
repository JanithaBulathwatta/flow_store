<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_m extends CI_Model {

	public function getMenuItems($ut_id){ 
		$db = get_tenant_db();
		
		if (!$db) {
			return [];
		}

		$db->join('sys_permission_main', 'sys_permission_main.pm_id = sys_permission_user_main.pm_id', 'left');
		$re = $db->select('sys_permission_user_main.*, sys_permission_main.pm_name, sys_permission_main.pm_icon, 
			sys_permission_main.pm_url, sys_permission_main.pm_order')
			->where('sys_permission_main.status', 'active')
			->where('sys_permission_user_main.status', 'active')
			->where('sys_permission_user_main.ut_id', $ut_id)
			->order_by('sys_permission_main.pm_order', "ASC")
			->get('sys_permission_user_main')->result();
			
		foreach($re as $k => $v){
			$db->join('sys_permission_sub', 'sys_permission_sub.ps_id = sys_permission_user_sub.ps_id', 'left');
			$sub = $db->where('sys_permission_user_sub.pm_id', $v->pm_id)
				->where('sys_permission_sub.status', 'active')
				->where('sys_permission_user_sub.status', 'active')
				->where('sys_permission_user_sub.ut_id', $ut_id)
				->order_by('sys_permission_sub.ps_order', 'ASC')
				->get('sys_permission_user_sub')->result();
				
			$re[$k]->sub_permissions = $sub;
		}

		return $re;
	}
	
	public function search_permission_array($curr_url) {
		$db = get_tenant_db();
		
		if (!$db) {
			return false;
		}
		
		$db->where('pm_url', $curr_url);
		$db->where('status', 'active');
		$main_menu = $db->get('sys_permission_main')->row();
		
		if ($main_menu) {
			return true;
		}
		
		$db->where('ps_url', $curr_url);
		$db->where('status', 'active');
		$sub_menu = $db->get('sys_permission_sub')->row();
		
		if ($sub_menu) {
			return true;
		}
		
		return false;
	}
}