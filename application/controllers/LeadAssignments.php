<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadAssignments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Core
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

        // Models
        $this->load->model('crm/LeadAssignment_model', 'assignment');
        $this->load->model('crm/Lead_model', 'lead');
        $this->load->model('crm/User_model', 'user');

        // Auth check (AJAX-safe)
        //if (!$this->session->userdata('user_id')) {
            //show_404();
        //}
    }

    /**
     * AJAX: Assign / Reassign lead
     */
	 
    public function assign()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->form_validation->set_rules('lead_id', 'Lead', 'required|integer');
        $this->form_validation->set_rules('assigned_user_id', 'User', 'required|integer');

        if ($this->form_validation->run() === FALSE) {
            return $this->_json_error(validation_errors());
        }

        $lead_id = (int) $this->input->post('lead_id');
        $to_user = (int) $this->input->post('assigned_user_id');
        //$by_user = (int) $this->session->userdata('user_id');
        $by_user = '1';

        if (!$this->lead->exists($lead_id)) {
            return $this->_json_error('Invalid lead');
        }

        if (!$this->user->exists($to_user)) {
            return $this->_json_error('Invalid user');
        }

        // Assignment logic handled inside model (transaction-safe)
        $assigned_lead_id = $this->assignment->assign($lead_id, $to_user, $by_user);

		echo json_encode([
			'success' => true,
			'message' => 'Lead assigned successfully',
			'lead_id' => $assigned_lead_id
		]);
		

		/*if (!$assigned_lead_id) {
			return $this->_json_error('Failed to assign lead');
		}
				
		return $this->_json_success(
			'Lead assigned successfully',
			['lead_id' => $assigned_lead_id]
		);*/

        //$this->_json_success('Lead assigned successfully');
		
		//return $this->_json_success('Lead assigned successfully', ['lead_id' => $lead_id]);
		
    }

    /**
     * AJAX: Assignment history by lead
     */
    public function history($lead_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $lead_id = (int) $lead_id;

        if (!$this->lead->exists($lead_id)) {
            show_404();
        }

        $data['history'] = $this->assignment->get_history($lead_id);
	
		echo json_encode($data);

		/*$this->load->view('header');
        $this->load->view('crm/assignments/_history', $data);
		$this->load->view('footer');*/
    }

    /**
     * JSON success response
     */
   protected function _json_success($message = '', $data = [])
	{
		header('Content-Type: application/json');

		echo json_encode(array_merge([
			'success' => true,
			'message' => $message
		], $data));

		exit; // ← VERY IMPORTANT
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
