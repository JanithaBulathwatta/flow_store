<!--Custom CSS file -->
<link href="/assets/css/erpCustom.css" rel="stylesheet" >
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-12 mt-3">
				<div class="card custom-card card-bg mb-20">
					<div class="card-body"> 
						<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
							<div class="d-flex align-items-center"> 
								<span class="me-6 card-title">Sub Catagory Management </span>
								
                                <div class="d-flex gap-2 flex-wrap" id="supplier-status-container">
                                    <!-- Total Card -->
                                    <!--<div class=" stat-pill status-card" data-status="all">
                                        <span id="totalSub"></span>
                                        <span class="ms-1">Total</span>
                                    </div>
									
									<!-- Active  Card -->
                                    <!--<div class="mini-card stat-pill status-card" data-status="active">
                                        <span id="activeSub"></span>
                                        <span class="ms-1">Active</span>
                                    </div>
									
									<!-- Active  Card -->
                                    <!--<div class="mini-card stat-pill status-card" data-status="inactive">
                                        <span id="inactiveSub"></span>
                                        <span class="ms-1">Inactive</span>
                                    </div>

                                    <!-- Deleted  Card -->
                                    <!--<div class="mini-card stat-pill status-card" data-status="delete">
                                        <span id="deleteSub"></span>
                                        <span class="ms-1">Deleted</span>
                                    </div>-->
                                </div>
								
							
							</div> 
							
							<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<button class="btn btn-add" id="btnAddLead"><i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Sub Catagory</button>
							</div> 
						</div> 
					</div>
					
				</div>
				
				<div class="summary-bar" id="summary-bar"></div>
				
			</div>
		

		
            <div class="col-xl-12">

                <div class="card custom-card">

                    <!-- HEADER -->
                    <!--<div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title"> Sub Category List </div>
                    </div>-->

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="leadsTable" class="table table-stripe text-nowrap w-100 dataTable no-footer" aria-describedby="datatable-basic_info">

                                <thead>
                                <tr>
									
									<th>Sub Category Name</th>
									<th>Code</th>
									<th>Super Category</th>
									<th>Item Count</th>
									<th>Actions</th>
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

<div class="modal fade" id="leadFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form id="leadForm">

                <div class="modal-header">
                    <h6 class="modal-title" id="leadModalTitle">Create Sub Category</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="lead_id" name="lid">

                    <div class="row gy-3">
					
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Category Name *</label>
                            <input type="text" name="Category_name" id="Category_name" 
							   class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Category Code *</label>
                            <input type="text" name="Category_code" id="Category_code" class="form-control form-control-sm" required>
                        </div>


                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Super Category *</label>
								<select name="super_category_id" id="super_category_id" class="form-select form-select-sm" required>
								 <option value="">-- Select Super Category  --</option>
									<?php if(!empty($super_categories)): ?>
										<?php foreach ($super_categories as $sc): ?>
											<option value="<?= $sc->id; ?>">
												<?= html_escape($sc->name); ?>
											</option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
                        </div>
					
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light close-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub"> <i class="ri-save-line me-1"></i> Save </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
	$(document).ready(function () {

		var table = initializeDataTable('#leadsTable');
		const formModal = new bootstrap.Modal(document.getElementById('leadFormModal'));

		filter();
		loadSubCounts();
		
		
		//Submit lead for save or Update
 		$('#leadForm').ajax_submit({
			url : '/Sub_category/store', 
			rest: false,
			callback : function(id){
				$('#leadForm')[0].reset()
				filter();
				loadSubCounts();
			}
		}); 
		
		// get counts
		/*function loadSubCounts() {
			$.ajax({
				url: "<?php echo site_url('Sub_category/get_counts'); ?>",
				type: "GET",
				dataType: "json",
				success: function(response) {
					
					$('#totalSub').text(response.all_count || 0);
					$('#activeSub').text(response.active_count || 0);
					$('#inactiveSub').text(response.inactive_count || 0);
					$('#deleteSub').text(response.deleted_count || 0);
				},
				error: function() {
					console.error('Failed to load Sub Category counts');
				}
			});
		}*/
		
		
		
/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadSubCounts() {
    $.ajax({
        url: "Sub_category/get_counts",
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Category' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Category' },
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Category' },
       
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

		/*click function for "Add lead" button 
			* Change modal title,
			* Button value,
			* reset form,
			* Clear Lead id (if loaded)
			* trigger the modal
		*/
		$('#btnAddLead').click(function () {
			$('#leadModalTitle').text('New Sub Category');
			$('#btn-sub').text('Save').prop('disabled', false); // Reset disabled state
			$('#Category_code').removeClass('is-invalid'); // Clear error styling
			$('#code-error').remove(); // Remove error message
			$('#leadForm')[0].reset();
			$('#lead_id').val('');
			formModal.show();
		});

		// Click function get data for EDIT
		$(document).on('click', '.btnEditLead', function () {

			let id = $(this).data('id');

			$('#leadModalTitle').text('Edit category');
			$('#btn-sub').text('Update');
			$('#lead_id').val(id);
			formModal.show();

			$.getJSON("<?= site_url('/Sub_category/view?lid='); ?>" + id, function (res) {
				
				console.log(res);

				$('#Category_name').val(res.category.name);
				$('#Category_code').val(res.category.code);
				$('#Category_count').val(res.category.count);
				$('#super_category_id').val(res.category.super_category_id).trigger('change');

			});

		});

		$(document).on('click', '.status-card', function () {
			let status = $(this).data('status');
			filter(status);
		});

		
 function filter(status = 'all') {
    $.ajax({
        url: "<?= site_url('Sub_category/get_data'); ?>",
        type: "POST",
        data: { status: status }, // Sends the filter status to your controller
        dataType: "json",
        success: function (res) {
            let tbody = '';

            // 1. Properly destroy DataTable before updating rows
            if ($.fn.DataTable.isDataTable('#leadsTable')) {
                $('#leadsTable').DataTable().clear().destroy();
				$('#leadsTable tbody').empty();
            }

            if (res.data && res.data.length > 0) {
                $.each(res.data, function (i, item) {
                    
                    // --- Logic for Status & Button States ---
                    const isActive = item.status === 'active';
                    const isInactive = item.status === 'inactive';
                    const isDeleted = item.status === 'delete';

                    const statusChecked = isActive ? 'checked' : '';
                    
                    // Toggle disabled only if record is deleted
                    let toggleDisabled = isDeleted ? 'disabled' : '';

                    // Edit disabled for inactive & deleted
                    let editDisabled = (isInactive || isDeleted)
                        ? 'disabled style="opacity:0.8;cursor:not-allowed;"'
                        : '';

                    // Delete disabled only if already deleted
                    let deleteDisabled = isDeleted
                        ? 'disabled style="opacity:0.8;cursor:not-allowed;"'
                        : '';

                    let actionBtns = `
                        <div class="d-flex align-items-center gap-1">
                            
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input status-toggle" 
                                    type="checkbox" 
                                    data-id="${item.id}" 
                                    ${statusChecked} 
                                    ${toggleDisabled}
                                    style="transform: scale(1.2); cursor:pointer;"
									title="inactive">
                            </div>

                            <button class="btn btn-sm btn-icon btn-warning-light btnEditLead" 
                                data-id="${item.id}" 
                                title="${isInactive ? 'Inactive items cannot be edited' : 'Edit'}"
                                ${editDisabled}>
                                <i class="ri-edit-line icon-yellow-dark"></i>
                            </button>

                            <button class="btn btn-sm btn-danger-light btn-icon lead-delete" 
                                data-id="${item.id}" 
                                title="Delete"
                                ${deleteDisabled}>
                                <i class="ri-delete-bin-line icon-red-dark"></i>
                            </button>

                        </div>`;

                    tbody += `
                    <tr>
                        <td>
                            <span class="fw-medium">${item.name}</span>
                        </td>
                        <td>${item.code ?? '-'}</td>
                        <td>${item.super_category_name ?? '<span class="text-muted">None</span>'}</td>
                        <td><span class="">${item.product_count ?? 0}</span></td>
                        <td class="text-center">
                            ${actionBtns}
                        </td>
                    </tr>`;
                });
            } 

            // Update HTML
            $('#leadsTable tbody').html(tbody);
			initializeDataTable('#leadsTable');

        },
        error: function() {
            console.error("Failed to fetch data.");
        }
    });
}

		
		$(document).on('click', '.lead-delete', function () {
			
			const id = $(this).data('id');
		
			//alert(id);
			
			$(this).del_modal({
				title : 'Delete ',
				head : 'Delete Sub Category',
				para: 'Do you want to Delete this?',
				id : id,
				url : '/Sub_category/delete?lid='+id,
				callback : function(res){
					if(res != ''){
						filter();
						loadSubCounts();
					}
				}
			});
			
		});
		
		$(document).on('change', '.status-toggle', function() {
			const $toggle = $(this);
			const id = $toggle.data('id');
			const isChecked = $toggle.is(':checked');
			const newStatus = isChecked ? 'active' : 'inactive';

			$toggle.prop('disabled', true);

			$.ajax({
				url: '<?= site_url("Sub_category/update_status"); ?>',
				type: 'POST',
				data: { lid: id, status: newStatus },
				dataType: 'json',
				success: function(res) {
					if (res.stt === 'ok') {
						toastr.success(res.msg || 'Status updated');
						
						// CALL YOUR FILTER FUNCTION HERE
						// This rebuilds the table manually with the new status
						filter(); 
						loadSubCounts();
						
					} else {
						toastr.error(res.msg || 'Failed to update');
						$toggle.prop('checked', !isChecked);
					}
				},
				error: function(xhr) {
					console.log(xhr.responseText);
					toastr.error('Server error');
					$toggle.prop('checked', !isChecked);
				},
				complete: function() {
					$toggle.prop('disabled', false);
				}
			});
		});


		// SAVE (CREATE + UPDATE)
		/*$('#leadForm').submit(function (e) {

			e.preventDefault();

			let id = $('#lead_id').val();

			let url = id
				? "<?= site_url('Leads/update'); ?>/" + id
				: "<?= site_url('Leads/store'); ?>";

			$.ajax({
				url: url,
				type: "POST",
				data: {
					customer_name: $('#customer_name').val(),
					customer_email: $('#customer_email').val(),
					customer_phone: $('#customer_phone').val(),
					source: $('#source').val(),
					product_id: $('#product_id').val(),
					status_id: $('#status_id').val(),
					assigned_user_id: $('#assigned_user_id').val(),
					priority: $('#priority').val(),
					notes: $('#notes').val()
				},
				success: function (res) {

					toastr.success("Lead saved successfully");
					formModal.hide();

					setTimeout(function () {
						location.reload();
					}, 800);
				},
				error: function () {
					toastr.error("Something went wrong");
				}
			});

		});*/
		

		/*document.getElementById("btn-cl").addEventListener("click", function () {
			document.body.classList.remove('modal-open');
			document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
			modal.hide();
		});*/
		
		
		// Function to check if code is unique
		$('#Category_code').on('input', function() {
			let code = $(this).val().trim();
			let excludeId = $('#lead_id').val(); // The hidden input holding the current ID
			let $input = $(this);
			let $submitBtn = $('#btn-sub'); // Ensure this matches your button ID

			if (code.length > 0) {
				$.ajax({
					url: "<?= site_url('Sub_category/check_code_exists'); ?>",
					type: "GET",
					data: { code: code, exclude_id: excludeId },
					dataType: "json",
					success: function(res) {
						if (res.exists) {
							$input.addClass('is-invalid');
							$submitBtn.prop('disabled', true);
							
							// Optional: Add an error message if it doesn't exist
							if ($('#code-error').length === 0) {
								$input.after('<div id="code-error" class="invalid-feedback">This code already exists.</div>');
							}
						} else {
							$input.removeClass('is-invalid');
							$submitBtn.prop('disabled', false);
							$('#code-error').remove();
						}
					}
				});
			} else {
				$input.removeClass('is-invalid');
				$submitBtn.prop('disabled', false);
				$('#code-error').remove();
			}
		});
		

		
	});


	



</script>

