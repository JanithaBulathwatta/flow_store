<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EventLog_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       CHECK IDEMPOTENCY KEY
    ============================================================ */

    public function idempotency_exists($idempotency_key)
    {
        return $this->db
            ->where('reference_no', $idempotency_key)
            ->where('status', 'SUCCESS')
            ->limit(1)
            ->count_all_results('accounting_event_log') > 0;
    }

    /* ============================================================
       CREATE EVENT LOG ENTRY
    ============================================================ */

    public function create_event_log($event_code, $payload, $idempotency_key)
    {
        $insert = [
            'event_code' => $event_code,
            'reference_no' => $idempotency_key,
            'source_module' => 'API',
            'payload_json' => json_encode($payload),
            'status' => 'PENDING',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('accounting_event_log', $insert);

        return $this->db->insert_id();
    }

    /* ============================================================
       MARK SUCCESS
    ============================================================ */

    public function mark_success($event_log_id, $journal_no)
    {
        $this->db->where('id', $event_log_id);
        $this->db->update('accounting_event_log', [
            'status' => 'SUCCESS',
            'journal_no' => $journal_no,
            'processed_at' => date('Y-m-d H:i:s')
        ]);
    }

    /* ============================================================
       MARK FAILED
    ============================================================ */

    public function mark_failed($event_log_id, $error_message)
    {
        $this->db->where('id', $event_log_id);
        $this->db->update('accounting_event_log', [
            'status' => 'FAILED',
            'error_message' => $error_message,
            'processed_at' => date('Y-m-d H:i:s')
        ]);
    }

    /* ============================================================
       FETCH EVENT BY IDEMPOTENCY KEY
    ============================================================ */

    public function get_by_idempotency_key($idempotency_key)
    {
        return $this->db
            ->where('reference_no', $idempotency_key)
            ->get('accounting_event_log')
            ->row_array();
    }
}