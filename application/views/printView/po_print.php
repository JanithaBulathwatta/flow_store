<div class="meta">
  <div class="meta-cell">
    <div class="mc-label">Prepared By</div>
    <div class="mc-val"><?php echo $po->prepared_by_name ?? 'N/A'; ?></div>
  </div>
  <div class="meta-cell">
    <div class="mc-label">Approved By</div>
    <div class="mc-val"><?php echo $po->approved_by_name ?? 'Pending'; ?></div>
  </div>
  <div class="meta-cell p">
    <div class="mc-label">Payment Terms</div>
    <div class="mc-val">Next <?php echo $po->cred_period; ?> Days</div> </div>
  <div class="meta-cell g" style="display:none">
    <div class="mc-label">PO Reference</div>
    <div class="mc-val"><?php echo $po->po_number; ?></div>
  </div>
</div>

<div class="parties">
  <div class="party">
    <div class="party-label">Supplier</div>
    <div class="party-name"><?php echo $po->supplier_name; ?></div>
    <div class="party-info">
      <?php echo $po->supplier_address; ?><br>
      <?php echo $po->supplier_phone; ?>
    </div>
  </div>
  <div class="party">
    <div class="party-label p">Deliver To</div>
    <div class="party-name"><?php echo $po->company->company_name ; ?></div> <div class="party-info">
      <?php echo $po->company->company_addr ?? ''; ?><br>
      <span class="p">Expected: <?php echo date('d M Y', strtotime($po->expected_date)); ?></span>
    </div>
  </div>
</div>

<table class="tbl">
  <thead>
    <tr>
      <th style="width:22px">#</th>
      <th style="width:68px">Code</th>
      <th>Product</th>
      <th class="r" style="width:36px">Unit</th>
      <th class="r p" style="width:40px">Qty</th>
      <th class="r" style="width:72px">Unit Price</th>
      <th class="r" style="width:44px">Disc.</th>
      <th class="r" style="width:38px">Tax</th>
      <th class="r" style="width:80px">Total</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($po->items)): ?>
      <?php foreach($po->items as $index => $item): ?>
      <tr>
        <td><?php echo $index + 1; ?></td>
        <td><span class="code"><?php echo $item->product_code; ?></span></td>
        <td>
          <span class="pname">
            <?php echo $item->product_name; ?>
          </span>
        </td>
        <td class="c"><?php echo $item->unit_code; ?></td>
        <td class="r p"><?php echo number_format($item->quantity, 2); ?></td>
        <td class="r"><?php echo number_format($item->unit_price, 2); ?></td>
        <td class="r">
          <?php 
            if($item->discount_value > 0) {
              echo ($item->discount_type == 'percent') ? $item->discount_value.'%' : number_format($item->discount_value, 2);
            } else {
              echo '—';
            }
          ?>
        </td>
        <td class="r"><?php echo ($item->tax_value > 0) ? number_format($item->tax_value, 2) : '—'; ?></td>
        <td class="r"><?php echo number_format($item->line_total, 2); ?></td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="9" style="text-align:center;">No items found</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<div class="bottom">
  <div class="notes">
    <div class="notes-label">Notes</div>
    <?php echo !empty($po->remarks) ? nl2br($po->remarks) : 'All items must meet quality standards. Substitutions require prior approval.'; ?>
  </div>
  <div class="summary">
    <div class="sum-row">
      <span class="sum-label">Subtotal</span>
      <span class="sum-val"><?php echo number_format($po->subtotal, 2); ?></span>
    </div>
    <div class="sum-row">
      <span class="sum-label">Discount</span>
      <span class="sum-val">− <?php echo number_format($po->discount_value, 2); ?></span>
    </div>
    <div class="sum-row">
      <span class="sum-label">Tax Total</span>
      <span class="sum-val">+ <?php echo number_format($po->tax_total, 2); ?></span>
    </div>
    <div class="sum-total">
      <span>Total (LKR)</span>
      <span class="sum-val"><?php echo number_format($po->grand_total, 2); ?></span>
    </div>
  </div>
</div>

<div class="sigs">
  <div>
    <div class="sig-box"></div>
    <div class="sig-label">Prepared By</div>
    <div class="sig-name"><?php echo $po->prepared_by_name ?? '....................'; ?></div>
  </div>
  <div>
    <div class="sig-box"></div>
    <div class="sig-label">Checked By</div>
    <div class="sig-name"><?php //echo $po->prepared_by_name ?? '....................'; ?></div> </div>
  <div>
    <div class="sig-box"></div>
    <div class="sig-label">Approved By</div>
    <div class="sig-name"><?php echo $po->approved_by_name ?? '....................'; ?></div>
  </div>
  <div>
    <div class="sig-box"></div>
    <div class="sig-label p">Supplier Signature</div>
    <div class="sig-name p"><?php echo $po->supplier_name; ?></div>
  </div>
</div>