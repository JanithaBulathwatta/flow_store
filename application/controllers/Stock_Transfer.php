<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_Transfer extends CI_Controller {

    public function __construct() {
    parent::__construct();
    $this->load->model('Stock_transaction_model');
    $this->load->model('crm/Customer_model');
    $this->load->model('Store_model');
    $this->load->model('crm/Product_model');
	$this->load->model('crm/Projects_model', 'project');
    $this->load->helper('url');
    
    // Check if user is logged in
    if (!$this->session->userdata('user_id')) {
        $this->response('unauth', [], 'Unauthorized', 401);
        exit;
    }
    
    // ADD PERMISSION CHECK HERE
    $user_type = $this->session->userdata('ut_id');
    $current_url = uri_string(); // Gets current URL like "Stock_Transfer/index"
    
    // Check if user has permission for this module
    if (!$this->_check_permission($user_type, $current_url)) {
        // If no permission, return unauthorized
        if ($this->input->is_ajax_request()) {
            $this->response('unauth', [], 'You don\'t have permission to access this module', 403);
        } else {
            show_error('You don\'t have permission to access this page', 403);
        }
    }
}

	// Add this method to check permissions
	private function _check_permission($user_type, $url) {
		// If user is super admin (assuming ut_id = 1 is super admin), allow all
		if ($user_type == 1) {
			return true;
		}
		
		// Query to check if user has permission for this URL
		$this->db->select('psu.*');
		$this->db->from('sys_permission_user_sub psu');
		$this->db->join('sys_permission_sub ps', 'ps.ps_id = psu.ps_id');
		$this->db->where('psu.ut_id', $user_type);
		$this->db->where('ps.ps_url', $url);
		$this->db->where('psu.status', 'active');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return true;
		}
		
		// Also check for wildcard permissions (e.g., "Stock_Transfer/*")
		$this->db->select('psu.*');
		$this->db->from('sys_permission_user_sub psu');
		$this->db->join('sys_permission_sub ps', 'ps.ps_id = psu.ps_id');
		$this->db->where('psu.ut_id', $user_type);
		$this->db->where('ps.ps_url', $url . '/%');
		$this->db->where('psu.status', 'active');
		
		$query2 = $this->db->get();
		
		return $query2->num_rows() > 0;
	} 

    // ─── MAIN VIEW ───
    // public function index() {
        // $data['customers']  = $this->Customer_model->get_all();
        // $data['warehouses'] = $this->Store_model->get_all_stores();
        
		
        // $allowed = ['issue_ui','receive_ui'];

		// $page = $this->input->get('page');

		// if(!in_array($page, $allowed)){
			// $page = 'issue';
		// }
		
		// $this->load->view('header');
		// $this->load->view('stock/st_tir', $data);
		// $this->load->view('footer');
		
	// } 
	public function index() {
		// Get mode from URL parameter (default: issue)
		$mode = $this->input->get('mode');
		
		// Define allowed modes
		$allowed_modes = ['issue', 'transfer', 'return'];
		
		// Validate mode
		if (!in_array($mode, $allowed_modes)) {
			$mode = 'issue';
		}
		
		// Load mode-specific data
		switch($mode) {
			case 'issue':
				$data['customers']  = $this->Customer_model->get_all();
				$data['warehouses'] = $this->Store_model->get_all_stores();
				break;
			case 'transfer':
				$data['warehouses'] = $this->Store_model->get_all_stores();
				$data['customers'] = [];
				break;
			case 'return':
				$data['customers']  = $this->Customer_model->get_all();
				$data['warehouses'] = $this->Store_model->get_all_stores();
				break;
		}
		
		// CHANGE THIS LINE - use 'allowed' instead of 'mode'
		$data['allowed'] = $mode;  // <-- FIXED: was $data['mode'] = $mode;
		$data['allowed_modes'] = $allowed_modes;
		
		$this->load->view('header');
		$this->load->view('stock/st_tir', $data);
		$this->load->view('footer');
	}
   
	//project item issue
	public function project_issue() {
		// Get mode from URL parameter (default: issue)
		$mode = $this->input->get('mode');
		
		// Define allowed modes
		$allowed_modes = ['pro_issue','transfer', 'return'];
		
		// Validate mode
		if (!in_array($mode, $allowed_modes)) {
			$mode = 'pro_issue';
		}
		
		// Load mode-specific data
		switch($mode) {
			case 'pro_issue':
				$start_date = '';
				$end_date = '';
				$customer = '';
				$status = '';

				$data ['project'] = $this->project->get_filtered($start_date, $end_date, $customer, $status);
				$data['warehouses'] = $this->Store_model->get_all_stores();
				break;
			case 'transfer':
				$data['warehouses'] = $this->Store_model->get_all_stores();
				$data['customers'] = [];
				break;
			case 'return':
				$data['customers']  = $this->Customer_model->get_all();
				$data['warehouses'] = $this->Store_model->get_all_stores();
				break;
		}
		
		// CHANGE THIS LINE - use 'allowed' instead of 'mode'
		$data['allowed'] = $mode;  // <-- FIXED: was $data['mode'] = $mode;
		$data['allowed_modes'] = $allowed_modes;
		
		$this->load->view('header');
		$this->load->view('stock/st_transfer', $data);
		$this->load->view('footer'); 
	}
	//project item issue

    // ─── RESPONSE WRAPPER ───
    private function response($status, $data = [], $msg = '', $code = 200) {
        http_response_code($code);
        echo json_encode(['status' => $status, 'data' => $data, 'msg' => $msg]);
        exit;
    }

    // ─── SAVE TRANSACTION (PENDING) ───
    public function store() {
		$payload = json_decode(file_get_contents("php://input"), true);
		
		if (!$payload) {
			$this->response('validation_error', [], 'Invalid request', 422);
		}
		
		// Validate based on mode
		$mode = $payload['transaction_mode'] ?? '';
		$errors = [];
		
		if ($mode === 'transfer') {
			if (empty($payload['store_id'])) {
				$errors[] = 'Source warehouse is required';
			}
			if (empty($payload['to_store_id'])) {
				$errors[] = 'Destination warehouse is required';
			}
			if ($payload['store_id'] == $payload['to_store_id']) {
				$errors[] = 'Source and destination warehouses must be different';
			}
			// No customer validation for transfer
		} elseif ($mode === 'issue') {
			if (empty($payload['customer_id'])) {
				$errors[] = 'Customer is required for stock issue';
			}
			if (empty($payload['store_id'])) {
				$errors[] = 'Warehouse is required';
			}
		}
		elseif ($mode === 'pro_issue') {
			if (empty($payload['project_id'])) {
				$errors[] = 'Project is required for stock issue';
			}
			if (empty($payload['store_id'])) {
				$errors[] = 'Warehouse is required';
			}
		}
		elseif ($mode === 'return') {
			if (empty($payload['customer_id'])) {
				$errors[] = 'Customer is required for stock return';
			}
			if (empty($payload['store_id'])) {
				$errors[] = 'Warehouse is required';
			}
		}
		
		if (empty($payload['items'])) {
			$errors[] = 'At least one item is required';
		}
		
		if (!empty($errors)) {
			$this->response('validation_error', $errors, 'Validation failed', 422);
		}
		
		// Save transaction
		$result = $this->Stock_transaction_model->save_transaction($payload);
		
		if (!$result['success']) {
			$this->response('error', [], $result['message'], 500);
		}
		
		$this->response('success', $result['data'], 'Transaction saved as pending');
	}

    // ─── UPDATE TRANSACTION ───
    public function update($id = null) {
        if (!$id) $id = $this->uri->segment(3);
        if (!$id) $this->response('error', [], 'Transaction ID required', 400);

        $payload = json_decode(file_get_contents("php://input"), true);
        if (!$payload) $this->response('validation_error', [], 'Invalid request', 422);

        $result = $this->Stock_transaction_model->update_transaction($id, $payload);
        
        if (!$result['success']) {
            $this->response('error', [], $result['message'], 500);
        }

        $this->response('success', [], 'Transaction updated');
    }

		// ─── APPROVE TRANSACTION ───
	public function approve() {
		// Get ID from GET parameter
		$id = $this->input->get('id');
		
		// If not found, try URI segment
		if (!$id) {
			$id = $this->uri->segment(3);
		}
		
		if (!$id) {
			$this->response('error', [], 'Transaction ID required', 400);
		}

		$result = $this->Stock_transaction_model->approve_transaction($id);
		
		if (!$result['success']) {
			$this->response('error', [], $result['message'], 500);
		}

		$this->response('success', [], 'Transaction approved - stock updated');
	}       

    // ─── REJECT TRANSACTION ───
    public function reject() {
		$id = $this->input->get('id');
        if (!$id) {
        $id = $this->uri->segment(3);
    }
        if (!$id) $this->response('error', [], 'Transaction ID required', 400);

        $note = $this->input->post('note') ?? 'Rejected';
        
        $result = $this->Stock_transaction_model->reject_transaction($id, $note);
        
        if (!$result['success']) {
            $this->response('error', [], $result['message'], 500);
        }

        $this->response('success', [], 'Transaction rejected');
    }

    // ─── GET CUSTOMERS (AJAX) ───
    public function get_customers_ajax() {
        $customers = $this->Customer_model->get_all('1');
        $data = $this->Stock_transaction_model->format_customers_for_dropdown($customers);
        $this->response('success', $data, 'Customers loaded');
    }

	public function get_products_ajax() {
		// Get ALL product fields including batch/serial tracking
		$products = $this->db->where('status', 'active')
                         ->get('products')
                         ->result();
		$data = $this->Stock_transaction_model->format_products_for_search($products);
		$this->response('success', $data, 'Products loaded');
	}

    // ─── GET WAREHOUSES (AJAX) ───
    public function get_warehouses_ajax() {
        $stores = $this->Store_model->get_all_stores();
        $this->response('success', $stores, 'Warehouses loaded');
    }

    // ─── GET BATCHES ───
    public function get_batches() {
        $product_id   = $this->input->get('product_id');
        $warehouse_id = $this->input->get('warehouse_id');
        
        if (!$product_id) $this->response('error', [], 'Product ID required', 400);

        $batches = $this->Stock_transaction_model->get_available_batches($product_id, $warehouse_id);
        $this->response('success', $batches, 'Batches loaded');
    }

    // ─── GET SERIALS ───
    public function get_serials() {
        $product_id   = $this->input->get('product_id');
        $warehouse_id = $this->input->get('warehouse_id');
        
        if (!$product_id) $this->response('error', [], 'Product ID required', 400);

        $serials = $this->Stock_transaction_model->get_available_serials($product_id, $warehouse_id);
        $this->response('success', $serials, 'Serials loaded');
    }

    // ─── GET SINGLE TRANSACTION ───
    public function get($id = null) {
    if (!$id) $id = $this->input->get('id');
    if (!$id) $this->response('error', [], 'Transaction ID required', 400);

    $transaction = $this->Stock_transaction_model->get_transaction($id);
    
    if (!$transaction) {
        $this->response('error', [], 'Transaction not found', 404);
    }

    $this->response('success', $transaction, 'Transaction loaded');
}


		// ─── LIST PAGE VIEW ───
	public function activity_list() {
		$data['warehouses'] = $this->Store_model->get_all_stores();
	 
		$this->load->view('header');
		$this->load->view('stock/stock_activity_list', $data);   // ← your new view file
		$this->load->view('footer');
	}
	 
	// ─── GET COUNTS FOR STAT PILLS (AJAX) ───
	// GET /Stock_Transfer/get_counts
	public function get_counts() {
		$counts = $this->Stock_transaction_model->get_activity_counts();
		$this->response('success', $counts, 'Counts loaded');
	}
	 
	// ─── LIST (already exists but update it to join names) ───
	// Replace or update your existing list() method:
	public function list() {
		$filters = [
			'type'     => $this->input->get('type'),
			'status'   => $this->input->get('status'),
			'from'     => $this->input->get('from_date'),
			'to'       => $this->input->get('to_date'),
			'search'   => $this->input->get('search'),
			'store_id' => $this->input->get('store_id'),
		];
	 
		$transactions = $this->Stock_transaction_model->get_transactions_with_names($filters);
		$this->response('success', $transactions, 'Transactions loaded');
	}
	// ─── LOAD EXISTING TRANSACTION FOR APPROVAL (LOCKED MODE) ───
	public function load_for_approval($id = null) {
		if (!$id) $id = $this->uri->segment(3);
		if (!$id) redirect('Stock_Transfer/activity_list');
		
		$transaction = $this->Stock_transaction_model->get_transaction($id);
		
		if (!$transaction) {
			$this->session->set_flashdata('error', 'Transaction not found');
			redirect('Stock_Transfer/activity_list');
		}
		
		if ($transaction->status !== 'pending') {
			$this->session->set_flashdata('warning', 'This transaction is already ' . $transaction->status);
			redirect('Stock_Transfer/activity_list');
		}
		
		// CRITICAL: Pass these to the view
		$data['transaction'] = $transaction;
		$data['allowed'] = $transaction->act_type;
		$data['is_locked'] = true;  // This must be set
		$data['warehouses'] = $this->Store_model->get_all_stores();
		$data['customers'] = $this->Customer_model->get_all();
		$data['allowed_modes'] = ['issue', 'transfer', 'return'];
		
		$this->load->view('header');
		$this->load->view('stock/st_tir', $data);
		$this->load->view('footer');
	}
}