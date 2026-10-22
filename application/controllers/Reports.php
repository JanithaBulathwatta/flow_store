<?php
require_once(APPPATH.'controllers/BaseApiController.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends BaseApiController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/Reports_model');
    }

    /* ==============================
       TRIAL BALANCE
    ============================== */

    public function trial_balance()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['financial_year_id'])) {
                $this->respond(400, $this->error('Financial year required'));
            }

            $response = $this->Reports_model->trial_balance($request);

            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       GENERAL LEDGER
    ============================== */

    public function ledger()
    {
        try {

            $request = $this->get_json_input();

			//print_r ($request['account_id']);
			//exit;

            if (empty($request['account_id'])) {
                $this->respond(400, $this->error('Account ID required'));
            }

            $response = $this->Reports_model->ledger($request);

            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       PROFIT & LOSS
    ============================== */

    public function profit_loss()
    {
        try {

            $request = $this->get_json_input();
            $response = $this->Reports_model->profit_loss($request);
            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       BALANCE SHEET
    ============================== */

    public function balance_sheet()
    {
        try {

            $request = $this->get_json_input();
            $response = $this->Reports_model->balance_sheet($request);
            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       JOURNAL VIEW
    ============================== */

    public function journal()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['journal_no'])) {
                $this->respond(400, $this->error('Journal number required'));
            }

            $response = $this->Reports_model->journal_view($request);

            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}