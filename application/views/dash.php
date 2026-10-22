
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>

	<style>
		.chart-container {
		  position: relative;
		  height: 200px; /* Or whatever height you need */
		  width: 100%;
		}
		*{box-sizing:border-box;margin:0;padding:0}
		:root{
		  --bg:#f7f6f3;--surface:#fff;--surface2:#f0efe9;--border:#e8e6df;
		  --text:#1a1917;--muted:#7a786f;--faint:#b4b2a9;
		  --green:#3B6D11;--green-bg:#EAF3DE;
		  --red:#A32D2D;--red-bg:#FCEBEB;
		  --amber:#854F0B;--amber-bg:#FAEEDA;
		  --blue:#185FA5;--blue-bg:#E6F1FB;
		  --teal:#0F6E56;--teal-bg:#E1F5EE;
		  --purple:#534AB7;--purple-bg:#EEEDFE;
		}
		body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);font-size:13px;line-height:1.5}

		/* ── LAYOUT ── */
		.dash{display:grid;grid-template-columns:200px 1fr;min-height:100vh}
		.main{overflow-y:auto;display:flex;flex-direction:column}
		.content{padding:16px;flex:1}

		/* ── SIDEBAR ── */
		.sidebar{background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;position:sticky;top:0;height:100vh}
		.logo{padding:16px 14px 12px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px}
		.logo-mark{width:28px;height:28px;background:var(--text);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
		.logo-mark span{color:#fff;font-size:10px;font-weight:500;font-family:'DM Mono',monospace}
		.logo-name{font-size:13px;font-weight:500}
		.logo-sub{font-size:9px;color:var(--muted)}
		.nav{padding:8px 0;flex:1;overflow-y:auto}
		.nav-label{font-size:9px;font-weight:500;color:var(--faint);letter-spacing:1px;text-transform:uppercase;padding:8px 14px 3px}
		.nav-item{display:flex;align-items:center;gap:8px;padding:6px 14px;cursor:pointer;color:var(--muted);font-size:11.5px;border-left:2px solid transparent;transition:all .12s}
		.nav-item:hover{color:var(--text);background:var(--surface2)}
		.nav-item.active{color:var(--text);border-left-color:var(--text);background:var(--surface2);font-weight:500}
		.nav-ic{width:13px;height:13px;flex-shrink:0;opacity:.55}
		.nav-badge{margin-left:auto;background:var(--red-bg);color:var(--red);font-size:9px;padding:1px 5px;border-radius:8px;font-weight:500}
		.sb-footer{padding:10px 14px;border-top:1px solid var(--border)}
		.avatar{width:26px;height:26px;border-radius:50%;background:var(--purple-bg);display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:500;color:var(--purple);flex-shrink:0}

		/* ── TOP BAR ── */
		.topbar{background:var(--surface);border-bottom:1px solid var(--border);padding:0 18px;height:50px;display:flex;align-items:center;gap:10px;position:sticky;top:0;z-index:10}
		.page-title{font-size:13px;font-weight:500;flex:1}
		.pill{background:var(--surface2);border:1px solid var(--border);border-radius:6px;padding:3px 9px;font-size:11px;color:var(--muted);cursor:pointer}
		.notif-btn{width:30px;height:30px;border-radius:6px;background:var(--surface2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative}
		.notif-dot{position:absolute;top:5px;right:5px;width:5px;height:5px;background:#E24B4A;border-radius:50%;border:1px solid var(--surface)}

		/* ── CARDS ── */
		.card{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:13px 15px}
		.card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
		.card-title{font-size:10px;font-weight:500;text-transform:uppercase;letter-spacing:.5px;color:var(--muted)}
		.card-action{font-size:10px;color:var(--muted);cursor:pointer;text-decoration:underline;text-underline-offset:2px}

		/* ── BADGES ── */
		.badge{font-size:9px;padding:2px 6px;border-radius:8px;font-weight:500;display:inline-block}
		.bg{background:var(--green-bg);color:var(--green)}
		.br{background:var(--red-bg);color:var(--red)}
		.ba{background:var(--amber-bg);color:var(--amber)}
		.bb{background:var(--blue-bg);color:var(--blue)}
		.bp{background:var(--purple-bg);color:var(--purple)}
		.bt{background:var(--teal-bg);color:var(--teal)}

		/* ── SECTION LABEL ── */
		.sec-label{font-size:9px;font-weight:500;text-transform:uppercase;letter-spacing:1px;color:var(--faint);margin:18px 0 10px;padding-bottom:5px;border-bottom:1px solid var(--border)}

		/* ── GRIDS ── */
		.g6{display:grid;grid-template-columns:repeat(6,1fr);gap:9px;margin-bottom:14px}
		.g2a{display:grid;grid-template-columns:240px 1fr;gap:12px;margin-bottom:12px}
		.g22{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px}
		.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:9px;margin-bottom:12px}
		.g4{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:9px;margin-bottom:12px}
		.g23{display:grid;grid-template-columns:2fr 1fr;gap:12px;margin-bottom:12px}
		.g32{display:grid;grid-template-columns:1fr 2fr;gap:12px;margin-bottom:12px}

		/* ── KPI ── */
		.kpi{background:var(--surface);border:1px solid var(--border);border-radius:9px;padding:11px 13px;cursor:pointer;transition:border-color .12s}
		.kpi:hover{border-color:var(--faint)}
		.kpi-lbl{font-size:9px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px}
		.kpi-val{font-size:17px;font-weight:500;font-family:'DM Mono',monospace;letter-spacing:-.5px;line-height:1.1}
		.kpi-sub{font-size:9px;margin-top:4px}
		.up{color:var(--green)}.dn{color:var(--red)}.wn{color:var(--amber)}

		/* ── LEGACY SALES BLOCK ── */
		.sales-legacy{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:0}
		.sl-cell{padding:11px 11px;border-right:1px solid var(--border)}
		.sl-cell:last-child{border-right:none}
		.sl-period{font-size:9px;font-weight:500;text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px}
		.sl-amount{font-size:22px;font-weight:500;font-family:'DM Mono',monospace;letter-spacing:-.5px;line-height:1}
		.sl-count{font-size:10px;color:var(--muted);margin-top:3px}
		.sl-divider{height:1px;background:var(--border);margin:8px 0}
		.sl-split{display:flex;flex-direction:column;gap:2px}
		.sl-split-row{display:flex;justify-content:space-between;font-size:10px}

		/* ── TARGET DONUT ── */
		.target-wrap{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%}
		.target-label{font-size:10px;color:var(--muted);margin-top:8px}
		.target-pct{font-size:18px;font-weight:500;font-family:'DM Mono',monospace}

		/* ── BARS ── */
		.bar-row{display:flex;align-items:center;gap:7px;margin-bottom:5px;font-size:10px}
		.bar-lbl{width:62px;color:var(--muted);flex-shrink:0}
		.bar-wrap{flex:1;background:var(--surface2);border-radius:2px;height:5px;overflow:hidden}
		.bar-fill{height:100%;border-radius:2px}
		.bar-val{min-width:56px;text-align:right;font-family:'DM Mono',monospace;font-size:9px}

		/* ── STOCK BARS ── */
		.sb-row{display:flex;align-items:center;gap:7px;margin-bottom:4px;font-size:10px}
		.sb-lbl{width:74px;color:var(--muted);flex-shrink:0}
		.sb-wrap{flex:1;background:var(--surface2);border-radius:2px;height:7px;overflow:hidden}
		.sb-fill{height:100%;border-radius:2px}
		.sb-val{min-width:28px;text-align:right;font-size:9px;font-family:'DM Mono',monospace}

		/* ── LIST ITEMS ── */
		.li{display:flex;align-items:center;justify-content:space-between;padding:6px 0;border-bottom:1px solid var(--border);font-size:11px}
		.li:last-child{border-bottom:none}
		.li-name{font-weight:500;margin-bottom:1px}
		.li-sub{font-size:9px;color:var(--muted)}

		/* ── ALERTS ── */
		.alert-item{display:flex;align-items:flex-start;gap:7px;padding:7px 0;border-bottom:1px solid var(--border)}
		.alert-item:last-child{border-bottom:none;padding-bottom:0}
		.adot{width:5px;height:5px;border-radius:50%;flex-shrink:0;margin-top:4px}
		.dot-r{background:#E24B4A}.dot-a{background:#EF9F27}.dot-b{background:#378ADD}
		.alert-text{font-size:11px;line-height:1.4}
		.alert-meta{font-size:9px;color:var(--muted)}

		/* ── DONUT LEGEND ── */
		.donut-wrap{display:flex;align-items:center;gap:12px}
		.leg-row{display:flex;align-items:center;gap:5px;font-size:10px;margin-bottom:4px}
		.leg-sq{width:8px;height:8px;border-radius:2px;flex-shrink:0}

		/* ── MINI STATS ── */
		.mini-grid{display:grid;grid-template-columns:1fr 1fr;gap:7px;margin-top:10px}
		.mini-stat{background:var(--surface2);border-radius:7px;padding:8px;text-align:center}
		.mini-num{font-size:14px;font-weight:500;font-family:'DM Mono',monospace}
		.mini-lbl{font-size:9px;color:var(--muted);margin-top:1px;text-transform:uppercase;letter-spacing:.4px}

		/* ── PNL ── */
		.pnl-row{display:flex;align-items:center;justify-content:space-between;padding:5px 0;border-bottom:1px solid var(--border);font-size:11px}
		.pnl-row:last-child{border-bottom:none}

		/* ── SMS ── */
		.sms-row{display:flex;align-items:center;gap:8px;padding:6px 0;border-bottom:1px solid var(--border);font-size:11px}
		.sms-row:last-child{border-bottom:none}
		.sms-bar-wrap{flex:1;background:var(--surface2);border-radius:2px;height:4px;overflow:hidden}
		.sms-bar-fill{height:100%;border-radius:2px}

		/* ── PROGRESS ── */
		.prog-outer{background:var(--surface2);border-radius:3px;height:6px;overflow:hidden;margin:4px 0}
		.prog-inner{height:100%;border-radius:3px}

		/* ── PROJ TABLE ── */
		.ptable{width:100%;border-collapse:collapse;font-size:10.5px}
		.ptable th{text-align:left;font-size:9px;font-weight:500;text-transform:uppercase;letter-spacing:.5px;color:var(--faint);padding:0 8px 7px 0;border-bottom:1px solid var(--border)}
		.ptable td{padding:8px 8px 8px 0;border-bottom:1px solid var(--border);vertical-align:middle}
		.ptable tr:last-child td{border-bottom:none}
		.pbar-wrap{background:var(--surface2);border-radius:2px;height:4px;width:70px;overflow:hidden;margin-top:3px}
		.pbar-fill{height:100%;border-radius:2px}

		/* ── ACTIVITY ── */
		.act-item{display:flex;align-items:flex-start;gap:8px;padding:7px 0;border-bottom:1px solid var(--border);font-size:11px}
		.act-item:last-child{border-bottom:none}
		.act-time{font-size:9px;color:var(--faint);font-family:'DM Mono',monospace;min-width:36px;margin-top:1px}
		.act-icon{width:18px;height:18px;border-radius:4px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:9px;font-weight:500}
		.act-sub{font-size:9px;color:var(--muted)}

		/* ── FOOTER STRIP ── */
		.fstrip{display:grid;border-top:1px solid var(--border);margin-top:11px;padding-top:11px}
		.fstrip-cell{text-align:center;padding:4px 6px;border-right:1px solid var(--border)}
		.fstrip-cell:last-child{border-right:none}
		.fstrip-lbl{font-size:9px;color:var(--muted)}
		.fstrip-val{font-size:14px;font-weight:500;font-family:'DM Mono',monospace;margin-top:2px}

		/* ── LEGEND ROW ── */
		.legend{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:9px}
		.legend-item{display:flex;align-items:center;gap:4px;font-size:10px;color:var(--muted)}
		.legend-sq{width:9px;height:9px;border-radius:2px;flex-shrink:0}
		.chart-wrap{position:relative;width:100%}

		/* ── TOP ITEMS LEGEND ── */
		.item-legend{display:flex;flex-direction:column;gap:5px;justify-content:center}
		.item-leg-row{display:flex;align-items:center;gap:7px;font-size:10px}
		.item-leg-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
		.item-leg-name{color:var(--text);flex:1}
		.item-leg-val{font-family:'DM Mono',monospace;font-size:9px;color:var(--muted)}
		
		/* Inventory specific styles */
.stock-alert-item {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:4px 0;
    border-bottom:1px solid var(--border);
}
.stock-alert-item:last-child {
    border-bottom:none;
}
.stock-alert-name {
    font-weight:500;
    font-size:10px;
}
.stock-alert-qty {
    font-size:9px;
    color:var(--muted);
}
.stock-badge-low {
    background:var(--red-bg);
    color:var(--red);
    font-size:8px;
    padding:1px 6px;
    border-radius:8px;
}
.stock-badge-critical {
    background:var(--red-bg);
    color:var(--red);
    font-size:8px;
    padding:1px 6px;
    border-radius:8px;
    animation: pulse 1s infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
	</style>

	<!-- ============================================================
     DATA LAYER — replace each fetch() call with your AJAX endpoint
     All UI reads exclusively from these objects.
     ============================================================ -->
	<script>
		/* ─────────────────────────────────────────────
		   DATASET 1 — KPI & Sales Summary
		   Replace with: fetch('/api/dashboard/kpi')
		───────────────────────────────────────────── */
		const DS_KPI = {
		  salesToday:        { amount: 847250,  bills: 34,  cash: 355000,  card: 262000,  credit: 230250 },
		  salesYesterday:    { amount: 890000,  bills: 41,  cash: 410000,  card: 260000,  credit: 220000 },
		  salesThisMonth:    { amount: 12400000,bills: 487, cash: 5200000, card: 3800000, credit: 3400000 },
		  salesLastMonth:    { amount: 11800000,bills: 460, cash: 4900000, card: 3600000, credit: 3300000 },
		  receivables:       { total: 2300000,  overdue: 18 },
		  payables:          { total: 1100000,  dueToday: 3 },
		  netCash:           { total: 4600000 },
		  stockValue:        { total: 6800000,  lowItems: 5 },
		  purchasesMTD:      { total: 3200000,  pendingPOs: 4 },
		  salesTarget:       { target: 15000000, achieved: 12400000 },
		};

		/* ─────────────────────────────────────────────
		   DATASET 2 — Charts (Trend & Collections)
		   Replace with: fetch('/api/dashboard/charts')
		───────────────────────────────────────────── */
		const DS_CHARTS = {
		  salesTrend: {
			labels:  ['Apr 26','Apr 27','Apr 28','Apr 29','Apr 30','May 1','May 2'],
			cash:    [320,380,290,420,350,410,355],
			card:    [210,240,190,280,230,260,262],
			credit:  [180,200,160,230,190,220,230],
		  },
		  settledVsTotal: {
			labels:       ['Dec 23','Jan 24','Feb 24','Mar 24','Apr 24','May 24','Jun 24','Jul 24','Aug 24','Sep 24','Oct 24','Nov 24','Dec 24','Jan 25','Feb 25'],
			saleTotal:    [2100,1800,1950,2200,1700,2400,1900,6200,2000,2100,1800,2300,2500,1900,1800],
			settledAmt:   [1800,1600,1750,1900,1500,2100,1700,2200,1800,1900,1700,2100,2200,1700,1600],
		  },
		  plTrend: {
			labels:   ['Jan','Feb','Mar','Apr','May'],
			income:   [9.8,10.2,11.5,11.8,12.4],
			expenses: [7.2,7.8,8.1,8.5,8.7],
		  },
		  receivablesVsPayables: {
			labels:       ['Dec','Jan','Feb','Mar','Apr','May'],
			receivables:  [1820,1950,2100,2050,2130,2300],
			payables:     [980,1050,1200,1150,1130,1100],
			netPosition:  [840,900,900,900,1000,1200],
		  },
		  monthlyCollections: {
			labels:         ['Dec','Jan','Feb','Mar','Apr','May'],
			billed:         [10200,10800,11200,11500,11800,12400],
			cashCard:       [7800,8200,8600,8900,9100,9000],
			creditRecovered:[1400,1600,1800,1700,1900,2100],
		  },
		  monthlyProgress: {
			labels: ['Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
			values: [120,280,420,180,0,0,2050],
		  },
		  attendance: {
			present: 39, absent: 7, late: 2, leave: 0, total: 48,
		  },
		};

		/* ─────────────────────────────────────────────
		   DATASET 3 — Operational Data
		   Replace with: fetch('/api/dashboard/operations')
		───────────────────────────────────────────── */
		const DS_OPS = {
		  alerts: [
			{ level:'red',  text:'12 items below reorder level',       meta:'Inventory · Reorder needed' },
			{ level:'red',  text:'8 products expiring within 7 days',  meta:'Inventory · Urgent' },
			{ level:'amber',text:'LKR 420K receivables overdue 60+ days', meta:'Finance · 6 customers' },
			{ level:'amber',text:'3 GRNs pending verification',         meta:'Purchasing · Action required' },
			{ level:'amber',text:'7 employees absent today',            meta:'HRM · Unexcused' },
			{ level:'blue', text:'Payroll processing due in 3 days',    meta:'HRM · 48 employees' },
		  ],
		  stockByBranch: [
			{ name:'Main Store', pct:82, color:'#3B6D11' },
			{ name:'Branch A',   pct:61, color:'#185FA5' },
			{ name:'Branch B',   pct:44, color:'#EF9F27' },
			{ name:'Warehouse',  pct:73, color:'#534AB7' },
		  ],
		  expiryAlerts: [
			{ name:'Paracetamol 500mg', lot:'#2201', units:240, days:3,  badge:'br' },
			{ name:'Vitamin C Syrup',   lot:'#3312', units:80,  days:6,  badge:'br' },
			{ name:'Antiseptic Cream',  lot:'#1190', units:150, days:22, badge:'ba' },
		  ],
		  purchaseOrders: [
			{ supplier:'MedPharma Pvt Ltd',   poNo:'PO-2245', items:3,  due:'May 5', status:'Pending',    badge:'ba' },
			{ supplier:'Global Supplies Co.', poNo:'PO-2241', items:7,  due:'May 7', status:'Processing', badge:'bb' },
			{ supplier:'Lanka Distributors',  poNo:'PO-2238', items:12, due:'—',     status:'GRN Ready',  badge:'bg' },
		  ],
		  supplierAging: [
			{ label:'0–30 days',  pct:70, color:'#3B6D11', val:'LKR 480K' },
			{ label:'31–60 days', pct:45, color:'#EF9F27', val:'LKR 310K' },
			{ label:'61–90 days', pct:25, color:'#D85A30', val:'LKR 170K' },
			{ label:'90+ days',   pct:12, color:'#A32D2D', val:'LKR 85K'  },
		  ],
		  customerAging: [
			{ label:'0–30 days',  pct:65, color:'#3B6D11', val:'LKR 890K' },
			{ label:'31–60 days', pct:40, color:'#EF9F27', val:'LKR 550K' },
			{ label:'61–90 days', pct:22, color:'#D85A30', val:'LKR 300K' },
			{ label:'90+ days',   pct:10, color:'#A32D2D', val:'LKR 140K' },
		  ],
		  topCreditCustomers: [
			{ name:'Saman Enterprises', limit:500000, used:380000, badge:'ba' },
			{ name:'Colombo Traders',   limit:300000, used:290000, badge:'br' },
			{ name:'Perera & Sons',     limit:200000, used:80000,  badge:'bg' },
		  ],
		  financials: {
			revenueMTD:  12400000,
			expensesMTD:  8700000,
			netProfit:    3700000,
			doubleEntry: 'Balanced',
			vatLiability: 184000,
			journalCount: 38,
		  },
		  hrm: {
			leavesPending: 3,
			payrollAmount: 2100000,
			payDate: 'May 28',
		  },
		  smsCampaigns: [
			{ name:'Credit reminder — May',  sent:1247, total:1600, color:'#185FA5' },
			{ name:'Invoice delivery alerts', sent:842,  total:900,  color:'#3B6D11' },
		  ],
		  smsUsage:  { used:2089, quota:5000 },
		  smsRecent: [
			{ msg:'Invoice #INV-4412 → Saman Ent.',    status:'Delivered', badge:'bg' },
			{ msg:'Overdue reminder → Colombo Traders', status:'Delivered', badge:'bg' },
			{ msg:'Credit alert → Perera & Sons',       status:'Failed',    badge:'br' },
		  ],
		  activityFeed: [
			{ time:'10:42', icon:'$', iconBg:'#EAF3DE', iconColor:'#3B6D11', text:'Invoice #INV-4415 created',    sub:'Saman Enterprises · LKR 48,500' },
			{ time:'10:20', icon:'P', iconBg:'#E6F1FB', iconColor:'#185FA5', text:'Payment received',             sub:'Colombo Traders · LKR 120,000'  },
			{ time:'09:55', icon:'G', iconBg:'#E1F5EE', iconColor:'#0F6E56', text:'GRN-0892 completed',           sub:'Lanka Distributors · 12 items'   },
			{ time:'09:30', icon:'J', iconBg:'#FAEEDA', iconColor:'#854F0B', text:'Journal entry posted',         sub:'Salary advance · Balanced'       },
			{ time:'09:10', icon:'S', iconBg:'#EEEDFE', iconColor:'#534AB7', text:'SMS campaign triggered',       sub:'Credit reminder · 84 recipients' },
			{ time:'08:50', icon:'!', iconBg:'#FCEBEB', iconColor:'#A32D2D', text:'Low stock alert raised',       sub:'Paracetamol 500mg · 12 units'    },
			{ time:'08:35', icon:'C', iconBg:'#EAF3DE', iconColor:'#3B6D11', text:'New customer added',           sub:'Nimal & Brothers · Gampaha'      },
			{ time:'08:20', icon:'O', iconBg:'#E6F1FB', iconColor:'#185FA5', text:'PO-2246 raised',               sub:'MedPharma · LKR 85,000'          },
			{ time:'08:00', icon:'A', iconBg:'#E1F5EE', iconColor:'#0F6E56', text:'Attendance marked',            sub:'48 employees · 7 absent flagged' },
		  ],
		};

		/* ─────────────────────────────────────────────
		   DATASET 4 — Projects
		   Replace with: fetch('/api/dashboard/projects')
		───────────────────────────────────────────── */
		const DS_PROJECTS = {
		  list: [
			{ name:'ERP Phase 2 Rollout',     dept:'IT Dept',       client:'Internal',  start:'Jan 15, 2026', budget:1800000, spent:1100000, progress:68, status:'In Progress',   badge:'bb', color:'#185FA5' },
			{ name:'Branch Setup — Kandy',    dept:'Operations',    client:'Internal',  start:'Feb 01, 2026', budget:3200000, spent:2800000, progress:90, status:'Near Complete',  badge:'bt', color:'#3B6D11' },
			{ name:'Pharma Supply Contract',  dept:'MedPharma',     client:'MedPharma', start:'Mar 10, 2026', budget:5500000, spent:1400000, progress:25, status:'In Progress',   badge:'ba', color:'#EF9F27' },
			{ name:'Warehouse Expansion',     dept:'Logistics',     client:'Internal',  start:'Apr 01, 2026', budget:7000000, spent:2900000, progress:35, status:'At Risk',        badge:'br', color:'#534AB7' },
			{ name:'SMS Platform Integration',dept:'IT · Marketing',client:'Internal',  start:'Apr 20, 2026', budget:480000,  spent:120000,  progress:40, status:'On Track',       badge:'bg', color:'#0F6E56' },
		  ],
		};

		/* ─────────────────────────────────────────────
		   DATASET 5 — Top Selling Items
		   Replace with: fetch('/api/dashboard/top-items')
		───────────────────────────────────────────── */
		const DS_ITEMS = {
		  topItems: [
			{ name:'TVLE32MX-NM-FL-S',              value:2850000, color:'#D4537E' },
			{ name:'TVLE24MX-NM-S',                 value:1920000, color:'#854F0B' },
			{ name:'Samsung Galaxy S23',             value:1540000, color:'#3B6D11' },
			{ name:'TVLE32MX-SM-FL-S',              value:1230000, color:'#EF9F27' },
			{ name:'SINOPEC TULUX CI-4/SL 15W40',   value:890000,  color:'#534AB7' },
			{ name:'Samsung A02',                    value:420000,  color:'#B4B2A9' },
			{ name:'Others',                         value:540000,  color:'#e8e6df' },
		  ],
		};

		/* ─── HELPERS ─── */
function fmt(n){
  if(n>=1000000) return 'LKR '+(n/1000000).toFixed(2)+'M';
  if(n>=1000)    return 'LKR '+(n/1000).toFixed(0)+'K';
  return 'LKR '+n.toLocaleString();
}
function fmtShort(n){
  if(n>=1000000) return (n/1000000).toFixed(2)+'M';
  if(n>=1000)    return (n/1000).toFixed(0)+'K';
  return n.toLocaleString();
}
function pct(used,limit){ return Math.round(used/limit*100); }
function badgeClass(p){ return p>=90?'br':p>=70?'ba':'bg'; }
	</script>

	<!-- ============================================================
		 HTML SHELL
		 ============================================================ -->
<div class="main-content app-content">
    <div class="container-fluid">
	
		<div class="content">

			<!-- ── KPI STRIP ── -->
			<div class="g6" id="kpi-strip">
			<div class="kpi">
			  <div class="kpi-lbl">Today's Sales</div>
			  <div class="kpi-val">847K</div>
			  <div class="kpi-sub up">↑ -10% vs yesterday</div>
			</div>
			<div class="kpi">
			  <div class="kpi-lbl">Receivables</div>
			  <div class="kpi-val">2.30M</div>
			  <div class="kpi-sub wn">⚠ 18 overdue</div>
			</div>
			<div class="kpi">
			  <div class="kpi-lbl">Payables</div>
			  <div class="kpi-val">1.10M</div>
			  <div class="kpi-sub wn">3 due today</div>
			</div>
			<div class="kpi">
			  <div class="kpi-lbl">Net Cash</div>
			  <div class="kpi-val">4.60M</div>
			  <div class="kpi-sub up">↑ stable</div>
			</div>
			<div class="kpi">
			  <div class="kpi-lbl">Stock Value</div>
			  <div class="kpi-val">6.80M</div>
			  <div class="kpi-sub dn">↓ 5 low items</div>
			</div>
			<div class="kpi">
			  <div class="kpi-lbl">Purchases MTD</div>
			  <div class="kpi-val">3.20M</div>
			  <div class="kpi-sub wn">4 POs pending</div>
			</div></div>

			<!-- ── LEGACY SALES + TREND + TARGET ── -->
			<div class="sec-label">Sales overview</div>
			<div style="display:grid;grid-template-columns:1fr 1.6fr 200px;gap:12px;margin-bottom:12px">

<!-- Legacy Sales Block -->
<div class="card" style="padding:0;overflow:hidden">
    <div style="padding:10px 14px 6px;border-bottom:1px solid var(--border)">
        <div class="card-title">Total sales earnings</div>
    </div>
    <div class="sales-legacy" id="sales-legacy-block">
        <?php 
        $periods = [
            'today' => ['label' => 'Today', 'cls' => 'up'],
            'yesterday' => ['label' => 'Yesterday', 'cls' => 'wn'],
            'this_month' => ['label' => 'This Month', 'cls' => 'up'],
            'last_month' => ['label' => 'Last Month', 'cls' => '']
        ];
        foreach ($periods as $key => $p):
            $data = $sales_earnings[$key] ?? ['amount' => 0, 'bills' => 0, 'cash' => 0, 'card' => 0, 'credit' => 0];
        ?>
        <div class="sl-cell">
            <div class="sl-period <?= $p['cls'] ?>" style="color:<?= $p['cls'] == 'up' ? 'var(--green)' : ($p['cls'] == 'wn' ? 'var(--amber)' : 'var(--muted)') ?>">
                <?= $p['label'] ?>
            </div>
            <div class="sl-amount"><?= $this->Dashboard_model->format_currency($data['amount']) ?></div>
            <div class="sl-count"><?= $data['bills'] ?> Sales</div>
            <div class="sl-divider"></div>
            <div class="sl-split">
                <div class="sl-split-row"><span style="color:var(--muted)">Cash</span><span style="color:var(--green);font-weight:500"><?= $this->Dashboard_model->format_currency($data['cash']) ?></span></div>
                <div class="sl-split-row"><span style="color:var(--muted)">Card</span><span style="color:var(--blue);font-weight:500"><?= $this->Dashboard_model->format_currency($data['card']) ?></span></div>
                <div class="sl-split-row"><span style="color:var(--muted)">Credit</span><span style="color:var(--amber);font-weight:500"><?= $this->Dashboard_model->format_currency($data['credit']) ?></span></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Settled vs Sale Total -->
<div class="card">
    <div class="card-head">
        <div class="card-title">Sale total vs settled amount</div>
        <div style="display:flex;gap:5px">
            <span class="badge bg">Sale Total</span>
            <span class="badge bb">Settled</span>
        </div>
    </div>
    <div class="chart-wrap" style="height:160px">
        <canvas id="settledChart" role="img" aria-label="Sale total vs settled amount trend"></canvas>
    </div>
</div>

			  <!-- Target Achievement -->
			  <div class="card" style="display:flex;flex-direction:column;align-items:center;justify-content:center">
				<div class="card-title" style="margin-bottom:10px">Monthly target</div>
				<div style="position:relative;width:110px;height:110px">
				  <canvas id="targetChart" width="137" height="137" role="img" aria-label="Sales target achievement donut" style="display: block; box-sizing: border-box; height: 110px; width: 110px;"></canvas>
				  <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center">
					<div style="font-size:16px;font-weight:500;font-family:'DM Mono',monospace" id="target-pct-label">83%</div>
					<div style="font-size:9px;color:var(--muted)">achieved</div>
				  </div>
				</div>
				<div style="margin-top:8px;text-align:center">
				  <div style="font-size:9px;color:var(--muted)">Target</div>
				  <div style="font-size:12px;font-weight:500;font-family:'DM Mono',monospace" id="target-amount-label">15.00M</div>
				  <div style="font-size:9px;color:var(--muted);margin-top:3px">Achieved</div>
				  <div style="font-size:12px;font-weight:500;font-family:'DM Mono',monospace;color:var(--green)" id="achieved-amount-label">12.40M</div>
				</div>
			  </div>
			</div>

			<!-- ── DAILY SALES TREND ── -->
			<div class="g2a" style="margin-bottom:12px">
			  <div class="card">
				<div class="card-head"><div class="card-title">Alerts</div><div class="card-action">View all</div></div>
				<div id="alerts-list">
			<div class="alert-item">
			  <div class="adot dot-r"></div>
			  <div><div class="alert-text">12 items below reorder level</div><div class="alert-meta">Inventory · Reorder needed</div></div>
			</div>
			<div class="alert-item">
			  <div class="adot dot-r"></div>
			  <div><div class="alert-text">8 products expiring within 7 days</div><div class="alert-meta">Inventory · Urgent</div></div>
			</div>
			<div class="alert-item">
			  <div class="adot dot-a"></div>
			  <div><div class="alert-text">LKR 420K receivables overdue 60+ days</div><div class="alert-meta">Finance · 6 customers</div></div>
			</div>
			<div class="alert-item">
			  <div class="adot dot-a"></div>
			  <div><div class="alert-text">3 GRNs pending verification</div><div class="alert-meta">Purchasing · Action required</div></div>
			</div>
			<div class="alert-item">
			  <div class="adot dot-a"></div>
			  <div><div class="alert-text">7 employees absent today</div><div class="alert-meta">HRM · Unexcused</div></div>
			</div>
			<div class="alert-item">
			  <div class="adot dot-b"></div>
			  <div><div class="alert-text">Payroll processing due in 3 days</div><div class="alert-meta">HRM · 48 employees</div></div>
			</div></div>
			  </div>
			 <div class="card">
    <div class="card-head">
        <div class="card-title">Daily sales trend</div>
        <div style="display:flex;gap:5px;flex-wrap:wrap">
            <span class="badge bg">Cash</span>
            <span class="badge bb">Card</span>
            <span class="badge bp">Bank</span>
            <span class="badge ba">Cheque</span>
            <span class="badge br">Credit</span>
        </div>
    </div>
    <div class="chart-wrap" style="height:185px">
        <canvas id="salesChart" role="img" aria-label="Daily sales trend stacked bar chart"></canvas>
    </div>
</div>
			</div>

			<!-- Sales Analytics - Side by Side -->
<div class="sec-label">Sales analytics</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px">
    
    <!-- Top Selling Items -->
    <div class="card">
        <div class="card-head">
            <div class="card-title">Top selling items</div>
            <div class="card-action">View all</div>
        </div>
        <div style="display:grid;grid-template-columns:160px 1fr;gap:16px;align-items:center">
            <div style="position:relative;width:160px;height:160px">
                <canvas id="topItemsChart" width="200" height="200" role="img" aria-label="Top selling items donut chart"></canvas>
            </div>
            <div class="item-legend" id="top-items-legend">
                <?php if (!empty($top_items)): ?>
                    <?php foreach ($top_items as $item): ?>
                        <div class="item-leg-row">
                            <div class="item-leg-dot" style="background:<?= $item['color'] ?>"></div>
                            <div class="item-leg-name"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="item-leg-val"><?= $item['percentage'] ?>%</div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="padding:10px;text-align:center;color:var(--muted);font-size:11px;">No sales data available</div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Additional stats -->
        <?php if (!empty($top_items)): ?>
        <div style="border-top:1px solid var(--border);padding-top:9px;margin-top:9px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:5px">
            <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:4px">
                <div style="font-size:11px;font-weight:500;color:var(--green)"><?= number_format($top_items[0]['quantity'] ?? 0) ?></div>
                <div style="font-size:8px;color:var(--muted)">Units sold (top)</div>
            </div>
            <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:4px">
                <div style="font-size:11px;font-weight:500;color:var(--blue)"><?= number_format($top_items[0]['invoices'] ?? 0) ?></div>
                <div style="font-size:8px;color:var(--muted)">Invoices (top)</div>
            </div>
            <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:4px">
                <div style="font-size:11px;font-weight:500;color:var(--purple)"><?= count($top_items) ?></div>
                <div style="font-size:8px;color:var(--muted)">Top items</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Monthly Sales Progress -->
    <div class="card">
        <div class="card-head">
            <div class="card-title">Monthly sales progress</div>
            <div class="card-action"><?= date('Y') ?></div>
        </div>
        <div class="chart-wrap" style="height:175px">
            <canvas id="monthlyProgressChart" role="img" aria-label="Monthly sales progress bar chart"></canvas>
        </div>
        <?php if (!empty($monthly_progress['values'])): 
            $last_month = end($monthly_progress['values']);
            $highest = max($monthly_progress['values']);
            $average = round(array_sum($monthly_progress['values']) / count($monthly_progress['values']));
            $total = array_sum($monthly_progress['values']);
        ?>
        <div style="border-top:1px solid var(--border);padding-top:9px;margin-top:9px;display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:5px">
            <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:4px">
                <div style="font-size:11px;font-weight:500;color:var(--blue)"><?= number_format($last_month) ?>K</div>
                <div style="font-size:8px;color:var(--muted)">Last Month</div>
            </div>
            <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:4px">
                <div style="font-size:11px;font-weight:500;color:var(--green)"><?= number_format($highest) ?>K</div>
                <div style="font-size:8px;color:var(--muted)">Highest</div>
            </div>
            <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:4px">
                <div style="font-size:11px;font-weight:500;color:var(--amber)"><?= number_format($average) ?>K</div>
                <div style="font-size:8px;color:var(--muted)">Average</div>
            </div>
            <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:4px">
                <div style="font-size:11px;font-weight:500;color:var(--purple)"><?= number_format($total) ?>K</div>
                <div style="font-size:8px;color:var(--muted)">YTD Total</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
</div>
<!-- ── INVENTORY + PROCUREMENT ── -->
<div class="sec-label">Inventory &amp; procurement</div>
<div class="g22" style="display:block; width:100%;">
    <!-- Inventory Overview - Full Width -->
    <div class="card" style="width:100%;">
        <div class="card-head">
            <div class="card-title">Inventory overview</div>
            <div class="card-action">Manage stock</div>
        </div>
        
        <!-- Stock by Branch -->
        <div style="margin-bottom:10px">
            <div style="font-size:9px;color:var(--muted);margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px">
                Stock by branch (<?= $inventory_summary['branches'] ?? 0 ?> branches)
            </div>
            <div id="stock-branches">
                <?php if (!empty($stock_by_branch)): ?>
                    <?php foreach ($stock_by_branch as $branch): ?>
                        <div class="sb-row">
                            <div class="sb-lbl"><?= htmlspecialchars($branch->name) ?></div>
                            <div class="sb-wrap">
                                <div class="sb-fill" style="width:<?= $branch->pct ?>%;background:<?= $branch->pct >= 70 ? '#3B6D11' : ($branch->pct >= 40 ? '#EF9F27' : '#A32D2D') ?>"></div>
                            </div>
                            <div class="sb-val"><?= $branch->pct ?>%</div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="padding:8px;text-align:center;color:var(--muted);font-size:11px;">No stock data available</div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Inventory Summary Stats - Expanded to 4 columns -->
        <div style="border-top:1px solid var(--border);padding-top:9px">
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:5px;margin-bottom:8px">
                <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:6px">
                    <div style="font-size:13px;font-weight:500;color:var(--blue)"><?= number_format($inventory_summary['total_items'] ?? 0) ?></div>
                    <div style="font-size:8px;color:var(--muted)">Products</div>
                </div>
                <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:6px">
                    <div style="font-size:13px;font-weight:500;color:var(--green)"><?= number_format($inventory_summary['total_qty'] ?? 0) ?></div>
                    <div style="font-size:8px;color:var(--muted)">Total Qty</div>
                </div>
                <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:6px">
                    <div style="font-size:13px;font-weight:500;color:var(--purple)"><?= $inventory_summary['formatted_value'] ?? 'LKR 0' ?></div>
                    <div style="font-size:8px;color:var(--muted)">Stock Value</div>
                </div>
                <div style="text-align:center;background:var(--surface2);border-radius:4px;padding:6px">
                    <div style="font-size:13px;font-weight:500;color:var(--teal)"><?= number_format($inventory_summary['reserved_qty'] ?? 0) ?></div>
                    <div style="font-size:8px;color:var(--muted)">Reserved</div>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:5px">
                <div style="text-align:center;background:var(--red-bg);border-radius:4px;padding:4px">
                    <div style="font-size:13px;font-weight:500;color:var(--red)"><?= $inventory_summary['low_stock'] ?? 0 ?></div>
                    <div style="font-size:8px;color:var(--red)">Low Stock</div>
                </div>
                <div style="text-align:center;background:var(--amber-bg);border-radius:4px;padding:4px">
                    <div style="font-size:13px;font-weight:500;color:var(--amber)"><?= $inventory_summary['zero_stock'] ?? 0 ?></div>
                    <div style="font-size:8px;color:var(--amber)">Zero Stock</div>
                </div>
                <div style="text-align:center;background:var(--blue-bg);border-radius:4px;padding:4px">
                    <div style="font-size:13px;font-weight:500;color:var(--blue)"><?= number_format($inventory_summary['reserved_qty'] ?? 0) ?></div>
                    <div style="font-size:8px;color:var(--blue)">Reserved</div>
                </div>
            </div>
        </div>
        
        <!-- Stock Alerts -->
        <?php if (!empty($inventory_alerts)): ?>
        <div style="border-top:1px solid var(--border);padding-top:9px;margin-top:9px">
            <div style="font-size:9px;color:var(--red);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">⚠ Low Stock Alerts</div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;">
                <?php foreach ($inventory_alerts as $alert): ?>
                    <div class="li" style="padding:6px 8px;background:var(--red-bg);border-radius:4px;border-bottom:none;">
                        <div>
                            <div class="li-name" style="font-size:10px"><?= htmlspecialchars($alert->product_name ?? 'Unknown') ?></div>
                            <div class="li-sub" style="font-size:8px">
                                Available: <?= number_format($alert->available_qty ?? 0) ?> 
                                <?php if ($alert->reorder_level): ?>
                                    · Reorder: <?= $alert->reorder_level ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <span class="badge br">Low</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div> 

<!-- ── RECEIVABLES + FINANCIAL ── -->
<div class="g22">
    <div class="card">
        <div class="card-head">
            <div class="card-title">Customer receivables aging</div>
            <div class="card-action">View ledger</div>
        </div>
        <div style="margin-bottom:10px" id="customer-aging">
            <?php 
            // Get aging data from model
            $aging_buckets = $this->Dashboard_model->get_customer_receivables_aging();
            if (!empty($aging_buckets)): 
            ?>
                <?php foreach ($aging_buckets as $bucket): ?>
                    <div class="bar-row">
                        <div class="bar-lbl"><?= $bucket['label'] ?></div>
                        <div class="bar-wrap">
                            <div class="bar-fill" style="width:<?= $bucket['pct'] ?>%;background:<?= $bucket['color'] ?>"></div>
                        </div>
                        <div class="bar-val"><?= $bucket['formatted_val'] ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="padding:10px;text-align:center;color:var(--muted);font-size:11px;">No receivables data available</div>
            <?php endif; ?>
        </div>
        
        <div style="border-top:1px solid var(--border);padding-top:9px">
            <div style="font-size:9px;color:var(--muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Top credit customers</div>
            <div id="credit-customers">
                <?php 
                $top_customers = $this->Dashboard_model->get_top_overdue_customers(5);
                if (!empty($top_customers)): 
                ?>
                    <?php foreach ($top_customers as $customer): 
                        // Calculate usage percentage based on total overdue vs some limit
                        // For now, use a default or calculate from your data
                        $pct = 0;
                        if ($customer->total_overdue > 0) {
                            // You can set a credit limit per customer from your database
                            $credit_limit = 500000; // Default limit
                            $pct = min(round(($customer->total_overdue / $credit_limit) * 100), 100);
                        }
                        $badge_class = $pct >= 90 ? 'br' : ($pct >= 70 ? 'ba' : 'bg');
                    ?>
                        <div class="li">
                            <div>
                                <div class="li-name"><?= htmlspecialchars($customer->cus_name ?? 'Unknown') ?></div>
                                <div class="li-sub">
                                    <?= $customer->overdue_invoices ?? 0 ?> overdue invoices · 
                                    <?= $customer->total_overdue ? $this->Dashboard_model->format_currency($customer->total_overdue) : 'LKR 0' ?>
                                </div>
                            </div>
                            <span class="badge <?= $badge_class ?>"><?= $pct ?>%</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="padding:10px;text-align:center;color:var(--muted);font-size:11px;">No credit customers found</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
   <!-- Financial Snapshot -->
<div class="card">
    <div class="card-head">
        <div class="card-title">Financial snapshot</div>
        <div class="card-action">Trial balance</div>
    </div>
    
    <!-- P&L Rows -->
    <div id="pnl-rows" style="margin-bottom:10px">
        <?php 
        // Get financial data from your model
        // Make sure you have this method in your Dashboard_model
        $financial_data = $this->Dashboard_model->get_financial_snapshot();
        ?>
        <div class="pnl-row">
            <span style="color:var(--muted)">Revenue (MTD)</span>
            <span style="font-family:'DM Mono',monospace;font-weight:500;color:var(--green)">
                <?= $this->Dashboard_model->format_currency($financial_data['revenueMTD'] ?? 0) ?>
            </span>
        </div>
        <div class="pnl-row">
            <span style="color:var(--muted)">Expenses (MTD)</span>
            <span style="font-family:'DM Mono',monospace;font-weight:500;color:var(--red)">
                <?= $this->Dashboard_model->format_currency($financial_data['expensesMTD'] ?? 0) ?>
            </span>
        </div>
        <div class="pnl-row" style="border-top:1px solid var(--border);margin-top:3px;padding-top:7px">
            <span style="font-weight:500">Net Profit</span>
            <span style="font-family:'DM Mono',monospace;font-weight:500;color:<?= ($financial_data['netProfit'] ?? 0) >= 0 ? 'var(--green)' : 'var(--red)' ?>">
                <?= $this->Dashboard_model->format_currency($financial_data['netProfit'] ?? 0) ?>
            </span>
        </div>
    </div>
    
    <!-- P&L Chart -->
    <div class="chart-wrap" style="height:95px">
        <canvas id="plChart" role="img" aria-label="P&amp;L income vs expense bar chart"></canvas>
    </div>
    
    <!-- Footer Stats -->
    <div style="border-top:1px solid var(--border);padding-top:9px;margin-top:10px;display:flex;justify-content:space-between" id="fin-footer">
        <div>
            <div style="font-size:9px;color:var(--muted)">Double-entry</div>
            <div style="font-size:11px;font-weight:500;color:var(--green);margin-top:1px">
                <?= ($financial_data['doubleEntry'] ?? 'Balanced') ?> ✓
            </div>
        </div>
        <div>
            <div style="font-size:9px;color:var(--muted)">VAT liability</div>
            <div style="font-size:11px;font-weight:500;color:var(--amber);margin-top:1px">
                <?= $this->Dashboard_model->format_currency($financial_data['vatLiability'] ?? 0) ?> due
            </div>
        </div>
        <div>
            <div style="font-size:9px;color:var(--muted)">Journal entries</div>
            <div style="font-size:11px;font-weight:500;margin-top:1px">
                <?= number_format($financial_data['journalCount'] ?? 0) ?> this month
            </div>
        </div>
    </div>
</div>
</div>

<!-- ── RECEIVABLES VS PAYABLES 6M ── -->
<div class="sec-label">Credit &amp; payables movement — last 6 months</div>
<div class="card" style="margin-bottom:12px">
    <div class="card-head">
        <div class="card-title">Cumulative receivables vs payables</div>
        <div style="display:flex;gap:5px">
            <span class="badge bb">Receivables</span>
            <span class="badge br">Payables</span>
        </div>
    </div>
    <div class="legend">
        <div class="legend-item"><div class="legend-sq" style="background:#185FA5"></div>Total receivables</div>
        <div class="legend-item"><div class="legend-sq" style="background:#E24B4A"></div>Total payables</div>
        <div class="legend-item"><div class="legend-sq" style="background:#639922"></div>Net position</div>
    </div>
    <div class="chart-wrap" style="height:195px">
        <canvas id="creditChart" role="img" aria-label="Receivables vs payables line chart 6 months"></canvas>
    </div>
    <div class="fstrip" style="grid-template-columns:1fr 1fr 1fr" id="credit-footer">
        <div class="fstrip-cell">
            <div class="fstrip-lbl">Current receivables</div>
            <div class="fstrip-val" style="color:var(--blue)"><?= $rp_summary['receivables']['formatted'] ?? 'LKR 0' ?></div>
            <div style="font-size:9px;color:var(--red);margin-top:1px">
                <?php if (($rp_summary['receivables']['overdue_count'] ?? 0) > 0): ?>
                    ⚠ <?= $rp_summary['receivables']['overdue_count'] ?> overdue (<?= $rp_summary['receivables']['overdue_formatted'] ?>)
                <?php else: ?>
                    All current ✓
                <?php endif; ?>
            </div>
        </div>
        <div class="fstrip-cell">
            <div class="fstrip-lbl">Current payables</div>
            <div class="fstrip-val" style="color:var(--red)"><?= $rp_summary['payables']['formatted'] ?? 'LKR 0' ?></div>
            <div style="font-size:9px;color:var(--red);margin-top:1px">
                <?php if (($rp_summary['payables']['overdue_count'] ?? 0) > 0): ?>
                    ⚠ <?= $rp_summary['payables']['overdue_count'] ?> overdue (<?= $rp_summary['payables']['overdue_formatted'] ?>)
                <?php else: ?>
                    All current ✓
                <?php endif; ?>
            </div>
        </div>
        <div class="fstrip-cell" style="border-right:none">
            <div class="fstrip-lbl">Net position</div>
            <div class="fstrip-val" style="color:<?= $rp_summary['is_favourable'] ? 'var(--green)' : 'var(--red)' ?>">
                <?= $rp_summary['net_formatted'] ?? 'LKR 0' ?>
            </div>
            <div style="font-size:9px;color:<?= $rp_summary['is_favourable'] ? 'var(--green)' : 'var(--red)' ?>;margin-top:1px">
                <?= $rp_summary['is_favourable'] ? 'Favourable ✓' : 'Unfavourable' ?>
            </div>
        </div>
    </div>
</div>

<!-- ── MONTHLY COLLECTIONS ── -->
<div class="sec-label">Collections — month wise</div>
<div class="card" style="margin-bottom:12px">
    <div class="card-head">
        <div class="card-title">Monthly collections vs billed</div>
        <div class="card-action">
            <span style="font-size:9px;color:var(--green);font-weight:500">
                Collection Rate: <?= $collection_summary['collection_rate'] ?? 0 ?>%
            </span>
        </div>
    </div>
    <div class="legend">
        <div class="legend-item">
            <div class="legend-sq" style="background:#534AB7;opacity:.4"></div>
            Total billed
        </div>
        <div class="legend-item">
            <div class="legend-sq" style="background:#3B6D11"></div>
            Cash + Card
        </div>
        <div class="legend-item">
            <div class="legend-sq" style="background:#EF9F27"></div>
            Credit recovered
        </div>
    </div>
    <div class="chart-wrap" style="height:175px">
        <canvas id="collChart" role="img" aria-label="Monthly collections bar chart"></canvas>
    </div>
    <div class="fstrip" style="grid-template-columns:1fr 1fr 1fr 1fr" id="coll-footer">
        <div class="fstrip-cell">
            <div class="fstrip-lbl">MTD billed</div>
            <div class="fstrip-val"><?= $collection_summary['formatted_billed'] ?? '0' ?></div>
        </div>
        <div class="fstrip-cell">
            <div class="fstrip-lbl">MTD collected</div>
            <div class="fstrip-val" style="color:var(--green)"><?= $collection_summary['formatted_collected'] ?? '0' ?></div>
        </div>
        <div class="fstrip-cell">
            <div class="fstrip-lbl">Credit recovered</div>
            <div class="fstrip-val" style="color:var(--amber)"><?= $collection_summary['formatted_credit'] ?? '0' ?></div>
        </div>
        <div class="fstrip-cell" style="border-right:none">
            <div class="fstrip-lbl">Collection rate</div>
            <div class="fstrip-val" style="color:var(--purple)"><?= $collection_summary['collection_rate'] ?? 0 ?>%</div>
        </div>
    </div>
</div>

<!-- ── HRM + SMS ── -->
<div class="sec-label">HRM &amp; SMS campaign</div>
<div class="g22">
    <div class="card">
        <div class="card-head">
            <div class="card-title">HRM overview</div>
            <div class="card-action">Manage</div>
        </div>
        <div class="donut-wrap" style="margin-bottom:12px">
            <div style="position:relative;width:80px;height:80px;flex-shrink:0">
                <canvas id="attendChart" width="100" height="100" role="img" aria-label="Attendance donut chart" style="display: block; box-sizing: border-box; height: 80px; width: 80px;"></canvas>
                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center">
                    <div style="font-size:14px;font-weight:500;font-family:'DM Mono',monospace" id="attend-present"><?= $hrm_data['active_staff'] ?? 0 ?></div>
                    <div style="font-size:8px;color:var(--muted)">active</div>
                </div>
            </div>
            <div id="attend-legend">
                <div class="leg-row"><div class="leg-sq" style="background:#3B6D11"></div>Active — <?= $hrm_data['active_staff'] ?? 0 ?></div>
                <div class="leg-row"><div class="leg-sq" style="background:#E24B4A"></div>Inactive — <?= $hrm_data['inactive_staff'] ?? 0 ?></div>
                <div class="leg-row"><div class="leg-sq" style="background:#185FA5"></div>Male — <?= $hrm_data['male_staff'] ?? 0 ?></div>
                <div class="leg-row"><div class="leg-sq" style="background:#EF9F27"></div>Female — <?= $hrm_data['female_staff'] ?? 0 ?></div>
            </div>
        </div>
        <div class="mini-grid" id="hrm-mini">
            <div class="mini-stat">
                <div class="mini-num"><?= $hrm_data['total_staff'] ?? 0 ?></div>
                <div class="mini-lbl">Total staff</div>
            </div>
            <div class="mini-stat">
                <div class="mini-num" style="color:var(--amber)"><?= $hrm_data['pending_leaves'] ?? 0 ?></div>
                <div class="mini-lbl">Leave pending</div>
            </div>
            <div class="mini-stat">
                <div class="mini-num" style="color:var(--blue);font-size:11px"><?= $hrm_data['formatted_salary'] ?? '0' ?></div>
                <div class="mini-lbl">Monthly payroll</div>
            </div>
            <div class="mini-stat">
                <div class="mini-num" style="color:var(--green);font-size:11px"><?= date('M d') ?></div>
                <div class="mini-lbl">Pay date</div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-head">
            <div class="card-title">Leave requests</div>
            <div class="card-action">View all</div>
        </div>
        <div style="font-size:9px;color:var(--muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Recent leave requests</div>
        <div id="leave-requests">
            <?php if (!empty($leave_requests)): ?>
                <?php foreach ($leave_requests as $leave): ?>
                    <div class="li">
                        <div>
                            <div class="li-name"><?= htmlspecialchars($leave->full_name ?? 'Unknown') ?></div>
                            <div class="li-sub"><?= htmlspecialchars($leave->designation ?? '') ?> · <?= date('M d', strtotime($leave->start_date)) ?> - <?= date('M d', strtotime($leave->end_date)) ?> (<?= $leave->total_days ?> days)</div>
                        </div>
                        <span class="badge <?= $leave->status == 'request' ? 'ba' : ($leave->status == 'approved' ? 'bg' : 'br') ?>">
                            <?= ucfirst($leave->status ?? 'Pending') ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="padding:10px;text-align:center;color:var(--muted);font-size:11px;">No leave requests found</div>
            <?php endif; ?>
        </div>
        
        <div style="border-top:1px solid var(--border);padding-top:9px;margin-top:6px">
            <div style="display:flex;justify-content:space-between;font-size:10px">
                <span style="color:var(--muted)">Leave statistics</span>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:5px;margin-top:4px">
                <div style="background:var(--surface2);border-radius:4px;padding:4px;text-align:center">
                    <div style="font-size:12px;font-weight:500;color:var(--amber)"><?= $hrm_data['pending_leaves'] ?? 0 ?></div>
                    <div style="font-size:8px;color:var(--muted)">Pending</div>
                </div>
                <div style="background:var(--surface2);border-radius:4px;padding:4px;text-align:center">
                    <div style="font-size:12px;font-weight:500;color:var(--green)"><?= $hrm_data['approved_leaves'] ?? 0 ?></div>
                    <div style="font-size:8px;color:var(--muted)">Approved</div>
                </div>
                <div style="background:var(--surface2);border-radius:4px;padding:4px;text-align:center">
                    <div style="font-size:12px;font-weight:500;color:var(--red)"><?= $hrm_data['rejected_leaves'] ?? 0 ?></div>
                    <div style="font-size:8px;color:var(--muted)">Rejected</div>
                </div>
            </div>
        </div>
    </div>
</div>

			<!-- ── PROJECTS ── -->
<div class="sec-label">Ongoing projects</div>
<div class="card" style="margin-bottom:12px">
    <div class="card-head">
        <div class="card-title">Project tracker</div>
        <div class="card-action">Add project</div>
    </div>
    <table class="ptable">
        <thead>
            <tr>
                <th>Project</th>
                <th>Client</th>
                <th>Start date</th>
                <th>Budget</th>
                <th>Progress</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="proj-rows">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): 
                    $progress = $this->Dashboard_model->calculate_project_progress($project->project_id);
                ?>
                <tr>
                    <td>
                        <div style="font-weight:500"><?= htmlspecialchars($project->project_name) ?></div>
                        <div class="li-sub"><?= htmlspecialchars($project->branch_name ?? 'N/A') ?></div>
                    </td>
                    <td style="color:var(--muted);font-size:10px"><?= htmlspecialchars($project->client_name ?? 'Internal') ?></td>
                    <td style="font-family:'DM Mono',monospace;font-size:9px;color:var(--muted)"><?= date('M d, Y', strtotime($project->start_date)) ?></td>
                    <td style="font-family:'DM Mono',monospace;font-size:10px"><?= $this->Dashboard_model->format_currency($project->estimated_budget) ?></td>
                    <td>
                        <div class="pbar-wrap">
                            <div class="pbar-fill" style="width:<?= $progress ?>%;background:<?= $progress >= 70 ? '#3B6D11' : ($progress >= 40 ? '#EF9F27' : '#534AB7') ?>"></div>
                        </div>
                        <div style="font-size:9px;color:var(--muted);margin-top:2px"><?= $progress ?>%</div>
                    </td>
                    <td><span class="badge <?= $this->Dashboard_model->get_project_status_badge($project->project_status) ?>"><?= htmlspecialchars($project->project_status ?? 'Planning') ?></span></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;padding:20px;color:var(--muted)">No projects found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="fstrip" style="grid-template-columns:1fr 1fr 1fr 1fr" id="proj-footer">
        <div class="fstrip-cell">
            <div class="fstrip-lbl">Active projects</div>
            <div class="fstrip-val"><?= $project_stats['total'] ?? 0 ?></div>
        </div>
        <div class="fstrip-cell">
            <div class="fstrip-lbl">In Progress</div>
            <div class="fstrip-val" style="color:var(--amber)"><?= ($project_stats['in_progress'] ?? 0) + ($project_stats['on_track'] ?? 0) ?></div>
        </div>
        <div class="fstrip-cell">
            <div class="fstrip-lbl">At Risk</div>
            <div class="fstrip-val" style="color:var(--red)"><?= $project_stats['at_risk'] ?? 0 ?></div>
        </div>
        <div class="fstrip-cell" style="border-right:none">
            <div class="fstrip-lbl">Completed</div>
            <div class="fstrip-val" style="color:var(--green)"><?= $project_stats['completed'] ?? 0 ?></div>
        </div>
    </div>
</div>

			<!-- ── ACTIVITY FEED ── -->
			<div class="sec-label">Recent activity</div>
			<div class="card" style="margin-bottom:12px">
			  <div class="card-head"><div class="card-title">Live activity feed</div><div class="card-action">View audit log</div></div>
			  <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0 18px" id="activity-feed">
			<div>
			  <div class="act-item">
				<div class="act-time">10:42</div>
				<div class="act-icon" style="background:#EAF3DE;color:#3B6D11">$</div>
				<div><div style="font-size:11px">Invoice #INV-4415 created</div><div class="act-sub">Saman Enterprises · LKR 48,500</div></div>
			  </div>
			  <div class="act-item">
				<div class="act-time">09:30</div>
				<div class="act-icon" style="background:#FAEEDA;color:#854F0B">J</div>
				<div><div style="font-size:11px">Journal entry posted</div><div class="act-sub">Salary advance · Balanced</div></div>
			  </div>
			  <div class="act-item">
				<div class="act-time">08:35</div>
				<div class="act-icon" style="background:#EAF3DE;color:#3B6D11">C</div>
				<div><div style="font-size:11px">New customer added</div><div class="act-sub">Nimal &amp; Brothers · Gampaha</div></div>
			  </div>
			</div>
			<div>
			  <div class="act-item">
				<div class="act-time">10:20</div>
				<div class="act-icon" style="background:#E6F1FB;color:#185FA5">P</div>
				<div><div style="font-size:11px">Payment received</div><div class="act-sub">Colombo Traders · LKR 120,000</div></div>
			  </div>
			  <div class="act-item">
				<div class="act-time">09:10</div>
				<div class="act-icon" style="background:#EEEDFE;color:#534AB7">S</div>
				<div><div style="font-size:11px">SMS campaign triggered</div><div class="act-sub">Credit reminder · 84 recipients</div></div>
			  </div>
			  <div class="act-item">
				<div class="act-time">08:20</div>
				<div class="act-icon" style="background:#E6F1FB;color:#185FA5">O</div>
				<div><div style="font-size:11px">PO-2246 raised</div><div class="act-sub">MedPharma · LKR 85,000</div></div>
			  </div>
			</div>
			<div>
			  <div class="act-item">
				<div class="act-time">09:55</div>
				<div class="act-icon" style="background:#E1F5EE;color:#0F6E56">G</div>
				<div><div style="font-size:11px">GRN-0892 completed</div><div class="act-sub">Lanka Distributors · 12 items</div></div>
			  </div>
			  <div class="act-item">
				<div class="act-time">08:50</div>
				<div class="act-icon" style="background:#FCEBEB;color:#A32D2D">!</div>
				<div><div style="font-size:11px">Low stock alert raised</div><div class="act-sub">Paracetamol 500mg · 12 units</div></div>
			  </div>
			  <div class="act-item">
				<div class="act-time">08:00</div>
				<div class="act-icon" style="background:#E1F5EE;color:#0F6E56">A</div>
				<div><div style="font-size:11px">Attendance marked</div><div class="act-sub">48 employees · 7 absent flagged</div></div>
			  </div>
			</div></div>
			</div>

		  </div>
	
	</div>
</div>

<span class="nav-badge" id="nb-sales">—</span>
<span class="nav-badge" id="nb-inv">—</span>
<!-- ============================================================
     RENDER ENGINE — reads from DS_* and populates the DOM
     ============================================================ -->
<script>

// ============================================================
// RENDER ENGINE — reads from DS_* and populates the DOM
// ============================================================

/* ─── HELPERS ─── */
function fmt(n){
  if(n>=1000000) return 'LKR '+(n/1000000).toFixed(2)+'M';
  if(n>=1000)    return 'LKR '+(n/1000).toFixed(0)+'K';
  return 'LKR '+n.toLocaleString();
}
function fmtShort(n){
  if(n>=1000000) return (n/1000000).toFixed(2)+'M';
  if(n>=1000)    return (n/1000).toFixed(0)+'K';
  return n.toLocaleString();
}
function pct(used,limit){ return Math.round(used/limit*100); }
function badgeClass(p){ return p>=90?'br':p>=70?'ba':'bg'; }

// Wait for DOM to be fully loaded before running any code
document.addEventListener('DOMContentLoaded', function() {

  /* ── KPI STRIP ── */
  (function(){
    const k = DS_KPI;
    const strip = document.getElementById('kpi-strip');
    if (!strip) return;
    const items = [
      { lbl:"Today's Sales", val:fmtShort(k.salesToday.amount),     sub:`↑ ${pct(k.salesToday.amount,k.salesYesterday.amount)-100+Math.round((k.salesToday.amount-k.salesYesterday.amount)/k.salesYesterday.amount*100)}% vs yesterday`, cls:'up' },
      { lbl:"Receivables",   val:fmtShort(k.receivables.total),      sub:`⚠ ${k.receivables.overdue} overdue`,  cls:'wn' },
      { lbl:"Payables",      val:fmtShort(k.payables.total),         sub:`${k.payables.dueToday} due today`,    cls:'wn' },
      { lbl:"Net Cash",      val:fmtShort(k.netCash.total),          sub:'↑ stable',                            cls:'up' },
      { lbl:"Stock Value",   val:fmtShort(k.stockValue.total),       sub:`↓ ${k.stockValue.lowItems} low items`,cls:'dn' },
      { lbl:"Purchases MTD", val:fmtShort(k.purchasesMTD.total),     sub:`${k.purchasesMTD.pendingPOs} POs pending`, cls:'wn' },
    ];
    strip.innerHTML = items.map(i=>`
      <div class="kpi">
        <div class="kpi-lbl">${i.lbl}</div>
        <div class="kpi-val">${i.val}</div>
        <div class="kpi-sub ${i.cls}">${i.sub}</div>
      </div>`).join('');

    const nbSales = document.getElementById('nb-sales');
    const nbInv = document.getElementById('nb-inv');
    if (nbSales) nbSales.textContent = DS_KPI.salesToday.bills;
    if (nbInv) nbInv.textContent = DS_KPI.stockValue.lowItems;
  })();

  /* ── LEGACY SALES BLOCK ── */
  // DISABLED - Now rendered by PHP in the HTML

  /* ── TARGET DONUT ── */
  (function(){
    const t = DS_KPI.salesTarget;
    const achPct = Math.round(t.achieved/t.target*100);
    const targetLabel = document.getElementById('target-pct-label');
    const targetAmount = document.getElementById('target-amount-label');
    const achievedAmount = document.getElementById('achieved-amount-label');
    const targetChart = document.getElementById('targetChart');
    
    if (targetLabel) targetLabel.textContent = achPct+'%';
    if (targetAmount) targetAmount.textContent = fmtShort(t.target);
    if (achievedAmount) achievedAmount.textContent = fmtShort(t.achieved);
    
    if (targetChart) {
      const color = achPct>=100?'#3B6D11':achPct>=70?'#EF9F27':'#E24B4A';
      new Chart(targetChart, {
        type:'doughnut',
        data:{datasets:[{data:[achPct,100-achPct],backgroundColor:[color,'#e8e6df'],borderWidth:0,cutout:'72%'}]},
        options:{responsive:false,plugins:{legend:{display:false},tooltip:{enabled:false}}}
      });
    }
  })();

  /* ── ALERTS ── */
  (function(){
    const alertsList = document.getElementById('alerts-list');
    if (!alertsList) return;
    const dotMap = {red:'dot-r',amber:'dot-a',blue:'dot-b'};
    alertsList.innerHTML = DS_OPS.alerts.map(a=>`
      <div class="alert-item">
        <div class="adot ${dotMap[a.level]}"></div>
        <div><div class="alert-text">${a.text}</div><div class="alert-meta">${a.meta}</div></div>
      </div>`).join('');
  })();

  /* ── TOP SELLING ITEMS ── */
(function() {
    const topItemsData = <?= json_encode($top_items) ?>;
    const ctx = document.getElementById('topItemsChart');
    
    if (ctx && topItemsData && topItemsData.length > 0) {
        const labels = topItemsData.map(item => item.name);
        const values = topItemsData.map(item => item.value);
        const colors = topItemsData.map(item => item.color);
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 2,
                    borderColor: '#fff',
                    cutout: '58%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                const item = topItemsData[c.dataIndex];
                                return [
                                    'Item: ' + item.name,
                                    'Sales: LKR ' + c.raw.toLocaleString(),
                                    'Units: ' + item.quantity,
                                    'Invoices: ' + item.invoices,
                                    'Share: ' + item.percentage + '%'
                                ];
                            }
                        }
                    }
                }
            }
        });
    } else if (ctx) {
        // Show empty state
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['No Data'],
                datasets: [{
                    data: [1],
                    backgroundColor: ['#e8e6df'],
                    borderWidth: 0,
                    cutout: '58%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });
    }
})();

  /* ── STOCK BRANCHES ── */
  (function(){
    const stockBranches = document.getElementById('stock-branches');
    if (!stockBranches) return;
    stockBranches.innerHTML = DS_OPS.stockByBranch.map(b=>`
      <div class="sb-row">
        <div class="sb-lbl">${b.name}</div>
        <div class="sb-wrap"><div class="sb-fill" style="width:${b.pct}%;background:${b.color}"></div></div>
        <div class="sb-val">${b.pct}%</div>
      </div>`).join('');
  })();

  /* ── EXPIRY LIST ── */
  (function(){
    const expiryList = document.getElementById('expiry-list');
    if (!expiryList) return;
    expiryList.innerHTML = DS_OPS.expiryAlerts.map(e=>`
      <div class="li">
        <div><div class="li-name">${e.name}</div><div class="li-sub">Lot ${e.lot} · ${e.units} units</div></div>
        <span class="badge ${e.badge}">${e.days} days</span>
      </div>`).join('');
  })();

  /* ── PO LIST ── */
  (function(){
    const poList = document.getElementById('po-list');
    if (!poList) return;
    poList.innerHTML = DS_OPS.purchaseOrders.map(p=>`
      <div class="li">
        <div><div class="li-name">${p.supplier}</div><div class="li-sub">${p.poNo} · ${p.items} items · Due ${p.due}</div></div>
        <span class="badge ${p.badge}">${p.status}</span>
      </div>`).join('');
  })();

  /* ── AGING BARS ── */
function renderAging(elId, data){
  const el = document.getElementById(elId);
  if (!el) return;
  el.innerHTML = data.map(a=>`
    <div class="bar-row">
      <div class="bar-lbl">${a.label}</div>
      <div class="bar-wrap"><div class="bar-fill" style="width:${a.pct}%;background:${a.color}"></div></div>
      <div class="bar-val">${a.val}</div>
    </div>`).join('');
}
renderAging('supplier-aging', DS_OPS.supplierAging);
// renderAging('customer-aging', DS_OPS.customerAging); // DISABLED - Now rendered by PHP

  /* ── CREDIT CUSTOMERS 
  (function(){
    const creditCustomers = document.getElementById('credit-customers');
    if (!creditCustomers) return;
    creditCustomers.innerHTML = DS_OPS.topCreditCustomers.map(c=>{
      const p = pct(c.used,c.limit);
      return `<div class="li">
        <div><div class="li-name">${c.name}</div><div class="li-sub">${fmtShort(c.limit)} limit · ${fmtShort(c.used)} used</div></div>
        <span class="badge ${badgeClass(p)}">${p}%</span>
      </div>`;
    }).join('');
  })(); ── */

  /* ── PNL ROWS 
  (function(){
    const f = DS_OPS.financials;
    const pnlRows = document.getElementById('pnl-rows');
    if (pnlRows) {
      pnlRows.innerHTML = `
        <div class="pnl-row"><span style="color:var(--muted)">Revenue (MTD)</span><span style="font-family:'DM Mono',monospace;font-weight:500;color:var(--green)">${fmt(f.revenueMTD)}</span></div>
        <div class="pnl-row"><span style="color:var(--muted)">Expenses (MTD)</span><span style="font-family:'DM Mono',monospace;font-weight:500;color:var(--red)">${fmt(f.expensesMTD)}</span></div>
        <div class="pnl-row" style="border-top:1px solid var(--border);margin-top:3px;padding-top:7px"><span style="font-weight:500">Net Profit</span><span style="font-family:'DM Mono',monospace;font-weight:500;color:var(--green)">${fmt(f.netProfit)}</span></div>`;
    }
    const finFooter = document.getElementById('fin-footer');
    if (finFooter) {
      finFooter.innerHTML = `
        <div><div style="font-size:9px;color:var(--muted)">Double-entry</div><div style="font-size:11px;font-weight:500;color:var(--green);margin-top:1px">${f.doubleEntry} ✓</div></div>
        <div><div style="font-size:9px;color:var(--muted)">VAT liability</div><div style="font-size:11px;font-weight:500;color:var(--amber);margin-top:1px">${fmt(f.vatLiability)} due</div></div>
        <div><div style="font-size:9px;color:var(--muted)">Journal entries</div><div style="font-size:11px;font-weight:500;margin-top:1px">${f.journalCount} this month</div></div>`;
    }
  })();── */

  /* ── SMS ── */
  (function(){
    const smsCampaigns = document.getElementById('sms-campaigns');
    if (smsCampaigns) {
      smsCampaigns.innerHTML = DS_OPS.smsCampaigns.map(c=>`
        <div class="sms-row">
          <div style="flex:1"><div style="font-weight:500;font-size:11px;margin-bottom:3px">${c.name}</div>
          <div class="sms-bar-wrap"><div class="sms-bar-fill" style="width:${Math.round(c.sent/c.total*100)}%;background:${c.color}"></div></div></div>
          <div style="text-align:right;min-width:44px"><div style="font-size:11px;font-weight:500">${c.sent.toLocaleString()}</div><div style="font-size:9px;color:var(--muted)">sent</div></div>
        </div>`).join('');
    }
    const u = DS_OPS.smsUsage;
    const usageLabel = document.getElementById('sms-usage-label');
    const usageBar = document.getElementById('sms-usage-bar');
    if (usageLabel) usageLabel.textContent = `${u.used.toLocaleString()} / ${u.quota.toLocaleString()}`;
    if (usageBar) usageBar.style.width = Math.round(u.used/u.quota*100)+'%';
    const smsRecent = document.getElementById('sms-recent');
    if (smsRecent) {
      smsRecent.innerHTML = DS_OPS.smsRecent.map(r=>`
        <div style="display:flex;justify-content:space-between;align-items:center">
          <span style="color:var(--muted)">${r.msg}</span>
          <span class="badge ${r.badge}">${r.status}</span>
        </div>`).join('');
    }
  })();

  // ============================================================
  // ALL CHARTS - Initialized on page load (ONLY ONCE!)
  // ============================================================

  // 1. Sales Trend Chart (static data from DS_CHARTS)
const salesChart = document.getElementById('salesChart');
if (salesChart) {
    const salesTrendData = <?= json_encode($sales_trend) ?>;
    
    new Chart(salesChart, {
        type: 'bar',
        data: {
            labels: salesTrendData.labels,
            datasets: [
                {
                    label: 'Cash',
                    data: salesTrendData.cash,
                    backgroundColor: '#3B6D11',
                    stack: 's'
                },
                {
                    label: 'Card',
                    data: salesTrendData.card,
                    backgroundColor: '#185FA5',
                    stack: 's'
                },
                {
                    label: 'Bank Transfer',
                    data: salesTrendData.bank,
                    backgroundColor: '#534AB7',
                    stack: 's'
                },
                {
                    label: 'Cheque',
                    data: salesTrendData.cheque,
                    backgroundColor: '#EF9F27',
                    stack: 's'
                },
                {
                    label: 'Credit',
                    data: salesTrendData.credit,
                    backgroundColor: '#A32D2D',
                    stack: 's'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(c) {
                            return c.dataset.label + ': LKR ' + c.raw.toFixed(1) + 'K';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 9 }, color: '#7a786f' },
                    border: { display: false }
                },
                y: {
                    grid: { color: '#e8e6df' },
                    ticks: {
                        font: { size: 9 },
                        color: '#7a786f',
                        callback: function(v) {
                            return v + 'K';
                        }
                    },
                    border: { display: false }
                }
            }
        }
    });
}

 // P&L Chart - Dynamic PHP Data
(function() {
    const plData = <?= json_encode($this->Dashboard_model->get_pl_trend(6)) ?>;
    const ctx = document.getElementById('plChart');
    
    if (ctx && plData && plData.labels && plData.labels.length > 0) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: plData.labels,
                datasets: [
                    {
                        label: 'Income',
                        data: plData.income,
                        backgroundColor: '#3B6D11',
                        borderRadius: 3
                    },
                    {
                        label: 'Expense',
                        data: plData.expenses,
                        backgroundColor: '#e8e6df',
                        borderRadius: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                return c.dataset.label + ': LKR ' + c.raw.toFixed(1) + 'M';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { 
                            font: { size: 9 }, 
                            color: '#7a786f'
                        },
                        border: { display: false }
                    },
                    y: {
                        display: false
                    }
                }
            }
        });
    }
})();

  // Monthly Progress Chart - DYNAMIC PHP DATA
(function() {
    const progressData = <?= json_encode($monthly_progress) ?>;
    const ctx = document.getElementById('monthlyProgressChart');
    
    if (ctx && progressData && progressData.labels && progressData.labels.length > 0) {
        // Prepare datasets
        const datasets = [];
        
        // Main sales data
        datasets.push({
            label: 'Sales',
            data: progressData.values,
            backgroundColor: progressData.values.map(v => {
                if (v === 0) return '#e8e6df';
                // Color based on value
                if (v >= 1000) return 'rgba(59,109,17,0.8)';
                if (v >= 500) return 'rgba(59,109,17,0.6)';
                return 'rgba(59,109,17,0.4)';
            }),
            borderRadius: 4,
            borderSkipped: false
        });
        
        // Optional: Add target line if targets exist
        if (progressData.targets && progressData.targets.some(t => t !== null)) {
            datasets.push({
                label: 'Target',
                data: progressData.targets,
                type: 'line',
                borderColor: '#E24B4A',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 4,
                pointBackgroundColor: '#E24B4A',
                fill: false,
                tension: 0.1
            });
        }
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: progressData.labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: progressData.targets && progressData.targets.some(t => t !== null),
                        position: 'top',
                        labels: {
                            font: { size: 9 },
                            color: '#7a786f',
                            boxWidth: 12
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                if (c.dataset.label === 'Target') {
                                    return 'Target: LKR ' + c.raw.toLocaleString() + 'K';
                                }
                                return c.dataset.label + ': LKR ' + c.raw.toLocaleString() + 'K';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { 
                            font: { size: 9 }, 
                            color: '#7a786f',
                            maxRotation: 45
                        },
                        border: { display: false }
                    },
                    y: {
                        grid: { color: '#e8e6df' },
                        ticks: {
                            font: { size: 9 },
                            color: '#7a786f',
                            callback: function(v) {
                                if (v === 0) return '0';
                                if (v >= 1000) return (v / 1000).toFixed(1) + 'M';
                                return v.toLocaleString() + 'K';
                            }
                        },
                        border: { display: false }
                    }
                }
            }
        });
    }
})();
  // 4. Settled vs Sale Total Chart - DYNAMIC PHP DATA
  (function() {
    const settledData = <?= json_encode($settled_vs_total) ?>;
    const settledCtx = document.getElementById('settledChart');
    if (settledCtx && settledData && settledData.labels && settledData.labels.length > 0) {
      new Chart(settledCtx, {
        type: 'line',
        data: {
          labels: settledData.labels,
          datasets: [
            {
              label: 'Sale Total',
              data: settledData.saleTotal,
              borderColor: '#3B6D11',
              backgroundColor: 'rgba(59,109,17,0.07)',
              borderWidth: 2,
              pointRadius: 3,
              pointBackgroundColor: '#3B6D11',
              fill: true,
              tension: 0.3
            },
            {
              label: 'Settled Amt',
              data: settledData.settledAmt,
              borderColor: '#185FA5',
              backgroundColor: 'rgba(24,95,165,0.07)',
              borderWidth: 2,
              pointRadius: 3,
              pointBackgroundColor: '#185FA5',
              fill: true,
              tension: 0.3
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => c.dataset.label + ': LKR ' + c.raw.toLocaleString() + 'K' } } },
          scales: {
            x: { grid: { display: false }, ticks: { font: { size: 8 }, color: '#7a786f', maxRotation: 45 }, border: { display: false } },
            y: { grid: { color: '#e8e6df' }, ticks: { font: { size: 9 }, color: '#7a786f', callback: v => (v / 1000).toFixed(0) + 'M' }, border: { display: false } }
          }
        }
      });
    }
  })();

  // 5. Monthly Collections Chart - DYNAMIC PHP DATA
  (function() {
    const collData = <?= json_encode($monthly_collections) ?>;
    const collCtx = document.getElementById('collChart');
    if (collCtx && collData && collData.labels && collData.labels.length > 0) {
      new Chart(collCtx, {
        type: 'bar',
        data: {
          labels: collData.labels,
          datasets: [
            {
              label: 'Total billed',
              data: collData.billed,
              backgroundColor: 'rgba(83,74,183,0.15)',
              borderColor: '#534AB7',
              borderWidth: 1,
              borderRadius: 4
            },
            {
              label: 'Cash+Card',
              data: collData.cashCard,
              backgroundColor: '#3B6D11',
              borderRadius: 4
            },
            {
              label: 'Credit recovered',
              data: collData.creditRecovered,
              backgroundColor: '#EF9F27',
              borderRadius: 4
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => c.dataset.label + ': LKR ' + (c.raw / 1000).toFixed(1) + 'M' } } },
          scales: {
            x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#7a786f' }, border: { display: false } },
            y: { grid: { color: '#e8e6df' }, ticks: { font: { size: 10 }, color: '#7a786f', callback: v => 'LKR ' + (v / 1000).toFixed(0) + 'K' }, border: { display: false } }
          }
        }
      });
    }
  })();

 // 6. Receivables vs Payables Chart - DYNAMIC PHP DATA
(function() {
    const rpData = <?= json_encode($rp_trend) ?>;
    const rpCtx = document.getElementById('creditChart');
    if (rpCtx && rpData && rpData.labels && rpData.labels.length > 0) {
        new Chart(rpCtx, {
            type: 'line',
            data: {
                labels: rpData.labels,
                datasets: [
                    {
                        label: 'Receivables',
                        data: rpData.receivables,
                        borderColor: '#185FA5',
                        backgroundColor: 'rgba(24,95,165,0.07)',
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#185FA5',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Payables',
                        data: rpData.payables,
                        borderColor: '#E24B4A',
                        backgroundColor: 'rgba(226,75,74,0.06)',
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#E24B4A',
                        fill: true,
                        tension: 0.4,
                        borderDash: [5, 3]
                    },
                    {
                        label: 'Net Position',
                        data: rpData.netPosition,
                        borderColor: '#639922',
                        backgroundColor: 'rgba(99,153,34,0.05)',
                        borderWidth: 1.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#639922',
                        fill: true,
                        tension: 0.4,
                        borderDash: [2, 4]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                return c.dataset.label + ': LKR ' + c.raw.toLocaleString() + 'K';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, color: '#7a786f' },
                        border: { display: false }
                    },
                    y: {
                        grid: { color: '#e8e6df' },
                        ticks: {
                            font: { size: 10 },
                            color: '#7a786f',
                            callback: function(v) {
                                return 'LKR ' + (v / 1000).toFixed(1) + 'M';
                            }
                        },
                        border: { display: false }
                    }
                }
            }
        });
    }
})();

  // 7. HRM Attendance Chart - DYNAMIC PHP DATA
  (function() {
    const totalStaff = <?= $hrm_data['total_staff'] ?? 0 ?>;
    const activeStaff = <?= $hrm_data['active_staff'] ?? 0 ?>;
    const inactiveStaff = <?= $hrm_data['inactive_staff'] ?? 0 ?>;
    const attendCanvas = document.getElementById('attendChart');
    if (attendCanvas) {
      new Chart(attendCanvas, {
        type: 'doughnut',
        data: {
          labels: ['Active', 'Inactive'],
          datasets: [{
            data: [activeStaff, inactiveStaff || 0.1],
            backgroundColor: ['#3B6D11', '#E24B4A'],
            borderWidth: 0,
            cutout: '70%'
          }]
        },
        options: {
          responsive: false,
          plugins: { legend: { display: false }, tooltip: { enabled: false } }
        }
      });
    }
    const attendPresent = document.getElementById('attend-present');
    if (attendPresent) attendPresent.textContent = activeStaff;
  })();

  // ============================================================
  // ACTIVITY FEED - Real-time refresh
  // ============================================================
  (function() {
      let refreshInterval = null;
      let isRefreshing = false;
      
      function refreshActivityFeed() {
          if (isRefreshing) return;
          isRefreshing = true;
          
          fetch('/Dash/get_activity_feed_html?limit=9', {
              method: 'GET',
              headers: {
                  'X-Requested-With': 'XMLHttpRequest'
              }
          })
          .then(response => response.json())
          .then(data => {
              if (data.success && data.html) {
                  const activityContainer = document.getElementById('activity-feed');
                  if (activityContainer) {
                      activityContainer.style.opacity = '0.5';
                      setTimeout(() => {
                          activityContainer.innerHTML = data.html;
                          activityContainer.style.opacity = '1';
                          attachActivityClickHandlers();
                      }, 200);
                  }
              }
              isRefreshing = false;
          })
          .catch(error => {
              console.error('Error refreshing activity feed:', error);
              isRefreshing = false;
          });
      }
      
      function attachActivityClickHandlers() {
          const activityItems = document.querySelectorAll('.act-item');
          activityItems.forEach(item => {
              item.style.cursor = 'pointer';
              item.addEventListener('click', function() {
                  const activityId = this.getAttribute('data-activity-id');
                  if (activityId) {
                      showActivityDetails(activityId);
                  }
              });
          });
      }
      
      function showActivityDetails(activityId) {
          fetch('/Dash/get_activity_detail/' + activityId, {
              method: 'GET',
              headers: {
                  'X-Requested-With': 'XMLHttpRequest'
              }
          })
          .then(response => response.json())
          .then(data => {
              if (data.success && data.data) {
                  const act = data.data;
                  let details = `Activity Details:\n\n`;
                  details += `Time: ${act.created_at}\n`;
                  details += `User: ${act.username} (${act.user_role})\n`;
                  details += `Module: ${act.module}\n`;
                  details += `Action: ${act.action}\n`;
                  details += `Type: ${act.action_type}\n`;
                  details += `Description: ${act.description || 'N/A'}\n`;
                  details += `IP Address: ${act.ip_address}\n`;
                  details += `Status: ${act.status || 'N/A'}`;
                  alert(details);
              }
          })
          .catch(error => console.error('Error fetching activity details:', error));
      }
      
      // Initial attachment of click handlers
      attachActivityClickHandlers();
      
      // Refresh activity feed every 90 seconds
      if (refreshInterval) {
          clearInterval(refreshInterval);
      }
      refreshInterval = setInterval(refreshActivityFeed, 90000);
      
      // Refresh when user comes back to tab
      document.addEventListener('visibilitychange', function() {
          if (!document.hidden) {
              refreshActivityFeed();
          }
      });
  })();

}); // End of DOMContentLoaded
</script>

