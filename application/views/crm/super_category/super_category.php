
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-12 mt-3">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body"> 
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                            <div class="d-flex align-items-center"> 
                                <span class="card-title me-6">Super Category</span>
                                
                                <div class="d-flex gap-2 flex-wrap" id="category-status-container">
                                    <div class="d-flex gap-2 flex-wrap align-items-center" id="category-status-container">
										<!-- Total Pill -->
										<!--<div id="pill-total" class="stat-pill status-filter" data-status="">
											<span class="num" id="val-total">0</span>
											<span class="lbl">Total</span>
										</div>

										<!-- Active Pill -->
										<!--<div id="pill-active" class="stat-pill status-filter" data-status="active">
											<span class="num" id="val-active">0</span>
											<span class="lbl">Active</span>
										</div>

										<!-- Inactive Pill -->
										<!--<div id="pill-inactive" class="stat-pill status-filter" data-status="inactive">
											<span class="num" id="val-inactive">0</span>
											<span class="lbl">Inactive</span>
										</div>

										<!-- Deleted Pill -->
										<!--<div id="pill-deleted" class="stat-pill status-filter" data-status="deleted">
											<span class="num" id="val-deleted">0</span>
											<span class="lbl">Deleted</span>
										</div>-->
									</div>
                                </div>
                                
                            </div> 
                            
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-add" id="btnAddCategory"><i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Super Category</button>
                            </div> 
                        </div> 
                    </div>
					
					<div class="summary-bar" id="summary-bar"></div>
					
                </div>
            </div>
        
             <input type="hidden" id="statusFilter" value="">
            <input type="hidden" id="searchFilter" value="">
            <input type="hidden" id="dateRange" value="">
                            
                             
        
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="categoriesTable" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th class="text-center">Status</th>    <!-- Add text-center -->
                                        <th style="width: 100px;" class="text-center">Item Count</th>
                                        <th class="text-center"><div style="margin-left: 150px;">Actions</div></th>
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

<!-- Category Form Modal -->
<div class="modal fade" id="categoryFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="categoryForm">
                <div class="modal-header">
                    <h6 class="modal-title" id="categoryModalTitle">Super Category</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="category_id" name="cid">
					<input type="hidden" id="form_status" name="status" value="active">

                    <div class="row gy-3">
                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="form-control form-control-sm" 
                                   required 
                                   maxlength="100"
                                   title="Please enter a category name">
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>

                        <div class="col-xl-12 mt-1">
                           <label class="form-label">Category Code <span class="text-danger">*</span></label>
                           <input type="text" 
                                  name="code" 
                                  id="code" 
                                  class="form-control form-control-sm" 
                                  required>
                          <div class="invalid-feedback" id="code-error"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub"> 
                        <i class="ri-save-line me-1"></i> Save 
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    
     
    var table = initializeDataTable('#categoriesTable');

    const formModal = new bootstrap.Modal(document.getElementById('categoryFormModal'));

    // Load category counts
		/*function loadCategoryCounts() {
			$.ajax({
				url: "<?= site_url('Super_category/get_category_counts_ajax'); ?>",
				type: "GET",
				dataType: "json",
				success: function(response) {
					let total = 0;

					response.forEach(function(status) {
						const name = (status.name || '').toLowerCase();
						
						// Update specific pill counts
						// Targets IDs like #val-active, #val-inactive, #val-deleted
						$('#val-' + name).text(status.total);
						
						// Optional: Store the ID if needed for filtering
						$('#pill-' + name).data('id', status.lid);

						// Calculate total for Active and Inactive categories
						if (name === 'active' || name === 'inactive') {
							total += parseInt(status.total) || 0;
						}
					});

					// Update the Total count element
					$('#val-total').text(total);
				},
				error: function() {
					console.error('Failed to load category counts');
				}
			});
		}*/

    loadCategoryCounts();
	
	
	
	/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadCategoryCounts() {
    $.ajax({
        url: "Super_category/get_category_counts_ajax",
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
    // 1. Convert the dynamic GRN_ITEMS array into an easy-to-lookup object: { active: 1, deleted: 1 }
    var countsMap = {};
    GRN_ITEMS.forEach(function(item) {
        if (item.name) {
            countsMap[item.name.toLowerCase()] = parseInt(item.total || 0, 10);
        }
    });

    // 2. Define your master config. This acts as your blueprint so components NEVER disappear.
    var itemsConfig = {
        active:   { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Category',   lbl: 'Active count' },
        inactive: { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Category', lbl: 'Inactive count' },
        deleted:  { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Category',  lbl: 'Deleted count' }
       
    };

    // 3. Loop over your master config keys instead of GRN_ITEMS.
    
    var displayItems = Object.keys(itemsConfig).map(function(key) {
        var cfg = itemsConfig[key];
        
        // Grab the value from our database map. If it doesn't exist, default it to 0!
        var finalVal = countsMap[key] !== undefined ? countsMap[key] : 0;

        return {
            icon: cfg.icon,
            ibg: cfg.bg,
            ic: cfg.ic,
            val: finalVal, 
            lbl: STATUS_LABELS[key] || cfg.lbl,
            sub: cfg.sub,
            extra: ''
        };
    });

    // Your exact template literal generator layout
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
    
    // Click handler for status filters
    $(document).on('click', '.status-filter', function () {
        let status = $(this).data('status');
        console.log("Filtering by status:", status);
        
        $('#statusFilter').val(status);
        filter();
    });

     
 
	
	// Submit category for save or Update)
$('#categoryForm').ajax_submit({
    url: '/Super_category/store',  // Same URL for both add and edit
    rest: false,
    callback: function(id) {
        $('#categoryForm')[0].reset();
        $('#category_id').val('');
        formModal.hide();
        filter();
        loadCategoryCounts();
         
    }
});

    // Add new category
    $('#btnAddCategory').click(function () {
        $('#categoryModalTitle').text('New Category');
        $('#btn-sub').text('Save');
        $('#categoryForm')[0].reset();
        $('#category_id').val('');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        formModal.show();
    });

    // Edit category  
    $(document).on('click', '.btnEditCategory', function () {
        let id = $(this).data('id');

        $('#categoryModalTitle').text('Edit Category');
        $('#btn-sub').text('Update');
        $('#category_id').val(id);
        
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');

        $.getJSON("<?= site_url('/Super_category/view?lid='); ?>" + id, function (res) {
            if (res.success) {
                $('#name').val(res.category.name);
                $('#code').val(res.category.code);
                formModal.show();
            } else {
                toastr.error(res.message || 'Failed to load category data');
            }
        });
    });

    // Filter form submission
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });

    // Delete category
    $(document).on('click', '.btnDeleteCategory', function () {            
        const id = $(this).data('id');
        deleteCategory(this, id);
    });

    function deleteCategory(el, id) {
         
            $(el).del_modal({
                title: 'Delete',
                head: 'Delete Category',
                para: 'Do you want to delete this category?',
                id: id,
                url: '<?= site_url("Super_category/delete?id="); ?>' + id,
                callback: function () {
                    filter();
                    loadCategoryCounts();
                }
            });
         
    }

    $(document).on('change', '.statusToggle', function() {
        const $toggle = $(this);
        const categoryId = $toggle.data('category-id');
        const isChecked = $toggle.is(':checked');
        const newStatus = isChecked ? 'active' : 'inactive';

        $toggle.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('Super_category/update_status/'); ?>",
            type: "POST",
            data: {
                id: categoryId,
                status: newStatus
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    toastr.success('Status updated successfully');
                    loadCategoryCounts();
                    
                    let $badge = $toggle.closest('td').find('.status-badge');
                    if ($badge.length) {
                        $badge.removeClass('bg-success bg-danger')
                              .addClass(newStatus === 'active' ? 'bg-success' : 'bg-danger')
                              .text(newStatus === 'active' ? 'Active' : 'Inactive');
                    }
                    filter();
                } else {
                    $toggle.prop('checked', !isChecked);
                    toastr.error(res.message || 'Failed to update status');
                }
            },
            error: function() {
                $toggle.prop('checked', !isChecked);
                toastr.error('Something went wrong');
            },
            complete: function() {
                $toggle.prop('disabled', false);
            }
        });
    });

    // Filter function with Edit button disabled when inactive  
function filter() {
    if ($.fn.DataTable.isDataTable('#categoriesTable')) {
        $('#categoriesTable').DataTable().destroy();
    }

    $.ajax({
        url: "<?= site_url('Super_category/filter'); ?>",
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
                $.each(res.data, function (i, category) {
                    let toggleOnClass = category.status === 'active' ? "on" : "";
                    
                    // Updated status badge logic to include Deleted
                    let statusBadge = '';
                    if (category.status === 'active') {
                        statusBadge = '<span class="badge bg-success status-badge">Active</span>';
                    } else if (category.status === 'inactive') {
                        statusBadge = '<span class="badge bg-danger status-badge">Inactive</span>';
                    } else if (category.status === 'deleted') {
                        statusBadge = '<span class="badge bg-dark status-badge">Deleted</span>';
                    }
                    
                    // Button states based on status
                    const isActive = category.status === 'active';
                    const isDeleted = category.status === 'deleted';
                    
                    // For inactive: disable edit, keep delete enabled
                    // For deleted: disable both edit and delete
                    const editDisabled = (!isActive || isDeleted) ? 'disabled' : '';
                    const editStyle = (!isActive || isDeleted) ? 'opacity: 0.5; cursor: not-allowed;' : '';
                    
                    const deleteDisabled = isDeleted ? 'disabled' : '';
                    const deleteStyle = isDeleted ? 'opacity: 0.5; cursor: not-allowed;' : '';
                    
                    // Toggle state
                    const toggleDisabled = isDeleted ? 'disabled' : '';
                    const toggleChecked = category.status === 'active' ? 'checked' : '';
                    
                    tbody += `
                        <tr>
                            <td>${escapeHtml(category.code || category.id)}</td>
                            <td>
                                <span class="fw-medium">${escapeHtml(category.name)}</span>
                            </td>
                            <td>
                                ${statusBadge}
                            </td>
                            <td class="align-middle fw-bold" style="text-align: right; padding-right: 15px;">
                                 ${category.item_count || 0}
                             </td>
                            <td class="d-flex align-items-center gap-2">
							    <div style="width: 70px;"></div> <!-- Spacer -->
                                <!-- Toggle Switch -->
                                <span class="form-check form-switch m-0 d-flex align-items-center">
                                    <input class="form-check-input statusToggle m-0" 
                                        type="checkbox" 
                                        ${toggleChecked} 
                                        data-category-id="${category.id}"
                                        ${toggleDisabled}
										title="${isDeleted ? 'Cannot toggle deleted items' : (isActive ? 'Click to deactivate' : 'Click to activate')}">
										
                                </span>
                                
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-icon btn-warning-light btnEditCategory" 
                                    data-id="${category.id}"
                                    ${editDisabled}
                                    style="${editStyle}"
                                    title="${!isActive ? (isDeleted ? 'Deleted items cannot be edited' : 'Activate to edit') : 'Edit'}">
                                    <i class="ri-edit-line"></i>
                                </button>
                                
                                <!-- Delete Button -->
                                <button class="btn btn-sm btn-danger-light btn-icon btnDeleteCategory" 
                                    data-id="${category.id}"
                                    ${deleteDisabled}
                                    style="${deleteStyle}"
                                    title="${isDeleted ? 'Already deleted' : 'Delete'}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </td>
                        </tr>`;
                });
            } 

            $('#categoriesTable tbody').html(tbody);
        
            // Reinitialize DataTable
            table = initializeDataTable('#categoriesTable');
            
            // REMOVED loadCategoryCounts() from here to avoid loop
        },
        error: function(xhr, status, error) {
            console.error('Filter error:', error);
            toastr.error('Failed to load categories');
        }
    });
}

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Initial load
    filter();

    $('#resetBtn').click(function() {
        $('#searchFilter').val('');
        $('#statusFilter').val('');
        $('#dateRange').val('');
        filter();
    });

});
</script>  