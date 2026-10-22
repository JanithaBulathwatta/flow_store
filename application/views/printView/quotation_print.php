  <!-- Meta Information -->
  <div class="meta">
    <div class="meta-cell">
      <div class="mc-label">Quotation Number</div>
      <div class="mc-val"><?php echo str_replace('INV-', 'QUO-', $invoice->invoice_no); ?></div>
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
		
		
	<div class="terms">
		<?php 
			$configs = $this->session->userdata('sys_config');
			echo $configs['terms'];
		?>
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