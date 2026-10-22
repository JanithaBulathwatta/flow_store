<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {
	
	public function index(){
		
		$this->load->model('Grn/Grn_m');
		$this->load->model('crm/Supply_model');
		$this->load->model('crm/Staff_model');
		$this->load->model('crm/Product_model', 'product');
		$this->load->model('Settings_m','settings');
		
		$data ['store'] = $this->Grn_m->get_stores();
		$data ['sup'] = $this->Supply_model->get_all_suppliers();
		$data ['staff'] = $this->Staff_model->get_staff();
		$data ['products'] = $this->product->get_active();
		$data ['vat'] = $this->settings->get_vat_rate();
		$data ['nbt'] = $this->settings->get_nbt_rate();
		
		$this->load->view('header');
		$this->load->view('/grn/new_grn',$data);
		$this->load->view('footer');
	}
			
	public function grn_list(){	
		$this->load->model('Grn/Grn_m');
		$this->load->model('crm/Supply_model');
		$this->load->model('crm/Staff_model');
		$data ['store'] = $this->Grn_m->get_stores();	
		$data ['sup'] = $this->Supply_model->get_all_suppliers();	
		$data ['staff'] = $this->Staff_model->get_staff();
		
		$this->load->view('header');
		$this->load->view('grn/grn_list',$data);
		$this->load->view('footer');
	}
	
	public function get_product_price(){
		
		$product_id = $this->input->post('product_id');
		$product = $this->db->where('id',$product_id)->get('products')->row();

		echo json_encode(['selling_price'  => $product->price]);
		
	}
	
	public function save_grn(){
		$this->load->model('Grn/Grn_m');
		$this->Grn_m->save_grn();
	}
	
	public function filter()
    {
		$this->load->model('Grn/Grn_m');
        $filters = [
			'date_range'  => $this->input->get('date_range'),
			'fk_store_id' => $this->input->get('fk_store_id'),
			'fk_sup_id'   => $this->input->get('fk_sup_id'),
			'fk_user_id'  => $this->input->get('fk_user_id')
		];
		
		$data = $this->Grn_m->get_grn_list($filters);

		echo json_encode(['data' => $data]);
    }
	
	
	public function items()
	{
		$grn_id = $this->input->get('grn_id');
		$this->load->model('Grn/Grn_m');
		$items = $this->Grn_m->get_grn_items($grn_id);

		echo json_encode(['items' => $items]);
	}
	
	public function get_grn_counts()
	{
		$this->load->model('Grn/Grn_m');
		$data = $this->Grn_m->get_grn_counts();

		echo json_encode($data);
	}
	
}