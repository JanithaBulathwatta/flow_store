<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesReport_model extends CI_Model {
	
	public function get_sales_report($sub_category_id = null, $brand = null, $date_range = null)
	{
		$this->db
			->select('
				sc.name AS sub_category_name,
				p.product_code,
				sii.product_name,
				si.invoice_date AS sale_date,
				sii.unit_price,
				sii.qty,
				sii.line_total AS total_price,
				b.brand_name AS brand
			')
			->from('sales_invoice_items sii')
			->join('products p', 'p.id = sii.product_id', 'left')
			->join('brands b', 'b.brand_id = p.brand_id', 'left')
			->join('sub_category sc', 'sc.id = p.sub_category_id', 'left')
			->join('sales_invoices si', 'si.id = sii.invoice_id', 'left'); // Kept only for invoice_date

		// Filter by Sub-Category
		if (!empty($sub_category_id)) {
			$this->db->where('p.sub_category_id', $sub_category_id);
		}
		
		// Filter by brand
		if (!empty($brand)) {
			$this->db->where('p.brand_id', $brand);
		}

		// Filter by Date Range (Checking against Invoice Date)
		if (!empty($date_range)) {
			$dates = explode(' – ', $date_range);

			if (count($dates) == 2) {
				$start = date('Y-m-d 00:00:00', strtotime(trim($dates[0])));
				$end   = date('Y-m-d 23:59:59', strtotime(trim($dates[1])));

				$this->db->where('si.invoice_date >=', $start);
				$this->db->where('si.invoice_date <=', $end);
			}
		}

		// Order by Category name, then by recent date
		return $this->db
			->order_by('sc.name', 'ASC')
			->order_by('si.invoice_date', 'DESC')
			->get()
			->result();
	}
}