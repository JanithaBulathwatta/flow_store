<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_model extends CI_Model
{
    protected $table = 'units';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get all active units (unit_stt = 1 means active)
     */
    public function get_active()
    {
        return $this->db
            ->select('unit_id, unit_name, unit_code')
            ->where('unit_stt', 1)  // 1 = active, not 'active'
            ->order_by('unit_name', 'ASC')
            ->get($this->table)
            ->result_array();
    }
    
    /**
     * Get unit by ID
     */
    public function get_by_id($id)
    {
        return $this->db
            ->where('unit_id', $id)
            ->where('unit_stt', 1)
            ->get($this->table)
            ->row_array();
    }
}
?>