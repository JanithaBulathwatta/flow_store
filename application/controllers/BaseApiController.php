<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseApiController extends CI_Controller {
	
    protected $client;

    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');

        $this->load->database();
        $this->load->model('accounting/ApiClients_model');

       // $this->authenticate();
    }

    /* ==============================
       AUTHENTICATION
    ============================== */

    protected function authenticate()
    {
        $client_key = $this->input->get_request_header('X-CLIENT-KEY');
        $client_secret = $this->input->get_request_header('X-CLIENT-SECRET');

        if (!$client_key || !$client_secret) {
            $this->respond(401, $this->error('Unauthorized'));
        }

        $client = $this->ApiClients_model->validate_client($client_key, $client_secret);

        if (!$client) {
            $this->respond(401, $this->error('Invalid API Credentials'));
        }

        $this->client = $client;
    }

    /* ==============================
       JSON INPUT VALIDATION
    ============================== */

    protected function get_json_input()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->respond(400, $this->error('Invalid JSON format'));
        }

        return $data;
    }

    /* ==============================
       RESPONSE HANDLER
    ============================== */

    protected function respond($http_code, $body)
    {
        http_response_code($http_code);
        echo json_encode($body);
        exit;
    }

    protected function success($desc, $payload = [])
    {
        return [
            'status' => true,
            'result_desc' => $desc,
            'payload' => $payload
        ];
    }

    protected function error($desc, $code = null)
    {
        return [
            'status' => false,
            'result_desc' => $desc,
            'error_code' => $code,
            'payload' => null
        ];
    }
}