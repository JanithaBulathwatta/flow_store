<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 5/3/2026

class Brand_model extends CI_Model {

    protected $table = 'brands';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Check if brand exists  
     */
    public function exists($brand_id) {
        return $this->db
            ->where('brand_id', (int)$brand_id)
            ->where('brand_status', 'active')
            ->count_all_results($this->table) > 0;
    }

    /**
     * Get all brands with filters
     */
    public function get_all_brands($filters = [])
{
    $this->db->select('
        b.*,
        COUNT(p.id) as item_count
    ');
    $this->db->from($this->table . ' b');
    $this->db->join('products p', 'b.brand_id = p.brand_id AND p.status != "deleted"', 'left');
    
    // Apply filters
    if (!empty($filters['search'])) {
        $this->db->group_start()
            ->like('b.brand_name', $filters['search'])
            ->or_like('b.brand_code', $filters['search'])
            ->or_like('b.brand_description', $filters['search'])
            ->group_end();
    }
    
    if (!empty($filters['status'])) {
        if ($filters['status'] === 'active') {
            $this->db->where('b.brand_status', 'active');
        } elseif ($filters['status'] === 'inactive') {
            $this->db->where('b.brand_status', 'inactive');
        } elseif ($filters['status'] === 'deleted') {
            $this->db->where('b.brand_status', 'deleted');
        }
    } else {
        // Default: Show only active and inactive (exclude deleted)
        $this->db->where('b.brand_status !=', 'deleted');
    }
    
    if (!empty($filters['date'])) {
        $this->db->where('DATE(b.created_at)', $filters['date']);
    }
    
    $this->db->group_by('b.brand_id');
    $this->db->order_by('b.brand_id', 'DESC');
    
    $query = $this->db->get();
    return $query->result();
}

    /**
     * Get brand counts for mini cards
     */


public function get_counts()
{
    $query = $this->db->select('
        COUNT(*) as total_brands,
        IFNULL(SUM(CASE WHEN brand_status = "active" THEN 1 ELSE 0 END), 0) as active_count,
        IFNULL(SUM(CASE WHEN brand_status = "inactive" THEN 1 ELSE 0 END), 0) as inactive_count,
        IFNULL(SUM(CASE WHEN brand_status = "deleted" THEN 1 ELSE 0 END), 0) as deleted_count,
        IFNULL((SELECT COUNT(DISTINCT brand_id) FROM products WHERE status != "deleted"), 0) as brands_with_products
    ')->from($this->table)->get();
    
    return $query->row_array();
}

    /**
     * Get single brand by ID
     */
    public function get_brand($id)
{
    $this->db->select('
        b.*,
        COUNT(p.id) as item_count
    ');
    $this->db->from($this->table . ' b');
    $this->db->join('products p', 'b.brand_id = p.brand_id AND p.status != "deleted"', 'left');
    $this->db->where('b.brand_id', $id);
    $this->db->group_by('b.brand_id');
    
    $query = $this->db->get();
    return $query->row();
}
	
    /**
     * Insert new brand
     */
    public function insert_brand($data) {
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Brand Module','Create Brands','INSERT');
		
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
		
		
    }

    /**
     * Update brand
     */
    public function update_brand($id, $data) {
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Brand Module','Update Brand','UPDATE');
		
        $this->db->where('brand_id', (int)$id);
        return $this->db->update($this->table, $data);
			
    }

    /**
     * Delete brand  
     */
    public function delete_brand($id) {
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Brand Module','Delete Brand','DELETE');
		
        $id = (int)$id;
        
        if (!$id) {
            return false;
        }
        
        $this->db->where('brand_id', $id);
        return $this->db->update($this->table, ['brand_status' => 'deleted']);
		

		
    }

    /**
     * Check if brand code exists
     * FIXED: Now properly checks only active brands and excludes current ID for updates
     */
    public function code_exists($code, $id = 0) {
        if (empty($code)) {
            return false;
        }
        
        $this->db->where('brand_code', $code);
        $this->db->where('brand_status', 'active'); // Only check active brands
        
        if ($id > 0) {
            $this->db->where('brand_id !=', (int)$id); // Exclude current brand for updates
        }
        
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }
	
	public function get_active() {
        $this->db->from($this->table);
        $this->db->where('brand_status', 'active');
        $this->db->order_by('brand_name', 'ASC');
    
       $query = $this->db->get();
       return $query->result();
	   
	   
    }
	
}
?>