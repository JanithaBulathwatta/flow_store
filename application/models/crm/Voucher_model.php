<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_model extends CI_Model {

   protected $table = 'voucher';

    public function __construct() {
        parent::__construct();
    }
	
	public function exists($lead_id)
    {
        return $this->db->where('id', (int)$lead_id)->count_all_results($this->table) > 0;
    }
	
	public function get_all($status = 'all')
	{
		$this->db->select('voucher.*')->from('voucher');
			
		if ($status != 'all') {
			$this->db->where('status', $status);
		} else {
			$this->db->where_in('status', ['active','Issued']);
		}

		return $this->db->order_by('voucher.id', 'DESC')->get()->result();
	}

	public function get_data_for_approval(){
		$this->db->select('voucher.*');
		$this->db->from('voucher');	
		$this->db->where('status','pending');
		return $this->db->order_by('voucher.id', 'DESC')->get()->result();
	}


	public function get_by_id($id)
	{
		return $this->db
			->select('vr.*, ur.full_name AS user_name')
			->from('voucher vr')
			->join('user ur', 'ur.user_id = vr.voucher_name', 'left')
			
			->where('vr.id', (int)$id) 
			->get()
			->row(); 
	}
	

	public function create()
	{
		$this->load->library('form_validation');

		// Set Validation Rules based on your Sub Category table
		$this->form_validation->set_rules('emp_name','Receiver ID','required|trim');
		$this->form_validation->set_rules('Voucher_Amount','Voucher Amount','required|trim|numeric');
		$this->form_validation->set_rules('voucher_date','Voucher Date','required|trim');
		$this->form_validation->set_rules('notes','Notes','required|trim');

		if ($this->form_validation->run() == FALSE) {
        // Return validation errors to AJAX
			echo json_encode(['stt' => 'error', 'msg' => validation_errors(), 'data' => '']);
		} else {
			// Prepare Data for the sub_category table
			$data = ['emp_name'=> $this->input->post('emp_name', TRUE),
					 'amount'=> $this->input->post('Voucher_Amount', TRUE),
					 'note'=> $this->input->post('notes', TRUE),
					 'voucher_date'=> $this->input->post('voucher_date', TRUE)
					];

			//  Insert into the database
			$this->db->insert('voucher', $data);
			$insert_id = $this->db->insert_id();

			if ($insert_id) {
				echo json_encode(array("stt" => "ok", "msg" => "Voucher Created Successfully !!", "data" => $insert_id));
			} else {
				echo json_encode(array("stt" => "error", "msg" => "Something Went Wrong !!", "data" => ''));
			}
		}
	
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Voucher Module','Create Voucher','INSERT');
		//end of activity log
	}
	
	public function update()
    {
		
		$id = $_POST['lid'];
		
        $data = ['emp_name' => $this->input->post('emp_name', TRUE),
			     'amount' => $this->input->post('Voucher_Amount', TRUE),
			     'note' => $this->input->post('voucher_date', TRUE),
			     'voucher_date' => $this->input->post('notes', TRUE)
				];

		
        $this->db->where('id', (int)$id)->update($this->table, $data);

		if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Voucher Updated Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}

        //for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Voucher Module','Update Voucher','UPDATE');
		//end of activity log
    }
	
	public function delete($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}

		$this->db->where('id', $id);
		$update = $this->db->update('voucher',['status' => 'delete']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Voucher Deleted Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Voucher Module','Delete Voucher','DELETE');
		//end of activity log
	}
	
	public function cancel($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}

		$this->db->where('id', $id);
		$update = $this->db->update('voucher',['status' => 'cancel']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Voucher Cancel Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Voucher Module','Cancel Voucher','UPDATE');
		//end of activity log
	}
	
	public function issue($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}

		$this->db->where('id', $id);
		$update = $this->db->update('voucher',['status' => 'Issued']);

		if ($id) {
			//echo json_encode(['stt' => 'ok','msg' => 'Voucher Issued Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Voucher Module','Voucher Issued','UPDATE');
		//end of activity log
	}
	
	
	public function approve($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}

		$this->db->where('id', $id);
		$update = $this->db->update('voucher',['status' => 'active']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Voucher Approved Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Voucher Module','Approve Voucher','Approve');
		//end of activity log
	}
	
	public function reject($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}

		$this->db->where('id', $id);
		$update = $this->db->update('voucher',['status' => 'reject']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Voucher Reject Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Voucher Module','Reject Voucher','Reject');
		//end of activity log
	}
	
	
	/**
     * Get counts by status
     */
	    public function get_counts() {
        $data = [];
		
        $data['all_count'] = $this->db->count_all($this->table);
		
        $this->db->where('status', 'cancel');
        $data['cancel_count'] = $this->db->count_all_results($this->table);
        
        $this->db->where('status', 'delete');
        $data['deleted_count'] = $this->db->count_all_results($this->table);
        
        return (object) $data;
    }
}	