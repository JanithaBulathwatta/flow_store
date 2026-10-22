<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mappings_model');
        $this->load->model('FinancialYear_model');
        $this->load->model('JournalSequence_model');
        $this->load->model('EventLog_model');
    }

    /* ============================================================
       HANDLE ACCOUNTING EVENT (MAIN ENTRY POINT)
    ============================================================ */

    /* ============================================================
       HANDLE ACCOUNTING EVENT (MAIN ENTRY POINT)
    ============================================================ */

    public function handle_request($request, $idempotency_key)
    {
        // Check idempotency
        if ($this->EventLog_model->idempotency_exists($idempotency_key)) {
            return [
                'status' => false,
                'result_desc' => 'Duplicate request detected',
                'error_code' => 'DUPLICATE_REQUEST',
                'payload' => null
            ];
        }

        $this->db->trans_start();

        try {

            $event_code = $request['function'];
            $payload    = $request['payload'];
            $note       = isset($request['note']) ? $request['note'] : null;

            // Get active financial year
            $financial_year = $this->FinancialYear_model->get_active_year();

            if (!$financial_year) {
                throw new Exception('No active financial year');
            }

            // Create event log
            $event_log_id = $this->EventLog_model->create_event_log(
                $event_code,
                $payload,
                $idempotency_key
            );
			
			if ($event_code === 'MANUAL_JV') {

				if (!isset($payload['lines']) || empty($payload['lines'])) {
					throw new Exception('Manual journal lines missing');
				}

				$journal_lines = $payload['lines'];

			} else {

				$mappings = $this->Mappings_model->get_active_mappings_by_event($event_code);

				if (empty($mappings)) {
					throw new Exception('No mapping found for event');
				}

				$journal_lines = $this->build_journal_lines($mappings, $payload);
			}

            // Validate balance
            $this->validate_balanced($journal_lines);

            // Generate journal number
            $journal_no = $this->JournalSequence_model
                ->generate_journal_number($financial_year['id']);

            // Insert ledger entries
            foreach ($journal_lines as $line) {

                $insert = [
                    'journal_no' => $journal_no,
                    'voucher_type_id' => 1,
                    'transaction_date' => date('Y-m-d'),
                    'financial_year_id' => $financial_year['id'],
                    'account_id' => $line['account_id'],
                    'debit' => $line['debit'],
                    'credit' => $line['credit'],
                    'description' => $note,
                    'event_log_id' => $event_log_id,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->db->insert('general_ledger', $insert);
            }

            // Mark event log success
            $this->EventLog_model->mark_success($event_log_id, $journal_no);

            $this->db->trans_complete();

            return [
                'status' => true,
                'result_desc' => 'Journal posted successfully',
                'payload' => [
                    'journal_no' => $journal_no
                ]
            ];

        } catch (Exception $e) {

            $this->db->trans_rollback();
            log_message('error', $e->getMessage());

            return [
                'status' => false,
                'result_desc' => $e->getMessage(),
                'error_code' => 'POSTING_FAILED',
                'payload' => null
            ];
        }
    }

    /* ============================================================
       BUILD JOURNAL LINES
    ============================================================ */

    private function build_journal_lines($mappings, $payload)
    {
        $lines = [];

        foreach ($mappings as $map) {

            $amount = isset($payload[$map['amount_source_field']])
                ? (float)$payload[$map['amount_source_field']]
                : 0;

            if ($amount <= 0) continue;

            $account_id = $this->resolve_account($map, $payload);

            if ($map['line_type'] === 'DEBIT') {
                $lines[] = [
                    'account_id' => $account_id,
                    'debit' => $amount,
                    'credit' => 0
                ];
            } else {
                $lines[] = [
                    'account_id' => $account_id,
                    'debit' => 0,
                    'credit' => $amount
                ];
            }
        }

        return $lines;
    }


    /* ============================================================
       VALIDATE BALANCE
    ============================================================ */

    private function validate_balanced($lines)
    {
        $debit = 0;
        $credit = 0;

        foreach ($lines as $line) {
            $debit += $line['debit'];
            $credit += $line['credit'];
        }

        if (round($debit,2) !== round($credit,2)) {
            throw new Exception('Unbalanced journal entry');
        }
    }

    /* ============================================================
       RESOLVE ACCOUNT
    ============================================================ */

    private function resolve_account($map, $payload)
    {
        if ($map['account_source_type'] === 'FIXED') {
            return $map['fixed_account_id'];
        }

        if ($map['account_source_type'] === 'FROM_PAYLOAD') {
            return $payload[$map['account_field']];
        }

        throw new Exception('Unsupported account source type');
    }
}