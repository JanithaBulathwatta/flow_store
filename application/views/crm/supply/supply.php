<style>
  

.select2-dropdown {
    z-index: 99999999 !important;
}


.custom-sm-select + .select2-container .select2-selection__rendered {
    line-height: 33px !important;
    font-size: 0.875rem !important;
	 border-radius:  0.55rem !important;
}


 
  
</style>

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
                                <span class="card-title me-6">Suppliers Management</span>
                                
                                <div class="d-flex gap-2 flex-wrap align-items-center" id="supplier-status-container">
									<!-- Total Suppliers Pill -->
									<!--<div id="pill-total" class="stat-pill status-filter" data-status="active,inactive" style="cursor: pointer;">
										<span class="num" id="val-total">0</span>
										<span class="lbl">Total</span>
									</div>

									<!-- Active Suppliers Pill -->
									<!--<div id="pill-active" class="stat-pill status-filter" data-status="active" style="cursor: pointer;">
										<span class="num" id="val-active">0</span>
										<span class="lbl">Active</span>
									</div>

									<!-- Inactive Suppliers Pill -->
									<!--<div id="pill-inactive" class="stat-pill status-filter" data-status="inactive" style="cursor: pointer;">
										<span class="num" id="val-inactive">0</span>
										<span class="lbl">Inactive</span>
									</div>

									<!-- Deleted Suppliers Pill -->
									<!--<div id="pill-deleted" class="stat-pill status-filter" data-status="deleted" style="cursor: pointer;">
										<span class="num" id="val-deleted">0</span>
										<span class="lbl">Deleted</span>
									</div>-->
								</div>
                                
                            </div> 
                            
                            <!-- New Supplier Button -->
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-add" id="btnAddSupplier">
                                    <i class="ri-add-line me-1 fw-medium align-middle"></i>Add New Supplier
                                </button>
                            </div> 
                        </div> 
                    </div>
                </div>
				
				<div class="summary-bar" id="summary-bar"></div>
				
            </div>
        
            <!-- HIDDEN FILTER INPUTS -->
            <input type="hidden" id="statusFilter" value="active,inactive">
            <input type="hidden" id="searchFilter" value="">
            <input type="hidden" id="dateRange" value="">
        
            <!-- Suppliers Table -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="supplyTable" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Bank Details</th>
										<th class="text-center">Total Purchases (LKR)</th>
                                        <th class="text-center">Total Paid (LKR)</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                      
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Supplier Form Modal (Add/Edit) -->
<div class="modal fade" id="supplierFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="supplierModalTitle">New Supplier</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="supplierForm">
                <div class="modal-body">
                    <input type="hidden" id="supplier_id" name="id">
					
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required maxlength="100">
                        </div>

                        <div class="col-md-6 mb-3">
                           <label class="form-label">Email (Optional)</label>
                           <input type="email" name="email" id="email" class="form-control"
                                  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                  title="Please enter a valid email address">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone" class="form-control" required
                                   pattern="[0-9+\-\s]{10,15}" 
                                   title="Please enter a valid phone number (10-15 digits)">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea name="address" id="address" class="form-control" rows="1" required maxlength="255"></textarea>
                        </div>
						
						
						<div class="col-md-6 mb-3">
                            <label class="form-label">Credit Period <span class="text-danger">*</span></label>
                            <input type="number" name="cre_period" id="Cre-period" class="form-control" required>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 mt-2">Bank Details (Optional)</h6>

                    <div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label">Bank Name</label>
							<select name="bank_name" id="bank_name" class="form-select select2 custom-sm-select" aria-label=".form-select-sm example"> 
								<option value="">-- None --</option>
								<?php if (!empty($banks)): ?>
									<?php foreach ($banks as $bank): ?>
										<option value="<?= html_escape($bank->bank_name) ?>">
											<?= html_escape($bank->bank_name) ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>

						<div class="col-md-6 mb-3 bank-field" style="display: none;">
							<label class="form-label">Bank Branch</label>
							<input type="text" name="bank_branch" id="bank_branch" class="form-control">
						</div>

						<!--<div class="col-md-6 mb-3 bank-field" style="display: none;">
							<label class="form-label">Account Number</label>
							<input type="text" name="account_number" id="account_number" class="form-control" pattern="[0-9]{7,100}" title="Please enter a valid account number (7-10 digits)">
						</div>-->
					</div>

					<div class="row">
						<div class="col-md-6 mb-3 bank-field" style="display: none;">
							<label class="form-label">Account Holder Name</label>
							<input type="text" name="account_holder" id="account_holder" class="form-control">
						</div>
						
						<div class="col-md-6 mb-3 bank-field" style="display: none;">
							<label class="form-label">Account Number</label>
							<!--<input type="text" name="account_number" id="account_number" class="form-control" pattern="[0-9]{7,100}" title="Please enter a valid account number (7-10 digits)">-->
							<input type="text" name="account_number" id="account_number" class="form-control">
						</div>
					</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub">
                        <i class="ri-save-line me-1"></i> Add Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
	$(document).ready(function () {
		var table = initializeDataTable('#supplyTable');

		// Initialize modals
		const formModal = new bootstrap.Modal(document.getElementById('supplierFormModal'));
		
		// Set default filter to show active and inactive (excluding deleted) on page load
		$('#statusFilter').val('active,inactive');

		// Load supplier counts
		loadSupplierCounts();
		
		filterSuppliers(); 

		  
	$('#supplier-status-container').on('click', '.status-filter', function () {
		let status = $(this).data('status');
		$('#statusFilter').val(status);

		 
		$('.status-filter').removeClass('active');
		$(this).addClass('active');

		// Call filter function
		filterSuppliers();
	});
     

    // Add New Supplier
    $('#btnAddSupplier').click(function () {
        $('#supplierForm')[0].reset();
        $('#supplier_id').val('');
        $('#supplierModalTitle').text('New Supplier');
		$('#bank_name').val('').trigger('change');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Add Supplier');
        
         toggleBankFields();
		
		formModal.show();
		
		$('.select2').select2({
			dropdownParent: $('#supplierFormModal'),
			width: '100%'
		});
		
    });

    // Submit form
    $('#supplierForm').ajax_submit({
    url: '/Supply/store',
    rest: false,
    callback: function(response) {
        $('#supplierForm')[0].reset();
        $('#supplier_id').val('');
        $('#bank_name').val('').trigger('change');
        formModal.hide();
        filterSuppliers();   
        loadSupplierCounts();
    }
});

	// --- NEW: URL CHECK CONDITION ---(22/4/2026) -> SANTHOSH
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('edit');

    if (editId) {
        openEditSupplier(editId);
        // Clean the URL so it doesn't re-open on refresh
        window.history.replaceState({}, document.title, window.location.pathname);
    }
	
	$(document).on('click', '.btnEditSupplier', function () {
        let id = $(this).data('id');
        openEditSupplier(id);
    });
	//-----END OF URL CHECK -----
	
	function toggleBankFields() {
        var selectedBank = $('#bank_name').val();
        if (selectedBank && selectedBank !== '') {
            $('.bank-field').show();
            // Make fields required when bank is selected
            $('#bank_branch').prop('required', true);
            $('#account_number').prop('required', true);
            $('#account_holder').prop('required', true);
        } else {
            $('.bank-field').hide();
            // Remove required when no bank selected
            $('#bank_branch').prop('required', false);
            $('#account_number').prop('required', false);
            $('#account_holder').prop('required', false);
            // Clear values when hiding
            $('#bank_branch').val('');
            $('#account_number').val('');
            $('#account_holder').val('');
        }
    }
    
    // Initial call
    toggleBankFields();
    
    // Listen for change on bank select
    $('#bank_name').on('change', function() {
        toggleBankFields();
    });
    
    // Also handle when modal is opened for edit
    $('#supplierFormModal').on('shown.bs.modal', function() {
        toggleBankFields();
    });

    // Edit Supplier
    function openEditSupplier(id) {
       
        $('#supplierModalTitle').text('Edit Supplier');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Update Supplier');   
        $('#supplier_id').val(id);
        
        $('#supplierForm')[0].reset();
        formModal.show();
         
        $.getJSON("<?= site_url('Supply/get_supplier?id='); ?>" + id, function (res) {
            if (res.success) {
                $('#name').val(res.supplier.name);
                $('#phone').val(res.supplier.phone);
                $('#email').val(res.supplier.email);
                $('#address').val(res.supplier.address);
                $('#Cre-period').val(res.supplier.cre_period);
                
                if (res.supplier.bank_name) {
                    $('#bank_name').val(res.supplier.bank_name).trigger('change');
                }
                
                $('#bank_branch').val(res.supplier.bank_branch);
                $('#account_number').val(res.supplier.account_number);
                $('#account_holder').val(res.supplier.account_holder);
            } else {
                toastr.error(res.message || 'Failed to load supplier data');
            }
        }).fail(function() {
            toastr.error('Server error occurred');
        });
    }

    // Delete Supplier
    $(document).on('click', '.btnDeleteSupplier', function () {            
        const id = $(this).data('id');
        deleteSupplier(this, id);
    });

    function deleteSupplier(el, id){
        $(el).del_modal({
            title : 'Delete',
            head  : 'Delete Supplier',
            para  : 'Do you want to delete this supplier?',
            id    : id,
            url   : '<?= base_url("index.php/Supply/delete?id="); ?>' + id,
            callback: function () {
                 $('#statusFilter').val('active,inactive');
                 filterSuppliers();   
                 loadSupplierCounts();   
            }
        });
    }

    // Due Payment button
    $(document).on('click', '.btnDuePayment', function () {
        let id = $(this).data('id');
        if (!$(this).prop('disabled')) {
            toastr.info('Due payment feature coming soon for supplier ID: ' + id);
        }
    });

    // Status toggle change handler
$(document).on('change', '.statusToggle', function() {
    const $toggle = $(this);
    const supplierId = $toggle.data('supplier-id');  
    const isChecked = $toggle.is(':checked');
    const newStatus = isChecked ? 'active' : 'inactive';

    // Don't proceed if supplierId is missing
    if (!supplierId) {
        toastr.error('Supplier ID is missing');
        $toggle.prop('checked', !isChecked);  
        return;
    }

    $toggle.prop('disabled', true);

    $.ajax({
        url: "/Supply/update_status",
        type: "POST",
        data: {
            id: supplierId,
            status: newStatus
        },
        dataType: "json",
        success: function(res) {
            if (res.success) {
                toastr.success('Status updated successfully');
                loadSupplierCounts();
                filterSuppliers();  
            } else {
                $toggle.prop('checked', !isChecked);  
                toastr.error(res.message || 'Failed to update status');
            }
        },
        error: function(xhr, status, error) {
            $toggle.prop('checked', !isChecked); // Revert on error
            toastr.error('Something went wrong: ' + error);
            console.error('AJAX Error:', xhr.responseText);
        },
        complete: function() {
            $toggle.prop('disabled', false);
        }
    });
});

    // Helper function
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Initialize daterangepicker
    $('.date-range-input').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        }
    });

    $('.date-range-input').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' – ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('.date-range-input').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});

// Load supplier counts
/*function loadSupplierCounts() {
    $.ajax({
        url: "/Supply/get_counts",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Calculate total (Active + Inactive)
            let totalActiveInactive = (parseInt(response.active_count) || 0) + (parseInt(response.inactive_count) || 0);
            
            // Update the text values in the pills
            $('#val-total').text(totalActiveInactive);
            $('#val-active').text(response.active_count || 0);
            $('#val-inactive').text(response.inactive_count || 0);
            $('#val-deleted').text(response.deleted_count || 0);
        },
        error: function() {
            console.error('Failed to load supplier counts');
        }
    });
}*/

/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadSupplierCounts() {
    $.ajax({
        url: "/Supply/get_counts",
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Customers' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Customers' },
        total_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'All Customers' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Customers' },
       
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Customers' };
		

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


function filterSuppliers() {
	
	 if ($.fn.DataTable.isDataTable('#supplyTable')) {
        $('#supplyTable').DataTable().destroy();
    }

    let status = $('#statusFilter').val();
    let search = $('#searchFilter').val();
    let dateRange = $('#dateRange').val();

    $.ajax({
        url: "/Supply/get_filtered_suppliers",
        type: "POST",
        data: {
            status: status,
            search: search,
            date_range: dateRange
        },
        dataType: "json",
        success: function(res) {

            if (!res.success) {
                toastr.error('Failed to load suppliers');
                return;
            }

            let html = '';

            if (res.data.length === 0) {
                html = `<tr>
                            <td colspan="7" class="text-center text-muted">
                                No suppliers found
                            </td>
                        </tr>`;
            } else {

                $.each(res.data, function(index, supplier){

                    let isActive = supplier.status === 'active';
                    let isDeleted = supplier.status === 'deleted';
					let isInactive = supplier.status === 'inactive';

                    // For deleted suppliers, disable ALL buttons
                    let allDisabled = isDeleted ? true : false;
                    
                    let editDisabled = allDisabled ? 'disabled' : (!isActive ? 'disabled' : '');
                    let editStyle = allDisabled ? 'style="opacity:0.5;cursor:not-allowed;"' : (!isActive ? 'style="opacity:0.5;cursor:not-allowed;"' : '');

                    let dueDisabled = allDisabled ? 'disabled' : (!isActive ? 'disabled' : '');
                    let dueStyle = allDisabled ? 'style="opacity:0.5;cursor:not-allowed;"' : (!isActive ? 'style="opacity:0.5;cursor:not-allowed;"' : '');

                    let toggleDisabled = allDisabled ? 'disabled' : '';
                    
                    let viewDisabled = allDisabled ? 'disabled' : '';
                    let viewStyle = allDisabled ? 'style="opacity:0.5;cursor:not-allowed;"' : '';
                    
                    let deleteDisabled = allDisabled ? 'disabled' : '';
                    let deleteStyle = allDisabled ? 'style="opacity:0.5;cursor:not-allowed;"' : '';
					
					
                     

                   // Status badge colors using ERP theme classes
					let statusBadge = supplier.status === 'active' 
						? '<span class="badge bg-success rounded-pill fs-11">Active</span>'
						: supplier.status === 'inactive'
						? '<span class="badge bg-orange rounded-pill fs-11">Inactive</span>'
						: '<span class="badge bg-danger rounded-pill fs-11">Deleted</span>';
						
						
						// Format currency
                    let totalPurchases = parseFloat(supplier.total_purchases || 0).toLocaleString('en-LK', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    let totalPaid = parseFloat(supplier.total_paid || 0).toLocaleString('en-LK', {minimumFractionDigits: 2, maximumFractionDigits: 2});
					
					
                    html += `
    <tr>
        <!--<td class="align-middle">${supplier.id}</td>-->
        <td class="align-middle">
           <span class="fw-medium">${supplier.name}</span><br>
           <small class="text-muted">
               <i class="bi bi-telephone"></i> ${supplier.phone ?? ''}
                ${supplier.email ? `<br><i class="bi bi-envelope"></i> ${supplier.email}` : ''}
           </small><br>
             
        </td>
        <td class="align-middle">${supplier.address ?? ''}</td>
        <td class="align-middle">
            ${supplier.bank_name ? `${supplier.bank_name}<br>${supplier.account_number || ''}<br><small>${supplier.bank_branch || ''}</small>` : '-'}
        </td>
        <td class="align-middle fw-normal" style="color:var(--primary); text-align: right;">
        ${totalPurchases}
    </td>
    <td class="align-middle fw-normal" style="color:var(--success); text-align: right;">
        ${totalPaid}
    </td>
        <td class="text-center align-middle">
            <div class="d-flex gap-1 align-items-center">
                <span class="form-check form-switch m-0">
                    <input class="form-check-input statusToggle"
                        type="checkbox"
                        ${supplier.status === 'active' ? 'checked' : ''}
                        data-supplier-id="${supplier.id}"
                        ${toggleDisabled}
                        title="Toggle Status">
                </span>
                <button class="btn btn-sm btn-icon btn-info-light btnViewSupplier" 
                    data-id="${supplier.id}" 
                    ${viewDisabled}
                    ${viewStyle}
                    title="View Supplier Profile">
                    <i class="ri-eye-line"></i>
                </button>
                <button class="btn btn-sm btn-icon btn-warning-light btnEditSupplier"
                    data-id="${supplier.id}"
                    ${editDisabled}
                    ${editStyle}
                    title="Edit Supplier">
                    <i class="ri-edit-line"></i>
                </button>
                <button class="btn btn-sm btn-danger-light btn-icon btnDeleteSupplier"
                    data-id="${supplier.id}"
                    ${deleteDisabled}
                    ${deleteStyle}
                    title="Delete Supplier">
                    <i class="ri-delete-bin-line"></i>
                </button>
                <button class="btn btn-sm btn-success-light btn-icon btnDuePayment"
                    data-id="${supplier.id}"
                    ${dueDisabled}
                    ${dueStyle}
                    title="Make Payment">
                    <i class="ri-money-dollar-circle-line"></i>
                </button>
            </div>
        </td>
    </tr>`;
                });
            }

            $('#supplyTable tbody').html(html);
			
			table = initializeDataTable('#supplyTable');
        }
    });
	
	// View Supplier Profile
	$(document).on('click', '.btnViewSupplier', function () {
		let id = $(this).data('id');
 
		// Redirect to profile page with supplier ID  
		window.location.href = "/Supply/supplier_profile?id=" + id;
	}); 



}

</script>