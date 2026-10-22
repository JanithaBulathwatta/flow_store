<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_queue_model extends CI_Model {

    private $sms_sender;
	private $email_service;
    private $table = 'message_queue';

    public function __construct() {
        parent::__construct();
        
        // Load the SmsSender library
        $this->load->library('SmsSender');
		$this->load->library('Email_service'); 
		
        $this->sms_sender = new SmsSender();
		$this->email_service = new Email_service(); 
    }

    /**
     * Main method: Fetch and process pending SMS in batches
     * 
     * @param int $limit Number of messages to process (default: 5)
     * @return array Result summary
     */
    /**
 * Process only SMS messages
 */
public function process_sms_batch($limit = 5) {
    $this->db->trans_start();
    
    $pending_messages = $this->get_pending_sms($limit);
    
    if (empty($pending_messages)) {
        $this->db->trans_complete();
        return ['success' => true, 'message' => 'No pending SMS found', 'total_processed' => 0];
    }
    
    $message_ids = array_column($pending_messages, 'mq_id');
    $this->mark_as_processing($message_ids);
    
    $this->db->trans_complete();
    
    $results = [];
    $success_count = 0;
    $failed_count = 0;
    
    foreach ($pending_messages as $message) {
        $result = $this->process_single_message($message);
        $results[] = $result;
        
        if ($result['success']) {
            $success_count++;
        } else {
            $failed_count++;
        }
        
        usleep(500000);
    }
    
    return [
        'success' => true,
        'type' => 'sms',
        'total_processed' => count($pending_messages),
        'success_count' => $success_count,
        'failed_count' => $failed_count,
        'details' => $results,
        'processed_at' => date('Y-m-d H:i:s')
    ];
}
/**
 * Process SMS message
 * 
 * @param array $message Message data
 * @param array $result Reference to result array
 * @return void
 */
private function process_sms($message, &$result) {
    // Validate
    if (empty($message['to']) || empty($message['message'])) {
        throw new Exception('Missing phone number or message content');
    }
    
    // Use CI instance
    $CI =& get_instance();
    $CI->load->library('SmsSender');
    
    // Format phone number
    $phone = preg_replace('/\D/', '', $message['to']);
    if (preg_match('/^0[0-9]{9}$/', $phone)) {
        $phone = '94' . substr($phone, 1);
    }
    
    // Send SMS
    $response = $CI->smssender->send_sms_with_mobi(
        '8989898989',
        $phone,
        $message['message']
    );
    
    $result['response'] = $response;
    
    if ($response['success'] === true) {
        $this->update_message_success($message['mq_id'], $response);
        $result['success'] = true;
        $result['status'] = 'success';
    } else {
        $error_msg = is_array($response['response']) 
            ? json_encode($response['response']) 
            : $response['response'];
        throw new Exception($error_msg);
    }
}

/**
 * Process only Email messages
 */
public function process_email_batch($limit = 5) {
    $this->db->trans_start();
    
    $pending_messages = $this->get_pending_emails($limit);
    
    if (empty($pending_messages)) {
        $this->db->trans_complete();
        return ['success' => true, 'message' => 'No pending emails found', 'total_processed' => 0];
    }
    
    $message_ids = array_column($pending_messages, 'mq_id');
    $this->mark_as_processing($message_ids);
    
    $this->db->trans_complete();
    
    $results = [];
    $success_count = 0;
    $failed_count = 0;
    
    foreach ($pending_messages as $message) {
        $result = $this->process_single_message($message);
        $results[] = $result;
        
        if ($result['success']) {
            $success_count++;
        } else {
            $failed_count++;
        }
        
        usleep(500000);
    }
    
    return [
        'success' => true,
        'type' => 'email',
        'total_processed' => count($pending_messages),
        'success_count' => $success_count,
        'failed_count' => $failed_count,
        'details' => $results,
        'processed_at' => date('Y-m-d H:i:s')
    ];
}

    /**
     * Get pending messages that need to be sent
     * 
     * @param int $limit
     * @return array
     */
    /**
 * Get pending SMS messages only
 */
private function get_pending_sms($limit = 5) {
    $this->db->select('*')
        ->from($this->table)
        ->where('status', 'pending')
        ->where('type', 'sms')
        ->where('retry_count <', 3, false)
        ->order_by('mq_id', 'ASC')
        ->limit($limit);
    
    $query = $this->db->get();
    return $query->result_array();
}

/**
 * Get pending Email messages only
 */
private function get_pending_emails($limit = 5) {
    $this->db->select('*')
        ->from($this->table)
        ->where('status', 'pending')
        ->where('type', 'email')
        ->where('retry_count <', 3, false)
        ->order_by('mq_id', 'ASC')
        ->limit($limit);
    
    $query = $this->db->get();
    return $query->result_array();
}

    /**
     * Mark messages as processing
     * 
     * @param array $message_ids
     * @return bool
     */
    private function mark_as_processing($message_ids) {
        if (empty($message_ids)) {
            return false;
        }
        
        $this->db->where_in('mq_id', $message_ids)
            ->update($this->table, [
                'status' => 'processing',
                'processed_at' => date('Y-m-d H:i:s')
            ]);
        
        return $this->db->affected_rows() > 0;
    }

    /**
     * Process a single SMS message
     * 
     * @param array $message Message data from database
     * @return array Result of processing
     */
    private function process_single_message($message) {
    $result = [
        'mq_id' => $message['mq_id'],
        'to' => $message['to'],
        'type' => $message['type'],  // ← IMPORTANT: Add this line
        'success' => false,
        'status' => 'failed',
        'response' => null,
        'error' => null
    ];
    
    try {
        // ← CRITICAL: Route based on type
        if ($message['type'] == 'sms') {
            $this->process_sms($message, $result);
        } elseif ($message['type'] == 'email') {
            $this->process_email($message, $result);  // ← Call email processor
        } else {
            throw new Exception('Unknown message type: ' . $message['type']);
        }
    } catch (Exception $e) {
        $result['error'] = $e->getMessage();
        $this->handle_failure($message, $e->getMessage());
    }
    
    return $result;
}

    /**
     * Update message as successfully sent
     * 
     * @param int $mq_id
     * @param array $response
     * @return bool
     */
    private function update_message_success($mq_id, $response) {
        $update_data = [
            'status' => 'success',
            'sent_at' => date('Y-m-d H:i:s'),
            'response_data' => json_encode($response)
        ];
        
        return $this->db->where('mq_id', $mq_id)
            ->update($this->table, $update_data);
    }

    /**
     * Handle failed message
     * 
     * @param array $message
     * @param string $error_message
     * @return bool
     */
    private function handle_failure($message, $error_message) {
        $new_retry_count = ($message['retry_count'] ?? 0) + 1;
        $max_retries = 3;
        
        if ($new_retry_count >= $max_retries) {
            $status = 'failed';
            log_message('error', "SMS permanently failed. ID: {$message['mq_id']}, Error: {$error_message}");
        } else {
            $status = 'pending';
            // FIXED: Changed from 'WARNING' to 'warning' (lowercase)
            log_message('warning', "SMS failed, retry {$new_retry_count}/{$max_retries}. ID: {$message['mq_id']}");
        }
        
        $update_data = [
            'status' => $status,
            'retry_count' => $new_retry_count,
            'response_data' => json_encode(['error' => $error_message])
        ];
        
        if ($status === 'pending') {
            $update_data['sent_at'] = null;
        }
        
        return $this->db->where('mq_id', $message['mq_id'])
            ->update($this->table, $update_data);
    }

    /**
     * Add a new message to queue
     * 
     * @param array $data
     * @return int Insert ID
     */
    public function add_to_queue($data) {
        $insert_data = [
            'event_name' => $data['event_name'] ?? null,
            'module' => $data['module'] ?? null,
            'type' => 'sms',
            'to' => $data['to'],
            'message' => $data['message'],
            'status' => 'pending',
            'retry_count' => 0,
            'c_date' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert($this->table, $insert_data);
        return $this->db->insert_id();
    }

    /**
     * Get queue statistics
     * 
     * @return array
     */
    public function get_queue_stats() {
        $stats = [];
        
        // Count by status
        $query = $this->db->select('status, COUNT(*) as count')
            ->from($this->table)
            ->group_by('status')
            ->get();
        
        $status_counts = [];
        foreach ($query->result() as $row) {
            $status_counts[$row->status] = $row->count;
        }
        
        $stats['status_counts'] = $status_counts;
        
        // Total pending
        $stats['total_pending'] = $this->db->where('status', 'pending')
            ->from($this->table)
            ->count_all_results();
        
        // Success rate
        $total = $this->db->count_all($this->table);
        $success = $status_counts['success'] ?? 0;
        $stats['success_rate'] = $total > 0 ? round(($success / $total) * 100, 2) : 0;
        
        $stats['last_updated'] = date('Y-m-d H:i:s');
        
        return $stats;
    }

    /**
     * Reset failed messages for retry
     * 
     * @param int $hours_old
     * @return int
     */
    public function reset_failed_messages($hours_old = 24) {
        $reset_time = date('Y-m-d H:i:s', strtotime("-{$hours_old} hours"));
        
        $this->db->set('status', 'pending')
            ->set('retry_count', 0)
            ->where('status', 'failed')
            ->where('processed_at <', $reset_time)
            ->update($this->table);
        
        return $this->db->affected_rows();
    }
	/**
 * Add Email to queue
 * Uses 'to' column for email address
 * Uses 'message' column for email body (HTML)
 * Uses 'event_name' column for email subject
 * 
 * @param string $to Email address
 * @param string $subject Email subject
 * @param string $message Email body (HTML)
 * @param string $module Optional module name
 * @return int Insert ID
 */
public function add_email($to, $subject, $message, $module = null) {
    $insert_data = [
        'event_name' => $subject,  // Subject stored here
        'module' => $module,
        'type' => 'email',
        'to' => $to,               // Email address
        'message' => $message,     // Email HTML body
        'status' => 'pending',
        'retry_count' => 0,
        'c_date' => date('Y-m-d H:i:s')
    ];
    
    $this->db->insert($this->table, $insert_data);
    return $this->db->insert_id();
}

/**
 * Process Email message
 */
private function process_email($message, &$result) {
    // Validate - 'to' column holds email address
    if (empty($message['to']) || empty($message['message'])) {
        throw new Exception('Missing email address or message content');
    }
    
    // Validate email format
    if (!filter_var($message['to'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address: ' . $message['to']);
    }
    
    // Subject from event_name column
    $subject = $message['event_name'] ?? 'System Notification';
    
    // Prepare email data
    $email_data = [
        'html' => $message['message']
    ];
    
    // Send email using Email_service
    $response = $this->email_service->send_finance_summary(
        $message['to'],  // Recipient email
        $email_data,
        'cron'
    );
    
    $result['response'] = $response;
    
    if ($response['status'] === true) {
        $this->update_message_success($message['mq_id'], $response);
        $result['success'] = true;
        $result['status'] = 'success';
    } else {
        throw new Exception($response['error'] ?? 'Email sending failed');
    }
}
}