<style>
	/* ── COMPACT CHARTS CARD ── */
	.charts-compact{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;margin-bottom:12px;}
	.cc-head{padding:10px 16px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:8px;}
	.cc-head h6{font-size:12px;font-weight:700;color:var(--text-dark);margin:0;flex:1;}
	.cc-inner{display:grid;grid-template-columns:2fr 1fr 1fr;gap:0;}
	.cc-panel{padding:12px 14px;border-right:1px solid var(--card-border);}
	.cc-panel:last-child{border-right:none;}
	.cc-panel-title{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);margin-bottom:8px;}
	.sec-icon{width:24px;height:24px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:10px;flex-shrink:0;}

	/* ── BADGES ── */
	.badge{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;}
	
	/* Payment Methods */
	.ch-cash{background:#e0f2fe;color:#0369a1;}
	.ch-card{background:var(--purple-light);color:#6d28d9;}
	.ch-bank{background:var(--teal-light);color:#0f766e;}
	.ch-cheque{background:var(--orange-light);color:#c2410c;}
	.ch-credit{background:var(--danger-light);color:#991b1b;}

	/* Invoice Payment Statuses */
	.st-paid{background:var(--success-light);color:#065f46;}
	.st-partial{background:var(--warning-light);color:#92400e;}
	.st-unpaid{background:var(--danger-light);color:#991b1b;}

	/* ── EMPTY ── */
	.empty-state{text-align:center;padding:40px 20px;color:var(--text-muted);}
	.empty-state i{font-size:34px;opacity:.2;display:block;margin-bottom:8px;}
	.empty-state p{font-size:12px;}
	
	.padding-b{
		margin-bottom:25px !important;
		padding-bottom:10px !important;
	}
	.m-lef{
		margin-left:35px;
	}
</style>

<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<!-- MAIN -->
<main class="main">

  <!-- PAGE HEADER -->
  <div class="pg-hdr">
    <div class="pg-hdr-l">
      <h1><i class="fa-solid fa-credit-card" style="font-size:16px;margin-right:8px;color:var(--primary);"></i>Payment Report</h1>
      <p>Payment information breakdowns by customer and collections</p>
    </div>
  </div>
  
  <!-- FILTERS SYSTEM CARD -->
  <div class="card custom-card mb-3 padding-b">
	<div class="card-body py-3">
		<div class="row g-2 align-items-end">
			<div class="col-sm-6 col-md-4 col-xl-3">
				<label class="form-label fw-medium fs-12 mb-1">Customer</label>
				<select class="form-select form-select-sm" id="fCustomer">
					<option value="">All Customers</option>
					<?php foreach($customers as $customer): ?>
						<option value="<?= $customer->cus_id ?>"><?= $customer->cus_name ?> <?= !empty($customer->company_name) ? '('.$customer->company_name.')' : '' ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-sm-6 col-md-4 col-xl-3">
				<label class="form-label fw-medium fs-12 mb-1">Payment status</label>
				<select class="form-select form-select-sm" id="fPaymentstatus" name="status">
					<option value="">All status</option>
					<option value="PARTIAL">PARTIAL</option>
					<option value="PAID">PAID</option>
				</select>
			</div>
			<div class="col-sm-6 col-md-4 col-xl-3">
				<label class="form-label fw-medium fs-12 mb-1">Date Range</label>
				<div class="input-group input-group-sm">
					<input type="text" class="date-range-input daterangepicker-field form-control-sm" placeholder="Select Date Range" data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" id="fDateRange" name="date_range"/>
				</div>
			</div>
			<div class="col-sm-6 col-md-4 col-xl-3">
				<div class="d-flex gap-2">
					<button class="btn btn-primary btn-sm flex-fill d-inline-flex align-items-center justify-content-center" onclick="applyFilters()">
						<i class="ri-filter-line me-1"></i>Apply Filters
					</button>
					<button class="btn btn-light btn-sm" onclick="resetFilters()" title="Reset Filters">
						<i class="ri-refresh-line"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

  <!-- TAB COLLECTION LOG -->
  <div class="tab-card">
    <div class="tabs-header">
      <div class="tab-item active" onclick="switchTab('all',this)"><i class="fa-solid fa-money-bill-wave"></i>All Payments<span class="tc" id="tc-all">0</span></div>
      <!--<div class="tab-item" onclick="switchTab('cash',this)"><i class="fa-solid fa-wallet"></i>Cash<span class="tc" id="tc-cash">0</span></div>
      <div class="tab-item" onclick="switchTab('cheque',this)"><i class="fa-solid fa-money-check"></i>Cheque<span class="tc" id="tc-cheque">0</span></div>
      <div class="tab-item" onclick="switchTab('card',this)"><i class="fa-solid fa-credit-card"></i>Card / Bank<span class="tc" id="tc-card">0</span></div>-->
    </div>
    
    <div class="tab-body">
      <div class="tab-pane active" id="tab-all"><div id="log-all"></div></div>
      <div class="tab-pane" id="tab-cash"><div id="log-cash"></div></div>
      <div class="tab-pane" id="tab-cheque"><div id="log-cheque"></div></div>
      <div class="tab-pane" id="tab-card"><div id="log-card"></div></div>
    </div>
  </div>

</main>

<!-- PREVIEW DRAWER PANEL (For Reference Details) -->
<div class="preview-panel" id="preview-panel">
  <div class="pp-head">
    <h5 id="pp-title">Transaction Details</h5>
    <button class="pp-close" onclick="closePreview()"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div class="pp-body" id="pp-body"></div>
</div>

<div id="toast-c"></div>

<script>
	/* ═══════════════════════ DATA HANDLERS ═══════════════════════ */
	var PAYMENTS = [];
	
	// Core collection fetching function
	function loadPaymentReportData() {
		var customerId    = $('#fCustomer').val();
		var dateRange     = $('#fDateRange').val();
		var status     = $('#fPaymentstatus').val();

		$.ajax({
			url: '/PaymentReport/payment_report_filter', 
			type: 'POST',
			dataType: 'json',
			data: {
				customer_id: customerId,
				date_range: dateRange,
				status:status
			},
			success: function(res) {
				PAYMENTS = res.data;
				renderAllTabs();
			}
		});
	}


	/* ─── RENDER LISTS & DOM TABLES ─── */
	function renderLog(containerId, dataRows){
		// 1. Clear any existing DataTable instance attached to a table inside this container first
		if ($.fn.DataTable.isDataTable('#' + containerId + ' table')) {
			$('#' + containerId + ' table').DataTable().clear().destroy();
		}

		if(!dataRows.length){
			$('#'+containerId).html('<div class="empty-state"><i class="fa-solid fa-inbox"></i><p>No payment records found.</p></div>');
			return;
		}

		var tableHtml = '<div class="toolbar">'
			//+'<span class="rc">'+dataRows.length+' collection transactions</span>'
		  +'</div>'
		  +'<div class="tbl-wrap"><table class="tbl table table-stripe text-nowrap w-100">' 
		  +'<thead><tr>'
			+'<th>Payment Date</th>'
			+'<th>Invoice No</th>'
			+'<th>Customer</th>'
			+'<th style="text-align:left;">Collection Amount</th>'
			+'<th style="text-align:center;">Invoice Status</th>'
		  +'</tr></thead><tbody>'+dataRows.map(function(p){
			
			var statusLower = p.invoice_payment_status.toLowerCase();
			var statusBadge = '<span class="badge st-'+statusLower+'">'+p.invoice_payment_status+'</span>';

			return '<tr onclick="openPreview('+p.payment_id+')">'
			  +'<td style="font-size:12px;color:var(--text-muted);white-space:nowrap;">'+p.payment_date+'</td>'
			  +'<td style="font-weight:600;font-size:12px;color:var(--primary);">'+(p.invoice_no || '—')+'</td>'
			  +'<td style="font-weight:600;font-size:12px;">'+p.cus_name+'</td>'
			  +'<td style="text-align:right;"><span class="mono fw-bold text-success" style="font-size:12px;">'+parseFloat(p.payment_batch_total).toFixed(2)+'</span></td>'
			  +'<td style="text-align:center;">'+statusBadge+'</td>'
			+'</tr>';
		}).join('')+'</tbody></table></div>';

		// 2. Inject the HTML into your container element
		$('#'+containerId).html(tableHtml);

		// 3. Initialize the DataTable plugin on the newly rendered table inside the container
		if (typeof initializeDataTable === "function") {
			initializeDataTable('#' + containerId + ' table');
		} else {
			$('#' + containerId + ' table').DataTable();
		}
	}

	function renderAllTabs(){
		// Renders all dynamic rows into the main pane container cleanly
		renderLog('log-all', PAYMENTS);

		// Dynamic updates for simple counter indicator
		$('#tc-all').text(PAYMENTS.length);
	}

	/* ─── FILTERS ACTION BINDINGS ─── */
	function applyFilters(){
		loadPaymentReportData();
	}

	function resetFilters(){
		$('#fCustomer').val('');
		$('#fDateRange').val('');
		$('#fPaymentstatus').val('');
		loadPaymentReportData();
	}

	function switchTab(tabName, element) {
		$('.tab-item').removeClass('active');
		$(element).addClass('active');
		$('.tab-pane').removeClass('active');
		$('#tab-' + tabName).addClass('active');
	}

	// Local data filter search input inside lists
	function filterLog(containerId, searchVal) {
		var cleanSearch = searchVal.toLowerCase();
		$('#' + containerId + ' tbody tr').each(function() {
			var rowText = $(this).text().toLowerCase();
			if (rowText.indexOf(cleanSearch) > -1) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
	}


	// Document Initializer
	$(document).ready(function() {
		loadPaymentReportData();
	});
</script>