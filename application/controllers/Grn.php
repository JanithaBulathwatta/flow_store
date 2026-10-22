<?php
//madhushika(2026-03-27)
defined('BASEPATH') OR exit('No direct script access allowed');

class Grn extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Grn_model');
        $this->load->model('crm/Supply_model');
        $this->load->model('Store_model');
        $this->load->model('crm/Product_model');  
        $this->load->model('crm/User_model'); 
        $this->load->model('crm/Staff_model'); 
        $this->load->model('Unit_model');  
        $this->load->model('crm/TaxRate_model');
        $this->load->helper('url');

        // Example auth check
        if (!$this->session->userdata('user_id')) {
            $this->response('unauth', [], 'Unauthorized', 401);
            exit;
        }
    }
	public function index()
	{
		// Get user type from session - use 'ut_id' as the key
		$ut_id = $this->session->userdata('ut_id');
		
		// If not in session, get from database
		if (!$ut_id) {
			$user_id = $this->session->userdata('user_id');
			if ($user_id) {
				$user = $this->db->select('ut_id, owner')
								 ->where('user_id', $user_id)
								 ->get('user')
								 ->row();
				if ($user) {
					$ut_id = $user->ut_id ?? 0;
					$is_owner = $user->owner ?? 0;
					// Store in session for future use
					$this->session->set_userdata('ut_id', $ut_id);
					$this->session->set_userdata('owner', $is_owner);
				}
			}
		}
		
		// Get owner status
		$is_owner = $this->session->userdata('owner');
		
		// Set permissions: ut_id 1 or 2 OR owner can approve/reject
		$can_approve = ($ut_id == 1 || $ut_id == 3 || $is_owner == 1);
		$can_reject = ($ut_id == 1 || $ut_id == 3 || $is_owner == 1);
		
		$data['sup'] = $this->Supply_model->get_all_suppliers();
		$data['stores'] = $this->Store_model->get_all_stores();
		//$data['user'] = $this->User_model->get_active_users(); 
		$data['user'] = $this->Staff_model->get_staff(); 
		$data['products'] = $this->Product_model->get_active(); 
		$data['tax_rates'] = $this->TaxRate_model->get_all_taxes(); 
		$data['can_approve_grn'] = $can_approve;
		$data['can_reject_grn'] = $can_reject;
		$data['ut_id'] = $ut_id;
		$data['is_owner'] = $is_owner;
		
		$data ['unit'] = $this->Unit_model->get_all_active();
		$data ['rate'] = $this->TaxRate_model->get_all_tax();
		
		$this->load->view('header');
		$this->load->view('grn_view', $data);
		$this->load->view('footer');
	}
		
	// grn list page UI function 	
	public function grn_list(){	
		$this->load->model('Grn/Grn_m');
		$this->load->model('crm/Supply_model');
		$this->load->model('crm/Staff_model');
		$data ['store'] = $this->Grn_m->get_stores();	
		$data ['sup'] = $this->Supply_model->get_all_suppliers();	
		$data ['staff'] = $this->Staff_model->get_staff();
		
		$this->load->view('header');
		$this->load->view('grn/grn_list',$data);
		$this->load->view('footer');
	}

	// print page function
	public function print_view()
	{
		$id = $this->input->get('grn');
		
		$this->load->model('Grn_model');
		
		$data['grn'] = $this->Grn_model->get_product($id);

		if (!$data['grn']) {
			show_404();
		}

		
		$this->load->view('printView/header', $data);
		$this->load->view('printView/grn_print', $data);
		$this->load->view('printView/footer', $data);
	}
	
    /* -----------------------------------------------------------
       Response Wrapper
    ----------------------------------------------------------- */

    private function response($status, $data = [], $msg = '', $ref = 200)
    {
        echo json_encode([
            'status' => $status,
            'data'   => $data,
            'msg'    => $msg,
            'ref'    => $ref
        ]);
        exit;
    }
	/* -----------------------------------------------------------
	   GET GRN SUMMARY FOR AJAX
	----------------------------------------------------------- */
	public function getGRNSummary($grn_id = null)
	{
		if (!$grn_id) {
			$grn_id = $this->uri->segment(3);
		}
		
		if (!$grn_id) {
			$this->response('error', [], 'GRN ID required', 400);
			return;
		}
		
		$summary = $this->Grn_model->getGRNSummary($grn_id);
		
		if (!$summary) {
			$this->response('error', [], 'GRN not found', 404);
			return;
		}
		
		$this->response('success', $summary, 'GRN summary loaded');
	}

	/* -----------------------------------------------------------
	   GET GRN HISTORY FOR AJAX
	----------------------------------------------------------- */
	public function getGRNHistory($grn_id = null)
	{
		if (!$grn_id) {
			$grn_id = $this->uri->segment(3);
		}
		
		if (!$grn_id) {
			$this->response('error', [], 'GRN ID required', 400);
			return;
		}
		
		$history = $this->Grn_model->getGRNHistory($grn_id);
		
		$this->response('success', $history, 'GRN history loaded');
	}
    /* -----------------------------------------------------------
       GRN LIST
    ----------------------------------------------------------- */

    public function list()
    {
        $filters = $this->input->get();

        $data = $this->Grn_model->getList($filters);

        $this->response('success', $data, 'GRN list loaded');
    }

    /* -----------------------------------------------------------
       GET SINGLE GRN
    ----------------------------------------------------------- */

    public function get()
    {
		$id = $this->input->get('grn_id');
		
        $grn = $this->Grn_model->get($id);

        if (!$grn) {
            $this->response('error', [], 'GRN not found', 404);
        }

        $this->response('success', $grn, 'GRN loaded');
    }

    /* -----------------------------------------------------------
       CREATE GRN
    ----------------------------------------------------------- */

	public function store()
	{
		$payload = json_decode(file_get_contents("php://input"), true);	
			
		if (!$payload) {
			$this->response('validation_error', [], 'Invalid request', 422);
		}
		
		error_log("=== STORE METHOD CALLED ===");
		error_log("Store payload: " . json_encode($payload));
		
		// Check if we have a GRN ID from the payload
		$grn_id = $payload['grn_id'] ?? null;
		
		error_log("GRN ID from payload: " . ($grn_id ?? 'NULL'));
		
		// If we have a GRN ID, update existing GRN
		if ($grn_id) {
			// First, get the current GRN to check its status
			$current_grn = $this->db->where('id', $grn_id)->get('grn')->row();
			
			error_log("Current GRN status: " . ($current_grn ? $current_grn->status : 'NOT FOUND'));
			
			if ($current_grn) {
				// If status is 'new' or 'draft', we can update it
				if ($current_grn->status == 'new' || $current_grn->status == 'draft') {
					$result = $this->Grn_model->update($grn_id, $payload);
					error_log("Update result: " . ($result ? 'SUCCESS' : 'FAILED'));
					if ($result) {
						// Get the updated GRN to verify status change
						$updated_grn = $this->db->where('id', $grn_id)->get('grn')->row();
						error_log("Updated GRN status: " . $updated_grn->status);
						$this->response('success', ['grn_id' => $grn_id], 'GRN saved successfully');
					} else {
						$this->response('error', [], 'GRN save failed');
					}
				} else {
					$this->response('error', [], 'Cannot edit GRN in ' . $current_grn->status . ' status');
				}
			} else {
				$this->response('error', [], 'GRN not found');
			}
			return;
		}
		
		// No GRN ID - create new GRN
		error_log("Creating new GRN");
		$grn_id = $this->Grn_model->create($payload);
		$result = $grn_id ? true : false;
		
		if (!$result) {
			$this->response('error', [], 'GRN save failed');
		}
		
		$this->response('success', ['grn_id' => $grn_id], 'GRN saved successfully');
	}

    /* -----------------------------------------------------------
       UPDATE GRN
    ----------------------------------------------------------- */

	 public function update($id = null)
	{
		// Get ID from parameter or from URI segment
		if (!$id) {
			$id = $this->uri->segment(3); // Get 3rd segment after controller/method
		}
		
		if (!$id) {
			$this->response('error', [], 'GRN ID is required', 400);
			return;
		}
		
		$payload = json_decode(file_get_contents("php://input"), true);
		
		if (!$payload) {
			$this->response('validation_error', [], 'Invalid request data', 422);
			return;
		}
		
		$result = $this->Grn_model->update($id, $payload);
		
		if (!$result) {
			$this->response('error', [], 'GRN update failed');
			return;
		}
		
		$this->response('success', [], 'GRN updated successfully');
	}

    /* -----------------------------------------------------------
       DELETE GRN
    ----------------------------------------------------------- */

    public function delete($id)
    {
        $result = $this->Grn_model->delete($id);

        if (!$result) {
            $this->response('error', [], 'Unable to delete GRN');
        }

        $this->response('success', [], 'GRN deleted');
    }


  public function submit($id = null)
{
    if (!$id) {
        $id = $this->uri->segment(3);
    }
    
    // Get the payload if any
    $payload = json_decode(file_get_contents("php://input"), true);
    
    // First, save/update the GRN with all data if payload exists
    if ($payload && !empty($payload)) {
        error_log("Submit: Saving GRN data first for ID: $id");
        
        // Check if GRN exists
        $existing = $this->db->where('id', $id)->get('grn')->row();
        
        if ($existing) {
            // Update existing GRN with the new data
            $result = $this->Grn_model->update($id, $payload);
            if (!$result) {
                error_log("Failed to update GRN before submission");
                $this->response('error', [], 'Failed to save GRN data before submission');
                return;
            }
        } else {
            // Create new GRN (though this shouldn't happen with an ID)
            $grn_id = $this->Grn_model->create($payload);
            if (!$grn_id) {
                $this->response('error', [], 'Failed to create GRN');
                return;
            }
            $id = $grn_id;
        }
    }
    
    // Now submit for approval
    $result = $this->Grn_model->submitForApproval($id);
    
    if (!$result) {
        $this->response('error', [], 'GRN submit failed');
        return;
    }
    
    $this->response('success', [
        'grn_id' => $id,
        'status' => 'submitted'
    ], 'GRN submitted for approval');
}  

    /* -----------------------------------------------------------
       APPROVE GRN
    ----------------------------------------------------------- */

    public function approve($id = null)
{
    // Check permission before allowing approval
    $ut_id = $this->session->userdata('ut_id');
    $is_owner = $this->session->userdata('owner');
    
    if (!($ut_id == 1 || $ut_id == 2 || $is_owner == 1)) {
        $this->response('error', [], 'You do not have permission to approve GRNs', 403);
        return;
    }
    
    if (!$id) {
        $id = $this->uri->segment(3);
    }
    
    if (!$id) { 
        $id = $this->input->post('grn_id');
    }
    
    if (!$id) {
        $this->response('error', [], 'GRN ID is required', 400);
        return;
    }
    
    $result = $this->Grn_model->approve($id);
    
    if (!$result) {
        $this->response('error', [], 'GRN approval failed');
        return;
    }
    
    $this->response('success', [], 'GRN approved');
}

public function reject($id = null)
{
    // Check permission before allowing rejection
    $ut_id = $this->session->userdata('ut_id');
    $is_owner = $this->session->userdata('owner');
    
    if (!($ut_id == 1 || $ut_id == 2 || $is_owner == 1)) {
        $this->response('error', [], 'You do not have permission to reject GRNs', 403);
        return;
    }
    
    if (!$id) {
        $id = $this->uri->segment(3);
    }
    
    if (!$id) {
        $id = $this->input->post('grn_id');
    }
    
    if (!$id) {
        $this->response('error', [], 'GRN ID is required', 400);
        return;
    }
    
    $note = $this->input->post('note');
    
    if (empty($note)) {
        $this->response('error', [], 'Rejection reason is required', 400);
        return;
    }
    
    $result = $this->Grn_model->reject($id, $note);
    
    if (!$result) {
        $this->response('error', [], 'GRN rejection failed');
        return;
    }
    
    $this->response('success', [], 'GRN rejected');
}

    /* -----------------------------------------------------------
       IMPORT PURCHASE ORDER
    ----------------------------------------------------------- */

    public function importPurchaseOrder($po_id)
    {
        $data = $this->Grn_model->importPO($po_id);

        if (!$data) {
            $this->response('error', [], 'PO import failed');
        }

        $this->response('success', $data, 'PO imported');
    }

	   // /* -----------------------------------------------------------
	   // SAVE SERIAL NUMBERS
	// ----------------------------------------------------------- */
		// public function saveSerialNumbers()
	// {
		// $payload = json_decode(file_get_contents("php://input"), true);
		
		// // Debug: Log what we received
		// error_log("=== Save Serial Numbers Controller ===");
		// error_log("Payload: " . json_encode($payload));
		
		// if (!$payload || !isset($payload['serials'])) {
			// $this->response('validation_error', [], 'Invalid request data', 422);
			// return;
		// }
		
		// $grn_item_id = $payload['grn_item_id'] ?? null;
		// $product_id = $payload['product_id'] ?? null;
		// $warehouse_id = $payload['warehouse_id'] ?? null;
		// $serials = $payload['serials'];
		
		// error_log("grn_item_id: $grn_item_id");
		// error_log("product_id: $product_id");
		// error_log("warehouse_id: $warehouse_id");
		// error_log("serials count: " . count($serials));
		
		// if (empty($serials)) {
			// $this->response('error', [], 'No serial numbers provided');
			// return;
		// }
		
		// if (!$product_id) {
			// $this->response('error', [], 'Product ID is required');
			// return;
		// }
		
		// if (!$warehouse_id) {
			// $this->response('error', [], 'Warehouse ID is required');
			// return;
		// }
		
		// // Prepare data for model
		// $serial_data = [
			// 'product_id' => $product_id,
			// 'warehouse_id' => $warehouse_id,
			// 'serials' => $serials
		// ];
		
		// // Only add grn_item_id if it exists
		// if ($grn_item_id) {
			// $serial_data['grn_item_id'] = $grn_item_id;
		// }
		
		// $result = $this->Grn_model->saveSerialNumbers($serial_data);
		
		// if (!$result) {
			// error_log("Failed to save serial numbers");
			// $this->response('error', [], 'Serial save failed');
			// return;
		// }
		
		// error_log("Serial numbers saved successfully");
		
		// $this->response('success', [
			// 'count' => count($serials),
			// 'grn_item_id' => $grn_item_id
		// ], count($serials) . ' serial numbers saved');
	// }

	   /* -----------------------------------------------------------
	   ATTACHMENT UPLOAD
	----------------------------------------------------------- */
	public function uploadAttachment($grn_id = null)
	{
		// Get ID from parameter or from URI segment
		if (!$grn_id) {
			$grn_id = $this->uri->segment(3);
		}
		
		// If still no ID, try to get from POST
		if (!$grn_id && $this->input->post('grn_id')) {
			$grn_id = $this->input->post('grn_id');
		}
		
		if (!$grn_id) {
			$this->response('validation_error', [], 'GRN ID is required', 400);
			return;
		}
		
		error_log("UploadAttachment called with GRN ID: " . $grn_id);
		
		// Check if files were uploaded
		if (!isset($_FILES['files']) && !isset($_FILES['file'])) {
			$this->response('validation_error', [], 'No file uploaded', 400);
			return;
		}
		
		$results = [];
		
		// Handle multiple files
		if (isset($_FILES['files'])) {
			$files = $_FILES['files'];
			
			if (is_array($files['name'])) {
				for ($i = 0; $i < count($files['name']); $i++) {
					if ($files['error'][$i] == 0) {
						$file = [
							'name' => $files['name'][$i],
							'type' => $files['type'][$i],
							'tmp_name' => $files['tmp_name'][$i],
							'error' => $files['error'][$i],
							'size' => $files['size'][$i]
						];
						$result = $this->Grn_model->uploadAttachment($grn_id, $file);
						if ($result) {
							$results[] = $result;
						}
					}
				}
			} else {
				// Single file in 'files' array
				if ($files['error'] == 0) {
					$result = $this->Grn_model->uploadAttachment($grn_id, $files);
					if ($result) {
						$results[] = $result;
					}
				}
			}
		} 
		// Handle single file
		elseif (isset($_FILES['file'])) {
			$file = $_FILES['file'];
			if ($file['error'] == 0) {
				$result = $this->Grn_model->uploadAttachment($grn_id, $file);
				if ($result) {
					$results[] = $result;
				}
			}
		}
		
		if (empty($results)) {
			$this->response('error', [], 'Upload failed - no files were successfully uploaded');
			return;
		}
		
		$this->response('success', $results, count($results) . ' file(s) uploaded successfully');
	}


	   /* -----------------------------------------------------------
	   HISTORY
	----------------------------------------------------------- */
	public function history($grn_id = null)
	{
		// if (!$grn_id) {
			// $this->response('error', [], 'No GRN ID provided', 400);
			// return;
		// }
		 if (!$grn_id) {
			$grn_id = $this->uri->segment(3); // Get 3rd segment
		}
		
		$data = $this->Grn_model->getHistory($grn_id);
		$this->response('success', $data, 'History loaded');
	}

	/* -----------------------------------------------------------
	   GET PURCHASE ORDERS LIST
	----------------------------------------------------------- */


	public function getPurchaseOrders()
	{
		header('Content-Type: application/json');
		
		try {
			error_log("getPurchaseOrders called");
			
			if (!$this->session->userdata('user_id')) {
				$this->response('unauth', [], 'Unauthorized', 401);
				return;
			}
			
			$supplier_id = $this->input->get('supplier_id');
			$date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			
			// Call model method to get data
			$pos = $this->Grn_model->getPurchaseOrdersData($supplier_id, $date_from, $date_to);
			
			$this->response('success', $pos, 'Purchase orders loaded');
			
		} catch (Exception $e) {
			error_log("Exception in getPurchaseOrders: " . $e->getMessage());
			$this->response('error', [], 'Server error: ' . $e->getMessage(), 500);
		}
	}

	public function getPurchaseOrder($po_id = null)
	{
		// If parameter is empty, try to get from URI segment
		if (!$po_id) {
			$po_id = $this->uri->segment(3); // Get 3rd segment after controller/method
		}
		
		error_log("Controller getPurchaseOrder called with po_id: " . ($po_id ?? 'NULL'));
		
		if (!$po_id) {
			$this->response('error', [], 'Purchase Order ID is required', 400);
			return;
		}
		
		$po = $this->Grn_model->getPurchaseOrder($po_id);
		
		if (!$po) {
			$this->response('error', [], 'PO not found', 404);
			return;
		}
		
		$this->response('success', $po, 'PO loaded');
	}

		/* -----------------------------------------------------------
		   SUPPLIER SUMMARY
		----------------------------------------------------------- */

		/* -----------------------------------------------------------
	   SUPPLIER SUMMARY
	----------------------------------------------------------- */
	public function supplierSummary($supplier_id = null)
	{
		// If parameter is empty, try to get from URI segment
		if (!$supplier_id) {
			$supplier_id = $this->uri->segment(3);
		}
		
		if (!$supplier_id) {
			$this->response('error', [], 'Supplier ID is required', 400);
			return;
		}
		
		$data = $this->Grn_model->getSupplierSummary($supplier_id);
		
		if (!$data) {
			$this->response('error', [], 'Supplier not found', 404);
			return;
		}
		
		$this->response('success', $data, 'Supplier summary loaded');
	}

    /* -----------------------------------------------------------
       PRODUCT SUMMARY
    ----------------------------------------------------------- */

    public function productSummary($product_id)
    {
        $data = $this->Grn_model->getProductSummary($product_id);

        $this->response('success', $data, 'Product summary loaded');
    }


    public function generateGRNNumber()
    {
        $result = $this->Grn_model->createDraftGRN();
        
        if ($result) {
            $this->response('success', $result, 'Draft GRN created');
        } else {
            $this->response('error', [], 'Failed to create draft GRN');
        }
    }

    
	public function getProductDetails()
	{
		$product_id = $this->input->post('product_id');

		if (!$product_id) {
			echo json_encode(['status'=>false,'msg'=>'No product id']);
			return;
		}

		$this->load->model('Grn_model');

		$details = $this->Grn_model->getProductDetails($product_id);

		if ($details) {
			echo json_encode(['status'=>true] + $details);
		} else {
			echo json_encode(['status'=>false,'msg'=>'Product not found']);
		}
	}

	/* -----------------------------------------------------------
	   GET DRAFT GRN FOR CURRENT USER
	----------------------------------------------------------- */
	public function getDraftGRN()
	{
		try {
			if (!$this->session->userdata('user_id')) {
				$this->response('error', [], 'Unauthorized', 401);
				return;
			}
			
			$draft = $this->Grn_model->getDraftGRN();
			
			if (!$draft) {
				$this->response('success', null, 'No draft GRN found');
				return;
			}
			
			$this->response('success', $draft, 'Draft GRN loaded');
			
		} catch (Exception $e) {
			error_log("Error loading draft GRN: " . $e->getMessage());
			$this->response('error', [], 'Failed to load draft GRN', 500);
		}
	} 

	/* -----------------------------------------------------------
	   GET ATTACHMENTS FOR GRN
	----------------------------------------------------------- */
	public function getAttachments($grn_id = null)
	{
		if (!$grn_id) {
			$grn_id = $this->uri->segment(3);
		}
		
		if (!$grn_id) {
			$this->response('error', [], 'GRN ID required', 400);
			return;
		}
		
		$attachments = $this->Grn_model->getAttachments($grn_id);
		$this->response('success', $attachments, 'Attachments loaded');
	}

	/* -----------------------------------------------------------
	   DELETE ATTACHMENT
	----------------------------------------------------------- */
	public function deleteAttachment($attachment_id = null)
	{
		if (!$attachment_id) {
			$attachment_id = $this->uri->segment(3);
		}
		
		if (!$attachment_id) {
			$this->response('error', [], 'Attachment ID required', 400);
			return;
		}
		
		$result = $this->Grn_model->deleteAttachment($attachment_id);
		
		if (!$result) {
			$this->response('error', [], 'Failed to delete attachment');
			return;
		}
		
		$this->response('success', [], 'Attachment deleted');
	}

	/* -----------------------------------------------------------
	   DOWNLOAD ATTACHMENT
	----------------------------------------------------------- */
	public function downloadAttachment($attachment_id = null)
	{
		if (!$attachment_id) {
			$attachment_id = $this->uri->segment(3);
		}
		
		if (!$attachment_id) {
			show_error('Attachment ID required', 400);
			return;
		}
		
		$attachment = $this->Grn_model->getAttachment($attachment_id);
		
		if (!$attachment) {
			show_error('Attachment not found', 404);
			return;
		}
		
		$file_path = FCPATH . $attachment->file_path;
		
		if (!file_exists($file_path)) {
			show_error('File not found', 404);
			return;
		}
		
		// Force download
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $attachment->file_name . '"');
		header('Content-Length: ' . filesize($file_path));
		readfile($file_path);
		exit;
	}

	/* -----------------------------------------------------------
	   GET SERIAL NUMBERS FOR AN ITEM
	----------------------------------------------------------- */
	public function getSerialNumbers($grn_item_id = null)
	{
		if (!$grn_item_id) {
			$this->response('error', [], 'Item ID required', 400);
			return;
		}
		
		$serials = $this->db->where('grn_item_id', $grn_item_id)
							->get('product_serial_numbers')
							->result();
		
		$this->response('success', $serials, 'Serial numbers loaded');
	}
	/* -----------------------------------------------------------
	   CHECK IF BATCH EXISTS
	----------------------------------------------------------- */
	public function checkBatchExists()
	{
		$product_id = $this->input->post('product_id');
		$batch_number = $this->input->post('batch_number');
		$warehouse_id = $this->input->post('warehouse_id');
		$exclude_grn_item_id = $this->input->post('exclude_grn_item_id');
		
		if (!$product_id || !$batch_number || !$warehouse_id) {
			$this->response('error', [], 'Product ID, batch number, and warehouse ID required', 400);
			return;
		}
		
		$exists = $this->Grn_model->checkBatchExists($product_id, $warehouse_id, $batch_number, $exclude_grn_item_id);
		
		// If batch exists, get its details
		$batch_details = null;
		if ($exists) {
			$batch_details = $this->Grn_model->getBatchByNumber($product_id, $warehouse_id, $batch_number);
		}
		
		$this->response('success', [
			'exists' => $exists,
			'batch_details' => $batch_details
		], 'Batch check completed');
	}
	
	public function getGRNStatus($id = null)
{
    // If no ID in parameter, try to get from URI segment
    if (!$id) {
        $id = $this->uri->segment(3);
    }
    
    // If still no ID, return error
    if (!$id) {
        $this->response('error', [], 'GRN ID is required', 400);
        return;
    }
    
    $grn = $this->db->select('status')->where('id', $id)->get('grn')->row();
    
    if($grn) {
        $this->response('success', ['status' => $grn->status], 'Status loaded');
    } else {
        $this->response('error', [], 'GRN not found', 404);
    }
}

public function getDraftGRNById($grn_id = null)
{
    if (!$grn_id) {
        $grn_id = $this->uri->segment(3);
    }
    
    if (!$grn_id) {
        $this->response('error', [], 'GRN ID required', 400);
        return;
    }
    
    $grn = $this->Grn_model->getDraftGRNById($grn_id);
    
    if (!$grn) {
        $this->response('error', [], 'GRN not found', 404);
        return;
    }
    
    $this->response('success', $grn, 'GRN loaded');
}

	public function get_grn_counts()
	{
		$this->load->model('Grn_model');
		$data = $this->Grn_model->get_grn_counts();

		echo json_encode($data);
	}
	/* -----------------------------------------------------------
   GET PRODUCT TRACKING INFO (for batch/serial import check)
----------------------------------------------------------- */
public function getProductTrackingInfo()
{
    $product_ids = $this->input->post('product_ids');
    
    if (!$product_ids) {
        $this->response('error', [], 'Product IDs required', 400);
        return;
    }
    
    // Handle comma-separated string or array
    if (is_string($product_ids)) {
        $product_ids = explode(',', $product_ids);
    }
    
    if (empty($product_ids)) {
        $this->response('error', [], 'No valid product IDs', 400);
        return;
    }
    
    $this->db->select('id, is_expiry_trk, is_serial_trk');
    $this->db->where_in('id', $product_ids);
    $products = $this->db->get('products')->result();
    
    $result = [];
    foreach ($products as $p) {
        $result[$p->id] = [
            'is_expiry_trk' => (bool)$p->is_expiry_trk,
            'is_serial_trk' => (bool)$p->is_serial_trk
        ];
    }
    
    $this->response('success', $result, 'Product tracking info loaded');
}
/* -----------------------------------------------------------
   GENERATE UNIQUE SERIAL NUMBER
----------------------------------------------------------- */
public function generateUniqueSerial()
{
    $product_id = $this->input->post('product_id');
    $quantity = $this->input->post('quantity');
    
    if (!$product_id || !$quantity) {
        $this->response('error', [], 'Product ID and quantity required', 400);
        return;
    }
    
    // Get product info for prefix
    $product = $this->db->select('name, product_code')
                        ->where('id', $product_id)
                        ->get('products')
                        ->row();
    
    // Create prefix from product code or name
    $prefix = !empty($product->product_code) ? $product->product_code : 'SN' . $product_id;
    $prefix = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $prefix));
    
    // Get the last serial number for this product to find next number
    $lastSerial = $this->db->select('serial_no')
                           ->like('serial_no', $prefix . '-', 'after')
                           ->order_by('id', 'DESC')
                           ->limit(1)
                           ->get('product_serial_numbers')
                           ->row();
    
    $nextNumber = 1;
    if ($lastSerial) {
        // Extract number from format: PREFIX-001
        $parts = explode('-', $lastSerial->serial_no);
        $lastNumber = intval(end($parts));
        $nextNumber = $lastNumber + 1;
    }
    
    // Generate required quantity of unique serials
    $serials = [];
    for ($i = 0; $i < $quantity; $i++) {
        $serials[] = $prefix . '-' . str_pad($nextNumber + $i, 3, '0', STR_PAD_LEFT);
    }
    
    $this->response('success', [
        'serials' => $serials,
        'prefix' => $prefix,
        'start_number' => $nextNumber
    ], $quantity . ' unique serials generated');
}
/* -----------------------------------------------------------
   RECORD PAYMENT FOR GRN (ONLY AFTER APPROVAL)
----------------------------------------------------------- */
public function recordPayment()
{
    $payload = json_decode(file_get_contents("php://input"), true);
    
    if (!$payload || empty($payload['grn_id']) || empty($payload['amount'])) {
        $this->response('error', [], 'GRN ID and amount are required', 400);
        return;
    }
    
    $grn_id = $payload['grn_id'];
    $amount = (float)$payload['amount'];
    
    // Validate payment amount
    if ($amount <= 0) {
        $this->response('error', [], 'Payment amount must be greater than zero', 400);
        return;
    }
    
    // Validate payment method
    $method = $payload['payment_method'] ?? '';
    if (!in_array($method, ['cash', 'transfer', 'cheque'])) {
        $this->response('error', [], 'Invalid payment method', 400);
        return;
    }
    
    // Validate required fields for cheque
    if ($method == 'cheque' && empty($payload['cheque_no'])) {
        $this->response('error', [], 'Cheque number is required for cheque payments', 400);
        return;
    }
    
    // Validate payment date
    if (empty($payload['payment_date'])) {
        $this->response('error', [], 'Payment date is required', 400);
        return;
    }
    
    $result = $this->Grn_model->recordPayment($grn_id, $payload);
    
    if (!$result['status']) {
        $this->response('error', [], $result['message'], 400);
        return;
    }
    
    $this->response('success', ['payment_id' => $result['payment_id']], $result['message']);
}

/* -----------------------------------------------------------
   GET GRN PAYMENT SUMMARY
----------------------------------------------------------- */
public function getGRNPaymentSummary($grn_id = null)
{
    if (!$grn_id) {
        $grn_id = $this->uri->segment(3);
    }
    
    if (!$grn_id) {
        $this->response('error', [], 'GRN ID required', 400);
        return;
    }
    
    $summary = $this->Grn_model->getGRNPaymentSummary($grn_id);
    
    if (!$summary) {
        $this->response('error', [], 'GRN not found', 404);
        return;
    }
    
    $this->response('success', $summary, 'Payment summary loaded');
}

/* -----------------------------------------------------------
   GET GRN PAYMENT HISTORY
----------------------------------------------------------- */
public function getGRNPayments($grn_id = null)
{
    if (!$grn_id) {
        $grn_id = $this->uri->segment(3);
    }
    
    if (!$grn_id) {
        $this->response('error', [], 'GRN ID required', 400);
        return;
    }
    
    $payments = $this->Grn_model->getGRNPayments($grn_id);
    $this->response('success', $payments, 'Payment history loaded');
}
}