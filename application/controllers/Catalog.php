<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog extends CI_Controller {

    /**
     * Display brands page
     */
    public function index() {        
        $this->load->view('header');
        $this->load->view('crm/brand/brand');
        $this->load->view('footer');
    }


}
?>