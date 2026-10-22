<style>
	:root {
	  --primary:#3d52a0;--primary-d:#2d3d80;--primary-light:#eef1fb;--primary-mid:#c5cff7;
	  --accent:#f59e0b;--accent-light:#fef3c7;
	  --success:#10b981;--success-light:#d1fae5;--success-d:#059669;
	  --danger:#ef4444;--danger-light:#fee2e2;
	  --warning:#f59e0b;--warning-light:#fef3c7;
	  --info:#0ea5e9;--info-light:#e0f2fe;
	  --purple:#8b5cf6;--purple-light:#ede9fe;
	  --orange:#f97316;--orange-light:#ffedd5;
	  --teal:#14b8a6;--teal-light:#ccfbf1;
	  --sidebar-bg:#1a1f36;--sidebar-text:#a8b4d8;
	  --page-bg:#f2f4fa;--card-bg:#fff;--card-border:#e4e9f4;
	  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
	  --input-border:#d1d9e6;--table-head:#f7f9ff;
	  --shadow-sm:0 1px 4px rgba(61,82,160,.07);--shadow-md:0 4px 18px rgba(61,82,160,.11);--shadow-lg:0 8px 36px rgba(61,82,160,.16);
	  --r-sm:8px;--r-md:12px;--r-lg:16px;--r-xl:20px;
	  --sidebar-w:240px;--header-h:60px;--tr:.22s cubic-bezier(.4,0,.2,1);
	}
	*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
	body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;overflow-x:hidden;}
	::-webkit-scrollbar{width:5px;height:5px;}::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

	/* ─── SIDEBAR ─── */
	.app-sidebar{position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-w);background:var(--sidebar-bg);z-index:100;display:flex;flex-direction:column;}
	.sidebar-logo{height:var(--header-h);display:flex;align-items:center;padding:0 18px;border-bottom:1px solid rgba(255,255,255,.06);}
	.logo-mark{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;font-size:15px;color:#fff;font-weight:800;flex-shrink:0;}
	.logo-text{margin-left:10px;color:#fff;font-weight:700;font-size:15px;letter-spacing:-.3px;}.logo-text span{color:#7b8dd1;}
	.sidebar-nav{flex:1;overflow-y:auto;padding:10px 0;}
	.nav-cat{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(168,180,216,.45);padding:14px 18px 5px;}
	.nav-link{display:flex;align-items:center;gap:10px;padding:9px 18px;color:var(--sidebar-text);text-decoration:none;font-size:13px;font-weight:500;cursor:pointer;transition:all var(--tr);}
	.nav-link i{font-size:15px;width:18px;text-align:center;flex-shrink:0;}
	.nav-link:hover{background:rgba(255,255,255,.05);color:#fff;}
	.nav-link.active{background:rgba(61,82,160,.28);color:#fff;border-right:3px solid #7b8dd1;}
	.nav-badge{margin-left:auto;background:var(--accent);color:#fff;font-size:10px;padding:1px 7px;border-radius:20px;font-weight:700;}

	/* ─── HEADER ─── */
	.app-header{position:fixed;top:0;left:var(--sidebar-w);right:0;height:var(--header-h);background:#fff;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;padding:0 22px;z-index:90;box-shadow:var(--shadow-sm);}
	.hdr-left{display:flex;align-items:center;gap:14px;}
	.breadcrumb{display:flex;align-items:center;gap:5px;font-size:13px;color:var(--text-muted);}
	.breadcrumb a{color:var(--primary);text-decoration:none;font-weight:500;}
	.breadcrumb .sep{color:#ccc;}
	.breadcrumb .cur{color:var(--text-dark);font-weight:600;}
	.hdr-right{display:flex;align-items:center;gap:10px;}
	.hdr-btn{width:34px;height:34px;border-radius:var(--r-sm);border:1px solid var(--card-border);background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-muted);transition:all var(--tr);position:relative;}
	.hdr-btn:hover{border-color:var(--primary);color:var(--primary);}
	.hdr-btn .dot{position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:var(--danger);border:1.5px solid #fff;}
	.user-pill{display:flex;align-items:center;gap:8px;background:var(--primary-light);border-radius:20px;padding:4px 12px 4px 4px;cursor:pointer;}
	.user-av{width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#3d52a0,#7b8dd1);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:700;}
	.user-nm{font-size:12px;font-weight:600;color:var(--primary);}

	/* ─── MAIN ─── */
	.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:18px 22px;min-height:calc(100vh - var(--header-h));padding-bottom:160px;}

	/* ─── PAGE HEADER ─── */
	.pg-hdr{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:18px;gap:14px;flex-wrap:wrap;}
	.pg-hdr h1{font-size:19px;font-weight:800;color:var(--text-dark);letter-spacing:-.3px;}
	.inv-meta{display:flex;align-items:center;gap:8px;margin-top:5px;flex-wrap:wrap;}
	.inv-num{display:inline-flex;align-items:center;gap:5px;background:var(--primary-light);border:1px solid var(--primary-mid);border-radius:var(--r-sm);padding:3px 10px;font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:600;color:var(--primary);}
	.status-pill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;}
	.st-draft{background:#f0f0f0;color:#6c757d;}.st-pending{background:var(--accent-light);color:#b45309;}.st-done{background:var(--success-light);color:#065f46;}
	.wf-steps{display:flex;align-items:center;}
	.wf-s{display:flex;align-items:center;gap:5px;font-size:11px;font-weight:600;padding:3px 8px;color:var(--text-muted);}
	.wf-s::after{content:'›';margin-left:4px;color:#ccc;font-size:13px;}
	.wf-s:last-child::after{display:none;}
	.wf-s.done{color:var(--success);}.wf-s.active{color:var(--primary);font-weight:700;}

	/* ─── CARDS ─── */
	.card{background:var(--card-bg);border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--shadow-sm);overflow:visible;margin-bottom:14px;}
	.card-head{padding:13px 17px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:9px;background:var(--card-bg);border-radius:var(--r-md) var(--r-md) 0 0;}
	.sec-icon{width:28px;height:28px;border-radius:var(--r-sm);background:var(--primary-light);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:13px;flex-shrink:0;}
	.card-head h6{font-size:13px;font-weight:700;color:var(--text-dark);margin:0;}
	.card-body{padding:16px;}

	/* ─── FORMS ─── */
	.lbl{font-size:11px;font-weight:700;color:var(--text-mid);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px;}
	.fc{width:100%;padding:8px 11px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr),box-shadow var(--tr);}
	.fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
	.fc::placeholder{color:var(--text-muted);}
	textarea.fc{resize:vertical;min-height:56px;}
	.ig{position:relative;}
	.ig .fc{padding-left:34px;}
	.ig .ipfx{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;pointer-events:none;}
	.ig-r{position:relative;}
	.ig-r .fc{padding-right:34px;}
	.ig-r .isfx{position:absolute;right:11px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;pointer-events:none;}

	/* ─── GRID ─── */
	.g{display:grid;gap:12px;}
	.g2{grid-template-columns:1fr 1fr;}
	.g3{grid-template-columns:1fr 1fr 1fr;}
	.g4{grid-template-columns:1fr 1fr 1fr 1fr;}
	.g5{grid-template-columns:1fr 1fr 1fr 1fr 1fr;}
	.gc-full{grid-column:1/-1;}

	/* ─── CUSTOMER PANEL ─── */
	.cust-bar{background:linear-gradient(135deg,var(--primary-light),#f0f4ff);border:1.5px solid var(--primary-mid);border-radius:var(--r-md);padding:13px 16px;margin-top:11px;display:none;}
	.cust-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px;}
	.ci-item .lbl2{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:2px;}
	.ci-item .val{font-size:13px;font-weight:600;color:var(--text-dark);}
	.cr-bar-w{flex:1;height:5px;background:#e2e8f0;border-radius:10px;overflow:hidden;margin-top:4px;}
	.cr-bar-f{height:100%;border-radius:10px;background:linear-gradient(90deg,var(--success),#34d399);}
	.cr-bar-f.warn{background:linear-gradient(90deg,var(--warning),#fbbf24);}
	.cr-bar-f.bad{background:linear-gradient(90deg,var(--danger),#f87171);}

	/* ─── ITEM ENTRY BAR ─── */
	.entry-bar{background:var(--table-head);border:1.5px dashed var(--primary-mid);border-radius:var(--r-md);padding:13px;margin-bottom:11px;}
	.entry-top{display:grid;grid-template-columns:2fr 80px 130px 80px auto;gap:9px;align-items:end;}
	.entry-extras{display:none;margin-top:10px;border-top:1px solid var(--card-border);padding-top:10px;}

	/* ─── PRODUCT INFO PANEL ─── */
	.prod-info-panel{background:linear-gradient(135deg,#f8faff,#eef4ff);border:1.5px solid var(--primary-mid);border-radius:var(--r-md);padding:12px 14px;margin-top:10px;display:none;animation:slideDown .2s ease;}
	@keyframes slideDown{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
	.pip-grid{display:grid;grid-template-columns:auto 1fr;gap:12px 20px;align-items:start;}
	.pip-img{width:64px;height:64px;border-radius:var(--r-sm);background:#fff;border:1.5px solid var(--primary-mid);display:flex;align-items:center;justify-content:center;font-size:26px;flex-shrink:0;}
	.pip-right{display:grid;grid-template-columns:repeat(auto-fit,minmax(100px,1fr));gap:8px;}
	.pip-item .pil{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:1px;}
	.pip-item .piv{font-size:12px;font-weight:600;color:var(--text-dark);}
	.pip-item .piv.green{color:var(--success);}
	.pip-item .piv.red{color:var(--danger);}
	.pip-item .piv.orange{color:var(--orange);}
	.pip-badges{display:flex;gap:5px;flex-wrap:wrap;margin-top:8px;}
	.feat-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;}
	.fb-serial{background:var(--purple-light);color:#6d28d9;}
	.fb-batch{background:var(--teal-light);color:#0f766e;}
	.fb-expiry{background:var(--orange-light);color:#c2410c;}
	.fb-warranty{background:var(--success-light);color:#065f46;}
	.fb-free{background:var(--accent-light);color:#92400e;}

	/* ─── SERIAL/BATCH/EXPIRY ROW ─── */
	.spec-row{background:#fff;border:1.5px solid var(--card-border);border-radius:var(--r-sm);padding:10px 12px;margin-top:8px;display:none;}
	.spec-row.show{display:block;}
	.spec-row .sr-grid{display:grid;gap:8px;}
	.sr-tag{display:inline-flex;align-items:center;gap:5px;padding:3px 8px;border-radius:4px;font-size:11px;font-weight:700;margin-bottom:6px;}
	.sr-serial{background:var(--purple-light);color:#6d28d9;}
	.sr-batch{background:var(--teal-light);color:#0f766e;}
	.sr-expiry{background:var(--orange-light);color:#c2410c;}
	.sr-warranty{background:var(--success-light);color:#065f46;}

	/* Serial chip list */
	.serial-chips{display:flex;flex-wrap:wrap;gap:5px;margin-top:6px;min-height:28px;padding:4px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);background:#fff;}
	.s-chip{display:inline-flex;align-items:center;gap:5px;background:var(--purple-light);color:#5b21b6;border-radius:4px;padding:2px 8px;font-size:11px;font-weight:600;font-family:'JetBrains Mono',monospace;}
	.s-chip button{background:none;border:none;cursor:pointer;color:#7c3aed;font-size:10px;padding:0;}
	.serial-add-row{display:flex;gap:6px;margin-top:6px;}

	/* Batch select */
	.batch-option{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);cursor:pointer;margin-bottom:5px;transition:all var(--tr);}
	.batch-option:hover,.batch-option.sel{border-color:var(--teal);background:var(--teal-light);}
	.batch-option .bn{font-size:12px;font-weight:700;font-family:'JetBrains Mono',monospace;color:var(--text-dark);}
	.batch-option .bmeta{font-size:11px;color:var(--text-muted);}
	.batch-option .bstock{font-size:11px;font-weight:700;color:var(--teal);}

	/* ─── FREE ISSUE ROW ─── */
	.fi-row{display:grid;grid-template-columns:auto 70px auto;gap:7px;align-items:center;background:var(--accent-light);border:1.5px solid #fde68a;border-radius:var(--r-sm);padding:7px 10px;margin-top:8px;}
	.fi-label{font-size:11px;font-weight:700;color:#92400e;display:flex;align-items:center;gap:5px;}
	.fi-input{width:100%;padding:5px 8px;border:1.5px solid #fde68a;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;text-align:center;background:#fff;color:#92400e;outline:none;}
	.fi-input:focus{border-color:var(--accent);}
	.fi-note{font-size:10px;color:#92400e;font-weight:600;}

	/* ─── ADD BTN ─── */
	.add-btn{padding:8px 16px;background:var(--primary);color:#fff;border:none;border-radius:var(--r-sm);font-weight:700;font-size:13px;cursor:pointer;white-space:nowrap;font-family:inherit;display:flex;align-items:center;gap:6px;transition:all var(--tr);}
	.add-btn:hover{background:var(--primary-d);transform:translateY(-1px);}

	/* ─── ITEM SEARCH DROPDOWN ─── */
	.search-wrap{position:relative;}
	.item-dd{position:absolute;top:calc(100% + 4px);left:0;right:0;background:#fff;border:1.5px solid var(--primary-mid);border-radius:var(--r-md);z-index:200;box-shadow:var(--shadow-lg);max-height:300px;overflow-y:auto;display:none;}
	.i-opt{display:flex;align-items:center;gap:10px;padding:9px 12px;cursor:pointer;border-bottom:1px solid var(--card-border);transition:background var(--tr);}
	.i-opt:last-child{border-bottom:none;}
	.i-opt:hover,.i-opt.hover{background:var(--primary-light);}
	.i-code{font-family:'JetBrains Mono',monospace;font-size:10px;background:var(--primary-light);color:var(--primary);padding:2px 6px;border-radius:3px;font-weight:600;flex-shrink:0;}
	.i-name{font-size:13px;font-weight:600;color:var(--text-dark);}
	.i-sub{font-size:11px;color:var(--text-muted);display:flex;align-items:center;gap:5px;margin-top:1px;}
	.i-price{margin-left:auto;font-size:12px;font-weight:700;color:var(--primary);font-family:'JetBrains Mono',monospace;flex-shrink:0;}
	.stk{font-size:10px;padding:1px 5px;border-radius:3px;font-weight:700;}
	.stk-ok{background:var(--success-light);color:#065f46;}
	.stk-low{background:var(--warning-light);color:#92400e;}
	.stk-out{background:var(--danger-light);color:#991b1b;}

	/* ─── TABLE ─── */
	.tbl-wrap{overflow-x:auto;border-radius:var(--r-md);border:1px solid var(--card-border);}
	.tbl{width:100%;border-collapse:collapse;min-width:900px;}
	.tbl thead tr{background:var(--table-head);}
	.tbl th{padding:10px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);border-bottom:2px solid var(--card-border);white-space:nowrap;}
	.tbl th.r,.tbl td.r{text-align:right;}
	.tbl th.c,.tbl td.c{text-align:center;}
	.tbl td{padding:9px 12px;font-size:13px;border-bottom:1px solid var(--card-border);vertical-align:top;}
	.tbl tbody tr:hover{background:#fafbff;}
	.tbl tbody tr:last-child td{border-bottom:none;}
	.tbl-name{font-weight:600;font-size:13px;}
	.tbl-sub{font-size:11px;color:var(--text-muted);margin-top:1px;display:flex;align-items:center;gap:4px;flex-wrap:wrap;}
	.tbl-tags{display:flex;gap:3px;margin-top:3px;flex-wrap:wrap;}
	.t-tag{font-size:10px;padding:1px 6px;border-radius:3px;font-weight:700;}
	.ti-input{width:64px;padding:5px 7px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);text-align:center;font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:700;outline:none;}
	.ti-input:focus{border-color:var(--primary);box-shadow:0 0 0 2px rgba(61,82,160,.1);}
	.fi-tbl-input{width:58px;padding:5px 6px;border:1.5px solid #fde68a;border-radius:var(--r-sm);text-align:center;font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:700;outline:none;background:var(--accent-light);color:#92400e;}
	.fi-tbl-input:focus{border-color:var(--accent);}
	.del-btn{background:none;border:1.5px solid var(--danger-light);color:var(--danger);border-radius:var(--r-sm);width:26px;height:26px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all var(--tr);font-size:11px;margin-left:auto;}
	.del-btn:hover{background:var(--danger);color:#fff;border-color:var(--danger);}
	.mono{font-family:'JetBrains Mono',monospace;}
	.empty-cart{text-align:center;padding:36px 20px;color:var(--text-muted);}
	.empty-cart i{font-size:38px;opacity:.25;display:block;margin-bottom:8px;}
	.empty-cart p{font-size:13px;}

	/* ─── WARNING CHIPS IN TABLE ─── */
	.warn-chip{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:1px 6px;border-radius:3px;}
	.wc-expiry{background:var(--orange-light);color:#c2410c;}
	.wc-serial{background:var(--purple-light);color:#6d28d9;}
	.wc-batch{background:var(--teal-light);color:#0f766e;}
	.wc-fi{background:var(--accent-light);color:#92400e;}
	.wc-warranty{background:var(--success-light);color:#065f46;}

	/* ─── SUMMARY / RIGHT ─── */
	.sum-box{background:var(--primary-light);border:1.5px solid var(--primary-mid);border-radius:var(--r-md);padding:16px;}
	.sum-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:9px;}
	.sum-row:last-child{margin-bottom:0;}
	.sum-row .sl{font-size:12px;color:var(--text-muted);font-weight:600;}
	.sum-row .sv{font-size:13px;font-weight:700;color:var(--text-dark);font-family:'JetBrains Mono',monospace;}
	.sum-divider{height:1px;background:var(--primary-mid);margin:10px 0;}
	.sum-total .sl{font-size:14px;color:var(--primary);font-weight:800;}
	.sum-total .sv{font-size:18px;color:var(--primary);font-weight:800;}

	.confirm-btn{width:100%;padding:13px;background:linear-gradient(135deg,#3d52a0,#2d3d80);color:#fff;border:none;border-radius:var(--r-md);font-family:inherit;font-size:14px;font-weight:800;cursor:pointer;transition:all var(--tr);display:flex;align-items:center;justify-content:center;gap:9px;box-shadow:0 4px 14px rgba(61,82,160,.32);}
	.confirm-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(61,82,160,.42);}
	.confirm-btn:disabled{opacity:.45;cursor:not-allowed;transform:none;}
	.kbd{background:rgba(255,255,255,.2);border-radius:3px;padding:1px 5px;font-size:10px;font-family:'JetBrains Mono',monospace;}

	/* ─── PAYMENT PANEL ─── */
	#pay-panel{position:fixed;bottom:0;left:var(--sidebar-w);right:0;background:#fff;border-top:2px solid var(--primary-mid);box-shadow:0 -8px 36px rgba(61,82,160,.16);z-index:300;transform:translateY(100%);transition:transform .35s cubic-bezier(.4,0,.2,1);max-height:80vh;overflow-y:auto;}
	#pay-panel.open{transform:translateY(0);}
	.pp-inner{display:grid;grid-template-columns:1fr 370px;}
	.pp-head{background:linear-gradient(135deg,var(--primary),var(--primary-d));color:#fff;padding:13px 20px;display:flex;align-items:center;justify-content:space-between;grid-column:1/-1;}
	.pp-head h5{font-size:14px;font-weight:800;letter-spacing:-.2px;}
	.pp-head .pref{font-size:11px;opacity:.7;font-family:'JetBrains Mono',monospace;}
	.pp-close{background:rgba(255,255,255,.15);border:none;color:#fff;border-radius:var(--r-sm);width:30px;height:30px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:14px;transition:background var(--tr);}
	.pp-close:hover{background:rgba(255,255,255,.25);}
	.pp-left{padding:16px 18px;border-right:1px solid var(--card-border);}
	.pp-right{padding:16px 18px;background:var(--page-bg);}
	.sec-lbl{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);margin-bottom:8px;display:block;}
	.pt-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:7px;margin-bottom:14px;}
	.pt-btn{padding:9px 5px;border:2px solid var(--card-border);border-radius:var(--r-sm);background:#fff;text-align:center;cursor:pointer;transition:all var(--tr);font-family:inherit;}
	.pt-btn i{font-size:17px;display:block;margin-bottom:3px;color:var(--text-muted);}
	.pt-btn span{font-size:10px;font-weight:700;color:var(--text-muted);display:block;}
	.pt-btn.sel{border-color:var(--primary);background:var(--primary-light);}
	.pt-btn.sel i,.pt-btn.sel span{color:var(--primary);}
	.qa-grid{display:grid;grid-template-columns:1fr 1fr;gap:7px;margin-bottom:12px;}
	.qa-btn{padding:8px;border-radius:var(--r-sm);font-size:11px;font-weight:700;cursor:pointer;font-family:inherit;border:1.5px solid;transition:all var(--tr);display:flex;align-items:center;gap:5px;justify-content:center;}
	.qa-cash{background:var(--success-light);color:#065f46;border-color:#6ee7b7;}
	.qa-cash:hover{background:var(--success);color:#fff;border-color:var(--success);}
	.qa-round{background:var(--info-light);color:#0369a1;border-color:#7dd3fc;}
	.qa-round:hover{background:var(--info);color:#fff;}
	.pay-lines{display:flex;flex-direction:column;gap:7px;}
	.pay-line{display:grid;grid-template-columns:140px 1fr 32px;gap:7px;align-items:center;animation:sli .2s ease;}
	@keyframes sli{from{opacity:0;transform:translateY(-5px)}to{opacity:1;transform:translateY(0)}}
	.pm-sel,.pa-inp{padding:8px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;color:var(--text-dark);outline:none;width:100%;}
	.pa-inp{font-family:'JetBrains Mono',monospace;font-weight:700;text-align:right;}
	.pm-sel:focus,.pa-inp:focus{border-color:var(--primary);}
	.rm-line{width:30px;height:34px;border:1.5px solid var(--danger-light);background:none;border-radius:var(--r-sm);color:var(--danger);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;transition:all var(--tr);}
	.rm-line:hover{background:var(--danger);color:#fff;}
	.add-pm-btn{margin-top:8px;padding:7px 12px;border:1.5px dashed var(--primary-mid);background:var(--primary-light);color:var(--primary);border-radius:var(--r-sm);font-size:11px;font-weight:700;cursor:pointer;font-family:inherit;width:100%;transition:all var(--tr);}
	.add-pm-btn:hover{border-color:var(--primary);}
	.bal-box{background:var(--primary);color:#fff;border-radius:var(--r-md);padding:14px;}
	.bal-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;}
	.bal-row:last-child{margin-bottom:0;}
	.bal-row .bl{font-size:11px;opacity:.8;font-weight:600;}
	.bal-row .bv{font-family:'JetBrains Mono',monospace;font-size:13px;font-weight:700;}
	.bal-div{height:1px;background:rgba(255,255,255,.2);margin:9px 0;}
	.bal-row.grand .bl{font-size:13px;font-weight:800;opacity:1;}
	.bal-row.grand .bv{font-size:18px;}
	.bal-row.change .bv{color:#6ee7b7;}
	.chq-details{margin-top:10px;display:none;}
	.card-details{margin-top:10px;}
	.credit-warn{background:var(--danger-light);border:1.5px solid #fca5a5;border-radius:var(--r-sm);padding:9px 11px;margin-bottom:9px;font-size:12px;color:#991b1b;font-weight:600;display:none;}
	.cr-info{background:var(--info-light);border:1.5px solid #7dd3fc;border-radius:var(--r-sm);padding:9px 11px;margin-bottom:9px;display:none;}
	.cr-info .cir{display:flex;justify-content:space-between;font-size:12px;margin-bottom:3px;}
	.cr-info .cir:last-child{margin-bottom:0;}
	.cr-info .cil{color:#0369a1;font-weight:600;}.cr-info .civ{font-family:'JetBrains Mono',monospace;font-weight:700;}
	.complete-btn{width:100%;padding:13px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;border-radius:var(--r-md);font-family:inherit;font-size:14px;font-weight:800;cursor:pointer;transition:all var(--tr);margin-top:10px;display:flex;align-items:center;justify-content:center;gap:9px;box-shadow:0 4px 14px rgba(16,185,129,.3);}
	.complete-btn:hover{transform:translateY(-2px);}
	.complete-btn:disabled{opacity:.4;cursor:not-allowed;transform:none;}
	.back-btn{width:100%;padding:9px;background:none;border:1.5px solid var(--card-border);border-radius:var(--r-sm);color:var(--text-mid);font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;transition:all var(--tr);margin-top:7px;}
	.back-btn:hover{border-color:var(--primary);color:var(--primary);}

	/* ─── LOCKED OVERLAY ─── */
	.locked-ov{position:absolute;inset:0;background:rgba(248,250,255,.65);backdrop-filter:blur(2px);z-index:10;border-radius:var(--r-md);display:none;align-items:center;justify-content:center;flex-direction:column;gap:7px;}
	.locked-ov i{font-size:26px;color:var(--primary);opacity:.4;}
	.locked-ov span{font-size:12px;color:var(--text-muted);font-weight:600;}
	.rel{position:relative;}

	/* ─── MISC ─── */
	.badge{display:inline-flex;align-items:center;gap:4px;padding:2px 7px;border-radius:20px;font-size:11px;font-weight:700;}
	.b-pri{background:var(--primary-light);color:var(--primary);}
	.b-suc{background:var(--success-light);color:#065f46;}
	.b-acc{background:var(--accent-light);color:#92400e;}
	.divider{height:1px;background:var(--card-border);margin:12px 0;}
	.d-flex{display:flex;}.ac{align-items:center;}.jb{justify-content:space-between;}.gap-2{gap:8px;}.gap-1{gap:5px;}
	.mt-1{margin-top:5px;}.mt-2{margin-top:9px;}.mt-3{margin-top:14px;}.mb-2{margin-bottom:9px;}.mb-3{margin-bottom:14px;}
	.ml-auto{margin-left:auto;}
	.fs-11{font-size:11px;}.fs-12{font-size:12px;}.fw-600{font-weight:600;}.fw-700{font-weight:700;}.fw-800{font-weight:800;}
	.text-muted{color:var(--text-muted);}
	.text-success{color:var(--success);}
	.text-danger{color:var(--danger);}
	.text-primary{color:var(--primary);}

	/* ─── TOAST ─── */
	#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
	.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;pointer-events:auto;display:flex;align-items:center;gap:7px;box-shadow:var(--shadow-lg);animation:tIn .25s ease;max-width:310px;}
	@keyframes tIn{from{opacity:0;transform:translateX(18px)}to{opacity:1;transform:translateX(0)}}
	.t-suc{background:var(--success);color:#fff;}.t-warn{background:var(--warning);color:#fff;}.t-err{background:var(--danger);color:#fff;}.t-info{background:var(--primary);color:#fff;}

	/* ─── SUCCESS OVERLAY ─── */
	.suc-ov{position:fixed;inset:0;background:rgba(10,18,45,.85);z-index:9999;display:none;align-items:center;justify-content:center;}
	.suc-card{background:#fff;border-radius:var(--r-xl);padding:36px;text-align:center;max-width:380px;width:90%;animation:popIn .38s cubic-bezier(.34,1.56,.64,1);}
	@keyframes popIn{from{opacity:0;transform:scale(.8)}to{opacity:1;transform:scale(1)}}
	.suc-icon{width:68px;height:68px;border-radius:50%;background:var(--success-light);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:30px;color:var(--success);}
	.suc-card h3{font-size:19px;font-weight:800;margin-bottom:5px;}
	.suc-card p{font-size:13px;color:var(--text-muted);margin-bottom:18px;}
	.suc-meta{background:var(--primary-light);border-radius:var(--r-sm);padding:11px;margin-bottom:16px;}
	.suc-meta-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px;}
	.suc-meta-row:last-child{margin-bottom:0;}
	.suc-actions{display:flex;gap:9px;justify-content:center;}
	.btn-print,.btn-new{padding:9px 18px;border:none;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;}
	.btn-print{background:var(--primary);color:#fff;}
	.btn-new{background:var(--success);color:#fff;}

	/* ─── STATS GRID ─── */
	.stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:9px;}
	.stat-box{border-radius:var(--r-sm);padding:9px;text-align:center;}
	.stat-box .sv{font-size:18px;font-weight:800;font-family:'JetBrains Mono',monospace;}
	.stat-box .sl{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);}

	/* ─── MODALS ─── */
	.modal-bg{position:fixed;inset:0;background:rgba(10,18,45,.6);z-index:500;display:none;align-items:center;justify-content:center;}
	.modal-bg.show{display:flex;}
	.modal-box{background:#fff;border-radius:var(--r-lg);padding:22px;max-width:480px;width:95%;max-height:85vh;overflow-y:auto;box-shadow:var(--shadow-lg);animation:popIn .3s ease;}
	.modal-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
	.modal-head h5{font-size:14px;font-weight:800;color:var(--text-dark);}
	.modal-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:18px;}
</style>

		
		
		<form id="saleform">
			
			<!-- ─── HEADER ─── 
			<header class="app-header">
				<div class="hdr-left">
					<div class="breadcrumb">
						<a href="#">Sales</a><span class="sep">›</span><span class="cur">New Invoice</span>
					</div>
				</div>
				<div class="hdr-right">
					<div class="hdr-btn"><i class="fa-solid fa-magnifying-glass"></i></div>
					<div class="hdr-btn"><i class="fa-solid fa-bell"></i><span class="dot"></span></div>
					<div class="hdr-btn"><i class="fa-solid fa-gear"></i></div>
					<div class="user-pill"><div class="user-av">AD</div><span class="user-nm">Admin</span></div>
				</div>
			</header>-->
			
			<!-- ─── MAIN ─── -->
			<main class="main">
				<!-- Page Header -->
				<div class="pg-hdr">
					<div>
						<h1>New Sales Invoice </h1>
						<input type="hidden" id="mode" name="mode" value="complete">
						<input type="hidden" id="invid" name="inv_id" value="0">
						<div class="inv-meta">
							<span class="inv-num"><i class="fa-solid fa-hashtag"></i><span id="inv-number">INV-2026-0087</span></span>
							<span class="status-pill st-draft" id="inv-status"><i class="fa-solid fa-circle" style="font-size:7px"></i> Draft</span>
							<div class="wf-steps">
								<span class="wf-s done"><i class="fa-solid fa-check"></i> Start</span>
								<span class="wf-s active" id="wf1"><i class="fa-solid fa-pencil"></i> Items</span>
								<span class="wf-s" id="wf2">Confirm</span>
								<span class="wf-s" id="wf3">Payment</span>
								<span class="wf-s" id="wf4">Done</span>
							</div>
						</div>
					</div>
					<div class="d-flex ac gap-2">
						<button onclick="saveDraft()" type="submit" style="padding:8px 14px;border:1.5px solid var(--card-border);border-radius:var(--r-sm);background:#fff;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--text-mid);display:flex;align-items:center;gap:5px;" id="drft-btn"><i class="fa-regular fa-floppy-disk"></i>Save Draft</button>
						<button class="clear-frm" type="button" style="padding:8px 14px;border:1.5px solid var(--danger-light);border-radius:var(--r-sm);background:#fff;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--danger);display:flex;align-items:center;gap:5px;"><i class="fa-solid fa-trash"></i>Clear</button>
					</div>
				</div>

				<!-- GRID -->
				<div style="display:grid;grid-template-columns:1fr 290px;gap:14px;align-items:start;">

				<!-- ─── LEFT ─── -->
				<div>

					<!-- Section 1: Invoice Header -->
					<div class="card">
						<div class="card-head">
							<div class="sec-icon"><i class="fa-solid fa-file-invoice"></i></div>
							<h6>Invoice Details</h6>
						</div>
						<div class="card-body">
							<div class="g g3">
								<div>
									<label class="lbl">Customer <span style="color:var(--danger)">*</span></label>
									<select class="fc"  name="customer_id" id="cust-sel" onchange="onCustChange()" required>
										<option value=''>— Select Customer —</option>
											<?php
												foreach($cus as $item){
													echo"<option value='$item->cus_id'>$item->cus_name</option>";
												}
											?>
									</select>
								</div>
								<div>
									<label class="lbl">Invoice Date <span style="color:var(--danger)">*</span></label>
									<input type="date" name="invoice_date" class="fc" id="inv-date" required>
								</div>
								<div>
									<label class="lbl">Due Date <span style="color:var(--danger)">*</span></label>
									<input type="date" name="due_date" class="fc" id="inv-due" required>
								</div>
								<div>
									<label class="lbl">Sales Person <span style="color:var(--danger)">*</span></label>
										<select class="fc" name="created_by" id="sales-person" required>
											<option value="">- Sales Person -</option>
												<?php
													foreach($staff as $item){
														echo"<option value='$item->staff_id'>$item->full_name</option>";
													}
												?>
										</select>
								</div>
								<div>
									<label class="lbl">Warehouse <span style="color:var(--danger)">*</span></label>
									<select class="fc" name="warehouse_id" id="warehouse" required>
										<option value="">- Warehouse -</option>
										<?php
											foreach($store as $item){
												echo"<option value='$item->store_id'>$item->store_name</option>";
											}
										?>
									</select>
								</div>
								<div>
									<label class="lbl">Price List <span style="color:var(--danger)">*</span></label>
									<select class="fc" id="price-list" onchange="applyPriceList()" required>
										<option value="retail">Retail Price</option>
										<option value="wholesale">Wholesale Price</option>
										<option value="special">Special Rate</option>
									</select>
								</div>
							</div>
							<div class="cust-bar" id="cust-bar"><div class="cust-grid" id="cust-grid"></div></div>
						</div>	
					</div>

				  <!-- Section 2: Item Entry -->
				  <div class="card rel" id="items-card">
					<div class="locked-ov" id="items-locked">
					  <i class="fa-solid fa-lock"></i><span>Invoice confirmed — payment in progress</span>
					</div>
					<div class="card-head">
					  <div class="sec-icon"><i class="fa-solid fa-cart-plus"></i></div>
					  <h6>Add Items</h6>
					  <div class="ml-auto d-flex ac gap-2">
						<span class="badge b-pri" id="cnt-badge">0 items</span>
						<span class="badge b-acc" id="fi-count-badge" style="display:none"><i class="fa-solid fa-gift"></i>Free Issue</span>
					  </div>
					</div>
					<div class="card-body">

					  <!-- ENTRY BAR -->
					  <div class="entry-bar">
						<div class="entry-top">
						  <div>
							<label class="lbl">Search Item (Name / Code / Barcode)</label>
							<div class="search-wrap">
							  <input type="text" class="fc" id="item-search" placeholder="Type to search…" autocomplete="off" onkeyup="searchItems(this.value)" onkeydown="handleItemKD(event)">
							  <div class="item-dd" id="item-dd"></div>
							</div>
						  </div>
						  <div>
							<label class="lbl">Qty</label>
							<input type="number" class="fc" id="e-qty" value="1" min="0.01" step="0.01" onchange="calcEntryLine()">
						  </div>
						  <div>
							<label class="lbl">Unit Price</label>
							<div class="ig"><span class="ipfx">Rs.</span><input type="number" class="fc" id="e-price" value="0" step="0.01" onchange="calcEntryLine()"></div>
						  </div>
						  <div>
							<label class="lbl">Disc %</label>
							<div class="ig-r" style="position:relative;"><input type="number" class="fc" id="e-disc" value="0" min="0" max="100" onchange="calcEntryLine()"><span class="isfx">%</span></div>
						  </div>
						  <div>
							<label class="lbl">&nbsp;</label>
							<button class="add-btn" type="button" onclick="addItem()"><i class="fa-solid fa-plus"></i>Add</button>
						  </div>
						</div>

						<!-- PRODUCT INFO PANEL -->
						<div class="prod-info-panel" id="prod-info-panel">
						  <div class="pip-grid">
							<div class="pip-img" id="pip-icon">📦</div>
							<div>
							  <div class="pip-right" id="pip-right"></div>
							  <div class="pip-badges" id="pip-badges"></div>
							</div>
						  </div>
						</div>

						<!-- EXTRA ENTRY OPTIONS (serial/batch/expiry/warranty/free issue) -->
						<div class="entry-extras" id="entry-extras">

						  <!-- Serial Number Entry -->
						  <div class="spec-row" id="ser-row">
							<span class="sr-tag sr-serial"><i class="fa-solid fa-barcode"></i>Serial Numbers Required</span>
							<div style="font-size:11px;color:var(--text-muted);margin-bottom:6px;">Enter all serial numbers for the quantity being sold.</div>
							<div class="serial-chips" id="serial-chips"></div>
							<div class="serial-add-row mt-2">
							  <input type="text" class="fc" id="serial-input" placeholder="Scan or type serial number…" style="font-family:'JetBrains Mono',monospace;font-size:12px;" onkeydown="if(event.key==='Enter'){addSerial();event.preventDefault();}">
							  <button class="add-btn" type="button" onclick="addSerial()" style="white-space:nowrap;font-size:12px;padding:7px 12px;"><i class="fa-solid fa-plus"></i>Add</button>
							</div>
							<div id="serial-count" style="font-size:11px;color:var(--text-muted);margin-top:4px;"></div>
						  </div>

						  <!-- Batch Selection -->
						  <div class="spec-row" id="batch-row">
							<span class="sr-tag sr-batch"><i class="fa-solid fa-layer-group"></i>Select Batch</span>
							<div id="batch-options"></div>
						  </div>

						  <!-- Expiry Date -->
						  <div class="spec-row" id="expiry-row">
							<span class="sr-tag sr-expiry"><i class="fa-solid fa-calendar-xmark"></i>Expiry / Best-Before</span>
							<div class="g g3 mt-2" id="expiry-info"></div>
						  </div>

						  <!-- Warranty -->
						  <div class="spec-row" id="warranty-row">
							<span class="sr-tag sr-warranty"><i class="fa-solid fa-shield-halved"></i>Warranty</span>
							<div class="g g3 mt-2">
							  <div>
								<label class="lbl">Default Warranty</label>
								<input type="text" class="fc" id="w-default" readonly style="background:#f7f9ff;">
							  </div>
							  <div>
								<label class="lbl">Override Period <span style="color:var(--text-muted)">(months)</span></label>
								<input type="number" class="fc" id="w-override" min="0" placeholder="e.g. 24" onchange="calcEntryLine()">
							  </div>
							  <div>
								<label class="lbl">Warranty Type</label>
								<select class="fc" id="w-type">
								  <option value="manufacturer">Manufacturer</option>
								  <option value="dealer">Dealer</option>
								  <option value="extended">Extended</option>
								</select>
							  </div>
							</div>
						  </div>

						  <!-- Free Issue -->
						  <div class="fi-row" id="fi-entry-row" style="display:none;">
							<div class="fi-label"><i class="fa-solid fa-gift"></i>Free Issue Qty</div>
							<input type="number" class="fi-input" id="e-freeissue" value="0" min="0" step="1" onchange="calcEntryLine()" placeholder="0">
							<div class="fi-note">Free qty is given at <strong>no charge</strong>. Not added to invoice value.</div>
						  </div>

						  <!-- Line Preview -->
						  <div id="line-prev" style="display:none;text-align:right;padding-top:8px;font-size:12px;color:var(--text-muted);">
							Billable: <strong id="line-prev-val" class="mono" style="color:var(--primary)">Rs. 0.00</strong>
							<span id="fi-prev-note" style="margin-left:10px;color:var(--accent);font-weight:700;display:none;">+ <span id="fi-prev-qty">0</span> FREE</span>
						  </div>

						</div><!-- /entry-extras -->

					  </div><!-- /entry-bar -->

					  <!-- ITEMS TABLE -->
					  <div class="tbl-wrap">
						<table class="tbl">
						  <thead>
							<tr>
							  <th style="width:32px">#</th>
							  <th>Item</th>
							  <th class="r">Unit Price</th>
							  <th class="c">Qty</th>
							  <th class="c">Free Qty</th>
							  <th class="c">Disc %</th>
							  <th class="r">Disc Amt</th>
							  <th class="r">Net Line</th>
							  <th class="c" style="width:44px"></th>
							</tr>
						  </thead>
						  <tbody id="items-tbody">
							<tr id="empty-row">
							  <td colspan="9">
								<div class="empty-cart">
								  <i class="fa-solid fa-cart-shopping"></i>
								  <p>No items added yet. Search and add products above.</p>
								</div>
							  </td>
							</tr>
						  </tbody>
						</table>
					  </div>

					</div>
				  </div>

				  <!-- Section 3: Remarks -->
				  <div class="card">
					<div class="card-head">
					  <div class="sec-icon"><i class="fa-solid fa-note-sticky"></i></div>
					  <h6>Remarks</h6>
					</div>
					<div class="card-body">
					  <div class="g g2">
						<div><label class="lbl">Internal Remarks</label><textarea class="fc" id="int-rem" name="remarks" rows="2" placeholder="Internal notes…"></textarea></div>
						<div><label class="lbl">Customer Note (printed)</label><textarea class="fc" id="cust-note" rows="2" placeholder="Message to customer…"></textarea></div>
					  </div>
					</div>
				  </div>

				</div><!-- /LEFT -->

				<!-- ─── RIGHT ─── -->
				<div style="position:sticky;top:78px;">

				  <!-- Summary -->
				  <div class="card">
					<div class="card-head">
					  <div class="sec-icon"><i class="fa-solid fa-calculator"></i></div>
					  <h6>Summary</h6>
					</div>
					<div class="card-body">
					  <div class="sum-box">
						<div class="sum-row"><span class="sl">Subtotal</span><span class="sv" id="sum-sub">Rs. 0.00</span></div>
						<input type="hidden" name="subtotal" class="sum-sub">
						<div class="sum-row"><span class="sl">Item Discounts</span><span class="sv" style="color:var(--success)" id="sum-disc">- Rs. 0.00</span></div>
						<div class="sum-row"><span class="sl">Free Issue Value</span><span class="sv" style="color:var(--accent)" id="sum-fi">Rs. 0.00</span></div>
						<div class="divider" style="margin:8px 0;"></div>
						<div style="margin-bottom:8px;">
						  <label class="lbl" style="font-size:10px;">Global Discount</label>
						  <div style="display:grid;grid-template-columns:1fr 70px;gap:5px;align-items:center;">
							<input type="number" class="fc" id="g-disc" value="0" min="0" max="100" placeholder="%" onchange="calcTotals()" style="font-size:12px;padding:6px 9px;">
							<span class="mono" id="g-disc-val" style="font-size:12px;color:var(--success);text-align:right;">- Rs. 0.00</span>
						  </div>
						</div>
						<div class="sum-row"><span class="sl">Tax (15% VAT)</span><span class="sv" id="sum-tax">Rs. 0.00</span></div>
						<input type="hidden" name="tax_total" class="sum-tax">
						<div class="divider" style="margin:8px 0;"></div>
						<div class="sum-row sum-total"><span class="sl">TOTAL</span><span class="sv" id="sum-total">Rs. 0.00</span></div>
						<input type="hidden" name="grand_total" class="sum-total">
					  </div>

					  <div style="display:flex;align-items:center;gap:10px;margin-top:9px;flex-wrap:wrap;">
						<label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:12px;font-weight:600;color:var(--text-mid);">
						  <input type="checkbox" id="tax-chk" onchange="calcTotals()" style="accent-color:var(--primary);">Apply VAT
						</label>
						<label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:12px;font-weight:600;color:var(--text-mid);">
						  <input type="checkbox" id="round-chk" onchange="calcTotals()" style="accent-color:var(--primary);">Round Off
						</label>
					  </div>

					  <button class="confirm-btn mt-3" type="button" id="confirm-btn" onclick="confirmInvoice()">
						<i class="fa-solid fa-check-circle"></i>Confirm Invoice<span class="kbd">Enter</span>
					  </button>
					</div>
				  </div>

				  <!-- Quick Stats -->
				  <div class="card">
					<div class="card-body" style="padding:13px;">
					  <span class="sec-lbl">Invoice Stats</span>
					  <div class="stats-grid">
						<div class="stat-box" style="background:var(--primary-light);">
						  <div class="sv" style="color:var(--primary);" id="stat-items">0</div>
						  <input type="hidden" name="total_items" class="stat-items">
						  <div class="sl">Items</div>
						</div>
						<div class="stat-box" style="background:var(--success-light);">
						  <div class="sv" style="color:var(--success);" id="stat-qty">0</div>
						  <input type="hidden" name="total_qty" class="stat-qty">
						  <div class="sl">Total Qty</div>
						</div>
						<div class="stat-box" style="background:var(--accent-light);">
						  <div class="sv" style="color:#92400e;font-size:14px;" id="stat-fi">0</div>
						  <input type="hidden" name="total_free_qty" class="stat-fi">
						  <div class="sl">Free Qty</div>
						</div>
						<div class="stat-box" style="background:var(--info-light);">
						  <div class="sv" style="color:#0369a1;font-size:14px;" id="stat-saved">0.00</div>
						  <input type="hidden" name="bill_discount_value" class="stat-saved">
						  <div class="sl">Saved</div>
						</div>
					  </div>
					</div>
				  </div>

				</div><!-- /RIGHT -->

			  </div>

			</main>

			<!-- ─── PAYMENT PANEL ─── -->
			<div id="pay-panel">
				<div class="pp-inner">
					<div class="pp-head">
						<div>
							<h5><i class="fa-solid fa-credit-card" style="margin-right:7px;"></i>Payment Collection</h5>
							<div class="pref" id="pay-ref">INV-2026-0087 · Rs. 0.00</div>
						</div>
						<button class="pp-close clear-payments" type="button" onclick="backToEdit()"><i class="fa-solid fa-xmark"></i></button>
					</div>
					<div class="pp-left">
						<span class="sec-lbl">Payment Type</span>
						<div class="pt-grid">
							<button class="pt-btn" type="button" onclick="addPayLine('cash',event)"><i class="fa-solid fa-money-bill-wave"></i><span>Cash</span></button>
							<button class="pt-btn" type="button" onclick="addPayLine('card',event)"><i class="fa-solid fa-credit-card"></i><span>Card</span></button>
							<button class="pt-btn" type="button" onclick="addPayLine('bank',event)"><i class="fa-solid fa-university"></i><span>Bank</span></button>
							<button class="pt-btn" type="button" onclick="addPayLine('cheque',event)"><i class="fa-solid fa-money-check-dollar"></i><span>Cheque</span></button>
							<button class="pt-btn" type="button" onclick="addPayLine('credit',event)"><i class="fa-solid fa-hand-holding-dollar"></i><span>Credit</span></button>
						</div>
						<span class="sec-lbl">Quick Actions</span>
						<div class="qa-grid mb-3">
							<button class="qa-btn qa-cash" type="button" onclick="payFullCash()"><i class="fa-solid fa-bolt"></i>Pay Full Cash</button>
							<button class="qa-btn qa-round" type="button" onclick="roundOff()"><i class="fa-solid fa-circle-half-stroke"></i>Round Off</button>
						</div>
						<div class="credit-warn" id="cr-warn"><i class="fa-solid fa-triangle-exclamation"></i> Credit limit exceeded for this customer.</div>
						<div class="cr-info" id="cr-info"></div>
						<span class="sec-lbl">Payment Lines</span>
						<div class="pay-lines" id="pay-lines"></div>
						<button class="add-pm-btn" type="button"onclick="addPayLine('cash')"><i class="fa-solid fa-plus"></i> Add Payment Method</button>
					</div>
					<div class="pp-right">
						<span class="sec-lbl">Balance</span>
							<div class="bal-box">
								<div class="bal-row"><span class="bl">Invoice Total</span><span class="bv" id="bal-total">Rs. 0.00</span></div>
								<div class="bal-row"><span class="bl">Amount Paid</span><span class="bv" id="bal-paid">Rs. 0.00</span></div>
								<input type="hidden" name="paid_amount" class="bal-paid">
								<div class="bal-div"></div>
								<div class="bal-row grand"><span class="bl" id="bal-lbl">Balance Remaining</span><span class="bv" id="bal-rem">Rs. 0.00</span></div>
								<input type="hidden" name="balance_amount" class="bal">
								<div class="bal-row change" id="change-row" style="display:none;"><span class="bl" style="opacity:.8;font-size:11px;">Change to Return</span><span class="bv" id="change-amt" style="font-size:16px;">Rs. 0.00</span></div>
							</div>
							<div class="chq-details" id="chq-details">
								<span class="sec-lbl" style="margin-top:10px;">Cheque Details</span>
								<div class="g" style="gap:7px;margin-top:4px;">
									<input type="text" class="fc" name="chq-no" id="chq-no" placeholder="Cheque Number">
									<input type="text" class="fc" name="chq-bank" id="chq-bank" placeholder="Bank Name">
									<input type="date" class="fc" name="chq-date" id="chq-date">
								</div>
							</div>
							<div class="card-details" id="card-details" style="display:none;">
								<span class="sec-lbl">Card Details</span>
								<div class="g" style="gap:7px;margin-top:4px;">
									<input type="text" class="fc" name="card-no" id="card-no" placeholder="Card Number">
									<input type="text" class="fc" name="card-type" id="card-type" placeholder="Card Type (Visa/Master)">
									<input type="text" class="fc" name="card-ref" id="card-ref" placeholder="Reference No">
								</div>
							</div>
							<div style="margin-top:11px;">
								<label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:12px;font-weight:600;color:var(--text-mid);">
									<input type="checkbox" id="auto-print" style="accent-color:var(--success);">Print invoice after completing
								</label>
							</div>
							<button class="complete-btn" type="submit" id="complete-btn" onclick="completeSale()"><i class="fa-solid fa-circle-check"></i>Complete Sale</button>
							<button class="back-btn clear-payments" type="button" onclick="backToEdit()"><i class="fa-solid fa-arrow-left"></i> Back to Edit</button>
							<button onclick="cancelSale()" class="clear-frm" type="button" style="width:100%;padding:8px;background:none;border:none;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--danger);margin-top:5px;display:flex;align-items:center;justify-content:center;gap:5px;">
							<i class="fa-solid fa-ban"></i>Cancel Invoice
						</button>
					</div>
				</div>
			</div>

			<!-- ─── SUCCESS OVERLAY ─── -->
			<div class="suc-ov" id="suc-ov">
				<div class="suc-card">
					<div class="suc-icon"><i class="fa-solid fa-check"></i></div>
					<h3>Sale Completed!</h3>
					<p>Invoice has been saved and payment recorded.</p>
					<div class="suc-meta">
						<div class="suc-meta-row"><span style="color:var(--text-muted)">Invoice</span><span class="mono fw-700" id="suc-inv"></span></div>
						<div class="suc-meta-row"><span style="color:var(--text-muted)">Total</span><span class="mono fw-700" id="suc-total"></span></div>
						<div class="suc-meta-row" id="suc-cr" style="display:none;"><span style="color:var(--success);font-weight:600;">Change</span><span class="mono fw-700" style="color:var(--success)" id="suc-change"></span></div>
					</div>
					<div class="suc-actions">
						<button class="btn-print" data-id="" type="button" onclick="printInvoice()"><i class="fa-solid fa-print"></i>Print</button>
						<button class="btn-new" type="button" onclick="newSale()"><i class="fa-solid fa-plus"></i>New Sale</button>
					</div>
				</div>
			</div>

			<div id="toast-c"></div>
		</form>
	

<!-- ─── JAVASCRIPT ─── -->
<script>
	let lastInvoiceId = null;
	
	var CUSTOMERS = {};
	$.ajax({
		url: "/Sale/get_customers_ajax",
		type: "GET",
		dataType: "json",
		success: function(response) {
			CUSTOMERS = response;
			console.log("Customers Loaded:", CUSTOMERS);
			
		},
		error: function(xhr, status, error) {
			console.error("Error loading customers:", error);
		}
	});

	var PRODUCTS = [];

	$.ajax({
		url: "/Sale/get_products_ajax",
		type: "GET",
		dataType: "json",
		success: function(res) {
			PRODUCTS = res;

			console.log(PRODUCTS);

			// Example
			//console.log(PRODUCTS[0].name);
		},
		error: function(err) {
			console.error("Error loading products:", err);
		}
	});

	// ═══════════════════════════════════════════════════════════
	// STATE
	// ═══════════════════════════════════════════════════════════
	var items = [];          // invoice line items
	var confirmed = false;
	var curCustomer = null;
	var selProduct = null;
	var serialsForEntry = [];
	var selBatch = null;
	var payLines = [];
	var plId = 0;

	// ═══════════════════════════════════════════════════════════
	// INIT
	// ═══════════════════════════════════════════════════════════
	$(function(){
		var today = new Date();
		var fmt = function(d){ return d.toISOString().split('T')[0]; };
		$('#inv-date').val(fmt(today));
		var due = new Date(today); due.setDate(due.getDate()+30);
		$('#inv-due').val(fmt(due));

		$(document).on('keydown', function(e){
			if (e.key==='Enter' && !$('#pay-panel').hasClass('open')){
				if ($(e.target).is('#item-search,#e-qty,#e-price,#e-disc,#e-freeissue')) { e.preventDefault(); addItem(); return; }
				if (items.length > 0 && !confirmed) { e.preventDefault(); confirmInvoice(); }
			}
			if (e.key==='Escape'){
				$('#item-dd').hide();
				if ($('#pay-panel').hasClass('open')) 
				backToEdit();
			}
		});
	
		$(document).on('click', function(e){ if (!$(e.target).closest('.search-wrap').length) $('#item-dd').hide(); });
		calcTotals();
	});

	// ═══════════════════════════════════════════════════════════
	// CUSTOMER
	// ═══════════════════════════════════════════════════════════
	function onCustChange(){
		var id = $('#cust-sel').val();
		if (!id){ $('#cust-bar').hide(); curCustomer=null; return; }
			curCustomer = CUSTOMERS[id];
		var c = curCustomer;
		var used = c.creditUsed||0, avail = c.creditLimit - used;
		var pct = c.creditLimit>0 ? Math.min((used/c.creditLimit)*100,100) : 0;
		var barCls = pct>90?'bad':pct>70?'warn':'';
		var html = `<div class="ci-item"><div class="lbl2">Name</div><div class="val">${c.name}</div></div>
					<div class="ci-item"><div class="lbl2">Phone</div><div class="val">${c.phone}</div></div>
					<div class="ci-item"><div class="lbl2">Email</div><div class="val" style="font-size:11px">${c.email}</div></div>
					${c.creditEnabled?`
					<div class="ci-item"><div class="lbl2">Credit Limit</div><div class="val">Rs. ${fmt2(c.creditLimit)}</div></div>
					<div class="ci-item"><div class="lbl2">Available</div><div class="val text-success">Rs. ${fmt2(avail)}</div></div>
					<div class="ci-item gc-full" style="grid-column:span 3"><div class="lbl2">Credit Used ${pct.toFixed(0)}%</div>
					<div class="cr-bar-w"><div class="cr-bar-f ${barCls}" style="width:${pct}%"></div></div></div>`
					:'<div class="ci-item"><div class="lbl2">Credit</div><div class="val text-muted">Not enabled</div></div>'}`;
		$('#cust-grid').html(html);
		$('#cust-bar').fadeIn(200);
	}

	// ═══════════════════════════════════════════════════════════
	// PRICE LIST
	// ═══════════════════════════════════════════════════════════
	
	function getPriceForProduct(p){

		if (!p) return 0;

		var pl = $('#price-list').val();

		if (pl === 'wholesale' && p.wholesalePrice != null && p.wholesalePrice !== '') {
			return parseFloat(p.wholesalePrice);
		}

		if (pl === 'special' && p.specialPrice != null && p.specialPrice !== '') {
			return parseFloat(p.specialPrice);
		}

		return parseFloat(p.price || 0);
	}
	
	function applyPriceList(){
		if (selProduct){ $('#e-price').val(getPriceForProduct(selProduct).toFixed(2)); calcEntryLine(); }
	}

	// ═══════════════════════════════════════════════════════════
	// ITEM SEARCH
	// ═══════════════════════════════════════════════════════════
	var searchTimer;
	function searchItems(val){
		clearTimeout(searchTimer);
		if (val.length<1){ 
			$('#item-dd').hide(); 
			clearProdPanel(); 
			return; 
		}
		searchTimer = setTimeout(function(){
			// AJAX: $.get('/api/items/search?q='+val, function(res){ renderDD(res); });
			var res = PRODUCTS.filter(function(p){
				return p.name.toLowerCase().includes(val.toLowerCase()) || p.code.toLowerCase().includes(val.toLowerCase());
			});
			renderDD(res);
		},140);
	}


	<?php if (!empty($_GET['id'])): ?>
		var invoiceId = "<?= htmlspecialchars($_GET['id'], ENT_QUOTES) ?>";

		$.getJSON("/Sale/get_invoice_ajax?id=" + invoiceId, function(res) {

			console.log(res);

			$('#invid').val(res.invoice.id);
			$('#cust-sel').val(res.invoice.customer_id);
			$('#sales-person').val(res.invoice.created_by);
			$('#warehouse').val(res.invoice.warehouse_id);
			$('#item-dd').hide();
			$('#drft-btn').prop('disabled', true);

			// ✅ set global items (IMPORTANT)
			items = mapToInvoiceItems(res.items);

			// ✅ render table like Add Item
			renderTable();
			calcTotals();

			// ✅ OPTIONAL dropdown (keep if needed)
			let products = mapToRenderFormat(res.items);
			renderDD(products);

		});
	<?php endif; ?>

	function mapToRenderFormat(items) {
		return items.map(function(i){
			return {
				id: i.product_id,
				code: i.product_code || '',
				name: i.product_name || i.name,
				icon: '📦',
				category: 'General',
				description: i.description || '',
				stock: 0,
				isSerial: i.is_serial_trk == 1,
				isBatch: i.is_batch == 1,
				hasExpiry: i.is_expiry_trk == 1,
				hasWarranty: i.is_warranty_item == 1,
				retailPrice: parseFloat(i.retailPrice || 0),
				wholesalePrice: parseFloat(i.wholesalePrice || 0),
				specialPrice: parseFloat(i.specialPrice || 0),
				unit: i.unit,
				price: parseFloat(i.unit_price),
				qty: parseFloat(i.qty),
				batchNo: i.batch_no || null
			};
		});
	}
	
	function mapToInvoiceItems(dbItems) {

		return dbItems.map(function(i){

			return {
				productId: i.product_id,
				code: i.product_code || '',
				name: i.product_name,
				icon: '📦',
				unit: i.unit,
				price: parseFloat(i.unit_price),
				qty: parseFloat(i.qty),
				disc: parseFloat(i.discount_value || 0),
				freeIssue: parseFloat(i.free_qty || 0),
				// flags
				isSerial: i.is_serial_trk == 1,
				isBatch: i.is_batch == 1,
				hasExpiry: i.is_expiry_trk == 1,
				expDate: i.expiry_date || null,
				hasWarranty: i.is_warranty_item == 1,
				warrantyMonths: i.warranty_period || 0,
				warrantyType: i.warrantyType || 'manufacturer',
				// batch
				batchId: i.batch_id || null,
				batchNo: i.batch_no || null,
				serials: []
			};
		});
	}

	function renderDD(prods){
		if (!prods.length){
			$('#item-dd').html('<div style="padding:12px;text-align:center;color:var(--text-muted);font-size:12px;">No items found</div>').show(); return;
		}
		var html = prods.map(function(p){
		var sc = p.stock>10?'stk-ok':p.stock>0?'stk-low':'stk-out';
		var sl = p.stock>0?p.stock+' in stock':'Out of stock';
		var badges = [
			p.isSerial?'<span class="fb-serial feat-badge"><i class="fa-solid fa-barcode"></i>Serial</span>':'',
			p.isBatch?'<span class="fb-batch feat-badge"><i class="fa-solid fa-layer-group"></i>Batch</span>':'',
			p.hasExpiry?'<span class="fb-expiry feat-badge"><i class="fa-solid fa-calendar-xmark"></i>Expiry</span>':'',
			p.hasWarranty?'<span class="fb-warranty feat-badge"><i class="fa-solid fa-shield-halved"></i>Warranty</span>':'',
		].join('');
		return `<div class="i-opt" onclick="selectProd('${p.id}')">
					<span class="i-code">${p.code}</span>
					<div style="flex:1;min-width:0;">
						<div class="i-name">${p.icon} ${p.name}</div>
						<div class="i-sub">${p.category} · ${p.description||''} · <span class="stk ${sc}">${sl}</span></div>
						<div style="display:flex;gap:3px;margin-top:3px;">${badges}</div>
					</div>
					<span class="i-price">Rs. ${fmt2(getPriceForProduct(p))}</span>
				</div>`;
		}).join('');
		$('#item-dd').html(html).show();
	}

	function handleItemKD(e){
		var dd=$('#item-dd'); if (!dd.is(':visible')) return;
		var opts=dd.find('.i-opt'), act=dd.find('.i-opt.hover');
		if (e.key==='ArrowDown'){e.preventDefault();var n=act.length?act.next('.i-opt'):opts.first();opts.removeClass('hover');n.addClass('hover');}
		else if(e.key==='ArrowUp'){e.preventDefault();var pv=act.length?act.prev('.i-opt'):opts.last();opts.removeClass('hover');pv.addClass('hover');}
		else if(e.key==='Enter'){if(act.length){e.preventDefault();act.click();}}
	}

	// ═══════════════════════════════════════════════════════════
	// SELECT PRODUCT → INFO PANEL + EXTRAS
	// ═══════════════════════════════════════════════════════════
	function selectProd(id){
		var p = PRODUCTS.find(function(x){return x.id===id;});
		if (!p) return;
		selProduct = p;
		serialsForEntry = [];
		selBatch = null;
		$('#item-search').val(p.name);
		$('#e-price').val(getPriceForProduct(p).toFixed(2));
		$('#e-qty').val(1);
		$('#e-disc').val(0);
		$('#e-freeissue').val(0);
		$('#item-dd').hide();
		showProdInfoPanel(p);
		showEntryExtras(p);
		calcEntryLine();
		setTimeout(function(){ $('#e-qty').focus().select(); },80);
	}

	function clearProdPanel(){
		selProduct = null; serialsForEntry = []; selBatch = null;
		$('#prod-info-panel').hide();
		$('#entry-extras').hide();
	}

	function showProdInfoPanel(p){
		var pl = $('#price-list').val();
		var price = getPriceForProduct(p);
		var stockCls = p.stock>10?'green':p.stock>0?'orange':'red';
		var pipHTML = `<div class="pip-item"><div class="pil">Code</div><div class="piv mono">${p.code}</div></div>
						<div class="pip-item"><div class="pil">Category</div><div class="piv">${p.category}</div></div>
						<div class="pip-item"><div class="pil">Unit</div><div class="piv">${p.unit}</div></div>
						<div class="pip-item"><div class="pil">Stock</div><div class="piv ${stockCls}">${p.stock} ${p.unit}</div></div>
						<div class="pip-item"><div class="pil">Retail Price</div><div class="piv mono">Rs. ${fmt2(p.price)}</div></div>
						<div class="pip-item"><div class="pil">Wholesale</div><div class="piv mono">Rs. ${fmt2(p.wholesalePrice)}</div></div>
		${p.hasWarranty?`<div class="pip-item"><div class="pil">Warranty</div><div class="piv">${p.warrantyMonths} months (${p.warrantyType})</div></div>`:''}
		${p.isBatch&&p.batches?`<div class="pip-item"><div class="pil">Batches</div><div class="piv">${p.batches.length} batches available</div></div>`:''}`;
		var badges = [
			p.isSerial?'<span class="feat-badge fb-serial"><i class="fa-solid fa-barcode"></i>Serial Item</span>':'',
			p.isBatch?'<span class="feat-badge fb-batch"><i class="fa-solid fa-layer-group"></i>Batch Tracked</span>':'',
			p.hasExpiry?'<span class="feat-badge fb-expiry"><i class="fa-solid fa-calendar-xmark"></i>Has Expiry</span>':'',
			p.hasWarranty?'<span class="feat-badge fb-warranty"><i class="fa-solid fa-shield-halved"></i>Warranty</span>':'',
			'<span class="feat-badge fb-free"><i class="fa-solid fa-gift"></i>Free Issue</span>'
		].join('');
		$('#pip-icon').text(p.icon);
		$('#pip-right').html(pipHTML);
		$('#pip-badges').html(badges);
		$('#prod-info-panel').slideDown(200);
	}

	function showEntryExtras(p){
		$('#entry-extras').show();

		// Batch
		if (p.isBatch && p.batches && p.batches.length){
			var html = p.batches.map(function(b){
				var daysLeft = Math.ceil((new Date(b.expDate)-new Date())/86400000);
				var expCls = daysLeft<90?'text-danger':daysLeft<180?'text-warning':'text-success';
				var expTxt = p.hasExpiry?`Exp: ${b.expDate} <span class="${expCls}">(${daysLeft}d)</span>`:'No expiry';
				return `<div class="batch-option" onclick="selectBatch('${b.id}',this)" data-bid="${b.id}">
							<div><div class="bn">${b.batchNo}</div><div class="bmeta">Mfg: ${b.mfgDate} · ${expTxt}</div></div>
							<div class="bstock">${b.stock} ${p.unit}</div>
						</div>`;
			}).join('');
			
			$('#batch-options').html(html);
			$('#batch-row').addClass('show');
		} else { $('#batch-row').removeClass('show'); selBatch=null; }

		// Expiry (non-batch items that have expiry — show a field to enter)
		if (p.hasExpiry && !p.isBatch){
			$('#expiry-info').html(`<div><label class="lbl">Expiry Date</label><input type="date" class="fc" id="e-expiry"></div>
									<div><label class="lbl">Mfg Date</label><input type="date" class="fc" id="e-mfgdate"></div>`);
			$('#expiry-row').addClass('show');
		} else { $('#expiry-row').removeClass('show'); }

		// Warranty
		if (p.hasWarranty){
			$('#w-default').val(p.warrantyMonths+' months ('+p.warrantyType+')');
			$('#w-override').val(p.warrantyMonths);
			$('#w-type').val(p.warrantyType);
			$('#warranty-row').addClass('show');
		} else { $('#warranty-row').removeClass('show'); }

		// Free Issue always shown
		$('#fi-entry-row').show();
	}

	// Serial number handling
	function renderSerialChips(){
		var chips = serialsForEntry.map(function(s,i){
			return `<span class="s-chip">${s}<button onclick="removeSerial(${i})"><i class="fa-solid fa-xmark"></i></button></span>`;
		}).join('');
		$('#serial-chips').html(chips||'<span style="font-size:11px;color:var(--text-muted);padding:3px 6px;">No serials entered yet</span>');
			var needed = parseInt($('#e-qty').val())||0;
			var have = serialsForEntry.length;
			var cls = have===needed?'color:var(--success)':have>needed?'color:var(--danger)':'color:var(--text-muted)';
			$('#serial-count').html(`<span style="${cls};font-weight:700;">${have} of ${needed} serials entered</span>`);
	}

	function addSerial(){
		var val = $('#serial-input').val().trim();
		if (!val) return;
		if (serialsForEntry.includes(val)){ toast('Serial already added','warning'); return; }
		// Check if valid serial for product
		if (selProduct && selProduct.serials && !selProduct.serials.includes(val)){
			toast('Serial not found in stock: '+val,'warning'); return;
		}
		serialsForEntry.push(val);
		$('#serial-input').val('');
		renderSerialChips();
	}

	function removeSerial(i){ serialsForEntry.splice(i,1); renderSerialChips(); }

	// Batch selection
	function selectBatch(bid, el){
		selBatch = bid;
		$('.batch-option').removeClass('sel');
		$(el).addClass('sel');
		// If expiry: populate the expiry info from batch
		if (selProduct && selProduct.hasExpiry){
			var b = selProduct.batches.find(function(x){return x.id===bid;});
			if (b){
				var dLeft = Math.ceil((new Date(b.expDate)-new Date())/86400000);
				var eCls = dLeft<90?'text-danger':dLeft<180?'text-warning':'text-success';
				$('#expiry-row').addClass('show');
				$('#expiry-info').html(`<div class="pip-item"><div class="pil">Batch No.</div><div class="piv mono">${b.batchNo}</div></div>
									<div class="pip-item"><div class="pil">Mfg. Date</div><div class="piv">${b.mfgDate}</div></div>
									<div class="pip-item"><div class="pil">Expiry Date</div><div class="piv ${eCls}">${b.expDate} (${dLeft} days)</div></div>`);
			}
		}
	}

	// ═══════════════════════════════════════════════════════════
	// ENTRY LINE CALC
	// ═══════════════════════════════════════════════════════════
	function calcEntryLine(){
		var price = parseFloat($('#e-price').val())||0;
		var qty = parseFloat($('#e-qty').val())||0;
		var disc = parseFloat($('#e-disc').val())||0;
		var fi = parseInt($('#e-freeissue').val())||0;
		if (selProduct && selProduct.isSerial) renderSerialChips();
			var discAmt = price*qty*(disc/100);
			var total = price*qty - discAmt;
		if (price>0 && qty>0){
			$('#line-prev-val').text('Rs. '+fmt2(total));
			$('#line-prev').show();
			if (fi>0){ $('#fi-prev-qty').text(fi); $('#fi-prev-note').show(); }
			else { $('#fi-prev-note').hide(); }
		} else { $('#line-prev').hide(); }
	}

	// ═══════════════════════════════════════════════════════════
	// ADD ITEM TO INVOICE
	// ═══════════════════════════════════════════════════════════
	function addItem(){
		if (!selProduct){ 
			toast('Search and select a product first','warning'); 
			return; 
		}
		
		var qty = parseFloat($('#e-qty').val())||0;
		var price = parseFloat($('#e-price').val())||0;
		var disc = parseFloat($('#e-disc').val())||0;
		var fi = parseInt($('#e-freeissue').val())||0;

		if (qty<=0){ toast('Quantity must be > 0','warning'); $('#e-qty').focus(); return; }
		if (price<=0){ toast('Unit price must be > 0','warning'); $('#e-price').focus(); return; }
		if (selProduct.stock<=0){ toast('Out of stock','danger'); return; }
		if (qty>selProduct.stock){ toast('Insufficient stock. Available: '+selProduct.stock,'warning'); return; }

		// Serial validation
		if (selProduct.isSerial){
			if (serialsForEntry.length !== qty){
				toast('Please enter '+qty+' serial number(s). You have '+serialsForEntry.length,'warning'); return;
			}
		}

		// Batch validation
		if (selProduct.isBatch && selProduct.batches && selProduct.batches.length && !selBatch){
			toast('Please select a batch','warning'); return;
		}

		var batchInfo = null;
		if (selBatch && selProduct.batches){
			batchInfo = selProduct.batches.find(function(b){return b.id===selBatch;});
		}
		
		var warrantyMonths = parseInt($('#w-override').val())||selProduct.warrantyMonths||0;
		var warrantyType = $('#w-type').val()||selProduct.warrantyType||'manufacturer';

		// Check for existing same product same batch
		var existing = items.find(function(i){
			return i.productId===selProduct.id && (!selBatch || i.batchId===selBatch);
		});
		if (existing && !selProduct.isSerial){
			existing.qty += qty;
			existing.freeIssue = (existing.freeIssue||0) + fi;
			existing.disc = disc;
			toast(selProduct.name+' updated','info');
		}else {
			items.push({
				productId:selProduct.id, code:selProduct.code, name:selProduct.name, icon:selProduct.icon,
				unit:selProduct.unit, price:price, qty:qty, disc:disc, freeIssue:fi,
				isSerial:selProduct.isSerial, serials:[...serialsForEntry],
				isBatch:selProduct.isBatch, batchId:selBatch, batchNo:batchInfo?batchInfo.batchNo:null,
				hasExpiry:selProduct.hasExpiry, expDate:batchInfo?batchInfo.expDate:null,
				hasWarranty:selProduct.hasWarranty, warrantyMonths:warrantyMonths, warrantyType:warrantyType
			});
			toast(selProduct.name+' added','success');
		}

		renderTable();
		calcTotals();
		resetEntry();
	}

	function resetEntry(){
		selProduct=null; serialsForEntry=[]; 
		selBatch=null;
		$('#item-search').val('').focus();
		$('#e-qty').val(1); 
		$('#e-price').val(0); 
		$('#e-disc').val(0); 
		$('#e-freeissue').val(0);
		$('#prod-info-panel').slideUp(150);
		$('#entry-extras').slideUp(150);
		$('#line-prev').hide();
		$('#ser-row,#batch-row,#expiry-row,#warranty-row').removeClass('show');
		$('#fi-entry-row').hide();
	}

	// ═══════════════════════════════════════════════════════════
	// RENDER TABLE
	// ═══════════════════════════════════════════════════════════
	function renderTable(){
		var tbody = $('#items-tbody');

		if (!items.length){
			tbody.html('<tr id="empty-row"><td colspan="9"><div class="empty-cart"><i class="fa-solid fa-cart-shopping"></i><p>No items added.</p></div></td></tr>');
			$('#cnt-badge').text('0 items');
			$('#fi-count-badge').hide();
			return;
		}

		var hasFI = items.some(function(i){return i.freeIssue>0;});
			$('#fi-count-badge').toggle(hasFI);
			$('#cnt-badge').text(items.length+' item'+(items.length!==1?'s':''));

		var html = items.map(function(item,idx){

		var discAmt = item.price * item.qty * (item.disc/100);
		var lineTotal = item.price * item.qty - discAmt;

		var expiryStr='',batchStr='',serialStr='',warrantyStr='';

		if (item.isBatch && item.batchNo)
			batchStr=`<span class="warn-chip wc-batch"><i class="fa-solid fa-layer-group"></i>${item.batchNo}</span>`;

		if (item.hasExpiry && item.expDate){
			var dl=Math.ceil((new Date(item.expDate)-new Date())/86400000);
			var ec=dl<90?'background:var(--danger-light);color:#991b1b;':dl<180?'background:var(--warning-light);color:#92400e;':'background:var(--orange-light);color:#c2410c;';
			expiryStr=`<span class="warn-chip wc-expiry" style="${ec}"><i class="fa-solid fa-calendar-xmark"></i>Exp ${item.expDate}</span>`;
		}

		if (item.isSerial && item.serials && item.serials.length)
			serialStr=`<span class="warn-chip wc-serial"><i class="fa-solid fa-barcode"></i>${item.serials.length} S/N</span>`;

		if (item.hasWarranty && item.warrantyMonths)
			warrantyStr=`<span class="warn-chip wc-warranty"><i class="fa-solid fa-shield-halved"></i>${item.warrantyMonths}mo</span>`;

		var fiStr = item.freeIssue>0
		  ? `<span class="warn-chip wc-fi"><i class="fa-solid fa-gift"></i>+${item.freeIssue} FREE</span>`
		  : '';

		return `<tr>
					<td style="color:var(--text-muted);font-size:11px;font-weight:700;">${idx+1}</td>

					<td>
						<div class="tbl-name">${item.icon||''} ${item.name}</div>

						<!-- ✅ FIXED DATA (hidden inputs) -->
						<input type="hidden" name="product_id[]" value="${item.productId}">
						<input type="hidden" name="product_name[]" value="${item.name}">
						<input type="hidden" name="unit[]" value="${item.unit}">
						<input type="hidden" name="unit_price[]" value="${item.price}">
						<input type="hidden" name="discount_value[]" value="${item.disc}">
						<input type="hidden" name="line_total[]" value="${lineTotal}">
						<div class="tbl-sub">${item.code} · ${item.unit}${item.batchNo?(' · Batch: '+item.batchNo):''}</div>
						<div class="tbl-tags mt-1">${serialStr}${batchStr}${expiryStr}${warrantyStr}${fiStr}</div>
					</td>

					<td class="r mono">Rs. ${fmt2(item.price)}</td>

					<td class="c">
						<input type="number" class="ti-input" name="qty[]" value="${item.qty}" min="0.01" step="0.01" onchange="updQty(${idx},this.value)" ${confirmed?'disabled':''}>
					</td>

					<td class="c">
						<input type="number" class="fi-tbl-input" name="free_qty[]"  value="${item.freeIssue||0}" min="0" step="1" onchange="updFI(${idx},this.value)" ${confirmed?'disabled':''} title="Free Issue Qty">
					</td>

					<td class="c">
						<input type="number" class="ti-input"  value="${item.disc}" min="0" max="100" onchange="updDisc(${idx},this.value)" ${confirmed?'disabled':''} style="width:55px;">
					</td>

					<td class="r" style="color:var(--success)">
						<span class="mono">Rs. ${fmt2(discAmt)}</span>
					</td>

					<td class="r">
						<strong class="mono">Rs. ${fmt2(lineTotal)}</strong>
					</td>

					<td class="c">
						${!confirmed?`<button class="del-btn" onclick="removeItem(${idx})"><i class="fa-solid fa-xmark"></i></button>`:''}
					</td>
				</tr>`;

			}).join('');

		tbody.html(html);
	}

	function updQty(i,v){ var q=parseFloat(v)||0; if(q<=0){toast('Qty must be > 0','warning');return;} items[i].qty=q; renderTable(); calcTotals(); }
	function updDisc(i,v){ items[i].disc=Math.min(100,Math.max(0,parseFloat(v)||0)); renderTable(); calcTotals(); }
	function updFI(i,v){ items[i].freeIssue=Math.max(0,parseInt(v)||0); renderTable(); calcTotals(); }
	function removeItem(i){ var n=items[i].name; items.splice(i,1); renderTable(); calcTotals(); toast(n+' removed','info'); }

	// ═══════════════════════════════════════════════════════════
	// CALCULATE TOTALS
	// ═══════════════════════════════════════════════════════════
	function calcTotals(){
		var sub=0, iDisc=0, fiVal=0;
			items.forEach(function(item){
				var line = item.price*item.qty;
				var disc = line*(item.disc/100);
				sub += line; iDisc += disc;
				// Free issue value (for display only — not charged)
				fiVal += item.price*(item.freeIssue||0);
			});
		var afterItemDisc = sub - iDisc;
		var gDiscPct = parseFloat($('#g-disc').val())||0;
		var gDiscAmt = afterItemDisc*(gDiscPct/100);
		var afterG = afterItemDisc - gDiscAmt;
		var taxEnabled = $('#tax-chk').is(':checked');
		var tax = taxEnabled ? afterG*0.15 : 0;
		var total = afterG + tax;
		
		if ($('#round-chk').is(':checked')) total = Math.round(total);

			$('#sum-sub').text('Rs. '+fmt2(sub));
			$('.sum-sub').val(fmt2(sub));
			$('#sum-disc').text('- Rs. '+fmt2(iDisc));
			$('#sum-fi').text('Rs. '+fmt2(fiVal)+' given free');
			$('#g-disc-val').text('- Rs. '+fmt2(gDiscAmt));
			$('#sum-tax').text('Rs. '+fmt2(tax));
			$('.sum-tax').val(fmt2(tax));
			$('#sum-total').text('Rs. '+fmt2(total));
			$('.sum-total').val(fmt2(total));

			var totalQty = items.reduce(function(a,b){return a+b.qty;},0);
			var totalFI = items.reduce(function(a,b){return a+(b.freeIssue||0);},0);
			var saved = iDisc + gDiscAmt;
				$('#stat-items').text(items.length);
				$('.stat-items').val(items.length);
				$('#stat-qty').text(fmt2(totalQty));
				$('.stat-qty').val(fmt2(totalQty));
				$('#stat-fi').text(totalFI+' units');
				$('.stat-fi').val(totalFI);
				$('#stat-saved').text(fmt2(saved));
				$('.stat-saved').val(fmt2(saved));

				$('#bal-total').text('Rs. '+fmt2(total));
				$('#pay-ref').text($('#inv-number').text()+' · Rs. '+fmt2(total));
				window._invTotal = total;
			updateBalance();
	}
	
	// ═══════════════════════════════════════════════════════════
	// CONFIRM INVOICE
	// ═══════════════════════════════════════════════════════════
	function confirmInvoice(){
		if (!items.length){ toast('Add at least one item','warning'); return; }
		if (!$('#cust-sel').val()){ toast('Please select a customer','warning'); return; }

		// Serial completeness check
		/*var serialErr = false;
		items.forEach(function(item){
			if (item.isSerial && item.serials.length !== item.qty){
				toast('Serial numbers missing for: '+item.name,'danger'); 
				serialErr=true;
			}
		});*/
	
		if (!window.location.search.includes('id=')) {
			var serialErr = false;
			items.forEach(function(item){
				if (item.isSerial && item.serials.length !== item.qty){
					toast('Serial numbers missing for: ' + item.name,'danger'); 
					serialErr = true;
				}
			});
			if (serialErr) return;
		} 
		
		$('#pay-panel').show();
		confirmed = true;
		$('#items-locked').css('display','flex');
		$('#confirm-btn').prop('disabled',true).html('<i class="fa-solid fa-lock"></i> Invoice Locked');
		$('#inv-status').removeClass().addClass('status-pill st-pending').html('<i class="fa-solid fa-circle" style="font-size:7px"></i> Pending Payment');
		$('#wf1').removeClass('active').addClass('done').html('<i class="fa-solid fa-check"></i> Items');
		$('#wf2').addClass('done').html('<i class="fa-solid fa-check"></i> Confirm');
		$('#wf3').addClass('active').html('<i class="fa-solid fa-bolt"></i> Payment');

		openPayPanel();
		toast('Invoice confirmed — enter payment','info');
	}

	// ═══════════════════════════════════════════════════════════
	// PAYMENT PANEL
	// ═══════════════════════════════════════════════════════════
	function openPayPanel(){
		payLines=[]; plId=0;
		renderPayLines(); updateBalance();
		if (curCustomer && curCustomer.creditEnabled){
			var avail = curCustomer.creditLimit - curCustomer.creditUsed;
			$('#cr-info').show().html(`<div class="cir"><span class="cil">Credit Limit</span><span class="civ">Rs. ${fmt2(curCustomer.creditLimit)}</span></div>
									   <div class="cir"><span class="cil">Available</span><span class="civ">Rs. ${fmt2(avail)}</span></div>
									   <div class="cir"><span class="cil">Outstanding</span><span class="civ">Rs. ${fmt2(curCustomer.outstanding)}</span></div>`);
		} else { $('#cr-info').hide(); }
		$('#pay-panel').addClass('open');
		setTimeout(function(){ addPayLine('cash'); },250);
	}

	function backToEdit(){
		confirmed=false;
		$('#items-locked').css('display','none');
		$('#confirm-btn').prop('disabled',false).html('<i class="fa-solid fa-check-circle"></i> Confirm Invoice <span class="kbd">Enter</span>');
		$('#inv-status').removeClass().addClass('status-pill st-draft').html('<i class="fa-solid fa-circle" style="font-size:7px"></i> Draft');
		$('#wf1').removeClass('done active').addClass('active').html('<i class="fa-solid fa-pencil"></i> Items');
		$('#wf2').removeClass('done active').text('Confirm');
		$('#wf3').removeClass('done active').text('Payment');
		renderTable();
		$('#pay-panel').removeClass('open');
		payLines=[];
	}
	
	function renderPayLines(){
		var html = payLines.map(function(l){
			return `<div class="pay-line" id="pl-${l.id}">
						<select class="pm-sel" name="payment_method[]" onchange="chgMethod(${l.id},this.value)">
							<option value="cash" ${l.method==='cash'?'selected':''}>💵 Cash</option>
							<option value="card" ${l.method==='card'?'selected':''}>💳 Card</option>
							<option value="bank" ${l.method==='bank'?'selected':''}>🏦 Bank</option>
							<option value="cheque" ${l.method==='cheque'?'selected':''}>📝 Cheque</option>
							<option value="credit" ${l.method==='credit'?'selected':''}>🤝 Credit</option>
						</select>
						<input type="number" class="pa-inp" name="amount[]" id="pa-${l.id}" value="${l.amount.toFixed(2)}" step="0.01" onchange="updPay(${l.id},this.value)" onkeyup="updPay(${l.id},this.value)">
						<button class="rm-line" onclick="rmPayLine(${l.id})"><i class="fa-solid fa-xmark"></i></button>
					</div>`;
		}).join('');
		$('#pay-lines').html(html||'<div style="text-align:center;padding:16px;color:var(--text-muted);font-size:12px;"><i class="fa-solid fa-plus-circle" style="display:block;font-size:22px;margin-bottom:5px;opacity:.3;"></i>Select a payment type above</div>');
	}
	
	// ─── PAYMENT LINES ───
	function addPayLine(method, e){
		if (e){ var b=$(e.currentTarget); b.addClass('sel'); setTimeout(function(){b.removeClass('sel');},400); }
		plId++;
		var rem = getRemaining();
		payLines.push({id:plId, method:method, amount:rem>0?rem:0});
		renderPayLines();
		updateBalance();
		chgMethod(plId, method);
		setTimeout(function(){ $('#pa-'+plId).focus().select(); },80);
	}
	
	function chgMethod(id, m){
		var l = payLines.find(x => x.id === id);
		if (l) l.method = m;

		var hasCheque = payLines.some(x => x.method === 'cheque');
		var hasCard   = payLines.some(x => x.method === 'card');

		// Toggle cheque block
		$('#chq-details').toggle(hasCheque);

		if (hasCheque) {
			checkChequeVisibility();
			$('#chq-no, #chq-bank, #chq-date').attr('required', true);
		} else {
			$('#chq-no, #chq-bank, #chq-date')
				.removeAttr('required')
				.val('');
		}

		// 🔥 Toggle card block
		$('#card-details').toggle(hasCard);

		if (hasCard) {
			cardVisibility();
			$('#card-no, #card-type, #card-ref').attr('required', true);
		} else {
			$('#card-no, #card-type, #card-ref')
				.removeAttr('required')
				.val('');
		}

		validateCredit();
		
	}
	
	function checkChequeVisibility(){
		var hasCheque = payLines.some(x => x.method === 'cheque');
		$('#chq-details').toggle(hasCheque);
		$('#chq-no, #chq-bank, #chq-date').attr('required', true);
	}
	
	function cardVisibility(){
		var hasCard = payLines.some(x => x.method === 'card');
		$('#card-details').toggle(hasCard);
		$('#card-no, #card-type, #card-ref').attr('required', true);
	}
	
	function updPay(id,v){ var l=payLines.find(function(x){return x.id===id;}); if(l) l.amount=parseFloat(v)||0; updateBalance(); }
	
	function rmPayLine(id){
		payLines = payLines.filter(x => x.id !== id);

		renderPayLines();
		updateBalance();

		// 🔁 Re-check methods after removal
		var hasCheque = payLines.some(x => x.method === 'cheque');
		var hasCard   = payLines.some(x => x.method === 'card');

		// Toggle cheque block
		$('#chq-details').toggle(hasCheque);
		if (!hasCheque) {
			$('#chq-no, #chq-bank, #chq-date')
				.removeAttr('required')
				.val('');
		}

		// Toggle card block
		$('#card-details').toggle(hasCard);
		if (!hasCard) {
			$('#card-no, #card-type, #card-ref')
				.removeAttr('required')
				.val('');
		}
	}

	function getRemaining(){
		var total=window._invTotal||0, paid=payLines.reduce(function(a,b){return a+b.amount;},0);
		return Math.max(0,total-paid);
	}

	function updateBalance(){
		
		var total=window._invTotal||0, paid=payLines.reduce(function(a,b){return a+b.amount;},0);
		var rem=total-paid;
		$('#bal-total').text('Rs. '+fmt2(total)); 
		$('#bal-paid').text('Rs. '+fmt2(paid));
		$('.bal-paid').val(fmt2(paid));
		$('.bal').val(rem);
		if (rem>0.01){
			$('#bal-rem').text('Rs. '+fmt2(rem)); $('#change-row').hide();
			$('#bal-lbl').text('Balance Remaining').css('color','#fca5a5');
			$('.bal').val(rem);
		} else if (rem<-0.01){
			$('#bal-rem').text('Rs. 0.00'); $('#change-amt').text('Rs. '+fmt2(Math.abs(rem))); $('#change-row').show();
			$('#bal-lbl').text('Fully Paid').css('color','#6ee7b7');
		} else {
			$('#bal-rem').text('Rs. 0.00'); $('#change-row').hide();
			$('#bal-lbl').text('Fully Paid').css('color','#6ee7b7');
		}
		validateCredit();
		$('#complete-btn').prop('disabled', paid<=0);
		
		var balance = $('.bal').val();
		
	}

	function validateCredit(){
		var cLines=payLines.filter(function(l){return l.method==='credit';}), cTotal=cLines.reduce(function(a,b){return a+b.amount;},0);
		if (cTotal>0 && curCustomer && curCustomer.creditEnabled){
			var avail=curCustomer.creditLimit-curCustomer.creditUsed;
			if (cTotal>avail){ $('#cr-warn').show(); return false; }
		}
		$('#cr-warn').hide(); return true;
	}
	
	function payFullCash(){
		payLines=[]; plId++;
		payLines.push({id:plId,method:'cash',amount:window._invTotal||0});
		renderPayLines(); updateBalance(); toast('Full cash applied','success');
	}
	
	function roundOff(){
		var total=window._invTotal||0, rounded=Math.round(total);
		if (rounded===total){ toast('Already rounded','info'); return; }
		if (payLines.length){ payLines[payLines.length-1].amount+=(rounded-total); $('#pa-'+payLines[payLines.length-1].id).val(payLines[payLines.length-1].amount.toFixed(2)); }
		updateBalance(); toast('Rounded to Rs. '+fmt2(rounded),'info');
	}

	// ═══════════════════════════════════════════════════════════
	// COMPLETE SALE
	// ═══════════════════════════════════════════════════════════
	function completeSale(){
		var total=window._invTotal||0, paid=payLines.reduce(function(a,b){return a+b.amount;},0);
		if (!payLines.length){ toast('Add a payment method','warning'); return; }
		if (!validateCredit()){ toast('Credit limit exceeded','danger'); return; }
		var hasCheque=payLines.some(function(l){return l.method==='cheque';});
		if (hasCheque && !$('#chq-no').val()){ toast('Fill cheque details','warning'); return; }

		var change=Math.max(0,paid-total);
		$('#pay-panel').removeClass('open');
		$('#suc-inv').text($('#inv-number').text());
		$('#suc-total').text('Rs. '+fmt2(total));
		if (change>0){ $('#suc-change').text('Rs. '+fmt2(change)); $('#suc-cr').show(); } else { $('#suc-cr').hide(); }
		$('#suc-ov').css('display','flex');
		
	 
	}
	
	function printInvoice(){ 
		toast('Sending to printer…','info'); 
		window.location.href = '/Sale/print_invoice?id=' + encodeURIComponent(lastInvoiceId);
	}
	

	function newSale(){
		items=[]; 
		confirmed=false; 
		payLines=[]; 
		plId=0; 
		curCustomer=null; 
		selProduct=null;
		window._invTotal=0;
		$('#suc-ov').css('display','none');
		$('#cust-sel').val('');
		$('#sales-person').val('');
		$('#warehouse').val('');
		$('#price-list').val('');
		$('#cust-bar').hide();
		$('#items-locked').css('display','none');
		$('#confirm-btn').prop('disabled',false).html('<i class="fa-solid fa-check-circle"></i> Confirm Invoice <span class="kbd">Enter</span>');
		$('#inv-status').removeClass().addClass('status-pill st-draft').html('<i class="fa-solid fa-circle" style="font-size:7px"></i> Draft');
		['#wf1','#wf2','#wf3','#wf4'].forEach(function(s,i){$(s).removeClass('done active').text(['Items','Confirm','Payment','Done'][i]);});
		$('#wf1').addClass('active').html('<i class="fa-solid fa-pencil"></i> Items');
		$('#inv-number').text('INV-2026-'+String(Math.floor(Math.random()*900)+100).padStart(4,'0'));
		$('#g-disc').val(0); $('#tax-chk').prop('checked',false); $('#round-chk').prop('checked',false);
		resetEntry(); renderTable(); calcTotals();
		toast('Ready for new sale!','success');
	}

	function cancelSale(){ 
		newSale(); 
	}

	// ─── HELPERS ───
	function fmt2(n){ return Number(n).toLocaleString('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2}); }
	function toast(msg,type){
		var ic={success:'fa-check-circle',warning:'fa-triangle-exclamation',danger:'fa-circle-xmark',info:'fa-circle-info'};
		var t=$('<div class="t-item t-'+(type||'info')+'"><i class="fa-solid '+ic[type||'info']+'"></i>'+msg+'</div>');
		$('#toast-c').append(t);
		setTimeout(function(){t.css({opacity:0,transform:'translateX(18px)',transition:'all .3s'});setTimeout(function(){t.remove();},300);},3000);
	}

	function saveDraft(){ 
		$('#mode').val('draft');

		if (!items.length){ 
			toast('No items to save','warning'); 
			return; 
		} 	
	}

	$(document).ready(function () {
		
		$('#drft-btn').prop('disabled', false);
		
		
		$('#saleform').ajax_submit({
			url: '/Sale/save_invoice',
			rest: false,
			callback: function(id){

				lastInvoiceId = id; // store globally

				// print AFTER save
				if ($('#auto-print').is(':checked')) {
					printInvoice();
				}

				$('#saleform')[0].reset();

			}
		});
		
		
		//clear sale
		$('.clear-frm').click(function(){
			$.confirmBox({
				title: 'Clear Sale',
				head: 'Are you sure?',
				para: 'Current Sale Data Will be Loss.',

				onConfirm: function(close){
					newSale();
					$('#pay-panel').hide();
					close();
				}
			});
		});
		
		//clear payment
		$('.clear-payments').click(function(){
			$.confirmBox({
				title: 'Clear Payment Details',
				head: 'Return to edit?',
				para: 'Payment data will be cleared.',

				onConfirm: function(close){
					backToEdit(); 
					close();
				}
			});
		});
		
	});
		
</script>