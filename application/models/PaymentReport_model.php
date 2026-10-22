<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentReport_model extends CI_Model {
	
	public function get_payment_report($customer_id = null, $status = null, $date_range = null)
	{
		$this->db
			->select('
				sp.id AS payment_id,
				sp.payment_date,
				sp.total_amount AS payment_batch_total,
				
				si.invoice_no,
				si.invoice_date,
				si.grand_total AS invoice_grand_total,
				si.paid_amount AS invoice_total_paid,
				si.balance_amount AS invoice_balance,
				si.payment_status AS invoice_payment_status,
				
				c.cus_id,
				c.cus_name,
				c.company_name,
				c.cus_phone
			')
			->from('sales_payments sp')
			->join('sales_invoices si', 'si.id = sp.invoice_id', 'left')
			->join('customer c', 'c.cus_id = si.customer_id', 'left');

		// Filter by Customer
		if (!empty($customer_id)) {
			$this->db->where('si.customer_id', $customer_id);
		}
		
		// Filter by Stauts
		if (!empty($status)) {
			$this->db->where('si.payment_status', $status);
		}

		// Filter by Date Range
		if (!empty($date_range)) {
			$dates = explode(' – ', $date_range);

			if (count($dates) == 2) {
				$start = date('Y-m-d 00:00:00', strtotime(trim($dates[0])));
				$end   = date('Y-m-d 23:59:59', strtotime(trim($dates[1])));

				$this->db->where('sp.payment_date >=', $start);
				$this->db->where('sp.payment_date <=', $end);
			}
		}

		return $this->db
			->order_by('sp.payment_date', 'DESC')
			->get()
			->result();
	}
}