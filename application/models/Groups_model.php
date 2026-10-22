<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Check if group exists (for validation)
    public function group_exists($group_name, $exclude_id = null) {
        $this->db->where('group_name', $group_name);
        $this->db->where('group_str', 'Active');
        
        // Exclude current group when checking for update
        if ($exclude_id) {
            $this->db->where('group_id !=', $exclude_id);
        }
        
        $query = $this->db->get('group');
        return $query->num_rows() > 0;
    }
    
    // Create new group
    public function create_group($group_name) {
        $data = array(
            'group_name' => $group_name,
            'group_str' => 'Active',
            'created_date' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('group', $data);
        return $this->db->insert_id();
    }
    
    // Get all active groups
    public function get_all_groups() {
        $this->db->where('group_str', 'Active');
        $this->db->order_by('created_date', 'DESC');
        $query = $this->db->get('group');
        return $query->result_array();
    }
    
    // Get single group by ID
    public function get_group_by_id($group_id) {
        $this->db->where('group_id', $group_id);
        $this->db->where('group_str', 'Active');
        $query = $this->db->get('group');
        return $query->row_array(); // Returns single group or null
    }
    
     
     // Delete group (soft delete)
     public function delete_group($group_id) {
         $this->db->where('group_id', $group_id);
         return $this->db->update('group', ['group_str' => 'Inactive']);
     }  

     // Add this method to update group
     public function update_group($group_id, $group_name) {
    $data = array(
        'group_name' => $group_name
        // Add 'updated_date' if you have this column
    );
    
    $this->db->where('group_id', $group_id);
    $this->db->where('group_str', 'Active');
    return $this->db->update('group', $data);
  }	 
  
  
  
  public function get_all_groups_with_counts() {
    // First, get all active groups
    $this->db->where('group_str', 'Active');
    $this->db->order_by('created_date', 'DESC');
    $groups = $this->db->get('group')->result_array();
    
    // Then get counts for each group
    foreach ($groups as &$group) {
        $this->db->where('fk_group_id', $group['group_id']);
        $this->db->where('contact_status', 'Active');
        $group['participant_count'] = $this->db->count_all_results('contact');
    }
    
    return $groups;
 }      
}

?>