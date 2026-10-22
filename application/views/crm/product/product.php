
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
                                <span class="card-title me-6">Products Management</span>
                                
                                <div class="d-flex gap-2 flex-wrap align-items-center" id="product-status-container">
									<!-- All Products Pill -->
									<!--<div id="pill-total" class="stat-pill status-filter" data-status="" style="cursor: pointer;">
										<span class="num" id="val-total">0</span>
										<span class="lbl">All Products</span>
									</div>

									<!-- Active Products Pill -->
									<!--<div id="pill-active" class="stat-pill status-filter" data-status="active" style="cursor: pointer;">
										<span class="num" id="val-active">0</span>
										<span class="lbl">Active</span>
									</div>

									<!-- Inactive Products Pill -->
									<!--<div id="pill-inactive" class="stat-pill status-filter" data-status="inactive" style="cursor: pointer;">
										<span class="num" id="val-inactive">0</span>
										<span class="lbl">Inactive</span>
									</div>

									<!-- Deleted Products Pill -->
									<!--<div id="pill-deleted" class="stat-pill status-filter" data-status="deleted" style="cursor: pointer;">
										<span class="num" id="val-deleted">0</span>
										<span class="lbl">Deleted</span>
									</div>-->
								</div>
                            </div> 
                            
                            <!-- New Product Button -->
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-add" id="btnAddProduct">
                                    <i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Product
                                </button>
                            </div>

							<div class="col-xl-12">
								<form id="data-filter">
									<div class="card mb-3">
										<div class="card-body row g-3">
											<div id="filter-inputs-row" class="row g-3">
												<!-- Select Staff -->
												<div class="col-md-4">
													<label class="text-black-normal label mb-1">Select Super Category</label>
													<select id="scat" name="fk_user_id" class="form-control form-select form-select-sm js-example-basic-single w-100">
														<option value=""> Select Super Category </option>
														<?php foreach ($super_categories as $scat): ?>
															<option value="<?= $scat->id; ?>"><?= html_escape($scat->name); ?></option>
														<?php endforeach; ?>
													</select>
												</div>
												
												<!-- Search Button -->
												<div class="col-md-4">
													<label class="text-black-normal label mb-1">&nbsp;</label>
													<button type="submit" class="btn btn-search w-100" style="background: #5b5ea6; color: white; border: none; padding: 6px 12px; border-radius: 6px; display: block">
														Search
													</button>
												</div>
											</div>	
										</div>
									</div>
								</form>
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
        
            <!-- Products Table -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productsTable" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>Product Details</th>
                                        <th>Price</th>
										<th>WH Price</th>   
                                        <th>Mini Price</th>
                                        <th>Measure Unit</th>       
                                        <th>Status</th> 
                                        <th>Qty/Pack</th> 
                                        <th>Warranty</th>
                                        <th>Reorder</th>
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

 

<script>
$(document).ready(function () {
    
    // Initialize DataTable
    var table = initializeDataTable('#productsTable');
    
    // Load initial data
    filter();
    loadProductCounts();
	
	$('#data-filter').on('submit', function(e){
		e.preventDefault();
		filter();
	});
    
    // Click handler for status filters  
    $(document).on('click', '.status-filter', function () {
        let status = $(this).data('status');
        $('#statusFilter').val(status);
        filter();
    });
    
    // Add new product - Redirect to add page
    $('#btnAddProduct').click(function () {
        window.location.href = "<?php echo base_url('Product/add'); ?>";
    });
    
    // Edit product - Redirect to edit page
	$(document).on('click', '.btnEditProduct', function () {
		let id = $(this).data('id');
		if (id && id !== '' && id !== 'undefined') {
			// Method 1: Use concatenation properly
			window.location.href = "<?php echo base_url('Product/add?id='); ?>" + id;
		} else {
			toastr.error('Invalid product ID');
		}
	});
    
    // Delete product
    $(document).on('click', '.btnDeleteProduct', function () {            
        const id = $(this).data('id');
        deleteProduct(this, id);
    });
    
    // Toggle status
    $(document).on('change', '.toggleStatus', function () {
        let id = $(this).data('id');
        let checkbox = $(this);

        $.ajax({
            url: "<?= site_url('Product/toggle_status'); ?>",
            type: "POST",
            data: { id: id },
            dataType: "json",
            success: function(res) {
                if (res.stt === 'ok') {
                    toastr.success(res.msg);
                    filter();
                    loadProductCounts();
                } else {
                    toastr.error(res.msg);
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
            },
            error: function() {
                toastr.error('Something went wrong');
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
        });
    });
    
    function deleteProduct(el, id) {
        $(el).del_modal({
            title: 'Delete',
            head: 'Delete Product',
            para: 'Do you want to delete this product?',
            id: id,
            url: '<?php echo site_url("Product/delete?id="); ?>' + id,
            callback: function(response) {
                filter();
                loadProductCounts();
            }
        });
    }
    
    // Load product counts
		/*function loadProductCounts() {
			$.ajax({
				url: "<?php echo site_url('Product/get_counts'); ?>",
				type: "GET",
				dataType: "json",
				success: function(response) {
					// Calculate total (Active + Inactive)
					let allCount = (parseInt(response.active_count) || 0) + (parseInt(response.inactive_count) || 0);

					// Update text for each specific ID
					$('#val-total').text(allCount);
					$('#val-active').text(response.active_count || 0);
					$('#val-inactive').text(response.inactive_count || 0);
					$('#val-deleted').text(response.deleted_count || 0);
				},
				error: function() {
					console.error('Failed to load product counts');
				}
			});
		}*/
		
/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadProductCounts() {
    $.ajax({
        url: "Product/get_counts",
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
                active_count: 'fa-check-double',
                inactive_count: 'fa-circle-check',
                deleted_count: 'fa-circle-xmark'
                
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Products' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Products' },
        total: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'total Products' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Products' },
        
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Category' };
		


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
        lbl: 'Total Products',
        sub: 'Overall generated Products',
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
    
    // Filter function
    function filter() {
        if ($.fn.DataTable.isDataTable('#productsTable')) {
            $('#productsTable').DataTable().destroy();
        }
        
        $.ajax({
            url: "<?= site_url('Product/filter'); ?>",
            type: "POST",
            data: {
                search: $('#searchFilter').val(),
                status: $('#statusFilter').val(),
                date: $('#dateRange').val(),
				s_cat: $('#scat').val()
            },
			
            dataType: "json",
            success: function (res) {
                let tbody = '';
                
                if (res.data && res.data.length > 0) {
                    $.each(res.data, function (index, product) {
                        let statusBadge = '';
                        if (product.status === 'active') {
                            statusBadge = '<span class="badge bg-success" style="font-size: 9px; padding: 2px 6px; margin-left: 6px;">Active</span>';
                        } else if (product.status === 'inactive') {
                            statusBadge = '<span class="badge bg-warning" style="font-size: 9px; padding: 2px 6px; margin-left: 6px;">Inactive</span>';
                        } else if (product.status === 'deleted') {
                            statusBadge = '<span class="badge bg-danger" style="font-size: 9px; padding: 2px 6px; margin-left: 6px;">Deleted</span>';
                        }

                        // Serial Label Tracking
						/*let serialLabel = product.is_serial_trk == 1 ? 
							'<span class="badge bg-success rounded-pill" style="font-size:9px;">Serial</span>' :
							'<span class="badge bg-light rounded-pill" style="font-size:9px;">Serial</span>';

						// Expiry Label Tracking
						let expiryLabel = product.is_expiry_trk == 1 ?
							'<span class="badge bg-danger rounded-pill" style="font-size:9px;">Expiry</span>' :
							'<span class="badge bg-light rounded-pill" style="font-size:9px;">Expiry</span>';

						// Batch Label Tracking
						let batchLabel = product.is_batch == 1 ? 
							'<span class="badge bg-orange rounded-pill" style="font-size:9px;">Batch</span>' :
							'<span class="badge bg-light rounded-pill" style="font-size:9px;">Batch</span>';*/
						let serialLabel = product.is_serial_trk == 1 
							? '<span class="badge bg-success rounded-pill" style="font-size:9px;">Serial</span>' 
							: '';

						let expiryLabel = product.is_expiry_trk == 1 
							? '<span class="badge bg-danger rounded-pill" style="font-size:9px;">Expiry</span>' 
							: '';

						let batchLabel = product.is_batch == 1 
							? '<span class="badge bg-warning rounded-pill" style="font-size:9px;">Batch</span>' 
							: '';
				  
				  tbody += `<tr data-product-id="${product.id}">
                            <!--<td class="align-middle">${escapeHtml(product.id)}</td>-->
                            <td class="align-middle">
                                <div class="product-info">
                                    <!--<div><span class="product-name fw-semibold">${escapeHtml(product.name)}</span>${statusBadge}</div>-->
                                    <div><span class="product-name fw-semibold">${escapeHtml(product.name)} </span> </br> <span class="badge bg-secondary">${escapeHtml(product.product_code)}</span> ${(batchLabel || serialLabel || expiryLabel) 
									? `${batchLabel} ${serialLabel} ${expiryLabel}`.trim() 
									: '-'} </div>
                                    <!--<div>${batchLabel} ${serialLabel} ${expiryLabel}</div>-->
                                </div>
                            </td>
                            <td class="text-center fw-normal text-amount">${formatNumber(product.price)}</td>
                            <td class="text-center fw-normal text-amount">${product.wholesalePrice ? formatNumber(product.wholesalePrice) : '0.00'}</td>
                            <td class="text-center fw-normal text-amount">${product.specialPrice ? formatNumber(product.specialPrice) : '0.00'}</td>
							<td class="align-middle">
								${product.unit_name ? escapeHtml(product.unit_name) : '-'}
							</td>
                            <!--<td class="align-middle">
								${(batchLabel || serialLabel || expiryLabel) 
									? `${batchLabel} ${serialLabel} ${expiryLabel}`.trim() 
									: '-'}
							</td>-->
							<!--<td class="align-middle">
							  ${(batchLabel || serialLabel || expiryLabel)
								? `${batchLabel ? `<span>${batchLabel}</span>` : ''}
								   ${batchLabel && (serialLabel || expiryLabel) ? '<br>' : ''}
								   ${(serialLabel || expiryLabel) ? `<span>${`${serialLabel || ''} ${expiryLabel || ''}`.trim()}</span>` : ''}`
								: '-'}
							</td>-->
							
							<td class="align-middle">
							 ${statusBadge}
							</td>
							
							<td class="align-middle">${escapeHtml(product.qty_per_pack || '-')}</td>
                             
                            
							<td class="align-middle">
								${product.is_warranty_item == 1 ? `
									<div class="d-flex flex-column gap-1">
										<span class="badge bg-primary" style="font-size: 10px; padding: 3px 8px;">
											<i class="ri-timer-line me-1"></i> ${escapeHtml(product.warranty_period)}
										</span>
										${product.warrantyType ? `
										<span class="badge bg-info" style="font-size: 10px; padding: 3px 8px;">
											<i class="ri-shield-line me-1"></i> ${escapeHtml(product.warrantyType)}
										</span>
										` : ''}
									</div>
								` : '<span class="text-muted">No Warranty</span>'}
							</td>
                            
							<td class="align-middle">${escapeHtml(product.reorder_level)}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input toggleStatus" type="checkbox" data-id="${product.id}" 
                                        ${product.status === 'active' ? 'checked' : ''} ${product.status === 'deleted' ? 'disabled' : ''}
										title="${product.status === 'deleted' ? 'Cannot toggle deleted items' : (product.status === 'active' ? 'Click to deactivate' : 'Click to activate')}">
                                    </div>
                                    <button class="btn btn-sm btn-icon btn-warning-light btnEditProduct" 
										data-id="${product.id}"
										${(product.status === 'inactive' || product.status === 'deleted') ? 'disabled' : ''}
										style="${(product.status === 'inactive' || product.status === 'deleted') ? 'opacity: 0.5; cursor: not-allowed;' : ''}"
										title="${(product.status === 'inactive' || product.status === 'deleted') ? (product.status === 'deleted' ? 'Deleted items cannot be edited' : 'Activate to edit') : 'Edit'}">
										<i class="ri-edit-line"></i>
									</button>
						            <button class="btn btn-sm btn-danger-light btn-icon btnDeleteProduct" 
										data-id="${product.id}"
										${product.status === 'deleted' ? 'disabled' : ''}
										style="${product.status === 'deleted' ? 'opacity: 0.5; cursor: not-allowed;' : ''}"
										title="${product.status === 'deleted' ? 'Already deleted' : 'Delete'}">
										<i class="ri-delete-bin-line"></i>
									</button>
                                </div>
                            </td>
                        </tr>`;
                    });
                } else {
                    tbody = `<tr><td colspan="10" class="text-center text-muted">No products found</td></tr>`;
                }
                
                $('#productsTable tbody').html(tbody);
                table = initializeDataTable('#productsTable');
                loadProductCounts();
            },
            error: function(xhr, status, error) {
                console.error('Filter error:', error);
                toastr.error('Failed to load products');
            }
        });
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function formatNumber(num) {
        return parseFloat(num).toFixed(2);
    }
    
});
</script>