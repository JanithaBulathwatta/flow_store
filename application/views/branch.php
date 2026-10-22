
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<style>
#branchesTable th,
#branchesTable td {
    vertical-align: middle !important;
}

#branchesTable .d-flex.justify-content-center {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 8px;
}

#branchesTable .btn-warning-light,
#branchesTable .btn-danger-light,
#branchesTable .btn-success-light {
    margin: 0 2px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

#branchesTable tbody tr {
    height: 55px;
}

table.dataTable thead th,
table.dataTable tbody td {
    text-align: left !important;
    vertical-align: middle !important;
}

table.dataTable tbody td:last-child,
table.dataTable thead th:last-child {
    text-align: center !important;
}

table.dataTable thead th,
table.dataTable tbody td {
    padding: 12px 10px !important;
}


.mini-card i {
    margin-right: 5px;
    font-size: 16px;
}

.bg-teal {
    background-color: #20c997;
}

.bg-warning {
    background-color: #ffc107;
}

.bg-danger {
    background-color: #dc3545;
}

.branch-info {
    display: flex;
    flex-direction: column;
}

.branch-name {
    font-weight: 500;
    color: #333;
}

.branch-code {
    font-size: 11px;
    color: #6c757d;
}

.branch-address {
    font-size: 12px;
    color: #6c757d;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.status-badge {
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
    display: inline-block;
}

.status-active {
    background-color: #d4edda;
    color: #155724;
}

.status-inactive {
    background-color: #fff3cd;
    color: #856404;
}

.status-deleted {
    background-color: #f8d7da;
    color: #721c24;
}

.bg-secondary {
    background-color: #6c757d;
}

.form-label .text-danger {
    display: inline !important;
    color: #dc3545 !important; /* Forces Bootstrap's standard red */
    visibility: visible !important;
    font-weight: bold;
}



</style>

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-12 mt-3">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body"> 
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                            <div class="d-flex align-items-center"> 
                                <span class="card-title me-6">Branch Management</span>
                                
                                <div class="d-flex gap-2 flex-wrap" id="branch-status-container">
                                    <!--<div class="mini-card bg-teal active-filter" data-status="active" style="cursor: pointer;">
                                        <i class="bi bi-building"></i>
                                        <span id="activeBranches">0</span>
                                        <span class="ms-1">Active Branches</span>
                                    </div>

                                    <div class="mini-card bg-warning" data-status="inactive" style="cursor: pointer;">
                                        <i class="bi bi-pause-circle"></i>
                                        <span id="inactiveBranches">0</span>
                                        <span class="ms-1">Inactive Branches</span>
                                    </div>

                                    <div class="mini-card bg-secondary" data-status="" style="cursor: pointer;">
                                        <i class="bi bi-list"></i>
                                        <span>All</span>
                                    </div>-->
                                </div>
                                
                            </div> 
                            
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-add" id="btnAddBranch">
                                    <i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Branch
                                </button>
                            </div> 
                        </div> 
                    </div>
					
					<div class="summary-bar" id="summary-bar"></div>
					
                </div>
            </div>
        
            <div class="col-xl-12">
                <form id="data-filter" style="display: none;">
                </form>
            </div>
        
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="branchesTable" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        
                                        <th>Branch</th>
                                        <th>Branch Code</th>
                                        <th>City</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Created</th>
                                        <th>Status</th>
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

<div class="modal fade" id="branchFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="branchForm">
                <div class="modal-header">
                    <h6 class="modal-title" id="branchModalTitle">Add Branch</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="branch_id" name="bid">

                    <div class="row gy-3">
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Branch Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control form-control-sm" placeholder="Enter branch code" maxlength="20" required>
                            <div class="invalid-feedback" id="code-error"></div>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter branch name" maxlength="45" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Branch Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address" class="form-control form-control-sm" placeholder="Enter full branch address" maxlength="100" required>
                            <div class="invalid-feedback" id="address-error"></div>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" id="city" class="form-control form-control-sm" placeholder="Enter city" maxlength="30" required>
                            <div class="invalid-feedback" id="city-error"></div>
                        </div>
                        
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Phone </label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-sm" placeholder="Enter phone number" maxlength="15">
                            <div class="invalid-feedback" id="phone-error"></div>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Email </label>
                            <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="Enter email address" maxlength="50">
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub"> <i class="ri-save-line me-1"></i> Add Branch </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    
    const formModal = new bootstrap.Modal(document.getElementById('branchFormModal'));

    var initialBranches = <?php echo json_encode($branches); ?>;
    var initialCounts = <?php echo json_encode($counts); ?>;
    
    $('#activeBranches').text(initialCounts.active_count || 0);
    $('#inactiveBranches').text(initialCounts.inactive_count || 0);
    $('#deletedBranches').text(initialCounts.deleted_count || 0);
    
    var table = initializeDataTable('#branchesTable');
    var currentStatusFilter = ''; // Default to active filter
    
    filter();
    
    /*function loadBranchCounts() {
        $.ajax({
            url: "<?php echo site_url('Branch/get_counts'); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                $('#activeBranches').text(response.active_count || 0);
                $('#inactiveBranches').text(response.inactive_count || 0);
                $('#deletedBranches').text(response.deleted_count || 0);
            },
            error: function() {
                console.error('Failed to load branch counts');
            }
        });
    }*/
	
/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadBranchCounts() {
    $.ajax({
        url: "/Branch/get_counts",
        type: "GET",
        dataType: "json",
        success: function(res) {

            console.log(res);

            
            // Storing the original array response
            GRN_ITEMS = Object.keys(res).map(function(key) {
                return {
                    name: key,         // e.g. "active_count"
                    total: res[key]    // e.g. 58
                };
            });
            
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Branch' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Branch' },
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'All Branch' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Branch' },
       
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Branch' };
		

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
        lbl: 'Total Branch Records',
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

    
    loadBranchCounts();
    
    // Status card click functionality
    $(document).on('click', '.mini-card', function() {
        let status = $(this).data('status');
        currentStatusFilter = status;
        
        // Update visual state of cards
        $('.mini-card').removeClass('active-filter');
        $(this).addClass('active-filter');
        
        filter();
    });
    
    $('#branchForm').submit(function(e){
        e.preventDefault();

        clearValidationErrors();

        let id = $('#branch_id').val();
        let url = id 
            ? "<?= base_url('Branch/update'); ?>" 
            : "<?= base_url('Branch/store'); ?>";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res){
                if(res.stt === 'ok'){
                    toastr.success(res.msg);
                    formModal.hide();
                    $('#branchForm')[0].reset();
                    filter();
                    loadBranchCounts();
                } else {
                    if (res.msg) {
                        displayValidationErrors(res.msg);
                    } else {
                        toastr.error('Something went wrong');
                    }
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Something went wrong: ' + error);
            }
        });
    });
    
    $('#btnAddBranch').click(function () {
        $('#branchModalTitle').text('Add Branch');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Add Branch');
        $('#branchForm')[0].reset();
        $('#branch_id').val('');
        clearValidationErrors();
        formModal.show();
    });
    
    $(document).on('click', '.btnEditBranch', function () {
        let id = $(this).data('id');
        
        $('#branchModalTitle').text('Edit Branch');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Update Branch');
        $('#branch_id').val(id);
        
        clearValidationErrors();
        
        formModal.show();
        
        $.getJSON("<?= site_url('Branch/get_branch?id='); ?>" + id, function (res) {
            if (res.success) {
                $('#code').val(res.branch.code);
                $('#name').val(res.branch.name);
                $('#address').val(res.branch.address);
                $('#city').val(res.branch.city);
                $('#phone').val(res.branch.phone);
                $('#email').val(res.branch.email);
            } else {
                toastr.error(res.message || 'Failed to load branch data');
            }
        });
    });
    
    $(document).on('click', '.btnDeleteBranch', function () {            
        const id = $(this).data('id');
        deleteBranch(this, id);
    });

    $(document).on('change', '.status-toggle', function() {
        const $toggle = $(this);
        const id = $toggle.data('id');
        const isChecked = $toggle.is(':checked');
        const newStatus = isChecked ? 'active' : 'inactive';

        $toggle.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('Branch/toggle_status'); ?>",
            type: "POST",
            data: {
                id: id,
                status: newStatus
            },
            dataType: "json",
            success: function(res) {
                if (res.stt === 'ok') {
                    toastr.success(res.msg);
                    filter();
                    loadBranchCounts();
                } else {
                    toastr.error(res.msg || 'Failed to update status');
                    $toggle.prop('checked', !isChecked);
                }
            },
            error: function() {
                toastr.error('Something went wrong');
                $toggle.prop('checked', !isChecked);
            },
            complete: function() {
                $toggle.prop('disabled', false);
            }
        });
    });
    
    function deleteBranch(el, id) {
        $(el).del_modal({
            title: 'Delete',
            head: 'Delete Branch',
            para: 'Do you want to delete this branch?',
            id: id,
            url: '<?php echo site_url("Branch/delete?id="); ?>' + id,
            callback: function(response) {
                filter();
                loadBranchCounts();
            }
        });
    }


    
    /*function filter() {
        if ($.fn.DataTable.isDataTable('#branchesTable')) {
            //$('#branchesTable').DataTable().destroy();
			$('#branchesTable').DataTable().clear().destroy();
			$('#branchesTable tbody').empty();
        }
        
        $.ajax({
            url: "<?= site_url('Branch/filter'); ?>",
            type: "POST",
            data: {
                search: $('#searchFilter').val(),
                status: currentStatusFilter || $('#statusFilter').val(),
                date: $('#dateRange').val()
            },
            dataType: "json",
            success: function (res) {
                let tbody = '';
                
                if (res.data && res.data.length > 0) {
                    let filteredBranches;
                    
                    // Filter based on status card selection (exclude deleted from all views)
                    if (currentStatusFilter === '') {
                        // Show all non-deleted branches
                        filteredBranches = res.data.filter(branch => branch.branch_status !== 'deleted');
                    } else {
                        // Filter by specific status (never show deleted)
                        filteredBranches = res.data.filter(branch => branch.branch_status === currentStatusFilter);
                    }
                    
                    filteredBranches.sort((a, b) => {
                        return parseInt(b.branch_id) - parseInt(a.branch_id);
                    });
                    
                    $.each(filteredBranches, function (index, branch) {
                        let rowNumber = index + 1;
                        let branchId = branch.branch_id;
                        let branchCode = branch.branch_code;
                        let branchName = branch.branch_name;
                        let branchAddress = branch.branch_address_full;
                        let branchCity = branch.branch_city;
                        let branchPhone = branch.branch_phone;
                        let branchEmail = branch.branch_email;
                        let branchStatus = branch.branch_status;
                        let createdAt = branch.created_at ? branch.created_at.split(' ')[0] : '-';
                        
                        let statusBadge = '';
                        let toggleButton = '';
                        
                        if (branchStatus === 'active') {
                            statusBadge = '<span ></span>';
                            toggleButton = `<div class="form-check form-switch d-inline-block me-2 align-middle">
                                               <input class="form-check-input status-toggle" 
                                                      type="checkbox" 
                                                      data-id="${branchId}" 
                                                      checked
                                                      style="transform: scale(1.2); cursor: pointer;"
                                                      title="Toggle Status">
                                           </div>`;
                        } else if (branchStatus === 'inactive') {
                            statusBadge = '<span ></span>';
                            toggleButton = `<div class="form-check form-switch d-inline-block me-2 align-middle">
                                               <input class="form-check-input status-toggle" 
                                                      type="checkbox" 
                                                      data-id="${branchId}" 
                                                      style="transform: scale(1.2); cursor: pointer;"
                                                      title="Toggle Status">
                                           </div>`;
                        }
                        
                        tbody += `
                        <tr data-branch-id="${branchId}">
                            <!--<td>${rowNumber}</td>-->
                            <td>
                                <div class="branch-info">
                                    <span class="fw-medium">${escapeHtml(branchName)}</span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium">${escapeHtml(branchCode)}</span>
                            </td>
                            <td>${escapeHtml(branchCity)}</td>
                            <td>
                                <span class="fw-medium" title="${escapeHtml(branchAddress)}">
                                    ${escapeHtml(branchAddress)}
                                </span>
                            </td>
                            <td>${escapeHtml(branchPhone)}</td>
                            <td>${escapeHtml(branchEmail)}</td>
                            <td>${createdAt}</td>
                            <td>${statusBadge}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    ${toggleButton}
                                    <button class="btn btn-sm btn-icon btn-warning-light btnEditBranch" 
                                            data-id="${branchId}" 
                                            title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger-light btn-icon btnDeleteBranch" 
                                            data-id="${branchId}" 
                                            title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                    });
                } else {
                    tbody = `<tr>
                        <td colspan="9" class="text-center text-muted">No branches found</td>
                    </tr>`;
                }
                
                $('#branchesTable tbody').html(tbody);
                
                table = initializeDataTable('#branchesTable');
                
                if (res.counts) {
                    $('#activeBranches').text(res.counts.active_count || 0);
                    $('#inactiveBranches').text(res.counts.inactive_count || 0);
                    $('#deletedBranches').text(res.counts.deleted_count || 0);
                }
            },
            error: function(xhr, status, error) {
                console.error('Filter error:', error);
                toastr.error('Failed to load branches');
            }
        });
    }*/
	
	function filter() {
    // 1. Get or Initialize the DataTable instance right away
    let tableInstance;
    if ($.fn.DataTable.isDataTable('#branchesTable')) {
        tableInstance = $('#branchesTable').DataTable();
        tableInstance.clear(); 
    } else {
        // If it hasn't been initialized yet, do it now so the API is ready
        tableInstance = initializeDataTable('#branchesTable');
    }
    
    $.ajax({
        url: "<?= site_url('Branch/filter'); ?>",
        type: "POST",
        data: {
            search: $('#searchFilter').val(),
            status: currentStatusFilter || $('#statusFilter').val(),
            date: $('#dateRange').val()
        },
        dataType: "json",
        success: function (res) {
            
            if (res.data && res.data.length > 0) {
                let filteredBranches;
                
                // Filter based on status card selection
                if (currentStatusFilter === '') {
                    filteredBranches = res.data.filter(branch => branch.branch_status !== 'deleted');
                } else {
                    filteredBranches = res.data.filter(branch => branch.branch_status === currentStatusFilter);
                }
                
                // Sort by ID descending
                filteredBranches.sort((a, b) => parseInt(b.branch_id) - parseInt(a.branch_id));
                
                // 2. Loop through records and push rows directly into the DataTables API
                $.each(filteredBranches, function (index, branch) {
                    let branchId = branch.branch_id;
                    let branchCode = branch.branch_code;
                    let branchName = branch.branch_name;
                    let branchAddress = branch.branch_address_full;
                    let branchCity = branch.branch_city;
                    let branchPhone = branch.branch_phone;
                    let branchEmail = branch.branch_email;
                    let branchStatus = branch.branch_status;
                    let createdAt = branch.created_at ? branch.created_at.split(' ')[0] : '-';
                    
                    let statusBadge = '';
                    let toggleButton = '';
                    
                    if (branchStatus === 'active') {
                        statusBadge = '<span class="badge bg-success-light text-success">Active</span>';
                        toggleButton = `<div class="form-check form-switch d-inline-block me-2 align-middle">
                                           <input class="form-check-input status-toggle" 
                                                  type="checkbox" 
                                                  data-id="${branchId}" 
                                                  checked
                                                  style="transform: scale(1.2); cursor: pointer;"
                                                  title="Toggle Status">
                                       </div>`;
                    } else if (branchStatus === 'inactive') {
                        statusBadge = '<span class="badge bg-warning-light text-warning">Inactive</span>';
                        toggleButton = `<div class="form-check form-switch d-inline-block me-2 align-middle">
                                           <input class="form-check-input status-toggle" 
                                                  type="checkbox" 
                                                  data-id="${branchId}" 
                                                  style="transform: scale(1.2); cursor: pointer;"
                                                  title="Toggle Status">
                                       </div>`;
                    }
                    
                    // Create the nodes using standard DataTables row definitions
                    let rowNode = tableInstance.row.add([
                        `<div class="branch-info"><span class="fw-medium">${escapeHtml(branchName)}</span></div>`,
                        `<span class="fw-medium">${escapeHtml(branchCode)}</span>`,
                        escapeHtml(branchCity),
                        `<span class="fw-medium" title="${escapeHtml(branchAddress)}">${escapeHtml(branchAddress)}</span>`,
                        escapeHtml(branchPhone),
                        escapeHtml(branchEmail),
                        createdAt,
                        statusBadge,
                        `<div class="d-flex justify-content-center gap-1">
                            ${toggleButton}
                            <button class="btn btn-sm btn-icon btn-warning-light btnEditBranch" data-id="${branchId}" title="Edit">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-sm btn-danger-light btn-icon btnDeleteBranch" data-id="${branchId}" title="Delete">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>`
                    ]).node();

                    // This attaches the row attribute data ID back onto your <tr> tag safely
                    $(rowNode).attr('data-branch-id', branchId);
                    $(rowNode).find('td:last-child').addClass('text-center'); 
                });

                // 3. Draw the newly added nodes onto the screen
                tableInstance.draw();

            } else {
                // If there is no data, draw an empty view
                tableInstance.draw();
            }
            
            // Render counters card section safely
            if (res.counts) {
                $('#activeBranches').text(res.counts.active_count || 0);
                $('#inactiveBranches').text(res.counts.inactive_count || 0);
                $('#deletedBranches').text(res.counts.deleted_count || 0);
            }
        },
        error: function(xhr, status, error) {
            console.error('Filter error:', error);
            toastr.error('Failed to load branches');
        }
    });
}
    
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function initializeDataTable(selector) {
        return $(selector).DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "emptyTable": "No branches found"
            },
            "order": []  
        });
    }
    
    function clearValidationErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        /*$('.text-danger').remove();*/
    }
    
    function displayValidationErrors(errors) {
        toastr.error('Please check the form for errors');
        
        if (errors.toLowerCase().includes('branch code')) {
            $('#code').addClass('is-invalid');
            $('#code-error').html('Branch code is required or already exists');
        }
        
        if (errors.toLowerCase().includes('branch name')) {
            $('#name').addClass('is-invalid');
            $('#name-error').html('Branch name is required');
        }
        
        if (errors.toLowerCase().includes('address')) {
            $('#address').addClass('is-invalid');
            $('#address-error').html('Branch address is required');
        }

        if (errors.toLowerCase().includes('city')) {
            $('#city').addClass('is-invalid');
            $('#city-error').html('City is required');
        }

        if (errors.toLowerCase().includes('phone')) {
            $('#phone').addClass('is-invalid');
            $('#phone-error').html('Phone is required');
        }

        if (errors.toLowerCase().includes('email')) {
            $('#email').addClass('is-invalid');
            $('#email-error').html('Valid email is required');
        }
    }
    
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });
    
});
</script>