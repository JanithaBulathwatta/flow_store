<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_invoice_model extends CI_Model {

    public function generate_invoice_no() {
        $prefix = 'INV-' . date('Ym') . '-';
        $last = $this->db->select('invoice_no')
                          ->like('invoice_no', $prefix, 'after')
                          ->order_by('id', 'DESC')
                          ->limit(1)
                          ->get('project_invoices')
                          ->row();
        $next = 1;
        if ($last) {
            $parts = explode('-', $last->invoice_no);
            $next = intval(end($parts)) + 1;
        }
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    // public function save_invoice($data, $items) {
		// $this->db->trans_start();
		// $data['invoice_no'] = $this->generate_invoice_no();
		// $data['total_items'] = count($items);

		// $total_qty = 0;
		// $sub_total = 0; // sum of line totals, i.e. AFTER line-level discounts
		// foreach ($items as $it) {
			// $total_qty += $it['qty'];
			// $sub_total += $it['line_total'];
		// }

		//clamp invoice-level discount so it never exceeds sub total or goes negative
		// $invoice_discount = $data['discount'] ?? 0;
		// if ($invoice_discount < 0) $invoice_discount = 0;
		// if ($invoice_discount > $sub_total) $invoice_discount = $sub_total;

		// $grand_total = $sub_total - $invoice_discount;

		// $data['total_qty']   = $total_qty;
		// $data['sub_total']   = $sub_total;
		// $data['discount']    = $invoice_discount;
		// $data['grand_total'] = $grand_total;
		// $data['balance']     = $grand_total - ($data['paid_amount'] ?? 0);
		// $data['status']      = $this->resolve_status($data['balance'], $data['paid_amount'], $grand_total);

		// $this->db->insert('project_invoices', $data);
		// $invoice_id = $this->db->insert_id();

		// foreach ($items as $it) {
			// $it['p_invoice_id'] = $invoice_id;
			// $this->db->insert('project_invoice_items', $it);
		// }

		// $this->db->trans_complete();
		// return $this->db->trans_status() ? $invoice_id : false;
	// }
	
	// public function save_invoice($data, $items)
	// {
		// $this->db->trans_start();

		// /*
		// |--------------------------------------------------------------------------
		// | Invoice Number
		// |--------------------------------------------------------------------------
		// */
		// $invoice_no = $this->generate_invoice_no();

		// /*
		// |--------------------------------------------------------------------------
		// | Calculate Totals
		// |--------------------------------------------------------------------------
		// */
		// $total_items = count($items);
		// $total_qty = 0;
		// $subtotal = 0;
		// $line_discount_total = 0;

		// foreach ($items as $item) {

			// $qty      = (float) $item['qty'];
			// $price    = (float) $item['unit_price'];
			// $discount = (float) ($item['discount'] ?? 0);

			// $total_qty += $qty;

			//Before line discount
			// $subtotal += ($qty * $price);

			//Total line discounts
			// $line_discount_total += $discount;
		// }

		// /*
		// |--------------------------------------------------------------------------
		// | Amount After Line Discount
		// |--------------------------------------------------------------------------
		// */
		// $after_line_discount = $subtotal - $line_discount_total;

		// if ($after_line_discount < 0) {
			// $after_line_discount = 0;
		// }

		// /*
		// |--------------------------------------------------------------------------
		// | Invoice Discount
		// |--------------------------------------------------------------------------
		// */
		// $invoice_discount = (float) ($data['discount'] ?? 0);

		// if ($invoice_discount < 0) {
			// $invoice_discount = 0;
		// }

		// if ($invoice_discount > $after_line_discount) {
			// $invoice_discount = $after_line_discount;
		// }

		// /*
		// |--------------------------------------------------------------------------
		// | Grand Total
		// |--------------------------------------------------------------------------
		// */
		// $grand_total = $after_line_discount - $invoice_discount;

		// if ($grand_total < 0) {
			// $grand_total = 0;
		// }

		// /*
		// |--------------------------------------------------------------------------
		// | Paid Amount
		// |--------------------------------------------------------------------------
		// */
		// $paid_amount = (float) ($data['paid_amount'] ?? 0);

		// if ($paid_amount < 0) {
			// $paid_amount = 0;
		// }

		// if ($paid_amount > $grand_total) {
			// $paid_amount = $grand_total;
		// }

		// $balance = $grand_total - $paid_amount;

		// /*
		// |--------------------------------------------------------------------------
		// | Payment Status
		// |--------------------------------------------------------------------------
		// */
		// if ($paid_amount <= 0) {

			// $payment_status = 'unpaid';

		// } elseif ($paid_amount >= $grand_total) {

			// $payment_status = 'paid';

		// } else {

			// $payment_status = 'partial';
		// }


		// /*
		// |--------------------------------------------------------------------------
		// | 1. SAVE PROJECT INVOICE
		// |--------------------------------------------------------------------------
		// */

		// $project_invoice_data = [

			// 'project_id'  => $data['project_id'],

			// 'invoice_no'  => $invoice_no,

			// 'invoice_date' => $data['invoice_date'],

			// 'due_date' => !empty($data['due_date'])
				// ? $data['due_date']
				// : null,

			// 'total_items' => $total_items,

			// 'total_qty' => $total_qty,

			// 'discount' => $invoice_discount,

			// 'sub_total' => $after_line_discount,

			// 'grand_total' => $grand_total,

			// 'paid_amount' => $paid_amount,

			// 'balance' => $balance,

			// 'notes' => $data['notes'] ?? null,

			// 'status' => $payment_status
		// ];

		// $this->db->insert(
			// 'project_invoices',
			// $project_invoice_data
		// );

		// if ($this->db->trans_status() === false) {

			// $this->db->trans_rollback();

			// return false;
		// }

		// $project_invoice_id = $this->db->insert_id();


		// /*
		// |--------------------------------------------------------------------------
		// | 2. SAVE PROJECT INVOICE ITEMS
		// |--------------------------------------------------------------------------
		// */

		// foreach ($items as $item) {

			// $project_item = [

				// 'p_invoice_id' => $project_invoice_id,

				// 'product_id' => $item['product_id'],

				// 'product_name' => $item['product_name'],

				// 'product_code' => $item['product_code'] ?? null,

				// 'unit_price' => $item['unit_price'],

				// 'qty' => $item['qty'],

				// 'discount' => $item['discount'],

				// 'line_total' => $item['line_total']
			// ];

			// $this->db->insert(
				// 'project_invoice_items',
				// $project_item
			// );

			// if ($this->db->trans_status() === false) {

				// $this->db->trans_rollback();

				// return false;
			// }
		// }


		// /*
		// |--------------------------------------------------------------------------
		// | 3. SAVE SALES INVOICE
		// |--------------------------------------------------------------------------
		// |
		// | Project invoice does not use customer.
		// | customer_id must therefore be NULL.
		// |
		// */

		// $sales_invoice_data = [

			// 'invoice_no' => $invoice_no,
			// 'customer_id' => 0,
			// 'warehouse_id' => $data['warehouse_id'],
			// 'invoice_date' => $data['invoice_date'],
			// 'due_date' => !empty($data['due_date'])
				// ? $data['due_date']
				// : null,

			// 'total_items' => $total_items,
			// 'total_qty' => $total_qty,
			// 'total_free_qty' => 0,
			// 'subtotal' => $subtotal,
			// 'line_discount_total' => $line_discount_total,
			// 'bill_discount_value' => $invoice_discount,
			// 'bill_discount_type' => 'AMOUNT',
			// 'tax_total' => 0,
			// 'grand_total' => $grand_total,
			// 'paid_amount' => $paid_amount,
			// 'balance_amount' => $balance,
			// 'payment_status' => strtoupper($payment_status),
			// 'status' => 'PROJECT',
			// 'remarks' => $data['notes'] ?? null,
			// 'created_by' => $this->session->userdata('user_id'),
			// 'invoice_type' => 'PROJECT',
			// 'project_id' => $data['project_id'],
			// 'branch_id' => $this->session->userdata('branch'),
			// 'dis_val' => $invoice_discount
		// ];

		// $this->db->insert('sales_invoices',$sales_invoice_data);

		// if ($this->db->trans_status() === false) {

			// $this->db->trans_rollback();

			// return false;
		// }

		// $sales_invoice_id = $this->db->insert_id();


		// /*
		// |--------------------------------------------------------------------------
		// | 4. SAVE SALES INVOICE ITEMS
		// |--------------------------------------------------------------------------
		// */

		// foreach ($items as $item) {

			// $sales_item = [

				// 'invoice_id' => $sales_invoice_id,
				// 'product_id' => $item['product_id'],
				// 'product_name' => $item['product_name'],
				// 'unit' => null,
				// 'qty' => $item['qty'],
				// 'free_qty' => 0,
				// 'unit_price' => $item['unit_price'],
				// 'discount_value' => $item['discount'],
				// 'discount_type' => 'AMOUNT',
				// 'tax_value' => 0,
				// 'line_total' => $item['line_total'],
				// 'has_batch' => 0,
				// 'has_serial' => 0
			// ];

			// $this->db->insert('sales_invoice_items',$sales_item);

			// if ($this->db->trans_status() === false) {

				// $this->db->trans_rollback();

				// return false;
			// }
		// }


		// /*
		// |--------------------------------------------------------------------------
		// | 5. SAVE PAYMENT
		// |--------------------------------------------------------------------------
		// */

		//if ($paid_amount > 0) {
			
			// $payment_data = [

				// 'invoice_id' => $sales_invoice_id,

				// 'payment_date' => date('Y-m-d H:i:s'),

				// 'total_amount' => $paid_amount,

				// 'created_by' => $this->session->userdata('user_id'),

				// 'branch_id' => $data['branch_id'] ?? null
			// ];

			// $this->db->insert(
				// 'sales_payments',
				// $payment_data
			// );

			// if ($this->db->trans_status() === false) {

				// $this->db->trans_rollback();

				// return false;
			// }

			// $payment_id = $this->db->insert_id();


			// /*
			// |--------------------------------------------------------------------------
			// | 6. SAVE PAYMENT ITEM
			// |--------------------------------------------------------------------------
			// |
			// | Current modal doesn't have payment method.
			// | Defaulting to CASH.
			// |
			// */

			// $payment_item_data = [

				// 'payment_id' => $payment_id,
				// 'payment_method' => 'CASH',
				// 'account_id' => null,
				// 'amount' => $paid_amount,
				// 'reference_no' => null,
				// 'cheque_no' => null,
				// 'cheque_date' => null,
				// 'bank_name' => null,
				// 'note' => 'Project invoice payment',
				// 'card_number' => null,
				// 'cheque_status' => 'PENDING'
			// ];

			// $this->db->insert('sales_payment_items',$payment_item_data);

			// if ($this->db->trans_status() === false) {
				// $this->db->trans_rollback();
				// return false;
			// }
		//}


		// /*
		// |--------------------------------------------------------------------------
		// | Complete Transaction
		// |--------------------------------------------------------------------------
		// */

		// $this->db->trans_complete();

		// if ($this->db->trans_status() === false) {
			// return false;
		// }

		// /*
		// |--------------------------------------------------------------------------
		// | Return SALES invoice ID
		// |--------------------------------------------------------------------------
		// */

		// return $sales_invoice_id;
	// }	

	public function save_invoice($data, $items, $payments = [])
	{
		/*
		|--------------------------------------------------------------------------
		| START TRANSACTION
		|--------------------------------------------------------------------------
		*/
		$this->db->trans_start();
		/*
		|--------------------------------------------------------------------------
		| Invoice Number
		|--------------------------------------------------------------------------
		*/
		$invoice_no = $this->generate_invoice_no();
		/*
		|--------------------------------------------------------------------------
		| Calculate Invoice Totals
		|--------------------------------------------------------------------------
		*/

		$total_items = count($items);
		$total_qty = 0;
		$subtotal = 0;
		$line_discount_total = 0;

		foreach ($items as $item) {

			$qty = (float) $item['qty'];
			$price = (float) $item['unit_price'];
			$discount = (float) ($item['discount'] ?? 0);

			$total_qty += $qty;
			/*
			| Gross subtotal
			*/

			$subtotal += ($qty * $price);
			/*
			| Line discounts
			*/
			$line_discount_total += $discount;

		}


		/*
		|--------------------------------------------------------------------------
		| After Line Discount
		|--------------------------------------------------------------------------
		*/

		$after_line_discount = $subtotal - $line_discount_total;

		if ($after_line_discount < 0) {
			$after_line_discount = 0;
		}


		/*
		|--------------------------------------------------------------------------
		| Invoice Discount
		|--------------------------------------------------------------------------
		*/

		$invoice_discount = (float) ($data['discount'] ?? 0);

		if ($invoice_discount < 0) {
			$invoice_discount = 0;
		}


		if ($invoice_discount > $after_line_discount ) {
			$invoice_discount = $after_line_discount;
		}


		/*
		|--------------------------------------------------------------------------
		| Grand Total
		|--------------------------------------------------------------------------
		*/

		$grand_total = $after_line_discount - $invoice_discount;

		if ($grand_total < 0) {
			$grand_total = 0;
		}


		/*
		|--------------------------------------------------------------------------
		| Calculate Payments From Payment Rows
		|--------------------------------------------------------------------------
		*/

		$paid_amount = 0;
		foreach ($payments as $payment) {
			$paid_amount += (float) $payment['amount'];

		}

		/*
		|--------------------------------------------------------------------------
		| Safety: Payment Cannot Exceed Invoice
		|--------------------------------------------------------------------------
		*/
		
		if ($paid_amount > $grand_total) {
			$this->db->trans_rollback();
			return false;
		}


		/*
		|--------------------------------------------------------------------------
		| Balance
		|--------------------------------------------------------------------------
		*/

		$balance = $grand_total - $paid_amount;

		/*
		|--------------------------------------------------------------------------
		| Payment Status
		|--------------------------------------------------------------------------
		*/

		if ($paid_amount <= 0) {
			$payment_status = 'unpaid';
		} elseif ($paid_amount >= $grand_total) {
			$payment_status ='paid';
		} else {
			$payment_status = 'partial';

		}


		/*
		|--------------------------------------------------------------------------
		| 1. PROJECT INVOICE
		|--------------------------------------------------------------------------
		*/

		$project_invoice_data = ['project_id' =>$data['project_id'],
								'invoice_no' =>$invoice_no,
								'invoice_date' => $data['invoice_date'],
								'due_date' =>!empty($data['due_date'])? $data['due_date']: null,
								'total_items' =>$total_items,
								'total_qty' =>$total_qty,
								'discount' => $invoice_discount,
								/*| IMPORTANT sub_total here means amount after line discounts.*/
								'sub_total' => $after_line_discount,
								'grand_total' => $grand_total,
								'paid_amount' => $paid_amount,
								'balance' => $balance,
								'notes' => $data['notes'] ?? null,
								'status' => $payment_status
								];
								
		$this->db->insert('project_invoices',$project_invoice_data);

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		}

		$project_invoice_id = $this->db->insert_id();


		/*
		|--------------------------------------------------------------------------
		| 2. PROJECT INVOICE ITEMS
		|--------------------------------------------------------------------------
		*/
		foreach ($items as $item) {
			$project_item = [

				'p_invoice_id' => $project_invoice_id,
				'product_id' => $item['product_id'],
				'product_name' => $item['product_name'],
				'product_code' => $item['product_code'] ?? null,
				'unit_price' => $item['unit_price'],
				'qty' => $item['qty'],
				'discount' => $item['discount'],
				'line_total' => $item['line_total']
			];

			$this->db->insert('project_invoice_items', $project_item);

			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				return false;
			}
		}
		
		/*
		|--------------------------------------------------------------------------
		| 3. SALES INVOICE
		|--------------------------------------------------------------------------
		*/

		$sales_invoice_data = ['invoice_no' => $invoice_no, 
								'customer_id' => $_POST['customer_id'],
								'warehouse_id' => $data['warehouse_id'],
								'invoice_date' => $data['invoice_date'],
								'due_date' => !empty($data['due_date']) ? $data['due_date']: null,
								'total_items' => $total_items,
								'total_qty' => $total_qty,
								'total_free_qty' => 0,
								/*| Gross subtotal*/
								'subtotal' => $subtotal,
								'line_discount_total' => $line_discount_total,
								'bill_discount_value' => $invoice_discount,
								'bill_discount_type' =>'AMOUNT',
								'tax_total' => 0,
								'grand_total' => $grand_total,
								'paid_amount' => $paid_amount,
								'balance_amount' => $balance,
								'payment_status' => strtoupper($payment_status),
								'status' =>	'PROJECT',
								'remarks' => $data['notes'] ?? null,
								'created_by' =>	$this->session->userdata('user_id'),
								'invoice_type' =>'PROJECT',
								'project_id' =>$data['project_id'],
								'branch_id' =>$this->session->userdata('branch'),
								'dis_val' =>$invoice_discount
							];
							
		$this->db->insert('sales_invoices',$sales_invoice_data);

		if($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		}
		
		$sales_invoice_id = $this->db->insert_id();

		/*
		|--------------------------------------------------------------------------
		| 4. SALES INVOICE ITEMS
		|--------------------------------------------------------------------------
		*/

		foreach ($items as $item) {

			$sales_item = [
				'invoice_id' => $sales_invoice_id,
				'product_id' => $item['product_id'],
				'product_name' => $item['product_name'],
				'unit' => null,
				'qty' =>$item['qty'],
				'free_qty' =>0,
				'unit_price' =>$item['unit_price'],
				'discount_value' =>$item['discount'],
				'discount_type' =>'AMOUNT',
				'tax_value' =>0,
				'line_total' =>$item['line_total'],
				'has_batch' =>0,
				'has_serial' => 0
			];

			$this->db->insert('sales_invoice_items',$sales_item);

			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				return false;
			}

		}


		/*
		|--------------------------------------------------------------------------
		| 5. SALES PAYMENT HEADER
		|--------------------------------------------------------------------------
		|
		| Only create payment header if there is at least one payment.
		|
		*/

		if (!empty($payments)) {

			$payment_data = ['invoice_id' =>$sales_invoice_id,
							 'payment_date' => date('Y-m-d H:i:s'),
							 'total_amount' => $paid_amount,
							 'created_by' => $this->session->userdata('user_id'),
							 'branch_id' =>$this->session->userdata('branch'),
							];
			$this->db->insert('sales_payments',$payment_data);

			if($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				return false;
			}

			$payment_id =$this->db->insert_id();

			/*
			|--------------------------------------------------------------------------
			| 6. PAYMENT ITEMS
			|--------------------------------------------------------------------------
			|
			| One row per payment method.
			|
			*/

			foreach ($payments as $payment) {

				$payment_item_data = [
					'payment_id' =>$payment_id,
					'payment_method' =>$payment['payment_method'],
					'account_id' =>null,
					'amount' =>$payment['amount'],
					'reference_no' =>$payment['reference_no'] ?? null,
					'cheque_no' =>$payment['cheque_no'] ?? null,
					'cheque_date' =>$payment['cheque_date'] ?? null,
					'bank_name' =>$payment['bank_name'] ?? null,
					'note' =>'Project invoice payment',
					/*| Card number*/
					'card_number' =>$payment['card_number'] ?? null,
					/*| Card expiry*/
					/*'card_expiry' =>$payment['card_expiry'] ?? null,*/
					/*| Cheque starts as Pending*/
					'cheque_status' => $payment['payment_method'] === 'CHEQUE' ? 'Pending': 'Pending'
				];

				$this->db->insert('sales_payment_items',$payment_item_data);

				if ($this->db->trans_status() === false) {
					$this->db->trans_rollback();
					return false;
				}
			}
		}


		/*
		|--------------------------------------------------------------------------
		| COMPLETE TRANSACTION
		|--------------------------------------------------------------------------
		*/

		$this->db->trans_complete();

		if($this->db->trans_status() === false) 
		{
			return false;
		}

		/*
		|--------------------------------------------------------------------------
		| RETURN SALES INVOICE ID
		|--------------------------------------------------------------------------
		*/
		return $sales_invoice_id;
	}
	
    private function resolve_status($balance, $paid, $grand_total) {
        if ($paid <= 0) return 'unpaid';
        if ($balance <= 0) return 'paid';
        return 'partial';
    }

    // Used by get_sales_invoices_ajax
    public function get_invoices_by_project($project_id) {
        return $this->db->select('*')
                ->from('project_invoices')
                ->where('project_id', $project_id)
                ->order_by('invoice_date', 'DESC')
                ->get()->result();
    }

    public function get_aggregates_by_project($project_id) {
        $row = $this->db->select('
                SUM(grand_total) as total_billing,
                SUM(paid_amount) as total_paid,
                SUM(balance) as total_balance
             ')
             ->from('project_invoices')
             ->where('project_id', $project_id)
             ->get()->row();

        return [
            'total_billing' => (float) ($row->total_billing ?? 0),
            'total_paid'    => (float) ($row->total_paid ?? 0),
            'total_balance' => (float) ($row->total_balance ?? 0),
        ];
    }

    public function get_invoice($invoice_id) {
		$this->db->join('projects','projects.project_id=project_invoices.project_id','left');
		$this->db->join('customer','customer.cus_id=projects.fk_cus_id','left');
        $invoice = $this->db->get_where('project_invoices', ['id' => $invoice_id])->row();
        if (!$invoice) return null;

        $invoice->items = $this->db->get_where('project_invoice_items', ['p_invoice_id' => $invoice_id])->result();
        return $invoice;
    }

    public function delete_invoice($invoice_id) {
        return $this->db->delete('project_invoices', ['id' => $invoice_id]); // items cascade
    }

    public function search_products($term) {
        return $this->db->select('id, name, product_code, price, retailPrice, wholesalePrice, measure_unit')
                ->where('status', 'active')
                ->group_start()
                    ->like('name', $term)
                    ->or_like('product_code', $term)
                ->group_end()
                ->order_by('name', 'ASC')
                ->get('products')->result();
    }
	
	
	// public function get_issues($act_id){
		// return $this->db->select('*')
        // ->from('stock_activities')
        // ->join('customer','customer.cus_id=stock_activities.cus_id','left')
        // ->join('staff_info','staff_info.staff_id=stock_activities.create_by','left')
        // ->join('stock_transaction_items','stock_transaction_items.fk_st_activity_id=stock_activities.st_activity_id','left')
        // ->join('products','products.id=stock_transaction_items.product_id','left')
		// ->where('stock_activities.st_activity_id', $act_id)
		// ->where('stock_activities.act_type', 'issue')
        // ->get()->result();
	// }
	
	
	public function get_issues($act_id)
	{
		// 1. Get issue basic details
		$activity = $this->db->select('stock_activities.*,customer.*,staff_info.*')
			->from('stock_activities')
			->join('projects','projects.project_id = stock_activities.project_id','left')
			->join('customer','customer.cus_id = projects.fk_cus_id','left')
			->join('staff_info','staff_info.staff_id = stock_activities.create_by','left')
			->where('stock_activities.st_activity_id', $act_id)
			->where('stock_activities.act_type', 'issue')
			->get()
			->row();


		// 2. Get issue products/items
		$items = $this->db
			->select('
				stock_transaction_items.*,
				products.*
			')
			->from('stock_transaction_items')
			->join(
				'products',
				'products.id = stock_transaction_items.product_id',
				'left'
			)
			->where(
				'stock_transaction_items.fk_st_activity_id',
				$act_id
			)
			->get()
			->result();


		// Return both results
		return [
			'activity' => $activity,
			'items'    => $items
		];
	}
	
}