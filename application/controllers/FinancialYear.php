<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FinancialYear extends BaseApiController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/FinancialYear_model');
    }

    public function create()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['year_name']) || empty($request['start_date']) || empty($request['end_date'])) {
                $this->respond(400, $this->error('Missing required fields'));
            }

            $response = $this->FinancialYear_model->create_year($request);

            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    public function activate()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['id'])) {
                $this->respond(400, $this->error('Financial year ID required'));
            }

            $response = $this->FinancialYear_model->activate_year($request);

            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    public function close()
    {
        try {

            $request = $this->get_json_input();

            if (empty($request['id'])) {
                $this->respond(400, $this->error('Financial year ID required'));
            }

            $response = $this->FinancialYear_model->close_year($request);

            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }

    public function list()
    {
        try {

            $response = $this->FinancialYear_model->get_years();
            $this->respond(200, $response);

        } catch (Exception $e) {

            log_message('error', $e->getMessage());
            $this->respond(500, $this->error('Internal Server Error'));
        }
    }
}