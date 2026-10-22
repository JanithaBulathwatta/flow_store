<style>
.prod-sticky-header{position:sticky;top:0;z-index:110;background:#fff;border-bottom:1px solid #e9ecef;padding:.75rem 0;margin-bottom:1rem;}
.prod-sticky-header .prod-tag{display:inline-flex;align-items:center;gap:4px;padding:2px 9px;border-radius:5px;font-size:.71rem;font-weight:600;}
.kpi-pill{border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:.85rem;position:relative;overflow:hidden;}
.kpi-pill .kp-icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;}
.kpi-pill .kp-val{font-size:1.35rem;font-weight:700;line-height:1;margin-bottom:2px;}
.kpi-pill .kp-lbl{font-size:.72rem;color:#64748b;font-weight:500;}
.kpi-pill .kp-sub{font-size:.68rem;color:#94a3b8;margin-top:2px;}
.kpi-pill .kp-bg{position:absolute;right:-12px;bottom:-12px;width:70px;height:70px;border-radius:50%;opacity:.06;}
.stk-tabs .nav-link{color:#64748b;font-size:.875rem;font-weight:500;padding:.5rem 1.1rem;border-radius:8px 8px 0 0;border:none;border-bottom:2px solid transparent;}
.stk-tabs .nav-link.active{color:#405189;border-bottom-color:#405189;background:transparent;font-weight:600;}
.stk-tabs .nav-link:hover:not(.active){background:#f8f9fb;color:#405189;}
.dt-tbl th{background:#f8f9fb;font-size:.71rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;white-space:nowrap;padding:.6rem .875rem;border-bottom:2px solid #e9ecef;}
.dt-tbl td{padding:.6rem .875rem;border-bottom:1px solid #f1f5f9;vertical-align:middle;font-size:.8125rem;}
.dt-tbl tbody tr:hover td{background:#f8faff;}
.sb{display:inline-flex;align-items:center;gap:3px;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:600;white-space:nowrap;}
.sb-normal{background:#dcfce7;color:#166534;}.sb-low{background:#fef9c3;color:#854d0e;}.sb-zero{background:#fee2e2;color:#991b1b;}
.sb-valid{background:#dcfce7;color:#166534;}.sb-near{background:#fef9c3;color:#854d0e;}.sb-expired{background:#fee2e2;color:#991b1b;}
.num{text-align:right;font-variant-numeric:tabular-nums;}
.ov-stat{text-align:center;padding:.75rem .5rem;border-radius:8px;background:#f8fafc;border:1px solid #f1f5f9;}
.ov-stat .ov-val{font-size:1.2rem;font-weight:700;line-height:1;}
.ov-stat .ov-lbl{font-size:.68rem;color:#94a3b8;margin-top:3px;}
.wh-bar{height:8px;border-radius:4px;background:#e9ecef;overflow:hidden;margin-top:5px;}
.wh-bar-fill{height:100%;border-radius:4px;background:linear-gradient(90deg,#405189,#6172b0);}
.empty-tab{text-align:center;padding:3.5rem 1rem;color:#94a3b8;}
.empty-tab i{font-size:2.5rem;display:block;margin-bottom:.625rem;}
.empty-tab p{font-size:.875rem;margin:0;}
.qa-bar{position:sticky;bottom:0;background:#fff;border-top:1px solid #e9ecef;padding:.75rem 1rem;z-index:50;display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;border-radius:0 0 12px 12px;}
</style>

<div class="main-content app-content">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
      <div>
        <nav><ol class="breadcrumb mb-1">
          <li class="breadcrumb-item"><a href="<?= base_url('Stock_report') ?>">Inventory</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('Stock_report') ?>">Stock Report</a></li>
          <li class="breadcrumb-item active"><?= htmlspecialchars($product['name'] ?? 'Product') ?></li>
        </ol></nav>
        <h1 class="page-title fw-semibold fs-18 mb-0">Stock Detail</h1>
      </div>
      <div class="d-flex gap-2 flex-wrap mt-md-0 mt-2">
        <a href="<?= base_url('Stock_report') ?>" class="btn btn-light btn-sm">
          <i class="ri-arrow-left-line me-1"></i>Back to Report
        </a>
        <a href="<?= base_url('Stock_transactions?pid=' . $product_id) ?>" class="btn btn-info btn-sm">
          <i class="ri-bar-chart-line me-1"></i>View Transactions
        </a>
      </div>
    </div>

    <!-- Product Sticky Header -->
    <div class="prod-sticky-header">
      <div class="d-flex align-items-start gap-3 flex-wrap">
        <div style="width:54px;height:54px;border-radius:12px;background:linear-gradient(135deg,#405189,#6172b0);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="ri-box-3-line text-white fs-22"></i>
        </div>
        <div class="flex-fill">
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <h4 class="fw-bold mb-0 fs-16"><?= htmlspecialchars($product['name']) ?></h4>
            <span class="sb sb-normal" id="prodStatusBadge">Normal</span>
          </div>
          <div class="d-flex gap-3 flex-wrap mt-1">
            <span class="text-muted fs-12"><i class="ri-price-tag-3-line me-1"></i>SKU: <strong><?= htmlspecialchars($product['product_code'] ?? 'N/A') ?></strong></span>
            <span class="text-muted fs-12"><i class="ri-folder-line me-1"></i>Category: <strong><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></strong></span>
          </div>
        </div>
        <div class="text-end">
          <div class="fs-11 text-muted mb-1">Reorder Level</div>
          <div class="fw-bold fs-16 text-warning"><?= $product['reorder_level'] ?? 0 ?> pcs</div>
        </div>
      </div>
    </div>

    <!-- KPI Summary Row -->
    <div class="row g-3 mb-4" id="kpiRow"></div>

    <!-- Tabs -->
    <div class="card custom-card">
      <div class="card-header border-bottom-0 pb-0">
        <ul class="nav stk-tabs" id="detailTabs">
          <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabOverview" onclick="loadTab('overview')">
              <i class="ri-dashboard-line me-1"></i>Overview
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabWarehouses" onclick="loadTab('warehouses')">
              <i class="ri-building-line me-1"></i>Warehouse Stock
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabBatches" onclick="loadTab('batches')">
              <i class="ri-archive-line me-1"></i>Batch Details
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabTransactions" onclick="loadTab('transactions')">
              <i class="ri-swap-box-line me-1"></i>Transactions
            </button>
          </li>
        </ul>
      </div>

      <div class="tab-content" id="detailTabContent">
        <!-- Overview Tab -->
        <div class="tab-pane fade show active p-4" id="tabOverview">
          <div class="row g-4">
            <div class="col-lg-8">
              <div class="fw-semibold fs-13 text-muted text-uppercase letter-spacing-1 mb-3">Stock Snapshot</div>
              <div class="row g-2 mb-4" id="overviewStats"></div>
              <div>
                <div class="fw-semibold fs-13 mb-2">Warehouse Distribution</div>
                <div id="whDistribution"></div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card bg-light border-0">
                <div class="card-body">
                  <div class="fw-semibold fs-13 text-muted text-uppercase mb-3">Product Info</div>
                  <ul class="list-group list-group-flush fs-13">
                    <li class="list-group-item bg-transparent px-0"><strong>Name:</strong> <?= htmlspecialchars($product['name']) ?></li>
                    <li class="list-group-item bg-transparent px-0"><strong>SKU:</strong> <?= htmlspecialchars($product['product_code'] ?? 'N/A') ?></li>
                    <li class="list-group-item bg-transparent px-0"><strong>Category:</strong> <?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></li>
                    <li class="list-group-item bg-transparent px-0"><strong>Brand:</strong> <?= htmlspecialchars($product['brand_name'] ?? 'N/A') ?></li>
                    <li class="list-group-item bg-transparent px-0"><strong>Price:</strong> Rs. <?= number_format($product['price'] ?? 0, 2) ?></li>
                    <li class="list-group-item bg-transparent px-0"><strong>Reorder Level:</strong> <?= $product['reorder_level'] ?? 0 ?></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Warehouse Stock Tab -->
        <div class="tab-pane fade" id="tabWarehouses">
          <div class="p-3 border-bottom">
            <span class="fw-semibold fs-13"><i class="ri-building-line me-2 text-primary"></i>Stock by Warehouse</span>
          </div>
          <div class="table-responsive">
            <table class="table dt-tbl mb-0">
              <thead>
                <tr>
                  <th>Warehouse</th>
                  <th class="num">Quantity</th>
                  <th class="num">Unit Cost</th>
                  <th class="num">Stock Value</th>
                  <th>% of Total</th>
                </tr>
              </thead>
              <tbody id="whTbody"></tbody>
            </table>
          </div>
        </div>

        <!-- Batch Details Tab -->
        <div class="tab-pane fade" id="tabBatches">
          <div class="p-3 border-bottom">
            <span class="fw-semibold fs-13"><i class="ri-archive-line me-2 text-primary"></i>Batch Details</span>
          </div>
          <div class="table-responsive">
            <table class="table dt-tbl mb-0">
              <thead>
                <tr>
                  <th>Batch No.</th>
                  <th>Warehouse</th>
                  <th class="num">Qty</th>
                  <th>Expiry Date</th>
                  <th>Days Left</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="batchTbody"></tbody>
            </table>
          </div>
        </div>

        <!-- Transactions Tab -->
        <div class="tab-pane fade" id="tabTransactions">
          <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <span class="fw-semibold fs-13"><i class="ri-swap-box-line me-2 text-primary"></i>Recent Transactions</span>
            <a href="<?= base_url('Stock_transactions?pid=' . $product_id) ?>" class="btn btn-sm btn-primary">
              <i class="ri-external-link-line me-1"></i>View All
            </a>
          </div>
          <div class="table-responsive">
            <table class="table dt-tbl mb-0">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Reference</th>
                  <th>Warehouse</th>
                  <th class="num">Qty In</th>
                  <th class="num">Qty Out</th>
                  <th>User</th>
                </tr>
              </thead>
              <tbody id="txnTbody"></tbody>
            </table>
          </div>
        </div>

      </div>

      <!-- Quick Action Bar -->
      <div class="qa-bar">
        <span class="fw-semibold fs-12 text-muted me-2"><i class="ri-lightning-line me-1 text-warning"></i>Quick Actions:</span>
        <a href="<?= base_url('Stock_transactions?pid=' . $product_id) ?>" class="btn btn-info btn-sm">
          <i class="ri-bar-chart-line me-1"></i>Full Transaction Log
        </a>
        <div class="ms-auto d-flex align-items-center gap-2">
          <span class="fw-semibold text-primary fs-13">Current Stock:</span>
          <span class="badge fs-13 fw-bold px-3 py-2" id="currentStockBadge" style="background:#405189;color:#fff;border-radius:8px;">—</span>
        </div>
      </div>

    </div>

  </div>
</div>

<script>
const PRODUCT_ID = <?= $product_id ?>;
const BASE_URL = '<?= base_url() ?>';

window.loadKpiData = function() {
  $.get(BASE_URL + 'Stock_detail/get_kpi_data', { product_id: PRODUCT_ID }, function(res) {
    if (res) {
      $('#kpiRow').html(`
        <div class="col-xl-3 col-sm-6">
          <div class="kpi-pill" style="background:#eff6ff;border:1px solid #bfdbfe;">
            <div class="kp-icon" style="background:#dbeafe;color:#1e40af;"><i class="ri-box-3-line"></i></div>
            <div><div class="kp-val">${res.total_stock || 0}</div><div class="kp-lbl">Total Stock</div></div>
            <div class="kp-bg" style="background:#3b82f6;"></div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="kpi-pill" style="background:#f0fdf4;border:1px solid #bbf7d0;">
            <div class="kp-icon" style="background:#dcfce7;color:#166534;"><i class="ri-money-dollar-circle-line"></i></div>
            <div><div class="kp-val">Rs. ${parseFloat(res.total_value || 0).toLocaleString()}</div><div class="kp-lbl">Stock Value</div></div>
            <div class="kp-bg" style="background:#22c55e;"></div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="kpi-pill" style="background:#fef9c3;border:1px solid #fde047;">
            <div class="kp-icon" style="background:#fef08a;color:#854d0e;"><i class="ri-building-line"></i></div>
            <div><div class="kp-val">${res.warehouse_count || 0}</div><div class="kp-lbl">Warehouses</div></div>
            <div class="kp-bg" style="background:#eab308;"></div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="kpi-pill" style="background:#fdf4ff;border:1px solid #f3e8ff;">
            <div class="kp-icon" style="background:#f3e8ff;color:#7e22ce;"><i class="ri-archive-line"></i></div>
            <div><div class="kp-val">${res.batch_count || 0}</div><div class="kp-lbl">Batches</div></div>
            <div class="kp-bg" style="background:#a855f7;"></div>
          </div>
        </div>
      `);
      $('#currentStockBadge').text((res.total_stock || 0) + ' pcs');
    }
  });
};

window.loadTab = function(tab) {
  if (tab === 'overview') loadOverviewTab();
  else if (tab === 'warehouses') loadWarehouseTab();
  else if (tab === 'batches') loadBatchTab();
  else if (tab === 'transactions') loadTransactionTab();
};

window.loadOverviewTab = function() {
  $.get(BASE_URL + 'Stock_detail/get_warehouse_breakdown', { product_id: PRODUCT_ID }, function(res) {
    if (res.success && res.data) {
      let total = res.data.reduce((sum, w) => sum + parseFloat(w.quantity || 0), 0);
      let html = '';
      res.data.forEach(w => {
        let pct = total > 0 ? ((w.quantity / total) * 100).toFixed(1) : 0;
        html += `
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="fw-medium fs-13">${w.store_name}</span>
              <span class="fw-bold">${w.quantity} pcs (${pct}%)</span>
            </div>
            <div class="wh-bar"><div class="wh-bar-fill" style="width:${pct}%;"></div></div>
          </div>
        `;
      });
      $('#whDistribution').html(html || '<div class="empty-tab"><i class="ri-inbox-line"></i><p>No warehouse data</p></div>');
      
      let statsHtml = `
        <div class="col-6 col-md-3"><div class="ov-stat"><div class="ov-val">${total}</div><div class="ov-lbl">Total Stock</div></div></div>
        <div class="col-6 col-md-3"><div class="ov-stat"><div class="ov-val">${res.data.length}</div><div class="ov-lbl">Warehouses</div></div></div>
      `;
      $('#overviewStats').html(statsHtml);
    }
  });
};

window.loadWarehouseTab = function() {
  $.get(BASE_URL + 'Stock_detail/get_warehouse_breakdown', { product_id: PRODUCT_ID }, function(res) {
    if (res.success && res.data) {
      let total = res.data.reduce((sum, w) => sum + parseFloat(w.quantity || 0), 0);
      let html = '';
      res.data.forEach(w => {
        let pct = total > 0 ? ((w.quantity / total) * 100).toFixed(1) : 0;
        html += `
          <tr>
            <td>${w.store_name}</td>
            <td class="num">${w.quantity}</td>
            <td class="num">Rs. ${parseFloat(w.unit_cost || 0).toFixed(2)}</td>
            <td class="num">Rs. ${parseFloat(w.stock_value || 0).toLocaleString()}</td>
            <td>${pct}%</td>
          </tr>
        `;
      });
      $('#whTbody').html(html || '<tr><td colspan="5" class="text-center text-muted">No warehouse data</td></tr>');
    }
  });
};

window.loadBatchTab = function() {
  $.get(BASE_URL + 'Stock_detail/get_batches', { product_id: PRODUCT_ID }, function(res) {
    if (res.success && res.data) {
      let html = '';
      res.data.forEach(b => {
        let statusClass = b.expiry_status === 'VALID' ? 'sb-valid' : (b.expiry_status === 'NEAR' ? 'sb-near' : 'sb-expired');
        html += `
          <tr>
            <td>${b.batch_no || 'N/A'}</td>
            <td>${b.warehouse_name || 'N/A'}</td>
            <td class="num">${b.qty || 0}</td>
            <td>${b.expiry_date || 'N/A'}</td>
            <td>${b.days_left || 0} days</td>
            <td><span class="sb ${statusClass}">${b.expiry_status}</span></td>
          </tr>
        `;
      });
      $('#batchTbody').html(html || '<tr><td colspan="7" class="text-center text-muted">No batch data</td></tr>');
    }
  });
};

window.loadTransactionTab = function() {
  $.get(BASE_URL + 'Stock_detail/get_transactions', { product_id: PRODUCT_ID }, function(res) {
    if (res.success && res.data) {
      let html = '';
      res.data.forEach(t => {
        html += `
          <tr>
            <td>${t.transaction_date || 'N/A'}</td>
            <td>${t.transaction_type || 'N/A'}</td>
            <td>${t.reference_number || 'N/A'}</td>
            <td>${t.warehouse_name || 'N/A'}</td>
            <td class="num" style="color:#16a34a;font-weight:600;">${t.quantity_in || '—'}</td>
            <td class="num" style="color:#dc2626;font-weight:600;">${t.quantity_out || '—'}</td>
            <td>${t.user_name || 'N/A'}</td>
          </tr>
        `;
      });
      $('#txnTbody').html(html || '<tr><td colspan="7" class="text-center text-muted">No transactions</td></tr>');
    }
  });
};

$(document).ready(function() {
  loadKpiData();
  loadOverviewTab();
});
</script>
