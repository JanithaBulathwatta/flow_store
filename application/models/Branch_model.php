<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// supun 2023/3/11
class Branch_model extends CI_Model {

    protected $table = 'branches';

    public function __construct() {
        parent::__construct();
    }

    public function exists($branch_id) {
        return $this->db
            ->where('branch_id', (int)$branch_id)
            ->where('branch_status !=', 'deleted')
            ->count_all_results($this->table) > 0;
    }

    public function get_all_branches($filters = []) {
        $this->db->from($this->table);
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('branch_name', $filters['search']);
            $this->db->or_like('branch_code', $filters['search']);
            $this->db->or_like('branch_city', $filters['search']);
            $this->db->or_like('branch_address_full', $filters['search']);
            $this->db->or_like('branch_phone', $filters['search']);
            $this->db->or_like('branch_email', $filters['search']);
            $this->db->group_end();
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('branch_status', $filters['status']);
        }else {
			$this->db->where_in('branch_status', ['active', 'inactive']);
		}
        
        if (!empty($filters['date'])) {
            $this->db->where('DATE(created_at)', $filters['date']);
        }
        
        $this->db->order_by('branch_id', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }
	
	
	public function get_active_branches(){
		$this->db->from($this->table);
		$this->db->where('branch_status','active');
		$query = $this->db->get();
		return $query->result();
	}

    public function get_counts() {
        $data = [];
		
		
        
        $this->db->where('branch_status', 'active');
        $data['active_count'] = $this->db->count_all_results($this->table);
        
        $this->db->where('branch_status', 'inactive');
        $data['inactive_count'] = $this->db->count_all_results($this->table);
        
        $this->db->where('branch_status', 'deleted');
        $data['deleted_count'] = $this->db->count_all_results($this->table);
        
        return (object) $data;
    }

    public function get_branch($id) {
        return $this->db->get_where($this->table, ['branch_id' => (int)$id])->row();
    }

    public function insert_branch($data) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Branch Module','Create Branch','INSERT');
		//end of activity log
		
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_branch($id, $data) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Branch Module','Update Branch','UPDATE');
		//end of activity log
		
        $this->db->where('branch_id', (int)$id);
        return $this->db->update($this->table, $data);
    }

    public function delete_branch($id) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Branch Module','Delete Branch','DELETE');
		//end of activity log
		
        $id = (int)$id;
        
        if (!$id) { 
            return false;
        } 
        
        $this->db->where('branch_id', $id);
        return $this->db->update($this->table, ['branch_status' => 'deleted']);
    }

    public function update_status($id, $status) {
        $id = (int)$id;
        
        if (!$id || !in_array($status, ['active', 'inactive'])) {
            return false;
        }
        
        $this->db->where('branch_id', $id);
        return $this->db->update($this->table, ['branch_status' => $status]);
    }

    public function code_exists($code, $id = 0) {
        if (empty($code)) {
            return false;
        }
        
        $this->db->where('branch_code', $code);
        $this->db->where('branch_status !=', 'deleted');
        
        if ($id > 0) {
            $this->db->where('branch_id !=', (int)$id);
        }
        
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    public function get_active() {
        $this->db->from($this->table);
        $this->db->where('branch_status', 'active');
        $this->db->order_by('branch_name', 'ASC');
    
        $query = $this->db->get();
        return $query->result();
    }
}
?>