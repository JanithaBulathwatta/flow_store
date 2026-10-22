<div class="main-content app-content">
	<div class="container-fluid">

		<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
			<div>
				<h1 class="page-title fw-semibold fs-18 mb-1">Expense Approval Management</h1>
				<p class="text-muted fs-12 mb-0"><i class="ri-shield-check-line me-1"></i>Centralized approval inbox — Finance Authorization Desk</p>
			</div>
			<div class="d-flex gap-2 align-items-center flex-wrap mt-md-0 mt-2">
				<div class="dropdown">
					<button class="btn btn-secondary-light btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="ri-download-line me-1"></i>Export</button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item fs-13" href="#"><i class="ri-file-excel-line me-2 text-success"></i>Excel Data Log</a></li>
						<li><a class="dropdown-item fs-13" href="#"><i class="ri-file-pdf-line me-2 text-danger"></i>PDF Document Report</a></li>
					</ul>
				</div>
				<nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="#">Finance</a></li><li class="breadcrumb-item active">Expense Approvals</li></ol></nav>
			</div>
		</div>

		<div class="row g-3 mb-4" id="statRow"></div>

		<div class="row g-3">
			<div class="col-12">

				<form id="data-filter">	
					<div class="fbar mb-3 d-flex flex-wrap gap-2 align-items-center">
						<div class="input-group input-group-sm" style="max-width:230px;">
							<input type="text" class="form-control form-control-sm input-group-sm border-start-0" placeholder="Ref no. / note details…" id="srch">
						</div>
						<select class="form-select" id="fStatus" style="max-width:145px;">
							<option value="">All Status States</option>
							<option value="pending" selected>Pending</option>
							<option value="active">Approved (Active)</option>
							<option value="rejected">Rejected</option>
							<option value="on_hold">On Hold</option>
						</select>
						<select class="form-select" id="fPri" style="max-width:130px;">
							<option value="">All Priority</option>
							<option value="high">High</option>
							<option value="medium">Medium</option>
							<option value="low">Low</option>
						</select>
						
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary w-100 mb-1 mr-10 right" id="searchBtn">Search Queue</button>
						</div>
					</div>
				</form>	

				<div class="card custom-card">
					<div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
						<span class="fw-semibold fs-14"><i class="ri-inbox-line me-2 text-primary"></i>Awaiting Authorization Queue</span>
						<div class="d-flex align-items-center gap-2">
							<span class="badge bg-danger fs-11" id="pendBadge">0 pending logs</span>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table ap-tbl mb-0 text-nowrap">
								<thead>
  <tr>
    <th>Date</th>
    <th>Ref No.</th>
    <th>Category</th>
    <th>Type</th>
    <th>Description</th>
    <th>Account</th>
    <th class="text-center">Qty</th>
    <th class="text-center">Unit Price</th>   <th class="text-center">Total Amount</th> <th class="text-center">Actions</th>
  </tr>
</thead>
								<tbody id="apTbody"></tbody>
							</table>
						</div>
					</div>
					<div class="card-footer d-flex align-items-center justify-content-between">
						<span class="text-muted fs-12" id="footerCount">0 records track allocations</span>
						<nav>
							<ul class="pagination pagination-sm mb-0">
								<li class="page-item disabled"><a class="page-link">&laquo;</a></li>
								<li class="page-item active"><a class="page-link">1</a></li>
								<li class="page-item"><a class="page-link">&raquo;</a></li>
							</ul>
						</nav>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="mApprove" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="app_appr">
				<div class="modal-header border-0 pb-0">
					<h6 class="modal-title fw-semibold text-success"><i class="ri-checkbox-circle-line me-2"></i>Authorize Expense Allocation</h6>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<div class="alert alert-success-transparent py-2 fs-12 mb-3 d-flex align-items-center gap-2">
						<i class="ri-information-line text-success fs-14"></i>This confirms the entry. The status changes to <strong>Active</strong>.
					</div>
					<div class="p-3 bg-light rounded" id="mAppDetail"></div>
				</div>
				<div class="modal-footer border-0 pt-0">
					<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success btn-sm">Confirm & Authorize</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="mReject" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="app_rej">
				<div class="modal-header border-0 pb-0">
					<h6 class="modal-title fw-semibold text-danger"><i class="ri-close-circle-line me-2"></i>Reject Expense Request</h6>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger-transparent py-2 fs-12 mb-3 d-flex align-items-center gap-2">
						<i class="ri-error-warning-line text-danger fs-14"></i>Rejecting this item will drop it out of the verification queue permanently.
					</div>
					<div class="p-3 bg-light rounded" id="mRejDetail"></div>
				</div>
				<div class="modal-footer border-0 pt-0">
					<button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger btn-sm">Confirm Rejection</button>
				</div>
			</form>	
		</div>
	</div>
</div>

<script>
	// 1. GLOBAL STATE TRACKERS
	var DATA = []; 
	var activeId = null;

	// 2. DEFENSIVE VARIABLE FORMATTING SCOPES
	
const lkr = (n) => n ? parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
	const fdate = (d) => { 
		if (!d) return '—'; 
		var x = new Date(d); 
		return isNaN(x) ? d : x.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }); 
	};
	const dtpill = (t) => `<span class="badge bg-primary-transparent text-primary">${t || 'EXPENSE'}</span>`;

	// 3. RUNTIME APP CONFIGURATION ON MOUNT
	$(document).ready(function() {
		fetchData();
		
		$('#data-filter').on('submit', function (e) { 
			e.preventDefault(); 
			fetchData(); 
		});

		//  MANUAL AJAX TO AVOID THE PLUGIN RACING BOOTSTRAP CLOSURES
		$('#app_appr').on('submit', function(e) {
			e.preventDefault();
			executeAction('<?= site_url("Expense/approve"); ?>', '#mApprove');
		});

		$('#app_rej').on('submit', function(e) {
			e.preventDefault();
			executeAction('<?= site_url("Expense/reject"); ?>', '#mReject');
		});
	});

	// Helper function to submit tracking requests cleanly
	function executeAction(targetUrl, modalId) {
		if (!activeId) return;
		$.ajax({
			url: targetUrl,
			type: 'POST',
			data: { exp_id: activeId },
			dataType: 'json',
			success: function(res) {
				if (res.status === 'success') {
					$(modalId).modal('hide');
					window.triggerLiveRefresh();
				} else {
					alert('Error: ' + res.message);
				}
			},
			error: function() {
				alert('Server communication failure.');
			}
		});
	}

	// 4. CORE REQUEST ENGINE TARGET LINK 
	function fetchData() {
		$.ajax({
			url: '<?= site_url("Expense/get_pending_approval_data") ?>',
			type: 'POST',
			data: { search: $('#srch').val() }, 
			dataType: 'json',
			beforeSend: function() {
				$('#apTbody').html('<tr><td colspan="10" class="text-center p-5"><div class="spinner-border text-primary"></div></td></tr>');
			},
			success: function(res) {
				DATA = res || []; 
				refresh();
				if (!activeId && DATA.length > 0) {
					window.selectRow(DATA[0].exp_id);
				}
			},
			error: function(xhr, status, error) {
				console.error("AJAX Error Output:", xhr.responseText);
				$('#apTbody').html('<tr><td colspan="10" class="text-center text-danger p-4"><i class="ri-error-warning-line me-1"></i>Error fetching validation queue records.</td></tr>');
			}
		});
	}

	// 5. UNIFIED DATA RENDERING ENGINE MATRIX
	function refresh() {
		var q = ($('#srch').val() || '').toLowerCase();
		
		var filtered = $.grep(DATA, function(d) {
			var matchString = (d.ref || '') + (d.cat || '') + (d.note || '');
			return !q || matchString.toLowerCase().includes(q);
		});

		$('#pendBadge').text(filtered.length + ' pending logs');
		$('#footerCount').text(filtered.length + ' records track allocations');

		var $tbody = $('#apTbody').empty();
		if (!filtered.length) {
			$tbody.append('<tr><td colspan="10" class="text-center p-4 text-muted"><i class="ri-inbox-line me-1"></i>No pending verification logs found.</td></tr>');
			return;
		}

		var rowHtml = '';
		$.each(filtered, function(index, d) {
			var isActive = (d.exp_id == activeId);
			
			// Click buttons trigger openApprove / openReject handlers safely
			var btns = `<div class="d-flex gap-1 flex-wrap">
				<button class="btn btn-sm btn-success py-1 px-2 fs-11" onclick="window.openApprove(${d.exp_id})">Approve</button>
				<button class="btn btn-sm btn-danger py-1 px-2 fs-11" onclick="window.openReject(${d.exp_id})">Reject</button>
			</div>`;

			var qty = d.qty ? parseInt(d.qty) : 1;
			var unitAmount = d.unit_amount ? parseFloat(d.unit_amount) : 0;
			var totalAmount = d.amt ? parseFloat(d.amt) : (unitAmount * qty);

rowHtml += `<tr class="${isActive ? 'table-active' : ''}" style="cursor:pointer;" onclick="window.selectRow(${d.exp_id})">
    <td class="text-muted fs-12">${fdate(d.date)}</td>
    <td><span class="fw-semibold text-primary">${d.ref}</span></td>
    <td><span class="badge bg-light text-muted fw-normal fs-11">${d.cat || 'General'}</span> </td>
    <td>${dtpill(d.dt)}</td>
    <td class="text-wrap" style="max-width: 200px;">${d.note ? d.note : '—'}</td>
    <td><span class="text-secondary fs-12">${d.acc || '—'}</span> </td>
    <td class="text-center">${qty}</td>
    
    <td class="text-center" style="white-space: nowrap;">${lkr(unitAmount)}</td>
    
    <td class="text-center" style="white-space: nowrap;">${lkr(totalAmount)}</td>
    
    <td onclick="event.stopPropagation()">${btns}</td>
</tr>`;
		});

		$tbody.append(rowHtml);
	}

	window.triggerLiveRefresh = function() { fetchData(); };

	window.selectRow = function(id) {
		activeId = id;
		$('#apTbody tr').removeClass('table-active');
		$(`#apTbody tr[onclick="window.selectRow(${id})"]`).addClass('table-active');
	};

	// MODAL OPENERS: Finds the dynamic data inside your array and pushes it to the view
	window.openApprove = (id) => {
		activeId = id;
		window.selectRow(id);
		var match = DATA.find(x => x.exp_id == id);
		$('#mAppDetail').html(detailHTML(match));
		$('#mApprove').modal('show');
	};

	window.openReject = (id) => {
		activeId = id;
		window.selectRow(id);
		var match = DATA.find(x => x.exp_id == id);
		$('#mRejDetail').html(detailHTML(match));
		$('#mReject').modal('show');
	};

	function detailHTML(d) {
		if (!d) return '';
		var qty = d.qty ? parseInt(d.qty) : 1;
		var unitAmount = d.unit_amount ? parseFloat(d.unit_amount) : 0;
		var totalAmount = d.amt ? parseFloat(d.amt) : (unitAmount * qty);

		return `<div class="row g-2 fs-13">
			<div class="col-6">Category: <strong>${d.cat || 'Unassigned'}</strong></div>
			<div class="col-6">Reference ID: <strong class="text-primary">${d.ref}</strong></div>
			<div class="col-6">Account Source: <strong>${d.acc || '—'}</strong></div>
			<div class="col-6">Charged Amount: <strong class="text-primary">${totalAmount}</strong></div>
			<div class="col-12 text-muted fs-12 mt-2" style="background:#fff;padding:8px;border-radius:4px;border:1px solid #e2e8f0;">Memo Note: ${d.note || 'No notes provided.'}</div>
		</div>`;
	}
</script>