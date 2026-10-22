<!-- Start::app-content -->
<div class="main-content app-content">
	<div class="container-fluid">

		<!-- ══ STYLES ══ -->
		<style>
			/* ── badges ── */
			.ap{display:inline-flex;align-items:center;gap:3px;padding:3px 11px;border-radius:20px;font-size:.71rem;font-weight:600;letter-spacing:.03em;white-space:nowrap;}
			.ap-pending  {background:#fef9c3;color:#854d0e;}
			.ap-approved {background:#dcfce7;color:#166534;}
			.ap-rejected {background:#fee2e2;color:#991b1b;}
			.ap-on_hold  {background:#dbeafe;color:#1e40af;}
			.ap-cancelled{background:#f1f5f9;color:#64748b;}
			.ap-submitted{background:#ede9fe;color:#5b21b6;}
			.ap-released {background:#d1fae5;color:#065f46;}
			.ap-held     {background:#dbeafe;color:#1e40af;}
			.pri-high    {background:#fee2e2;color:#991b1b;border-radius:5px;padding:2px 8px;font-size:.7rem;font-weight:700;}
			.pri-medium  {background:#ffedd5;color:#9a3412;border-radius:5px;padding:2px 8px;font-size:.7rem;font-weight:700;}
			.pri-low     {background:#f1f5f9;color:#64748b;border-radius:5px;padding:2px 8px;font-size:.7rem;font-weight:700;}
			.dt-pill{display:inline-flex;align-items:center;gap:3px;padding:2px 9px;border-radius:5px;font-size:.71rem;font-weight:600;white-space:nowrap;}
			.dt-GRN    {background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;}
			.dt-PO     {background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;}
			.dt-PAYMENT{background:#fdf4ff;color:#7e22ce;border:1px solid #e9d5ff;}
			.dt-STOCK  {background:#fff7ed;color:#9a3412;border:1px solid #fed7aa;}

			/* ── stat cards ── */
			.sc{border-radius:12px;display:flex;align-items:center;gap:.875rem;padding:1.1rem 1.25rem;}
			.sc-icon{width:46px;height:46px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;}
			.sc-val{font-size:1.3rem;font-weight:700;line-height:1;}
			.sc-lbl{font-size:.73rem;color:#64748b;font-weight:500;margin-top:3px;}
			.sc-sub{font-size:.68rem;color:#94a3b8;margin-top:1px;}

			/* ── filter bar ── */
			.fbar{background:#f8fafc;border:1px solid #e9ecef;border-radius:10px;padding:.65rem 1rem;}

			/* ── approval table ── */
			.ap-tbl th{background:#f8f9fb;font-size:.71rem;text-transform:uppercase;letter-spacing:.06em;color:#64748b;white-space:nowrap;padding:.6rem .875rem;}
			.ap-tbl td{vertical-align:middle;font-size:.8125rem;padding:.65rem .875rem;}
			.ap-tbl tbody tr:hover td{background:#f8faff;}
			.ap-tbl tr.pri-high-row td:first-child {border-left:3px solid #ef4444;}
			.ap-tbl tr.pri-medium-row td:first-child{border-left:3px solid #f97316;}
			.ap-tbl tr.pri-low-row td:first-child   {border-left:3px solid #cbd5e1;}

			/* ── age pills ── */
			.age-ok  {background:#f0fdf4;color:#166534;border-radius:5px;padding:1px 7px;font-size:.7rem;font-weight:600;}
			.age-warn{background:#fff7ed;color:#9a3412;border-radius:5px;padding:1px 7px;font-size:.7rem;font-weight:600;}
			.age-over{background:#fef2f2;color:#991b1b;border-radius:5px;padding:1px 7px;font-size:.7rem;font-weight:600;}

			/* ── empty state ── */
			.empty-st{text-align:center;padding:3rem 1rem;color:#94a3b8;}
			.empty-st i{font-size:2.6rem;display:block;margin-bottom:.625rem;}
			.empty-st p{font-size:.875rem;margin:0;}

			/* ── audit timeline ── */
			.tl{position:relative;padding-left:1.4rem;}
			.tl::before{content:'';position:absolute;left:.3rem;top:.4rem;bottom:.4rem;width:2px;background:#e9ecef;border-radius:2px;}
			.tl-item{position:relative;margin-bottom:1rem;padding-bottom:0;}
			.tl-item:last-child{margin-bottom:0;}
			.tl-dot{position:absolute;left:-1.1rem;top:.3rem;width:10px;height:10px;border-radius:50%;border:2px solid #fff;box-shadow:0 0 0 2px #94a3b8;background:#94a3b8;}
			.tl-dot.d-submitted{background:#8b5cf6;box-shadow:0 0 0 2px #8b5cf6;}
			.tl-dot.d-approved {background:#22c55e;box-shadow:0 0 0 2px #22c55e;}
			.tl-dot.d-rejected {background:#ef4444;box-shadow:0 0 0 2px #ef4444;}
			.tl-dot.d-held     {background:#3b82f6;box-shadow:0 0 0 2px #3b82f6;}
			.tl-dot.d-released {background:#10b981;box-shadow:0 0 0 2px #10b981;}
			.tl-dot.d-cancelled{background:#94a3b8;box-shadow:0 0 0 2px #94a3b8;}

			/* ── toast ── */
			#__tb{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:7px;}
			.t-itm{padding:10px 16px;border-radius:8px;font-size:13px;font-weight:500;color:#fff;box-shadow:0 4px 14px rgba(0,0,0,.18);opacity:0;transform:translateY(5px);transition:all .22s;max-width:300px;}

			/* ── detail slide panel ── */
			#detailPanel{display:none;}
		</style>

		<!-- ══ PAGE HEADER ══ -->
		<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
			<div>
				<h1 class="page-title fw-semibold fs-18 mb-1">Approval Management</h1>
				<p class="text-muted fs-12 mb-0"><i class="ri-shield-check-line me-1"></i>Centralized approval inbox — Finance Manager</p>
			</div>
			<div class="d-flex gap-2 align-items-center flex-wrap mt-md-0 mt-2">
				<div class="dropdown">
					<button class="btn btn-secondary-light btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="ri-download-line me-1"></i>Export</button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item fs-13" href="#"><i class="ri-file-excel-line me-2 text-success"></i>Excel</a></li>
						<li><a class="dropdown-item fs-13" href="#"><i class="ri-file-pdf-line me-2 text-danger"></i>PDF</a></li>
					</ul>
				</div>
				<nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="#">Finance</a></li><li class="breadcrumb-item active">Approvals</li></ol></nav>
			</div>
		</div>

		<!-- ══ STAT SUMMARY ROW ══ -->
		<div class="row g-3 mb-4" id="statRow"></div>

		<!-- ══ MAIN LAYOUT: Table + Audit (side by side) ══ -->
		<div class="row g-3">

			<!-- LEFT: Filter + Table -->
			<div class="col-xl-8 col-lg-8">

				<!-- Filter bar -->
				<div class="fbar mb-3 d-flex flex-wrap gap-2 align-items-center">
					<div class="input-group input-group-sm" style="max-width:230px;">
						<span class="input-group-text bg-white"><i class="ri-search-line text-muted"></i></span>
						<input type="text" class="form-control border-start-0" placeholder="Ref no. / requester…" id="srch">
					</div>
					<select class="form-select form-select-sm" id="fStatus" style="max-width:140px;">
						<option value="">All Status</option>
						<option value="pending">Pending</option>
						<option value="approved">Approved</option>
						<option value="rejected">Rejected</option>
						<option value="on_hold">On Hold</option>
						<option value="cancelled">Cancelled</option>
					</select>
					<select class="form-select form-select-sm" id="fType" style="max-width:145px;">
						<option value="">All Types</option>
						<option value="GRN">GRN</option>
						<option value="PO">Purchase Order</option>
						<option value="PAYMENT">Payment</option>
						<option value="STOCK">Stock Adjustment</option>
					</select>
					<select class="form-select form-select-sm" id="fPri" style="max-width:130px;">
						<option value="">All Priority</option>
						<option value="high">High</option>
						<option value="medium">Medium</option>
						<option value="low">Low</option>
					</select>
					<span class="ms-auto text-muted fs-12" id="recCount"></span>
				</div>

				<!-- Approvals table card -->
				<div class="card custom-card">
					<div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
						<span class="fw-semibold fs-14"><i class="ri-inbox-line me-2 text-primary"></i>Approval Requests</span>
						<div class="d-flex align-items-center gap-2">
							<span class="badge bg-danger fs-11" id="pendBadge">0 pending</span>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table ap-tbl mb-0 text-nowrap">
								<thead>
									<tr>
										<th>Type</th>
										<th>Reference</th>
										<th>Requested By</th>
										<th>Date</th>
										<th>Amount</th>
										<th>Priority</th>
										<th>Age</th>
										<th>Status</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="apTbody"></tbody>
							</table>
						</div>
					</div>
					<div class="card-footer d-flex align-items-center justify-content-between">
						<span class="text-muted fs-12" id="footerCount">0 records</span>
						<nav>
							<ul class="pagination pagination-sm mb-0">
								<li class="page-item disabled"><a class="page-link">&laquo;</a></li>
								<li class="page-item active"><a class="page-link">1</a></li>
								<li class="page-item"><a class="page-link">&raquo;</a></li>
							</ul>
						</nav>
					</div>
				</div>

			</div><!-- /col-xl-8 -->

			<!-- RIGHT: Audit trail -->
			<div class="col-xl-4 col-lg-12">
				<div class="card custom-card h-100">
					<div class="card-header d-flex align-items-center justify-content-between">
						<span class="fw-semibold fs-14"><i class="ri-history-line me-2 text-primary"></i>Approval Audit Trail</span>
						<span class="badge bg-primary-transparent text-primary fs-11" id="logBadge">— entries</span>
					</div>
					<div class="card-body" style="max-height:620px;overflow-y:auto;" id="auditBody">
						<div class="empty-st"><i class="ri-history-line"></i><p>Select a request to view its trail</p></div>
					</div>
					<div class="card-footer py-2 px-3 d-flex align-items-center gap-2" id="auditFooter" style="display:none!important;">
						<!-- filled when a row is selected -->
					</div>
				</div>
			</div>
		</div><!-- /row -->
	</div>
</div><!-- End::app-content -->

<!-- search modal -->
<div class="modal fade" id="responsive-searchModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="input-group">
					<input type="text" class="form-control border-end-0" placeholder="Search Anything ...">
					<button class="btn btn-primary" type="button"><i class="bi bi-search"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ════════════════════ MODALS ════════════════════ -->

        <!-- Approve -->
        <div class="modal fade" id="mApprove" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
				<form id="app_appr">
					<input type="hidden" name="appid" id="appid">
					<div class="modal-header border-0 pb-0">
						<h6 class="modal-title fw-semibold text-success"><i class="ri-checkbox-circle-line me-2"></i>Approve Request</h6>
						<button class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="alert alert-success-transparent py-2 fs-12 mb-3 d-flex align-items-center gap-2">
							<i class="ri-information-line text-success fs-14"></i>This will <strong>confirm the document</strong>. The requester will be notified.
						</div>
						<div class="p-3 bg-light rounded mb-3" id="mAppDetail"></div>
						<label class="form-label fw-medium fs-13">Remarks <span class="text-muted fw-normal">(optional)</span></label>
						<textarea class="form-control" rows="2" name="appremark" id="mAppRemarks" placeholder="Add approval notes…"></textarea>
					</div>
					<div class="modal-footer border-0 pt-0">
						<button type="reset" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-success btn-sm" onclick="doApprove()" data-bs-dismiss="modal"><i class="ri-check-line me-1"></i>Confirm Approval</button>
				  </div>
				</form>
            </div>
          </div>
        </div>

        <!-- Reject -->
        <div class="modal fade" id="mReject" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
				<form id="app_rej">
					<input type="hidden" name="appid" id="rejid">
					<div class="modal-header border-0 pb-0">
						<h6 class="modal-title fw-semibold text-danger"><i class="ri-close-circle-line me-2"></i>Reject Request</h6>
						<button class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger-transparent py-2 fs-12 mb-3 d-flex align-items-center gap-2">
							<i class="ri-error-warning-line text-danger fs-14"></i>Requester will be notified. A <strong>reason is required</strong>.
						</div>
						<div class="p-3 bg-light rounded mb-3" id="mRejDetail"></div>
							<label class="form-label fw-medium fs-13">Rejection Reason <span class="text-danger">*</span></label>
							<textarea class="form-control" rows="3" name="appremark" id="mRejReason" placeholder="Clearly state the reason…"></textarea>
					</div>
					<div class="modal-footer border-0 pt-0">
						<button type="reset" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-danger btn-sm" onclick="doReject()" data-bs-dismiss="modal"><i class="ri-close-circle-line me-1"></i>Confirm Rejection</button>
					</div>
				</form>
            </div>
          </div>
        </div>

        <!-- Hold -->
        <div class="modal fade" id="mHold" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<form id="app_hold">
						<input type="hidden" name="appid" id="Hid">
						<div class="modal-header border-0 pb-0">
							<h6 class="modal-title fw-semibold" style="color:#1e40af;"><i class="ri-pause-circle-line me-2"></i>Place on Hold</h6>
							<button class="btn-close" data-bs-dismiss="modal"></button>
						</div>
						<div class="modal-body">
							<div class="alert alert-primary-transparent py-2 fs-12 mb-3 d-flex align-items-center gap-2">
								<i class="ri-information-line text-primary fs-14"></i>Request will be paused. You can release the hold later.
							</div>
							<div class="p-3 bg-light rounded mb-3" id="mHoldDetail"></div>
							<label class="form-label fw-medium fs-13">Hold Reason <span class="text-danger">*</span></label>
							<textarea class="form-control" rows="3" id="mHoldReason" placeholder="Why is this being placed on hold?"></textarea>
						</div>
						<div class="modal-footer border-0 pt-0">
							<button class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
							<button class="btn btn-sm fw-semibold" style="background:#dbeafe;color:#1e40af;" onclick="doHold()" data-bs-dismiss="modal">
								<i class="ri-pause-circle-line me-1"></i>Confirm Hold
							</button>
						</div>
					</form>
				</div>
			</div>
        </div>

<script>
	
	// Execute the named function
	$(document).ready(function() {
		filter();
		
		//Submit lead for save or Update
 		$('#app_appr').ajax_submit({
			url :'/Approval/approve', 
			rest: false,
			callback : function(id){
				$('#app_appr')[0].reset()
				filter();
				//loadLeadCounts();
			}
		}); 
		
		//Submit lead for save or Update
 		$('#app_rej').ajax_submit({
			url :'/Approval/reject', 
			rest: false,
			callback : function(id){
				$('#app_rej')[0].reset()
				filter();
				//loadLeadCounts();
			}
		}); 
		
		//Submit lead for save or Update
 		$('#app_hold').ajax_submit({
			url :'/Approval/hold', 
			rest: false,
			callback : function(id){
				$('#app_rej')[0].reset()
				filter();
				//loadLeadCounts();
			}
		});
		
	});
	
	//relese request if request is hold 
	function doRelease(id) {
		$.ajax({
			url: '/Approval/relese?apid=' + id, // Correct concatenation
			type: 'GET',
			dataType: 'json',
			beforeSend: function() {
				$('#apTbody').html(
					'<tr><td colspan="9" class="text-center p-5">' +
					'<div class="spinner-border text-primary"></div>' +
					'</td></tr>'
				);
			},
			success: function(res) {
				filter();
			},
			error: function() {
				$('#apTbody').html(
					'<tr><td colspan="9" class="text-center text-danger">' +
					'Error fetching data.' +
					'</td></tr>'
				);
			}
		});
	}


	
	
	function filter() {
		'use strict';

		/* ── State Management ────────────────────────────────────────────────── */
		var DATA = []; 
		var LOG = [];  
		var activeId = null;

		/* ── Helpers (jQuery Style) ─────────────────────────────────────────── */
		const lkr = (n) => n ? 'LKR ' + parseFloat(n).toLocaleString('en-US') : '—';
		const fdate = (d) => { 
			if (!d) return '—'; 
			var x = new Date(d); 
			return isNaN(x) ? d : x.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }); 
		};
		
		const badge = (s) => `<span class="ap ap-${s}">${s.replace('_', ' ')}</span>`;
		const dtpill = (t) => `<span class="dt-pill dt-${t}">${t}</span>`;
		const pripill = (p) => `<span class="pri-${p}">${p}</span>`;
		const agepill = (a) => { 
			var c = a <= 3 ? 'age-ok' : a <= 7 ? 'age-warn' : 'age-over'; 
			return `<span class="${c}">${a}d</span>`; 
		};

		/* ── Toast Notification ─────────────────────────────────────────────── */
		function toast(msg, type) {
			var colors = { success: '#22c55e', danger: '#ef4444', warning: '#f59e0b', primary: '#405189', info: '#0ea5e9' };
			var $box = $('#__tb');
			if (!$box.length) { 
				$box = $('<div id="__tb"></div>').appendTo('body'); 
			}
			var $t = $('<div class="t-itm"></div>')
				.css('background', colors[type] || colors.primary)
				.html('<i class="ri-checkbox-circle-line me-2"></i>' + msg);
			
			$box.append($t);
			
			// Trigger animation
			setTimeout(() => { $t.css({ opacity: 1, transform: 'translateY(0)' }); }, 10);
			
			// Remove after 3s
			setTimeout(() => { 
				$t.css('opacity', 0); 
				setTimeout(() => { $t.remove(); }, 300); 
			}, 3300);
		}

		/* ── Core AJAX Fetch Function ──────────────────────────────────────── */
		function fetchData() {
			$.ajax({
				url: '/Approval/get_data', // Your CI3 Controller Link
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('#apTbody').html('<tr><td colspan="9" class="text-center p-5"><div class="spinner-border text-primary"></div></td></tr>');
				},
				success: function(res) {
					// Adjust keys based on your CI3 JSON output
					DATA = res.requests || res; 
					LOG = res.logs || []; 
					
					refresh();

					// Auto-select first pending record (Original Logic)
					if (!activeId) {
						var first = $.grep(DATA, (d) => d.status === 'pending')[0];
						if (first) window.selectRow(first.id);
					}
				},
				error: function() {
					$('#apTbody').html('<tr><td colspan="9" class="text-center text-danger">Error fetching data.</td></tr>');
				}
			});
		}

		/* ── Stats Rendering ───────────────────────────────────────────────── */
		function renderStats() {
			var pend = $.grep(DATA, (d) => d.status === 'pending');
			var hold = $.grep(DATA, (d) => d.status === 'on_hold');
			var appr = $.grep(DATA, (d) => d.status === 'approved');
			var rej  = $.grep(DATA, (d) => d.status === 'rejected');
			var urgent = $.grep(DATA, (d) => d.pri === 'high' && d.status === 'pending');
			var pendAmt = pend.reduce((s, d) => s + parseFloat(d.amt || 0), 0);

			var cards = [
				{ bg: '#fef9c3', ic: '#854d0e', icon: 'ri-time-line', lbl: 'Pending', val: pend.length, sub: lkr(pendAmt) },
				{ bg: '#fee2e2', ic: '#991b1b', icon: 'ri-alarm-warning-line', lbl: 'High Priority', val: urgent.length, sub: 'Requires Action' },
				{ bg: '#dbeafe', ic: '#1e40af', icon: 'ri-pause-circle-line', lbl: 'On Hold', val: hold.length, sub: 'Awaiting Release' },
				{ bg: '#dcfce7', ic: '#166534', icon: 'ri-checkbox-circle-line', lbl: 'Approved', val: appr.length, sub: 'Total items' }
			];

			$('#statRow').empty().append(cards.map(c => `
				<div class="col-sm-6 col-xl">
					<div class="card custom-card">
						<div class="card-body sc">
							<div class="sc-icon" style="background:${c.bg}"><i class="${c.icon}" style="color:${c.ic};font-size:1.2rem;"></i></div>
							<div><div class="sc-val">${c.val}</div><div class="sc-lbl">${c.lbl}</div><div class="sc-sub">${c.sub}</div></div>
						</div>
					</div>
				</div>`
			).join(''));

			$('#pendBadge').text(pend.length + ' pending');
		}

		/* ── Table Rendering ───────────────────────────────────────────────── */
		function render() {
			var q   = ($('#srch').val() || '').toLowerCase();
			var st  = $('#fStatus').val();
			var tp  = $('#fType').val();
			var pri = $('#fPri').val();

			var filtered = $.grep(DATA, function(d) {
				return (!q || (d.ref + d.by + d.dt).toLowerCase().includes(q)) && (!st || d.status === st) && (!tp || d.dt === tp) && (!pri || d.pri === pri);
			});

			$('#recCount, #footerCount').text(filtered.length + ' record(s)');

			var $tbody = $('#apTbody').empty();
			if (!filtered.length) {
				$tbody.append('<tr><td colspan="9" class="p-0"><div class="empty-st"><i class="ri-inbox-line"></i><p>No records found</p></div></td></tr>');
				return;
			}

			$tbody.append(filtered.map(function(d) {
				var isActive = (d.id == activeId);
				var rowCls = `pri-${d.pri}-row ${isActive ? 'table-active' : ''}`;
				
				var btns = `<div class="d-flex gap-1 flex-wrap">
					<button class="btn btn-sm btn-icon ${isActive ? 'btn-primary' : 'btn-secondary-light'}" onclick="selectRow(${d.id})"><i class="ri-history-line"></i></button>`;

				if (d.status === 'pending') {
					btns += `<button class="btn btn-sm btn-success" onclick="openApprove(${d.id})" data-bs-toggle="modal" data-bs-target="#mApprove">Approve</button>
							 <button class="btn btn-sm btn-danger-light" onclick="openReject(${d.id})" data-bs-toggle="modal" data-bs-target="#mReject">Reject</button>
							 <button class="btn btn-sm btn-warning-light" onclick="openHold(${d.id})"  data-bs-toggle="modal" data-bs-target="#mHold">Hold</button>`;
				} else if (d.status === 'on_hold') {
					btns += `<button class="btn btn-sm btn-success-light" onclick="doRelease(${d.id})">Release</button>`;
				}
				btns += '</div>';

				return `<tr class="${rowCls}" style="cursor:pointer;" onclick="selectRow(${d.id})">
					<td>${dtpill(d.dt)}</td>
					<td><span class="fw-semibold text-primary">${d.ref}</span></td>
					<td>${d.by}</td>
					<td class="text-muted fs-12">${fdate(d.date)}</td>
					<td class="fw-semibold">${lkr(d.amt)}</td>
					<td>${pripill(d.pri)}</td>
					<td>${agepill(d.age)}</td>
					<td>${badge(d.status)}</td>
					<td onclick="event.stopPropagation()">${btns}</td>
				</tr>`;
			}).join(''));
		}

		/* ── Audit Trail (Globalized for HTML onclicks) ──────────────────── */
		window.selectRow = function(id) {
			activeId = id;
			var d = DATA.find(x => x.id == id);
			if (!d) return;
			render(); // Update table highlight

			var logs = $.grep(LOG, (l) => l.id == id || l.document_id == id);
			$('#logBadge').text(logs.length + ' entries');

			var hdr = `
				<div class="p-3 mb-3 rounded" style="background:#f8faff; border:1px solid #e0e8ff;">
					<div class="d-flex align-items-center justify-content-between mb-2">
						<div class="fw-semibold fs-13 text-primary">${d.ref}</div> ${badge(d.status)}
					</div>
					<div class="row g-2 fs-12">
						<div class="col-6"><span class="text-muted">Type: </span>${dtpill(d.dt)}</div>
						<div class="col-6"><span class="text-muted">Priority: </span>${pripill(d.pri)}</div>
						<div class="col-12">Requested By: <strong>${d.by}</strong> | Amount: <strong class="text-primary">${lkr(d.amt)}</strong></div>
					</div>
				</div>`;

			var tl = '<div class="tl">' + logs.map(l => `
				<div class="tl-item">
					<div class="tl-dot d-${l.act}"></div>
					<div class="fs-11 text-muted mb-1">${l.at}</div>
					<div class="fw-semibold fs-13">${l.by} &mdash; ${badge(l.act)}</div>
					<div class="text-muted fs-12 mt-1">${l.note}</div>
				</div>`).join('') + '</div>';

			$('#auditBody').html(hdr + tl);

			// Update Audit Footer
			var $af = $('#auditFooter').show();
			if (d.status === 'pending') {
				$af.html(`<button class="btn btn-success btn-sm flex-fill" onclick="openApprove(${d.id})" data-bs-toggle="modal" data-bs-target="#mApprove">Approve</button>
						  <button class="btn btn-danger-light btn-sm flex-fill" onclick="openReject(${d.id})" data-bs-toggle="modal" data-bs-target="#mReject">Reject</button>
						  <button class="btn btn-warning-light btn-sm flex-fill" onclick="openHold(${d.id})" id="${d.id}" data-bs-toggle="modal" data-bs-target="#mHold">Hold</button>`);
			} else {
				$af.html(`<span class="text-muted fs-12 w-100 text-center py-1">Document is ${d.status}</span>`);
			}
		};

		/* ── Modal Handling (Globalized) ──────────────────────────────────── */
		function detailHTML(d) {
			return `<div class="row g-2 fs-13">
				<div class="col-6">Type: ${dtpill(d.dt)}</div><div class="col-6">Ref: <strong class="text-primary">${d.ref}</strong></div>
				<div class="col-6">Requested By: <strong>${d.by}</strong></div><div class="col-6">Amount: <strong class="text-primary">${lkr(d.amt)}</strong></div>
				<div class="col-12 text-muted fs-12">${d.note || ''}</div>
			</div>`;
		}

		window.openApprove = (id) => { 
			activeId = id; const d = DATA.find(x => x.id == id); 
			$('#mAppDetail').html(detailHTML(d)); $('#mAppRemarks').val(''); 
			$('#appid').val(activeId); 
		};

		window.openReject = (id) => { 
			activeId = id; const d = DATA.find(x => x.id == id); 
			$('#mRejDetail').html(detailHTML(d)); $('#mRejReason').val(''); 
			$('#rejid').val(activeId); 
		};
		
		window.openHold = (id) => {
			activeId = id; const d = DATA.find(x => x.id == id); 
			$('#mHoldDetail').html(detailHTML(d)); $('#mHoldDetail').val(''); 
			$('#Hid').val(activeId);
		};

		/* ── Refresh Trigger ───────────────────────────────────────────────── */
		function refresh() { renderStats(); render(); }

		/* ── Initialization ────────────────────────────────────────────────── */
		$(document).ready(function() {
			fetchData(); // Load data from CI3 controller

			// Filter Event Listeners
			$('#srch').on('input', render);
			$('#fStatus, #fType, #fPri').on('change', render);

			// Footer Year
			$('#year').text(new Date().getFullYear());
		});

	}
</script>
<!-- ════════════════════ APP JS ════════════════════ -->


