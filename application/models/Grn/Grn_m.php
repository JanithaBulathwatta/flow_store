<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grn_m extends CI_Model
{
	public function get_stores(){
		$res = $this->db->get('stores')->result();
		return $res;
	}	
   
	public function save_grn(){
	
		$this->load->library('form_validation');

		$this->form_validation->set_rules('fk_store_id', 'Store', 'required');
		$this->form_validation->set_rules('grn_date', 'GRN Date', 'required');
		$this->form_validation->set_rules('ref_no', 'Reference No', 'required');
		$this->form_validation->set_rules('fk_sup_id', 'Supplier', 'required');
		$this->form_validation->set_rules('fk_user_id', 'Received User', 'required');
		
		$this->form_validation->set_rules('item_id[]', 'Atleast 1 Item ', 'required');
		$this->form_validation->set_rules('purchase_price[]', 'Purchase Price ', 'required');
		$this->form_validation->set_rules('selling_price[]', 'Selling Price', 'required');
		$this->form_validation->set_rules('qty[]', 'Item Qty', 'required');

		if ($this->form_validation->run() == FALSE) {

			echo json_encode(['stt'=>'error','msg'=>validation_errors(),'data'=>'']);

		} else {

			$this->db->trans_start();

			$grn_data = [
				'ref_no'      => $this->input->post('ref_no', TRUE),
				'fk_store_id' => $this->input->post('fk_store_id'),
				'grn_date'    => $this->input->post('grn_date'),
				'fk_sup_id'   => $this->input->post('fk_sup_id'),
				'fk_user_id'  => $this->input->post('fk_user_id'),
				'grn_amount'  => $this->input->post('grn_amount'),
				'due_amount'  => $this->input->post('due_amt')
			];

			$this->db->insert('grn',$grn_data);
			$grn_id = $this->db->insert_id();


			/*$items = $this->input->post('fk_itm_id');

			if(!empty($items)){

				foreach($items as $item){

					$grn_item = [
						'fk_itm_id' => $item['item_id'],
						'p_pri'     => $item['purchase_price'],
						's_pri'     => $item['selling_price'],
						'qty'       => $item['qty'],
						'line_tot'  => $item['line_total']
					];

					$this->db->insert('grn_item',$grn_item);


					$stock = [
						'fk_itm_id'   => $item['item_id'],
						'in_amt'      => $item['qty'],
						'out_amt'     => 0,
						'trans_type'  => 'GRN',
						'line_tot'    => $item['line_total']
					];

					$this->db->insert('stock',$stock);

					$stock_id = $this->db->insert_id();


					$stock_price = [
						'fk_stock_id' => $stock_id,
						'fk_item_id'  => $item['item_id'],
						'sel_price'   => $item['selling_price']
					];

					$this->db->insert('stock_price',$stock_price);

				}

			}*/
			
			$item_ids = $this->input->post('item_id');
			$purchase_prices = $this->input->post('purchase_price');
			$selling_prices = $this->input->post('selling_price');
			$qtys = $this->input->post('qty');
			$line_totals = $this->input->post('line_total');

			for ($i = 0; $i < count($item_ids); $i++) {

				// GRN Item
				$grn_item = [
					'fk_itm_id' => $item_ids[$i],
					'p_pri' => $purchase_prices[$i],
					's_pri' => $selling_prices[$i],
					'qty' => $qtys[$i],
					'line_tot' => $line_totals[$i],
					'fk_grn_id' => $grn_id
				];

				$this->db->insert('grn_item', $grn_item);


				// Stock Insert
				$stock_data = [
					'fk_itm_id' => $item_ids[$i],
					'in_amt' => $qtys[$i],
					'out_amt' => 0,
					'trans_type' => 'GRN',
					'line_tot' => $line_totals[$i]
				];

				$this->db->insert('stock', $stock_data);

				$stock_id = $this->db->insert_id();


				// Stock Price Insert
				$stock_price = [
					'fk_stock_id' => $stock_id,
					'fk_item_id' => $item_ids[$i],
					'sel_price' => $selling_prices[$i]
				];

				$this->db->insert('stock_price', $stock_price);

			}

			$trans = [
				'ref'          => $this->input->post('ref_no'),
				'cash_amt'     => $this->input->post('cash_amt'),
				'card_amt'     => $this->input->post('card_amt'),

				'crd_numb'     => $this->input->post('crd_numb') ? $this->input->post('crd_numb') : NULL,
				'crd_exp_date' => $this->input->post('crd_exp_date') ? $this->input->post('crd_exp_date') : NULL,

				'chq_amt'      => $this->input->post('chq_amt'),
				'chq_no'       => $this->input->post('chq_no') ? $this->input->post('chq_no') : NULL,
				'chq_date'     => $this->input->post('chq_date') ? $this->input->post('chq_date') : NULL
			];

			$this->db->insert('transation', $trans);

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {

				echo json_encode(["stt"=>"error","msg"=>"Something Went Wrong!!","data"=>'']);

			} else {

				echo json_encode(["stt"=>"ok","msg"=>"GRN Saved Successfully !!","data"=>$grn_id]);

			}

		}

	}
	
	public function get_grn_list($filters = [])
	{
		$this->db->select('g.grn_id,g.ref_no,g.grn_date,g.grn_amount,g.due_amount,s.store_name,sup.name as supplier_name,u.full_name as received_by');
		$this->db->from('grn g');
		$this->db->join('stores s','s.store_id = g.fk_store_id','left');
		$this->db->join('supply sup','sup.id = g.fk_sup_id','left');
		$this->db->join('user u','u.user_id = g.fk_user_id','left');


		/* STORE FILTER */
		if(!empty($filters['fk_store_id'])){
			$this->db->where('g.fk_store_id', $filters['fk_store_id']);
		}

		/* SUPPLIER FILTER */
		if(!empty($filters['fk_sup_id'])){
			$this->db->where('g.fk_sup_id', $filters['fk_sup_id']);
		}

		/* USER FILTER */
		if(!empty($filters['fk_user_id'])){
			$this->db->where('g.fk_user_id', $filters['fk_user_id']);
		}

		/* DATE RANGE FILTER */
		if(!empty($filters['date_range'])){

			$dates = explode(' – ', $filters['date_range']);

			if(count($dates) == 2){

				$start = date('Y-m-d', strtotime($dates[0]));
				$end   = date('Y-m-d', strtotime($dates[1]));

				$this->db->where('DATE(g.grn_date) >=', $start);
				$this->db->where('DATE(g.grn_date) <=', $end);
			}
		}

		$this->db->order_by('g.grn_id','DESC');

		return $this->db->get()->result();
	}

	public function get_grn_items($grn_id)
	{
		$this->db->select('gi.qty,gi.p_pri,gi.s_pri,gi.line_tot,p.name as product_name,p.product_code');

		$this->db->from('grn_item gi');
		$this->db->join('products p','p.id = gi.fk_itm_id','left');

		$this->db->where('gi.fk_grn_id', $grn_id);

		return $this->db->get()->result();
	}
	
	public function get_grn_counts()
	{
		$total = $this->db->count_all('grn');

		$this->db->where('due_amount',0);
		$settled = $this->db->count_all_results('grn');

		$this->db->where('due_amount >',0);
		$outstanding = $this->db->count_all_results('grn');

		return [
			['name'=>'Total','total'=>$total],
			['name'=>'Settled','total'=>$settled],
			['name'=>'Outstanding','total'=>$outstanding]
		];
	}
	
	
   
}