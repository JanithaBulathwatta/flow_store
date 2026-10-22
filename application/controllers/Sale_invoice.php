<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class Sale_invoice extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Sale_model');
			$this->load->model('crm/Customer_model');
			$this->load->model('crm/Sale_model');
			$this->load->model('Store_model');
			$this->load->model('crm/Staff_model');
			$this->load->model('Sales_invoice_model');
			
			// updated by santhosh at 05/06/2026 
			$this->load->model('crm/Bank_model');
			$this->load->model('crm/BankAccount_model');
			
		}
		
		public function index(){
			$data['cus']=$this->Customer_model->get_all();
			$data['staff']=$this->Sale_model->get_sale_staff();
			$data['store']=$this->Store_model->get_all_stores();
			
			//$data['modal_content'] = $this->load->view('crm/customer/customer_form',[],TRUE);
			
			$this->load->view('header');
			$this->load->view('Sale/invoice',$data);
			$this->load->view('footer');
		}
		
		public function new_quotation(){
			$data['cus']=$this->Customer_model->get_all();
			$data['staff']=$this->Sale_model->get_sale_staff();
			$data['store']=$this->Store_model->get_all_stores();
			
			//$data['modal_content'] = $this->load->view('crm/customer/customer_form',[],TRUE);
			
			$this->load->view('header');
			$this->load->view('Sale/quotation',$data);
			$this->load->view('footer');
		}
		
		
		public function get_customers_ajax()
		{
			$cus = $this->Customer_model->get_all();
			$formatted = [];
			foreach ($cus as $c) {
				$formatted[$c->cus_id] = [
					'name' => $c->cus_name,
					'phone' => $c->cus_phone,
					'email' => $c->cus_email,
					'creditLimit' => (float)$c->max_credit_limit,
					'outstanding' => (float)$c->current_credit_amt,
					'creditEnabled' => (bool)$c->is_credit,
					'creditUsed' => $c->current_credit_amt,
					'creditUsed' => $c->current_credit_amt,
					'is_cash_customer' => $c->is_cash_customer,
				];
			}
			header('Content-Type: application/json');
			echo json_encode($formatted);
		}
	
		public function get_products_ajax()
		{
			$products = $this->Sale_model->getProducts();
			$formatted = [];
			
			foreach ($products as $p) {
				// Get batches with correct column names
				$batches = [];
				if (!empty($p['isBatch'])) {
					$batch_results = $this->db->select('id, batch_no, expiry_date, qty')
									   ->where('product_id', $p['id'])
									   ->where('warehouse_id', $p['warehouse_id'] ?? 1)
									   ->where('qty >', 0)
									   ->order_by('expiry_date', 'ASC')
									   ->get('product_batches')
									   ->result();
					
					// ✅ Use $batch_results variable correctly
					foreach ($batch_results as $batch) {
						$batches[] = array(
							'id' => $batch->id,
							'batchNo' => $batch->batch_no,      // Renamed for JS
							'batch_no' => $batch->batch_no,     // Keep original
							'expDate' => $batch->expiry_date,   // Renamed for JS
							'expiry_date' => $batch->expiry_date, // Keep original
							'qty' => (float)$batch->qty,
							'stock' => (float)$batch->qty,      // Alias for JS
							'mfgDate' => date('Y-m-d'),         // Default value
						);
					}
				}
				
				$formatted[] = [
					'id' => $p['id'],
					'code' => $p['code'],
					'name' => $p['name'],
					'icon' => '📦',
					'unit' => $p['unit'] ?: 'Pcs',
					'category' => $p['category'] ?: 'General',
					'price' => (float)$p['price'],
					'wholesalePrice' => (float)($p['wholesalePrice'] ?? 0),
					'specialPrice' => (float)($p['specialPrice'] ?? 0),
					'stock' => (int)$p['stock'],
					'isSerial' => !empty($p['isSerial']),
					'isBatch' => !empty($p['isBatch']),
					'hasExpiry' => !empty($p['hasExpiry']),
					'hasWarranty' => !empty($p['hasWarranty']),
					'warrantyMonths' => (int)($p['warrantyMonths'] ?? 0),
					'warrantyType' => $p['warrantyType'] ?? null,
					'serials' => !empty($p['serials']) ? $p['serials'] : null,
					'batches' => $batches,
					'description' => $p['description'] ?? ''
				];
			}  // ✅ Closing brace for foreach

			header('Content-Type: application/json');
			echo json_encode($formatted);
		}
		
		public function save_invoice()
		{ 
			$this->load->library('form_validation');
			$this->form_validation->set_rules('customer_id', 'Customer Name', 'required');
			$this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required');
			$this->form_validation->set_rules('due_date', 'Due Date', 'required');
			$this->form_validation->set_rules('created_by', 'Sales Person', 'required');
			$this->form_validation->set_rules('warehouse_id', 'Warehouse', 'required');
			$this->form_validation->set_rules('product_id[]', 'Product', 'required');
			
		
			if ($this->form_validation->run() == FALSE) {
				echo json_encode(['stt' => 'error', 'msg' => validation_errors(), 'data' => '']);
			} else {
				
				$this->db->trans_begin();

				$post = $this->input->post();

				// helper
				function clean($val){
					return floatval(str_replace(',', '', $val));
				}

				// =========================
				// SAVE INVOICE
				// =========================
				$invoiceData = [
					'invoice_no' => $post['invoice_no'],
					'customer_id' => $post['customer_id'],
					'warehouse_id' => $post['warehouse_id'],
					'invoice_date' => $post['invoice_date'],
					'due_date' => $post['due_date'],

					'total_items' => $post['total_items'],
					'total_qty' => clean($post['total_qty']),
					'total_free_qty' => clean($post['total_free_qty']),

					'subtotal' => clean($post['subtotal']),
					'line_discount_total' => clean($post['line_discount_total']),
					'bill_discount_value' => clean($post['bill_discount_value']),
					'tax_total' => clean($post['tax_total']),
					'grand_total' => clean($post['grand_total']),

					'paid_amount' => clean($post['paid_amount']),
					'balance_amount' => clean($post['balance_amount']),

					'remarks' => $post['remarks'],
					'created_by' => $post['created_by'],
					'dis_val' => $post['dis_val'],
					'branch_id' => $this->session->userdata('branch'),
					
					
					//'status' => (strtolower($post['mode']) == 'draft') ? 'DRAFT' : 'COMPLETED'
					'status' => in_array(strtoupper($post['mode']), ['DRAFT', 'COMPLETED', 'QUOTATION']) ? strtoupper($post['mode']) : 'DRAFT'
				];

				// payment status
				if ($invoiceData['paid_amount'] <= 0) {
					$invoiceData['payment_status'] = 'UNPAID';
				} elseif ($invoiceData['paid_amount'] < $invoiceData['grand_total']) {
					$invoiceData['payment_status'] = 'PARTIAL';
				} else {
					$invoiceData['payment_status'] = 'PAID';
				}

				//$this->db->insert('sales_invoices', $invoiceData);
				//$invoice_id = $this->db->insert_id();
				// -------------------------
				// CHECK EXISTING INVOICE (IMPORTANT FIX FOR DUPLICATE ERROR)
				// -------------------------
				$invoice_id = $this->input->post('invoice_id');

				if (!empty($invoice_id)) {

					// UPDATE EXISTING DRAFT 
					$this->db->where('id', $invoice_id);
					$this->db->update('sales_invoices', $invoiceData);

					// DELETE OLD ITEMS
					$this->db->where('invoice_id', $invoice_id)->delete('sales_invoice_items');

				} else {

					// INSERT NEW
					$this->db->insert('sales_invoices', $invoiceData);
					$invoice_id = $this->db->insert_id();
				}

                 $warehouse_id = $post['warehouse_id'];

				// =========================
				// ITEMS INSERT
				// =========================
				$count = count($post['product_id']);

				for ($i = 0; $i < $count; $i++) {

					// safety (avoid undefined index)
					$product_id = $post['product_id'][$i] ?? null;
					if (!$product_id) continue;

					$itemData = [
						'invoice_id' => $invoice_id,
						'product_id' => $product_id,
						'product_name' => $post['product_name'][$i] ?? '',
						'unit' => $post['unit'][$i] ?? '',
						'qty' => $post['qty'][$i] ?? 0,
						'free_qty' => $post['free_qty'][$i] ?? 0,
						'unit_price' => $post['unit_price'][$i] ?? 0,
						'discount_value' => $post['discount_value'][$i] ?? 0,
						'line_total' => $post['line_total'][$i] ?? 0,
						'has_batch' => 0,
						'has_serial' => 0
					];

					$this->db->insert('sales_invoice_items', $itemData);
					$invoice_item_id = $this->db->insert_id();

					// =========================
					// SERIALS (OPTIONAL)
					// =========================
					if (!empty($post['serials'][$product_id])) {
                
						$serials = array_filter($post['serials'][$product_id]); // remove empty values
						
						foreach ($serials as $sn) {
							// ✅ Update product_serial_numbers table status to SOLD
							// Using grn_item_id to track which purchase this serial came from
							$this->db->where('serial_no', $sn);
							$this->db->where('product_id', $product_id);
							$this->db->where('warehouse_id', $warehouse_id);
							$this->db->update('product_serial_numbers', [
								'status' => 'SOLD'
							]);
							
							// Log for debugging
							if ($this->db->affected_rows() == 0) {
								error_log("Failed to update serial: $sn for product: $product_id, warehouse: $warehouse_id");
							} else {
								error_log("Successfully updated serial $sn to SOLD");
							}
						}

						// Mark item as having serials
						$this->db->where('id', $invoice_item_id)->update('sales_invoice_items', ['has_serial' => 1]);
					}
					
					// =========================
					// BATCH (OPTIONAL)
					// =========================
					if (!empty($post['batch_no'][$i])) {
						$this->db->insert('sales_invoice_item_batches', [
							'invoice_item_id' => $invoice_item_id,
							'batch_no' => $post['batch_no'][$i],
							'qty' => $post['qty'][$i]
						]);

						$this->db->where('id', $invoice_item_id)->update('sales_invoice_items', ['has_batch' => 1]);
					}
				}	
					
				if ($invoice_id && !in_array(strtoupper($post['mode'] ?? 'COMPLETED'), ['DRAFT', 'QUOTATION'])) {
					// THIS IS THE KEY - Update stock like GRN approve
					$this->load->model('Sales_invoice_model');
					
					$stock_updated = $this->Sales_invoice_model->update_stock_for_sale($invoice_id);
					
					if (!$stock_updated) {
						$this->db->trans_rollback();
						echo json_encode(["stt" => "error","msg" => "Stock update failed! Insufficient inventory.","data" => '']);
						return;
					}
				}
	
	
	


				// =========================
				// PAYMENTS
				// =========================
				if (!empty($post['payment_method'])) {

					$this->db->insert('sales_payments', [
						'invoice_id' => $invoice_id,
						'payment_date' => date('Y-m-d H:i:s'),
						'total_amount' => clean($post['paid_amount']),
						'created_by' => $post['created_by']
					]);

					$payment_id = $this->db->insert_id();

					/*foreach ($post['payment_method'] as $k => $method) {
						$this->db->insert('sales_payment_items', [
							'payment_id' => $payment_id,
							'payment_method' => strtoupper($method),
							'cheque_no'=>$post['cheque_no'][$k],
							//'card_number'=>$post['card_number'][$k],
							'bank_name'=>$post['bank_name'][$k],
							'cheque_date'=>$post['cheque_date'][$k],
							'amount' => clean($post['amount'][$k])
						]);
					}*/
					foreach ($post['payment_method'] as $k => $method) {

						$data = [
							'payment_id'     => $payment_id,
							'payment_method' => strtoupper($method),
							'amount'         => clean($post['amount'][$k]),
							'cheque_no'      => null,
							'card_number'    => null,
							'bank_name'      => null,
							'cheque_date'    => null
						];

						switch (strtoupper($method)) {

							case 'CARD':
								$data['card_number'] = $post['card_number'][0] ?? null;
								break;

							case 'BANK':
								$data['bank_name'] = $post['bank_name'][0] ?? null;
								break;

							case 'CHEQUE':
								$data['cheque_no']   = $post['cheque_no'][0] ?? null;
								$data['bank_name']   = $post['bank_name'][0] ?? null;
								$data['cheque_date'] = $post['cheque_date'][0] ?? null;
								break;
						}

						$this->db->insert('sales_payment_items', $data);
					}
				}

				// =========================
				// FINAL
				// =========================
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();

					echo json_encode([
						"stt" => "error",
						"msg" => "Something Went Wrong!!"
					]);
				} else {
					$this->db->trans_commit();
					
			//for activity log entry
			$customer_id = isset($post['customer_id']) ? $post['customer_id'] : null;
			$customer    = $this->Customer_model->get_by_id($customer_id);
			$user_id_fk = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('ut_id');
			$msg = "Sale Created [Invoice No:" . $post['invoice_no'] . "]";
			
			// Define the number and email
			$phone      = isset($customer->cus_phone) ? $customer->cus_phone : "";
			$email      = isset($customer->cus_email) ? $customer->cus_email : "";
			
			$this->Activity_log_m->addLog($user_id_fk, $user_type, 'Sale Module', 'Create Sale', 'INSERT', true, 1, $phone, $email, $msg);
			//end of activity log

					/*echo json_encode([
						"stt" => "ok",
						"msg" => ($post['mode'] == 'DRAFT')
							? "Sale Drafted Successfully !!"
							: "Sale Completed Successfully !!",
						"data" => $invoice_id
					]);*/
						
					echo json_encode(["stt" => "ok",
									  "msg" => ($post['mode'] == 'DRAFT')
											? "Sale Drafted Successfully !!"
											: (($post['mode'] == 'QUOTATION')
												? "Quotation Saved Successfully !!"
												: "Sale Completed Successfully !!"),
										"data" => $invoice_id
									]);
					
				}
							
				$bal = $post['balance_amount'];
				$id = $post['customer_id'];
				
				$this->db->select('current_credit_amt');
				$this->db->where('cus_id',$id);
				$res = $this->db->get('customer')->row();
				
				$cur_cre = $res->current_credit_amt;
				
				$cur_amt = $cur_cre + $bal;
				
				$data = ['current_credit_amt' => $cur_amt];
								
				$this->db->where('cus_id', $id);
				return $this->db->update('customer', $data);
				
			}
			
		}
		
		public function get_invoice()
		{
			$invoice_id = $_GET['id'];
			
			$this->load->model('Sales_invoice_model');

			$data = $this->Sales_invoice_model->getInvoiceWithItems($invoice_id);

			echo json_encode($data);
		}
		
		//public function get_invoice_ajax()
		public function get_invoice_ajax()
	  	{
			$id = $_GET['id'];
			$data = $this->Sale_model->get_invoice_with_items($id);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
        	
        	
		//get single invoice item for delivery note
		public function delivery_note_items()
		{
			$id = $_GET['id'];
			$data = $this->Sale_model->delivery_note_items($id);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
        	
        public function delivery_note()
        {	
        	$this->load->view('delivery_note/delivery_note'); 					
		}
        	
        public function print_invoice()
        {
            $id = $this->input->get('id');
            
            if (!$id) {
                show_404();
            }
            
            $this->load->model('Sale_model');
            
            $data['invoice'] = $this->Sale_model->get_invoice_for_print($id);
            
            if (!$data['invoice']) {
                show_404();
            }
            
            $this->load->view('printView/sales_header', $data);
            $this->load->view('printView/sales_print', $data);
            $this->load->view('printView/sales_footer', $data);
        } 
		
        public function print_quotation()
        {
            $id = $this->input->get('id');
            
            if (!$id) {
                show_404();
            }
            
            $this->load->model('Sale_model');
            
            $data['invoice'] = $this->Sale_model->get_invoice_for_print($id);
            
            if (!$data['invoice']) {
                show_404();
            }
            
            $this->load->view('printView/quotation_header', $data);
            $this->load->view('printView/quotation_print', $data);
            $this->load->view('printView/quotation_footer', $data);
        }
    
        
        public function view() {
        	$id = $this->input->get('id');
        	 
            if (!$id) show_404();
        
            $invoice = $this->Sales_invoice_model->get_invoice_details($id);
            if (!$invoice) show_404();
        
        	$data = [
                'invoice'  => $invoice,
                'items'    => $this->Sales_invoice_model->get_invoice_items_simple($id),
                'payments' => $this->Sales_invoice_model->get_invoice_payments($id),
                'page_title' => 'Invoice ' . $invoice->invoice_no
            ];
        
            $this->load->view('header');
            $this->load->view('Sale/salse_view', $data);
            $this->load->view('footer');
        }
		
        public function sale_list() {	
        
			$data ['staff'] = $this->Staff_model->get_staff();
			
			// updated by santhosh at 05/06/2026 
			$data['banks'] = $this->Bank_model->get_active_banks();
			$data['banks_acc'] = $this->BankAccount_model->get_all();
			$pay_accounts = $this->BankAccount_model->get_pay_accounts();
			$data['pay'] = $pay_accounts;
			
			// ✅ Automatically set the first account's ID as the default value if it exists
			$data['default_account_id'] = (!empty($pay_accounts)) ? $pay_accounts[0]->bank_acc_id : '';
			
			$this->load->view('header');
			$this->load->view('Sale/sales_list',$data);
			$this->load->view('footer');
			
		}
        	
		public function get_data(){
			
			$filters = $this->input->get();
			$data = $this->Sale_model->get_invoices($filters);
			echo json_encode($data);
			
		}
		
		public function get_data_for_quotation(){
			
			$filters = $this->input->get();
			$data = $this->Sale_model->get_quotation($filters);
			echo json_encode($data);
			
		}
		
		public function quotation(){
			
			$data ['staff'] = $this->Staff_model->get_staff();
			
			$this->load->view('header');
			$this->load->view('Sale/quotation_list',$data);
			$this->load->view('footer');
		}

	// create a function for the sales payment (05/06/2026 -> santhosh)

	public function process_payment()
	{
		// Call the model to handle all validations and DB transactions
		$result = $this->Sales_invoice_model->create_payment();

		if ($result) {
			echo json_encode(['stt' => 'ok', 'msg' => 'Payment processed successfully']);
		} else {
			echo json_encode(['stt' => 'error', 'msg' => 'Failed to save payment']);
		}
	}
	
	
	public function get_invoice_number()
    {
        $data = $this->Sale_model->generate_invoice_number();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
		
	public function inbound_cheques(){
		$this->load->model('crm/BankAccount_model');
		$data ['bnk']= $this->BankAccount_model->get_all();;
		
		$this->load->view('header');
		$this->load->view('Sale/inbound_cheque_list',$data);
		$this->load->view('footer');
	}	
	
	/*public function get_cheques()
	{
		$data = $this->Sale_model->get_cheques();

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}*/
	
	// updated this function santhosh (6/8/2026)
	public function get_cheques()
	{
		$data = $this->Sale_model->get_supplier_cheques();

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	public function save_payment_item()
	{
		$post = $this->input->post();

		if (!$post) {
			echo json_encode(['status' => false]);
			return;
		}

		$data = [
			'payment_id'     => $post['payment_id'] ?? null,
			'payment_method' => $post['payment_method'] ?? 'CHEQUE',

			'account_id'     => $post['account_id'] ?? null,
			'amount'         => $post['amount'] ?? 0,

			'reference_no'   => $post['reference_no'] ?? null,

			'cheque_no'      => $post['cheque_no'] ?? null,
			'cheque_date'    => $post['chq_date'] ?? null,

			'bank_name'      => $post['bank_name'] ?? null,
			'note'           => $post['note'] ?? null,

			'cheque_status'  => $post['cheque_status'] ?? 'Pending',

			'card_number'    => $post['card_number'] ?? null,
		];

		$id = $post['id'] ?? null;

	
		$result = $this->Sale_model->save_or_update($data, $id);

		echo json_encode([
			'status' => $result
		]);
	}
	
	
	// get sales counts
		public function get_sale_counts()
	{
		
		$data = $this->Sale_model->get_sale_counts();

		echo json_encode($data);
	}
	
	// get Quotations counts
		public function get_quotation_counts()
	{
		
		$data = $this->Sale_model->get_quotation_counts();

		echo json_encode($data);
	}
	
	
	public function change_status()
	{
		$post = $this->input->post();
		
		if (!$post || !isset($post['id'])) {
			echo json_encode(['status' => false, 'message' => 'Invalid payment request parameters.']);
			return;
		}

		// Capture user session ID if available to pass for invoice footprints
		$user_id = $this->session->userdata('user_id');

		// All business operations moved strictly to the model
		$result = $this->Sale_model->process_cheque_status_change($post, $user_id);

		// Output the response to your jQuery AJAX saveCheque function
		echo json_encode($result);
	}

	
} 