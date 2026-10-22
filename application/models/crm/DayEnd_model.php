<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DayEnd_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_stock_impact($warehouse_id, $date)
    {
        // 1. GRN  --
        $grn = $this->db->select('COUNT(*) as count, COALESCE(SUM(grand_total), 0) as value')
			->from('grn')
			->where('DATE(grn_date)', $date)
			->where('warehouse_id', $warehouse_id)
			->where('status', 'approved')
			->get()
			->row();
        
        // 2. SALES --- issues wanna show seperately
        $sales = $this->db->select('COUNT(*) as count, COALESCE(SUM(grand_total), 0) as value')
			->from('sales_invoices')
			->where('DATE(invoice_date)', $date)
			->where('warehouse_id', $warehouse_id)
			->where('status', 'COMPLETED')
			->get()
			->row();
			
	    // 3. ISSUES --- (from stock_activities - separate from sales)
		$issues = $this->db->select('
				COUNT(DISTINCT sa.st_activity_id) as count, 
				COALESCE(SUM(sti.qty * sti.unit_cost), 0) as value
			')
			->from('stock_activities sa')
			->join('stock_transaction_items sti', 'sti.fk_st_activity_id = sa.st_activity_id', 'left')
			->where('DATE(sa.st_act_date)', $date)
			->where('sa.store_id', $warehouse_id)
			->where('sa.act_type', 'issue')
			->where('sa.status', 'approved')
			->get()
			->row();
        
        // 4. TRANSFERS IN --- (from GRN with ref_type = 'trans IN')
		$transfers_in = $this->db->select('COUNT(*) as count, COALESCE(SUM(grand_total), 0) as value')
			->from('grn')
			->where('DATE(grn_date)', $date)
			->where('warehouse_id', $warehouse_id)
			->where('status', 'approved')
			->where('ref_type', 'trans IN')
			->get()
			->row();
        
        // 5. TRANSFERS OUT --- (from stock_activities with act_type = 'transfer')
		$transfers_out = $this->db->select('
				COUNT(DISTINCT sa.st_activity_id) as count, 
				COALESCE(SUM(sti.qty * sti.unit_cost), 0) as value
			')
			->from('stock_activities sa')
			->join('stock_transaction_items sti', 'sti.fk_st_activity_id = sa.st_activity_id', 'left')
			->where('DATE(sa.st_act_date)', $date)
			->where('sa.store_id', $warehouse_id)
			->where('sa.act_type', 'transfer')
			->where('sa.status', 'approved')
			->get()
			->row();
        
         // 5. ADJUSTMENTS - REAL VALUE using last_purchase_price (later)
			$adjustments = $this->db->select('
					COUNT(DISTINCT sa.id) as count,
					COALESCE(SUM(sai.adjustment_qty * p.last_purchase_price), 0) as value
				')
				->from('stock_adjustments sa')
				->join('stock_adjustment_items sai', 'sai.adjustment_id = sa.id', 'left')
				->join('products p', 'p.id = sai.product_id', 'left')
				->where('DATE(sa.adjustment_date)', $date)
				->where('sa.warehouse_id', $warehouse_id)
				->where('sa.status', 'approved')
				->get()
				->row();
        
        // Build response with REAL counts + MOCK values
        return [
            'grn' => [
                'label' => 'GRN Received',
                'count' => (int)$grn->count,
                'value' => (float)$grn->value,
                'color' => 'var(--success)'
            ],
            'transfers_in' => [
				'label' => 'Transfers In',
				'count' => (int)$transfers_in->count,
				'value' => (float)$transfers_in->value,
				'color' => 'var(--info)'
			],
            'transfers_out' => [
				'label' => 'Transfers Out',
				'count' => (int)$transfers_out->count,
				'value' => (float)$transfers_out->value,
				'color' => 'var(--info)'
			],
            'sales' => [
                'label' => 'Sales',
                'count' => (int)$sales->count,
                'value' => (float)$sales->value,
                'color' => 'var(--primary)'
            ],
			'issues' => [
				'label' => 'Issues',
				'count' => (int)$issues->count,
				'value' => (float)$issues->value,
				'color' => 'var(--warning)'
			],
            'adjustments' => [
				'label' => 'Adjustments',
				'count' => (int)$adjustments->count,
				'value' => (float)$adjustments->value,   
				'color' => 'var(--warning)'
             ]
        ];
    }
    
    public function get_stock_total($stock_data)
	{
		// Stock IN (positive values)
		$stock_in = $stock_data['grn']['value'] + $stock_data['transfers_in']['value'];
		
		// Stock OUT (negative or should be subtracted)
		$stock_out = $stock_data['sales']['value'] +      // Sales reduces stock
		             $stock_data['issues']['value'] +     // Issues reduces stock
					 abs($stock_data['transfers_out']['value']) +  // Transfer Out reduces stock
					 abs($stock_data['adjustments']['value']);     // Adjustments reduce stock
		
		// Net Stock Value = Stock IN - Stock OUT
		$net_stock = $stock_in - $stock_out;
		
		return $net_stock;
	}
	
	/**
 * Get Income Impact data for today
 */
public function get_income_impact($warehouse_id, $date)
{
    // 1. GROSS SALES (Today's completed sales)   --
    $gross_sales = $this->db->select('COALESCE(SUM(grand_total), 0) as value, COUNT(*) as count')
        ->from('sales_invoices')
        ->where('DATE(invoice_date)', $date)
        ->where('warehouse_id', $warehouse_id)
        ->where('status', 'COMPLETED')
        ->get()
        ->row();
    
    // 2. RETURNS (Today's returned sales)    --
    $returns = $this->db->select('COALESCE(SUM(grand_total), 0) as value, COUNT(*) as count')
        ->from('sales_invoices')
        ->where('DATE(invoice_date)', $date)
        ->where('warehouse_id', $warehouse_id)
        ->where('status', 'RETURNED')
        ->get()
        ->row();
    
    // 3. DISCOUNTS GIVEN (Today's completed sales discounts)   --
    $discounts = $this->db->select('COALESCE(SUM(bill_discount_value), 0) as value')
        ->from('sales_invoices')
        ->where('DATE(invoice_date)', $date)
        ->where('warehouse_id', $warehouse_id)
        ->where('status', 'COMPLETED')
        ->get()
        ->row();
    
    // 4. PREVIOUS DUE (Unpaid invoices from BEFORE today)  --
    $previous_due = $this->db->select('COALESCE(SUM(balance_amount), 0) as value')
        ->from('sales_invoices')
        ->where('DATE(invoice_date) <', $date)
        ->where('warehouse_id', $warehouse_id)
        ->where('status', 'COMPLETED')
        ->get()
        ->row();
    
    // 5. CASH COLLECTION TODAY (Payments received today)  --
    $cash_collection = $this->db->select('COALESCE(SUM(amount), 0) as value')
		->from('sales_payment_items')
		->where('payment_method', 'CASH')
		->where('DATE(created_at)', $date)  // or join with sales_payments
		->get()
		->row();
    
    // 6. CREDIT CARRY-FORWARD (All unpaid balances - any date, including today)  --
	$credit_forward = $this->db->select('COALESCE(SUM(balance_amount), 0) as value')
		->from('sales_invoices')
		->where('DATE(invoice_date) <=', $date)  // ← TODAY and BEFORE
		->where('warehouse_id', $warehouse_id)
		->where('status', 'COMPLETED')
		->get()
		->row();
    
    // Build response
    return [
        'gross_sales' => [
            'label' => 'Gross Sales',
            'count' => (int)$gross_sales->count,
            'value' => (float)$gross_sales->value,
            'color' => 'var(--success)'
        ],
        'returns' => [
            'label' => 'Returns',
            'count' => (int)$returns->count,
            'value' => -(float)$returns->value,  // Negative value
            'color' => 'var(--danger)'
        ],
        'discounts' => [
            'label' => 'Discounts Given',
            'count' => null,
            'value' => -(float)$discounts->value,  // Negative value
            'color' => 'var(--warning)'
        ],
        'previous_due' => [
            'label' => 'Previous Due',
            'count' => null,
            'value' => (float)$previous_due->value,
            'color' => 'var(--purple)'
        ],
        'cash_collection' => [
            'label' => 'Cash Collection Today',
            'count' => null,
            'value' => (float)$cash_collection->value,
            'color' => 'var(--success)'
        ],
        'credit_forward' => [
            'label' => 'Credit Carry-forward',
            'count' => null,
            'value' => (float)$credit_forward->value,
            'color' => 'var(--purple)'
        ]
    ];
}

/**
 * Get Net Income Position (total of all values)
 */
public function get_income_total($income_data)
{
    $total = 0;
    $items = [$income_data['gross_sales'], $income_data['returns'], $income_data['discounts'], 
              $income_data['previous_due'], $income_data['cash_collection'], $income_data['credit_forward']];
    
    foreach($items as $item) {
        $total += $item['value'];
    }
    return $total;
}

/**
 * Get Account Balances with REAL collections from sales_payment_items
 * Dynamic - calculates actual cash_in by payment method
 */
public function get_account_balances($warehouse_id, $date)
{
    // Get today's collections by payment method from sales_payment_items
    $this->db->select('spi.payment_method, COALESCE(SUM(spi.amount), 0) as total')
        ->from('sales_payment_items spi')
        ->join('sales_payments sp', 'sp.id = spi.payment_id')
        ->join('sales_invoices si', 'si.id = sp.invoice_id')
        ->where('DATE(sp.payment_date)', $date)
        ->where('si.warehouse_id', $warehouse_id)
        ->group_by('spi.payment_method');
    
    $collections = $this->db->get()->result();
    
    // Store collections by payment method
    $cash_in_by_method = [];
    $total_cash_in = 0;
    foreach($collections as $col) {
        $cash_in_by_method[$col->payment_method] = (float)$col->total;
        $total_cash_in += (float)$col->total;
    }
    
    // Dynamic accounts based on payment methods that have collections
    $accounts = [];
    
    // Define account configurations
    $account_configs = [
        'CASH' => [
            'name' => 'Main Cash',
            'type' => 'Cash',
            'icon' => 'fa-money-bill-wave',
            'color' => 'var(--success)',
            'sort' => 1
        ],
        'CARD' => [
            'name' => 'POS / Card',
            'type' => 'Card',
            'icon' => 'fa-credit-card',
            'color' => 'var(--purple)',
            'sort' => 2
        ],
        'BANK' => [
            'name' => 'Bank Transfer',
            'type' => 'Bank',
            'icon' => 'fa-landmark',
            'color' => 'var(--primary)',
            'sort' => 3
        ],
        'CHEQUE' => [
            'name' => 'Cheque',
            'type' => 'Cheque',
            'icon' => 'fa-file-invoice',
            'color' => 'var(--warning)',
            'sort' => 4
        ],
        'CREDIT' => [
            'name' => 'Credit Payment',
            'type' => 'Credit',
            'icon' => 'fa-credit-card',
            'color' => 'var(--info)',
            'sort' => 5
        ]
    ];
    
    // Build accounts with REAL cash_in
    foreach($account_configs as $method => $config) {
        $cash_in = isset($cash_in_by_method[$method]) ? $cash_in_by_method[$method] : 0;
        
        // Only show accounts that have collections OR you can show all
        // For now, showing all accounts (including zero collections)
        $accounts[] = [
            'id' => $method,
            'name' => $config['name'],
            'type' => $config['type'],
            'icon' => $config['icon'],
            'color' => $config['color'],
            'opening' => 0,  // You can set this from an opening balance table later
            'cash_in' => $cash_in,
            'cash_out' => 0,  // Can add expense payments later
            'expected' => $cash_in,  // Since opening is 0, expected = cash_in
            'sort' => $config['sort']
        ];
    }
    
    // Sort by sort order
    usort($accounts, function($a, $b) {
        return $a['sort'] - $b['sort'];
    });
    
    return $accounts;
}

/**
 * Get total of all account expected balances
 */
public function get_accounts_total($accounts_data)
{
    $total = 0;
    foreach($accounts_data as $acc) {
        $total += $acc['expected'];
    }
    return $total;
}

/**
 * Get Expense Summary for today - Show ALL expense categories
 */
public function get_expense_summary($warehouse_id, $date)
{
    // Get ALL expense categories that have expenses today
    $all_expenses = $this->db->select('
            ec.exp_cat_name as category_name,
            COALESCE(SUM(e.total_amount), 0) as amount
        ')
        ->from('expenses e')
        ->join('expense_cat ec', 'ec.exp_cat_id = e.cat_id')
        ->where('DATE(e.expense_date)', $date)
         
        ->where('e.status', 'active')
        ->group_by('e.cat_id')
        ->order_by('amount', 'DESC')
        ->get()
        ->result();
    
    // Calculate total of all expenses
    $total_expenses = 0;
    $expenses_list = [];
    
    foreach($all_expenses as $exp) {
        $expenses_list[] = [
            'cat' => $exp->category_name,
            'amount' => (float)$exp->amount
        ];
        $total_expenses += (float)$exp->amount;
    }
    
    return [
        'expenses' => $expenses_list,
        'total' => $total_expenses,
        'has_data' => $total_expenses > 0
    ];
}

/**
 * Get Pending Items for the day
 */
public function get_pending_items($warehouse_id, $date)
{
    $pending_items = [];
    
    // 1. UNAPPROVED GRN - REAL data   --
    $unapproved_grn = $this->db->select('COUNT(*) as count, COALESCE(SUM(grand_total), 0) as value')
		->from('grn')
		->where('DATE(grn_date)', $date)  // ← ADD THIS LINE
		->where('warehouse_id', $warehouse_id)
		->where('status NOT IN ("approved", "rejected", "cancelled")', NULL, FALSE)
		->get()
		->row();
    
    if($unapproved_grn->count > 0) {
        $pending_items['unapproved_grn'] = [
            'cat' => 'Unapproved GRN',
            'count' => (int)$unapproved_grn->count,
            'note' => 'Rs. ' . number_format($unapproved_grn->value, 2) . ' pending approval',
            'color' => 'var(--danger)'
        ];
    }
    
    // 2. OVERDUE INVOICES - REAL    --
    $overdue = $this->db->select('COUNT(*) as count, COALESCE(SUM(balance_amount), 0) as value')
        ->from('sales_invoices')
        ->where('warehouse_id', $warehouse_id)
        ->where('due_date <', date('Y-m-d'))
        ->where('payment_status !=', 'PAID')
        ->where('status', 'COMPLETED')
        ->get()
        ->row();
    
    if($overdue->count > 0) {
        $pending_items['overdue_invoices'] = [
            'cat' => 'Overdue Invoices',
            'count' => (int)$overdue->count,
            'note' => 'Rs. ' . number_format($overdue->value, 2) . ' overdue',
            'color' => 'var(--warning)'
        ];
    }
    
    // 3. NEGATIVE STOCK ITEMS - REAL data from inventory_stock
    $negative_stock = $this->db->select('COUNT(*) as count')
        ->from('inventory_stock')
        ->where('warehouse_id', $warehouse_id)
        ->where('qty <', 0)
        ->get()
        ->row();
    
    if($negative_stock->count > 0) {
        // Get product names for negative stock items
        $neg_products = $this->db->select('p.name, s.qty')
            ->from('inventory_stock s')
            ->join('products p', 'p.id = s.product_id')
            ->where('s.warehouse_id', $warehouse_id)
            ->where('s.qty <', 0)
            ->limit(3)
            ->get()
            ->result();
        
        $product_list = [];
        foreach($neg_products as $p) {
            $product_list[] = $p->name . ' (qty: ' . $p->qty . ')';
        }
        $note = implode(', ', $product_list);
        if($negative_stock->count > 3) {
            $note .= ' and ' . ($negative_stock->count - 3) . ' more';
        }
        
        $pending_items['negative_stock'] = [
            'cat' => 'Negative Stock Items',
            'count' => (int)$negative_stock->count,
            'note' => $note,
            'color' => 'var(--danger)'
        ];
    }
    
    // 4. UNCLEARED CHEQUES - From sales_payment_items
    $uncleared = $this->db->select('COUNT(*) as count, COALESCE(SUM(amount), 0) as value')
        ->from('sales_payment_items')
        ->where('payment_method', 'CHEQUE')
        ->where('DATE(created_at)', $date)
        ->get()
        ->row();
    
    if($uncleared->count > 0) {
        // Get cheque numbers for the note
        $cheque_numbers = $this->db->select('cheque_no, amount')
            ->from('sales_payment_items')
            ->where('payment_method', 'CHEQUE')
            ->where('DATE(created_at)', $date)
            ->where('cheque_no IS NOT NULL')
            ->where('cheque_no !=', '')
            ->limit(3)
            ->get()
            ->result();
        
        $cheque_list = [];
        foreach($cheque_numbers as $ch) {
            $cheque_list[] = $ch->cheque_no . ' (Rs. ' . number_format($ch->amount, 2) . ')';
        }
        
        $note = 'Rs. ' . number_format($uncleared->value, 2) . ' pending bank clearance';
        if(!empty($cheque_list)) {
            $note .= ' - Cheques: ' . implode(', ', $cheque_list);
            if($uncleared->count > 3) {
                $note .= ' and ' . ($uncleared->count - 3) . ' more';
            }
        }
        
        $pending_items['uncleared_cheques'] = [
            'cat' => 'Uncleared Cheques',
            'count' => (int)$uncleared->count,
            'note' => $note,
            'color' => 'var(--warning)'
        ];
    }
    
    return $pending_items;
}

/**
 * Get Reconciliation data for today
 */
public function get_reconciliation($warehouse_id, $date)
{
    // Get Income Impact data which already has all required calculations
    $income_data = $this->get_income_impact($warehouse_id, $date);
    
    // Extract values from Income Impact
    $gross_sales = $income_data['gross_sales']['value'];
    $returns = abs($income_data['returns']['value']);  // Already negative, get absolute
    $discounts = abs($income_data['discounts']['value']);  // Already negative, get absolute
    $cash_collected = $income_data['cash_collection']['value'];
    $credit_forward = $income_data['credit_forward']['value'];
    
    // Calculate LHS and RHS
    $lhs = $gross_sales - $returns - $discounts;
    $rhs = $cash_collected + $credit_forward;
    $diff = $lhs - $rhs;
    $is_balanced = abs($diff) < 1;
    
    return [
        'gross_sales' => $gross_sales,
        'returns' => $returns,
        'discounts' => $discounts,
        'net_sales' => $lhs,
        'cash_collected' => $cash_collected,
        'credit_forward' => $credit_forward,
        'total_rhs' => $rhs,
        'difference' => $diff,
        'is_balanced' => $is_balanced
    ];
}

/**
 * Get warehouse/store name from stores table
 */
public function get_warehouse_name($warehouse_id)
{
    $result = $this->db->select('store_name')
        ->from('stores')
        ->where('store_id', $warehouse_id)
        ->get()
        ->row();
    
    return $result ? $result->store_name : 'Store #' . $warehouse_id;
}

/**
 * Get dynamic blocking messages
 */
public function get_blocking_messages($warehouse_id, $date)
{
    $blocks = [];
    
    // Check for unapproved GRN (today only)
    $unapproved = $this->db->select('COUNT(*) as count')
        ->from('grn')
        ->where('DATE(grn_date)', $date)
        ->where('warehouse_id', $warehouse_id)
        ->where('status NOT IN ("approved", "rejected", "cancelled")', NULL, FALSE)
        ->get()
        ->row();
    
    if($unapproved->count > 0) {
        $blocks[] = [
            'msg' => $unapproved->count . ' Unapproved GRN(s) pending. Review before closing.',
            'type' => 'warn'
        ];
    }
    
    // Check for negative stock
    $neg_stock = $this->db->select('COUNT(*) as count')
        ->from('inventory_stock')
        ->where('warehouse_id', $warehouse_id)
        ->where('qty <', 0)
        ->get()
        ->row();
    
    if($neg_stock->count > 0) {
        $blocks[] = [
            'msg' => $neg_stock->count . ' product(s) with negative stock. Resolve before closing.',
            'type' => 'warn'
        ];
    }
    
    // If no blocks, show success
    if(empty($blocks)) {
        $blocks[] = [
            'msg' => 'All checks passed. Ready to close the period.',
            'type' => 'ok'
        ];
    }
    
    return $blocks;
}


/**
 * Get all active stores for warehouse selector
 */
public function get_all_stores()
{
    $stores = $this->db->select('store_id, store_name')
        ->from('stores')
        ->where('store_status', 'active')  // or whatever status column name
        ->order_by('store_name', 'ASC')
        ->get()
        ->result();
    
    return $stores;
}

}
?>