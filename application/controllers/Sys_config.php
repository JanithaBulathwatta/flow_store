<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Pubudu 12/3/2026

class Sys_config extends CI_Controller {

    public function index() {
         	
        $this->load->view('header');
        $this->load->view('settings/system_config');
        $this->load->view('footer');
    }
	
}
?>