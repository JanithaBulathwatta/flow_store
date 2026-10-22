<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// wenusha 11/3/2026

class Tax_rate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('Store_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
		$this->load->model('crm/TaxRate_model');
    }

    public function index() {
         
        $data['title'] = 'Tax Rate Management';
        
        // Get initial data for the view
        $data['taxes'] = $this->TaxRate_model->get_all_taxes(['status !=' => 'deleted']);
        $data['counts'] = $this->TaxRate_model->get_counts();
		
		
        $this->load->view('header');
        $this->load->view('crm/taxRate/taxRate', $data);
        $this->load->view('footer');
    }
	
	
	public function filter() {
        $filters = [];
        
        $search = $this->input->post('search');
        $status = $this->input->post('status');
        $date = $this->input->post('date');
        
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        
        if (!empty($status) && $status !== 'all') {
            $filters['status'] = $status;
        }
        
        if (!empty($date)) {
            $filters['date'] = $date;
        }
        
        $data['data'] = $this->TaxRate_model->get_all_taxes($filters);
        $data['counts'] = $this->TaxRate_model->get_counts(); // ADD counts to response
        
        echo json_encode($data);
    }

    public function store() {
    $id = $this->input->post('tid'); // Check for ID
    
    $this->form_validation->set_rules('tax_name', 'Tax Name', 'required|trim|max_length[100]');
    $this->form_validation->set_rules('tax_code', 'Tax Code', 'required|trim|max_length[50]');
    $this->form_validation->set_rules('tax_rate', 'Tax Rate', 'required|numeric|greater_than[0]|less_than[100]');
    $this->form_validation->set_rules('tax_type', 'Tax Type', 'required|in_list[sales,purchase]');
    $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]');

    // Check unique code (exclude current if updating)
    if ($id) {
        $existing = $this->db
            ->where('tax_code', $this->input->post('tax_code'))
            ->where('tax_rate_id !=', $id)
            ->where('status !=', 'deleted')
            ->get('tax_rates')
            ->row();
        
        if ($existing) {
            echo json_encode(['stt' => 'error', 'msg' => 'Tax code already exists']);
            return;
        }
    } else {
        if ($this->TaxRate_model->tax_code_exists($this->input->post('tax_code'))) {
            echo json_encode(['stt' => 'error', 'msg' => 'Tax code already exists']);
            return;
        }
    }

    if ($this->form_validation->run() == FALSE) {
        echo json_encode(['stt' => 'error', 'msg' => validation_errors()]);
        return;
    }
    
    $data = [
        'tax_name' => $this->input->post('tax_name'),
        'tax_code' => strtoupper($this->input->post('tax_code')),
        'tax_rate' => $this->input->post('tax_rate'),
        'tax_type' => $this->input->post('tax_type'),
        'description' => $this->input->post('description'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    if ($id) {
        // Update existing
        $result = $this->TaxRate_model->update_tax($id, $data);
        if ($result) {
            echo json_encode(['stt' => 'ok', 'msg' => 'Tax rate updated successfully', 'data' => $id]);
        } else {
            echo json_encode(['stt' => 'error', 'msg' => 'Failed to update tax rate']);
        }
    } else {
        // Insert new
        $data['status'] = 'active';
        $data['created_by'] = $this->session->userdata('user_id') ?? 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $insert_id = $this->TaxRate_model->insert_tax($data);
        if ($insert_id) {
            echo json_encode(['stt' => 'ok', 'msg' => 'Tax rate added successfully', 'data' => $insert_id]);
        } else {
            echo json_encode(['stt' => 'error', 'msg' => 'Failed to add tax rate']);
        }
    }
}

    public function update() {
        $id = $this->input->post('tid');
        
        if (!$this->TaxRate_model->exists($id)) {
            echo json_encode(['stt' => 'error', 'msg' => 'Tax rate not found']);
            return;
        }
        
        $this->form_validation->set_rules('tax_name', 'Tax Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('tax_code', 'Tax Code', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('tax_rate', 'Tax Rate', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('tax_type', 'Tax Type', 'required|in_list[sales,purchase]');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]');

        // Check if tax_code is unique except for current record
        if ($this->input->post('tax_code')) {
            $existing = $this->db
                ->where('tax_code', $this->input->post('tax_code'))
                ->where('tax_rate_id !=', $id)
                ->get('tax_rates')
                ->row();
            
            if ($existing) {
                echo json_encode(['stt' => 'error', 'msg' => 'Tax code already exists']);
                return;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $response = [
                'stt' => 'error',
                'msg' => validation_errors()
            ];
        } else {
            $data = [
                'tax_name' => $this->input->post('tax_name'),
                'tax_code' => strtoupper($this->input->post('tax_code')),
                'tax_rate' => $this->input->post('tax_rate'),
                'tax_type' => $this->input->post('tax_type'),
                'description' => $this->input->post('description'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $updated = $this->TaxRate_model->update_tax($id, $data);
            
            if ($updated) {
                $response = [
                    'stt' => 'ok',
                    'msg' => 'Tax rate updated successfully'
                ];
            } else {
                $response = [
                    'stt' => 'error',
                    'msg' => 'Failed to update tax rate'
                ];
            }
        }
        
        echo json_encode($response);
    }

    public function get_tax() {
        $id = $this->input->get('id');
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'No ID provided']);
            return;
        }
        
        $tax = $this->TaxRate_model->get_tax($id);
        
        if ($tax) {
            echo json_encode(['success' => true, 'tax' => $tax]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tax rate not found']);
        }
    }

    public function delete() {
        $id = $this->input->get('id');
        
        if (!$id) {
            echo json_encode(['stt' => 'error', 'msg' => 'No ID provided']);
            return;
        }
        
        $deleted = $this->TaxRate_model->delete_tax($id);
        
        if ($deleted) {
            echo json_encode(['stt' => 'ok', 'msg' => 'Tax rate deleted successfully']);
        } else {
            echo json_encode(['stt' => 'error', 'msg' => 'Failed to delete tax rate']);
        }
    }

    /**
     * NEW METHOD: Update tax status (for Bootstrap toggle)
     * This replaces toggle_status() for the new toggle
     */
    public function update_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        
        if (!$id || !in_array($status, ['active', 'inactive'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        $updated = $this->TaxRate_model->update_status($id, $status);
        
        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    /**
     * KEPT FOR BACKWARDS COMPATIBILITY - in case other parts of code still use it
     */
    public function toggle_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        
        if (!$id || !in_array($status, ['active', 'inactive'])) {
            echo json_encode(['stt' => 'error', 'msg' => 'Invalid request']);
            return;
        }
        
        $updated = $this->TaxRate_model->update_status($id, $status);
        
        if ($updated) {
            $msg = $status === 'active' ? 'Tax rate activated successfully' : 'Tax rate deactivated successfully';
            echo json_encode(['stt' => 'ok', 'msg' => $msg]);
        } else {
            echo json_encode(['stt' => 'error', 'msg' => 'Failed to update status']);
        }
    }

    public function get_counts() {
        $counts = $this->TaxRate_model->get_counts();
        echo json_encode($counts);
    }

    public function get_active_taxes() {
        $type = $this->input->get('type'); // Optional: sales or purchase
        $taxes = $this->TaxRate_model->get_active($type);
        echo json_encode($taxes);
    }

}
?>