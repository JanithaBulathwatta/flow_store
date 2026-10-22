<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load required libraries & helpers
        $this->load->library(['session']);
        $this->load->helper(['url']);

        // Load model
        $this->load->model('crm/Dashboard_model', 'dashboard');

        // Authentication check
        /*if (!$this->session->userdata('user_id')) {
          redirect('Auth/login');
        }*/
    }

    /**
     * CRM Dashboard main page
     */
    public function index()
    {
        $user_id = (int) $this->session->userdata('user_id');
        $role    = $this->session->userdata('role');

        $data = [
            'page_title'     => 'Dashboard',
            'total_leads'    => $this->dashboard->get_total_leads(),
            'leads_by_status'=> $this->dashboard->get_leads_by_status(),
            'my_leads'       => $this->dashboard->get_user_leads($user_id),
            'recent_leads'   => $this->dashboard->get_recent_leads(10),
			'my_open_leads'   => $this->dashboard->get_user_open_leads($user_id),
            'role'           => $role
        ];
		
		$this->load->view('header');
        $this->load->view('crm/dashboard/index', $data);
		$this->load->view('footer');
	}

    /**
     * AJAX: Refresh dashboard stats
     */
    public function refresh_stats()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $user_id = (int) $this->session->userdata('user_id');

        $response = [
            'total_leads'     => $this->dashboard->get_total_leads(),
            'leads_by_status' => $this->dashboard->get_leads_by_status(),
            'my_open_leads'   => $this->dashboard->get_user_open_leads($user_id)
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
