<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// supun 2023/3/11
class Branch extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->model('Branch_model');
        $this->load->helper('url');
		$this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function Branch_manage() {
        $filters = [
            'search' => $this->input->get('search'),
            'status' => $this->input->get('status'),
            'date' => $this->input->get('date')
        ];
        
        $data['branches'] = $this->Branch_model->get_all_branches($filters);
        $data['counts'] = $this->Branch_model->get_counts(); 
        $data['filters'] = $filters;
        
        $this->load->view('header');
        $this->load->view('branch', $data);
        $this->load->view('footer');
    }

    public function filter() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $filters = [
            'search' => $this->input->post('search'),
            'status' => $this->input->post('status'),
            'date' => $this->input->post('date')
        ];
        
        $branches = $this->Branch_model->get_all_branches($filters);
        
        $response = [
            'data' => $branches
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_counts() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $counts = $this->Branch_model->get_counts();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($counts));
    }

    public function get_branch() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->get('id');
        
        if (!$id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'ID is required']));
            return;
        }
        
        $branch = $this->Branch_model->get_branch($id);
        
        if ($branch) {
            $response = [
                'success' => true,
                'branch' => [
                    'id' => $branch->branch_id,
                    'code' => $branch->branch_code,
                    'name' => $branch->branch_name,
                    'address' => $branch->branch_address_full,
                    'city' => $branch->branch_city,
                    'phone' => $branch->branch_phone,
                    'email' => $branch->branch_email,
                    'status' => $branch->branch_status
                ]
            ];
        } else {
            $response = ['success' => false, 'message' => 'Branch not found'];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function store() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('code', 'Branch Code', 'required|trim|max_length[20]|callback_check_unique_code');
        $this->form_validation->set_rules('name', 'Branch Name', 'required|trim|max_length[45]');
        $this->form_validation->set_rules('address', 'Branch Address', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('city', 'Branch City', 'required|trim|max_length[30]');
        $this->form_validation->set_rules('phone', 'Branch Phone', 'required|trim|max_length[15]');
        $this->form_validation->set_rules('email', 'Branch Email', 'required|valid_email|max_length[50]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'stt' => 'error', 
                'msg' => validation_errors(), 
                'data' => ''
            ]);
        } else {
            $data = [
                'branch_code' => $this->input->post('code', TRUE),
                'branch_name' => $this->input->post('name', TRUE),
                'branch_address_full' => $this->input->post('address', TRUE),
                'branch_city' => $this->input->post('city', TRUE),
                'branch_phone' => $this->input->post('phone', TRUE),
                'branch_email' => $this->input->post('email', TRUE),
                'branch_status' => 'active'
            ];
            
            $insert_id = $this->Branch_model->insert_branch($data);
            
            if ($insert_id) {
                echo json_encode([
                    'stt' => 'ok',
                    'msg' => 'Branch added successfully',
                    'data' => $insert_id
                ]);
            } else {
                echo json_encode([
                    'stt' => 'error',
                    'msg' => 'Failed to add branch',
                    'data' => ''
                ]);
            }
        }
    }

    public function update() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->post('bid');
        
        if (!$id) {
            echo json_encode([
                'stt' => 'error', 
                'msg' => 'ID is required', 
                'data' => ''
            ]);
            return;
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('code', 'Branch Code', 'required|trim|max_length[20]|callback_check_unique_code_update['.$id.']');
        $this->form_validation->set_rules('name', 'Branch Name', 'required|trim|max_length[45]');
        $this->form_validation->set_rules('address', 'Branch Address', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('city', 'Branch City', 'required|trim|max_length[30]');
        $this->form_validation->set_rules('phone', 'Branch Phone', 'required|trim|max_length[15]');
        $this->form_validation->set_rules('email', 'Branch Email', 'required|valid_email|max_length[50]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'stt' => 'error', 
                'msg' => validation_errors(), 
                'data' => ''
            ]);
        } else {
            $data = [
                'branch_code' => $this->input->post('code', TRUE),
                'branch_name' => $this->input->post('name', TRUE),
                'branch_address_full' => $this->input->post('address', TRUE),
                'branch_city' => $this->input->post('city', TRUE),
                'branch_phone' => $this->input->post('phone', TRUE),
                'branch_email' => $this->input->post('email', TRUE)
            ];
            
            $updated = $this->Branch_model->update_branch($id, $data);
            
            if ($updated) {
                echo json_encode([
                    'stt' => 'ok',
                    'msg' => 'Branch updated successfully',
                    'data' => $id
                ]);
            } else {
                echo json_encode([
                    'stt' => 'error',
                    'msg' => 'Failed to update branch',
                    'data' => ''
                ]);
            }
        }
    }

    public function delete() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->get('id');
        
        if (!$id) {
            echo json_encode([
                'stt' => 'error', 
                'msg' => 'ID is required', 
                'data' => ''
            ]);
            return;
        }
        
        $branch = $this->Branch_model->get_branch($id);
        if (!$branch) {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Branch not found',
                'data' => ''
            ]);
            return;
        }
        
        $deleted = $this->Branch_model->delete_branch($id);
        
        if ($deleted) {
            echo json_encode([
                'stt' => 'ok',
                'msg' => 'Branch deleted successfully',
                'data' => $id
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Failed to delete branch',
                'data' => ''
            ]);
        }
    }

    public function toggle_status() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        
        if (!$id || !$status) {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'ID and status are required',
                'data' => ''
            ]);
            return;
        }
        
        $updated = $this->Branch_model->update_status($id, $status);
        
        if ($updated) {
            $message = $status === 'active' ? 'Branch activated successfully' : 'Branch deactivated successfully';
            echo json_encode([
                'stt' => 'ok',
                'msg' => $message,
                'data' => $id
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Failed to update branch status',
                'data' => ''
            ]);
        }
    }

    public function check_unique_code($code) {
        if (empty($code)) {
            return TRUE;
        }
        
        if ($this->Branch_model->code_exists($code)) {
            $this->form_validation->set_message('check_unique_code', 'The branch code "%s" already exists. Please use a different code.');
            return FALSE;
        }
        
        return TRUE;
    }

    public function check_unique_code_update($code, $id) {
        if (empty($code)) {
            return TRUE;
        }
        
        if ($this->Branch_model->code_exists($code, $id)) {
            $this->form_validation->set_message('check_unique_code_update', 'The branch code "%s" already exists. Please use a different code.');
            return FALSE;
        }
        
        return TRUE;
    }
}
?>