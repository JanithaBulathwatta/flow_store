<div class="main-content app-content">
    <div class="container-fluid">
        <!-- ================= KPI ROW ================= -->
        <div class="row mt-4">
            <div class="col-xxl-12 order-xxl-0 order-first">
                <div class="d-flex flex-column h-100">
                    <div class="row h-100">
                        <div class="col-xl-3 col-md-6">
							<div class="card custom-card">
								<div class="card-body">
									<div class="d-flex align-items-start gap-3 flex-wrap">
										<!-- Icon -->
										<div>
											<span class="avatar avatar-md avatar-rounded bg-primary shadow shadow-primary">
												<i class="ti ti-users fs-5"></i>
											</span>
										</div>

										<!-- Content -->
										<div class="flex-fill">

											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="d-block">Total Leads</span>

												<span class="badge bg-success-transparent rounded-pill">
													6.24%
													<i class="ti ti-arrow-up"></i>
												</span>
											</div>

											<span class="d-block mb-2"></span>

											<h4 class="fw-semibold mb-3 lh-1">
												<?= (int)$total_leads; ?>
											</h4>

											<a href="<?= site_url('leads'); ?>"
											   class="fs-12 text-muted text-decoration-underline">
												View All Leads
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>

                        <div class="col-xl-3 col-md-6">
							<div class="card custom-card">
								<div class="card-body">
									<div class="d-flex align-items-start gap-3 flex-wrap">
										<!-- Icon -->
										<div>
											<span class="avatar avatar-md avatar-rounded bg-warning shadow shadow-warning">
												<i class="ti ti-folder fs-5"></i>
											</span>
										</div>

										<!-- Content -->
										<div class="flex-fill">

											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="d-block">My Open Leads</span>

												<span class="badge bg-danger-transparent rounded-pill">
													1.12%
													<i class="ti ti-arrow-down"></i>
												</span>
											</div>

											<span class="d-block mb-2"></span>

											<h4 class="fw-semibold mb-3 lh-1">
												<?= (int)($my_open_leads ?? 0); ?>
											</h4>

											<a href="<?= site_url('leads?assigned=me'); ?>"
											   class="fs-12 text-muted text-decoration-underline">
												Assigned to Me
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-xxl-9">
							<div class="card custom-card overflow-hidden">
								<!-- ================= HEADER ================= -->
								<div class="card-header justify-content-between">
									<div class="card-title">
										My Recent Leads
									</div>
									<div class="d-flex flex-wrap ms-auto gap-2">
										<!-- SEARCH -->
										<div class="me-1">
											<input id="leadSearchInput"
												   class="form-control form-control-sm"
												   type="text"
												   placeholder="Search Leads">
										</div>
										<!-- SORT -->
										<div class="dropdown">
											<a href="javascript:void(0);"
											   class="btn btn-primary btn-sm btn-wave"
											   data-bs-toggle="dropdown">
												Sort By
												<i class="ri-arrow-down-s-line align-middle ms-1"></i>
											</a>
											<ul class="dropdown-menu dropdown-menu-end">
												<li>
													<a class="dropdown-item sort-trigger" data-sort="1">
														Customer
													</a>
												</li>
												<li>
													<a class="dropdown-item sort-trigger" data-sort="2">
														Status
													</a>
												</li>
												<li>
													<a class="dropdown-item sort-trigger" data-sort="3">
														Date
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>


								<!-- ================= BODY ================= -->
								<div class="card-body p-0">
									<div class="table-responsive">
										<table id="myLeadsTable"
											   class="table text-nowrap align-middle">
											<thead>
												<tr>
													<th class="text-center">
														<input id="selectAllLeads" class="form-check-input" type="checkbox">
													</th>
													<th>Customer</th>
													<th>Status</th>
													<th>Created</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($my_leads as $lead): ?>
													<tr>
														<!-- CHECK -->
														<td class="text-center">
															<input class="form-check-input row-check"
																   type="checkbox">
														</td>

														<!-- CUSTOMER -->
														<td>
															<div class="d-flex align-items-center gap-3">

																<div class="lh-1">
																	<span class="avatar avatar-sm shadow 
																				 bg-primary-transparent 
																				 text-primary">
																		<?= strtoupper(substr($lead->customer_name, 0, 1)); ?>
																	</span>
																</div>

																<div>
																	<span class="d-block fw-semibold">
																		<?= html_escape($lead->customer_name); ?>
																	</span>

																	<span class="fs-12 text-muted">
																		<?= html_escape($lead->assigned_user); ?>
																	</span>
																</div>

															</div>
														</td>

														<!-- STATUS -->
														<td>
															<span class="badge badge-pill"
																  style="background-color: <?= html_escape($lead->status_color); ?>">
																<?= html_escape($lead->status_name); ?>
															</span>
														</td>

														<!-- DATE -->
														<td>
															<?= date('Y-m-d', strtotime($lead->created_at)); ?>
														</td>

														<!-- ACTIONS -->
														<td>
															<div class="btn-list">

																<a href="<?= site_url('leads/view/'.$lead->id); ?>"
																   class="btn btn-sm btn-success-light 
																		  btn-icon btn-wave">
																	<i class="fe fe-eye"></i>
																</a>

																<a href="<?= site_url('leads/edit/'.$lead->id); ?>"
																   class="btn btn-sm btn-primary-light 
																		  btn-icon btn-wave">
																	<i class="fe fe-edit"></i>
																</a>

															</div>
														</td>

													</tr>

												<?php endforeach; ?>

												<?php if (empty($my_leads)): ?>
													<tr>
														<td colspan="5"
															class="text-center text-muted py-4">
															No leads assigned
														</td>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>
									</div>
								</div>

								<!-- ================= FOOTER ================= -->
								<div class="card-footer border-top-0">
									<div class="d-flex align-items-center">
										<div id="leadsCountText">
											Showing <?= count($my_leads); ?> Entries
										</div>

										<div class="transform-arrow ms-2">
											<i class="bi bi-arrow-right fw-semibold"></i>
										</div>

										<div class="ms-auto">

											<nav class="pagination-style-4">
												<ul class="pagination mb-0"
													id="datatablePagination">
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-xl-3 col-md-6">
							<div class="card custom-card overflow-hidden">
								<!-- CARD HEADER -->
								<div class="card-header justify-content-between">
									<div class="card-title">
										Leads by Status
									</div>
									<div class="dropdown">
										<a href="javascript:void(0);"
										   class="btn btn-sm btn-light btn-wave fs-12 text-muted"
										   data-bs-toggle="dropdown">
											View All
											<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-end">
											<li>
												<a class="dropdown-item"
												   href="<?= site_url('leads'); ?>">
													Open Leads
												</a>
											</li>
											<li>
												<a class="dropdown-item"
												   href="<?= site_url('leads?status=all'); ?>">
													All Statuses
												</a>
											</li>
										</ul>
									</div>
								</div>


								<!-- CARD BODY -->
								<div class="card-body">
									<ul class="list-unstyled browser-statistics-list">
										<?php foreach ($leads_by_status as $status): ?>
											<li>
												<div class="d-flex align-items-center flex-wrap gap-3 p-2
															border border-dashed border-opacity-25 rounded"
													 style="border-color: <?= html_escape($status->color); ?>">

													<!-- ICON -->
													<div>
														<span class="avatar avatar-md"
															  style="background-color: <?= html_escape($status->color); ?>20;">
															<i class="ri-flag-fill fs-4"
															   style="color: <?= html_escape($status->color); ?>"></i>
														</span>
													</div>

													<!-- NAME -->
													<div class="flex-fill">
														<span class="fw-medium">
															<?= html_escape($status->name); ?>
														</span>
														<span class="d-block text-muted fs-12">
															Lead Status
														</span>
													</div>

													<!-- COUNT -->
													<div class="text-end ms-auto">
														<span class="fw-semibold d-block mb-1">
															<span class="fw-normal fs-12">
																<i class="ri-circle-fill fs-8 me-1"
																   style="color: <?= html_escape($status->color); ?>"></i>
																Leads
															</span>
															- <?= (int)$status->total; ?>
														</span>
													</div>

												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>