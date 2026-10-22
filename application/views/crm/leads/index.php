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
								<span class="card-title me-6">Lead management </span>
								
								
								<div class="d-flex gap-2 flex-wrap align-items-center" id="lead-status-container">
									<!--<div id="pill-total"     class="stat-pill"><span class="num" id="val-total">—</span>     <span class="lbl">Total</span></div>-->
									<!--<div id="pill-following" class="stat-pill"><span class="num" id="val-following">—</span> <span class="lbl">Following</span></div>
									<div id="pill-pending"   class="stat-pill"><span class="num" id="val-pending">—</span>   <span class="lbl">Pending</span></div>
									<div id="pill-converted" class="stat-pill"><span class="num" id="val-converted">—</span> <span class="lbl">Converted</span></div>
									<div id="pill-rejected"  class="stat-pill"><span class="num" id="val-rejected">—</span>  <span class="lbl">Rejected</span></div>-->
								</div>
								
							
							</div> 
							
							<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<button class="btn btn-add btn-wave" id="btnAddLead"><i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Lead</button>
							</div> 
						</div> 
					</div>
					
					<div class="summary-bar" id="summary-bar"></div>
					
				</div>
			</div>
		
			<div class="col-xl-12">
				<form id="data-filter">
					<div class="card mb-3 ">
						<div class="card-body row g-3">
							<div class="col-md-2">
								<label class="text-black-normal label mb-1">Date Range</label>
								<input type="text" class="date-range-input daterangepicker-field form-control-sm" placeholder="Select Date Range" data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" />
							</div>
							<div class="col-md-3">
								<label class="text-black-normal label mb-1">Product</label>
								<select class="form-select js-example-basic-single form-select-sm" id="productFilter" aria-label=".form-select-sm example">
									<option value="">-- Select Product --</option>
									<?php foreach ($products as $product): ?>
										<option value="<?= $product->id; ?>"><?= html_escape($product->name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="col-md-3">
								<label class="text-black-normal label mb-1">Lead Status</label>
								<select id="statusid" class="form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example">
									<option value="">-- Select Status --</option>
									<?php foreach ($statuses as $status): ?>
										<option value="<?= $status->id; ?>">
											<?= html_escape($status->name); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="col-md-2">
								<label class="text-black-normal label mb-1">Priority</label>
								<select id="priorityid" class="form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example"> 
									<option value="">-- Select Priority --</option>
									<option value="low">Low</option>
									<option value="medium">Medium</option>
									<option value="high">High</option>
								</select>
							</div>
							
							<div class="col-md-2">
								<button type="submit" class="btn btn-search w-100 mb-1 mr-10 mt-1 right" id="searchBtn">Search</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		
            <div class="col-xl-12">

                <div class="card custom-card">

                    <!-- HEADER -->
                    <!--<div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title"> Leads List </div>
                    </div>-->

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="leadsTable" class="table table-stripe text-nowrap w-100 dataTable no-footer" aria-describedby="datatable-basic_info">

                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Contact</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                    <th>Assigned</th>
                                    <th>Created</th>
                                    <th>Last Reply</th>
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
                    <input type="hidden" id="lead_id" name="lid">

                    <div class="row gy-3">
					
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Customer Name *</label>
                            <input type="text"  name="customer_name" id="customer_name" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Customer Email *</label>
                            <input type="email" name="customer_email" id="customer_email" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Customer Phone *</label>
                            <input type="text" name="customer_phone" id="customer_phone" class="form-control form-control-sm required phone" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Source *</label>
                            <input type="text" name="source" id="source" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-3 mt-1">
                            <label class="form-label">Product *</label>
                            <select id="product_id" name="product_id" class="form-control form-select-sm" required>
                                <option value="">-- Select Product --</option>
								<?php foreach ($products as $product): ?>
                                    <option value="<?= $product->id; ?>"><?= html_escape($product->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
						
                        <div class="col-xl-3 mt-1">
                            <label class="form-label">Status *</label>
                            <select id="status_id" name="status_id" class="form-control form-select-sm" required>
                                <option value="">Select Status</option>
								<?php foreach ($statuses as $status): ?>
                                    <option value="<?= $status->id; ?>"><?= html_escape($status->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xl-3 mt-1">
                            <label class="form-label">Assign To *</label>
                            <select id="assigned_user_id" name="assigned_user_id" class="form-control form-select-sm" required>
                                <?php foreach ($users as $user): ?>
                                    <option value="">Select Assign To</option>
									<option value="<?= $user->user_id; ?>"><?= html_escape($user->full_name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xl-3 mt-1">
                            <label class="form-label">Priority *</label>
                            <select id="priority" name="priority" class="form-control form-select-sm" required>
                                <option value="">Select Priority</option>
								<option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Notes</label>
                            <textarea id="notes" name="notes" class="form-control form-control-sm" rows="3"></textarea>
                        </div>
					
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
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
		
		//load data to lead count by status
		/*function loadLeadCounts() {
			$.ajax({
				url: "/Leads/get_lead_counts_ajax",
				type: "GET",
				dataType: "json",
				success: function(response) {
					response.forEach(function(status) {
						const key = (status.name || '').toLowerCase();
						$('#val-' + key).text(status.total);
						$('#pill-' + key).data('id', status.lid);
					});
				}
			});
		}*/
		
		/* ═══════════════════════ DATA ═══════════════════════ */
		// AJAX call for GRN Dashboard
		var GRN_ITEMS = [];
		var STATUS_LABELS = {};
		var STATUS_CSS    = {};
		var STATUS_ICON   = {};
		
		function loadLeadCounts() {
		$.ajax({
			url: "/Leads/get_lead_counts_ajax",
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
						STATUS_LABELS[key] = item.name + ' count';
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
		//var totalGrns = GRN_ITEMS.reduce(function(acc, item) { return acc + parseInt(item.total || 0); }, 0);
		
		// Mapping config for display panels
		var itemsConfig = {
			converted:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Payment Completed' },
			pending:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Awaiting Verification' },
			total: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
			rejected: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Needs Correction' },
			following:    { icon: 'fa-file-lines',    bg: 'var(--primary-light)', ic: 'var(--primary)', sub: 'Saved Workspaces' }
		};

		// Generating array structure for your map generator loop
		var displayItems = GRN_ITEMS.map(function(item) {
			var key = (item.name || '').toLowerCase();
			var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Category' };
			
			// Dynamic addition of spans for specific status types
			var extraHtml = '';
			if (key === 'settled') {
				// Adds placeholder span for Sale Total under Verified Documents
				extraHtml = '<div class="sbi-extra-amt" style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #475569;">'
						  + 'Sale Total: <span id="totalGrnAmount" style="color:' + cfg.ic + '">'+ Sale_total +'</span>'
						  + '</div>';
			} if (key === 'outstanding') {
				// Adds placeholder span for Total Due under Awaiting Verification
				extraHtml = '<div class="sbi-extra-amt" style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #475569;">'
						  + 'Total Due: <span id="totalDueAmount" style="color:' + cfg.ic + '">'+ Total_Due +'</span>'
						  + '</div>';
			}

			return {
				icon: cfg.icon,
				ibg: cfg.bg,
				ic: cfg.ic,
				val: item.total,
				lbl: STATUS_LABELS[key] || item.name,
				sub: cfg.sub,
				extra: extraHtml
			};
		});

		// Automatically inject a "Total" card at the front of the summary bar array
		/*displayItems.unshift({
			icon: 'fa-boxes-stacked',
			ibg: '#e0f2fe',
			ic: '#0369a1',
			val: totalGrns,
			lbl: 'Total GRN Records',
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

		loadLeadCounts();
		
		//Submit lead for save or Update
 		$('#leadForm').ajax_submit({
			url :'/Leads/store', 
			rest: false,
			callback : function(id){
				$('#leadForm')[0].reset()
				filter();
				loadLeadCounts();
			}
		}); 
		

		/*click function for "Add lead" button 
			* Change modal title,
			* Button value,
			* reset form,
			* Clear Lead id (if loaded)
			* trigger the modal
		*/
		$('#btnAddLead').click(function () {
			$('#leadModalTitle').text('New Lead');
			$('#btn-sub').text('Save');
			$('#leadForm')[0].reset();
			$('#lead_id').val('');
			formModal.show();
		});

		// Click function get data for EDIT
		$(document).on('click', '.btnEditLead', function () {

			let id = $(this).data('id');

			$('#leadModalTitle').text('Edit Lead');
			$('#btn-sub').text('Edit');
			$('#lead_id').val(id);
			formModal.show();

			$.getJSON("<?= site_url('/Leads/view?lid='); ?>" + id, function (res) {
				
				console.log(res);
				
				$('#customer_name').val(res.lead.customer_name);
				$('#customer_email').val(res.lead.customer_email);
				$('#customer_phone').val(res.lead.customer_phone);
				$('#source').val(res.lead.source);
				$('#product_id').val(res.lead.product_id);
				$('#status_id').val(res.lead.status_id);
				$('#assigned_user_id').val(res.lead.assigned_user_id);
				$('#priority').val(res.lead.priority);
				$('#notes').val(res.lead.notes);

			});

		});

		$('#data-filter').on('submit', function (e) {
			e.preventDefault();
			filter();
		});

		$(document).on('click', '.lead-delete', function () {            
			const id = $(this).data('id');
			dellead(this, id);
		});

		function dellead(el, id){
			$(el).del_modal({
				title : 'Delete',
				head  : 'Delete lead',
				para  : 'Do you want to delete this?',
				id    : id,
				url   : '/Leads/delete?lid=' + id,

				callback: function () {
					// plugin already confirmed success
					filter();   // refresh table
				}
			});
		}
		
		function filter(statusId = null){

			/*if ($.fn.DataTable.isDataTable('#leadsTable')) {
				$('#leadsTable').DataTable().destroy();
			}*/
			
			if ($.fn.DataTable.isDataTable('#leadsTable')) {
				let table = $('#leadsTable').DataTable();
				table.clear().destroy();
			}
			

			$.ajax({
				url: "<?= site_url('/Leads/filter'); ?>",
				type: "POST",
				data: {
					//date: $('#daterange').val(),
					date: $('.date-range-input').val(),
					product_id: $('#productFilter').val(),
					status_id: statusId ?? $('#statusid').val(), // ✅ FIX,
					priority: $('#priorityid').val()
				},
				dataType: "json",
				success: function (res) {

					let tbody = '';

					if (res.data.length > 0) {
						
						console.log(res.data);
						
						$.each(res.data, function (i, lead) {
							
							let lid = (i+1);
							let days = parseInt(lead.days_since_created);
							let dayColor = days < 7 ? 'bg-success' : (days <= 14 ? 'bg-warning' : 'bg-danger');

							let p = (lead.priority || '').toLowerCase();
							let pColor = p === 'high'   ? 'bg-danger' :
										 p === 'medium' ? 'bg-warning' :
										 p === 'low'    ? 'bg-success' : 'bg-secondary';

							let actionBtns = '';

							if (lead.status_name === 'Converted' || lead.status_name === 'Rejected') {
								actionBtns = `<button class="btn btn-outline-secondary inactive-btn" disabled>
												Already ${lead.status_name}
											  </button>`;
							} else {
								actionBtns = `
									<button class="btn btn-sm btn-icon btn-info-light viewBtn2" data-id="${lead.id}">
										<i class="ri-eye-line"></i>
									</button>
									<button class="btn btn-sm btn-icon btn-warning-light btnEditLead" data-id="${lead.id}">
										<i class="ri-edit-line"></i>
									</button>
									<button class="btn btn-sm btn-danger-light btn-icon lead-delete" data-id="${lead.id}">
										<i class="ri-delete-bin-line"></i>
									</button>`;
							}

							tbody += `
							<tr>
								<td>${lid}</td>
								<td>
									<span class="fw-medium">${lead.customer_name}</span><br>
									<small class="text-black-normal">Source : ${lead.source}</small>
								</td>
								<td>
									${lead.customer_email ?? ''}<br>
									${lead.customer_phone ?? ''}
								</td>
								<td>${lead.product_name ?? '-'} 
									<span class="badge ${pColor}" style="background:">
										${lead.priority}
									</span>
								</td>
								<td>
									<span class="badge ${lead.status_color}">
										${lead.status_name}
									</span>
								</td>
								<td>${lead.assigned_user_name}</td>
								<td>
									${(lead.created_at || '').split(' ')[0]}<br>
									<span class="badge ${dayColor}" style="background:">
										${days} days
									</span>
								</td>
								<td>
									${lead.last_comment_date ?? '-'}<br>
									<small class="text-black-normal">
										${lead.last_comment ?? 'N/A'}
										<span class="badge bg-secondary">
											${lead.comment_count}
										</span>
									</small>
								</td>
								<td>${actionBtns}</td>
							</tr>`;
						});

					} else {
						tbody = `<tr>
									<td colspan="10" class="text-center text-black-normal">
										No leads found
									</td>
								 </tr>`;
						$('#leadsTable').DataTable();
					}

					$('#leadsTable tbody').html(tbody);

					// ✅ CRITICAL FIX
					table = initializeDataTable('#leadsTable');
				}
			});
		}

		$(document).on('click', '.btnViewLead', function () {

			let id = $(this).data('id');
			const modal = new bootstrap.Modal(document.getElementById('leadViewModal'));

			modal.show();

			$.getJSON("<?= site_url('Leads/view?lid='); ?>" + id, function (res) {

				let lead = res.lead;

				$('#lead_name').text(lead.customer_name);
				$('#lead_product').text('' + (lead.product_name ?? '-'));
				$('#leadid').val(id);
				$('#leid').val(id);

				$('#lead_phone').html(`${lead.customer_phone ?? '-'}`);
				$('#lead_email').html(`${lead.customer_email ?? '-'}`);

				$('#lead_priority').text(lead.priority);
				$('#lead_source').text(lead.source ?? '-');
				$('#lead_created').text(lead.created_at);
				
				$('#lead_assigned_id').val(lead.assigned_user_id);

				$('#lead_notes').html(
					lead.notes ? lead.notes.replace(/\n/g,"<br>") : 'No notes'
				);

				$('#lead_assigned').text(lead.assigned_user_name ?? '-');

				$('#lead_status_badge')
					.text(lead.status_name)
					.css('background', lead.status_color);

				$('#comment_lead_id').val(lead.id);

				loadComments(lead.id);
				loadHistory(lead.id);

			});

		});
		
		

		function loadComments(leadId) {
			$('#commentsContainer').html('<div class="col-12 text-black-soft">Loading...</div>');
			
			$.ajax({
				url: "<?= site_url('LeadComments/list?lid='); ?>" + leadId, // ✅ FIXED
				type: "GET",
				dataType: "json",
				success: function (res) {
					
					console.log(res);
					
					let html = '';

					if (res.comments && res.comments.length > 0) {

						$.each(res.comments, function (i, c) {

							html += `<li> 
										<div> 
											<span class="avatar avatar-sm avatar-rounded profile-timeline-avatar"> 
												<img src="/assets/images/faces/8.jpg" alt="Emma"> 
											</span> 
											<p class="text-black-soft mb-2"> 
												<span class="text-default"> 
													<span class="fw-medium">${c.commented_by ?? 'User'}</span> - " ${c.comment ?? ''} " 
												</span> <br>
												<span class="float-end fs-11 badge bg-light text-black-soft">${c.created_at ?? ''}</span> 
											</p>
										</div> 
									</li>`;
						});

					} else {

						html = `
						<div class="col-12">
							<div class="text-black-soft text-center py-4">
								no comment into show
							</div>
						</div>
						`;
					}

					$('#comments-container').html(html);
				},
				error: function () {
					$('#comments-container').html(`
						<div class="col-12">
							<div class="text-black-soft text-center py-4">
								no comment into show
							</div>
						</div>
					`);
				}
			});
		}

		function loadHistory(leadId) {
		
			$('#assignment-history').html('<div class="col-12 text-black-soft">Loading...</div>');

				$.ajax({
					url: "<?= site_url('LeadAssignments/history?lid='); ?>" + leadId,
					type: "GET",
					dataType: "json",
					success: function (res) {
						console.log(res);
						let html = '';

						if (res.history && res.history.length > 0) {

							$.each(res.history, function (i, h) {

								html +=`<br>
										<div class="fw-medium"> 
											<div class="text-truncate mb-1">${h.assigned_to ?? 'User'} - Assigned by : ${h.assigned_by ?? ''} <span class="bg-info-transparent badge">${h.assigned_at ?? 'User'}</span></div>
										</div>`;
							});

						} else {

							html = `
							<div class="col-12">
								<div class="text-black-soft text-center py-3">no assignment history</div>
							</div>
							`;
						}

						$('#assignment-history').html(html);
					},
					error: function () {
						$('#assignment-history').html(`
							<div class="col-12">
								<div class="text-black-soft text-center py-3">
									no assignment history
								</div>
							</div>
						`);
					}
				});
		}


		$(document).on('submit', '#commentForm', function (e) {

			e.preventDefault();

			$.post(
				"<?= site_url('LeadComments/store'); ?>",
				$(this).serialize(),
				function (res) {

					if (res.success) {
						toastr.success("Comment added");
						$('#commentForm')[0].reset();
						loadComments(res.lead_id);
						//loadComments();
					} else {
						toastr.error(res.message);
					}

				},
				'json'
			);
		});


		$(document).on('submit', '#assignForm', function (e) {

			e.preventDefault();
			
			var current_user = $('#auid').val();
			var assigned = $('#lead_assigned_id').val();
				
			if(current_user == assigned){
				toastr.error('You cannot Reassign to yourself');
				return;
			}else{
				$.ajax({
					url: "<?= site_url('LeadAssignments/assign'); ?>",
					type: "POST",
					data: $(this).serialize(),
					dataType: "json",
					callback: function (res) {
						if (res.success) {
							toastr.success(res.message);
							loadHistory(res.lead_id);
						} else {
							toastr.error(res.message);
						}
					},
					error: function (xhr) {
						console.error("AJAX error", xhr.responseText);
					}
				});
			}
			
		});
		
		$(document).on("click", ".viewBtn2", function() {
			let id = $(this).data('id');
			window.location.href = "/Leads/lead_view?lead_id=" + id;
		});


		$(document).on('click', '.lead-status-card', function () {

			let statusId = $(this).attr('data-id'); // safer

			console.log("FINAL ID:", statusId);

			filter(statusId); // ✅ DIRECT PASS
		});
		
		
	});

	

</script>
