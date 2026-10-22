<style>
	:root {
	  --primary:#3d52a0;--primary-d:#2d3d80;--primary-light:#eef1fb;--primary-mid:#c5cff7;
	  --sms:#0ea5e9;--sms-light:#e0f2fe;--sms-dark:#0369a1;
	  --email:#8b5cf6;--email-light:#ede9fe;--email-dark:#6d28d9;
	  --success:#10b981;--success-light:#d1fae5;
	  --danger:#ef4444;--danger-light:#fee2e2;
	  --warning:#f59e0b;--warning-light:#fef3c7;
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
	::-webkit-scrollbar{width:5px;height:5px;}
	::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

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

	.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:20px 22px;min-height:calc(100vh - var(--header-h));}

	.pg-hdr{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:14px;flex-wrap:wrap;}
	.pg-hdr-left h1{font-size:19px;font-weight:800;letter-spacing:-.3px;}
	.pg-hdr-left p{font-size:13px;color:var(--text-muted);margin-top:3px;}
	.pg-actions{display:flex;gap:8px;align-items:center;}
	.btn{padding:9px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;gap:6px;}
	.btn-primary{background:var(--primary);color:#fff;box-shadow:0 2px 8px rgba(61,82,160,.25);}
	.btn-primary:hover{background:var(--primary-d);transform:translateY(-1px);}
	.btn-outline{background:#fff;color:var(--text-mid);border:1.5px solid var(--card-border);}
	.btn-outline:hover{border-color:var(--primary);color:var(--primary);}
	.btn-sm{padding:7px 12px;font-size:12px;}
	.btn-danger-o{background:#fff;color:var(--danger);border:1.5px solid var(--danger-light);}
	.btn-danger-o:hover{background:var(--danger);color:#fff;}

	.stats-bar{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;}
	.stat-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:16px 18px;display:flex;align-items:center;gap:14px;box-shadow:var(--sh-sm);transition:all var(--tr);}
	.stat-card:hover{transform:translateY(-1px);box-shadow:var(--sh-md);}
	.stat-icon{width:44px;height:44px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:19px;flex-shrink:0;}
	.si-total{background:var(--primary-light);color:var(--primary);}
	.si-sms{background:var(--sms-light);color:var(--sms);}
	.si-email{background:var(--email-light);color:var(--email);}
	.stat-info .sv{font-size:24px;font-weight:800;color:var(--text-dark);font-family:'JetBrains Mono',monospace;line-height:1;}
	.stat-info .sl{font-size:11px;color:var(--text-muted);font-weight:600;margin-top:3px;}
	.stat-info .sd{font-size:11px;font-weight:600;margin-top:1px;}

	.layout{display:grid;grid-template-columns:210px 1fr;gap:16px;align-items:start;}

	.filter-panel{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);position:sticky;top:78px;overflow:hidden;}
	.fp-head{padding:13px 16px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:8px;}
	.fp-head h6{font-size:13px;font-weight:700;color:var(--text-dark);margin:0;}
	.fp-si{width:26px;height:26px;border-radius:6px;background:var(--primary-light);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:12px;flex-shrink:0;}
	.fp-search{padding:10px 12px;border-bottom:1px solid var(--card-border);}
	.fp-sw{position:relative;}
	.fp-sw i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;pointer-events:none;}
	.fp-sw input{width:100%;padding:7px 10px 7px 30px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;color:var(--text-dark);outline:none;transition:border-color var(--tr);background:var(--page-bg);}
	.fp-sw input:focus{border-color:var(--primary);}
	.fp-groups{padding:6px 0;}
	.fg-item{display:flex;align-items:center;justify-content:space-between;padding:9px 16px;cursor:pointer;transition:all var(--tr);font-size:13px;font-weight:500;color:var(--text-mid);border-left:3px solid transparent;}
	.fg-item:hover{background:var(--primary-light);color:var(--primary);}
	.fg-item.active{background:var(--primary-light);color:var(--primary);border-left-color:var(--primary);font-weight:700;}
	.fg-name{display:flex;align-items:center;gap:8px;}
	.fg-name i{font-size:13px;width:15px;text-align:center;}
	.fg-cnt{font-size:10px;font-weight:800;background:var(--primary-mid);color:var(--primary);padding:1px 7px;border-radius:20px;}
	.fg-item.active .fg-cnt{background:var(--primary);color:#fff;}
	.cl-box{padding:12px 14px;border-top:1px solid var(--card-border);}
	.cl-title{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:7px;}
	.cl-row{display:flex;align-items:center;gap:7px;font-size:11px;font-weight:600;color:var(--text-muted);margin-bottom:5px;}
	.cl-row:last-child{margin-bottom:0;}
	.cl-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}

	.toolbar{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:11px 16px;display:flex;align-items:center;gap:10px;margin-bottom:12px;flex-wrap:wrap;box-shadow:var(--sh-sm);}
	.tb-l{display:flex;align-items:center;gap:8px;flex:1;flex-wrap:wrap;}
	.tb-r{display:flex;align-items:center;gap:7px;flex-shrink:0;}
	.tb-btn{padding:6px 12px;border-radius:var(--r-sm);border:1.5px solid var(--card-border);background:#fff;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--text-mid);transition:all var(--tr);display:flex;align-items:center;gap:5px;}
	.tb-btn:hover,.tb-btn.active{border-color:var(--primary);color:var(--primary);background:var(--primary-light);}
	.tb-btn.sms-f.active{border-color:var(--sms);color:var(--sms-dark);background:var(--sms-light);}
	.tb-btn.email-f.active{border-color:var(--email);color:var(--email-dark);background:var(--email-light);}
	.tb-div{width:1px;height:20px;background:var(--card-border);flex-shrink:0;}
	.bulk-lbl{font-size:12px;color:var(--text-muted);font-weight:600;white-space:nowrap;}

	.group-section{margin-bottom:14px;}
	.group-header{display:flex;align-items:center;justify-content:space-between;padding:11px 16px;background:linear-gradient(90deg,var(--primary-light),#f8faff);border:1px solid var(--primary-mid);border-radius:var(--r-md);cursor:pointer;transition:all var(--tr);user-select:none;}
	.group-header:hover{filter:brightness(.97);}
	.gh-l{display:flex;align-items:center;gap:10px;}
	.gh-icon{width:32px;height:32px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
	.gh-title{font-size:13px;font-weight:800;color:var(--primary);}
	.gh-sub{font-size:11px;color:var(--text-muted);margin-top:1px;}
	.gh-r{display:flex;align-items:center;gap:10px;}
	.gh-pills{display:flex;gap:6px;}
	.gh-pill{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;}
	.gp-sms{background:var(--sms-light);color:var(--sms-dark);}
	.gp-email{background:var(--email-light);color:var(--email-dark);}
	.gh-chev{color:var(--text-muted);font-size:13px;transition:transform var(--tr);}
	.gh-chev.open{transform:rotate(90deg);}

	.events-wrap{border:1px solid var(--card-border);border-top:none;border-radius:0 0 var(--r-md) var(--r-md);overflow:hidden;background:#fff;}
	.ev-row{border-bottom:1px solid var(--card-border);transition:background var(--tr);position:relative;}
	.ev-row:last-child{border-bottom:none;}
	.ev-row:hover{background:#fafbff;}
	.ev-row.inactive{background:repeating-linear-gradient(135deg,#fafbff 0,#fafbff 6px,#f5f6fa 6px,#f5f6fa 12px);}
	.ev-row.inactive .ev-label,.ev-row.inactive .ev-desc{opacity:.5;}
	.mand-bar{position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--mandatory);}

	.ev-inner{display:grid;grid-template-columns:1fr auto;gap:20px;padding:14px 20px;align-items:center;}
	.ev-top{display:flex;align-items:center;gap:7px;margin-bottom:5px;flex-wrap:wrap;}
	.ev-label{font-size:13px;font-weight:700;color:var(--text-dark);}
	.ev-key{font-size:10px;font-family:'JetBrains Mono',monospace;background:var(--table-head);border:1px solid var(--card-border);color:var(--text-muted);padding:2px 6px;border-radius:4px;font-weight:600;}
	.b-mand{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;background:var(--mandatory-light);color:#c2410c;}
	.b-ucfg{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;background:var(--sms-light);color:var(--sms-dark);}
	.ev-desc{font-size:12px;color:var(--text-muted);font-weight:500;line-height:1.5;margin-bottom:3px;}
	.ev-note{font-size:11px;color:var(--text-muted);font-style:italic;display:flex;align-items:flex-start;gap:4px;margin-top:2px;}
	.ev-note i{margin-top:1px;flex-shrink:0;color:var(--primary);font-size:11px;}

	.ev-controls{display:flex;align-items:center;gap:14px;flex-shrink:0;}
	.ch-toggles{display:flex;align-items:center;gap:12px;}
	.ch-col{display:flex;flex-direction:column;align-items:center;gap:5px;}
	.ch-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;}
	.ch-lbl.sms{color:var(--sms-dark);}
	.ch-lbl.email{color:var(--email-dark);}

	.tog{position:relative;display:inline-block;width:38px;height:20px;}
	.tog input{opacity:0;width:0;height:0;position:absolute;}
	.tog-s{position:absolute;cursor:pointer;inset:0;border-radius:20px;background:#e2e8f0;transition:background .2s;border:1.5px solid #d1d9e6;}
	.tog-s::before{content:'';position:absolute;width:14px;height:14px;left:2px;top:1px;border-radius:50%;background:#fff;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
	.tog input:checked + .tog-s{border-color:transparent;}
	.tog.sms-t input:checked + .tog-s{background:var(--sms);}
	.tog.email-t input:checked + .tog-s{background:var(--email);}
	.tog input:checked + .tog-s::before{transform:translateX(18px);}
	.tog.locked .tog-s{cursor:not-allowed;opacity:.5;}

	.ev-act-col{display:flex;flex-direction:column;align-items:center;gap:5px;padding-left:14px;border-left:1px solid var(--card-border);}
	.ev-act-lbl{font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.4px;}
	.big-tog{position:relative;display:inline-block;width:44px;height:24px;}
	.big-tog input{opacity:0;width:0;height:0;position:absolute;}
	.big-tog-s{position:absolute;cursor:pointer;inset:0;border-radius:20px;background:#e2e8f0;transition:background .2s;border:1.5px solid #d1d9e6;}
	.big-tog-s::before{content:'';position:absolute;width:18px;height:18px;left:2px;top:1px;border-radius:50%;background:#fff;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
	.big-tog input:checked + .big-tog-s{background:var(--success);border-color:transparent;}
	.big-tog input:checked + .big-tog-s::before{transform:translateX(20px);}
	.big-tog.locked input{pointer-events:none;}
	.big-tog.locked .big-tog-s{cursor:not-allowed;}
	.ev-slbl{font-size:10px;font-weight:800;}

	.empty-state{text-align:center;padding:48px 24px;color:var(--text-muted);}
	.empty-state i{font-size:38px;opacity:.22;display:block;margin-bottom:10px;}
	.empty-state p{font-size:13px;}

	.audit-drawer{position:fixed;right:-400px;top:var(--header-h);bottom:0;width:400px;background:#fff;border-left:1px solid var(--card-border);box-shadow:var(--sh-lg);z-index:400;transition:right .3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;}
	.audit-drawer.open{right:0;}
	.ad-head{padding:15px 18px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
	.ad-head h5{font-size:14px;font-weight:800;color:var(--text-dark);}
	.ad-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:16px;}
	.ad-body{flex:1;overflow-y:auto;padding:16px 18px;}
	.ae{display:flex;gap:11px;margin-bottom:14px;}
	.ae-line{display:flex;flex-direction:column;align-items:center;}
	.ae-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;margin-top:3px;}
	.ae-dot.enable{background:var(--success);}
	.ae-dot.disable{background:var(--danger);}
	.ae-dot.bulk{background:var(--warning);}
	.ae-trail{width:1px;flex:1;min-height:14px;background:var(--card-border);margin-top:4px;}
	.ae-msg{font-size:12px;font-weight:600;color:var(--text-dark);line-height:1.4;}
	.ae-meta{font-size:11px;color:var(--text-muted);margin-top:3px;}
	.ad-empty{text-align:center;padding:36px 16px;color:var(--text-muted);}
	.ad-empty i{font-size:30px;opacity:.2;display:block;margin-bottom:8px;}
	.ad-empty p{font-size:12px;}

	#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
	.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;pointer-events:auto;display:flex;align-items:center;gap:7px;box-shadow:var(--sh-lg);animation:tIn .25s ease;max-width:300px;}
	@keyframes tIn{from{opacity:0;transform:translateX(16px)}to{opacity:1;transform:translateX(0)}}
	.t-s{background:var(--success);color:#fff;}
	.t-w{background:var(--warning);color:#fff;}
	.t-e{background:var(--danger);color:#fff;}
	.t-i{background:var(--primary);color:#fff;}
		
</style>


    	
		<header class="header">
		  <div class="hdr-l">
			<div class="bc"><a href="#">System</a><span class="sep">›</span><span class="cur">Notification Configuration</span></div>
		  </div>
		  <div class="hdr-r">
			<div class="hbtn"><i class="fa-solid fa-magnifying-glass"></i></div>
			<div class="hbtn"><i class="fa-solid fa-bell"></i><span class="dot"></span></div>
			<div class="hbtn" onclick="toggleAudit()" title="Change History"><i class="fa-solid fa-clock-rotate-left"></i></div>
			<div class="upill"><div class="uav">AD</div><span class="unm">Admin</span></div>
		  </div>
		</header>

		<main class="main">

		  <div class="pg-hdr">
			<div class="pg-hdr-left">
			  <h1><i class="fa-solid fa-bell" style="font-size:16px;margin-right:8px;color:var(--primary);"></i>Notification Configuration</h1>
			  <p>Enable or disable SMS and Email notifications per system event. Changes take effect immediately.</p>
			</div>
			<div class="pg-actions">
			  <button class="btn btn-outline btn-sm" onclick="toggleAudit()"><i class="fa-solid fa-clock-rotate-left"></i>Change History</button>
			  <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="fa-solid fa-floppy-disk"></i>Save Changes</button>
			</div>
		  </div>

		  <div class="stats-bar" id="stats-bar"></div>

		  <div class="layout">

			<div class="filter-panel">
			  <div class="fp-head">
				<div class="fp-si"><i class="fa-solid fa-filter"></i></div>
				<h6>Groups</h6>
			  </div>
			  <div class="fp-search">
				<div class="fp-sw">
				  <i class="fa-solid fa-magnifying-glass"></i>
				  <input type="text" id="search-inp" placeholder="Search events…" oninput="renderAll()">
				</div>
			  </div>
			  <div class="fp-groups" id="fp-groups"></div>
			  <div class="cl-box">
				<div class="cl-title">Channels</div>
				<div class="cl-row"><div class="cl-dot" style="background:var(--sms)"></div>SMS</div>
				<div class="cl-row"><div class="cl-dot" style="background:var(--email)"></div>Email</div>
			  </div>
			</div>

			<div>
			  <div class="toolbar">
				<div class="tb-l">
				  <span style="font-size:12px;font-weight:600;color:var(--text-muted);">Show:</span>
				  <button class="tb-btn active" onclick="setChanFilter('all',this)">All</button>
				  <button class="tb-btn sms-f" onclick="setChanFilter('sms',this)"><i class="fa-solid fa-message" style="color:var(--sms)"></i>SMS</button>
				  <button class="tb-btn email-f" onclick="setChanFilter('email',this)"><i class="fa-solid fa-envelope" style="color:var(--email)"></i>Email</button>
				  <div class="tb-div"></div>
				  <!--<button class="tb-btn" id="inact-btn" onclick="toggleInactive(this)"><i class="fa-solid fa-eye-slash"></i>Show Inactive</button>-->
				</div>
				<div class="tb-r">
				  <!--<span class="bulk-lbl">Bulk:</span>
				  <button class="btn btn-outline btn-sm" onclick="bulkChannel('sms',1)" style="color:var(--sms-dark);border-color:var(--sms-light);"><i class="fa-solid fa-message"></i>All SMS On</button>
				  <button class="btn btn-outline btn-sm" onclick="bulkChannel('email',1)" style="color:var(--email-dark);border-color:var(--email-light);"><i class="fa-solid fa-envelope"></i>All Email On</button>
				  <button class="btn btn-danger-o btn-sm" onclick="bulkDisable()"><i class="fa-solid fa-ban"></i>Disable All</button>-->
				</div>
			  </div>
			  <div id="events-list"></div>
			</div>

		  </div>
		</main>

		<div class="audit-drawer" id="audit-drawer">
		  <div class="ad-head">
			<h5><i class="fa-solid fa-clock-rotate-left" style="margin-right:7px;color:var(--primary);"></i>Change History</h5>
			<button class="ad-close" onclick="toggleAudit()"><i class="fa-solid fa-xmark"></i></button>
		  </div>
		  <div class="ad-body" id="audit-body">
			<div class="ad-empty"><i class="fa-solid fa-clock-rotate-left"></i><p>No changes yet.</p></div>
		  </div>
		</div>

		<div id="toast-c"></div>
	

	

<script>

	var DATA   = <?= json_encode($notifications, JSON_UNESCAPED_UNICODE); ?>;
	var GROUPS = <?= json_encode($groups, JSON_UNESCAPED_UNICODE); ?>;

	console.log(DATA);

	/* ✅ NORMALIZE DATA */
	DATA = DATA.map(function(d){
		d.id = Number(d.id);
		d.sms = Number(d.sms);
		d.email = Number(d.email);
		d.is_active = Number(d.is_active);
		d.is_mandatory = Number(d.is_mandatory);
		d.user_configurable = Number(d.user_configurable);
		d.priority = Number(d.priority);
		return d;
	});

	function toast(msg, type){
	  var map = {
		s: ['t-s','fa-check-circle'],        // success
		w: ['t-w','fa-triangle-exclamation'],// warning
		e: ['t-e','fa-circle-xmark'],        // error
		i: ['t-i','fa-circle-info']          // info
	  };

	  var p = map[type] || map.i;

	  var $t = $('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i>'+msg+'</div>');

	  $('#toast-c').append($t);

	  setTimeout(function(){
		$t.css({
		  opacity: 0,
		  transform: 'translateX(16px)',
		  transition: 'all .3s'
		});

		setTimeout(function(){
		  $t.remove();
		},300);

	  }, 2800);
	}

	var activeGroup  = 'ALL';
	var chanFilter   = 'all';
	var showInactive = false;
	var auditLog     = [];

	$(function(){ renderStats(); renderGroups(); renderAll(); });

	/* ================= STATS ================= */
	function renderStats(){
		var total   = DATA.length;
		var active  = DATA.filter(d => d.is_active === 1).length;
		var smsOn   = DATA.filter(d => d.sms === 1 && d.is_active === 1).length;
		var emailOn = DATA.filter(d => d.email === 1 && d.is_active === 1).length;

		$('#stats-bar').html(
			sc('si-total','fa-bell',total,'Total Events',active+' active','#10b981')+
			sc('si-sms','fa-message',smsOn,'SMS Enabled',(total-smsOn)+' disabled','var(--sms)')+
			sc('si-email','fa-envelope',emailOn,'Email Enabled',(total-emailOn)+' disabled','var(--email)')
		);
	}

	function sc(cls,icon,num,lbl,sub,subClr){
		return '<div class="stat-card"><div class="stat-icon '+cls+'"><i class="fa-solid '+icon+'"></i></div><div class="stat-info"><div class="sv">'+num+'</div><div class="sl">'+lbl+'</div><div class="sd" style="color:'+subClr+'">'+sub+'</div></div></div>';
	}

	/* ================= GROUPS ================= */
	function renderGroups(){
		var html = fg('ALL','fa-border-all','var(--primary)','All Events',DATA.length);

		Object.keys(GROUPS).forEach(function(g){
			var m=GROUPS[g];
			html += fg(g,m.icon,m.color,m.label,DATA.filter(d => d.group_key===g).length);
		});

		$('#fp-groups').html(html);
	}

	function fg(g,icon,color,label,cnt){
		return '<div class="fg-item '+(activeGroup===g?'active':'')+'" onclick="setGroup(\''+g+'\',this)"><div class="fg-name"><i class="fa-solid '+icon+'" style="color:'+color+'"></i>'+label+'</div><span class="fg-cnt">'+cnt+'</span></div>';
	}

	function setGroup(g,el){
		activeGroup=g;
		$('.fg-item').removeClass('active');
		$(el).addClass('active');
		renderAll();
	}

	/* ================= MAIN ================= */
	function renderAll(){
		var q      = ($('#search-inp').val()||'').toLowerCase();
		var groups = activeGroup==='ALL' ? Object.keys(GROUPS) : [activeGroup];
		var html   = '';
		var shown  = 0;

		groups.forEach(function(g){
			var meta = GROUPS[g];

			var rows = DATA.filter(function(d){
				if (d.group_key!==g) return false;
				if (!showInactive && d.is_active === 0) return false;
				if (chanFilter==='sms' && d.sms !== 1) return false;
				if (chanFilter==='email' && d.email !== 1) return false;

				if (q && !d.label.toLowerCase().includes(q)
					&& !d.event_name.toLowerCase().includes(q)
					&& !d.description.toLowerCase().includes(q)) return false;

				return true;
			});

			if (!rows.length) return;

			shown += rows.length;
			rows.sort((a,b)=>a.priority-b.priority);

			var sOn = rows.filter(d=>d.sms===1).length;
			var eOn = rows.filter(d=>d.email===1).length;

			html += '<div class="group-section">'
			+'<div class="group-header" onclick="toggleGroup(\''+g+'\')">'
			+'<div class="gh-title">'+meta.label+'</div>'
			+'</div>'
			+'<div class="events-wrap" id="evwrap-'+g+'">'
			+rows.map(evRow).join('')
			+'</div>'
			+'</div>';
		});

		if (!shown) html='<div class="empty-state">No events found</div>';
		$('#events-list').html(html);
	}

	function evRow(d){
	  var locked = !!Number(d.is_mandatory);
	  var inact  = Number(d.is_active) !== 1 ? ' inactive' : '';
	  var mandB  = locked ? '<div class="mand-bar"></div>' : '';
	  var noteH  = d.note ? '<div class="ev-note"><i class="fa-solid fa-circle-info"></i>'+d.note+'</div>' : '';

	  return '<div class="ev-row'+inact+'" id="evr-'+d.id+'">'+mandB
		+'<div class="ev-inner">'
		  +'<div>'
			+'<div class="ev-top">'
			  +'<span class="ev-label">'+d.label+'</span>'
			  +'<span class="ev-key">'+d.event_name+'</span>'
			  +(locked?'<span class="b-mand"><i class="fa-solid fa-lock"></i>Mandatory</span>':'')
			  +(Number(d.user_configurable) === 1 ?'<span class="b-ucfg"><i class="fa-solid fa-user-gear"></i>User Config</span>':'')
			+'</div>'
			+'<div class="ev-desc">'+d.description+'</div>'
			+noteH
		  +'</div>'

		  +'<div class="ev-controls">'
			+'<div class="ch-toggles">'

			  +'<div class="ch-col">'
				+'<span class="ch-lbl sms">SMS</span>'
				+'<label class="tog sms-t '+(locked?'locked':'')+'">'
				  +'<input type="checkbox" '
				  +(Number(d.sms) === 1 ? 'checked' : '')
				  +' onchange="setChannel('+d.id+',\'sms\',this.checked)">'
				  +'<span class="tog-s"></span>'
				+'</label>'
			  +'</div>'

			  +'<div class="ch-col">'
				+'<span class="ch-lbl email">Email</span>'
				+'<label class="tog email-t '+(locked?'locked':'')+'">'
				  +'<input type="checkbox" '
				  +(Number(d.email) === 1 ? 'checked' : '')
				  +' onchange="setChannel('+d.id+',\'email\',this.checked)">'
				  +'<span class="tog-s"></span>'
				+'</label>'
			  +'</div>'

			+'</div>'


		  +'</div>'
		+'</div>'
	  +'</div>';
	}

	/* ================= ACTIONS ================= */
	function setChannel(id, ch, val){
	  var ev = byId(id);
	  if (!ev) return;

	  ev[ch] = val ? 1 : 0;

	  renderStats();
	}

	function setActive(id, val){
	  var ev = byId(id);
	  if (!ev) return;

	  if (Number(ev.is_mandatory) === 1 && !val){
		renderAll(); // revert UI
		return;
	  }

	  ev.is_active = val ? 1 : 0;

	  $('#evr-'+id).toggleClass('inactive', !val);

	  $('#slbl-'+id)
		.text(val ? 'ON' : 'OFF')
		.css('color', val ? 'var(--success)' : 'var(--text-muted)');

	  renderStats();
	} 

	function setChanFilter(f,el){ chanFilter=f; $('.tb-btn').removeClass('active'); $(el).addClass('active'); renderAll(); }
	function toggleInactive(el){ showInactive=!showInactive; $(el).toggleClass('active',showInactive); renderAll(); }
	function toggleGroup(g){ $('#evwrap-'+g).slideToggle(180); $('#chev-'+g).toggleClass('open'); }
	
	function scopedData(){
	  return activeGroup === 'ALL'
		? DATA
		: DATA.filter(function(d){
			return d.group_key === activeGroup;
		  });
	}
	
	function scopeLabel(){
	  return activeGroup === 'ALL'
		? 'All Groups'
		: (GROUPS[activeGroup] ? GROUPS[activeGroup].label : activeGroup);
	}
	
	function bulkChannel(ch, val){
	  scopedData().forEach(function(d){

		// skip mandatory OFF case (optional rule)
		if (d.is_mandatory == 1 && val === 0) return;

		// if event is inactive, optionally activate it when enabling channel
		if (val === 1 && d.is_active == 0){
		  d.is_active = 1;
		}

		d[ch] = val ? 1 : 0;
	  });

	  logAudit(
		'bulk',
		'Bulk: All <strong>'+ch.toUpperCase()+'</strong> '+(val ? 'enabled' : 'disabled')+' — '+scopeLabel()
	  );

	  renderStats();
	  renderAll();

	  toast(
		'All '+ch.toUpperCase()+' '+(val ? 'enabled' : 'disabled')+' in '+scopeLabel(),
		val ? 's' : 'w'
	  );
	}
	
	function bulkDisable(){
	  if (!confirm('Disable ALL non-mandatory SMS and Email notifications in the current view?')) return;

	  scopedData().forEach(function(d){

		// NEVER disable mandatory
		if (Number(d.is_mandatory) === 1) return;

		d.sms = 0;
		d.email = 0;
		d.is_active = 0;
	  });

	  logAudit(
		'bulk',
		'Bulk: All non-mandatory notifications disabled — '+scopeLabel()
	  );

	  renderStats();
	  renderAll();

	  toast('All non-mandatory notifications disabled','w');
	}
	
	/* ================= HELPERS ================= */
	function byId(id){
		return DATA.find(d=>d.id===id);
	}

	function toggleGroup(g){
		$('#evwrap-'+g).slideToggle();
	}

	/* ================= AUDIT ================= */
	function logAudit(type,msg){
		auditLog.unshift({type:type,msg:msg});
		if (auditLog.length>50) auditLog.pop();
	}


	function saveAll(){
		$.ajax({
			url: "/Notification_manager/save_settings",
			type: "POST",
			dataType: "json",
			contentType: "application/json",
			data: JSON.stringify({ events: DATA }),

			success: function(res){
			  if(res.status === 'success'){
				toast('Notification settings saved','s');
			  }else{
				toast('Save failed','e');
			  }
			},

			error: function(){
			  toast('Server error','e');
			}
		});
	}
</script>