<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// supun 2026/3/10

class Store extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Store_model');
        $this->load->model('Branch_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        $filters = [
            'search' => $this->input->get('search'),
            'status' => $this->input->get('status'),
            'date' => $this->input->get('date')
        ];
        
        $data['stores'] = $this->Store_model->get_all_stores($filters);
        $data['counts'] = $this->Store_model->get_counts();
        $data['filters'] = $filters;
		
		// get branches lits for the dropdown
		$data ['branches'] = $this->Branch_model->get_all_branches();
        
        $this->load->view('header');
        $this->load->view('store/store', $data);
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
        
        $stores = $this->Store_model->get_all_stores($filters);
        
        $response = [
            'data' => $stores
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_counts() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $counts = $this->Store_model->get_counts();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($counts));
    }

    public function get_store() {
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
        
        $store = $this->Store_model->get_store($id);
        
        if ($store) {
            $response = [
                'success' => true,
                'store' => [
                    'id' => $store->store_id,
                    'name' => $store->store_name,
                    'address' => $store->store_address,
                    'phone' => $store->store_phone,
                    'status' => $store->store_status,
                    'branch_id' => $store->branch_id,
                    'branch_name' => $store->branch_name
                ]
            ];
        } else {
            $response = ['success' => false, 'message' => 'Store not found'];
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
		
        $this->form_validation->set_rules('branch_id', 'Branch', 'required|numeric');
        $this->form_validation->set_rules('name', 'Store Name', 'required|trim|max_length[45]');
        $this->form_validation->set_rules('address', 'Store Address', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('phone', 'Store Phone', 'required|trim|max_length[10]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'stt' => 'error', 
                'msg' => validation_errors(), 
                'data' => ''
            ]);
        } else {
            $data = [
				'branch_id'     => $this->input->post('branch_id', TRUE),
                'store_name' => $this->input->post('name', TRUE),
                'store_address' => $this->input->post('address', TRUE),
                'store_phone' => $this->input->post('phone', TRUE),
                'store_status' => 'active'
            ];
            
            $insert_id = $this->Store_model->insert_store($data);
            
            if ($insert_id) {
                echo json_encode([
                    'stt' => 'ok',
                    'msg' => 'Store added successfully',
                    'data' => $insert_id
                ]);
            } else {
                echo json_encode([
                    'stt' => 'error',
                    'msg' => 'Failed to add store',
                    'data' => ''
                ]);
            }
        }
    }

    public function update() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->post('sid');
        
        if (!$id) {
            echo json_encode([
                'stt' => 'error', 
                'msg' => 'ID is required', 
                'data' => ''
            ]);
            return;
        }
        
        $this->load->library('form_validation');
		
        $this->form_validation->set_rules('branch_id', 'Branch', 'required|numeric');
        $this->form_validation->set_rules('name', 'Store Name', 'required|trim|max_length[45]');
        $this->form_validation->set_rules('address', 'Store Address', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('phone', 'Store Phone', 'required|trim|max_length[10]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'stt' => 'error', 
                'msg' => validation_errors(), 
                'data' => ''
            ]);
        } else {
            $data = [
			
				'branch_id'     => $this->input->post('branch_id', TRUE),
                'store_name' => $this->input->post('name', TRUE),
                'store_address' => $this->input->post('address', TRUE),
                'store_phone' => $this->input->post('phone', TRUE)
            ];
            
            $updated = $this->Store_model->update_store($id, $data);
            
            if ($updated) {
                echo json_encode([
                    'stt' => 'ok',
                    'msg' => 'Store updated successfully',
                    'data' => $id
                ]);
            } else {
                echo json_encode([
                    'stt' => 'error',
                    'msg' => 'Failed to update store',
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
        
        $store = $this->Store_model->get_store($id);
        if (!$store) {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Store not found',
                'data' => ''
            ]);
            return;
        }
        
        $deleted = $this->Store_model->delete_store($id);
        
        if ($deleted) {
            echo json_encode([
                'stt' => 'ok',
                'msg' => 'Store deleted successfully',
                'data' => $id
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Failed to delete store',
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
        
        $updated = $this->Store_model->update_status($id, $status);
        
        if ($updated) {
            $message = $status === 'active' ? 'Store activated successfully' : 'Store deactivated successfully';
            echo json_encode([
                'stt' => 'ok',
                'msg' => $message,
                'data' => $id
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Failed to update store status',
                'data' => ''
            ]);
        }
    }
}
?>