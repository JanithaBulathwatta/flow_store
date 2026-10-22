<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_service {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('email');
    }

    /**
     * Send email via SMTP (Generic method used by queue system)
     * 
     * @param string $to Recipient email address
     * @param array $data Data array containing 'html' key with email body
     * @param string $period_type Ignored - kept for compatibility
     * @return array Result with status and error if any
     */
    public function send_finance_summary($to, $data, $period_type = 'cron')
    {
        $subject = "System Notification - " . date('Y-m-d H:i');
        
        // Use the HTML from data array
        $message = $data['html'] ?? $data['message'] ?? 'No message content';
        
        $config = [
            'protocol'    => 'smtp',
            'smtp_host'   => 'smtp.hostinger.com',
            'smtp_port'   => 465,
            'smtp_user'   => 'dev@max-branding.com',
            'smtp_pass'   => 'vM;xhQ2>s:7T@76',
            'smtp_crypto' => 'ssl',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'crlf'        => "\r\n"
        ];

        $this->CI->email->initialize($config);
        $this->CI->email->from('dev@max-branding.com', 'System Notification');
        $this->CI->email->to($to);
        $this->CI->email->subject($subject);
        $this->CI->email->message($message);

        if (!$this->CI->email->send()) {
            return [
                'status' => false, 
                'error' => $this->CI->email->print_debugger()
            ];
        }

        return ['status' => true];
    }
}