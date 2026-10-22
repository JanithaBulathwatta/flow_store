<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 20/3/2026

class StockAdjustHistory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        $this->load->model('crm/StockAdjustHistory_model', 'adjustment_model');
   
        // ========== ADD PERMISSION CODE HERE ==========
        // Auth check
        if (!$this->session->userdata('user_id')) {
            redirect('login');
            exit;
        }
        
        // Get user permissions
        $this->load->model('crm/User_model');
        $this->user_id = $this->session->userdata('user_id');
        $this->ut_id = $this->session->userdata('ut_id');
        $this->is_owner = $this->session->userdata('owner');
        
        // Set permissions
        $this->can_approve = ($this->ut_id == 1|| $this->ut_id == 2 || $this->is_owner == 1);
        $this->can_view = true; // All logged-in users can view history
        
        // Store in session if not set
        if (!$this->ut_id) {
            $user = $this->db->select('ut_id, owner')
                             ->where('user_id', $this->user_id)
                             ->get('user')
                             ->row();
            if ($user) {
                $this->ut_id = $user->ut_id ?? 0;
                $this->is_owner = $user->owner ?? 0;
                $this->session->set_userdata('ut_id', $this->ut_id);
                $this->session->set_userdata('owner', $this->is_owner);
                $this->can_approve = ($this->ut_id == 1 || $this->ut_id == 2 || $this->is_owner == 1);
            }
        }
        // ========== END OF PERMISSION CODE ==========

   }
    
    public function index()
    {
        $data['warehouses'] = $this->adjustment_model->get_warehouses();
        $data['users'] = $this->adjustment_model->get_users();
        $data['adjustment_types'] = [
            'CORRECTION' => 'Correction',
            'DAMAGE' => 'Damage',
            'LOSS' => 'Loss',
            'EXPIRED' => 'Expired',
            'STOCK_COUNT' => 'Stock Count'
        ];
        $data['statuses'] = [
            'Draft' => 'Draft',
            'Submitted' => 'Submitted',
            'Approved' => 'Approved',
            'Rejected' => 'Rejected',
            'Cancelled' => 'Cancelled'
        ];
		
		// ========== ADD PERMISSIONS TO VIEW ==========
        $data['can_approve'] = $this->can_approve;
        $data['can_view'] = $this->can_view;
        $data['ut_id'] = $this->ut_id;
        $data['is_owner'] = $this->is_owner;
        // ========== END OF ADDED CODE ==========
        
        $this->load->view('header', $data);
        $this->load->view('crm/stock/stockAdjustHistory', $data);
        $this->load->view('footer');
    }
    
    public function get_adjustments()
    {
        $this->output->set_content_type('application/json');
        
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $page_size = $this->input->get('page_size') ? (int)$this->input->get('page_size') : 20;
        $sort_by = $this->input->get('sort_by') ? $this->input->get('sort_by') : 'date';
        $sort_dir = $this->input->get('sort_dir') ? $this->input->get('sort_dir') : 'desc';
        
        $filters = [
            'date_from' => $this->input->get('date_from'),
            'date_to' => $this->input->get('date_to'),
            'warehouse_id' => $this->input->get('warehouse_id'),
            'adjustment_type' => $this->input->get('adjustment_type'),
            'status' => $this->input->get('status'),
            'created_by' => $this->input->get('created_by'),
            'search' => $this->input->get('search')
        ];
        
        $filters = array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        });
        
        $offset = ($page - 1) * $page_size;
        
        $adjustments = $this->adjustment_model->get_adjustments(
            $filters, 
            $page_size, 
            $offset, 
            $sort_by, 
            $sort_dir
        );
        
        $total_count = $this->adjustment_model->get_adjustments_count($filters);
        
        $formatted_adjustments = [];
        foreach ($adjustments as $adj) {
            $formatted_adjustments[] = [
                'id' => $adj['id'],
                'adjNo' => $adj['adjustment_no'],
                'date' => date('Y-m-d', strtotime($adj['adjustment_date'])),
                'warehouse' => $adj['warehouse_name'] ?? 'Warehouse ' . $adj['warehouse_id'],
                'type' => $this->_format_type($adj['adjustment_type']),
                'status' => strtolower($adj['status'] ?? 'submitted'),
                'createdBy' => $this->_get_user_name($adj['created_by']),
                'approvedBy' => isset($adj['approved_by']) ? $this->_get_user_name($adj['approved_by']) : '',
                'remarks' => $adj['remarks'] ?? '',
                'items_count' => (int)($adj['items_count'] ?? 0),
                'netQty' => (float)($adj['net_qty'] ?? 0),
                'valueImpact' => (float)($adj['value_impact'] ?? 0)
            ];
        }
        
        $response = [
            'success' => true,
            'data' => $formatted_adjustments,
            'total' => $total_count,
            'page' => $page,
            'page_size' => $page_size,
            'total_pages' => ceil($total_count / $page_size),
			// ========== ADD PERMISSIONS TO API RESPONSE ==========
            'permissions' => [
                'can_approve' => $this->can_approve,
                'can_view' => $this->can_view
            ]
            // ========== END OF ADDED CODE ==========
        ];
        
        $this->output->set_output(json_encode($response));
    }
    
    public function get_adjustment_detail()
    {
        $this->output->set_content_type('application/json');
        
        $id = $this->input->get('id');
        if (!$id) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Adjustment ID is required'
            ]));
            return;
        }
        
        $detail = $this->adjustment_model->get_adjustment_detail($id);
        
        if (!$detail) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Adjustment not found'
            ]));
            return;
        }
        
        $this->output->set_output(json_encode([
            'success' => true,
            'data' => $detail
        ]));
    }
    
    public function approve()
    {
        $this->output->set_content_type('application/json');
		
		// ========== ADD PERMISSION CHECK ==========
        if (!$this->can_approve) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'You do not have permission to approve stock adjustments'
            ]));
            return;
        }
        // ========== END OF PERMISSION CHECK ==========
        
        $id = $this->input->post('id');
        if (!$id) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Adjustment ID is required'
            ]));
            return;
        }
        
        $user_id = $this->session->userdata('user_id') ?: 1;
        
        $result = $this->adjustment_model->update_status($id, 'Approved', '', $user_id);
        
        if ($result) {
            $this->output->set_output(json_encode([
                'success' => true,
                'message' => 'Adjustment approved successfully'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to approve adjustment'
            ]));
        }
    }
    
    public function reject()
    {
        $this->output->set_content_type('application/json');
		
		// ========== ADD PERMISSION CHECK ==========
        if (!$this->can_approve) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'You do not have permission to reject stock adjustments'
            ]));
            return;
        }
        // ========== END OF PERMISSION CHECK ==========
        
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');
        
        if (!$id) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Adjustment ID is required'
            ]));
            return;
        }
        
        if (!$reason) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Rejection reason is required'
            ]));
            return;
        }
        
        $user_id = $this->session->userdata('user_id') ?: 1;
        
        $result = $this->adjustment_model->update_status($id, 'Rejected', $reason, $user_id);
        
        if ($result) {
            $this->output->set_output(json_encode([
                'success' => true,
                'message' => 'Adjustment rejected'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to reject adjustment'
            ]));
        }
    }
	
	
    
    public function cancel()
    {
        $this->output->set_content_type('application/json');
        
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');
        
        if (!$id) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Adjustment ID is required'
            ]));
            return;
        }
        
        $user_id = $this->session->userdata('user_id') ?: 1;
        
        $result = $this->adjustment_model->update_status($id, 'Cancelled', $reason, $user_id);
        
        if ($result) {
            $this->output->set_output(json_encode([
                'success' => true,
                'message' => 'Adjustment cancelled'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Failed to cancel adjustment'
            ]));
        }
    }
    
    public function bulk_approve()
    {
        $this->output->set_content_type('application/json');
		
		// ========== ADD PERMISSION CHECK ==========
        if (!$this->can_approve) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'You do not have permission to approve stock adjustments'
            ]));
            return;
        }
        // ========== END OF PERMISSION CHECK ==========
        
        $ids = $this->input->post('ids');
        if (!$ids || !is_array($ids)) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'No adjustments selected'
            ]));
            return;
        }
        
        $user_id = $this->session->userdata('user_id') ?: 1;
        $approved_count = 0;
        
        foreach ($ids as $id) {
            $result = $this->adjustment_model->update_status($id, 'Approved', '', $user_id);
            if ($result) $approved_count++;
        }
        
        $this->output->set_output(json_encode([
            'success' => true,
            'message' => $approved_count . ' adjustment(s) approved successfully',
            'approved_count' => $approved_count
        ]));
    }
    
    private function _format_type($type)
    {
        $types = [
            'CORRECTION' => 'Correction',
            'DAMAGE' => 'Damage',
            'LOSS' => 'Loss',
            'EXPIRED' => 'Expired',
            'STOCK_COUNT' => 'Stock Count'
        ];
        
        return $types[$type] ?? $type;
    }
    
    private function _get_user_name($user_id)
    {
        static $user_cache = [];
        
        if (empty($user_id)) return 'System';
        
        if (!isset($user_cache[$user_id])) {
            if ($this->db->table_exists('user')) {
                $this->db->select('full_name');
                $this->db->where('user_id', $user_id);
                $query = $this->db->get('user');
                $result = $query->row_array();
                $user_cache[$user_id] = $result ? $result['full_name'] : 'User ' . $user_id;
            } else {
                $user_cache[$user_id] = 'User ' . $user_id;
            }
        }
        
        return $user_cache[$user_id];
    }
}