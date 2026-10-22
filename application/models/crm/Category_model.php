<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{
    protected $table = 'categories';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get active categories for dropdown
     */
    /*public function get_active()
    {
        return $this->db
            ->select('id, name, super_category_id')
            ->where('status', 'active')
            ->order_by('name', 'ASC')
            ->get($this->table)
            ->result_array();
    }*/
	
	
	/**
	 * Get categories with status filter
	 */
	public function get_active($status = 'all')
	{
		$this->db
			->select('id, name, super_category_id')
			->from($this->table);

		if ($status != 'all') {
			$this->db->where('status', $status);
		} else {
			$this->db->where_in('status', ['active','inactive','delete']);
		}

		return $this->db
			->order_by('name', 'ASC')
			->get()
			->result_array();
	}

    /**
     * Get categories by super category
     */
    public function get_by_super_category($super_category_id)
    {
        return $this->db
            ->select('id, name')
            ->where('super_category_id', (int)$super_category_id)
            ->where('status', 'active')
            ->order_by('name', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    /**
     * Get category by ID
     */
    public function get_by_id($id)
    {
        return $this->db
            ->where('id', (int)$id)
            ->where('status', 'active')
            ->get($this->table)
            ->row_array();
    }
}