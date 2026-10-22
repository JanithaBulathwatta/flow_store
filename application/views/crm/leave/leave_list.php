<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-12 mt-3">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body"> 
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                            <div class="d-flex align-items-center"> 
                                <span class="card-title me-6">Leave Management</span>
                                
                                <div class="d-flex gap-2 flex-wrap" id="leave-status-container"> 
                                    <!-- Status counts will be loaded here -->
                                </div>
                            </div> 
                            
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-add" id="btnAddLeaveRequest">
                                    <i class="ri-add-line me-1 fw-medium align-middle"></i> Request New
                                </button>
                            </div> 
                        </div> 
                    </div>
					
					<div class="summary-bar" id="summary-bar"></div>
					
                </div>
            </div>
        
            <div class="col-xl-12">
                <form id="data-filter">
                    <div class="card mb-3">
                        <div class="card-body row g-3">
                            <div class="col-md-2">
                                <label class="form-label mb-1">Date Range</label>
                                <input type="text" class="date-range-input daterangepicker-field form-control-sm" 
                                       placeholder="Select Date Range" 
                                       data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" />
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label mb-1">Employee</label>
                                <select class="form-select js-example-basic-single form-select-sm" id="employeeFilter">
                                    <option value="">-- All Employees --</option>
                                    <?php foreach ($employees as $emp): ?>
                                        <option value="<?= $emp->id; ?>"><?= html_escape($emp->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                    <label class="form-label mb-1">Branch</label>
                    <select class="form-select js-example-basic-single form-select-sm" id="branchFilter">
                        <option value="">-- All Branches --</option>
                        <?php foreach ($branches as $branch): ?>
                            <option value="<?= $branch->branch_id; ?>"><?= html_escape($branch->branch_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Status</label>
                                <select class="form-select form-select-sm js-example-basic-single" id="statusFilter" class="form-select form-select-sm">
									<option value="">-- All Status --</option>
									<option value="request">Pending</option>
									<option value="approved">Approved</option>
									<option value="rejected">Rejected</option>
								</select>
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label mb-1">Leave Type</label>
                                <select class="form-select form-select-sm js-example-basic-single"id="leaveTypeFilter" class="form-select form-select-sm">
                                    <option value="">-- All Types --</option>
                                    <?php foreach ($leave_types as $type): ?>
                                        <option value="<?= $type->leave_type_id; ?>">
                                            <?= html_escape($type->leave_type_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-search w-100 mb-1 mt-4" id="searchBtn">
                                     Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
            <div class="col-xl-12">
    <div class="card custom-card">
        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center py-2"> <!-- Reduced padding -->
            <div class="card-title">Leave Requests</div>
        </div>

        <!-- BODY -->
        <div class="card-body p-2"> <!-- Reduced padding -->
            <div class="table-responsive">
                <table id="leaveTable" class="table table-sm  w-100 mb-0"> <!-- Added table-sm for compact -->
                    <thead class="compact-header">
                        <tr>
                            <th class="text-center" style="width: 3%">#</th>
                            <th style="width: 8%">Employee</th>
                            <th style="width: 6%">Branch</th>
                            <th style="width: 7%">Leave Type</th>
                            <th style="width: 6%">Start</th>
                            <th style="width: 6%">End</th>
                            <th class="text-center" style="width: 4%">Days</th>
                            <th style="width: 10%">Reason</th>
                            <th class="text-center" style="width: 6%">Status</th>
                            <th style="width: 8%">Approved By</th>
                            <th style="width: 6%">App Date</th>
                            <th class="text-center" style="width: 4%">Attach</th>
                            <th style="width: 6%">Req Date</th>
                            <th class="text-center" style="width: 8%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<!-- Leave Request Modal -->
<div class="modal fade" id="leaveRequestModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="leaveRequestForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title" id="leaveModalTitle">New Leave Request</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="leave_request_id" name="leave_request_id">

                    <div class="row gy-3">
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Employee *</label>
                            <select name="employee_id" id="employee_id" class="form-control form-select-sm" required>
                                <option value="">-- Select Employee --</option>
                                <?php foreach ($employees as $emp): ?>
                                    <option value="<?= $emp->id; ?>"><?= html_escape($emp->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-control form-select-sm">
                                <option value="">-- Select Branch --</option>
                                <?php foreach ($branches as $branch): ?>
                                    <option value="<?= $branch->branch_id; ?>"><?= html_escape($branch->branch_name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Leave Type *</label>
                            <select name="leave_type_id" id="leave_type_id" class="form-control form-select-sm" required>
                                <option value="">-- Select Leave Type --</option>
                                <?php foreach ($leave_types as $type): ?>
                                    <option value="<?= $type->leave_type_id; ?>">
                                        <?= html_escape($type->leave_type_name); ?> 
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Start Date *</label>
                            <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">End Date *</label>
                            <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Total Days *</label>
                            <input type="number" step="0.5" name="total_days" id="total_days" class="form-control form-control-sm" readonly required>
                        </div>

                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Reason *</label>
                            <textarea name="reason" id="reason" class="form-control form-control-sm" rows="3" required></textarea>
                        </div>

                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Attachment (if any)</label>
                            <input type="file" name="attachment" id="attachment" class="form-control form-control-sm">
                            <small class="text-muted">Allowed: jpg, jpeg, png, pdf, doc, docx (Max: 2MB)</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub">
                        <i class="ri-save-line me-1"></i> Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="attachmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header">
                <h6 class="modal-title">Attachment Preview</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <div id="attachmentModalContent"></div>
            </div>

        </div>
    </div>
</div>
<!-- View/Approve Modal -->
<div class="modal fade" id="viewRequestModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Leave Request Details</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="modal-body">
    <div class="table-responsive">
        <table class="table table-bordered table-sm mb-0">
            <tbody>
                <tr>
                    <th style="width: 30%">Employee</th>
                    <td id="view_employee"></td>
                </tr>
                <tr>
                    <th>Branch</th>
                    <td id="view_branch"></td>
                </tr>
                <tr>
                    <th>Leave Type</th>
                    <td id="view_leave_type"></td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td id="view_start_date"></td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td id="view_end_date"></td>
                </tr>
                <tr>
                    <th>Total Days</th>
                    <td id="view_total_days"></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><span id="view_status" class="badge"></span></td>
                </tr>
                <tr>
                    <th>Reason</th>
                    <td id="view_reason"></td>
                </tr>
                <tr>
					<th>Attachment</th>
					<td id="view_attachment"></td>
				</tr>
				<tr id="attachment_preview_row" style="display:none;">
					<th>Preview</th>
					<td>
						<div id="attachment_preview_container"></div>
					</td>
				</tr>	
                <tr>
                    <th>Request Date</th>
                    <td id="view_created_at"></td>
                </tr>
                <tr>
                    <th>Approved By</th>
                    <td id="view_approved_by"></td>
                </tr>
                <tr>
                    <th>Approval Comment</th>
                    <td id="view_approval_comment"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
                   <!-- <div class="col-md-6">
                        <p><strong>Reason:</strong> <span id="view_reason"></span></p>
                        <p><strong>Status:</strong> <span id="view_status" class="badge"></span></p>
                        <p><strong>Attachment:</strong> <span id="view_attachment"></span></p>
                        <p><strong>Request Date:</strong> <span id="view_created_at"></span></p>
                        <p><strong>Approved By:</strong> <span id="view_approved_by"></span></p>
                        <p><strong>Approval Comment:</strong> <span id="view_approval_comment"></span></p>
                    </div>-->
                </div>
            </div>
            <div class="modal-footer" id="approval_actions" style="display: none;">
                <input type="hidden" id="current_request_id">
                <textarea id="approval_comment" class="form-control mb-2" placeholder="Approval/Rejection comment..."></textarea>
                <button type="button" class="btn btn-success" onclick="updateStatus('approved')">
                    <i class="ri-check-line"></i> Approve
                </button>
                <button type="button" class="btn btn-danger" onclick="updateStatus('rejected')">
                    <i class="ri-close-line"></i> Reject
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    
    var table = initializeDataTable('#leaveTable');
    const formModal = new bootstrap.Modal(document.getElementById('leaveRequestModal'));
    const viewModal = new bootstrap.Modal(document.getElementById('viewRequestModal'));

    // Calculate total days automatically
    $('#start_date, #end_date').change(function() {
        let start = $('#start_date').val();
        let end = $('#end_date').val();
        
        if (start && end) {
            let startDate = new Date(start);
            let endDate = new Date(end);
            let diffTime = Math.abs(endDate - startDate);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            $('#total_days').val(diffDays);
        }
    });

    loadLeaveCounts();
    filter();
    $(document).on('click', '.btnApproveRequest', function () {

    let id = $(this).data('id');

    $('#current_request_id').val(id);

    // Clear old comment
    $('#approval_comment').val('');

    // Show approval buttons
    $('#approval_actions').show();

    // Load request details
    $.getJSON("/HRM/view?lid=" + id, function (res) {

        let request = res.request;

        $('#view_employee').text(request.employee_name);
        $('#view_branch').text(request.branch_name || '-');
        $('#view_leave_type').text(request.leave_type_name);
        $('#view_start_date').text(request.start_date);
        $('#view_end_date').text(request.end_date);
        $('#view_total_days').text(request.total_days);
        $('#view_reason').text(request.reason);

        viewModal.show();

    });

});
const attachmentModal = new bootstrap.Modal(document.getElementById('attachmentModal'));

$(document).on('click', '.btnPreviewAttachment', function () {

    let fileName = $(this).data('file');
    let fileUrl = "/uploads/leave_attachments/" + fileName;
    let extension = fileName.split('.').pop().toLowerCase();

    let previewHtml = '';

    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
        previewHtml = `<img src="${fileUrl}" class="img-fluid rounded shadow" style="max-height:500px;">`;
    } 
    else if (extension === 'pdf') {
        previewHtml = `<iframe src="${fileUrl}" width="100%" height="500px" style="border:none;"></iframe>`;
    } 
    else {
        previewHtml = `
            <p class="mb-2">Preview not available</p>
            <a href="${fileUrl}" class="btn btn-primary btn-sm" download>
                Download File
            </a>`;
    }

    $('#attachmentModalContent').html(previewHtml);

    attachmentModal.show();
});
    // Load leave counts by status
    /*function loadLeaveCounts() {

    $.ajax({
        url: "/HRM/get_leave_counts_ajax",
        type: "GET",
        dataType: "json",
        success: function(response) {

            console.log("Counts response:", response); // debug

            let html = '';

            response.forEach(function(status) {

                let dbStatus = '';

                if (status.name === 'Pending') dbStatus = 'request';
                if (status.name === 'Approved') dbStatus = 'approved';
                if (status.name === 'Rejected') dbStatus = 'rejected';

                let bgClass = status.name === 'Pending' ? 'bg-warning' :
                              status.name === 'Approved' ? 'bg-success' :
                              status.name === 'Rejected' ? 'bg-danger' :
                              'bg-secondary';

                html += `
                <div class="mini-card ${bgClass} text-white px-3 py-1 rounded status-filter"
                     data-status="${dbStatus}"
                     style="cursor:pointer">

                     ${status.total} ${status.name}

                </div>`;
            });

            $('#leave-status-container').html(html);
        }
    });
}*/

/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadLeaveCounts() {
    $.ajax({
        url: "/HRM/get_leave_counts_ajax",
        type: "GET",
        dataType: "json",
        success: function(res) {

            console.log(res);

           
            // Storing the original array response
            GRN_ITEMS = res;
            
            // Dynamic mappings based on your design style
            GRN_ITEMS.forEach(function(item) {
                var key = (item.name || '').toLowerCase();

                // STATUS LABELS (e.g., "settled" -> "Settled")
                if (!STATUS_LABELS[key]) {
                    STATUS_LABELS[key] = item.name.split('_')[0] + ' count';
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
    var totalGrns = GRN_ITEMS.reduce(function(acc, item) { return acc + parseInt(item.total || 0); }, 0);
    
    // Mapping config for display panels
    var itemsConfig = {
        approved:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'approved Leaves ' },
        pending:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'pending Leaves' },
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
        rejected: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'rejected Leaves ' },
       
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Leaves ' };
		

        return {
            icon: cfg.icon,
            ibg: cfg.bg,
            ic: cfg.ic,
            val: item.total,
            lbl: STATUS_LABELS[key] || item.name,
            sub: cfg.sub,
            extra: ''
        };
    });

    // Automatically inject a "Total" card at the front of the summary bar array
    /*displayItems.unshift({
        icon: 'fa-boxes-stacked',
        ibg: '#e0f2fe',
        ic: '#0369a1',
        val: totalGrns,
        lbl: 'Total Sub Catagory Records',
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
                + item.extra
            + '</div>'
        + '</div>';
    }).join('');

    // Target element to render the dynamic markup
    $('#summary-bar').html(html);
}



   $(document).on('click', '.status-filter', function () {

    let status = $(this).attr('data-status');

    console.log("Clicked Status:", status);

    $('#statusFilter').val(status);

    filter();

});
    // Submit form
   // Submit form - Fixed to ensure modal closes
$('#leaveRequestForm').on('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);
    
    $.ajax({
        url: '/HRM/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                toastr.success('Leave request submitted successfully');
                $('#leaveRequestForm')[0].reset();
                filter();
                loadLeaveCounts();
                
                // Force close modal
                $('#leaveRequestModal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('overflow', 'auto');
                
                formModal.hide();
            } else {
                toastr.error(response.message || 'Error submitting request');
            }
        },
        error: function(xhr, status, error) {
            toastr.error('AJAX Error: ' + error);
            console.error(xhr.responseText);
        }
    });
});

    // Add new request button
    $('#btnAddLeaveRequest').click(function () {
        $('#leaveModalTitle').text('New Leave Request');
        $('#btn-sub').text('Submit Request');
        $('#leaveRequestForm')[0].reset();
        $('#leave_request_id').val('');
        formModal.show();
    });

    // View request details (with approve/reject buttons)
    $(document).on('click', '.btnViewRequest', function () {
        let id = $(this).data('id');
        
        $.getJSON("/HRM/view?lid=" + id, function (res) {
            let request = res.request;
            
            $('#view_employee').text(request.employee_name);
            $('#view_branch').text(request.branch_name || '-');
            $('#view_leave_type').text(request.leave_type_name);
            $('#view_start_date').text(request.start_date);
            $('#view_end_date').text(request.end_date);
            $('#view_total_days').text(request.total_days);
            $('#view_reason').text(request.reason);
            
            // Fix: Map database status to display text
            let statusDisplay = request.status === 'request' ? 'PENDING' :
                               request.status === 'approved' ? 'APPROVED' :
                               request.status === 'rejected' ? 'REJECTED' : request.status.toUpperCase();
            
            let statusBadge = $('#view_status');
            statusBadge.text(statusDisplay);
            statusBadge.removeClass().addClass('badge');
            
            // Fix: Use 'request' instead of 'pending' for styling
            if(request.status === 'request') statusBadge.addClass('bg-warning');
            else if(request.status === 'approved') statusBadge.addClass('bg-success');
            else if(request.status === 'rejected') statusBadge.addClass('bg-danger');
            else statusBadge.addClass('bg-secondary');
            
				   if (request.attachment) {
  
			let fileUrl = "/uploads/leave_attachments/" + request.attachment;
			let extension = request.attachment.split('.').pop().toLowerCase();

			$('#view_attachment').html(`
    <button type="button" class="btn btn-sm btn-icon btn-info-light" id="btnPreviewAttachment" title="View Attachment">
        <i class="ri-eye-line"></i>
    </button>
`);

			$('#attachment_preview_row').hide();
			$('#attachment_preview_container').html('');

			$(document).off('click', '#btnPreviewAttachment').on('click', '#btnPreviewAttachment', function () {

				let previewHtml = '';

				if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
					previewHtml = `<img src="${fileUrl}" class="img-fluid rounded border" style="max-height:400px;">`;
				} 
				else if (extension === 'pdf') {
					previewHtml = `
						<iframe src="${fileUrl}" width="100%" height="500px" style="border:none;"></iframe>
					`;
				} 
				else {
					previewHtml = `
						<a href="${fileUrl}" class="btn btn-info btn-sm" download>
							Download File
						</a>
					`;
				}

				$('#attachment_preview_container').html(previewHtml);
				$('#attachment_preview_row').show();
			});

		} else {
			$('#view_attachment').text('-');
			$('#attachment_preview_row').hide();
		}
            
            $('#view_created_at').text(request.created_at);
            $('#view_approved_by').text(request.approver_name || '-');
            $('#view_approval_comment').text(request.approval_comment || '-');
            
            $('#current_request_id').val(id);
            
            // Fix: Show approval buttons only for 'request' status (pending)
            if(request.status === 'request') {
                $('#approval_actions').show();
            } else {
                $('#approval_actions').hide();
            }
            
            viewModal.show();
        });
    });

    // Filter form submit
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });

    // Delete request
    $(document).on('click', '.leave-delete', function () {            
        const id = $(this).data('id');
        deleteRequest(this, id);
    });

    function deleteRequest(el, id) {
        $(el).del_modal({
            title: 'Delete',
            head: 'Delete Leave Request',
            para: 'Do you want to delete this request?',
            id: id,
            url: '/HRM/delete?lid=' + id,
            callback: function () {
                filter();
                loadLeaveCounts();
            }
        });
    }
    
    function filter() {
    if ($.fn.DataTable.isDataTable('#leaveTable')) {
        $('#leaveTable').DataTable().destroy();
    }

    $.ajax({
        url: "/HRM/filter",
        type: "POST",
        data: {
            date: $('.date-range-input').val(),
            employee_id: $('#employeeFilter').val(),
			branch_id: $('#branchFilter').val(),
            status: $('#statusFilter').val(),
            leave_type_id: $('#leaveTypeFilter').val()
        },
        dataType: "json",
        success: function (res) {
            let tbody = '';

            if (res.data.length > 0) {
                $.each(res.data, function (i, req) {
                    
                    // Map database status to display text and CSS class
                    let statusDisplay = req.status === 'request' ? 'PENDING' :
                                       req.status === 'approved' ? 'APPROVED' :
                                       req.status === 'rejected' ? 'REJECTED' : req.status;
                    
                    let statusClass = req.status === 'request' ? 'bg-warning' :
                                     req.status === 'approved' ? 'bg-success' :
                                     req.status === 'rejected' ? 'bg-danger' : 'bg-secondary';
                    
                    let attachmentIcon = req.attachment ? 
    `<button class="btn btn-sm btn-info btn-icon-sm btnPreviewAttachment"
        data-file="${req.attachment}">
        <i class="ri-file-line"></i>
    </button>` : '-';

      let actionBtns = '';

// Style exactly like leads module
if (req.status === 'request') {
    actionBtns = `
        
        <button class="btn btn-sm btn-icon btn-success-light btnApproveRequest" data-id="${req.leave_request_id}" title="Approve/Reject">
            <i class="ri-check-line"></i>
        </button>`;
} else {
    // For approved/rejected requests, show only View button
    actionBtns = `
        <button class="btn btn-sm btn-icon btn-info-light btnViewRequest" data-id="${req.leave_request_id}" title="View Details">
            <i class="ri-eye-line"></i>
        </button>`;
}
                    tbody += `
                        <tr>
                            <td class="text-right">${req.leave_request_id}</td>
                            <td><span class="employee-name" title="${req.employee_name || ''}">${req.employee_name || '-'}</span></td>
                            <td><span title="${req.branch_name || ''}">${req.branch_name || '-'}</span></td>
                            <td><span title="${req.leave_type_name || ''}">${req.leave_type_name || '-'}</span></td>
                            <td><span class="date-small">${req.start_date || '-'}</span></td>
                            <td><span class="date-small">${req.end_date || '-'}</span></td>
                            <td ><span class="date-small">${req.total_days || 0}</span></td>
                            <td><span class="reason-cell" title="${req.reason || ''}">${req.reason ? req.reason.substring(0, 25) + (req.reason.length > 25 ? '...' : '') : '-'}</span></td>
                            <td class="text-right "><span class="badge ${statusClass} badge-compact">${statusDisplay}</span></td>
                            <td><span class="employee-name" title="${req.approver_name || ''}">${req.approver_name || '-'}</span></td>
                            <td><span class="date-small">${req.updated_at ? req.updated_at.split(' ')[0] : '-'}</span></td>
                            <td class="text-right">${attachmentIcon}</td>
                            <td><span class="date-small">${req.created_at ? req.created_at.split(' ')[0] : '-'}</span></td>
                            <td class="text-right">
                                <div class="btn-group" role="group" style="gap: 5px;">
                                    ${actionBtns}
                                </div>
                            </td>
                        </tr>`;
                });
            } else {
                tbody = `<tr>
                            <td colspan="14" class="text-center text-muted">
                                No leave requests found
                            </td>
                         </tr>`;
            }

            $('#leaveTable tbody').html(tbody);
            table = initializeDataTable('#leaveTable');
        }
    });
}
    // Edit request
    $(document).on('click', '.btnEditRequest', function () {
        let id = $(this).data('id');
        
        $('#leaveModalTitle').text('Edit Leave Request');
        $('#btn-sub').text('Update Request');
        $('#leave_request_id').val(id);
        
        $.getJSON("/HRM/view?lid=" + id, function (res) {
            let request = res.request;
            
            $('#employee_id').val(request.employee_id);
            $('#branch_id').val(request.branch_id);
            $('#leave_type_id').val(request.leave_type_id);
            $('#start_date').val(request.start_date);
            $('#end_date').val(request.end_date);
            $('#total_days').val(request.total_days);
            $('#reason').val(request.reason);
        });
        
        formModal.show();
    });
});

// Update status (approve/reject)
function updateStatus(status) {

    let id = $('#current_request_id').val();
    let comment = $('#approval_comment').val();

    $.ajax({

        url: "/HRM/update_status",
        type: "POST",

        data: {
            id: id,
            status: status,
            comment: comment
        },

        dataType: "json",

        success: function(res){

            if(res.success){

                toastr.success("Leave request " + status);

                $('#viewRequestModal').modal('hide');

                location.reload(); // easiest safe refresh

            }else{

                toastr.error("Error updating status");

            }

        }

    });

}

function initializeDataTable(selector) {
    if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().destroy();
    }
    
    return $(selector).DataTable({
        "pageLength": 25,
        "ordering": true,
        "responsive": false,
        "scrollX": false,
        "scrollY": false,
        "autoWidth": true,
        "pagingType": "simple_numbers", // More compact pagination
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        "columnDefs": [
            { "width": "3%", "targets": 0, "className": "text-center" },
            { "width": "8%", "targets": 1 },
            { "width": "6%", "targets": 2 },
            { "width": "7%", "targets": 3 },
            { "width": "6%", "targets": 4 },
            { "width": "6%", "targets": 5 },
            { "width": "4%", "targets": 6, "className": "text-center" },
            { "width": "10%", "targets": 7 },
            { "width": "6%", "targets": 8, "className": "text-center" },
            { "width": "8%", "targets": 9 },
            { "width": "6%", "targets": 10 },
            { "width": "4%", "targets": 11, "className": "text-center" },
            { "width": "6%", "targets": 12 },
            { "width": "8%", "targets": 13, "className": "text-center" }
        ],
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
        "language": {
            "lengthMenu": "_MENU_",
            "info": "_START_-_END_ of _TOTAL_",
            "infoEmpty": "0-0 of 0",
            "infoFiltered": "(filtered)",
            "paginate": {
                "previous": "<",
                "next": ">"
            }
        }
    });
}
</script>