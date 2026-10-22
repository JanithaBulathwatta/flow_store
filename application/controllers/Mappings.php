<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mappings extends BaseApiController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/Mappings_model');
    }

    /* ==============================
       CREATE MAPPING
    ============================== */

    public function create()
    {
        try {

            $request = $this->get_json_input();

            if (
                empty($request['event_code']) ||
                empty($request['line_type']) ||
                empty($request['account_source_type']) ||
                empty($request['amount_source_field'])
            ) {
                $this->respond(400, $this->error('Missing required fields'));
            }

            $response = $this->Mappings_model->create_mapping($request);

            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       UPDATE MAPPING
    ============================== */

    public function update()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['id'])) {
                $this->respond(400, $this->error('Mapping ID required'));
            }

            $response = $this->Mappings_model->update_mapping($request);

            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       LIST MAPPINGS
    ============================== */

    public function list()
    {
        try {

            $response = $this->Mappings_model->get_mappings();
            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       MANAGE CONDITIONS
    ============================== */

    public function conditions()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['mapping_id'])) {
                $this->respond(400, $this->error('Mapping ID required'));
            }

            $response = $this->Mappings_model->manage_conditions($request);

            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}