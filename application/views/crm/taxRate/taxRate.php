 <link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-12 mt-3">
    <div class="card custom-card card-bg mb-20">
        <div class="card-body"> 
            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                <div class="d-flex align-items-center"> 
                    <span class="card-title me-6">Tax Rate Management</span>
                    
                    <div class="d-flex gap-2 flex-wrap align-items-center" id="tax-status-container">
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
                
                <div class="d-flex flex-wrap gap-2 align-items-center"> 
                    <button class="btn btn-add btn-wave" id="btnAddTax">
                        <i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Tax Rate
                    </button>
                </div> 
            </div> 
        </div>
		
		<div class="summary-bar" id="summary-bar"></div>
		
    </div>
</div>
        
             
            <div class="col-xl-12">
                <form id="data-filter" style="display: none;">
                    <input type="hidden" id="searchFilter" name="search">
                    <input type="hidden" id="statusFilter" name="status">
                    <input type="hidden" id="dateRange" name="date">
                </form>
            </div>
        
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="taxTable" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tax Name</th>
                                        <th>Tax Rate</th>
                                        <th>Tax Type</th>
                                        <th>Description</th>
                                        <th>Created Date</th>
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

<div class="modal fade" id="taxFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="taxForm">
                <div class="modal-header">
                    <h6 class="modal-title" id="taxModalTitle">Add Tax Rate</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="tax_id" name="tid">

                    <div class="row gy-3">
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Tax Type <span class="text-danger">*</span></label>
                            <select name="tax_type" id="tax_type" class="form-control form-control-sm js-example-basic-single" required>
                                <option value="">Select Tax Type</option>
                                <option value="sales">Sales Tax</option>
                                <option value="purchase">Purchase Tax</option>
                            </select>
                            <div class="invalid-feedback" id="tax_type-error"></div>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Tax Name <span class="text-danger">*</span></label>
                            <input type="text" name="tax_name" id="tax_name" class="form-control form-control-sm" placeholder="Enter tax name" required>
                            <div class="invalid-feedback" id="tax_name-error"></div>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Tax Code <span class="text-danger">*</span></label>
                            <input type="text" name="tax_code" id="tax_code" class="form-control form-control-sm" placeholder="Enter tax code" maxlength="20" required>
                            <div class="invalid-feedback" id="tax_code-error"></div>
                            <small class="text-black-normal">Unique code (e.g., GST18, VAT5)</small>
                        </div>
                        
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Tax Rate <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="100" name="tax_rate" id="tax_rate" class="form-control form-control-sm" placeholder="Enter tax rate" required>
                                <span class="input-group-text" id="rate-symbol">%</span>
                            </div>
                            <div class="invalid-feedback" id="tax_rate-error"></div>
                        </div>

                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control form-control-sm" rows="3" placeholder="Enter tax description (optional)"></textarea>
                            <div class="invalid-feedback" id="description-error"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub"> <i class="ri-save-line me-1"></i> Add Tax Rate </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    
    const formModal = new bootstrap.Modal(document.getElementById('taxFormModal'));

    var initialTaxes = <?php echo json_encode($taxes); ?>;
    var initialCounts = <?php echo json_encode($counts); ?>;
    
    var table = initializeDataTable('#taxTable');
    
    filter();
	
	 
    
    /*function loadTaxCounts() {
    $.ajax({
        url: "<?php echo site_url('Tax_rate/get_counts'); ?>",
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
            console.error('Failed to load tax counts');
        }
    });
}*/


/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadTaxCounts() {
    $.ajax({
        url: "Tax_rate/get_counts",
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Tax Rate' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Tax Rate' },
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'All Tax Rate' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Tax Rate' },
       
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Tax Rate' };
		

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
        lbl: 'Total Tax Rate Records',
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

    
    loadTaxCounts();

    // Click handler for status filters
    $(document).on('click', '.status-filter', function () {
        let status = $(this).data('status');
        console.log("Filtering by status:", status);
        
        // Set the status filter value
        $('#statusFilter').val(status);
        
        // Reload table with filter
        filter();
    });

    $('#tax_type').change(function() {
        if ($(this).val() === 'sales' || $(this).val() === 'purchase') {
            $('#rate-symbol').text('%');
        }
    });
    
    // Submit tax rate for save or Update  
$('#taxForm').ajax_submit({
    url: '/Tax_rate/store',  // Same URL for both add and edit
    rest: false,
    beforeSubmit: function(formData) {
        clearValidationErrors();
        return true;
    },
    callback: function(response) {
        $('#taxForm')[0].reset();
        $('#tax_id').val('');
        $('#tax_type').val('').trigger('change'); // Reset Select2
        $('#statusFilter').val('');
        formModal.hide();
        filter();
        loadTaxCounts();
         
    }
});
    
    $('#btnAddTax').click(function () {
        $('#taxModalTitle').text('Add Tax Rate');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Add Tax Rate');
        $('#taxForm')[0].reset();
        $('#tax_id').val('');
		$('#tax_type').val('').trigger('change'); // Reset Select2
        $('#rate-symbol').text('%');
        clearValidationErrors();
        formModal.show();
    });
    
    $(document).on('click', '.btnEditTax', function () {
        let id = $(this).data('id');
        
        $('#taxModalTitle').text('Edit Tax Rate');
        $('#btn-sub').html('<i class="ri-save-line me-1"></i> Update Tax Rate');
        $('#tax_id').val(id);
        
        clearValidationErrors();
        
        formModal.show();
        
        $.getJSON("<?= site_url('Tax_rate/get_tax?id='); ?>" + id, function (res) {
            if (res.success) {
                $('#tax_name').val(res.tax.tax_name);
                $('#tax_code').val(res.tax.tax_code);
                $('#tax_type').val(res.tax.tax_type).trigger('change'); // Set Select2
                $('#tax_rate').val(res.tax.tax_rate);
                $('#description').val(res.tax.description);
                
                $('#rate-symbol').text('%');
            } else {
                toastr.error(res.message || 'Failed to load tax data');
            }
        });
    });
    
    $(document).on('click', '.btnDeleteTax', function () {            
        const id = $(this).data('id');
        deleteTax(this, id);
    });

    $(document).on('change', '.statusToggle', function() {
    const $toggle = $(this);
    const taxId = $toggle.closest('.tax-toggle').data('tax-id');
    const isChecked = $toggle.is(':checked');
    const newStatus = isChecked ? 'active' : 'inactive';

    if (!taxId) {
        toastr.error('Tax ID not found');
        $toggle.prop('checked', !isChecked);
        return;
    }

    $toggle.prop('disabled', true);

    $.ajax({
        url: "<?= site_url('Tax_rate/update_status'); ?>",
        type: "POST",
        data: {
            id: taxId,
            status: newStatus
        },
        dataType: "json",
        success: function(res) {
            if (res.success || res.stt === 'ok') {
                toastr.success('Status updated successfully');
                loadTaxCounts();
                filter();
            } else {
                $toggle.prop('checked', !isChecked);
                toastr.error(res.message || res.msg || 'Failed to update status');
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
    
    function deleteTax(el, id) {
        $(el).del_modal({
            title: 'Delete',
            head: 'Delete Tax Rate',
            para: 'Do you want to delete this tax rate?',
            id: id,
            url: '<?php echo site_url("Tax_rate/delete?id="); ?>' + id,
            callback: function(response) {
                filter();
                loadTaxCounts();
            }
        });
    }

    function filter() {
        if ($.fn.DataTable.isDataTable('#taxTable')) {
            $('#taxTable').DataTable().destroy();
        }
        
        $.ajax({
            url: "<?= site_url('Tax_rate/filter'); ?>",
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
                // Filter taxes based on selected status
                let filteredTaxes = res.data;
                let selectedStatus = $('#statusFilter').val();
                
                // If a specific status is selected (not empty), filter by that status
				if (selectedStatus && selectedStatus !== '') {
					filteredTaxes = res.data.filter(tax => tax.status === selectedStatus);
				} else {
					// If no status selected (empty/"All Tax Rates"), show only non-deleted (active + inactive)
					filteredTaxes = res.data.filter(tax => tax.status === 'active' || tax.status === 'inactive');
				}
                
                filteredTaxes.sort((a, b) => {
                    return parseInt(b.tax_rate_id) - parseInt(a.tax_rate_id);
                });
                    
                    $.each(filteredTaxes, function (index, tax) {
						let isInactive = tax.status === 'inactive';
                        let taxId = tax.tax_rate_id;
                        let taxName = tax.tax_name;
                        let taxCode = tax.tax_code;
                        let taxRate = tax.tax_rate;
                        let taxType = tax.tax_type === 'sales' ? 'Sales Tax' : 'Purchase Tax';
                        let description = tax.description || '-';
                        let taxStatus = tax.status;
                        let createDate = tax.created_at ? tax.created_at.split(' ')[0] : '-';
                        
                        // Status badge colors (including Deleted)
						let statusBadge = '';
						if (taxStatus === 'active') {
							statusBadge = '<span class="status-badge" style="background:#1dd871; color:#fff">Active</span>';
						} else if (taxStatus === 'inactive') {
							statusBadge = '<span class="status-badge" style="background:#ff7f50; color:#fff">Inactive</span>';
						} else if (taxStatus === 'deleted') {
							statusBadge = '<span class="status-badge" style="background:#6c757d; color:#fff">Deleted</span>';
						}

                        // Tax type badge colors
                        let taxTypeClass = tax.tax_type === 'sales' 
                            ? 'style="background:#72eca9; color:#fff"' 
                            : 'style="background:#f79a78; color:#fff"';
                        
                      tbody += `
<tr data-tax-id="${taxId}">
    <td><span>${escapeHtml(taxId)}</span></td>
    <td>
        <div class="d-flex flex-column">
            <span class="fw-medium">${escapeHtml(taxName)}</span>
            <small class="text-muted" style="font-size: 11px;"> ${escapeHtml(taxCode)}</small>
        </div>
    </td>
    <td><span class="fw-medium">${taxRate}%</span></td>
    <td>
        <span class="badge rounded-pill fs-11 
			${tax.tax_type === 'sales' ? 'bg-success' : 'bg-warning'}">
			${escapeHtml(taxType)}
		</span>
     </td>

    <td>
        <span class="text-dark" title="${escapeHtml(description)}">
            ${escapeHtml(description)}
        </span>
     </td>

    <td><span class="text-dark">${createDate}</span></td>
	
    <td class="text-center align-middle">
    <div class="d-flex align-items-center justify-content-center gap-1">
        <!-- Status Toggle -->
        <div class="tax-toggle" data-tax-id="${taxId}">
            <div class="form-check form-switch m-0">
                <input class="form-check-input statusToggle" 
                       type="checkbox" 
                       ${taxStatus === 'active' ? 'checked' : ''}
                       data-tax-id="${taxId}"
                       style="margin-top: 0; width: 32px; height: 16px;"
                       ${taxStatus === 'deleted' ? 'disabled' : ''}
                       title="${taxStatus === 'deleted' ? 'Cannot toggle deleted items' : (taxStatus === 'active' ? 'Click to deactivate' : 'Click to activate')}">
            </div>
        </div>

        <!-- Edit Button -->
        <button class="btn btn-sm btn-icon btn-warning-light btnEditTax" 
                data-id="${taxId}" 
                ${(taxStatus === 'inactive' || taxStatus === 'deleted') ? 'disabled' : ''}
                style="${(taxStatus === 'inactive' || taxStatus === 'deleted') ? 'opacity: 0.5; cursor: not-allowed; width: 26px; height: 26px;' : 'width: 26px; height: 26px;'}"
                title="${(taxStatus === 'inactive' || taxStatus === 'deleted') ? (taxStatus === 'deleted' ? 'Deleted items cannot be edited' : 'Activate to edit') : 'Edit Tax Rate'}">
            <i class="ri-edit-line" style="font-size: 12px;"></i>
        </button>

        <!-- Delete Button -->
        <button class="btn btn-sm btn-danger-light btn-icon btnDeleteTax" 
                data-id="${taxId}" 
                ${taxStatus === 'deleted' ? 'disabled' : ''}
                style="${taxStatus === 'deleted' ? 'opacity: 0.5; cursor: not-allowed; width: 26px; height: 26px;' : 'width: 26px; height: 26px;'}"
                title="${taxStatus === 'deleted' ? 'Already deleted' : 'Delete Tax Rate'}">
            <i class="ri-delete-bin-line" style="font-size: 12px;"></i>
        </button>
    </div>
</td
</tr>`;
           });
                } else {
                    tbody = `<tr>
                        <td colspan="7" class="text-center text-black-normal py-4">No tax rates found</td>
                    </tr>`;
                }
                
                $('#taxTable tbody').html(tbody);
                
                table = initializeDataTable('#taxTable');
                
                // Update counts
                loadTaxCounts();
            },
            error: function(xhr, status, error) {
                console.error('Filter error:', error);
                toastr.error('Failed to load tax rates');
            }
        });
    }

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
        
        if (errors.toLowerCase().includes('tax name')) {
            $('#tax_name').addClass('is-invalid');
            $('#tax_name-error').html('Tax name is required');
        }
        
        if (errors.toLowerCase().includes('tax code')) {
            $('#tax_code').addClass('is-invalid');
            $('#tax_code-error').html('Tax code is required');
        }
        
        if (errors.toLowerCase().includes('tax type')) {
            $('#tax_type').addClass('is-invalid');
            $('#tax_type-error').html('Tax type is required');
        }

        if (errors.toLowerCase().includes('tax rate')) {
            $('#tax_rate').addClass('is-invalid');
            $('#tax_rate-error').html('Tax rate is required');
        }
        
        if (!$('#tax_name').hasClass('is-invalid') && 
            !$('#tax_code').hasClass('is-invalid') && 
            !$('#tax_type').hasClass('is-invalid') && 
            !$('#tax_rate').hasClass('is-invalid')) {
            $('#tax_name').addClass('is-invalid');
            $('#tax_code').addClass('is-invalid');
            $('#tax_type').addClass('is-invalid');
            $('#tax_rate').addClass('is-invalid');
        }
    }
    
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });
	
	$('.js-example-basic-single').select2({
       dropdownParent: $('#taxFormModal'),
       width: '100%'
     });

 
    
});
</script>