<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 5/3/2026

class Brand extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crm/Brand_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    /**
     * Display brands page
     */
    public function index() {
          
        $filters = [
            'search' => $this->input->get('search'),
            'status' => $this->input->get('status'),
            'date' => $this->input->get('date')
        ];
        
         
        $data['brands'] = $this->Brand_model->get_all_brands($filters);
        
         
        $data['counts'] = $this->Brand_model->get_counts();
        
         
        $data['filters'] = $filters;
        
        $this->load->view('header');
        $this->load->view('crm/brand/brand', $data);
        $this->load->view('footer');
    }

    /**
     * AJAX: Get filtered brands for DataTable
     */
    public function filter() {
        // Only allow AJAX requests
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
		
		$status = $this->input->post('status');
    
       // Handle comma-separated statuses (like "active,inactive")
       if (!empty($status) && strpos($status, ',') !== false) {
           // For multiple statuses, we need to get ALL brands first
           // and let JavaScript handle the filtering
           $status = ''; // Send empty to get all brands
       }
        
        $filters = [
            'search' => $this->input->post('search'),
             'status' => $status,
            'date' => $this->input->post('date')
        ];
        
        $brands = $this->Brand_model->get_all_brands($filters);
        
        $response = [
            'data' => $brands,
			'counts' => $this->Brand_model->get_counts()
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * AJAX: Get brand counts for mini cards
     */
    public function get_counts() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $counts = $this->Brand_model->get_counts();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($counts));
    }

    /**
     * AJAX: Get single brand by ID
     */
    public function get_brand() {
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
        
        $brand = $this->Brand_model->get_brand($id);
        
        if ($brand) {
            // Map database fields to what the view expects
            $response = [
                'success' => true,
                'brand' => [
                    'id' => $brand->brand_id,
                    'name' => $brand->brand_name,
                    'code' => $brand->brand_code,
                    'description' => $brand->brand_description,
                    'status' => $brand->brand_status
                ]
            ];
        } else {
            $response = ['success' => false, 'message' => 'Brand not found'];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
 * Store or Update brand - Combined method  
 */
public function store() {
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    $id = $this->input->post('bid'); // Check if ID exists for update
    
    $this->load->library('form_validation');
    
    // Set validation rules based on whether it's update or insert
    if ($id) {
        // UPDATE validation rules
        $this->form_validation->set_rules('name', 'Brand Name', 'required|trim|max_length[45]');
        $this->form_validation->set_rules('code', 'Brand Code', 'required|trim|max_length[8]|callback_check_unique_code_update['.$id.']');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]');
    } else {
        // INSERT validation rules
        $this->form_validation->set_rules('name', 'Brand Name', 'required|trim|max_length[45]');
        $this->form_validation->set_rules('code', 'Brand Code', 'required|trim|max_length[8]|callback_check_unique_code');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]');
    }
    
    $this->form_validation->set_message('required', 'The %s field is required');
    $this->form_validation->set_message('max_length', 'The %s cannot exceed %s characters');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'stt' => 'error', 
            'msg' => validation_errors(), 
            'data' => ''
        ]);
    } else {
        $data = [
            'brand_name' => $this->input->post('name', TRUE),
            'brand_code' => $this->input->post('code', TRUE),
            'brand_description' => $this->input->post('description', TRUE),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($id) {
            // UPDATE existing brand
            $result = $this->Brand_model->update_brand($id, $data);
            if ($result) {
                echo json_encode([
                    'stt' => 'ok',
                    'msg' => 'Brand updated successfully',
                    'data' => $id
                ]);
            } else {
                echo json_encode([
                    'stt' => 'error',
                    'msg' => 'Failed to update brand',
                    'data' => ''
                ]);
            }
        } else {
            // INSERT new brand
            $data['brand_status'] = 'active';
            $data['created_at'] = date('Y-m-d H:i:s');
            $insert_id = $this->Brand_model->insert_brand($data);
            if ($insert_id) {
                echo json_encode([
                    'stt' => 'ok',
                    'msg' => 'Brand added successfully',
                    'data' => $insert_id
                ]);
            } else {
                echo json_encode([
                    'stt' => 'error',
                    'msg' => 'Failed to add brand',
                    'data' => ''
                ]);
            }
        }
    }
}
     

    /**
     * Delete brand  
     */
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
    
    // Check if brand exists  
    $brand = $this->Brand_model->get_brand($id);
    if (!$brand) {
        echo json_encode([
            'stt' => 'error',
            'msg' => 'Brand not found',
            'data' => ''
        ]);
        return;
    }
    
    // Check if brand has products
    $this->load->model('crm/Product_model');
    $has_products = $this->Product_model->has_products_by_brand($id);
    
    if ($has_products) {
        // Soft delete by changing status to deleted
        $data = ['brand_status' => 'deleted'];
        $result = $this->Brand_model->update_brand($id, $data);
        
        if ($result) {
            echo json_encode([
                'stt' => 'ok',
                'msg' => 'Brand has associated products. It has been marked as deleted.',
                'data' => $id
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Failed to delete brand',
                'data' => ''
            ]);
        }
        return;
    }
    
    $deleted = $this->Brand_model->delete_brand($id);
    
    if ($deleted) {
        echo json_encode([
            'stt' => 'ok',
            'msg' => 'Brand deleted successfully',
            'data' => $id
        ]);
    } else {
        echo json_encode([
            'stt' => 'error',
            'msg' => 'Failed to delete brand',
            'data' => ''
        ]);
    }
}

     /**
     * NEW METHOD: Update brand status (for toggle)
     */
    public function update_status() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        
        if (!$id) {
            echo json_encode([
                'success' => false,
                'message' => 'Brand ID is required!'
            ]);
            return;
        }
        
        if (!in_array($status, ['active', 'inactive'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid status!'
            ]);
            return;
        }
        
        $data = ['brand_status' => $status];
        $result = $this->Brand_model->update_brand($id, $data);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update status!'
            ]);
        }
    }



    /**
 * Callback to check if brand code is unique
 */
public function check_unique_code($code) {
     
     
    
    // Check if code exists in active brands
    if ($this->Brand_model->code_exists($code)) {
        $this->form_validation->set_message('check_unique_code', 'The brand code "%s" already exists. Please use a different code.');
        return FALSE;
    }
    
    return TRUE;
}

    /**
     * Callback to check if brand code is unique for update
     * FIXED: Now properly excludes current brand ID
     */
   public function check_unique_code_update($code, $id) {
     
    
    if ($this->Brand_model->code_exists($code, $id)) {
        $this->form_validation->set_message('check_unique_code_update', 'The brand code "%s" already exists. Please use a different code.');
        return FALSE;
    }
    
    return TRUE;
}
}
?>