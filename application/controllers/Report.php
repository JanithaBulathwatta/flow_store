<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Report_model');

        // Use your existing admin login check here, for example:
        // if (!$this->session->userdata('logged_in')) { redirect('login'); }
    }

    /** Page: /report/sales */
    public function sales()
    {
        $data['title'] = 'Sales Report';

        // Wrap with your admin layout if you have one:
        $this->load->view('header', $data);
        $this->load->view('Reports/sales_report', $data);
        $this->load->view('footer');
    }

    /** AJAX (GET): /report/sales_data */
    public function sales_data()
    {
        $f = array(
            'from'           => $this->_date($this->input->get('from'), date('Y-m-01')),
            'to'             => $this->_date($this->input->get('to'), date('Y-m-d')),
            'status'         => strtoupper(trim((string) $this->input->get('status'))),
            'invoice_type'   => strtoupper(trim((string) $this->input->get('invoice_type'))),
            'payment_status' => strtoupper(trim((string) $this->input->get('payment_status'))),
        );

        $summary = $this->Report_model->summary($f);
        $summary['avg_invoice'] = $summary['invoices'] > 0 ? $summary['grand_total'] / $summary['invoices'] : 0;

        $out = array(
            'success'  => true,
            'summary'  => $summary,
            'daily'    => $this->Report_model->daily($f),
            'products' => $this->Report_model->top_products($f, 10),
            'payments' => $this->Report_model->payment_methods($f),
            'invoices' => $this->Report_model->invoices($f, 1000),
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($out));
    }

    private function _date($value, $default)
    {
        $value = trim((string) $value);
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) ? $value : $default;
    }
	
	
	
    /* =====================================================================
     *  PROJECT EXPENSE REPORT
     * ===================================================================== */
 
    /** Page: /report/project_expenses */
    public function project_expenses()
    {
        $data['title']      = 'Project Expense Report';
        $data['projects']   = $this->Report_model->project_list();
        $data['families']   = $this->Report_model->family_list();
        $data['categories'] = $this->Report_model->category_list();
 
        $this->load->view('header', $data);
        $this->load->view('Reports/project_expense_report', $data);
        $this->load->view('footer');
    }
 
    /** AJAX (GET): /report/project_expenses_data */
    public function project_expenses_data()
    {
        $from = $this->_date($this->input->get('from'), date('Y-m-01'));
        $to   = $this->_date($this->input->get('to'), date('Y-m-d'));
        if ($from > $to) { $tmp = $from; $from = $to; $to = $tmp; }
 
        // One project, or 'ANY' = every expense that has a project_id
        $project = (int) $this->input->get('project_id');
 
        $f = array(
            'from'       => $from,
            'to'         => $to,
            'project_id' => $project > 0 ? $project : 'ANY',
            'family_id'  => (int) $this->input->get('family_id'),
            'cat_id'     => (int) $this->input->get('cat_id'),
            'status'     => strtoupper(trim((string) $this->input->get('status'))),
        );
 
        // Daily bars for short ranges, monthly bars for long ones
        $days  = (strtotime($to) - strtotime($from)) / 86400;
        $group = $days > 62 ? 'month' : 'day';
 
        $projects = $this->Report_model->project_overview($f);
        $budget = 0; $invoiced = 0;
        foreach ($projects as $p) { $budget += $p['budget']; $invoiced += $p['invoiced']; }
 
        $summary = $this->Report_model->exp_summary($f);
        $summary['average']  = $summary['entries'] > 0 ? $summary['total'] / $summary['entries'] : 0;
        $summary['budget']   = $budget;
        $summary['invoiced'] = $invoiced;
        $summary['net']      = $invoiced - $summary['total'];
 
        $out = array(
            'success'    => true,
            'summary'    => $summary,
            'projects'   => $projects,
            'families'   => $this->Report_model->exp_by_family($f),
            'categories' => $this->Report_model->exp_by_category($f, 10),
            'trend'      => $this->Report_model->exp_trend($f, $group),
            'rows'       => $this->Report_model->exp_rows($f, 1000),
        );
 
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($out));
    }
 

	
	
	/* =====================================================================
     *  GENERAL EXPENSE REPORT (expenses that are not linked to a project)
     * ===================================================================== */
 
    /** Page: /report/general_expenses */
    public function general_expenses()
    {
        $data['title']      = 'General Expense Report';
        $data['families']   = $this->Report_model->family_list();
        $data['categories'] = $this->Report_model->category_list();
 
        $this->load->view('header', $data);
        $this->load->view('Reports/general_expense_report', $data);
        $this->load->view('footer');
    }
	
    /** AJAX (GET): /report/general_expenses_data */
    public function general_expenses_data()
    {
        $from = $this->_date($this->input->get('from'), date('Y-m-01'));
        $to   = $this->_date($this->input->get('to'), date('Y-m-d'));
        if ($from > $to) { $tmp = $from; $from = $to; $to = $tmp; }
 
        $f = array(
            'from'       => $from,
            'to'         => $to,
            'project_id' => 'NONE',   // general expenses only: project_id IS NULL
            'family_id'  => (int) $this->input->get('family_id'),
            'cat_id'     => (int) $this->input->get('cat_id'),
            'status'     => strtoupper(trim((string) $this->input->get('status'))),
        );
 
        // Previous period of the same length, for the comparison card
        $days    = (int) round((strtotime($to) - strtotime($from)) / 86400) + 1;
        $prev_to = date('Y-m-d', strtotime($from . ' -1 day'));
        $fp      = $f;
        $fp['to']   = $prev_to;
        $fp['from'] = date('Y-m-d', strtotime($prev_to . ' -' . ($days - 1) . ' days'));
 
        $summary = $this->Report_model->exp_summary($f);
        $prev    = $this->Report_model->exp_summary($fp);
        $summary['average']    = $summary['entries'] > 0 ? $summary['total'] / $summary['entries'] : 0;
        $summary['prev_total'] = $prev['total'];
        $summary['change_pct'] = $prev['total'] > 0 ? round(($summary['total'] - $prev['total']) / $prev['total'] * 100, 1) : null;
 
        $group = $days > 62 ? 'month' : 'day';
 
        $out = array(
            'success'    => true,
            'summary'    => $summary,
            'families'   => $this->Report_model->exp_by_family($f),
            'categories' => $this->Report_model->exp_by_category($f, 10),
            'types'      => $this->Report_model->exp_by_type($f, 10),
            'trend'      => $this->Report_model->exp_trend($f, $group),
            'rows'       => $this->Report_model->exp_rows($f, 1000),
        );
 
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($out));
    }

	

}