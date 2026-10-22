<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadComments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Core
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

        // Models
        $this->load->model('crm/LeadComment_model', 'comment');
        $this->load->model('crm/Lead_model', 'lead');

        // Auth check
        //if (!$this->session->userdata('user_id')) {
            //show_404(); // AJAX-safe
        //}
    }

    /**
     * AJAX: Get comments by lead
     */
    public function list($lead_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $lead_id = (int) $lead_id;

        if (!$this->lead->exists($lead_id)) {
            show_404();
        }

        $data['comments'] = $this->comment->get_by_lead($lead_id);

		echo json_encode($data);

        //$this->load->view('header');
		//$this->load->view('crm/comments/_list', $data);
		//$this->load->view('footer');
	}

    /**
     * AJAX: Store a new comment
     */
    public function store()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->form_validation->set_rules('lead_id', 'Lead', 'required|integer');
        $this->form_validation->set_rules('comment', 'Comment', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            return $this->_json_error(validation_errors());
        }

        $lead_id = (int) $this->input->post('lead_id');

        if (!$this->lead->exists($lead_id)) {
            return $this->_json_error('Invalid lead');
        }

        $this->comment->create([
            'lead_id'      => $lead_id,
            'comment'      => $this->input->post('comment', TRUE)
            //'commented_by' => $this->session->userdata('user_id')
        ]);

        //$this->_json_success('Comment added successfully');
		echo json_encode([
			'success' => true,
			'message' => 'Comment added successfully',
			'lead_id' => $lead_id
		]);
		
		exit;
    }

    /**
     * JSON success response
     */
    private function _json_success($message)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'message' => $message
            ]));
    }

    /**
     * JSON error response
     */
    private function _json_error($message)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false,
                'message' => strip_tags($message)
            ]));
    }
}
