<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadComment_model extends CI_Model
{
    protected $table = 'lead_comments';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get comments by lead
     */
    public function get_by_lead($lead_id)
    {
        return $this->db
            ->select('
                c.id,
                c.comment,
                c.created_at,
                u.full_name AS commented_by
            ')
            ->from('lead_comments c')
            ->join('user u', 'u.user_id = c.commented_by')
            ->where('c.lead_id', (int)$lead_id)
            ->order_by('c.created_at', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Create new comment
     */
    public function create(array $data)
    {
        $this->db->insert($this->table, [
            'lead_id'      => (int)$data['lead_id'],
            'comment'      => $data['comment'],
            //'commented_by' => (int)$data['commented_by'],
            'commented_by' => $this->session->userdata('user_id'),
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        return $this->db->insert_id();
    }
}
