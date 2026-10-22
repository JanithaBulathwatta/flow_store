<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_submition extends CI_Controller
{
	
    public function __construct()
    {
        parent::__construct();
         
        $this->load->helper('url');
        

    }
	
	public function index()
    {
        $this->load->view('header');
        $this->load->view('migration/upload_form');
        $this->load->view('footer');
    }

	
public function import_sales()
{
    if (empty($_FILES['sales_file']['tmp_name'])) {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(['status' => 'error', 'message' => 'No file uploaded']));
    }

    $filePath = $_FILES['sales_file']['tmp_name'];
    $handle = fopen($filePath, 'r');
    
    if ($handle === FALSE) {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(['status' => 'error', 'message' => 'Cannot read uploaded file']));
    }

    $delimiter = ","; 
    $invoice_count = 0;
    $last_old_invoice_id = null;
    $current_new_invoice_id = null;
    $is_first_row = true; 

    $invoice_payments = []; 
    $all_new_invoice_ids = [];
    
    // Arrays to prevent duplicate tracking
    $imported_items = [];
    $imported_payments = [];

    while (($line = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
        
        // Strip BOM
        if ($is_first_row) {
            if (isset($line[0])) {
                $line[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}\x{FEFF}]/u', '', $line[0]);
            }
            $is_first_row = false;
            
            if (!is_numeric(trim($line[0]))) {
                continue; 
            }
        }

        if (count($line) < 24) {
            continue;
        }

        // =========================================================
        // FIXED INDEX MAPPING 🎯 (Aligned precisely with SQL columns)
        // =========================================================
        $old_invoice_id = trim($line[0]); 
        $invoice_no     = trim($line[1] ?? '');
        $invoice_type   = (strtoupper(trim($line[2] ?? '')) === 'PROJECT') ? 'PROJECT' : 'OTHER'; 
        $customer_id    = (!empty($line[3]) && $line[3] !== '\\N') ? intval($line[3]) : 1; 
        $invoice_date   = (!empty($line[4]) && $line[4] !== '\\N') ? date('Y-m-d H:i:s', strtotime($line[4])) : date('Y-m-d H:i:s'); 
        $due_date       = (!empty($line[5]) && $line[5] !== '\\N') ? date('Y-m-d H:i:s', strtotime($line[5])) : $invoice_date; 
        $total_qty      = floatval($line[6] ?? 0); 
        $subtotal       = floatval($line[7] ?? 0); // CSV-இல் உள்ள தொகை subtotal ஆக மாறுகிறது 🎯
        $bill_discount  = floatval($line[8] ?? 0); 
        
        // Calculating New Grand Total 
        $calculated_grand_total = $subtotal - $bill_discount;

        $status_part1   = strtoupper(($line[9] !== '\\N') ? trim($line[9] ?? '') : ''); 
        $status_part2   = strtoupper(($line[10] !== '\\N') ? trim($line[10] ?? '') : ''); 

        $payment_status = 'UNPAID';
        if ($status_part1 === 'SETTLED' || $status_part1 === 'PAID') {
            $payment_status = 'PAID';
        } elseif ($status_part1 === 'PARTIAL') {
            $payment_status = 'PARTIAL';
        }

        $status = 'COMPLETED';
        if ($status_part2 === 'DELETE' || $status_part1 === 'PENDING') {
            $status = 'DRAFT'; 
        }

        $remarks        = ($line[11] !== '\\N') ? trim($line[11]) : '';
        $created_by     = (!empty($line[12]) && $line[12] !== '\\N') ? intval($line[12]) : 1; 
        $created_at     = (!empty($line[13]) && $line[13] !== '\\N') ? date('Y-m-d H:i:s', strtotime($line[13])) : $invoice_date;
        $updated_at     = (!empty($line[14]) && $line[14] !== '\\N') ? date('Y-m-d H:i:s', strtotime($line[14])) : $invoice_date;
        $tax_total      = floatval($line[15] ?? 0);

        if (empty($invoice_no)) {
            $invoice_no = 'INV-' . str_pad($old_invoice_id, 5, '0', STR_PAD_LEFT); 
        }

        // Items Mapping
        $old_item_id    = trim($line[16] ?? '');
        $product_id     = intval($line[17] ?? 0); 
        $product_name   = ($line[18] !== '\\N' && !empty($line[18])) ? trim($line[18]) : 'Migrated Product'; 
        $qty            = ($line[19] !== '\\N') ? floatval($line[19]) : 1.0000; 
        $free_qty       = ($line[20] !== '\\N') ? floatval($line[20]) : 0.0000; 
        $unit_price     = floatval($line[21] ?? 0); 
        $discount_value = floatval($line[22] ?? 0); 
        $line_total     = floatval($line[23] ?? 0); 

        // Payments Mapping
        $old_payment_id = trim($line[24] ?? ''); 
        $payment_date   = (!empty($line[25]) && $line[25] !== '\\N') ? date('Y-m-d H:i:s', strtotime($line[25])) : null;
        $master_pay_amt = floatval($line[26] ?? 0); 
        $payment_method = strtoupper(($line[27] !== '\\N') ? trim($line[27] ?? '') : 'CASH'); 
        $split_pay_amt  = floatval($line[28] ?? 0); 

        // ==========================================
        // STAGE 1: SALES INVOICE (MASTER HEADER)
        // ==========================================
        if ($old_invoice_id !== $last_old_invoice_id) {
            
            $invoice_insert = [
                'branch_id'           => 1, 
                'invoice_no'          => $invoice_no, 
                'invoice_type'        => $invoice_type, 
                'customer_id'         => $customer_id, 
                'warehouse_id'        => 1, 
                'invoice_date'        => $invoice_date,
                'due_date'            => $due_date,
                'total_qty'           => $total_qty, 
                'subtotal'            => $subtotal, // Mapped here 🎯
                'grand_total'         => $calculated_grand_total, // Subtotal - Discount 🎯
                'paid_amount'         => 0.0000, // Will be updated in Stage 4
                'balance_amount'      => $calculated_grand_total, 
                'bill_discount_value' => $bill_discount, 
                'payment_status'      => $payment_status,
                'status'              => $status,
                'remarks'             => !empty($remarks) ? $remarks : 'Migrated Legacy Record.',
                'created_by'          => $created_by,
                'created_at'          => $created_at,
                'updated_at'          => $updated_at,
                'tax_total'           => $tax_total,
                'total_free_qty'      => 0.0000 
            ];

            $this->db->insert('sales_invoices', $invoice_insert);
            $current_new_invoice_id = $this->db->insert_id(); 
            
            $all_new_invoice_ids[] = $current_new_invoice_id; 
            $last_old_invoice_id = $old_invoice_id;
            $invoice_count++;
            $running_free_qty = 0;
        }

        // ==========================================
        // STAGE 2: SALES INVOICE ITEMS
        // ==========================================
        $item_key = $old_invoice_id . '_' . $old_item_id;
        if (!in_array($item_key, $imported_items)) {
            $running_free_qty += $free_qty;

            $item_insert = [
                'invoice_id'     => $current_new_invoice_id, 
                'product_id'     => $product_id,       
                'product_name'   => $product_name,
                'unit'           => 'PCS', 
                'qty'            => $qty,   
                'free_qty'       => $free_qty,
                'unit_price'     => $unit_price,   
                'discount_value' => $discount_value,
                'discount_type'  => 'AMOUNT',
                'line_total'     => $line_total
            ];
            $this->db->insert('sales_invoice_items', $item_insert);
            
            $imported_items[] = $item_key;

            if ($running_free_qty > 0) {
                $this->db->where('id', $current_new_invoice_id);
                $this->db->update('sales_invoices', ['total_free_qty' => $running_free_qty]);
            }
        }

        // ==========================================
        // STAGE 3: PAYMENTS
        // ==========================================
        if (!empty($old_payment_id) && $old_payment_id !== '\\N') {
            
            if (isset($invoice_payments[$old_payment_id])) {
                $sales_payment_id = $invoice_payments[$old_payment_id];
            } else {
                $payment_insert = [
                    'branch_id'    => 1,
                    'invoice_id'   => $current_new_invoice_id,
                    'payment_date' => $payment_date ?? $invoice_date,
                    'total_amount' => $master_pay_amt, 
                    'created_by'   => $created_by
                ];
                $this->db->insert('sales_payments', $payment_insert);
                $sales_payment_id = $this->db->insert_id();
                
                $invoice_payments[$old_payment_id] = $sales_payment_id;
            }

            $payment_item_key = $old_invoice_id . '_' . $old_payment_id;
            if (!in_array($payment_item_key, $imported_payments)) {
                
                $method_enum = 'CASH';
                if (strpos($payment_method, 'CARD') !== false) $method_enum = 'CARD';
                elseif (strpos($payment_method, 'BANK') !== false || strpos($payment_method, 'TRANSFER') !== false) $method_enum = 'BANK';
                elseif (strpos($payment_method, 'CHEQUE') !== false || strpos($payment_method, 'CHQ') !== false) $method_enum = 'CHEQUE';

                $payment_item_insert = [
                    'payment_id'     => $sales_payment_id,
                    'payment_method' => $method_enum,
                    'account_id'     => null, 
                    'amount'         => $split_pay_amt, 
                    'reference_no'   => 'MIGRATED_PAY',  
                    'cheque_no'      => null,
                    'cheque_date'    => null,
                    'bank_name'      => null,
                    'note'           => 'Migrated payment entry.',
                    'card_number'    => null
                ];

                $this->db->insert('sales_payment_items', $payment_item_insert);
                $imported_payments[] = $payment_item_key;
            }
        }
    }

    fclose($handle);

    // ==========================================
    // STAGE 4: PAID & BALANCE AMOUNT UPDATE 🎯
    // ==========================================
    if (!empty($all_new_invoice_ids)) {
        $this->db->query("
            UPDATE sales_invoices si
            JOIN (
                SELECT invoice_id, SUM(total_amount) as paid_sum 
                FROM sales_payments 
                WHERE invoice_id IN (" . implode(',', $all_new_invoice_ids) . ")
                GROUP BY invoice_id
            ) sp ON si.id = sp.invoice_id
            SET si.paid_amount = sp.paid_sum,
                si.balance_amount = si.grand_total - sp.paid_sum
        ");
    }

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => 'success',
            'message' => 'Sales migration successfully completed! Total Invoices: ' . $invoice_count
        ]));
}
 
}