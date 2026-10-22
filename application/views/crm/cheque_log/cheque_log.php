
	<!-- Start::app-content -->
	<div class="main-content app-content">
	  <div class="container-fluid">

		<style>
			/* ── Status badges ── */
			.cb-badge{display:inline-flex;align-items:center;gap:3px;padding:3px 10px;border-radius:20px;font-size:.71rem;font-weight:600;letter-spacing:.03em;white-space:nowrap;}
			.cb-active   {background:#d1fae5;color:#065f46;}
			.cb-completed{background:#e2e8f0;color:#334155;}
			.cb-on_hold  {background:#fef3c7;color:#92400e;}
			.cb-cancelled{background:#fee2e2;color:#991b1b;}
			.cb-unused   {background:#eff6ff;color:#1d4ed8;}
			.cb-issued   {background:#fef9c3;color:#854d0e;}
			.cb-presented{background:#f3e8ff;color:#6b21a8;}
			.cb-cleared  {background:#dcfce7;color:#166534;}
			.cb-bounced  {background:#fee2e2;color:#991b1b;}

			/* ── Stat top-row cards ── */
			.stat-top{border-radius:12px;padding:1.1rem 1.25rem;display:flex;align-items:center;gap:.9rem;}
			.stat-top .s-icon{width:46px;height:46px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;}
			.stat-top .s-val{font-size:1.3rem;font-weight:700;line-height:1.1;}
			.stat-top .s-sub{font-size:.7rem;color:#94a3b8;margin-top:2px;}
			.stat-top .s-lbl{font-size:.75rem;color:#64748b;font-weight:500;}

			/* ── Search / filter bar ── */
			.filter-bar{background:#f8fafc;border:1px solid #e9ecef;border-radius:10px;padding:.7rem 1rem;}

			/* ── Table ── */
			.chq-table th{background:#f8f9fb;font-size:.72rem;text-transform:uppercase;letter-spacing:.06em;color:#64748b;white-space:nowrap;}
			.chq-table td{vertical-align:middle;font-size:.8125rem;}
			.chq-table tr.row-hold td{background:#fffbeb!important;}
			.chq-table tr.row-bounced td{background:#fff5f5!important;}
			.chq-no{font-family:monospace;font-weight:700;font-size:.875rem;color:#405189;}
			.range-pill{display:inline-flex;align-items:center;gap:3px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:5px;padding:1px 7px;font-family:monospace;font-size:.78rem;font-weight:600;color:#1e40af;}

			/* ── Empty state ── */
			.empty-state{text-align:center;padding:3rem 1rem;color:#94a3b8;}
			.empty-state i{font-size:2.5rem;display:block;margin-bottom:.75rem;}
			.empty-state p{font-size:.875rem;margin:0;}

			/* ── Book detail mini-stats ── */
			.book-mini-stat{text-align:center;padding:.4rem .2rem;}
			.book-mini-stat .bv{font-size:1.05rem;font-weight:700;}
			.book-mini-stat .bl{font-size:.65rem;color:#94a3b8;margin-top:1px;}

			/* ── Progress bar inside book ── */
			.bk-prog{height:5px;border-radius:3px;background:#e9ecef;overflow:hidden;margin-top:6px;}
			.bk-prog-bar{height:100%;border-radius:3px;background:linear-gradient(90deg,#405189,#6172b0);}
			.bk-prog-bar.low{background:linear-gradient(90deg,#ef4444,#dc2626);}

			/* ── Hold ribbon on book row ── */
			.hold-chip{display:inline-flex;align-items:center;gap:3px;background:#fef3c7;color:#92400e;border:1px solid #fde68a;border-radius:5px;padding:1px 7px;font-size:.68rem;font-weight:600;}

			/* ── Log timeline dot ── */
			.log-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0;margin-top:4px;}

			/* ── Toast ── */
			#__tb{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:7px;}
			.t-item{padding:10px 15px;border-radius:8px;font-size:13px;font-weight:500;color:#fff;box-shadow:0 3px 12px rgba(0,0,0,.18);opacity:0;transform:translateY(5px);transition:all .22s;max-width:290px;}
		</style>

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
              <div>
                <h1 class="page-title fw-semibold fs-18 mb-1">Cheque Audit Log</h1>
                <span class="text-muted fs-12"><i class="ri-history-line me-1"></i>All status changes and hold events</span>
              </div>
              <div class="d-flex gap-2 align-items-center flex-wrap mt-2 mt-md-0">
                <a href="cheque-book.html" class="btn btn-primary-light btn-sm"><i class="ri-book-open-line me-1"></i>Books</a>
                <a href="cheque-list.html" class="btn btn-success-light btn-sm"><i class="ri-file-list-3-line me-1"></i>Cheques</a>
                <button class="btn btn-secondary-light btn-sm" onclick="window.print()"><i class="ri-printer-line me-1"></i>Print</button>
                <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="cheque-book.html">Cheque Books</a></li><li class="breadcrumb-item active">Audit Log</li></ol></nav>
              </div>
            </div>

            <!-- ── TOP STATS ROW ── -->
            <div class="row g-3 mb-4" id="logStats"></div>

            <!-- ── SEARCH / FILTER BAR ── -->
            <div class="filter-bar mb-3 d-flex flex-wrap gap-2 align-items-center">
              <div class="input-group input-group-sm" style="max-width:240px;">
                <span class="input-group-text"><i class="ri-search-line"></i></span>
                <input type="text" class="form-control" placeholder="Cheque no. / user / book…" id="logSearch">
              </div>
              <select class="form-select form-select-sm" id="logStatusFilter" style="max-width:170px;">
                <option value="">All New Status</option>
                <option value="issued">Issued</option>
                <option value="presented">Presented</option>
                <option value="cleared">Cleared</option>
                <option value="bounced">Bounced</option>
                <option value="cancelled">Cancelled</option>
                <option value="on_hold">On Hold</option>
              </select>
              <select class="form-select form-select-sm" id="logUserFilter" style="max-width:170px;">
                <option value="">All Users</option>
                <option value="Admin">Admin</option>
                <option value="Finance Mgr.">Finance Mgr.</option>
                <option value="Accountant">Accountant</option>
              </select>
              <span class="ms-auto text-muted fs-12" id="logCount"></span>
            </div>

            <!-- ── LOG TABLE + SIDE PANEL ── -->
            <div class="row g-3">
              <div class="col-xl-8">
                <div class="card custom-card">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="fw-semibold fs-14"><i class="ri-history-line me-2 text-primary"></i>Status Change Log</span>
                    <span class="text-muted fs-12" id="logTableCount">0 entries</span>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table chq-table mb-0 text-nowrap">
                        <thead>
                          <tr>
                            <th>Cheque No.</th>
                            <th>Book</th>
                            <th>Old Status</th>
                            <th>New Status</th>
                            <th>Changed By</th>
                            <th>Date &amp; Time</th>
                            <th>Remarks</th>
                          </tr>
                        </thead>
                        <tbody id="logTbody"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <!-- Status distribution -->
                <div class="card custom-card mb-3">
                  <div class="card-header"><span class="fw-semibold fs-14"><i class="ri-pie-chart-line me-2 text-primary"></i>Status Transitions</span></div>
                  <div class="card-body" id="logDist"></div>
                </div>
                <!-- User activity -->
                <div class="card custom-card">
                  <div class="card-header"><span class="fw-semibold fs-14"><i class="ri-user-line me-2 text-primary"></i>Activity by User</span></div>
                  <div class="card-body p-0">
                    <table class="table table-sm mb-0 fs-12">
                      <thead class="table-light"><tr><th>User</th><th>Actions</th><th>Last</th></tr></thead>
                      <tbody id="userActivity"></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <footer class="footer mt-auto py-3 bg-white text-center">
          <div class="container"><span class="text-muted">Copyright &copy; <span id="year"></span> <a href="#" class="text-dark fw-semibold">Rixzo</a>. All rights reserved.</span></div>
        </footer>

<script>
	$(document).ready(function(){
		loadLogs();
	});

// ── Utilities ──────────────────────────────────────────────────────────────────
function fmtLKR(n){return n?'LKR '+n.toLocaleString('en-US'):'—';}
function fmtDate(d){if(!d)return '—';var dt=new Date(d);return isNaN(dt)?d:dt.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'});}
function sbadge(s){return '<span class="cb-badge cb-'+s+'">'+s+'</span>';}
function hbadge(b,by){return b?'<span class="hold-chip"><i class="ri-lock-line"></i>'+by+'</span>':'<span style="color:#22c55e;font-size:.75rem;"><i class="ri-lock-unlock-line"></i></span>';}

function toast(msg,type){
  type=type||'primary';
  var C={primary:'#405189',success:'#22c55e',warning:'#f59e0b',danger:'#ef4444'};
  var box=document.getElementById('__tb');
  if(!box){box=document.createElement('div');box.id='__tb';document.body.appendChild(box);}
  var t=document.createElement('div');t.className='t-item';
  t.style.background=C[type]||C.primary;
  t.innerHTML='<i class="ri-check-line me-2"></i>'+msg;
  box.appendChild(t);
  requestAnimationFrame(function(){t.style.opacity=1;t.style.transform='translateY(0)';});
  setTimeout(function(){t.style.opacity=0;setTimeout(function(){t.remove();},300);},3200);
}

function showEmpty(tbodyId,cols){
  var tb=document.getElementById(tbodyId);if(!tb)return;
  tb.innerHTML='<tr><td colspan="'+cols+'" class="p-0"><div class="empty-state"><i class="ri-inbox-line"></i><p>No records found</p></div></td></tr>';
}
</script>

<script>
// ── Log stats ─────────────────────────────────────────────────────────────────
function renderLogStats(){
  var total=LOGS.length;
  var holdEvents=LOGS.filter(function(l){return l.newSt==='on_hold';}).length;
  var clearEvents=LOGS.filter(function(l){return l.newSt==='cleared';}).length;
  var bounceEvents=LOGS.filter(function(l){return l.newSt==='bounced';}).length;
  var todayStr=new Date().toLocaleDateString('en-GB');
  var todayCount=LOGS.filter(function(l){return l.at.startsWith('2026-03-15')||l.at.startsWith('2026-03-16');}).length;

  var stats=[
    {icon:'ri-history-line', bg:'#eff6ff',ic:'#1d4ed8',lbl:'Total Log Entries',val:total,sub:'All time'},
    {icon:'ri-lock-line',    bg:'#fef3c7',ic:'#92400e',lbl:'Hold Events',       val:holdEvents,sub:'Books + cheques'},
    {icon:'ri-checkbox-circle-line',bg:'#f0fdf4',ic:'#166534',lbl:'Cleared Events',  val:clearEvents,sub:'Confirmed by bank'},
    {icon:'ri-error-warning-line',  bg:'#fff1f2',ic:'#991b1b',lbl:'Bounce Events',   val:bounceEvents,sub:'Requires action'},
  ];
  document.getElementById('logStats').innerHTML=stats.map(function(s){
    return '<div class="col-sm-6 col-xl-3"><div class="card custom-card"><div class="card-body stat-top">' +
      '<div class="s-icon" style="background:'+s.bg+'"><i class="'+s.icon+'" style="color:'+s.ic+';font-size:1.2rem;"></i></div>' +
      '<div><div class="s-val">'+s.val+'</div><div class="s-lbl">'+s.lbl+'</div><div class="s-sub">'+s.sub+'</div></div>' +
      '</div></div></div>';
  }).join('');
}

// ── Render log table ──────────────────────────────────────────────────────────
	function loadLogs() {
		$.ajax({
			url: "<?= site_url('Finance/get_logs'); ?>",
			type: "GET",
			dataType: "json",
			success: function(res) {

				let tbody = '';

				if (res.data.length > 0) {
					$.each(res.data, function(i, l) {

						tbody += `
						<tr>
							<td>${l.cheque_no ?? '(book)'}</td>
							<td>${l.cheque_book_no ?? '-'}</td>
							<td>${l.old_status}</td>
							<td>${l.new_status}</td>
							<td>${l.changed_by}</td>
							<td>${l.changed_at}</td>
							<td>${l.remarks ?? '-'}</td>
						</tr>`;
					});

				} else {
					tbody = `<tr><td colspan="7">No logs</td></tr>`;
				}

				$('#logTbody').html(tbody);
			}
		});
	}

// ── Distribution ──────────────────────────────────────────────────────────────
function renderDist(){
  var el=document.getElementById('logDist');if(!el)return;
  var counts={};
  LOGS.forEach(function(l){counts[l.newSt]=(counts[l.newSt]||0)+1;});
  var total=LOGS.length;
  var colors={issued:'#f59e0b',presented:'#8b5cf6',cleared:'#22c55e',bounced:'#ef4444',cancelled:'#94a3b8',on_hold:'#f59e0b',active:'#22c55e'};
  el.innerHTML=Object.keys(counts).map(function(k){
    return '<div class="d-flex align-items-center gap-2 mb-2">' +
      '<span class="cb-badge cb-'+k+'" style="min-width:80px;justify-content:center;font-size:.7rem;">'+k+'</span>' +
      '<div class="flex-fill" style="background:#f1f5f9;border-radius:4px;height:8px;overflow:hidden;">' +
        '<div style="height:100%;width:'+Math.round(counts[k]/total*100)+'%;background:'+(colors[k]||'#405189')+';border-radius:4px;"></div>' +
      '</div>' +
      '<span class="fw-semibold fs-12" style="min-width:20px;">'+counts[k]+'</span>' +
    '</div>';
  }).join('');
}

// ── User activity ─────────────────────────────────────────────────────────────
function renderUserActivity(){
  var tb=document.getElementById('userActivity');if(!tb)return;
  var users={};
  LOGS.forEach(function(l){
    if(!users[l.by])users[l.by]={count:0,last:l.at};
    users[l.by].count++;
  });
  if(!Object.keys(users).length){tb.innerHTML='<tr><td colspan="3" class="text-center text-muted py-3">No data</td></tr>';return;}
  tb.innerHTML=Object.keys(users).map(function(u){
    return '<tr><td class="fw-medium fs-12">'+u+'</td>' +
      '<td><span class="badge bg-primary-transparent text-primary">'+users[u].count+'</span></td>' +
      '<td class="text-muted fs-11">'+users[u].last+'</td></tr>';
  }).join('');
}

document.getElementById('logSearch')&&document.getElementById('logSearch').addEventListener('input',renderLog);
document.getElementById('logStatusFilter')&&document.getElementById('logStatusFilter').addEventListener('change',renderLog);
document.getElementById('logUserFilter')&&document.getElementById('logUserFilter').addEventListener('change',renderLog);

function init(){renderLogStats();renderLog();renderDist();renderUserActivity();var y=document.getElementById('year');if(y)y.textContent=new Date().getFullYear();}
if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',init);}else{setTimeout(init,100);}
</script>
