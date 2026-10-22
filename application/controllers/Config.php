<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    /**
     * Display brands page
     */
    public function index() {        
        $filters = [
            'search' => $this->input->get('search'),
            'status' => $this->input->get('status'),
            'date' => $this->input->get('date')
        ];
        
        $data['stores'] = $this->Store_model->get_all_stores($filters);
        $data['counts'] = $this->Store_model->get_counts();
        $data['filters'] = $filters;
        
        $this->load->view('header');
        $this->load->view('store/store', $data);
        $this->load->view('footer');
    }


}
?>