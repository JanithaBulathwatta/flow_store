<?php
//madhushika(2026-03-11)
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_leave_types() {
        return $this->db->get('leave_types')->result();
    }

    public function get_employees() {
        // Adjust this based on your actual employee table structure
        // Using staff_info table from your provided schema
        $this->db->select('staff_id as id, full_name as name');
        $this->db->from('staff_info');
        $this->db->where('status', 'active');
        return $this->db->get()->result();
    }

    public function get_branches() {
        // Adjust based on your branch table
        $this->db->select('branch_id, branch_name');
        $this->db->from('branches');
        return $this->db->get()->result();
    }

    public function get_filtered_requests($filters = []) {
        $this->db->select('
            lr.*,
            e.full_name as employee_name,
            b.branch_name,
            lt.leave_type_name,
            au.full_name as approver_name,
            DATEDIFF(lr.end_date, lr.start_date) + 1 as calculated_days
        ');
        $this->db->from('leave_requests lr');
        $this->db->join('staff_info e', 'e.staff_id = lr.employee_id', 'left');
        $this->db->join('branches b', 'b.branch_id = lr.branch_id', 'left');
        $this->db->join('leave_types lt', 'lt.leave_type_id = lr.leave_type_id', 'left');
        $this->db->join('staff_info au', 'au.staff_id = lr.approved_by', 'left');

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $this->db->where('lr.start_date >=', $filters['start_date']);
            $this->db->where('lr.end_date <=', $filters['end_date']);
        }

        if (!empty($filters['employee_id'])) {
            $this->db->where('lr.employee_id', $filters['employee_id']);
        }
 // Add branch filter
    if (!empty($filters['branch_id'])) {
        $this->db->where('lr.branch_id', $filters['branch_id']);
    }
        if (!empty($filters['status'])) {
            $this->db->where('lr.status', $filters['status']);
        }

        if (!empty($filters['leave_type_id'])) {
            $this->db->where('lr.leave_type_id', $filters['leave_type_id']);
        }

        $this->db->order_by('lr.created_at', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_request_detail($id) {
        return $this->db->select('
            lr.*,
            e.full_name as employee_name,
            b.branch_name,
            lt.leave_type_name,
            au.full_name as approver_name
        ')
        ->from('leave_requests lr')
        ->join('staff_info e', 'e.staff_id = lr.employee_id', 'left')
        ->join('branches b', 'b.branch_id = lr.branch_id', 'left')
        ->join('leave_types lt', 'lt.leave_type_id = lr.leave_type_id', 'left')
        ->join('staff_info au', 'au.staff_id = lr.approved_by', 'left')
        ->where('lr.leave_request_id', $id)
        ->get()
        ->row();
    }

    public function save_request($data) {
        $this->db->insert('leave_requests', $data);
        return $this->db->insert_id();
    }

    public function update_request($id, $data) {
        $this->db->where('leave_request_id', $id);
        return $this->db->update('leave_requests', $data);
    }

    public function delete_request($id) {
        return $this->db->delete('leave_requests', ['leave_request_id' => $id]);
    }

    public function get_leave_counts_by_status() {
    // Your status values are: 'request', 'approved', 'rejected'
    $statuses = ['request', 'approved', 'rejected'];
    $result = [];
    
    $status_labels = [
        'request' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected'
    ];
    
    foreach ($statuses as $status) {
        $count = $this->db->where('status', $status)
                         ->count_all_results('leave_requests');
        
        $result[] = [
            'name' => $status_labels[$status],
            'status_code' => $status,
            'total' => $count
        ];
    }
    
    return $result;
}
}