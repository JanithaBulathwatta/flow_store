<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesReport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		
        // Load model
        $this->load->model('SalesReport_model');
        $this->load->model('crm/Sub_category_model');
        $this->load->model('crm/Brand_model');

    }

    /**
     * Sales Report  page
     */
    public function index()
    {
		$data['sub_categories'] = $this->Sub_category_model->get_all();
		$data['brands'] = $this->Brand_model->get_all_brands();
		
		$this->load->view('header');
        $this->load->view('Sale/sales_report',$data);
		$this->load->view('footer');
		
	}
	
	public function sales_report_filter()
	{
		// Retrieve inputs from the filter form/AJAX request
		$category_id    = $this->input->post('category_id');
		$brand     = $this->input->post('brand');
		$date_range     = $this->input->post('date_range');
		

		// Fetch the data
		$data = $this->SalesReport_model->get_sales_report($category_id, $brand, $date_range);

		// Return JSON response for DataTables or custom frontend builders
		echo json_encode(['data' => $data]);
	}
}	