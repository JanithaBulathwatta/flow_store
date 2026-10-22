<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'traits/BranchTrait.php';
// supun 2026/3/10

class Store_model extends CI_Model {
use BranchTrait;
    protected $table = 'stores';

    public function __construct() {
        parent::__construct();
    }

    public function exists($store_id) {
        return $this->db
            ->where('store_id', (int)$store_id)
            ->where('store_status !=', 'deleted')
            ->count_all_results($this->table) > 0;
    }

    public function get_all_stores($filters = []) {
		$this->db->select($this->table . '.*, branches.branch_name');
        $this->db->from($this->table);
		
		$this->db->join('branches', 'branches.branch_id = ' . $this->table . '.branch_id', 'left');
		$this->db->where('stores.store_status','active');
		//$this->db->where('store_status', 'active');
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('store_name', $filters['search']);
            $this->db->or_like('store_address', $filters['search']);
            $this->db->or_like('store_phone', $filters['search']);
            $this->db->group_end();
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('store_status', $filters['status']);
        }else{
			$this->db->where_in('store_status', ['active','inactive'] );
		}
        
        if (!empty($filters['date'])) {
            $this->db->where('DATE(create_date)', $filters['date']);
        }
        
        $this->db->order_by('store_id', 'DESC');
        
        $query = $this->db->get();
        $r = $query->result();
            foreach($r as $item){
                $item->outstanding = 0;
            }

        return $r;
    }

    public function get_counts() {
        $data = [];
        
		
		
        $this->db->where('store_status', 'active');
        $data['active_count'] = $this->db->count_all_results($this->table);
        
        $this->db->where('store_status', 'inactive');
        $data['inactive_count'] = $this->db->count_all_results($this->table);
        
        $this->db->where('store_status', 'deleted');
        $data['deleted_count'] = $this->db->count_all_results($this->table);
        
        return (object) $data;
    }
	

    /*public function get_store($id) {
        return $this->db->get_where($this->table, ['store_id' => (int)$id])->row();
    }*/
	
	//update this function to get branch_name to edit view (11/05/2026 -> santhosh)
	public function get_store($id) {
		$this->db->select($this->table . '.*, branches.branch_name');
		$this->db->from($this->table);
		$this->db->join('branches', 'branches.branch_id = ' . $this->table . '.branch_id', 'left');
		$this->db->where($this->table . '.store_id', (int)$id);
		
		return $this->db->get()->row();
	}

    public function insert_store($data) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Store Module','Create Store','INSERT');
		//end of activity log
		
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_store($id, $data) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Store Module','Update Store','UPDATE');
		//end of activity log
		
        $this->db->where('store_id', (int)$id);
        return $this->db->update($this->table, $data);
    }

    public function delete_store($id) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Store Module','Delete Store','DELETE');
		//end of activity log
		
        $id = (int)$id;
        
        if (!$id) {
            return false;
        }
        
        $this->db->where('store_id', $id);
        return $this->db->update($this->table, ['store_status' => 'deleted']);
    }

    public function update_status($id, $status) {
        $id = (int)$id;
        
        if (!$id || !in_array($status, ['active', 'inactive'])) {
            return false;
        }
        
        $this->db->where('store_id', $id);
        return $this->db->update($this->table, ['store_status' => $status]);
    }

    public function get_active() {
        $this->db->from($this->table);
        $this->db->where('store_status', 'active');
        $this->db->order_by('store_name', 'ASC');
    
        $query = $this->db->get();
        return $query->result();
    }
}
?>