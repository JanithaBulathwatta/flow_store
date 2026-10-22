<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends BaseApiController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/Configuration_model');
    }

    /* ==============================
       GET ALL CONFIG
    ============================== */

    public function get()
    {
        try {

            $response = $this->Configuration_model->get_all();
            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       UPDATE CONFIG
    ============================== */

    public function update()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['config_key'])) {
                $this->respond(400, $this->error('Config key required'));
            }

            $response = $this->Configuration_model->update_config($request);

            $this->respond(200, $response);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}