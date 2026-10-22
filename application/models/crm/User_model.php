<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }
	
	public function get_all_users()
{
    return $this->db
        ->select('user_id as id, full_name as name, email')  // Use correct column names
        ->where('status', 'act')
        ->order_by('full_name', 'ASC')
        ->get('user')
        ->result();
}
    /**
     * Get all users
     */
    public function get_all()
    {
        return $this->db
            ->order_by('name', 'ASC')
            ->get($this->table)
            ->result();
    }

    /**
     * Get only active users
     * (for lead assignment dropdowns)
     */
    public function get_active_users()
    {
        return $this->db->where('status','act')->order_by('full_name', 'ASC')->get('user')->result();
    }
	
	public function get_active_staff()
    {
        return $this->db->where('status','act')->where('ut_id','1')->order_by('full_name', 'ASC')->get('user')->result();
    }
	
	public function get_marketing_users()
    {
		$by_user = (int) $this->session->userdata('user_id');
		
        return $this->db->where('status','act')->where('ut_id','38')->order_by('full_name','ASC')->get('user')->result();
    }

    /**
     * Get user by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id',(int)$id)->get($this->table)->row();
    }

    /**
     * Check if user exists
     */
    public function exists($id)
    {
        return $this->db
            ->where('id', (int)$id)
            ->count_all_results($this->table) > 0;
    }

    /**
     * Get user by email (for login)
     */
    public function get_by_email($email)
    {
        return $this->db
			
            ->where('email', $email)
            ->get($this->table)
            ->row();
    }

    /**
     * Create user
     */
    public function create(array $data)
    {
        $this->db->insert($this->table, [
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => password_hash($data['password'], PASSWORD_BCRYPT),
            'role'       => $data['role'] ?? 'user',
            'is_active'  => 1,
            'created_at'=> date('Y-m-d H:i:s')
        ]);

        return $this->db->insert_id();
    }

    /**
     * Update user
     */
    public function update($id, array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }

        $this->db
            ->where('id', (int)$id)
            ->update($this->table, $data);

        return $this->db->affected_rows();
    }
}
