<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_book_model extends CI_Model {

    // ✅ GET ALL CHEQUE BOOKS
	public function get_all()
	{
		return $this->db
			->select("
				cb.*,
				ba.account_number,
				b.bank_name,

				COUNT(c.id) as total_cheques,

				SUM(c.status = 'unused') as unused,
				SUM(c.status = 'issued') as issued,
				SUM(c.status = 'presented') as presented,
				SUM(c.status = 'cleared') as cleared,
				SUM(c.status = 'bounced') as bounced,
				SUM(c.status = 'cancelled') as cancelled,
				SUM(c.is_hold = 1) as hold_count
			")
			->from('cheque_books cb')
			->join('bank_accounts ba', 'ba.bank_acc_id = cb.bank_account_id')
			->join('banks b', 'b.bank_id = ba.bank_id')
			->join('cheques c', 'c.cheque_book_id = cb.id', 'left')
			->group_by('cb.id')
			->order_by('cb.id', 'DESC')
			->get()
			->result();
	}
	
	//GET CHEQUE BOOK DETAILS BY ID
	public function get_book_by_id($id)
	{
		return $this->db->where('id', (int)$id)->get('cheque_books')->row(); 
	}

    // ✅ CREATE CHEQUE BOOK + AUTO GENERATE CHEQUES
    public function create()
    {
        $data = [
			'bank_account_id' => $this->input->post('bank_account_id'),
			'cheque_book_no'  => $this->input->post('cheque_book_no'),
			'issue_date'      => $this->input->post('issue_date') ?: date('Y-m-d'),
			'received_date'   => $this->input->post('received_date') ?: NULL, 
			'start_cheque_no' => (int)$this->input->post('start_cheque_no'),
			'end_cheque_no'   => (int)$this->input->post('end_cheque_no'),
			'total_leaves'    => ((int)$this->input->post('end_cheque_no') - (int)$this->input->post('start_cheque_no')) + 1,
			'created_at'      => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert('cheque_books', $data);

        if (!$insert) {
            echo json_encode(['stt'=>'error','msg'=>'Book creation failed']);
            return;
        }


        $book_id = $this->db->insert_id();

        //  AUTO GENERATE CHEQUES
        for ($i = $data['start_cheque_no']; $i <= $data['end_cheque_no']; $i++) {
            $this->db->insert('cheques', [
                'cheque_book_id' => $book_id,
                'bank_account_id' => $data['bank_account_id'],
                'cheque_no' => $i,
                'created_by' => $this->session->userdata('user_id')
            ]);
        }

        echo json_encode(['stt'=>'ok','msg'=>'Cheque Book Created']);
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'cheque book Module','Create cheque book','INSERT');
		//end of activity log
    }
	
	 // ✅ HOLD CHEQUE BOOK
	public function hold_book()
	{
		$id = $this->input->post('book_id');
		$reason = $this->input->post('reason');

		$this->db->trans_start();

		//  Update the Book itself
		$this->db->where('id', $id)->update('cheque_books', [
			'status' => 'on_hold',
			'hold_reason' => $reason,
			'updated_at' => date('Y-m-d H:i:s')
		]);

		//  Update all UNUSED cheques in this book to 'hold'
		$this->db->where('cheque_book_id', $id);
		$this->db->where('status', 'unused');
		$this->db->update('cheques', [
			'status' => 'on_hold',
			'is_hold' => 1,
			'hold_reason' => $reason,
			'hold_date' => date('Y-m-d H:i:s')
		]);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(['stt' => 'error', 'msg' => 'Failed to hold the book.']);
		} else {
			echo json_encode(['stt' => 'ok', 'msg' => 'Book and unused cheques are now on hold.']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'cheque book Module','Hold cheque book','UPDATE');
		//end of activity log
	}
	
	//RELEASE CHEQUE BOOK
	public function release_book()
	{
		$id = $this->input->post('book_id');

		$this->db->trans_start();

		// Update the Book status back to active
		$this->db->where('id', $id)->update('cheque_books', [
			'status' => 'active',
			'hold_reason' => NULL,
			'updated_at' => date('Y-m-d H:i:s')
		]);

		// Revert only the cheques that were 'on_hold' back to 'unused'
		$this->db->where('cheque_book_id', $id);
		$this->db->where('status', 'on_hold');
		$this->db->update('cheques', [
			'status' => 'unused',
			'is_hold' => 0,
			'hold_reason' => NULL,
			'hold_date' => NULL
		]);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(['stt' => 'error', 'msg' => 'Failed to release the book.']);
		} else {
			echo json_encode(['stt' => 'ok', 'msg' => 'Book is now active and cheques are released.']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'cheque book Module','Release cheque book','UPDATE');
		//end of activity log
	}


    public function exists($id)
    {
        return $this->db->where('id', $id)->count_all_results('cheque_books') > 0;
    }

    // ✅ GET CHEQUES BY BOOK
	
	public function get_cheques($book_id)
	{
		return $this->db
			->select('
				c.*, 
				cb.cheque_book_no, 
				ba.account_number, 
				ba.account_name,
				b.bank_name,
				ur.full_name as issued_by_name
			')
			->from('cheques c')
			
			->join('cheque_books cb', 'cb.id = c.cheque_book_id', 'left')
			
			->join('bank_accounts ba', 'ba.bank_acc_id = c.bank_account_id', 'left')
			
			->join('banks b', 'b.bank_id = ba.bank_id', 'left')
			
			->join('user ur', 'ur.user_id = c.issued_by', 'left')
			
			->where('c.cheque_book_id', (int)$book_id)
			->order_by('c.cheque_no', 'ASC')
			->get()
			->result();
	}
	
	//✅ GET USER INFORMATION

	public function user(){
		return $this->db->select('u.*,ut.ut_name')
						->from('user u')
						->join('sys_user_type ut','ut.ut_id = u.ut_id','left')
						->get()
						->result();
	}

    // ✅ UPDATE CHEQUE STATUS

	public function update_status()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$remarks = $this->input->post('remarks');

		$old = $this->db->where('id', $id)->get('cheques')->row();
		if (!$old) {
			echo json_encode(['stt'=>'error','msg'=>'Cheque not found']);
			return;
		}

		$data = ['status' => $status];

		// ✅ IMPORTANT: If changing status, we must release the hold flags
		if ($status !== 'on_hold') {
			$data['is_hold'] = 0;
			$data['hold_reason'] = NULL;
			$data['hold_date'] = NULL;
		}

		// ✅ ISSUE DATA
		if ($status == 'issued') {
			$data['issued_date'] = date('Y-m-d H:i:s');
			$data['payee_name']  = $this->input->post('payee_name');
			$data['amount']      = max(0, (float)$this->input->post('amount')); // Prevent negative
			$data['cheque_date'] = $this->input->post('cheque_date');
			$data['voucher_id']  = $this->input->post('voucher_ref');
			$data['issued_by']   = $this->session->userdata('user_id');
		}
		
		// ✅ HOLD DATA
		if ($status == 'on_hold') {
			$data['is_hold'] = 1;
			$data['hold_reason'] = $remarks;
			$data['hold_date']   = date('Y-m-d H:i:s');
			$data['hold_by']     = $this->session->userdata('user_id');
		}

		// ... (rest of your status checks: presented, cleared, etc.)

		$this->db->where('id', $id);
		if ($this->db->update('cheques', $data)) {
			$this->db->insert('cheque_status_logs', [
				'cheque_id'  => $id,
				'old_status' => $old->status,
				'new_status' => $status,
				'remarks'    => $remarks,
				'changed_by' => $this->session->userdata('user_id')
			]);
			echo json_encode(['stt'=>'ok','msg'=>'Status Updated Successfully']);
		} else {
			echo json_encode(['stt'=>'error','msg'=>'Update failed']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'cheque book Module','Change cheque status','UPDATE');
		//end of activity log
	}


    // ✅ GET LOGS
	
	public function get_logs()
	{
		return $this->db
			->select('l.*, c.cheque_no, cb.cheque_book_no, ur.full_name as issued_by_name, ut.ut_name as user_role_name')
			->from('cheque_status_logs l')
			->join('cheques c', 'c.id = l.cheque_id', 'left')
			->join('cheque_books cb', 'cb.id = c.cheque_book_id', 'left')
			->join('user ur', 'ur.user_id = l.changed_by', 'left')
			->join('sys_user_type ut', 'ut.ut_id = ur.ut_id', 'left')
			->order_by('l.id', 'DESC')
			->get()
			->result();
	}
	
	public function get_cheque_amount_summary($book_id = null) {
		$data = [];

		// Card 1: Total Issued Amount (Issued + Presented + Bounced + On Hold)
		$this->db->select_sum('amount');
		if ($book_id) {
			$this->db->where('cheque_book_id', $book_id);
		}
		// We include everything except 'unused' and 'cleared' to get the full issued snapshot
		$this->db->where_in('status', ['issued', 'presented', 'bounced', 'on_hold']);
		$res = $this->db->get('cheques')->row();
		$data['total_issued'] = $res->amount ?? 0.00;

		// Card 2: Total Cleared Amount
		$this->db->select_sum('amount');
		if ($book_id) {
			$this->db->where('cheque_book_id', $book_id);
		}
		$this->db->where('status', 'cleared');
		$res = $this->db->get('cheques')->row();
		$data['total_cleared'] = $res->amount ?? 0.00;

		return (object) $data;
	}
}