<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_detail extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Stock_model');
        $this->load->helper('url');
    }

    public function index() {
        $product_id = $this->input->get('pid'); 
        
        if (!$product_id) {
            redirect('Stock_report');
            return;
        }
        
        $data = [
            'page_title' => 'Stock Detail',
            'product_id' => $product_id,
            'product' => $this->Stock_model->get_product_detail($product_id)
        ];
        
        if (!$data['product']) {
            show_404();
            return;
        }
        
        $this->load->view('header');
        $this->load->view('stock/stock_detail', $data);
        $this->load->view('footer');
    }

    public function get_kpi_data() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $product_id = $this->input->get('product_id');
        
        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            return;
        }
        
        $kpi = $this->Stock_model->get_product_kpi($product_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kpi));
    }

    public function get_warehouse_breakdown() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $product_id = $this->input->get('product_id');
        
        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            return;
        }
        
        $warehouses = $this->Stock_model->get_warehouse_breakdown($product_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $warehouses]));
    }

    public function get_batches() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $product_id = $this->input->get('product_id');
        
        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            return;
        }
        
        $batches = $this->Stock_model->get_product_batches($product_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $batches]));
    }

    public function get_serials() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $product_id = $this->input->get('product_id');
        
        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            return;
        }
        
        $serials = $this->Stock_model->get_product_serials($product_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $serials]));
    }

    public function get_transactions() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $product_id = $this->input->get('product_id');
        
        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            return;
        }
        
        $transactions = $this->Stock_model->get_product_transactions($product_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $transactions]));
    }
}
?>
