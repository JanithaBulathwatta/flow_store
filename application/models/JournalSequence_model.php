<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JournalSequence_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       GENERATE JOURNAL NUMBER (CONCURRENCY SAFE)
    ============================================================ */

    public function generate_journal_number($financial_year_id, $voucher_type_id = 1)
    {
        $this->db->trans_start();

        try {

            // Lock the row for update
            $row = $this->db
                ->query("
                    SELECT * FROM journal_sequences 
                    WHERE financial_year_id = ? 
                    AND voucher_type_id = ? 
                    FOR UPDATE
                ", [$financial_year_id, $voucher_type_id])
                ->row_array();

            if (!$row) {

                // Initialize sequence if not exists
                $this->db->insert('journal_sequences', ['financial_year_id' => $financial_year_id,'voucher_type_id' => $voucher_type_id,'last_number' => 1,'created_at' => date('Y-m-d H:i:s')]);

                $sequence_number = 1;

            } else {

                $sequence_number = $row['last_number'] + 1;

                $this->db->where('id', $row['id']);
                $this->db->update('journal_sequences', [
                    'last_number' => $sequence_number,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            $this->db->trans_complete();

            // Fetch voucher prefix
            $voucher = $this->db
                ->where('id', $voucher_type_id)
                ->get('voucher_types')
                ->row_array();

            $prefix = $voucher ? $voucher['prefix'] : 'JV';

            // Format: JV-2026-000001
            $year = $this->db
                ->where('id', $financial_year_id)
                ->get('financial_years')
                ->row_array();

            $year_name = $year ? $year['year_name'] : date('Y');

            return sprintf(
                "%s-%s-%06d",
                $prefix,
                $year_name,
                $sequence_number
            );

        } catch (Exception $e) {

            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            throw new Exception('Failed to generate journal number');
        }
    }
}