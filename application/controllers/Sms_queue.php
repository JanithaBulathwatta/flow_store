<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_queue extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Message_queue_model');
    }
    public function process_queue() {
    set_time_limit(300);
    $limit = $this->input->get('limit') ?? 5;
    
    // Process both SMS and email
    $result = $this->Message_queue_model->process_sms_batch($limit);
    
    log_message('info', 'Queue Processed: ' . json_encode($result));
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
}
 
    public function stats() {
        $stats = $this->Message_queue_model->get_queue_stats();
        
        echo "<pre>";
        echo "=== QUEUE STATISTICS ===\n";
        print_r($stats);
        echo "</pre>";
    }
    
	public function process_sms_queue() {
		// Get domain from GET parameter (passed via cron)
    $domain = $this->input->get('domain');
    
    if ($domain) {
        // Set HTTP_HOST for database config to read
        $_SERVER['HTTP_HOST'] = $domain;
    }
     $limit = $this->input->get('limit') ?? 5;
    $result = $this->Message_queue_model->process_sms_batch($limit);
    echo json_encode($result);
}

/**
 * Process only Email queue
 * Call via cron every hour
 */
public function process_email_queue() {
    set_time_limit(300);
    $limit = $this->input->get('limit') ?? 20;
    $result = $this->Message_queue_model->process_email_batch($limit);
    
    log_message('info', 'Email Queue Processed: ' . json_encode($result));
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
}
}