<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ========== ACTIVITY FEED FROM ACTIVITY_LOG TABLE ==========
    public function get_activity_feed($limit = 20) {
        $activities = $this->db->select('
                activitylog_id,
                created_at as time,
                username,
                user_role,
                module,
                action,
                action_type,
                description,
                entity_type,
                entity_id,
                ip_address,
                request_method
            ')
            ->from('activity_log')
            ->order_by('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
        
        // Format the activities for display
        $formatted_activities = [];
        foreach ($activities as $act) {
            $formatted_activities[] = (object)[
                'activitylog_id' => $act->activitylog_id,
                'time' => date('H:i', strtotime($act->time)),
                'icon' => $this->get_icon($act->module, $act->action),
                'iconBg' => $this->get_icon_bg($act->module, $act->action),
                'iconColor' => $this->get_icon_color($act->module, $act->action),
                'text' => $this->get_action_text($act->module, $act->action, $act->entity_type),
                'sub' => $act->description ?: $act->username . ' performed ' . $act->action . ($act->entity_type ? ' on ' . $act->entity_type . ' #' . $act->entity_id : ''),
                'full_time' => $act->time,
                'username' => $act->username,
                'module' => $act->module,
                'action_type' => $act->action_type
            ];
        }
        
        return $formatted_activities;
    }

    // Helper functions for icons
    private function get_icon($module, $action) {
        $module = strtolower($module);
        $action = strtolower($action);
        
        $icons = [
            'sales' => ['create' => '$', 'edit' => 'E', 'delete' => 'D', 'default' => 'I'],
            'invoice' => ['create' => '$', 'edit' => 'E', 'delete' => 'D', 'default' => 'I'],
            'payment' => ['default' => 'P'],
            'stock' => ['default' => 'S'],
            'inventory' => ['default' => 'S'],
            'purchase' => ['default' => 'O'],
            'po' => ['default' => 'O'],
            'employee' => ['default' => 'A'],
            'attendance' => ['default' => 'A'],
            'customer' => ['default' => 'C'],
            'project' => ['create' => 'P', 'edit' => 'E', 'delete' => 'D', 'default' => 'P']
        ];
        
        foreach ($icons as $key => $icon_map) {
            if (strpos($module, $key) !== false) {
                if (strpos($action, 'create') !== false && isset($icon_map['create'])) return $icon_map['create'];
                if (strpos($action, 'edit') !== false && isset($icon_map['edit'])) return $icon_map['edit'];
                if (strpos($action, 'delete') !== false && isset($icon_map['delete'])) return $icon_map['delete'];
                return $icon_map['default'];
            }
        }
        
        if (strpos($action, 'login') !== false) return 'L';
        if (strpos($action, 'logout') !== false) return 'O';
        return '•';
    }

    private function get_icon_bg($module, $action) {
        $module = strtolower($module);
        
        $colors = [
            'sales' => '#EAF3DE',
            'invoice' => '#EAF3DE',
            'payment' => '#E6F1FB',
            'stock' => '#E1F5EE',
            'inventory' => '#E1F5EE',
            'purchase' => '#E6F1FB',
            'po' => '#E6F1FB',
            'employee' => '#E1F5EE',
            'attendance' => '#E1F5EE',
            'customer' => '#EAF3DE',
            'project' => '#EEEDFE'
        ];
        
        foreach ($colors as $key => $color) {
            if (strpos($module, $key) !== false) return $color;
        }
        
        if (strpos($action, 'login') !== false) return '#EEEDFE';
        return '#F0EFE9';
    }

    private function get_icon_color($module, $action) {
        $module = strtolower($module);
        
        $colors = [
            'sales' => '#3B6D11',
            'invoice' => '#3B6D11',
            'payment' => '#185FA5',
            'stock' => '#0F6E56',
            'inventory' => '#0F6E56',
            'purchase' => '#185FA5',
            'po' => '#185FA5',
            'employee' => '#0F6E56',
            'attendance' => '#0F6E56',
            'customer' => '#3B6D11',
            'project' => '#534AB7'
        ];
        
        foreach ($colors as $key => $color) {
            if (strpos($module, $key) !== false) return $color;
        }
        
        if (strpos($action, 'login') !== false) return '#534AB7';
        return '#7A786F';
    }

    private function get_action_text($module, $action, $entity_type) {
        $action_clean = ucfirst(str_replace('_', ' ', $action));
        return $entity_type ? $action_clean . ' ' . ucfirst($entity_type) : $action_clean . ' in ' . ucfirst($module);
    }

    // ========== PROJECT TRACKER ==========
    
    /**
     * Get all projects with optional filters
     */
    public function get_projects($limit = 10, $offset = 0, $filters = []) {
        $this->db->select('
                p.project_id,
                p.branch_id,
                p.project_name,
                p.estimated_budget,
                p.start_date,
                p.end_date,
                p.fk_cus_id,
                p.attachment,
                p.project_status,
                p.created_at,
                c.cus_name as client_name,
                b.branch_name as branch_name,
                (SELECT COUNT(*) FROM project_notes WHERE project_id = p.project_id) as note_count
            ')
            ->from('projects p')
            ->join('customer c', 'c.cus_id = p.fk_cus_id', 'left')
            ->join('branches b', 'b.branch_id = p.branch_id', 'left')
            ->order_by('p.created_at', 'DESC')
            ->limit($limit, $offset);
        
        // Apply filters
        if (!empty($filters['project_status'])) {
            $this->db->where('p.project_status', $filters['project_status']);
        }
        if (!empty($filters['branch_id'])) {
            $this->db->where('p.branch_id', $filters['branch_id']);
        }
        if (!empty($filters['client_id'])) {
            $this->db->where('p.fk_cus_id', $filters['client_id']);
        }
        if (!empty($filters['search'])) {
            $this->db->like('p.project_name', $filters['search']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('p.start_date >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('p.end_date <=', $filters['date_to']);
        }
        
        return $this->db->get()->result();
    }

    /**
     * Get single project with details
     */
    public function get_project($project_id) {
        $project = $this->db->select('
                p.*,
                c.cus_name as client_name,
                c.phone as client_phone,
                c.email as client_email,
                b.branch_name as branch_name
            ')
            ->from('projects p')
            ->join('customer c', 'c.cus_id = p.fk_cus_id', 'left')
            ->join('branches b', 'b.branch_id = p.branch_id', 'left')
            ->where('p.project_id', $project_id)
            ->get()
            ->row();
        
        if ($project) {
            // Get project notes
            $project->notes = $this->get_project_notes($project_id);
            
            // Get project progress (based on notes count or other metrics)
            $project->progress = $this->calculate_project_progress($project_id);
            
            // Get status badge color
            $project->badge_color = $this->get_project_status_badge($project->project_status);
        }
        
        return $project;
    }

    /**
     * Get project notes
     */
    public function get_project_notes($project_id, $limit = 5) {
        return $this->db->select('
                n.*,
                u.name as created_by_name,
                u.email as created_by_email
            ')
            ->from('project_notes n')
            ->join('users u', 'u.id = n.created_by', 'left')
            ->where('n.project_id', $project_id)
            ->order_by('n.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Add note to project
     */
    public function add_project_note($data) {
        $note_data = [
            'project_id' => $data['project_id'],
            'note_text' => $data['note_text'],
            'created_by' => $data['created_by'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('project_notes', $note_data);
        return $this->db->insert_id();
    }

    /**
     * Update project status
     */
    public function update_project_status($project_id, $status) {
        $data = [
            'project_status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('project_id', $project_id);
        return $this->db->update('projects', $data);
    }

    /**
     * Calculate project progress
     * Uses days elapsed vs total days, or notes count, or custom logic
     */
    public function calculate_project_progress($project_id) {
        $project = $this->db->select('start_date, end_date, project_status')
            ->from('projects')
            ->where('project_id', $project_id)
            ->get()
            ->row();
        
        if (!$project) return 0;
        
        // If project is completed, return 100
        if ($project->project_status == 'Completed') return 100;
        
        // Calculate based on dates
        if ($project->start_date && $project->end_date) {
            $start = strtotime($project->start_date);
            $end = strtotime($project->end_date);
            $now = time();
            
            $total_days = ($end - $start) / (60 * 60 * 24);
            $elapsed_days = ($now - $start) / (60 * 60 * 24);
            
            if ($total_days <= 0) return 0;
            
            $progress = ($elapsed_days / $total_days) * 100;
            return min(round($progress), 99); // Cap at 99 if not marked completed
        }
        
        // If no dates, use note count as progress indicator (max 10 notes = 100%)
        $note_count = $this->db->from('project_notes')
            ->where('project_id', $project_id)
            ->count_all_results();
        
        return min(round($note_count * 10), 99);
    }

    /**
     * Get status badge color
     */
    public function get_project_status_badge($status) {
        $badges = [
            'Planning' => 'bb',
            'In Progress' => 'ba',
            'On Track' => 'bg',
            'At Risk' => 'br',
            'Near Complete' => 'bt',
            'Completed' => 'bg',
            'On Hold' => 'ba',
            'Cancelled' => 'br'
        ];
        
        return $badges[$status] ?? 'bb';
    }

    /**
     * Get project status with color mapping
     */
    public function get_project_statuses() {
        return [
            'Planning' => ['label' => 'Planning', 'color' => '#185FA5', 'badge' => 'bb'],
            'In Progress' => ['label' => 'In Progress', 'color' => '#EF9F27', 'badge' => 'ba'],
            'On Track' => ['label' => 'On Track', 'color' => '#3B6D11', 'badge' => 'bg'],
            'At Risk' => ['label' => 'At Risk', 'color' => '#A32D2D', 'badge' => 'br'],
            'Near Complete' => ['label' => 'Near Complete', 'color' => '#0F6E56', 'badge' => 'bt'],
            'Completed' => ['label' => 'Completed', 'color' => '#3B6D11', 'badge' => 'bg'],
            'On Hold' => ['label' => 'On Hold', 'color' => '#EF9F27', 'badge' => 'ba'],
            'Cancelled' => ['label' => 'Cancelled', 'color' => '#A32D2D', 'badge' => 'br']
        ];
    }

    /**
     * Get project statistics
     */
    public function get_project_stats() {
        $total = $this->db->count_all('projects');
        
        $stats = [
            'total' => $total,
            'planning' => $this->db->from('projects')->where('project_status', 'Planning')->count_all_results(),
            'in_progress' => $this->db->from('projects')->where('project_status', 'In Progress')->count_all_results(),
            'on_track' => $this->db->from('projects')->where('project_status', 'On Track')->count_all_results(),
            'at_risk' => $this->db->from('projects')->where('project_status', 'At Risk')->count_all_results(),
            'completed' => $this->db->from('projects')->where('project_status', 'Completed')->count_all_results(),
            'on_hold' => $this->db->from('projects')->where('project_status', 'On Hold')->count_all_results(),
        ];
        
        // Calculate total budget and spent
        $budget = $this->db->select('SUM(estimated_budget) as total')
            ->from('projects')
            ->get()
            ->row();
        
        $stats['total_budget'] = (float)($budget->total ?? 0);
        
        return $stats;
    }

    // ========== PAGINATED VERSIONS ==========
    
    public function get_activity_feed_paginated($limit = 20, $offset = 0, $filters = []) {
        $this->db->select('
                activitylog_id,
                created_at as time,
                username,
                user_role,
                module,
                action,
                action_type,
                description,
                entity_type,
                entity_id,
                ip_address,
                request_method,
                status,
                response_code
            ')
            ->from('activity_log')
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset);
        
        // Apply filters
        if (!empty($filters['module'])) $this->db->where('module', $filters['module']);
        if (!empty($filters['user_id'])) $this->db->where('user_id_fk', $filters['user_id']);
        if (!empty($filters['action_type'])) $this->db->where('action_type', $filters['action_type']);
        if (!empty($filters['date_from'])) $this->db->where('DATE(created_at) >=', $filters['date_from']);
        if (!empty($filters['date_to'])) $this->db->where('DATE(created_at) <=', $filters['date_to']);
        
        return $this->db->get()->result();
    }

    public function get_activity_count($filters = []) {
        $this->db->from('activity_log');
        
        if (!empty($filters['module'])) $this->db->where('module', $filters['module']);
        if (!empty($filters['user_id'])) $this->db->where('user_id_fk', $filters['user_id']);
        if (!empty($filters['action_type'])) $this->db->where('action_type', $filters['action_type']);
        if (!empty($filters['date_from'])) $this->db->where('DATE(created_at) >=', $filters['date_from']);
        if (!empty($filters['date_to'])) $this->db->where('DATE(created_at) <=', $filters['date_to']);
        
        return $this->db->count_all_results();
    }
	// Add this to Dashboard_model.php
public function format_currency($amount) {
    if ($amount >= 1000000) {
        return number_format($amount / 1000000, 2) . 'M';
    } elseif ($amount >= 1000) {
        return number_format($amount / 1000, 0) . 'K';
    }
    return number_format($amount, 0);
}
// ========== HRM (HUMAN RESOURCE MANAGEMENT) ==========

/**
 * Get HRM overview statistics
 */
public function get_hrm_overview() {
    // Total staff
    $total_staff = $this->db->count_all('staff_info');
    
    // Staff by status
    $active_staff = $this->db->from('staff_info')->where('status', 'Active')->count_all_results();
    $inactive_staff = $this->db->from('staff_info')->where('status', 'Inactive')->count_all_results();
    
    // Staff by gender
    $male_staff = $this->db->from('staff_info')->where('gender', 'Male')->count_all_results();
    $female_staff = $this->db->from('staff_info')->where('gender', 'Female')->count_all_results();
    
    // Staff by employee type
    $permanent = $this->db->from('staff_info')->where('employee_type', 'Permanent')->count_all_results();
    $contract = $this->db->from('staff_info')->where('employee_type', 'Contract')->count_all_results();
    $intern = $this->db->from('staff_info')->where('employee_type', 'Intern')->count_all_results();
    
    // Leave requests
    $pending_leaves = $this->db->from('leave_requests')->where('status', 'request')->count_all_results();
    $approved_leaves = $this->db->from('leave_requests')->where('status', 'approved')->count_all_results();
    $rejected_leaves = $this->db->from('leave_requests')->where('status', 'rejected')->count_all_results();
    
    // Total salary
    $total_salary = $this->db->select('SUM(basic_salary) as total')
        ->from('staff_info')
        ->where('status', 'Active')
        ->get()
        ->row();
    
    return [
        'total_staff' => $total_staff,
        'active_staff' => $active_staff,
        'inactive_staff' => $inactive_staff,
        'male_staff' => $male_staff,
        'female_staff' => $female_staff,
        'permanent' => $permanent,
        'contract' => $contract,
        'intern' => $intern,
        'pending_leaves' => $pending_leaves,
        'approved_leaves' => $approved_leaves,
        'rejected_leaves' => $rejected_leaves,
        'total_salary' => (float)($total_salary->total ?? 0),
        'formatted_salary' => $this->format_currency($total_salary->total ?? 0),
    ];
}

/**
 * Get recent staff members
 */
public function get_recent_staff($limit = 5) {
    return $this->db->select('staff_id, staff_no, full_name, calling_name, designation, email, phone, joining_date, status')
        ->from('staff_info')
        ->order_by('joining_date', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get leave requests with staff details
 */
public function get_leave_requests($limit = 10, $status = null) {
    $this->db->select('
            lr.leave_request_id,
            lr.employee_id,
            lr.leave_type_id,
            lr.start_date,
            lr.end_date,
            lr.total_days,
            lr.reason,
            lr.status,
            lr.created_at,
            si.full_name,
            si.staff_no,
            si.designation,
            si.email,
            si.phone
        ')
        ->from('leave_requests lr')
        ->join('staff_info si', 'si.staff_id = lr.employee_id', 'left')
        ->order_by('lr.created_at', 'DESC')
        ->limit($limit);
    
    if ($status) {
        $this->db->where('lr.status', $status);
    }
    
    return $this->db->get()->result();
}

/**
 * Get leave statistics by month
 */
public function get_leave_statistics($year = null) {
    $year = $year ?? date('Y');
    
    $stats = [];
    for ($month = 1; $month <= 12; $month++) {
        $month_name = date('M', mktime(0, 0, 0, $month, 1, $year));
        
        $total = $this->db->from('leave_requests')
            ->where('YEAR(start_date)', $year)
            ->where('MONTH(start_date)', $month)
            ->count_all_results();
        
        $approved = $this->db->from('leave_requests')
            ->where('YEAR(start_date)', $year)
            ->where('MONTH(start_date)', $month)
            ->where('status', 'approved')
            ->count_all_results();
        
        $pending = $this->db->from('leave_requests')
            ->where('YEAR(start_date)', $year)
            ->where('MONTH(start_date)', $month)
            ->where('status', 'request')
            ->count_all_results();
        
        $stats[] = [
            'month' => $month_name,
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
        ];
    }
    
    return $stats;
}

/**
 * Get staff by designation
 */
public function get_staff_by_designation() {
    return $this->db->select('designation, COUNT(*) as count')
        ->from('staff_info')
        ->where('status', 'Active')
        ->group_by('designation')
        ->order_by('count', 'DESC')
        ->get()
        ->result();
}

/**
 * Get staff salary summary
 */
public function get_salary_summary() {
    $stats = $this->db->select('
            COUNT(*) as total_employees,
            SUM(basic_salary) as total_salary,
            AVG(basic_salary) as avg_salary,
            MIN(basic_salary) as min_salary,
            MAX(basic_salary) as max_salary
        ')
        ->from('staff_info')
        ->where('status', 'Active')
        ->get()
        ->row();
    
    return [
        'total_employees' => (int)($stats->total_employees ?? 0),
        'total_salary' => (float)($stats->total_salary ?? 0),
        'avg_salary' => (float)($stats->avg_salary ?? 0),
        'min_salary' => (float)($stats->min_salary ?? 0),
        'max_salary' => (float)($stats->max_salary ?? 0),
        'formatted_total' => $this->format_currency($stats->total_salary ?? 0),
        'formatted_avg' => $this->format_currency($stats->avg_salary ?? 0),
    ];
}

/**
 * Get upcoming birthdays
 */
public function get_upcoming_birthdays($days = 30) {
    $date = date('Y-m-d');
    $future_date = date('Y-m-d', strtotime("+$days days"));
    
    return $this->db->select('staff_id, full_name, calling_name, designation, dob, phone, email')
        ->from('staff_info')
        ->where('status', 'Active')
        ->where('DATE_FORMAT(dob, "%m-%d") BETWEEN DATE_FORMAT("' . $date . '", "%m-%d") AND DATE_FORMAT("' . $future_date . '", "%m-%d")')
        ->order_by('DATE_FORMAT(dob, "%m-%d")', 'ASC')
        ->get()
        ->result();
}

/**
 * Get leave balance for an employee
 */
public function get_leave_balance($employee_id) {
    // This would typically come from a leave balance table
    // For now, calculate based on approved leaves
    $total_approved = $this->db->from('leave_requests')
        ->where('employee_id', $employee_id)
        ->where('status', 'approved')
        ->where('YEAR(start_date)', date('Y'))
        ->select('SUM(total_days) as total')
        ->get()
        ->row();
    
    $annual_entitlement = 21; // Default annual leave entitlement
    
    return [
        'annual_entitlement' => $annual_entitlement,
        'used' => (int)($total_approved->total ?? 0),
        'balance' => $annual_entitlement - (int)($total_approved->total ?? 0),
    ];
}

/**
 * Get attendance summary (if you have attendance table)
 */
public function get_attendance_summary() {
    $today = date('Y-m-d');
    
    $present = $this->db->from('attendance')
        ->where('date', $today)
        ->where('status', 'present')
        ->count_all_results();
    
    $absent = $this->db->from('attendance')
        ->where('date', $today)
        ->where('status', 'absent')
        ->count_all_results();
    
    $late = $this->db->from('attendance')
        ->where('date', $today)
        ->where('status', 'late')
        ->count_all_results();
    
    $total = $this->db->count_all('staff_info');
    
    return [
        'total' => $total,
        'present' => $present,
        'absent' => $absent,
        'late' => $late,
        'present_percentage' => $total > 0 ? round(($present / $total) * 100) : 0,
    ];
}
// ========== MONTHLY COLLECTIONS VS BILLED ==========

/**
 * Get monthly collections vs billed data for customers (Sales)
 */
public function get_monthly_collections($months = 6) {
    $labels = [];
    $billed = [];
    $cashCard = [];
    $creditRecovered = [];
    
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = date('Y-m-01', strtotime("-$i months"));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_num = date('m', strtotime($date));
        $end_date = date('Y-m-t', strtotime($date));
        
        $labels[] = $month . ' ' . $year;
        
        // Total billed (completed invoices for the month)
        $bill = $this->db->select('SUM(grand_total) as total')
            ->from('sales_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status', 'COMPLETED')
            ->get()
            ->row();
        $billed[] = round(($bill->total ?? 0) / 1000);
        
        // Cash + Card collected (invoices with PAID or PARTIAL status)
        // Using payment_status from sales_invoices
        $cc = $this->db->select('SUM(grand_total) as total')
            ->from('sales_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status', 'COMPLETED')
            ->where('payment_status !=', 'UNPAID')
            ->get()
            ->row();
        $cashCard[] = round(($cc->total ?? 0) / 1000);
        
        // Credit recovered (invoices that were UNPAID in previous months but got paid this month)
        // This uses updated_at to track when payment status changed
        $cr = $this->db->select('SUM(grand_total) as total')
            ->from('sales_invoices')
            ->where('YEAR(updated_at)', $year)
            ->where('MONTH(updated_at)', $month_num)
            ->where('status', 'COMPLETED')
            ->where('payment_status', 'PAID')
            ->where('MONTH(invoice_date) <', $month_num)
            ->get()
            ->row();
        $creditRecovered[] = round(($cr->total ?? 0) / 1000);
    }
    
    return [
        'labels' => $labels,
        'billed' => $billed,
        'cashCard' => $cashCard,
        'creditRecovered' => $creditRecovered
    ];
}

/**
 * Get monthly collections vs billed data for suppliers (Purchases)
 */
public function get_monthly_purchases($months = 6) {
    $labels = [];
    $purchased = [];
    $paid = [];
    $creditRecovered = [];
    
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = date('Y-m-01', strtotime("-$i months"));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_num = date('m', strtotime($date));
        
        $labels[] = $month . ' ' . $year;
        
        // Total purchased (supplier invoices for the month)
        $purch = $this->db->select('SUM(grand_total) as total')
            ->from('supplier_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status !=', 'cancelled')
            ->get()
            ->row();
        $purchased[] = round(($purch->total ?? 0) / 1000);
        
        // Paid amount for purchases
        $paid_amt = $this->db->select('SUM(paid_amount) as total')
            ->from('supplier_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status !=', 'cancelled')
            ->where('status', 'paid')
            ->get()
            ->row();
        $paid[] = round(($paid_amt->total ?? 0) / 1000);
        
        // Credit recovered (payments made on previous month purchases)
        $cr = $this->db->select('SUM(paid_amount) as total')
            ->from('supplier_invoices')
            ->where('YEAR(updated_at)', $year)
            ->where('MONTH(updated_at)', $month_num)
            ->where('status', 'paid')
            ->where('MONTH(invoice_date) <', $month_num)
            ->get()
            ->row();
        $creditRecovered[] = round(($cr->total ?? 0) / 1000);
    }
    
    return [
        'labels' => $labels,
        'purchased' => $purchased,
        'paid' => $paid,
        'creditRecovered' => $creditRecovered
    ];
}

/**
 * Get collection summary for current month
 */
public function get_collection_summary() {
    $month = date('m');
    $year = date('Y');
    $first_day = date('Y-m-01');
    
    // Current month billed
    $billed = $this->db->select('SUM(grand_total) as total')
        ->from('sales_invoices')
        ->where('MONTH(invoice_date)', $month)
        ->where('YEAR(invoice_date)', $year)
        ->where('status', 'COMPLETED')
        ->get()
        ->row();
    
    // Current month collected (invoices with PAID or PARTIAL status)
    $collected = $this->db->select('SUM(grand_total) as total')
        ->from('sales_invoices')
        ->where('MONTH(invoice_date)', $month)
        ->where('YEAR(invoice_date)', $year)
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'UNPAID')
        ->get()
        ->row();
    
    // OR use sales_payments table
    // $collected = $this->db->select('SUM(sp.total_amount) as total')
    //     ->from('sales_payments sp')
    //     ->join('sales_invoices si', 'si.id = sp.invoice_id')
    //     ->where('MONTH(sp.payment_date)', $month)
    //     ->where('YEAR(sp.payment_date)', $year)
    //     ->where('si.status', 'COMPLETED')
    //     ->get()
    //     ->row();
    
    // Credit recovered this month (from previous months)
    $credit_rec = $this->db->select('SUM(grand_total) as total')
        ->from('sales_invoices')
        ->where('MONTH(updated_at)', $month)
        ->where('YEAR(updated_at)', $year)
        ->where('status', 'COMPLETED')
        ->where('payment_status', 'PAID')
        ->where('MONTH(invoice_date) <', $month)
        ->get()
        ->row();
    
    $billed_total = (float)($billed->total ?? 0);
    $collected_total = (float)($collected->total ?? 0);
    $credit_total = (float)($credit_rec->total ?? 0);
    
    $collection_rate = $billed_total > 0 ? round((($collected_total + $credit_total) / $billed_total) * 100) : 0;
    
    // Debug: Log the values
    log_message('debug', 'Collection Summary - Billed: ' . $billed_total . ', Collected: ' . $collected_total . ', Credit: ' . $credit_total . ', Rate: ' . $collection_rate);
    
    return [
        'billed' => $billed_total,
        'collected' => $collected_total,
        'credit_recovered' => $credit_total,
        'collection_rate' => $collection_rate,
        'formatted_billed' => $this->format_currency($billed_total),
        'formatted_collected' => $this->format_currency($collected_total),
        'formatted_credit' => $this->format_currency($credit_total),
    ];
}

/**
 * Get outstanding receivables
 */
public function get_outstanding_receivables() {
    $total_receivables = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->get()
        ->row();
    
    $overdue = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->where('due_date <', date('Y-m-d'))
        ->get()
        ->row();
    
    return [
        'total' => (float)($total_receivables->total ?? 0),
        'overdue' => (float)($overdue->total ?? 0),
        'formatted_total' => $this->format_currency($total_receivables->total ?? 0),
        'formatted_overdue' => $this->format_currency($overdue->total ?? 0),
    ];
}

/**
 * Get aging summary for receivables
 */
public function get_receivables_aging() {
    $buckets = [
        ['label' => '0–30 days', 'max_days' => 30, 'color' => '#3B6D11'],
        ['label' => '31–60 days', 'max_days' => 60, 'color' => '#EF9F27'],
        ['label' => '61–90 days', 'max_days' => 90, 'color' => '#D85A30'],
        ['label' => '90+ days', 'max_days' => 9999, 'color' => '#A32D2D']
    ];
    
    $result = [];
    $grand = 0;
    
    foreach ($buckets as $b) {
        $total = $this->db->select('SUM(balance_amount) as total')
            ->from('sales_invoices')
            ->where('payment_status !=', 'PAID')
            ->where('status', 'COMPLETED')
            ->where('DATEDIFF(CURDATE(), due_date) <=', $b['max_days'])
            ->where('DATEDIFF(CURDATE(), due_date) >', $b['max_days'] - 30)
            ->get()
            ->row();
        
        $val = (float)($total->total ?? 0);
        $result[] = [
            'label' => $b['label'],
            'pct' => 0,
            'color' => $b['color'],
            'val' => $val,
            'formatted_val' => $this->format_currency($val)
        ];
        $grand += $val;
    }
    
    foreach ($result as &$r) {
        $r['pct'] = $grand > 0 ? round(($r['val'] / $grand) * 100) : 0;
    }
    
    return $result;
}
// ========== CUMULATIVE RECEIVABLES VS PAYABLES ==========


/**
 * Get receivables aging by customer
 */
public function get_receivables_aging_detail($limit = 10) {
    return $this->db->select(' 
            c.cus_name as customer_name,
            COUNT(si.id) as invoice_count,
            SUM(si.balance_amount) as total_due,
            SUM(CASE WHEN si.due_date < CURDATE() THEN si.balance_amount ELSE 0 END) as overdue_amount,
            MAX(si.due_date) as oldest_due_date,
            MIN(si.due_date) as newest_due_date
        ')
        ->from('sales_invoices si')
        ->join('customer c', 'c.cus_id = si.customer_id', 'left')
        ->where('si.status', 'COMPLETED')
        ->where('si.payment_status !=', 'PAID')
        ->group_by('si.customer_id')
        ->order_by('total_due', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get payables aging by supplier
 */
public function get_payables_aging_detail($limit = 10) {
    return $this->db->select('
            s.name as supplier_name,
            COUNT(si.id) as invoice_count,
            SUM(si.balance_amount) as total_due,
            SUM(CASE WHEN si.due_date < CURDATE() THEN si.balance_amount ELSE 0 END) as overdue_amount,
            MAX(si.due_date) as oldest_due_date,
            MIN(si.due_date) as newest_due_date
        ')
        ->from('supplier_invoices si')
        ->join('supply s', 's.id = si.supplier_id', 'left')
        ->where('si.status !=', 'paid')
        ->where('si.status !=', 'cancelled')
        ->group_by('si.supplier_id')
        ->order_by('total_due', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get monthly receivables vs payables comparison
 */
public function get_monthly_rp_comparison($months = 6) {
    $labels = [];
    $receivables_monthly = [];
    $payables_monthly = [];
    
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = date('Y-m-01', strtotime("-$i months"));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_num = date('m', strtotime($date));
        
        $labels[] = $month . ' ' . $year;
        
        // New receivables added this month
        $rec = $this->db->select('SUM(grand_total) as total')
            ->from('sales_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status', 'COMPLETED')
            ->get()
            ->row();
        $receivables_monthly[] = round(($rec->total ?? 0) / 1000);
        
        // New payables added this month
        $pay = $this->db->select('SUM(grand_total) as total')
            ->from('supplier_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status !=', 'cancelled')
            ->get()
            ->row();
        $payables_monthly[] = round(($pay->total ?? 0) / 1000);
    }
    
    return [
        'labels' => $labels,
        'receivables' => $receivables_monthly,
        'payables' => $payables_monthly
    ];
}
/**
 * Get cumulative receivables vs payables data for chart (6 months)
 */
public function get_receivables_payables_trend($months = 6) {
    $labels = [];
    $receivables = [];
    $payables = [];
    $netPosition = [];
    
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = date('Y-m-01', strtotime("-$i months"));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_num = date('m', strtotime($date));
        $end_date = date('Y-m-t', strtotime($date));
        
        $labels[] = $month . ' ' . $year;
        
        // Total receivables (unpaid sales invoices up to this month)
        $rec = $this->db->select('SUM(balance_amount) as total')
            ->from('sales_invoices')
            ->where('status', 'COMPLETED')
            ->where('payment_status !=', 'PAID')
            ->where('invoice_date <=', $end_date)
            ->get()
            ->row();
        $receivables[] = round(($rec->total ?? 0) / 1000);
        
        // Total payables (unpaid supplier invoices up to this month)
        $pay = $this->db->select('SUM(balance_amount) as total')
            ->from('supplier_invoices')
            ->where('status !=', 'paid')
            ->where('status !=', 'cancelled')
            ->where('invoice_date <=', $end_date)
            ->get()
            ->row();
        $payables[] = round(($pay->total ?? 0) / 1000);
        
        // Net position (Receivables - Payables)
        $netPosition[] = round((($rec->total ?? 0) - ($pay->total ?? 0)) / 1000);
    }
    
    return [
        'labels' => $labels,
        'receivables' => $receivables,
        'payables' => $payables,
        'netPosition' => $netPosition
    ];
}

/**
 * Get current receivables and payables summary
 */
public function get_receivables_payables_summary() {
    // Current receivables
    $receivables = $this->db->select('
            SUM(balance_amount) as total,
            COUNT(CASE WHEN due_date < CURDATE() THEN 1 END) as overdue_count,
            SUM(CASE WHEN due_date < CURDATE() THEN balance_amount ELSE 0 END) as overdue_amount
        ')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->get()
        ->row();
    
    // Current payables
    $payables = $this->db->select('
            SUM(balance_amount) as total,
            COUNT(CASE WHEN due_date < CURDATE() THEN 1 END) as overdue_count,
            SUM(CASE WHEN due_date < CURDATE() THEN balance_amount ELSE 0 END) as overdue_amount
        ')
        ->from('supplier_invoices')
        ->where('status !=', 'paid')
        ->where('status !=', 'cancelled')
        ->get()
        ->row();
    
    $rec_total = (float)($receivables->total ?? 0);
    $pay_total = (float)($payables->total ?? 0);
    $net_position = $rec_total - $pay_total;
    
    return [
        'receivables' => [
            'total' => $rec_total,
            'formatted' => $this->format_currency($rec_total),
            'overdue_count' => (int)($receivables->overdue_count ?? 0),
            'overdue_amount' => (float)($receivables->overdue_amount ?? 0),
            'overdue_formatted' => $this->format_currency($receivables->overdue_amount ?? 0),
        ],
        'payables' => [
            'total' => $pay_total,
            'formatted' => $this->format_currency($pay_total),
            'overdue_count' => (int)($payables->overdue_count ?? 0),
            'overdue_amount' => (float)($payables->overdue_amount ?? 0),
            'overdue_formatted' => $this->format_currency($payables->overdue_amount ?? 0),
        ],
        'net_position' => $net_position,
        'net_formatted' => $this->format_currency($net_position),
        'is_favourable' => $net_position > 0,
    ];
}
// ========== TOTAL SALES EARNINGS & SETTLED AMOUNT ==========

/**
 * Get sales earnings data for Today, Yesterday, This Month, Last Month
 */
public function get_sales_earnings() {
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $first_day_month = date('Y-m-01');
    $first_day_last_month = date('Y-m-01', strtotime('-1 month'));
    $last_day_last_month = date('Y-m-t', strtotime('-1 month'));

    // Get payment methods from sales_payment_items
    // Today's sales
    $today_sales = $this->db->select('
            SUM(si.grand_total) as amount,
            COUNT(DISTINCT si.id) as bills,
            SUM(CASE WHEN spi.payment_method = "CASH" THEN spi.amount ELSE 0 END) as cash,
            SUM(CASE WHEN spi.payment_method = "CARD" THEN spi.amount ELSE 0 END) as card,
            SUM(CASE WHEN spi.payment_method = "CREDIT" THEN spi.amount ELSE 0 END) as credit
        ')
        ->from('sales_invoices si')
        ->join('sales_payments sp', 'sp.invoice_id = si.id', 'left')
        ->join('sales_payment_items spi', 'spi.payment_id = sp.id', 'left')
        ->where('DATE(si.invoice_date)', $today)
        ->where('si.status', 'COMPLETED')
        ->get()
        ->row();

    // Yesterday's sales
    $yesterday_sales = $this->db->select('
            SUM(si.grand_total) as amount,
            COUNT(DISTINCT si.id) as bills,
            SUM(CASE WHEN spi.payment_method = "CASH" THEN spi.amount ELSE 0 END) as cash,
            SUM(CASE WHEN spi.payment_method = "CARD" THEN spi.amount ELSE 0 END) as card,
            SUM(CASE WHEN spi.payment_method = "CREDIT" THEN spi.amount ELSE 0 END) as credit
        ')
        ->from('sales_invoices si')
        ->join('sales_payments sp', 'sp.invoice_id = si.id', 'left')
        ->join('sales_payment_items spi', 'spi.payment_id = sp.id', 'left')
        ->where('DATE(si.invoice_date)', $yesterday)
        ->where('si.status', 'COMPLETED')
        ->get()
        ->row();

    // This month's sales
    $month_sales = $this->db->select('
            SUM(si.grand_total) as amount,
            COUNT(DISTINCT si.id) as bills,
            SUM(CASE WHEN spi.payment_method = "CASH" THEN spi.amount ELSE 0 END) as cash,
            SUM(CASE WHEN spi.payment_method = "CARD" THEN spi.amount ELSE 0 END) as card,
            SUM(CASE WHEN spi.payment_method = "CREDIT" THEN spi.amount ELSE 0 END) as credit
        ')
        ->from('sales_invoices si')
        ->join('sales_payments sp', 'sp.invoice_id = si.id', 'left')
        ->join('sales_payment_items spi', 'spi.payment_id = sp.id', 'left')
        ->where('si.invoice_date >=', $first_day_month)
        ->where('si.status', 'COMPLETED')
        ->get()
        ->row();

    // Last month's sales
    $last_month_sales = $this->db->select('
            SUM(si.grand_total) as amount,
            COUNT(DISTINCT si.id) as bills,
            SUM(CASE WHEN spi.payment_method = "CASH" THEN spi.amount ELSE 0 END) as cash,
            SUM(CASE WHEN spi.payment_method = "CARD" THEN spi.amount ELSE 0 END) as card,
            SUM(CASE WHEN spi.payment_method = "CREDIT" THEN spi.amount ELSE 0 END) as credit
        ')
        ->from('sales_invoices si')
        ->join('sales_payments sp', 'sp.invoice_id = si.id', 'left')
        ->join('sales_payment_items spi', 'spi.payment_id = sp.id', 'left')
        ->where('si.invoice_date >=', $first_day_last_month)
        ->where('si.invoice_date <=', $last_day_last_month)
        ->where('si.status', 'COMPLETED')
        ->get()
        ->row();

    return [
        'today' => [
            'amount' => (float)($today_sales->amount ?? 0),
            'bills' => (int)($today_sales->bills ?? 0),
            'cash' => (float)($today_sales->cash ?? 0),
            'card' => (float)($today_sales->card ?? 0),
            'credit' => (float)($today_sales->credit ?? 0)
        ],
        'yesterday' => [
            'amount' => (float)($yesterday_sales->amount ?? 0),
            'bills' => (int)($yesterday_sales->bills ?? 0),
            'cash' => (float)($yesterday_sales->cash ?? 0),
            'card' => (float)($yesterday_sales->card ?? 0),
            'credit' => (float)($yesterday_sales->credit ?? 0)
        ],
        'this_month' => [
            'amount' => (float)($month_sales->amount ?? 0),
            'bills' => (int)($month_sales->bills ?? 0),
            'cash' => (float)($month_sales->cash ?? 0),
            'card' => (float)($month_sales->card ?? 0),
            'credit' => (float)($month_sales->credit ?? 0)
        ],
        'last_month' => [
            'amount' => (float)($last_month_sales->amount ?? 0),
            'bills' => (int)($last_month_sales->bills ?? 0),
            'cash' => (float)($last_month_sales->cash ?? 0),
            'card' => (float)($last_month_sales->card ?? 0),
            'credit' => (float)($last_month_sales->credit ?? 0)
        ]
    ];
}

/**
 * Get Sale Total vs Settled Amount data for chart (15 months)
 */
public function get_settled_vs_total($months = 15) {
    $labels = [];
    $saleTotal = [];
    $settledAmt = [];
    
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = date('Y-m-01', strtotime("-$i months"));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_num = date('m', strtotime($date));
        
        $labels[] = $month . ' ' . $year;
        
        // Total sales for the month
        $sales = $this->db->select('SUM(grand_total) as total')
            ->from('sales_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status', 'COMPLETED')
            ->get()
            ->row();
        $saleTotal[] = round(($sales->total ?? 0) / 1000);
        
        // Settled amount (payments received for invoices from this month)
        $settled = $this->db->select('SUM(sp.total_amount) as total')
            ->from('sales_payments sp')
            ->join('sales_invoices si', 'si.id = sp.invoice_id')
            ->where('YEAR(sp.payment_date)', $year)
            ->where('MONTH(sp.payment_date)', $month_num)
            ->where('si.status', 'COMPLETED')
            ->get()
            ->row();
        $settledAmt[] = round(($settled->total ?? 0) / 1000);
    }
    
    return [ 
        'labels' => $labels,
        'saleTotal' => $saleTotal,
        'settledAmt' => $settledAmt
    ];
}
/**
 * Get current month settled vs total summary
 */
public function get_settled_summary() {
    $month = date('m');
    $year = date('Y');
    
    // Total sales this month
    $total_sales = $this->db->select('SUM(grand_total) as total')
        ->from('sales_invoices')
        ->where('MONTH(invoice_date)', $month)
        ->where('YEAR(invoice_date)', $year)
        ->where('status', 'COMPLETED')
        ->get()
        ->row();
    
    // Total settled this month
    $total_settled = $this->db->select('SUM(sp.total_amount) as total')
        ->from('sales_payments sp')
        ->join('sales_invoices si', 'si.id = sp.invoice_id')
        ->where('MONTH(sp.payment_date)', $month)
        ->where('YEAR(sp.payment_date)', $year)
        ->where('si.status', 'COMPLETED')
        ->get()
        ->row();
    
    $total = (float)($total_sales->total ?? 0);
    $settled = (float)($total_settled->total ?? 0);
    $settlement_rate = $total > 0 ? round(($settled / $total) * 100) : 0;
    
    return [
        'total_sales' => $total,
        'total_settled' => $settled,
        'settlement_rate' => $settlement_rate,
        'formatted_sales' => $this->format_currency($total),
        'formatted_settled' => $this->format_currency($settled),
    ];
}
/**
 * Get daily sales trend with all payment methods
 */
public function get_sales_trend($days = 7) {
    $labels = [];
    $cash = [];
    $card = [];
    $bank = [];
    $cheque = [];
    $credit = [];
    
    for ($i = $days - 1; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('M d', strtotime($date));
        
        // Query your database here
        // Make sure you have data in your sales_payment_items table
        $row = $this->db->select("
                SUM(CASE WHEN spi.payment_method = 'CASH' THEN spi.amount ELSE 0 END) as cash,
                SUM(CASE WHEN spi.payment_method = 'CARD' THEN spi.amount ELSE 0 END) as card,
                SUM(CASE WHEN spi.payment_method = 'BANK' THEN spi.amount ELSE 0 END) as bank,
                SUM(CASE WHEN spi.payment_method = 'CHEQUE' THEN spi.amount ELSE 0 END) as cheque,
                SUM(CASE WHEN spi.payment_method = 'CREDIT' THEN spi.amount ELSE 0 END) as credit
            ")
            ->from('sales_invoices si')
            ->join('sales_payments sp', 'sp.invoice_id = si.id', 'left')
            ->join('sales_payment_items spi', 'spi.payment_id = sp.id', 'left')
            ->where('DATE(si.invoice_date)', $date)
            ->where('si.status', 'COMPLETED')
            ->get()
            ->row();
        
        // If no data, use 0
        $cash[] = (float)(($row->cash ?? 0) / 1000);
        $card[] = (float)(($row->card ?? 0) / 1000);
        $bank[] = (float)(($row->bank ?? 0) / 1000);
        $cheque[] = (float)(($row->cheque ?? 0) / 1000);
        $credit[] = (float)(($row->credit ?? 0) / 1000);
    }
    
    return [
        'labels' => $labels,
        'cash' => $cash,
        'card' => $card,
        'bank' => $bank,
        'cheque' => $cheque,
        'credit' => $credit
    ];
}/**
 * Get monthly sales progress for the last 12 months
 */
public function get_monthly_progress($months = 12) {
    $labels = [];
    $values = [];
    
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = date('Y-m-01', strtotime("-$i months"));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_num = date('m', strtotime($date));
        
        $labels[] = $month . ' ' . $year;
        
        // Total sales for the month (completed invoices only)
        $sales = $this->db->select('SUM(grand_total) as total')
            ->from('sales_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status', 'COMPLETED')
            ->get()
            ->row();
        
        $values[] = round(($sales->total ?? 0) / 1000);
    }
    
    return [
        'labels' => $labels,
        'values' => $values
    ];
}
// ========== TOP SELLING ITEMS ==========

/**
 * Get top selling items based on sales volume
 */
public function get_top_selling_items($limit = 7) {
    $items = $this->db->select('
            p.id as product_id,
            p.name as product_name,
            p.product_code,
            SUM(si.qty) as total_quantity,
            SUM(si.qty * si.unit_price) as total_sales,
            COUNT(DISTINCT si.invoice_id) as invoice_count,
            AVG(si.unit_price) as avg_price
        ')
        ->from('sales_invoice_items si')
        ->join('products p', 'p.id = si.product_id', 'left')
        ->join('sales_invoices si2', 'si2.id = si.invoice_id', 'left')
        ->where('si2.status', 'COMPLETED')
        ->group_by('si.product_id')
        ->order_by('total_sales', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
    
    return $items;
}

/**
 * Get top selling items with formatted data for chart
 */
public function get_top_items_chart_data($limit = 7) {
    $items = $this->get_top_selling_items($limit);
    
    $colors = [
        '#D4537E', '#854F0B', '#3B6D11', '#EF9F27', 
        '#534AB7', '#185FA5', '#0F6E56', '#A32D2D',
        '#B4B2A9', '#378ADD', '#D85A30'
    ];
    
    $result = [];
    $total_sales = 0;
    
    foreach ($items as $item) {
        $total_sales += $item->total_sales;
    }
    
    foreach ($items as $index => $item) {
        $percentage = $total_sales > 0 ? round(($item->total_sales / $total_sales) * 100) : 0;
        $result[] = [
            'name' => $item->product_name ?? 'Unknown Product',
            'value' => (float)$item->total_sales,
            'quantity' => (int)$item->total_quantity,
            'invoices' => (int)$item->invoice_count,
            'avg_price' => (float)$item->avg_price,
            'color' => $colors[$index % count($colors)],
            'percentage' => $percentage
        ];
    }
    
    return $result;
}

/**
 * Get top selling items by quantity (most units sold)
 */
public function get_top_items_by_quantity($limit = 7) {
    return $this->db->select('
            p.name as product_name,
            p.product_code,
            SUM(si.qty) as total_quantity,
            SUM(si.qty * si.unit_price) as total_sales
        ')
        ->from('sales_invoice_items si')
        ->join('products p', 'p.id = si.product_id', 'left')
        ->join('sales_invoices si2', 'si2.id = si.invoice_id', 'left')
        ->where('si2.status', 'COMPLETED')
        ->group_by('si.product_id')
        ->order_by('total_quantity', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get top selling items by revenue for a specific period
 */
public function get_top_items_by_period($period = 'month', $limit = 7) {
    $date_condition = '';
    
    switch ($period) {
        case 'today':
            $date_condition = "DATE(si2.invoice_date) = CURDATE()";
            break;
        case 'week':
            $date_condition = "YEARWEEK(si2.invoice_date) = YEARWEEK(CURDATE())";
            break;
        case 'month':
            $date_condition = "MONTH(si2.invoice_date) = MONTH(CURDATE()) AND YEAR(si2.invoice_date) = YEAR(CURDATE())";
            break;
        case 'quarter':
            $date_condition = "QUARTER(si2.invoice_date) = QUARTER(CURDATE()) AND YEAR(si2.invoice_date) = YEAR(CURDATE())";
            break;
        case 'year':
            $date_condition = "YEAR(si2.invoice_date) = YEAR(CURDATE())";
            break;
        default:
            $date_condition = "MONTH(si2.invoice_date) = MONTH(CURDATE()) AND YEAR(si2.invoice_date) = YEAR(CURDATE())";
    }
    
    return $this->db->select('
            p.name as product_name,
            p.product_code,
            SUM(si.qty) as total_quantity,
            SUM(si.qty * si.unit_price) as total_sales
        ')
        ->from('sales_invoice_items si')
        ->join('products p', 'p.id = si.product_id', 'left')
        ->join('sales_invoices si2', 'si2.id = si.invoice_id', 'left')
        ->where('si2.status', 'COMPLETED')
        ->where($date_condition, null, false)
        ->group_by('si.product_id')
        ->order_by('total_sales', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get top selling items with product details including unit
 */
public function get_top_items_with_details($limit = 7) {
    return $this->db->select('
            p.id as product_id,
            p.name as product_name,
            p.product_code,
            p.unit_id,
            u.name as unit_name,
            SUM(si.qty) as total_quantity,
            SUM(si.qty * si.unit_price) as total_sales,
            COUNT(DISTINCT si.invoice_id) as invoice_count,
            AVG(si.unit_price) as avg_price,
            MIN(si.unit_price) as min_price,
            MAX(si.unit_price) as max_price
        ')
        ->from('sales_invoice_items si')
        ->join('products p', 'p.id = si.product_id', 'left')
        ->join('units u', 'u.id = p.unit_id', 'left')
        ->join('sales_invoices si2', 'si2.id = si.invoice_id', 'left')
        ->where('si2.status', 'COMPLETED')
        ->group_by('si.product_id')
        ->order_by('total_sales', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get top selling items with category information
 */
public function get_top_items_with_categories($limit = 7) {
    return $this->db->select('
            p.id as product_id,
            p.name as product_name,
            p.product_code,
            c.name as category_name,
            sc.name as sub_category_name,
            SUM(si.qty) as total_quantity,
            SUM(si.qty * si.unit_price) as total_sales
        ')
        ->from('sales_invoice_items si')
        ->join('products p', 'p.id = si.product_id', 'left')
        ->join('categories c', 'c.id = p.category_id', 'left')
        ->join('sub_categories sc', 'sc.id = p.sub_category_id', 'left')
        ->join('sales_invoices si2', 'si2.id = si.invoice_id', 'left')
        ->where('si2.status', 'COMPLETED')
        ->group_by('si.product_id')
        ->order_by('total_sales', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get top selling items for dashboard with fallback if no data
 */
public function get_top_items_for_dashboard($limit = 7) {
    $items = $this->get_top_items_chart_data($limit);
    
    // If no items found, return empty array with a message
    if (empty($items)) {
        return [
            'items' => [],
            'has_data' => false,
            'message' => 'No sales data available'
        ];
    }
    
    return [
        'items' => $items,
        'has_data' => true,
        'total_items' => count($items),
        'top_item' => $items[0] ?? null
    ];
}
// ========== INVENTORY OVERVIEW ==========

/**
 * Get inventory stock by branch
 */
public function get_stock_by_branch() {
    $result = $this->db->select('
            b.branch_id,
            b.branch_name as name,
            SUM(isq.qty) as total_qty,
            SUM(isq.qty * isq.avg_cost) as stock_value
        ')
        ->from('inventory_stock isq')
        ->join('branches b', 'b.branch_id = isq.branch_id', 'left')
        ->group_by('isq.branch_id')
        ->get()
        ->result();
    
    // If no branches found, return empty array
    if (empty($result)) {
        return [];
    }
    
    // Calculate percentages
    $total_value = array_sum(array_column($result, 'stock_value'));
    foreach ($result as &$r) {
        $r->pct = $total_value > 0 ? round(($r->stock_value / $total_value) * 100) : 0;
        $r->name = $r->name ?? 'Branch ' . ($r->branch_id ?? 'Unknown');
    }
    
    return $result;
}

/**
 * Get stock by store (using stores table instead of warehouses)
 */
public function get_stock_by_store() {
    // Check if stores table exists
    if (!$this->db->table_exists('stores')) {
        return [];
    }
    
    $result = $this->db->select('
            s.store_id,
            s.store_name as name,
            SUM(isq.qty) as total_qty,
            SUM(isq.qty * isq.avg_cost) as stock_value
        ')
        ->from('inventory_stock isq')
        ->join('stores s', 's.store_id = isq.warehouse_id', 'left')
        ->group_by('isq.warehouse_id')
        ->get()
        ->result();
    
    // Calculate percentages
    $total_value = array_sum(array_column($result, 'stock_value'));
    foreach ($result as &$r) {
        $r->pct = $total_value > 0 ? round(($r->stock_value / $total_value) * 100) : 0;
        $r->name = $r->name ?? 'Store ' . ($r->store_id ?? 'Unknown');
    }
    
    return $result;
}

/**
 * Get total inventory value
 */
public function get_total_inventory_value() {
    $result = $this->db->select('SUM(qty * avg_cost) as total_value')
        ->from('inventory_stock')
        ->get()
        ->row();
    
    return (float)($result->total_value ?? 0);
}

/**
 * Get inventory stock summary
 */
public function get_inventory_summary() {
    // Total items in stock (distinct products)
    $total_items = $this->db->select('COUNT(DISTINCT product_id) as total')
        ->from('inventory_stock')
        ->get()
        ->row();
    
    // Total quantity
    $total_qty = $this->db->select('SUM(qty) as total')
        ->from('inventory_stock')
        ->get()
        ->row();
    
    // Total value
    $total_value = $this->get_total_inventory_value();
    
    // Low stock items (qty <= 10)
    $low_stock = $this->db->select('COUNT(DISTINCT product_id) as count')
        ->from('inventory_stock')
        ->where('qty <=', 10)
        ->where('qty >', 0)
        ->get()
        ->row();
    
    // Items with zero stock
    $zero_stock = $this->db->select('COUNT(DISTINCT product_id) as count')
        ->from('inventory_stock')
        ->where('qty', 0)
        ->get()
        ->row();
    
    // Items with reserved qty
    $reserved = $this->db->select('SUM(reserved_qty) as total')
        ->from('inventory_stock')
        ->get()
        ->row();
    
    // Branches count
    $branches = $this->db->select('COUNT(DISTINCT branch_id) as count')
        ->from('inventory_stock')
        ->get()
        ->row();
    
    // Stores count (using stores table instead of warehouses)
    $stores = $this->db->select('COUNT(DISTINCT warehouse_id) as count')
        ->from('inventory_stock')
        ->get()
        ->row();
    
    return [
        'total_items' => (int)($total_items->total ?? 0),
        'total_qty' => (int)($total_qty->total ?? 0),
        'total_value' => $total_value,
        'formatted_value' => $this->format_currency($total_value),
        'low_stock' => (int)($low_stock->count ?? 0),
        'zero_stock' => (int)($zero_stock->count ?? 0),
        'reserved_qty' => (float)($reserved->total ?? 0),
        'branches' => (int)($branches->count ?? 0),
        'stores' => (int)($stores->count ?? 0),
    ];
}

/**
 * Get top stocked products
 */
public function get_top_stocked_products($limit = 5) {
    return $this->db->select('
            p.id,
            p.name as product_name,
            p.product_code,
            SUM(isq.qty) as total_qty,
            SUM(isq.qty * isq.avg_cost) as stock_value,
            COUNT(DISTINCT isq.branch_id) as branch_count
        ')
        ->from('inventory_stock isq')
        ->join('products p', 'p.id = isq.product_id', 'left')
        ->group_by('isq.product_id')
        ->order_by('total_qty', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get inventory stock alerts (low stock items with product names)
 */
public function get_inventory_alerts($limit = 10) {
    return $this->db->select('
            p.id,
            p.name as product_name,
            p.product_code,
            p.reorder_level,
            SUM(isq.qty) as total_qty,
            SUM(isq.reserved_qty) as total_reserved,
            (SUM(isq.qty) - SUM(isq.reserved_qty)) as available_qty
        ')
        ->from('inventory_stock isq')
        ->join('products p', 'p.id = isq.product_id', 'left')
        ->group_by('isq.product_id')
        ->having('total_qty <= p.reorder_level OR total_qty <= 10')
        ->order_by('total_qty', 'ASC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get stock movement from inventory_stock_log
 */
public function get_stock_movement_summary() {
    // Check if inventory_stock_log table exists
    if (!$this->db->table_exists('inventory_stock_log')) {
        return [
            'in' => 0,
            'out' => 0,
            'adjustments' => 0,
            'formatted_in' => '0',
            'formatted_out' => '0'
        ];
    }
    
    $first_day = date('Y-m-01');
    $today = date('Y-m-d');
    
    // Get stock movements from inventory_stock_log
    $movements = $this->db->select('
            SUM(CASE WHEN old_qty < new_qty THEN (new_qty - old_qty) ELSE 0 END) as stock_in,
            SUM(CASE WHEN old_qty > new_qty THEN (old_qty - new_qty) ELSE 0 END) as stock_out
        ')
        ->from('inventory_stock_log')
        ->where('DATE(changed_at) >=', $first_day)
        ->get()
        ->row();
    
    // Get adjustments from inventory_stock_log where reference_type is 'adjustment'
    $adjustments = $this->db->select('COUNT(*) as count')
        ->from('inventory_stock_log')
        ->where('reference_type', 'adjustment')
        ->where('DATE(changed_at) >=', $first_day)
        ->get()
        ->row();
    
    return [
        'in' => (float)($movements->stock_in ?? 0),
        'out' => (float)($movements->stock_out ?? 0),
        'adjustments' => (int)($adjustments->count ?? 0),
        'formatted_in' => number_format($movements->stock_in ?? 0),
        'formatted_out' => number_format($movements->stock_out ?? 0)
    ];
}

/**
 * Get recent stock movements
 */
public function get_recent_stock_movements($limit = 10) {
    return $this->db->select('
            isl.*,
            p.name as product_name,
            p.product_code,
            b.branch_name,
            u.username as changed_by_name
        ')
        ->from('inventory_stock_log isl')
        ->join('products p', 'p.id = isl.product_id', 'left')
        ->join('branches b', 'b.branch_id = isl.branch_id', 'left')
        ->join('users u', 'u.id = isl.changed_by', 'left')
        ->order_by('isl.changed_at', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get stock value by store (using stores table)
 */
public function get_stock_by_warehouse() {
    // Try stores table first
    if ($this->db->table_exists('stores')) {
        $result = $this->db->select('
                s.store_id,
                s.store_name as name,
                SUM(isq.qty) as total_qty,
                SUM(isq.qty * isq.avg_cost) as stock_value
            ')
            ->from('inventory_stock isq')
            ->join('stores s', 's.store_id = isq.warehouse_id', 'left')
            ->group_by('isq.warehouse_id')
            ->get()
            ->result();
        
        $total_value = array_sum(array_column($result, 'stock_value'));
        foreach ($result as &$r) {
            $r->pct = $total_value > 0 ? round(($r->stock_value / $total_value) * 100) : 0;
            $r->name = $r->name ?? 'Store ' . ($r->store_id ?? 'Unknown');
        }
        
        return $result;
    }
    
    // If no stores table, return empty
    return [];
}

/**
 * Get product stock by branch for a specific product
 */
public function get_product_stock_by_branch($product_id) {
    return $this->db->select('
            b.branch_name,
            isq.qty,
            isq.reserved_qty,
            (isq.qty - isq.reserved_qty) as available_qty,
            isq.avg_cost,
            isq.updated_at
        ')
        ->from('inventory_stock isq')
        ->join('branches b', 'b.branch_id = isq.branch_id', 'left')
        ->where('isq.product_id', $product_id)
        ->get()
        ->result();
}
// ========== CUSTOMER RECEIVABLES AGING ==========

/**
 * Get customer receivables aging summary
 */
public function get_customer_receivables_aging() {
    $buckets = [
        ['label' => '0–30 days', 'max_days' => 30, 'color' => '#3B6D11'],
        ['label' => '31–60 days', 'max_days' => 60, 'color' => '#EF9F27'],
        ['label' => '61–90 days', 'max_days' => 90, 'color' => '#D85A30'],
        ['label' => '90+ days', 'max_days' => 9999, 'color' => '#A32D2D']
    ];
    
    $result = [];
    $grand = 0;
    
    foreach ($buckets as $b) {
        $total = $this->db->select('SUM(balance_amount) as total')
            ->from('sales_invoices')
            ->where('payment_status !=', 'PAID')
            ->where('status', 'COMPLETED')
            ->where('DATEDIFF(CURDATE(), due_date) <=', $b['max_days'])
            ->where('DATEDIFF(CURDATE(), due_date) >', $b['max_days'] - 30)
            ->get()
            ->row();
        
        $val = (float)($total->total ?? 0);
        $result[] = [
            'label' => $b['label'],
            'pct' => 0,
            'color' => $b['color'],
            'val' => $val,
            'formatted_val' => $this->format_currency($val)
        ];
        $grand += $val;
    }
    
    foreach ($result as &$r) {
        $r['pct'] = $grand > 0 ? round(($r['val'] / $grand) * 100) : 0;
    }
    
    return $result;
}

/**
 * Get receivables aging by customer with detailed breakdown
 */
public function get_receivables_by_customer($limit = 10) {
    return $this->db->select('
            c.cus_id as customer_id,
            c.cus_name as customer_name,
            c.cus_phone as phone,
            c.cus_email as email,
            COUNT(si.id) as invoice_count,
            SUM(si.balance_amount) as total_due,
            SUM(CASE WHEN si.due_date < CURDATE() THEN si.balance_amount ELSE 0 END) as overdue_amount,
            SUM(CASE WHEN DATEDIFF(CURDATE(), si.due_date) <= 30 AND si.due_date < CURDATE() THEN si.balance_amount ELSE 0 END) as overdue_0_30,
            SUM(CASE WHEN DATEDIFF(CURDATE(), si.due_date) BETWEEN 31 AND 60 AND si.due_date < CURDATE() THEN si.balance_amount ELSE 0 END) as overdue_31_60,
            SUM(CASE WHEN DATEDIFF(CURDATE(), si.due_date) BETWEEN 61 AND 90 AND si.due_date < CURDATE() THEN si.balance_amount ELSE 0 END) as overdue_61_90,
            SUM(CASE WHEN DATEDIFF(CURDATE(), si.due_date) > 90 AND si.due_date < CURDATE() THEN si.balance_amount ELSE 0 END) as overdue_90_plus,
            MAX(si.due_date) as oldest_due_date,
            MIN(si.due_date) as newest_due_date,
            MAX(si.invoice_date) as last_invoice_date
        ')
        ->from('sales_invoices si')
        ->join('customer c', 'c.cus_id = si.customer_id', 'left')
        ->where('si.status', 'COMPLETED')
        ->where('si.payment_status !=', 'PAID')
        ->group_by('si.customer_id')
        ->order_by('total_due', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get detailed aging per customer (all invoices)
 */
public function get_customer_aging_detail($customer_id = null) {
    $this->db->select('
            si.id as invoice_id,
            si.invoice_no,
            si.invoice_date,
            si.due_date,
            si.grand_total,
            si.paid_amount,
            si.balance_amount,
            si.payment_status,
            DATEDIFF(CURDATE(), si.due_date) as days_overdue,
            CASE 
                WHEN si.payment_status = "PAID" THEN "Paid"
                WHEN si.due_date < CURDATE() AND si.balance_amount > 0 THEN "Overdue"
                WHEN si.due_date >= CURDATE() AND si.balance_amount > 0 THEN "Current"
                ELSE "Other"
            END as aging_status
        ')
        ->from('sales_invoices si')
        ->where('si.status', 'COMPLETED')
        ->where('si.payment_status !=', 'PAID');
    
    if ($customer_id) {
        $this->db->where('si.customer_id', $customer_id);
    }
    
    return $this->db->order_by('si.due_date', 'ASC')
        ->get()
        ->result();
}

/**
 * Get aging summary statistics
 */
public function get_aging_summary() {
    // Total receivables
    $total_receivables = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->get()
        ->row();
    
    // Overdue receivables
    $overdue_receivables = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->where('due_date <', date('Y-m-d'))
        ->get()
        ->row();
    
    // Current receivables (not overdue)
    $current_receivables = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->where('due_date >=', date('Y-m-d'))
        ->get()
        ->row();
    
    // Overdue by aging buckets
    $overdue_0_30 = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->where('due_date <', date('Y-m-d'))
        ->where('DATEDIFF(CURDATE(), due_date) <=', 30)
        ->get()
        ->row();
    
    $overdue_31_60 = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->where('due_date <', date('Y-m-d'))
        ->where('DATEDIFF(CURDATE(), due_date) BETWEEN 31 AND 60')
        ->get()
        ->row();
    
    $overdue_61_90 = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->where('due_date <', date('Y-m-d'))
        ->where('DATEDIFF(CURDATE(), due_date) BETWEEN 61 AND 90')
        ->get()
        ->row();
    
    $overdue_90_plus = $this->db->select('SUM(balance_amount) as total')
        ->from('sales_invoices')
        ->where('status', 'COMPLETED')
        ->where('payment_status !=', 'PAID')
        ->where('due_date <', date('Y-m-d'))
        ->where('DATEDIFF(CURDATE(), due_date) >', 90)
        ->get()
        ->row();
    
    $total = (float)($total_receivables->total ?? 0);
    $overdue = (float)($overdue_receivables->total ?? 0);
    $current = (float)($current_receivables->total ?? 0);
    
    return [
        'total_receivables' => $total,
        'formatted_total' => $this->format_currency($total),
        'overdue_receivables' => $overdue,
        'formatted_overdue' => $this->format_currency($overdue),
        'current_receivables' => $current,
        'formatted_current' => $this->format_currency($current),
        'overdue_percentage' => $total > 0 ? round(($overdue / $total) * 100) : 0,
        'overdue_0_30' => (float)($overdue_0_30->total ?? 0),
        'overdue_31_60' => (float)($overdue_31_60->total ?? 0),
        'overdue_61_90' => (float)($overdue_61_90->total ?? 0),
        'overdue_90_plus' => (float)($overdue_90_plus->total ?? 0),
        'customer_count' => $this->db->from('sales_invoices')
            ->where('status', 'COMPLETED')
            ->where('payment_status !=', 'PAID')
            ->group_by('customer_id')
            ->count_all_results(),
    ];
}

/**
 * Get top overdue customers
 */
public function get_top_overdue_customers($limit = 5) {
    return $this->db->select('
            c.cus_id,
            c.cus_name,
            c.cus_phone,
            c.cus_email,
            COUNT(si.id) as overdue_invoices,
            SUM(si.balance_amount) as total_overdue,
            MAX(si.due_date) as oldest_due_date,
            MIN(si.due_date) as newest_due_date
        ')
        ->from('sales_invoices si')
        ->join('customer c', 'c.cus_id = si.customer_id', 'left')
        ->where('si.status', 'COMPLETED')
        ->where('si.payment_status !=', 'PAID')
        ->where('si.due_date <', date('Y-m-d'))
        ->group_by('si.customer_id')
        ->order_by('total_overdue', 'DESC')
        ->limit($limit)
        ->get()
        ->result();
}

/**
 * Get aging trend over time (last 6 months)
 */
public function get_aging_trend($months = 6) {
    $labels = [];
    $total = [];
    $overdue = [];
    $current = [];
    
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i months"));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_num = date('m', strtotime($date));
        
        $labels[] = $month . ' ' . $year;
        
        // Total receivables for this month
        $total_rec = $this->db->select('SUM(balance_amount) as total')
            ->from('sales_invoices')
            ->where('status', 'COMPLETED')
            ->where('payment_status !=', 'PAID')
            ->where('MONTH(invoice_date)', $month_num)
            ->where('YEAR(invoice_date)', $year)
            ->get()
            ->row();
        
        // Overdue receivables for this month
        $overdue_rec = $this->db->select('SUM(balance_amount) as total')
            ->from('sales_invoices')
            ->where('status', 'COMPLETED')
            ->where('payment_status !=', 'PAID')
            ->where('MONTH(invoice_date)', $month_num)
            ->where('YEAR(invoice_date)', $year)
            ->where('due_date <', date('Y-m-d', strtotime($date)))
            ->get()
            ->row();
        
        $total[] = round(($total_rec->total ?? 0) / 1000);
        $overdue[] = round(($overdue_rec->total ?? 0) / 1000);
        $current[] = round((($total_rec->total ?? 0) - ($overdue_rec->total ?? 0)) / 1000);
    }
    
    return [
        'labels' => $labels,
        'total' => $total,
        'overdue' => $overdue,
        'current' => $current
    ];
}
// ========== FINANCIAL SNAPSHOT ==========

public function get_financial_snapshot() {
    $first_day = date('Y-m-01');
    $today = date('Y-m-d');
    $current_month = date('Y-m');
    
    // Revenue MTD (from completed sales invoices)
    $revenue = $this->db->select('SUM(grand_total) as total')
        ->from('sales_invoices')
        ->where('invoice_date >=', $first_day)
        ->where('status', 'COMPLETED')
        ->get()
        ->row();
    
    // Expenses MTD - From expenses table
    $expenses = $this->db->select('SUM(total_amount) as total')
        ->from('expenses')
        ->where('expense_date >=', $first_day)
        ->where('status', 'active')
        ->get()
        ->row();
    $expenses_total = (float)($expenses->total ?? 0);
    
    // Staff Salary Expenses (current month)
    $salary_expenses = $this->db->select('SUM(basic_salary) as total')
        ->from('staff_salary')
        ->where('DATE_FORMAT(effective_from, "%Y-%m") =', $current_month)
        ->where('is_active', 1)
        ->get()
        ->row();
    $expenses_total += (float)($salary_expenses->total ?? 0);
    
    // Staff Allowances (current month)
    $allowances = $this->db->select('SUM(amount) as total')
        ->from('staff_allowances')
        ->where('DATE_FORMAT(created_at, "%Y-%m") =', $current_month)
        ->get()
        ->row();
    $expenses_total += (float)($allowances->total ?? 0);
    
    // Staff Deductions (current month - these reduce expenses)
    $deductions = $this->db->select('SUM(amount) as total')
        ->from('staff_deductions')
        ->where('DATE_FORMAT(created_at, "%Y-%m") =', $current_month)
        ->get()
        ->row();
    $expenses_total -= (float)($deductions->total ?? 0);
    
    // VAT liability (from tax_liabilities table or calculate from sales)
    $vat = $this->db->select('SUM(tax_total) as total')
        ->from('sales_invoices')
        ->where('invoice_date >=', $first_day)
        ->where('status', 'COMPLETED')
        ->get()
        ->row();
    $vat_total = (float)($vat->total ?? 0);
    
    // If tax_liabilities table exists, use it instead
    if ($this->db->table_exists('tax_liabilities')) {
        $vat_liability = $this->db->select('SUM(tax_amount) as total')
            ->from('tax_liabilities')
            ->where('status', 'pending')
            ->get()
            ->row();
        if ($vat_liability && $vat_liability->total !== null) {
            $vat_total = (float)($vat_liability->total ?? 0);
        }
    }
    
    // Journal entries count
    $journal_count = 0;
    if ($this->db->table_exists('journal_entries')) {
        $journal_count = $this->db->from('journal_entries')
            ->where('DATE(entry_date) >=', $first_day)
            ->count_all_results();
    }
    
    // Calculate net profit
    $revenue_total = (float)($revenue->total ?? 0);
    $net_profit = $revenue_total - $expenses_total;
    
    return [
        'revenueMTD' => $revenue_total,
        'expensesMTD' => $expenses_total,
        'netProfit' => $net_profit,
        'doubleEntry' => 'Balanced',
        'vatLiability' => $vat_total,
        'journalCount' => (int)$journal_count,
        'formatted_revenue' => $this->format_currency($revenue_total),
        'formatted_expenses' => $this->format_currency($expenses_total),
        'formatted_profit' => $this->format_currency($net_profit),
        'formatted_vat' => $this->format_currency($vat_total),
    ];
}

/**
 * Get P&L trend data for chart (last 6 months)
 */
public function get_pl_trend($months = 6) {
    $labels = [];
    $income = [];
    $expenses = [];
    
    for ($i = $months - 1; $i >= 0; $i--) {
        $date = date('Y-m-01', strtotime("-$i months"));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $month_num = date('m', strtotime($date));
        $month_year = date('Y-m', strtotime($date));
        
        $labels[] = $month . ' ' . $year;
        
        // Income for the month
        $rev = $this->db->select('SUM(grand_total) as total')
            ->from('sales_invoices')
            ->where('YEAR(invoice_date)', $year)
            ->where('MONTH(invoice_date)', $month_num)
            ->where('status', 'COMPLETED')
            ->get()
            ->row();
        $income_total = (float)($rev->total ?? 0);
        
        // Expenses for the month
        $exp_total = 0;
        
        // From expenses table
        $exp = $this->db->select('SUM(total_amount) as total')
            ->from('expenses')
            ->where('YEAR(expense_date)', $year)
            ->where('MONTH(expense_date)', $month_num)
            ->where('status', 'active')
            ->get()
            ->row();
        $exp_total += (float)($exp->total ?? 0);
        
        // Staff salary for the month - USING YEAR and MONTH instead of DATE_FORMAT
        $salary = $this->db->select('SUM(basic_salary) as total')
            ->from('staff_salary')
            ->where('YEAR(effective_from)', $year)
            ->where('MONTH(effective_from)', $month_num)
            ->where('is_active', 1)
            ->get()
            ->row();
        $exp_total += (float)($salary->total ?? 0);
        
        // Staff allowances for the month
        $allowances = $this->db->select('SUM(amount) as total')
            ->from('staff_allowances')
            ->where('YEAR(created_at)', $year)
            ->where('MONTH(created_at)', $month_num)
            ->get()
            ->row();
        $exp_total += (float)($allowances->total ?? 0);
        
        // Staff deductions for the month
        $deductions = $this->db->select('SUM(amount) as total')
            ->from('staff_deductions')
            ->where('YEAR(created_at)', $year)
            ->where('MONTH(created_at)', $month_num)
            ->get()
            ->row();
        $exp_total -= (float)($deductions->total ?? 0);
        
        $income[] = round($income_total / 1000000, 1);
        $expenses[] = round($exp_total / 1000000, 1);
    }
    
    return [
        'labels' => $labels,
        'income' => $income,
        'expenses' => $expenses
    ];
}
/**
 * Get total staff cost for a period
 */
public function get_staff_cost($month = null, $year = null) {
    $month = $month ?? date('m');
    $year = $year ?? date('Y');
    $month_year = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
    
    // Basic salary
    $salary = $this->db->select('SUM(basic_salary) as total')
        ->from('staff_salary')
        ->where('DATE_FORMAT(effective_from, "%Y-%m") =', $month_year)
        ->where('is_active', 1)
        ->get()
        ->row();
    $total = (float)($salary->total ?? 0);
    
    // Allowances
    $allowances = $this->db->select('SUM(amount) as total')
        ->from('staff_allowances')
        ->where('DATE_FORMAT(created_at, "%Y-%m") =', $month_year)
        ->get()
        ->row();
    $total += (float)($allowances->total ?? 0);
    
    // Deductions (subtract)
    $deductions = $this->db->select('SUM(amount) as total')
        ->from('staff_deductions')
        ->where('DATE_FORMAT(created_at, "%Y-%m") =', $month_year)
        ->get()
        ->row();
    $total -= (float)($deductions->total ?? 0);
    
    return $total;
}
/**
 * Get expense breakdown by category
 */
public function get_expense_breakdown($month = null, $year = null) {
    $month = $month ?? date('m');
    $year = $year ?? date('Y');
    
    // Get expenses by category from expenses table
    $expenses = $this->db->select('
            cat_id,
            SUM(total_amount) as total
        ')
        ->from('expenses')
        ->where('MONTH(expense_date)', $month)
        ->where('YEAR(expense_date)', $year)
        ->where('status', 'active')
        ->group_by('cat_id')
        ->get()
        ->result();
    
    // Get category names
    $result = [];
    foreach ($expenses as $exp) {
        $category = $this->db->select('cat_name')
            ->from('expense_categories')
            ->where('cat_id', $exp->cat_id)
            ->get()
            ->row();
        
        $result[] = [
            'category' => $category->cat_name ?? 'Other',
            'amount' => (float)$exp->total,
            'formatted' => $this->format_currency($exp->total)
        ];
    }
    
    return $result;
}
}