<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_charts extends CI_Controller {
	
	public function index()
    {
		$this->load->view('header');
		$this->load->view('Accounting/accounts_list');
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
	
	public function create()
    {
		$this->load->model('accounting/Accounts_model');
		$this->Accounts_model->create_account();
	}
	
	public function journal_entry(){
		$this->load->view('header');
		$this->load->view('Accounting/journal_entry');
		$this->load->view('footer');
	}

	public function journal_list(){
		$this->load->view('header');
		$this->load->view('Accounting/journal_list');
		$this->load->view('footer');
	} 
	
	public function journal_view(){
		$this->load->view('header');
		$this->load->view('Accounting/journal_view');
		$this->load->view('footer');
	} 
	

}