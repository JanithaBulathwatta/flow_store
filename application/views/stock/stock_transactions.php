`	11<style>
.kstrip{display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1rem;}
.kscard{flex:1;min-width:160px;border-radius:10px;padding:.875rem 1.1rem;display:flex;align-items:center;gap:.75rem;position:relative;overflow:hidden;border:1px solid transparent;}
.kscard .ksi{width:42px;height:42px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
.kscard .ksv{font-size:1.25rem;font-weight:700;line-height:1;margin-bottom:2px;}
.kscard .ksl{font-size:.71rem;color:#64748b;font-weight:500;}
.kscard .kss{font-size:.67rem;color:#94a3b8;margin-top:1px;}
.kscard .ksbg{position:absolute;right:-10px;bottom:-10px;width:60px;height:60px;border-radius:50%;opacity:.06;}
.fcard{background:#fff;border:1px solid #e9ecef;border-radius:10px;padding:.875rem 1.1rem;}
.fcard-title{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:.875rem;display:flex;align-items:center;gap:.4rem;}
.drll-tbl{width:100%;border-collapse:separate;border-spacing:0;}
.drll-tbl thead th{background:#f8f9fb;font-size:.71rem;text-transform:uppercase;letter-spacing:.055em;color:#64748b;white-space:nowrap;padding:.6rem .875rem;border-bottom:2px solid #e9ecef;}
.drll-tbl td{padding:.58rem .875rem;border-bottom:1px solid #f1f5f9;vertical-align:middle;font-size:.8rem;}
.drll-tbl tbody tr:hover td{background:#f8faff!important;}
.drll-tbl tbody tr.type-GRN td:first-child{border-left:3px solid #22c55e;}
.drll-tbl tbody tr.type-SALE td:first-child{border-left:3px solid #ef4444;}
.drll-tbl tbody tr.type-ADJUSTMENT td:first-child{border-left:3px solid #3b82f6;}
.drll-tbl tbody tr.type-TRANSFERIN td:first-child{border-left:3px solid #8b5cf6;}
.drll-tbl tbody tr.type-TRANSFEROUT td:first-child{border-left:3px solid #a855f7;}
.drll-tbl tbody tr.type-RETURNIN td:first-child{border-left:3px solid #10b981;}
.drll-tbl tbody tr.type-RETURNOUT td:first-child{border-left:3px solid #f59e0b;}
.qin{color:#16a34a;font-weight:700;}
.qout{color:#dc2626;font-weight:700;}
.qbal{font-weight:700;color:#405189;font-size:.875rem;}
.qbal.neg{color:#dc2626;}
.qnil{color:#cbd5e1;}
.num{text-align:right;font-variant-numeric:tabular-nums;}
.tbadge{display:inline-flex;align-items:center;gap:3px;padding:2px 9px;border-radius:5px;font-size:.7rem;font-weight:600;white-space:nowrap;}
.tb-GRN{background:#dcfce7;color:#166534;}.tb-SALE{background:#fee2e2;color:#991b1b;}.tb-ADJUSTMENT{background:#dbeafe;color:#1e40af;}
.tb-TRANSFERIN{background:#f3e8ff;color:#6b21a8;}.tb-TRANSFEROUT{background:#f3e8ff;color:#7e22ce;}.tb-RETURNIN{background:#d1fae5;color:#065f46;}.tb-RETURNOUT{background:#fef3c7;color:#92400e;}
.mode-banner{border-radius:10px;padding:.875rem 1.25rem;margin-bottom:1rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;}
.mode-banner.prod-mode{background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #bfdbfe;}
.drll-toolbar{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;padding:.6rem .875rem;background:#f8f9fb;border-bottom:1px solid #e9ecef;}
</style>

<div class="main-content app-content">
  <div class="container-fluid">

    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
      <div>
        <nav><ol class="breadcrumb mb-1">
          <li class="breadcrumb-item"><a href="<?= base_url('Stock_report') ?>">Inventory</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('Stock_report') ?>">Stock Report</a></li>
          <li class="breadcrumb-item active">Stock Transactions</li>
        </ol></nav>
        <h1 class="page-title fw-semibold fs-18 mb-0">Stock Transactions</h1>
      </div>
      <div class="d-flex gap-2 flex-wrap mt-md-0 mt-2 align-items-center">
        <a href="<?= base_url('Stock_report') ?>" class="btn btn-light btn-sm"><i class="ri-arrow-left-line me-1"></i>Stock Report</a>
        <?php if ($product_id): ?>
        <a href="<?= base_url('Stock_detail?pid=' . $product_id) ?>" class="btn btn-primary-light btn-sm"><i class="ri-bar-chart-box-line me-1"></i>Product Detail</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Product Mode Banner -->
    <?php if ($product_id && isset($product)): ?>
    <div class="mode-banner prod-mode">
      <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#405189,#6172b0);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="ri-box-3-line text-white fs-20"></i>
      </div>
      <div class="flex-fill">
        <div class="fw-bold fs-14"><?= htmlspecialchars($product['name']) ?></div>
        <div class="d-flex gap-3 flex-wrap mt-1">
          <span class="text-muted fs-12"><i class="ri-price-tag-3-line me-1"></i>SKU: <strong><?= htmlspecialchars($product['product_code'] ?? 'N/A') ?></strong></span>
          <span class="text-muted fs-12"><i class="ri-folder-line me-1"></i>Category: <strong><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></strong></span>
        </div>
      </div>
      <div class="text-end">
        <div class="text-muted fs-11 mb-1">Current Stock</div>
        <div class="text-muted fs-12" id="bannerStock">—</div>
      </div>
    </div>
    <?php endif; ?>

    <!-- KPI Summary Strip -->
    <div class="kstrip" id="kpiStrip"></div>

    <!-- Two-Column Layout -->
    <div class="row g-3">

      <!-- Filter Sidebar -->
      <div class="col-xl-2 col-lg-3 col-md-12">
        <div class="fcard mb-3">
          <div class="fcard-title"><i class="ri-filter-3-line"></i> Filters</div>

          <div class="mb-3">
            <label class="form-label fw-medium fs-12 mb-1">Date Range</label>
            <input type="date" class="form-control form-control-sm mb-1" id="fDateFrom" value="<?= date('Y-m-01') ?>">
            <input type="date" class="form-control form-control-sm" id="fDateTo" value="<?= date('Y-m-d') ?>">
          </div>

          <div class="mb-3">
            <label class="form-label fw-medium fs-12 mb-1">Warehouse</label>
            <select class="form-select form-select-sm" id="fWh">
              <option value="">All Warehouses</option>
              <?php foreach ($stores as $store): ?>
              <option value="<?= $store->id ?>"><?= htmlspecialchars($store->name) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-medium fs-12 mb-1">Transaction Type</label>
            <div class="form-check form-check-sm mb-1">
              <input class="form-check-input type-check" type="checkbox" value="GRN" id="tGRN" checked>
              <label class="form-check-label fs-12" for="tGRN">GRN</label>
            </div>
            <div class="form-check form-check-sm mb-1">
              <input class="form-check-input type-check" type="checkbox" value="SALE" id="tSale" checked>
              <label class="form-check-label fs-12" for="tSale">Sale</label>
            </div>
            <div class="form-check form-check-sm mb-1">
              <input class="form-check-input type-check" type="checkbox" value="ADJUSTMENT" id="tAdj" checked>
              <label class="form-check-label fs-12" for="tAdj">Adjustment</label>
            </div>
            <div class="form-check form-check-sm mb-1">
              <input class="form-check-input type-check" type="checkbox" value="TRANSFER_IN" id="tTransIn" checked>
              <label class="form-check-label fs-12" for="tTransIn">Transfer In</label>
            </div>
            <div class="form-check form-check-sm mb-1">
              <input class="form-check-input type-check" type="checkbox" value="TRANSFER_OUT" id="tTransOut" checked>
              <label class="form-check-label fs-12" for="tTransOut">Transfer Out</label>
            </div>
            <div class="form-check form-check-sm mb-1">
              <input class="form-check-input type-check" type="checkbox" value="RETURN_IN" id="tRetIn" checked>
              <label class="form-check-label fs-12" for="tRetIn">Return In</label>
            </div>
            <div class="form-check form-check-sm">
              <input class="form-check-input type-check" type="checkbox" value="RETURN_OUT" id="tRetOut" checked>
              <label class="form-check-label fs-12" for="tRetOut">Return Out</label>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-medium fs-12 mb-1">Quick Search</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="ri-search-line"></i></span>
              <input type="text" class="form-control" id="fSearch" placeholder="Ref / batch…">
            </div>
          </div>

          <button class="btn btn-primary btn-sm w-100 mb-2" onclick="applyFilters()">
            <i class="ri-filter-line me-1"></i>Apply Filters
          </button>
          <button class="btn btn-light btn-sm w-100" onclick="resetFilters()">
            <i class="ri-refresh-line me-1"></i>Reset
          </button>
        </div>
      </div>

      <!-- Main Table Column -->
      <div class="col-xl-10 col-lg-9 col-md-12">
        <div class="card custom-card">
          <div class="drll-toolbar">
            <span class="fw-semibold fs-13 me-auto">
              <i class="ri-swap-box-line me-2 text-primary"></i>Transaction Log
              <span class="badge bg-primary-transparent text-primary ms-2 fs-11" id="recBadge">0 records</span>
            </span>
            <button class="btn btn-sm btn-light" onclick="refreshData()">
              <i class="ri-refresh-line"></i>
            </button>
          </div>

          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="drll-tbl w-100">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Reference</th>
                    <th>Warehouse</th>
                    <th>Batch</th>
                    <th class="num">Qty In</th>
                    <th class="num">Qty Out</th>
                    <th class="num">Balance</th>
                    <th>User</th>
                  </tr>
                </thead>
                <tbody id="drllTbody"></tbody>
              </table>
            </div>
          </div>

          <div class="card-footer d-flex align-items-center justify-content-between flex-wrap gap-2 py-2">
            <div class="d-flex align-items-center gap-3">
              <span class="page-inf" id="pageInfo">Showing 0–0 of 0</span>
              <select class="form-select form-select-sm" id="pgSize" style="width:75px;" onchange="onPageSizeChange()">
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

    </div>

  </div>
</div>

<script>
const PRODUCT_ID = <?= $product_id ?? 'null' ?>;
const BASE_URL = '<?= base_url() ?>';
let currentPage = 1;
let currentPerPage = 20;

window.loadKpiData = function() {
  let params = { date_from: $('#fDateFrom').val(), date_to: $('#fDateTo').val() };
  if (PRODUCT_ID) params.product_id = PRODUCT_ID;
  
  $.get(BASE_URL + 'Stock_transactions/get_kpi_data', params, function(res) {
    if (res) {
		
		document.getElementById("bannerStock").innerHTML = res.total_in || 0;

		
      $('#kpiStrip').html(`
        <div class="kscard" style="background:#eff6ff;border-color:#bfdbfe;">
          <div class="ksi" style="background:#dbeafe;color:#1e40af;"><i class="ri-swap-box-line"></i></div>
          <div><div class="ksv">${res.total_transactions || 0}</div><div class="ksl">Total Transactions</div></div>
          <div class="ksbg" style="background:#3b82f6;"></div>
        </div>
        <div class="kscard" style="background:#f0fdf4;border-color:#bbf7d0;">
          <div class="ksi" style="background:#dcfce7;color:#166534;"><i class="ri-arrow-down-line"></i></div>
          <div><div class="ksv">${res.total_in || 0}</div><div class="ksl">Total In</div></div>
          <div class="ksbg" style="background:#22c55e;"></div>
        </div>
        <div class="kscard" style="background:#fef2f2;border-color:#fecaca;">
          <div class="ksi" style="background:#fee2e2;color:#991b1b;"><i class="ri-arrow-up-line"></i></div>
          <div><div class="ksv">${res.total_out || 0}</div><div class="ksl">Total Out</div></div>
          <div class="ksbg" style="background:#ef4444;"></div>
        </div>
      `);
    }
  });
};

window.loadTransactions = function(page = 1) {
  currentPage = page;
  let types = [];
  $('.type-check:checked').each(function() { types.push($(this).val()); });
  
  let filters = {
    date_from: $('#fDateFrom').val(),
    date_to: $('#fDateTo').val(),
    warehouse_id: $('#fWh').val(),
    type: types,
    search: $('#fSearch').val(),
    page: page,
    per_page: currentPerPage
  };
  
  if (PRODUCT_ID) filters.product_id = PRODUCT_ID;
  
  $.post(BASE_URL + 'Stock_transactions/filter', filters, function(res) {
    console.log('Transaction filter response:', res);
    if (res.success) {
      let html = '';
      if (res.data && res.data.length > 0) {
        console.log('Processing', res.data.length, 'transactions');
        res.data.forEach(t => {
          let typeClass = 'tb-' + (t.transaction_type || 'GRN').replace('_', '');
          let rowClass = 'type-' + (t.transaction_type || 'GRN').replace('_', '');
          let qtyIn = t.quantity_in > 0 ? `<span class="qin">${t.quantity_in}</span>` : '<span class="qnil">—</span>';
          let qtyOut = t.quantity_out > 0 ? `<span class="qout">${t.quantity_out}</span>` : '<span class="qnil">—</span>';
          let balClass = t.running_balance < 0 ? 'qbal neg' : 'qbal';
          
          html += `
            <tr class="${rowClass}">
              <td>${t.transaction_date || 'N/A'}</td>
              <td><span class="tbadge ${typeClass}">${t.transaction_type || 'N/A'}</span></td>
              <td>${t.reference_number || 'N/A'}</td>
              <td>${t.warehouse_name || 'N/A'}</td>
              <td>${t.batch_no || '—'}</td>
              <td class="num">${qtyIn}</td>
              <td class="num">${qtyOut}</td>
              <td class="num"><span class="${balClass}">${t.running_balance}</span></td>
              <td>${t.user_name || 'N/A'}</td>
            </tr>
          `;
        });
      } else {
        console.log('No data returned');
        html = '<tr><td colspan="9" class="text-center text-muted py-4">No transactions found</td></tr>';
      }
      $('#drllTbody').html(html);
      $('#recBadge').text(res.total + ' records');
      
      // Update pagination
      let start = (res.page - 1) * res.per_page + 1;
      let end = Math.min(res.page * res.per_page, res.total);
      $('#pageInfo').text(`Showing ${start}–${end} of ${res.total}`);
      
      renderPagination(res.page, res.total_pages);
    } else {
      console.error('Response success = false');
    }
  }, 'json').fail(function(xhr, status, error) {
    console.error('AJAX error:', error);
    console.error('Response:', xhr.responseText);
  });
};

window.renderPagination = function(current, total) {
  let html = '';
  if (total <= 1) {
    $('#pagination').html('');
    return;
  }
  
  if (current > 1) {
    html += `<li class="page-item"><a class="page-link" href="#" onclick="loadTransactions(${current - 1}); return false;">Prev</a></li>`;
  }
  
  for (let i = Math.max(1, current - 2); i <= Math.min(total, current + 2); i++) {
    let active = i === current ? 'active' : '';
    html += `<li class="page-item ${active}"><a class="page-link" href="#" onclick="loadTransactions(${i}); return false;">${i}</a></li>`;
  }
  
  if (current < total) {
    html += `<li class="page-item"><a class="page-link" href="#" onclick="loadTransactions(${current + 1}); return false;">Next</a></li>`;
  }
  
  $('#pagination').html(html);
};

window.applyFilters = function() {
  loadKpiData();
  loadTransactions(1);
};

window.resetFilters = function() {
  $('#fDateFrom').val('<?= date('Y-m-01') ?>');
  $('#fDateTo').val('<?= date('Y-m-d') ?>');
  $('#fWh').val('');
  $('#fSearch').val('');
  $('.type-check').prop('checked', true);
  applyFilters();
};

window.refreshData = function() {
  loadKpiData();
  loadTransactions(currentPage);
};

window.onPageSizeChange = function() {
  currentPerPage = $('#pgSize').val();
  loadTransactions(1);
};

$(document).ready(function() {
  loadKpiData();
  loadTransactions(1);
});
</script>
