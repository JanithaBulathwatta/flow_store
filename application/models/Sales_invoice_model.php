<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Sales_invoice_model extends CI_Model {
		
		public function insert_invoice($data){
			$this->db->insert('sales_invoices', $data);
			return $this->db->insert_id();
		}

		public function update_invoice($id, $data){
			return $this->db->where('id',$id)->update('sales_invoices',$data);
		}
			
		public function getInvoiceWithItems($invoice_id)
		{
			// 1. Get invoice
			$invoice = $this->db->where('id', $invoice_id)->get('sales_invoices')->row();

			if (!$invoice) {
				return ['status' => 'error', 'message' => 'Invoice not found'];
			}

			// 2. Only allow DRAFT edit load (your requirement)
			/*$status = $invoice->STATUS ?? $invoice->status ?? 'DRAFT';
			if ($status !== 'DRAFT') {
				return ['status' => 'error', 'message' => 'Only draft invoices can be edited'];
			}*/
			$status = strtoupper($invoice->STATUS ?? $invoice->status ?? 'DRAFT');
			if (!in_array($status, ['DRAFT', 'QUOTATION'])) {
				return ['status' => 'error', 'message' => 'Only draft or quotation invoices can be edited'];
			}
			

			// 3. Get items
			$items = $this->db
				->where('invoice_id', $invoice_id)
				->get('sales_invoice_items')
				->result();

			$resultItems = [];

			foreach ($items as $item) {

				// 4. Get serials
				$serials = $this->db
					->select('serial_no')
					//->where('invoice_item_id', $item->id)
					->where('product_id', $item->id)
					->get('product_serial_numbers')
					->result_array();

				$serialList = array_column($serials, 'serial_no');

				// 5. Get batches
				$batches = $this->db
					//->where('invoice_item_id', $item->id)
					->where('product_id', $item->id)
					->get('product_batches')
					->result();

				$batchList = [];

				foreach ($batches as $b) {
					$batchList[] = [
						'id'       => $b->id,
						'batchNo'  => $b->batch_no,
						'qty'      => $b->qty,
						'expDate'  => $b->expiry_date
					];
				}	
		
				// 6. Convert to FRONTEND FORMAT
				$resultItems[] = [
					'id'           => 'P' . str_pad($item->product_id, 3, '0', STR_PAD_LEFT),
					'code'         => 'P' . str_pad($item->product_id, 3, '0', STR_PAD_LEFT),
					'name'         => $item->product_name,
					'icon'         => '📦',
					'unit'         => $item->unit,
					'category'     => '',

					// pricing
					'retailPrice'  => (float)$item->unit_price,
					'wholesalePrice'=> (float)$item->unit_price,
					'specialPrice' => (float)$item->unit_price,
					'discount_value' => (float)$item->discount_value,
					'line_total' => (float)$item->line_total,

					// stock (you can calculate later)
					'stock'        => 0,
					'qty'        => $item->qty,
				
					// serial / batch flags
					'isSerial'     => (int)$item->has_serial,
					'isBatch'      => (int)$item->has_batch,
					'hasExpiry'    => 0,
					'hasWarranty'  => 0,
					'warrantyMonths'=> 0,
					'warrantyType' => null,

					// dynamic data
					'serials'      => !empty($serialList) ? $serialList : null,
					'batches'      => !empty($batchList) ? $batchList : null,

					'description'  => ''
				];
			}

			return [
				'status'  => 'success',
				'invoice' => $invoice,
				'items'   => $resultItems
			];
		}
		
		
		public function get_invoice_details($id) {
			return $this->db->select('si.*, c.cus_name, c.company_name, c.cus_phone, c.cus_email, c.cus_address, u.full_name as creator_name')
				->from('sales_invoices si')
				->join('customer c', 'c.cus_id = si.customer_id', 'left')
				->join('user u', 'u.user_id = si.created_by', 'left')
				->where('si.id', $id)
				->get()->row();
		}

		public function get_invoice_items_simple($id) {
			return $this->db->where('invoice_id', $id)->get('sales_invoice_items')->result();
		}

		public function get_invoice_payments($id) {
			return $this->db->select('sp.id as payment_id, sp.payment_date, spi.payment_method, spi.amount, spi.reference_no')
				->from('sales_payments sp')
				->join('sales_payment_items spi', 'spi.payment_id = sp.id')
				->where('sp.invoice_id', $id)
				->order_by('sp.payment_date', 'DESC')
				->get()->result();
		}
		
		public function update_stock_for_sale($invoice_id)
		{
			$this->db->trans_start();
			
			try {
				$invoice = $this->db->where('id', $invoice_id)->get('sales_invoices')->row();
				if (!$invoice) {
					throw new Exception("Invoice not found");
				}
				
				$warehouse_id = $invoice->warehouse_id;
				$user_id = $this->session->userdata('user_id');
				
				$items = $this->db->select('si.*')
								 ->where('si.invoice_id', $invoice_id)
								 ->get('sales_invoice_items si')
								 ->result();
				
				//print_r($items);
				//exit;
				
				foreach ($items as $item) {
					$sold_qty = (float)$item->qty;
					$product_id = $item->product_id;
					
					// Get product details
					$product = $this->db->select('is_batch, is_auto_batch, name')
										->where('id', $product_id)
										->get('products')
										->row();
					
					// Check if product has batch (either manual batch OR auto batch)
					$has_batch = ($product && ($product->is_batch == 1 || $product->is_auto_batch == 1));
					
					if ($has_batch) {
						
						// =============================================
						// FOR BATCH PRODUCTS (Manual + Auto Batch)
						// =============================================
						$remaining_to_sell = $sold_qty;
						
						// Get batches from product_batches table (FIFO)
						$batches = $this->db->select('id, batch_no, qty, expiry_date, warehouse_id, product_id')
										   ->where('product_id', $product_id)
										   ->where('warehouse_id', $warehouse_id)
										   ->where('qty >', 0)
										   ->order_by('expiry_date', 'ASC')
										   ->get('product_batches')
										   ->result();
									
						
						//echo $this->db->last_query();
									
						if (empty($batches)) {
							//print_r($batches);
							throw new Exception("No batches found for product: {$product->name}");
						}
						
						// Calculate total available stock from batches
						$total_batch_qty = array_sum(array_column($batches, 'qty'));
						
						if ($total_batch_qty < $sold_qty) {
							throw new Exception("Insufficient batch stock for {$product->name}. Available: $total_batch_qty, Needed: $sold_qty");
						}
						
						foreach ($batches as $batch) {
							if ($remaining_to_sell <= 0) break;
							
							$take_from_batch = min($batch->qty, $remaining_to_sell);
							$new_batch_qty = $batch->qty - $take_from_batch;
							$remaining_to_sell -= $take_from_batch;
							
							// STEP 1: UPDATE product_batches table (physical stock)
							$this->db->where('id', $batch->id)
									 ->update('product_batches', [
										 'qty' => $new_batch_qty,
										 'updated_at' => date('Y-m-d H:i:s')
									 ]);
							
							// STEP 2: UPDATE inventory_stock for this batch (available stock)
							// Available stock = physical stock - reserved_qty
							// When selling, we reduce both physical and available by same amount
							// reserved_qty remains unchanged
							$stock_record = $this->db->select('id, qty, reserved_qty')
													->where('product_id', $product_id)
													->where('warehouse_id', $warehouse_id)
													->where('batch_id', $batch->id)
													->get('inventory_stock')
													->row();
							
							if ($stock_record) {
								// Calculate new available stock (qty column)
								$new_available_qty = $stock_record->qty - $take_from_batch;
								
								$this->db->where('id', $stock_record->id)
										 ->update('inventory_stock', [
											 'qty' => $new_available_qty,
											 'updated_at' => date('Y-m-d H:i:s')
										 ]);
							} else {
								// Create inventory_stock record for this batch
								// New available qty = new_batch_qty - reserved_qty (assuming reserved_qty = 0 for new)
								$this->db->insert('inventory_stock', [
									'product_id' => $product_id,
									'warehouse_id' => $warehouse_id,
									'batch_id' => $batch->id,
									'qty' => $new_batch_qty, // Available stock equals physical stock initially
									'reserved_qty' => 0,
									'updated_at' => date('Y-m-d H:i:s')
								]);
							}
							
							error_log("Batch {$batch->batch_no}: Physical stock: {$batch->qty} -> {$new_batch_qty}, Available: reduced by $take_from_batch");
						}
						
					} else {
						// =============================================
						// FOR NON-BATCH PRODUCTS
						// =============================================
						$stock_record = $this->db->select('id, qty, reserved_qty')
												->where('product_id', $product_id)
												->where('warehouse_id', $warehouse_id)
												->where('batch_id IS NULL')
												->get('inventory_stock')
												->row();
						
						if (!$stock_record) {
							throw new Exception("No stock record found for product: {$product->name}");
						}
						
						$current_stock = (float)$stock_record->qty;
						$reserved_qty = (float)$stock_record->reserved_qty;
						
						// Available stock = qty - reserved_qty
						$available_stock = $current_stock - $reserved_qty;
						
						if ($available_stock < $sold_qty) {
							throw new Exception("Insufficient stock for product: {$product->name}. Available: $available_stock, Needed: $sold_qty");
						}
						
						// Deduct from main qty column only (available stock)
						$new_stock = $current_stock - $sold_qty;
						
						$this->db->where('id', $stock_record->id)
								 ->update('inventory_stock', [
									 'qty' => $new_stock,
									 'updated_at' => date('Y-m-d H:i:s')
								 ]);
						
						error_log("Product {$product->name}: Available stock reduced from $current_stock to $new_stock");
					}
					
					// Insert stock log
					$this->db->insert('inventory_stock_log', [
						'product_id' => $product_id,
						'warehouse_id' => $warehouse_id,
						'old_qty' => $current_stock ?? $total_batch_qty ?? 0,
						'new_qty' => ($current_stock ?? $total_batch_qty ?? 0) - $sold_qty,
						'reference_type' => 'SALE_INVOICE',
						'reference_id' => $invoice_id,
						'changed_at' => date('Y-m-d H:i:s'),
						'changed_by' => $user_id
					]);
					
					// Insert inventory transaction
					$this->db->insert('inventory_transactions', [
						'product_id' => $product_id,
						'warehouse_id' => $warehouse_id,
						'transaction_type' => 'SALE',
						'reference_type' => 'INVOICE',
						'reference_id' => $invoice_id,
						'qty' => -$sold_qty,
						'unit_cost' => $item->unit_price,
						'total_cost' => -($item->unit_price * $sold_qty),
						'transaction_date' => date('Y-m-d H:i:s'),
						'created_by' => $user_id
					]);
				}
				
				$this->db->trans_complete();
				
				if ($this->db->trans_status()) {
					error_log("Stock update COMPLETED for invoice: $invoice_id");
					return true;
				} else {
					error_log("Stock update FAILED for invoice: $invoice_id");
					return false;
				}
				
			} catch (Exception $e) {
				$this->db->trans_rollback();
				error_log("Stock update FAILED: " . $e->getMessage());
				return false;
			}
		}

private function getCurrentStock($product_id, $warehouse_id)
{
    $this->db->select('COALESCE(SUM(qty), 0) as total_qty')
             ->where('product_id', $product_id)
             ->where('warehouse_id', $warehouse_id)
             ->where('batch_id IS NULL');
    
    $stock = $this->db->get('inventory_stock')->row();
    return $stock ? (float)$stock->total_qty : 0;
}

private function updateStock($product_id, $warehouse_id, $qty_change)
{
    $this->db->where('product_id', $product_id)
             ->where('warehouse_id', $warehouse_id)
             ->where('batch_id IS NULL');
    
    $stock = $this->db->get('inventory_stock')->row();
    
    if ($stock) {
        $new_qty = $stock->qty + $qty_change;
        $this->db->where('id', $stock->id)
                 ->update('inventory_stock', [
                     'qty' => $new_qty, 
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
    } else {
        $this->db->insert('inventory_stock', [
            'product_id' => $product_id,
            'warehouse_id' => $warehouse_id,
            'batch_id' => null,
            'qty' => $qty_change,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
    
    
    /** 
     * Mark serial numbers as sold
     */
    private function markSerialsAsSold($invoice_item_id, $warehouse_id)
    {
        // Get serials for this invoice item
        $serials = $this->db->select('serial_no')
                            ->where('invoice_item_id', $invoice_item_id)
                            ->get('sales_invoice_item_serials')
                            ->result();
        
        foreach ($serials as $serial) {
            // Update serial status to SOLD
            $this->db->where('serial_no', $serial->serial_no)
                     ->where('warehouse_id', $warehouse_id)
                     ->update('product_serial_numbers', [
                         'status' => 'SOLD',
                         'sold_date' => date('Y-m-d H:i:s'),
                         'sold_invoice_id' => $invoice_item_id
                     ]);
        }
    }
    
    /**
     * Update batch quantity
     */
    private function updateBatchQuantity($batch_id, $qty_change, $warehouse_id)
    {
        
		// print_r($batch_id);
		// print_r($qty_change);
		// print_r($warehouse_id);
		// print_r('case');
		// exit; 
		
		$batch = $this->db->where('id', $batch_id)
                          ->where('warehouse_id', $warehouse_id)
                          ->get('product_batches')
                          ->row();
        
		
        if ($batch) {
            $new_qty = $batch->qty + $qty_change;
            
            if ($new_qty < 0) {
                throw new Exception("Insufficient batch stock for batch: " . $batch->batch_no);
            }
            
            $this->db->where('id', $batch_id)
                     ->update('product_batches', [
                         'qty' => $new_qty,
                         'updated_at' => date('Y-m-d H:i:s')
                     ]);
        }
    }
    
    // =============================================
    // REVERSE STOCK (for cancelled/returned sales)
    // =============================================
    
    /**
     * Reverse stock when sale is cancelled/returned
     * This adds stock back to inventory
     */
    public function reverse_stock_for_sale($invoice_id)
    {
        $this->db->trans_start();
        
        try {
            $invoice = $this->db->where('id', $invoice_id)->get('sales_invoices')->row();
            if (!$invoice) {
                throw new Exception("Invoice not found");
            }
            
            $warehouse_id = $invoice->warehouse_id;
            $items = $this->db->where('invoice_id', $invoice_id)
                              ->get('sales_invoice_items')
                              ->result();
            
            foreach ($items as $item) {
                $returned_qty = $item->qty;
                $product_id = $item->product_id;
                
                // Get batch ID
                $batch_id = null;
                $batch = $this->db->select('batch_id')
                                  ->where('invoice_item_id', $item->id)
                                  ->get('sales_invoice_item_batches')
                                  ->row();
                $batch_id = $batch ? $batch->batch_id : null;
                
                // Get current stock
                $old_qty = $this->getCurrentStock($product_id, $warehouse_id, $batch_id);
                
                // Add stock back (positive change)
                $new_qty = $old_qty + $returned_qty;
                
                // Update inventory_stock
                $this->updateStock($product_id, $warehouse_id, $returned_qty, $batch_id);
                
                // Insert stock log
                $this->db->insert('inventory_stock_log', [
                    'product_id' => $product_id,
                    'warehouse_id' => $warehouse_id,
                    'batch_id' => $batch_id,
                    'old_qty' => $old_qty,
                    'new_qty' => $new_qty,
                    'reference_type' => 'SALE_RETURN',
                    'reference_id' => $invoice_id,
                    'changed_at' => date('Y-m-d H:i:s'),
                    'changed_by' => $this->session->userdata('user_id')
                ]);
                
                // Insert transaction
                $this->db->insert('inventory_transactions', [
                    'product_id' => $product_id,
                    'warehouse_id' => $warehouse_id,
                    'transaction_type' => 'SALE_RETURN',
                    'reference_type' => 'INVOICE',
                    'reference_id' => $invoice_id,
                    
                    'qty' => $returned_qty,
                    'unit_cost' => $item->unit_price,
                    'total_cost' => $item->unit_price * $returned_qty,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_id')
                ]);
                
                // Mark serials as available again
                $this->markSerialsAsAvailable($item->id, $warehouse_id);
                
                // Update batch quantity
                if ($batch_id) {
                    $this->updateBatchQuantity($batch_id, $returned_qty, $warehouse_id);
                }
            }
            
            $this->db->trans_complete();
            return $this->db->trans_status();
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            error_log("Stock reversal failed: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Mark serials as available again (for returns)
     */
    private function markSerialsAsAvailable($invoice_item_id, $warehouse_id)
    {
        $this->db->where('invoice_item_id', $invoice_item_id)
                 ->update('product_serial_numbers', [
                     'status' => 'AVAILABLE',
                     'sold_date' => null,
                     'sold_invoice_id' => null
                 ]);
    }
	
	// sales payment function 
	
	/*public function create_payment()
	{
		// 1. Get the raw input
		$invoice_ids_raw = $this->input->post('selected_invoice_ids');
		
		// 2. Validation: If empty, return false immediately so the controller shows the error
		if (empty($invoice_ids_raw)) {
			return false;
		}

		$invoice_ids = explode(',', $invoice_ids_raw);
		
		// 3. Start Transaction
		$this->db->trans_start();

		$cash_amt     = (float)$this->input->post('cash_payment_amount');
		$transfer_amt = (float)$this->input->post('transfer_payment_amount');
		$cheque_amt   = (float)$this->input->post('cheque_payment_amount');
		$total_payment = $cash_amt + $transfer_amt + $cheque_amt;

		if ($total_payment <= 0) return false;

		// 4. Insert Master Record
		$payment_master = [
			'invoice_id'   => $invoice_ids[0], 
			'payment_date' => $this->input->post('payment_date') ?: date('Y-m-d H:i:s'),
			'total_amount' => $total_payment,
			'created_by'   => $this->session->userdata('user_id'),
			'created_at'   => date('Y-m-d H:i:s')
		];
		$this->db->insert('sales_payments', $payment_master);
		$payment_id = $this->db->insert_id();

		// 5. Insert Payment Items (CASH/BANK/CHEQUE)
		if ($cash_amt > 0) {
			$this->db->insert('sales_payment_items', [
				'payment_id' => $payment_id, 'payment_method' => 'CASH',
				'amount' => $cash_amt, 'account_id' => $this->input->post('cash_account_id'),
				'note' => $this->input->post('payment_remarks'), 'created_at' => date('Y-m-d H:i:s')
			]);
		}
		if ($transfer_amt > 0) {
			$this->db->insert('sales_payment_items', [
				'payment_id' => $payment_id, 'payment_method' => 'BANK',
				'amount' => $transfer_amt, 'account_id' => $this->input->post('transfer_bank_account_id'),
				'reference_no' => $this->input->post('transfer_ref_no'),'bank_name' => $this->input->post('bank_name'),
				'created_at' => date('Y-m-d H:i:s')
			]);
		}
		if ($cheque_amt > 0) {
			$this->db->insert('sales_payment_items', [
				'payment_id' => $payment_id, 'payment_method' => 'CHEQUE',
				'amount' => $cheque_amt, 'account_id' => $this->input->post('cheque_bank_account_id'),
				'cheque_no' => $this->input->post('cheque_no'), 'cheque_date' => $this->input->post('cheque_date') ?: NULL,
				'bank_name' => $this->input->post('cheque_bank_name'), 'created_at' => date('Y-m-d H:i:s')
			]);
		}

		// 6. Allocation Logic
		$remaining = $total_payment;
		foreach ($invoice_ids as $inv_id) {
			if ($remaining <= 0) break;
			$inv = $this->db->get_where('sales_invoices', ['id' => $inv_id])->row();
			if (!$inv) continue;

			$allocate = min($remaining, (float)$inv->balance_amount);
			if ($allocate > 0) {
				$paid_new = (float)$inv->paid_amount + $allocate;
				$bal_new = (float)$inv->grand_total - $paid_new;
				$this->db->where('id', $inv_id)->update('sales_invoices', [
					'paid_amount' => $paid_new,
					'balance_amount' => max(0, $bal_new),
					'payment_status' => ($bal_new <= 0) ? 'PAID' : 'PARTIAL',
					'updated_at' => date('Y-m-d H:i:s')
				]);
				$remaining -= $allocate;
			}
		}

		$this->db->trans_complete();
		return $this->db->trans_status();
	}*/
	
	
	public function create_payment()
	{
		// 1. Get the raw input
		$invoice_ids_raw = $this->input->post('selected_invoice_ids');
		
		// 2. Validation: If empty, return false immediately
		if (empty($invoice_ids_raw)) {
			return false;
		}

		$invoice_ids = explode(',', $invoice_ids_raw);
		
		// 3. Start Transaction
		$this->db->trans_start();

		$user_id      = $this->session->userdata('user_id');
		$cash_amt     = (float)$this->input->post('cash_payment_amount');
		$transfer_amt = (float)$this->input->post('transfer_payment_amount');
		$cheque_amt   = (float)$this->input->post('cheque_payment_amount');
		$total_payment = $cash_amt + $transfer_amt + $cheque_amt;
		$remarks      = $this->input->post('payment_remarks');

		if ($total_payment <= 0) return false;

		// --- FETCH CUSTOMER NAME FOR CHEQUE PAYEE ---
		// We get this from the first invoice provided in the selection
		$this->db->select('c.cus_name as customer_name');
		$this->db->from('sales_invoices i');
		$this->db->join('customer c', 'c.cus_id = i.customer_id'); 
		$this->db->where('i.id', $invoice_ids[0]);
		$customer_query = $this->db->get()->row();
		$payee_name = $customer_query ? $customer_query->customer_name : 'Walk-in Customer';

		// 4. Insert Master Record
		$payment_master = [
			'invoice_id'   => $invoice_ids[0], 
			'payment_date' => $this->input->post('payment_date') ?: date('Y-m-d H:i:s'),
			'total_amount' => $total_payment,
			'created_by'   => $user_id,
			'created_at'   => date('Y-m-d H:i:s')
		];
		$this->db->insert('sales_payments', $payment_master);
		$payment_id = $this->db->insert_id();

		// 5. Insert Payment Items (CASH/BANK/CHEQUE)
		if ($cash_amt > 0) {
			$this->db->insert('sales_payment_items', [
				'payment_id' => $payment_id, 'payment_method' => 'CASH',
				'amount' => $cash_amt, 'account_id' => $this->input->post('cash_account_id'),
				'note' => $remarks, 'created_at' => date('Y-m-d H:i:s')
			]);
		}
		if ($transfer_amt > 0) {
			$this->db->insert('sales_payment_items', [
				'payment_id' => $payment_id, 'payment_method' => 'BANK',
				'amount' => $transfer_amt, 'account_id' => $this->input->post('transfer_bank_account_id'),
				'reference_no' => $this->input->post('transfer_ref_no'), 'bank_name' => $this->input->post('bank_name'),
				'created_at' => date('Y-m-d H:i:s')
			]);
		}
		
		/*if ($cheque_amt > 0) {
			$cheque_no = $this->input->post('cheque_no');
			//$account_id = $this->input->post('cheque_bank_account_id');
			$cheque_date = $this->input->post('cheque_date');

			$this->db->insert('sales_payment_items', [
				'payment_id' => $payment_id, 'payment_method' => 'CHEQUE',
				'amount' => $cheque_amt, 
				//'account_id' => $account_id,
				'cheque_no' => $cheque_no, 'cheque_date' => $cheque_date ?: NULL,
				'bank_name' => $this->input->post('cheque_bank_name'), 'created_at' => date('Y-m-d H:i:s')
			]);

			// --- CHEQUE TABLE UPDATE LOGIC ---
			$cheque_update = [
				'cheque_date' => $cheque_date ?: NULL,
				'payee_name'  => $payee_name,
				'amount'      => $cheque_amt,
				'status'      => 'issued',
				'issued_by'   => $user_id,
				'issued_date' => date('Y-m-d H:i:s'),
				'remarks'     => $remarks,
				'updated_by'  => $user_id
			];

			//$this->db->where('bank_account_id', $account_id);
			$this->db->where('cheque_no', $cheque_no);
			$this->db->update('cheques', $cheque_update);
		}*/

		// 6. Allocation Logic
		$remaining = $total_payment;
		foreach ($invoice_ids as $inv_id) {
			if ($remaining <= 0) break;
			$inv = $this->db->get_where('sales_invoices', ['id' => $inv_id])->row();
			if (!$inv) continue;

			$allocate = min($remaining, (float)$inv->balance_amount);
			if ($allocate > 0) {
				$paid_new = (float)$inv->paid_amount + $allocate;
				$bal_new = (float)$inv->grand_total - $paid_new;
				$this->db->where('id', $inv_id)->update('sales_invoices', [
					'paid_amount' => $paid_new,
					'balance_amount' => max(0, $bal_new),
					'payment_status' => ($bal_new <= 0) ? 'PAID' : 'PARTIAL',
					'updated_at' => date('Y-m-d H:i:s')
				]);
				$remaining -= $allocate;
			}
		}
		
		//for activity log entry
		// 	
		//$customer    = $this->Customer_model->get_by_id($customer_id);
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$msg = "pay  [Invoice ID:" . $invoice_ids_raw . "]";
		
		// Define the number and email
		$phone      = isset($customer->cus_phone) ? $customer->cus_phone : "";
		$email      = isset($customer->cus_email) ? $customer->cus_email : "";
		
		$this->Activity_log_m->addLog($user_id_fk, $user_type, 'Sales Invoice Module', 'Pay To customer', 'INSERT', true, 1, $phone, $email, $msg);
		//end of activity log

		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	// Check if the cheque is availability
	/*public function is_cheque_valid($cheque_no, $account_id) {
		$this->db->where('cheque_no', $cheque_no);
		$this->db->where('bank_account_id', $account_id);
		$this->db->where('status', 'unused'); // Only allow unused cheques
		$query = $this->db->get('cheques');

		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}*/
	
	public function is_cheque_valid($cheque_no) {
		$this->db->where('cheque_no', $cheque_no);
		//$this->db->where('bank_account_id', $account_id);
		$this->db->where('status', 'unused'); // Only allow unused cheques
		$query = $this->db->get('cheques');

		if ($query->num_rows() > 0) {
			return true;
		}
		return false;
	}
	
}