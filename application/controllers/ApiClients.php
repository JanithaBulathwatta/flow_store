<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiClients extends BaseApiController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/ApiClients_model');
    }

    /* ==============================
       CREATE API CLIENT
    ============================== */

    public function create()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['description'])) {
                $this->respond(400, $this->error('Description required'));
            }

            $response = $this->ApiClients_model->create($request);
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       LIST CLIENTS
    ============================== */

    public function list()
    {
        try {

            $response = $this->ApiClients_model->get_all();
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       DEACTIVATE CLIENT
    ============================== */

    public function deactivate()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['id'])) {
                $this->respond(400, $this->error('Client ID required'));
            }

            $response = $this->ApiClients_model->deactivate($request);
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}