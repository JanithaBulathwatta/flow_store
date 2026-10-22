 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function get_all_groups() {
        $this->db->where('group_str', 'Active');
        $this->db->order_by('group_name', 'ASC');
        $query = $this->db->get('group');
        return $query->result_array();
    }
    
     
    public function get_group_by_id($group_id) {
        $this->db->where('group_id', $group_id);
        $this->db->where('group_str', 'Active');
        $query = $this->db->get('group');
        return $query->row_array();
    }
    
     
    public function get_contacts_by_group($group_id) {
        $this->db->select('contact_id, contact_name, contact_number, source, created_date');
        $this->db->where('fk_group_id', $group_id);
        $this->db->where('contact_status', 'Active');
        $this->db->order_by('contact_name', 'ASC');
        $query = $this->db->get('contact');
        return $query->result_array();
    }
    
     
    public function get_contact_count($group_id) {
        $this->db->where('fk_group_id', $group_id);
        $this->db->where('contact_status', 'Active');
        return $this->db->count_all_results('contact');
    }
    
     
    public function contact_exists($group_id, $phone_number, $exclude_id = null) {
        $this->db->where('fk_group_id', $group_id);
        $this->db->where('contact_number', $phone_number);
        $this->db->where('contact_status', 'Active');
        
        if ($exclude_id) {
            $this->db->where('contact_id !=', $exclude_id);
        }
        
        $query = $this->db->get('contact');
        return $query->num_rows() > 0;
    }
    
     
    public function get_contact_by_id($contact_id, $group_id = null) {
		$this->db->select('contact_id, contact_name, contact_number, source, ...'); 
        $this->db->where('contact_id', $contact_id);
        $this->db->where('contact_status', 'Active');
        
        if ($group_id) {
            $this->db->where('fk_group_id', $group_id);
        }
        
        $query = $this->db->get('contact');
        return $query->row_array();
    }
    
     
    public function add_contact($group_id, $contact_data) {
        $data = array(
            'fk_group_id' => $group_id,
            'contact_name' => $contact_data['name'],
            'contact_number' => $contact_data['phone_number'],
			'source' => isset($contact_data['source']) ? $contact_data['source'] : 'manual',
            'contact_status' => 'Active',
            'created_date' => date('Y-m-d H:i:s')
        );
        
        return $this->db->insert('contact', $data);
    }
    
     
    public function get_group_data($group_id) {
        $data = array();
        
         
        $data['group'] = $this->get_group_by_id($group_id);
        
         
        $data['contacts'] = $this->get_contacts_by_group($group_id);
        
         
        $data['contact_count'] = $this->get_contact_count($group_id);
        
        return $data;
    }
}