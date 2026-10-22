<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================================================
       CREATE ACCOUNT
    ============================================================ */

    /*public function create_account($data)
    {
        try {

            $this->db->trans_start();

            // Validate parent
            if (!empty($data['parent_id'])) {

                $parent = $this->db
                    ->get_where('accounts', ['id' => $data['parent_id']])
                    ->row_array();

                if (!$parent) {
                    throw new Exception('Invalid parent account');
                }
            }

            // Generate account number
            $account_number = $this->generate_account_number(
                $data['account_class']
            );

            $insert = [
                'account_number' => $account_number,
                'account_name' => $data['account_name'],
                'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : null,
                'account_class' => $data['account_class'],
                'account_type' => $data['account_type'],
                'is_posting' => isset($data['is_posting']) ? $data['is_posting'] : 1,
                'is_control_account' => isset($data['is_control_account']) ? $data['is_control_account'] : 0,
                'level' => isset($data['level']) ? $data['level'] : 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('accounts', $insert);

            $this->db->trans_complete();

            return ['status' => true,'result_desc' => 'Account created successfully','payload' => ['account_number' => $account_number]];

        } catch (Exception $e) {

            $this->db->trans_rollback();
            log_message('error', $e->getMessage());

            return [
                'status' => false,
                'result_desc' => $e->getMessage(),
                'payload' => null
            ];
        }
    }*/

	public function create_account()
    {
		/*$this->load->library('form_validation');
		$this->form_validation->set_rules('account_name', 'Account Name', 'required');
		$this->form_validation->set_rules('account_class', 'Account Class', 'required');
		$this->form_validation->set_rules('account_type', 'Account Type', 'required');
		$this->form_validation->set_rules('parent_id', 'Perent Account', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['stt' => 'error', 'msg' => validation_errors(), 'data' => '']);
		} else {
			
		}*/
		if (!empty($_POST['parent_id'])) {

			$parent = $this->db->get_where('accounts', ['id' => $_POST['parent_id']])->row_array();

			if (!$parent) {
				throw new Exception('Invalid parent account');
			}
		}

		// Generate account number
		$account_number = $this->generate_account_number($_POST['account_class']);

		$insert = [
			'account_number' => $account_number,
			'account_name' => $_POST['account_name'],
			'parent_id' => isset($_POST['parent_id']) ? $_POST['parent_id'] : null,
			'account_class' => $_POST['account_class'],
			'account_type' => $_POST['account_type'],
			'is_posting' => isset($_POST['is_posting']) ? $_POST['is_posting'] : 1,
			'is_control_account' => isset($_POST['is_control_account']) ? $_POST['is_control_account'] : 0,
			'level' => isset($_POST['level']) ? $_POST['level'] : 1,
			'created_at' => date('Y-m-d H:i:s')
		];

		$this->db->insert('accounts', $insert);
		$id = $this->db->insert_id();
		
		/*if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Account Created Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}*/
    }
	

    /* ============================================================
       GENERATE ACCOUNT NUMBER
    ============================================================ */

    private function generate_account_number($class)
    {
        $this->db->where('account_class', $class);
        $row = $this->db->get('account_auto_sequence')->row_array();

        if (!$row) {
            $this->db->insert('account_auto_sequence', [
                'account_class' => $class,
                'category_code' => 0,
                'last_number' => 1
            ]);
            $number = 1;
        } else {
            $number = $row['last_number'] + 1;

            $this->db->where('id', $row['id']);
            $this->db->update('account_auto_sequence', [
                'last_number' => $number
            ]);
        }

        return sprintf('%d%05d', $class, $number);
    }

    /* ============================================================
       UPDATE ACCOUNT (LIMITED FIELDS ONLY)
    ============================================================ */

    public function update_account($data)
    {
        $allowed = ['account_name','is_active'];

        $update = [];

        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $update[$field] = $data[$field];
            }
        }

        if (empty($update)) {
            return [
                'status' => false,
                'result_desc' => 'Nothing to update',
                'payload' => null
            ];
        }

        $this->db->where('id', $data['id']);
        $this->db->update('accounts', $update);

        return [
            'status' => true,
            'result_desc' => 'Account updated successfully',
            'payload' => null
        ];
    }

    /* ============================================================
       GET ACCOUNTS
    ============================================================ */

    public function get_accounts()
    {
        $accounts = $this->db->order_by('account_number', 'ASC')->get('accounts')->result_array();
        return ['status' => true,'result_desc' => 'Accounts fetched','payload' => $accounts];
    }
}