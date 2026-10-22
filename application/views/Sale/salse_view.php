<style>
:root {
  --primary: #3d52a0;
  --primary-d: #2d3d80;
  --primary-light: #eef1fb;
  --primary-mid: #c5cff7;
  --success: #10b981;
  --success-light: #d1fae5;
  --danger: #ef4444;
  --danger-light: #fee2e2;
  --warning: #f59e0b;
  --warning-light: #fef3c7;
  --info: #0ea5e9;
  --info-light: #e0f2fe;
  --sidebar-bg: #1a1f36;
  --sidebar-text: #a8b4d8;
  --page-bg: #f2f4fa;
  --card-bg: #ffffff;
  --card-border: #e4e9f4;
  --text-dark: #1a1f36;
  --text-mid: #4a5568;
  --text-muted: #8a94a6;
  --input-border: #d1d9e6;
  --table-head: #f7f9ff;
  --sh-sm: 0 1px 4px rgba(61,82,160,.07);
  --sh-md: 0 4px 18px rgba(61,82,160,.10);
  --r-sm: 8px;
  --r-md: 12px;
  --r-lg: 16px;
  --sidebar-w: 240px;
  --header-h: 60px;
  --tr: .2s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--page-bg); color: var(--text-dark); font-size: 14px; overflow-x: hidden; }
::-webkit-scrollbar { width: 5px; } ::-webkit-scrollbar-thumb { background: #c5cff7; border-radius: 10px; }

/* SIDEBAR */
.sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-w); background: var(--sidebar-bg); z-index: 100; display: flex; flex-direction: column; }
.sb-logo { height: var(--header-h); display: flex; align-items: center; padding: 0 18px; border-bottom: 1px solid rgba(255,255,255,.06); }
.logo-m { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg,#3d52a0,#7b8dd1); display: flex; align-items: center; justify-content: center; font-size: 15px; color: #fff; font-weight: 800; flex-shrink: 0; }
.logo-t { margin-left: 10px; color: #fff; font-weight: 700; font-size: 15px; } .logo-t span { color: #7b8dd1; }
.sb-nav { flex: 1; overflow-y: auto; padding: 10px 0; }
.sb-cat { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(168,180,216,.4); padding: 14px 18px 5px; }
.sb-link { display: flex; align-items: center; gap: 10px; padding: 9px 18px; color: var(--sidebar-text); text-decoration: none; font-size: 13px; font-weight: 500; cursor: pointer; transition: all var(--tr); }
.sb-link i { font-size: 15px; width: 18px; text-align: center; flex-shrink: 0; }
.sb-link:hover { background: rgba(255,255,255,.05); color: #fff; }
.sb-link.active { background: rgba(61,82,160,.28); color: #fff; border-right: 3px solid #7b8dd1; }

/* HEADER */
.header { position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: var(--header-h); background: #fff; border-bottom: 1px solid var(--card-border); display: flex; align-items: center; justify-content: space-between; padding: 0 22px; z-index: 90; box-shadow: var(--sh-sm); }
.bc { display: flex; align-items: center; gap: 5px; font-size: 13px; color: var(--text-muted); }
.bc a { color: var(--primary); text-decoration: none; font-weight: 500; }
.bc .sep { color: #ccc; } .bc .cur { color: var(--text-dark); font-weight: 600; }
.hdr-r { display: flex; align-items: center; gap: 10px; }
.hbtn { width: 34px; height: 34px; border-radius: var(--r-sm); border: 1px solid var(--card-border); background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-muted); transition: all var(--tr); position: relative; }
.hbtn:hover { border-color: var(--primary); color: var(--primary); }
.hbtn .dot { position: absolute; top: 6px; right: 6px; width: 7px; height: 7px; border-radius: 50%; background: var(--danger); border: 1.5px solid #fff; }
.upill { display: flex; align-items: center; gap: 8px; background: var(--primary-light); border-radius: 20px; padding: 4px 12px 4px 4px; cursor: pointer; }
.uav { width: 26px; height: 26px; border-radius: 50%; background: linear-gradient(135deg,#3d52a0,#7b8dd1); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 11px; font-weight: 700; }
.unm { font-size: 12px; font-weight: 600; color: var(--primary); }

/* MAIN */
.main { margin-left: var(--sidebar-w); margin-top: var(--header-h); padding: 22px; min-height: calc(100vh - var(--header-h)); }

/* PROFILE HERO */
.hero { background: #fff; border: 1px solid var(--card-border); border-radius: var(--r-lg); box-shadow: var(--sh-sm); margin-bottom: 18px; overflow: hidden; }
.hero-top { background: linear-gradient(110deg, #1a1f36 0%, #2d3d80 50%, #3d52a0 100%); padding: 28px 28px 0; position: relative; overflow: hidden; }
.hero-top::before { content: ''; position: absolute; top: -40px; right: -40px; width: 220px; height: 220px; border-radius: 50%; background: rgba(255,255,255,.04); }
.hero-top::after { content: ''; position: absolute; bottom: -20px; left: 30%; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,.03); }
.hero-inner { display: flex; align-items: flex-end; gap: 20px; position: relative; z-index: 1; }
.cust-av { width: 72px; height: 72px; border-radius: var(--r-md); background: linear-gradient(135deg, #7b8dd1, #3d52a0); display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: 800; color: #fff; flex-shrink: 0; border: 3px solid rgba(255,255,255,.2); margin-bottom: -1px; }
.hero-name-block { padding-bottom: 18px; }
.hero-name { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -.3px; }
.hero-type { font-size: 12px; color: rgba(255,255,255,.6); margin-top: 3px; display: flex; align-items: center; gap: 6px; }
.hero-actions { margin-left: auto; padding-bottom: 18px; display: flex; gap: 8px; position: relative; z-index: 1; }
.btn { padding: 8px 14px; border-radius: var(--r-sm); font-family: inherit; font-size: 12px; font-weight: 700; cursor: pointer; border: none; transition: all var(--tr); display: inline-flex; align-items: center; gap: 6px; }
.btn-white { background: rgba(255,255,255,.15); color: #fff; border: 1px solid rgba(255,255,255,.25); backdrop-filter: blur(8px); }
.btn-white:hover { background: rgba(255,255,255,.25); }
.btn-primary { background: #fff; color: var(--primary); }
.btn-primary:hover { background: var(--primary-light); }
.btn-outline { background: #fff; color: var(--text-mid); border: 1.5px solid var(--card-border); font-size: 12px; }
.btn-outline:hover { border-color: var(--primary); color: var(--primary); }
.btn-sm { padding: 6px 12px; font-size: 12px; }

/* Hero stats strip */
.hero-stats { display: grid; grid-template-columns: repeat(4, 1fr); border-top: 1px solid var(--card-border); }
.hs-item { padding: 16px 20px; border-right: 1px solid var(--card-border); }
.hs-item:last-child { border-right: none; }
.hs-label { font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 5px; }
.hs-value { font-size: 18px; font-weight: 800; color: var(--text-dark); font-family: 'JetBrains Mono', monospace; }
.hs-sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
.hs-value.green { color: var(--success); }
.hs-value.red { color: var(--danger); }
.hs-value.amber { color: var(--warning); }

/* STATUS BADGE */
.status-pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.sp-active { background: var(--success-light); color: #065f46; }
.sp-inactive { background: #f0f0f0; color: #6c757d; }
.sp-blocked { background: var(--danger-light); color: #991b1b; }

/* GRID LAYOUT */
.body-grid { display: grid; grid-template-columns: 300px 1fr; gap: 16px; align-items: start; }

/* CARDS */
.card { background: #fff; border: 1px solid var(--card-border); border-radius: var(--r-md); box-shadow: var(--sh-sm); margin-bottom: 14px; overflow: hidden; }
.card:last-child { margin-bottom: 0; }
.card-head { padding: 13px 16px; border-bottom: 1px solid var(--card-border); display: flex; align-items: center; gap: 9px; }
.card-head h6 { font-size: 13px; font-weight: 700; color: var(--text-dark); margin: 0; flex: 1; }
.sec-icon { width: 28px; height: 28px; border-radius: 6px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 12px; flex-shrink: 0; }
.card-body { padding: 16px; }

/* DETAIL ROWS */
.detail-row { display: flex; align-items: flex-start; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid var(--card-border); gap: 12px; }
.detail-row:last-child { border-bottom: none; padding-bottom: 0; }
.detail-row:first-child { padding-top: 0; }
.dr-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .4px; flex-shrink: 0; white-space: nowrap; }
.dr-value { font-size: 13px; font-weight: 600; color: var(--text-dark); text-align: right; }
.dr-value.mono { font-family: 'JetBrains Mono', monospace; }
.dr-value.muted { color: var(--text-muted); font-weight: 500; }
.dr-value a { color: var(--primary); text-decoration: none; }

/* CREDIT BAR */
.credit-bar-wrap { width: 100%; height: 6px; background: #e8ecf4; border-radius: 10px; overflow: hidden; margin-top: 5px; }
.credit-bar-fill { height: 100%; border-radius: 10px; transition: width .5s ease; }
.cb-green { background: linear-gradient(90deg, var(--success), #34d399); }
.cb-amber { background: linear-gradient(90deg, var(--warning), #fbbf24); }
.cb-red { background: linear-gradient(90deg, var(--danger), #f87171); }

/* TABS */
.tabs { display: flex; gap: 0; border-bottom: 2px solid var(--card-border); margin-bottom: 16px; }
.tab { padding: 10px 16px; font-size: 13px; font-weight: 600; color: var(--text-muted); cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all var(--tr); display: flex; align-items: center; gap: 6px; }
.tab:hover { color: var(--primary); }
.tab.active { color: var(--primary); border-bottom-color: var(--primary); font-weight: 700; }
.tab-cnt { font-size: 10px; font-weight: 800; padding: 1px 6px; border-radius: 20px; background: var(--primary-mid); color: var(--primary); }
.tab.active .tab-cnt { background: var(--primary); color: #fff; }
.tab-pane { display: none; } .tab-pane.active { display: block; }

/* TABLE */
.tbl-wrap { overflow-x: auto; border-radius: var(--r-md); border: 1px solid var(--card-border); }
.tbl { width: 100%; border-collapse: collapse; min-width: 520px; }
.tbl thead tr { background: var(--table-head); }
.tbl th { padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); border-bottom: 2px solid var(--card-border); white-space: nowrap; text-align: left; }
.tbl th.r, .tbl td.r { text-align: right; }
.tbl td { padding: 11px 14px; font-size: 13px; border-bottom: 1px solid var(--card-border); color: var(--text-dark); vertical-align: middle; }
.tbl tbody tr:last-child td { border-bottom: none; }
.tbl tbody tr { transition: background var(--tr); }
.tbl tbody tr:hover { background: #fafbff; }
.mono { font-family: 'JetBrains Mono', monospace; }

/* INVOICE STATUS */
.inv-badge { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
.ib-paid { background: var(--success-light); color: #065f46; }
.ib-partial { background: var(--warning-light); color: #92400e; }
.ib-pending { background: var(--info-light); color: #0369a1; }
.ib-overdue { background: var(--danger-light); color: #991b1b; }
.ib-draft { background: #f0f0f0; color: #6c757d; }

/* PAYMENT METHOD BADGE */
.pay-badge { display: inline-flex; align-items: center; gap: 3px; font-size: 11px; font-weight: 600; padding: 2px 7px; border-radius: 4px; }
.pb-cash { background: var(--success-light); color: #065f46; }
.pb-card { background: var(--primary-light); color: var(--primary); }
.pb-bank { background: var(--info-light); color: #0369a1; }
.pb-cheque { background: var(--warning-light); color: #92400e; }
.pb-credit { background: var(--danger-light); color: #991b1b; }

/* EMPTY */
.empty-rows td { text-align: center; padding: 36px 20px; color: var(--text-muted); }
.empty-rows i { font-size: 30px; opacity: .2; display: block; margin-bottom: 8px; }

/* TOAST */
#toast-c { position: fixed; top: 68px; right: 22px; z-index: 9999; display: flex; flex-direction: column; gap: 7px; pointer-events: none; }
.t-item { padding: 10px 16px; border-radius: var(--r-sm); font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 7px; box-shadow: 0 4px 16px rgba(0,0,0,.18); animation: tIn .25s ease; }
@keyframes tIn { from { opacity:0; transform: translateX(16px); } to { opacity:1; transform: translateX(0); } }
.t-s { background: var(--success); color: #fff; }
.t-i { background: var(--primary); color: #fff; }

/* MISC */
.fw-700 { font-weight: 700; }
.text-success { color: var(--success); }
.text-danger { color: var(--danger); }
.text-muted { color: var(--text-muted); }
.fs-11 { font-size: 11px; }
.d-flex { display: flex; } .ac { align-items: center; } .gap-2 { gap: 8px; } .ml-auto { margin-left: auto; }
</style>

<aside class="sidebar">
  <div class="sb-logo"><div class="logo-m">E</div><div class="logo-t">Rixzo <span>ERP</span></div></div>
  <div class="sb-nav">
    <div class="sb-cat">Main</div>
    <a class="sb-link" href="<?php echo site_url('Dashboard'); ?>"><i class="fa-solid fa-gauge-high"></i>Dashboard</a>
    <div class="sb-cat">Sales</div>
    <a class="sb-link" href="<?php echo site_url('Sales/invoice'); ?>"><i class="fa-solid fa-file-invoice-dollar"></i>Sales Invoice</a>
    <a class="sb-link active" href="<?php echo site_url('Sales/get_invoices'); ?>"><i class="fa-solid fa-list-check"></i>Invoice List</a>
    <a class="sb-link" href="<?php echo site_url('Customer'); ?>"><i class="fa-solid fa-users"></i>Customers</a>
    <div class="sb-cat">Inventory</div>
    <a class="sb-link" href="<?php echo site_url('Stock'); ?>"><i class="fa-solid fa-boxes-stacked"></i>Stock</a>
    <div class="sb-cat">Finance</div>
    <a class="sb-link" href="<?php echo site_url('Finance/cheque_book'); ?>"><i class="fa-solid fa-book"></i>Cheque Book</a>
    <a class="sb-link" href="<?php echo site_url('Reports'); ?>"><i class="fa-solid fa-chart-bar"></i>Reports</a>
  </div>
</aside>

<header class="header">
  <div class="bc"><a href="<?php echo site_url('Sales/get_invoices'); ?>">Invoices</a><span class="sep">›</span><span class="cur"><?php echo $invoice->invoice_no; ?></span></div>
  <div class="hdr-r">
    <div class="hbtn"><i class="fa-solid fa-magnifying-glass"></i></div>
    <div class="hbtn"><i class="fa-solid fa-bell"></i><span class="dot"></span></div>
    <div class="upill"><div class="uav">AD</div><span class="unm">Admin</span></div>
  </div>
</header>

<main class="main">

  <div class="hero">
    <div class="hero-top">
      <div class="hero-inner">
        <div class="cust-av" style="background:var(--primary-light); color:var(--primary);">
          <i class="fa-solid fa-file-invoice" style="font-size: 24px;"></i>
        </div>
        <div class="hero-name-block">
          <div class="hero-name"><?php echo $invoice->invoice_no; ?></div>
          <div class="hero-type">
            <span class="status-pill <?php echo $invoice->status == 'COMPLETED' ? 'sp-active' : 'sp-inactive'; ?>">
              <i class="fa-solid fa-circle" style="font-size:6px"></i>
              <?php echo $invoice->status; ?>
            </span>
            <span style="color:rgba(255,255,255,.4)">·</span>
            <span>Created: <?php echo date('d M Y', strtotime($invoice->invoice_date)); ?></span>
            <span style="color:rgba(255,255,255,.4)">·</span>
            <span>By <?php echo $invoice->creator_name; ?></span>
          </div>
        </div>
        <div class="hero-actions">
          <?php if($invoice->status == 'DRAFT'): ?>
            <button class="btn btn-primary" onclick="location.href='<?php echo site_url('Sales/edit/'.$invoice->id); ?>'"><i class="fa-solid fa-pen"></i> Edit Draft</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="hero-stats">
      <div class="hs-item">
        <div class="hs-label">Grand Total</div>
        <div class="hs-value">Rs. <?php echo number_format($invoice->grand_total, 2); ?></div>
        <div class="hs-sub"><?php echo $invoice->total_items; ?> Total Items</div>
      </div>
      <div class="hs-item">
        <div class="hs-label">Total Paid</div>
        <div class="hs-value green">Rs. <?php echo number_format($invoice->paid_amount, 2); ?></div>
        <div class="hs-sub"><?php echo $invoice->payment_status; ?></div>
      </div>
      <div class="hs-item">
        <div class="hs-label">Balance Due</div>
        <div class="hs-value <?php echo $invoice->balance_amount > 0 ? 'amber' : 'green'; ?>">
          Rs. <?php echo number_format($invoice->balance_amount, 2); ?>
        </div>
        <div class="hs-sub">Due: <?php echo date('d M Y', strtotime($invoice->due_date)); ?></div>
      </div>
      <div class="hs-item">
        <div class="hs-label">Warehouse</div>
        <div class="hs-value" style="font-size:14px;"><?php echo $invoice->warehouse_id; ?></div>
        <div class="hs-sub">Stock Location</div>
      </div>
    </div>
  </div>

  <div class="body-grid">

    <div>
      <div class="card">
        <div class="card-head">
          <div class="sec-icon"><i class="fa-solid fa-user-tag"></i></div>
          <h6>Customer Information</h6>
        </div>
        <div class="card-body">
          <div class="detail-row">
            <span class="dr-label">Customer Name</span>
            <span class="dr-value"><strong><?php echo $invoice->cus_name; ?></strong></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Company</span>
            <span class="dr-value"><?php echo $invoice->company_name ?: 'N/A'; ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Phone</span>
            <span class="dr-value mono"><?php echo $invoice->cus_phone; ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Billing Address</span>
            <span class="dr-value" style="text-align:right; font-size:12px;"><?php echo nl2br($invoice->cus_address); ?></span>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-head">
          <div class="sec-icon"><i class="fa-solid fa-circle-info"></i></div>
          <h6>Invoice Remarks</h6>
        </div>
        <div class="card-body">
            <p style="font-size:13px; color:var(--text-mid); line-height:1.5;">
                <?php echo $invoice->remarks ?: 'No additional remarks.'; ?>
            </p>
        </div>
      </div>
    </div>

    <div>
      <div class="card" style="overflow:visible;">
        <div class="card-body" style="padding-bottom:0;">
          <div class="tabs">
            <div class="tab active" onclick="switchTab('items',this)">
              <i class="fa-solid fa-boxes-stacked"></i>Product Items
              <span class="tab-cnt"><?php echo count($items); ?></span>
            </div>
            <div class="tab" onclick="switchTab('payments',this)">
              <i class="fa-solid fa-receipt"></i>Payment History
              <span class="tab-cnt"><?php echo count($payments); ?></span>
            </div>
          </div>

          <div class="tab-pane active" id="tab-items">
            <div class="tbl-wrap">
              <table class="tbl">
                <thead>
                  <tr>
                    <th>Product Description</th>
                    <th class="r">Qty</th>
                    <th class="r">Unit Price</th>
                    <th class="r">Discount</th>
                    <th class="r">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($items as $row): ?>
                  <tr>
                    <td>
                        <span style="font-weight:700; color:var(--text-dark);"><?php echo $row->product_name; ?></span><br>
                        <small class="text-muted"><?php echo $row->unit; ?></small>
                    </td>
                    <td class="r mono"><?php echo number_format($row->qty, 2); ?></td>
                    <td class="r mono">Rs. <?php echo number_format($row->unit_price, 2); ?></td>
                    <td class="r mono text-danger">-<?php echo number_format($row->discount_value, 2); ?> .Rs</td>
                    <td class="r mono fw-700">Rs. <?php echo number_format($row->line_total, 2); ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="r fw-700">Subtotal</td>
                        <td class="r mono fw-700">Rs. <?php echo number_format($invoice->subtotal, 2); ?></td>
                    </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <div class="tab-pane" id="tab-payments">
            <div class="tbl-wrap">
              <table class="tbl">
                <thead>
                  <tr>
                    <th>Payment Date</th>
                    <th>Method</th>
                    <th>Reference</th>
                    <th class="r">Amount Paid</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(empty($payments)): ?>
                    <tr class="empty-rows"><td colspan="4">No payments recorded for this invoice.</td></tr>
                  <?php else: foreach($payments as $p): ?>
                  <tr>
                    <td class="mono"><?php echo date('d M Y H:i', strtotime($p->payment_date)); ?></td>
                    <td><span class="status-pill sp-active"><?php echo $p->payment_method; ?></span></td>
                    <td><?php echo $p->reference_no ?: '—'; ?></td>
                    <td class="r mono green fw-700">Rs. <?php echo number_format($p->amount, 2); ?></td>
                  </tr>
                  <?php endforeach; endif; ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</main>

<script>
function switchTab(id, el) {
    $('.tab').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(el).addClass('active');
    $('#tab-' + id).addClass('active');
}
</script>