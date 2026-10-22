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
      <h1><i class="fa-solid fa-shopping-cart" style="font-size:16px;margin-right:8px;color:var(--primary);"></i>Sales Report</h1>
      <p>Sales information breakdowns by category and date range</p>
    </div>
  </div>
  
  <!-- FILTERS SYSTEM CARD -->
  <div class="card custom-card mb-3 padding-b">
	<div class="card-body py-3">
		<div class="row g-2 align-items-end">
			<div class="col-sm-6 col-md-4 col-xl-3">
				<label class="form-label fw-medium fs-12 mb-1">Category</label>
				<select class="form-select form-select-sm" id="Category">
					<option value="">All Catogery</option>
					<?php foreach($sub_categories as $sub_category): ?>
						<option value="<?= $sub_category->id ?>"><?= $sub_category->name ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="col-sm-6 col-md-4 col-xl-3">
				<label class="form-label fw-medium fs-12 mb-1">Brand</label>
				<select class="form-select form-select-sm" id="brand">
					<option value="">All brand</option>
					<?php foreach($brands as $brand): ?>
						<option value="<?= $brand->brand_id ?>"><?= $brand->brand_name ?></option>
					<?php endforeach; ?>
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
      <div class="tab-item active" onclick="switchTab('all',this)"><i class="fa-solid fa-money-bill-wave"></i>All Sales<span class="tc" id="tc-all">0</span></div>
    </div>
    
    <div class="tab-body">
      <div class="tab-pane active" id="tab-all"><div id="log-all"></div></div>
      
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
	var SALES_DATA = [];
	
	function loadSalesReportData() {
		var categoryId    = $('#Category').val();
		var dateRange     = $('#fDateRange').val();
		var brand     = $('#brand').val();
		
		$('#log-all').html('<div class="p-4 text-center text-muted">Loading sales report details...</div>');

		$.ajax({
			url: '/SalesReport/sales_report_filter', 
			type: 'POST',
			dataType: 'json',
			data: {
				category_id: categoryId,
				date_range: dateRange,
				brand:brand
			},
			success: function(res) {
				SALES_DATA = (res && res.data) ? res.data : []; 
				renderAllTabs();
			},
			error: function() {
				$('#log-all').html('<div class="empty-state text-danger"><i class="fa-solid fa-triangle-exclamation"></i><p>Failed to retrieve report data.</p></div>');
			}
		});
	}

	/* ─── HELPER: GROUP DATA BY CATEGORY ─── */
	function groupByCategory(dataArray) {
		return dataArray.reduce(function(groups, item) {
			var category = item.sub_category_name || 'Uncategorized';
			if (!groups[category]) {
				groups[category] = [];
			}
			groups[category].push(item);
			return groups;
		}, {});
	}

	/* ─── RENDER LISTS & DOM TABLES ─── */
	/*function renderLog(containerId, dataRows){
		// 1. Clear any existing DataTable instance attached to a table inside this container first
		if ($.fn.DataTable.isDataTable('#' + containerId + ' table')) {
			$('#' + containerId + ' table').DataTable().clear().destroy();
		}

		if(!dataRows || !dataRows.length){
			$('#'+containerId).html('<div class="empty-state"><i class="fa-solid fa-inbox"></i><p>No sales records match your filters.</p></div>');
			return;
		}

		var groupedData = groupByCategory(dataRows);
		var grandTotalQty = 0;
		var grandTotalAmount = 0;
		
		$('#tc-all').text(dataRows.length);

		var tableHtml = '<div class="toolbar mb-2">'
			+ '<span class="rc fw-semibold text-secondary">' + dataRows.length + ' line items sold</span>'
			+ '</div>'
			+ '<div class="tbl-wrap">'
			+ '<table class="tbl table table-stripe text-nowrap w-100">' 
			+ '<thead class="table-light">'
				+ '<tr>'
					+ '<th class="ps-3">Product Code</th>'
					+ '<th>Product Name</th>'
					+ '<th>Sale Date</th>'
					+ '<th style="text-align:center;">Qty</th>'
					+ '<th style="text-align:right;">Unit Price</th>'
					+ '<th style="text-align:right;" class="pe-3">Total Price</th>'
				+ '</tr>'
			+ '</thead>'
			+ '<tbody>';

		Object.keys(groupedData).forEach(function(categoryName) {
			var items = groupedData[categoryName];
			
			// Category group separator row
			tableHtml += '<tr class="category-group-row" style="background-color: #f1f3f5 !important; font-weight: 600; pointer-events: none;">'
				+ '<td colspan="6" style=" background-color:#f1f3f5 !important; color: #3d52a0; font-size: 14px; padding: 10px 15px; border-bottom: 1px solid #dee2e6;">'
					+ '<i class="fa-solid fa-tags me-2 "></i>' + categoryName
				+ '</td>'
			+ '</tr>';

			// Individual product detail lines
			items.forEach(function(item) {
				var qty = parseFloat(item.qty) || 0;
				var totalPrice = parseFloat(item.total_price) || 0;

				grandTotalQty += qty;
				grandTotalAmount += totalPrice;

				tableHtml += '<tr style="background-color: #ffffff !important;">'
					+ '<td class="ps-3" style="font-size:12px; color:var(--text-muted);">' + (item.product_code || '—') + '</td>'
					+ '<td style="font-weight: 500; font-size:12px;">' + item.product_name + '</td>'
					+ '<td style="font-size:12px; color: #6c757d;">' + item.sale_date + '</td>'
					+ '<td style="text-align:center; font-size:12px; font-weight: 500;">' + qty + '</td>'
					+ '<td style="text-align:right; font-size:12px;" class="mono">' + parseFloat(item.unit_price).toFixed(2) + '</td>'
					+ '<td style="text-align:right; font-size:12px;" class="mono fw-bold text-dark pe-3">' + totalPrice.toFixed(2) + '</td>'
					+ '</tr>';
			});
		});

		tableHtml += '</tbody>';

		// Grand Summary Layout inside tfoot
		tableHtml += '<tfoot class="table-light" style="font-weight: 700; border-top: 2px solid #dee2e6;">'
			+ '<tr>'
				+ '<td colspan="3" style="text-align: right; font-size: 12px; text-transform: uppercase; color: #495057;" class="pe-3">Grand Total:</td>'
				+ '<td style="text-align: center; font-size: 13px;" class="mono text-dark">' + grandTotalQty + '</td>'
				+ '<td></td>' 
				+ '<td style="text-align: right; font-size: 14px;" class="mono text-success fw-bold pe-3">' + grandTotalAmount.toFixed(2) + '</td>'
			+ '</tr>'
			+ '</tfoot>';

		tableHtml += '</table></div>';

		// 2. Inject the HTML into your container element
		$('#' + containerId).html(tableHtml);

		// 3. Initialize your specialized theme initializer, or fallback cleanly with static grouping preservation
		if (typeof initializeDataTable === "function") {
			initializeDataTable('#' + containerId + ' table');
		} else {
			$('#' + containerId + ' table').DataTable();
		}
	}*/
	
	/* ─── RENDER LISTS & DOM TABLES ─── */
	function renderLog(containerId, dataRows){
		// 1. Clear any existing DataTable instance attached to a table inside this container first
		if ($.fn.DataTable.isDataTable('#' + containerId + ' table')) {
			$('#' + containerId + ' table').DataTable().clear().destroy();
		}

		if(!dataRows || !dataRows.length){
			$('#'+containerId).html('<div class="empty-state"><i class="fa-solid fa-inbox"></i><p>No sales records match your filters.</p></div>');
			return;
		}

		// Group data first to keep native categorical order intact
		var groupedData = groupByCategory(dataRows);
		var grandTotalQty = 0;
		var grandTotalAmount = 0;
		
		

		var tableHtml = '<div class="toolbar mb-2">'
			//+ '<span class="rc fw-semibold text-secondary">' + dataRows.length + ' line items sold</span>'
			+ '</div>'
			+ '<div class="tbl-wrap">'
			+ '<table class="tbl table table-stripe text-nowrap w-100">' 
			+ '<thead class="table-light">'
				+ '<tr>'
					+ '<th class="ps-3">Product Code</th>'
					+ '<th>Product Name</th>'
					+ '<th>Brand Name</th>'
					+ '<th>Sale Date</th>'
					+ '<th style="text-align:center;">Qty</th>'
					+ '<th style="text-align:right;">Unit Price</th>'
					+ '<th style="text-align:right;" class="pe-3">Total Price</th>'
				+ '</tr>'
			+ '</thead>'
			+ '<tbody>';

		// Loop through categories to populate structural data lines safely
		Object.keys(groupedData).forEach(function(categoryName) {
			var items = groupedData[categoryName];
			
			items.forEach(function(item) {
				var qty = parseFloat(item.qty) || 0;
				var totalPrice = parseFloat(item.total_price) || 0;

				grandTotalQty += qty;
				grandTotalAmount += totalPrice;

				// We add 'data-category' directly onto the row so it remains flat for the custom plugin calculation
				tableHtml += '<tr style="background-color: #ffffff !important;" data-category="' + categoryName + '">'
					+ '<td class="ps-3" style="font-size:12px; color:var(--text-muted);">' + (item.product_code || '—') + '</td>'
					+ '<td style="font-weight: 500; font-size:12px;">' + item.product_name + '</td>'
					+ '<td style="font-weight: 500; font-size:12px;">' + item.brand + '</td>'
					+ '<td style="font-size:12px; color: #6c757d;">' + item.sale_date + '</td>'
					+ '<td style="text-align:center; font-size:12px; font-weight: 500;">' + qty + '</td>'
					+ '<td style="text-align:right; font-size:12px;" class="mono">' + parseFloat(item.unit_price).toFixed(2) + '</td>'
					+ '<td style="text-align:right; font-size:12px;" class="mono fw-bold text-dark pe-3">' + totalPrice.toFixed(2) + '</td>'
					+ '</tr>';
			});
		});

		tableHtml += '</tbody>';

		// Grand Summary Layout inside tfoot
		tableHtml += '<tfoot class="table-light" style="font-weight: 700; border-top: 2px solid #dee2e6;">'
			+ '<tr>'
				+ '<td colspan="4" style="text-align: right; font-size: 12px; text-transform: uppercase; color: #495057;" class="pe-3">Grand Total:</td>'
				+ '<td style="text-align: center; font-size: 13px;" class="mono text-dark">' + grandTotalQty + '</td>'
				+ '<td></td>' 
				+ '<td style="text-align: right; font-size: 14px;" class="mono text-success fw-bold pe-3">' + grandTotalAmount.toFixed(2) + '</td>'
			+ '</tr>'
			+ '</tfoot>';

		tableHtml += '</table></div>';

		// 2. Inject the base HTML layout into your container element
		$('#' + containerId).html(tableHtml);

		// ─── INSTANT PAGINATION EVENT LISTENER ───
		$('#' + containerId).on('draw.dt', 'table', function (e, settings) {
			var finalTable = $(this);
			
			// Flush out older category structural rows from a previous state view
			finalTable.find('.category-group-row').remove();

			var lastCategory = null;

			// Reiterate active context records visible within the active page pane
			finalTable.find('tbody tr').each(function() {
				var row = $(this);
				var currentCategory = row.attr('data-category');

				if (currentCategory && currentCategory !== lastCategory) {
					var categoryRowHtml = '<tr class="category-group-row" style="background-color: #f1f3f5 !important; font-weight: 600; pointer-events: none;">'
						+ '<td colspan="7" style="background-color:#f1f3f5 !important; color: #3d52a0; font-size: 14px; padding: 10px 15px; border-bottom: 1px solid #dee2e6; text-align: left;">'
							+ '<i class="fa-solid fa-tags me-2"></i>' + currentCategory
						+ '</td>'
					+ '</tr>';
					
					row.before(categoryRowHtml);
					lastCategory = currentCategory;
				}
			});
		});

		// 3. Initialize your specialized theme initializer, or fallback cleanly
		if (typeof initializeDataTable === "function") {
			initializeDataTable('#' + containerId + ' table');
		} else {
			$('#' + containerId + ' table').DataTable();
		}
	}
	

	function renderAllTabs(){
		renderLog('log-all', SALES_DATA);
		$('#tc-all').text(SALES_DATA.length);
	}

	/* ─── FILTERS ACTION BINDINGS ─── */
	function applyFilters(){
		loadSalesReportData();
	}

	function resetFilters(){
		$('#Category').val('');
		$('#fDateRange').val('');
		$('#brand').val('');
		loadSalesReportData();
	}

	$(document).ready(function() {
		loadSalesReportData();
	});
</script>