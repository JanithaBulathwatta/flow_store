 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all campaigns
     * 
     * @param array $filters Optional filters
     * @return array Campaigns data
     */
    public function get_all_campaigns($filters = array()) {
        $this->db->select('*');
        $this->db->from('campaign');
        
         
        if (!empty($filters)) {
            if (isset($filters['status']) && $filters['status'] != 'all') {
                $this->db->where('campaign_status', $filters['status']);
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $this->db->like('campaign_title', $filters['search']);
            }
            
            if (isset($filters['start_date']) && !empty($filters['start_date'])) {
                $this->db->where('DATE(campaign_date) >=', $filters['start_date']);
            }
            
            if (isset($filters['end_date']) && !empty($filters['end_date'])) {
                $this->db->where('DATE(campaign_date) <=', $filters['end_date']);
            }
        }
        
         
        $this->db->order_by('campaign_date', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get campaign by ID
     * 
     * @param int $campaign_id
     * @return array Campaign data
     */
    public function get_campaign_by_id($campaign_id) {
        $this->db->where('campaign_id', $campaign_id);
        $query = $this->db->get('campaign');
        return $query->row_array();
    }

    /**
     * Create a new campaign
     * 
     * @param array $data Campaign data
     * @return int|bool New campaign ID or false
     */
    public function create_campaign($data) {
        $campaign_data = array(
            'campaign_title' => $data['campaign_title'],
            'campaign_date' => isset($data['campaign_date']) ? $data['campaign_date'] : date('Y-m-d H:i:s'),
            'total_sent' => isset($data['total_sent']) ? $data['total_sent'] : 0,
            'recipients' => isset($data['recipients']) ? $data['recipients'] : 'All Contacts',
            'campaign_status' => isset($data['campaign_status']) ? $data['campaign_status'] : 'Active'
        );
        
        $this->db->insert('campaign', $campaign_data);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        
        return false;
    }

    /**
     * Update campaign
     * 
     * @param int $campaign_id
     * @param array $data Campaign data
     * @return bool Success
     */
    public function update_campaign($campaign_id, $data) {
        $this->db->where('campaign_id', $campaign_id);
        
        $update_data = array();
        
        if (isset($data['campaign_title'])) {
            $update_data['campaign_title'] = $data['campaign_title'];
        }
        
        if (isset($data['campaign_date'])) {
            $update_data['campaign_date'] = $data['campaign_date'];
        }
        
        if (isset($data['total_sent'])) {
            $update_data['total_sent'] = $data['total_sent'];
        }
        
        if (isset($data['recipients'])) {
            $update_data['recipients'] = $data['recipients'];
        }
        
        if (isset($data['campaign_status'])) {
            $update_data['campaign_status'] = $data['campaign_status'];
        }
        
        if (!empty($update_data)) {
            $this->db->update('campaign', $update_data);
            return $this->db->affected_rows() > 0;
        }
        
        return false;
    }

    /**
     * Delete campaign
     * 
     * @param int $campaign_id
     * @return bool Success
     */
    public function delete_campaign($campaign_id) {
        $this->db->where('campaign_id', $campaign_id);
        $this->db->delete('campaign');
        return $this->db->affected_rows() > 0;
    }

    /**
     * Get campaign statistics
     * 
     * @return array Statistics
     */
    public function get_campaign_statistics() {
        $statistics = array();
        
         
        $this->db->select('COUNT(*) as total');
        $query = $this->db->get('campaign');
        $statistics['total_campaigns'] = $query->row()->total;
        
         
        $this->db->select('COUNT(*) as active');
        $this->db->where('campaign_status', 'Active');
        $query = $this->db->get('campaign');
        $statistics['active_campaigns'] = $query->row()->active;
        
         
        $this->db->select('COUNT(*) as completed');
        $this->db->where('campaign_status', 'Completed');
        $query = $this->db->get('campaign');
        $statistics['completed_campaigns'] = $query->row()->completed;
        
         
        $this->db->select_sum('total_sent', 'total_messages');
        $query = $this->db->get('campaign');
        $statistics['total_messages'] = $query->row()->total_messages ?: 0;
        
         
        $this->db->select('AVG(total_sent) as avg_sent');
        $query = $this->db->get('campaign');
        $statistics['avg_completion'] = $query->row()->avg_sent ? round($query->row()->avg_sent, 2) : 0;
        
        return $statistics;
    }

    /**
     * Check if campaign title exists
     * 
     * @param string $title Campaign title
     * @param int $exclude_id Campaign ID to exclude (for updates)
     * @return bool Exists
     */
    public function campaign_exists($title, $exclude_id = 0) {
        $this->db->where('campaign_title', $title);
        
        if ($exclude_id > 0) {
            $this->db->where('campaign_id !=', $exclude_id);
        }
        
        $query = $this->db->get('campaign');
        return $query->num_rows() > 0;
    }

    /**
     * Get campaigns by status
     * 
     * @param string $status Campaign status
     * @return array Campaigns
     */
    public function get_campaigns_by_status($status) {
        $this->db->where('campaign_status', $status);
        $this->db->order_by('campaign_date', 'DESC');
        $query = $this->db->get('campaign');
        return $query->result_array();
    }

    /**
     * Update campaign status
     * 
     * @param int $campaign_id
     * @param string $status New status
     * @return bool Success
     */
    public function update_campaign_status($campaign_id, $status) {
        $this->db->where('campaign_id', $campaign_id);
        $this->db->update('campaign', array('campaign_status' => $status));
        return $this->db->affected_rows() > 0;
    }

    /**
     * Get campaigns with pagination
     * 
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array Campaigns
     */
    public function get_campaigns_paginated($limit, $offset = 0, $filters = array()) {
        $this->db->select('*');
        $this->db->from('campaign');
        
         
        if (!empty($filters)) {
            if (isset($filters['status']) && $filters['status'] != 'all') {
                $this->db->where('campaign_status', $filters['status']);
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $this->db->like('campaign_title', $filters['search']);
            }
        }
        
        $this->db->order_by('campaign_date', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count total campaigns for pagination
     * 
     * @param array $filters
     * @return int Total count
     */
    public function count_campaigns($filters = array()) {
        $this->db->from('campaign');
        
        if (!empty($filters)) {
            if (isset($filters['status']) && $filters['status'] != 'all') {
                $this->db->where('campaign_status', $filters['status']);
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $this->db->like('campaign_title', $filters['search']);
            }
        }
        
        return $this->db->count_all_results();
    }
	
	 
public function get_campaign_message($campaign_id) {
     
    $this->db->where('fk_campaign_id', $campaign_id);
    $this->db->where('campaign_number', 'MSG_START');
    $query = $this->db->get('campaign_numbers');
    
    if ($query->num_rows() > 0) {
        $message_meta = $query->row_array();
        $chunks_info = $message_meta['send_status'];
        
        // Extract number of chunks (format: "CHUNKS:5")
        if (strpos($chunks_info, 'CHUNKS:') === 0) {
            $num_chunks = (int) substr($chunks_info, 7);
            
            if ($num_chunks > 0) {
                // Get all message chunks
                $this->db->select('send_status');
                $this->db->where('fk_campaign_id', $campaign_id);
                $this->db->like('campaign_number', 'MSG_CHUNK_', 'after');
                $this->db->order_by('campaign_number', 'ASC');
                $query = $this->db->get('campaign_numbers');
                $chunks = $query->result_array();
                
                // Reconstruct message
                $full_message = '';
                foreach ($chunks as $chunk) {
                    $full_message .= $chunk['send_status'];
                }
                
                return $full_message;
            }
        }
    }
    
    // Try old format
    $this->db->where('fk_campaign_id', $campaign_id);
    $this->db->where('campaign_number', 'MSG');
    $query = $this->db->get('campaign_numbers');
    
    if ($query->num_rows() > 0) {
        $message_row = $query->row_array();
        return $message_row['send_status'];
    }
    
     
    $this->db->select('recipients');
    $this->db->where('campaign_id', $campaign_id);
    $campaign_query = $this->db->get('campaign');
    $campaign = $campaign_query->row_array();
    
    if (isset($campaign['recipients']) && strpos($campaign['recipients'], 'MSG:') === 0) {
        return substr($campaign['recipients'], 4);
    }
    
    return 'No message stored for this campaign';
}
}