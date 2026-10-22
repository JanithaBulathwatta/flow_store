<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security_settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Load helpers and libraries
        $this->load->helper('url');
        $this->load->model('Security_settings_model', 'security_model');
        $this->load->library('SmsSender'); // Load the existing SMS library
        
        // Auth check - ensure user is logged in
        if (!$this->session->userdata('login')) {
            redirect('auth/login');
        }
    }

    private function _uid() {
        return (int)$this->session->userdata('uid');
    }

    private function _json($data) {
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($data));
    }

    // Main page
    public function index() {
        // Check if this is first login
        $is_first_login = $this->security_model->is_first_login($this->_uid());
        
        // Get current session ID
        $current_session_id = session_id();
        
        // Get security overview
        $data = $this->security_model->get_security_overview($this->_uid(), $current_session_id);
        
        if (!$data) {
            show_error('User not found', 404);
            return;
        }
        
        $data['is_first_login'] = $is_first_login;
        
        // Load views
        $this->load->view('header', $data);
        $this->load->view('Security_settings', $data);
        $this->load->view('footer');
    }

    // Change password
    public function change_password() {
        $current = $this->input->post('current_password');
        $new = $this->input->post('new_password');
        
        if (!$current || !$new) {
            return $this->_json(['success' => false, 'message' => 'Missing fields.']);
        }
        
        $result = $this->security_model->change_password($this->_uid(), $current, $new);
        $this->_json($result);
    }

    // Set 2FA
    public function set_tfa() {
        $enabled = (bool)$this->input->post('enabled');
        $result = $this->security_model->set_tfa($this->_uid(), $enabled);
        $this->_json($result);
    }

    // Send OTP
    public function send_otp() {
        $phone = trim($this->input->post('phone'));
        
        if (!$phone) {
            return $this->_json(['success' => false, 'message' => 'Phone number required.']);
        }
        
        // Validate phone number format
        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            return $this->_json(['success' => false, 'message' => 'Invalid phone number format.']);
        }
        
        $result = $this->security_model->send_otp($this->_uid(), $phone);
        $this->_json($result);
    }

    // Verify OTP
    public function verify_otp() {
        $phone = trim($this->input->post('phone'));
        $otp = trim($this->input->post('otp'));
        
        if (!$phone || !$otp) {
            return $this->_json(['success' => false, 'message' => 'Missing fields.']);
        }
        
        $result = $this->security_model->verify_otp($this->_uid(), $phone, $otp);
        $this->_json($result);
    }

    // Set secret question
    public function set_secret_question() {
        $question = $this->input->post('question');
        $answer = $this->input->post('answer');
        
        if (!$question || !$answer) {
            return $this->_json(['success' => false, 'message' => 'Missing fields.']);
        }
        
        $result = $this->security_model->set_secret_question($this->_uid(), $question, $answer);
        $this->_json($result);
    }

    // Get active sessions
    public function get_sessions() {
        $current_session_id = session_id();
        $sessions = $this->security_model->get_active_sessions($this->_uid(), $current_session_id);
        $this->_json(['success' => true, 'sessions' => $sessions]);
    }

    // Revoke a session
    public function revoke_session() {
        $session_id = $this->input->post('session_id');
        
        if (!$session_id) {
            return $this->_json(['success' => false, 'message' => 'Missing session_id.']);
        }
        
        $result = $this->security_model->revoke_session($session_id, $this->_uid());
        $this->_json($result);
    }

    // Complete security setup (called when user finishes)
    public function complete_setup() {
        $this->security_model->complete_security_setup($this->_uid());
        $this->_json(['success' => true, 'message' => 'Setup completed']);
    }
    
    // Skip security setup (for first login)
    public function skip_setup() {
        $this->security_model->update_login_count($this->_uid(), true);
        $this->_json(['success' => true, 'message' => 'Setup skipped']);
    }
}