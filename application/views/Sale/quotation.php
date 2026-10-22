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

	.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:18px 10px;min-height:calc(100vh - var(--header-h));padding-bottom:60px;}

	.pg-hdr{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:18px;gap:14px;flex-wrap:wrap;margin-top:20px}
	.pg-hdr h1{font-size:19px;font-weight:800;color:var(--text-dark);letter-spacing:-.3px;}
	.inv-meta{display:flex;align-items:center;gap:8px;margin-top:5px;flex-wrap:wrap;}
	.inv-num{display:inline-flex;align-items:center;gap:5px;background:var(--primary-light);border:1px solid var(--primary-mid);border-radius:var(--r-sm);padding:3px 10px;font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:600;color:var(--primary);}
	.status-pill{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;}
	.st-draft{background:#f0f0f0;color:#6c757d;}.st-pending{background:var(--accent-light);color:#b45309;}.st-done{background:var(--success-light);color:#065f46;}
	.st-quote{background:var(--teal-light);color:#0f766e;}
	.wf-steps{display:flex;align-items:center;}
	.wf-s{display:flex;align-items:center;gap:5px;font-size:11px;font-weight:600;padding:3px 8px;color:var(--text-muted);}
	.wf-s::after{content:'›';margin-left:4px;color:#ccc;font-size:13px;}
	.wf-s:last-child::after{display:none;}
	.wf-s.done{color:var(--success);}.wf-s.active{color:var(--primary);font-weight:700;}

	.card{background:var(--card-bg);border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--shadow-sm);overflow:visible;margin-bottom:14px;}
	.card-head{padding:13px 17px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:9px;background:var(--card-bg);border-radius:var(--r-md) var(--r-md) 0 0;}
	.sec-icon{width:28px;height:28px;border-radius:var(--r-sm);background:var(--primary-light);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:13px;flex-shrink:0;}
	.card-head h6{font-size:13px;font-weight:700;color:var(--text-dark);margin:0;}

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

	.g{display:grid;gap:12px;}
	.g2{grid-template-columns:1fr 1fr;}
	.g3{grid-template-columns:1fr 1fr 1fr;}
	.gc-full{grid-column:1/-1;}

	.cust-bar{background:linear-gradient(135deg,var(--primary-light),#f0f4ff);border:1.5px solid var(--primary-mid);border-radius:var(--r-md);padding:13px 16px;margin-top:11px;display:none;}
	.cust-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px;}
	.ci-item .lbl2{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:2px;}
	.ci-item .val{font-size:13px;font-weight:600;color:var(--text-dark);}
	.cr-bar-w{flex:1;height:5px;background:#e2e8f0;border-radius:10px;overflow:hidden;margin-top:4px;}
	.cr-bar-f{height:100%;border-radius:10px;background:linear-gradient(90deg,var(--success),#34d399);}
	.cr-bar-f.warn{background:linear-gradient(90deg,var(--warning),#fbbf24);}
	.cr-bar-f.bad{background:linear-gradient(90deg,var(--danger),#f87171);}

	.entry-bar{background:var(--table-head);border:1.5px dashed var(--primary-mid);border-radius:var(--r-md);padding:13px 16px;}
	.entry-inline{display:flex;align-items:flex-end;gap:10px;flex-wrap:nowrap;}
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

	.ef{display:flex;flex-direction:column;gap:4px;}
	.ef-search{flex:2 1 220px;min-width:0;}
	.ef-price{flex:0 0 130px;}
	.ef-qty{flex:0 0 80px;}
	.ef-fi{flex:0 0 100px;}
	.ef-disc{flex:0 0 80px;}
	.ef-btn{flex:0 0 auto;padding-bottom:1px;}
	.fi-input{width:100%;padding:8px 10px;border:1.5px solid #fde68a;border-radius:var(--r-sm);font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:700;text-align:center;background:#fffbeb;color:#92400e;outline:none;}
	.fi-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(245,158,11,.1);}

	.add-btn{padding:8px 16px;background:var(--primary);color:#fff;border:none;border-radius:var(--r-sm);font-weight:700;font-size:13px;cursor:pointer;white-space:nowrap;font-family:inherit;display:flex;align-items:center;gap:6px;transition:all var(--tr);}
	.add-btn:hover{background:var(--primary-d);transform:translateY(-1px);}

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

	.spec-row{background:#fff;border:1.5px solid var(--card-border);border-radius:var(--r-sm);padding:10px 12px;margin-top:8px;display:none;}
	.spec-row.show{display:block;}
	.sr-tag{display:inline-flex;align-items:center;gap:5px;padding:3px 8px;border-radius:4px;font-size:11px;font-weight:700;margin-bottom:6px;}
	.sr-serial{background:var(--purple-light);color:#6d28d9;}
	.sr-batch{background:var(--teal-light);color:#0f766e;}
	.sr-expiry{background:var(--orange-light);color:#c2410c;}
	.sr-warranty{background:var(--success-light);color:#065f46;}

	.serial-chips{display:flex;flex-wrap:wrap;gap:5px;margin-top:6px;min-height:28px;padding:4px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);background:#fff;}
	.s-chip{display:inline-flex;align-items:center;gap:5px;background:var(--purple-light);color:#5b21b6;border-radius:4px;padding:2px 8px;font-size:11px;font-weight:600;font-family:'JetBrains Mono',monospace;}
	.s-chip button{background:none;border:none;cursor:pointer;color:#7c3aed;font-size:10px;padding:0;}
	.serial-add-row{display:flex;gap:6px;margin-top:6px;}

	.batch-option{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);cursor:pointer;margin-bottom:5px;transition:all var(--tr);}
	.batch-option:hover,.batch-option.sel{border-color:var(--teal);background:var(--teal-light);}
	.batch-option .bn{font-size:12px;font-weight:700;font-family:'JetBrains Mono',monospace;color:var(--text-dark);}
	.batch-option .bmeta{font-size:11px;color:var(--text-muted);}
	.batch-option .bstock{font-size:11px;font-weight:700;color:var(--teal);}

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
	.ti-input{width:64px;padding:5px 7px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);text-align:center;font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:700;outline:none;}
	.ti-input:focus{border-color:var(--primary);box-shadow:0 0 0 2px rgba(61,82,160,.1);}
	.fi-tbl-input{width:58px;padding:5px 6px;border:1.5px solid #fde68a;border-radius:var(--r-sm);text-align:center;font-family:'JetBrains Mono',monospace;font-size:12px;font-weight:700;outline:none;background:var(--accent-light);color:#92400e;}
	.fi-tbl-input:focus{border-color:var(--accent);}
	.del-btn{background:none;border:1.5px solid var(--danger-light);color:var(--danger);border-radius:var(--r-sm);width:26px;height:26px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all var(--tr);font-size:11px;margin-left:auto;}
	.del-btn:hover{background:var(--danger);color:#fff;border-color:var(--danger);}
	.mono{font-family:'JetBrains Mono',monospace;}
	.empty-cart{text-align:center;padding:36px 20px;color:var(--text-muted);}
	.empty-cart i{font-size:38px;opacity:.25;display:block;margin-bottom:8px;margin-left:47%;}
	.empty-cart p{font-size:13px;}

	.warn-chip{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;padding:1px 6px;border-radius:3px;}
	.wc-expiry{background:var(--orange-light);color:#c2410c;}
	.wc-serial{background:var(--purple-light);color:#6d28d9;}
	.wc-batch{background:var(--teal-light);color:#0f766e;}
	.wc-fi{background:var(--accent-light);color:#92400e;}
	.wc-warranty{background:var(--success-light);color:#065f46;}

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

	#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
	.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;pointer-events:auto;display:flex;align-items:center;gap:7px;box-shadow:var(--shadow-lg);animation:tIn .25s ease;max-width:310px;}
	@keyframes tIn{from{opacity:0;transform:translateX(18px)}to{opacity:1;transform:translateX(0)}}
	.t-suc{background:var(--success);color:#fff;}.t-warn{background:var(--warning);color:#fff;}.t-err,.t-danger{background:var(--danger);color:#fff;}.t-info{background:var(--primary);color:#fff;}

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

	.stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:9px;}
	.stat-box{border-radius:var(--r-sm);padding:9px;text-align:center;}
	.stat-box .sv{font-size:18px;font-weight:800;font-family:'JetBrains Mono',monospace;}
	.stat-box .sl{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);}

	.modal-backdrop{z-index:1040 !important;}
	.modal{z-index:1055 !important;}

	.cus-btn{background:#4b4b4c;color:#fff;padding:3px !important;font-size:8px !important;border-radius:5px;}
	.locked-ov{position:absolute;inset:0;background:rgba(248,250,255,.65);backdrop-filter:blur(2px);z-index:10;border-radius:var(--r-md);display:none;align-items:center;justify-content:center;flex-direction:column;gap:7px;}
	.locked-ov i{font-size:26px;color:var(--primary);opacity:.4;}
	.locked-ov span{font-size:12px;color:var(--text-muted);font-weight:600;}
	.rel{position:relative;}
</style>

<!--==========================================================================
	QUOTATION FORM
	Adapted from the Sale Invoice module. Key differences from the invoice page:
	  1. No payment collection panel — a quotation does not take payment.
	  2. Stock availability is NOT checked when adding items (see addItem()
	     below — the two blocking stock checks from the invoice version have
	     been removed on purpose, since a quotation is just a price offer and
	     should not be limited by current stock levels).
	  3. Serial-number-must-exist-in-stock validation has also been relaxed
	     to a non-blocking warning, for the same reason (quotations don't
	     reserve actual stock/serials).
	  4. Uses the SAME backend endpoints as your Sale Invoice module
	     (/Sale_invoice/get_invoice_number, /Sale_invoice/get_customers_ajax,
	     /Sale_invoice/get_products_ajax, /Sale_invoice/save_invoice,
	     /Sale_invoice/get_invoice, /Sale_invoice/print_invoice,
	     /Customer/store). The record is distinguished on the backend by the
	     hidden #mode field, which this page sets to 'QUOTATION' (or
	     'DRAFT_QUOTATION' for Save as Draft) instead of 'COMPLETED'.
	==========================================================================-->

<form id="quoform">
	<main class="main">
		<input type="hidden" name="invoice_no" id="inv-num">
		<input type="hidden" id="paid" name="paid_amount" class="bal-paid" value="0">
		<input type="hidden" id="bal" name="balance_amount" class="bal-rem" value="0"> 
		<!-- Page Header -->
		<div class="pg-hdr">
			<div>
				<h1>New Quotation</h1>
				<div class="inv-meta">
					<span class="inv-num"><i class="fa-solid fa-hashtag"></i><span id="inv-number"></span></span>
					<span class="status-pill st-draft" id="inv-status"><i class="fa-solid fa-circle" style="font-size:7px"></i> Draft</span>
					<div class="wf-steps">
						<span class="wf-s done"><i class="fa-solid fa-check"></i> Start</span>
						<span class="wf-s active" id="wf1"><i class="fa-solid fa-pencil"></i> Items</span>
						<span class="wf-s" id="wf2">Review</span>
						<span class="wf-s" id="wf3">Saved</span>
					</div>
				</div>
			</div>

			<div class="d-flex ac gap-2">
				<!--<button onclick="saveDraft()" id="drft-btn" type="button" style="padding:8px 14px;border:1.5px solid var(--card-border);border-radius:var(--r-sm);background:#fff;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--text-mid);display:flex;align-items:center;gap:5px;"><i class="fa-regular fa-floppy-disk"></i>Save as Draft</button>-->
				<button onclick="clearAll()" class="clear-frm w-100" type="button" style="padding:8px 14px;border:1.5px solid var(--danger-light);border-radius:var(--r-sm);background:#fff;font-family:inherit;font-size:12px;font-weight:600;cursor:pointer;color:var(--danger);display:flex;align-items:center;gap:5px;"><i class="fa-solid fa-trash"></i>Clear</button>
			</div>
		</div>

		<!-- GRID -->
		<div style="display:grid;grid-template-columns:1fr 290px;gap:14px;align-items:start;">

			<!-- ─── LEFT ─── -->
			<div>
				<!-- Section 1: Quotation Header -->
				<div class="card">
					<div class="card-head">
						<div class="sec-icon"><i class="fa-solid fa-file-invoice"></i></div>
						<h6>Quotation Details</h6>
					</div>
					<input type="hidden" name="quotation_no" id="inv-num">
					<input type="hidden" id="mode" name="mode" value="QUOTATION">
					<input type="hidden" name="quotation_id" id="invoiceid">
					<div class="card-body" style="padding:14px 17px;">
						<div class="g g2">
							<div>
								<label class="lbl">Customer <span style="color:var(--danger)">*</span> <span data-bs-toggle="modal" data-bs-target="#leadFormModal" class="cus-btn"><i class="fa fa-plus"></i>Add New</span></label>
								<select class="fc" id="cust-sel" name="customer_id" onchange="onCustChange()" required>
									<option value=''>— Select Customer —</option>
								</select>
							</div>
							<div>
								<label class="lbl">Quotation Date <span style="color:var(--danger)">*</span></label>
								<input type="date" class="fc" name="invoice_date" id="inv-date" required>
							</div>
							<div>
								<label class="lbl">Valid Until <span style="color:var(--danger)">*</span></label>
								<input type="date" class="fc" name="due_date" id="inv-due" required>
							</div>
							<div>
								<label class="lbl">Sales Person <span style="color:var(--danger)">*</span></label>
								<select class="fc" name="created_by" id="sales-person">
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
								<select class="fc" name="warehouse_id" id="warehouse">
									<option value="">- Warehouse -</option>
									<?php
										foreach($store as $item){
											echo"<option value='$item->store_id'>$item->store_name</option>";
										}
									?>
								</select>
							</div>
							<div>
								<label class="lbl">Price List</label>
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
						<i class="fa-solid fa-lock"></i><span>Quotation saved</span>
					</div>
					<div class="card-head">
						<div class="sec-icon"><i class="fa-solid fa-cart-plus"></i></div>
						<h6>Add Items</h6>
						<div class="ml-auto d-flex ac gap-2">
							<span class="badge b-pri" id="cnt-badge">0 items</span>
							<span class="badge b-acc" id="fi-count-badge" style="display:none"><i class="fa-solid fa-gift"></i>Free Issue</span>
						</div>
					</div>
					<div class="card-body" style="padding:14px 17px;">
						<div id="serial-hidden-container"></div>
						<div id="batch-hidden-container"></div>

						<!-- ENTRY BAR -->
						<div class="entry-bar">
							<div class="entry-inline">

								<div class="ef ef-search">
									<label class="lbl">Search Item (Name / Code / Barcode)</label>
									<div class="search-wrap">
										<input type="text" class="fc" id="item-search" placeholder="Type to search…" autocomplete="off" onkeyup="searchItems(this.value)" onkeydown="handleItemKD(event)">
										<div class="item-dd" id="item-dd"></div>
									</div>
								</div>

								<div class="ef ef-price">
									<label class="lbl">Unit Price</label>
									<div class="ig">
										<span class="ipfx">Rs.</span>
										<input type="number" class="fc" id="e-price" value="0" step="0.01" onchange="calcEntryLine()">
									</div>
								</div>

								<div class="ef ef-qty">
									<label class="lbl">Qty</label>
									<input type="number" class="fc" id="e-qty" value="1" min="1" step="1" onchange="calcEntryLine()">
								</div>

								<div class="ef ef-fi" id="fi-entry-row">
									<label class="lbl"><span class="ico">🎁</span>Free Issues</label>
									<input type="number" class="fi-input" id="e-freeissue" value="0" min="0" step="1" onchange="calcEntryLine()" placeholder="0">
								</div>

								<div class="ef ef-disc">
									<label class="lbl">
										Disc
										<?php
											$configs = $this->session->userdata('sys_config');
											if($configs['SDisc_type'] == 'Percent'){ echo"%"; } else { echo""; }
										?>
									</label>
									<div class="ig-r">
										<input type="number" class="fc" id="e-disc" value="0" min="0" max="100" onchange="calcEntryLine()">
										<span class="isfx">
											<?php
												$configs = $this->session->userdata('sys_config');
												if($configs['SDisc_type'] == 'Percent'){ echo"%"; } else { echo""; }
											?>
										</span>
									</div>
								</div>

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

							<!-- EXTRA ENTRY OPTIONS -->
							<div class="entry-extras" id="entry-extras" style="display:none;margin-top:10px;border-top:1px solid var(--card-border);padding-top:10px;">

								<!-- Serial Number Entry (informational only — not stock-checked for quotations) -->
								<div class="spec-row" id="ser-row">
									<span class="sr-tag sr-serial"><i class="fa-solid fa-barcode"></i>Serial Numbers (optional for quotation)</span>
									<div style="font-size:11px;color:var(--text-muted);margin-bottom:6px;">You may record intended serial numbers, but this is not required to save a quotation.</div>
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

								<!-- Line Preview -->
								<div id="line-prev" style="display:none;text-align:right;padding-top:8px;font-size:12px;color:var(--text-muted);">
									Billable: <strong id="line-prev-val" class="mono" style="color:var(--primary)">Rs. 0.00</strong>
									<span id="fi-prev-note" style="margin-left:10px;color:var(--accent);font-weight:700;display:none;">+ <span id="fi-prev-qty">0</span> FREE</span>
								</div>
							</div><!-- /entry-extras -->
						</div><!-- /entry-bar -->

						<!-- ITEMS TABLE -->
						<div class="tbl-wrap" style="margin-top:12px;">
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
					<div class="card-body" style="padding:14px 17px;">
						<div class="g g2">
							<div><label class="lbl">Internal Remarks</label><textarea class="fc" id="int-rem" rows="2" placeholder="Internal notes…"></textarea></div>
							<div><label class="lbl">Customer Note (printed)</label><textarea class="fc" name="remarks" id="cust-note" rows="2" placeholder="Message to customer…"></textarea></div>
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
					<div class="card-body" style="padding:14px 17px;">
						<div class="sum-box">
							<div class="sum-row"><span class="sl">Subtotal</span><span class="sv" id="sum-sub">Rs. 0.00</span></div>
							<div class="sum-row"><span class="sl">Item Discounts</span><span class="sv" style="color:var(--success)" id="sum-disc">- Rs. 0.00</span></div>
							<div class="sum-row"><span class="sl">Free Issue Value</span><span class="sv" style="color:var(--accent)" id="sum-fi">Rs. 0.00</span></div>
							<div class="divider" style="margin:8px 0;"></div>
							<div style="margin-bottom:8px;">
								<label class="lbl" style="font-size:10px;">Global Discount (%)</label>
								<div style="display:grid;grid-template-columns:1fr 70px;gap:5px;align-items:center;">
									<input type="number" class="fc" name="dis_val" id="g-disc" value="0" min="0" max="100" placeholder="%" onchange="calcTotals()" style="font-size:12px;padding:6px 9px;">
									<span class="mono" id="g-disc-val" style="font-size:12px;color:var(--success);text-align:right;">- Rs. 0.00</span>
								</div>
							</div>
							<div class="sum-row">
								<span class="sl">Tax (<?php $configs = $this->session->userdata('sys_config');echo $configs['Vat_rate'];?> % VAT)</span>
								<span class="sv" id="sum-tax">Rs. 0.00</span>
							</div>
							<div class="divider" style="margin:8px 0;"></div>
							<div class="sum-row sum-total"><span class="sl">TOTAL</span><span class="sv" id="sum-total">Rs. 0.00</span></div>
						</div>

						<div style="display:flex;align-items:center;gap:10px;margin-top:9px;flex-wrap:wrap;">
							<label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:12px;font-weight:600;color:var(--text-mid);">
								<input type="checkbox" id="tax-chk" onchange="calcTotals()" style="accent-color:var(--primary);">Apply VAT
							</label>
						</div>

						<button class="confirm-btn mt-3" type="button" id="confirm-btn" onclick="saveQuotationFinal()">
							<i class="fa-solid fa-check-circle"></i>Save Quotation<span class="kbd">Enter</span>
						</button>
					</div>
				</div>

				<!-- Quick Stats -->
				<div class="card">
					<div class="card-body" style="padding:13px;">
						<span class="sec-lbl" style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);display:block;margin-bottom:8px;">Quotation Stats</span>
						<div class="stats-grid">
							<div class="stat-box" style="background:var(--primary-light);">
								<div class="sv" style="color:var(--primary);" id="stat-items">0</div>
								<div class="sl">Items</div>
							</div>
							<div class="stat-box" style="background:var(--success-light);">
								<div class="sv" style="color:var(--success);" id="stat-qty">0</div>
								<div class="sl">Total Qty</div>
							</div>
							<div class="stat-box" style="background:var(--accent-light);">
								<div class="sv" style="color:#92400e;font-size:14px;" id="stat-fi">0</div>
								<div class="sl">Free Qty</div>
							</div>
							<div class="stat-box" style="background:var(--info-light);">
								<div class="sv" style="color:#0369a1;font-size:14px;" id="stat-saved">0.00</div>
								<div class="sl">Saved</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- /RIGHT -->
		</div>
	</main>

	<!-- Hidden totals passed to backend -->
	<input type="hidden" id="subtot" name="subtotal" class="sum-sub">
	<input type="hidden" id="lidis" name="line_discount_total" class="sum-disc">
	<input type="hidden" id="bildis" name="bill_discount_value" class="g-disc-val">
	<input type="hidden" id="taxtot" name="tax_total" class="sum-tax">
	<input type="hidden" id="totqty" name="total_qty" class="stat-qty">
	<input type="hidden" id="totfrqty" name="total_free_qty" class="stat-fi">
	<input type="hidden" id="gtl" name="grand_total" class="bal-total">

	<!-- ─── SUCCESS OVERLAY ─── -->
	<div class="suc-ov" id="suc-ov">
		<div class="suc-card">
			<div class="suc-icon"><i class="fa-solid fa-check"></i></div>
			<h3>Quotation Saved!</h3>
			<p>The quotation has been recorded successfully.</p>
			<div class="suc-meta">
				<div class="suc-meta-row"><span style="color:var(--text-muted)">Quotation No.</span><span class="mono fw-700" id="suc-inv"></span></div>
				<div class="suc-meta-row"><span style="color:var(--text-muted)">Total</span><span class="mono fw-700" id="suc-total"></span></div>
			</div>
			<div class="suc-actions">
				<button class="btn-print" type="button" onclick="printQuotation()"><i class="fa-solid fa-print"></i>Print</button>
				<button class="btn-new" type="button" onclick="newQuotation()"><i class="fa-solid fa-plus"></i>New Quotation</button>
			</div>
		</div>
	</div>

	<div id="toast-c"></div>
</form>

<div class="modal" tabindex="-1" role="dialog" id="leadFormModal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<form id="leadForm">
					<div class="modal-header">
						<h6 class="modal-title" id="leadModalTitle">New Customer</h6>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="lead_id" name="lid">
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Customer Name *</label>
								<input type="text" name="name" id="name" class="form-control" required maxlength="100" pattern="[A-Za-z\s]+" title="Please enter letters and spaces only">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Email</label>
								<input type="email" name="email" id="email" class="form-control" title="Please enter a valid email address">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Phone One *</label>
								<input type="text" name="phone" id="phone" class="form-control" required pattern="[0-9+\-\s]{10,15}" title="Please enter a valid phone number (10-15 digits)">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Phone Two</label>
								<input type="text" name="phone_two" id="phone_two" class="form-control" pattern="[0-9+\-\s]{10,15}" title="Please enter a valid phone number (10-15 digits)">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label">Address *</label>
								<textarea name="address" id="address" class="form-control" rows="1" maxlength="255" required></textarea>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Company Name</label>
								<input type="text" name="company_name" id="company_name" class="form-control" maxlength="100" pattern="[A-Za-z\s]+" title="Please enter letters and spaces only">
							</div>
						</div>
						
						
						<h6 class="fw-bold mb-3 mt-2">Credit Details</h6>
							
						<div class="row">
							<div class="col-md-12 mb-3">
								<label class="form-label d-block">Enable Credit?</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input is_credit" type="radio" name="is_credit" id="credit_yes" value="1">
									<label class="form-check-label" for="credit_yes">Yes</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input is_credit" type="radio" name="is_credit" id="credit_no" value="0" checked>
									<label class="form-check-label" for="credit_no">No</label>
								</div>
							</div>
						</div>

						<div class="row" id="credit_fields" style="display: none;">
							<div class="col-md-6 mb-3">
								<label class="form-label">Current Credit Amount:</label>
								<input type="number" step="0.01" name="current_credit_amt" id="current_credit_amt" class="form-control" placeholder="0.00">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">Max Credit Limit:</label>
								<input type="number" step="0.01" name="max_credit_limit" id="max_credit_limit" class="form-control" placeholder="0.00">
							</div>
						</div>
						
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light close-btn" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" id="btn-sub"><i class="ri-save-line me-1"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- ─── JAVASCRIPT ─── -->
<script>

	var enble_tax = <?php echo (int)$configs['sale_tax']; ?>;
	if (enble_tax == 0) {
		$('#tax-chk').prop('disabled', true).css({'background-color':'#f5f5f5','color':'#6c757d','cursor':'not-allowed'});
	}

	var Free_issue = <?php echo (int)$configs['Free_issue']; ?>;
	if (Free_issue == 0) {
		$('#e-freeissue').prop('readonly', true).css({'background-color':'#f5f5f5','color':'#6c757d','cursor':'not-allowed'});
	}

	var l_disc = <?php echo (int)$configs['Sale_l_disc']; ?>;
	if (l_disc == 0) {
		$('#e-disc').prop('readonly', true).css({'background-color':'#f5f5f5','color':'#6c757d','cursor':'not-allowed'});
	}

	var bill_disc = <?php echo (int)$configs['Sale_b_disc']; ?>;
	if (bill_disc == 0) {
		$('#g-disc').prop('readonly', true).css({'background-color':'#f5f5f5','color':'#6c757d','cursor':'not-allowed'});
	}

	$(document).on('click', '#btnOpenLeadForm', function() {
		$('#leadFormModal').modal({backdrop:'static',keyboard:false}).modal('show');
	});

	// Uses the same invoice-number generator as the Sale Invoice module
	function newquoid(){
		$.ajax({
			url: "/Sale_invoice/get_invoice_number",
			type: "GET",
			dataType: "json",
			success: function(response){
				$('#inv-number').text(response);
				$('#inv-num').val(response);
			},
			error: function(xhr, status, error){
				console.error("AJAX Error Status:", status);
			}
		});
	}

	var CUSTOMERS = {};
	var SELECTED_CUSTOMER = null;
	var DEFAULT_CASH_CUSTOMER = null;

	function cus(selectedCustomer = null) {
		if (selectedCustomer !== null) { SELECTED_CUSTOMER = selectedCustomer; }

		$.ajax({
			url: "/Sale_invoice/get_customers_ajax",
			type: "GET",
			dataType: "json",
			success: function(response) {
				CUSTOMERS = response;
				let options = '<option value="">— Select Customer —</option>';

				$.each(CUSTOMERS, function(id, customer) {
					if (parseInt(customer.is_cash_customer) === 1) { DEFAULT_CASH_CUSTOMER = String(id); }
					options += `<option value="${id}">${customer.name}</option>`;
				});

				$('#cust-sel').html(options);

				let toSelect = '';
				if (SELECTED_CUSTOMER !== null && SELECTED_CUSTOMER !== '') { toSelect = String(SELECTED_CUSTOMER); }
				else if (DEFAULT_CASH_CUSTOMER !== null) { toSelect = DEFAULT_CASH_CUSTOMER; }

				if (toSelect !== '') { $('#cust-sel').val(toSelect); $('#cust-sel').trigger('change'); }
			},
			error: function(xhr, status, error) { console.error(error); }
		});
	}

	var PRODUCTS = [];
	function prod(){
		$.ajax({
			url: "/Sale_invoice/get_products_ajax",
			type: "GET",
			dataType: "json",
			success: function(res) { PRODUCTS = res; },
			error: function(err) { console.error("Error loading products:", err); }
		});
	}

	var items = [];
	var saved = false;
	var curCustomer = null;
	var selProduct = null;
	var serialsForEntry = [];
	var selBatch = null;

	<?php if (!empty($_GET['id'])): ?>
		// Load an existing quotation for editing — uses the same get_invoice
		// action as the Sale Invoice module (records are distinguished by mode)
		var quotationId = "<?= htmlspecialchars($_GET['id'], ENT_QUOTES) ?>";

		$.getJSON("/Sale_invoice/get_invoice?id=" + quotationId, function(res) {
			$('#inv-num').val(res.invoice.invoice_no);
			$('#inv-number').text(res.invoice.invoice_no);
			cus(res.invoice.customer_id);
			$('#sales-person').val(res.invoice.created_by);
			$('#warehouse').val(res.invoice.warehouse_id);
			$('#invoiceid').val(res.invoice.id);
			$('#g-disc').val(res.invoice.dis_val);
			$('.item-dd').hide();
			$('#drft-btn').prop('disabled', true);

			items = mapToInvoiceItems(res.items);
			renderTable();
			calcTotals();
			appendHiddenInputs(items);
			$('#item-dd').hide();
			clearProdPanel();
		});
	<?php endif; ?>

	function mapToInvoiceItems(dbItems) {
		return dbItems.map(function(i){
			return {
				productId: i.id.replace('P',''),
				code: i.code || '',
				name: i.name,
				icon: i.icon || '📦',
				unit: i.unit,
				price: parseFloat(i.retailPrice || 0),
				qty: i.qty,
				disc: i.discount_value,
				freeIssue: 0,
				isSerial: i.isSerial == 1,
				isBatch: i.isBatch == 1,
				hasExpiry: i.hasExpiry == 1,
				expDate: null,
				hasWarranty: i.hasWarranty == 1,
				warrantyMonths: i.warrantyMonths || 0,
				warrantyType: i.warrantyType || 'manufacturer',
				batchId: null,
				batchNo: (i.batches && i.batches.length) ? i.batches[0].batchNo : null,
				serials: i.serials || []
			};
		});
	}

	function appendHiddenInputs(items) {
		let container = $('#serial-hidden-container');
		container.empty();

		items.forEach(function(item, index){
			container.append(`
				<input type="hidden" name="items[${index}][product_id]" value="${item.productId}">
				<input type="hidden" name="items[${index}][qty]" value="${item.qty}">
			`);
			if (item.serials && item.serials.length) {
				item.serials.forEach(function(sn){
					container.append(`<input type="hidden" name="serials[${item.productId}][]" value="${sn}">`);
				});
			}
			if (item.batchNo) {
				container.append(`<input type="hidden" name="items[${index}][batch_no]" value="${item.batchNo}">`);
			}
		});
	}

	$(function(){
		var today = new Date();
		var fmt = function(d){ return d.toISOString().split('T')[0]; };
		$('#inv-date').val(fmt(today));
		var due = new Date(today); due.setDate(due.getDate()+14); // default validity: 14 days
		$('#inv-due').val(fmt(due));

		$(document).on('keydown', function(e){
			if (e.key==='Enter'){
				if ($(e.target).is('#item-search,#e-qty,#e-price,#e-disc,#e-freeissue')) { e.preventDefault(); addItem(); return; }
			}
			if (e.key==='Escape'){ $('#item-dd').hide(); }
		});
		$(document).on('click', function(e){ if (!$(e.target).closest('.search-wrap').length) $('#item-dd').hide(); });
		calcTotals();
	});

	function onCustChange(){
		var id = $('#cust-sel').val();
		if (!id){ $('#cust-bar').hide(); curCustomer=null; return; }
		curCustomer = CUSTOMERS[id];
		var c = curCustomer;
		var html = `
			<div class="ci-item"><div class="lbl2">Name</div><div class="val">${c.name}</div></div>
			<div class="ci-item"><div class="lbl2">Phone</div><div class="val">${c.phone}</div></div>
			<div class="ci-item"><div class="lbl2">Email</div><div class="val" style="font-size:11px">${c.email}</div></div>`;
		$('#cust-grid').html(html);
		$('#cust-bar').fadeIn(200);
	}

	// PRICE LIST
	function getPriceForProduct(p){
		if (!p) return 0;
		var pl = $('#price-list').val();
		if (pl === 'wholesale' && p.wholesalePrice != null && p.wholesalePrice !== '') return parseFloat(p.wholesalePrice);
		if (pl === 'special' && p.specialPrice != null && p.specialPrice !== '') return parseFloat(p.specialPrice);
		return parseFloat(p.price || 0);
	}

	function applyPriceList(){
		if (selProduct){ $('#e-price').val(getPriceForProduct(selProduct).toFixed(2)); calcEntryLine(); }
	}

	// ITEM SEARCH
	var searchTimer;
	function searchItems(val) {
		clearTimeout(searchTimer);
		if (val.length < 1) { $('#item-dd').hide(); clearProdPanel(); return; }

		searchTimer = setTimeout(function () {
			const keyword = val.toLowerCase();
			var res = PRODUCTS.filter(function (p) {
				const name = (p.name || '').toLowerCase();
				const code = (p.code || '').toLowerCase();
				return name.includes(keyword) || code.includes(keyword);
			});
			renderDD(res);
		}, 140);
	}

	function renderDD(prods){
		if (!prods.length){
			$('#item-dd').html('<div style="padding:12px;text-align:center;color:var(--text-muted);font-size:12px;">No items found</div>').show();
			return;
		}
		// Stock is shown for reference only — it does NOT block adding to a quotation.
		var html = prods.map(function(p){
			var sc = p.stock>10?'stk-ok':p.stock>0?'stk-low':'stk-out';
			var sl = p.stock>0?p.stock+' in stock':'Out of stock (quotable)';
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
		var stockCls = p.stock>10?'green':p.stock>0?'orange':'red';
		var pipHTML = `
		<div class="pip-item"><div class="pil">Code</div><div class="piv mono">${p.code}</div></div>
		<div class="pip-item"><div class="pil">Category</div><div class="piv">${p.category}</div></div>
		<div class="pip-item"><div class="pil">Unit</div><div class="piv">${p.unit}</div></div>
		<div class="pip-item"><div class="pil">Stock</div><div class="piv ${stockCls}">${p.stock} ${p.unit} (info only)</div></div>
		<div class="pip-item"><div class="pil">Retail Price</div><div class="piv mono">Rs. ${fmt2(p.retailPrice)}</div></div>
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

		if (p.isSerial){
			serialsForEntry = [];
			renderSerialChips();
			$('#ser-row').addClass('show');
			$('#serial-input').val('');
		} else { $('#ser-row').removeClass('show'); }

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

		if (p.hasExpiry && !p.isBatch){
			$('#expiry-info').html(`
				<div><label class="lbl">Expiry Date</label><input type="date" class="fc" id="e-expiry"></div>
				<div><label class="lbl">Mfg Date</label><input type="date" class="fc" id="e-mfgdate"></div>`);
			$('#expiry-row').addClass('show');
		} else { $('#expiry-row').removeClass('show'); }

		if (p.hasWarranty){
			$('#w-default').val(p.warrantyMonths+' months ('+p.warrantyType+')');
			$('#w-override').val(p.warrantyMonths);
			$('#w-type').val(p.warrantyType);
			$('#warranty-row').addClass('show');
		} else { $('#warranty-row').removeClass('show'); }

		$('#fi-entry-row').show();
	}

	function storeSerialInputs(){
		var container = $('#serial-hidden-container');
		container.empty();
		if (!items || !items.length) return;

		items.forEach(function(item, index){
			if (!item.isSerial) return;
			if (!item.serials || !item.serials.length) return;

			container.append(`
			  <input type="hidden" name="items[${index}][product_id]" value="${item.productId}">
			  <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
			`);
			item.serials.forEach(function(sn){
				container.append(`<input type="hidden" name="serials[${item.productId}][]" value="${sn}">`);
			});
		});
	}

	function renderSerialChips(){
		var chips = serialsForEntry.map(function(s,i){
			return `<span class="s-chip">${s}<button type="button" onclick="removeSerial(${i})"><i class="fa-solid fa-xmark"></i></button></span>`;
		}).join('');
		$('#serial-chips').html(chips||'<span style="font-size:11px;color:var(--text-muted);padding:3px 6px;">No serials entered yet</span>');
		var needed = parseInt($('#e-qty').val())||0;
		var have = serialsForEntry.length;
		var cls = have===needed?'color:var(--success)':have>needed?'color:var(--danger)':'color:var(--text-muted)';
		$('#serial-count').html(`<span style="${cls};font-weight:700;">${have} of ${needed} serials entered (optional)</span>`);
	}

	// Serial entry is informational for quotations — NOT validated against stock.
	function addSerial(){
		var val = $('#serial-input').val().trim();
		if (!val) return;
		if (serialsForEntry.includes(val)){ toast('Serial already added','warning'); return; }
		serialsForEntry.push(val);
		$('#serial-input').val('');
		renderSerialChips();
	}

	function removeSerial(i){ serialsForEntry.splice(i,1); renderSerialChips(); }

	function selectBatch(bid, el){
		selBatch = bid;
		$('.batch-option').removeClass('sel');
		$(el).addClass('sel');

		if (selProduct){
			var b = selProduct.batches.find(function(x){ return x.id === bid; });
			if (b && selProduct.hasExpiry){
				var dLeft = Math.ceil((new Date(b.expDate)-new Date())/86400000);
				var eCls = dLeft<90?'text-danger':dLeft<180?'text-warning':'text-success';
				$('#expiry-row').addClass('show');
				$('#expiry-info').html(`
				  <div class="pip-item"><div class="pil">Batch No.</div><div class="piv mono">${b.batchNo}</div></div>
				  <div class="pip-item"><div class="pil">Mfg. Date</div><div class="piv">${b.mfgDate}</div></div>
				  <div class="pip-item"><div class="pil">Expiry Date</div><div class="piv ${eCls}">${b.expDate} (${dLeft} days)</div></div>
				`);
			}
		}
	}

	function storeBatchInputs(){
		var container = $('#batch-hidden-container');
		container.empty();
		if (!items || !items.length) return;

		items.forEach(function(item, index){
			if (!item.isBatch) return;
			if (!item.batchId) return;
			container.append(`
			  <input type="hidden" name="items[${index}][batch_id]" value="${item.batchId}">
			  <input type="hidden" name="items[${index}][batch_no]" value="${item.batchNo}">
			`);
		});
	}

	// ENTRY LINE CALC
	function calcEntryLine(){
		var price = parseFloat($('#e-price').val())||0;
		var qty = parseFloat($('#e-qty').val())||0;
		var disc = parseFloat($('#e-disc').val())||0;
		var fi = parseInt($('#e-freeissue').val())||0;
		if (selProduct && selProduct.isSerial) renderSerialChips();

		var mde = '<?php $configs = $this->session->userdata('sys_config');echo $configs['SDisc_type'];?>';
		var discAmt = (mde === 'Percent') ? (price * qty * (disc / 100)) : disc;
		var total = price*qty - discAmt;

		if (price>0 && qty>0){
			$('#line-prev-val').text('Rs. '+fmt2(total));
			$('#line-prev').show();
			if (fi>0){ $('#fi-prev-qty').text(fi); $('#fi-prev-note').show(); }
			else { $('#fi-prev-note').hide(); }
		} else { $('#line-prev').hide(); }
	}

	// ADD ITEM TO QUOTATION
	// IMPORTANT: stock availability is intentionally NOT checked here.
	// A quotation is a price offer, not a stock reservation, so items can be
	// quoted regardless of current stock levels (including zero/negative stock).
	function addItem(){
		if (!selProduct){ toast('Search and select a product first','warning'); return; }

		var qty = parseFloat($('#e-qty').val())||0;
		var price = parseFloat($('#e-price').val())||0;
		var disc = parseFloat($('#e-disc').val())||0;
		var fi = parseInt($('#e-freeissue').val())||0;

		if (qty<=0){ toast('Quantity must be greater than 0','warning'); $('#e-qty').focus(); return; }
		if (price<=0){ toast('Unit price must be greater than 0','warning'); $('#e-price').focus(); return; }
		if (isNaN(fi) || fi < 0) { toast('Free Issue Qty must be 0 or greater', 'warning'); $('#e-freeissue').focus(); return; }
		if (isNaN(disc) || disc < 0) { toast('Discount amount must be 0 or greater', 'warning'); $('#e-disc').focus(); return; }

		// Serial count is informational only — a quotation can be saved even
		// if serial numbers haven't been entered or don't fully match qty.
		var batchInfo = null;
		if (selBatch && selProduct.batches){
			batchInfo = selProduct.batches.find(function(b){return b.id===selBatch;});
		}

		var warrantyMonths = parseInt($('#w-override').val())||selProduct.warrantyMonths||0;
		var warrantyType = $('#w-type').val()||selProduct.warrantyType||'manufacturer';

		var existing = items.find(function(i){
			return i.productId===selProduct.id && (!selBatch || i.batchId===selBatch);
		});

		if (existing && !selProduct.isSerial){
			existing.qty += qty;
			existing.freeIssue = (existing.freeIssue||0) + fi;
			existing.disc = disc;
			toast(selProduct.name+' updated','info');
		} else {
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
		storeSerialInputs();
		storeBatchInputs();
	}

	function resetEntry(){
		selProduct=null; serialsForEntry=[]; selBatch=null;
		$('#item-search').val('').focus();
		$('#e-qty').val(1); $('#e-price').val(0); $('#e-disc').val(0); $('#e-freeissue').val(0);
		$('#prod-info-panel').slideUp(150);
		$('#entry-extras').slideUp(150);
		$('#line-prev').hide();
		$('#ser-row,#batch-row,#expiry-row,#warranty-row').removeClass('show');
		$('#fi-entry-row').hide();
	}

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
		var len=(items.length);

		var html = items.map(function(item,idx){
			var mde = '<?php $configs = $this->session->userdata('sys_config');echo $configs['SDisc_type'];?>';
			var discAmt = (mde === 'Percent') ? (item.price*item.qty*(item.disc/100)) : item.disc;
			var lineTotal = item.price*item.qty - discAmt;
			var expiryStr='',batchStr='',serialStr='',warrantyStr='';

			if (item.isBatch && item.batchNo) batchStr=`<span class="warn-chip wc-batch"><i class="fa-solid fa-layer-group"></i>${item.batchNo}</span>`;
			if (item.hasExpiry && item.expDate){
				var dl=Math.ceil((new Date(item.expDate)-new Date())/86400000);
				var ec=dl<90?'background:var(--danger-light);color:#991b1b;':dl<180?'background:var(--warning-light);color:#92400e;':'background:var(--orange-light);color:#c2410c;';
				expiryStr=`<span class="warn-chip wc-expiry" style="${ec}"><i class="fa-solid fa-calendar-xmark"></i>Exp ${item.expDate}</span>`;
			}
			if (item.isSerial && item.serials && item.serials.length) serialStr=`<span class="warn-chip wc-serial"><i class="fa-solid fa-barcode"></i>${item.serials.length} S/N</span>`;
			if (item.hasWarranty && item.warrantyMonths) warrantyStr=`<span class="warn-chip wc-warranty"><i class="fa-solid fa-shield-halved"></i>${item.warrantyMonths}mo</span>`;
			var fiStr = item.freeIssue>0?`<span class="warn-chip wc-fi"><i class="fa-solid fa-gift"></i>+${item.freeIssue} FREE</span>`:'';

			return `<tr>
						<td style="color:var(--text-muted);font-size:11px;font-weight:700;">${idx+1}</td>
						<td>
							<div class="tbl-name">${item.icon||''} ${item.name}</div>
							<div class="tbl-sub">${item.code} · ${item.unit}${item.batchNo?(' · Batch: '+item.batchNo):''}</div>
							<div class="tbl-tags mt-1">${serialStr}${batchStr}${expiryStr}${warrantyStr}${fiStr}</div>
						</td>
						<td class="r mono">Rs. ${fmt2(item.price)}</td>
						<td class="c"><input type="number" class="ti-input" value="${item.qty}" min="0.01" step="0.01" onchange="updQty(${idx},this.value)" ${saved?'disabled':''}></td>
						<td class="c"><input type="number" class="fi-tbl-input" value="${item.freeIssue||0}" min="0" step="1" onchange="updFI(${idx},this.value)" ${saved?'disabled':''} title="Free Issue Qty"></td>
						<td class="c"><input type="number" class="ti-input" value="${item.disc}" min="0" max="100" onchange="updDisc(${idx},this.value)" ${saved?'disabled':''} style="width:55px;"></td>
						<td class="r" style="color:var(--success)"><span class="mono">Rs. ${fmt2(discAmt)}</span></td>
						<td class="r"><strong class="mono">Rs. ${fmt2(lineTotal)}</strong></td>
						<td class="c">${!saved?`<button type="button" class="del-btn" onclick="removeItem(${idx})"><i class="fa-solid fa-xmark"></i></button>`:''}</td>
						<td style="display:none;">
							<input type="hidden" name="product_id[]" value="${item.productId}">
							<input type="hidden" name="product_name[]" value="${item.name}">
							<input type="hidden" name="unit[]" value="${item.unit}">
							<input type="hidden" name="qty[]" value="${item.qty}">
							<input type="hidden" name="free_qty[]" value="${item.freeIssue||0}">
							<input type="hidden" name="unit_price[]" value="${item.price}">
							<input type="hidden" name="discount_value[]" value="${item.disc}">
							<input type="hidden" name="line_total[]" value="${lineTotal}">
							<input type="hidden" value="${len}" name="total_items">
						</td>
					</tr>`;
		}).join('');
		tbody.html(html);
	}

	function updDisc(i,v){ items[i].disc=Math.min(100,Math.max(0,parseFloat(v)||0)); renderTable(); calcTotals(); }
	function updFI(i,v){ items[i].freeIssue=Math.max(0,parseInt(v)||0); renderTable(); calcTotals(); }

	function updQty(i,v){
		var q=parseFloat(v)||0;
		if(q<=0){ toast('Qty must be > 0','warning'); return; }
		items[i].qty=q;
		renderTable();
		calcTotals();
		storeSerialInputs();
		storeBatchInputs();
	}

	function removeItem(i){
		var n = items[i].name;
		items.splice(i,1);
		renderTable();
		calcTotals();
		storeSerialInputs();
		storeBatchInputs();
		toast(n+' removed','info');
	}

	function calcTotals(){
		var sub=0, iDisc=0, fiVal=0;

		items.forEach(function(item){
			var line = item.price*item.qty;
			var mde = '<?php $configs = $this->session->userdata('sys_config');echo $configs['SDisc_type'];?>';
			var disc = (mde === 'Percent') ? (line*(item.disc/100)) : item.disc;
			sub += line; iDisc += disc;
			fiVal += item.price*(item.freeIssue||0);
		});

		var afterItemDisc = sub - iDisc;
		var gDiscPct = parseFloat($('#g-disc').val())||0;
		var gDiscAmt = afterItemDisc*(gDiscPct/100);
		var afterG = afterItemDisc - gDiscAmt;
		var taxEnabled = $('#tax-chk').is(':checked');

		const VAT_RATE = <?php $configs = $this->session->userdata('sys_config');echo $configs['Vat_rate'];?>;
		var tax = taxEnabled ? afterG * (VAT_RATE / 100) : 0;
		var total = afterG + tax;

		$('#sum-sub').text('Rs. '+fmt2(sub));
		$('.sum-sub').val(fmt2(sub));

		$('#sum-disc').text('- Rs. '+fmt2(iDisc));
		$('.sum-disc').val(fmt2(iDisc));

		$('#sum-fi').text('Rs. '+fmt2(fiVal));

		$('#g-disc-val').text('- Rs. '+fmt2(gDiscAmt));
		$('.g-disc-val').val(fmt2(gDiscAmt));

		$('#sum-tax').text('Rs. '+fmt2(tax));
		$('.sum-tax').val(fmt2(tax));

		$('#sum-total').text('Rs. '+fmt2(total));

		var totalQty = items.reduce(function(a,b){return a+b.qty;},0);
		var totalFI = items.reduce(function(a,b){return a+(b.freeIssue||0);},0);
		var savedAmt = iDisc + gDiscAmt;
		$('#stat-items').text(items.length);

		$('#stat-qty').text(fmt2(totalQty));
		$('.stat-qty').val(fmt2(totalQty));

		$('#stat-fi').text(totalFI+' units');
		$('.stat-fi').val(totalFI);

		$('#stat-saved').text(fmt2(savedAmt));

		$('.bal-total').val((total));
		$('#gtl').val(total);
		window._invTotal = total;
	}

	// SAVE QUOTATION (final)
	// Adjust the AJAX endpoint / submission mechanism to match your backend.
	function saveQuotationFinal(){
		if (!items.length){ toast('Add at least one item','warning'); return; }
		if (!$('#cust-sel').val()){ toast('Please select a customer','warning'); return; }
		if (!$('#sales-person').val()){ toast('Please select a Sales Person','warning'); return; }
		if (!$('#warehouse').val()){ toast('Please select a warehouse','warning'); return; }

		$('#mode').val('QUOTATION');
		saved = true;
		$('#items-locked').css('display','flex');
		$('#confirm-btn').prop('disabled',true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving…');
		$('#inv-status').removeClass().addClass('status-pill st-quote').html('<i class="fa-solid fa-circle" style="font-size:7px"></i> Saved');
		$('#wf1').removeClass('active').addClass('done').html('<i class="fa-solid fa-check"></i> Items');
		$('#wf2').addClass('done').html('<i class="fa-solid fa-check"></i> Review');
		$('#wf3').addClass('active').html('<i class="fa-solid fa-check"></i> Saved');
		renderTable();

		// Triggers the form's ajax_submit binding (see $(document).ready below)
		$('#quoform').trigger('submit');
	}

	function saveDraft(){
		if (!items.length){ toast('No items to save','warning'); return; }
		$('#mode').val('DRAFT_QUOTATION');
		$('#quoform').trigger('submit');
	}

	function printQuotation(){
		toast('Sending to printer…','info');
		if (typeof lastQuotationId !== 'undefined' && lastQuotationId){
			window.location.href = '/Sale_invoice/print_invoice?id=' + encodeURIComponent(lastQuotationId);
		}
	}

	function newQuotation(){
		items=[]; saved=false; curCustomer=null; selProduct=null;
		window._invTotal=0;
		$('#suc-ov').css('display','none');
		$('#cust-sel').val(''); $('#cust-bar').hide();
		$('#items-locked').css('display','none');
		$('#confirm-btn').prop('disabled',false).html('<i class="fa-solid fa-check-circle"></i> Save Quotation <span class="kbd">Enter</span>');
		$('#inv-status').removeClass().addClass('status-pill st-draft').html('<i class="fa-solid fa-circle" style="font-size:7px"></i> Draft');
		['#wf1','#wf2','#wf3'].forEach(function(s,i){$(s).removeClass('done active').text(['Items','Review','Saved'][i]);});
		$('#wf1').addClass('active').html('<i class="fa-solid fa-pencil"></i> Items');
		$('#g-disc').val(0); $('#tax-chk').prop('checked',false);
		resetEntry(); renderTable(); calcTotals();
		newquoid(); prod();
		toast('Ready for a new quotation!','success');
	}

	function clearAll(){
		if (!items.length && !$('#cust-sel').val()) return;
		newQuotation();
	}

	// ─── HELPERS ───
	function fmt2(n){ return Number(n).toLocaleString('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2}); }
	function toast(msg,type){
		var ic={success:'fa-check-circle',warning:'fa-triangle-exclamation',danger:'fa-circle-xmark',info:'fa-circle-info'};
		var t=$('<div class="t-item t-'+(type||'info')+'"><i class="fa-solid '+ic[type||'info']+'"></i>'+msg+'</div>');
		$('#toast-c').append(t);
		setTimeout(function(){t.css({opacity:0,transform:'translateX(18px)',transition:'all .3s'});setTimeout(function(){t.remove();},300);},3000);
	}

	var lastQuotationId = null;

	$(document).ready(function () {

		newquoid();
		cus();
		prod();

		// Uses the same save endpoint as the Sale Invoice module — the
		// hidden #mode field (set to QUOTATION / DRAFT_QUOTATION above)
		// tells the backend to persist this as a quotation instead of
		// a completed sale, exactly as the original saveQuotation()
		// button on the invoice page was designed to do.
		$('#quoform').ajax_submit({
			url: '/Sale_invoice/save_invoice',
			rest: false,
			callback: function(id){
				lastQuotationId = id;

				$('#suc-inv').text($('#inv-number').text());
				$('#suc-total').text('Rs. '+fmt2(window._invTotal||0));
				$('#suc-ov').css('display','flex');

				const cleanUrl = window.location.origin + window.location.pathname;
				window.history.replaceState({}, document.title, cleanUrl);
			}
		});

		$('.clear-frm').click(function(){
			if (typeof $.confirmBox === 'function'){
				$.confirmBox({
					title: 'Clear Quotation',
					head: 'Are you sure?',
					para: 'Current quotation data will be lost.',
					onConfirm: function(close){
						$('#cust-sel').val('');
						$('#sales-person').val('');
						$('#warehouse').val('');
						newQuotation();
						close();
					}
				});
			} else {
				newQuotation();
			}
		});

		// Customer quick-add form
		$('#leadForm').ajax_submit({
			url : '/Customer/store',
			rest: false,
			callback : function(id){
				if(id!=''){
					$('#leadForm')[0].reset();
					cus();
					prod();
				}
			}
		});
	});

</script>
