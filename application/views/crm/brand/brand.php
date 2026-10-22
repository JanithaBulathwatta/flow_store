<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <!-- Mini Cards Section -->
            <div class="col-md-12 mt-3">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body"> 
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                            <div class="d-flex align-items-center"> 
                                <span class="card-title me-6">Brands Management</span>
                                
                                <div class="d-flex gap-2 flex-wrap align-items-center" id="brand-status-container">
                                    <!--<div id="pill-total" class="stat-pill status-filter" data-status="active,inactive">
                                        <span class="num" id="val-total">0</span>
                                        <span class="lbl">Total</span>
                                    </div>
                                    <div id="pill-active" class="stat-pill status-filter" data-status="active">
                                        <span class="num" id="val-active">0</span>
                                        <span class="lbl">Active</span>
                                    </div>
                                    <div id="pill-inactive" class="stat-pill status-filter" data-status="inactive">
                                        <span class="num" id="val-inactive">0</span>
                                        <span class="lbl">Inactive</span>
                                    </div>
                                    <div id="pill-deleted" class="stat-pill status-filter" data-status="deleted">
                                        <span class="num" id="val-deleted">0</span>
                                        <span class="lbl">Deleted</span>
                                    </div>-->
                                </div>
                                
                            </div> 
                            
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-add btn-wave" id="btnAddBrand">
                                    <i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Brand
                                </button>
                            </div> 

                        </div>
						
                    </div>
                </div>
				
				<div class="summary-bar" id="summary-bar"></div>
            </div>
			
        
		     <!-- HIDDEN FILTER INPUTS -->
            <input type="hidden" id="statusFilter" value="">
            <input type="hidden" id="searchFilter" value="">
            <input type="hidden" id="dateRange" value="">
			
            <!-- Hidden Filter Form -->
            <div class="col-xl-12">
                <form id="data-filter" style="display: none;">
                    <!-- Hidden filter form -->
                </form>
            </div>
        
            <!-- Brands Table -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="brandsTable" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>Brand</th>
                                        <th>Code</th>
                                        <th>Description</th>
										<th class="text-center">Item count</th>
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

<!-- Brand Form Modal -->
<div class="modal fade" id="brandFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="brandForm">
                <div class="modal-header">
                    <h6 class="modal-title" id="brandModalTitle">Add Brand</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="brand_id" name="bid">
					<input type="hidden" id="form_status" name="status" value="active"> 

                    <div class="row gy-3">
                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter brand name" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>

                        <div class="col-xl-12 mt-1">
                          <label class="form-label">Brand Code <span class="text-danger">*</span></label>
                          <input type="text" name="code" id="code" class="form-control form-control-sm" placeholder="Enter brand code" required>
                           <div class="invalid-feedback" id="code-error"></div>
                        </div>
                        
                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control form-control-sm" placeholder="Enter brand description" rows="3"></textarea>
                            <div class="invalid-feedback" id="description-error"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub"> <i class="ri-save-line me-1"></i> Add Brand </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    
	 
    const formModal = new bootstrap.Modal(document.getElementById('brandFormModal'));

    // Initial data from PHP (passed from controller)
    var initialBrands = <?php echo json_encode($brands); ?>;
    var initialCounts = <?php echo json_encode($counts); ?>;
    
    // Set initial counts
    $('#activeBrands').text(initialCounts.active_count || 0);
    $('#inactiveBrands').text(initialCounts.inactive_count || 0);
    $('#deletedBrands').text(initialCounts.deleted_count || 0);
    
    // Initialize DataTable
    var table = initializeDataTable('#brandsTable');
    
    // Load initial data
    filter();
    
   // Load brand counts
	/*function loadBrandCounts() {
		$.ajax({
			url: "<?php echo site_url('Brand/get_counts'); ?>",
			type: "GET",
			dataType: "json",
			success: function(response) {
				let total = (parseInt(response.active_count) || 0) + (parseInt(response.inactive_count) || 0);
				
				$('#val-total').text(total);
				$('#val-active').text(response.active_count || 0);
				$('#val-inactive').text(response.inactive_count || 0);
				$('#val-deleted').text(response.deleted_count || 0);
			},
			error: function() {
				console.error('Failed to load brand counts');
			}
		});
	}*/

    loadBrandCounts();
	
	
	
/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadBrandCounts() {
    $.ajax({
        url: "Brand/get_counts",
        type: "GET",
        dataType: "json",
        success: function(res) {

            console.log(res);

            // Storing the original array response
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
				// New code that preserves all words nicely
				if (!STATUS_LABELS[key]) {
					// Replace underscores with spaces
					var readableName = item.name.replace(/_/g, ' '); 
					// Capitalize the first letter and append ' count'
					STATUS_LABELS[key] = readableName.charAt(0).toUpperCase() + readableName.slice(1);
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Brands' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Brands' },
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Brands' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Brands' },
       
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Total Brands' };
		

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
	
	// Click handler for status filters - EXACTLY like Projects code
    $(document).on('click', '.status-filter', function () {
        let status = $(this).data('status');
        console.log("Filtering by status:", status);
        
        // Set the status filter value
        $('#statusFilter').val(status);
        
        // Reload table with filter
        filter();
    });
    
     
    // Submit brand for save or Update  
$('#brandForm').ajax_submit({
    url: '/Brand/store',  // Same URL for both add and edit
    rest: false,
    beforeSubmit: function(formData) {
         
        clearValidationErrors();
        return true;  
    },
    callback: function(id) {
        $('#brandForm')[0].reset();
        $('#brand_id').val('');
        formModal.hide();
        $('#statusFilter').val('');  
        filter();
        loadBrandCounts();
         
    }
});
                 
             
    // Add new brand
    $('#btnAddBrand').click(function () {
        $('#brandModalTitle').text('Add Brand');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Add Brand');
        $('#brandForm')[0].reset();
        $('#brand_id').val('');
        clearValidationErrors();
        formModal.show();
    });
    
    // Edit brand
    $(document).on('click', '.btnEditBrand', function () {
        let id = $(this).data('id');
        
        $('#brandModalTitle').text('Edit Brand');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Update Brand');
        $('#brand_id').val(id);
        
        // Clear validation errors
        clearValidationErrors();
        
        formModal.show();
        
        $.getJSON("<?= site_url('Brand/get_brand?id='); ?>" + id, function (res) {
            if (res.success) {
                $('#name').val(res.brand.name);
                $('#code').val(res.brand.code);
                $('#description').val(res.brand.description);
            } else {
                toastr.error(res.message || 'Failed to load brand data');
            }
        });
    });
    
    // Delete brand
    $(document).on('click', '.btnDeleteBrand', function () {            
        const id = $(this).data('id');
        deleteBrand(this, id);
    });
    
    function deleteBrand(el, id) {
        $(el).del_modal({
            title: 'Delete',
            head: 'Delete Brand',
            para: 'Do you want to delete this brand?',
            id: id,
            url: '<?php echo site_url("Brand/delete?id="); ?>' + id,
            callback: function(response) {
                 
                filter();  
                loadBrandCounts();  
            }
        });
    }
    
    // Status toggle change handler  
    $(document).on('change', '.statusToggle', function() {
        const $toggle = $(this);
        const brandId = $toggle.closest('.brand-toggle').data('brand-id');
        const isChecked = $toggle.is(':checked');
        const newStatus = isChecked ? 'active' : 'inactive';

        // Disable toggle during AJAX
        $toggle.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('Brand/update_status'); ?>",
            type: "POST",
            data: {
                id: brandId,
                status: newStatus
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    toastr.success('Status updated successfully');
                    
                    // Update mini cards
                    loadBrandCounts();
                    
                    // Disable/enable action buttons based on new status
                    const $actionRow = $toggle.closest('td');
                    const $actionButtons = $actionRow.find('.btnEditBrand, .btnDeleteBrand');
                    
                    const $editBtn = $actionRow.find('.btnEditBrand');
                    const $deleteBtn = $actionRow.find('.btnDeleteBrand');

                    if (newStatus === 'active') {
                      $editBtn.prop('disabled', false);
                      $deleteBtn.prop('disabled', false);
                    } else if (newStatus === 'inactive') {
                       $editBtn.prop('disabled', true);
                       $deleteBtn.prop('disabled', false);
                     }
					filter();
                    
                } else {
                    // Revert if failed
                    $toggle.prop('checked', !isChecked);
                    toastr.error(res.message || 'Failed to update status');
                }
            },
            error: function() {
                // Revert if failed
                $toggle.prop('checked', !isChecked);
                toastr.error('Something went wrong');
            },
            complete: function() {
                // Re-enable toggle
                $toggle.prop('disabled', false);
            }
        });
    });
    
/*function filter() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#brandsTable')) {
        $('#brandsTable').DataTable().destroy();
		
    }
    
    $.ajax({
        url: "<?= site_url('Brand/filter'); ?>",
        type: "POST",
        data: {
            search: $('#searchFilter').val(),
            status: $('#statusFilter').val(),
            date: $('#dateRange').val()
        },
        dataType: "json",
        success: function (res) {
            let tbody = '';
            
            if (res.data && res.data.length > 0) {
                // Filter brands based on selected status
                let filteredBrands = res.data;
                let selectedStatus = $('#statusFilter').val();
                
                // If a specific status is selected, filter by that status
                if (selectedStatus && selectedStatus !== '') {
                    // Check if it's a comma-separated list (like "active,inactive")
                    if (selectedStatus.includes(',')) {
                        let statuses = selectedStatus.split(',');
                        filteredBrands = res.data.filter(brand => 
                            statuses.includes(brand.brand_status)
                        );
                    } else {
                        // Single status filter
                        filteredBrands = res.data.filter(brand => brand.brand_status === selectedStatus);
                    }
                } else {
                    // DEFAULT VIEW: Show only active AND inactive brands (exclude deleted)
                    filteredBrands = res.data.filter(brand => 
                        brand.brand_status === 'active' || brand.brand_status === 'inactive'
                    );
                }
                
                // Sort by ID descending
                filteredBrands.sort((a, b) => {
                    return parseInt(b.brand_id) - parseInt(a.brand_id);
                });
                
                // Generate rows
                $.each(filteredBrands, function (index, brand) {
                    let brandId = brand.brand_id;
                    let brandName = brand.brand_name;
                    let brandCode = brand.brand_code;
                    let brandDesc = brand.brand_description;
                    let brandStatus = brand.brand_status;
					let itemCount = brand.item_count || 0;
                    
                    // Format description with truncation
                    let displayDescription = brandDesc ? 
                        (brandDesc.length > 50 ? escapeHtml(brandDesc.substring(0, 50)) + '...' : escapeHtml(brandDesc)) 
                        : '-';
                    
                    // Determine if toggle should be disabled (deleted brands)
                    let isDeleted = brandStatus === 'deleted';
                    let isInactive = brandStatus === 'inactive';
                    let isActive = brandStatus === 'active';
                    
                    // Status badge
                    let statusBadge = '';
                    if (brandStatus === 'active') {
                        statusBadge = '<span class="badge bg-success" style="font-size: 10px; padding: 3px 6px; margin-top: 4px; display: inline-block;">Active</span>';
                    } else if (brandStatus === 'inactive') {
                        statusBadge = '<span class="badge bg-warning" style="font-size: 10px; padding: 3px 6px; margin-top: 4px; display: inline-block;">Inactive</span>';
                    } else if (brandStatus === 'deleted') {
                        statusBadge = '<span class="badge bg-danger" style="font-size: 10px; padding: 3px 6px; margin-top: 4px; display: inline-block;">Deleted</span>';
                    }
					
					 
                    
                    tbody += `
                    <tr data-brand-id="${brandId}">
                        <td>
                            <div class="brand-info">
                                <span class="brand-name fw-medium">${escapeHtml(brandName)}</span>
                                 
                            </div>
                         </td>
                        <td>
                            ${brandCode ? `<span class="brand-code">${escapeHtml(brandCode)}</span>` : '-'}
                         </td>
                        <td title="${brandDesc ? escapeHtml(brandDesc) : ''}">
                            ${displayDescription}
                        </td>
						
						<td class="fw-normal" style="text-align: center; padding-left: 25%;">
                             ${itemCount}
                        </td>
						 
                        <td class="text-center">
                            <div class="d-flex align-items-center gap-1">
                                <!-- Status Toggle -->
                                <div class="brand-toggle" data-brand-id="${brandId}">
                                    <div class="form-check form-switch d-inline-block" style="margin-right: 2px;">
                                        <input class="form-check-input statusToggle" 
                                               type="checkbox" 
                                               ${brandStatus === 'active' ? 'checked' : ''} 
                                               data-brand-id="${brandId}"
                                               style="transform: scale(1.1); cursor: pointer; margin-top: 0;"
                                               ${isDeleted ? 'disabled' : ''}
                                               title="${isDeleted ? 'Cannot toggle deleted items' : (isActive ? 'Click to deactivate' : 'Click to activate')}">
                                    </div>
                                </div>
                                
                                <button class="btn btn-sm btn-icon btn-warning-light btnEditBrand" 
                                       data-id="${brandId}" 
                                       title="Edit"
                                       ${isInactive || isDeleted ? 'disabled' : ''}>
                                        <i class="ri-edit-line"></i>
                                </button>
                                
                                <button class="btn btn-sm btn-danger-light btn-icon btnDeleteBrand" 
                                    data-id="${brandId}" 
                                    title="Delete"
                                    ${isDeleted ? 'disabled' : ''}>
                                   <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                });
            } else {
                tbody = `<tr>
                    <td colspan="5" class="text-center text-muted">No brands found</td>
                </tr>`;
            }
            
            $('#brandsTable tbody').html(tbody);
            
            // Re-initialize DataTable
            table = initializeDataTable('#brandsTable');
            
            // Update counts
            loadBrandCounts();
        },
        error: function(xhr, status, error) {
            console.error('Filter error:', error);
            toastr.error('Failed to load brands');
        }
    });
}*/


function filter() {
    // 1. Safe Instantiation: Get or initialize the DataTable instance up front
    let tableInstance;
    if ($.fn.DataTable.isDataTable('#brandsTable')) {
        tableInstance = $('#brandsTable').DataTable();
        tableInstance.clear(); // Clear rows from DataTables engine cache safely
    } else {
        // If it's a completely fresh table layout, initialize it right away
        tableInstance = initializeDataTable('#brandsTable');
    }
    
    $.ajax({
        url: "<?= site_url('Brand/filter'); ?>",
        type: "POST",
        data: {
            search: $('#searchFilter').val(),
            status: $('#statusFilter').val(),
            date: $('#dateRange').val()
        },
        dataType: "json",
        success: function (res) {
            
            if (res.data && res.data.length > 0) {
                let filteredBrands = res.data;
                let selectedStatus = $('#statusFilter').val();
                
                // Process Filters
                if (selectedStatus && selectedStatus !== '') {
                    if (selectedStatus.includes(',')) {
                        let statuses = selectedStatus.split(',');
                        filteredBrands = res.data.filter(brand => 
                            statuses.includes(brand.brand_status)
                        );
                    } else {
                        filteredBrands = res.data.filter(brand => brand.brand_status === selectedStatus);
                    }
                } else {
                    // DEFAULT VIEW: Show active and inactive, exclude deleted
                    filteredBrands = res.data.filter(brand => 
                        brand.brand_status === 'active' || brand.brand_status === 'inactive'
                    );
                }
                
                // Sort by ID descending
                filteredBrands.sort((a, b) => parseInt(b.brand_id) - parseInt(a.brand_id));
                
                // 2. Insert rows using the native DataTables row engine
                $.each(filteredBrands, function (index, brand) {
                    let brandId = brand.brand_id;
                    let brandName = brand.brand_name;
                    let brandCode = brand.brand_code;
                    let brandDesc = brand.brand_description;
                    let brandStatus = brand.brand_status;
                    let itemCount = brand.item_count || 0;
                    
                    let displayDescription = brandDesc ? 
                        (brandDesc.length > 50 ? escapeHtml(brandDesc.substring(0, 50)) + '...' : escapeHtml(brandDesc)) 
                        : '-';
                    
                    let isDeleted = brandStatus === 'deleted';
                    let isInactive = brandStatus === 'inactive';
                    let isActive = brandStatus === 'active';
                    
                    let statusBadge = '';
                    if (brandStatus === 'active') {
                        statusBadge = '<span class="badge bg-success" style="font-size: 10px; padding: 3px 6px; display: inline-block;">Active</span>';
                    } else if (brandStatus === 'inactive') {
                        statusBadge = '<span class="badge bg-warning" style="font-size: 10px; padding: 3px 6px; display: inline-block;">Inactive</span>';
                    } else if (brandStatus === 'deleted') {
                        statusBadge = '<span class="badge bg-danger" style="font-size: 10px; padding: 3px 6px; display: inline-block;">Deleted</span>';
                    }
                    
                    // Native registration to DataTable schema array mapping
                    let rowNode = tableInstance.row.add([
                        `<div class="brand-info"><span class="brand-name fw-medium">${escapeHtml(brandName)}</span></div>`,
                        brandCode ? `<span class="brand-code">${escapeHtml(brandCode)}</span>` : '-',
                        displayDescription,
                        itemCount,
                        `<div class="d-flex align-items-center justify-content-center gap-1">
                            <div class="brand-toggle" data-brand-id="${brandId}">
                                <div class="form-check form-switch d-inline-block" style="margin-right: 2px;">
                                    <input class="form-check-input statusToggle" 
                                           type="checkbox" 
                                           ${brandStatus === 'active' ? 'checked' : ''} 
                                           data-brand-id="${brandId}"
                                           style="transform: scale(1.1); cursor: pointer; margin-top: 0;"
                                           ${isDeleted ? 'disabled' : ''}
                                           title="${isDeleted ? 'Cannot toggle deleted items' : (isActive ? 'Click to deactivate' : 'Click to activate')}">
                                </div>
                            </div>
                            <button class="btn btn-sm btn-icon btn-warning-light btnEditBrand" data-id="${brandId}" title="Edit" ${isInactive || isDeleted ? 'disabled' : ''}>
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-sm btn-danger-light btn-icon btnDeleteBrand" data-id="${brandId}" title="Delete" ${isDeleted ? 'disabled' : ''}>
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>`
                    ]).node();

                    // Safely reapply your attributes onto the freshly generated <tr> node
                    $(rowNode).attr('data-brand-id', brandId);
                    $(rowNode).find('td:nth-child(4)').css({ 'text-align': 'center' }); // Aligns item count cleanly
                    $(rowNode).find('td:last-child').addClass('text-center');
                });

                // 3. Re-render the canvas layout
                tableInstance.draw();

            } else {
                // Draws native clean "No brands found" message instead of raw HTML fallback strings
                tableInstance.draw();
            }
            
            // Sync dynamic dashboard headers/cards counts 
            loadBrandCounts();
        },
        error: function(xhr, status, error) {
            console.error('Filter error:', error);
            toastr.error('Failed to load brands');
        }
    });
}

    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
     
    
    function clearValidationErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
         
    }
    
     
    function displayValidationErrors(errors) {
    clearValidationErrors();
    
    // Check for specific error messages
    if (errors.includes('code already exists') || errors.includes('Duplicate entry')) {
        $('#code').addClass('is-invalid');
        $('#code-error').html('This brand code already exists. Please use a different code.');
    }
    
    if (errors.includes('Brand Name') || errors.includes('name')) {
        $('#name').addClass('is-invalid');
        $('#name-error').html('Brand name is required');
    }
    
    // If no field highlighted but there are errors, show general message
    if (!$('.is-invalid').length) {
        toastr.error(errors);
    }
}
    
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });
    
});
</script>         