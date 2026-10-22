<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log_model extends CI_Model {

    protected $table = 'activity_log';
    //protected $table = 'user';

    public function __construct() {
        parent::__construct();
    }
	
	 public function get_all()
    {
        return $this->db
            ->select('
                al.*,
                u.full_name
            ')
            ->from('activity_log al')
            ->join('user u', 'u.user_id = al.user_id_fk', 'left')
            ->order_by('al.created_at', 'DESC')
            ->get()
            ->result();
    }
	
	
	public function get_filtered($date = null, $module = null, $user = null)
    {

        $this->db
            ->select('
                al.*,
                u.full_name
            ')
            ->from('activity_log al')
            ->join('user u', 'u.user_id = al.user_id_fk', 'left');


        /* DATE RANGE FILTER */
        if (!empty($date)) {

            $dates = explode(' – ', $date);

            if (count($dates) == 2) {

                $start = date('Y-m-d', strtotime(trim($dates[0])));
                $end   = date('Y-m-d', strtotime(trim($dates[1])));

                $this->db->where('DATE(al.created_at) >=', $start);
                $this->db->where('DATE(al.created_at) <=', $end);
            }
        }


        /* MODULE FILTER */
        if (!empty($module)) {
            $this->db->where('al.module', $module);
        }


        /* USER FILTER */
        if (!empty($user)) {
            $this->db->where('al.user_id_fk', $user);
        }


        return $this->db
            ->order_by('al.created_at', 'DESC')
            ->get()
            ->result();
    }
	
	/*public function get_by_id($id)
	{
		return $this->db
			->select('
				al.*,
				u.full_name AS user_name
			')
			->from('activity_log al')
			->join('user u', 'u.user_id = al.user_id_fk', 'left')
			->where('al.activitylog_id', (int)$id)
			->get()
			->row();
	}*/
	
	public function get_by_id($id)
{
    return $this->db
        ->select('al.*, u.full_name AS user_name')
        ->from('activity_log al')
        ->join('user u', 'u.user_id = al.user_id_fk', 'left')
        ->where('al.activitylog_id', $id)
        ->get()
        ->row();
}
	
}	