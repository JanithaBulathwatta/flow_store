<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Day End — Rixzo ERP</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
:root{
  --primary:#3d52a0;--primary-d:#2d3d80;--primary-light:#eef1fb;--primary-mid:#c5cff7;
  --success:#10b981;--success-light:#d1fae5;--success-d:#059669;
  --danger:#ef4444;--danger-light:#fee2e2;
  --warning:#f59e0b;--warning-light:#fef3c7;
  --info:#0ea5e9;--info-light:#e0f2fe;
  --purple:#8b5cf6;--purple-light:#ede9fe;
  --orange:#f97316;--orange-light:#ffedd5;
  --teal:#14b8a6;--teal-light:#ccfbf1;
  --sidebar-bg:#1a1f36;--sidebar-text:#a8b4d8;
  --page-bg:#f0f2f9;--card-border:#e4e9f4;
  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
  --input-border:#d1d9e6;
  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.10);
  --r-sm:8px;--r-md:12px;--r-lg:16px;
  --sidebar-w:240px;--header-h:60px;--tr:.2s cubic-bezier(.4,0,.2,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;}
::-webkit-scrollbar{width:5px;}::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

/* SIDEBAR */
.sidebar{position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-w);background:var(--sidebar-bg);z-index:100;display:flex;flex-direction:column;}
.sb-logo{height:var(--header-h);display:flex;align-items:center;padding:0 18px;border-bottom:1px solid rgba(255,255,255,.06);}
.logo-m{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;font-size:15px;color:#fff;font-weight:800;}
.logo-t{margin-left:10px;color:#fff;font-weight:700;font-size:15px;}.logo-t span{color:#7b8dd1;}
.sb-nav{flex:1;overflow-y:auto;padding:10px 0;}
.sb-cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(168,180,216,.4);padding:14px 18px 5px;}
.sb-link{display:flex;align-items:center;gap:10px;padding:9px 18px;color:var(--sidebar-text);text-decoration:none;font-size:13px;font-weight:500;cursor:pointer;transition:all var(--tr);}
.sb-link i{font-size:15px;width:18px;text-align:center;}
.sb-link:hover{background:rgba(255,255,255,.05);color:#fff;}
.sb-link.active{background:rgba(61,82,160,.28);color:#fff;border-right:3px solid #7b8dd1;}

/* HEADER */
.header{position:fixed;top:0;left:var(--sidebar-w);right:0;height:var(--header-h);background:#fff;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;padding:0 22px;z-index:90;box-shadow:var(--sh-sm);}
.bc{display:flex;align-items:center;gap:5px;font-size:13px;color:var(--text-muted);}
.bc a{color:var(--primary);text-decoration:none;font-weight:500;}
.bc .sep{color:#ccc;}.bc .cur{font-weight:600;color:var(--text-dark);}
.hdr-r{display:flex;align-items:center;gap:10px;}
.hbtn{width:34px;height:34px;border-radius:var(--r-sm);border:1px solid var(--card-border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-muted);transition:all var(--tr);}
.hbtn:hover{border-color:var(--primary);color:var(--primary);}
.upill{display:flex;align-items:center;gap:8px;background:var(--primary-light);border-radius:20px;padding:4px 12px 4px 4px;cursor:pointer;}
.uav{width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;}
.unm{font-size:12px;font-weight:600;color:var(--primary);}

/* MAIN */
.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:20px 24px;}

/* BUTTONS */
.btn{padding:9px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;gap:7px;}
.btn-primary{background:var(--primary);color:#fff;}
.btn-primary:hover{background:var(--primary-d);transform:translateY(-1px);}
.btn-success{background:var(--success);color:#fff;}
.btn-success:hover{background:var(--success-d);transform:translateY(-1px);}
.btn-danger{background:var(--danger);color:#fff;}
.btn-outline{background:#fff;color:var(--text-mid);border:1.5px solid var(--card-border);}
.btn-outline:hover{border-color:var(--primary);color:var(--primary);}
.btn-warn-o{background:#fff;color:#92400e;border:1.5px solid #fde68a;}
.btn-warn-o:hover{background:var(--warning);color:#fff;}
.btn-sm{padding:7px 13px;font-size:12px;}
.btn:disabled{opacity:.35;cursor:not-allowed;transform:none!important;}

/* FORM */
.fc{padding:8px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;background:#fff;transition:border-color var(--tr);}
.fc:focus{border-color:var(--primary);}

/* TOP CONTEXT ROW */
.ctx-row{display:flex;align-items:center;gap:10px;margin-bottom:18px;flex-wrap:wrap;}
.ctx-row h1{font-size:18px;font-weight:800;letter-spacing:-.3px;margin-right:4px;}

/* OPEN/CLOSED BANNER */
.period-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:800;}
.pc-open{background:var(--success-light);color:#065f46;border:1px solid #6ee7b7;}
.pc-closed{background:var(--danger-light);color:#991b1b;border:1px solid #fca5a5;}

/* CLOSED NOTICE */
.closed-notice{background:var(--danger-light);border:1.5px solid #fca5a5;border-radius:var(--r-md);padding:12px 16px;margin-bottom:18px;display:flex;align-items:center;gap:12px;}
.closed-notice-text{flex:1;font-size:13px;color:#991b1b;font-weight:600;}

/* BODY GRID  */
.page-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:14px;}
.page-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;}

/* SUMMARY CARD — the main building block */
.sum-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;}
.sum-card-head{padding:11px 14px;display:flex;align-items:center;gap:8px;border-bottom:1px solid var(--card-border);}
.sum-card-head h6{font-size:12px;font-weight:800;color:var(--text-dark);margin:0;flex:1;text-transform:uppercase;letter-spacing:.4px;}
.sc-icon{width:24px;height:24px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0;}
.sum-card-body{padding:12px 14px;}

/* LINE ITEM — the core unit inside a summary card */
.li-row{display:flex;align-items:center;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f0f2f8;gap:10px;}
.li-row:last-child{border-bottom:none;}
.li-row.total-li{border-top:2px solid var(--card-border);margin-top:2px;padding-top:9px;border-bottom:none;}
.li-label{font-size:12px;font-weight:500;color:var(--text-mid);display:flex;align-items:center;gap:6px;flex:1;}
.li-label .badge{font-size:10px;font-weight:700;padding:1px 6px;border-radius:20px;font-family:'JetBrains Mono',monospace;white-space:nowrap;}
.li-vals{display:flex;align-items:center;gap:12px;flex-shrink:0;}
.li-count{font-size:11px;font-weight:700;color:var(--text-muted);font-family:'JetBrains Mono',monospace;min-width:28px;text-align:right;}
.li-amount{font-size:13px;font-weight:700;font-family:'JetBrains Mono',monospace;color:var(--text-dark);min-width:90px;text-align:right;}
.li-amount.green{color:var(--success);}
.li-amount.red{color:var(--danger);}
.li-amount.muted{color:var(--text-muted);font-weight:500;}
.li-amount.big{font-size:15px;color:var(--primary);font-weight:800;}
.total-li .li-label{font-weight:800;color:var(--text-dark);}

/* ACCOUNT ROW */
.acc-row{display:grid;grid-template-columns:1fr auto auto auto;gap:10px;align-items:center;padding:8px 0;border-bottom:1px solid #f0f2f8;}
.acc-row:last-child{border-bottom:none;}
.acc-name{font-size:12px;font-weight:700;color:var(--text-dark);display:flex;align-items:center;gap:6px;}
.acc-type-lbl{font-size:10px;color:var(--text-muted);font-weight:600;}
.acc-fig{font-size:12px;font-family:'JetBrains Mono',monospace;font-weight:600;text-align:right;white-space:nowrap;}
.acc-fig.dim{color:var(--text-muted);}
.acc-actual-input{width:88px;padding:5px 7px;border:1.5px solid var(--input-border);border-radius:6px;font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:700;text-align:right;outline:none;background:#fff;transition:border-color var(--tr);}
.acc-actual-input:focus{border-color:var(--primary);}
.acc-actual-input.ok{border-color:var(--success);}
.acc-actual-input.warn{border-color:var(--warning);}
.acc-var{font-size:11px;font-weight:800;font-family:'JetBrains Mono',monospace;text-align:right;min-width:44px;}

/* CLOSE CARD */
.close-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;}
.close-card-head{background:linear-gradient(110deg,#1a1f36,#2d3d80);padding:16px 20px;display:flex;align-items:center;gap:12px;}
.close-card-head h5{font-size:14px;font-weight:800;color:#fff;margin:0;flex:1;}
.close-card-body{padding:16px 20px;}

/* CHECK ROW */
.check-row{display:flex;align-items:center;gap:9px;padding:7px 0;border-bottom:1px solid #f0f2f8;font-size:13px;font-weight:600;}
.check-row:last-child{border-bottom:none;}
.check-row.ok{color:var(--success);}
.check-row.warn{color:var(--warning);}
.check-row.fail{color:var(--danger);}
.check-row i{font-size:15px;width:18px;text-align:center;}

/* BOTTOM BAR */
.bottom-bar{background:linear-gradient(110deg,#1a1f36,#2d3d80);border-radius:var(--r-lg);padding:20px 24px;display:flex;align-items:center;gap:0;margin-bottom:32px;}
.bb-totals{display:flex;gap:0;flex:1;}
.bb-tot-item{padding:0 28px;border-right:1px solid rgba(255,255,255,.12);}
.bb-tot-item:first-child{padding-left:0;}
.bb-tot-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:rgba(255,255,255,.5);margin-bottom:4px;}
.bb-tot-val{font-size:18px;font-weight:800;font-family:'JetBrains Mono',monospace;color:#fff;}
.bb-tot-sub{font-size:11px;color:rgba(255,255,255,.45);margin-top:2px;}
.bb-action{margin-left:auto;padding-left:28px;display:flex;align-items:center;gap:10px;flex-shrink:0;}

/* STATUS MESSAGES */
.status-msgs{margin-bottom:16px;display:flex;flex-direction:column;gap:8px;}
.smsg{display:flex;align-items:flex-start;gap:10px;padding:11px 14px;border-radius:var(--r-sm);border:1.5px solid;font-size:13px;font-weight:600;}
.smsg-closed{background:var(--danger-light);border-color:#fca5a5;color:#991b1b;}
.smsg-warn{background:var(--warning-light);border-color:#fde68a;color:#92400e;}
.smsg-ok{background:var(--success-light);border-color:#6ee7b7;color:#065f46;}
.smsg i{font-size:15px;flex-shrink:0;margin-top:1px;}
.smsg-text{flex:1;}
.smsg-text strong{font-weight:800;}

/* CLOSE BUTTON STATES */
.btn-end{padding:12px 24px;font-size:14px;font-weight:800;border-radius:var(--r-md);font-family:inherit;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;gap:8px;}
.btn-end-ok{background:var(--success);color:#fff;box-shadow:0 4px 14px rgba(16,185,129,.3);}
.btn-end-ok:hover{background:var(--success-d);transform:translateY(-1px);}
.btn-end-blocked{background:rgba(255,255,255,.1);color:rgba(255,255,255,.4);cursor:not-allowed;border:1px solid rgba(255,255,255,.15);}
.btn-end-closed{background:rgba(245,158,11,.15);color:#fbbf24;border:1px solid rgba(245,158,11,.3);cursor:pointer;}
.btn-end-closed:hover{background:rgba(245,158,11,.25);}

/* DIVIDER */
.divider{height:1px;background:var(--card-border);margin:12px 0;}

/* NEG STOCK ALERT */
.neg-alert{background:var(--danger-light);border:1.5px solid #fca5a5;border-radius:var(--r-sm);padding:9px 12px;font-size:12px;color:#991b1b;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:10px;}

/* RECONCILIATION BOX — compact inside close card */
.recon-box{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.12);border-radius:var(--r-sm);padding:12px;margin-bottom:14px;}
.rb-row{display:flex;justify-content:space-between;align-items:center;padding:4px 0;font-size:12px;}
.rb-lbl{color:rgba(255,255,255,.75);font-weight:600;}
.rb-lbl.indent{padding-left:12px;color:rgba(255,255,255,.55);font-size:11px;}
.rb-val{font-family:'JetBrains Mono',monospace;font-weight:700;color:#fff;}
.rb-val.neg{color:#fca5a5;}
.rb-sep{height:1px;background:rgba(255,255,255,.15);margin:6px 0;}
.rb-total .rb-lbl{color:#fff;font-weight:800;}
.rb-total .rb-val{font-size:15px;}
.recon-result{display:flex;align-items:center;justify-content:space-between;padding:9px 12px;border-radius:6px;margin-bottom:14px;}
.rr-ok{background:rgba(16,185,129,.2);border:1px solid rgba(16,185,129,.3);}
.rr-fail{background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.3);}
.rr-lbl{font-size:12px;font-weight:700;color:#fff;display:flex;align-items:center;gap:6px;}
.rr-diff{font-size:11px;font-family:'JetBrains Mono',monospace;font-weight:800;}
.rr-diff.ok{color:#6ee7b7;}.rr-diff.fail{color:#fca5a5;}

/* MODAL */
.modal-bg{position:fixed;inset:0;background:rgba(10,18,45,.55);z-index:500;display:none;align-items:center;justify-content:center;padding:20px;}
.modal-bg.show{display:flex;}
.modal-box{background:#fff;border-radius:var(--r-lg);width:100%;max-width:420px;box-shadow:0 8px 32px rgba(0,0,0,.2);animation:popIn .25s cubic-bezier(.34,1.56,.64,1);}
@keyframes popIn{from{opacity:0;transform:scale(.92)}to{opacity:1;transform:scale(1)}}
.mb-head{padding:16px 20px 0;display:flex;align-items:center;justify-content:space-between;}
.mb-head h4{font-size:14px;font-weight:800;}
.mb-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:16px;}
.mb-body{padding:14px 20px;}
.mb-foot{padding:11px 20px;border-top:1px solid var(--card-border);display:flex;justify-content:flex-end;gap:8px;}
.form-row{margin-bottom:11px;}
.form-lbl{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-mid);display:block;margin-bottom:4px;}
.form-lbl span{color:var(--danger);}

/* TOAST */
#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;display:flex;align-items:center;gap:7px;box-shadow:0 4px 16px rgba(0,0,0,.18);animation:tIn .25s ease;max-width:300px;}
@keyframes tIn{from{opacity:0;transform:translateX(16px)}to{opacity:1;transform:translateX(0)}}
.t-s{background:var(--success);color:#fff;}.t-e{background:var(--danger);color:#fff;}.t-i{background:var(--primary);color:#fff;}.t-w{background:var(--warning);color:#fff;}
</style>
</head>
<body>

 

<main class="main">

  <!-- Context Row -->
  <div class="ctx-row">
    <div>
      <h1><i class="fa-solid fa-moon" style="font-size:15px;margin-right:6px;color:var(--primary);"></i>Day End</h1>
      <div style="font-size:13px;color:var(--text-muted);margin-top:3px;" id="ctx-sub"></div>
    </div>
    <div id="period-chip" style="margin-left:8px;"></div>
    <button class="btn btn-outline btn-sm" onclick="load()" style="margin-left:8px;"><i class="fa-solid fa-rotate-right"></i>Refresh</button>
    <div style="margin-left:auto;" id="hdr-actions"></div>
  </div>

  <!-- Status / blocking messages -->
  <div id="status-msgs"></div>

  <!-- ═══ ROW 1: Stock · Income · Accounts ═══ -->
  <div class="page-grid">

    <!-- STOCK IMPACT -->
    <div class="sum-card">
      <div class="sum-card-head">
        <div class="sc-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-boxes-stacked"></i></div>
        <h6>Stock Impact</h6>
      </div>
      <div class="sum-card-body" id="stock-card"></div>
    </div>

    <!-- INCOME IMPACT -->
    <div class="sum-card">
      <div class="sum-card-head">
        <div class="sc-icon" style="background:var(--success-light);color:var(--success);"><i class="fa-solid fa-chart-line"></i></div>
        <h6>Income Impact</h6>
      </div>
      <div class="sum-card-body" id="income-card"></div>
    </div>

    <!-- ACCOUNT BALANCES -->
    <div class="sum-card">
      <div class="sum-card-head">
        <div class="sc-icon" style="background:#ccfbf1;color:#14b8a6;"><i class="fa-solid fa-wallet"></i></div>
        <h6>Account Balances</h6>
        <span style="font-size:10px;color:var(--text-muted);font-weight:600;">Enter actual ↓</span>
      </div>
      <div class="sum-card-body" id="acc-card"></div>
    </div>

  </div>

  <!-- ═══ ROW 2: Expenses · Pending Jobs ═══ -->
  <div class="page-grid">

    <!-- EXPENSES -->
    <div class="sum-card">
      <div class="sum-card-head">
        <div class="sc-icon" style="background:var(--orange-light);color:var(--orange);"><i class="fa-solid fa-receipt"></i></div>
        <h6>Expense Summary</h6>
      </div>
      <div class="sum-card-body" id="exp-card"></div>
    </div>

    <!-- PENDING JOBS -->
    <div class="sum-card">
      <div class="sum-card-head">
        <div class="sc-icon" style="background:var(--warning-light);color:var(--warning);"><i class="fa-solid fa-clock"></i></div>
        <h6>Pending / Unresolved</h6>
      </div>
      <div class="sum-card-body" id="pending-card"></div>
    </div>

    <!-- RECON SUMMARY -->
    <div class="sum-card">
      <div class="sum-card-head">
        <div class="sc-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-scale-balanced"></i></div>
        <h6>Reconciliation</h6>
      </div>
      <div class="sum-card-body" id="recon-card"></div>
    </div>

  </div>

  <!-- ═══ BOTTOM ROW: Totals + Day End Action ═══ -->
  <div id="bottom-bar"></div>

</main>

<!-- REOPEN MODAL -->
<div class="modal-bg" id="reopen-modal">
  <div class="modal-box">
    <div class="mb-head">
      <h4><i class="fa-solid fa-lock-open" style="color:var(--danger);margin-right:6px;"></i>Reopen Period</h4>
      <button class="mb-close" onclick="$('#reopen-modal').removeClass('show')"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="mb-body">
      <div style="background:var(--danger-light);border-radius:var(--r-sm);padding:9px 12px;font-size:12px;color:#991b1b;font-weight:600;margin-bottom:12px;">
        <i class="fa-solid fa-triangle-exclamation"></i> Reopening allows backdated transactions. Action is logged.
      </div>
      <div class="form-row">
        <label class="form-lbl">Reason <span>*</span></label>
        <textarea class="fc" id="reopen-reason" rows="2" placeholder="Why does this period need to be reopened?"></textarea>
      </div>
      <div class="form-row" style="margin-bottom:0;">
        <label class="form-lbl">Superadmin Password <span>*</span></label>
        <input type="password" class="fc" id="reopen-pass" placeholder="Confirm with password">
      </div>
    </div>
    <div class="mb-foot">
      <button class="btn btn-outline btn-sm" onclick="$('#reopen-modal').removeClass('show')">Cancel</button>
      <button class="btn btn-danger btn-sm" onclick="confirmReopen()"><i class="fa-solid fa-lock-open"></i>Reopen</button>
    </div>
  </div>
</div>

<div id="toast-c"></div>

<script>
/* ═══ SAMPLE DATA — replace with $.post('/day_end/summary', ...) ═══ */
var D = {
  status:    'open',
   
  closed_by: null,
  closed_at: null,
  
};

var realData = {
    totalSales: 0,
    totalExpenses: 0,
    totalAccountBalance: 0,
    pendingCount: 0
};

$(function(){ load(); });

function load() {
	var warehouse_id = $('#warehouse_selector').val() || 1;
    var currentDate = '<?php echo date("Y-m-d"); ?>';
    
	 D.date = currentDate;  
	 
    // Get top section data (warehouse name, blocks)
    $.ajax({
        url: '/DayEnd/get_top_section_data',
        type: 'POST',
        data: { warehouse_id: warehouse_id, date: currentDate },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                D.warehouse = response.warehouse_name;
                D.blocks = response.blocks;
                renderContext();
                renderStatusMsgs();
            }
        }
    });
	
	
    // Get real stock impact data
    $.ajax({
        url: '/DayEnd/get_stock_impact',
        type: 'POST',
        data: { warehouse_id: warehouse_id, date: currentDate },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                renderStockFromRealData(response.stock, response.total_value);
            } else {
                // Fallback to mock data if error
                renderStockWithMockData();
            }
        },
        error: function() {
            // Fallback to mock data
            renderStockWithMockData();
        }
    });
	
	$.ajax({
        url: '/DayEnd/get_income_impact',
        type: 'POST',
        data: { warehouse_id: warehouse_id, date: currentDate },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                renderIncomeFromRealData(response.income, response.total_income);
				realData.totalSales = response.income.gross_sales.value;   
                renderBottomBar();     
            } else {
                renderIncomeWithMockData();
            }
        },
        error: function() { renderIncomeWithMockData(); }
    });
	
	$.ajax({
    url: '/DayEnd/get_account_balances',
    type: 'POST',
    data: { warehouse_id: warehouse_id, date: currentDate },
    dataType: 'json',
    success: function(response) {
        if(response.success) {
            renderAccountsFromRealData(response.accounts, response.total_balance);
			realData.totalAccountBalance = response.total_balance;   
            renderBottomBar(); 
        } else {
            renderAccountsWithMockData();
        }
    },
    error: function() { renderAccountsWithMockData(); }
  });
  
  $.ajax({
    url: '/DayEnd/get_expense_summary',
    type: 'POST',
    data: { warehouse_id: warehouse_id, date: currentDate },
    dataType: 'json',
    success: function(response) {
        if(response.success) {
              
            renderExpensesFromRealData(response.expenses, response.total);
            realData.totalExpenses = response.total;   
            renderBottomBar();
        } else {
            renderExpensesWithMockData();
        }
    },
    error: function() { renderExpensesWithMockData(); }
});

// Get real pending items data
$.ajax({
    url: '/DayEnd/get_pending_items',
    type: 'POST',
    data: { warehouse_id: warehouse_id, date: currentDate },
    dataType: 'json',
    success: function(response) {
        if(response.success) {
            renderPendingFromRealData(response.pending);
			realData.pendingCount = response.total_count;   
            renderBottomBar();
        } else {
            renderPendingWithMockData();
        }
    },
    error: function() { renderPendingWithMockData(); }
});

// Get real reconciliation data
$.ajax({
    url: '/DayEnd/get_reconciliation',
    type: 'POST',
    data: { warehouse_id: warehouse_id, date: currentDate },
    dataType: 'json',
    success: function(response) {
        if(response.success) {
            renderReconFromRealData(response);
            window._reconOk = response.is_balanced;
        } else {
            renderReconWithMockData();
        }
    },
    error: function() { renderReconWithMockData(); }
});


    
    // Keep other render functions as is (using mock data for now)
    renderContext();
    renderStatusMsgs();
    renderBottomBar();
}



// New function to render stock with real data
function renderStockFromRealData(stockData, totalValue) {
    var stockArray = [
        stockData.grn,
        stockData.transfers_in,
        stockData.transfers_out,
        stockData.sales,
		stockData.issues, 
        stockData.adjustments
    ];
    
    var html = '';
    for(var i = 0; i < stockArray.length; i++) {
        var s = stockArray[i];
        var countDisplay = s.count > 0 ? '×' + s.count : '';
        var amountClass = s.value < 0 ? 'red' : (s.value > 0 ? 'green' : '');
        var displayValue = Math.abs(s.value);
        
        html += '<div class="li-row">';
        html += '<div class="li-label">';
        html += '<div style="width:7px;height:7px;border-radius:50%;background:' + s.color + ';flex-shrink:0;"></div>';
        html += s.label;
        html += '</div>';
        html += '<div class="li-vals">';
        html += '<span class="li-count">' + countDisplay + '</span>';
        html += '<span class="li-amount ' + amountClass + '">Rs. ' + fmt(displayValue) + '</span>';
        html += '</div>';
        html += '</div>';
    }
    
    // Add total row
    html += '<div class="li-row total-li">';
    html += '<div class="li-label">Net Stock Value In</div>';
    html += '<div class="li-vals"><span class="li-amount big">Rs. ' + fmt(totalValue) + '</span></div>';
    html += '</div>';
    
    $('#stock-card').html(html);
}

 


// NEW: Render income with real data
function renderIncomeFromRealData(incomeData, totalIncome) {
    var incomeArray = [
        incomeData.gross_sales,
        incomeData.returns,
        incomeData.discounts,
        incomeData.previous_due,
        incomeData.cash_collection,
        incomeData.credit_forward
    ];
    
    var html = '';
    for(var i = 0; i < incomeArray.length; i++) {
        var s = incomeArray[i];
        var countDisplay = s.count && s.count > 0 ? '×' + s.count : '';
        var amountClass = s.value < 0 ? 'red' : (s.value > 0 ? 'green' : '');
        var displayValue = Math.abs(s.value);
        
        html += '<div class="li-row">';
        html += '<div class="li-label">';
        html += '<div style="width:7px;height:7px;border-radius:50%;background:' + s.color + ';flex-shrink:0;"></div>';
        html += s.label;
        html += '</div>';
        html += '<div class="li-vals">';
        html += '<span class="li-count">' + countDisplay + '</span>';
        html += '<span class="li-amount ' + amountClass + '">Rs. ' + fmt(displayValue) + '</span>';
        html += '</div>';
        html += '</div>';
    }
    
    // Add total row
    html += '<div class="li-row total-li">';
    html += '<div class="li-label">Net Income Position</div>';
    html += '<div class="li-vals"><span class="li-amount big">Rs. ' + fmt(totalIncome) + '</span></div>';
    html += '</div>';
    
    $('#income-card').html(html);
}

// Render accounts with REAL data
function renderAccountsFromRealData(accountsData, totalBalance) {
    var html = '';
    for(var i = 0; i < accountsData.length; i++) {
        var acc = accountsData[i];
        var movement = acc.expected - acc.opening;
        var movementClass = movement > 0 ? 'var(--success)' : (movement < 0 ? 'var(--danger)' : 'var(--text-muted)');
        var movementSign = movement >= 0 ? '+' : '';
        
        html += '<div class="li-row">';
        html += '<div class="li-label">';
        html += '<i class="fa-solid ' + acc.icon + '" style="color:' + acc.color + ';font-size:12px;width:14px;text-align:center;flex-shrink:0;"></i>';
        html += '<div>';
        html += '<div style="font-size:12px;font-weight:700;color:var(--text-dark);">' + acc.name + '</div>';
        html += '<div style="font-size:10px;color:var(--text-muted);">Open: <span style="font-family:JetBrains Mono,monospace;">' + fmt(acc.opening) + '</span></div>';
        if(acc.cash_in > 0) {
            html += '<div style="font-size:9px;color:var(--success);">+ Collection: ' + fmt(acc.cash_in) + '</div>';
        }
        html += '</div>';
        html += '</div>';
        html += '<div class="li-vals"><div style="text-align:right;">';
        html += '<div class="li-amount">Rs. ' + fmt(acc.expected) + '</div>';
        html += '<div style="font-size:10px;font-weight:700;color:' + movementClass + ';margin-top:1px;">' + movementSign + fmt(movement) + '</div>';
        html += '</div></div>';
        html += '</div>';
    }
    
    // Add total row
    html += '<div class="li-row total-li">';
    html += '<div class="li-label">Total All Accounts</div>';
    html += '<div class="li-vals"><span class="li-amount big">Rs. ' + fmt(totalBalance) + '</span></div>';
    html += '</div>';
    
    $('#acc-card').html(html);
}

// Render expences with REAL data
function renderExpensesFromRealData(expenses, total) {
    if(total > 0) {
        var maxAmount = Math.max(...expenses.map(e => e.amount));
        var html = '';
        for(var i = 0; i < expenses.length; i++) {
            var e = expenses[i];
            var pct = maxAmount > 0 ? (e.amount / maxAmount * 100).toFixed(0) : 0;
            html += '<div class="li-row">';
            html += '<div class="li-label">';
            html += '<div style="width:7px;height:7px;border-radius:50%;background:var(--orange);flex-shrink:0;"></div>';
            html += e.cat;
            html += '<div style="flex:1;margin:0 8px;height:4px;background:#f0f2f8;border-radius:4px;overflow:hidden;">';
            html += '<div style="height:100%;width:' + pct + '%;background:var(--orange);border-radius:4px;"></div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="li-vals"><span class="li-amount">Rs. ' + fmt(e.amount) + '</span></div>';
            html += '</div>';
        }
        html += '<div class="li-row total-li">';
        html += '<div class="li-label">Total Expenses</div>';
        html += '<div class="li-vals"><span class="li-amount" style="color:var(--orange);">Rs. ' + fmt(total) + '</span></div>';
        html += '</div>';
        $('#exp-card').html(html);
    } else {
        $('#exp-card').html('<div style="text-align:center;padding:18px;color:var(--text-muted);font-size:12px;"><i class="fa-solid fa-receipt" style="font-size:22px;display:block;margin-bottom:6px;"></i>No expenses recorded today</div>');
    }
}

// Render pending items with REAL data
function renderPendingFromRealData(pendingItems) {
    if(pendingItems.length === 0) {
        $('#pending-card').html('<div style="text-align:center;padding:18px;color:var(--success);font-size:12px;font-weight:700;"><i class="fa-solid fa-circle-check" style="font-size:22px;display:block;margin-bottom:6px;"></i>Nothing pending</div>');
        return;
    }
    
    var html = '';
    for(var i = 0; i < pendingItems.length; i++) {
        var p = pendingItems[i];
        var none = p.count === 0;
        html += '<div class="li-row">';
        html += '<div class="li-label">';
        html += '<div style="width:7px;height:7px;border-radius:50%;background:' + p.color + ';flex-shrink:0;"></div>';
        html += '<div>';
        html += '<div style="font-size:12px;font-weight:600;">' + p.cat + '</div>';
        html += '<div style="font-size:10px;color:var(--text-muted);margin-top:1px;">' + p.note + '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="li-vals">';
        html += '<span style="font-size:11px;font-weight:800;background:var(--warning-light);color:#92400e;padding:2px 8px;border-radius:20px;font-family:JetBrains Mono,monospace;">' + p.count + '</span>';
        html += '</div>';
        html += '</div>';
    }
    
    $('#pending-card').html(html);
}


// Render reconciliation with REAL data
function renderReconFromRealData(data) {
    var lhs = data.net_sales;
    var rhs = data.total_rhs;
    var diff = data.difference;
    var ok = data.is_balanced;
    
    var html = liRow('Gross Sales', 'var(--success)', '', 'Rs. ' + fmt(data.gross_sales), 'green')
             + liRow('− Returns', 'var(--danger)', '', 'Rs. ' + fmt(Math.abs(data.returns)), 'red')
             + liRow('− Discounts', 'var(--warning)', '', 'Rs. ' + fmt(Math.abs(data.discounts)), 'red')
             + liTotal('Net Sales (LHS)', 'Rs. ' + fmt(lhs))
             + '<div style="height:6px;"></div>'
             + liRow('Cash Collected', 'var(--success)', '', 'Rs. ' + fmt(data.cash_collected), 'green')
             + liRow('Credit Forward', 'var(--purple)', '', 'Rs. ' + fmt(data.credit_forward), '')
             + liTotal('Total RHS', 'Rs. ' + fmt(rhs))
             + '<div style="margin-top:8px;padding:8px 10px;border-radius:var(--r-sm);'
             +   'background:' + (ok ? 'var(--success-light)' : 'var(--danger-light)') + ';'
             +   'display:flex;align-items:center;justify-content:space-between;">'
             + '<span style="font-size:12px;font-weight:800;color:' + (ok ? '#065f46' : '#991b1b') + ';display:flex;align-items:center;gap:6px;">'
             + '<i class="fa-solid ' + (ok ? 'fa-circle-check' : 'fa-circle-xmark') + '"></i>' + (ok ? 'Reconciled' : 'Not Reconciled')
             + '</span>'
             + '<span style="font-family:JetBrains Mono,monospace;font-size:12px;font-weight:800;color:' + (ok ? '#065f46' : '#991b1b') + ';"> Δ Rs. ' + fmt(Math.abs(diff)) + '</span>'
             + '</div>';
    
    $('#recon-card').html(html);
}

function render(){
    renderContext();
    renderStatusMsgs();
    renderBottomBar();
}

function addWarehouseSelector() {
    var selectorHtml = '<select id="warehouse_selector" class="fc" style="width:150px; margin-left:8px;">';
    selectorHtml += '<option value="1">Main Store</option>';
    selectorHtml += '<option value="2">Branch 1</option>';
    selectorHtml += '<option value="3">Branch 2</option>';
    selectorHtml += '</select>';
    $('.ctx-row').append(selectorHtml);
    
    // Refresh data when warehouse changes
    $('#warehouse_selector').on('change', function() {
        load();
    });
}


// Update renderContext to use dynamic warehouse name
function renderContext() {
    var dayLabel = formatDate(D.date);
    $('#ctx-sub').text(D.warehouse + ' \u00b7 ' + dayLabel);
    
    if (D.status === 'closed') {
        $('#period-chip').html('<span class="period-chip pc-closed"><i class="fa-solid fa-lock"></i> Period Closed</span>');
        $('#hdr-actions').html(reopenBtn());
    } else {
        $('#period-chip').html('<span class="period-chip pc-open"><i class="fa-solid fa-circle" style="font-size:8px;"></i> Open</span>');
        $('#hdr-actions').html('');
    }
}

/* STATUS MESSAGES */
function renderStatusMsgs(){
  var msgs = [];
  if (D.status === 'closed') {
    msgs.push({type:'closed', icon:'fa-lock',
      text:'Period is <strong>closed</strong>. Closed by <strong>'+D.closed_by+'</strong> at '+D.closed_at+'. No backdated transactions allowed.'});
  } else {
    D.blocks.forEach(function(b){ msgs.push({type:'warn', icon:'fa-triangle-exclamation', text:b.msg}); });
    if (!D.blocks.length) msgs.push({type:'ok', icon:'fa-circle-check', text:'All checks passed. Ready to close the period.'});
  }
  var html = msgs.map(function(m){
    var cls = m.type==='closed'?'smsg-closed':m.type==='warn'?'smsg-warn':'smsg-ok';
    return '<div class="smsg '+cls+'"><i class="fa-solid '+m.icon+'"></i><div class="smsg-text">'+m.text+'</div></div>';
  }).join('');
  $('#status-msgs').html(html ? '<div class="status-msgs">'+html+'</div>' : '');
}

 
 

 
 
 

/* BOTTOM BAR - Using REAL data */
function renderBottomBar(){
  var totalSales = realData.totalSales;
  var totalExp = realData.totalExpenses;
  var totalAccBal = realData.totalAccountBalance;
  var pendCount = realData.pendingCount;
  var reconOk = window._reconOk === true;
  var canClose = D.status === 'open' && reconOk && D.blocks.length === 0;
  var isClosed = D.status === 'closed';

  var actionBtn;
  if (isClosed){
    actionBtn='<button class="btn-end btn-end-closed" onclick="openReopenModal()">'
      +'<i class="fa-solid fa-lock-open"></i>Reopen Period</button>';
  } else if (canClose){
    actionBtn='<button class="btn-end btn-end-ok" onclick="runDayEnd()">'
      +'<i class="fa-solid fa-moon"></i>Close Day End</button>';
  } else {
    actionBtn='<div style="text-align:center;">'
      +'<button class="btn-end btn-end-blocked" disabled><i class="fa-solid fa-ban"></i>Cannot Close Yet</button>'
      +'<div style="font-size:11px;color:rgba(255,255,255,.4);margin-top:6px;">Resolve the issues shown above</div>'
    +'</div>';
  }

  $('#bottom-bar').html('<div class="bottom-bar">'
    +'<div class="bb-totals">'
      +bbTot("Today's Sales",   'Rs. '+fmtK(totalSales),  'Gross invoiced')
      +bbTot('Total Expenses',  'Rs. '+fmtK(totalExp),    'Today\'s expenses')
      +bbTot('Account Balance', 'Rs. '+fmtK(totalAccBal), 'Across all accounts')
      +bbTot('Pending Items',   pendCount+' items', pendCount?'Need attention':'All clear',
             pendCount?'#fbbf24':'#6ee7b7')
      +bbTot('Period Status',
             isClosed?'Closed':'Open',
             isClosed?'Locked — '+D.closed_at:'Trading in progress',
             isClosed?'#fca5a5':'#6ee7b7')
    +'</div>'
    +'<div class="bb-action">'+actionBtn+'</div>'
  +'</div>');
}

/* SHARED ROW BUILDERS */
function liRow(label, dotColor, count, amount, amtClass){
  return '<div class="li-row">'
    +'<div class="li-label">'
      +'<div style="width:7px;height:7px;border-radius:50%;background:'+dotColor+';flex-shrink:0;"></div>'
      +label
    +'</div>'
    +'<div class="li-vals">'
      +(count?'<span class="li-count">'+count+'</span>':'<span class="li-count"></span>')
      +'<span class="li-amount'+(amtClass?' '+amtClass:'')+'">'+amount+'</span>'
    +'</div>'
  +'</div>';
}
function liTotal(label, amount){
  return '<div class="li-row total-li">'
    +'<div class="li-label">'+label+'</div>'
    +'<div class="li-vals"><span class="li-amount big">'+amount+'</span></div>'
  +'</div>';
}
function bbTot(label, val, sub, valColor){
  return '<div class="bb-tot-item">'
    +'<div class="bb-tot-lbl">'+label+'</div>'
    +'<div class="bb-tot-val"'+(valColor?' style="color:'+valColor+';"':'')+'>'+val+'</div>'
    +'<div class="bb-tot-sub">'+sub+'</div>'
  +'</div>';
}

function reopenBtn(){
  return '<button class="btn btn-warn-o btn-sm" onclick="openReopenModal()"><i class="fa-solid fa-lock-open"></i>Reopen Period</button>';
}
function openReopenModal(){ $('#reopen-modal').addClass('show'); }

/* ACTIONS */
function runDayEnd(){
  if (!confirm('Close Day End for '+D.warehouse+' — '+formatDate(D.date)+'?\n\nThis will lock the period.')) return;
  toast('Running Day End…','i');
  setTimeout(function(){
    D.status='closed'; D.closed_by='Admin User'; D.closed_at=nowStr();
    render(); toast('Period closed and locked.','s');
  },1200);
}
function confirmReopen(){
  if (!$('#reopen-reason').val().trim()){ toast('Enter a reason','w'); return; }
  if (!$('#reopen-pass').val().trim()){   toast('Enter password','w');  return; }
  $('#reopen-modal').removeClass('show');
  D.status='open'; D.closed_by=null; D.closed_at=null;
  render(); toast('Period reopened. Action logged.','w');
}

/* HELPERS */
function formatDate(d){
  if (!d) return '';
  var dt=new Date(d+'T00:00:00');
  return dt.toLocaleDateString('en-GB',{weekday:'short',day:'numeric',month:'short',year:'numeric'});
}
function fmt(n){ return Number(n).toLocaleString('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2}); }
function fmtK(n){ return n>=1000000?(n/1000000).toFixed(2)+'M':n>=1000?(n/1000).toFixed(0)+'K':fmt(n); }
function nowStr(){ var d=new Date(); return d.toISOString().slice(0,16).replace('T',' '); }
function toast(msg,type){
  var m={s:['t-s','fa-check-circle'],w:['t-w','fa-triangle-exclamation'],e:['t-e','fa-circle-xmark'],i:['t-i','fa-circle-info']};
  var p=m[type]||m.i;
  var $t=$('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i>'+msg+'</div>');
  $('#toast-c').append($t);
  setTimeout(function(){$t.css({opacity:0,transform:'translateX(16px)',transition:'all .3s'});setTimeout(function(){$t.remove();},300);},2800);
}
</script>
  
 
</body>
</html>
