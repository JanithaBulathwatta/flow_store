<!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <style>
                    /* ── Status badges ── */
                    .cb-badge {
                        display: inline-flex;
                        align-items: center;
                        gap: 3px;
                        padding: 3px 10px;
                        border-radius: 20px;
                        font-size: .71rem;
                        font-weight: 600;
                        letter-spacing: .03em;
                        white-space: nowrap;
                    }

                    .cb-active {
                        background: #d1fae5;
                        color: #065f46;
                    }

                    .cb-completed {
                        background: #e2e8f0;
                        color: #334155;
                    }

                    .cb-on_hold {
                        background: #fef3c7;
                        color: #92400e;
                    }

                    .cb-cancelled {
                        background: #fee2e2;
                        color: #991b1b;
                    }

                    .cb-unused {
                        background: #eff6ff;
                        color: #1d4ed8;
                    }

                    .cb-issued {
                        background: #fef9c3;
                        color: #854d0e;
                    }

                    .cb-presented {
                        background: #f3e8ff;
                        color: #6b21a8;
                    }

                    .cb-cleared {
                        background: #dcfce7;
                        color: #166534;
                    }

                    .cb-bounced {
                        background: #fee2e2;
                        color: #991b1b;
                    }

                    /* ── Stat top-row cards ── */
                    .stat-top {
                        border-radius: 12px;
                        padding: 1.1rem 1.25rem;
                        display: flex;
                        align-items: center;
                        gap: .9rem;
                    }

                    .stat-top .s-icon {
                        width: 46px;
                        height: 46px;
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.25rem;
                        flex-shrink: 0;
                    }

                    .stat-top .s-val {
                        font-size: 1.3rem;
                        font-weight: 700;
                        line-height: 1.1;
                    }

                    .stat-top .s-sub {
                        font-size: .7rem;
                        color: #94a3b8;
                        margin-top: 2px;
                    }

                    .stat-top .s-lbl {
                        font-size: .75rem;
                        color: #64748b;
                        font-weight: 500;
                    }

                    /* ── Search / filter bar ── */
                    .filter-bar {
                        background: #f8fafc;
                        border: 1px solid #e9ecef;
                        border-radius: 10px;
                        padding: .7rem 1rem;
                    }

                    /* ── Table ── */
                    .chq-table th {
                        background: #f8f9fb;
                        font-size: .72rem;
                        text-transform: uppercase;
                        letter-spacing: .06em;
                        color: #64748b;
                        white-space: nowrap;
                    }

                    .chq-table td {
                        vertical-align: middle;
                        font-size: .8125rem;
                    }

                    .chq-table tr.row-hold td {
                        background: #fffbeb !important;
                    }

                    .chq-table tr.row-bounced td {
                        background: #fff5f5 !important;
                    }

                    .chq-no {
                        font-family: monospace;
                        font-weight: 700;
                        font-size: .875rem;
                        color: #405189;
                    }

                    .range-pill {
                        display: inline-flex;
                        align-items: center;
                        gap: 3px;
                        background: #eff6ff;
                        border: 1px solid #bfdbfe;
                        border-radius: 5px;
                        padding: 1px 7px;
                        font-family: monospace;
                        font-size: .78rem;
                        font-weight: 600;
                        color: #1e40af;
                    }

                    /* ── Empty state ── */
                    .empty-state {
                        text-align: center;
                        padding: 3rem 1rem;
                        color: #94a3b8;
                    }

                    .empty-state i {
                        font-size: 2.5rem;
                        display: block;
                        margin-bottom: .75rem;
                    }

                    .empty-state p {
                        font-size: .875rem;
                        margin: 0;
                    }

                    /* ── Book detail mini-stats ── */
                    .book-mini-stat {
                        text-align: center;
                        padding: .4rem .2rem;
                    }

                    .book-mini-stat .bv {
                        font-size: 1.05rem;
                        font-weight: 700;
                    }

                    .book-mini-stat .bl {
                        font-size: .65rem;
                        color: #94a3b8;
                        margin-top: 1px;
                    }

                    /* ── Progress bar inside book ── */
                    .bk-prog {
                        height: 5px;
                        border-radius: 3px;
                        background: #e9ecef;
                        overflow: hidden;
                        margin-top: 6px;
                    }

                    .bk-prog-bar {
                        height: 100%;
                        border-radius: 3px;
                        background: linear-gradient(90deg, #405189, #6172b0);
                    }

                    .bk-prog-bar.low {
                        background: linear-gradient(90deg, #ef4444, #dc2626);
                    }

                    /* ── Hold ribbon on book row ── */
                    .hold-chip {
                        display: inline-flex;
                        align-items: center;
                        gap: 3px;
                        background: #fef3c7;
                        color: #92400e;
                        border: 1px solid #fde68a;
                        border-radius: 5px;
                        padding: 1px 7px;
                        font-size: .68rem;
                        font-weight: 600;
                    }

                    /* ── Log timeline dot ── */
                    .log-dot {
                        width: 9px;
                        height: 9px;
                        border-radius: 50%;
                        flex-shrink: 0;
                        margin-top: 4px;
                    }

                    /* ── Toast ── */
                    #__tb {
                        position: fixed;
                        bottom: 20px;
                        right: 20px;
                        z-index: 9999;
                        display: flex;
                        flex-direction: column;
                        gap: 7px;
                    }

                    .t-item {
                        padding: 10px 15px;
                        border-radius: 8px;
                        font-size: 13px;
                        font-weight: 500;
                        color: #fff;
                        box-shadow: 0 3px 12px rgba(0, 0, 0, .18);
                        opacity: 0;
                        transform: translateY(5px);
                        transition: all .22s;
                        max-width: 290px;
                    }
                </style>

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <div>
                        <h1 class="page-title fw-semibold fs-18 mb-1">Cheque List</h1>
                        <span class="text-muted fs-12"><i class="ri-file-list-3-line me-1"></i>All cheques across all
                            books</span>
                    </div>
                    <div class="d-flex gap-2 align-items-center flex-wrap mt-2 mt-md-0">
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalIssueCheque">
                            <i class="ri-send-plane-line me-1"></i>Issue Cheque
                        </button>
                        <a href="<?= site_url('Finance/check_book'); ?>" class="btn btn-primary-light btn-sm"><i
                                class="ri-book-open-line me-1"></i>Books</a>
                        <a href="<?= site_url('Finance/cheque_log'); ?>" class="btn btn-info-light btn-sm"><i
                                class="ri-history-line me-1"></i>Log</a>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="cheque-book.html">Cheque Books</a></li>
                                <li class="breadcrumb-item active">Cheque List</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- ── TOP STATS ROW ── -->
                <div class="row g-3 mb-4" id="chqStats"></div>

                <!-- ── SEARCH / FILTER BAR ── -->
                <div class="filter-bar mb-3 d-flex flex-wrap gap-2 align-items-center">
                    <div class="input-group input-group-sm" style="max-width:240px;">
                        <span class="input-group-text"><i class="ri-search-line"></i></span>
                        <input type="text" class="form-control" placeholder="Cheque no. / payee…" id="chqSearch">
                    </div>
                    <select class="form-select form-select-sm" id="chqStatusFilter" style="max-width:160px;">
                        <option value="">All Status</option>
                        <option value="unused">Unused</option>
                        <option value="issued">Issued</option>
                        <option value="presented">Presented</option>
                        <option value="cleared">Cleared</option>
                        <option value="bounced">Bounced</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="on_hold">On Hold</option>
                    </select>
                    <select class="form-select form-select-sm" id="chqBookFilter" style="max-width:180px;">
                        <option value="">All Books</option>
                    </select>
                    <select class="form-select form-select-sm" id="chqHoldFilter" style="max-width:140px;">
                        <option value="">Hold: All</option>
                        <option value="1">Held Only</option>
                        <option value="0">Not Held</option>
                    </select>
                    <span class="ms-auto text-muted fs-12" id="chqCount"></span>
                </div>

                <!-- ── CHEQUES TABLE ── -->
                <div class="card custom-card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span class="fw-semibold fs-14"><i class="ri-file-list-3-line me-2 text-primary"></i>Cheque
                            Register</span>
                        <div class="d-flex gap-1">
                            <input type="checkbox" class="form-check-input" id="chkAllChq" title="Select all"> <span
                                class="ms-1 fs-12 text-muted">Select all</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table chq-table mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input" id="chkAllChq2"></th>
                                        <th>Cheque No.</th>
                                        <th>Book</th>
                                        <th>Payee</th>
                                        <th>Amount</th>
                                        <th>Cheque Date</th>
                                        <th>Issued Date</th>
                                        <th>Cleared Date</th>
                                        <th>Issued By</th>
                                        <th>Status</th>
                                        <th>Hold</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="chqTbody"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span class="text-muted fs-12" id="chqFooterCount">0 records</span>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- ── MODAL: Issue Cheque ── -->
                <div class="modal fade" id="modalIssueCheque" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title fw-semibold"><i
                                        class="ri-send-plane-line me-2 text-success"></i>Issue Cheque</h6>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-success-transparent py-2 fs-12 mb-3"><i
                                        class="ri-shield-check-line me-1"></i>Only <strong>unused</strong> cheques that
                                    are <strong>not on hold</strong> can be issued.</div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Cheque Book <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="issBook">
                                            <option value="">-- Select Book --</option>
                                            <option value="1">CB-2026-001 (101–150)</option>
                                            <option value="3">CB-2026-003 (301–350)</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Cheque No. <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="issChqNo">
                                            <option>-- Select --</option>
                                            <option>000104 (unused)</option>
                                            <option>000106 (unused)</option>
                                            <option>000107 (unused)</option>
                                            <option>000303 (unused)</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Payee <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="issPayee" placeholder="Payee name">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Amount (LKR) <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group"><span class="input-group-text fs-12">LKR</span><input
                                                type="number" class="form-control" id="issAmt" step="0.01"
                                                placeholder="0.00"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Cheque Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="issDate">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Voucher Ref.</label>
                                        <input type="text" class="form-control" placeholder="e.g. VCH-2026-0041">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-medium fs-13">Narration</label>
                                        <textarea class="form-control" rows="2"
                                            placeholder="Purpose of cheque…"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-success btn-sm" onclick="doIssueCheque()"
                                    data-bs-dismiss="modal"><i class="ri-check-line me-1"></i>Issue Cheque</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── MODAL: Hold Cheque ── -->
                <div class="modal fade" id="modalHoldChq" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title fw-semibold text-warning"><i
                                        class="ri-file-lock-line me-2"></i>Hold Cheque</h6>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-warning-transparent py-2 fs-12 mb-3"><i
                                        class="ri-error-warning-line me-1"></i>This cheque will be
                                    <strong>blocked</strong> from further processing.</div>
                                <div class="p-3 bg-light rounded mb-3 fs-13">
                                    <div class="row g-2">
                                        <div class="col-6">Cheque No: <strong id="hcNo">—</strong></div>
                                        <div class="col-6">Status: <span id="hcStatus">—</span></div>
                                        <div class="col-6">Payee: <span id="hcPayee">—</span></div>
                                        <div class="col-6">Amount: <span id="hcAmt"
                                                class="fw-semibold text-primary">—</span></div>
                                    </div>
                                </div>
                                <label class="form-label fw-medium fs-13">Reason <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="hcReason"
                                    placeholder="Enter hold reason…"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-warning btn-sm" onclick="doHoldCheque()"
                                    data-bs-dismiss="modal"><i class="ri-lock-line me-1"></i>Confirm Hold</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── MODAL: Update Status ── -->
                <div class="modal fade" id="modalUpdStatus" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title fw-semibold"><i class="ri-refresh-line me-2 text-info"></i>Update
                                    Cheque Status</h6>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="p-3 bg-light rounded mb-3 fs-13">
                                    <div class="row g-2">
                                        <div class="col-6">Cheque No: <strong id="usNo">—</strong></div>
                                        <div class="col-6">Current: <span id="usCurSt">—</span></div>
                                        <div class="col-6">Payee: <span id="usPayee">—</span></div>
                                        <div class="col-6">Amount: <span id="usAmt"
                                                class="fw-semibold text-primary">—</span></div>
                                    </div>
                                </div>
                                <label class="form-label fw-medium fs-13 mb-2">New Status</label>
                                <div class="d-flex flex-wrap gap-2 mb-3" id="usOptBtns">
                                    <button class="btn btn-sm btn-outline-secondary us-opt"
                                        onclick="selUsOpt(this,'presented')">Presented</button>
                                    <button class="btn btn-sm btn-outline-success us-opt"
                                        onclick="selUsOpt(this,'cleared')">Cleared</button>
                                    <button class="btn btn-sm btn-outline-danger us-opt"
                                        onclick="selUsOpt(this,'bounced')">Bounced</button>
                                    <button class="btn btn-sm btn-outline-secondary us-opt"
                                        onclick="selUsOpt(this,'cancelled')">Cancelled</button>
                                </div>
                                <label class="form-label fw-medium fs-13">Effective Date</label>
                                <input type="date" class="form-control mb-3" id="usDate">
                                <label class="form-label fw-medium fs-13">Remarks</label>
                                <textarea class="form-control" rows="2" id="usRemarks"
                                    placeholder="Reason / notes…"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary btn-sm" onclick="doUpdateStatus()"
                                    data-bs-dismiss="modal"><i class="ri-check-line me-1"></i>Update</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <footer class="footer mt-auto py-3 bg-white text-center">
            <div class="container"><span class="text-muted">Copyright &copy; <span id="year"></span> <a href="#"
                        class="text-dark fw-semibold">Rixzo</a>. All rights reserved.</span></div>
        </footer>

        <script>
			$(document).ready(function(){
				loadCheques();
			});

            // ── Utilities ──────────────────────────────────────────────────────────────────
            function fmtLKR(n) { return n ? 'LKR ' + n.toLocaleString('en-US') : '—'; }
            function fmtDate(d) { if (!d) return '—'; var dt = new Date(d); return isNaN(dt) ? d : dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }); }
            function sbadge(s) { return '<span class="cb-badge cb-' + s + '">' + s + '</span>'; }
            function hbadge(b, by) { return b ? '<span class="hold-chip"><i class="ri-lock-line"></i>' + by + '</span>' : '<span style="color:#22c55e;font-size:.75rem;"><i class="ri-lock-unlock-line"></i></span>'; }

            function toast(msg, type) {
                type = type || 'primary';
                var C = { primary: '#405189', success: '#22c55e', warning: '#f59e0b', danger: '#ef4444' };
                var box = document.getElementById('__tb');
                if (!box) { box = document.createElement('div'); box.id = '__tb'; document.body.appendChild(box); }
                var t = document.createElement('div'); t.className = 't-item';
                t.style.background = C[type] || C.primary;
                t.innerHTML = '<i class="ri-check-line me-2"></i>' + msg;
                box.appendChild(t);
                requestAnimationFrame(function () { t.style.opacity = 1; t.style.transform = 'translateY(0)'; });
                setTimeout(function () { t.style.opacity = 0; setTimeout(function () { t.remove(); }, 300); }, 3200);
            }

            function showEmpty(tbodyId, cols) {
                var tb = document.getElementById(tbodyId); if (!tb) return;
                tb.innerHTML = '<tr><td colspan="' + cols + '" class="p-0"><div class="empty-state"><i class="ri-inbox-line"></i><p>No records found</p></div></td></tr>';
            }
        </script>

        <script>
            var activeChqId = null, selectedNewStatus = '';

            // ── Populate book filter ──────────────────────────────────────────────────────
            (function () {
                var sel = document.getElementById('chqBookFilter');
                if (!sel) return;
                BOOKS.forEach(function (b) { var o = document.createElement('option'); o.value = b.id; o.textContent = b.no; sel.appendChild(o); });
            })();

            // ── Render stats ──────────────────────────────────────────────────────────────
            function renderChqStats() {
                var total = CHEQUES.length;
                var issued = CHEQUES.filter(function (c) { return c.status === 'issued'; });
                var issuedVal = issued.reduce(function (s, c) { return s + c.amount; }, 0);
                var held = CHEQUES.filter(function (c) { return c.isHold; });
                var heldVal = held.reduce(function (s, c) { return s + c.amount; }, 0);
                var cleared = CHEQUES.filter(function (c) { return c.status === 'cleared'; });
                var clearedVal = cleared.reduce(function (s, c) { return s + c.amount; }, 0);
                var bounced = CHEQUES.filter(function (c) { return c.status === 'bounced'; });
                var bouncedVal = bounced.reduce(function (s, c) { return s + c.amount; }, 0);

                var stats = [
                    { icon: 'ri-file-list-line', bg: '#eff6ff', ic: '#1d4ed8', lbl: 'Total Cheques', val: total, sub: CHEQUES.filter(function (c) { return c.status === 'unused'; }).length + ' unused' },
                    { icon: 'ri-send-plane-line', bg: '#fef9c3', ic: '#854d0e', lbl: 'Issued', val: issued.length + ' cheques', sub: fmtLKR(issuedVal) },
                    { icon: 'ri-lock-line', bg: '#fef3c7', ic: '#92400e', lbl: 'On Hold', val: held.length + ' cheques', sub: fmtLKR(heldVal) },
                    { icon: 'ri-checkbox-circle-line', bg: '#f0fdf4', ic: '#166534', lbl: 'Cleared', val: cleared.length + ' cheques', sub: fmtLKR(clearedVal) },
                    { icon: 'ri-error-warning-line', bg: '#fff1f2', ic: '#991b1b', lbl: 'Bounced', val: bounced.length + ' cheques', sub: fmtLKR(bouncedVal) },
                ];
                document.getElementById('chqStats').innerHTML = stats.map(function (s) {
                    return '<div class="col-sm-6 col-xl"><div class="card custom-card"><div class="card-body stat-top">' +
                        '<div class="s-icon" style="background:' + s.bg + '"><i class="' + s.icon + '" style="color:' + s.ic + ';font-size:1.2rem;"></i></div>' +
                        '<div><div class="s-val">' + s.val + '</div><div class="s-lbl">' + s.lbl + '</div><div class="s-sub">' + s.sub + '</div></div>' +
                        '</div></div></div>';
                }).join('');
            }
			
			// get book id by url
			function getBookId() {
				const urlParams = new URLSearchParams(window.location.search);
				return urlParams.get('book');
			}

            // ── Render cheques table ──────────────────────────────────────────────────────
            function loadCheques() {

			let bookId = getBookId();

			$.ajax({
				url: "<?= site_url('Finance/get_cheques'); ?>",
				type: "GET",
				data: { book: bookId },
				dataType: "json",
				success: function(res) {

					let tbody = '';

					if (res.data.length > 0) {

						$.each(res.data, function(i, c) {

							let holdClass = c.is_hold == 1 ? 'row-hold' : '';
							let bounceClass = c.status == 'bounced' ? 'row-bounced' : '';

							tbody += `
							<tr class="${holdClass} ${bounceClass}">
								
								<td><span class="chq-no">${c.cheque_no}</span></td>

								<td>${c.cheque_book_no}</td>

								<td>${c.payee_name ?? '-'}</td>

								<td>${c.amount ? 'LKR ' + parseFloat(c.amount).toLocaleString() : '-'}</td>

								<td>${c.cheque_date ?? '-'}</td>

								<td>
									<span class="cb-badge cb-${c.status}">
										${c.status}
									</span>
								</td>

								<td>
									${c.is_hold == 1 
										? '<span class="hold-chip">ON HOLD</span>' 
										: '-'}
								</td>

								<td>
									<div class="d-flex gap-1">

										${c.status === 'unused' ? `
											<button class="btn btn-sm btn-primary issueBtn"
												data-id="${c.id}">
												Issue
											</button>
										` : ''}

										${c.status === 'issued' ? `
											<button class="btn btn-sm btn-warning presentBtn"
												data-id="${c.id}">
												Present
											</button>
										` : ''}

										${c.status === 'presented' ? `
											<button class="btn btn-sm btn-success clearBtn"
												data-id="${c.id}">
												Clear
											</button>

											<button class="btn btn-sm btn-danger bounceBtn"
												data-id="${c.id}">
												Bounce
											</button>
										` : ''}

									</div>
								</td>

							</tr>`;
						});

					} else {
						tbody = `<tr><td colspan="8" class="text-center">No cheques found</td></tr>`;
					}

					$('#chqTbody').html(tbody);
				}
			});
		}

		// issued Cheques
		$(document).on('click', '.issueBtn', function () {

			let id = $(this).data('id');

			$.post("<?= site_url('Finance/update_cheque_status'); ?>", {
				id: id,
				status: 'issued'
			}, function (res) {

				if (res.stt === 'ok') {
					loadCheques();
				} else {
					alert(res.msg);
				}

			}, 'json');
		});
		
		// present sts
		$(document).on('click', '.presentBtn', function () {

			let id = $(this).data('id');

			$.post("<?= site_url('Finance/update_cheque_status'); ?>", {
				id: id,
				status: 'presented'
			}, function (res) {
				loadCheques();
			}, 'json');
		});
		
		// bounce
		$(document).on('click', '.bounceBtn', function () {

			let id = $(this).data('id');

			$.post("<?= site_url('Finance/update_cheque_status'); ?>", {
				id: id,
				status: 'bounced'
			}, function (res) {
				loadCheques();
			}, 'json');
		});
		
		
				
		
            function openHoldChq(id) {
                activeChqId = id;
                var c = CHEQUES.find(function (c) { return c.id === id; }); if (!c) return;
                document.getElementById('hcNo').textContent = c.no;
                document.getElementById('hcStatus').innerHTML = sbadge(c.status);
                document.getElementById('hcPayee').textContent = c.payee || '—';
                document.getElementById('hcAmt').textContent = c.amount ? fmtLKR(c.amount) : '—';
                document.getElementById('hcReason').value = '';
            }

            function doHoldCheque() {
                var c = CHEQUES.find(function (c) { return c.id === activeChqId; }); if (!c) return;
                var r = document.getElementById('hcReason').value.trim(); if (!r) { toast('Reason required', 'warning'); return; }
                c.isHold = true; c.holdBy = 'Admin'; c.holdReason = r;
                LOGS.unshift({ chequeNo: c.no, bookNo: c.bookNo, oldSt: c.status, newSt: 'on_hold', by: 'Admin', at: new Date().toLocaleString(), remarks: r });
                renderCheques(); renderChqStats(); toast('Cheque ' + c.no + ' placed on hold', 'warning');
            }

            function doUnholdChq(id) {
                var c = CHEQUES.find(function (c) { return c.id === id; }); if (!c) return;
                if (!confirm('Remove hold from cheque ' + c.no + '?')) return;
                c.isHold = false; c.holdBy = ''; c.holdReason = '';
                LOGS.unshift({ chequeNo: c.no, bookNo: c.bookNo, oldSt: 'on_hold', newSt: c.status, by: 'Admin', at: new Date().toLocaleString(), remarks: 'Hold removed' });
                renderCheques(); renderChqStats(); toast('Hold removed from ' + c.no, 'success');
            }

            function openUpdStatus(id) {
                activeChqId = id;
                var c = CHEQUES.find(function (c) { return c.id === id; }); if (!c) return;
                document.getElementById('usNo').textContent = c.no;
                document.getElementById('usCurSt').innerHTML = sbadge(c.status);
                document.getElementById('usPayee').textContent = c.payee || '—';
                document.getElementById('usAmt').textContent = c.amount ? fmtLKR(c.amount) : '—';
                document.getElementById('usRemarks').value = '';
                document.querySelectorAll('.us-opt').forEach(function (b) { b.classList.remove('active'); });
                selectedNewStatus = '';
            }

            function selUsOpt(btn, st) {
                document.querySelectorAll('.us-opt').forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active'); selectedNewStatus = st;
            }

            function doUpdateStatus() {
                if (!selectedNewStatus) { toast('Select a status', 'warning'); return; }
                var c = CHEQUES.find(function (c) { return c.id === activeChqId; }); if (!c) return;
                var old = c.status; c.status = selectedNewStatus;
                if (selectedNewStatus === 'cleared') c.clearedDate = document.getElementById('usDate').value || new Date().toISOString().slice(0, 10);
                LOGS.unshift({ chequeNo: c.no, bookNo: c.bookNo, oldSt: old, newSt: selectedNewStatus, by: 'Admin', at: new Date().toLocaleString(), remarks: document.getElementById('usRemarks').value || '—' });
                renderCheques(); renderChqStats(); toast('Cheque ' + c.no + ' → ' + selectedNewStatus, selectedNewStatus === 'cleared' ? 'success' : selectedNewStatus === 'bounced' ? 'danger' : 'primary');
            }

            function openViewChq(id) {
                var c = CHEQUES.find(function (c) { return c.id === id; }); if (c) toast('View: ' + c.no + ' | ' + c.payee + ' | ' + fmtLKR(c.amount), 'primary');
            }

            function doIssueCheque() {
                var p = document.getElementById('issPayee').value.trim();
                var a = document.getElementById('issAmt').value;
                if (!p || !a) { toast('Fill required fields', 'warning'); return; }
                toast('Cheque issued to ' + p + ' for LKR ' + parseInt(a).toLocaleString(), 'success');
                renderCheques(); renderChqStats();
            }

            document.getElementById('chqSearch') && document.getElementById('chqSearch').addEventListener('input', renderCheques);
            document.getElementById('chqStatusFilter') && document.getElementById('chqStatusFilter').addEventListener('change', renderCheques);
            document.getElementById('chqBookFilter') && document.getElementById('chqBookFilter').addEventListener('change', renderCheques);
            document.getElementById('chqHoldFilter') && document.getElementById('chqHoldFilter').addEventListener('change', renderCheques);

            function init() { renderChqStats(); renderCheques(); var y = document.getElementById('year'); if (y) y.textContent = new Date().getFullYear(); }
            if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); } else { setTimeout(init, 100); }
        </script>