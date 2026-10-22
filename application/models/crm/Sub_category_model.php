<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_category_model extends CI_Model {
    
    protected $table = 'sub_category'; 
    
    public function __construct() {
        parent::__construct();
    }
	
	    public function exists($lead_id)
    {
        return $this->db
            ->where('id', (int)$lead_id)
            ->count_all_results($this->table) > 0;
    }
    
	
	
	public function get_all($status = 'all')
	{
		
			
		
		$this->db
			->select('
				sc.*, 
				sp.name AS super_category_name, 
				COUNT(p.id) AS product_count
			')
			->from('sub_category sc')
			->join('super_category sp', 'sp.id = sc.super_category_id', 'left')
			->join('products p', 'p.sub_category_id = sc.id AND p.status != "deleted"', 'left')
			->group_by('sc.id');

		if ($status != 'all') {
			$this->db->where('sc.status', $status);
		} else {
			$this->db->where_in('sc.status', ['active', 'inactive']);
		}
		
		return $this->db
			->order_by('sc.id', 'DESC')
			->get()
			->result();
		
	}

	public function get_by_id($id)
	{
		
			


		return $this->db
			->select('
				sc.*, 
				sp.name AS super_category_name,
				sp.code AS super_category_code
			')
			->from('sub_category sc')
			->join('super_category sp', 'sp.id = sc.super_category_id', 'left')
			
			->where('sc.id', (int)$id) 
			->get()
			->row(); 
	}
	

	public function create()
{
    $this->load->library('form_validation');

    // Set Validation Rules based on your Sub Category table
    $this->form_validation->set_rules('Category_name', 'Category Name', 'required|trim');
    $this->form_validation->set_rules('Category_code', 'Category Code', 'required|trim');
    $this->form_validation->set_rules('super_category_id', 'Super Category', 'required|numeric');
    

    if ($this->form_validation->run() == FALSE) {
        // Return validation errors to AJAX
        echo json_encode(['stt' => 'error', 'msg' => validation_errors(), 'data' => '']);
    } else {
        // Prepare Data for the sub_category table
        $data = [
            'name'              => $this->input->post('Category_name', TRUE),
            'code'              => $this->input->post('Category_code', TRUE),
            'super_category_id' => $this->input->post('super_category_id', TRUE),
            'count'             => $this->input->post('Category_count', TRUE) ?: 0,
            'status'            => 'active' // Default status for new items
        ];

        //  Insert into the database
        $this->db->insert('sub_category', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            echo json_encode(array("stt" => "ok", "msg" => "Sub Category Created Successfully !!", "data" => $insert_id));
        } else {
            echo json_encode(array("stt" => "error", "msg" => "Something Went Wrong !!", "data" => ''));
        }
    }
	
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Sub Category Module','Create Sub Category','INSERT');
		//end of activity log
}
	
	    public function update()
    {
		
		$id = $_POST['lid'];
		
		$data = ['name'    => $this->input->post('Category_name', TRUE),
				'code'   => $this->input->post('Category_code', TRUE),
				'super_category_id'   => $this->input->post('super_category_id', TRUE),
				//'count'           => $this->input->post('super_category_id', TRUE),
				];
		
        $this->db->where('id', (int)$id)->update($this->table, $data);

		if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Sub Category Updated Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Sub Category Module','Update Sub Category','UPDATE');
		//end of activity log

        //return $this->db->affected_rows();
    }
	
		public function delete($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}

		$this->db->where('id', $id);
		$update = $this->db->update('sub_category',['status' => 'delete']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Sub Category Deleted Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Sub Category Module','Delete Sub Category','DELETE');
		//end of activity log
	}
	
	 
	/**
     * Get all active sub categories
     */
    public function get_active()
    {
		

		
        return $this->db
            ->select('id, name, super_category_id')
            ->where('status', 'active')
            ->order_by('name', 'ASC')
            ->get($this->table)
            ->result_array();
    }
	
	/**
     * Get sub categories by super category ID
     */
    public function get_by_super_category($super_category_id)
    {
        return $this->db
            ->select('id, name')
            ->where('super_category_id', $super_category_id)
            ->where('status', 'active')
            ->order_by('name', 'ASC')
            ->get($this->table)
            ->result_array();
    }
	
	 /**
     * Get counts by status
     */
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