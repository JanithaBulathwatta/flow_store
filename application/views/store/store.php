
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<style>
#storesTable th,
#storesTable td {
    vertical-align: middle !important;
}

#storesTable .d-flex.justify-content-center {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 8px;
}

#storesTable .btn-warning-light,
#storesTable .btn-danger-light,
#storesTable .btn-success-light {
    margin: 0 2px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

#storesTable tbody tr {
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

.store-info {
    display: flex;
    flex-direction: column;
}

.store-name {
    font-weight: 500;
    color: #333;
}

.store-address {
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


</style>

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-12 mt-3">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body"> 
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                            <div class="d-flex align-items-center"> 
                                <span class="card-title me-6">Warehouse Management</span>
                                
                                <div class="d-flex gap-2 flex-wrap" id="store-status-container">
                                    <!--<div class="mini-card bg-teal active-filter" data-status="active" style="cursor: pointer;">
                                        <i class="bi bi-shop"></i>
                                        <span id="activeStores">0</span>
                                        <span class="ms-1">Active Warehousees</span>
                                    </div>

                                    <div class="mini-card bg-warning" data-status="inactive" style="cursor: pointer;">
                                        <i class="bi bi-pause-circle"></i>
                                        <span id="inactiveStores">0</span>
                                        <span class="ms-1">Inactive Warehouses</span>
                                    </div>

                                    <div class="mini-card bg-secondary" data-status="" style="cursor: pointer;">
                                        <i class="bi bi-list"></i>
                                        <span>All</span>
                                    </div>-->
                                </div>
                                
                            </div> 
                            
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-add" id="btnAddStore">
                                    <i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Warehouse
                                </button>
                            </div> 
                        </div> 
                    </div>
					
                </div>
				<div class="summary-bar" id="summary-bar"></div>
            </div>
        
            <div class="col-xl-12">
                <form id="data-filter" style="display: none;">
                </form>
            </div>
        
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="storesTable" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Warehouse Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>branche</th>
                                        <th>Created</th>
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

<div class="modal fade" id="storeFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="storeForm">
                <div class="modal-header">
                    <h6 class="modal-title" id="storeModalTitle">Add Warehouse</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="store_id" name="sid">

                    <div class="row gy-3">
                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Warehouse Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter store name" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>

                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Warehouse Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address" class="form-control form-control-sm" placeholder="Enter store address" required>
                            <div class="invalid-feedback" id="address-error"></div>
                        </div>
                        
                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Warehouse Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-sm" placeholder="Enter store phone" maxlength="10" required>
                            <div class="invalid-feedback" id="phone-error"></div>
                        </div>
						
						<div class="col-xl-12 mt-1">
							<label class="form-label">Branch <span class="text-danger">*</span></label>
							<select name="branch_id" id="branch_id" class="form-control form-control-sm" required>
								<option value="">-- Select Branch --</option>
								<?php if(!empty($branches)): ?>
									<?php foreach ($branches as $branch): ?>
										<option value="<?= $branch->branch_id; ?>">
											<?= html_escape($branch->branch_name); ?> (<?= html_escape($branch->branch_code); ?>)
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
						
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub"> <i class="ri-save-line me-1"></i> Add Warehouse </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    
    const formModal = new bootstrap.Modal(document.getElementById('storeFormModal'));

    var initialStores = <?php echo json_encode($stores); ?>;
    var initialCounts = <?php echo json_encode($counts); ?>;
    
    $('#activeStores').text(initialCounts.active_count || 0);
    $('#inactiveStores').text(initialCounts.inactive_count || 0);
    $('#deletedStores').text(initialCounts.deleted_count || 0);
    
    var table = initializeDataTable('#storesTable');
    var currentStatusFilter = ''; // Default to active filter
    
    filter();
    
    /*function loadStoreCounts() {
        $.ajax({
            url: "<?php echo site_url('Store/get_counts'); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                $('#activeStores').text(response.active_count || 0);
                $('#inactiveStores').text(response.inactive_count || 0);
                $('#deletedStores').text(response.deleted_count || 0);
            },
            error: function() {
                console.error('Failed to load store counts');
            }
        });
    }*/
    
    loadStoreCounts();
	
/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadStoreCounts() {
    $.ajax({
        url: "Store/get_counts",
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Warehouse' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Warehouse' },
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'All Warehouse' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Warehouse' },
       
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Warehouse' };
		

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
        lbl: 'Total  count',
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

    
    // Status card click functionality
    $(document).on('click', '.mini-card', function() {
        let status = $(this).data('status');
        currentStatusFilter = status;
        
        // Update visual state of cards
        $('.mini-card').removeClass('active-filter');
        $(this).addClass('active-filter');
        
        filter();
    });
    
    $('#storeForm').submit(function(e){
        e.preventDefault();

        clearValidationErrors();

        let id = $('#store_id').val();
        let url = id 
            ? "<?= base_url('Store/update'); ?>" 
            : "<?= base_url('Store/store'); ?>";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res){
                if(res.stt === 'ok'){
                    toastr.success(res.msg);
                    formModal.hide();
                    $('#storeForm')[0].reset();
                    filter();
                    loadStoreCounts();
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
    
    $('#btnAddStore').click(function () {
        $('#storeModalTitle').text('Add Warehouse');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Add Warehouse');
        $('#storeForm')[0].reset();
        $('#store_id').val('');
        clearValidationErrors();
        formModal.show();
    });
    
    $(document).on('click', '.btnEditStore', function () {
        let id = $(this).data('id');
        
        $('#storeModalTitle').text('Edit Warehouse');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Update Warehouse');
        $('#store_id').val(id);
        
        clearValidationErrors();
        
        formModal.show();
        
        $.getJSON("<?= site_url('Store/get_store?id='); ?>" + id, function (res) {
            if (res.success) {
                $('#name').val(res.store.name);
                $('#address').val(res.store.address);
                $('#phone').val(res.store.phone);
                $('#branch_id').val(res.store.branch_id);
            } else {
                toastr.error(res.message || 'Failed to load store data');
            }
        });
    });
    
    $(document).on('click', '.btnDeleteStore', function () {            
        const id = $(this).data('id');
        deleteStore(this, id);
    });

    $(document).on('change', '.status-toggle', function() {
        const $toggle = $(this);
        const id = $toggle.data('id');
        const isChecked = $toggle.is(':checked');
        const newStatus = isChecked ? 'active' : 'inactive';

        $toggle.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('Store/toggle_status'); ?>",
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
                    loadStoreCounts();
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
    
    function deleteStore(el, id) {
        $(el).del_modal({
            title: 'Delete',
            head: 'Delete Warehouse',
            para: 'Do you want to delete this Warehouse?',
            id: id,
            url: '<?php echo site_url("Store/delete?id="); ?>' + id,
            callback: function(response) {
                filter();
                loadStoreCounts();
            }
        });
    }


    
    /*function filter() {
        if ($.fn.DataTable.isDataTable('#storesTable')) {
            $('#storesTable').DataTable().destroy();
        }
        
        $.ajax({
            url: "<?= site_url('Store/filter'); ?>",
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
                    let filteredStores;
                    
                    // Filter based on status card selection (exclude deleted from all views)
                    if (currentStatusFilter === '') {
                        // Show all non-deleted stores
                        filteredStores = res.data.filter(store => store.store_status !== 'deleted');
                    } else {
                        // Filter by specific status (never show deleted)
                        filteredStores = res.data.filter(store => store.store_status === currentStatusFilter);
                    }
                    
                    filteredStores.sort((a, b) => {
                        return parseInt(b.store_id) - parseInt(a.store_id);
                    });
                    
                    $.each(filteredStores, function (index, store) {
                        let rowNumber = index + 1;
                        let storeId = store.store_id;
                        let storeName = store.store_name;
                        let storeAddress = store.store_address;
                        let storePhone = store.store_phone;
                        let storeStatus = store.store_status;
                        let createDate = store.create_date ? store.create_date.split(' ')[0] : '-';
						let branche = store.branch_name;
                        
                        let statusBadge = '';
                        let toggleButton = '';
                        
                        if (storeStatus === 'active') {
                            statusBadge = '<span ></span>';
                            toggleButton = `<div class="form-check form-switch d-inline-block me-2 align-middle">
                                               <input class="form-check-input status-toggle" 
                                                      type="checkbox" 
                                                      data-id="${storeId}" 
                                                      checked
                                                      style="transform: scale(1.2); cursor: pointer;"
                                                      title="Toggle Status">
                                           </div>`;
                        } else if (storeStatus === 'inactive') {
                            statusBadge = '<span></span>';
                            toggleButton = `<div class="form-check form-switch d-inline-block me-2 align-middle">
                                               <input class="form-check-input status-toggle" 
                                                      type="checkbox" 
                                                      data-id="${storeId}" 
                                                      style="transform: scale(1.2); cursor: pointer;"
                                                      title="Toggle Status">
                                           </div>`;
                        }
                        
                        tbody += `
                        <tr data-store-id="${storeId}">
                            <td>${rowNumber}</td>
                            <td>
                                <div class="store-info">
                                    <span class="fw-medium">${escapeHtml(storeName)}</span>
                                    ${statusBadge}
                                </div>
                            </td>
                            <td>${escapeHtml(storePhone)}</td>
                            <td>
                                <span class="fw-medium" title="${escapeHtml(storeAddress)}">
                                    ${escapeHtml(storeAddress)}
                                </span>
                            </td>
							<td>${branche}</td>
                            <td>${createDate}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    ${toggleButton}
                                    <button class="btn btn-sm btn-icon btn-warning-light btnEditStore" 
                                            data-id="${storeId}" 
                                            title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger-light btn-icon btnDeleteStore" 
                                            data-id="${storeId}" 
                                            title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                    });
                } else {
                    tbody = `<tr>
                        <td colspan="6" class="text-center text-muted">No stores found</td>
                    </tr>`;
                }
                
                $('#storesTable tbody').html(tbody);
                
                table = initializeDataTable('#storesTable');
                
                if (res.counts) {
                    $('#activeStores').text(res.counts.active_count || 0);
                    $('#inactiveStores').text(res.counts.inactive_count || 0);
                    $('#deletedStores').text(res.counts.deleted_count || 0);
                }
            },
            error: function(xhr, status, error) {
                console.error('Filter error:', error);
                toastr.error('Failed to load stores');
            }
        });
    }*/
	
	function filter() {
    // 1. Check or initialize the DataTables instance up front
    let tableInstance;
    if ($.fn.DataTable.isDataTable('#storesTable')) {
        tableInstance = $('#storesTable').DataTable();
        tableInstance.clear(); 
    } else {
        
        tableInstance = initializeDataTable('#storesTable');
    }
    
    $.ajax({
        url: "<?= site_url('Store/filter'); ?>",
        type: "POST",
        data: {
            search: $('#searchFilter').val(),
            status: currentStatusFilter || $('#statusFilter').val(),
            date: $('#dateRange').val()
        },
        dataType: "json",
        success: function (res) {
            
            if (res.data && res.data.length > 0) {
                let filteredStores;
                
                // Filter based on status card selection (exclude deleted from all views)
                if (currentStatusFilter === '') {
                    filteredStores = res.data.filter(store => store.store_status !== 'deleted');
                } else {
                    filteredStores = res.data.filter(store => store.store_status === currentStatusFilter);
                }
                
                // Sort by ID descending
                filteredStores.sort((a, b) => parseInt(b.store_id) - parseInt(a.store_id));
                
                // 2. Loop through and feed the data row array elements to DataTables
                $.each(filteredStores, function (index, store) {
                    let rowNumber = index + 1;
                    let storeId = store.store_id;
                    let storeName = store.store_name;
                    let storeAddress = store.store_address;
                    let storePhone = store.store_phone;
                    let storeStatus = store.store_status;
                    let createDate = store.create_date ? store.create_date.split(' ')[0] : '-';
                    let branchName = store.branch_name;
                    
                    let statusBadge = '';
                    let toggleButton = '';
                    
                    if (storeStatus === 'active') {
                        statusBadge = '<span class="badge bg-success" style="font-size: 10px; padding: 3px 6px; display: inline-block; margin-left: 5px;">Active</span>';
                        toggleButton = `<div class="form-check form-switch d-inline-block me-2 align-middle">
                                           <input class="form-check-input status-toggle" 
                                                  type="checkbox" 
                                                  data-id="${storeId}" 
                                                  checked
                                                  style="transform: scale(1.2); cursor: pointer;"
                                                  title="Toggle Status">
                                       </div>`;
                    } else if (storeStatus === 'inactive') {
                        statusBadge = '<span class="badge bg-warning" style="font-size: 10px; padding: 3px 6px; display: inline-block; margin-left: 5px;">Inactive</span>';
                        toggleButton = `<div class="form-check form-switch d-inline-block me-2 align-middle">
                                           <input class="form-check-input status-toggle" 
                                                  type="checkbox" 
                                                  data-id="${storeId}" 
                                                  style="transform: scale(1.2); cursor: pointer;"
                                                  title="Toggle Status">
                                       </div>`;
                    }
                    
                    // Add via DataTables framework parsing wrapper
                    let rowNode = tableInstance.row.add([
                        rowNumber,
                        `<div class="store-info"><span class="fw-medium">${escapeHtml(storeName)}</span></div>`,
                        escapeHtml(storePhone),
                        `<span class="fw-medium" title="${escapeHtml(storeAddress)}">${escapeHtml(storeAddress)}</span>`,
                        escapeHtml(branchName),
                        createDate,
                        `<div class="d-flex justify-content-center gap-1">
                            ${toggleButton}
                            <button class="btn btn-sm btn-icon btn-warning-light btnEditStore" data-id="${storeId}" title="Edit">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-sm btn-danger-light btn-icon btnDeleteStore" data-id="${storeId}" title="Delete">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>`
                    ]).node();

                    // Apply layout tags back safely onto the row wrapper node structure
                    $(rowNode).attr('data-store-id', storeId);
                    $(rowNode).find('td:last-child').addClass('text-center');
                });

                // 3. Command DataTables engine to redraw elements onto screen canvas
                tableInstance.draw();

            } else {
                // Draws default native "No entries found" instead of messy broken custom rows
                tableInstance.draw();
            }
            
            // Sync dashboard summary statistics cards values
            if (res.counts) {
                $('#activeStores').text(res.counts.active_count || 0);
                $('#inactiveStores').text(res.counts.inactive_count || 0);
                $('#deletedStores').text(res.counts.deleted_count || 0);
            }
        },
        error: function(xhr, status, error) {
            console.error('Filter error:', error);
            toastr.error('Failed to load stores');
        }
    });
}
    
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // function initializeDataTable(selector) {
        // return $(selector).DataTable({
            // "paging": true,
            // "lengthChange": true,
            // "searching": true,
            // "ordering": true,
            // "info": true,
            // "autoWidth": false,
            // "responsive": true,
            // "language": {
                // "emptyTable": "No stores found"
            // },
            // "order": []  
        // });
    // }
    
    function clearValidationErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        /*$('.text-danger').remove();*/
    }
    
    function displayValidationErrors(errors) {
        toastr.error('Please check the form for errors');
        
        if (errors.toLowerCase().includes('store name')) {
            $('#name').addClass('is-invalid');
            $('#name-error').html('Store name is required');
        }
        
        if (errors.toLowerCase().includes('address')) {
            $('#address').addClass('is-invalid');
            $('#address-error').html('Store address is required');
        }

        if (errors.toLowerCase().includes('phone')) {
            $('#phone').addClass('is-invalid');
            $('#phone-error').html('Store phone is required');
        }
        
        if (!$('#name').hasClass('is-invalid') && !$('#address').hasClass('is-invalid') && !$('#phone').hasClass('is-invalid')) {
            $('#name').addClass('is-invalid');
            $('#address').addClass('is-invalid');
            $('#phone').addClass('is-invalid');
        }
    }
    
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });
    
});
</script>