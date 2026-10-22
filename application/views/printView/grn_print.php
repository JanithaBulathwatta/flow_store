<div class="meta">
  <div class="meta-cell">
    <div class="mc-label">GRN Number</div>
    <div class="mc-val"><?php echo $grn->grn_number; ?></div>
  </div>
  <div class="meta-cell">
    <div class="mc-label">Date</div>
    <div class="mc-val"><?php echo date('d-m-Y', strtotime($grn->grn_date)); ?></div>
  </div>
  <div class="meta-cell">
    <div class="mc-label">Status</div>
    <div class="mc-val" style="text-transform: uppercase;"><?php echo $grn->status; ?></div>
  </div>
</div>

<div class="parties">
  <div class="party">
    <div class="party-label">Supplier</div>
    <div class="party-name"><?php echo $grn->supplier_name; ?></div>
    <div class="party-info">
      <?php echo $grn->supplier_address; ?><br>
      <?php echo $grn->supplier_phone; ?>
    </div>
  </div>
  <div class="party">
    <div class="party-label">Delivery Note</div>
    <div class="party-info">
      <?php echo $grn->delivery_note ?? 'None'; ?>
    </div>
  </div>
</div>

<table class="tbl">
  <thead>
    <!--<tr>
      <th style="width:22px">#</th>
      <th>Product</th>
	  <th class="r">Unit</th>
      <th class="r">Qty</th>
      <th class="r">Unit Price</th>
      <th class="r">Disc.</th>
      <th class="r">Tax</th>
      <th class="r">Total</th>
    </tr>-->
	<tr>
        <th style="width:22px">#</th>
        <th style="width:68px">Code</th>
        <th>Product</th>
        <th class="r" style="width:36px">Unit</th>
        <!--<th class="r p" style="width:40px">Qty</th>-->
        <th class="r g" style="width:46px;display:none">Ord.</th>
        <th class="r g" style="width:46px;display:none">Recv.</th>
        <th class="r g" style="width:44px;display:none">Free</th>
        <th class="r" style="width:72px">Unit Price</th>
        <th class="r" style="width:44px">Disc.</th>
        <th class="r" style="width:38px">Tax</th>
        <th class="r" style="width:80px">Total</th>
      </tr>
  </thead>
  <tbody>
    <?php if(!empty($grn->items)): ?>
      <?php foreach($grn->items as $i => $item): ?>
      <tr>
        <td><?php echo $item->id; ?></td>
        <td><?php echo $item->product_code; ?></td>
        <td>
            <span class="pname"><?php echo $item->product_name; ?></span>
            <small><?php echo $item->product_code; ?></small>
        </td>
		<td class="r"><?php echo $item->unit_name; ?></td>
        <!--<td class="r"><?php echo number_format($item->quantity, 2); ?></td>-->
        <td class="r"><?php echo number_format($item->unit_price, 2); ?></td>
        <td class="r"><?php echo number_format($item->discount_value, 2); ?></td>
        <td class="r"><?php echo number_format($item->tax_value, 2); ?></td>
        <td class="r"><?php echo number_format($item->line_total, 2); ?></td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<div class="bottom">
  <div class="notes">
    <div class="notes-label">Remarks</div>
    <?php echo $grn->remarks; ?>
  </div>
  <div class="summary">
    <div class="sum-row">
        <span class="sum-label">Subtotal</span>
        <span class="sum-val"><?php echo number_format($grn->subtotal, 2); ?></span>
    </div>
    <div class="sum-row">
        <span class="sum-label">Total Tax</span>
        <span class="sum-val"><?php echo number_format($grn->tax_total, 2); ?></span>
    </div>
    <div class="sum-total">
        <span>Grand Total (LKR)</span>
        <span class="sum-val"><?php echo number_format($grn->grand_total, 2); ?></span>
    </div>
  </div>
</div>

<div class="sigs">
    <div>
        <div class="sig-box"></div>
        <div class="sig-label">Prepared By</div>
        <div class="sig-name">
            <?php echo $grn->prepared_by_name ?? '....................'; ?>
        </div>
    </div>

    <div>
        <div class="sig-box"></div>
        <div class="sig-label">Checked By</div>
        <div class="sig-name">
            <?php echo $grn->checked_by_name ?? '....................'; ?>
        </div>
    </div>

    <div>
        <div class="sig-box"></div>
        <div class="sig-label">Approved By</div>
        <div class="sig-name">
            <?php echo $grn->approved_by_name ?? '....................'; ?>
        </div>
    </div>

    <div>
        <div class="sig-box"></div>
        <div class="sig-label">Received By</div>
        <div class="sig-name">
            <?php echo $grn->received_by_name ?? '....................'; ?>
        </div>
    </div>
</div>