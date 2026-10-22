<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>New Hire Purchase — Rixzo ERP</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
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
  --page-bg:#f0f2f9;--card-bg:#fff;--card-border:#e4e9f4;
  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
  --input-border:#d1d9e6;
  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.10);--sh-lg:0 8px 36px rgba(61,82,160,.16);
  --r-sm:8px;--r-md:12px;--r-lg:16px;
  --sidebar-w:240px;--header-h:60px;--tr:.2s cubic-bezier(.4,0,.2,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;}
::-webkit-scrollbar{width:5px;}::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

/* SIDEBAR */
.sidebar{position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-w);background:var(--sidebar-bg);z-index:100;display:flex;flex-direction:column;}
.sb-logo{height:var(--header-h);display:flex;align-items:center;padding:0 18px;border-bottom:1px solid rgba(255,255,255,.06);}
.logo-m{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;font-size:15px;color:#fff;font-weight:800;flex-shrink:0;}
.logo-t{margin-left:10px;color:#fff;font-weight:700;font-size:15px;}.logo-t span{color:#7b8dd1;}
.sb-nav{flex:1;overflow-y:auto;padding:10px 0;}
.sb-cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(168,180,216,.4);padding:14px 18px 5px;}
.sb-link{display:flex;align-items:center;gap:10px;padding:9px 18px;color:var(--sidebar-text);text-decoration:none;font-size:13px;font-weight:500;cursor:pointer;transition:all var(--tr);}
.sb-link i{font-size:15px;width:18px;text-align:center;flex-shrink:0;}
.sb-link:hover{background:rgba(255,255,255,.05);color:#fff;}
.sb-link.active{background:rgba(61,82,160,.28);color:#fff;border-right:3px solid #7b8dd1;}

/* HEADER */
.header{position:fixed;top:0;left:var(--sidebar-w);right:0;height:var(--header-h);background:#fff;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;padding:0 22px;z-index:90;box-shadow:var(--sh-sm);}
.hdr-l{display:flex;align-items:center;gap:14px;}
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
.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:20px 24px 60px;}

/* BUTTONS */
.btn{padding:9px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;gap:7px;}
.btn-primary{background:var(--primary);color:#fff;box-shadow:0 2px 8px rgba(61,82,160,.25);}
.btn-primary:hover{background:var(--primary-d);transform:translateY(-1px);}
.btn-success{background:var(--success);color:#fff;box-shadow:0 2px 8px rgba(16,185,129,.2);}
.btn-success:hover{background:var(--success-d);transform:translateY(-1px);}
.btn-outline{background:#fff;color:var(--text-mid);border:1.5px solid var(--card-border);}
.btn-outline:hover{border-color:var(--primary);color:var(--primary);}
.btn-danger-o{background:#fff;color:var(--danger);border:1.5px solid #fca5a5;}
.btn-danger-o:hover{background:var(--danger);color:#fff;}
.btn-sm{padding:7px 12px;font-size:12px;}
.btn:disabled{opacity:.35;cursor:not-allowed;transform:none!important;}

/* STEP WIZARD */
.wizard-bar{display:flex;align-items:center;gap:0;background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:16px 20px;margin-bottom:18px;box-shadow:var(--sh-sm);position:relative;}
.step{display:flex;align-items:center;gap:10px;flex:1;position:relative;}
.step:not(:last-child)::after{content:'';position:absolute;left:calc(50% + 24px);right:0;top:18px;height:2px;background:var(--card-border);z-index:0;}
.step.done:not(:last-child)::after{background:var(--primary-mid);}
.step-num{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;flex-shrink:0;position:relative;z-index:1;transition:all var(--tr);}
.step.pending .step-num{background:var(--page-bg);border:2px solid var(--card-border);color:var(--text-muted);}
.step.active .step-num{background:var(--primary);color:#fff;box-shadow:0 0 0 4px var(--primary-light);}
.step.done .step-num{background:var(--success);color:#fff;}
.step-text{flex:1;}
.step-text .st-lbl{font-size:12px;font-weight:800;color:var(--text-dark);}
.step.pending .step-text .st-lbl{color:var(--text-muted);}
.step.active .step-text .st-lbl{color:var(--primary);}
.step.done .step-text .st-lbl{color:var(--success);}
.step-text .st-sub{font-size:10px;color:var(--text-muted);font-weight:500;margin-top:1px;}

/* SECTION CARD */
.sec-card{overflow: visible !important;background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);margin-bottom:14px;overflow:hidden;}
.sec-head{padding:13px 18px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:10px;}
.sec-icon{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;}
.sec-head h5{font-size:13px;font-weight:800;color:var(--text-dark);margin:0;flex:1;letter-spacing:-.1px;}
.sec-head .sec-sub{font-size:11px;color:var(--text-muted);font-weight:500;}
.sec-body{padding:16px 18px;}

/* FORM GRID */
.fg{display:grid;gap:14px;}
.fg-2{grid-template-columns:1fr 1fr;}
.fg-3{grid-template-columns:1fr 1fr 1fr;}
.fg-4{grid-template-columns:1fr 1fr 1fr 1fr;}
.fld{display:flex;flex-direction:column;gap:5px;}
.fld label{font-size:12px;font-weight:700;color:var(--text-mid);display:flex;align-items:center;gap:5px;}
.fld label .req{color:var(--danger);font-size:13px;line-height:1;}
.fc{padding:8px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;background:#fff;transition:border-color var(--tr);width:100%;}
.fc:focus{border-color:var(--primary);}
.fc:disabled{background:var(--page-bg);color:var(--text-muted);cursor:not-allowed;}
.fc.readonly{background:#f7f9ff;border-style:dashed;color:var(--text-mid);}
.input-ic{position:relative;}
.input-ic .fc{padding-left:34px;}
.input-ic i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:13px;pointer-events:none;}
.input-sfx{position:relative;}
.input-sfx .fc{padding-right:50px;}
.input-sfx .sfx{position:absolute;right:10px;top:50%;transform:translateY(-50%);font-size:11px;font-weight:700;color:var(--text-muted);}
.fld-hint{font-size:11px;color:var(--text-muted);font-weight:500;}
.fld-err{font-size:11px;color:var(--danger);font-weight:600;display:none;}

/* INVOICE SEARCH BOX */
.inv-search-wrap{position:relative;z-index: 100; }
.inv-results{position:absolute;top:calc(100% + 4px);left:0;right:0;background:#fff;border:1.5px solid var(--primary);border-radius:var(--r-sm);box-shadow:var(--sh-md);z-index:1000;max-height:240px;overflow-y:auto;display:none;}
.inv-results.show{display:block;}
.inv-result-item{padding:10px 14px;cursor:pointer;transition:background var(--tr);border-bottom:1px solid var(--card-border);}
.inv-result-item:last-child{border-bottom:none;}
.inv-result-item:hover{background:var(--primary-light);}
.ir-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:3px;}
.ir-no{font-size:12px;font-weight:800;color:var(--primary);font-family:'JetBrains Mono',monospace;}
.ir-amt{font-size:12px;font-weight:800;color:var(--text-dark);font-family:'JetBrains Mono',monospace;}
.ir-bot{font-size:11px;color:var(--text-muted);font-weight:500;display:flex;gap:10px;}
.inv-tag{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;}
.tag-unsettled{background:var(--warning-light);color:#92400e;}
.tag-partial{background:var(--orange-light);color:#c2410c;}

/* SELECTED INVOICE PILL */
.sel-inv{background:var(--primary-light);border:1.5px solid var(--primary-mid);border-radius:var(--r-sm);padding:10px 14px;display:flex;align-items:center;gap:12px;}
.si-ico{width:32px;height:32px;border-radius:8px;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0;}
.si-info{flex:1;}
.si-no{font-size:13px;font-weight:800;color:var(--primary);font-family:'JetBrains Mono',monospace;}
.si-meta{font-size:11px;color:var(--text-muted);font-weight:500;margin-top:2px;}
.si-amt{text-align:right;}
.si-amt-val{font-size:15px;font-weight:800;color:var(--text-dark);font-family:'JetBrains Mono',monospace;}
.si-amt-lbl{font-size:10px;color:var(--text-muted);font-weight:600;text-align:right;}
.si-rm{width:26px;height:26px;border-radius:6px;border:1px solid #fca5a5;background:#fff;cursor:pointer;color:var(--danger);display:flex;align-items:center;justify-content:center;font-size:11px;transition:all var(--tr);}
.si-rm:hover{background:var(--danger);color:#fff;}

/* PLAN CARDS */
.plan-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;}
.plan-card{border:2px solid var(--card-border);border-radius:var(--r-md);padding:14px;cursor:pointer;transition:all var(--tr);position:relative;background:#fff;}
.plan-card:hover{border-color:var(--primary-mid);box-shadow:var(--sh-sm);}
.plan-card.selected{border-color:var(--primary);background:var(--primary-light);box-shadow:0 0 0 3px var(--primary-light);}
.plan-check{position:absolute;top:10px;right:10px;width:20px;height:20px;border-radius:50%;border:2px solid var(--card-border);background:#fff;display:flex;align-items:center;justify-content:center;font-size:9px;color:transparent;transition:all var(--tr);}
.plan-card.selected .plan-check{border-color:var(--primary);background:var(--primary);color:#fff;}
.plan-months{font-size:24px;font-weight:800;color:var(--text-dark);font-family:'JetBrains Mono',monospace;line-height:1;}
.plan-months span{font-size:12px;font-weight:600;color:var(--text-muted);margin-left:2px;}
.plan-name{font-size:12px;font-weight:700;color:var(--text-mid);margin-top:4px;}
.plan-rate{font-size:11px;font-weight:600;margin-top:8px;padding:3px 8px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;}
.rate-int{background:var(--warning-light);color:#92400e;}
.rate-free{background:var(--success-light);color:#065f46;}
.plan-dp{font-size:11px;color:var(--text-muted);font-weight:600;margin-top:6px;}
.plan-card.selected .plan-name{color:var(--primary);}

/* KYC DOCS */
.doc-list{display:flex;flex-direction:column;gap:8px;}
.doc-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border:1.5px solid var(--card-border);border-radius:var(--r-sm);background:var(--page-bg);transition:all var(--tr);}
.doc-item.uploaded{border-color:var(--success);background:var(--success-light);}
.doc-item.uploaded .doc-name{color:#065f46;}
.doc-ico{width:30px;height:30px;border-radius:7px;background:#fff;border:1px solid var(--card-border);display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--text-muted);flex-shrink:0;}
.doc-item.uploaded .doc-ico{border-color:var(--success);color:var(--success);background:var(--success-light);}
.doc-name{font-size:12px;font-weight:700;color:var(--text-dark);flex:1;}
.doc-req-lbl{font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;}
.doc-req{background:var(--orange-light);color:#c2410c;}
.doc-opt{background:var(--primary-light);color:var(--primary);}
.doc-ok{background:var(--success-light);color:#065f46;}
.doc-upload-btn{font-size:11px;font-weight:700;padding:5px 10px;border-radius:6px;border:1.5px solid var(--card-border);background:#fff;cursor:pointer;font-family:inherit;color:var(--text-mid);transition:all var(--tr);display:flex;align-items:center;gap:4px;}
.doc-upload-btn:hover{border-color:var(--primary);color:var(--primary);}
.doc-item.uploaded .doc-upload-btn{border-color:var(--success);color:var(--success);}

/* SCHEDULE TABLE */
.sched-wrap{overflow-x:auto;}
.sched-table{width:100%;border-collapse:collapse;font-size:12px;}
.sched-table th{padding:8px 12px;background:var(--page-bg);border-bottom:2px solid var(--card-border);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);text-align:left;white-space:nowrap;}
.sched-table td{padding:8px 12px;border-bottom:1px solid var(--card-border);vertical-align:middle;}
.sched-table tr:last-child td{border-bottom:none;}
.sched-table tr:hover td{background:#fafbff;}
.sched-table .mono{font-family:'JetBrains Mono',monospace;font-weight:600;}
.inst-no{width:28px;height:28px;border-radius:6px;background:var(--primary-light);color:var(--primary);font-size:11px;font-weight:800;display:flex;align-items:center;justify-content:center;font-family:'JetBrains Mono',monospace;}
.due-date{font-size:12px;font-weight:600;color:var(--text-dark);}
.inst-status{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;}
.is-upcoming{background:var(--primary-light);color:var(--primary);}
.is-first{background:var(--info-light);color:#0c4a6e;}

/* DOWN PAYMENT PANEL */
.dp-panel{background:linear-gradient(110deg,#1a1f36,#2d3d80);border-radius:var(--r-lg);padding:20px 24px;margin-bottom:14px;}
.dp-panel h5{font-size:13px;font-weight:800;color:#fff;margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.dp-row{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px;}
.dp-stat{padding-right:16px;border-right:1px solid rgba(255,255,255,.12);}
.dp-stat:last-child{border-right:none;}
.dp-stat-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:rgba(255,255,255,.5);margin-bottom:4px;}
.dp-stat-val{font-size:18px;font-weight:800;font-family:'JetBrains Mono',monospace;color:#fff;}
.dp-stat-sub{font-size:11px;color:rgba(255,255,255,.4);margin-top:2px;}
.dp-input-row{display:flex;align-items:flex-end;gap:12px;}
.dp-input-group{flex:1;}
.dp-input-group label{font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:5px;display:block;text-transform:uppercase;letter-spacing:.4px;}
.dp-input{padding:10px 14px;border:2px solid rgba(255,255,255,.2);border-radius:var(--r-sm);background:rgba(255,255,255,.08);font-family:'JetBrains Mono',monospace;font-size:15px;font-weight:700;color:#fff;outline:none;width:100%;transition:border-color var(--tr);}
.dp-input:focus{border-color:rgba(255,255,255,.5);}
.dp-input::placeholder{color:rgba(255,255,255,.25);}
.dp-constraint{font-size:11px;color:rgba(255,255,255,.45);margin-top:5px;font-weight:600;}
.dp-constraint.ok{color:#6ee7b7;}
.dp-constraint.warn{color:#fbbf24;}
.dp-constraint.err{color:#fca5a5;}
.dp-apply-btn{padding:10px 18px;border-radius:var(--r-sm);background:var(--success);color:#fff;border:none;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:all var(--tr);display:flex;align-items:center;gap:6px;white-space:nowrap;}
.dp-apply-btn:hover{background:var(--success-d);}
.dp-apply-btn:disabled{opacity:.4;cursor:not-allowed;}

/* SUMMARY FOOTER */
.summary-bar{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:16px 20px;display:flex;align-items:center;gap:0;box-shadow:var(--sh-sm);}
.sb-items{display:flex;gap:0;flex:1;flex-wrap:wrap;}
.sb-item{padding:0 24px;border-right:1px solid var(--card-border);}
.sb-item:first-child{padding-left:0;}
.sb-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);margin-bottom:3px;}
.sb-val{font-size:16px;font-weight:800;font-family:'JetBrains Mono',monospace;color:var(--text-dark);}
.sb-val.primary{color:var(--primary);}
.sb-val.success{color:var(--success);}
.sb-actions{margin-left:auto;padding-left:24px;display:flex;gap:8px;flex-shrink:0;}

/* GUARANTOR */
.gtr-card{border:1.5px dashed var(--card-border);border-radius:var(--r-md);padding:14px;transition:all var(--tr);}
.gtr-card.filled{border-style:solid;border-color:var(--success);background:var(--success-light);}
.gtr-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
.gtr-title{font-size:12px;font-weight:800;color:var(--text-mid);text-transform:uppercase;letter-spacing:.4px;display:flex;align-items:center;gap:6px;}
.gtr-card.filled .gtr-title{color:#065f46;}
.gtr-rm{font-size:11px;color:var(--danger);cursor:pointer;font-weight:700;background:none;border:none;font-family:inherit;padding:0;display:flex;align-items:center;gap:3px;}
.add-gtr-btn{width:100%;padding:11px;border:1.5px dashed var(--primary-mid);border-radius:var(--r-sm);background:var(--primary-light);color:var(--primary);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:all var(--tr);display:flex;align-items:center;justify-content:center;gap:7px;}
.add-gtr-btn:hover{border-color:var(--primary);background:#e4ecff;}

/* PAGE HEADER */
.pg-hdr{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:12px;}
.pg-hdr-l h1{font-size:19px;font-weight:800;letter-spacing:-.3px;}
.pg-hdr-l p{font-size:13px;color:var(--text-muted);margin-top:3px;}
.pg-actions{display:flex;gap:8px;align-items:center;}

/* TOAST */
#toast-c{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
.t-item{display:flex;align-items:center;gap:9px;padding:11px 16px;border-radius:var(--r-sm);font-size:13px;font-weight:600;box-shadow:var(--sh-lg);min-width:240px;animation:slideIn .3s ease;}
@keyframes slideIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
.t-s{background:var(--success);color:#fff;}
.t-e{background:var(--danger);color:#fff;}
.t-w{background:var(--warning);color:#fff;}
.t-i{background:var(--primary);color:#fff;}

/* DIVIDER */
.divider{height:1px;background:var(--card-border);margin:14px 0;}

/* BADGE */
.badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;}
.badge-info{background:var(--info-light);color:#0c4a6e;}
.badge-warn{background:var(--warning-light);color:#92400e;}
.badge-success{background:var(--success-light);color:#065f46;}

/* STEP PANE */
.step-pane{display:none;}
.step-pane.active{display:block;}

/* INFO BOX */
.info-box{display:flex;gap:10px;padding:11px 14px;border-radius:var(--r-sm);border:1.5px solid;font-size:12px;font-weight:600;margin-bottom:14px;}
.info-box-info{background:var(--info-light);border-color:#7dd3fc;color:#0c4a6e;}
.info-box-warn{background:var(--warning-light);border-color:#fde68a;color:#92400e;}
.info-box i{font-size:14px;flex-shrink:0;margin-top:1px;}

/* STEP NAV */
.step-nav{display:flex;justify-content:space-between;align-items:center;margin-top:16px;}

/* PROGRESS BAR */
.prog-wrap{height:4px;background:var(--card-border);border-radius:10px;margin-bottom:2px;}
.prog-bar{height:100%;border-radius:10px;background:linear-gradient(90deg,var(--primary),#7b8dd1);transition:width .4s ease;}
</style>
</head>
<body>

<!-- SIDEBAR -->
 
 
<!-- HEADER -->
 

<!-- MAIN -->
<main class="main">

  <!-- PAGE HEADER -->
  <div class="pg-hdr">
    <div class="pg-hdr-l">
      <h1><i class="fa-solid fa-hand-holding-dollar" style="color:var(--primary);font-size:17px;margin-right:6px;"></i> New Hire Purchase Agreement</h1>
      <p>Convert an unsettled invoice into a structured hire purchase plan</p>
    </div>
    <div class="pg-actions">
      <button class="btn btn-outline btn-sm" onclick="window.history.back()"><i class="fa-solid fa-arrow-left"></i> Back</button>
      <button class="btn btn-outline btn-sm" onclick="saveDraft()"><i class="fa-regular fa-floppy-disk"></i> Save Draft</button>
    </div>
  </div>

  <!-- STEP WIZARD -->
  <div class="wizard-bar">
    <div class="step active" id="ws-1">
      <div class="step-num" id="wsn-1">1</div>
      <div class="step-text">
        <div class="st-lbl">Invoice & Client</div>
        <div class="st-sub">Select source invoice</div>
      </div>
    </div>
    <div class="step pending" id="ws-2">
      <div class="step-num" id="wsn-2">2</div>
      <div class="step-text">
        <div class="st-lbl">Plan & Schedule</div>
        <div class="st-sub">Choose instalment plan</div>
      </div>
    </div>
    <div class="step pending" id="ws-3">
      <div class="step-num" id="wsn-3">3</div>
      <div class="step-text">
        <div class="st-lbl">Guarantor & KYC</div>
        <div class="st-sub">Supporting documents</div>
      </div>
    </div>
    <div class="step pending" id="ws-4">
      <div class="step-num" id="wsn-4">4</div>
      <div class="step-text">
        <div class="st-lbl">Down Payment</div>
        <div class="st-sub">Collect initial payment</div>
      </div>
    </div>
    <div class="step pending" id="ws-5">
      <div class="step-num" id="wsn-5"><i class="fa-solid fa-check" style="font-size:11px;"></i></div>
      <div class="step-text">
        <div class="st-lbl">Confirm</div>
        <div class="st-sub">Finalise agreement</div>
      </div>
    </div>
  </div>

  <!-- ═══════════════ STEP 1: INVOICE & CLIENT ═══════════════ -->
  <div class="step-pane active" id="pane-1">

    <!-- Invoice Selector -->
    <div class="sec-card">
      <div class="sec-head">
        <div class="sec-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-file-invoice-dollar"></i></div>
        <h5>Source Invoice</h5>
        <span class="sec-sub">Search and pick an unsettled invoice</span>
      </div>
      <div class="sec-body">

        <div id="inv-search-section">
          <div class="fld" style="margin-bottom:0;">
            <label>Invoice Number or Customer Name <span class="req">*</span></label>
            <div class="inv-search-wrap">
              <div class="input-ic">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="fc" id="inv-search" placeholder="Type invoice no. or customer name…" autocomplete="off">
              </div>
              <div class="inv-results" id="inv-results"></div>
            </div>
          </div>
        </div>

        <div id="inv-selected-section" style="display:none;">
          <div class="sel-inv" id="sel-inv-box">
            <div class="si-ico"><i class="fa-solid fa-file-invoice-dollar"></i></div>
            <div class="si-info">
              <div class="si-no" id="si-no">—</div>
              <div class="si-meta" id="si-meta">—</div>
            </div>
            <div class="si-amt">
              <div class="si-amt-val" id="si-amt">—</div>
              <div class="si-amt-lbl">Outstanding</div>
            </div>
            <button class="si-rm" onclick="clearInvoice()" title="Remove"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>

      </div>
    </div>

    <!-- Client Info -->
    <div class="sec-card" id="client-card">
      <div class="sec-head">
        <div class="sec-icon" style="background:var(--info-light);color:var(--info);"><i class="fa-solid fa-user"></i></div>
        <h5>Client</h5>
        <span class="sec-sub">Auto-filled from invoice · can override</span>
      </div>
      <div class="sec-body">
        <div class="fg fg-2" style="margin-bottom:14px;">
          <div class="fld">
            <label>Client Name <span class="req">*</span></label>
            <div class="input-ic">
              <i class="fa-solid fa-user"></i>
              <input type="text" class="fc" id="cl-name" placeholder="Full name">
            </div>
          </div>
          <div class="fld">
            <label>NIC / Passport <span class="req">*</span></label>
            <input type="text" class="fc" id="cl-nic" placeholder="National ID number">
          </div>
        </div>
        <div class="fg fg-3">
          <div class="fld">
            <label>Phone <span class="req">*</span></label>
            <div class="input-ic">
              <i class="fa-solid fa-phone"></i>
              <input type="text" class="fc" id="cl-phone" placeholder="+94 77 000 0000">
            </div>
          </div>
          <div class="fld">
            <label>Email</label>
            <div class="input-ic">
              <i class="fa-regular fa-envelope"></i>
              <input type="text" class="fc" id="cl-email" placeholder="email@example.com">
            </div>
          </div>
          <div class="fld">
            <label>Date of Birth</label>
            <input type="date" class="fc" id="cl-dob">
          </div>
        </div>
        <div class="divider"></div>
        <div class="fg fg-2">
          <div class="fld">
            <label>Address</label>
            <input type="text" class="fc" id="cl-addr" placeholder="Residential address">
          </div>
          <div class="fld">
            <label>Employment / Occupation</label>
            <input type="text" class="fc" id="cl-job" placeholder="Job title or business name">
          </div>
        </div>
      </div>
    </div>

    <div class="step-nav">
      <span></span>
      <button class="btn btn-primary" onclick="goStep(2)">Continue <i class="fa-solid fa-arrow-right"></i></button>
    </div>
  </div>

  <!-- ═══════════════ STEP 2: PLAN & SCHEDULE ═══════════════ -->
  <div class="step-pane" id="pane-2">

    <div class="sec-card">
      <div class="sec-head">
        <div class="sec-icon" style="background:var(--purple-light);color:var(--purple);"><i class="fa-solid fa-calendar-days"></i></div>
        <h5>Hire Purchase Plan</h5>
        <span class="sec-sub">Select an instalment scheme</span>
      </div>
      <div class="sec-body">
        <div class="plan-grid" id="plan-grid"></div>
      </div>
    </div>

    <div class="sec-card" id="schedule-card" style="display:none;">
      <div class="sec-head">
        <div class="sec-icon" style="background:var(--teal-light);color:var(--teal);"><i class="fa-solid fa-table-list"></i></div>
        <h5>Instalment Schedule</h5>
        <span class="sec-sub" id="sched-sub">—</span>
        <div style="margin-left:auto;display:flex;gap:8px;align-items:center;">
          <span class="badge badge-info" id="sched-badge">—</span>
        </div>
      </div>
      <div class="sec-body" style="padding:0;">
        <div class="sched-wrap">
          <table class="sched-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Due Date</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Instalment</th>
                <th>Balance</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="sched-body"></tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="step-nav">
      <button class="btn btn-outline" onclick="goStep(1)"><i class="fa-solid fa-arrow-left"></i> Back</button>
      <button class="btn btn-primary" onclick="goStep(3)">Continue <i class="fa-solid fa-arrow-right"></i></button>
    </div>
  </div>

  <!-- ═══════════════ STEP 3: GUARANTOR & KYC ═══════════════ -->
  <div class="step-pane" id="pane-3">

    <!-- Guarantors -->
    <div class="sec-card">
      <div class="sec-head">
        <div class="sec-icon" style="background:var(--orange-light);color:var(--orange);"><i class="fa-solid fa-people-group"></i></div>
        <h5>Guarantors</h5>
        <span class="sec-sub">Minimum 1 guarantor required</span>
      </div>
      <div class="sec-body">
        <div id="guarantors-wrap"></div>
        <button class="add-gtr-btn" id="add-gtr-btn" onclick="addGuarantor()">
          <i class="fa-solid fa-circle-plus"></i> Add Guarantor
        </button>
      </div>
    </div>

    <!-- KYC Documents -->
    <div class="sec-card">
      <div class="sec-head">
        <div class="sec-icon" style="background:var(--warning-light);color:var(--warning);"><i class="fa-solid fa-folder-open"></i></div>
        <h5>KYC Documents</h5>
        <span class="sec-sub" id="kyc-sub">Upload supporting documents</span>
      </div>
      <div class="sec-body">
        <div class="doc-list" id="doc-list"></div>
      </div>
    </div>

    <div class="step-nav">
      <button class="btn btn-outline" onclick="goStep(2)"><i class="fa-solid fa-arrow-left"></i> Back</button>
      <button class="btn btn-primary" onclick="goStep(4)">Continue <i class="fa-solid fa-arrow-right"></i></button>
    </div>
  </div>

  <!-- ═══════════════ STEP 4: DOWN PAYMENT ═══════════════ -->
  <div class="step-pane" id="pane-4">

    <div class="dp-panel">
      <h5><i class="fa-solid fa-coins"></i> Down Payment Collection</h5>
      <div class="dp-row" id="dp-stats-row"></div>
      <div class="dp-input-row">
        <div class="dp-input-group">
          <label>Amount Collected</label>
          <input type="number" class="dp-input" id="dp-amount" placeholder="0.00" oninput="onDpInput()">
          <div class="dp-constraint" id="dp-constraint-msg">Enter amount collected from customer</div>
        </div>
        <button class="dp-apply-btn" id="dp-apply-btn" onclick="applyDownPayment()">
          <i class="fa-solid fa-arrow-rotate-right"></i> Recalculate Schedule
        </button>
      </div>
    </div>

    <!-- Adjusted Schedule preview -->
    <div class="sec-card" id="dp-sched-card">
      <div class="sec-head">
        <div class="sec-icon" style="background:var(--success-light);color:var(--success);"><i class="fa-solid fa-table-list"></i></div>
        <h5>Adjusted Instalment Schedule</h5>
        <span class="sec-sub" id="dp-sched-sub">—</span>
      </div>
      <div class="sec-body" style="padding:0;">
        <div class="sched-wrap">
          <table class="sched-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Due Date</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Instalment</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody id="dp-sched-body"></tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="step-nav">
      <button class="btn btn-outline" onclick="goStep(3)"><i class="fa-solid fa-arrow-left"></i> Back</button>
      <button class="btn btn-primary" onclick="goStep(5)">Continue <i class="fa-solid fa-arrow-right"></i></button>
    </div>
  </div>

  <!-- ═══════════════ STEP 5: CONFIRM ═══════════════ -->
  <div class="step-pane" id="pane-5">

    <div class="info-box info-box-info">
      <i class="fa-solid fa-circle-info"></i>
      <div>Review the summary below before creating the hire purchase agreement. Once confirmed, an HP number will be generated and the invoice marked as HP-linked.</div>
    </div>

    <!-- Review Summary -->
    <div class="sec-card">
      <div class="sec-head">
        <div class="sec-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-clipboard-check"></i></div>
        <h5>Agreement Summary</h5>
      </div>
      <div class="sec-body">
        <div class="fg fg-3" id="confirm-summary"></div>
      </div>
    </div>

    <div class="summary-bar">
      <div class="sb-items" id="final-sb-items"></div>
      <div class="sb-actions">
        <button class="btn btn-outline" onclick="goStep(4)"><i class="fa-solid fa-arrow-left"></i> Back</button>
        <button class="btn btn-success" onclick="confirmHP()"><i class="fa-solid fa-check-double"></i> Create HP Agreement</button>
      </div>
    </div>
  </div>

</main>

<!-- TOAST CONTAINER -->
<div id="toast-c"></div>

 
<script>
 

/* ═══════════════════════════════════════════════════
   STATE MANAGEMENT
═══════════════════════════════════════════════════ */
var STATE = {
  step: 1,
  invoice: null,
  plan: null,
  schedule: [],
  dpAmount: 0,
  dpApplied: false,
  guarantors: [],
  kycUploaded: {},
  kycFiles: {}
};

var gtrCounter = 0;

/* ═══════════════════════════════════════════════════
   HELPER FUNCTIONS
═══════════════════════════════════════════════════ */
function fmt(n) {
  if (!n && n !== 0) return '—';
  return Math.round(n).toLocaleString('en-LK');
}

function fmtDate(d) {
  return d.toISOString().slice(0, 10);
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

function isValidEmail(email) {
  var emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
  return emailRegex.test(email);
}

function toast(msg, type) {
  var map = { s:['t-s','fa-check-circle'], e:['t-e','fa-circle-xmark'], w:['t-w','fa-triangle-exclamation'], i:['t-i','fa-circle-info'] };
  var p = map[type] || map.i;
  var $t = $('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i> '+msg+'</div>');
  $('#toast-c').append($t);
  setTimeout(function(){ $t.css({opacity:0,transform:'translateX(16px)',transition:'all .3s'}); setTimeout(function(){ $t.remove(); }, 300); }, 3000);
}

$.debounce = function(delay, func) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timeout);
    timeout = setTimeout(function() {
      func.apply(context, args);
    }, delay);
  };
};

/* ═══════════════════════════════════════════════════
   STEP NAVIGATION
═══════════════════════════════════════════════════ */
function goStep(n) {
  if (n > STATE.step) {
    if (!validateStep(STATE.step)) return;
  }
  STATE.step = n;
  $('.step-pane').removeClass('active');
  $('#pane-'+n).addClass('active');

  for (var i = 1; i <= 5; i++) {
    var $s = $('#ws-'+i);
    $s.removeClass('active done pending');
    if (i < n) {
      $s.addClass('done');
      $('#wsn-'+i).html('<i class="fa-solid fa-check" style="font-size:11px;"></i>');
    } else if (i === n) {
      $s.addClass('active');
      $('#wsn-'+i).text(i);
    } else {
      $s.addClass('pending');
      $('#wsn-'+i).text(i);
    }
  }

  if (n === 4) renderDpPanel();
  if (n === 5) renderConfirm();
}

function validateStep(n) {
  if (n === 1) {
    if (!STATE.invoice) { toast('Please select an invoice','e'); return false; }
    if (!$('#cl-name').val().trim()) { toast('Client name is required','e'); return false; }
    var nicValue = $('#cl-nic').val().trim();
	if (!nicValue) { toast('NIC / Passport is required','e'); return false; }
	if (nicValue.length !== 12) { toast('NIC / Passport must be exactly 12 characters','e'); return false; }
	var phoneValue = $('#cl-phone').val().trim();
	if (!phoneValue) { toast('Phone number is required','e'); return false; }
	// Sri Lanka phone validation: 10 digits (starting with 0) OR 12 digits (starting with +94)
	var sriLankaPattern = /^(?:\+94|0)[1-9]\d{8}$/;
	if (!sriLankaPattern.test(phoneValue)) { 
		toast('Please enter a valid Sri Lanka phone number (e.g., 0771234567 or +94771234567)','e'); 
		return false; 
	}
	
	var email = $('#cl-email').val().trim();
    if (email && !isValidEmail(email)) {
      toast('Please enter a valid email address','e');
      return false;
    }
	
	return true;
  }
  if (n === 2) {
    if (!STATE.plan) { toast('Please select a plan','e'); return false; }
    return true;
  }
  if (n === 3) {
    if (STATE.guarantors.length === 0) { toast('At least one guarantor is required','e'); return false; }
    
	for (var i = 0; i < STATE.guarantors.length; i++) {
        var g = STATE.guarantors[i];
        if (!g.nic || g.nic.trim().length !== 12) { toast('Guarantor '+(i+1)+': NIC is required and must be exactly 12 characters','e'); return false; }
        if (!g.phone || !/^(?:\+94|0)[1-9]\d{8}$/.test(g.phone.trim())) { toast('Guarantor '+(i+1)+': Phone is required and must be a valid Sri Lanka number','e'); return false; }
    }
	
	
	
	var missing = false;
    $.ajax({
      url: '/Hire_purchase/kyc_types',
      method: 'GET',
      async: false,
      success: function(kycDocs) {
        missing = kycDocs.filter(function(d){ return d.required && !STATE.kycUploaded[d.id]; });
      }
    });
    if (missing.length > 0) { toast('Please upload all required KYC documents','e'); return false; }
    return true;
  }
  if (n === 4) {
    if (!STATE.dpApplied) { toast('Please confirm the down payment amount','e'); return false; }
    return true;
  }
  return true;
}


/* ═══════════════════════════════════════════════════
   INVOICE SEARCH
═══════════════════════════════════════════════════ */
$('#inv-search').on('input', $.debounce(300, function() {
  var q = $(this).val().trim();
  if (!q) { 
    $('#inv-results').removeClass('show').html(''); 
    return; 
  }
  
  $.ajax({
    url: '/Hire_purchase/invoices',
    method: 'GET',
    data: { q: q },
    success: function(invoices) {
      if (!invoices.length) {
        $('#inv-results').addClass('show').html('<div style="padding:14px;text-align:center;font-size:12px;color:var(--text-muted);">No unsettled invoices found</div>');
        return;
      }
      var html = invoices.map(function(inv){
        var tag = inv.status === 'partial'
          ? '<span class="inv-tag tag-partial"><i class="fa-solid fa-circle-half-stroke"></i> Partial</span>'
          : '<span class="inv-tag tag-unsettled"><i class="fa-solid fa-circle-xmark"></i> Unsettled</span>';
        return '<div class="inv-result-item" onclick="selectInvoice(\''+inv.id+'\')">'
          + '<div class="ir-top"><span class="ir-no">'+escapeHtml(inv.id)+'</span>'+tag+'<span class="ir-amt">LKR '+fmt(inv.outstanding)+'</span></div>'
          + '<div class="ir-bot"><span><i class="fa-regular fa-user"></i> '+escapeHtml(inv.customer)+'</span><span><i class="fa-regular fa-calendar"></i> '+inv.date+'</span><span>'+escapeHtml(inv.items)+'</span></div>'
          + '</div>';
      }).join('');
      $('#inv-results').addClass('show').html(html);
    },
    error: function() {
      toast('Failed to load invoices', 'e');
    }
  });
}));

$(document).on('click', function(e){
  if (!$(e.target).closest('.inv-search-wrap').length) $('#inv-results').removeClass('show');
});

function selectInvoice(id) {
  $.ajax({
    url: '/Hire_purchase/invoices',
    method: 'GET',
    data: { q: id },
    success: function(invoices) {
      var inv = invoices.find(function(i) { return i.id === id; });
      if (inv) {
        STATE.invoice = inv;
        $('#inv-results').removeClass('show');
        $('#inv-search-section').hide();
        $('#si-no').text(inv.id);
        $('#si-meta').text(inv.customer + ' · ' + inv.date + ' · ' + inv.items);
        $('#si-amt').text('LKR ' + fmt(inv.outstanding));
        $('#inv-selected-section').show();
		
        $('#cl-name').val(inv.customer || '');
        $('#cl-phone').val(inv.phone || '');
        $('#cl-email').val(inv.email || '');
        $('#cl-addr').val(inv.address || '');
		
        toast('Invoice ' + inv.id + ' selected', 's');
      }
    },
    error: function() {
      toast('Failed to load invoice details', 'e');
    }
  });
}

function clearInvoice() {
  STATE.invoice = null;
  $('#inv-selected-section').hide();
  $('#inv-search-section').show();
  $('#inv-search').val('');
  $('#cl-name,#cl-nic,#cl-phone,#cl-email,#cl-dob,#cl-addr,#cl-job').val('');
}

/* ═══════════════════════════════════════════════════
   PLAN SELECTION
═══════════════════════════════════════════════════ */
function renderPlans() {
  $.ajax({
    url: '/Hire_purchase/plans',
    method: 'GET',
    success: function(plans) {
      var html = plans.map(function(p){
        var rateHtml = p.interest_free
          ? '<span class="plan-rate rate-free"><i class="fa-solid fa-star"></i> Interest Free</span>'
          : '<span class="plan-rate rate-int"><i class="fa-solid fa-percent"></i> '+p.rate+'% p.a.</span>';
        return '<div class="plan-card" id="pc-'+p.id+'" onclick="selectPlan(\''+p.id+'\')"><div class="plan-check"><i class="fa-solid fa-check"></i></div>'
          + '<div class="plan-months">'+p.months+'<span>months</span></div>'
          + '<div class="plan-name">'+escapeHtml(p.name)+'</div>'
          + rateHtml
          + '<div class="plan-dp">Min. Down Payment: <strong>'+p.min_dp_pct+'%</strong></div>'
          + '<div class="plan-dp">Processing Fee: LKR '+fmt(p.processing_fee)+'</div>'
          + '</div>';
      }).join('');
      $('#plan-grid').html(html);
    },
    error: function() {
      toast('Failed to load plans', 'e');
    }
  });
}

function selectPlan(id) {
  $.ajax({
    url: '/Hire_purchase/plans',
    method: 'GET',
    success: function(plans) {
      var plan = plans.find(function(p) { return p.id === id; });
      if (plan) {
        STATE.plan = plan;
        $('.plan-card').removeClass('selected');
        $('#pc-'+id).addClass('selected');
        if (STATE.invoice) {
          var minDp = Math.ceil(STATE.invoice.outstanding * plan.min_dp_pct / 100);
          buildSchedule(minDp);
        }
      }
    },
    error: function() {
      toast('Failed to load plan details', 'e');
    }
  });
}

/* ═══════════════════════════════════════════════════
   SCHEDULE COMPUTATION
═══════════════════════════════════════════════════ */
function buildSchedule(dpAmt) {
  if (!STATE.invoice || !STATE.plan) return;
  
  $.ajax({
    url: '/Hire_purchase/schedule',
    method: 'POST',
    data: {
      invoice_id: STATE.invoice.id,
      plan_id: STATE.plan.id,
      down_payment: dpAmt || STATE.dpAmount
    },
    success: function(response) {
      STATE.schedule = response.schedule;
      renderSchedule(response.schedule, '#sched-body', true);
      $('#sched-sub').text(STATE.plan.name + ' · ' + STATE.plan.months + ' instalments · LKR ' + fmt(Math.round(response.schedule[0].instalment)) + '/mo');
      $('#sched-badge').text('Total Repayable: LKR ' + fmt(response.summary.total_repayable));
      $('#schedule-card').show();
    },
    error: function(xhr) {
      var error = xhr.responseJSON;
      toast(error.error || 'Failed to calculate schedule', 'e');
    }
  });
}

function renderSchedule(rows, bodySelector, showStatus) {
  var html = rows.map(function(r){
    var statusHtml = '';
    if (showStatus) {
      statusHtml = r.no === 1
        ? '<td><span class="inst-status is-first"><i class="fa-solid fa-star"></i> 1st</span></td>'
        : '<td><span class="inst-status is-upcoming"><i class="fa-regular fa-clock"></i> Upcoming</span></td>';
    }
    return '<tr>'
      + '<td><div class="inst-no">'+r.no+'</div></td>'
      + '<td><span class="due-date">'+r.due_date+'</span></td>'
      + '<td class="mono">'+fmt(r.principal)+'</td>'
      + '<td class="mono" style="color:'+(r.interest>0?'var(--danger)':'var(--text-muted)')+'">'+fmt(r.interest)+'</td>'
      + '<td class="mono" style="font-weight:800;color:var(--primary);">'+fmt(r.instalment)+'</td>'
      + '<td class="mono" style="color:var(--text-muted);">'+fmt(r.balance)+'</td>'
      + (showStatus ? statusHtml : '')
      + '</tr>';
  }).join('');
  $(bodySelector).html(html);
}

/* ═══════════════════════════════════════════════════
   GUARANTORS
═══════════════════════════════════════════════════ */
function renderGuarantors() {
  var html = STATE.guarantors.map(function(g, idx){
    return '<div class="gtr-card" id="gtr-'+g.id+'" style="margin-bottom:10px;">'
      + '<div class="gtr-head">'
      + '<div class="gtr-title"><i class="fa-solid fa-user-shield"></i> Guarantor '+(idx+1)+'</div>'
      + '<button class="gtr-rm" onclick="removeGuarantor('+g.id+')"><i class="fa-solid fa-trash-can"></i> Remove</button>'
      + '</div>'
      + '<div class="fg fg-3">'
      + '<div class="fld"><label>Full Name <span class="req">*</span></label><input type="text" class="fc" id="gn-'+g.id+'" value="'+escapeHtml(g.name)+'" placeholder="Full name" onchange="updateGtr('+g.id+',\'name\',this.value)"></div>'
      + '<div class="fld"><label>NIC <span class="req">*</span></label><input type="text" class="fc" id="gnic-'+g.id+'" value="'+escapeHtml(g.nic)+'" placeholder="NIC number" onchange="updateGtr('+g.id+',\'nic\',this.value)"></div>'
      + '<div class="fld"><label>Phone <span class="req">*</span></label><input type="text" class="fc" id="gph-'+g.id+'" value="'+escapeHtml(g.phone)+'" placeholder="Phone" onchange="updateGtr('+g.id+',\'phone\',this.value)"></div>'
      + '</div>'
      + '<div class="fg fg-2" style="margin-top:10px;">'
      + '<div class="fld"><label>Relationship to Client </label><select class="fc" onchange="updateGtr('+g.id+',\'rel\',this.value)"><option value="">Select…</option><option '+(g.rel==='Spouse'?'selected':'')+'>Spouse</option><option '+(g.rel==='Parent'?'selected':'')+'>Parent</option><option '+(g.rel==='Sibling'?'selected':'')+'>Sibling</option><option '+(g.rel==='Friend'?'selected':'')+'>Friend</option><option '+(g.rel==='Employer'?'selected':'')+'>Employer</option><option '+(g.rel==='Other'?'selected':'')+'>Other</option></select></div>'
      + '<div class="fld"><label>Address</label><input type="text" class="fc" value="'+escapeHtml(g.addr)+'" placeholder="Residential address" onchange="updateGtr('+g.id+',\'addr\',this.value)"></div>'
      + '</div>'
      + '</div>';
  }).join('');
  $('#guarantors-wrap').html(html);
  if (STATE.guarantors.length >= 3) $('#add-gtr-btn').hide();
  else $('#add-gtr-btn').show();
}

function addGuarantor() {
  gtrCounter++;
  STATE.guarantors.push({ id:gtrCounter, name:'', nic:'', phone:'', rel:'', addr:'' });
  renderGuarantors();
}

function removeGuarantor(id) {
  STATE.guarantors = STATE.guarantors.filter(function(g){ return g.id !== id; });
  renderGuarantors();
}

function updateGtr(id, field, val) {
  var g = STATE.guarantors.find(function(g){ return g.id === id; });
  if (g) g[field] = val;
}

/* ═══════════════════════════════════════════════════
   KYC DOCUMENTS
═══════════════════════════════════════════════════ */
function renderKyc() {
  $.ajax({
    url: '/Hire_purchase/kyc_types',
    method: 'GET',
    success: function(kycDocs) {
      var html = kycDocs.map(function(d){
        var uploaded = !!STATE.kycUploaded[d.id];
        var reqLabel = uploaded ? '<span class="doc-req-lbl doc-ok"><i class="fa-solid fa-check"></i> Uploaded</span>'
          : (d.required ? '<span class="doc-req-lbl doc-req">Required</span>' : '<span class="doc-req-lbl doc-opt">Optional</span>');
        var btnLabel = uploaded ? '<i class="fa-solid fa-check"></i> Uploaded' : '<i class="fa-solid fa-arrow-up-from-bracket"></i> Upload';
        return '<div class="doc-item '+(uploaded?'uploaded':'')+'" id="docitem-'+d.id+'">'
          + '<div class="doc-ico"><i class="fa-regular fa-file-lines"></i></div>'
          + '<div class="doc-name">'+escapeHtml(d.name)+'</div>'
          + reqLabel
          + '<button class="doc-upload-btn" onclick="uploadDocument(\''+d.id+'\', \''+escapeHtml(d.name)+'\')">'+btnLabel+'</button>'
          + '</div>';
      }).join('');
      $('#doc-list').html(html);
      var uploadedCount = Object.keys(STATE.kycUploaded).length;
      $('#kyc-sub').text(uploadedCount + ' of ' + kycDocs.length + ' documents uploaded');
    },
    error: function() {
      toast('Failed to load KYC document types', 'e');
    }
  });
}

function uploadDocument(docId, docName) {
  var input = document.createElement('input');
  input.type = 'file';
  input.accept = 'image/jpeg,image/png,application/pdf';
  
  input.onchange = function(e) {
    var file = e.target.files[0];
    if (!file) return;
    
    var formData = new FormData();
    formData.append('file', file);
    formData.append('doc_type', docId);
    
    $.ajax({
      url: '/Hire_purchase/upload_document',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
		   
		  
        STATE.kycUploaded[docId] = true;
        STATE.kycFiles[docId] = response.file_path;
		
		  
        renderKyc();
        toast(docName + ' uploaded successfully', 's');
      },
      error: function(xhr) {
        var error = xhr.responseJSON;
        toast(error.error || 'Upload failed', 'e');
      }
    });
  };
  
  input.click();
}

/* ═══════════════════════════════════════════════════
   DOWN PAYMENT
═══════════════════════════════════════════════════ */
function renderDpPanel() {
  if (!STATE.invoice || !STATE.plan) return;
  var inv = STATE.invoice;
  var plan = STATE.plan;
  var minDp = Math.ceil(inv.outstanding * plan.min_dp_pct / 100);

  var html = '<div class="dp-stat"><div class="dp-stat-lbl">Invoice Outstanding</div><div class="dp-stat-val">LKR '+fmt(inv.outstanding)+'</div><div class="dp-stat-sub">'+inv.id+'</div></div>'
    + '<div class="dp-stat"><div class="dp-stat-lbl">Min. Down Payment ('+plan.min_dp_pct+'%)</div><div class="dp-stat-val">LKR '+fmt(minDp)+'</div><div class="dp-stat-sub">Based on '+plan.name+'</div></div>'
    + '<div class="dp-stat"><div class="dp-stat-lbl">Processing Fee</div><div class="dp-stat-val">LKR '+fmt(plan.processing_fee)+'</div><div class="dp-stat-sub">One-time charge</div></div>';
  $('#dp-stats-row').html(html);
  $('#dp-amount').attr('min', minDp).attr('max', inv.outstanding);

  if (STATE.dpAmount === 0) STATE.dpAmount = minDp;
  buildDpSchedule(STATE.dpAmount);
}

function onDpInput() {
  if (!STATE.invoice || !STATE.plan) return;
  var inv = STATE.invoice;
  var plan = STATE.plan;
  var minDp = Math.ceil(inv.outstanding * plan.min_dp_pct / 100);
  var entered = parseFloat($('#dp-amount').val()) || 0;
  var $msg = $('#dp-constraint-msg');
  var $btn = $('#dp-apply-btn');
  
  if (entered < minDp) {
    $msg.text('Minimum down payment is LKR ' + fmt(minDp) + ' (' + plan.min_dp_pct + '%)').removeClass('ok warn').addClass('err');
    $btn.prop('disabled', true);
  } else if (entered >= inv.outstanding) {
    $msg.text('Down payment cannot equal or exceed the full outstanding amount').removeClass('ok warn').addClass('err');
    $btn.prop('disabled', true);
  } else if (entered > minDp) {
    var extra = entered - minDp;
    $msg.text('LKR ' + fmt(extra) + ' above minimum — schedule will be adjusted').removeClass('err warn').addClass('ok');
    $btn.prop('disabled', false);
  } else {
    $msg.text('Minimum down payment met').removeClass('err warn').addClass('ok');
    $btn.prop('disabled', false);
  }
}

function applyDownPayment() {
  var entered = parseFloat($('#dp-amount').val()) || 0;
  STATE.dpAmount = entered;
  STATE.dpApplied = true;
  buildDpSchedule(entered);
  toast('Schedule updated for LKR ' + fmt(entered) + ' down payment', 's');
}

function buildDpSchedule(dpAmt) {
  if (!STATE.invoice || !STATE.plan) return;
  
  $.ajax({
    url: '/Hire_purchase/schedule',
    method: 'POST',
    data: {
      invoice_id: STATE.invoice.id,
      plan_id: STATE.plan.id,
      down_payment: dpAmt
    },
    success: function(response) {
      renderSchedule(response.schedule, '#dp-sched-body', false);
      $('#dp-sched-sub').text(STATE.plan.name + ' · After LKR ' + fmt(dpAmt) + ' down payment · ' + fmt(Math.round(response.schedule[0].instalment)) + '/mo');
    },
    error: function(xhr) {
      var error = xhr.responseJSON;
      toast(error.error || 'Failed to calculate schedule', 'e');
    }
  });
}

/* ═══════════════════════════════════════════════════
   CONFIRM STEP
═══════════════════════════════════════════════════ */
function renderConfirm() {
  if (!STATE.invoice || !STATE.plan) return;
  var inv = STATE.invoice;
  var plan = STATE.plan;
  var dp = STATE.dpAmount;
  var principal = inv.outstanding - dp;
  //var emi = STATE.schedule.length ? STATE.schedule[0].instalment : 0;
  
  var emi = 0;
  if ($('#dp-sched-body tr').length > 0) {
    // Get first row's instalment from the adjusted schedule in Step 4
    var firstRowInstalment = $('#dp-sched-body tr:first td:nth-child(5)').text();
    emi = parseFloat(firstRowInstalment.replace(/[^0-9.-]/g, '')) || 0;
  } else if (STATE.schedule.length > 0) {
    // Fallback to initial schedule
    emi = STATE.schedule[0].instalment;
  }
  
  var totalAmt = 0;
  if ($('#dp-sched-body tr').length > 0) {
    $('#dp-sched-body tr').each(function() {
      var instalment = $(this).find('td:nth-child(5)').text();
      var val = parseFloat(instalment.replace(/[^0-9.-]/g, '')) || 0;
      totalAmt += val;
    });
  } else {
    totalAmt = STATE.schedule.reduce(function(s, r) { return s + r.instalment; }, 0);
  }

  var items = [
    { lbl:'Invoice', val:inv.id, icon:'fa-file-invoice-dollar', color:'var(--primary)' },
    { lbl:'Customer', val:inv.customer, icon:'fa-user', color:'var(--info)' },
    { lbl:'Invoice Amount', val:'LKR '+fmt(inv.outstanding), icon:'fa-coins', color:'var(--warning)' },
    { lbl:'Plan', val:plan.name, icon:'fa-calendar-days', color:'var(--purple)' },
    { lbl:'Down Payment', val:'LKR '+fmt(dp), icon:'fa-hand-holding-dollar', color:'var(--success)' },
    { lbl:'Financed Amount', val:'LKR '+fmt(principal), icon:'fa-scale-balanced', color:'var(--orange)' },
    { lbl:'Monthly Instalment', val:'LKR '+fmt(emi), icon:'fa-arrow-rotate-right', color:'var(--teal)' },
    { lbl:'Processing Fee', val:'LKR '+fmt(plan.processing_fee), icon:'fa-receipt', color:'var(--danger)' },
    { lbl:'Guarantors', val:STATE.guarantors.length + ' added', icon:'fa-people-group', color:'var(--orange)' }
  ];

  var html = items.map(function(it){
    return '<div class="fld" style="background:var(--page-bg);border-radius:var(--r-sm);padding:12px;">'
      + '<label style="font-size:10px;letter-spacing:.4px;text-transform:uppercase;display:flex;align-items:center;gap:5px;"><i class="fa-solid '+it.icon+'" style="color:'+it.color+';"></i> '+it.lbl+'</label>'
      + '<div style="font-size:14px;font-weight:800;color:var(--text-dark);margin-top:4px;font-family:JetBrains Mono,monospace;">'+it.val+'</div>'
      + '</div>';
  }).join('');
  $('#confirm-summary').html(html);

  //var totalAmt = (STATE.schedule.reduce(function(s,r){return s+r.instalment;},0));
  $('#final-sb-items').html(
    '<div class="sb-item"><div class="sb-lbl">Outstanding</div><div class="sb-val">LKR '+fmt(inv.outstanding)+'</div></div>'
    +'<div class="sb-item"><div class="sb-lbl">Down Payment</div><div class="sb-val success">LKR '+fmt(dp)+'</div></div>'
    +'<div class="sb-item"><div class="sb-lbl">Financed</div><div class="sb-val primary">LKR '+fmt(principal)+'</div></div>'
    +'<div class="sb-item"><div class="sb-lbl">Total Repayable</div><div class="sb-val">LKR '+fmt(totalAmt)+'</div></div>'
    +'<div class="sb-item"><div class="sb-lbl">Monthly EMI</div><div class="sb-val primary">LKR '+fmt(emi)+'</div></div>'
  );
}

/* ═══════════════════════════════════════════════════
   CREATE HP AGREEMENT
═══════════════════════════════════════════════════ */
function confirmHP() {
	 
  var payload = {
    invoice_id: STATE.invoice.id,
    plan_id: STATE.plan.id,
    client_name: $('#cl-name').val(),
    client_nic: $('#cl-nic').val(),
    client_phone: $('#cl-phone').val(),
    client_email: $('#cl-email').val(),
    client_dob: $('#cl-dob').val(),
    client_addr: $('#cl-addr').val(),
    client_job: $('#cl-job').val(),
    down_payment: STATE.dpAmount,
    guarantors: STATE.guarantors,
    kyc_uploaded: Object.keys(STATE.kycUploaded),
    kyc_paths: STATE.kycFiles
  };
  
   
  
  $.ajax({
    url: '/Hire_purchase/create',
    method: 'POST',
    data: JSON.stringify(payload),
    contentType: 'application/json',
    success: function(response) {
		toast('HP Agreement created successfully! Ref: ' + response.hp_ref, 's');
		setTimeout(function() {
			// Just go back to the creation page instead of trying to view details
			window.location.href = '/Hire_purchase';
		}, 1500);
	},
    error: function(xhr) {
      var response = xhr.responseJSON;
      if (response && response.errors) {
        response.errors.forEach(function(err) {
          toast(err, 'e');
        });
      } else {
        toast('Failed to create HP agreement', 'e');
      }
    }
  });
}

function saveDraft() {
  var draftData = {
    invoice: STATE.invoice,
    plan: STATE.plan,
    client: {
      name: $('#cl-name').val(),
      nic: $('#cl-nic').val(),
      phone: $('#cl-phone').val(),
      email: $('#cl-email').val(),
      dob: $('#cl-dob').val(),
      addr: $('#cl-addr').val(),
      job: $('#cl-job').val()
    },
    down_payment: STATE.dpAmount,
    guarantors: STATE.guarantors,
    kyc_uploaded: STATE.kycUploaded,
    saved_at: new Date().toISOString()
  };
  
  localStorage.setItem('hp_draft_' + new Date().getTime(), JSON.stringify(draftData));
  toast('Draft saved', 'i');
}

/* ═══════════════════════════════════════════════════
   INITIALIZATION
═══════════════════════════════════════════════════ */
$(function(){
  renderPlans();
  renderKyc();
  renderGuarantors();
});
</script>
 
</body>
</html>

