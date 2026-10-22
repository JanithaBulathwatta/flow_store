<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadStatuses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Core
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

        // Model
        $this->load->model('crm/LeadStatus_model', 'status');

        // Auth check
       // if (!$this->session->userdata('user_id')) {
            //redirect('login');
        //}
    }

    /**
     * List lead statuses
     */
    public function index()
    {
        $data = [
            'page_title' => 'Lead Statuses',
            'statuses'   => $this->status->get_all()
        ];

		$this->load->view('header');
        $this->load->view('crm/statuses/index', $data);
		$this->load->view('footer');
	}

    /**
     * Show create form
     */
    public function create()
    {
        $data['page_title'] = 'Create Lead Status';
		$this->load->view('header');
        $this->load->view('crm/statuses/create', $data);
		$this->load->view('footer');
	}

    /**
     * Store status
     */
    public function store()
    {
        $this->_set_validation_rules();

        if ($this->form_validation->run() === FALSE) {
            return $this->create();
        }

        $data = [
            'name'       => $this->input->post('name', TRUE),
            'color'      => $this->input->post('color', TRUE),
            'sort_order' => (int) $this->input->post('sort_order'),
            'is_active'  => 1
        ];

        $this->status->create($data);

        $this->session->set_flashdata('success', 'Lead status created successfully');
        redirect('leadstatuses');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $status = $this->status->get_by_id((int)$id);

        if (!$status) {
            show_404();
        }

        $data = [
            'page_title' => 'Edit Lead Status',
            'status'     => $status
        ];
		$this->load->view('header');
        $this->load->view('crm/statuses/edit', $data);
		$this->load->view('footer');
    }

    /**
     * Update status
     */
    public function update($id)
    {
        $this->_set_validation_rules();

        if ($this->form_validation->run() === FALSE) {
            return $this->edit($id);
        }

        $data = [
            'name'       => $this->input->post('name', TRUE),
            'color'      => $this->input->post('color', TRUE),
            'sort_order' => (int) $this->input->post('sort_order'),
            'is_active'  => (int) $this->input->post('is_active')
        ];

        $this->status->update((int)$id, $data);

        $this->session->set_flashdata('success', 'Lead status updated successfully');
        redirect('leadstatuses');
    }

    /**
     * Validation rules
     */
    private function _set_validation_rules()
    {
        $this->form_validation->set_rules('name', 'Status Name', 'required|trim');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'integer');
    }
}
