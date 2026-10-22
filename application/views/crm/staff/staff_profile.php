<?php 
$edit_mode = isset($edit_mode) && $edit_mode === true;
$staff_data = isset($staff) ? $staff : null;
?>
<style>
:root {
  --primary:#3d52a0; --primary-light:#eef1fb; --primary-mid:#c5cff7; --primary-dark:#2d3d80;
  --success:#10b981; --success-light:#d1fae5; --success-dark:#059669;
  --danger:#ef4444;  --danger-light:#fee2e2;
  --warning:#f59e0b; --warning-light:#fef3c7;
  --info:#0ea5e9;    --info-light:#e0f2fe;
  --purple:#8b5cf6;  --purple-light:#ede9fe;
  --teal:#14b8a6;    --teal-light:#ccfbf1;
  --orange:#f97316;  --orange-light:#ffedd5;
  --pink:#ec4899;    --pink-light:#fce7f3;
  --sidebar-bg:#1e2140; --sidebar-text:#a8b4d8;
  --page-bg:#f4f6fb; --card-bg:#fff; --card-border:#e8ecf4;
  --text-dark:#1a1f36; --text-mid:#4a5568; --text-muted:#8a94a6;
  --input-border:#d1d9e6; --table-head:#f8faff;
  --shadow-sm:0 1px 3px rgba(61,82,160,0.07);
  --shadow-md:0 4px 16px rgba(61,82,160,0.10);
  --shadow-lg:0 8px 32px rgba(61,82,160,0.15);
  --radius-sm:8px; --radius-md:12px; --radius-lg:16px;
  --sidebar-w:240px; --header-h:60px;
  --transition:0.22s cubic-bezier(.4,0,.2,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;min-height:100vh;}
::-webkit-scrollbar{width:5px;height:5px;}
::-webkit-scrollbar-track{background:transparent;}
::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

/* ── SIDEBAR ── */
.app-sidebar{position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-w);background:var(--sidebar-bg);z-index:100;display:flex;flex-direction:column;}
.sidebar-logo{height:var(--header-h);display:flex;align-items:center;padding:0 20px;border-bottom:1px solid rgba(255,255,255,0.07);}
.logo-mark{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff;font-weight:800;flex-shrink:0;}
.logo-text{margin-left:10px;color:#fff;font-weight:700;font-size:15px;}
.logo-text span{color:#7b8dd1;}
.sidebar-nav{flex:1;overflow-y:auto;padding:12px 0;}
.nav-category{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(168,180,216,0.5);padding:14px 20px 6px;}
.nav-link-item{display:flex;align-items:center;gap:10px;padding:9px 20px;color:var(--sidebar-text);text-decoration:none;font-size:13px;font-weight:500;cursor:pointer;transition:all var(--transition);}
.nav-link-item i{font-size:16px;width:20px;text-align:center;flex-shrink:0;}
.nav-link-item:hover{background:rgba(255,255,255,0.05);color:#fff;}
.nav-link-item.active{background:rgba(61,82,160,0.3);color:#fff;border-right:3px solid #7b8dd1;}
 
/* ── HEADER ── */
.app-header{position:fixed;top:0;left:var(--sidebar-w);right:0;height:var(--header-h);background:#fff;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;padding:0 24px;z-index:90;box-shadow:var(--shadow-sm);}
.breadcrumb-trail{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--text-muted);}
.breadcrumb-trail a{color:var(--primary);text-decoration:none;font-weight:500;}
.breadcrumb-trail .sep{color:var(--input-border);}
.breadcrumb-trail .current{color:var(--text-dark);font-weight:600;}
.header-right{display:flex;align-items:center;gap:12px;}
.header-btn{width:36px;height:36px;border-radius:var(--radius-sm);border:1px solid var(--card-border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-muted);transition:all var(--transition);position:relative;}
.header-btn:hover{border-color:var(--primary);color:var(--primary);}
.header-btn .dot{position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:var(--danger);border:1.5px solid #fff;}
.user-pill{display:flex;align-items:center;gap:8px;background:var(--primary-light);border-radius:20px;padding:4px 12px 4px 4px;cursor:pointer;}
.user-avatar-h{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;}
.user-name{font-size:12px;font-weight:600;color:var(--primary);}

/* ── MAIN ── */
.main-content{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:0 0 40px;}

/* ── HERO BANNER ── */ 
.profile-banner{
  background:linear-gradient(135deg,#1e2140 0%,#2d3d80 50%,#3d52a0 100%);
  padding:32px 28px 0; position:relative; overflow:hidden;
}
.profile-banner::before{
  content:''; position:absolute; top:-60px; right:-60px;
  width:300px; height:300px; border-radius:50%;
  background:rgba(255,255,255,0.04); pointer-events:none;
}
.profile-banner::after{
  content:''; position:absolute; bottom:-80px; left:30%;
  width:200px; height:200px; border-radius:50%;
  background:rgba(123,141,209,0.1); pointer-events:none;
}
.banner-inner{display:flex;gap:24px;align-items:flex-end;position:relative;z-index:1;}
.profile-avatar-wrap{position:relative;flex-shrink:0;}
.profile-avatar{
  width:100px; height:100px; border-radius:50%;
  border:4px solid rgba(255,255,255,0.3);
  display:flex;align-items:center;justify-content:center;
  font-size:36px;font-weight:800;color:#fff;
  background:linear-gradient(135deg,#7b8dd1,#3d52a0);
  overflow:hidden; position:relative;
}
.profile-avatar img{width:100%;height:100%;object-fit:cover;border-radius:50%;display:none;}
.online-ring{position:absolute;bottom:4px;right:4px;width:20px;height:20px;border-radius:50%;border:3px solid #1e2140;background:var(--success);}
.banner-info{flex:1;padding-bottom:20px;}
.banner-info .emp-chip{
  display:inline-flex;align-items:center;gap:5px;
  background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);
  border-radius:6px;padding:2px 10px;
  font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:600;color:#c5cff7;
  margin-bottom:6px;
}
.banner-info h1{font-size:22px;font-weight:800;color:#fff;letter-spacing:-.3px;margin-bottom:3px;}
.banner-info .sub{font-size:13px;color:rgba(255,255,255,0.65);margin-bottom:10px;}
.banner-tags{display:flex;gap:6px;flex-wrap:wrap;}
.btag{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.btag-active{background:rgba(16,185,129,0.2);color:#6ee7b7;border:1px solid rgba(110,231,183,0.25);}
.btag-dept{background:rgba(197,207,247,0.15);color:#c5cff7;border:1px solid rgba(197,207,247,0.2);}
.btag-role{background:rgba(139,92,246,0.2);color:#c4b5fd;border:1px solid rgba(196,181,253,0.25);}
.btag-type{background:rgba(20,184,166,0.2);color:#99f6e4;border:1px solid rgba(153,246,228,0.25);}
.banner-actions{padding-bottom:20px;display:flex;gap:8px;flex-wrap:wrap;align-self:flex-end;}
.btn{padding:9px 16px;border-radius:var(--radius-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--transition);display:inline-flex;align-items:center;gap:7px;}
.btn-white{background:#fff;color:var(--primary);}
.btn-white:hover{background:#f0f4ff;}
.btn-ghost{background:rgba(255,255,255,0.12);color:#fff;border:1px solid rgba(255,255,255,0.2);}
.btn-ghost:hover{background:rgba(255,255,255,0.2);}
.btn-primary{background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;box-shadow:0 4px 12px rgba(61,82,160,0.28);}
.btn-primary:hover{transform:translateY(-1px);}
.btn-secondary{background:#fff;color:var(--text-mid);border:1.5px solid var(--card-border);}
.btn-secondary:hover{border-color:var(--primary);color:var(--primary);}
.btn-danger-soft{background:var(--danger-light);color:var(--danger);border:1.5px solid #fca5a5;}
.btn-sm{padding:6px 12px;font-size:12px;}
.btn-xs{padding:4px 10px;font-size:11px;}

/* ── TABS ── */
.profile-tabs{display:flex;gap:0;background:rgba(255,255,255,0.06);border-top:1px solid rgba(255,255,255,0.1);position:relative;z-index:1;padding:0 28px;}
.ptab{padding:12px 18px;font-size:13px;font-weight:600;color:rgba(255,255,255,0.55);cursor:pointer;border-bottom:3px solid transparent;transition:all var(--transition);white-space:nowrap;display:flex;align-items:center;gap:7px;}
.ptab:hover{color:rgba(255,255,255,0.85);}
.ptab.active{color:#fff;border-bottom-color:#7b8dd1;}
.ptab .tab-count{background:rgba(255,255,255,0.15);border-radius:20px;padding:1px 7px;font-size:10px;font-weight:700;}

/* ── BODY LAYOUT ── */
.profile-body{padding:22px 28px;display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;}
.tab-content{display:none;}
.tab-content.active{display:contents;}

/* ── CARDS ── */
.card{background:var(--card-bg);border:1px solid var(--card-border);border-radius:var(--radius-md);box-shadow:var(--shadow-sm);overflow:hidden;}
.card-header{padding:13px 18px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:10px;}
.section-icon{width:30px;height:30px;border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.si-blue{background:var(--primary-light);color:var(--primary);}
.si-green{background:var(--success-light);color:var(--success-dark);}
.si-purple{background:var(--purple-light);color:var(--purple);}
.si-orange{background:var(--orange-light);color:var(--orange);}
.si-teal{background:var(--teal-light);color:var(--teal);}
.si-pink{background:var(--pink-light);color:var(--pink);}
.si-red{background:var(--danger-light);color:var(--danger);}
.card-header h6{font-size:13px;font-weight:700;color:var(--text-dark);flex:1;margin:0;}
.card-header .card-actions{display:flex;gap:6px;align-items:center;}
.card-body{padding:18px;}
.mb-card{margin-bottom:18px;}

/* ── QUICK STATS ROW ── */
.quick-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px;}
.qs-card{background:var(--card-bg);border:1px solid var(--card-border);border-radius:var(--radius-md);padding:14px 16px;box-shadow:var(--shadow-sm);position:relative;overflow:hidden;}
.qs-card::after{content:'';position:absolute;top:-16px;right:-16px;width:60px;height:60px;border-radius:50%;opacity:.06;}
.qs-blue::after{background:var(--primary);}
.qs-green::after{background:var(--success);}
.qs-orange::after{background:var(--orange);}
.qs-purple::after{background:var(--purple);}
.qs-card .qi{width:36px;height:36px;border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:10px;}
.qs-blue .qi{background:var(--primary-light);color:var(--primary);}
.qs-green .qi{background:var(--success-light);color:var(--success-dark);}
.qs-orange .qi{background:var(--orange-light);color:var(--orange);}
.qs-purple .qi{background:var(--purple-light);color:var(--purple);}
.qs-card .qv{font-size:22px;font-weight:800;font-family:'JetBrains Mono',monospace;line-height:1;}
.qs-blue .qv{color:var(--primary);}
.qs-green .qv{color:var(--success-dark);}
.qs-orange .qv{color:var(--orange);}
.qs-purple .qv{color:var(--purple);}
.qs-card .ql{font-size:11px;color:var(--text-muted);font-weight:600;margin-top:3px;}
.qs-card .qdelta{font-size:11px;font-weight:700;margin-top:6px;display:flex;align-items:center;gap:3px;}
.delta-up{color:var(--success);}
.delta-dn{color:var(--danger);}

/* ── INFO GRID ── */
.info-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.info-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.info-item .il{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:4px;}
.info-item .iv{font-size:13px;font-weight:600;color:var(--text-dark);}
.info-item .iv.mono{font-family:'JetBrains Mono',monospace;}
.info-item .iv a{color:var(--primary);text-decoration:none;}
.info-item .iv a:hover{text-decoration:underline;}
.span-2{grid-column:span 2;}
.span-3{grid-column:span 3;}

/* ── SECTION DIVIDER ── */
.sdiv{display:flex;align-items:center;gap:10px;margin:16px 0 14px;}
.sdiv span{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);white-space:nowrap;}
.sdiv::before,.sdiv::after{content:'';flex:1;height:1px;background:var(--card-border);}

/* ── BADGE ── */
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap;}
.b-active{background:var(--success-light);color:#065f46;}
.b-inactive{background:#f1f5f9;color:#64748b;}
.b-leave{background:var(--warning-light);color:#92400e;}
.b-probation{background:var(--purple-light);color:#6d28d9;}
.b-dept{background:var(--primary-light);color:var(--primary);}
.b-role{background:var(--purple-light);color:var(--purple);}
.b-type{background:var(--teal-light);color:#0f766e;}
.b-present{background:var(--success-light);color:#065f46;}
.b-absent{background:var(--danger-light);color:#991b1b;}
.b-late{background:var(--warning-light);color:#92400e;}
.b-info{background:var(--info-light);color:#0369a1;}
.b-orange{background:var(--orange-light);color:#c2410c;}
.b-neutral{background:#f1f5f9;color:#475569;}

/* ── SALARY PANEL ── */
.salary-box{background:linear-gradient(135deg,var(--primary) 0%,var(--primary-dark) 100%);border-radius:var(--radius-md);padding:18px;color:#fff;margin-bottom:14px;}
.sb-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;font-size:12px;}
.sb-row:last-child{margin-bottom:0;}
.sb-row .sl{opacity:.8;}
.sb-row .sv{font-family:'JetBrains Mono',monospace;font-weight:700;}
.sb-divider{height:1px;background:rgba(255,255,255,0.2);margin:10px 0;}
.sb-total{display:flex;justify-content:space-between;align-items:center;}
.sb-total .sl{font-size:14px;font-weight:800;}
.sb-total .sv{font-size:20px;font-weight:800;font-family:'JetBrains Mono',monospace;}
.allowance-row,.deduction-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--card-border);font-size:13px;align-items:center;}
.allowance-row:last-child,.deduction-row:last-child{border-bottom:none;}
.allowance-row .name,.deduction-row .name{color:var(--text-mid);font-weight:600;}
.allowance-row .amt{color:var(--success-dark);font-weight:700;font-family:'JetBrains Mono',monospace;}
.deduction-row .amt{color:var(--danger);font-weight:700;font-family:'JetBrains Mono',monospace;}

/* ── WEEK CHART ── */
.week-chart{display:flex;gap:8px;align-items:flex-end;height:80px;margin:4px 0 10px;}
.wbar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;}
.wbar{width:100%;border-radius:4px 4px 0 0;transition:height .5s ease;cursor:pointer;position:relative;}
.wbar:hover::after{content:attr(data-tip);position:absolute;top:-28px;left:50%;transform:translateX(-50%);background:var(--text-dark);color:#fff;padding:2px 8px;border-radius:4px;font-size:10px;font-weight:700;white-space:nowrap;pointer-events:none;}
.wbar-label{font-size:10px;color:var(--text-muted);font-weight:700;}
.wbar-val{font-size:9px;color:var(--text-muted);font-weight:600;}

/* ── ACTIVITY LOG ── */
.activity-log{padding:2px 0;}
.act-item{display:flex;gap:12px;margin-bottom:16px;position:relative;}
.act-item:last-child{margin-bottom:0;}
.act-item::before{content:'';position:absolute;left:15px;top:28px;bottom:-16px;width:1.5px;background:var(--card-border);}
.act-item:last-child::before{display:none;}
.act-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;z-index:1;}
.ad-sale{background:var(--success-light);color:var(--success-dark);}
.ad-login{background:var(--info-light);color:var(--info);}
.ad-edit{background:var(--primary-light);color:var(--primary);}
.ad-leave{background:var(--warning-light);color:var(--warning);}
.ad-print{background:var(--teal-light);color:var(--teal);}
.ad-pass{background:var(--purple-light);color:var(--purple);}
.ad-warn{background:var(--danger-light);color:var(--danger);}
.act-content .ac-title{font-size:12px;font-weight:700;color:var(--text-dark);}
.act-content .ac-sub{font-size:11px;color:var(--text-muted);margin-top:2px;}
.act-content .ac-time{font-size:10px;color:var(--text-muted);margin-top:3px;}
.act-content .ac-badge{margin-top:4px;}

/* ── SALES TABLE ── */
.mini-table{width:100%;border-collapse:collapse;}
.mini-table thead th{padding:8px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);border-bottom:2px solid var(--card-border);background:var(--table-head);white-space:nowrap;}
.mini-table td{padding:10px 12px;font-size:12px;border-bottom:1px solid var(--card-border);vertical-align:middle;}
.mini-table tbody tr:last-child td{border-bottom:none;}
.mini-table tbody tr:hover td{background:#fafbff;}
.mono{font-family:'JetBrains Mono',monospace;}

/* ── DEVICE CARD ── */
.device-item{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--card-border);}
.device-item:last-child{border-bottom:none;}
.device-icon{width:40px;height:40px;border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.dev-desktop{background:var(--primary-light);color:var(--primary);}
.dev-mobile{background:var(--success-light);color:var(--success-dark);}
.dev-tablet{background:var(--purple-light);color:var(--purple);}
.device-info{flex:1;}
.device-info .dn{font-size:13px;font-weight:700;color:var(--text-dark);}
.device-info .ds{font-size:11px;color:var(--text-muted);margin-top:1px;}
.device-meta{text-align:right;}
.device-meta .dm-time{font-size:11px;color:var(--text-muted);}
.device-meta .dm-ip{font-size:10px;font-family:'JetBrains Mono',monospace;color:var(--text-muted);}
.device-status{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
.ds-active{background:var(--success);}
.ds-idle{background:var(--warning);}
.ds-offline{background:#cbd5e1;}

/* ── ATTENDANCE MINI CALENDAR ── */
.att-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:3px;margin-top:8px;}
.att-day-head{font-size:9px;font-weight:800;text-align:center;color:var(--text-muted);padding:2px 0;text-transform:uppercase;}
.att-day{width:100%;aspect-ratio:1;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;cursor:default;}
.att-present{background:var(--success-light);color:#065f46;}
.att-absent{background:var(--danger-light);color:#991b1b;}
.att-late{background:var(--warning-light);color:#92400e;}
.att-weekend{background:#f8faff;color:var(--text-muted);}
.att-empty{background:transparent;color:transparent;}
.att-today{border:2px solid var(--primary);}
.att-legend{display:flex;gap:12px;margin-top:8px;flex-wrap:wrap;}
.att-leg-item{display:flex;align-items:center;gap:5px;font-size:10px;color:var(--text-muted);font-weight:600;}
.att-leg-dot{width:10px;height:10px;border-radius:3px;}

/* ── PROGRESS BAR ── */
.progress-wrap{margin-bottom:10px;}
.progress-label{display:flex;justify-content:space-between;font-size:11px;font-weight:700;color:var(--text-mid);margin-bottom:4px;}
.progress-bar{height:7px;background:#e8ecf4;border-radius:10px;overflow:hidden;}
.progress-fill{height:100%;border-radius:10px;transition:width .8s ease;}

/* ── RIGHT COLUMN SIDEBAR ── */
.right-col{display:flex;flex-direction:column;gap:16px;}

/* Contact quick links */
.contact-link{display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid var(--card-border);font-size:13px;text-decoration:none;color:var(--text-dark);transition:color var(--transition);}
.contact-link:last-child{border-bottom:none;}
.contact-link:hover{color:var(--primary);}
.contact-link .cl-icon{width:32px;height:32px;border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.contact-link .cl-label{font-size:10px;color:var(--text-muted);font-weight:600;}
.contact-link .cl-val{font-size:12px;font-weight:700;}

/* Skills */
.skill-bar{margin-bottom:10px;}
.skill-bar .sk-label{font-size:12px;font-weight:700;margin-bottom:5px;display:flex;justify-content:space-between;}
.skill-bar .sk-track{height:6px;background:#e8ecf4;border-radius:10px;overflow:hidden;}
.skill-bar .sk-fill{height:100%;border-radius:10px;background:linear-gradient(90deg,var(--primary),#7b8dd1);}

/* ── KPI MINI CARDS inside body ── */
.kpi-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:16px;}
.kpi-card{background:#f8faff;border:1px solid var(--card-border);border-radius:var(--radius-sm);padding:12px 14px;}
.kpi-card .kv{font-size:18px;font-weight:800;font-family:'JetBrains Mono',monospace;color:var(--text-dark);}
.kpi-card .kl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);margin-top:2px;}
.kpi-card .ks{font-size:10px;font-weight:700;margin-top:4px;}

/* ── TOAST ── */
#toast-container{position:fixed;top:72px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;pointer-events:none;}
.toast-item{padding:12px 18px;border-radius:var(--radius-sm);font-size:13px;font-weight:600;pointer-events:auto;display:flex;align-items:center;gap:8px;box-shadow:var(--shadow-lg);animation:toastIn .3s ease;max-width:320px;}
@keyframes toastIn{from{opacity:0;transform:translateX(20px);}to{opacity:1;transform:translateX(0);}}
.toast-success{background:var(--success);color:#fff;}
.toast-info{background:var(--primary);color:#fff;}
.toast-warning{background:var(--warning);color:#fff;}

@media(max-width:1100px){.profile-body{grid-template-columns:1fr;}}
@media(max-width:768px){
  :root{--sidebar-w:0px;}
  .quick-stats{grid-template-columns:1fr 1fr;}
  .info-grid-3{grid-template-columns:1fr 1fr;}
  .kpi-strip{grid-template-columns:1fr 1fr;}
}
</style>



<div class="main-content app-content">
    <div class="container-fluid">

        <!-- HERO BANNER -->
        <div class="profile-banner">
            <div class="banner-inner">
                <div class="profile-avatar-wrap">
                    <div class="profile-avatar">
                        <?php if(!empty($staff->profile_photo)): ?>
                            <img src="<?php echo base_url($staff->profile_photo); ?>" alt="" style="display:block;">
                        <?php else: ?>
                            <?php echo substr($staff->full_name, 0, 1); ?>
                        <?php endif; ?>
                    </div>
                    <div class="online-ring" title="<?php echo ucfirst($staff->status); ?>"></div>
                </div>
                <div class="banner-info">
                    <div class="emp-chip"><i class="fa-solid fa-id-badge"></i> <?php echo $staff->staff_no; ?></div>
                    <h1><?php echo $staff->full_name; ?></h1>
                    <div class="sub">
                        <?php echo $staff->designation_name ?: $staff->designation; ?> 
                        · <?php echo $staff->branch_location ?: 'Head Office'; ?>
                    </div>
                    <div class="banner-tags">
                        <span class="btag btag-active"><i class="fa-solid fa-circle" style="font-size:7px"></i> <?php echo ucfirst($staff->status); ?></span>
                        <span class="btag btag-dept"><i class="fa-solid fa-building"></i> <?php echo $staff->branch_location ?: '—'; ?></span>
                        <span class="btag btag-role"><i class="fa-solid fa-user-tie"></i> <?php echo $staff->designation_name ?: 'Staff'; ?></span>
                        <span class="btag btag-type"><i class="fa-solid fa-briefcase"></i> <?php echo ucfirst(str_replace('_', ' ', $staff->employee_type)); ?></span>
                    </div>
                </div>
                <div class="banner-actions">
                   
                </div>
            </div>

            <!-- TABS -->
            <div class="profile-tabs">
                <div class="ptab active" onclick="switchTab('overview')"><i class="fa-solid fa-house"></i> Overview</div>
                <div class="ptab" onclick="switchTab('sales')"><i class="fa-solid fa-chart-line"></i> Sales 
                    <span class="tab-count"><?php echo count($staff->recent_sales ?? []); ?></span>
                </div>
                <div class="ptab" onclick="switchTab('salary')"><i class="fa-solid fa-sack-dollar"></i> Salary</div>
                <div class="ptab" onclick="switchTab('activity')"><i class="fa-solid fa-clock-rotate-left"></i> Activity 
                    <span class="tab-count"><?php echo count($staff->activities ?? []); ?></span>
                </div>
            </div>
        </div><!-- END profile-banner -->

        <!-- BODY -->
        <div class="profile-body">
            <!-- LEFT COLUMN -->
            <div id="main-col">
                <!-- OVERVIEW TAB -->
                <div class="tab-content active" id="tab-overview">
                    <!-- General Info Card -->
                    <div class="card mb-card">
                        <div class="card-header">
                            <div class="section-icon si-blue"><i class="fa-solid fa-user"></i></div>
                            <h6>General Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="sdiv"><span>Personal</span></div>
                            <div class="info-grid-3">
                                <div class="info-item"><div class="il">Full Name</div><div class="iv"><?php echo $staff->full_name; ?></div></div>
                                <div class="info-item"><div class="il">Calling Name</div><div class="iv"><?php echo $staff->calling_name ?: '—'; ?></div></div>
                                <div class="info-item"><div class="il">Gender</div><div class="iv"><?php echo $staff->gender ?: '—'; ?></div></div>
                                <div class="info-item"><div class="il">Date of Birth</div><div class="iv"><?php echo $staff->dob ? date('d M Y', strtotime($staff->dob)) : '—'; ?></div></div>
                                <div class="info-item"><div class="il">Age</div><div class="iv"><?php echo isset($staff->age) ? $staff->age.' years' : '—'; ?></div></div>
                                <div class="info-item"><div class="il">NIC/Passport</div><div class="iv mono"><?php echo $staff->nic_passport ?: '—'; ?></div></div>
                                <div class="info-item"><div class="il">Blood Group</div><div class="iv"><?php echo $staff->blood_group ?: '—'; ?></div></div>
                            </div>
                            
                            <div class="sdiv"><span>Employment</span></div>
                            <div class="info-grid-3">
                                <div class="info-item"><div class="il">Staff No</div><div class="iv mono" style="color:var(--primary);"><?php echo $staff->staff_no; ?></div></div>
                                <div class="info-item"><div class="il">Department</div><div class="iv"><?php echo $staff->branch_location ?: '—'; ?></div></div>
                                <div class="info-item"><div class="il">Designation</div><div class="iv"><?php echo $staff->designation_name ?: $staff->designation; ?></div></div>
                                <div class="info-item"><div class="il">Employment Type</div><div class="iv"><?php echo ucfirst(str_replace('_', ' ', $staff->employee_type)); ?></div></div>
                                <div class="info-item"><div class="il">Joining Date</div><div class="iv"><?php echo $staff->joining_date ? date('d M Y', strtotime($staff->joining_date)) : '—'; ?></div></div>
                                <div class="info-item"><div class="il">Tenure</div><div class="iv"><?php echo isset($staff->tenure) ? $staff->tenure : '—'; ?></div></div>
                                <div class="info-item"><div class="il">Status</div><div class="iv"><span class="badge b-active"><?php echo ucfirst($staff->status); ?></span></div></div>
                            </div>
                            
                            <div class="sdiv"><span>System Access</span></div>
                            <div class="info-grid-3">
                                <div class="info-item"><div class="il">Username</div><div class="iv mono"><?php echo $staff->phone; ?></div></div>
                                <div class="info-item"><div class="il">User Role</div><div class="iv"><?php echo $staff->designation_name ?: '—'; ?></div></div>
                                <div class="info-item"><div class="il">Account Status</div>
                                    <div class="iv">
                                        <?php if(isset($staff->has_account)): ?>
                                            <span class="badge <?php echo $staff->user_status == 'act' ? 'b-active' : 'b-inactive'; ?>">
                                                <?php echo $staff->user_status == 'act' ? 'Active' : 'Locked'; ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge b-neutral">No Account</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="info-item"><div class="il">EPF Enrolled</div><div class="iv"><?php echo $staff->epf_enabled ? 'Yes' : 'No'; ?></div></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Card -->
                    <div class="card mb-card">
                        <div class="card-header">
                            <div class="section-icon si-green"><i class="fa-solid fa-address-card"></i></div>
                            <h6>Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="info-grid-2">
                                <div class="info-item"><div class="il">Primary Phone</div><div class="iv"><?php echo $staff->phone; ?></div></div>
                                <div class="info-item"><div class="il">Secondary Phone</div><div class="iv"><?php echo $staff->phone2 ?: '—'; ?></div></div>
                                <div class="info-item"><div class="il">Email</div><div class="iv"><?php echo $staff->email ?: '—'; ?></div></div>
                                <div class="info-item"><div class="il">Emergency Contact</div><div class="iv"><?php echo $staff->emergency_contact ?: '—'; ?></div></div>
                                <div class="info-item span-2"><div class="il">Address</div><div class="iv"><?php echo $staff->address ?: '—'; ?></div></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bank Details -->
                    <?php if($staff->bank_name): ?>
                    <div class="card mb-card">
                        <div class="card-header">
                            <div class="section-icon si-purple"><i class="fa-solid fa-building-columns"></i></div>
                            <h6>Bank Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="info-grid-2">
                                <div class="info-item"><div class="il">Bank Name</div><div class="iv"><?php echo $staff->bank_name; ?></div></div>
                                <div class="info-item"><div class="il">Branch</div><div class="iv"><?php echo $staff->bank_branch ?: '—'; ?></div></div>
                                <div class="info-item"><div class="il">Account Number</div><div class="iv mono"><?php echo $staff->account_no; ?></div></div>
                                <div class="info-item"><div class="il">Account Name</div><div class="iv"><?php echo $staff->account_name; ?></div></div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Notes -->
                    <?php if(!empty($staff->internal_notes)): ?>
                    <div class="card mb-card">
                        <div class="card-header">
                            <div class="section-icon si-orange"><i class="fa-solid fa-note-sticky"></i></div>
                            <h6>Internal Notes</h6>
                        </div>
                        <div class="card-body">
                            <?php echo nl2br($staff->internal_notes); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div><!-- END overview tab -->

                <!-- SALES TAB -->
                <div class="tab-content" id="tab-sales" style="display:none;">
                    <?php if(!empty($staff->sales_summary)): ?>
                    <div class="quick-stats">
                        <div class="qs-card qs-green">
                            <div class="qi"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                            <div class="qv"><?php echo $staff->sales_summary['current_month']['count']; ?></div>
                            <div class="ql">Invoices This Month</div>
                        </div>
                        <div class="qs-card qs-blue">
                            <div class="qi"><i class="fa-solid fa-money-bill-wave"></i></div>
                            <div class="qv"><?php echo number_format($staff->sales_summary['current_month']['total'] / 1000, 1); ?>K</div>
                            <div class="ql">Revenue (LKR)</div>
                        </div>
                        <div class="qs-card qs-orange">
                            <div class="qi"><i class="fa-solid fa-clock"></i></div>
                            <div class="qv"><?php echo $staff->sales_summary['pending']['count']; ?></div>
                            <div class="ql">Pending Payment</div>
                        </div>
                        <div class="qs-card qs-purple">
                            <div class="qi"><i class="fa-solid fa-chart-line"></i></div>
                            <div class="qv"><?php echo $staff->sales_summary['total_invoices']; ?></div>
                            <div class="ql">Total Invoices</div>
                        </div>
                    </div>
                    
                    <div class="card mb-card">
                        <div class="card-header">
                            <div class="section-icon si-green"><i class="fa-solid fa-chart-bar"></i></div>
                            <h6>Last 7 Days — Sales Activity</h6>
                        </div>
                        <div class="card-body">
                            <div class="week-chart" id="sales-week-chart"></div>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:10px;" id="week-labels"></div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="card mb-card">
                        <div class="card-header">
                            <div class="section-icon si-teal"><i class="fa-solid fa-receipt"></i></div>
                            <h6>Recent Sales Invoices</h6>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="mini-table">
                                <thead>
                                    <tr>
                                        <th>Invoice No.</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Total (LKR)</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($staff->recent_sales)): ?>
                                        <?php foreach($staff->recent_sales as $sale): ?>
                                        <tr>
                                            <td class="mono" style="color:var(--primary);"><?php echo $sale->invoice_no; ?></td>
                                            <td><?php echo date('d M Y', strtotime($sale->invoice_date)); ?></td>
                                            <td><?php echo $sale->customer_name ?: '—'; ?></td>
                                            <td class="text-center"><?php echo $sale->total_items; ?></td>
                                            <td class="mono fw-bold">Rs. <?php echo number_format($sale->grand_total, 2); ?></td>
                                            <td>
                                                <?php
                                                $status_class = ['COMPLETED'=>'b-active','DRAFT'=>'b-neutral','CANCELLED'=>'b-absent'];
                                                $cls = $status_class[$sale->status] ?? 'b-neutral';
                                                ?>
                                                <span class="badge <?php echo $cls; ?>"><?php echo ucfirst(strtolower($sale->status)); ?></span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="6" class="text-center text-muted py-4">No sales records found</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- END sales tab -->

                <!-- SALARY TAB -->
                <div class="tab-content" id="tab-salary" style="display:none;">
                    <div class="card mb-card">
                        <div class="card-header">
                            <div class="section-icon si-green"><i class="fa-solid fa-sack-dollar"></i></div>
                            <h6>Salary Structure</h6>
                        </div>
                        <div class="card-body">
                            <div class="salary-box">
                                <div class="sb-row"><span class="sl">Basic Salary</span><span class="sv">Rs. <?php echo number_format($staff->basic_salary, 2); ?></span></div>
                                <div class="sb-row"><span class="sl">Total Allowances</span><span class="sv" style="color:#6ee7b7;">+ Rs. <?php echo number_format($staff->total_allowances, 2); ?></span></div>
                                <div class="sb-row"><span class="sl">Fixed Deductions</span><span class="sv" style="color:#fca5a5;">− Rs. <?php echo number_format($staff->total_deductions, 2); ?></span></div>
                                <?php if($staff->epf_enabled): ?>
                                <div class="sb-row"><span class="sl">EPF Employee (<?php echo $staff->epf_employee_pct; ?>%)</span><span class="sv" style="color:#fca5a5;">− Rs. <?php echo number_format($staff->epf_employee, 2); ?></span></div>
                                <?php endif; ?>
                                <div class="sb-divider"></div>
                                <div class="sb-total"><span class="sl">Net Take-Home</span><span class="sv">Rs. <?php echo number_format($staff->net_salary, 2); ?></span></div>
                            </div>
                            
                            <?php if(!empty($staff->allowances)): ?>
                            <div class="sdiv"><span>Allowances</span></div>
                            <?php foreach($staff->allowances as $a): ?>
                            <div class="allowance-row"><span class="name"><?php echo $a->allowance_name; ?></span><span class="amt">+ Rs. <?php echo number_format($a->amount, 2); ?></span></div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <?php if(!empty($staff->deductions)): ?>
                            <div class="sdiv"><span>Deductions</span></div>
                            <?php foreach($staff->deductions as $d): ?>
                            <div class="deduction-row"><span class="name"><?php echo $d->deduction_name; ?></span><span class="amt">− Rs. <?php echo number_format($d->amount, 2); ?></span></div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <?php if($staff->epf_enabled): ?>
                            <div class="sdiv"><span>EPF / ETF</span></div>
                            <div style="background:var(--info-light);border-radius:8px;padding:12px;">
                                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                                    <div><div style="font-size:10px;font-weight:700;">EPF Employee</div><div class="mono">Rs. <?php echo number_format($staff->epf_employee, 2); ?></div></div>
                                    <div><div style="font-size:10px;font-weight:700;">EPF Employer</div><div class="mono">Rs. <?php echo number_format($staff->epf_employer, 2); ?></div></div>
                                    <div><div style="font-size:10px;font-weight:700;">ETF Employer</div><div class="mono">Rs. <?php echo number_format($staff->etf_employer, 2); ?></div></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div><!-- END salary tab -->

                <!-- ACTIVITY TAB -->
                <div class="tab-content" id="tab-activity" style="display:none;">
                    <div class="card mb-card">
                        <div class="card-header">
                            <div class="section-icon si-purple"><i class="fa-solid fa-clock-rotate-left"></i></div>
                            <h6>Recent Activity Log</h6>
                        </div>
                        <div class="card-body">
                            <div class="activity-log">
                                <?php if(!empty($staff->activities)): ?>
                                    <?php foreach($staff->activities as $act): 
                                        $formatted = $this->Staff_model->format_activity($act);
                                    ?>
                                    <div class="act-item">
                                        <div class="act-dot <?php echo $formatted['cls']; ?>">
                                            <i class="fa-solid <?php echo $formatted['icon']; ?>"></i>
                                        </div>
                                        <div class="act-content">
                                            <div class="ac-title"><?php echo $formatted['title']; ?></div>
                                            <div class="ac-sub"><?php echo $formatted['description']; ?></div>
                                            <div class="ac-time">
                                                <i class="fa-regular fa-clock"></i> <?php echo $formatted['time']; ?>
                                            </div>
                                            <?php if($formatted['badge']): ?>
                                            <div class="ac-badge">
                                                <span class="badge b-info"><?php echo $formatted['badge']; ?></span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center text-muted py-4">No activity recorded</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div><!-- END activity tab -->
            </div><!-- END main-col -->

            <!-- RIGHT SIDEBAR -->
            <div class="right-col">
                <div class="card">
                    <div class="card-header">
                        <div class="section-icon si-blue"><i class="fa-solid fa-address-card"></i></div>
                        <h6>Contact</h6>
                    </div>
                    <div class="card-body">
                        <a class="contact-link" href="tel:<?php echo $staff->phone; ?>">
                            <div class="cl-icon" style="background:var(--success-light);color:var(--success-dark);"><i class="fa-solid fa-phone"></i></div>
                            <div><div class="cl-label">Primary Phone</div><div class="cl-val"><?php echo $staff->phone; ?></div></div>
                        </a>
                        <?php if($staff->email): ?>
                        <a class="contact-link" href="mailto:<?php echo $staff->email; ?>">
                            <div class="cl-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-envelope"></i></div>
                            <div><div class="cl-label">Email</div><div class="cl-val"><?php echo $staff->email; ?></div></div>
                        </a>
                        <?php endif; ?>
                        <?php if($staff->emergency_contact): ?>
                        <a class="contact-link" href="tel:<?php echo $staff->emergency_contact; ?>">
                            <div class="cl-icon" style="background:var(--orange-light);color:var(--orange);"><i class="fa-solid fa-phone-volume"></i></div>
                            <div><div class="cl-label">Emergency</div><div class="cl-val"><?php echo $staff->emergency_contact; ?></div></div>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="section-icon si-purple"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <h6>Audit Trail</h6>
                    </div>
                    <div class="card-body">
                        <div style="display:flex;justify-content:space-between;padding:7px 0;"><span style="color:var(--text-muted);">Staff No</span><span style="font-weight:700;"><?php echo $staff->staff_no; ?></span></div>
                        <div style="display:flex;justify-content:space-between;padding:7px 0;"><span style="color:var(--text-muted);">Status</span><span style="font-weight:700;"><?php echo ucfirst($staff->status); ?></span></div>
                        <div style="display:flex;justify-content:space-between;padding:7px 0;"><span style="color:var(--text-muted);">Joining Date</span><span style="font-weight:700;"><?php echo $staff->joining_date ? date('d M Y', strtotime($staff->joining_date)) : '—'; ?></span></div>
                    </div>
                </div>
            </div><!-- END right-col -->
        </div><!-- END profile-body -->
    </div>
</div>

<script>
function switchTab(tab){
    $('.ptab').removeClass('active');
    $('.ptab').each(function(){
        if($(this).text().toLowerCase().includes(tab)){
            $(this).addClass('active');
        }
    });
    $('.tab-content').hide();
    $('#tab-'+tab).show();
}

var weekData = <?php echo json_encode($staff->sales_summary['week_data'] ?? []); ?>;

function renderSalesChart() {
    if (!weekData.length) return;
    var maxTotal = Math.max.apply(null, weekData.map(function(d) { return d.total; }));
    var wrap = $('#sales-week-chart'); 
    var labWrap = $('#week-labels');
    wrap.empty(); 
    labWrap.empty();
    weekData.forEach(function(d) {
        var pct = maxTotal > 0 ? Math.round((d.total / maxTotal) * 100) : 0;
        var h = Math.max(pct * 0.7, 4);
        var tip = d.label + ': ' + d.count + ' inv · Rs.' + d.total.toLocaleString();
        wrap.append('<div class="wbar-wrap"><div class="wbar" style="height:' + h + 'px;background:' + (d.count > 0 ? 'var(--primary-mid)' : '#e8ecf4') + ';" data-tip="' + tip + '" title="' + tip + '"></div><div class="wbar-label">' + d.day + '</div><div class="wbar-val">' + (d.count > 0 ? d.count : '—') + '</div></div>');
        if (d.count > 0) labWrap.append('<span class="badge b-info" style="font-size:10px;">' + d.label + ': ' + d.count + ' inv</span>');
    });
}

$(document).ready(function() {
    renderSalesChart();
});
</script>   