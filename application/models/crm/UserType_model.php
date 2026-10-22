<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserType_model extends CI_Model {
    
    protected $table = 'sys_user_type'; 
    protected $primary_key = 'ut_id';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function exists($id)
    {
        return $this->db
            ->where($this->primary_key, (int)$id)
            ->count_all_results($this->table) > 0;
    }
    
    public function get_all($status = 'all')
    {
        $this->db->from($this->table);

        if ($status != 'all') {
            $this->db->where('status', $status);
        } else {
            $this->db->where_in('status', ['active', 'inactive']);
        }

        return $this->db
            ->order_by($this->primary_key, 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where($this->primary_key, (int)$id) 
            ->get($this->table)
            ->row(); 
    }

    public function create()
    {
        $this->load->library('form_validation');

        // Validation based on your view input name "User_type"
        $this->form_validation->set_rules('User_type', 'User Type', 'required|trim|min_length[3]');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['stt' => 'error', 'msg' => validation_errors(), 'data' => '']);
        } else {
            $user_type_val = $this->input->post('User_type', TRUE);
            
            $data = [
                'ut_name' => $user_type_val,
                'ut_type' => $user_type_val, // Both columns get the same value as requested
                'status'  => 'active',
                'com_id'  => 0, // Default or session based
                'editable' => 1
            ];

            $this->db->insert($this->table, $data);
            $insert_id = $this->db->insert_id();

            if ($insert_id) {
                echo json_encode(array("stt" => "ok", "msg" => "User Type Created Successfully !!", "data" => $insert_id));
            } else {
                echo json_encode(array("stt" => "error", "msg" => "Something Went Wrong !!", "data" => ''));
            }
        }
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'User Type Module','Create User Type','INSERT');
		//end of activity log
    }
    
    public function update()
    {
        $id = $this->input->post('utId', TRUE); 
        $user_type_val = $this->input->post('User_type', TRUE);
        
        $data = [
            'ut_name' => $user_type_val,
            'ut_type' => $user_type_val
        ];
        
        $this->db->where($this->primary_key, (int)$id)->update($this->table, $data);

        if($this->db->affected_rows() >= 0){ 
            // Note: affected_rows is 0 if no changes were made but query was successful
            echo json_encode(array("stt"=>"ok","msg"=>"User Type Updated Successfully !!","data"=>$id));
        } else {
            echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
        }
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'User Type Module','Update User Type','UPDATE');
		//end of activity log
    }
    
    public function delete($id)
    {
        $id = (int)$id;

        if (!$id) {
            echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
            return;
        }

        $this->db->where($this->primary_key, $id);
        $update = $this->db->update($this->table, ['status' => 'delete']);

        if ($update) {
            echo json_encode(['stt' => 'ok','msg' => 'User Type Deleted Successfully!','data' => $id]);
        } else {
            echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
        }
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'User Type Module','Delete User Type','DELETE');
		//end of activity log
    }

    public function get_counts() {
        $data = [];
        
        $this->db->where_in('status', ['active', 'inactive']);
        $data['all_count'] = $this->db->count_all_results($this->table);
        
        $this->db->where('status', 'active');
        $data['active_count'] = $this->db->count_all_results($this->table);
        
        $this->db->where('status', 'inactive');
        $data['inactive_count'] = $this->db->count_all_results($this->table);
        
        $this->db->where('status', 'delete');
        $data['deleted_count'] = $this->db->count_all_results($this->table);
        
        return (object) $data;
    }
}