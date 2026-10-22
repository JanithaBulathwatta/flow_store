 <!-- ═══════════════════════════════════════════════════════ -->
        <!-- STOCK ADJUSTMENT HISTORY                                 -->
        <!-- ═══════════════════════════════════════════════════════ -->
        <div class="main-content app-content">
          <div class="container-fluid">

            <!-- ── Styles ── -->
            <style>
            /* ── KPI cards ── */
            .kc{border-radius:12px;padding:1rem 1.2rem;display:flex;align-items:center;gap:.85rem;position:relative;overflow:hidden;border:1px solid transparent;}
            .kc .ki{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
            .kc .kv{font-size:1.25rem;font-weight:700;line-height:1;margin-bottom:2px;}
            .kc .kl{font-size:.71rem;color:#64748b;font-weight:500;}
            .kc .ks{font-size:.67rem;color:#94a3b8;margin-top:1px;}
            .kc .kbg{position:absolute;right:-8px;bottom:-8px;width:56px;height:56px;border-radius:50%;opacity:.07;}

            /* ── Status badges ── */
            .sb{display:inline-flex;align-items:center;gap:3px;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:600;white-space:nowrap;}
            .sb-draft    {background:#f1f5f9;color:#475569;}
            .sb-submitted{background:#dbeafe;color:#1e40af;}
            .sb-approved {background:#dcfce7;color:#166534;}
            .sb-rejected {background:#fee2e2;color:#991b1b;}
            .sb-cancelled{background:#f1f5f9;color:#94a3b8;}

            /* ── Adj type pills ── */
            .tp{display:inline-flex;align-items:center;gap:2px;padding:2px 8px;border-radius:5px;font-size:.69rem;font-weight:600;white-space:nowrap;}
            .tp-corr{background:#eff6ff;color:#1d4ed8;}
            .tp-dmg {background:#fee2e2;color:#991b1b;}
            .tp-loss{background:#fff7ed;color:#9a3412;}
            .tp-exp {background:#fef9c3;color:#854d0e;}
            .tp-cnt {background:#f0fdf4;color:#166534;}

            /* ── Qty change chips ── */
            .qpos{color:#16a34a;font-weight:700;}
            .qneg{color:#dc2626;font-weight:700;}
            .qnil{color:#94a3b8;}

            /* ── Filter bar ── */
            .fbar{background:#fff;border:1px solid #e9ecef;border-radius:10px;padding:.825rem 1.1rem;}
            .fbar label{font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:#94a3b8;margin-bottom:.25rem;}

            /* ── Table ── */
            .ah-tbl{width:100%;border-collapse:separate;border-spacing:0;}
            .ah-tbl thead th{
              background:#f8f9fb;font-size:.7rem;text-transform:uppercase;
              letter-spacing:.055em;color:#64748b;white-space:nowrap;
              padding:.6rem .875rem;border-bottom:2px solid #e9ecef;
              position:sticky;top:0;z-index:4;cursor:pointer;user-select:none;
            }
            .ah-tbl thead th:hover{background:#eef2ff;color:#405189;}
            .ah-tbl thead th.s-asc::after {content:' ↑';opacity:.7;}
            .ah-tbl thead th.s-desc::after{content:' ↓';opacity:.7;}
            .ah-tbl td{padding:.58rem .875rem;border-bottom:1px solid #f1f5f9;vertical-align:middle;font-size:.8125rem;}
            .ah-tbl tbody tr:hover td{background:#f8faff!important;}

            /* ── Row status coloring ── */
            .ah-tbl tr.row-approved td:first-child{border-left:3px solid #22c55e;}
            .ah-tbl tr.row-submitted td:first-child{border-left:3px solid #3b82f6;}
            .ah-tbl tr.row-rejected td:first-child{border-left:3px solid #ef4444;}
           
		   /* ── Expand row ── */
            .expand-row td{padding:0!important;background:#f0f7ff!important;}
            .exp-inner{padding:1rem 1.5rem;animation:fadeIn .2s ease;}
            @keyframes fadeIn{from{opacity:0;transform:translateY(-4px);}to{opacity:1;transform:translateY(0);}}

            /* ── Detail panel inside expand ── */
            .det-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:.75rem;}
            .det-item{display:flex;flex-direction:column;gap:2px;}
            .det-lbl{font-size:.67rem;text-transform:uppercase;letter-spacing:.04em;color:#94a3b8;font-weight:600;}
            .det-val{font-size:.8rem;font-weight:600;color:#1e293b;}

            /* ── Items mini table ── */
            .items-mini{border-radius:8px;overflow:hidden;border:1px solid #e9ecef;}
            .items-mini table{width:100%;border-collapse:collapse;font-size:.78rem;}
            .items-mini thead th{background:#f8f9fb;padding:.4rem .75rem;font-size:.68rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;white-space:nowrap;}
            .items-mini td{padding:.4rem .75rem;border-top:1px solid #f1f5f9;vertical-align:middle;}

            /* ── Activity log ── */
            .act-log{border-left:2px solid #e9ecef;padding-left:1.1rem;margin-left:.4rem;}
            .act-item{position:relative;margin-bottom:.875rem;}
            .act-item:last-child{margin-bottom:0;}
            .act-dot{position:absolute;left:-1.4rem;top:.25rem;width:9px;height:9px;border-radius:50%;border:2px solid #fff;}
            .act-dot.d-created   {background:#94a3b8;box-shadow:0 0 0 2px #94a3b8;}
            .act-dot.d-submitted {background:#3b82f6;box-shadow:0 0 0 2px #3b82f6;}
            .act-dot.d-approved  {background:#22c55e;box-shadow:0 0 0 2px #22c55e;}
            .act-dot.d-rejected  {background:#ef4444;box-shadow:0 0 0 2px #ef4444;}
            .act-dot.d-cancelled {background:#94a3b8;box-shadow:0 0 0 2px #94a3b8;}

            /* ── Toolbar ── */
            .tbl-toolbar{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;padding:.6rem .875rem;background:#f8f9fb;border-bottom:1px solid #e9ecef;}

            /* ── Filter chips ── */
            .fc{display:inline-flex;align-items:center;gap:3px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:20px;padding:2px 8px;font-size:.71rem;color:#1e40af;}
            .fc .rm{cursor:pointer;opacity:.55;}
            .fc .rm:hover{opacity:1;}

            /* ── Scroll ── */
            .tbl-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch;}
            .tbl-scroll::-webkit-scrollbar{height:5px;}
            .tbl-scroll::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:3px;}

            /* ── Empty ── */
            .empty-ah{text-align:center;padding:4rem 1rem;color:#94a3b8;}
            .empty-ah i{font-size:2.8rem;display:block;margin-bottom:.625rem;}
            .empty-ah p{font-size:.875rem;margin:0;}

            /* ── Page info ── */
            .pg-inf{font-size:.78rem;color:#64748b;}

            /* ── Toast ── */
            #__tb{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:7px;}
            .t-itm{padding:10px 16px;border-radius:8px;font-size:13px;font-weight:500;color:#fff;box-shadow:0 4px 14px rgba(0,0,0,.18);opacity:0;transform:translateY(5px);transition:all .22s;max-width:290px;}

            /* Adj number pill */
            .adj-pill{font-family:monospace;font-weight:700;color:#405189;font-size:.8rem;}

            @media(max-width:768px){.hide-mob{display:none!important;}}
            </style>

            <!-- ══ PAGE HEADER ══ -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
              <div>
                 
                <h1 class="page-title fw-semibold fs-18 mb-0">Stock Adjustment History</h1>
              </div>
              <div class="d-flex gap-2 align-items-center flex-wrap mt-md-0 mt-2">
                 
                 
              </div>
            </div>

            <!-- ══ KPI STRIP ══ -->
            <div class="row g-3 mb-3" id="kpiRow"></div>

            <!-- ══ FILTER BAR ══ -->
            <div class="fbar mb-3">
              <div class="row g-2 align-items-end">
                <div class="col-sm-6 col-md-3 col-xl-2">
                  <label>Date From</label>
                  <input type="date" class="form-control form-control-sm" id="fFrom" value="2026-01-01">
                </div>
                <div class="col-sm-6 col-md-3 col-xl-2">
                  <label>Date To</label>
                  <input type="date" class="form-control form-control-sm" id="fTo" value="2026-03-18">
                </div>
               <div class="col-sm-6 col-md-3 col-xl-2">
				  <label>Warehouse</label>
				  <select class="form-select form-select-sm" id="fWh">
					<option value="">All Warehouses</option>
					<?php foreach ($warehouses as $warehouse): ?>
					  <option value="<?php echo $warehouse['id']; ?>">
						<?php echo htmlspecialchars($warehouse['name']); ?>
					  </option>
					<?php endforeach; ?>
				  </select>
				</div>
                <div class="col-sm-6 col-md-3 col-xl-2">
                  <label>Adj. Type</label>
                  <select class="form-select form-select-sm" id="fType">
                    <option value="">All Types</option>
                    <option value="Correction">Correction</option>
                    <option value="Damage">Damage</option>
                    <option value="Loss">Loss</option>
                    <option value="Expired">Expired</option>
                    <option value="Stock Count">Stock Count</option>
                  </select>
                </div>
                <div class="col-sm-6 col-md-3 col-xl-2">
                  <label>Status</label>
                  <select class="form-select form-select-sm" id="fStatus">
                    <option value="">All Status</option>
                    <option value="submitted">Submitted</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                  </select>
                </div>
                <div class="col-sm-6 col-md-3 col-xl-2">
                  <label>Created By</label>
                  <select class="form-select form-select-sm" id="fUser">
                    <option value="">All Users</option>
                    <option value="Admin">Admin</option>
                    <option value="Warehouse Staff">Warehouse Staff</option>
                    <option value="Finance Manager">Finance Manager</option>
                    <option value="Accountant">Accountant</option>
                  </select>
                </div>
                <div class="col-sm-6 col-md-3 col-xl-2">
                  <label>Search</label>
                  <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="ri-search-line text-muted"></i></span>
                    <input type="text" class="form-control border-start-0" id="fSearch" placeholder="Adj. no / product…">
                  </div>
                </div>
                <div class="col-sm-6 col-md-3 col-xl-2">
                  <div class="d-flex gap-2">
                    <button class="btn btn-primary btn-sm flex-fill" onclick="applyFilters()">
                      <i class="ri-filter-line me-1"></i>Apply
                    </button>
                    <button class="btn btn-light btn-sm" onclick="resetFilters()">
                      <i class="ri-refresh-line"></i>
                    </button>
                  </div>
                </div>
              </div>
              <!-- Filter chips -->
              <div id="filterChips" class="d-flex gap-2 flex-wrap mt-2" style="min-height:0;"></div>
            </div>

            <!-- ══ MAIN TABLE CARD ══ -->
            <div class="card custom-card">

              <!-- Toolbar -->
              <div class="tbl-toolbar">
                <span class="fw-semibold fs-13 me-auto">
                  <i class="ri-history-line me-2 text-primary"></i>Adjustment Records
                  <span class="badge bg-primary-transparent text-primary ms-2 fs-11" id="recBadge">0 records</span>
                </span>
                <!-- Bulk actions -->
                <div id="bulkBar" class="d-none align-items-center gap-2">
                  <span class="text-muted fs-12" id="selCount">0 selected</span>
                  <button class="btn btn-sm btn-success-light" onclick="bulkApprove()">
                    <i class="ri-checkbox-circle-line me-1"></i>Approve Selected
                  </button>
                </div>
                <button class="btn btn-sm btn-light" onclick="refreshTable()">
                  <i class="ri-refresh-line"></i>
                </button>
              </div>

              <!-- Table -->
              <div class="card-body p-0">
                <div class="tbl-scroll">
					<div class="table-responsive">
					  <table class=" ah-tbl table table-stripe text-nowrap w-100 dataTable no-footer" aria-describedby="datatable-basic_info" id="adjTable">
						<thead>
						  <tr>
							<th style="width:28px;"><input type="checkbox" class="form-check-input" id="chkAll" onchange="toggleAll(this)"></th>
							<th onclick="sortBy('adjNo')">Adj. Number</th>
							<th onclick="sortBy('date')" class="hide-mob">Date</th>
							<th onclick="sortBy('warehouse')" class="hide-mob">Warehouse</th>
							<th onclick="sortBy('type')" style="text-align: center;">Type</th>
							<th onclick="sortBy('items')" class="hide-mob">Items</th>
							<th onclick="sortBy('netQty')" class="hide-mob">Net Qty</th>
							<th onclick="sortBy('valueImpact')" class="hide-mob">Value Impact</th>
							<th onclick="sortBy('status')">Status</th>
							<th onclick="sortBy('createdBy')" class="hide-mob">Created By</th>
							<th class="hide-mob">Approved By</th>
							<th>Actions</th>
						  </tr>
						</thead>
						<tbody id="adjTbody"></tbody>
					  </table>
					</div>
                </div>
              </div>

              <!-- Pagination -->
              <div class="card-footer d-flex align-items-center justify-content-between flex-wrap gap-2 py-2">
                <div class="d-flex align-items-center gap-3">
                  <span class="pg-inf" id="pgInfo">Showing 0–0 of 0</span>
                  <select class="form-select form-select-sm" id="pgSize" style="width:78px;" onchange="onPgSize()">
                    <option value="10">10</option>
                    <option value="20" selected>20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </div>
                <nav><ul class="pagination pagination-sm mb-0" id="pagination"></ul></nav>
              </div>
            </div>

          </div>
        </div><!-- /app-content -->

        <!-- ════════════════════ MODALS ════════════════════ -->

        <!-- View / Detail Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1">
          <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <div>
                  <h6 class="modal-title fw-semibold mb-1">
                    <i class="ri-file-search-line me-2 text-primary"></i>
                    Adjustment Detail — <span id="vmAdjNo" class="adj-pill">—</span>
                  </h6>
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span id="vmStatusBadge"></span>
                    <span id="vmTypeBadge"></span>
                    <span class="text-muted fs-12" id="vmDateLine">—</span>
                  </div>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <!-- Header info grid -->
                <div class="det-grid mb-4" id="vmInfoGrid"></div>
                <div class="row g-3">
                  <!-- Items table -->
                  <div class="col-lg-8">
                    <div class="fw-semibold fs-13 mb-2">
                      <i class="ri-list-check-3 me-2 text-primary"></i>Line Items
                      <span class="badge bg-primary-transparent text-primary ms-1 fs-11" id="vmItemCount">0</span>
                    </div>
                    <div class="items-mini" id="vmItemsTable"></div>
                  </div>
                  <!-- Activity log -->
                  <div class="col-lg-4">
                    <div class="fw-semibold fs-13 mb-2">
                      <i class="ri-history-line me-2 text-primary"></i>Activity Log
                    </div>
                    <div class="act-log" id="vmActLog"></div>
                  </div>
                </div>
                <!-- Remarks -->
                <div class="mt-3 p-3 bg-light rounded" id="vmRemarksBox" style="display:none;">
                  <div class="fw-semibold fs-12 text-muted text-uppercase mb-1">Remarks / Notes</div>
                  <div class="fs-13" id="vmRemarks">—</div>
                </div>
              </div>
              <div class="modal-footer" id="vmFooter"></div>
            </div>
          </div>
        </div>

        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-semibold text-success"><i class="ri-checkbox-circle-line me-2"></i>Approve Adjustment</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="alert alert-success-transparent py-2 fs-12 mb-3">
                  <i class="ri-information-line me-1"></i>Approving will <strong>immediately update warehouse stock</strong> for all items in this adjustment.
                </div>
                <ul class="list-group list-group-flush fs-13" id="approveList"></ul>
              </div>
              <div class="modal-footer border-0 pt-0">
                <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success btn-sm" onclick="confirmApprove()" data-bs-dismiss="modal">
                  <i class="ri-checkbox-circle-line me-1"></i>Confirm Approval
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-semibold text-danger"><i class="ri-close-circle-line me-2"></i>Reject Adjustment</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="alert alert-danger-transparent py-2 fs-12 mb-3">
                  <i class="ri-error-warning-line me-1"></i>The requester will be notified. A <strong>reason is required</strong>.
                </div>
                <div class="mb-3 fs-13 text-muted" id="rejectTarget">—</div>
                <label class="form-label fw-medium fs-13">Rejection Reason <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="3" id="rejectReason" placeholder="Clearly state the reason for rejection…"></textarea>
              </div>
              <div class="modal-footer border-0 pt-0">
                <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger btn-sm" onclick="confirmReject()" data-bs-dismiss="modal">
                  <i class="ri-close-circle-line me-1"></i>Confirm Rejection
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Cancel Modal -->
        <div class="modal fade" id="cancelModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-semibold text-muted"><i class="ri-forbid-2-line me-2"></i>Cancel Adjustment</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="alert alert-warning-transparent py-2 fs-12 mb-3">
                  <i class="ri-error-warning-line me-1"></i>Cancelling this adjustment cannot be undone. No stock changes will be made.
                </div>
                <div class="mb-3 fs-13 text-muted" id="cancelTarget">—</div>
                <label class="form-label fw-medium fs-13">Reason (optional)</label>
                <textarea class="form-control" rows="2" id="cancelReason" placeholder="Optional cancellation reason…"></textarea>
              </div>
              <div class="modal-footer border-0 pt-0">
                <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Go Back</button>
                <button class="btn btn-secondary btn-sm" onclick="confirmCancel()" data-bs-dismiss="modal">
                  <i class="ri-forbid-2-line me-1"></i>Confirm Cancellation
                </button>
              </div>
            </div>
          </div>
        </div>

      
<!-- ══════════════════ HISTORY JS ══════════════════ -->
<script>

var warehouses = <?php echo json_encode($warehouses ?? []); ?>;
var users = <?php echo json_encode($users ?? []); ?>;
var adjustmentTypes = <?php echo json_encode($adjustment_types ?? []); ?>;
var statuses = <?php echo json_encode($statuses ?? []); ?>;

// ========== PERMISSION FLAGS FROM PHP ==========
var CAN_APPROVE = <?php echo isset($can_approve) ? ($can_approve ? 'true' : 'false') : 'false'; ?>;
var CAN_VIEW = <?php echo isset($can_view) ? ($can_view ? 'true' : 'false') : 'true'; ?>;

console.log('StockAdjustHistory Permissions:');
console.log('- Can Approve:', CAN_APPROVE);
console.log('- Can View:', CAN_VIEW);
// ========== END OF PERMISSION FLAGS ==========

(function(){
'use strict';

/* ══════════════════════════════════════════════════════
   STATE
══════════════════════════════════════════════════════ */
var S = {
    adjustments: [],
    page: 1,
    pageSize: 20,
    totalRecords: 0,
    sortKey: 'date',
    sortDir: 'desc',
    expandedId: null,
    activeAdjId: null,
    filters: {
        date_from: '',
        date_to: '',
        warehouse_id: '',
        adjustment_type: '',
        status: '',
        created_by: '',
        search: ''
    }
};

var baseUrl = '<?php echo base_url(); ?>';

/* ══════════════════════════════════════════════════════
   API CALLS
══════════════════════════════════════════════════════ */
function loadAdjustments() {
    var params = {
        page: S.page,
        page_size: S.pageSize,
        sort_by: S.sortKey,
        sort_dir: S.sortDir,
        date_from: S.filters.date_from,
        date_to: S.filters.date_to,
        warehouse_id: S.filters.warehouse_id,
        adjustment_type: S.filters.adjustment_type,
        status: S.filters.status,
        created_by: S.filters.created_by,
        search: S.filters.search
    };
    
    // Remove empty params
    Object.keys(params).forEach(function(key) {
        if (params[key] === '' || params[key] === null || params[key] === undefined) {
            delete params[key];
        }
    });
    
    $.ajax({
        url: baseUrl + 'index.php/StockAdjustHistory/get_adjustments',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                S.adjustments = response.data;
                S.totalRecords = response.total;
                renderTable();
                renderKPI();
            } else {
                toast('Failed to load data', 'danger');
            }
        },
        error: function() {
            toast('Network error', 'danger');
        }
    });
}

function loadAdjustmentDetail(id, callback) {
    $.ajax({
        url: baseUrl + 'index.php/StockAdjustHistory/get_adjustment_detail',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success && callback) {
                callback(response.data);
            } else {
                toast('Failed to load adjustment details', 'danger');
            }
        },
        error: function() {
            toast('Network error', 'danger');
        }
    });
}

function approveAdjustment(id, callback) {
    $.ajax({
        url: baseUrl + 'index.php/StockAdjustHistory/approve',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toast(response.message, 'success');
                if (callback) callback(true);
            } else {
                toast(response.message, 'danger');
                if (callback) callback(false);
            }
        },
        error: function() {
            toast('Network error', 'danger');
            if (callback) callback(false);
        }
    });
}

function rejectAdjustment(id, reason, callback) {
    $.ajax({
        url: baseUrl + 'index.php/StockAdjustHistory/reject',
        type: 'POST',
        data: { id: id, reason: reason },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toast(response.message, 'warning');
                if (callback) callback(true);
            } else {
                toast(response.message, 'danger');
                if (callback) callback(false);
            }
        },
        error: function() {
            toast('Network error', 'danger');
            if (callback) callback(false);
        }
    });
}

function cancelAdjustment(id, reason, callback) {
    $.ajax({
        url: baseUrl + 'index.php/StockAdjustHistory/cancel',
        type: 'POST',
        data: { id: id, reason: reason },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toast(response.message, 'warning');
                if (callback) callback(true);
            } else {
                toast(response.message, 'danger');
                if (callback) callback(false);
            }
        },
        error: function() {
            toast('Network error', 'danger');
            if (callback) callback(false);
        }
    });
}

function bulkApproveAdjustments(ids, callback) {
    $.ajax({
        url: baseUrl + 'index.php/StockAdjustHistory/bulk_approve',
        type: 'POST',
        data: { ids: ids },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toast(response.message, 'success');
                if (callback) callback(true);
            } else {
                toast(response.message, 'danger');
                if (callback) callback(false);
            }
        },
        error: function() {
            toast('Network error', 'danger');
            if (callback) callback(false);
        }
    });
}

/* ══════════════════════════════════════════════════════
   RENDER FUNCTIONS
══════════════════════════════════════════════════════ */
function renderKPI() {
    var all = S.adjustments;
    var approved = all.filter(function(d) { return d.status === 'approved'; }).length;
    var pending = all.filter(function(d) { return d.status === 'submitted'; }).length;
    var rejected = all.filter(function(d) { return d.status === 'rejected'; }).length;
    var totalQtyAdj = all.filter(function(d) { return d.status === 'Approved'; }).reduce(function(s, d) { return s + Math.abs(d.netQty); }, 0);
    var totalValImp = all.filter(function(d) { return d.status === 'Approved'; }).reduce(function(s, d) { return s + Math.abs(d.valueImpact); }, 0);

    var cards = [
        {bg:'#eff6ff', ic:'#1d4ed8', icon:'ri-file-list-3-line', lbl:'Total Adjustments', val:all.length, sub:approved+' approved, '+pending+' pending, '+rejected+' rejected'},
    {bg:'#fef9c3', ic:'#854d0e', icon:'ri-time-line', lbl:'Pending Approval', val:pending, sub:'Awaiting action'},
    {bg:'#dcfce7', ic:'#166534', icon:'ri-checkbox-circle-line', lbl:'Approved', val:approved, sub:'Stock updated'},
    {bg:'#fee2e2', ic:'#991b1b', icon:'ri-close-circle-line', lbl:'Rejected', val:rejected, sub:'Not applied'},
        {bg:'#fdf4ff', ic:'#7e22ce', icon:'ri-stack-line', lbl:'Total Qty Adjusted', val:totalQtyAdj+' units', sub:'Approved only'},
        {bg:'#fff7ed', ic:'#9a3412', icon:'ri-money-dollar-circle-line', lbl:'Total Value Impact', val:lkr(Math.abs(totalValImp)), sub:'Net impact on stock value'},
    ];

    document.getElementById('kpiRow').innerHTML = cards.map(function(c) {
        return '<div class="col-sm-6 col-xl"><div class="card custom-card"><div class="card-body kc" style="background:'+c.bg+';border-color:'+c.bg+';">'+
            '<div class="ki" style="background:rgba(255,255,255,.5);"><i class="'+c.icon+'" style="color:'+c.ic+';font-size:1.15rem;"></i></div>'+
            '<div><div class="kv" style="color:'+c.ic+';">'+c.val+'</div><div class="kl">'+c.lbl+'</div><div class="ks">'+c.sub+'</div></div>'+
            '<div class="kbg" style="background:'+c.ic+';"></div>'+
        '</div></div></div>';
    }).join('');
}

function renderTable() {
    var tb = document.getElementById('adjTbody');
    if (!tb) return;
    
    var start = (S.page - 1) * S.pageSize;
    var pageData = S.adjustments;
    
    var rb = document.getElementById('recBadge');
    if (rb) rb.textContent = S.totalRecords + ' records';
    
    var pi = document.getElementById('pgInfo');
    if (pi) pi.textContent = 'Showing ' + (S.totalRecords ? start + 1 : 0) + '\u2013' + Math.min(start + S.pageSize, S.totalRecords) + ' of ' + S.totalRecords;

    if (!pageData.length) {
        tb.innerHTML = '<tr><td colspan="12"><div class="empty-ah"><i class="ri-inbox-line"></i><p>No adjustment records found.<br><small>Try adjusting your filters.</small></p></div></td></tr>';
        renderPagination();
        return;
    }

    tb.innerHTML = pageData.map(function(d) {
        var rowCls = 'row-' + (d.status || 'submitted');
        var netQtyHtml = d.netQty > 0 ? '<span class="qpos">+' + d.netQty + '</span>' : d.netQty < 0 ? '<span class="qneg">' + d.netQty + '</span>' : '<span class="qnil">0</span>';
        //var valHtml = d.valueImpact > 0 ? '<span class="qpos">' + lkr(d.valueImpact) + '</span>' : d.valueImpact < 0 ? '<span class="qneg">' + lkr(d.valueImpact) + '</span>' : '<span class="qnil">—</span>';
        var valHtml = '<span class="text-amount">' + (d.valueImpact !== 0 ? d.valueImpact.toFixed(2) : '0.00') + '</span>';

        var btns = '<div class="d-flex gap-1 flex-nowrap">';
btns += '<button class="btn btn-sm btn-icon btn-info-light" title="View Detail" onclick="openViewModal(' + d.id + ')" data-bs-toggle="modal" data-bs-target="#viewModal"><i class="ri-eye-line"></i></button>';

// Only show Approve/Reject buttons if user has permission AND status is 'submitted'
if (d.status === 'submitted' && CAN_APPROVE) {
    btns += '<button class="btn btn-sm btn-icon btn-success-light" title="Approve" onclick="openApproveModal(' + d.id + ')" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="ri-checkbox-circle-line"></i></button>' +
            '<button class="btn btn-sm btn-icon btn-danger-light" title="Reject" onclick="openRejectModal(' + d.id + ')" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="ri-close-circle-line"></i></button>';
}

btns += '</div>';

        return '<tr class="' + rowCls + '" data-id="' + d.id + '">' +
            '<td><input type="checkbox" class="form-check-input row-chk" data-id="' + d.id + '" onchange="onRowCheck()"></td>' +
            '<td><span class="adj-pill">' + escapeHtml(d.adjNo) + '</span></td>' +
            '<td class="hide-mob text-muted fs-12">' + formatDate(d.date) + '</td>' +
            '<td class="hide-mob text-muted fs-12">' + escapeHtml(d.warehouse) + ' WH</td>' +
            '<td>' + tbadge(d.type) + '</td>' +
            '<td class="hide-mob text-center"><span class="badge bg-light text-dark">' + d.items_count + '</span></td>' +
            '<td class="hide-mob text-center">' + netQtyHtml + '</td>' +
            '<td class="hide-mob text-center text-amount">' + valHtml + '</td>' +
            '<td>' + sbadge(d.status) + '</td>' +
            '<td class="hide-mob text-muted fs-12">' + escapeHtml(d.createdBy) + '</td>' +
            '<td class="hide-mob text-muted fs-12">' + (d.approvedBy ? escapeHtml(d.approvedBy) : '<span class="text-muted">—</span>') + '</td>' +
            '<td>' + btns + '</td>' +
        '</tr>';
    }).join('');

    renderPagination();
}

function renderPagination() {
    var pg = document.getElementById('pagination');
    if (!pg) return;
    
    var pages = Math.ceil(S.totalRecords / S.pageSize);
    if (pages <= 1) {
        pg.innerHTML = '';
        return;
    }
    
    var h = '<li class="page-item ' + (S.page === 1 ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="goPage(' + (S.page - 1) + ');return false;">&laquo;</a></li>';
    for (var i = 1; i <= pages; i++) {
        if (i === 1 || i === pages || Math.abs(i - S.page) <= 1)
            h += '<li class="page-item ' + (i === S.page ? 'active' : '') + '"><a class="page-link" href="#" onclick="goPage(' + i + ');return false;">' + i + '</a></li>';
        else if (Math.abs(i - S.page) === 2)
            h += '<li class="page-item disabled"><a class="page-link">…</a></li>';
    }
    h += '<li class="page-item ' + (S.page === pages ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="goPage(' + (S.page + 1) + ');return false;">&raquo;</a></li>';
    pg.innerHTML = h;
}

/* ══════════════════════════════════════════════════════
   HELPER FUNCTIONS
══════════════════════════════════════════════════════ */
function lkr(n) {
    if (n == null) return '—';
    var a = Math.abs(n);
    return (n < 0 ? '-' : '') + 'LKR ' + a.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function formatDate(d) {
    if (!d) return '—';
    var x = new Date(d);
    return isNaN(x) ? d : x.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}

function formatDateTime(d) {
    if (!d) return '—';
    return d;
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function toast(msg, type) {
    var C = { success: '#22c55e', danger: '#ef4444', warning: '#f59e0b', primary: '#405189', info: '#0ea5e9' };
    var b = document.getElementById('__tb');
    if (!b) {
        b = document.createElement('div');
        b.id = '__tb';
        document.body.appendChild(b);
    }
    var t = document.createElement('div');
    t.className = 't-itm';
    t.style.background = C[type] || C.primary;
    t.innerHTML = '<i class="ri-checkbox-circle-line me-2"></i>' + msg;
    b.appendChild(t);
    requestAnimationFrame(function() {
        t.style.opacity = 1;
        t.style.transform = 'translateY(0)';
    });
    setTimeout(function() {
        t.style.opacity = 0;
        setTimeout(function() { t.remove(); }, 300);
    }, 3200);
}

function sbadge(s) { 
    // Convert to lowercase to match database values
    var status = (s || '').toLowerCase();
    
    var m = {
        'submitted': 'sb sb-submitted',
        'approved': 'sb sb-approved',
        'rejected': 'sb sb-rejected'
    };
    
    var icons = { 
        'submitted': '<i class="ri-time-line me-1"></i>',
        'approved': '<i class="ri-checkbox-circle-fill me-1"></i>',
        'rejected': '<i class="ri-close-circle-fill me-1"></i>'
    };
    
    // Capitalize first letter for display
    var displayText = status.charAt(0).toUpperCase() + status.slice(1);
    
    return '<span class="' + (m[status] || 'sb sb-submitted') + '">' + 
           (icons[status] || '<i class="ri-time-line me-1"></i>') + 
           displayText + 
           '</span>';
}

function tbadge(t) {
    var m = { Correction: 'tp tp-corr', Damage: 'tp tp-dmg', Loss: 'tp tp-loss', Expired: 'tp tp-exp', 'Stock Count': 'tp tp-cnt' };
    var icons = { Correction: '🔧', Damage: '💥', Loss: '📉', Expired: '⏰', 'Stock Count': '📋' };
    return '<span class="' + (m[t] || 'tp tp-corr') + '">' + (icons[t] || '') + '&nbsp;' + t + '</span>';
}

function modeBadge(m) {
    var map = { add: '<span style="background:#f0fdf4;color:#16a34a;border:1px solid #86efac;border-radius:4px;padding:1px 7px;font-size:.68rem;font-weight:700;">+Add</span>', sub: '<span style="background:#fff5f5;color:#dc2626;border:1px solid #fca5a5;border-radius:4px;padding:1px 7px;font-size:.68rem;font-weight:700;">-Sub</span>', set: '<span style="background:#eff6ff;color:#1d4ed8;border:1px solid #93c5fd;border-radius:4px;padding:1px 7px;font-size:.68rem;font-weight:700;">=Set</span>' };
    return map[m] || map.sub;
}

/* ══════════════════════════════════════════════════════
   MODAL FUNCTIONS
══════════════════════════════════════════════════════ */
window.openViewModal = function(id) {
    S.activeAdjId = id;
    loadAdjustmentDetail(id, function(d) {
        if (!d) return;

        // Header badges
        var el = document.getElementById('vmAdjNo');
        if (el) el.textContent = d.adjNo;
        var sb = document.getElementById('vmStatusBadge');
        if (sb) sb.innerHTML = sbadge(d.status);
        var tb2 = document.getElementById('vmTypeBadge');
        if (tb2) tb2.innerHTML = tbadge(d.type);
        var dl = document.getElementById('vmDateLine');
        if (dl) dl.textContent = formatDate(d.date) + ' · Created by ' + d.createdBy;

        // Info grid
        var grid = document.getElementById('vmInfoGrid');
        if (grid) grid.innerHTML = [
            { l: 'Adjustment No.', v: '<span class="adj-pill">' + escapeHtml(d.adjNo) + '</span>' },
            { l: 'Date', v: formatDate(d.date) },
            { l: 'Warehouse', v: d.warehouse + ' Warehouse' },
            { l: 'Type', v: tbadge(d.type) },
            { l: 'Status', v: sbadge(d.status) },
            { l: 'Items', v: d.items_count + ' product(s)' },
            { l: 'Net Qty Change', v: d.netQty > 0 ? '<span class="qpos">+' + d.netQty + '</span>' : d.netQty < 0 ? '<span class="qneg">' + d.netQty + '</span>' : '0' },
            { l: 'Value Impact', v: d.valueImpact !== 0 ? '<span class="' + (d.valueImpact > 0 ? 'qpos' : 'qneg') + '">' + lkr(d.valueImpact) + '</span>' : '—' },
            { l: 'Created By', v: escapeHtml(d.createdBy) },
            { l: 'Approved By', v: d.approvedBy ? escapeHtml(d.approvedBy) : '<span class="text-muted">Pending</span>' }
        ].map(function(r) {
            return '<div class="det-item"><div class="det-lbl">' + r.l + '</div><div class="det-val">' + r.v + '</div></div>';
        }).join('');

        // Items table
        var ic = document.getElementById('vmItemCount');
        if (ic) ic.textContent = d.items.length;
        var itmTbl = document.getElementById('vmItemsTable');
        if (itmTbl) {
            itmTbl.innerHTML = '<table><thead><tr>' +
                '<th>Product</th><th>SKU</th><th>Batch</th><th>Mode</th>' +
                '<th class="text-center">Old Qty</th><th class="text-center">Adj. Qty</th><th class="text-center">New Qty</th>' +
                '<th class="text-end">Unit Cost</th><th class="text-end">Impact</th>' +
                '</tr></thead><tbody>' +
                d.items.map(function(i) {
    var delta = i.mode === 'add' ? i.qty : i.mode === 'sub' ? -i.qty : (i.newQty - i.oldQty);
    var impact = delta * i.cost;
    
    // Determine if mode is add or subtract (case insensitive)
    var modeLower = (i.mode || '').toLowerCase();
    var isAdd = modeLower === 'add' || modeLower === 'additive';
    var isSubtract = modeLower === 'sub' || modeLower === 'subtract' || modeLower.indexOf('sub') !== -1;
    
    return '<tr>' +
        '<td class="fw-semibold">' + escapeHtml(i.product) + '</td>' +
        '<td class="text-muted">' + escapeHtml(i.sku) + '</td>' +
        '<td>' + (i.batch ? '<span style="background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;border-radius:4px;padding:0 6px;font-size:.68rem;font-weight:700;">' + escapeHtml(i.batch) + '</span>' : '<span class="text-muted">—</span>') + '</td>' +
        '<td>' + modeBadge(i.mode) + '</td>' +
        '<td class="text-center text-muted">' + i.oldQty + '</td>' +
        '<td class="text-center fw-semibold">' + 
            (isAdd ? '<span class="qpos">+' + i.qty + '</span>' : 
             isSubtract ? '<span class="qneg">-' + i.qty + '</span>' : 
             '<span style="color:#1d4ed8;">' + i.qty + '</span>') + 
        '</td>' +
        '<td class="text-center fw-bold" style="color:#405189;">' + i.newQty + ' ' + i.unit + '</td>' +
        '<td class="text-end text-muted">' + lkr(i.cost) + '</td>' +
        '<td class="text-end ' + (impact > 0 ? 'qpos' : impact < 0 ? 'qneg' : 'text-muted') + '">' + lkr(impact) + '</td>' +
    '</tr>';
}).join('') +
                '</tbody></table>';
        }

        // Activity log
        var dotMap = { created: 'd-created', submitted: 'd-submitted', approved: 'd-approved', rejected: 'd-rejected', cancelled: 'd-cancelled' };
        var actLog = document.getElementById('vmActLog');
        if (actLog && d.activity) actLog.innerHTML = d.activity.map(function(a) {
            return '<div class="act-item">' +
                '<div class="act-dot ' + (dotMap[a.action] || 'd-created') + '"></div>' +
                '<div class="fs-11 text-muted">' + formatDateTime(a.at) + '</div>' +
                '<div class="fw-semibold fs-12">' + escapeHtml(a.by) + ' — ' + sbadge(a.action.charAt(0).toUpperCase() + a.action.slice(1)) + '</div>' +
                '<div class="text-muted fs-12 mt-1">' + (a.note || '') + '</div>' +
            '</div>';
        }).join('');

        // Remarks
        var rbox = document.getElementById('vmRemarksBox');
        var rval = document.getElementById('vmRemarks');
        if (d.remarks) {
            if (rbox) rbox.style.display = '';
            if (rval) rval.textContent = d.remarks;
        } else {
            if (rbox) rbox.style.display = 'none';
        }

        // Footer action buttons
        var footer = document.getElementById('vmFooter');
        if (footer) {
            var btns = '<button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>';
            if (d.status === 'Submitted') {
                btns = '<button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>' +
                    '<button class="btn btn-danger btn-sm" onclick="openRejectModal(' + d.id + ')" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="ri-close-circle-line me-1"></i>Reject</button>' +
                    '<button class="btn btn-success btn-sm" onclick="openApproveModal(' + d.id + ')" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#approveModal"><i class="ri-checkbox-circle-line me-1"></i>Approve</button>';
            } else if (d.status === 'Draft') {
                btns = '<button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>' +
                    '<a href="stock-adjustment.html?edit=' + d.id + '" class="btn btn-primary btn-sm" data-bs-dismiss="modal"><i class="ri-edit-line me-1"></i>Edit</a>';
            }
            footer.innerHTML = btns;
        }
    });
};

/* ══════════════════════════════════════════════════════
           APPROVE / REJECT / CANCEL
══════════════════════════════════════════════════════ */


window.openApproveModal = function(id) {
    S.activeAdjId = id;
    loadAdjustmentDetail(id, function(d) {
        if (!d) return;
        var list = document.getElementById('approveList');
        if (list) list.innerHTML = [
            ['Adj. No.', d.adjNo],
            ['Warehouse', d.warehouse + ' Warehouse'],
            ['Type', tbadge(d.type)],
            ['Items', d.items_count],
            ['Net Qty', d.netQty > 0 ? '<span class="qpos">+' + d.netQty + '</span>' : '<span class="qneg">' + d.netQty + '</span>'],
            ['Value Impact', lkr(d.valueImpact)]
        ].map(function(r) {
            return '<li class="list-group-item px-0 py-2 d-flex justify-content-between fs-13"><span class="text-muted">' + r[0] + '</span><span class="fw-semibold">' + r[1] + '</span></li>';
        }).join('');
    });
};

window.confirmApprove = function() {
    approveAdjustment(S.activeAdjId, function(success) {
        if (success) {
            loadAdjustments();
            $('#approveModal').modal('hide');
        }
    });
};

window.openRejectModal = function(id) {
    S.activeAdjId = id;
    loadAdjustmentDetail(id, function(d) {
        if (!d) return;
        var rt = document.getElementById('rejectTarget');
        if (rt) rt.textContent = d.adjNo + ' — ' + d.warehouse + ' WH — ' + d.type;
        var rr = document.getElementById('rejectReason');
        if (rr) rr.value = '';
    });
};

window.confirmReject = function() {
    var reason = document.getElementById('rejectReason').value.trim();
    if (!reason) {
        toast('Rejection reason is required', 'danger');
        return;
    }
    rejectAdjustment(S.activeAdjId, reason, function(success) {
        if (success) {
            loadAdjustments();
            $('#rejectModal').modal('hide');
        }
    });
};

window.openCancelModal = function(id) {
    S.activeAdjId = id;
    loadAdjustmentDetail(id, function(d) {
        if (!d) return;
        var ct = document.getElementById('cancelTarget');
        if (ct) ct.textContent = d.adjNo + ' — ' + d.warehouse + ' WH — ' + d.type;
        var cr = document.getElementById('cancelReason');
        if (cr) cr.value = '';
    });
};

window.confirmCancel = function() {
    var reason = document.getElementById('cancelReason').value;
    cancelAdjustment(S.activeAdjId, reason, function(success) {
        if (success) {
            loadAdjustments();
            $('#cancelModal').modal('hide');
        }
    });
};

/* ══════════════════════════════════════════════════════
   FILTER FUNCTIONS
══════════════════════════════════════════════════════ */
window.applyFilters = function() {
    S.filters.date_from = document.getElementById('fFrom').value;
    S.filters.date_to = document.getElementById('fTo').value;
    S.filters.warehouse_id = document.getElementById('fWh').value;
    S.filters.adjustment_type = document.getElementById('fType').value;
    S.filters.status = document.getElementById('fStatus').value;
    S.filters.created_by = document.getElementById('fUser').value;
    S.filters.search = document.getElementById('fSearch').value;
    
    S.page = 1;
    loadAdjustments();
};

window.resetFilters = function() {
    document.getElementById('fFrom').value = '';
    document.getElementById('fTo').value = '';
    document.getElementById('fWh').value = '';
    document.getElementById('fType').value = '';
    document.getElementById('fStatus').value = '';
    document.getElementById('fUser').value = '';
    document.getElementById('fSearch').value = '';
    
    S.filters = {
        date_from: '',
        date_to: '',
        warehouse_id: '',
        adjustment_type: '',
        status: '',
        created_by: '',
        search: ''
    };
    S.page = 1;
    loadAdjustments();
    toast('Filters reset', 'primary');
};

/* ══════════════════════════════════════════════════════
   SORTING & PAGINATION
══════════════════════════════════════════════════════ */
window.sortBy = function(key) {
    if (S.sortKey === key) {
        S.sortDir = S.sortDir === 'asc' ? 'desc' : 'asc';
    } else {
        S.sortKey = key;
        S.sortDir = 'desc';
    }
    S.page = 1;
    loadAdjustments();
};

window.goPage = function(p) {
    var pages = Math.ceil(S.totalRecords / S.pageSize);
    if (p < 1 || p > pages) return;
    S.page = p;
    loadAdjustments();
};

window.onPgSize = function() {
    var v = document.getElementById('pgSize').value;
    S.pageSize = parseInt(v);
    S.page = 1;
    loadAdjustments();
};

/* ══════════════════════════════════════════════════════
   SELECTION & BULK ACTIONS
══════════════════════════════════════════════════════ */
window.toggleAll = function(chk) {
    document.querySelectorAll('.row-chk').forEach(function(c) {
        c.checked = chk.checked;
    });
    updateBulkBar();
};

window.onRowCheck = function() {
    updateBulkBar();
};

function updateBulkBar() {
    var sel = document.querySelectorAll('.row-chk:checked').length;
    var bar = document.getElementById('bulkBar');
    var cnt = document.getElementById('selCount');
    if (sel > 0 && CAN_APPROVE) {
        bar.classList.remove('d-none');
        bar.classList.add('d-flex');
        if (cnt) cnt.textContent = sel + ' selected';
    } else {
        bar.classList.add('d-none');
        bar.classList.remove('d-flex');
    }
}

window.bulkApprove = function() {
	// ========== PERMISSION CHECK ==========
    if (!CAN_APPROVE) {
        toast('You do not have permission to approve stock adjustments', 'danger');
        return;
    }
    // ========== END PERMISSION CHECK ==========
	
    var ids = Array.from(document.querySelectorAll('.row-chk:checked')).map(function(c) {
        return parseInt(c.getAttribute('data-id'));
    });
    
    if (ids.length === 0) {
        toast('No adjustments selected', 'warning');
        return;
    }
    
    if (confirm('Approve ' + ids.length + ' adjustment(s)? This will update stock quantities.')) {
        bulkApproveAdjustments(ids, function(success) {
            if (success) {
                loadAdjustments();
                var chk = document.getElementById('chkAll');
                if (chk) chk.checked = false;
                updateBulkBar();
            }
        });
    }
};

window.refreshTable = function() {
    loadAdjustments();
    toast('Refreshed', 'success');
};

window.doExport = function(t) {
    toast('Exporting ' + S.totalRecords + ' records as ' + t.toUpperCase() + '…', 'primary');
    // Implement export if needed
};

/* ══════════════════════════════════════════════════════
   INIT
══════════════════════════════════════════════════════ */
function init() {
    // Set default date range (last 30 days)
    var today = new Date();
    var thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(today.getDate() - 30);
    
    document.getElementById('fFrom').value = thirtyDaysAgo.toISOString().split('T')[0];
    document.getElementById('fTo').value = today.toISOString().split('T')[0];
    
    // Load data
    loadAdjustments();
    
    // Set current year in footer
    var y = document.getElementById('year');
    if (y) y.textContent = new Date().getFullYear();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    setTimeout(init, 80);
}

})();
</script>
