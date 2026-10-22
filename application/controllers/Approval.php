<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Approval_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

	public function index(){
		$this->load->view('header');
		$this->load->view('Approval/approval_list');
		$this->load->view('footer');
	}
	
	/*public function get_data(){
		$a = $this->Approval_model->get_data();
		echo json_encode($a);
	}*/
	
	public function get_data() {
		// Capture the inputs from the AJAX request
		$filters = [
			'search'   => $this->input->get('search'),
			'status'   => $this->input->get('status'),
			'type'     => $this->input->get('type'),
			'priority' => $this->input->get('priority')
		];
		$data = $this->Approval_model->get_data($filters);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function approve(){
		$this->Approval_model->approve_request();
	}

	public function reject(){
		$this->Approval_model->reject_request();
	}

	public function hold(){
		$this->Approval_model->hold_request();
	}

	public function relese(){
		$this->Approval_model->relese_request();
	}

}
