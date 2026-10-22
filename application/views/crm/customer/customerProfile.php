<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Profile — <?php echo htmlspecialchars($customer->cus_name ?? 'Rixzo ERP'); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sb-logo"><div class="logo-m">E</div><div class="logo-t">Rixzo <span>ERP</span></div></div>
  <div class="sb-nav">
    <div class="sb-cat">Main</div>
    <a class="sb-link" href="<?php echo site_url('Dashboard'); ?>"><i class="fa-solid fa-gauge-high"></i>Dashboard</a>
    <div class="sb-cat">Sales</div>
    <a class="sb-link" href="<?php echo site_url('Sales/invoice'); ?>"><i class="fa-solid fa-file-invoice-dollar"></i>Sales Invoice</a>
    <a class="sb-link" href="<?php echo site_url('Sales/invoice_list'); ?>"><i class="fa-solid fa-list-check"></i>Invoice List</a>
    <a class="sb-link active" href="<?php echo site_url('Customer'); ?>"><i class="fa-solid fa-users"></i>Customers</a>
    <div class="sb-cat">Inventory</div>
    <a class="sb-link" href="<?php echo site_url('Stock'); ?>"><i class="fa-solid fa-boxes-stacked"></i>Stock</a>
    <div class="sb-cat">Finance</div>
    <a class="sb-link" href="<?php echo site_url('Finance/cheque_book'); ?>"><i class="fa-solid fa-book"></i>Cheque Book</a>
    <a class="sb-link" href="<?php echo site_url('Reports'); ?>"><i class="fa-solid fa-chart-bar"></i>Reports</a>
  </div>
</aside>

<!-- HEADER -->
<header class="header">
  <div class="bc"><a href="<?php echo site_url('Customer'); ?>">Customers</a><span class="sep">›</span><span class="cur"><?php echo htmlspecialchars($customer->cus_name); ?></span></div>
  <div class="hdr-r">
    <div class="hbtn"><i class="fa-solid fa-magnifying-glass"></i></div>
    <div class="hbtn"><i class="fa-solid fa-bell"></i><span class="dot"></span></div>
    <div class="upill"><div class="uav">AD</div><span class="unm">Admin</span></div>
  </div>
</header>

<!-- MAIN -->
<main class="main">

  <!-- HERO -->
  <div class="hero">
    <div class="hero-top">
      <div class="hero-inner">
        <div class="cust-av">
          <?php 
            $name_parts = explode(' ', trim($customer->cus_name));
            $initials = '';
            foreach($name_parts as $part) {
                if(!empty($part)) $initials .= strtoupper(substr($part, 0, 1));
            }
            echo substr($initials, 0, 2);
          ?>
        </div>
        <div class="hero-name-block">
          <div class="hero-name"><?php echo htmlspecialchars($customer->cus_name); ?></div>
          <div class="hero-type">
            <span class="status-pill <?php echo $customer->cus_status == 'active' ? 'sp-active' : ($customer->cus_status == 'inactive' ? 'sp-inactive' : 'sp-blocked'); ?>">
              <i class="fa-solid fa-circle" style="font-size:6px"></i>
              <?php echo ucfirst($customer->cus_status); ?>
            </span>
            <span style="color:rgba(255,255,255,.4)">·</span>
            <span><?php echo htmlspecialchars($customer->company_name ?: 'Individual Customer'); ?></span>
            <span style="color:rgba(255,255,255,.4)">·</span>
            <span>Customer since <?php echo date('M Y', strtotime($customer->reg_date)); ?></span>
          </div>
        </div>
         
      </div>
    </div>
    <div class="hero-stats">
      <div class="hs-item">
        <div class="hs-label">Total Sales</div>
        <div class="hs-value" id="totalSales">0</div>
        <div class="hs-sub" id="totalInvoices">0 invoices</div>
      </div>
      <div class="hs-item">
        <div class="hs-label">Outstanding</div>
        <div class="hs-value amber" id="outstandingAmount">0</div>
        <div class="hs-sub" id="unpaidCount">0 unpaid invoices</div>
      </div>
      <div class="hs-item">
        <div class="hs-label">Credit Used</div>
        <div class="hs-value red" id="creditUsed">
          <?php echo number_format($customer->current_credit_amt, 2); ?>
          <span style="font-size:12px;font-weight:500;color:var(--text-muted)">/ <?php echo number_format($customer->max_credit_limit, 2); ?></span>
        </div>
        <div class="hs-sub" id="creditPercent"><?php echo $customer->max_credit_limit > 0 ? number_format(($customer->current_credit_amt / $customer->max_credit_limit) * 100, 1) : 0; ?>% of limit</div>
      </div>
      <div class="hs-item">
        <div class="hs-label">Last Activity</div>
        <div class="hs-value" style="font-size:14px;" id="lastActivity"><?php echo date('M d, Y', strtotime($customer->reg_date)); ?></div>
        <div class="hs-sub" id="lastInvoiceRef">Customer since registration</div>
      </div>
    </div>
  </div>

  <!-- BODY GRID -->
  <div class="body-grid">

    <!-- LEFT: General Details -->
    <div>
      <div class="card">
        <div class="card-head">
          <div class="sec-icon"><i class="fa-solid fa-address-card"></i></div>
          <h6>General Details</h6>
        </div>
        <div class="card-body">
          <div class="detail-row">
            <span class="dr-label">Company</span>
            <span class="dr-value"><?php echo htmlspecialchars($customer->company_name ?: 'N/A'); ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Contact Person</span>
            <span class="dr-value"><?php echo htmlspecialchars($customer->cus_name); ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Phone</span>
            <span class="dr-value mono"><a href="tel:<?php echo $customer->cus_phone; ?>"><?php echo $customer->cus_phone; ?></a></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Phone 2</span>
            <span class="dr-value mono"><a href="tel:<?php echo $customer->cus_phone_2; ?>"><?php echo $customer->cus_phone_2 ?: 'N/A'; ?></a></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Email</span>
            <span class="dr-value" style="font-size:12px;"><a href="mailto:<?php echo $customer->cus_email; ?>"><?php echo $customer->cus_email ?: 'N/A'; ?></a></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Address</span>
            <span class="dr-value" style="text-align:right;font-size:12px;"><?php echo nl2br(htmlspecialchars($customer->cus_address ?: 'N/A')); ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Customer Type</span>
            <span class="dr-value"><?php echo htmlspecialchars($customer->company_name ? 'Business' : 'Individual'); ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Registration Date</span>
            <span class="dr-value mono"><?php echo date('d M Y', strtotime($customer->reg_date)); ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Credit Enabled</span>
            <span class="dr-value">
              <?php if($customer->is_credit == 1): ?>
                <span class="status-pill sp-active">Yes</span>
              <?php else: ?>
                <span class="status-pill sp-inactive">No</span>
              <?php endif; ?>
            </span>
          </div>
        </div>
      </div>

      <?php if($customer->is_credit == 1): ?>
      <div class="card">
        <div class="card-head">
          <div class="sec-icon" style="background:var(--danger-light);color:var(--danger);"><i class="fa-solid fa-hand-holding-dollar"></i></div>
          <h6>Credit Account</h6>
        </div>
        <div class="card-body">
          <div class="detail-row">
            <span class="dr-label">Status</span>
            <span class="dr-value"><span class="status-pill sp-active">Enabled</span></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Credit Limit</span>
            <span class="dr-value mono">Rs. <?php echo number_format($customer->max_credit_limit, 2); ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Used</span>
            <span class="dr-value mono text-danger">Rs. <?php echo number_format($customer->current_credit_amt, 2); ?></span>
          </div>
          <div class="detail-row">
            <span class="dr-label">Available</span>
            <span class="dr-value mono text-success">Rs. <?php echo number_format($customer->max_credit_limit - $customer->current_credit_amt, 2); ?></span>
          </div>
          <div class="detail-row" style="border-bottom:none;padding-bottom:0;">
            <span class="dr-label">Utilisation</span>
            <span class="dr-value mono" style="color:var(--warning);">
              <?php 
                $utilization = $customer->max_credit_limit > 0 ? ($customer->current_credit_amt / $customer->max_credit_limit) * 100 : 0;
                echo number_format($utilization, 1);
              ?>%
            </span>
          </div>
          <div class="credit-bar-wrap" style="margin-top:8px;">
            <?php 
              $utilization = $customer->max_credit_limit > 0 ? ($customer->current_credit_amt / $customer->max_credit_limit) * 100 : 0;
              $bar_class = $utilization > 70 ? 'cb-red' : ($utilization > 40 ? 'cb-amber' : 'cb-green');
            ?>
            <div class="credit-bar-fill <?php echo $bar_class; ?>" style="width:<?php echo min($utilization, 100); ?>%"></div>
          </div>
          <div style="display:flex;justify-content:space-between;margin-top:4px;">
            <span class="fs-11 text-muted">Rs. 0</span>
            <span class="fs-11 text-muted">Rs. <?php echo number_format($customer->max_credit_limit, 2); ?></span>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <!-- RIGHT: Tabs -->
    <div>
      <div class="card" style="overflow:visible;">
        <div class="card-body" style="padding-bottom:0;">
          <div class="tabs">
            <div class="tab active" onclick="switchTab('invoices',this)">
              <i class="fa-solid fa-file-invoice"></i>Invoices
              <span class="tab-cnt" id="invoiceCount">0</span>
            </div>
            <div class="tab" onclick="switchTab('payments',this)">
              <i class="fa-solid fa-money-bill-wave"></i>Payments
              <span class="tab-cnt" id="paymentCount">0</span>
            </div>
          </div>

          <!-- INVOICES TAB -->
          <div class="tab-pane active" id="tab-invoices">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;flex-wrap:wrap;">
              <select id="inv-filter" onchange="renderInvoices()" style="padding:6px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;font-weight:600;color:var(--text-mid);outline:none;background:#fff;cursor:pointer;">
                <option value="all">All Statuses</option>
                <option value="PAID">Paid</option>
                <option value="PARTIAL">Partial</option>
                <option value="PENDING">Pending</option>
                <option value="OVERDUE">Overdue</option>
                <option value="DRAFT">Draft</option>
              </select>
              <span id="inv-count" style="font-size:12px;color:var(--text-muted);font-weight:600;"></span>
              <div style="margin-left:auto;display:flex;gap:6px;">
                <button class="btn btn-outline btn-sm" onclick="exportInvoices()"><i class="fa-solid fa-download"></i>Export</button>
              </div>
            </div>
            <div class="tbl-wrap">
              <table class="tbl">
                <thead>
                  <tr>
                    <th>Invoice #</th>
                    <th>Date</th>
                    <th>Due Date</th>
                    <th class="r">Amount</th>
                    <th class="r">Paid</th>
                    <th class="r">Balance</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="inv-tbody">
                  <tr class="empty-rows"><td colspan="7"><i class="fa-solid fa-spinner fa-pulse"></i>Loading invoices...</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- PAYMENTS TAB -->
          <div class="tab-pane" id="tab-payments">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;flex-wrap:wrap;">
              <select id="pay-filter" onchange="renderPayments()" style="padding:6px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;font-weight:600;color:var(--text-mid);outline:none;background:#fff;cursor:pointer;">
                <option value="all">All Methods</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cheque">Cheque</option>
                <option value="Credit">Credit</option>
              </select>
              <span id="pay-count" style="font-size:12px;color:var(--text-muted);font-weight:600;"></span>
              <div style="margin-left:auto;display:flex;gap:6px;">
                <button class="btn btn-outline btn-sm" onclick="exportPayments()"><i class="fa-solid fa-download"></i>Export</button>
              </div>
            </div>
            <div class="tbl-wrap">
              <table class="tbl">
                <thead>
                  <tr>
                    <th>Receipt #</th>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Method</th>
                    <th class="r">Amount</th>
                    <th>Note</th>
                  </tr>
                </thead>
                <tbody id="pay-tbody">
                  <tr class="empty-rows"><td colspan="6"><i class="fa-solid fa-spinner fa-pulse"></i>Loading payments...</td></tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</main>

<div id="toast-c"></div>

<script>
// Pass PHP data to JavaScript (like Supplier module)
const customerId = <?= $customer->cus_id ?>;
const invoicesData = <?= json_encode($invoices) ?>;
const paymentsData = <?= json_encode($payments) ?>;
const statsData = <?= json_encode($stats) ?>;

function fmt(n) { 
    return Number(n).toLocaleString('en-LK', {minimumFractionDigits: 2, maximumFractionDigits: 2}); 
}

function toast(msg, type) {
    var map = {s: ['t-s', 'fa-check-circle'], i: ['t-i', 'fa-circle-info'], e: ['t-i', 'fa-circle-exclamation']};
    var p = map[type] || map.i;
    var $t = $('<div class="t-item ' + p[0] + '"><i class="fa-solid ' + p[1] + '"></i>' + msg + '</div>');
    $('#toast-c').append($t);
    setTimeout(function() {
        $t.css({opacity: 0, transform: 'translateX(16px)', transition: 'all .3s'});
        setTimeout(function() { $t.remove(); }, 300);
    }, 2600);
}

// Status badge mapping
const INV_STATUS_MAP = {
    'paid': ['ib-paid', 'fa-check-circle', 'Paid'],
    'partial': ['ib-partial', 'fa-adjust', 'Partial'],
    'unpaid': ['ib-pending', 'fa-clock', 'Unpaid'],
    'overdue': ['ib-overdue', 'fa-exclamation-circle', 'Overdue'],
    'draft': ['ib-draft', 'fa-pen', 'Draft']
};

const PAY_METHOD_MAP = {
    'Cash': 'pb-cash',
    'Card': 'pb-card',
    'Bank': 'pb-bank',
    'Cheque': 'pb-cheque',
    'Credit': 'pb-credit'
};

function renderInvoices() {
    let filter = $('#inv-filter').val();
    let filtered = filter === 'all' ? invoicesData : invoicesData.filter(inv => inv.status === filter);
    
    $('#inv-count').text(filtered.length + ' record' + (filtered.length !== 1 ? 's' : ''));
    
    if (!filtered.length) {
        $('#inv-tbody').html('<tr class="empty-rows"><td colspan="7"><i class="fa-solid fa-file-invoice"></i>No invoices found</td></tr>');
        return;
    }
    
    let html = filtered.map(function(inv) {
        let s = INV_STATUS_MAP[inv.status] || INV_STATUS_MAP['unpaid'];
        let balance = inv.balance_amount || 0;
        let balHtml = balance > 0
            ? '<span class="mono" style="color:var(--danger);font-weight:700;">Rs. ' + fmt(balance) + '</span>'
            : '<span class="mono" style="color:var(--success);">—</span>';
        
        return '<tr>' +
            '<td><a href="#" class="view-invoice" data-id="' + inv.id + '" style="color:var(--primary);font-weight:700;text-decoration:none;font-family:\'JetBrains Mono\',monospace;font-size:12px;">' + inv.invoice_no + '</a></td>' +
            '<td style="color:var(--text-mid);font-size:12px;">' + inv.invoice_date + '</td>' +
            '<td style="color:var(--text-mid);font-size:12px;">' + (inv.due_date || '-') + '</td>' +
            '<td class="r mono fw-700">Rs. ' + fmt(inv.grand_total) + '</td>' +
            '<td class="r mono" style="color:var(--success)">Rs. ' + fmt(inv.paid_amount) + '</td>' +
            '<td class="r">' + balHtml + '</td>' +
            '<td><span class="inv-badge ' + s[0] + '"><i class="fa-solid ' + s[1] + '" style="font-size:9px;"></i>' + s[2] + '</span></td>' +
        '</tr>';
    }).join('');
    
    $('#inv-tbody').html(html);
}

function renderPayments() {
    if (!paymentsData.length) {
        $('#pay-tbody').html('<tr class="empty-rows"><td colspan="6"><i class="fa-solid fa-money-bill-wave"></i>No payments found</td></tr>');
        return;
    }
    
    let icons = {'Cash':'fa-money-bill-wave','Card':'fa-credit-card','Bank':'fa-university','Cheque':'fa-money-check-dollar','Credit':'fa-hand-holding-dollar'};
    
    let html = paymentsData.map(function(pay) {
        let cls = PAY_METHOD_MAP[pay.method] || 'pb-cash';
        return '<tr>' +
            '<td><span class="mono" style="font-size:12px;font-weight:600;color:var(--text-mid);">' + pay.receipt_no + '</span></td>' +
            '<td style="color:var(--text-mid);font-size:12px;">' + pay.date + '</td>' +
            '<td><a href="#" style="color:var(--primary);font-weight:700;text-decoration:none;font-size:12px;">' + pay.invoice_no + '</a></td>' +
            '<td><span class="pay-badge ' + cls + '"><i class="fa-solid ' + (icons[pay.method] || 'fa-money-bill-wave') + '" style="font-size:10px;"></i>' + pay.method + '</span></td>' +
            '<td class="r mono fw-700" style="color:var(--success)">Rs. ' + fmt(pay.amount) + '</td>' +
            '<td style="font-size:12px;color:var(--text-muted);">' + (pay.note || '—') + '</td>' +
        '</tr>';
    }).join('');
    
    $('#pay-tbody').html(html);
}

function updateStats() {
    if (statsData) {
        $('#totalSales').text(fmt(statsData.total_sales || 0));
        $('#totalInvoices').text((statsData.total_invoices || 0) + ' invoice' + (statsData.total_invoices !== 1 ? 's' : ''));
        $('#outstandingAmount').text(fmt(statsData.total_outstanding || 0));
        $('#unpaidCount').text((statsData.outstanding_count || 0) + ' unpaid invoice' + (statsData.outstanding_count !== 1 ? 's' : ''));
        $('#invoiceCount').text(statsData.total_invoices || 0);
        $('#paymentCount').text(paymentsData.length);
    }
}

function filterInvoices() {
    renderInvoices();
}

function switchTab(id, el) {
    $('.tab').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(el).addClass('active');
    $('#tab-' + id).addClass('active');
}

function editCustomer(id) {
    window.location.href = '<?= site_url("Customer") ?>?edit=' + id;
}

function createNewInvoice(id) {
    window.location.href = '<?= site_url("Sales/invoice?customer_id="); ?>' + id;
}

$(function() { 
    renderInvoices(); 
    renderPayments();
    updateStats();
});
</script>
</body>
</html>