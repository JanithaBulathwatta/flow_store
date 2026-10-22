<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DayEnd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('crm/DayEnd_model');
        $this->load->library('session');
    }
    
    public function index()
    {
        $this->load->view('header');
        $this->load->view('crm/finance/dayEnd');
        $this->load->view('footer');
    }
    
    /**
     * AJAX endpoint to get stock impact data
     * URL: /dayend/get_stock_impact
     */
    public function get_stock_impact()
    {
        $warehouse_id = $this->input->post('warehouse_id') ?: 1;
        $date = $this->input->post('date') ?: date('Y-m-d');
        
        // Get stock impact data from model
        $stock_data = $this->DayEnd_model->get_stock_impact($warehouse_id, $date);
        $total_value = $this->DayEnd_model->get_stock_total($stock_data);
        
        $response = [
            'success' => true,
            'stock' => $stock_data,
            'total_value' => $total_value
        ];
        
        echo json_encode($response);
    }
	
	/**
 * AJAX endpoint to get income impact data
  
 */
public function get_income_impact()
{
    $warehouse_id = $this->input->post('warehouse_id') ?: 1;
    $date = $this->input->post('date') ?: date('Y-m-d');
    
    // Get income impact data from model
    $income_data = $this->DayEnd_model->get_income_impact($warehouse_id, $date);
    $total_income = $this->DayEnd_model->get_income_total($income_data);
    
    $response = [
        'success' => true,
        'income' => $income_data,
        'total_income' => $total_income
    ];
    
    echo json_encode($response);
}

/**
 * AJAX endpoint to get account balances data
  
 */
public function get_account_balances()
{
    $warehouse_id = $this->input->post('warehouse_id') ?: 1;
    $date = $this->input->post('date') ?: date('Y-m-d');
    
    // Get account balances from model
    $accounts_data = $this->DayEnd_model->get_account_balances($warehouse_id, $date);
    $total_balance = $this->DayEnd_model->get_accounts_total($accounts_data);
    
    $response = [
        'success' => true,
        'accounts' => $accounts_data,
        'total_balance' => $total_balance
    ];
    
    echo json_encode($response);
}

/**
 * AJAX endpoint to get expense summary
 */
public function get_expense_summary()
{
    $warehouse_id = $this->input->post('warehouse_id') ?: 1;
    $date = $this->input->post('date') ?: date('Y-m-d');
    
    $expense_data = $this->DayEnd_model->get_expense_summary($warehouse_id, $date);
    
    $response = [
        'success' => true,
        'expenses' => $expense_data['expenses'], 
        'total' => $expense_data['total'],
        'has_data' => $expense_data['has_data']
    ];
    
    echo json_encode($response);
}

/**
 * AJAX endpoint to get pending items
 * URL: /dayend/get_pending_items
 */
public function get_pending_items()
{
    $warehouse_id = $this->input->post('warehouse_id') ?: 1;
    $date = $this->input->post('date') ?: date('Y-m-d');
    
    $pending_data = $this->DayEnd_model->get_pending_items($warehouse_id, $date);
    
    // Convert to array format expected by view
    $pending_array = [];
    foreach($pending_data as $item) {
        $pending_array[] = $item;
    }
    
    $response = [
        'success' => true,
        'pending' => $pending_array,
        'total_count' => array_sum(array_column($pending_array, 'count'))
    ];
    
    echo json_encode($response);
}

/**
 * AJAX endpoint to get reconciliation data
 * URL: /dayend/get_reconciliation
 */
public function get_reconciliation()
{
    $warehouse_id = $this->input->post('warehouse_id') ?: 1;
    $date = $this->input->post('date') ?: date('Y-m-d');
    
    $recon_data = $this->DayEnd_model->get_reconciliation($warehouse_id, $date);
    
    $response = [
        'success' => true,
        'gross_sales' => $recon_data['gross_sales'],
        'returns' => $recon_data['returns'],
        'discounts' => $recon_data['discounts'],
        'net_sales' => $recon_data['net_sales'],
        'cash_collected' => $recon_data['cash_collected'],
        'credit_forward' => $recon_data['credit_forward'],
        'total_rhs' => $recon_data['total_rhs'],
        'difference' => $recon_data['difference'],
        'is_balanced' => $recon_data['is_balanced']
    ];
    
    echo json_encode($response);
}

public function get_top_section_data()
{
    $warehouse_id = $this->input->post('warehouse_id') ?: 1;
    $date = $this->input->post('date') ?: date('Y-m-d');
    
    $response = [
        'success' => true,
        'warehouse_name' => $this->DayEnd_model->get_warehouse_name($warehouse_id),
        'warehouse_id' => $warehouse_id,
        'blocks' => $this->DayEnd_model->get_blocking_messages($warehouse_id, $date),
        'current_date' => $date
    ];
    
    echo json_encode($response);
}
}
?>