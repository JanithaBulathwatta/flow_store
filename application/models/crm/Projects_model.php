<?php
//madhushika(2026-03-12)
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'traits/BranchTrait.php';

class Projects_model extends CI_Model {
    use BranchTrait;
    protected $table = 'projects';

    public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->load->model('accounting/Accounts_model');
    }

    /* CUSTOMER LIST */
    public function get_customers() {
		$this->filterByBranch();
        return $this->db
            ->select('cus_id, cus_name')
            ->from('customer')
            ->order_by('cus_name', 'ASC')
            ->get()
            ->result();
    }

    /* PROJECT COUNTS BY STATUS */
    public function get_project_counts() {
	$branch_id = $this->getCurrentBranchId();
		
    $total = $this->db->where('branch_id', $branch_id)
                      ->count_all_results('projects');
					  
    $active = $this->db->where('project_status', 'Active')
                       ->where('branch_id', $branch_id)
                       ->count_all_results('projects');

    $completed = $this->db->where('project_status', 'Completed')
                          ->where('branch_id', $branch_id)
                          ->count_all_results('projects');
						  
    $cancelled = $this->db->where('project_status', 'Cancelled')
                          ->where('branch_id', $branch_id)
                          ->count_all_results('projects');

        return [
            'total' => $total,
            'active' => $active,
            'completed' => $completed,
            'cancelled' => $cancelled
        ];
    }

    /* GET FILTERED PROJECTS */
    public function get_filtered($start, $end, $customer, $status) {
		
		$this->filterByBranch('p');
        $this->db->select('
            p.*,
            c.cus_name
        ');
        $this->db->from('projects p');
        $this->db->join('customer c', 'c.cus_id = p.fk_cus_id', 'left');

        if (!empty($start)) {
            $this->db->where('DATE(p.start_date) >=', $start);
        }

        if (!empty($end)) {
            $this->db->where('DATE(p.end_date) <=', $end);
        }

        if (!empty($customer)) {
            $this->db->where('p.fk_cus_id', $customer);
        }

        if (!empty($status)) {
            $this->db->where('p.project_status', $status);
        }

        return $this->db
            ->order_by('p.project_id', 'DESC')
            ->get()
            ->result();
    }

    /* GET SINGLE PROJECT */
    public function get_by_id($id) {
    $this->filterByBranch('p');
    $this->filterByBranch('p');
        return $this->db
            ->select('p.*, c.cus_name')
            ->from('projects p')
            ->join('customer c', 'c.cus_id = p.fk_cus_id', 'left')
            ->where('p.project_id', $id)
            ->get()
            ->row();
    }

    /* CREATE PROJECT */
    public function create($data) {
    // ADD BRANCH ID
    $data = $this->addBranch($data); 
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Project Module','Create Project','INSERT');
		//end of activity log
		
        $this->db->insert($this->table, $data);		
        return $this->db->insert_id();
    }

    /* UPDATE PROJECT */
    public function update($id, $data) {
    // Verify project belongs to current branch
    if (!$this->verifyBranch($this->table, $id, 'project_id')) {  // ADD THIS LINE
        error_log("Cannot update project from different branch: $id");
        return false;
    }
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Project Module','Update Project','UPDATE');
		//end of activity log
		
        $this->db->where('project_id', $id);		
        return $this->db->update($this->table, $data);
    }

	public function delete($id)
	{
		 // Verify project belongs to current branch
    if (!$this->verifyBranch($this->table, $id, 'project_id')) {  // ADD THIS LINE
        return false;
    }
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Project Module','Delete Project','DELETE');
		//end of activity log
		
		$this->db->where('project_id', $id);		
		return $this->db->delete('projects');
		

	}

	/* CHECK IF PROJECT EXISTS */
public function exists($id) {
    $this->filterByBranch();  // ADD THIS LINE
    
    return $this->db
        ->where('project_id', $id)
        ->count_all_results('projects') > 0;
}
}