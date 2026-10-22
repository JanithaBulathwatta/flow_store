<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'traits/BranchTrait.php';

class Po_model extends CI_Model {
	
    use BranchTrait;
    /* -----------------------------------------------------------
       GET PO LIST WITH FILTERS
    ----------------------------------------------------------- */
    public function getList($filters = [])
    {
		$this->filterByBranch('po'); 
	
        $this->db->select('po.*, sup.name as supplier_name, u.full_name as created_by_name')
                 ->from('purchase_orders po')
                 ->join('supply sup', 'sup.id = po.supplier_id', 'left')
                 ->join('user u', 'u.user_id = po.created_by', 'left');
				 
				 // Manual branch filter
    if ($branch_id) {
        $this->db->where('po.branch_id', $branch_id);
    }
        
        // Supplier filter
        if(!empty($filters['fk_sup_id'])){
            $this->db->where('po.supplier_id', $filters['fk_sup_id']);
        }
        
        // Status filter
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
        
        
		$pos = $this->db->order_by('po.id', 'DESC')->get()->result();
        
        // Get item counts and amounts for each PO
        foreach($pos as $po){
            $items = $this->db->select('SUM(quantity * unit_price) as total, COUNT(*) as count')
                             ->where('po_id', $po->id)
                             ->get('purchase_order_items')
                             ->row();
            
            $po->item_count = $items->count ?? 0;
            $po->po_amount = $items->total ?? 0;
        }
        
        return $pos;
    }
    
    /* -----------------------------------------------------------
       GET SINGLE PO WITH ITEMS
    ----------------------------------------------------------- */
   public function get($po_id)
{
    $this->filterByBranch();  // ADD THIS LINE
    
    $items = $this->db->select('poi.*, p.name as product_name, p.product_code')
                     ->from('purchase_order_items poi')
                     ->join('products p', 'p.id = poi.product_id', 'left')
                     ->where('poi.po_id', $po_id)
                     ->get()
                     ->result();
    
    return $items;
}
  
    
    /* -----------------------------------------------------------
       CREATE PO
    ----------------------------------------------------------- */
    public function create($data)
    {
		

		
        $this->db->trans_start();

        $header = [
            'po_number' => $data['po_number'],
            'supplier_id' => $data['supplier_id'],
            //'staff_id' => $data['staff_id'],
            'order_date' => isset($data['po_date']) ? $data['po_date'] : date('Y-m-d'),
            'expected_date' => $data['expected_delivery_date'],
            'subtotal' => isset($data['subtotal']) ? $data['subtotal'] : 0,
            'discount_value' => isset($data['discount_value']) ? $data['discount_value'] : 0,
            'discount_type' => isset($data['discount_type']) ? $data['discount_type'] : 'amount',
            'tax_total' => isset($data['tax_total']) ? $data['tax_total'] : 0,
            'grand_total' => isset($data['grand_total']) ? $data['grand_total'] : 0,
            'remarks' => isset($data['remarks']) ? $data['remarks'] : null,
            'status' => 'new',
            'created_by' => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
		$header = $this->addBranch($header);
        $this->db->insert('purchase_orders', $header);
        $po_id = $this->db->insert_id();

        if (!$po_id) {
            $this->db->trans_rollback();
            return false;
        }

        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->insertItem($po_id, $item);
            }
        }
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'PO Module','Create PO','INSERT');
		//end of activity log

        $this->logApproval($po_id, 'created');

        $this->db->trans_complete();

        return $this->db->trans_status() ? $po_id : false;
			
		}
    
    /* -----------------------------------------------------------
       INSERT PO ITEM
    ----------------------------------------------------------- */
    private function insertItem($po_id, $item)
    {
        $line_total = isset($item['line_total']) ? $item['line_total'] : ($item['quantity'] * $item['unit_price']);
        
        $row = [
            'po_id' => $po_id,
            'product_id' => $item['product_id'],
            'unit_id' => isset($item['unit_id']) ? $item['unit_id'] : 1,
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'discount_value' => isset($item['discount_value']) ? $item['discount_value'] : 0,
            'discount_type' => isset($item['discount_type']) ? $item['discount_type'] : 'amount',
            'tax_value' => isset($item['tax_value']) ? $item['tax_value'] : 0,
            'line_total' => $line_total
        ];
//$row = $this->addBranch($row);
        $this->db->insert('purchase_order_items', $row);
        return $this->db->insert_id();
    }
    
    /* -----------------------------------------------------------
       UPDATE PO
    ----------------------------------------------------------- */
  /* -----------------------------------------------------------
   UPDATE PO
----------------------------------------------------------- */
public function update($id, $data)
{
	
	// Verify PO belongs to current branch
    if (!$this->verifyBranch('purchase_orders', $id)) {  // ADD THIS LINE
        error_log("Cannot update PO from different branch: $id");
        return false;
    }
    $this->db->trans_start();

    // Get current PO status
    $current_po = $this->db->select('status')->where('id', $id)->get('purchase_orders')->row();
    
    $updateData = [
        'supplier_id' => $data['supplier_id'] ?? null,
        'order_date' => $data['po_date'] ?? null,
        'expected_date' => $data['expected_delivery_date'],
		'remarks' => $data['remarks'] ?? null,
        'subtotal' => $data['subtotal'] ?? 0,
        'discount_value' => $data['discount_value'] ?? 0,
        'discount_type' => $data['discount_type'] ?? 'amount',
        'tax_total' => $data['tax_total'] ?? 0,
        'grand_total' => $data['grand_total'] ?? 0,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    //$updateData = $this->addBranch($updateData); 
    // FIX: Change status for both 'new' and 'draft'
    if ($current_po && ($current_po->status == 'new' || $current_po->status == 'draft')) {
        // Only change 'new' to 'draft'
        if ($current_po->status == 'new') {
            $updateData['status'] = 'draft';
        }
        // If already draft, status remains draft
    } else {
        // For 'submitted' or 'approved', don't allow update
        // REMOVED the $this->response() call - just return false
        error_log("Cannot edit PO in " . $current_po->status . " status");
        $this->db->trans_rollback();
        return false;
    }
    
    $this->db->where('id', $id)->update('purchase_orders', $updateData);

    // Update items if provided
    if (isset($data['items']) && is_array($data['items'])) {
        $this->db->where('po_id', $id)->delete('purchase_order_items');
        
        foreach ($data['items'] as $item) {
            $this->insertItem($id, $item);
        }
    }
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'PO Module','Update PO','UPDATE');
	//end of activity log
 
    $this->logApproval($id, 'edited');
    $this->db->trans_complete();

    return $this->db->trans_status();
}

    
    /* -----------------------------------------------------------
       DELETE PO
    ----------------------------------------------------------- */
    public function delete($id)
    { // Verify PO belongs to current branch
    if (!$this->verifyBranch('purchase_orders', $id)) {  // ADD THIS LINE
        return false;
    }
    
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'PO Module','Delete PO','DELETE');
		//end of activity log
		
        $this->db->where('id', $id)->delete('purchase_orders');
        return $this->db->affected_rows() > 0;
    }
    
    /* -----------------------------------------------------------
       CREATE DRAFT PO
    ----------------------------------------------------------- */
    public function createDraftPO()
    {
        $year = date('Y');
        
        $this->db->like('po_number', 'PO-' . $year . '-', 'after');
        $count = $this->db->count_all_results('purchase_orders') + 1;
        
        $po_number = 'PO-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        
        $default_supplier = $this->db->select('id')
                                     ->where('status', 'active')
                                     ->limit(1)
                                     ->get('supply')
                                     ->row();
        
        $current_user = $this->session->userdata('user_id');
        $supplier_id = $default_supplier ? $default_supplier->id : 1;
        
        $draft_data = [
            'po_number' => $po_number,
            'supplier_id' => $supplier_id,
            'order_date' => date('Y-m-d'),
            'expected_date' => $data['expected_delivery_date'],
			'subtotal' => 0,
            'discount_value' => 0,
            'discount_type' => 'percent',
            'tax_total' => 0,
            'grand_total' => 0,
            'status' => 'new',
            'created_by' => $current_user,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $draft_data = $this->addBranch($draft_data);
        $this->db->insert('purchase_orders', $draft_data);
        $po_id = $this->db->insert_id();
        
        $this->logApproval($po_id, 'created');
        
        return [
            'po_id' => $po_id,
            'po_number' => $po_number
        ];
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'PO Module','Create Draft PO','INSERT');
		//end of activity log
    }
    
    /* -----------------------------------------------------------
       GET DRAFT PO
    ----------------------------------------------------------- */
    public function getDraftPO()
    { $branch_id = $this->getCurrentBranchId();
        $user_id = $this->session->userdata('user_id');
        
        $draft = $this->db->where('created_by', $user_id)
		->where('branch_id', $branch_id) 
                          ->where('status', 'new')
                          ->order_by('id', 'DESC')
                          ->limit(1)
                          ->get('purchase_orders')
                          ->row();
        
        if (!$draft) {
            return null;
        }
        
        $items = $this->db->where('po_id', $draft->id)
                          ->get('purchase_order_items')
                          ->result();
        
        $draft->items = $items;
        $draft->po_date = $draft->order_date;
        
        return $draft;
    }
    
    /* -----------------------------------------------------------
       SUBMIT FOR APPROVAL
    ----------------------------------------------------------- */
    public function submitForApproval($po_id)
    { // Verify PO belongs to current branch
    if (!$this->verifyBranch('purchase_orders', $po_id)) {  // ADD THIS LINE
        error_log("Cannot submit PO from different branch: $po_id");
        return false;
    }
        $this->db->trans_start();
        
        $po = $this->db->where('id', $po_id)->get('purchase_orders')->row();
        
        if (!$po) {
            return false;
        }
        
        $this->db->where('id', $po_id)->update('purchase_orders', [
            'status' => 'submitted',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->logApproval($po_id, 'submitted');
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
		
    }
    
    /* -----------------------------------------------------------
   APPROVE PO - Enhanced version like GRN
----------------------------------------------------------- */
/* -----------------------------------------------------------
   APPROVE PO - Simple Working Version
----------------------------------------------------------- */
public function approve($po_id)
{ // Verify PO belongs to current branch
    if (!$this->verifyBranch('purchase_orders', $po_id)) {  // ADD THIS LINE
        error_log("Cannot approve PO from different branch: $po_id");
        return false;
    }
    // Get current PO
    $po = $this->db->where('id', $po_id)->get('purchase_orders')->row();
    
	$po_numb = $po->po_number;
	
    if (!$po) {
        error_log("PO not found for approval: " . $po_id);
        return false;
    }
    
    // Check if PO is in correct status
    if ($po->status != 'submitted') {
        error_log("PO cannot be approved. Current status: " . $po->status);
        return false;
    }
    
    // Update PO status
    $result = $this->db->where('id', $po_id)->update('purchase_orders', [
        'status' => 'approved',
        'approved_by' => $this->session->userdata('user_id'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
	//Added by pubudu Anuradha function call for send message/email on 2026-05-08
	/*$event = "Create Purchase Order";
	$module = "Purchase Order";
	$type = "sms";
	$to = "0702952227";
	$msg ="Purchase Order Created [".$po_numb."]";
		
	$this->Notification_model->save_message_log($event,$module,$type,$to,$msg);*/
	//function call for send message/email end
	
	
    if ($result) {
		
		// --- START OF ACTIVITY LOG ---
        // FIX: Extract supplier_id directly from the database record object
        $supplier_id = isset($po->supplier_id) ? $po->supplier_id : null;
        
		$supplier = $this->Supply_model->get_supplier_by_id($supplier_id);
		
		$phone    = isset($supplier->phone) ? $supplier->phone : "";
		$email    = isset($supplier->email) ? $supplier->email : "";
        
        $user_id_fk = $this->session->userdata('user_id');
        $user_type  = $this->session->userdata('ut_id');
        
        // Clearer context: Notifying that it was Approved, not Created
        $msg = "Purchase Order Approved: [" . $po_numb . "]";
        
        $this->Activity_log_m->addLog($user_id_fk, $user_type, 'PO Module', 'approved PO', 'UPDATE', true, 1, $phone, $email, $msg);
        // --- END OF ACTIVITY LOG ---
		
        // Log approval action
        $this->logApproval($po_id, 'approved');
        error_log("PO $po_id approved successfully");
        return true;
    } else {
        error_log("Failed to update PO $po_id");
        return false;
    }
	
	
}

/* -----------------------------------------------------------
   REJECT PO - Enhanced version like GRN
----------------------------------------------------------- */
public function reject($po_id, $note = null)
{  // Verify PO belongs to current branch
    if (!$this->verifyBranch('purchase_orders', $po_id)) {  // ADD THIS LINE
        error_log("Cannot reject PO from different branch: $po_id");
        return false;
    }
    $this->db->trans_start();
    
    // Get current PO
    $po = $this->db->where('id', $po_id)->get('purchase_orders')->row();
    
    if (!$po) {
        $this->db->trans_rollback();
        error_log("PO not found for rejection: " . $po_id);
        return false;
    }
    
    // Check if PO can be rejected
    if (!in_array($po->status, ['submitted', 'new', 'draft'])) {
        $this->db->trans_rollback();
        error_log("PO cannot be rejected. Current status: " . $po->status);
        return false;
    }
    
    // Update PO status
    $this->db->where('id', $po_id)->update('purchase_orders', [
        'status' => 'rejected',
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
    // Log rejection (like GRN does)
    $this->logApproval($po_id, 'rejected', $note);
    
    // OPTIONAL: Update approval request if exists
    if ($this->db->table_exists('approval_requests')) {
        $this->db->where('document_type', 'PO')
                 ->where('document_id', $po_id)
                 ->where('status', 'pending')
                 ->update('approval_requests', [
                     'status' => 'rejected',
                     'rejection_reason' => $note,
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
    }
    
    $this->db->trans_complete();
    
    if ($this->db->trans_status()) {
        error_log("PO $po_id rejected successfully");
        return true;
    } else {
        error_log("Transaction failed for PO rejection ID: " . $po_id);
        return false;
    }
}

/* -----------------------------------------------------------
   CREATE NOTIFICATION FOR APPROVAL (Helper Method)
----------------------------------------------------------- */
private function createApprovalNotification($po_id)
{
    // Check if notification system exists
    if ($this->db->table_exists('notifications')) {
        $po = $this->db->where('id', $po_id)->get('purchase_orders')->row();
        
        if ($po) {
            // Get supplier email for notification
            $supplier = $this->db->select('name, email, phone')
                                 ->where('id', $po->supplier_id)
                                 ->get('supply')
                                 ->row();
            
            if ($supplier && $supplier->email) {
                $this->db->insert('notifications', [
                    'type' => 'po_approved',
                    'reference_id' => $po_id,
                    'reference_number' => $po->po_number,
                    'recipient_type' => 'supplier',
                    'recipient_id' => $po->supplier_id,
                    'recipient_email' => $supplier->email,
                    'subject' => 'Purchase Order Approved',
                    'message' => 'Your purchase order ' . $po->po_number . ' has been approved.',
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}

/* -----------------------------------------------------------
   CHECK IF PO CAN BE APPROVED
----------------------------------------------------------- */
public function canApprove($po_id)
{
    $po = $this->db->select('status, grand_total')
                   ->where('id', $po_id)
                   ->get('purchase_orders')
                   ->row();
    
    if (!$po) {
        return ['can_approve' => false, 'reason' => 'PO not found'];
    }
    
    if ($po->status != 'submitted') {
        return ['can_approve' => false, 'reason' => 'PO must be submitted first'];
    }
    
    // Check if PO has items
    $item_count = $this->db->where('po_id', $po_id)
                           ->count_all_results('purchase_order_items');
    
    if ($item_count == 0) {
        return ['can_approve' => false, 'reason' => 'PO has no items'];
    }
    
    // Check if grand total is valid
    if ($po->grand_total <= 0) {
        return ['can_approve' => false, 'reason' => 'PO total amount is zero or negative'];
    }
    
    return ['can_approve' => true, 'reason' => ''];
}

// /* -----------------------------------------------------------
   // BULK APPROVE MULTIPLE POS
// ----------------------------------------------------------- */
// public function bulkApprove($po_ids)
// {
    // if (empty($po_ids) || !is_array($po_ids)) {
        // return false;
    // }
    
    // $this->db->trans_start();
    
    // $approved_count = 0;
    // $failed_ids = [];
    
    // foreach ($po_ids as $po_id) {
        // $check = $this->canApprove($po_id);
        
        // if ($check['can_approve']) {
            // $result = $this->approve($po_id);
            // if ($result) {
                // $approved_count++;
            // } else {
                // $failed_ids[] = $po_id;
            // }
        // } else {
            // $failed_ids[] = $po_id;
            // error_log("PO $po_id cannot be approved: " . $check['reason']);
        // }
    // }
    
    // $this->db->trans_complete();
    
    // return [
        // 'success' => $this->db->trans_status(),
        // 'total' => count($po_ids),
        // 'approved' => $approved_count,
        // 'failed' => $failed_ids
    // ];
// }

/* -----------------------------------------------------------
   GET APPROVAL WORKFLOW STATUS
----------------------------------------------------------- */
public function getApprovalStatus($po_id)
{
    $po = $this->db->select('status, approved_by, approved_at, created_by, created_at')
                   ->where('id', $po_id)
                   ->get('purchase_orders')
                   ->row();
    
    if (!$po) {
        return null;
    }
    
    $approver_name = null;
    if ($po->approved_by) {
        $approver = $this->db->select('full_name')
                             ->where('user_id', $po->approved_by)
                             ->get('user')
                             ->row();
        $approver_name = $approver ? $approver->full_name : null;
    }
    
    $creator_name = null;
    if ($po->created_by) {
        $creator = $this->db->select('full_name')
                            ->where('user_id', $po->created_by)
                            ->get('user')
                            ->row();
        $creator_name = $creator ? $creator->full_name : null;
    }
    
    return [
        'current_status' => $po->status,
        'created_by' => $creator_name,
        'created_at' => $po->created_at,
        'approved_by' => $approver_name,
        'approved_at' => $po->approved_at,
        'can_approve' => ($po->status == 'submitted'),
        'can_reject' => in_array($po->status, ['submitted', 'new', 'draft'])
    ];
}
    
    /* -----------------------------------------------------------
       LOG APPROVAL
    ----------------------------------------------------------- */
    public function logApproval($po_id, $action, $note = null)
    {
        $this->db->insert('po_approvals', [
            'po_id' => $po_id,
            'action' => $action,
            'action_by' => $this->session->userdata('user_id'),
            'action_note' => $note,
            'action_date' => date('Y-m-d H:i:s')
        ]);
    }
    
    /* -----------------------------------------------------------
       GET PO SUMMARY
    ----------------------------------------------------------- */
    public function getPOSummary($po_id)
    {  $this->filterByBranch(); 
        $po = $this->db->where('id', $po_id)->get('purchase_orders')->row();
        
        if (!$po) return null;
        
        $items = $this->db->select('COUNT(*) as item_count, SUM(quantity) as total_qty')
                          ->where('po_id', $po_id)
                          ->get('purchase_order_items')
                          ->row();
        
        $supplier = $this->db->select('name')->where('id', $po->supplier_id)->get('supply')->row();
        $created_by = $this->db->select('full_name')->where('user_id', $po->created_by)->get('user')->row();
        
        return [
            'po_number' => $po->po_number,
            'status' => $po->status,
            'created_by' => $created_by ? $created_by->full_name : 'Unknown',
            'created_on' => date('d M Y', strtotime($po->created_at)),
            'supplier_name' => $supplier ? $supplier->name : 'Unknown',
            'total_items' => $items->item_count ? $items->item_count : 0,
            'total_qty' => $items->total_qty ? $items->total_qty : 0,
            'grand_total' => $po->grand_total
        ];
    }
    
    /* -----------------------------------------------------------
       GET PO HISTORY
    ----------------------------------------------------------- */
    public function getPOHistory($po_id)
{
    $this->filterByBranch();
        $approvals = $this->db->select('pa.*, u.full_name as user_name')
                              ->from('po_approvals pa')
                              ->join('user u', 'u.user_id = pa.action_by', 'left')
                              ->where('pa.po_id', $po_id)
                              ->order_by('pa.id', 'ASC')
                              ->get()
                              ->result();
        
        $history = [];
        foreach ($approvals as $approval) {
            $action = $approval->action;
            $icon = 'ri-information-line';
            $color = 'secondary';
            
            switch ($action) {
                case 'created':
                    $icon = 'ri-add-circle-line';
                    $color = 'primary';
                    $text = 'PO was created';
                    break;
                case 'edited':
                    $icon = 'ri-edit-line';
                    $color = 'info';
                    $text = 'PO was edited';
                    break;
                case 'submitted':
                    $icon = 'ri-send-plane-line';
                    $color = 'warning';
                    $text = 'Submitted for approval';
                    break;
                case 'approved':
                    $icon = 'ri-checkbox-circle-line';
                    $color = 'success';
                    $text = 'PO was approved';
                    break;
                case 'rejected':
                    $icon = 'ri-close-circle-line';
                    $color = 'danger';
                    $text = 'PO was rejected';
                    break;
                default:
                    $text = ucfirst($action);
            }
            
            $history[] = [
                'id' => $approval->id,
                'action' => $action,
                'action_text' => $text,
                'action_by' => $approval->user_name ?? 'System',
                'action_date' => date('d M Y H:i:s', strtotime($approval->action_date)),
                'note' => $approval->action_note,
                'icon' => $icon,
                'color' => $color
            ];
        }
        
        return $history;
    }
    
    /* -----------------------------------------------------------
       GET PRODUCT DETAILS
    ----------------------------------------------------------- */
    public function getProductDetails($product_id)
    {
        if (!$product_id) return false;
        
        $product = $this->db->select('p.*, u.unit_name')
                             ->from('products p')
                             ->join('units u', 'u.unit_id = p.unit_id', 'left')
                             ->where('p.id', $product_id)
                             ->get()
                             ->row();
        
        if (!$product) return false;
        
        $unit_name = $product->unit_name ?? 'N/A';
        $last_price = $product->last_purchase_price ?? 0;
        $default_price = $product->price ?? 0;
        $suggested_price = ($last_price > 0) ? $last_price : $default_price;
        
        return [
            'unit' => $unit_name,
            'last_price' => $last_price,
            'default_price' => $default_price,
            'suggested_price' => $suggested_price,
            'product_name' => $product->name,
            'product_code' => $product->product_code
        ];
    }
    
    /* -----------------------------------------------------------
       GET PO FOR PRINT
    ----------------------------------------------------------- */
    public function get_po_for_print($id)
	
    {
		// 1. Fetch Company Info from sys_info table
		$company = $this->db->get('sys_info')->row();
		
        $this->db->select('
            purchase_orders.*, 
            supply.name as supplier_name,
			supply.cre_period as cred_period,
            supply.address as supplier_address, 
            supply.phone as supplier_phone,
            u1.full_name as prepared_by_name, 
            u2.full_name as approved_by_name
        ');
        $this->db->from('purchase_orders');
        $this->db->join('supply', 'supply.id = purchase_orders.supplier_id', 'left');
        $this->db->join('user u1', 'u1.user_id = purchase_orders.created_by', 'left');
        $this->db->join('user u2', 'u2.user_id = purchase_orders.approved_by', 'left');
        $this->db->where('purchase_orders.id', $id);
        $query = $this->db->get();
        $po = $query->row();

        if ($po) {
            $this->db->select('
                purchase_order_items.*, 
                products.name as product_name, 
                products.product_code, 
                units.unit_code,
                units.unit_name
            ');
            $this->db->from('purchase_order_items');
            $this->db->join('products', 'products.id = purchase_order_items.product_id');
            $this->db->join('units', 'units.unit_id = purchase_order_items.unit_id', 'left');
            $this->db->where('purchase_order_items.po_id', $id);
            $po->items = $this->db->get()->result();
			
			$po->company = $company;
        }

        return $po;
    }
	/* -----------------------------------------------------------
		GET PO BY ID (ANY STATUS)
	----------------------------------------------------------- */

/* -----------------------------------------------------------
   GET PO BY ID (ANY STATUS) - ADD THIS METHOD
----------------------------------------------------------- */
public function getPOById($po_id)
{
    if (!$po_id) { 
        return null;
    }
    
    $this->filterByBranch();  
    
    // Get the PO header
    $po = $this->db->where('id', $po_id)->get('purchase_orders')->row();
    
    if (!$po) {
        return null;
    }
    
    // Get supplier name
    $supplier = $this->db->select('name')->where('id', $po->supplier_id)->get('supply')->row();
    $po->supplier_name = $supplier ? $supplier->name : null;
    
    // Get created by name
    $creator = $this->db->select('full_name')->where('user_id', $po->created_by)->get('user')->row();
    $po->created_by_name = $creator ? $creator->full_name : null;
    
    // Get items for this PO
    $items = $this->db->select('poi.*, p.name as product_name, p.product_code')
                      ->from('purchase_order_items poi')
                      ->join('products p', 'p.id = poi.product_id', 'left')
                      ->where('poi.po_id', $po->id)
                      ->get()
                      ->result();
    
    $po->items = $items;
    $po->po_date = $po->order_date;
    
    return $po;
}
}