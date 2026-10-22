<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Project Invoice</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<style>
*{box-sizing:border-box;margin:0;padding:0}

:root{
  --ink:#111;
  --mid:#555;
  --lite:#999;
  --line:#ddd;
  --bg-row:#fafafa;
  --f:  'Inter',sans-serif;
  --fm: 'JetBrains Mono',monospace;
}

body{
  font-family:var(--f);
  font-size:12px;
  color:var(--ink);
  background:#d9d9d9;
  padding:20px 12px;
}

/* ── toolbar ── */
.bar{
  max-width:195mm;
  margin:0 auto 12px;
  display:flex;
  gap:6px;
  align-items:center;
}
.bar-title{
  font-family:var(--fm);
  font-size:10px;
  color:#666;
  letter-spacing:.08em;
  text-transform:uppercase;
  margin-right:auto;
}
.btn{
  font-family:var(--fm);
  font-size:10px;
  letter-spacing:.06em;
  text-transform:uppercase;
  border:1px solid #888;
  background:#fff;
  color:#333;
  padding:4px 12px;
  cursor:pointer;
  border-radius:2px;
  transition:all .12s;
}
.btn:hover,.btn.on{background:#111;color:#fff;border-color:#111}

/* ── page ── */
.page{
  max-width:195mm;
  margin:0 auto;
  background:#fff;
  padding:14mm 14mm 12mm;
  box-shadow:0 2px 20px rgba(0,0,0,.15);
}

/* ── header ── */
.hd{
  display:flex;
  justify-content:space-between;
  align-items:flex-end;
  padding-bottom:10px;
  border-bottom:1.5px solid var(--ink);
  margin-bottom:12px;
}
.co-name{font-size:15px;font-weight:700;letter-spacing:-.02em}
.co-sub{font-size:10px;color:var(--mid);margin-top:2px;line-height:1.6}
.doc-right{text-align:right}
.doc-type{
  font-family:var(--fm);
  font-size:9px;
  letter-spacing:.15em;
  text-transform:uppercase;
  color:var(--mid);
}
.doc-num{
  font-family:var(--fm);
  font-size:16px;
  font-weight:600;
  color:var(--ink);
  letter-spacing:-.02em;
}
.doc-date{font-size:10px;color:var(--mid);margin-top:1px}

/* ── meta row ── */
.meta{
  display:grid;
  grid-template-columns:1fr 1fr 1fr;
  gap:0;
  border:1px solid var(--line);
  margin-bottom:12px;
}
.meta-cell{
  padding:7px 10px;
  border-right:1px solid var(--line);
}
.meta-cell:last-child{border-right:none}
.mc-label{
  font-family:var(--fm);
  font-size:8px;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:var(--lite);
  margin-bottom:2px;
}
.mc-val{font-size:11px;font-weight:500;color:var(--ink)}

/* ── parties ── */
.parties{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px;
  margin-bottom:12px;
}
.party{padding:8px 10px;border:1px solid var(--line)}
.party-label{
  font-family:var(--fm);
  font-size:8px;
  letter-spacing:.15em;
  text-transform:uppercase;
  color:var(--lite);
  margin-bottom:5px;
}
.party-name{font-size:12px;font-weight:600;margin-bottom:2px}
.party-info{font-size:10.5px;color:var(--mid);line-height:1.65}

/* ── table ── */
.tbl{
  width:100%;
  border-collapse:collapse;
  margin-bottom:12px;
  font-size:11px;
}
.tbl thead th{
  font-family:var(--fm);
  font-size:8px;
  letter-spacing:.1em;
  text-transform:uppercase;
  color:var(--mid);
  padding:5px 7px;
  border-bottom:1.5px solid var(--ink);
  text-align:left;
  white-space:nowrap;
}
.tbl thead th.r{text-align:right}
.tbl tbody td{
  padding:6px 7px;
  border-bottom:1px solid var(--line);
  color:var(--ink);
  vertical-align:top;
}
.tbl tbody tr:last-child td{border-bottom:none}
.tbl tbody tr:nth-child(even) td{background:var(--bg-row)}
.tbl td.r{text-align:right;font-family:var(--fm);font-size:10.5px}
.tbl td.c{text-align:center}
.code{font-family:var(--fm);font-size:9.5px;color:var(--lite)}
.pname{font-size:11px;font-weight:500}
.pname small{display:block;font-size:9.5px;color:var(--mid);font-weight:400}

/* grn-only cols */
.g{display:none}
body.grn .g{display:table-cell}
body.grn .p{display:none}

/* ── bottom ── */
.bottom{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:16px;
}

.notes{flex:1;padding:8px 10px;border:1px solid var(--line);font-size:10.5px;color:var(--mid);line-height:1.7}
.notes-label{
  font-family:var(--fm);
  font-size:8px;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:var(--lite);
  margin-bottom:4px;
}

/* summary */
.summary{width:200px;flex-shrink:0}
.sum-row{
  display:flex;
  justify-content:space-between;
  padding:4px 0;
  border-bottom:1px solid var(--line);
  font-size:11px;
}
.sum-row:last-child{border-bottom:none}
.sum-label{color:var(--mid)}
.sum-val{font-family:var(--fm);font-weight:500;white-space:nowrap}
.sum-total{
  display:flex;
  justify-content:space-between;
  padding:7px 0 0;
  margin-top:4px;
  border-top:1.5px solid var(--ink);
  font-size:13px;
  font-weight:700;
}
.sum-total .sum-val{font-family:var(--fm)}

/* ── sigs ── */
.sigs{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:12px;
  margin-top:14px;
  padding-top:12px;
  border-top:1px solid var(--line);
}
.sig-box{padding-bottom:24px;border-bottom:1px solid var(--ink);margin-bottom:4px}
.sig-label{font-family:var(--fm);font-size:8px;letter-spacing:.1em;text-transform:uppercase;color:var(--lite)}
.sig-name{font-size:10px;color:var(--mid);margin-top:1px}

/* ── footer ── */
.ft{
  margin-top:12px;
  padding-top:7px;
  border-top:1px solid var(--line);
  display:flex;
  justify-content:space-between;
  font-family:var(--fm);
  font-size:8.5px;
  color:var(--lite);
}

/* ── print ── */
@media print{
  @page{size:A4 portrait;margin:10mm}
  body{background:#fff;padding:0}
  .bar{display:none!important}
  .page{max-width:100%;box-shadow:none;padding:0}
  thead{display:table-header-group}
  tr{page-break-inside:avoid}
  *{-webkit-print-color-adjust:exact;print-color-adjust:exact}
}

@media print {
    @page {
        margin-top: 0;
        margin-bottom: 0;
    }
    body {
        padding-top: 50px;    /* Adds space so your content doesn't hit the paper edge */
        padding-bottom: 50px;
    }
}

	<!-- =========================
		 INVOICE FOOTER DETAILS
	========================= -->

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
</head>
<body id="B" class="po">

<!-- toolbar -->
<div class="bar d-print-none">
  <span class="bar-title">Preview</span>
  <!--<button class="btn on" id="bPO" onclick="sw('po')">PO</button>
  <button class="btn" id="bGRN" onclick="sw('grn')">GRN</button>-->
  <button class="btn" onclick="print()">Print / PDF</button>
</div>

<div class="page">
	<div class="hd">
		<!-- LEFT SIDE -->
		<div style="display:flex; align-items:center; gap:12px;">
			
			<?php
				$com_logo      = $this->session->userdata('company_logo');
				$com_name      = $this->session->userdata('company_name');
				$company_addr  = $this->session->userdata('company_addr');
				$sys_info = $this->session->userdata('sys_info');
			?>

			<!-- LOGO -->
			<?php if (!empty($com_logo)): ?>
				<img src="<?= base_url('uploads/' . $com_logo); ?>"
					 alt="Company Logo"
					 style="width:140px; height:60px; object-fit:cover; border-radius:6px; margin-left:-18px;">
			<?php endif; ?>

			<!-- COMPANY DETAILS -->
			<div>
				<div class="co-name">
					<?= !empty($com_name) ? htmlspecialchars($com_name) : 'Your Company Name'; ?>
				</div>

				<div class="co-sub">
					<?php if (!empty($com_name)): ?>

						<?= htmlspecialchars($company_addr ?? '') ?><br>

						Phone: <?= htmlspecialchars($sys_info->company_contact_1 ?? '') ?> <?= !empty($sys_info->company_contact_2) ? ' / ' . htmlspecialchars($sys_info->company_contact_2) : '' ?>

					<?php else: ?> 

						Sri Lanka &nbsp;·&nbsp; +94 77 000 0000<br>
						No. 123, Galle Road, Colombo 03

					<?php endif; ?>
				</div>
			</div>

		</div>

		<!-- RIGHT SIDE -->
		<div class="doc-right">
			<div class="doc-type" id="dType">SALES INVOICE</div>
			<div class="doc-num" id="dNum"><?= htmlspecialchars($invoice->invoice_no) ?></div>
			<div class="doc-date"><?= $invoice->invoice_date ?></div>
		</div>

	
  
</div>


  <!-- Meta Information -->
  <div class="meta">
    <div class="meta-cell">
      <div class="mc-label">Invoice Number</div>
      <div class="mc-val"><?= htmlspecialchars($invoice->invoice_no) ?></div>
    </div>
    <div class="meta-cell">
      <div class="mc-label">Date</div>
      <div class="mc-val"><?= $invoice->invoice_date ?></div>
    </div>
    <div class="meta-cell">
      <div class="mc-label">Due Date</div>
      <div class="mc-val"><?= $invoice->due_date ?: '-' ?></div>
    </div>
    <!--<div class="meta-cell">
      <div class="mc-label">Status</div>
      <div class="mc-val" style="text-transform: uppercase;"></div>
    </div>-->
  </div>

  <!-- Parties Section -->
  <div class="parties">
    <div class="party">
      <div class="party-label">Customer</div>
      <div class="party-name"><?= $invoice->cus_name ?: '-' ?></div>
    </div>
    <div class="party">
      <div class="party-label">Payment Info</div>
      <div class="party-name">Status: <?php echo $invoice->payment_status ?? 'Reference Only'; ?></div>
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
        <th class="r" style="width:70px">Unit Price</th>
        <th class="r" style="width:50px">Disc.</th>
        <th class="r" style="width:80px">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($invoice->items)): ?>
        <?php $total_discount = 0; foreach($invoice->items as $i => $item): $total_discount += (float)$item->discount; ?>
		
        <tr>
          <td><?php echo $i+1; ?></td>
          <td><span class="code"><?php echo $item->product_code ?? 'N/A'; ?></span></td>
          <td>
              <span class="pname"><?php echo $item->product_name; ?></span>
              <small><?php echo $item->product_code; ?></small>
           </td>
          <td class="r"><?php echo $item->unit_name ?? 'Pcs'; ?></td>
          <td class="r"><?php echo number_format($item->qty, 2); ?></td>
          <td class="r"><?php echo number_format($item->unit_price, 2); ?></td>
          <td class="r"><?= number_format($item->discount, 2) ?></td>
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
		<span class="sum-label">Line Discount</span>
		<span class="sum-val">- LKR <?= number_format($total_discount, 2) ?></span>
	  </div>
	  <div class="sum-row">
		<span class="sum-label">Sub Total</span>
		<span class="sum-val">LKR <?= number_format($invoice->sub_total, 2) ?></span>
	  </div>
	  <div class="sum-row">
		<span class="sum-label">Invoice Discount</span>
		<span class="sum-val">- LKR <?= number_format($invoice->discount, 2) ?></span>
	  </div>
	  <?php if(isset($invoice->paid_amount) && $invoice->paid_amount > 0): ?>
	  <div class="sum-row">
		<span class="sum-label">Paid Amount</span>
		<span class="sum-val">LKR <?= number_format($invoice->paid_amount, 2) ?></span>
	  </div>
	  <div class="sum-row">
		<span class="sum-label">Balance</span>
		<span class="sum-val">LKR <?= number_format($invoice->balance, 2) ?></span>
	  </div>
	  <?php endif; ?>
	  <div class="sum-total">
		<span>Grand Total (LKR)</span>
		<span class="sum-val"><?php echo number_format($invoice->grand_total, 2); ?></span>
	  </div>
	</div>
  </div><br>
  
  
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
  
   <!-- footer -->
  <div class="ft">
    <span id="fDate"></span>
    <span>System Generated — Introps ERP</span>
    <span>Page 1 of 1</span>
  </div>

</div>


</body>
</html>