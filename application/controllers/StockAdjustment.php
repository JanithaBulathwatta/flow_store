<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 19/3/2026

class StockAdjustment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Core libraries & helpers
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        
        // Load the model
        $this->load->model('crm/StockAdjustment_model');
		$this->load->model('Store_model');
		
		// ========== ADD THIS PERMISSION CODE HERE ==========
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
    $this->can_approve = ($this->ut_id == 1 || $this->ut_id == 2 || $this->is_owner == 1);
    $this->can_submit = true; // All logged-in users can submit counts
    
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
    // Get ALL filter parameters from URL (GET request)
    $warehouse_id = $this->input->get('warehouse_id');
    $category_id = $this->input->get('category_id');
    $brand_id = $this->input->get('brand_id');
    $search = $this->input->get('search');
    $show = $this->input->get('show');
    
    // Pass filter values to view for preserving selections
    $data['filters'] = array(
        'warehouse_id' => $warehouse_id,
        'category_id' => $category_id,
        'brand_id' => $brand_id,
        'search' => $search,
        'show' => $show
    );
    
    // Get data from model with ALL filters applied
    $data['stock_items'] = $this->StockAdjustment_model->get_filtered_inventory_stock(
        $warehouse_id, $category_id, $brand_id, $search, $show
    );
    
    $data['summary'] = $this->StockAdjustment_model->get_stock_summary();
    $data['categories'] = $this->StockAdjustment_model->get_categories();
    $data['brands'] = $this->StockAdjustment_model->get_brands();
    //$data['warehouses'] = $this->StockAdjustment_model->get_warehouses();
    $data['warehouses'] = $this->Store_model->get_active();
	
    // Generate adjustment number
    $data['adjustment_no'] = 'ADJ-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
	// ========== ADD THESE LINES ==========
    // Pass permissions to view
    $data['can_approve'] = $this->can_approve;
    $data['can_submit'] = $this->can_submit;
    $data['ut_id'] = $this->ut_id;
    $data['is_owner'] = $this->is_owner;
    // ========== END OF ADDED LINES ==========
	
    // Load views
    $this->load->view('header');
    $this->load->view('crm/stock/stockAdjustment', $data);
    $this->load->view('footer');
}

	// this function is use for get stock adjustments report
	public function stock_adjustment_report(){
		$this->load->view('header');
		$this->load->view('/stock/stock_ajustment_report');
		$this->load->view('footer');
	}
	
	
	/**
     * AJAX endpoint tracking parent adjustments log matching standard filter constraints.
     */
    public function filter_adjustments() {
        $type       = $this->input->post('adjustment_type');
        $status     = $this->input->post('status');
        $date_range = $this->input->post('date_range');

        $filters = array(
            'adjustment_type' => $type,
            'status'          => $status,
            'date_range'      => $date_range
        );

        $data = $this->StockAdjustment_model->get_filtered_adjustments($filters);
        
        echo json_encode(array('status' => true, 'data' => $data));
    }

    /**
     * AJAX drill down payload loader tracking individual item subcategories mapping.
     */
    public function get_adjustment_items() {
        $adjustment_id = $this->input->post('adjustment_id');
        
        if (empty($adjustment_id)) {
            echo json_encode(array('status' => false, 'data' => []));
            return;
        }

        $data = $this->StockAdjustment_model->get_adjustment_items($adjustment_id);
        
        echo json_encode(array('status' => true, 'data' => $data));
    }

	
	
	
	
    /**
     * AJAX endpoint to save counted quantities
     */
    public function save_count()
    {
        $id = $this->input->post('id');
        $counted_qty = $this->input->post('counted_qty');
        
        // You can implement actual saving here if needed
        echo json_encode(['success' => true]);
    }
    
    /**
 * AJAX endpoint to submit for approval
 */
public function submit()
{
    $adjustment_no = $this->input->post('adjustment_no');
    $notes = $this->input->post('notes');
    $items = json_decode($this->input->post('items'), true); // Get counted items
    
    if (empty($items)) {
        echo json_encode([
            'success' => false,
            'message' => 'No items to submit'
        ]);
        return;
    }
    
    // Get warehouse_id from first item (assuming all items are from same warehouse)
    $warehouse_id = $items[0]['warehouse_id'];
    
    // Start transaction
    $this->db->trans_start();
    
    try {
        // Create adjustment header
        $adjustment_id = $this->StockAdjustment_model->create_adjustment($adjustment_no, $warehouse_id, $notes);
        
        // Prepare items for saving with batch tracking
        $adjustment_items = array();
        foreach ($items as $item) {
            $adjustment_qty = $item['counted'] - $item['systemQty'];
            $adjustment_items[] = array(
                'product_id' => $item['product_id'],
                'batch_id' => $item['batch_id'], // Add batch_id
                'current_qty' => $item['systemQty'],
                'adjustment_qty' => $adjustment_qty,
                'new_qty' => $item['counted']
            );
        }
        
        // Save adjustment items
        $this->StockAdjustment_model->save_adjustment_items($adjustment_id, $adjustment_items);
        
        // Complete transaction
        $this->db->trans_complete();
        
        echo json_encode([
            'success' => true,
            'message' => 'Stock adjustment #' . $adjustment_no . ' submitted successfully'
        ]);
        
    } catch (Exception $e) {
        $this->db->trans_rollback();
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}
    
    /**
     * AJAX endpoint to approve and post
     */
    public function approve()
{
	// ========== ADD THIS PERMISSION CHECK ==========
    if (!$this->can_approve) {
        echo json_encode([
            'success' => false,
            'message' => 'You do not have permission to approve stock adjustments'
        ]);
        return;
    }
    // ========== END OF PERMISSION CHECK ==========
	
    $adjustment_no = $this->input->post('adjustment_no');
    
    // Get adjustment ID from adjustment number
    $this->db->select('id');
    $this->db->from('stock_adjustments');
    $this->db->where('adjustment_no', $adjustment_no);
    $adjustment = $this->db->get()->row_array();
    
    if (!$adjustment) {
        echo json_encode([
            'success' => false,
            'message' => 'Adjustment not found'
        ]);
        return;
    }
    
    // Update inventory stock
    $result = $this->StockAdjustment_model->update_inventory_stock($adjustment['id']);
    
    if ($result) {
		// ✅ ADD THE NEW CODE HERE (after the stock update success)
        // ========== ADD THIS CODE ==========
        $this->db->where('adjustment_no', $adjustment_no);
        $this->db->update('stock_adjustments', array(
            'status' => 'approved',
            'approved_by' => $this->user_id,
            'approved_date' => date('Y-m-d H:i:s')
        ));
        // ========== END OF ADDED CODE ==========
        echo json_encode([
            'success' => true,
            'message' => 'Stock adjustment #' . $adjustment_no . ' approved and inventory updated'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Approval failed'
        ]);
    }
}
    
    /**
     * AJAX endpoint to get filtered data
     */
    public function get_filtered_data()
    {
        $warehouse_id = $this->input->post('warehouse_id');
        $category_id = $this->input->post('category');
        $brand_id = $this->input->post('brand');
        $search = $this->input->post('search');
        
        // Use the correct method name
        $data = $this->StockAdjustment_model->get_inventory_stock($warehouse_id);
        
        // Apply additional filters
        if ($category_id) {
            $data = array_filter($data, function($item) use ($category_id) {
                return isset($item['sub_category_id']) && $item['sub_category_id'] == $category_id;
            });
        }
        
        if ($brand_id) {
            $data = array_filter($data, function($item) use ($brand_id) {
                return isset($item['brand_id']) && $item['brand_id'] == $brand_id;
            });
        }
        
        if ($search) {
            $search = strtolower($search);
            $data = array_filter($data, function($item) use ($search) {
                return (strpos(strtolower($item['product_name']), $search) !== false) ||
                       (isset($item['sku']) && strpos(strtolower($item['sku']), $search) !== false) ||
                       (isset($item['description']) && strpos(strtolower($item['description']), $search) !== false) ||
                       (isset($item['brand_name']) && strpos(strtolower($item['brand_name']), $search) !== false);
            });
        }
        
        // Reindex array
        $data = array_values($data);
        
        echo json_encode($data);
    }
	
	/**
 * AJAX endpoint to get stock data AND warehouse data together
 */
public function get_stock_data()
{
    $warehouse_id = $this->input->get('warehouse_id');
    
    // Get stock data
    $stock_data = $this->StockAdjustment_model->get_inventory_stock($warehouse_id);
    
    // Get warehouse data from Store model
    $warehouses = $this->Store_model->get_active();
    
    // Format warehouses to match your existing structure
    $formatted_warehouses = array();
    foreach ($warehouses as $wh) {
        $formatted_warehouses[] = array(
            'id' => $wh->store_id,
            'name' => $wh->store_name,
            'address' => $wh->store_address,
            'phone' => $wh->store_phone,
            'code' => 'ST' . str_pad($wh->store_id, 2, '0', STR_PAD_LEFT)
        );
    }
    
    // Return both datasets in one response
    $response = array(
        'stock_items' => $stock_data,
        'warehouses' => $formatted_warehouses
    );
    
    echo json_encode($response);
}

/**
 * AJAX endpoint to get warehouses data
 */
public function get_warehouses_data()
    {
        // Use Store_model instead of StockAdjustment_model
        $warehouses = $this->Store_model->get_active();
        
        
        $formatted = array();
        foreach ($warehouses as $wh) {
            $formatted[] = array(
                'id' => $wh->store_id,
                'name' => $wh->store_name,
                'address' => $wh->store_address,
                'phone' => $wh->store_phone,
                'code' => 'ST' . str_pad($wh->store_id, 2, '0', STR_PAD_LEFT)
            );
        }
        
        echo json_encode($formatted);
    }
	
	/**
 * AJAX endpoint to get stock data grouped by batch
 */
public function get_stock_data_grouped()
{
    $warehouse_id = $this->input->get('warehouse_id');
    $category_id = $this->input->get('category_id');
    $brand_id = $this->input->get('brand_id');
    $search = $this->input->get('search');
    
    // Get grouped stock data
    $grouped_data = $this->StockAdjustment_model->get_inventory_stock_grouped_by_batch(
        $warehouse_id, $category_id, $brand_id, $search
    );
    
    // Get warehouse data
    $warehouses = $this->Store_model->get_active();
    
    $formatted_warehouses = array();
    foreach ($warehouses as $wh) {
        $formatted_warehouses[] = array(
            'id' => $wh->store_id,
            'name' => $wh->store_name,
            'address' => $wh->store_address,
            'phone' => $wh->store_phone,
            'code' => 'ST' . str_pad($wh->store_id, 2, '0', STR_PAD_LEFT)
        );
    }
    
    $response = array(
        'batches' => $grouped_data,
        'warehouses' => $formatted_warehouses
    );
    
    echo json_encode($response);
}


	public function save_adjestment()
	{

		$items = json_decode($this->input->post('items_json'), true);

		if (!$items || count($items) == 0) {
			echo json_encode([
				'status' => false,
				'message' => 'No items found'
			]);
			return;
		}

		// MAIN TABLE DATA (ALWAYS INSERT)
		$header = [
			'branch_id'       => $this->input->post('branch_id'),
			'warehouse_id'    => $this->input->post('warehouse_id'),
			'adjustment_type' => $this->input->post('adjustment_type'),
			'adjustment_date' => date('Y-m-d H:i:s'),
			'remarks'         => $this->input->post('remarks'),
			'created_by'      => $this->session->userdata('user_id'),
			'status'          => 'submitted',
			'adjustment_no'   => 'ADJ-' . time()
		];

		$id = $this->StockAdjustment_model->insert_adjustment($header, $items);

		echo json_encode([
			'status' => true,
			'id'     => $id
		]);
	}

 
}