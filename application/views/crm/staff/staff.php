<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff List — ERP</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
/* === ALL YOUR EXISTING STYLES EXACTLY AS YOU HAVE THEM === */
:root {
  --primary: #3d52a0; --primary-light: #eef1fb; --primary-mid: #c5cff7; --primary-dark: #2d3d80;
  --success: #10b981; --success-light: #d1fae5; --success-dark: #059669;
  --danger: #ef4444; --danger-light: #fee2e2;
  --warning: #f59e0b; --warning-light: #fef3c7;
  --info: #0ea5e9; --info-light: #e0f2fe;
  --purple: #8b5cf6; --purple-light: #ede9fe;
  --teal: #14b8a6; --teal-light: #ccfbf1;
  --orange: #f97316; --orange-light: #ffedd5;
  
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--page-bg); color: var(--text-dark); font-size: 14px; min-height: 100vh; }
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #c5cff7; border-radius: 10px; }

/* === KEEP ALL YOUR OTHER STYLES EXACTLY AS THEY ARE === */
/* I'm not repeating the entire 800+ lines of CSS here for brevity */
/* BUT YOU SHOULD KEEP ALL YOUR EXISTING STYLES EXACTLY AS YOU HAVE THEM */
/* ── MAIN ── */
.main-content { margin-left:var(--sidebar-w); margin-top:var(--header-h); padding:24px; min-height:calc(100vh - var(--header-h)); }

/* ── PAGE HEADER ── */
.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; gap:12px; flex-wrap:wrap; }
.page-header h1 { font-size:20px; font-weight:800; color:var(--text-dark); letter-spacing:-.3px; }
.page-header p { font-size:13px; color:var(--text-muted); margin-top:2px; }
.header-actions { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }

/* Badges */
.b-dept { background:var(--primary-light); color:var(--primary); }

.b-type-perm { background:var(--teal-light); color:#0f766e; }
.b-type-ft   { background:var(--info-light); color:#0369a1; }
.b-type-cont { background:var(--orange-light); color:#c2410c; }
.b-type-pt   { background:#fce7f3; color:#9d174d; }
.b-type-intern{ background:#f0fdf4; color:#166534; }

/* mono */
.mono { font-family:'JetBrains Mono',monospace; }

/* Action buttons */
.action-btns { display:flex; gap:5px; align-items:center; }
.act-btn {
  width:30px; height:30px; border-radius:var(--radius-sm); display:flex; align-items:center; justify-content:center;
  font-size:13px; cursor:pointer; transition:all var(--transition); border:1.5px solid; text-decoration:none;
}



/* Empty state */
.empty-state { text-align:center; padding:60px 20px; }
.empty-state i { font-size:48px; color:var(--primary-mid); display:block; margin-bottom:12px; }
.empty-state h5 { font-size:15px; font-weight:700; color:var(--text-dark); margin-bottom:6px; }
.empty-state p { font-size:13px; color:var(--text-muted); }



/* ── SLIDE PANEL (View / Edit) ── */
.slide-overlay { position:fixed; inset:0; background:rgba(10,20,50,0.45); z-index:500; display:none; opacity:0; transition:opacity .3s; }
.slide-overlay.open { display:block; opacity:1; }
.slide-panel {
  position:fixed; top:0; right:0; bottom:0; width:520px; max-width:100%;
  background:#fff; z-index:501; transform:translateX(100%);
  transition:transform 0.32s cubic-bezier(.4,0,.2,1);
  display:flex; flex-direction:column; box-shadow:var(--shadow-lg);
}
.slide-panel.open { transform:translateX(0); }
.slide-panel-header {
  padding:0 20px; height:58px; display:flex; align-items:center; gap:12px;
  border-bottom:1px solid var(--card-border); flex-shrink:0;
}
.slide-panel-header h5 { font-size:14px; font-weight:800; color:var(--text-dark); flex:1; }
.close-panel-btn { width:32px; height:32px; border-radius:var(--radius-sm); border:1.5px solid var(--card-border); background:none; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:14px; color:var(--text-muted); transition:all var(--transition); }
.close-panel-btn:hover { border-color:var(--danger); color:var(--danger); }
.slide-panel-tabs { display:flex; border-bottom:1px solid var(--card-border); flex-shrink:0; }
.sp-tab { flex:1; padding:11px; text-align:center; font-size:12px; font-weight:700; cursor:pointer; color:var(--text-muted); border-bottom:2px solid transparent; transition:all var(--transition); }
.sp-tab.active { color:var(--primary); border-bottom-color:var(--primary); }
.slide-panel-body { flex:1; overflow-y:auto; }
.slide-panel-footer { padding:14px 20px; border-top:1px solid var(--card-border); display:flex; gap:8px; justify-content:flex-end; flex-shrink:0; }

/* Panel content */
.profile-hero { padding:24px 20px 16px; display:flex; gap:16px; align-items:center; background:linear-gradient(135deg,var(--primary-light) 0%,#f0f4ff 100%); border-bottom:1px solid var(--primary-mid); }
.hero-avatar { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:800; color:#fff; border:3px solid rgba(255,255,255,0.7); flex-shrink:0; }
.hero-name { font-size:17px; font-weight:800; color:var(--text-dark); }
.hero-desig { font-size:12px; color:var(--text-muted); margin-bottom:6px; }
.hero-tags { display:flex; gap:5px; flex-wrap:wrap; }
.emp-id-chip { display:inline-flex; align-items:center; gap:5px; background:var(--primary-light); border:1px solid var(--primary-mid); border-radius:6px; padding:2px 10px; font-family:'JetBrains Mono',monospace; font-size:12px; font-weight:600; color:var(--primary); margin-bottom:6px; }

.info-section { padding:16px 20px; }
.info-section + .info-section { border-top:1px solid var(--card-border); }
.info-section-title { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.8px; color:var(--text-muted); margin-bottom:12px; display:flex; align-items:center; gap:6px; }
.info-section-title i { color:var(--primary); }
.info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.info-item .il { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:var(--text-muted); margin-bottom:3px; }
.info-item .iv { font-size:13px; font-weight:600; color:var(--text-dark); }
.info-item .iv.mono-val { font-family:'JetBrains Mono',monospace; }
.full-width { grid-column:span 2; }

/* Edit form inside panel */
.edit-section { padding:16px 20px; }
.edit-section + .edit-section { border-top:1px solid var(--card-border); }
.edit-section-title { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.8px; color:var(--text-muted); margin-bottom:12px; }
.form-group { margin-bottom:12px; }
.form-label-sm { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:var(--text-mid); display:block; margin-bottom:5px; }
.form-ctrl { width:100%; padding:8px 11px; border:1.5px solid var(--input-border); border-radius:var(--radius-sm); font-family:inherit; font-size:13px; color:var(--text-dark); outline:none; transition:border-color var(--transition); }
.form-ctrl:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(61,82,160,0.1); }
.edit-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }

/* Activity log */
.activity-log { padding:16px 20px; }
.act-item { display:flex; gap:12px; margin-bottom:14px; position:relative; }
.act-item::before { content:''; position:absolute; left:15px; top:28px; bottom:-14px; width:1px; background:var(--card-border); }
.act-item:last-child::before { display:none; }
.act-dot { width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0; z-index:1; }
.act-dot-create { background:var(--success-light); color:var(--success-dark); }
.act-dot-edit   { background:var(--primary-light); color:var(--primary); }
.act-dot-status { background:var(--warning-light); color:var(--warning); }
.act-dot-login  { background:var(--info-light); color:var(--info); }
.act-content .ac-title { font-size:12px; font-weight:700; color:var(--text-dark); }
.act-content .ac-sub   { font-size:11px; color:var(--text-muted); margin-top:2px; }

/* Toast */
#toast-container { position:fixed; top:72px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:8px; pointer-events:none; }
.toast-item { padding:12px 18px; border-radius:var(--radius-sm); font-size:13px; font-weight:600; pointer-events:auto; display:flex; align-items:center; gap:8px; box-shadow:var(--shadow-lg); animation:toastIn .3s ease; max-width:320px; }
@keyframes toastIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
.toast-success { background:var(--success); color:#fff; }
.toast-warning { background:var(--warning); color:#fff; }
.toast-danger  { background:var(--danger);  color:#fff; }
.toast-info    { background:var(--primary);  color:#fff; }

/* Delete confirm */
.confirm-modal { position:fixed; inset:0; background:rgba(10,20,50,0.6); z-index:600; display:none; align-items:center; justify-content:center; }
.confirm-card { background:#fff; border-radius:var(--radius-lg); padding:28px; max-width:360px; width:90%; text-align:center; animation:popIn .3s cubic-bezier(.34,1.56,.64,1); }
@keyframes popIn { from { opacity:0; transform:scale(.85); } to { opacity:1; transform:scale(1); } }
.confirm-icon { width:60px; height:60px; border-radius:50%; background:var(--danger-light); display:flex; align-items:center; justify-content:center; margin:0 auto 14px; font-size:26px; color:var(--danger); }
.confirm-card h4 { font-size:16px; font-weight:800; margin-bottom:6px; }
.confirm-card p  { font-size:13px; color:var(--text-muted); margin-bottom:20px; }
.confirm-actions { display:flex; gap:8px; justify-content:center; }

@media (max-width:1200px) { .stat-cards { grid-template-columns:repeat(3,1fr); } }
@media (max-width:900px)  { .stat-cards { grid-template-columns:repeat(2,1fr); } }
@media (max-width:640px)  { .stat-cards { grid-template-columns:1fr 1fr; } .slide-panel { width:100%; } }

</style>
</head>
<body>

<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<!-- MAIN - KEEP EXACTLY AS IS -->
<main class="main-content">

  <!-- Page Header -->
  <div class="page-header">
    <div>
      <h1>Staff Directory</h1>
      <p>Manage all employees, roles, and payroll assignments</p>
    </div>
    <div class="header-actions">
      <button class="btn btn-secondary" onclick="exportCSV()"><i class="fa-solid fa-file-csv"></i> Export</button>
      <button class="btn btn-success" onclick="window.location.href='<?php echo site_url('staff/create'); ?>'"><i class="fa-solid fa-user-plus"></i> Add Staff</button>
    </div>
  </div>

  <!-- STAT CARDS -->
  <!--<div class="stat-cards">
    <div class="stat-card sc-blue" onclick="filterByStatus('')" id="sc-all">
      <div class="sc-icon"><i class="fa-solid fa-users"></i></div>
      <div class="sc-val" id="sc-total">0</div>
      <div class="sc-label">Total Staff</div>
      <div class="sc-sub">All records</div>
    </div>
    <div class="stat-card sc-green" onclick="filterByStatus('active')" id="sc-active">
      <div class="sc-icon"><i class="fa-solid fa-circle-check"></i></div>
      <div class="sc-val" id="sc-active-val">0</div>
      <div class="sc-label">Active</div>
      <div class="sc-sub">Currently working</div>
    </div>
    <div class="stat-card sc-orange" onclick="filterByStatus('on_leave')" id="sc-leave">
      <div class="sc-icon"><i class="fa-solid fa-calendar-minus"></i></div>
      <div class="sc-val" id="sc-leave-val">0</div>
      <div class="sc-label">On Leave</div>
      <div class="sc-sub">Away from work</div>
    </div>
    <div class="stat-card sc-red" onclick="filterByStatus('inactive')" id="sc-inactive">
      <div class="sc-icon"><i class="fa-solid fa-user-slash"></i></div>
      <div class="sc-val" id="sc-inactive-val">0</div>
      <div class="sc-label">Inactive</div>
      <div class="sc-sub">Deactivated</div>
    </div>
    <div class="stat-card sc-purple" onclick="filterByStatus('probation')" id="sc-probation">
      <div class="sc-icon"><i class="fa-solid fa-user-clock"></i></div>
      <div class="sc-val" id="sc-prob-val">0</div>
      <div class="sc-label">Probation</div>
      <div class="sc-sub">Under review</div>
    </div>
  </div>-->
  
  <div class="summary-bar" id="summary-bar"></div>

  <!-- FILTER BAR -->
  <div class="filter-bar">
    <div class="search-wrap">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" class="search-input" id="search-input" placeholder="Search by name, ID, email, phone…" oninput="applyFilters()">
    </div>
    <!--<select class="filter-select" id="filter-dept" onchange="applyFilters()"> 
      <option value="">All Departments</option>
      <option>Administration</option>
      <option>Sales</option>
      <option>Finance</option>
      <option>IT</option>
      <option>Warehouse</option>
      <option>Human Resources</option>
      <option>Operations</option>
    </select>-->
    <select class="filter-select" id="filter-role" onchange="applyFilters()">
      <option value="">All Roles</option>
      <option>Admin</option>
      <option>Manager</option>
      <option>Staff</option>
      <option>Cashier</option>
      <option>Accountant</option>
      <option>Viewer</option>
    </select>
    <select class="filter-select" id="filter-type" onchange="applyFilters()">
      <option value="">All Types</option>
      <option>Permanent</option>
      <option>Full-Time</option>
      <option>Contract</option>
      <option>Part-Time</option>
      <option>Intern</option>
    </select>
    <div class="filter-divider"></div>
    <div class="view-toggle">
      <button class="view-btn active" id="btn-table-view" onclick="setView('table')" title="Table view"><i class="fa-solid fa-list"></i></button>
      <button class="view-btn" id="btn-card-view" onclick="setView('card')" title="Card view"><i class="fa-solid fa-grip"></i></button>
    </div>
    <button class="btn btn-secondary btn-sm" onclick="clearFilters()"><i class="fa-solid fa-rotate-left"></i> Reset</button>
  </div>

  <!-- TABLE CARD -->
  <div class="card">
    <div class="tbl-toolbar">
      <div class="rec-count">
        <i class="fa-solid fa-users" style="color:var(--blue-dark);"></i>
        Staff Records
        <span class="badge bg-black-soft" id="rec-badge">0 records</span>
      </div>
      <div class="bulk-bar" id="bulk-bar">
        <span class="bulk-count" id="bulk-count">0 selected</span>
        <button class="btn btn-sm" style="background:var(--success-light);color:var(--success-dark);border:1.5px solid #6ee7b7;" onclick="bulkActivate()"><i class="fa-solid fa-check"></i> Activate</button>
        <button class="btn btn-sm" style="background:var(--danger-light);color:var(--danger);border:1.5px solid #fca5a5;" onclick="bulkDeactivate()"><i class="fa-solid fa-ban"></i> Deactivate</button>
      </div>
      <div class="ml-auto">
        <button class="btn btn-secondary btn-sm btn-icon" onclick="loadStaffData()" title="Refresh"><i class="fa-solid fa-arrows-rotate"></i></button>
        <button class="btn btn-secondary btn-sm" onclick="exportCSV()"><i class="fa-solid fa-download"></i> Export</button>
      </div>
    </div>

    <div id="table-view">
      <div class="tbl-wrap">
        <table class="staff-table">
          <thead>
            <tr>
              <th style="width:36px;"><input type="checkbox" id="chk-all" onchange="toggleAll(this)"></th>
              <th onclick="sortBy('name')">Staff Member <i class="fa-solid fa-sort sort-icon"></i></th>
              <th onclick="sortBy('empId')">Emp. ID <i class="fa-solid fa-sort sort-icon"></i></th>
              <!--<th onclick="sortBy('dept')">Department <i class="fa-solid fa-sort sort-icon"></i></th>-->
              <th onclick="sortBy('role')">Role <i class="fa-solid fa-sort sort-icon"></i></th>
              <th onclick="sortBy('type')">Type <i class="fa-solid fa-sort sort-icon"></i></th>
              <th onclick="sortBy('salary')">Net Salary <i class="fa-solid fa-sort sort-icon"></i></th>
              <th onclick="sortBy('joining')">Joined <i class="fa-solid fa-sort sort-icon"></i></th>
              <th onclick="sortBy('status')">Status <i class="fa-solid fa-sort sort-icon"></i></th>
              <th style="text-align:right;">Actions</th>
            </tr>
          </thead>
          <tbody id="staff-tbody"></tbody>
        </table>
      </div>
      <div class="empty-state" id="empty-state" style="display:none;">
        <i class="fa-solid fa-users-slash"></i>
        <h5>No staff found</h5>
        <p>Try adjusting your search or filter criteria</p>
      </div>
    </div>

    <div id="card-view" style="display:none;">
      <div class="staff-cards-grid" id="staff-cards-grid"></div>
      <div class="empty-state" id="empty-state-card" style="display:none;">
        <i class="fa-solid fa-users-slash"></i>
        <h5>No staff found</h5>
        <p>Try adjusting your search or filter criteria</p>
      </div>
    </div>

    <div class="card-footer">
      <div style="display:flex;align-items:center;gap:12px;">
        <span class="pg-info" id="pg-info">Showing 0–0 of 0</span>
        <select class="pg-size-select" id="pg-size" onchange="onPgSize()">
          <option value="10" selected>10 / page</option>
          <option value="20">20 / page</option>
          <option value="50">50 / page</option>
        </select>
      </div>
      <nav><ul class="pagination" id="pagination"></ul></nav>
    </div>
  </div>

</main>



<!-- Delete Confirm Modal -->
<div class="confirm-modal" id="confirm-modal" style="display:none;">
  <div class="confirm-card">
    <div class="confirm-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
    <h4>Remove Staff Member?</h4>
    <p>This will permanently delete <strong id="del-name"></strong> and all associated records.</p>
    <div class="confirm-actions">
      <button class="btn btn-secondary" onclick="$('#confirm-modal').css('display','none')">Cancel</button>
      <button class="btn" style="background:var(--danger);color:#fff;" onclick="doDelete()"><i class="fa-solid fa-trash"></i> Delete</button>
    </div>
  </div>
</div>

<div id="toast-container"></div>

<script>
// === STATE ===
var STAFF = [];
var filtered = [];
var currentPage = 1;
var pageSize = 10;
var currentView = 'table';
var sortKey = '';
var sortDir = 1;
var activeStatusFilter = '';
var deleteTargetId = null;
var selectedIds = new Set();

// === LOAD REAL DATA FROM SERVER ===
function loadStaffData() {
    $.ajax({
        url: '<?php echo base_url("Staff/get_all_data"); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // CLEAR THE ARRAY FIRST - THIS IS IMPORTANT
            STAFF = [];  // Reset the array
            
            if (response.data && response.data.length > 0) {
                STAFF = response.data.map(function(item) {
                    return {
                        id: item.staff_id,
                        empId: item.staff_no || ('STF-' + item.staff_id),
                        name: item.full_name || '—',
                        calling: item.calling_name || (item.full_name ? item.full_name.split(' ')[0] : ''),
                        //dept: item.branch_location || '—',
                        desig: item.designation || '—',
                        role: item.designation_name || 'Staff',
                        type: item.employee_type ? item.employee_type.replace(/_/g, ' ') : 'Full-Time',
                        status: item.status || 'active',
                        phone: item.phone || '—',
                        email: item.email || '—',
                        joining: item.joining_date || '',
                        salary: parseFloat(item.basic_salary) || 0,
                        hasLogin: item.has_account ? true : false,
                        hasEpf: item.epf_enabled == 1,
                        allowances: item.allowances || [],
                        deductions: item.deductions || [],
                        avatar: item.profile_photo,
                        color: 'var(--blue-dark)',
                        notes: item.internal_notes || '',
                        branch: item.branch_location || 'Head Office',
                        reporting: '—'
                    };
                });
            }
            updateStatCards();
            applyFilters();
            loadStaffCounts();
        },
        error: function() {
            toast('Failed to load staff data', 'danger');
        }
    });
}

/*function loadStaffCounts() {
    $.ajax({
        url: '<?php echo base_url("Staff/get_counts"); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#sidebar-count').text(response.all_count || 0);
        }
    });
}*/

/*function updateStatCards() {
    var total = STAFF.length;
    var active = STAFF.filter(s => s.status === 'active').length;
    var onLeave = STAFF.filter(s => s.status === 'on_leave').length;
    var inactive = STAFF.filter(s => s.status === 'inactive').length;
    var probation = STAFF.filter(s => s.status === 'probation').length;
    
    $('#sc-total').text(total);
    $('#sc-active-val').text(active);
    $('#sc-leave-val').text(onLeave);
    $('#sc-inactive-val').text(inactive);
    $('#sc-prob-val').text(probation);
    $('#sidebar-count').text(total);
}*/


/* ═══════════════════════ DATA ═══════════════════════ */
// Global storage pool used by your summary bar engine
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function updateStatCards() {
    var total     = STAFF.length;
    var active    = STAFF.filter(s => s.status === 'active').length;
    var onLeave   = STAFF.filter(s => s.status === 'on_leave').length;
    var inactive  = STAFF.filter(s => s.status === 'inactive').length;
    var probation = STAFF.filter(s => s.status === 'probation').length;
    
    // Updates standard structural sidebar counts if needed elsewhere
    $('#sidebar-count').text(total);

    // FIX: Convert raw filter counts into the structured array your loop expects
    GRN_ITEMS = [
        { name: 'total',     total: total },
        { name: 'active',    total: active },
        { name: 'on_leave',  total: onLeave },
        { name: 'inactive',  total: inactive },
        { name: 'probation', total: probation }
    ];

    // Dynamic generation of classes and custom labels
    GRN_ITEMS.forEach(function(item) {
        var key = (item.name || '').toLowerCase();

        // Generates clean human-readable titles (e.g., "on_leave" -> "On leave count")
        if (!STATUS_LABELS[key]) {
            var readableName = item.name.replace(/_/g, ' '); 
            STATUS_LABELS[key] = readableName.charAt(0).toUpperCase() + readableName.slice(1) + ' count';
        }

        // Generates standard structural target CSS selectors (e.g., "st-on_leave")
        if (!STATUS_CSS[key]) {
            STATUS_CSS[key] = 'st-' + key;
        }
    });

    // FontAwesome icon class map matching your status keys exactly
    STATUS_ICON = {
        total:     'fa-users',
        active:    'fa-user-check',
        on_leave:  'fa-user-clock',
        inactive:  'fa-user-slash',
        probation: 'fa-user-shield'
    };

    // Run your structural summary bar layout generation engine
    renderGrnSummaryBar();
}

/* ─── COMPACT SUMMARY BAR (STAFF VERSION) ─── */
function renderGrnSummaryBar() {
    
    // Mapping configurations for display structural themes
    var itemsConfig = {
        total:     { icon: 'fa-users',        bg: '#e0f2fe',            ic: '#0369a1',       sub: 'Total Registered Staff' },
        active:    { icon: 'fa-user-check',   bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Currently Active' },
        on_leave:  { icon: 'fa-user-clock',   bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'On Official Leave' },
        inactive:  { icon: 'fa-user-slash',   bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deactivated Accounts' },
        probation: { icon: 'fa-user-shield',  bg: 'var(--primary-light)', ic: 'var(--primary)', sub: 'Under Probationary Period' }
    };

    // Generating item dictionary structures for your template generator mapping loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-user', bg: '#e2e8f0', ic: '#64748b', sub: 'Staff Category' };
        
        return {
            cls: STATUS_CSS[key] || '',          
            icon: STATUS_ICON[key] || cfg.icon,  
            ibg: cfg.bg,
            ic: cfg.ic,
            val: item.total,
            lbl: STATUS_LABELS[key] || item.name,
            sub: cfg.sub,
            extra: ''
        };
    });

    // Your template literal generator matching your UI layouts exactly
    var html = displayItems.map(function(item) {
        return '<div class="sb-item' + (item.cls ? ' ' + item.cls : '') + '">'
            + '<div class="sbi-icon" style="background:' + item.ibg + ';color:' + item.ic + '"><i class="fa-solid ' + item.icon + '"></i></div>'
            + '<div class="sbi-main">'
                + '<div class="sbi-val" style="color:' + item.ic + '">' + item.val + '</div>'
                + '<div class="sbi-lbl">' + item.lbl + '</div>'
                + item.extra
            + '</div>'
        + '</div>';
    }).join('');

    // Target structural viewport wrapper element to render your dynamic markup
    $('#summary-bar').html(html);
}

function filterByStatus(status) {
    activeStatusFilter = status;
    //$('#filter-dept').val('');
    $('#filter-role').val('');
    $('#filter-type').val('');
    $('#search-input').val('');
    
    $('.stat-card').removeClass('active-filter');
    if (!status) $('#sc-all').addClass('active-filter');
    else if (status === 'active') $('#sc-active').addClass('active-filter');
    else if (status === 'on_leave') $('#sc-leave').addClass('active-filter');
    else if (status === 'inactive') $('#sc-inactive').addClass('active-filter');
    else if (status === 'probation') $('#sc-probation').addClass('active-filter');
    
    applyFilters();
}

function applyFilters() {
    var q = $('#search-input').val().toLowerCase().trim();
    //var dept = $('#filter-dept').val();
    var role = $('#filter-role').val();
    var type = $('#filter-type').val();

    filtered = STAFF.filter(function(s) {
        var matchQ = !q || 
            (s.name && s.name.toLowerCase().includes(q)) || 
            (s.empId && s.empId.toLowerCase().includes(q)) ||
            (s.email && s.email.toLowerCase().includes(q)) || 
            (s.phone && s.phone.includes(q)) ||
            (s.desig && s.desig.toLowerCase().includes(q)) 
            //(s.dept && s.dept.toLowerCase().includes(q));
        var matchStatus = !activeStatusFilter || s.status === activeStatusFilter;
        //var matchDept = !dept || s.dept === dept;
        var matchRole = !role || s.role === role;
        var matchType = !type || s.type === type;
        return matchQ && matchStatus && matchRole && matchType;
    });

    if (sortKey) doSort();
    currentPage = 1;
    selectedIds.clear();
    $('#chk-all').prop('checked', false);
    $('#bulk-bar').removeClass('show');
    render();
}

function clearFilters() {
    $('#search-input').val('');
    //$('#filter-dept').val('');
    $('#filter-role').val('');
    $('#filter-type').val('');
    activeStatusFilter = '';
    $('.stat-card').removeClass('active-filter');
    applyFilters();
}

function sortBy(key) {
    if (sortKey === key) sortDir *= -1;
    else { sortKey = key; sortDir = 1; }
    $('.staff-table th').removeClass('sorted-asc sorted-desc');
    doSort();
    render();
}

function doSort() {
    filtered.sort(function(a, b) {
        var va = a[sortKey] || '', vb = b[sortKey] || '';
        if (sortKey === 'salary') return (a.salary - b.salary) * sortDir;
        return String(va).localeCompare(String(vb)) * sortDir;
    });
}

function render() {
    var total = filtered.length;
    var start = (currentPage - 1) * pageSize;
    var end = Math.min(start + pageSize, total);
    var page = filtered.slice(start, end);

    $('#rec-badge').text(total + ' record' + (total !== 1 ? 's' : ''));
    $('#pg-info').text(total === 0 ? 'No records' : 'Showing ' + (start + 1) + '–' + end + ' of ' + total);

    if (currentView === 'table') renderTable(page, total);
    else renderCards(page, total);
    
    renderPagination(total);
}

function getStatusBadge(s) {
    var map = {
        active: '<span class="badge bg-success status-badge"><i class="fa-solid fa-circle" style="font-size:7px"></i> Active</span>',
        inactive: '<span class="badge bg-orange-dark"><i class="fa-solid fa-circle" style="font-size:7px"></i> Inactive</span>',
        on_leave: '<span class="badge bg-red-dark"><i class="fa-solid fa-calendar-xmark" style="font-size:9px"></i> On Leave</span>',
        probation: '<span class="badge bg-yellow-dark"><i class="fa-solid fa-clock" style="font-size:9px"></i> Probation</span>'
    };
    return map[s] || s;
}

function getTypeBadge(t) {
    var map = { 
        'Permanent': 'b-type-perm', 
        'Full-Time': 'b-type-ft', 
        'Contract': 'b-type-cont', 
        'Part-Time': 'b-type-pt', 
        'Intern': 'b-type-intern' 
    };
    return '<span class="badge bg-yellow-dark ' + (map[t] || '') + '">' + t + '</span>';
}

function getInitials(name) { 
    if (!name) return '?';
    return name.split(' ').map(w => w[0]).join('').substr(0, 2).toUpperCase(); 
}

function getDotClass(s) { 
    return {
        active: 'dot-active', 
        inactive: 'dot-inactive', 
        on_leave: 'dot-leave', 
        probation: 'dot-probation'
    }[s] || 'dot-inactive'; 
}

function fmtSalary(n) { 
    return 'Rs. ' + Number(n).toLocaleString('en-LK'); 
}

function fmtDate(d) { 
    return d ? new Date(d).toLocaleDateString('en-GB', {day:'2-digit',month:'short',year:'numeric'}) : '—'; 
}

function renderTable(page, total) {
    var tbody = $('#staff-tbody');
    if (total === 0) { 
        tbody.html(''); 
        $('#empty-state').show(); 
        return; 
    }
    $('#empty-state').hide();

    var html = page.map(function(s) {
        var checked = selectedIds.has(s.id) ? 'checked' : '';
        var rowCls = selectedIds.has(s.id) ? 'selected' : '';
        return '<tr class="' + rowCls + '" id="row-' + s.id + '">' +
            '<td><input type="checkbox" ' + checked + ' onchange="toggleSelect(' + s.id + ',this)"></td>' +
            '<td>' +
                '<div class="staff-cell">' +
                    '<div class="staff-avatar" style="background:' + s.color + ';">' +
                        getInitials(s.name) +
                        '<span class="online-dot ' + getDotClass(s.status) + '"></span>' +
                    '</div>' +
                    '<div>' +
                        '<div class="staff-name">' + s.name + '</div>' +
                        '<div class="staff-desig">' + s.desig + ' · ' + s.phone + '</div>' +
                    '</div>' +
                '</div>' +
            '</td>' +
            '<td><span class="mono" style="font-size:12px;color:var(--primary);">' + s.empId + '</span></td>' +
            //'<td><span class="badge bg-orange-dark status-badge">' + s.dept + '</span></td>' +
            '<td><span class="badge bg-purple-dark">' + s.role + '</span></td>' +
            '<td>' + getTypeBadge(s.type) + '</td>' +
            '<td><span class="mono" style="font-weight:700;">' + fmtSalary(s.salary) + '</span></td>' +
            '<td style="color:var(--text-muted);font-size:12px;">' + fmtDate(s.joining) + '</td>' +
            '<td>' + getStatusBadge(s.status) + '</td>' +
            '<td>' +
                '<div class="action-btns" style="justify-content:flex-end;">' +
                    '<button class="btn btn-sm btn-icon btn-info-light " onclick="viewProfile(' + s.id + ')" title="View Profile"><i class="ri-eye-line"></i></button>' +
                    '<button class="btn btn-sm btn-icon btn-warning-light" onclick="editStaff(' + s.id + ')" title="Edit Staff"><i class="ri-edit-line"></i></button>' +
                    '<button class="btn btn-sm btn-danger-light btn-icon" onclick="confirmDelete(' + s.id + ')" title="Delete"><i class="ri-delete-bin-line"></i></button>' +
                '</div>' +
            '</td>' +
        '</tr>';
    }).join('');
    tbody.html(html);
}

function renderCards(page, total) {
    var grid = $('#staff-cards-grid');
    if (total === 0) { 
        grid.html(''); 
        $('#empty-state-card').show(); 
        return; 
    }
    $('#empty-state-card').hide();
    
    var html = page.map(function(s) {
        return '<div class="staff-card-item" onclick="viewProfile(' + s.id + ')">' +
            '<div class="staff-card-badge">' + getStatusBadge(s.status) + '</div>' +
            '<div class="staff-card-avatar" style="background:' + s.color + ';border-color:' + s.color + '30;">' +
                getInitials(s.name) +
                '<span class="online-dot ' + getDotClass(s.status) + '" style="bottom:2px;right:2px;width:11px;height:11px;border:2px solid #fff;"></span>' +
            '</div>' +
            '<div class="staff-card-name">' + s.name + '</div>' +
            '<div class="staff-card-desig">' + s.desig + '</div>' +
            '<div class="staff-card-tags">' +
                //'<span class="badge b-dept" style="font-size:10px;">' + s.dept + '</span>' +
                '<span class="badge b-role" style="font-size:10px;">' + s.role + '</span>' +
                getTypeBadge(s.type) +
            '</div>' +
            '<div class="staff-card-meta"><i class="fa-solid fa-phone" style="font-size:10px;margin-right:4px;"></i>' + s.phone + ' · <span class="mono" style="font-size:11px;color:var(--primary);">' + s.empId + '</span></div>' +
            '<div class="staff-card-actions" onclick="event.stopPropagation()">' +
                '<button class="btn btn-sm btn-icon btn-info-light " onclick="viewProfile(' + s.id + ')"><i class="ri-eye-line"></i></button>' +
                '<button class="btn btn-sm btn-icon btn-warning-light" onclick="editStaff(' + s.id + ')"><i class="ri-edit-line"></i></button>' +
                '<button class="btn btn-sm btn-danger-light btn-icon" onclick="confirmDelete(' + s.id + ')"><i class="ri-delete-bin-line"></i></button>' +
            '</div>' +
        '</div>';
    }).join('');
    grid.html(html);
}

function renderPagination(total) {
    var pages = Math.ceil(total / pageSize);
    var ul = $('#pagination'); 
    ul.html('');
    if (pages <= 1) return;

    ul.append('<li class="' + (currentPage === 1 ? 'disabled' : '') + '"><a onclick="gotoPage(' + (currentPage - 1) + ')"><i class="fa-solid fa-chevron-left"></i></a></li>');
    
    for (var i = 1; i <= pages; i++) {
        if (pages > 7 && i > 2 && i < pages && Math.abs(i - currentPage) > 2) {
            if (i === 3 || i === pages - 1) ul.append('<li><span>…</span></li>');
            continue;
        }
        ul.append('<li class="' + (i === currentPage ? 'active' : '') + '"><a onclick="gotoPage(' + i + ')">' + i + '</a></li>');
    }
    
    ul.append('<li class="' + (currentPage === pages ? 'disabled' : '') + '"><a onclick="gotoPage(' + (currentPage + 1) + ')"><i class="fa-solid fa-chevron-right"></i></a></li>');
}

function gotoPage(p) {
    var pages = Math.ceil(filtered.length / pageSize);
    if (p < 1 || p > pages) return;
    currentPage = p; 
    render();
}

function onPgSize() { 
    pageSize = parseInt($('#pg-size').val()); 
    currentPage = 1; 
    render(); 
}

function toggleAll(cb) {
    var page = filtered.slice((currentPage - 1) * pageSize, currentPage * pageSize);
    page.forEach(function(s) {
        if (cb.checked) selectedIds.add(s.id); 
        else selectedIds.delete(s.id);
        $('#row-' + s.id).toggleClass('selected', cb.checked);
        $('#row-' + s.id + ' input[type=checkbox]').prop('checked', cb.checked);
    });
    updateBulkBar();
}

function toggleSelect(id, cb) {
    if (cb.checked) selectedIds.add(id); 
    else selectedIds.delete(id);
    $('#row-' + id).toggleClass('selected', cb.checked);
    updateBulkBar();
}

function updateBulkBar() {
    var n = selectedIds.size;
    if (n > 0) { 
        $('#bulk-bar').addClass('show'); 
        $('#bulk-count').text(n + ' selected'); 
    } else { 
        $('#bulk-bar').removeClass('show'); 
    }
}

function bulkActivate() {
    var ids = Array.from(selectedIds);
    ids.forEach(function(id) {
        $.ajax({
            url: '<?php echo base_url("Staff/update_status"); ?>',
            type: 'POST',
            data: { lid: id, status: 'active' }
        });
    });
    selectedIds.clear();
    loadStaffData();
    toast(ids.length + ' staff activated', 'success');
}

function bulkDeactivate() {
    var ids = Array.from(selectedIds);
    ids.forEach(function(id) {
        $.ajax({
            url: '<?php echo base_url("Staff/update_status"); ?>',
            type: 'POST',
            data: { lid: id, status: 'inactive' }
        });
    });
    selectedIds.clear();
    loadStaffData();
    toast(ids.length + ' staff deactivated', 'warning');
}

function setView(v) {
    currentView = v;
    if (v === 'table') { 
        $('#table-view').show(); 
        $('#card-view').hide(); 
        $('#btn-table-view').addClass('active'); 
        $('#btn-card-view').removeClass('active'); 
    } else { 
        $('#table-view').hide(); 
        $('#card-view').show(); 
        $('#btn-card-view').addClass('active'); 
        $('#btn-table-view').removeClass('active'); 
    }
    render();
}

// === DIRECT REDIRECTS - NO SLIDE PANEL ===
function viewProfile(id){
    window.location.href = '/Staff/profile?s_id=' + id;
} 

function editStaff(id) {
    window.location.href = '<?php echo site_url("Staff/edit/"); ?>' + id;
}

function confirmDelete(id) {
    deleteTargetId = id;
    var s = STAFF.find(x => x.id == id); 
    if (!s) return;
    $('#del-name').text(s.name);
    $('#confirm-modal').css('display', 'flex');
}

function doDelete() {
    if (!deleteTargetId) return;
    
    $.ajax({
        url: '<?php echo base_url("Staff/delete"); ?>?lid=' + deleteTargetId,
        type: 'GET',
        dataType: 'json',
        success: function() {
            $('#confirm-modal').css('display', 'none');
            loadStaffData();
            toast('Staff member deleted', 'danger');
        }
    });
}

function exportCSV() {
    var rows = [['Emp ID', 'Name', 'Dept', 'Designation', 'Role', 'Type', 'Status', 'Phone', 'Email', 'Joined', 'Salary']];
    filtered.forEach(function(s) {
        rows.push([s.empId, s.name, s.dept, s.desig, s.role, s.type, s.status, s.phone, s.email, s.joining, s.salary]);
    });
    var csv = rows.map(r => r.map(v => '"' + v + '"').join(',')).join('\n');
    var blob = new Blob([csv], {type: 'text/csv'});
    var a = document.createElement('a'); 
    a.href = URL.createObjectURL(blob); 
    a.download = 'staff-list.csv'; 
    a.click();
    toast('CSV exported — ' + filtered.length + ' records', 'success');
}

function toast(msg, type) {
    type = type || 'info';
    var icons = {success:'fa-check-circle', warning:'fa-triangle-exclamation', danger:'fa-circle-xmark', info:'fa-circle-info'};
    var $t = $('<div class="toast-item toast-' + type + '"><i class="fa-solid ' + icons[type] + '"></i>' + msg + '</div>');
    $('#toast-container').append($t);
    setTimeout(function() { $t.fadeOut(300, function() { $t.remove(); }); }, 3500);
}

// === INIT ===
$(document).ready(function() {
    loadStaffData();
    
    // Close modal on cancel
    $(document).on('click', '#confirm-modal .btn-secondary', function() {
        $('#confirm-modal').css('display', 'none');
    });
});
</script>
</body>
</html>