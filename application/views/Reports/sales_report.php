<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!--
	  Bootstrap CSS removed: all styling now comes from the project dashboard theme below.
	  Keep jQuery and Chart.js exactly as before. Font Awesome + Google Fonts added for the
	  icons and typography used by the dashboard design (remove if your layout already loads them).
	-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700;800&display=swap">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

	<style>
	:root{
	  --primary:#3d52a0;--primary-d:#2d3d80;--primary-light:#eef1fb;--primary-mid:#c5cff7;
	  --success:#10b981;--success-light:#d1fae5;--success-d:#059669;
	  --danger:#ef4444;--danger-light:#fee2e2;
	  --warning:#f59e0b;--warning-light:#fef3c7;
	  --info:#0ea5e9;--info-light:#e0f2fe;
	  --purple:#8b5cf6;--purple-light:#ede9fe;
	  --teal:#14b8a6;--teal-light:#ccfbf1;
	  --orange:#f97316;--orange-light:#ffedd5;
	  --page-bg:#f2f4fa;--card-bg:#fff;--card-border:#e4e9f4;
	  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
	  --input-border:#d1d9e6;--table-head:#f7f9ff;
	  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.10);
	  --r-sm:8px;--r-md:12px;--r-lg:16px;--tr:.2s cubic-bezier(.4,0,.2,1);
	}

	/* ── PAGE SHELL ── */
	#srPage{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;padding:20px 22px;}
	#srPage *,#srPage *::before,#srPage *::after{box-sizing:border-box;}
	#srPage ::-webkit-scrollbar{width:5px;height:5px;}
	#srPage ::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}
	.sr-loading{opacity:.5;pointer-events:none}

	/* helper classes emitted by the existing JS */
	#srPage .num{text-align:right}
	#srPage .text-center{text-align:center}
	#srPage .text-muted{color:var(--text-muted)!important}
	#srPage .text-success{color:var(--success-d)!important}
	#srPage .text-danger{color:var(--danger)!important}
	#srPage .font-weight-bold{font-weight:800}

	/* ── HERO ── */
	.sr-hero{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-lg);box-shadow:var(--sh-sm);margin-bottom:16px;overflow:hidden;}
	.sr-hero-banner{background:linear-gradient(120deg,#1a1f36 0%,#2d3d80 45%,#3d52a0 100%);padding:22px 26px;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;}
	.sr-hero-banner::before{content:'';position:absolute;top:-60px;right:-60px;width:260px;height:260px;border-radius:50%;background:rgba(255,255,255,.04);}
	.sr-hero-banner::after{content:'';position:absolute;bottom:-30px;left:35%;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.03);}
	.sr-hero-text{position:relative;z-index:1;}
	.sr-code{font-family:'JetBrains Mono',monospace;font-size:11px;color:rgba(255,255,255,.55);font-weight:600;letter-spacing:.5px;margin-bottom:5px;}
	.sr-title{font-size:21px;font-weight:800;color:#fff;letter-spacing:-.3px;line-height:1.2;margin:0;}
	.sr-sub{font-size:13px;color:rgba(255,255,255,.65);margin-top:5px;display:flex;align-items:center;gap:6px;}
	.sr-hero-actions{position:relative;z-index:1;display:flex;gap:8px;}

	/* ── BUTTONS ── */
	#srPage .btn{padding:9px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;justify-content:center;gap:7px;line-height:1.2;}
	#srPage .btn-primary{background:var(--primary);color:#fff;box-shadow:0 2px 8px rgba(61,82,160,.22);}
	#srPage .btn-primary:hover{background:var(--primary-d);transform:translateY(-1px);}
	#srPage .btn-ho{background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.22);backdrop-filter:blur(8px);}
	#srPage .btn-ho:hover{background:rgba(255,255,255,.22);}
	#srPage .btn-block{width:100%;}

	/* ── GENERIC CARD ── */
	.sr-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;margin-bottom:16px;}
	.sr-card-head{padding:12px 16px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:8px;}
	.sr-card-head h6{font-size:12px;font-weight:700;color:var(--text-dark);margin:0;flex:1;}
	.sec-icon{width:26px;height:26px;border-radius:6px;background:var(--primary-light);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:11px;flex-shrink:0;}
	.sr-card-body{padding:14px 16px;}

	/* ── FILTERS ── */
	.sr-filter-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;align-items:end;}
	.sr-field label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-mid);display:block;margin-bottom:5px;}
	#srPage .fc{width:100%;padding:9px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr),box-shadow var(--tr);background:#fff;}
	#srPage .fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
	#srPage .fc::placeholder{color:var(--text-muted);}

	/* ── KPI GRID ── */
	.sr-kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px;}
	.sr-kpi{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:16px 18px;box-shadow:var(--sh-sm);transition:all var(--tr);position:relative;overflow:hidden;}
	.sr-kpi:hover{transform:translateY(-2px);box-shadow:var(--sh-md);}
	.sr-kpi::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
	.sr-kpi.k-sales::before{background:linear-gradient(90deg,var(--primary),#7b8dd1);}
	.sr-kpi.k-count::before{background:linear-gradient(90deg,var(--purple),#a78bfa);}
	.sr-kpi.k-paid::before{background:linear-gradient(90deg,var(--success),#34d399);}
	.sr-kpi.k-bal::before{background:linear-gradient(90deg,var(--danger),#f87171);}
	.sr-kpi.k-avg::before{background:linear-gradient(90deg,var(--teal),#2dd4bf);}
	.sr-kpi.k-disc::before{background:linear-gradient(90deg,var(--warning),#fbbf24);}
	.sr-kpi.k-tax::before{background:linear-gradient(90deg,var(--orange),#fb923c);}
	.sr-kpi.k-sub::before{background:linear-gradient(90deg,var(--info),#38bdf8);}
	.sr-kpi-icon{width:38px;height:38px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:10px;}
	.sr-kpi h4{font-size:22px;font-weight:800;color:var(--text-dark);font-family:'JetBrains Mono',monospace;line-height:1;margin:0;}
	.sr-kpi small{display:block;font-size:10px;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-top:6px;}

	/* ── CHARTS ROW ── */
	.sr-charts-row{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px;}
	.sr-charts-row .sr-card{margin-bottom:0;display:flex;flex-direction:column;}

	/* ── TOOLBAR ── */
	.sr-toolbar{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
	.sr-toolbar h6{font-size:12px;font-weight:700;color:var(--text-dark);margin:0;flex:1;display:flex;align-items:center;gap:8px;}
	.sw{position:relative;min-width:200px;}
	.sw i{position:absolute;left:9px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;pointer-events:none;}
	.sw input{width:100%;padding:7px 9px 7px 28px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;color:var(--text-dark);outline:none;transition:border-color var(--tr);background:#fff;}
	.sw input:focus{border-color:var(--primary);}
	.sw input::placeholder{color:var(--text-muted);}

	/* ── TABLE ── */
	.tbl-wrap{overflow-x:auto;border-radius:var(--r-md);border:1px solid var(--card-border);}
	.tbl{width:100%;border-collapse:collapse;min-width:580px;margin:0;}
	.tbl thead tr{background:var(--table-head);}
	.tbl th{padding:10px 13px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);border-bottom:2px solid var(--card-border);text-align:left;white-space:nowrap;}
	.tbl th.num{text-align:right;}
	.tbl td{padding:10px 13px;font-size:13px;border-bottom:1px solid var(--card-border);vertical-align:middle;}
	.tbl td.num{font-family:'JetBrains Mono',monospace;font-size:12px;}
	.tbl tbody tr:last-child td{border-bottom:none;}
	.tbl tbody tr{transition:background var(--tr);}
	.tbl tbody tr:hover{background:#fafbff;}
	.tbl tfoot td{background:var(--table-head);border-top:2px solid var(--card-border);border-bottom:none;font-size:13px;}
	#srInvoices td,#srInvoices th{white-space:nowrap}
	#srInvoices td:first-child{font-family:'JetBrains Mono',monospace;font-size:11px;font-weight:600;color:var(--primary);}

	/* ── BADGES ── */
	#srPage .badge{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;}
	#srPage .badge-success{background:var(--success-light);color:#065f46;}
	#srPage .badge-warning{background:var(--warning-light);color:#92400e;}
	#srPage .badge-danger{background:#fee2e2;color:#991b1b;}
	#srPage .badge-secondary{background:var(--primary-light);color:var(--primary);}

	/* ── RESPONSIVE ── */
	@media (max-width:1100px){
	  .sr-filter-grid{grid-template-columns:repeat(3,1fr);}
	  .sr-kpi-grid{grid-template-columns:repeat(2,1fr);}
	  .sr-charts-row{grid-template-columns:1fr;}
	}
	@media (max-width:575px){
	  .sr-filter-grid{grid-template-columns:repeat(2,1fr);}
	  #srPage{padding:14px 12px;}
	}
	
	h1 {
		color: #fff !important;
	}

	</style>

	<div class="main-content app-content">
		<div id="srPage">

		  <!-- Hero -->
		  <div class="sr-hero">
			<div class="sr-hero-banner">
			  <div class="sr-hero-text">
				<div class="sr-code">Reports · Sales</div>
				<h1 class="sr-title"><?php echo html_escape($title); ?></h1>
				<div class="sr-sub"><i class="fa-solid fa-chart-line" style="font-size:11px;"></i> Sales, collections and outstanding balances for the selected period</div>
			  </div>
			  <div class="sr-hero-actions">
				<button class="btn btn-ho" id="srExport" type="button"><i class="fa-solid fa-file-csv"></i>Export CSV</button>
			  </div>
			</div>
		  </div>

		  <!-- Filters -->
		  <div class="sr-card">
			<div class="sr-card-head">
			  <div class="sec-icon"><i class="fa-solid fa-filter"></i></div>
			  <h6>Filters</h6>
			</div>
			<div class="sr-card-body">
			  <form id="srFilters" class="sr-filter-grid">
				<div class="sr-field">
				  <label>From</label>
				  <input type="date" name="from" class="fc" value="<?php echo date('Y-m-01'); ?>">
				</div>
				<div class="sr-field">
				  <label>To</label>
				  <input type="date" name="to" class="fc" value="<?php echo date('Y-m-d'); ?>">
				</div>
				<div class="sr-field">
				  <label>Status</label>
				  <select name="status" class="fc">
					<option value="VALID">All sales</option>
					<option value="COMPLETED">Completed</option>
					<option value="HIRE PURCHASE">Hire purchase</option>
					<option value="PROJECT">Project</option>
					<option value="RETURNED">Returned</option>
					<option value="CANCELLED">Cancelled</option>
					<option value="DRAFT">Draft</option>
					<option value="QUOTATION">Quotation</option>
				  </select>
				</div>
				<div class="sr-field">
				  <label>Invoice type</label>
				  <select name="invoice_type" class="fc">
					<option value="">All</option>
					<option value="PROJECT">Project</option>
					<option value="OTHER">Other</option>
				  </select>
				</div>
				<div class="sr-field">
				  <label>Payment</label>
				  <select name="payment_status" class="fc">
					<option value="">All</option>
					<option value="PAID">Paid</option>
					<option value="PARTIAL">Partial</option>
					<option value="UNPAID">Unpaid</option>
				  </select>
				</div>
				<div class="sr-field">
				  <button type="submit" class="btn btn-primary btn-block"><i class="fa-solid fa-magnifying-glass"></i>Show report</button>
				</div>
			  </form>
			</div>
		  </div>

		  <!-- KPIs -->
		  <div class="sr-kpi-grid" id="srKpis">
			<div class="sr-kpi k-sales">
			  <div class="sr-kpi-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-sack-dollar"></i></div>
			  <h4 id="kGrand">0.00</h4><small>Net sales</small>
			</div>
			<div class="sr-kpi k-count">
			  <div class="sr-kpi-icon" style="background:var(--purple-light);color:var(--purple);"><i class="fa-solid fa-file-invoice"></i></div>
			  <h4 id="kCount">0</h4><small>Invoices</small>
			</div>
			<div class="sr-kpi k-paid">
			  <div class="sr-kpi-icon" style="background:var(--success-light);color:var(--success);"><i class="fa-solid fa-money-bill-wave"></i></div>
			  <h4 id="kPaid" class="text-success">0.00</h4><small>Collected</small>
			</div>
			<div class="sr-kpi k-bal">
			  <div class="sr-kpi-icon" style="background:var(--danger-light);color:var(--danger);"><i class="fa-solid fa-scale-balanced"></i></div>
			  <h4 id="kBal" class="text-danger">0.00</h4><small>Outstanding</small>
			</div>
			<div class="sr-kpi k-avg">
			  <div class="sr-kpi-icon" style="background:var(--teal-light);color:var(--teal);"><i class="fa-solid fa-calculator"></i></div>
			  <h4 id="kAvg">0.00</h4><small>Average invoice</small>
			</div>
			<div class="sr-kpi k-disc">
			  <div class="sr-kpi-icon" style="background:var(--warning-light);color:var(--warning);"><i class="fa-solid fa-tags"></i></div>
			  <h4 id="kDisc">0.00</h4><small>Line discounts</small>
			</div>
			<div class="sr-kpi k-tax">
			  <div class="sr-kpi-icon" style="background:var(--orange-light);color:var(--orange);"><i class="fa-solid fa-percent"></i></div>
			  <h4 id="kTax">0.00</h4><small>Tax</small>
			</div>
			<div class="sr-kpi k-sub">
			  <div class="sr-kpi-icon" style="background:var(--info-light);color:var(--info);"><i class="fa-solid fa-layer-group"></i></div>
			  <h4 id="kSub">0.00</h4><small>Subtotal</small>
			</div>
		  </div>

		  <!-- Charts -->
		  <div class="sr-charts-row">
			<div class="sr-card">
			  <div class="sr-card-head">
				<div class="sec-icon"><i class="fa-solid fa-chart-column"></i></div>
				<h6>Daily sales</h6>
			  </div>
			  <div class="sr-card-body">
				<div style="height:260px"><canvas id="cDaily"></canvas></div>
			  </div>
			</div>
			<div class="sr-card">
			  <div class="sr-card-head">
				<div class="sec-icon" style="background:var(--success-light);color:var(--success);"><i class="fa-solid fa-chart-pie"></i></div>
				<h6>Collections by method</h6>
			  </div>
			  <div class="sr-card-body">
				<div style="height:260px"><canvas id="cPay"></canvas></div>
			  </div>
			</div>
		  </div>

		  <!-- Top products -->
		  <div class="sr-card">
			<div class="sr-card-head">
			  <div class="sec-icon" style="background:var(--purple-light);color:var(--purple);"><i class="fa-solid fa-boxes-stacked"></i></div>
			  <h6>Top products by revenue</h6>
			</div>
			<div class="sr-card-body">
			  <div class="tbl-wrap">
				<table class="tbl" id="srProducts">
				  <thead><tr><th>Product</th><th class="num">Qty</th><th class="num">Free qty</th><th class="num">Revenue</th></tr></thead>
				  <tbody></tbody>
				</table>
			  </div>
			</div>
		  </div>

		  <!-- Invoices -->
		  <div class="sr-card">
			<div class="sr-card-body">
			  <div class="sr-toolbar" style="margin-bottom:12px;">
				<h6><span class="sec-icon"><i class="fa-solid fa-file-invoice"></i></span>Invoices</h6>
				<div class="sw">
				  <i class="fa-solid fa-magnifying-glass"></i>
				  <input type="search" id="srSearch" placeholder="Search invoice or customer">
				</div>
			  </div>
			  <div class="tbl-wrap">
				<table class="tbl" id="srInvoices">
				  <thead>
					<tr>
					  <th>Invoice</th><th>Date</th><!--<th>Customer ID</th>--><th>Type</th><th>Status</th><th>Payment</th>
					  <th class="num">Total</th><th class="num">Paid</th><th class="num">Balance</th>
					</tr>
				  </thead>
				  <tbody></tbody>
				  <tfoot></tfoot>
				</table>
			  </div>
			</div>
		  </div>
		</div>
	</div>

<script>
(function ($) {
  var URL_DATA = '<?php echo site_url("/Report/sales_data"); ?>';
  var dailyChart = null, payChart = null, rows = [];

  function n(v) { return parseFloat(v) || 0; }
  function money(v) { return n(v).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); }
  function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }
  function badge(s) {
    var c = {PAID: 'success', PARTIAL: 'warning', UNPAID: 'danger'}[s] || 'secondary';
    return '<span class="badge badge-' + c + '">' + esc(s) + '</span>';
  }

  function load() {
    var $page = $('#srPage').addClass('sr-loading');
    $.ajax({url: URL_DATA, type: 'GET', dataType: 'json', data: $('#srFilters').serialize()})
      .done(function (res) {
        if (!res || !res.success) { alert('Could not load the report.'); return; }
        renderKpis(res.summary);
        renderDaily(res.daily);
        renderPayments(res.payments);
        renderProducts(res.products);
        rows = res.invoices;
        renderInvoices();
      })
      .fail(function () { alert('Request failed. Check your connection and try again.'); })
      .always(function () { $page.removeClass('sr-loading'); });
  }

  function renderKpis(s) {
    $('#kGrand').text(money(s.grand_total));
    $('#kCount').text(s.invoices);
    $('#kPaid').text(money(s.paid_amount));
    $('#kBal').text(money(s.balance_amount));
    $('#kAvg').text(money(s.avg_invoice));
    $('#kDisc').text(money(s.line_discount));
    $('#kTax').text(money(s.tax_total));
    $('#kSub').text(money(s.subtotal));
  }

  function renderDaily(d) {
    if (dailyChart) dailyChart.destroy();
    dailyChart = new Chart(document.getElementById('cDaily'), {
      type: 'bar',
      data: {
        labels: d.map(function (x) { return x.day; }),
        datasets: [{label: 'Sales', data: d.map(function (x) { return n(x.total); }), backgroundColor: '#2f45ff', borderRadius: 3}]
      },
      options: {maintainAspectRatio: false, plugins: {legend: {display: false}}, scales: {y: {beginAtZero: true}}}
    });
  }

  function renderPayments(p) {
    if (payChart) payChart.destroy();
    payChart = new Chart(document.getElementById('cPay'), {
      type: 'doughnut',
      data: {
        labels: p.map(function (x) { return x.payment_method; }),
        datasets: [{data: p.map(function (x) { return n(x.total); }), backgroundColor: ['#2f45ff', '#12805c', '#e0a100', '#b8420d', '#6c757d']}]
      },
      options: {maintainAspectRatio: false, plugins: {legend: {position: 'bottom'}}}
    });
  }

  function renderProducts(list) {
    var h = list.length ? '' : '<tr><td colspan="4" class="text-center text-muted">No product sales in this period.</td></tr>';
    list.forEach(function (p) {
      h += '<tr><td>' + esc(p.name) + '</td><td class="num">' + n(p.qty) + '</td><td class="num">' + n(p.free_qty) +
           '</td><td class="num">' + money(p.revenue) + '</td></tr>';
    });
    $('#srProducts tbody').html(h);
  }

  function renderInvoices() {
    var q = $.trim($('#srSearch').val()).toLowerCase();
    var list = rows.filter(function (r) {
      return !q || (String(r.invoice_no) + ' ' + r.customer_id).toLowerCase().indexOf(q) > -1;
    });
    var h = list.length ? '' : '<tr><td colspan="9" class="text-center text-muted">No invoices match these filters.</td></tr>';
    var t = {g: 0, p: 0, b: 0};
    list.forEach(function (r) {
      t.g += n(r.grand_total); t.p += n(r.paid_amount); t.b += n(r.balance_amount);
      h += '<tr><td>' + esc(r.invoice_no || ('#' + r.id)) + '</td><td>' + esc(String(r.invoice_date).substr(0, 10)) +
           '</td><!--<td>' + esc(r.customer_id) + '</td>--><td>' + esc(r.invoice_type) + '</td><td>' + esc(r.status) +
           '</td><td>' + badge(r.payment_status) + '</td><td class="num">' + money(r.grand_total) +
           '</td><td class="num">' + money(r.paid_amount) + '</td><td class="num">' + money(r.balance_amount) + '</td></tr>';
    });
    $('#srInvoices tbody').html(h);
    $('#srInvoices tfoot').html(list.length
      ? '<tr class="font-weight-bold"><td colspan="5">Total (' + list.length + ')</td><td class="num">' + money(t.g) +
        '</td><td class="num">' + money(t.p) + '</td><td class="num">' + money(t.b) + '</td></tr>' : '');
  }

  function exportCsv() {
    var out = [['Invoice', 'Date', 'Customer ID', 'Type', 'Status', 'Payment', 'Total', 'Paid', 'Balance']];
    rows.forEach(function (r) {
      out.push([r.invoice_no, String(r.invoice_date).substr(0, 10), r.customer_id, r.invoice_type, r.status,
                r.payment_status, r.grand_total, r.paid_amount, r.balance_amount]);
    });
    var csv = out.map(function (line) {
      return line.map(function (c) { return '"' + String(c == null ? '' : c).replace(/"/g, '""') + '"'; }).join(',');
    }).join('\n');
    var a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([csv], {type: 'text/csv'}));
    a.download = 'sales-report.csv';
    a.click();
  }

  $('#srFilters').on('submit', function (e) { e.preventDefault(); load(); });
  $('#srSearch').on('input', renderInvoices);
  $('#srExport').on('click', exportCsv);
  load();
})(jQuery);
</script>