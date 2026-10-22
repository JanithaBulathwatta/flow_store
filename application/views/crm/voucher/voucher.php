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

<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-12 mt-3">
				<div class="card custom-card card-bg mb-20">
					<div class="card-body"> 
						<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
							<div class="d-flex align-items-center"> 
								<span class="card-title me-6">Voucher management </span>
								
								<div class="d-flex gap-2 flex-wrap" id="supplier-status-container">
                                    <!-- Active Suppliers Card -->
                                    <!--<div class="mini-card bg-primary status-card" 	data-status="all">
                                        <i class="bi bi-building"></i>
                                        <span id="totalVou"></span>
                                        <span class="ms-1">Total Voucher</span>
                                    </div>

                                    <!-- Deleted Suppliers Card -->
                                    <!--<div class="mini-card bg-teal status-card" 	data-status="cancel">
                                        <i class="bi-hourglass"></i>
                                        <span id="cancelVou"></span>
                                        <span class="ms-1">Total Cancel Voucher</span>
                                    </div>
									
									<!-- Deleted Suppliers Card -->
                                    <!--<div class="mini-card bg-danger status-card" 	data-status="delete">
                                        <i class="bi bi-trash"></i>
                                        <span id="deleteVou"></span>
                                        <span class="ms-1">Total Deleted Voucher</span>
                                    </div>-->
                                </div>
								
								<div class="d-flex gap-2 flex-wrap" id="lead-status-container"> </div>
								
							
							</div> 
							
							<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<button class="btn btn-add" id="btnAddLead"><i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Voucher</button>
							</div> 
						</div> 
					</div>
					
					<div class="summary-bar" id="summary-bar"></div>
					
				</div>
			</div>
		

            <div class="col-xl-12">

                <div class="card custom-card">

                    <!-- HEADER -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title"> Voucher List </div>
                    </div>

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="leadsTable" class="table table-stripe text-nowrap w-100 dataTable no-footer" aria-describedby="datatable-basic_info">

                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voucher Name</th>
                                    <th>Voucher Amount</th>
                                    <th>Note</th>
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
                    <h6 class="modal-title" id="leadModalTitle">Lead</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    
                    <div class="row gy-3">
					
						<input type="hidden" name="lid">
					
                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Employee Name</label>
                           <input type="text" name="emp_name" id="Emp_name" class="form-control form-control-sm" required min="0.01" step="0.01" title="Please enter a valid amount (e.g., 10.50)">
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Voucher Amount</label>
                            <input type="number" name="Voucher_Amount" id="Voucher_Amount" class="form-control form-control-sm" required min="0.01" step="0.01" title="Please enter a valid amount (e.g., 10.50)">
                        </div>
	
						<div class="col-xl-6 mt-1">
                            <label class="form-label">Voucher Date</label>
                            <input type="date" name="voucher_date" id="Voucher_Date" class="form-control form-control-sm" value="<?= date('Y-m-d'); ?>">
                        </div>

                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Notes</label>
                            <textarea id="notes" name="notes" class="form-control form-control-sm" rows="3"></textarea>
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

<!--Cancel modal-->
<div id="canModalOverlay" class="can-modal-overlay" style="display:none;">
    <div class="can-modal-box">
        <div class="can-modal-header">
            <span class="can-title">Cancel</span>
            <button class="can-close" style="border:none; background:none; cursor:pointer;">&times;</button>
        </div>

        <div class="can-modal-body">
            <h4 class="can-head">Cancel Item</h4>
            <p class="can-para">Are you sure?</p>
        </div>

        <div class="can-modal-footer">
            <button class="can-btn can-back">Close</button>
            <button class="can-btn can-confirm">
                <i class="ri-close-circle-line"></i> Confirm
            </button>
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
			url : '/Voucher/store', 
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
				url: "<?php echo site_url('Voucher/get_counts'); ?>",
				type: "GET",
				dataType: "json",
				success: function(response) {
					
					$('#totalVou').text(response.all_count || 0);
					$('#cancelVou').text(response.cancel_count || 0);
					//$('#inactiveSub').text(response.inactive_count || 0);
					$('#deleteVou').text(response.deleted_count || 0);
				},
				error: function() {
					console.error('Failed to Voucher counts');
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
				url: "Voucher/get_counts",
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
				active:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Voucher' },
				cancel_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Voucher' },
				all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
				deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Voucher' },
			   
			};

			// Generating array structure for your map generator loop
			var displayItems = GRN_ITEMS.map(function(item) {
				var key = (item.name || '').toLowerCase();
				var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Voucher' };
				

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
			$('#leadModalTitle').text('New Voucher');
			$('#btn-sub').text('Save');
			$('#leadForm')[0].reset();
			$('#lead_id').val('');
			formModal.show();
		});

		// Click function get data for EDIT
		$(document).on('click', '.btnEditLead', function () {

			let id = $(this).data('id');

			$('#leadModalTitle').text('Edit Voucher');
			$('#btn-sub').text('Edit');
			$('#lead_id').val(id);
			formModal.show();

			$.getJSON("<?= site_url('/Voucher/view?lid='); ?>" + id, function (res) {
				
				console.log(res);

				$('#voucher_name_id').val(res.Voucher.voucher_name);
				$('#Voucher_Amount').val(res.Voucher.amount);
				$('#notes').val(res.Voucher.note);

			});

		});
		
		$(document).on('click', '.status-card', function () {
			let status = $(this).data('status');
			filter(status);
		});
		
		function filter(status = 'all') {
			$.ajax({
				url: "<?= site_url('Voucher/get_data'); ?>",
				type: "POST",
				data: { status: status }, // Logic to filter by status
				dataType: "json",
				success: function (res) {
					let tbody = '';

					// 1. Destroy existing DataTable before updating rows
					if ($.fn.DataTable.isDataTable('#leadsTable')) {
						$('#leadsTable').DataTable().clear().destroy();
						$('#leadsTable tbody').empty();
					}

					if (res.data && res.data.length > 0) {
						$.each(res.data, function (i, item) {
							
							const isCencel = item.status === 'cancel';
							const isDeleted = item.status === 'delete';
							const isActive  = item.status === 'active';
							
							let editDisabled = (isDeleted) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '';
							let deleteDisabled = (isDeleted) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '';
							let cancelDisabled = (isCencel || isDeleted) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '';

							let actionBtns = `
								<!--<button class="btn btn-sm btn-icon btn-warning-light btnEditLead" 
									data-id="${item.id}" ${editDisabled}>
									<i class="ri-edit-line"></i>
								</button>-->
								<button class="btn btn-sm btn-icon btn-primary-light print_btn" data-id="${item.id}" title="Print Voucher"><i class="ri-printer-line"></i></button>
								<!--<button class="btn btn-sm btn-icon btn-info-light cancel_btn" data-id="${item.id}" ${cancelDisabled}><i class="ri-share-forward-line"></i></button>-->
								<button class="btn btn-sm btn-danger-light btn-icon lead-delete" data-id="${item.id}" ${deleteDisabled}><i class="ri-delete-bin-line"></i></button>
								`;

							tbody += `
							<tr>
								<td>${item.id}</td>
								<td><span class="fw-medium">${item.emp_name}</span></td>
								<td>${item.amount ?? '-'}</td>
								<td>${item.note ?? '-'}</td>	
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
				head : 'Delete voucher',
				para: 'Do you want to Delete this?',
				id : id,
				url : '/Voucher/delete?lid='+id,
				callback : function(res){
					if(res != ''){
						filter();
						loadSubCounts();
					}
				}
			});
			
		});
		
		$(document).on('click', '.cancel_btn', function () {
			
			const id = $(this).data('id');
		
			//alert(id);
			
			$(this).can_modal({
				title : 'Mark As Issued',
				head : 'Mark As Issued',
				para: 'Do you want to Issue this?',
				id : id,
				url : '/Voucher/issue?lid='+id,
				callback : function(res){
					if(res != ''){
						filter();
						loadSubCounts();
					}
				}
			});
			
		});
		
		
		$(document).on('click', '.print_btn', function () {

			const id = $(this).data('id');
			window.open('<?= site_url("Voucher/print_voucher/"); ?>?id=' + id,'_blank');

		});
		
		
		$(document).on('change', '.status-toggle', function() {
			const $toggle = $(this);
			const id = $toggle.data('id');
			const isChecked = $toggle.is(':checked');
			const newStatus = isChecked ? 'active' : 'inactive';

			$toggle.prop('disabled', true);

			$.ajax({
				url: '<?= site_url("Voucher/update_status"); ?>',
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
	});

	// Cancel modal function 
	(function ($) {
		$.fn.can_modal = function (options) {
			const settings = $.extend({
				title: 'Cancel',
				head: 'Cancel Voucher',
				para: 'Are you sure?',
				id: null,
				url: '',
				callback: function () {}
			}, options);

			const modal = $('#canModalOverlay');

			// Set content
			modal.find('.can-title').text(settings.title);
			modal.find('.can-head').text(settings.head);
			modal.find('.can-para').text(settings.para);

			modal.fadeIn(120);

			const btnConfirm = modal.find('.can-confirm');
			const btnBack = modal.find('.can-back');

			// Reset state
			btnConfirm.prop('disabled', false).html('<i class="ri-close-circle-line"></i> Confirm');
			btnBack.prop('disabled', false);

			function closeModal() { modal.fadeOut(120); }

			modal.off('click', '.can-close, .can-back').on('click', '.can-close, .can-back', closeModal);

			modal.off('click', '.can-confirm').on('click', '.can-confirm', function () {
				if (btnConfirm.prop('disabled')) return;

				btnConfirm.prop('disabled', true).text('Processing...');
				btnBack.prop('disabled', true);

				$.ajax({
					url: settings.url,
					type: 'POST',
					data: { id: settings.id },
					dataType: 'json',
					success: function (res) {
						if (res.stt === 'ok') {
							toastr.success(res.msg);
							settings.callback(res.data);
							closeModal();
						} else {
							toastr.error(res.msg);
							btnConfirm.prop('disabled', false).html('<i class="ri-close-circle-line"></i> Confirm');
							btnBack.prop('disabled', false);
						}
					},
					error: function () {
						toastr.error('Server error');
						btnConfirm.prop('disabled', false).html('<i class="ri-close-circle-line"></i> Confirm');
						btnBack.prop('disabled', false);
					}
				});
			});

			return this;
		};
	}(jQuery));
	



</script>
