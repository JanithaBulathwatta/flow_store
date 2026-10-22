<style>
	.table th, .table td {
		padding: 0.15rem 1rem;
		vertical-align: middle;
		line-height: 1.462;
		font-size: 0.813rem;
		font-weight: 400;
	}
	
	.text-white{
		color:#fff;
	}
	
	.p-31 {
		padding: 0.5rem !important;
	}
	
	/* Success */
	.toast-success {
		background-color: #28a745 !important; /* green */
	}

	/* Error */
	.toast-error {
		background-color: #dc3545 !important; /* red */
	}

	/* Info */
	.toast-info {
		background-color: #17a2b8 !important; /* blue */
	}

	/* Warning */
	.toast-warning {
		background-color: #ffc107 !important; /* yellow */
		color: #000 !important;
	}
	
	
	
	
	
	#page-loader {
		position: fixed;
		width: 100%;
		height: 100%;
		background: #ffffff;
		top: 0;
		left: 0;
		z-index: 9999;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.spinner {
		width: 40px;
		height: 40px;
		border: 4px solid #ddd;
		border-top: 4px solid #3498db;
		border-radius: 50%;
		animation: spin 0.8s linear infinite;
	}

	@keyframes spin {
		100% { transform: rotate(360deg); }
	}
</style>


<div id="page-loader">
    <div class="spinner"></div>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
		<input type="hidden" id="lead_assigned_id">
     
        <!-- Start::row-1 -->
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="row mx-0 justify-content-center gy-3 gy-xxl-0">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card custom-card shadow-none border mb-0 overflow-hidden">
                            <div class="card-body">
                                <div class="row">	
                                    <div class="col-xl-12 mt-xxl-0 mt-3">
                                        <div class="d-flex gap-2 align-items-center justify-content-between mb-3 flex-wrap">
                                            <div>
                                                <h4 class="fw-medium mb-1">New Lead For - <span id="lead_product"> </span></h4>
                                                <span class="fw-medium">Lead Status : </span><span class="mb-0 fs-14 fw-medium text-white px-1 rounded me-2" id="lead_status_badge">Pending</span>
                                                <i class="bi bi-patch-check-fill text-success align-middle lh-1 fs-15" data-bs-toggle="tooltip" aria-label="Verified" data-bs-original-title="Verified"></i>
												
												<form id="change-st">
													<div class="mb-3">
														<div class="col-sm-11 mt-1">
															<input type="hidden" id="ledid" name="lead_id">
															<select id="status_id" name="status_id" class="form-select" required>
																<option value="">Change Lead Status</option>
																<?php foreach ($statuses as $status): ?>
																	<option value="<?= $status->id; ?>">
																		<?= html_escape($status->name); ?>
																	</option>
																<?php endforeach; ?>
															</select>
														</div>
													</div>
												</form>
												
                                            </div>
											
                                            <div class="ms-auto">
                                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                                    <div class="fw-medium">Priority:</div>
                                                    <p class="mb-0 border border-dark border-opacity-75 fw-medium nft-auction-time ms-auto px-2 rounded fs-15 flex-shrink-0" id="lead_priority"> Low</p>
                                                </div>
                                            </div>
                                        </div>
										
                                        <div class="mb-3">
                                            <p class="fs-15 fw-medium mb-1">Description :</p>
                                            <p class="text-muted mb-0" id="lead_notes"> </p>
                                        </div>
                                        <div class="d-flex align-items-center gap-xxl-5 gap-3 mb-3 justify-content-between flex-wrap">
                                            <div>
                                                <div class="mb-2">
                                                    Product<i class="ri-price-tag-line text-pink lh-1 mx-1"></i> :
                                                </div>
                                                <h5 class="fw-semibold mb-0 bid-amt align-middle mb-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 40 65">
                                                        <g fill="none" fill-rule="evenodd">
                                                            <g fill-rule="nonzero" transform="translate(-227 -93)">
                                                                <g transform="translate(227 93)">
                                                                    <g>
                                                                        <path
                                                                            fill="#8A92B2"
                                                                            d="M20.1.8v23.3c0 .1-.1.2-.2.2-.7.3-1.3.6-2 .9-.9.4-1.9.8-2.8 1.3L11.8 28l-2.7 1.2-3.3 1.5c-.9.4-1.8.8-2.8 1.3-.7.3-1.5.7-2.2 1-.1 0-.1.1-.2 0H.5c.3-.5.6-.9.9-1.4 1.6-2.7 3.3-5.4 4.9-8.1 1.7-2.9 3.5-5.8 5.2-8.7 1.6-2.7 3.2-5.4 4.8-8 1.2-2 2.4-3.9 3.5-5.9.2 0 .2-.1.3-.1-.1 0 0 0 0 0z"
                                                                        ></path>
                                                                        <path
                                                                            fill="#454A75"
                                                                            d="M39.5 33c-1.5 1-3.1 1.9-4.6 2.8-4.9 2.9-9.7 5.7-14.6 8.6-.1 0-.1.1-.2.1s-.1-.1-.1-.1v-.3-19.5-.3c0-.1.1-.1.2-.1.4.2.8.4 1.3.6 1.2.6 2.5 1.1 3.7 1.7 1.1.5 2.1 1 3.2 1.4 1.1.5 2.1 1 3.2 1.5.9.4 1.9.8 2.8 1.3.9.4 1.9.8 2.8 1.3.7.3 1.4.7 2.2 1 0-.1 0 0 .1 0z"
                                                                        ></path>
                                                                        <path
                                                                            fill="#8A92B2"
                                                                            d="M20.1 64.1s-.1 0 0 0c-.1 0-.1 0-.2-.1-2-2.8-3.9-5.5-5.9-8.3l-6-8.4c-1.9-2.7-3.9-5.4-5.8-8.2L.7 37c0-.1-.1-.1-.1-.2.1 0 .1.1.2.1 2.7 1.6 5.5 3.2 8.2 4.8 3.1 1.9 6.3 3.7 9.4 5.6.5.3 1.1.6 1.6.9.1 0 .1.1.1.2V64.1z"
                                                                        ></path>
                                                                        <path
                                                                            fill="gray"
                                                                            d="M.6 33s.1 0 0 0c.1 0 .1 0 0 0 0 .1 0 .1 0 0z"
                                                                        ></path>
                                                                        <path
                                                                            fill="#62688F"
                                                                            d="M.7 33.1c0-.1 0-.1 0 0 1-.5 2-.9 3-1.4l3.9-1.8c1-.5 2-.9 3-1.4 1.4-.7 2.9-1.3 4.3-2 1-.4 2-.9 3-1.3.7-.3 1.4-.6 2.1-1 .1 0 .1-.1.2-.1V44.5c-.1.1-.1 0-.2 0-.3-.2-.6-.3-.8-.5L.9 33.2c-.1-.1-.2-.1-.2-.1zM39.4 36.8c0 .1 0 .1-.1.2-5.8 8.2-11.6 16.3-17.4 24.5-.6.9-1.2 1.7-1.8 2.6V64v-.2-15.3-.3c1.3-.8 2.6-1.6 3.9-2.3l15.3-9c0-.1.1-.1.1-.1z"
                                                                        ></path>
                                                                        <path
                                                                            fill="#62688F"
                                                                            d="M20.1 24.2V24 1.1.9l19.2 31.8c.1.1.2.2.2.3-.4-.2-.8-.4-1.3-.6-.5-.2-1-.5-1.5-.7-.3-.1-.6-.3-1-.4-.5-.2-1.1-.5-1.6-.7-.3-.1-.6-.3-.9-.4l-2.1-.9c-.4-.2-.7-.3-1.1-.5-.5-.2-1-.5-1.5-.7-.3-.1-.6-.3-.9-.4l-2.1-.9c-.4-.2-.7-.3-1.1-.5-.5-.2-1-.5-1.5-.7-.3-.2-.7-.3-1-.5l-1.8-.9z"
                                                                        ></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                    <span id="lead_product2"></span>
                                                </h5>
                                            </div>
                                            <div>
                                                <div class="fw-normal mb-2">
                                                    Lead Source<i class="ri-nft-line text-pink lh-1 fs-14 mx-1"></i> :
                                                </div>
                                                <div class="d-flex align-items-center fw-medium gap-1">
                                                    <span class="avatar avatar-xs avatar-rounded lh-1"
                                                        ><img src="../assets/images/nft-images/2.png" alt=""
                                                    /></span>
                                                    <span id="lead_source"> </span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mb-2">
                                                    Lead Date<i class="ri-article-line text-pink lh-1 fs-14 mx-1"></i> :
                                                </p>
                                                <div>
                                                    <i class="ri-calendar-event-line text-primary me-1"></i><span id="lead_created"></span>
                                                </div>
                                            </div>
                                            <div class="me-3">
                                                <div class="fw-normal mb-2">
                                                    Assigned By<i class="ri-vip-crown-2-line text-pink lh-1 fs-14 mx-1"></i>:
                                                </div>
                                                <div class="d-flex align-items-center fw-medium gap-1">
                                                    <span class="avatar avatar-xs avatar-rounded lh-1"
                                                        ><img src="../assets/images/faces/9.jpg" alt=""
                                                    /></span>
                                                    <span id="lead_assigned"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
										<div class="row">
											<div class="col-xl-8"></div>
											
										</div>
										
										<div class="row mb-3 gy-3 gy-xl-0">
											
											<div class="col-xl-7">
                                                <h6 class="mb-3">Customer Details:</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered text-nowrap">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row" class="fw-medium">Customer Name</th>
                                                                <td><span id="lead_name"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="fw-medium">Contact Number</th>
                                                                <td>
                                                                    <span id="lead_phone"></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="fw-medium">Email</th>
                                                                <td><span id="lead_email"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="fw-medium">Source</th>
                                                                <td><span id="lead_source2"></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
											
											<div class="col-sm-5">	
												
												 <h6 class="mb-3">Lead Assign:</h6>
											
												<form id="assignForm">
													<input type="hidden" name="lead_id" id="leid">

													<select name="assigned_user_id" id="auid" class="form-select w-100 mb-3 mt-3" required>
														<option value="">Select Assign To</option>
														<?php foreach ($users as $user): ?>
															<option value="<?= $user->user_id; ?>"><?= html_escape($user->full_name); ?></option>
														<?php endforeach; ?>
													</select>

													<button type="submit" class="btn btn-warning btn-sm w-100">
														<i class="ri-user-line me-1"></i>
														Reassign
													</button>
												</form>
											</div>
											
                                        </div>
										
										<div class="row">	
											
											<div class="col-sm-7">
												<h6 class="mb-3">Lead Comment History: <i class="ri-edit-line"></i></h6>
												<ul class="list-unstyled profile-timeline mb-3" id="comments-container"> 
													
												</ul>
												
												<form id="commentForm">
													<input type="hidden" name="lead_id" id="leadid" value="${lead.id}">
													<textarea name="comment" class="form-control" rows="3" placeholder="Add a comment..." required></textarea>

													<div class="text-end mt-2">
														<button type="submit" class="btn btn-primary btn-sm"> <i class="ri-chat-1-line me-1"></i> Add Comment </button>
													</div>
												</form>
													
											</div>
											
											<div class="col-xl-5">
												
												<h6 class="mb-3">Lead Assignment History:</h6>
											
												<div class="row mb-3 gy-3 gy-xl-0" id="assignment-history">
                                                
												</div>
                                            </div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->
    </div>
</div>

<script>
	
	$(window).on("load", function () {
		$("#page-loader").fadeOut(500);
		var id = "<?=$_GET['lead_id'];?>";
		loadComments(id);
		loadHistory(id);
		
	});
	
	var id = "<?=$_GET['lead_id'];?>";
	
	$.getJSON("<?= site_url('/Leads/view?lid='); ?>" + id, function (res) {

		let lead = res.lead;

		$('#lead_name').text(lead.customer_name);
		$('#lead_product').text('' + (lead.product_name ?? '-'));
		$('#lead_product2').text('' + (lead.product_name ?? '-'));
		$('#leadid').val(id);
		$('#leid').val(id);
		$('#ledid').val(id);

		$('#lead_phone').html(`${lead.customer_phone ?? '-'}`);
		$('#lead_email').html(`${lead.customer_email ?? '-'}`);

		$('#lead_priority').text(lead.priority);
		$('#lead_source').text(lead.source ?? '-');
		$('#lead_source2').text(lead.source ?? '-');
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

	
	function loadComments(leadId) {
		$('#commentsContainer').html('<div class="col-12 text-muted">Loading...</div>');
		
		$.ajax({
			//url: "<?= site_url('LeadComments/list'); ?>/" + leadId, // ✅ FIXED
			url: "<?= site_url('/Leads/list?lid='); ?>" + leadId, // ✅ FIXED
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
										<p class="text-muted mb-2"> 
											<span class="text-default"> 
												<span class="fw-medium">${c.commented_by ?? 'User'}</span> - " ${c.comment ?? ''} " 
											</span> <br>
											<span class="float-end fs-11 badge bg-light text-muted">${c.created_at ?? ''}</span> 
										</p>
									</div> 
								</li>`;
					});

				} else {

					html = `
					<div class="col-12">
						<div class="text-muted text-center py-4">
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
						<div class="text-muted text-center py-4">
							no comment into show
						</div>
					</div>
				`);
			}
		});
	}
	
	$(document).on('submit', '#commentForm', function (e) {

		e.preventDefault();

		$.post(
			"<?= site_url('/Leads/store_comment'); ?>",
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
	
	$(document).on("change", "#status_id", function () {

		let form = $("#change-st");   // your form
		let formData = form.serialize();

		$("#page-loader").show(); // show loader

		$.post(
			"<?= site_url('/Leads/change_status'); ?>",
			formData,
			function (res) {

				if (res.success) {
					toastr.success("Status updated");
					
					 location.reload();
					// optional reload / update UI
					// loadComments(res.lead_id);

				} else {
					toastr.error(res.message);
				}

			},
			"json"
		);
	});
	
	
	function loadComments(leadId) {
		$('#commentsContainer').html('<div class="col-12 text-muted">Loading...</div>');
		
		$.ajax({
			url: "<?= site_url('/Leads/list?lid='); ?>" + leadId, // ✅ FIXED
			type: "GET",
			dataType: "json",
			success: function (res) {
				
				console.log(res);
				
				let html = '';

				if (res.comments && res.comments.length > 0) {

					$.each(res.comments, function (i, c) {

						html += `<div class="border rounded p-31 mt-2">
									<div class="d-sm-flex d-block align-items-top">
										<div class="d-flex flex-fill">
											<div class="me-2">
												<span class="avatar avatar-sm avatar-rounded">
													<img src="../assets/images/faces/11.jpg" alt="" />
												</span>
											</div>
											<div class="lh-1 me-2">
												<p class="mb-1 fw-medium fs-14">${c.commented_by ?? 'User'} <span class="text-success"></span></p>
												<div class="mb-1"><span class="fs-11 text-muted"> ${c.created_at ?? ''} </span></div>
											</div>
										</div>
										<div class="mb-1 ms-auto text-end">
											<i class="ri-star-fill fs-15 align-middle text-warning align-middle"></i>
											<span class="align-middle">4.0</span>
										</div>
									</div>
									<div class="ps-sm-4 ps-0">
										<p class="fw-medium mb-1 ps-2 text-muted"><i>" ${c.comment ?? ''} "</i></p>
										<p class="mb-0 fs-12 text-muted ps-2">
											
										</p>
									</div>
								</div>`;
					});

				} else {

					html = `
					<div class="col-12">
						<div class="text-muted text-center py-4">
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
						<div class="text-muted text-center py-4">
							no comment into show
						</div>
					</div>
				`);
			}
		});
	}
	
	function loadHistory(leadId) {
	
		$('#assignment-history').html('<div class="col-12 text-muted">Loading...</div>');

			$.ajax({
				url: "<?= site_url('/Leads/history?lid='); ?>" + leadId,
				type: "GET",
				dataType: "json",
				success: function (res) {
					console.log(res);
					let html = '';

					if (res.history && res.history.length > 0) {

						$.each(res.history, function (i, h) {

							html +=`<div class="p-2 mt-2 rounded bg-light d-flex align-items-center flex-wrap gap-2">
										<div class="lh-1">
											<span class="avatar avatar-rounded avatar-md p-1 bg-success bg-opacity-50 border">
												<img src="../assets/images/faces/12.jpg" alt="">
											</span>
										</div>
										<div class="flex-fill">
											<p class="mb-0 fw-medium">
												${h.assigned_to_name ?? 'User'} - Assigned by : ${h.assigned_by_name ?? ''}
												<i class="bi bi-patch-check-fill text-secondary align-middle lh-1"></i>
											</p>
											<p class="fs-11 text-muted mb-0">${h.assigned_at ?? 'User'}</p>
										</div>
									</div>
								</div>`;
						});

					} else {

						html = `
						<div class="col-12">
							<div class="text-muted text-center py-3">
								no assignment history
							</div>
						</div>
						`;
					}

					$('#assignment-history').html(html);
				},
				error: function () {
					$('#assignment-history').html(`
						<div class="col-12">
							<div class="text-muted text-center py-3">
								no assignment history
							</div>
						</div>
					`);
				}
			});
	}
	
	/*$(document).on('submit', '#assignForm', function (e) {

		e.preventDefault();
		
		var current_user = $('#auid').val();
		var assigned = $('#lead_assigned_id').val();
			
		if(current_user === assigned){
			toastr.error('You cannot Reassign to yourself');
			return;
		}else{
			$.ajax({
				url: "<?= site_url('/Leads/assign'); ?>",
				type: "POST",
				data: $(this).serialize(),
				dataType: "json",
				success: function (res) {
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
		
	});*/
	
	$(document).on('submit', '#assignForm', function (e) {

		e.preventDefault();

		let form = $(this);

		let current_user = parseInt($('#auid').val(), 10);
		let assigned = parseInt($('#lead_assigned_id').val(), 10);

		if (current_user === assigned) {
			toastr.error('You cannot reassign to yourself');
			return;
		}

		$.ajax({
			url: "<?= site_url('/Leads/assign'); ?>",
			type: "POST",
			data: form.serialize(),
			dataType: "json",	

			success: function (res) {
				if (res.success) {
					toastr.success(res.message);

					// 🔑 keep values in sync
					$('#auid').val(assigned);
					$('#assigned_user_id').val('');

					loadHistory(res.lead_id);
				} else {
					toastr.error(res.message);
				}
			}
		});
	}); 
	
</script>