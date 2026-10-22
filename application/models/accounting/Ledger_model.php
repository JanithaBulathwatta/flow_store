 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       INSERT MULTIPLE LEDGER LINES (ATOMIC)
    ============================================================ */

    public function insert_journal($journal_no, $financial_year_id, $voucher_type_id, $lines, $meta = [])
    {
        if (empty($lines)) {
            throw new Exception('Journal lines cannot be empty');
        }

        $this->db->trans_start();

        try {

            $this->validate_balanced($lines);

            foreach ($lines as $line) {

                if (empty($line['account_id'])) {
                    throw new Exception('Account ID missing in journal line');
                }

                if (!$this->is_posting_account($line['account_id'])) {
                    throw new Exception('Posting to non-posting account is not allowed');
                }

                $insert = [
                    'journal_no' => $journal_no,
                    'voucher_type_id' => $voucher_type_id,
                    'transaction_date' => $meta['transaction_date'] ?? date('Y-m-d'),
                    'financial_year_id' => $financial_year_id,
                    'account_id' => $line['account_id'],
                    'debit' => $line['debit'] ?? 0,
                    'credit' => $line['credit'] ?? 0,
                    'description' => $meta['description'] ?? null,
                    'reference_type' => $meta['reference_type'] ?? null,
                    'reference_no' => $meta['reference_no'] ?? null,
                    'event_log_id' => $meta['event_log_id'] ?? null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $meta['created_by'] ?? null
                ];

                $this->db->insert('general_ledger', $insert);
            }

            $this->db->trans_complete();

            return true;

        } catch (Exception $e) {

            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            throw $e;
        }
    }

    /* ============================================================
       VALIDATE BALANCE
    ============================================================ */

    private function validate_balanced($lines)
    {
        $debit = 0;
        $credit = 0;

        foreach ($lines as $line) {
            $debit += (float)($line['debit'] ?? 0);
            $credit += (float)($line['credit'] ?? 0);
        }

        if (round($debit, 2) !== round($credit, 2)) {
            throw new Exception('Unbalanced journal entry');
        }
    }

    /* ============================================================
       CHECK IF ACCOUNT IS POSTING ACCOUNT
    ============================================================ */

    private function is_posting_account($account_id)
    {
        $account = $this->db
            ->select('is_posting, is_control_account')
            ->where('id', $account_id)
            ->get('accounts')
            ->row_array();

        if (!$account) {
            return false;
        }

        if ($account['is_posting'] != 1) {
            return false;
        }

        if ($account['is_control_account'] == 1) {
            return false;
        }

        return true;
    }

    /* ============================================================
       FETCH JOURNAL BY NUMBER
    ============================================================ */

    public function get_journal($journal_no)
    {
        return $this->db
            ->where('journal_no', $journal_no)
            ->order_by('id', 'ASC')
            ->get('general_ledger')
            ->result_array();
    }

    /* ============================================================
       CHECK IF JOURNAL EXISTS
    ============================================================ */

    public function journal_exists($journal_no)
    {
        return $this->db
            ->where('journal_no', $journal_no)
            ->limit(1)
            ->count_all_results('general_ledger') > 0;
    }

    /* ============================================================
       REVERSE JOURNAL (IMMUTABLE SAFE)
    ============================================================ */

    public function reverse_journal($journal_no, $financial_year_id, $voucher_type_id, $meta = [])
    {
        $original = $this->get_journal($journal_no);

        if (empty($original)) {
            throw new Exception('Journal not found');
        }

        $reverse_lines = [];

        foreach ($original as $entry) {
            $reverse_lines[] = [
                'account_id' => $entry['account_id'],
                'debit' => $entry['credit'],
                'credit' => $entry['debit']
            ];
        }

        $reverse_journal_no = 'REV-' . $journal_no;

        $this->insert_journal(
            $reverse_journal_no,
            $financial_year_id,
            $voucher_type_id,
            $reverse_lines,
            $meta
        );

        return $reverse_journal_no;
    }

    /* ============================================================
       GET ACCOUNT BALANCE (FAST AGGREGATION)
    ============================================================ */

    public function get_account_balance($account_id, $financial_year_id)
    {
        $this->db->select('SUM(debit - credit) as balance');
        $this->db->where('account_id', $account_id);
        $this->db->where('financial_year_id', $financial_year_id);

        $result = $this->db->get('general_ledger')->row_array();

        return isset($result['balance']) ? (float)$result['balance'] : 0;
    }
}