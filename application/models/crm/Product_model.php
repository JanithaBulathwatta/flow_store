<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 6/3/2026

class Product_model extends CI_Model
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check if product exists
     */
    public function exists($product_id)
    {
        return $this->db
            ->where('id', (int)$product_id)
            ->count_all_results($this->table) > 0;
    }

    /**
     * Check if product code exists
     */
    public function code_exists($code, $exclude_id = null)
    {
        $this->db->where('product_code', $code);
		$this->db->where('status !=', 'deleted');
		
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get product counts for dashboard
     */
    public function get_counts()
    {
        $query = $this->db->select('
            COUNT(*) as all_count,
            SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count,
			SUM(CASE WHEN status = "inactive" THEN 1 ELSE 0 END) as inactive_count,
            SUM(CASE WHEN status = "deleted" THEN 1 ELSE 0 END) as deleted_count
        ')->from($this->table)->get();
        
        return $query->row_array();
    }

    /**
     * Get all active products (for dropdowns etc)
     */
    public function get_active()
    {
        return $this->db
            ->select('id, name, product_code, price')
            ->where('status', 'active')
            ->order_by('name', 'ASC')
            ->get($this->table)
            ->result();
    }

    /**
     * Get filtered products for DataTable
     */
	public function get_filtered($search = '', $status = '', $date = '', $scat = '')
	{	
		$this->db->select('
			p.*,
			p.id,
			b.brand_name as brand_name,
			b.brand_code,
			sc.name as category_name,   
			ssc.name as super_category_name,
			p.is_serial_trk,
			p.is_expiry_trk,
			p.wholesalePrice,
			p.specialPrice,
			p.is_batch,
			p.warrantyType,
			p.measure_unit,       
			p.qty_per_pack,
			u.unit_name,           
			u.unit_code  
		')
		->from($this->table . ' p')
		->join('brands b', 'p.brand_id = b.brand_id', 'left')
		->join('sub_category sc', 'p.category_id = sc.id', 'left')
		->join('super_category ssc', 'p.sub_category_id = ssc.id', 'left')
		->join('units u', 'p.measure_unit = u.unit_id', 'left');
		
		// Apply search filter
		if (!empty($scat)) {
			$this->db->where('p.category_id', $scat);
		}
		
		// Apply search filter
		if (!empty($search)) {
			$this->db->group_start()
				->like('p.name', $search)
				->or_like('p.product_code', $search)
				->or_like('p.description', $search)
				->group_end();
		}

		// Status filtering - now only using status field
		if ($status === 'active') {
			$this->db->where('p.status', 'active');
		} elseif ($status === 'inactive') {
			$this->db->where('p.status', 'inactive');
		} elseif ($status === 'deleted') {
			$this->db->where('p.status', 'deleted');
		} else {
			// Default: Show all non-deleted products
			$this->db->where('p.status !=', 'deleted');
		}

		$this->db->order_by('p.id', 'DESC');
			
		return $this->db->get()->result_array();
	}

		/**
		 * Get single product by ID with relations
		 */
		public function get_by_id($id)
	{
		return $this->db
			->select('
				p.*,
				b.brand_name as brand_name,
				b.brand_code,
				sc.name as category_name,   
				ssc.name as super_category_name,
				p.is_serial_trk,
				p.is_expiry_trk,
				p.wholesalePrice,
				p.specialPrice,
				p.is_batch,
				p.warrantyType,
				u.unit_id,   
				p.images,
				p.measure_unit,       
				p.qty_per_pack,
				u.unit_name,           
				u.unit_code 
				
			')
			->from($this->table . ' p')
			->join('brands b', 'p.brand_id = b.brand_id', 'left')
			->join('sub_category sc', 'p.category_id = sc.id', 'left')
			->join('super_category ssc', 'p.sub_category_id = ssc.id', 'left')
			->join('units u', 'p.measure_unit = u.unit_id', 'left') 
			->where('p.id', (int)$id)
			->get()
			->row_array();
	}

    /**
     * Create new product
     */
    public function create($data)
    {
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Product Module','Create Product','INSERT');
		//end of activity log
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update product
     */
    public function update($id, $data)
    {
        $this->db->where('id', (int)$id);
        $this->db->update($this->table, $data);
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Product Module','Update Product','UPDATE');
		//end of activity log
		
        return $this->db->affected_rows() > 0;
    }

    /**
     * Soft delete product
     */
    public function delete($id)
    {
        $data = [
            'status' => 'deleted',
             
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', (int)$id);
        $this->db->update($this->table, $data);
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Product Module','DELETE Product','DELETE');
		//end of activity log
        
        return $this->db->affected_rows() > 0;
    }

    /**
     * Hard delete (if needed)
     */
    public function hard_delete($id)
    {
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Product Module','DELETE Product','DELETE');
		//end of activity log
		
        return $this->db->where('id', (int)$id)->delete($this->table);
    }
	
	/**
 * Check if brand has associated products
  
 */
public function has_products_by_brand($brand_id)
{
    return $this->db->where('brand_id', $brand_id)
        ->where('status !=', 'deleted')
        ->count_all_results($this->table) > 0;
}

/**
 * Get product count by brand
  
 */
public function get_product_count_by_brand($brand_id)
{
    return $this->db->where('brand_id', $brand_id)
        ->where('status !=', 'deleted')
        ->count_all_results($this->table);
}

/**
 * After product create/update/delete, update super category item count
 */
public function update_super_category_item_count($category_id = null)
{
    if ($category_id) {
        // Get super_category_id from sub_category
        $this->db->select('super_category_id');
        $this->db->where('id', $category_id);
        $sub_category = $this->db->get('sub_category')->row();
        
        if ($sub_category && $sub_category->super_category_id) {
            $this->load->model('crm/Sup_category_model');
            $this->Sup_category_model->update_item_count($sub_category->super_category_id);
        }
    }
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'Product Module','Update super category item count','UPDATE');
	//end of activity log
}
}