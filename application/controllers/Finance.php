<?php
//madhushika(2026-03-10)
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('crm/BankAccount_model');
        $this->load->model('crm/Check_book_model');
        $this->load->model('crm/Bank_model');
        $this->load->model('crm/Common_m');
        $this->load->model('crm/Voucher_model');

    }
	public function index()
	{
		//redirect('Finance/bank_accounts');
	}
    public function bank_accounts()
    {
        $banks = $this->db->get_where('banks',['status'=>'active'])->result();
        $counts = $this->BankAccount_model->get_counts();

        $data = ['page_title' => 'Bank Accounts','banks' => $banks,'counts' => $counts];

        $this->load->view('header');
        $this->load->view('crm/finance/bank_accounts',$data);
        $this->load->view('footer');
    }

    public function get_accounts()
    {
        $data = $this->BankAccount_model->get_all();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => $data
            ]));
    }

	public function store_account()
	{	
		// Ensure JSON response
		$this->output->set_content_type('application/json');
		
		if($_POST['lid'] != ''){
			$this->BankAccount_model->update();
		}else{
			$this->BankAccount_model->create();
		}
	}

    public function view_account()
    {
        $id = $_GET['lid'];

        $account = $this->BankAccount_model->get_by_id((int)$id);

        if(!$account){
            show_404();
        }

        echo json_encode(['account'=>$account]);
    }

    public function delete_account()
    {
        $id = $_GET['lid'];

        $this->BankAccount_model->delete($id);
    }
	
	
	// ===========================
    // ✅ CHEQUE BOOK CODES ARE STARTING HERE ----> //santhosh(2026-03-18)
    // ===========================
	
	// check_book
	public function check_book (){
		
		$bank_Ac = $this->BankAccount_model->get_all();
		$bnaks = $this->Bank_model->get_active_banks();
		
        

        $data = ['page_title' => 'Bank Accounts','banks_Ac' => $bank_Ac,'bnaks' => $bnaks];
		
		$this->load->view('header');
        $this->load->view('crm/check_book/check_book',$data);
		$this->load->view('footer');
		
	}
	
	// cheque list
	public function cheque_list(){
		
		$book_id = $this->input->get('book');
		
		$data['selected_book'] = $this->Check_book_model->get_book_by_id($book_id);
		$data['voucher'] = $this->Voucher_model->get_all();
		
		$this->load->view('header');
        $this->load->view('crm/check_book/cheque_list',$data);
		$this->load->view('footer');
	} 
	

	// cheque log 
		public function cheque_log(){
			
		
		$data['roles'] = $this->Check_book_model->user();
			
		$this->load->view('header');
        $this->load->view('crm/check_book/cheque_log',$data);
		$this->load->view('footer');
	}
	
	// print cheque page
	public function print_cheque() {
		
		$this->load->helper('number');
		
		$cheque_id = $this->input->get('cheque');
		
		$data['cheque'] = $this->db->where('id', $cheque_id)->get('cheques')->row();
		$data['templates'] = $this->db->get('cheque_templates')->result();
		$this->load->view('crm/check_book/print_cheque_view', $data);
	}	
	
	// ===========================
    // ✅ CHEQUE BOOK APIs
    // ===========================
    public function get_books()
    {
        if (ob_get_length()) ob_clean();

        $data = $this->Check_book_model->get_all();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data'=>$data]));
    }

    public function store_book()
    {

        $this->Check_book_model->create();
        
    }
	
	//HOLD CHEQUE BOOK
	public function hold_book_action()
	{
		if (ob_get_length()) ob_clean();
		$this->Check_book_model->hold_book();
	}
	
	//RELEASE CHEQUE BOOK
	public function release_book_action()
	{
		if (ob_get_length()) ob_clean();
		$this->Check_book_model->release_book();
	}



    // ===========================
    // CHEQUE APIs
    // ===========================
    public function get_cheques()
    {
        if (ob_get_length()) ob_clean();

        $book_id = $this->input->get('book');

        $data = $this->Check_book_model->get_cheques($book_id);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data'=>$data]));
    }

    public function update_cheque_status()
    {
        if (ob_get_length()) ob_clean();

        $this->Check_book_model->update_status();
    }


    // ===========================
    // ✅ LOGS
    // ===========================
    public function get_logs()
    {
        if (ob_get_length()) ob_clean();

        $data = $this->Check_book_model->get_logs();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data'=>$data]));
    }
	
	
	public function get_amount_summary() {
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		$book_id = $this->input->get('book');
		$summary = $this->Check_book_model->get_cheque_amount_summary($book_id);

		$formatted_data = [
			['name' => 'total_issued',  'total' => $summary->total_issued],
			['name' => 'total_cleared', 'total' => $summary->total_cleared]
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($formatted_data));
	}

	
}