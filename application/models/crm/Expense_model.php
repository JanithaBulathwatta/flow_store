<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'traits/BranchTrait.php';
//wenusha 10/3/2026

class Expense_model extends CI_Model {

    use BranchTrait;
    protected $table_expenses = 'expenses';
    protected $table_categories = 'expense_cat';
    protected $table_types = 'expense_type';

    public function __construct() {
        parent::__construct();
    }
	
	public function get_table_types() {
        return $this->table_types;
    }

    public function get_table_expenses() {
        return $this->table_expenses;
    }

    public function get_table_categories() {
        return $this->table_categories;
    }

    // Get all expense categories from expense_cat table
    public function get_all_categories() {
        $this->db->select('exp_cat_id as id, exp_cat_name as name');
        $query = $this->db->get($this->table_categories);
        return $query->result();
    }

    // Get all expense types from expense_type table
    public function get_all_expense_types() {
    
        $this->db->select('
            et.Exp_Type_id as id, 
            et.Exp_Type_name as name, 
            et.Exp_Type_status as status,
            ec.exp_cat_name as category_name,
            ec.exp_cat_id as category_id
        ');
        $this->db->from($this->table_types . ' as et');
        $this->db->join($this->table_categories . ' as ec', 'ec.exp_cat_id = et.fk_exp_cat_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    // Get all expense types with categories for dropdown
    public function get_all_expense_types_with_categories() {
        return $this->get_all_expense_types();
    }

    // Count expense types by status (Active/Inactive)
    public function count_expense_types_by_status($status) {
        return $this->db->where('Exp_Type_status', $status)
                        ->from($this->table_types)
                        ->count_all_results();
    }

    // Filter expenses
   public function filter_expenses($date_range = null, $category_id = null, $type_id = null, $status = null) {

    $this->db->select('
        et.Exp_Type_id as id,
        et.Exp_Type_name as expense_type_name,
        et.Exp_Type_status as status,
        ec.exp_cat_id as category_id,
        ec.exp_cat_name as expense_category_name
    ');

    $this->db->from($this->table_types . ' as et');
    $this->db->join($this->table_categories . ' as ec', 'ec.exp_cat_id = et.fk_exp_cat_id', 'left');


    // Only hide deleted records if no status filter is applied or if status is not 'deleted'
    if (empty($status) || $status !== 'deleted') {
        $this->db->where('et.Exp_Type_status !=', 'Deleted');
    }
	
    // Category filter
    if (!empty($category_id)) {
        $this->db->where('et.fk_exp_cat_id', $category_id);
    }

    // Status filter
    if (!empty($status)) {
        // Handle status mapping (convert 'active' to 'Active', etc.)
        if ($status === 'active') {
            $status = 'Active';
        } elseif ($status === 'inactive') {
            $status = 'Inactive';
        } elseif ($status === 'deleted') {
            $status = 'Deleted';
        }
        $this->db->where('et.Exp_Type_status', $status);
    }

    $this->db->order_by('et.Exp_Type_id', 'DESC');

    $query = $this->db->get();
    return $query->result_array();
}

    // Save new expense
     public function save_expense($data) {
        // ADD BRANCH ID
        $data = $this->addBranch($data);
		
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Expense Module','Create Expense','INSERT');
		//end of activity log
		
        // Check if table exists
        if (!$this->db->table_exists($this->table_expenses)) {
            return false;
        }
        
        $this->db->insert($this->table_expenses, $data);
        return $this->db->insert_id();
    }

    // Get expense by ID
    public function get_expense_by_id($id) {
        // Filter by branch
        $this->filterByBranch('e');
        // Check if table exists
        if (!$this->db->table_exists($this->table_expenses)) {
            return null;
        }
        
        $this->db->select('
            e.*, 
            et.Exp_Type_name,
            et.Exp_Type_status,
            ec.exp_cat_name
        ');
        $this->db->from($this->table_expenses . ' as e');
        $this->db->join($this->table_types . ' as et', 'et.Exp_Type_id = e.Exp_Type_id', 'left');
        $this->db->join($this->table_categories . ' as ec', 'ec.exp_cat_id = e.exp_cat_id', 'left');
        $this->db->where('e.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Update expense type status
    public function update_type_status($id, $status) {
        return $this->db->where('Exp_Type_id', $id)
                        ->update($this->table_types, ['Exp_Type_status' => $status]);
    }

    public function delete_expense($id) {
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'Expense Module','Delete Expense','DELETE');
	//end of activity log
		
		log_message('error', 'delete_expense called with ID: ' . $id);
    $id = (int)$id;
    
    if (!$id) {
        log_message('error', 'Invalid expense ID for delete: ' . $id);
        return false;
    }
    
    // Check if record exists
    $this->db->where('Exp_Type_id', $id);
    $query = $this->db->get($this->table_types);
    $expense = $query->row();
	
	log_message('error', 'Query: ' . $this->db->last_query());
    log_message('error', 'Found expense: ' . print_r($expense, true));
    
    if (!$expense) {
        log_message('error', 'Expense type not found with ID: ' . $id);
        return false;
    }
    
    // Soft delete - mark as deleted/inactive
    $this->db->where('Exp_Type_id', $id);
    $this->db->update($this->table_types, ['Exp_Type_status' => 'Deleted']);
    
    $affected = $this->db->affected_rows();
    log_message('error', 'Affected rows: ' . $affected);
    log_message('error', 'Update query: ' . $this->db->last_query());
    
    if ($affected > 0) {
        log_message('error', 'Successfully deactivated expense type ID: ' . $id);
        return true;
    } else {
        log_message('error', 'Deactivate failed for expense type ID: ' . $id);
        return false;
    }
}
    // Get expense type by ID
    // Add this method to Expense_model.php
public function get_expense_type_by_id($id) {
    $this->db->select('
        et.Exp_Type_id as id,
        et.Exp_Type_name as name,
        et.Exp_Type_status as status,
        et.fk_exp_cat_id as category_id,
        ec.exp_cat_name as category_name
    ');
    $this->db->from($this->table_types . ' as et');
    $this->db->join($this->table_categories . ' as ec', 'ec.exp_cat_id = et.fk_exp_cat_id', 'left');
    $this->db->where('et.Exp_Type_id', $id);
    
    $query = $this->db->get();
    return $query->row_array();
}

    // Get category by ID
    public function get_category_by_id($id) {
        $query = $this->db->where('exp_cat_id', $id)
                        ->get($this->table_categories);
        return $query->row_array();
    }
	
	public function count_deleted_expense_types() {
    return $this->db->where('Exp_Type_status', 'Deleted')
                    ->from($this->table_types)
                    ->count_all_results();
}
	public function update_status_to_pending($expense_id) {
        // Verify expense belongs to current branch
        if (!$this->verifyBranch($this->table_expenses, $expense_id, 'exp_id')) {
            log_message('error', "Cannot update expense from different branch: $expense_id");
            return false;
        }
    // Construct the modification map to transition the ENUM state row value
    $data = array(
        'status' => 'pending' // Matches your explicit table ENUM values exactly
    );

    // Apply strict filtering constraints targeting that exact database primary key index
    $this->db->where('exp_id', $expense_id); 
    
    // Execute active records update transaction and return true/false status results
    return $this->db->update('expenses', $data); 
}
} 