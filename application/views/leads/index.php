<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-12 mt-3">
				<div class="card custom-card">
					<div class="card-body"> 
						<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
							<div class="d-flex align-items-center"> 
								<span class="fw-medium fs-16 me-2">Lead management </span>
								
								
								<div class="d-flex gap-2 flex-wrap" id="lead-status-container"> </div>
								
							
							</div> 
							
							<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<button class="btn btn-success" id="btnAddLead"><i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Lead</button>
							</div> 
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
								<input type="text" name="daterange" class="form-control form-control-sm" id="dateRange" data-bind="daterangepicker: dateRange">
								<!--<input type="date" class="form-control form-control-sm" id="dateRange">
								<div class="col-lg-12 control-section">
									<div id="wrapper">
										<input type="text" id="daterange" data-bind="daterangepicker: dateRange" class="form-control form-control-sm"/><br/><br/>
									</div>
								</div>-->
							</div>
							<div class="col-md-3">
								<label class="form-label mb-1">Product</label>
								<select class="form-select js-example-basic-single form-select-sm" id="productFilter" aria-label=".form-select-sm example">
									<option value="">-- Select Product --</option>
									<?php foreach ($products as $product): ?>
										<option value="<?= $product->id; ?>"><?= html_escape($product->name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="col-md-3">
								<label class="form-label mb-1">Lead Status</label>
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
								<label class="form-label mb-1">Priority</label>
								<select id="priorityid" class="form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example"> 
									<option value="">-- Select Priority --</option>
									<option value="low">Low</option>
									<option value="medium">Medium</option>
									<option value="high">High</option>
								</select>
							</div>
							
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
                        <div class="card-title"> Leads List </div>
                    </div>

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
                            <label class="form-label">Customer Email</label>
                            <input type="email" name="customer_email" id="customer_email" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Customer Phone</label>
                            <input type="text" name="customer_phone" id="customer_phone" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Source</label>
                            <input type="text" name="source" id="source" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-3 mt-1">
                            <label class="form-label">Product</label>
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
									<option value="<?= $user->id; ?>">
                                        <?= html_escape($user->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xl-3 mt-1">
                            <label class="form-label">Priority</label>
                            <select id="priority" name="priority" class="form-control form-select-sm" required>
                                <option value="">Select Priority</option>
								<option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <div class="col-xl-12 mt-1">
                            <label class="form-label">Notes</label>
                            <textarea id="notes" name="notes" class="form-control form-control-sm" rows="3" required></textarea>
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
		
	});
	
	$('#data-filter').on('submit', function (e) {
		e.preventDefault();
		filter();
	});
	
	function filter(){

		if ($.fn.DataTable.isDataTable('#leadsTable')) {
			$('#leadsTable').DataTable().destroy();
		}
		

		$.ajax({
			url: "<?= site_url('/Leads_1/filter'); ?>",
			type: "POST",
			data: {
				date: $('#daterange').val(),
				product_id: $('#productFilter').val(),
				status_id: $('#statusid').val(),
				priority: $('#priorityid').val()
			},
			dataType: "json",
			success: function (res) {

				let tbody = '';

				console.log('filter woerk');

				if (res.data.length > 0) {
					$.each(res.data, function (i, lead) {

						let days = parseInt(lead.days_since_created);
						let dayColor = days < 7 ? '#1dd871' : (days <= 14 ? '#ff7f50' : '#f04d4d');

						let p = (lead.priority || '').toLowerCase();
						let pColor = p === 'high' ? '#f47373' :
									 p === 'medium' ? '#f79a78' :
									 p === 'low' ? '#72eca9' : '#ccc';

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
							<td>${lead.lead_code ?? lead.id}</td>
							<td>
								<span class="fw-medium">${lead.customer_name}</span><br>
								<small class="text-muted">Source : ${lead.source}</small>
							</td>
							<td>
								${lead.customer_email ?? ''}<br>
								${lead.customer_phone ?? ''}
							</td>
							<td>${lead.product_name ?? '-'} 
								<span class="badge" style="background:${pColor}">
									${lead.priority}
								</span>
							</td>
							<td>
								<span class="badge" style="background:${lead.status_color};color:#fff">
									${lead.status_name}
								</span>
							</td>
							<td>${lead.assigned_user_name}</td>
							<td>
								${(lead.created_at || '').split(' ')[0]}<br>
								<span class="badge" style="background:${dayColor}">
									${days} days
								</span>
							</td>
							<td>
								${lead.last_comment_date ?? '-'}<br>
								<small class="text-muted">
									${lead.last_comment ?? 'N/A'}
									<span class="badge bg-primary">
										${lead.comment_count}
									</span>
								</small>
							</td>
							<td>${actionBtns}</td>
						</tr>`;
					});

				} else {
					tbody = `<tr>
								<td colspan="10" class="text-center text-muted">
									No leads found
								</td>
							 </tr>`;
				}

				$('#leadsTable tbody').html(tbody);

				// ✅ CRITICAL FIX
				table = initializeDataTable('#leadsTable');
			}
		});
	}
	
</script>