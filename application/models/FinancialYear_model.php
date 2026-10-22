<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FinancialYear_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       CREATE FINANCIAL YEAR
    ============================================================ */

    public function create_year($data)
    {
        try {

            if (strtotime($data['start_date']) >= strtotime($data['end_date'])) {
                throw new Exception('Invalid date range');
            }

            $insert = [
                'year_name' => $data['year_name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'is_active' => 0,
                'is_closed' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('financial_years', $insert);

            return [
                'status' => true,
                'result_desc' => 'Financial year created successfully',
                'payload' => null
            ];

        } catch (Exception $e) {

            log_message('error', $e->getMessage());

            return [
                'status' => false,
                'result_desc' => $e->getMessage(),
                'payload' => null
            ];
        }
    }

    /* ============================================================
       ACTIVATE FINANCIAL YEAR
    ============================================================ */

    public function activate_year($data)
    {
        $this->db->trans_start();

        try {

            // Deactivate all
            $this->db->update('financial_years', ['is_active' => 0]);

            // Activate selected
            $this->db->where('id', $data['id']);
            $this->db->update('financial_years', ['is_active' => 1]);

            $this->db->trans_complete();

            return [
                'status' => true,
                'result_desc' => 'Financial year activated',
                'payload' => null
            ];

        } catch (Exception $e) {

            $this->db->trans_rollback();
            log_message('error', $e->getMessage());

            return [
                'status' => false,
                'result_desc' => $e->getMessage(),
                'payload' => null
            ];
        }
    }

    /* ============================================================
       GET ACTIVE YEAR
    ============================================================ */

    public function get_active_year()
    {
        return $this->db
            ->where('is_active', 1)
            ->where('is_closed', 0)
            ->get('financial_years')
            ->row_array();
    }

    /* ============================================================
       VALIDATE DATE WITHIN ACTIVE YEAR
    ============================================================ */

    public function validate_date_within_year($date)
    {
        $year = $this->get_active_year();

        if (!$year) {
            throw new Exception('No active financial year');
        }

        if ($date < $year['start_date'] || $date > $year['end_date']) {
            throw new Exception('Transaction date outside active financial year');
        }

        return true;
    }

    /* ============================================================
       CLOSE FINANCIAL YEAR
    ============================================================ */

    public function close_year($data)
    {
        $this->db->trans_start();

        try {

            $year = $this->db
                ->where('id', $data['id'])
                ->where('is_closed', 0)
                ->get('financial_years')
                ->row_array();

            if (!$year) {
                throw new Exception('Invalid or already closed year');
            }

            // Calculate profit/loss
            $profit_loss = $this->calculate_profit_loss($year['id']);

            // Get retained earnings account
            $retained_account = $this->db
                ->where('config_key', 'retained_earnings_account')
                ->get('system_config')
                ->row_array();

            if (!$retained_account) {
                throw new Exception('Retained earnings account not configured');
            }

            // Transfer profit/loss
            if ($profit_loss != 0) {

                $this->db->insert('general_ledger', [
                    'journal_no' => 'YEAR-END-' . $year['year_name'],
                    'voucher_type_id' => 1,
                    'transaction_date' => $year['end_date'],
                    'financial_year_id' => $year['id'],
                    'account_id' => $retained_account['config_value'],
                    'debit' => ($profit_loss < 0) ? abs($profit_loss) : 0,
                    'credit' => ($profit_loss > 0) ? $profit_loss : 0,
                    'description' => 'Year End Transfer',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            // Mark closed
            $this->db->where('id', $year['id']);
            $this->db->update('financial_years', [
                'is_closed' => 1,
                'closed_at' => date('Y-m-d H:i:s')
            ]);

            $this->db->trans_complete();

            return [
                'status' => true,
                'result_desc' => 'Financial year closed successfully',
                'payload' => null
            ];

        } catch (Exception $e) {

            $this->db->trans_rollback();
            log_message('error', $e->getMessage());

            return [
                'status' => false,
                'result_desc' => $e->getMessage(),
                'payload' => null
            ];
        }
    }

    /* ============================================================
       CALCULATE PROFIT & LOSS
    ============================================================ */

    private function calculate_profit_loss($financial_year_id)
    {
        $this->db->select('SUM(debit - credit) as balance');
        $this->db->where('financial_year_id', $financial_year_id);
        $this->db->where_in('account_id', function($db){
            $db->select('id')
               ->from('accounts')
               ->where_in('account_type', ['REVENUE','EXPENSE']);
        });

        $result = $this->db->get('general_ledger')->row_array();

        return isset($result['balance']) ? (float)$result['balance'] : 0;
    }
}