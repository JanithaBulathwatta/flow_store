<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Journal extends CI_Controller {
	
	public function journal_entry(){
		$this->load->view('header');
		$this->load->view('Accounting/journal_entry');
		$this->load->view('footer');
	}

	public function post()
    {
        // Idempotency Key (Recommended for Financial Safety)
		$idempotency_key = $this->input->get_request_header('X-IDEMPOTENCY-KEY');

		if (!$idempotency_key) {
			$this->respond(400, $this->error('Missing Idempotency Key'));
		}
		
		print_r($idempotency_key);
		exit;

		$response = $this->Accounting_model->handle_request($idempotency_key);
    }

	public function journal_list(){
		$this->load->view('header');
		$this->load->view('Accounting/journal_list');
		$this->load->view('footer');
	} 
	
	public function accounts_tree(){
		$this->load->view('header');
		$this->load->view('Accounting/accounts_tree');
		$this->load->view('footer');
	}
	
	public function create_account(){
		$this->load->view('header');
		$this->load->view('Accounting/account_form');
		$this->load->view('footer');
	}
	
	public function journal_view(){
		$this->load->view('header');
		$this->load->view('Accounting/journal_view');
		$this->load->view('footer');
	}

}