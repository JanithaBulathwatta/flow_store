<style>
	:root{
	  --primary:#3d52a0;--primary-d:#2d3d80;--primary-light:#eef1fb;--primary-mid:#c5cff7;
	  --success:#10b981;--success-light:#d1fae5;
	  --danger:#ef4444;--danger-light:#fee2e2;
	  --warning:#f59e0b;--warning-light:#fef3c7;
	  --info:#0ea5e9;--info-light:#e0f2fe;
	  --mandatory:#f97316;--mandatory-light:#ffedd5;
	  --sidebar-bg:#1a1f36;--sidebar-text:#a8b4d8;
	  --page-bg:#f2f4fa;--card-bg:#fff;--card-border:#e4e9f4;
	  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
	  --input-border:#d1d9e6;--table-head:#f7f9ff;
	  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.11);--sh-lg:0 8px 36px rgba(61,82,160,.16);
	  --r-sm:8px;--r-md:12px;--r-lg:16px;
	  --sidebar-w:240px;--header-h:60px;--tr:.2s cubic-bezier(.4,0,.2,1);
	}
	*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
	body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;overflow-x:hidden;}
	::-webkit-scrollbar{width:5px;height:5px;}::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

	/* ── SIDEBAR ── */
	.sidebar{position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-w);background:var(--sidebar-bg);z-index:100;display:flex;flex-direction:column;}
	.sb-logo{height:var(--header-h);display:flex;align-items:center;padding:0 18px;border-bottom:1px solid rgba(255,255,255,.06);}
	.logo-m{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;font-size:15px;color:#fff;font-weight:800;flex-shrink:0;}
	.logo-t{margin-left:10px;color:#fff;font-weight:700;font-size:15px;letter-spacing:-.3px;}.logo-t span{color:#7b8dd1;}
	.sb-nav{flex:1;overflow-y:auto;padding:10px 0;}
	.sb-cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(168,180,216,.4);padding:14px 18px 5px;}
	.sb-link{display:flex;align-items:center;gap:10px;padding:9px 18px;color:var(--sidebar-text);text-decoration:none;font-size:13px;font-weight:500;cursor:pointer;transition:all var(--tr);}
	.sb-link i{font-size:15px;width:18px;text-align:center;flex-shrink:0;}
	.sb-link:hover{background:rgba(255,255,255,.05);color:#fff;}
	.sb-link.active{background:rgba(61,82,160,.28);color:#fff;border-right:3px solid #7b8dd1;}

	/* ── HEADER ── */
	.header{position:fixed;top:0;left:var(--sidebar-w);right:0;height:var(--header-h);background:#fff;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;padding:0 22px;z-index:90;box-shadow:var(--sh-sm);}
	.hdr-l{display:flex;align-items:center;gap:14px;}
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

	/* ── PAGE HEADER ── */
	.pg-hdr{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:18px;gap:14px;flex-wrap:wrap;}
	.pg-hdr-left h1{font-size:19px;font-weight:800;letter-spacing:-.3px;}
	.pg-hdr-left p{font-size:13px;color:var(--text-muted);margin-top:3px;}
	.pg-actions{display:flex;gap:8px;align-items:center;}
	.btn{padding:9px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;gap:6px;}
	.btn-primary{background:var(--primary);color:#fff;box-shadow:0 2px 8px rgba(61,82,160,.25);}
	.btn-primary:hover{background:var(--primary-d);transform:translateY(-1px);}
	.btn-outline{background:#fff;color:var(--text-mid);border:1.5px solid var(--card-border);}
	.btn-outline:hover{border-color:var(--primary);color:var(--primary);}
	.btn-sm{padding:7px 12px;font-size:12px;}

	/* ── STATS BAR ── */
	.stats-bar{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px;}
	.stat-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:14px 16px;display:flex;align-items:center;gap:12px;box-shadow:var(--sh-sm);transition:all var(--tr);}
	.stat-card:hover{transform:translateY(-1px);box-shadow:var(--sh-md);}
	.stat-icon{width:38px;height:38px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
	.stat-info .sv{font-size:20px;font-weight:800;color:var(--text-dark);font-family:'JetBrains Mono',monospace;line-height:1;}
	.stat-info .sl{font-size:11px;color:var(--text-muted);font-weight:600;margin-top:3px;}

	/* ── LAYOUT ── */
	.layout{display:grid;grid-template-columns:200px 1fr;gap:16px;align-items:start;}

	/* ── FILTER PANEL ── */
	.filter-panel{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);position:sticky;top:78px;overflow:hidden;}
	.fp-head{padding:13px 16px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:8px;}
	.fp-head h6{font-size:13px;font-weight:700;color:var(--text-dark);margin:0;}
	.fp-si{width:26px;height:26px;border-radius:6px;background:var(--primary-light);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:12px;flex-shrink:0;}
	.fp-search{padding:10px 12px;border-bottom:1px solid var(--card-border);}
	.fp-sw{position:relative;}
	.fp-sw i{position:absolute;left:9px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;pointer-events:none;}
	.fp-sw input{width:100%;padding:7px 10px 7px 28px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;color:var(--text-dark);outline:none;transition:border-color var(--tr);background:var(--page-bg);}
	.fp-sw input:focus{border-color:var(--primary);}
	.fp-groups{padding:6px 0;}
	.fg-item{display:flex;align-items:center;justify-content:space-between;padding:9px 16px;cursor:pointer;transition:all var(--tr);font-size:12px;font-weight:500;color:var(--text-mid);border-left:3px solid transparent;}
	.fg-item:hover{background:var(--primary-light);color:var(--primary);}
	.fg-item.active{background:var(--primary-light);color:var(--primary);border-left-color:var(--primary);font-weight:700;}
	.fg-name{display:flex;align-items:center;gap:7px;}
	.fg-name i{font-size:13px;width:14px;text-align:center;}
	.fg-cnt{font-size:10px;font-weight:800;background:var(--primary-mid);color:var(--primary);padding:1px 7px;border-radius:20px;}
	.fg-item.active .fg-cnt{background:var(--primary);color:#fff;}
	.fp-legend{padding:12px 14px;border-top:1px solid var(--card-border);}
	.fl-title{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:7px;}
	.fl-row{display:flex;align-items:center;gap:7px;font-size:11px;font-weight:600;color:var(--text-muted);margin-bottom:5px;}
	.fl-row:last-child{margin-bottom:0;}
	.fl-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}

	/* ── TOOLBAR ── */
	.toolbar{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:10px 14px;display:flex;align-items:center;gap:8px;margin-bottom:12px;flex-wrap:wrap;box-shadow:var(--sh-sm);}
	.tb-l{display:flex;align-items:center;gap:7px;flex:1;flex-wrap:wrap;}
	.tb-btn{padding:5px 11px;border-radius:var(--r-sm);border:1.5px solid var(--card-border);background:#fff;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--text-muted);transition:all var(--tr);display:flex;align-items:center;gap:4px;}
	.tb-btn:hover,.tb-btn.active{border-color:var(--primary);color:var(--primary);background:var(--primary-light);}
	.tb-div{width:1px;height:18px;background:var(--card-border);}

	/* ── GROUP SECTION ── */
	.group-section{margin-bottom:14px;}
	.group-header{display:flex;align-items:center;justify-content:space-between;padding:11px 16px;background:linear-gradient(90deg,var(--primary-light),#f8faff);border:1px solid var(--primary-mid);border-radius:var(--r-md);cursor:pointer;transition:all var(--tr);user-select:none;}
	.group-header:hover{filter:brightness(.97);}
	.gh-l{display:flex;align-items:center;gap:10px;}
	.gh-icon{width:30px;height:30px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
	.gh-title{font-size:13px;font-weight:800;color:var(--primary);}
	.gh-sub{font-size:11px;color:var(--text-muted);margin-top:1px;}
	.gh-r{display:flex;align-items:center;gap:10px;}
	.gh-pills{display:flex;gap:5px;}
	.gh-pill{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;}
	.gp-edit{background:var(--primary-light);color:var(--primary);}
	.gp-lock{background:var(--mandatory-light);color:#c2410c;}
	.gh-chev{color:var(--text-muted);font-size:12px;transition:transform var(--tr);}
	.gh-chev.open{transform:rotate(90deg);}

	/* ── CONFIG ROWS ── */
	.configs-wrap{border:1px solid var(--card-border);border-top:none;border-radius:0 0 var(--r-md) var(--r-md);overflow:hidden;background:#fff;}
	.cfg-row{border-bottom:1px solid var(--card-border);transition:background var(--tr);position:relative;}
	.cfg-row:last-child{border-bottom:none;}
	.cfg-row:hover{background:#fafbff;}
	.cfg-row.locked-row{background:repeating-linear-gradient(135deg,#fafbff 0,#fafbff 6px,#f5f6fa 6px,#f5f6fa 12px);}
	.lock-bar{position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--mandatory);}

	.cfg-inner{display:grid;grid-template-columns:1fr auto;gap:20px;padding:14px 18px 14px 20px;align-items:center;}

	/* left info side */
	.cfg-info{}
	.cfg-top{display:flex;align-items:center;gap:8px;margin-bottom:5px;flex-wrap:wrap;}
	.cfg-label{font-size:13px;font-weight:700;color:var(--text-dark);}
	.cfg-name{font-size:10px;font-family:'JetBrains Mono',monospace;background:var(--table-head);border:1px solid var(--card-border);color:var(--text-muted);padding:2px 6px;border-radius:4px;font-weight:600;}
	.b-locked{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;background:var(--mandatory-light);color:#c2410c;}
	.b-type{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;background:var(--info-light);color:#0369a1;}
	.cfg-desc{font-size:12px;color:var(--text-muted);font-weight:500;line-height:1.5;}

	/* right control side */
	.cfg-control{display:flex;align-items:center;gap:12px;flex-shrink:0;}

	/* Integer input */
	.int-input-wrap{display:flex;align-items:center;gap:6px;}
	.int-btn{width:28px;height:28px;border-radius:var(--r-sm);border:1.5px solid var(--input-border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;color:var(--text-mid);transition:all var(--tr);}
	.int-btn:hover:not(:disabled){border-color:var(--primary);color:var(--primary);background:var(--primary-light);}
	.int-btn:disabled{opacity:.35;cursor:not-allowed;}
	.cfg-int{width:70px;padding:7px 8px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:'JetBrains Mono',monospace;font-size:14px;font-weight:700;text-align:center;outline:none;transition:border-color var(--tr),box-shadow var(--tr);color:var(--text-dark);}
	.cfg-int:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
	.cfg-int:disabled{background:var(--table-head);color:var(--text-muted);cursor:not-allowed;}

	/* Text input */
	.cfg-text{width:220px;padding:8px 11px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr),box-shadow var(--tr);}
	.cfg-text:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
	.cfg-text:disabled{background:var(--table-head);color:var(--text-muted);cursor:not-allowed;font-family:'JetBrains Mono',monospace;}

	/* Password / API key input */
	.cfg-pass-wrap{position:relative;width:220px;}
	.cfg-pass{width:100%;padding:8px 34px 8px 11px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:'JetBrains Mono',monospace;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr);letter-spacing:2px;}
	.cfg-pass:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
	.cfg-pass:disabled{background:var(--table-head);color:var(--text-muted);cursor:not-allowed;}
	.pass-eye{position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:13px;padding:2px;transition:color var(--tr);}
	.pass-eye:hover{color:var(--primary);}

	/* Select / Dropdown */
	.cfg-select{width:180px;padding:8px 11px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;background:#fff;cursor:pointer;transition:border-color var(--tr);}
	.cfg-select:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
	.cfg-select:disabled{background:var(--table-head);color:var(--text-muted);cursor:not-allowed;}

	/* Boolean toggle */
	.tog-wrap{display:flex;flex-direction:column;align-items:center;gap:5px;}
	.tog-lbl-t{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);}
	.big-tog{position:relative;display:inline-block;width:44px;height:24px;}
	.big-tog input{opacity:0;width:0;height:0;position:absolute;}
	.big-tog-s{position:absolute;cursor:pointer;inset:0;border-radius:20px;background:#e2e8f0;transition:background .2s;border:1.5px solid #d1d9e6;}
	.big-tog-s::before{content:'';position:absolute;width:18px;height:18px;left:2px;top:1px;border-radius:50%;background:#fff;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
	.big-tog input:checked + .big-tog-s{background:var(--success);border-color:transparent;}
	.big-tog input:checked + .big-tog-s::before{transform:translateX(20px);}
	.big-tog.locked input{pointer-events:none;}
	.big-tog.locked .big-tog-s{cursor:not-allowed;opacity:.5;}
	.tog-val{font-size:10px;font-weight:800;}

	/* Current value badge */
	.cur-val{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;font-family:'JetBrains Mono',monospace;}
	.cv-int{background:var(--primary-light);color:var(--primary);}
	.cv-text{background:var(--success-light);color:#065f46;}
	.cv-locked{background:var(--mandatory-light);color:#c2410c;}
	.cv-bool{background:var(--info-light);color:#0369a1;}

	/* Changed indicator */
	.changed-dot{width:8px;height:8px;border-radius:50%;background:var(--warning);display:none;flex-shrink:0;}
	.changed .changed-dot{display:inline-block;}

	/* Separator */
	.cfg-sep{width:1px;height:36px;background:var(--card-border);flex-shrink:0;}

	/* ── AUDIT DRAWER ── */
	.audit-drawer{position:fixed;right:-380px;top:var(--header-h);bottom:0;width:380px;background:#fff;border-left:1px solid var(--card-border);box-shadow:var(--sh-lg);z-index:400;transition:right .3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;}
	.audit-drawer.open{right:0;}
	.ad-head{padding:14px 18px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
	.ad-head h5{font-size:14px;font-weight:800;color:var(--text-dark);}
	.ad-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:16px;}
	.ad-body{flex:1;overflow-y:auto;padding:14px 18px;}
	.ae{display:flex;gap:11px;margin-bottom:14px;}
	.ae-line{display:flex;flex-direction:column;align-items:center;}
	.ae-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0;margin-top:3px;}
	.ae-dot.change{background:var(--warning);}
	.ae-dot.save{background:var(--success);}
	.ae-trail{width:1px;flex:1;min-height:12px;background:var(--card-border);margin-top:4px;}
	.ae-msg{font-size:12px;font-weight:600;color:var(--text-dark);line-height:1.4;}
	.ae-meta{font-size:11px;color:var(--text-muted);margin-top:2px;}

	/* ── UNSAVED BANNER ── */
	.unsaved-banner{position:fixed;bottom:0;left:var(--sidebar-w);right:0;background:linear-gradient(90deg,#1a1f36,#2d3d80);padding:12px 24px;display:flex;align-items:center;justify-content:space-between;z-index:200;transform:translateY(100%);transition:transform .3s cubic-bezier(.4,0,.2,1);box-shadow:0 -4px 20px rgba(0,0,0,.2);}
	.unsaved-banner.show{transform:translateY(0);}
	.ub-left{display:flex;align-items:center;gap:10px;color:#fff;}
	.ub-left i{font-size:16px;color:#fbbf24;}
	.ub-left span{font-size:13px;font-weight:600;}
	.ub-count{font-size:12px;font-weight:800;background:var(--warning);color:#fff;padding:1px 8px;border-radius:20px;font-family:'JetBrains Mono',monospace;}
	.ub-right{display:flex;gap:8px;}
	.btn-ub-discard{padding:7px 14px;border-radius:var(--r-sm);font-family:inherit;font-size:12px;font-weight:700;cursor:pointer;background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.2);transition:all var(--tr);}
	.btn-ub-discard:hover{background:rgba(255,255,255,.2);}
	.btn-ub-save{padding:7px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:12px;font-weight:800;cursor:pointer;background:var(--success);color:#fff;border:none;transition:all var(--tr);display:flex;align-items:center;gap:6px;}
	.btn-ub-save:hover{background:#059669;}

	/* ── EMPTY ── */
	.empty-state{text-align:center;padding:44px 20px;color:var(--text-muted);}
	.empty-state i{font-size:36px;opacity:.2;display:block;margin-bottom:9px;}
	.empty-state p{font-size:13px;}

	/* ── TOAST ── */
	#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
	.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;display:flex;align-items:center;gap:7px;box-shadow:var(--sh-lg);animation:tIn .25s ease;max-width:300px;pointer-events:auto;}
	@keyframes tIn{from{opacity:0;transform:translateX(16px)}to{opacity:1;transform:translateX(0)}}
	.t-s{background:var(--success);color:#fff;}.t-w{background:var(--warning);color:#fff;}.t-e{background:var(--danger);color:#fff;}.t-i{background:var(--primary);color:#fff;}
</style>

	<!-- HEADER -->
	<header class="header">
		<div class="hdr-l">
			<div class="bc"><a href="#">System</a><span class="sep">›</span><span class="cur">System Configuration</span></div>
		</div>
		<div class="hdr-r">
			<div class="hbtn"><i class="fa-solid fa-magnifying-glass"></i></div>
			<div class="hbtn"><i class="fa-solid fa-bell"></i><span class="dot"></span></div>
			<div class="hbtn" onclick="toggleAudit()" title="Change History"><i class="fa-solid fa-clock-rotate-left"></i></div>
			<div class="upill"><div class="uav">AD</div><span class="unm">Admin</span></div>
		</div>
	</header>

	<!-- MAIN -->
	<main class="main">

		<div class="pg-hdr">
			<div class="pg-hdr-left">
				<h1><i class="fa-solid fa-sliders" style="font-size:16px;margin-right:8px;color:var(--primary);"></i>System Configuration</h1>
				<p>Manage global system settings. Locked items require a developer to modify.</p>
			</div>
			<div class="pg-actions">
				<button class="btn btn-outline btn-sm" onclick="toggleAudit()"><i class="fa-solid fa-clock-rotate-left"></i>Change History</button>
				<button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="fa-solid fa-floppy-disk"></i>Save Changes</button>
			</div>
		</div>

		<!-- Stats -->
		<div class="stats-bar" id="stats-bar"></div>

		<!-- Layout -->
		<div class="layout">

			<!-- Left filter panel -->
			<div class="filter-panel">
				<div class="fp-head">
					<div class="fp-si"><i class="fa-solid fa-filter"></i></div>
					<h6>Groups</h6>
				</div>
				<div class="fp-search">
					<div class="fp-sw">
						<i class="fa-solid fa-magnifying-glass"></i>
						<input type="text" id="search-inp" placeholder="Search settings…" oninput="render()">
					</div>
				</div>
				<div class="fp-groups" id="fp-groups"></div>
				<div class="fp-legend">
					<div class="fl-title">Legend</div>
					<div class="fl-row"><div class="fl-dot" style="background:var(--mandatory);"></div>Locked — read only</div>
					<div class="fl-row"><div class="fl-dot" style="background:var(--success);"></div>Editable</div>
					<div class="fl-row"><div class="fl-dot" style="background:var(--warning);"></div>Unsaved change</div>
				</div>
			</div>

			<!-- Right content -->
			<div>
				<div class="toolbar">
					<div class="tb-l">
						<span style="font-size:12px;font-weight:600;color:var(--text-muted);">Show:</span>
							<button class="tb-btn active" id="f-all" onclick="setFilter('all',this)">All</button>
							<button class="tb-btn" id="f-editable" onclick="setFilter('editable',this)"><i class="fa-solid fa-pen" style="font-size:11px;"></i>Editable</button>
							<button class="tb-btn" id="f-locked" onclick="setFilter('locked',this)"><i class="fa-solid fa-lock" style="font-size:11px;"></i>Locked</button>
						<div class="tb-div"></div>
							<button class="tb-btn" id="f-changed" onclick="setFilter('changed',this)"><i class="fa-solid fa-circle-dot" style="font-size:11px;color:var(--warning);"></i>Unsaved</button>
					</div>
					<span style="font-size:12px;color:var(--text-muted);font-weight:600;" id="result-count"></span>
				</div>

				<div id="config-list"></div>
			</div>

		</div>
	</main>

	<!-- AUDIT DRAWER -->
	<div class="audit-drawer" id="audit-drawer">
		<div class="ad-head">
			<h5><i class="fa-solid fa-clock-rotate-left" style="margin-right:7px;color:var(--primary);"></i>Change History</h5>
			<button class="ad-close" onclick="toggleAudit()"><i class="fa-solid fa-xmark"></i></button>
		</div>
		<div class="ad-body" id="audit-body">
			<div style="text-align:center;padding:32px 16px;color:var(--text-muted);">
				<i class="fa-solid fa-clock-rotate-left" style="font-size:28px;opacity:.2;display:block;margin-bottom:8px;"></i>
				<p style="font-size:12px;">No changes recorded yet.</p>
			</div>
		</div> 
	</div>
 
	<!-- UNSAVED BANNER -->
	<div class="unsaved-banner" id="unsaved-banner">
		<div class="ub-left">
			<i class="fa-solid fa-circle-exclamation"></i>
			<span>You have unsaved changes</span>
			<span class="ub-count" id="ub-count">0</span>
		</div>
		<div class="ub-right">
			<button class="btn-ub-discard" onclick="discardAll()"><i class="fa-solid fa-rotate-left"></i> Discard</button>
			<button class="btn-ub-save" onclick="saveAll()"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
		</div>
	</div>

	<div id="toast-c"></div>

<script>
	
	var CONFIG = [];

	$.ajax({
		url: '/Settings/get_configs',
		type: 'GET',
		dataType: 'json',
		/*success: function(res){

			CONFIG = res;
			console.log(CONFIG);
			GROUPS = {};
			CONFIG.forEach(function(c){
				GROUPS[c.group] = {
					icon: c.group_icon,
					color: c.group_color
				};
			});

			renderStats();
			renderFilterPanel();
			render();
		}*/
		success: function(res){

			CONFIG = res.map(function(c){
				c.sc_locked = Number(c.sc_locked);
				return c;
			});

			console.log(CONFIG);

			GROUPS = {};
			CONFIG.forEach(function(c){
				GROUPS[c.group] = {
					icon: c.group_icon,
					color: c.group_color
				};
			});

			renderStats();
			renderFilterPanel();
			render();
		}
	});

	/* ── Track changes ── */
	var changes = {};  /* sc_id → {original, current} */
	var activeGroup = 'ALL';
	var activeFilter = 'all';
	var auditLog = [];

	/* ── GROUP META ── */
	var GROUPS = {};
	CONFIG.forEach(function(c){ GROUPS[c.group] = {icon:c.group_icon, color:c.group_color}; });

	/* ─── INIT ─── */
	$(function(){
	  renderStats();
	  renderFilterPanel();
	  render();
	});

	/* ─── STATS ─── */
	function renderStats(){
	  var total    = CONFIG.length;
	  var editable = CONFIG.filter(function(c){return !c.sc_locked;}).length;
	  var locked   = CONFIG.filter(function(c){return c.sc_locked;}).length;
	  var unsaved  = Object.keys(changes).length;
	  $('#stats-bar').html(
		stat('fa-sliders',   'var(--primary-light)', 'var(--primary)', total,    'Total Settings')+
		stat('fa-pen',       'var(--success-light)', 'var(--success)', editable, 'Editable')+
		stat('fa-lock',      'var(--mandatory-light)','#c2410c',       locked,   'Locked')+
		stat('fa-circle-dot','var(--warning-light)', 'var(--warning)', unsaved,  'Unsaved Changes')
	  );
	}
	function stat(ic,bg,color,v,l){
	  return '<div class="stat-card">'
		+'<div class="stat-icon" style="background:'+bg+';color:'+color+';"><i class="fa-solid '+ic+'"></i></div>'
		+'<div class="stat-info"><div class="sv" style="color:'+color+'">'+v+'</div><div class="sl">'+l+'</div></div>'
		+'</div>';
	}

	/* ─── FILTER PANEL ─── */
	function renderFilterPanel(){
	  var html = fgItem('ALL','fa-border-all','var(--primary)','All Settings',CONFIG.length);
	  Object.keys(GROUPS).forEach(function(g){
		var m=GROUPS[g];
		html += fgItem(g,m.icon,m.color,g,CONFIG.filter(function(c){return c.group===g;}).length);
	  });
	  $('#fp-groups').html(html);
	}
	function fgItem(g,icon,color,label,cnt){
	  return '<div class="fg-item '+(activeGroup===g?'active':'')+'" onclick="setGroup(\''+g+'\',this)">'
		+'<div class="fg-name"><i class="fa-solid '+icon+'" style="color:'+color+'"></i>'+label+'</div>'
		+'<span class="fg-cnt">'+cnt+'</span>'
		+'</div>';
	}
	function setGroup(g,el){
	  activeGroup=g;
	  $('.fg-item').removeClass('active');
	  $(el).addClass('active');
	  render();
	}
	function setFilter(f,el){
	  activeFilter=f;
	  $('.tb-btn').removeClass('active');
	  $(el).addClass('active');
	  render();
	}

	/* ─── MAIN RENDER ─── */
	function render(){
	  var q   = ($('#search-inp').val()||'').toLowerCase();
	  var groups = activeGroup==='ALL' ? Object.keys(GROUPS) : [activeGroup];
	  var html = '';
	  var totalShown = 0;

	  groups.forEach(function(g){
		var meta = GROUPS[g];
		var rows = CONFIG.filter(function(c){
		  if (c.group !== g)                                                                                 return false;
		  if (activeFilter==='editable' && c.sc_locked)                                                     return false;
		  if (activeFilter==='locked'   && !c.sc_locked)                                                    return false;
		  if (activeFilter==='changed'  && !changes[c.sc_id])                                               return false;
		  if (q && !c.sc_label.toLowerCase().includes(q) && !c.sc_name.toLowerCase().includes(q)
				&& !(c.sc_desc||'').toLowerCase().includes(q))                                              return false;
		  return true;
		});
		if (!rows.length) return;
		totalShown += rows.length;
		var editCnt = rows.filter(function(c){return !c.sc_locked;}).length;
		var lockCnt = rows.filter(function(c){return c.sc_locked;}).length;

		html += '<div class="group-section">'
		  +'<div class="group-header" onclick="toggleGroup(\''+g+'\')">'
			+'<div class="gh-l">'
			  +'<div class="gh-icon" style="background:'+meta.color+'18;color:'+meta.color+';"><i class="fa-solid '+meta.icon+'"></i></div>'
			  +'<div><div class="gh-title">'+g+'</div><div class="gh-sub">'+rows.length+' setting'+(rows.length!==1?'s':'')+'</div></div>'
			+'</div>'
			+'<div class="gh-r">'
			  +'<div class="gh-pills">'
				+(editCnt?'<span class="gh-pill gp-edit"><i class="fa-solid fa-pen" style="font-size:9px;"></i>'+editCnt+' editable</span>':'')
				+(lockCnt?'<span class="gh-pill gp-lock"><i class="fa-solid fa-lock" style="font-size:9px;"></i>'+lockCnt+' locked</span>':'')
			  +'</div>'
			  +'<i class="fa-solid fa-chevron-right gh-chev open" id="chev-'+g.replace(/\s/g,'_')+'"></i>'
			+'</div>'
		  +'</div>'
		  +'<div class="configs-wrap" id="cwrap-'+g.replace(/\s/g,'_')+'">'
			+rows.map(cfgRow).join('')
		  +'</div>'
		+'</div>';
	  });

	  if (!totalShown){
		html='<div class="empty-state"><i class="fa-solid fa-sliders"></i><p>No settings match your filters.</p></div>';
	  }
	  $('#config-list').html(html);
	  $('#result-count').text(totalShown+' setting'+(totalShown!==1?'s':''));
	}

	/* ─── RENDER A SINGLE ROW ─── */
	function cfgRow(c){
	  var locked   = !!c.sc_locked;
	  var isChanged= !!changes[c.sc_id];
	  var val      = changes[c.sc_id] ? changes[c.sc_id].current : c.sc_value;
	  var dtype    = c.sc_datatype;
	  var control  = buildControl(c, val, locked);
	  var typePill = '<span class="b-type">'+dtype+'</span>';

	  return '<div class="cfg-row '+(locked?'locked-row':'')+' '+(isChanged?'changed':'')+'" id="cfgr-'+c.sc_id+'">'
		+(locked?'<div class="lock-bar"></div>':'')
		+'<div class="cfg-inner">'
		  +'<div class="cfg-info">'
			+'<div class="cfg-top">'
			  +'<span class="cfg-label">'+c.sc_label+'</span>'
			  +'<span class="cfg-name">'+c.sc_name+'</span>'
			  +typePill
			  +(locked?'<span class="b-locked"><i class="fa-solid fa-lock" style="font-size:9px;"></i>Locked</span>':'')
			  +'<div class="changed-dot" title="Unsaved change"></div>'
			+'</div>'
			+'<div class="cfg-desc">'+c.sc_desc+'</div>'
		  +'</div>'
		  +'<div class="cfg-control">'
			+control
		  +'</div>'
		+'</div>'
	  +'</div>';
	}

	/* ─── BUILD CONTROL BY DATATYPE ─── */
	function buildControl(c, val, locked){
	  var id     = c.sc_id;
	  var dtype  = c.sc_datatype;
	  var disAttr= locked ? 'disabled' : '';
	  var onchg  = locked ? '' : 'onchange="onValChange('+id+',this)"';
	  var oninput= locked ? '' : 'oninput="onValChange('+id+',this)"';

	  
	  /*if (dtype === 'boolean'){
		var isToggle = (c.sc_options === null && (val==='0'||val==='1'));
		if (isToggle){
		  var checked = val==='1' ? 'checked' : '';
		  var col     = val==='1' ? 'var(--success)' : 'var(--text-muted)';
		  var lbl     = val==='1' ? 'ON' : 'OFF';
		  return '<div class="tog-wrap">'
			+'<span class="tog-lbl-t">Value</span>'
			+'<label class="big-tog '+(locked?'locked':'')+'">'
			  +'<input type="checkbox" id="ctrl-'+id+'" '+checked+' '+(locked?'':'onchange="onToggleChange('+id+',this)"')+'>'
			  +'<span class="big-tog-s"></span>'
			+'</label>'
			+'<span class="tog-val" id="tlbl-'+id+'" style="color:'+col+'">'+lbl+'</span>'
		  +'</div>';
		} else {
		  
		  return '<div class="int-input-wrap">'
			+'<button class="int-btn" '+(locked?'disabled':'')+' onclick="stepInt('+id+',-1)" type="button"><i class="fa-solid fa-minus" style="font-size:10px;"></i></button>'
			+'<input type="number" class="cfg-int" id="ctrl-'+id+'" value="'+val+'" '+disAttr+' '+onchg+'>'
			+'<button class="int-btn" '+(locked?'disabled':'')+' onclick="stepInt('+id+',1)" type="button"><i class="fa-solid fa-plus" style="font-size:10px;"></i></button>'
		  +'</div>';
		}
	  }*/
	  /* BOOLEAN -> Toggle Only */
	if (dtype === 'boolean') {

		var checked = val === '1' ? 'checked' : '';
		var col     = val === '1' ? 'var(--success)' : 'var(--text-muted)';
		var lbl     = val === '1' ? 'ON' : 'OFF';

		return '<div class="tog-wrap">'
			+'<span class="tog-lbl-t">Value</span>'
			+'<label class="big-tog '+(locked ? 'locked' : '')+'">'
				+'<input type="checkbox" id="ctrl-'+id+'" '+checked+' '+(locked ? '' : 'onchange="onToggleChange('+id+',this)"')+'>'
				+'<span class="big-tog-s"></span>'
			+'</label>'
			+'<span class="tog-val" id="tlbl-'+id+'" style="color:'+col+'">'+lbl+'</span>'
		+'</div>';
	}

	/* INTEGER -> Number Stepper */
	if (dtype === 'int') {

		return '<div class="int-input-wrap">'
			+'<button class="int-btn" '+(locked ? 'disabled' : '')+' onclick="stepInt('+id+',-1)" type="button">'
				+'<i class="fa-solid fa-minus" style="font-size:10px;"></i>'
			+'</button>'
			+'<input type="number" class="cfg-int" id="ctrl-'+id+'" value="'+val+'" '+disAttr+' '+onchg+'>'
			+'<button class="int-btn" '+(locked ? 'disabled' : '')+' onclick="stepInt('+id+',1)" type="button">'
				+'<i class="fa-solid fa-plus" style="font-size:10px;"></i>'
			+'</button>'
		+'</div>';
	}

	  /* STRING with options → dropdown */
	  if ((dtype==='string') && c.sc_options){
		var opts = c.sc_options.split(',').map(function(o){
		  return '<option value="'+o.trim()+'"'+(o.trim()===val?' selected':'')+'>'+o.trim()+'</option>';
		}).join('');
		return '<select class="cfg-select" id="ctrl-'+id+'" '+disAttr+' '+onchg+'>'+opts+'</select>';
	  }

	  /* PASSWORD / API KEY */
	  if (dtype==='password'){
		return '<div class="cfg-pass-wrap">'
		  +'<input type="password" class="cfg-pass" id="ctrl-'+id+'" value="'+val+'" '+disAttr+' '+oninput+' placeholder="'+(locked?'●●●●●●●●':'Enter key…')+'">'
		  +(locked?'':'<button class="pass-eye" type="button" onclick="togglePass('+id+')" tabindex="-1"><i class="fa-solid fa-eye" id="eye-'+id+'"></i></button>')
		+'</div>';
	  }

	  /* PLAIN TEXT / STRING without options */
	  return '<input type="text" class="cfg-text" id="ctrl-'+id+'" value="'+val+'" '+disAttr+' '+oninput+'>';
	}

	/* ─── CHANGE HANDLERS ─── */
	/*function onValChange(id, el){
	  //var cfg = CONFIG.find(function(c){return c.sc_id===id;});
	  var cfg = CONFIG.find(function(c){return String(c.sc_id) === String(id);});
	  if (!cfg || cfg.sc_locked) return;
	  var newVal = el.type==='number' ? String(el.value) : el.value;
	  var orig   = cfg.sc_value;
	  if (newVal === orig){
		delete changes[id];
	  } else {
		changes[id] = {original:orig, current:newVal, label:cfg.sc_label};
	  }
	  updateRowState(id);
	  updateBanner();
	  renderStats();
	}*/
	function onValChange(id, el){

		console.log('ID:', id);

		var cfg = CONFIG.find(function(c){
			return String(c.sc_id) === String(id);
		});

		console.log('CFG:', cfg);

		if (!cfg || cfg.sc_locked) return;

		var newVal = String(el.value);
		var orig   = String(cfg.sc_value);

		console.log('NEW:', newVal);
		console.log('OLD:', orig);

		if (newVal === orig){
			delete changes[id];
		} else {
			changes[id] = {
				original: orig,
				current: newVal,
				label: cfg.sc_label
			};
		}

		console.log('CHANGES:', changes);

		updateRowState(id);
		updateBanner();
		renderStats();
	}

	function onToggleChange(id, el){
	 // var cfg = CONFIG.find(function(c){return c.sc_id===id;});
	  var cfg = CONFIG.find(function(c){return String(c.sc_id) === String(id);});
	  if (!cfg || cfg.sc_locked) return;
	  var newVal = el.checked ? '1' : '0';
	  var orig   = cfg.sc_value;
	  var col    = el.checked?'var(--success)':'var(--text-muted)';
	  var lbl    = el.checked?'ON':'OFF';
	  $('#tlbl-'+id).text(lbl).css('color',col);
	  if (newVal===orig){ delete changes[id]; }
	  else { changes[id]={original:orig,current:newVal,label:cfg.sc_label}; }
	  updateRowState(id); updateBanner(); renderStats();
	}

	function stepInt(id, delta){
	  //var cfg = CONFIG.find(function(c){return c.sc_id===id;});
	  var cfg = CONFIG.find(function(c){return String(c.sc_id) === String(id);});
	  if (!cfg || cfg.sc_locked) return;
	  var input=$('#ctrl-'+id);
	  var cur=parseInt(input.val())||0;
	  var newVal=Math.max(0,cur+delta);
	  input.val(newVal);
	  onValChange(id,input[0]);
	}

	function togglePass(id){
	  var inp=$('#ctrl-'+id);
	  var eye=$('#eye-'+id);
	  if (inp.attr('type')==='password'){
		inp.attr('type','text');
		eye.attr('class','fa-solid fa-eye-slash');
	  } else {
		inp.attr('type','password');
		eye.attr('class','fa-solid fa-eye');
	  }
	}

	function updateRowState(id){
	  var row=$('#cfgr-'+id);
	  if (changes[id]){
		row.addClass('changed');
		row.find('.changed-dot').show();
	  } else {
		row.removeClass('changed');
		row.find('.changed-dot').hide();
	  }
	}

	/* ─── BANNER ─── */
	function updateBanner(){
	  var cnt=Object.keys(changes).length;
	  if (cnt>0){
		$('#ub-count').text(cnt);
		$('#unsaved-banner').addClass('show');
	  } else {
		$('#unsaved-banner').removeClass('show');
	  }
	}

	/* ─── SAVE / DISCARD ─── */
	/*function saveAll(){
	  if (!Object.keys(changes).length){ toast('No changes to save','i'); return; }
	  //AJAX: $.post('/api/sys-config/save', {changes: changes}, function(res){...});
	  Object.keys(changes).forEach(function(id){
		var ch=changes[id];
		addAudit(ch.label+' changed from <strong>'+ch.original+'</strong> → <strong>'+ch.current+'</strong>');
		var cfg=CONFIG.find(function(c){return c.sc_id==id;});
		if (cfg) cfg.sc_value=ch.current;
	  });
	  changes={};
	  renderStats();
	  updateBanner();
	  render();
	  toast('All changes saved successfully','s');
	}*/
	
	function saveAll()
		{
			if (!Object.keys(changes).length) {
				toast('No changes to save','i');
				return;
			}

			$.ajax({
				url: '/Settings/save_configs',
				type: 'POST',
				dataType: 'json',
				data: {
					changes: JSON.stringify(changes)
				},
				success: function(res)
				{
					if(res.status === 'success')
					{
						Object.keys(changes).forEach(function(id){

							var cfg = CONFIG.find(function(c){
								return c.sc_id == id;
							});

							if(cfg){
								cfg.sc_value = changes[id].current;
							}
						});

						changes = {};

						renderStats();
						updateBanner();
						render();

						toast('Settings saved successfully','s');
					}
					else
					{
						toast(res.message || 'Failed to save settings','e');
					}
				},
				error: function()
				{
					toast('Server error occurred','e');
				}
			});
		}

	function discardAll(){
	  if (!Object.keys(changes).length) return;
	  if (!confirm('Discard all unsaved changes?')) return;
	  changes={};
	  renderStats();
	  updateBanner();
	  render();
	  toast('Changes discarded','w');
	}

	/* ─── GROUP COLLAPSE ─── */
	function toggleGroup(g){
	  var key=g.replace(/\s/g,'_');
	  $('#cwrap-'+key).slideToggle(180);
	  $('#chev-'+key).toggleClass('open');
	}

	/* ─── AUDIT ─── */
	function addAudit(msg){
	  auditLog.unshift({msg:msg,time:nowStr()});
	  renderAudit();
	}
	function renderAudit(){
	  if (!auditLog.length){
		$('#audit-body').html('<div style="text-align:center;padding:32px 16px;color:var(--text-muted);"><i class="fa-solid fa-clock-rotate-left" style="font-size:28px;opacity:.2;display:block;margin-bottom:8px;"></i><p style="font-size:12px;">No changes yet.</p></div>');
		return;
	  }
	  var html=auditLog.map(function(a,i){
		return '<div class="ae">'
		  +'<div class="ae-line"><div class="ae-dot change"></div>'+(i<auditLog.length-1?'<div class="ae-trail"></div>':'')+'</div>'
		  +'<div><div class="ae-msg">'+a.msg+'</div><div class="ae-meta">Admin · '+a.time+'</div></div>'
		+'</div>';
	  }).join('');
	  $('#audit-body').html(html);
	}
	function toggleAudit(){ $('#audit-drawer').toggleClass('open'); }

	/* ─── HELPERS ─── */
	function nowStr(){var d=new Date();return d.toISOString().slice(0,16).replace('T',' ');}
	function toast(msg,type){
	  var map={s:['t-s','fa-check-circle'],w:['t-w','fa-triangle-exclamation'],e:['t-e','fa-circle-xmark'],i:['t-i','fa-circle-info']};
	  var p=map[type]||map.i;
	  var $t=$('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i>'+msg+'</div>');
	  $('#toast-c').append($t);
	  setTimeout(function(){$t.css({opacity:0,transform:'translateX(16px)',transition:'all .3s'});setTimeout(function(){$t.remove();},300);},2800);
	}
</script>