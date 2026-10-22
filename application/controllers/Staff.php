<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller
{
	
    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('crm/Staff_model');
		$this->load->model('crm/BankAccount_model');
        $this->load->model('Branch_model');
    }   
	
	/**
		Display suppliers list
    **/
    public function index() 
    {
		$bank = $this->db->get_where('banks')->result();
		$designation = $this->db->get_where('sys_user_type')->result();
		
        $data = [
            'page_title' => 'Create Sub Category',
			'bank' => $bank,
			'designation'=>$designation,

        ];
        $this->load->view('header');   
        $this->load->view('crm/staff/staff',$data);
        $this->load->view('footer');   
    }
	
		/*	public function get_data()
		{
			// Clear any previous buffer/notices
			if (ob_get_length()) ob_clean();
	
			$data = $this->Staff_model->get_all();

			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'data' => $data
				]));
		}*/
		
	public function get_data()
	{
		if (ob_get_length()) ob_clean();

		$status = $this->input->post('status');

		$data = $this->Staff_model->get_all($status);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(['data'=>$data]));
	}
		
	public function store()
	{
		if(isset($_POST['lid']) && $_POST['lid'] != ''){
			$this->Staff_model->update();
		}else{
			$this->Staff_model->create();
		}
	}
	
	public function view()
    {
		
		$id = $_GET['lid'];
		
        $staff = $this->Staff_model->get_by_id((int)$id);

        if (!$staff) {
            show_404();
        }

        $data = ['page_title' => 'Staff Details','staff'=> $staff];
	
		echo json_encode($data);
		
	
	}
	
	public function create()
	{
		$bank = $this->db->where('status', 'active')->get('banks')->result();
		$designation = $this->db->get_where('sys_user_type')->result();
		$branch = $this->Branch_model->get_active_branches();
		
	
		$data = ['page_title' => 'Create Staff Member','bank' => $bank,'designation' => $designation,'branch' => $branch,];
		
		$this->load->view('header');
		$this->load->view('crm/staff/staff_view', $data);
		$this->load->view('footer');
	}
		
		
	public function delete()
	{
		
		$id = $_GET['lid'];
		
		$this->Staff_model->delete($id);
		
		
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		if (!$this->Staff_model->exists($id)) {
			echo json_encode(['success' => true,'message' => 'Lead Not available']);
		}

		
	}
	
	public function update_status()
	{
		// Clear any previous buffer/notices
		if (ob_get_length()) ob_clean();

		$id = $this->input->post('lid');
		$status = $this->input->post('status');

		if (!$id) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['stt' => 'error', 'msg' => 'ID is missing']));
		}

		$this->db->where('staff_id', $id);
		$update = $this->db->update('staff_info', ['status' => $status]);

		if ($update) {
			$response = ['stt' => 'ok', 'msg' => 'Status updated to ' . $status];
		} else {
			$response = ['stt' => 'error', 'msg' => 'Database update failed'];
		}

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}
	
	
		//get counts
	    public function get_counts() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $counts = $this->Staff_model->get_counts();
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($counts));
    }
	public function generateStaffNo()
{
    $year = date('Y');
    
    // Get the latest staff_no for this year
    $this->db->like('staff_no', 'STF-' . $year . '-', 'after');
    $this->db->order_by('staff_id', 'DESC');
    $this->db->limit(1);
    $last = $this->db->get('staff_info')->row();
    
    if ($last && $last->staff_no) {
        // Extract number and increment
        preg_match('/STF-\d{4}-(\d{4})/', $last->staff_no, $matches);
        $count = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
    } else {
        $count = 1;
    }
    
    $staff_no = 'STF-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    
    // Ensure uniqueness
    while($this->db->where('staff_no', $staff_no)->get('staff_info')->num_rows() > 0) {
        $count++;
        $staff_no = 'STF-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => 'success',
            'data' => ['staff_no' => $staff_no],
            'msg' => 'Staff number generated'
        ]));
}
/* -----------------------------------------------------------
   GET STAFF BY ID
----------------------------------------------------------- */
public function getStaffById($staff_id = null)
{
    if (!$staff_id) {
        $staff_id = $this->uri->segment(3);
    }
    
    if (!$staff_id) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'error', 'msg' => 'Staff ID required']));
        return;
    }
    
    $staff = $this->Staff_model->get_by_id($staff_id);
    
    if (!$staff) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'error', 'msg' => 'Staff not found']));
        return;
    }
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['status' => 'success', 'data' => $staff, 'msg' => 'Staff loaded']));
}
/**
 * Save staff record as draft
 */
public function save_draft()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    // Store with draft status
    $_POST['status'] = 'draft';
    
    // Call the same create method but with draft status
    $this->Staff_model->create();
}


	public function profile()
	{
		//$staff_id = $this->uri->segment(3);
		$staff_id = $_GET['s_id'];
		
		if (!$staff_id) {
			show_404();
		}
		
		$staff = $this->Staff_model->get_full_profile($staff_id);
		
		if (!$staff) {
			show_404();
		}
		
		$data = ['page_title' => 'Staff Profile - ' . $staff->full_name,'staff' => $staff];
		
		$this->load->view('header');
		$this->load->view('crm/staff/staff_profile', $data);
		$this->load->view('footer');
	}

public function edit()
{
    // Get staff_id from URL segment
    $staff_id = $this->uri->segment(3);
    
    if (!$staff_id) {
        show_404();
    }
    
    $staff = $this->Staff_model->get_full_profile($staff_id);
    
    if (!$staff) {
        show_404();
    }
    
    $bank = $this->db->where('status', 'active')->get('banks')->result();
    $designation = $this->db->get_where('sys_user_type')->result();
    
    $data = [
        'page_title' => 'Edit Staff - ' . $staff->full_name,
        'bank' => $bank,
        'designation' => $designation,
        'staff' => $staff,
        'edit_mode' => true
    ];
    
    $this->load->view('header');
    $this->load->view('crm/staff/staff_view', $data);
    $this->load->view('footer');
}
public function get_all_data()
{
    $data = $this->Staff_model->get_all_with_details();
    echo json_encode(['data' => $data]);
} 
}	
