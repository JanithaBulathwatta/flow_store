<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('crm/User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    /**
     * Login page + login action
     */
    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        if ($this->input->post()) {

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {

                $email    = $this->input->post('email', TRUE);
                $password = $this->input->post('password', TRUE);

                $user = $this->User_model->get_by_email($email);

                if ($user && $user->is_active == 1) {

                    // 🔴 Plain text password check
                    if ($password === $user->password) {

                        $this->session->set_userdata([
                            'user_id'   => $user->id,
                            'name'      => $user->name,
                            'email'     => $user->email,
                            'role'      => $user->role,
                            'logged_in' => TRUE
                        ]);

                        redirect('dashboard');

                    } else {
                        $this->session->set_flashdata('error', 'Invalid password');
                    }

                } else {
                    $this->session->set_flashdata('error', 'User not found or inactive');
                }
            }
        }

        $this->load->view('auth/login');
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
