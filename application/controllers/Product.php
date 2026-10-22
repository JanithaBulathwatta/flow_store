<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//wenusha 6/3/2026

class Product extends CI_Controller
{
    public function __construct()
	
	
    {
        parent::__construct();
		
		// Debug - log the request
    if ($this->input->server('REQUEST_METHOD') === 'POST') {
        log_message('debug', 'POST request received to: ' . $this->uri->segment(2));
        log_message('debug', 'POST data: ' . print_r($this->input->post(), true));
    }

        // Core libraries & helpers
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

        // Models
        $this->load->model('crm/Product_model', 'product_model');
        $this->load->model('crm/Brand_model', 'brand');
        $this->load->model('crm/Category_model', 'category');
        $this->load->model('crm/Sup_category_model', 'super_category');
		$this->load->model('crm/Sub_category_model', 'sub_category');
		$this->load->model('crm/Unit_model', 'unit');
    }

    /**
     * Get product counts for mini cards
     */
    public function get_counts() {
    $active = $this->db->where('status', 'active')->count_all_results('products');
    $inactive = $this->db->where('status', 'inactive')->count_all_results('products');
    $deleted = $this->db->where('status', 'deleted')->count_all_results('products');

    echo json_encode([
        'active_count' => $active,
        'inactive_count' => $inactive,
        'deleted_count' => $deleted
    ]);
}

    /**
     * Main product page
     */
    public function index()
    {
        $data = [
            'page_title' => 'Products',
            'products' => $this->product_model->get_active(),
            'counts' => $this->product_model->get_counts(),
            'brands' => $this->brand->get_active(),
            'super_categories' => $this->super_category->get_active(),
            'sub_categories' => $this->sub_category->get_active()
        ];

        $this->load->view('header');
        $this->load->view('crm/product/product', $data);
        $this->load->view('footer');
    }
	
	
	public function add()
{
    // Check if ID is passed for editing
    $edit_id = $this->input->get('id');
    
    $data = [
        'page_title' => $edit_id ? 'Edit Product' : 'Add Product',
        'is_edit' => $edit_id ? true : false,
        'product_id' => $edit_id,
        'super_categories' => $this->super_category->get_active(),
        'brands' => $this->brand->get_active(),
        'sub_categories' => $this->sub_category->get_active(),
		'units' => $this->unit->get_active(),
		'default_reorder_level' => 0,
        'default_qty_per_pack' => 1
    ];
    
    $this->load->view('header');
    $this->load->view('crm/product/product_add', $data);
    $this->load->view('footer');
}

public function edit($id = null)
{
    // Debug: Log the received ID
    error_log('=== EDIT METHOD CALLED ===');
    error_log('Received ID: ' . $id);
    error_log('Full URL: ' . current_url());
    
    if ($id === null) {
        error_log('ID is NULL - redirecting to add');
        redirect(base_url('Product/add'));
        return;
    }
    
    $product = $this->product_model->get_by_id($id);
    
    if (!$product) {
        show_404();
    }
    
    $data = [
        'page_title' => 'Edit Product',
        'product' => $product,
        'is_edit' => true,
        'super_categories' => $this->super_category->get_active(),
        'brands' => $this->brand->get_active(),
        'sub_categories' => $this->sub_category->get_active(),
		'units' => $this->unit->get_active()
    ];
    
	$this->load->view('header');
    $this->load->view('crm/product/product_add', $data);
	$this->load->view('footer');
}


   /**
 * Filter products for DataTable
 */
public function filter()
{
    try {
        $status = $this->input->post('status');
        $search = $this->input->post('search');
        $date = $this->input->post('date');
        $scat = $this->input->post('s_cat');
        
        // USE THE MODEL METHOD THAT HAS ALL THE JOINS
        $data = $this->product_model->get_filtered($search, $status, $date , $scat);
        
        $counts = [
            'active_count' => $this->db->where('status', 'active')->count_all_results('products'),
            'inactive_count' => $this->db->where('status', 'inactive')->count_all_results('products'),
            'deleted_count' => $this->db->where('status', 'deleted')->count_all_results('products')
        ];

        echo json_encode(['data' => $data, 'counts' => $counts]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
    /**
     * Get super categories for dropdown
     */
    public function get_super_categories()
    {
        $data = $this->super_category->get_active();
        echo json_encode(['success' => true, 'data' => $data]);
    }

    /**
     * Get brands for dropdown
     */
    public function get_brands()
    {
        $data = $this->brand->get_active();
        echo json_encode(['success' => true, 'data' => $data]);
    }

    /**
 * Get sub categories for dropdown (renamed from get_categories)
 */
public function get_sub_categories()
{
    $super_category_id = $this->input->get('super_category_id');
    
    if ($super_category_id) {
        // Get sub categories filtered by super category
        $data = $this->sub_category->get_by_super_category($super_category_id); // You'll need a Sub_category_model
    } else {
        // Get all active sub categories
        $data = $this->sub_category->get_active(); // You'll need a Sub_category_model
    }
    
    echo json_encode(['success' => true, 'data' => $data]);
}

    /**
 * Get sub categories by super category (for dynamic dropdown)
 */
public function get_sub_categories_by_super()
{
    $super_category_id = $this->input->post('super_category_id');
    
	if (!$super_category_id) {
        echo json_encode([]);
        return;
    }
	
    // You'll need to load Sub_category_model
    $this->load->model('crm/Sub_category_model', 'sub_category');
    $sub_categories = $this->sub_category->get_by_super_category($super_category_id);
    
    echo json_encode($sub_categories);
}

    /**
     * Get single product for edit
     */
    public function get_product()
    {
        $id = $this->input->get('id');

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            return;
        }

        $product = $this->product_model->get_by_id($id);

        if ($product) {
            echo json_encode(['success' => true, 'product' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
    }

    /**
 * Store or Update product - Combined method  
 */
public function store()
{
	
	 
    $id = $this->input->post('pid'); // Check if ID exists for update

     
     
    // ===========================================
    // BASIC INFORMATION VALIDATION (ALL MANDATORY)
    // ===========================================
    $this->form_validation->set_rules('name', 'Product Name', 'required|trim');
    $this->form_validation->set_rules('code', 'Product Code', 'required|trim');
    $this->form_validation->set_rules('super_category_id', 'Super Category', 'required|integer');
    $this->form_validation->set_rules('brand_id', 'Brand', 'required|integer');
    $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
    $this->form_validation->set_rules('measure_unit', 'Measure Unit', 'required|integer');
    $this->form_validation->set_rules('reorder_level', 'Reorder Level', 'required|integer|greater_than_equal_to[0]');
    
    // ===========================================
    // PRICING VALIDATION (ALL MANDATORY)
    // ===========================================
    $this->form_validation->set_rules('selling_price', 'Selling Price', 'required|numeric|greater_than[0]');
       
    $this->form_validation->set_rules('wholesale_price', 'Wholesale Price', 'numeric|greater_than_equal_to[0]'); // Optional
    $this->form_validation->set_rules('special_price', 'Special Price', 'numeric|greater_than_equal_to[0]'); // Optional
    
    
	
    // Check product code uniqueness (with ID for update)
    $code = $this->input->post('code');
    if (!empty($code)) {
        if ($id) {
            // Check for update - exclude current product
            if ($this->product_model->code_exists($code, $id)) {
                echo json_encode(['stt' => 'error', 'msg' => 'Product code already exists']);
                return;
            }
        } else {
            // Check for insert
            if ($this->product_model->code_exists($code)) {
                echo json_encode(['stt' => 'error', 'msg' => 'Product code already exists']);
                return;
            }
        }
    }

    // Check warranty validation if checked
    $is_warranty = $this->input->post('is_warranty_item');
    if ($is_warranty && empty($this->input->post('warranty_period'))) {
        echo json_encode(['stt' => 'error', 'msg' => 'Warranty period is required for warranty items']);
        return;
    }

    if ($this->form_validation->run() == FALSE) {
    // Get individual field errors
    $error_messages = [];
    foreach ($this->form_validation->error_array() as $field => $error) {
        // Map form field names to their error display IDs
        /*$field_map = [
            'name' => 'name',
            'code' => 'code',
            'sub_category_id' => 'category_id',
            'brand_id' => 'brand_id',
            'category_id' => 'super_category_id',
            'reorder_level' => 'reorder_level',
            'selling_price' => 'selling_price',
            'opening_stock' => 'opening_stock',
            'unit_id' => 'measure_unit',
            'opening_value' => 'opening_value'
        ];*/
		
		$field_map = [
            'name' => 'name',
            'code' => 'code',
            'sub_category_id' => 'super_category_id',
            'brand_id' => 'brand_id',
            'category_id' => 'category_id',
            'reorder_level' => 'reorder_level',
            'selling_price' => 'selling_price',
            'opening_stock' => 'opening_stock',
            'unit_id' => 'measure_unit',
            'opening_value' => 'opening_value'
        ];
        
        $display_field = isset($field_map[$field]) ? $field_map[$field] : $field;
        $error_messages[$display_field] = $error;
    }
    
    echo json_encode([
        'stt' => 'error',
        'msg' => validation_errors(),
        'data' => '',
        'errors' => $error_messages  // Add this line
    ]);
    return;
}
	
	$uploaded_images = [];
	
	// Create upload directory if not exists
    $upload_path = FCPATH . 'uploads/products/';
    if (!file_exists($upload_path)) {
        mkdir($upload_path, 0777, true);
    }
	
	// Process main image
    if (!empty($_FILES['main_image']['name'])) {
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = time() . '_main_' . rand(1000, 9999);
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('main_image')) {
            $upload_data = $this->upload->data();
            $uploaded_images[] = $upload_data['file_name'];
        } else {
            echo json_encode(['stt' => 'error', 'msg' => 'Main image upload failed: ' . $this->upload->display_errors()]);
            return;
        }
    }
	
	 
	
	// Handle deletion of existing images (for edit mode)
    $delete_images = $this->input->post('delete_images');
    $existing_images = [];
    
    if ($id) {
        $current_product = $this->product_model->get_by_id($id);
        if ($current_product && !empty($current_product['images'])) {
            $existing_images = json_decode($current_product['images'], true) ?: [];
            
            // Remove deleted images from server
            if (!empty($delete_images)) {
                foreach ($delete_images as $del_img) {
                    $file_path = $upload_path . $del_img;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    // Remove from array
                    $key = array_search($del_img, $existing_images);
                    if ($key !== false) {
                        unset($existing_images[$key]);
                    }
                }
            }
        }
    }
    
    // Merge existing images with new ones
    $all_images = array_merge($existing_images, $uploaded_images);
    $images_json = !empty($all_images) ? json_encode(array_values($all_images)) : null;
    
    
    $is_serial_trk = $this->input->post('is_serial_trk') ? 1 : 0;
    $is_expiry_trk = $this->input->post('is_expiry_trk') ? 1 : 0;
    $is_batch = $this->input->post('is_batch') ? 1 : 0;
	
    // Prepare data
    $data = [
        'name' => $this->input->post('name', TRUE),
        'product_code' => $this->input->post('code', TRUE),
        'description' => $this->input->post('description', TRUE),
        'price' => $this->input->post('selling_price'),
		'wholesalePrice' => $this->input->post('wholesale_price') ?: null,
        'specialPrice' => $this->input->post('special_price') ?: null,
         
        'reorder_level' => $this->input->post('reorder_level') ?: 0,
		//'opening_stock' => $this->input->post('opening_stock') ?: 0,
        //'opening_value' => $this->input->post('opening_value') ?: 0.00,
        'images' => $images_json,
        //'sub_category_id' => $this->input->post('category_id'),
        'sub_category_id' => $this->input->post('super_category_id'),
        'brand_id' => $this->input->post('brand_id'),
        'category_id' => $this->input->post('category_id'),
        'is_warranty_item' => $is_warranty ? 1 : 0,
        'warranty_period' => $this->input->post('warranty_period'),
        'is_serial_trk' => $is_serial_trk,
        'is_expiry_trk' => $is_expiry_trk,
		'is_batch' => $is_batch,
		'is_auto_batch' => ($is_batch == 1) ? 0 : 1,
        'warrantyType' => $this->input->post('warrantyType'),
		'measure_unit' => $this->input->post('measure_unit'),       
        'qty_per_pack' => $this->input->post('qty_per_pack') ?: 1,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($id) {
        // UPDATE existing product
        $old_product = $this->product_model->get_by_id($id);
        $result = $this->product_model->update($id, $data);
        if ($result) {
            // Update using sub_category_id (which links to sub_category table)
            if ($old_product && isset($old_product['sub_category_id'])) {
                $this->update_super_category_item_count($old_product['sub_category_id']);
            }
            $this->update_super_category_item_count($this->input->post('super_category_id'));
            
            echo json_encode(['stt' => 'ok', 'msg' => 'Product updated successfully', 'data' => $id]);
        }
    } else {
        // INSERT new product
        $data['status'] = 'active';
        $data['created_at'] = date('Y-m-d H:i:s');
        $product_id = $this->product_model->create($data);
        if ($product_id) {
        // Update super_category item count for the new product's category
          $this->update_super_category_item_count($this->input->post('super_category_id'));
		  
        echo json_encode(['stt' => 'ok', 'msg' => 'Product created successfully', 'data' => $product_id]);
    } else {
        echo json_encode(['stt' => 'error', 'msg' => 'Failed to create product']);
    }
    }
}

     

    /**
 * Delete product  
 */
public function delete()
{
    $id = $this->input->get('id');

    if (!$id) {
        echo json_encode(['stt' => 'error', 'msg' => 'Product ID required']);
        return;
    }

    // Get product info before deletion to know which category
    $product = $this->product_model->get_by_id($id);
    
    if (!$product) {
        echo json_encode(['stt' => 'error', 'msg' => 'Product not found']);
        return;
    }

    $deleted = $this->product_model->delete($id);

    if ($deleted) {
        // Update using sub_category_id
        $this->update_super_category_item_count($product['sub_category_id']);
        echo json_encode(['stt' => 'ok', 'msg' => 'Product deleted successfully']);
    } else {
        echo json_encode(['stt' => 'error', 'msg' => 'Failed to delete product']);
    }
}
	
	public function toggle_status()
{
    $id = $this->input->post('id');
    $product = $this->product_model->get_by_id($id);
    
    if (!$product) {
        echo json_encode(['stt' => 'error', 'msg' => 'Product not found']);
        return;
    }
    
    $new_status = ($product['status'] === 'active') ? 'inactive' : 'active';
    
    $updated = $this->product_model->update($id, [
        'status' => $new_status,
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
    if ($updated) {
        // Update using sub_category_id
        $this->update_super_category_item_count($product['sub_category_id']);
        echo json_encode(['stt' => 'ok', 'msg' => 'Status updated']);
    } else {
        echo json_encode(['stt' => 'error', 'msg' => 'Failed to update status']);
    }
}

/**
 * Update serial tracking status for a product
 */
public function update_serial_tracking()
{
    $id = $this->input->post('id');
    $is_serial_trk = $this->input->post('is_serial_trk') ? 1 : 0;
    
    if (!$id) {
        echo json_encode(['stt' => 'error', 'msg' => 'Product ID required']);
        return;
    }
    
    // Check if product exists
    if (!$this->product_model->exists($id)) {
        echo json_encode(['stt' => 'error', 'msg' => 'Product not found']);
        return;
    }
    
    $updated = $this->product_model->update($id, [
        'is_serial_trk' => $is_serial_trk,
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
    if ($updated) {
        echo json_encode(['stt' => 'ok', 'msg' => 'Serial tracking updated successfully']);
    } else {
        echo json_encode(['stt' => 'error', 'msg' => 'Failed to update serial tracking']);
    }
}

/**
 * Update super_category item count after product changes
 * @param int $sub_category_id - The sub_category.id (from products.sub_category_id column)
 */
private function update_super_category_item_count($sub_category_id)
{
    if (!$sub_category_id) {
        return;
    }
    
    // Get the super_category_id from sub_category table
    $sub_category = $this->db
        ->select('super_category_id')
        ->where('id', $sub_category_id)
        ->get('sub_category')
        ->row();
    
    if ($sub_category && $sub_category->super_category_id) {
        $this->super_category->update_item_count($sub_category->super_category_id);
    }
}
}