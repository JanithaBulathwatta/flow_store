<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       GET ALL CONFIG
    ============================================================ */

    public function get_all()
    {
        $configs = $this->db
            ->order_by('config_key', 'ASC')
            ->get('system_config')
            ->result_array();

        return [
            'status' => true,
            'result_desc' => 'Configurations fetched',
            'payload' => $configs
        ];
    }

    /* ============================================================
       GET SINGLE VALUE
    ============================================================ */

    public function get_value($key)
    {
        $row = $this->db
            ->where('config_key', $key)
            ->get('system_config')
            ->row_array();

        return $row ? $row['config_value'] : null;
    }

    /* ============================================================
       UPDATE CONFIG
    ============================================================ */

    public function update_config($data)
    {
        $existing = $this->db
            ->where('config_key', $data['config_key'])
            ->get('system_config')
            ->row_array();

        if ($existing) {

            $this->db->where('config_key', $data['config_key']);
            $this->db->update('system_config', [
                'config_value' => $data['config_value']
            ]);

        } else {

            $this->db->insert('system_config', [
                'config_key' => $data['config_key'],
                'config_value' => $data['config_value'],
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return [
            'status' => true,
            'result_desc' => 'Configuration updated',
            'payload' => null
        ];
    }
}