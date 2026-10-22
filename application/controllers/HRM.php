<?php
//madhushika(2026-03-11)
defined('BASEPATH') OR exit('No direct script access allowed');

class HRM extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crm/Leave_model');
        $this->load->helper('form');
        $this->load->library(['form_validation','session']);
		 $this->load->helper('url'); 
    }
	public function index()
	{
		redirect('HRM/leave_manage');
	}
		public function leave_manage() {
			$data['title'] = 'Leave Management';
			$data['leave_types'] = $this->Leave_model->get_leave_types();
			$data['employees'] = $this->Leave_model->get_employees();
			$data['branches'] = $this->Leave_model->get_branches();
			
			$this->load->view('header');
			$this->load->view('crm/leave/leave_list', $data);
			$this->load->view('footer');
		}

    public function filter() {
        $post_data = $this->input->post();
        
        // Get date range
        $date_range = isset($post_data['date']) ? $post_data['date'] : '';
        $dates = explode(' - ', $date_range);
        $start_date = isset($dates[0]) ? trim($dates[0]) : '';
        $end_date = isset($dates[1]) ? trim($dates[1]) : '';
        
        $filters = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'employee_id' => isset($post_data['employee_id']) ? $post_data['employee_id'] : '',
			'branch_id' => isset($post_data['branch_id']) ? $post_data['branch_id'] : '',
            'status' => isset($post_data['status']) ? $post_data['status'] : '',
            'leave_type_id' => isset($post_data['leave_type_id']) ? $post_data['leave_type_id'] : ''
        ];
        
        $data['requests'] = $this->Leave_model->get_filtered_requests($filters);
        
        echo json_encode(['data' => $data['requests']]);
    }

    public function store() {
    $this->form_validation->set_rules('employee_id', 'Employee', 'required');
    $this->form_validation->set_rules('leave_type_id', 'Leave Type', 'required');
    $this->form_validation->set_rules('start_date', 'Start Date', 'required');
    $this->form_validation->set_rules('end_date', 'End Date', 'required');
    $this->form_validation->set_rules('total_days', 'Total Days', 'required|numeric');
    $this->form_validation->set_rules('reason', 'Reason', 'required');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode(['success' => false, 'message' => validation_errors()]);
        return;
    }

    $data = [
        'employee_id' => $this->input->post('employee_id'),
        'branch_id' => $this->input->post('branch_id'),
        'leave_type_id' => $this->input->post('leave_type_id'),
        'start_date' => $this->input->post('start_date'),
        'end_date' => $this->input->post('end_date'),
        'total_days' => $this->input->post('total_days'),
        'reason' => $this->input->post('reason'),
        'status' => 'request', // This sets it to PENDING
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Handle file upload
    if (!empty($_FILES['attachment']['name'])) {
        $config['upload_path'] = './uploads/leave_attachments/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('attachment')) {
            $upload_data = $this->upload->data();
            $data['attachment'] = $upload_data['file_name'];
        }
    }

    $id = $this->Leave_model->save_request($data);
    
    echo json_encode(['success' => true, 'id' => $id, 'message' => 'Leave request submitted successfully']);
}


    public function view() {
        $id = $this->input->get('lid');
        $request = $this->Leave_model->get_request_detail($id);
        echo json_encode(['request' => $request]);
    }

    public function update_status()
{
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    $comment = $this->input->post('comment');

    if(empty($id)){
        echo json_encode([
            'success'=>false,
            'message'=>'Leave ID missing'
        ]);
        return;
    }

    $data = [
        'status' => $status,
        'approved_by' => 1, // temporary (until session fixed)
        'approval_comment' => $comment,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $result = $this->Leave_model->update_request($id,$data);

    echo json_encode([
        'success'=>$result,
        'message'=>'Status updated'
    ]);
}

    public function delete() {
        $id = $this->input->get('lid');
        $result = $this->Leave_model->delete_request($id);
        echo json_encode(['success' => $result]);
    }
    
    public function get_leave_counts_ajax() {
        $counts = $this->Leave_model->get_leave_counts_by_status();
        echo json_encode($counts);
    }
}