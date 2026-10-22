<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 27/02/2026

class Sup_category_model extends CI_Model {
    
    protected $table = 'super_category';
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get status counts for mini cards
     */
    public function get_status_counts()
    {
        $this->db->select("
        CASE 
            WHEN status = 'active' THEN 'Active'
            WHEN status = 'inactive' THEN 'Inactive'
            WHEN status = 'deleted' THEN 'Deleted'
            ELSE status
        END as name,
        status as color,
        COUNT(id) as total
    ", FALSE);
	
	
        $this->db->from($this->table);
        $this->db->group_by('status');
        
        $query = $this->db->get();
        return $query->result_array();
    }

   /**
 * Get filtered categories with product counts (DIRECT JOIN)
 */
public function get_filtered($search = null, $status = null, $date = null)
    {
        $this->db->select('super_category.*,COALESCE(COUNT(DISTINCT products.id), 0) as item_count');
        $this->db->from($this->table);
        // MUST go through sub_category table
        $this->db->join('sub_category', 'sub_category.super_category_id = super_category.id', 'left');
        $this->db->join('products', 'products.sub_category_id = sub_category.id AND products.status != "deleted"', 'left');
        
        // Hide deleted by default unless specifically requested
        if ($status !== 'deleted') {
            $this->db->where('super_category.status !=', 'deleted');
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('super_category.name', $search);
            $this->db->or_like('super_category.code', $search);
            $this->db->group_end();
        }

        if (!empty($status) && $status !== 'deleted') {
            $this->db->where('super_category.status', $status);
        }
        
        // If status is 'deleted', show only deleted
        if ($status === 'deleted') {
            $this->db->where('super_category.status', 'deleted');
        }

        if (!empty($date)) {
            $this->db->where('DATE(super_category.created_at)', $date);
        }

        $this->db->group_by('super_category.id');
        $this->db->order_by('super_category.updated_at', 'DESC');
        $this->db->order_by('super_category.created_at', 'DESC');

        $query = $this->db->get();
		
		
        return $query->result();
    }
	
	/**
 * Get all categories with product counts (DIRECT JOIN)
 */
public function get_all_with_product_counts()
    {
        $this->db->select('
            super_category.*,
            COALESCE(COUNT(DISTINCT products.id), 0) as item_count
        ');
        $this->db->from($this->table);
        $this->db->join('sub_category', 'sub_category.super_category_id = super_category.id', 'left');
        $this->db->join('products', 'products.sub_category_id = sub_category.id AND products.status != "deleted"', 'left');
        $this->db->group_by('super_category.id');
        $this->db->order_by('super_category.updated_at', 'DESC');
        $this->db->order_by('super_category.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * Get all categories with subcategory counts
     */
    public function get_all_with_subcategory_counts()
    {
        $this->db->select('
            super_category.*,
            COALESCE(COUNT(sub_category.id), 0) as subcategory_count
        ');
        $this->db->from($this->table);
        $this->db->join('sub_category', 'sub_category.super_category_id = super_category.id', 'left');
        $this->db->group_by('super_category.id');
        $this->db->order_by('super_category.updated_at', 'DESC');
        $this->db->order_by('super_category.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get all categories
     */
    public function get_all()
    {
		$this->db->order_by('updated_at', 'DESC');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table);
		
		
        return $query->result();
    }

    /**
 * Get single super category by ID with product count (DIRECT JOIN)
 */
public function get_by_id($id)
    {
        $this->db->select('
            super_category.*,
            COALESCE(COUNT(DISTINCT products.id), 0) as item_count
        ');
        $this->db->from($this->table);
        $this->db->join('sub_category', 'sub_category.super_category_id = super_category.id', 'left');
        $this->db->join('products', 'products.sub_category_id = sub_category.id AND products.status != "deleted"', 'left');
        $this->db->where('super_category.id', $id);
        $this->db->group_by('super_category.id');
        
        $query = $this->db->get();
		
		
        return $query->row();
    }


    /**
     * Insert new super category
     */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Super Category Module','Create Super Category','INSERT');
		//end of activity log
		
        return $this->db->insert_id();
    }

    /**
     * Update super category
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Super Category Module','Updete Super Category','UPDATE');
		//end of activity log
		
        return $this->db->affected_rows() > 0;
    }

    /**
     * Delete super category
     */
    public function delete($id)
    {
        if (!$id || !is_numeric($id)) {
        return false;
        }
    
        // Check if category exists
        $category = $this->get_by_id($id);
        if (!$category) {
            return false;
        }
    
        // SOFT DELETE - just update status to 'deleted' (uses existing toggle system)
        $data = [
          'status' => 'deleted',  // Uses same column as your toggle
          'updated_at' => date('Y-m-d H:i:s')
        ];
    
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Super Category Module','Delete Super Category','DELETE');
		//end of activity log
    
        return $this->db->affected_rows() > 0;
    }
	
	/**
   * RESTORE - Set status back to 'active'
   */
   public function restore($id)
   {
        if (!$id || !is_numeric($id)) {
           return false;
        }
    
        $data = [
          'status' => 'active',  // Restore to active
          'updated_at' => date('Y-m-d H:i:s')
        ];
    
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Super Category Module','Active Super Category','UPDATE');
		//end of activity log
    
        return $this->db->affected_rows() > 0;
     }
	 
	 /**
 * Update item count for a specific super category  
 */
public function update_item_count($super_category_id)
    {
        $this->db->select('COUNT(DISTINCT products.id) as item_count');
        $this->db->from('sub_category');
        $this->db->join('products', 'products.sub_category_id = sub_category.id AND products.status != "deleted"', 'left');
        $this->db->where('sub_category.super_category_id', $super_category_id);
        
        $query = $this->db->get();
        $result = $query->row();
        
        $item_count = $result ? (int)$result->item_count : 0;
        
        $this->db->where('id', $super_category_id);
        $this->db->update($this->table, ['item_count' => $item_count]);
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Super Category Module','Update item count in Super Category','UPDATE');
		//end of activity log
        
        return $this->db->affected_rows() > 0;
    }
	
	 /**
 * Update all item counts  
 */
public function update_all_item_counts()
    {
        $sql = "
            UPDATE super_category sc
            SET sc.item_count = (
                SELECT COUNT(DISTINCT p.id)
                FROM sub_category sub
                JOIN products p ON p.sub_category_id = sub.id AND p.status != 'deleted'
                WHERE sub.super_category_id = sc.id
            ),
            sc.updated_at = NOW()
        ";
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Super Category Module','Update item count in Super Category','UPDATE');
		//end of activity log
        
        return $this->db->query($sql);
    }
	

    /**
     * Get total count
     */
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    /**
     * Get active categories
     */
    public function get_active()
    {
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get($this->table);
		
		
        return $query->result();
    }
}