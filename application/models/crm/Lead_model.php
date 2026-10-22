<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_model extends CI_Model
{
    protected $table = 'leads';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check if lead exists
     */
    public function exists($lead_id)
    {
        return $this->db
            ->where('id', (int)$lead_id)
            ->count_all_results($this->table) > 0;
    }

    /**
     * Get all leads (for listing)
     */
    /*public function get_all()
    {
        return $this->db
            ->select('
                l.*,
                p.name AS product_name,
                s.name AS status_name,
                s.color AS status_color,
                u.name AS assigned_user_name,
				c.comment as last_comment,
				COUNT(c.id) AS comment_count,
				c.comment AS last_comment
            ')
            ->from('leads l')
            ->join('products p', 'p.id = l.product_id', 'left')
			->join('lead_comments c', 'c.lead_id = l.id', 'left')
            ->join('lead_statuses s', 's.id = l.status_id')
            ->join('users u', 'u.id = l.assigned_user_id')
            ->order_by('l.created_at', 'DESC')
            ->get()
            ->result();
    }*/
	
	public function get_all()
	{
		return $this->db
			->select('
				l.*,
				p.name AS product_name,
				s.name AS status_name,
				s.color AS status_color,
				u.full_name AS assigned_user_name,
				lc.comment AS last_comment,
				lc.created_at AS last_comment_date,
				COALESCE(cc.comment_count, 0) AS comment_count,
				DATEDIFF(NOW(), l.created_at) AS days_since_created
			')
			->from('leads l')

			->join('products p', 'p.id = l.product_id', 'left')
			->join('lead_statuses s', 's.id = l.status_id')
			->join('user u', 'u.user_id = l.assigned_user_id')

			->join('(
				SELECT lead_id, COUNT(*) AS comment_count
				FROM lead_comments
				GROUP BY lead_id
			) cc', 'cc.lead_id = l.id', 'left')

			->join('(
				SELECT c1.lead_id, c1.comment, c1.created_at
				FROM lead_comments c1
				INNER JOIN (
					SELECT lead_id, MAX(id) AS last_id
					FROM lead_comments
					GROUP BY lead_id
				) c2 ON c2.last_id = c1.id
			) lc', 'lc.lead_id = l.id', 'left')
			->where('l.status', 'active')
			->order_by('l.created_at', 'DESC')
			->get()
			->result();
	}

	public function get_filtered($date = null, $product = null, $status = null, $priority = null)
	{
		
		$this->db
			->select('
				l.*,
				p.name AS product_name,
				s.name AS status_name,
				s.color AS status_color,
				u.name AS assigned_user_name,
				lc.comment AS last_comment,
				lc.created_at AS last_comment_date,
				COALESCE(cc.comment_count, 0) AS comment_count,
				DATEDIFF(NOW(), l.created_at) AS days_since_created
			')
			->from('leads l')
			->join('products p', 'p.id = l.product_id', 'left')
			->join('lead_statuses s', 's.id = l.status_id')
			->join('users u', 'u.id = l.assigned_user_id')
			->join('(
				SELECT lead_id, COUNT(*) AS comment_count
				FROM lead_comments
				GROUP BY lead_id
			) cc', 'cc.lead_id = l.id', 'left')
			->join('(
				SELECT c1.lead_id, c1.comment, c1.created_at
				FROM lead_comments c1
				INNER JOIN (
					SELECT lead_id, MAX(id) AS last_id
					FROM lead_comments
					GROUP BY lead_id
				) c2 ON c2.last_id = c1.id
			) lc', 'lc.lead_id = l.id', 'left');

		/*if (!empty($date)) {
			$this->db->where('DATE(l.created_at)', $date);
		}*/ 
		
		if (!empty($date)) {

			$dates = explode(' – ', $date);

			if (count($dates) == 2) {

				$start = date('Y-m-d', strtotime(trim($dates[0])));
				$end   = date('Y-m-d', strtotime(trim($dates[1])));

				$this->db->where('DATE(l.created_at) >=', $start);
				$this->db->where('DATE(l.created_at) <=', $end);
			}
		}

		if (!empty($product)) {
			$this->db->where('l.product_id', $product);
		}

		if (!empty($status)) {
			$this->db->where('l.status_id', $status);
		}

		if (!empty($priority)) {
			$this->db->where('l.priority', $priority);
		}

		return $this->db
			//->where('l.status', 'active')
			->order_by('l.created_at', 'DESC')
			->get()
			->result();
	}

    /**
     * Get single lead with relations
     */
    public function get_by_id($id)
    {
        return $this->db
            ->select('
                l.*,
                p.name AS product_name,
                s.name AS status_name,
                s.color AS status_color,
                u.name AS assigned_user_name
            ')
            ->from('leads l')
            ->join('products p', 'p.id = l.product_id', 'left')
            ->join('lead_statuses s', 's.id = l.status_id')
            ->join('users u', 'u.id = l.assigned_user_id')
            ->where('l.id', (int)$id)
            ->get()
            ->row();
    }

    /**
     * Create new lead
     */
    public function create()
    {
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
		$this->form_validation->set_rules('customer_email', 'Customer Email', 'required');
		$this->form_validation->set_rules('customer_phone', 'Customer Phone', 'required');
		$this->form_validation->set_rules('source', 'Lead Source', 'required');
		$this->form_validation->set_rules('product_id', 'Product', 'required');
		$this->form_validation->set_rules('status_id', ' Lead Status', 'required');
		$this->form_validation->set_rules('assigned_user_id', 'User Asignment', 'required');
		$this->form_validation->set_rules('priority', 'Lead Priority', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['stt' => 'error', 'msg' => validation_errors(), 'data' => '']);
		} else {
			$id = $this->input->post('lid') !== null ? $this->input->post('lid') : null; 
		
		
			$data = ['customer_name'     => $this->input->post('customer_name', TRUE),
					 'customer_email'    => $this->input->post('customer_email', TRUE),
					 'customer_phone'    => $this->input->post('customer_phone', TRUE),
					 'source'            => $this->input->post('source', TRUE),
					 'product_id'        => $this->input->post('product_id'),
					 'status_id'         => $this->input->post('status_id'),
					 'assigned_user_id'  => $this->input->post('assigned_user_id'),
					 'priority'          => $this->input->post('priority'),
					 'notes'             => $this->input->post('notes', TRUE),
					 'created_by'        => $this->session->userdata('user_id')
					];

			$this->db->insert($this->table, $data);
			$id = $this->db->insert_id();
			
			if($id){
				echo json_encode(array("stt"=>"ok","msg"=>"Lead Created Successfully !!","data"=>$id));
			}else{
				echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
			}
        }
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Lead Module','Create Lead','INSERT');
		//end of activity log
    }

    /**
     * Update lead
     */
    public function update() 
    {
		
		$id = $_POST['lid'];
		
		$data = ['customer_name'    => $this->input->post('customer_name', TRUE),
				 'customer_email'   => $this->input->post('customer_email', TRUE),
                 'customer_phone'   => $this->input->post('customer_phone', TRUE),
                 'source'           => $this->input->post('source', TRUE),
				 'product_id'       => $this->input->post('product_id'),
				 'status_id'        => $this->input->post('status_id'),
				 'assigned_user_id' => $this->input->post('assigned_user_id'),
				 'priority'         => $this->input->post('priority'),
				 'notes'            => $this->input->post('notes', TRUE)
				];
		
        $this->db->where('id', (int)$id)->update($this->table, $data);

		if($id){
			echo json_encode(array("stt"=>"ok","msg"=>"Lead Updated Successfully !!","data"=>$id));
		}else{
			echo json_encode(array("stt"=>"error","msg"=>"Something Went Wrong!!","data"=>''));
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Lead Module','Update Lead','UPDATE');
		//end of activity log

        //return $this->db->affected_rows();
    }

    /**
     * Change lead status + history
     */
    //public function change_status($lead_id, $status_id, $user_id)
    public function change_status($lead_id, $status_id)
    {
		
		$user_id ="1";
		
        $this->db->trans_start();

        // Get current status
        $current = $this->db
            ->select('status_id')
            ->where('id', (int)$lead_id)
            ->get($this->table)
            ->row();

        if (!$current) {
            $this->db->trans_complete();
            return false;
        }

        // Update lead
        $this->db
            ->where('id', (int)$lead_id)
            ->update($this->table, [
                'status_id' => (int)$status_id
            ]);

        // Insert history
        $this->db->insert('lead_status_history', [
            'lead_id'       => (int)$lead_id,
            'old_status_id' => (int)$current->status_id,
            'new_status_id' => (int)$status_id,
            'changed_by'    => (int)$user_id,
            'changed_at'    => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Update assigned user (current owner)
     * Assignment history is handled in LeadAssignment_model
     */
    public function update_assigned_user($lead_id, $user_id)
    {
        return $this->db
            ->where('id', (int)$lead_id)
            ->update($this->table, [
                'assigned_user_id' => (int)$user_id
            ]);
    }
	
	/*public function delete($id)
	{
		return $this->db->where('id', (int)$id)->delete('leads');
			
		if($id){
			echo json_encode(['stt' => 'error', 'msg' => 'Database transaction failed!', 'data' => '']);
		}else{
			echo json_encode(['stt' => 'ok', 'msg' => 'Lead Deleted Successfully!', 'data' => $id]);
		}				
	}*/
	
	public function delete($id)
	{
		$id = (int)$id;

		if (!$id) {
			echo json_encode(['stt' => 'error','msg' => 'Invalid ID!','data' => '']);
			return;
		}

		$this->db->where('id', $id);
		$update = $this->db->update('leads',['status' => 'delete']);

		if ($id) {
			echo json_encode(['stt' => 'ok','msg' => 'Lead Deleted Successfully!','data' => $id]);
		} else {
			echo json_encode(['stt' => 'error','msg' => 'Database transaction failed!','data' => '']);
		}
		
		//for activity log entry
		$user_id_fk = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('ut_id');
		$this->Activity_log_m->addLog($user_id_fk,$user_type,'Lead Module','Delete Lead','DELETE');
		//end of activity log
	}
	
	public function get_status_counts_single_row()
	{
		/*$this->db->select("COUNT(CASE WHEN status_id = 1 THEN 1 END) as new_count,
						   COUNT(CASE WHEN status_id = 2 THEN 1 END) as contacted_count,
			               COUNT(CASE WHEN status_id = 3 THEN 1 END) as qualified_count,
			               COUNT(CASE WHEN status_id = 4 THEN 1 END) as closed_count");
		
		return $this->db->get('leads')->row();*/
		$this->db->select('ls.name, ls.color, COUNT(l.id) as total ,ls.id as lid');
		$this->db->from('lead_statuses ls');
		$this->db->join('leads l', 'l.status_id = ls.id', 'left');
		$this->db->where('ls.is_active', 1);
		$this->db->group_by('ls.id');
		$this->db->order_by('ls.sort_order', 'ASC');

		return $this->db->get()->result_array();
		
	}
	
}
