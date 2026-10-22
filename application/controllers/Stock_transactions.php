<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Stock_transactions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Stock_model');
        $this->load->helper('url');
    }

    public function index() {
        $product_id = $this->input->get('pid');
        
        $data = [
            'page_title' => 'Stock Transactions',
            'product_id' => $product_id,
            'stores' => $this->Stock_model->get_stores()
        ];
        
        if ($product_id) {
            $data['product'] = $this->Stock_model->get_product_detail($product_id);
        }
        
        $this->load->view('header');
        $this->load->view('stock/stock_transactions', $data);
        $this->load->view('footer');
    }

    public function get_kpi_data() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $filters = [
            'product_id' => $this->input->get('product_id'),
            'date_from' => $this->input->get('date_from'),
            'date_to' => $this->input->get('date_to'),
            'warehouse_id' => $this->input->get('warehouse_id'),
            'type' => $this->input->get('type')
        ];
        
        $kpi = $this->Stock_model->get_transaction_kpi($filters);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($kpi));
    }

    public function filter() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $filters = [
            'product_id' => $this->input->post('product_id'),
            'date_from' => $this->input->post('date_from'),
            'date_to' => $this->input->post('date_to'),
            'warehouse_id' => $this->input->post('warehouse_id'),
            'type' => $this->input->post('type'),
            'batch' => $this->input->post('batch'),
            'user' => $this->input->post('user'),
            'search' => $this->input->post('search'),
            'page' => $this->input->post('page', TRUE) ?? 1,
            'per_page' => $this->input->post('per_page', TRUE) ?? 20
        ];
        
        $result = $this->Stock_model->get_transactions_with_balance($filters);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }


}
?>
