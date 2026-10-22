<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       ACCOUNTING EVENT LOGS
    ============================================================ */

    public function get_event_logs($filters = [])
    {
        if (!empty($filters['event_code'])) {
            $this->db->where('event_code', $filters['event_code']);
        }

        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }

        $logs = $this->db
            ->order_by('created_at', 'DESC')
            ->get('accounting_event_log')
            ->result_array();

        return [
            'status' => true,
            'result_desc' => 'Event logs fetched',
            'payload' => $logs
        ];
    }

    /* ============================================================
       API REQUEST LOGS
    ============================================================ */

    public function get_api_logs($filters = [])
    {
        if (!empty($filters['client_key'])) {
            $this->db->where('client_key', $filters['client_key']);
        }

        $logs = $this->db
            ->order_by('created_at', 'DESC')
            ->get('api_request_logs')
            ->result_array();

        return [
            'status' => true,
            'result_desc' => 'API logs fetched',
            'payload' => $logs
        ];
    }

    /* ============================================================
       YEAR END LOGS
    ============================================================ */

    public function get_year_end_logs()
    {
        $logs = $this->db
            ->order_by('closed_at', 'DESC')
            ->get('year_end_logs')
            ->result_array();

        return [
            'status' => true,
            'result_desc' => 'Year-end logs fetched',
            'payload' => $logs
        ];
    }
}