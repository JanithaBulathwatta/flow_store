<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--
  Bootstrap CSS removed: styling now comes from the project dashboard theme below.
  Font Awesome + Google Fonts are added for icons/typography (remove if your layout already loads them).
-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700;800&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<style>
:root{
  --primary:#3d52a0;--primary-d:#2d3d80;--primary-light:#eef1fb;--primary-mid:#c5cff7;
  --success:#10b981;--success-light:#d1fae5;--success-d:#059669;
  --danger:#ef4444;--danger-light:#fee2e2;
  --warning:#f59e0b;--warning-light:#fef3c7;
  --info:#0ea5e9;--info-light:#e0f2fe;
  --purple:#8b5cf6;--purple-light:#ede9fe;
  --teal:#14b8a6;--teal-light:#ccfbf1;
  --orange:#f97316;--orange-light:#ffedd5;
  --page-bg:#f2f4fa;--card-border:#e4e9f4;
  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
  --input-border:#d1d9e6;--table-head:#f7f9ff;
  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.10);
  --r-sm:8px;--r-md:12px;--r-lg:16px;--tr:.2s cubic-bezier(.4,0,.2,1);
}

/* ── PAGE SHELL ── */
#gePage{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;padding:20px 22px;}
#gePage *,#gePage *::before,#gePage *::after{box-sizing:border-box;}
#gePage ::-webkit-scrollbar{width:5px;height:5px;}
#gePage ::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}
.ge-loading{opacity:.5;pointer-events:none}

/* helper classes emitted by the existing JS */
#gePage .num{text-align:right}
#gePage .text-center{text-align:center}
#gePage .text-muted{color:var(--text-muted)!important}
#gePage .text-success{color:var(--success-d)!important}
#gePage .text-danger{color:var(--danger)!important}
#gePage .font-weight-bold{font-weight:800}

/* ── HERO ── */
.ge-hero{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-lg);box-shadow:var(--sh-sm);margin-bottom:16px;overflow:hidden;}
.ge-hero-banner{background:linear-gradient(120deg,#1a1f36 0%,#2d3d80 45%,#3d52a0 100%);padding:22px 26px;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;}
.ge-hero-banner::before{content:'';position:absolute;top:-60px;right:-60px;width:260px;height:260px;border-radius:50%;background:rgba(255,255,255,.04);}
.ge-hero-banner::after{content:'';position:absolute;bottom:-30px;left:35%;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.03);}
.ge-hero-text{position:relative;z-index:1;}
.ge-code{font-family:'JetBrains Mono',monospace;font-size:11px;color:rgba(255,255,255,.55);font-weight:600;letter-spacing:.5px;margin-bottom:5px;}
.ge-title{font-size:21px;font-weight:800;color:#fff;letter-spacing:-.3px;line-height:1.2;margin:0;}
.ge-sub{font-size:13px;color:rgba(255,255,255,.65);margin-top:5px;display:flex;align-items:center;gap:6px;}
.ge-hero-actions{position:relative;z-index:1;display:flex;gap:8px;}

/* ── BUTTONS ── */
#gePage .btn{padding:9px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;justify-content:center;gap:7px;line-height:1.2;}
#gePage .btn-primary{background:var(--primary);color:#fff;box-shadow:0 2px 8px rgba(61,82,160,.22);}
#gePage .btn-primary:hover{background:var(--primary-d);transform:translateY(-1px);}
#gePage .btn-ho{background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.22);backdrop-filter:blur(8px);}
#gePage .btn-ho:hover{background:rgba(255,255,255,.22);}
#gePage .btn-block{width:100%;}

/* ── CARDS ── */
.ge-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;margin-bottom:16px;}
.ge-card-head{padding:12px 16px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:8px;}
.ge-card-head h6{font-size:12px;font-weight:700;color:var(--text-dark);margin:0;flex:1;}
.sec-icon{width:26px;height:26px;border-radius:6px;background:var(--primary-light);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:11px;flex-shrink:0;}
.ge-card-body{padding:14px 16px;}

/* ── FILTERS ── */
.ge-filter-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;align-items:end;}
.ge-field label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-mid);display:block;margin-bottom:5px;}
#gePage .fc{width:100%;padding:9px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr),box-shadow var(--tr);background:#fff;}
#gePage .fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}

/* ── KPI GRID ── */
.ge-kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px;}
.ge-kpi{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:16px 18px;box-shadow:var(--sh-sm);transition:all var(--tr);position:relative;overflow:hidden;}
.ge-kpi:hover{transform:translateY(-2px);box-shadow:var(--sh-md);}
.ge-kpi::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
.ge-kpi.k-total::before{background:linear-gradient(90deg,var(--danger),#f87171);}
.ge-kpi.k-entries::before{background:linear-gradient(90deg,var(--purple),#a78bfa);}
.ge-kpi.k-avg::before{background:linear-gradient(90deg,var(--teal),#2dd4bf);}
.ge-kpi.k-prev::before{background:linear-gradient(90deg,var(--warning),#fbbf24);}
.ge-kpi-icon{width:38px;height:38px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:10px;}
.ge-kpi h4{font-size:22px;font-weight:800;color:var(--text-dark);font-family:'JetBrains Mono',monospace;line-height:1;margin:0;}
.ge-kpi .ge-lbl{display:block;font-size:10px;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-top:6px;}
/* change line: JS replaces this element's class, so it is styled by id */
#kChange{display:block;font-size:11px;font-weight:700;margin-top:6px;color:var(--text-muted);}

/* ── CHARTS ROW ── */
.ge-charts-row{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px;}
.ge-charts-row .ge-card{margin-bottom:0;display:flex;flex-direction:column;}

/* ── BREAKDOWN ROW ── */
.ge-split-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;}
.ge-split-row .ge-card{margin-bottom:0;}

/* ── TOOLBAR ── */
.ge-toolbar{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:12px;}
.ge-toolbar h6{font-size:12px;font-weight:700;color:var(--text-dark);margin:0;flex:1;display:flex;align-items:center;gap:8px;}
.sw{position:relative;min-width:220px;}
.sw i{position:absolute;left:9px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;pointer-events:none;}
.sw input{width:100%;padding:7px 9px 7px 28px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;color:var(--text-dark);outline:none;transition:border-color var(--tr);background:#fff;}
.sw input:focus{border-color:var(--primary);}
.sw input::placeholder{color:var(--text-muted);}

/* ── TABLES ── */
.tbl-wrap{overflow-x:auto;border-radius:var(--r-md);border:1px solid var(--card-border);}
.tbl{width:100%;border-collapse:collapse;min-width:380px;margin:0;}
.tbl thead tr{background:var(--table-head);}
.tbl th{padding:10px 13px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);border-bottom:2px solid var(--card-border);text-align:left;white-space:nowrap;}
.tbl th.num{text-align:right;}
.tbl td{padding:10px 13px;font-size:13px;border-bottom:1px solid var(--card-border);vertical-align:middle;}
.tbl td.num{font-family:'JetBrains Mono',monospace;font-size:12px;}
.tbl tbody tr:last-child td{border-bottom:none;}
.tbl tbody tr{transition:background var(--tr);}
.tbl tbody tr:hover{background:#fafbff;}
.tbl tfoot td{background:var(--table-head);border-top:2px solid var(--card-border);border-bottom:none;font-size:13px;}
#geRows{min-width:580px;}
#geRows td, #geRows th { white-space:nowrap }
#geRows td:nth-child(2){font-family:'JetBrains Mono',monospace;font-size:11px;font-weight:600;color:var(--primary);}

/* ── RESPONSIVE ── */
@media (max-width:1100px){
  .ge-filter-grid{grid-template-columns:repeat(3,1fr);}
  .ge-kpi-grid{grid-template-columns:repeat(2,1fr);}
  .ge-charts-row,.ge-split-row{grid-template-columns:1fr;}
}
@media (max-width:575px){
  .ge-filter-grid{grid-template-columns:repeat(2,1fr);}
  #gePage{padding:14px 12px;}
}

h1{
	color: #fff !important;
}
</style>

<div class="main-content app-content">
<div id="gePage">

  <!-- Hero -->
  <div class="ge-hero">
    <div class="ge-hero-banner">
      <div class="ge-hero-text">
        <div class="ge-code">Reports · Expenses</div>
        <h1 class="ge-title"><?php echo html_escape($title); ?></h1>
        <div class="ge-sub"><i class="fa-solid fa-receipt" style="font-size:11px;"></i> Expenses that are not linked to a project</div>
      </div>
      <div class="ge-hero-actions">
        <button class="btn btn-ho" id="geExport" type="button"><i class="fa-solid fa-file-csv"></i>Export CSV</button>
      </div>
    </div>
  </div>

  <!-- Filters -->
  <div class="ge-card">
    <div class="ge-card-head">
      <div class="sec-icon"><i class="fa-solid fa-filter"></i></div>
      <h6>Filters</h6>
    </div>
    <div class="ge-card-body">
      <form id="geFilters" class="ge-filter-grid">
        <div class="ge-field">
          <label>From</label>
          <input type="date" name="from" class="fc" value="<?php echo date('Y-m-01'); ?>">
        </div>
        <div class="ge-field">
          <label>To</label>
          <input type="date" name="to" class="fc" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="ge-field">
          <label>Family</label>
          <select name="family_id" id="geFamily" class="fc">
            <option value="">All families</option>
            <?php foreach ($families as $fm): ?>
              <option value="<?php echo (int) $fm['family_id']; ?>"><?php echo html_escape($fm['family_name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="ge-field">
          <label>Category</label>
          <select name="cat_id" id="geCat" class="fc">
            <option value="">All categories</option>
            <?php foreach ($categories as $c): ?>
              <option value="<?php echo (int) $c['exp_cat_id']; ?>" data-family="<?php echo (int) $c['family_id']; ?>"><?php echo html_escape($c['exp_cat_name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="ge-field">
          <label>Status</label>
          <select name="status" class="fc">
            <option value="ACTIVE">Active</option>
            <option value="BOTH">Active + pending</option>
            <option value="PENDING">Pending</option>
            <option value="DELETED">Deleted</option>
          </select>
        </div>
        <div class="ge-field">
          <button type="submit" class="btn btn-primary btn-block"><i class="fa-solid fa-magnifying-glass"></i>Show report</button>
        </div>
      </form>
    </div>
  </div>

  <!-- KPIs -->
  <div class="ge-kpi-grid">
    <div class="ge-kpi k-total">
      <div class="ge-kpi-icon" style="background:var(--danger-light);color:var(--danger);"><i class="fa-solid fa-receipt"></i></div>
      <h4 id="kTotal" class="text-danger">0.00</h4><small class="ge-lbl">Total expenses</small>
    </div>
    <div class="ge-kpi k-entries">
      <div class="ge-kpi-icon" style="background:var(--purple-light);color:var(--purple);"><i class="fa-solid fa-layer-group"></i></div>
      <h4 id="kEntries">0</h4><small class="ge-lbl">Entries</small>
    </div>
    <div class="ge-kpi k-avg">
      <div class="ge-kpi-icon" style="background:var(--teal-light);color:var(--teal);"><i class="fa-solid fa-calculator"></i></div>
      <h4 id="kAvg">0.00</h4><small class="ge-lbl">Average per entry</small>
    </div>
    <div class="ge-kpi k-prev">
      <div class="ge-kpi-icon" style="background:var(--warning-light);color:var(--warning);"><i class="fa-solid fa-clock-rotate-left"></i></div>
      <h4 id="kPrev">0.00</h4><small class="ge-lbl">Previous period</small><small id="kChange"></small>
    </div>
  </div>

  <!-- Charts -->
  <div class="ge-charts-row">
    <div class="ge-card">
      <div class="ge-card-head">
        <div class="sec-icon" style="background:var(--danger-light);color:var(--danger);"><i class="fa-solid fa-chart-column"></i></div>
        <h6>Spending over time</h6>
      </div>
      <div class="ge-card-body">
        <div style="height:260px"><canvas id="cTrend"></canvas></div>
      </div>
    </div>
    <div class="ge-card">
      <div class="ge-card-head">
        <div class="sec-icon" style="background:var(--purple-light);color:var(--purple);"><i class="fa-solid fa-chart-pie"></i></div>
        <h6>By expense family</h6>
      </div>
      <div class="ge-card-body">
        <div style="height:260px"><canvas id="cFamily"></canvas></div>
      </div>
    </div>
  </div>

  <!-- Breakdown tables -->
  <div class="ge-split-row">
    <div class="ge-card">
      <div class="ge-card-head">
        <div class="sec-icon" style="background:var(--orange-light);color:var(--orange);"><i class="fa-solid fa-tags"></i></div>
        <h6>Top categories</h6>
      </div>
      <div class="ge-card-body">
        <div class="tbl-wrap">
          <table class="tbl" id="geCats">
            <thead><tr><th>Category</th><th class="num">Entries</th><th class="num">Total</th><th class="num">Share</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="ge-card">
      <div class="ge-card-head">
        <div class="sec-icon" style="background:var(--teal-light);color:var(--teal);"><i class="fa-solid fa-list"></i></div>
        <h6>Top expense types</h6>
      </div>
      <div class="ge-card-body">
        <div class="tbl-wrap">
          <table class="tbl" id="geTypes">
            <thead><tr><th>Type</th><th class="num">Entries</th><th class="num">Total</th><th class="num">Share</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Expense list -->
  <div class="ge-card">
    <div class="ge-card-body">
      <div class="ge-toolbar">
        <h6><span class="sec-icon"><i class="fa-solid fa-receipt"></i></span>Expenses</h6>
        <div class="sw">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" id="geSearch" placeholder="Search reference, note, category">
        </div>
      </div>
      <div class="tbl-wrap">
        <table class="tbl" id="geRows">
          <thead>
            <tr><th>Date</th><th>Reference</th><th>Family</th><th>Category</th><th>Type</th><th>Note</th><th class="num">Qty</th><th class="num">Unit</th><th class="num">Total</th><th>Status</th></tr>
          </thead>
          <tbody></tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
  </div>

</div>
</div>

<script>
(function ($) {
  var URL_DATA = '<?php echo site_url("/Report/general_expenses_data"); ?>';
  var trendChart = null, famChart = null, rows = [];

  function n(v) { return parseFloat(v) || 0; }
  function money(v) { return n(v).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}); }
  function esc(s) { return $('<div>').text(s == null ? '' : s).html(); }

  // Category list follows the selected family
  $('#geFamily').on('change', function () {
    var fam = $(this).val();
    $('#geCat').val('');
    $('#geCat option[data-family]').each(function () {
      var show = !fam || String($(this).data('family')) === fam;
      $(this).prop('hidden', !show).prop('disabled', !show);
    });
  });

  function load() {
    var $page = $('#gePage').addClass('ge-loading');
    $.ajax({url: URL_DATA, type: 'GET', dataType: 'json', data: $('#geFilters').serialize()})
      .done(function (res) {
        if (!res || !res.success) { alert('Could not load the report.'); return; }
        renderKpis(res.summary);
        renderTrend(res.trend);
        renderFamilies(res.families);
        renderBreakdown('#geCats', res.categories, res.summary.total);
        renderBreakdown('#geTypes', res.types, res.summary.total);
        rows = res.rows;
        renderRows();
      })
      .fail(function () { alert('Request failed. Check your connection and try again.'); })
      .always(function () { $page.removeClass('ge-loading'); });
  }

  function renderKpis(s) {
    $('#kTotal').text(money(s.total));
    $('#kEntries').text(s.entries);
    $('#kAvg').text(money(s.average));
    $('#kPrev').text(money(s.prev_total));
    if (s.change_pct === null) {
      $('#kChange').attr('class', '').text('No spending in the previous period');
    } else {
      var up = n(s.change_pct) > 0;
      $('#kChange').attr('class', up ? 'text-danger' : 'text-success')
        .text((up ? '+' : '') + s.change_pct + '% vs previous period');
    }
  }

  function renderTrend(d) {
    if (trendChart) trendChart.destroy();
    trendChart = new Chart(document.getElementById('cTrend'), {
      type: 'bar',
      data: {labels: d.map(function (x) { return x.label; }),
             datasets: [{label: 'Expenses', data: d.map(function (x) { return n(x.total); }), backgroundColor: '#b8420d', borderRadius: 3}]},
      options: {maintainAspectRatio: false, plugins: {legend: {display: false}}, scales: {y: {beginAtZero: true}}}
    });
  }

  function renderFamilies(f) {
    if (famChart) famChart.destroy();
    famChart = new Chart(document.getElementById('cFamily'), {
      type: 'doughnut',
      data: {labels: f.map(function (x) { return x.name; }),
             datasets: [{data: f.map(function (x) { return n(x.total); }), backgroundColor: f.map(function (x) { return x.color; })}]},
      options: {maintainAspectRatio: false, plugins: {legend: {position: 'bottom'}}}
    });
  }

  function renderBreakdown(sel, list, total) {
    var h = list.length ? '' : '<tr><td colspan="4" class="text-center text-muted">No expenses in this period.</td></tr>';
    list.forEach(function (c) {
      h += '<tr><td>' + esc(c.name) + '</td><td class="num">' + c.entries + '</td><td class="num">' + money(c.total) +
           '</td><td class="num">' + (n(total) > 0 ? (n(c.total) / n(total) * 100).toFixed(1) + '%' : '-') + '</td></tr>';
    });
    $(sel + ' tbody').html(h);
  }

  function renderRows() {
    var q = $.trim($('#geSearch').val()).toLowerCase();
    var list = rows.filter(function (r) {
      return !q || [r.reference_no, r.note, r.exp_cat_name, r.Exp_Type_name].join(' ').toLowerCase().indexOf(q) > -1;
    });
    var h = list.length ? '' : '<tr><td colspan="10" class="text-center text-muted">No expenses match these filters.</td></tr>';
    var total = 0;
    list.forEach(function (r) {
      total += n(r.total_amount);
      h += '<tr><td>' + esc(r.expense_date) + '</td><td>' + esc(r.reference_no) + '</td><td>' + esc(r.family_name) +
           '</td><td>' + esc(r.exp_cat_name) + '</td><td>' + esc(r.Exp_Type_name) +
           '</td><td style="white-space:normal;min-width:160px">' + esc(r.note) + '</td><td class="num">' + esc(r.qty) +
           '</td><td class="num">' + money(r.unit_amount) + '</td><td class="num">' + money(r.total_amount) + '</td><td>' + esc(r.status) + '</td></tr>';
    });
    $('#geRows tbody').html(h);
    $('#geRows tfoot').html(list.length ? '<tr class="font-weight-bold"><td colspan="8">Total (' + list.length + ')</td><td class="num">' + money(total) + '</td><td></td></tr>' : '');
  }

  function exportCsv() {
    var out = [['Date', 'Reference', 'Family', 'Category', 'Type', 'Note', 'Qty', 'Unit amount', 'Total', 'Status']];
    rows.forEach(function (r) {
      out.push([r.expense_date, r.reference_no, r.family_name, r.exp_cat_name, r.Exp_Type_name, r.note, r.qty, r.unit_amount, r.total_amount, r.status]);
    });
    var csv = out.map(function (line) {
      return line.map(function (c) { return '"' + String(c == null ? '' : c).replace(/"/g, '""') + '"'; }).join(',');
    }).join('\n');
    var a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([csv], {type: 'text/csv'}));
    a.download = 'general-expenses.csv';
    a.click();
  }

  $('#geFilters').on('submit', function (e) { e.preventDefault(); load(); });
  $('#geSearch').on('input', renderRows);
  $('#geExport').on('click', exportCsv);
  load();
})(jQuery);
</script>