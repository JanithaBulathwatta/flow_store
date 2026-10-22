<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- PO Custom Styles -->
        <style>
            .po-status-badge { font-size: 0.75rem; padding: 0.35em 0.8em; border-radius: 30px; letter-spacing: 0.04em; }
            .supplier-summary-card { background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%); border: 1px solid #d0deff; border-radius: 10px; }
            .items-table th { background-color: #f8f9fa; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.06em; color: #6c757d; white-space: nowrap; }
            .items-table td { vertical-align: middle; }
            .items-table .qty-input { width: 80px; text-align: center; }
            .items-table .price-input { width: 110px; }
            .totals-card { background: #f8f9fb; border: 1px solid #e9ecef; border-radius: 10px; }
            .totals-card .total-row { display: flex; justify-content: space-between; align-items: center; padding: 0.55rem 0; border-bottom: 1px dashed #dee2e6; font-size: 0.875rem; }
            .totals-card .total-row:last-child { border-bottom: none; }
            .totals-card .grand-total-row { background: linear-gradient(135deg, var(--primary-color, #405189), #6172b0); color: #fff; border-radius: 8px; padding: 0.75rem 1rem; margin-top: 0.5rem; }
            .section-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; }
            .section-header .section-icon { width: 32px; height: 32px; background: linear-gradient(135deg, #405189, #6172b0); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.875rem; flex-shrink: 0; }
            .section-header h6 { margin: 0; font-weight: 600; font-size: 0.925rem; }
            .po-step-bar { display: flex; align-items: center; gap: 0; }
            .po-step { display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; padding: 0.3rem 0.8rem; background: #f0f0f0; color: #888; }
            .po-step.active { background: #405189; color: #fff; }
            .po-step.done { background: #d4edda; color: #155724; }
            .po-step:first-child { border-radius: 20px 0 0 20px; }
            .po-step:last-child { border-radius: 0 20px 20px 0; }
            .badge-draft { background: #e9ecef; color: #495057; }
            .badge-submitted { background: #fff3cd; color: #856404; }
            .badge-approved { background: #d1e7dd; color: #0f5132; }
            .badge-rejected { background: #f8d7da; color: #842029; }
            .po-number-badge { background: #eef2ff; color: #3d52a0; border: 1px solid #c5cff7; border-radius: 8px; padding: 0.25rem 0.75rem; font-size: 0.875rem; font-weight: 600; font-family: monospace; }
			 
			#inline-product{
				height: 32px !important;
				background: white !important;
			}
		</style>

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-semibold fs-18 mb-1">Purchase Order</h1>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="po-number-badge" id="po-number-display">
                        <i class="ri-file-list-3-line me-1"></i>Loading...
                    </span>
                    <input type="hidden" id="hidden-po-id" value="">
                    <input type="hidden" id="hidden-po-number" value="">
                    <span class="badge po-status-badge" id="summary-status">Draft</span>
                    <div class="po-step-bar ms-2">
                        <span class="po-step done"><i class="ri-check-line me-1"></i>New</span>
                        <span class="po-step active"><i class="ri-edit-line me-1"></i>Draft</span>
                        <span class="po-step">Submit</span>
                        <span class="po-step">Review</span>
                        <span class="po-step">Approve</span>
                        <span class="po-step">Receive</span>
                    </div>
                </div>
            </div>
            <div class="ms-md-1 ms-0 mt-md-0 mt-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Purchase</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">PO</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <!-- Start PO Create Content -->
        <div class="row g-3">

            <!-- LEFT COLUMN (Main) -->
            <div class="col-xl-9 col-lg-12">

                <!-- SECTION 1: PO Header Fields -->
                <div class="card custom-card mb-3">
                    <div class="card-header">
                        <div class="section-header mb-0">
                            <span class="section-icon"><i class="ri-file-list-3-line"></i></span>
                            <h6>Purchase Order Information</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-6 col-xl-4">
                                <label class="form-label fw-medium fs-13">Supplier <span class="text-danger">*</span></label>
                                <select class="form-control" id="po-supplier">
                                    <option value="">-- Select Supplier --</option>
                                    <?php foreach($sup as $item): ?>
                                        <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
							
							<!--<div class="col-sm-6 col-xl-4">
                                <label class="form-label fw-medium fs-13">Prepared By<span class="text-danger">*</span></label>
                                <select class="form-control" name="staff_id" id="po-staff">
                                    <option value="">-- Select Prepared By --</option>
                                    <?php foreach($staff as $item): ?>
                                        <option value="<?= $item->staff_id ?>"><?= $item->full_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>-->
							
                            <div class="col-sm-6 col-xl-4">
                                <label class="form-label fw-medium fs-13">Warehouse</label>
                                <select class="form-control" id="po-warehouse">
                                    <option value="">-- Select Warehouse --</option>
                                    <?php foreach($stores as $item): ?>
                                        <option value="<?= $item->store_id ?>"><?= $item->store_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <label class="form-label fw-medium fs-13">PO Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="po-date" placeholder="Select date">
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <label class="form-label fw-medium fs-13">Expected Delivery Date</label>
                                <input type="text" class="form-control" id="po-expected-delivery" placeholder="Select date">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium fs-13">Remarks</label>
                                <textarea class="form-control" id="po-remarks" rows="2" placeholder="Any notes about this purchase order..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Items Table -->
				<div class="card custom-card mb-3"> 
					<div class="card-header">
						<div class="section-header mb-0">
							<span class="section-icon"><i class="ri-list-check-3"></i></span>
							<h6>Items</h6>
						</div>
					</div>
					<div class="card-body">
						<!-- Add Product Form - ABOVE the table -->
						<div class="row g-2 mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
							<div class="col-md-4">
								<label class="form-label fw-medium fs-12 mb-1">Product <span class="text-danger">*</span></label>
								<select class="form-control form-control-sm" id="inline-product">
									<option value="">-- Select Product --</option>
									<?php foreach($products as $item): ?>
										<option value="<?= $item->id ?>" data-price="<?= $item->price ?>" data-name="<?= htmlspecialchars($item->name) ?>">
											<?= htmlspecialchars($item->name) ?> - LKR <?= number_format($item->price, 2) ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-md-2">
								<label class="form-label fw-medium fs-12 mb-1">Unit</label>
								<input type="text" class="form-control form-control-sm" id="inline-unit" value="pcs" readonly>
							</div>
							<div class="col-md-2">
								<label class="form-label fw-medium fs-12 mb-1">Quantity <span class="text-danger">*</span></label>
								<input type="number" class="form-control form-control-sm" id="inline-qty" value="1" min="1">
							</div>
							<div class="col-md-2">
								<label class="form-label fw-medium fs-12 mb-1">Unit Price <span class="text-danger">*</span></label>
								<div class="input-group input-group-sm">
									<span class="input-group-text">LKR</span>
									<input type="number" class="form-control" id="inline-price" value="0.00" step="0.01">
								</div>
							</div>
							<div class="col-md-2 d-flex align-items-end">
								<button class="btn btn-success btn-sm w-100" id="btn-inline-add">
									<i class="ri-add-line me-1"></i> Add Product
								</button>
							</div>
							<div class="col-12 mt-2" id="inline-preview" style="display: none;">
								<div class="alert alert-primary-transparent mb-0 py-2 d-flex justify-content-between align-items-center">
									<span class="fs-12 fw-medium">Line Total Preview:</span>
									<span class="fs-13 fw-bold text-primary" id="inline-line-total">LKR 0.00</span>
								</div>
							</div>
						</div>
						
						<!-- Items Table -->
						<div class="table-responsive">
							<table class="table items-table mb-0 text-nowrap">
								<thead>
									<tr>
										<th style="width:32px;">#</th>
										<th style="min-width:180px;">Product</th>
										<th>Unit</th>
										<th>Qty</th>
										<th>Unit Price</th>
										<th>Line Total</th>
										<th style="width:100px;">Actions</th>
									</tr>
								</thead>
								<tbody id="po-items-tbody">
									<!-- Dynamically populated -->
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<div class="row justify-content-end">
							<div class="col-md-16">
								<div class="totals-card p-3">
									<div class="total-row">
										<span class="text-muted">Subtotal</span>
										<span class="fw-medium" id="po-subtotal">LKR 0.00</span>
									</div>
									<div class="grand-total-row d-flex justify-content-between align-items-center">
										<span class="fw-bold fs-14">Grand Total</span>
										<span class="fw-bold fs-16" id="po-grand-total">LKR 0.00</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

                <!-- ACTION BUTTONS -->
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

            <!-- RIGHT COLUMN (Sidebar) -->
            <div class="col-xl-3 col-lg-12">

                <!-- PO Summary Card -->
                <div class="card custom-card mb-3">
                    <div class="card-header">
                        <div class="section-header mb-0">
                            <span class="section-icon"><i class="ri-information-line"></i></span>
                            <h6>PO Summary</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">PO Number</span>
                                <span class="fw-semibold font-monospace" id="summary-po-number">Loading...</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Status</span>
                                <span class="badge po-status-badge" id="summary-status">Draft</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Created By</span>
                                <span class="fw-semibold" id="summary-created-by">--</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Created On</span>
                                <span class="fw-semibold" id="summary-created-on"><?= date('d M Y') ?></span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Total Items</span>
                                <span class="badge bg-primary-transparent text-primary" id="summary-total-items">0</span>
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
                            <li class="d-flex align-items-center gap-2 mb-2" data-check="date">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                <span>PO Date set</span>
                            </li>
                            <li class="d-flex align-items-center gap-2 mb-2" data-check="items">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                <span>At least one item added</span>
                            </li>
                            <li class="d-flex align-items-center gap-2" data-check="quantities">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                <span>All quantities > 0</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- PO History / Audit Log -->
                <div class="card custom-card mb-3">
                    <div class="card-header">
                        <div class="section-header mb-0">
                            <span class="section-icon" style="background:linear-gradient(135deg,#6c757d,#495057)!important;"><i class="ri-history-line"></i></span>
                            <h6>PO History</h6>
                        </div>
                    </div>
                    <div class="card-body" id="po-history-container">
                        <div class="text-center py-3 text-muted fs-12">
                            <div class="spinner-border spinner-border-sm me-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Loading history...
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- MODAL: Add Item -->
        <div class="modal fade" id="modalAddItem" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title fw-semibold"><i class="ri-add-circle-line me-2 text-success"></i>Add Product to PO</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-medium fs-13">Product <span class="text-danger">*</span></label>
                                <select class="form-control form-select" id="modal-product">
                                    <option value="">-- Search & Select Product --</option>
                                    <?php foreach($products as $item): ?>
                                        <option value="<?= $item->id ?>"><?= $item->name ?> - LKR <?= number_format($item->price, 2) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-medium fs-13">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="modal-qty" value="1" min="1">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-medium fs-13">Unit Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text fs-12">LKR</span>
                                    <input type="number" class="form-control" id="modal-price" value="0.00" step="0.01">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label fw-medium fs-13">Unit</label>
                                <input type="text" class="form-control" id="modal-unit" value="pcs" readonly>
                            </div>
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
                        <button class="btn btn-success btn-sm" id="btn-add-to-po">
                            <i class="ri-check-line me-1"></i> Add to PO
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL: Reject PO -->
        <div class="modal fade" id="modalReject" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h6 class="modal-title fw-semibold text-danger"><i class="ri-close-circle-line me-2"></i>Reject PO</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger-transparent py-2 fs-13 mb-3">
                            <i class="ri-error-warning-line me-1"></i> Rejecting this PO will return it for correction. A reason is required.
                        </div>
                        <label class="form-label fw-medium fs-13">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="4" placeholder="Please describe the reason for rejection..." id="reject-reason"></textarea>
                        <div class="fs-12 text-muted mt-1">This message will be visible to the creator in PO history.</div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger btn-sm" id="btn-confirm-reject">
                            <i class="ri-close-circle-line me-1"></i> Confirm Rejection
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL: Approve Confirmation -->
        <div class="modal fade" id="modalApprove" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h6 class="modal-title fw-semibold text-success"><i class="ri-checkbox-circle-line me-2"></i>Approve PO</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success-transparent py-2 fs-13 mb-3">
                            <i class="ri-information-line me-1"></i> Approving this PO will update product last purchase prices.
                        </div>
                        <ul class="list-group list-group-flush fs-13 mb-0">
                            <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">PO Number</span><strong id="approve-po-number">--</strong></li>
                            <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">Supplier</span><strong id="approve-supplier">--</strong></li>
                            <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">Grand Total</span><strong class="text-primary" id="approve-grand-total">LKR 0.00</strong></li>
                            <li class="list-group-item px-0 d-flex justify-content-between"><span class="text-muted">Total Items</span><strong id="approve-total-items">0</strong></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success btn-sm" id="btn-confirm-approve">
                            <i class="ri-checkbox-circle-line me-1"></i> Confirm Approval
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
// ============================================
// PERMISSION SCRIPT - DEFINED ONCE AT THE TOP
// ============================================
var CAN_APPROVE_PO = <?= isset($can_approve_po) ? ($can_approve_po ? 'true' : 'false') : 'false' ?>;
var CAN_REJECT_PO = <?= isset($can_reject_po) ? ($can_reject_po ? 'true' : 'false') : 'false' ?>;
var UT_ID = <?= isset($ut_id) ? (int)$ut_id : 0 ?>;
var IS_OWNER = <?= isset($is_owner) ? ($is_owner == 1 ? 'true' : 'false') : 'false' ?>;

console.log('=== PO PERMISSION DEBUG ===');
console.log('UT_ID (User Type ID):', UT_ID);
console.log('Is Owner:', IS_OWNER);
console.log('Can Approve PO:', CAN_APPROVE_PO);
console.log('Can Reject PO:', CAN_REJECT_PO);

</script> 
            `
<script>
// ============================================
// MAIN SCRIPT - Using same pattern as GRN
// ============================================ 

$('#po-supplier').val('');
 
// Global helper functions
function showToast(msg, type) {
    if (!type) type = 'primary';
    const colors = { primary: '#405189', success: '#25b865', danger: '#dc3545', warning: '#f7b731', info: '#0dcaf0' };
    const container = document.getElementById('toast-container') || (function() {
        var d = document.createElement('div');
        d.id = 'toast-container';
        d.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;';
        document.body.appendChild(d);
        return d;
    })();
    var toast = document.createElement('div');
    toast.style.cssText = 'background:' + (colors[type] || colors.primary) + ';color:#fff;padding:12px 18px;border-radius:8px;font-size:13px;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,0.2);max-width:320px;opacity:0;transform:translateY(8px);transition:all 0.25s;z-index:9999;';
    toast.innerHTML = '<i class="ri-checkbox-circle-line me-2"></i>' + msg;
    container.appendChild(toast);
    requestAnimationFrame(function() { toast.style.opacity = 1; toast.style.transform = 'translateY(0)'; });
    setTimeout(function() { toast.style.opacity = 0; setTimeout(function() { toast.remove(); }, 300); }, 3500);
}

// Check if we're opening an existing PO
var urlParams = new URLSearchParams(window.location.search);
var poId = urlParams.get('id');

// Flag to prevent multiple loads
var isLoading = false;

// Product data from PHP
var productsById = {
<?php foreach ($products as $p): ?>
    <?= $p->id ?>: {
        id: <?= $p->id ?>,
        name: '<?= addslashes($p->name) ?>',
        price: <?= floatval($p->price ?? 0) ?>
    },
<?php endforeach; ?>
};

function fmtLKR(n) {
    return 'LKR ' + parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Function to update workflow steps based on status
function updateWorkflowSteps(status) {
    var steps = document.querySelectorAll('.po-step');
    if (!steps.length) return;
    
    steps.forEach(function(step) {
        step.classList.remove('active', 'done');
    });
    
    var currentStepIndex = 0;
    switch(status) {
        case 'new': currentStepIndex = 0; break;
        case 'draft': currentStepIndex = 1; break;
        case 'submitted': currentStepIndex = 2; break;
        case 'approved': currentStepIndex = 4; break;
        case 'rejected': currentStepIndex = 1; break;
        default: currentStepIndex = 0;
    }
    
    steps.forEach(function(step, index) {
        if (index < currentStepIndex) {
            step.classList.add('done');
        } else if (index === currentStepIndex) {
            step.classList.add('active');
        }
    });
}

// ✅ KEY FIX: Same pattern as GRN - check if variable exists with fallback
function setUIModeByStatus(status) {
    var isNew = (status === 'new');
    var isDraft = (status === 'draft');
    var isSubmitted = (status === 'submitted');
    var isApproved = (status === 'approved');
    var isRejected = (status === 'rejected');
    
    // ✅ Same as GRN: Check if variables exist with fallback to false
    var canApprove = (typeof CAN_APPROVE_PO !== 'undefined' && CAN_APPROVE_PO === true);
    var canReject = (typeof CAN_REJECT_PO !== 'undefined' && CAN_REJECT_PO === true);
    
    console.log('setUIModeByStatus - Status:', status);
    console.log('setUIModeByStatus - Can Approve:', canApprove, 'Can Reject:', canReject);
    
    // Update status badge
    var statusBadge = document.getElementById('summary-status');
    if (statusBadge) {
        var displayStatus = status === 'new' ? 'NEW' : (status ? status.toUpperCase() : 'DRAFT');
        statusBadge.textContent = displayStatus;
        statusBadge.className = 'badge po-status-badge badge-' + (status === 'new' ? 'new' : (status || 'draft'));
    }
    
    if(isNew || isDraft) {
        $('#btn-save-draft, #btn-submit-approval').show();
        $('#btn-approve, #btn-reject').hide();
        $('input, select, textarea, .btn-success[data-bs-target="#modalAddItem"]').prop('disabled', false);
        $('.btn-danger-light').show();
        updateWorkflowSteps(isNew ? 'new' : 'draft');
    } 
    else if(isSubmitted) {
        $('#btn-save-draft, #btn-submit-approval').hide();
        
        if (canApprove) {
            $('#btn-approve').show();
            console.log('Showing Approve button');
        } else {
            $('#btn-approve').hide();
            console.log('Hiding Approve button');
        }
        
        if (canReject) {
            $('#btn-reject').show();
            console.log('Showing Reject button');
        } else {
            $('#btn-reject').hide();
            console.log('Hiding Reject button');
        }
        
        $('input, select, textarea, .btn-success[data-bs-target="#modalAddItem"]').prop('disabled', false);
        $('.btn-danger-light').show();
        updateWorkflowSteps('submitted');
    }
    else if(isApproved) {
        $('#btn-save-draft, #btn-submit-approval, #btn-approve, #btn-reject').hide();
        $('input, select, textarea, .btn-success[data-bs-target="#modalAddItem"]').prop('disabled', true);
        $('.btn-danger-light').hide();
        updateWorkflowSteps('approved');
    }
    else if(isRejected) {
        $('#btn-save-draft, #btn-submit-approval, #btn-approve, #btn-reject').hide();
        $('input, select, textarea, .btn-success[data-bs-target="#modalAddItem"]').prop('disabled', true);
        $('.btn-danger-light').hide();
        updateWorkflowSteps('rejected');
    }
}

// PO Items array
var poItems = [];
var nextItemId = 1;
var currentPOId = null;
var currentPONumber = null;

function renderItemsTable() {
    var tbody = document.getElementById('po-items-tbody');
    if (!tbody) return;
    
    if (poItems.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-3">No items added yet<\/td><\/tr>';
        return;
    }
    
    var html = '';
    for (var i = 0; i < poItems.length; i++) {
        var item = poItems[i];
        var lineTotal = (item.qty || 0) * (item.price || 0);
        html += '<tr data-item-id="' + item.id + '">' +
            '<td class="text-muted fs-12">' + (i + 1) + '<\/td>' +
            '<td><div class="fw-semibold fs-13">' + escapeHtml(item.name) + '<\/div>' +
            '<div class="fs-11 text-muted">ID: ' + item.productId + '<\/div><\/td>' +
            '<td><span class="badge bg-light text-dark">' + escapeHtml(item.unit || 'pcs') + '<\/span><\/td>' +
            '<td><input type="number" class="form-control qty-input" value="' + item.qty + '" min="1" style="width:80px" onchange="updateItemQty(' + item.id + ', this.value)"><\/td>' +
            '<td><input type="number" class="form-control price-input" value="' + item.price.toFixed(2) + '" step="0.01" style="width:110px" onchange="updateItemPrice(' + item.id + ', this.value)"><\/td>' +
            '<td class="fw-semibold text-end">' + fmtLKR(lineTotal) + '<\/td>' +
            '<td><button class="btn btn-sm btn-icon btn-danger-light" title="Delete" onclick="deleteItem(' + item.id + ')"><i class="ri-delete-bin-5-line"><\/i><\/button><\/td>' +
            '<\/tr>';
    }
    tbody.innerHTML = html;
    updateTotals();
    updateValidationChecklist();
}

function updateTotals() {
    var subtotal = 0;
    for (var i = 0; i < poItems.length; i++) {
        subtotal += (poItems[i].qty || 0) * (poItems[i].price || 0);
    }
    
    var subtotalEl = document.getElementById('po-subtotal');
    var grandTotalEl = document.getElementById('po-grand-total');
    var totalItemsEl = document.getElementById('summary-total-items');
    var summaryGrandEl = document.getElementById('summary-grand-total');
    
    if (subtotalEl) subtotalEl.textContent = fmtLKR(subtotal);
    if (grandTotalEl) grandTotalEl.textContent = fmtLKR(subtotal);
    if (totalItemsEl) totalItemsEl.textContent = poItems.length;
    if (summaryGrandEl) summaryGrandEl.textContent = fmtLKR(subtotal);
}

function updateValidationChecklist() {
    var supplierValid = !!document.getElementById('po-supplier').value;
    var dateValid = !!document.getElementById('po-date').value;
    var hasItems = poItems.length > 0;
    var allQtyValid = hasItems ? poItems.every(function(i) { return (i.qty || 0) > 0; }) : false;
    
    var checks = { supplier: supplierValid, date: dateValid, items: hasItems, quantities: allQtyValid };
    var keys = Object.keys(checks);
    for (var i = 0; i < keys.length; i++) {
        var key = keys[i];
        var li = document.querySelector('[data-check="' + key + '"]');
        if (li) {
            var text = li.querySelector('span') ? li.querySelector('span').textContent : key;
            if (checks[key]) {
                li.innerHTML = '<i class="ri-checkbox-circle-fill text-success"><\/i><span>' + text + '<\/span>';
            } else {
                li.innerHTML = '<i class="ri-error-warning-fill text-warning"><\/i><span>' + text + '<\/span>';
            }
        }
    }
}

window.updateItemQty = function(id, val) {
    for (var i = 0; i < poItems.length; i++) {
        if (poItems[i].id === id) {
            poItems[i].qty = Math.max(1, parseInt(val) || 1);
            break;
        }
    }
    renderItemsTable();
};

window.updateItemPrice = function(id, val) {
    for (var i = 0; i < poItems.length; i++) {
        if (poItems[i].id === id) {
            poItems[i].price = Math.max(0, parseFloat(val) || 0);
            break;
        }
    }
    renderItemsTable();
};

window.deleteItem = function(id) {
	
	//coded by pubudu anuradha replace traditional confirm box into custom confirm box   
	$.confirmBox({
		title: 'Remove Item',
		head: 'Are you sure?',
		para: 'The Selected Item Will be removed.',

		onConfirm: function(close){
			var newItems = [];
			for (var i = 0; i < poItems.length; i++) {
				if (poItems[i].id !== id) {
					newItems.push(poItems[i]);
				}
			}
			poItems = newItems;
			renderItemsTable();
			close();
		}
	});
	
	//commented by pubudu Anuradha traditional confirm 
    /*if (confirm('Remove this item?')) {
        var newItems = [];
        for (var i = 0; i < poItems.length; i++) {
            if (poItems[i].id !== id) {
                newItems.push(poItems[i]);
            }
        }
        poItems = newItems;
        renderItemsTable();
    }*/
};

function collectPOData() {
    var supplierId = document.getElementById('po-supplier').value;
    //var staffId = document.getElementById('po-staff').value;
    var warehouseId = document.getElementById('po-warehouse').value;
    var poDate = document.getElementById('po-date').value;
    var expectedDate = document.getElementById('po-expected-delivery').value;
    var remarks = document.getElementById('po-remarks').value;
    
    var subtotal = 0;
    for (var i = 0; i < poItems.length; i++) {
        subtotal += (poItems[i].qty || 0) * (poItems[i].price || 0);
    }
    
    if (poDate && poDate.includes('/')) {
        var parts = poDate.split('/');
        poDate = parts[2] + '-' + parts[1] + '-' + parts[0];
    }
    
    var formattedExpectedDate = null;
    if (expectedDate) {
        if (expectedDate.includes('/')) {
            var parts = expectedDate.split('/');
            formattedExpectedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
        } else {
            formattedExpectedDate = expectedDate;
        }
    }
    
    var items = [];
    for (var i = 0; i < poItems.length; i++) {
        items.push({
            product_id: poItems[i].productId,
            unit_id: 1,
            quantity: poItems[i].qty,
            unit_price: poItems[i].price,
            discount_value: 0,
            discount_type: 'amount',
            tax_value: 0,
            line_total: poItems[i].qty * poItems[i].price
        });
    }
    
    return {
        po_id: currentPOId,
        po_number: currentPONumber,
        supplier_id: parseInt(supplierId) || null,
        //staff_id: parseInt(staffId) || null,
        warehouse_id: warehouseId ? parseInt(warehouseId) : null,
        po_date: poDate,
        expected_delivery_date: formattedExpectedDate,
        remarks: remarks || null,
        subtotal: subtotal,
        discount_value: 0,
        discount_type: 'amount',
        tax_total: 0,
        grand_total: subtotal,
        items: items
    };
}

function loadPOSummary(poId) {
    if (!poId) return;
    
    fetch('<?= site_url("Po/getPOSummary?po_id=") ?>' + poId, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.status === 'success' && data.data) {
            var summary = data.data;
            var poNumberEl = document.getElementById('summary-po-number');
            if (poNumberEl) poNumberEl.textContent = summary.po_number || '--';
            
            var statusBadge = document.getElementById('summary-status');
            if (statusBadge) {
                statusBadge.textContent = summary.status ? summary.status.toUpperCase() : 'DRAFT';
                statusBadge.className = 'badge po-status-badge badge-' + (summary.status || 'draft');
            }
            
            var createdByEl = document.getElementById('summary-created-by');
            if (createdByEl) createdByEl.textContent = summary.created_by || '--';
            
            var createdOnEl = document.getElementById('summary-created-on');
            if (createdOnEl) createdOnEl.textContent = summary.created_on || '--';
            
            var totalItemsEl = document.getElementById('summary-total-items');
            if (totalItemsEl) totalItemsEl.textContent = summary.total_items || 0;
            
            var grandTotalEl = document.getElementById('summary-grand-total');
            if (grandTotalEl) grandTotalEl.textContent = fmtLKR(summary.grand_total || 0);
        }
    })
    .catch(function(e) { console.error('Error loading PO summary:', e); });
}

function loadPOHistory(poId) {
    if (!poId) {
        var container = document.getElementById('po-history-container');
        if (container) container.innerHTML = '<div class="text-center py-3 text-muted fs-12">No PO selected</div>';
        return;
    }
    
    var container = document.getElementById('po-history-container');
    container.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm me-2"></div>Loading history...</div>';
    
    fetch('<?= site_url("Po/getPOHistory?po_id=") ?>' + poId, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.status === 'success' && data.data && data.data.length > 0) {
            var html = '<div class="history-timeline">';
            for (var i = 0; i < data.data.length; i++) {
                var item = data.data[i];
                html += '<div class="history-item ' + item.action + ' mb-3">' +
                    '<div class="d-flex justify-content-between align-items-center">' +
                        '<strong class="fs-12">' + item.action_text + '</strong>' +
                        '<small class="text-muted fs-11">' + item.action_date + '</small>' +
                    '</div>' +
                    '<div class="text-muted fs-11">by ' + item.action_by + '</div>';
                if (item.note) {
                    html += '<div class="small text-muted mt-1">Note: ' + escapeHtml(item.note) + '</div>';
                }
                html += '</div>';
            }
            html += '</div>';
            container.innerHTML = html;
        } else {
            container.innerHTML = '<div class="text-center py-3 text-muted fs-12">No history available</div>';
        }
    })
    .catch(function(e) {
        console.error('Error loading PO history:', e);
        container.innerHTML = '<div class="text-center py-3 text-muted fs-12">Unable to load history</div>';
    });
}

function loadPODataById(id) {
    if(isLoading) return;
    isLoading = true;
    
    console.log('loadPODataById called with ID:', id);
    showToast('Loading PO...', 'info');
    
    $.ajax({
        url: '<?= site_url("Po/list") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            console.log('List response:', res);
            if (res.status === 'success' && res.data) {
                var po = null;
                for (var i = 0; i < res.data.length; i++) {
                    if (res.data[i].id == id) {
                        po = res.data[i];
                        break;
                    }
                }
                if (po) {
                    $.ajax({
                        url: '<?= site_url("Po/get_po_items") ?>',
                        type: 'GET',
                        dataType: 'json',
                        data: { po_id: id },
                        success: function(itemsRes) {
                            if (itemsRes.status === 'success') po.items = itemsRes.data;
                            loadExistingPOData(po);
                            setUIModeByStatus(po.status);
                        },
                        error: function() {
                            loadExistingPOData(po);
                            setUIModeByStatus(po.status);
                        }
                    });
                } else {
                    showToast('PO not found', 'danger');
                    createNewDraftPO();
                }
            } else {
                showToast('Failed to load PO', 'danger');
                createNewDraftPO();
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            showToast('Error loading PO: ' + error, 'danger');
            createNewDraftPO();
        },
        complete: function() { isLoading = false; }
    });
}

function loadExistingPOData(po) {
    console.log('loadExistingPOData called with PO:', po);
    
    if (!po || !po.id) {
        createNewDraftPO();
        return;
    }
    
    currentPOId = po.id;
    currentPONumber = po.po_number;
    
    document.getElementById('hidden-po-id').value = currentPOId;
    document.getElementById('hidden-po-number').value = currentPONumber;
    document.getElementById('po-number-display').innerHTML = '<i class="ri-file-list-3-line me-1"></i>' + currentPONumber;
    
    if (po.supplier_id)
		$('#po-supplier').val(po.supplier_id);
    if (po.warehouse_id) $('#po-warehouse').val(po.warehouse_id);
    
    if (po.order_date || po.po_date) {
        var poDate = po.order_date || po.po_date;
        if (poDate && !poDate.includes('/')) {
            var dateParts = poDate.split('-');
            if (dateParts.length === 3) poDate = dateParts[2] + '/' + dateParts[1] + '/' + dateParts[0];
        }
        $('#po-date').val(poDate);
    }
    
    if (po.expected_date || po.expected_delivery_date) {
        var expectedDate = po.expected_date || po.expected_delivery_date;
        if (expectedDate && !expectedDate.includes('/')) {
            var dateParts = expectedDate.split('-');
            if (dateParts.length === 3) expectedDate = dateParts[2] + '/' + dateParts[1] + '/' + dateParts[0];
        }
        $('#po-expected-delivery').val(expectedDate);
    }
    
    if (po.remarks) $('#po-remarks').val(po.remarks);
    
    if (po.items && po.items.length) {
        poItems = [];
        nextItemId = 1;
        for (var i = 0; i < po.items.length; i++) {
            var item = po.items[i];
            var product = productsById[item.product_id];
            poItems.push({
                id: nextItemId++,
                productId: item.product_id,
                name: product ? product.name : (item.product_name || 'Unknown'),
                unit: 'pcs',
                qty: parseFloat(item.quantity),
                price: parseFloat(item.unit_price)
            });
        }
        renderItemsTable();
    } else {
        poItems = [];
        renderItemsTable();
    }
    
    if (currentPOId) {
        loadPOSummary(currentPOId);
        loadPOHistory(currentPOId);
    }
    
    updateValidationChecklist();
    showToast('PO ' + currentPONumber + ' loaded successfully', 'success');
}

function createNewDraftPO() {
    fetch('<?= site_url("Po/generatePONumber") ?>', {
        method: 'GET', 
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.status === 'success') {
            currentPOId = data.data.po_id;
            currentPONumber = data.data.po_number;
            document.getElementById('po-number-display').innerHTML = '<i class="ri-file-list-3-line me-1"></i>' + currentPONumber;
            document.getElementById('hidden-po-id').value = currentPOId;
            document.getElementById('hidden-po-number').value = currentPONumber;
            setUIModeByStatus('new');
            showToast('New PO created: ' + currentPONumber, 'success');
        } else {
            showToast(data.msg || 'Failed to create draft PO', 'danger');
        }
    })
    .catch(function(error) {
        console.error('Error creating draft:', error);
        showToast('Error creating new PO', 'danger');
    });
}

function updateModalLineTotal() {
    var qty = parseFloat(document.getElementById('modal-qty') ? document.getElementById('modal-qty').value : 0) || 0;
    var price = parseFloat(document.getElementById('modal-price') ? document.getElementById('modal-price').value : 0) || 0;
    var lineTotalEl = document.getElementById('modal-line-total');
    if (lineTotalEl) lineTotalEl.textContent = fmtLKR(qty * price);
}

function closeModal(modalElement) {
    if (!modalElement) return;
    var modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) modal.hide();
    setTimeout(function() {
        var backdrops = document.querySelectorAll('.modal-backdrop');
        for (var i = 0; i < backdrops.length; i++) backdrops[i].remove();
        document.body.classList.remove('modal-open');
    }, 100);
}

$(document).ready(function() {
	//select 2 plugin 
	$('#inline-product').select2({
        placeholder: '-- Select Product --',
        allowClear: true,
        width: '100%'
    });
	
    if (window.flatpickr) {
        flatpickr('#po-date', { dateFormat: 'd/m/Y', defaultDate: 'today' });
        flatpickr('#po-expected-delivery', { dateFormat: 'd/m/Y' });
    }
    
    var existingPoId = urlParams.get('id');
    if (existingPoId && existingPoId !== 'null' && existingPoId !== '') {
        loadPODataById(existingPoId);
    } else {
        fetch('<?= site_url("Po/getDraftPO") ?>', {
            method: 'GET', credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.status === 'success' && data.data) {
                loadExistingPOData(data.data);
                setUIModeByStatus(data.data.status);
            } else {
                createNewDraftPO();
            }
        })
        .catch(function() { createNewDraftPO(); });
    }
    
    renderItemsTable();
    
    $('#btn-add-to-po').on('click', function() {
        var productId = parseInt($('#modal-product').val());
        if (!productId) { showToast('Please select a product', 'warning'); return; }
        var prod = productsById[productId];
        if (!prod) { showToast('Product not found', 'warning'); return; }
        var qty = parseInt($('#modal-qty').val()) || 1;
        var price = parseFloat($('#modal-price').val()) || 0;
        if (qty <= 0) { showToast('Quantity must be greater than 0', 'warning'); return; }
        if (price <= 0) { showToast('Unit price must be greater than 0', 'warning'); return; }
        
        var existingItem = null;
        for (var i = 0; i < poItems.length; i++) {
            if (poItems[i].productId === productId) { existingItem = poItems[i]; break; }
        }
        if (existingItem) { showToast('Product already added to this PO', 'warning'); return; }
        
        poItems.push({
            id: nextItemId++,
            productId: productId,
            name: prod.name,
            unit: $('#modal-unit').val() || 'pcs',
            qty: qty,
            price: price
        });
        renderItemsTable();
        closeModal(document.getElementById('modalAddItem'));
        $('#modal-product, #modal-qty, #modal-price, #modal-unit').val('');
        $('#modal-qty').val('1');
        $('#modal-price').val('0');
        $('#modal-unit').val('pcs');
        showToast('Product added successfully', 'success');
    });
    
    $('#modalAddItem .btn-secondary, #modalAddItem .btn-close').on('click', function() { closeModal(document.getElementById('modalAddItem')); });
    
    $('#modal-product').on('change', function() {
        var productId = this.value;
        if (!productId) return;
        var prod = productsById[productId];
        if (prod) {
            $('#modal-unit').val('pcs');
            $('#modal-price').val(prod.price || 0);
            updateModalLineTotal();
        }
    });
    // Inline add product functionality
function updateInlineLineTotal() {
    var qty = parseFloat($('#inline-qty').val()) || 0;
    var price = parseFloat($('#inline-price').val()) || 0;
    var lineTotal = qty * price;
    $('#inline-line-total').text(fmtLKR(lineTotal));
    
    // Show preview when values are entered
    if (qty > 0 && price > 0) {
        $('#inline-preview').slideDown(200);
    } else {
        $('#inline-preview').slideUp(200);
    }
}

// Product selection handler for inline form
$('#inline-product').on('change', function() {
    var productId = $(this).val();
    if (!productId) {
        $('#inline-price').val('0.00');
        $('#inline-qty').val('1');
        updateInlineLineTotal();
        return;
    }
    
    var selectedOption = $(this).find('option:selected');
    var price = parseFloat(selectedOption.data('price')) || 0;
    
    $('#inline-price').val(price.toFixed(2));
    $('#inline-qty').val(1);
    updateInlineLineTotal();
});

// Quantity/Price changes
$('#inline-qty, #inline-price').on('input', function() {
    updateInlineLineTotal();
});

// Add button click
$('#btn-inline-add').on('click', function() {
    var productId = parseInt($('#inline-product').val());
    if (!productId) {
        showToast('Please select a product', 'warning');
        return;
    }
    
    var prod = productsById[productId];
    if (!prod) {
        showToast('Product not found', 'warning');
        return;
    }
    
    var qty = parseInt($('#inline-qty').val()) || 1;
    var price = parseFloat($('#inline-price').val()) || 0;
    
    if (qty <= 0) {
        showToast('Quantity must be greater than 0', 'warning');
        return;
    }
    if (price <= 0) {
        showToast('Unit price must be greater than 0', 'warning');
        return;
    }
    
    // Check for duplicate product
    var existingItem = poItems.find(function(i) { return i.productId === productId; });
    if (existingItem) {
        showToast('Product already added to this PO', 'warning');
        return;
    }
    
    // Add the item
    poItems.push({
        id: nextItemId++,
        productId: productId,
        name: prod.name,
        unit: $('#inline-unit').val() || 'pcs',
        qty: qty,
        price: price
    });
    
    renderItemsTable();
    
    // Reset inline form
    $('#inline-product').val('');
    //$('#select2-inline-product-container').html('');
    $('#inline-product').val(null).trigger('change');
	$('#inline-price').val('0.00');
    $('#inline-qty').val('1');
    $('#inline-unit').val('pcs');
    updateInlineLineTotal();
    $('#inline-preview').slideUp(200);
    
    showToast('Product added successfully', 'success');
});
    $('#modal-qty, #modal-price').on('input', updateModalLineTotal);

	$('#btn-save-draft').on('click', function() {
        if (!$('#po-supplier').val()) { showToast('Select supplier', 'warning'); return; }
        if (!$('#po-date').val()) { showToast('Select PO date', 'warning'); return; }
        if (poItems.length === 0) { showToast('Add at least one item', 'warning'); return; }
        
        var poData = collectPOData();
        fetch('<?= site_url("Po/store") ?>', {
            method: 'POST', 
			headers: { 'Content-Type': 'application/json' }, 
			body: JSON.stringify(poData), 
			credentials: 'same-origin'
        }).then(function(r) { return r.json(); }).then(function(data) {
            if (data.status === 'success') {
                if (!currentPOId) currentPOId = data.data.po_id;
                showToast('PO saved as draft', 'success');
                if (currentPOId) { loadPOSummary(currentPOId); loadPOHistory(currentPOId); }
            } else { showToast(data.msg || 'Save failed', 'danger'); }
        }).catch(function() { showToast('Save failed', 'danger'); });
    });
	
    
	//re write above funtion prevent with double submission
	$('#btn-submit-approval').on('click', function() {
		var $btn = $(this);

		// Prevent double submission
		if ($btn.data('submitting')) {
			return;
		}

		if (!$('#po-supplier').val()) { showToast('Select supplier', 'warning'); return; }
		if (!$('#po-date').val()) { showToast('Select PO date', 'warning'); return; }
		if (poItems.length === 0) { showToast('Add at least one item', 'warning'); return; }

		$btn.data('submitting', true);
		$btn.prop('disabled', true).text('Submitting...');

		var poData = collectPOData();

		var promise = currentPOId ?
			fetch('<?= site_url("Po/update?poid="); ?>' + currentPOId, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(poData)
			}) :
			fetch('<?= site_url("Po/store"); ?>', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(poData)
			});

		promise
			.then(function(r) { return r.json(); })
			.then(function(saveResult) {
				if (saveResult.status === 'success') {
					if (!currentPOId && saveResult.data && saveResult.data.po_id) {
						currentPOId = saveResult.data.po_id;
					}

					return fetch('<?= site_url("Po/submit?poid="); ?>' + currentPOId, {
						method: 'POST', 
						headers: { 'Content-Type': 'application/json' },
						body: JSON.stringify(poData)
					});
				}

				throw new Error(saveResult.msg || 'Save failed');
			})
			.then(function(r) { return r.json(); })
			.then(function(submitResult) {
				if (submitResult.status === 'success') {
					showToast('PO submitted for approval', 'success');
					setTimeout(function() {
						location.reload();
					}, 2000);
				} else {
					throw new Error(submitResult.msg || 'Submit failed');
				}
			})
			.catch(function(e) {
				showToast('Error: ' + e.message, 'danger');

				// Re-enable button on error
				$btn.data('submitting', false);
				$btn.prop('disabled', false).text('Submit for Approval');
			});
	});
    
    $('#btn-approve').on('click', function() {
        $('#approve-po-number').text(currentPONumber || '--');
        $('#approve-supplier').text($('#po-supplier option:selected').text() || '--');
        $('#approve-grand-total').text($('#po-grand-total').text());
        $('#approve-total-items').text(poItems.length);
    });
    
    $('#btn-confirm-approve').on('click', function() {
        if (!currentPOId) return;
        $.ajax({ url: '<?= site_url("Po/approve?poid="); ?>' + currentPOId, type: 'POST', success: function(res) {
            if (res.status === 'success') { showToast('PO approved successfully', 'success'); setTimeout(function() { location.reload(); }, 2000); }
            else { showToast(res.msg || 'Approval failed', 'danger'); }
        }, error: function() { showToast('Error approving PO', 'danger'); } });
    });
    
    $('#btn-confirm-reject').on('click', function() {
        var reason = $('#reject-reason').val();
        if (!reason) { showToast('Please provide a rejection reason', 'warning'); return; }
        if (!currentPOId) return;
        $.ajax({ url: '<?= site_url("Po/reject?poid="); ?>' + currentPOId, type: 'POST', data: { note: reason }, success: function(res) {
            if (res.status === 'success') { showToast('PO rejected', 'success'); setTimeout(function() { location.reload(); }, 2000); }
            else { showToast(res.msg || 'Rejection failed', 'danger'); }
        }, error: function() { showToast('Error rejecting PO', 'danger'); } });
    });
    
    $('#btn-cancel').on('click', function() {
        if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
            window.location.href = '<?= site_url("Po/po_list") ?>';
        }
    });
    
    $('#btn-print').on('click', function() {
        if (currentPOId) { window.open('<?= site_url("Po/print_po?id="); ?>' + currentPOId, '_blank'); }
        else { showToast('Save the PO before printing', 'warning'); }
    });
    
    $('#po-supplier, #po-date').on('change', updateValidationChecklist);
});
</script>