<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
		$this->load->helper('url');
        $this->load->model('crm/Activity_log_model');
        //$this->load->model('crm/Activity_log_model');
        //$this->load->library('form_validation');
       // $this->load->library('session');
        
        // CSRF Protection for AJAX requests  
        if ($this->input->is_ajax_request()) {
            $csrf_name = $this->security->get_csrf_token_name();
            $csrf_hash = $this->input->post($csrf_name) ?: $this->input->get($csrf_name);
            
             
        }
    }

    /**
     * Display activity log list
     */
    public function activity_log() 
    {
		//$counts = $this->Customer_model->get_counts();
		$user = $this->db->get_where('user')->result();
		$module = $this->db->get_where('modules')->result();
	    
        $data = [
            'page_title' => 'Create Voucher',

			'users'=>$user,
			'modules'=>$module,
			//'counts' => $counts,

        ];
		
        $this->load->view('header'); 		
        $this->load->view('crm/activity_log/activity_log', $data); 
        $this->load->view('footer');   
    }
	
	    public function filter()
    {
        $date   = $this->input->post('date_range');
        $module = $this->input->post('module');   
        $user   = $this->input->post('user_type');

        $data = $this->Activity_log_model->get_filtered($date, $module, $user);

        echo json_encode(['data' => $data]);
    }
	
	public function get_data() {
    $logs = $this->Activity_log_model->get_all();
    
    // CodeIgniter 3 way to send JSON
    return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
            'data' => $logs
        ]));
}
	
	
	public function lead_view()
	{
		$lead_id = $this->input->get('lead_id');

		if (!$lead_id) {
			show_404();
		}

		$data['log'] = $this->Activity_log_model->get_by_id($lead_id);

		if (!$data['log']) {
			show_404();
		}

		//$this->load->view('crm/activity_log/view', $data);
	}
	
	public function view()
	{
		$id = $this->input->get('id');

		$customer = $this->Activity_log_model->get_by_id((int)$id);

		if (!$customer) {
			show_404();
		}

		$data = [
			'status' => true,
			'customer' => $customer
		];

		header('Content-Type: application/json');
		echo json_encode($data);
	}
} 