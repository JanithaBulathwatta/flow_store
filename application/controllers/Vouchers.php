<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends BaseApiController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/Vouchers_model');
    }

    /* ==============================
       CREATE VOUCHER TYPE
    ============================== */

    public function create()
    {
        try {

            $request = $this->get_json_input();

            if (
                empty($request['code']) ||
                empty($request['name']) ||
                empty($request['prefix'])
            ) {
                $this->respond(400, $this->error('Missing required fields'));
            }

            $response = $this->Vouchers_model->create($request);
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       LIST VOUCHER TYPES
    ============================== */

    public function list()
    {
        try {

            $response = $this->Vouchers_model->get_all();
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    /* ==============================
       UPDATE VOUCHER TYPE
    ============================== */

    public function update()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['id'])) {
                $this->respond(400, $this->error('Voucher ID required'));
            }

            $response = $this->Vouchers_model->update($request);
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}