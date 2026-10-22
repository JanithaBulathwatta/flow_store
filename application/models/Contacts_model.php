 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // ============================================
    // NEW: GET DATA METHOD (Combines both queries)
    // ============================================
    public function get_data($group_id) {
        $data = [];
        
        // Query 1: GET SINGLE ROW (GROUP DETAILS)
        $data['group'] = $this->get_group_details($group_id);
        
        // Query 2: GET MULTIPLE ROWS (CONTACTS)
        $data['contacts'] = $this->get_contacts_by_group($group_id);
        
        // Get count
        $data['contact_count'] = $this->get_contact_count($group_id);
        
        return $data;
    }
    
    // ============================================
    // QUERY 1: GET SINGLE ROW (GROUP DETAILS)
    // ============================================
    public function get_group_details($group_id) {
        $this->db->select('group_id, group_name, created_date');
        $this->db->where('group_id', $group_id);
        $this->db->where('group_str', 'Active');
        $query = $this->db->get('group');
        
        // Return single row as array
        return $query->row_array();
    }
    
    // ============================================
    // QUERY 2: GET MULTIPLE ROWS (CONTACTS)
    // ============================================
    public function get_contacts_by_group($group_id, $filters = array()) {
        $this->db->select('contact_id, contact_name, contact_number,  source, created_date');
        $this->db->where('fk_group_id', $group_id);
        $this->db->where('contact_status', 'Active');
        
        // Apply search if provided
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('contact_name', $filters['search']);
            $this->db->or_like('contact_number', $filters['search']);
            $this->db->group_end();
        }
        
        // Order by
        $this->db->order_by('created_date', 'DESC');
        
        $query = $this->db->get('contact');
        
        // Return multiple rows as array
        return $query->result_array();
    }
    
    // ============================================
    // GET CONTACT COUNT
    // ============================================
    public function get_contact_count($group_id) {
        $this->db->where('fk_group_id', $group_id);
        $this->db->where('contact_status', 'Active');
        return $this->db->count_all_results('contact');
    }
    
    // ============================================
    // ADD CONTACT TO GROUP
    // ============================================
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
    
    // ============================================
    // CHECK IF CONTACT EXISTS IN GROUP
    // ============================================
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
	
	
	
	// ============================================
// GET SINGLE CONTACT BY ID
// ============================================
public function get_contact_by_id($contact_id, $group_id) {
    $this->db->select('contact_id, contact_name, contact_number, created_date, source');
    $this->db->where('contact_id', $contact_id);
    $this->db->where('fk_group_id', $group_id);
    $this->db->where('contact_status', 'Active');
    
    $query = $this->db->get('contact');
    
    if ($query->num_rows() > 0) {
        return $query->row_array();
    }
    
    return false;
}

// ============================================
// UPDATE CONTACT
// ============================================
public function update_contact($contact_id, $group_id, $contact_data) {
    $this->db->where('contact_id', $contact_id);
    $this->db->where('fk_group_id', $group_id);
    $this->db->where('contact_status', 'Active');
    
    return $this->db->update('contact', $contact_data);
}

 
	
}