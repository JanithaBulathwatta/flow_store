<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_model extends CI_Model
{
    protected $table = 'units';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_active()
    {
        return $this->db
            ->where('unit_stt', 1)
            ->order_by('unit_name', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where('unit_id', $id)
            ->get($this->table)
            ->row();
    }

    public function get_unit_name($id)
    {
        $unit = $this->get_by_id($id);
        return $unit ? $unit->unit_name : '';
    }

    public function get_unit_code($id)
    {
        $unit = $this->get_by_id($id);
        return $unit ? $unit->unit_code : '';
    }
}