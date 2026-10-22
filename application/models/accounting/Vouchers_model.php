<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       CREATE VOUCHER TYPE
    ============================================================ */

    public function create($data)
    {
        try {

            $this->db->insert('voucher_types', [
                'code' => strtoupper($data['code']),
                'name' => $data['name'],
                'prefix' => strtoupper($data['prefix']),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return [
                'status' => true,
                'result_desc' => 'Voucher type created successfully',
                'payload' => null
            ];

        } catch (Exception $e) {

            log_message('error', $e->getMessage());

            return [
                'status' => false,
                'result_desc' => 'Failed to create voucher type',
                'payload' => null
            ];
        }
    }

    /* ============================================================
       UPDATE VOUCHER TYPE
    ============================================================ */

    public function update($data)
    {
        $allowed = ['name', 'prefix', 'is_active'];

        $update = [];

        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $update[$field] = $data[$field];
            }
        }

        if (empty($update)) {
            return [
                'status' => false,
                'result_desc' => 'Nothing to update',
                'payload' => null
            ];
        }

        $this->db->where('id', $data['id']);
        $this->db->update('voucher_types', $update);

        return [
            'status' => true,
            'result_desc' => 'Voucher updated successfully',
            'payload' => null
        ];
    }

    /* ============================================================
       GET ALL VOUCHERS
    ============================================================ */

    public function get_all()
    {
        $result = $this->db
            ->order_by('code', 'ASC')
            ->get('voucher_types')
            ->result_array();

        return [
            'status' => true,
            'result_desc' => 'Voucher list fetched',
            'payload' => $result
        ];
    }

    /* ============================================================
       GET BY ID
    ============================================================ */

    public function get_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('voucher_types')
            ->row_array();
    }
}