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
	
	/* Adjustment Types */
	.type-correction{background:#e0f2fe;color:#0369a1;}
	.type-damage{background:#fee2e2;color:#991b1b;}
	.type-loss{background:#ffedd5;color:#c2410c;}
	.type-expired{background:#f3e8ff;color:#6d28d9;}
	.type-count{background:#ccfbf1;color:#0f766e;}

	/* Statuses */
	.st-approved{background:var(--success-light);color:#065f46;}
	.st-submitted{background:var(--warning-light);color:#92400e;}
	.st-rejected{background:var(--danger-light);color:#991b1b;}

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

<main class="main">

  <div class="pg-hdr">
    <div class="pg-hdr-l">
      <h1><i class="fa-solid fa-boxes-stacked" style="font-size:16px;margin-right:8px;color:var(--primary);"></i>Stock Adjustments</h1>
      <p>Manage and audit structural stock inventory adjustment files</p>
    </div>
  </div>
  
  <div class="card custom-card mb-3 padding-b">
	<div class="card-body py-3">
		<div class="row g-2 align-items-end">
			<div class="col-sm-6 col-md-4 col-xl-3">
				<label class="form-label fw-medium fs-12 mb-1">Adjustment Type</label>
				<select class="form-select form-select-sm" id="adjustment_type">
					<option value="">All Types</option>
					<option value="CORRECTION">Correction</option>
					<option value="DAMAGE">Damage</option>
					<option value="LOSS">Loss</option>
					<option value="EXPIRED">Expired</option>
					<option value="STOCK_COUNT">Stock Count</option>
				</select>
			</div>
			
			<div class="col-sm-6 col-md-4 col-xl-3">
				<label class="form-label fw-medium fs-12 mb-1">Status</label>
				<select class="form-select form-select-sm" id="status">
					<option value="">All Statuses</option>
					<option value="submitted">Submitted</option>
					<option value="approved">Approved</option>
					<option value="rejected">Rejected</option>
				</select>
			</div>

			<div class="col-sm-6 col-md-4 col-xl-3">
				<label class="form-label fw-medium fs-12 mb-1">Date Range</label>
				
					<input type="text" class="date-range-input daterangepicker-field form-control-sm w-100" 
									   placeholder="Select Date Range" 
									   data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" />
				
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

  <div class="tab-card">
    <div class="tabs-header">
      <div class="tab-item active"><i class="fa-solid fa-clipboard-list"></i>Adjustment Log<span class="tc" id="tc-all">0</span></div>
    </div>
    
    <div class="tab-body">
      <div class="tab-pane active" id="tab-all"><div id="log-all"></div></div>
    </div>
  </div>

</main>

<div class="modal fade" id="adjustmentItemsModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius: var(--r-md); overflow: hidden;">
      <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
        <h5 class="modal-title" id="pp-title" style="font-size:14px; font-weight:700;">Adjustment Items Breakdown</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="pp-body" style="padding:16px; max-height: 70vh; overflow-y: auto;">
        </div>
      <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 10px 16px;">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="toast-c"></div>

<script>
	/* ═══════════════════════ DATA HANDLERS ═══════════════════════ */
	var ADJUSTMENT_DATA = [];
	
	function loadAdjustmentReportData() {
		var adjustmentType = $('#adjustment_type').val();
		var status         = $('#status').val();
		var dateRange      = $('#fDateRange').val();
		
		$('#log-all').html('<div class="p-4 text-center text-muted">Loading stock adjustments...</div>');

		$.ajax({
			url: '/StockAdjustment/filter_adjustments', 
			type: 'POST',
			dataType: 'json',
			data: {
				adjustment_type: adjustmentType,
				status: status,
				date_range: dateRange
			},
			success: function(res) {
				ADJUSTMENT_DATA = (res && res.data) ? res.data : []; 
				renderLog('log-all', ADJUSTMENT_DATA);
				$('#tc-all').text(ADJUSTMENT_DATA.length);
			},
			error: function() {
				$('#log-all').html('<div class="empty-state text-danger"><i class="fa-solid fa-triangle-exclamation"></i><p>Failed to retrieve adjustment data.</p></div>');
			}
		});
	}

	/* ─── RENDER MAIN SUMMARY TABLE ─── */
	function renderLog(containerId, dataRows){
		if ($.fn.DataTable.isDataTable('#' + containerId + ' table')) {
			$('#' + containerId + ' table').DataTable().clear().destroy();
		}

		if(!dataRows || !dataRows.length){
			$('#'+containerId).html('<div class="empty-state"><i class="fa-solid fa-inbox"></i><p>No adjustment records match your filters.</p></div>');
			return;
		}

		var tableHtml = '<div class="tbl-wrap">'
			+ '<table class="tbl table table-stripe text-nowrap w-100">' 
			+ '<thead class="table-light">'
				+ '<tr>'
					+ '<th class="ps-3">Adjustment No</th>'
					+ '<th>Type</th>'
					+ '<th>Date</th>'
					+ '<th>Status</th>'
					+ '<th>Warehouse</th>'
					+ '<th>Remarks</th>'
					+ '<th style="text-align:center;" class="pe-3">Actions</th>'
				+ '</tr>'
			+ '</thead>'
			+ '<tbody>';

		dataRows.forEach(function(item) {
			var typeClass = 'type-' + item.adjustment_type.toLowerCase().replace('_', '');
			var statusClass = 'st-' + item.status.toLowerCase();

			tableHtml += '<tr style="background-color: #ffffff !important;">'
				+ '<td class="ps-3" style="font-weight: 600; font-size:12px; color:var(--primary);">' + item.adjustment_no + '</td>'
				+ '<td><span class="badge ' + typeClass + '">' + item.adjustment_type + '</span></td>'
				+ '<td style="font-size:12px; color: #6c757d;">' + item.adjustment_date + '</td>'
				+ '<td><span class="badge ' + statusClass + '">' + item.status.toUpperCase() + '</span></td>'
				+ '<td style="font-size:12px;">' + item.store_name + '</td>'
				+ '<td style="font-size:12px; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">' + (item.remarks || '—') + '</td>'
				+ '<td style="text-align:center;" class="pe-3">'
					+ '<button class="btn btn-xs btn-primary d-inline-flex align-items-center gap-1" style="font-size:11px; padding: 2px 8px;" onclick="viewDetails(' + item.id + ', \'' + item.adjustment_no + '\')">'
						+ '<i class="fa-solid fa-eye"></i> Items'
					+ '</button>'
				+ '</td>'
				+ '</tr>';
		});

		tableHtml += '</tbody></table></div>';

		$('#' + containerId).html(tableHtml);

		if (typeof initializeDataTable === "function") {
			initializeDataTable('#' + containerId + ' table');
		} else {
			$('#' + containerId + ' table').DataTable({
				"order": [[2, "desc"]]
			});
		}
	}
	
	/* ─── DRILL DOWN MODAL POP-UP FUNCTION ─── */
	function viewDetails(adjustmentId, adjustmentNo) {
		$('#pp-title').text('Items breakdown for: ' + adjustmentNo);
		$('#pp-body').html('<div class="text-center p-4 text-muted"><i class="fa-solid fa-spinner fa-spin me-2"></i>Loading adjustment items...</div>');
		
		// Show the Bootstrap modal
		var itemsModal = new bootstrap.Modal(document.getElementById('adjustmentItemsModal'));
		itemsModal.show();

		$.ajax({
			url: '/StockAdjustment/get_adjustment_items',
			type: 'POST',
			dataType: 'json',
			data: { adjustment_id: adjustmentId },
			success: function(res) {
				if(!res || !res.data || !res.data.length) {
					$('#pp-body').html('<div class="text-center p-3 text-muted">No line items linked to this adjustment profile.</div>');
					return;
				}

				var html = '<div class="table-responsive">'
					+ '<table class="table table-sm table-bordered" style="font-size:11px; margin-bottom: 0;">'
					+ '<thead class="table-dark"><tr>'
						+ '<th>Product</th>'
						//+ '<th style="text-align:center;">Mode</th>'
						+ '<th style="text-align:right;">Prev Qty</th>'
						+ '<th style="text-align:right;">Adj Qty</th>'
						+ '<th style="text-align:right;">New Qty</th>'
					+ '</tr></thead><tbody>';

				res.data.forEach(function(item) {
					var modeColor = item.mode === 'ADD' ? 'text-success' : (item.mode === 'SUBTRACT' ? 'text-danger' : 'text-primary');
					html += '<tr>'
						+ '<td><strong>' + (item.product_name || 'ID: '+item.product_id) + '</strong><br><small class="text-muted">' + (item.product_code || '') + '</small></td>'
						//+ '<td style="text-align:center;"><span class="fw-bold ' + modeColor + '">' + item.mode + '</span></td>'
						+ '<td style="text-align:right;" class="mono">' + parseFloat(item.current_qty).toFixed(2) + '</td>'
						+ '<td style="text-align:right;" class="mono fw-bold">' + parseFloat(item.adjustment_qty).toFixed(2) + '</td>'
						+ '<td style="text-align:right;" class="mono">' + parseFloat(item.new_qty).toFixed(2) + '</td>'
						+ '</tr>';
				});

				html += '</tbody></table></div>';
				$('#pp-body').html(html);
			},
			error: function() {
				$('#pp-body').html('<div class="text-danger p-3 text-center">Failed to fetch items checklist records.</div>');
			}
		});
	}

	/* ─── FILTERS ACTION BINDINGS ─── */
	function applyFilters(){
		loadAdjustmentReportData();
	}

	function resetFilters(){
		$('#adjustment_type').val('');
		$('#status').val('');
		$('#fDateRange').val('');
		loadAdjustmentReportData();
	}

	$(document).ready(function() {
		loadAdjustmentReportData();
	});
</script>