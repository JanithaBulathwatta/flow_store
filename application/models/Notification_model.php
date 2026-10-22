<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

	private $table = 'notification_settings';
	
	// Get notification settings (DATA)
    public function get_notification_data()
    {
        return $this->db
            ->select('notification_id as id,event_name,`key`,label,description,note,sms,email,is_active,is_mandatory,user_configurable,group_key,priority')
            ->from('notification_settings')
            ->order_by('priority','ASC')
            ->get()
            ->result_array();
    }
	
    public function get_groups()
    {
        $rows = $this->db
            ->select('group_key,group_name,group_icon,icon_color')
            ->from('group')
            ->where('group_str','Active')
            ->get()
            ->result_array();

        $groups = [];

        foreach ($rows as $r) {
            $groups[strtoupper(trim($r['group_key']))] = [
                "label" => trim($r['group_name']),
                "icon"  => $r['group_icon'],
                "color" => $r['icon_color']
            ];
        }

        return $groups;
    }

    public function update_by_id($id, $data){
        $this->db->where('notification_id', $id);
        return $this->db->update($this->table, $data);
    }
	
    public function update_by_event($event_name, $data){
        $this->db->where('event_name', $event_name);
        return $this->db->update($this->table, $data);
		
    }
	
	
	
	public function save_message_log($event,$module,$type,$to,$msg){
		 
		$data = ['event_name' => $event,
				  'module'     => $module,
                  'type'       => $type,
                  'to'         => $to,
                  'message'    => $msg];

		return $this->db->insert('message_queue', $data);
	
 	}
	
	public function get_all_messages()
	{
		return $this->db->order_by('mq_id', 'DESC')->get('message_queue')->result();
	}
	
	
	
}
?>