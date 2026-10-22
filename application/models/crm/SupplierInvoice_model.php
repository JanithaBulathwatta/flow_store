<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'traits/BranchTrait.php';
class SupplierInvoice_model extends CI_Model {
use BranchTrait;
    

    public function __construct() {
        parent::__construct();
    }
	
	
	public function get_all_invoices()
	{
		$this->filterByBranch('si');
		return $this->db
			->select("
				si.*,
				s.name as supplier_name,
				DATEDIFF(CURDATE(), si.invoice_date) as invoice_age,
				DATEDIFF(CURDATE(), si.due_date) as due_age
			")
			->from('supplier_invoices si')
			->join('supply s', 's.id = si.supplier_id', 'left') 
			->order_by('si.id', 'DESC')
			->get()
			->result();
	}
	
	
	// updeted function for pay 3 type of payment at the same time )(santhosh -> 08/05/2026)

	public function create_payment()
	{
		$this->db->trans_start(); 

		$supplier_id = $this->input->post('supplier_id');
		$remarks = $this->input->post('payment_remarks');
		$user_id = $this->session->userdata('user_id');
		$invoice_ids_str = $this->input->post('selected_invoice_ids');
		
		// Fetch Supplier Name for the 'payee_name' field in cheques table
		$supplier = $this->db->get_where('supply', ['id' => $supplier_id])->row();
		$payee_name = $supplier ? $supplier->name : 'Unknown Supplier';

		$methods = [
			'cash' => [
				'date'    => $this->input->post('cash_payment_date'),
				'amount'  => (float)$this->input->post('cash_payment_amount'),
				'account' => $this->input->post('cash_account_id'),
				'ref'     => NULL, 'chq_no' => NULL, 'chq_dt' => NULL, 'bank' => NULL
			],
			'transfer' => [
				'date'    => $this->input->post('transfer_payment_date'),
				'amount'  => (float)$this->input->post('transfer_payment_amount'),
				'account' => $this->input->post('transfer_bank_account_id'),
				'ref'     => $this->input->post('transfer_ref_no'),
				'chq_no'  => NULL, 'chq_dt' => NULL, 'bank' => $this->input->post('bank_name'),
			],
			'cheque' => [
				'date'    => $this->input->post('cheque_payment_date'),
				'amount'  => (float)$this->input->post('cheque_payment_amount'),
				'account' => $this->input->post('account_id'),
				'ref'     => NULL,
				'chq_no'  => $this->input->post('cheque_no'),
				'chq_dt'  => $this->input->post('cheque_date'),
				'bank'    => $this->input->post('cheque_bank_name')
			]
		];

		$created_payments = [];
		$total_collected = 0;

		foreach ($methods as $type => $data) {
			if ($data['amount'] > 0) {
				$payment_data = [
					'branch_id'      => $this->session->userdata('branch_id'),
					'supplier_id'    => $supplier_id,
					'payment_date'   => $data['date'],
					'payment_method' => $type,
					'account_id'     => $data['account'],
					'amount'         => $data['amount'],
					'reference_no'   => $data['ref'],
					'cheque_no'      => $data['chq_no'],
					'cheque_date'    => $data['chq_dt'] ?: NULL,
					'bank_name'      => $data['bank'],
					'note'           => $remarks,
					'created_by'     => $user_id,
					'created_at'     => date('Y-m-d H:i:s')
				];

				$this->db->insert('supplier_payments', $payment_data);
				$payment_id = $this->db->insert_id();

				// --- CHEQUE TABLE UPDATE LOGIC ---
				if ($type === 'cheque') {
					$cheque_update = [
						'cheque_date'    => $data['chq_dt'],
						'payee_name'     => $this->input->post('Payee_name'),
						'amount'         => $data['amount'],
						'status'         => 'issued',
						'issued_by'      => $user_id,
						'issued_date'    => date('Y-m-d H:i:s'),
						'remarks'        => $remarks,
						'updated_by'     => $user_id
					];

					// Update the existing unused cheque based on Bank Account and Cheque Number
					$this->db->where('bank_account_id', $data['account']);
					$this->db->where('cheque_no', $data['chq_no']);
					$this->db->update('cheques', $cheque_update);
				}
				// ---------------------------------

				$created_payments[] = [
					'id' => $payment_id,
					'remaining' => $data['amount']
				];
				$total_collected += $data['amount'];
			}
		}

		// 2. Handle Allocations
		if ($total_collected > 0 && !empty($invoice_ids_str)) {
			$invoice_ids = explode(',', $invoice_ids_str);
			
			foreach ($invoice_ids as $inv_id) {
				$inv = $this->db->get_where('supplier_invoices', ['id' => $inv_id])->row();
				if (!$inv) continue;

				$invoice_balance = (float)$inv->balance_amount;
				if ($invoice_balance <= 0) continue;

				// We need to use the created payments to cover this invoice balance
				foreach ($created_payments as &$pay) {
					if ($pay['remaining'] <= 0 || $invoice_balance <= 0) continue;

					$allocate_this = min($pay['remaining'], $invoice_balance);

					if ($allocate_this > 0) {
						// INSERT ALLOCATION RECORD
						$this->db->insert('supplier_payment_allocations', [
							'payment_id'       => $pay['id'],
							'invoice_id'       => $inv_id,
							'allocated_amount' => $allocate_this
						]);

						$pay['remaining'] -= $allocate_this;
						$invoice_balance -= $allocate_this;
					}
				}

				// Update the Invoice Status based on what was allocated
				$new_paid = (float)$inv->paid_amount + ((float)$inv->balance_amount - $invoice_balance);
				$new_balance = (float)$inv->grand_total - $new_paid;
				// Determine the logic
				if ($new_balance <= 0) {
					$invoice_status = 'paid';
					$history_status = 'paid';
				} else {
					$invoice_status = 'partial';      
					$history_status = 'partial_paid'; 
				}

				// Update Invoice Table
				$this->db->where('id', $inv_id);
				$this->db->update('supplier_invoices', [
					'paid_amount'    => $new_paid,
					'balance_amount' => $new_balance,
					'status'         => $invoice_status 
				]);

				// Insert into History Table
				$this->db->insert('supplier_invoice_history', [
					'invoice_id' => $inv_id,
					'action'     => $history_status, 
					'action_by'  => $user_id,
					'note'       => $remarks,
					'created_at' => date('Y-m-d H:i:s')
				]);
			}
		}
		
		
		//for activity log entry
		$supplier    = $this->Supply_model->get_supplier_by_id($supplier_id);
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$msg = "pay  [Invoice ID:" . $invoice_ids_str . "]";
		
		// Define the number and email
		$phone      = isset($supplier->phone) ? $supplier->phone : "";
		$email      = isset($supplier->email) ? $supplier->email : "";
		
		$this->Activity_log_m->addLog($user_id_fk, $user_type, 'Supplier Invoice Module', 'Pay To Supplier', 'INSERT', true, 1, $phone, $email, $msg);
		//end of activity log
		
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}


	// get the cheque book information 
	public function get_unused_cheque_details($cheque_no) {
    $this->db->select('c.bank_account_id, c.cheque_book_id, ba.account_number, b.bank_name');
    $this->db->from('cheques c');
    
    // Join chain to reach the true text value for bank names
    $this->db->join('bank_accounts ba', 'ba.bank_acc_id = c.bank_account_id'); 
    $this->db->join('banks b', 'b.bank_id = ba.bank_id');
    
    $this->db->where('c.cheque_no', $cheque_no);
    $this->db->where('c.status', 'unused'); 
    $this->db->limit(1);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row();
    }
    return null;
}
	
	// GET SUM AND COUNTS OF THE INVOICES
	public function get_stats() {
		$data = [];
		$today = date('Y-m-d');
		$first_day_month = date('Y-m-01');

		
		$data['total_count'] = $this->db->count_all_results('supplier_invoices');

		
		$this->db->select('SUM(balance_amount) as total_bal, COUNT(id) as total_qty');
		$this->db->where_in('status', ['unpaid', 'partial']);
		$out_query = $this->db->get('supplier_invoices')->row();
		$data['outstanding_sum'] = $out_query->total_bal ?? 0;
		$data['outstanding_count'] = $out_query->total_qty ?? 0;

		
		$this->db->select('SUM(balance_amount) as overdue_bal, COUNT(id) as overdue_qty');
		$this->db->where('due_date <', $today);
		$this->db->where_in('status', ['unpaid', 'partial']);
		$overdue_query = $this->db->get('supplier_invoices')->row();
		$data['overdue_sum'] = $overdue_query->overdue_bal ?? 0;
		$data['overdue_count'] = $overdue_query->overdue_qty ?? 0;

		
		$this->db->select('SUM(paid_amount) as paid_bal, COUNT(id) as paid_qty');
		$this->db->where('status', 'paid');
		$this->db->where('updated_at >=', $first_day_month);
		$paid_query = $this->db->get('supplier_invoices')->row();
		$data['paid_month_sum'] = $paid_query->paid_bal ?? 0;
		$data['paid_month_count'] = $paid_query->paid_qty ?? 0;

		return (object) $data;
	}	
	
	public function cancel_supplier_invoice($id)
    {
        
        $invoice = $this->db->get_where('supplier_invoices', ['id' => $id])->row();
        
        if (!$invoice || $invoice->status === 'paid') {
            return false;
        }

        $this->db->trans_start();

        //  Update the Invoice Status
        $this->db->where('id', $id);
        $this->db->update('supplier_invoices', [
            'status'     => 'cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Log the action in the History Table
        $this->db->insert('supplier_invoice_history', [
            'invoice_id'     => $id,
            'action'         => 'cancelled',
            'note'           => 'Invoice cancelled via management dashboard',
            'action_by'     => $this->session->userdata('user_id'),
            'created_at'     => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
	
		
	public function get_invoice_history($invoice_id) {
		$this->db->select('
			h.*, 
			p.payment_method, 
			p.cheque_no, 
			p.reference_no, 
			u.full_name as staff_name,
			a.allocated_amount
		');
		$this->db->from('supplier_invoice_history h');
		$this->db->join('user u', 'u.user_id = h.action_by', 'left');
		
		// Join via Allocation using the timestamp AND the invoice ID
		// We remove the GROUP BY so each payment method shows as a separate line in history
		$this->db->join('supplier_payment_allocations a', 'a.invoice_id = h.invoice_id AND ABS(TIMESTAMPDIFF(SECOND, h.created_at, a.created_at)) < 2', 'left');
		$this->db->join('supplier_payments p', 'p.id = a.payment_id', 'left');
		
		$this->db->where('h.invoice_id', $invoice_id);
		$this->db->order_by('h.created_at', 'DESC');
		
		$query = $this->db->get();
		return $query->result();
	}
		
		/**
	 * Get invoices for a specific supplier
	 */
	public function get_supplier_invoices($supplier_id)
	{
		return $this->db
			->select("
				si.*,
				DATEDIFF(CURDATE(), si.due_date) as days_overdue
			")
			->from('supplier_invoices si')
			->where('si.supplier_id', $supplier_id)
			->order_by('si.invoice_date', 'DESC')
			->get()
			->result();
	}

	/**
	 * Get invoice items/details if you have an items table
	 */
	public function get_invoice_items($invoice_id)
	{
		// If you have an invoice items table, query it here
		// Otherwise return empty array
		return $this->db
			->select('*')
			->from('supplier_invoice_items')
			->where('invoice_id', $invoice_id)
			->get()
			->result();
	}

}	