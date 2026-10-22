 
 <link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-12 mt-3">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body"> 
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                            <div class="d-flex align-items-center"> 
                                <span class="card-title me-6">Expense Management</span>

                                
								<div class="d-flex gap-2 flex-wrap align-items-center" id="expense-status-container">
									<!--<div id="pill-total" class="stat-pill status-filter" data-status="">
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
                           <!-- <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-success" href="<?php echo base_url('expense/get_ui'); ?>">
                                    <i class="ri-add-line me-1 fw-medium align-middle"></i>expence manager
                                </button>
                            </div> -->
							<div class="d-flex flex-wrap gap-2 align-items-center">
									<a href="<?php echo base_url('Expense/get_ui'); ?>" class="btn btn-add btn-wave" id="btn_expence_manager">
										<i class="ri-add-line me-1 fw-medium align-middle"></i>Expense Manager
									</a>
							</div>
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
								<button class="btn btn-add btn-wave" id="btnAddExpense">
									<i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Expense Type
								</button>
                            </div>  
                        </div> 
                    </div>
					
					<div class="summary-bar" id="summary-bar"></div>
					
                </div>
            </div>
        
            <!-- HIDDEN FILTER INPUTS -->
            <input type="hidden" id="statusFilter" value="">
            <input type="hidden" id="searchFilter" value="">
            <input type="hidden" id="dateRange" value="">
        
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">Expenses List</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="expensesTable" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Expense Type</th>
                                        <th>Expense Category</th>
                                        <th class="text-center">Status</th>
                                        <th>Actions</th>
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

<div class="modal fade" id="expenseFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="expenseForm">
                <div class="modal-header">
                    <h6 class="modal-title" id="expenseModalTitle">New Expense Type</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="expense_id" name="eid">

                    <div class="row gy-3">
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Expense Type Name <span class="text-danger">*</span></label>
                            <input type="text" id="expense_type_name" name="expense_type_name" 
                                   class="form-control form-control-sm" placeholder="Enter expense type name" required>
                            <div class="invalid-feedback" id="expense_type_name-error"></div>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Expense Category <span class="text-danger">*</span></label>
                            <select id="expense_category_id" name="expense_category_id" class="form-control form-select-sm js-example-basic-single" required>
                                <option value="">-- Select Category --</option>
                                <?php if(isset($categories) && !empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->id; ?>"><?= html_escape($category->name); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="invalid-feedback" id="expense_category_id-error"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub">
                        <i class="ri-save-line me-1"></i> Add Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {
    
    var table = initializeDataTable('#expensesTable');
    const formModal = new bootstrap.Modal(document.getElementById('expenseFormModal'));
	
	$(document).on('select2:open', () => {
      document.querySelectorAll('.select2-container--open').forEach(el => {
        el.style.zIndex = '999999';
      });
    });

     

// Load expense counts for mini cards
/*function loadExpenseCounts() {
    $.ajax({
        url: "<?= site_url('Expense/get_expense_counts_ajax'); ?>",
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
            console.error('Failed to load expense counts');
        }
    });
}*/


/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadExpenseCounts() {
    $.ajax({
        url: "Expense/get_expense_counts_ajax",
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Expense' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Expense' },
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'All Expense' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Expense' },
       
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Expense' };
		

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

	
	loadExpenseCounts();

    // Click handler for status filters - EXACTLY like Projects code
    $(document).on('click', '.status-filter', function () {
        let status = $(this).data('status');
        console.log("Filtering by status:", status);
        
        // Set the status filter value
        $('#statusFilter').val(status);
        
        // Reload table with filter
        filter();
    });
    
    // Filter function - Updated version
function filter() {
    if ($.fn.DataTable.isDataTable('#expensesTable')) {
        $('#expensesTable').DataTable().destroy();
    }

    $.ajax({
        url: "<?= site_url('Expense/filter'); ?>",
        type: "POST",
        data: {
            date: $('.date-range-input').val(),
            category_id: $('#categoryFilter').val(),
            status: $('#statusFilter').val()
        },
        dataType: "json",
        success: function(res) {
            let tbody = '';

            if (res.data && res.data.length > 0) {
                
				let filteredExpenses = res.data;
                let selectedStatus = $('#statusFilter').val();
                
                if (selectedStatus && selectedStatus !== '') {
                    let statusMap = {
                        'active': 'Active',
                        'inactive': 'Inactive',
                        'deleted': 'Deleted'
                    };
                    filteredExpenses = res.data.filter(expense => expense.status === statusMap[selectedStatus]);
                }
                
                $.each(filteredExpenses, function (i, expense) {
                    let isDeleted = expense.status === 'Deleted';
                    
                    let statusBadge = '';
                    if (expense.status === 'Active') {
                        statusBadge = '<span class="badge bg-success status-badge">Active</span>';
                    } else if (expense.status === 'Inactive') {
                        statusBadge = '<span class="badge bg-danger status-badge">Inactive</span>';
                    } else if (expense.status === 'Deleted') {
                        statusBadge = '<span class="badge bg-dark status-badge">Deleted</span>';
                    }
                    
                    const isActive = expense.status === 'Active';
                    const editDisabled = (!isActive || isDeleted) ? 'disabled' : '';
                    const deleteDisabled = isDeleted ? 'disabled' : '';
                    const toggleDisabled = isDeleted ? 'disabled' : '';
                    const toggleChecked = expense.status === 'Active' ? 'checked' : '';
                    
                    tbody += `
                        <tr>
                            <td>${escapeHtml(expense.id)}</td>
                            <td>
                                <span class="fw-medium">${escapeHtml(expense.expense_type_name || '-')}</span>
                            </td>
                            <td>
                                <span class="fw-medium">${escapeHtml(expense.expense_category_name || '-')}</span>
                            </td>
                            <td>
                                ${statusBadge}
                            </td>
                            <td class="d-flex align-items-center gap-2">
                                <!-- Toggle Switch -->
                                <span class="form-check form-switch m-0 d-flex align-items-center">
                                    <input class="form-check-input statusToggle m-0" 
                                        type="checkbox" 
                                        ${toggleChecked} 
                                        data-expense-id="${expense.id}"
                                        ${toggleDisabled}
                                        style="transform: scale(1.2); cursor: pointer;"
                                        title="${isDeleted ? 'Cannot toggle deleted items' : (isActive ? 'Click to deactivate' : 'Click to activate')}">
                                </span>
                                
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-icon btn-warning-light btnEditExpense" 
                                    data-id="${expense.id}"
                                    ${editDisabled}
                                    style="${editDisabled ? 'opacity: 0.5; cursor: not-allowed;' : ''}"
                                    title="${!isActive ? (isDeleted ? 'Deleted items cannot be edited' : 'Activate to edit') : 'Edit'}">
                                    <i class="ri-edit-line"></i>
                                </button>
                                
                                <!-- Delete Button -->
                                <button class="btn btn-sm btn-danger-light btn-icon expense-delete" 
                                    data-id="${expense.id}"
                                    ${deleteDisabled}
                                    style="${deleteDisabled ? 'opacity: 0.5; cursor: not-allowed;' : ''}"
                                    title="${isDeleted ? 'Already deleted' : 'Delete'}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </td>
                        </td>`;
                });
            } else {
                tbody = `<tr>
                    <td colspan="5" class="text-center text-muted py-4">No expenses found</td>
                </tr>`;
            }

            $('#expensesTable tbody').html(tbody);
            table = initializeDataTable('#expensesTable');
            
            // Update counts
            loadExpenseCounts();
        },
        error: function() {
            toastr.error('Error loading expenses');
        }
    });
}

    // Status toggle change handler - Updated version
$(document).on('change', '.statusToggle', function() {
    const $toggle = $(this);
    const expenseId = $toggle.data('expense-id');
    const isChecked = $toggle.is(':checked');
    const newStatus = isChecked ? 'active' : 'inactive';

    // Disable toggle during AJAX
    $toggle.prop('disabled', true);

    $.ajax({
        url: "<?= site_url('Expense/update_status/'); ?>",
        type: "POST",
        data: {
            id: expenseId,
            status: newStatus
        },
        dataType: "json",
        success: function(res) {
            if (res.success) {
                toastr.success('Status updated successfully');
                loadExpenseCounts();
                
                // Refresh with current filter
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

    // Initial load
    loadExpenseCounts();
    console.log('loadExpenseCounts function called');
    
    // Initial filter - show all expenses (active + inactive)
    filter();

    // Form submit handler
    $('#expenseForm').ajax_submit({
    url: '/Expense/store',  // Same URL for both add and edit
    rest: false,
    beforeSubmit: function(formData) {
        clearValidationErrors();
        return true;
    },
    callback: function(response) {
        $('#expenseForm')[0].reset();
        $('#expense_id').val('');
		$('#expense_category_id').val('').trigger('change');
        $('#statusFilter').val('');
        formModal.hide();
        filter();
        loadExpenseCounts();
         
    }
     
});

    // Add button click
    $('#btnAddExpense').click(function () {
        $('#expenseModalTitle').text('Add Expense');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Add Expense');
        $('#expenseForm')[0].reset();
        $('#expense_id').val('');
		$('#expense_category_id').val('').trigger('change');
        clearValidationErrors();
        formModal.show();
    });

    // Edit button click
    $(document).on('click', '.btnEditExpense', function () {
        let id = $(this).data('id');
        
        $('#expenseModalTitle').text('Edit Expense');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Update Expense');
        $('#expense_id').val(id);
        
        clearValidationErrors();
        formModal.show();

        $.ajax({
            url: "<?= site_url('Expense/view?eid='); ?>" + id,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if(res.success && res.expense) {
                    $('#expense_type_name').val(res.expense.Exp_Type_name);
                      $('#expense_category_id').val(res.expense.fk_exp_cat_id).trigger('change');
                } else {
                    toastr.error(res.message || 'Error loading expense data');
                    formModal.hide();
                }
            },
            error: function() {
                toastr.error('Error loading expense data');
                formModal.hide();
            }
        });
    });

    // Delete function
    $(document).on('click', '.expense-delete', function () {            
        const id = $(this).data('id');
        deleteExpense(this, id);
    });

    function deleteExpense(el, id) {
        $(el).del_modal({    
            title: 'Delete',
            head: 'Delete Expense',
            para: 'Do you want to delete this expense?',
            id: id,
            url: '<?php echo site_url("Expense/delete?id="); ?>' + id,
            toast: false,
            confirmButton: 'Delete',
            cancelButton: 'Cancel',
            callback: function(response) {
                filter();
                loadExpenseCounts();
            }
        });
    }

    // Filter form submit
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });

    // Helper functions
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
        toastr.error('Please check the form for errors');
        
        if (errors.toLowerCase().includes('expense type name')) {
            $('#expense_type_name').addClass('is-invalid');
            $('#expense_type_name-error').html('Expense type name is required');
        }
        
        if (errors.toLowerCase().includes('expense category')) {
            $('#expense_category_id').addClass('is-invalid');
            $('#expense_category_id-error').html('Expense category is required');
        }
    }

});

/*document.getElementById('btn_expence_manager').addEventListener('click', function() {
    // Redirect to your CodeIgniter controller/method
    window.location.href = "<?php echo base_url('expense/get_ui'); ?>";
});*/

/*$('#btn_expence_manager').on('click', function(e) {
    e.preventDefault();
    console.log("Button was clicked! Attempting to load UI..."); // Check if this shows in Console

    $.ajax({
        url: "<?php echo base_url('expense/get_ui'); ?>", // Double check this path!
        type: "GET",
        success: function(response) {
            console.log("Success! Received HTML.");
            $('#ui-container').html(response);
        },
        error: function(xhr) {
            console.log("Error Status: " + xhr.status);
            console.log("Error Detail: " + xhr.responseText);
        }
    });
});*/
</script>