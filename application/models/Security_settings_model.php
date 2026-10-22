<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security_settings_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('SmsSender'); // Load SMS library
    }

    // Get user by ID
    private function _get_user($user_id) {
        return $this->db
            ->select('user_id, password, phone, email, full_name, tfa_enabled, phone_verified, secret_question, secret_answer, login_count, otp_code, otp_expire')
            ->where('user_id', $user_id)
            ->get('user')
            ->row();
    }

    // Get security overview with sessions from activity_log
    public function get_security_overview($user_id, $current_session_id = null) {
        $user = $this->_get_user($user_id);
        
        if (!$user) {
            return null;
        }
        
        // Get active sessions from activity_log (last 24 hours)
        $sessions = $this->get_active_sessions($user_id, $current_session_id);
        
        return [
            'tfa_enabled' => (bool)$user->tfa_enabled,
            'phone' => $user->phone,
            'phone_verified' => (bool)$user->phone_verified,
            'sq_is_set' => !empty($user->secret_question),
            'sq_question' => $user->secret_question ?? null,
            'login_count' => (int)$user->login_count,
            'sessions' => $sessions,
            'email' => $user->email,
            'full_name' => $user->full_name
        ];
    }

    // Get active sessions from activity_log table
    public function get_active_sessions($user_id, $current_session_id = null) {
        // Get unique sessions from last 24 hours
        $query = $this->db
            ->select('session_id, ip_address, user_agent, MAX(created_at) as last_active, COUNT(*) as activity_count')
            ->where('user_id_fk', $user_id)
            ->where('created_at >', date('Y-m-d H:i:s', strtotime('-24 hours')))
            ->where('session_id IS NOT NULL')
            ->group_by('session_id')
            ->order_by('last_active', 'DESC')
            ->get('activity_log');
        
        $results = $query->result();
        $sessions = [];
        
        foreach ($results as $index => $row) {
            $is_current = ($current_session_id && $row->session_id === $current_session_id);
            
            $sessions[] = (object)[
                'id' => $index + 1,
                'session_token' => $row->session_id,
                'device_name' => $this->_parse_user_agent($row->user_agent),
                'ip_address' => $row->ip_address,
                'last_active' => $row->last_active,
                'is_current' => $is_current,
                'device_icon' => $this->_get_device_icon($row->user_agent),
                'activity_count' => $row->activity_count
            ];
        }
        
        // If no sessions found, return current session only
        if (empty($sessions) && $current_session_id) {
            $sessions[] = (object)[
                'id' => 1,
                'session_token' => $current_session_id,
                'device_name' => $this->_parse_user_agent($this->input->user_agent()),
                'ip_address' => $this->input->ip_address(),
                'last_active' => date('Y-m-d H:i:s'),
                'is_current' => true,
                'device_icon' => 'fa-laptop',
                'activity_count' => 1
            ];
        }
        
        return $sessions;
    }

    // Revoke session (mark as inactive in activity_log - we just log it)
  public function revoke_session($session_id, $user_id) {
    // Check if this is the current session
    if ($session_id === session_id()) {
        return $this->_fail('You cannot revoke your own current session.');
    }
    
    // Update last_login to a new timestamp - this will invalidate all other sessions
    $this->db->where('user_id', $user_id)
             ->update('user', ['last_login' => date('Y-m-d H:i:s')]);
    
    // Log the action
    $this->_log_security_event($user_id, 'session_revoked', "Session revoked: $session_id", $session_id);
    
    return $this->_ok('Session revoked. Other device will be logged out.');
}

    // Change password
    public function change_password($user_id, $current_password, $new_password) {
        $user = $this->_get_user($user_id);
        
        if (!$user) {
            return $this->_fail('User not found.');
        }
        
        // Verify current password
        if (!password_verify($current_password, $user->password)) {
            $this->_log_security_event($user_id, 'failed_password_change', 'Incorrect current password');
            return $this->_fail('Current password is incorrect.');
        }
        
        // Validate new password
        $validation = $this->_validate_password($new_password);
        if (!$validation['valid']) {
            return $this->_fail($validation['message']);
        }
        
        // Hash and update password
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $this->db->where('user_id', $user_id)
                 ->update('user', ['password' => $hashed]);
        
        $this->_log_security_event($user_id, 'password_changed', 'Password updated successfully');
        return $this->_ok('Password updated successfully.');
    }

    // Enable/disable 2FA
    public function set_tfa($user_id, $enabled) {
        $this->db->where('user_id', $user_id)
                 ->update('user', ['tfa_enabled' => $enabled ? 1 : 0]);
        
        $action = $enabled ? 'enabled' : 'disabled';
        $this->_log_security_event($user_id, "2fa_$action", "Two-factor authentication $action");
        
        return $this->_ok("2FA " . ($enabled ? 'enabled' : 'disabled') . ".");
    }

    // Get 2FA status
    public function get_tfa_status($user_id) {
        $user = $this->_get_user($user_id);
        return $user ? (bool)$user->tfa_enabled : false;
    }

    // Send OTP via SMS
    public function send_otp($user_id, $phone) {
        // Generate 6-digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        // Hash and store OTP
        $hashed_otp = password_hash($otp, PASSWORD_DEFAULT);
        $this->db->where('user_id', $user_id)
                 ->update('user', [
                     'otp_code' => $hashed_otp,
                     'otp_expire' => $expires
                 ]);
        
        // Send SMS via your gateway
        $sms_sent = $this->_send_sms($phone, $otp);
        
        if (!$sms_sent['success']) {
            return $this->_fail('Failed to send OTP. Please try again. ' . ($sms_sent['message'] ?? ''));
        }
        
        $this->_log_security_event($user_id, 'otp_sent', "OTP sent to $phone");
        return $this->_ok('OTP sent successfully.');
    }

    // Verify OTP
    public function verify_otp($user_id, $phone, $otp_entered) {
        $user = $this->_get_user($user_id);
        
        if (!$user || $user->phone != $phone) {
            return $this->_fail('Invalid request.');
        }
        
        // Check if OTP exists
        if (empty($user->otp_code)) {
            return $this->_fail('No OTP requested. Please request a new one.');
        }
        
        // Check if OTP expired
        if (strtotime($user->otp_expire) < time()) {
            return $this->_fail('OTP expired. Please request a new one.');
        }
        
        // Verify OTP
        if (!password_verify($otp_entered, $user->otp_code)) {
            $this->_log_security_event($user_id, 'failed_otp_verification', 'Incorrect OTP entered');
            return $this->_fail('Incorrect OTP.');
        }
        
        // Mark phone as verified and clear OTP
        $this->db->where('user_id', $user_id)
                 ->update('user', [
                     'phone_verified' => 1,
                     'otp_code' => null,
                     'otp_expire' => null
                 ]);
        
        $this->_log_security_event($user_id, 'phone_verified', "Phone number $phone verified");
        return $this->_ok('Phone number verified successfully.');
    }

    // Get phone verification status
    public function get_phone_status($user_id) {
        $user = $this->_get_user($user_id);
        if (!$user) {
            return ['phone' => null, 'verified' => false];
        }
        return [
            'phone' => $user->phone,
            'verified' => (bool)$user->phone_verified
        ];
    }

    // Set secret question
    public function set_secret_question($user_id, $question, $answer) {
        if (empty(trim($question)) || empty(trim($answer))) {
            return $this->_fail('Question and answer are required.');
        }
        
        $hashed_answer = password_hash(strtolower(trim($answer)), PASSWORD_DEFAULT);
        
        $this->db->where('user_id', $user_id)
                 ->update('user', [
                     'secret_question' => $question,
                     'secret_answer' => $hashed_answer
                 ]);
        
        $this->_log_security_event($user_id, 'secret_question_set', 'Security question configured');
        return $this->_ok('Secret question saved successfully.');
    }

    // Get secret question status
    public function get_secret_question_status($user_id) {
        $user = $this->_get_user($user_id);
        if (!$user) {
            return ['is_set' => false, 'question' => null];
        }
        return [
            'is_set' => !empty($user->secret_question),
            'question' => $user->secret_question ?? null
        ];
    }

    // Update login count (call after security setup or on each login)
    public function update_login_count($user_id, $increment = true) {
        if ($increment) {
            $this->db->where('user_id', $user_id)
                     ->set('login_count', 'login_count + 1', FALSE)
                     ->set('last_login', date('Y-m-d H:i:s'))
                     ->update('user');
        } else {
            $this->db->where('user_id', $user_id)
                     ->update('user', ['last_login' => date('Y-m-d H:i:s')]);
        }
    }

    // Check if first login
    public function is_first_login($user_id) {
        $user = $this->_get_user($user_id);
        return $user && $user->login_count == 0;
    }

    // Complete security setup (called when user finishes or skips)
    public function complete_security_setup($user_id) {
        $this->update_login_count($user_id, true);
        $this->_log_security_event($user_id, 'security_setup_completed', 'User completed security setup');
    }

    // Private helper methods
    private function _validate_password($password) {
        if (strlen($password) < 6) {
            return ['valid' => false, 'message' => 'Password must be at least 6 characters.'];
        }
        if (!preg_match('/[0-9]/', $password)) {
            return ['valid' => false, 'message' => 'Password must contain at least one number.'];
        }
        if (!preg_match('/[a-zA-Z]/', $password)) {
            return ['valid' => false, 'message' => 'Password must contain at least one letter.'];
        }
        return ['valid' => true, 'message' => ''];
    }

    private function _parse_user_agent($user_agent_string) {
        if (empty($user_agent_string)) {
            return 'Unknown Device';
        }
        
        // Simple parsing - you can make this more sophisticated
        $ua = strtolower($user_agent_string);
        
        if (strpos($ua, 'windows') !== false) {
            if (strpos($ua, 'chrome') !== false) return 'Chrome on Windows';
            if (strpos($ua, 'firefox') !== false) return 'Firefox on Windows';
            return 'Windows PC';
        }
        
        if (strpos($ua, 'mac') !== false) {
            if (strpos($ua, 'chrome') !== false) return 'Chrome on Mac';
            if (strpos($ua, 'safari') !== false) return 'Safari on Mac';
            return 'Mac Computer';
        }
        
        if (strpos($ua, 'iphone') !== false) return 'iPhone';
        if (strpos($ua, 'ipad') !== false) return 'iPad';
        if (strpos($ua, 'android') !== false) return 'Android Device';
        
        return 'Unknown Device';
    }

    private function _get_device_icon($user_agent_string) {
        $ua = strtolower($user_agent_string);
        if (strpos($ua, 'iphone') !== false || strpos($ua, 'android') !== false) {
            return 'fa-mobile-alt';
        }
        if (strpos($ua, 'ipad') !== false) {
            return 'fa-tablet-alt';
        }
        return 'fa-laptop';
    }

    private function _send_sms($phone, $otp) {
        // Format phone number for SMS - convert to international format if needed
        $sms_phone = $phone;
        
        // If phone starts with 0, replace with 94 for Sri Lanka
        if (preg_match('/^0[0-9]{9}$/', $phone)) {
            $sms_phone = '94' . substr($phone, 1);
        }
        
        // Message to send
        $message = "Your verification code is: {$otp}. This code will expire in 10 minutes.";
        
        // Use the existing SmsSender library with sender ID '8989898989' (same as Staff_model)
        try {
            $result = $this->smssender->send_sms_with_mobi('8989898989', $sms_phone, $message);
            
            // Log the SMS attempt
            log_message('info', "OTP SMS sent to {$sms_phone} | Result: " . json_encode($result));
            
            // Check if SMS was sent successfully
            if (isset($result['success']) && $result['success'] === true) {
                return ['success' => true, 'message' => 'SMS sent successfully'];
            } else {
                $error_msg = $result['response']['msg'] ?? $result['message'] ?? 'Unknown error';
                return ['success' => false, 'message' => $error_msg];
            }
        } catch (Exception $e) {
            log_message('error', "SMS sending failed: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function _log_security_event($user_id, $action, $description, $session_id = null) {
        $session_id = $session_id ?: session_id();
        
        $this->db->insert('activity_log', [
            'user_id_fk' => $user_id,
            'session_id' => $session_id,
            'action' => $action,
            'action_type' => 'security',
            'description' => $description,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'created_at' => date('Y-m-d H:i:s'),
            'module' => 'security_settings',
            'status' => 'success',
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? null,
            'request_url' => current_url()
        ]);
    }

    private function _ok($message) {
        return ['success' => true, 'message' => $message];
    }

    private function _fail($message) {
        return ['success' => false, 'message' => $message];
    }
	
}