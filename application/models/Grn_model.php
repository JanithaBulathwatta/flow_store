<?php

//madhushika(2026-03-27)
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'traits/BranchTrait.php';

class Grn_model extends CI_Model {
	
	use BranchTrait;
	

    /* -----------------------------------------------------------
       GET GRN LIST
    ----------------------------------------------------------- */

    /*public function getList($filters = [])
    {
        if (!empty($filters['supplier_id'])) {
            $this->db->where('supplier_id', $filters['supplier_id']);
        }

        if (!empty($filters['warehouse_id'])) {
            $this->db->where('warehouse_id', $filters['warehouse_id']);
        }

        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }

        return $this->db->order_by('id','DESC')
                        ->get('grn')
                        ->result();
    }*/
	
	public function getList($filters = [])
	{
		 $this->filterByBranch('g'); 
		$this->db->select('g.*,s.store_name,sup.name as supplier_name,stf.full_name as received_by');
		$this->db->from('grn g');
		$this->db->join('stores s','s.store_id = g.warehouse_id','left');
		$this->db->join('supply sup','sup.id = g.supplier_id','left');
		$this->db->join('user u','u.user_id = g.created_by','left');
		$this->db->join('staff_info stf','stf.staff_id = g.received_by','left');

		/* STORE FILTER */
		if(!empty($filters['fk_store_id'])){
			$this->db->where('g.warehouse_id', $filters['fk_store_id']);
		}

		/* SUPPLIER FILTER */
		if(!empty($filters['fk_sup_id'])){
			$this->db->where('g.supplier_id', $filters['fk_sup_id']);
		}

		/* USER FILTER */
		if(!empty($filters['fk_user_id'])){
			$this->db->where('g.created_by', $filters['fk_user_id']);
		}

		/* DATE RANGE FILTER */
		if(!empty($filters['date_range'])){

			$dates = explode(' – ', $filters['date_range']);

			if(count($dates) == 2){

				$start = date('Y-m-d', strtotime($dates[0]));
				$end   = date('Y-m-d', strtotime($dates[1]));

				$this->db->where('DATE(g.grn_date) >=', $start);
				$this->db->where('DATE(g.grn_date) <=', $end);
			}
		}
		
		$this->db->order_by('g.created_at','DESC');
		return $this->db->get()->result();
	}

    /* -----------------------------------------------------------
       GET SINGLE GRN
    ----------------------------------------------------------- */

    /*public function get($id)
    {
        $grn = $this->db->where('id',$id)->get('grn')->row();

        if(!$grn) return false;

        $grn->items = $this->db->where('grn_id',$id)
                               ->get('grn_items')
                               ->result();

        return $grn;
    }*/
	
	public function get($grn_id)
	{
		$this->filterByBranch(); 
		$this->db->select('gi.*,p.name as product_name,p.product_code');

		$this->db->from('grn_items gi');
		$this->db->join('products p','p.id = gi.product_id','left');

		$this->db->where('gi.grn_id', $grn_id);

		return $this->db->get()->result();
	}
	
	
	// print page porduct function
	public function get_product($id)
	{
		
		// 1. Fetch Company Info from sys_info table
		$company = $this->db->get('sys_info')->row();
		
		// 1. Fetch main GRN details with Supplier and User names
		$this->db->select('
			grn.*, 
			supply.name as supplier_name, 
			supply.address as supplier_address, 
			supply.phone as supplier_phone,
			u1.full_name as prepared_by_name, 
			u2.full_name as received_by_name, 
			u3.full_name as approved_by_name
			
		');
		$this->db->from('grn');
		$this->db->join('supply', 'supply.id = grn.supplier_id', 'left');
		$this->db->join('user u1', 'u1.user_id = grn.created_by', 'left'); // Prepared by
		$this->db->join('user u2', 'u2.user_id = grn.received_by', 'left'); // Received by
		$this->db->join('user u3', 'u3.user_id = grn.approved_by', 'left'); // Approved by
		$this->db->where('grn.id', $id);
		$query = $this->db->get();
		$grn = $query->row();

		if ($grn) {
			// Fetch Items with Product info and Unit Name
			$this->db->select('grn_items.*, products.name as product_name, products.product_code, units.unit_name, units.unit_code ');
			$this->db->from('grn_items');
			$this->db->join('products', 'products.id = grn_items.product_id');
			$this->db->join('units', 'units.unit_id = grn_items.unit_id', 'left'); 
			$this->db->where('grn_items.grn_id', $id);
			$grn->items = $this->db->get()->result();
			
			$grn->company = $company;
		}

		return $grn;
	}
	


    /* -----------------------------------------------------------
       CREATE GRN
    ----------------------------------------------------------- */

    public function create($data)
{
	

	
    $this->db->trans_start();

		print_r($data['reference_no']);
		exit;

     $header = [
        'grn_number' => $data['grn_number'],
        'supplier_id' => $data['supplier_id'],
        'warehouse_id' => $data['warehouse_id'],
        'po_id' => $data['po_id'] ?? null,
        'grn_date' => $data['grn_date'],
        'delivery_note' => $data['delivery_note'] ?? null,
        'ref_invoice_no' => $data['reference_no'] ?? null,
        'subtotal' => $data['subtotal'] ?? 0,
        'discount_value' => $data['discount_value'] ?? 0,
        'discount_type' => $data['discount_type'] ?? 'amount',
        'tax_total' => $data['tax_total'] ?? 0,
        'grand_total' => $data['grand_total'] ?? 0,
        'remarks' => $data['remarks'] ?? null,
        // ADD THIS LINE - Save paid_amount
        'paid_amount' => $data['paid_amount'] ?? 0,
        'status' => 'new',
        'created_by' => $this->session->userdata('user_id'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    $header = $this->addBranch($header); 
    $this->db->insert('grn', $header);
    $grn_id = $this->db->insert_id();

    if (!$grn_id) {
        $this->db->trans_rollback();
        return false;
    }

    if (isset($data['items']) && is_array($data['items'])) {
        foreach ($data['items'] as $item) {
            $this->insertItem($grn_id, $item);
        }
    }

    $this->logApproval($grn_id, 'created');
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'GRN Module','Create GRN','INSERT');
	//end of activity log

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
        return $grn_id;
    } else {
        error_log("Transaction failed for GRN creation");
        return false;
    }
}

    /* -----------------------------------------------------------
       INSERT GRN ITEM
    ----------------------------------------------------------- */

private function insertItem($grn_id, $item)
{
    // Get GRN number for auto-batch naming
    $grn = $this->db->select('grn_number')->where('id', $grn_id)->get('grn')->row();
    $grn_number = $grn ? $grn->grn_number : 'GRN-' . $grn_id;
    
    // Get product to check flags
    $product = $this->db->select('is_batch, is_auto_batch')
                       ->where('id', $item['product_id'])
                       ->get('products')
                       ->row();
    
    $batch_number = $item['batch_number'] ?? null;
    $expiry_date = $item['expiry_date'] ?? null;
    $is_auto_batch = 0;
    
    // Decision logic
    if ($product && $product->is_auto_batch == 1) {
        $batch_number = 'AUTO-' . $grn_number . '-P' . $item['product_id'];
        $expiry_date = null;
        $is_auto_batch = 1;
    } else if ($product && $product->is_batch == 1 && empty($batch_number)) {
        $batch_number = 'AUTO-' . $grn_number . '-P' . $item['product_id'];
        $is_auto_batch = 1;
    }
    
    // ========== FIX: Handle serials properly ==========
    $serials_json = null;
    $has_serials = 0;
    
    // Check various possible locations for serials data
    if (isset($item['serials_data']) && !empty($item['serials_data'])) {
        // Already JSON
        if (is_string($item['serials_data'])) {
            $serials_json = $item['serials_data'];
        } else {
            $serials_json = json_encode($item['serials_data']);
        }
        $has_serials = 1;
        error_log("Serial data saved to grn_items: " . $serials_json);
    } 
    elseif (isset($item['serials']) && !empty($item['serials'])) {
        $serials_json = json_encode($item['serials']);
        $has_serials = 1;
        error_log("Serial data from 'serials' key: " . $serials_json);
    }
    elseif (isset($item['serials_data']) && is_array($item['serials_data']) && !empty($item['serials_data'])) {
        $serials_json = json_encode($item['serials_data']);
        $has_serials = 1;
        error_log("Serial data from array: " . $serials_json);
    }
    
    $row = [
        'grn_id' => $grn_id,
        'product_id' => $item['product_id'],
        'unit_id' => $item['unit_id'],
        'quantity' => $item['quantity'],
        'free_quantity' => $item['free_quantity'] ?? 0,
        'unit_price' => $item['unit_price'],
        'discount_value' => $item['discount_value'] ?? 0,
        'discount_type' => $item['discount_type'] ?? 'amount',
        'tax_value' => $item['tax_value'] ?? 0,
        'batch_number' => $batch_number,
        'expiry_date' => $expiry_date,
        'line_total' => $item['line_total'],
        'has_serials' => $has_serials,
        'serials_data' => $serials_json,  // This is the critical line
    ];
    
    $this->db->insert('grn_items', $row);
    $item_id = $this->db->insert_id();
    
    error_log("Inserted GRN item ID: $item_id, has_serials: $has_serials, serials_data length: " . strlen($serials_json ?? ''));
    
    return $item_id;
}

    /* -----------------------------------------------------------
       UPDATE GRN
    ----------------------------------------------------------- */

   public function update($id, $data)
{
	

	
    $this->db->trans_start();

    // Get current GRN status
    $current_grn = $this->db->select('status')->where('id', $id)->get('grn')->row();
    
    // Prepare update data
   $updateData = [
        'supplier_id' => $data['supplier_id'] ?? null,
        'warehouse_id' => $data['warehouse_id'] ?? null,
        'grn_date' => $data['grn_date'] ?? null,
        'delivery_note' => $data['delivery_note'] ?? null,
        'ref_invoice_no' => $data['reference_no'] ?? null,
        'remarks' => $data['remarks'] ?? null,
        'subtotal' => $data['subtotal'] ?? 0,
        'discount_value' => $data['discount_value'] ?? 0,
        'discount_type' => $data['discount_type'] ?? 'amount',
        'tax_total' => $data['tax_total'] ?? 0,
        'grand_total' => $data['grand_total'] ?? 0,
        // ADD THIS LINE - Save paid_amount
        'paid_amount' => $data['paid_amount'] ?? 0,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    // FIX: Change status from 'new' to 'draft' when saving
    if ($current_grn && $current_grn->status == 'new') {
        $updateData['status'] = 'draft';
        error_log("Changing GRN status from 'new' to 'draft' for ID: " . $id);
    }
    $updateData = $this->addBranch($updateData);
    $this->db->where('id', $id)->update('grn', $updateData);

    // Update items if provided
    if (isset($data['items']) && is_array($data['items'])) {
        // Delete existing items
        $this->db->where('grn_id', $id)->delete('grn_items');
        
        // Insert new items
        foreach ($data['items'] as $item) {
            $this->insertItem($id, $item);
        }
    }

    $this->logApproval($id, 'edited');
	
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'GRN Module','Update GRN','UPDATE');
	//end of activity log

    $this->db->trans_complete();

    return $this->db->trans_status();
}
    /* -----------------------------------------------------------
       DELETE GRN
    ----------------------------------------------------------- */

   public function delete($id)
{
    // Verify GRN belongs to current branch
    if (!$this->verifyBranch('grn', $id)) {
        error_log("Cannot delete GRN from different branch: $id");
        return false;
    }
		
	//for activity log entry
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$this->Activity_log_m->addLog($user_id_fk,$user_type,'GRN Module','Delete GRN','DELETE');
	//end of activity log
		
        return $this->db->where('id',$id)->delete('grn');
    }

    /* -----------------------------------------------------------
       SUBMIT GRN
    ----------------------------------------------------------- */

    public function submit($id)
    {
        $this->db->where('id',$id)->update('grn',['status'=>'submitted']);

        $this->logApproval($id,'submitted');

        return true;
    }

public function approve($id)
{
	$branch_id = $this->getCurrentBranchId();
    // Verify GRN belongs to current branch
    if (!$this->verifyBranch('grn', $id)) {
        error_log("Cannot approve GRN from different branch: $id");
        return false;
    }
    $this->db->trans_start();

    $grn = $this->db->select('warehouse_id, supplier_id, grn_date, grn_number, status')
                   ->where('id', $id)
                   ->get('grn')
                   ->row();
    
    if (!$grn) {
        $this->db->trans_rollback();
        error_log("GRN not found: " . $id);
        return false;
    }
    
    // If already approved, skip
    if ($grn->status == 'approved') {
        error_log("GRN already approved: " . $id);
        $this->db->trans_rollback();
        return false;
    }
    
    $warehouse_id = $grn->warehouse_id;
    $grn_date = $grn->grn_date;
    $grn_numb = $grn->grn_number;

    // Check if invoice already exists, if not, create it
    $existing_invoice = $this->db->where('reference_id', $id)
                                 ->where('source_type', 'grn')
                                 ->get('supplier_invoices')
                                 ->row();   
    
    if (!$existing_invoice) {
        // Create supplier invoice if not already created
        $invoice_id = $this->createSupplierInvoiceFromGRN($id);
        if ($invoice_id) {
            error_log("Supplier invoice created during approval for GRN: $id, Invoice ID: $invoice_id");
        } else {
            error_log("WARNING: Failed to create supplier invoice during approval for GRN: $id");
        }
    } else {
        error_log("Supplier invoice already exists for GRN: $id, Invoice ID: {$existing_invoice->id}");
    }

    // Update GRN status to approved
    $this->db->where('id', $id)->update('grn', [
        'status' => 'approved',
        'approved_by' => $this->session->userdata('user_id'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    $items = $this->db->where('grn_id', $id)->get('grn_items')->result();
    $updated_products = [];

    foreach($items as $item)
    {
        error_log("=== Processing item for product ID: {$item->product_id} ===");
        error_log("Unit price from GRN item: {$item->unit_price}");
        
        // Get product's auto-batch setting
        $product = $this->db->select('is_auto_batch, is_batch, last_purchase_price, last_purchase_date')
                           ->where('id', $item->product_id)
                           ->get('products')
                           ->row();
        
        error_log("Current product last_purchase_price before update: " . ($product->last_purchase_price ?? 'NULL'));
        
        $qty = $item->quantity + $item->free_quantity;
        
        // Determine if this is an auto-batch
        $is_auto_batch = ($product && $product->is_auto_batch == 1) ? 1 : 0;
        
        // Handle batch
        $batch_id = null;
        if(!empty($item->batch_number))
        {
            $batch_result = $this->insertBatch($item, $warehouse_id, $is_auto_batch);
            $batch_id = $batch_result['batch_id'];
            error_log("Batch processed for product {$item->product_id}, batch_no: {$item->batch_number}, batch_id: $batch_id");
        }
        
        // For auto-batch products, migrate stock if needed
        if ($is_auto_batch && $batch_id) {
            $stock_exists = $this->db->where('product_id', $item->product_id)
                                     ->where('warehouse_id', $warehouse_id)
                                     ->where('batch_id', $batch_id)
                                     ->get('inventory_stock')
                                     ->row();
            
            if (!$stock_exists) {
                $null_batch_stock = $this->db->where('product_id', $item->product_id)
                                             ->where('warehouse_id', $warehouse_id)
                                             ->where('batch_id IS NULL')
                                             ->get('inventory_stock')
                                             ->row();
                
                if ($null_batch_stock) {
                    $this->db->where('id', $null_batch_stock->id)
                             ->update('inventory_stock', [
                                 'batch_id' => $batch_id,
                                 'updated_at' => date('Y-m-d H:i:s')
                             ]);
                    error_log("Migrated stock from NULL batch to batch_id: $batch_id");
                }
            }
        }
        
        // Process serial numbers
        if($item->has_serials == 1 && !empty($item->serials_data))
        {
            $serials = json_decode($item->serials_data, true);
			$branch_id = $this->getCurrentBranchId();
            if(is_array($serials) && count($serials) > 0)
            {
                foreach($serials as $serial_no)
                {
                    $serial_no = trim($serial_no);
                    if(empty($serial_no)) continue;
                    
                    $exists = $this->db->where('serial_no', $serial_no)
                               ->where('branch_id', $branch_id)  // ADD BRANCH FILTER
                               ->get('product_serial_numbers')
                               ->num_rows();
                    
                    if($exists == 0) {
						$this->db->insert('product_serial_numbers', [
							'product_id' => $item->product_id,
							'warehouse_id' => $warehouse_id,
							'branch_id' => $branch_id,  // ADD BRANCH ID
							'serial_no' => $serial_no,
							'status' => 'AVAILABLE',
							'grn_item_id' => $item->id,
							'created_at' => date('Y-m-d H:i:s')
						]);
                    }
                }
            }
        }
        
        // FIX: Update product's last purchase price - Only update if not already updated in this approval
        if (!in_array($item->product_id, $updated_products)) {
            error_log("Updating last_purchase_price for product ID: {$item->product_id}");
            error_log("Setting to unit_price: {$item->unit_price}");
            error_log("Setting last_purchase_date to: {$grn_date}");
            
            // Direct update without any conditions
            $this->db->set('last_purchase_price', $item->unit_price);
            $this->db->set('last_purchase_date', $grn_date);
            $this->db->where('id', $item->product_id);
            $update_result = $this->db->update('products');
            
            if ($update_result) {
                error_log("✓ SUCCESS: Product {$item->product_id} updated");
                
                // Verify the update
                $verify = $this->db->select('last_purchase_price, last_purchase_date')
                                  ->where('id', $item->product_id)
                                  ->get('products')
                                  ->row();
                error_log("Verification - New last_purchase_price: " . ($verify->last_purchase_price ?? 'NULL'));
                error_log("Verification - New last_purchase_date: " . ($verify->last_purchase_date ?? 'NULL'));
                
                $updated_products[] = $item->product_id;
            } else {
                error_log("✗ FAILED: Product {$item->product_id} update failed");
                error_log("DB Error: " . $this->db->error()['message']);
            }
        } else {
            error_log("Skipping product {$item->product_id} - already updated in this GRN");
        }
        
        // Get current stock BEFORE updating
        $old_qty = $this->getCurrentStock($item->product_id, $warehouse_id, $batch_id, $branch_id);
        
        // Update stock
        $this->updateStock($item->product_id, $warehouse_id, $qty, $batch_id, $branch_id);
        
        // Calculate new quantity
        $new_qty = $old_qty + $qty;
        
        // Insert stock log
$this->db->insert('inventory_stock_log', [
    'product_id' => $item->product_id,
    'warehouse_id' => $warehouse_id,
    'branch_id' => $branch_id,  // ADD THIS LINE
    'old_qty' => $old_qty,
    'new_qty' => $new_qty,
    'reference_type' => 'GRN',
    'reference_id' => $id,
    'changed_at' => date('Y-m-d H:i:s'),
    'changed_by' => $this->session->userdata('user_id')
]);

        // Insert inventory transaction
$this->db->insert('inventory_transactions', [
    'product_id' => $item->product_id,
    'warehouse_id' => $warehouse_id,
    'branch_id' => $branch_id,  // ADD THIS LINE
    'transaction_type' => 'GRN',
    'reference_type' => 'GRN',
    'reference_id' => $id,
    'batch_id' => $batch_id,
    'qty' => $qty,
    'unit_cost' => $item->unit_price,
    'total_cost' => $qty * $item->unit_price,
    'transaction_date' => date('Y-m-d H:i:s'),
    'created_by' => $this->session->userdata('user_id')
]);
    }
	
	//for activity log entry
	
	$user_id_fk = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('ut_id');
	$msg = "GRN Created [" . $grn_numb . "]";
	
	$supplier_id = isset($grn->supplier_id) ? $grn->supplier_id : null;
	
	$supplier = $this->Supply_model->get_supplier_by_id($supplier_id);
	
	// Define the number and email
	$phone    = isset($supplier->phone) ? $supplier->phone : "";
	$email    = isset($supplier->email) ? $supplier->email : "";
	
	$this->Activity_log_m->addLog($user_id_fk, $user_type, 'GRN Module', 'Create GRN', 'INSERT', true, 1, $phone, $email, $msg);
	//end of activity log

    $this->logApproval($id, 'approved');
    $this->db->trans_complete();

    if ($this->db->trans_status()) {
        error_log("✓ GRN approval transaction completed successfully");
        error_log("✓ Updated products: " . implode(', ', $updated_products));
        return true;
    } else {
        error_log("✗ GRN approval transaction FAILED");
        return false;
    }
}



/**
 * Update Stock - With batch_id (requires modified unique key)
 */
private function updateStock($product_id, $warehouse_id, $qty, $batch_id = null, $branch_id = null)
{
    if (!$branch_id) {
        $branch_id = $this->getCurrentBranchId();
    }
    $this->db->where('product_id', $product_id)
             ->where('warehouse_id', $warehouse_id);
    
    if ($batch_id) {
        $this->db->where('batch_id', $batch_id);
    } else {
        $this->db->where('batch_id IS NULL');
    }
    
    $row = $this->db->get('inventory_stock')->row();

    if ($row) {
        // Update existing - ADD to current stock (not replace)
        $new_qty = $row->qty + $qty;
        $this->db->where('id', $row->id)
                 ->update('inventory_stock', [
                     'qty' => $new_qty,
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
        error_log("Updated inventory_stock ID {$row->id}: Old Qty={$row->qty}, Adding={$qty}, New Qty={$new_qty}");
    } else {
        // Insert new stock record
        $this->db->insert('inventory_stock', [
            'product_id' => $product_id,
            'warehouse_id' => $warehouse_id,
            'branch_id' => $branch_id,
            'batch_id' => $batch_id,
            'qty' => $qty,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        error_log("Created new inventory_stock record for product $product_id, batch_id: " . ($batch_id ?? 'NULL') . ", Qty: $qty");
    }
}
/**
 * Get Current Stock - Also respects batch_id
 */
private function getCurrentStock($product_id, $warehouse_id, $batch_id = null, $branch_id = null)
{
    if (!$branch_id) {
        $branch_id = $this->getCurrentBranchId();
    }
    $this->db->select('qty')
             ->where('product_id', $product_id)
             ->where('warehouse_id', $warehouse_id)
             ->where('branch_id', $branch_id);
    
    if ($batch_id) {
        $this->db->where('batch_id', $batch_id);
    } else {
        $this->db->where('batch_id IS NULL');
    }
    
    $row = $this->db->get('inventory_stock')->row();
    
    return $row ? $row->qty : 0;
}

/**
 * Process Stock Transaction (using your schema)
 */
private function processStockTransaction($data)
{
    // Get current stock
    $current_stock = $this->getCurrentStock(
        $data['product_id'],
        $data['warehouse_id']
    );

    // Calculate new quantity
    $qty_change = ($data['direction'] === 'IN') 
        ? $data['quantity'] 
        : -$data['quantity'];

    $new_qty = $current_stock + $qty_change;

    // Insert transaction record
    $this->db->insert('inventory_transactions', [
    'product_id' => $item->product_id,
    'warehouse_id' => $warehouse_id,
        'transaction_type' => 'GRN',
        'reference_type' => $data['reference_type'],
        'reference_id' => $data['reference_id'],
        'batch_id' => $data['batch_id'] ?? null,
        'qty' => $data['quantity'],
        'unit_cost' => $data['unit_cost'] ?? 0,
        'total_cost' => ($data['quantity'] * ($data['unit_cost'] ?? 0)),
        'transaction_date' => date('Y-m-d H:i:s'),
        'created_by' => $data['user_id'] ?? null
    ]);

    // Update stock
    $this->updateStock(
        $data['product_id'],
        $data['warehouse_id'],
        $new_qty
    );

    // Log stock change
    $this->db->insert('inventory_stock_log', [
        'product_id' => $data['product_id'],
        'warehouse_id' => $data['warehouse_id'],
        'old_qty' => $current_stock,
        'new_qty' => $new_qty,
        'reference_type' => $data['reference_type'],
        'reference_id' => $data['reference_id'],
        'changed_at' => date('Y-m-d H:i:s'),
        'changed_by' => $data['user_id'] ?? null
    ]);
}




    /* -----------------------------------------------------------
       REJECT GRN
    ----------------------------------------------------------- */

    public function reject($id,$note)
    {
        $this->db->where('id',$id)->update('grn',['status'=>'rejected']);

        $this->logApproval($id,'rejected',$note);

        return true;
    }

    /* -----------------------------------------------------------
       INVENTORY STOCK UPDATE
    ----------------------------------------------------------- */

    
    /* -----------------------------------------------------------
       INVENTORY TRANSACTION LOG
    ----------------------------------------------------------- */

    private function logInventoryTransaction(
        $product_id,
        $warehouse_id,
        $qty,
        $type,
        $ref_id
    )
    {
        $this->db->insert('inventory_transactions',[
            'product_id'=>$product_id,
            'warehouse_id'=>$warehouse_id,
            'transaction_type'=>$type,
            'reference_type'=>'GRN',
            'reference_id'=>$ref_id,
            'quantity'=>$qty,
            'created_by'=>$this->session->userdata('user_id')
        ]);
    }

    /* -----------------------------------------------------------
       INSERT BATCH
    ----------------------------------------------------------- */



		/* -----------------------------------------------------------
	   CHECK IF BATCH EXISTS (FOR VALIDATION)
	----------------------------------------------------------- */
	public function checkBatchExists($product_id, $warehouse_id, $batch_no, $exclude_grn_item_id = null)
	{
		$branch_id = $this->getCurrentBranchId();
		$this->db->where('product_id', $product_id)
				 ->where('warehouse_id', $warehouse_id)
				 ->where('branch_id', $branch_id) 
				 ->where('batch_no', $batch_no);
		
		if ($exclude_grn_item_id) {
			$this->db->where('grn_item_id !=', $exclude_grn_item_id);
		}
		
		return $this->db->get('product_batches')->num_rows() > 0;
	}

	/* -----------------------------------------------------------
	   GET BATCH DETAILS BY BATCH NUMBER
	----------------------------------------------------------- */
	public function getBatchByNumber($product_id, $warehouse_id, $batch_no)
{
    $branch_id = $this->getCurrentBranchId(); // ADD THIS LINE
    
    return $this->db->where('product_id', $product_id)
                    ->where('warehouse_id', $warehouse_id)
                    ->where('branch_id', $branch_id)  // ADD BRANCH FILTER
                    ->where('batch_no', $batch_no)
                    ->get('product_batches')
                    ->row();
}

	/* -----------------------------------------------------------
	   GET ALL BATCHES FOR A PRODUCT
	----------------------------------------------------------- */
	public function getProductBatches($product_id, $warehouse_id = null)
{
    $branch_id = $this->getCurrentBranchId(); // ADD THIS LINE
    
    $this->db->select('id, batch_no, expiry_date, qty, created_at')
             ->where('product_id', $product_id)
             ->where('branch_id', $branch_id);  // ADD BRANCH FILTER
    
    if ($warehouse_id) {
        $this->db->where('warehouse_id', $warehouse_id);
    }
    
    $this->db->order_by('expiry_date', 'ASC');
    
    return $this->db->get('product_batches')->result();
}

		/* -----------------------------------------------------------
	   SERIAL NUMBERS
	----------------------------------------------------------- */
	public function saveSerialNumbers($data)
	{
		// Debug log
		error_log("=== saveSerialNumbers called ===");
		error_log("Data: " . json_encode($data));
		
		// Check if we have serials to save
		if (empty($data['serials'])) {
			error_log("No serials to save");
			return true;
		}
		
		$product_id = $data['product_id'] ?? null;
		$warehouse_id = $data['warehouse_id'] ?? null;
		$grn_item_id = $data['grn_item_id'] ?? null;
		$serials = $data['serials'];
		$branch_id = $this->getCurrentBranchId();
		
		if (!$product_id || !$warehouse_id) {
			error_log("Missing product_id or warehouse_id for serial numbers");
			return false;
		}
		
		$this->db->trans_start();
		
		// If we have a grn_item_id, delete existing serials for this item first
			if ($grn_item_id) {
			$this->db->where('grn_item_id', $grn_item_id)
					 ->where('branch_id', $branch_id)  // ADD BRANCH FILTER
					 ->delete('product_serial_numbers');
		}	
		
		// Insert each serial number
		$inserted = 0;
		foreach ($serials as $serial) {
			$serial_no = trim($serial);
			if (empty($serial_no)) continue;
			
			$insert_data = [
				'product_id' => $product_id,
				'warehouse_id' => $warehouse_id,
				'branch_id' => $branch_id,  // ADD BRANCH ID
				'serial_no' => $serial_no,
				'status' => 'AVAILABLE',
				'grn_item_id' => $grn_item_id,
				'created_at' => date('Y-m-d H:i:s')
			];
			
			error_log("Inserting serial: " . json_encode($insert_data));
			
			$result = $this->db->insert('product_serial_numbers', $insert_data);
			if ($result) {
				$inserted++;
				error_log("Serial inserted successfully, ID: " . $this->db->insert_id());
			} else {
				error_log("Failed to insert serial: " . $serial_no);
			}
		}
		
		$this->db->trans_complete();
		
		error_log("Total serials inserted: $inserted");
		
		if ($this->db->trans_status()) {
			return true;
		} else {
			error_log("Transaction failed for serial numbers");
			return false;
		}
	} 

		/* -----------------------------------------------------------
		   ATTACHMENT UPLOAD
		----------------------------------------------------------- */

	  public function uploadAttachment($grn_id, $file)
	{
		// 1. Check if GRN exists
		$grn = $this->db->where('id', $grn_id)->get('grn')->row();
		if (!$grn) {
			error_log("uploadAttachment: GRN not found for ID: " . $grn_id);
			return false;
		}
		
		// 2. Create full path
		$upload_path = 'uploads/grn/' . $grn_id . '/';
		$full_path = FCPATH . $upload_path;
		
		// 3. Create directory if it doesn't exist
		if (!is_dir($full_path)) {
			if (!mkdir($full_path, 0777, true)) {
				error_log("uploadAttachment: Failed to create directory: " . $full_path);
				return false;
			}
		}
		
		// 4. Generate unique filename
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		$filename = time() . '_' . uniqid() . '.' . $ext;
		$filepath = $upload_path . $filename;
		$full_filepath = $full_path . $filename;
		
		// 5. Move uploaded file
		if (!move_uploaded_file($file['tmp_name'], $full_filepath)) {
			error_log("uploadAttachment: Failed to move file from " . $file['tmp_name']);
			return false;
		}
		
		// 6. Insert into database
		$data = [
			'grn_id' => $grn_id,
			'file_name' => $file['name'],
			'file_path' => $filepath,
			'file_type' => $ext,
			'uploaded_by' => $this->session->userdata('user_id'),
			'uploaded_at' => date('Y-m-d H:i:s')
		];
		
		if (!$this->db->insert('grn_attachments', $data)) {
			error_log("uploadAttachment: Failed to insert record");
			if (file_exists($full_filepath)) {
				unlink($full_filepath);
			}
			return false;
		}
		
		return [
			'id' => $this->db->insert_id(),
			'file_name' => $file['name'],
			'file_path' => $filepath
		];
	}
	
public function createDraftGRN()
{
    $user_id = $this->session->userdata('user_id');
    
    // FIRST, check if there's already a NEW GRN for this user
    $existing_new_grn = $this->db->where('created_by', $user_id)
                                 ->where('status', 'new')
                                 ->order_by('id', 'DESC')
                                 ->limit(1)
                                 ->get('grn')
                                 ->row();
    
    // If exists, return the existing one
    if ($existing_new_grn) {
        return [
            'grn_id' => $existing_new_grn->id,
            'grn_number' => $existing_new_grn->grn_number
        ];
    }
    
    // Only create new if no existing NEW GRN found
    $year = date('Y');
    
    // Get the maximum GRN number for this year
    $this->db->select('grn_number');
    $this->db->like('grn_number', 'GRN-' . $year . '-', 'after');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);
    $last_grn = $this->db->get('grn')->row();
    
    if ($last_grn && $last_grn->grn_number) {
        $parts = explode('-', $last_grn->grn_number);
        $last_number = intval(end($parts));
        $new_number = $last_number + 1;
    } else {
        $new_number = 1;
    }
    
    $grn_number = 'GRN-' . $year . '-' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    
    // Check if number exists (safety)
    $exists = $this->db->where('grn_number', $grn_number)->get('grn')->num_rows();
    while($exists > 0) {
        $new_number++;
        $grn_number = 'GRN-' . $year . '-' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
        $exists = $this->db->where('grn_number', $grn_number)->get('grn')->num_rows();
    }
    
    // Create NEW GRN with NULL values (NO default supplier/warehouse)
    $draft_data = [
        'grn_number' => $grn_number,
        'supplier_id' => null,      // No default supplier
        'warehouse_id' => null,     // No default warehouse
        'grn_date' => date('Y-m-d'),
        'delivery_note' => null,
        'ref_invoice_no' => null, 
        'received_by' => $user_id,
        'subtotal' => 0,
        'discount_value' => 0,
        'discount_type' => 'percent',
        'tax_total' => 0,
        'grand_total' => 0,
        'status' => 'new',
        'created_by' => $user_id,
        'created_at' => date('Y-m-d H:i:s')
    ];
    $draft_data = $this->addBranch($draft_data);
    $this->db->insert('grn', $draft_data);
    $grn_id = $this->db->insert_id();
    
    // Log the creation
    $this->logApproval($grn_id, 'created');
    
    return [
        'grn_id' => $grn_id,
        'grn_number' => $grn_number
    ];
}


    /* -----------------------------------------------------------
       APPROVAL HISTORY
    ----------------------------------------------------------- */

    public function getHistory($grn_id)
    {
        return $this->db->where('grn_id',$grn_id)
                        ->order_by('id','ASC')
                        ->get('grn_approvals')
                        ->result();
    }

    public function logApproval($grn_id,$action,$note=null)
    {
        $this->db->insert('grn_approvals',[
            'grn_id'=>$grn_id,
            'action'=>$action,
            'action_by'=>$this->session->userdata('user_id'),
            'action_note'=>$note
        ]);
    }


		
	public function getProductDetails($product_id)
{
    if (!$product_id) return false;

    // 1. Get product info
    $product = $this->db->where('id', $product_id)->get('products')->row();
    if (!$product) return false;

    // 2. Get unit
    $unit_name = 'N/A';
    if (isset($product->unit_id) && !empty($product->unit_id)) {
        $unit = $this->db->where('unit_id', $product->unit_id)->get('units')->row();
        $unit_name = $unit ? $unit->unit_name : 'N/A';
    }

    // 3. Get current stock from inventory_stock table
    $stock = 0;
    $stock_result = $this->db->select('COALESCE(SUM(qty), 0) as total_stock')
        ->where('product_id', $product_id)
        ->get('inventory_stock')
        ->row();
    $stock = $stock_result ? (float)$stock_result->total_stock : 0;

    // 4. Get last purchase price - DIRECTLY from products table
    $last_price = isset($product->last_purchase_price) ? (float)$product->last_purchase_price : 0;
    $last_date = isset($product->last_purchase_date) && $product->last_purchase_date != '0000-00-00' 
                 ? date('Y-m-d', strtotime($product->last_purchase_date)) 
                 : 'N/A';

    // 5. Get expiry and serial tracking flags
    $is_expiry_trk = isset($product->is_expiry_trk) ? (bool)$product->is_expiry_trk : false;
    $is_serial_trk = isset($product->is_serial_trk) ? (bool)$product->is_serial_trk : false;
    
    // Also check for is_batch flag if needed
    $is_batch = isset($product->is_batch) ? (bool)$product->is_batch : false;
    $is_auto_batch = isset($product->is_auto_batch) ? (bool)$product->is_auto_batch : false;

    error_log("Product ID: $product_id - Last Purchase Price from products table: $last_price");
    error_log("Product ID: $product_id - Last Purchase Date: " . ($last_date != 'N/A' ? $last_date : 'NULL'));

    return [
        'unit' => $unit_name,
        'stock' => $stock,
        'last_price' => $last_price,
        'last_date' => $last_date,
        'is_expiry_trk' => $is_expiry_trk,
        'is_serial_trk' => $is_serial_trk,
        'is_batch' => $is_batch,
        'is_auto_batch' => $is_auto_batch
    ];
}

	public function getPurchaseOrdersData($supplier_id = null, $date_from = null, $date_to = null)
	{
		try {
			$this->db->select('po.*, s.name as supplier_name')
					 ->from('purchase_orders po')
					 ->join('supply s', 's.id = po.supplier_id', 'left')
					 ->where('po.status !=', 'cancelled')
					 ->order_by('po.id', 'DESC');
			
			if ($supplier_id && $supplier_id != '') {
				$this->db->where('po.supplier_id', $supplier_id);
			}
			
			if ($date_from && $date_from != '') {
				$this->db->where('po.order_date >=', $date_from);
			}
			
			if ($date_to && $date_to != '') {
				$this->db->where('po.order_date <=', $date_to);
			}
			
			$pos = $this->db->get()->result();
			
			// Get item counts for each PO
			foreach ($pos as $po) {
				$items = $this->db->select('id, product_id, quantity, unit_price')
								  ->where('po_id', $po->id)
								  ->get('purchase_order_items')
								  ->result();
				
				$po->items = $items;
				$po->total_amount = 0;
				$po->item_count = count($items);
				
				foreach ($items as $item) {
					$po->total_amount += ($item->quantity * $item->unit_price);
				}
			}
			
			return $pos;
			
		} catch (Exception $e) {
			error_log("Exception in getPurchaseOrdersData: " . $e->getMessage());
			return [];
		}
	}

	public function getPurchaseOrder($po_id)
{
    $id = intval($po_id);
    
    // Get PO header
    $po = $this->db->where('id', $id)->get('purchase_orders')->row();
    
    if (!$po) {
        error_log("PO not found for ID: " . $id);
        return false;
    }
    
    // Get supplier name
    $supplier = $this->db->where('id', $po->supplier_id)->get('supply')->row();
    $po->supplier_name = $supplier ? $supplier->name : 'Unknown';
    
    // Get items
    $items = $this->db->where('po_id', $id)->get('purchase_order_items')->result();
    
    // Add product details to items - INCLUDING tracking flags
    foreach ($items as $item) {
        $product = $this->db->select('id, name, product_code, is_expiry_trk, is_serial_trk')
                           ->where('id', $item->product_id)
                           ->get('products')
                           ->row();
        
        $item->product_name = $product ? $product->name : 'Unknown';
        $item->product_code = $product ? $product->product_code : '';
        $item->is_expiry_trk = $product ? (bool)$product->is_expiry_trk : false;
        $item->is_serial_trk = $product ? (bool)$product->is_serial_trk : false;
        
        $unit = $this->db->where('unit_id', $item->unit_id)->get('units')->row();
        $item->unit_name = $unit ? $unit->unit_name : 'pcs';
        
        $item->received_quantity = 0;
        $item->pending_quantity = $item->quantity;
    }
    
    $po->items = $items;
    return $po;
}
	  
	/* -----------------------------------------------------------
	   GET DRAFT GRN FOR CURRENT USER (WITH ATTACHMENTS)
	----------------------------------------------------------- */
	public function getDraftGRN()
{
    $user_id = $this->session->userdata('user_id');
    
    // Get the latest draft OR new GRN for this user (not submitted/approved/rejected)
    $draft = $this->db->where('created_by', $user_id)
                      ->where('branch_id', $branch_id)
                      ->where('status','new')  // Include both 'draft' and 'new'
                      ->order_by('id', 'DESC')
                      ->limit(1)
                      ->get('grn')
                      ->row();
    
    if (!$draft) {
        return null;
    }
    
    // Get items for this GRN
    $items = $this->db->where('grn_id', $draft->id)
                      ->get('grn_items')
                      ->result();
    
    $draft->items = $items;
    
    // Get attachments for this GRN
    $attachments = $this->db->where('grn_id', $draft->id)
                           ->order_by('uploaded_at', 'DESC')
                           ->get('grn_attachments')
                           ->result();
    
    $draft->attachments = $attachments;
    
    // Make sure received_by is included
    $draft->received_by = $draft->received_by ?? null;
    $draft->ref_invoice_no = $draft->ref_invoice_no ?? null;
    
    return $draft;
}
		
public function submitForApproval($grn_id)
{
    // Verify GRN belongs to current branch
    if (!$this->verifyBranch('grn', $grn_id)) {
        error_log("Cannot submit GRN from different branch: $grn_id");
        return false;
    }
    error_log("=== SUBMIT FOR APPROVAL CALLED for GRN ID: $grn_id ===");
    
    $this->db->trans_start();
    
    $grn = $this->db->where('id', $grn_id)->get('grn')->row();
    
    if (!$grn) {
        error_log("GRN not found with ID: $grn_id");
        $this->db->trans_rollback();
        return false;
    }
    
    // Only draft or new can be submitted
    if ($grn->status != 'draft' && $grn->status != 'new') {
        error_log("Cannot submit GRN in status: {$grn->status}");
        $this->db->trans_rollback();
        return false;
    }
    
    // Update GRN status to submitted
    $update_data = [
        'status' => 'submitted',
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $this->db->where('id', $grn_id)->update('grn', $update_data);
    
    // Log approval
    $this->logApproval($grn_id, 'submitted');
    
    // ADD THIS: Create supplier invoice upon submission
    $invoice_id = $this->createSupplierInvoiceFromGRN($grn_id);
    
    if (!$invoice_id) {
        error_log("WARNING: Failed to create supplier invoice for GRN: $grn_id");
        // Don't rollback - GRN submission can still proceed even if invoice creation fails
        // But log the error
    }
    
    $this->db->trans_complete();
    
    if ($this->db->trans_status()) {
        error_log("GRN $grn_id submitted successfully" . ($invoice_id ? " with invoice ID: $invoice_id" : ""));
        return true;
    } else {
        error_log("Transaction failed for GRN submission");
        return false;
    }
}
	/* -----------------------------------------------------------
	   GET DEFAULT APPROVER
	----------------------------------------------------------- */
	private function getDefaultApprover()
	{
		// Find an owner (admin) user
		$approver = $this->db->select('user_id')
							 ->where('owner', 1)
							 ->where('status', '1')
							 ->limit(1)
							 ->get('user')
							 ->row();
		
		if ($approver) {
			return $approver->user_id;
		}
		
		// Fallback: get any active user
		$anyUser = $this->db->select('user_id')
							->where('status', '1')
							->limit(1)
							->get('user')
							->row();
		
		return $anyUser ? $anyUser->user_id : null;
	}

	/* -----------------------------------------------------------
	   GET ATTACHMENTS FOR GRN
	----------------------------------------------------------- */
	public function getAttachments($grn_id)
	{
		return $this->db->where('grn_id', $grn_id)
						->order_by('uploaded_at', 'DESC')
						->get('grn_attachments')
						->result();
	}

	/* -----------------------------------------------------------
	   GET SINGLE ATTACHMENT
	----------------------------------------------------------- */
	public function getAttachment($attachment_id)
	{
		return $this->db->where('id', $attachment_id)
						->get('grn_attachments')
						->row();
	}
	/* -----------------------------------------------------------
	   GET GRN SUMMARY (For Right Sidebar)
	----------------------------------------------------------- */
public function getGRNSummary($grn_id)
{
    $this->filterByBranch(); 
    $grn = $this->db->where('id', $grn_id)->get('grn')->row();
    
    if (!$grn) return null;
    
    // Get items count and total quantity
    $items = $this->db->select('COUNT(*) as item_count, SUM(quantity + free_quantity) as total_qty')
        ->where('grn_id', $grn_id)
        ->get('grn_items')
        ->row();
    
    // Get supplier name
    $supplier = $this->db->select('name')
        ->where('id', $grn->supplier_id)
        ->get('supply')
        ->row();
    
    // Get created by user name - FIX: Use staff_info instead of user
    $created_by = $this->db->select('full_name')
        ->where('staff_id', $grn->created_by)
        ->get('staff_info')
        ->row();
    
    // Get warehouse name
    $warehouse = $this->db->select('store_name')
        ->where('store_id', $grn->warehouse_id)
        ->get('stores')
        ->row();
    
    return [
        'grn_number' => $grn->grn_number,
        'ref_invoice_no' => $grn->ref_invoice_no ?? null, 
        'status' => $grn->status,
        'created_by' => $created_by ? $created_by->full_name : 'Unknown',
        'created_on' => date('d M Y', strtotime($grn->created_at)),
        'supplier_name' => $supplier ? $supplier->name : 'Unknown',
        'warehouse_name' => $warehouse ? $warehouse->store_name : 'Unknown',
        'total_items' => $items->item_count ? (int)$items->item_count : 0,
        'total_qty' => $items->total_qty ? (float)$items->total_qty : 0,
        'grand_total' => (float)$grn->grand_total
    ];
}

	/* -----------------------------------------------------------
	   GET GRN HISTORY (Audit Log)
	----------------------------------------------------------- */
	/* -----------------------------------------------------------
	   GET GRN HISTORY (Audit Log)
	----------------------------------------------------------- */
	public function getGRNHistory($grn_id)
{
    $this->filterByBranch();
		// Get approval history
		$approvals = $this->db->select('ga.*, u.full_name as user_name')
			->from('grn_approvals ga')
			->join('user u', 'u.user_id = ga.action_by', 'left')
			->where('ga.grn_id', $grn_id)
			->order_by('ga.id', 'ASC')
			->get()
			->result();
		
		// Format history items
		$history = [];
		foreach ($approvals as $approval) {
			$action = $approval->action;
			$icon = 'ri-information-line';
			$color = 'secondary';
			
			switch ($action) {
				case 'created':
					$icon = 'ri-add-circle-line';
					$color = 'primary';
					$text = 'GRN was created';
					break;
				case 'edited':
					$icon = 'ri-edit-line';
					$color = 'info';
					$text = 'GRN was edited';
					break;
				case 'submitted':
					$icon = 'ri-send-plane-line';
					$color = 'warning';
					$text = 'Submitted for approval';
					break;
				case 'approved':
					$icon = 'ri-checkbox-circle-line';
					$color = 'success';
					$text = 'GRN was approved';
					break;
				case 'rejected':
					$icon = 'ri-close-circle-line';
					$color = 'danger';
					$text = 'GRN was rejected';
					break;
				default:
					$text = ucfirst($action);
			}
			
			// Handle date safely - use action_date column
			$action_date = 'Unknown date';
			if (isset($approval->action_date) && !empty($approval->action_date)) {
				$action_date = date('d M Y H:i:s', strtotime($approval->action_date));
			}
			
			$history[] = [
				'id' => $approval->id,
				'action' => $action,
				'action_text' => $text,
				'action_by' => isset($approval->user_name) ? $approval->user_name : 'System',
				'action_date' => $action_date,
				'note' => isset($approval->action_note) ? $approval->action_note : null,
				'icon' => $icon,
				'color' => $color
			];
		}
		
		return $history;
	}
	/* -----------------------------------------------------------
	   DELETE ATTACHMENT
	----------------------------------------------------------- */
	public function deleteAttachment($attachment_id)
	{
		// Get attachment info first
		$attachment = $this->getAttachment($attachment_id);
		
		if (!$attachment) {
			return false;
		}
		
		// Delete file from server
		$file_path = FCPATH . $attachment->file_path;
		if (file_exists($file_path)) {
			unlink($file_path);
		}
		
		// Delete from database
		$this->db->where('id', $attachment_id)->delete('grn_attachments');
		
		return $this->db->affected_rows() > 0;
	}
	/* -----------------------------------------------------------
	   GET SUPPLIER SUMMARY FROM INVOICES (SIMPLIFIED)
	----------------------------------------------------------- */
	public function getSupplierSummary($supplier_id)
	{
		if (!$supplier_id) return false;
		
		// Get supplier details - only basic info
		$supplier = $this->db->select('id, name, phone, email')
			->where('id', $supplier_id)
			->get('supply')
			->row();
		
		if (!$supplier) {
			error_log("Supplier not found for ID: " . $supplier_id);
			return false;
		}
		
		// 1. Get last invoice for this supplier
		$last_invoice = $this->db->select('invoice_number, created_at, grand_total, status')
			->from('supplier_invoices')
			->where('supplier_id', $supplier_id)
			->where('status !=', 'cancelled')
			->order_by('created_at', 'DESC')
			->order_by('id', 'DESC')
			->limit(1)
			->get()
			->row();
		
		$last_invoice_date = $last_invoice && $last_invoice->created_at ? date('d M Y', strtotime($last_invoice->created_at)) : 'No records';
		$last_invoice_amount = $last_invoice && $last_invoice->grand_total ? (float)$last_invoice->grand_total : 0;
		$last_invoice_number = $last_invoice && $last_invoice->invoice_number ? $last_invoice->invoice_number : 'N/A';
		$last_invoice_status = $last_invoice && $last_invoice->status ? $last_invoice->status : 'N/A';
		
		// 2. Get total purchases (all invoices except cancelled)
		$total_purchases = $this->db->select('COALESCE(SUM(grand_total), 0) as total')
			->from('supplier_invoices')
			->where('supplier_id', $supplier_id)
			->where('status !=', 'cancelled')
			->get()
			->row();
		$total_purchased = (float)$total_purchases->total;
		
		// 3. Get outstanding balance directly from invoices
		$outstanding_result = $this->db->select('COALESCE(SUM(balance_amount), 0) as total_outstanding')
			->from('supplier_invoices')
			->where('supplier_id', $supplier_id)
			->where('status !=', 'paid')
			->where('status !=', 'cancelled')
			->where('balance_amount >', 0)
			->get()
			->row();
		$outstanding_balance = (float)$outstanding_result->total_outstanding;
		
		// 4. Get invoice statistics
		$total_invoices = $this->db->where('supplier_id', $supplier_id)
			->where('status !=', 'cancelled')
			->count_all_results('supplier_invoices');
		
		// 5. Get unpaid invoices count
		$unpaid_invoices = $this->db->where('supplier_id', $supplier_id)
			->where_in('status', ['unpaid', 'partial'])
			->count_all_results('supplier_invoices');
		
		// 6. Get overdue invoices
		$today = date('Y-m-d');
		$overdue_invoices = $this->db->select('COALESCE(SUM(balance_amount), 0) as overdue_total')
			->from('supplier_invoices')
			->where('supplier_id', $supplier_id)
			->where('due_date <', $today)
			->where('status !=', 'paid')
			->where('status !=', 'cancelled')
			->where('balance_amount >', 0)
			->get()
			->row();
		$overdue_amount = (float)$overdue_invoices->overdue_total;
		
		return [
			'supplier_id' => $supplier->id,
			'supplier_name' => $supplier->name,
			'supplier_phone' => $supplier->phone ?? 'N/A',
			'supplier_email' => $supplier->email ?? 'N/A',
			'tax_number' => 'N/A',
			
			// Last invoice info
			'last_invoice_date' => $last_invoice_date,
			'last_invoice_amount' => $last_invoice_amount,
			'last_invoice_number' => $last_invoice_number,
			'last_invoice_status' => $last_invoice_status,
			
			// Financial summary
			'total_purchased' => $total_purchased,
			'total_payments' => $total_purchased - $outstanding_balance,
			'outstanding_balance' => $outstanding_balance,
			
			// Invoice statistics
			'total_invoices' => $total_invoices,
			'unpaid_invoices' => $unpaid_invoices,
			'month_purchases' => 0, // Optional, can calculate if needed
			'overdue_amount' => $overdue_amount,
			
			// Credit info (simplified)
			'credit_limit' => 0,
			'payment_terms' => 'Net 30',
			'credit_used_percentage' => 0,
			'available_credit' => 0
		];
	}
	
	public function getDraftGRNById($grn_id)
{
    $this->filterByBranch();
    
    // Select all GRN fields including received_by
    $this->db->select('grn.*');
    $this->db->from('grn');
    $this->db->where('grn.id', $grn_id);
    $grn = $this->db->get()->row();
    
    if (!$grn) {
        return null;
    }
    
    // Get items for this GRN
    $items = $this->db->where('grn_id', $grn->id)
                      ->get('grn_items')
                      ->result();
    
    // Decode serials data for each item
    foreach ($items as $item) {
        if ($item->has_serials && !empty($item->serials_data)) {
            $item->serials = json_decode($item->serials_data, true);
        }
    }
    
    $grn->items = $items;
    
    // Get attachments
    $attachments = $this->db->where('grn_id', $grn->id)
                           ->order_by('uploaded_at', 'DESC')
                           ->get('grn_attachments')
                           ->result();
    
    $grn->attachments = $attachments;
    
    // Force cast received_by to string/number properly
    $grn->received_by = $grn->received_by ? (int)$grn->received_by : null;
    
    return $grn;
}
/* -----------------------------------------------------------
   INSERT BATCH - Creates or updates batch record for GRN items
----------------------------------------------------------- */
/* -----------------------------------------------------------
   INSERT BATCH - Creates or updates batch record for GRN items
----------------------------------------------------------- */
private function insertBatch($item, $warehouse_id, $is_auto_batch = 0)
{
    $total_qty = $item->quantity + $item->free_quantity;
	$branch_id = $this->getCurrentBranchId();
    
    // FIX FOR AUTO-BATCH: For auto-batch products, we need to find existing auto-batches
    // for the same product, NOT using the batch number (since it changes per GRN)
    $existing_batch = null;
    
    // Debug log
    error_log("=== insertBatch called ===");
    error_log("Product ID: {$item->product_id}");
    error_log("is_auto_batch: $is_auto_batch");
    error_log("batch_number from item: " . ($item->batch_number ?? 'NULL'));
    error_log("Warehouse ID: $warehouse_id");
    
     if ($is_auto_batch == 1) {
        $existing_batch = $this->db->select('id, qty, avg_cost')
                                   ->where('product_id', $item->product_id)
                                   ->where('warehouse_id', $warehouse_id)
                                   ->where('branch_id', $branch_id) 
                                   ->where('is_auto_batch', 1)
                                   ->order_by('id', 'DESC')
                                   ->limit(1)
                                   ->get('product_batches')
                                   ->row();
        
        if ($existing_batch) {
            error_log("Found existing AUTO-BATCH for product {$item->product_id}, batch_id: {$existing_batch->id}");
        } else {
            error_log("No existing auto-batch found, will create new one");
        }
    } else {
        // For manual batch products: Check by exact batch number
        if (!empty($item->batch_number)) {
            $existing_batch = $this->db->select('id, qty, avg_cost')
                                       ->where('product_id', $item->product_id)
                                       ->where('warehouse_id', $warehouse_id)
                                       ->where('branch_id', $branch_id)
                                       ->where('batch_no', $item->batch_number)
                                       ->get('product_batches')
                                       ->row();
            
            if ($existing_batch) {
                error_log("Found existing manual batch: {$item->batch_number}, batch_id: {$existing_batch->id}");
            }
        }
    }
    
    if ($existing_batch) {
        // Batch exists - update quantity and average cost
        $new_qty = $existing_batch->qty + $total_qty;
        
        // Calculate weighted average cost
        $total_old_cost = $existing_batch->qty * ($existing_batch->avg_cost ?? $item->unit_price);
        $total_new_cost = $total_qty * $item->unit_price;
        $new_avg_cost = ($total_old_cost + $total_new_cost) / $new_qty;
        
        $this->db->where('id', $existing_batch->id)
                 ->update('product_batches', [
                     'qty' => $new_qty,
                     'avg_cost' => round($new_avg_cost, 4),
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
        
        error_log("UPDATING batch ID {$existing_batch->id}: Old Qty={$existing_batch->qty}, Adding={$total_qty}, New Qty={$new_qty}");
        
        return [
            'batch_id' => $existing_batch->id,
            'action' => 'updated'
        ];
    } else {
        // Create new batch
        // For auto-batch, generate a batch number if empty
        $batch_no = $item->batch_number;
        if (empty($batch_no) && $is_auto_batch == 1) {
            // Generate a unique auto-batch number
            $grn = $this->db->select('grn_number')->where('id', $item->grn_id)->get('grn')->row();
            $grn_number = $grn ? $grn->grn_number : 'GRN-' . $item->grn_id;
            $batch_no = 'AUTO-' . $grn_number . '-P' . $item->product_id;
            error_log("Generated auto-batch number: $batch_no");
        }
        
         $batch_data = [
        'product_id' => $item->product_id,
        'warehouse_id' => $warehouse_id,
        'branch_id' => $branch_id,
            'batch_no' => $batch_no,
            'expiry_date' => $item->expiry_date ?? null,
            'qty' => $total_qty,
            'avg_cost' => $item->unit_price,
            'is_auto_batch' => $is_auto_batch,
            'grn_item_id' => $item->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('product_batches', $batch_data);
        $batch_id = $this->db->insert_id();
        
        error_log("CREATING new batch ID=$batch_id, Batch No=$batch_no, is_auto_batch=$is_auto_batch, Qty=$total_qty");
        
        return [
            'batch_id' => $batch_id,
            'action' => 'created'
        ];
    }
}

	public function get_grn_counts()
{
    $branch_id = $this->getCurrentBranchId(); // ADD THIS LINE
    
    $total = $this->db->where('branch_id', $branch_id)->count_all_results('grn');  // ADD BRANCH FILTER
    
    $settled = $this->db->where('status', 'approved')
                        ->where('branch_id', $branch_id)  // ADD BRANCH FILTER
                        ->count_all_results('grn');
    
    $this->db->where('status !=', 'approved')
             ->where('status !=', 'rejected')
             ->where('status !=', 'cancelled')
             ->where('branch_id', $branch_id);  // ADD BRANCH FILTER
    $outstanding = $this->db->count_all_results('grn');

    return [
        ['name'=>'Total','total'=>$total],
        ['name'=>'Approved','total'=>$settled],
        ['name'=>'Outstanding','total'=>$outstanding]
    ];
}
/* -----------------------------------------------------------
   GET GRN PAYMENT HISTORY (FROM EXISTING TABLES)
----------------------------------------------------------- */
public function getGRNPayments($grn_id)
{
    // Get GRN to find linked supplier invoice
    $grn = $this->db->select('ref_invoice_no, supplier_id, grn_number')
        ->where('id', $grn_id)
        ->get('grn')
        ->row();
    
    if (!$grn) return [];
    
    $payments = [];
    
    // If GRN has a reference invoice number, get payments for that invoice
    if (!empty($grn->ref_invoice_no)) {
        // Try to find invoice by invoice_number or by ID
        $invoice = $this->db->select('id')
            ->where('invoice_number', $grn->ref_invoice_no)
            ->or_where('id', $grn->ref_invoice_no)
            ->get('supplier_invoices')
            ->row();
        
        if ($invoice) {
            $payments = $this->db->select('
                    sp.*,
                    spa.allocated_amount,
                    spa.invoice_id,
                    u.full_name as created_by_name
                ')
                ->from('supplier_payment_allocations spa')
                ->join('supplier_payments sp', 'sp.id = spa.payment_id')
                ->join('user u', 'u.user_id = sp.created_by', 'left')
                ->where('spa.invoice_id', $invoice->id)
                ->where('sp.status', 'active')
                ->order_by('sp.created_at', 'DESC')
                ->get()
                ->result();
        }
    }
    
    return $payments;
}

/* -----------------------------------------------------------
   GET GRN PAYMENT SUMMARY
----------------------------------------------------------- */
public function getGRNPaymentSummary($grn_id)
{
    $grn = $this->db->select('grand_total, paid_amount, status, ref_invoice_no, supplier_id, grn_number')
        ->where('id', $grn_id)
        ->get('grn')
        ->row();
    
    if (!$grn) return null;
    
    // Calculate balance amount (since it might not be stored in grn table)
    $grand_total = (float)($grn->grand_total ?? 0);
    $paid_amount = (float)($grn->paid_amount ?? 0);
    $balance_amount = $grand_total - $paid_amount;
    if ($balance_amount < 0) $balance_amount = 0;
    
    $summary = [
        'grand_total' => $grand_total,
        'paid_amount' => $paid_amount,
        'balance_amount' => $balance_amount,
        'status' => $grn->status ?? 'draft',
        'payment_count' => 0,
        'invoice_linked' => !empty($grn->ref_invoice_no),
        'invoice_id' => null
    ];
    
    // Get payment count from linked invoice if exists
    if (!empty($grn->ref_invoice_no)) {
        // Try to find invoice by ID or invoice_number
        $invoice = $this->db->select('id')
            ->group_start()
                ->where('id', $grn->ref_invoice_no)
                ->or_where('invoice_number', $grn->ref_invoice_no)
            ->group_end()
            ->get('supplier_invoices')
            ->row();
        
        if ($invoice) {
            $payment_count = $this->db->select('COUNT(DISTINCT sp.id) as count')
                ->from('supplier_payment_allocations spa')
                ->join('supplier_payments sp', 'sp.id = spa.payment_id')
                ->where('spa.invoice_id', $invoice->id)
                ->where('sp.status', 'active')
                ->get()
                ->row();
            
            $summary['payment_count'] = (int)($payment_count->count ?? 0);
            $summary['invoice_id'] = $invoice->id;
        }
    }
    
    return $summary;
}

/* -----------------------------------------------------------
   RECORD PAYMENT AGAINST GRN (ONLY AFTER APPROVAL)
----------------------------------------------------------- */
public function recordPayment($grn_id, $payment_data)
{
    $this->db->trans_start();
    
    // 1. Get current GRN details
    $grn = $this->db->select('grand_total, paid_amount, balance_amount, status, ref_invoice_no, supplier_id, grn_number, branch_id')
        ->where('id', $grn_id)
        ->get('grn')
        ->row();
    
    if (!$grn) {
        $this->db->trans_rollback();
        return ['status' => false, 'message' => 'GRN not found'];
    }
    
    // IMPORTANT: Only allow payments on APPROVED GRNs
    if ($grn->status !== 'approved') {
        $this->db->trans_rollback();
        return ['status' => false, 'message' => 'Payments can only be recorded for approved GRNs. Current status: ' . $grn->status];
    }
    
    $amount = (float)$payment_data['amount'];
    $new_paid = (float)$grn->paid_amount + $amount;
    $new_balance = (float)$grn->grand_total - $new_paid;
    
    if ($new_balance < 0) {
        $this->db->trans_rollback();
        return ['status' => false, 'message' => 'Payment amount exceeds balance due'];
    }
    
    // Determine new status for GRN
    if ($new_balance <= 0) {
        $new_status = 'paid';
        $action = 'paid';
    } else if ($new_paid > 0) {
        $new_status = 'partial';
        $action = 'partial_paid';
    } else {
        $new_status = $grn->status;
        $action = 'payment_recorded';
    }
    
    // Get branch_id from GRN
    $branch_id = $grn->branch_id ?? $this->getCurrentBranchId();
    
    // 2. Insert into supplier_payments table - FIXED
    $payment_record = [
        'supplier_id' => $grn->supplier_id,
        'branch_id' => $branch_id,  // Add branch_id
        'payment_date' => $payment_data['payment_date'],
        'payment_method' => $payment_data['payment_method'],
        'account_id' => $payment_data['account_id'] ?? null,
        'amount' => $amount,
        'reference_no' => $payment_data['reference_no'] ?? null,
        'cheque_no' => $payment_data['cheque_no'] ?? null,
        'cheque_date' => $payment_data['cheque_date'] ?? null,
        'bank_name' => $payment_data['bank_name'] ?? null,
        'note' => $payment_data['note'] ?? "Payment for GRN #{$grn->grn_number}",
        'status' => 'active',
        'created_by' => $this->session->userdata('user_id'),
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $this->db->insert('supplier_payments', $payment_record);
    $payment_id = $this->db->insert_id();
    
    // Log the insert
    error_log("Payment inserted into supplier_payments. ID: $payment_id, Branch ID: $branch_id");
    
    // 3. Handle invoice allocation if GRN has reference invoice
    $invoice_id = null;
    if (!empty($grn->ref_invoice_no)) {
        // Find the supplier invoice
        $invoice = $this->db->select('id, grand_total, paid_amount, balance_amount, status')
            ->where('invoice_number', $grn->ref_invoice_no)
            ->or_where('id', $grn->ref_invoice_no)
            ->get('supplier_invoices')
            ->row();
        
        if ($invoice) {
            $invoice_id = $invoice->id;
            
            // Insert into supplier_payment_allocations (no branch_id needed)
            $this->db->insert('supplier_payment_allocations', [
                'payment_id' => $payment_id,
                'invoice_id' => $invoice_id,
                'allocated_amount' => $amount,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            // Update invoice paid amounts
            $new_invoice_paid = (float)$invoice->paid_amount + $amount;
            $new_invoice_balance = (float)$invoice->grand_total - $new_invoice_paid;
            
            $invoice_status = $new_invoice_balance <= 0 ? 'paid' : ($new_invoice_paid > 0 ? 'partial' : $invoice->status);
            
            $this->db->where('id', $invoice_id)
                ->update('supplier_invoices', [
                    'paid_amount' => $new_invoice_paid,
                    'balance_amount' => $new_invoice_balance,
                    'status' => $invoice_status,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            
            // Log to supplier_invoice_history
            $this->db->insert('supplier_invoice_history', [
                'invoice_id' => $invoice_id,
                'action' => $invoice_status == 'paid' ? 'paid' : 'partial_paid',
                'action_by' => $this->session->userdata('user_id'),
                'note' => "Payment from GRN #{$grn->grn_number}: " . number_format($amount, 2),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    // 4. Update GRN with new payment totals
    $this->db->where('id', $grn_id)
        ->update('grn', [
            'paid_amount' => $new_paid,
            'balance_amount' => $new_balance,
            'status' => $new_status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    
    // 5. Log the payment action in GRN history
    $this->db->insert('grn_approvals', [
        'grn_id' => $grn_id,
        'action' => $action,
        'action_by' => $this->session->userdata('user_id'),
        'action_note' => "Payment of " . number_format($amount, 2) . " recorded. New balance: " . number_format($new_balance, 2),
        'action_date' => date('Y-m-d H:i:s')
    ]);
    
    $this->db->trans_complete();
    
    // Activity log
    $user_id_fk = $this->session->userdata('user_id');
    $user_type = $this->session->userdata('ut_id');
    $this->Activity_log_m->addLog($user_id_fk, $user_type, 'GRN Module', 'Record Payment', 'INSERT');
    
    if ($this->db->trans_status()) {
        error_log("Payment recorded successfully for GRN: $grn_id");
        return ['status' => true, 'payment_id' => $payment_id, 'message' => 'Payment recorded successfully'];
    } else {
        error_log("Failed to record payment for GRN: $grn_id");
        return ['status' => false, 'message' => 'Failed to record payment'];
    }
}
/**
 * Create supplier invoice from approved GRN
 * Called only when GRN status changes to 'submitted' or 'approved'
 */
public function createSupplierInvoiceFromGRN($grn_id)
{
    // Get GRN details
    $grn = $this->db->where('id', $grn_id)->get('grn')->row();
    
    if (!$grn) {
        error_log("GRN not found for invoice creation: $grn_id");
        return false;
    }
    
    // Get branch_id from GRN or session
    $branch_id = $grn->branch_id ?? $this->getCurrentBranchId();
    
    // ===== CHECK IF INVOICE ALREADY EXISTS =====
    $existing = $this->db->where('reference_id', $grn_id)
                         ->where('source_type', 'grn')
                         ->get('supplier_invoices')
                         ->row();
    
    if ($existing) {
        error_log("Invoice already exists for GRN: $grn_id, Invoice ID: {$existing->id}");
        return $existing->id;
    }
    
    // Get GRN items
    $items = $this->db->where('grn_id', $grn_id)->get('grn_items')->result();
    
    if (empty($items)) {
        error_log("No items found for GRN: $grn_id");
        return false;
    }
    
    // Calculate invoice amounts
    $subtotal = (float)$grn->subtotal;
    $discount_value = (float)$grn->discount_value;
    $discount_type = $grn->discount_type;
    $tax_total = (float)$grn->tax_total;
    $grand_total = (float)$grn->grand_total;
    $paid_amount = (float)$grn->paid_amount;
    
    $balance_amount = $grand_total - $paid_amount;
    if ($balance_amount < 0) $balance_amount = 0;
    
    $invoice_status = $balance_amount <= 0 ? 'paid' : ($paid_amount > 0 ? 'partial' : 'unpaid');
    
    // ===== DETERMINE INVOICE NUMBER =====
    $invoice_number = null;
    
    // 1. Check if user entered a reference number
    if (!empty($grn->ref_invoice_no)) {
        // Use the user's reference number as invoice number
        $invoice_number = $grn->ref_invoice_no;
        error_log("Using user's reference number: " . $invoice_number);
        
        // Check if this invoice number already exists
        $exists = $this->db->where('invoice_number', $invoice_number)
                           ->get('supplier_invoices')
                           ->num_rows();
        
        if ($exists > 0) {
            // If exists, append a suffix
            $invoice_number = $grn->ref_invoice_no . '-' . date('Ymd');
            error_log("Invoice number already exists, using: " . $invoice_number);
        }
    }
    
    // 2. If no user reference or it already exists, auto-generate
    if (empty($invoice_number)) {
        $year = date('Y');
        $last_invoice = $this->db->select('invoice_number')
                                 ->like('invoice_number', 'INV-' . $year . '-', 'after')
                                 ->order_by('id', 'DESC')
                                 ->limit(1)
                                 ->get('supplier_invoices')
                                 ->row();
        
        if ($last_invoice && $last_invoice->invoice_number) {
            $parts = explode('-', $last_invoice->invoice_number);
            $last_number = intval(end($parts));
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        
        $invoice_number = 'INV-' . $year . '-' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
        error_log("Auto-generated invoice number: " . $invoice_number);
    }
    
    // Insert supplier invoice
    $invoice_data = [
        'invoice_number' => $invoice_number,
        'supplier_id' => $grn->supplier_id,
        'branch_id' => $branch_id,
        'source_type' => 'grn',
        'reference_id' => $grn_id,
        'reference_number' => $grn->grn_number,
        'invoice_date' => $grn->grn_date,
        'due_date' => date('Y-m-d', strtotime('+30 days', strtotime($grn->grn_date))),
        'subtotal' => $subtotal,
        'discount_value' => $discount_value,
        'discount_type' => $discount_type,
        'tax_total' => $tax_total,
        'grand_total' => $grand_total,
        'paid_amount' => $paid_amount,
        'balance_amount' => $balance_amount,
        'status' => $invoice_status,
        'remarks' => 'Auto-generated from GRN #' . $grn->grn_number,
        'created_by' => $this->session->userdata('user_id'),
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $this->db->insert('supplier_invoices', $invoice_data);
    $invoice_id = $this->db->insert_id();
    
    if (!$invoice_id) {
        error_log("Failed to create supplier invoice for GRN: $grn_id");
        return false;
    }
    
    // Insert invoice items
    foreach ($items as $item) {
        $line_total = (float)$item->quantity * (float)$item->unit_price;
        $discount_amount = 0;
        
        if ($item->discount_value > 0) {
            if ($item->discount_type == 'percent') {
                $discount_amount = $line_total * ((float)$item->discount_value / 100);
            } else {
                $discount_amount = min((float)$item->discount_value, $line_total);
            }
        }
        
        $line_total_after_discount = $line_total - $discount_amount;
        
        $invoice_item_data = [
            'invoice_id' => $invoice_id,
            'product_id' => $item->product_id,
            'unit_id' => $item->unit_id,
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
            'discount_value' => $item->discount_value,
            'discount_type' => $item->discount_type,
            'tax_value' => $item->tax_value,
            'line_total' => $line_total_after_discount,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('supplier_invoice_items', $invoice_item_data);
    }
    
    // ===== IMPORTANT: DON'T OVERWRITE USER'S REFERENCE =====
    // Only update ref_type, keep user's ref_invoice_no
    $this->db->where('id', $grn_id)
             ->update('grn', [
                 'ref_type' => 'GRN',
                 'updated_at' => date('Y-m-d H:i:s')
             ]);
    
    // Log invoice creation
    $this->db->insert('supplier_invoice_history', [
        'invoice_id' => $invoice_id,
        'action' => 'created',
        'action_by' => $this->session->userdata('user_id'),
        'note' => 'Invoice auto-generated from GRN #' . $grn->grn_number,
        'created_at' => date('Y-m-d H:i:s')
    ]);
    
    error_log("Supplier invoice created for GRN $grn_id, Invoice ID: $invoice_id, Number: $invoice_number");
    
    return $invoice_id;
}
} 