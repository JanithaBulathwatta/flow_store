<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_m extends CI_Model {



    public function __construct() {
        parent::__construct();
    }


	// get all active user types from the sys_user_type table 
	public function get_user_types(){
		return $this->db
			->select('ut_id as id, ut_name as name, ut_type as type')
			->where('status', 'active') 
			->order_by('ut_name', 'ASC')
			->get('sys_user_type')
			->result();
	}

}