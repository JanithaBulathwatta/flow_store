<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model
{
    /** Statuses counted as real sales when "VALID" is selected */
    private $valid_status = array('COMPLETED', 'HIRE PURCHASE', 'PROJECT');
    private $all_status   = array('DRAFT', 'COMPLETED', 'CANCELLED', 'RETURNED', 'QUOTATION', 'HIRE PURCHASE', 'PROJECT');

    /**
     * Applies filters to the query. Alias `si` = sales_invoices must exist.
     * $date_col lets payments filter on payment date instead of invoice date.
     */
    private function apply($f, $date_col = 'si.invoice_date')
    {
        $this->db->where($date_col . ' >=', $f['from'] . ' 00:00:00');
        $this->db->where($date_col . ' <=', $f['to'] . ' 23:59:59');

        if ($f['status'] === '' || $f['status'] === 'VALID') {
            $this->db->where_in('si.status', $this->valid_status);
        } elseif (in_array($f['status'], $this->all_status, true)) {
            $this->db->where('si.status', $f['status']);
        }

        if (in_array($f['invoice_type'], array('PROJECT', 'OTHER'), true)) {
            $this->db->where('si.invoice_type', $f['invoice_type']);
        }
        if (in_array($f['payment_status'], array('UNPAID', 'PARTIAL', 'PAID'), true)) {
            $this->db->where('si.payment_status', $f['payment_status']);
        }
    }

    public function summary($f)
    {
        $this->db->select("COUNT(si.id) AS invoices,
            COALESCE(SUM(si.subtotal),0) AS subtotal,
            COALESCE(SUM(si.line_discount_total),0) AS line_discount,
            COALESCE(SUM(si.tax_total),0) AS tax_total,
            COALESCE(SUM(si.grand_total),0) AS grand_total,
            COALESCE(SUM(si.paid_amount),0) AS paid_amount,
            COALESCE(SUM(si.balance_amount),0) AS balance_amount", false);
        $this->db->from('sales_invoices si');
        $this->apply($f);
        $r = $this->db->get()->row_array();

        foreach ($r as $k => $v) { $r[$k] = (float) $v; }
        $r['invoices'] = (int) $r['invoices'];
        return $r;
    }

    public function daily($f)
    {
        $this->db->select("DATE(si.invoice_date) AS day, COUNT(si.id) AS invoices, SUM(si.grand_total) AS total", false);
        $this->db->from('sales_invoices si');
        $this->apply($f);
        $this->db->group_by('DATE(si.invoice_date)', false);
        $this->db->order_by('day', 'ASC');
        return $this->db->get()->result_array();
    }

    public function top_products($f, $limit = 10)
    {
        $this->db->select("sii.product_id,
            MAX(COALESCE(p.name, sii.product_name)) AS name,
            SUM(sii.qty) AS qty,
            SUM(sii.free_qty) AS free_qty,
            SUM(sii.line_total) AS revenue", false);
        $this->db->from('sales_invoice_items sii');
        $this->db->join('sales_invoices si', 'si.id = sii.invoice_id');
        $this->db->join('products p', 'p.id = sii.product_id', 'left');
        $this->apply($f);
        $this->db->group_by('sii.product_id');
        $this->db->order_by('revenue', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result_array();
    }

    /** Money collected in the period, grouped by payment method */
    public function payment_methods($f)
    {
        $this->db->select("spi.payment_method, COUNT(spi.id) AS payments, SUM(spi.amount) AS total", false);
        $this->db->from('sales_payment_items spi');
        $this->db->join('sales_payments sp', 'sp.id = spi.payment_id');
        $this->db->join('sales_invoices si', 'si.id = sp.invoice_id');
        $this->apply($f, 'sp.payment_date');
        $this->db->group_by('spi.payment_method');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result_array();
    }

    public function invoices($f, $limit = 1000)
    {
        $this->db->select("si.id, si.invoice_no, si.invoice_date, si.customer_id, si.invoice_type,
            si.status, si.payment_status, si.grand_total, si.paid_amount, si.balance_amount");
        $this->db->from('sales_invoices si');
        $this->apply($f);
        $this->db->order_by('si.invoice_date', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result_array();
    }
	
	
	/* =====================================================================
     *  PROJECT EXPENSE REPORT
     * ===================================================================== */
 
    /** Applies filters to the query. Alias `e` = expenses must exist. */
    private function apply_exp($f)
    {
        $this->db->where('e.expense_date >=', $f['from']);
        $this->db->where('e.expense_date <=', $f['to']);
 
        switch ($f['status']) {
            case 'PENDING': $this->db->where('e.status', 'pending'); break;
            case 'DELETED': $this->db->where('e.status', 'deleted'); break;
            case 'BOTH':    $this->db->where_in('e.status', array('active', 'pending')); break;
            default:        $this->db->where('e.status', 'active');
        }
 
        // 'NONE' = general expenses only (no project)
        // 'ANY'  = project expenses only (any project)
        // number = one specific project
        if ($f['project_id'] === 'NONE') {
            $this->db->where('(e.project_id IS NULL OR e.project_id = 0)', null, false);
        } elseif ($f['project_id'] === 'ANY') {
            $this->db->where('e.project_id >', 0);
        } elseif ((int) $f['project_id'] > 0) {
            $this->db->where('e.project_id', (int) $f['project_id']);
        }
        if ((int) $f['family_id'] > 0) { $this->db->where('e.family_id', (int) $f['family_id']); }
        if ((int) $f['cat_id'] > 0)    { $this->db->where('e.cat_id', (int) $f['cat_id']); }
    }
 
    /* ---- lookups for the filter dropdowns ---- */
    public function project_list()
    {
        return $this->db->select('project_id, project_name')->order_by('project_name')->get('projects')->result_array();
    }
 
    public function family_list()
    {
        return $this->db->select('family_id, family_name')->order_by('family_name')->get('expense_family')->result_array();
    }
 
    public function category_list()
    {
        return $this->db->select('exp_cat_id, exp_cat_name, family_id')->order_by('exp_cat_name')->get('expense_cat')->result_array();
    }
 
    public function exp_summary($f)
    {
        $this->db->select('COUNT(e.exp_id) AS entries, COALESCE(SUM(e.total_amount),0) AS total', false);
        $this->db->from('expenses e');
        $this->apply_exp($f);
        $r = $this->db->get()->row_array();
        return array('entries' => (int) $r['entries'], 'total' => (float) $r['total']);
    }
 
    /** One row per project: budget, spent, invoiced (project sales), net and budget used % */
    public function project_overview($f)
    {
        // Spent per project (respects all expense filters)
        $this->db->select('e.project_id, COUNT(e.exp_id) AS entries, SUM(e.total_amount) AS spent', false);
        $this->db->from('expenses e');
        $this->apply_exp($f);
        $this->db->group_by('e.project_id');
        $spent = array();
        foreach ($this->db->get()->result_array() as $r) {
            $spent[(string) $r['project_id']] = $r;
        }
 
        // Invoiced per project in the same period (real sales only)
        $this->db->select('si.project_id, SUM(si.grand_total) AS invoiced', false);
        $this->db->from('sales_invoices si');
        $this->db->where('si.project_id IS NOT NULL', null, false);
        $this->db->where('si.invoice_date >=', $f['from'] . ' 00:00:00');
        $this->db->where('si.invoice_date <=', $f['to'] . ' 23:59:59');
        $this->db->where_in('si.status', $this->valid_status);
        $this->db->group_by('si.project_id');
        $invoiced = array();
        foreach ($this->db->get()->result_array() as $r) { $invoiced[(string) $r['project_id']] = (float) $r['invoiced']; }
 
        // Projects
        $this->db->select('project_id, project_name, estimated_budget, project_status');
        $this->db->from('projects');
        if ((int) $f['project_id'] > 0) {
            $this->db->where('project_id', (int) $f['project_id']);
        }
        $this->db->order_by('project_name');
 
        $out = array();
        foreach ($this->db->get()->result_array() as $p) {
            $id     = (string) $p['project_id'];
            $s      = isset($spent[$id]) ? (float) $spent[$id]['spent'] : 0;
            $budget = (float) $p['estimated_budget'];
            $inv    = isset($invoiced[$id]) ? $invoiced[$id] : 0;
            $out[] = array(
                'project_id' => $id,
                'name'       => $p['project_name'],
                'status'     => $p['project_status'],
                'budget'     => $budget,
                'entries'    => isset($spent[$id]) ? (int) $spent[$id]['entries'] : 0,
                'spent'      => $s,
                'invoiced'   => $inv,
                'net'        => $inv - $s,
                'used_pct'   => $budget > 0 ? round($s / $budget * 100, 1) : null,
            );
        }
 
        return $out;
    }
 
    public function exp_by_family($f)
    {
        $this->db->select("COALESCE(fam.family_name,'Unassigned') AS name, COALESCE(fam.color,'#6b7280') AS color,
            COUNT(e.exp_id) AS entries, SUM(e.total_amount) AS total", false);
        $this->db->from('expenses e');
        $this->db->join('expense_family fam', 'fam.family_id = e.family_id', 'left');
        $this->apply_exp($f);
        $this->db->group_by('e.family_id');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result_array();
    }
 
    public function exp_by_category($f, $limit = 10)
    {
        $this->db->select("COALESCE(c.exp_cat_name,'Unassigned') AS name, COUNT(e.exp_id) AS entries, SUM(e.total_amount) AS total", false);
        $this->db->from('expenses e');
        $this->db->join('expense_cat c', 'c.exp_cat_id = e.cat_id', 'left');
        $this->apply_exp($f);
        $this->db->group_by('e.cat_id');
        $this->db->order_by('total', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result_array();
    }
 
    /** $group = 'day' or 'month' */
    public function exp_trend($f, $group = 'day')
    {
        $fmt = $group === 'month' ? '%Y-%m' : '%Y-%m-%d';
        $this->db->select("DATE_FORMAT(e.expense_date,'" . $fmt . "') AS label, SUM(e.total_amount) AS total", false);
        $this->db->from('expenses e');
        $this->apply_exp($f);
        $this->db->group_by('label');
        $this->db->order_by('label', 'ASC');
        return $this->db->get()->result_array();
    }
 
    public function exp_rows($f, $limit = 1000)
    {
        $this->db->select("e.exp_id, e.expense_date, e.reference_no, e.note, e.qty, e.unit_amount, e.total_amount, e.status,
            p.project_name, fam.family_name, c.exp_cat_name, t.Exp_Type_name", false);
        $this->db->from('expenses e');
        $this->db->join('projects p', 'p.project_id = e.project_id', 'left');
        $this->db->join('expense_family fam', 'fam.family_id = e.family_id', 'left');
        $this->db->join('expense_cat c', 'c.exp_cat_id = e.cat_id', 'left');
        $this->db->join('expense_type t', 't.Exp_Type_id = e.type_id', 'left');
        $this->apply_exp($f);
        $this->db->order_by('e.expense_date', 'DESC');
        $this->db->order_by('e.exp_id', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result_array();
    }


	
	/* =====================================================================
     *  GENERAL EXPENSE REPORT (expenses with no project)
     *  Reuses apply_exp(); the controller always sends project_id = 'NONE'.
     * ===================================================================== */
 
    public function exp_by_type($f, $limit = 10)
    {
        $this->db->select("COALESCE(t.Exp_Type_name,'Unassigned') AS name, COUNT(e.exp_id) AS entries, SUM(e.total_amount) AS total", false);
        $this->db->from('expenses e');
        $this->db->join('expense_type t', 't.Exp_Type_id = e.type_id', 'left');
        $this->apply_exp($f);
        $this->db->group_by('e.type_id');
        $this->db->order_by('total', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result_array();
    }


}