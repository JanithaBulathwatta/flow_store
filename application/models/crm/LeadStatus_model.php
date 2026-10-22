<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadStatus_model extends CI_Model
{
    protected $table = 'lead_statuses';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all statuses (admin listing)
     */
    public function get_all()
    {
        return $this->db
            ->order_by('sort_order', 'ASC')
            ->get($this->table)
            ->result();
    }

    /**
     * Get active statuses (for leads)
     */
    public function get_active()
    {
        return $this->db
            ->where('is_active', 1)
            ->order_by('sort_order', 'ASC')
            ->get($this->table)
            ->result();
    }

    /**
     * Get status by ID
     */
    public function get_by_id($id)
    {
        return $this->db
            ->where('id', (int)$id)
            ->get($this->table)
            ->row();
    }

    /**
     * Create status
     */
    public function create(array $data)
    {
        $this->db->insert($this->table, [
            'name'       => $data['name'],
            'color'      => $data['color'] ?? '#6c757d',
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $data['is_active'] ?? 1
        ]);

        return $this->db->insert_id();
    }

    /**
     * Update status
     */
    public function update($id, array $data)
    {
        $this->db
            ->where('id', (int)$id)
            ->update($this->table, [
                'name'       => $data['name'],
                'color'      => $data['color'] ?? '#6c757d',
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active'  => $data['is_active']
            ]);

        return $this->db->affected_rows();
    }

    /**
     * Check if status exists
     */
    public function exists($id)
    {
        return $this->db
            ->where('id', (int)$id)
            ->count_all_results($this->table) > 0;
    }
}
