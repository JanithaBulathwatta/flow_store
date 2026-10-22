<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Notification_manager extends CI_Controller {

	// Optional API (AJAX)
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notification_model');
    }

    public function index()
    {
        $data['notifications'] = $this->Notification_model->get_notification_data();
        $data['groups'] = $this->Notification_model->get_groups();

		$this->load->view('header');
        $this->load->view('settings/notification_settings', $data);
        $this->load->view('footer');
    }
	
	public function save_settings(){

        // Read raw JSON
        $input = json_decode(trim(file_get_contents('php://input')), true);

        if (!isset($input['events'])) {
            echo json_encode(['status' => 'error', 'message' => 'No data received']);
            return;
        }

        $events = $input['events'];

        foreach ($events as $ev) {

            // Safety: only update allowed fields
            $data = [
                'sms'        => isset($ev['sms']) ? (int)$ev['sms'] : 0,
                'email'      => isset($ev['email']) ? (int)$ev['email'] : 0,
                'is_active'  => isset($ev['is_active']) ? (int)$ev['is_active'] : 0,
            ];

            // Use notification_id OR event_name (your DB has both)
            if (!empty($ev['id'])) {
                $this->Notification_model->update_by_id($ev['id'], $data);
            } elseif (!empty($ev['event_name'])) {
                $this->Notification_model->update_by_event($ev['event_name'], $data);
            }
        }

        echo json_encode(['status' => 'success']);
    }
	
	public function message_log(){

		$event = "Purchase";
		$module = "Purchase Order";
		$type = "email";
		$to = "0702952227";
		$msg ="Purchase Order Created [123456]";
		
		$this->Notification_model->save_message_log($event,$module,$type,$to,$msg);
	
		$this->load->view('header');
        $this->load->view('settings/message_log');
        $this->load->view('footer');
	}

	public function get_messages()
    {
        $messages = $this->Notification_model->get_all_messages();

        $data = [];

        foreach ($messages as $row) {

            $data[] = [
                'id'        => (int)$row->mq_id,
                'channel'   => $row->type,
                'type'      => $row->module,
                'to'        => $row->to,
                'recipient' => $row->event_name,
                'subject'   => $row->type == 'email' ? $row->event_name : null,
                'body'      => $row->message,
                'status'    => $row->status,
                'sent_at'   => date('Y-m-d H:i', strtotime($row->c_date)),
                'ref'       => strtoupper($row->module).'-'.$row->mq_id,
                'parts'     => $row->type == 'sms'
                                ? ceil(strlen($row->message) / 160)
                                : null
            ];
        }

        echo json_encode($data);
    }
	
}
?>