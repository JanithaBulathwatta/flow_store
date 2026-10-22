<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 4/3/2026

class Supply extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
         
        $this->load->helper('url');
        $this->load->model('crm/Supply_model');
		 $this->load->model('crm/Bank_model');
		 $this->load->model('crm/BankAccount_model');
		 $this->load->model('crm/SupplierInvoice_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        
        // CSRF Protection for AJAX requests  
        if ($this->input->is_ajax_request()) {
            $csrf_name = $this->security->get_csrf_token_name();
            $csrf_hash = $this->input->post($csrf_name) ?: $this->input->get($csrf_name);
            
             
        }
    }

    /**
     * Display suppliers list
     */
    public function index() 
    {
        $data['title'] = 'Suppliers Management';
        
         
        $filters = [
            'search' => $this->input->get('search'),
            'status' => $this->input->get('status'),
            'date_range' => $this->input->get('date_range')
        ];
        
         
        $filters = array_filter($filters);
        
         
        $data['suppliers'] = $this->Supply_model->get_all_suppliers($filters);
        
         
        $data['counts'] = $this->Supply_model->get_counts();
        
         
        $data['filters'] = $filters;
		
		 
        $data['banks'] = $this->Bank_model->get_active_banks();
        
         
        $this->load->view('header', $data);   
        $this->load->view('crm/supply/supply', $data);
        $this->load->view('footer');   
    }

    /**
     * Store new supplier (AJAX)  
     */
    public function store() 
{
     
    
    $id = $this->input->post('id'); // Check for ID
    
    if ($id) {
         
        $this->Supply_model->update();
    } else {
         
        $this->Supply_model->create();
    }
}

    /**
     * Update supplier (AJAX)  
     */
    public function update() 
    {
        header('Content-Type: application/json');
        
         
        $this->Supply_model->update();
    }

    /**
 * Get supplier by ID (AJAX)  
 */
public function get_supplier() 
{
    header('Content-Type: application/json');
    
     
    $id = $this->input->get('id');
    
    if (!$id) {
        echo json_encode([
            'success' => false,
            'message' => 'Supplier ID is required!'
        ]);
        return;
    }
    
    $supplier = $this->Supply_model->get_supplier_by_id($id);
    
    if ($supplier) {
        echo json_encode([
            'success' => true,
            'supplier' => $supplier
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Supplier not found!'
        ]);
    }
}

    /**
     * Delete supplier (soft delete)  
     */
    public function delete() 
    {
        header('Content-Type: application/json');
        
          
        $id = $this->input->get('id');
        
        if (!$id) {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Invalid supplier ID!',
                'data' => ''
            ]);
            return;
        }
        
         
        $result = $this->Supply_model->delete_supplier($id);
        
        if ($result) {
            echo json_encode([
                'stt' => 'ok',
                'msg' => 'Supplier deleted successfully!',
                'data' => $id
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Failed to delete supplier!',
                'data' => ''
            ]);
        }
    }

    /**
     * Update supplier status (AJAX)  
     */
    public function update_status() 
    {
        header('Content-Type: application/json');
        
         
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        
        if (!$id) {
            echo json_encode([
                'success' => false,
                'message' => 'Supplier ID is required!'
            ]);
            return;
        }
        
        if (!in_array($status, ['active', 'inactive', 'deleted'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid status!'
            ]);
            return;
        }
        
        $result = $this->Supply_model->update_status($id, $status);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update status!'
            ]);
        }
    }

    /**
     * Get counts for mini cards (AJAX)
     */
    public function get_counts() 
    {
        header('Content-Type: application/json');
        
        $counts = $this->Supply_model->get_counts();
        
        echo json_encode([
           // 'success' => true,
            'active_count' => $counts->active_count,
            'inactive_count' => $counts->inactive_count,
            'deleted_count' => $counts->deleted_count,
            'total_count' => $counts->total_count
        ]);
    }
	
	
	 /**
 * Get filtered suppliers as JSON (for AJAX table loading)
  
 */
public function get_filtered_suppliers() 
{
    header('Content-Type: application/json');
    
    if (!$this->input->is_ajax_request()) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
    $filters = [
        'search' => $this->input->post('search'),
        'status' => $this->input->post('status'),
        'date_range' => $this->input->post('date_range')
    ];
    
     
    log_message('debug', 'Received filters: ' . print_r($filters, true));
    
     
    $filters = array_filter($filters);
    
     
    $suppliers = $this->Supply_model->get_all_suppliers($filters);
    
    echo json_encode([
        'success' => true,
        'data' => $suppliers,
        'received_filters' => $filters  
    ]);
}
	
	// ===========================
    // ✅ SUPPLLIERS INVOICE CODES ARE STARTING HERE ----> //santhosh(2026-03-24)
    // ===========================
	
	
	public function supplier_invoice(){
		
		$data['banks'] = $this->Bank_model->get_active_banks();
		$data['banks_acc'] = $this->BankAccount_model->get_all();
		$pay_accounts = $this->BankAccount_model->get_pay_accounts();
		$data['pay'] = $pay_accounts;
		
		// ✅ Automatically set the first account's ID as the default value if it exists
		$data['default_account_id'] = (!empty($pay_accounts)) ? $pay_accounts[0]->bank_acc_id : '';
		
		$this->load->view('header');   
        $this->load->view('crm/supply/supplier_invoice',$data);
        $this->load->view('footer');   
	}
	
	// get all invoices
	public function get_invoices(){
		if (ob_get_length()) ob_clean();

		// Call the new model method
		$data = $this->SupplierInvoice_model->get_all_invoices();

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(['data' => $data]));
	}
	
	public function process_payment()
	{
		
		// Call the model to handle DB transactions
		$result = $this->SupplierInvoice_model->create_payment();

		if ($result) {
			echo json_encode(['stt' => 'ok', 'msg' => 'Payment processed successfully']);
		} else {
			echo json_encode(['stt' => 'error', 'msg' => 'Failed to save payment']);
		}
	}
	

	
	// Check if the cheque is available
	public function check_cheque_availability() {
		$cheque_no = $this->input->post('cheque_no');

		// Query for complete structural tracking profile criteria
		$cheque_data = $this->SupplierInvoice_model->get_unused_cheque_details($cheque_no);

		if ($cheque_data) {
			echo json_encode([
				'available'       => true,
				'bank_account_id' => $cheque_data->bank_account_id,
				'cheque_book_id'  => $cheque_data->cheque_book_id,
				'bank_name'       => $cheque_data->bank_name,
				'account_number'  => $cheque_data->account_number
			]);
		} else {
			echo json_encode([
				'available' => false,
				'message'   => 'Cheque number not found or already used.'
			]);
		}
	}
		
	// GET SUM AND COUNTS OF THE INVOICES
	public function get_stats() {
		if (!$this->input->is_ajax_request()) { show_404(); }
		
		$stats = $this->SupplierInvoice_model->get_stats();
		
		echo json_encode($stats);
	}
	
	// GET INVOICES HISTORY BY ID
	public function view_history() {
		
		$id = $this->input->get('invId');
		
		if (!$this->input->is_ajax_request()) { show_404(); }
		
		$history = $this->SupplierInvoice_model->get_invoice_history($id);
		echo json_encode($history);
	}
	
	public function cancel_invoice()
	{
		
		$id = (int)$this->input->post('id');

		if (!$id) {
			echo json_encode(['stt' => 'error', 'msg' => 'Invalid Invoice ID!', 'data' => '']);
			return;
		}

		$result = $this->SupplierInvoice_model->cancel_supplier_invoice($id);

		if ($result) {
			echo json_encode([
				'stt'  => 'ok',
				'msg'  => 'Invoice Cancelled Successfully!',
				'data' => $id
			]);
		} else {
			echo json_encode([
				'stt'  => 'error',
				'msg'  => 'Database error or Invoice already processed!',
				'data' => ''
			]);
		}
	}
	
	
/**
 * Display supplier profile page
 * @param int $id Supplier ID
 */
public function supplier_profile($id = null)
{
    // If no ID from parameter, try to get from GET (like Customer pattern)
    if (!$id) {
        $id = $this->input->get('id');
    }
    
    // Validate ID
    if (!$id || !is_numeric($id)) {
        $this->session->set_flashdata('error', 'Invalid supplier ID');
        redirect('Supply');
        return;
    }
    
    // Get supplier details
    $supplier = $this->Supply_model->get_supplier_by_id((int)$id);
    
    if (!$supplier) {
        show_404('Supplier not found');
        return;
    }
    
    // Get supplier statistics
    $stats = $this->get_supplier_stats((int)$id);
    
    // Get supplier invoices
    $invoices = $this->SupplierInvoice_model->get_supplier_invoices((int)$id);
    
    // Get supplier payments
    $payments = $this->get_supplier_payments((int)$id);
    
    // Prepare data for view
    $data = [
        'supplier' => $supplier,
        'stats' => $stats,
        'invoices' => $invoices,
        'payments' => $payments,
        'title' => $supplier->name . ' - Profile'
    ];
    
    // Load views
    $this->load->view('header', $data);
    $this->load->view('crm/supply/supplierProfile', $data);
    $this->load->view('footer');
}

/**
 * Get supplier statistics for profile page
 */
private function get_supplier_stats($supplier_id)
{
    // Get invoice statistics - Total Purchases = sum of ALL invoice amounts
    $this->db->select("
        COUNT(*) as total_invoices,
        SUM(grand_total) as total_sales,   
          
        COUNT(CASE WHEN status IN ('unpaid', 'partial') THEN 1 END) as outstanding_count
    ");
    $this->db->where('supplier_id', $supplier_id);
    $invoice_stats = $this->db->get('supplier_invoices')->row();
    
    // Get payment statistics - Total Paid = sum of ALL payment amounts
    $this->db->select("
        COUNT(*) as total_payments,
        SUM(amount) as total_paid   
    ");
    $this->db->where('supplier_id', $supplier_id);
    $this->db->where('status', 'active');
    $payment_stats = $this->db->get('supplier_payments')->row();
	
	// Merge the stats
    $stats = (object) array_merge((array)$invoice_stats, (array)$payment_stats);
	
	// Calculate Outstanding = Total Purchases - Total Paid
    $stats->total_outstanding = ($stats->total_sales ?? 0) - ($stats->total_paid ?? 0);
    
    return $stats;
}

/**
 * Get supplier payments
 */
private function get_supplier_payments($supplier_id)
{
    return $this->db
        ->select("
            sp.*,
            spa.invoice_id,
            si.invoice_number
        ")
        ->from('supplier_payments sp')
        ->join('supplier_payment_allocations spa', 'spa.payment_id = sp.id', 'left')
        ->join('supplier_invoices si', 'si.id = spa.invoice_id', 'left')
        ->where('sp.supplier_id', $supplier_id)
        ->where('sp.status', 'active')
        ->order_by('sp.payment_date', 'DESC')
        ->get()
        ->result();
}

/**
 * Get supplier profile data via AJAX
 */
public function get_profile_data()
{
    header('Content-Type: application/json');
    
    if (!$this->input->is_ajax_request()) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        return;
    }
    
    $id = $this->input->post('id') ?: $this->input->get('id');
    
    if (!$id || !is_numeric($id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid supplier ID']);
        return;
    }
    
    // Get supplier details
    $supplier = $this->Supply_model->get_supplier_by_id((int)$id);
    
    if (!$supplier) {
        echo json_encode(['success' => false, 'message' => 'Supplier not found']);
        return;
    }
    
    // Get supplier statistics
    $stats = $this->get_supplier_stats((int)$id);
    
    // Get supplier invoices
    $invoices = $this->SupplierInvoice_model->get_supplier_invoices((int)$id);
    
    // Get supplier payments
    $payments = $this->get_supplier_payments((int)$id);
    
    echo json_encode([
        'success' => true,
        'supplier' => $supplier,
        'stats' => $stats,
        'invoices' => $invoices,
        'payments' => $payments
    ]);
}

/**
 * Get supplier invoices via AJAX (only for table data)
 */
public function get_supplier_invoices_ajax()
{
    if (!$this->input->is_ajax_request()) return;
    
    $supplier_id = $this->input->post('supplier_id');
    $status = $this->input->post('status');
    
    // Get invoices - use existing columns
    $this->db->select('id, invoice_number, invoice_date, due_date, grand_total, paid_amount, balance_amount, status');
    $this->db->where('supplier_id', $supplier_id);
    if ($status && $status != 'all') {
        $this->db->where('status', $status);
    }
    $this->db->order_by('invoice_date', 'DESC');
    $invoices = $this->db->get('supplier_invoices')->result();
    
    echo json_encode(['success' => true, 'invoices' => $invoices]);
}

/**
 * Get supplier payments via AJAX (only for table data)
 */
public function get_supplier_payments_ajax()
{
    if (!$this->input->is_ajax_request()) return;
    
    $supplier_id = $this->input->post('supplier_id');
    
    $payments = $this->db
        ->select("
            sp.*,
            spa.invoice_id,
            si.invoice_number
        ")
        ->from('supplier_payments sp')
        ->join('supplier_payment_allocations spa', 'spa.payment_id = sp.id', 'left')
        ->join('supplier_invoices si', 'si.id = spa.invoice_id', 'left')
        ->where('sp.supplier_id', $supplier_id)
        ->where('sp.status', 'active')
        ->order_by('sp.payment_date', 'DESC')
        ->get()
        ->result();
    
    echo json_encode(['success' => true, 'payments' => $payments]);
}
	
	
}