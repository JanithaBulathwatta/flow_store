<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceManager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Core libraries & helpers
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);

		$this->load->model('device_manager/DeviceManager_model');
		$this->load->library('user_agent');
		
    }
	
	    public function index()
    {
		
		$this->load->view('header');
        $this->load->view('device_manager/device_manager');
		$this->load->view('footer');
	}
	
	

	public function get_devices_json() {
		header('Content-Type: application/json');
		$devices = $this->DeviceManager_model->get_all_devices();
		echo json_encode($devices);
	}

	public function toggle_active() {
		$id = $this->input->post('id');
		$active = $this->input->post('is_active');
		$this->DeviceManager_model->update_status($id, ['is_active' => $active]);
		echo json_encode(['status' => 'success']);
	}
	
	public function remove_device() {
		$id = $this->input->post('id');
		
		// We do a "Soft Delete" by changing the status
		$this->DeviceManager_model->update_status($id, [
			'status' => 'deleted',
			'is_active' => 0
		]);
		
		echo json_encode(['status' => 'success']);
	}

	public function update_device_status() {
		$id = $this->input->post('id');
		$status = $this->input->post('status'); 
		$active = ($status == 'blocked') ? 0 : 1;
		
		$this->DeviceManager_model->update_status($id, [
			'status' => $status,
			'is_active' => $active
		]);
		echo json_encode(['status' => 'success']);
	}
}	