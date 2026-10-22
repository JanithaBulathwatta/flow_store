<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'traits/BranchTrait.php';
class Stock_model extends CI_Model {
		use BranchTrait;

    public function __construct() {
		
        parent::__construct();
    }

    public function get_kpi_summary() {
    $branch_id = $this->getCurrentBranchId();
        // Total stock value (only for active products)
        $total_value = $this->db
            ->select('SUM(is.qty * is.avg_cost) as total_value')
            ->from('inventory_stock is')
            ->join('products p', 'p.id = is.product_id', 'inner')
            ->where('is.qty >', 0)
            ->where('p.status', 'active')
            ->get()
            ->row();
        
        // Low stock items (below reorder level, only active products)
        $low_stock = $this->db
            ->select('COUNT(DISTINCT is.product_id) as count')
            ->from('inventory_stock is')
            ->join('products p', 'p.id = is.product_id', 'inner')
            ->where('is.qty <=', 'p.reorder_level', FALSE)
            ->where('is.qty >', 0)
            ->where('p.status', 'active')
            ->get()
            ->row();
        
        // Zero stock items (only active products)
        $zero_stock = $this->db
            ->select('COUNT(DISTINCT is.product_id) as count')
            ->from('inventory_stock is')
            ->join('products p', 'p.id = is.product_id', 'inner')
            ->where('is.qty', 0)
            ->where('p.status', 'active')
            ->get()
            ->row();
        
        // Negative stock items (only active products)
        $negative_stock = $this->db
            ->select('COUNT(DISTINCT is.product_id) as count')
            ->from('inventory_stock is')
            ->join('products p', 'p.id = is.product_id', 'inner')
            ->where('is.qty <', 0)
            ->where('p.status', 'active')
            ->get()
            ->row();
        
        return [
            'total_value' => $total_value->total_value ?? 0,
            'low_stock_count' => $low_stock->count ?? 0,
            'zero_stock_count' => $zero_stock->count ?? 0,
            'negative_stock_count' => $negative_stock->count ?? 0
        ];
    }

    public function get_stock_report($filters = []) {
    $branch_id = $this->getCurrentBranchId();
        // Build query - show ALL products that have inventory stock  // fix typo 70,71 lines  kalhara  avg_cost to avg_cost
        $this->db->select('
            is.batch_id,
			p.id as product_id,
            p.name as product_name,
            p.product_code as sku,
            p.status as product_status,
			u.unit_id,
			u.unit_name,           
            u.unit_code,
			COALESCE(sc.name, "Uncategorized") as category,
            COALESCE(p.reorder_level, 0) as reorder_level,
            COALESCE(SUM(is.qty), 0) as total_qty,
            COALESCE(AVG(is.avg_cost), 0) as avg_cost,  
            COALESCE(SUM(is.qty * is.avg_cost), 0) as stock_value,
            COUNT(DISTINCT is.warehouse_id) as warehouse_count,
            (SELECT COUNT(*) FROM product_batches pb2 WHERE pb2.product_id = p.id AND pb2.qty > 0) as batch_count
        ');
        $this->db->from('inventory_stock is');
        $this->db->join('products p', 'p.id = is.product_id', 'inner');
		$this->db->join('units u', 'p.measure_unit = u.unit_id', 'left'); 
        $this->db->join('sub_category sc', 'sc.id = p.category_id', 'left');
    
    // ADD BRANCH FILTER
    if ($branch_id) {
        $this->db->where('is.branch_id', $branch_id);
    }
        
        // Only show active products (comment this line to see ALL products including inactive)
        $this->db->where('p.status', 'active');
        
        // Apply search filter
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('p.name', $filters['search']);
            $this->db->or_like('p.product_code', $filters['search']);
            $this->db->group_end();
        }
        
        // Apply warehouse filter ONLY if specified
        if (!empty($filters['warehouse_id'])) {
            $this->db->where('is.warehouse_id', $filters['warehouse_id']);
        }
        
        // Apply category filter
        if (!empty($filters['category'])) {
            $this->db->where('p.category_id', $filters['category']);
        }
        
        $this->db->group_by('p.id');
        $this->db->order_by('total_qty', 'DESC');
        
        // Limit to 100 products for performance
        $this->db->limit(100);
        
        // Get the query
        $query = $this->db->get();
        
        // Log the query for debugging
        log_message('debug', 'Stock Report Query: ' . $this->db->last_query());
        
        $results = $query->result();
        
        // Log raw results count
        log_message('debug', 'Stock Report Raw Results: ' . count($results) . ' records before stock type filtering');
        
        // Filter by stock type AFTER getting results (only if specified)
        if (!empty($filters['stock_type'])) {
            $results = array_filter($results, function($item) use ($filters) {
                switch ($filters['stock_type']) {
                    case 'low':
                        return $item->total_qty > 0 && $item->reorder_level > 0 && $item->total_qty <= $item->reorder_level;
                    case 'zero':
                        return $item->total_qty == 0;
                    case 'excludeZero':
                        return $item->total_qty > 0;
                    case 'negative':
                        return $item->total_qty < 0;
                    default:
                        return true;
                }
            });
            
            log_message('debug', 'Stock Report After Stock Type Filter: ' . count($results) . ' records');
        }
        
        return array_values($results);
    }

    public function get_product_batches($product_id) {
    $branch_id = $this->getCurrentBranchId();
        return $this->db
            ->select('
                pb.*,
                s.store_name as warehouse_name,
                DATEDIFF(pb.expiry_date, NOW()) as days_left,
                CASE
                    WHEN pb.expiry_date < NOW() THEN "EXPIRED"
                    WHEN DATEDIFF(pb.expiry_date, NOW()) <= 30 THEN "NEAR"
                    ELSE "VALID"
                END as expiry_status
            ')
            ->from('product_batches pb')
            ->join('stores s', 's.store_id = pb.warehouse_id', 'left')
            ->where('pb.product_id', (int)$product_id)
            ->where('pb.qty >', 0)
            ->order_by('pb.expiry_date', 'ASC')
            ->get()
            ->result();
    }
    
    public function get_product_stock($product_id) {
    $branch_id = $this->getCurrentBranchId();
        return $this->db
            ->select('
                is.*,
                s.store_name as warehouse_name
            ')
            ->from('inventory_stock is')
            ->join('stores s', 's.store_id = is.warehouse_id', 'left')
            ->where('is.product_id', (int)$product_id)
            ->get()
            ->result();
    }

    public function quick_adjustment($data) {
        $this->db->trans_start();
        
        // Generate adjustment number
        $adj_no = 'ADJ-' . date('Y') . '-' . str_pad($this->get_next_adjustment_number(), 4, '0', STR_PAD_LEFT);
        
        // Create adjustment header
        $adjustment = [
            'adjustment_no' => $adj_no,
            'warehouse_id' => $data['warehouse_id'],
            'adjustment_type' => 'CORRECTION',
            'adjustment_date' => date('Y-m-d H:i:s'),
            'remarks' => $data['remarks'],
            'created_by' => $data['created_by']
        ];
        
        $this->db->insert('stock_adjustments', $adjustment);
        $adjustment_id = $this->db->insert_id();
        
        // Get current stock
        $current_stock = $this->db
            ->select('qty')
            ->from('inventory_stock')
            ->where('product_id', $data['product_id'])
            ->where('warehouse_id', $data['warehouse_id'])
            ->get()
            ->row();
        
        $current_qty = $current_stock ? $current_stock->qty : 0;
        
        // Calculate new quantity based on mode
        $adjustment_qty = $data['adjustment_qty'];
        switch ($data['mode']) {
            case 'ADD':
                $new_qty = $current_qty + $adjustment_qty;
                break;
            case 'SUBTRACT':
                $new_qty = $current_qty - $adjustment_qty;
                break;
            case 'SET':
                $new_qty = $adjustment_qty;
                $adjustment_qty = $new_qty - $current_qty;
                break;
            default:
                $new_qty = $current_qty;
        }
        
        // Create adjustment item
        $adjustment_item = [
            'adjustment_id' => $adjustment_id,
            'product_id' => $data['product_id'],
            'current_qty' => $current_qty,
            'adjustment_qty' => $adjustment_qty,
            'new_qty' => $new_qty,
            'mode' => $data['mode']
        ];
        
        $this->db->insert('stock_adjustment_items', $adjustment_item);
        
        // Update inventory stock
        $this->update_inventory_stock($data['product_id'], $data['warehouse_id'], $new_qty);
        
        // Log the transaction
        $this->log_inventory_transaction([
            'product_id' => $data['product_id'],
            'warehouse_id' => $data['warehouse_id'],
            'transaction_type' => 'ADJUSTMENT',
            'reference_type' => 'stock_adjustments',
            'reference_id' => $adjustment_id,
            'qty' => $adjustment_qty,
            'transaction_date' => date('Y-m-d H:i:s'),
            'created_by' => $data['created_by']
        ]);
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    private function update_inventory_stock($product_id, $warehouse_id, $new_qty) {
        $exists = $this->db
            ->where('product_id', $product_id)
            ->where('warehouse_id', $warehouse_id)
            ->count_all_results('inventory_stock');
        
        if ($exists) {
            $this->db
                ->where('product_id', $product_id)
                ->where('warehouse_id', $warehouse_id)
                ->update('inventory_stock', ['qty' => $new_qty]);
        } else {
            $this->db->insert('inventory_stock', [
                'product_id' => $product_id,
                'warehouse_id' => $warehouse_id,
                'qty' => $new_qty
            ]);
        }
    }

    private function log_inventory_transaction($data) {
        $this->db->insert('inventory_transactions', $data);
    }

    private function get_next_adjustment_number() {
        $year = date('Y');
        $count = $this->db
            ->like('adjustment_no', 'ADJ-' . $year, 'after')
            ->count_all_results('stock_adjustments');
        
        return $count + 1;
    }

    public function get_categories() {
        return $this->db
            ->select('sc.id, sc.name as category')
            ->from('sub_category sc')
            ->join('products p', 'p.category_id = sc.id', 'inner')
            ->where('sc.status', 'active')
            ->where('p.status', 'active')
            ->group_by('sc.id')
            ->order_by('sc.name', 'ASC')
            ->get()
            ->result();
    }
    
    public function get_stores() {
        return $this->db
            ->select('store_id as id, store_name as name')
            ->from('stores')
            //->where('store_status', 'active')
            ->order_by('store_name', 'ASC')
            ->get()
            ->result();
    }

    public function get_product_detail($product_id) {
        $this->db->select('p.*, sc.name as category_name, b.brand_name');
        $this->db->from('products p');
        $this->db->join('sub_category sc', 'sc.id = p.sub_category_id', 'left');
        $this->db->join('brands b', 'b.brand_id = p.brand_id', 'left');
        $this->db->where('p.id', $product_id);
        $this->db->where('p.status !=', 'deleted');

        return $this->db->get()->row_array();
    }

    public function get_product_kpi($product_id) {
    $branch_id = $this->getCurrentBranchId();
        // Total stock across all warehouses
        $this->db->select('COALESCE(SUM(qty), 0) as total_stock');
        $this->db->from('inventory_stock');
        $this->db->where('product_id', $product_id);
        $stock_result = $this->db->get()->row_array();

        // Total value  (want to chnage this logic to get the actual total price of the single product -> comment by santhosh(14/05/2026))
        $this->db->select('COALESCE(SUM(is.qty * is.avg_cost), 0) as total_value');
        $this->db->from('inventory_stock is');
        $this->db->where('is.product_id', $product_id);
        $value_result = $this->db->get()->row_array();

        // Warehouse count
        $this->db->select('COUNT(DISTINCT warehouse_id) as warehouse_count');
        $this->db->from('inventory_stock');
        $this->db->where('product_id', $product_id);
        $this->db->where('qty >', 0);
        $wh_result = $this->db->get()->row_array();

        // Batch count
        $this->db->select('COUNT(*) as batch_count');
        $this->db->from('product_batches');
        $this->db->where('product_id', $product_id);
        $this->db->where('qty >', 0);
        $batch_result = $this->db->get()->row_array();

        return [
            'total_stock' => $stock_result['total_stock'],
            'total_value' => $value_result['total_value'],
            'warehouse_count' => $wh_result['warehouse_count'],
            'batch_count' => $batch_result['batch_count']
        ];
    }

    public function get_warehouse_breakdown($product_id) {
    $branch_id = $this->getCurrentBranchId();
        $this->db->select('s.store_id, s.store_name, is.qty as quantity, is.avg_cost as unit_cost, (is.qty * is.avg_cost) as stock_value');
        $this->db->from('inventory_stock is');
        $this->db->join('stores s', 's.store_id = is.warehouse_id');
        $this->db->where('is.product_id', $product_id);
        $this->db->where('s.store_status', 'active');
        $this->db->order_by('is.qty', 'DESC');

        return $this->db->get()->result_array();
    }

    public function get_product_serials($product_id) {
        // Return empty array since serial tracking table doesn't exist yet
        return [];
    }

    public function get_product_transactions($product_id, $limit = 50) {
    $branch_id = $this->getCurrentBranchId();
        $this->db->select('it.*, s.store_name as warehouse_name, pb.batch_no, u.full_name as user_name', FALSE);
        $this->db->select('CASE WHEN it.qty > 0 THEN it.qty ELSE 0 END as quantity_in', FALSE);
        $this->db->select('CASE WHEN it.qty < 0 THEN ABS(it.qty) ELSE 0 END as quantity_out', FALSE);
        $this->db->select('CONCAT(it.reference_type, "-", it.reference_id) as reference_number', FALSE);
        $this->db->from('inventory_transactions it');
        $this->db->join('stores s', 's.store_id = it.warehouse_id', 'left');
        $this->db->join('product_batches pb', 'pb.id = it.batch_id', 'left');
		$this->db->join('user u', 'u.user_id = it.created_by', 'left');
        $this->db->where('it.product_id', $product_id);
        $this->db->order_by('it.transaction_date', 'DESC');
        $this->db->order_by('it.id', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }

    public function get_transaction_kpi($filters = []) {
    $branch_id = $this->getCurrentBranchId();
        $this->db->select('
            COUNT(*) as total_transactions,
            COALESCE(SUM(CASE WHEN qty > 0 THEN qty ELSE 0 END), 0) as total_in,
            COALESCE(SUM(CASE WHEN qty < 0 THEN ABS(qty) ELSE 0 END), 0) as total_out
        ');
        $this->db->from('inventory_transactions');

        if (!empty($filters['product_id'])) {
            $this->db->where('product_id', $filters['product_id']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('transaction_date >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('transaction_date <=', $filters['date_to']);
        }
        if (!empty($filters['warehouse_id'])) {
            $this->db->where('warehouse_id', $filters['warehouse_id']);
        }
        if (!empty($filters['type'])) {
        $this->db->where('transaction_type', $filters['type']);
    }
    
    // ADD BRANCH FILTER
    if ($branch_id) {
        $this->db->where('branch_id', $branch_id);
    }

        return $this->db->get()->row_array();
    }

    public function get_transactions_with_balance($filters = []) {
    $branch_id = $this->getCurrentBranchId();
        $page = isset($filters['page']) ? (int)$filters['page'] : 1;
        $per_page = isset($filters['per_page']) ? $filters['per_page'] : 20;

        if ($per_page === 'all') {
            $per_page = 999999;
            $page = 1;
        } else {
            $per_page = (int)$per_page;
        }

        $offset = ($page - 1) * $per_page;

        // Build base query - use FALSE to prevent escaping CASE statements
        $this->db->select('it.*, s.store_name as warehouse_name, pb.batch_no, p.name as product_name, p.product_code, ur.user_id as user_id, ur.full_name as user_name', FALSE);
        $this->db->select('CASE WHEN it.qty > 0 THEN it.qty ELSE 0 END as quantity_in', FALSE);
        $this->db->select('CASE WHEN it.qty < 0 THEN ABS(it.qty) ELSE 0 END as quantity_out', FALSE);
        $this->db->select('CONCAT(it.reference_type, "-", it.reference_id) as reference_number', FALSE);
        $this->db->from('inventory_transactions it');
        $this->db->join('stores s', 's.store_id = it.warehouse_id', 'left');
        $this->db->join('product_batches pb', 'pb.id = it.batch_id', 'left');
        $this->db->join('products p', 'p.id = it.product_id', 'left');
		$this->db->join('user ur', 'ur.user_id = it.created_by', 'left');
    
		// ADD BRANCH FILTER
		if ($branch_id) {
			$this->db->where('it.branch_id', $branch_id);
		}

        // Apply filters
        if (!empty($filters['product_id'])) {
            $this->db->where('it.product_id', $filters['product_id']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('it.transaction_date >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('it.transaction_date <=', $filters['date_to']);
        }
        if (!empty($filters['warehouse_id'])) {
            $this->db->where('it.warehouse_id', $filters['warehouse_id']);
        }
        if (!empty($filters['type'])) {
            $types = is_array($filters['type']) ? $filters['type'] : [$filters['type']];
            $this->db->where_in('it.transaction_type', $types);
        }
        if (!empty($filters['batch'])) {
            $this->db->where('pb.batch_no', $filters['batch']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('it.reference_type', $filters['search']);
            $this->db->or_like('it.reference_id', $filters['search']);
            $this->db->or_like('pb.batch_no', $filters['search']);
            $this->db->group_end();
        }

        // Get total count
        $total_query = clone $this->db;
        $total = $total_query->count_all_results('', FALSE);

        // Apply pagination
        $this->db->order_by('it.transaction_date', 'DESC');
        $this->db->order_by('it.id', 'DESC');
        $this->db->limit($per_page, $offset);

        $transactions = $this->db->get()->result_array();

        // Calculate running balance
        $balance = 0;
        foreach ($transactions as &$txn) {
            $balance += $txn['qty'];
            $txn['running_balance'] = $balance;
        }

        return [
            'success' => true,
            'data' => $transactions,
            'total' => $total,
            'page' => $page,
            'per_page' => $per_page == 999999 ? 'all' : $per_page,
            'total_pages' => $per_page == 999999 ? 1 : ceil($total / $per_page)
        ];
    }

}
?>