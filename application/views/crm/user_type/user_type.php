
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-12 mt-3">
				<div class="card custom-card card-bg mb-20">
					<div class="card-body"> 
						<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
							<div class="d-flex align-items-center"> 
								<span class="card-title me-6">User Type Management </span>
								
                                <div class="d-flex gap-2 flex-wrap" id="supplier-status-container">
                                    <!-- Total Card -->
                                    <!--<div class="mini-card bg-purple-dark status-card" data-status="all">
                                        <i class="bi bi-building"></i>
                                        <span id="totalSub"></span>
                                        <span class="ms-1">Total User Types </span>
                                    </div>
									
									<!-- Active  Card -->
                                    <!--<div class="mini-card bg-success status-card" data-status="active">
                                        <i class="bi bi-building"></i>
                                        <span id="activeSub"></span>
                                        <span class="ms-1">Active User Types</span>
                                    </div>

                                    <!-- Deleted  Card -->
                                    <!--<div class="mini-card bg-danger status-card" data-status="delete">
                                        <i class="bi bi-trash"></i>
                                        <span id="deleteSub"></span>
                                        <span class="ms-1">Deleted User Types</span>
                                    </div>-->
                                </div>
								
							
							</div> 
							
							<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<button class="btn btn-add" id="btnAddLead"><i class="ri-add-line me-1 fw-medium align-middle"></i> Add New User Types</button>
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
                        <div class="card-title"> User Types List </div>
                    </div>

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="TypeTable" class="table table-stripe text-nowrap w-100 dataTable no-footer" aria-describedby="datatable-basic_info">

                                <thead>
                                <tr>
									<th>ID</th>
									<th>Name</th>
									<th>User Types</th>
									<th>Category</th>
									<th>Status</th>
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
    <div class="modal-dialog modal-s modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form id="UserTypesForm">

                <div class="modal-header">
                    <h6 class="modal-title" id="leadModalTitle">Create User Type</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="utId" name="utId">

                    <div class="row gy-3">
											
						<div class="col-xl-12 mt-1">
                            <label class="form-label">User Type *</label>
                            <input type="text" name="User_type" id="User_type" 
							   class="form-control form-control-sm" required
							   pattern="[A-Za-z\s'\-]+" 
							   title="Please enter letters, spaces, hyphens, or apostrophes only">
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

		var table = initializeDataTable('#TypeTable');
		const formModal = new bootstrap.Modal(document.getElementById('leadFormModal'));

		filter();
		
		//Submit type for save or Update
 		$('#UserTypesForm').ajax_submit({
			url : '/UserType/store', 
			rest: false,
			callback : function(id){
				$('#UserTypesForm')[0].reset()
				filter();
				loadSubCounts();
			}
		}); 
		
		// get counts
		/*function loadSubCounts() {
			$.ajax({
				url: "/UserType/get_counts",
				type: "GET",
				dataType: "json",
				success: function(response) {
					
					$('#totalSub').text(response.all_count || 0);
					$('#activeSub').text(response.active_count || 0);
					$('#inactiveSub').text(response.inactive_count || 0);
					$('#deleteSub').text(response.deleted_count || 0);
				},
				error: function() {
					console.error('Failed to load User Types counts');
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
        url: "/UserType/get_counts",
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
        active_count:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active User Type' },
        inactive_count:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive User Type' },
        all_count: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'All User Type' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted User Type' },
       
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status User Type' };
		

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

		
		loadSubCounts();

		/*click function for "Add type" button 
			* Change modal title,
			* Button value,
			* reset form,
			* Clear type id (if loaded)
			* trigger the modal
		*/
		$('#btnAddLead').click(function () {
			$('#leadModalTitle').text('New User Types');
			
			$('#btn-sub').text('Save');
			$('#UserTypesForm')[0].reset();
			$('#utId').val('');
			formModal.show();
		});

		// Click function get data for EDIT
		$(document).on('click', '.btnEditUserType', function () {

			let id = $(this).data('id');

			$('#leadModalTitle').text('Edit category');
			$('#btn-sub').text('Edit');
			$('#utId').val(id);
			formModal.show();

			$.getJSON("/UserType/view?utId=" + id, function (res) {
				
				console.log(res);

				$('#User_type').val(res.User_type.ut_name);
			});

		});

		$(document).on('click', '.status-card', function () {
			let status = $(this).data('status');
			filter(status);
		});

		
function filter(status = 'all') {
    $.ajax({
        url: "UserType/get_data", 
        type: "POST",
        data: { status: status },
        dataType: "json",
        success: function (res) {
            let tbody = '';

            // 1. Properly destroy DataTable before updating rows
            if ($.fn.DataTable.isDataTable('#TypeTable')) {
                $('#TypeTable').DataTable().destroy();
            }

            // 'res.data' should match the array returned by your controller
            if (res.data && res.data.length > 0) {
                $.each(res.data, function (i, item) {
                    
                    // --- Logic for Status & Button States ---
                    const isActive = item.status === 'active';
                    const isInactive = item.status === 'inactive';
                    const isDeleted = item.status === 'delete';

                    const statusChecked = isActive ? 'checked' : '';
                    let toggleDisabled = isDeleted ? 'disabled' : '';

                    // Edit disabled for inactive & deleted
                    let editDisabled = (isInactive || isDeleted)
                        ? 'disabled style="opacity:0.5;cursor:not-allowed;"'
                        : '';

                    // Delete disabled only if already deleted
                    let deleteDisabled = isDeleted
                        ? 'disabled style="opacity:0.5;cursor:not-allowed;"'
                        : '';

                    let actionBtns = `
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input status-toggle" 
                                    type="checkbox" 
                                    data-id="${item.ut_id}" 
                                    ${statusChecked} 
                                    ${toggleDisabled}
                                    style="transform: scale(1.2); cursor:pointer;">
                            </div>

                            <button class="btn btn-sm btn-icon btn-warning-light btnEditUserType" 
                                data-id="${item.ut_id}" 
                                title="${isInactive ? 'Inactive items cannot be edited' : 'Edit'}"
                                ${editDisabled}>
                                <i class="ri-edit-line"></i>
                            </button>

                            <button class="btn btn-sm btn-danger-light btn-icon type-delete" 
                                data-id="${item.ut_id}" 
                                title="Delete"
                                ${deleteDisabled}>
                                <i class="ri-delete-bin-line"></i>
                            </button>

                        </div>`;

                    tbody += `
                    <tr>
                        <td>${item.ut_id}</td>
                        <td>
                            <span class="fw-medium">${item.ut_name}</span>
                        </td>
                        <td>${item.ut_type ?? '-'}</td>
                        <td>${item.category ?? 'normal'}</td>
                        <td>
                            <span class="badge ${isActive ? 'bg-success' : 'bg-danger'}">
                                ${item.status}
                            </span>
                        </td>
                        <td>
                            ${actionBtns}
                        </td>
                    </tr>`;
                });
            } else {
                tbody = `<tr><td colspan="6" class="text-center text-muted">No user types found</td></tr>`;
            }

            // Update HTML
            $('#TypeTable tbody').html(tbody);

            // 2. Re-initialize the DataTable
            $('#TypeTable').DataTable({
                pageLength: 10,
                responsive: true,
                retrieve: true,
                order: [[0, "desc"]] // Orders by ut_id DESC
            });
        },
        error: function() {
            console.error("Failed to fetch data.");
        }
    });
}

		
		$(document).on('click', '.type-delete', function () {
			
			const id = $(this).data('id');
		
			//alert(id);
			
			$(this).del_modal({
				title : 'Delete ',
				head : 'Delete type',
				para: 'Do you want to Delete this?',
				id : id,
				url : '/UserType/delete?utId='+id,
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
				url: '/UserType/update_status',
				type: 'POST',
				data: { utId: id, status: newStatus },
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


	



</script>

