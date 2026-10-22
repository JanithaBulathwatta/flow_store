<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'traits/BranchTrait.php';
//wenusha 4/3/2026

class Supply_model extends CI_Model {
    use BranchTrait;
    protected $table = 'supply';

    public function __construct() {
        parent::__construct();
		 $this->load->model('accounting/Accounts_model');
		
    }

   /**
 * Create new supplier with optional bank details
 */
public function create()
{
    $this->load->library('form_validation');
    
    // Set validation rules - Bank fields are optional now
    $this->form_validation->set_rules('name', 'Supplier Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'valid_email');
    $this->form_validation->set_rules('phone', 'Phone', 'required|trim|regex_match[/^[0-9+\-\s]{10,15}$/]|max_length[20]');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('cre_period', 'Credit Period', 'required');
    
    // Bank fields validation - only if bank_name is provided
    $bank_name = $this->input->post('bank_name', TRUE);
    if (!empty($bank_name)) {
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim');
        $this->form_validation->set_rules('bank_branch', 'Bank Branch', 'required');
        $this->form_validation->set_rules('account_number', 'Account Number', 'required');
        $this->form_validation->set_rules('account_holder', 'Account Holder', 'required');
    }
    
    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'stt' => 'error', 
            'msg' => validation_errors(), 
            'data' => ''
        ]);
        return false;
    }
    
    // Check if email already exists (only if email is provided)
$email = $this->input->post('email', TRUE);
if (!empty($email) && $this->email_exists($email, isset($id) ? $id : null)) {
    echo json_encode([
        'stt' => 'error',
        'msg' => 'Email already exists!',
        'data' => ''
    ]);
    return false;
}
    
    // Check if phone already exists  
    $phone = $this->input->post('phone', TRUE);
    if (!empty($phone) && $this->phone_exists($phone)) {
        echo json_encode([
            'stt' => 'error',
            'msg' => 'Phone number already exists!',
            'data' => ''
        ]);
        return false;
    }
    
    // Prepare data with XSS filtering
    $data = [
            'name' => $this->input->post('name', TRUE),
        'phone' => $this->input->post('phone', TRUE),
        'email' => !empty($email) ? $email : NULL,
        'address' => $this->input->post('address', TRUE),
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s'),
        'cre_period' => $this->input->post('cre_period', TRUE),
    ];
    
    // ADD BRANCH ID
    $data = $this->addBranch($data);
    
    // Only add bank details if bank_name is provided
    if (!empty($bank_name)) {
        $data['bank_name'] = $bank_name;
        $data['bank_branch'] = $this->input->post('bank_branch', TRUE);
        $data['account_number'] = $this->input->post('account_number', TRUE);
        $data['account_holder'] = $this->input->post('account_holder', TRUE);
    } else {
        // Set NULL values for bank fields
        $data['bank_name'] = null;
        $data['bank_branch'] = null;
        $data['account_number'] = null;
        $data['account_holder'] = null;
    }

	// ================== CREATE ACCOUNT ==================
	// mapping
	$account_class = 2; // LIABILITY
	$account_type  = 'LIABILITY';;

	$parent_id = 1;

	// calculate level
	$parent = $this->db->get_where('accounts', ['id' => $parent_id])->row_array();
	$level = $parent ? $parent['level'] + 1 : 1;

	$old_post = $_POST;

	$_POST = array_merge($_POST, [
		'account_name' => $this->input->post('name', TRUE),
		'account_class' => $account_class,
		'account_type' => $account_type,
		'parent_id' => $parent_id,
		'is_posting' => 1,
		'is_control_account' => 0,
		'level' => $level
	]);

	$this->Accounts_model->create_account();

	$_POST = $old_post;
	// ================== END OF CREATE ACCOUNT ==================


    $this->db->insert($this->table, $data);
    $id = $this->db->insert_id();
  
  
	if ($id) {
        echo json_encode([
            'stt' => 'ok',
            'msg' => 'Supplier Created Successfully!',
            'data' => $id
        ]);
    } else {
        echo json_encode([
            'stt' => 'error',
            'msg' => 'Something Went Wrong!',
            'data' => ''
        ]);
    }
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'Supplier Module','Create Supplier','INSERT');
	//end of activity log
	
	
}

/**
 * Update supplier with optional bank details
 */
public function update()
{
    $id = $this->input->post('id');
    
    if (!$id) {
        echo json_encode([
            'stt' => 'error',
            'msg' => 'Invalid Supplier ID!',
            'data' => ''
        ]);
        return false;
    }
    
    // Set validation rules  
    $this->form_validation->set_rules('name', 'Supplier Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'valid_email');
    $this->form_validation->set_rules('phone', 'Phone', 'required');
    $this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('cre_period', 'Credit Period', 'required');
    
    // Bank fields validation - only if bank_name is provided
    $bank_name = $this->input->post('bank_name', TRUE);
    if (!empty($bank_name)) {
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim');
        $this->form_validation->set_rules('bank_branch', 'Bank Branch', 'required');
        $this->form_validation->set_rules('account_number', 'Account Number', 'required');
        $this->form_validation->set_rules('account_holder', 'Account Holder', 'required');
    }
    
    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'stt' => 'error', 
            'msg' => validation_errors(), 
            'data' => ''
        ]);
        return false;
    }
    
    // Check if email already exists (only if email is provided)
$email = $this->input->post('email', TRUE);
if (!empty($email) && $this->email_exists($email, isset($id) ? $id : null)) {
    echo json_encode([
        'stt' => 'error',
        'msg' => 'Email already exists!',
        'data' => ''
    ]);
    return false;
}
    
    // Check if phone already exists (excluding current)
    $phone = $this->input->post('phone', TRUE);
    if (!empty($phone) && $this->phone_exists($phone, $id)) {
        echo json_encode([
            'stt' => 'error',
            'msg' => 'Phone number already exists!',
            'data' => ''
        ]);
        return false;
    }
    
    // Prepare data with XSS filtering
    $data = [
        'name' => $this->input->post('name', TRUE),
        'phone' => $this->input->post('phone', TRUE),
        'email' => !empty($email) ? $email : NULL,
        'address' => $this->input->post('address', TRUE),
        'cre_period' => $this->input->post('cre_period', TRUE),
        'updated_at' => date('Y-m-d H:i:s'),
    ];
     
    // Handle bank details based on selection
    if (!empty($bank_name)) {
        $data['bank_name'] = $bank_name;
        $data['bank_branch'] = $this->input->post('bank_branch', TRUE);
        $data['account_number'] = $this->input->post('account_number', TRUE);
        $data['account_holder'] = $this->input->post('account_holder', TRUE);
    } else {
        // Clear bank details when "None" is selected
        $data['bank_name'] = null;
        $data['bank_branch'] = null;
        $data['account_number'] = null;
        $data['account_holder'] = null;
    }
    
    // Add branch_id (shouldn't change, but included for consistency)
    $data = $this->addBranch($data); 
    
    $this->db->where('id', (int)$id)->update($this->table, $data);
    
    if ($this->db->affected_rows() >= 0) {
        echo json_encode([
            'stt' => 'ok',
            'msg' => 'Supplier Updated Successfully!',
            'data' => $id
        ]);
    } else {
        echo json_encode([
            'stt' => 'error',
            'msg' => 'No changes made or Something Went Wrong!',
            'data' => ''
        ]);
    }
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'Supplier Module','Update Supplier','UPDATE');
	//end of activity log
}

    /**
     * Get all suppliers with optional filters
     */
    public function get_all_suppliers($filters = []) 
    {
		$this->filterByBranch(); 
        $this->db->from($this->table);
        
        // IMPORTANT: Exclude deleted records by default unless specifically requested
        if (empty($filters['status']) || $filters['status'] != 'deleted') {
            $this->db->where('status !=', 'deleted');
        }
        
        // Apply filters if any
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('name', $filters['search']);
            $this->db->or_like('phone', $filters['search']);
            $this->db->or_like('email', $filters['search']);
            $this->db->or_like('address', $filters['search']);
            $this->db->group_end();
        }
        
        if (!empty($filters['status'])) {
    // Support multiple statuses
    $statuses = is_array($filters['status']) ? $filters['status'] : explode(',', $filters['status']);
    $this->db->where_in('status', $statuses);
}
        
        if (!empty($filters['date_range'])) {
         $dates = explode(' – ', $filters['date_range']);
         if (count($dates) == 2) {
            $start = date('Y-m-d', strtotime(trim($dates[0])));
            $end   = date('Y-m-d', strtotime(trim($dates[1])));
            $this->db->where('DATE(created_at) >=', $start);
            $this->db->where('DATE(created_at) <=', $end);
         }
        }
        
        // Order by latest first
        $this->db->order_by('id', 'DESC');
        
        
        $query = $this->db->get();
        $r = $query->result();
		
		
				foreach($r as $item){
			// Get total purchases (sum of all invoice amounts)
        $this->db->select_sum('grand_total');
        $this->db->where('supplier_id', $item->id);
        $purchases_result = $this->db->get('supplier_invoices')->row();
        $item->total_purchases = $purchases_result->grand_total ?? 0;
        
        // Get total paid (sum of all payment amounts)
        $this->db->select_sum('amount');
        $this->db->where('supplier_id', $item->id);
        $this->db->where('status', 'active');
        $payments_result = $this->db->get('supplier_payments')->row();
        $item->total_paid = $payments_result->amount ?? 0;
        
        // Outstanding (for backward compatibility)
        $item->outstanding = ($item->total_purchases - $item->total_paid);
		}
        return $r;
    }

    /**
     * Get supplier by ID
     */
    public function get_supplier_by_id($id) 
{
    $this->filterByBranch();  // ← ADD THIS LINE
    
    return $this->db->get_where($this->table, ['id' => $id])->row();
}

    /**
     * Delete supplier  
     */
    
public function delete_supplier($id)
{
    $id = (int)$id;

    if (!$id) {
        return false;
    }

    // Verify supplier belongs to current branch
    if (!$this->verifyBranch($this->table, $id)) {  // ← ADD THIS LINE
        return false;
    }

    // Check if supplier exists
    $supplier = $this->get_supplier_by_id($id);
    if (!$supplier) {
        return false;
    }
    
    $data = [
        'status' => 'deleted',
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $this->db->where('id', $id);
    $result = $this->db->update($this->table, $data);
    
    //for activity log entry
    $user_id_fk = $this->session->userdata('user_id');
    $user_type = $this->session->userdata('ut_id');
    $this->Activity_log_m->addLog($user_id_fk, $user_type, 'Supplier Module', 'Delete Supplier', 'DELETE');

    return $result;
}
    /**
     * Permanently delete supplier  
     */
    public function permanent_delete_supplier($id) 
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /**
     * Update supplier status
     */
    public function update_status($id, $status) 
    {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Get supplier counts by status
     */
    public function get_counts() 
{
    $branch_id = $this->getCurrentBranchId();  // ADD THIS LINE
    
    $query = $this->db->query("
        SELECT 
            COUNT(CASE WHEN status = 'active' THEN 1 END) as active_count,
            COUNT(CASE WHEN status = 'inactive' THEN 1 END) as inactive_count,
            COUNT(CASE WHEN status = 'deleted' THEN 1 END) as deleted_count,
            COUNT(*) as total_count
        FROM {$this->table}
        WHERE branch_id = " . ($branch_id ? (int)$branch_id : 0) . "
    ");
    return $query->row();
}

    /**
     * Check if email exists (for unique validation)
     */
    public function email_exists($email, $id = null) 
{
    $branch_id = $this->getCurrentBranchId();  // ADD THIS LINE
    
    $this->db->where('email', $email);
    $this->db->where('branch_id', $branch_id);  // ADD BRANCH FILTER
    
    if ($id) {
        $this->db->where('id !=', $id);
    }
    $query = $this->db->get($this->table);
    return $query->num_rows() > 0;
}

    /**
     * Check if phone exists (for unique validation)
     */
    public function phone_exists($phone, $id = null) 
{
    if (empty($phone)) return false;
    
    $branch_id = $this->getCurrentBranchId();  // ADD THIS LINE
    
    $this->db->where('phone', $phone);
    $this->db->where('branch_id', $branch_id);  // ADD BRANCH FILTER
    $this->db->where('status !=', 'deleted');
    
    if ($id) {
        $this->db->where('id !=', $id);
    }
    $query = $this->db->get($this->table);
    return $query->num_rows() > 0;
}
}