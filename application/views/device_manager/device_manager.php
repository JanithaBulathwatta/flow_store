<style>

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;overflow-x:hidden;}
::-webkit-scrollbar{width:5px;height:5px;}::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}


/* ── MAIN ── */
.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:22px;}


/* ── TOAST ── */
#toast-c { position: fixed; top: 68px; right: 22px; z-index: 9999; display: flex; flex-direction: column; gap: 7px; pointer-events: none; }
.t-item { padding: 10px 16px; border-radius: var(--radius-sm); font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 7px; box-shadow: var(--shadow-lg); animation: tIn .25s ease; max-width: 300px; }
@keyframes tIn { from { opacity: 0; transform: translateX(16px) } to { opacity: 1; transform: translateX(0) } }
.t-s { background: var(--green-normal); color: var(--white); }
.t-w { background: var(--yellow-normal); color: var(--white); }
.t-e { background: var(--red-normal); color: var(--white); }
.t-i { background: var(--blue-normal); color: var(--white); }


/* ── STATS ── */
.stats-bar {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}

.stat-card {
    background: var(--white);
    border: 1px solid var(--input-border);
    border-radius: var(--radius-md); /* Updated to match your :root variable name */
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: var(--shadow-sm);
    transition: all var(--transition);
}

.stat-card:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.stat-icon {
    width: 42px;
    height: 42px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

/* Color Mapping for Icons */
.si-total {
    background: var(--blue-soft);
    color: var(--blue-dark);
}

.si-active {
    background: var(--green-soft);
    color: var(--green-dark);
}

.si-inactive {
    background: var(--black-soft); 
    color: var(--black-dark);
}

.si-blocked {
    background: var(--red-soft);
    color: var(--red-dark);
}

.stat-info .sv {
    font-size: 22px;
    font-weight: 800;
    font-family: 'JetBrains Mono', monospace;
    line-height: 1;
    color: var(--black-dark); /* Ensures visibility */
}

.stat-info .sl {
    font-size: 11px;
    color: var(--black-normal); /* Using black-normal instead of transparent black-soft */
    font-weight: 600;
    margin-top: 3px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

</style>


<!-- MAIN -->
<main class="main">

  <div class="pg-hdr">
    <div>
      <h1><i class="fa-solid fa-desktop" style="font-size:16px;margin-right:8px;color:var(--blue-dark);"></i>Device Manager</h1>
      <p>Manage all registered devices across users. Activate, deactivate or block access.</p>
    </div>
    <div style="display:flex;gap:8px;align-items:center;">
      <!--<button class="btn btn-outline btn-sm" onclick="exportDevices()"><i class="fa-solid fa-download"></i>Export</button>-->
    </div>
  </div>

  <!-- STATS -->
  <div class="stats-bar" id="stats-bar"></div>

  <!-- FILTERS -->
  <div class="filters-bar">
    <div class="search-wrap">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="search-inp" placeholder="Search device name, model, IP, user…" oninput="renderDevices()">
    </div>

    <select class="fc-sel" id="f-user" onchange="renderDevices()">
      <option value="">All Users</option>
    </select>

    <select class="fc-sel" id="f-type" onchange="renderDevices()">
      <option value="">All Types</option>
      <option value="desktop">Desktop</option>
      <option value="mobile">Mobile</option>
      <option value="tablet">Tablet</option>
    </select>

    <select class="fc-sel" id="f-status" onchange="renderDevices()">
      <option value="">All Statuses</option>
      <option value="online">Online</option>
      <option value="offline">Offline</option>
      <option value="blocked">Blocked</option>
    </select>

    <select class="fc-sel" id="f-active" onchange="renderDevices()">
      <option value="">Active & Inactive</option>
      <option value="1">Active only</option>
      <option value="0">Inactive only</option>
    </select>

    <div class="f-divider"></div>
    <span class="results-meta" id="results-meta"></span>
    <div class="f-divider"></div>

    <div class="view-btns">
      <div class="vbtn" id="vbtn-grid" onclick="setView('grid')" title="Grid view"><i class="fa-solid fa-grip"></i></div>
      <div class="vbtn active" id="vbtn-table" onclick="setView('table')" title="Table view"><i class="fa-solid fa-table-list"></i></div>
    </div>
  </div>

  <!-- GRID VIEW -->
  <div class="devices-grid" id="devices-grid"></div>

  <!-- TABLE VIEW -->
  <div class="devices-table" id="devices-table">
    <div class="tbl-wrap">
      <table class="tbl">
        <thead>
          <tr>
            <th>Device</th>
            <th>User</th>
            <th>Type</th>
            <th>OS / Browser</th>
            <th>IP Address</th>
            <th>Last Seen</th>
            <th>Status</th>
            <!--<th>Active</th>-->
            <th style="text-align:center;">Actions</th>
          </tr>
        </thead>
        <tbody id="devices-tbody"></tbody>
      </table>
    </div>
  </div>

</main>

<!-- CONFIRM MODAL -->
<div class="modal-bg" id="confirm-modal">
  <div class="modal-box">
    <div class="modal-icon danger" id="modal-icon"><i class="fa-solid fa-ban"></i></div>
    <h5 id="modal-title">Block Device</h5>
    <p id="modal-body">Are you sure you want to block this device? The user will be immediately signed out.</p>
    <div class="modal-actions">
      <button class="btn btn-light btn-sm" onclick="closeModal()">Cancel</button>
      <button class="btn btn-danger btn-sm" id="modal-confirm-btn" onclick="executeConfirm()">Confirm</button>
    </div>
  </div>
</div>

<div id="toast-c"></div>

<script>
/* ──────────────────────────────────────────────────
   SAMPLE DATA  —  replace with $.get('/api/devices', ...)
────────────────────────────────────────────────── */
/* ─── DATA STORE ─── */
var DEVICES = []; // This will be filled by loadDevices()
var currentView = 'table';
var pendingAction = null;

/* ─── CONFIG ─── */
var TYPE_ICON  = {desktop:'fa-desktop',mobile:'fa-mobile-screen',tablet:'fa-tablet-screen-button',unknown:'fa-question-circle'};
var TYPE_CLS   = {desktop:'di-desktop',mobile:'di-mobile',tablet:'di-tablet',unknown:'di-unknown'};
var STATUS_CLS = {online:'sp-online',offline:'sp-offline',blocked:'sp-blocked'};
var STATUS_LBL = {online:'Online',offline:'Offline',blocked:'Blocked'};
var STATUS_DOT = {online:'fa-circle',offline:'fa-circle',blocked:'fa-ban'};

/* ─── INIT ─── */
$(function(){
  // Initial load from Database
  loadDevices();
});

/* ─── DATABASE FETCH ─── */
function loadDevices() {
    $.get('<?= base_url("/DeviceManager/get_devices_json") ?>', function(data) {
        var rawDevices = (typeof data === 'string') ? JSON.parse(data) : data;

        // Map database fields to the format used by the UI
        DEVICES = rawDevices.map(d => ({
            id: d.id,
            name: d.device_name || 'Unknown Device',
            model: d.model || 'Unknown Model',
            type: d.device_type || 'desktop',
            os: d.os || 'Unknown OS',
            browser: d.browser || 'Unknown Browser',
            ip: d.ip_address || '0.0.0.0',
            user_id: d.user_id,
            user: d.user || 'Unknown User',
            role: d.role || 'User',
            last_seen: d.last_seen,
            status: d.status || 'offline',
            is_active: parseInt(d.is_active || 0)
        }));

        // Now that DEVICES is full, render everything
        populateUserFilter();
        renderStats();
        renderDevices();
    }).fail(function(err) {
        console.error("Fetch failed:", err);
        toast('Failed to load devices from server', 'e');
    });
}

/* ─── UI POPULATION ─── */
function populateUserFilter(){
  var users = {};
  DEVICES.forEach(function(d){ users[d.user_id] = d.user; });
  var html = '<option value="">All Users</option>';
  Object.keys(users).forEach(function(id){
    html += '<option value="'+id+'">'+users[id]+'</option>';
  });
  $('#f-user').html(html);
}

function renderStats(){
  var total    = DEVICES.length;
  var active   = DEVICES.filter(function(d){return d.is_active;}).length;
  var inactive = DEVICES.filter(function(d){return !d.is_active;}).length;
  var blocked  = DEVICES.filter(function(d){return d.status==='blocked';}).length;
  $('#stats-bar').html(
    sc('si-total','fa-desktop',    total,   'Total Devices')+
    sc('si-active','fa-circle-check',active, 'Active')+
    sc('si-inactive','fa-circle-xmark',inactive,'Inactive')+
    sc('si-blocked','fa-ban',      blocked, 'Blocked')
  );
}
function sc(cls,icon,num,lbl){
  return '<div class="stat-card"><div class="stat-icon '+cls+'"><i class="fa-solid '+icon+'"></i></div><div class="stat-info"><div class="sv">'+num+'</div><div class="sl">'+lbl+'</div></div></div>';
}

/* ─── FILTER & RENDER ─── */
function filteredDevices(){
  var q      = ($('#search-inp').val()||'').toLowerCase();
  var userId = $('#f-user').val();
  var type   = $('#f-type').val();
  var status = $('#f-status').val();
  var active = $('#f-active').val();
  return DEVICES.filter(function(d){
    if (userId && d.user_id != userId) return false;
    if (type   && d.type !== type)     return false;
    if (status && d.status !== status) return false;
    if (active === '1' && !d.is_active) return false;
    if (active === '0' && d.is_active)  return false;
    if (q && !d.name.toLowerCase().includes(q)
          && !d.model.toLowerCase().includes(q)
          && !d.ip.toLowerCase().includes(q)
          && !d.user.toLowerCase().includes(q)
          && !d.os.toLowerCase().includes(q)) return false;
    return true;
  });
}

function renderDevices(){
  var rows = filteredDevices();
  $('#results-meta').text(rows.length+' device'+(rows.length!==1?'s':''));
  if (currentView === 'grid') renderGrid(rows);
  else renderTable(rows);
}

function renderGrid(rows){
  if (!rows.length){
    $('#devices-grid').html('<div class="empty-state" style="grid-column:1/-1"><i class="fa-solid fa-desktop"></i><p>No devices match your filters.</p></div>');
    return;
  }
  var html = rows.map(function(d){ return deviceCard(d); }).join('');
  $('#devices-grid').html(html);
}

function deviceCard(d){
  var accentCls = d.status === 'blocked' ? 'blocked' : d.status === 'online' ? 'online' : 'offline';
  var inactCls  = d.is_active ? '' : ' inactive';
  var initials  = d.user.split(' ').map(function(w){return w[0];}).join('').slice(0,2).toUpperCase();

  return '<div class="device-card'+inactCls+'" id="dc-'+d.id+'">'
    +'<div class="dc-accent '+accentCls+'"></div>'
    +'<div class="dc-body">'
      +'<div class="dc-top">'
        +'<div class="dc-icon-wrap '+TYPE_CLS[d.type||'unknown']+'"><i class="fa-solid '+TYPE_ICON[d.type||'unknown']+'"></i></div>'
        +'<div class="dc-title">'
          +'<div class="dc-name" title="'+d.name+'">'+d.name+'</div>'
          +'<div class="dc-model">'+d.model+'</div>'
        +'</div>'
        +'<div class="dc-status"><span class="sp '+STATUS_CLS[d.status]+'"><i class="fa-solid '+STATUS_DOT[d.status]+'" style="font-size:7px"></i>'+STATUS_LBL[d.status]+'</span></div>'
      +'</div>'
      +'<div class="user-chip">'
        +'<div class="uc-av">'+initials+'</div>'
        +'<span class="uc-name">'+d.user+'</span>'
        +'<span class="uc-role">· '+d.role+'</span>'
      +'</div>'
      +'<div class="dc-meta">'
        +'<div class="dm-row"><i class="fa-brands fa-'+osIcon(d.os)+'"></i><span class="dm-label">OS:</span><span class="dm-value">'+d.os+'</span></div>'
        +'<div class="dm-row"><i class="fa-solid fa-globe"></i><span class="dm-label">Browser:</span><span class="dm-value">'+d.browser+'</span></div>'
        +'<div class="dm-row"><i class="fa-solid fa-network-wired"></i><span class="dm-label">IP:</span><span class="dm-value mono">'+d.ip+'</span></div>'
      +'</div>'
      +'<div class="tog-wrap">'
        /*+'<span class="tog-lbl">Active</span>'
        +'<label class="tog"><input type="checkbox" '+(d.is_active?'checked':'')+' onchange="toggleActive('+d.id+',this.checked)"><span class="tog-s"></span></label>'
        +'<span style="font-size:11px;font-weight:700;color:'+(d.is_active?'var(--success)':'var(--text-muted)')+';" id="atog-lbl-'+d.id+'">'+(d.is_active?'Enabled':'Disabled')+'</span>'*/
      +'</div>'
    +'</div>'
    +'<div class="dc-foot">'
      +'<div class="dc-last-seen"><i class="fa-regular fa-clock"></i>'+relativeTime(d.last_seen)+'</div>'
      +'<div class="dc-actions">'
        +'<!--<div class="act-btn" onclick="viewDetail('+d.id+')" title="View detail"><i class="fa-solid fa-eye"></i></div>-->'
        +(d.status !== 'blocked'
          ? '<div class="btn btn-sm bg-red-soft btn-icon" onclick="confirmBlock('+d.id+')" title="Block device"><i class="ri-forbid-line icon-red-dark"></i></div>'
          : '<div class="btn btn-sm bg-green-soft btn-icon" onclick="confirmUnblock('+d.id+')" title="Unblock" style="color:var(--success);border-color:var(--success-light);"><i class="fa-solid fa-circle-check icon-green-dark"></i></div>')
        +'<div class="btn btn-sm bg-red-soft btn-icon" onclick="confirmRemove('+d.id+')" title="Remove device"><i class="ri-delete-bin-line icon-red-dark"></i></div>'
      +'</div>'
    +'</div>'
  +'</div>';
}

function renderTable(rows){
  if (!rows.length){
    $('#devices-tbody').html('<tr><td colspan="9"><div class="empty-state"><i class="fa-solid fa-desktop"></i><p>No devices match your filters.</p></div></td></tr>');
    return;
  }
  var html = rows.map(function(d){
    var inactCls = d.is_active ? '' : ' inactive';
    var initials = d.user.split(' ').map(function(w){return w[0];}).join('').slice(0,2).toUpperCase();
    return '<tr class="'+inactCls+'">'
      +'<td>'
        +'<div style="display:flex;align-items:center;gap:9px;">'
          +'<div class="dc-icon-wrap '+TYPE_CLS[d.type||'unknown']+'" style="width:32px;height:32px;font-size:14px;flex-shrink:0;"><i class="fa-solid '+TYPE_ICON[d.type||'unknown']+'"></i></div>'
          +'<div><div style="font-weight:700;font-size:13px;">'+d.name+'</div><div style="font-size:11px;color:var(--text-muted);">'+d.model+'</div></div>'
        +'</div>'
      +'</td>'
      +'<td>'
        +'<div style="display:flex;align-items:center;gap:7px;">'
          +'<div class="uc-av" style="width:24px;height:24px;font-size:9px;">'+initials+'</div>'
          +'<div><div style="font-size:12px;font-weight:600;">'+d.user+'</div><div style="font-size:11px;color:var(--text-muted);">'+d.role+'</div></div>'
        +'</div>'
      +'</td>'
      +'<td style="text-transform:capitalize;font-size:12px;">'+d.type+'</td>'
      +'<td style="font-size:12px;color:var(--text-mid);">'+d.os+' · '+d.browser+'</td>'
      +'<td><span class="mono" style="font-size:12px;">'+d.ip+'</span></td>'
      +'<td style="font-size:12px;color:var(--text-muted);">'+relativeTime(d.last_seen)+'</td>'
      +'<td><span class="sp '+STATUS_CLS[d.status]+'"><i class="fa-solid '+STATUS_DOT[d.status]+'" style="font-size:7px"></i>'+STATUS_LBL[d.status]+'</span></td>'
      +'<!--<td>'
        +'<label class="tog"><input type="checkbox" '+(d.is_active?'checked':'')+' onchange="toggleActive('+d.id+',this.checked)"><span class="tog-s"></span></label>'
      +'</td>-->'
      +'<td style="text-align:center;">'
        +'<div style="display:flex;gap:5px;justify-content:center;">'
          +'<!--<div class="act-btn" onclick="viewDetail('+d.id+')" title="Details"><i class="fa-solid fa-eye"></i></div>-->'
          +(d.status!=='blocked'
            ?'<div class="btn btn-sm bg-red-soft btn-icon" onclick="confirmBlock('+d.id+')" title="Block"><i class="ri-forbid-line icon-red-dark"></i></div>'
            :'<div class="btn btn-sm bg-green-soft btn-icon" onclick="confirmUnblock('+d.id+')" title="Unblock" style="color:var(--success);border-color:var(--success-light);"><i class="fa-solid fa-circle-check icon-green-dark"></i></div>')
          +'<div class="btn btn-sm bg-red-soft btn-icon" onclick="confirmRemove('+d.id+')" title="Remove"><i class="ri-delete-bin-line icon-red-dark"></i></div>'
        +'</div>'
      +'</td>'
    +'</tr>';
  }).join('');
  $('#devices-tbody').html(html);
}

/* ─── ACTIONS ─── */
function toggleActive(id, val){
    var d = byId(id); if (!d) return;
    if (d.status === 'blocked' && val){
        toast('Unblock the device before activating it','w');
        loadDevices(); 
        return;
    }
    
    // AJAX: Update DB
    $.post('<?= base_url("DeviceManager/toggle_active") ?>', {
        id: id,
        is_active: val ? 1 : 0,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
    }, function(res) {
        toast(d.name+' '+(val?'activated':'deactivated'), val?'s':'w');
        loadDevices(); // Refresh list
    });
}

function confirmBlock(id){
  var d = byId(id); if (!d) return;
  pendingAction = {type:'block', id:id};
  showModal('danger','fa-ban','Block Device',
    'Block <strong>'+d.name+'</strong> ('+d.user+')? The user will be immediately signed out on this device.',
    'Block Device','btn-danger');
}

function confirmUnblock(id){
  var d = byId(id); if (!d) return;
  pendingAction = {type:'unblock', id:id};
  showModal('warn','fa-circle-check','Unblock Device',
    'Allow <strong>'+d.name+'</strong> to access the system again?',
    'Unblock','btn-primary');
}

function confirmRemove(id){
  var d = byId(id); if (!d) return;
  pendingAction = {type:'remove', id:id};
  showModal('danger','fa-trash','Remove Device',
    'Remove <strong>'+d.name+'</strong> permanently? This cannot be undone.',
    'Remove','btn-danger-o');
}

function executeConfirm(){
  if (!pendingAction) return;
  var a = pendingAction; pendingAction = null;
  closeModal();

  var targetUrl = '';
  var postData = { 
      id: a.id,
      '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
  };

  if (a.type === 'block') {
      targetUrl = '<?= base_url("DeviceManager/update_device_status") ?>';
      postData.status = 'blocked';
  } else if (a.type === 'unblock') {
    targetUrl = '<?= base_url("DeviceManager/update_device_status") ?>';
    postData.status = 'active';
  } else if (a.type === 'remove') {
      targetUrl = '<?= base_url("DeviceManager/remove_device") ?>';
  }

  $.post(targetUrl, postData, function(res) {
      toast('Action completed successfully', 's');
      loadDevices(); // Refresh everything
  }).fail(function() {
      toast('Server error', 'e');
  });
}

/* ─── MODAL CONTROLS ─── */
function showModal(iconCls, iconName, title, body, confirmLbl, confirmCls){
  $('#modal-icon').attr('class','modal-icon '+iconCls).html('<i class="fa-solid '+iconName+'"></i>');
  $('#modal-title').text(title);
  $('#modal-body').html(body);
  $('#modal-confirm-btn').attr('class','btn btn-sm '+confirmCls).text(confirmLbl);
  $('#confirm-modal').addClass('show');
}
function closeModal(){ $('#confirm-modal').removeClass('show'); pendingAction=null; }

/* ─── HELPERS ─── */
function byId(id){ return DEVICES.find(function(d){return d.id==id;}); }

function setView(v){
  currentView = v;
  if (v === 'grid'){
    $('#devices-grid').show(); $('#devices-table').hide();
    $('#vbtn-grid').addClass('active'); $('#vbtn-table').removeClass('active');
  } else {
    $('#devices-grid').hide(); $('#devices-table').show();
    $('#vbtn-grid').removeClass('active'); $('#vbtn-table').addClass('active');
  }
  renderDevices();
}

function viewDetail(id){
  var d = byId(id); if (!d) return;
  toast(d.name+' · Last seen '+relativeTime(d.last_seen),'i');
}

function relativeTime(ts){
  if (!ts) return '—';
  var d = new Date(ts), now = new Date();
  var diff = Math.floor((now - d) / 60000);
  if (diff < 2) return 'Just now';
  if (diff < 60) return diff+'m ago';
  var h = Math.floor(diff/60);
  if (h < 24) return h+'h ago';
  var days = Math.floor(h/24);
  if (days === 1) return 'Yesterday';
  if (days < 7) return days+'d ago';
  return d.toLocaleDateString('en-GB',{day:'numeric',month:'short'});
}

function osIcon(os){
  if (!os) return 'question-circle';
  var o = os.toLowerCase();
  if (o.includes('windows')) return 'windows';
  if (o.includes('android')) return 'android';
  if (o.includes('ios') || o.includes('ipad') || o.includes('macos')) return 'apple';
  if (o.includes('linux')) return 'linux';
  return 'globe';
}

function toast(msg,type){
  var map={s:['t-s','fa-check-circle'],w:['t-w','fa-triangle-exclamation'],e:['t-e','fa-circle-xmark'],i:['t-i','fa-circle-info']};
  var p=map[type]||map.i;
  var $t=$('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i>'+msg+'</div>');
  $('#toast-c').append($t);
  setTimeout(function(){$t.css({opacity:0,transform:'translateX(16px)',transition:'all .3s'});setTimeout(function(){$t.remove();},300);},2800);
}

$(function(){
  setView('table'); 
  loadDevices();
});

</script>