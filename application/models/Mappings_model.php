<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mappings_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       CREATE MAPPING
    ============================================================ */

    public function create_mapping($data)
    {
        try {

            $insert = [
                'event_code' => $data['event_code'],
                'line_type' => $data['line_type'],
                'account_source_type' => $data['account_source_type'],
                'fixed_account_id' => isset($data['fixed_account_id']) ? $data['fixed_account_id'] : null,
                'amount_source_field' => $data['amount_source_field'],
                'narration_template' => isset($data['narration_template']) ? $data['narration_template'] : null,
                'sequence' => isset($data['sequence']) ? $data['sequence'] : 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('accounting_event_mappings', $insert);

            return [
                'status' => true,
                'result_desc' => 'Mapping created successfully',
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
       GET ACTIVE MAPPINGS BY EVENT
    ============================================================ */

    public function get_active_mappings_by_event($event_code)
    {
        return $this->db->where('event_code', $event_code)->where('is_active', 1)->order_by('sequence', 'ASC')->get('accounting_event_mappings')->result_array();
    }

    /* ============================================================
       UPDATE MAPPING
    ============================================================ */

    public function update_mapping($data)
    {
        $allowed = [
            'line_type',
            'account_source_type',
            'fixed_account_id',
            'amount_source_field',
            'narration_template',
            'sequence',
            'is_active'
        ];

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
        $this->db->update('accounting_event_mappings', $update);

        return [
            'status' => true,
            'result_desc' => 'Mapping updated successfully',
            'payload' => null
        ];
    }

    /* ============================================================
       MANAGE CONDITIONS
    ============================================================ */

    public function manage_conditions($data)
    {
        if (isset($data['conditions'])) {

            foreach ($data['conditions'] as $condition) {

                $insert = [
                    'mapping_id' => $data['mapping_id'],
                    'field_name' => $condition['field_name'],
                    'operator' => $condition['operator'],
                    'value' => $condition['value']
                ];

                $this->db->insert('accounting_event_conditions', $insert);
            }
        }

        return [
            'status' => true,
            'result_desc' => 'Conditions saved',
            'payload' => null
        ];
    }
}