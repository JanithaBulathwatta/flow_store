<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
		$this->load->helper('url');
        $this->load->model('Sale_model');
        $this->load->model('crm/Customer_model');
        $this->load->model('crm/Sale_model');
        $this->load->model('Store_model');
		$this->load->model('crm/Staff_model');
		
    }

    public function index() {
		$data['cus']=$this->Customer_model->get_all();
		$data['staff']=$this->Sale_model->get_sale_staff();
		$data['store']=$this->Store_model->get_all_stores();
		
        $this->load->view('header');
        $this->load->view('Sale/sales_invoice',$data);
        $this->load->view('footer');
		
    }
	
	public function sale_2() {
		$data['cus']=$this->Customer_model->get_all();
		$data['staff']=$this->Sale_model->get_sale_staff();
		$data['store']=$this->Store_model->get_all_stores();
		
        $this->load->view('header');
        $this->load->view('Sale/sales_invoice2',$data);
        $this->load->view('footer');
		
    }
	
	public function sale_list() {	

		$data ['staff'] = $this->Staff_model->get_staff();
		
        $this->load->view('header');
        $this->load->view('Sale/sales_list',$data);
        $this->load->view('footer');
		
    }
	
	public function get_data(){
		
		$filters = $this->input->get();
		$data = $this->Sale_model->get_invoices($filters);
		echo json_encode($data);
		
	}
	
	public function get_customers_ajax()
	{
		$cus = $this->Customer_model->get_all();
		$formatted = [];
		foreach ($cus as $c) {
			$formatted[$c->cus_id] = [
				'name' => $c->cus_name,
				'phone' => $c->cus_phone,
				'email' => $c->cus_email,
				'creditLimit' => (float)$c->max_credit_limit,
				'outstanding' => (float)$c->current_credit_amt,
				'creditEnabled' => (bool)$c->is_credit,
				'creditUsed' => (float)$c->current_credit_amt,
			];
		}
		header('Content-Type: application/json');
		echo json_encode($formatted);
	}
	
	public function get_products_ajax()
	{
		$products = $this->Sale_model->getProducts(); // your data
		$formatted = [];
		foreach ($products as $p) {
			$formatted[] = [
				'id' => $p['id'], //?: $p['code'], // fallback if empty
				'code' => $p['code'],
				'name' => $p['name'],
				'icon' => '📦', // default (you can improve later)
				'unit' => $p['unit'] ?: 'Pcs',
				'category' => $p['category'] ?: 'General',

				'price' => (float)$p['price'],
				'wholesalePrice' => (float)$p['wholesalePrice'],
				'specialPrice' => (float)$p['specialPrice'],

				'stock' => (int)$p['stock'],

				'isSerial' => !empty($p['isSerial']),
				'isBatch' => !empty($p['isBatch']),
				'hasExpiry' => !empty($p['hasExpiry']),
				'hasWarranty' => !empty($p['hasWarranty']),

				'warrantyMonths' => (int)$p['warrantyMonths'],
				'warrantyType' => $p['warrantyType'] ?: null,

				'serials' => !empty($p['serials']) ? $p['serials'] : null,
				'batches' => !empty($p['batches']) ? $p['batches'] : null,

				'description' => $p['description'] ?? ''
			];
		}

		header('Content-Type: application/json');
		echo json_encode($formatted);
	}

	public function save_invoice(){
		
		if ($_POST['mode'] == 'complete'){
			if($_POST['inv_id'] == '0'){
				$this->Sale_model->save_sales();
			}else{
				$this->Sale_model->update_saved_draft();
			}
		}else{
			if($_POST['mode'] == 'complete' && $_POST['inv_id'] != '0'){
				toast('You Cannot save Draft As a Draft','danger');
			}else{
				$this->Sale_model->save_as_draft();
			}
		}
	}
	
	//public function get_invoice_ajax()
	public function get_invoice_ajax()
	{
		$id = $_GET['id'];
		$data = $this->Sale_model->get_invoice_with_items($id);
		header('Content-Type: application/json');
		echo json_encode($data);
	}
	
	
	//get single invoice item for delivery note
	public function delivery_note_items()
	{
		$id = $_GET['id'];
		$data = $this->Sale_model->delivery_note_items($id);
		header('Content-Type: application/json');
		echo json_encode($data);
	}
	
	public function delivery_note()
	{

	
	//$this->load->view('delivery_note/header');
	$this->load->view('delivery_note/delivery_note' );
	//$this->load->view('delivery_note/footer');		
		
			
	}
	
	public function print_invoice()
{
    $id = $this->input->get('id');
    
    if (!$id) {
        show_404();
    }
    
    $this->load->model('Sale_model');
    
    $data['invoice'] = $this->Sale_model->get_invoice_for_print($id);
    
    if (!$data['invoice']) {
        show_404();
    }
    
    $this->load->view('printView/sales_header', $data);
    $this->load->view('printView/sales_print', $data);
    $this->load->view('printView/sales_footer', $data);
}


public function view() {
	$id = $this->input->get('id');
	 
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
    $this->load->view('Sale/salse_view', $data);
    $this->load->view('footer');
}
	
}
?>