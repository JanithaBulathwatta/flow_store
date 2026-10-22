<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load required libraries & helpers
        $this->load->library(['session']);
        $this->load->helper(['url']);
		
		

        // Load model
        $this->load->model('crm/Sub_category_model');

    }

    /**
     * CRM Dashboard sub category page
     */
    public function index()
    {
		$super_categories = $this->db->get_where('super_category', ['status' => 'active'])->result();
		
        $data = [
            'page_title' => 'Create Sub Category',
			'super_categories' => $super_categories,

        ];
		
		$this->load->view('header');
        $this->load->view('crm/sub_category/sub_category', $data);
		$this->load->view('footer');
		
	}
	
		
	public function get_data()
	{
		if (ob_get_length()) ob_clean();

		$status = $this->input->post('status');

		$data = $this->Sub_category_model->get_all($status);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(['data'=>$data]));
	}
	
	
		public function store()
    {
		if($_POST['lid'] != ''){
			$this->Sub_category_model->update();
		}else{
			$this->Sub_category_model->create();
		}
		
    }
	
	    public function view()
    {
		
		$id = $_GET['lid'];
		
        $category = $this->Sub_category_model->get_by_id((int)$id);

        if (!$category) {
            show_404();
        }

        $data = ['page_title' => 'Sub Category Details','category'=> $category];
	
		echo json_encode($data);
		

	}
	
		
		
		public function delete()
	{
		
		$id = $_GET['lid'];
		
		$this->Sub_category_model->delete($id);
		
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->Sub_category_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Lead Not available']);
		}

		

	}
	
	public function update_status()
{
    // Clear any previous buffer/notices
    if (ob_get_length()) ob_clean();

    $id = $this->input->post('lid');
    $status = $this->input->post('status');

    if (!$id) {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['stt' => 'error', 'msg' => 'ID is missing']));
    }

    $this->db->where('id', $id);
    $update = $this->db->update('sub_category', ['status' => $status]);

    if ($update) {
        $response = ['stt' => 'ok', 'msg' => 'Status updated to ' . $status];
    } else {
        $response = ['stt' => 'error', 'msg' => 'Database update failed'];
    }
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'Sub Category Module','Update Sub Category','UPDATE');
	//end of activity log

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}

		//get counts
	    public function get_counts() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $counts = $this->Sub_category_model->get_counts();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($counts));
    }
	
	
	public function check_code_exists()
	{
		$code = $this->input->get('code', TRUE);
		$exclude_id = $this->input->get('exclude_id', TRUE);

		$this->db->where('code', $code);
		// If we are editing, don't flag the code of the record we are currently editing
		if ($exclude_id) {
			$this->db->where('id !=', (int)$exclude_id);
		}

		$exists = $this->db->get('sub_category')->num_rows() > 0;

		echo json_encode(['exists' => $exists]);
	}

}	