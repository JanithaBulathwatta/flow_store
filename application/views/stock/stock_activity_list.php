<style>
    :root {
        --primary: #5b5ea6;
        --primary-light: #eeeef7;
        --success: #1aaa6b;
        --success-light: #e3f6ef;
        --warning: #f59e0b;
        --warning-light: #fef3c7;
        --danger: #ef4444;
        --danger-light: #fee2e2;
        --info: #0ea5e9;
        --info-light: #e0f2fe;
        --body-bg: #f0f1f5;
        --card-bg: #ffffff;
        --text-default: #1e2139;
        --text-muted: #7b8191;
        --border-color: #e8e9f0;
        --font: 'DM Sans', sans-serif;
    }

    .me-6 { margin-right: 1rem !important; margin-left: 6px !important; }

    /* type badge colours */
    .badge-issue    { background: #fee2e2; color: #b91c1c; }
    .badge-transfer { background: #e0f2fe; color: #0369a1; }
    .badge-return   { background: #d1fae5; color: #065f46; }

    /* status badge */
    .badge-pending  { background: var(--warning-light); color: #92400e; }
    .badge-approved { background: var(--success-light);  color: #065f46; }
    .badge-rejected { background: var(--danger-light);   color: #991b1b; }

    /* Quick-view modal (reuse same modal-overlay pattern) */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(18,20,40,.5); backdrop-filter: blur(4px);
        z-index: 200; align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    @keyframes slideUp { from { transform:translateY(30px);opacity:0; } to { transform:translateY(0);opacity:1; } }
    .modal-box {
        background:#fff; border-radius:16px;
        width:640px; max-width:95vw; max-height:90vh; overflow-y:auto;
        box-shadow:0 20px 60px rgba(0,0,0,.18); animation:slideUp .25s ease;
    }
    .modal-header-bar {
        display:flex; align-items:center; justify-content:space-between;
        padding:18px 22px; border-bottom:1px solid var(--border-color);
    }
    .modal-title-text { font-size:15px; font-weight:700; }
    .modal-close {
        width:30px; height:30px; border-radius:7px; border:none;
        background:var(--danger-light); color:var(--danger);
        font-size:18px; cursor:pointer; display:flex;
        align-items:center; justify-content:center; transition:all .15s;
    }
    .modal-close:hover { background:var(--danger); color:#fff; }
    .modal-body-pad { padding:20px 22px; }
    .modal-footer-bar {
        padding:16px 22px; border-top:1px solid var(--border-color);
        display:flex; justify-content:flex-end; gap:10px;
    }

    .detail-row { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px; }
    .detail-chip {
        display:inline-flex; align-items:center; gap:4px;
        background:var(--primary-light); color:var(--primary);
        border-radius:6px; padding:4px 10px; font-size:12px; font-weight:600;
    }

    .items-table { width:100%; border-collapse:collapse; margin-top:8px; }
    .items-table th {
        background:#f4f4f8; padding:7px 10px;
        font-size:11px; font-weight:700; color:var(--text-muted);
        text-transform:uppercase; letter-spacing:.3px; text-align:left;
    }
    .items-table td { padding:8px 10px; font-size:12.5px; border-bottom:1px solid #f0f0f5; }
    .items-table tr:last-child td { border-bottom:none; }

    /* approve / reject action buttons */
    .btn-approve { background:var(--success-light); color:var(--success); border:none; border-radius:6px; padding:4px 10px; font-size:12px; font-weight:600; cursor:pointer; }
    .btn-reject  { background:var(--danger-light);  color:var(--danger);  border:none; border-radius:6px; padding:4px 10px; font-size:12px; font-weight:600; cursor:pointer; }
    .btn-approve:hover { background:var(--success); color:#fff; }
    .btn-reject:hover  { background:var(--danger);  color:#fff; }
</style>

<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">

            <!-- ── Stat pills ── -->
            <div class="col-md-12 mt-3">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="card-title me-6">Stock Activity List</span>
                                <div class="d-flex gap-2 flex-wrap align-items-center" id="stat-pills-container">

                                    <!--<div class="stat-pill status-filter" data-status="" style="cursor:pointer;">
                                        <span class="num" id="val-total">0</span>
                                        <span class="lbl">Total</span>
                                    </div>
                                    <div class="stat-pill status-filter" data-status="pending" style="cursor:pointer;">
                                        <span class="num" id="val-pending">0</span>
                                        <span class="lbl">Pending</span>
                                    </div>
                                    <div class="stat-pill status-filter" data-status="approved" style="cursor:pointer;">
                                        <span class="num" id="val-approved">0</span>
                                        <span class="lbl">Approved</span>
                                    </div>
                                    <div class="stat-pill status-filter" data-status="rejected" style="cursor:pointer;">
                                        <span class="num" id="val-rejected">0</span>
                                        <span class="lbl">Rejected</span>
                                    </div>-->

                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <a href="/Stock_Transfer?mode=issue">
                                    <button class="btn btn-add"><i class="ri-add-line me-1 fw-medium align-middle"></i> New Issue</button>
                                </a>
                                <a href="/Stock_Transfer?mode=transfer">
                                    <button class="btn btn-add" style="background:#0ea5e9;"><i class="ri-swap-line me-1 fw-medium align-middle"></i> New Transfer</button>
                                </a>
                                <a href="/Stock_Transfer?mode=return">
                                    <button class="btn btn-add" style="background:#1aaa6b;"><i class="ri-arrow-go-back-line me-1 fw-medium align-middle"></i> New Return</button>
                                </a>
                            </div>
                        </div>
                    </div>
					
					<div class="summary-bar" id="summary-bar"></div>
					
                </div>
            </div>

            <!-- ── Filters ── -->
            <div class="col-xl-12">
                <form id="data-filter">
                    <div class="card mb-3">
                        <div class="card-body row g-3">

                            <div class="col-md-3">
                                <label class="text-black-normal label mb-1">Date Range</label>
                                <input type="text" class="date-range-input daterangepicker-field form-control-sm w-100"
                                       placeholder="Select Date Range"
                                       data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" />
                            </div>

                            <div class="col-md-2">
                                <label class="text-black-normal label mb-1">Activity Type</label>
                                <select id="act_type" name="act_type" class="form-control form-select form-select-sm js-example-basic-single w-100">
                                    <option value="">All Types</option>
                                    <option value="issue">Issue</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="return">Return</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="text-black-normal label mb-1">Status</label>
                                <select id="act_status" name="act_status" class="form-control form-select form-select-sm js-example-basic-single w-100">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="text-black-normal label mb-1">Warehouse</label>
                                <select id="store_id" name="store_id" class="form-control form-select form-select-sm js-example-basic-single w-100">
                                    <option value="">All Warehouses</option>
                                    <?php foreach ($warehouses as $wh): ?>
                                        <option value="<?= $wh->store_id ?>"><?= html_escape($wh->store_name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="text-black-normal label mb-1">&nbsp;</label>
                                <button type="submit" class="btn btn-search w-100"
                                        style="background:#5b5ea6;color:white;border:none;padding:6px 12px;border-radius:6px;">
                                    Search
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <!-- ── Table ── -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="stock_activity_table" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Activity ID</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>From Warehouse</th>
                                    <th>To Warehouse / Customer</th>
                                    <th>Total Qty</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Notes</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════
     QUICK VIEW MODAL
════════════════════════════════════════════ -->
<div class="modal-overlay" id="activityModal">
    <div class="modal-box">
        <div class="modal-header-bar">
            <div class="modal-title-text" id="actModalTitle">Activity Details</div>
            <button type="button" class="modal-close" onclick="closeActivityModal()"><i class="ri-close-line"></i></button>
        </div>
        <div class="modal-body-pad">

            <div class="detail-row" id="actDetailChips"></div>

            <div id="actItemsWrap">
                <div class="pay-section-title" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:8px;">
                    <i class="ri-list-check"></i> Items
                </div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Batch</th>
                            <th>Serial(s)</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody id="actItemsBody">
                        <tr><td colspan="4" class="text-center text-muted">Loading…</td></tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="modal-footer-bar" id="actModalFooter">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="closeActivityModal()">Close</button>
        </div>
    </div>
</div>


<script>
		// ─────────────────────────────────────────────
		//  GLOBALS
		// ─────────────────────────────────────────────
		let stockActivities = [];

		$(document).ready(function(){
			loadActivityList();
			loadActivityCounts();

			$('#data-filter').on('submit', function(e){
				e.preventDefault();
				loadActivityList();
				loadActivityCounts();
			});
		});

		// ─────────────────────────────────────────────
		//  FORMAT HELPERS
		// ─────────────────────────────────────────────
		function formatQty(v){ return new Intl.NumberFormat('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2}).format(parseFloat(v)||0); }

		function typeBadge(type){
			const map = {
				issue:    '<span class="badge badge-issue"><i class="ri-arrow-up-circle-line"></i> Issue</span>',
				transfer: '<span class="badge badge-transfer"><i class="ri-swap-line"></i> Transfer</span>',
				return:   '<span class="badge badge-return"><i class="ri-arrow-go-back-line"></i> Return</span>',
			};
			return map[(type||'').toLowerCase()] || '<span class="badge bg-secondary">'+(type||'Unknown')+'</span>';
		}

		function statusBadge(status){
			const map = {
				pending:  '<span class="badge badge-pending"><i class="ri-time-line"></i> Pending</span>',
				approved: '<span class="badge badge-approved"><i class="ri-check-line"></i> Approved</span>',
				rejected: '<span class="badge badge-rejected"><i class="ri-close-circle-line"></i> Rejected</span>',
			};
			return map[(status||'').toLowerCase()] || '<span class="badge bg-secondary">'+(status||'Unknown')+'</span>';
		}

		// ─────────────────────────────────────────────
		//  LOAD LIST
		// ─────────────────────────────────────────────
		function loadActivityList(){

			if($.fn.DataTable.isDataTable('#stock_activity_table')){
				$('#stock_activity_table').DataTable().clear().destroy();
			}

			$.ajax({
				url: '/Stock_Transfer/list',
				type: 'GET',
				dataType: 'json',
				data:{
					date_range: $('.date-range-input').val(),
					type:       $('#act_type').val(),
					status:     $('#act_status').val(),
					store_id:   $('#store_id').val(),
				},
				success: function(res){

					stockActivities = res.data || res || [];
					let tbody = '';

					if(stockActivities.length > 0){

						$.each(stockActivities, function(i, act){

							const destination = act.act_type === 'transfer'
								? (act.warehouse_to || '-')
								: (act.customer    || '-');

							let actionBtns = `
								<a class="btn btn-sm btn-info-light" title="View & Approve" href="/Stock_Transfer/load_for_approval/${act.st_activity_id}">
									<i class="ri-eye-line"></i> View/Approve
								</a>`;

							if((act.status||'').toLowerCase() === 'pending'){
								actionBtns += `
								<button class="btn btn-sm btn-approve ms-1" title="Approve" onclick="approveActivity(${act.st_activity_id})">
									<i class="ri-check-line"></i>
								</button>
								<button class="btn btn-sm btn-reject ms-1" title="Reject" onclick="rejectActivity(${act.st_activity_id})">
									<i class="ri-close-line"></i>
								</button>`;
							}

							tbody += `
							<tr>
								<td>${i+1}</td>
								<td><strong>#${act.st_activity_id}</strong></td>
								<td>
									${act.st_act_date ? act.st_act_date.split(' ')[0] : '-'}
									<br/>
									<small class="text-muted" style="font-size:11px;">${act.st_act_date ? (act.st_act_date.split(' ')[1]||'') : ''}</small>
								</td>
								<td>${typeBadge(act.act_type)}</td>
								<td>${act.warehouse_from || '-'}</td>
								<td>${destination}</td>
								<td class="text-center fw-normal">${formatQty(act.qty)}</td>
								<td class="text-center">${statusBadge(act.status)}</td>
								<td>${act.created_by_name || '-'}</td>
								<td><small class="text-muted">${act.note ? act.note.substring(0,40)+(act.note.length>40?'…':'') : '-'}</small></td>
								<td class="text-center">${actionBtns}</td>
							</tr>`;
						});

					} else {
						tbody = `<tr><td colspan="11" class="text-center text-muted">No Activities Found</td></tr>`;
					}

					$('#stock_activity_table tbody').html(tbody);
					initializeDataTable('#stock_activity_table');
				}
			});
		}

		// ─────────────────────────────────────────────
		//  LOAD COUNTS FOR PILLS
		// ─────────────────────────────────────────────
		/*function loadActivityCounts(){
			$.ajax({
				url: '/Stock_Transfer/get_counts',
				type: 'GET',
				dataType: 'json',
				success: function(res){
					if(!res || !res.data) return;
					const counts = res.data;
					$('#val-total').text(counts.total || 0);
					$('#val-pending').text(counts.pending || 0);
					$('#val-approved').text(counts.approved || 0);
					$('#val-rejected').text(counts.rejected || 0);
				}
			});
		}*/
		
		/* ═══════════════════════ DATA ═══════════════════════ */
		// AJAX call for GRN Dashboard
		var GRN_ITEMS = [];
		var STATUS_LABELS = {};
		var STATUS_CSS    = {};
		var STATUS_ICON   = {};

		function loadActivityCounts() {
			$.ajax({
				url: "/Stock_Transfer/get_counts",
				type: "GET",
				dataType: "json",
				success: function(res) {

					console.log(res);

					// Storing the original array response
					if (res.data) {
						GRN_ITEMS = Object.keys(res.data).map(function(key) {
							return {
								name: key,             // e.g. "pending", "approved"
								total: res.data[key]   // e.g. 28, 25
							};
						});
					} else {
						GRN_ITEMS = [];
					}
					
					// Dynamic mappings based on your design style
					GRN_ITEMS.forEach(function(item) {
						var key = (item.name || '').toLowerCase();

						// STATUS LABELS (e.g., "settled" -> "Settled")
						if (!STATUS_LABELS[key]) {
							STATUS_LABELS[key] = item.name + ' count';
						}

						// STATUS CSS (e.g., "st-settled")
						if (!STATUS_CSS[key]) {
							STATUS_CSS[key] = 'st-' + key;
						}
					});

					// Status FontAwesome Icons mapping matching your structure
					STATUS_ICON = {
						settled: 'fa-check-double',
						pending: 'fa-clock',
						approved: 'fa-circle-check',
						rejected: 'fa-circle-xmark',
						draft: 'fa-file-lines',
						partial: 'fa-layer-group'
					};

					// Call structural rendering functions
					renderGrnSummaryBar();
					// renderAllGrnTabs(); // Uncomment if you use tab views
				},
				error: function() {
					console.error('Failed to load GRN counts');
				}
			});
		}

		/* ─── COMPACT SUMMARY BAR (GRN VERSION) ─── */
		function renderGrnSummaryBar() {
			//var totalGrns = GRN_ITEMS.reduce(function(acc, item) { return acc + parseInt(item.total || 0); }, 0);
			
			// Mapping config for display panels
			var itemsConfig = {
				approved:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Approve Completed' },
				pending:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Awaiting Verification' },
				total: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
				rejected: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Needs Correction' },
				draft:    { icon: 'fa-file-lines',    bg: 'var(--primary-light)', ic: 'var(--primary)', sub: 'Saved Workspaces' }
			};

			// Generating array structure for your map generator loop
			var displayItems = GRN_ITEMS.map(function(item) {
				var key = (item.name || '').toLowerCase();
				var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Category' };
				
				// Dynamic addition of spans for specific status types
				var extraHtml = '';
				if (key === 'settled') {
					// Adds placeholder span for Sale Total under Verified Documents
					extraHtml = '<div class="sbi-extra-amt" style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #475569;">'
							  + 'Sale Total: <span id="totalGrnAmount" style="color:' + cfg.ic + '">'+ Sale_total +'</span>'
							  + '</div>';
				} if (key === 'outstanding') {
					// Adds placeholder span for Total Due under Awaiting Verification
					extraHtml = '<div class="sbi-extra-amt" style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #475569;">'
							  + 'Total Due: <span id="totalDueAmount" style="color:' + cfg.ic + '">'+ Total_Due +'</span>'
							  + '</div>';
				}

				return {
					icon: cfg.icon,
					ibg: cfg.bg,
					ic: cfg.ic,
					val: item.total,
					lbl: STATUS_LABELS[key] || item.name,
					sub: cfg.sub,
					extra: extraHtml
				};
			});

			// Automatically inject a "Total" card at the front of the summary bar array
			/*displayItems.unshift({
				icon: 'fa-boxes-stacked',
				ibg: '#e0f2fe',
				ic: '#0369a1',
				val: totalGrns,
				lbl: 'Total GRN Records',
				sub: 'Overall generated entries',
				extra: ''
			});*/

			// Your template literal generator matching your UI layout exactly
			var html = displayItems.map(function(item) {
				
				return '<div class="sb-item' + (item.cls ? ' ' + item.cls : '') + '">'
					+ '<div class="sbi-icon" style="background:' + item.ibg + ';color:' + item.ic + '"><i class="fa-solid ' + item.icon + '"></i></div>'
					+ '<div class="sbi-main">'
						+ '<div class="sbi-val" style="color:' + item.ic + '">' + item.val + '</div>'
						+ '<div class="sbi-lbl">' + item.lbl + '</div>'
						+ '<div class="sbi-sub">' + item.sub + '</div>'
						+ item.extra
					+ '</div>'
				+ '</div>';
			}).join('');

			// Target element to render the dynamic markup
			$('#summary-bar').html(html);
		}

		// ─────────────────────────────────────────────
		//  VIEW ACTIVITY (MODAL)
		// ─────────────────────────────────────────────
		function viewActivity(id){
			// Show modal
			document.getElementById('activityModal').classList.add('show');
			document.getElementById('actModalTitle').textContent = 'Activity #' + id;
			document.getElementById('actDetailChips').innerHTML  = '<span class="text-muted" style="font-size:12px;"><i class="ri-loader-4-line"></i> Loading…</span>';
			document.getElementById('actItemsBody').innerHTML    = '<tr><td colspan="4" class="text-center text-muted">Loading…</td></tr>';
			document.getElementById('actModalFooter').innerHTML  = '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="closeActivityModal()">Close</button>';

			$.ajax({
				url: '/Stock_Transfer/get/' + id,
				type: 'GET',
				dataType: 'json',
				success: function(res){
					const act = res.data;

					// Chips
					let chips = `
						<span class="detail-chip">${typeBadge(act.act_type)}</span>
						<span class="detail-chip"><i class="ri-map-pin-2-line"></i> From: ${act.warehouse_from||'-'}</span>`;

					if(act.act_type === 'transfer'){
						chips += `<span class="detail-chip"><i class="ri-arrow-right-line"></i> To: ${act.warehouse_to||'-'}</span>`;
					} else {
						chips += `<span class="detail-chip"><i class="ri-user-line"></i> Customer: ${act.customer||'-'}</span>`;
					}
					chips += `<span class="detail-chip"><i class="ri-calendar-line"></i> ${(act.st_act_date||'').split(' ')[0]}</span>`;
					chips += `<span class="detail-chip">${statusBadge(act.status)}</span>`;

					document.getElementById('actDetailChips').innerHTML = chips;

					// Items
					let itemRows = '';
					if(act.items && act.items.length > 0){
						act.items.forEach(function(item){
							itemRows += `<tr>
								<td>${item.product_name || ('Product #'+item.product_id)}</td>
								<td>${item.batch_id || '-'}</td>
								<td><small>${item.serial || '-'}</small></td>
								<td class="fw-bold">${formatQty(item.qty)}</td>
							</tr>`;
						});
					} else {
						itemRows = '<tr><td colspan="4" class="text-center text-muted">No items found</td></tr>';
					}
					document.getElementById('actItemsBody').innerHTML = itemRows;

					// Footer – approve/reject buttons for pending
					if((act.status||'').toLowerCase() === 'pending'){
						document.getElementById('actModalFooter').innerHTML = `
							<button type="button" class="btn btn-sm btn-outline-secondary" onclick="closeActivityModal()">Close</button>
							<button type="button" class="btn-reject" onclick="rejectActivity(${act.st_activity_id});closeActivityModal();">
								<i class="ri-close-line"></i> Reject
							</button>
							<button type="button" class="btn-approve" onclick="approveActivity(${act.st_activity_id});closeActivityModal();">
								<i class="ri-check-line"></i> Approve
							</button>`;
					}
				}
			});
		}

		function closeActivityModal(){
			document.getElementById('activityModal').classList.remove('show');
		}

		// ─────────────────────────────────────────────
		//  APPROVE / REJECT
		// ─────────────────────────────────────────────
		function approveActivity(id){
			if(!confirm('Approve this stock activity? This will update inventory.')){return;}

			$.ajax({
				url: '/Stock_Transfer/approve/' + id,
				type: 'POST',
				dataType: 'json',
				success: function(res){
					if(res.status === 'success'){
						showToast('Activity #'+id+' approved – stock updated', 'ri-check-double-line', '#1aaa6b');
					} else {
						showToast(res.msg || 'Approval failed', 'ri-error-warning-line', '#ef4444');
					}
					loadActivityList();
					loadActivityCounts();
				},
				error: function(){
					showToast('Server error during approval', 'ri-error-warning-line', '#ef4444');
				}
			});
		}

		function rejectActivity(id){
			const note = prompt('Reason for rejection (optional):') ?? '';

			$.ajax({
				url: '/Stock_Transfer/reject/' + id,
				type: 'POST',
				dataType: 'json',
				data: { note: note },
				success: function(res){
					if(res.status === 'success'){
						showToast('Activity #'+id+' rejected', 'ri-close-circle-line', '#ef4444');
					} else {
						showToast(res.msg || 'Rejection failed', 'ri-error-warning-line', '#ef4444');
					}
					loadActivityList();
					loadActivityCounts();
				}
			});
		}

		// ─────────────────────────────────────────────
		//  TOAST (reuse same pattern as sale list)
		// ─────────────────────────────────────────────
		function showToast(msg, icon='ri-information-line', color='#1e2139'){
			let container = document.querySelector('.toast-container');
			if(!container){
				container = document.createElement('div');
				container.className = 'toast-container';
				document.body.appendChild(container);
			}
			const toast = document.createElement('div');
			toast.className = 'toast-item';
			toast.style.background = color;
			toast.innerHTML = `<i class="${icon}"></i>${msg}`;
			container.appendChild(toast);
			setTimeout(()=>{ toast.style.opacity='0'; toast.style.transition='opacity .4s'; setTimeout(()=>toast.remove(),400); }, 3000);
		}
</script>