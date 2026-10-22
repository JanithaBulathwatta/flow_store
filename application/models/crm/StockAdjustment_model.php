<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 19/3/2026

class StockAdjustment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get inventory stock with product details
     */
    public function get_inventory_stock($warehouse_id = null)
{
    $this->db->select('
        inventory_stock.id,
        inventory_stock.product_id,
        inventory_stock.warehouse_id,
        inventory_stock.batch_id,
        inventory_stock.qty as systemQty,
        product_batches.avg_cost as avg_cost,
        inventory_stock.updated_at,
        products.name as product_name,
        products.product_code as sku,
        products.description,
        products.reorder_level,
        products.status,
        products.brand_id,
        products.sub_category_id,
        sub_category.name as category,
        brands.brand_name as brand_name,
        brands.brand_code as brand_code,
        stores.store_id,
        stores.store_name as warehouse_name,
        stores.store_address as warehouse_address,
        stores.store_phone as warehouse_phone,
        product_batches.batch_no,
        product_batches.expiry_date,
        DATEDIFF(product_batches.expiry_date, CURDATE()) as days_left
    ');
    
    $this->db->from('inventory_stock');
    $this->db->join('products', 'products.id = inventory_stock.product_id', 'left');
    $this->db->join('brands', 'brands.brand_id = products.brand_id', 'left');
    $this->db->join('sub_category', 'sub_category.id = products.sub_category_id', 'left');
    $this->db->join('stores', 'stores.store_id = inventory_stock.warehouse_id', 'left');
    $this->db->join('product_batches', 'product_batches.id = inventory_stock.batch_id', 'left');
    
    if ($warehouse_id) {
        $this->db->where('inventory_stock.warehouse_id', $warehouse_id);
    }
    
    // Only show active products
    $this->db->where('products.status', 'active');
    
    // Order by product name and warehouse
    $this->db->order_by('products.name', 'ASC');
    $this->db->order_by('stores.store_name', 'ASC');
    $this->db->order_by('product_batches.expiry_date', 'ASC');
    
    $query = $this->db->get();
    return $query->result_array();
}



    /**
     * Get inventory stock summary
     */
    public function get_stock_summary()
   {
    $this->db->select('
        COUNT(*) as total_lines,
        SUM(inventory_stock.qty) as total_quantity,
        SUM(inventory_stock.qty * product_batches.avg_cost) as total_value,
        COUNT(DISTINCT inventory_stock.product_id) as unique_products,
        COUNT(DISTINCT inventory_stock.warehouse_id) as warehouses
    ');
    $this->db->from('inventory_stock');
    $this->db->join('product_batches', 'product_batches.id = inventory_stock.batch_id', 'left');
    $query = $this->db->get();
    return $query->row_array();
    }

    /**
     * Get categories - from sub_categories table if exists
     */
    public function get_categories()
    {
        // Check if sub_categories table exists
        if ($this->db->table_exists('sub_category')) {
            $this->db->select('id, name as category');
            $this->db->from('sub_category');
            $this->db->where('status', 'active');
            $this->db->order_by('name', 'ASC');
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
        }
        
        // Fallback: return empty array
        return array();
    }

    /**
     * Get brands from brands table
     */
    public function get_brands()
    {
        // Check if brands table exists
        if ($this->db->table_exists('brands')) {
            $this->db->select('brand_id as id, brand_name as brand, brand_code');
            $this->db->from('brands');
            $this->db->where('brand_status', 'active');
            $this->db->order_by('brand_name', 'ASC');
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
        }
        
        // Fallback: return empty array
        return array();
    }

     


    /**
     * Get product details by ID
     */
    public function get_product($product_id)
    {
        $this->db->select('
            products.*,
            brands.brand_name,
            brands.brand_code
        ');
        $this->db->from('products');
        $this->db->join('brands', 'brands.brand_id = products.brand_id', 'left');
        $this->db->where('products.id', $product_id);
        
        $query = $this->db->get();
        return $query->row_array();
    }
	
	/**
 * Create new stock adjustment header
 */
public function create_adjustment($adjustment_no, $warehouse_id, $notes)
    {
        $data = array(
            'adjustment_no' => $adjustment_no,
            'warehouse_id' => $warehouse_id,
            'adjustment_type' => 'STOCK_COUNT',
            'adjustment_date' => date('Y-m-d H:i:s'),
            'remarks' => $notes,
            'created_by' => $this->session->userdata('user_id') ?: 1,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('stock_adjustments', $data);
        return $this->db->insert_id();
    }

    /**
     * Save adjustment items
     */
    public function save_adjustment_items($adjustment_id, $items)
    {
        $data = array();
        foreach ($items as $item) {
            $data[] = array(
                'adjustment_id' => $adjustment_id,
                'product_id' => $item['product_id'],
                'batch_id' => $item['batch_id'],
                'current_qty' => $item['current_qty'],
                'adjustment_qty' => $item['adjustment_qty'],
                'new_qty' => $item['new_qty'],
                'mode' => $this->get_adjustment_mode($item['adjustment_qty']),
                'created_at' => date('Y-m-d H:i:s')
            );
        }
        
        if (!empty($data)) {
            return $this->db->insert_batch('stock_adjustment_items', $data);
        }
        return false;
    }

    /**
     * Determine adjustment mode based on quantity change
     */
    private function get_adjustment_mode($adjustment_qty)
    {
        if ($adjustment_qty > 0) {
            return 'ADD';
        } elseif ($adjustment_qty < 0) {
            return 'SUBTRACT';
        } else {
            return 'SET';
        }
    }

    /**
     * Update inventory stock and log all changes
     */
    public function update_inventory_stock($adjustment_id)
    {
        error_log("=== update_inventory_stock STARTED for ID: " . $adjustment_id);
        
        $this->db->trans_start();
        
        try {
            // Get adjustment items
            $items = $this->db->select('
                    sai.product_id, 
                    sai.current_qty, 
                    sai.adjustment_qty, 
                    sai.new_qty, 
                    sai.batch_id,
                    sa.warehouse_id
                ')
                ->from('stock_adjustment_items sai')
                ->join('stock_adjustments sa', 'sa.id = sai.adjustment_id')
                ->where('sai.adjustment_id', $adjustment_id)
                ->get()
                ->result_array();
            
            error_log("Found " . count($items) . " items to process");
            
            if (empty($items)) {
                error_log("ERROR: No items found for adjustment ID: " . $adjustment_id);
                $this->db->trans_rollback();
                return false;
            }
            
            $user_id = $this->session->userdata('user_id') ?: 1;
            $items_processed = 0;
            
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                $warehouse_id = $item['warehouse_id'];
                $batch_id = $item['batch_id'];
                $old_qty = (float)$item['current_qty'];
                $new_qty = (float)$item['new_qty'];
                $adjustment_qty = (float)$item['adjustment_qty'];
                
                error_log("Processing Product ID: $product_id, Warehouse: $warehouse_id, Batch: $batch_id");
                error_log("Old: $old_qty, New: $new_qty, Adj: $adjustment_qty");
                
                // Get current avg_cost from product_batches
                $avg_cost = 0;
                if ($batch_id) {
                  $batch = $this->db->select('avg_cost')
                     ->where('id', $batch_id)
                     ->get('product_batches')
                     ->row();
                  $avg_cost = $batch ? (float)$batch->avg_cost : 0;
                }
                
                // 1. UPDATE inventory_stock
                $this->db->set('qty', $new_qty);
                $this->db->set('updated_at', date('Y-m-d H:i:s'));
                $this->db->where('product_id', $product_id);
                $this->db->where('warehouse_id', $warehouse_id);
                $this->db->where('batch_id', $batch_id);
                $stock_updated = $this->db->update('inventory_stock');
                error_log("inventory_stock updated: " . ($stock_updated ? 'YES' : 'NO'));
                
                // 2. UPDATE product_batches (if batch exists)
                if ($batch_id) {
                    $this->db->set('qty', $new_qty);
                    $this->db->set('updated_at', date('Y-m-d H:i:s'));
                    $this->db->where('id', $batch_id);
                    $batch_updated = $this->db->update('product_batches');
                    error_log("product_batches updated: " . ($batch_updated ? 'YES' : 'NO'));
                }
                
                // 3. INSERT INTO inventory_stock_log
                $log_data = array(
                    'product_id' => $product_id,
                    'warehouse_id' => $warehouse_id,
                    'old_qty' => $old_qty,
                    'new_qty' => $new_qty,
                    'reference_type' => 'STOCK_ADJUSTMENT',
                    'reference_id' => $adjustment_id,
                    'changed_at' => date('Y-m-d H:i:s'),
                    'changed_by' => $user_id
                );
                $log_inserted = $this->db->insert('inventory_stock_log', $log_data);
                error_log("inventory_stock_log inserted: " . ($log_inserted ? 'YES, ID: ' . $this->db->insert_id() : 'NO'));
                
                // 4. INSERT INTO inventory_transactions
                $transaction_data = array(
                    'product_id' => $product_id,
                    'warehouse_id' => $warehouse_id,
                    'transaction_type' => 'ADJUSTMENT',
                    'reference_type' => 'STOCK_ADJUSTMENT',
                    'reference_id' => $adjustment_id,
                    'batch_id' => $batch_id,
                    'qty' => $adjustment_qty,
                    'unit_cost' => $avg_cost,
                    'total_cost' => $adjustment_qty * $avg_cost,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'created_by' => $user_id,
                    'created_at' => date('Y-m-d H:i:s')
                );
                $transaction_inserted = $this->db->insert('inventory_transactions', $transaction_data);
                error_log("inventory_transactions inserted: " . ($transaction_inserted ? 'YES, ID: ' . $this->db->insert_id() : 'NO'));
                
                $items_processed++;
            }
            
            $this->db->trans_complete();
            
            error_log("Items processed: $items_processed");
            error_log("Transaction status: " . ($this->db->trans_status() ? 'SUCCESS' : 'FAILED'));
            
            return $this->db->trans_status();
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            error_log("EXCEPTION: " . $e->getMessage());
            return false;
        }
    }
 

/**
 * Get inventory stock with ALL filters applied directly in SQL
 */
public function get_filtered_inventory_stock($warehouse_id = null, $category_id = null, $brand_id = null, $search = null, $show = null)
{
    $this->db->select('
        inventory_stock.id,
        inventory_stock.product_id,
        inventory_stock.warehouse_id,
        inventory_stock.batch_id,
        inventory_stock.qty as systemQty,
        product_batches.avg_cost as avg_cost,
        inventory_stock.updated_at,
        products.name as product_name,
        products.product_code as sku,
        products.description,
        products.reorder_level,
        products.status,
        products.brand_id,
        products.sub_category_id as category_id,
        sub_category.name as category,
        brands.brand_id as brand_id, 
        brands.brand_name as brand_name,
        brands.brand_code as brand_code,
        stores.store_id,
        stores.store_name as warehouse_name,
        stores.store_address as warehouse_address,
        stores.store_phone as warehouse_phone,
        product_batches.batch_no,
        product_batches.expiry_date,
        DATEDIFF(product_batches.expiry_date, CURDATE()) as days_left
    ');
    
    $this->db->from('inventory_stock');
    $this->db->join('products', 'products.id = inventory_stock.product_id', 'left');
    $this->db->join('brands', 'brands.brand_id = products.brand_id', 'left');
    $this->db->join('sub_category', 'sub_category.id = products.sub_category_id', 'left');
    $this->db->join('stores', 'stores.store_id = inventory_stock.warehouse_id', 'left');
    $this->db->join('product_batches', 'product_batches.id = inventory_stock.batch_id', 'left');
    
    // Apply ALL filters
    if ($warehouse_id) {
        $this->db->where('inventory_stock.warehouse_id', $warehouse_id);
    }
    
    if ($category_id) {
        $this->db->where('products.sub_category_id', $category_id);
    }
    
    if ($brand_id) {
        $this->db->where('products.brand_id', $brand_id);
    }
    
    if ($search) {
        $this->db->group_start();
        $this->db->like('products.name', $search);
        $this->db->or_like('products.product_code', $search);
        $this->db->or_like('products.description', $search);
        $this->db->or_like('product_batches.batch_no', $search);
        $this->db->group_end();
    }
    
    // Only show active products
    $this->db->where('products.status', 'active');
    
    // Order by product name, expiry date
    $this->db->order_by('products.name', 'ASC');
    $this->db->order_by('stores.store_name', 'ASC');
    $this->db->order_by('product_batches.expiry_date', 'ASC');
    
    $query = $this->db->get();
    $results = $query->result_array();
    
    // Handle "Show" filter in PHP
    if ($show && $show != 'all') {
        $filtered_results = array();
        foreach ($results as $row) {
            $variance = isset($row['counted']) ? ($row['counted'] - $row['systemQty']) : null;
            
            if ($show == 'counted' && isset($row['counted']) && $row['counted'] !== '') {
                $filtered_results[] = $row;
            } elseif ($show == 'uncounted' && (!isset($row['counted']) || $row['counted'] === '')) {
                $filtered_results[] = $row;
            } elseif ($show == 'variance' && $variance !== null && $variance != 0) {
                $filtered_results[] = $row;
            } elseif ($show == 'pos' && $variance !== null && $variance > 0) {
                $filtered_results[] = $row;
            } elseif ($show == 'neg' && $variance !== null && $variance < 0) {
                $filtered_results[] = $row;
            } elseif ($show == 'all') {
                $filtered_results[] = $row;
            }
        }
        return $filtered_results;
    }
    
    return $results;
}

/**
 * Get inventory stock grouped by batch number
 * Returns nested structure: batches -> products with correct batch quantities
 * INCLUDES products with NO BATCH
 */
public function get_inventory_stock_grouped_by_batch($warehouse_id = null, $category_id = null, $brand_id = null, $search = null)
{
    $this->db->select('
        inventory_stock.id as inventory_id,
        inventory_stock.product_id,
        inventory_stock.warehouse_id,
        inventory_stock.batch_id,
        inventory_stock.qty as systemQty,
         
        inventory_stock.updated_at,
        products.name as product_name,
        products.product_code as sku,
        products.description,
        products.reorder_level,
        products.status,
        products.brand_id,
        products.sub_category_id as category_id,
        sub_category.name as category,
        brands.brand_id as brand_id, 
        brands.brand_name as brand_name,
        brands.brand_code as brand_code,
        stores.store_id,
        stores.store_name as warehouse_name,
        stores.store_address as warehouse_address,
        stores.store_phone as warehouse_phone,
        product_batches.batch_no,
        product_batches.expiry_date,
		product_batches.avg_cost as avg_cost,   

        DATEDIFF(product_batches.expiry_date, CURDATE()) as days_left
    ');
    
    $this->db->from('inventory_stock');
    $this->db->join('products', 'products.id = inventory_stock.product_id', 'left');
    $this->db->join('brands', 'brands.brand_id = products.brand_id', 'left');
    $this->db->join('sub_category', 'sub_category.id = products.sub_category_id', 'left');
    $this->db->join('stores', 'stores.store_id = inventory_stock.warehouse_id', 'left');
    $this->db->join('product_batches', 'product_batches.id = inventory_stock.batch_id', 'left');
    
    // Apply filters
    if ($warehouse_id) {
        $this->db->where('inventory_stock.warehouse_id', $warehouse_id);
    }
    
    if ($category_id) {
        $this->db->where('products.sub_category_id', $category_id);
    }
    
    if ($brand_id) {
        $this->db->where('products.brand_id', $brand_id);
    }
    
    if ($search) {
        $this->db->group_start();
        $this->db->like('products.name', $search);
        $this->db->or_like('products.product_code', $search);
        $this->db->or_like('products.description', $search);
        $this->db->or_like('product_batches.batch_no', $search);
        $this->db->group_end();
    }
    
    $this->db->where('products.status', 'active');
    $this->db->order_by('product_batches.batch_no', 'ASC');
    $this->db->order_by('products.name', 'ASC');
    
    $query = $this->db->get();
    $results = $query->result_array();
    
    // Group by batch number
    $grouped_by_batch = array();
    foreach ($results as $row) {
        // Use 'NO_BATCH' for products without a batch number
        $batch_key = ($row['batch_no'] && $row['batch_no'] !== '') ? $row['batch_no'] : 'NO_BATCH';
        
        if (!isset($grouped_by_batch[$batch_key])) {
            $grouped_by_batch[$batch_key] = array(
                'batch_no' => $row['batch_no'] ?: 'No Batch Assigned',
                'batch_id' => $row['batch_id'],
                'expiry_date' => $row['expiry_date'],
                'days_left' => $row['days_left'],
                'warehouse_name' => $row['warehouse_name'],
                'warehouse_id' => $row['warehouse_id'],
                'products' => array()
            );
        }
        
        // Add product to this batch
        $grouped_by_batch[$batch_key]['products'][] = array(
            'id' => $row['inventory_id'],
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'sku' => $row['sku'],
            'category' => $row['category'],
            'category_id' => $row['category_id'],
            'brand_name' => $row['brand_name'],
            'brand_id' => $row['brand_id'],
            'systemQty' => floatval($row['systemQty']),
            'avg_cost' => floatval($row['avg_cost'] ?: 0),
            'counted' => null
        );
    }
    
    return $grouped_by_batch;
}

/**
     * Fetches parent stock adjustments with joined names for branch, warehouse, and staff.
     */
    public function get_filtered_adjustments($filters) {
        $this->db->select('
            sa.*, 
            b.branch_name, 
            w.store_name, 
            creator.full_name as created_by_name, 
            approver.full_name as approved_by_name
        ');
        $this->db->from('stock_adjustments sa');
        
        // Relational Left Joins
        $this->db->join('branches b', 'b.branch_id = sa.branch_id', 'left');
        $this->db->join('stores w', 'w.store_id = sa.warehouse_id', 'left'); // Adjust 'warehouses' table name if different
        $this->db->join('staff_info creator', 'creator.staff_id = sa.created_by', 'left');
        $this->db->join('staff_info approver', 'approver.staff_id = sa.approved_by', 'left');

        // Dynamic Filtering
        if (!empty($filters['adjustment_type'])) {
            $this->db->where('sa.adjustment_type', $filters['adjustment_type']);
        }

        if (!empty($filters['status'])) {
            $this->db->where('sa.status', $filters['status']);
        }

        if (!empty($filters['date_range'])) {
            $dates = explode(' - ', $filters['date_range']);
            if (count($dates) == 2) {
                $start_date = date('Y-m-d 00:00:00', strtotime($dates[0]));
                $end_date   = date('Y-m-d 23:59:59', strtotime($dates[1]));
                $this->db->where('sa.adjustment_date >=', $start_date);
                $this->db->where('sa.adjustment_date <=', $end_date);
            }
        }

        $this->db->order_by('sa.adjustment_date', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Fetches individual items inside an adjustment, joining product and batch details.
     */
    public function get_adjustment_items($adjustment_id) {
        $this->db->select('sai.*, p.name, p.product_code, bt.batch_no');
        $this->db->from('stock_adjustment_items sai');
        
        // Relational Joins for items
        $this->db->join('products p', 'p.id = sai.product_id', 'left');
        $this->db->join('product_batches bt', 'bt.id = sai.batch_id', 'left'); 
        
        $this->db->where('sai.adjustment_id', $adjustment_id);
        return $this->db->get()->result();
    }
	
	
	public function insert_adjustment($header, $items)
    {
        // 1. INSERT MAIN TABLE (NO CHECK, ALWAYS NEW)
        $this->db->insert('stock_adjustments', $header);
        $adjustment_id = $this->db->insert_id();

        // 2. INSERT ALL ITEMS (NO UPDATE, NO FILTER)
        foreach ($items as $item) {

            $data = [
                'adjustment_id'  => $adjustment_id,
                'product_id'     => $item['product_id'],
                'batch_id'       => $item['batch_id'],
                'current_qty'    => $item['current_qty'],
                'adjustment_qty' => $item['adjustment_qty'],
                'new_qty'        => $item['new_qty'],
                'mode'           => $item['mode']
            ];

            $this->db->insert('stock_adjustment_items', $data);
        }

        return $adjustment_id;
    }

}
