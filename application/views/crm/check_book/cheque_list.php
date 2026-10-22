<!-- Start::app-content -->
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">
        <div class="main-content app-content">
            <div class="container-fluid">

                <style>
                    
                    /* ── Stat top-row cards ── */
                    .stat-top {
                        border-radius: var(--radius-md);
                        padding: 1.1rem 1.25rem;
                        display: flex;
                        align-items: center;
                        gap: .9rem;
                        background: var(--white);
                        border: 1px solid var(--input-border);
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
                        color: var(--black-dark);
                    }

                    .stat-top .s-sub {
                        font-size: .7rem;
                        color: var(--black-normal);
                        margin-top: 2px;
                    }

                    .stat-top .s-lbl {
                        font-size: .75rem;
                        color: var(--black-normal);
                        font-weight: 500;
                    }

                    /* ── Search / filter bar ── */
                    .filter-bar {
                        background: var(--black-soft);
                        border: 1px solid var(--input-border);
                        border-radius: 10px;
                        padding: .7rem 1rem;
                    }

                    /* ── Table ── */
                    .chq-table th {
                        background: var(--blue-soft);
                        font-size: .72rem;
                        text-transform: uppercase;
                        letter-spacing: .06em;
                        color: var(--black-normal);
                        white-space: nowrap;
                        border-bottom: 1px solid var(--input-border);
                    }

                    .chq-table td {
                        vertical-align: middle;
                        font-size: .8125rem;
                        color: var(--black-dark);
                        border-bottom: 1px solid var(--input-border);
                    }

                    .chq-table tr.row-hold td {
                        background: var(--yellow-soft) !important;
                    }

                    .chq-table tr.row-bounced td {
                        background: var(--red-soft) !important;
                    }

                    .chq-no {
                        font-family: 'JetBrains Mono', monospace;
                        font-weight: 700;
                        font-size: .875rem;
                        color: var(--blue-dark);
                    }

                    .range-pill {
                        display: inline-flex;
                        align-items: center;
                        gap: 3px;
                        background: var(--blue-soft);
                        border: 1px solid var(--blue-normal);
                        border-radius: 5px;
                        padding: 1px 7px;
                        font-family: 'JetBrains Mono', monospace;
                        font-size: .78rem;
                        font-weight: 600;
                        color: var(--blue-dark);
                    }

                    /* ── Empty state ── */
                    .empty-state {
                        text-align: center;
                        padding: 3rem 1rem;
                        color: var(--black-normal);
                    }

                    .empty-state i {
                        font-size: 2.5rem;
                        display: block;
                        margin-bottom: .75rem;
                        color: var(--blue-normal);
                    }

                    .empty-state p {
                        font-size: .875rem;
                        margin: 0;
                    }

                    
                    /* ── Progress bar inside book ── */
                    .bk-prog {
                        height: 5px;
                        border-radius: 3px;
                        background: var(--input-border);
                        overflow: hidden;
                        margin-top: 6px;
                    }

                    .bk-prog-bar {
                        height: 100%;
                        border-radius: 3px;
                        background: linear-gradient(90deg, var(--blue-dark), var(--blue-normal));
                    }

                    .bk-prog-bar.low {
                        background: linear-gradient(90deg, var(--red-dark), var(--red-normal));
                    }

                    /* ── Hold ribbon on book row ── */
                    .hold-chip {
                        display: inline-flex;
                        align-items: center;
                        gap: 3px;
                        background: var(--yellow-soft);
                        color: var(--yellow-dark);
                        border: 1px solid var(--yellow-normal);
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
                        background: var(--blue-normal);
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
                        border-radius: var(--radius-sm);
                        font-size: 13px;
                        font-weight: 500;
                        color: var(--white);
                        box-shadow: var(--shadow-lg);
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
                        <!--<button class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalIssueCheque">
                            <i class="ri-send-plane-line me-1"></i>Issue Cheque
                        </button>-->
                        <a href="<?= site_url('Finance/check_book'); ?>" class="btn btn-primary-light btn-sm"><i
                                class="ri-book-open-line me-1"></i>Books</a>
                        <a href="<?= site_url('Finance/cheque_log'); ?>" class="btn btn-info-light btn-sm"><i
                                class="ri-history-line me-1"></i>Log</a>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Cheque Books</li>
                                <li class="breadcrumb-item active">Cheque List</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- ── TOP STATS ROW ── -->
                <!--<div class="row g-3 mb-4" id="chqStats"></div>-->
				
				<div class="summary-bar" id="summary-bar"></div>

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
                            </div>

                            <div class="modal-body">
                                <div class="alert alert-success-transparent py-2 fs-12 mb-3"><i
                                        class="ri-shield-check-line me-1"></i>Only <strong>unused</strong> cheques that
                                    are <strong>not on hold</strong> can be issued.</div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Cheque Book <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="issBook" required>
                                            
											<?php if (!empty($selected_book)): ?>
												<option value="<?= $selected_book->id ?>">
													<?= $selected_book->cheque_book_no ?>
												</option>
											<?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Cheque No. <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="issChqNo" required>
                                            <option>-- Select --</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Payee <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="issPayee" placeholder="Payee name" maxlength="100" required
												pattern="[A-Za-z\s]+" 
												title="Please enter letters and spaces only">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Amount (LKR) <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group"><span class="input-group-text fs-12">LKR</span><input
                                                type="number" class="form-control" id="issAmt" step="0.01"
                                                placeholder="0.00" required></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Cheque Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="issDate" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium fs-13">Voucher Ref.</label>
                                        <!--<input type="text" class="form-control" placeholder="e.g. VCH-2026-0041">-->
										<select class="form-select" id="voucher_ref" required>
                                            <option value="">-- Select Voucher --</option>
											<?php if (!empty($voucher)): ?>
												<?php foreach($voucher as $v): ?>
													<option value="<?= $v->id ?>">
														<?= $v->user_name ?> </option>
												<?php endforeach; ?>
											<?php endif; ?>
                                        </select>
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

				
				<div class="modal fade" id="modalHoldChq" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="holdChequeForm">
								<div class="modal-header">
									<h6 class="modal-title fw-semibold text-warning"><i class="ri-file-lock-line me-2"></i>Hold Cheque</h6>
									<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
								</div>
								<div class="modal-body">
									<input type="hidden" name="id" id="hold_chq_id">
									<input type="hidden" name="status" value="on_hold">

									<div class="alert alert-warning-transparent py-2 fs-12 mb-3">
										<i class="ri-error-warning-line me-1"></i>This cheque will be <strong>blocked</strong> from further processing.
									</div>
									
									<div class="p-3 bg-light rounded mb-3 fs-13">
										<div class="row g-2">
											<div class="col-6">Cheque No: <strong id="hcNo">—</strong></div>
											<div class="col-6">Status: <span id="hcStatus">—</span></div>
											<div class="col-6">Payee: <span id="hcPayee">—</span></div>
											<div class="col-6">Amount: <span id="hcAmt" class="fw-semibold text-primary">—</span></div>
										</div>
									</div>

									<label class="form-label fw-medium fs-13">Reason <span class="text-danger">*</span></label>
									<textarea class="form-control" rows="3" name="remarks" id="hcReason" placeholder="Enter hold reason…" required></textarea>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-warning btn-sm"><i class="ri-lock-line me-1"></i>Confirm Hold</button>
								</div>
							</form>
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
									<button class="btn btn-sm btn-outline-primary us-opt" id="btnRelIssued" style="display:none;" onclick="selUsOpt(this,'issued')">Release to Issued</button>
									<button class="btn btn-sm btn-outline-info us-opt" id="btnRelUnused" style="display:none;" onclick="selUsOpt(this,'unused')">Release to Unused</button>

                                </div>
                                <label class="form-label fw-medium fs-13">Effective Date</label>
                                <input type="date" class="form-control mb-3" id="usDate">
                                <label class="form-label fw-medium fs-13">Remarks</label>
                                <textarea class="form-control" rows="2" id="usRemarks"
                                    placeholder="Reason / notes…"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-sm close-btn" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary btn-sm" onclick="doUpdateStatus()"
                                    data-bs-dismiss="modal"><i class="ri-check-line me-1"></i>Update</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


       <script>
	   // ==============================
		// GLOBAL VARIABLES
		// ==============================
		let us_id = '';
		let us_status = '';

		// single modal instance
		const statusModal = new bootstrap.Modal(document.getElementById('modalUpdStatus'));


		// ==============================
		// LOAD CHEQUES TABLE
		// ==============================
		$(document).ready(function(){
			loadCheques();
			
		});

		function getBookId() {
			const urlParams = new URLSearchParams(window.location.search);
			return urlParams.get('book');
		}

	function loadCheques() {
		let bookId = getBookId();
		let search = $('#chqSearch').val();
		let status = $('#chqStatusFilter').val();
		let book   = $('#chqBookFilter').val();
		let hold   = $('#chqHoldFilter').val();

		$.ajax({
			url: "<?= site_url('Finance/get_cheques'); ?>",
			type: "GET",
			data: { book: bookId },
			dataType: "json",
			success: function(res) {
				// ✅ Set Page Title dynamically
				if(res.data && res.data.length > 0) {
					$('.page-title').text('Cheque List - ' + res.data[0].cheque_book_no);
				}

				let tbody = '';
				let data = res.data || [];
				
				let filtered = data.filter(function(c) {
					return (
						(!search || (c.cheque_no?.toLowerCase().includes(search.toLowerCase()) || c.payee_name?.toLowerCase().includes(search.toLowerCase()))) &&
						(!status || c.status === status) &&
						(!book || c.cheque_book_id == book) &&
						(hold === '' || c.is_hold == hold)
					);
				});

				if(filtered.length > 0) {
					$.each(filtered, function(i, c) {
						let actionBtns = '';
						let formattedAmt = c.amount ? 'LKR ' + parseFloat(c.amount).toLocaleString() : '-';
						
						let printBtn = `<a href="<?= site_url('Finance/print_cheque'); ?>?cheque=${c.id}" target="_blank" class="btn btn-sm btn-icon btn-info-light me-1" title="Print Cheque"><i class="ri-printer-line"></i></a>`;
						
						let holdBtn = `<button class="btn btn-sm btn-icon btn-warning-light openHoldModal" data-id="${c.id}" data-no="${c.cheque_no}" data-status="${c.status}" data-payee="${c.payee_name ?? '-'}" data-amount="${formattedAmt}"><i class="ri-lock-line"></i></button>`;
						
						// ✅ Logic for different statuses
						if (c.status === 'unused') {
							actionBtns = `<button class="btn btn-sm btn-primary openIssueModal" data-id="${c.id}" data-no="${c.cheque_no}" data-status="${c.status}" data-bookid="${c.cheque_book_id}">Issue</button>`;
						} 
						else if (c.status === 'issued') {
							actionBtns = printBtn + `<button class="btn btn-sm btn-warning openStatusModal" data-id="${c.id}" data-no="${c.cheque_no}" data-status="${c.status}" data-payee="${c.payee_name ?? '-'}" data-amount="${formattedAmt}">Present</button>` + holdBtn;
						} 
						else if (c.status === 'presented') {
							actionBtns = printBtn + `<button class="btn btn-sm btn-success openStatusModal" data-id="${c.id}" data-no="${c.cheque_no}" data-status="${c.status}" data-payee="${c.payee_name ?? '-'}" data-amount="${formattedAmt}">Clear</button> <button class="btn btn-sm btn-danger openStatusModal" data-id="${c.id}" data-no="${c.cheque_no}" data-status="${c.status}" data-payee="${c.payee_name ?? '-'}" data-amount="${formattedAmt}">Bounce</button>` + holdBtn;
						} 
						else if (c.status === 'on_hold') {
							// ✅ Added data-payee and data-amount here so the modal isn't empty on release
							actionBtns = printBtn + `<button class="btn btn-sm btn-icon btn-success-light openStatusModal" data-id="${c.id}" data-no="${c.cheque_no}" data-status="${c.status}" data-payee="${c.payee_name ?? '-'}" data-amount="${formattedAmt}" title="Release Hold"><i class="ri-lock-unlock-line"></i></button>`;
						}

						// ✅ Hoverable Hold Status
						let holdStatusHtml = c.is_hold == 1 
							? `<span title="Reason: ${c.hold_reason ?? 'No reason provided'}" style="cursor:help; border-bottom: 1px dashed #fb8c00; color: #fb8c00; font-weight: bold;">ON HOLD</span>` 
							: '-';

						tbody += `
						<tr>
							<td><input type="checkbox" class="form-check-input chq-select" value="${c.id}"></td>
							<td>${c.cheque_no}</td>
							<td>${c.cheque_book_no}</td>
							<td>${c.payee_name ?? '-'}</td>
							<td>${c.amount ? parseFloat(c.amount).toLocaleString() + '.00' : '-'}</td>
							<td>${c.cheque_date ?? '-'}</td>
							<td>${c.issued_date ?? '-'}</td>
							<td>${c.cleared_date ?? '-'}</td>
							<td>${c.issued_by_name ?? '-'}</td>
							<td><span class="cb-badge cb-${c.status}">${c.status}</span></td>
							<td>${holdStatusHtml}</td>
							<td>${actionBtns}</td>
						</tr>`;
					});
				} else {
					tbody = `<tr><td colspan="12" class="text-center">No cheques found</td></tr>`;
				}
				$('#chqTbody').html(tbody);
			}
		});
	}
		
		$('#chqSearch').on('input', loadCheques);
		$('#chqStatusFilter').on('change', loadCheques);
		$('#chqBookFilter').on('change', loadCheques);
		$('#chqHoldFilter').on('change', loadCheques);


		// ==============================
		// OPEN STATUS MODAL (Enhanced)
		// ==============================
		$(document).on('click', '.openStatusModal', function () {
		const d = $(this).data();
		us_id = d.id;

		// Fill the Info Section (Fixes the "null/--" issue)
		$('#usNo').text(d.no);
		$('#usCurSt').text(d.status);
		$('#usPayee').text(d.payee || '-');
		$('#usAmt').text(d.amount || '-');

		// Reset all buttons
		$('.us-opt').hide().removeClass('active');
		us_status = '';

		// Logic to show correct buttons
		if (d.status === 'issued') {
			$('.us-opt[onclick*="presented"]').show();
			$('.us-opt[onclick*="cancelled"]').show();
		} 
		else if (d.status === 'presented') {
			$('.us-opt[onclick*="cleared"]').show();
			$('.us-opt[onclick*="bounced"]').show();
		} 
		// ✅ Handle Release Hold
		else if (d.status === 'on_hold') {
			$('#btnRelIssued').show();
			$('#btnRelUnused').show();
		}

		statusModal.show();
	});
		
		// ==============================
		// OPEN ISSUE MODAL 
		// ==============================
		
		$(document).on('click', '.openIssueModal', function () {
			const d = $(this).data();
			
			// 1. Clear existing values in the modal
			$('#issPayee').val('');
			$('#issAmt').val('');
			$('#issDate').val('');

			// 2. Trigger change and pass the selection logic as a callback
			if(d.bookid) {
				// We pass the callback as the second parameter to trigger()
				$('#issBook').val(d.bookid).trigger('change', [function() {
					// This code runs ONLY after the AJAX success above
					$('#issChqNo').val(d.id);
					
					if($('#issChqNo').val() === null) {
						// If it's not in the 'unused' list, we manually add it so it shows up
						$('#issChqNo').append(`<option value="${d.id}" selected>${d.no}</option>`);
					}
				}]);
			}

			const issueModalInstance = new bootstrap.Modal(document.getElementById('modalIssueCheque'));
			issueModalInstance.show();
		});


		// ==============================
		// SELECT STATUS
		// ==============================
		function selUsOpt(el, status){
			$('.us-opt').removeClass('active');
			$(el).addClass('active');
			us_status = status;
		}


		// ==============================
		// AJAX SUBMIT 
		// ==============================
		$('#modalUpdStatus').append('<form id="updateStatusForm"></form>');

		$('#updateStatusForm').ajax_submit({
			url : '<?= site_url("Finance/update_cheque_status"); ?>',
			rest: false,
			callback : function(){

				statusModal.hide();

				$('.modal-backdrop').remove();
				$('body').removeClass('modal-open').css('padding-right', '');

				loadCheques();

				
			}
		});


		// ==============================
		// SUBMIT FUNCTION
		// ==============================
		function doUpdateStatus(){

			if(us_id == '' || us_status == ''){
				toastr.error("Select status");
				return;
			}

			$('#updateStatusForm').html(`
				<input type="hidden" name="id" value="${us_id}">
				<input type="hidden" name="status" value="${us_status}">
				<input type="hidden" name="date" value="${$('#usDate').val()}">
				<input type="hidden" name="remarks" value="${$('#usRemarks').val()}">
			`);

			$('#updateStatusForm').submit();
		}
		
		// ==============================
		// MODAL INSTANCE
		// ==============================
		const issueModal = new bootstrap.Modal(document.getElementById('modalIssueCheque'));


		// ==============================
		// LOAD BOOKS DROPDOWN can use this code
		// ==============================
		
		function loadBooksDropdown() {
			// 1. Get the 'book' ID from the URL
			const urlParams = new URLSearchParams(window.location.search);
			const bookId = urlParams.get('book');

			$.ajax({
				url: "<?= site_url('Finance/get_books'); ?>",
				type: "GET",
				dataType: "json",
				success: function(res) {
					let opt = '<option value="">-- Select Book --</option>';

					$.each(res.data, function(i, b) {
						// 2. Check if this is the book from the URL
						let selected = (b.id == bookId) ? 'selected' : '';
						
						opt += `<option value="${b.id}" ${selected}>
							${b.cheque_book_no}
						</option>`;
					});

					$('#issBook').html(opt);
				}
			});
		}
		
		// KEEP THIS VERSION
		$('#issBook').on('change', function(e, callback) { 
			let bookId = $(this).val();
			let $chqSelect = $('#issChqNo');
			
			if (bookId == '') {
				$chqSelect.html('<option value="">-- Select --</option>');
				return;
			}

			$.ajax({
				url: "<?= site_url('Finance/get_cheques'); ?>",
				type: "GET",
				data: { book: bookId },
				dataType: "json",
				success: function(res) {
					let opt = '<option value="">-- Select --</option>';
					$.each(res.data, function(i, c) {
						if (c.status === 'unused' && c.is_hold == 0) {
							opt += `<option value="${c.id}">${c.cheque_no} (unused)</option>`;
						}
					});
					$chqSelect.html(opt);

					// Execute callback if provided (used for auto-selecting specific cheque)
					if (typeof callback === 'function') {
						callback();
					}
				}
			});
		});


		// ==============================
		// 2. TOP BUTTON LOGIC (Auto-select Book from URL)
		// ==============================
		$(document).on('click', '#btnTopIssue', function() {
			// 1. Clear previous form data
			$('#issPayee, #issAmt, #issDate').val('');
			$('#issChqNo').html('<option value="">-- Loading --</option>');

			// 2. Get Book ID from URL
			const urlParams = new URLSearchParams(window.location.search);
			const bookIdFromUrl = urlParams.get('book');

			if (bookIdFromUrl) {
				// Force set the book dropdown
				$('#issBook').val(bookIdFromUrl);

				// 3. Manually trigger the cheque loading logic
				// We call the function directly to ensure it runs
				loadUnusedCheques(bookIdFromUrl);
			} else {
				$('#issChqNo').html('<option value="">-- Select Book First --</option>');
			}
		});
		
		

		// ==============================
		// 3. TABLE ROW BUTTON LOGIC (Specific Cheque)
		// ==============================
		$(document).on('click', '.openIssueModal', function () {
			const d = $(this).data();
			
			// Reset inputs
			$('#issPayee, #issAmt, #issDate').val('');

			if(d.bookid) {
				// Step A: Set the book and trigger change
				$('#issBook').val(d.bookid).trigger('change', [function() {
					// Step B: Once AJAX finishes, select the specific cheque
					$('#issChqNo').val(d.id);
					
					// Fallback: If cheque isn't in the list (e.g. status changed), add it manually
					if($('#issChqNo').val() === null) {
						$('#issChqNo').append(`<option value="${d.id}" selected>${d.no}</option>`);
					}
				}]);
			}
			
			// Show the modal manually since we are using JS triggers
			const issueModalInstance = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalIssueCheque'));
			issueModalInstance.show();
		});

		
		// clear the form when click the close button 
		const closeBtn = document.querySelector('.close-btn');
		const form = document.getElementById('issueChequeForm');

		closeBtn.addEventListener('click', function() {
			
			form.reset();
		});


		// ==============================
		// AJAX SUBMIT 
		// ==============================
		$('#modalIssueCheque').append('<form id="issueChequeForm"></form>');

		$('#issueChequeForm').ajax_submit({
			url : '<?= site_url("Finance/update_cheque_status"); ?>', 
			rest: false,
			callback : function(){

				issueModal.hide();

				$('.modal-backdrop').remove();
				$('body').removeClass('modal-open').css('padding-right', '');

				loadCheques();

				
			}
		});
		
		$(document).on('click', '.openHoldModal', function() {
			let d = $(this).data();
			$('#hcNo').text(d.no);
			$('#hcStatus').text(d.status);
			$('#hcPayee').text(d.payee);
			$('#hcAmt').text(d.amount);
			
			// Set the hidden ID for the doHoldCheque() function
			$('#hold_chq_id').val(d.id); 
			
			// Show Modal
			new bootstrap.Modal(document.getElementById('modalHoldChq')).show();
		});
		
		// Initialization for the Hold Cheque Form
		$('#holdChequeForm').ajax_submit({
			url : '<?= site_url("Finance/update_cheque_status"); ?>', 
			rest: false,
			callback : function(res){
				
				
				// Hide Modal
				let holdModal = bootstrap.Modal.getInstance(document.getElementById('modalHoldChq'));
				if(holdModal) holdModal.hide();

				// Standard Backdrop Cleanup
				$('.modal-backdrop').remove();
				$('body').removeClass('modal-open').css('padding-right', '');

				// Refresh the table
				loadCheques();
				
				// Clear the reason field for next time
				$('#hcReason').val('');
				
				// toastr.success("Cheque put on hold successfully");
			}
		});


		// ==============================
		// SUBMIT FUNCTION
		// ==============================
		function doIssueCheque(){

			let chqId = $('#issChqNo').val();
			let payee = $('#issPayee').val();
			let amount = $('#issAmt').val();
			let date = $('#issDate').val();
			let voucher_ref = $('#voucher_ref').val();

			if(chqId == '' || payee == '' || amount == '' || date == ''){
				toastr.error("Fill all required fields");
				return;
			}

			$('#issueChequeForm').html(`
				<input type="hidden" name="id" value="${chqId}">
				<input type="hidden" name="status" value="issued">
				<input type="hidden" name="payee_name" value="${payee}">
				<input type="hidden" name="amount" value="${amount}">
				<input type="hidden" name="cheque_date" value="${date}">
				<input type="hidden" name="voucher_ref" value="${voucher_ref}">
			`);

			$('#issueChequeForm').submit();
		}
		
// New Two-Card Configuration Mapping Labels
const STATUS_LABELS = {
    'total_issued': 'Total Issued Amount',
    'total_cleared': 'Total Cleared Amount'
};

function loadAmountSummaryBar() {
    let bookId = getBookId(); 

    $.ajax({
        url: "<?= site_url('Finance/get_amount_summary'); ?>",
        type: "GET",
        data: { book: bookId },
        dataType: "json",
        success: function(amountItems) {
            renderAmountSummaryBar(amountItems);
        }
    });
}

function renderAmountSummaryBar(amountItems) {
    // Config layout mappings for the two target metrics
    var itemsConfig = {
        total_issued:  { icon: 'fa-money-check-dollar', bg: 'rgba(53, 119, 241, 0.1)',  ic: '#3577f1', sub: 'Includes Pending, Hold & Bounced' },
        total_cleared: { icon: 'fa-circle-check',       bg: 'rgba(43, 193, 123, 0.1)', ic: '#2bc17b', sub: 'Realized & cleared by bank' }
    };

    var displayItems = amountItems.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-wallet', bg: '#e2e8f0', ic: '#64748b', sub: '' };
        
        var formattedValue = 'LKR ' + parseFloat(item.total || 0).toLocaleString(undefined, {
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2
        });

        return {
            icon: cfg.icon,
            ibg: cfg.bg,
            ic: cfg.ic,
            val: formattedValue,
            lbl: STATUS_LABELS[key] || item.name,
            sub: cfg.sub,
            extra: ''
        };
    });

    // Render template loop markup matching your style structure
    var html = displayItems.map(function(item) {
        return '<div class="sb-item" style="flex: 1; min-width: 280px; max-width: 50%;">'
            + '<div class="sbi-icon" style="background:' + item.ibg + ';color:' + item.ic + '"><i class="fa-solid ' + item.icon + '"></i></div>'
            + '<div class="sbi-main">'
                + '<div class="sbi-val" style="color:' + item.ic + '; font-weight: 700; font-size: 18px;">' + item.val + '</div>'
                + '<div class="sbi-lbl" style="font-weight: 600; font-size: 14px; color: #334155;">' + item.lbl + '</div>'
                + '<div class="sbi-sub" style="font-size: 11px; color: #64748b;">' + item.sub + '</div>'
                + item.extra
            + '</div>'
        + '</div>';
    }).join('');

    $('#summary-bar').html(html);
}

// Re-trigger bar execution during core initialization checks
$(document).ready(function() {
    loadAmountSummaryBar();
});

</script>