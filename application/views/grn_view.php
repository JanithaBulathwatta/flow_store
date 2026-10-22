   <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- GRN Custom Styles -->
                <style>
                    .grn-status-badge { font-size: 0.75rem; padding: 0.35em 0.8em; border-radius: 30px; letter-spacing: 0.04em; }
                    .supplier-summary-card { background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%); border: 1px solid #d0deff; border-radius: 10px; }
                    .supplier-summary-card .sup-stat { border-right: 1px solid #d0deff; }
                    .supplier-summary-card .sup-stat:last-child { border-right: none; }
                    .items-table th { background-color: #f8f9fa; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.06em; color: #6c757d; white-space: nowrap; }
                    .items-table td { vertical-align: middle; }
                    .items-table .qty-input { width: 80px; text-align: center; }
                    .items-table .price-input { width: 110px; }
                    .items-table .discount-input { width: 85px; }
                    .totals-card { background: #f8f9fb; border: 1px solid #e9ecef; border-radius: 10px; }
                    .totals-card .total-row { display: flex; justify-content: space-between; align-items: center; padding: 0.55rem 0; border-bottom: 1px dashed #dee2e6; font-size: 0.875rem; }
                    .totals-card .total-row:last-child { border-bottom: none; }
                    .totals-card .grand-total-row { background: linear-gradient(135deg, var(--primary-color, #405189), #6172b0); color: #fff; border-radius: 8px; padding: 0.75rem 1rem; margin-top: 0.5rem; }
                    .history-item { border-left: 3px solid #e9ecef; padding-left: 1rem; position: relative; margin-bottom: 1rem; }
                    .history-item::before { content: ''; width: 10px; height: 10px; background: #405189; border-radius: 50%; position: absolute; left: -6.5px; top: 5px; }
                    .history-item.approved::before { background: #25b865; }
                    .history-item.rejected::before { background: #dc3545; }
                    .history-item.submitted::before { background: #f7b731; }
                    .dropzone-area { border: 2px dashed #c8d4f0; border-radius: 10px; background: #f8faff; text-align: center; padding: 2rem 1rem; cursor: pointer; transition: all 0.2s; }
                    .dropzone-area:hover { border-color: #405189; background: #eef2ff; }
                    .product-info-panel { background: #f0f4ff; border: 1px solid #d0deff; border-radius: 8px; font-size: 0.8125rem; }
                    .product-info-panel .pi-row { display: flex; justify-content: space-between; padding: 0.3rem 0; border-bottom: 1px dashed #d0deff; }
                    .product-info-panel .pi-row:last-child { border-bottom: none; }
                    .section-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; }
                    .section-header .section-icon { width: 32px; height: 32px; background: linear-gradient(135deg, #405189, #6172b0); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.875rem; flex-shrink: 0; }
                    .section-header h6 { margin: 0; font-weight: 600; font-size: 0.925rem; }
                    .grn-step-bar { display: flex; align-items: center; gap: 0; }
                    .grn-step { display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; padding: 0.3rem 0.8rem; background: #f0f0f0; color: #888; }
                    .grn-step.active { background: #405189; color: #fff; }
                    .grn-step.done { background: #d4edda; color: #155724; }
                    .grn-step:first-child { border-radius: 20px 0 0 20px; }
                    .grn-step:last-child { border-radius: 0 20px 20px 0; }
                    .grn-step-arrow { color: #ccc; font-size: 0.7rem; }
                    .serial-list-item { display: flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.5rem; border-bottom: 1px solid #f0f0f0; font-size: 0.8125rem; }
                    .serial-list-item:last-child { border-bottom: none; }
                    .serial-list-item .sn-idx { width: 24px; height: 24px; background: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0; }
                    .po-table-row:hover { background: #f0f4ff !important; cursor: pointer; }
                    .po-table-row.selected { background: #e8f0fe !important; }
                    .badge-draft { background: #e9ecef; color: #495057; }
                    .badge-submitted { background: #fff3cd; color: #856404; }
                    .badge-approved { background: #d1e7dd; color: #0f5132; }
                    .badge-rejected { background: #f8d7da; color: #842029; }
                    .badge-cancelled { background: #f0f0f0; color: #6c757d; }
                    .action-btn-bar { position: sticky; bottom: 0; background: #fff; border-top: 1px solid #e9ecef; padding: 1rem 1.5rem; z-index: 10; border-radius: 0 0 12px 12px; margin: 0 -1.5rem -1.5rem; }
                    .grn-number-badge { background: #eef2ff; color: #3d52a0; border: 1px solid #c5cff7; border-radius: 8px; padding: 0.25rem 0.75rem; font-size: 0.875rem; font-weight: 600; font-family: monospace; }
					.attachment-thumb {
						width: 56px;
						height: 56px;
						border-radius: 8px;
						background: #f0f4ff;
						border: 1px solid #c5cff7;
						display: flex;
						align-items: center;
						justify-content: center;
						font-size: 1.25rem;
						color: #405189;
						position: relative;
						cursor: pointer;
						transition: all 0.2s;
					}

					.attachment-thumb:hover {
						background: #eef2ff;
						border-color: #405189;
					}

					.attachment-thumb i {
						font-size: 24px;
					}

					.attachment-thumb .remove-att {
						position: absolute;
						top: -5px;
						right: -5px;
						width: 18px;
						height: 18px;
						background: #dc3545;
						border-radius: 50%;
						display: flex;
						align-items: center;
						justify-content: center;
						color: #fff;
						font-size: 0.6rem;
						cursor: pointer;
						opacity: 0;
						transition: opacity 0.2s;
					}

					.attachment-thumb:hover .remove-att {
						opacity: 1;
					}/* Make sure preview container is visible */
					#file-preview-container {
						min-height: 80px;
						padding: 8px;
						background: #fafbff;
						border-radius: 8px;
						display: flex;
						flex-wrap: wrap;
						gap: 10px;
						align-items: center;
					}

					/* Make sure the count is visible */
					#selected-files-count {
						font-weight: 600;
					}
					/* Force table visibility */
					.items-table {
						display: table !important;
						width: 100% !important;
					}

					#grn-items-tbody {
						display: table-row-group !important;
					}

					.items-table tr {
						display: table-row !important;
					}

					.items-table td {
						display: table-cell !important;
					}

                    .attachment-thumb .remove-att { position: absolute; top: -5px; right: -5px; width: 16px; height: 16px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.6rem; cursor: pointer; }
                
					.mb{
						margin-bottom:5px !important;
					}
					
					.mr{
						margin-right: 5px;
					}
				
					.w-25{
						width: 25%;
					}
				
				</style>

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <div>
                        <h1 class="page-title fw-semibold fs-18 mb-1">Goods Receipt Note</h1>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                           <span class="grn-number-badge" id="grn-number-display">
								<i class="ri-file-list-3-line me-1"></i>Loading...
							</span>
							<!-- Hidden fields for GRN ID -->
							<input type="hidden" id="hidden-grn-id" value="">
							<input type="hidden" id="hidden-grn-number" value="">
                            <span class="badge grn-status-badge badge-draft">Draft</span>
                            <!-- Workflow Steps -->
                            <div class="grn-step-bar ms-2">
								<span class="grn-step done"><i class="ri-check-line me-1"></i>New</span>
								<span class="grn-step active"><i class="ri-edit-line me-1"></i>Draft</span>
								<span class="grn-step">Submit</span>
								<span class="grn-step">Review</span>
								<span class="grn-step">Approve</span>
								<span class="grn-step">Stock Update</span>
							</div>
                        </div>
                    </div>
                    <div class="ms-md-1 ms-0 mt-md-0 mt-2">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Purchase</a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">GRN</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->
                
                <!-- Start GRN Create Content -->
                <div class="row g-3">

                    <!-- ===== LEFT COLUMN (Main) ===== -->
                    <div class="col-xl-9 col-lg-12">

                        <!-- ===== SECTION 1: GRN Header Fields ===== -->
                        <div class="card custom-card mb-3">
                            <div class="card-header">
                                <div class="section-header mb-0">
                                    <span class="section-icon"><i class="ri-file-list-3-line"></i></span>
                                    <h6>GRN Information</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6 col-xl-4">
                                        <label class="form-label fw-medium fs-13">Supplier <span class="text-danger">*</span></label>
                                        <select class="form-control" id="grn-supplier" data-trigger>
                                            <option value="">-- Select Supplier --</option>
                                            <?php foreach($sup as $item){
                                                echo '<option value="'.$item->id.'">'.$item->name.'</option>';
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-xl-4">
                                        <label class="form-label fw-medium fs-13">Warehouse <span class="text-danger">*</span></label>
                                        <select class="form-control" id="grn-warehouse" data-trigger>
                                            
                                            <option value="">-- Select Warehouse --</option>
                                            <?php foreach($stores as $item){
                                                echo '<option value="'.$item->store_id.'">'.$item->store_name.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
						                <label class="form-label fw-medium fs-13">GRN Date <span class="text-danger">*</span></label>
						                <input type="date" class="form-control" id="grn-date" placeholder="Select date" value="<?= date('Y-m-d'); ?>">
					                </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <label class="form-label fw-medium fs-13">Received By <span class="text-danger">*</span></label>
                                        <select class="form-control" id="grn-received-by" data-trigger>
                                            <option value="">-- Select User --</option>
                                            <?php foreach($user as $item){
                                                echo '<option value="'.$item->staff_id.'">'.$item->full_name.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <label class="form-label fw-medium fs-13">Delivery Note No.</label>
                                        <input type="text" class="form-control" id="grn-delivery-note" placeholder="e.g. DN-2026-001">
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <label class="form-label fw-medium fs-13">Reference / Invoice No. </label>
                                        <input type="text" class="form-control" id="grn-ref" placeholder="Supplier invoice ref.">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-medium fs-13">Remarks</label>
                                        <textarea class="form-control" id="grn-remarks" rows="2" placeholder="Any notes about this receipt..."></textarea>
                                    </div> 
									<!-- ADD THIS NEW PAID AMOUNT FIELD AFTER REMARKS -->
									<div class="col-12">
										<label class="form-label fw-medium fs-13">Paid Amount (Optional)</label>
										<div class="input-group">
											<span class="input-group-text">LKR</span>
											<input type="number" class="form-control" id="grn-paid-amount" value="0.00" step="0.01" min="0">
										</div>
										<div class="fs-11 text-muted mt-1">Enter amount paid to supplier for this GRN (if any)</div>
									</div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== SECTION 2: Supplier Summary (shown after supplier select) ===== -->
                        <div class="card custom-card mb-3" id="supplier-summary-panel" style="display:none!important;">
                            <div class="card-body py-3">
                                <div class="supplier-summary-card p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="avatar avatar-sm bg-primary-transparent rounded">
                                            <i class="ri-building-line text-primary"></i>
                                        </div>
                                        <div>
                                            <span class="fw-semibold fs-14" id="sup-name">ABC Traders</span>
                                            <span class="text-muted fs-12 ms-2" id="sup-phone"><i class="ri-phone-line"></i> 0771 112 222</span>
                                        </div>
                                        <span class="ms-auto badge bg-success-transparent text-success fs-11">Active Supplier</span>
                                    </div>
                                    <div class="row g-2 text-center mt-1">
                                        <div class="col-4 sup-stat py-2">
                                            <div class="text-muted fs-11 mb-1">Last Invoice Date</div>
                                            <div class="fw-semibold fs-13" id="sup-last-date">10 Feb 2026</div>
                                        </div>
                                        <div class="col-4 sup-stat py-2">
                                            <div class="text-muted fs-11 mb-1">Last Invoice Amount</div>
                                            <div class="fw-semibold fs-13 text-primary" id="sup-last-amount">LKR 25,000.00</div>
                                        </div>
                                        <div class="col-4 py-2">
                                            <div class="text-muted fs-11 mb-1">Outstanding Balance</div>
                                            <div class="fw-semibold fs-13 text-danger" id="sup-outstanding">LKR 10,000.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== DEMO: Supplier Summary shown by default for preview ===== -->
                        

                        <!-- ===== SECTION 3: Import PO ===== -->
                        <div class="card custom-card mb-3">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div class="section-header mb-0">
                                    <span class="section-icon"><i class="ri-file-copy-2-line"></i></span>
                                    <h6>Purchase Order Import</h6>
                                </div>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImportPO">
                                    <i class="ri-import-line me-1"></i> Import Purchase Order
                                </button>
                            </div>
                            <div class="card-body py-2">
                                <div class="alert alert-primary-transparent mb-0 py-2 fs-12 d-flex align-items-center gap-2">
                                    <i class="ri-information-line text-primary fs-14"></i>
                                    Import items from an existing Purchase Order, or add items manually using the button below.
                                </div>
                            </div>
                        </div>

                        <!-- ===== SECTION 4: Items Table ===== -->
                        <div class="card custom-card mb-3">
                            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="section-header mb-0">
                                    <span class="section-icon"><i class="ri-list-check-3"></i></span>
                                    <h6>Items <span class="badge bg-primary-transparent text-primary fs-11 ms-1"></span></h6>
                                </div>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddItem">
                                    <i class="ri-add-line me-1"></i> Add Product
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table items-table mb-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width:32px;">#</th>
                                                <th style="min-width:180px;">Product</th>
                                                <th>Unit</th>
                                                <th>Qty</th>
                                                <th>Free Qty</th>
                                                <th>Unit Price</th>
                                                <th>Discount</th>
                                                
                                                <th>Line Total</th>
                                                <th style="width:100px;">Actions</th>
                                            </tr>
                                        </thead>
                                       <tbody id="grn-items-tbody">
											<!-- Dynamically populated -->
									</tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Totals inside card footer -->
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label class="form-label fw-medium fs-13">Bill Discount</label>
                                        <div class="d-flex gap-2">
                                            <input type="number" class="form-control" id="bill-discount-val" placeholder="0.00" value="0" min="0">
                                            <select class="form-select" id="bill-discount-type" style="max-width:100px;">
                                                <option>%</option>
                                                <option selected>LKR</option>
                                            </select>
                                        </div>
                                        <div class="fs-12 text-muted mt-1">Applied to entire document after line discounts</div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="totals-card p-3">
											<div class="total-row">
												<span class="text-muted">Subtotal</span>
												<span class="fw-medium" id="tot-subtotal">LKR 0.00</span>
											</div>
											<div class="total-row">
												<span class="text-muted">Line Discount Total</span>
												<span class="fw-medium text-danger" id="tot-line-disc">- LKR 0.00</span>
											</div>
											<div class="total-row">
												<span class="text-muted">Bill Discount</span>
												<span class="fw-medium text-danger" id="tot-bill-disc">- LKR 0.00</span>
											</div>
											<div class="total-row">
												<div class="d-flex gap-2 align-items-center">
													<span class="text-muted">Tax Rate (%)</span>
													
													<select class="form-select form-select-sm" id="global-tax-rate" style="width:60%;">
														<?php
															$configs = $this->session->userdata('sys_config');
															$vat_rate = $configs['Vat_rate'];

															foreach($rate as $item){
																$selected = ($item->tax_rate == $vat_rate) ? 'selected' : '';

																echo "<option value='{$item->tax_rate}' {$selected}>
																		{$item->tax_name} - {$item->tax_rate} %
																	  </option>";
															}
														?>
													</select>
													
												</div>
												<span class="fw-medium text-info" id="tot-tax-amount">LKR 0.00</span>
											</div>
											<div class="grand-total-row d-flex justify-content-between align-items-center">
												<span class="fw-bold fs-14">Grand Total (Inc. Tax)</span>
												<span class="fw-bold fs-16" id="tot-grand">LKR 0.00</span>
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>

						<!-- ===== SECTION 5: Attachments ===== -->
						<div class="card custom-card mb-3">
							<div class="card-header">
								<div class="section-header mb-0">
									<span class="section-icon"><i class="ri-attachment-2"></i></span>
									<h6>Attachments <span class="text-muted fw-normal fs-12">(Delivery note, supplier invoice, etc.)</span></h6>
								</div>
							</div>
							<div class="card-body">
								<div class="dropzone-area mb-3" id="grn-dropzone">
									<i class="ri-upload-cloud-2-line fs-2 text-primary mb-2 d-block"></i>
									<div class="fw-medium fs-14">Drop files here or click to select</div>
									<div class="text-muted fs-12 mt-1">Supports PDF, JPG, PNG up to 10MB</div>
									<div class="upload-status-indicator fs-11 mt-2" id="upload-status">
										<span class="badge bg-secondary-transparent text-secondary">
											<i class="ri-information-line me-1"></i>Select files to preview (will upload when saved)
										</span>
									</div>
									<input type="file" id="att-file-input" class="d-none" multiple accept=".pdf,.jpg,.jpeg,.png">
								</div>
								
								<!-- File Previews Container -->
								<div class="fw-semibold fs-13 mb-2">Selected Files <span class="text-muted fs-12" id="selected-files-count">(0 files)</span></div>
								<div class="d-flex flex-wrap gap-2 mb-3" id="file-preview-container">
									<div class="text-muted fs-12">No files selected</div>
								</div>
								
								<!-- Uploaded Files Container -->
								<div class="fw-semibold fs-13 mb-2">Uploaded Files</div>
								<div class="d-flex flex-wrap gap-2" id="uploaded-files-container">
									<!-- Uploaded files will appear here -->
								</div>
							</div>
						</div>

                        <!-- ===== ACTION BUTTONS ===== -->
                        <div class="card custom-card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <button class="btn btn-secondary" id="btn-save-draft">
                                        <i class="ri-save-line me-1"></i> Save Draft
                                    </button>
                                    <button class="btn btn-primary" id="btn-submit-approval">
                                        <i class="ri-send-plane-line me-1"></i> Submit for Approval
                                    </button>
                                    <button class="btn btn-success" id="btn-approve" data-bs-toggle="modal" data-bs-target="#modalApprove">
                                        <i class="ri-checkbox-circle-line me-1"></i> Approve
                                    </button>
                                    <button class="btn btn-danger" id="btn-reject" data-bs-toggle="modal" data-bs-target="#modalReject">
                                        <i class="ri-close-circle-line me-1"></i> Reject
                                    </button>
                                    <div class="ms-auto d-flex gap-2">
                                        <button class="btn btn-warning-light" id="btn-cancel">
                                            <i class="ri-close-line me-1"></i> Cancel
                                        </button>
                                        <button class="btn btn-info-light" id="btn-print">
                                            <i class="ri-printer-line me-1"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ===== RIGHT COLUMN (Sidebar) ===== -->
                    <div class="col-xl-3 col-lg-16 ms-auto">

									   <!-- GRN Summary Card -->
				<div class="card custom-card mb-3">
					<div class="card-header">
						<div class="section-header mb-0">
							<span class="section-icon"><i class="ri-information-line"></i></span>
							<h6>GRN Summary</h6>
						</div>
					</div>
					<div class="card-body">
						<ul class="list-group list-group-flush">
							<li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
								<span class="text-muted">GRN Number</span>
								<span class="fw-semibold font-monospace" id="summary-grn-number"><?php echo isset($grn) ? $grn->grn_number : 'Loading...'; ?></span>
							</li>
							<li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
								<span class="text-muted">Status</span>
								<span class="badge grn-status-badge" id="summary-status">Draft</span>
							</li>
							<li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
								<span class="text-muted">Created By</span>
								<span class="fw-semibold" id="summary-created-by">
									<?php 
									$user_name = 'Admin User'; // Default
									if(isset($user) && !empty($user)) {
										foreach($user as $u) {
											if($u->staff_id == $this->session->userdata('staff_id')) {
												$user_name = $u->full_name;
												break;
											}
										}
									}
									echo $user_name;
									?>
								</span>
							</li>
							<li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
								<span class="text-muted">Created On</span>
								<span class="fw-semibold" id="summary-created-on"><?php echo date('d M Y'); ?></span>
							</li>
							<li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
								<span class="text-muted">Total Items</span>
								<span class="badge bg-primary-transparent text-primary" id="summary-total-items">0</span>
							</li>
							<li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
								<span class="text-muted">Total Qty (incl. free)</span>
								<span class="fw-semibold" id="summary-total-qty">0</span>
							</li>
							<li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
								<span class="text-muted">Grand Total</span>
								<span class="fw-bold text-primary fs-14" id="summary-grand-total">LKR 0.00</span>
							</li>
						</ul>
					</div>
				</div>

									   <!-- Validation Checklist -->
				<div class="card custom-card mb-3">
					<div class="card-header">
						<div class="section-header mb-0">
							<span class="section-icon bg-success" style="background:linear-gradient(135deg,#25b865,#1a9c52)!important;"><i class="ri-shield-check-line"></i></span>
							<h6>Validation Checklist</h6>
						</div>
					</div>
					<div class="card-body">
						<ul class="list-unstyled mb-0 fs-13" id="validation-checklist">
							<li class="d-flex align-items-center gap-2 mb-2" data-check="supplier">
								<i class="ri-checkbox-circle-fill text-success"></i>
								<span>Supplier selected</span>
							</li>
							<li class="d-flex align-items-center gap-2 mb-2" data-check="warehouse">
								<i class="ri-checkbox-circle-fill text-success"></i>
								<span>Warehouse selected</span>
							</li>
							<li class="d-flex align-items-center gap-2 mb-2" data-check="date">
								<i class="ri-checkbox-circle-fill text-success"></i>
								<span>GRN Date set</span>
							</li>
							<li class="d-flex align-items-center gap-2 mb-2" data-check="received-by">
								<i class="ri-checkbox-circle-fill text-success"></i>
								<span>Received By selected</span>
							</li>
							<li class="d-flex align-items-center gap-2 mb-2" data-check="items">
								<i class="ri-checkbox-circle-fill text-success"></i>
								<span>At least one item added</span>
							</li>
							<li class="d-flex align-items-center gap-2 mb-2" data-check="quantities">
								<i class="ri-checkbox-circle-fill text-success"></i>
								<span>All quantities > 0</span>
							</li>
							<li class="d-flex align-items-center gap-2 mb-2" data-check="serials">
								<i class="ri-checkbox-circle-fill text-success"></i>
								<span>Serial numbers completed</span>
							</li>
							<li class="d-flex align-items-center gap-2" data-check="discounts">
								<i class="ri-checkbox-circle-fill text-success"></i>
								<span>Discounts within valid range</span>
							</li>
						</ul>
					</div>
				</div>
				<!-- Payment Summary Card (Only visible after approval) -->
<div class="card custom-card mb-3" id="payment-summary-card" style="display: none;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="section-header mb-0">
            <span class="section-icon" style="background:linear-gradient(135deg,#25b865,#1a9c52)!important;">
                <i class="ri-money-dollar-circle-line"></i>
            </span>
            <h6>Payment Summary</h6>
        </div>
        
    </div>
    <div class="card-body">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Grand Total</span>
                <span class="fw-semibold" id="payment-grand-total">LKR 0.00</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Paid Amount</span>
                <span class="fw-semibold text-success" id="payment-paid-amount">LKR 0.00</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">Balance Due</span>
                <span class="fw-bold text-danger fs-14" id="payment-balance">LKR 0.00</span>
            </div>
        </div>
        
        <!-- Payment Progress Bar -->
        <div class="mb-3">
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" id="payment-progress" style="width: 0%;" role="progressbar"></div>
            </div>
            <div class="text-center mt-1">
                <span class="fs-11 text-muted" id="payment-percentage">0%</span>
                <span class="fs-11 text-muted mx-2">|</span>
                <span class="badge" id="payment-status-badge">Unpaid</span>
            </div>
        </div>
        
        <!-- Linked Invoice Info -->
        <div class="mt-2 pt-2 border-top" id="invoice-link-container" style="display: none;">
            <div class="fs-11 text-muted">
                <i class="ri-file-list-line me-1"></i>
                Linked Invoice: <strong id="linked-invoice-number">--</strong>
            </div>
        </div>
    </div>
</div>

<!-- Payment History Card -->
<div class="card custom-card mb-3" id="payment-history-card" style="display: none;">
    <div class="card-header">
        <div class="section-header mb-0">
            <span class="section-icon" style="background:linear-gradient(135deg,#6c757d,#495057)!important;">
                <i class="ri-history-line"></i>
            </span>
            <h6>Payment History</h6>
        </div>
    </div>
    <div class="card-body p-0" id="payment-history-container" style="max-height: 300px; overflow-y: auto;">
        <div class="text-center py-3 text-muted fs-12">
            <i class="ri-information-line me-1"></i>
            No payments recorded yet
        </div>
    </div>
</div>
										<!-- GRN History / Audit Log -->
				<div class="card custom-card mb-3">
					<div class="card-header">
						<div class="section-header mb-0">
							<span class="section-icon" style="background:linear-gradient(135deg,#6c757d,#495057)!important;"><i class="ri-history-line"></i></span>
							<h6>GRN History</h6>
						</div>
					</div>
					<div class="card-body" id="grn-history-container">
						<div class="text-center py-3 text-muted fs-12">
							<div class="spinner-border spinner-border-sm me-2" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
							Loading history...
						</div>
					</div>
				</div>

										<!-- Quick Stats -->
				<div class="card custom-card mb-3">
					<div class="card-header">
						<div class="section-header mb-0">
							<span class="section-icon" style="background:linear-gradient(135deg,#f7b731,#d4981a)!important;"><i class="ri-bar-chart-2-line"></i></span>
							<h6>Stock Impact Preview</h6>
						</div>
					</div>
					<div class="card-body p-0">
						<table class="table table-sm mb-0 fs-12">
							<thead class="table-light">
								<tr>
									<th>Product</th>
									<th class="text-center">Current</th>
									<th class="text-center">Incoming</th>
									<th class="text-center">After</th>
								</tr>
							</thead>
							<tbody id="stock-summary-body">  
								<!-- Dynamically populated -->
							</tbody>
						</table>
						<div class="px-3 py-2 bg-light fs-11 text-muted border-top">
							<i class="ri-information-line me-1"></i> Stock updates only upon <strong>Approval</strong>. Free qty is included in stock increase.
						</div>
					</div>
				</div>
								<!-- End GRN Create Content -->


								<!-- ====================================== -->
				<!-- MODAL: Import Purchase Order           -->
				<!-- ====================================== -->
				<div class="modal fade" id="modalImportPO" tabindex="-1" aria-labelledby="modalImportPOLabel" aria-hidden="true">
					<div class="modal-dialog modal-xl modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="modal-title fw-semibold" id="modalImportPOLabel">
									<i class="ri-file-copy-2-line me-2 text-primary"></i>Import from Purchase Order
								</h6>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<!-- Filters -->
								<div class="row g-2 mb-3">
									<div class="col-sm-3">
										<label class="form-label fs-12 fw-medium mb-1">Supplier</label>
										<select class="form-select form-select-sm" id="po-filter-supplier">
											<option value="">All Suppliers</option>
											<?php foreach($sup as $item): ?>
											<option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="col-sm-3">
										<label class="form-label fs-12 fw-medium mb-1">Date From</label>
										<input type="date" class="form-control form-control-sm" id="po-filter-date-from">
									</div>
									<div class="col-sm-3">
										<label class="form-label fs-12 fw-medium mb-1">Date To</label>
										<input type="date" class="form-control form-control-sm" id="po-filter-date-to">
									</div>
									<div class="col-sm-3 d-flex align-items-end">
										<button class="btn btn-primary btn-sm w-100" id="btn-search-po">
											<i class="ri-search-line me-1"></i> Search
										</button>
									</div>
								</div>
								
								<!-- PO List -->
								<div class="mb-3">
									<div class="fw-semibold fs-13 mb-2">Select Purchase Order</div>
									<div class="table-responsive">
										<table class="table table-hover table-bordered fs-13 mb-0" id="po-list-table">
											<thead class="table-light">
												<tr>
													<th style="width:50px;"></th>
													<th>PO Number</th>
													<th>Supplier</th>
													<th>Date</th>
													<th>Items</th>
													<th class="text-end">Total Amount</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody id="po-list-body">
												<tr>
													<td colspan="7" class="text-center py-4 text-muted">
														<div class="spinner-border spinner-border-sm me-2" role="status">
															<span class="visually-hidden">Loading...</span>
														</div>
														Loading purchase orders...
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								
								<!-- PO Items Preview -->
								<div class="mt-3 p-3 bg-light rounded border" id="po-items-preview" style="display: none;">
									<div class="d-flex justify-content-between align-items-center mb-2">
										<div class="fw-semibold fs-13">
											<i class="ri-list-check me-1 text-primary"></i>
											<span id="selected-po-number">PO-2026-001</span> — Items Preview
										</div>
										<div>
											<span class="badge bg-primary" id="po-items-count">0 items</span>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-sm table-bordered fs-12 mb-0">
											<thead class="table-light">
												<tr>
													<th style="width:40px;">
														<input type="checkbox" class="form-check-input" id="select-all-po-items" checked>
													</th>
													<th>Product</th>
													<th>Unit</th>
													<th>PO Qty</th>
													<th>Pending</th>
													<th>Unit Price</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody id="po-items-body">
												<!-- Items will be populated here -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary btn-sm" id="btn-import-selected" disabled>
									<i class="ri-import-line me-1"></i> Import Selected Items
								</button>
							</div>
						</div>
					</div> 
				</div>

                <!-- ====================================== -->
                <!-- MODAL: Add / Edit Item                 -->
                <!-- ====================================== -->
                <div class="modal fade" id="modalAddItem" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title fw-semibold"><i class="ri-add-circle-line me-2 text-success"></i>Add Product to GRN</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12 mb">
                                        <label class="form-label fw-medium fs-13">Product <span class="text-danger">*</span></label>
                                        <select class="form-control" id="modal-product" data-trigger>
                                            <option value="">-- Search & Select Product --</option>
                                             <?php foreach($products as $item){
                                                echo '<option value="'.$item->id.'">'.$item->name.' - LKR '.$item->price.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                   <!-- Product Info Panel with data-pi attributes -->
                                   <div class="product-info-panel p-3">
										<div class="fw-semibold fs-13 mb-2 text-primary">
											<i class="ri-information-line me-1"></i> Product Information
										</div>
										<div class="row g-0">
											<div class="col-6">
												<div class="pi-row">
													<span class="text-muted">Unit</span>
													<span class="fw-medium" data-pi="unit">pcs</span>
												</div>
												
												<div class="pi-row">
													<span class="text-muted">Current Stock</span>
													<span class="fw-medium text-success" data-pi="stock">0 pcs</span>
												</div>
												<div class="pi-row">
													<span class="text-muted">Last Purchase Price</span>
													<span class="fw-medium" data-pi="last-price">LKR 0.00</span>
												</div>
											</div>
											<div class="col-6 ps-3">
												<div class="pi-row">
													<span class="text-muted">Last Purchase Date</span>
													<span class="fw-medium" data-pi="last-date">N/A</span>
												</div>
												<div class="pi-row" data-pi="expiry">
													<span class="text-muted">Expiry Required</span>
													<span class="badge bg-secondary-transparent text-secondary">Checking...</span>
												</div>
												<div class="pi-row" data-pi="serial">
													<span class="text-muted">Serial Tracked</span>
													<span class="badge bg-secondary-transparent text-secondary">Checking...</span>
												</div>
											</div>
										</div>
									</div>

                                    <div class="col-sm-6 col-xl-3">
                                        <label class="form-label fw-medium fs-13">Quantity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="modal-qty" value="1" min="1">
                                    </div>
                                    <div class="col-sm-6 col-xl-3">
                                        <label class="form-label fw-medium fs-13">Free Quantity</label>
                                        <input type="number" class="form-control" id="modal-free-qty" value="0" min="0">
                                        <div class="fs-11 text-muted text-center">Included in stock, not in value</div>
                                    </div>
                                    <div class="col-sm-6 col-xl-3">
                                        <label class="form-label fw-medium fs-13">Unit Price <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text fs-12 mr">LKR</span>
                                            <input type="number" class="form-control" id="modal-price" value="0.00" step="0.01">
                                        </div>
                                    </div>
                                    <!--<div class="col-sm-6 col-xl-3">
                                        <label class="form-label fw-medium fs-13">Unit</label>
                                        <input type="text" class="form-control" id="modal-unit" value="pcs" readonly>
                                    </div>-->
									
									<div class="col-sm-6 col-xl-3">
										<label class="form-label fw-medium fs-13">Unit</label>
										<select class="form-select" id="modal-unit">
											<?php
												foreach($unit as $item){
													echo"<option value='$item->unit_name'>$item->unit_name</option>";
												}
											?>
										</select>
									</div>
									
                                    <div class="col-sm-4">
                                        <label class="form-label fw-medium fs-13">Line Discount</label>
                                        <input type="number" class="form-control" id="modal-discount" value="0" min="0">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label fw-medium fs-13">Discount Type</label>
                                        <select class="form-select" id="modal-discount-type">
                                            <option value="percent">Percentage (%)</option>
                                            <option value="amount">Fixed Amount (LKR)</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Batch / Expiry (conditional) -->
                                    <div class="col-sm-4" id="modal-batch-group">
                                        <label class="form-label fw-medium fs-13">Batch Number</label>
                                        <input type="text" class="form-control" id="modal-batch" placeholder="e.g. B2026-03">
                                    </div>
																		<div class="col-sm-6" id="modal-expiry-group" style="display: none;">
										<label class="form-label fw-medium fs-13">Expiry Date <span class="text-danger">*</span></label>
										<input type="date" class="form-control" id="modal-expiry">
										<div class="fs-11 text-danger mt-1" id="expiry-warning" style="display: none;">
											<i class="ri-error-warning-line me-1"></i> This product requires expiry date
										</div>
									</div>
                                    <!-- Line Total Preview -->
                                    <div class="col-12">
                                        <div class="alert alert-primary-transparent mb-0 py-2 d-flex justify-content-between align-items-center">
                                            <span class="fs-13 fw-medium">Line Total (preview)</span>
                                            <span class="fs-14 fw-bold text-primary" id="modal-line-total">LKR 0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalSerialNumbers">
                                    <i class="ri-barcode-line me-1"></i> Enter Serial Numbers
                                </button>
                                <button class="btn btn-success btn-sm" data-bs-dismiss="modal">
                                    <i class="ri-check-line me-1"></i> Add to GRN
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ====================================== -->
                <!-- MODAL: Serial Numbers                  -->
                <!-- ====================================== -->
                <div class="modal fade" id="modalSerialNumbers" tabindex="-1">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title fw-semibold"><i class="ri-barcode-line me-2 text-info"></i>Serial Number Entry</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-info-transparent py-2 mb-3 fs-13 d-flex align-items-center gap-2">
    <i class="ri-information-line text-info"></i>
    <span>Product: <strong id="serial-product-name">Laptop Dell XPS 15</strong> &nbsp;|&nbsp; Required: <strong id="serial-required-qty" class="text-primary">5 serial numbers</strong></span>
</div>
                                <!-- Generator -->
                                <div class="card bg-light border-0 mb-3">
                                    <div class="card-body py-2">
                                        <div class="fw-semibold fs-13 mb-2 text-muted"><i class="ri-magic-line me-1"></i> Auto Generate</div>
                                        <div class="row g-2">
                                            <div class="col-5">
                                                <label class="form-label fs-12 mb-1">Start Serial</label>
                                                <input type="text" class="form-control form-control-sm" id="sn-start" value="SN1001">
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label fs-12 mb-1">End Serial</label>
                                                <input type="text" class="form-control form-control-sm" id="sn-end" value="SN1005">
                                            </div>
                                            <div class="col-2 d-flex align-items-end">
                                                <button class="btn btn-primary btn-sm w-100" id="btn-generate-sn">Gen</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Serial List -->
                                <div class="fw-semibold fs-13 mb-2">Serial Numbers List</div>
                                <div id="sn-list" style="max-height:260px; overflow-y:auto; border:1px solid #e9ecef; border-radius:8px;">
                                    <div class="serial-list-item"><span class="sn-idx">1</span><input type="text" class="form-control form-control-sm border-0" value="SN1001"><button class="btn btn-sm btn-icon text-danger border-0 bg-transparent"><i class="ri-close-line"></i></button></div>
                                    <div class="serial-list-item"><span class="sn-idx">2</span><input type="text" class="form-control form-control-sm border-0" value="SN1002"><button class="btn btn-sm btn-icon text-danger border-0 bg-transparent"><i class="ri-close-line"></i></button></div>
                                    <div class="serial-list-item"><span class="sn-idx">3</span><input type="text" class="form-control form-control-sm border-0" value="SN1003"><button class="btn btn-sm btn-icon text-danger border-0 bg-transparent"><i class="ri-close-line"></i></button></div>
                                    <div class="serial-list-item"><span class="sn-idx">4</span><input type="text" class="form-control form-control-sm border-0" value="SN1004"><button class="btn btn-sm btn-icon text-danger border-0 bg-transparent"><i class="ri-close-line"></i></button></div>
                                    <div class="serial-list-item"><span class="sn-idx">5</span><input type="text" class="form-control form-control-sm border-0" value="SN1005"><button class="btn btn-sm btn-icon text-danger border-0 bg-transparent"><i class="ri-close-line"></i></button></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                                    <span class="text-muted fs-12">Total Entered: <strong class="text-success" id="sn-count">5 / 5</strong></span>
                                    <button class="btn btn-sm btn-outline-secondary fs-12" id="btn-add-sn"><i class="ri-add-line"></i> Add Row</button>
                                </div>
                            </div>
                            <div class="modal-footer">
								<button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
								<button class="btn btn-primary btn-sm" id="btn-save-serials">
									<i class="ri-check-line me-1"></i> Save Serial Numbers
								</button>
							</div>	
                        </div>
                    </div>
                </div>
				<!-- ====================================== -->
<!-- MODAL: Record Payment (After Approval) -->
<!-- ====================================== -->
<div class="modal fade" id="modalRecordPayment" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold">
                    <i class="ri-money-dollar-circle-line me-2 text-primary"></i>Record Payment
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info-transparent py-2 mb-3 fs-13">
                    <i class="ri-information-line me-1"></i>
                    GRN: <strong id="payment-grn-number">--</strong> &nbsp;|&nbsp;
                    Balance Due: <strong id="payment-balance-due" class="text-danger">LKR 0.00</strong>
                </div>
                
                <!-- Payment Method Selection -->
                <div class="mb-3">
                    <label class="form-label fw-medium fs-13">Payment Method <span class="text-danger">*</span></label>
                    <select class="form-select" id="payment-method" required>
                        <option value="">-- Select Payment Method --</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Bank Transfer</option>
                        <option value="cheque">Cheque</option>
                    </select>
                </div>
                
                <!-- Common Fields -->
                <div class="mb-3">
                    <label class="form-label fw-medium fs-13">Payment Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="payment-date" value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <!-- Transfer Fields -->
                <div id="transfer-fields" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label fw-medium fs-13">Reference No.</label>
                        <input type="text" class="form-control" id="transfer-ref" placeholder="Transaction reference">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium fs-13">Bank Name</label>
                        <input type="text" class="form-control" id="transfer-bank" placeholder="Bank name">
                    </div>
                </div>
                
                <!-- Cheque Fields -->
                <div id="cheque-fields" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label fw-medium fs-13">Cheque No. <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cheque-no" placeholder="Cheque number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium fs-13">Cheque Date</label>
                        <input type="date" class="form-control" id="cheque-date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium fs-13">Bank Name</label>
                        <input type="text" class="form-control" id="cheque-bank" placeholder="Bank name">
                    </div>
                </div>
                
                <!-- Payment Amount -->
                <div class="mb-3">
                    <label class="form-label fw-medium fs-13">Payment Amount <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">LKR</span>
                        <input type="number" class="form-control" id="payment-amount" step="0.01" min="0.01" placeholder="0.00">
                    </div>
                </div>
                
                <!-- Note -->
                <div class="mb-3">
                    <label class="form-label fw-medium fs-13">Note</label>
                    <textarea class="form-control" id="payment-note" rows="2" placeholder="Optional payment note"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary btn-sm" id="btn-record-payment">
                    <i class="ri-save-line me-1"></i> Record Payment
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ====================================== -->
<!-- MODAL: Edit Batch/Expiry                -->
<!-- ====================================== -->
<div class="modal fade" id="modalBatchExpiry" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold"><i class="ri-stack-line me-2 text-warning"></i>Batch & Expiry Information</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning-transparent py-2 mb-3 fs-13">
                    <i class="ri-information-line me-1"></i>
                    Product: <strong id="batch-product-name">--</strong>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium fs-13">Batch Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="batch-number" placeholder="e.g. BATCH-2026-001">
                    <div class="fs-12 text-muted mt-1">Unique identifier for this product batch</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium fs-13">Expiry Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="expiry-date">
                    <div class="fs-12 text-danger mt-1" id="batch-expiry-warning" style="display:none;">
                        <i class="ri-error-warning-line me-1"></i> Expiry date cannot be in the past
                    </div>
                </div>
                <div class="alert alert-info-transparent py-2 fs-12 mb-0">
                    <i class="ri-information-line me-1"></i>
                    Adding stock to existing batch? System will check and confirm automatically.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary btn-sm" id="save-batch-btn">
                    <i class="ri-save-line me-1"></i> Save Batch Info
                </button>
            </div>
        </div>
    </div>
</div>
                <!-- ====================================== -->
<!-- MODAL: Reject GRN                      -->
<!-- ====================================== -->
<div class="modal fade" id="modalReject" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="modal-title fw-semibold text-danger"><i class="ri-close-circle-line me-2"></i>Reject GRN</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger-transparent py-2 fs-13 mb-3">
                    <i class="ri-error-warning-line me-1"></i> Rejecting this GRN will return it for correction. A reason is required.
                </div>
                <label class="form-label fw-medium fs-13">Rejection Reason <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="4" placeholder="Please describe the reason for rejection..." id="reject-reason"></textarea>
                <div class="fs-12 text-muted mt-1">This message will be visible to the creator in GRN history.</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger btn-sm" id="confirm-reject-btn">
                    <i class="ri-close-circle-line me-1"></i> Confirm Rejection
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ====================================== -->
<!-- MODAL: Approve Confirmation            -->
<!-- ====================================== -->
<div class="modal fade" id="modalApprove" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="modal-title fw-semibold text-success"><i class="ri-checkbox-circle-line me-2"></i>Approve GRN</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success-transparent py-2 fs-13 mb-3">
                    <i class="ri-information-line me-1"></i> Approving this GRN will <strong>update warehouse inventory</strong> immediately.
                </div>
                <ul class="list-group list-group-flush fs-13 mb-0" id="approve-modal-details">
                    <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">GRN Number</span><strong id="approve-grn-number">--</strong></li>
                    <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">Supplier</span><strong id="approve-supplier">--</strong></li>
                    <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">Warehouse</span><strong id="approve-warehouse">--</strong></li>
                    <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">Grand Total</span><strong class="text-primary" id="approve-grand-total">LKR 0.00</strong></li>
                    <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">Total Items</span><strong id="approve-total-items">0 products, 0 units</strong></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success btn-sm" id="confirm-approve-btn">
                    <i class="ri-checkbox-circle-line me-1"></i> Confirm Approval &amp; Update Stock
                </button>
            </div>
        </div>
    </div>
</div>

                <!--End::row-1 -->

            </div>
        </div>
        <!-- End::app-content -->

        


        <div class="modal fade" id="responsive-searchModal" tabindex="-1" aria-labelledby="responsive-searchModal" aria-hidden="true">
		  <div class="modal-dialog">
			  <div class="modal-content">
				  <div class="modal-body">
					  <div class="input-group">
						  <input type="text" class="form-control border-end-0" placeholder="Search Anything ..."
							  aria-label="Search Anything ..." aria-describedby="button-addon2">
						  <button class="btn btn-primary" type="button"
							  id="button-addon2"><i class="bi bi-search"></i></button>
					  </div>
				  </div>
			  </div>
		  </div>
		</div>

    </div>

    
<!-- Scroll To Top -->
<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
</div>
<div id="responsive-overlay"></div>
<!-- Scroll To Top -->

<!-- Popper JS -->
<script src="../assets/libs/@popperjs/core/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Defaultmenu JS -->
<script src="../assets/js/defaultmenu.js"></script>

<!-- Node Waves JS-->
<script src="../assets/libs/node-waves/waves.min.js"></script>

<!-- Sticky JS -->
<script src="../assets/js/sticky.js"></script>

<!-- Simplebar JS -->
<script src="../assets/libs/simplebar/simplebar.min.js"></script>
<script src="../assets/js/simplebar.js"></script>

<!-- Auto Complete JS -->
<script src="../assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js"></script>

<!-- Color Picker JS -->
<script src="../assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>


    
<!-- Custom-Switcher JS -->
<script src="../assets/js/custom-switcher.js"></script>

    <!-- Date & Time Picker JS -->
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>

<script>
// Add this at the top with other global variables
let isGRNLoading = false;
let loadedGRNId = null;
	//function for selected discount type accoding to the config settings
	var dis_typ = '<?php $configs = $this->session->userdata('sys_config');echo $configs['SDisc_type'];?>';
	$('#bill-discount-type').val('<?= ($configs['SDisc_type'] ?? 'Percent') === 'Fixrd_val' ? 'LKR' : '%' ?>').trigger('change');
	$('#modal-discount-type').val('<?= ($configs['SDisc_type'] ?? 'Percent') === 'Fixrd_val' ? 'amount' : 'percent' ?>').trigger('change');
	

// Global helper functions
function showToast(msg, type = 'primary') {
    const colors = { primary: '#405189', success: '#25b865', danger: '#dc3545', warning: '#f7b731', info: '#0dcaf0' };
    const container = document.getElementById('toast-container') || (() => {
        const d = document.createElement('div');
        d.id = 'toast-container';
        d.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;';
        document.body.appendChild(d);
        return d;
    })();
    const toast = document.createElement('div');
    toast.style.cssText = `background:${colors[type] || colors.primary};color:#fff;padding:12px 18px;border-radius:8px;font-size:13px;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,0.2);max-width:320px;opacity:0;transform:translateY(8px);transition:all 0.25s;z-index:9999;`;
    toast.innerHTML = `<i class="ri-checkbox-circle-line me-2"></i>${msg}`;
    container.appendChild(toast);
    requestAnimationFrame(() => { toast.style.opacity = 1; toast.style.transform = 'translateY(0)'; });
    setTimeout(() => { toast.style.opacity = 0; setTimeout(() => toast.remove(), 300); }, 3500);
}

// Check if we're opening an existing GRN
const urlParams = new URLSearchParams(window.location.search);
const grnId = urlParams.get('id');

// Flag to prevent multiple loads
let isLoading = false;
// Function to update workflow steps based on status
function updateWorkflowSteps(status) {
    const steps = document.querySelectorAll('.grn-step');
    if (!steps.length) return;
    
    // Remove all active/done classes
    steps.forEach(step => {
        step.classList.remove('active', 'done');
    });
    
    // Define step order
    const stepOrder = ['Create', 'Draft', 'Submit', 'Review', 'Approve', 'Stock Update'];
    
    // Determine current step index based on status
    let currentStepIndex = 0;
    switch(status) {
        case 'draft':
            currentStepIndex = 1;
            break;
        case 'submitted':
            currentStepIndex = 2;
            break;
        case 'approved':
            currentStepIndex = 4;
            break;
        case 'rejected':
            currentStepIndex = 1;
            break;
        default:
            currentStepIndex = 1;
    }
    
    // Mark completed steps
    steps.forEach((step, index) => {
        const stepText = step.textContent.trim().replace(/[^A-Za-z\s]/g, '').trim();
        const stepName = stepText.split(' ')[0];
        
        if (index < currentStepIndex) {
            step.classList.add('done');
        } else if (index === currentStepIndex) {
            step.classList.add('active');
        }
    });
}
function setUIModeByStatus(status) {
    const isNew = (status === 'new');
    const isDraft = (status === 'draft');
    const isSubmitted = (status === 'submitted');
    const isApproved = (status === 'approved');
    const isRejected = (status === 'rejected');
    
    // Get permission flags from global variables
    var canApprove = typeof CAN_APPROVE_GRN !== 'undefined' ? CAN_APPROVE_GRN : false;
    var canReject = typeof CAN_REJECT_GRN !== 'undefined' ? CAN_REJECT_GRN : false;
    
    console.log('setUIModeByStatus - Status:', status);
    console.log('setUIModeByStatus - Can Approve:', canApprove, 'Can Reject:', canReject);
    
    if(isNew || isDraft) {
        // ✅ HIDE approve/reject buttons for ALL users in NEW/DRAFT mode
        $('#btn-save-draft, #btn-submit-approval').show();
        $('#btn-approve, #btn-reject').hide();  // Force hidden
        
        $('input, select, textarea, .btn-success[data-bs-target="#modalAddItem"]').prop('disabled', false);
        $('.qty-input, .price-input, .discount-input').prop('disabled', false);
        $('.btn-danger-light').show();
        updateWorkflowSteps('draft');
    } 

    else if(isSubmitted) {
        // ✅ ONLY show Approve/Reject buttons in SUBMITTED mode (based on permissions)
        $('#btn-save-draft, #btn-submit-approval').hide();
        
        if (canApprove) {
            $('#btn-approve').show();
        } else {
            $('#btn-approve').hide();
        }
        
        if (canReject) {
            $('#btn-reject').show();
        } else {
            $('#btn-reject').hide();
        }
        
        $('input, select, textarea, .btn-success[data-bs-target="#modalAddItem"]').prop('disabled', false);
        $('.qty-input, .price-input, .discount-input').prop('disabled', false);
        $('.btn-danger-light').show();
        updateWorkflowSteps('submitted');
    }
    else if(isApproved) {
        // Approved mode - LOCKED (no buttons)
        $('#btn-save-draft, #btn-submit-approval, #btn-approve, #btn-reject').hide();
        $('input, select, textarea, .btn-success[data-bs-target="#modalAddItem"]').prop('disabled', true);
        $('.qty-input, .price-input, .discount-input').prop('disabled', true);
        $('.btn-danger-light').hide();
        updateWorkflowSteps('approved');
    }
    else if(isRejected) {
        // Rejected mode - LOCKED (no buttons)
        $('#btn-save-draft, #btn-submit-approval, #btn-approve, #btn-reject').hide();
        $('input, select, textarea, .btn-success[data-bs-target="#modalAddItem"]').prop('disabled', true);
        $('.qty-input, .price-input, .discount-input').prop('disabled', true);
        $('.btn-danger-light').hide();
        updateWorkflowSteps('rejected');
    }
    else {
        // Default
        $('#btn-save-draft, #btn-submit-approval').show();
        $('#btn-approve, #btn-reject').hide();
        updateWorkflowSteps('draft');
    }

	
}
 
// Function to load GRN data by ID
function loadGRNDataById(id) {
    // Prevent duplicate loading
    if(isLoading) return;
    if(loadedGRNId === id) {
        console.log('GRN already loaded, skipping...');
        return;
    }
    
    isLoading = true;
    
    showToast('Loading GRN...', 'info');
    
    $.ajax({
        url: '<?= base_url("Grn/getGRNStatus/") ?>' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) { 
            if(response.status === 'success') { 
                loadedGRNId = id;
                setUIModeByStatus(response.data.status);
                loadExistingGRNById(id);
            } else {
                showToast('GRN not found', 'danger');
                if (typeof createNewDraftGRN === 'function') {
                    createNewDraftGRN();
                }
            }
            isLoading = false;
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            showToast('Error loading GRN status', 'danger');
            if (typeof createNewDraftGRN === 'function') {
                createNewDraftGRN();
            }
            isLoading = false;
        }
    });
}
// Function to load existing GRN by ID
function loadExistingGRNById(grnId) {
    console.log('Loading GRN by ID:', grnId);
    
    fetch('<?php echo site_url("Grn/getDraftGRNById/"); ?>' + grnId, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        console.log('GRN data received:', data);
        
        if (data.status === 'success' && data.data) {
            // Directly call a globally exposed function to load the data
            if (typeof window.loadGRNDataToForm === 'function') {
                window.loadGRNDataToForm(data.data);
            } else {
                console.error('loadGRNDataToForm function not found yet, storing data');
                window.pendingGRNData = data.data;
            }
        } else {
            showToast('Failed to load GRN data', 'danger');
        }
    })
    .catch(error => {
        console.error('Error loading GRN:', error);
        showToast('Error loading GRN', 'danger');
    });
}
window.processLoadedGRNData = function() {
    console.log('processLoadedGRNData called');
    console.log('window.pendingGRNId:', window.pendingGRNId);
    console.log('window.pendingGRNItems:', window.pendingGRNItems);
    
    if (window.pendingGRNId && window.pendingGRNItems) {
        // Set global variables for approve/reject
        window.currentGRNIdGlobal = window.pendingGRNId;
        window.currentGRNNumberGlobal = window.pendingGRNNumber;
        window.currentGRNStatusGlobal = window.pendingGRNStatus;
        
        // Also set hidden fields
        document.getElementById('hidden-grn-id').value = window.pendingGRNId;
        document.getElementById('hidden-grn-number').value = window.pendingGRNNumber;
        document.getElementById('grn-number-display').innerHTML = '<i class="ri-file-list-3-line me-1"></i>' + window.pendingGRNNumber;
        
        // Update status badge
        const statusBadge = document.querySelector('.grn-status-badge');
        if (statusBadge && window.pendingGRNStatus) {
            statusBadge.textContent = window.pendingGRNStatus.toUpperCase();
            statusBadge.className = 'badge grn-status-badge badge-' + window.pendingGRNStatus;
        }
        
        // Set form values
        if (window.pendingGRNFullData) {
            const fullData = window.pendingGRNFullData;
            if (fullData.supplier_id) $('#grn-supplier').val(fullData.supplier_id).trigger('change');
            if (fullData.warehouse_id) $('#grn-warehouse').val(fullData.warehouse_id);
            if (fullData.grn_date) $('#grn-date').val(fullData.grn_date);
            if (fullData.received_by) $('#grn-received-by').val(fullData.received_by);
            if (fullData.delivery_note) $('#grn-delivery-note').val(fullData.delivery_note);
            if (fullData.ref_invoice_no) $('#grn-ref').val(fullData.ref_invoice_no);
            if (fullData.remarks) $('#grn-remarks').val(fullData.remarks);
            if (fullData.paid_amount !== undefined) $('#grn-paid-amount').val(fullData.paid_amount);
            if (fullData.discount_value) $('#bill-discount-val').val(fullData.discount_value);
            if (fullData.discount_type) {
                $('#bill-discount-type').val(fullData.discount_type === 'percent' ? '%' : 'LKR');
            }
        }
        
        // Render items directly using the global function
        if (typeof window.renderItemsTableDirectly === 'function') {
            window.renderItemsTableDirectly(window.pendingGRNItems);
        } else {
            console.error('renderItemsTableDirectly not found');
        }
        
        // Update UI mode
        if (typeof setUIModeByStatus === 'function') {
            setUIModeByStatus(window.pendingGRNStatus || 'draft');
        }
        
        // Load summary and history
        if (window.pendingGRNId) {
            if (typeof loadGRNSummary === 'function') {
                loadGRNSummary(window.pendingGRNId);
            }
            if (typeof loadGRNHistory === 'function') {
                loadGRNHistory(window.pendingGRNId);
            }
            if (typeof loadAttachments === 'function') {
                loadAttachments(window.pendingGRNId);
            }
            // Load payment data if approved
            if ((window.pendingGRNStatus === 'approved' || window.pendingGRNStatus === 'submitted') && typeof loadPaymentData === 'function') {
                loadPaymentData(window.pendingGRNId);
            }
        }
        
        // Show/hide payment sections
        if (window.pendingGRNStatus === 'approved') {
            $('#payment-summary-card, #payment-history-card').show();
        } else {
            $('#payment-summary-card, #payment-history-card').hide();
        }
        
        showToast(window.pendingGRNNumber + ' loaded successfully', 'success');
    }
};

// Also create a direct render function that will be available globally
window.renderItemsTableDirectly = function(items) {
    console.log('renderItemsTableDirectly called with items:', items);
    
    if (!items || items.length === 0) {
        document.getElementById('grn-items-tbody').innerHTML = '<td colspan="10" class="text-center py-3">No items added yet</td>';
        return;
    }
    
    let html = '';
    let idx = 1;
    
    items.forEach((item) => {
        const product = productsById ? productsById[item.product_id] : null;
        const productName = product ? product.name : 'Product ID: ' + item.product_id;
        const qty = parseFloat(item.quantity) || 0;
        const freeQty = parseFloat(item.free_quantity) || 0;
        const price = parseFloat(item.unit_price) || 0;
        const discVal = parseFloat(item.discount_value) || 0;
        const discType = item.discount_type === 'percent' ? '%' : 'LKR';
        const lineTotal = (qty * price) - (discType === '%' ? (qty * price * discVal / 100) : discVal);
        const hasSerials = item.has_serials == 1;
        const isExpiryTracked = !!(item.batch_number && item.expiry_date);
        
        let indicators = '';
        if (isExpiryTracked && item.batch_number && item.expiry_date) {
            indicators += `<span class="badge bg-success-light text-success ms-1"><i class="ri-stack-line"></i> Batch ✓</span>`;
        }
        if (hasSerials) {
            indicators += `<span class="badge bg-info-light text-info ms-1"><i class="ri-barcode-line"></i> Serial</span>`;
        }
        
        html += `
            <tr>
                <td class="text-muted fs-12">${idx++}</td>
                <td>
                    <div class="fw-semibold fs-13">${escapeHtml(productName)}</div>
                    <div class="fs-11 text-muted">${indicators}</div>
                    ${item.batch_number && item.expiry_date ? `<div class="fs-10 text-muted mt-1">Batch: ${escapeHtml(item.batch_number)} | Expiry: ${escapeHtml(item.expiry_date)}</div>` : ''}
                </td>
                <td><span class="badge bg-light text-dark">pcs</span></td>
                <td><input type="number" class="form-control qty-input" value="${qty}" min="1" style="width:80px" disabled></td>
                <td><input type="number" class="form-control qty-input" value="${freeQty}" min="0" style="width:80px" disabled></td>
                <td><input type="number" class="form-control price-input" value="${price.toFixed(2)}" step="0.01" style="width:110px" disabled></td>
                <td>
                    <div class="d-flex gap-1">
                        <input type="number" class="form-control discount-input" value="${discVal}" min="0" style="width:85px" disabled>
                        <select class="form-select form-select-sm" style="width:60px" disabled>
                            <option ${discType === '%' ? 'selected' : ''}>%</option>
                            <option ${discType === 'LKR' ? 'selected' : ''}>LKR</option>
                        </select>
                    </div>
                </td>
                <td class="fw-semibold text-end">${fmtLKR(lineTotal)}</td>
                <td></td>
            </tr>
        `;
    });
    
    document.getElementById('grn-items-tbody').innerHTML = html;
    
    // Update totals
    if (typeof updateTotals === 'function') {
        updateTotals();
    }
};

// Call processLoadedGRNData when data is available
if (window.pendingGRNId) {
    setTimeout(function() {
        if (typeof window.processLoadedGRNData === 'function') {
            window.processLoadedGRNData();
        }
    }, 100);
}
// DEFINE THE FUNCTION HERE BEFORE IT'S CALLED
window.loadGRNDataToForm = function(grnData) {
    // Prevent duplicate processing
    if (window.processedGRNId === grnData.id) {
        console.log('GRN already processed, skipping...');
        return;
    }
    window.processedGRNId = grnData.id;
    
    console.log('loadGRNDataToForm called with:', grnData);
    console.log('received_by value:', grnData.received_by);
    
    if (!grnData) {
        console.error('No GRN data provided');
        return;
    }
    
    // First, store the received_by value before any UI changes
    var receivedByValue = grnData.received_by && grnData.received_by != 'null' && grnData.received_by != '' ? grnData.received_by : null;
    
    // Set form values
    if (grnData.supplier_id) $('#grn-supplier').val(grnData.supplier_id);
    if (grnData.warehouse_id) $('#grn-warehouse').val(grnData.warehouse_id);
    if (grnData.grn_date) $('#grn-date').val(grnData.grn_date);
    if (grnData.delivery_note) $('#grn-delivery-note').val(grnData.delivery_note);
    if (grnData.ref_invoice_no) $('#grn-ref').val(grnData.ref_invoice_no);
    if (grnData.remarks) $('#grn-remarks').val(grnData.remarks);
    if (grnData.paid_amount !== undefined && grnData.paid_amount !== null) {
        $('#grn-paid-amount').val(grnData.paid_amount);
    }
    if (grnData.discount_value) $('#bill-discount-val').val(grnData.discount_value);
    if (grnData.discount_type) {
        $('#bill-discount-type').val(grnData.discount_type === 'percent' ? '%' : 'LKR');
    }
    
    // Set received_by value BEFORE triggering status change
    if (receivedByValue) {
        console.log('Setting received_by to:', receivedByValue);
        $('#grn-received-by').val(receivedByValue);
    }
    
    // Store data for processing
    if (!window.pendingGRNData || window.pendingGRNData.id !== grnData.id) {
        window.pendingGRNItems = grnData.items || [];
        window.pendingGRNId = grnData.id;
        window.pendingGRNNumber = grnData.grn_number;
        window.pendingGRNStatus = grnData.status || 'draft';
        window.pendingGRNFullData = grnData;
    }
    
    // Set UI mode based on status - this may disable inputs but should preserve values
    if (typeof setUIModeByStatus === 'function') {
        setUIModeByStatus(grnData.status || 'draft');
    }
    
    // AFTER setting UI mode, re-set the received_by value (in case it was cleared)
    if (receivedByValue) {
        setTimeout(function() {
            console.log('Re-setting received_by to:', receivedByValue);
            $('#grn-received-by').val(receivedByValue);
            console.log('Current received_by value after re-set:', $('#grn-received-by').val());
        }, 50);
    }
    
    // Load summary and history
    if (grnData.id && !window.summaryLoadedForGRN) {
        window.summaryLoadedForGRN = grnData.id;
        if (typeof loadGRNSummary === 'function') {
            loadGRNSummary(grnData.id);
        }
        if (typeof loadGRNHistory === 'function') {
            loadGRNHistory(grnData.id);
        }
        if (typeof loadAttachments === 'function') {
            loadAttachments(grnData.id);
        }
    }
    
    // Process the loaded data only once
    if (typeof window.processLoadedGRNData === 'function' && !window.processedGRNData) {
        window.processedGRNData = true;
        window.processLoadedGRNData();
    }
    
    showToast(grnData.grn_number + ' loaded successfully', 'success');
};


// Make productsById available globally
window.productsByIdGlobal = {
<?php foreach ($products as $p): ?>
    <?php echo $p->id; ?>: {
        id: <?php echo $p->id; ?>,
        name: '<?php echo addslashes($p->name); ?>',
        sku: '<?php echo addslashes($p->product_code ?? ''); ?>',
        price: <?php echo floatval($p->price ?? 0); ?>,
        unit: '',
        stock: 0
    },
<?php endforeach; ?>
};

// Update the renderItemsTableDirectly function to use the global productsById
window.renderItemsTableDirectly = function(items) {
    console.log('renderItemsTableDirectly called with items:', items);
    
    if (!items || items.length === 0) {
        const tbody = document.getElementById('grn-items-tbody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center py-3">No items added yet</td></tr>';
        }
        return;
    }
    
    let html = '';
    let idx = 1;
    
    items.forEach((item) => {
        // Use the global productsById
        const product = window.productsByIdGlobal ? window.productsByIdGlobal[item.product_id] : null;
        const productName = product ? product.name : 'Product ID: ' + item.product_id;
        const qty = parseFloat(item.quantity) || 0;
        const freeQty = parseFloat(item.free_quantity) || 0;
        const price = parseFloat(item.unit_price) || 0;
        const discVal = parseFloat(item.discount_value) || 0;
        const discType = item.discount_type === 'percent' ? '%' : 'LKR';
        const lineTotal = (qty * price) - (discType === '%' ? (qty * price * discVal / 100) : discVal);
        const hasSerials = item.has_serials == 1;
        const isExpiryTracked = !!(item.batch_number && item.expiry_date);
        
        let indicators = '';
        if (isExpiryTracked && item.batch_number && item.expiry_date) {
            indicators += `<span class="badge bg-success-light text-success ms-1"><i class="ri-stack-line"></i> Batch ✓</span>`;
        }
        if (hasSerials) {
            indicators += `<span class="badge bg-info-light text-info ms-1"><i class="ri-barcode-line"></i> Serial</span>`;
        }
        
        // Function to escape HTML
        function escapeHtml(text) {
            if (!text) return '';
            return String(text).replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }
        
        html += `
            <tr data-item-id="${item.id || idx}">
                <td class="text-muted fs-12">${idx++}</td>
                <td>
                    <div class="fw-semibold fs-13">${escapeHtml(productName)}</div>
                    <div class="fs-11 text-muted">${indicators}</div>
                    ${item.batch_number && item.expiry_date ? `<div class="fs-10 text-muted mt-1">Batch: ${escapeHtml(item.batch_number)} | Expiry: ${escapeHtml(item.expiry_date)}</div>` : ''}
                </td>
                <td><span class="badge bg-light text-dark">pcs</span></td>
                <td><input type="number" class="form-control qty-input" value="${qty}" min="1" style="width:80px" disabled></td>
                <td><input type="number" class="form-control qty-input" value="${freeQty}" min="0" style="width:80px" disabled></td>
                <td><input type="number" class="form-control price-input" value="${price.toFixed(2)}" step="0.01" style="width:110px" disabled></td>
                <td>
                    <div class="d-flex gap-1">
                        <input type="number" class="form-control discount-input" value="${discVal}" min="0" style="width:85px" disabled>
                        <select class="form-select form-select-sm" style="width:60px" disabled>
                            <option ${discType === '%' ? 'selected' : ''}>%</option>
                            <option ${discType === 'LKR' ? 'selected' : ''}>LKR</option>
                        </select>
                    </div>
                </td>
                <td class="fw-semibold text-end">${fmtLKR(lineTotal)}</td>
                <td></td>
            </tr>
        `;
    });
    
    const tbody = document.getElementById('grn-items-tbody');
    if (tbody) {
        tbody.innerHTML = html;
    }
    
    // Update totals if the function exists
    if (typeof updateTotals === 'function') {
        updateTotals();
    } else if (typeof window.updateTotalsGlobal === 'function') {
        window.updateTotalsGlobal();
    } else {
        // Manually update totals
        let subtotal = 0;
        items.forEach(item => {
            const qty = parseFloat(item.quantity) || 0;
            const price = parseFloat(item.unit_price) || 0;
            subtotal += qty * price;
        });
        const grandTotalSpan = document.getElementById('tot-grand');
        if (grandTotalSpan) {
            grandTotalSpan.textContent = fmtLKR(subtotal);
        }
        const summaryGrandTotal = document.getElementById('summary-grand-total');
        if (summaryGrandTotal) {
            summaryGrandTotal.textContent = fmtLKR(subtotal);
        }
        const summaryTotalItems = document.getElementById('summary-total-items');
        if (summaryTotalItems) {
            summaryTotalItems.textContent = items.length;
        }
    }
};

// Helper function fmtLKR if not defined globally
if (typeof fmtLKR !== 'function') {
    window.fmtLKR = function(n) {
        return 'LKR ' + parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };
    var fmtLKR = window.fmtLKR;
}
window.pendingGRNData = null;

// If GRN ID exists in URL, load it
if(grnId && loadedGRNId !== grnId) {
    $(document).ready(function() {
        loadGRNDataById(grnId);
    });
}
</script>
<!-- ===== GRN Create Module JS ===== -->
<script>


    /* ========== GLOBAL VARIABLES ========== */
    (function () {
    'use strict';

    /* ========== GLOBAL VARIABLES ========== */
    let grnItems = [];
    let nextItemId = 1;
    let currentGRNId = null;
    let currentGRNNumber = null;
    let currentGRNStatus = 'draft';  // ADD THIS LINE
    let selectedFiles = [];
    let currentSerialItem = null;
    let serialNumbersArray = [];
    let editingItemId = null;
    let currentProductDetails = null;
    
    // Add this reference to global showToast
    const showToastGlobal = window.showToast;  // ADD THIS LINE

    /* ========== PRODUCT DATA ========== */
    const productsById = {
<?php foreach ($products as $p): ?>
        <?php echo $p->id; ?>: {
            id: <?php echo $p->id; ?>,
            name: '<?php echo addslashes($p->name); ?>',
            sku: '<?php echo addslashes($p->product_code ?? ''); ?>',
            price: <?php echo floatval($p->price ?? 0); ?>,
            unit: '',
            stock: 0
        },
<?php endforeach; ?>
    };

    const taxRates = [
<?php foreach($tax_rates as $tax): ?>
        { id: <?php echo $tax->tax_rate_id; ?>, name: '<?php echo addslashes($tax->tax_name); ?>', rate: <?php echo $tax->tax_rate; ?> },
<?php endforeach; ?>
    ];

    const mockSuppliers = {
<?php foreach ($sup as $sp): ?>
        <?php echo $sp->id; ?>: { name: '<?php echo addslashes($sp->name); ?>', phone: '<?php echo addslashes($sp->phone ?? ''); ?>' },
<?php endforeach; ?>
    };

    /* ========== HELPER FUNCTIONS ========== */
    function fmtLKR(n) {
        return 'LKR ' + parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function showToast(msg, type = 'primary') {
        const colors = { primary: '#405189', success: '#25b865', danger: '#dc3545', warning: '#f7b731', info: '#0dcaf0' };
        const container = document.getElementById('toast-container') || (() => {
            const d = document.createElement('div');
            d.id = 'toast-container';
            d.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;';
            document.body.appendChild(d);
            return d;
        })();
        const toast = document.createElement('div');
        toast.style.cssText = `background:${colors[type] || colors.primary};color:#fff;padding:12px 18px;border-radius:8px;font-size:13px;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,0.2);max-width:320px;opacity:0;transform:translateY(8px);transition:all 0.25s;`;
        toast.innerHTML = `<i class="ri-checkbox-circle-line me-2"></i>${msg}`;
        container.appendChild(toast);
        requestAnimationFrame(() => { toast.style.opacity = 1; toast.style.transform = 'translateY(0)'; });
        setTimeout(() => { toast.style.opacity = 0; setTimeout(() => toast.remove(), 300); }, 3500);
    }

function loadExistingDraft(draft) {
    console.log('loadExistingDraft called with:', draft);
    
    currentGRNId = draft.id;
    currentGRNNumber = draft.grn_number;
    currentGRNStatus = draft.status;
    
    document.getElementById('hidden-grn-id').value = currentGRNId;
    document.getElementById('hidden-grn-number').value = currentGRNNumber;
    document.getElementById('grn-number-display').innerHTML = '<i class="ri-file-list-3-line me-1"></i>' + currentGRNNumber;
    
    // Set form values
    if (draft.supplier_id) $('#grn-supplier').val(draft.supplier_id).trigger('change');
    if (draft.warehouse_id) $('#grn-warehouse').val(draft.warehouse_id);
    if (draft.grn_date) $('#grn-date').val(draft.grn_date);
    if (draft.received_by) $('#grn-received-by').val(draft.received_by);
    if (draft.delivery_note) $('#grn-delivery-note').val(draft.delivery_note);
    if (draft.ref_invoice_no) $('#grn-ref').val(draft.ref_invoice_no);
    if (draft.remarks) $('#grn-remarks').val(draft.remarks);
    
    // Set discount values
    if (draft.discount_value) $('#bill-discount-val').val(draft.discount_value);
    if (draft.discount_type) {
        $('#bill-discount-type').val(draft.discount_type === 'percent' ? '%' : 'LKR');
    }
    
    // ========== FIX: Clear and reload items correctly ==========
    if (draft.items && draft.items.length > 0) {
        // Clear existing items array
        grnItems = [];
        nextItemId = 1;
        
        // Add each item to grnItems array
        draft.items.forEach((item) => {
            const product = productsById[item.product_id];
            if (product) {
                const hasSerials = item.has_serials == 1;
                const serialsArray = item.serials ? item.serials : [];
                
                // Calculate serialsDone properly
                let serialsDone = true;
                if (hasSerials) {
                    const qty = parseFloat(item.quantity) || 0;
                    serialsDone = serialsArray.length >= qty;
                }
                
                grnItems.push({
                    id: nextItemId++,
                    productId: item.product_id,
                    name: product.name,
                    sku: product.sku || '',
                    unit: 'pcs',
                    qty: parseFloat(item.quantity) || 0,
                    freeQty: parseFloat(item.free_quantity) || 0,
                    price: parseFloat(item.unit_price) || 0,
                    discVal: parseFloat(item.discount_value) || 0,
                    discType: item.discount_type === 'percent' ? '%' : 'LKR',
                    taxRate: parseFloat(item.tax_value) || 0,
                    batch: item.batch_number || '',
                    expiry: item.expiry_date || '',
                    isSerial: hasSerials,
                    serialsDone: serialsDone,
                    serials: serialsArray,
                    currentStock: 0,
                    isExpiryTracked: !!(item.batch_number && item.expiry_date)
                });
            }
        });
        
        console.log('Loaded items into grnItems:', grnItems);
        
        // Render the items table
        if (typeof renderItemsTable === 'function') {
            renderItemsTable();
        }
        
        // Update stock impact preview
        if (typeof fetchCurrentStockForItems === 'function') {
            fetchCurrentStockForItems();
        }
    } else {
        console.log('No items found in draft');
        // Clear items table
        if (typeof renderItemsTable === 'function') {
            renderItemsTable();
        }
    }
    
    // Apply disable state based on status
    applyDisableState();
    
    // Load attachments
    if (currentGRNId && typeof loadAttachments === 'function') {
        loadAttachments(currentGRNId);
    }
    
    // Load summary and history
    if (currentGRNId) {
        if (typeof loadGRNSummary === 'function') {
            loadGRNSummary(currentGRNId);
        }
        if (typeof loadGRNHistory === 'function') {
            loadGRNHistory(currentGRNId);
        }
    }
    
    // Update totals
    if (typeof updateTotals === 'function') {
        updateTotals();
    }
    
    // Update validation checklist
    if (typeof updateValidationChecklist === 'function') {
        updateValidationChecklist();
    }
    
    // Show/hide payment sections based on status
    if (currentGRNStatus === 'approved') {
        $('#payment-summary-card, #payment-history-card').show();
        if (typeof loadPaymentData === 'function') {
            loadPaymentData(currentGRNId);
        }
        // Check if already fully paid
        const balanceSpan = document.getElementById('payment-balance');
        const balanceText = balanceSpan ? balanceSpan.textContent : 'LKR 0.00';
        const balance = parseFloat(balanceText.replace('LKR', '').replace(/,/g, '')) || 0;
        
        if (balance <= 0) {
            $('#btn-record-payment-modal').hide();
        } else {
            $('#btn-record-payment-modal').show();
        }
    } else {
        $('#payment-summary-card, #payment-history-card').hide();
    }
    
    showToast(currentGRNNumber + ' loaded successfully', 'success');
}

   // Inside your IIFE, after the variable declarations, add:

// Expose a function to process GRN data
window.processGRNData = function(draft) {
    console.log('Processing GRN data in IIFE');
    loadExistingDraft(draft);
};

// Check for pending data
if (window.pendingGRNData) {
    console.log('Loading pending GRN data from global');
    loadExistingDraft(window.pendingGRNData);
    delete window.pendingGRNData;
}

    function getUnitIdFromName(unitName) {
        const unitMap = { 'pcs': 1, 'kg': 2, 'ltr': 3, 'box': 4, 'dozen': 5 };
        return unitMap[unitName.toLowerCase()] || 1;
    }
// THIS CODE GOES AFTER THE IIFE ENDS (after the closing })();

// Listen for when GRN data is loaded and update the global currentGRNId
(function monitorGRNLoad() {
    // Check every 500ms if GRN data has been loaded
    const interval = setInterval(function() {
        if (window.pendingGRNId && window.pendingGRNId !== 'null' && window.pendingGRNId !== null) {
            console.log('monitorGRNLoad: Found pending GRN ID:', window.pendingGRNId);
            
            // Update all the variables that approve/reject functions need
            window.currentGRNIdGlobal = window.pendingGRNId;
            window.currentGRNNumberGlobal = window.pendingGRNNumber;
            window.currentGRNStatusGlobal = window.pendingGRNStatus;
            
            // Also update the IIFE's variables if accessible
            if (typeof currentGRNId !== 'undefined') {
                // This is tricky because currentGRNId is inside IIFE scope
                // Instead, we'll override the approve/reject functions to use window.currentGRNIdGlobal
                console.log('Set window.currentGRNIdGlobal =', window.currentGRNIdGlobal);
            }
            
            // Clear the interval once we have the data
            clearInterval(interval);
        }
    }, 500);
    
    // Also check immediately
    setTimeout(function() {
        if (window.pendingGRNId && window.pendingGRNId !== 'null' && window.pendingGRNId !== null) {
            console.log('monitorGRNLoad (timeout): Found pending GRN ID:', window.pendingGRNId);
            window.currentGRNIdGlobal = window.pendingGRNId;
            window.currentGRNNumberGlobal = window.pendingGRNNumber;
            window.currentGRNStatusGlobal = window.pendingGRNStatus;
        }
    }, 100);
})();
// Add this inside your IIFE, after the loadExistingDraft function

// Function to sync external data into grnItems
function syncExternalDataToGrnItems(externalItems) {
	// Add this debug line right after the sync function definition
console.log('syncExternalDataToGrnItems function defined');
    if (!externalItems || externalItems.length === 0) return;
    
    console.log('Syncing external items to grnItems:', externalItems);
    
    // Clear existing items
    grnItems = [];
    nextItemId = 1;
    
    // Add each item
    externalItems.forEach((item, index) => {
        const product = productsById[item.product_id];
        if (product) {
            const hasSerials = item.has_serials == 1;
            const serialsArray = item.serials ? item.serials : [];
            
            let serialsDone = true;
            if (hasSerials) {
                const qty = parseFloat(item.quantity) || 0;
                serialsDone = serialsArray.length >= qty;
            }
            
            grnItems.push({
                id: nextItemId++,
                productId: item.product_id,
                name: product.name,
                sku: product.sku || '',
                unit: 'pcs',
                qty: parseFloat(item.quantity) || 0,
                freeQty: parseFloat(item.free_quantity) || 0,
                price: parseFloat(item.unit_price) || 0,
                discVal: parseFloat(item.discount_value) || 0,
                discType: item.discount_type === 'percent' ? '%' : 'LKR',
                taxRate: parseFloat(item.tax_value) || 0,
                batch: item.batch_number || '',
                expiry: item.expiry_date || '',
                isSerial: hasSerials,
                serialsDone: serialsDone,
                serials: serialsArray,
                currentStock: 0,
                isExpiryTracked: !!(item.batch_number && item.expiry_date)
            });
        }
    });
    
    console.log('grnItems after sync:', grnItems);
    
    // Render the table using the internal render function
    if (typeof renderItemsTable === 'function') {
        renderItemsTable();
    }
    
    // Update totals
    if (typeof updateTotals === 'function') {
        updateTotals();
    }
    
    // Update validation checklist
    if (typeof updateValidationChecklist === 'function') {
        updateValidationChecklist();
    }
    
    // Fetch stock for items
    if (typeof fetchCurrentStockForItems === 'function') {
        fetchCurrentStockForItems();
    }
}

// Override the window.renderItemsTableDirectly to also sync data to grnItems
const originalRenderItemsTableDirectly = window.renderItemsTableDirectly;
window.renderItemsTableDirectly = function(items) {
    console.log('Intercepted renderItemsTableDirectly, items length:', items ? items.length : 0);
    console.log('Call stack for renderItemsTableDirectly:', new Error().stack);
    
    // Call the original function to display the table
    if (originalRenderItemsTableDirectly) {
        originalRenderItemsTableDirectly(items);
    }
    
    // Sync the data to the internal grnItems array
    syncExternalDataToGrnItems(items);
};
    /* ========== GRN DATA COLLECTION ========== */
function collectGRNData() {
    const supplierId = document.getElementById('grn-supplier').value;
    const warehouseId = document.getElementById('grn-warehouse').value;
    let grnDate = document.getElementById('grn-date').value;
    const receivedBy = document.getElementById('grn-received-by').value;
    const deliveryNote = document.getElementById('grn-delivery-note').value;
    const referenceNo = document.getElementById('grn-ref').value;
    const remarks = document.getElementById('grn-remarks').value;
	const paidAmount = parseFloat(document.getElementById('grn-paid-amount')?.value) || 0;
    
    let subtotal = 0, totalLineDiscount = 0;
    
    grnItems.forEach(item => {
        const lineValue = (item.qty || 0) * (item.price || 0);
        let discount = 0;
        if (item.discType === '%') {
            discount = lineValue * ((item.discVal || 0) / 100);
        } else {
            discount = Math.min(item.discVal || 0, lineValue);
        }
        subtotal += lineValue;
        totalLineDiscount += discount;
    });
    
    const discountValue = parseFloat(document.getElementById('bill-discount-val').value) || 0;
    const discountTypeSelect = document.getElementById('bill-discount-type');
    const discountType = discountTypeSelect.value === '%' ? 'percent' : 'amount';
    
    const afterLineDiscount = subtotal - totalLineDiscount;
    let billDiscountAmount = 0;
    if (discountType === 'percent') {
        billDiscountAmount = afterLineDiscount * (discountValue / 100);
    } else {
        billDiscountAmount = Math.min(discountValue, afterLineDiscount);
    }
    
    const afterBillDiscount = afterLineDiscount - billDiscountAmount;
    
    // Get global tax rate
    const globalTaxRate = parseFloat(document.getElementById('global-tax-rate')?.value || 0);
    const taxAmount = afterBillDiscount * (globalTaxRate / 100);
    const grandTotal = afterBillDiscount + taxAmount;
    
    if (grnDate && grnDate.includes('/')) {
        const parts = grnDate.split('/');
        if (parts.length === 3) grnDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
    }
    
    const items = grnItems.map(item => ({
        product_id: item.productId,
        unit_id: getUnitIdFromName(item.unit),
        quantity: item.qty,
        free_quantity: item.freeQty || 0,
        unit_price: item.price,
        discount_value: item.discVal || 0,
        discount_type: item.discType === '%' ? 'percent' : 'amount',
        tax_value: 0,  // No per-item tax
        batch_number: item.batch || null,
        expiry_date: item.expiry || null,
        line_total: (item.qty * item.price) - (item.discVal || 0),
        has_serials: (item.isSerial && item.serialsDone && item.serials && item.serials.length > 0) ? 1 : 0,
        serials_data: (item.isSerial && item.serialsDone && item.serials) ? item.serials : null
    }));
    
    return {
        grn_id: currentGRNId,  
        grn_number: currentGRNNumber,
        supplier_id: parseInt(supplierId),
        warehouse_id: parseInt(warehouseId),
        grn_date: grnDate,
        delivery_note: deliveryNote || null,
        reference_no: referenceNo || null,
		remarks: remarks || null,
        received_by: parseInt(receivedBy) || null,
        subtotal: subtotal,
        discount_value: discountValue,
        discount_type: discountType,
        tax_rate: globalTaxRate,  // Add global tax rate
        tax_amount: taxAmount,     // Add calculated tax amount
        grand_total: grandTotal,
		paid_amount: paidAmount,
        line_discount_total: totalLineDiscount,
        items: items
    };

}
/* ========== APPLY DISABLE STATE TO ALL INPUTS ========== */
function applyDisableState() {
    const status = currentGRNStatus;
    const isSubmitted = (status === 'submitted');
    const isApproved = (status === 'approved');
    const isLocked = (isSubmitted || isApproved);
    
    console.log('applyDisableState called - Status:', status, 'Locked:', isLocked);
    
    if (isLocked) {
        // ========== STORE CURRENT VALUES BEFORE DISABLING ==========
        var supplierVal = $('#grn-supplier').val();
        var warehouseVal = $('#grn-warehouse').val();
        var dateVal = $('#grn-date').val();
        var receivedByVal = $('#grn-received-by').val();
        var deliveryNoteVal = $('#grn-delivery-note').val();
        var refVal = $('#grn-ref').val();
        var remarksVal = $('#grn-remarks').val();
        var paidAmountVal = $('#grn-paid-amount').val();
        var billDiscountVal = $('#bill-discount-val').val();
        var billDiscountType = $('#bill-discount-type').val();
        
        // ========== DISABLE ALL FORM FIELDS ==========
        $('#grn-supplier, #grn-warehouse, #grn-date, #grn-received-by, #grn-delivery-note, #grn-ref, #grn-remarks').prop('disabled', true);
        
        // ========== DISABLE BILL DISCOUNT FIELDS ==========
        $('#bill-discount-val, #bill-discount-type').prop('disabled', true);
        
        // ========== RESTORE VALUES AFTER DISABLING ==========
        $('#grn-supplier').val(supplierVal);
        $('#grn-warehouse').val(warehouseVal);
        $('#grn-date').val(dateVal);
        $('#grn-received-by').val(receivedByVal);
        $('#grn-delivery-note').val(deliveryNoteVal);
        $('#grn-ref').val(refVal);
        $('#grn-remarks').val(remarksVal);
        $('#grn-paid-amount').val(paidAmountVal);
        $('#bill-discount-val').val(billDiscountVal);
        $('#bill-discount-type').val(billDiscountType);
        
        // ========== DISABLE ALL ITEMS TABLE INPUTS ==========
        $('.qty-input, .price-input, .discount-input, .discount-type-select, .tax-select').prop('disabled', true);
        
        // ========== DISABLE ACTION BUTTONS IN ITEMS TABLE ==========
        $('.btn-icon.btn-danger-light, .btn-icon.btn-warning-light, .btn-icon.btn-info-light').prop('disabled', true);
        
        // ========== HIDE/DISABLE "ADD PRODUCT" BUTTON ==========
        $('.btn-success[data-bs-target="#modalAddItem"]').hide().prop('disabled', true);
        
        // ========== DISABLE "IMPORT PURCHASE ORDER" BUTTON ==========
        $('.btn-primary[data-bs-target="#modalImportPO"]').prop('disabled', true).css('opacity', '0.6');
        
        // ========== DISABLE ATTACHMENT UPLOAD ==========
        $('#grn-dropzone').css({
            'pointer-events': 'none',
            'opacity': '0.6',
            'cursor': 'not-allowed'
        });
        $('#att-file-input').prop('disabled', true);
        
        // ========== DISABLE MODAL BUTTONS ==========
        $('#modalAddItem .btn-info, #modalAddItem .btn-success, #modalAddItem .btn-secondary').prop('disabled', true);
        $('#modal-product').prop('disabled', true);
        
        // ========== DISABLE PO IMPORT MODAL ==========
        $('#modalImportPO .btn-primary, #modalImportPO .btn-secondary').prop('disabled', true);
        $('#po-filter-supplier, #po-filter-date-from, #po-filter-date-to').prop('disabled', true);
        $('#btn-search-po, #btn-import-selected').prop('disabled', true);
        
        // ========== DISABLE BATCH MODAL ==========
        $('#modalBatchExpiry .btn-primary, #modalBatchExpiry .btn-secondary').prop('disabled', true);
        $('#batch-number, #expiry-date').prop('disabled', true);
        
        // ========== DISABLE SERIAL MODAL ==========
        $('#modalSerialNumbers .btn-primary, #modalSerialNumbers .btn-secondary').prop('disabled', true);
        $('#sn-start, #sn-end, #btn-generate-sn, #btn-add-sn').prop('disabled', true);
        $('.sn-input').prop('disabled', true);
        
        // ========== SHOW LOCK MESSAGE ==========
        $('#upload-status').html('<span class="badge bg-danger-transparent text-danger"><i class="ri-lock-line me-1"></i> Locked - Cannot upload when GRN is ' + status + '</span>');
        
    } else {
        // ========== ENABLE ALL FORM FIELDS ==========
        $('#grn-supplier, #grn-warehouse, #grn-date, #grn-received-by, #grn-delivery-note, #grn-ref, #grn-remarks').prop('disabled', false);
        
        // ========== ENABLE BILL DISCOUNT FIELDS ==========
        $('#bill-discount-val, #bill-discount-type').prop('disabled', false);
        
        // ========== ENABLE "ADD PRODUCT" BUTTON ==========
        $('.btn-success[data-bs-target="#modalAddItem"]').show().prop('disabled', false);
        
        // ========== ENABLE "IMPORT PURCHASE ORDER" BUTTON ==========
        $('.btn-primary[data-bs-target="#modalImportPO"]').prop('disabled', false).css('opacity', '1');
        
        // ========== ENABLE ATTACHMENT UPLOAD ==========
        $('#grn-dropzone').css({
            'pointer-events': 'auto',
            'opacity': '1',
            'cursor': 'pointer'
        });
        $('#att-file-input').prop('disabled', false);
        
        // ========== ENABLE MODAL BUTTONS ==========
        $('#modalAddItem .btn-info, #modalAddItem .btn-success, #modalAddItem .btn-secondary').prop('disabled', false);
        $('#modal-product').prop('disabled', false);
        
        // ========== ENABLE PO IMPORT MODAL ==========
        $('#modalImportPO .btn-primary, #modalImportPO .btn-secondary').prop('disabled', false);
        $('#po-filter-supplier, #po-filter-date-from, #po-filter-date-to').prop('disabled', false);
        $('#btn-search-po, #btn-import-selected').prop('disabled', false);
        
        // ========== ENABLE BATCH MODAL ==========
        $('#modalBatchExpiry .btn-primary, #modalBatchExpiry .btn-secondary').prop('disabled', false);
        $('#batch-number, #expiry-date').prop('disabled', false);
        
        // ========== ENABLE SERIAL MODAL ==========
        $('#modalSerialNumbers .btn-primary, #modalSerialNumbers .btn-secondary').prop('disabled', false);
        $('#sn-start, #sn-end, #btn-generate-sn, #btn-add-sn').prop('disabled', false);
        
        // ========== RESET DROPZONE MESSAGE ==========
        $('#upload-status').html('<span class="badge bg-secondary-transparent text-secondary"><i class="ri-information-line me-1"></i>Select files to preview (will upload when saved)</span>');
    }
}
		/* ========== RENDER ITEMS TABLE ========== */
	  function renderItemsTable() {
    const tbody = document.getElementById('grn-items-tbody');
    if (!tbody) return;
    
    // Use grnItems array from the outer scope
    if (grnItems.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center py-3">No items added yet</td></tr>';
        return;
    }
		
		let html = '';
		grnItems.forEach((item, idx) => {
			const lineTotal = (item.qty || 0) * (item.price || 0);
			
			// Inside renderItemsTable() - replace the indicators section
let indicators = '';

// Show batch/expiry status
if (item.isExpiryTracked) {
    if (item.batch && item.expiry) {
        const batchStatus = item.isExistingBatch ? 'info' : 'success';
        indicators += `<span class="badge bg-${batchStatus}-light text-${batchStatus} ms-1" title="Batch: ${escapeHtml(item.batch)} | Expiry: ${escapeHtml(item.expiry)}">
            <i class="ri-stack-line"></i> Batch ✓
        </span>`;
    } else {
        indicators += `<span class="badge bg-warning-light text-warning ms-1" title="Batch number and expiry date required">
            <i class="ri-alert-line"></i> Batch Pending
        </span>`;
    }
}

// Show serial status
if (item.isSerial) {
    if (item.serialsDone && item.serials && item.serials.length === item.qty) {
        indicators += `<span class="badge bg-success-light text-success ms-1" title="${item.serials.length} serial numbers added">
            <i class="ri-barcode-line"></i> Serial ✓
        </span>`;
    } else {
        indicators += `<span class="badge bg-danger-light text-danger ms-1" title="Click serial button to add ${item.qty} serial numbers">
            <i class="ri-error-warning-line"></i> Serial Pending
        </span>`;
    }
}

// Show imported from PO badge
if (item.importedFromPO) {
    indicators += `<span class="badge bg-info-light text-info ms-1" title="Imported from Purchase Order">
        <i class="ri-file-copy-line"></i> PO
    </span>`;
}
			if (item.isSerial) {
				indicators += `<span class="badge bg-info-light text-info ms-1" title="Serial tracked"><i class="ri-barcode-line"></i> Serial</span>`;
			}
			
			html += `
				<tr data-item-id="${item.id}">
					<td class="text-muted fs-12">${idx + 1}</td>
					<td>
						<div class="fw-semibold fs-13">${escapeHtml(item.name)}</div>
						<div class="fs-11 text-muted">SKU: ${escapeHtml(item.sku || '')} ${indicators}</div>
						${item.batch && item.expiry ? `<div class="fs-10 text-muted mt-1">Batch: ${escapeHtml(item.batch)} | Expiry: ${escapeHtml(item.expiry)}</div>` : ''}
					</td>
					<td><span class="badge bg-light text-dark">${escapeHtml(item.unit || 'pcs')}</span></td>
					<td><input type="number" class="form-control qty-input" value="${item.qty}" min="1" style="width:80px" onchange="updateItemQty(${item.id}, this.value)"></td>
					<td><input type="number" class="form-control qty-input" value="${item.freeQty || 0}" min="0" style="width:80px" onchange="updateItemFreeQty(${item.id}, this.value)"></td>
					<td><input type="number" class="form-control price-input" value="${item.price.toFixed(2)}" step="0.01" style="width:110px" onchange="updateItemPrice(${item.id}, this.value)"></td>
					<td>
						<div class="d-flex gap-1">
							<input type="number" class="form-control discount-input" value="${item.discVal || 0}" min="0" style="width:85px" onchange="updateItemDisc(${item.id}, this.value)">
							<select class="form-select form-select-sm" style="width:60px" onchange="updateItemDiscType(${item.id}, this.value)">
								<option ${item.discType === '%' ? 'selected' : ''}>%</option>
								<option ${item.discType === 'LKR' ? 'selected' : ''}>LKR</option>
							</select>
						</div>
					</td>
					
					<td class="fw-semibold text-end">${fmtLKR(lineTotal)}</td>
					<td>
						<div class="d-flex gap-1">
            ${item.isSerial ? 
                `<button class="btn btn-sm btn-icon ${item.serialsDone ? 'btn-success-light' : 'btn-warning-light'}" 
                    title="${item.serialsDone ? 'View/Edit Serial Numbers' : 'Add Serial Numbers (Required)'}" 
                    onclick="openSerialModal(${item.id})">
                    <i class="ri-barcode-line"></i>
                </button>` : ''
            }
            ${item.isExpiryTracked ? 
                `<button class="btn btn-sm btn-icon ${(item.batch && item.expiry) ? 'btn-info-light' : 'btn-warning-light'}" 
                    title="${(item.batch && item.expiry) ? 'Edit Batch/Expiry' : 'Add Batch & Expiry (Required)'}" 
                    onclick="openBatchModal(${item.id})">
                    <i class="ri-stack-line"></i>
                </button>` : ''
            }
            <button class="btn btn-sm btn-icon btn-danger-light" title="Delete" onclick="deleteItem(${item.id})">
                <i class="ri-delete-bin-5-line"></i>
            </button>
        </div>

					</td>
				</tr>
			`;
		});
		tbody.innerHTML = html;
		updateTotals();
		updateValidationChecklist();
		updateStockImpactPreview();
		fetchCurrentStockForItems();
	}

	// Helper function to show batch info
	window.showBatchInfo = function(itemId) {
		const item = grnItems.find(i => i.id === itemId);
		if (item && item.batch && item.expiry) {
			showToast(`Batch: ${item.batch}\nExpiry: ${item.expiry}`, 'info');
		}
	};
	// Add event listener for global tax rate change
document.getElementById('global-tax-rate')?.addEventListener('change', function() {
    updateTotals();
    updateValidationChecklist();
});
	/* ========== UPDATE STOCK IMPACT PREVIEW ========== */
	function updateStockImpactPreview() {
		const tbody = document.getElementById('stock-summary-body');
		if (!tbody) return;
		
		if (grnItems.length === 0) {
			tbody.innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted">No items added</td></tr>';
			return;
		}
		
		let html = '';
		
		// Process each item
		grnItems.forEach(item => {
			const productId = item.productId;
			const product = productsById[productId];
			
			if (!product) return;
			
			const incomingQty = (item.qty || 0) + (item.freeQty || 0);
			const currentStock = item.currentStock || 0;
			const afterStock = currentStock + incomingQty;
			
			html += `
				<tr>
					<td class="fw-semibold">${escapeHtml(item.name)}</td>
					<td class="text-center">${currentStock} ${item.unit || 'pcs'}</td>
					<td class="text-center text-success">+${incomingQty} ${item.unit || 'pcs'}</td>
					<td class="text-center fw-semibold ${afterStock > currentStock ? 'text-success' : ''}">${afterStock} ${item.unit || 'pcs'}</td>
				</tr>
			`;
		});
		
		tbody.innerHTML = html;
	}

	/* ========== FETCH CURRENT STOCK FOR PRODUCTS ========== */
	function fetchCurrentStockForItems() {
		if (grnItems.length === 0) return;
		
		// Get unique product IDs
		const productIds = [...new Set(grnItems.map(item => item.productId))];
		
		// Fetch stock for each product
		productIds.forEach(productId => {
			fetch('<?php echo site_url("Grn/getProductDetails"); ?>', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: 'product_id=' + encodeURIComponent(productId),
				credentials: 'same-origin'
			})
			.then(response => response.json())
			.then(data => {
				if (data.status) {
					// Update current stock for all items with this product ID
					grnItems.forEach(item => {
						if (item.productId === productId) {
							item.currentStock = data.stock || 0;
							item.unit = data.unit || 'pcs';
						}
					});
					updateStockImpactPreview();
				}
			})
			.catch(error => {
				console.error('Error fetching stock for product:', productId, error);
			});
		});
	}
    function updateTotals() {
    let subtotal = 0, totalDisc = 0;
    
    grnItems.forEach(item => {
        const lineValue = (item.qty || 0) * (item.price || 0);
        let disc = 0;
        if (item.discType === '%') disc = lineValue * ((item.discVal || 0) / 100);
        else disc = Math.min(item.discVal || 0, lineValue);
        subtotal += lineValue;
        totalDisc += disc;
    });
    
    const billDiscVal = parseFloat(document.getElementById('bill-discount-val')?.value || 0);
    const billDiscType = document.getElementById('bill-discount-type')?.value;
    let billDisc = 0;
    const afterLineDisc = subtotal - totalDisc;
    if (billDiscType === '%') billDisc = afterLineDisc * (billDiscVal / 100);
    else billDisc = Math.min(billDiscVal, afterLineDisc);
    
    const afterBillDisc = afterLineDisc - billDisc;
    
    // Get global tax rate
    const globalTaxRate = parseFloat(document.getElementById('global-tax-rate')?.value || 0);
    const taxAmount = afterBillDisc * (globalTaxRate / 100);
    const grandTotal = afterBillDisc + taxAmount;
    
    document.getElementById('tot-subtotal').textContent = fmtLKR(subtotal);
    document.getElementById('tot-line-disc').textContent = '- ' + fmtLKR(totalDisc);
    document.getElementById('tot-bill-disc').textContent = '- ' + fmtLKR(billDisc);
    document.getElementById('tot-tax-amount').textContent = '+ ' + fmtLKR(taxAmount);
    document.getElementById('tot-grand').textContent = fmtLKR(grandTotal);
    
    // Update summary totals
    document.getElementById('summary-total-items').textContent = grnItems.length;
    document.getElementById('summary-grand-total').textContent = fmtLKR(grandTotal);
}

    function updateValidationChecklist() {
        const supplierValid = !!document.getElementById('grn-supplier').value;
        const warehouseValid = !!document.getElementById('grn-warehouse').value;
        const dateValid = !!document.getElementById('grn-date').value;
        const receivedValid = !!document.getElementById('grn-received-by').value;
        const hasItems = grnItems.length > 0;
        const allQtyValid = hasItems ? grnItems.every(i => (i.qty || 0) > 0) : false;
        const serialsValid = grnItems.filter(i => i.isSerial).every(i => i.serialsDone);
        
        const checks = { supplier: supplierValid, warehouse: warehouseValid, date: dateValid, 'received-by': receivedValid, items: hasItems, quantities: allQtyValid, serials: serialsValid };
        Object.keys(checks).forEach(key => {
            const li = document.querySelector(`[data-check="${key}"]`);
            if (li) {
                const text = li.querySelector('span')?.textContent || key;
                li.innerHTML = checks[key] ? `<i class="ri-checkbox-circle-fill text-success"></i><span>${text}</span>` : `<i class="ri-error-warning-fill text-warning"></i><span>${text}</span>`;
            }
        });
    }

    /* ========== ITEM MUTATORS ========== */
    window.updateItemQty = (id, val) => { const item = grnItems.find(i => i.id === id); if (item) { item.qty = Math.max(1, parseInt(val) || 1); renderItemsTable(); } };
    window.updateItemFreeQty = (id, val) => { const item = grnItems.find(i => i.id === id); if (item) { item.freeQty = Math.max(0, parseInt(val) || 0); renderItemsTable(); } };
    window.updateItemPrice = (id, val) => { const item = grnItems.find(i => i.id === id); if (item) { item.price = Math.max(0, parseFloat(val) || 0); renderItemsTable(); } };
    window.updateItemDisc = (id, val) => { const item = grnItems.find(i => i.id === id); if (item) { item.discVal = Math.max(0, parseFloat(val) || 0); renderItemsTable(); } };
    window.updateItemDiscType = (id, val) => { const item = grnItems.find(i => i.id === id); if (item) { item.discType = val; renderItemsTable(); } };
    window.updateItemTax = (id, val) => { const item = grnItems.find(i => i.id === id); if (item) { const [name, rate] = val.split(':'); item.tax = name; item.taxRate = parseFloat(rate) || 0; renderItemsTable(); } };
    window.deleteItem = (id) => { if (confirm('Remove this item?')) { grnItems = grnItems.filter(i => i.id !== id); renderItemsTable(); } };

    /* ========== SERIAL NUMBER MODAL ========== */
    window.openSerialModal = function(itemId) {
    const item = grnItems.find(i => i.id === itemId);
    if (!item) { 
        showToast('Item not found', 'danger'); 
        return; 
    }
    
    currentSerialItem = item;
    
    // Update modal title
    const modalTitle = document.querySelector('#modalSerialNumbers .modal-title');
    if (modalTitle) {
        modalTitle.innerHTML = `<i class="ri-barcode-line me-2 text-info"></i>Serial Numbers - ${escapeHtml(item.name)}`;
    }
    
    // Update product name and required quantity in the alert
    const productNameSpan = document.getElementById('serial-product-name');
    const requiredQtySpan = document.getElementById('serial-required-qty');
    
    if (productNameSpan) {
        productNameSpan.textContent = item.name;
    }
    if (requiredQtySpan) {
        requiredQtySpan.textContent = `${item.qty} serial numbers`;
    }
    
    // Initialize serial numbers array
    serialNumbersArray = item.serials && item.serials.length ? [...item.serials] : Array(item.qty).fill('');
    renderSerialList();
    
    const modal = new bootstrap.Modal(document.getElementById('modalSerialNumbers'));
    modal.show();
};
/* ========== REJECT GRN HANDLER ========== */
function rejectGRN() {
    // Use global variable first, then fallback to IIFE variable
    const grnId = window.currentGRNIdGlobal || currentGRNId;
    const reason = $('#reject-reason').val().trim();
    
    console.log('rejectGRN - grnId:', grnId);
    
    if (!reason) {
        showToast('Please enter a rejection reason', 'warning');
        return;
    }
    
    if (!grnId) {
        showToast('No GRN selected', 'danger');
        return;
    }
    
    // Show loading state
    const rejectBtn = $('#confirm-reject-btn');
    const originalText = rejectBtn.html();
    rejectBtn.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin me-1"></i> Rejecting...');
    
    $.ajax({
        url: '<?php echo site_url("Grn/reject/"); ?>' + grnId,
        type: 'POST',
        data: { note: reason },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                showToast('GRN rejected successfully', 'success');
                $('#modalReject').modal('hide');
                $('#reject-reason').val('');
                
                // Reload page after short delay
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                showToast(response.msg || 'Failed to reject GRN', 'danger');
            }
        },
        error: function(xhr, status, error) {
            console.error('Reject error:', error);
            showToast('Error rejecting GRN: ' + error, 'danger');
        },
        complete: function() {
            rejectBtn.prop('disabled', false).html(originalText);
        }
    });
}

/* ========== APPROVE GRN HANDLER ========== */
function approveGRN() {
    // Use global variable first, then fallback to IIFE variable
    const grnId = window.currentGRNIdGlobal || currentGRNId;
    
    console.log('approveGRN - grnId:', grnId);
    
    if (!grnId) {
        showToast('No GRN selected', 'danger');
        return;
    }
    
    // Show loading state
    const approveBtn = $('#confirm-approve-btn');
    const originalText = approveBtn.html();
    approveBtn.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin me-1"></i> Approving...');
    
    $.ajax({
        url: '<?php echo site_url("Grn/approve/"); ?>' + grnId,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                showToast('GRN approved and stock updated successfully', 'success');
                $('#modalApprove').modal('hide');
                
                // Reload page after short delay
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                showToast(response.msg || 'Failed to approve GRN', 'danger');
            }
        },
        error: function(xhr, status, error) {
            console.error('Approve error:', error);
            let errorMsg = 'Error approving GRN';
            if (xhr.responseJSON && xhr.responseJSON.msg) {
                errorMsg = xhr.responseJSON.msg;
            }
            showToast(errorMsg, 'danger');
        },
        complete: function() {
            approveBtn.prop('disabled', false).html(originalText);
        }
    });
}

/* ========== POPULATE APPROVE MODAL WITH GRN DATA ========== */
function populateApproveModal() {
    // Use global variable first, then fallback to IIFE variable
    const grnId = window.currentGRNIdGlobal || currentGRNId;
    
    console.log('populateApproveModal - grnId:', grnId);
    
    if (!grnId) return;
    
    // Get GRN details for the modal
    $.ajax({
        url: '<?php echo site_url("Grn/getGRNSummary/"); ?>' + grnId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success' && response.data) {
                const data = response.data;
                $('#approve-grn-number').text(data.grn_number || '--');
                $('#approve-supplier').text(data.supplier_name || '--');
                $('#approve-warehouse').text(data.warehouse_name || '--');
                $('#approve-grand-total').text(fmtLKR(data.grand_total || 0));
                $('#approve-total-items').text(data.total_items + ' products, ' + data.total_qty + ' units');
            }
        },
        error: function(error) {
            console.error('Error loading GRN summary for modal:', error);
        }
    });
}
/* ========== RESET REJECT MODAL ========== */
function resetRejectModal() {
    $('#reject-reason').val('');
}

/* ========== INITIALIZE MODAL HANDLERS ========== */
function initModalHandlers() {
    // Approve button click
    $('#btn-approve').on('click', function() {
        const grnId = window.currentGRNIdGlobal || currentGRNId;
        const grnStatus = window.currentGRNStatusGlobal || currentGRNStatus;
        
        console.log('Approve button clicked - GRN ID:', grnId, 'Status:', grnStatus);
        
        if (!grnId) {
            showToast('No GRN loaded', 'warning');
            return;
        }
        
        // Check if GRN is in submittable status
        if (grnStatus !== 'submitted') {
            showToast('GRN must be submitted before approval. Current status: ' + grnStatus, 'warning');
            return;
        }
        
        // Populate modal with data
        populateApproveModal();
        
        // Show modal
        $('#modalApprove').modal('show');
    });
    
    // Confirm approve button
    $('#confirm-approve-btn').on('click', function() {
        approveGRN();
    });
    
    // Reject button click
    $('#btn-reject').on('click', function() {
        const grnId = window.currentGRNIdGlobal || currentGRNId;
        const grnStatus = window.currentGRNStatusGlobal || currentGRNStatus;
        
        console.log('Reject button clicked - GRN ID:', grnId, 'Status:', grnStatus);
        
        if (!grnId) {
            showToast('No GRN loaded', 'warning');
            return;
        }
        
        // Check if GRN is in submittable status
        if (grnStatus !== 'submitted') {
            showToast('GRN must be submitted before rejection. Current status: ' + grnStatus, 'warning');
            return;
        }
        
        // Reset and show modal
        resetRejectModal();
        $('#modalReject').modal('show');
    });
    
    // Confirm reject button
    $('#confirm-reject-btn').on('click', function() {
        rejectGRN();
    });
    
    // Clear reject reason when modal is closed
    $('#modalReject').on('hidden.bs.modal', function() {
        resetRejectModal();
    });
    
    // Modal focus fix (prevents aria-hidden warning)
    $('#modalApprove, #modalReject').on('shown.bs.modal', function() {
        $(this).removeAttr('aria-hidden');
    });
    
    $('#modalApprove, #modalReject').on('hidden.bs.modal', function() {
        $(this).attr('aria-hidden', 'true');
        // Return focus to the button that opened the modal
        if ($(this).attr('id') === 'modalApprove') {
            $('#btn-approve').focus();
        } else {
            $('#btn-reject').focus();
        }
    });
}

// Call this when document is ready
$(document).ready(function() {
    initModalHandlers();
});
    function renderSerialList() {
        const container = document.getElementById('sn-list');
        if (!container) return;
        
        let html = '';
        serialNumbersArray.forEach((serial, idx) => {
            html += `
                <div class="serial-list-item">
                    <span class="sn-idx">${idx + 1}</span>
                    <input type="text" class="form-control form-control-sm border-0 sn-input" value="${escapeHtml(serial)}" placeholder="Enter serial number" onchange="updateSerialNumber(${idx}, this.value)">
                    <button class="btn btn-sm btn-icon text-danger border-0 bg-transparent" onclick="removeSerialNumber(${idx})"><i class="ri-close-line"></i></button>
                </div>
            `;
        });
        container.innerHTML = html;
        updateSerialCount();
    }

    window.updateSerialNumber = (idx, val) => { if (idx >= 0 && idx < serialNumbersArray.length) { serialNumbersArray[idx] = val.trim(); updateSerialCount(); } };
    window.removeSerialNumber = (idx) => { serialNumbersArray.splice(idx, 1); renderSerialList(); };
    window.addSerialRow = () => { serialNumbersArray.push(''); renderSerialList(); };
    
    window.generateSerialNumbers = () => {
        const start = document.getElementById('sn-start').value.trim();
        const end = document.getElementById('sn-end').value.trim();
        const required = currentSerialItem ? currentSerialItem.qty : 5;
        if (!start || !end) { showToast('Please enter start and end serial numbers', 'warning'); return; }
        
        const startMatch = start.match(/^([A-Za-z]*)(\d+)$/);
        const endMatch = end.match(/^([A-Za-z]*)(\d+)$/);
        if (!startMatch || !endMatch) { showToast('Invalid format. Use like SN1001', 'warning'); return; }
        
        const prefix = startMatch[1];
        const startNum = parseInt(startMatch[2]);
        const endNum = parseInt(endMatch[2]);
        if (startNum > endNum) { showToast('End must be greater than start', 'warning'); return; }
        
        const count = endNum - startNum + 1;
        if (count < required) { showToast(`Need ${required} serials, only ${count} generated`, 'warning'); return; }
        
        const timestamp = Date.now();
        const generated = [];
        for (let i = 0; i < required; i++) {
            generated.push(`${prefix}${currentSerialItem.productId}-${timestamp}-${startNum + i}`);
        }
        serialNumbersArray = generated;
        renderSerialList();
        showToast(`${required} unique serial numbers generated`, 'success');
    };
    
    function updateSerialCount() {
        const required = currentSerialItem ? currentSerialItem.qty : 0;
        const entered = serialNumbersArray.filter(s => s && s.trim() !== '').length;
        const el = document.getElementById('sn-count');
        if (el) {
            el.textContent = `${entered} / ${required}`;
            el.className = entered === required ? 'text-success fw-semibold' : (entered > required ? 'text-danger fw-semibold' : 'text-warning fw-semibold');
        }
    }
    
    function saveSerialNumbersToServer() {
    if (!currentSerialItem) {
        showToast('No item selected', 'warning');
        return Promise.reject('No item selected');
    }
    
    const validSerials = serialNumbersArray.filter(s => s && s.trim() !== '');
    const required = currentSerialItem.qty;
    
    if (validSerials.length !== required) {
        showToast(`Please enter ${required} serial numbers (${validSerials.length} entered)`, 'warning');
        return Promise.reject('Incomplete serials');
    }
    
    // Check for duplicates
    const duplicates = validSerials.filter((s, i) => validSerials.indexOf(s) !== i);
    if (duplicates.length) {
        showToast(`Duplicate serials: ${duplicates.join(', ')}`, 'danger');
        return Promise.reject('Duplicate serials');
    }
    
    // SAVE TO MEMORY ONLY
    const itemIndex = grnItems.findIndex(i => i.id === currentSerialItem.id);
    if (itemIndex !== -1) {
        grnItems[itemIndex].serials = validSerials;
        grnItems[itemIndex].serialsDone = true;
        grnItems[itemIndex].isSerial = true;
    }
    
    showToast(`${validSerials.length} serial numbers saved for ${currentSerialItem.name}`, 'success');
    
    // Close modal
    const modalElement = document.getElementById('modalSerialNumbers');
    const modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) modal.hide();
    
    setTimeout(() => {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
    }, 150);
    
    renderItemsTable();
    updateValidationChecklist();
    
    return Promise.resolve({ status: 'success' });
}

	// Add event listener for modal hidden event to clean up
	document.getElementById('modalSerialNumbers')?.addEventListener('hidden.bs.modal', function() {
		// Remove any lingering backdrops
		const backdrops = document.querySelectorAll('.modal-backdrop');
		backdrops.forEach(backdrop => backdrop.remove());
		document.body.classList.remove('modal-open');
		document.body.style.overflow = '';
		document.body.style.paddingRight = '';
		
		// Reset serial numbers array
		serialNumbersArray = [];
		currentSerialItem = null;
	});

	// Also fix the Cancel button in serial modal
	document.querySelector('#modalSerialNumbers .btn-secondary')?.addEventListener('click', function() {
		const modalElement = document.getElementById('modalSerialNumbers');
		const modal = bootstrap.Modal.getInstance(modalElement);
		if (modal) {
			modal.hide();
		}
		
		// Remove backdrop
		setTimeout(() => {
			const backdrops = document.querySelectorAll('.modal-backdrop');
			backdrops.forEach(backdrop => backdrop.remove());
			document.body.classList.remove('modal-open');
			document.body.style.overflow = '';
			document.body.style.paddingRight = '';
		}, 150);
	});

	/* ========== CLOSE ALL MODALS ========== */
	function closeAllModals() {
		const modals = document.querySelectorAll('.modal.show');
		modals.forEach(modal => {
			const bsModal = bootstrap.Modal.getInstance(modal);
			if (bsModal) {
				bsModal.hide();
			}
		});
		
		// Remove all backdrops
		const backdrops = document.querySelectorAll('.modal-backdrop');
		backdrops.forEach(backdrop => backdrop.remove());
		
		// Reset body styles
		document.body.classList.remove('modal-open');
		document.body.style.overflow = '';
		document.body.style.paddingRight = '';
	}
	/* ========== PAYMENT FUNCTIONS (AFTER APPROVAL) ========== */

// Load payment summary and history (only for approved GRNs)
function loadPaymentData(grnId) {
    if (!grnId) return;
    
    // Load payment summary
    fetch(baseUrl + 'Grn/getGRNPaymentSummary/' + grnId, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' && data.data) {
            const summary = data.data;
            
            // Update payment summary display
            document.getElementById('payment-grand-total').textContent = fmtLKR(summary.grand_total);
            document.getElementById('payment-paid-amount').textContent = fmtLKR(summary.paid_amount);
            document.getElementById('payment-balance').textContent = fmtLKR(summary.balance_amount);
            
            // Update progress bar
            const percentage = summary.grand_total > 0 ? (summary.paid_amount / summary.grand_total) * 100 : 0;
            document.getElementById('payment-progress').style.width = percentage + '%';
            document.getElementById('payment-percentage').textContent = percentage.toFixed(1) + '%';
            
            // Update status badge
            const statusBadge = document.getElementById('payment-status-badge');
            if (summary.balance_amount <= 0) {
                statusBadge.innerHTML = '<span class="badge bg-success">Fully Paid</span>';
                $('#btn-record-payment-modal').hide();
            } else if (summary.paid_amount > 0) {
                statusBadge.innerHTML = '<span class="badge bg-warning">Partial Payment</span>';
                $('#btn-record-payment-modal').show();
            } else {
                statusBadge.innerHTML = '<span class="badge bg-danger">Unpaid</span>';
                $('#btn-record-payment-modal').show();
            }
            
            // Show invoice link if exists
            if (summary.invoice_linked && summary.invoice_id) {
                $('#invoice-link-container').show();
                $('#linked-invoice-number').text(summary.invoice_id);
            }
        }
    })
    .catch(error => console.error('Error loading payment summary:', error));
    
    // Load payment history
    loadPaymentHistory(grnId);
}

// Load payment history
function loadPaymentHistory(grnId) {
    fetch(baseUrl + 'Grn/getGRNPayments/' + grnId, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('payment-history-container');
        if (!container) return;
        
        if (data.status === 'success' && data.data && data.data.length > 0) {
            let html = '<div class="list-group list-group-flush">';
            
            data.data.forEach(payment => {
                const methodIcon = payment.payment_method === 'cash' ? 'ri-money-cny-circle-line' :
                                  (payment.payment_method === 'transfer' ? 'ri-bank-line' : 'ri-survey-line');
                const methodColor = payment.payment_method === 'cash' ? 'success' :
                                   (payment.payment_method === 'transfer' ? 'info' : 'warning');
                
                html += `
                    <div class="list-group-item px-3 py-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <i class="${methodIcon} text-${methodColor} me-1"></i>
                                <strong class="fs-12">${fmtLKR(payment.allocated_amount || payment.amount)}</strong>
                                <div class="fs-11 text-muted mt-1">
                                    <i class="ri-calendar-line me-1"></i>${payment.payment_date}
                                </div>
                            </div>
                            <span class="badge bg-${methodColor}-light text-${methodColor} text-uppercase fs-10">
                                ${payment.payment_method}
                            </span>
                        </div>
                        ${payment.reference_no ? `<div class="fs-11 text-muted mt-1">Ref: ${escapeHtml(payment.reference_no)}</div>` : ''}
                        ${payment.cheque_no ? `<div class="fs-11 text-muted">Chq: ${escapeHtml(payment.cheque_no)}</div>` : ''}
                        ${payment.note ? `<div class="fs-11 text-muted mt-1">${escapeHtml(payment.note)}</div>` : ''}
                        <div class="fs-10 text-muted mt-1">by ${escapeHtml(payment.created_by_name || 'System')} on ${new Date(payment.created_at).toLocaleDateString()}</div>
                    </div>
                `;
            });
            
            html += '</div>';
            container.innerHTML = html;
        } else {
            container.innerHTML = '<div class="text-center py-3 text-muted fs-12"><i class="ri-information-line me-1"></i>No payments recorded yet</div>';
        }
    })
    .catch(error => console.error('Error loading payment history:', error));
}

// Record payment
function recordPayment() {
    const grnId = currentGRNId;
    if (!grnId) {
        showToast('No GRN selected', 'warning');
        return;
    }
    
    const method = document.getElementById('payment-method').value;
    if (!method) {
        showToast('Please select payment method', 'warning');
        return;
    }
    
    const paymentDate = document.getElementById('payment-date').value;
    if (!paymentDate) {
        showToast('Payment date is required', 'warning');
        return;
    }
    
    let referenceNo = null;
    let chequeNo = null;
    let chequeDate = null;
    let bankName = null;
    
    if (method === 'transfer') {
        referenceNo = document.getElementById('transfer-ref').value || null;
        bankName = document.getElementById('transfer-bank').value || null;
    } else if (method === 'cheque') {
        chequeNo = document.getElementById('cheque-no').value;
        chequeDate = document.getElementById('cheque-date').value || null;
        bankName = document.getElementById('cheque-bank').value || null;
        if (!chequeNo) {
            showToast('Cheque number is required', 'warning');
            return;
        }
    }
    
    const amount = parseFloat(document.getElementById('payment-amount').value);
    if (isNaN(amount) || amount <= 0) {
        showToast('Please enter a valid amount', 'warning');
        return;
    }
    
    // Check if amount exceeds balance
    const balanceSpan = document.getElementById('payment-balance');
    const balanceText = balanceSpan ? balanceSpan.textContent : 'LKR 0.00';
    const balance = parseFloat(balanceText.replace('LKR', '').replace(/,/g, '')) || 0;
    
    if (amount > balance) {
        showToast(`Payment amount (${fmtLKR(amount)}) exceeds balance due (${fmtLKR(balance)})`, 'warning');
        return;
    }
    
    const note = document.getElementById('payment-note').value || null;
    
    const payload = {
        grn_id: grnId,
        payment_method: method,
        payment_date: paymentDate,
        amount: amount,
        reference_no: referenceNo,
        cheque_no: chequeNo,
        cheque_date: chequeDate,
        bank_name: bankName,
        note: note
    };
    
    // Show loading state
    const recordBtn = document.getElementById('btn-record-payment');
    const originalText = recordBtn.innerHTML;
    recordBtn.disabled = true;
    recordBtn.innerHTML = '<i class="ri-loader-4-line ri-spin me-1"></i> Processing...';
    
    fetch(baseUrl + 'Grn/recordPayment', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showToast('Payment recorded successfully', 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalRecordPayment'));
            if (modal) modal.hide();
            
            // Reset form
            resetPaymentForm();
            
            // Reload payment data
            loadPaymentData(currentGRNId);
            
            // Also reload main GRN to update status
            if (typeof loadGRNDataById === 'function') {
                loadGRNDataById(currentGRNId);
            }
        } else {
            showToast(data.msg || 'Failed to record payment', 'danger');
        }
    })
    .catch(error => {
        console.error('Payment error:', error);
        showToast('Error recording payment', 'danger');
    })
    .finally(() => {
        recordBtn.disabled = false;
        recordBtn.innerHTML = originalText;
    });
}

// Reset payment form
function resetPaymentForm() {
    document.getElementById('payment-method').value = '';
    document.getElementById('payment-date').value = new Date().toISOString().split('T')[0];
    document.getElementById('payment-amount').value = '';
    document.getElementById('payment-note').value = '';
    
    // Transfer fields
    document.getElementById('transfer-ref').value = '';
    document.getElementById('transfer-bank').value = '';
    
    // Cheque fields
    document.getElementById('cheque-no').value = '';
    document.getElementById('cheque-date').value = '';
    document.getElementById('cheque-bank').value = '';
    
    // Hide all field groups
    document.getElementById('transfer-fields').style.display = 'none';
    document.getElementById('cheque-fields').style.display = 'none';
}

// Initialize payment modal event handlers
function initPaymentModal() {
    // Payment method change
    document.getElementById('payment-method')?.addEventListener('change', function() {
        const method = this.value;
        
        document.getElementById('transfer-fields').style.display = 'none';
        document.getElementById('cheque-fields').style.display = 'none';
        
        if (method === 'transfer') {
            document.getElementById('transfer-fields').style.display = 'block';
        } else if (method === 'cheque') {
            document.getElementById('cheque-fields').style.display = 'block';
        }
    });
    
    // Record payment button
    document.getElementById('btn-record-payment')?.addEventListener('click', recordPayment);
    
    // Open payment modal button
    document.getElementById('btn-record-payment-modal')?.addEventListener('click', function() {
        const balanceSpan = document.getElementById('payment-balance');
        const balanceText = balanceSpan ? balanceSpan.textContent : 'LKR 0.00';
        const balanceAmount = parseFloat(balanceText.replace('LKR', '').replace(/,/g, '')) || 0;
        
        if (balanceAmount <= 0) {
            showToast('This GRN is already fully paid', 'warning');
            return;
        }
        
        // Set GRN number and balance in modal
        const grnNumber = document.getElementById('hidden-grn-number')?.value || '--';
        document.getElementById('payment-grn-number').textContent = grnNumber;
        document.getElementById('payment-balance-due').textContent = fmtLKR(balanceAmount);
        
        // Reset form
        resetPaymentForm();
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('modalRecordPayment'));
        modal.show();
    });
}
		/* ========== PURCHASE ORDER IMPORT FUNCTIONS ========== */

	// Load Purchase Orders
	function loadPurchaseOrders() {
		const supplierId = document.getElementById('po-filter-supplier').value;
		const dateFrom = document.getElementById('po-filter-date-from').value;
		const dateTo = document.getElementById('po-filter-date-to').value;
		
		const tbody = document.getElementById('po-list-body');
		if (!tbody) return;
		
		// Show loading
		tbody.innerHTML = `
			<tr>
				<td colspan="7" class="text-center py-4 text-muted">
					<div class="spinner-border spinner-border-sm me-2" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
					Loading purchase orders...
				</td>
			</tr>
		`;
		
		let url = '<?php echo site_url("Grn/getPurchaseOrders"); ?>';
		const params = new URLSearchParams();
		if (supplierId) params.append('supplier_id', supplierId);
		if (dateFrom) params.append('date_from', dateFrom);
		if (dateTo) params.append('date_to', dateTo);
		
		if (params.toString()) {
			url += '?' + params.toString();
		}
		
		fetch(url, {
			method: 'GET',
			credentials: 'same-origin',
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === 'success' && data.data && data.data.length > 0) {
				let html = '';
				data.data.forEach(po => {
					html += `
						<tr class="po-table-row" data-po-id="${po.id}" data-po-number="${po.po_number}">
							<td class="text-center">
								<input type="radio" name="selected-po" value="${po.id}" class="form-check-input">
							</td>
							<td class="fw-semibold">${escapeHtml(po.po_number)}</td>
							<td>${escapeHtml(po.supplier_name || 'N/A')}</td>
							<td>${po.order_date ? new Date(po.order_date).toLocaleDateString() : 'N/A'}</td>
							<td class="text-center">${po.item_count || 0}</td>
							<td class="text-end">${fmtLKR(po.total_amount || 0)}</td>
							<td><span class="badge bg-${po.status === 'approved' ? 'success' : (po.status === 'pending' ? 'warning' : 'secondary')}">${escapeHtml(po.status || 'N/A')}</span></td>
						</tr>
					`;
				});
				tbody.innerHTML = html;
				
				// Add click handlers
				document.querySelectorAll('.po-table-row').forEach(row => {
					row.addEventListener('click', function(e) {
						if (e.target.type !== 'radio') {
							const radio = this.querySelector('input[type="radio"]');
							if (radio) radio.checked = true;
							loadPurchaseOrderItems(this.dataset.poId);
						}
					});
					
					const radio = row.querySelector('input[type="radio"]');
					if (radio) {
						radio.addEventListener('change', function() {
							if (this.checked) {
								loadPurchaseOrderItems(row.dataset.poId);
							}
						});
					}
				});
			} else {
				tbody.innerHTML = `
					<tr>
						<td colspan="7" class="text-center py-4 text-muted">
							<i class="ri-file-copy-line fs-3 mb-2 d-block"></i>
							No purchase orders found
						</td>
					</tr>
				`;
			}
		})
		.catch(error => {
			console.error('Error loading purchase orders:', error);
			tbody.innerHTML = `
				<tr>
					<td colspan="7" class="text-center py-4 text-danger">
						<i class="ri-error-warning-line me-1"></i>
						Failed to load purchase orders
					</td>
				</tr>
			`;
		});
	}

	// Load Purchase Order Items
	let currentSelectedPO = null;

	function loadPurchaseOrderItems(poId) {
		if (!poId) return;
		
		const previewDiv = document.getElementById('po-items-preview');
		const itemsBody = document.getElementById('po-items-body');
		const poNumberSpan = document.getElementById('selected-po-number');
		const itemsCountSpan = document.getElementById('po-items-count');
		const importBtn = document.getElementById('btn-import-selected');
		
		if (!previewDiv || !itemsBody) return;
		
		// Show loading
		previewDiv.style.display = 'block';
		itemsBody.innerHTML = `
			<tr>
				<td colspan="8" class="text-center py-3">
					<div class="spinner-border spinner-border-sm me-2" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
					Loading items...
				</td>
			</tr>
		`;
		
		fetch('<?php echo site_url("Grn/getPurchaseOrder/"); ?>' + poId, {
			method: 'GET',
			credentials: 'same-origin',
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === 'success' && data.data) {
				const po = data.data;
				currentSelectedPO = po;
				
				poNumberSpan.textContent = po.po_number || 'PO-' + poId;
				
				if (po.items && po.items.length > 0) {
					itemsCountSpan.textContent = po.items.length + ' items';
					let html = '';
					
					po.items.forEach((item, idx) => {
						const lineTotal = (item.quantity || 0) * (item.unit_price || 0);
						html += `
							<tr>
								<td class="text-center">
									<input type="checkbox" class="form-check-input po-item-checkbox" data-item-index="${idx}" checked>
								</td>
								<td>
									<div class="fw-semibold fs-12">${escapeHtml(item.product_name || 'Unknown')}</div>
									<div class="text-muted fs-10">Code: ${escapeHtml(item.product_code || 'N/A')}</div>
								</td>
								<td>${escapeHtml(item.unit_name || 'pcs')}</td>
								<td class="text-center">${item.quantity || 0}</td>
								<td class="text-center">0</td>
								<td class="text-center text-warning">${item.quantity || 0}</td>
								<td class="text-end">${fmtLKR(item.unit_price || 0)}</td>
								<td class="text-end">${fmtLKR(lineTotal)}</td>
							</tr>
						`;
					});
					
					itemsBody.innerHTML = html;
					importBtn.disabled = false;
					
					// Add select all functionality
					const selectAllCheckbox = document.getElementById('select-all-po-items');
					if (selectAllCheckbox) {
						selectAllCheckbox.checked = true;
						selectAllCheckbox.onchange = function() {
							document.querySelectorAll('.po-item-checkbox').forEach(cb => {
								cb.checked = this.checked;
							});
						};
					}
				} else {
					itemsBody.innerHTML = `
						<tr>
							<td colspan="8" class="text-center py-3 text-muted">
								No items found in this purchase order
							</td>
						</tr>
					`;
					itemsCountSpan.textContent = '0 items';
					importBtn.disabled = true;
				}
			} else {
				itemsBody.innerHTML = `
					<tr>
						<td colspan="8" class="text-center py-3 text-danger">
							Failed to load PO items
						</td>
					</tr>
				`;
				importBtn.disabled = true;
			}
		})
		.catch(error => {
			console.error('Error loading PO items:', error);
			itemsBody.innerHTML = `
				<tr>
					<td colspan="8" class="text-center py-3 text-danger">
						Error loading items
					</td>
				</tr>
			`;
			importBtn.disabled = true;
		});
	}
	/* ========== CHECK IF BATCH EXISTS ========== */
	function checkBatchExists(productId, batchNumber, warehouseId) {
		return fetch('<?php echo site_url("Grn/checkBatchExists"); ?>', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: 'product_id=' + productId + '&batch_number=' + encodeURIComponent(batchNumber) + '&warehouse_id=' + warehouseId,
			credentials: 'same-origin'
		})
		.then(response => response.json())
		.then(data => {
			return data.exists;
		});
	}
	// Import Selected Items from PO
function importSelectedPOItems() {
    if (!currentSelectedPO) {
        showToast('No purchase order selected', 'warning');
        return;
    }
    
    const selectedCheckboxes = document.querySelectorAll('.po-item-checkbox:checked');
    if (selectedCheckboxes.length === 0) {
        showToast('No items selected for import', 'warning');
        return;
    }
    
    // Get selected items
    const selectedItems = [];
    selectedCheckboxes.forEach(cb => {
        const index = parseInt(cb.dataset.itemIndex);
        if (currentSelectedPO.items && currentSelectedPO.items[index]) {
            selectedItems.push(currentSelectedPO.items[index]);
        }
    });
    
    if (selectedItems.length === 0) {
        showToast('No valid items selected', 'warning');
        return;
    }
    
    // IMPORT ALL ITEMS FIRST (no tracking check yet)
    let importedCount = 0;
    let serialItemsCount = 0;
    let expiryItemsCount = 0;
    
    selectedItems.forEach(item => {
        const productExists = productsById[item.product_id];
        
        // Check if product already exists in GRN
        const existingItem = grnItems.find(i => i.productId === item.product_id);
        if (existingItem) {
            showToast(`Product "${item.product_name}" already exists. Skipping duplicate.`, 'info');
            return;
        }
        
        // Determine tracking requirements from PO item data
        const needsExpiry = item.is_expiry_trk === true || item.is_expiry_trk === 1;
        const needsSerial = item.is_serial_trk === true || item.is_serial_trk === 1;
        
        // Create new item with tracking flags
        const newItem = {
            id: nextItemId++,
            productId: item.product_id,
            name: item.product_name,
            sku: item.product_code || '',
            unit: item.unit_name || 'pcs',
            qty: parseFloat(item.quantity) || 0,
            freeQty: 0,
            price: parseFloat(item.unit_price) || 0,
            discVal: 0,
            discType: 'LKR',
            tax: 'No Tax',
            taxRate: 0,
            batch: '',
            expiry: '',
            isSerial: needsSerial,
            serialsDone: !needsSerial,  // False if serials needed
            serials: [],
            isExpiryTracked: needsExpiry,
            batchDone: !needsExpiry,    // False if expiry/batch needed
            importedFromPO: true,
            poItemId: item.id
        };
        
        grnItems.push(newItem);
        importedCount++;
        
        if (needsSerial) serialItemsCount++;
        if (needsExpiry) expiryItemsCount++;
    });
    
    if (importedCount > 0) {
        renderItemsTable();
        fetchCurrentStockForItems();
        
        // Show summary message
        let message = `${importedCount} item(s) imported successfully.`;
        if (serialItemsCount > 0) {
            message += ` ${serialItemsCount} item(s) require serial numbers. Click the serial button on each row to add them.`;
        }
        if (expiryItemsCount > 0) {
            message += ` ${expiryItemsCount} item(s) require batch/expiry info. Edit each item to add details.`;
        }
        showToast(message, 'success');
        
        // Close modal properly
        const modalElement = document.getElementById('modalImportPO');
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
        
        // Force remove backdrop after modal closes
        setTimeout(() => {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
        }, 150);
        
        // Clear selection
        currentSelectedPO = null;
    } else {
        showToast('No new items were imported', 'info');
    }
}
// Variables for batch modal
let currentBatchItem = null;

// Open batch modal for an item
window.openBatchModal = function(itemId) {
    const item = grnItems.find(i => i.id === itemId);
    if (!item) {
        showToast('Item not found', 'danger');
        return;
    }
    
    currentBatchItem = item;
    
    // Update modal
    document.getElementById('batch-product-name').textContent = item.name;
    document.getElementById('batch-number').value = item.batch || '';
    document.getElementById('expiry-date').value = item.expiry || '';
    
    // Reset warning
    document.getElementById('batch-expiry-warning').style.display = 'none';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('modalBatchExpiry'));
    modal.show();
};

// Save batch info
document.getElementById('save-batch-btn')?.addEventListener('click', function() {
    if (!currentBatchItem) {
        showToast('No item selected', 'warning');
        return;
    }
    
    const batchNumber = document.getElementById('batch-number').value.trim();
    const expiryDate = document.getElementById('expiry-date').value;
    const warehouseId = document.getElementById('grn-warehouse').value;
    
    // Validate
    if (!batchNumber) {
        showToast('Batch number is required', 'warning');
        return;
    }
    
    if (!expiryDate) {
        showToast('Expiry date is required', 'warning');
        return;
    }
    
    // Check expiry date not in past
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const expiry = new Date(expiryDate);
    if (expiry < today) {
        showToast('Expiry date cannot be in the past', 'warning');
        return;
    }
    
    if (!warehouseId) {
        showToast('Please select a warehouse first', 'warning');
        return;
    }
    
    // Show loading
    const saveBtn = this;
    const originalText = saveBtn.innerHTML;
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="ri-loader-4-line ri-spin me-1"></i> Checking...';
    
    // Check if batch exists
    checkBatchExists(currentBatchItem.productId, batchNumber, warehouseId).then(exists => {
        if (exists) {
            // Ask user if they want to add to existing batch
            if (confirm(`Batch number "${batchNumber}" already exists in inventory.\n\nDo you want to add more stock to this existing batch?`)) {
                // Save with existing batch flag
                currentBatchItem.batch = batchNumber;
                currentBatchItem.expiry = expiryDate;
                currentBatchItem.isExistingBatch = true;
                currentBatchItem.batchDone = true;
                
                renderItemsTable();
                showToast(`Batch info saved. Stock will be added to existing batch "${batchNumber}" upon approval.`, 'success');
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalBatchExpiry'));
                if (modal) modal.hide();
            }
        } else {
            // New batch - save normally
            currentBatchItem.batch = batchNumber;
            currentBatchItem.expiry = expiryDate;
            currentBatchItem.isExistingBatch = false;
            currentBatchItem.batchDone = true;
            
            renderItemsTable();
            showToast(`New batch "${batchNumber}" created for ${currentBatchItem.name}`, 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalBatchExpiry'));
            if (modal) modal.hide();
        }
    }).catch(error => {
        console.error('Error checking batch:', error);
        showToast('Error checking batch number. Please try again.', 'danger');
    }).finally(() => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
    });
});

// Clear batch modal on close
document.getElementById('modalBatchExpiry')?.addEventListener('hidden.bs.modal', function() {
    currentBatchItem = null;
    document.getElementById('batch-number').value = '';
    document.getElementById('expiry-date').value = '';
});
	// Initialize PO Import Modal
	function initPOImportModal() {
		const searchBtn = document.getElementById('btn-search-po');
		const importBtn = document.getElementById('btn-import-selected');
		const modal = document.getElementById('modalImportPO');
		
		if (searchBtn) {
			searchBtn.addEventListener('click', function() {
				loadPurchaseOrders();
			});
		}
		
		if (importBtn) {
			importBtn.addEventListener('click', function() {
				importSelectedPOItems();
			});
		}
		
		// Load POs when modal opens
		if (modal) {
			modal.addEventListener('show.bs.modal', function() {
				loadPurchaseOrders();
			});
		}
	} 
		// Save serial numbers button handler
		document.getElementById('btn-save-serials')?.addEventListener('click', function(e) {
			e.preventDefault();
			saveSerialNumbersToServer().catch(e => console.error(e));
		});
		document.getElementById('btn-add-sn')?.addEventListener('click', addSerialRow);
		document.getElementById('btn-generate-sn')?.addEventListener('click', generateSerialNumbers);
		
		function escapeHtml(text) { if (!text) return ''; return text.replace(/[&<>]/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m])); }

		/* ========== ADD ITEM MODAL ========== */
		window.openEditItem = function(id) {
			const item = grnItems.find(i => i.id === id);
			if (!item) return;
			editingItemId = id;
			document.getElementById('modal-product').value = item.productId;
			document.getElementById('modal-qty').value = item.qty;
			document.getElementById('modal-free-qty').value = item.freeQty;
			document.getElementById('modal-price').value = item.price;
			document.getElementById('modal-unit').value = item.unit;
			document.getElementById('modal-discount').value = item.discVal;
			document.getElementById('modal-batch').value = item.batch || '';
			document.getElementById('modal-expiry').value = item.expiry || '';
			document.getElementById('modal-product').dispatchEvent(new Event('change'));
			updateModalLineTotal();
		};
		/* ========== LOAD GRN SUMMARY ========== */
	function loadGRNSummary(grnId) {
		if (!grnId) return;
		
		fetch('<?php echo site_url("Grn/getGRNSummary/"); ?>' + grnId, {
			method: 'GET',
			credentials: 'same-origin',
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === 'success' && data.data) {
				const summary = data.data;
				
				// Update summary card
				document.getElementById('summary-grn-number').textContent = summary.grn_number || '--';
				document.getElementById('summary-ref-invoice').textContent = summary.ref_invoice_no || '--';
				
				// Update status badge
				const statusBadge = document.getElementById('summary-status');
				if (statusBadge) {
					statusBadge.textContent = summary.status ? summary.status.toUpperCase() : 'DRAFT';
					statusBadge.className = `badge grn-status-badge badge-${summary.status || 'draft'}`;
				}
				
				document.getElementById('summary-created-by').textContent = summary.created_by || '--';
				document.getElementById('summary-created-on').textContent = summary.created_on || '--';
				document.getElementById('summary-total-items').textContent = summary.total_items || 0;
				document.getElementById('summary-total-qty').textContent = summary.total_qty || 0;
				document.getElementById('summary-grand-total').textContent = fmtLKR(summary.grand_total || 0);
				
				// Update workflow steps based on status
				updateWorkflowSteps(summary.status);
			}
		})
		.catch(error => {
			console.error('Error loading GRN summary:', error);
		});
	}

	/* ========== UPDATE WORKFLOW STEPS ========== */
	function updateWorkflowSteps(status) {
    const steps = document.querySelectorAll('.grn-step');
    if (!steps.length) return;
    
    steps.forEach(step => {
        step.classList.remove('active', 'done');
    });
    
    let currentStepIndex = 0;
    switch(status) {
        case 'new':
            currentStepIndex = 0;  // New status at step 0 (Create)
            break;
        case 'draft':
            currentStepIndex = 1;
            break;
        case 'submitted':
            currentStepIndex = 2;
            break;
        case 'approved':
            currentStepIndex = 4;
            break;
        case 'rejected':
            currentStepIndex = 1;
            break;
        default:
            currentStepIndex = 0;
    }
    
    steps.forEach((step, index) => {
        if (index < currentStepIndex) {
            step.classList.add('done');
        } else if (index === currentStepIndex) {
            step.classList.add('active');
        }
    });
}

	/* ========== LOAD GRN HISTORY ========== */
	function loadGRNHistory(grnId) {
		if (!grnId) {
			const container = document.getElementById('grn-history-container');
			if (container) {
				container.innerHTML = '<div class="text-center py-3 text-muted fs-12">No GRN selected</div>';
			}
			return;
		}
		
		const container = document.getElementById('grn-history-container');
		if (!container) return;
		
		// Show loading
		container.innerHTML = `
			<div class="text-center py-3 text-muted fs-12">
				<div class="spinner-border spinner-border-sm me-2" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
				Loading history...
			</div>
		`;
		
		fetch('<?php echo site_url("Grn/getGRNHistory/"); ?>' + grnId, {
			method: 'GET',
			credentials: 'same-origin',
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === 'success' && data.data && data.data.length > 0) {
				let html = '<div class="history-timeline">';
				
				data.data.forEach(item => {
					const noteHtml = item.note ? `<div class="text-muted fs-11 mt-1 ps-4">Note: ${escapeHtml(item.note)}</div>` : '';
					
					html += `
						<div class="history-item mb-3 ${item.action}">
							<div class="d-flex align-items-start gap-2">
								<div class="history-icon mt-1">
									<i class="${item.icon} text-${item.color} fs-14"></i>
								</div>
								<div class="flex-grow-1">
									<div class="d-flex justify-content-between align-items-center flex-wrap">
										<strong class="fs-13">${item.action_text}</strong>
										<small class="text-muted fs-11">${item.action_date}</small>
									</div>
									<div class="fs-12 text-muted">by ${item.action_by}</div>
									${noteHtml}
								</div>
							</div>
						</div>
					`;
				});
				
				html += '</div>';
				container.innerHTML = html;
			} else {
				container.innerHTML = `
					<div class="text-center py-4 text-muted">
						<i class="ri-history-line fs-3 mb-2 d-block"></i>
						<div class="fs-12">No history available</div>
						<div class="fs-11 text-muted mt-1">Actions will appear here as GRN progresses</div>
					</div>
				`;
			}
		})
		.catch(error => {
			console.error('Error loading GRN history:', error);
			container.innerHTML = `
				<div class="text-center py-3 text-danger fs-12">
					<i class="ri-error-warning-line me-1"></i>
					Failed to load history
				</div>
			`;
		});
	}
    function updateModalLineTotal() {
        const qty = parseFloat(document.getElementById('modal-qty')?.value) || 0;
        const price = parseFloat(document.getElementById('modal-price')?.value) || 0;
        const discVal = parseFloat(document.getElementById('modal-discount')?.value) || 0;
        const discType = document.getElementById('modal-discount-type')?.value;
        const taxStr = document.getElementById('modal-tax')?.value || '';
        const taxRate = taxStr.includes('12') ? 0.12 : taxStr.includes('8') ? 0.08 : taxStr.includes('2') ? 0.02 : 0;
        const lineValue = qty * price;
        const disc = discType === 'percent' ? lineValue * (discVal / 100) : Math.min(discVal, lineValue);
        const total = (lineValue - disc) * (1 + taxRate);
        document.getElementById('modal-line-total').textContent = fmtLKR(total);
    }
    
		/* ========== ADD ITEM MODAL - FIXED ========== */
	// Product selection handler
	document.getElementById('modal-product')?.addEventListener('change', function() {
		const productId = this.value;
		if (!productId) return;
		
		const prod = productsById[productId];
		if (!prod) return;
		
		// Reset form
		document.getElementById('modal-qty').value = '1';
		document.getElementById('modal-free-qty').value = '0';
		document.getElementById('modal-discount').value = '0';
		document.getElementById('modal-batch').value = '';
		document.getElementById('modal-expiry').value = '';
		
		// Set default unit
		document.getElementById('modal-unit').value = prod.unit || 'pcs';
		document.getElementById('modal-price').value = prod.price || 0;
		
		// Show loading state for product info
		const piUnit = document.querySelector('[data-pi="unit"]');
		const piStock = document.querySelector('[data-pi="stock"]');
		const piLastPrice = document.querySelector('[data-pi="last-price"]');
		const piLastDate = document.querySelector('[data-pi="last-date"]');
		const piExpiry = document.querySelector('[data-pi="expiry"]');
		const piSerial = document.querySelector('[data-pi="serial"]');
		
		if (piUnit) piUnit.textContent = 'Loading...';
		if (piStock) piStock.textContent = 'Loading...';
		if (piLastPrice) piLastPrice.textContent = 'Loading...';
		if (piLastDate) piLastDate.textContent = 'Loading...';
		
		// Fetch product details
		fetch('<?php echo site_url("Grn/getProductDetails"); ?>', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: 'product_id=' + encodeURIComponent(productId),
			credentials: 'same-origin'
		})
		.then(response => response.json())
		.then(data => {
			if (data.status) {
				currentProductDetails = data;
				
				// Update product info panel
				if (piUnit) piUnit.textContent = data.unit || 'pcs';
				if (piStock) piStock.textContent = `${data.stock} ${data.unit || 'pcs'}`;
				if (piLastPrice) piLastPrice.textContent = fmtLKR(data.last_price || 0);
				if (piLastDate) piLastDate.textContent = data.last_date || 'N/A';
				
				// Update unit and price in form
				document.getElementById('modal-unit').value = data.unit || 'pcs';
				if (data.last_price > 0) {
					document.getElementById('modal-price').value = data.last_price;
				}
				
				// Handle expiry tracking
				const isExpiryTracked = data.is_expiry_trk === true || data.is_expiry_trk === 1;
				const batchGroup = document.getElementById('modal-batch-group');
				const expiryGroup = document.getElementById('modal-expiry-group');
				const expiryWarning = document.getElementById('expiry-warning');
				
				if (batchGroup && expiryGroup) {
					if (isExpiryTracked) {
						batchGroup.style.display = 'block';
						expiryGroup.style.display = 'block';
						if (expiryWarning) expiryWarning.style.display = 'block';
					} else {
						batchGroup.style.display = 'none';
						expiryGroup.style.display = 'none';
						if (expiryWarning) expiryWarning.style.display = 'none';
					}
				}
				
				// Update expiry info display
				if (piExpiry) {
					piExpiry.innerHTML = `
						<span class="text-muted">Expiry Required</span>
						<span class="badge ${isExpiryTracked ? 'bg-warning-transparent text-warning' : 'bg-secondary-transparent text-secondary'}">
							${isExpiryTracked ? 'Yes' : 'No'}
						</span>
					`;
				}
				
				// Handle serial tracking
				const isSerialTracked = data.is_serial_trk === true || data.is_serial_trk === 1;
				const serialBtn = document.querySelector('#modalAddItem .btn-info');
				
				if (serialBtn) {
					serialBtn.style.display = isSerialTracked ? 'inline-flex' : 'none';
					if (isSerialTracked) {
						serialBtn.innerHTML = '<i class="ri-barcode-line me-1"></i> Enter Serial Numbers';
					}
				}
				
				// Update serial info display
				if (piSerial) {
					piSerial.innerHTML = `
						<span class="text-muted">Serial Tracked</span>
						<span class="badge ${isSerialTracked ? 'bg-info-transparent text-info' : 'bg-secondary-transparent text-secondary'}">
							${isSerialTracked ? 'Yes' : 'No'}
						</span>
					`;
				}
				
				// Update line total preview
				updateModalLineTotal();
			} else {
				console.error('Failed to fetch product details:', data);
				showToast('Failed to load product details', 'warning');
			}
		})
		.catch(error => {
			console.error('Error fetching product details:', error);
			showToast('Error loading product details', 'danger');
		});
	});


	// Add to GRN button with batch existence check
	document.querySelector('#modalAddItem .btn-success')?.addEventListener('click', function() {
		const productId = parseInt(document.getElementById('modal-product').value);
		if (!productId) { 
			showToast('Please select a product', 'warning'); 
			return;
		}
		
		const prod = productsById[productId];
		if (!prod) { 
			showToast('Product not found', 'warning'); 
			return;
		}
		
		const isSerialTracked = currentProductDetails?.is_serial_trk === true || currentProductDetails?.is_serial_trk === 1;
		const isExpiryTracked = currentProductDetails?.is_expiry_trk === true || currentProductDetails?.is_expiry_trk === 1;
		
		// Validate serial tracking
		if (isSerialTracked) {
			showToast('This product requires serial numbers. Please use the "Enter Serial Numbers" button.', 'warning');
			return;
		}
		
		// Validate expiry tracking
		if (isExpiryTracked) {
			const expiryDate = document.getElementById('modal-expiry').value;
			const batchNumber = document.getElementById('modal-batch').value;
			const warehouseId = document.getElementById('grn-warehouse').value;
			
			if (!expiryDate) {
				showToast('Expiry date is required for this product', 'warning');
				return;
			}
			
			if (!batchNumber) {
				showToast('Batch number is required for this product', 'warning');
				return;
			}
			
			if (!warehouseId) {
				showToast('Please select a warehouse first', 'warning');
				return;
			}
			
			// Validate expiry date is not in the past
			const today = new Date();
			today.setHours(0, 0, 0, 0);
			const expiry = new Date(expiryDate);
			if (expiry < today) {
				showToast('Expiry date cannot be in the past', 'warning');
				return;
			}
			
			// Check if batch already exists
			showToast('Checking batch number...', 'info');
			
			checkBatchExists(productId, batchNumber, warehouseId).then(exists => {
				if (exists) {
					// Batch exists - show confirmation dialog
					if (confirm(`Batch number "${batchNumber}" already exists in inventory.\n\nDo you want to add more stock to this existing batch?`)) {
						// User confirmed to use existing batch
						addItemToGRN(productId, prod, isExpiryTracked, true);
					} else {
						// User wants to create new batch - ask for new batch number
						const newBatch = prompt('Please enter a new batch number:', batchNumber + '-NEW');
						if (newBatch && newBatch.trim()) {
							document.getElementById('modal-batch').value = newBatch.trim();
							// Re-check for the new batch number
							checkBatchExists(productId, newBatch.trim(), warehouseId).then(existsAgain => {
								if (existsAgain) {
									showToast('That batch number also exists. Please use a unique batch number.', 'warning');
								} else {
									addItemToGRN(productId, prod, isExpiryTracked, false);
								}
							});
						} else {
							showToast('Please enter a valid batch number', 'warning');
						}
					}
				} else {
					// Batch doesn't exist - add normally
					addItemToGRN(productId, prod, isExpiryTracked, false);
				}
			}).catch(error => {
				console.error('Error checking batch:', error);
				// If check fails, still allow adding
				addItemToGRN(productId, prod, isExpiryTracked, false);
			});
			
			return; // Wait for batch check
		}
		
		addItemToGRN(productId, prod, isExpiryTracked, false);
	});
function initAttachmentHandlers() {
    const dropzone = document.getElementById('grn-dropzone');
    const fileInput = document.getElementById('att-file-input');
    
    if (!dropzone || !fileInput) return;
    
    // Click to select files
    dropzone.addEventListener('click', (e) => {
        // Don't trigger if clicking on remove button
        if (e.target.closest('.remove-att')) return;
        fileInput.click();
    });
    
    // Drag and drop
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.style.borderColor = '#405189';
        dropzone.style.background = '#eef2ff';
    });
    
    dropzone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropzone.style.borderColor = '#c8d4f0';
        dropzone.style.background = '#f8faff';
    });
    
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.style.borderColor = '#c8d4f0';
        dropzone.style.background = '#f8faff';
        
        const files = Array.from(e.dataTransfer.files);
        addFiles(files);
    });
    
    // File input change
    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        addFiles(files);
        fileInput.value = ''; // Reset so same file can be selected again
    });
}

function addFiles(files) {
    // Filter valid file types
    const validFiles = files.filter(f => {
        const ext = f.name.split('.').pop().toLowerCase();
        return ['pdf', 'jpg', 'jpeg', 'png'].includes(ext);
    });
    
    if (validFiles.length !== files.length) {
        showToast('Only PDF, JPG, JPEG, PNG files are allowed', 'warning');
    }
    
    // Limit file size (10MB)
    const oversized = validFiles.filter(f => f.size > 10 * 1024 * 1024);
    if (oversized.length) {
        showToast(`File(s) ${oversized.map(f => f.name).join(', ')} exceed 10MB limit`, 'danger');
        return;
    }
    
    validFiles.forEach(f => selectedFiles.push(f));
    renderSelectedFilesPreview();
    
    showToast(`${validFiles.length} file(s) selected`, 'success');
}

	function addItemToGRN(productId, prod, isExpiryTracked, isExistingBatch) {
		const newItem = {
			id: nextItemId++,
			productId: productId,
			name: prod.name,
			sku: prod.sku || '',
			unit: document.getElementById('modal-unit').value || 'pcs',
			qty: parseInt(document.getElementById('modal-qty').value) || 1,
			freeQty: parseInt(document.getElementById('modal-free-qty').value) || 0,
			price: parseFloat(document.getElementById('modal-price').value) || 0,
			discVal: parseFloat(document.getElementById('modal-discount').value) || 0,
			discType: document.getElementById('modal-discount-type').value.includes('Perc') ? '%' : 'LKR',
			tax: 'No Tax',
			taxRate: 0,
			batch: isExpiryTracked ? document.getElementById('modal-batch').value : '',
			expiry: isExpiryTracked ? document.getElementById('modal-expiry').value : '',
			isSerial: false,
			serialsDone: true,
			isExpiryTracked: isExpiryTracked,
			isExistingBatch: isExistingBatch // Flag to indicate if this is adding to existing batch
		};
		
		if (editingItemId !== null) {
			const index = grnItems.findIndex(i => i.id === editingItemId);
			if (index !== -1) grnItems[index] = { ...grnItems[index], ...newItem, id: editingItemId };
			editingItemId = null;
		} else {
			grnItems.push(newItem);
		}
		
		renderItemsTable();
		
		// Show appropriate message
		if (isExpiryTracked) {
			if (isExistingBatch) {
				showToast(`Product added to existing batch "${newItem.batch}". Stock will be merged upon approval.`, 'info');
			} else {
				showToast(`New batch "${newItem.batch}" created for this product.`, 'success');
			}
		} else {
			showToast('Product added successfully', 'success');
		}
		
		// Close modal
		const modal = bootstrap.Modal.getInstance(document.getElementById('modalAddItem'));
		if (modal) modal.hide();
		
		// Reset form
		document.getElementById('modal-product').value = '';
		document.getElementById('modal-batch').value = '';
		document.getElementById('modal-expiry').value = '';
	}
	// Enter Serial Numbers button
	document.querySelector('#modalAddItem .btn-info')?.addEventListener('click', function() {
		const productId = parseInt(document.getElementById('modal-product').value);
		if (!productId) { 
			showToast('Please select a product first', 'warning'); 
			return;
		}
		
		const isSerialTracked = currentProductDetails?.is_serial_trk === true || currentProductDetails?.is_serial_trk === 1;
		if (!isSerialTracked) { 
			showToast('This product does not require serial numbers', 'info'); 
			return;
		}
		
		const prod = productsById[productId];
		if (!prod) { 
			showToast('Product not found', 'warning'); 
			return;
		}
		
		const qty = parseInt(document.getElementById('modal-qty').value) || 1;
		const isExpiryTracked = currentProductDetails?.is_expiry_trk === true || currentProductDetails?.is_expiry_trk === 1;
		
		// Create temporary item
		const tempItem = {
			id: -Date.now(),
			productId: productId,
			name: prod.name,
			sku: prod.sku || '',
			unit: document.getElementById('modal-unit').value || 'pcs',
			qty: qty,
			freeQty: parseInt(document.getElementById('modal-free-qty').value) || 0,
			price: parseFloat(document.getElementById('modal-price').value) || 0,
			discVal: parseFloat(document.getElementById('modal-discount').value) || 0,
			discType: document.getElementById('modal-discount-type').value.includes('Perc') ? '%' : 'LKR',
			tax: 'No Tax',
			taxRate: 0,
			batch: isExpiryTracked ? document.getElementById('modal-batch').value : '',
			expiry: isExpiryTracked ? document.getElementById('modal-expiry').value : '',
			isSerial: true,
			serialsDone: false,
			serials: [],
			isExpiryTracked: isExpiryTracked
		};
		
		grnItems.push(tempItem);
		renderItemsTable();
		
		// Close the add item modal
		const addModal = bootstrap.Modal.getInstance(document.getElementById('modalAddItem'));
		if (addModal) addModal.hide();
		
		// Open serial number modal after a short delay
		setTimeout(() => openSerialModal(tempItem.id), 300);
		
		showToast(`Item "${prod.name}" added. Please enter ${qty} serial numbers.`, 'info');
	});
		
		['modal-qty', 'modal-price', 'modal-discount'].forEach(id => {
			document.getElementById(id)?.addEventListener('input', updateModalLineTotal);
		});
		document.getElementById('modal-discount-type')?.addEventListener('change', updateModalLineTotal);
		document.getElementById('modal-tax')?.addEventListener('change', updateModalLineTotal);

		/* ========== GRN CRUD OPERATIONS ========== */
function generateGRNNumber() {
    // Check if we already have a GRN ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const existingGrnId = urlParams.get('id');
    
    if(existingGrnId) {
        // Don't create new draft, load existing
        // The global function will handle this
        console.log('Will load existing GRN:', existingGrnId);
        return;
    }
    
    // Otherwise create new draft
    fetch('<?php echo site_url("Grn/generateGRNNumber"); ?>', {
        method: 'GET', 
        credentials: 'same-origin'
    }).then(r => r.json()).then(data => {
        if (data.status === 'success') {
            currentGRNId = data.data.grn_id;
            currentGRNNumber = data.data.grn_number;
            document.getElementById('grn-number-display').innerHTML = `<i class="ri-file-list-3-line me-1"></i>${currentGRNNumber}`;
            document.getElementById('hidden-grn-id').value = currentGRNId;
            document.getElementById('hidden-grn-number').value = currentGRNNumber;
        }
    }).catch(error => {
        console.error('Error creating draft:', error);
    });
}
		/* ========== LOAD ATTACHMENTS ========== */
	function loadAttachments(grnId) {
		if (!grnId) return;
		
		fetch('<?php echo site_url("Grn/getAttachments/"); ?>' + grnId, {
			method: 'GET',
			credentials: 'same-origin',
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === 'success' && data.data) {
				displayExistingAttachments(data.data);
			}
		})
		.catch(error => {
			console.error('Error loading attachments:', error);
		});
	}

	/* ========== DISPLAY EXISTING ATTACHMENTS ========== */
	function displayExistingAttachments(attachments) {
		const container = document.getElementById('uploaded-files-container');
		if (!container) return;
		
		if (!attachments || attachments.length === 0) {
			container.innerHTML = '<div class="text-muted fs-12">No uploaded files</div>';
			return;
		}
		
		let html = '';
		attachments.forEach(att => {
			const ext = att.file_type || att.file_name.split('.').pop().toLowerCase();
			const icon = ext === 'pdf' ? 'ri-file-pdf-line' : 
						(['jpg','jpeg','png'].includes(ext) ? 'ri-image-line' : 'ri-file-line');
			
			html += `
				<div class="attachment-thumb" data-attachment-id="${att.id}">
					<i class="${icon} text-primary" style="font-size:24px"></i>
					<div class="attachment-info" style="position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; background: rgba(0,0,0,0.7); color: white; padding: 2px 4px; border-radius: 4px; display: none;">
						${escapeHtml(att.file_name)}
					</div>
					<span class="remove-att" onclick="deleteAttachment(${att.id}, event)">
						<i class="ri-close-line"></i>
					</span>
				</div>
			`;
		});
		
		container.innerHTML = html;
		
		// Add tooltip on hover
		document.querySelectorAll('.attachment-thumb').forEach(thumb => {
			thumb.addEventListener('mouseenter', function() {
				const info = this.querySelector('.attachment-info');
				if (info) info.style.display = 'block';
			});
			thumb.addEventListener('mouseleave', function() {
				const info = this.querySelector('.attachment-info');
				if (info) info.style.display = 'none';
			});
			thumb.addEventListener('click', function(e) {
				if (!e.target.closest('.remove-att')) {
					const attId = this.dataset.attachmentId;
					if (attId) downloadAttachment(attId);
				}
			});
		});
	}

	/* ========== DOWNLOAD ATTACHMENT ========== */
	function downloadAttachment(attachmentId) {
		window.open('<?php echo site_url("Grn/downloadAttachment/"); ?>' + attachmentId, '_blank');
	}

	/* ========== DELETE ATTACHMENT ========== */
	function deleteAttachment(attachmentId, event) {
		event.stopPropagation();
		
		if (!confirm('Are you sure you want to delete this attachment?')) {
			return;
		}
		
		fetch('<?php echo site_url("Grn/deleteAttachment/"); ?>' + attachmentId, {
			method: 'DELETE',
			credentials: 'same-origin',
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
		.then(response => response.json())
		.then(data => {
			if (data.status === 'success') {
				showToast('Attachment deleted successfully', 'success');
				// Remove from DOM
				const thumb = document.querySelector(`.attachment-thumb[data-attachment-id="${attachmentId}"]`);
				if (thumb) thumb.remove();
				
				// Check if no attachments left
				const container = document.getElementById('uploaded-files-container');
				if (container && container.children.length === 0) {
					container.innerHTML = '<div class="text-muted fs-12">No uploaded files</div>';
				}
			} else {
				showToast('Failed to delete attachment: ' + (data.msg || 'Unknown error'), 'danger');
			}
		})
		.catch(error => {
			console.error('Error deleting attachment:', error);
			showToast('Failed to delete attachment', 'danger');
		});
	}
    function createNewDraftGRN() {
        fetch('<?php echo site_url("Grn/generateGRNNumber"); ?>', {
            method: 'GET', credentials: 'same-origin'
        }).then(r => r.json()).then(data => {
            if (data.status === 'success') {
                currentGRNId = data.data.grn_id;
                currentGRNNumber = data.data.grn_number;
                document.getElementById('grn-number-display').innerHTML = `<i class="ri-file-list-3-line me-1"></i>${currentGRNNumber}`;
                document.getElementById('hidden-grn-id').value = currentGRNId;
                document.getElementById('hidden-grn-number').value = currentGRNNumber;
            }
        });
    }
    
    document.getElementById('btn-save-draft')?.addEventListener('click', () => {
    if (!document.getElementById('grn-supplier').value) { showToast('Select supplier', 'warning'); return; }
    if (!document.getElementById('grn-warehouse').value) { showToast('Select warehouse', 'warning'); return; }
    if (grnItems.length === 0) { showToast('Add at least one item', 'warning'); return; }
    
    const grnData = collectGRNData();
    
    // ALWAYS use store endpoint - it handles both create and update
    const url = '<?php echo site_url("Grn/store"); ?>';
    
    console.log('Saving GRN data:', grnData);
    
    fetch(url, {
        method: 'POST', 
        headers: { 'Content-Type': 'application/json' }, 
        body: JSON.stringify(grnData), 
        credentials: 'same-origin'
    }).then(r => r.json()).then(async data => {
        console.log('Save response:', data);
        
        if (data.status === 'success') {
            const newGrnId = data.data?.grn_id;
            if (!currentGRNId && newGrnId) {
                currentGRNId = newGrnId;
                currentGRNNumber = data.data?.grn_number;
                document.getElementById('hidden-grn-id').value = currentGRNId;
                document.getElementById('hidden-grn-number').value = currentGRNNumber;
                document.getElementById('grn-number-display').innerHTML = '<i class="ri-file-list-3-line me-1"></i>' + currentGRNNumber;
                console.log('Set currentGRNId to:', currentGRNId);
            }
            
            showToast('GRN saved as draft', 'success');
            
            // IMPORTANT: Upload files AFTER we have the GRN ID
            if (selectedFiles.length > 0 && currentGRNId) {
                console.log('Uploading files for GRN:', currentGRNId);
                await uploadFilesAfterSave(currentGRNId, selectedFiles);
                // Don't clear selectedFiles here - it's cleared in upload function
            }
            
            // Reload GRN to get updated status
            if (currentGRNId) {
                setTimeout(() => {
                    loadGRNDataById(currentGRNId);
                }, 500);
            }
        } else {
            showToast(data.msg || 'Save failed', 'danger');
        }
    }).catch(e => {
        console.error('Save error:', e);
        showToast('Save failed', 'danger');
    });
});
    
    document.getElementById('btn-submit-approval')?.addEventListener('click', async () => {
    if (!validateGRNForSubmission()) return;
    
    // FIRST: Save the GRN (including any pending attachments)
    const grnData = collectGRNData();
    
    try {
        // Step 1: Save/Update GRN
        let saveResult;
        if (currentGRNId) {
            const response = await fetch('<?php echo site_url("Grn/update/"); ?>' + currentGRNId, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(grnData),
                credentials: 'same-origin'
            });
            saveResult = await response.json();
        } else {
            const response = await fetch('<?php echo site_url("Grn/store"); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(grnData),
                credentials: 'same-origin'
            });
            saveResult = await response.json();
        }
        
        if (saveResult.status !== 'success') {
            throw new Error(saveResult.msg || 'Failed to save GRN');
        }
        
        // Update GRN ID if new
        if (!currentGRNId && saveResult.data?.grn_id) {
            currentGRNId = saveResult.data.grn_id;
            currentGRNNumber = saveResult.data.grn_number;
            document.getElementById('hidden-grn-id').value = currentGRNId;
            document.getElementById('hidden-grn-number').value = currentGRNNumber;
        }
        
        // Step 2: Upload any pending attachments BEFORE submitting
        if (selectedFiles.length > 0 && currentGRNId) {
            console.log('Uploading attachments before submission...');
            await uploadFilesAfterSave(currentGRNId, selectedFiles);
            // Wait a moment for uploads to complete
            await new Promise(resolve => setTimeout(resolve, 1000));
        }
        
        // Step 3: Submit for approval
        const submitResponse = await fetch('<?php echo site_url("Grn/submit/"); ?>' + currentGRNId, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(grnData)
        });
        const submitResult = await submitResponse.json();
        
        if (submitResult.status === 'success') {
            showToast('GRN submitted for approval', 'success');
            setTimeout(() => location.reload(), 2000);
        } else {
            throw new Error(submitResult.msg || 'Submission failed');
        }
    } catch (e) {
        showToast('Error: ' + e.message, 'danger');
        console.error('Submission error:', e);
    }
});
    
    function validateGRNForSubmission() {
    console.log('validateGRNForSubmission - grnItems.length:', grnItems.length);
    console.log('validateGRNForSubmission - grnItems:', grnItems);
    
    const errors = [];
    
    if (!document.getElementById('grn-supplier').value) errors.push('Supplier');
    if (!document.getElementById('grn-warehouse').value) errors.push('Warehouse');
    if (!document.getElementById('grn-date').value) errors.push('GRN Date');
    if (!document.getElementById('grn-received-by').value) errors.push('Received By');
    
    // FIX: Use grnItems array (not window.pendingGRNItems)
    if (grnItems.length === 0) errors.push('At least one item');
    
    // Check pending serials
    const pendingSerials = grnItems.filter(i => i.isSerial && !i.serialsDone);
    if (pendingSerials.length) {
        errors.push(`Serial numbers required for: ${pendingSerials.map(i => i.name).join(', ')}`);
    }
    
    // Check pending batch/expiry
    const pendingBatch = grnItems.filter(i => i.isExpiryTracked && (!i.batch || !i.expiry));
    if (pendingBatch.length) {
        errors.push(`Batch/Expiry required for: ${pendingBatch.map(i => i.name).join(', ')}`);
    }
    
    // Additional validation for quantity and price
    const invalidQuantity = grnItems.filter(i => (i.qty || 0) <= 0);
    if (invalidQuantity.length) {
        errors.push(`Quantity must be greater than 0 for: ${invalidQuantity.map(i => i.name).join(', ')}`);
    }
    
    const invalidPrice = grnItems.filter(i => (i.price || 0) <= 0);
    if (invalidPrice.length) {
        errors.push(`Price must be greater than 0 for: ${invalidPrice.map(i => i.name).join(', ')}`);
    }
    
    if (errors.length) {
        showToast('Please fix: ' + errors.join(', '), 'warning');
        return false;
    }
    
    return true;
}
    
   function uploadFilesAfterSave(grnId, files) {
    if (!grnId) {
        console.error('No GRN ID for upload');
        showToast('Cannot upload files: GRN not saved yet', 'warning');
        return Promise.reject('No GRN ID');
    }
    
    if (!files || files.length === 0) {
        return Promise.resolve();
    }
    
    const formData = new FormData();
    files.forEach(f => formData.append('files[]', f));
    
    showToast(`Uploading ${files.length} file(s) to GRN #${grnId}...`, 'info');
    
    return fetch('<?php echo site_url("Grn/uploadAttachment/"); ?>' + grnId, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
    .then(async response => {
        const text = await response.text();
        console.log('Upload response raw:', text);
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('JSON parse error:', e);
            throw new Error('Invalid server response');
        }
    })
    .then(data => {
        console.log('Upload response:', data);
        if (data.status === 'success') {
            showToast(`${data.data?.length || files.length} file(s) uploaded successfully`, 'success');
            // Clear selected files after successful upload
            selectedFiles = [];
            renderSelectedFilesPreview();
            // Reload attachments
            if (typeof loadAttachments === 'function') {
                loadAttachments(grnId);
            }
            return data;
        } else {
            showToast('Upload failed: ' + (data.msg || 'Unknown error'), 'danger');
            throw new Error(data.msg);
        }
    })
    .catch(error => {
        console.error('Upload error:', error);
        showToast('Upload failed: ' + error.message, 'danger');
        throw error;
    });
}
    
       function renderSelectedFilesPreview() {
        const container = document.getElementById('file-preview-container');
        if (!container) return;
        
        const countSpan = document.getElementById('selected-files-count');
        
        if (!selectedFiles.length) {
            container.innerHTML = '<div class="text-muted fs-12">No files selected</div>';
            if (countSpan) countSpan.textContent = '(0 files)';
            return;
        }
        
        if (countSpan) countSpan.textContent = `(${selectedFiles.length} files)`;
        
        let html = '';
        selectedFiles.forEach((f, i) => {
            const ext = f.name.split('.').pop().toLowerCase();
            const icon = ext === 'pdf' ? 'ri-file-pdf-line' : 
                        (['jpg','jpeg','png'].includes(ext) ? 'ri-image-line' : 'ri-file-line');
            
            // Truncate filename if too long
            const displayName = f.name.length > 30 ? f.name.substring(0, 27) + '...' : f.name;
            
            html += `
                <div class="attachment-thumb" data-file-index="${i}" style="position: relative; width: 80px; height: 80px; background: #f0f4ff; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: default;">
                    <i class="${icon} text-primary" style="font-size: 28px;"></i>
                    <div class="fs-10 text-muted mt-1 text-center" style="max-width: 70px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${escapeHtml(displayName)}</div>
                    <span class="remove-att" onclick="removeSelectedFile(${i})" style="position: absolute; top: -5px; right: -5px; width: 18px; height: 18px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.6rem; cursor: pointer;">
                        <i class="ri-close-line"></i>
                    </span>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }  // <-- THIS CLOSING BRACE WAS MISSING!

    window.removeSelectedFile = (idx) => {
        if (idx >= 0 && idx < selectedFiles.length) {
            selectedFiles.splice(idx, 1);
            renderSelectedFilesPreview();
            showToast('File removed', 'info');
        }
    };

	// Function to load supplier summary
	function loadSupplierSummary(supplierId) {
		if (!supplierId) {
			document.getElementById('supplier-summary-panel').style.display = 'none';
			return;
		}
		
		// Show loading state
		const panel = document.getElementById('supplier-summary-panel');
		if (panel) {
			panel.style.display = 'block';
		}
		
		const nameSpan = document.getElementById('sup-name');
		const lastDateSpan = document.getElementById('sup-last-date');
		const lastAmountSpan = document.getElementById('sup-last-amount');
		const outstandingSpan = document.getElementById('sup-outstanding');
		
		if (nameSpan) nameSpan.textContent = 'Loading...';
		if (lastDateSpan) lastDateSpan.textContent = 'Loading...';
		if (lastAmountSpan) lastAmountSpan.textContent = 'Loading...';
		if (outstandingSpan) outstandingSpan.textContent = 'Loading...';
		
		const url = '<?php echo site_url("Grn/supplierSummary/"); ?>' + supplierId;
		console.log('Fetching supplier summary from:', url);
		
		fetch(url, {
			method: 'GET',
			credentials: 'same-origin',
			headers: { 
				'X-Requested-With': 'XMLHttpRequest',
				'Accept': 'application/json'
			}
		})
		.then(response => {
			console.log('Response status:', response.status);
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.text(); // Get as text first to see raw response
		})
		.then(text => {
			console.log('Raw response:', text);
			try {
				return JSON.parse(text);
			} catch (e) {
				console.error('JSON parse error:', e);
				throw new Error('Invalid JSON response: ' + text.substring(0, 200));
			}
		})
		.then(data => {
			console.log('Supplier summary data:', data);
			
			if (data.status === 'success' && data.data) {
				const summary = data.data;
				
				// Update basic info
				if (nameSpan) nameSpan.textContent = summary.supplier_name || '--';
				
				const phoneSpan = document.getElementById('sup-phone');
				if (phoneSpan) {
					phoneSpan.innerHTML = '<i class="ri-phone-line"></i> ' + (summary.supplier_phone || '--');
				}
				
				// Update last invoice info
				if (lastDateSpan) lastDateSpan.textContent = summary.last_invoice_date || '--';
				if (lastAmountSpan) lastAmountSpan.textContent = fmtLKR(summary.last_invoice_amount || 0);
				
				// Update outstanding balance with color coding
				if (outstandingSpan) {
					const outstanding = summary.outstanding_balance || 0;
					outstandingSpan.textContent = fmtLKR(outstanding);
					
					if (outstanding > 100000) {
						outstandingSpan.className = 'fw-semibold fs-13 text-danger';
					} else if (outstanding > 50000) {
						outstandingSpan.className = 'fw-semibold fs-13 text-warning';
					} else if (outstanding > 0) {
						outstandingSpan.className = 'fw-semibold fs-13 text-info';
					} else {
						outstandingSpan.className = 'fw-semibold fs-13 text-success';
					}
				}
				
				// Update status badge
				const statusBadge = document.querySelector('#supplier-summary-panel .badge');
				if (statusBadge) {
					const overdueAmount = summary.overdue_amount || 0;
					const outstanding = summary.outstanding_balance || 0;
					
					if (overdueAmount > 0) {
						statusBadge.innerHTML = '<i class="ri-alert-line me-1"></i> Overdue';
						statusBadge.className = 'ms-auto badge bg-danger-transparent text-danger fs-11';
					} else if (outstanding > 0) {
						statusBadge.innerHTML = '<i class="ri-wallet-line me-1"></i> Has Balance';
						statusBadge.className = 'ms-auto badge bg-warning-transparent text-warning fs-11';
					} else {
						statusBadge.innerHTML = '<i class="ri-check-line me-1"></i> All Settled';
						statusBadge.className = 'ms-auto badge bg-success-transparent text-success fs-11';
					}
				}
				
				// Show credit limit if available
				if (summary.credit_limit > 0) {
					const creditHtml = `
						<div class="mt-2 pt-2 border-top">
							<div class="d-flex justify-content-between fs-12">
								<span class="text-muted">Credit Limit:</span>
								<span class="fw-semibold">${fmtLKR(summary.credit_limit)}</span>
							</div>
							<div class="d-flex justify-content-between fs-12">
								<span class="text-muted">Available Credit:</span>
								<span class="fw-semibold ${summary.available_credit < 0 ? 'text-danger' : 'text-success'}">
									${fmtLKR(summary.available_credit)}
								</span>
							</div>
							<div class="d-flex justify-content-between fs-12">
								<span class="text-muted">Payment Terms:</span>
								<span class="fw-semibold">${summary.payment_terms}</span>
							</div>
						</div>
					`;
					const summaryCard = document.querySelector('#supplier-summary-panel .supplier-summary-card');
					if (summaryCard) {
						let creditDiv = summaryCard.querySelector('.credit-info');
						if (!creditDiv) {
							creditDiv = document.createElement('div');
							creditDiv.className = 'credit-info mt-2 pt-2 border-top';
							summaryCard.appendChild(creditDiv);
						}
						creditDiv.innerHTML = creditHtml;
					}
				}
				
			} else {
				console.error('Failed to load supplier summary:', data);
				document.getElementById('supplier-summary-panel').style.display = 'none';
				showToast('Failed to load supplier summary: ' + (data.msg || 'Unknown error'), 'warning');
			}
		})
		.catch(error => {
			console.error('Error loading supplier summary:', error);
			document.getElementById('supplier-summary-panel').style.display = 'none';
			showToast('Error loading supplier summary: ' + error.message, 'danger');
		});
	}
		document.getElementById('bill-discount-val')?.addEventListener('input', updateTotals);
		document.getElementById('bill-discount-type')?.addEventListener('change', updateTotals);
		document.getElementById('grn-supplier')?.addEventListener('change', updateValidationChecklist);
		document.getElementById('grn-warehouse')?.addEventListener('change', updateValidationChecklist);
		document.getElementById('grn-date')?.addEventListener('change', updateValidationChecklist);
		document.getElementById('grn-received-by')?.addEventListener('change', updateValidationChecklist);
		
		generateGRNNumber();
		renderItemsTable();
		// Initialize PO Import Modal
	   initPOImportModal();
	   // Add this INSIDE your IIFE, before the final })();
// Expose a function to apply the draft data
window.applyGRNDraft = function(draft) {
    loadExistingDraft(draft);
};

// Check if there's a pending draft
if (window.pendingGRNDraft) {
    loadExistingDraft(window.pendingGRNDraft);
    delete window.pendingGRNDraft;
}
var baseUrl = '<?php echo base_url(); ?>';

// Initialize payment modal when document is ready
$(document).ready(function() {
    console.log('Initializing payment modal...');
    
    // Check if payment modal elements exist
    if ($('#modalRecordPayment').length) {
        console.log('Payment modal found, initializing...');
        initPaymentModal();
    } else {
        console.log('Payment modal not found');
    }
});
$(document).ready(function() {
    // Force hide approve/reject buttons on initial load
    $('#btn-approve, #btn-reject').hide();
	
	initAttachmentHandlers();

});
	})();
	
	window.productsByIdGlobal = window.productsByIdGlobal || {};

// FIX: Override renderItemsTableDirectly to use global products
window.renderItemsTableDirectly = function(items) {
    console.log('FIXED renderItemsTableDirectly called with items:', items);
    
    const tbody = document.getElementById('grn-items-tbody');
    if (!tbody) return;
    
    if (!items || items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center py-3">No items added yet</td></tr>';
        return;
    }
    
    let html = '';
    let idx = 1;
    
    items.forEach((item) => {
        // Get product name from global or use product_id
        let productName = 'Product ID: ' + item.product_id;
        if (window.productsByIdGlobal && window.productsByIdGlobal[item.product_id]) {
            productName = window.productsByIdGlobal[item.product_id].name;
        }
        
        const qty = parseFloat(item.quantity) || 0;
        const freeQty = parseFloat(item.free_quantity) || 0;
        const price = parseFloat(item.unit_price) || 0;
        const discVal = parseFloat(item.discount_value) || 0;
        const discType = item.discount_type === 'percent' ? '%' : 'LKR';
        const lineTotal = (qty * price) - (discType === '%' ? (qty * price * discVal / 100) : discVal);
        
        html += `
            <tr data-item-id="${item.id || idx}">
                <td class="text-muted fs-12">${idx++}</td>
                <td>
                    <div class="fw-semibold fs-13">${escapeHtml(productName)}</div>
                </td>
                <td><span class="badge bg-light text-dark">pcs</span></td>
                <td><input type="number" class="form-control qty-input" value="${qty}" min="1" style="width:80px" disabled></td>
                <td><input type="number" class="form-control qty-input" value="${freeQty}" min="0" style="width:80px" disabled></td>
                <td><input type="number" class="form-control price-input" value="${price.toFixed(2)}" step="0.01" style="width:110px" disabled></td>
                <td>
                    <div class="d-flex gap-1">
                        <input type="number" class="form-control discount-input" value="${discVal}" min="0" style="width:85px" disabled>
                        <select class="form-select form-select-sm" style="width:60px" disabled>
                            <option ${discType === '%' ? 'selected' : ''}>%</option>
                            <option ${discType === 'LKR' ? 'selected' : ''}>LKR</option>
                        </select>
                    </div>
                </td>
                <td class="fw-semibold text-end">${fmtLKR(lineTotal)}</td>
                <td></td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    
    // Update totals
    let subtotal = 0;
    items.forEach(item => {
        subtotal += (parseFloat(item.quantity) || 0) * (parseFloat(item.unit_price) || 0);
    });
    const grandTotalSpan = document.getElementById('tot-grand');
    if (grandTotalSpan) grandTotalSpan.textContent = fmtLKR(subtotal);
    const summaryGrandTotal = document.getElementById('summary-grand-total');
    if (summaryGrandTotal) summaryGrandTotal.textContent = fmtLKR(subtotal);
    const summaryTotalItems = document.getElementById('summary-total-items');
    if (summaryTotalItems) summaryTotalItems.textContent = items.length;
};

// FIX: Load attachments after GRN loads
function loadAttachmentsFixed(grnId) {
    if (!grnId) return;
    
    console.log('Loading attachments for GRN:', grnId);
    
    fetch('<?php echo site_url("Grn/getAttachments/"); ?>' + grnId, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Attachments data:', data);
        if (data.status === 'success' && data.data && data.data.length > 0) {
            displayAttachments(data.data);
        } else {
            document.getElementById('uploaded-files-container').innerHTML = '<div class="text-muted fs-12">No uploaded files</div>';
        }
    })
    .catch(error => {
        console.error('Error loading attachments:', error);
    });
}

function displayAttachments(attachments) {
    const container = document.getElementById('uploaded-files-container');
    if (!container) return;
    
    if (!attachments || attachments.length === 0) {
        container.innerHTML = '<div class="text-muted fs-12">No uploaded files</div>';
        return;
    }
    
    let html = '';
    attachments.forEach(att => {
        const ext = att.file_type || att.file_name.split('.').pop().toLowerCase();
        const icon = ext === 'pdf' ? 'ri-file-pdf-line' : 
                    (['jpg','jpeg','png'].includes(ext) ? 'ri-image-line' : 'ri-file-line');
        
        html += `
            <div class="attachment-thumb" data-attachment-id="${att.id}" onclick="downloadAttachment(${att.id})">
                <i class="${icon} text-primary" style="font-size:24px"></i>
                <div class="attachment-info" style="position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; background: rgba(0,0,0,0.7); color: white; padding: 2px 4px; border-radius: 4px; display: none;">
                    ${escapeHtml(att.file_name)}
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // Add hover tooltips
    document.querySelectorAll('.attachment-thumb').forEach(thumb => {
        thumb.addEventListener('mouseenter', function() {
            const info = this.querySelector('.attachment-info');
            if (info) info.style.display = 'block';
        });
        thumb.addEventListener('mouseleave', function() {
            const info = this.querySelector('.attachment-info');
            if (info) info.style.display = 'none';
        });
    });
}

function downloadAttachment(attachmentId) {
    window.open('<?php echo site_url("Grn/downloadAttachment/"); ?>' + attachmentId, '_blank');
}

// Override processLoadedGRNData to also load attachments
const originalProcessLoadedGRNData = window.processLoadedGRNData;
window.processLoadedGRNData = function() {
    console.log('processLoadedGRNData called');
    
    // Prevent duplicate processing
    if (window.processingGRNData) return;
    window.processingGRNData = true;
    
    console.log('window.pendingGRNId:', window.pendingGRNId);
    console.log('window.pendingGRNItems:', window.pendingGRNItems);
    
    if (window.pendingGRNId && window.pendingGRNItems) {
        // Set global variables for approve/reject
        window.currentGRNIdGlobal = window.pendingGRNId;
        window.currentGRNNumberGlobal = window.pendingGRNNumber;
        window.currentGRNStatusGlobal = window.pendingGRNStatus;
        
        // Also set hidden fields
        document.getElementById('hidden-grn-id').value = window.pendingGRNId;
        document.getElementById('hidden-grn-number').value = window.pendingGRNNumber;
        document.getElementById('grn-number-display').innerHTML = '<i class="ri-file-list-3-line me-1"></i>' + window.pendingGRNNumber;
        
        // Update status badge
        const statusBadge = document.querySelector('.grn-status-badge');
        if (statusBadge && window.pendingGRNStatus) {
            statusBadge.textContent = window.pendingGRNStatus.toUpperCase();
            statusBadge.className = 'badge grn-status-badge badge-' + window.pendingGRNStatus;
        }
        
        // Render items directly using the global function
        if (typeof window.renderItemsTableDirectly === 'function') {
            window.renderItemsTableDirectly(window.pendingGRNItems);
        }
        
        // Show/hide payment sections
        if (window.pendingGRNStatus === 'approved') {
            $('#payment-summary-card, #payment-history-card').show();
        } else {
            $('#payment-summary-card, #payment-history-card').hide();
        }
        
        showToast(window.pendingGRNNumber + ' loaded successfully', 'success');
    }
    
    window.processingGRNData = false;
};

// Helper function
function escapeHtml(text) {
    if (!text) return '';
    return String(text).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Ensure fmtLKR is defined globally
if (typeof fmtLKR !== 'function') {
    window.fmtLKR = function(n) {
        return 'LKR ' + parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };
}

// Also ensure productsByIdGlobal is populated from the PHP products array
window.productsByIdGlobal = {
<?php foreach ($products as $p): ?>
    <?php echo $p->id; ?>: {
        id: <?php echo $p->id; ?>,
        name: '<?php echo addslashes($p->name); ?>',
        sku: '<?php echo addslashes($p->product_code ?? ''); ?>',
        price: <?php echo floatval($p->price ?? 0); ?>
    },
<?php endforeach; ?>
};

console.log('Products loaded:', Object.keys(window.productsByIdGlobal).length);
// FIX: Load GRN History
function loadGRNHistoryFixed(grnId) {
    if (!grnId) {
        const container = document.getElementById('grn-history-container');
        if (container) {
            container.innerHTML = '<div class="text-center py-3 text-muted fs-12">No GRN selected</div>';
        }
        return;
    }
    
    const container = document.getElementById('grn-history-container');
    if (!container) return;
    
    // Show loading
    container.innerHTML = `
        <div class="text-center py-3 text-muted fs-12">
            <div class="spinner-border spinner-border-sm me-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            Loading history...
        </div>
    `;
    
    fetch('<?php echo site_url("Grn/getGRNHistory/"); ?>' + grnId, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' && data.data && data.data.length > 0) {
            let html = '<div class="history-timeline">';
            
            data.data.forEach(item => {
                const noteHtml = item.note ? `<div class="text-muted fs-11 mt-1 ps-4">Note: ${escapeHtml(item.note)}</div>` : '';
                
                html += `
                    <div class="history-item mb-3 ${item.action}">
                        <div class="d-flex align-items-start gap-2">
                            <div class="history-icon mt-1">
                                <i class="${item.icon} text-${item.color} fs-14"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <strong class="fs-13">${item.action_text}</strong>
                                    <small class="text-muted fs-11">${item.action_date}</small>
                                </div>
                                <div class="fs-12 text-muted">by ${item.action_by}</div>
                                ${noteHtml}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            container.innerHTML = html;
        } else {
            container.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="ri-history-line fs-3 mb-2 d-block"></i>
                    <div class="fs-12">No history available</div>
                    <div class="fs-11 text-muted mt-1">Actions will appear here as GRN progresses</div>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading GRN history:', error);
        container.innerHTML = `
            <div class="text-center py-3 text-danger fs-12">
                <i class="ri-error-warning-line me-1"></i>
                Failed to load history
            </div>
        `;
    });
}

// FIX: Load GRN Summary (including stock impact)
function loadGRNSummaryFixed(grnId) {
    if (!grnId) return;
    
    fetch('<?php echo site_url("Grn/getGRNSummary/"); ?>' + grnId, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' && data.data) {
            const summary = data.data;
            
            // Update summary card
            document.getElementById('summary-grn-number').textContent = summary.grn_number || '--';
            document.getElementById('summary-status').textContent = summary.status ? summary.status.toUpperCase() : 'DRAFT';
            document.getElementById('summary-created-by').textContent = summary.created_by || '--';
            document.getElementById('summary-created-on').textContent = summary.created_on || '--';
            document.getElementById('summary-total-items').textContent = summary.total_items || 0;
            document.getElementById('summary-total-qty').textContent = summary.total_qty || 0;
            document.getElementById('summary-grand-total').textContent = fmtLKR(summary.grand_total || 0);
            
            // Update status badge class
            const statusBadge = document.getElementById('summary-status');
            if (statusBadge) {
                statusBadge.className = `badge grn-status-badge badge-${summary.status || 'draft'}`;
            }
            
            // Update workflow steps
            updateWorkflowSteps(summary.status);
            
            // Update stock impact preview if items exist
            if (window.pendingGRNItems && window.pendingGRNItems.length > 0) {
                updateStockImpactPreviewFixed(window.pendingGRNItems);
            }
        }
    })
    .catch(error => {
        console.error('Error loading GRN summary:', error);
    });
}

// FIX: Update Stock Impact Preview
function updateStockImpactPreviewFixed(items) {
    const tbody = document.getElementById('stock-summary-body');
    if (!tbody) return;
    
    if (!items || items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted">No items added</tr>';
        return;
    }
    
    // First, fetch current stock for each product
    const productIds = [...new Set(items.map(item => item.product_id))];
    
    // Create a map to store stock data
    const stockMap = {};
    let pendingRequests = productIds.length;
    
    if (productIds.length === 0) {
        renderStockTable(items, stockMap);
        return;
    }
    
    productIds.forEach(productId => {
        fetch('<?php echo site_url("Grn/getProductDetails"); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + encodeURIComponent(productId),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                stockMap[productId] = {
                    stock: data.stock || 0,
                    unit: data.unit || 'pcs'
                };
            } else {
                stockMap[productId] = { stock: 0, unit: 'pcs' };
            }
            pendingRequests--;
            
            if (pendingRequests === 0) {
                renderStockTable(items, stockMap);
            }
        })
        .catch(error => {
            console.error('Error fetching stock for product:', productId, error);
            stockMap[productId] = { stock: 0, unit: 'pcs' };
            pendingRequests--;
            
            if (pendingRequests === 0) {
                renderStockTable(items, stockMap);
            }
        });
    });
    
    function renderStockTable(items, stockMap) {
        let html = '';
        
        items.forEach(item => {
            const productId = item.product_id;
            const stockData = stockMap[productId] || { stock: 0, unit: 'pcs' };
            const product = window.productsByIdGlobal ? window.productsByIdGlobal[productId] : null;
            const productName = product ? product.name : 'Product ID: ' + productId;
            
            const incomingQty = (parseFloat(item.quantity) || 0) + (parseFloat(item.free_quantity) || 0);
            const currentStock = stockData.stock;
            const afterStock = currentStock + incomingQty;
            const unit = stockData.unit;
            
            html += `
                <tr>
                    <td class="fw-semibold">${escapeHtml(productName)}</td>
                    <td class="text-center">${currentStock} ${unit}</td>
                    <td class="text-center text-success">+${incomingQty} ${unit}</td>
                    <td class="text-center fw-semibold ${afterStock > currentStock ? 'text-success' : ''}">${afterStock} ${unit}</td>
                </tr>
            `;
        });
        
        tbody.innerHTML = html;
    }
}

// Override processLoadedGRNData to also load history and summary
const originalProcessLoadedGRNData2 = window.processLoadedGRNData;
window.processLoadedGRNData = function() {
    console.log('FINAL OVERRIDE processLoadedGRNData called');
    
    if (originalProcessLoadedGRNData2) {
        originalProcessLoadedGRNData2();
    }
    
    // Load all components after GRN data is processed
    if (window.pendingGRNId) {
        setTimeout(function() {
            loadGRNHistoryFixed(window.pendingGRNId);
            loadGRNSummaryFixed(window.pendingGRNId);
            
            // Update stock impact preview with items
            if (window.pendingGRNItems && window.pendingGRNItems.length > 0) {
                updateStockImpactPreviewFixed(window.pendingGRNItems);
            }
        }, 300);
    }
};

// Also make sure updateWorkflowSteps is defined
function updateWorkflowSteps(status) {
    const steps = document.querySelectorAll('.grn-step');
    if (!steps.length) return;
    
    steps.forEach(step => {
        step.classList.remove('active', 'done');
    });
    
    let currentStepIndex = 0;
    switch(status) {
        case 'new': currentStepIndex = 0; break;
        case 'draft': currentStepIndex = 1; break;
        case 'submitted': currentStepIndex = 2; break;
        case 'approved': currentStepIndex = 4; break;
        case 'rejected': currentStepIndex = 1; break;
        default: currentStepIndex = 0;
    }
    
    steps.forEach((step, index) => {
        if (index < currentStepIndex) {
            step.classList.add('done');
        } else if (index === currentStepIndex) {
            step.classList.add('active');
        }
    });
}

// Force reload if GRN ID is present
if (window.pendingGRNId) {
    setTimeout(function() {
        loadGRNHistoryFixed(window.pendingGRNId);
        loadGRNSummaryFixed(window.pendingGRNId);
        if (window.pendingGRNItems) {
            updateStockImpactPreviewFixed(window.pendingGRNItems);
        }
    }, 500);
} 
</script>

<script>
    // Permission flags from PHP
    var CAN_APPROVE_GRN = <?= isset($can_approve_grn) ? ($can_approve_grn ? 'true' : 'false') : 'false' ?>;
    var CAN_REJECT_GRN = <?= isset($can_reject_grn) ? ($can_reject_grn ? 'true' : 'false') : 'false' ?>;
    var USER_TYPE_ID = <?= isset($user_type_id) ? $user_type_id : '0' ?>;
    
    console.log('User Type ID:', USER_TYPE_ID);
    console.log('Can Approve:', CAN_APPROVE_GRN);
    console.log('Can Reject:', CAN_REJECT_GRN);
</script>