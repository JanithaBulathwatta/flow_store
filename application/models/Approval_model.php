<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_model extends CI_Model {
//----------------------------------------------------------------------------------------

    /*public function get_data(){
		$this->db->join('user','user.user_id = approval_requests.requested_by','left');
		$res = $this->db->get('approval_requests')->result();
		return $res;
	}*/
	
	public function get_data() {
		
		
	
		$this->db->select('
			approval_requests.id,
			approval_requests.document_type as dt,
			approval_requests.reference_no as ref,
			user.full_name as by,
			approval_requests.created_at as date,
			approval_requests.status,
			approval_requests.priority as pri,
			approval_requests.amount as amt,
			DATEDIFF(NOW(), approval_requests.created_at) as age
		');
		$this->db->from('approval_requests');
		$this->db->join('user', 'user.user_id = approval_requests.requested_by', 'left');
		//$query = $this->db->get();
		//return $query->result();
		
		// Apply Filter: Search (Ref No or Requester Name)
		if (!empty($filters['search'])) {
			$this->db->group_start();
			$this->db->like('approval_requests.reference_no', $filters['search']);
			$this->db->or_like('user.full_name', $filters['search']);
			$this->db->group_end();
		}

		// Apply Filter: Status
		if (!empty($filters['status'])) {
			$this->db->where('approval_requests.status', $filters['status']);
		}

		// Apply Filter: Type
		if (!empty($filters['type'])) {
			$this->db->where('approval_requests.document_type', $filters['type']);
		}

		// Apply Filter: Priority
		if (!empty($filters['priority'])) {
			$this->db->where('approval_requests.priority', $filters['priority']);
		}

		$this->db->order_by('approval_requests.created_at', 'DESC');
		$query = $this->db->get();
		return $query->result();
		
	}
	
	
	public function approve_request(){
		$id = $_POST['appid'];
		$action_by = $this->session->userdata('uid');
		
		
		$data = ['remarks'    => $this->input->post('appremark', TRUE),
				 'status'   => 'approved'];
		
        $this->db->where('id', (int)$id)->update('approval_requests', $data);
		
		$data3 = ['remarks'    => $this->input->post('appremark', TRUE),
				  'approval_id'    => $id,
				  'action_by'    => $action_by,
				  'status'   => 'approved'];
		
		$this->db->insert('approval_steps',$data3);
		$id2 = $this->db->insert_id();
		
		
		$data2 = ['remarks'    => $this->input->post('appremark', TRUE),
				  'approval_id'    => $id,
				  'step_id'    => $id2,
				  'action_by'    => $action_by,
				  'action'   => 'approved'];
		
		$this->db->insert('approval_actions',$data2);
		
		

		if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Approved Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Approval  Module','Approved','UPDATE');
	}
	
	
	public function reject_request(){
		$id = $_POST['appid'];
		
		$action_by = $this->session->userdata('uid');
		
		
		$data = ['remarks'    => $this->input->post('appremark', TRUE),
				 'status'   => 'rejected'];
		
        $this->db->where('id', (int)$id)->update('approval_requests', $data);
		
		$data3 = ['remarks'    => $this->input->post('appremark', TRUE),
				  'approval_id'    => $id,
				  'action_by'    => $action_by,
				  'status'   => 'rejected'];
		
		$this->db->insert('approval_steps',$data3);
		$id2 = $this->db->insert_id();
		
		
		$data2 = ['remarks'    => $this->input->post('appremark', TRUE),
				  'approval_id'    => $id,
				  'step_id'    => $id2,
				  'action_by'    => $action_by,
				  'action'   => 'rejected'];
		
		$this->db->insert('approval_actions',$data2);

		if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Approval Rejected Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Approval  Module','Reject','UPDATE');
	}
	
	public function hold_request(){
		
		$id = $_POST['appid'];
		
		$action_by = $this->session->userdata('uid');
		
		
		$data = ['remarks'    => $this->input->post('appremark', TRUE),
				 'status'   => 'on_hold'];
		
        $this->db->where('id', (int)$id)->update('approval_requests', $data);
		
		$data3 = ['remarks'    => $this->input->post('appremark', TRUE),
				  'approval_id'    => $id,
				  'action_by'    => $action_by,
				  'status'   => 'on_hold'];
		
		$this->db->insert('approval_steps',$data3);
		$id2 = $this->db->insert_id();
		
		
		$data2 = ['remarks'    => $this->input->post('appremark', TRUE),
				  'approval_id'    => $id,
				  'step_id'    => $id2,
				  'action_by'    => $action_by,
				  'action'   => 'on_hold'];
		
		$this->db->insert('approval_actions',$data2);

		if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Request Hold Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Approval  Module','Hold','UPDATE');
	}
	
	public function relese_request(){
		
		$id = $_GET['apid'];
		
		$action_by = $this->session->userdata('uid');
		
		
		$data = ['remarks'    => $this->input->post('appremark', TRUE),
				 'status'   => 'pending'];
		
        $this->db->where('id', (int)$id)->update('approval_requests', $data);
		
		$data3 = ['remarks'    => $this->input->post('appremark', TRUE),
				  'approval_id'    => $id,
				  'action_by'    => $action_by,
				  'status'   => 'pending'];
		
		$this->db->insert('approval_steps',$data3);
		$id2 = $this->db->insert_id();
		
		
		$data2 = ['remarks'    => $this->input->post('appremark', TRUE),
				  'approval_id'    => $id,
				  'step_id'    => $id2,
				  'action_by'    => $action_by,
				  'action'   => 'pending'];
		
		$this->db->insert('approval_actions',$data2);

		if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Request Hold Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Approval  Module','Relesed','UPDATE');
	}
//----------------------------------------------------------------------------------------	
	
}
?>