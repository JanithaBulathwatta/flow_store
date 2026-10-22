<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'traits/BranchTrait.php';

class Customer_model extends CI_Model {
	
	use BranchTrait;

   protected $table = 'customer';

    public function __construct() {
        parent::__construct();
		$this->load->model('accounting/Accounts_model');
    }
	
	public function exists($lead_id)
{
    $this->filterByBranch();
        return $this->db->where('cus_id', (int)$lead_id)->count_all_results($this->table) > 0;
    }

	public function get_all($status = 'all')
	{
		
		//$this->filterByBranch();
		$branch = $this->session->userdata('branch');
		$this->db->select('*')->from('customer');

		if ($status != 'all') {
			$this->db->where('cus_status', $status);
			$this->db->where('branch_id',$branch);
		} else {
			$this->db->where_in('cus_status', ['active','inactive']);
		}
		
		return $this->db->order_by('cus_id', 'DESC')->get()->result();
	}
	
	public function get_by_id($id)
{
    $this->filterByBranch();
		return $this->db->select('*')->from('customer')->where('cus_id', (int)$id)->get()->row();
	}
	

	public function create()
	{
		$this->load->library('form_validation');
		// Set Validation Rules based on your Sub Category table
		$this->form_validation->set_rules('name', 'Customer Name', 'required|trim|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		$this->form_validation->set_rules('phone', 'Phone One', 'required|trim|regex_match[/^[0-9+\-\s]{10,15}$/]');
		$this->form_validation->set_rules('phone_two', 'Phone Two', 'trim|regex_match[/^[0-9+\-\s]{10,15}$/]');
		$this->form_validation->set_rules('address', 'Address', 'required|trim|max_length[255]');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|max_length[100]');
		// Credit Details
		$this->form_validation->set_rules('is_credit', 'Enable Credit', 'required|in_list[0,1]');
		// Conditional Validation: Only require these if is_credit is "1"
		if ($this->input->post('is_credit') == '1') {
			$this->form_validation->set_rules('current_credit_amt', 'Current Credit Amount', 'required|numeric');
			$this->form_validation->set_rules('max_credit_limit', 'Max Credit Limit', 'required|numeric');
		} else {
			$this->form_validation->set_rules('current_credit_amt', 'Current Credit Amount', 'numeric');
			$this->form_validation->set_rules('max_credit_limit', 'Max Credit Limit', 'numeric');
		}

		if ($this->form_validation->run() == FALSE) {
			// Return validation errors to AJAX
			echo json_encode(['stt' => 'error', 'msg' => validation_errors(), 'data' => '']);
		} else {
			// Prepare Data for the sub_category table
			$data = [
				'cus_name'           => $this->input->post('name', TRUE),
				'company_name'       => $this->input->post('company_name', TRUE),
				'cus_phone'          => $this->input->post('phone', TRUE),
				'cus_phone_2'        => $this->input->post('phone_two', TRUE),
				'cus_email'          => $this->input->post('email', TRUE),
				'cus_address'        => $this->input->post('address', TRUE),
				'is_credit'          => $this->input->post('is_credit', TRUE),
				// Use 0 if the values are empty or not provided
				'current_credit_amt' => $this->input->post('current_credit_amt', TRUE) ?: 0,
				'max_credit_limit'   => $this->input->post('max_credit_limit', TRUE) ?: 0,
				'cus_status'         => 'active'
			];
             // ADD BRANCH ID
        $data = $this->addBranch($data);
			//  Insert into the database
			$this->db->insert('customer', $data);
			$insert_id = $this->db->insert_id();

			// ================== CREATE ACCOUNT ==================
			// mapping
			/*$account_class = 1; // ASSET
			$account_type  = 'ASSET';

			$parent_id = 2;

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

			$_POST = $old_post;*/
			// ================== END OF CREATE ACCOUNT ==================

			if ($insert_id) {
				echo json_encode(array("stt" => "ok", "msg" => "Customer Created Successfully !!", "data" => $insert_id));
			} else {
				echo json_encode(array("stt" => "error", "msg" => "Something Went Wrong !!", "data" => ''));
			}
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Customer Module','Create Customer','INSERT');
		//end of activity log
	}
	
	public function update()
    {	
		$id = $_POST['lid'];
		
		$data = [
			'cus_name'           => $this->input->post('name', TRUE),
			'company_name'       => $this->input->post('company_name', TRUE),
			'cus_phone'          => $this->input->post('phone', TRUE),
			'cus_phone_2'        => $this->input->post('phone_two', TRUE),
			'cus_email'          => $this->input->post('email', TRUE),
			'cus_address'        => $this->input->post('address', TRUE),
			'is_credit'          => $this->input->post('is_credit', TRUE),
			// Use 0 if the values are empty or not provided
			'current_credit_amt' => $this->input->post('current_credit_amt', TRUE) ?: 0,
			'max_credit_limit'   => $this->input->post('max_credit_limit', TRUE) ?: 0,
			'cus_status'         => 'active'
		];
          // Add branch_id (though it shouldn't change)
    $data = $this->addBranch($data);
        $this->db->where('cus_id', (int)$id)->update($this->table, $data);

		if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Customer Updated Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Customer Module','Update Customer','UPDATE');
		//end of activity log
        //return $this->db->affected_rows();
    }
	
		public function delete($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}
        
		 // Verify customer belongs to current branch
    if (!$this->verifyBranch('customer', $id, 'cus_id')) {  // ← ADD THIS LINE
        echo json_encode(['stt' => 'error','msg' => 'Unauthorized: Customer not in your branch','data' => '']);
        return;
    }
		$this->db->where('cus_id', $id);
		$update = $this->db->update('customer',['cus_status' => 'delete']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Customer Deleted Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Customer Module','Delete Customer','DELETE');
		//end of activity log
	}
	
	public function cancel($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}

		$this->db->where('id', $id);
		$update = $this->db->update('customer',['cus_status' => 'cancel']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Lead Cancel Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Customer Module','Cancel Customer','UPDATE');
		//end of activity log
	}
	
	 /**
     * Get staff counts by status
     */
	 public function get_counts() {
		$branch_id = $this->getCurrentBranchId();
		$data = [];
		
		$this->db->where('branch_id', $branch_id);
		$data['all_count'] = $this->db->count_all_results($this->table);
		
		$this->db->where(['branch_id' => $branch_id, 'cus_status' => 'active']);
		$data['active_count'] = $this->db->count_all_results($this->table);
		
		$this->db->where(['branch_id' => $branch_id, 'cus_status' => 'inactive']);
		$data['inactive_count'] = $this->db->count_all_results($this->table);
		
		$this->db->where(['branch_id' => $branch_id, 'cus_status' => 'delete']);
		$data['deleted_count'] = $this->db->count_all_results($this->table);
		
		return (object) $data;
	}
	
	/**
 * Get customer invoices from sales_invoices table
 */
public function get_customer_invoices($customer_id)
{
    if (!$this->db->table_exists('sales_invoices')) {
        return [];
    }
    // Verify customer exists and belongs to branch (optional check)
    if (!$this->verifyBranch('customer', $customer_id, 'cus_id')) {
        return [];
    }
    
    $branch_id = $this->getCurrentBranchId();
    $query = $this->db
        ->select('id, invoice_no, invoice_date as date, due_date, grand_total as amount, paid_amount as paid, payment_status as status')
        ->from('sales_invoices')
        ->where('customer_id', $customer_id)
        ->where('branch_id', $branch_id) 
        ->order_by('invoice_date', 'DESC')
        ->get();
    
    $results = $query->result();
    
    // Format the data properly
    $formatted = [];
    foreach ($results as $row) {
        $formatted[] = (object)[
            'id' => $row->id,
            'invoice_no' => $row->invoice_no,
            'invoice_date' => date('Y-m-d', strtotime($row->date)),
            'due_date' => $row->due_date ? date('Y-m-d', strtotime($row->due_date)) : '',
            'grand_total' => floatval($row->amount),
            'paid_amount' => floatval($row->paid),
            'balance_amount' => floatval($row->amount) - floatval($row->paid),
            'status' => strtolower($row->status) // Convert to lowercase for consistency
        ];
    }
    
    return $formatted;
}

/**
 * Get customer payments from sales_payments and sales_payment_items
 */
public function get_customer_payments($customer_id)
{
    // Check if tables exist
     if (!$this->db->table_exists('sales_payments') || !$this->db->table_exists('sales_payment_items')) {
        return [];
    }
    
    // Verify customer exists and belongs to branch
    if (!$this->verifyBranch('customer', $customer_id, 'cus_id')) {
        return [];
    }
    
    $branch_id = $this->getCurrentBranchId();
    
    $query = $this->db
        ->select('
            sp.id as payment_id,
            sp.payment_date as date,
            spi.payment_method as method,
            spi.amount as amount,
            spi.reference_no as note,
            si.invoice_no,
            si.id as invoice_id
        ')
        ->from('sales_payments sp')
        ->join('sales_payment_items spi', 'spi.payment_id = sp.id', 'left')
        ->join('sales_invoices si', 'si.id = sp.invoice_id', 'left')
        ->where('si.customer_id', $customer_id)
        ->where('si.branch_id', $branch_id)
        ->order_by('sp.payment_date', 'DESC')
        ->get();
    
    $results = $query->result();
    
    // Format the data
    $formatted = [];
    foreach ($results as $row) {
        $formatted[] = [
            'payment_id' => $row->payment_id,
            'receipt_no' => 'RCP-' . str_pad($row->payment_id, 6, '0', STR_PAD_LEFT),
            'date' => date('Y-m-d', strtotime($row->date)),
            'invoice_id' => $row->invoice_id,
            'invoice_no' => $row->invoice_no ?? 'N/A',
            'method' => ucwords(strtolower($row->method ?? 'Cash')),
            'amount' => floatval($row->amount ?? 0),
            'note' => $row->note ?? ''
        ];
    }
    
    return $formatted;
}

 
}	