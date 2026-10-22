<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'traits/BranchTrait.php';
class Stock_transaction_model extends CI_Model {
use BranchTrait;
    // ============================================================
    // VALIDATION
    // ============================================================
    
    public function validate_transaction($payload) {
        $errors = [];
        $mode = $payload['transaction_mode'] ?? '';

        // Common validations
        if (empty($payload['store_id'])) {
            $errors[] = 'Source warehouse is required';
        }

        if (empty($payload['items'])) {
            $errors[] = 'At least one item is required';
        }

        // Mode-specific validations
        if ($mode === 'issue') {
            if (empty($payload['customer_id'])) {
                $errors[] = 'Customer is required for stock issue';
            }
        }

        if ($mode === 'transfer') {
            if (empty($payload['to_store_id'])) {
                $errors[] = 'Destination warehouse is required for transfer';
            }
            if (!empty($payload['store_id']) && !empty($payload['to_store_id']) && 
                $payload['store_id'] == $payload['to_store_id']) {
                $errors[] = 'Source and destination warehouses must be different';
            }
        }

        return $errors;
    }

    // ============================================================
    // SAVE TRANSACTION (INSERT)
    // ============================================================
    
	public function save_transaction($payload) {
		$mode = $payload['transaction_mode'];
		
		if($mode === 'pro_issue'){
			$mode ='issue';
		}
		
		$total_qty = 0;
		foreach ($payload['items'] as $item) {
			$total_qty += floatval($item['qty']);
		}

		$headerData = [
			'act_type'    => $mode,
			'st_act_date' => date('Y-m-d H:i:s'),
			'delivery_date' => $payload['deli'], 
			'store_id'    => $payload['store_id'],
			'to_store_id' => $payload['to_store_id'] ?? null,
			'cus_id'      => $payload['customer_id'] ?? null,
			'project_id'  => $payload['project_id'] ?? null,
			'qty'         => $total_qty,
			'note'        => $payload['remarks'] ?? null,
			'status'      => 'pending',
			'create_by'   => $this->session->userdata('user_id'),
			'branch_id'   => $this->session->userdata('branch')
		];

		try {
			$this->db->trans_start();

			// ✅ FIRST: Validate all items BEFORE inserting anything
			if ($mode === 'transfer' || $mode === 'issue' || $mode === 'pro_issue') {
				foreach ($payload['items'] as $item) {
					
					$product_id = $item['product_id'];
					$warehouse_id = $payload['store_id'];
					$batch_id = $item['batch_id'] ?? null;
					$qty = $item['qty'];
					
					// Get product info for validation
					$product = $this->db->select('is_batch, is_expiry_trk, is_serial_trk')
										->where('id', $product_id)
										->get('products')
										->row();
					
					if (!$product) {
						throw new Exception('Product not found: ' . $product_id);
					}
					
					// ✅ 1. STOCK CHECK
					$this->db->where('product_id', (int)$product_id);
					$this->db->where('warehouse_id', (int)$warehouse_id);
					if (!empty($batch_id)) {
						$this->db->where('batch_id', (int)$batch_id);
					}
					
					$stock = $this->db->get('inventory_stock')->row();
					
					if (!$stock) {
						throw new Exception('No stock found for product ID: ' . $product_id . ' in warehouse ' . $warehouse_id);
					}
					
					$available = (float)$stock->qty - (float)$stock->reserved_qty;
					if ($available < (float)$qty) {
						throw new Exception('Insufficient stock for product ID: ' . $product_id . '. Requested: ' . $qty . ', Available: ' . $available);
					}
					
					// ✅ 2. BATCH CHECK
					if ($product->is_batch == 1 || $product->is_expiry_trk == 1) {
						if (empty($batch_id)) {
							throw new Exception('Batch selection is required for batch-tracked product ID: ' . $product_id);
						}
						
						$batch = $this->db->where('id', $batch_id)
										  ->where('product_id', $product_id)
										  ->get('product_batches')
										  ->row();
						
						if (!$batch) {
							throw new Exception('Selected batch not found for product ID: ' . $product_id);
						}
						
						if ((float)$batch->qty < (float)$qty) {
							throw new Exception('Insufficient batch quantity. Batch: ' . $batch->batch_no . ', Available: ' . $batch->qty . ', Requested: ' . $qty);
						}
					}
					
					// ✅ 3. SERIAL CHECK - Validate count AND availability
					if ($product->is_serial_trk == 1) {
						$serials = $item['serials'] ?? [];
						
						if (empty($serials)) {
							throw new Exception('Serial numbers required for serial-tracked product ID: ' . $product_id);
						}
						
						if (count($serials) != (int)$qty) {
							throw new Exception('Serial count mismatch for product ID: ' . $product_id . '. Expected: ' . $qty . ', Got: ' . count($serials));
						}
						
						// ✅ VALIDATE EACH SERIAL IS AVAILABLE
						foreach ($serials as $serial_no) {
							$serial_no = trim($serial_no);
							if (empty($serial_no)) continue;
							
							// Check if serial exists
							$serial_exists = $this->db->where('serial_no', $serial_no)
													   ->where('product_id', $product_id)
													   ->get('product_serial_numbers')
													   ->row();
							
							if (!$serial_exists) {
								throw new Exception('Serial number "' . $serial_no . '" not found in system for product ID: ' . $product_id);
							}
							
							// Check if serial is AVAILABLE
							if ($serial_exists->status !== 'AVAILABLE') {
								throw new Exception('Serial number "' . $serial_no . '" is not available. Current status: ' . $serial_exists->status);
							}
							
							// Check if serial is in the correct warehouse
							if ($serial_exists->warehouse_id != $warehouse_id) {
								throw new Exception('Serial number "' . $serial_no . '" is not in the selected warehouse. It is in warehouse ID: ' . $serial_exists->warehouse_id);
							}
						}
					}
				}
			}

			// ✅ NOW insert the header and items (validation passed)
			$this->db->insert('stock_activities', $headerData);
			$activity_id = $this->db->insert_id();

			if (!$activity_id) {
				throw new Exception('Failed to create activity record');
			}

			$this->_save_items($activity_id, $mode, $payload['items']);
			
			// ✅ NOW reserve stock and serials
			if ($mode === 'transfer' || $mode === 'issue') {
				foreach ($payload['items'] as $item) {
					
					$product_id = $item['product_id'];
					$warehouse_id = $payload['store_id'];
					$batch_id = $item['batch_id'] ?? null;
					$qty = $item['qty'];
					
					// Reserve stock (transfer only)
					if ($mode === 'transfer') {
						$reserved = $this->_reserve_and_reduce_qty($product_id, $warehouse_id, $batch_id, $qty);
						if (!$reserved) {
							throw new Exception('Failed to reserve stock for product ID: ' . $product_id);
						}
					}
					
					// Reserve serials (both transfer and issue)
					if (!empty($item['serials'])) {
						$ref_type = $mode === 'transfer' ? 'transfer' : 'issue';
						$serials_reserved = $this->_reserve_serials(
							$product_id,
							$warehouse_id,
							$item['serials'],
							$ref_type,
							$activity_id
						);
						
						if (!$serials_reserved) {
							throw new Exception('Failed to reserve serials for product ID: ' . $product_id);
						}
					}
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Database transaction failed');
			}

			return [
				'success' => true,
				'data'    => ['activity_id' => $activity_id, 'status' => 'pending'],
				'message' => 'Transaction saved successfully.'
			];

		} catch (Exception $e) {
			$this->db->trans_rollback();
			log_message('error', 'Stock transaction save failed: ' . $e->getMessage());
			return ['success' => false, 'message' => $e->getMessage()];
		}
	}

	private function _reserve_and_reduce_qty($product_id, $warehouse_id, $batch_id, $qty)
	{
		$this->db->where('product_id', (int)$product_id);
		$this->db->where('warehouse_id', (int)$warehouse_id);

		if (!empty($batch_id)) {
			$this->db->where('batch_id', (int)$batch_id);
		}

		$stock = $this->db->get('inventory_stock')->row();

		if (!$stock) {
			return false;
		}

		// Check available stock (qty - reserved_qty)
		$available = (float)$stock->qty - (float)$stock->reserved_qty;
		if ($available < (float)$qty) {
			return false;
		}

		// Increase reserved_qty AND decrease actual qty
		$this->db->set('reserved_qty', 'reserved_qty + ' . (float)$qty, FALSE);
		$this->db->set('qty', 'GREATEST(qty - ' . (float)$qty . ', 0)', FALSE);
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $stock->id);
		$this->db->update('inventory_stock');

		return $this->db->affected_rows() > 0;
	}

		// ============================================================
		// UPDATE TRANSACTION
		// ============================================================
		
	public function update_transaction($id, $payload) {
		try {
			$current = $this->_get_activity($id);
			if (!$current) {
				throw new Exception('Transaction not found');
			}
			if ($current->status !== 'pending') {
				throw new Exception('Only pending transactions can be edited');
			}

			$mode = $payload['transaction_mode'] ?? $current->act_type;
			$total_qty = 0;
			foreach ($payload['items'] as $item) {
				$total_qty += floatval($item['qty']);
			}

			$this->db->trans_start();

			// Update header
			$headerData = [
				'store_id'    => $payload['store_id'] ?? $current->store_id,
				'to_store_id' => $payload['to_store_id'] ?? $current->to_store_id,
				'cus_id'      => $payload['customer_id'] ?? $current->cus_id,
				'qty'         => $total_qty,
				'note'        => $payload['remarks'] ?? $current->note
			];
			
			$this->db->where('st_activity_id', $id);
			$this->db->update('stock_activities', $headerData);

			// Delete old items from unified table
			$this->db->where('fk_st_activity_id', $id)->delete('stock_transaction_items');

			// Insert new items
			$this->_save_items($id, $mode, $payload['items']);

			$this->db->trans_complete();
			
			$user_id_fk = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('ut_id');
			$this->load->model('Activity_log_m');
			$this->Activity_log_m->addLog($user_id_fk, $user_type, 'Stock Transaction Module', 'Update Stock Transaction', 'UPDATE');

			return ['success' => true, 'message' => 'Transaction updated'];

		} catch (Exception $e) {
			$this->db->trans_rollback();
			return ['success' => false, 'message' => $e->getMessage()];
		}
	}
		/**
	 * Mark serial numbers as UNAVAILABLE when reserved
	 */
private function _reserve_serials($product_id, $warehouse_id, $serials, $ref_type, $ref_id)
{
    $branch_id = $this->getCurrentBranchId();
    if (empty($serials)) {
        log_message('info', "No serials to reserve for product {$product_id}");
        return true;
    }
    
    log_message('info', "Reserving " . count((array)$serials) . " serials for product {$product_id}: " . implode(',', (array)$serials));
    
    foreach ((array)$serials as $serial_no) {
        $serial_no = trim($serial_no);
         if (empty($serial_no)) continue;
        
        // Check if serial exists and is AVAILABLE - ADD BRANCH FILTER
        $exists = $this->db->where('serial_no', $serial_no)
                           ->where('product_id', $product_id)
                           ->where('branch_id', $branch_id)  // ADD BRANCH FILTER
                           ->get('product_serial_numbers')
                           ->row();
        
        
        
        if (!$exists) {
            log_message('error', "Serial {$serial_no} not found in database for product {$product_id}");
            // For return mode, serials might be new - skip validation
            if ($ref_type === 'return') {
                log_message('info', "Return mode - allowing new serial: {$serial_no}");
                continue;
            }
            return false;
        }
        
        if ($exists->status !== 'AVAILABLE') {
            log_message('error', "Serial {$serial_no} is not AVAILABLE (current status: {$exists->status})");
            return false;
        }
        
        // Mark as UNAVAILABLE with reference
        $this->db->where('id', $exists->id)
                 ->update('product_serial_numbers', [
                     'status' => 'UNAVAILABLE',
                     'ref_type' => $ref_type,
                     'ref_no' => $ref_id
                 ]);
                 
        log_message('info', "Serial {$serial_no} reserved successfully (AVAILABLE → UNAVAILABLE)");
    }
    
    return true;
}
	
		/**
	 * Mark serial numbers as TRANSFERRED (moving to another warehouse)
	 */
	private function _mark_serials_transferred($product_id, $warehouse_id, $serials, $ref_type, $ref_id, $new_warehouse_id = null)
{
    $branch_id = $this->getCurrentBranchId();
		if (empty($serials)) return;
		
		foreach ((array)$serials as $serial_no) {
			$serial_no = trim($serial_no);
			if (empty($serial_no)) continue;
			
			$update_data = [
				'status' => 'TRANSFERRED',  // Or 'SOLD' for issue
				'ref_type' => $ref_type,
				'ref_no' => $ref_id
			];
			
			// If transferring to new warehouse, update warehouse_id
			if ($new_warehouse_id) {
				$update_data['warehouse_id'] = $new_warehouse_id;
			}
			
			$this->db->where('serial_no', $serial_no)
					 ->where('product_id', $product_id)
					 ->where('branch_id', $branch_id)
					 ->update('product_serial_numbers', $update_data);
		}
	}

	/**
	 * Mark serial numbers as SOLD/ISSUED
	 */
	private function _mark_serials_issued($product_id, $serials, $ref_type, $ref_id)
{
    $branch_id = $this->getCurrentBranchId();
		if (empty($serials)) return;
		
		foreach ((array)$serials as $serial_no) {
			$serial_no = trim($serial_no);
			if (empty($serial_no)) continue;
			
			$this->db->where('serial_no', $serial_no)
					 ->where('product_id', $product_id)
					 ->where('branch_id', $branch_id)
					 ->update('product_serial_numbers', [
						 'status' => 'SOLD',
						 'ref_type' => $ref_type,
						 'ref_no' => $ref_id
					 ]);
		}
	}
	
		/**
	 * Restore serial numbers to AVAILABLE on reject
	 */
	private function _restore_serials($product_id, $serials)
{
    $branch_id = $this->getCurrentBranchId();
		if (empty($serials)) return;
		
		foreach ((array)$serials as $serial_no) {
			$serial_no = trim($serial_no);
			if (empty($serial_no)) continue;
			
			$this->db->where('serial_no', $serial_no)
					 ->where('product_id', $product_id)
					 ->where('branch_id', $branch_id)
					 ->where('status', 'UNAVAILABLE')
					 ->update('product_serial_numbers', [
						 'status' => 'AVAILABLE',
						 'ref_type' => null,
						 'ref_no' => null
					 ]);
		}
	}
		/**
	 * Mark serial numbers as RETURNED and add to warehouse
	 */
	private function _mark_serials_returned($product_id, $warehouse_id, $serials, $ref_type, $ref_id, $batch_id = null)
	{
		$branch_id = $this->getCurrentBranchId();
		if (empty($serials)) return;
		
		foreach ((array)$serials as $serial_no) {
			$serial_no = trim($serial_no);
			if (empty($serial_no)) continue;
			
			// Check if serial already exists
			$exists = $this->db->where('serial_no', $serial_no)
							   ->where('product_id', $product_id)
							   ->where('branch_id', $branch_id)
							   ->get('product_serial_numbers')
							   ->row();
			
			if ($exists) {
				// Update existing serial
				$this->db->where('id', $exists->id)
						 ->update('product_serial_numbers', [
							 'status' => 'AVAILABLE',  // Make available again
							 'warehouse_id' => $warehouse_id,
							 'batch_id' => $batch_id,
							 'ref_type' => $ref_type,
							 'ref_no' => $ref_id
						 ]);
			} else {
				// Insert new serial for return
				$this->db->insert('product_serial_numbers', [
					'product_id' => $product_id,
					'warehouse_id' => $warehouse_id,
					'branch_id' => $branch_id,
					'serial_no' => $serial_no,
					'status' => 'AVAILABLE',
					'batch_id' => $batch_id,
					'ref_type' => $ref_type,
					'ref_no' => $ref_id,
					'created_at' => date('Y-m-d H:i:s')
				]);
			}
		}
	}
	/**
	 * FIFO Stock Deduction
	 *
	 * @param int    $product_id   Product ID
	 * @param int    $warehouse_id Warehouse ID
	 * @param int    $batch_id     Batch ID to deduct from
	 * @param float  $qty          Quantity to deduct
	 * @param string $ref_type     Reference type (e.g. 'SALE', 'TRANSFER_OUT')
	 * @param int    $ref_id       Reference ID (e.g. sale_id, transfer_id)
	 * @param int    $created_by   User ID performing the transaction
	 *
	 * @return array ['success' => bool, 'total_cost' => float|null, 'message' => string]
	 */
	public function deduct_stock_fifo($product_id, $warehouse_id, $batch_id, $qty, $ref_type, $ref_id, $created_by = null)
	{
		$this->db->trans_begin();

		try {
			// ============================================================
			// STEP 1: CHECK IF SUFFICIENT STOCK EXISTS IN inventory_stock
			// ============================================================
			
			$this->db->where('product_id', (int)$product_id);
			$this->db->where('warehouse_id', (int)$warehouse_id);
			
			if (!empty($batch_id)) {
				$this->db->where('batch_id', (int)$batch_id);
			}
			
			$stock = $this->db->get('inventory_stock')->row();
			
			if (!$stock) {
				$this->db->trans_rollback();
				return [
					'success'    => false,
					'total_cost' => null,
					'message'    => "No stock found for product ID {$product_id} in this warehouse.",
				];
			}
			
			// Check available quantity (actual qty - reserved qty)
			$available_qty = (float)$stock->qty - (float)$stock->reserved_qty;
			
			if ($available_qty < (float)$qty) {
				$this->db->trans_rollback();
				return [
					'success'    => false,
					'total_cost' => null,
					'message'    => "Insufficient stock. Requested: {$qty}, Available: {$available_qty}.",
				];
			}
			
			// ============================================================
			// STEP 2: GET UNIT COST
			// ============================================================
			
			$unit_cost = 0;

	// Try to get cost from batch first
	if (!empty($batch_id)) {
		$batch = $this->db->where('id', $batch_id)->get('product_batches')->row();
		if ($batch && !empty($batch->unit_cost)) {
			$unit_cost = (float)$batch->unit_cost;
		}
	}

	// If no cost from batch, get from product
	if ($unit_cost == 0) {
		// Use last_purchase_price as cost (correct column name)
		$product = $this->db->select('id, last_purchase_price, price')
							->where('id', $product_id)
							->get('products')
							->row();
		if ($product) {
			// Try last_purchase_price first, then fallback to price
			$unit_cost = (float)($product->last_purchase_price ?? $product->price ?? 0);
		}
	}
			
			// ============================================================
			// STEP 3: TRY FIFO FROM inventory_transactions
			// ============================================================
			
			// Get all positive transactions for this product/batch/warehouse (GRN receipts)
			$positive_transactions = $this->db->select('id, grn_id, qty, unit_cost, transaction_date')
											 ->where('product_id', $product_id)
											 ->where('warehouse_id', $warehouse_id)
											 ->where('batch_id', $batch_id)
											 ->where('qty >', 0)  // Only positive entries (receipts)
											 ->order_by('transaction_date', 'ASC')
											 ->order_by('id', 'ASC')
											 ->get('inventory_transactions')
											 ->result();
			
			// If we have positive transactions, use FIFO
			if (!empty($positive_transactions)) {
				
				$qty_remaining = (float)$qty;
				$total_cost = 0.0;
				$now = date('Y-m-d H:i:s');
				
				foreach ($positive_transactions as $transaction) {
					if ($qty_remaining <= 0) {
						break;
					}
					
					// Calculate how much is still available from this receipt
					// by subtracting all deductions made against it
					$deductions = $this->db->select_sum('qty')
										  ->where('grn_id', $transaction->id)
										  ->where('qty <', 0)
										  ->get('inventory_transactions')
										  ->row();
					
					$deducted_qty = abs((float)($deductions->qty ?? 0));
					$available_in_layer = (float)$transaction->qty - $deducted_qty;
					
					if ($available_in_layer <= 0) {
						continue;  // This layer is fully consumed
					}
					
					$deduct_qty = min($available_in_layer, $qty_remaining);
					$layer_unit_cost = (float)($transaction->unit_cost ?? $unit_cost);
					$line_cost = round($deduct_qty * $layer_unit_cost, 4);
					
					// Insert deduction record
					$insert_data = [
						'product_id'       => $product_id,
						'warehouse_id'     => $warehouse_id,
						'transaction_type' => $ref_type,
						'reference_type'   => $ref_type,
						'reference_id'     => $ref_id,
						'batch_id'         => $batch_id,
						'grn_id'          => $transaction->id,  // Reference to original receipt
						'qty'              => -$deduct_qty,
						'unit_cost'        => $layer_unit_cost,
						'total_cost'       => -$line_cost,
						'transaction_date' => $now,
						'created_by'       => $created_by,
					];
					
					$this->db->insert('inventory_transactions', $insert_data);
					
					if ($this->db->affected_rows() === 0) {
						throw new Exception("Failed to insert FIFO deduction record for transaction ID {$transaction->id}.");
					}
					
					$total_cost += $line_cost;
					$qty_remaining -= $deduct_qty;
				}
				
				// Check if we deducted everything
				if ($qty_remaining > 0) {
					// Still have remaining qty to deduct - use simple method for remaining
					$now = date('Y-m-d H:i:s');
					$remaining_cost = round($qty_remaining * $unit_cost, 4);
					
					$this->db->insert('inventory_transactions', [
						'product_id'       => $product_id,
						'warehouse_id'     => $warehouse_id,
						'transaction_type' => $ref_type,
						'reference_type'   => $ref_type,
						'reference_id'     => $ref_id,
						'batch_id'         => $batch_id,
						'grn_id'          => null,
						'qty'              => -$qty_remaining,
						'unit_cost'        => $unit_cost,
						'total_cost'       => -$remaining_cost,
						'transaction_date' => $now,
						'created_by'       => $created_by,
					]);
					
					$total_cost += $remaining_cost;
				}
				
			} else {
				// ============================================================
				// NO POSITIVE TRANSACTIONS - Create simple deduction record
				// ============================================================
				
				$now = date('Y-m-d H:i:s');
				$line_cost = round((float)$qty * $unit_cost, 4);
				
				$this->db->insert('inventory_transactions', [
					'product_id'       => $product_id,
					'warehouse_id'     => $warehouse_id,
					'transaction_type' => $ref_type,
					'reference_type'   => $ref_type,
					'reference_id'     => $ref_id,
					'batch_id'         => $batch_id,
					'grn_id'          => null,
					'qty'              => -(float)$qty,
					'unit_cost'        => $unit_cost,
					'total_cost'       => -$line_cost,
					'transaction_date' => $now,
					'created_by'       => $created_by,
				]);
				
				if ($this->db->affected_rows() === 0) {
					throw new Exception("Failed to insert deduction record.");
				}
				
				$total_cost = $line_cost;
			}
			
			// ============================================================
			// STEP 4: COMMIT
			// ============================================================
			
			if ($this->db->trans_status() === false) {
				throw new Exception('Transaction failed during commit.');
			}

			$this->db->trans_commit();

			return [
				'success'    => true,
				'total_cost' => round($total_cost, 4),
				'message'    => 'Stock deducted successfully.',
			];

		} catch (Exception $e) {
			$this->db->trans_rollback();
			log_message('error', 'FIFO deduction error: ' . $e->getMessage());
			return [
				'success'    => false,
				'total_cost' => null,
				'message'    => $e->getMessage(),
			];
		}
	}
		// ============================================================
		// APPROVE TRANSACTION (UPDATE STATUS + STOCK)
		// ============================================================
		
public function approve_transaction($id) {
    try {
        $activity = $this->_get_activity($id);
        
        if (!$activity) {
            throw new Exception('Transaction not found');
        }
        if ($activity->status !== 'pending') {
            throw new Exception('Transaction is not in pending status');
        }

        $this->db->trans_start();

        $items = $this->_get_items($id, $activity->act_type);

        foreach ($items as $item) {
            
            log_message('info', "Processing {$activity->act_type} item - Product: {$item->product_id}, Batch: " . ($item->batch_id ?? 'NULL') . ", Qty: {$item->qty}");
            
            // Get serials from the item
            $serials = [];
            if (!empty($item->serial)) {
                $serials = explode(',', $item->serial);
            }
            
            if ($activity->act_type === 'transfer') {
                // ============================================================
                // TRANSFER: Deduct from source, create GRN for destination
                // ============================================================
                
                // Create inventory transaction (FIFO deduction)
                $fifo_result = $this->deduct_stock_fifo(
                    $item->product_id,
                    $activity->store_id,
                    $item->batch_id,
                    $item->qty,
                    'TRANSFER_OUT',
                    $activity->st_activity_id,
                    $this->session->userdata('user_id')
                );

                if (!$fifo_result['success']) {
                    throw new Exception('FIFO deduction failed for product ID ' . $item->product_id . ': ' . $fifo_result['message']);
                }
                
                // Release reserved only (qty already reduced on submit)
                $this->db->where('product_id', (int)$item->product_id);
                $this->db->where('warehouse_id', (int)$activity->store_id);
                if (!empty($item->batch_id)) {
                    $this->db->where('batch_id', (int)$item->batch_id);
                }
                
                $source_stock = $this->db->get('inventory_stock')->row();
                
                if ($source_stock) {
                    $this->db->set('reserved_qty', 'GREATEST(reserved_qty - ' . (float)$item->qty . ', 0)', FALSE);
                    $this->db->set('updated_at', date('Y-m-d H:i:s'));
                    $this->db->where('id', $source_stock->id);
                    $this->db->update('inventory_stock');
                }
                
                // Reduce batch qty
                if (!empty($item->batch_id)) {
                    $this->db->set('qty', 'qty - ' . (float)$item->qty, FALSE)
                             ->set('updated_at', date('Y-m-d H:i:s'))
                             ->where('id', (int)$item->batch_id)
                             ->where('qty >=', (float)$item->qty)
                             ->update('product_batches');
                }
                
                // ✅ MARK SERIALS AS TRANSFERRED (move to destination warehouse)
                if (!empty($serials)) {
                    $this->_mark_serials_transferred(
                        $item->product_id,
                        $activity->store_id,
                        $serials,
                        'transfer',
                        $activity->st_activity_id,
                        $activity->to_store_id  // New warehouse for serials
                    );
                }
                
                // Create GRN for destination
                if (!empty($activity->to_store_id)) {
                    $grn_id = $this->_create_grn_for_destination(
                        $item->product_id,
                        $activity->to_store_id,
                        $item->batch_id,
                        $item->qty,
                        $activity->st_activity_id,
                        $serials  // Pass serials to GRN
                    );
                    
                    if ($grn_id) {
                        $this->db->where('st_activity_id', $id)
                                 ->update('stock_activities', ['grn_id' => $grn_id]);
                    }
                }
                
            } elseif ($activity->act_type === 'return') {
                // ============================================================
                // RETURN: Add stock back to warehouse
                // ============================================================
                
                // Create inventory transaction (receipt)
                $unit_cost = 0;
                if (!empty($item->batch_id)) {
                    $batch = $this->db->where('id', $item->batch_id)->get('product_batches')->row();
                    $unit_cost = $batch ? ($batch->unit_cost ?? 0) : 0;
                }
                if ($unit_cost == 0) {
                    $product = $this->db->select('last_purchase_price, price')
                                        ->where('id', $item->product_id)
                                        ->get('products')
                                        ->row();
                    $unit_cost = $product ? (float)($product->last_purchase_price ?? $product->price ?? 0) : 0;
                }
                
                $total_cost = (float)$item->qty * $unit_cost;
                
                // Create return receipt record in inventory_transactions
                $this->db->insert('inventory_transactions', [
                    'product_id'       => $item->product_id,
                    'warehouse_id'     => $activity->store_id,
                    'transaction_type' => 'RETURN_IN',
                    'reference_type'   => 'RETURN_IN',
                    'reference_id'     => $activity->st_activity_id,
                    'batch_id'         => $item->batch_id ?? null,
                    'qty'              => (float)$item->qty,
                    'unit_cost'        => $unit_cost,
                    'total_cost'       => $total_cost,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'created_by'       => $this->session->userdata('user_id'),
                    'created_at'       => date('Y-m-d H:i:s')
                ]);
                
                // Increase inventory_stock at warehouse
                $this->db->where('product_id', (int)$item->product_id);
                $this->db->where('warehouse_id', (int)$activity->store_id);
                if (!empty($item->batch_id)) {
                    $this->db->where('batch_id', (int)$item->batch_id);
                }
                
                $existing_stock = $this->db->get('inventory_stock')->row();
                
                if ($existing_stock) {
                    $this->db->set('qty', 'qty + ' . (float)$item->qty, FALSE)
                             ->set('updated_at', date('Y-m-d H:i:s'))
                             ->where('id', $existing_stock->id)
                             ->update('inventory_stock');
                } else {
                    $this->db->insert('inventory_stock', [
                        'product_id'   => $item->product_id,
                        'warehouse_id' => $activity->store_id,
                        'batch_id'     => $item->batch_id ?? null,
                        'qty'          => $item->qty,
                        'reserved_qty' => 0,
                        'updated_at'   => date('Y-m-d H:i:s')
                    ]);
                }
                
                // Update or create product_batches for return
                $batch_id_for_serials = null;
                if (!empty($item->batch_id)) {
                    $this->db->set('qty', 'qty + ' . (float)$item->qty, FALSE)
                             ->set('updated_at', date('Y-m-d H:i:s'))
                             ->where('id', (int)$item->batch_id)
                             ->update('product_batches');
                    $batch_id_for_serials = $item->batch_id;
                } elseif (!empty($item->batch_number)) {
                    $existing_batch = $this->db->where('product_id', $item->product_id)
                                               ->where('warehouse_id', $activity->store_id)
                                               ->where('batch_no', $item->batch_number)
                                               ->get('product_batches')
                                               ->row();
                    
                    if ($existing_batch) {
                        $this->db->set('qty', 'qty + ' . (float)$item->qty, FALSE)
                                 ->set('updated_at', date('Y-m-d H:i:s'))
                                 ->where('id', $existing_batch->id)
                                 ->update('product_batches');
                        $batch_id_for_serials = $existing_batch->id;
                    } else {
                        $this->db->insert('product_batches', [
                            'product_id'   => $item->product_id,
                            'warehouse_id' => $activity->store_id,
                            'batch_no'     => $item->batch_number ?? ('RET-' . date('Ymd') . '-' . $activity->st_activity_id),
                            'expiry_date'  => $item->expiry_date ?? null,
                            'qty'          => $item->qty,
                            'unit_cost'    => $unit_cost,
                            'created_at'   => date('Y-m-d H:i:s'),
                            'updated_at'   => date('Y-m-d H:i:s')
                        ]);
                        $batch_id_for_serials = $this->db->insert_id();
                    }
                }
                
                // ✅ MARK SERIALS AS RETURNED
                if (!empty($serials)) {
                    $this->_mark_serials_returned(
                        $item->product_id,
                        $activity->store_id,
                        $serials,
                        'return',
                        $activity->st_activity_id,
                        $batch_id_for_serials
                    );
                }
                
                // Insert stock log
                $old_qty = 0;
                $stock_log = $this->db->where('product_id', $item->product_id)
                                      ->where('warehouse_id', $activity->store_id)
                                      ->get('inventory_stock')
                                      ->row();
                if ($stock_log) {
                    $old_qty = $stock_log->qty - (float)$item->qty;
                }
                
                $this->db->insert('inventory_stock_log', [
                    'product_id'     => $item->product_id,
                    'warehouse_id'   => $activity->store_id,
                    'old_qty'        => $old_qty,
                    'new_qty'        => $old_qty + (float)$item->qty,
                    'reference_type' => 'RETURN',
                    'reference_id'   => $activity->st_activity_id,
                    'changed_at'     => date('Y-m-d H:i:s'),
                    'changed_by'     => $this->session->userdata('user_id')
                ]);
                
            } elseif ($activity->act_type === 'issue') {
                // ============================================================
                // ISSUE: Deduct stock for customer
                // ============================================================
                
                $fifo_result = $this->deduct_stock_fifo(
                    $item->product_id,
                    $activity->store_id,
                    $item->batch_id,
                    $item->qty,
                    'ISSUE_OUT',
                    $activity->st_activity_id,
                    $this->session->userdata('user_id')
                );

                if (!$fifo_result['success']) {
                    throw new Exception('FIFO deduction failed for product ID ' . $item->product_id . ': ' . $fifo_result['message']);
                }
                
                // Reduce inventory_stock
                $this->db->where('product_id', (int)$item->product_id);
                $this->db->where('warehouse_id', (int)$activity->store_id);
                if (!empty($item->batch_id)) {
                    $this->db->where('batch_id', (int)$item->batch_id);
                }
                
                $issue_stock = $this->db->get('inventory_stock')->row();
                
                if ($issue_stock) {
                    $this->db->set('qty', 'GREATEST(qty - ' . (float)$item->qty . ', 0)', FALSE);
                    $this->db->set('updated_at', date('Y-m-d H:i:s'));
                    $this->db->where('id', $issue_stock->id);
                    $this->db->update('inventory_stock');
                }
                
                // Reduce batch qty
                if (!empty($item->batch_id)) {
                    $this->db->set('qty', 'qty - ' . (float)$item->qty, FALSE)
                             ->set('updated_at', date('Y-m-d H:i:s'))
                             ->where('id', (int)$item->batch_id)
                             ->update('product_batches');
                }
                
                // ✅ MARK SERIALS AS SOLD/ISSUED
                if (!empty($serials)) {
                    $this->_mark_serials_issued(
                        $item->product_id,
                        $serials,
                        'issue',
                        $activity->st_activity_id
                    );
                }
            }
        }

        // Update status to approved
        $this->db->where('st_activity_id', $id);
        $this->db->update('stock_activities', [
            'status' => 'approved',
            'approved_by' => $this->session->userdata('user_id'),
            'approved_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Transaction commit failed');
        }
        
        log_message('info', ucfirst($activity->act_type) . " #{$id} approved successfully");
        
        $messages = [
            'transfer' => 'Transfer approved. Stock deducted from source, GRN created for destination.',
            'return' => 'Return approved. Stock added back to warehouse.',
            'issue' => 'Issue approved. Stock deducted from warehouse.'
        ];
        
        return [
            'success' => true, 
            'message' => $messages[$activity->act_type] ?? 'Transaction approved successfully.'
        ];

    } catch (Exception $e) {
        $this->db->trans_rollback();
        log_message('error', 'Transaction approval failed: ' . $e->getMessage());
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

	private function _create_grn_for_destination($product_id, $warehouse_id, $source_batch_id, $qty, $reference_id, $serials = [])
{
    $branch_id = $this->getCurrentBranchId();
		// Get product details
		$product = $this->db->select('id, name, product_code, unit_id, is_expiry_trk, is_batch, is_auto_batch, last_purchase_price, price')
							->where('id', $product_id)
							->get('products')
							->row();
		
		if (!$product) {
			log_message('error', "GRN Creation: Product not found: {$product_id}");
			return null;
		}
		
		// Get source batch details
		$source_batch = null;
		$batch_number = null;
		$expiry_date = null;
		$unit_cost = 0;
		
		if ($source_batch_id) {
			$source_batch = $this->db->where('id', $source_batch_id)
									 ->get('product_batches')
									 ->row();
			if ($source_batch) {
				$batch_number = $source_batch->batch_no;
				$expiry_date = $source_batch->expiry_date ?? null;
				$unit_cost = $source_batch->unit_cost ?? 0;
				log_message('info', "GRN Creation: Source batch found - {$batch_number}, cost: {$unit_cost}");
			}
		}
		
		// ============================================================
		// IMPORTANT: For batch-tracked products, ensure batch_number exists
		// ============================================================
		if (($product->is_batch == 1 || $product->is_auto_batch == 1) && empty($batch_number)) {
			// Generate a transfer batch number
			$batch_number = 'TRF-BATCH-' . date('Ymd') . '-' . $reference_id . '-P' . $product_id;
			log_message('info', "GRN Creation: Generated batch number for transfer: {$batch_number}");
		}
		
		if ($unit_cost == 0) {
			$unit_cost = (float)($product->last_purchase_price ?? $product->price ?? 0);
		}
		
		$total_cost = $qty * $unit_cost;
		
		// Generate GRN number
		$year = date('Y');
		$this->db->select('grn_number');
		$this->db->like('grn_number', 'TRF-' . $year . '-', 'after');
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
		
		$grn_number = 'TRF-' . $year . '-' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
		
		log_message('info', "GRN Creation: Generated GRN number: {$grn_number}");
		log_message('info', "GRN Creation: Batch number: " . ($batch_number ?? 'NULL') . ", Expiry: " . ($expiry_date ?? 'NULL'));
		
		// Create GRN header
		$grn_data = [
			'grn_number' => $grn_number,
			'supplier_id' => null,
			'warehouse_id' => $warehouse_id,
			'branch_id' => $branch_id,
			'grn_date' => date('Y-m-d'),
			'delivery_note' => 'Stock Transfer #' . $reference_id,
			'ref_invoice_no' => 'ST-TRF-' . $reference_id,
			'subtotal' => $total_cost,
			'discount_value' => 0,
			'discount_type' => 'amount',
			'tax_total' => 0,
			'grand_total' => $total_cost,
			'remarks' => 'Auto-generated from stock transfer #' . $reference_id . '. Source batch: ' . ($batch_number ?? 'N/A'),
			'status' => 'submitted',
			'created_by' => $this->session->userdata('user_id'),
			'received_by' => $this->session->userdata('user_id'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];
		
		$this->db->insert('grn', $grn_data);
		$grn_id = $this->db->insert_id();
		
		if (!$grn_id) {
			log_message('error', "GRN Creation: Failed to insert GRN header");
			return null;
		}
		
		// Create GRN item - ENSURE batch_number is passed
		$grn_item_data = [
        'grn_id' => $grn_id,
        'product_id' => $product_id,
        'unit_id' => $product->unit_id ?? null,
        'quantity' => $qty,
        'free_quantity' => 0,
        'unit_price' => $unit_cost,
        'discount_value' => 0,
        'discount_type' => 'amount',
        'tax_value' => 0,
        'batch_number' => $batch_number,
        'expiry_date' => $expiry_date,
        'line_total' => $total_cost,
        'has_serials' => !empty($serials) ? 1 : 0,
        'serials_data' => !empty($serials) ? json_encode($serials) : null,
        'created_at' => date('Y-m-d H:i:s')
    ];
		
		$this->db->insert('grn_items', $grn_item_data);
		$grn_item_id = $this->db->insert_id();
		
		log_message('info', "GRN Item created - ID: {$grn_item_id}, Batch: " . ($batch_number ?? 'NULL'));
		
		// Log GRN creation
		$this->db->insert('grn_approvals', [
			'grn_id' => $grn_id,
			'action' => 'created',
			'action_by' => $this->session->userdata('user_id'),
			'action_note' => 'Auto-created from stock transfer #' . $reference_id . '. Batch: ' . ($batch_number ?? 'N/A'),
			'action_date' => date('Y-m-d H:i:s')
		]);
		
		$this->db->insert('grn_approvals', [
			'grn_id' => $grn_id,
			'action' => 'submitted',
			'action_by' => $this->session->userdata('user_id'),
			'action_note' => 'Awaiting approval. Approve to add stock and create batch at destination.',
			'action_date' => date('Y-m-d H:i:s')
		]);
		
		log_message('info', "GRN #{$grn_id} ({$grn_number}) created - Status: submitted");
		log_message('info', "ACTION: Go to GRN module and approve GRN #{$grn_id} to complete the transfer");
		
		return $grn_id;
	}

	private function logApproval($grn_id, $action, $note = null)
	{
		$this->db->insert('grn_approvals', [
			'grn_id' => $grn_id,
			'action' => $action,
			'action_by' => $this->session->userdata('user_id'),
			'action_note' => $note,
			'action_date' => date('Y-m-d H:i:s')
		]);
	}

	/**
	 * Add stock to destination warehouse (like GRN)
	 * Creates GRN and immediately approves it (or submits for approval)
	 */
	private function _add_stock_to_destination($product_id, $warehouse_id, $source_batch_id, $qty, $reference_id)
	{
		// Load GRN model
		$this->load->model('Grn_model');
		
		// Get product details
		$product = $this->db->select('is_expiry_trk, is_auto_batch, unit_id, name, product_code')
							->where('id', $product_id)
							->get('products')
							->row();
		
		// If source batch exists, get its details
		$source_batch = null;
		if ($source_batch_id) {
			$source_batch = $this->db->where('id', $source_batch_id)
									 ->get('product_batches')
									 ->row();
		}
		
		$batch_number = null;
		$expiry_date = null;
		$unit_cost = $source_batch ? $source_batch->unit_cost : 0;
		
		// For manual batch products, use the same batch number
		if ($product && $product->is_expiry_trk == 1 && $source_batch && $source_batch->batch_no) {
			$batch_number = $source_batch->batch_no;
			$expiry_date = $source_batch->expiry_date ?? null;
		}
		
		// First, create a DRAFT GRN
		$grn_data = [
			'grn_number' => 'TRF-GRN-' . date('Ymd') . '-' . $reference_id,
			'supplier_id' => null,  // No supplier for transfers
			'warehouse_id' => $warehouse_id,
			'grn_date' => date('Y-m-d'),
			'delivery_note' => 'Stock Transfer from warehouse (Ref: ' . $reference_id . ')',
			'ref_invoice_no' => $reference_id,
			'subtotal' => $qty * $unit_cost,
			'discount_value' => 0,
			'discount_type' => 'amount',
			'tax_total' => 0,
			'grand_total' => $qty * $unit_cost,
			'remarks' => 'Auto-generated from stock transfer approval',
			'status' => 'draft',  // Start as draft
			'created_by' => $this->session->userdata('user_id'),
			'received_by' => $this->session->userdata('user_id'),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];
		
		$this->db->insert('grn', $grn_data);
		$grn_id = $this->db->insert_id();
		
		if (!$grn_id) {
			error_log("Failed to create GRN for transfer");
			return;
		}
		
		// Create GRN item
		$grn_item_data = [
			'grn_id' => $grn_id,
			'product_id' => $product_id,
			'unit_id' => $product->unit_id ?? null,
			'quantity' => $qty,
			'free_quantity' => 0,
			'unit_price' => $unit_cost,
			'discount_value' => 0,
			'discount_type' => 'amount',
			'tax_value' => 0,
			'batch_number' => $batch_number,
			'expiry_date' => $expiry_date,
			'line_total' => $qty * $unit_cost,
			'has_serials' => 0,
			'serials_data' => null,
			'created_at' => date('Y-m-d H:i:s')
		];
		
		$this->db->insert('grn_items', $grn_item_data);
		$grn_item_id = $this->db->insert_id();
		
		// NOW APPROVE THE GRN using the Grn_model
		// First, update the GRN item with the ID
		$this->db->where('id', $grn_item_id)
				 ->update('grn_items', ['id' => $grn_item_id]);
		
		// Call the approve method from Grn_model
		// This will handle batch creation, stock update, inventory transactions, etc.
		$submit_result = $this->Grn_model->submitForApproval($grn_id);
		
		 if (!$submit_result) {
			error_log("Failed to submit GRN for approval. Transfer reference: " . $reference_id);
		}
		
		error_log("GRN created and submitted for approval. GRN ID: $grn_id, Status: submitted");
		
		return $grn_id;
	}
	private function _create_batch_at_destination($product_id, $warehouse_id, $source_batch, $qty, $batch_no)
		{
			$batch_data = [
				'product_id'   => $product_id,
				'warehouse_id' => $warehouse_id,
				'batch_no'     => $batch_no,
				'qty'          => $qty,
				'unit_cost'    => $source_batch ? $source_batch->unit_cost : 0,
				'created_at'   => date('Y-m-d H:i:s'),
				'updated_at'   => date('Y-m-d H:i:s')
			];
			
			// Copy expiry info if exists from source batch
			if ($source_batch && isset($source_batch->expiry_date) && $source_batch->expiry_date) {
				$batch_data['expiry_date'] = $source_batch->expiry_date;
			}
			if ($source_batch && isset($source_batch->mfg_date) && $source_batch->mfg_date) {
				$batch_data['mfg_date'] = $source_batch->mfg_date;
			}
			
			$this->db->insert('product_batches', $batch_data);
			return $this->db->insert_id();
		}

		/**
		 * Update inventory_stock table for destination warehouse
		 */
		private function _update_destination_inventory_stock($product_id, $warehouse_id, $batch_id, $qty)
	{
		$this->db->where('product_id', $product_id);
		$this->db->where('warehouse_id', $warehouse_id);
		
		if ($batch_id) {
			$this->db->where('batch_id', $batch_id);
		}
		
		$stock = $this->db->get('inventory_stock')->row();
		
		if ($stock) {
			// Update existing - INCREASE stock at destination
			$this->db->set('qty', 'qty + ' . (float)$qty, FALSE)
					 ->set('updated_at', date('Y-m-d H:i:s'))
					 ->where('id', $stock->id)
					 ->update('inventory_stock');
		} else {
			// Insert new
			$this->db->insert('inventory_stock', [
				'product_id'   => $product_id,
				'warehouse_id' => $warehouse_id,
				'batch_id'     => $batch_id,
				'qty'          => $qty,
				'reserved_qty' => 0,
				'updated_at'   => date('Y-m-d H:i:s')
			]);
		}
	}
	/**
	 * Find existing batch in destination warehouse by batch number
	 */
	private function _find_existing_batch($product_id, $warehouse_id, $batch_no)
	{
		if (!$batch_no) return null;
		
		return $this->db->select('id, qty')
						->where('product_id', $product_id)
						->where('warehouse_id', $warehouse_id)
						->where('batch_no', $batch_no)
						->get('product_batches')
						->row();
	}

	/**
	 * Update existing batch quantity
	 */
	private function _update_batch_quantity($batch_id, $additional_qty)
	{
		$this->db->set('qty', 'qty + ' . (float)$additional_qty, FALSE)
				 ->set('updated_at', date('Y-m-d H:i:s'))
				 ->where('id', $batch_id)
				 ->update('product_batches');
	}

	/**
	 * Create new batch from source batch details
	 */
	private function _create_batch_from_source($product_id, $warehouse_id, $source_batch, $qty)
	{
		$batch_data = [
			'product_id'   => $product_id,
			'warehouse_id' => $warehouse_id,
			'batch_no'     => $source_batch ? $source_batch->batch_no : 'TRF-' . date('YmdHis'),
			'qty'          => $qty,
			'unit_cost'    => $source_batch ? $source_batch->unit_cost : 0,
			'created_at'   => date('Y-m-d H:i:s'),
			'updated_at'   => date('Y-m-d H:i:s')
		];
		
		// Copy expiry info if exists
		if ($source_batch && $source_batch->expiry_date) {
			$batch_data['expiry_date'] = $source_batch->expiry_date;
		}
		if ($source_batch && $source_batch->mfg_date) {
			$batch_data['mfg_date'] = $source_batch->mfg_date;
		}
		
		$this->db->insert('product_batches', $batch_data);
		return $this->db->insert_id();
	}



    // ============================================================
    // REJECT TRANSACTION
    // ============================================================
    
   public function reject_transaction($id, $note = '')
{
    try {
        $activity = $this->_get_activity($id);

        if (!$activity) {
            return ['success' => false, 'message' => 'Transaction not found'];
        }

        if ($activity->status !== 'pending') {
            return ['success' => false, 'message' => 'Transaction is not in pending status'];
        }

        $this->db->trans_start();

        $items = $this->_get_items($id, $activity->act_type);

        if ($activity->act_type === 'transfer') {
            // RESTORE: Decrease reserved_qty AND increase qty (reverse the submit)
            foreach ($items as $item) {
                $restored = $this->_restore_qty_and_release_reserved(
                    $item->product_id,
                    $activity->store_id,
                    $item->batch_id,
                    $item->qty
                );
                
                if (!$restored) {
                    throw new Exception('Failed to restore stock for product ID: ' . $item->product_id);
                }
                
                // ✅ RESTORE SERIALS - Mark back as AVAILABLE
                if (!empty($item->serial)) {
                    $serials = explode(',', $item->serial);
                    $this->_restore_serials($item->product_id, $serials);
                    log_message('info', "Restored " . count($serials) . " serials for product ID: {$item->product_id}");
                }
            }
        } elseif ($activity->act_type === 'return') {
            log_message('info', "Return #{$id} rejected - no stock changes needed");
        } elseif ($activity->act_type === 'issue') {
            log_message('info', "Issue #{$id} rejected - no stock changes needed");
        }

        // Update status
        $this->db->where('st_activity_id', $id);
        $this->db->update('stock_activities', [
            'status' => 'rejected',
            'note'   => $note,
            'rejected_by' => $this->session->userdata('user_id'),
            'rejected_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Transaction commit failed');
        }

        return ['success' => true, 'message' => 'Transaction rejected successfully.'];

    } catch (Exception $e) {
        $this->db->trans_rollback();
        log_message('error', 'Transaction rejection failed: ' . $e->getMessage());
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
   

    // ============================================================
    // LIST TRANSACTIONS
    // ============================================================
    
    public function get_transactions($filters = []) {
        if (!empty($filters['type'])) {
            $this->db->where('act_type', $filters['type']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['from'])) {
            $this->db->where('st_act_date >=', $filters['from'] . ' 00:00:00');
        }
        if (!empty($filters['to'])) {
            $this->db->where('st_act_date <=', $filters['to'] . ' 23:59:59');
        }
        if (!empty($filters['search'])) {
            $this->db->like('note', $filters['search']);
        }

        return $this->db->order_by('st_act_date', 'DESC')
                       ->get('stock_activities')
                       ->result();
    }

    // ============================================================
    // HELPER: GET AVAILABLE BATCHES
    // ============================================================
    
	public function get_available_batches($product_id, $warehouse_id = null) {
    $branch_id = $this->getCurrentBranchId();
    log_message('info', "Getting available batches for product_id: {$product_id}, warehouse_id: " . ($warehouse_id ?? 'NULL'));
    
    $this->db->where('product_id', $product_id);
    $this->db->where('qty >', 0);
    
    if ($branch_id) {
        $this->db->where('branch_id', $branch_id);  // ADD BRANCH FILTER
    }  // Only batches with stock
    
    if ($warehouse_id) {
        $this->db->where('warehouse_id', $warehouse_id);
    }
    
    $this->db->order_by('expiry_date', 'ASC');
    $result = $this->db->get('product_batches')->result();
    
    log_message('info', "Found " . count($result) . " batches for product_id: {$product_id}");
    
    return $result;
}
    // ============================================================
    // HELPER: GET AVAILABLE SERIALS
    // ============================================================
    
    public function get_available_serials($product_id, $warehouse_id = null) {
    $branch_id = $this->getCurrentBranchId();
    $this->db->select('id, serial_no, batch_id');
    $this->db->where('product_id', $product_id);
     $this->db->where('status', 'AVAILABLE');
    
    if ($branch_id) {
        $this->db->where('branch_id', $branch_id);  // ADD BRANCH FILTER
    }  // Only available serials
    
    if ($warehouse_id) {
        $this->db->where('warehouse_id', $warehouse_id);
    }
    
    return $this->db->get('product_serial_numbers')->result();
}

    // ============================================================
    // FORMATTERS
    // ============================================================
    
    public function format_customers_for_dropdown($customers) {
    $result = [];
    foreach ($customers as $c) {
        $result[$c->cus_id] = [
            'name'          => $c->cus_name,
            'phone'         => $c->cus_phone ?? '',
            'email'         => $c->cus_email ?? '',
            'creditEnabled' => ($c->cus_credit_enabled ?? 0) == 1,
            'creditLimit'   => floatval($c->cus_credit_limit ?? 0),
            'creditUsed'    => floatval($c->cus_credit_used ?? 0),
            'outstanding'   => floatval($c->cus_outstanding ?? 0)
        ];
    }
    return $result;
}

public function format_products_for_search($products) {
    $result = [];
    
    $warehouse_id = $this->input->get('warehouse_id') ?? null;
    $mode = $this->input->get('mode') ?? 'issue';
    
    foreach ($products as $p) {
        
        // Get stock based on mode
        if ($mode === 'return') {
            $this->db->select('COALESCE(SUM(qty), 0) as total_stock');
            $this->db->where('product_id', $p->id);
        } else {
            $this->db->select('COALESCE(SUM(qty), 0) as total_stock');
            $this->db->where('product_id', $p->id);
            if ($warehouse_id) {
                $this->db->where('warehouse_id', $warehouse_id);
            }
        }
        
        $stock_row = $this->db->get('inventory_stock')->row();
        $stock = floatval($stock_row->total_stock ?? 0);
        
        // ============================================================
        // CRITICAL FIX: Properly detect batch tracking
        // ============================================================
        $isBatch = ($p->is_batch ?? 0) == 1;
        $hasExpiry = ($p->is_expiry_trk ?? 0) == 1;
        $isSerial = ($p->is_serial_trk ?? 0) == 1;
        
        // Log for debugging
        log_message('debug', "Product {$p->id} - is_batch: {$p->is_batch}, is_expiry_trk: {$p->is_expiry_trk}, is_batch: " . ($isBatch ? 'true' : 'false') . ", hasExpiry: " . ($hasExpiry ? 'true' : 'false'));
        
        // Get batches for batch-tracked products
        $batches = [];
        if ($isBatch || $hasExpiry) {
            if ($mode === 'return') {
                $batches = $this->get_all_batches($p->id, $warehouse_id);
            } else {
                // For issue/transfer - get batches for the selected warehouse
                $batches = $this->get_available_batches($p->id, $warehouse_id);
            }
        }
        
        // Format batches
        $formatted_batches = [];
        foreach ($batches as $batch) {
            $formatted_batches[] = [
                'id'           => $batch->id,
                'batch_no'     => $batch->batch_no,
                'batchNo'      => $batch->batch_no,
                'qty'          => floatval($batch->qty),
                'stock'        => floatval($batch->qty),
                'expiry_date'  => $batch->expiry_date ?? null,
                'expDate'      => $batch->expiry_date ?? null,
                'mfg_date'     => $batch->mfg_date ?? null,
                'mfgDate'      => $batch->mfg_date ?? null,
                'unit_cost'    => $batch->unit_cost ?? 0,
                'warehouse_id' => $batch->warehouse_id ?? null
            ];
        }
        
        // Get serials
        $serials = [];
        if ($isSerial) {
            $serial_data = $this->get_available_serials($p->id, $warehouse_id);
            $serials = array_column($serial_data, 'serial_no');
        }
        
        $result[] = [
            'id'             => $p->id,
            'code'           => $p->product_code ?? '',
            'name'           => $p->name ?? '',
            'icon'           => '📦',
            'category'       => $p->category_name ?? 'General',
            'description'    => $p->description ?? '',
            'stock'          => $mode === 'return' ? 999999 : $stock,
            'unit'           => $p->measure_unit ?? $p->unit ?? 'pcs',
            'price'          => floatval($p->price ?? 0),
            'retailPrice'    => floatval($p->retailPrice ?? 0),
            'wholesalePrice' => floatval($p->wholesalePrice ?? 0),
            'isSerial'       => $isSerial,
            'isSerialTrk'    => $isSerial,
            'isBatch'        => $isBatch,        // Use proper boolean
            'isBatchTrk'     => $isBatch,        // Use proper boolean
            'isAutoBatch'    => ($p->is_auto_batch ?? 0) == 1,
            'hasExpiry'      => $hasExpiry,      // Use proper boolean
            'hasWarranty'    => ($p->is_warranty_item ?? 0) == 1,
            'warrantyMonths' => intval($p->warranty_period ?? 0),
            'warrantyType'   => $p->warrantyType ?? 'manufacturer',
            'batches'        => $formatted_batches,
            'serials'        => $serials
        ];
    }
    return $result;
}

	public function get_all_batches($product_id, $warehouse_id = null) {
    $branch_id = $this->getCurrentBranchId();
		// Get all batches for a product, optionally filtered by warehouse
		log_message('info', "Getting all batches for product_id: {$product_id}, warehouse_id: " . ($warehouse_id ?? 'ALL'));
		
		$this->db->where('product_id', $product_id);
		$this->db->where('qty >', 0);
    
    if ($branch_id) {
        $this->db->where('branch_id', $branch_id);  // ADD BRANCH FILTER
    }
		
		if ($warehouse_id) {
			$this->db->where('warehouse_id', $warehouse_id);
		}
		
		$this->db->order_by('expiry_date', 'ASC');
		$result = $this->db->get('product_batches')->result();
		
		log_message('info', "Found " . count($result) . " batches for product_id: {$product_id}");
		
		return $result;
	}
    // ============================================================
    // PRIVATE HELPERS
    // ============================================================
    
	 private function _get_activity($id) {
			return $this->db->where('st_activity_id', $id)
						   ->get('stock_activities')
						   ->row();
		}

		private function _get_items($activity_id, $type) {
		// Use unified table for all transaction types
		$table = 'stock_transaction_items';
		
		return $this->db
			->select('i.*, p.name as product_name, p.product_code, p.is_serial_trk, p.is_expiry_trk')
			->from($table . ' i')
			->join('products p', 'p.id = i.product_id', 'left')
			->where('i.fk_st_activity_id', $activity_id)
			->get()
			->result();
	}

    private function _save_items($activity_id, $mode, $items) {
    $table = 'stock_transaction_items';
    
    foreach ($items as $item) {
        $this->db->insert($table, [
            'fk_st_activity_id' => $activity_id,
            'product_id'        => $item['product_id'],
            'qty'               => $item['qty'],
            'batch_id'          => $item['batch_id'] ?? null,
            'batch_number'      => $item['batch_number'] ?? null,
            'expiry_date'       => $item['expiry_date'] ?? null,
            'serial'            => !empty($item['serials']) ? implode(',', (array)$item['serials']) : null,
            'unit_cost'         => $item['unit_cost'] ?? null,
            'created_at'        => date('Y-m-d H:i:s')
        ]);
    }
}


    private function _process_inventory_update($activity, $items) {
        foreach ($items as $item) {
            if ($activity->act_type === 'issue') {
                $this->_decrease_stock($item->product_id, $activity->store_id, $item->qty);
            } elseif ($activity->act_type === 'transfer') {
                $this->_decrease_stock($item->product_id, $activity->store_id, $item->qty);
                $this->_increase_stock($item->product_id, $activity->to_store_id, $item->qty);
            }
        }
    }

	private function _decrease_stock($product_id, $warehouse_id, $batch_id, $qty)
	{
		$this->db->set('qty', 'qty - ' . (float)$qty, FALSE);

		$this->db->where('product_id', $product_id);
		$this->db->where('warehouse_id', $warehouse_id);

		if ($batch_id) {
			$this->db->where('batch_id', $batch_id);
		}

		$this->db->update('inventory_stock');
	}

   private function _increase_stock($product_id, $warehouse_id, $batch_id, $qty)
{
    $this->db->where('product_id', $product_id);
    $this->db->where('warehouse_id', $warehouse_id);

    if ($batch_id) {
        $this->db->where('batch_id', $batch_id);
    }

    $stock = $this->db->get('inventory_stock')->row();

    if ($stock) {

        $this->db->set('qty', 'qty + ' . (float)$qty, FALSE);

        $this->db->where('id', $stock->id);

        $this->db->update('inventory_stock');

    } else {

        $this->db->insert('inventory_stock', [
            'product_id' => $product_id,
            'warehouse_id' => $warehouse_id,
            'batch_id' => $batch_id,
            'qty' => $qty,
            'reserved_qty' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}

    private function _log_stock_movements($activity, $items) {
        foreach ($items as $item) {
            $this->db->insert('inventory_stock_log', [
                'product_id'     => $item->product_id,
                'warehouse_id'   => $activity->store_id,
                'old_qty'        => 0,
                'new_qty'        => $item->qty,
                'reference_type' => 'stock_' . $activity->act_type,
                'reference_id'   => $activity->st_activity_id,
                'changed_at'     => date('Y-m-d H:i:s'),
                'changed_by'     => $this->session->userdata('user_id')
            ]);
        }
    }

    private function _get_store_name($id) {
        if (!$id) return null;
        $store = $this->db->select('store_name')->where('store_id', $id)->get('stores')->row();
        return $store ? $store->store_name : null;
    }

    private function _get_customer_name($id) {
        if (!$id) return null;
        $customer = $this->db->select('cus_name')->where('cus_id', $id)->get('customer')->row();
        return $customer ? $customer->cus_name : null;
    }

    private function _get_user_name($id) {
    if (!$id) return null;
    $user = $this->db->select('full_name')
                     ->where('user_id', $id)
                     ->get('user')
                     ->row();
    return $user ? $user->full_name : null;
}

	private function _reserve_stock($product_id, $warehouse_id, $batch_id, $qty)
	{
		$this->db->where('product_id', (int)$product_id);
		$this->db->where('warehouse_id', (int)$warehouse_id);

		if (!empty($batch_id)) {
			$this->db->where('batch_id', (int)$batch_id);
		}

		$stock = $this->db->get('inventory_stock')->row();

		if (!$stock) {
			return false;
		}

		// Check available stock (qty - reserved_qty)
		$available = (float)$stock->qty - (float)$stock->reserved_qty;
		if ($available < (float)$qty) {
			return false;
		}

		// ONLY increase reserved_qty - DO NOT deduct actual qty
		$this->db->set('reserved_qty', 'reserved_qty + ' . (float)$qty, FALSE);
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $stock->id);
		$this->db->update('inventory_stock');

		return true;
	}

	private function _release_reserved_stock($product_id, $warehouse_id, $batch_id, $qty)
	{
		$this->db->where('product_id', (int)$product_id);
		$this->db->where('warehouse_id', (int)$warehouse_id);

		if (!empty($batch_id)) {
			$this->db->where('batch_id', (int)$batch_id);
		}

		$stock = $this->db->get('inventory_stock')->row();

		if (!$stock) {
			return false;
		}

		// Check if reserved_qty is sufficient
		if ((float)$stock->reserved_qty < (float)$qty) {
			return false;
		}

		// Release reserved stock (decrease reserved_qty AND decrease actual qty)
		$this->db->set('reserved_qty', 'GREATEST(reserved_qty - ' . (float)$qty . ', 0)', FALSE);
		$this->db->set('qty', 'GREATEST(qty - ' . (float)$qty . ', 0)', FALSE);
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $stock->id);
		$this->db->update('inventory_stock');
		
		return $this->db->affected_rows() > 0;
	}

		private function _restore_reserved_stock($product_id, $warehouse_id, $batch_id, $qty)
	{
		$this->db->where('product_id', (int)$product_id);
		$this->db->where('warehouse_id', (int)$warehouse_id);

		if (!empty($batch_id)) {
			$this->db->where('batch_id', (int)$batch_id);
		}

		$stock = $this->db->get('inventory_stock')->row();

		if (!$stock) {
			return false;
		}

		// Restore reserved stock (decrease reserved_qty, qty stays same)
		$this->db->set('reserved_qty', 'GREATEST(reserved_qty - ' . (float)$qty . ', 0)', FALSE);
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $stock->id);
		$this->db->update('inventory_stock');
		
		// NO change to product_batches for rejection (stock wasn't actually deducted yet)
		
		return $this->db->affected_rows() > 0;
	}


	// ─── COUNTS FOR STAT PILLS ───
	public function get_activity_counts() {
    $branch_id = $this->getCurrentBranchId();
		// Total
		$this->db->where('branch_id', $branch_id); 
		$total = $this->db->count_all('stock_activities');
	 
		// Per status
		$rows = $this->db
			->select('status, COUNT(*) as cnt')
			->group_by('status')
			->where('branch_id', $branch_id)
			->get('stock_activities')
			->result();
	 
		$counts = [
			'total'    => $total,
			'pending'  => 0,
			'approved' => 0,
			'rejected' => 0,
		];
	 
		foreach ($rows as $row) {
			$key = strtolower($row->status ?? '');
			if (isset($counts[$key])) {
				$counts[$key] = (int)$row->cnt;
			}
		}
	 
		return $counts;
	}
	 
	// ─── LIST WITH JOINED NAMES ───
	// Replaces the plain get_transactions() for the list view
	public function get_transactions_with_names($filters = []) {
    $branch_id = $this->getCurrentBranchId();
	 
		$this->db->select('
			sa.*,
			s_from.store_name   AS warehouse_from,
			s_to.store_name     AS warehouse_to,
			c.cus_name          AS customer,
			u.full_name as created_by_name
		');
		$this->db->from('stock_activities sa');
		$this->db->join('stores  s_from', 's_from.store_id  = sa.store_id',    'left');
		$this->db->join('stores  s_to',   's_to.store_id    = sa.to_store_id', 'left');
		$this->db->join('customer c',     'c.cus_id         = sa.cus_id',      'left');
		$this->db->join('user u', 'u.user_id = sa.create_by', 'left');
    
    // ADD BRANCH FILTER
    if ($branch_id) {
        $this->db->where('sa.branch_id', $branch_id);  // Add branch_id column to stock_activities
    }
	 
		if (!empty($filters['type'])) {
			$this->db->where('sa.act_type', $filters['type']);
		}
		if (!empty($filters['status'])) {
			$this->db->where('sa.status', $filters['status']);
		}
		if (!empty($filters['store_id'])) {
			$this->db->where('sa.store_id', $filters['store_id']);
		}
		if (!empty($filters['from'])) {
			$this->db->where('sa.st_act_date >=', $filters['from'] . ' 00:00:00');
		}
		if (!empty($filters['to'])) {
			$this->db->where('sa.st_act_date <=', $filters['to'] . ' 23:59:59');
		}
		if (!empty($filters['search'])) {
			$this->db->like('sa.note', $filters['search']);
		}
	 
		// Date range string from filter (e.g. "01/05/2026 - 31/05/2026")
		if (!empty($filters['date_range'])) {
			$parts = explode(' - ', $filters['date_range']);
			if (count($parts) === 2) {
				$from = date('Y-m-d', strtotime(trim($parts[0])));
				$to   = date('Y-m-d', strtotime(trim($parts[1])));
				$this->db->where('DATE(sa.st_act_date) >=', $from);
				$this->db->where('DATE(sa.st_act_date) <=', $to);
			}
		}
	 
		return $this->db
			->order_by('sa.st_act_date', 'DESC')
			->get()
			->result();
	}
	 
	// ─── get_transaction() – UPDATED to include item product names ───
	public function get_transaction($id) {
		$activity = $this->_get_activity($id);
		if (!$activity) return null;
		
		// Use unified table
		$items = $this->db
			->select('i.*, p.name as product_name, p.product_code, p.is_serial_trk, p.is_expiry_trk')
			->from('stock_transaction_items i')
			->join('products p', 'p.id = i.product_id', 'left')
			->where('i.fk_st_activity_id', $id)
			->get()
			->result();
		
		$activity->items         = $items;
		$activity->warehouse_from = $this->_get_store_name($activity->store_id);
		$activity->warehouse_to   = $this->_get_store_name($activity->to_store_id);
		$activity->customer       = $this->_get_customer_name($activity->cus_id);
		$activity->created_by_name = $this->_get_user_name($activity->create_by);
		
		return $activity;
	}   
}