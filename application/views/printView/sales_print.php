  
	<!-- =========================
		 INVOICE FOOTER DETAILS
	========================= -->

	<style>
		.invoice-footer-details {
			width: 100%;
			margin-top: 25px;
			font-family: Arial, Helvetica, sans-serif;
			color: #222;
			font-size: 12px;
		}

		.invoice-footer-grid {
			display: table;
			width: 100%;
			border-collapse: collapse;
			table-layout: fixed;
		}

		.invoice-footer-column {
			display: table-cell;
			width: 50%;
			vertical-align: top;
			padding: 0 8px;
		}

		.invoice-footer-column:first-child {
			padding-left: 0;
			padding-right: 15px;
		}

		.invoice-footer-column:last-child {
			padding-left: 15px;
			padding-right: 0;
		}

		/* Section Heading */
		.invoice-section-title {
			font-size: 13px;
			font-weight: bold;
			text-transform: uppercase;
			padding-bottom: 7px;
			margin-bottom: 8px;
			border-bottom: 2px solid #222;
		}

		/* Terms */
		.invoice-terms {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		.invoice-terms li {
			position: relative;
			padding-left: 15px;
			margin-bottom: 7px;
			line-height: 1.5;
		}

		.invoice-terms li::before {
			content: "•";
			position: absolute;
			left: 0;
			font-weight: bold;
		}

		/* Bank Details */
		.bank-details {
			border: 1px solid #d9d9d9;
			margin-bottom: 8px;
			padding: 9px 10px;
			background: #fafafa;
			border-radius: 3px;
		}

		.bank-name {
			font-weight: bold;
			font-size: 12px;
			margin-bottom: 5px;
		}

		.bank-row {
			display: table;
			width: 100%;
			margin-bottom: 2px;
			line-height: 1.45;
		}

		.bank-label {
			display: table-cell;
			width: 105px;
			font-weight: bold;
			vertical-align: top;
		}

		.bank-value {
			display: table-cell;
			vertical-align: top;
		}

		/* Print Optimization */
		@media print {
			.invoice-footer-details {
				page-break-inside: avoid;
			}

			.bank-details {
				page-break-inside: avoid;
			}
		}
	</style>
  
  <!-- Meta Information -->
  <div class="meta">
    <div class="meta-cell">
      <div class="mc-label">Invoice Number</div>
      <div class="mc-val"><?php echo $invoice->invoice_no; ?></div>
    </div>
    <div class="meta-cell">
      <div class="mc-label">Date</div>
      <div class="mc-val"><?php echo date('d-m-Y', strtotime($invoice->invoice_date)); ?></div>
    </div>
    <div class="meta-cell">
      <div class="mc-label">Due Date</div>
      <div class="mc-val"><?php echo date('d-m-Y', strtotime($invoice->due_date)); ?></div>
    </div>
    <div class="meta-cell">
      <div class="mc-label">Status</div>
      <div class="mc-val" style="text-transform: uppercase;"><?php echo $invoice->status; ?></div>
    </div>
  </div>

  <!-- Parties Section -->
  <div class="parties">
    <div class="party">
      <div class="party-label">Customer</div>
      <div class="party-name"><?php echo $invoice->customer_name ?? 'Walk-in Customer'; ?></div>
      <div class="party-info">
        <?php echo $invoice->customer_address ?? ''; ?><br>
        <?php echo $invoice->customer_phone ?? ''; ?>
      </div>
    </div>
    <div class="party">
      <div class="party-label">Payment Info</div>
      <div class="party-name">Status: <?php echo $invoice->payment_status ?? 'PENDING'; ?></div>
      <div class="party-info">
         Payment Method: <?php echo $invoice->payment_method_string ?? 'Not specified'; ?><br>
        <?php if(isset($invoice->paid_amount) && $invoice->paid_amount > 0): ?>
        Paid: LKR <?php echo number_format($invoice->paid_amount, 2); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Items Table -->
  <table class="tbl">
    <thead>
      <tr>
        <th style="width:30px">#</th>
        <th style="width:70px">Code</th>
        <th>Product</th>
        <th class="r" style="width:45px">Unit</th>
        <th class="r" style="width:50px">Qty</th>
        <th class="r" style="width:45px">Free</th>
        <th class="r" style="width:70px">Unit Price</th>
        <th class="r" style="width:50px">Disc.</th>
        <th class="r" style="width:45px">Tax</th>
        <th class="r" style="width:80px">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($invoice->items)): ?>
        <?php foreach($invoice->items as $i => $item): ?>
        <tr>
          <td><?php echo $i+1; ?></td>
          <td><span class="code"><?php echo $item->product_code ?? 'N/A'; ?></span></td>
          <td>
              <span class="pname"><?php echo $item->product_name; ?></span>
              <small><?php echo $item->product_code; ?></small>
           </td>
          <td class="r"><?php echo $item->unit_name ?? 'Pcs'; ?></td>
          <td class="r"><?php echo number_format($item->qty, 2); ?></td>
          <td class="r"><?php echo number_format($item->free_qty, 2); ?></td>
          <td class="r"><?php echo number_format($item->unit_price, 2); ?></td>
          <td class="r"><?php echo number_format($item->discount_value, 2); ?></td>
          <td class="r"><?php echo number_format($item->tax_value, 2); ?></td>
          <td class="r"><?php echo number_format($item->line_total, 2); ?></td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="10" class="c" style="text-align:center; padding:20px;">No items found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Bottom Section -->
  <div class="bottom">
    <div class="notes">
      <div class="notes-label">Remarks</div>
      <?php echo $invoice->remarks ?? 'No remarks'; ?>
    </div>
    <div class="summary">
      <div class="sum-row">
        <span class="sum-label">Subtotal</span>
        <span class="sum-val">LKR <?php echo number_format($invoice->subtotal, 2); ?></span>
      </div>
      <?php if($invoice->bill_discount_value > 0): ?>
      <div class="sum-row">
        <span class="sum-label">Bill Discount</span>
        <span class="sum-val">- LKR <?php echo number_format($invoice->bill_discount_value, 2); ?></span>
      </div>
      <?php endif; ?>
      <div class="sum-row">
        <span class="sum-label">Total Tax</span>
        <span class="sum-val">LKR <?php echo number_format($invoice->tax_total, 2); ?></span>
      </div>
      <div class="sum-total">
        <span>Grand Total (LKR)</span>
        <span class="sum-val"><?php echo number_format($invoice->grand_total, 2); ?></span>
      </div>
      <?php if($invoice->paid_amount > 0): ?>
      <div class="sum-row" style="border-top:1px solid var(--line); margin-top:5px; padding-top:5px;">
        <span class="sum-label">Paid Amount</span>
        <span class="sum-val">LKR <?php echo number_format($invoice->paid_amount, 2); ?></span>
      </div>
      <div class="sum-row">
        <span class="sum-label">Balance Amount</span>
        <span class="sum-val">LKR <?php echo number_format($invoice->balance_amount, 2); ?></span>
      </div>
      <?php endif; ?>
    </div>
  </div>


	

	<div class="invoice-footer-details">

		<div class="invoice-footer-grid">

			<?php 
				$configs = $this->session->userdata('sys_config');
				echo $configs['inv_ter_pay'];
			?>

		</div>

	</div>
	
	<!-- Signatures -->
	<div class="sigs">
		<div>
		  <div class="sig-box"></div>
		  <div class="sig-label">Prepared By</div>
		  <div class="sig-name"><?php echo $invoice->prepared_by_name ?? '....................'; ?></div>
		</div>
		<div>
		  <div class="sig-box"></div>
		  <div class="sig-label">Checked By</div>
		  <div class="sig-name">....................</div>
		</div>
		<div>
		  <div class="sig-box"></div>
		  <div class="sig-label">Approved By</div>
		  <div class="sig-name">....................</div>
		</div>
		<div>
		  <div class="sig-box"></div>
		  <div class="sig-label">Received By</div>
		  <div class="sig-name"><?php echo $invoice->customer_name ?? '....................'; ?></div>
		</div>
	</div>