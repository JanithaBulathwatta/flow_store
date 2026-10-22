<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserType extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('crm/UserType_model');
    }


    public function index()
    {		
		$this->load->view('header');
        $this->load->view('crm/user_type/user_type');
		$this->load->view('footer');	
	}
	
		
	public function get_data()
	{
		if (ob_get_length()) ob_clean();

		$status = $this->input->post('status');

		$data = $this->UserType_model->get_all($status);

		return $this->output->set_content_type('application/json')->set_output(json_encode(['data'=>$data]));
	}
	
	
	public function store()
    {
		if($_POST['utId'] != ''){
			$this->UserType_model->update();
		}else{
			$this->UserType_model->create();
		}
		
    }
	
	public function view()
    {
		
		$id = $_GET['utId'];
        $User_type = $this->UserType_model->get_by_id((int)$id);
        if (!$User_type) {
            show_404();
        }
        $data = ['page_title' => 'User Type Details','User_type'=> $User_type];
		echo json_encode($data);
	
	}
	
			
	public function delete()
	{
		
		$id = $_GET['utId'];
		
		$this->UserType_model->delete($id);
		
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->UserType_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'User Types Not available']);
		}
	}
	
	public function update_status()
	{
		// Clear any previous buffer/notices
		if (ob_get_length()) ob_clean();

		$id = $this->input->post('utId');
		$status = $this->input->post('status');

		if (!$id) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['stt' => 'error', 'msg' => 'ID is missing']));
		}

		$this->db->where('ut_id', $id);
		$update = $this->db->update('sys_user_type', ['status' => $status]);

		if ($update) {
			$response = ['stt' => 'ok', 'msg' => 'Status updated to ' . $status];
		} else {
			$response = ['stt' => 'error', 'msg' => 'Database update failed'];
		}

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	//get counts
	public function get_counts() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $counts = $this->UserType_model->get_counts();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($counts));
    }

}	