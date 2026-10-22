<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiClients_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       VALIDATE CLIENT (Used by BaseApiController)
    ============================================================ */

    public function validate_client($client_key, $client_secret)
    {
        return $this->db
            ->where('client_key', $client_key)
            ->where('client_secret', hash('sha256', $client_secret))
            ->where('is_active', 1)
            ->get('api_clients')
            ->row_array();
    }

    /* ============================================================
       CREATE CLIENT
    ============================================================ */

    public function create($data)
    {
        $client_key = bin2hex(random_bytes(16));
        $client_secret_raw = bin2hex(random_bytes(32));
        $client_secret_hashed = hash('sha256', $client_secret_raw);

        $this->db->insert('api_clients', [
            'client_key' => $client_key,
            'client_secret' => $client_secret_hashed,
            'description' => $data['description'],
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return [
            'status' => true,
            'result_desc' => 'API client created',
            'payload' => [
                'client_key' => $client_key,
                'client_secret' => $client_secret_raw  // Only returned once
            ]
        ];
    }

    /* ============================================================
       DEACTIVATE CLIENT
    ============================================================ */

    public function deactivate($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('api_clients', ['is_active' => 0]);

        return [
            'status' => true,
            'result_desc' => 'Client deactivated',
            'payload' => null
        ];
    }

    /* ============================================================
       GET ALL CLIENTS
    ============================================================ */

    public function get_all()
    {
        $clients = $this->db
            ->select('id, client_key, description, is_active, created_at')
            ->get('api_clients')
            ->result_array();

        return [
            'status' => true,
            'result_desc' => 'Clients fetched',
            'payload' => $clients
        ];
    }
}