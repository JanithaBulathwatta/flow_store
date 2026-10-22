<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Core libraries & helpers
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

        // Models
        $this->load->model('crm/Lead_model', 'lead');
        $this->load->model('crm/LeadStatus_model', 'status');
        $this->load->model('crm/Product_model', 'product');
        $this->load->model('crm/User_model', 'user'); // for assignment dropdowns
		$this->load->model('crm/LeadComment_model', 'comment');
		$this->load->model('crm/LeadAssignment_model', 'assignment');
    
    }

	public function get_lead_counts_ajax()
	{
		$this->load->model('Lead_model');
		$data = $this->Lead_model->get_status_counts_single_row();
	
		echo json_encode($data);
	}

    /*List leads*/
    public function index()
    {
        $data = [
            'page_title' => 'Leads',
            'leads'      => $this->lead->get_all(),
			'page_title' => 'Create Lead',
            'statuses'   => $this->status->get_active(),
            'products'   => $this->product->get_active(),
            'users'      => $this->user->get_active_staff()
        ];
		
		$this->load->view('header');
        $this->load->view('crm/leads/index', $data);
		$this->load->view('footer');
	}
	
	public function filter()
	{
		$date     = $this->input->post('date');
		$product  = $this->input->post('product_id');
		$status   = $this->input->post('status_id');
		$priority = $this->input->post('priority');

		$data = $this->lead->get_filtered($date, $product, $status, $priority);

		echo json_encode(['data' => $data]);
	}

    /**
     * Show create lead form
     */
    public function create()
    {
        $data = [
            'page_title' => 'Create Lead',
            'statuses'   => $this->status->get_active(),
            'products'   => $this->product->get_active(),
            'users'      => $this->user->get_active_users()
        ];
		
		$this->load->view('header');
        $this->load->view('crm/leads/create', $data);
		$this->load->view('footer');
	}

    /**
     * Store lead
     */
    /*public function store()
    {
        $this->_set_validation_rules();

        if ($this->form_validation->run() === FALSE) {
            return $this->create();
        }

        $data = [
            'customer_name'     => $this->input->post('customer_name', TRUE),
            'customer_email'    => $this->input->post('customer_email', TRUE),
            'customer_phone'    => $this->input->post('customer_phone', TRUE),
            'source'            => $this->input->post('source', TRUE),
            'product_id'        => $this->input->post('product_id'),
            'status_id'         => $this->input->post('status_id'),
            'assigned_user_id'  => $this->input->post('assigned_user_id'),
            'priority'          => $this->input->post('priority'),
            'notes'             => $this->input->post('notes', TRUE)
            //'created_by'        => $this->session->userdata('user_id')
        ];

        $lead_id = $this->lead->create($data);
		
		print_r($lead_id);
		exit;

		if($lead_id){
			echo json_encode(array("stt"=>"ok","msg"=>"Lead Created Successfully naden!!","data"=>$lead_id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}
		
        //$this->session->set_flashdata('success', 'Lead created successfully');
        //redirect('leads/view/' . $lead_id);
    }*/
	
	public function store()
    {
		if($_POST['lid'] != ''){
			$this->lead->update();
		}else{
			$this->lead->create();
		}
		
        //$this->session->set_flashdata('success', 'Lead created successfully');
        //redirect('leads/view/' . $lead_id);
    }

    /**
     * View lead details
     */
    public function view()
    {
		
		$id = $_GET['lid'];
		
        $lead = $this->lead->get_by_id((int)$id);

        if (!$lead) {
            show_404();
        }

        $data = ['page_title' => 'Lead Details','lead'=> $lead];
	
		echo json_encode($data);
		
		//$this->load->view('header');
        //$this->load->view('crm/leads/view', $data);
		//$this->load->view('footer');
	}

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $lead = $this->lead->get_by_id((int)$id);

        if (!$lead) {
            show_404();
        }

        $data = [
            'page_title' => 'Edit Lead',
            'lead'       => $lead,
            'statuses'   => $this->status->get_active(),
            'products'   => $this->product->get_active(),
            'users'      => $this->user->get_active_users()
        ];
		
		echo json_encode($data);
		
		//$this->load->view('header');
        //$this->load->view('crm/leads/edit', $data);
		//$this->load->view('footer');
	}

    /*Update lead*/
    public function update($id)
    {
        $this->_set_validation_rules();

        if ($this->form_validation->run() === FALSE) {
            return $this->edit($id);
        }

        $data = [
            'customer_name'    => $this->input->post('customer_name', TRUE),
            'customer_email'   => $this->input->post('customer_email', TRUE),
            'customer_phone'   => $this->input->post('customer_phone', TRUE),
            'source'           => $this->input->post('source', TRUE),
            'product_id'       => $this->input->post('product_id'),
            'status_id'        => $this->input->post('status_id'),
            'assigned_user_id' => $this->input->post('assigned_user_id'),
            'priority'         => $this->input->post('priority'),
            'notes'            => $this->input->post('notes', TRUE)
        ];

        $this->lead->update((int)$id, $data, $this->session->userdata('user_id'));

        $this->session->set_flashdata('success', 'Lead updated successfully');
        redirect('leads/view/' . $id);
    }

    /**
     * AJAX: Change lead status
     */
    public function change_status()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->lead->change_status(
            (int)$this->input->post('lead_id'),
            (int)$this->input->post('status_id'),
            //$this->session->userdata('user_id')
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true]));
    }

    /**
     * Validation rules
     */
    private function _set_validation_rules()
    {
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required|trim');
        $this->form_validation->set_rules('customer_email', 'Email', 'valid_email|trim');
        $this->form_validation->set_rules('customer_phone', 'Phone', 'trim');
        $this->form_validation->set_rules('status_id', 'Status', 'required|integer');
        $this->form_validation->set_rules('assigned_user_id', 'Assigned User', 'required|integer');
    }
	
	public function delete()
	{
		
		$id = $_GET['lid'];
		
		$this->lead->delete($id);
		
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->lead->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Lead Not available']);
		}

		

		//$this->_json_success('Lead deleted successfully');
		/*echo json_encode([
			'success' => true,
			'message' => 'Lead Deleted successfully'
		]);*/
	}
	
	
	public function lead_view(){
		
		$data = [
            'page_title' => 'Leads',
            'leads'      => $this->lead->get_all(),
			'page_title' => 'Create Lead',
            'statuses'   => $this->status->get_active(),
            'products'   => $this->product->get_active(),
            //'users'      => $this->user->get_active_users()
            'users'      => $this->user->get_marketing_users()
        ];
		
		$this->load->view('header');
		$this->load->view('lead_view',$data);
		$this->load->view('footer');
	}


	public function list(){
		
		$lead_id = $_GET['lid'];
		
		
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //$lead_id = (int) $lead_id;

        /*if (!$this->lead->exists($lead_id)) {
            show_404();
        }*/

        $data['comments'] = $this->comment->get_by_lead($lead_id);

		echo json_encode($data);

        //$this->load->view('header');
		//$this->load->view('crm/comments/_list', $data);
		//$this->load->view('footer');
	}
	
	/*AJAX: Store a new comment*/
    public function store_comment()
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
	
	/*AJAX: Assignment history by lead*/
    public function history()
    {
		
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        //$lead_id = (int) $lead_id;
        $lead_id = $_GET['lid'];

        if (!$this->lead->exists($lead_id)) {
            show_404();
        }

        $data['history'] = $this->assignment->get_history($lead_id);
	
		echo json_encode($data);

		/*$this->load->view('header');
        $this->load->view('crm/assignments/_history', $data);
		$this->load->view('footer');*/
    }
	
	/*AJAX: Assign / Reassign lead*/
	 
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
        $by_user = (int) $this->session->userdata('user_id');

        /*if (!$this->lead->exists($lead_id)) {
            return $this->_json_error('Invalid lead');
        }
	
        if (!$this->user->exists($to_user)) {
            return $this->_json_error('Invalid user');
        }*/

        // Assignment logic handled inside model (transaction-safe)
        $assigned_lead_id = $this->assignment->assign($lead_id, $to_user, $by_user);

		echo json_encode(['success' => true,'message' => 'Lead assigned successfully','lead_id' => $assigned_lead_id]);
		

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
	
}
