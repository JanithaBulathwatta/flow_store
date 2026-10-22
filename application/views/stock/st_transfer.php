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
	.fi-input{width:100%;padding:8px 8px;border:1.5px solid #fde68a;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;text-align:center;background:#fff;color:#92400e;outline:none;}
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
	.empty-cart i{font-size:38px;opacity:.25;display:block;margin-bottom:8px;margin-left: 47%;}
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


	.entry-bar{background:var(--table-head);border:1.5px dashed var(--primary-mid);border-radius:var(--r-md);padding:13px 16px;}
	.entry-inline{display:flex;align-items:flex-end;gap:10px;flex-wrap:nowrap;}
	.search-wrap{position:relative;}
	.fc{width:100%;padding:8px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);background:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr),box-shadow var(--tr);}
	.fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
	.fc::placeholder{color:var(--text-muted);}
	.ig{position:relative;}
	.ig .fc{padding-left:30px;}
	.ig .ipfx{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:11px;pointer-events:none;font-weight:600;}
	.ig-r{position:relative;}
	.ig-r .fc{padding-right:24px;}
	.ef{display:flex;flex-direction:column;gap:4px;}
	.ef-search{flex:2 1 220px;min-width:0;}
	.ef-price{flex:0 0 130px;}
	.ef-qty{flex:0 0 80px;}
	.ef-fi{flex:0 0 100px;}
	.ef-disc{flex:0 0 80px;}
	.ef-btn{flex:0 0 auto;padding-bottom:1px;}
	.fi-input{width:100%;padding:8px 10px;border:1.5px solid #fde68a;border-radius:var(--r-sm);font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:700;text-align:center;background:#fffbeb;color:#92400e;outline:none;}
	.fi-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(245,158,11,.1);}
	/* APPROVAL MODAL */
	.approval-modal{
		border:none;
		border-radius:18px;
		overflow:hidden;
		box-shadow:0 15px 50px rgba(0,0,0,.15);
	}

	.approval-icon{
		width:52px;
		height:52px;
		border-radius:14px;
		background:linear-gradient(135deg,#dcfce7,#bbf7d0);
		color:#16a34a;
		display:flex;
		align-items:center;
		justify-content:center;
		font-size:22px;
	}

	.approve-summary{
		display:grid;
		grid-template-columns:1fr 1fr;
		gap:12px;
		margin-bottom:18px;
	}
	.sum-item{
		background:#f8fafc;
		border:1px solid #e2e8f0;
		border-radius:12px;
		padding:12px;
	}
	.sum-label{
		display:block;
		font-size:10px;
		text-transform:uppercase;
		font-weight:700;
		color:#94a3b8;
		margin-bottom:4px;
		letter-spacing:.5px;
	}
	.sum-value{
		font-size:14px;
		font-weight:700;
		color:#0f172a;
	}
	.sum-badge{
		display:inline-flex;
		align-items:center;
		padding:4px 10px;
		border-radius:30px;
		font-size:11px;
		font-weight:700;
	}
	.sum-badge.issue{
		background:#fef3c7;
		color:#92400e;
	}
	.sum-badge.transfer{
		background:#dbeafe;
		color:#1d4ed8;
	}
	.approve-alert{display:flex;gap:10px;align-items:flex-start;background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;border-radius:12px;padding:12px 14px;font-size:13px;line-height:1.5;}
	.btn-approve{border:none;background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;padding:11px 18px;border-radius:10px;font-weight:700;fontsize:13px;display:flex;align-items:center;gap:7px;transition:.2s;}
	.btn-approve:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(34,197,94,.25);}
	.btn-cancel{border:none;background:#f1f5f9;color:#475569;padding:11px 16px;border-radius:10px;font-weight:700;font-size:13px;}

	.main {
	  padding: 18px 40px;
	}

</style>



	<form id="saleform"> 
	
		<!-- ─── MAIN ─── -->
		<main class="main">

			<!-- Page Header -->
			<div class="pg-hdr">
				<div>
				
								
						<?php
							if($allowed == 'pro_issue'){
								echo"<h1>Project Item Issue</h1>";
							}
							else if($allowed == 'transfer'){
								echo"<h1>Stock Transfer</h1>";
							}
							else if($allowed == 'return'){
								echo"<h1>Stock Return</h1>";
							}
						?>
					<!-- Add this after the <h1> tag -->
					<div class="mode-tabs" style="display: none; gap: 10px; margin-bottom: 20px;">
						<a href="?mode=pro_issue" class="mode-btn <?= $allowed == 'pro_issue' ? 'active' : '' ?>" style="padding: 8px 20px; border-radius: 8px; text-decoration: none; background: <?= $allowed == 'pro_issue' ? '#3d52a0' : '#f0f0f0' ?>; color: <?= $allowed == 'pro_issue' ? '#fff' : '#333' ?>;">
							📤 Stock Issue
						</a>
						<a href="?mode=transfer" class="mode-btn <?= $allowed == 'transfer' ? 'active' : '' ?>" style="padding: 8px 20px; border-radius: 8px; text-decoration: none; background: <?= $allowed == 'transfer' ? '#3d52a0' : '#f0f0f0' ?>; color: <?= $allowed == 'transfer' ? '#fff' : '#333' ?>;">
							🔄 Stock Transfer
						</a>
						<a href="?mode=return" class="mode-btn <?= $allowed == 'return' ? 'active' : '' ?>" style="padding: 8px 20px; border-radius: 8px; text-decoration: none; background: <?= $allowed == 'return' ? '#3d52a0' : '#f0f0f0' ?>; color: <?= $allowed == 'return' ? '#fff' : '#333' ?>;">
							↩️ Stock Return
						</a>
					</div>
					
					<div class="inv-meta">
						<span class="inv-num"><i class="fa-solid fa-hashtag"></i><span id="inv-number"></span></span>
						<span class="status-pill st-draft" id="inv-status"><i class="fa-solid fa-circle" style="font-size:7px"></i> Draft</span>
						<div class="wf-steps">
							<span class="wf-s done"><i class="fa-solid fa-check"></i> Start</span>
							<span class="wf-s active" id="wf1"><i class="fa-solid fa-pencil"></i> Items</span>
							<span class="wf-s" id="wf2">Confirm</span>
							<!--<span class="wf-s" id="wf3">Payment</span>
							<span class="wf-s" id="wf4">Done</span>-->
						</div>
					</div>
				</div>
			
				<!--<div class="d-flex ac gap-2">
					<button onclick="saveDraft()" id="drft-btn" type="submit" style="padding:8px 14px;border:1.5px solid var(--card-border);border-radius:var(--r-sm);background:#fff;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--text-mid);display:flex;align-items:center;gap:5px;"><i class="fa-regular fa-floppy-disk"></i>Save Draft</button>
					<button onclick="clearAll()" class="clear-frm" type="button" style="padding:8px 14px;border:1.5px solid var(--danger-light);border-radius:var(--r-sm);background:#fff;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--danger);display:flex;align-items:center;gap:5px;"><i class="fa-solid fa-trash"></i>Clear</button>
				</div>-->
			</div>

			<!-- GRID -->
			<div style="display:grid;grid-template-columns:1fr 290px;gap:14px;align-items:start;">

				<!-- ─── LEFT ─── -->
				<div>
					<!-- Section 1: Invoice Header -->
					<div class="card">
						<div class="card-head">
							<div class="sec-icon"><i class="fa-solid fa-file-invoice"></i></div>
							<h6>
								<?php if($allowed == 'pro_issue'): ?>Issue Details
								<?php elseif($allowed == 'transfer'): ?>Transfer Details
								<?php else: ?>Return Details
								<?php endif; ?>
							</h6>
							<!--<h6>Transfer Details</h6>
							<h6>Return Details</h6>-->
						</div>
						<input type="hidden" name="invoice_no" id="inv-num">
						<input type="hidden" id="mode" name="mode" value="complete">
						<input type="hidden" name="invoice_id" id="invoiceid">
						<!-- In the card-body section where warehouse fields are -->
			<div class="card-body">
				<div class="g g3">
				
					<?php if ($allowed == 'pro_issue'): ?>
						<!-- ISSUE MODE FIELDS -->
						
						<div>
							<label class="lbl">From Warehouse <span style="color:var(--danger)">*</span></label>
							<select class="fc" name="warehouse_id" id="warehouse" onchange="loadProducts()">
								<option value="">- Select Warehouse -</option>
								<?php foreach ($warehouses as $item): ?>
									<option value="<?= $item->store_id ?>"><?= $item->store_name ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div>
							<label class="lbl">Project <span style="color:var(--danger)">*</span></label>
							<select class="fc" id="cust-sel" name="project_id" onchange="onCustChange()">
								<option value="">— Select Project —</option>
								<?php foreach ($project as $item): ?>
									<option value="<?= $item->project_id ?>"><?= $item->project_name ?></option>
								<?php endforeach; ?>
							</select>
						</div>
        <?php elseif ($allowed == 'transfer'): ?>
            <!-- TRANSFER MODE FIELDS - UPDATED WITH TO_WAREHOUSE -->
            <div>
                <label class="lbl">From Warehouse <span style="color:var(--danger)">*</span></label>
                <select class="fc" name="warehouse_id" id="warehouse" onchange="loadProducts()">
                    <option value="">- Select Source -</option>
                    <?php foreach ($warehouses as $item): ?>
                        <option value="<?= $item->store_id ?>"><?= $item->store_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="lbl">To Warehouse <span style="color:var(--danger)">*</span></label>
                <select class="fc" name="to_warehouse_id" id="to_warehouse">
                    <option value="">- Select Destination -</option>
                    <?php foreach ($warehouses as $item): ?>
                        <option value="<?= $item->store_id ?>"><?= $item->store_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <!-- Empty div for spacing -->
            </div>

				<?php elseif ($allowed == 'return'): ?>
								<!-- RETURN MODE FIELDS -->
								<div>
									<label class="lbl">Customer <span style="color:var(--danger)">*</span></label>
									<select class="fc" id="cust-sel" name="customer_id" onchange="onCustChange()">
										<option value="">— Select Customer —</option>
										<?php foreach ($customers as $item): ?>
											<option value="<?= $item->cus_id ?>"><?= $item->cus_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								
								<div>
									<label class="lbl">Return To Warehouse <span style="color:var(--danger)">*</span></label>
									<select class="fc" name="warehouse_id" id="warehouse">
										<option value="">- Select Warehouse -</option>
										<?php foreach ($warehouses as $item): ?>
											<option value="<?= $item->store_id ?>"><?= $item->store_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<?php endif; ?>
								
								<div>
									<label class="lbl">Transaction Date <span style="color:var(--danger)">*</span></label>
									<input type="date" class="fc" name="invoice_date" id="inv-date" required>
								</div>
								
								<div>
									<label class="lbl">Delivery Date <span style="color:var(--danger)">*</span></label>
									<input type="date" class="fc" value="<?= date('Y-m-d', strtotime('+2 days')); ?>" name="delivery_date" id="deli-date" required>
								</div>
								
								
							</div>
							
							<div class="cust-bar" id="cust-bar"><div class="cust-grid" id="cust-grid"></div></div>
						</div>
					</div>
					
					<div class="credit-warn" id="cr-warn"><i class="fa-solid fa-triangle-exclamation"></i> Credit limit exceeded or Credit not enabled for this customer.</div>

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
							<div id="serial-hidden-container"></div>
							<div id="batch-hidden-container"></div>
						
							<!-- ENTRY BAR -->
							<div class="entry-bar">
								<!--<div class="entry-top">
									<div>
										<label class="lbl">Search Item (Name / Code / Barcode)</label>
										<div class="search-wrap">
											<input type="text" class="fc" id="item-search" placeholder="Type to search…" autocomplete="off" onkeyup="searchItems(this.value)" onkeydown="handleItemKD(event)">
											<div class="item-dd" id="item-dd"></div>
										</div>
									</div>
									<div>
										<label class="lbl">Unit Price</label>
										<div class="ig"><span class="ipfx">Rs.</span><input type="number" class="fc" id="e-price" value="0" step="0.01" onchange="calcEntryLine()"></div>
									</div>
									<div>
										<label class="lbl">Qty</label>
										<input type="number" class="fc" id="e-qty" value="1" min="0.01" step="0.01" onchange="calcEntryLine()">
									</div>
									<div id="fi-entry-row" style="display:none;">
										<label class="lbl"><i class="fa-solid fa-gift"></i>Free Issue Qty</label>
										<input type="number" class="fi-input fc" id="e-freeissue" value="0" min="0" step="1" onchange="calcEntryLine()" placeholder="0">
										<!--<div class="fi-note">Free qty is given at <strong>no charge</strong>. Not added to invoice value.</div>-->
									<!--</div>
									<div>
										<label class="lbl">Disc %</label>
										<div class="ig-r" style="position:relative;"><input type="number" class="fc" id="e-disc" value="0" min="0" max="100" onchange="calcEntryLine()"><span class="isfx">%</span></div>
									</div>
									<div>
										<label class="lbl">&nbsp;</label>
										<button class="add-btn" type="button" onclick="addItem()"><i class="fa-solid fa-plus"></i>Add</button>
									</div>
								</div>-->
								
								
								<div class="entry-inline">

									<div class="ef ef-search">
										<label class="lbl">Search Item (Name / Code / Barcode)</label>
										<div class="search-wrap">
											<input type="text" class="fc" id="item-search" placeholder="Type to search…" autocomplete="off" onkeyup="searchItems(this.value)" onkeydown="handleItemKD(event)">
											<div class="item-dd" id="item-dd"></div>
										</div>
									</div>

									<!--<div class="ef ef-price">
										<label class="lbl">Unit Price</label>
										<div class="ig">
											<span class="ipfx">Rs.</span>
											<input type="number" class="fc" id="e-price" value="0" step="0.01" onchange="calcEntryLine()">
										</div>
									</div>-->

									<div class="ef ef-qty">
										<label class="lbl">Issue Qty</label>
										<input type="number" class="fc" id="e-qty" value="1" min="1" step="1" onchange="calcEntryLine()">
									</div>

									<!--<div class="ef ef-fi" id="fi-entry-row">
										<label class="lbl"><span class="ico">🎁</span>Free Issues</label>
										<input type="number" class="fi-input" id="e-freeissue" value="0" min="0" step="1" onchange="calcEntryLine()" placeholder="0">
									</div>-->

									<!--<div class="ef ef-disc">
										<label class="lbl">Disc %</label>
										<div class="ig-r">
											<input type="number" class="fc" id="e-disc" value="0" min="0" max="100" onchange="calcEntryLine()">
											<span class="isfx">%</span>
										</div>
									</div>-->

									<div class="ef ef-btn">
										<button class="add-btn" type="button" onclick="addItem()">
											<svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 1v10M1 6h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
											Add
										</button>
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
											<button type="button" class="add-btn" onclick="addSerial()" style="white-space:nowrap;font-size:12px;padding:7px 12px;"><i class="fa-solid fa-plus"></i>Add</button>
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

									<!-- Free Issue
									<div class="fi-row" id="fi-entry-row" style="display:none;">
										<div class="fi-label"><i class="fa-solid fa-gift"></i>Free Issue Qty</div>
										<input type="number" class="fi-input" id="e-freeissue" value="0" min="0" step="1" onchange="calcEntryLine()" placeholder="0">
										<div class="fi-note">Free qty is given at <strong>no charge</strong>. Not added to invoice value.</div>
									</div> -->

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
											<!--<th class="r">Unit Price</th>-->
											<th class="c">Issue Qty</th>
											<!--<th class="c">Free Qty</th>
											<th class="c">Disc %</th>
											<th class="r">Disc Amt</th>
											<th class="r">Net Line</th>-->
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
					<!--<div class="card">
						<div class="card-head">
							<div class="sec-icon"><i class="fa-solid fa-note-sticky"></i></div>
							<h6>Remarks</h6>
						</div>
						<div class="card-body">
							<div class="g g2">
								<div><label class="lbl">Internal Remarks</label><textarea class="fc" id="int-rem" rows="2" placeholder="Internal notes…"></textarea></div>
							</div>
						</div>
					</div>-->
				</div><!-- /LEFT -->

				<!-- ─── RIGHT ─── -->
				<div style="position:sticky;top:78px;">

					<!-- Summary -->
					<!--<div class="card">
						<div class="card-head">
							<div class="sec-icon"><i class="fa-solid fa-calculator"></i></div>
							<h6>Summary</h6>
						</div>
						<div class="card-body">
							<div class="sum-box">
								<div class="sum-row"><span class="sl">Subtotal</span><span class="sv" id="sum-sub">Rs. 0.00</span></div>
								<div class="sum-row"><span class="sl">Item Discounts</span><span class="sv" style="color:var(--success)" id="sum-disc">- Rs. 0.00</span></div>
								<div class="sum-row"><span class="sl">Free Issue Value</span><span class="sv" style="color:var(--accent)" id="sum-fi">Rs. 0.00</span></div>
								<div class="divider" style="margin:8px 0;"></div>
								<div style="margin-bottom:8px;">
									<label class="lbl" style="font-size:10px;">Global Discount (%)</label>
									<div style="display:grid;grid-template-columns:1fr 70px;gap:5px;align-items:center;">
										<input type="number" class="fc" id="g-disc" value="0" min="0" max="100" placeholder="%" onchange="updateSummary()" style="font-size:12px;padding:6px 9px;">
										<span class="mono" id="g-disc-val" style="font-size:12px;color:var(--success);text-align:right;">- Rs. 0.00</span>
									</div>
								</div>
								<div class="sum-row"><span class="sl">Tax (15% VAT)</span><span class="sv" id="sum-tax">Rs. 0.00</span></div>
								<div class="divider" style="margin:8px 0;"></div>
								<div class="sum-row sum-total"><span class="sl">TOTAL</span><span class="sv" id="sum-total">Rs. 0.00</span></div>
							</div>

							<div style="display:flex;align-items:center;gap:10px;margin-top:9px;flex-wrap:wrap;">
								<label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:12px;font-weight:600;color:var(--text-mid);">
									<input type="checkbox" id="tax-chk" onchange="updateSummary()" style="accent-color:var(--primary);">Apply VAT
								</label>
								
							</div>

							<button class="confirm-btn mt-3" type="button" id="confirm-btn" onclick="confirmInvoice()">
								<i class="fa-solid fa-check-circle"></i>Confirm Invoice<span class="kbd">Enter</span>
							</button>
						</div>
					</div>--> 

					<div class="card">
						<div class="card-head">
							<div class="sec-icon"><i class="fa-solid fa-note-sticky"></i></div>
							<h6>Remarks</h6>
						</div>
						<div class="card-body">
							<div class="g g2" >
								<div style="width: 245px;"><label class="lbl">Internal Remarks</label><textarea class="fc" id="int-rem" rows="2" placeholder="Internal notes…"></textarea></div>
							</div>
						</div>
					</div>

					<!-- Quick Stats -->
					<div class="card">
						<div class="card-body" style="padding:13px;">
							<span class="sec-lbl">Issue Summary</span>
							<div class="stats-grid">
								<div class="stat-box" style="background:var(--primary-light);">
									<div class="sv" style="color:var(--primary);" id="stat-items">0</div>
									<div class="sl">Items</div>
								</div>
								<div class="stat-box" style="background:var(--success-light);">
									<div class="sv" style="color:var(--success);" id="stat-qty">0</div>
									<div class="sl">Total Qty</div>
								</div>
								<!--<div class="stat-box" style="background:var(--accent-light);">
									<div class="sv" style="color:#92400e;font-size:14px;" id="stat-fi">0</div>
									<div class="sl">Free Qty</div>
								</div>
								<div class="stat-box" style="background:var(--info-light);">
									<div class="sv" style="color:#0369a1;font-size:14px;" id="stat-saved">0.00</div>
									<div class="sl">Saved</div>
								</div>-->
							</div>
							
								<?php if(isset($is_locked) && $is_locked === true): ?>
									<!-- Show Approve/Reject buttons in locked mode -->
									<div class="d-flex gap-2" style="flex-direction: column;">
										<button type="button" class="btn-approve" onclick="approveTransaction(<?= isset($transaction) ? $transaction->st_activity_id : 0 ?>)" style="background:#10b981; color:white; border:none; padding:12px 16px; border-radius:8px; font-weight:700; width:100%; cursor:pointer;">
											<i class="fa-solid fa-check"></i> Approve Transaction
										</button>
										<button type="button" class="btn-reject" onclick="rejectTransaction(<?= isset($transaction) ? $transaction->st_activity_id : 0 ?>)" style="background:#ef4444; color:white; border:none; padding:12px 16px; border-radius:8px; font-weight:700; width:100%; cursor:pointer;">
											<i class="fa-solid fa-times"></i> Reject Transaction
										</button>
									</div>
								<?php else: ?>
									<!-- Show Submit button in normal mode -->
									<button class="confirm-btn mt-3" type="button" id="confirm-btn" onclick="submitTransaction()">
										<i class="fa-solid fa-check-circle"></i>
										<?php if($allowed == 'pro_issue'): ?>Submit Issue
										<?php elseif($allowed == 'transfer'): ?>Submit Transfer
										<?php else: ?>Submit Return
										<?php endif; ?>
										<span class="kbd">Enter</span>
									</button>
								<?php endif; ?>
						</div>
					</div>
					
					
					
				</div><!-- /RIGHT -->
			</div>
			<!-- APPROVAL MODAL -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content approval-modal">

            <!-- HEADER -->
            <div class="modal-header border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="approval-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>

                    <div>
                        <h5 class="modal-title mb-0">Approve Transaction</h5>
                        <small class="text-muted">
                            Confirm stock issue / transfer approval
                        </small>
                    </div>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- SUMMARY -->
                <div class="approve-summary">

                    <div class="sum-item">
                        <span class="sum-label">Transaction No</span>
                        <span class="sum-value" id="approveRefNo">
                            ST-00001
                        </span>
                    </div>

                    <div class="sum-item">
                        <span class="sum-label">Type</span>
                        <span class="sum-badge issue" id="approveType">
                            ISSUE
                        </span>
                    </div>

                    <div class="sum-item">
                        <span class="sum-label">Warehouse</span>
                        <span class="sum-value" id="approveWarehouse">
                            Main Warehouse
                        </span>
                    </div>

                    <div class="sum-item">
                        <span class="sum-label">Total Qty</span>
                        <span class="sum-value" id="approveQty">
                            25 PCS
                        </span>
                    </div>

                </div>

                <!-- WARNING -->
                <div class="approve-alert">
                    <i class="fas fa-info-circle"></i>

                    <div>
                        Approving this transaction will finalize the stock movement
                        and release reserved stock quantities.
                    </div>
                </div>

                <!-- NOTE -->
                <div class="mt-3">
                    <label class="lbl">Approval Note</label>

                    <textarea class="fc"
                              id="approval_note"
                              rows="3"
                              placeholder="Optional approval note..."></textarea>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0">

                <button type="button"
                        class="btn-cancel"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <button type="button"
                        class="btn-approve"
                        id="confirmApproveBtn">

                    <i class="fas fa-check"></i>
                    Approve Transaction
                </button>

            </div>

        </div>
    </div>
</div>
		</main>

		

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
						<button class="btn-print" type="button" onclick="printInvoice()"><i class="fa-solid fa-print"></i>Print</button>
						<button class="btn-new" type="button" onclick="newSale()"><i class="fa-solid fa-plus"></i>New Sale</button>
					</div>
			</div>
		</div>

		<div id="toast-c"></div>
	</form>

	<!-- ─── JAVASCRIPT ─── -->
	<script>
				let lastInvoiceId = null;
		var invno = 'INV-' + Date.now();
		$('#inv-number').text(invno);
		$('#inv-num').val(invno);

		function newinvid(){
			let lastInvoiceId = null;
			var invno = 'INV-' + Date.now();
			$('#inv-number').text(invno);
			$('#inv-num').val(invno);
		}

		var CUSTOMERS = {};
		var PRODUCTS = [];
		var items = [];
		var confirmed = false;
		var curCustomer = null;
		var selProduct = null;
		var serialsForEntry = [];
		var selBatch = null;

		// Load customers
		$.ajax({
			url: "/Stock_Transfer/get_customers_ajax",
			type: "GET",
			dataType: "json",
			success: function(response) {
				CUSTOMERS = response.data || {};
				console.log("Customers Loaded:", CUSTOMERS);
			},
			error: function(xhr, status, error) {
				console.error("Error loading customers:", error);
				CUSTOMERS = {};
			}
		});

		// Load products with mode
		function loadInitialProducts() {
			var mode = '<?= $allowed ?>';
			var warehouseId = $('#warehouse').val();  // ✅ Get selected warehouse
			$.ajax({
				url: "/Stock_Transfer/get_products_ajax",
				type: "GET",
				data: { 
					mode: mode,
					warehouse_id: warehouseId || ''  // ✅ Pass warehouse_id
				},
				dataType: "json",
				success: function(response) {
					PRODUCTS = response.data || [];
					console.log("Products Loaded:", PRODUCTS.length + " products for " + mode + " mode");
					if (PRODUCTS.length > 0) {
						console.log("Sample product:", PRODUCTS[0]);
						console.log("isSerial:", PRODUCTS[0].isSerial, "isBatch:", PRODUCTS[0].isBatch, "hasExpiry:", PRODUCTS[0].hasExpiry);
						console.log("Batches:", PRODUCTS[0].batches ? PRODUCTS[0].batches.length : 0);
					}
				},
				error: function(err) {
					console.error("Error loading products:", err);
					PRODUCTS = [];
				}
			});
		}


		// ─── ALL FUNCTIONS ───

		function onCustChange(){
			var id = $('#cust-sel').val();
			if (!id){ $('#cust-bar').hide(); curCustomer=null; return; }
			curCustomer = CUSTOMERS[id];
			if (!curCustomer) return;
			var c = curCustomer;
			var used = c.creditUsed||0, avail = c.creditLimit - used;
			var pct = c.creditLimit>0 ? Math.min((used/c.creditLimit)*100,100) : 0;
			var barCls = pct>90?'bad':pct>70?'warn':'';
			var html = '<div class="ci-item"><div class="lbl2">Name</div><div class="val">'+c.name+'</div></div>' +
				'<div class="ci-item"><div class="lbl2">Phone</div><div class="val">'+c.phone+'</div></div>' +
				'<div class="ci-item"><div class="lbl2">Email</div><div class="val" style="font-size:11px">'+c.email+'</div></div>';
			if(c.creditEnabled){
				html += '<div class="ci-item"><div class="lbl2">Credit Limit</div><div class="val">Rs. '+fmt2(c.creditLimit)+'</div></div>' +
					'<div class="ci-item"><div class="lbl2">Available</div><div class="val text-success">Rs. '+fmt2(avail)+'</div></div>' +
					'<div class="ci-item gc-full" style="grid-column:span 3"><div class="lbl2">Credit Used '+pct.toFixed(0)+'%<input type="hidden" value="'+fmt2(avail)+'" id="cre-limit"></div>' +
					'<div class="cr-bar-w"><div class="cr-bar-f '+barCls+'" style="width:'+pct+'%"></div></div></div>';
			} else {
				html += '<div class="ci-item"><div class="lbl2">Credit</div><div class="val text-muted">Not enabled<input type="hidden" value="Not enabled" id="cre-stt2"></div></div>';
			}
			$('#cust-grid').html(html);
			$('#cust-bar').fadeIn(200);
		}

		function getPriceForProduct(p){
			if (!p) return 0;
			return parseFloat(p.price || 0);
		}

		var searchTimer;
		function searchItems(val){
			clearTimeout(searchTimer);
			if (val.length<1){ $('#item-dd').hide(); clearProdPanel(); return; }
			searchTimer = setTimeout(function(){
				var res = PRODUCTS.filter(function(p){
					return p.name.toLowerCase().includes(val.toLowerCase()) || p.code.toLowerCase().includes(val.toLowerCase());
				});
				renderDD(res);
			},140);
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
				return '<div class="i-opt" onclick="selectProd(\''+p.id+'\')">' +
					'<span class="i-code">'+p.code+'</span>' +
					'<div style="flex:1;min-width:0;">' +
					'<div class="i-name">'+p.icon+' '+p.name+'</div>' +
					'<div class="i-sub">'+p.category+' · '+ (p.description||'') +' · <span class="stk '+sc+'">'+sl+'</span></div>' +
					'<div style="display:flex;gap:3px;margin-top:3px;">'+badges+'</div>' +
					'</div>' +
					'<span class="i-price">Rs. '+fmt2(getPriceForProduct(p))+'</span>' +
					'</div>';
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

		function selectProd(id){
			var p = PRODUCTS.find(function(x){return x.id===id;});
			if (!p) return;
			selProduct = p;
			serialsForEntry = [];
			selBatch = null;
			$('#item-search').val(p.name);
			$('#e-qty').val(1);
			$('#item-dd').hide();
			showProdInfoPanel(p);
			showEntryExtras(p);
			calcEntryLine();
			setTimeout(function(){ $('#e-qty').focus().select(); },80);
		}

		function showProdInfoPanel(p){
			var stockCls = p.stock > 10 ? 'green' : p.stock > 0 ? 'orange' : 'red';
			var pipHTML = '<div class="pip-item"><div class="pil">Code</div><div class="piv mono">'+(p.code||'')+'</div></div>' +
				'<div class="pip-item"><div class="pil">Category</div><div class="piv">'+(p.category||'')+'</div></div>' +
				'<div class="pip-item"><div class="pil">Unit</div><div class="piv">'+(p.unit||'')+'</div></div>' +
				'<div class="pip-item"><div class="pil">Stock</div><div class="piv '+stockCls+'">'+p.stock+' '+(p.unit||'')+'</div></div>' +
				'<div class="pip-item"><div class="pil">Retail Price</div><div class="piv mono">Rs. '+fmt2(p.retailPrice||0)+'</div></div>' +
				'<div class="pip-item"><div class="pil">Wholesale</div><div class="piv mono">Rs. '+fmt2(p.wholesalePrice||0)+'</div></div>';
			if (p.hasWarranty) pipHTML += '<div class="pip-item"><div class="pil">Warranty</div><div class="piv">'+(p.warrantyMonths||0)+' months ('+(p.warrantyType||'manufacturer')+')</div></div>';
			if ((p.isBatch||p.isBatchTrk) && p.batches) pipHTML += '<div class="pip-item"><div class="pil">Batches</div><div class="piv">'+p.batches.length+' batches available</div></div>';
			
			var badges = [];
			if (p.isSerial||p.isSerialTrk) badges.push('<span class="feat-badge fb-serial"><i class="fa-solid fa-barcode"></i>Serial Item</span>');
			if (p.isBatch||p.isBatchTrk) badges.push('<span class="feat-badge fb-batch"><i class="fa-solid fa-layer-group"></i>Batch Tracked</span>');
			if (p.isAutoBatch) badges.push('<span class="feat-badge fb-batch"><i class="fa-solid fa-robot"></i>Auto Batch</span>');
			if (p.hasExpiry) badges.push('<span class="feat-badge fb-expiry"><i class="fa-solid fa-calendar-xmark"></i>Has Expiry</span>');
			if (p.hasWarranty) badges.push('<span class="feat-badge fb-warranty"><i class="fa-solid fa-shield-halved"></i>Warranty</span>');
			badges.push('<span class="feat-badge fb-free"><i class="fa-solid fa-gift"></i>Free Issue</span>');
			
			$('#pip-icon').text(p.icon||'📦');
			$('#pip-right').html(pipHTML);
			$('#pip-badges').html(badges.join(''));
			$('#prod-info-panel').slideDown(200);
		}

		function showEntryExtras(p){
    $('#entry-extras').show();
    var mode = '<?= $allowed ?>';

    // ==========================================
    // SERIAL SECTION
    // ==========================================
    // For issue/transfer: show ONLY if product has serial tracking
    // For return: always show (allow manual entry)
    if (mode === 'return' || (p.isSerial || p.isSerialTrk)){
        serialsForEntry = [];
        renderSerialChips();
        $('#ser-row').addClass('show');
        $('#serial-input').val('');
        
        // For issue/transfer, show how many serials needed
        if (mode !== 'return') {
            $('#serial-count').show();
        }
    } else { 
        $('#ser-row').removeClass('show'); 
    }

    // ==========================================
    // BATCH SECTION
    // ==========================================
    var isBatchTracked = (p.isBatch == 1) || (p.isBatchTrk == 1) || (p.hasExpiry == 1);
    
    // For issue/transfer: show ONLY if product has batch tracking AND warehouse is selected
    // For return: show always (allow create new)
    if (mode === 'return') {
        // Return mode - show batch UI
        var html = '';
        
        if (p.batches && p.batches.length > 0) {
            html = p.batches.map(function(b){
                var expDate = b.expDate || b.expiry_date;
                var daysLeft = 0, expCls = '', expTxt = 'No expiry';
                if (expDate) {
                    daysLeft = Math.ceil((new Date(expDate)-new Date())/86400000);
                    expCls = daysLeft<90?'text-danger':daysLeft<180?'text-warning':'text-success';
                    expTxt = 'Exp: '+expDate+' <span class="'+expCls+'">('+daysLeft+'d)</span>';
                }
                return '<div class="batch-option" onclick="selectBatch(\''+b.id+'\',this)" data-bid="'+b.id+'">' +
                    '<div><div class="bn">'+(b.batchNo||b.batch_no||'N/A')+'</div><div class="bmeta">'+expTxt+'</div></div>' +
                    '<div class="bstock">'+(b.stock||b.qty||0)+' '+(p.unit||'pcs')+'</div></div>';
            }).join('');
        } else {
            html = '<div style="padding:10px;text-align:center;color:var(--text-muted);font-size:12px;">No existing batches found. Create a new one below.</div>';
        }
        
        html += '<div class="batch-option" onclick="selectBatch(\'new\',this)" data-bid="new">' +
            '<div><div class="bn">+ New Batch for Return</div><div class="bmeta">Create new batch entry</div></div>' +
            '<div class="bstock">—</div></div>';
        
        $('#batch-options').html(html);
        $('#batch-row').addClass('show').css('display', 'block');
        $('#batch-row .sr-tag').html('<i class="fa-solid fa-layer-group"></i> Select or Create Batch (Optional)');
        
    } else if (isBatchTracked) {
        // Issue/Transfer mode - show batch UI ONLY if batch tracked
        var warehouseId = $('#warehouse').val();
        
        if (!warehouseId) {
            $('#batch-options').html('<div style="padding:10px;text-align:center;color:var(--danger);font-size:12px;">' +
                '<i class="fa-solid fa-triangle-exclamation"></i> Please select a warehouse first.</div>');
            $('#batch-row').addClass('show').css('display', 'block');
        } else if (p.batches && p.batches.length > 0) {
            var html = p.batches.map(function(b){
                var expDate = b.expDate || b.expiry_date;
                var daysLeft = 0, expCls = '', expTxt = 'No expiry';
                if (expDate) {
                    daysLeft = Math.ceil((new Date(expDate)-new Date())/86400000);
                    expCls = daysLeft<90?'text-danger':daysLeft<180?'text-warning':'text-success';
                    expTxt = 'Exp: '+expDate+' <span class="'+expCls+'">('+daysLeft+'d)</span>';
                }
                var availableStock = (b.stock || b.qty || 0);
                return '<div class="batch-option" onclick="selectBatch(\''+b.id+'\',this)" data-bid="'+b.id+'">' +
                    '<div><div class="bn">'+(b.batchNo||b.batch_no||'N/A')+'</div><div class="bmeta">'+expTxt+'</div></div>' +
                    '<div class="bstock">' + availableStock + ' ' + (p.unit||'pcs') + '</div></div>';
            }).join('');
            $('#batch-options').html(html);
            $('#batch-row').addClass('show').css('display', 'block');
            $('#batch-row .sr-tag').html('<i class="fa-solid fa-layer-group"></i> Select Batch (Required)');
        } else {
            $('#batch-options').html('<div style="padding:10px;text-align:center;color:var(--danger);font-size:12px;">' +
                '<i class="fa-solid fa-triangle-exclamation"></i> No batches available for this product in the selected warehouse.' +
                '<br><small>Please add stock via GRN first.</small></div>');
            $('#batch-row').addClass('show').css('display', 'block');
        }
    } else { 
        $('#batch-row').removeClass('show').hide(); 
        selBatch = null;
    }

    // ==========================================
    // EXPIRY SECTION (only for non-batch products)
    // ==========================================
    if (p.hasExpiry && !p.isBatch && !p.isBatchTrk){
        $('#expiry-info').html(
            '<div><label class="lbl">Expiry Date</label><input type="date" class="fc" id="e-expiry"></div>' +
            '<div><label class="lbl">Mfg Date</label><input type="date" class="fc" id="e-mfgdate"></div>'
        );
        $('#expiry-row').addClass('show');
    } else { 
        $('#expiry-row').removeClass('show'); 
    }

    // ==========================================
    // WARRANTY SECTION
    // ==========================================
    if (p.hasWarranty){
        $('#w-default').val((p.warrantyMonths||0)+' months ('+(p.warrantyType||'manufacturer')+')');
        $('#w-override').val(p.warrantyMonths||0);
        $('#w-type').val(p.warrantyType||'manufacturer');
        $('#warranty-row').addClass('show');
    } else { 
        $('#warranty-row').removeClass('show'); 
    }
    
    // Free issue row - show for all modes except return
    if (mode !== 'return') {
        $('#fi-entry-row').show();
    } else {
        $('#fi-entry-row').hide();
    }
}

		function clearProdPanel(){
			selProduct=null; serialsForEntry=[]; selBatch=null;
			$('#prod-info-panel').hide();
			$('#entry-extras').hide();
		}
 
		function renderSerialChips(){
			var chips = serialsForEntry.map(function(s,i){
				return '<span class="s-chip">'+s+'<button onclick="removeSerial('+i+')"><i class="fa-solid fa-xmark"></i></button></span>';
			}).join('');
			$('#serial-chips').html(chips||'<span style="font-size:11px;color:var(--text-muted);padding:3px 6px;">No serials entered yet</span>');
			var needed = parseInt($('#e-qty').val())||0;
			var have = serialsForEntry.length;
			var cls = have===needed?'color:var(--success)':have>needed?'color:var(--danger)':'color:var(--text-muted)';
			$('#serial-count').html('<span style="'+cls+';font-weight:700;">'+have+' of '+needed+' serials entered</span>');
		}

		function addSerial(){
    var val = $('#serial-input').val().trim();
    if (!val) return;

    if (serialsForEntry.includes(val)){
        toast('Serial already added','warning'); 
        return;
    }

    var mode = '<?= $allowed ?>';
    
    // For return mode OR when serial list is empty, allow manual entry
    if (mode === 'return' || !selProduct || !Array.isArray(selProduct.serials) || selProduct.serials.length === 0){
        // Allow manual serial entry
        serialsForEntry.push(val);
        $('#serial-input').val('');
        renderSerialChips();
        return;
    }

    // For issue/transfer with available serials - validate against stock
    if (!selProduct.serials.includes(val)){
        toast('Serial not found in stock: ' + val,'warning'); 
        return;
    }

    serialsForEntry.push(val);
    $('#serial-input').val('');
    renderSerialChips();
}

		function removeSerial(i){ serialsForEntry.splice(i,1); renderSerialChips(); }

		function selectBatch(bid, el){
    console.log("selectBatch called with bid:", bid, "type:", typeof bid);
    
    if (bid === 'new') {
        selBatch = 'new';
        $('.batch-option').removeClass('sel');
        $(el).addClass('sel');
        $('#expiry-row').addClass('show');
        $('#expiry-info').html(
            '<div><label class="lbl">New Batch Number</label><input type="text" class="fc" id="e-new-batch" placeholder="Enter batch number"></div>' +
            '<div><label class="lbl">Expiry Date</label><input type="date" class="fc" id="e-expiry"></div>' +
            '<div><label class="lbl">Mfg Date</label><input type="date" class="fc" id="e-mfgdate"></div>'
        );
        console.log("selBatch set to: 'new'");
        return;
    }
    
    // Convert to string for comparison, but store original
    selBatch = String(bid);
    console.log("selBatch set to:", selBatch);
    
    $('.batch-option').removeClass('sel');
    $(el).addClass('sel');
    
    if (selProduct){
        var b = selProduct.batches.find(function(x){ 
            return String(x.id) === String(bid); 
        });
        if (b && selProduct.hasExpiry){
            var expDate = b.expDate || b.expiry_date;
            if (expDate) {
                var dLeft = Math.ceil((new Date(expDate)-new Date())/86400000);
                var eCls = dLeft<90?'text-danger':dLeft<180?'text-warning':'text-success';
                $('#expiry-row').addClass('show');
                $('#expiry-info').html(
                    '<div class="pip-item"><div class="pil">Batch No.</div><div class="piv mono">'+(b.batchNo||b.batch_no||'N/A')+'</div></div>' +
                    '<div class="pip-item"><div class="pil">Mfg. Date</div><div class="piv">'+(b.mfgDate||b.mfg_date||'N/A')+'</div></div>' +
                    '<div class="pip-item"><div class="pil">Expiry Date</div><div class="piv '+eCls+'">'+expDate+' ('+dLeft+' days)</div></div>'
                );
            }
        }
    }
}

		function storeSerialInputs(){
			var container = $('#serial-hidden-container');
			container.empty();
			if (!items || !items.length) return;
			items.forEach(function(item, index){
				if (!item.isSerial) return;
				if (!item.serials || !item.serials.length) return;
				container.append('<input type="hidden" name="items['+index+'][product_id]" value="'+item.productId+'">');
				container.append('<input type="hidden" name="items['+index+'][qty]" value="'+item.qty+'">');
				item.serials.forEach(function(sn){
					container.append('<input type="hidden" name="serials['+item.productId+'][]" value="'+sn+'">');
				});
			});
		}

function storeBatchInputs(){
    var container = $('#batch-hidden-container');
    container.empty();
    if (!items || !items.length) return;
    items.forEach(function(item, index){
        if (!item.isBatch) return;
        // Store batch_id if it exists and is not 'new'
        if (item.batchId && item.batchId !== 'new') {
            container.append('<input type="hidden" name="items['+index+'][batch_id]" value="'+item.batchId+'">');
        }
        // Store batch_no if it exists
        if (item.batchNo) {
            container.append('<input type="hidden" name="items['+index+'][batch_no]" value="'+item.batchNo+'">');
        }
        // Also store product_id and qty for reference
        container.append('<input type="hidden" name="items['+index+'][product_id]" value="'+item.productId+'">');
        container.append('<input type="hidden" name="items['+index+'][qty]" value="'+item.qty+'">');
    });
}

		function calcEntryLine(){
			var price = parseFloat($('#e-price').val())||0;
			var qty = parseFloat($('#e-qty').val())||0;
			if (selProduct && selProduct.isSerial) renderSerialChips();
			if (price>0 && qty>0){
				$('#line-prev-val').text('Rs. '+fmt2(price*qty));
				$('#line-prev').show();
			} else { $('#line-prev').hide(); }
		}

function addItem() {
    if (!selProduct) { toast('Search and select a product first','warning'); return; }
    var qty = parseInt($('#e-qty').val())||0;
    var mode = '<?= $allowed ?>';
    if (qty<=0){ toast('Quantity must be > 0','warning'); return; }
    
    // DEBUG: Log current selection
    console.log("=== ADDING ITEM ===");
    console.log("Product:", selProduct.name, "ID:", selProduct.id);
    console.log("selBatch:", selBatch);
    console.log("isBatchTracked:", selProduct.isBatch, selProduct.isBatchTrk, selProduct.hasExpiry);
    console.log("Batches available:", selProduct.batches);
    
    if (mode === 'return') {
        // Return mode code (keep as is)
        // ... existing return code ...
    }
    
    // For ISSUE and TRANSFER modes
    if (selProduct.stock <= 0){ toast('Out of stock','error'); return; }
    if (qty > selProduct.stock){ toast('Insufficient stock. Available: '+selProduct.stock,'warning'); return; }
    
    var isSerialItem = selProduct.isSerial || selProduct.isSerialTrk;
    if (isSerialItem && serialsForEntry.length !== qty){ 
        toast('Please enter '+qty+' serial(s). You have '+serialsForEntry.length,'warning'); 
        return; 
    }
    
    var isBatchItem = selProduct.isBatch || selProduct.isBatchTrk || selProduct.hasExpiry;
    
    // CRITICAL: Check if batch is required AND selected
    if (isBatchItem && (!selBatch || selBatch === '' || selBatch === null)){ 
        toast('Please select a batch for this product','warning'); 
        console.log("Batch validation failed - selBatch:", selBatch);
        return; 
    }
    
    var batchInfo = null;
    var actualBatchId = null;
    var actualBatchNo = null;
    
    if (selBatch && selBatch !== '' && selBatch !== null) {
        actualBatchId = selBatch;
        // Find batch info from product batches
        if (selProduct.batches && selProduct.batches.length) {
            batchInfo = selProduct.batches.find(function(b){ 
                return String(b.id) === String(selBatch); 
            });
            if (batchInfo) {
                actualBatchNo = batchInfo.batchNo || batchInfo.batch_no;
            }
        }
    }
    
    console.log("actualBatchId:", actualBatchId);
    console.log("actualBatchNo:", actualBatchNo);
    
    var expDate = batchInfo ? (batchInfo.expDate || batchInfo.expiry_date) : null;
    
    // Check if same product+batch already exists (for non-serial items)
    var existing = items.find(function(i){ 
        return i.productId === selProduct.id && i.batchId === actualBatchId; 
    });
    
    if (existing && !isSerialItem) { 
        existing.qty += qty; 
        toast(selProduct.name+' updated','info'); 
    } else {
        items.push({
            productId: selProduct.id,
            code: selProduct.code,
            name: selProduct.name,
            icon: selProduct.icon||'📦',
            unit: selProduct.unit||'pcs',
            qty: qty,
            isSerial: isSerialItem,
            serials: [...serialsForEntry],
            isBatch: isBatchItem,
            batchId: actualBatchId,      // Store the actual batch ID
            batchNo: actualBatchNo,      // Store batch number for display
            batchNumber: actualBatchNo,
            hasExpiry: selProduct.hasExpiry,
            expDate: expDate,
            expiryDate: expDate,
            hasWarranty: selProduct.hasWarranty,
            warrantyMonths: parseInt($('#w-override').val()) || selProduct.warrantyMonths || 0,
            warrantyType: $('#w-type').val() || selProduct.warrantyType || 'manufacturer'
        });
        toast(selProduct.name+' added','success');
    }
    
    console.log("Items after add:", items);
    
    renderTable();
    updateSummary();
    resetEntry();
    storeSerialInputs();
    storeBatchInputs();
}

		function resetEntry(){
			selProduct=null;serialsForEntry=[];selBatch=null;
			$('#item-search').val('').focus();$('#e-qty').val(1);
			$('#prod-info-panel').slideUp(150);$('#entry-extras').slideUp(150);$('#line-prev').hide();
			$('#ser-row,#batch-row,#expiry-row,#warranty-row').removeClass('show');$('#fi-entry-row').hide();
		}

		function renderTable() {
    var tbody = $('#items-tbody');
    if (!items.length) {
        tbody.html('<tr id="empty-row"><td colspan="4"><div class="empty-cart"><i class="fa-solid fa-box-open"></i><p>No items added.</p></div></td></tr>');
        $('#cnt-badge').text('0 items');
        return;
    }
    $('#cnt-badge').text(items.length+' item'+(items.length!==1?'s':''));
    var html = items.map(function(item,idx){
        var batchStr='',serialStr='',expiryStr='';
        // Show batch number if available (not the ID)
        var displayBatchNo = item.batchNo || (item.batchId && item.batchId !== 'new' ? 'Batch #'+item.batchId : null);
        if(item.isBatch && displayBatchNo) batchStr='<span class="warn-chip wc-batch"><i class="fa-solid fa-layer-group"></i>'+displayBatchNo+'</span>';
        if(item.hasExpiry&&item.expDate) expiryStr='<span class="warn-chip wc-expiry"><i class="fa-solid fa-calendar-xmark"></i>Exp '+item.expDate+'</span>';
        if(item.isSerial&&item.serials&&item.serials.length) serialStr='<span class="warn-chip wc-serial"><i class="fa-solid fa-barcode"></i>'+item.serials.length+' S/N</span>';
        return '<tr><td style="color:var(--text-muted);font-size:11px;font-weight:700;">'+(idx+1)+'</td>' +
            '<td><div class="tbl-name">'+(item.icon||'')+' '+item.name+'</div>' +
            '<div class="tbl-sub">'+item.code+' · '+item.unit+(displayBatchNo?(' · '+displayBatchNo):'')+'</div>' +
            '<div class="tbl-tags mt-1">'+serialStr+batchStr+expiryStr+'</div></td>' +
            '<td class="c"><input type="number" class="ti-input" value="'+item.qty+'" min="1" onchange="updQty('+idx+',this.value)"></td>' +
            '<td class="c"><button class="del-btn" onclick="removeItem('+idx+')"><i class="fa-solid fa-xmark"></i></button></td>' +
            '</tr>';
    }).join('');
    tbody.html(html);
}

		function updQty(i,v){ var q=parseFloat(v)||0; if(q<=0){toast('Qty must be > 0','warning');return;} items[i].qty=q; renderTable(); updateSummary(); storeSerialInputs(); storeBatchInputs(); }
		function removeItem(i){ var n=items[i].name; items.splice(i,1); renderTable(); updateSummary(); storeSerialInputs(); storeBatchInputs(); toast(n+' removed','info'); }

		function updateSummary(){
			var totalQty = items.reduce(function(a,b){return a+b.qty;},0);
			$('#stat-items').text(items.length);
			$('#stat-qty').text(fmt2(totalQty));
		}

		function loadProducts() {
			var warehouseId = $('#warehouse').val();
			var mode = '<?= $allowed ?>';
			$.ajax({
				url: "/Stock_Transfer/get_products_ajax",
				type: "GET",
				data: { warehouse_id: warehouseId||'', mode: mode },
				dataType: "json",
				success: function(response) {
					if (response.status === 'success') {
						PRODUCTS = response.data || [];
						console.log("Products Loaded:", PRODUCTS.length+" products for "+mode+" mode");
					} else { PRODUCTS = []; toast(response.msg||'Error loading products','warning'); }
				},
				error: function(err) { console.error("Error loading products:", err); PRODUCTS = []; toast('Failed to load products','error'); }
			});
		}

		$('#warehouse').on('change', function() { loadProducts(); });

function getItems() {
    console.log("=== getItems called ===");
    console.log("Current items array:", JSON.parse(JSON.stringify(items)));
    
    var result = items.map(function(item, index) {
        var itemData = {
            product_id: item.productId,
            qty: item.qty,
            serials: item.serials || []
        };
        
        // IMPORTANT: Use 'batch_id' with underscore (not 'batchId')
        if (item.isBatch) {
            // For existing batches, send batch_id (with underscore)
            if (item.batchId && item.batchId !== 'new' && item.batchId !== null && item.batchId !== '') {
                itemData.batch_id = parseInt(item.batchId);  // Ensure it's a number
                console.log("Adding batch_id:", itemData.batch_id, "for product:", item.productId);
            } else {
                console.log("WARNING: No batch_id for batch-tracked product:", item.productId, "batchId:", item.batchId);
            }
            // Send batch_number if available
            if (item.batchNo) {
                itemData.batch_number = item.batchNo;
            }
        }
        
        if (item.expiryDate) {
            itemData.expiry_date = item.expiryDate;
        }
        
        return itemData;
    });
    
    console.log("Final items being submitted:", result);
    return result;
}

		function submitTransaction() {
			if (!items.length) { toast('Add at least one item','warning'); return; }
			var mode = '<?= $allowed ?>';
			var payload = {};
			if (mode === 'pro_issue') {
				if(!$('#cust-sel').val()){toast('Please select a customer','warning');return;}
				if(!$('#warehouse').val()){toast('Please select source warehouse','warning');return;}
				payload = {transaction_mode:mode,store_id:$('#warehouse').val(),project_id:$('#cust-sel').val(),to_store_id:null,remarks:$('#int-rem').val(),items:getItems(),deli:$('#deli-date').val()};
			} else if (mode === 'transfer') {
				if(!$('#warehouse').val()){toast('Please select source warehouse','warning');return;}
				if(!$('#to_warehouse').val()){toast('Please select destination warehouse','warning');return;}
				if($('#warehouse').val()===$('#to_warehouse').val()){toast('Source and destination must be different','warning');return;}
				payload = {transaction_mode:mode,store_id:$('#warehouse').val(),customer_id:null,to_store_id:$('#to_warehouse').val(),remarks:$('#int-rem').val(),items:getItems()};
			} else if (mode === 'return') {
				if(!$('#cust-sel').val()){toast('Please select a customer','warning');return;}
				if(!$('#warehouse').val()){toast('Please select return warehouse','warning');return;}
				payload = {transaction_mode:mode,store_id:$('#warehouse').val(),customer_id:$('#cust-sel').val(),to_store_id:null,remarks:$('#int-rem').val(),items:getItems()};
			}
			if (!payload.items||payload.items.length===0){toast('No items to submit','warning');return;}
			$.ajax({
				url:'/Stock_Transfer/store',type:'POST',data:JSON.stringify(payload),contentType:'application/json',dataType:'json',
				beforeSend:function(){ $('#confirm-btn').prop('disabled',true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...'); },
				success:function(response){
					if(response.status==='success'){
						var modeName=mode==='transfer'?'Transfer':(mode==='pro_issue'?'pro_issue':'Return');
						toast(modeName+' request submitted!','success');
						showSuccessModal(response.data,mode);
						clearForm();
						setTimeout(function(){window.location.href='/Stock_Transfer/activity_list';},2000);
					} else { toast(response.msg||'Save failed','error'); }
				},
				error:function(xhr){var msg='Server error';try{var res=JSON.parse(xhr.responseText);msg=res.msg||msg;}catch(e){} toast(msg,'error'); },
				complete:function(){ $('#confirm-btn').prop('disabled',false).html('<i class="fa-solid fa-check-circle"></i> Submit'); }
			});
		}

		function showSuccessModal(data,mode){
			var modeText=mode==='transfer'?'Transfer':(mode==='pro_issue'?'pro_issue':'Return');
			$('#suc-ov .suc-icon').html('<i class="fa-solid fa-check-circle"></i>');
			$('#suc-ov h3').text(modeText+' Submitted!');
			$('#suc-ov p').text(modeText+' request has been sent for approval.');
			$('#suc-inv').text('Ref: '+(data.activity_id||'Pending'));
			$('#suc-total').text('Status: Pending Approval');
			$('#suc-cr').hide();$('#suc-ov').css('display','flex');
			$('.btn-print').hide();$('.btn-new').text('New '+modeText);
		}

		function clearForm(){
			items=[];selProduct=null;serialsForEntry=[];selBatch=null;curCustomer=null;confirmed=false;
			$('#item-search').val('');$('#e-qty').val(1);$('#cust-sel').val('');$('#warehouse').val('');
			$('#to_warehouse').val('');$('#int-rem').val('');$('#cust-bar').hide();
			$('#prod-info-panel').hide();$('#entry-extras').hide();
			$('#items-locked').css('display','none');
			$('#inv-status').removeClass().addClass('status-pill st-draft').html('<i class="fa-solid fa-circle" style="font-size:7px"></i> Draft');
			renderTable();updateSummary();newinvid();
		}

		function approveTransaction(id){
			if(!confirm('Approve this transaction?'))return;
			$.ajax({url:'/Stock_Transfer/approve?id='+id,type:'POST',dataType:'json',
				success:function(r){if(r.status==='success'){toast('Approved!','success');setTimeout(function(){window.location.href='/Stock_Transfer/activity_list';},1500);}else{toast(r.msg||'Failed','error');}},
				error:function(){toast('Server error','error');}});
		}

		function rejectTransaction(id){
			var note=prompt('Rejection reason:','');if(note===null)return;
			$.ajax({url:'/Stock_Transfer/reject?id='+id,type:'POST',data:{note:note},dataType:'json',
				success:function(r){if(r.status==='success'){toast('Rejected','info');setTimeout(function(){window.location.href='/Stock_Transfer/activity_list';},1500);}else{toast(r.msg||'Failed','error');}},
				error:function(){toast('Server error','error');}});
		}

		function fmt2(n){ return Number(n).toLocaleString('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2}); }
		function toast(msg,type){
			var ic={success:'fa-check-circle',warning:'fa-triangle-exclamation',danger:'fa-circle-xmark',info:'fa-circle-info'};
			var t=$('<div class="t-item t-'+(type||'info')+'"><i class="fa-solid '+ic[type||'info']+'"></i>'+msg+'</div>');
			$('#toast-c').append(t);
			setTimeout(function(){t.css({opacity:0,transform:'translateX(18px)',transition:'all .3s'});setTimeout(function(){t.remove();},300);},3000);
		}

		// ─── INITIALIZATION ───
		$(document).ready(function(){
			var today = new Date();
			$('#inv-date').val(today.toISOString().split('T')[0]);
			
			/*var pr_id = <?=$_GET['project']?>;
			$('#cust-sel').val(pr_id);*/
			var pr_id = <?= (int) ($_GET['project'] ?? 0) ?>;
			if (pr_id > 0) {
				$('#cust-sel').val(pr_id);
				onCustChange();
			}
			
			
			loadInitialProducts();
			updateSummary();
			
			//pevent form double submision $('#confirm-btn').click(function(e){ e.preventDefault(); submitTransaction(); });
			$('#clear-btn').click(function(){ clearForm(); });
			
			$(document).on('keydown',function(e){
				if(e.key==='Enter' && !$('#pay-panel').hasClass('open')){
					if($(e.target).is('#item-search,#e-qty')){e.preventDefault();addItem();return;}
				}
				if(e.key==='Escape'){ $('#item-dd').hide(); }
			});
			$(document).on('click',function(e){ if(!$(e.target).closest('.search-wrap').length) $('#item-dd').hide(); });
			
			// Load existing transaction for approval
			var transactionData = <?= isset($transaction) && $transaction ? json_encode($transaction) : 'null' ?>;
			var isLocked = <?= isset($is_locked) && $is_locked ? 'true' : 'false' ?>;
			if (transactionData && isLocked) {
				$('#inv-number').text('TRX-'+transactionData.st_activity_id);
				$('#inv-date').val(transactionData.st_act_date.split(' ')[0]);
				$('#int-rem').val(transactionData.note||'');
				if(transactionData.act_type==='pro_issue'){ $('#warehouse').val(transactionData.store_id).prop('disabled',true); $('#cust-sel').val(transactionData.cus_id).prop('disabled',true); }
				else if(transactionData.act_type==='transfer'){ $('#warehouse').val(transactionData.store_id).prop('disabled',true); $('#to_warehouse').val(transactionData.to_store_id).prop('disabled',true); }
				else if(transactionData.act_type==='return'){ $('#warehouse').val(transactionData.store_id).prop('disabled',true); $('#cust-sel').val(transactionData.cus_id).prop('disabled',true); }
				if(transactionData.items&&transactionData.items.length){
					items = transactionData.items.map(function(item){ return {productId:item.product_id,code:item.product_code||'',name:item.product_name||'',icon:'📦',unit:'pcs',qty:parseFloat(item.qty),isSerial:(item.is_serial_trk==1),serials:item.serial?item.serial.split(','):[],isBatch:(item.is_expiry_trk==1),batchId:item.batch_id,batchNo:null}; });
					renderTable();updateSummary();
				}
				$('#warehouse, #to_warehouse, #cust-sel, #inv-date, #int-rem, #item-search').prop('disabled',true);
				$('.add-btn, .del-btn, .ti-input').prop('disabled',true);
				$('.entry-inline button').prop('disabled',true);
				$('.entry-bar').hide();
				$('#items-locked').css('display','flex').html('<i class="fa-solid fa-lock"></i><span>Transaction is pending approval - Read Only Mode</span>');
			}
		});
	
	</script>