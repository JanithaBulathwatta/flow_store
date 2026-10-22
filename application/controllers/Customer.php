<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller
{
	
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('crm/Customer_model');

    }
	
	/*Display voucher list*/
    public function index() 
    {
		$counts = $this->Customer_model->get_counts();
        $data = ['page_title' => 'Create Customer','counts' => $counts,];
        $this->load->view('header');   
        $this->load->view('crm/customer/customer',$data);
        $this->load->view('footer');   
    }
	
	
	public function customer_frm(){
		$this->load->view('header');   
        $this->load->view('crm/customer/customer_form');
        $this->load->view('footer');
	}
	
	public function get_data()
	{
		if (ob_get_length()) ob_clean();

		$status = $this->input->post('status');
		$data = $this->Customer_model->get_all($status);
		return $this->output->set_content_type('application/json')->set_output(json_encode(['data'=>$data]));
	}
	
	public function store()
    {
		if($_POST['lid'] != ''){
			$this->Customer_model->update();
		}else{
			$this->Customer_model->create();
		}   
    }
	
	public function view()
    {
		$id = $_GET['lid'];
        $customer = $this->Customer_model->get_by_id((int)$id);
        if (!$customer) {
            show_404();
        }
        $data = ['page_title' => 'Sub Category Details','customer'=> $customer];
		echo json_encode($data);
	}
	
	public function delete()
	{
		
		$id = $_GET['lid'];
		$this->Customer_model->delete($id);
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		if (!$this->Customer_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Lead Not available']);
		}
	}
	
	public function update_status()
	{
		// Clear any previous buffer/notices
		if (ob_get_length()) ob_clean();
		$id = $this->input->post('lid');
		$status = $this->input->post('status');
		if (!$id) {
			return $this->output->set_content_type('application/json')->set_output(json_encode(['stt' => 'error', 'msg' => 'ID is missing']));
		}
		$this->db->where('cus_id', $id);
		$update = $this->db->update('customer', ['cus_status' => $status]);
		if ($update) {
			$response = ['stt' => 'ok', 'msg' => 'Status updated to ' . $status];
		} else {
			$response = ['stt' => 'error', 'msg' => 'Database update failed'];
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
	//get counts
	public function get_counts() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $counts = $this->Customer_model->get_counts();
        $this->output->set_content_type('application/json')->set_output(json_encode($counts));
    }
	
	/*Get customer profile data for view*/
	public function get_profile()
	{
		if (ob_get_length()) ob_clean();
    
		$id = $this->input->get('lid');
    
		if (!$id) {
			return $this->output->set_content_type('application/json')->set_output(json_encode(['stt' => 'error', 'msg' => 'Customer ID required']));
		}
    
		$customer = $this->Customer_model->get_by_id((int)$id);
    
		if (!$customer) {
			return $this->output->set_content_type('application/json')->set_output(json_encode(['stt' => 'error', 'msg' => 'Customer not found']));
		}
    
		// You can also fetch additional data like invoices, payments here
		// For now, just return customer data
		return $this->output->set_content_type('application/json')->set_output(json_encode(['stt' => 'ok','customer' => $customer]));
	}

	/*Display customer profile page*/
	public function profile()
	{
		$id = $this->input->get('lid');
		if (!$id) {
			show_404();
		}
		$customer = $this->Customer_model->get_by_id((int)$id);
		if (!$customer || $customer->cus_status == 'delete') {
			show_404();
		}
		// Load invoices directly from database (like Supplier module)
		$invoices = $this->Customer_model->get_customer_invoices((int)$id);
		// Load payments directly from database
		$payments = $this->Customer_model->get_customer_payments((int)$id);
		// Get statistics
		$stats = $this->get_customer_stats((int)$id);
		$data = ['page_title' => 'Customer Profile - ' . $customer->cus_name,
				'customer' => $customer,
				'invoices' => $invoices,
				'payments' => $payments,
				'stats' => $stats];
		$this->load->view('header');
		$this->load->view('crm/customer/customerProfile', $data);
		$this->load->view('footer');
	}

	/*Get customer statistics*/
	private function get_customer_stats($customer_id)
	{
		// Get invoice statistics
		$this->db->select("COUNT(*) as total_invoices,
			SUM(CASE WHEN payment_status IN ('PAID') THEN grand_total ELSE 0 END) as total_paid,
			SUM(CASE WHEN payment_status IN ('UNPAID', 'PARTIAL') THEN balance_amount ELSE 0 END) as total_outstanding,
			COUNT(CASE WHEN payment_status IN ('UNPAID', 'PARTIAL') THEN 1 END) as outstanding_count,
			SUM(grand_total) as total_sales");
		$this->db->where('customer_id', $customer_id);
		$invoice_stats = $this->db->get('sales_invoices')->row();		
		return (object) $invoice_stats;
	}
	
	
}	