<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 
class HP_model extends CI_Model
{
    /**
     * Get invoices with 'HIRE PURCHASE' status for HP conversion
     * No payment_status condition - just get all HIRE PURCHASE invoices
     */
    public function get_eligible_invoices()
    {
        $sql = "
            SELECT 
                si.id as db_id, 
                si.invoice_no as id,
                c.cus_name as customer,
                si.invoice_date as date,
                si.grand_total as total,
                si.grand_total as outstanding,
                '' as items,
                'unsettled' as status
            FROM sales_invoices si
            LEFT JOIN customer c ON c.cus_id = si.customer_id
            WHERE si.status = 'HIRE PURCHASE'
            ORDER BY si.invoice_date DESC
        ";
        
        $invoices = $this->db->query($sql)->result_array();
        
        // Add items description for each invoice
        foreach ($invoices as &$inv) {
            $items = $this->db->select('GROUP_CONCAT(product_name SEPARATOR ", ") as items')
                              ->where('invoice_id', $inv['db_id'])
                              ->get('sales_invoice_items')
                              ->row();
            $inv['items'] = $items ? $items->items : '';
        }
        
        return $invoices;
    }
    
	
	/**
     * Search invoices with 'HIRE PURCHASE' status by term
     */
    public function search_eligible_invoices($search_term)
    {
        $sql = "
            SELECT 
                si.id as db_id, 
                si.invoice_no as id,
                c.cus_name as customer,
				c.cus_phone as phone,
                c.cus_email as email,
                c.cus_address as address,
                si.invoice_date as date,
                si.grand_total as total,
                si.grand_total as outstanding,
                '' as items,
                'unsettled' as status
            FROM sales_invoices si
            LEFT JOIN customer c ON c.cus_id = si.customer_id
            WHERE si.status = 'HIRE PURCHASE'
                AND (si.invoice_no LIKE ? OR c.cus_name LIKE ?)
            ORDER BY si.invoice_date DESC
        ";
        
        $search_term = "%{$search_term}%";
        $invoices = $this->db->query($sql, [$search_term, $search_term])->result_array();
        
        // Add items description for each invoice
        foreach ($invoices as &$inv) {
            $items = $this->db->select('GROUP_CONCAT(product_name SEPARATOR ", ") as items')
                              ->where('invoice_id', $inv['db_id'])
                              ->get('sales_invoice_items')
                              ->row();
            $inv['items'] = $items ? $items->items : '';
        }
        
        return $invoices;
    }


    /**
 * Get single invoice by ID
 */
public function get_invoice($invoice_id)
    {
        $sql = "
            SELECT 
                si.id as db_id,
                si.invoice_no as id,
                c.cus_name as customer,
                c.cus_phone as phone,
                c.cus_email as email,
                c.cus_address as address,
                si.invoice_date as date,
                si.grand_total as total,
                si.grand_total as outstanding,
                'unsettled' as status
            FROM sales_invoices si
            LEFT JOIN customer c ON c.cus_id = si.customer_id
            WHERE si.invoice_no = ?    
        ";
        
        $invoice = $this->db->query($sql, [$invoice_id])->row_array();
        
        if ($invoice) {
            $items = $this->db->select('GROUP_CONCAT(product_name SEPARATOR ", ") as items')
                              ->where('invoice_id', $invoice['db_id'])
                              ->get('sales_invoice_items')
                              ->row();
            $invoice['items'] = $items ? $items->items : '';
            $invoice['id'] = $invoice['db_id'];
        }
        
        return $invoice;
    }
    

		/**
	 * Available HP plans from database
	 */
	public function get_plans()
	{
		$plans = $this->db
			->select('id, months, name, rate, interest_free, min_dp_pct, processing_fee')
			->from('hp_plans')
			->where('is_active', 1)
			->order_by('display_order', 'ASC')
			->get()
			->result_array();
		
		// Convert interest_free from 0/1 to false/true
		foreach ($plans as &$plan) {
			$plan['interest_free'] = (bool)$plan['interest_free'];
		}
		
		return $plans;
	}

		/**
	 * Return a single plan by ID from database
	 */
	public function get_plan($plan_id)
	{
		$plan = $this->db
			->select('id, months, name, rate, interest_free, min_dp_pct, processing_fee')
			->from('hp_plans')
			->where('id', $plan_id)
			->where('is_active', 1)
			->get()
			->row_array();
		
		if ($plan) {
			$plan['interest_free'] = (bool)$plan['interest_free'];
		}
		
		return $plan;
	}
	
	
    /**
     * Required / optional KYC document types.
     */
    public function get_kyc_doc_types()
    {
        return [
            ['id' => 'kyc1', 'name' => 'National Identity Card (Both Sides)', 'required' => TRUE],
            ['id' => 'kyc2', 'name' => 'Proof of Address (Utility Bill / Bank Statement)', 'required' => TRUE],
            ['id' => 'kyc3', 'name' => 'Pay Slip / Income Proof', 'required' => TRUE],
            ['id' => 'kyc4', 'name' => 'Employment Letter', 'required' => FALSE],
            ['id' => 'kyc5', 'name' => 'Bank Statement (3 months)', 'required' => FALSE],
        ];
    }


    /* ─────────────────────────────────────────────────────────────
     *  VALIDATION
     * ───────────────────────────────────────────────────────────── */

    /**
     * Validate the full HP creation payload.
     *
     * @param  array $data  POST payload
     * @return array        ['valid' => bool, 'errors' => []]
     */
    public function validate_create($data)
    {
        $errors = [];

        /* ── Invoice ── */
        if (empty($data['invoice_id'])) {
            $errors[] = 'Invoice is required.';
        } else {
            $inv = $this->get_invoice($data['invoice_id']);
            if ( ! $inv) {
                $errors[] = 'Selected invoice is not eligible for hire purchase.';
            }
        }

        /* ── Plan ── */
        if (empty($data['plan_id'])) {
            $errors[] = 'A hire purchase plan must be selected.';
        } else {
            $plan = $this->get_plan($data['plan_id']);
            if ( ! $plan) {
                $errors[] = 'Selected plan is invalid.';
            }
        }

        /* ── Client ── */
        if (empty(trim($data['client_name'] ?? '')))  $errors[] = 'Client name is required.';
        if (empty(trim($data['client_nic'] ?? '')))   $errors[] = 'Client NIC / Passport is required.';
        if (empty(trim($data['client_phone'] ?? ''))) $errors[] = 'Client phone number is required.';

        if ( ! empty($data['client_email']) && ! filter_var($data['client_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Client email address is invalid.';
        }

        /* ── Down payment ── */
        if ( ! isset($inv) || ! isset($plan)) {
            /* Already flagged above; skip DP check to avoid cascading errors */
        } else {
            $dp  = (float)($data['down_payment'] ?? 0);
            $min = ceil($inv['outstanding'] * $plan['min_dp_pct'] / 100);

            if ($dp <= 0) {
                $errors[] = 'Down payment amount is required.';
            } elseif ($dp < $min) {
                $errors[] = sprintf(
                    'Down payment must be at least LKR %s (%d%% of outstanding).',
                    number_format($min, 2),
                    $plan['min_dp_pct']
                );
            }  
        }

        /* ── Guarantors ── */
        $guarantors = $data['guarantors'] ?? [];
        if (empty($guarantors) || ! is_array($guarantors)) {
            $errors[] = 'At least one guarantor is required.';
        } else {
            foreach ($guarantors as $i => $g) {
                $n = $i + 1;
                if (empty(trim($g['name'] ?? '')))  $errors[] = "Guarantor {$n}: name is required.";
                if (empty(trim($g['nic'] ?? '')))   $errors[] = "Guarantor {$n}: NIC is required.";
                if (empty(trim($g['phone'] ?? ''))) $errors[] = "Guarantor {$n}: phone is required.";
            }

        }

        /* ── Required KYC documents ── */
        $uploaded_docs = $data['kyc_uploaded'] ?? [];   /* array of doc type IDs uploaded */
        foreach ($this->get_kyc_doc_types() as $doc) {
            if ($doc['required'] && ! in_array($doc['id'], $uploaded_docs)) {
                $errors[] = "KYC document '{$doc['name']}' is required.";
            }
        }

        return [
            'valid'  => empty($errors),
            'errors' => $errors,
        ];
    }


    /* ─────────────────────────────────────────────────────────────
     *  SCHEDULE COMPUTATION
     * ───────────────────────────────────────────────────────────── */

    /**
     * Build instalment schedule rows.
     *
     * @param  float  $outstanding  Invoice outstanding amount
     * @param  float  $down_payment Amount collected upfront
     * @param  array  $plan         Plan array from get_plan()
     * @param  string $start_date   'Y-m-d' — first instalment base date (defaults to today)
     * @return array  [ ['no', 'due_date', 'principal', 'interest', 'instalment', 'balance'], … ]
     */
    public function compute_schedule($outstanding, $down_payment, $plan, $start_date = NULL)
    {
        $principal   = $outstanding - $down_payment;
        $months      = (int)$plan['months'];
        $annual_rate = (float)$plan['rate'];
        $rows        = [];
        $balance     = $principal;

        $base = $start_date ? new DateTime($start_date) : new DateTime();

        if ($plan['interest_free']) {
            /* Equal principal instalments, zero interest */
            $instalment = ceil($principal / $months);

            for ($i = 1; $i <= $months; $i++) {
                $due = clone $base;
                $due->modify("+{$i} months");

                $prin = ($i === $months) ? $balance : min($instalment, $balance);
                $balance -= $prin;

                $rows[] = [
                    'no'         => $i,
                    'due_date'   => $due->format('Y-m-d'),
                    'principal'  => round($prin, 2),
                    'interest'   => 0.00,
                    'instalment' => round($prin, 2),
                    'balance'    => round($balance, 2),
                ];
            }
        } else {
            /* Reducing balance EMI */
            $monthly_rate = $annual_rate / 100 / 12;
            $emi = $principal
                * $monthly_rate
                * pow(1 + $monthly_rate, $months)
                / (pow(1 + $monthly_rate, $months) - 1);
            $emi = round($emi, 2);

            for ($i = 1; $i <= $months; $i++) {
                $due = clone $base;
                $due->modify("+{$i} months");

                $interest = round($balance * $monthly_rate, 2);
                $prin     = ($i === $months) ? $balance : round($emi - $interest, 2);
                $balance  = round(max(0, $balance - $prin), 2);

                $rows[] = [
                    'no'         => $i,
                    'due_date'   => $due->format('Y-m-d'),
                    'principal'  => $prin,
                    'interest'   => $interest,
                    'instalment' => round($prin + $interest, 2),
                    'balance'    => $balance,
                ];
            }
        }

        return $rows;
    }


    /* ─────────────────────────────────────────────────────────────
     *  REFERENCE NUMBER GENERATOR
     * ───────────────────────────────────────────────────────────── */

    /**
     * Generate next HP reference number:  HP-YYYY-NNNN
     */
    private function _generate_ref()
    {
        $year = date('Y');
        $last = $this->db
            ->select_max('hp_id')
            ->get('HP_AGREEMENT')
            ->row();

        $next = $last && $last->hp_id ? (int)$last->hp_id + 1 : 1;

        return 'HP-' . $year . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }


    /* ─────────────────────────────────────────────────────────────
     *  SAVE — MAIN ENTRY POINT
     * ───────────────────────────────────────────────────────────── */

    /**
     * Validate + save a new HP agreement.
     *
     * @param  array $data  Structured payload (see below)
     * @return array  ['success' => bool, 'hp_ref' => string|null, 'errors' => []]
     *
     * Expected $data shape:
     * [
     *   'invoice_id'    => 'INV-2024-0341',
     *   'plan_id'       => 'P12',
     *   'client_name'   => 'Nimal Perera',
     *   'client_nic'    => '199012345678',
     *   'client_phone'  => '0771234567',
     *   'client_email'  => 'nimal@example.com',     // optional
     *   'client_dob'    => '1990-05-12',             // optional
     *   'client_addr'   => '12 Perera Mawatha',      // optional
     *   'client_job'    => 'Engineer',               // optional
     *   'down_payment'  => 97000,
     *   'guarantors'    => [
     *       ['name'=>'...','nic'=>'...','phone'=>'...','rel'=>'...','addr'=>'...'],
     *   ],
     *   'kyc_uploaded'  => ['kyc1','kyc2','kyc3'],   // doc type IDs
     *   'kyc_paths'     => ['kyc1'=>'uploads/hp/kyc1_abc.jpg', ...],
     * ]
     */
    public function create($data)
    {
        /* 1. Validate */
        $v = $this->validate_create($data);
        if ( ! $v['valid']) {
            return ['success' => FALSE, 'hp_ref' => NULL, 'errors' => $v['errors']];
        }

        $inv  = $this->get_invoice($data['invoice_id']);
        $plan = $this->get_plan($data['plan_id']);
        $dp   = (float)$data['down_payment'];

        /* 2. Build schedule before DB writes */
        $schedule = $this->compute_schedule($inv['outstanding'], $dp, $plan);

        $total_interest   = array_sum(array_column($schedule, 'interest'));
        $total_repayable  = array_sum(array_column($schedule, 'instalment'));

        /* 3. Begin transaction */
        $this->db->trans_begin();

        try {
            /* 3a. HP_AGREEMENT */
            $hp_ref = $this->_generate_ref();

            $this->db->insert('HP_AGREEMENT', [
                'hp_ref'           => $hp_ref,
                'hp_invoice_id'    => $inv['id'],
                'hp_plan_id'       => $plan['id'],
                'hp_plan_name'     => $plan['name'],
                'hp_months'        => $plan['months'],
                'hp_rate'          => $plan['rate'],
                'hp_interest_free' => (int)$plan['interest_free'],
                'hp_outstanding'   => $inv['outstanding'],
                'hp_down_payment'  => $dp,
                'hp_principal'     => $inv['outstanding'] - $dp,
                'hp_processing_fee'=> $plan['processing_fee'],
                'hp_total_interest'=> $total_interest,
                'hp_total_repayable'=> $total_repayable,
                'hp_client_name'   => trim($data['client_name']),
                'hp_client_nic'    => trim($data['client_nic']),
                'hp_client_phone'  => trim($data['client_phone']),
                'hp_client_email'  => trim($data['client_email'] ?? ''),
                'hp_client_dob'    => $data['client_dob'] ?? NULL,
                'hp_client_addr'   => trim($data['client_addr'] ?? ''),
                'hp_client_job'    => trim($data['client_job'] ?? ''),
                'hp_status'        => 'active',
                'hp_created_by'    => $this->session->userdata('user_id') ?? 1,
                'hp_created_at'    => date('Y-m-d H:i:s'),
            ]);

            $hp_id = $this->db->insert_id();

            /* 3b. HP_SCHEDULE — one row per instalment */
            foreach ($schedule as $row) {
                $this->db->insert('HP_SCHEDULE', [
                    'hs_hp_id'      => $hp_id,
                    'hs_no'         => $row['no'],
                    'hs_due_date'   => $row['due_date'],
                    'hs_principal'  => $row['principal'],
                    'hs_interest'   => $row['interest'],
                    'hs_instalment' => $row['instalment'],
                    'hs_balance'    => $row['balance'],
                    'hs_status'     => 'pending',
                    'hs_paid_amt'   => 0,
                    'hs_paid_date'  => NULL,
                ]);
            }

            /* 3c. HP_GUARANTOR */
            foreach ($data['guarantors'] as $g) {
                $this->db->insert('HP_GUARANTOR', [
                    'hg_hp_id'  => $hp_id,
                    'hg_name'   => trim($g['name']),
                    'hg_nic'    => trim($g['nic']),
                    'hg_phone'  => trim($g['phone']),
                    'hg_rel'    => trim($g['rel'] ?? ''),
                    'hg_addr'   => trim($g['addr'] ?? ''),
                ]);
            }

            /* 3d. HP_DOCUMENT — only docs that were uploaded */
            $kyc_paths = $data['kyc_paths'] ?? [];
            foreach ($data['kyc_uploaded'] as $doc_id) {
                $this->db->insert('HP_DOCUMENT', [
                    'hd_hp_id'   => $hp_id,
                    'hd_type_id' => $doc_id,
                    'hd_path'    => $kyc_paths[$doc_id] ?? '',
                    'hd_uploaded_at' => date('Y-m-d H:i:s'),
                ]);
            }

            /* 3e. Mark invoice as HP-linked (update status in invoice table) */
            /* TODO: uncomment when invoice table is live
             * $this->db->where('si_ref', $inv['id'])
             *          ->update('SI_INVOICE', [
             *              'si_status'  => 'hp_linked',
             *              'si_hp_ref'  => $hp_ref,
             *          ]);
             */

            /* 4. Commit */
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed.');
            }

            $this->db->trans_commit();

            return [
                'success' => TRUE,
                'hp_ref'  => $hp_ref,
                'hp_id'   => $hp_id,
                'errors'  => [],
            ];

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'HP_model::create — ' . $e->getMessage());

            return [
                'success' => FALSE,
                'hp_ref'  => NULL,
                'errors'  => ['A system error occurred. Please try again.'],
            ];
        }
    }


    /* ─────────────────────────────────────────────────────────────
     *  READ HELPERS  (used by list + dashboard — future screens)
     * ───────────────────────────────────────────────────────────── */

    /**
     * All HP agreements, newest first.
     */
    public function get_all($filters = [])
    {
        $this->db->from('HP_AGREEMENT');

        if ( ! empty($filters['status'])) {
            $this->db->where('hp_status', $filters['status']);
        }
        if ( ! empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('hp_ref', $s)
                ->or_like('hp_client_name', $s)
                ->or_like('hp_invoice_id', $s)
                ->group_end();
        }

        return $this->db->order_by('hp_id', 'DESC')->get()->result_array();
    }

    /**
     * Single HP agreement with full schedule, guarantors, and documents.
     */
    public function get_one($hp_id)
    {
        $agreement = $this->db->get_where('HP_AGREEMENT', ['hp_id' => $hp_id])->row_array();
        if ( ! $agreement) return NULL;

        $agreement['schedule']   = $this->db
            ->order_by('hs_no', 'ASC')
            ->get_where('HP_SCHEDULE', ['hs_hp_id' => $hp_id])
            ->result_array();

        $agreement['guarantors'] = $this->db
            ->get_where('HP_GUARANTOR', ['hg_hp_id' => $hp_id])
            ->result_array();

        $agreement['documents']  = $this->db
            ->get_where('HP_DOCUMENT', ['hd_hp_id' => $hp_id])
            ->result_array();

        return $agreement;
    }
	
	
}
