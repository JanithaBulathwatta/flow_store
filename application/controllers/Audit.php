<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends BaseApiController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/Audit_model');
    }

    /* ==============================
       ACCOUNTING EVENT LOGS
    ============================== */

    public function event_logs()
    {
        try {

            $request = $this->get_json_input();
            $response = $this->Audit_model->get_event_logs($request);
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       API REQUEST LOGS
    ============================== */

    public function api_logs()
    {
        try {

            $request = $this->get_json_input();
            $response = $this->Audit_model->get_api_logs($request);
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       YEAR END LOGS
    ============================== */

    public function year_end_logs()
    {
        try {

            $response = $this->Audit_model->get_year_end_logs();
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}