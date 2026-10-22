<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_model extends CI_Model {

    protected $table = 'banks';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all active banks for dropdown
     */
    public function get_active_banks() 
    {
        $this->db->select('bank_id, bank_name, bank_code');
        $this->db->from($this->table);
        $this->db->where('status', 'active');
        $this->db->order_by('bank_name', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		//$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Bank Module','BANK','READ');
		
    }
}