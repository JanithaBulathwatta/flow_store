<?php
//madhushika(2026-03-12)
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Libraries & helpers
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'security', 'form']);

        // Model
        $this->load->model('crm/Projects_model', 'project');
        $this->load->model('Project_invoice_model');
    }

    public function index() {
        redirect('Projects/project_manage');
    }

    public function project_manage() {
        $data = [
            'page_title' => 'Projects',
            'customers' => $this->project->get_customers()
        ];

        $this->load->view('header');
        $this->load->view('crm/projects/projects_list', $data);
        $this->load->view('footer');
    }

    public function get_project_counts_ajax() {
        $data = $this->project->get_project_counts();
        echo json_encode($data);
    }

    /* FILTER PROJECTS */
    public function filter() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $customer = $this->input->post('customer');
        $status = $this->input->post('status');

        $data = $this->project->get_filtered($start_date, $end_date, $customer, $status);
        echo json_encode(['data' => $data]);
    }

    /* STORE PROJECT - Exactly like Leads with stt and msg */
   /* public function store() {
        $id = $this->input->post('lid');
        
        // Prepare base data
        $data = [
            'project_name' => $this->input->post('project_name', TRUE),
            'fk_cus_id' => $this->input->post('fk_cus_id'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'project_status' => $this->input->post('project_status')
        ];

        // Handle file upload
        if (isset($_FILES['attachment']) && $_FILES['attachment']['name'] != '') {
            
            // Create upload directory if it doesn't exist
            $upload_path = './uploads/projects/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }
            
            // Configure upload
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx';
            $config['max_size'] = 5120; // 5MB
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('attachment')) {
                $upload_data = $this->upload->data();
                $data['attachment'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                log_message('error', 'File upload error: ' . $error);
            }
        }

		// ================== CREATE ACCOUNT ==================
		// mapping
		$account_class = 2; // LIABILITY
		$account_type  = 'LIABILITY';

		$parent_id = 3;

		// calculate level
		$parent = $this->db->get_where('accounts', ['id' => $parent_id])->row_array();
		$level = $parent ? $parent['level'] + 1 : 1;

		$old_post = $_POST;

		$_POST = array_merge($_POST, [
			'account_name' => $this->input->post('project_name', TRUE),
			'account_class' => $account_class,
			'account_type' => $account_type,
			'parent_id' => $parent_id,
			'is_posting' => 1,
			'is_control_account' => 0,
			'level' => $level
		]);

		$this->Accounts_model->create_account();

		$_POST = $old_post;
		// ================== END OF CREATE ACCOUNT ==================


        if (!empty($id)) {
            // Update existing project
            $result = $this->project->update($id, $data);
            $message = 'Project updated successfully';
        } else {
            // Create new project
            $data['created_at'] = date('Y-m-d H:i:s');
            $result = $this->project->create($data);
            $message = 'Project created successfully';
        }

        if ($result) {
            echo json_encode([
                'stt' => 'ok',
                'msg' => $message,
                'data' => $id ?: $result
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Operation failed',
                'data' => ''
            ]);
        }
    }*/
	public function store() {
    $id = $this->input->post('lid');
    
    // 🎯 BACKEND VALIDATION & CASTING
    $raw_budget = $this->input->post('estimated_budget');
    // Force field conversion to float, defaulting to 0.00 if it arrives blank
    $clean_budget = (!empty($raw_budget) && is_numeric($raw_budget)) ? floatval($raw_budget) : 0.00;

    // Optional Server-side block check parameter
    if ($clean_budget < 0) {
        echo json_encode([
            'stt' => 'error',
            'msg' => 'Validation Failed: Estimated budget cannot be a negative value.',
            'data' => ''
        ]);
        return;
    }
    
    // Prepare base data matrix
    $data = [
        'project_name'     => $this->input->post('project_name', TRUE),
        'fk_cus_id'        => $this->input->post('fk_cus_id'),
        'start_date'       => $this->input->post('start_date'),
        'end_date'         => $this->input->post('end_date'),
        'project_status'   => $this->input->post('project_status'),
        'estimated_budget' => $clean_budget
    ];

    // Handle file upload
    if (isset($_FILES['attachment']) && $_FILES['attachment']['name'] != '') {
        $upload_path = './uploads/projects/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }
        
        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE;
        
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('attachment')) {
            $upload_data = $this->upload->data();
            $data['attachment'] = $upload_data['file_name'];
        } else {
            $error = $this->upload->display_errors();
            log_message('error', 'File upload error: ' . $error);
        }
    }

    // ================== CREATE ACCOUNT ==================
    $account_class = 2; // LIABILITY
    $account_type  = 'LIABILITY';
    $parent_id     = 3;

    // Calculate level hierarchy placement depth
    $parent = $this->db->get_where('accounts', ['id' => $parent_id])->row_array();
    $level  = $parent ? $parent['level'] + 1 : 1;

    $old_post = $_POST;

    $_POST = array_merge($_POST, [
        'account_name'       => $this->input->post('project_name', TRUE),
        'account_class'      => $account_class,
        'account_type'       => $account_type,
        'parent_id'          => $parent_id,
        'is_posting'         => 1,
        'is_control_account' => 0,
        'level'              => $level
        // Optional: If your create_account model loop maps opening balances or credit constraints,
        // you can pass 'opening_balance' => $clean_budget here as well if required!
    ]);

    $this->Accounts_model->create_account();

    $_POST = $old_post;
    // ================== END OF CREATE ACCOUNT ==================

    if (!empty($id)) {
        // Update existing project
        $result = $this->project->update($id, $data);
        $message = 'Project updated successfully';
    } else {
        // Create new project
        $data['created_at'] = date('Y-m-d H:i:s');
        $result = $this->project->create($data);
        $message = 'Project created successfully';
    }

    if ($result) {
        echo json_encode([
            'stt'  => 'ok',
            'msg'  => $message,
            'data' => $id ?: $result
        ]);
    } else {
        echo json_encode([
            'stt'  => 'error',
            'msg'  => 'Operation failed',
            'data' => ''
        ]);
    }
}

    /* VIEW PROJECT */
    public function view() {
        $id = $this->input->get('lid');
        $project = $this->project->get_by_id($id);
        echo json_encode(['project' => $project]);
    }

    /* DELETE PROJECT - Exactly like Leads with stt and msg */
    public function delete() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = $this->input->get('lid');

        if (!$id) {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Invalid project id',
                'data' => ''
            ]);
            exit;
        }

        // Check if project exists
        if (!$this->project->exists($id)) {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Project not found!',
                'data' => ''
            ]);
            exit;
        }

        // Get project to delete attachment if exists
        $project = $this->project->get_by_id($id);
        if ($project && $project->attachment) {
            $file_path = './uploads/projects/' . $project->attachment;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $deleted = $this->project->delete($id);

        if ($deleted) {
            echo json_encode([
                'stt' => 'ok',
                'msg' => 'Project deleted successfully',
                'data' => $id
            ]);
        } else {
            echo json_encode([
                'stt' => 'error',
                'msg' => 'Delete failed',
                'data' => ''
            ]);
        }

        exit;
    }
	/*====================================================================================================================
															project Dashboard
	====================================================================================================================*/
	//  Updated to accept a $project_id parameter directly from the URL segment
	public function project_Dashboard($project_id = NULL) {
		
		$data = [
			'page_title'         => 'Project Dashboard',
			'selected_project_id' => $project_id, // Pass it down to your view file
			'customers'          => $this->project->get_customers() 
		];

		// Optional: If an ID is passed, you can fetch specific records right here
		if ($project_id !== NULL) {
			// e.g., $data['active_project'] = $this->project->get_project_details($project_id);
		}

		$this->load->view('header');
		$this->load->view('crm/projects/projectDashboard', $data);
		$this->load->view('footer');
	}

public function get_project_hero_details_ajax() {
    $project_id = $this->input->get('project_id');

    if (empty($project_id)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Missing project identification parameter.']);
        return;
    }

    // Join projects with customer table to map real client metadata strings
    $project = $this->db->select('
            p.project_id,
            p.project_name,
            p.estimated_budget, 
            p.start_date,
            p.end_date,
            p.project_status,
            p.created_at,
            p.fk_cus_id,
            c.cus_name,
            c.company_name
        ')
        ->from('projects p')
        ->join('customer c', 'p.fk_cus_id = c.cus_id', 'inner')
        ->where('p.project_id', $project_id)
        ->get()
        ->row_array();

    if (!$project) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Project not found.']);
        return;
    }

    // Calculate structural relative time parameters safely
    $now = new DateTime();
    $elapsed_sub = '—';
    $remaining_sub = '—';

    if (!empty($project['start_date'])) {
        $start = new DateTime($project['start_date']);
        if ($now > $start) {
            $diff = $now->diff($start);
            $elapsed_sub = $diff->days . ' days ago';
        } else {
            $elapsed_sub = 'Starts in future';
        }
        $project['start_date_formatted'] = date('M d, Y', strtotime($project['start_date']));
    } else {
        $project['start_date_formatted'] = 'Not Set';
    }

    if (!empty($project['end_date'])) {
        $end = new DateTime($project['end_date']);
        if ($end > $now) {
            $diff = $now->diff($end);
            $remaining_sub = $diff->days . ' days remaining';
        } else {
            $remaining_sub = 'Overdue / Completed';
        }
        $project['end_date_formatted'] = date('M d, Y', strtotime($project['end_date']));
    } else {
        $project['end_date_formatted'] = 'Not Set';
    }

    $project['created_date_formatted'] = date('M d, Y', strtotime($project['created_at']));
    $project['elapsed_sub'] = $elapsed_sub;
    $project['remaining_sub'] = $remaining_sub;

    // Standard fallback configs for elements not explicitly tracked inside project schema tables yet
    $project['category'] = 'Interior & Fit-out'; 
    $project['manager'] = 'Saman Silva';
    $project['progress_pct'] = 42; 

    // 🎯 DYNAMIC BUDGET FORMATTING: Fallback to 0 if null, format with commas
    $rawBudget = floatval($project['estimated_budget'] ?? 0);
    $project['budget'] = 'Rs. ' . number_format($rawBudget, 2); 

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'project' => $project
    ]);
}

/*public function get_issued_items_ajax() {
    // 1. Capture the GET parameter
    $project_id = $this->input->get('project_id');

    if (empty($project_id)) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing project identification parameter.'
        ]);
        return;
    }

    //2. Your exact requested SQL structure written in Active Record
    $issued_items = $this->db->select('
            sii.id,
            p.product_code AS code,
            p.name AS name,
            p.measure_unit AS unit,
            sii.qty,
            p.last_purchase_price AS unit_cost,
            sa.st_act_date AS date,
            sa.note
        ')
        ->from('stock_issue_items sii')
        ->join('stock_activities sa', 'sii.fk_st_activity_id = sa.st_activity_id', 'inner')
        ->join('products p', 'sii.product_id = p.id', 'inner')
        ->where('sa.project_id', $project_id)
        ->where('sa.act_type', 'issue')
        ->where('sa.status', 'approved')
        ->order_by('sa.st_act_date', 'DESC')
        ->get()
        ->result_array();

    // 3. Optional: Add a hardcoded fallback string for "cat" and "issued_by" 
    // so your frontend renderItems() function doesn't show "undefined"
    foreach ($issued_items as &$item) {
        $item['cat'] = 'Stock Item'; // Temporary placeholder until category column is known
        $item['issued_by'] = 'System'; // Temporary placeholder until user column is known
        $item['qty'] = floatval($item['qty']);
        $item['unit_cost'] = floatval($item['unit_cost']);
    }

    // 4. Output the raw JSON data payload back to the browser
    echo json_encode([
        'success'      => true,
        'issued_items' => $issued_items
    ]);
}*/

	public function get_issued_items_ajax() {
		$project_id = $this->input->get('project_id');
		
		if (!$project_id) {
			echo json_encode([]);
			return;
		}

		// 🎯 FIXED LOGIC: COUNT(DISTINCT ...) checks unique product variations per activity group
		$this->db->select("
			sa.st_activity_id AS activity_id,
			sa.st_act_date AS activity_date,
			sa.create_by AS created_by,
			sa.note AS remarks,
			COUNT(DISTINCT sti.product_id) AS total_product_count
		");
		$this->db->from('stock_activities sa');
		$this->db->join('stock_transaction_items sti', 'sa.st_activity_id = sti.fk_st_activity_id', 'left');
		
		$this->db->where('sa.project_id', $project_id);
		$this->db->where('sa.act_type', 'issue');
		
		$this->db->group_by(array('sa.st_activity_id', 'sa.st_act_date', 'sa.create_by', 'sa.note'));
		$this->db->order_by('sa.st_activity_id', 'DESC');
		
		$query = $this->db->get();
		$result = $query->result_array();

		// Ensure it's returned cleanly as a number type
		foreach ($result as &$row) {
			$row['total_product_count'] = (int)$row['total_product_count'];
		}

		header('Content-Type: application/json');
		echo json_encode($result);
	}	

																					//project expences [kalhara]
	public function get_project_expenses_ajax() {
    $project_id = $this->input->get('project_id');

    if (empty($project_id)) {
        echo json_encode(['success' => false, 'message' => 'Missing project identification parameter.']);
        return;
    }

    //Select columns directly from the expenses table without any JOINs
    $expenses = $this->db->select('
            exp_id AS id,
            expense_date AS date,
            reference_no AS ref,
            family_id AS family,       
            cat_id AS cat,          
            type_id AS type,         
            note AS description,        
            bank_acc_id AS account,   
            qty,                        
            total_amount AS amount       
        ')
        ->from('expenses')
        ->where('project_id', $project_id)
        ->where('status !=', 'deleted')
        ->order_by('expense_date', 'DESC')
        ->get()
        ->result_array();

    // Static mapping definitions to mimic database text relationships
    $family_map = [1 => 'payroll', 2 => 'logistics', 3 => 'operational', 4 => 'utilities', 5 => 'marketing'];
    $cat_map    = [1 => 'Salaries', 2 => 'Fuel & Transport', 3 => 'Rent & Premises', 4 => 'Electricity', 5 => 'Advertising'];
    $type_map   = [1 => 'Monthly Salary', 2 => 'Fuel', 3 => 'Office Rent', 4 => 'Generator Fuel', 5 => 'Print'];
    $acc_map    = [1 => 'Commercial Bank A/C', 2 => 'Petty Cash Float', 3 => 'Main Cash Account', 4 => 'Corporate Credit Card'];
// meka db eken adinna one 
    //Data Normalizer loop
    foreach ($expenses as &$exp) {
        $exp['qty'] = intval($exp['qty']);
        
        // Calculate the unit amount out of total_amount to perfectly match your frontend expectations
        $exp['amount'] = $exp['qty'] > 0 ? floatval($exp['amount'] / $exp['qty']) : floatval($exp['amount']);
        
        // Convert numbers to matching string representations for dashboard UI rendering engines
        $exp['family']  = $family_map[$exp['family']]   ?? 'operational';
        $exp['cat']     = $cat_map[$exp['cat']]         ?? 'General Expenses';
        $exp['type']    = $type_map[$exp['type']]       ?? 'Other Cost';
        $exp['account'] = $acc_map[$exp['account']]     ?? 'Main Account';
    }

    echo json_encode([
        'success'  => true,
        'expenses' => $expenses
    ]);
}
	
/*public function get_sales_invoices_ajax() {
    // 1. Gather the query validation parameter safely
    $project_id = $this->input->get('project_id');

    if (empty($project_id)) {
        echo json_encode([
            'success' => false,
            'message' => 'Identification mismatch payload validation error.'
        ]);
        return;
    }

    // 2. Fetch required architecture schema keys exclusively 
    $invoices = $this->db->select('
            id,
            invoice_no,
            invoice_date,
            due_date,
            total_items,
            total_qty,
            grand_total,
            paid_amount,
            balance_amount,
            status
        ')
        ->from('_sales_invoices')
        ->where('project_id', $project_id) // Ensures records isolate back into this target project row dashboard
        ->order_by('invoice_date', 'DESC')
        ->get()
        ->result_array();

    // 3. Clean string mutation conversions cleanly without array dot errors
    foreach ($invoices as &$inv) {
        $inv['invoice_date'] = date('Y-m-d H:i', strtotime($inv['invoice_date']));
        if (!empty($inv['due_date'])) {
            $inv['due_date'] = date('Y-m-d', strtotime($inv['due_date']));
        }
    }

    // 4. Return serialized stream back to UI runtime loop
    echo json_encode([
        'success'  => true,
        'invoices' => $invoices
    ]);
}*/

/*public function get_sales_invoices_ajax() {
    $project_id = $this->input->get('project_id');

    if (empty($project_id)) {
        echo json_encode(['success' => false, 'message' => 'Project identification token is missing.']);
        return;
    }

    $invoices = $this->db->select('
            id,
            invoice_no,
            invoice_date,
            due_date,
            total_items,
            total_qty,
            grand_total,
            paid_amount,
            balance_amount,
            status
        ')
        ->from('sales_invoices')          // FIX: Corrected table name
        ->where('project_id', $project_id)
        ->where('status', 'PROJECT')       // FIX: Swapped to uppercase matching the DB ENUM
        ->order_by('invoice_date', 'DESC')
        ->get()
        ->result_array();

    foreach ($invoices as &$inv) {
        $inv['invoice_date'] = date('Y-m-d H:i', strtotime($inv['invoice_date']));
        if (!empty($inv['due_date'])) {
            $inv['due_date'] = date('Y-m-d', strtotime($inv['due_date']));
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success'  => true,
        'invoices' => $invoices
    ]);
}*/

	/*public function get_sales_invoices_ajax() {
    $project_id = $this->input->get('project_id');

    if (empty($project_id)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Project identification token is missing.']);
        return;
    }

    // 1. Fetch itemized row rows for your data table ledger display
    $invoices = $this->db->select('
            id,
            invoice_no,
            invoice_date,
            due_date,
            total_items,
            total_qty,
            grand_total,
            paid_amount,
            balance_amount,
            status
        ')
        ->from('sales_invoices')          
        ->where('project_id', $project_id)
        ->where('status', 'PROJECT')       
        ->order_by('invoice_date', 'DESC')
        ->get()
        ->result_array();

    // 2. 🎯 NEW MATH LOGIC: Calculate project-wise aggregates via SQL SUM operators
    $totals = $this->db->select('
            SUM(COALESCE(grand_total, 0)) as aggregate_invoice_total,
            SUM(COALESCE(paid_amount, 0)) as aggregate_paid_total,
            SUM(COALESCE(balance_amount, 0)) as aggregate_balance_total
        ')
        ->from('sales_invoices')
        ->where('project_id', $project_id)
        ->where('status', 'PROJECT')
        ->get()
        ->row_array();

    // Format row datetimes safely
    foreach ($invoices as &$inv) {
        $inv['invoice_date'] = date('Y-m-d H:i', strtotime($inv['invoice_date']));
        if (!empty($inv['due_date'])) {
            $inv['due_date'] = date('Y-m-d', strtotime($inv['due_date']));
        }
    }

    // 3. Return both structural layers in the unified JSON stream mapping pipeline
    header('Content-Type: application/json');
    echo json_encode([
        'success'                  => true,
        'invoices'                 => $invoices,
        'aggregate_invoice_total'  => floatval($totals['aggregate_invoice_total'] ?? 0),
        'aggregate_paid_total'     => floatval($totals['aggregate_paid_total'] ?? 0),
        'aggregate_balance_total'  => floatval($totals['aggregate_balance_total'] ?? 0)
    ]);
}*/
	
public function commit_sales_invoice_ajax() {
    // 1. Enforce strict AJAX access validation security
    if (!$this->input->is_ajax_request()) {
        show_404();
        return;
    }

    // 2. Sanitize and structure incoming JavaScript payload variables
    $data = array(
        'project_id'          => $this->input->post('project_id'),
        'invoice_no'          => $this->input->post('invoice_no'),
        'warehouse_id'        => $this->input->post('warehouse_id'),
        'invoice_date'        => $this->input->post('invoice_date'),
        // If due_date arrives empty or as a string 'null', write standard SQL NULL
        'due_date'            => (!empty($this->input->post('due_date')) && $this->input->post('due_date') !== 'null') ? $this->input->post('due_date') : NULL,
        'total_items'         => intval($this->input->post('total_items')),
        'total_qty'           => floatval($this->input->post('total_qty')),
        'total_free_qty'      => floatval($this->input->post('total_free_qty')),
        'subtotal'            => floatval($this->input->post('subtotal')),
        'line_discount_total' => floatval($this->input->post('line_discount_total')),
        'bill_discount_value' => floatval($this->input->post('bill_discount_value')),
        'bill_discount_type'  => $this->input->post('bill_discount_type'),
        'tax_total'           => floatval($this->input->post('tax_total')),
        'grand_total'         => floatval($this->input->post('grand_total')),
        'paid_amount'         => floatval($this->input->post('paid_amount')),
        'balance_amount'      => floatval($this->input->post('balance_amount')),
		'status'              => 'PROJECT',
        'remarks'             => trim($this->input->post('remarks')),
        'created_at'          => date('Y-m-d H:i:s')
    );

    // 3. Fallback server-side verification check
    if (empty($data['invoice_no']) || empty($data['project_id']) || $data['subtotal'] <= 0) {
        echo json_encode(array(
            'success' => false, 
            'message' => 'Validation error: Missing critical invoice metrics.'
        ));
        return;
    }

    // 4. Check for duplicate invoice numbers to protect database integrity
    $duplicate_check = $this->db->get_where('sales_invoices', array('invoice_no' => $data['invoice_no']))->num_rows();
    if ($duplicate_check > 0) {
        echo json_encode(array(
            'success' => false, 
            'message' => 'Invoice code structure conflict: ' . $data['invoice_no'] . ' already exists inside the ledger.'
        ));
        return;
    }

    // 5. Commit record transaction to the active table ledger
    // NOTE: Change 'sales_invoices' if your database table uses a different name!
    $inserted = $this->db->insert('sales_invoices', $data);

    // 6. Return response stream to the front-end AJAX handler
    header('Content-Type: application/json');
    if ($inserted) {
        echo json_encode(array(
            'success' => true, 
            'message' => 'Sales Invoice successfully recorded.'
        ));
    } else {
        $db_error = $this->db->error();
        echo json_encode(array(
            'success' => false, 
            'message' => 'Database exception failure: ' . $db_error['message']
        ));
    }
}
	public function save_project_note_ajax() {
    if (!$this->input->is_ajax_request()) { show_404(); return; }

    $project_id = $this->input->post('project_id');
    $note_text  = trim($this->input->post('note_text'));

    // 1. Fetch user ID directly out of the active CodeIgniter user session framework
    $session_user_id = $this->session->userdata('user_id'); // <-- Double-check if your app uses 'id' or 'user_id'

    // 2. Fallback verification: Force an active session check
    if (empty($session_user_id)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Authentication expired. Please log in again to post updates.'
        ]);
        return;
    }

    if (empty($project_id) || empty($note_text)) {
        echo json_encode(['success' => false, 'message' => 'Note content cannot be empty.']);
        return;
    }

    $data = [
        'project_id' => $project_id,
        'note_text'  => $note_text,
        'created_by' => $session_user_id, // Writes the explicit foreign user index integer directly
        'created_at' => date('Y-m-d H:i:s')
    ];

    if ($this->db->insert('project_notes', $data)) {
        echo json_encode(['success' => true, 'message' => 'Note successfully attached.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database exception encountered.']);
    }
}

public function get_project_notes_ajax() {
    if (!$this->input->is_ajax_request()) { show_404(); return; }

    $project_id = $this->input->get('project_id');
    if (empty($project_id)) {
        echo json_encode(['success' => false, 'message' => 'Project target missing.']);
        return;
    }

    $notes = $this->db->select('
                pn.id, 
                pn.note_text AS text, 
                pn.created_at AS time,
                u.name AS by
             ') // ◄─── CHANGE 'u.first_name' TO YOUR EXACT COLUMN (e.g., u.name or u.username)
                      ->from('project_notes AS pn')
                      ->join('users AS u', 'u.id = pn.created_by', 'left') 
                      ->where('pn.project_id', $project_id)
                      ->order_by('pn.created_at', 'DESC')
                      ->get()
                      ->result_array();

    foreach ($notes as &$note) {
        $note['time'] = date('Y-m-d H:i', strtotime($note['time']));
        if (empty($note['by'])) {
            $note['by'] = 'System User';
        }
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'notes' => $notes]);
}

	public function delete_project_note_ajax() {
    if (!$this->input->is_ajax_request()) { show_404(); return; }

    $note_id = $this->input->post('note_id');
    if (empty($note_id)) {
        echo json_encode(['success' => false, 'message' => 'Target identifier missing.']);
        return;
    }

    if ($this->db->delete('project_notes', ['id' => $note_id])) {
        echo json_encode(['success' => true, 'message' => 'Note dropped successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database delete operation failed.']);
    }
}

public function get_project_activity_ajax() {
    if (!$this->input->is_ajax_request()) {
        show_404();
        return;
    }
	
	$this->load->helper('text');
	
    $project_id = $this->input->get('project_id');
    if (empty($project_id)) {
        echo json_encode(['success' => false, 'message' => 'Project target identification missing.']);
        return;
    }

    $combined_timeline = [];

    // ══════════════════════════════════════════════════════════════════
    // 1. FETCH & FORMAT SALES INVOICES
    // ══════════════════════════════════════════════════════════════════
    $invoices = $this->db->select('si.id, si.invoice_no, si.grand_total, si.created_at, u.name AS user_name')
                         ->from('sales_invoices AS si')
                         ->join('users AS u', 'u.id = si.created_by', 'left')
                         ->where('si.project_id', $project_id)
                         ->where('si.status', 'PROJECT')
                         ->get()
                         ->result_array();

    foreach ($invoices as $inv) {
        $combined_timeline[] = [
            'id'    => $inv['id'],
            'type'  => 'payment',
            'color' => '#10b981',
            'msg'   => "Invoice created — <strong>" . $inv['invoice_no'] . "</strong> — Rs. " . number_format($inv['grand_total'], 2),
            'by'    => !empty($inv['user_name']) ? $inv['user_name'] : 'System',
            'time'  => $inv['created_at']
        ];
    }

    // ══════════════════════════════════════════════════════════════════
    // 2. FETCH & FORMAT EXPENSES
    // ══════════════════════════════════════════════════════════════════
    // Assumes your expenses table links back to the user via a 'created_by' column, change if different
    $expenses = $this->db->select('e.exp_id, e.note, e.total_amount, e.created_at')
                         ->from('expenses AS e')
                         ->where('e.project_id', $project_id)
                         ->where('e.status', 'active')
                         ->get()
                         ->result_array();

    foreach ($expenses as $exp) {
        $combined_timeline[] = [
            'id'    => $exp['exp_id'],
            'type'  => 'expense',
            'color' => '#ef4444',
            'msg'   => "Expense added — <strong>" . ($exp['note'] ? $exp['note'] : 'General Expense') . "</strong> — Rs. " . number_format($exp['total_amount'], 2),
            'by'    => 'Admin', // Adjust dynamically if expenses table records user accounts
            'time'  => $exp['created_at']
        ];
    }

    // ══════════════════════════════════════════════════════════════════
    // 3. FETCH & FORMAT PROJECT NOTES
    // ══════════════════════════════════════════════════════════════════
    $notes = $this->db->select('pn.id, pn.note_text, pn.created_at, u.name AS user_name')
                      ->from('project_notes AS pn')
                      ->join('users AS u', 'u.id = pn.created_by', 'left')
                      ->where('pn.project_id', $project_id)
                      ->get()
                      ->result_array();

    foreach ($notes as $note) {
        $combined_timeline[] = [
            'id'    => $note['id'],
            'type'  => 'note',
            'color' => '#f59e0b',
            'msg'   => "Note added: <em>\"" . character_limiter($note['note_text'], 60) . "\"</em>",
            'by'    => !empty($note['user_name']) ? $note['user_name'] : 'System User',
            'time'  => $note['created_at']
        ];
    }

    // ══════════════════════════════════════════════════════════════════
    // 4. FETCH & FORMAT STOCK ACTIVITIES
    // ══════════════════════════════════════════════════════════════════
    $stocks = $this->db->select('sa.st_activity_id, sa.act_type, sa.qty, sa.note, sa.st_act_date, u.name AS user_name')
                       ->from('stock_activities AS sa')
                       ->join('users AS u', 'u.id = sa.create_by', 'left')
                       ->where('sa.project_id', $project_id)
                       ->get()
                       ->result_array();

    foreach ($stocks as $st) {
        $combined_timeline[] = [
            'id'    => $st['st_activity_id'],
            'type'  => 'item',
            'color' => '#3d52a0',
            'msg'   => "Stock " . ucfirst($st['act_type']) . " — <strong>Qty: " . floatval($st['qty']) . "</strong> " . ($st['note'] ? " — " . $st['note'] : ""),
            'by'    => !empty($st['user_name']) ? $st['user_name'] : 'Inventory System',
            'time'  => $st['st_act_date']
        ];
    }

    // ══════════════════════════════════════════════════════════════════
    // 5. SORT TIMELINE CHRONOLOGICALLY (DESCENDING)
    // ══════════════════════════════════════════════════════════════════
    usort($combined_timeline, function($a, $b) {
        return strtotime($b['time']) - strtotime($a['time']);
    });

    // ══════════════════════════════════════════════════════════════════
    // 6. FORMAT TIMESTAMP STRINGS & RETURN SERIALIZED DATA
    // ══════════════════════════════════════════════════════════════════
    foreach ($combined_timeline as &$item) {
        $item['time'] = date('Y-m-d H:i', strtotime($item['time']));
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success'  => true,
        'activity' => $combined_timeline
    ]);
}

	/*public function get_product_base_items_ajax() {
    $project_id = $this->input->get('project_id');
    
    if (!$project_id) {
        echo json_encode([]);
        return;
    }

    // 🎯 Matching your schema: p.id joins with sti.product_id, and p.name is the column name
    $this->db->select("
        sti.product_id,
        MAX(p.name) AS product_name,
        SUM(COALESCE(sti.qty, 0)) AS total_quantity_issued,
        COUNT(sa.st_activity_id) AS total_transactions_count
    ");
    $this->db->from('stock_transaction_items sti');
    
    // Join with stock_activities using internal key constraints
    $this->db->join('stock_activities sa', 'sti.fk_st_activity_id = sa.st_activity_id', 'inner');
    
    // 🎯 CRITICAL JOIN ADJUSTMENT FOR YOUR SCHEMA:
    // sti.product_id references products.id
    $this->db->join('products p', 'sti.product_id = p.id', 'left');
    
    $this->db->where('sa.project_id', $project_id);
    $this->db->where('sa.act_type', 'issue');
    
    // Group strictly by product identifier to sum totals per item cleanly
    $this->db->group_by('sti.product_id');
    $this->db->order_by('total_quantity_issued', 'DESC');
    
    $query = $this->db->get();
    $result = $query->result_array();

    header('Content-Type: application/json');
    echo json_encode($result);
}*/
	public function get_product_base_items_ajax() {
		$project_id = $this->input->get('project_id');
			
		if (!$project_id) {
			header('Content-Type: application/json');
			echo json_encode(['success' => false, 'products' => [], 'grand_issued_value' => 0]);
			return;
		}

		// 🎯 Corrected Select fields mapping back to your structural schemas
		$this->db->select("
			sti.product_id,
			MAX(p.name) AS product_name,
			SUM(COALESCE(sti.qty, 0)) AS total_quantity_issued,
			SUM(COALESCE(sti.qty, 0) * COALESCE(p.last_purchase_price, 0)) AS total_item_value,
			COUNT(sa.st_activity_id) AS total_transactions_count
		");
		$this->db->from('stock_transaction_items sti');
		$this->db->join('stock_activities sa', 'sti.fk_st_activity_id = sa.st_activity_id', 'inner');
		$this->db->join('products p', 'sti.product_id = p.id', 'left');
			
		$this->db->where('sa.project_id', $project_id);
		$this->db->where('sa.act_type', 'issue');
		// Note: If testing an unapproved test project, you can comment out the next line temporarily
		$this->db->where('sa.status', 'approved'); 
		
		$this->db->group_by('sti.product_id');
		$this->db->order_by('total_quantity_issued', 'DESC');
		
		$products = $this->db->get()->result_array();

		// 🎯 FIXED: Changed array dot syntax accessor to standard PHP array key hooks
		$grand_issued_value = 0;
		foreach ($products as $p) {
			$grand_issued_value += floatval($p['total_item_value']);
		}

		header('Content-Type: application/json');
		echo json_encode([
			'success'             => true,
			'products'            => $products,
			'grand_issued_value'  => $grand_issued_value 
		]);
}










	public function product_search() {
        $term = $this->input->get('term');
        echo json_encode($this->Project_invoice_model->search_products($term));
    }

    // public function save_invoice() {
		// $items_json = $this->input->post('items');
		// $items = json_decode($items_json, true);
		// if (empty($items)) {
			// echo json_encode(['status' => false, 'message' => 'No products added.']);
			// return;
		// }
		// $data = [
			// 'project_id'   => (int) $this->input->post('project_id'),
			// 'invoice_date' => $this->input->post('invoice_date'),
			// 'due_date'     => $this->input->post('due_date'),
			// 'paid_amount'  => (float) $this->input->post('paid_amount'),
			// 'discount'     => (float) $this->input->post('invoice_discount'),
			// 'notes'        => $this->input->post('notes'),
		// ];
		// $clean_items = [];
		// foreach ($items as $it) {
			// $qty      = (float) $it['qty'];
			// $price    = (float) $it['unit_price'];
			// $discount = (float) ($it['discount'] ?? 0);
			// $clean_items[] = [
				// 'product_id'   => (int) $it['product_id'],
				// 'product_name' => $it['product_name'],
				// 'product_code' => $it['product_code'] ?? null,
				// 'unit_price'   => $price,
				// 'qty'          => $qty,
				// 'discount'     => $discount,
				// 'line_total'   => ($qty * $price) - $discount,
			// ];
		// }
		// $invoice_id = $this->Project_invoice_model->save_invoice($data, $clean_items);
		// if ($invoice_id) {
			// echo json_encode(['status' => true, 'invoice_id' => $invoice_id]);
		// } else {
			// echo json_encode(['status' => false, 'message' => 'Failed to save invoice.']);
		// }
	// }
	
	/*public function save_invoice()
	{
		$items_json = $this->input->post('items');
		$items = json_decode($items_json, true);

		if (empty($items) || !is_array($items)) {
			echo json_encode([
				'status'  => false,
				'message' => 'No products added.'
			]);
			return;
		}

		$project_id = (int) $this->input->post('project_id');

		if ($project_id <= 0) {
			echo json_encode([
				'status'  => false,
				'message' => 'Invalid project ID.'
			]);
			return;
		}

		/*
		 * sales_invoices requires warehouse_id.
		 * Send this from your project if you have a warehouse assigned.
		 */
		/*$warehouse_id = (int) $this->input->post('warehouse_id');
		$branch_id    = (int) $this->input->post('branch_id');

		/*if ($warehouse_id <= 0) {
			echo json_encode([
				'status'  => false,
				'message' => 'Warehouse is required.'
			]);
			return;
		}*/

		/*$data = [
			'project_id'   => (int) $this->input->post('project_id'),

			'warehouse_id' => (int) $this->input->post('warehouse_id'),

			'branch_id'    => (int) $this->input->post('branch_id'),

			'invoice_date' => $this->input->post('invoice_date'),

			'due_date'     => $this->input->post('due_date'),

			'paid_amount'  => (float) $this->input->post('paid_amount'),

			'discount'     => (float) $this->input->post('invoice_discount'),

			'notes'        => $this->input->post('notes'),
		];

		$clean_items = [];

		foreach ($items as $it) {

			$product_id = (int) ($it['product_id'] ?? 0);
			$qty        = (float) ($it['qty'] ?? 0);
			$price      = (float) ($it['unit_price'] ?? 0);
			$discount   = (float) ($it['discount'] ?? 0);

			if ($product_id <= 0) {
				echo json_encode([
					'status'  => false,
					'message' => 'Invalid product.'
				]);
				return;
			}

			if ($qty <= 0) {
				echo json_encode([
					'status'  => false,
					'message' => 'Invalid quantity.'
				]);
				return;
			}

			if ($price < 0) {
				echo json_encode([
					'status'  => false,
					'message' => 'Invalid price.'
				]);
				return;
			}

			if ($discount < 0) {
				$discount = 0;
			}

			$gross_total = $qty * $price;

			if ($discount > $gross_total) {
				$discount = $gross_total;
			}

			$line_total = $gross_total - $discount;

			$clean_items[] = [
				'product_id'   => $product_id,
				'product_name' => $it['product_name'] ?? '',
				'product_code' => $it['product_code'] ?? '',
				'unit_price'   => $price,
				'qty'          => $qty,
				'discount'     => $discount,
				'line_total'   => $line_total
			];
		}

		$invoice_id = $this->Project_invoice_model->save_invoice(
			$data,
			$clean_items
		);

		if ($invoice_id) {

			echo json_encode([
				'status'     => true,
				'invoice_id' => $invoice_id
			]);

		} else {

			echo json_encode([
				'status'  => false,
				'message' => 'Failed to save invoice.'
			]);
		}
	}*/
	
	
	public function save_invoice()
	{
		/*
		|--------------------------------------------------------------------------
		| ITEMS
		|--------------------------------------------------------------------------
		*/

		$items_json = $this->input->post('items');
		$items = json_decode($items_json, true);

		if (empty($items) || !is_array($items)) {
			echo json_encode(['status'  => false, 'message' => 'No products added.']);
			return;
		}

		/*
		|--------------------------------------------------------------------------
		| PROJECT
		|--------------------------------------------------------------------------
		*/
		$project_id = (int) $this->input->post('project_id');

		if ($project_id <= 0) {
			echo json_encode(['status'  => false,'message' => 'Invalid project ID.']);
			return;
		}

		/*
		|--------------------------------------------------------------------------
		| PAYMENTS
		|--------------------------------------------------------------------------
		*/

		$payments_json = $this->input->post('payments');
		$payments = json_decode($payments_json, true);

		if (!is_array($payments)) {
			$payments = [];
		}

		/*
		|--------------------------------------------------------------------------
		| Warehouse / Branch
		|--------------------------------------------------------------------------
		*/

		$warehouse_id = (int) $this->input->post('warehouse_id');
		$branch_id = (int) $this->input->post('branch_id');


		/*
		|--------------------------------------------------------------------------
		| Invoice Data
		|--------------------------------------------------------------------------
		*/

		$data = [
			'project_id' => $project_id,
			'warehouse_id' => $warehouse_id,
			'branch_id' => $branch_id,
			'invoice_date' => $this->input->post('invoice_date'),
			'due_date' => $this->input->post('due_date'),
			'paid_amount' => (float) $this->input->post('paid_amount'),
			'discount' =>(float) $this->input->post('invoice_discount'),
			'notes' => $this->input->post('notes')
		];


		/*
		|--------------------------------------------------------------------------
		| Clean Invoice Items
		|--------------------------------------------------------------------------
		*/

		$clean_items = [];

		foreach ($items as $it) {

			$product_id = (int) ($it['product_id'] ?? 0);
			$qty = (float) ($it['qty'] ?? 0);
			$price = (float) ($it['unit_price'] ?? 0);
			$discount = (float) ($it['discount'] ?? 0);

			if ($product_id <= 0) {
				echo json_encode(['status'  => false,'message' => 'Invalid product.']);
				return;
			}

			if ($qty <= 0) {
				echo json_encode(['status'  => false,'message' => 'Invalid quantity.']);
				return;
			}

			if ($price < 0) {
				echo json_encode([
					'status'  => false,
					'message' => 'Invalid price.'
				]);
				return;
			}

			if ($discount < 0) {
				$discount = 0;
			}

			$gross_total = $qty * $price;

			if ($discount > $gross_total) {
				$discount =	$gross_total;
			}

			$line_total = $gross_total - $discount;

			$clean_items[] = [
				'product_id' =>$product_id,
				'product_name' =>$it['product_name'] ?? '',
				'product_code' =>$it['product_code'] ?? '',
				'unit_price' =>$price,
				'qty' =>$qty,
				'discount' => $discount,
				'line_total' => $line_total
			];
		}
		
		/*
		|--------------------------------------------------------------------------
		| Clean Payment Methods
		|--------------------------------------------------------------------------
		*/

		$clean_payments = [];
		$allowed_methods = ['CASH','CARD','BANK','CHEQUE'];

		foreach ($payments as $payment) {
			$method = strtoupper(trim($payment['payment_method'] ?? ''));
			$amount = (float) ($payment['amount'] ?? 0);

			/*
			| Skip empty payment rows
			*/

			if ($amount <= 0 && empty($method)) {
				continue;
			}

			/*
			| Validate method
			*/
			if (!in_array($method,$allowed_methods,true)) {
				echo json_encode(['status'  => false,'message' => 'Invalid payment method.']);
				return;
			}

			/*
			| Amount
			*/
			if ($amount <= 0) {
				echo json_encode(['status'  => false,'message' =>'Payment amount must be greater than zero.']);
				return;
			}
			
			$payment_data = ['payment_method' =>$method,'amount' =>$amount,'card_number' =>null,'card_expiry' =>null,'cheque_no' =>null,'cheque_date' =>null,'bank_name' =>null,'reference_no' =>null];

			/*
			|--------------------------------------------------------------------------
			| CARD
			|--------------------------------------------------------------------------
			*/
			if ($method === 'CARD') {

				$card_number =preg_replace('/\s+/','',$payment['card_number'] ?? '');
				$card_expiry = trim($payment['card_expiry'] ?? '');

				if (!preg_match('/^\d{16}$/',$card_number)) {
					echo json_encode(['status'  => false,'message' =>'Invalid card number.']);
					return;
				}

				if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/',$card_expiry)) {
					echo json_encode(['status'  => false,'message' =>'Invalid card expiry date.']);
					return;
				}

				/*
				| Validate expiry is not past
				*/

				list($month,$year) = explode('/',$card_expiry);
				$month =(int) $month;
				$year = 2000 + (int) $year;
				$current_year = (int) date('Y');
				$current_month =(int) date('m');

				if ($year < $current_year ||($year === $current_year && $month < $current_month)) {
					echo json_encode(['status'  => false,'message' =>'Card has expired.']);
					return;
				}

				$payment_data['card_number'] = $card_number;
				$payment_data['card_expiry'] = $card_expiry;

			}

			/*
			|--------------------------------------------------------------------------
			| BANK
			|--------------------------------------------------------------------------
			*/

			if ($method === 'BANK') {

				$payment_data['bank_name'] = trim($payment['bank_name'] ?? '');
				$payment_data['reference_no'] =trim($payment['reference_no'] ?? '');
			}


			/*
			|--------------------------------------------------------------------------
			| CHEQUE
			|--------------------------------------------------------------------------
			*/

			if ($method === 'CHEQUE') {

				$cheque_no =
					trim(
						$payment['cheque_no'] ?? ''
					);

				$cheque_date =
					trim(
						$payment['cheque_date'] ?? ''
					);


				if ($cheque_no === '') {

					echo json_encode([
						'status'  => false,
						'message' =>
							'Cheque number is required.'
					]);

					return;
				}


				if ($cheque_date === '') {

					echo json_encode([
						'status'  => false,
						'message' =>
							'Cheque date is required.'
					]);

					return;
				}
				

				$payment_data['cheque_no'] =
					$cheque_no;

				$payment_data['cheque_date'] =
					$cheque_date;

			}


			$clean_payments[] =
				$payment_data;

		}


		/*
		|--------------------------------------------------------------------------
		| Payment Total
		|--------------------------------------------------------------------------
		*/

		$payment_total = 0;

		foreach ($clean_payments as $payment) {

			$payment_total +=
				(float) $payment['amount'];

		}


		/*
		|--------------------------------------------------------------------------
		| Compare with frontend paid amount
		|--------------------------------------------------------------------------
		*/

		$frontend_paid =
			(float) $data['paid_amount'];


		if (
			abs(
				$payment_total -
				$frontend_paid
			) > 0.01
		) {

			/*
			| Server is authoritative.
			*/

			$data['paid_amount'] =
				$payment_total;

		}


		/*
		|--------------------------------------------------------------------------
		| Save
		|--------------------------------------------------------------------------
		*/

		$invoice_id =
			$this->Project_invoice_model->save_invoice(
				$data,
				$clean_items,
				$clean_payments
			);


		if ($invoice_id) {

			echo json_encode([

				'status' =>
					true,

				'invoice_id' =>
					$invoice_id

			]);

		} else {

			echo json_encode([

				'status' =>
					false,

				'message' =>
					'Failed to save invoice.'

			]);

		}
	}	

    // Matches the AJAX call already in your view
    public function get_sales_invoices_ajax() {
        $project_id = $this->input->get('project_id');

        if (!$project_id) {
            echo json_encode(['success' => false, 'message' => 'Missing project_id.']);
            return;
        }

        $invoices = $this->Project_invoice_model->get_invoices_by_project($project_id);
        $agg = $this->Project_invoice_model->get_aggregates_by_project($project_id);

        echo json_encode([
            'success' => true,
            'invoices' => $invoices,
            'aggregate_invoice_total' => $agg['total_billing'],
            'aggregate_paid_total'    => $agg['total_paid'],
            'aggregate_balance_total' => $agg['total_balance'],
        ]);
    }

    public function view_invoice($invoice_id) {
        $invoice = $this->Project_invoice_model->get_invoice($invoice_id);
        if (!$invoice) {
            echo json_encode(['status' => false]);
            return;
        }
        echo json_encode(['status' => true, 'invoice' => $invoice]);
    }

    public function delete_invoice($invoice_id) {
        $ok = $this->Project_invoice_model->delete_invoice($invoice_id);
        echo json_encode(['status' => (bool) $ok]);
    }

	public function print_invoice() {
		
		$invoice_id = $_GET['inv_id'];
		
        $invoice = $this->Project_invoice_model->get_invoice($invoice_id);
		
		// print_r($invoice);
		// exit;
        if (!$invoice) { show_error('Invoice not found', 404); return; }
        $data['invoice'] = $invoice;
		$this->load->view('crm/projects/print', $data);
    
	}
	
	public function print_Do() {
		
		$act_id = $this->input->get('act_id');

		if (!$act_id) {
			show_error('Issue ID is required', 400);
			return;
		}

		$do = $this->Project_invoice_model->get_issues($act_id);

		if (!$do || !$do['activity']) {
			show_error('Issue not found', 404);
			return;
		}

		$data['do'] = $do;

		//print_r($data);
		//exit;

		$this->load->view('crm/projects/project_issues_do', $data);
    
	}

	
}