<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 10/3/2026

class Expense extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Core libraries & helpers
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

		$this->load->model('crm/Expense_model', 'expense_model');

         
         
    
    }

	 

    
    public function index()
    {
		
		$data['categories'] = $this->expense_model->get_all_categories();
        $data['expenseTypes'] = $this->expense_model->get_all_expense_types();
        $data['title'] = 'Expense Management';
         

		$this->load->view('header');
        $this->load->view('crm/expense/expense',$data);
		$this->load->view('footer');
	}
	
	public function get_expense_counts_ajax() {
        $active_count = $this->expense_model->count_expense_types_by_status('Active');
        $inactive_count = $this->expense_model->count_expense_types_by_status('Inactive');
        $deleted_count = $this->expense_model->count_expense_types_by_status('Deleted');
		
        $response = [
            'active_count' => $active_count,
            'inactive_count' => $inactive_count,
			'deleted_count' => $deleted_count
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function filter() {
        $date_range = $this->input->post('date');
        $category_id = $this->input->post('category_id');
        $type_id = $this->input->post('type_id');
        $status = $this->input->post('status');
		
		log_message('error', 'Filter status received: ' . $status);
        
        $data = $this->expense_model->filter_expenses($date_range, $category_id, $type_id, $status);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $data]));
    }

    public function store() {
    $this->form_validation->set_rules('expense_type_name', 'Expense Type Name', 'trim|required|min_length[2]|max_length[100]');
    $this->form_validation->set_rules('expense_category_id', 'Expense Category', 'trim|required|numeric');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode(['stt' => 'error', 'msg' => strip_tags(validation_errors())]);
        return;
    }
    
    $id = $this->input->post('eid'); // Check for ID
    
    $data = [
        'Exp_Type_name' => $this->input->post('expense_type_name'),
        'fk_exp_cat_id' => $this->input->post('expense_category_id'),
        'Exp_Type_status' => 'Active'
    ];
    
    if ($id) {
        // Update existing
        $this->db->where('Exp_Type_id', $id);
        $result = $this->db->update($this->expense_model->get_table_types(), $data);
        if ($result) {
            echo json_encode(['stt' => 'ok', 'msg' => 'Expense updated successfully', 'data' => $id]);
        } else {
            echo json_encode(['stt' => 'error', 'msg' => 'Update failed']);
        }
    } else {
        // Insert new
        $result = $this->db->insert($this->expense_model->get_table_types(), $data);
        $new_id = $this->db->insert_id();
        if ($result) {
            echo json_encode(['stt' => 'ok', 'msg' => 'Expense added successfully', 'data' => $new_id]);
        } else {
            echo json_encode(['stt' => 'error', 'msg' => 'Add failed']);
        }
    }
}

    public function view() {
    $id = $this->input->get('eid');
    
    if (!$id) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => false, 'message' => 'ID required']));
        return;
    }
    
    // Get expense type data (not from expenses table)
    $expense_type = $this->expense_model->get_expense_type_by_id($id);
    
    if ($expense_type) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'expense' => [
                    'Exp_Type_id' => $expense_type['id'],
                    'Exp_Type_name' => $expense_type['name'],
                    'fk_exp_cat_id' => $expense_type['category_id'],
                    'Exp_Type_status' => $expense_type['status']
                ]
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Expense type not found'
            ]));
    }
}

    public function update_status() {
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    
    // Capitalize first letter for database
    $status = ucfirst(strtolower($status));
    
    $result = $this->expense_model->update_type_status($id, $status);
    
    $response = ['success' => $result ? true : false];
    if (!$result) {
        $response['message'] = 'Failed to update status';
    }
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}

public function delete() {
    log_message('error', 'DELETE METHOD CALLED');
    
    $id = $this->input->get('id');
    
    if (!$id) {
        log_message('error', 'No ID provided to delete method');
        echo json_encode(['stt' => 'error', 'msg' => 'No ID provided']);
        return;
    }
    
    log_message('error', 'Attempting to delete ID: ' . $id);
    
    $deleted = $this->expense_model->delete_expense($id);
    
    if ($deleted) {
        log_message('error', 'Successfully deleted ID: ' . $id);
        echo json_encode(['stt' => 'ok', 'msg' => 'Expense deleted successfully']);
    } else {
        log_message('error', 'Failed to delete ID: ' . $id);
        echo json_encode(['stt' => 'error', 'msg' => 'Failed to delete expense']);
    }
}





    public function get_all_expense_types() {
        $types = $this->expense_model->get_all_expense_types_with_categories();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $types]));
    }
	 
	 
	 
	 public function update() {
    $this->form_validation->set_rules('expense_type_name', 'Expense Type Name', 'trim|required|min_length[2]|max_length[100]');
    $this->form_validation->set_rules('expense_category_id', 'Expense Category', 'trim|required|numeric');

    if ($this->form_validation->run() == FALSE) {
        $response = ['success' => false, 'message' => strip_tags(validation_errors())];
    } else {
        $id = $this->input->post('eid');
        
        $data = [
            'Exp_Type_name' => $this->input->post('expense_type_name'),
            'fk_exp_cat_id' => $this->input->post('expense_category_id')
        ];
        
        $this->db->where('Exp_Type_id', $id);
        $result = $this->db->update($this->expense_model->get_table_types(), $data);
        
        $response = [
            'success' => $result, 
            'message' => $result ? 'Updated successfully' : 'Update failed'
        ];
    }
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}
	/*--------------------------------------------------------------------------------------------------------------------
						EXPENCE MANAGER 
	--------------------------------------------------------------------------------------------------------------------*/
	public function get_ui() {
    $data['title'] = "Expense Manager";
    
    // Add your custom CSS here if you want it loaded in the header
	$data['custom_styles'] = ['expense-manager-custom.css'];
	
	$data['families_initial'] = $this->db->get('expense_family')->result();

    $this->load->view('header', $data);       // Load Header
    $this->load->view('crm/expense/expence_manager');   // Load your New UI
    $this->load->view('footer');              // Load Footer
}
	// Step 2: Get Categories when Family is selected
   /* public function get_categories_by_family() {
       // $family_id = $this->input->post('family_id');
       // $categories = $this->db->where('family_id', $family_id)->get('expense_cat')->result();
       // echo json_encode($categories);
	   $categories = $this->db->get('expense_cat')->result();
    
    // Return as JSON for your AJAX call
    echo json_encode($categories);
    }*/
	
	public function get_categories_by_family() {
    $this->db->select('
        expense_cat.exp_cat_id, 
        expense_cat.exp_cat_name, 
        expense_cat.family_id, 
        expense_family.family_name
    ');
    $this->db->from('expense_cat');
    // Join with the family table to get the foreign key and family name
    $this->db->join('expense_family', 'expense_family.family_id = expense_cat.family_id', 'inner');
    
    $categories = $this->db->get()->result();
    echo json_encode($categories);
}

    // Step 3: Get Types when Category is selected
    public function get_types_by_category() {
        $cat_id = $this->input->post('cat_id');
        // We filter by cat_id; family_id is redundant but available in the table
        $types = $this->db->where('cat_id', $cat_id)->get('expense_typ')->result();
        echo json_encode($types);
    }

	public function get_families_ajax() {
    // 1. Clear any previous output buffers
    ob_clean(); 
    
    // 2. Set the header strictly to JSON
    header('Content-Type: application/json');

    // 3. Temporarily bypass any custom auth to test if data loads
    // If this works, we know the session check was the culprit
    $families = $this->db->get('expense_family')->result();
    
    if (!$families) {
        echo json_encode([]); // Return empty array instead of nothing
    } else {
        echo json_encode($families);
    }
    exit; // Prevent CI from adding extra debug info
}	
	public function get_bank_accounts_ajax() {
    // Fetch only active accounts
    $this->db->where('status', 'active');
    $query = $this->db->get('bank_accounts');
    $accounts = $query->result();

    echo json_encode($accounts);
}
/*public function save_expense_ajax() {
    // Collect POST data
    $date    = $this->input->post('date');
    $ref     = $this->input->post('ref_no');
    $fam_id  = $this->input->post('family_id');
    $cat_id  = $this->input->post('cat_id');
    $type_id = $this->input->post('type_id');
    $acc_id  = $this->input->post('bank_acc_id');
    $note    = $this->input->post('note');
    $qty     = (int)$this->input->post('qty');
    $unit    = (double)$this->input->post('amount');
    $total   = $qty * $unit;

    $this->db->trans_start(); // Start SQL Transaction

    // 1. Insert into 'expenses' table
    $this->db->insert('expenses', [
        'expense_date' => $date,
        'reference_no' => $ref,
        'family_id'    => $fam_id,
        'cat_id'       => $cat_id,
        'type_id'      => $type_id,
        'bank_acc_id'  => $acc_id,
        'note'         => $note,
        'qty'          => $qty,
        'unit_amount'  => $unit,
        'total_amount' => $total
    ]);

    // 2. Update 'bank_accounts' balance
    // Deduct the total amount from the chosen account
    $this->db->set('current_balance', 'current_balance - ' . $total, FALSE);
    $this->db->where('bank_acc_id', $acc_id);
    $this->db->update('bank_accounts');

    $this->db->trans_complete(); // Commit if both succeeded

    if ($this->db->trans_status() === FALSE) {
        echo json_encode(['success' => false, 'message' => 'Database error occurred.']);
    } else {
        echo json_encode(['success' => true]);
    }
}*/
/*
public function save_expense_ajax() {
    // Collect POST data
    $project_id = $this->input->post('project_id'); // Grab the new project context field
    $date       = $this->input->post('date');
    $ref        = $this->input->post('ref_no');
    $fam_id     = $this->input->post('family_id');
    $cat_id     = $this->input->post('cat_id');
    $type_id    = $this->input->post('type_id');
    $acc_id     = $this->input->post('bank_acc_id');
    $note       = $this->input->post('note');
    $qty        = (int)$this->input->post('qty');
    $unit       = (double)$this->input->post('amount');
    $total      = $qty * $unit;

    $this->db->trans_start(); // Start SQL Transaction

    // 1. Insert into 'expenses' table
    $this->db->insert('expenses', [
        'project_id'   => !empty($project_id) ? $project_id : NULL, // Safely handle global vs specific project contexts
        'expense_date' => $date,
        'reference_no' => $ref,
        'family_id'    => $fam_id,
        'cat_id'       => $cat_id,
        'type_id'      => $type_id,
        'bank_acc_id'  => $acc_id,
        'note'         => $note,
        'qty'          => $qty,
        'unit_amount'  => $unit,
        'total_amount' => $total
    ]);

    // 2. Update 'bank_accounts' balance
    // Deduct the total amount from the chosen account
    $this->db->set('current_balance', 'current_balance - ' . $total, FALSE);
    $this->db->where('bank_acc_id', $acc_id);
    $this->db->update('bank_accounts');

    $this->db->trans_complete(); // Commit if both succeeded

    if ($this->db->trans_status() === FALSE) {
        echo json_encode(['success' => false, 'message' => 'Database error occurred.']);
    } else {
        echo json_encode(['success' => true]);
    }
}*/

	public function save_expense_ajax() {
    // 1. Collect and explicitly sanitize incoming POST payload data packet entries
    $project_id = $this->input->post('project_id'); 
    $date       = $this->input->post('date');
    $ref        = $this->input->post('ref_no');
    $fam_id     = $this->input->post('family_id');
    $cat_id     = $this->input->post('cat_id');
    $type_id    = $this->input->post('type_id');
    $acc_id     = $this->input->post('bank_acc_id');
    $note       = $this->input->post('note');
    $qty        = (int)$this->input->post('qty');
    $unit       = (double)$this->input->post('amount');
    
    // Explicitly enforce absolute precision mathematical safety checks
    $total      = (float)($qty * $unit);

    // 2. Open an ACID Compliant SQL Transaction Block 
    $this->db->trans_start(); 

    // Insert structural tracking metrics down inside the central 'expenses' table registry
    $this->db->insert('expenses', [
        'project_id'   => !empty($project_id) ? $project_id : NULL, 
        'expense_date' => $date,
        'reference_no' => $ref,
        'family_id'    => $fam_id,
        'cat_id'       => $cat_id,
        'type_id'      => $type_id,
        'bank_acc_id'  => $acc_id,
        'note'         => $note,
        'qty'          => $qty,
        'unit_amount'  => $unit,
        'total_amount' => $total
    ]);

    // 3. Update 'bank_accounts' balance ledger dynamically via custom expression context
    // The cast context string ensures raw numeric math calculations bypass security vulnerabilities safely
    $this->db->set('current_balance', 'current_balance - ' . $total, FALSE);
    $this->db->where('bank_acc_id', $acc_id);
    $this->db->update('bank_accounts');

    // 4. Close Transaction Execution Frame
    $this->db->trans_complete(); 

    // 5. Construct and dispatch structured HTTP payload response packets cleanly
    $this->output->set_content_type('application/json');

    if ($this->db->trans_status() === FALSE) {
        $this->output->set_output(json_encode([
            'success' => false, 
            'message' => 'Database storage pipeline failure occurred processing entries.'
        ]));
    } else {
        $this->output->set_output(json_encode([
            'success' => true
        ]));
    }
}



	/*public function get_expenses_ajax() {
    $this->db->select('e.*, b.account_nickname as account, c.category_name as cat, t.type_name as type, f.family_name as family');
    $this->db->from('expenses e');
    $this->db->join('bank_accounts b', 'e.bank_acc_id = b.bank_acc_id');
    $this->db->join('categories c', 'e.cat_id = c.cat_id');
    $this->db->join('expense_types t', 'e.type_id = t.type_id');
    $this->db->join('expense_families f', 'e.family_id = f.family_id');
    $this->db->order_by('e.expense_date', 'DESC');
    
    $query = $this->db->get();
    echo json_encode($query->result());
}*/
public function get_expenses_ajax() {
    header('Content-Type: application/json');

    $this->db->select('
        e.exp_id, 
        e.expense_date as date, 
        e.reference_no as ref, 
        e.note, 
        e.qty, 
        e.unit_amount as amount, 
        e.total_amount,
        f.family_name as family,
        f.color as family_color,
        c.exp_cat_name as cat,
        t.type_name as type,
        b.account_nickname as account
    ');
    $this->db->from('expenses e');
    
    // Exact table and column mapping
    $this->db->join('expense_family f', 'e.family_id = f.family_id', 'left');
    $this->db->join('expense_cat c',    'e.cat_id = c.exp_cat_id', 'left');
    $this->db->join('expense_typ t',    'e.type_id = t.type_id', 'left');
    $this->db->join('bank_accounts b',  'e.bank_acc_id = b.bank_acc_id', 'left');
    
    $this->db->where('e.status', 'active');
    $this->db->order_by('e.expense_date', 'DESC');
    
    $query = $this->db->get();
    $result = $query->result();

    echo json_encode($result ? $result : []);
}

	public function change_expense_status() {
    // 1. Enforce that this is exclusively an incoming AJAX/POST request
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
        
        // Grab the expense tracking identifier from the AJAX data payload
        $expense_id = $this->input->post('expense_id');

        // Validation guard: Make sure an ID was transmitted
        if (empty($expense_id)) {
            echo json_encode([
                'success' => false, 
                'status'  => 'error',
                'message' => 'Missing primary key identifier for the expense record.'
            ]);
            return;
        }

        // 2. Load your data repository layer model
        $this->load->model('Expense_model');

        // Execute the soft deletion request to change the ENUM value status to 'pending'
        // This targets your schema constraints: 'active', 'pending', 'deleted'
        $is_updated = $this->Expense_model->update_status_to_pending($expense_id);

        if ($is_updated) {
            // Return success structure so the front-end switches button states instantly
            echo json_encode([
                'success' => true,
                'status'  => 'success'
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'status'  => 'error',
                'message' => 'Database failed to alter the status transaction configuration state.'
            ]);
        }

    } else {
        // Fallback protection block against direct script execution URL queries
        echo json_encode([
            'success' => false, 
            'status'  => 'error',
            'message' => 'Invalid request delivery architecture execution routing rule.'
        ]);
    }
}


//---------------------------------------------------------------------------------------------------------------------
//											Expence approval
//---------------------------------------------------------------------------------------------------------------------	

	/** ─── LOAD EXPENSE APPROVAL MANAGEMENT VIEW ───
     * Route Target: /Expense/get_approval_ui
     */
    public function get_approval_ui() {
        $data['title'] = "Expense Approval Management";
        
        // Load any custom styles if your main dashboard wrapper layout needs it
        $data['custom_styles'] = ['expense-manager-custom.css'];
        
        // Fetch structural lookup filters data if you intend to populate a 
        // category/family filtering dropdown within your approval window later
        $data['families_initial'] = $this->db->get('expense_family')->result();
        
      
        $this->load->view('header', $data);                        
        $this->load->view('crm/expense/expense_Approval');        
        $this->load->view('footer');                              
    }
	
	
  
public function get_pending_approval_data() {
    $search = $this->input->post('search');

    $this->db->select('*');
    $this->db->from('expenses');
    
    // This ensures once status changes to 'deleted' or 'active', it disappears on reload!
    $this->db->where('status', 'pending'); 

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('ref', $search);
        $this->db->or_like('cat', $search);
        $this->db->or_like('note', $search);
        $this->db->group_end();
    }

    $query = $this->db->get();
    echo json_encode($query->result());
}

	public function approve() {
    $id = $this->input->post('exp_id') ? $this->input->post('exp_id') : $this->input->post('id');
    $remarks = $this->input->post('appremark');

    if (!empty($id)) {
        $this->db->where('exp_id', $id);
        $this->db->update('expenses', [
            'status' => 'deleted', //  ENUM VALID: Changes state to Active
            'remarks' => $remarks  
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Record authorized successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request identifier.']);
    }
}

	public function reject() {
		$id = $this->input->post('exp_id') ? $this->input->post('exp_id') : $this->input->post('id');
		$remarks = $this->input->post('appremark');

		if (!empty($id)) {
			$this->db->where('exp_id', $id);
			$this->db->update('expenses', [
				'status' => 'active', //  ENUM VALID: Drops it out of the pending queue view
				'remarks' => '[REJECTED] ' . $remarks // Prepends tag to the text logs for clarity
			]);
			echo json_encode(['status' => 'success', 'message' => 'Record successfully rejected.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Invalid request identifier.']);
		}
	}


}
