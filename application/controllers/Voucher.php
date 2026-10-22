<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends CI_Controller
{
	
    public function __construct()
    {
        parent::__construct();
         
        $this->load->helper('url');
        $this->load->model('crm/Voucher_model');

    }
	
	/**Display voucher list**/
    public function index() 
    {
		
		$user = $this->db->get_where('user')->result();
		$counts = $this->Voucher_model->get_counts();
		
        $data = ['page_title' => 'Create Voucher','user'=>$user,'counts' => $counts,];
        $this->load->view('header');   
        $this->load->view('crm/voucher/voucher',$data);
        $this->load->view('footer');   
    }
	
	public function list_for_approvals(){
		
		$user = $this->db->get_where('user')->result();
		$counts = $this->Voucher_model->get_counts();
		
        $data = ['page_title' => 'Create Voucher','user'=>$user,'counts' => $counts,];
		
		$this->load->view('header');   
        $this->load->view('crm/voucher/voucher_list_for_approval',$data);
        $this->load->view('footer');   
	}
	
	public function get_data_for_approval(){
		
		$data = $this->Voucher_model->get_data_for_approval();
		return $this->output->set_content_type('application/json')->set_output(json_encode(['data'=>$data]));
	
	}
	
	public function approve(){
		
		$id = $_GET['lid'];
		$this->Voucher_model->approve($id);
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->Voucher_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Voucher Not available']);
		}
	}
	
	public function reject(){
		
		$id = $_GET['lid'];
		$this->Voucher_model->reject($id);
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->Voucher_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Voucher Not available']);
		}
	}
	
	
	public function print_voucher()
	{
		$id = $_GET['id'];
		
		$this->Voucher_model->issue($id);
		
		$voucher = $this->db->where('id', $id)->get('voucher')->row();

		if (!$voucher) {
			show_404();
		}
		$data['voucher'] = $voucher;
		$this->load->view('crm/voucher/print_voucher', $data);
	}
		
	public function get_data()
	{
		if (ob_get_length()) ob_clean();
		$status = $this->input->post('status');
		$data = $this->Voucher_model->get_all($status);
		return $this->output->set_content_type('application/json')->set_output(json_encode(['data'=>$data]));
	}
	
	
	public function store()
    {
		if($_POST['lid'] != ''){
			$this->Voucher_model->update();
		}else{
			$this->Voucher_model->create();
		}     
    }
	
	public function view()
    {
		
		$id = $_GET['lid'];
		
        $category = $this->Voucher_model->get_by_id((int)$id);

        if (!$category) {
            show_404();
        }

        $data = ['page_title' => 'Sub Category Details','category'=> $category];
	
		echo json_encode($data);
		
		
	}
	
		

		
	public function delete()
	{
		
		$id = $_GET['lid'];
		
		$this->Voucher_model->delete($id);
		
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->Voucher_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Lead Not available']);
		}
		

	}
	
	public function cancel()
	{
		
		$id = $_GET['lid'];
		
		$this->Voucher_model->cancel($id);
		
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->Voucher_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Lead Not available']);
		}
		

	}
	
	public function issue()
	{
		
		$id = $_GET['lid'];
		
		$this->Voucher_model->issue($id);
		
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->Voucher_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Voucher Not available']);
		}
		

	}
	
	//get counts
	public function get_counts() {
	if (!$this->input->is_ajax_request()) {
		show_404();
	}
	
	$counts = $this->Voucher_model->get_counts();
	
	$this->output
		->set_content_type('application/json')
		->set_output(json_encode($counts));
    }

}	