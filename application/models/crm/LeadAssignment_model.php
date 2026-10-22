<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadAssignment_model extends CI_Model
{
    protected $table = 'lead_assignments';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Assign or reassign a lead
     * - Updates current owner in leads table
     * - Inserts assignment history
     */
    /*public function assign($lead_id, $assigned_to, $assigned_by)
    {
        $this->db->trans_start();

        // Update current assigned user in leads table
        $this->db
            ->where('id', (int)$lead_id)
            ->update('leads', [
                'assigned_user_id' => (int)$assigned_to
            ]);

        // Insert assignment history
        $this->db->insert($this->table, [
            'lead_id'     => (int)$lead_id,
            'assigned_to' => (int)$assigned_to,
            'assigned_by' => (int)$assigned_by,
            'assigned_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();
        //return $this->db->trans_status();
		
		// Return lead_id if success, otherwise false
		if ($this->db->trans_status()) {
			return (int)$lead_id;
		}

		return false;
		
    }*/
	
	public function assign($lead_id, $assigned_to, $assigned_by)
	{
		$this->db->trans_start();

		$this->db->where('id', (int)$lead_id)->update('leads', ['assigned_user_id' => (int)$assigned_to]);
		
		$this->db->insert($this->table, [
			'lead_id'     => (int)$lead_id,
			'assigned_to' => (int)$assigned_to,
			'assigned_by' => (int)$assigned_by,
			'assigned_at' => date('Y-m-d H:i:s')
		]);

		$this->db->trans_complete();

		if ($this->db->trans_status()) {
			return (int)$lead_id;   // ✅ return id
		}

		return false;
	}


    /**
     * Get assignment history for a lead
     */
    /*public function get_history($lead_id)
    {
        return $this->db
            ->select('
                a.assigned_at,
                u_to.name AS assigned_to,
                u_by.name AS assigned_by
            ')
            ->from('lead_assignments a')
            ->join('users u_to', 'u_to.id = a.assigned_to')
            ->join('users u_by', 'u_by.id = a.assigned_by')
            ->where('a.lead_id', (int)$lead_id)
            ->order_by('a.assigned_at', 'ASC')
            ->get()
            ->result();
    }*/
	public function get_history($lead_id)
	{
		return $this->db
			->select('
				a.assigned_at,
				u_to.full_name AS assigned_to_name,
				u_by.full_name AS assigned_by_name
			')
			->from('lead_assignments a')
			->join('user u_to', 'u_to.user_id = a.assigned_to', 'left')
			->join('user u_by', 'u_by.user_id = a.assigned_by', 'left')
			->where('a.lead_id', (int)$lead_id)
			->order_by('a.assigned_at', 'ASC')
			->get()
			->result();
	}

}
