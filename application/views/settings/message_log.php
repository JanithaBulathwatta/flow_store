<style>
	


	/* ── COMPACT CHARTS CARD ── */
	.charts-compact{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden;margin-bottom:12px;}
	.cc-head{padding:10px 16px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;gap:8px;}
	.cc-head h6{font-size:12px;font-weight:700;color:var(--text-dark);margin:0;flex:1;}
	.cc-inner{display:grid;grid-template-columns:2fr 1fr 1fr;gap:0;}
	.cc-panel{padding:12px 14px;border-right:1px solid var(--card-border);}
	.cc-panel:last-child{border-right:none;}
	.cc-panel-title{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);margin-bottom:8px;}
	.sec-icon{width:24px;height:24px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:10px;flex-shrink:0;}

	/* donut */
	.donut-wrap{display:flex;align-items:center;gap:12px;}
	.donut-legend{display:flex;flex-direction:column;gap:4px;flex:1;}
	.dl-row{display:flex;align-items:center;justify-content:space-between;gap:6px;font-size:10px;}
	.dl-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}
	.dl-lbl{flex:1;font-weight:600;color:var(--text-mid);}
	.dl-val{font-weight:800;font-family:'JetBrains Mono',monospace;color:var(--text-dark);}



	/* ── BADGES ── */
	.badge{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;}
	/* Channel */
	.ch-sms{background:#e0f2fe;color:#0369a1;}
	.ch-email{background:var(--purple-light);color:#6d28d9;}
	/* Status */
	.st-delivered{background:var(--success-light);color:#065f46;}
	.st-sent{background:var(--info-light);color:#0369a1;}
	.st-failed{background:var(--danger-light);color:#991b1b;}
	.st-pending{background:var(--warning-light);color:#92400e;}
	.st-opened{background:var(--teal-light);color:#0f766e;}
	.st-bounced{background:var(--rose-light);color:#be123c;}
	/* Type */
	.tp-system{background:var(--primary-light);color:var(--primary);}
	.tp-marketing{background:var(--orange-light);color:#c2410c;}
	.tp-auth{background:var(--danger-light);color:#991b1b;}
	.tp-custom{background:var(--success-light);color:#065f46;}
	.tp-campaign{background:var(--purple-light);color:#6d28d9;}
	.tp-transactional{background:var(--teal-light);color:#0f766e;}

	/* ── MESSAGE PREVIEW PANEL ── */
	.preview-panel{position:fixed;right:-420px;top:var(--header-h);bottom:0;width:420px;background:#fff;border-left:1px solid var(--card-border);box-shadow:var(--sh-lg);z-index:300;transition:right .3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;}
	.preview-panel.open{right:0;}
	.pp-head{padding:15px 18px;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
	.pp-head h5{font-size:14px;font-weight:800;color:var(--text-dark);}
	.pp-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:16px;}
	.pp-body{flex:1;overflow-y:auto;padding:16px 18px;}
	.pp-meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;}
	.pp-meta-item .pm-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-muted);margin-bottom:3px;}
	.pp-meta-item .pm-val{font-size:12px;font-weight:600;color:var(--text-dark);}
	.msg-bubble{background:var(--table-head);border:1.5px solid var(--card-border);border-radius:var(--r-md);padding:14px 16px;margin-top:12px;}
	.msg-bubble.sms-bubble{background:#e0f7fe;border-color:#bae6fd;}
	.msg-bubble.email-bubble{background:var(--purple-light);border-color:#ddd6fe;}
	.msg-bubble .mb-label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;}
	.msg-bubble.sms-bubble .mb-label{color:#0369a1;}
	.msg-bubble.email-bubble .mb-label{color:#6d28d9;}
	.msg-text{font-size:13px;color:var(--text-dark);line-height:1.65;}
	.msg-subject{font-size:13px;font-weight:700;color:var(--text-dark);margin-bottom:8px;padding-bottom:8px;border-bottom:1px solid #ddd6fe;}
	.divider{height:1px;background:var(--card-border);margin:12px 0;}

	/* ── CUSTOM SMS MODAL ── */
	.modal-bg{position:fixed;inset:0;background:rgba(10,18,45,.55);z-index:500;display:none;align-items:center;justify-content:center;padding:20px;}
	.modal-bg.show{display:flex;}
	.modal-box{background:#fff;border-radius:var(--r-xl);width:100%;max-width:500px;box-shadow:var(--sh-lg);animation:popIn .28s cubic-bezier(.34,1.56,.64,1);}
	@keyframes popIn{from{opacity:0;transform:scale(.9)}to{opacity:1;transform:scale(1)}}
	.mb-head{padding:18px 22px 0;display:flex;align-items:center;justify-content:space-between;}
	.mb-head h4{font-size:15px;font-weight:800;}
	.mb-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:16px;width:28px;height:28px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;transition:all var(--tr);}
	.mb-close:hover{background:var(--danger-light);color:var(--danger);}
	.mb-body{padding:16px 22px;}
	.mb-foot{padding:12px 22px;border-top:1px solid var(--card-border);display:flex;justify-content:flex-end;gap:8px;}
	.form-row{margin-bottom:13px;}
	.form-lbl{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-mid);display:block;margin-bottom:4px;}
	.form-lbl span{color:var(--danger);}
	.fc{width:100%;padding:9px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr);}
	.fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
	.fc::placeholder{color:var(--text-muted);}
	textarea.fc{resize:vertical;min-height:90px;}
	.char-count{font-size:11px;color:var(--text-muted);text-align:right;margin-top:4px;font-family:'JetBrains Mono',monospace;}

	/* ── EMPTY ── */
	.empty-state{text-align:center;padding:40px 20px;color:var(--text-muted);}
	.empty-state i{font-size:34px;opacity:.2;display:block;margin-bottom:8px;}
	.empty-state p{font-size:12px;}

	/* ── TOAST ── */
	#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;pointer-events:none;}
	.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;display:flex;align-items:center;gap:7px;box-shadow:0 4px 16px rgba(0,0,0,.18);animation:tIn .25s ease;max-width:300px;}
	@keyframes tIn{from{opacity:0;transform:translateX(16px)}to{opacity:1;transform:translateX(0)}}
	.t-s{background:var(--success);color:#fff;}.t-e{background:var(--danger);color:#fff;}.t-i{background:var(--primary);color:#fff;}.t-w{background:var(--warning);color:#fff;}
</style>
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">


<!-- MAIN -->
<main class="main">

  <!-- PAGE HEADER -->
  <div class="pg-hdr">
    <div class="pg-hdr-l">
      <h1><i class="fa-solid fa-comments" style="font-size:16px;margin-right:8px;color:var(--primary);"></i>Outbound Message Log</h1>
      <p>All SMS and Email messages sent from the system — campaigns, notifications, auth, and custom.</p>
    </div>
  </div>

  <!-- QUICK ACTION RAIL — compact pill buttons -->
  <div class="quick-rail">
    <!--<a class="quick-action" onclick="toast('Opening SMS Campaign Tool…','i')">
      <div class="qa-icon" style="background:#e0f2fe;color:#0369a1;"><i class="fa-solid fa-bullhorn"></i></div>
      <div class="qa-title">SMS Campaigns</div>
    </a>
    <a class="quick-action" onclick="toast('Opening Notification Settings…','i')">
      <div class="qa-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-bell-slash"></i></div>
      <div class="qa-title">Notification Rules</div>
    </a>-->
    <a class="quick-action" onclick="openCustomSmsModal()">
      <div class="qa-icon" style="background:var(--success-light);color:var(--success);"><i class="fa-solid fa-paper-plane"></i></div>
      <div class="qa-title">Send Custom SMS</div>
    </a>
    <!--<a class="quick-action" onclick="toast('Opening Email Composer…','i')">
      <div class="qa-icon" style="background:var(--purple-light);color:var(--purple);"><i class="fa-solid fa-envelope-open-text"></i></div>
      <div class="qa-title">Compose Email</div>
    </a>
    <a class="quick-action" onclick="toast('Opening Template Manager…','i')">
      <div class="qa-icon" style="background:var(--orange-light);color:var(--orange);"><i class="fa-solid fa-file-code"></i></div>
      <div class="qa-title">Templates</div>
    </a>
    <div style="margin-left:auto;display:flex;gap:6px;align-items:center;">
      <button class="btn btn-outline btn-sm" onclick="exportLog()"><i class="fa-solid fa-download"></i>Export</button>
    </div>-->
  </div>

  <!-- COMPACT SUMMARY BAR (wallet + stats in one row) -->
  <div class="summary-bar" id="summary-bar"></div>

  <!-- COMPACT CHARTS -->
  <div class="charts-compact" id="charts-compact"></div>

  <!-- TAB LOG -->
  <div class="tab-card">
    <div class="tabs-header">
      <div class="tab-item active" onclick="switchTab('all',this)"><i class="fa-solid fa-inbox"></i>All Messages<span class="tc" id="tc-all">0</span></div>
      <div class="tab-item" onclick="switchTab('sms',this)"><i class="fa-solid fa-message"></i>SMS<span class="tc" id="tc-sms">0</span></div>
      <div class="tab-item" onclick="switchTab('email',this)"><i class="fa-solid fa-envelope"></i>Email<span class="tc" id="tc-email">0</span></div>
      <div class="tab-item" onclick="switchTab('failed',this)"><i class="fa-solid fa-triangle-exclamation"></i>Failed<span class="tc" id="tc-failed" style="background:var(--danger-light);color:var(--danger);">0</span></div>
    </div>
    <div class="tab-body">
      <div class="tab-pane active" id="tab-all"><div id="log-all"></div></div>
      <div class="tab-pane" id="tab-sms"><div id="log-sms"></div></div>
      <div class="tab-pane" id="tab-email"><div id="log-email"></div></div>
      <div class="tab-pane" id="tab-failed"><div id="log-failed"></div></div>
    </div>
  </div>

</main>

<!-- MESSAGE PREVIEW PANEL -->
<div class="preview-panel" id="preview-panel">
  <div class="pp-head">
    <h5 id="pp-title">Message Preview</h5>
    <button class="pp-close" onclick="closePreview()"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div class="pp-body" id="pp-body"></div>
</div>

<!-- CUSTOM SMS MODAL -->
<div class="modal-bg" id="sms-modal">
  <div class="modal-box">
    <div class="mb-head">
      <h4><i class="fa-solid fa-paper-plane" style="color:var(--sms-color);margin-right:8px;"></i>Send Custom SMS</h4>
      <button class="mb-close" onclick="$('#sms-modal').removeClass('show')"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="mb-body">
      <div class="form-row">
        <label class="form-lbl">Recipient <span>*</span></label>
        <input type="text" class="fc" id="sms-to" placeholder="e.g. 0771234567 or select customer">
      </div>
      <div class="form-row">
        <label class="form-lbl">Sender ID</label>
        <select class="fc" id="sms-sender">
          <option>RIXZO</option><option>NOTIFY</option><option>INFO</option>
        </select>
      </div>
      <div class="form-row">
        <label class="form-lbl">Message <span>*</span></label>
        <textarea class="fc" id="sms-text" rows="4" placeholder="Type your message…" oninput="updateCharCount()"></textarea>
        <div class="char-count"><span id="sms-chars">0</span>/160 chars · <span id="sms-parts">1</span> SMS</div>
      </div>
      <div style="background:var(--warning-light);border:1.5px solid #fde68a;border-radius:var(--r-sm);padding:9px 12px;font-size:12px;color:#92400e;font-weight:600;display:flex;align-items:center;gap:7px;">
        <i class="fa-solid fa-wallet"></i>
        SMS Wallet: <strong id="modal-balance">Rs. 0.00</strong> · Estimated cost: <strong id="sms-cost">Rs. 1.80</strong>
      </div>
    </div>
    <div class="mb-foot">
      <button class="btn btn-outline btn-sm" onclick="$('#sms-modal').removeClass('show')">Cancel</button>
      <button class="btn btn-sms btn-sm" onclick="sendCustomSms()"><i class="fa-solid fa-paper-plane"></i>Send SMS</button>
    </div>
  </div>
</div>

<div id="toast-c"></div>

<script>
	/* ═══════════════════════ DATA ═══════════════════════ */
	var WALLET = {balance:24750, quota:10000, used_this_month:0, rate_per_sms:1.80};
	
	// AJAX call
	var MESSAGES = [];
	var TYPE_LABELS = {};
	var TYPE_CSS    = {};
	var STATUS_CSS  = {};
	var STATUS_ICON = {};

	$.ajax({
		url:'/Notification_manager/get_messages',
		type: 'GET',
		dataType: 'json',
		success: function(res) {

			console.log(res);

			MESSAGES = res;
			
			// Dynamic type arrays
			MESSAGES.forEach(function(m){

				// TYPE LABELS
				if(!TYPE_LABELS[m.type]){
					TYPE_LABELS[m.type] =
						m.type.charAt(0).toUpperCase() + m.type.slice(1);
				}

				// TYPE CSS
				if(!TYPE_CSS[m.type]){
					TYPE_CSS[m.type] = 'tp-' + m.type;
				}

				// STATUS CSS
				if(!STATUS_CSS[m.status]){
					STATUS_CSS[m.status] = 'st-' + m.status;
				}

			});

			// Status icons
			STATUS_ICON = {
				delivered:'fa-check-double',
				sent:'fa-check',
				failed:'fa-xmark',
				pending:'fa-clock',
				opened:'fa-envelope-open',
				bounced:'fa-ban'
			};


			renderWallet();
			renderCharts();
			renderKPIs();
			renderAllTabs();
			updateTabCounts();
		
		}
	});

	/* active tab state */
	var activeTab = 'all';
	var selectedMsg = null;

	/* ─── COMPACT SUMMARY BAR ─── */
	function renderWallet(){
	  var smsAll   = MESSAGES.filter(function(m){return m.channel==='sms';});
	  var emailAll = MESSAGES.filter(function(m){return m.channel==='email';});
	  var fail     = MESSAGES.filter(function(m){return m.status==='failed'||m.status==='bounced';});
	  var delivered= MESSAGES.filter(function(m){return m.status==='delivered'||m.status==='opened';});
	  var emailDel = emailAll.filter(function(m){return m.status==='delivered'||m.status==='opened';});
	  var smsC=smsAll.length, emailC=emailAll.length, total=MESSAGES.length;
	  var delivRate= emailC>0?((emailDel.length/emailC)*100).toFixed(0):0;
	  var dailyAvg = (smsC/7).toFixed(0);
	  var daysLeft = WALLET.balance>0?Math.floor(WALLET.balance/((dailyAvg||1)*WALLET.rate_per_sms)):0;
	  var used=smsC, quotaPct=Math.min((used/WALLET.quota)*100,100);
	  var qColor=quotaPct>85?'var(--danger)':quotaPct>65?'var(--warning)':'var(--success)';
	  WALLET.used_this_month=used;
	  $('#modal-balance').text('Rs. '+WALLET.balance.toLocaleString());

	  var items = [
		// Wallet
		/*{cls:'wallet-item',icon:'fa-wallet','ibg':'var(--success-light)','ic':'var(--success)',
		 val:'Rs. '+WALLET.balance.toLocaleString(),lbl:'SMS Wallet',
		 sub:'<i class="fa-solid fa-circle" style="font-size:6px;color:var(--success);"></i> '+daysLeft+' days remaining',
		 extra:''},
		// Quota
		{icon:'fa-chart-bar','ibg':'var(--warning-light)','ic':'var(--warning)',
		 val:quotaPct.toFixed(0)+'%',lbl:'SMS Quota',
		 sub:used+' / '+WALLET.quota.toLocaleString()+' · '+dailyAvg+'/day avg',
		 extra:'<div class="quota-inline"><div class="qi-bar"><div class="qi-fill" style="width:'+quotaPct.toFixed(0)+'%;background:'+qColor+';"></div></div></div>'},*/
		// SMS
		{icon:'fa-message','ibg':'#e0f2fe','ic':'#0369a1',
		 val:smsC,lbl:'SMS Sent',
		 sub:MESSAGES.filter(function(m){return m.channel==='sms'&&m.status==='delivered';}).length+' delivered · '+fail.filter(function(m){return m.channel==='sms';}).length+' failed',
		 extra:''},
		// Email
		{icon:'fa-envelope','ibg':'var(--purple-light)','ic':'var(--purple)',
		 val:emailC,lbl:'Emails Sent',
		 sub:delivRate+'% delivery · '+emailDel.length+' opened/delivered',
		 extra:''},
		// Total
		{icon:'fa-paper-plane','ibg':'var(--primary-light)','ic':'var(--primary)',
		 val:total,lbl:'Total Messages',
		 sub:'This month · all channels',
		 extra:''},
		// Failed
		{icon:'fa-circle-xmark','ibg':'var(--danger-light)','ic':'var(--danger)',
		 val:fail.length,lbl:'Failed / Bounced',
		 sub:fail.length>0?'Needs attention':'All good',
		 extra:''},
		// Delivered
		{icon:'fa-check-double','ibg':'var(--teal-light)','ic':'var(--teal)',
		 val:delivered.length,lbl:'Delivered / Opened',
		 sub:total>0?((delivered.length/total)*100).toFixed(0)+'% success rate':'',
		 extra:''},
	  ];

	  var html=items.map(function(item){
		return '<div class="sb-item'+(item.cls?' '+item.cls:'')+'">'
		  +'<div class="sbi-icon" style="background:'+item.ibg+';color:'+item.ic+'"><i class="fa-solid '+item.icon+'"></i></div>'
		  +'<div class="sbi-main">'
			+'<div class="sbi-val" style="color:'+item.ic+'">'+item.val+'</div>'
			+'<div class="sbi-lbl">'+item.lbl+'</div>'
			+'<div class="sbi-sub">'+item.sub+'</div>'
			+item.extra
		  +'</div>'
		+'</div>';
	  }).join('');
	  $('#summary-bar').html(html);
	}
	
	function renderKPIs(){}  // merged into renderWallet

	/* ─── COMPACT CHARTS ─── */
	function renderCharts(){
	 
		var grouped = {};

		MESSAGES.forEach(function(m){

			var d = new Date(m.sent_at);

			var label = d.toLocaleDateString('en-US', {
				month:'short',
				day:'numeric'
			});

			if(!grouped[label]){
				grouped[label] = {
					sms:0,
					email:0
				};
			}

			if(m.channel === 'sms'){
				grouped[label].sms++;
			}

			if(m.channel === 'email'){
				grouped[label].email++;
			}

		});

		var days      = Object.keys(grouped);
		var smsData   = days.map(d => grouped[d].sms);
		var emailData = days.map(d => grouped[d].email);
		var trendSvg=buildTrendSVG(days,smsData,emailData);


	  var types={};
	  MESSAGES.forEach(function(m){types[m.type]=(types[m.type]||0)+1;});
	  var total=MESSAGES.length;
	  var colors={system:'#3d52a0',marketing:'#f97316',auth:'#ef4444',custom:'#10b981',campaign:'#8b5cf6',transactional:'#0ea5e9'};
	  var entries=Object.entries(types).sort(function(a,b){return b[1]-a[1];});
	  var r=30,cx=38,cy=38,circ=2*Math.PI*r,offset=0;
	  var arcs=entries.map(function(e){
		var dash=(e[1]/total)*circ;
		var arc='<circle cx="'+cx+'" cy="'+cy+'" r="'+r+'" fill="none" stroke="'+(colors[e[0]]||'#aaa')+'" stroke-width="11" stroke-dasharray="'+dash.toFixed(2)+' '+circ+'" stroke-dashoffset="-'+offset.toFixed(2)+'"/>';
		offset+=dash; return arc;
	  }).join('');
	  var donutSvg='<svg viewBox="0 0 76 76" width="68" height="68" style="flex-shrink:0;transform:rotate(-90deg);">'
		+arcs
		+'<text x="38" y="36" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="800" fill="var(--text-dark)" transform="rotate(90,38,38)">'+total+'</text>'
		+'<text x="38" y="48" text-anchor="middle" font-size="7" fill="var(--text-muted)" transform="rotate(90,38,38)">total</text>'
		+'</svg>';
	  var donutLegend=entries.map(function(e){
		return '<div class="dl-row"><div class="dl-dot" style="background:'+(colors[e[0]]||'#aaa')+'"></div><div class="dl-lbl">'+TYPE_LABELS[e[0]]+'</div><div class="dl-val">'+e[1]+'</div></div>';
	  }).join('');

	  var statCnt={delivered:0,sent:0,failed:0,pending:0,opened:0,bounced:0};
	  MESSAGES.forEach(function(m){statCnt[m.status]=(statCnt[m.status]||0)+1;});
	  var maxS=Math.max.apply(null,Object.values(statCnt))||1;
	  var sCols={delivered:'#10b981',sent:'#0ea5e9',failed:'#ef4444',pending:'#f59e0b',opened:'#14b8a6',bounced:'#f43f5e'};
	  var statusBars=Object.entries(statCnt).filter(function(e){return e[1]>0;}).sort(function(a,b){return b[1]-a[1];}).map(function(e){
		var pct=(e[1]/maxS*100).toFixed(0);
		return '<div class="mini-bar-row"><div class="mb-top"><span class="mb-lbl" style="text-transform:capitalize;">'+e[0]+'</span><span class="mb-val">'+e[1]+'</span></div><div class="mb-track"><div class="mb-fill" style="width:'+pct+'%;background:'+(sCols[e[0]]||'#aaa')+'"></div></div></div>';
	  }).join('');

	  $('#charts-compact').html(
		'<div class="cc-head">'
		  +'<div class="sec-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-chart-line"></i></div>'
		  +'<h6>Send Volume &amp; Analytics</h6>'
		  +'<div style="display:flex;gap:10px;">'
			+'<span style="display:flex;align-items:center;gap:4px;font-size:10px;font-weight:700;color:#0369a1;"><div style="width:7px;height:7px;border-radius:50%;background:#0ea5e9;"></div>SMS</span>'
			+'<span style="display:flex;align-items:center;gap:4px;font-size:10px;font-weight:700;color:var(--purple);"><div style="width:7px;height:7px;border-radius:50%;background:var(--email-color);"></div>Email</span>'
		  +'</div>'
		+'</div>'
		+'<div class="cc-inner">'
		  +'<div class="cc-panel"><div class="cc-panel-title">7-Day Send Volume</div><svg viewBox="0 0 380 100" style="width:100%;height:100px;overflow:visible;">'+trendSvg+'</svg></div>'
		  +'<div class="cc-panel"><div class="cc-panel-title">By Message Type</div><div class="donut-wrap">'+donutSvg+'<div class="donut-legend">'+donutLegend+'</div></div></div>'
		  +'<div class="cc-panel"><div class="cc-panel-title">Delivery Status</div>'+statusBars+'</div>'
		+'</div>'
	  );
	}

	function buildTrendSVG(labels, sms, email){
		labels = labels || [];
		sms    = sms || [];
		email  = email || [];

		if(labels.length === 0){
			labels = ["No Data"];
		}

		var w=380,h=80,padL=20,padR=8,padT=6,padB=22;
		var cw=w-padL-padR, ch=h-padT-padB;
		var allData = sms.concat(email);

		if(allData.length === 0){
			allData = [0];
		}

		var maxV=Math.max.apply(null, allData)*1.2 || 1;
		var n=labels.length;
		var step = n > 1 ? cw/(n-1) : cw;

		function px(i){return padL+i*step;}
		function py(v){return padT+ch-(v/maxV)*ch;}

		var grid='';
		for(var g=0;g<=3;g++){
			var gy=padT+(ch/3)*g;
			grid+='<line x1="'+padL+'" y1="'+gy.toFixed(0)+'" x2="'+(w-padR)+'" y2="'+gy.toFixed(0)+'" stroke="#e4e9f4" stroke-width="1"/>';
		}

		var xlbls=labels.map(function(l,i){
			return '<text x="'+px(i).toFixed(0)+'" y="'+(h-3)+'" text-anchor="middle" font-size="8" fill="#8a94a6">'+l+'</text>';
		}).join('');

		function buildLine(data,color,areaColor){
			if(!data.length) return '';

				var pts=data.map(function(v,i){
				  return px(i).toFixed(1)+','+py(v).toFixed(1);
				}).join(' ');

				var areaPath='M'+pts.split(' ').join(' L');
				areaPath+=' L'+px(n-1).toFixed(1)+','+(padT+ch)+' L'+padL+','+(padT+ch)+' Z';

				var linePath='M'+pts.split(' ').join(' L');

				return '<path d="'+areaPath+'" fill="'+areaColor+'"/>'
				  +'<path d="'+linePath+'" fill="none" stroke="'+color+'" stroke-width="2"/>'
				  +data.map(function(v,i){
					return '<circle cx="'+px(i).toFixed(1)+'" cy="'+py(v).toFixed(1)+'" r="2.5" fill="'+color+'"/>';
				  }).join('');
			}

			return grid + xlbls
			+ buildLine(sms,'#0ea5e9','rgba(14,165,233,.08)')
			+ buildLine(email,'#8b5cf6','rgba(139,92,246,.06)');
	} 

	/* ─── TABLE ─── */
	function renderLog(containerId, msgs){
		if(!msgs.length){$('#'+containerId).html('<div class="empty-state"><i class="fa-solid fa-inbox"></i><p>No messages found.</p></div>');return;}
		var tableHtml='<div class="toolbar">'
			+'<div class="sw"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Search recipient, content, ref…" oninput="filterLog(\''+containerId+'\',this.value)"></div>'
			+'<select class="fsel" onchange="filterLog(\''+containerId+'\',\'\',this.value,null)"><option value="">All Types</option>'+Object.keys(TYPE_LABELS).map(function(k){return '<option value="'+k+'">'+TYPE_LABELS[k]+'</option>';}).join('')+'</select>'
			+'<select class="fsel" onchange="filterLog(\''+containerId+'\',\'\',null,this.value)"><option value="">All Statuses</option>'+['delivered','sent','failed','pending','opened','bounced'].map(function(s){return '<option value="'+s+'">'+s.charAt(0).toUpperCase()+s.slice(1)+'</option>';}).join('')+'</select>'
			+'<span class="rc">'+msgs.length+' messages</span>'
		  +'</div>'
		  +'<div class="tbl-wrap"><table class="tbl"><thead><tr>'
			+'<th style="width:36px"></th>'
			+'<th>Sent At</th><th>Channel</th><th>Type</th>'
			+'<th>Recipient</th><th>To</th><th>Subject / Preview</th>'
			+'<th>Ref</th><th style="text-align:center;">Status</th>'
		  +'</tr></thead><tbody>'+msgs.map(function(m){
			var chanBadge = m.channel==='sms'
			  ? '<span class="badge ch-sms"><i class="fa-solid fa-message" style="font-size:9px;"></i>SMS</span>'
			  : '<span class="badge ch-email"><i class="fa-solid fa-envelope" style="font-size:9px;"></i>Email</span>';
			var preview = m.channel==='email'
			  ? (m.subject||'(no subject)')
			  : (m.body.length>55?m.body.slice(0,55)+'…':m.body);
			return '<tr onclick="openPreview('+m.id+')" title="Click to view message">'
			  +'<td><div style="width:28px;height:28px;border-radius:50%;background:'+(m.channel==='sms'?'#e0f2fe':'var(--purple-light)')+';display:flex;align-items:center;justify-content:center;font-size:11px;color:'+(m.channel==='sms'?'#0369a1':'var(--purple)')+'"><i class="fa-solid '+(m.channel==='sms'?'fa-message':'fa-envelope')+'"></i></div></td>'
			  +'<td style="font-size:12px;color:var(--text-muted);white-space:nowrap;">'+m.sent_at+'</td>'
			  +'<td>'+chanBadge+'</td>'
			  +'<td><span class="badge '+TYPE_CSS[m.type]+'">'+TYPE_LABELS[m.type]+'</span></td>'
			  +'<td style="font-weight:600;font-size:12px;">'+m.recipient+'</td>'
			  +'<td><span class="mono" style="font-size:11px;color:var(--text-muted);">'+m.to+'</span></td>'
			  +'<td style="font-size:12px;color:var(--text-mid);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'+preview+'</td>'
			  +'<td><span class="mono" style="font-size:11px;color:var(--primary);">'+m.ref+'</span></td>'
			  +'<td style="text-align:center;"><span class="badge '+STATUS_CSS[m.status]+'"><i class="fa-solid '+STATUS_ICON[m.status]+'" style="font-size:9px;"></i>'+m.status+'</span></td>'
			+'</tr>';
		}).join('')+'</tbody></table></div>';
		$('#'+containerId).html(tableHtml);
	}

	function renderAllTabs(){
		var sms    = MESSAGES.filter(function(m){return m.channel==='sms';});
		var email  = MESSAGES.filter(function(m){return m.channel==='email';});
		var failed = MESSAGES.filter(function(m){return m.status==='failed'||m.status==='bounced';});
		renderLog('log-all', MESSAGES);
		renderLog('log-sms', sms);
		renderLog('log-email', email);
		renderLog('log-failed', failed);
		updateTabCounts();
	}

	function filterLog(containerId, q, type, status){
		q = q !== undefined ? q.toLowerCase() : '';
		type   = type   !== undefined ? type   : null;
		status = status !== undefined ? status : null;
		var base = containerId==='log-all'?MESSAGES:containerId==='log-sms'?MESSAGES.filter(function(m){return m.channel==='sms';}):containerId==='log-email'?MESSAGES.filter(function(m){return m.channel==='email';}):MESSAGES.filter(function(m){return m.status==='failed'||m.status==='bounced';});
		var rows = base.filter(function(m){
			if (type && m.type!==type) return false;
			if (status && m.status!==status) return false;
			if (q && !m.recipient.toLowerCase().includes(q) && !m.body.toLowerCase().includes(q) && !m.to.toLowerCase().includes(q) && !m.ref.toLowerCase().includes(q)) return false;
			return true;
		});
		renderLog(containerId, rows);
	}

	function updateTabCounts(){
		$('#tc-all').text(MESSAGES.length);
		$('#tc-sms').text(MESSAGES.filter(function(m){return m.channel==='sms';}).length);
		$('#tc-email').text(MESSAGES.filter(function(m){return m.channel==='email';}).length);
		$('#tc-failed').text(MESSAGES.filter(function(m){return m.status==='failed'||m.status==='bounced';}).length);
	}

	/* ─── TAB SWITCH ─── */
	function switchTab(id,el){$('.tab-item').removeClass('active');$('.tab-pane').removeClass('active');$(el).addClass('active');$('#tab-'+id).addClass('active');}

	/* ─── PREVIEW PANEL ─── */
	function openPreview(id){
		var m=MESSAGES.find(function(x){return x.id===id;});
		if(!m) return;
			var isSms=m.channel==='sms';
			var chanColor=isSms?'#0369a1':'var(--purple)';
			$('#pp-title').html('<i class="fa-solid '+(isSms?'fa-message':'fa-envelope')+'" style="margin-right:7px;color:'+chanColor+';"></i>'+m.recipient);
			  var metaHtml='<div class="pp-meta-grid">'
				+'<div class="pp-meta-item"><div class="pm-lbl">Channel</div><div class="pm-val">'+m.channel.toUpperCase()+'</div></div>'
				+'<div class="pp-meta-item"><div class="pm-lbl">Type</div><div class="pm-val">'+m.type+'</div></div>'
				+'<div class="pp-meta-item"><div class="pm-lbl">To</div><div class="pm-val mono" style="font-size:12px;">'+m.to+'</div></div>'
				+'<div class="pp-meta-item"><div class="pm-lbl">Sent</div><div class="pm-val" style="font-size:12px;">'+m.sent_at+'</div></div>'
				+'<div class="pp-meta-item"><div class="pm-lbl">Status</div><div class="pm-val"><span class="badge '+STATUS_CSS[m.status]+'"><i class="fa-solid '+STATUS_ICON[m.status]+'" style="font-size:9px;"></i>'+m.status+'</span></div></div>'
				+'<div class="pp-meta-item"><div class="pm-lbl">Reference</div><div class="pm-val mono" style="font-size:12px;color:var(--primary);">'+m.ref+'</div></div>'
				+(isSms?'<div class="pp-meta-item"><div class="pm-lbl">SMS Parts</div><div class="pm-val">'+m.parts+' part'+(m.parts>1?'s':'')+'</div></div>':'')
				+(isSms?'<div class="pp-meta-item"><div class="pm-lbl">Cost</div><div class="pm-val mono">Rs. '+(m.parts*1.80).toFixed(2)+'</div></div>':'')
			  +'</div>';
			var bubbleCls=isSms?'sms-bubble':'email-bubble';
			var contentHtml='<div class="msg-bubble '+bubbleCls+'">'
				+'<div class="mb-label">'+(isSms?'📱 SMS MESSAGE':'📧 EMAIL MESSAGE')+'</div>'
				+((!isSms&&m.subject)?'<div class="msg-subject">'+m.subject+'</div>':'')
				+'<div class="msg-text">'+m.body.replace(/\n/g,'<br>')+'</div>'
			  +'</div>';
			$('#pp-body').html(metaHtml+'<div class="divider"></div>'+contentHtml);
			$('#preview-panel').addClass('open');
	}
	
	function closePreview(){ $('#preview-panel').removeClass('open'); }
	/* ─── CUSTOM SMS ─── */
	function openCustomSmsModal(){
		$('#sms-to,#sms-text').val('');
		updateCharCount();
		$('#sms-modal').addClass('show');
		setTimeout(function(){$('#sms-to').focus();},300);
	}
		
	function updateCharCount(){
		var len=$('#sms-text').val().length;
		var parts=Math.ceil(len/160)||1;
		$('#sms-chars').text(len);
		$('#sms-parts').text(parts);
		$('#sms-cost').text('Rs. '+(parts*1.80).toFixed(2));
	}
	
	function sendCustomSms(){
		var to=$('#sms-to').val().trim();
		var text=$('#sms-text').val().trim();
		if(!to){toast('Enter a recipient number','w');return;}
		if(!text){toast('Enter a message','w');return;}
		var nid=Math.max.apply(null,MESSAGES.map(function(m){return m.id;}))+1;
		MESSAGES.unshift({id:nid,channel:'sms',type:'custom',to:to,recipient:to,subject:null,body:text,status:'sent',sent_at:nowStr(),ref:'CUSTOM-'+String(nid).padStart(3,'0'),parts:Math.ceil(text.length/160)||1});
		WALLET.balance-=(Math.ceil(text.length/160)||1)*1.80;
		renderWallet(); renderKPIs(); renderCharts(); renderAllTabs();
		$('#sms-modal').removeClass('show');
		toast('SMS sent to '+to,'s');
	}

	/* ─── EXPORT ─── */
	function exportLog(){ toast('Exporting message log…','i'); /* AJAX */ }
	/* ─── HELPERS ─── */
	function fmt(n){return Number(n).toLocaleString('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2});}
	function nowStr(){var d=new Date();return d.toISOString().slice(0,16).replace('T',' ');}
	function toast(msg,type){
	  var map={s:['t-s','fa-check-circle'],w:['t-w','fa-triangle-exclamation'],e:['t-e','fa-circle-xmark'],i:['t-i','fa-circle-info']};
	  var p=map[type]||map.i;
	  var $t=$('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i>'+msg+'</div>');
	  $('#toast-c').append($t);
	  setTimeout(function(){$t.css({opacity:0,transform:'translateX(16px)',transition:'all .3s'});setTimeout(function(){$t.remove();},300);},2800);
	}
</script>