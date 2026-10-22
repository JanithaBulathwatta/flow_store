<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Sales Quotation — <?php echo str_replace('INV-', 'QUO-', $invoice->invoice_no); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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
  grid-template-columns:1fr 1fr 1fr 1fr;
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
  @page{size:A4 portrait;margin:15mm}
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
        padding-top: 50px;
        padding-bottom: 50px;
    }
}
</style>
</head>
<body id="B" class="sales">

<div class="bar d-print-none">
  <span class="bar-title">Quotation Preview</span>
  <button class="btn" onclick="window.print()">Print / PDF</button>
  <button class="btn" onclick="downloadInvoicePDF()">Download</button>
  <button class="btn" onclick="window.close()">Close</button>
</div>

<div class="page">
	<div class="hd">
		<!-- LEFT SIDE -->
		<div style="display:flex; align-items:center; gap:12px;">
			
			<!-- LOGO -->
			<?php
				$com_logo = $this->session->userdata('company_logo');
			?>
			<img src="/uploads/<?php echo $com_logo; ?>" alt="logo" width="140" height="60" style="width:140px; height:60px; object-fit:cover; border-radius:6px; margin-left:-18px; display:block;">

			<!-- COMPANY DETAILS -->
			<div>
				<div class="co-name">
					<?php echo isset($invoice->company) && $invoice->company 
						? $invoice->company->company_name 
						: 'Your Company Name'; ?>
				</div>

				<div class="co-sub">
					<?php if(isset($invoice->company) && $invoice->company): ?>
						<?php echo $invoice->company->company_addr ?? ''; ?><br>
						Phone: <?php echo $invoice->company->company_contact_1 ?? ''; ?>
						<?php if(!empty($invoice->company->company_contact_2)): ?>
							/ <?php echo $invoice->company->company_contact_2; ?>
						<?php endif; ?><br>

						Email: <?php echo $invoice->company->company_email_1 ?? ''; ?>
						<?php if(!empty($invoice->company->company_email_2)): ?>
							/ <?php echo $invoice->company->company_email_2; ?>
						<?php endif; ?><br>

						<?php if(!empty($invoice->company->company_web)): ?>
							Web: <?php echo $invoice->company->company_web; ?>
						<?php endif; ?>
					<?php else: ?>
						Sri Lanka · +94 77 000 0000<br>
						No. 123, Galle Road, Colombo 03
					<?php endif; ?>
				</div>
			</div>

		</div>

		<!-- RIGHT SIDE -->
		<div class="doc-right">
			<div class="doc-type">Quotation </div>
			<div class="doc-num"><?php echo str_replace('INV-', 'QUO-', $invoice->invoice_no); ?></div>
			<div class="doc-date"><?php echo date('d F Y', strtotime($invoice->invoice_date)); ?></div>
		</div>
</div>

<script>
	function downloadInvoicePDF() {
	  var invoiceNo = <?php echo json_encode(str_replace('INV-', 'QUO-', $invoice->invoice_no)); ?>;
	  var safeName = invoiceNo.replace(/[^a-zA-Z0-9\-_]/g, "-");

	  var element = document.querySelector('.page');

	  var opt = {
		margin:       0,
		filename:     safeName + '.pdf',
		image:        { type: 'jpeg', quality: 0.98 },
		html2canvas:  { scale: 2, useCORS: true },
		jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
	  };

	  var btn = event.target;
	  var originalText = btn.textContent;
	  btn.textContent = 'Generating...';
	  btn.disabled = true;

	  html2pdf().set(opt).from(element).save().then(function() {
		btn.textContent = originalText;
		btn.disabled = false;
	  }).catch(function(err) {
		console.error(err);
		btn.textContent = originalText;
		btn.disabled = false;
		alert('Failed to generate PDF. Please try again.');
	  });
	}
</script>