<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Po_model');
        $this->load->model('crm/Supply_model');
        $this->load->model('Store_model');
        $this->load->model('crm/Product_model');
        $this->load->model('crm/User_model');
        $this->load->model('Unit_model');
        $this->load->model('crm/TaxRate_model');
		$this->load->model('crm/Staff_model');
        $this->load->helper('url');
        
        // Authentication check
        if (!$this->session->userdata('user_id')) {
            $this->response('unauth', [], 'Unauthorized', 401);
            exit;
        }
    }
    
	private function check_auth()
    {
        if (!$this->session->userdata('user_id')) {
            if ($this->input->is_ajax_request()) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(401)
                    ->set_output(json_encode([
                        'status' => 'error',
                        'msg' => 'Unauthorized - Please login'
                    ]));
                exit;
            } else {
                redirect('login');
            }
        }
    }
	private function response($status, $data = [], $msg = '', $code = 200)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode([
                'status' => $status,
                'data' => $data,
                'msg' => $msg
            ]));
    }
	public function index(){
	
		// Get user type from session
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
					$this->session->set_userdata('ut_id', $ut_id);
					$this->session->set_userdata('owner', $is_owner);
				}
			}
		}
		
		// Get owner status
		$is_owner = $this->session->userdata('owner');
		$status = 'active';
		
		// ✅ ONLY ut_id = 1 can approve/reject
		$can_approve = ($ut_id == 1);
		$can_reject = ($ut_id == 1);
		
		// Get products with unit names
		$products = $this->db->select('p.*, u.unit_name')
							 ->from('products p')
							 ->join('units u', 'u.unit_id = p.unit_id', 'left')
							 ->where('p.status', 'active')
							 ->get()
							 ->result();
		
		$data['sup'] = $this->Supply_model->get_all_suppliers();
		$data['stores'] = $this->Store_model->get_all_stores();
		$data['user'] = $this->User_model->get_active_users();
		$data['staff'] = $this->Staff_model->get_all($status);
		$data['products'] = $products;
		$data['tax_rates'] = $this->TaxRate_model->get_all_taxes();
		$data['can_approve_po'] = $can_approve;
		$data['can_reject_po'] = $can_reject;
		$data['ut_id'] = $ut_id;
		$data['is_owner'] = $is_owner;
		
		$this->load->view('header');
		$this->load->view('po_view', $data);
		$this->load->view('footer');
	}

    public function po_list()
    {    
        $data['sup'] = $this->Supply_model->get_all_suppliers();    
        $data['stores'] = $this->Store_model->get_all_stores();
        
        $this->load->view('header');
        $this->load->view('po_list', $data);
        $this->load->view('footer');
    }
    
    // print po function 
    public function print_po()
    {
        $id = $this->input->get('id'); 
        $this->load->model('Po_model');
        $data['po'] = $this->Po_model->get_po_for_print($id);

        if (!$data['po']) {
            show_404();
        }

        $this->load->view('printView/po_header', $data);
        $this->load->view('printView/po_print', $data);
        $this->load->view('printView/footer2');
    }
    
    /* -----------------------------------------------------------
       Response Wrapper
    ----------------------------------------------------------- */
    // private function response($status, $data = [], $msg = '', $ref = 200)
    // {
        // header('Content-Type: application/json');
        // echo json_encode([
            // 'status' => $status,
            // 'data'   => $data,
            // 'msg'    => $msg,
            // 'ref'    => $ref
        // ]);
        // exit;
    // }
    
    /* -----------------------------------------------------------
       GENERATE PO NUMBER
    ----------------------------------------------------------- */
    public function generatePONumber()
    {
        $result = $this->Po_model->createDraftPO();
        
        if ($result) {
            $this->response('success', $result, 'Draft PO created');
        } else {
            $this->response('error', [], 'Failed to create draft PO');
        }
    }
    
    /* -----------------------------------------------------------
       GET DRAFT PO
    ----------------------------------------------------------- */
     public function getDraftPO()
    {
        $this->check_auth();
        
        try {
            $draft = $this->Po_model->getDraftPO();
            
            if (!$draft) {
                $this->response('success', null, 'No draft PO found');
                return;
            }
            
            $this->response('success', $draft, 'Draft PO loaded');
            
        } catch (Exception $e) {
            error_log("Error loading draft PO: " . $e->getMessage());
            $this->response('error', [], 'Failed to load draft PO', 500);
        }
    }
    
    /* -----------------------------------------------------------
       GET PO STATUS - NEEDED FOR LOADING EXISTING PO
    ----------------------------------------------------------- */
    // public function getPOStatus($id = null)
    // {
        // if (!$id) {
            // $id = $this->uri->segment(3);
        // }
        
        // if (!$id) {
            // $this->response('error', [], 'PO ID is required', 400);
            // return;
        // }
        
        // $po = $this->db->select('status')->where('id', $id)->get('purchase_orders')->row();
        
        // if($po) {
            // $this->response('success', ['status' => $po->status], 'Status loaded');
        // } else {
            // $this->response('error', [], 'PO not found', 404);
        // }
    // }
    
    /* -----------------------------------------------------------
       GET PO BY ID - NEEDED FOR LOADING EXISTING PO
    ----------------------------------------------------------- */
   // public function getPOById($po_id = null)
    // {
        // // Check auth first
        // $this->check_auth();
        
        // if (!$po_id) {
            // $po_id = $this->uri->segment(3);
        // }
        
        // if (!$po_id) {
            // $this->response('error', [], 'PO ID required', 400);
            // return;
        // }
        
        // $po = $this->Po_model->getPOById($po_id);
        
        // if (!$po) {
            // $this->response('error', [], 'PO not found', 404);
            // return;
        // }
        
        // $this->response('success', $po, 'PO loaded');
    // }
    
    /* -----------------------------------------------------------
       GET PO SUMMARY
    ----------------------------------------------------------- */
    public function getPOSummary()
    {
        $po_id = $this->input->get('po_id');
        
        if(!$po_id){
            $this->response('error', [], 'PO ID required');
            return;
        }
        
        $summary = $this->Po_model->getPOSummary($po_id);
        
        if (!$summary) {
            $this->response('error', [], 'PO not found', 404);
            return;
        }
        
        $this->response('success', $summary, 'PO summary loaded');
    }
     
    /* -----------------------------------------------------------
       GET PO HISTORY
    ----------------------------------------------------------- */
    public function getPOHistory()
    {
		
       $po_id = $this->input->get('po_id');
        
        if(!$po_id){
            $this->response('error', [], 'PO ID required');
            return;
        }
        
        $history = $this->Po_model->getPOHistory($po_id);
        
        $this->response('success', $history, 'PO history loaded');
    }
    
    /* -----------------------------------------------------------
       CREATE/UPDATE PO
    ----------------------------------------------------------- */
    public function store()
    {
        $payload = json_decode(file_get_contents("php://input"), true);
        
        if (!$payload) {
            $this->response('validation_error', [], 'Invalid request', 422);
        }
        
        error_log("Store PO payload: " . json_encode($payload));
        
        // Check if we have a PO ID from the payload
        $po_id = $payload['po_id'] ?? null;
        
        if ($po_id) {
            $current_po = $this->db->where('id', $po_id)->get('purchase_orders')->row();
            
            if ($current_po) {
                if ($current_po->status == 'new' || $current_po->status == 'draft') {
                    $result = $this->Po_model->update($po_id, $payload);
                    if ($result) {
                        $this->response('success', ['po_id' => $po_id], 'PO saved successfully');
                    } else {
                        $this->response('error', [], 'PO save failed');
                    }
                } else {
                    $this->response('error', [], 'Cannot edit PO in ' . $current_po->status . ' status');
                }
            } else {
                $this->response('error', [], 'PO not found');
            }
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $existing_new_po = $this->db->where('created_by', $user_id)
                                     ->where('status', 'new')
                                     ->order_by('id', 'DESC')
                                     ->limit(1)
                                     ->get('purchase_orders')
                                     ->row();
        
        if ($existing_new_po) {
            $po_id = $existing_new_po->id;
            $result = $this->Po_model->update($po_id, $payload);
        } else {
            $po_id = $this->Po_model->create($payload);
            $result = $po_id ? true : false;
        }
        
        if (!$result) {
            $this->response('error', [], 'PO save failed');
        }
        
        $this->response('success', ['po_id' => $po_id], 'PO saved successfully');
    }
    
    /* -----------------------------------------------------------
       SUBMIT PO
    ----------------------------------------------------------- */
    //public function submit($id = null)
    public function submit()
    {
		
		$id = $_GET['poid'];
		
        if (!$id) {
            $id = $this->uri->segment(3);
        }
        
        $payload = json_decode(file_get_contents("php://input"), true);
        
        if ($payload && !empty($payload)) {
            $existing = $this->db->where('id', $id)->get('purchase_orders')->row();
            if ($existing) {
                $result = $this->Po_model->update($id, $payload);
                if (!$result) {
                    $this->response('error', [], 'Failed to save PO data before submission');
                    return;
                }
            }
        }
        
        $result = $this->Po_model->submitForApproval($id);
        
        if (!$result) {
            $this->response('error', [], 'PO submit failed');
            return;
        }
        
        $this->response('success', ['po_id' => $id, 'status' => 'submitted'], 'PO submitted for approval');
    }
    
//public function approve($id = null)
public function approve()
{
	
	$id = $_GET['poid'];
	
    // ✅ ONLY ut_id = 1 can approve
    $ut_id = $this->session->userdata('ut_id');
    
    if ($ut_id != 1) {
        $this->response('error', [], 'You do not have permission to approve POs', 403);
        return;
    }
    
    // Get ID from parameter or URI segment
    if (!$id) {
        $id = $this->uri->segment(3);
    }
    
    if (!$id) {
        $this->response('error', [], 'PO ID is required', 400);
        return;
    }
    
    // Check if PO can be approved
    $can_approve = $this->Po_model->canApprove($id);
    
    if (!$can_approve['can_approve']) {
        $this->response('error', [], $can_approve['reason'], 422);
        return;
    }
    
    // Perform approval
    $result = $this->Po_model->approve($id);
    
    if (!$result) {
        $this->response('error', [], 'PO approval failed. Please try again.', 500);
        return;
    }
    
    // Get updated PO data
    $po = $this->Po_model->getPOById($id);
    
    $this->response('success', [
        'po_id' => $id,
        'po_number' => $po ? $po->po_number : null,
        'status' => 'approved'
    ], 'PO approved successfully');
}

//public function reject($id = null)
public function reject()
{
	
	$id = $_GET['poid'];
	
    // ✅ ONLY ut_id = 1 can reject
    $ut_id = $this->session->userdata('ut_id');
    
    if ($ut_id != 1) {
        $this->response('error', [], 'You do not have permission to reject POs', 403);
        return;
    }
    
    // Get ID from parameter or URI segment
    if (!$id) {
        $id = $this->uri->segment(3);
    }
    
    if (!$id) {
        $this->response('error', [], 'PO ID is required', 400);
        return;
    }
    
    // Get rejection reason from request
    $payload = json_decode(file_get_contents("php://input"), true);
    $note = $payload['note'] ?? $this->input->post('note');
    
    if (empty($note)) {
        $this->response('validation_error', [], 'Rejection reason is required', 422);
        return;
    }
    
    // Perform rejection
    $result = $this->Po_model->reject($id, $note);
    
    if (!$result) {
        $this->response('error', [], 'PO rejection failed', 500);
        return;
    }
    
    $this->response('success', [
        'po_id' => $id,
        'status' => 'rejected'
    ], 'PO rejected successfully');
} 
/* -----------------------------------------------------------
   GET PO APPROVAL STATUS - New endpoint
----------------------------------------------------------- */
public function get_approval_status()
{
    $po_id = $this->input->get('po_id');
    
    if (!$po_id) {
        $this->response('error', [], 'PO ID required', 400);
        return;
    }
    
    $status = $this->Po_model->getApprovalStatus($po_id);
    
    if (!$status) {
        $this->response('error', [], 'PO not found', 404);
        return;
    }
    
    $this->response('success', $status, 'Approval status loaded');
} 
 
// /* -----------------------------------------------------------
   // BULK APPROVE POS - Optional feature
// ----------------------------------------------------------- */
// public function bulk_approve()
// {
    // $payload = json_decode(file_get_contents("php://input"), true);
    
    // if (!$payload || empty($payload['po_ids'])) {
        // $this->response('error', [], 'PO IDs required', 400);
        // return;
    // }
    
    // $po_ids = $payload['po_ids'];
    
    // if (!is_array($po_ids)) {
        // $this->response('error', [], 'Invalid PO IDs format', 400);
        // return;
    // }
    
    // $result = $this->Po_model->bulkApprove($po_ids);
    
    // if (!$result['success']) {
        // $this->response('error', $result, 'Bulk approval failed', 500);
        // return;
    // }
    
    // $this->response('success', $result, 'Bulk approval completed');
// }
    
    /* -----------------------------------------------------------
       UPDATE PO
    ----------------------------------------------------------- */
    //public function update($id = null)
    public function update()
    {
        $id = $_GET['poid'];
		
		if (!$id) {
            $id = $this->uri->segment(3);
        }
        
        if (!$id) {
            $this->response('error', [], 'PO ID is required', 400);
            return;
        }
        
        $payload = json_decode(file_get_contents("php://input"), true);
        
        if (!$payload) {
            $this->response('validation_error', [], 'Invalid request data', 422);
            return;
        }
        
        $result = $this->Po_model->update($id, $payload);
        
        if (!$result) {
            $this->response('error', [], 'PO update failed');
            return;
        }
        
        $this->response('success', [], 'PO updated successfully');
    }
    
    /* -----------------------------------------------------------
       GET PRODUCT DETAILS
    ----------------------------------------------------------- */
    public function getProductDetails()
    {
        $product_id = $this->input->post('product_id');
        
        if (!$product_id) {
            echo json_encode(['status'=>false,'msg'=>'No product id']);
            return;
        }
        
        $details = $this->Po_model->getProductDetails($product_id);
        
        if ($details) {
            echo json_encode(['status'=>true] + $details);
        } else {
            echo json_encode(['status'=>false,'msg'=>'Product not found']);
        }
    }
    
    /* -----------------------------------------------------------
       PO LIST (for DataTable) - MAIN LIST FUNCTION
    ----------------------------------------------------------- */
    public function list()
    {
        $filters = $this->input->get();
        
        $this->db->select('po.*, sup.name as supplier_name, u.full_name as created_by_name')
                 ->from('purchase_orders po')
                 ->join('supply sup', 'sup.id = po.supplier_id', 'left')
                 ->join('user u', 'u.user_id = po.created_by', 'left');
        
        // Apply filters
        if(!empty($filters['fk_sup_id'])){
            $this->db->where('po.supplier_id', $filters['fk_sup_id']);
        }
        
        if(!empty($filters['po_status'])){
            $this->db->where('po.status', $filters['po_status']);
        }
        
        // Date range filter
        if(!empty($filters['date_range'])){
            $dates = explode(' – ', $filters['date_range']);
            if(count($dates) == 2){
                $start = date('Y-m-d', strtotime($dates[0]));
                $end   = date('Y-m-d', strtotime($dates[1]));
                $this->db->where('DATE(po.order_date) >=', $start);
                $this->db->where('DATE(po.order_date) <=', $end);
            }
        }
        
        $pos = $this->db->order_by('po.created_at', 'DESC')->get()->result();
        
        // Get item counts and amounts for each PO
        foreach($pos as $po){
            $items = $this->db->select('SUM(quantity * unit_price) as total, COUNT(*) as count')
                             ->where('po_id', $po->id)
                             ->get('purchase_order_items')
                             ->row();
            
            $po->item_count = $items->count ?? 0;
            $po->po_amount = $items->total ?? 0;
        }
        
        $this->response('success', $pos, 'PO list loaded');
    }
    
    /* -----------------------------------------------------------
       GET PO COUNTS
    ----------------------------------------------------------- */
    public function get_po_counts()
    {
        $counts = [];
        
        // Total POs
        $total = $this->db->count_all('purchase_orders');
        $counts[] = ['name' => 'Total', 'total' => $total];
        
        // Count by status
        $statuses = ['draft', 'submitted', 'approved', 'rejected'];
        foreach($statuses as $status){
            $count = $this->db->where('status', $status)->count_all_results('purchase_orders');
            if($count > 0){
                $counts[] = ['name' => ucfirst($status), 'total' => $count];
            }
        }
        
        $this->response('success', $counts, 'PO counts loaded');
    }
    
    /* -----------------------------------------------------------
       GET PO ITEMS
    ----------------------------------------------------------- */
    public function get_po_items()
    {
        $po_id = $this->input->get('po_id');
        
        if(!$po_id){
            $this->response('error', [], 'PO ID required');
            return;
        }
        
        $items = $this->db->select('poi.*, p.name as product_name, p.product_code')
                          ->from('purchase_order_items poi')
                          ->join('products p', 'p.id = poi.product_id', 'left')
                          ->where('poi.po_id', $po_id)
                          ->get()
                          ->result();
        
        $this->response('success', $items, 'PO items loaded');
    }
    
    /* -----------------------------------------------------------
       DELETE PO
    ----------------------------------------------------------- */
    public function delete_po()
    {
        $po_id = $this->input->post('po_id');
        
        if(!$po_id){
            $this->response('error', [], 'PO ID required');
            return;
        }
        
        // Check if PO is in draft status
        $po = $this->db->where('id', $po_id)->get('purchase_orders')->row();
        if(!$po || $po->status != 'draft'){
            $this->response('error', [], 'Only draft POs can be deleted');
            return;
        }
        
        // Delete items first
        $this->db->where('po_id', $po_id)->delete('purchase_order_items');
        // Delete PO
        $this->db->where('id', $po_id)->delete('purchase_orders');
        
        $this->response('success', [], 'PO deleted successfully');
    }
	
}