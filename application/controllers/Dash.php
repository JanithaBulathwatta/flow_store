<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {
    
    public function __construct() {
    parent::__construct();
    
    if (!$this->session->userdata('login')) {
        // Use CodeIgniter's redirect - handles base URL correctly
        $this->load->helper('url');
        redirect('Login');  // ← Goes to your Login controller
        exit;
    }
    
    $this->load->model('crm/Dashboard_model');
}
   public function index() {
    try {
        // Get activity feed for dashboard (9 items for 3 columns)
        $data['activity_feed'] = $this->Dashboard_model->get_activity_feed(9);
        
        // Get projects for dashboard
        $data['projects'] = $this->Dashboard_model->get_projects(5);
        $data['project_stats'] = $this->Dashboard_model->get_project_stats();
        
        // Get HRM data
        $data['hrm_data'] = $this->Dashboard_model->get_hrm_overview();
        $data['leave_requests'] = $this->Dashboard_model->get_leave_requests(5);
        
        // Get collection data for charts
        $data['monthly_collections'] = $this->Dashboard_model->get_monthly_collections(6);
        $data['collection_summary'] = $this->Dashboard_model->get_collection_summary();
        $data['receivables_aging'] = $this->Dashboard_model->get_receivables_aging();
        $data['outstanding'] = $this->Dashboard_model->get_outstanding_receivables();
        
        // Get receivables vs payables data
        $data['rp_trend'] = $this->Dashboard_model->get_receivables_payables_trend(6);
        $data['rp_summary'] = $this->Dashboard_model->get_receivables_payables_summary();
        
        // Get sales earnings and settled data
        $data['sales_earnings'] = $this->Dashboard_model->get_sales_earnings();
        $data['settled_vs_total'] = $this->Dashboard_model->get_settled_vs_total(15);
        $data['settled_summary'] = $this->Dashboard_model->get_settled_summary();
		
		// Get sales trend data
		$data['sales_trend'] = $this->Dashboard_model->get_sales_trend(7);
		
		// Get monthly progress data
        $data['monthly_progress'] = $this->Dashboard_model->get_monthly_progress(12);
		
		// Get top selling items
        $data['top_items'] = $this->Dashboard_model->get_top_items_chart_data(7);
        
        // Optional: Get top items by quantity
        $data['top_items_by_qty'] = $this->Dashboard_model->get_top_items_by_quantity(5);
        
		 // Get inventory data
        $data['stock_by_branch'] = $this->Dashboard_model->get_stock_by_branch();
        $data['stock_by_store'] = $this->Dashboard_model->get_stock_by_store();
        $data['inventory_summary'] = $this->Dashboard_model->get_inventory_summary();
        $data['top_stocked_products'] = $this->Dashboard_model->get_top_stocked_products(5);
        $data['inventory_alerts'] = $this->Dashboard_model->get_inventory_alerts(5);
        $data['stock_movement'] = $this->Dashboard_model->get_stock_movement_summary();
		
		 // Get financial data
        $data['financial_data'] = $this->Dashboard_model->get_financial_snapshot();
        $data['pl_trend'] = $this->Dashboard_model->get_pl_trend(6);
		
        $data['title'] = 'Dashboard';
        
        $this->load->view('header', $data);
        $this->load->view('dash', $data);
        $this->load->view('footer');
    } catch (Exception $e) {
        log_message('error', 'Dashboard index error: ' . $e->getMessage());
        show_error('Unable to load dashboard. Please check error logs.');
    }
}
    /**
     * Get activity feed for dashboard (AJAX endpoint)
     */
    public function get_activity_feed() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $limit = $this->input->get('limit') ?: 20;
        $activities = $this->Dashboard_model->get_activity_feed($limit);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'data' => $activities,
                'total' => count($activities)
            ]));
    }
    
    /**
     * For the dashboard - return formatted HTML for activity feed (AJAX endpoint)
     */
    public function get_activity_feed_html() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $limit = $this->input->get('limit') ?: 9;
        $activities = $this->Dashboard_model->get_activity_feed($limit);
        
        // Split into 3 columns for the dashboard
        $cols = [[], [], []];
        foreach ($activities as $index => $item) {
            $cols[$index % 3][] = $item;
        }
        
        $html = '';
        foreach ($cols as $col) {
            $html .= '<div>';
            foreach ($col as $item) {
                $html .= '
                <div class="act-item" data-activity-id="' . $item->activitylog_id . '">
                    <div class="act-time">' . $item->time . '</div>
                    <div class="act-icon" style="background:' . $item->iconBg . ';color:' . $item->iconColor . '">' . $item->icon . '</div>
                    <div>
                        <div style="font-size:11px">' . htmlspecialchars($item->text, ENT_QUOTES, 'UTF-8') . '</div>
                        <div class="act-sub">' . htmlspecialchars($item->sub, ENT_QUOTES, 'UTF-8') . '</div>
                    </div>
                </div>';
            }
            $html .= '</div>';
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'html' => $html,
                'activities' => $activities
            ]));
    }
    
    /**
     * Get single activity details (AJAX endpoint)
     */
    public function get_activity_detail($id) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $activity = $this->db->select('*')
            ->from('activity_log')
            ->where('activitylog_id', $id)
            ->get()
            ->row();
        
        if ($activity) {
            // Decode JSON fields if they exist
            if (!empty($activity->request_params)) {
                $activity->request_params = json_decode($activity->request_params, true);
            }
            if (!empty($activity->old_data)) {
                $activity->old_data = json_decode($activity->old_data, true);
            }
            if (!empty($activity->new_data)) {
                $activity->new_data = json_decode($activity->new_data, true);
            }
            if (!empty($activity->changed_fields)) {
                $activity->changed_fields = json_decode($activity->changed_fields, true);
            }
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'data' => $activity
                ]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Activity not found'
                ]));
        }
    }
    
    /**
     * Projects page with full list
     */
    public function projects() {
        $data['title'] = 'Projects';
        
        // Get filter parameters
        $filters = [
            'project_status' => $this->input->get('status'),
            'branch_id' => $this->input->get('branch'),
            'search' => $this->input->get('search')
        ];
        
        // Pagination
        $page = $this->input->get('page') ?: 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $data['projects'] = $this->Dashboard_model->get_projects($limit, $offset, $filters);
        $data['project_stats'] = $this->Dashboard_model->get_project_stats();
        $data['statuses'] = $this->Dashboard_model->get_project_statuses();
        
        $this->load->view('header', $data);
        $this->load->view('projects', $data);
        $this->load->view('footer');
    }
    
    /**
     * View single project details
     */
    public function project_view($id) {
        $data['title'] = 'Project Details';
        $data['project'] = $this->Dashboard_model->get_project($id);
        
        if (!$data['project']) {
            show_404();
        }
        
        $this->load->view('header', $data);
        $this->load->view('project_view', $data);
        $this->load->view('footer');
    }
    
    /**
     * Add note to project (AJAX)
     */
    public function add_project_note() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $this->output->set_content_type('application/json');
        
        $project_id = $this->input->post('project_id');
        $note_text = $this->input->post('note_text');
        
        if (!$project_id || !$note_text) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }
        
        // Get current user ID (adjust according to your auth system)
        $user_id = $this->session->userdata('user_id') ?: 1;
        
        $note_id = $this->Dashboard_model->add_project_note([
            'project_id' => $project_id,
            'note_text' => $note_text,
            'created_by' => $user_id
        ]);
        
        if ($note_id) {
            echo json_encode(['success' => true, 'note_id' => $note_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add note']);
        }
    }
    
    /**
     * Update project status (AJAX)
     */
    public function update_project_status() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $this->output->set_content_type('application/json');
        
        $project_id = $this->input->post('project_id');
        $status = $this->input->post('status');
        
        if (!$project_id || !$status) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }
        
        $updated = $this->Dashboard_model->update_project_status($project_id, $status);
        
        if ($updated) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }
    
    /**
     * Get project stats (AJAX)
     */
    public function get_project_stats() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'data' => $this->Dashboard_model->get_project_stats()
            ]));
    }
	/**
 * Get HRM data (AJAX)
 */
public function get_hrm_data() {
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'success' => true,
            'data' => $this->Dashboard_model->get_hrm_overview()
        ]));
}

/**
 * Get leave requests (AJAX)
 */
public function get_leave_requests() {
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    $status = $this->input->get('status');
    $limit = $this->input->get('limit') ?: 10;
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'success' => true,
            'data' => $this->Dashboard_model->get_leave_requests($limit, $status)
        ]));
}

/**
 * Approve leave request (AJAX)
 */
public function approve_leave() {
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    $this->output->set_content_type('application/json');
    
    $leave_id = $this->input->post('leave_id');
    $action = $this->input->post('action'); // approve or reject
    $comment = $this->input->post('comment');
    
    if (!$leave_id || !$action) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        return;
    }
    
    $status = $action == 'approve' ? 'approved' : 'rejected';
    $user_id = $this->session->userdata('user_id') ?: 1;
    
    $data = [
        'status' => $status,
        'approved_by' => $user_id,
        'approval_comment' => $comment,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $this->db->where('leave_request_id', $leave_id);
    $updated = $this->db->update('leave_requests', $data);
    
    if ($updated) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update leave request']);
    }
}
public function session_check() {
    // Only allow from your IP or during development
    // if ($_SERVER['REMOTE_ADDR'] != 'your_ip') show_404();

    echo "<h3>CodeIgniter Session Data</h3>";
    echo "<pre>";
    print_r($this->session->all_userdata());
    echo "</pre>";

    echo "<h3>PHP \$_SESSION Data</h3>";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    echo "<h3>Session Status</h3>";
    echo "session_status(): " . session_status() . "<br>";
    echo "session_id(): " . session_id() . "<br>";

    // Check if session file exists
    $save_path = $this->config->item('sess_save_path');
    if (empty($save_path)) {
        $save_path = ini_get('session.save_path');
    }
    echo "Session save path: " . $save_path . "<br>";
    $session_file = $save_path . '/sess_' . session_id();
    if (file_exists($session_file)) {
        echo "Session file exists: " . $session_file . "<br>";
        echo "File size: " . filesize($session_file) . " bytes<br>";
    } else {
        echo "Session file NOT found at: " . $session_file . "<br>";
    }
}
/**
 * Customer Receivables Aging Page
 */
public function receivables_aging() {
    $data['title'] = 'Receivables Aging';
    $data['aging_summary'] = $this->Dashboard_model->get_aging_summary();
    $data['aging_buckets'] = $this->Dashboard_model->get_customer_receivables_aging();
    $data['receivables_by_customer'] = $this->Dashboard_model->get_receivables_by_customer(20);
    $data['top_overdue'] = $this->Dashboard_model->get_top_overdue_customers(10);
    $data['aging_trend'] = $this->Dashboard_model->get_aging_trend(6);
    
    $this->load->view('header', $data);
    $this->load->view('receivables_aging', $data);
    $this->load->view('footer');
}
}