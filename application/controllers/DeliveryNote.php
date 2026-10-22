<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryNote extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Grn_model');
        $this->load->model('crm/DeliveryNote');
   

        // Example auth check
        if (!$this->session->userdata('user_id')) {
            $this->response('unauth', [], 'Unauthorized', 401);
            exit;
        }
    }
	public function index()
		{

		
		//$this->load->view('delivery_note/header');
		$this->load->view('delivery_note/delivery_note' );
		//$this->load->view('delivery_note/footer');		
			
				
		}