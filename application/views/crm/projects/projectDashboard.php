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
  --rose:#f43f5e;--rose-light:#ffe4e6;
  --sidebar-bg:#1a1f36;--sidebar-text:#a8b4d8;
  --page-bg:#f2f4fa;--card-bg:#fff;--card-border:#e4e9f4;
  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
  --input-border:#d1d9e6;--table-head:#f7f9ff;
  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.10);--sh-lg:0 8px 32px rgba(61,82,160,.14);
  --r-sm:8px;--r-md:12px;--r-lg:16px;--r-xl:20px;
  --sidebar-w:240px;--header-h:60px;--tr:.2s cubic-bezier(.4,0,.2,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;overflow-x:hidden;}
::-webkit-scrollbar{width:5px;height:5px;}::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

/* ── SIDEBAR ── */
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

/* ── HEADER ── */
.header{position:fixed;top:0;left:var(--sidebar-w);right:0;height:var(--header-h);background:#fff;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;padding:0 22px;z-index:90;box-shadow:var(--sh-sm);}
.bc{display:flex;align-items:center;gap:5px;font-size:13px;color:var(--text-muted);}
.bc a{color:var(--primary);text-decoration:none;font-weight:500;}
.bc .sep{color:#ccc;}.bc .cur{color:var(--text-dark);font-weight:600;}
.hdr-r{display:flex;align-items:center;gap:10px;}
.hbtn{width:34px;height:34px;border-radius:var(--r-sm);border:1px solid var(--card-border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-muted);transition:all var(--tr);position:relative;}
.hbtn:hover{border-color:var(--primary);color:var(--primary);}
.hbtn .dot{position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:var(--danger);border:1.5px solid #fff;}
.upill{display:flex;align-items:center;gap:8px;background:var(--primary-light);border-radius:20px;padding:4px 12px 4px 4px;cursor:pointer;}
.uav{width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;}
.unm{font-size:12px;font-weight:600;color:var(--primary);}

/* ── MAIN ── */
.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:20px 22px;min-height:calc(100vh - var(--header-h));}

/* ── BUTTONS ── */
.btn{padding:9px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;gap:7px;}
.btn-primary{background:var(--primary);color:#fff;box-shadow:0 2px 8px rgba(61,82,160,.22);}
.btn-primary:hover{background:var(--primary-d);transform:translateY(-1px);}
.btn-outline{background:#fff;color:var(--text-mid);border:1.5px solid var(--card-border);}
.btn-outline:hover{border-color:var(--primary);color:var(--primary);}
.btn-success{background:var(--success);color:#fff;box-shadow:0 2px 8px rgba(16,185,129,.22);}
.btn-success:hover{background:var(--success-d);transform:translateY(-1px);}
.btn-teal{background:var(--teal);color:#fff;box-shadow:0 2px 8px rgba(20,184,166,.22);}
.btn-teal:hover{background:#0f766e;transform:translateY(-1px);}
.btn-sm{padding:7px 13px;font-size:12px;}
.btn-xs{padding:5px 10px;font-size:11px;border-radius:6px;}

/* ── PROJECT HERO ── */
.project-hero{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-lg);box-shadow:var(--sh-sm);margin-bottom:16px;overflow:hidden;}
.hero-banner{background:linear-gradient(120deg,#1a1f36 0%,#2d3d80 45%,#3d52a0 100%);padding:22px 26px 0;position:relative;overflow:hidden;}
.hero-banner::before{content:'';position:absolute;top:-60px;right:-60px;width:260px;height:260px;border-radius:50%;background:rgba(255,255,255,.04);}
.hero-banner::after{content:'';position:absolute;bottom:-30px;left:35%;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.03);}
.hero-top{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;position:relative;z-index:1;padding-bottom:20px;}
.project-code{font-family:'JetBrains Mono',monospace;font-size:11px;color:rgba(255,255,255,.55);font-weight:600;letter-spacing:.5px;margin-bottom:5px;}
.project-name{font-size:21px;font-weight:800;color:#fff;letter-spacing:-.3px;line-height:1.2;max-width:560px;}
.project-client{font-size:13px;color:rgba(255,255,255,.65);margin-top:5px;display:flex;align-items:center;gap:6px;}
.ps{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;}
.ps-active{background:rgba(16,185,129,.25);color:#6ee7b7;border:1px solid rgba(16,185,129,.3);}
.btn-ho{background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.22);backdrop-filter:blur(8px);}
.btn-ho:hover{background:rgba(255,255,255,.22);}
.btn-hw{background:#fff;color:var(--primary);}
.btn-hw:hover{background:var(--primary-light);}

/* Info strip */
.hero-strip{display:grid;grid-template-columns:repeat(5,1fr);border-top:1px solid var(--card-border);}
.hs-item{padding:13px 18px;border-right:1px solid var(--card-border);}
.hs-item:last-child{border-right:none;}
.hs-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:4px;}
.hs-val{font-size:14px;font-weight:700;color:var(--text-dark);}
.hs-sub{font-size:11px;color:var(--text-muted);margin-top:2px;}
.prog-wrap{width:100%;height:5px;background:#e8ecf4;border-radius:10px;overflow:hidden;margin-top:5px;}
.prog-fill{height:100%;border-radius:10px;background:linear-gradient(90deg,var(--success),#34d399);transition:width .6s ease;}

/* ── KPI GRID ── */
.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px;}
.kpi-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:16px 18px;box-shadow:var(--sh-sm);transition:all var(--tr);position:relative;overflow:hidden;}
.kpi-card:hover{transform:translateY(-2px);box-shadow:var(--sh-md);}
.kpi-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
.k-exp::before{background:linear-gradient(90deg,var(--danger),#f87171);}
.k-inv::before{background:linear-gradient(90deg,var(--purple),#a78bfa);}
.k-pay::before{background:linear-gradient(90deg,var(--success),#34d399);}
.k-bal::before{background:linear-gradient(90deg,var(--teal),#2dd4bf);}
.k-bud::before{background:linear-gradient(90deg,var(--warning),#fbbf24);}
.k-note::before{background:linear-gradient(90deg,var(--orange),#fb923c);}
.kpi-icon{width:38px;height:38px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:10px;}
.kpi-main{display:flex;align-items:flex-end;gap:8px;margin-bottom:2px;}
.kpi-val{font-size:19px;font-weight:800;color:var(--text-dark);font-family:'JetBrains Mono',monospace;line-height:1;}
.kpi-val.big{font-size:22px;}
.kpi-badge{font-size:10px;font-weight:800;padding:2px 7px;border-radius:20px;white-space:nowrap;align-self:center;}
.kpi-lbl{font-size:10px;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-top:3px;}
.kpi-sub-row{display:flex;align-items:center;gap:8px;margin-top:6px;flex-wrap:wrap;}
.kpi-sub-item{display:flex;align-items:center;gap:4px;font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;}
.bb-wrap{width:100%;height:5px;background:#f0f2f8;border-radius:10px;overflow:hidden;margin-top:7px;}
.bb-fill{height:100%;border-radius:10px;transition:width .6s ease;}

/* ── CHARTS ROW ── */
/* Mobile responsive override */
@media (max-width: 991px) {
    .charts-row {
        flex-wrap: wrap;
    }
    .charts-row .chart-card {
        flex: 1 1 100%;
        max-width: 100%;
    }
}
.charts-row .chart-card {
    flex: 1 1 50%;        /* CRITICAL: Forces each card to occupy exactly 50% width */
    max-width: calc(50% - 8px); /* Account precisely for the flex gap offset */
    background: #ffffff;
    border: 1px solid #e8ecf4;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    display: flex;        /* Makes internal card elements flexible */
    flex-direction: column;
}
/*.charts-row{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:16px;}*/
.charts-row {
    display: flex;
    flex-direction: row;  /* Align cards side by side horizontally */
    flex-wrap: nowrap;    /* Prevent accidental uneven row breaks on desktop */
    gap: 16px;            /* Consistent spacing gap between your two cards */
    width: 100%;          /* Forces full edge-to-edge container stretch */
    align-items: stretch; /* Forces both charts to match each other's height perfectly */
    margin-bottom: 20px;
}
.chart-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;}
.cc-head{padding:12px 16px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:8px;}
.cc-head h6{font-size:12px;font-weight:700;color:var(--text-dark);margin:0;flex:1;}
.sec-icon{width:26px;height:26px;border-radius:6px;background:var(--primary-light);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:11px;flex-shrink:0;}
.cc-body{padding:14px 16px;}
.chart-leg{display:flex;flex-direction:column;gap:5px;margin-top:10px;}
.leg-row{display:flex;align-items:center;justify-content:space-between;font-size:11px;}
.leg-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
.leg-lbl{color:var(--text-muted);font-weight:600;display:flex;align-items:center;gap:5px;flex:1;}
.leg-val{font-weight:800;font-family:'JetBrains Mono',monospace;color:var(--text-dark);}

/* inline bar chart in legend */
.mini-bar-row{margin-bottom:7px;}
.mini-bar-lbl{display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;}
.mini-bar-name{font-size:11px;font-weight:600;color:var(--text-mid);}
.mini-bar-val{font-size:11px;font-weight:800;font-family:'JetBrains Mono',monospace;color:var(--text-dark);}
.mini-track{height:6px;background:#f0f2f8;border-radius:10px;overflow:hidden;}
.mini-fill{height:100%;border-radius:10px;transition:width .7s cubic-bezier(.4,0,.2,1);}

/* ── TAB CARD ── */
.tab-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;}
.tabs-header{display:flex;border-bottom:2px solid var(--card-border);padding:0 4px;overflow-x:auto;}
.tab-item{padding:12px 16px;font-size:12px;font-weight:600;color:var(--text-muted);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;white-space:nowrap;transition:all var(--tr);display:flex;align-items:center;gap:6px;}
.tab-item:hover{color:var(--primary);}
.tab-item.active{color:var(--primary);border-bottom-color:var(--primary);font-weight:700;}
.tc{font-size:10px;font-weight:800;padding:1px 6px;border-radius:20px;background:var(--primary-mid);color:var(--primary);}
.tab-item.active .tc{background:var(--primary);color:#fff;}
.tab-body{padding:16px;}
.tab-pane{display:none;}
.tab-pane.active{display:block;}

/* ── TOOLBAR ── */
.tab-toolbar{display:flex;align-items:center;gap:8px;margin-bottom:12px;flex-wrap:wrap;}
.sw{position:relative;flex:1;min-width:150px;}
.sw i{position:absolute;left:9px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;pointer-events:none;}
.sw input{width:100%;padding:7px 9px 7px 28px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;color:var(--text-dark);outline:none;transition:border-color var(--tr);}
.sw input:focus{border-color:var(--primary);}
.sw input::placeholder{color:var(--text-muted);}
.fsel{padding:7px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;font-weight:600;color:var(--text-dark);outline:none;background:#fff;cursor:pointer;}
.fsel:focus{border-color:var(--primary);}
.rc{font-size:12px;color:var(--text-muted);font-weight:600;white-space:nowrap;}

/* ── TABLE ── */
.tbl-wrap{overflow-x:auto;border-radius:var(--r-md);border:1px solid var(--card-border);}
.tbl{width:100%;border-collapse:collapse;min-width:580px;}
.tbl thead tr{background:var(--table-head);}
.tbl th{padding:10px 13px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);border-bottom:2px solid var(--card-border);white-space:nowrap;}
.tbl th.r,.tbl td.r{text-align:right;}
.tbl td{padding:10px 13px;font-size:13px;border-bottom:1px solid var(--card-border);vertical-align:middle;}
.tbl tbody tr:last-child td{border-bottom:none;}
.tbl tbody tr{transition:background var(--tr);}
.tbl tbody tr:hover{background:#fafbff;}
.mono{font-family:'JetBrains Mono',monospace;}

/* ── BADGES ── */
.badge{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;}
.b-pri{background:var(--primary-light);color:var(--primary);}
.b-suc{background:var(--success-light);color:#065f46;}
.b-warn{background:var(--warning-light);color:#92400e;}
.b-dan{background:var(--danger-light);color:#991b1b;}
.b-info{background:var(--info-light);color:#0369a1;}
.b-purp{background:var(--purple-light);color:#6d28d9;}
.b-teal{background:var(--teal-light);color:#0f766e;}
.b-orange{background:var(--orange-light);color:#c2410c;}

/* ── ACTIVITY ── */
.act-list{display:flex;flex-direction:column;}
.act-entry{display:flex;gap:13px;padding:11px 0;border-bottom:1px solid var(--card-border);}
.act-entry:last-child{border-bottom:none;}
.act-line{display:flex;flex-direction:column;align-items:center;}
.act-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;margin-top:3px;}
.act-trail{width:1px;flex:1;background:var(--card-border);margin-top:5px;}
.act-msg{font-size:13px;color:var(--text-dark);font-weight:500;line-height:1.45;}
.act-msg strong{font-weight:700;}
.act-meta{font-size:11px;color:var(--text-muted);margin-top:3px;display:flex;align-items:center;gap:5px;}

/* ── NOTES ── */
.note-card{background:linear-gradient(135deg,#fef9c3,#fef3c7);border:1.5px solid #fde68a;border-radius:var(--r-md);padding:14px 16px;margin-bottom:10px;position:relative;}
.note-card:last-of-type{margin-bottom:0;}
.note-text{font-size:13px;color:var(--text-dark);line-height:1.6;}
.note-foot{display:flex;align-items:center;justify-content:space-between;margin-top:8px;}
.note-by{font-size:11px;color:#92400e;font-weight:600;}
.del-note{background:none;border:none;cursor:pointer;color:#b45309;font-size:12px;padding:2px 6px;border-radius:4px;transition:all var(--tr);}
.del-note:hover{background:var(--danger-light);color:var(--danger);}
.add-note-area{margin-top:14px;border-top:1px solid var(--card-border);padding-top:14px;}

/* ── EMPTY ── */
.empty-state{text-align:center;padding:36px 20px;color:var(--text-muted);}
.empty-state i{font-size:32px;opacity:.2;display:block;margin-bottom:8px;}
.empty-state p{font-size:12px;}

/* ── DEL BTN ── */
.del-btn{background:none;border:1.5px solid var(--danger-light);color:var(--danger);border-radius:var(--r-sm);width:26px;height:26px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;font-size:11px;transition:all var(--tr);}
.del-btn:hover{background:var(--danger);color:#fff;}

/* ── PAYMENT SCREEN OVERLAY ── */
.pay-screen{position:fixed;inset:0;background:var(--page-bg);z-index:600;display:none;overflow-y:auto;}
.pay-screen.show{display:block;}
.pay-screen-header{background:#fff;border-bottom:1px solid var(--card-border);padding:0 28px;height:var(--header-h);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:10;box-shadow:var(--sh-sm);}
.pay-screen-header h4{font-size:16px;font-weight:800;color:var(--text-dark);}
.pay-screen-body{max-width:680px;margin:32px auto;padding:0 24px 40px;}

/* ── EXPENSE MODAL ── */
.modal-bg{position:fixed;inset:0;background:rgba(10,18,45,.55);z-index:500;display:none;align-items:flex-start;justify-content:center;padding:32px 16px;overflow-y:auto;}
.modal-bg.show{display:flex;}
.modal-box{background:#fff;border-radius:var(--r-xl);width:100%;max-width:540px;box-shadow:var(--sh-lg);animation:popIn .3s cubic-bezier(.34,1.56,.64,1);margin:auto;}
@keyframes popIn{from{opacity:0;transform:scale(.9)}to{opacity:1;transform:scale(1)}}
.mb-head{padding:20px 22px 0;display:flex;align-items:center;justify-content:space-between;}
.mb-head h4{font-size:15px;font-weight:800;color:var(--text-dark);}
.mb-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:17px;width:30px;height:30px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;transition:all var(--tr);}
.mb-close:hover{background:var(--danger-light);color:var(--danger);}
.mb-body{padding:18px 22px;}
.mb-foot{padding:14px 22px;border-top:1px solid var(--card-border);display:flex;justify-content:flex-end;gap:8px;}
.form-row{margin-bottom:14px;}
.form-lbl{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-mid);display:block;margin-bottom:5px;}
.form-lbl span{color:var(--danger);}
.fc{width:100%;padding:9px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr),box-shadow var(--tr);background:#fff;}
.fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
.fc::placeholder{color:var(--text-muted);}
textarea.fc{resize:vertical;min-height:60px;}
.ig{position:relative;}.ig .fc{padding-left:34px;}
.ig .ipfx{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;font-weight:600;pointer-events:none;}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;}
.err{font-size:11px;color:var(--danger);font-weight:600;margin-top:3px;display:none;}

/* family pills */
.fam-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:7px;margin-top:4px;}
.fam-pill{padding:9px 7px;border:1.5px solid var(--card-border);border-radius:var(--r-sm);text-align:center;cursor:pointer;transition:all var(--tr);}
.fam-pill i{font-size:16px;display:block;margin-bottom:3px;color:var(--text-muted);}
.fam-pill span{font-size:10px;font-weight:700;color:var(--text-muted);display:block;}
.fam-pill.sel{border-color:var(--primary);background:var(--primary-light);}
.fam-pill.sel i,.fam-pill.sel span{color:var(--primary);}

/*modal scrolling*/
/* Custom Scrollbar for a modern look */
#account-list::-webkit-scrollbar {
    width: 6px;
}
#account-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
#account-list::-webkit-scrollbar-thumb {
    background: var(--primary-mid); /* Uses your primary color theme */
    border-radius: 10px;
}
#account-list::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}

/* ── TOAST ── */
#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;display:flex;align-items:center;gap:7px;box-shadow:0 4px 16px rgba(0,0,0,.18);animation:tIn .25s ease;max-width:300px;}
@keyframes tIn{from{opacity:0;transform:translateX(16px)}to{opacity:1;transform:translateX(0)}}
.t-s{background:var(--success);color:#fff;}.t-e{background:var(--danger);color:#fff;}.t-i{background:var(--primary);color:#fff;}.t-w{background:var(--warning);color:#fff;}












/* ═══════════════════════════════════════
   INVOICE MODAL - Base
   ═══════════════════════════════════════ */
#invoiceModal .modal-dialog,
#viewInvoiceModal .modal-dialog {
  max-width: 900px;
}

.siv-modal {
  border: none;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,0.25);
}

.siv-modal-header {
  border-bottom: 1px solid #eef0f4;
  padding: 18px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
}

.siv-modal-header .modal-title {
  font-size: 18px;
  font-weight: 700;
  color: #1e2330;
  margin: 0;
}

.siv-modal-header .btn-close {
  opacity: 0.45;
  font-size: 12px;
}
.siv-modal-header .btn-close:hover { opacity: 0.85; }

.siv-modal-body {
  background: #f4f5f8;
  padding: 20px 24px;
  max-height: 75vh;
  overflow-y: auto;
}

/* Scrollbar polish */
.siv-modal-body::-webkit-scrollbar { width: 8px; }
.siv-modal-body::-webkit-scrollbar-track { background: transparent; }
.siv-modal-body::-webkit-scrollbar-thumb { background: #d5d9e0; border-radius: 8px; }
.siv-modal-body::-webkit-scrollbar-thumb:hover { background: #b7bcc7; }

.siv-modal-footer {
  border-top: 1px solid #eef0f4;
  padding: 14px 24px;
  gap: 10px;
  background: #fff;
}

/* ═══════════════════════════════════════
   BUTTONS
   ═══════════════════════════════════════ */
.siv-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: background .15s, border-color .15s;
}

.siv-btn-outline {
  background: #fff;
  border: 1.5px solid #e3e6ec;
  color: #384152;
}
.siv-btn-outline:hover { background: #f7f8fb; }

.siv-btn-primary {
  background: #2b3a75;
  color: #fff;
}
.siv-btn-primary:hover { background: #1e3fc0; }

.siv-btn-save { padding: 10px 22px; }
.siv-add-btn { height: 39px; white-space: nowrap; }

/* ═══════════════════════════════════════
   CARDS (sections inside modal body)
   ═══════════════════════════════════════ */
.siv-card {
  background: #fff;
  border: 1px solid #e9ebf0;
  border-radius: 12px;
  margin-bottom: 16px;
  overflow: hidden;
  width: 100%;
}
.siv-card:last-child { margin-bottom: 0; }

.siv-card-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 13px 16px;
  font-weight: 700;
  font-size: 14px;
  color: #1e2330;
  border-bottom: 1px solid #f0f1f4;
}

.siv-icon { color: #2851e3; margin-right: 8px; }

.siv-badge {
  background: #eef1fb;
  color: #2851e3;
  font-size: 11.5px;
  font-weight: 700;
  padding: 3px 10px;
  border-radius: 20px;
}

.siv-card-body { padding: 16px; }

/* ═══════════════════════════════════════
   FORM FIELDS
   ═══════════════════════════════════════ */
.siv-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
  margin-bottom: 14px;
}
.siv-row:last-child { margin-bottom: 0; }

.siv-field label {
  font-size: 11px;
  font-weight: 700;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: .4px;
  margin-bottom: 6px;
  display: block;
}

.req { color: #e74c3c; }

.siv-input,
select.siv-input,
textarea.siv-input {
  width: 100%;
  border: 1.5px solid #e3e6ec;
  border-radius: 9px;
  padding: 5px 10px;
  font-size: 13.5px;
  color: #1e2330;
  background: #fff;
  transition: border-color .15s, box-shadow .15s;
}

.siv-input::placeholder { color: #b3b8c2; }

.siv-input:focus {
  border-color: #2851e3;
  outline: none;
  box-shadow: 0 0 0 3px rgba(40,81,227,.12);
}

.siv-input.is-invalid { border-color: #d64545 !important; }

.siv-error {
  display: none;
  color: #d64545;
  font-size: 11.5px;
  font-weight: 600;
  margin-top: 5px;
}
.siv-error.show { display: block; }

textarea.siv-input { resize: vertical; }

/* ═══════════════════════════════════════
   ADD ITEM ROW
   ═══════════════════════════════════════ */
.siv-additem-row {
  display: flex;
  gap: 10px;
  align-items: end;
  background: #f9fafc;
  border: 1px dashed #dde1ea;
  border-radius: 10px;
  padding: 12px;
  margin-bottom: 10px;
  flex-wrap: wrap;
}

.siv-field.grow { flex: 1; min-width: 200px; }
.siv-field.small { width: 130px; }
.siv-field.xsmall { width: 90px; }

.siv-prefix-input {
  position: relative;
  display: flex;
  align-items: center;
}
.siv-prefix-input span {
  position: absolute;
  left: 12px;
  font-size: 12.5px;
  color: #8a90a0;
  font-weight: 600;
  pointer-events: none;
}
.siv-prefix-input input { padding-left: 32px; }

.siv-suffix-input {
  position: relative;
  display: flex;
  align-items: center;
}
.siv-suffix-input span {
  position: absolute;
  right: 12px;
  font-size: 12.5px;
  color: #8a90a0;
  font-weight: 600;
  pointer-events: none;
}
.siv-suffix-input input { padding-right: 26px; }

/* ═══════════════════════════════════════
   ITEMS TABLE
   ═══════════════════════════════════════ */
.siv-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 4px;
}

.siv-table thead th {
  font-size: 10.5px;
  font-weight: 700;
  color: #9aa0ac;
  text-transform: uppercase;
  letter-spacing: .5px;
  text-align: left;
  padding: 8px 10px;
  border-bottom: 1.5px solid #eef0f4;
}
.siv-table thead th.r,
.siv-table td.r { text-align: right; }

.siv-table tbody td {
  padding: 9px 10px;
  font-size: 13px;
  color: #1e2330;
  border-bottom: 1px solid #f2f3f6;
}
.siv-table tbody tr:last-child td { border-bottom: none; }
.siv-table tbody tr:hover { background: #fafbfd; }

.siv-table input[type="number"] {
  border: 1.5px solid #e3e6ec;
  border-radius: 7px;
  padding: 5px 7px;
  font-size: 12.5px;
  text-align: right;
}
.siv-table input[type="number"]:focus {
  border-color: #2851e3;
  outline: none;
}

.siv-btn-danger-icon {
  background: transparent;
  border: none;
  color: #d64545;
  padding: 4px 8px;
  cursor: pointer;
  border-radius: 6px;
  transition: background .15s;
}
.siv-btn-danger-icon:hover { background: #fdeaea; }

/* Empty state */
.siv-empty {
  text-align: center;
  padding: 30px 0 18px;
  color: #b3b8c2;
}
.siv-empty i {
  font-size: 30px;
  margin-bottom: 8px;
  display: block;
}
.siv-empty p { margin: 0; font-size: 13px; }

/* ═══════════════════════════════════════
   SUMMARY GRID
   ═══════════════════════════════════════ */
.siv-summary-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 14px;
}

.siv-sumline {
  display: flex;
  flex-direction: column;
  gap: 6px;
  font-size: 12px;
  color: #6b7280;
}

.siv-sumline b {
  font-family: 'Courier New', monospace;
  font-weight: 700;
  font-size: 15px;
  color: #1e2330;
}

.siv-sumline .neg { color: #d64545; }

.siv-sumline.total {
  border-left: 2px solid #eef0f4;
  padding-left: 14px;
}
.siv-sumline.total b {
  font-size: 19px;
  color: #2851e3;
}

/* ═══════════════════════════════════════
   STATUS BADGES (view modal)
   ═══════════════════════════════════════ */
.siv-status-badge {
  font-size: 11px;
  font-weight: 700;
  padding: 3px 10px;
  border-radius: 20px;
  text-transform: capitalize;
}
.status-unpaid    { background: #fdeaea; color: #d64545; }
.status-partial   { background: #fdf6e3; color: #d69e2e; }
.status-paid      { background: #e9f9f0; color: #2ea043; }
.status-cancelled { background: #f0f1f4; color: #6b7280; }

/* ═══════════════════════════════════════
   VIEW INVOICE MODAL SPECIFIC
   ═══════════════════════════════════════ */
#view-invoice-body p {
  font-size: 13.5px;
  color: #333;
  margin-bottom: 10px;
}
#view-invoice-body p b { color: #1e2330; }

/* ═══════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════ */
@media (max-width: 900px) {
  .siv-row,
  .siv-summary-grid {
    grid-template-columns: 1fr;
  }
  .siv-sumline.total {
    border-left: none;
    padding-left: 0;
    border-top: 1px solid #eef0f4;
    padding-top: 10px;
  }
  .siv-additem-row {
    flex-direction: column;
    align-items: stretch;
  }
  .siv-field.small,
  .siv-field.xsmall,
  .siv-field.grow {
    width: 100%;
  }
  .siv-add-btn { width: 100%; justify-content: center; }
}






/* ═══════════════════════════════════════
   SUMMARY BAR - standalone dark banner style
   ═══════════════════════════════════════ */
.siv-summary-bar {
  display: flex;
  align-items: center;
  background: #2b3a75;
  border-radius: 12px;
  padding: 16px 20px;
  margin: 4px 0 18px;
  gap: 0;
}

.siv-summary-item {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 5px;
  text-align: center;
}

.siv-summary-label {
  font-size: 10.5px;
  font-weight: 700;
  color: #8a90a0;
  text-transform: uppercase;
  letter-spacing: .5px;
}

.siv-summary-item b {
  font-family: 'Courier New', monospace;
  font-size: 16px;
  font-weight: 700;
  color: #fff;
}

.siv-summary-item b.neg { color: #ff8080; }

.siv-summary-divider {
  width: 1px;
  height: 34px;
  background: rgba(255,255,255,0.12);
  margin: 0 6px;
}

.siv-summary-grand {
  position: relative;
}
.siv-summary-grand b {
  font-size: 21px;
  color: #ffd166;
}
.siv-summary-grand .siv-summary-label {
  color: #ffd166;
  opacity: 0.7;
}

@media (max-width: 900px) {
  .siv-summary-bar {
    flex-wrap: wrap;
    gap: 14px;
  }
  .siv-summary-item { flex: 1 1 40%; }
  .siv-summary-divider { display: none; }
  .siv-summary-grand { flex: 1 1 100%; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 12px; }
}


	/* ============================================================
	   INVOICE PAYMENT SECTION
	============================================================ */

	.siv-payment-row {
		border: 1px solid #e5e7eb;
		border-radius: 8px;
		padding: 15px;
		margin-bottom: 12px;
		background: #fafafa;
	}

	.siv-payment-row-header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-bottom: 12px;
	}

	.siv-payment-row-title {
		font-weight: 600;
		font-size: 14px;
	}

	.siv-payment-remove {
		border: 0;
		background: transparent;
		color: #dc2626;
		cursor: pointer;
		font-size: 14px;
	}

	.siv-payment-fields {
		display: grid;
		grid-template-columns: 1fr 1fr 1fr;
		gap: 12px;
	}

	.siv-payment-extra {
		margin-top: 12px;
	}

	.siv-payment-summary {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 15px;
		margin-top: 20px;
		padding: 15px;
		border-radius: 8px;
		background: #f8fafc;
	}

	.siv-payment-summary > div {
		display: flex;
		flex-direction: column;
		gap: 4px;
	}

	.siv-payment-summary span {
		font-size: 12px;
		color: #6b7280;
	}

	.siv-payment-summary strong {
		font-size: 16px;
	}

	.siv-payment-balance-warning {
		color: #dc2626 !important;
	}

	.siv-payment-balance-success {
		color: #059669 !important;
	}

	@media (max-width: 768px) {

		.siv-payment-fields {
			grid-template-columns: 1fr;
		}

		.siv-payment-summary {
			grid-template-columns: 1fr;
		}

	}

</style>

<!-- MAIN DASHBOARD -->
<main class="main" id="main-dashboard">

  <!-- HERO -->
<div class="project-hero">
  <div class="hero-banner">
    <div class="hero-top">
      <div>
        <div class="project-code">Project #<span id="hero-display-id-top">0</span> · <span id="hero-category">Loading...</span></div>
        <div class="project-name" id="hero-project-name">Loading Project Context Title...</div>
        <div class="project-client">
          <i class="fa-solid fa-building" style="font-size:11px;"></i>
          <span id="hero-client-company">...</span> <span style="color:rgba(255,255,255,.35);">·</span>
          <i class="fa-solid fa-user" style="font-size:11px;"></i>
          <span id="hero-client-contact">...</span>
        </div>
        <div style="margin-top:9px;display:flex;align-items:center;gap:8px;">
          <span class="ps ps-active" id="hero-status-pill"><i class="fa-solid fa-circle" style="font-size:6px;"></i>Active</span>
          <span style="font-size:11px;color:rgba(255,255,255,.5);">Managed by <span id="hero-manager">...</span></span>
        </div>
      </div>
      <div style="display:flex;gap:8px;align-items:flex-start;flex-shrink:0;">
        <button class="btn btn-sm btn-ho" onclick="toast('Editing project details…','i')"><i class="fa-solid fa-pen"></i>Edit</button>
        <button class="btn btn-sm btn-ho" onclick="openExpenseModal()"><i class="fa-solid fa-receipt"></i>Add Expense</button>
        <button class="btn btn-sm btn-hw" onclick="openPayScreen()"><i class="fa-solid fa-plus"></i>Add Payment</button>
      </div>
    </div>
  </div>
  <div class="hero-strip">
    <div class="hs-item"><div class="hs-lbl">Start Date</div><div class="hs-val" id="hero-start-date">—</div><div class="hs-sub" id="hero-start-sub">—</div></div>
    <div class="hs-item"><div class="hs-lbl">Expected End</div><div class="hs-val" style="color:var(--warning);" id="hero-end-date">—</div><div class="hs-sub" id="hero-end-sub">—</div></div>
    <div class="hs-item"><div class="hs-lbl">Total Budget</div><div class="hs-val" style="font-family:'JetBrains Mono',monospace;font-size:13px;" id="hero-budget">—</div></div>
    <div class="hs-item"><div class="hs-lbl">Progress</div><div class="hs-val" style="color:var(--success);" id="hero-progress-txt">0%</div><div class="prog-wrap"><div class="prog-fill" id="hero-progress-bar" style="width:0%;"></div></div></div>
    <div class="hs-item"><div class="hs-lbl">Project ID</div><div class="hs-val" style="font-family:'JetBrains Mono',monospace;font-size:12px;" id="hero-display-id-bot">PRJ-000</div><div class="hs-sub" id="hero-created-sub">—</div></div>
  </div>
</div>

  <!-- KPI CARDS
  <div class="kpi-grid" id="kpi-grid"></div> -->

  <!-- CHARTS ROW -->
  <div class="charts-row" id="charts-row"></div>

  <!-- TABS -->
  <div class="tab-card">
    <div class="tabs-header">
     <!-- <div class="tab-item active" onclick="switchTab('items',this)"><i class="fa-solid fa-boxes-stacked"></i>Issued List<span class="tc" id="tc-items_">0</span></div>-->
	  <div class="tab-item active" onclick="switchTab('items_name',this)"><i class="fa-solid fa-boxes-stacked"></i>Issued List<span class="tc" id="tc-items">0</span></div>
	  <div class="tab-item" onclick="switchTab('products_view',this)"><i class="fa-solid fa-layer-group"></i>Products View<span class="tc" id="tc-products-count">0</span></div>
      <div class="tab-item" onclick="switchTab('expenses',this)"><i class="fa-solid fa-receipt"></i>Expenses<span class="tc" id="tc-expenses">0</span></div>
      <div class="tab-item" onclick="switchTab('payments',this)"><i class="fa-solid fa-money-bill-wave"></i>Invoice<span class="tc" id="tc-payments">0</span></div>
      <div class="tab-item" onclick="switchTab('activity',this)"><i class="fa-solid fa-clock-rotate-left"></i>Activity<span class="tc" id="tc-activity">0</span></div>
      <div class="tab-item" onclick="switchTab('notes',this)"><i class="fa-solid fa-note-sticky"></i>Notes<span class="tc" id="tc-notes">0</span></div>
    </div>
    <div class="tab-body">

    <!-- ISSUED List -->
    <div class="tab-pane" id="tab-items_name">
		<div class="tab-toolbar">
			<div class="sw">
				<i class="fa-solid fa-magnifying-glass"></i>
				<input type="text" placeholder="Search activities…" oninput="filterItemNames(this.value)">
			</div>
			
			<select class="fsel" id="f-iact" onchange="filterItemNames('')">
				<option value="">All Transactions</option>
			</select>
			
			<span class="rc" id="rc-items"></span>
			
			<div style="margin-left:auto; display:flex; gap:7px;">
				<button class="btn btn-teal btn-sm" onclick="redirectIssueItem()">
					<i class="fa-solid fa-boxes-stacked"></i>Issue Inventory Item
				</button>
			</div>
		</div>
		
		<div class="tbl-wrap">
			<table class="tbl">
				<thead>
					<tr>
						<th style="width: 15%;">Activity ID</th>
						<th class="r" style="width: 15%; padding-right: 20px;">Product Count</th>
						<th style="width: 15%;">Issued By</th>
						<th style="width: 20%;">Transaction Date</th>
						<th style="width: 35%;">Remarks / Notes</th>
					</tr>
				</thead>
				<tbody id="items-tbody">
				</tbody>
			</table>
		</div>
	</div>
	  
	<!-- Products list -->
    <div class="tab-pane" id="tab-products_view">
    <div class="tab-toolbar">
        <div class="sw">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search products..." oninput="filterProductsTab(this.value)">
        </div>
        <span class="rc" id="rc-products-total"></span>
    </div>
    
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width: 20%;">Product ID</th>
                    <th style="width: 45%;">Product Name</th>
                    <th class="r" style="width: 15%; padding-right: 20px;">Total Qty Issued</th>
                    <th class="r" style="width: 20%; padding-right: 20px;">Transactions Count</th>
                </tr>
            </thead>
            <tbody id="products-view-tbody">
                </tbody>
        </table>
    </div>
</div>

      <!-- EXPENSES -->
      <div class="tab-pane" id="tab-expenses">
        <div class="tab-toolbar">
          <div class="sw"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Search expenses…" oninput="filterExpenses(this.value)"></div>
          <select class="fsel" id="f-ecat" onchange="filterExpenses('')"><option value="">All Categories</option></select>
          <span class="rc" id="rc-expenses"></span>
          <div style="margin-left:auto;">
            <button class="btn btn-primary btn-sm" onclick="openExpenseModal()"><i class="fa-solid fa-plus"></i>Add Expense</button>
          </div>
        </div>
        <div class="tbl-wrap"><table class="tbl">
			<thead>
				<tr>
				  <th>Date</th>
				  <th>Ref</th>
				  <th>Category</th>
				  <th>Type</th>
				  <th>Description</th>
				  <th>Account</th>
				  <th class="r">Qty</th>
				  <th class="r">Amount</th>
				  <th class="r">Total</th>
				  <th style="text-align:center">Del</th>
				</tr>
			</thead>
          <tbody id="expenses-tbody"></tbody>
        </table></div>
      </div>


		
		<!-- PAYMENTS (INVOICE)-->
		<div class="tab-pane" id="tab-payments">
			<div class="tab-toolbar">
			  <div class="sw"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Search payments…" oninput="filterPayments(this.value)"></div>
			  <select class="fsel" id="f-pmethod" onchange="filterPayments('')"><option value="">All Methods</option></select>
			  <span class="rc" id="rc-payments"></span>
			  <div style="margin-left:auto;">
				<button class="btn btn-success btn-sm" onclick="openInvoiceModal(PROJECT.id, loadProjectInvoices)"><i class="fa-solid fa-plus"></i>Invoice</button>
			  </div>
			</div>
			<div class="tbl-wrap">
				<table class="tbl">
					<thead>
						<tr>
							<th>Invoice Date</th>
							<th>Invoice No</th>
							<th>Due Date</th>
							<th class="r">Total Items</th>
							<th class="r">Total Qty</th>
							<th class="r">Grand Total</th>
							<!--<th class="r">Paid Amount</th>
							<th class="r">Balance</th>-->
							<th style="text-align:center">Action</th>
						</tr>
					</thead>
					<tbody id="payments-tbody"></tbody>
				</table>
			</div>
		</div>












		

		<!--newly added  Invoice Modal Start-->
		<!--<div class="modal fade" id="invoiceModal" tabindex="-1">
		  <div class="modal-dialog modal-xl">
			<div class="modal-content siv-modal">
			  <div class="modal-header siv-modal-header">
				<h5 class="modal-title">New Project Invoice</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			  </div>

			  <div class="modal-body siv-modal-body">
				<form id="invoiceForm" novalidate>

				  <div class="siv-card">
					<div class="siv-card-head" style="display:none;"><i class="fa-solid fa-file-invoice siv-icon"></i>Invoice Details</div>
					<div class="siv-card-head">
					  <span><i class="fa-solid fa-file-invoice siv-icon"></i> Invoice Details</span>
					  
					</div>
					
					<div class="siv-card-body">
					  <div class="siv-row">
						<div class="siv-field">
						  <label>Invoice Date <span class="req">*</span></label>
						  <input type="date" id="inv-date" class="siv-input" required>
						  <span class="siv-error" id="err-date"></span>
						</div>
						<div class="siv-field">
						  <label>Due Date</label>
						  <input type="date" id="inv-due-date" class="siv-input" value="<?= date('Y-m-d', strtotime('+2 weeks'));?>">	
						</div>
					  </div>
					  
					  <div class="siv-field">
						 <label>Notes</label>
						<textarea id="inv-notes" class="siv-input" rows="3" placeholder="Optional notes..."></textarea>
					  </div>
					  
					  <div class="siv-row" style="display:none;">
						<div class="siv-field">
						  <label>Paid Amount</label>
						  <div class="siv-prefix-input">
							<span>Rs.</span>
							<input type="number" id="inv-paid" class="siv-input" value="0" step="0.01" min="0">
						  </div>
						  <span class="siv-error" id="err-paid"></span>
						</div>
						<div class="siv-field"></div>
					  </div>
					</div>
				  </div>

				  <div class="siv-card">
					<div class="siv-card-head">
					  <span><i class="fa-solid fa-cart-shopping siv-icon"></i> Add Items</span>
					  <span class="siv-badge" id="sum-items-badge">0 items</span>
					</div>
					<div class="siv-card-body">
					  <div class="siv-additem-row">
						<div class="siv-field grow">
						  <label>Search Item (Name / Code)</label>
						  <select id="inv-product-select" class="siv-input"><option value="">Type to search...</option></select>
						</div>
						<div class="siv-field small">
						  <label>Unit Price</label>
						  <div class="siv-prefix-input">
							<span>Rs.</span>
							<input type="number" id="inv-add-price" class="siv-input" value="0" step="0.01">
						  </div>
						</div>
						<div class="siv-field xsmall">
						  <label>Qty</label>
						  <input type="number" id="inv-add-qty" class="siv-input" value="1" min="0.01" step="0.01">
						</div>
						<div class="siv-field small">
						  <label>Discount</label>
						  <div class="siv-prefix-input">
							<span>Rs.</span>
							<input type="number" id="inv-add-discount" class="siv-input" value="0" min="0" step="0.01">
						  </div>
						</div>
						<button type="button" class="siv-btn siv-btn-primary siv-add-btn" onclick="addInvoiceItem()"><i class="fa-solid fa-plus"></i> Add</button>
					  </div>
					  <span class="siv-error" id="err-items"></span>

					  <table class="siv-table">
						<thead>
						  <tr>
							<th>#</th><th>Item</th><th>Code</th><th class="r">Price</th><th class="r">Qty</th>
							<th class="r">Discount</th><th class="r">Line Total</th><th></th>
						  </tr>
						</thead>
						<tbody id="inv-items-tbody"></tbody>
					  </table>

					  <div class="siv-empty" id="inv-empty-state">
						<i class="fa-solid fa-cart-shopping"></i>
						<p>No items added yet. Search and add products above.</p>
					  </div>
					</div>
				  </div>
					
					<div class="siv-row">
					  <div class="siv-field">
						<label>Invoice Discount</label>
						<div class="siv-prefix-input">
						  <span>Rs.</span>
						  <input type="number" id="inv-invoice-discount" class="siv-input" value="0" step="0.01" min="0">
						</div>
						<span class="siv-error" id="err-inv-discount"></span>
					  </div>
					  <div class="siv-field"></div>
					</div>
					
					<div class="siv-summary-bar">
					  <div class="siv-summary-item">
						<span class="siv-summary-label">Total Items</span>
						<b id="sum-items">0</b>
					  </div>
					  <div class="siv-summary-divider"></div>
					  <div class="siv-summary-item">
						<span class="siv-summary-label">Total Qty</span>
						<b id="sum-qty">0</b>
					  </div>
					  <div class="siv-summary-divider"></div>
					  <div class="siv-summary-item">
						<span class="siv-summary-label">Line Discount</span>
						<b class="neg" id="sum-discount">Rs. 0.00</b>
					  </div>
					  <div class="siv-summary-divider"></div>
					  <div class="siv-summary-item">
						<span class="siv-summary-label">Sub Total</span>
						<b id="sum-subtotal">Rs. 0.00</b>
					  </div>
					  <div class="siv-summary-divider"></div>
					  <div class="siv-summary-item">
						<span class="siv-summary-label">Invoice Discount</span>
						<b class="neg" id="sum-invoice-discount">Rs. 0.00</b>
					  </div>
					  <div class="siv-summary-divider"></div>
					  <div class="siv-summary-item">
						<span class="siv-summary-label">Paid Amount</span>
						<b id="sum-paid">Rs. 0.00</b>
					  </div>
					  <div class="siv-summary-divider"></div>
					  <div class="siv-summary-item siv-summary-grand">
						<span class="siv-summary-label">Grand Total</span>
						<b id="sum-grand">Rs. 0.00</b>
					  </div>
					</div>

				</form>
			  </div>

			  <div class="modal-footer siv-modal-footer">
				<button type="button" class="siv-btn siv-btn-outline" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="siv-btn siv-btn-primary siv-btn-save" onclick="saveInvoice()"><i class="fa-solid fa-floppy-disk"></i> Save Invoice</button>
			  </div>
			</div>
		  </div>
		</div>-->
		
		<!-- New Project Invoice Modal -->
		<div class="modal fade" id="invoiceModal" tabindex="-1">
			<div class="modal-dialog modal-xl">
				<div class="modal-content siv-modal">

					<div class="modal-header siv-modal-header">
						<h5 class="modal-title">
							<i class="fa-solid fa-file-invoice me-2"></i>
							New Project Invoice
						</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>

					<div class="modal-body siv-modal-body">
						<form id="invoiceForm" novalidate>
							<!-- =====================================================
								 INVOICE DETAILS
							====================================================== -->
							<div class="siv-card">
								<div class="siv-card-head">
									<span>
										<i class="fa-solid fa-file-invoice siv-icon"></i>
										Invoice Details
									</span>
								</div>
								<div class="siv-card-body">
									<div class="siv-row">
										<div class="siv-field">
											<label>Invoice Date<span class="req">*</span></label>
											<input type="date" id="inv-date" class="siv-input" value="<?= date('Y-m-d'); ?>" required>
											<span class="siv-error" id="err-date"></span>
										</div>

										<div class="siv-field">
											<label>Due Date</label>
											<input type="date" id="inv-due-date" class="siv-input" value="<?= date('Y-m-d', strtotime('+2 weeks')); ?>">
										</div>
										
										<div class="siv-field">
											<label>Customer <span class="req">*</span></label>
											<select class="fc" id="cust-sel" required>
												<option>- Select Customer -</option>
												<?php
													foreach($customers as $item){
														echo"<option value='$item->cus_id'>$item->cus_name</option>";
													}
												?>
											</select>
										</div>
									</div>
									<div class="siv-field">
										<label>Notes</label>
										<textarea id="inv-notes" class="siv-input" rows="3" placeholder="Optional notes..."></textarea>
									</div>
								</div>
							</div>

							<!-- =====================================================
								 ADD ITEMS
							====================================================== -->

							<div class="siv-card">
								<div class="siv-card-head">
									<span><i class="fa-solid fa-cart-shopping siv-icon"></i>Add Items</span>
									<span class="siv-badge" id="sum-items-badge">0 items</span>
								</div>
								<div class="siv-card-body">
									<div class="siv-additem-row">
										<div class="siv-field grow">
											<label>Search Item (Name / Code)</label>
											<select id="inv-product-select" class="siv-input">
												<option value="">Type to search...</option>
											</select>
										</div>

										<div class="siv-field small">
											<label>Unit Price</label>
											<div class="siv-prefix-input">
												<span>Rs.</span>
												<input type="number" id="inv-add-price" class="siv-input" value="0" step="0.01" min="0">
											</div>

										</div>

										<div class="siv-field xsmall">
											<label>Qty</label>
											<input type="number" id="inv-add-qty" class="siv-input" value="1" min="0.01" step="0.01">
										</div>

										<div class="siv-field small">
											<label>Discount</label>
											<div class="siv-prefix-input">
												<span>Rs.</span>
												<input type="number" id="inv-add-discount" class="siv-input" value="0" min="0" step="0.01">
											</div>
										</div>
										
										<button type="button" class="siv-btn siv-btn-primary siv-add-btn" onclick="addInvoiceItem()"><i class="fa-solid fa-plus"></i>Add</button>
									</div>

									<span class="siv-error" id="err-items"></span>

									<table class="siv-table">
										<thead>
											<tr>
												<th>#</th>
												<th>Item</th>
												<th>Code</th>
												<th class="r">Price</th>
												<th class="r">Qty</th>
												<th class="r">Discount</th>
												<th class="r">Line Total</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="inv-items-tbody"></tbody>
									</table>

									<div class="siv-empty" id="inv-empty-state">
										<i class="fa-solid fa-cart-shopping"></i>
										<p> No items added yet. Search and add products above.</p>
									</div>
								</div>
							</div>
							
							


							<!-- =====================================================
								 PAYMENT SECTION
							====================================================== -->
							<div class="siv-card">
								<div class="siv-card-head">
									<span><i class="fa-solid fa-money-bill-wave siv-icon"></i>Payments</span>
									<span class="siv-badge"id="inv-payment-status-badge">Unpaid</span>
								</div>
								
								<div class="siv-card-body">
									<!-- Payment rows -->
									<div id="invoicePaymentsContainer"></div>
									<span class="siv-error" id="err-payments"></span>
									<!-- Add payment button -->
									<div style="margin-top:15px;">
										<button type="button" class="siv-btn siv-btn-outline" onclick="addInvoicePaymentRow()"><i class="fa-solid fa-plus"></i>Add Payment Method</button>
									</div>
									<br>
			
									<!-- =====================================================
										 INVOICE DISCOUNT
									====================================================== -->
									<div class="siv-row">
										<div class="siv-field">
											<label>Invoice Discount</label>
											<div class="siv-prefix-input">
												<span>Rs.</span>
												<input type="number" id="inv-invoice-discount" class="siv-input" value="0" step="0.01" min="0">
											</div>
											<span class="siv-error" id="err-inv-discount"></span>
										</div>
										<div class="siv-field"></div>
									</div>

									<!-- Payment summary -->
									<div class="siv-payment-summary">
										<div>
											<span>Total Due</span>
											<strong id="payment-total-due">
												Rs. 0.00
											</strong>
										</div>

										<div>
											<span>Total Paid</span>
											<strong id="payment-total-paid">
												Rs. 0.00
											</strong>
										</div>

										<div>
											<span>Balance</span>
											<strong id="payment-total-balance">
												Rs. 0.00
											</strong>
										</div>
									</div>
								</div>
							</div>

							<!-- =====================================================
								 SUMMARY
							====================================================== -->

							<div class="siv-summary-bar">
								<div class="siv-summary-item">
									<span class="siv-summary-label">
										Total Items
									</span>
									<b id="sum-items">0</b>
								</div>


								<div class="siv-summary-divider"></div>
									<div class="siv-summary-item">

										<span class="siv-summary-label">
											Total Qty
										</span>

										<b id="sum-qty">0</b>
									</div>

								<div class="siv-summary-divider"></div>

								<div class="siv-summary-item">
									<span class="siv-summary-label"> Line Discount </span>
									<b class="neg" id="sum-discount"> Rs. 0.00 </b>
								</div>

								<div class="siv-summary-divider"></div>
								<div class="siv-summary-item">
									<span class="siv-summary-label">Sub Total</span>
									<b id="sum-subtotal">Rs. 0.00</b>
								</div>


								<div class="siv-summary-divider"></div>
								<div class="siv-summary-item">
									<span class="siv-summary-label">
										Invoice Discount
									</span>
									<b class="neg"
									   id="sum-invoice-discount">
										Rs. 0.00
									</b>
								</div>


								<div class="siv-summary-divider"></div>
									<div class="siv-summary-item">
										<span class="siv-summary-label">
											Paid Amount
										</span>
										<b id="sum-paid">
											Rs. 0.00
										</b>
									</div>


									<div class="siv-summary-divider"></div>


								<div class="siv-summary-item siv-summary-grand">

									<span class="siv-summary-label">
										Grand Total
									</span>

									<b id="sum-grand">
										Rs. 0.00
									</b>

								</div>
							</div>
						</form>
					</div>

					<div class="modal-footer siv-modal-footer">
						<button type="button" class="siv-btn siv-btn-outline" data-bs-dismiss="modal">Cancel </button>
						<button type="button" class="siv-btn siv-btn-primary siv-btn-save" onclick="saveInvoice()"><i class="fa-solid fa-floppy-disk"></i>Save Invoice</button>
					</div>
				</div>
			</div>
		</div>

		<!-- View Invoice Modal -->
		<div class="modal fade" id="viewInvoiceModal" tabindex="-1">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content siv-modal">
			  <div class="modal-header siv-modal-header">
				<h5 class="modal-title">Invoice Details</h5>
				<div>
				  <button class="siv-btn siv-btn-outline" onclick="printCurrentInvoice()"><i class="fa-solid fa-print"></i> Print</button>
				  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
			  </div>
			  <div class="modal-body siv-modal-body" id="view-invoice-body"></div>
			</div>
		  </div>
		</div>
		<!--newly added  Invoice Modal Start-->
		
		









      <!-- ACTIVITY -->
      <div class="tab-pane" id="tab-activity">
        <div class="tab-toolbar">
          <div class="sw"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Search activity…" oninput="filterActivity(this.value)"></div>
          <select class="fsel" id="f-atype" onchange="filterActivity('')"><option value="">All Types</option></select>
          <span class="rc" id="rc-activity"></span>
        </div>
        <div class="act-list" id="act-list"></div>
      </div>

      <!-- NOTES -->
      <div class="tab-pane" id="tab-notes">
        <div id="notes-list"></div>
        <div class="add-note-area">
          <label class="form-lbl">Add a Note</label>
          <textarea class="fc" id="new-note-text" rows="3" placeholder="Type your note here…" style="margin-bottom:8px;"></textarea>
          <button class="btn btn-primary btn-sm" onclick="addProjectNote()"><i class="fa-solid fa-plus"></i>Add Note</button>
        </div>
      </div>

    </div>
  </div>

</main>

<!-- ══════════════════════════════════
     NEW PAYMENT FULL SCREEN
══════════════════════════════════ -->
<div class="pay-screen" id="pay-screen">
  <div class="pay-screen-header">
    <div style="display:flex;align-items:center;gap:12px;">
      <button class="btn btn-outline btn-sm" onclick="closePayScreen()"><i class="fa-solid fa-arrow-left"></i>Back to Project</button>
      <h4><i class="fa-solid fa-money-bill-wave" style="color:var(--success);margin-right:7px;"></i>Record New Payment — PRJ-2026-014</h4>
    </div>
    <div style="font-size:12px;color:var(--text-muted);font-weight:600;" id="pay-screen-balance"></div>
  </div>
  <div class="pay-screen-body">

    <!-- Balance summary -->
    <div style="background:linear-gradient(135deg,#1a1f36,#2d3d80);border-radius:var(--r-lg);padding:20px 22px;margin-bottom:22px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
      <div><div style="font-size:10px;color:rgba(255,255,255,.5);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Contract Value</div><div style="font-size:18px;font-weight:800;color:#fff;font-family:'JetBrains Mono',monospace;">Rs. 4,500,000</div></div>
      <div><div style="font-size:10px;color:rgba(255,255,255,.5);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Total Received</div><div style="font-size:18px;font-weight:800;color:#6ee7b7;font-family:'JetBrains Mono',monospace;" id="ps-received">Rs. 0.00</div></div>
      <div><div style="font-size:10px;color:rgba(255,255,255,.5);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Balance Due</div><div style="font-size:18px;font-weight:800;color:#fbbf24;font-family:'JetBrains Mono',monospace;" id="ps-balance">Rs. 0.00</div></div>
    </div>

    <!-- Payment form -->
    <div style="background:#fff;border:1px solid var(--card-border);border-radius:var(--r-lg);padding:24px;box-shadow:var(--sh-sm);">
      <div style="font-size:15px;font-weight:800;color:var(--text-dark);margin-bottom:18px;display:flex;align-items:center;gap:8px;"><i class="fa-solid fa-receipt" style="color:var(--primary);"></i>Payment Details</div>
      <div class="g2">
        <div class="form-row">
          <label class="form-lbl">Receipt / Reference No.</label>
          <input type="text" class="fc" id="ps-ref" placeholder="e.g. PAY-004">
        </div>
        <div class="form-row">
          <label class="form-lbl">Payment Date <span>*</span></label>
          <input type="date" class="fc" id="ps-date">
          <div class="err" id="err-ps-date">Select a date.</div>
        </div>
      </div>
      <div class="g2">
        <div class="form-row">
          <label class="form-lbl">Amount <span>*</span></label>
          <div class="ig"><span class="ipfx">Rs.</span><input type="number" class="fc" id="ps-amount" placeholder="0.00" step="0.01" oninput="updatePayScreenBalance()"></div>
          <div class="err" id="err-ps-amount">Enter a valid amount.</div>
        </div>
        <div class="form-row">
          <label class="form-lbl">Payment Method <span>*</span></label>
          <select class="fc" id="ps-method">
            <option value="">— Select Method —</option>
            <option>Bank Transfer</option>
            <option>Cheque</option>
            <option>Cash</option>
            <option>Card</option>
          </select>
          <div class="err" id="err-ps-method">Select a method.</div>
        </div>
      </div>
      <!-- Cheque details (shown when Cheque selected) -->
      <div id="ps-cheque-details" style="display:none;background:var(--warning-light);border:1.5px solid #fde68a;border-radius:var(--r-sm);padding:12px 14px;margin-bottom:14px;">
        <div class="g3">
          <div class="form-row" style="margin-bottom:0;">
            <label class="form-lbl">Cheque No.</label>
            <input type="text" class="fc" id="ps-chq-no" placeholder="Cheque number">
          </div>
          <div class="form-row" style="margin-bottom:0;">
            <label class="form-lbl">Bank</label>
            <input type="text" class="fc" id="ps-chq-bank" placeholder="Bank name">
          </div>
          <div class="form-row" style="margin-bottom:0;">
            <label class="form-lbl">Cheque Date</label>
            <input type="date" class="fc" id="ps-chq-date">
          </div>
        </div>
      </div>
      <div class="form-row">
        <label class="form-lbl">Note</label>
        <textarea class="fc" id="ps-note" rows="2" placeholder="Payment details, milestone reference…"></textarea>
      </div>
      <!-- Running total preview -->
      <div style="background:var(--success-light);border:1.5px solid #6ee7b7;border-radius:var(--r-sm);padding:12px 16px;display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
        <span style="font-size:13px;font-weight:700;color:var(--success-d);">New Running Total After This Payment</span>
        <span style="font-size:18px;font-weight:800;color:var(--success-d);font-family:'JetBrains Mono',monospace;" id="ps-running-total">Rs. 0.00</span>
      </div>
      <div style="display:flex;justify-content:flex-end;gap:8px;">
        <button class="btn btn-outline btn-sm" onclick="closePayScreen()">Cancel</button>
        <button class="btn btn-success" onclick="savePayment()"><i class="fa-solid fa-check"></i>Save Payment</button>
      </div>
    </div>

  </div>
</div>




<div id="toast-c"></div>
<?php $this->load->view('crm/expense/expenceModal'); ?>
<?php //$this->load->view('crm/projects/projectInvoiceModal'); ?>
<script>
/* ═══════════════════ MASTER DATA ═══════════════════ */
var rawServerId = '<?= !empty($selected_project_id) ? $selected_project_id : "" ?>';

if (!rawServerId || rawServerId.trim() === "") {
    /*var urlSegments = window.location.pathname.split('/');
    var lastSegment = urlSegments.pop() || urlSegments.pop(); 
    if (!isNaN(lastSegment) && lastSegment !== "") {
        rawServerId = lastSegment;
    }*/
	
	var urlParams = new URLSearchParams(window.location.search);
	var rawServerId = urlParams.get('project_id');
}

var PROJECT = {
    id: rawServerId,
    budget: 4500000 
};

// 🎯 Both global collections start completely empty now
var ISSUED_ITEMS = []; 
var EXPENSES = []; 

/* ─── LIFE CYCLE ENTRY ─── */
$(function(){
    $('#m-date').val(new Date().toISOString().split('T')[0]);
    $('#ps-date').val(new Date().toISOString().split('T')[0]);
    
    // 🚀 Trigger both live dataset loaders on boot
    loadProjectDashboardData();
});

/**
 * Orchestrates multiple data streams and handles UI paint triggers safely
 */
function loadProjectDashboardData() {
    if (!PROJECT.id) {
        console.warn("Dashboard sync paused: No project identifier scope.");
        return;
    }

    // Run both AJAX calls asynchronously. Once both return, render the visual metrics.
    $.when(loadIssuedItems(), fetchExpenses()).done(function() {
        console.log("All data channels synchronized successfully. Rendering UI...");
        renderKPIs(); 
        renderCharts(); 
        renderAll();
    });
}

let TOTAL_ISSUED_INVENTORY_COST = 0;
let PRODUCT_BASE_ITEMS = [];
var PAYMENTS = [];
var ACTIVITY = [];
var NOTES = [];
var EXP_FAMILIES=[];

var EXP_CATS={
  operational:[{id:'rent',label:'Rent & Premises',types:['Office Rent','Warehouse Rent']},{id:'maint',label:'Maintenance',types:['Equipment Repair','Cleaning']},{id:'supplies',label:'Office Supplies',types:['Stationery','Printing']}],
  payroll:[{id:'salaries',label:'Salaries',types:['Monthly Salary','Bonus']},{id:'epf',label:'EPF / ETF',types:['EPF Employer','ETF Employer']},{id:'allowances',label:'Allowances',types:['Transport','Meal']}],
  logistics:[{id:'fuel',label:'Fuel & Transport',types:['Fuel','Vehicle Hire']},{id:'courier',label:'Courier & Post',types:['Local Delivery','International']}],
  utilities:[{id:'electricity',label:'Electricity',types:['CEB Bill','Generator Fuel']},{id:'internet',label:'Internet & Phone',types:['Broadband','Mobile Data']}],
  marketing:[{id:'advertising',label:'Advertising',types:['Social Media','Print','Radio']}],
  other:[{id:'misc',label:'Miscellaneous',types:['Petty Cash','Other']},{id:'legal',label:'Legal & Compliance',types:['Audit Fees','Licenses']}],
};
var CAT_COLORS={operational:'#3d52a0',payroll:'#8b5cf6',logistics:'#f59e0b',utilities:'#0ea5e9',marketing:'#f43f5e',other:'#6b7280'};
var selFamily=null;

/* ─── INIT ─── */
$(function(){
  $('#m-date').val(new Date().toISOString().split('T')[0]);
  $('#ps-date').val(new Date().toISOString().split('T')[0]);
  renderKPIs(); renderCharts(); renderAll();
  //buildFamPills();
  $('#ps-method').on('change',function(){ $('#ps-cheque-details').toggle($(this).val()==='Cheque'); updatePayScreenBalance(); });
});

/* ─── KPIs ─── */
/*function getStats(){
  var totalExp   = EXPENSES.reduce(function(a,e){return a+e.qty*e.amount;},0);
  var totalInv   = ISSUED_ITEMS.reduce(function(a,i){return a+i.qty*i.unit_cost;},0);
  var totalPaid  = PAYMENTS.reduce(function(a,p){return a+p.amount;},0);
  var invUnits   = ISSUED_ITEMS.reduce(function(a,i){return a+i.qty;},0);
  var totalCost  = totalExp + totalInv;
  var budgetUsed = PROJECT.budget>0?((totalCost/PROJECT.budget)*100):0;
  var balance    = totalPaid - totalCost;
  return {totalExp,totalInv,totalPaid,invUnits,invLines:ISSUED_ITEMS.length,totalCost,budgetUsed,balance,
          expCount:EXPENSES.length,noteCount:NOTES.length,noteVal:totalExp};
}*/
function getStats() {
    var stats = {
        totalExp: 0,
        totalInv: 0,
        totalInvoice: 0, // Grand Billed Revenue
        totalPaid: 0,
        budgetUsed: 0,   // 🎯 FIXED: Added missing comma here
        totalBalance: 0
    };
	var budget = window.PROJECT_BUDGET || 0;

    // 1. Calculate Expenses Total
    if (typeof EXPENSES !== 'undefined' && Array.isArray(EXPENSES)) {
        EXPENSES.forEach(function(e) {
            var qty = parseFloat(e.qty || 1);
            var amount = parseFloat(e.amount || e.total_amount || 0);
            stats.totalExp += (qty * amount);
        });
    }

    // 2. Read inventory asset valuation from backend AJAX data payload state
    if (typeof TOTAL_ISSUED_INVENTORY_COST !== 'undefined') {
        stats.totalInv = parseFloat(TOTAL_ISSUED_INVENTORY_COST) || 0;
    } else if (typeof ISSUED_ITEMS !== 'undefined' && Array.isArray(ISSUED_ITEMS)) {
        ISSUED_ITEMS.forEach(function(i) {
            var qty = parseFloat(i.qty || 0);
            var cost = parseFloat(i.unit_cost || i.unit_price || i.unit_amount || 0);
            stats.totalInv += (qty * cost);
        });
    }

    // 3. 🎯 FIXED: Single loop configuration for Invoices to prevent duplicated totals
    if (typeof INVOICES !== 'undefined' && Array.isArray(INVOICES)) {
        INVOICES.forEach(function(inv) {
            stats.totalInvoice += parseFloat(inv.grand_total || 0); // Total amount invoiced
            stats.totalPaid += parseFloat(inv.paid_amount || 0);    // Total cash received
        });
    }

    // 4. Math Logic: Balance = Total Invoiced - Paid Amount
    stats.totalBalance = Math.max(0, stats.totalInvoice - stats.totalPaid);

    // 5. Calculate Budget Utilization Baseline
    var budget = 0;
    var $heroBudgetEl = $('#hero-budget-display'); 
    if ($heroBudgetEl.length) {
        budget = parseFloat($heroBudgetEl.text().replace(/[^0-9.]/g, '')) || 0;
    } else if (typeof PROJECT !== 'undefined' && PROJECT.budget) {
        var rawBudgetText = String(PROJECT.budget).replace(/[^0-9.]/g, '');
        budget = parseFloat(rawBudgetText) || 0;
    }

    // Math Logic: Total Cost = Expenses + Materials
    var totalCost = stats.totalExp + stats.totalInv;
    if (budget > 0) {
        stats.budgetUsed = (totalCost / budget) * 100;
    }

    return stats;
}
function renderKPIs(){
  var s = getStats();
  var bColor = s.budgetUsed>85?'var(--danger)':s.budgetUsed>65?'var(--warning)':'var(--success)';
  var bFill  = Math.min(s.budgetUsed,100).toFixed(1);
  var balColor = s.balance>=0?'var(--success)':'var(--danger)';

  $('#kpi-grid').html(
    // 1 Expenses
    '<div class="kpi-card k-exp">'
     +'<div class="kpi-icon" style="background:var(--danger-light);color:var(--danger);"><i class="fa-solid fa-receipt"></i></div>'
     +'<div class="kpi-main"><div class="kpi-val big">'+fmtK(s.totalExp)+'</div></div>'
     +'<div class="kpi-lbl">Total Expenses</div>'
     +'<div class="kpi-sub-row">'
       +'<div class="kpi-sub-item" style="background:var(--danger-light);color:var(--danger);"><i class="fa-solid fa-layer-group"></i>'+s.expCount+' entries</div>'
     +'</div>'
    +'</div>'+

    // 2 Inventory
    '<div class="kpi-card k-inv">'
     +'<div class="kpi-icon" style="background:var(--purple-light);color:var(--purple);"><i class="fa-solid fa-boxes-stacked"></i></div>'
     +'<div class="kpi-main"><div class="kpi-val big">'+fmtK(s.totalInv)+'</div></div>'
     +'<div class="kpi-lbl">Inventory Cost</div>'
     +'<div class="kpi-sub-row">'
       +'<div class="kpi-sub-item" style="background:var(--purple-light);color:var(--purple);"><i class="fa-solid fa-hashtag"></i>'+s.invUnits+' units</div>'
       +'<div class="kpi-sub-item" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-list"></i>'+s.invLines+' items</div>'
     +'</div>'
    +'</div>'+

    // 3 Payments
    '<div class="kpi-card k-pay">'
     +'<div class="kpi-icon" style="background:var(--success-light);color:var(--success);"><i class="fa-solid fa-money-bill-wave"></i></div>'
     +'<div class="kpi-main"><div class="kpi-val big">'+fmtK(s.totalPaid)+'</div></div>'
     +'<div class="kpi-lbl">Payments Received</div>'
     +'<div class="kpi-sub-row">'
       +'<div class="kpi-sub-item" style="background:var(--success-light);color:#065f46;"><i class="fa-solid fa-check"></i>'+PAYMENTS.length+' payments</div>'
     +'</div>'
    +'</div>'+

    // 4 Balance
    '<div class="kpi-card k-bal">'
     +'<div class="kpi-icon" style="background:var(--teal-light);color:var(--teal);"><i class="fa-solid fa-scale-balanced"></i></div>'
     +'<div class="kpi-main"><div class="kpi-val big" style="color:'+balColor+'">'+fmtK(Math.abs(s.balance))+'</div></div>'
     +'<div class="kpi-lbl">Client Balance</div>'
     +'<div class="kpi-sub-row">'
       +'<div class="kpi-sub-item" style="background:'+(s.balance>=0?'var(--success-light)':'var(--danger-light)')+';color:'+(s.balance>=0?'#065f46':'#991b1b')+';"><i class="fa-solid '+(s.balance>=0?'fa-arrow-up':'fa-arrow-down')+'"></i>'+(s.balance>=0?'Advance balance':'Amount owed')+'</div>'
     +'</div>'
    +'</div>'+

    // 5 Budget
    '<div class="kpi-card k-bud" style="grid-column:span 2;">'
     +'<div style="display:flex;align-items:flex-start;justify-content:space-between;">'
       +'<div>'
         +'<div class="kpi-icon" style="background:var(--warning-light);color:var(--warning);margin-bottom:8px;"><i class="fa-solid fa-chart-pie"></i></div>'
         +'<div class="kpi-val">'+s.budgetUsed.toFixed(1)+'%</div>'
         +'<div class="kpi-lbl">Budget Utilised</div>'
       +'</div>'
       +'<div style="text-align:right;">'
         +'<div style="font-size:11px;color:var(--text-muted);font-weight:600;margin-bottom:4px;">Remaining</div>'
         +'<div style="font-size:16px;font-weight:800;font-family:\'JetBrains Mono\',monospace;color:'+bColor+';">'+fmt(PROJECT.budget-s.totalCost)+'</div>'
         +'<div style="font-size:11px;color:var(--text-muted);margin-top:2px;">of Rs. '+fmtK(PROJECT.budget)+'</div>'
       +'</div>'
     +'</div>'
     +'<div class="bb-wrap" style="margin-top:8px;"><div class="bb-fill" style="width:'+bFill+'%;background:'+bColor+';"></div></div>'
    +'</div>'+

    // 6 Notes
    '<div class="kpi-card k-note">'
     +'<div class="kpi-icon" style="background:var(--orange-light);color:var(--orange);"><i class="fa-solid fa-note-sticky"></i></div>'
     +'<div class="kpi-main"><div class="kpi-val big">'+NOTES.length+'</div></div>'
     +'<div class="kpi-lbl">Project Notes</div>'
     +'<div class="kpi-sub-row">'
       +'<div class="kpi-sub-item" style="background:var(--orange-light);color:var(--orange);"><i class="fa-solid fa-file-lines"></i>'+ACTIVITY.length+' activity logs</div>'
     +'</div>'
    +'</div>'
  );
}


function renderCharts() {
    var s = getStats();
    
    // Pull the clean global budget value we cached from the hero data node
    var budget = window.PROJECT_BUDGET || 0;
    var totalCost = s.totalExp + s.totalInv;

    // ══════════════════════════════════════════════════════════════════
    // CHART 1: CLEAN TOTAL COST OVERVIEW
    // ══════════════════════════════════════════════════════════════════
    var expPct = totalCost > 0 ? ((s.totalExp / totalCost) * 100).toFixed(1) : 0;
    var invPct = totalCost > 0 ? ((s.totalInv / totalCost) * 100).toFixed(1) : 0;

    var svgCost = buildDonutSvg([
        { val: expPct, color: '#f97316', label: 'Expenses' },
        { val: invPct, color: '#8b5cf6', label: 'Issued Inventory' }
    ], fmt(totalCost), 'Total Cost');

    var chart1HTML = `
        <div class="cc-head">
            <div class="sec-icon" style="background:var(--danger-light);color:var(--danger);">
                <i class="fa-solid fa-calculator" style="font-size:11px;"></i>
            </div>
            <h6>Total Cost Summary</h6>
        </div>
        <div class="cc-body">
            <div style="display:flex; gap:16px; align-items:center;">
                ${svgCost}
                <div style="flex:1;">
                    ${miniBar('Total Project Cost', fmt(totalCost), '100', '#ef4444')}
                    ${miniBar('Direct Expenses (' + expPct + '%)', fmt(s.totalExp), expPct, '#f97316')}
                    ${miniBar('Issued Inventory (' + invPct + '%)', fmt(s.totalInv), invPct, '#8b5cf6')}
                </div>
            </div>
        </div>
    `;

    // ══════════════════════════════════════════════════════════════════
    // CHART 2: INVOICES & COLLECTIONS OVERVIEW
    // ══════════════════════════════════════════════════════════════════
    var paidPct = s.totalInvoice > 0 ? ((s.totalPaid / s.totalInvoice) * 100).toFixed(1) : 0;
    var balPct  = s.totalInvoice > 0 ? ((s.totalBalance / s.totalInvoice) * 100).toFixed(1) : 0;

    var svgInvoice = buildDonutSvg([
        { val: paidPct, color: '#10b981', label: 'Paid' },
        { val: balPct, color: '#ef4444', label: 'Balance Outstanding' }
    ], fmt(s.totalInvoice), 'Total Invoiced');

    var chart2HTML = `
        <div class="cc-head">
            <div class="sec-icon" style="background:var(--success-light);color:var(--success);">
                <i class="fa-solid fa-file-invoice-dollar" style="font-size:11px;"></i>
            </div>
            <h6>Invoice & Collections</h6>
        </div>
        <div class="cc-body">
            <div style="display:flex; gap:16px; align-items:center;">
                ${svgInvoice}
                <div style="flex:1;">
                    ${miniBar('Total Invoices', fmt(s.totalInvoice), '100', '#10b981')}
                    ${miniBar('Paid Invoices (' + paidPct + '%)', fmt(s.totalPaid), paidPct, '#10b981')}
                    ${miniBar('Balance Invoices (' + balPct + '%)', fmt(s.totalBalance), balPct, '#ef4444')}
                </div>
            </div>
        </div>
    `;

    // ══════════════════════════════════════════════════════════════════
    // CHART 3: 🎯 NEW ESTIMATED BUDGET VS TOTAL COST VARIANCE
    // ══════════════════════════════════════════════════════════════════
    var variancePct = 0;
    var statusColor = '#10b981'; // Default Green
    
    if (totalCost > 0) {
        variancePct = parseFloat(((budget / totalCost) * 100) - 100);
    } else if (budget > 0 && totalCost === 0) {
        // Budget exists but nothing spent yet means 100% savings potential margin
        variancePct = 100;
    }

    // 🎯 Color Logic Shift: If variance is below zero, switch color theme to Red
    if (variancePct < 0) {
        statusColor = '#ef4444'; 
    }

    // Prepare display labels
    var formattedVariance = (variancePct >= 0 ? '+' : '') + variancePct.toFixed(1) + '%';
    var absVariancePct = Math.min(100, Math.abs(variancePct)); // Cap visual fill representation at 100%

    // Build the variance donut presentation ring
    var svgVariance = buildDonutSvg([
        { val: absVariancePct, color: statusColor, label: 'Variance Margin' },
        { val: Math.max(0, 100 - absVariancePct), color: '#e8ecf4', label: 'Scale Reference' }
    ], formattedVariance, 'Budget Variance');

    var chart3HTML = `
        <div class="cc-head">
            <div class="sec-icon" style="background:var(--primary-light);color:var(--primary);">
                <i class="fa-solid fa-scale-balanced" style="font-size:11px;"></i>
            </div>
            <h6>Budget vs Cost Variance</h6>
        </div>
        <div class="cc-body">
            <div style="display:flex; gap:16px; align-items:center;">
                ${svgVariance}
                <div style="flex:1;">
                    ${miniBar('Estimated Budget', fmt(budget), '100', '#3d52a0')}
                    ${miniBar('Total Accrued Cost', fmt(totalCost), '100', '#64748b')}
                    
                    <div style="margin-top: 8px; padding-top: 6px; border-top: 1px dashed #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:11px; font-weight:600; color:var(--text-muted);">Status Assessment:</span>
                        <span style="font-size:11px; font-weight:700; color:${statusColor}; text-transform:uppercase;">
                            ${variancePct >= 0 ? '<i class="fa-solid fa-circle-check"></i> Within Budget' : '<i class="fa-solid fa-triangle-exclamation"></i> Budget Blown'}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    `;

    // 4. Inject all 3 finalized dynamic blocks into your interface DOM grid row
    $('#charts-row').html(
        '<div class="chart-card">' + chart1HTML + '</div>' +
        '<div class="chart-card">' + chart2HTML + '</div>' +
        '<div class="chart-card">' + chart3HTML + '</div>'
    );
}
function miniBar(label,val,pct,color){
  return '<div class="mini-bar-row">'
    +'<div class="mini-bar-lbl"><span class="mini-bar-name">'+label+'</span><span class="mini-bar-val">'+val+'</span></div>'
    +'<div class="mini-track"><div class="mini-fill" style="width:'+pct+'%;background:'+color+';"></div></div>'
    +'</div>';
}

function buildDonutSvg(segments, center, sub){
  var r=38,cx=50,cy=50,stroke=10;
  var circ=2*Math.PI*r;
  var offset=0;
  var paths=segments.map(function(s){
    var dash=(s.val/100)*circ;
    var path='<circle cx="'+cx+'" cy="'+cy+'" r="'+r+'" fill="none" stroke="'+s.color+'" stroke-width="'+stroke+'"'
      +' stroke-dasharray="'+dash.toFixed(2)+' '+circ+'" stroke-dashoffset="-'+offset.toFixed(2)+'" stroke-linecap="round"/>';
    offset += dash;
    return path;
  }).join('');
  return '<svg viewBox="0 0 100 100" width="90" height="90" style="flex-shrink:0;transform:rotate(-90deg);">'
    +paths
    +'<text x="50" y="48" text-anchor="middle" dominant-baseline="middle" font-size="14" font-weight="800" fill="var(--text-dark)" transform="rotate(90,50,50)">'+center+'</text>'
    +'<text x="50" y="62" text-anchor="middle" dominant-baseline="middle" font-size="8" fill="var(--text-muted)" transform="rotate(90,50,50)">'+sub+'</text>'
    +'</svg>';
}

/* ─── RENDER ALL ─── */
//function renderAll(){ renderItems(); renderExpenses(); renderPayments(); renderActivity(); renderNotes(); updateCounts(); }
function renderAll() {
    let rows = '';
    const $tbody = $('#items-tbody');

    if (ISSUED_ITEMS.length === 0) {
        $tbody.html('<tr><td colspan="6" style="text-align:center;" class="text-muted">No issued stock items recorded for this project.</td></tr>');
        return;
    }

    ISSUED_ITEMS.forEach(item => {
        rows += `
            <tr>
                <td style="font-size:12px; color:var(--text-muted);">${item.product_id}</td>
                <td class="r" style="font-size:12px; color:var(--text-muted);">${item.qty}</td>
                <td style="font-size:12px; color:var(--text-muted);">${item.batch_id ? item.batch_id : '—'}</td>
                <td style="font-size:12px; color:var(--text-muted);">${item.serial ? item.serial : '—'}</td>
                <td style="font-size:12px; color:var(--text-muted);">${item.created_at}</td>
                <td style="text-align:center">
                    <button type="button" class="del-btn" onclick="deleteStockItem(${item.id})">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    $tbody.html(rows);
}
/* ─── ITEMS ─── */
function renderItems(q,cat){
  q=(q||'').toLowerCase(); cat=cat||$('#f-icat').val();
  var cats={},rows=ISSUED_ITEMS.filter(function(i){cats[i.cat]=1;if(cat&&i.cat!==cat)return false;if(q&&!i.name.toLowerCase().includes(q)&&!i.code.toLowerCase().includes(q))return false;return true;});
  $('#f-icat').html('<option value="">All Categories</option>'+Object.keys(cats).sort().map(function(c){return '<option value="'+c+'"'+(c===cat?'selected':'')+'>'+c+'</option>';}).join(''));
  $('#rc-items').text(rows.length+' record'+(rows.length!==1?'s':''));
  if(!rows.length){$('#items-tbody').html('<tr><td colspan="9"><div class="empty-state"><i class="fa-solid fa-boxes-stacked"></i><p>No items found.</p></div></td></tr>');return;}
  $('#items-tbody').html(rows.map(function(i){
    var total=i.qty*i.unit_cost;
    return '<tr><td><span class="mono" style="font-size:11px;color:var(--primary);">'+i.code+'</span></td><td style="font-weight:600;">'+i.name+'</td><td><span class="badge b-pri">'+i.cat+'</span></td><td class="r mono fw-700">'+i.qty+'</td><td class="r mono">'+fmt(i.unit_cost)+'</td><td class="r"><strong class="mono">'+fmt(total)+'</strong></td><td style="font-size:12px;color:var(--text-muted);">'+i.issued_by+'</td><td style="font-size:12px;color:var(--text-muted);">'+i.date+'</td><td style="text-align:center;"><button class="del-btn" onclick="delItem('+i.id+')"><i class="fa-solid fa-xmark"></i></button></td></tr>';
  }).join(''));
}
function filterItems(q){renderItems(q,$('#f-icat').val());}
function delItem(id){if(!confirm('Remove this item?'))return;ISSUED_ITEMS=ISSUED_ITEMS.filter(function(i){return i.id!==id;});renderAll();renderKPIs();renderCharts();logAct('item','#3d52a0','Item removed from project','Admin');toast('Item removed','w');}

/* ─── EXPENSES ─── */
/*function renderExpenses(q,cat){
  q=(q||'').toLowerCase();cat=cat||$('#f-ecat').val();
  var cats={},rows=EXPENSES.filter(function(e){cats[e.cat]=1;if(cat&&e.cat!==cat)return false;if(q&&!e.cat.toLowerCase().includes(q)&&!e.type.toLowerCase().includes(q)&&!e.note.toLowerCase().includes(q)&&!e.ref.toLowerCase().includes(q))return false;return true;});
  $('#f-ecat').html('<option value="">All Categories</option>'+Object.keys(cats).sort().map(function(c){return '<option value="'+c+'"'+(c===cat?'selected':'')+'>'+c+'</option>';}).join(''));
  $('#rc-expenses').text(rows.length+' record'+(rows.length!==1?'s':''));
  if(!rows.length){$('#expenses-tbody').html('<tr><td colspan="10"><div class="empty-state"><i class="fa-solid fa-receipt"></i><p>No expenses.</p></div></td></tr>');return;}
  $('#expenses-tbody').html(rows.map(function(e){
    var total=e.qty*e.amount,color=CAT_COLORS[e.family]||'#aaa';
    return '<tr><td style="font-size:12px;color:var(--text-muted);">'+e.date+'</td><td><span class="mono" style="font-size:11px;color:var(--text-muted);">'+e.ref+'</span></td><td><span class="badge" style="background:'+color+'18;color:'+color+'"><i class="fa-solid fa-circle" style="font-size:6px;"></i>'+e.cat+'</span></td><td><span class="badge b-pri">'+e.type+'</span></td><td style="font-size:12px;max-width:130px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="'+e.note+'">'+e.note+'</td><td style="font-size:12px;color:var(--text-muted);">'+e.account+'</td><td class="r mono" style="font-size:12px;">'+e.qty+'</td><td class="r mono" style="font-size:12px;">'+fmt(e.amount)+'</td><td class="r"><strong class="mono">'+fmt(total)+'</strong></td><td style="text-align:center;"><button class="del-btn" onclick="delExpense('+e.id+')"><i class="fa-solid fa-xmark"></i></button></td></tr>';
  }).join(''));
}*/
function filterExpenses(q){renderExpenses(q,$('#f-ecat').val());}
function delExpense(id){if(!confirm('Delete this expense?'))return;EXPENSES=EXPENSES.filter(function(e){return e.id!==id;});renderAll();renderKPIs();renderCharts();logAct('expense','#ef4444','Expense deleted','Admin');toast('Expense deleted','w');}



/* ─── PAYMENTS (INVOICE)─── */
/*
function renderPayments(q,method){
  q=(q||'').toLowerCase();method=method||$('#f-pmethod').val();
  var methods={},rows=PAYMENTS.filter(function(p){methods[p.method]=1;if(method&&p.method!==method)return false;if(q&&!p.note.toLowerCase().includes(q)&&!p.ref.toLowerCase().includes(q))return false;return true;});
  $('#f-pmethod').html('<option value="">All Methods</option>'+Object.keys(methods).sort().map(function(m){return '<option value="'+m+'"'+(m===method?'selected':'')+'>'+m+'</option>';}).join(''));
  $('#rc-payments').text(rows.length+' payment'+(rows.length!==1?'s':''));
  if(!rows.length){$('#payments-tbody').html('<tr><td colspan="600"><div class="empty-state"><i class="fa-solid fa-money-bill-wave"></i><p>No payments.</p></div></td></tr>');return;}
  var mc={'Bank Transfer':'b-suc','Cheque':'b-warn','Cash':'b-teal','Card':'b-info','Credit':'b-dan'};
  $('#payments-tbody').html(rows.map(function(p){
    return '<tr><td style="font-size:12px;color:var(--text-muted);">'+p.date+'</td><td><span class="mono" style="font-size:11px;font-weight:600;color:var(--primary);">'+p.ref+'</span></td><td><span class="badge '+(mc[p.method]||'b-pri')+'">'+p.method+'</span></td><td style="font-size:12px;">'+p.note+'</td><td class="r"><strong class="mono" style="color:var(--success);">'+fmt(p.amount)+'</strong></td><td style="text-align:center;"><button class="del-btn" onclick="delPayment('+p.id+')"><i class="fa-solid fa-xmark"></i></button></td></tr>';
  }).join(''));
}
function filterPayments(q){renderPayments(q,$('#f-pmethod').val());}
function delPayment(id){if(!confirm('Delete this payment?'))return;PAYMENTS=PAYMENTS.filter(function(p){return p.id!==id;});renderAll();renderKPIs();renderCharts();logAct('payment','#10b981','Payment deleted','Admin');toast('Payment deleted','w');}
*/
/* ─── PAYMENTS (INVOICE)─── */



/* ─── ACTIVITY ─── */
function renderActivity(q,type){
  q=(q||'').toLowerCase();type=type||$('#f-atype').val();
  var types={},rows=ACTIVITY.filter(function(a){types[a.type]=1;if(type&&a.type!==type)return false;if(q&&!a.msg.toLowerCase().includes(q)&&!a.by.toLowerCase().includes(q))return false;return true;});
  $('#f-atype').html('<option value="">All Types</option>'+Object.keys(types).sort().map(function(t){return '<option value="'+t+'"'+(t===type?'selected':'')+'>'+capitalize(t)+'</option>';}).join(''));
  $('#rc-activity').text(rows.length+' entr'+(rows.length!==1?'ies':'y'));
  if(!rows.length){$('#act-list').html('<div class="empty-state"><i class="fa-solid fa-clock-rotate-left"></i><p>No activity.</p></div>');return;}
  $('#act-list').html(rows.map(function(a,idx){
    return '<div class="act-entry"><div class="act-line"><div class="act-dot" style="background:'+a.color+';"></div>'+(idx<rows.length-1?'<div class="act-trail"></div>':'')+'</div><div><div class="act-msg">'+a.msg+'</div><div class="act-meta"><i class="fa-solid fa-user" style="font-size:10px;"></i>'+a.by+'<span style="color:#ccc;">·</span><i class="fa-regular fa-clock" style="font-size:10px;"></i>'+a.time+'</div></div></div>';
  }).join(''));
}
function filterActivity(q){renderActivity(q,$('#f-atype').val());}
function logAct(type,color,msg,by){var nid=ACTIVITY.length?Math.max.apply(null,ACTIVITY.map(function(a){return a.id;}))+1:1;ACTIVITY.unshift({id:nid,type:type,color:color,msg:msg,by:by,time:nowStr()});if($('#tab-activity').hasClass('active'))renderActivity();updateCounts();}

/* ─── NOTES ─── */
function renderNotes(){
  if(!NOTES.length){$('#notes-list').html('<div class="empty-state"><i class="fa-solid fa-note-sticky"></i><p>No notes yet.</p></div>');return;}
  $('#notes-list').html(NOTES.map(function(n){return '<div class="note-card" id="note-'+n.id+'"><div class="note-text">'+n.text+'</div><div class="note-foot"><span class="note-by"><i class="fa-solid fa-user" style="font-size:10px;margin-right:3px;"></i>'+n.by+' · '+n.time+'</span><button class="del-note" onclick="delNote('+n.id+')" title="Delete"><i class="fa-solid fa-xmark"></i></button></div></div>';}).join(''));
}
function addNote(){var t=$('#new-note-text').val().trim();if(!t){$('#new-note-text').focus();return;}var nid=NOTES.length?Math.max.apply(null,NOTES.map(function(n){return n.id;}))+1:1;NOTES.unshift({id:nid,text:t,by:'Admin',time:nowStr()});$('#new-note-text').val('');renderNotes();updateCounts();logAct('note','#f59e0b','Note added by <strong>Admin</strong>','Admin');renderKPIs();toast('Note added','s');}
function delNote(id){NOTES=NOTES.filter(function(n){return n.id!==id;});renderNotes();updateCounts();renderKPIs();toast('Note deleted','w');}

/* ─── TAB COUNTS ─── */
//function updateCounts(){$('#tc-items').text(ISSUED_ITEMS.length);$('#tc-expenses').text(EXPENSES.length);$('#tc-payments').text(PAYMENTS.length);$('#tc-activity').text(ACTIVITY.length);$('#tc-notes').text(NOTES.length);}
function updateCounts() {
    // Check if variables exist before reading .length to prevent script crashes
    if (typeof ISSUED_ITEMS !== 'undefined') $('#tc-items').text(ISSUED_ITEMS.length);
    if (typeof EXPENSES !== 'undefined')     $('#tc-expenses').text(EXPENSES.length);
    if (typeof ACTIVITY !== 'undefined')     $('#tc-activity').text(ACTIVITY.length);
    if (typeof NOTES !== 'undefined')        $('#tc-notes').text(NOTES.length);
	
	
	// CHANGED: Swapped PAYMENTS to INVOICES to match your actual global data array name
	//PAYMENTS (INVOICE)
    if (typeof INVOICES !== 'undefined')$('#tc-payments').text(INVOICES.length);
}

/* ─── TAB SWITCH ─── */
//function switchTab(id,el){$('.tab-item').removeClass('active');$('.tab-pane').removeClass('active');$(el).addClass('active');$('#tab-'+id).addClass('active');if(id==='items')renderItems();else if(id==='expenses')renderExpenses();else if(id==='payments')renderPayments();else if(id==='activity')renderActivity();else if(id==='notes')renderNotes(); loadIssuedItems(); loadProjectInvoices();}

function switchTab(id, el) {
    $('.tab-item').removeClass('active');
    $('.tab-pane').removeClass('active');
    $(el).addClass('active');
    $('#tab-' + id).addClass('active');
    
    if (id === 'items') {
        renderItems();
        loadIssuedItems(); // Keeps original table loading
    } 
    // 🎯 NEW: Added cleanly for your product-centric view without disturbing anything else
    else if (id === 'products_view') {
        if (typeof PRODUCT_BASE_ITEMS !== 'undefined' && PRODUCT_BASE_ITEMS.length === 0) {
            loadProductBaseData().done(function() {
                renderProductsBaseTable();
            });
        } else {
            renderProductsBaseTable();
        }
    }
    else if (id === 'expenses') {
        renderExpenses();
    } 
    else if (id === 'payments') {
        //renderPayments();
        renderInvoices();
		loadProjectInvoices();
    } 
    else if (id === 'activity') {
        renderActivity();
    } 
    else if (id === 'notes') {
        renderNotes();
    }
}

/* ─── ISSUE ITEM REDIRECT ─── */
function redirectIssueItem(){
  toast('Redirecting to Inventory Issue screen — PRJ-2026-014…','i');
  // In production: window.location.href = '/inventory/issue?project=PRJ-2026-014';
  //window.location.href = '/Stock_Transfer?mode=issue&&?project='+rawServerId;
  window.location.href = `/Stock_Transfer/project_issue?mode=issue&project=${rawServerId}`;
  
}

/*====================================================================================================================
																				dynamic Logics
====================================================================================================================*/
$(document).ready(function() {
    
  loadProjectHeroDetails();
  loadProjectNotes();
  loadProjectActivity();
  loadProductBaseData();	
  loadProjectInvoices();//PAYMENTS (INVOICE)
  fetchExpenses();
  updateCounts();
  
});

function openInvoiceModal(projectId, successCallback) {
    var $modal = $('#invoice-modal');
    
    if ($modal.length === 0) {
        console.error("The layout container #invoice-modal is missing.");
        return;
    }

    // Assign project parameters
    $modal.data('project-id', projectId);
    $modal.data('on-success', typeof successCallback === 'function' ? successCallback : null);

    // Initialize clean field values
    $modal.find('input, select, textarea').val('');
    $('#inv-total-items').val(0);
    $('#inv-total-qty, #inv-free-qty, #inv-line-discount, #inv-tax-total, #inv-bill-discount-value, #inv-paid-amount').val('0.00');
    $('#inv-bill-discount-type').val('AMOUNT');

    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    $('#inv-date').val(now.toISOString().slice(0, 16));
    
    currentInvoiceStep = 1;
    $('#inv-step-1').show();
    $('#inv-step-2').hide();
    $('#inv-btn-back').hide();
    $('#inv-btn-next').show();
    $('#inv-btn-save').hide();
    $('#inv-ms1').addClass('active').removeClass('done');
    $('#inv-ms2').removeClass('active done');
    
    $('.fc').removeClass('has-error');
    $('.err-msg').hide();

    $modal.addClass('show');
}

function loadProjectHeroDetails() {
    if (typeof PROJECT === 'undefined' || !PROJECT.id) {
        console.warn("Hero Hydration Aborted: Void context scope.");
		console.log("id missed");
        return;
    }

    $.ajax({
        url: '<?= site_url("Projects/get_project_hero_details_ajax") ?>',
        type: 'GET',
        data: { project_id: PROJECT.id },
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                var p = res.project;
                
                // 🎯 1. BIND TO A GLOBAL VARIABLE FIRST
                // Storing the clean float value ensures your chart math won't break
                window.PROJECT_BUDGET = parseFloat(p.estimated_budget) || 0;
                console.log("id non missed");
                // Also update your main object reference state if you use it elsewhere
                //PROJECT.budget = window.PROJECT_BUDGET; 

                // 🎯 2. HYDRATE THE HERO DISPLAY ELEMENT
                // Uses the pre-formatted currency string returned from your PHP controller
                $('#hero-budget').text(p.budget); 

                // --- Keep your remaining DOM assignments intact ---
                var paddedId = p.project_id;
                $('#hero-display-id-top').text(paddedId);
                $('#hero-display-id-bot').text(paddedId);
                $('#hero-project-name').text(p.project_name);
                $('#hero-category').text(p.category);
                
                $('#hero-client-company').text(p.company_name ? p.company_name : 'No Company Recorded');
                $('#hero-client-contact').text(p.cus_name ? p.cus_name : 'No Contact Person');
                $('#hero-manager').text(p.manager);
                
                $('#hero-start-date').text(p.start_date_formatted);
                $('#hero-start-sub').text(p.elapsed_sub);
                $('#hero-end-date').text(p.end_date_formatted);
                $('#hero-end-sub').text(p.remaining_sub);
                $('#hero-created-sub').text('Created ' + p.created_date_formatted);
                
                $('#hero-progress-txt').text(p.progress_pct + '%');
                $('#hero-progress-bar').css('width', p.progress_pct + '%');

                $('#hero-status-pill').html('<i class="fa-solid fa-circle" style="font-size:6px;"></i> ' + p.project_status);
                var statusCheck = p.project_status.toLowerCase();
                if(statusCheck !== 'active' && statusCheck !== 'in progress' && statusCheck !== 'approved') {
                     $('#hero-status-pill').removeClass('ps-active').css('background', 'var(--text-muted)');
                } else {
                     $('#hero-status-pill').addClass('ps-active').css('background', ''); 
                }

                // 🎯 3. REDRAW CHARTS DYNAMICALLY
                // If your dashboard charts depend on this budget, trigger them to load now
                if (typeof renderCharts === 'function') {
                    renderCharts();
                }
            }
        },
        error: function(xhr) {
            console.error("Hero Sync Drop Error details:", xhr.responseText);
        }
    });
}

/* ─── LIFE CYCLE ENTRY ─── */
$(function(){
    // Set up default dates on forms if they exist
    if($('#m-date').length) $('#m-date').val(new Date().toISOString().split('T')[0]);
    if($('#ps-date').length) $('#ps-date').val(new Date().toISOString().split('T')[0]);
    
    // Bind change events
    $('#ps-method').on('change', function(){ 
        $('#ps-cheque-details').toggle($(this).val() === 'Cheque'); 
        if(typeof updatePayScreenBalance === "function") updatePayScreenBalance(); 
    });

    // 🚀 Instantly trigger our dynamic AJAX data sync engine
    loadIssuedItems();
	fetchExpenses();
});

function loadIssuedItems() {
    var urlParams = new URLSearchParams(window.location.search);
    var projectId = urlParams.get('project_id'); // Using your confirmed URL parameter

    if (!projectId) {
        console.error("❌ AJAX Aborted: project_id not found in URL parameters.");
        return;
    }

    // Show processing loader
    $('#items-tbody').html('<tr><td colspan="5" style="text-align:center; color:var(--text-muted); font-size:12px;">Loading transaction records...</td></tr>');

    $.ajax({
        url: "/Projects/get_issued_items_ajax",
        type: "GET",
        data: { project_id: projectId },
        dataType: "json",
        success: function(response) {
            //  THE DIAGNOSTIC STEP: Check your console log to see what your database keys actually look like!
            console.log("📊 Database Response Array:", response);
			
            var html = '';
			
            $('#tc-items').text(response.length);
			
            if (response && response.length > 0) {
                response.forEach(function(item) {
                    // Check if keys exist, fallback to 0 or empty safely if they are null
                    var activityId = item.activity_id || '—';
                    var productCount = item.total_product_count || 0;
                    var createdBy = item.created_by || '—';
                    var activityDate = item.activity_date || '—';
                    var remarks = item.remarks || '—';
                    html += '<tr>' +
                        '<td><span class="mono">#ACT-' + activityId + '</span></td>' +
                        '<td class="r mono" style="padding-right: 20px; font-weight:600;">' + productCount + ' Items</td>' +
                        '<td>User #' + createdBy + '</td>' +
                        '<td style="color:var(--text-muted); font-size:12px;">' + activityDate + '</td>' +
                        '<td style="max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="' + remarks + '">' + remarks + '</td>' +
                        //'<td style="max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="'  '">' + projectId + '</td>' +
						'<td style="text-align:center;"><button class="del-btn" style="margin-right:4px;" onclick="printDo('+ activityId +')" title="Print"><i class="fa-solid fa-print"></i></button></td>'+
					'</tr>';
                });
                
                $('#tc-items').text(response.length);
            } else {
                console.warn("⚠️ Query returned 0 records for project_id:", projectId);
                html = '<tr><td colspan="5" style="text-align:center; color:var(--text-muted); font-size:12px;">No batch transaction activity found.</td></tr>';
                $('#tc-items').text(0);
            }
            
            // Render directly to UI
            $('#items-tbody').html(html);
        },
        error: function(xhr, status, error) {
            console.error("❌ Critical AJAX Request Failed:", error);
            console.log("Raw response text from server:", xhr.responseText); // This prints PHP errors if any exist
            $('#items-tbody').html('<tr><td colspan="5" style="text-align:center; color:var(--danger); font-size:12px;">Failed to process transactional logs.</td></tr>');
        }
    });
} 
function fetchExpenses() {
    return $.ajax({
        url: '/Projects/get_project_expenses_ajax?project_id=' + PROJECT.id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            $('#expenses-tbody').html('<tr><td colspan="10" style="text-align:center;"><i class="fa-solid fa-circle-notch fa-spin"></i> Syncing expenses...</td></tr>');
        },
        success: function(res) {
            if (res.success) {
                EXPENSES = res.expenses || [];
				$('#tc-expenses').text(EXPENSES.length);
				
            } else {
                console.error("Expense stream error:", res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Expense HTTP route failed:", error);
        }
    });
}

function renderExpenses(q, cat) {
  q = (q || '').toLowerCase();
  cat = cat || $('#f-ecat').val();
  
  var cats = {};
  // Filter row sets based on search query values or categories chosen
  var rows = EXPENSES.filter(function(e) {
    cats[e.cat] = 1;
    if (cat && e.cat !== cat) return false;
    if (q && !e.cat.toLowerCase().includes(q) && 
             !e.type.toLowerCase().includes(q) && 
             !e.description.toLowerCase().includes(q) && 
             !e.ref.toLowerCase().includes(q)) return false;
    return true;
  });

  // Rebuild filter select dropdown dynamically
  $('#f-ecat').html('<option value="">All Categories</option>' + Object.keys(cats).sort().map(function(c) {
    return '<option value="' + c + '"' + (c === cat ? 'selected' : '') + '>' + c + '</option>';
  }).join(''));

  $('#rc-expenses').text(rows.length + ' record' + (rows.length !== 1 ? 's' : ''));

  if (!rows.length) {
    $('#expenses-tbody').html('<tr><td colspan="10"><div class="empty-state"><i class="fa-solid fa-receipt"></i><p>No expenses logged.</p></div></td></tr>');
    return;
  }

  // Map data fields perfectly to your required columns
  $('#expenses-tbody').html(rows.map(function(e) {
    var total = e.qty * e.amount;
    var color = CAT_COLORS[e.family] || '#6b7280'; // Fallback color indicator
    
    return '<tr>' +
      '<td style="font-size:12px;color:var(--text-muted);">' + e.date + '</td>' +
      '<td><span class="mono" style="font-size:11px;color:var(--text-muted);">' + e.ref + '</span></td>' +
      '<td><span class="badge" style="background:' + color + '18;color:' + color + '"><i class="fa-solid fa-circle" style="font-size:6px;margin-right:4px;"></i>' + e.cat + '</span></td>' +
      '<td><span class="badge b-pri">' + e.type + '</span></td>' +
      '<td style="font-size:12px;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="' + e.description + '">' + (e.description || '-') + '</td>' +
      '<td style="font-size:12px;color:var(--text-muted);">' + e.account + '</td>' +
      '<td class="r mono" style="font-size:12px;">' + e.qty + '</td>' +
      '<td class="r mono" style="font-size:12px;">' + fmt(e.amount) + '</td>' +
      '<td class="r"><strong class="mono">' + fmt(total) + '</strong></td>' +
      '<td style="text-align:center;"><button class="del-btn" onclick="delExpense(' + e.id + ')"><i class="fa-solid fa-xmark"></i></button></td>' +
    '</tr>';
  }).join(''));
}

/*function openExpenseModal(explicitProjectId = null) {
    console.log("Opening Custom Multi-Step Modal...");
    
    // 1. Reset states back to default step settings safely
    currentStep = 1;
    if (typeof modalStep !== 'undefined') modalStep = 1;
    
    selFamily = null; 
    selAccount = null;
    resetModal();

    // 2. Hydrate project context safely without risking global ReferenceErrors
    let targetProjectId = null;
    
    if (explicitProjectId) {
        targetProjectId = explicitProjectId;
    } else if (typeof PROJECT !== 'undefined' && PROJECT && PROJECT.id) {
        targetProjectId = PROJECT.id;
    } else {
        // FALLBACK: Read from PHP variable injection or parse the dashboard URL segment
        var rawServerId = '<?= !empty($selected_project_id) ? $selected_project_id : "" ?>';
        if (!rawServerId || rawServerId.trim() === "") {
            var urlSegments = window.location.pathname.split('/');
            var lastSegment = urlSegments.pop() || urlSegments.pop(); 
            if (!isNaN(lastSegment) && lastSegment !== "") {
                rawServerId = lastSegment;
            }
        }
        if (rawServerId && rawServerId.trim() !== "") {
            targetProjectId = rawServerId;
        }
    }

    // Assign to the hidden modal field
    if (targetProjectId) {
        $('#modal_project_id').val(targetProjectId);
        console.log("Modal bound to Project Context ID:", targetProjectId);
    } else {
        $('#modal_project_id').val('');
        console.log("Modal opened in global context (No Project Bound).");
    }

    // 3. Trigger rendering engine to pull fresh data from database endpoints
    if (typeof renderETypePills === "function") {
        renderETypePills(); 
    }

    // 4. Slide open the UI viewport overlay frame securely
    $('#exp-modal').addClass('show');
    
    if (typeof updateStepUI === "function") {
        updateStepUI();
    }
}*/
	function openExpenseModal(explicitProjectId = null) {
    console.log("Opening Custom Multi-Step Modal...");
    
    // 1. Reset states back to default step settings safely
    currentStep = 1;
    if (typeof modalStep !== 'undefined') modalStep = 1;
    
    selFamily = null; 
    selAccount = null;
    //resetModal(); // Commented out to prevent the UI infinite loop race condition

    // 2. Hydrate project context safely without risking global ReferenceErrors
   let targetProjectId = null;
    
    if (explicitProjectId) {
        targetProjectId = explicitProjectId;
    } else if (typeof PROJECT !== 'undefined' && PROJECT && PROJECT.id) {
        targetProjectId = PROJECT.id;
    } else {
        // FALLBACK: Read from PHP variable injection or parse the dashboard URL segment
        var rawServerId = '<?= !empty($selected_project_id) ? $selected_project_id : "" ?>';
        if (!rawServerId || rawServerId.trim() === "") {
            var urlSegments = window.location.pathname.split('/');
            var lastSegment = urlSegments.pop() || urlSegments.pop(); 
            if (!isNaN(lastSegment) && lastSegment !== "") {
                rawServerId = lastSegment;
            }
        }
        if (rawServerId && rawServerId.trim() !== "") {
            targetProjectId = rawServerId;
        }
    }

    // Assign to the hidden modal field
    if (targetProjectId) {
        $('#modal_project_id').val(targetProjectId);
        console.log("Modal bound to Project Context ID:", targetProjectId);
    } else {
        $('#modal_project_id').val('');
        console.log("Modal opened in global context (No Project Bound).");
    }

    // 3. Trigger rendering engine to pull fresh data from database endpoints
    if (typeof loadCategories === "function") {
        loadCategories(); // Kicks off the cascade dropdown list fetcher
    }

    if (typeof renderETypePills === "function") {
        renderETypePills(); 
    }

    // 4. Slide open the UI viewport overlay frame securely
    $('#exp-modal').addClass('show');
    
    if (typeof updateStepUI === "function") {
        updateStepUI();
    }
}


// 1. Initialize the global matrix array to house real DB row data
var INVOICES = [];

function renderInvoices(q, statusFilter) {
    q = (q || '').toLowerCase();
    statusFilter = statusFilter || $('#f-status').val(); // Dropdown element to filter by status if you add one later
    
    // 2. Apply filtering layers over the dataset
    var invoicesToDisplay = INVOICES.filter(function(inv) {
        if (statusFilter && inv.status !== statusFilter) return false;
        if (q && !inv.invoice_no.toLowerCase().includes(q)) return false;
        return true;
    });

    // Update row count indicator (assumes an element like #rc-invoices exists, or safe check)
    if ($('#rc-invoices').length) {
        $('#rc-invoices').text(invoicesToDisplay.length + ' invoice' + (invoicesToDisplay.length !== 1 ? 's' : ''));
    }

    // 3. Render Empty State Context across all 9 structural grid columns
    if (!invoicesToDisplay.length) {
        $('#payments-tbody').html('<tr><td colspan="9"><div class="empty-state" style="text-align:center; padding: 20px;"><i class="fa-solid fa-file-invoice-dollar" style="font-size:24px; color:var(--text-muted);"></i><p style="margin-top:8px; color:var(--text-muted);">No sales invoices found matching filters.</p></div></td></tr>');
        return;
    }

    // 4. Map records directly into the 9-column UI Layout table design
    $('#payments-tbody').html(invoicesToDisplay.map(function(inv) {
        // Safe standard helper wrapper for floating currency precision parsing
        var fmtVal = function(num) { return parseFloat(num || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); };
        
        var totalQty = parseFloat(inv.total_qty || 0).toFixed(0);
        var balance = parseFloat(inv.balance_amount || 0);

        return '<tr>' +
            '<td style="font-size:12px; color:var(--text-muted);">' + inv.invoice_date + '</td>' +
            '<td><span class="mono" style="font-size:11px; font-weight:600; color:var(--primary);">' + inv.invoice_no + '</span></td>' +
            '<td style="font-size:12px;">' + (inv.due_date ? inv.due_date : '—') + '</td>' +
            '<td class="r">' + inv.total_items + '</td>' +
            '<td class="r">' + totalQty + '</td>' +
            '<td class="r"><strong class="mono">' + fmtVal(inv.grand_total) + '</strong></td>' +
            //'<td class="r"><strong class="mono" style="color:var(--success);">' + fmtVal(inv.paid_amount) + '</strong></td>' +
            //'<td class="r"><strong class="mono ' + (balance > 0 ? 'text-danger' : '') + '">' + fmtVal(balance) + '</strong></td>' +
            '<td style="text-align:center;">' +
                '<button class="del-btn" style="background:none; border:none; color:var(--danger); cursor:pointer;" onclick="delInvoice(' + inv.id + ')">' +
                    '<i class="fa-solid fa-xmark"></i>' +
                '</button>' +
            '</td>' +
        '</tr>';
    }).join(''));
}

// 5. Asynchronous Core Dispatch Hook
/*function loadProjectInvoices() {
    if (typeof PROJECT === 'undefined' || !PROJECT.id) {
        console.warn("Aborted Invoice Load: Global tracking state execution token context is void.");
        return;
    }

    $.ajax({
        url: '/Projects/get_sales_invoices_ajax',
        type: 'GET',
        data: { project_id: PROJECT.id },
        dataType: 'json',
        beforeSend: function() {
            $('#payments-tbody').html('<tr><td colspan="9" style="text-align:center;" class="text-muted"><i class="fa-solid fa-circle-notch fa-spin"></i> Fetching active tracking invoices pipeline ledger...</td></tr>');
        },
        success: function(res) {
            if (res.success) {
                // Populate global repository with clean structured row logs from DB
                INVOICES = res.invoices || [];
                
                // 🎯 Bind Server-Side Aggregates directly into your chart window hooks
                window.TOTAL_INVOICE_BILLING_SUM = res.aggregate_invoice_total || 0;
                window.TOTAL_INVOICE_PAID_SUM    = res.aggregate_paid_total || 0;
                window.TOTAL_INVOICE_BALANCE_SUM = res.aggregate_balance_total || 0;

                renderInvoices();
                
                // Optional: If renderCharts() is ready, trigger a dynamic redraw here
                if (typeof renderCharts === 'function') {
                    renderCharts();
                }
            } else {
                alert(res.message || "Failed parsing array layers.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Interface Failure text stack:", xhr.responseText);
            $('#payments-tbody').html('<tr><td colspan="9" style="text-align:center; color:red;">Critical runtime connection pipeline drop error.</td></tr>');
        }
    });
}*/


function openPayScreen() {
    if (typeof PROJECT !== 'undefined' && PROJECT.id) {
        // Redirect the browser window straight to your destination URI route mapping
        window.location.href = '/Sale_invoice/sale_list?id=' + PROJECT.id;
    } else {
        console.error("Redirect Failed: Active tracking project instance execution frame is unassigned.");
        alert("Unable to process request: Project context was not found.");
    }
}

function loadProjectNotes() {
    // Assumes PROJECT.id is globally available on your dashboard view page
    $.ajax({
        url: '/Projects/get_project_notes_ajax',
        type: 'GET',
        data: { project_id: PROJECT.id },
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                NOTES = res.notes;
				$('#tc-notes').text(NOTES.length);
                renderNotes();
            } else {
                console.error("Notes Error: " + res.message);
            }
        },
        error: function() {
            console.error("Critical failure reading project note streams.");
        }
    });
}

/**
 * UI Renderer: Compiles the NOTES array into your layout container
 */
function renderNotes() {
    // 1. Target your exact HTML workspace container component
    if (!NOTES || !NOTES.length) {
        $('#notes-list').html('<div class="empty-state"><i class="fa-solid fa-note-sticky"></i><p>No notes yet.</p></div>');
        return;
    }
    
    // 2. Map through the dynamic database array records using your precise card CSS class wrappers
    $('#notes-list').html(NOTES.map(function(n) {
        // Fallback checks to prevent layout crashes if a column value arrives null
        var textContent = n.text || '';
        var authorName = n.by || 'System User';
        var timestamp = n.time || 'Recent';

        return '<div class="note-card" id="note-' + n.id + '">' +
            '<div class="note-text">' + textContent + '</div>' +
            '<div class="note-foot">' +
                '<span class="note-by">' +
                    '<i class="fa-solid fa-user" style="font-size:10px; margin-right:3px;"></i>' + 
                    authorName + ' · ' + timestamp + 
                '</span>' +
                '<button class="del-note" onclick="delNote(' + n.id + ')" title="Delete">' +
                    '<i class="fa-solid fa-xmark"></i>' +
                '</button>' +
            '</div>' +
        '</div>';
    }).join(''));
}

/**
 * Action Controller: Add Note Form Submissions
 */
function addProjectNote() {
    var $textarea = $('#new-note-text'); // Change selector to match your input textarea field ID
    var noteText = $textarea.val().trim();

    if (!noteText) {
        alert("Please write some content before submitting your note updates.");
        return;
    }

    $.ajax({
        url: 'https://medi.provioustech.com/index.php/Projects/save_project_note_ajax',
        type: 'POST',
        data: {
            project_id: PROJECT.id,
            note_text: noteText
        },
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                $textarea.val(''); // Wipe text input area
                loadProjectNotes(); // Refresh database view stream
				loadProjectActivity();
                if (typeof toast === 'function') toast('Note attached successfully', 's');
            } else {
                alert("Error: " + res.message);
            }
        }
    });
}

/**
 * Action Controller: Delete Note Requests
 */
function delNote(id) {
    if (!confirm("Are you sure you want to permanently delete this internal note?")) return;

    $.ajax({
        url: 'https://medi.provioustech.com/index.php/Projects/delete_project_note_ajax',
        type: 'POST',
        data: { note_id: id },
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                loadProjectNotes(); // Refresh list layout view
                if (typeof toast === 'function') toast('Note removed', 'w');
            } else {
                alert("Error: " + res.message);
            }
        }
    });
}

function loadProjectActivity() {
    // Assumes PROJECT.id is globally available on your dashboard view page
    $.ajax({
        url: '/Projects/get_project_activity_ajax',
        type: 'GET',
        data: { project_id: PROJECT.id },
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                // Update global data tracker pool
                ACTIVITY = res.activity;
                $('#tc-activity').text(ACTIVITY.length);
                // Fire the interface compiler engine
                renderActivity('', '');
            } else {
                console.error("Activity Stream Error: " + res.message);
            }
        },
        error: function() {
            console.error("Critical communications failure reading timeline feed vectors.");
        }
    });
}

/**
 * UI Renderer: Compiles the combined timeline matrix into the DOM
 */
function renderActivity(q, type) {
    q = (q || '').toLowerCase();
    type = type || $('#f-atype').val();
    
    var types = {};
    
    // 1. Filter data dynamically inside the UI layer
    var rows = ACTIVITY.filter(function(a) {
        types[a.type] = 1; // Track existing types to populate the select filter dropdown
        if (type && a.type !== type) return false;
        if (q && !a.msg.toLowerCase().includes(q) && !a.by.toLowerCase().includes(q)) return false;
        return true;
    });

    // 2. Refresh the Toolbar Filter Dropdown options dynamically
    var selectHtml = '<option value="">All Types</option>' + Object.keys(types).sort().map(function(t) {
        // Simple capitalize helper logic
        var capitalizedType = t.charAt(0).toUpperCase() + t.slice(1);
        return '<option value="' + t + '"' + (t === type ? ' selected' : '') + '>' + capitalizedType + '</option>';
    }).join('');
    $('#f-atype').html(selectHtml);

    // 3. Update the Counter Tag indicator
    if ($('#rc-activity').length) {
        $('#rc-activity').text(rows.length + ' entr' + (rows.length !== 1 ? 'ies' : 'y'));
    }

    // 4. Handle empty timelines cleanly
    if (!rows.length) {
        $('#act-list').html('<div class="empty-state"><i class="fa-solid fa-clock-rotate-left"></i><p>No activity found matching filters.</p></div>');
        return;
    }

    // 5. Map rows chronologically using your exact visual timeline classes and dots
    $('#act-list').html(rows.map(function(a, idx) {
        // Renders the vertical layout tracking connection line up until the last entry card
        var trailLine = (idx < rows.length - 1) ? '<div class="act-trail"></div>' : '';

        return '<div class="act-entry">' +
            '<div class="act-line">' +
                '<div class="act-dot" style="background:' + a.color + ';"></div>' +
                trailLine +
            '</div>' +
            '<div>' +
                '<div class="act-msg">' + a.msg + '</div>' +
                '<div class="act-meta">' +
                    '<i class="fa-solid fa-user" style="font-size:10px; margin-right:4px;"></i>' + a.by +
                    '<span style="color:#ccc; margin:0 6px;">·</span>' +
                    '<i class="fa-regular fa-clock" style="font-size:10px; margin-right:4px;"></i>' + a.time +
                '</div>' +
            '</div>' +
        '</div>';
    }).join(''));
}

/**
 * Filter Controller Pipe
 */
function filterActivity(q) {
    renderActivity(q, $('#f-atype').val());
}
// Example tab control router integration click event
$('.tab-btn, .nav-link').on('click', function() {
    var targetTabId = $(this).attr('href') || $(this).data('target');
    
    // Trigger data pipe query exclusively when the activity panel comes into focus
    if (targetTabId === '#tab-activity') {
        loadProjectActivity();
    }
});

/*function loadProductBaseData() {
    // Show a loading indicator spinner while the data downloads
    $('#products-view-tbody').html('<tr><td colspan="4" style="text-align:center;" class="text-muted"><i class="fa-solid fa-spinner fa-spin"></i> Organizing product records...</td></tr>');

    return $.ajax({
        // 🎯 UPDATED: Matches your exact platform directory pathing structure
        url: '/Projects/get_product_base_items_ajax', 
        type: 'GET',
        data: { project_id: PROJECT.id },   // Attaches the active dashboard project context ID
        dataType: 'json',
        success: function(response) {
            PRODUCT_BASE_ITEMS = response;
            
            // Sync the counter badges on your interface
            $('#tc-products-count').text(PRODUCT_BASE_ITEMS.length);
            $('#rc-products-total').text(PRODUCT_BASE_ITEMS.length + ' Unique Products');
        },
        error: function(xhr, status, error) {
            console.error("Product data stream connection failed:", error);
            $('#products-view-tbody').html('<tr><td colspan="4" style="text-align:center;" class="text-danger">Failed to load product list.</td></tr>');
        }
    });
}*/
function loadProductBaseData() {
    $('#products-view-tbody').html('<tr><td colspan="4" style="text-align:center;" class="text-muted"><i class="fa-solid fa-spinner fa-spin"></i> Organizing product records...</td></tr>');

    return $.ajax({
        url: '/Projects/get_product_base_items_ajax', 
        type: 'GET',
        data: { project_id: PROJECT.id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                PRODUCT_BASE_ITEMS = response.products;
                TOTAL_ISSUED_INVENTORY_COST = parseFloat(response.grand_issued_value || 0); // 🎯 Saved to global context
                
                // Update Badge Counters
                $('#tc-products-count').text(PRODUCT_BASE_ITEMS.length);
                $('#rc-products-total').text(PRODUCT_BASE_ITEMS.length + ' Unique Products');
                
                // 🎯 Automatically refresh the charts row since we now have the real inventory value
                renderCharts();
            }
        },
        error: function() {
            $('#products-view-tbody').html('<tr><td colspan="4" style="text-align:center;" class="text-danger">Failed to load product list.</td></tr>');
        }
    });
}

/**
 * 3. Dedicated HTML Table UI Row Painter
 */
function renderProductsBaseTable() {
    const $tbody = $('#products-view-tbody');
    if (!$tbody.length) return; // Safety guard in case element isn't in DOM yet

    if (!PRODUCT_BASE_ITEMS || PRODUCT_BASE_ITEMS.length === 0) {
        $tbody.html('<tr><td colspan="4" style="text-align:center;" class="text-muted">No product summary allocations recorded for this project.</td></tr>');
        return;
    }

    let rows = '';
    PRODUCT_BASE_ITEMS.forEach(p => {
        // Formats quantities to remove extra decimal trailing zeros gracefully
        let formattedQty = parseFloat(p.total_quantity_issued || 0);

        rows += `
            <tr>
                <td class="mono" style="font-size:12px; color:var(--text-muted);">${p.product_id}</td>
                <td style="font-weight:600; color:var(--text-dark);">${p.product_name || 'Generic / Unnamed Product'}</td>
                <td class="r mono fw-700" style="font-size:13px; padding-right:20px; color:var(--primary);">${formattedQty}</td>
                <td class="r mono" style="font-size:12px; padding-right:20px;">${p.total_transactions_count} entries</td>
            </tr>
        `;
    });

    $tbody.html(rows);
}

/**
 * 4. Optional Frontend Search Filter (Hooks into the text input on your tab toolbar)
 */
function filterProductsTab(searchValue) {
    let q = searchValue.toLowerCase().trim();
    if (!q) {
        renderProductsBaseTable(); // If search is cleared, reset to standard list
        return;
    }

    const $tbody = $('#products-view-tbody');
    let rows = '';
    
    // Filter the global array matching the search query
    let filtered = PRODUCT_BASE_ITEMS.filter(p => {
        let name = (p.product_name || '').toLowerCase();
        let id = String(p.product_id || '').toLowerCase();
        return name.includes(q) || id.includes(q);
    });

    if (filtered.length === 0) {
        $tbody.html('<tr><td colspan="4" style="text-align:center;" class="text-muted">No matching products found.</td></tr>');
        return;
    }

    filtered.forEach(p => {
        let formattedQty = parseFloat(p.total_quantity_issued || 0);
        rows += `
            <tr>
                <td class="mono" style="font-size:12px; color:var(--text-muted);">${p.product_id}</td>
                <td style="font-weight:600; color:var(--text-dark);">${p.product_name || 'Generic / Unnamed Product'}</td>
                <td class="r mono fw-700" style="font-size:13px; padding-right:20px; color:var(--primary);">${formattedQty}</td>
                <td class="r mono" style="font-size:12px; padding-right:20px;">${p.total_transactions_count} entries</td>
            </tr>
        `;
    });

    $tbody.html(rows);
}

/*====================================================================================================================
																				dynamic Logics	END END END END
====================================================================================================================*/

/* ─── PAYMENT SCREEN ─── */
/*function openPayScreen(){
  var totalPaid=PAYMENTS.reduce(function(a,p){return a+p.amount;},0);
  var balance=PROJECT.budget-totalPaid;
  $('#ps-received').text('Rs. '+fmt(totalPaid));
  $('#ps-balance').text('Rs. '+fmt(balance));
  updatePayScreenBalance();
  $('#ps-date').val(new Date().toISOString().split('T')[0]);
  $('#ps-amount,#ps-ref,#ps-note,#ps-chq-no,#ps-chq-bank').val('');
  $('#ps-method').val('');
  $('#ps-cheque-details').hide();
  $('#m-total-display').text('Rs. 0.00');
  $('.err').hide();
  $('#pay-screen').addClass('show');
  $('body').css('overflow','hidden');
}*/
function closePayScreen(){$('#pay-screen').removeClass('show');$('body').css('overflow','');}
function updatePayScreenBalance(){
  var totalPaid=PAYMENTS.reduce(function(a,p){return a+p.amount;},0);
  var newAmt=parseFloat($('#ps-amount').val())||0;
  var newTotal=totalPaid+newAmt;
  $('#ps-running-total').text('Rs. '+fmt(newTotal));
}
function savePayment(){
  var ok=true;
  var amt=parseFloat($('#ps-amount').val())||0;
  if(amt<=0){$('#err-ps-amount').show();ok=false;}else{$('#err-ps-amount').hide();}
  if(!$('#ps-method').val()){$('#err-ps-method').show();ok=false;}else{$('#err-ps-method').hide();}
  if(!$('#ps-date').val()){$('#err-ps-date').show();ok=false;}else{$('#err-ps-date').hide();}
  if(!ok)return;
  var nid=PAYMENTS.length?Math.max.apply(null,PAYMENTS.map(function(p){return p.id;}))+1:1;
  PAYMENTS.push({id:nid,date:$('#ps-date').val(),ref:$('#ps-ref').val()||'PAY-'+String(nid).padStart(3,'0'),method:$('#ps-method').val(),note:$('#ps-note').val()||$('#ps-method').val()+' payment',amount:amt});
  logAct('payment','#10b981','Payment received — <strong>Rs. '+fmt(amt)+'</strong> ('+($('#ps-note').val()||'—')+')','Admin');
  closePayScreen();
  renderAll();renderKPIs();renderCharts();
  switchTab('payments',$('.tab-item').eq(2)[0]);
  toast('Payment saved — Rs. '+fmt(amt),'s');
}

/* ─── EXPENSE MODAL ─── */
/*function buildFamPills(){$('#fam-grid').html(EXP_FAMILIES.map(function(f){return '<div class="fam-pill" onclick="selFam(\''+f.key+'\')" id="fp-'+f.key+'"><i class="fa-solid '+f.icon+'" style="color:'+f.color+'"></i><span>'+f.label+'</span></div>';}).join(''));}
function selFam(key){selFamily=key;$('.fam-pill').removeClass('sel');$('#fp-'+key).addClass('sel');var cats=EXP_CATS[key]||[];$('#m-cat').html('<option value="">— Select —</option>'+cats.map(function(c){return '<option value="'+c.id+'">'+c.label+'</option>';}).join(''));$('#m-type').html('<option value="">— Select —</option>');$('#cat-row').show();$('#type-row').hide();$('#err-fam').hide();}
function onCatChange(){var cid=$('#m-cat').val();if(!cid){$('#type-row').hide();return;}var cat=(EXP_CATS[selFamily]||[]).find(function(c){return c.id===cid;});if(!cat)return;$('#m-type').html('<option value="">— Select —</option>'+cat.types.map(function(t){return '<option>'+t+'</option>';}).join(''));$('#type-row').show();$('#err-cat').hide();}
function calcExpTotal(){var a=parseFloat($('#m-amount').val())||0,q=parseInt($('#m-qty').val())||1;$('#m-total-display').text('Rs. '+fmt(a*q));}
function openExpModal(){selFamily=null;$('.fam-pill').removeClass('sel');$('#m-cat,#m-type,#m-account').val('');$('#m-amount').val('');$('#m-qty').val(1);$('#m-ref,#m-note').val('');$('#m-total-display').text('Rs. 0.00');$('#cat-row,#type-row').hide();$('.err').hide();$('#m-date').val(new Date().toISOString().split('T')[0]);$('#exp-modal').addClass('show');}
function closeExpModal(){$('#exp-modal').removeClass('show');}
function saveExpense(){
  var ok=true;
  if(!selFamily){$('#err-fam').show();ok=false;}
  if(!$('#m-cat').val()){$('#err-cat').show();ok=false;}
  if(!$('#m-type').val()){$('#err-type').show();ok=false;}
  var amt=parseFloat($('#m-amount').val())||0;
  if(amt<=0){$('#err-amount').show();ok=false;}else{$('#err-amount').hide();}
  if(!$('#ps-date,#m-date').filter('[id="m-date"]').val()){$('#err-mdate').show();ok=false;}else{$('#err-mdate').hide();}
  if(!$('#m-account').val()){$('#err-maccount').show();ok=false;}else{$('#err-maccount').hide();}
  if(!ok)return;
  var cats=EXP_CATS[selFamily]||[];
  var cat=cats.find(function(c){return c.id===$('#m-cat').val();});
  var nid=EXPENSES.length?Math.max.apply(null,EXPENSES.map(function(e){return e.id;}))+1:1;
  var qty=parseInt($('#m-qty').val())||1;
  EXPENSES.push({id:nid,date:$('#m-date').val(),ref:$('#m-ref').val()||'EXP-'+String(nid).padStart(3,'0'),family:selFamily,cat:cat?cat.label:'Other',type:$('#m-type').val(),note:$('#m-note').val(),account:$('#m-account').val(),qty:qty,amount:amt});
  logAct('expense','#ef4444','Expense added — <strong>'+($('#m-type').val())+'</strong> — Rs. '+fmt(amt*qty),'Admin');
  closeExpModal();
  renderAll();renderKPIs();renderCharts();
  switchTab('expenses',$('.tab-item').eq(1)[0]);
  toast('Expense saved — Rs. '+fmt(amt*qty),'s');
}*/

/* ─── HELPERS ─── */
function fmt(n){return Number(n).toLocaleString('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2});}
function fmtK(n){if(n>=1000000)return (n/1000000).toFixed(2)+'M';if(n>=1000)return (n/1000).toFixed(0)+'K';return fmt(n);}
function capitalize(s){return s.charAt(0).toUpperCase()+s.slice(1);}
function nowStr(){var d=new Date();return d.toISOString().slice(0,16).replace('T',' ');}
function toast(msg,type){
  var map={s:['t-s','fa-check-circle'],w:['t-w','fa-triangle-exclamation'],e:['t-e','fa-circle-xmark'],i:['t-i','fa-circle-info']};
  var p=map[type]||map.i;
  var $t=$('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i>'+msg+'</div>');
  $('#toast-c').append($t);
  setTimeout(function(){$t.css({opacity:0,transform:'translateX(16px)',transition:'all .3s'});setTimeout(function(){$t.remove();},300);},2800);
}





















//script for new invoice function



let invItems = [];
let currentViewInvoiceId = null;
let INVOICES2 = [];

$(document).ready(function() {
    loadProjectHeroDetails();
    loadProjectNotes();
    loadProjectActivity();
    loadProductBaseData();
    loadProjectInvoices(); // PAYMENTS (INVOICE)
});

/* ═══════════════════════════════════════
   LOAD INVOICES FROM SERVER (unchanged)
   ═══════════════════════════════════════ */
function loadProjectInvoices() {
    if (typeof PROJECT === 'undefined' || !PROJECT.id) {
        console.warn("Aborted Invoice Load: Global tracking state execution token context is void.");
        return;
    }
    $.ajax({
        url: '<?= site_url("Projects/get_sales_invoices_ajax") ?>',
        type: 'GET',
        data: { project_id: PROJECT.id },
        dataType: 'json',
        beforeSend: function() {
            $('#payments-tbody').html('<tr><td colspan="9" style="text-align:center;" class="text-muted"><i class="fa-solid fa-circle-notch fa-spin"></i> Fetching active tracking invoices pipeline ledger...</td></tr>');
        },
        success: function(res) {
            if (res.success) {
                INVOICES2 = res.invoices || [];

                window.TOTAL_INVOICE_BILLING_SUM = res.aggregate_invoice_total || 0;
                window.TOTAL_INVOICE_PAID_SUM    = res.aggregate_paid_total || 0;
                window.TOTAL_INVOICE_BALANCE_SUM = res.aggregate_balance_total || 0;

                renderInvoices(); // <— replaces renderPayments()

                if (typeof renderCharts === 'function') {
                    renderCharts();
                }
            } else {
                alert(res.message || "Failed parsing array layers.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Interface Failure text stack:", xhr.responseText);
            $('#payments-tbody').html('<tr><td colspan="9" style="text-align:center; color:red;">Critical runtime connection pipeline drop error.</td></tr>');
        }
    });
}

/* ═══════════════════════════════════════
   RENDER / FILTER / DELETE INVOICES
   (replacement for renderPayments / filterPayments / delPayment)
   ═══════════════════════════════════════ */
function renderInvoices(q, status) {
    q = (q || '').toLowerCase();
    status = status || $('#f-pmethod').val(); // reusing your existing filter dropdown id

    var statuses = {};
    var rows = INVOICES2.filter(function(inv) {
        statuses[inv.status] = 1;
        if (status && inv.status !== status) return false;
        if (q && !inv.invoice_no.toLowerCase().includes(q) && !(inv.notes || '').toLowerCase().includes(q)) return false;
        return true;
    });

    // Rebuild status filter dropdown dynamically (same pattern as method dropdown)
    $('#f-pmethod').html(
        '<option value="">All Statuses</option>' +
        Object.keys(statuses).sort().map(function(s) {
            return '<option value="' + s + '"' + (s === status ? ' selected' : '') + '>' + s.charAt(0).toUpperCase() + s.slice(1) + '</option>';
        }).join('')
    );

    $('#rc-payments').text(rows.length + ' invoice' + (rows.length !== 1 ? 's' : ''));
    $('#tc-payments').text(rows.length + ' invoice' + (rows.length !== 1 ? 's' : ''));

    if (!rows.length) {
        $('#payments-tbody').html('<tr><td colspan="9"><div class="empty-state"><i class="fa-solid fa-file-invoice"></i><p>No invoices.</p></div></td></tr>');
        return;
    }

    var sc = { 'unpaid': 'b-dan', 'partial': 'b-warn', 'paid': 'b-suc', 'cancelled': 'b-pri' };

    $('#payments-tbody').html(rows.map(function(r) {
        return '<tr>' +
            '<td style="font-size:12px;color:var(--text-muted);">' + r.invoice_date + '</td>' +
            '<td><a href="javascript:void(0)" onclick="viewInvoice(' + r.id + ')"><span class="mono" style="font-size:11px;font-weight:600;color:var(--primary);">' + r.invoice_no + '</span></a></td>' +
            '<td style="font-size:12px;color:var(--text-muted);">' + (r.due_date || '-') + '</td>' +
            '<td class="r">' + r.total_items + '</td>' +
            '<td class="r">' + r.total_qty + '</td>' +
            '<td class="r"><strong class="mono">' + fmt(r.grand_total) + '</strong></td>' +
            //'<td class="r"><strong class="mono" style="color:var(--success);">' + fmt(r.paid_amount) + '</strong></td>' +
            //'<td class="r"><strong class="mono" style="color:var(--danger);">' + fmt(r.balance) + '</strong></td>' +
            '<td style="text-align:center;">' +
                '<button class="del-btn" style="margin-right:4px;" onclick="printInvoiceDirect(' + r.id + ')" title="Print"><i class="fa-solid fa-print"></i></button>' +
                //'<button class="del-btn" onclick="deleteInvoice(' + r.id + ')"><i class="fa-solid fa-xmark"></i></button>' +
            '</td>' +
        '</tr>';
    }).join(''));
}

function filterPayments(q) {
    renderInvoices(q, $('#f-pmethod').val());
}

function deleteInvoice(invoice_id) {
    if (!confirm('Delete this invoice?')) return;
    $.post('<?= site_url("Projects/delete_invoice") ?>/' + invoice_id, function(res) {
        if (res.status) {
            loadProjectInvoices();
            if (typeof logAct === 'function') logAct('payment', '#ef4444', 'Invoice deleted', 'Admin');
            if (typeof toast === 'function') toast('Invoice deleted', 'w');
        }
    }, 'json');
}

/* ═══════════════════════════════════════
   CREATE INVOICE MODAL
   ═══════════════════════════════════════ */
function openInvoiceModal(project_id, callback) {
    invItems = [];
    clearAllErrors();
    $('#invoiceForm')[0].reset();
    $('#inv-date').val(new Date().toISOString().slice(0, 10));
    $('#inv-paid').val(0);
    $('#inv-invoice-discount').val(0);
    loadProductOptions();
    renderInvoiceItems();
    window._invoiceSaveCallback = callback;
    $('#invoiceModal').modal('show');
}

function loadProductOptions() {
    $.getJSON('<?= site_url("Projects/product_search") ?>', { term: '' }, function(data) {
        const sel = $('#inv-product-select').empty().append('<option value="">Type to search...</option>');
        data.forEach(p => {
            sel.append(`<option value="${p.id}" data-price="${p.retailPrice || p.price || 0}" data-code="${p.product_code || ''}">${p.name}${p.product_code ? ' (' + p.product_code + ')' : ''}</option>`);
        });
    });
}

$(document).on('change', '#inv-product-select', function() {
    const opt = $(this).find(':selected');
    $('#inv-add-price').val(opt.data('price') || 0);
});

function addInvoiceItem() {
    clearFieldError('err-items');

    const sel = $('#inv-product-select');
    const opt = sel.find(':selected');
    const pid = sel.val();

    if (!pid) {
        showFieldError('err-items', 'Please select a product.');
        return;
    }

    // ── Duplicate check: merge quantity instead of blocking ──
    const existingIdx = invItems.findIndex(it => it.product_id === pid);
    if (existingIdx !== -1) {
        const qty = parseFloat($('#inv-add-qty').val()) || 0;
        if (qty <= 0) {
            showFieldError('err-items', 'Quantity must be greater than 0.');
            return;
        }
        invItems[existingIdx].qty += qty;

        sel.val('');
        $('#inv-add-qty').val(1);
        $('#inv-add-price').val('');
        $('#inv-add-discount').val(0);
        renderInvoiceItems();
        return;
    }

    const qty = parseFloat($('#inv-add-qty').val()) || 0;
    const price = parseFloat($('#inv-add-price').val()) || 0;
    const discount = parseFloat($('#inv-add-discount').val()) || 0;

    if (qty <= 0) {
        showFieldError('err-items', 'Quantity must be greater than 0.');
        return;
    }
    if (price < 0) {
        showFieldError('err-items', 'Unit price cannot be negative.');
        return;
    }
    if (discount < 0) {
        showFieldError('err-items', 'Discount cannot be negative.');
        return;
    }
    if (discount > qty * price) {
        showFieldError('err-items', 'Discount cannot exceed line amount.');
        return;
    }

    invItems.push({
        product_id: pid,
        product_name: opt.text(),
        product_code: opt.data('code') || '',
        unit_price: price,
        qty: qty,
        discount: discount
    });

    sel.val('');
    $('#inv-add-qty').val(1);
    $('#inv-add-price').val('');
    $('#inv-add-discount').val(0);
    renderInvoiceItems();
}



// ── Duplicate check: merge quantity instead of blocking ──
/*const existingIdx = invItems.findIndex(it => it.product_id === pid);
if (existingIdx !== -1) {
    const qty = parseFloat($('#inv-add-qty').val()) || 0;
    if (qty <= 0) { showFieldError('err-items', 'Quantity must be greater than 0.'); return; }

    invItems[existingIdx].qty += qty;

    sel.val('');
    $('#inv-add-qty').val(1);
    $('#inv-add-price').val('');
    $('#inv-add-discount').val(0);
    renderInvoiceItems();
    return;
}*/

function renderInvoiceItems() {
    const tbody = $('#inv-items-tbody').empty();
    const hasItems = invItems.length > 0;
    $('#inv-empty-state').toggle(!hasItems);
    $('#inv-items-tbody').closest('table').toggle(hasItems);

    invItems.forEach((it, idx) => {
        const lineTotal = (it.qty * it.unit_price) - it.discount;
        tbody.append(`
          <tr>
            <td>${idx + 1}</td>
            <td>${it.product_name}</td>
            <td>${it.product_code}</td>
            <td class="r">${it.unit_price.toFixed(2)}</td>
            <td class="r"><input type="number" min="0.01" step="0.01" value="${it.qty}" style="width:65px" onchange="updateItem(${idx},'qty',this.value)"></td>
            <td class="r"><input type="number" min="0" step="0.01" value="${it.discount}" style="width:70px" onchange="updateItem(${idx},'discount',this.value)"></td>
            <td class="r">${lineTotal.toFixed(2)}</td>
            <td class="r"><button type="button" class="siv-btn-danger-icon" onclick="removeItem(${idx})"><i class="fa-solid fa-trash"></i></button></td>
          </tr>`);
    });
    $('#sum-items-badge').text(invItems.length + ' items');
    renderInvoiceSummary();
}

function updateItem(idx, field, value) {
    invItems[idx][field] = parseFloat(value) || 0;
    renderInvoiceItems();
}

function removeItem(idx) {
    invItems.splice(idx, 1);
    renderInvoiceItems();
}

function renderInvoiceSummary() {
    const totalItems = invItems.length;
    const totalQty = invItems.reduce((s, it) => s + it.qty, 0);
    const totalLineDiscount = invItems.reduce((s, it) => s + it.discount, 0);
    const subTotal = invItems.reduce((s, it) => s + (it.qty * it.unit_price - it.discount), 0);

    let invoiceDiscount = parseFloat($('#inv-invoice-discount').val()) || 0;
    if (invoiceDiscount > subTotal) invoiceDiscount = subTotal;

    const grandTotal = subTotal - invoiceDiscount;
    const paid = parseFloat($('#inv-paid').val()) || 0;

    $('#sum-items').text(totalItems);
    $('#sum-qty').text(totalQty);
    $('#sum-discount').text('Rs. ' + totalLineDiscount.toFixed(2));
    $('#sum-subtotal').text('Rs. ' + subTotal.toFixed(2));
    $('#sum-invoice-discount').text('Rs. ' + invoiceDiscount.toFixed(2));
    $('#sum-paid').text('Rs. ' + paid.toFixed(2));
    $('#sum-grand').text('Rs. ' + grandTotal.toFixed(2));
}

$(document).on('input', '#inv-paid, #inv-invoice-discount', renderInvoiceSummary);

/* ---------- Validation ---------- */
function showFieldError(id, msg) { $('#' + id).text(msg).addClass('show'); }
function clearFieldError(id) { $('#' + id).text('').removeClass('show'); }
function clearAllErrors() {
    $('.siv-error').text('').removeClass('show');
    $('.siv-input').removeClass('is-invalid');
}

function validateInvoiceForm() {
    clearAllErrors();
    let valid = true;

    const date = $('#inv-date').val();
    if (!date) {
        showFieldError('err-date', 'Invoice date is required.');
        $('#inv-date').addClass('is-invalid');
        valid = false;
    }

    const dueDate = $('#inv-due-date').val();
    if (dueDate && date && dueDate < date) {
        showFieldError('err-date', 'Due date cannot be before invoice date.');
        valid = false;
    }

    const paid = parseFloat($('#inv-paid').val());
    if (paid < 0) {
        showFieldError('err-paid', 'Paid amount cannot be negative.');
        $('#inv-paid').addClass('is-invalid');
        valid = false;
    }

    if (invItems.length === 0) {
        showFieldError('err-items', 'Add at least one product to the invoice.');
        valid = false;
    }

    const subTotal = invItems.reduce((s, it) => s + (it.qty * it.unit_price - it.discount), 0);
    const invoiceDiscount = parseFloat($('#inv-invoice-discount').val()) || 0;
    if (invoiceDiscount < 0) {
        showFieldError('err-inv-discount', 'Discount cannot be negative.');
        $('#inv-invoice-discount').addClass('is-invalid');
        valid = false;
    } else if (invoiceDiscount > subTotal) {
        showFieldError('err-inv-discount', 'Discount cannot exceed sub total.');
        $('#inv-invoice-discount').addClass('is-invalid');
        valid = false;
    }

    return valid;
}

/* ---------- Save ---------- */
/*function saveInvoice() {
    if (!validateInvoiceForm()) return;
    if (typeof PROJECT === 'undefined' || !PROJECT.id) { alert('Project context missing.'); return; }

    const payload = invItems.map(it => ({
        product_id: it.product_id,
        product_name: it.product_name,
        product_code: it.product_code,
        unit_price: it.unit_price,
        qty: it.qty,
        discount: it.discount
    }));

    $.post('<?= site_url("Projects/save_invoice") ?>', {
        project_id: PROJECT.id,
        invoice_date: $('#inv-date').val(),
        due_date: $('#inv-due-date').val(),
        paid_amount: $('#inv-paid').val(),
        invoice_discount: $('#inv-invoice-discount').val(),
        notes: $('#inv-notes').val(),
        items: JSON.stringify(payload)
    }, function(res) {
        if (res.status) {
            $('#invoiceModal').modal('hide');
            if (typeof window._invoiceSaveCallback === 'function') {
                window._invoiceSaveCallback();
            } else {
                loadProjectInvoices();
            }
            if (typeof logAct === 'function') logAct('payment', '#10b981', 'Invoice created', 'Admin');
            if (typeof toast === 'function') toast('Invoice saved', 's');
        } else {
            alert(res.message || 'Failed to save invoice.');
        }
    }, 'json');
}*/

/*function saveInvoice() {

    if (!validateInvoiceForm()) return;

    if (typeof PROJECT === 'undefined' || !PROJECT.id) {
        alert('Project context missing.');
        return;
    }

    if (!invItems || invItems.length === 0) {
        alert('Please add at least one item.');
        return;
    }

    const payload = invItems.map(it => ({
        product_id: it.product_id,
        product_name: it.product_name,
        product_code: it.product_code || '',
        unit_price: parseFloat(it.unit_price) || 0,
        qty: parseFloat(it.qty) || 0,
        discount: parseFloat(it.discount) || 0
    }));

    const paidAmount = parseFloat($('#inv-paid').val()) || 0;

    $.ajax({
        url: '<?= site_url("Projects/save_invoice") ?>',
        type: 'POST',
        dataType: 'json',

        data: {
            project_id: PROJECT.id,

            // These should exist in PROJECT
            customer_id: PROJECT.customer_id || 0,
            warehouse_id: PROJECT.warehouse_id || 0,
            branch_id: PROJECT.branch_id || 0,

            invoice_date: $('#inv-date').val(),
            due_date: $('#inv-due-date').val(),

            paid_amount: paidAmount,

            invoice_discount: parseFloat(
                $('#inv-invoice-discount').val()
            ) || 0,

            notes: $('#inv-notes').val(),

            items: JSON.stringify(payload)
        },

        beforeSend: function () {
            $('.siv-btn-save')
                .prop('disabled', true)
                .html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');
        },

        success: function (res) {

            if (res.status) {

                $('#invoiceModal').modal('hide');

                if (typeof window._invoiceSaveCallback === 'function') {
                    window._invoiceSaveCallback();
                } else {
                    loadProjectInvoices();
                }

                if (typeof logAct === 'function') {
                    logAct(
                        'payment',
                        '#10b981',
                        'Invoice created',
                        'Admin'
                    );
                }

                if (typeof toast === 'function') {
                    toast('Invoice saved successfully', 's');
                }

            } else {

                alert(res.message || 'Failed to save invoice.');
            }
        },
		
        error: function (xhr) {

            console.error(xhr.responseText);

            let message = 'An error occurred while saving invoice.';

            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    message = response.message;
                }
            } catch (e) {}

            alert(message);
        },

        complete: function () {

            $('.siv-btn-save')
                .prop('disabled', false)
                .html('<i class="fa-solid fa-floppy-disk"></i> Save Invoice');
        }
    });
}*/
/* ============================================================
   SAVE INVOICE
============================================================ */

function saveInvoice() {

    /*if (!validateInvoiceForm()) {
        return;
    }*/
	
	 if (!validateInvoiceForm()) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Project validation
    |--------------------------------------------------------------------------
    */

    if (
        typeof PROJECT === 'undefined' ||
        !PROJECT.id
    ) {

        alert('Project context missing.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Items validation
    |--------------------------------------------------------------------------
    */

    if (
        typeof invItems === 'undefined' ||
        !invItems ||
        invItems.length === 0
    ) {

        alert('Please add at least one item.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Payment validation
    |--------------------------------------------------------------------------
    */

    if (!validateInvoicePayments()) {
        return;
    }
	

    /*
    |--------------------------------------------------------------------------
    | Project validation
    |--------------------------------------------------------------------------
    */

    if (
        typeof PROJECT === 'undefined' ||
        !PROJECT.id
    ) {

        alert('Project context missing.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Items validation
    |--------------------------------------------------------------------------
    */

    if (
        typeof invItems === 'undefined' ||
        !invItems ||
        invItems.length === 0
    ) {

        alert('Please add at least one item.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Payment validation
    |--------------------------------------------------------------------------
    */

    if (!validateInvoicePayments()) {

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Prepare invoice items
    |--------------------------------------------------------------------------
    */

    const payload = invItems.map(function (it) {

        return {

            product_id: it.product_id,

            product_name: it.product_name,

            product_code: it.product_code || '',

            unit_price:
                parseFloat(it.unit_price) || 0,

            qty:
                parseFloat(it.qty) || 0,

            discount:
                parseFloat(it.discount) || 0

        };

    });


    /*
    |--------------------------------------------------------------------------
    | Prepare payment methods
    |--------------------------------------------------------------------------
    */

    const payments = [];


    $('.siv-payment-row').each(function () {

        const row = $(this);

        const method =
            row.find('.invoice-payment-method').val();

        const amount =
            parseFloat(
                row.find('.invoice-payment-amount').val()
            ) || 0;


        if (!method || amount <= 0) {
            return;
        }


        const payment = {

            payment_method: method,

            amount: amount,

            card_number: null,

            card_expiry: null,

            cheque_no: null,

            cheque_date: null,

            bank_name: null,

            reference_no: null

        };


        /*
        |--------------------------------------------------------------------------
        | CARD
        |--------------------------------------------------------------------------
        */

        if (method === 'CARD') {

            payment.card_number =
                row.find('.invoice-card-number')
                    .val()
                    .replace(/\s/g, '');

            payment.card_expiry =
                row.find('.invoice-card-expiry')
                    .val()
                    .trim();

        }


        /*
        |--------------------------------------------------------------------------
        | BANK
        |--------------------------------------------------------------------------
        */

        if (method === 'BANK') {

            payment.bank_name =
                row.find('.invoice-bank-name')
                    .val()
                    .trim();

            payment.reference_no =
                row.find('.invoice-bank-reference')
                    .val()
                    .trim();

        }


        /*
        |--------------------------------------------------------------------------
        | CHEQUE
        |--------------------------------------------------------------------------
        */

        if (method === 'CHEQUE') {

            payment.cheque_no =
                row.find('.invoice-cheque-number')
                    .val()
                    .trim();

            payment.cheque_date =
                row.find('.invoice-cheque-date')
                    .val();

        }


        payments.push(payment);

    });


    /*
    |--------------------------------------------------------------------------
    | Total paid
    |--------------------------------------------------------------------------
    */

    let paidAmount = 0;

    payments.forEach(function (payment) {

        paidAmount +=
            parseFloat(payment.amount) || 0;

    });


    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */
	
    $.ajax({

        url: '<?= site_url("Projects/save_invoice") ?>',

        type: 'POST',

        dataType: 'json',

        data: {
            project_id: PROJECT.id,
            //customer_id:PROJECT.customer_id || 0,
            customer_id:$('#cust-sel').val(),
            warehouse_id:PROJECT.warehouse_id || 0,
            branch_id:PROJECT.branch_id || 0,
            invoice_date:$('#inv-date').val(),
            due_date:$('#inv-due-date').val(), 
			cus_id: $('#cust-sel').val(),
            paid_amount:paidAmount,
            invoice_discount:parseFloat($('#inv-invoice-discount').val()) || 0,
            notes:$('#inv-notes').val(),
            items:JSON.stringify(payload),
            payments:JSON.stringify(payments)
        },


        beforeSend: function () {

            $('.siv-btn-save')
                .prop('disabled', true)
                .html(
                    '<i class="fa-solid fa-spinner fa-spin"></i> Saving...'
                );

        },


        success: function (res) {

            if (res.status) {

                $('#invoiceModal').modal('hide');


                if (
                    typeof window._invoiceSaveCallback ===
                    'function'
                ) {

                    window._invoiceSaveCallback();

                } else {

                    loadProjectInvoices();

                }


                if (typeof logAct === 'function') {

                    logAct(
                        'payment',
                        '#10b981',
                        'Invoice created',
                        'Admin'
                    );

                }


                if (typeof toast === 'function') {

                    toast(
                        'Invoice saved successfully',
                        's'
                    );

                }

            } else {

                alert(
                    res.message ||
                    'Failed to save invoice.'
                );

            }

        },


        error: function (xhr) {

            console.error(xhr.responseText);

            let message =
                'An error occurred while saving invoice.';


            try {

                const response =
                    JSON.parse(xhr.responseText);

                if (response.message) {

                    message =
                        response.message;

                }

            } catch (e) {}


            alert(message);

        },


        complete: function () {

            $('.siv-btn-save')
                .prop('disabled', false)
                .html(
                    '<i class="fa-solid fa-floppy-disk"></i> Save Invoice'
                );

        }

    });

}



/* ═══════════════════════════════════════
   VIEW / PRINT SINGLE INVOICE
   ═══════════════════════════════════════ */
function viewInvoice(invoice_id) {
    currentViewInvoiceId = invoice_id;
    $.getJSON('<?= site_url("Projects/view_invoice") ?>/' + invoice_id, function(res) {
        if (!res.status) { alert('Invoice not found.'); return; }
        const inv = res.invoice;

        let rows = inv.items.map(it => `
          <tr>
            <td>${it.product_name}</td>
            <td>${it.product_code || ''}</td>
            <td class="r">${parseFloat(it.unit_price).toFixed(2)}</td>
            <td class="r">${it.qty}</td>
            <td class="r">${parseFloat(it.discount).toFixed(2)}</td>
            <td class="r">${parseFloat(it.line_total).toFixed(2)}</td>
          </tr>`).join('');

        $('#view-invoice-body').html(`
          <p><b>Invoice No:</b> ${inv.invoice_no} &nbsp; <b>Date:</b> ${inv.invoice_date} &nbsp; <b>Due:</b> ${inv.due_date || '-'}</p>
          <p><b>Status:</b> <span class="siv-status-badge status-${inv.status}">${inv.status}</span></p>
          <table class="siv-table">
            <thead><tr><th>Product</th><th>Code</th><th class="r">Price</th><th class="r">Qty</th><th class="r">Discount</th><th class="r">Total</th></tr></thead>
            <tbody>${rows}</tbody>
          </table>
          <p class="r" style="margin-top:10px;">
            <b>Sub Total:</b> ${parseFloat(inv.sub_total).toFixed(2)} &nbsp;
            <b>Invoice Discount:</b> ${parseFloat(inv.discount).toFixed(2)} &nbsp;
            <b>Grand Total:</b> ${parseFloat(inv.grand_total).toFixed(2)} &nbsp;
            <b>Paid:</b> ${parseFloat(inv.paid_amount).toFixed(2)} &nbsp;
            <b>Balance:</b> ${parseFloat(inv.balance).toFixed(2)}
          </p>
          ${inv.notes ? '<p><b>Notes:</b> ' + inv.notes + '</p>' : ''}
        `);
        $('#viewInvoiceModal').modal('show');
    });
}

function printCurrentInvoice() {
    if (!currentViewInvoiceId) return;
    window.open('<?= site_url("/Projects/print_invoice") ?>/' + currentViewInvoiceId, '_blank');
}

function printInvoiceDirect(invoice_id) {
    window.open('<?= site_url("/Projects/print_invoice?inv_id=") ?>' + invoice_id, '_blank');
}
	function printDo(act_id) {
		window.open('<?= site_url("/Projects/print_Do?act_id=") ?>' + act_id, '_blank');
	}
 
//script for new invoice function 



		/* ============================================================
		   PROJECT INVOICE PAYMENTS
		============================================================ */

		let invoicePaymentIndex = 0;


		/*
		|--------------------------------------------------------------------------
		| Add Payment Row
		|--------------------------------------------------------------------------
		*/

		function addInvoicePaymentRow() {

			const container = $('#invoicePaymentsContainer');

			const rowId = invoicePaymentIndex++;

			const html = `
				<div class="siv-payment-row"
					 id="invoicePaymentRow_${rowId}"
					 data-payment-index="${rowId}">

					<div class="siv-payment-row-header">

						<div class="siv-payment-row-title">
							Payment ${rowId + 1}
						</div>

						<button type="button"
								class="siv-payment-remove"
								onclick="removeInvoicePaymentRow(${rowId})">

							<i class="fa-solid fa-trash"></i>
							Remove

						</button>

					</div>


					<div class="siv-payment-fields">

						<div class="siv-field">

							<label>
								Payment Method
								<span class="req">*</span>
							</label>

							<select class="siv-input invoice-payment-method"
									onchange="changeInvoicePaymentMethod(${rowId})">

								<option value="">Select Method</option>
								<option value="CASH">Cash</option>
								<option value="CARD">Card</option>
								<option value="BANK">Bank</option>
								<option value="CHEQUE">Cheque</option>

							</select>

							<span class="siv-error payment-method-error"></span>

						</div>


						<div class="siv-field">

							<label>
								Amount
								<span class="req">*</span>
							</label>

							<div class="siv-prefix-input">

								<span>Rs.</span>

								<input type="number"
									   class="siv-input invoice-payment-amount"
									   value="0"
									   min="0"
									   step="0.01"
									   oninput="calculateInvoicePayments()">

							</div>

							<span class="siv-error payment-amount-error"></span>

						</div>

					</div>


					<!-- CARD FIELDS -->

					<div class="siv-payment-extra invoice-card-fields"
						 style="display:none;">

						<div class="siv-payment-fields">

							<div class="siv-field">

								<label>
									Card Number
									<span class="req">*</span>
								</label>

								<input type="text"
									   class="siv-input invoice-card-number"
									   maxlength="19"
									   placeholder="XXXX XXXX XXXX XXXX">

								<span class="siv-error card-number-error"></span>

							</div>


							<div class="siv-field">

								<label>
									Expire Date
									<span class="req">*</span>
								</label>

								<input type="text"
									   class="siv-input invoice-card-expiry"
									   maxlength="5"
									   placeholder="MM/YY">

								<span class="siv-error card-expiry-error"></span>

							</div>

							<div class="siv-field"></div>

						</div>

					</div>


					<!-- BANK FIELDS -->

					<div class="siv-payment-extra invoice-bank-fields"
						 style="display:none;">

						<div class="siv-payment-fields">

							<div class="siv-field">

								<label>
									Bank Name
								</label>

								<input type="text"
									   class="siv-input invoice-bank-name"
									   placeholder="Bank name">

							</div>


							<div class="siv-field">

								<label>
									Reference No.
								</label>

								<input type="text"
									   class="siv-input invoice-bank-reference"
									   placeholder="Transaction reference">

							</div>

							<div class="siv-field"></div>

						</div>

					</div>


					<!-- CHEQUE FIELDS -->

					<div class="siv-payment-extra invoice-cheque-fields"
						 style="display:none;">

						<div class="siv-payment-fields">

							<div class="siv-field">

								<label>
									Cheque Number
									<span class="req">*</span>
								</label>

								<input type="text"
									   class="siv-input invoice-cheque-number"
									   placeholder="Cheque number">

								<span class="siv-error cheque-number-error"></span>

							</div>


							<div class="siv-field">

								<label>
									Cheque Date
									<span class="req">*</span>
								</label>

								<input type="date"
									   class="siv-input invoice-cheque-date">

								<span class="siv-error cheque-date-error"></span>

							</div>

							<div class="siv-field"></div>

						</div>

					</div>

				</div>
			`;

			container.append(html);

			calculateInvoicePayments();
		}


		/*
		|--------------------------------------------------------------------------
		| Remove Payment Row
		|--------------------------------------------------------------------------
		*/

		function removeInvoicePaymentRow(rowId) {

			$('#invoicePaymentRow_' + rowId).remove();

			calculateInvoicePayments();
		}


		/*
		|--------------------------------------------------------------------------
		| Payment Method Change
		|--------------------------------------------------------------------------
		*/

		function changeInvoicePaymentMethod(rowId) {

			const row = $('#invoicePaymentRow_' + rowId);

			const method = row.find('.invoice-payment-method').val();


			row.find('.invoice-card-fields').hide();
			row.find('.invoice-bank-fields').hide();
			row.find('.invoice-cheque-fields').hide();


			if (method === 'CARD') {

				row.find('.invoice-card-fields').show();

			} else if (method === 'BANK') {

				row.find('.invoice-bank-fields').show();

			} else if (method === 'CHEQUE') {

				row.find('.invoice-cheque-fields').show();

			}


			calculateInvoicePayments();
		}


		/*
		|--------------------------------------------------------------------------
		| Calculate Payment Totals
		|--------------------------------------------------------------------------
		*/

		function calculateInvoicePayments() {

			let totalPaid = 0;

			$('.invoice-payment-amount').each(function () {

				const amount = parseFloat($(this).val()) || 0;

				totalPaid += amount;

			});


			/*
			|--------------------------------------------------------------------------
			| Get Grand Total
			|--------------------------------------------------------------------------
			*/

			const grandTotalText = $('#sum-grand').text()
				.replace(/Rs\./g, '')
				.replace(/,/g, '')
				.trim();

			const grandTotal = parseFloat(grandTotalText) || 0;

			let balance = grandTotal - totalPaid;

			if (balance < 0) {
				balance = 0;
			}


			$('#payment-total-due').text(
				'Rs. ' + grandTotal.toFixed(2)
			);

			$('#payment-total-paid').text(
				'Rs. ' + totalPaid.toFixed(2)
			);

			$('#payment-total-balance').text(
				'Rs. ' + balance.toFixed(2)
			);


			/*
			|--------------------------------------------------------------------------
			| Update Main Summary
			|--------------------------------------------------------------------------
			*/

			$('#sum-paid').text(
				'Rs. ' + totalPaid.toFixed(2)
			);


			/*
			|--------------------------------------------------------------------------
			| Payment Status
			|--------------------------------------------------------------------------
			*/

			let status = 'Unpaid';

			if (totalPaid > 0 && totalPaid < grandTotal) {

				status = 'Partial';

			} else if (grandTotal > 0 && totalPaid >= grandTotal) {

				status = 'Paid';

			}


			$('#inv-payment-status-badge').text(status);


			/*
			|--------------------------------------------------------------------------
			| Prevent over payment visually
			|--------------------------------------------------------------------------
			*/

			const balanceElement = $('#payment-total-balance');

			balanceElement.removeClass(
				'siv-payment-balance-warning siv-payment-balance-success'
			);

			if (totalPaid > grandTotal) {

				balanceElement.addClass(
					'siv-payment-balance-warning'
				);

			} else {

				balanceElement.addClass(
					'siv-payment-balance-success'
				);

			}

		}


		/*
		|--------------------------------------------------------------------------
		| Card Number Formatting
		|--------------------------------------------------------------------------
		*/

		$(document).on(
			'input',
			'.invoice-card-number',
			function () {

				let value = $(this)
					.val()
					.replace(/\D/g, '');

				value = value.substring(0, 16);

				let formatted = value.match(/.{1,4}/g);

				$(this).val(
					formatted ? formatted.join(' ') : ''
				);
			}
		);


		/*
		|--------------------------------------------------------------------------
		| Card Expiry Formatting
		|--------------------------------------------------------------------------
		*/

		$(document).on(
			'input',
			'.invoice-card-expiry',
			function () {

				let value = $(this)
					.val()
					.replace(/\D/g, '')
					.substring(0, 4);

				if (value.length >= 3) {

					value =
						value.substring(0, 2) +
						'/' +
						value.substring(2);

				}

				$(this).val(value);
			}
		);



		/* ============================================================
		   VALIDATE PAYMENTS
		============================================================ */

		// function validateInvoicePayments() {

			// $('#err-payments').text('');

			// let valid = true;

			// let totalPaid = 0;

			// const grandTotalText = $('#sum-grand')
				// .text()
				// .replace(/Rs\./g, '')
				// .replace(/,/g, '')
				// .trim();

			// const grandTotal = parseFloat(grandTotalText) || 0;


			// const rows = $('.siv-payment-row');

			// /*
			// |--------------------------------------------------------------------------
			// | No payment is also allowed
			// |--------------------------------------------------------------------------
			// */

			// if (rows.length === 0) {

				// return true;
			// }


			// rows.each(function () {

				// const row = $(this);

				// const method = row
					// .find('.invoice-payment-method')
					// .val();

				// const amount = parseFloat(
					// row.find('.invoice-payment-amount').val()
				// ) || 0;


				// /*
				// |--------------------------------------------------------------------------
				// | Method
				// |--------------------------------------------------------------------------
				// */

				// if (!method) {

					// row.find('.payment-method-error')
						// .text('Please select a payment method.');

					// valid = false;

				// } else {

					// row.find('.payment-method-error')
						// .text('');
				// }


				// /*
				// |--------------------------------------------------------------------------
				// | Amount
				// |--------------------------------------------------------------------------
				// */

				// if (amount <= 0) {

					// row.find('.payment-amount-error')
						// .text('Payment amount must be greater than 0.');

					// valid = false;

				// } else {

					// row.find('.payment-amount-error')
						// .text('');
				// }


				// totalPaid += amount;


				// /*
				// |--------------------------------------------------------------------------
				// | CARD
				// |--------------------------------------------------------------------------
				// */

				// if (method === 'CARD') {

					// const cardNumber = row
						// .find('.invoice-card-number')
						// .val()
						// .replace(/\s/g, '');

					// const expiry = row
						// .find('.invoice-card-expiry')
						// .val()
						// .trim();


					// /*
					// | Card number
					// */

					// if (!/^\d{16}$/.test(cardNumber)) {

						// row.find('.card-number-error')
							// .text('Enter a valid 16 digit card number.');

						// valid = false;

					// } else {

						// row.find('.card-number-error')
							// .text('');
					// }


					// /*
					// | Expiry
					// */

					// if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {

						// row.find('.card-expiry-error')
							// .text('Enter expiry as MM/YY.');

						// valid = false;

					// } else {

						// const parts = expiry.split('/');

						// const month = parseInt(parts[0], 10);

						// const year = 2000 + parseInt(parts[1], 10);

						// const today = new Date();

						// const currentMonth =
							// today.getMonth() + 1;

						// const currentYear =
							// today.getFullYear();


						// if (
							// year < currentYear ||
							// (
								// year === currentYear &&
								// month < currentMonth
							// )
						// ) {

							// row.find('.card-expiry-error')
								// .text('Card has expired.');

							// valid = false;

						// } else {

							// row.find('.card-expiry-error')
								// .text('');
						// }

					// }

				// }


				// /*
				// |--------------------------------------------------------------------------
				// | CHEQUE
				// |--------------------------------------------------------------------------
				// */

				// if (method === 'CHEQUE') {

					// const chequeNumber = row
						// .find('.invoice-cheque-number')
						// .val()
						// .trim();

					// const chequeDate = row
						// .find('.invoice-cheque-date')
						// .val();


					// /*
					// | Cheque number
					// */

					// if (!chequeNumber) {

						// row.find('.cheque-number-error')
							// .text('Cheque number is required.');

						// valid = false;

					// } else {

						// row.find('.cheque-number-error')
							// .text('');
					// }


					// /*
					// | Cheque date
					// */

					// if (!chequeDate) {

						// row.find('.cheque-date-error')
							// .text('Cheque date is required.');

						// valid = false;

					// } else {

						// row.find('.cheque-date-error')
							// .text('');
					// }

				// }

			// });


			// /*
			// |--------------------------------------------------------------------------
			// | Payment Cannot Exceed Invoice Total
			// |--------------------------------------------------------------------------
			// */

			// if (totalPaid > grandTotal + 0.001) {

				// $('#err-payments').text(
					// 'Total payment cannot exceed the invoice grand total.'
				// );

				// valid = false;
			// }


			// /*
			// |--------------------------------------------------------------------------
			// | Payment Amount
			// |--------------------------------------------------------------------------
			// */

			// if (totalPaid > 0) {

				// const remaining =
					// grandTotal - totalPaid;

				// if (remaining < -0.001) {

					// $('#err-payments').text(
						// 'Payment amount exceeds invoice total.'
					// );

					// valid = false;
				// }

			// }


			// return valid;
		// }
		function validateInvoicePayments() {

			var cus = $('#cust-sel').val();
			if(cus == ''){
				alert('please Select customer');
				return;
			}
			
			$('#err-payments').text('');

			let valid = true;
			let totalPaid = 0;
			let hasPaymentMethod = false;

			/*
			|--------------------------------------------------------------------------
			| Get Invoice Grand Total
			|--------------------------------------------------------------------------
			*/

			const grandTotalText = $('#sum-grand')
				.text()
				.replace(/Rs\./g, '')
				.replace(/,/g, '')
				.trim();

			const grandTotal = parseFloat(grandTotalText) || 0;


			/*
			|--------------------------------------------------------------------------
			| Payment Rows
			|--------------------------------------------------------------------------
			*/

			const rows = $('.siv-payment-row');


			/*
			|--------------------------------------------------------------------------
			| AT LEAST ONE PAYMENT METHOD REQUIRED
			|--------------------------------------------------------------------------
			*/

			if (rows.length === 0) {

				$('#err-payments').text(
					'Please add at least one payment method.'
				);

				return false;
			}


			/*
			|--------------------------------------------------------------------------
			| Validate Each Payment Row
			|--------------------------------------------------------------------------
			*/

			rows.each(function () {

				const row = $(this);

				const method = row
					.find('.invoice-payment-method')
					.val();

				const amount = parseFloat(
					row.find('.invoice-payment-amount').val()
				) || 0;


				/*
				|--------------------------------------------------------------------------
				| Method Required
				|--------------------------------------------------------------------------
				*/

				if (!method) {

					row.find('.payment-method-error')
						.text('Please select a payment method.');

					valid = false;

				} else {

					row.find('.payment-method-error')
						.text('');

					/*
					| At least one valid payment method
					*/

					if (amount > 0) {
						hasPaymentMethod = true;
					}
				}


				/*
				|--------------------------------------------------------------------------
				| Amount Required
				|--------------------------------------------------------------------------
				*/

				if (amount <= 0) {

					row.find('.payment-amount-error')
						.text('Payment amount must be greater than 0.');

					valid = false;

				} else {

					row.find('.payment-amount-error')
						.text('');
				}


				totalPaid += amount;


				/*
				|--------------------------------------------------------------------------
				| CARD VALIDATION
				|--------------------------------------------------------------------------
				*/

				if (method === 'CARD') {

					const cardNumber = row
						.find('.invoice-card-number')
						.val()
						.replace(/\s/g, '');

					const expiry = row
						.find('.invoice-card-expiry')
						.val()
						.trim();


					/*
					| Card Number
					*/

					if (!/^\d{16}$/.test(cardNumber)) {

						row.find('.card-number-error')
							.text('Enter a valid 16 digit card number.');

						valid = false;

					} else {

						row.find('.card-number-error')
							.text('');
					}


					/*
					| Card Expiry
					*/

					if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {

						row.find('.card-expiry-error')
							.text('Enter expiry as MM/YY.');

						valid = false;

					} else {

						const parts = expiry.split('/');

						const month = parseInt(parts[0], 10);

						const year = 2000 + parseInt(parts[1], 10);

						const today = new Date();

						const currentMonth =
							today.getMonth() + 1;

						const currentYear =
							today.getFullYear();


						if (
							year < currentYear ||
							(
								year === currentYear &&
								month < currentMonth
							)
						) {

							row.find('.card-expiry-error')
								.text('Card has expired.');

							valid = false;

						} else {

							row.find('.card-expiry-error')
								.text('');
						}
					}
				}


				/*
				|--------------------------------------------------------------------------
				| CHEQUE VALIDATION
				|--------------------------------------------------------------------------
				*/

				if (method === 'CHEQUE') {

					const chequeNumber = row
						.find('.invoice-cheque-number')
						.val()
						.trim();

					const chequeDate = row
						.find('.invoice-cheque-date')
						.val();


					/*
					| Cheque Number
					*/

					if (!chequeNumber) {

						row.find('.cheque-number-error')
							.text('Cheque number is required.');

						valid = false;

					} else {

						row.find('.cheque-number-error')
							.text('');
					}


					/*
					| Cheque Date
					*/

					if (!chequeDate) {

						row.find('.cheque-date-error')
							.text('Cheque date is required.');

						valid = false;

					} else {

						row.find('.cheque-date-error')
							.text('');
					}
				}

			});


			/*
			|--------------------------------------------------------------------------
			| AT LEAST ONE PAYMENT WITH AMOUNT
			|--------------------------------------------------------------------------
			*/

			if (!hasPaymentMethod) {

				$('#err-payments').text(
					'Please add at least one payment method with a valid amount.'
				);

				valid = false;
			}


			/*
			|--------------------------------------------------------------------------
			| Payment Cannot Exceed Invoice Total
			|--------------------------------------------------------------------------
			*/

			if (totalPaid > grandTotal + 0.001) {

				$('#err-payments').text(
					'Total payment cannot exceed the invoice grand total.'
				);

				valid = false;
			}


			/*
			|--------------------------------------------------------------------------
			| Return Validation Result
			|--------------------------------------------------------------------------
			*/

			return valid;
		}

		














</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="<?= base_url('assets/js/sales-dashboard.js') ?>"></script>