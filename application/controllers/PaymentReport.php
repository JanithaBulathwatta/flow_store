<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentReport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		
        // Load model
        $this->load->model('PaymentReport_model');
        $this->load->model('crm/Customer_model');

    }

    /**
     * Payment Report  page
     */
    public function index()
    {
		$data['customers'] = $this->Customer_model->get_all();
		
		$this->load->view('header');
        $this->load->view('Sale/payment_report',$data);
		$this->load->view('footer');
		
	}
	
	public function payment_report_filter()
	{
		// Retrieve inputs from the filter form/AJAX request
		$customer_id    = $this->input->post('customer_id');
		$status = $this->input->post('status');
		$date_range     = $this->input->post('date_range');

		// Fetch the data
		$data = $this->PaymentReport_model->get_payment_report($customer_id, $status, $date_range);

		// Return JSON response for DataTables or custom frontend builders
		echo json_encode(['data' => $data]);
	}
}	