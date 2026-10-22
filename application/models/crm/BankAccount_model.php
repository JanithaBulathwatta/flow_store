<?php
//madhushika(2026-03-10)
		defined('BASEPATH') OR exit('No direct script access allowed');

		class BankAccount_model extends CI_Model {

			protected $table = 'bank_accounts';

			public function __construct() {
				parent::__construct();
				$this->load->model('accounting/Accounts_model');
			}

			/*public function get_all()
			{
				return $this->db
					->select('
					ba.bank_acc_id,
					b.bank_name,
					ba.branch_name,
					ba.account_name,
					ba.account_number,
					ba.current_balance,
					ba.od_limit,
					ba.account_type,
					ba.account_nickname
					')
            ->from('bank_accounts ba')
            ->join('banks b','b.bank_id = ba.bank_id','left')
            ->where_in('ba.status',['active','inactive'])
            ->order_by('ba.bank_acc_id','DESC')
            ->get()
            ->result();
			
			$user_id_fk = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('ut_id');
			$this->load->model('Activity_log_m');
			$this->Activity_log_m->addLog($user_id_fk,$user_type,'Bank Account Module','BANK Accounts','READ');
			
    }*/
	
	public function get_all()
	{
		// Log the activity first (before returning)
		/*$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk, $user_type, 'Bank Account Module', 'BANK Accounts', 'READ');*/

		return $this->db
			->select('
				ba.bank_acc_id,
				b.bank_name,
				ba.branch_name,
				ba.account_name,
				ba.account_number,
				ba.current_balance,
				ba.od_limit,
				ba.account_type,
				ba.account_nickname
			')
			->from('bank_accounts ba')
			->join('banks b', 'b.bank_id = ba.bank_id', 'left')
			->where_in('ba.status', ['active', 'inactive'])
			//->where('ba.account_type !=', 'pay') // This excludes the pay type
			->where('ba.account_type', 'od') // This excludes the pay type
			->order_by('ba.bank_acc_id', 'DESC')
			->get()
			->result();
	}
	
	public function get_pay_accounts()
	{
		// Log the activity
		/*$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk, $user_type, 'Bank Account Module', 'Pay Accounts', 'READ');*/

		return $this->db
			->select('
				ba.bank_acc_id,
				b.bank_name,
				ba.branch_name,
				ba.account_name,
				ba.account_number,
				ba.current_balance,
				ba.od_limit,
				ba.account_type,
				ba.account_nickname
			')
			->from('bank_accounts ba')
			->join('banks b', 'b.bank_id = ba.bank_id', 'left')
			->where_in('ba.status', ['active', 'inactive'])
			->where('ba.account_type', 'pay') // This gets ONLY pay accounts
			->order_by('ba.bank_acc_id', 'DESC')
			->get()
			->result();
	}

public function create()
{
    // Get form data with validation
    $bank_id = $this->input->post('bank_id', TRUE);
    $account_name = $this->input->post('account_name', TRUE);
    $account_number = $this->input->post('account_number', TRUE);
    $branch_name = $this->input->post('branch_name', TRUE);
    $account_nickname = $this->input->post('account_nickname', TRUE);
    $account_type = $this->input->post('account_type', TRUE);
    $current_balance = $this->input->post('current_balance', TRUE);
    $od_limit = $this->input->post('od_limit', TRUE);
    
    // VALIDATION - Check required fields
    if (empty($bank_id)) {
        echo json_encode(["stt" => "error", "msg" => "Bank is required. Please select a bank."]);
        return false;
    }
    
    if (empty($account_name)) {
        echo json_encode(["stt" => "error", "msg" => "Account name is required."]);
        return false;
    }
    
    if (empty($account_number)) {
        echo json_encode(["stt" => "error", "msg" => "Account number is required."]);
        return false;
    }
    
    // Verify that the selected bank exists in the banks table
    $bank_exists = $this->db
        ->where('bank_id', $bank_id)
        ->where('status', 'active')
        ->get('banks')
        ->num_rows();
    
    if ($bank_exists == 0) {
        echo json_encode(["stt" => "error", "msg" => "Selected bank does not exist in the system."]);
        return false;
    }
    
    // Prepare data array (removed duplicate current_balance)
    $data = [
        'bank_id' => $bank_id,
        'branch_name' => $branch_name,
        'account_name' => $account_name,
        'account_number' => $account_number,
        'account_nickname' => $account_nickname,
        'account_type' => $account_type,
        'current_balance' => !empty($current_balance) ? $current_balance : 0,
        'od_limit' => !empty($od_limit) ? $od_limit : 0,
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    // Insert into database
    $this->db->insert($this->table, $data);
    $insert_id = $this->db->insert_id();
    
    if($insert_id){
        // ================== CREATE ACCOUNT MAPPING ==================
        $account_class = 1; // LIABILITY
        $account_type  = 'ASSET';
        $parent_id = 4;
        
        // Calculate level
        $parent = $this->db->get_where('accounts', ['id' => $parent_id])->row_array();
        $level = $parent ? $parent['level'] + 1 : 1;
        
        $old_post = $_POST;
        
        $_POST = array_merge($_POST, [
            'account_name' => $this->input->post('account_nickname', TRUE) ?: $this->input->post('account_name', TRUE),
            'account_class' => $account_class,
            'account_type' => $account_type,
            'parent_id' => $parent_id,
            'is_posting' => 1,
            'is_control_account' => 0,
            'level' => $level
        ]);
        
        $this->Accounts_model->create_account();
        $_POST = $old_post;
        // ================== END OF CREATE ACCOUNT ==================
        
        // Log activity
        $user_id_fk = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('ut_id');
        $this->load->model('Activity_log_m');
        $this->Activity_log_m->addLog($user_id_fk, $user_type, 'Bank Account Module', 'Create Bank Account', 'INSERT');
        
        echo json_encode(["stt"=>"ok", "msg"=>"Account Created Successfully", "data"=>$insert_id]);
    } else {
        echo json_encode(["stt"=>"error", "msg"=>"Database Error: Could not create account", "data"=>'']);
    }
}

public function update()
{
    $id = $_POST['lid'];
    
    if (empty($id)) {
        echo json_encode(["stt" => "error", "msg" => "Account ID is missing"]);
        return false;
    }
    
    // Get form data with validation
    $bank_id = $this->input->post('bank_id', TRUE);
    $account_name = $this->input->post('account_name', TRUE);
    $account_number = $this->input->post('account_number', TRUE);
    $branch_name = $this->input->post('branch_name', TRUE);
    $account_nickname = $this->input->post('account_nickname', TRUE);
    $account_type = $this->input->post('account_type', TRUE);
    $od_limit = $this->input->post('od_limit', TRUE);
    
    // VALIDATION - Check required fields
    if (empty($bank_id)) {
        echo json_encode(["stt" => "error", "msg" => "Bank is required. Please select a bank."]);
        return false;
    }
    
    if (empty($account_name)) {
        echo json_encode(["stt" => "error", "msg" => "Account name is required."]);
        return false;
    }
    
    if (empty($account_number)) {
        echo json_encode(["stt" => "error", "msg" => "Account number is required."]);
        return false;
    }
    
    // Verify that the selected bank exists
    $bank_exists = $this->db
        ->where('bank_id', $bank_id)
        ->where('status', 'active')
        ->get('banks')
        ->num_rows();
    
    if ($bank_exists == 0) {
        echo json_encode(["stt" => "error", "msg" => "Selected bank does not exist in the system."]);
        return false;
    }
    
    // Check if account exists
    $account_exists = $this->db
        ->where('bank_acc_id', $id)
        ->where_in('status', ['active', 'inactive'])
        ->get($this->table)
        ->num_rows();
    
    if ($account_exists == 0) {
        echo json_encode(["stt" => "error", "msg" => "Account not found"]);
        return false;
    }
    
    // Prepare data array (Note: current_balance is NOT updated here typically)
    $data = [
        'bank_id' => $bank_id,
        'branch_name' => $branch_name,
        'account_name' => $account_name,
        'account_number' => $account_number,
        'account_nickname' => $account_nickname,
        'account_type' => $account_type,
        'od_limit' => !empty($od_limit) ? $od_limit : 0,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    // Update database
    $this->db->where('bank_acc_id', $id);
    $result = $this->db->update($this->table, $data);
    
    if($result) {
        // Log activity
        $user_id_fk = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('ut_id');
        $this->load->model('Activity_log_m');
        $this->Activity_log_m->addLog($user_id_fk, $user_type, 'Bank Account Module', 'Update Bank Account', 'UPDATE');
        
        echo json_encode(["stt"=>"ok", "msg"=>"Account Updated Successfully", "data"=>$id]);
    } else {
        echo json_encode(["stt"=>"error", "msg"=>"Database Error: Could not update account", "data"=>'']);
    }
}

    public function get_by_id($id)
    {
        return $this->db
            ->select('ba.*,b.bank_name')
            ->from('bank_accounts ba')
            ->join('banks b','b.bank_id = ba.bank_id','left')
            ->where('ba.bank_acc_id',$id)
            ->get()
            ->row();
			
		/*$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Bank Account Module','Access Bank Account Detail','READ');*/
    }

    public function delete($id)
    {
        $this->db->where('bank_acc_id',$id)
            ->update($this->table,['status'=>'deleted']);

        echo json_encode(["stt"=>"ok","msg"=>"Deleted","data"=>$id]);
		
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->load->model('Activity_log_m');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Bank Account Module','Delete Bank Account','DELETE');
		
    }

    public function get_counts()
    {
        $query = $this->db->query("
            SELECT
            COUNT(CASE WHEN status='active' THEN 1 END) active_count,
            COUNT(CASE WHEN status='deleted' THEN 1 END) deleted_count,
            COUNT(*) total_count
            FROM {$this->table}
        ");

        return $query->row();
    }
}