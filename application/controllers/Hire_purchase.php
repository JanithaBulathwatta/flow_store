<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hire_purchase — Controller
 * Thin controller: receive → delegate to model → respond.
 */
class Hire_purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('crm/HP_model');
		$this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload');
       
    }

    /**
     * GET /hire-purchase
     * Main page - serve the creation view
     */
    public function index()
    {
        // JUST LOAD VIEWS - NO DATA PASSED
        // All data will be loaded via AJAX calls
        $this->load->view('header');
        $this->load->view('hire_purchase');   
        $this->load->view('footer');
    }  

    /**
     * GET /hire-purchase/invoices?q=search_term
     * AJAX: Search eligible invoices
     */
    public function invoices()
    {
        $search = $this->input->get('q');
        
        if (!$search) {
            $this->_json(['error' => 'Search term required'], 400);
            return;
        }
        
        $invoices = $this->HP_model->search_eligible_invoices($search);
        $this->_json($invoices);
    }

    /**
     * GET /hire-purchase/plans
     * AJAX: Get all available HP plans
     */
    public function plans()
    {
        $plans = $this->HP_model->get_plans();
        $this->_json($plans);
    }

    /**
     * POST /hire-purchase/schedule
     * AJAX: Calculate schedule preview
     * Body: { invoice_id, plan_id, down_payment }
     */
    public function schedule()
    {
        $invoice_id   = $this->input->post('invoice_id');
        $plan_id      = $this->input->post('plan_id');
        $down_payment = (float)$this->input->post('down_payment');
        
        // Validate inputs
        if (!$invoice_id || !$plan_id) {
            $this->_json(['error' => 'Invoice and plan are required'], 400);
            return;
        }
        
        $inv = $this->HP_model->get_invoice($invoice_id);
        $plan = $this->HP_model->get_plan($plan_id);
        
        if (!$inv || !$plan) {
            $this->_json(['error' => 'Invalid invoice or plan.'], 400);
            return;
        }
        
        // Validate down payment
        $min_dp = ceil($inv['outstanding'] * $plan['min_dp_pct'] / 100);
        if ($down_payment < $min_dp) {
            $this->_json(['error' => "Minimum down payment is LKR " . number_format($min_dp, 2)], 400);
            return;
        }
        
        if ($down_payment >= $inv['outstanding']) {
            $this->_json(['error' => 'Down payment cannot equal or exceed outstanding amount'], 400);
            return;
        }
        
        $rows = $this->HP_model->compute_schedule($inv['outstanding'], $down_payment, $plan);
        
        $this->_json([
            'schedule' => $rows,
            'summary' => [
                'total_interest' => array_sum(array_column($rows, 'interest')),
                'total_repayable' => array_sum(array_column($rows, 'instalment')),
                'monthly_instalment' => $rows[0]['instalment'] ?? 0
            ]
        ]);
    }

    /**
     * POST /hire-purchase/create
     * Create new HP agreement (supports both JSON and form-data)
     */
    public function create()
    {
        // Handle file uploads first if present
        $uploaded_files = [];
        if (!empty($_FILES)) {
            $uploaded_files = $this->_handle_kyc_uploads();
        }
        
        // Build payload from POST (supports both JSON and form-data)
        $payload = $this->_build_payload($uploaded_files);
        
        // Validate required fields
        $validation = $this->_validate_payload($payload);
        if (!$validation['valid']) {
            $this->_json(['success' => false, 'errors' => $validation['errors']], 422);
            return;
        }
        
        // Create HP agreement
        $result = $this->HP_model->create($payload);
        
        $status = $result['success'] ? 200 : 422;
        $this->_json($result, $status);
    }

    /**
     * GET /hire-purchase/get/{hp_id}
     * Get existing HP agreement details
     */
    public function get($hp_id)
    {
        $agreement = $this->HP_model->get_one($hp_id);
        
        if (!$agreement) {
            $this->_json(['error' => 'Agreement not found'], 404);
            return;
        }
        
        $this->_json($agreement);
    }

    /**
     * POST /hire-purchase/upload-document
     * Upload KYC document
     */
    public function upload_document()
    {
        $doc_type = $this->input->post('doc_type');
        
        if (!$doc_type) {
            $this->_json(['error' => 'Document type required'], 400);
            return;
        }
        
        $config['upload_path'] = './uploads/hp_documents/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = true;
        
        // Create directory if not exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        
        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload('file')) {
            $this->_json(['error' => $this->upload->display_errors('', '')], 400);
            return;
        }
        
        $upload_data = $this->upload->data();
        
        $this->_json([
            'success' => true,
            'doc_type' => $doc_type,
            'file_path' => $config['upload_path'] . $upload_data['file_name'],
            'file_name' => $upload_data['file_name']
        ]);
    }

    /* ─────────────────────────────────────────────────────────────
     *  PRIVATE HELPERS
     * ───────────────────────────────────────────────────────────── */

    private function _json($data, $status = 200)
    {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
    private function _handle_kyc_uploads()
    {
        $uploaded = [];
        $config['upload_path'] = './uploads/hp_documents/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 5120;
        $config['encrypt_name'] = true;
        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        
        foreach ($_FILES as $key => $file) {
            if (isset($file['name']) && $file['name']) {
                $_FILES['temp_file'] = $file;
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('temp_file')) {
                    $upload_data = $this->upload->data();
                    $uploaded[$key] = $config['upload_path'] . $upload_data['file_name'];
                }
            }
        }
        
        return $uploaded;
    }
    
    private function _build_payload($uploaded_files = [])
    {
        // Check if JSON input
        $json_input = json_decode(file_get_contents('php://input'), true);
        $post_data = $json_input ? $json_input : $_POST;
        
        // Parse guarantors (could be JSON string or array)
        $guarantors = [];
        if (isset($post_data['guarantors'])) {
            if (is_string($post_data['guarantors'])) {
                $guarantors = json_decode($post_data['guarantors'], true);
            } else {
                $guarantors = $post_data['guarantors'];
            }
        }
        
        // Parse KYC uploaded
        $kyc_uploaded = [];
        if (isset($post_data['kyc_uploaded'])) {
            if (is_string($post_data['kyc_uploaded'])) {
                $kyc_uploaded = json_decode($post_data['kyc_uploaded'], true);
            } else {
                $kyc_uploaded = $post_data['kyc_uploaded'];
            }
        }
		
		// Get kyc_paths from JSON (not from uploaded_files which is empty)
		$kyc_paths = [];
		if (isset($post_data['kyc_paths'])) {
			if (is_string($post_data['kyc_paths'])) {
				$kyc_paths = json_decode($post_data['kyc_paths'], true);
			} else {
				$kyc_paths = $post_data['kyc_paths'];
			}
		}
        
        return [
            'invoice_id'    => $post_data['invoice_id'] ?? '',
            'plan_id'       => $post_data['plan_id'] ?? '',
            'client_name'   => $post_data['client_name'] ?? '',
            'client_nic'    => $post_data['client_nic'] ?? '',
            'client_phone'  => $post_data['client_phone'] ?? '',
            'client_email'  => $post_data['client_email'] ?? '',
            'client_dob'    => $post_data['client_dob'] ?? null,
            'client_addr'   => $post_data['client_addr'] ?? '',
            'client_job'    => $post_data['client_job'] ?? '',
            'down_payment'  => (float)($post_data['down_payment'] ?? 0),
            'guarantors'    => $guarantors,
            'kyc_uploaded'  => $kyc_uploaded,
            'kyc_paths'     => $kyc_paths,
        ];
    }
    
    private function _validate_payload($payload)
    {
        $errors = [];
        
        if (empty($payload['invoice_id'])) $errors[] = 'Invoice is required';
        if (empty($payload['plan_id'])) $errors[] = 'Plan is required';
        if (empty($payload['client_name'])) $errors[] = 'Client name is required';
        if (empty($payload['client_nic'])) $errors[] = 'Client NIC is required';
        if (empty($payload['client_phone'])) $errors[] = 'Client phone is required';
        if ($payload['down_payment'] <= 0) $errors[] = 'Down payment is required';
        if (empty($payload['guarantors'])) $errors[] = 'At least one guarantor is required';
        
        return ['valid' => empty($errors), 'errors' => $errors];
    }
	
	/**
 * GET /hire-purchase/kyc-types
 * AJAX: Get KYC document types
 */
public function kyc_types()
{
    $kyc_docs = $this->HP_model->get_kyc_doc_types();
    $this->_json($kyc_docs);
}

public function debug_log()
{
    // Force display of debug info
    echo "<pre>";
    echo "POST data received:\n";
    print_r($_POST);
    echo "\n\nRAW input:\n";
    echo file_get_contents('php://input');
    echo "\n\nSession data:\n";
    print_r($this->session->all_userdata());
    echo "</pre>";
    die();
}

 
}