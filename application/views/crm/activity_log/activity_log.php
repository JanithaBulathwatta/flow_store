

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-12 mt-3">
				<div class="card custom-card">
					<div class="card-body"> 
						<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
							<div class="d-flex align-items-center"> 
								<span class="fw-medium fs-16 me-2">Activity Log Management </span>
								
								
								<div class="d-flex gap-2 flex-wrap" id="lead-status-container"> </div>
								
							
							</div> 
							
							<!--<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<button class="btn btn-success" id="btnAddLead"><i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Lead</button>
							</div>--> 
						</div> 
					</div>
					
				</div>
			</div>
		
			<div class="col-xl-12">
				<form id="data-filter">
					<div class="card mb-3 ">
						<div class="card-body row g-3">
							<div class="col-md-2">
								<label class="form-label mb-1">Date Range</label>
								<input type="text" id="date_range" class="date-range-input daterangepicker-field form-control-sm" placeholder="Select Date Range" data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" />
							</div>
							<div class="col-md-3">
								<label class="form-label mb-1">module</label>
								<select class="form-select js-example-basic-single form-select-sm" id="moduleFilter" aria-label=".form-select-sm example">
									<option value="">-- Select module --</option>
									<option value=""></option>
									<?php foreach ($modules as $module): ?>
										<option value="<?= $module->module_name; ?>"><?= html_escape($module->module_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="col-md-3">
								<label class="form-label mb-1">user</label>
								<select id="user_id" class="form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example">
									<option value="">-- Select user --</option>
									<?php foreach ($users as $user): ?>
										<option value="<?= $user->user_id; ?>">
											<?= html_escape($user->full_name); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<!--<div class="col-md-2">
								<label class="form-label mb-1">Priority</label>
								<select id="priorityid" class="form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example"> 
									<option value="">-- Select Priority --</option>
									<option value="low">Low</option>
									<option value="medium">Medium</option>
									<option value="high">High</option>
								</select>
							</div>-->
							
							<div class="col-md-2">
								<button type="submit" class="btn btn-primary w-100 mb-1 mr-10 mt-1 right" id="searchBtn">Search</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		
            <div class="col-xl-12">

                <div class="card custom-card">

                    <!-- HEADER -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title"> Activity Log List </div>
                    </div>

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="leadsTable" class="table table-stripe text-nowrap w-100 dataTable no-footer" aria-describedby="datatable-basic_info">

                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Module</th>
                                    <th>Action</th>
                                    <th>Action Type</th>
                                    <th>Action Response</th>
                                    <th>User Type</th>
                                    <th>User</th>
                                    <th>Created At</th>
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

<!-- Start:: Company Details Offcanvas -->
<!--<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExample">

<div class="offcanvas-body p-0">

<div class="d-sm-flex align-items-top p-3 border-bottom border-block-end-dashed">

<span class="avatar avatar-xxl avatar-rounded me-3 p-2 bg-primary-transparent">
<img src="../assets/images/company-logos/2.png" alt="">
</span>

<div class="flex-fill main-profile-info">

<div class="d-flex align-items-center justify-content-between">

<h6 class="fw-medium mb-1">
<span id="log_module">Module</span>

<span class="badge bg-success-transparent fs-10">
<i class="ri-circle-fill fs-8 text-success me-1"></i>
<span id="log_status">Status</span>
</span>

</h6>

<button type="button" class="btn-close crm-contact-close-btn"
data-bs-dismiss="offcanvas" aria-label="Close"></button>

</div>

<p class="mb-2 text-muted fs-12" id="log_description">
Activity description
</p>

<div class="d-flex gap-2 fs-15 mt-1">

<a href="javascript:void(0);" class="btn btn-sm btn-info">
<i class="ri-phone-line"></i>
<span id="log_action">Action</span>
</a>

<a href="javascript:void(0);" class="btn btn-sm btn-primary">
<i class="ri-mail-line"></i>
<span id="log_action_type">Action Type</span>
</a>

<a href="javascript:void(0);" class="btn btn-sm btn-success">
<i class="ri-message-line"></i>
<span id="log_user_role">User Role</span>
</a>

<div class="dropdown ms-auto">
<a href="javascript:void(0);" data-bs-toggle="dropdown"
class="btn btn-icon btn-sm btn-secondary-light">
<i class="ri-more-fill"></i>
</a>

<ul class="dropdown-menu dropdown-menu-end">
<li><a class="dropdown-item" href="#">Entity ID : <span id="log_entity_id"></span></a></li>
<li><a class="dropdown-item" href="#">Entity Type : <span id="log_entity_type"></span></a></li>
<li><a class="dropdown-item" href="#">Environment : <span id="log_environment"></span></a></li>
</ul>

</div>

</div>

</div>
</div>


<div class="d-flex mt-3 gap-3 p-1 py-0 border-bottom border-block-end-dashed">

<div class="p-2 text-center flex-fill">
<i class="ri-shake-hands-line p-2 fs-5 rounded-circle lh-1 text-fixed-white shadow-sm bg-primary"></i>
<p class="fw-semibold fs-20 text-shadow mb-0 mt-2" id="log_response_code">0</p>
<p class="mb-0 text-muted">Response Code</p>
</div>

<div class="p-2 text-center flex-fill">
<i class="ri-money-dollar-circle-line p-2 fs-5 rounded-circle lh-1 text-fixed-white shadow-sm bg-primary"></i>
<p class="fw-semibold fs-20 text-shadow mb-0 mt-2" id="log_device">Device</p>
<p class="mb-0 text-muted">Device Type</p>
</div>

<div class="p-2 text-center flex-fill">
<i class="ri-thumb-up-line p-2 fs-5 rounded-circle lh-1 text-fixed-white shadow-sm bg-primary"></i>
<p class="fw-semibold fs-20 text-shadow mb-0 mt-2" id="log_platform">Platform</p>
<p class="mb-0 text-muted">Platform</p>
</div>

</div>


<div class="p-3 border-bottom border-block-end-dashed">

<p class="fs-15 mb-2 fw-medium">Request Details :</p>

<p class="text-muted mb-0">

Method : <b id="log_request_method"></b> <br>
URL : <b id="log_request_url"></b> <br>
IP : <b id="log_ip"></b>

</p>

</div>


<div class="p-3 border-bottom border-block-end-dashed">

<p class="fs-14 mb-2 fw-medium">User Information :</p>

<div>

<div class="d-flex align-items-center mb-2">

<div class="me-2">
<span class="avatar avatar-sm avatar-rounded bg-primary-transparent">
<i class="ri-user-line align-middle fs-14"></i>
</span>
</div>

<div id="log_username">
Username
</div>

</div>

<div class="d-flex align-items-center mb-2">

<div class="me-2">
<span class="avatar avatar-sm avatar-rounded bg-secondary-transparent">
<i class="ri-user-settings-line align-middle fs-14"></i>
</span>
</div>

<div id="log_user_type">
User Type
</div>

</div>

<div class="d-flex align-items-center mb-0">

<div class="me-2">
<span class="avatar avatar-sm avatar-rounded bg-success-transparent">
<i class="ri-map-pin-line align-middle fs-14"></i>
</span>
</div>

<div id="log_server">
Server Name
</div>

</div>

</div>

</div>


<div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center flex-wrap gap-4">

<p class="fs-14 mb-0 fw-medium">Created Date:</p>

<div id="log_created_at">
Date
</div>

</div>


<div class="p-3 border-bottom border-block-end-dashed">

<p class="fs-14 mb-2 fw-medium">Changed Fields :</p>

<pre id="log_changed_fields" style="font-size:12px"></pre>

</div>


<div class="p-3 border-bottom border-block-end-dashed">

<p class="fs-14 mb-2 fw-medium">Old Data :</p>

<pre id="log_old_data" style="font-size:12px"></pre>

</div>


<div class="p-3 border-bottom border-block-end-dashed">

<p class="fs-14 mb-2 fw-medium">New Data :</p>

<pre id="log_new_data" style="font-size:12px"></pre>

</div>


<div class="p-3 d-flex align-items-center gap-3">

<div class="fs-14 fw-medium">
Session :
</div>

<div id="log_session">
Session ID
</div>

</div>

</div>
</div>-->

<!-- Start:: Activity Log Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample">

<div class="offcanvas-body p-0">

<!-- HEADER -->
<div class="d-sm-flex align-items-top p-4 border-bottom bg-light">

<span class="avatar avatar-xxl avatar-rounded me-3 p-2 bg-primary-transparent">
<i class="ri-file-list-3-line fs-28 text-primary"></i>
</span>

<div class="flex-fill">

<div class="d-flex align-items-center justify-content-between">

<h5 class="fw-semibold mb-1">
<span id="log_module">Module</span>

<span class="badge bg-success ms-2" id="log_status">
Status
</span>
</h5>

<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>

</div>

<p class="text-muted small mb-2" id="log_description">
Activity description
</p>

<div class="d-flex gap-2 flex-wrap">

<span class="badge bg-info-subtle text-info">
<i class="ri-flashlight-line me-1"></i>
<span id="log_action"></span>
</span>

<span class="badge bg-primary-subtle text-primary">
<i class="ri-edit-line me-1"></i>
<span id="log_action_type"></span>
</span>

<span class="badge bg-success-subtle text-success">
<i class="ri-user-line me-1"></i>
<span id="log_user_role"></span>
</span>

</div>

</div>
</div>


<!-- SUMMARY STATS -->
<div class="row g-0 border-bottom text-center">

<div class="col">
<div class="p-3">
<i class="ri-checkbox-circle-line fs-20 text-success"></i>
<h5 class="fw-semibold mt-2 mb-0" id="log_response_code">0</h5>
<p class="text-muted small mb-0">Response Code</p>
</div>
</div>

<div class="col border-start">
<div class="p-3">
<i class="ri-smartphone-line fs-20 text-primary"></i>
<h6 class="fw-semibold mt-2 mb-0" id="log_device">Device</h6>
<p class="text-muted small mb-0">Device Type</p>
</div>
</div>

<div class="col border-start">
<div class="p-3">
<i class="ri-android-line fs-20 text-success"></i>
<h6 class="fw-semibold mt-2 mb-0" id="log_platform">Platform</h6>
<p class="text-muted small mb-0">Platform</p>
</div>
</div>

</div>


<!-- REQUEST DETAILS -->
<div class="p-4 border-bottom">

<h6 class="fw-semibold mb-3">
<i class="ri-send-plane-line me-2 text-primary"></i>
Request Details
</h6>

<div class="small">

<div class="mb-2">
<span class="text-muted">Method</span><br>
<span class="fw-semibold" id="log_request_method"></span>
</div>

<div class="mb-2">
<span class="text-muted">URL</span><br>
<span class="fw-semibold text-break" id="log_request_url"></span>
</div>

<div>
<span class="text-muted">IP Address</span><br>
<span class="fw-semibold" id="log_ip"></span>
</div>

</div>

</div>


<!-- USER INFO -->
<div class="p-4 border-bottom">

<h6 class="fw-semibold mb-3">
<i class="ri-user-settings-line me-2 text-primary"></i>
User Information
</h6>

<div class="small">

<div class="d-flex align-items-center mb-2">
<i class="ri-user-line me-2 text-muted"></i>
<span id="log_username"></span>
</div>

<div class="d-flex align-items-center mb-2">
<i class="ri-shield-user-line me-2 text-muted"></i>
<span id="log_user_type"></span>
</div>

<div class="d-flex align-items-center">
<i class="ri-server-line me-2 text-muted"></i>
<span id="log_server"></span>
</div>

</div>

</div>


<!-- CREATED DATE -->
<div class="p-4 border-bottom">

<h6 class="fw-semibold mb-2">
<i class="ri-time-line me-2 text-primary"></i>
Created Date
</h6>

<span class="small text-muted" id="log_created_at"></span>

</div>


<!-- DATA CHANGES -->
<div class="p-4 border-bottom">

<h6 class="fw-semibold mb-3">
<i class="ri-edit-box-line me-2 text-primary"></i>
Changed Fields
</h6>

<pre class="bg-light border rounded p-3 small" id="log_changed_fields"></pre>

</div>


<div class="p-4 border-bottom">

<h6 class="fw-semibold mb-3">
<i class="ri-database-2-line me-2 text-primary"></i>
Old Data
</h6>

<pre class="bg-light border rounded p-3 small" id="log_old_data"></pre>

</div>


<div class="p-4 border-bottom">

<h6 class="fw-semibold mb-3">
<i class="ri-database-line me-2 text-primary"></i>
New Data
</h6>

<pre class="bg-light border rounded p-3 small" id="log_new_data"></pre>

</div>


<!-- SESSION -->
<div class="p-4">

<h6 class="fw-semibold mb-2">
<i class="ri-key-line me-2 text-primary"></i>
Session
</h6>

<span class="badge bg-secondary" id="log_session"></span>

</div>


</div>
</div>
<!-- End:: Company Details Offcanvas -->
<script>
$(document).ready(function () {

	document.addEventListener('hidden.bs.offcanvas', function () {
		document.querySelectorAll('.offcanvas-backdrop').forEach(el => el.remove());
	});
	
	// Handle Filter Submit
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });
	// side modal function
	$(document).on("click", ".viewLogBtn", function () {

		let id = $(this).data("id");

		$.ajax({
			url: "<?= site_url('Security/view'); ?>",
			type: "GET",
			data: { id: id },
			dataType: "json",
			success: function(res) {

				let log = res.customer;
				
				function formatJSON(data){
					try{
						return JSON.stringify(JSON.parse(data), null, 2);
					}catch{
						return data;
					}
				}

				$("#log_module").text(log.module);
				$("#log_status").text(log.status);
				$("#log_description").text(log.description);

				$("#log_action").text(log.action);
				$("#log_action_type").text(log.action_type);

				$("#log_username").text(log.user_name ?? log.username);
				$("#log_user_type").text(log.user_type);
				$("#log_server").text(log.server_name);

				$("#log_device").text(log.device_type);
				$("#log_platform").text(log.platform);
				$("#log_ip").text(log.ip_address);
				
				$("#log_session").text(log.session_id);

				$("#log_request_method").text(log.request_method);
				$("#log_request_url").text(log.request_url);

				$("#log_response_code").text(log.response_code);

				$("#log_old_data").text(formatJSON(log.old_data));
				$("#log_new_data").text(formatJSON(log.new_data));
				$("#log_changed_fields").text(formatJSON(log.changed_fields));

				$("#log_created_at").text(log.created_at);
				
				    // OPEN OFFCANVAS
				var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasExample'));
				offcanvas.show();
						}
		});

	});
    
    // Initialize Date Range Picker if you have the library
    if($('.date-range-input').length > 0) {
        $('.date-range-input').daterangepicker({
            autoUpdateInput: false,
            locale: { cancelLabel: 'Clear' }
        });
        $('.date-range-input').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
        });
    }

    // Load initial data
    filter();
    loadLeadCounts();



function filter() {
    // Destroy existing DataTable instance to prevent "Cannot reinitialise" error
    if ($.fn.DataTable.isDataTable('#leadsTable')) {
        $('#leadsTable').DataTable().destroy();
    }

    $.ajax({
        url: "<?= site_url('Security/filter'); ?>",
        type: "POST",
        data: {
            date_range: $('#date_range').val(),
            module: $('#moduleFilter').val(),
            user_type: $('#user_id').val()
        },
        dataType: "json",
        beforeSend: function() {
            $('#leadsTable tbody').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
        },
        success: function (res) {
            let tbody = '';

            if (res.data && res.data.length > 0) {
                $.each(res.data, function (i, log) {
                    
                    // Status Class Mapping (using our new light/dark system)
                   let statusClass = (log.status || '').toLowerCase() === 'success' ? 'bg-success' : ((log.status || '').toLowerCase() === 'failed' ? 'bg-danger' : 'bg-warning');
                    
                    // Action Type Class Mapping
                    let actionTypeClass = 
							(log.action_type || '').toLowerCase() === 'create' ? 'bg-success' :
							(log.action_type || '').toLowerCase() === 'update' ? 'bg-warning' :
							(log.action_type || '').toLowerCase() === 'delete' ? 'bg-danger' : 'bg-secondary';

                    tbody += `
                    <tr>
                        <td>${log.activitylog_id}</td>
                        <td><span class="fw-medium">${log.module}</span></td>
                        <td>${log.action}</td>
                        <td><span class="badge ${actionTypeClass}">${log.action_type}</span></td>
                        <td><span class="badge ${statusClass}">${log.status}</span></td>
                        <td>${log.user_type}</td>
                        <td>${log.full_name ?? (log.username ?? 'System')}</td>
                        <td>
                            ${(log.created_at || '').split(' ')[0]} <br>
                            <small class="text-muted">${(log.created_at || '').split(' ')[1] || ''}</small>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-icon btn-info-light viewLogBtn"
                                    data-id="${log.activitylog_id}">
                                <i class="ri-eye-line"></i>
                            </button>
                        </td>
                    </tr>`;
                });
            } else {
                tbody = '<tr><td colspan="9" class="text-center text-muted">No activity logs found</td></tr>';
            }

            $('#leadsTable tbody').html(tbody);

            // Re-initialize DataTable
            $('#leadsTable').DataTable({
                "order": [[0, "desc"]],
                "pageLength": 10,
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search logs..."
                }
            });
        },
        error: function(xhr) {
            console.error("Fetch Error:", xhr.responseText);
            $('#leadsTable tbody').html('<tr><td colspan="9" class="text-center text-danger">Failed to load data.</td></tr>');
        }
    });
}
	
});
</script>


