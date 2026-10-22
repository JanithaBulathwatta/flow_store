<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// wenusha 11/3/2026

class TaxRate_model extends CI_Model {

    protected $table = 'tax_rates';

    public function __construct() {
        parent::__construct();
    }

    public function exists($tax_rate_id) {
        return $this->db
            ->where('tax_rate_id', (int)$tax_rate_id)
            ->where('status !=', 'deleted')
            ->count_all_results($this->table) > 0;
    }

    public function get_all_taxes($filters = []) {
        $this->db->from($this->table);
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('tax_name', $filters['search']);
            $this->db->or_like('tax_code', $filters['search']);
            $this->db->or_like('description', $filters['search']);
            $this->db->group_end();
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        
        if (!empty($filters['tax_type'])) {
            $this->db->where('tax_type', $filters['tax_type']);
        }
        
        if (!empty($filters['date'])) {
            $this->db->where('DATE(created_at)', $filters['date']);
        }
        
        if (isset($filters['status !='])) {
            $this->db->where('status !=', $filters['status !=']);
        }
        
        $this->db->order_by('tax_rate_id', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get counts for mini cards - UPDATED to use single query
     */
    public function get_counts() {
        $query = $this->db->query("
            SELECT 
                COUNT(CASE WHEN status = 'active' THEN 1 END) as active_count,
                COUNT(CASE WHEN status = 'inactive' THEN 1 END) as inactive_count,
                COUNT(CASE WHEN status = 'deleted' THEN 1 END) as deleted_count
            FROM {$this->table}
        ");
        return $query->row();
    }

    public function get_tax($id) {
        return $this->db->get_where($this->table, ['tax_rate_id' => (int)$id])->row();
    }
	
    public function get_all_tax() {
        return $this->db->get($this->table)->result();
    }

    public function insert_tax($data) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Tax Rate Module','Create Tax Rate','INSERT');
		//end of activity log
		
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_tax($id, $data) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Tax Rate Module','Update Tax Rate','UPDATE');
		//end of activity log
		
        $this->db->where('tax_rate_id', (int)$id);
        return $this->db->update($this->table, $data);
    }

    public function delete_tax($id) {
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Tax Rate Module','Delete Tax Rate','DELETE');
		//end of activity log
		
        $id = (int)$id;
        
        if (!$id) {
            return false;
        }
        
        $this->db->where('tax_rate_id', $id);
        return $this->db->update($this->table, ['status' => 'deleted']);
    }

    public function update_status($id, $status) {
        $id = (int)$id;
        
        if (!$id || !in_array($status, ['active', 'inactive'])) {
            return false;
        }
        
        $this->db->where('tax_rate_id', $id);
        return $this->db->update($this->table, ['status' => $status]);
    }

    public function get_active($type = null) {
        $this->db->from($this->table);
        $this->db->where('status', 'active');
        
        if ($type && in_array($type, ['sales', 'purchase'])) {
            $this->db->where('tax_type', $type);
        }
        
        $this->db->order_by('tax_name', 'ASC');
    
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_code($code) {
        return $this->db->get_where($this->table, ['tax_code' => $code])->row();
    }

    public function tax_code_exists($code, $exclude_id = null) {
        $this->db->where('tax_code', $code);
        $this->db->where('status !=', 'deleted');
        
        if ($exclude_id) {
            $this->db->where('tax_rate_id !=', $exclude_id);
        }
        
        return $this->db->get($this->table)->num_rows() > 0;
    }
}
?>