<?php
require_once(APPPATH.'controllers/BaseApiController.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends BaseApiController{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/Accounts_model');
    }

    /*public function create()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['account_name']) || empty($request['account_class'])) {
                $this->respond(400, $this->error('Missing required fields'));
            }

            $response = $this->Accounts_model->create_account($request);
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }*/

	public function create()
    {
		$this->Accounts_model->create_account();
	}
	
    public function update()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['id'])) {
                $this->respond(400, $this->error('Account ID required'));
            }

            $response = $this->Accounts_model->update_account($request);

            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    public function list()
    {
        try {

            $response = $this->Accounts_model->get_accounts();
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    public function tree()
    {
        try {

            $response = $this->Accounts_model->get_account_tree();
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}