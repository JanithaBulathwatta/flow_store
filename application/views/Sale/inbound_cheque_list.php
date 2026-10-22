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
	  --slate:#64748b;--slate-light:#f1f5f9;
	  --sidebar-bg:#1a1f36;--sidebar-text:#a8b4d8;
	  --page-bg:#f2f4fa;--card-border:#e4e9f4;
	  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
	  --input-border:#d1d9e6;--table-head:#f7f9ff;
	  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.10);--sh-lg:0 8px 32px rgba(61,82,160,.14);
	  --r-sm:8px;--r-md:12px;--r-lg:16px;
	  --sidebar-w:240px;--header-h:60px;--tr:.18s cubic-bezier(.4,0,.2,1);
	}
	*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
	body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;}
	::-webkit-scrollbar{width:5px;}::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

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

	.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:20px 22px;}

	/* BUTTONS */
	.btn{padding:8px 15px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;transition:all var(--tr);display:inline-flex;align-items:center;gap:6px;}
	.btn-primary{background:var(--primary);color:#fff;}
	.btn-primary:hover{background:var(--primary-d);transform:translateY(-1px);}
	.btn-success{background:var(--success);color:#fff;}
	.btn-success:hover{background:var(--success-d);transform:translateY(-1px);}
	.btn-danger{background:var(--danger);color:#fff;}
	.btn-outline{background:#fff;color:var(--text-mid);border:1.5px solid var(--card-border);}
	.btn-outline:hover{border-color:var(--primary);color:var(--primary);}
	.btn-sm{padding:6px 12px;font-size:12px;}

	/* FORM */
	.fc{width:100%;padding:8px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;background:#fff;transition:border-color var(--tr),box-shadow var(--tr);}
	.fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.09);}
	.fc::placeholder{color:var(--text-muted);}
	.form-row{margin-bottom:12px;}
	.form-lbl{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-mid);display:block;margin-bottom:4px;}
	.form-lbl span{color:var(--danger);}
	.g2{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
	.err-msg{font-size:11px;color:var(--danger);font-weight:600;margin-top:3px;display:none;}

	/* STAT STRIP */
	.stat-strip{display:grid;grid-template-columns:repeat(6,1fr);gap:10px;margin-bottom:14px;}
	.stat-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);padding:13px 15px;box-shadow:var(--sh-sm);position:relative;overflow:hidden;cursor:pointer;transition:all var(--tr);}
	.stat-card:hover{transform:translateY(-1px);box-shadow:var(--sh-md);}
	.stat-card.active-filter{box-shadow:0 0 0 2px var(--primary),var(--sh-md);}
	.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
	.sc-val{font-size:19px;font-weight:800;font-family:'JetBrains Mono',monospace;line-height:1;}
	.sc-lbl{font-size:10px;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-top:3px;}
	.sc-sub{font-size:10px;margin-top:4px;color:var(--text-muted);}

	/* SEARCH / FILTERS BAR */
	.filters-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);margin-bottom:14px;overflow:hidden;}
	.filters-top{padding:10px 14px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;border-bottom:1px solid var(--card-border);}
	.filters-bottom{padding:10px 14px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
	.sw{position:relative;flex:1;min-width:200px;}
	.sw i.ic{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;pointer-events:none;}
	.sw input{width:100%;padding:8px 30px 8px 30px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr);}
	.sw input:focus{border-color:var(--primary);}
	.sw input::placeholder{color:var(--text-muted);}
	.sw .clr{position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:12px;display:none;padding:2px;}
	.fsel{padding:7px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;font-weight:600;color:var(--text-dark);outline:none;background:#fff;cursor:pointer;}
	.fsel:focus{border-color:var(--primary);}
	.finp{padding:7px 10px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:12px;color:var(--text-dark);outline:none;background:#fff;width:138px;}
	.finp:focus{border-color:var(--primary);}
	.t-div{width:1px;height:20px;background:var(--card-border);flex-shrink:0;}
	.rc{font-size:12px;color:var(--text-muted);font-weight:600;white-space:nowrap;}
	.flbl{font-size:11px;font-weight:700;color:var(--text-muted);white-space:nowrap;}

	/* STATUS PILLS */
	.pill-row{display:flex;gap:6px;flex-wrap:wrap;}
	.fpill{padding:4px 11px;border-radius:20px;font-size:11px;font-weight:700;cursor:pointer;border:1.5px solid var(--card-border);background:#fff;color:var(--text-muted);transition:all var(--tr);white-space:nowrap;}
	.fpill:hover,.fpill.act{border-color:var(--primary);background:var(--primary-light);color:var(--primary);}

	/* TABLE */
	.table-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;}
	.tc-head{padding:11px 16px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:8px;}
	.tc-head h6{font-size:13px;font-weight:700;margin:0;flex:1;}
	.tbl{width:100%;border-collapse:collapse;}
	.tbl th{padding:9px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);border-bottom:2px solid var(--card-border);background:var(--table-head);white-space:nowrap;text-align:left;}
	.tbl th.r{text-align:right;}
	.tbl td{padding:10px 12px;font-size:13px;border-bottom:1px solid var(--card-border);vertical-align:middle;}
	.tbl tbody tr:last-child td{border-bottom:none;}
	.tbl tbody tr:hover td{background:#fafbff;}
	.tbl td.r{text-align:right;}
	.mono{font-family:'JetBrains Mono',monospace;}

	/* STATUS BADGES */
	.st{display:inline-flex;align-items:center;gap:3px;padding:3px 8px;border-radius:20px;font-size:10px;font-weight:800;white-space:nowrap;}
	.st-Pending{background:var(--primary-light);color:var(--primary);}
	.st-OnHold{background:var(--warning-light);color:#92400e;}
	.st-Deposited{background:var(--info-light);color:#0369a1;}
	.st-Cleared{background:var(--success-light);color:#065f46;}
	.st-Banked{background:var(--teal-light);color:#0f766e;}
	.st-Bounced{background:var(--danger-light);color:#991b1b;}
	.st-Returned{background:var(--orange-light);color:#c2410c;}
	.st-Replaced{background:var(--slate-light);color:var(--slate);}
	.st-Cancelled{background:var(--slate-light);color:var(--slate);}

	/* TYPE BADGE */
	.tb{display:inline-flex;align-items:center;gap:3px;padding:2px 7px;border-radius:4px;font-size:10px;font-weight:700;}
	.tb-Sale{background:var(--primary-light);color:var(--primary);}
	.tb-PR{background:var(--orange-light);color:#c2410c;}
	.tb-Advance{background:var(--purple-light);color:#6d28d9;}
	.tb-Other{background:var(--slate-light);color:var(--slate);}

	/* DUE BADGE */
	.due{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:var(--r-sm);font-size:11px;font-weight:700;font-family:'JetBrains Mono',monospace;white-space:nowrap;}
	.due-far{background:var(--info-light);color:#0369a1;}
	.due-soon{background:var(--success-light);color:#065f46;}
	.due-warn{background:var(--warning-light);color:#92400e;}
	.due-late{background:var(--danger-light);color:#991b1b;}
	.due-done{background:var(--slate-light);color:#94a3b8;}

	/* ACTION BUTTON */
	.act-btn{display:inline-flex;align-items:center;gap:5px;padding:9px 40px 11px;border-radius:var(--r-sm);font-size:11px;font-weight:700;cursor:pointer;border:1.5px solid var(--card-border);background:#fff;color:var(--text-mid);transition:all var(--tr);white-space:nowrap;}
	.act-btn:hover{border-color:var(--primary);color:var(--primary);background:var(--primary-light);}

	/* INFO BUTTON */
	.info-btn{width:26px;height:26px;border-radius:50%;border:1.5px solid var(--primary-mid);background:var(--primary-light);color:var(--primary);display:inline-flex;align-items:center;justify-content:center;cursor:pointer;font-size:12px;transition:all var(--tr);vertical-align:middle;}
	.info-btn:hover{background:var(--primary);color:#fff;border-color:var(--primary);}

	/* MODAL */
	.modal-bg{position:fixed;inset:0;background:rgba(10,18,45,.55);z-index:500;display:none;align-items:flex-start;justify-content:center;padding:28px 16px;overflow-y:auto;}
	.modal-bg.show{display:flex;}
	.modal-box{background:#fff;border-radius:var(--r-lg);width:100%;max-width:500px;box-shadow:var(--sh-lg);animation:popIn .24s cubic-bezier(.34,1.56,.64,1);margin:auto;}
	@keyframes popIn{from{opacity:0;transform:scale(.93)}to{opacity:1;transform:scale(1)}}
	.mb-head{padding:17px 20px 0;display:flex;align-items:center;justify-content:space-between;}
	.mb-head h4{font-size:15px;font-weight:800;display:flex;align-items:center;gap:8px;}
	.mb-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:16px;width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:6px;transition:all var(--tr);}
	.mb-close:hover{background:var(--danger-light);color:var(--danger);}
	.mb-body{padding:14px 20px;}
	.mb-foot{padding:11px 20px;border-top:1px solid var(--card-border);display:flex;justify-content:flex-end;gap:8px;}

	/* Cheque info strip */
	.chq-strip{background:var(--primary-light);border:1px solid var(--primary-mid);border-radius:var(--r-sm);padding:11px 14px;margin-bottom:14px;display:grid;grid-template-columns:1fr 1fr;gap:6px 16px;}
	.cs-item .csl{font-size:10px;font-weight:700;color:var(--primary);text-transform:uppercase;letter-spacing:.4px;}
	.cs-item .csv{font-size:12px;font-weight:700;color:var(--text-dark);}

	/* Action option cards */
	.action-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:14px;}
	.ac-card{border:1.5px solid var(--card-border);border-radius:var(--r-sm);padding:10px 8px;text-align:center;cursor:pointer;transition:all var(--tr);background:#fff;}
	.ac-card:hover{border-color:var(--primary);background:var(--primary-light);}
	.ac-card.selected{border-width:2px;}
	.ac-card i{font-size:20px;display:block;margin-bottom:5px;}
	.ac-lbl{font-size:11px;font-weight:800;display:block;}
	.ac-sub{font-size:9px;color:var(--text-muted);margin-top:2px;display:block;}

	/* Action color themes */
	.ac-banked    {--ac:#14b8a6;--ac-bg:#ccfbf1;}
	.ac-deposited {--ac:#0ea5e9;--ac-bg:#e0f2fe;}
	.ac-hold      {--ac:#f59e0b;--ac-bg:#fef3c7;}
	.ac-return    {--ac:#f97316;--ac-bg:#ffedd5;}
	.ac-replace   {--ac:#8b5cf6;--ac-bg:#ede9fe;}
	.ac-bounced   {--ac:#ef4444;--ac-bg:#fee2e2;}
	.ac-card.selected{border-color:var(--ac)!important;background:var(--ac-bg)!important;}
	.ac-card.selected i,.ac-card.selected .ac-lbl{color:var(--ac)!important;}

	/* Conditional fields */
	.cond-fields{background:var(--table-head);border:1px solid var(--card-border);border-radius:var(--r-sm);padding:12px 14px;margin-bottom:12px;}
	.cond-fields .form-row:last-child{margin-bottom:0;}

	/* TOAST */
	#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
	.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;display:flex;align-items:center;gap:7px;box-shadow:0 4px 16px rgba(0,0,0,.18);animation:tIn .2s ease;max-width:310px;}
	@keyframes tIn{from{opacity:0;transform:translateX(14px)}to{opacity:1;transform:translateX(0)}}
	.t-s{background:var(--success);color:#fff;}.t-e{background:var(--danger);color:#fff;}.t-i{background:var(--primary);color:#fff;}.t-w{background:var(--warning);color:#fff;}

	.empty-state{text-align:center;padding:48px 20px;color:var(--text-muted);}
	.empty-state i{font-size:36px;opacity:.18;display:block;margin-bottom:10px;}
</style>


<script>

	let TODAY = '';
	let CHEQUES = [];
	let CUSTOMERS = [];
	let ACCOUNTS = [];

	$.ajax({
		url: '/Sale_invoice/get_cheques',
		type: 'GET',
		dataType: 'json',
		success: function(res){

			TODAY     = res.today;
			CHEQUES   = res.cheques;
			CUSTOMERS = res.customers;
			ACCOUNTS  = res.accounts;

			console.log('TODAY', TODAY);
			console.log('CHEQUES', CHEQUES);
			console.log('CUSTOMERS', CUSTOMERS);
			console.log('ACCOUNTS', ACCOUNTS);
		
			initializePage();
			
			
		}
	});
</script>


<main class="main">

  <!-- STAT CARDS -->
  <div class="stat-strip" id="stat-strip"></div>

  <!-- FILTERS -->
  <div class="filters-card">
    <!-- Row 1: search + status pills -->
    <div class="filters-top">
      <!-- Cheque / party / bank search -->
      <div class="sw" style="min-width:220px;max-width:280px;">
        <i class="fa-solid fa-magnifying-glass ic"></i>
        <input type="text" id="s-text" placeholder="Cheque no, bank, ref…" oninput="applyFilters()">
        <button class="clr" id="s-text-clr" onclick="clearField('s-text')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <!-- Customer search -->
      <div class="sw" style="min-width:180px;max-width:240px;">
        <i class="fa-solid fa-user ic"></i>
        <input type="text" id="s-customer" placeholder="Search customer…" oninput="applyFilters()">
        <button class="clr" id="s-customer-clr" onclick="clearField('s-customer')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="t-div"></div>
      <!-- Status pills -->
      <div class="pill-row" id="pill-row"></div>
      <div class="t-div"></div>
      <span class="rc" id="rc"></span>
    </div>
    <!-- Row 2: date ranges + other filters -->
    <div class="filters-bottom">
      <span class="flbl">Received</span>
      <input type="date" class="finp" id="f-recv-from" onchange="applyFilters()">
      <span class="flbl">→</span>
      <input type="date" class="finp" id="f-recv-to" onchange="applyFilters()">
      <div class="t-div"></div>
      <span class="flbl">Due Date</span>
      <input type="date" class="finp" id="f-due-from" onchange="applyFilters()">
      <span class="flbl">→</span>
      <input type="date" class="finp" id="f-due-to" onchange="applyFilters()">
      <div class="t-div"></div>
      <select class="fsel" id="f-bank" onchange="applyFilters()">
        <option value="">All Banks</option>
      </select>
      <select class="fsel" id="f-type" onchange="applyFilters()">
        <option value="">All Types</option>
        <option value="Sale">Sale</option>
        <option value="Purchase Return">Purchase Return</option>
        <option value="Advance">Advance</option>
        <option value="Other">Other</option>
      </select>
      <button class="btn btn-outline btn-sm" style="font-size:12px;" onclick="resetFilters()"><i class="fa-solid fa-rotate-left"></i>Reset</button>
    </div>
  </div>

  <!-- TABLE -->
  <div class="table-card">
    <div class="tc-head">
      <h6><i class="fa-solid fa-money-check-dollar" style="color:var(--primary);margin-right:6px;"></i>Cheques Received</h6>
    </div>
    <table class="tbl">
      <thead><tr>
        <th>Cheque No.</th>
        <th>Customer</th>
        <th>Bank / Branch</th>
        <th>Reference</th>
        <th>Type</th>
        <th class="r">Amount</th>
        <th>Received</th>
        <th>Due Date</th>
        <th>Due In</th>
        <th>Status</th>
        <th style="text-align:center;">Action</th>
      </tr></thead>
      <tbody id="tbl-body"></tbody>
    </table>
  </div>

</main>

<!-- INFO MODAL -->
<div class="modal-bg" id="info-modal">
  <div class="modal-box" style="max-width:460px;">
    <div class="mb-head">
      <h4 id="info-title"></h4>
      <button class="mb-close" onclick="$('#info-modal').removeClass('show')"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="mb-body" id="info-body"></div>
    <div class="mb-foot">
      <button class="btn btn-outline btn-sm" onclick="$('#info-modal').removeClass('show')">Close</button>
      <button class="btn btn-primary btn-sm" id="info-update-btn" onclick="switchToUpdate()"><i class="fa-solid fa-pen-to-square"></i>Update Status</button>
    </div>
  </div>
</div>

<form id="chq-stl-frm">

	<input type="text" id="pitm_id">
	
	<!-- ACTION MODAL -->
	<div class="modal-bg" id="action-modal">
	  <div class="modal-box">
		<div class="mb-head">
		  <h4 id="modal-title"></h4>
		  <button class="mb-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
		</div>
			<div class="mb-body">
				  <!-- Cheque strip -->
				  <div class="chq-strip" id="modal-strip"></div>

				  <!-- Action selection (hidden when editing Deposited resolution) -->
				  <div id="action-select-wrap">
					<div class="form-row" style="margin-bottom:10px;">
					  <label class="form-lbl">Select Action <span>*</span></label>
					</div>
					<div class="action-grid" id="action-grid"></div>
				  </div>

				  <!-- Conditional fields per action -->
				  <div id="cond-wrap" style="display:none;">
					<!-- BANKED -->
					<div id="f-banked" class="cond-fields" style="display:none;">
					  <div class="form-row">
						<label class="form-lbl">Deposit Account <span>*</span></label>
						<select class="fc" id="" name="account_id">
						  <option value="">— Select Account —</option>
							<?php
								foreach($bnk as $item){
									echo"<option value='$item->bank_acc_id'>$item->bank_name $item->account_number</option>";
								}
							?>
						</select> 
						<div class="err-msg" id="e-account">Select an account.</div>
					  </div>
					  <div class="form-row" style="margin-bottom:0;">
						<label class="form-lbl" name="c_date">Deposit Date <span>*</span></label>
						<input type="date" class="fc" id="m-bank-date">
						<div class="err-msg" id="e-bank-date">Select a date.</div>
					  </div>
					</div>

					<!-- DEPOSITED -->
					<div id="f-deposited" class="cond-fields" style="display:none;">
					  <div class="form-row">
						<label class="form-lbl">Sent to Account <span>*</span></label>
						<select class="fc" id="" name="account_id">
							 <option value="">— Select Account —</option> 
							<?php
								foreach($bnk as $item){
									echo"<option value='$item->bank_acc_id'>$item->bank_name $item->account_number</option>";
								}
							?>
						</select>
						<div class="err-msg" id="e-dep-account">Select an account.</div>
					  </div>
					  <div class="form-row" style="margin-bottom:0;">
						<label class="form-lbl">Date Sent to Bank <span>*</span></label>
						<input type="date" class="fc"  name="c_date" id="m-dep-date">
						<div class="err-msg" id="e-dep-date">Select a date.</div>
					  </div>
					</div>

					<!-- DEPOSITED RESOLUTION (approve/bounce) — shown for Deposited cheques -->
					<div id="f-dep-resolve" class="cond-fields" style="display:none;">
					  <div class="form-row" style="margin-bottom:8px;">
						<label class="form-lbl">Bank Cleared?</label>
						<div style="display:flex;gap:8px;margin-top:4px;">
						  <button type="button" class="btn btn-outline btn-sm" id="r-cleared" onclick="setResolution('Cleared')" style="flex:1;justify-content:center;">
							<i class="fa-solid fa-circle-check" style="color:var(--success);"></i>Cleared / Approved
						  </button>
						  <button type="button" class="btn btn-outline btn-sm" id="r-bounced" onclick="setResolution('Bounced')" style="flex:1;justify-content:center;">
							<i class="fa-solid fa-ban" style="color:var(--danger);"></i>Bounced / Rejected
						  </button>
						</div>
					  </div>
					  <div class="form-row" style="margin-bottom:0;">
						<label class="form-lbl">Note</label>
						<textarea class="fc" id="m-res-note" rows="2"  placeholder="Bank reference, reason for bounce…" style="resize:none;"></textarea>
					  </div>
					</div>

					<!-- HOLD, RETURN, BOUNCED — note only -->
					<div id="f-note" class="cond-fields" style="display:none;">
					  <div class="form-row" style="margin-bottom:0;">
						<label class="form-lbl" id="note-lbl">Note <span>*</span></label>
						<textarea class="fc" id="m-note" name="note" rows="3" placeholder="" style="resize:none;"></textarea>
						<div class="err-msg" id="e-note">A note is required.</div>
					  </div>
					</div>

					<!-- REPLACE — new cheque details -->
					<div id="f-replace" class="cond-fields" style="display:none;">
					  <div style="font-size:11px;font-weight:700;color:var(--purple);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;"><i class="fa-solid fa-plus-circle"></i> New Replacement Cheque</div>
					  <div class="g2">
						<div class="form-row">
						  <label class="form-lbl">New Cheque No. <span>*</span></label>
						  <input type="text" class="fc" name="cheque_no" id="m-new-chqno" placeholder="e.g. 004922">
						  <div class="err-msg" id="e-new-chqno">Enter cheque number.</div>
						</div>
						<div class="form-row">
						  <label class="form-lbl">Amount <span>*</span></label>
						  <input type="number" class="fc" name="amount" id="m-new-amount" placeholder="0.00" step="0.01">
						  <div class="err-msg" id="e-new-amount">Enter amount.</div>
						</div>
					  </div>
					  <div class="g2">
						<div class="form-row">
						  <label class="form-lbl">Bank <span>*</span></label>
						  <input type="text" class="fc" name="bank_name" id="m-new-bank" placeholder="Bank name">
						  <div class="err-msg" id="e-new-bank">Enter bank name.</div>
						</div>
						<div class="form-row">
						  <label class="form-lbl">Branch</label>
						  <input type="text" class="fc" name="branch" id="m-new-branch" placeholder="Branch">
						</div>
					  </div>
					  <div class="form-row" style="margin-bottom:0;">
						<label class="form-lbl">New Due Date <span>*</span></label>
						<input type="date" name="chq_date" class="fc" id="m-new-due">
						<div class="err-msg" id="e-new-due">Select a due date.</div>
					  </div> 
				</div>
			  </div>

			  <div id="m-error" style="display:none;background:var(--danger-light);border-radius:var(--r-sm);padding:9px 12px;font-size:12px;color:#991b1b;font-weight:600;margin-top:8px;"></div>
			</div>
			<div class="mb-foot">
			  <button class="btn btn-outline btn-sm" onclick="closeModal()">Cancel</button>
			  <button class="btn btn-primary btn-sm" id="modal-save-btn" onclick="saveAction()"><i class="fa-solid fa-check"></i>Save</button>
			</div>
	  </div>
	</div>
</form>	

<div id="toast-c"></div>

<script>

	var activeStatus = '';
	var editingId    = null;
	var selAction    = null;
	var selResolution= null;

	/* ── INIT ── */
	/*$(function(){
	  //var banks=[...new Set(CHEQUES.map(function(c){return c.bank;}))].sort();
	  var banks=[...new Set(
			CHEQUES
				.filter(function(c){ return c.bank; })
				.map(function(c){ return c.bank; })
		)].sort();
	  $('#f-bank').append(banks.map(function(b){return '<option value="'+b+'">'+b+'</option>';}));

	  
	  ['#m-account','#m-dep-account'].forEach(function(sel){
		$(sel).append(ACCOUNTS.map(function(a){return '<option value="'+a+'">'+a+'</option>';}));
	  });

	  
	  var statuses=['All','Pending','On Hold','Deposited','Cleared','Banked','Bounced','Returned','Replaced','Cancelled'];
	  $('#pill-row').html(statuses.map(function(s,i){
		var v = s==='All'?'':s;
		return '<span class="fpill'+(i===0?' act':'')+'" data-val="'+v+'" onclick="setPill(this)">'+s+'</span>';
	  }).join(''));

	  
	  $('#m-bank-date,#m-dep-date').val(TODAY);

	  applyFilters();
	});*/
	
	function initializePage(){

		var banks=[...new Set(
			CHEQUES
				.filter(function(c){ return c.bank; })
				.map(function(c){ return c.bank; })
		)].sort();

		$('#f-bank').append(
			banks.map(function(b){
				return '<option value="'+b+'">'+b+'</option>';
			})
		);

		['#m-account','#m-dep-account'].forEach(function(sel){

			$(sel).empty();

			$(sel).append(
				ACCOUNTS.map(function(a){
					return '<option value="'+a+'">'+a+'</option>';
				})
			);
		});

		$('#m-bank-date,#m-dep-date').val(TODAY);

		applyFilters();
	}

	/* ── FILTERS ── */
	function setPill(el){
	  $('.fpill').removeClass('act');
	  $(el).addClass('act');
	  activeStatus=$(el).data('val');
	  applyFilters();
	}

	function applyFilters(){
	  //var txt     = $('#s-text').val().toLowerCase();
	  //var cust    = $('#s-customer').val().toLowerCase();
	  var txt  = ($('#s-text').val() || '').toLowerCase();
	  var cust = ($('#s-customer').val() || '').toLowerCase();
	  var recvFrom= $('#f-recv-from').val();
	  var recvTo  = $('#f-recv-to').val();
	  var dueFrom = $('#f-due-from').val();
	  var dueTo   = $('#f-due-to').val();
	  var bank    = $('#f-bank').val();
	  var type    = $('#f-type').val();

	  /* toggle clear buttons */
	  $('#s-text-clr').toggle(txt.length>0);
	  $('#s-customer-clr').toggle(cust.length>0);

	  var rows = CHEQUES.filter(function(c){
		if (activeStatus && c.status!==activeStatus)          return false;
		if (bank && c.bank!==bank)                            return false;
		if (type && c.ref_type!==type)                        return false;
		if (recvFrom && c.received_date<recvFrom)              return false;
		if (recvTo   && c.received_date>recvTo)                return false;
		if (dueFrom  && c.due_date<dueFrom)                    return false;
		if (dueTo    && c.due_date>dueTo)                      return false;
		if (txt){
		  var h=[c.cheque_no,c.bank,c.branch,c.ref_no,c.status,c.ref_type,c.note].join(' ').toLowerCase();
		  if(!h.includes(txt)) return false;
		}
		if (cust){
		  if(!c.customer.toLowerCase().includes(cust)) return false;
		}
		return true;
	  }).sort(function(a, b) {
			if (a.status === 'Pending' && b.status !== 'Pending') return -1;
			if (b.status === 'Pending' && a.status !== 'Pending') return 1;
			
			if (a.status === 'Pending' && b.status === 'Pending') {
				// Safe fallback using || '' to prevent null crashes
				var dateA = a.due_date || '';
				var dateB = b.due_date || '';
				return dateA.localeCompare(dateB);
			}
			
			if (a.status === 'Deposited' && b.status !== 'Deposited') return -1;
			if (b.status === 'Deposited' && a.status !== 'Deposited') return 1;
			
			// Safe fallback using || '' to prevent null crashes
			var recA = a.received_date || '';
			var recB = b.received_date || '';
			return recB.localeCompare(recA);
		});

	  renderStats();
	  renderTable(rows);
	  $('#rc').text(rows.length+' record'+(rows.length!==1?'s':''));
	}

	function clearField(id){
	  $('#'+id).val('');
	  $('#'+id+'-clr').hide();
	  applyFilters();
	}

	function resetFilters(){
	  $('#s-text,#s-customer,#f-recv-from,#f-recv-to,#f-due-from,#f-due-to').val('');
	  $('#f-bank,#f-type').val('');
	  $('#s-text-clr,#s-customer-clr').hide();
	  $('.fpill').removeClass('act').first().addClass('act');
	  activeStatus='';
	  applyFilters();
	}

	/* ── STATS ── */
	function renderStats(){
	  var all       = CHEQUES;
	  var pending   = all.filter(function(c){return c.status==='Pending';});
	  var deposited = all.filter(function(c){return c.status==='Deposited';});
	  var cleared   = all.filter(function(c){return c.status==='Cleared'||c.status==='Banked';});
	  var bounced   = all.filter(function(c){return c.status==='Bounced';});
	  var overdue   = pending.filter(function(c){return daysDiff(c.due_date)<0;});
	  
	  //var pendVal   = pending.reduce(function(a,c){return a+c.amount;},0);
	  //var depVal    = deposited.reduce(function(a,c){return a+c.amount;},0);
		var pendVal = pending.reduce(function(a,c){
			return a + parseFloat(c.amount || 0);
		},0);

		var depVal = deposited.reduce(function(a,c){
			return a + parseFloat(c.amount || 0);
		},0);


	  var cards=[
		{lbl:'Total',       val:all.length,        sub:'In register',            color:'#3d52a0', bc:'#3d52a0'},
		{lbl:'Pending',     val:pending.length,    sub:'Rs. '+fmtK(pendVal),    color:'#3d52a0', bc:'#3d52a0'},
		{lbl:'Deposited',   val:deposited.length,  sub:'Rs. '+fmtK(depVal),     color:'#0ea5e9', bc:'#0ea5e9'},
		{lbl:'Cleared',     val:cleared.length,    sub:'Banked/Cleared',        color:'#10b981', bc:'#10b981'},
		{lbl:'Bounced',     val:bounced.length,    sub:'Needs attention',        color:'#ef4444', bc:'#ef4444'},
		{lbl:'Overdue',     val:overdue.length,    sub:'Past due date',          color:'#92400e', bc:'#f59e0b'},
	  ];

	  $('#stat-strip').html(cards.map(function(c){
		return '<div class="stat-card">'
		  +'<div style="position:absolute;top:0;left:0;right:0;height:3px;background:'+c.bc+';"></div>'
		  +'<div class="sc-val" style="color:'+c.color+';">'+c.val+'</div>'
		  +'<div class="sc-lbl">'+c.lbl+'</div>'
		  +'<div class="sc-sub">'+c.sub+'</div>'
		+'</div>';
	  }).join(''));
	}

	/* ── TABLE ── */
	function renderTable(rows){
	  if(!rows.length){
		$('#tbl-body').html('<tr><td colspan="11"><div class="empty-state"><i class="fa-solid fa-money-check-dollar"></i><p>No cheques found.</p></div></td></tr>');
		return;
	  }
	  $('#tbl-body').html(rows.map(function(c){
		var days   = daysDiff(c.due_date);
		var due    = dueBadge(c,days);
		var stBadge= statusBadge(c.status);
		var tbBadge= typeBadge(c.ref_type);
		//var canAct = ['Pending','On Hold','Deposited','Bounced'].includes(c.status);
		var canAct = ['Pending','On Hold','Deposited','Bounced'].includes(c.status);

		return '<tr>'
		  +'<td><span class="mono" style="font-size:12px;font-weight:700;color:var(--primary);">'+c.cheque_no+'</span>'
			+(c.note?'<div style="font-size:10px;color:var(--text-muted);margin-top:2px;"><i class="fa-solid fa-note-sticky" style="font-size:9px;"></i> '+c.note+'</div>':'')
		  +'</td>'
		  +'<td style="font-weight:600;font-size:12px;">'+c.customer+'</td>'
		  +'<td><div style="font-size:12px;font-weight:600;">'+c.bank+'</div><div style="font-size:10px;color:var(--text-muted);">'+c.branch+'</div></td>'
		  +'<td><span class="mono" style="font-size:11px;color:var(--primary);font-weight:600;">'+c.ref_no+'</span></td>'
		  +'<td>'+tbBadge+'</td>'
		  +'<td class="r"><strong class="mono">'+fmt(c.amount)+'</strong></td>'
		  +'<td style="font-size:12px;color:var(--text-muted);">'+fmtDate(c.received_date)+'</td>'
		  +'<td style="font-size:12px;font-weight:600;">'+fmtDate(c.due_date)+'</td>'
		  +'<td>'+due+'</td>'
		  +'<td>'+stBadge+'</td>'
		  +'<td style="text-align:center;white-space:nowrap;">'
			+'<button class="info-btn" onclick="openInfo('+c.id+')" title="View cheque details"><i class="fa-solid fa-circle-info"></i></button>'
			+(canAct
			  ?' <button class="act-btn" onclick="openModal('+c.id+')"><i class="fa-solid fa-pen-to-square"></i>Update</button>'
			  :' <span style="font-size:11px;color:var(--text-muted);">'
				+(c.status==='Replaced'&&c.replaced_by?'→ #'+(CHEQUES.find(function(x){return x.id===c.replaced_by;})||{cheque_no:'?'}).cheque_no:'—')
			  +'</span>'
			)
		  +'</td>'
		+'</tr>';
	  }).join(''));
	}

	/* ── BADGES ── */
	function statusBadge(s){
	  var icons={Pending:'fa-clock',OnHold:'fa-pause',Deposited:'fa-paper-plane',Cleared:'fa-check-double',Banked:'fa-building-columns',Bounced:'fa-ban',Returned:'fa-rotate-left',Replaced:'fa-arrows-rotate',Cancelled:'fa-xmark'};
	  var key=s.replace(' ','');
	  return '<span class="st st-'+key+'"><i class="fa-solid '+(icons[key]||'fa-circle')+'" style="font-size:9px;"></i>'+s+'</span>';
	}
	function typeBadge(t){
	  var cls={'Sale':'tb-Sale','Purchase Return':'tb-PR','Advance':'tb-Advance','Other':'tb-Other'}[t]||'tb-Other';
	  var short={'Sale':'Sale','Purchase Return':'Purch. Ret.','Advance':'Advance','Other':'Other'}[t]||t;
	  return '<span class="tb '+cls+'">'+short+'</span>';
	}
	function dueBadge(c,days){
	  if(c.status!=='Pending'&&c.status!=='On Hold'&&c.status!=='Deposited'){
		return '<span class="due due-done">'+fmtDate(c.due_date)+'</span>';
	  }
	  var cls,label,icon;
	  if      (days>3) {cls='due-far';   label='In '+days+'d';        icon='fa-calendar';}
	  else if (days>=1){cls='due-soon';  label='In '+days+'d';         icon='fa-calendar-check';}
	  else if (days===0){cls='due-soon'; label='Today';                icon='fa-calendar-check';}
	  else if (days>=-3){cls='due-warn'; label=Math.abs(days)+'d over';icon='fa-triangle-exclamation';}
	  else              {cls='due-late'; label=Math.abs(days)+'d late';icon='fa-circle-exclamation';}
	  return '<span class="due '+cls+'"><i class="fa-solid '+icon+'" style="font-size:10px;"></i>'+label+'</span>';
	}

	/* ── INFO PANEL ── */
	var infoId = null;
	function openInfo(id){
		
		/*alert('hi');*/
		
	  //var c=CHEQUES.find(function(x){return x.id===id;});
		var c = CHEQUES.find(function(x){
			return parseInt(x.id) === parseInt(id);
		});
	  
	  if(!c) return;
	  infoId=id;

	  $('#info-title').html('<i class="fa-solid fa-money-check-dollar" style="color:var(--primary);margin-right:8px;"></i>Cheque #'+c.cheque_no);

	  var days=daysDiff(c.due_date);
	  var canAct=['Pending','On Hold','Deposited','Bounced'].includes(c.status);
	  $('#info-update-btn').toggle(canAct);

	  /* Build replaced link if applicable */
	  var replLink='';
	  if(c.replaced_by){
		//var rep=CHEQUES.find(function(x){return x.id===c.replaced_by;});
		CHEQUES.find(function(x){
			return parseInt(x.id) === parseInt(c.replaced_by);
		})
		if(rep) replLink='<div style="margin-top:6px;font-size:12px;color:var(--purple);font-weight:600;"><i class="fa-solid fa-arrows-rotate" style="font-size:10px;"></i> Replaced by Cheque #'+rep.cheque_no+' — Rs. '+fmt(rep.amount)+'</div>';
	  }

	  var html=''
		/* Amount hero */
		+'<div style="background:linear-gradient(110deg,var(--primary-light),#f8faff);border:1.5px solid var(--primary-mid);border-radius:var(--r-md);padding:14px 16px;margin-bottom:14px;display:flex;align-items:center;justify-content:space-between;">'
		  +'<div>'
			+'<div style="font-size:10px;font-weight:700;color:var(--primary);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Cheque Amount</div>'
			+'<div style="font-size:24px;font-weight:800;font-family:\'JetBrains Mono\',monospace;color:var(--primary);">Rs. '+fmt(c.amount)+'</div>'
		  +'</div>'
		  +'<div style="text-align:right;">'
			+statusBadge(c.status)
			+'<div style="margin-top:6px;">'+dueBadge(c,days)+'</div>'
		  +'</div>'
		+'</div>'

		/* Details grid */
		+'<div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">'
		  +iRow('Cheque No.',    '<span class="mono" style="font-weight:700;color:var(--primary);">'+c.cheque_no+'</span>')
		  +iRow('Bank',          c.bank)
		  +iRow('Branch',        c.branch)
		  +iRow('Customer',      '<span style="font-weight:700;">'+c.customer+'</span>')
		  +iRow('Reference',     '<span class="mono" style="color:var(--primary);font-size:11px;">'+c.ref_no+'</span>')
		  +iRow('Type',          typeBadge(c.ref_type))
		  +iRow('Received Date', fmtDate(c.received_date))
		  +iRow('Due Date',      '<span style="font-weight:700;">'+fmtDate(c.due_date)+'</span>')
		+'</div>'

		/* Timeline / history section */
		+'<div style="background:var(--table-head);border:1px solid var(--card-border);border-radius:var(--r-sm);padding:12px 14px;margin-bottom:12px;">'
		  +'<div style="font-size:10px;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px;">Timeline</div>'
		  +'<div class="info-timeline">'
			+tlItem('fa-inbox',        '#10b981', 'Received',   fmtDate(c.received_date), true)
			+(c.deposited_date?tlItem('fa-paper-plane','#0ea5e9','Deposited to Bank',fmtDate(c.deposited_date)+(c.banked_to?' — '+c.banked_to:''),false):'')
			+(c.banked_date?tlItem('fa-building-columns','#14b8a6','Banked / Cleared',fmtDate(c.banked_date)+(c.banked_to?' — '+c.banked_to:''),false):'')
			+(c.status==='Bounced'?tlItem('fa-ban','#ef4444','Bounced','Bank returned cheque',false):'')
			+(c.status==='Returned'?tlItem('fa-rotate-left','#f97316','Returned to Customer','',false):'')
			+(c.status==='Replaced'?tlItem('fa-arrows-rotate','#8b5cf6','Marked as Replaced','',false):'')
			+(c.status==='On Hold'?tlItem('fa-pause','#f59e0b','On Hold','',false):'')
		  +'</div>'
		+'</div>'

		/* Notes */
		+(c.note
		  ?'<div style="background:linear-gradient(135deg,#fef9c3,#fef3c7);border:1.5px solid #fde68a;border-radius:var(--r-sm);padding:11px 13px;">'
			+'<div style="font-size:10px;font-weight:800;color:#92400e;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;"><i class="fa-solid fa-note-sticky" style="font-size:11px;"></i> Notes</div>'
			+'<div style="font-size:13px;color:var(--text-dark);line-height:1.6;">'+c.note+'</div>'
		  +'</div>'
		  :'<div style="text-align:center;padding:10px;font-size:12px;color:var(--text-muted);"><i class="fa-solid fa-note-sticky" style="opacity:.2;margin-right:5px;"></i>No notes.</div>'
		)
		+replLink;

	  $('#info-body').html(html);
	  $('#info-modal').addClass('show');
	}

	function switchToUpdate(){
	  $('#info-modal').removeClass('show');
	  openModal(infoId);
	}

	function iRow(l,v){
	  return '<div style="background:#fff;border:1px solid var(--card-border);border-radius:6px;padding:8px 11px;">'
		+'<div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:3px;">'+l+'</div>'
		+'<div style="font-size:12px;font-weight:600;color:var(--text-dark);">'+v+'</div>'
	  +'</div>';
	}

	function tlItem(icon,color,label,sub,first){
	  return '<div style="display:flex;gap:10px;'+(first?'':'margin-top:8px;')+'">'
		+'<div style="display:flex;flex-direction:column;align-items:center;">'
		  +'<div style="width:22px;height:22px;border-radius:50%;background:'+color+';display:flex;align-items:center;justify-content:center;flex-shrink:0;">'
			+'<i class="fa-solid '+icon+'" style="font-size:10px;color:#fff;"></i>'
		  +'</div>'
		+'</div>'
		+'<div style="padding-top:2px;">'
		  +'<div style="font-size:12px;font-weight:700;color:var(--text-dark);">'+label+'</div>'
		  +(sub?'<div style="font-size:11px;color:var(--text-muted);margin-top:1px;">'+sub+'</div>':'')
		+'</div>'
	  +'</div>';
	}

	/* ── MODAL ── */
	function openModal(id){
	 // var c=CHEQUES.find(function(x){return x.id===id;});
	  var c = CHEQUES.find(function(x){
		return parseInt(x.id) === parseInt(id);
	});
	  
	if(!c) return;
	  editingId=id; selAction=null; selResolution=null;

	  /* Title */
	  $('#modal-title').html('<input type="hidden" name="payment_id" value="'+c.payment_id+'"><input type="hidden" name="id" value="'+c.id+'"><i class="fa-solid fa-pen" style="color:var(--primary);"></i>Cheque #'+c.cheque_no );

	  /* Strip */
	  $('#modal-strip').html(
		si('Party',   c.customer)+
		si('Bank',    c.bank+' / '+c.branch)+
		si('Amount',  'Rs. '+fmt(c.amount))+
		si('Due Date',fmtDate(c.due_date))+
		si('Ref.',    c.ref_no)+
		si('Status',  c.status)
	  );

	  /* Actions depending on current status */
	  var actions=[];
	  if(c.status==='Pending'||c.status==='On Hold'){
		actions=[
		  {key:'Banked',    icon:'fa-building-columns', label:'Direct Bank',  sub:'Skip deposit step',    cls:'ac-banked'},
		  {key:'Deposited', icon:'fa-paper-plane',       label:'Deposit',      sub:'Send to bank, await',  cls:'ac-deposited'},
		  {key:'On Hold',   icon:'fa-pause',             label:'Hold',         sub:'Hold with note',        cls:'ac-hold'},
		  {key:'Returned',  icon:'fa-rotate-left',       label:'Return',       sub:'Give back to customer', cls:'ac-return'},
		  {key:'Replaced',  icon:'fa-arrows-rotate',     label:'Replace',      sub:'New cheque received',   cls:'ac-replace'},
		  {key:'Bounced',   icon:'fa-ban',               label:'Bounced',      sub:'Mark as rejected',      cls:'ac-bounced'},
		];
		$('#action-select-wrap').show();
		$('#modal-save-btn').show();
		/* Hide deposit resolution */
		$('#f-dep-resolve').hide();
	  } else if(c.status==='Deposited'){
		/* Only resolution needed */
		actions=[];
		$('#action-select-wrap').hide();
		$('#cond-wrap').show();
		showCond('dep-resolve');
		$('#modal-save-btn').text('Save Result');
		/* Populate note */
		$('#m-res-note').val('');
		selAction='DepResolve';
	  } else if(c.status==='Bounced'){
		actions=[
		  {key:'Deposited', icon:'fa-paper-plane',   label:'Re-deposit',  sub:'Try again',            cls:'ac-deposited'},
		  {key:'Replaced',  icon:'fa-arrows-rotate', label:'Replace',     sub:'New cheque received',  cls:'ac-replace'},
		  {key:'Returned',  icon:'fa-rotate-left',   label:'Return',      sub:'Give back',             cls:'ac-return'},
		];
		$('#action-select-wrap').show();
		$('#modal-save-btn').show();
	  }

	  if(actions.length){
		$('#action-grid').html(actions.map(function(a){
		  return '<div class="ac-card '+a.cls+'" data-key="'+a.key+'" onclick="selAct(\''+a.key+'\',this)">'
			+'<i class="fa-solid '+a.icon+'" style="color:inherit;"></i>'
			+'<span class="ac-lbl">'+a.label+'</span>'
			+'<span class="ac-sub">'+a.sub+'</span>'
		  +'</div>';
		}).join(''));
		hideCond();
		$('#cond-wrap').hide();
	  }

	  /* Reset fields */
	  $('.err-msg').hide();
	  $('#m-error').hide();
	  $('#m-account,#m-dep-account').val('');
	  $('#m-bank-date,#m-dep-date').val(TODAY);
	  $('#m-note,#m-res-note').val('');
	  $('#m-new-chqno,#m-new-bank,#m-new-branch').val('');
	  $('#m-new-amount').val('');
	  $('#m-new-due').val('');
	  $('#r-cleared,#r-bounced').removeClass('btn-success btn-danger').addClass('btn-outline');

	  $('#action-modal').addClass('show');
	}

	function closeModal(){
	  $('#action-modal').removeClass('show');
	  editingId=null; selAction=null; selResolution=null;
	}

	function selAct(key,el){
	  selAction=key;
	  $('.ac-card').removeClass('selected');
	  $(el).addClass('selected');
	  $('#m-error').hide();
	  hideCond();
	  $('#cond-wrap').show();

	  if(key==='Banked')    showCond('banked');
	  else if(key==='Deposited') showCond('deposited');
	  else if(key==='On Hold')   {showCond('note'); $('#note-lbl').html('Reason for Hold <span>*</span>'); $('#m-note').attr('placeholder','Why is this cheque being held?');}
	  else if(key==='Returned')  {showCond('note'); $('#note-lbl').html('Reason for Return <span>*</span>'); $('#m-note').attr('placeholder','Why is this being returned to customer?');}
	  else if(key==='Bounced')   {showCond('note'); $('#note-lbl').html('Bounce Reason <span>*</span>'); $('#m-note').attr('placeholder','Bank reason, what happened?');}
	  else if(key==='Replaced')  showCond('replace');
	}

	function showCond(key){hideCond();$('#f-'+key).show();}
	function hideCond(){$('[id^="f-"]').filter('.cond-fields').hide();}

	function setResolution(r){
	  selResolution=r;
	  $('#r-cleared,#r-bounced').removeClass('btn-success btn-danger').addClass('btn-outline');
	  if(r==='Cleared') $('#r-cleared').removeClass('btn-outline').addClass('btn-success');
	  else              $('#r-bounced').removeClass('btn-outline').addClass('btn-danger');
	}

	/* ── SAVE ── */
	/*function saveAction(){
	  //var c=CHEQUES.find(function(x){return x.id===editingId;});
		var c = CHEQUES.find(function(x){
			return parseInt(x.id) === parseInt(editingId);
		});
		
		
	  if(!c) return;
	  $('#m-error').hide();

	  //Deposited resolution 
	  if(selAction==='DepResolve'){
		if(!selResolution){showErr('Select Cleared or Bounced.'); return;}
		c.status=selResolution;
		c.note=$('#m-res-note').val()||c.note;
		if(selResolution==='Cleared') c.banked_date=TODAY;
		closeModal(); applyFilters(); toast(selResolution==='Cleared'?'Cheque cleared!':'Marked as bounced.',selResolution==='Cleared'?'s':'e');
		return;
	  }

	  if(!selAction){showErr('Select an action.'); return;}

	  //Validate 
	  var ok=true;
	  if(selAction==='Banked'){
		if(!$('#m-account').val()){$('#e-account').show();ok=false;}
	  }
	  else if(selAction==='Deposited'){
		if(!$('#m-dep-account').val()){$('#e-dep-account').show();ok=false;}
		if(!$('#m-dep-date').val()){$('#e-dep-date').show();ok=false;}
	  }
	  else if(['On Hold','Returned','Bounced'].includes(selAction)){
		if(!$('#m-note').val().trim()){$('#e-note').show();ok=false;}
	  }
	  else if(selAction==='Replaced'){
		if(!$('#m-new-chqno').val()){$('#e-new-chqno').show();ok=false;}
		if(!$('#m-new-amount').val()||parseFloat($('#m-new-amount').val())<=0){$('#e-new-amount').show();ok=false;}
		if(!$('#m-new-bank').val()){$('#e-new-bank').show();ok=false;}
		if(!$('#m-new-due').val()){$('#e-new-due').show();ok=false;}
	  }
	  if(!ok) return;

	  
	  if(selAction==='Banked'){
		c.status='Banked'; c.banked_to=$('#m-account').val(); c.banked_date=$('#m-bank-date').val();
		toast('Cheque marked as Banked.','s');
	  }
	  else if(selAction==='Deposited'){
		c.status='Deposited'; c.banked_to=$('#m-dep-account').val(); c.deposited_date=$('#m-dep-date').val();
		toast('Cheque deposited — awaiting bank clearance.','i');
	  }
	  else if(selAction==='On Hold'){
		c.status='On Hold'; c.note=$('#m-note').val();
		toast('Cheque placed on hold.','w');
	  }
	  else if(selAction==='Returned'){
		c.status='Returned'; c.note=$('#m-note').val();
		toast('Cheque returned to customer.','w');
	  }
	  else if(selAction==='Bounced'){
		c.status='Bounced'; c.note=$('#m-note').val();
		toast('Cheque marked as bounced.','e');
	  }
	  else if(selAction==='Replaced'){
		c.status='Replaced'; c.note='Replaced with chq #'+$('#m-new-chqno').val();
		//Create replacement cheque 
		//var newId=Math.max.apply(null,CHEQUES.map(function(x){return x.id;}))+1;
		var newId=Math.max.apply(
			null,
			CHEQUES.map(function(x){
				return parseInt(x.id) || 0;
			})
		)+1;
		c.replaced_by=newId;
		CHEQUES.push({
		  id:newId, cheque_no:$('#m-new-chqno').val(),
		  bank:$('#m-new-bank').val(), branch:$('#m-new-branch').val()||c.branch,
		  amount:parseFloat($('#m-new-amount').val()), due_date:$('#m-new-due').val(),
		  received_date:TODAY, customer_id:c.customer_id, customer:c.customer,
		  ref_no:c.ref_no, ref_type:c.ref_type, status:'Pending',
		  note:'Replacement for chq #'+c.cheque_no,
		  banked_to:null, banked_date:null, deposited_date:null, replaced_by:null,
		});
		toast('Replacement cheque #'+$('#m-new-chqno').val()+' created.','s');
	  }

		// collect form data
		var formData = $('#chq-stl-frm').serializeArray();

		// also add dynamic JS values if needed
		formData.push({ name: 'cheque_id', value: c.id });
		formData.push({ name: 'status', value: c.status });

		$.ajax({
		  url: '/Sale_invoice/save_payment_item',
		  type: 'POST',
		  data: $.param(formData),
		  dataType: 'json',
		  success: function(res){
			if(res.status){
			  toast('Saved successfully', 's');
			  closeModal();
			  applyFilters();
			} else {
			  toast(res.message || 'Save failed', 'e');
			}
		  },
		  error: function(){
			toast('Server error', 'e');
		  }
		});
		
	  closeModal(); applyFilters();
	}*/
	
	function saveAction(e) {

		if (e) {
			e.preventDefault();
		}

		const c = CHEQUES.find(x => parseInt(x.id) === parseInt(editingId));

		if (!c) {
			showErr('Cheque record not found.');
			return;
		}

		$('#m-error').hide();
		$('.err-msg').hide();

		let valid = true;

		/* ---------------------------
		   DEPOSITED RESOLUTION
		---------------------------- */
		if (selAction === 'DepResolve') {

			if (!selResolution) {
				showErr('Please select Cleared or Bounced.');
				return;
			}

			const payload = {
				id: c.id,
				payment_id: c.payment_id,
				cheque_status: selResolution,
				note: $('#m-res-note').val().trim()
			};

			saveCheque(payload);
			return;
		}

		/* ---------------------------
		   ACTION REQUIRED
		---------------------------- */
		if (!selAction) {
			showErr('Please select an action.');
			return;
		}

		/* ---------------------------
		   VALIDATIONS
		---------------------------- */

		if (selAction === 'Banked') {

			if (!$('[name="account_id"]').first().val()) {
				$('#e-account').show();
				valid = false;
			}

			if (!$('#m-bank-date').val()) {
				$('#e-bank-date').show();
				valid = false;
			}
		}

		else if (selAction === 'Deposited') {

			if (!$('[name="account_id"]').last().val()) {
				$('#e-dep-account').show();
				valid = false;
			}

			if (!$('#m-dep-date').val()) {
				$('#e-dep-date').show();
				valid = false;
			}
		}

		else if (['On Hold', 'Returned', 'Bounced'].includes(selAction)) {

			if (!$('#m-note').val().trim()) {
				$('#e-note').show();
				valid = false;
			}
		}

		else if (selAction === 'Replaced') {

			if (!$('#m-new-chqno').val().trim()) {
				$('#e-new-chqno').show();
				valid = false;
			}

			if (
				!$('#m-new-amount').val() ||
				parseFloat($('#m-new-amount').val()) <= 0
			) {
				$('#e-new-amount').show();
				valid = false;
			}

			if (!$('#m-new-bank').val().trim()) {
				$('#e-new-bank').show();
				valid = false;
			}

			if (!$('#m-new-due').val()) {
				$('#e-new-due').show();
				valid = false;
			}
		}

		if (!valid) {
			return;
		}

		/* ---------------------------
		   PAYLOAD
		---------------------------- */

		let payload = {
			id: c.id,
			payment_id: c.payment_id,
			payment_method: 'CHEQUE',
			cheque_status: '',
			account_id: null,
			note: '',
			cheque_no: null,
			cheque_date: null,
			bank_name: null,
			amount: null,
			action: selAction
		};

		switch (selAction) {

			case 'Banked':

				payload.cheque_status = 'Cleared';
				payload.account_id = $('[name="account_id"]').first().val();
				payload.cheque_date = $('#m-bank-date').val();

				break;

			case 'Deposited':

				payload.cheque_status = 'Deposited';
				payload.account_id = $('[name="account_id"]').last().val();
				payload.cheque_date = $('#m-dep-date').val();

				break;

			case 'On Hold':

				payload.cheque_status = 'Pending';
				payload.note = $('#m-note').val().trim();

				break;

			case 'Returned':

				payload.cheque_status = 'Canclled';
				payload.note = $('#m-note').val().trim();

				break;

			case 'Bounced':

				payload.cheque_status = 'Bounced';
				payload.note = $('#m-note').val().trim();

				break;

			case 'Replaced':

				payload.cheque_status = 'Canclled';
				payload.note = 'Replaced with cheque #' + $('#m-new-chqno').val();

				payload.new_cheque = {
					cheque_no: $('#m-new-chqno').val(),
					amount: $('#m-new-amount').val(),
					bank_name: $('#m-new-bank').val(),
					branch: $('#m-new-branch').val(),
					cheque_date: $('#m-new-due').val()
				};

				break;
		}

		saveCheque(payload);
	}


	/* ==================================================
	   SAVE AJAX
	================================================== */

	function saveCheque(payload) {

		const $btn = $('#modal-save-btn');

		$btn.prop('disabled', true);

		$.ajax({
			url: '/Sale_invoice/change_status',
			method: 'POST',
			data: payload,
			dataType: 'json',

			success: function (res) {

				$btn.prop('disabled', false);

				if (!res || !res.status) {

					showErr(
						res && res.message
							? res.message
							: 'Failed to save cheque.'
					);

					return;
				}

				toast('Cheque updated successfully.', 's');

				if (typeof loadCheques === 'function') {
					loadCheques();
				} else {
					location.reload();
				}

				closeModal();
			},

			error: function (xhr) {

				$btn.prop('disabled', false);

				console.error(xhr.responseText);

				showErr(
					'Server error (' +
					xhr.status +
					'). Please try again.'
				);
			}
		});
	}

	/* ── HELPERS ── */
	function si(l,v){return '<div class="cs-item"><div class="csl">'+l+'</div><div class="csv">'+v+'</div></div>';}
	function showErr(m){$('#m-error').text(m).show();}
	//function daysDiff(d){return Math.round((new Date(d+'T00:00:00')-new Date(TODAY+'T00:00:00'))/(864e5));}
	function daysDiff(d){
		if(!d) return 0;

		return Math.round(
			(new Date(d+'T00:00:00')-
			new Date(TODAY+'T00:00:00'))/(864e5)
		);
	}
	//function fmtDate(d){return new Date(d+'T00:00:00').toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'});}
	function fmtDate(d){
		if(!d) return '-';

		return new Date(d+'T00:00:00')
		.toLocaleDateString('en-GB',{
			day:'numeric',
			month:'short',
			year:'numeric'
		});
	}
	function fmt(n){return Number(n).toLocaleString('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2});}
	function fmtK(n){return n>=1e6?(n/1e6).toFixed(2)+'M':n>=1e3?(n/1e3).toFixed(0)+'K':fmt(n);}
	
	function toast(msg,type){
	  var m={s:['t-s','fa-check-circle'],w:['t-w','fa-triangle-exclamation'],e:['t-e','fa-circle-xmark'],i:['t-i','fa-circle-info']};
	  var p=m[type]||m.i;
	  var $t=$('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i>'+msg+'</div>');
	  $('#toast-c').append($t);
	  setTimeout(function(){$t.css({opacity:0,transform:'translateX(14px)',transition:'all .3s'});setTimeout(function(){$t.remove();},300);},2800);
	}
</script>