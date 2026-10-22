<?php
require_once(APPPATH.'controllers/BaseApiController.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends BaseApiController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/Accounting_model');
    }

    /* ==============================
       POST EVENT
    ============================== */

    public function post()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['function']) || empty($request['payload'])) {
                $this->respond(400, $this->error('Invalid request structure'));
            }

            // Idempotency Key (Recommended for Financial Safety)
            $idempotency_key = $this->input->get_request_header('X-IDEMPOTENCY-KEY');

            if (!$idempotency_key) {
                $this->respond(400, $this->error('Missing Idempotency Key'));
            }

            $response = $this->Accounting_model->handle_request($request, $idempotency_key);

            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       REVERSE ENTRY
    ============================== */

    public function reverse()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['journal_no'])) {
                $this->respond(400, $this->error('Journal number required'));
            }

            $response = $this->Accounting_model->reverse_entry($request);

            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}