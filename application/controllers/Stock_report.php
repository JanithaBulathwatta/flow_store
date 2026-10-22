<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Stock_model');
        $this->load->model('Branch_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        $data = [
            'page_title' => 'Stock Report',
            'branches' => $this->Branch_model->get_active(),
            'categories' => $this->Stock_model->get_categories(),
            'stores' => $this->Stock_model->get_stores()
        ];
        
        $this->load->view('header');
        $this->load->view('stock/stock_report', $data);
        $this->load->view('footer');
    }

    public function get_kpi_data() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $kpi = $this->Stock_model->get_kpi_summary();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kpi));
    }

    public function filter() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $filters = [
            'search' => $this->input->post('search'),
            'warehouse_id' => $this->input->post('warehouse_id'),
            'branch_id' => $this->input->post('branch_id'),
            'category' => $this->input->post('category'),
            'stock_type' => $this->input->post('stock_type'),
            'date_from' => $this->input->post('date_from'),
            'date_to' => $this->input->post('date_to')
        ];
        
        $stock_data = $this->Stock_model->get_stock_report($filters);
		
        $response = [
            'data' => $stock_data,
            'count' => count($stock_data),
            'filters_applied' => $filters
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_batch_details() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $product_id = $this->input->get('product_id');
        
        if (!$product_id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Product ID is required']));
            return;
        }
        
        $batches = $this->Stock_model->get_product_batches($product_id);
        
        $response = [
            'success' => true,
            'batches' => $batches
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    public function get_product_stock() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $product_id = $this->input->get('product_id');
        
        if (!$product_id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Product ID is required']));
            return;
        }
        
        $stock = $this->Stock_model->get_product_stock($product_id);
        
        $response = [
            'success' => true,
            'stock' => $stock
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function quick_adjust() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $this->form_validation->set_rules('product_id', 'Product', 'required|integer');
        $this->form_validation->set_rules('warehouse_id', 'Warehouse', 'required|integer');
        $this->form_validation->set_rules('adjustment_qty', 'Adjustment Quantity', 'required|numeric');
        $this->form_validation->set_rules('remarks', 'Remarks', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => validation_errors()
            ]);
            return;
        }
        
        $data = [
            'product_id' => $this->input->post('product_id', TRUE),
            'warehouse_id' => $this->input->post('warehouse_id', TRUE),
            'adjustment_qty' => $this->input->post('adjustment_qty', TRUE),
            'mode' => $this->input->post('mode', TRUE),
            'remarks' => $this->input->post('remarks', TRUE),
            'created_by' => $this->session->userdata('user_id') ?? 1
        ];
        
        $result = $this->Stock_model->quick_adjustment($data);
        
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Stock adjusted successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to adjust stock'
            ]);
        }
    }

   
}
