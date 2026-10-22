<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SaleView extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->model('Sale_model');
        $this->load->model('crm/Customer_model');
        $this->load->model('crm/Sale_model');
        $this->load->model('Store_model');
		
    }

    public function index($id) {

		if (!$id) show_404();

		$invoice = $this->Sale_model->get_invoice_details($id);
		if (!$invoice) show_404();

		$data = [
			'invoice'  => $invoice,
			'items'    => $this->Sale_model->get_invoice_items_simple($id),
			'payments' => $this->Sale_model->get_invoice_payments($id),
			'page_title' => 'Invoice ' . $invoice->invoice_no
		];

		$this->load->view('header');
		$this->load->view('sales/invoice_view', $data);
		$this->load->view('footer');
		
    }