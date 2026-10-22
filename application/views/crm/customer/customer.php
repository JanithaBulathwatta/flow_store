<!--Custom CSS file -->
<link href="/assets/css/erpCustom.css" rel="stylesheet" >
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">


<style>
/* CANCEL MODAL STYLES */
.can-modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.can-modal-box {
    width: 260px;
    background: #fff;
    border-radius: 6px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    overflow: hidden;
    font-family: Arial, sans-serif;
}

.can-modal-header {
	display:flex;
	justify-content:space-between;
	align-items:center;
	padding:8px 10px;
	border-bottom:1px solid #eee;
	font-size:13px !importeb;
	font-weight:600;
}

.can-modal-body {
    padding: 12px 10px;
    text-align: center;
}

.can-modal-footer {
    display: flex;
    gap: 6px;
    padding: 10px;
    border-top: 1px solid #eee;
}

.can-btn {
    flex: 1;
    padding: 6px 0;
    font-size: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.can-back { background: #e0e0e0; }

/* Orange color for Cancel action */
.can-confirm {
    background: rgb(46 142 247 / 90%); 
    color: #fff;
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
								<span class="card-title me-6">Customer Management </span>
								
								<div class="d-flex gap-2 flex-wrap" id="supplier-status-container">
                                    <!-- Active Suppliers Card -->
                                    <!--<div class="stat-pill status-card" data-status="all">
                                        <span id="activeCustomer"></span>
                                        <span class="ms-1">Active </span>
                                    </div>

                                    <!-- Deleted Suppliers Card -->
                                    <!--<div class=" stat-pill status-card" data-status="inactive">
                                        <span id="inactiveCustomer"></span>
                                        <span class="ms-1">Inactive </span>
                                    </div>
									
									
									<!-- Deleted Suppliers Card -->
                                    <!--<div class=" stat-pill status-card" data-status="delete">
                                        <span id="deleteCustomer"></span>
                                        <span class="ms-1">Deleted </span>
                                    </div>-->
                                </div>
								
							</div> 
							
							<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<button class="btn btn-add" id="btnAddLead"><i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Customer</button>
							</div> 
						</div> 
					</div>
				</div>
				
				<div class="summary-bar" id="summary-bar"></div>
				
			</div>
		

		
            <div class="col-xl-12">

                <div class="card custom-card">

                    <!-- HEADER -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!--<div class="card-title"> Customer List </div>-->
                    </div>

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="customerTable" class="table table-stripe text-nowrap w-100 dataTable no-footer" aria-describedby="datatable-basic_info">

                             <thead>
								<tr>
									<th>#</th>
									<th>Customer Name</th>
									<th>Customer Contact</th>
									<th>Address</th>
									<th>Reg Date</th>
									<th>Allow Credit</th>
									<th>Used Credit</th> 
									<th>Max Limit</th>   
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


<div class="modal fade" id="leadFormModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form id="leadForm">

                <div class="modal-header">
                    <h6 class="modal-title" id="leadModalTitle">Customer</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
					<input type="hidden" id="lead_id" name="lid">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label">Customer Name *<span class="text-danger"></span></label>
							<input type="text" name="name" id="name" class="form-control" required >
						</div>
						
						<div class="col-md-6 mb-3">
							<label class="form-label">Email</label>
							<input type="email" name="email" id="email" class="form-control" 
								   title="Please enter a valid email address">
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label">Phone One *</label>
							<input type="text" name="phone" id="phone" class="form-control" required 
								   pattern="[0-9+\-\s]{10,15}" 
								   title="Please enter a valid phone number (10-15 digits)">
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Phone Two</label>
							<input type="text" name="phone_two" id="phone_two" class="form-control"  
								   pattern="[0-9+\-\s]{10,15}" 
								   title="Please enter a valid phone number (10-15 digits)">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label">Address *</label>
							<textarea name="address" id="address" class="form-control" rows="1" maxlength="255" required></textarea>
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Company Name</label>
							<input type="text" name="company_name" id="company_name" class="form-control" maxlength="100" 
							pattern="[A-Za-z\s]+" 
							title="Please enter letters and spaces only">
						</div>
					</div>
								 <h6 class="fw-bold mb-3 mt-2">Credit Details</h6>
					
					<div class="row">
						<div class="col-md-12 mb-3">
							<label class="form-label d-block">Enable Credit?</label>
							<div class="form-check form-check-inline">
								<input class="form-check-input is_credit" type="radio" name="is_credit" id="credit_yes" value="1">
								<label class="form-check-label" for="credit_yes">Yes</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input is_credit" type="radio" name="is_credit" id="credit_no" value="0" checked>
								<label class="form-check-label" for="credit_no">No</label>
							</div>
						</div>
					</div>

					<div class="row" id="credit_fields" style="display: none;">
						<div class="col-md-6 mb-3">
							<label class="form-label">Current Credit Amount:</label>
							<input type="number" step="0.01" name="current_credit_amt" id="current_credit_amt" class="form-control" placeholder="0.00">
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Max Credit Limit:</label>
							<input type="number" step="0.01" name="max_credit_limit" id="max_credit_limit" class="form-control" placeholder="0.00">
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
		
		//Submit lead for save or Update
 		$('#leadForm').ajax_submit({
			url : '/Customer/store', 
			rest: false,
			callback : function(id){
				if(id!=''){
					$('#leadForm')[0].reset()
					filter();
					loadCustomerCounts();
				}
			}
		}); 
		
		// credit info yes no button function 
		document.querySelectorAll('.is_credit').forEach((elem) => {
			elem.addEventListener("change", function(event) {
				const creditFields = document.getElementById("credit_fields");
				if (event.target.value === "1") {
					creditFields.style.display = "flex"; // Show fields
				} else {
					creditFields.style.display = "none"; // Hide fields
				}
			});
		});
	
		// adding value 
		$('.is_credit').on('change', function() {
			if ($(this).val() == '1') {
				$('#credit_fields').slideDown();
				$('#current_credit_amt').prop('required',true);
				$('#max_credit_limit').prop('required',true);
			} else {
				$('#credit_fields').slideUp();
				$('#current_credit_amt').prop('required',false);
				$('#max_credit_limit').prop('required',false);
			}
		});

		// get counts
	/*function loadCustomerCounts() {
		$.ajax({
			url: "<?php echo site_url('/Customer/get_counts'); ?>",
			type: "GET",
			dataType: "json",
			success: function(response) {
				
				$('#totalCustomer').text(response.all_count || 0);
				$('#activeCustomer').text(response.active_count || 0);
				$('#inactiveCustomer').text(response.inactive_count || 0);
				$('#deleteCustomer').text(response.deleted_count || 0);
			},
			error: function() {
				console.error('Failed to load Customer counts');
			}
		});
	}*/
	

	
	
/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadCustomerCounts() {
    $.ajax({
        url: "Customer/get_counts",
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
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'All Customers' },
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

	
	loadCustomerCounts();

		/*click function for "Add lead" button 
			* Change modal title,
			* Button value,
			* reset form,
			* Clear Lead id (if loaded)
			* trigger the modal
		*/
		$('#btnAddLead').click(function () {
			$('#leadModalTitle').text('New Customer');
			$('#btn-sub').text('Save');
			$('#leadForm')[0].reset();
			$('#lead_id').val('');
			formModal.show();
		});

		// Click function get data for EDIT
		$(document).on('click', '.btnEditLead', function () {

			let id = $(this).data('id');

			$('#leadModalTitle').text('Edit Customer');
			$('#btn-sub').text('Update');
			$('#lead_id').val(id);
			formModal.show();

			$.getJSON("<?= site_url('/Customer/view?lid='); ?>" + id, function (res) {
				
				console.log(res);

				// Assuming 'res.data' contains the customer object from your AJAX response
				$('#name').val(res.customer.cus_name);
				$('#company_name').val(res.customer.company_name);
				$('#email').val(res.customer.cus_email);
				$('#phone').val(res.customer.cus_phone);
				$('#phone_two').val(res.customer.cus_phone_2);
				$('#address').val(res.customer.cus_address);
				
				$(`input[name="is_credit"][value="${res.customer.is_credit}"]`).prop('checked', true);

				// Logic to show or hide the credit fields div immediately
				if (res.customer.is_credit == 1) {
					$('#credit_fields').show();
					
					$('#current_credit_amt').val(res.customer.current_credit_amt);
					$('#max_credit_limit').val(res.customer.max_credit_limit);
					
				} else {
					$('#credit_fields').hide();
					
					$('#current_credit_amt').val('0');
					$('#max_credit_limit').val('0');
				}

			});

		});

		$(document).on('click', '.status-card', function () {
			let status = $(this).data('status');
			filter(status);
		});

		
		// check the create lint validation
		function checkCreditLimits() {
		const isCredit = $('input[name="is_credit"]:checked').val();
		const used = parseFloat($('#current_credit_amt').val()) || 0;
		const max = parseFloat($('#max_credit_limit').val()) || 0;
		const $submitBtn = $('#btn-sub');

		// Remove existing warning
		$('.credit-warning').remove();

		if (isCredit == "1" && used > max) {
			$submitBtn.prop('disabled', true);
			$('#credit_fields').after('<div class="col-12 credit-warning"><small class="text-danger">Error: Used amount cannot be greater than Max limit.</small></div>');
		} else {
			$submitBtn.prop('disabled', false);
		}
	}

	// Attach listeners to the inputs in the modal
	$(document).on('input', '#current_credit_amt, #max_credit_limit', checkCreditLimits);
	$(document).on('change', '.is_credit', checkCreditLimits);
				
		function filter(status = 'all') {
			$.ajax({
				url: "<?= site_url('Customer/get_data'); ?>",
				type: "POST",
				data: { status: status },
				dataType: "json",
				success: function (res) {
					let customers = res.data ? res.data : res;

					// 1. Properly destroy existing DataTable to prevent "parentNode" errors
					if ($.fn.DataTable.isDataTable('#customerTable')) {
						$('#customerTable').DataTable().clear().destroy();
					}

					let tbody = '';

					if (customers && customers.length > 0) {
						$.each(customers, function (i, item) {
							const isActive = item.cus_status === 'active';
							const isInactive = item.cus_status === 'inactive';
							const isDeleted = item.cus_status === 'delete';

							const statusChecked = isActive ? 'checked' : '';
							let toggleDisabled = isDeleted ? 'disabled' : '';
							let editDisabled = (isInactive || isDeleted) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '';
							let deleteDisabled = isDeleted ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '';

							let creditBadge = item.is_credit == "1" 
								? '<span class="status-badge status-active">Yes</span>' 
								: '<span class="status-badge status-deleted">No</span>';

							// SPLIT COLUMNS LOGIC
							let usedDisplay = item.is_credit == "1" ? `<span class="text-danger fw-normal">${item.current_credit_amt}.00</span>` : '<span class="text-muted fw-normal">N/A</span>';
							let maxDisplay = item.is_credit == "1" ? `<span class="text-primary fw-normal">${item.max_credit_limit}.00</span>` : '<span class="text-muted fw-normal">N/A</span>';

							let actionBtns = `
								<div class="d-flex justify-content-center align-items-center gap-1">
									<div class="form-check form-switch d-inline-block">
										<input class="form-check-input status-toggle" type="checkbox" data-id="${item.cus_id}" ${statusChecked} ${toggleDisabled} style="transform: scale(1.1); cursor:pointer;">
									</div>
									<button class="btn btn-sm btn-icon btn-info-light btnViewCustomer" data-id="${item.cus_id}" title="View Profile" ${editDisabled}><i class="ri-eye-line"></i></button>
									<button class="btn btn-sm btn-icon btn-warning-light btnEditLead" data-id="${item.cus_id}" title="Edit" ${editDisabled}><i class="ri-edit-line"></i></button>
									<button class="btn btn-sm btn-danger-light btn-icon lead-delete" data-id="${item.cus_id}" ${deleteDisabled}><i class="ri-delete-bin-line"></i></button>
								</div>`;

							tbody += `
							<tr>
								<td>${item.cus_id}</td>
								<td><span class="fw-medium">${item.cus_name}</span><br><small class="text-muted">${item.company_name ?? ''}</small></td>
								<td><small><i class="ri-phone-line"></i> ${item.cus_phone}<br><i class="ri-mail-line"></i> ${item.cus_email || 'N/A'}</small></td>
								<td><small class="text-wrap" style="max-width: 150px; display: block;">${item.cus_address ?? '-'}</small></td>
								<td><small>${item.reg_date}</small></td>
								<td class="text-center">${creditBadge}</td>
								<td class="text-amount">${usedDisplay}</td>
								<td class="text-amount">${maxDisplay}</td>
								<td class="text-center">${actionBtns}</td>
							</tr>`;
						});
					}

					// Update Table Body
					$('#customerTable tbody').html(tbody);

					// 2. Re-initialize DataTable (Handles "No Data" automatically if tbody is empty)
					$('#customerTable').DataTable({
						"pageLength": 10,
						"responsive": true,
						"language": {
							"emptyTable": "No customers found for this status"
						}
					});
				},
				error: function(xhr) {
					console.error("Fetch Error: " + xhr.responseText);
				}
			});
		}
		
		
		$(document).on('click', '.lead-delete', function () {
			
			const id = $(this).data('id');
		
			//alert(id);
			
			$(this).del_modal({
				title : 'Delete ',
				head : 'Delete Customer',
				para: 'Do you want to Delete this?',
				id : id,
				url : '/Customer/delete?lid='+id,
				callback : function(res){
					if(res != ''){
						filter();
						loadCustomerCounts();
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
				url: '<?= site_url("Customer/update_status"); ?>',
				type: 'POST',
				data: { lid: id, status: newStatus },
				dataType: 'json',
				success: function(res) {
					if (res.stt === 'ok') {
						toastr.success(res.msg || 'Status updated');
						
						// CALL YOUR FILTER FUNCTION HERE
						// This rebuilds the table manually with the new status
						filter(); 
						loadCustomerCounts();
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
				

		// View Customer Profile
		$(document).on('click', '.btnViewCustomer', function () {
			let id = $(this).data('id');
			
			// Redirect to profile page with customer ID
			window.location.href = "<?= site_url('Customer/profile?lid='); ?>" + id;
		});

		
	});

</script>
