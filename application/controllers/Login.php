<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	  public function __construct() {
        parent::__construct();
        $this->load->helper('url');  // Add this
        $this->load->helper('form');
    }
	
	public function index(){
		$this->load->view('login');
	}
	
	public function login_user(){
		$this->load->model('Login_m');
		$re = $this->Login_m->auth();
		
		// change the Content-Type to json
		header('Content-Type: application/json');
		
		// Check if result is array (success with additional data)
		if (is_array($re) && isset($re['status']) && $re['status'] == 'success') {
			// Return success with redirect info
			echo json_encode([
				'success' => true,
				'user_id' => $re['user_id'],
				'is_first_login' => $re['is_first_login'],
				'redirect' => $re['redirect']
			]);
		} else if ($re === 'blocked') {
			// Device blocked
			echo json_encode([
				'success' => false,
				'message' => 'Your device has been blocked. Please contact administrator.'
			]);
		} else {
			// Login failed
			echo json_encode([
				'success' => false,
				'message' => 'Invalid username or password'
			]);
		}
	}
	
	/*public function login_user(){
		$this->load->model('Login_m');
		$this->load->helper('url');
		$re = $this->Login_m->auth();

		if($re != 0){
			redirect('/Dash');
		}else{
			$tx['a'] = "Invalid Username or Password";
			$this->load->view('login', $tx);
		}
	}*/ 

	public function logout(){
		$this->load->model('Login_m');
		$re = $this->Login_m->logout();
	
		if($re == '1'){
			$tx['a']='';
			$this->load->view('login', $tx);
			//redirect('/Login');
		}
	}
	
	/*public function forgot_password(){
		$this->load->view('login/forgot_password');
	}*/
	public function check_session()
{
    echo "<pre>";
    echo "=== SESSION DATA ===\n";
    print_r($this->session->all_userdata());
    echo "\n=== BRANCH ID CHECK ===\n";
    echo "branch_id key: " . ($this->session->userdata('branch_id') ?: 'NOT SET') . "\n";
    echo "branch key (old): " . ($this->session->userdata('branch') ?: 'NOT SET') . "\n";
    echo "</pre>";
}
	public function send_reset_otp(){
		
		header('Content-Type: application/json');
		$phone = $this->input->post('phone');

		if (!$phone) {
			echo json_encode(['success' => false, 'message' => 'Phone required']);
			return;
		}

		$user = $this->db->get_where('user', ['phone' => $phone])->row_array();
		if (!$user) {
			echo json_encode(['success' => false, 'message' => 'Invalid phone number. Please use your registered number.']);
			return;
		}

		$otp = rand(100000, 999999);
		$expire = date('Y-m-d H:i:s', strtotime('+5 minutes'));

		$this->db->where('user_id', $user['user_id']);
		$this->db->update('user', ['otp_code' => $otp,'otp_expire' => $expire,'reset_otp_verified' => 0]);

		$this->session->set_userdata('reset_user_id', $user['user_id']);

		// Send SMS
		$this->load->library('SmsSender');
		$this->smssender->send_sms_with_mobi('8989898989',$user['phone'],"Your reset OTP is: $otp");

		echo json_encode(['success' => true]);
		
	}
	
	public function verify_reset_otp_ajax()
	{
		header('Content-Type: application/json');

		$user_id = $this->session->userdata('reset_user_id');
		$otp     = $this->input->post('otp');

		if (!$user_id || !$otp) {
			echo json_encode(['success' => false, 'message' => 'Invalid request']);
			return;
		}

		$user = $this->db->get_where('user', ['user_id' => $user_id])->row_array();

		if (
			!$user ||
			$user['otp_code'] != $otp ||
			strtotime($user['otp_expire']) < time()
		) {
			echo json_encode(['success' => false, 'message' => 'Invalid or expired OTP']);
			return;
		}

		// ✅ Mark reset OTP verified
		$this->db->where('user_id', $user_id)->update('user', [
			'reset_otp_verified' => 1
		]);

		echo json_encode(['success' => true]);
	}
	
	public function reset_password_otp()
	{
		$user_id = $this->session->userdata('reset_user_id');
		if (!$user_id) {
			redirect('Login/forgot_password');
			return;
		}

		$user = $this->db->get_where('user', [
			'user_id' => $user_id,
			'reset_otp_verified' => 1
		])->row_array();

		if (!$user) {
			$this->session->set_flashdata('error', 'OTP verification required');
			redirect('Login/forgot_password');
			return;
		}

		if ($this->input->method() === 'post') {
			$password = $this->input->post('password');
			$confirm  = $this->input->post('confirm_password');

			if ($password !== $confirm) {
				$this->session->set_flashdata('error', 'Passwords do not match');
				redirect(current_url());
				return;
			}

			$this->db->where('user_id', $user_id)->update('user', [
				'password'           => $password,
				'reset_otp_verified' => 0,
				'otp_code'           => null,
				'otp_expire'         => null
			]);

			$this->session->unset_userdata('reset_user_id');

			$this->session->set_flashdata('success','Password reset successful. Please login.');

			$this->load->view('login');
			return;
		}

		$this->load->view('login/reset_password_otp');
	}
	
	public function forgot_password()
	{
		$this->load->view('login/forgot_password');
	}
	
	public function change_password(){
		$this->load->view('login/change_password');
	}
	
	public function change_pass(){
		$this->load->model('Login_m');
		$this->Login_m->change_passwd();
	}
	
	
}