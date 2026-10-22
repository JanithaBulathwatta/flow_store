<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Core
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

        // Model
        $this->load->model('crm/Product_model', 'product');

        // Auth check
        /*if (!$this->session->userdata('user_id')) {
            redirect('login');
        }*/
    }

    /**
     * List products
     */
    public function index()
    {
        $data = ['page_title' => 'Products','products'   => $this->product->get_all()];
		$this->load->view('header');
        $this->load->view('crm/products/index', $data);
		$this->load->view('footer');
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data['page_title'] = 'Create Product';
        $this->load->view('header');
		$this->load->view('crm/products/create', $data);
		$this->load->view('footer');
	}

    /**Store product**/
    public function store()
    {
        $this->_set_validation_rules();

        if ($this->form_validation->run() === FALSE) {
            return $this->create();
        }

        $data = [
            'name'        => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'price'       => $this->input->post('price'),
            'is_active'   => 1
        ];

        $this->product->create($data);

        $this->session->set_flashdata('success', 'Product created successfully');
        //redirect('products');
		
		//echo json_encode('Product created successfully');
		echo json_encode(['success' => true,'message' => 'Product Created successfully']);
	}

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $product = $this->product->get_by_id((int)$id);

        if (!$product) {
            show_404();
        }

        $data = [
            'page_title' => 'Edit Product',
            'product'    => $product
        ];

		$this->load->view('header');
        $this->load->view('crm/products/edit', $data);
		$this->load->view('footer');
	}

    /**
     * Update product
     */
    public function update($id)
    {
        $this->_set_validation_rules();

        if ($this->form_validation->run() === FALSE) {
            return $this->edit($id);
        }

        $data = [
            'name'        => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'price'       => $this->input->post('price'),
            'is_active'   => (int) $this->input->post('is_active')
        ];

        $this->product->update((int)$id, $data);

        $this->session->set_flashdata('success', 'Product updated successfully');
        //redirect('products');
		//echo json_encode('Product Updated successfully');
		echo json_encode(['success' => true,'message' => 'Product Updated successfully']);
	}

	private function _json($data)
	{
		header('Content-Type: application/json');
		echo json_encode($data);
		exit;
	}


	public function delete($id)
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		$id = (int)$id;

		if (!$this->product->exists($id)) {
			return $this->_json([
				'success' => false,
				'message' => 'Product not found'
			]);
		}

		$this->product->delete($id);

		return $this->_json([
			'success' => true,
			'message' => 'Product deleted successfully'
		]);
	}


    /**
     * Validation rules
     */
    private function _set_validation_rules()
    {
        $this->form_validation->set_rules('name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'numeric');
    }
	
	public function get($id)		
	{
		$product = $this->product->get_by_id((int)$id);

		echo json_encode($product);
	}

	
}
