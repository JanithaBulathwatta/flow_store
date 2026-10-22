<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 27/02/2026

class Super_category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

         
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);

         
        $this->load->model('crm/Sup_category_model');
		
		$this->form_validation->set_message('edit_unique', 'The %s already exists.');

         
    }

    /**
     * Super Category list page
     */
    public function index()
    {
        $data['page_title'] = 'Super Categories';
        $this->load->view('header');
        $this->load->view('crm/super_category/super_category', $data);
        $this->load->view('footer');
    }

    /**
     * Get category counts for mini cards (AJAX)
     */
    public function get_category_counts_ajax()
    {
        $data = $this->Sup_category_model->get_status_counts();
        echo json_encode($data);
    }

     
    /**
 * Store or Update super category (AJAX)  
 */
public function store()
{
    $id = $this->input->post('cid');  
    /*
    // Set validation rules
    if ($id) {
        // UPDATE validation rules
        $this->form_validation->set_rules(
            'name',
            'Category Name',
            "required|max_length[255]|callback_edit_unique[super_category.name.{$id}]"
        );
        $this->form_validation->set_rules(
            'code',
            'Category Code',
            "required|max_length[50]|regex_match[/^[A-Za-z0-9_-]+$/]|callback_edit_unique[super_category.code.{$id}]"
        );
        $this->form_validation->set_message('edit_unique', 'The {field} is already taken');
    } else {
        // INSERT validation rules
        $this->form_validation->set_rules(
            'name',
            'Category Name',
            'required|max_length[255]|is_unique[super_category.name]'
        );
        $this->form_validation->set_rules(
            'code',
            'Category Code',
            'required|max_length[50]|regex_match[/^[A-Za-z0-9_-]+$/]|is_unique[super_category.code]'
        );
    }

    if ($this->form_validation->run() == FALSE) {
        // Format errors for your plugin
        $error_string = validation_errors();
        
        // For field-specific errors (if your plugin supports it)
        $field_errors = [];
        if (form_error('name')) {
            $field_errors['name'] = strip_tags(form_error('name'));
        }
        if (form_error('code')) {
            $field_errors['code'] = strip_tags(form_error('code'));
        }
        
        echo json_encode([
            'stt' => 'error',
            'msg' => $error_string,  // Your plugin uses this
            'field_errors' => $field_errors,  // Extra for field highlighting
            'data' => ''
        ]); 
    } else {
		*/
        $data = [
            'name' => $this->input->post('name', TRUE),
            'code' => $this->input->post('code', TRUE),
            'status' => $this->input->post('status') ?: 'active',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($id) {
            $result = $this->Sup_category_model->update($id, $data);
            if ($result) {
                echo json_encode([
                    'stt' => 'ok',
                    'msg' => 'Category Updated Successfully!',
                    'data' => $id
                ]);
            } else {
                echo json_encode([
                    'stt' => 'error',
                    'msg' => 'Something Went Wrong!',
                    'data' => ''
                ]);
            }
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $new_id = $this->Sup_category_model->insert($data);
            if ($new_id) {
                echo json_encode([
                    'stt' => 'ok',
                    'msg' => 'Category Created Successfully!',
                    'data' => $new_id
                ]);
            } else {
                echo json_encode([
                    'stt' => 'error',
                    'msg' => 'Something Went Wrong!',
                    'data' => ''
                ]);
            }
        
    }
}


     
              

    /**
     * View single super category (AJAX)
     */
    public function view()
{
    $id = $this->input->get('lid'); // Get from query string
    
    if (!$id) {
        echo json_encode([
            'success' => false, 
            'message' => 'ID not provided'
        ]);
        return;
    }

    $category = $this->Sup_category_model->get_by_id($id);
    
    if ($category) {
        echo json_encode([
            'success' => true,
            'category' => $category
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Category not found with ID: ' . $id
        ]);
    }
}
    /**
     * Delete super category (AJAX)  
     */
    public function delete()
    {
		 if (!$this->input->is_ajax_request()) {
            show_404();
         }
         
        $id = $this->input->get('id');

        if (!$id) {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Category ID is required',
                'data' => ''
            ]);
            return;
        }

        // Check if category exists
        $category = $this->Sup_category_model->get_by_id($id);

        if (!$category) {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Category not found',
                'data' => ''
            ]);
            return;
        }

          
	    // Check if already deleted
        if ($category->status == 'deleted') {
           echo json_encode([
              'stt' => 'error',
              'msg' => 'Category is already deleted',
              'data' => ''
           ]);
           return;
        }
	 
        // Perform delete
        $result = $this->Sup_category_model->delete($id);

        if ($result) {
            echo json_encode([
                'stt' => 'ok',
                'msg' => 'Category Deleted Successfully!',
                'data' => $id
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Failed to delete category',
                'data' => ''
            ]);
        }
    }

    /**
      * RESTORE - Set status back to active
    */
    public function restore()
    {
       if (!$this->input->is_ajax_request()) {
          show_404();
       }
    
       $id = $this->input->post('id');

       if (!$id) {
          echo json_encode([
            'success' => false,
            'message' => 'Category ID is required'
           ]);
           return;
        }

        $result = $this->Sup_category_model->restore($id);

        if ($result) {
            echo json_encode([
              'success' => true,
              'message' => 'Category restored successfully!'
            ]);
        } else {
             echo json_encode([
               'success' => false,
               'message' => 'Failed to restore category'
             ]);
         }
    }

    /**
     * Filter super categories (AJAX)
     */
    public function filter()
    {
        $search = $this->input->post('search');
        $status = $this->input->post('status');
        $date = $this->input->post('date');

        $data = $this->Sup_category_model->get_filtered($search, $status, $date);
        
        echo json_encode(['data' => $data]);
    }

    /**
     * Update category status (AJAX)
     */
    public function update_status()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $id = $this->input->post('id'); // Get ID from POST data
    $status = $this->input->post('status');

    if (!$id) {
        echo json_encode([
            'success' => false,
            'message' => 'ID not provided'
        ]);
        return;
    }

    $data = [
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $result = $this->Sup_category_model->update($id, $data);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update status'
        ]);
    }
}

public function edit_unique($str, $params)
{
    // Params format: table.field.id
    list($table, $field, $id) = explode('.', $params);
    
    // Trim whitespace
    $str = trim($str);
    $id = trim($id);
    
    if (empty($str) || empty($id)) {
        return TRUE; // Skip validation if empty (required will catch this)
    }
    
    $this->db->where($field, $str);
    $this->db->where('id !=', $id);
    
    // Also check status != 'deleted' to avoid conflicts with soft-deleted records
    $this->db->where('status !=', 'deleted');
    
    $query = $this->db->get($table);
    
    if ($query->num_rows() > 0) {
        $this->form_validation->set_message('edit_unique', 'The {field} "%s" is already taken by another active category.');
        return FALSE;
    }
    
    return TRUE;
}
  
}  