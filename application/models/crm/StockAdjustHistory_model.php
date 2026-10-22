<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 20/3/2026

class StockAdjustHistory_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all stock adjustments with aggregated data
     */
    public function get_adjustments($filters = [], $limit = null, $offset = null, $sort_by = 'adjustment_date', $sort_dir = 'DESC')
{
    $this->db->select('
    sa.*,
    s.store_name as warehouse_name,
    COUNT(DISTINCT sai.id) as items_count,
    SUM(CASE 
        WHEN sai.mode = "ADD" THEN sai.adjustment_qty
        WHEN sai.mode = "SUBTRACT" THEN sai.adjustment_qty
        ELSE sai.new_qty - sai.current_qty
    END) as net_qty,
    SUM(
        (CASE 
            WHEN sai.mode = "ADD" THEN sai.adjustment_qty
            WHEN sai.mode = "SUBTRACT" THEN sai.adjustment_qty
            ELSE sai.new_qty - sai.current_qty
        END) * IFNULL(pb.avg_cost, 0)
    ) as value_impact
', FALSE);
    
    $this->db->from('stock_adjustments sa');
    $this->db->join('stock_adjustment_items sai', 'sa.id = sai.adjustment_id', 'left');
    $this->db->join('stores s', 'sa.warehouse_id = s.store_id', 'left');
    $this->db->join('product_batches pb', 'pb.id = sai.batch_id', 'left');
    // Apply filters
    $this->_apply_filters($filters);
    
    $this->db->group_by('sa.id, sa.warehouse_id');
    
    // Apply sorting
    $sortable_fields = [
        'adjNo' => 'sa.adjustment_no',
        'date' => 'sa.adjustment_date',
        'warehouse' => 's.store_name',
        'type' => 'sa.adjustment_type',
        'status' => 'sa.status',
        'createdBy' => 'sa.created_by',
        'valueImpact' => 'value_impact'
    ];
    
    $sort_field = isset($sortable_fields[$sort_by]) ? $sortable_fields[$sort_by] : 'sa.adjustment_date';
    $this->db->order_by($sort_field, $sort_dir);
    
    // Apply pagination
    if ($limit !== null && $offset !== null) {
        $this->db->limit($limit, $offset);
    }
    
    $query = $this->db->get();
    $results = $query->result_array();
    
    return $results;
}
    
    /**
     * Get total count of adjustments with filters
     */
    public function get_adjustments_count($filters = [])
    {
        $this->db->from('stock_adjustments sa');
        $this->db->join('stores s', 'sa.warehouse_id = s.store_id', 'left');
        $this->_apply_filters($filters);
        return $this->db->count_all_results();
    }
    
    /**
     * Get single adjustment with its items
     */
    public function get_adjustment_detail($id)
    {
        // Get adjustment header with warehouse info
        $this->db->select('sa.*, s.store_name as warehouse_name');
        $this->db->from('stock_adjustments sa');
        $this->db->join('stores s', 'sa.warehouse_id = s.store_id', 'left');
        $this->db->where('sa.id', $id);
        $adjustment = $this->db->get()->row_array();
        
        if (!$adjustment) {
            return null;
        }
        
        // Get items
        $this->db->where('adjustment_id', $id);
        $items = $this->db->get('stock_adjustment_items')->result_array();
        
        // Format items
        $formatted_items = [];
        foreach ($items as $item) {
            $formatted_items[] = [
                'product' => $this->_get_product_name($item['product_id']),
                'sku' => $this->_get_product_sku($item['product_id']),
                'batch' => $item['batch_id'] ? $this->_get_batch_number($item['batch_id']) : '',
                'mode' => strtolower($item['mode']),
                'qty' => abs($item['adjustment_qty']),
                'oldQty' => $item['current_qty'],
                'newQty' => $item['new_qty'],
                'unit' => 'pcs',
                'cost' => $this->_get_product_cost($item['product_id'], $adjustment['warehouse_id'], $item['batch_id'])
            ];
        }
        
        // Get activity log
        $activities = $this->_get_activity_log($adjustment);
        
        // Calculate net quantity and value impact
        $net_qty = 0;
        $value_impact = 0;
        foreach ($formatted_items as $item) {
            $delta = 0;
            if ($item['mode'] == 'add') {
                $delta = $item['qty'];
            } elseif ($item['mode'] == 'sub') {
                $delta = -$item['qty'];
            } else {
                $delta = $item['newQty'] - $item['oldQty'];
            }
            $net_qty += $delta;
            $value_impact += $delta * $item['cost'];
        }
        
        return [
            'id' => $adjustment['id'],
            'adjNo' => $adjustment['adjustment_no'],
            'date' => date('Y-m-d', strtotime($adjustment['adjustment_date'])),
            'warehouse' => $adjustment['warehouse_name'] ?? 'Warehouse ' . $adjustment['warehouse_id'],
            'type' => $this->_format_type($adjustment['adjustment_type']),
            'status' => $adjustment['status'] ?? 'Draft',
            'createdBy' => $this->_get_user_name($adjustment['created_by']),
            'approvedBy' => isset($adjustment['approved_by']) ? $this->_get_user_name($adjustment['approved_by']) : '',
            'remarks' => $adjustment['remarks'] ?? '',
            'items' => $formatted_items,
            'activity' => $activities,
            'items_count' => count($formatted_items),
            'netQty' => $net_qty,
            'valueImpact' => $value_impact
        ];
    }
    
    /**
     * Get adjustment items for a specific adjustment
     */
    public function get_adjustment_items($adjustment_id)
    {
        $this->db->where('adjustment_id', $adjustment_id);
        $query = $this->db->get('stock_adjustment_items');
        return $query->result_array();
    }
    
    /**
     * Get all stores/warehouses for filter dropdown
     */
    public function get_warehouses()
    {
        $this->db->select('store_id as id, store_name as name');
        $this->db->from('stores');
        $this->db->where('store_status', 'Active');
        $this->db->order_by('store_name');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get users for filter dropdown
     */
    public function get_users()
    {
        // First get from user table
        if ($this->db->table_exists('user')) {
            $this->db->select('user_id as id, full_name as username');
            $this->db->from('user');
            $this->db->where('status', '1');
            $this->db->order_by('full_name');
            $query = $this->db->get();
            $user_results = $query->result_array();
            
            $users = [];
            foreach ($user_results as $row) {
                $users[] = [
                    'id' => $row['id'],
                    'username' => $row['username']
                ];
            }
            
            return $users;
        }
        
        // Fallback: get from stock_adjustments
        $this->db->select('created_by as id, created_by as username');
        $this->db->from('stock_adjustments');
        $this->db->where('created_by IS NOT NULL');
        $this->db->group_by('created_by');
        $this->db->order_by('created_by');
        $query = $this->db->get();
        $results = $query->result_array();
        
        $users = [];
        foreach ($results as $row) {
            $users[] = [
                'id' => $row['id'],
                'username' => 'User ' . $row['username']
            ];
        }
        
        return $users;
    }
    
   /**
 * Update adjustment status
 */
public function update_status($id, $status, $reason = '', $user_id = null)
{
    // Initialize data array
    $data = [];
    
    // Check for rejected status (case-insensitive)
    if (strtolower($status) == 'rejected') {
        $data['status'] = 'rejected';
        
        // Get current remarks
        $current = $this->db->select('remarks')->where('id', $id)->get('stock_adjustments')->row();
        $current_remarks = $current ? ($current->remarks ?? '') : '';
        
        // Create rejection log
        $rejection_log = "\n" . str_repeat("=", 50) . "\n";
        $rejection_log .= "❌ REJECTED\n";
        $rejection_log .= "Date: " . date('Y-m-d H:i:s') . "\n";
        $rejection_log .= "By: User ID " . ($user_id ?? 'Unknown') . "\n";
        $rejection_log .= "Reason: " . $reason . "\n";
        $rejection_log .= str_repeat("=", 50) . "\n";
        
        // Add to remarks
        $data['remarks'] = $current_remarks . $rejection_log;
        
    } 
    elseif (strtolower($status) == 'approved') {
        $data['status'] = 'approved';
        $data['approved_by'] = $user_id;
        $data['approved_date'] = date('Y-m-d H:i:s');
        $this->_apply_stock_changes($id);
    }
    else {
        // For any other status, just update status
        $data['status'] = strtolower($status);
    }
    
    // Only update if we have data
    if (empty($data)) {
        return false;
    }
    
    $this->db->where('id', $id);
    return $this->db->update('stock_adjustments', $data);
}
    
    /**
 * Apply stock changes when adjustment is approved
 * This should match the logic in StockAdjustment_model::update_inventory_stock()
 */
private function _apply_stock_changes($adjustment_id)
{
    error_log("=== _apply_stock_changes STARTED for ID: " . $adjustment_id);
    
    $this->db->trans_start();
    
    try {
        // Get adjustment items with warehouse info
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
     * Apply filters to query
     */
    private function _apply_filters($filters)
    {
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(sa.adjustment_date) >=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(sa.adjustment_date) <=', $filters['date_to']);
        }
        
        if (!empty($filters['warehouse_id'])) {
            $this->db->where('sa.warehouse_id', $filters['warehouse_id']);
        }
        
        if (!empty($filters['adjustment_type'])) {
            $this->db->where('sa.adjustment_type', $filters['adjustment_type']);
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('sa.status', $filters['status']);
        }
        
        if (!empty($filters['created_by'])) {
            $this->db->where('sa.created_by', $filters['created_by']);
        }
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('sa.adjustment_no', $filters['search']);
            $this->db->or_like('sa.remarks', $filters['search']);
            $this->db->or_like('s.store_name', $filters['search']);
            $this->db->group_end();
        }
    }
    
    /**
     * Get user name by ID
     */
    private function _get_user_name($user_id)
    {
        if (empty($user_id)) return 'System';
        
        if ($this->db->table_exists('user')) {
            $this->db->select('full_name');
            $this->db->where('user_id', $user_id);
            $query = $this->db->get('user');
            $result = $query->row_array();
            if ($result && !empty($result['full_name'])) {
                return $result['full_name'];
            }
        }
        
        return 'User ' . $user_id;
    }
    
    /**
     * Get product name by ID
     */
    private function _get_product_name($product_id)
    {
        if ($this->db->table_exists('products')) {
            $this->db->select('name');
            $this->db->where('id', $product_id);
            $query = $this->db->get('products');
            $result = $query->row_array();
            if ($result) {
                return $result['name'];
            }
        }
        
        return 'Product ' . $product_id;
    }
    
    /**
     * Get product SKU by ID
     */
    private function _get_product_sku($product_id)
{
    if ($this->db->table_exists('products')) {
        $this->db->select('product_code');  // ✅ Correct column name
        $this->db->where('id', $product_id);
        $query = $this->db->get('products');
        $result = $query->row_array();
        if ($result && !empty($result['product_code'])) {
            return $result['product_code'];
        }
    }
    
    return 'SKU-' . $product_id;
}
    
   /**
 * Get product cost from product_batches table only
 */
private function _get_product_cost($product_id, $warehouse_id = null, $batch_id = null)
{
    // Get from product_batches using batch_id
    if ($batch_id) {
        $this->db->select('avg_cost');
        $this->db->where('id', $batch_id);
        $query = $this->db->get('product_batches');
        $result = $query->row_array();
        
        if ($result && isset($result['avg_cost'])) {
            return (float)$result['avg_cost'];
        }
    }
    
    // No fallbacks - return 0 if not found
    return 0;
}
    
    /**
     * Get batch number by ID
     */
    private function _get_batch_number($batch_id)
    {
        if ($this->db->table_exists('product_batches')) {
            $this->db->select('batch_no');
            $this->db->where('id', $batch_id);
            $query = $this->db->get('product_batches');
            $result = $query->row_array();
            if ($result && !empty($result['batch_no'])) {   
                return $result['batch_no'];   
            }
        }
        
        return 'BATCH-' . $batch_id;
    }
    
    /**
     * Format adjustment type for display
     */
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
    
    /**
     * Generate activity log from adjustment data
     */
    private function _get_activity_log($adjustment)
    {
        $activities = [];
        
        if (!empty($adjustment['created_at'])) {
            $activities[] = [
                'action' => 'created',
                'by' => $this->_get_user_name($adjustment['created_by']),
                'at' => date('Y-m-d H:i', strtotime($adjustment['created_at'])),
                'note' => 'Adjustment created'
            ];
        }
        
        if (!empty($adjustment['submitted_at'])) {
            $activities[] = [
                'action' => 'submitted',
                'by' => $this->_get_user_name($adjustment['submitted_by'] ?? $adjustment['created_by']),
                'at' => date('Y-m-d H:i', strtotime($adjustment['submitted_at'])),
                'note' => 'Submitted for approval'
            ];
        }
        
        if (!empty($adjustment['approved_at'])) {
            $activities[] = [
                'action' => 'approved',
                'by' => $this->_get_user_name($adjustment['approved_by']),
                'at' => date('Y-m-d H:i', strtotime($adjustment['approved_at'])),
                'note' => 'Approved and stock updated'
            ];
        }
        
        if (!empty($adjustment['rejected_at'])) {
            $activities[] = [
                'action' => 'rejected',
                'by' => $this->_get_user_name($adjustment['rejected_by']),
                'at' => date('Y-m-d H:i', strtotime($adjustment['rejected_at'])),
                'note' => $adjustment['rejection_reason'] ?? 'No reason provided'
            ];
        }
        
        if (!empty($adjustment['cancelled_at'])) {
            $activities[] = [
                'action' => 'cancelled',
                'by' => $this->_get_user_name($adjustment['cancelled_by']),
                'at' => date('Y-m-d H:i', strtotime($adjustment['cancelled_at'])),
                'note' => $adjustment['cancellation_reason'] ?? 'Cancelled'
            ];
        }
        
        return $activities;
    }
}