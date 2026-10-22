<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       TRIAL BALANCE
    ============================================================ */

    public function trial_balance($data)
    {
        $this->db->select("
            a.id,
            a.account_number,
            a.account_name,
            SUM(gl.debit) as total_debit,
            SUM(gl.credit) as total_credit
        ");
        $this->db->from('accounts a');
        $this->db->join('general_ledger gl', 'gl.account_id = a.id', 'left');
        $this->db->where('gl.financial_year_id', $data['financial_year_id']);
        $this->db->group_by('a.id');
        $this->db->order_by('a.account_number', 'ASC');

        $result = $this->db->get()->result_array();

        return [
            'status' => true,
            'result_desc' => 'Trial balance generated',
            'payload' => $result
        ];
    }

    /* ============================================================
       LEDGER (ACCOUNT LEVEL)
    ============================================================ */

    public function ledger($data)
    {
        $this->db->where('account_id', $data['account_id']);

        if (!empty($data['financial_year_id'])) {
            $this->db->where('financial_year_id', $data['financial_year_id']);
        }

        if (!empty($data['date_from'])) {
            $this->db->where('transaction_date >=', $data['date_from']);
        }

        if (!empty($data['date_to'])) {
            $this->db->where('transaction_date <=', $data['date_to']);
        }

        $this->db->order_by('transaction_date', 'ASC');

        $entries = $this->db->get('general_ledger')->result_array();

        return ['status' => true,'result_desc' => 'Ledger fetched','payload' => $entries];
    }

    /* ============================================================
       PROFIT & LOSS
    ============================================================ */

    public function profit_loss($data)
    {
        $this->db->select("
            a.account_name,
            a.account_type,
            SUM(gl.debit - gl.credit) as balance
        ");
        $this->db->from('accounts a');
        $this->db->join('general_ledger gl', 'gl.account_id = a.id');
        $this->db->where('gl.financial_year_id', $data['financial_year_id']);
        $this->db->where_in('a.account_type', ['REVENUE','EXPENSE']);
        $this->db->group_by('a.id');

        $result = $this->db->get()->result_array();

        return [
            'status' => true,
            'result_desc' => 'Profit & Loss generated',
            'payload' => $result
        ];
    }

    /* ============================================================
       BALANCE SHEET
    ============================================================ */

    public function balance_sheet($data)
    {
        $this->db->select("
            a.account_name,
            a.account_type,
            SUM(gl.debit - gl.credit) as balance
        ");
        $this->db->from('accounts a');
        $this->db->join('general_ledger gl', 'gl.account_id = a.id');
        $this->db->where('gl.financial_year_id', $data['financial_year_id']);
        $this->db->where_in('a.account_type', ['ASSET','LIABILITY','EQUITY']);
        $this->db->group_by('a.id');

        $result = $this->db->get()->result_array();

        return [
            'status' => true,
            'result_desc' => 'Balance sheet generated',
            'payload' => $result
        ];
    }

    /* ============================================================
       JOURNAL VIEW
    ============================================================ */

    public function journal_view($data)
    {
        $entries = $this->db
            ->where('journal_no', $data['journal_no'])
            ->order_by('id', 'ASC')
            ->get('general_ledger')
            ->result_array();

        return [
            'status' => true,
            'result_desc' => 'Journal fetched',
            'payload' => $entries
        ];
    }
}