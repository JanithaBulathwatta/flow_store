
<!-- Start::app-content -->
<div class="main-content app-content">
 <div class="container-fluid">

<style>

/* ── Search / filter bar ── */
.filter-bar{background:var(--black-soft);border:1px solid var(--input-border);border-radius:10px;padding:.7rem 1rem;}

/* ── Empty state ── */
.empty-state{text-align:center;padding:3rem 1rem;color:var(--black-normal);}
.empty-state i{font-size:2.5rem;display:block;margin-bottom:.75rem;color:var(--blue-normal);}
.empty-state p{font-size:.875rem;margin:0;}

/* ── Toast ── */
#__tb{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:7px;}
.t-item{padding:10px 15px;border-radius:var(--radius-sm);font-size:13px;font-weight:500;color:var(--white);box-shadow:var(--shadow-lg);opacity:0;transform:translateY(5px);transition:all .22s;max-width:290px;}
.t-item.success{background:var(--green-dark);}
.t-item.error{background:var(--red-dark);}

</style>

<!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
              <div>
                <h1 class="page-title fw-semibold fs-18 mb-1">Cheque Books</h1>
                <!--<span class="text-muted fs-12"><i class="ri-bank-line me-1"></i>Commercial Bank — A/C 1001-0042-5589</span>-->
              </div>
              <div class="d-flex gap-2 align-items-center flex-wrap mt-2 mt-md-0">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreateBook">
                  <i class="ri-add-line me-1"></i>New Cheque Book
                </button>
                <div class="dropdown">
                  <!--<button class="btn btn-secondary-light btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="ri-download-line me-1"></i>Export</button>-->
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item fs-13" href="#"><i class="ri-file-excel-line me-2 text-success"></i>Excel</a></li>
                    <li><a class="dropdown-item fs-13" href="#"><i class="ri-file-pdf-line me-2 text-danger"></i>PDF</a></li>
                  </ul>
                </div>
                <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="#">Finance</a></li><li class="breadcrumb-item active">Cheque Books</li></ol></nav>
              </div>
            </div>

            <!-- ── TOP STATS ROW ── -->
            <div class="row g-3 mb-4" id="bookStats"></div>

            <!-- ── SEARCH / FILTER BAR ── -->
            <div class="filter-bar mb-3 d-flex flex-wrap gap-2 align-items-center">
              <div class="input-group input-group-sm" style="max-width:240px;">
                <span class="input-group-text"><i class="ri-search-line"></i></span>
                <input type="text" class="form-control" placeholder="Search book no. or bank…" id="bkSearch">
              </div>
              <select class="form-select form-select-sm" id="bkStatusFilter" style="max-width:160px;">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="on_hold">On Hold</option>
                <!--<option value="completed">Completed</option>-->
                <!--<option value="cancelled">Cancelled</option>-->
              </select>
              <select class="form-select form-select-sm" id="bkBankFilter" style="max-width:200px;">
				<option value="">-- Select Bank --</option>
				<?php foreach($bnaks as $bank): ?>
					<option value="<?= $bank->bank_name ?>">
						<?= $bank->bank_name ?> 
					</option>
				<?php endforeach; ?>
              </select>
              <span class="ms-auto text-muted fs-12" id="bkCount"></span>
            </div>

            <!-- ── BOOKS TABLE ── -->
            <div class="card custom-card">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table chq-table mb-0">
                    <thead>
                      <tr>
                        <th>Book No.</th>
                        <th>Bank Account</th>
                        <th>Cheque Range</th>
                        <th>Leaf Count</th>
                        <th>Unused</th>
                        <th>Issued</th>
                        <th>Presented</th>
                        <th>Cleared</th>
                        <th>Bounced</th>
                        <th>Cancelled</th>
                        <th>On Hold</th>
                        <th>Usage</th>
                        <th>Status</th>
                        <th>Issue Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="bkTbody"></tbody>
                  </table>
                </div>
              </div>
            </div>

			
			<div class="modal fade" id="modalCreateBook" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<form id="chequeBookForm">
							<div class="modal-header">
								<h6 class="modal-title fw-semibold">
									<i class="ri-add-circle-line me-2 text-primary"></i>Create New Cheque Book
								</h6>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
							</div>
							<div class="modal-body">
								

								<div class="row g-3">
									<div class="col-12">
										<label class="form-label fw-medium fs-13">Bank Account <span class="text-danger">*</span></label>
										<select class="form-select" name="bank_account_id" id="cb_bank_id" required>
											<option value="">-- Select Account --</option>
												<?php foreach($banks_Ac as $acc): ?>
													<option value="<?= $acc->bank_acc_id ?>">
														<?= $acc->bank_name ?> — A/C <?= $acc->account_number ?>
													</option>
												<?php endforeach; ?>
										</select>
									</div>
									<div class="col-sm-6">
										<label class="form-label fw-medium fs-13">Book No. <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="cheque_book_no" id="cbNo" placeholder="e.g. CB-2026-007" required>
									</div>
									<div class="col-sm-6">
										<label class="form-label fw-medium fs-13">Issue Date</label>
										<input type="date" class="form-control" name="issue_date" id="cbIssDate" value="<?= date('Y-m-d'); ?>">
									</div>
									<div class="col-sm-6">
										<label class="form-label fw-medium fs-13">Start No. <span class="text-danger">*</span></label>
										<input type="number" class="form-control" name="start_cheque_no" id="cbStart" placeholder="e.g. 701" required>
									</div>
									<div class="col-sm-6">
										<label class="form-label fw-medium fs-13">End No. <span class="text-danger">*</span></label>
										<input type="number" class="form-control" name="end_cheque_no" id="cbEnd" placeholder="e.g. 750" required>
									</div>
									<div class="col-sm-6">
										<label class="form-label fw-medium fs-13">Received Date</label>
										<input type="date" class="form-control" name="received_date">
									</div>
									<div class="col-sm-6">
										<label class="form-label fw-medium fs-13">Total Leaf</label>
										<input type="text" class="form-control bg-light" id="cbLeaves" readonly value="0">
									</div>
									<div class="col-12">
										<div class="alert alert-primary-transparent py-2 fs-12 mb-0" id="cbLeavesInfo">
											<i class="ri-information-line me-1"></i>Enter start <span id ="start"></span> &amp; <span id ="end"></span> end numbers. All cheque records will be auto-generated.
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
								<button type="submit" id="btn-sub-book" class="btn btn-primary btn-sm">
									<i class="ri-check-line me-1"></i>Create &amp; Generate Cheques
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>

            <!-- ── MODAL: Hold Book ── -->
           
			<div class="modal fade" id="modalHoldBk" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<form id="holdBookForm"> <div class="modal-header">
								<h6 class="modal-title fw-semibold text-warning"><i class="ri-lock-line me-2"></i>Hold Cheque Book</h6>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
							</div>
							<div class="modal-body">
								<input type="hidden" name="book_id" id="hold_bk_id">
								
								<div class="alert alert-warning-transparent py-2 fs-12 mb-3">
									<i class="ri-error-warning-line me-1"></i>This will <strong>block all unused cheques</strong>. Already-issued cheques remain unaffected.
								</div>
								
								<div class="mb-3 fs-13">
									Book: <strong id="hbkRef">—</strong> &nbsp; 
									Range: <span class="badge bg-light text-dark" id="hbkRange">—</span>
								</div>

								<div class="mb-3">
									<label class="form-label fw-medium fs-13">Reason <span class="text-danger">*</span></label>
									<textarea class="form-control" name="reason" rows="3" id="hbkReason" placeholder="Enter reason for holding..." required></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-warning btn-sm">
									<i class="ri-lock-line me-1"></i>Confirm Hold
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="modalReleaseBk" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<form id="releaseBookForm">
							<div class="modal-header">
								<h6 class="modal-title fw-semibold text-success"><i class="ri-lock-unlock-line me-2"></i>Release Cheque Book</h6>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
							</div>
							<div class="modal-body">
								<input type="hidden" name="book_id" id="rel_bk_id">
								<div class="alert alert-info-transparent py-2 fs-12 mb-3">
									<i class="ri-information-line me-1"></i>This will make all currently held cheques <strong>Unused</strong> and available.
								</div>
								<div class="mb-3">
									<label class="form-label fw-medium fs-13">Release Reason <span class="text-danger">*</span></label>
									<textarea class="form-control" name="reason" rows="3" required placeholder="Why is this book being released?"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-success btn-sm">Confirm Release</button>
							</div>
						</form>
					</div>
				</div>
			</div>

          </div>
        </div><!-- End::app-content -->
		
		<!-- selease the book in hold -->
		<form id="statusUpdateForm" style="display:none;">
			<input type="hidden" name="book_id" id="status_book_id">
		</form>



<script>

$(document).ready(function(){
    loadBooks();
});


// 1. Function to trigger the Modal from your table button
$(document).on('click', '.btnHoldBook', function() {
    let id = $(this).data('id');
    let ref = $(this).data('ref');
    let range = $(this).data('range');

    $('#hold_bk_id').val(id);
    $('#hbkRef').text(ref);
    $('#hbkRange').text(range);
    
    new bootstrap.Modal(document.getElementById('modalHoldBk')).show();
});


//  Submit Logic
$('#holdBookForm').ajax_submit({
    url : '<?= site_url("Finance/hold_book_action"); ?>',
    rest: false,
    callback : function(res){
        // Hide Modal
        bootstrap.Modal.getInstance(document.getElementById('modalHoldBk')).hide();

        // Standard Backdrop Cleanup
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');

        // Refresh Data
        loadBooks();
        
    }
});	


/*$(document).on('click', '.btnReleaseBook', function() {
    let bookId = $(this).data('id');
    let bookRef = $(this).data('ref');
	
	$('#status_book_id').val(bookId);    
    $('#statusUpdateForm').submit();

});*/


$('#statusUpdateForm').ajax_submit({
    url : '<?= site_url("Finance/release_book_action"); ?>',
    rest: false,
    callback : function(res){
        // Standard Backdrop Cleanup (just in case)
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');

        // Refresh Data
        if (typeof loadBooks === "function") {
            loadBooks(); 
        }
        
        
    }
});



//  Define the Modal Instance
const bookFormModal = new bootstrap.Modal(document.getElementById('modalCreateBook'));

//  Submit Cheque Book for Save 
$('#chequeBookForm').ajax_submit({
    url : '<?= site_url("Finance/store_book"); ?>', 
    rest: false,
    callback : function(res){
        // Reset Form
        $('#chequeBookForm')[0].reset();
        $('#cbLeaves').val(0);
        
        // Hide Modal
        bookFormModal.hide(); 

        // FORCE REMOVE the dark backdrop 
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');

        // Refresh Data
        loadBooks(); 
        
    }
});


// 1. Trigger Release Modal
$(document).on('click', '.btnReleaseBook', function() {
    $('#rel_bk_id').val($(this).data('id'));
    new bootstrap.Modal(document.getElementById('modalReleaseBk')).show();
});

// 2. Handle Release AJAX
$('#releaseBookForm').ajax_submit({
    url : '<?= site_url("Finance/release_book_action"); ?>',
    rest: false,
    callback : function(res){
        bootstrap.Modal.getInstance(document.getElementById('modalReleaseBk')).hide();
        loadBooks();
    }
});

// 3. JS Validations for New Cheque Book
$(document).on('input', '#cbStart, #cbEnd', function() {
    let start = parseInt($('#cbStart').val()) || 0;
    let end = parseInt($('#cbEnd').val()) || 0;
    
    // Prevent Negatives
    if(start < 0) { start = 0; $('#cbStart').val(0); }
    if(end < 0) { end = 0; $('#cbEnd').val(0); }

    let total = (end >= start && start > 0) ? (end - start) + 1 : 0;
    $('#cbLeaves').val(total);

    // --- New Range Order Logic ---
    let isRangeInvalid = (start > 0 && end > 0 && start >= end);

    // Leaf limit and Range validation
    if (total > 200) {
        $('#cbLeavesInfo').removeClass('alert-primary-transparent').addClass('alert-danger-transparent');
        $('#cbLeavesInfo').html('<i class="ri-error-warning-line"></i> Error: Max leaf limit is 200.');
        $('#btn-sub-book').prop('disabled', true);
    } 
    else if (isRangeInvalid) {
        // QA Fix: Force Start < End
        $('#cbLeavesInfo').removeClass('alert-primary-transparent').addClass('alert-danger-transparent');
        $('#cbLeavesInfo').html('<i class="ri-error-warning-line"></i> Error: Start No. must be less than End No.');
        $('#btn-sub-book').prop('disabled', true);
        $('#cbLeaves').val(0); // Reset leaf count display as range is logical error
    }
    else {
        // Valid State
        $('#cbLeavesInfo').addClass('alert-primary-transparent').removeClass('alert-danger-transparent');
        $('#cbLeavesInfo').html('<i class="ri-information-line"></i> Enter range. All records auto-generated.');
        
        // Enable button only if both fields have values and are valid
        if(start > 0 && end > 0 && end > start) {
            $('#btn-sub-book').prop('disabled', false);
        } else {
            $('#btn-sub-book').prop('disabled', true);
        }
    }
});

//  Auto-calculate Leaves while typing
$(document).on('input', '#cbStart, #cbEnd', function() {
    let start = parseInt($('#cbStart').val()) || 0;
    let end = parseInt($('#cbEnd').val()) || 0;
	
	$('#start').text(start);
	$('#end').text(end);
	
    let total = (end >= start && start > 0) ? (end - start) + 1 : 0;
    $('#cbLeaves').val(total);
});

//  Open Modal for "Add New"
$('#btnAddBook').click(function () {
    $('#chequeBookForm')[0].reset();
    $('#cb_lid').val(''); 
    $('#cbLeaves').val(0);
    bookFormModal.show();
});

// ── Render books table ───────────────────────────────────────────────────────
function loadBooks() {
    let search = $('#bkSearch').val();
    let status = $('#bkStatusFilter').val();
    let bank   = $('#bkBankFilter').val();
        
    $.ajax({
        url: "/Finance/get_books",
        type: "GET",
        dataType: "json",
        success: function(res) {
            let tbody = '';
            let data = res.data || [];
            
            let filtered = data.filter(function(b) {
                return (
                    (!search || 
                        (b.cheque_book_no?.toLowerCase().includes(search.toLowerCase()) ||
                         b.bank_name?.toLowerCase().includes(search.toLowerCase()) ||
                         b.account_number?.toLowerCase().includes(search.toLowerCase()))
                    )
                    &&
                    (!status || b.status === status)
                    &&
                    (!bank || b.bank_name === bank)
                );
            });

            if (filtered.length > 0) {
                $.each(filtered, function(i, b) {
                    
                    let actionBtn = '';
                    let statusHtml = '';
                    let colorClass = '';

                    // ✅ QA FIX: Dynamic Status Colors & Hover Title
                    switch(b.status) {
                        case 'active':    colorClass = 'success'; break;
                        case 'on_hold':   colorClass = 'warning'; break;
                        case 'completed': colorClass = 'primary'; break;
                        case 'cancelled': colorClass = 'danger'; break;
                        default:          colorClass = 'secondary';
                    }

                    // Tooltip shows the hold reason if it exists
                    let holdTooltip = b.hold_reason ? `title="Reason: ${b.hold_reason}"` : `title="${b.status}"`;
                    
                    statusHtml = `<span class="badge bg-${colorClass}-transparent text-${colorClass} text-uppercase px-2 py-1" 
                                    style="font-size: 10px; cursor: help;" ${holdTooltip}>
                                    ${b.status.replace('_', ' ')}
                                  </span>`;

                    // ✅ QA FIX: Action Buttons logic
                    if (b.status === 'on_hold') {
                        actionBtn = `
                            <button class="btn btn-sm btn-icon btn-success-light btnReleaseBook" 
                                    data-id="${b.id}" 
                                    data-ref="${b.cheque_book_no}" 
                                    title="Release Book">
                                <i class="ri-lock-unlock-line"></i>
                            </button>`;
                    } else if (b.status !== 'completed') {
                        // Only show Hold button if the book isn't already completed
                        actionBtn = `
                            <button class="btn btn-sm btn-icon btn-warning-light btnHoldBook" 
                                    data-id="${b.id}" 
                                    data-ref="${b.cheque_book_no}" 
                                    data-range="${b.start_cheque_no} - ${b.end_cheque_no}"
                                    title="Hold Book">
                                <i class="ri-lock-line"></i>
                            </button>`;
                    }

                    let used = b.total_leaves - b.unused;
                    let percent = Math.round((used / b.total_leaves) * 100);

                    tbody += `
                    <tr>
                        <td><strong>${b.cheque_book_no}</strong></td>

                        <td>
                            ${b.bank_name}<br>
                            <small class="text-muted">${b.account_number}</small>
                        </td>

                        <td class="fs-12">${b.start_cheque_no} - ${b.end_cheque_no}</td>

                        <td class="text-center fw-medium">${b.total_leaves}</td>

                        <td class="text-center text-muted">${b.unused || 0}</td>
                        <td class="text-center">${b.issued || 0}</td>
                        <td class="text-center">${b.presented || 0}</td>
                        <td class="text-center text-success">${b.cleared || 0}</td>
                        <td class="text-center text-danger">${b.bounced || 0}</td>
                        <td class="text-center text-warning">${b.cancelled || 0}</td>

                        <td class="text-center">${b.hold_count || 0}</td>

                        <td>
                            <div class="progress progress-xs mb-1" style="width:80px; height:6px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: ${percent}%"></div>
                            </div>
                            <small class="text-muted">${percent}% Used</small>
                        </td>

                        <td class="text-center">
                            ${statusHtml}
                        </td>

                        <td class="fs-11">${b.issue_date ?? '-'}</td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= site_url('Finance/cheque_list'); ?>?book=${b.id}" 
                                   class="btn btn-sm btn-icon btn-info-light" title="View Cheques">
                                    <i class="ri-eye-line"></i>
                                </a>
                                ${actionBtn}
                            </div>
                        </td>
                    </tr>`;
                });

            } else {
                tbody = `<tr><td colspan="15" class="text-center py-4">No cheque books found</td></tr>`;
            }

            $('#bkTbody').html(tbody);
        }
    });
}
	// Trigger filtering on input/change
		
	$('#bkSearch').on('input', loadBooks);
    $('#bkStatusFilter').on('change', loadBooks);
    $('#bkBankFilter').on('change', loadBooks);



	// Auto-calculate leaves in the Modal
	$('#start_cheque_no, #end_cheque_no').on('input', function() {
		let start = parseInt($('#start_cheque_no').val()) || 0;
		let end = parseInt($('#end_cheque_no').val()) || 0;
		if (end >= start && start > 0) {
			$('#total_leaves_display').val((end - start) + 1);
		} else {
			$('#total_leaves_display').val(0);
		}
	});

	
	// clear the form when click the close button 
	const closeBtn = document.querySelector('.close-btn');
	const form = document.getElementById('chequeBookForm');

	closeBtn.addEventListener('click', function() {
		
		form.reset();
	});
	
 



</script>