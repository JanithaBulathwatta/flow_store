<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'traits/BranchTrait.php';
	class Sale_model extends CI_Model {
		use BranchTrait;
		public function get_sale_staff(){
			//$this->db->where('ut_id','40');
			$this->db->where('status','active');
			$res = $this->db->get('staff_info')->result();
			
			return $res;
			
		}
		
	public function getProducts() {
    
    $whouse = $this->session->userdata('whereouse_id');
    $branch_id = $this->getCurrentBranchId();
    
    $this->db->select('p.id, p.name, p.product_code, p.description,
                       p.price, p.wholesalePrice, p.specialPrice,
                       p.is_warranty_item, p.is_expiry_trk, p.is_serial_trk,
                       p.warranty_period, p.warrantyType, p.is_batch, p.is_auto_batch,
                       u.unit_name, sc.name AS sub_category, s.name AS super_category,
                       COALESCE(SUM(is2.qty), 0) as total_stock');
    $this->db->from('products p');
    //$this->db->join('units u', 'p.unit_id = u.unit_id', 'left');
	$this->db->join('units u', 'p.measure_unit = u.unit_id', 'left'); 
    //$this->db->join('sub_category sc', 'p.sub_category_id = sc.id', 'left');
    $this->db->join('sub_category sc', 'p.category_id = sc.id', 'left');
    $this->db->join('super_category s', 'sc.super_category_id = s.id', 'left');
    $this->db->join('inventory_stock is2', 'is2.product_id = p.id', 'left');
    $this->db->where('p.status', 'active');
    
    // Add branch filter
    /*if ($branch_id) {
        $this->db->where('is2.branch_id', $branch_id);
    }*/
    
    // Add warehouse filter
    /*if ($whouse) {
        $this->db->where('is2.warehouse_id', $whouse);
    }*/
    
    $this->db->group_by('p.id');
    
    $query = $this->db->get();
    
    $products = [];
    
    foreach ($query->result_array() as $row) {
        $total_stock = (float)$row['total_stock'];
        
        $product = [
            "id"            => $row["id"],
            "code"          => $row["product_code"],
            "name"          => $row["name"],
            "icon"          => null,
            "unit"          => $row["unit_name"],
            "category"      => $row["super_category"],
            "price"         => (float)$row["price"],
            "wholesalePrice"=> (float)$row["wholesalePrice"],
            "specialPrice"  => (float)$row["specialPrice"],
            "description"   => $row["description"],
            "isSerial"      => (bool)$row["is_serial_trk"],
            "isBatch"       => (bool)$row["is_batch"],
            "isAutoBatch"   => (bool)$row["is_auto_batch"],
            "hasExpiry"     => (bool)$row["is_expiry_trk"],
            "hasWarranty"   => (bool)$row["is_warranty_item"],
            "warrantyMonths"=> (int)$row["warranty_period"],
            "warrantyType"  => $row["warrantyType"],
            "stock"         => $total_stock,
            "serials"       => null,
            "batches"       => null,
            "warehouse_stock" => []
        ];

        // Get stock breakdown by warehouse (with branch filter)
        $this->db->select('s.store_id, s.store_name, is3.qty');
        $this->db->from('inventory_stock is3');
        $this->db->join('stores s', 's.store_id = is3.warehouse_id');
        $this->db->where('is3.product_id', $row["id"]);
        $this->db->where('is3.qty >', 0);
        
        if ($branch_id) {
            $this->db->where('is3.branch_id', $branch_id);
        }
        
        $warehouse_stock = $this->db->get()->result_array();
        $product["warehouse_stock"] = $warehouse_stock;

        // For SERIAL tracked products
        if ($product["isSerial"]) {
            $this->db->select('serial_no, warehouse_id');
            $this->db->from('product_serial_numbers');
            $this->db->where('product_id', $row["id"]);
            $this->db->where('status', 'AVAILABLE');
            
            if ($branch_id) {
                $this->db->where('branch_id', $branch_id);
            }
            
            $serials = $this->db->get()->result_array();
            $product["serials"] = $serials;
            $product["stock"] = count($serials);
        }

        // For BATCH tracked products
        if ($product["isBatch"]) {
            $this->db->select('pb.id, pb.batch_no, pb.expiry_date, pb.is_auto_batch, COALESCE(is4.qty, 0) as stock_qty');
            $this->db->from('product_batches pb');
            $this->db->join('inventory_stock is4', 'is4.batch_id = pb.id', 'left');
            $this->db->where('pb.product_id', $row["id"]);
            
            if ($branch_id) {
                $this->db->where('pb.branch_id', $branch_id);
                $this->db->where('is4.branch_id', $branch_id);
            }
            
            $this->db->group_by('pb.id');
            $batches = $this->db->get()->result_array();
            
            $product["batches"] = [];
            foreach ($batches as $b) {
                $batch_stock = (float)($b['stock_qty'] ?? 0);
                $product["batches"][] = [
                    "id"           => "B".$b["id"],
                    "batchNo"      => $b["batch_no"],
                    "expDate"      => $b["expiry_date"],
                    "isAutoBatch"  => (bool)$b["is_auto_batch"],
                    "stock"        => $batch_stock
                ];
            }
        }

        $products[] = $product;
    }

    return $products;
}	
		public function save_sales()
		{
		
			$this->db->trans_start(); // 🔒 transaction start

			// =========================
			// 🔹 Helper to clean numbers
			// =========================
			function clean_number($val) {
				return (float) str_replace([',', 'Rs.', ' '], '', $val);
			}

			// =========================
			// 🔹 Invoice Data
			// =========================
			$invoiceData = [
				'invoice_no' => 'INV-' . time(), // you can improve this
				'customer_id' => $this->input->post('customer_id'),
				'warehouse_id' => $this->input->post('warehouse_id'),
				'invoice_date' => $this->input->post('invoice_date'),
				'due_date' => $this->input->post('due_date'),

				'total_items' => $this->input->post('total_items'),
				'total_qty' => clean_number($this->input->post('total_qty')),
				'total_free_qty' => clean_number($this->input->post('total_free_qty')),

				'subtotal' => clean_number($this->input->post('subtotal')),
				'tax_total' => clean_number($this->input->post('tax_total')),
				'grand_total' => clean_number($this->input->post('grand_total')),

				'bill_discount_value' => clean_number($this->input->post('bill_discount_value')),

				'paid_amount' => clean_number($this->input->post('paid_amount')),
				'balance_amount' => clean_number($this->input->post('balance_amount')),

				'payment_status' => 'PAID', // you can calculate dynamically
				'status' => 'COMPLETED',

				'remarks' => $this->input->post('remarks'),
				'created_by' => $this->input->post('created_by')
			];
              // ADD BRANCH ID
    $invoiceData = $this->addBranch($invoiceData);
    
    $this->db->insert('sales_invoices', $invoiceData);
    $invoice_id = $this->db->insert_id();
    
			$this->db->insert('sales_invoices', $invoiceData);
			$invoice_id = $this->db->insert_id();

			// =========================
			// 🔹 Items
			// =========================
			$product_ids = $this->input->post('product_id');
			$names = $this->input->post('product_name');
			$units = $this->input->post('unit');
			$qtys = $this->input->post('qty');
			$free_qtys = $this->input->post('free_qty');
			$prices = $this->input->post('unit_price');
			$discounts = $this->input->post('discount_value');

			for ($i = 0; $i < count($names); $i++) {

				// ⚠️ skip invalid rows
				if (empty($names[$i])) continue;

				// ⚠️ handle undefined product_id
				$product_id = (!empty($product_ids[$i]) && $product_ids[$i] !== 'undefined')
					? $product_ids[$i]
					: 0;

				$qty = (float)$qtys[$i];
				$price = clean_number($prices[$i]);
				$disc = clean_number($discounts[$i]);

				$line_total = ($qty * $price) - $disc;

				$item = [
					'invoice_id' => $invoice_id,
					'product_id' => $product_id,
					'product_name' => $names[$i],
					'unit' => $units[$i],

					'qty' => $qty,
					'free_qty' => (float)$free_qtys[$i],

					'unit_price' => $price,

					'discount_value' => $disc,
					'discount_type' => 'AMOUNT',

					'tax_value' => 0,
					'line_total' => $line_total
				];

				$this->db->insert('sales_invoice_items', $item);
			}

			// =========================
			// 🔹 Payment
			// =========================
			$payment = [
				'invoice_id' => $invoice_id,
				'payment_date' => date('Y-m-d H:i:s'),
				'total_amount' => clean_number($this->input->post('paid_amount')),
				'created_by' => $this->input->post('created_by')
			];

			$this->db->insert('sales_payments', $payment);
			$payment_id = $this->db->insert_id();

			// =========================
			// 🔹 Payment Items
			// =========================
			$methods = $this->input->post('payment_method');
			$amounts = $this->input->post('amount');

			// if single method (not array)
			if (!is_array($methods)) {
				$methods = [$methods];
				$amounts = [$amounts];
			}

			for ($i = 0; $i < count($methods); $i++) {

				$pi = [
					'payment_id' => $payment_id,
					'payment_method' => strtoupper($methods[$i]),
					'amount' => clean_number($amounts[$i])
				];

				$this->db->insert('sales_payment_items', $pi);
			}

			// =========================
			// 🔹 Commit / Rollback
			// =========================
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				return ['status' => false, 'msg' => 'Transaction Failed'];
			}

			/*return [
				'status' => true,
				'invoice_id' => $invoice_id,
				'msg' => 'Invoice Saved Successfully'
			];*/
			
			if($invoice_id){
				echo json_encode(array("stt"=>"ok","msg"=>"Sale Completed Successfully !!","data"=>$invoice_id));
			}else{
				echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
			}
			
			//for activity log entry
			$customer_id = $this->input->post('customer_id');
			$customer    = $this->Customer_model->get_by_id($customer_id);
			$user_id_fk = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('ut_id');
			$msg = "Sale Created [Invoice No:" . $this->input->post('invoice_date') . "]";
			
			// Define the number and email
			$phone      = isset($customer->cus_phone) ? $customer->cus_phone : "";
			$email      = isset($customer->cus_email) ? $customer->cus_email : "";
			
			$this->Activity_log_m->addLog($user_id_fk, $user_type, 'Sale Module', 'Create Sale', 'INSERT', true, 1, $phone, $email, $msg);
			//end of activity log
			
		}
		
		public function save_as_draft(){
			$this->db->trans_start(); // 🔒 transaction start

			// =========================
			// 🔹 Helper to clean numbers
			// =========================
			function clean_number($val) {
				return (float) str_replace([',', 'Rs.', ' '], '', $val);
			}

			// =========================
			// 🔹 Invoice Data
			// =========================
			$invoiceData = [
				'invoice_no' => 'INV-' . time(), // you can improve this
				'customer_id' => $this->input->post('customer_id'),
				'warehouse_id' => $this->input->post('warehouse_id'),
				'invoice_date' => $this->input->post('invoice_date'),
				'due_date' => $this->input->post('due_date'),

				'total_items' => $this->input->post('total_items'),
				'total_qty' => clean_number($this->input->post('total_qty')),
				'total_free_qty' => clean_number($this->input->post('total_free_qty')),

				'subtotal' => clean_number($this->input->post('subtotal')),
				'tax_total' => clean_number($this->input->post('tax_total')),
				'grand_total' => clean_number($this->input->post('grand_total')),

				'bill_discount_value' => clean_number($this->input->post('bill_discount_value')),

				'paid_amount' => clean_number($this->input->post('paid_amount')),
				'balance_amount' => clean_number($this->input->post('balance_amount')),

				'payment_status' => 'PAID', // you can calculate dynamically
				'status' => 'DRAFT',

				'remarks' => $this->input->post('remarks'),
				'created_by' => $this->input->post('created_by')
			];
            $invoiceData = $this->addBranch($invoiceData);
			$this->db->insert('sales_invoices', $invoiceData);
			$invoice_id = $this->db->insert_id();

			// =========================
			// 🔹 Items
			// =========================
			$product_ids = $this->input->post('product_id');
			$names = $this->input->post('product_name');
			$units = $this->input->post('unit');
			$qtys = $this->input->post('qty');
			$free_qtys = $this->input->post('free_qty');
			$prices = $this->input->post('unit_price');
			$discounts = $this->input->post('discount_value');

			for ($i = 0; $i < count($names); $i++) {

				// ⚠️ skip invalid rows
				if (empty($names[$i])) continue;

				// ⚠️ handle undefined product_id
				$product_id = (!empty($product_ids[$i]) && $product_ids[$i] !== 'undefined')
					? $product_ids[$i]
					: 0;

				$qty = (float)$qtys[$i];
				$price = clean_number($prices[$i]);
				$disc = clean_number($discounts[$i]);

				$line_total = ($qty * $price) - $disc;

				$item = [
					'invoice_id' => $invoice_id,
					'product_id' => $product_id,
					'product_name' => $names[$i],
					'unit' => $units[$i],

					'qty' => $qty,
					'free_qty' => (float)$free_qtys[$i],

					'unit_price' => $price,

					'discount_value' => $disc,
					'discount_type' => 'AMOUNT',

					'tax_value' => 0,
					'line_total' => $line_total
				];

				$this->db->insert('sales_invoice_items', $item);
			}

			

			// =========================
			// 🔹 Commit / Rollback
			// =========================
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				return ['status' => false, 'msg' => 'Transaction Failed'];
			}

			/*return [
				'status' => true,
				'invoice_id' => $invoice_id,
				'msg' => 'Invoice Drafted Successfully'
			];*/
			
			if($invoice_id){
				echo json_encode(array("stt"=>"ok","msg"=>"Sale Drafted Successfully !!","data"=>$invoice_id));
			}else{
				echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
			}
			
			//for activity log entry
			$user_id_fk = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('ut_id');

			
			$this->Activity_log_m->addLog($user_id_fk, $user_type, 'Sale Module', 'Create Draft Sale', 'INSERT');
			//end of activity log
			
		} 
		
		public function update_saved_draft()
		{
			$this->db->trans_start(); // 🔒 start transaction

			// helper
			function clean_number($val) {
				return (float) str_replace([',', 'Rs.', ' '], '', $val);
			}

			$inv_id = $this->input->post('inv_id');

			if (empty($inv_id)) {
				return ['status' => false, 'msg' => 'Invalid Invoice ID'];
			}
            if (!$this->verifyBranch('sales_invoices', $inv_id)) {
        return ['status' => false, 'msg' => 'Unauthorized: Invoice not in your branch'];
    }
     
			// 🔍 Check invoice
			$invoice = $this->db->where('id', $inv_id)->get('sales_invoices')->row();

			if (!$invoice) {
				return ['status' => false, 'msg' => 'Invoice not found'];
			}

			$invoice_id = $inv_id;

			// =========================
			// 🔹 UPDATE INVOICE HEADER
			// =========================
			$invoiceData = [
				'customer_id' => $this->input->post('customer_id'),
				'warehouse_id' => $this->input->post('warehouse_id'),
				'invoice_date' => $this->input->post('invoice_date'),
				'due_date' => $this->input->post('due_date'),

				'total_items' => $this->input->post('total_items'),
				'total_qty' => clean_number($this->input->post('total_qty')),
				'total_free_qty' => clean_number($this->input->post('total_free_qty')),

				'tax_total' => clean_number($this->input->post('tax_total')),
				'grand_total' => clean_number($this->input->post('grand_total')),
				'bill_discount_value' => clean_number($this->input->post('bill_discount_value')),

				'paid_amount' => clean_number($this->input->post('paid_amount')),
				'balance_amount' => clean_number($this->input->post('balance_amount')),

				'remarks' => $this->input->post('remarks'),
				'created_by' => $this->input->post('created_by'),
				'status' => 'COMPLETED'
			];

			$this->db->where('id', $invoice_id);
			$this->db->update('sales_invoices', $invoiceData);

			// =========================
			// 🔹 ITEMS (SMART UPDATE)
			// =========================
			$item_ids    = $this->input->post('item_id');
			$product_ids = $this->input->post('product_id');
			$names       = $this->input->post('product_name');
			$units       = $this->input->post('unit');
			$qtys        = $this->input->post('qty');
			$free_qtys   = $this->input->post('free_qty');
			$prices      = $this->input->post('unit_price');
			$discounts   = $this->input->post('discount_value');

			$submitted_ids = [];

			for ($i = 0; $i < count($names); $i++) {

				if (empty($names[$i])) continue;

				$item_id   = !empty($item_ids[$i]) ? $item_ids[$i] : null;
				$product_id = (!empty($product_ids[$i]) && $product_ids[$i] !== 'undefined')
								? $product_ids[$i] : 0;

				$qty   = (float)$qtys[$i];
				$price = clean_number($prices[$i]);
				$disc  = clean_number($discounts[$i]);

				$line_total = ($qty * $price) - $disc;

				if ($item_id) {

					// 🔹 UPDATE
					$this->db->where('id', $item_id);
					$this->db->update('sales_invoice_items', [
						'product_id' => $product_id,
						'product_name' => $names[$i],
						'unit' => $units[$i],
						'qty' => $qty,
						'free_qty' => (float)$free_qtys[$i],
						'unit_price' => $price,
						'discount_value' => $disc,
						'line_total' => $line_total
					]);

					$submitted_ids[] = $item_id;

				} else {

					// 🔹 INSERT
					$this->db->insert('sales_invoice_items', [
						'invoice_id' => $invoice_id,
						'product_id' => $product_id,
						'product_name' => $names[$i],
						'unit' => $units[$i],
						'qty' => $qty,
						'free_qty' => (float)$free_qtys[$i],
						'unit_price' => $price,
						'discount_value' => $disc,
						'discount_type' => 'AMOUNT',
						'tax_value' => 0,
						'line_total' => $line_total
					]);

					$submitted_ids[] = $this->db->insert_id();
				}
			}

			// =========================
			// 🔹 DELETE removed items
			// =========================
			if (!empty($submitted_ids)) {
				$this->db->where('invoice_id', $invoice_id);
				$this->db->where_not_in('id', $submitted_ids);
				$this->db->delete('sales_invoice_items');
			} else {
				$this->db->where('invoice_id', $invoice_id);
				$this->db->delete('sales_invoice_items');
			}

			// =========================
			// 🔹 RECALCULATE SUBTOTAL
			// =========================
			$this->db->query("
				UPDATE sales_invoices 
				SET subtotal = (
					SELECT IFNULL(SUM(line_total),0) 
					FROM sales_invoice_items 
					WHERE invoice_id = {$invoice_id}
				)
				WHERE id = {$invoice_id}
			");

			// =========================
			// 🔹 PAYMENT (SMART)
			// =========================
			$existing_payment = $this->db
				->where('invoice_id', $invoice_id)
				->get('sales_payments')
				->row();

			if ($existing_payment) {

				$payment_id = $existing_payment->id;

				$this->db->where('id', $payment_id);
				$this->db->update('sales_payments', [
					'payment_date' => date('Y-m-d H:i:s'),
					'total_amount' => clean_number($this->input->post('paid_amount')),
					'created_by' => $this->input->post('created_by')
				]);

				$this->db->where('payment_id', $payment_id);
				$this->db->delete('sales_payment_items');

			} else {

				$this->db->insert('sales_payments', [
					'invoice_id' => $invoice_id,
					'payment_date' => date('Y-m-d H:i:s'),
					'total_amount' => clean_number($this->input->post('paid_amount')),
					'created_by' => $this->input->post('created_by')
				]);

				$payment_id = $this->db->insert_id();
			}

			// 🔹 Insert payment items
			$methods = $this->input->post('payment_method');
			$amounts = $this->input->post('amount');

			if (!is_array($methods)) {
				$methods = [$methods];
				$amounts = [$amounts];
			}

			for ($i = 0; $i < count($methods); $i++) {

				if (empty($methods[$i])) continue;

				$this->db->insert('sales_payment_items', [
					'payment_id' => $payment_id,
					'payment_method' => strtoupper($methods[$i]),
					'amount' => clean_number($amounts[$i])
				]);
			}

			// =========================
			// 🔹 PAYMENT STATUS
			// =========================
			$paid  = clean_number($this->input->post('paid_amount'));
			$grand = clean_number($this->input->post('grand_total'));

			$pay_status = 'PENDING';
			if ($paid >= $grand) {
				$pay_status = 'PAID';
			} elseif ($paid > 0) {
				$pay_status = 'PARTIAL';
			}

			$this->db->where('id', $invoice_id);
			$this->db->update('sales_invoices', [
				'payment_status' => $pay_status
			]);

			// =========================
			// 🔹 FINALIZE
			// =========================
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				return ['status' => false, 'msg' => 'Transaction Failed'];
			}

			/*return [
				'status' => true,
				'invoice_id' => $invoice_id,
				'msg' => 'Invoice Updated Successfully'
			];*/
			
			if($invoice_id){
				echo json_encode(array("stt"=>"ok","msg"=>"Sale Completed Successfully !!","data"=>$invoice_id));
			}else{
				echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
			}
			

			
		}
		
		
		public function get_invoice_with_items($invoice_id)
		{
			 // Verify invoice belongs to current branch
    if (!$this->verifyBranch('sales_invoices', $invoice_id)) {
        return null;
    }
		
			// 🔹 Invoice (single)
			$this->db->where('id', $invoice_id);
			$this->db->where('status', 'DRAFT');
			$invoice = $this->db->get('sales_invoices')->row_array();

			// 🔹 Items + Products JOIN
			$this->db->select('
				sales_invoice_items.*,
				p.id as product_id,
				p.product_code,
				p.name,
				p.description,
				p.retailPrice,
				p.wholesalePrice,
				p.specialPrice,
				p.is_serial_trk,
				p.is_batch,
				p.is_expiry_trk,
				p.is_warranty_item,
				p.warranty_period
			');
			$this->db->from('sales_invoice_items');
			$this->db->join('products p', 'p.id = sales_invoice_items.product_id', 'left');
			$this->db->where('sales_invoice_items.invoice_id', $invoice_id);

			$items = $this->db->get()->result_array();

			return [
				'invoice' => $invoice,
				'items'   => $items
			];
		}
		
		public function get_invoices($filters =[]){
			
			$this->filterByBranch('sales_invoices');
			
			$this->db->select('sales_invoices.*,customer.cus_name,customer.company_name,customer.cus_phone,customer.cus_email,staff_info.full_name AS created_by_name,staff_info.email AS created_by_email,staff_info.phone AS created_by_phone');
			$this->db->from('sales_invoices');
			$this->db->join('customer', 'customer.cus_id = sales_invoices.customer_id', 'left');
			//$this->db->join('user', 'user.user_id = sales_invoices.created_by', 'left');
			$this->db->join('staff_info', 'staff_info.staff_id = sales_invoices.created_by', 'left');
			
			/* STAFF FILTER */
			if(!empty($filters['fk_user_id'])){
				$this->db->where('sales_invoices.created_by', $filters['fk_user_id']);
			}

			/* STATUS FILTER */
			if(!empty($filters['invoice_status'])){
				$this->db->where('sales_invoices.status', $filters['invoice_status']);
			}
			
			/* DATE RANGE FILTER */
			if(!empty($filters['date_range'])){

				$dates = explode(' – ', $filters['date_range']);

				if(count($dates) == 2){

					$start = date('Y-m-d', strtotime($dates[0]));
					$end   = date('Y-m-d', strtotime($dates[1]));

					$this->db->where('DATE(sales_invoices.invoice_date) >=', $start);
					$this->db->where('DATE(sales_invoices.invoice_date) <=', $end);
				}
			}
			
			/* PROJECT ID FILTER */
			if(!empty($filters['productId'])){
				$this->db->where('sales_invoices.project_id', $filters['productId']);
				$this->db->where('sales_invoices.status','PROJECT');
			}
			
			$this->db->order_by('sales_invoices.id', 'DESC');

			$query = $this->db->get()->result();
			return $query;
		}
		
		
		public function get_sale_counts()
		{
			// 1. Total Invoices (Filtered by branch)
			$this->filterByBranch('sales_invoices');
			$total = $this->db->count_all_results('sales_invoices');
			
			// 2. Settled Invoices (Assuming 'paid' or 'approved' status - adjust status string if needed)
			$this->filterByBranch('sales_invoices');
			$settled = $this->db->where('payment_status', 'PAID') 
								->count_all_results('sales_invoices');
			
			// 3. Outstanding Invoices (Excluding finalized statuses like paid, rejected, cancelled)
			$this->filterByBranch('sales_invoices');
			$this->db->where('payment_status !=', 'PAID');
			$outstanding = $this->db->count_all_results('sales_invoices');

			// Return format matches your GRN counts method exactly
			return [
				['name' => 'Total', 'total' => $total],
				['name' => 'Settled', 'total' => $settled],
				['name' => 'Outstanding', 'total' => $outstanding]
			];
		}
		
		
		public function get_quotation_counts()
		{
			// 1. Total Invoices (Filtered by branch and NOT a quotation)
			$this->filterByBranch('sales_invoices');
			$this->db->where('status =', 'QUOTATION');
			$total = $this->db->count_all_results('sales_invoices');

			// Return format matches your GRN counts method exactly
			return [
				['name' => 'Total', 'total' => $total]
				
			];
		}
		
		public function get_quotation($filters =[]){
			
			$this->filterByBranch('sales_invoices');
	
			$this->db->select('sales_invoices.*,customer.cus_name,customer.company_name,customer.cus_phone,customer.cus_email,staff_info.full_name AS created_by_name,staff_info.email AS created_by_email,staff_info.phone AS created_by_phone');
			$this->db->from('sales_invoices');
			$this->db->join('customer', 'customer.cus_id = sales_invoices.customer_id', 'left');
			//$this->db->join('user', 'user.user_id = sales_invoices.created_by', 'left');
			$this->db->join('staff_info', 'staff_info.staff_id = sales_invoices.created_by', 'left');
			$this->db->where('sales_invoices.status','QUOTATION');
			
			/* STAFF FILTER */
			if(!empty($filters['fk_user_id'])){
				$this->db->where('sales_invoices.created_by', $filters['fk_user_id']);
			}

			/* STATUS FILTER */
			if(!empty($filters['invoice_status'])){
				$this->db->where('sales_invoices.status', $filters['invoice_status']);
			}
			
			/* DATE RANGE FILTER */
			if(!empty($filters['date_range'])){

				$dates = explode(' – ', $filters['date_range']);

				if(count($dates) == 2){

					$start = date('Y-m-d', strtotime($dates[0]));
					$end   = date('Y-m-d', strtotime($dates[1]));

					$this->db->where('DATE(sales_invoices.invoice_date) >=', $start);
					$this->db->where('DATE(sales_invoices.invoice_date) <=', $end);
				}
			}
			
			$this->db->order_by('sales_invoices.invoice_date', 'DESC');

			$query = $this->db->get()->result();
			return $query;
		}
		
		public function delivery_note_items($invoice_id)
		{
			// 1. Get System/Company Info
			$sys = $this->db->get('sys_info')->row_array();

			// 2. Get Invoice + Customer + Staff
			$this->db->select('
				si.*, 
				c.cus_name, 
				c.cus_address, 
				c.cus_phone, 
				c.company_name as cus_company,
				s.full_name as sales_rep_name
			');
			$this->db->from('sales_invoices si');
			$this->db->join('customer c', 'c.cus_id = si.customer_id', 'left');
			$this->db->join('staff_info s', 's.staff_id = si.created_by', 'left');
			$this->db->where('si.id', $invoice_id);
			$invoice = $this->db->get()->row_array();

			// 3. Get Items
			$this->db->select('sii.*, p.product_code, p.name as prod_name');
			$this->db->from('sales_invoice_items sii');
			$this->db->join('products p', 'p.id = sii.product_id', 'left');
			$this->db->where('sii.invoice_id', $invoice_id);
			$items = $this->db->get()->result_array();

			return [
				'system'  => $sys,
				'invoice' => $invoice,
				'items'   => $items
			];
		}
		
		public function get_invoice_for_print($id)
		{
			
			// Verify invoice belongs to current branch
    if (!$this->verifyBranch('sales_invoices', $id)) {
        return null;
    }
			// 1. Fetch Company Info from sys_info table
			$company = $this->db->get('sys_info')->row();
			
			// 2. Fetch main Invoice details with Customer and User names
			$this->db->select('
				si.*, 
				c.cus_name as customer_name, 
				c.cus_address as customer_address, 
				c.cus_phone as customer_phone,
				c.company_name,
				u1.full_name as prepared_by_name
			');
			$this->db->from('sales_invoices si');
			$this->db->join('customer c', 'c.cus_id = si.customer_id', 'left');
			$this->db->join('user u1', 'u1.user_id = si.created_by', 'left');
			$this->db->where('si.id', $id);
			$query = $this->db->get();
			$invoice = $query->row();
			
			if ($invoice) {
				// Fetch Items with Product info and Unit Name
				$this->db->select('
					sii.*, 
					p.name as product_name, 
					p.product_code, 
					u.unit_name, 
					u.unit_code 
				');
				$this->db->from('sales_invoice_items sii');
				$this->db->join('products p', 'p.id = sii.product_id', 'left');
				$this->db->join('units u', 'u.unit_id = p.unit_id', 'left');
				$this->db->where('sii.invoice_id', $id);
				$invoice->items = $this->db->get()->result();
				
				// Fetch payment methods for this invoice
				$this->db->select('spi.payment_method, spi.amount');
				$this->db->from('sales_payments sp');
				$this->db->join('sales_payment_items spi', 'spi.payment_id = sp.id', 'left');
				$this->db->where('sp.invoice_id', $id);
				$payment_methods = $this->db->get()->result();
				
				$invoice->payment_methods = $payment_methods;
				
				// Format payment methods as a string
				$methods_array = [];
				foreach ($payment_methods as $pm) {
					if (!empty($pm->payment_method)) {
						$methods_array[] = ucfirst(strtolower($pm->payment_method));
					}
				}
				$invoice->payment_method_string = !empty($methods_array) ? implode(' + ', $methods_array) : 'Not specified';
			}
			
			// Add company info to the invoice object
			$invoice->company = $company;
			
			return $invoice;
		}
		public function deduct_auto_batch_stock($invoice_id) {
    $items = $this->db->select('sii.id, sii.product_id, sii.qty, sibb.batch_no, sibb.qty as batch_qty')
                      ->from('sales_invoice_items sii')
                      ->join('sales_invoice_item_batches sibb', 'sibb.invoice_item_id = sii.id', 'left')
                      ->where('sii.invoice_id', $invoice_id)
                      ->get()
                      ->result();
    
    foreach ($items as $item) {
        if ($item->batch_no) {
            // Deduct from specific batch
            $this->db->set('qty', 'qty - ' . $item->batch_qty, false)
                     ->where('batch_id', $this->get_batch_id($item->product_id, $item->batch_no))
                     ->update('inventory_stock');
        }
    }
    return true;
}
	
	
	// create a function for generate invoice number like INV-2026-01 (snthosh 21/5/2026)
	public function generate_invoice_number()
	{
		$currentYear = date('Y');
		
		$this->db->select('invoice_no');
		$this->db->like('invoice_no', 'INV-' . $currentYear . '-', 'after');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('sales_invoices');

		if ($query->num_rows() > 0) {
			$last_invoice = $query->row()->invoice_no;
			$parts = explode('-', $last_invoice);
			$last_sequence = (int) end($parts);
			$next_sequence = $last_sequence + 1;
		} else {
			$next_sequence = 1;
		}

		// Zero-pad your sequential tracking digits (e.g., 01, 02)
		$padded_sequence = str_pad($next_sequence, 2, '0', STR_PAD_LEFT);
		
		return 'INV-' . $currentYear . '-' . $padded_sequence;
	}
	
	public function get_cheques()
    {
		$this->db->select("spi.payment_id,
						spi.id,
						spi.cheque_no,
						spi.bank_name AS bank,
						'' AS branch,
						spi.amount,
						spi.cheque_date AS due_date,
						DATE(sp.payment_date) AS received_date,
						c.cus_id AS customer_id,
						c.cus_name AS customer,
						si.invoice_no AS ref_no,
						'Sale' AS ref_type,
						spi.cheque_status AS status,
						IFNULL(spi.note,'') AS note,
						NULL AS banked_to,
						NULL AS banked_date,
						NULL AS deposited_date,
						NULL AS replaced_by
					", FALSE);

					$this->db->from('sales_payment_items spi');
					$this->db->join('sales_payments sp', 'sp.id = spi.payment_id');
					$this->db->join('sales_invoices si', 'si.id = sp.invoice_id');
					$this->db->join('customer c', 'c.cus_id = si.customer_id');
					$this->db->where('spi.payment_method', 'CHEQUE');

		$cheques = $this->db->get()->result_array();

		// CUSTOMERS
		$customers = $this->db
			->select('cus_id AS id, cus_name AS name')
			->where('cus_status', 'active')
			->get('customer')
			->result_array();

		// ACCOUNTS (unique bank names from cheque records)
		$accounts = $this->db
			->distinct()
			->select('CONCAT(bank_name," A/C") AS account_name', FALSE)
			->where('payment_method', 'CHEQUE')
			->where('bank_name IS NOT NULL', NULL, FALSE)
			->where('bank_name <>', '')
			->get('sales_payment_items')
			->result_array();

		return [
			'today'     => date('Y-m-d'),
			'cheques'   => $cheques,
			'customers' => $customers,
			'accounts'  => array_column($accounts, 'account_name')
		];
	
    }
	
	
	// get supplier cheques function (created_by santhosh 8/6/2026)
	public function get_supplier_cheques()
	{
		// 1. SELECT COLUMNS USING THE MASTER CHEQUES TABLE FOR TRUE STATUS TRACKING
		$this->db->select('sp.id AS id');
		$this->db->select('sp.id AS payment_id');
		$this->db->select('sp.cheque_no AS cheque_no');
		$this->db->select('sp.note AS note'); // Reading raw, clean note field directly now
		$this->db->select('s.name AS customer');
		$this->db->select('sp.bank_name AS bank');
		$this->db->select("'' AS branch", FALSE);
		$this->db->select('si.invoice_number AS ref_no');
		$this->db->select("'Purchase' AS ref_type", FALSE);
		$this->db->select('sp.amount AS amount');
		$this->db->select('DATE(sp.payment_date) AS received_date', FALSE);
		$this->db->select('sp.cheque_date AS due_date');
		
		// Grab the status string directly from master cheques table, fallback to standard payment status
		$this->db->select('c.status AS master_cheque_status');
		$this->db->select('sp.status AS system_status');
		$this->db->select('NULL AS replaced_by', FALSE);

		$this->db->from('supplier_payments sp');
		$this->db->join('supplier_payment_allocations spa', 'spa.payment_id = sp.id', 'left');
		$this->db->join('supplier_invoices si', 'si.id = spa.invoice_id', 'left');
		$this->db->join('supply s', 's.id = sp.supplier_id', 'left');
		
		// NEW: Join with master cheques table on unique cheque number
		$this->db->join('cheques c', 'c.cheque_no = sp.cheque_no', 'left');
		
		$this->db->where('sp.payment_method', 'cheque');

		$records = $this->db->get()->result_array();
		$cheques = [];

		foreach ($records as $row) {
			// Map master database lower_case enums directly to your exact frontend UI text indicators
			$ui_status = 'Pending';
			
			if (!empty($row['master_cheque_status'])) {
				switch ($row['master_cheque_status']) {
					case 'cleared':   $ui_status = 'Cleared'; break;
					case 'presented': $ui_status = 'Deposited'; break;
					case 'bounced':   $ui_status = 'Bounced'; break;
					case 'on_hold':   $ui_status = 'On Hold'; break;
					case 'cancelled': $ui_status = 'Returned'; break;
					case 'issued':    $ui_status = 'Pending'; break;
				}
			} else {
				// System fallback check if master record entry doesn't exist yet
				$ui_status = ($row['system_status'] == 'cancelled') ? 'Cancelled' : 'Pending';
			}

			$cheques[] = [
				'id'            => $row['id'],
				'payment_id'    => $row['payment_id'],
				'cheque_no'     => $row['cheque_no'],
				'note'          => $row['note'] ?? '', // No regex stripping needed anymore!
				'customer'      => $row['customer'],
				'bank'          => $row['bank'],
				'branch'        => $row['branch'],
				'ref_no'        => $row['ref_no'] ?? '—',
				'ref_type'      => $row['ref_type'],
				'amount'        => $row['amount'],
				'received_date' => $row['received_date'],
				'due_date'      => $row['due_date'],
				'status'        => $ui_status, 
				'replaced_by'   => $row['replaced_by']
			];
		}

		// 2. ACTIVE SUPPLIERS LISTING
		$suppliers = $this->db
			->select('id, name')
			->where('status', 'active')
			->get('supply')
			->result_array();

		// 3. ACCOUNTS LISTING
		$accounts = $this->db
			->distinct()
			->select("CONCAT(bank_name, ' A/C') AS account_name", FALSE)
			->where('payment_method', 'cheque')
			->where('bank_name IS NOT NULL', NULL, FALSE)
			->where('bank_name <>', '')
			->get('supplier_payments')
			->result_array();

		return [
			'today'     => date('Y-m-d'),
			'cheques'   => $cheques,
			'suppliers' => $suppliers,
			'accounts'  => array_column($accounts, 'account_name')
		];
	}
	
	public function save_or_update($data, $id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('sales_payment_items', $data);
        }

        return $this->db->insert('sales_payment_items', $data);
    }
	
	
public function process_cheque_status_change($post_data, $user_id = null)
{
    $id = $post_data['id'];
    $action = $post_data['action'] ?? '';             
    $cheque_status = $post_data['cheque_status'] ?? ''; 
    $note = $post_data['note'] ?? '';

    // Fetch original payment details to extract target parameters
    $this->db->where('id', $id);
    $payment = $this->db->get('supplier_payments')->row();

    if (!$payment) {
        return ['status' => false, 'message' => 'Cheque payment record not found.'];
    }

    // --- 1. COMPILE VALUES FOR SUPPLIER_PAYMENTS TABLE ---
    $update_data = [];
    $update_data['note'] = trim($note); // Storing plain user input without system tags
    
    if (!empty($post_data['account_id'])) {
        $update_data['account_id'] = $post_data['account_id'];
    }
    
    // Explicitly update cheque_date if provided in the post array
    if (!empty($post_data['cheque_date'])) {
        $update_data['cheque_date'] = $post_data['cheque_date'];
    }

    // Map strict supplier_payments table ENUM state
    if ($cheque_status === 'Canclled' || $action === 'Returned') {
        $update_data['status'] = 'cancelled';
    } else {
        $update_data['status'] = 'active';
    }

    // --- 2. MAP VALUES FOR MASTER CHEQUES TABLE ---
    $master_cheque_data = [];
    $current_date = date('Y-m-d H:i:s');
    
    if ($user_id) {
        $master_cheque_data['updated_by'] = $user_id;
    }

    // Explicitly sync the cheque_date to the cheques table
    if (!empty($post_data['cheque_date'])) {
        $master_cheque_data['cheque_date'] = $post_data['cheque_date'];
    }

    // Map incoming frontend strings to the strict master cheques ENUM values
    switch ($cheque_status) {
        case 'Cleared':
            $master_cheque_data['status'] = 'cleared';
            $master_cheque_data['cleared_date'] = $current_date;
            break;
        case 'Deposited':
            $master_cheque_data['status'] = 'presented';
            $master_cheque_data['presented_date'] = $current_date;
            break;
        case 'Bounced':
            $master_cheque_data['status'] = 'bounced';
            $master_cheque_data['bounce_reason'] = !empty($note) ? trim($note) : 'Cheque bounced by bank';
            break;
        case 'On Hold':
            $master_cheque_data['status'] = 'on_hold';
            $master_cheque_data['is_hold'] = 1;
            $master_cheque_data['hold_reason'] = !empty($note) ? trim($note) : 'Placed on hold';
            $master_cheque_data['hold_by'] = $user_id;
            $master_cheque_data['hold_date'] = $current_date;
            break;
        case 'Canclled':
        case 'Cancelled':
            $master_cheque_data['status'] = 'cancelled';
            $master_cheque_data['cancel_reason'] = !empty($note) ? trim($note) : 'Payment Cancelled';
            break;
        default:
            $master_cheque_data['status'] = 'issued';
            break;
    }

    if ($cheque_status !== 'On Hold') {
        $master_cheque_data['is_hold'] = 0;
    }

    // --- 3. EXECUTE ATOMIC TRANSACTION SAFETY BLOCK ---
    $this->db->trans_start();

    // A. Update supplier payments row
    $this->db->where('id', $id);
    $this->db->update('supplier_payments', $update_data);

    // B. Update master cheques table entry using matching cheque number reference
    if (!empty($payment->cheque_no)) {
        $this->db->where('cheque_no', $payment->cheque_no);
        $this->db->update('cheques', $master_cheque_data);
    }

    // C. Automated Reversal Invoice instantiation rules
    if ($action === 'Bounced' || $action === 'Returned' || $cheque_status === 'Bounced') {
        
        $inv_prefix = ($action === 'Bounced' || $cheque_status === 'Bounced') ? 'CHQ-BNC-' : 'CHQ-RET-';
        $invoice_number = $inv_prefix . time();
		$branch  = $this->session->userdata('branch');


        $invoice_data = [
            /*'branch_id'        => $payment->branch_id,*/
            'branch_id'        => $branch,
            'invoice_number'   => $invoice_number,
            'supplier_id'      => $payment->supplier_id,
            'source_type'      => 'manual',
            'reference_number' => $payment->cheque_no,
            'invoice_date'     => date('Y-m-d'),
            'due_date'         => date('Y-m-d'),
            'subtotal'         => $payment->amount,
            'grand_total'      => $payment->amount,
            'balance_amount'   => $payment->amount,
            'paid_amount'      => 0.00,
            'status'           => 'unpaid',
            'remarks'          => 'Automated invoice reversal created due to Cheque #' . $payment->cheque_no . ' being ' . $action,
            'created_by'       => $user_id ?? $payment->created_by
        ];

        $this->db->insert('supplier_invoices', $invoice_data);
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        return ['status' => false, 'message' => 'Database process failed during transaction updates.'];
    }
    
    return ['status' => true, 'message' => 'Cheque records synchronized and updated successfully.'];
}
	

	
}	

	
/*customer_id	"11"
invoice_date	"2026-04-21"
due_date	"2026-05-21"
created_by	"22"
warehouse_id	"11"
product_id[]	"undefined"
product_name[]	"iPhone 14"
unit[]	"box"
qty[]	"1"
free_qty[]	"0"
unit_price[]	"110,000.00"
discount_value[]	"10"
remarks	""
subtotal	"Rs. 110,000.00"
tax_total	"Rs. 13,365.00"
grand_total	"Rs. 102,465.00"
total_items	"1"
total_qty	"1.00"
total_free_qty	"0 units"
bill_discount_value	"20,900.00"
payment_method	"cash"
amount[]	"102465.00"
paid_amount	"102,465.00"
balance_amount	"Balance Remaining"*/