<style>
:root {
  --primary:#3d52a0;--primary-d:#2d3d80;--primary-light:#eef1fb;--primary-mid:#c5cff7;
  --success:#10b981;--success-light:#d1fae5;
  --danger:#ef4444;--danger-light:#fee2e2;
  --warning:#f59e0b;--warning-light:#fef3c7;
  --info:#0ea5e9;--info-light:#e0f2fe;
  --purple:#8b5cf6;--purple-light:#ede9fe;
  --teal:#14b8a6;--teal-light:#ccfbf1;
  --orange:#f97316;--orange-light:#ffedd5;
  --rose:#f43f5e;--rose-light:#ffe4e6;
  --sidebar-bg:#1a1f36;--sidebar-text:#a8b4d8;
  --page-bg:#f2f4fa;--card-bg:#fff;--card-border:#e4e9f4;
  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
  --input-border:#d1d9e6;--table-head:#f7f9ff;
  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.10);--sh-lg:0 8px 32px rgba(61,82,160,.14);
  --r-sm:8px;--r-md:12px;--r-lg:16px;--r-xl:20px;
  --sidebar-w:240px;--header-h:60px;--tr:.2s cubic-bezier(.4,0,.2,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;overflow-x:hidden;}
::-webkit-scrollbar{width:5px;height:5px;}::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

/* category dot badge */
.cat-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;}
.type-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:700;background:var(--primary-light);color:var(--primary);}

/* ── MODAL ── */
.modal-bg{position:fixed;inset:0;background:rgba(10,18,45,.55);z-index:500;display:none;align-items:flex-start;justify-content:center;padding:32px 16px;overflow-y:auto;}
.modal-bg.show{display:flex;}
.modal-box{background:#fff;border-radius:var(--r-xl);width:100%;max-width:560px;box-shadow:var(--sh-lg);animation:popIn .3s cubic-bezier(.34,1.56,.64,1);margin:auto;}
@keyframes popIn{from{opacity:0;transform:scale(.9) translateY(-10px)}to{opacity:1;transform:scale(1) translateY(0)}}
.mb-head{padding:20px 24px 0;display:flex;align-items:center;justify-content:space-between;}
.mb-head h4{font-size:16px;font-weight:800;color:var(--text-dark);letter-spacing:-.2px;}
.mb-close{background:none;border:none;cursor:pointer;color:var(--text-muted);font-size:18px;width:32px;height:32px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;transition:all var(--tr);}
.mb-close:hover{background:var(--danger-light);color:var(--danger);}
.mb-body{padding:20px 24px;}
.mb-foot{padding:16px 24px;border-top:1px solid var(--card-border);display:flex;justify-content:flex-end;gap:8px;border-radius:0 0 var(--r-xl) var(--r-xl);}

/* Form */
.form-row{margin-bottom:16px;}
.form-lbl{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-mid);display:block;margin-bottom:5px;}
.form-lbl span{color:var(--danger);margin-left:2px;}
.fc{width:100%;padding:9px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;transition:border-color var(--tr),box-shadow var(--tr);background:#fff;}
.fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.1);}
.fc::placeholder{color:var(--text-muted);}
textarea.fc{resize:vertical;min-height:64px;}
.fc.has-error{border-color:var(--danger);}
.err-msg{font-size:11px;color:var(--danger);font-weight:600;margin-top:4px;display:none;}
.form-grid2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.form-grid3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.ig{position:relative;}
.ig .fc{padding-left:34px;}
.ig .ipfx{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:12px;font-weight:600;pointer-events:none;}
/* Expense type pills */
.etype-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:6px;}
.etype-pill{padding:10px 8px;border:1.5px solid var(--card-border);border-radius:var(--r-sm);text-align:center;cursor:pointer;transition:all var(--tr);background:#fff;}
.etype-pill i{font-size:18px;display:block;margin-bottom:5px;color:var(--text-muted);}
.etype-pill span{font-size:11px;font-weight:700;color:var(--text-muted);display:block;}
.etype-pill.sel{border-color:var(--primary);background:var(--primary-light);}
.etype-pill.sel i,.etype-pill.sel span{color:var(--primary);}

/* Account select with balance */
.acc-option{padding:10px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);cursor:pointer;transition:all var(--tr);display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;}
.acc-option:last-child{margin-bottom:0;}
.acc-option:hover{border-color:var(--primary-mid);}
.acc-option.sel{border-color:var(--primary);background:var(--primary-light);}
.acc-name{font-size:13px;font-weight:600;color:var(--text-dark);}
.acc-bal{font-size:12px;font-weight:700;color:var(--success);font-family:'JetBrains Mono',monospace;}
.acc-type{font-size:10px;color:var(--text-muted);font-weight:600;margin-top:1px;}
.acc-radio{width:16px;height:16px;border-radius:50%;border:2px solid var(--input-border);display:flex;align-items:center;justify-content:center;transition:all var(--tr);flex-shrink:0;}
.acc-option.sel .acc-radio{border-color:var(--primary);background:var(--primary);}
.acc-option.sel .acc-radio::after{content:'';width:6px;height:6px;border-radius:50%;background:#fff;}
/* step indicator */
.modal-steps{display:flex;align-items:center;gap:0;margin-bottom:20px;border-bottom:1px solid var(--card-border);padding-bottom:14px;}
.ms-step{display:flex;align-items:center;gap:6px;font-size:11px;font-weight:700;color:var(--text-muted);padding:0 4px;}
.ms-step::after{content:'›';margin-left:6px;color:#ccc;font-size:14px;}
.ms-step:last-child::after{display:none;}
.ms-step .ms-num{width:20px;height:20px;border-radius:50%;background:#e8ecf4;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;flex-shrink:0;}
.ms-step.done{color:var(--success);}
.ms-step.done .ms-num{background:var(--success);color:#fff;}
.ms-step.active{color:var(--primary);}
.ms-step.active .ms-num{background:var(--primary);color:#fff;}

/*modal scrolling*/
/* Custom Scrollbar for a modern look */
#account-list::-webkit-scrollbar {
    width: 6px;
}
#account-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
#account-list::-webkit-scrollbar-thumb {
    background: var(--primary-mid); /* Uses your primary color theme */
    border-radius: 10px;
}
#account-list::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}

</style>

<!-- ═══════ ADD EXPENSE MODAL ═══════ -->
<div class="modal-bg" id="exp-modal">
  <div class="modal-box">
    
    <div class="mb-head">
      <h4><i class="fa-solid fa-plus-circle" style="color:var(--primary);margin-right:8px;"></i>Record New Expense</h4>
      <button type="button" class="mb-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    
    <div class="mb-body">

      <div class="modal-steps" id="modal-steps">
        <div class="ms-step active" id="ms1"><div class="ms-num">1</div>Classification</div>
        <div class="ms-step" id="ms2"><div class="ms-num">2</div>Details & Payment</div>
      </div>
		
      <div id="step-1">
        <div class="form-grid2">
          <div class="form-row">
            <label class="form-lbl">Category <span>*</span></label>
            <select class="fc" id="m-cat" onchange="onCatChange()">
              <option value="">— Select category —</option>
            </select>
            <div class="err-msg" id="err-cat" style="display:none;">Please select a category.</div>
          </div>
          
          <div class="form-row">
            <label class="form-lbl">Expense Type <span>*</span></label>
            <select class="fc" id="m-subcat">
              <option value="">— Select type —</option>
            </select>
            <div class="err-msg" id="err-subcat" style="display:none;">Please select a type.</div>
          </div>
        </div>

        <div class="divider" style="margin: 15px 0; height:1px; background:var(--card-border);"></div>

        <div class="form-grid2">
          <div class="form-row">
            <label class="form-lbl">Unit Price <span>*</span></label>
            <div class="ig">
              <span class="ipfx">Rs.</span>
              <input type="number" class="fc" id="m-amount" placeholder="0.00" oninput="calcTotal()">
            </div>
            <div class="err-msg" id="err-amount" style="display:none;">Please enter a valid amount.</div>
          </div>
          <div class="form-row">
            <label class="form-lbl">Quantity</label>
            <input type="number" class="fc" id="m-qty" value="1" min="1" oninput="calcTotal()">
          </div>
        </div>

        <div class="form-row" style="margin-top: 15px;">
          <div style="background:var(--table-head); border:1.5px solid var(--card-border); border-radius:var(--r-sm); padding:10px 15px; display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:12px; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Calculated Total</span>
            <span style="font-size:20px; font-weight:800; color:var(--primary); font-family:'JetBrains Mono',monospace;" id="m-total-display">Rs. 0.00</span>
          </div>
        </div>

        <div class="form-grid2">
          <div class="form-row">
            <label class="form-lbl">Expense Date <span>*</span></label>
            <input type="date" class="fc" id="m-date">
            <div class="err-msg" id="err-date" style="display:none;">Please select a date.</div>
          </div>
          <div class="form-row">
            <label class="form-lbl">Reference No.</label>
            <input type="text" class="fc" id="m-ref" placeholder="e.g. BILL/2026/01">
          </div>
        </div>

        <div class="form-row">
          <label class="form-lbl">Note / Description</label>
          <textarea class="fc" id="m-note" rows="2" placeholder="Optional details..."></textarea>
        </div>
      </div>

      <div id="step-2" style="display:none;">
        <label class="form-lbl" style="margin-bottom:10px; display:block;">Deduct From <span style="color:var(--danger)">*</span></label>
        <div id="account-list"></div>
        <div class="err-msg" id="err-account" style="display:none;">Please select an account.</div>
        
        <div class="divider" style="margin: 20px 0; height:1px; background:var(--card-border);"></div>
        
        <div style="background:var(--primary-light); border-radius:var(--r-sm); padding:12px 14px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
            <span style="font-size:12px; font-weight:600; color:var(--text-muted);">Category</span>
            <span style="font-size:12px; font-weight:700; color:var(--text-dark);" id="confirm-cat">—</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
            <span style="font-size:12px; font-weight:600; color:var(--text-muted);">Type</span>
            <span style="font-size:12px; font-weight:700; color:var(--text-dark);" id="confirm-type">—</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
            <span style="font-size:12px; font-weight:600; color:var(--text-muted);">Reference</span>
            <span style="font-size:12px; font-weight:700; font-family:'JetBrains Mono',monospace; color:var(--text-dark);" id="confirm-ref">—</span>
          </div>
          <div style="height:1px; background:var(--primary-mid); margin:8px 0;"></div>
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:13px; font-weight:800; color:var(--primary);">Total Amount</span>
            <span style="font-size:18px; font-weight:800; color:var(--primary); font-family:'JetBrains Mono',monospace;" id="confirm-total">Rs. 0.00</span>
          </div>
        </div>
      </div>

    </div> <div class="mb-foot">
      <button type="button" class="btn btn-outline btn-sm" id="btn-back" onclick="prevStep()" style="display:none;"><i class="fa-solid fa-arrow-left me-1"></i>Back</button>
      <button type="button" class="btn btn-outline btn-sm" onclick="closeModal()">Cancel</button>
      <button type="button" class="btn btn-primary btn-sm" id="btn-next" onclick="nextStep()">Next <i class="fa-solid fa-arrow-right ms-1"></i></button>
      <button type="button" class="btn btn-success btn-sm" id="btn-save" onclick="saveExpense()" style="display:none;"><i class="fa-solid fa-check me-1"></i>Save Expense</button>
    </div>

  </div>
</div>

<script>

var EXPENSES = []; // MUST be defined first
var selFamily = null;
var selAccount = null;
var targetDeleteExpenseId = null;
var CAT_COLORS = {
    'operational': '#3d52a0',
    'utilities': '#7091e6',
    'logistics': '#8697c4',
    'marketing': '#adbbda',
    'payroll': '#ede8f5',
    'other': '#aaa'
};


$(document).ready(function() {
    // Run the loader immediately
    renderFamilies();
});

// Function to load Families into the grid
function renderFamilies() {
    const grid = $('#etype-grid');
    grid.html('<div>Loading...</div>');

    $.ajax({
        url: '<?= site_url("Expense/get_families_ajax") ?>',
        type: 'GET',
        // Removing dataType: 'json' for a moment to handle the raw string error
        success: function(response) {
            grid.empty();
            
            // Check if the response is the string "unauthorized"
            if (response === "unauthorized") {
                grid.html('<div class="err-msg">Access Denied: Please log in again.</div>');
                return;
            }

            try {
                // If it's a string, parse it. If it's already an object, use it.
                const families = (typeof response === 'object') ? response : JSON.parse(response);
                
                families.forEach(fam => {
                    grid.append(`
                        <div class="etype-card" onclick="selectFamily(${fam.family_id}, '${fam.family_name}', this)" style="--card-accent: ${fam.color}">
                            <div class="etype-icon" style="background: ${fam.color}20; color: ${fam.color};">
                                <i class="fa-solid ${fam.icon}"></i>
                            </div>
                            <div class="etype-name">${fam.family_name}</div>
                        </div>`);
                });
            } catch (e) {
                console.error("JSON Error:", e);
                grid.html('<div class="err-msg">Invalid data received from server.</div>');
            }
        },
        error: function(xhr) {
            grid.html('<div>Error connecting to server.</div>');
        }
    });
}


// Global variables to hold selection
let selectedFamilyId = null;



function selectFamily(id, name, element) {
    selFamily = id; // IMPORTANT: This must match the variable name in validateStep
    $('.etype-card').removeClass('sel active');
    $(element).addClass('sel active');
    
    loadCategories(id);
    $('#cat-row').fadeIn();
    $('#err-etype').hide(); // Hide the error message immediately upon selection
}


// load categories 
function loadCategories() {
    const $catSelect = $('#m-cat');
    $catSelect.html('<option value="">Loading categories...</option>');

    $.ajax({
        url: '<?= site_url("Expense/get_categories_by_family") ?>', 
        type: 'GET', 
        dataType: 'json',
        success: function(categories) {
            let options = '<option value="">— Select category —</option>';
            
            if (categories && categories.length > 0) {
                categories.forEach(c => {
                    // We embed the family_id into the option element
                    options += `<option value="${c.exp_cat_id}" data-fam="${c.family_id}">
                                    ${c.family_name} > ${c.exp_cat_name}
                                </option>`;
                });
            } else {
                options = '<option value="">No categories found</option>';
            }
            $catSelect.html(options);
        },
        error: function() {
            $catSelect.html('<option value="">Error loading data</option>');
        }
    });
}

$(document).ready(function() {
    // Run the loader immediately
    loadCategories();
	onCatChange();
});


/* ═══════════════════════════════════════════════════
    LEVEL 3: FETCH TYPES (e.g., Office Rent, Bonus)
════════════════════════════════════════════════════ */
function onCatChange() {
    const catId = $('#m-cat').val();
    console.log("Triggered Level 3 for Category ID:");

    // 1. If empty selection, hide the next level and stop
    if (!catId || catId === "") {
        $('#subcat-row').hide();
        return;
    }

    // 2. Force the row to be visible immediately
    $('#subcat-row').css('display', 'block').fadeIn(200); 
    
    const $subcatSelect = $('#m-subcat');
    $subcatSelect.html('<option value="">Loading...</option>');

    $.ajax({
        url: '<?= site_url("Expense/get_types_by_category") ?>',
        type: 'POST',
        data: { cat_id: catId },
        dataType: 'json',
        success: function(types) {
            console.log("Data received from server:", types); // See what the DB sent
            
            let options = '<option value="">— Select type —</option>';
            
            if (Array.isArray(types) && types.length > 0) {
                types.forEach(t => {
                    // !!! DOUBLE CHECK THESE KEYS !!!
                    // Change 'type_id' to 'id' if that's what your table uses
                    options += `<option value="${t.type_id}">${t.type_name}</option>`;
                });
            } else {
                options = '<option value="">No types available</option>';
            }
            $subcatSelect.html(options);
        },
        error: function(xhr) {
            console.error("AJAX Error:", xhr.responseText);
            $subcatSelect.html('<option value="">Error fetching data</option>');
        }
    });
}


function validateStep(step) {
    var ok = true;
    
    // STEP 1: Classification
    if (step === 1) {
        // Validate Category
        if (!$('#m-cat').val()) { 
            $('#err-cat').show(); 
            ok = false; 
        } else { $('#err-cat').hide(); }

        // Validate Type (Sub-category)
        if (!$('#m-subcat').val()) { 
            $('#err-subcat').show(); 
            ok = false; 
        } else { $('#err-subcat').hide(); }
    }

    // STEP 2: Details & Payment
    if (step === 2) {
        var amt = parseFloat($('#m-amount').val()) || 0;
        if (amt <= 0) { 
            $('#err-amount').show(); 
            $('#m-amount').addClass('has-error'); 
            ok = false; 
        } else { 
            $('#err-amount').hide(); 
            $('#m-amount').removeClass('has-error'); 
        }

        if (!$('#m-date').val()) { $('#err-date').show(); ok = false; }
        
        // Ensure an account is selected (from Step 3 of the old design)
        if (!selAccount) { 
            $('#err-account').show(); 
            ok = false; 
        } else { $('#err-account').hide(); }
    }
    
    return ok;
}




/* ── TREND DATA (6 months) ── */
var TREND = [
  /*{month:'Dec 25', total:388000},
  {month:'Jan 26', total:412000},
  {month:'Feb 26', total:367000},
  {month:'Mar 26', total:445000},
  {month:'Apr 26', total:398000},*/
  {month:'May 26', total:2300}, // filled from EXPENSES*/
];

/* Category colors */
var CAT_COLORS = {
  operational:'#3d52a0', payroll:'#8b5cf6', logistics:'#f59e0b',
  utilities:'#0ea5e9', marketing:'#f43f5e', other:'#6b7280'
};

/* Comparison data (last month) */
/*var LAST_MONTH_CAT = {
  operational:110000, payroll:340000, logistics:32000,
  utilities:28000, marketing:18000, other:22000
};*/

/* ─── MODAL STATE ─── */
var modalStep = 1;
var selFamily = null;
var selAccount = null;

/* ─── INIT ─── */
$(function(){
  setTodayDate();
  renderKPIs();
  renderCatChart();
  renderTrendChart();
  renderTable();
  populateFilters();
  renderETypePills();
  renderAccountList();
});

function setTodayDate(){
  $('#m-date').val(new Date().toISOString().split('T')[0]);
}


function renderKPIs() {
    // Use 'amount' alias from your DB query
    var total = EXPENSES.reduce(function(a, b) { 
        return a + (parseFloat(b.qty) * parseFloat(b.amount)); 
    }, 0);

    // Ensure LAST_MONTH_CAT exists and is an object
    var lastMonthValues = (typeof LAST_MONTH_CAT !== 'undefined') ? Object.values(LAST_MONTH_CAT) : [];
    var lastTotal = lastMonthValues.reduce(function(a, b) { return a + b; }, 0);
    
    var delta = total - lastTotal;
    var pct = lastTotal > 0 ? ((delta / lastTotal) * 100).toFixed(1) : 0;
    
    var categories = getCatTotals();
    var topCat = categories.length > 0 ? categories[0] : null;

    $('#kpi-grid').html(
        kpi('c1', 'fa-receipt', fmt(total), 'This Month Total', pct > 0 ? 'up' : 'down',
            (pct > 0 ? '▲' : '▼') + ' ' + Math.abs(pct) + '% vs last month') +
        kpi('c2', 'fa-circle-dollar-to-slot', fmt(lastTotal), 'Last Month Total', 'flat', 'Apr 2026') +
        kpi('c3', 'fa-arrow-trend-up', fmt(Math.abs(delta)), 'Month Difference', delta > 0 ? 'up' : 'down',
            delta > 0 ? 'Increased' : 'Decreased') +
        kpi('c4', 'fa-layer-group', topCat ? topCat.label : '—', 'Top Category This Month', 'flat',
            topCat ? 'Rs. ' + fmt(topCat.total) : '')
    );

    // FIXED: Safety check for the TREND array
    if (typeof TREND !== 'undefined' && TREND[5]) {
        TREND[5].total = total;
    }
}

function kpi(cls,icon,val,lbl,deltaType,deltaTxt){
  return '<div class="kpi-card '+cls+'">'
    +'<div class="kpi-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid '+icon+'"></i></div>'
    +'<div class="kpi-val">'+val+'</div>'
    +'<div class="kpi-lbl">'+lbl+'</div>'
    +'<div class="kpi-delta '+deltaType+'"><i class="fa-solid '+(deltaType==='up'?'fa-arrow-up':deltaType==='down'?'fa-arrow-down':'fa-minus')+'"></i>'+deltaTxt+'</div>'
    +'</div>';
}

/* ─── CATEGORY TOTALS ─── */
function getCatTotals() {
    var map = {};
    EXPENSES.forEach(function(e) {
        // Use 'family' name as the key
        if (!map[e.family]) {
            map[e.family] = {
                family: e.family,
                label: e.family, // Already formatted from DB
                color: e.family_color || '#aaa', // Use DB color
                total: 0
            };
        }
        // Use the total_amount from the database
        map[e.family].total += parseFloat(e.total_amount) || 0;
    });
    return Object.values(map).sort(function(a, b) { return b.total - a.total; });
}

var LAST_MONTH_CAT = {}; // Global storage

function loadLastMonthData() {
    $.getJSON('<?= site_url("Expense/get_last_month_totals") ?>', function(data) {
        LAST_MONTH_CAT = data; // Should return { 'FamilyName': Total }
        renderCatChart(); // Refresh the chart with comparison bars
    });
}


function renderCatChart() {
    var cats = getCatTotals();
    
    // We assume LAST_MONTH_CAT is an object like { 'Operational': 5000, 'Utilities': 2000 }
    // If you don't have this yet, it will default to 0
    var lastMonthData = typeof LAST_MONTH_CAT !== 'undefined' ? LAST_MONTH_CAT : {};

    var allVals = cats.map(function(c) { return c.total; })
                      .concat(Object.values(lastMonthData));
    
    var maxVal = Math.max.apply(null, allVals) || 1;

    var html = cats.map(function(c) {
        var thisPct = Math.round((c.total / maxVal) * 100);
        var lastAmt = lastMonthData[c.family] || 0;
        var lastPct = Math.round((lastAmt / maxVal) * 100);
        var color   = c.color; // Using the color directly from the DB join

        return `
            <div class="bar-row">
                <div class="bar-label" title="${c.label}">${c.label}</div>
                <div class="dual-bar-track">
                    <div class="bar-track">
                        <div class="bar-fill" style="width:${thisPct}%; background:${color};"></div>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:${lastPct}%; background:#c5cff7;"></div>
                    </div>
                </div>
                <div class="bar-vals">
                    <div class="bar-this" style="color:${color};">${fmt(c.total)}</div>
                    <div class="bar-last">${fmt(lastAmt)}</div>
                </div>
            </div>`;
    }).join('');

    $('#cat-chart').html(html || '<div class="empty-chart">No data available for this month</div>');
}

/* ─── TREND SVG CHART ─── */
function renderTrendChart(){
  var data = TREND;
  var w = 480, h = 160, padL = 48, padR = 20, padT = 14, padB = 28;
  var chartW = w - padL - padR;
  var chartH = h - padT - padB;
  var maxVal = Math.max.apply(null, data.map(function(d){return d.total;})) * 1.15 || 1;
  var xStep  = chartW / (data.length - 1);

  function px(i){ return padL + i * xStep; }
  function py(v){ return padT + chartH - (v / maxVal) * chartH; }

  // Build path
  var pathD = data.map(function(d,i){ return (i===0?'M':'L') + px(i).toFixed(1)+','+py(d.total).toFixed(1); }).join(' ');
  var areaD = pathD + ' L'+px(data.length-1).toFixed(1)+','+(padT+chartH)+' L'+padL+','+(padT+chartH)+' Z';

  // Grid lines
  var gridLines = '';
  for (var g=0; g<=4; g++){
    var gy = padT + (chartH/4)*g;
    var gv = Math.round(maxVal * (1 - g/4));
    gridLines += '<line x1="'+padL+'" y1="'+gy.toFixed(1)+'" x2="'+(w-padR)+'" y2="'+gy.toFixed(1)+'" stroke="#e4e9f4" stroke-width="1"/>';
    gridLines += '<text x="'+(padL-6)+'" y="'+(gy+4)+'" text-anchor="end" font-size="9" fill="#8a94a6" font-family="\'JetBrains Mono\'">'+shortNum(gv)+'</text>';
  }

  // Dots + labels
  var dots = data.map(function(d,i){
    var isLast = i === data.length-1;
    return '<circle cx="'+px(i).toFixed(1)+'" cy="'+py(d.total).toFixed(1)+'" r="'+(isLast?5:4)+'" fill="'+(isLast?'var(--orange)':'var(--primary)')+'" stroke="#fff" stroke-width="2"/>'
      +'<text x="'+px(i).toFixed(1)+'" y="'+(padT+chartH+18)+'" text-anchor="middle" font-size="9.5" fill="#8a94a6" font-weight="600" font-family="\'Plus Jakarta Sans\'">'+d.month+'</text>'
      +(isLast&&d.total>0?'<text x="'+px(i).toFixed(1)+'" y="'+(py(d.total)-10)+'" text-anchor="middle" font-size="10" fill="var(--orange)" font-weight="800" font-family="\'JetBrains Mono\'">'+shortNum(d.total)+'</text>':'');
  }).join('');

  var svg = gridLines
    +'<defs><linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">'
      +'<stop offset="0%" stop-color="#3d52a0" stop-opacity="0.18"/>'
      +'<stop offset="100%" stop-color="#3d52a0" stop-opacity="0.02"/>'
    +'</linearGradient></defs>'
    +'<path d="'+areaD+'" fill="url(#areaGrad)"/>'
    +'<path d="'+pathD+'" fill="none" stroke="var(--primary)" stroke-width="2.2" stroke-linejoin="round" stroke-linecap="round"/>'
    +dots;

  $('#trend-chart').html(svg);
  $('#trend-legend').html(
    '<div class="leg-item"><div class="legend-dot" style="background:var(--primary);"></div>Monthly Total</div>'
    +'<div class="leg-item"><div class="legend-dot" style="background:var(--orange);"></div>Current Month</div>'
  );
}

/* ─── TABLE ─── */
function populateFilters(){
  var cats = {}, types = {}, accounts = {};
  EXPENSES.forEach(function(e){
    cats[e.cat]=1; types[e.type]=1; accounts[e.account]=1;
  });
  var catHtml='<option value="">All Categories</option>'+Object.keys(cats).sort().map(function(c){return '<option>'+c+'</option>';}).join('');
  var typeHtml='<option value="">All Types</option>'+Object.keys(types).sort().map(function(c){return '<option>'+c+'</option>';}).join('');
  var accHtml='<option value="">All Accounts</option>'+Object.keys(accounts).sort().map(function(c){return '<option>'+c+'</option>';}).join('');
  $('#f-cat').html(catHtml);
  $('#f-type').html(typeHtml);
  $('#f-account').html(accHtml);
}

/* Delete function and delete modal JS */
function deleteExp(id) {
    // 1. Save the ID into global memory context
    targetDeleteExpenseId = id;

    // 2. Open the custom Bootstrap confirmation modal layout frame cleanly
    // Supports either older Bootstrap v4 (.modal('show')) or newer v5 native initializations
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        var myModal = new bootstrap.Modal(document.getElementById('delete-confirm-modal'));
        myModal.show();
    } else {
        $('#delete-confirm-modal').modal('show');
    }
}

// 3. Attach a single click event listener handler to your modal action button
$(document).ready(function() {
    $('#btn-confirm-delete-submit').on('click', function() {
        if (!targetDeleteExpenseId) return;

        var id = targetDeleteExpenseId;
        var $btn = $(this);
        
        // Block consecutive click operations while transaction resolves
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');

        // Perform the AJAX status update to change state to 'pending'
        $.ajax({
            url: '<?= site_url("Expense/change_expense_status") ?>',
            type: 'POST',
            data: { expense_id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success || res.status === 'success') {
                    toast('Expense flagged as pending deletion', 'w');

                    // Sync local storage array matrix elements so UI state renders changes instantly
                    EXPENSES = EXPENSES.map(function(e) {
                        var eId = e.exp_id || e.id;
                        if (parseInt(eId) === parseInt(id)) {
                            e.status = 'pending';
                        }
                        return e;
                    });

                    // Instantly rebuild and update dashboard components locally
                    renderTable();
                    if (typeof renderKPIs === "function") renderKPIs();
                    if (typeof renderCatChart === "function") renderCatChart();
                    if (typeof renderTrendChart === "function") renderTrendChart();
                    if (typeof populateFilters === "function") populateFilters();

                } else {
                    toast(res.message || 'Error updating status', 'e');
                }
            },
            error: function() {
                toast('Connection interface failure', 'e');
            },
            complete: function() {
                // Reset structural visual button state configurations
                $btn.prop('disabled', false).text('Yes, Proceed');
                targetDeleteExpenseId = null;
                
                // Hide the modal container view frame
                $('#delete-confirm-modal').modal('hide');
            }
        });
    });
});

function renderTable() {
    // 1. Get filter values from UI
    var q    = ($('#search-inp').val() || '').toLowerCase();
    var cat  = $('#f-cat').val();
    var type = $('#f-type').val();
    var acc  = $('#f-account').val();

    // 2. Filter the global EXPENSES array
    var rows = EXPENSES.filter(function(e) {
        if (cat  && e.cat !== cat)   return false;
        if (type && e.type !== type) return false;
        if (acc  && e.account !== acc) return false;
        
        if (q && !(e.note || '').toLowerCase().includes(q)
              && !(e.reference_no || e.ref || '').toLowerCase().includes(q)
              && !(e.cat  || '').toLowerCase().includes(q)
              && !(e.type || '').toLowerCase().includes(q)) return false;
        return true;
    });

    // 3. Update result counter
    $('#results-count').text(rows.length + ' record' + (rows.length !== 1 ? 's' : ''));

    // 4. Handle empty state
    if (!rows.length) {
        $('#exp-tbody').html('<tr><td colspan="10"><div class="empty-state"><i class="fa-solid fa-receipt"></i><p>No expenses found.</p></div></td></tr>');
        return;
    }

    // 5. Build HTML rows matching your schema setup
    var html = rows.map(function(e) {
        var expId  = e.exp_id || e.id;
        var date   = e.expense_date || e.date;
        var refNo  = e.reference_no || e.ref || '—';
        var amount = parseFloat(e.unit_amount || e.amount) || 0;
        var total  = parseFloat(e.total_amount) || 0;
        var color  = e.family_color || '#6b7280';
        
        // ── TARGET THE SCHEMA ENUM 'pending' STATUS VALUE ──
        var isPending = (e.status && e.status.toLowerCase() === 'pending');

        // ── DISABLE LOGIC ATTRIBUTES & INLINE STYLING FADES ──
        var deleteDisabled = isPending ? 'disabled' : '';
        var deleteStyle    = isPending ? 'opacity: 0.35; cursor: not-allowed; background: #f2f4fa !important; border-color: #d1d9e6 !important; color: #a8b4d8 !important;' : '';
        var deleteTitle    = isPending ? 'Pending Deletion Approval' : 'Delete';

        return `
            <tr>
                <td style="font-size:12px;color:var(--text-muted);white-space:nowrap;">${date}</td>
                <td><span class="mono" style="font-size:11px;color:var(--text-muted);">${refNo}</span></td>
                <td>
                    <span class="cat-badge" style="background:${color}18;color:${color}">
                        <i class="fa-solid fa-circle" style="font-size:7px;"></i> ${e.cat || 'No Cat'}
                    </span>
                </td>
                <td><span class="type-badge">${e.type || '—'}</span></td>
                <td style="font-size:12px;color:var(--text-mid);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="${e.note}">
                    ${e.note || '—'}
                </td>
                <td style="font-size:12px;color:var(--text-mid);">${e.account || '—'}</td>
                <td class="r mono" style="font-size:12px;">${e.qty}</td>
                <td class="r mono" style="font-size:12px;">${fmt(amount)}</td>
                <td class="r"><strong class="mono">${fmt(total)}</strong></td>
                <td style="text-align:center;">
                    <button class="action-btn-del" 
                        onclick="deleteExp(${expId})"
                        ${deleteDisabled}
                        style="${deleteStyle}" 
                        title="${deleteTitle}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </td>
            </tr>`;
    }).join('');

    $('#exp-tbody').html(html);
}

/*function renderTable() {
    // 1. Get filter values from UI
    var q    = ($('#search-inp').val() || '').toLowerCase();
    var cat  = $('#f-cat').val();
    var type = $('#f-type').val();
    var acc  = $('#f-account').val();

    // 2. Filter the global EXPENSES array
    var rows = EXPENSES.filter(function(e) {
        if (cat  && e.cat !== cat)   return false;
        if (type && e.type !== type) return false;
        if (acc  && e.account !== acc) return false;
        
        // Search across multiple fields - using the new key aliases
        if (q && !(e.note || '').toLowerCase().includes(q)
              && !(e.ref  || '').toLowerCase().includes(q)
              && !(e.cat  || '').toLowerCase().includes(q)
              && !(e.type || '').toLowerCase().includes(q)) return false;
        return true;
    });

    // 3. Update result counter
    $('#results-count').text(rows.length + ' record' + (rows.length !== 1 ? 's' : ''));

    // 4. Handle empty state
    if (!rows.length) {
        $('#exp-tbody').html('<tr><td colspan="10"><div class="empty-state"><i class="fa-solid fa-receipt"></i><p>No expenses found.</p></div></td></tr>');
        return;
    }

    // 5. Build HTML rows using the DB Join aliases
    var html = rows.map(function(e) {
        var total  = parseFloat(e.total_amount) || 0;
        var amount = parseFloat(e.amount) || 0; // Using alias 'amount' from PHP
        var color  = e.family_color || '#6b7280'; // Using alias 'family_color' from PHP
        
        return `
            <tr>
                <td style="font-size:12px;color:var(--text-muted);white-space:nowrap;">${e.date}</td>
                <td><span class="mono" style="font-size:11px;color:var(--text-muted);">${e.ref || '—'}</span></td>
                <td>
                    <span class="cat-badge" style="background:${color}18;color:${color}">
                        <i class="fa-solid fa-circle" style="font-size:7px;"></i> ${e.cat || 'No Cat'}
                    </span>
                </td>
                <td><span class="type-badge">${e.type || '—'}</span></td>
                <td style="font-size:12px;color:var(--text-mid);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="${e.note}">
                    ${e.note || '—'}
                </td>
                <td style="font-size:12px;color:var(--text-mid);">${e.account || '—'}</td>
                <td class="r mono" style="font-size:12px;">${e.qty}</td>
                <td class="r mono" style="font-size:12px;">${fmt(amount)}</td>
                <td class="r"><strong class="mono">${fmt(total)}</strong></td>
                <td style="text-align:center;">
                    <button class="action-btn-del" onclick="deleteExp(${e.exp_id})" title="Delete">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </td>
            </tr>`;
    }).join('');

    $('#exp-tbody').html(html);
}*/

/* ─── MODAL ─── */
function openModal(){
  modalStep=1; selFamily=null; selAccount=null;
  resetModal();
  $('#exp-modal').addClass('show');
  updateStepUI();
}
function closeModal(){ $('#exp-modal').removeClass('show'); 
resetModal();
}

/*function resetModal(){
  selFamily=null; selAccount=null;
  $('#etype-grid .etype-pill').removeClass('sel');
  $('#m-cat').val(''); $('#m-subcat').val('');
  $('#m-amount').val(''); $('#m-qty').val(1);
  $('#m-ref').val(''); $('#m-note').val('');
  $('#m-total-display').text('Rs. 0.00');
  $('#cat-row,#subcat-row').hide();
  $('.err-msg').hide(); $('.fc').removeClass('has-error');
  setTodayDate();
  $('#account-list .acc-option').removeClass('sel');
  updateStepUI();
}*/
function resetModal() {
    //  FIX 1: Explicitly reset the wizard sequence state tracker to the beginning
    if (typeof currentStep !== 'undefined') {
        currentStep = 1; 
    }

    // Clear primary selection states
    selFamily = null; 
    selAccount = null;
    
    // Clear custom grid selections and highlights
    $('#etype-grid .etype-pill').removeClass('sel');
    $('#account-list .acc-option').removeClass('sel');
    
    //  FIX 2: Clear values and force standard 'change' events to keep plugins in sync
    $('#m-cat, #m-subcat, #m-amount, #m-ref, #m-note')
        .val('')
        .trigger('change'); 

    // Reset numeric tracking defaults securely
    $('#m-qty').val(1).trigger('change');
    
    //  FIX 3: Reset confirmation view indicators alongside your standard display output text
    $('#m-total-display').text('Rs. 0.00');
    $('#confirm-cat, #confirm-type, #confirm-ref').text('—');
    $('#confirm-total').text('Rs. 0.00');
    
    // Structural layout management toggles
    $('#cat-row, #subcat-row').hide();
    $('.err-msg').hide(); 
    
    //  FIX 4: Clear validation errors from inputs AND their form structural row wrappers
    $('.fc').removeClass('has-error');
    $('.form-row, .form-grid2, .form-group').removeClass('has-error');
    
    // Reset date picker limits to the current system timestamp
    if (typeof setTodayDate === 'function') {
        setTodayDate();
    }
    
    //  FIX 5: Fire the step layout builder to ensure buttons hide/show correctly for Step 1
    if (typeof updateStepUI === 'function') {
        updateStepUI();
    } else if (typeof updateStepWizardUI === 'function') {
        updateStepWizardUI(); // Fallback if you used the updated navigation name
    }
}
$(document).ready(function() {
    // Bind directly to the native Bootstrap hide event wrapper
    $('#exp-modal').on('hidden.bs.modal', function () {
        resetModal();
    });
});


function renderETypePills() {
    const grid = $('#etype-grid');
    grid.html('<div style="padding:20px; color:var(--text-muted);">Loading categories...</div>');

    $.ajax({
        url: '<?= site_url("Expense/get_families_ajax") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(families) {
            grid.empty(); // Clear the loading message
            
            families.forEach(fam => {
                // We use the database ID and Name now
                const pill = `
				<div class="etype-card" onclick="selectFamily(${fam.family_id}, '${fam.family_name}', this)" style="--card-accent: ${fam.color || '#6b7280'}">
				<div class="etype-icon" style="background: ${fam.color || '#6b7280'}20; color: ${fam.color || '#6b7280'};">
				<i class="fa-solid ${fam.icon || 'fa-folder'}"></i>
				</div>
				<div class="etype-name">${fam.family_name}</div>
				</div>`;
                grid.append(pill);
            });
        },
        error: function(err) {
            console.error("Database Error:", err);
            grid.html('<div class="err-msg">Failed to load from database.</div>');
        }
    });
}


function calcTotal(){
  var amt = parseFloat($('#m-amount').val())||0;
  var qty = parseInt($('#m-qty').val())||1;
  $('#m-total-display').text('Rs. '+fmt(amt*qty));
}
$('#m-amount,#m-qty').on('input',calcTotal);


function renderAccountList() {
    const list = $('#account-list');
    list.html('<div style="padding:20px; color:var(--text-muted);">Loading accounts...</div>');

    //  Calculate current total from Step 1 to compare balances against
    const unitPrice = parseFloat($('#m-amount').val()) || 0;
    const quantity = parseInt($('#m-qty').val()) || 1;
    const totalExpenseCost = unitPrice * quantity;

    $.ajax({
        url: '<?= site_url("Expense/get_bank_accounts_ajax") ?>', 
        type: 'GET',
        dataType: 'json',
        success: function(accounts) {
            list.empty();
            
            if (accounts.length === 0) {
                list.html('<div class="err-msg">No active bank accounts found.</div>');
                return;
            }

            accounts.forEach(acc => {
                const displayName = acc.account_nickname || acc.account_name;
                const balance = parseFloat(acc.current_balance) || 0;

                //  Validation Check: Is balance 0, negative, or less than the required total?
                const isInsufficient = (balance <= 0 || balance < totalExpenseCost);
                
                // Dynamic attributes based on validation status
                const disabledClass = isInsufficient ? 'disabled-acc' : '';
                const clickHandler = isInsufficient ? '' : `onclick="selectAccount(${acc.bank_acc_id}, this)"`;
                const inlineStyle = isInsufficient ? 'opacity: 0.5; cursor: not-allowed; pointer-events: none;' : 'cursor: pointer;';
                const balanceBadge = isInsufficient ? `<span style="font-size:10px; color:var(--danger); font-weight:700; text-transform:uppercase; display:block; text-align:right;">Low Funds</span>` : '';

                list.append(`
                    <div class="acc-option ${disabledClass}" id="ao-${acc.bank_acc_id}" ${clickHandler} data-balance="${balance}" style="${inlineStyle}">
                        <div>
                            <div class="acc-name" style="${isInsufficient ? 'color: var(--text-muted);' : ''}">${displayName}</div>
                            <div class="acc-type">${acc.account_type.toUpperCase()} - ${acc.account_number}</div>
                        </div>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div>
                                <span class="acc-bal" style="${isInsufficient ? 'color: var(--danger);' : ''}">Rs. ${fmt(balance)}</span>
                                ${balanceBadge}
                            </div>
                            <div class="acc-radio" id="ar-${acc.bank_acc_id}" style="${isInsufficient ? 'display:none;' : ''}"></div>
                        </div>
                    </div>
                `);
            });
        },
        error: function() {
            list.html('<div class="err-msg">Failed to load bank accounts.</div>');
        }
    });
}

function selectAccount(id, el){
  selAccount=id;
  $('.acc-option').removeClass('sel');
  $('.acc-radio').html('');
  $(el).addClass('sel');
  $('#ar-'+id).html('<span style="width:6px;height:6px;border-radius:50%;background:#fff;"></span>');
  $('#err-account').hide();
}


var currentStep = 1;

function nextStep() {
    // Step 1 Client-Side Validation Check
    if (currentStep === 1) {
        var isValid = true;
        $('.err-msg').hide();
        $('.fc').removeClass('has-error');

        if (!$('#m-cat').val()) { $('#err-cat').show(); $('#m-cat').addClass('has-error'); isValid = false; }
        if (!$('#m-subcat').val()) { $('#err-subcat').show(); $('#m-subcat').addClass('has-error'); isValid = false; }
        if (!$('#m-amount').val() || parseFloat($('#m-amount').val()) <= 0) { $('#err-amount').show(); $('#m-amount').addClass('has-error'); isValid = false; }
        if (!$('#m-date').val()) { $('#err-date').show(); $('#m-date').addClass('has-error'); isValid = false; }

        if (!isValid) return; // Halt if form constraints are not met

        // THE FIX: Extract the family ID directly from the selected category option's data attribute
        var selectedCatOption = $('#m-cat option:selected');
        selFamily = selectedCatOption.attr('data-fam') || selectedCatOption.data('fam') || null;

        // Move forward to step 2 tracking state
        currentStep = 2;
        
        // Render the active accounts layout tree
        if (typeof renderAccountList === "function") {
            renderAccountList();
        }
    }
    updateStepUI();
}

function prevStep() {
    if (currentStep === 2) {
        currentStep = 1;
    }
    updateStepUI();
}

function updateStepUI() {
    if (currentStep === 1) {
        // UI Layout visibility
        $('#step-1').show();
        $('#step-2').hide();
        
        // Step header bar indicators
        $('#ms1').addClass('active');
        $('#ms2').removeClass('active');
        
        // Footer navigation controls
        $('#btn-back').hide();
        $('#btn-next').show();
        $('#btn-save').hide();
    } else if (currentStep === 2) {
        // UI Layout visibility
        $('#step-1').hide();
        $('#step-2').show();
        
        // Step header bar indicators
        $('#ms1').removeClass('active');
        $('#ms2').addClass('active');
        
        // Footer navigation controls
        $('#btn-back').show();
        $('#btn-next').hide();
        $('#btn-save').show();
        
        //  Sync user data to Step 2 confirmation receipt box
        $('#confirm-cat').text($('#m-cat option:selected').text());
        $('#confirm-type').text($('#m-subcat option:selected').text());
        $('#confirm-ref').text($('#m-ref').val() || '—');
        $('#confirm-total').text($('#m-total-display').text());
    }
}

// Ensure your calculation script runs safely as well
function calcTotal() {
    var price = parseFloat($('#m-amount').val()) || 0;
    var qty = parseInt($('#m-qty').val()) || 1;
    var total = price * qty;
    
    // Formats cleanly without adding raw duplicate LKR symbols manually
    var formatted = 'Rs. ' + total.toLocaleString('en-LK', { minimumFractionDigits: 2 });
    $('#m-total-display').text(formatted);
}



function validateStep(step) {
    var ok = true;
    
    // STEP 1: Category Selection
    if (step === 1) {
        // We now check the dropdown value instead of the old Family Cards
        if (!$('#m-cat').val()) { 
            $('#err-cat').show(); 
            ok = false; 
        } else {
            $('#err-cat').hide();
        }
    }

    // STEP 2: Amount, Date, and Type
    if (step === 2) {
        // Validate Amount
        var amt = parseFloat($('#m-amount').val()) || 0;
        if (amt <= 0) { 
            $('#err-amount').show(); 
            $('#m-amount').addClass('has-error'); 
            ok = false; 
        } else { 
            $('#err-amount').hide(); 
            $('#m-amount').removeClass('has-error'); 
        }

        // Validate Date
        if (!$('#m-date').val()) { 
            $('#err-date').show(); 
            ok = false; 
        } else { 
            $('#err-date').hide(); 
        }

        // Validate Sub-category (Type) - Moved here from Step 1
        if (!$('#m-subcat').val()) { 
            $('#err-subcat').show(); 
            ok = false; 
        } else { 
            $('#err-subcat').hide(); 
        }
    }
    
    return ok;
}


/*function saveExpense() {
    // 1.  FIXED FINAL GUARD: Use 'currentStep' instead of 'modalStep'
    if (typeof validateStep === "function") {
        if (!validateStep(1) || !validateStep(2)) return;
    }
    
    // 2. Ensure an account is physically selected
    if (!selAccount) { 
        $('#err-account').text('Please select an account.').show(); 
        return; 
    }

    // 3.  EXTRACT TRUTH DIRECTLY FROM THE SELECTED ELEMENT
    var $selectedAccountEl = $(`#ao-${selAccount}`);
    var exactBankBalance = parseFloat($selectedAccountEl.data('balance')) || 
                           parseFloat($selectedAccountEl.attr('data-balance')) || 0;

    // Calculate dynamic total cost packet
    var qty = parseInt($('#m-qty').val()) || 1;
    var unitAmount = parseFloat($('#m-amount').val()) || 0;
    var totalExpenseCost = unitAmount * qty;

    // 4.  THE CRITICAL BALANCE ENFORCEMENT CHECK
    if (totalExpenseCost > exactBankBalance) {
        toast(`Transaction Rejected: Insufficient Funds!`, 'e');
        
        $('#err-account')
            .text(`Insufficient balance! This account only has Rs. ${exactBankBalance.toLocaleString('en-US', {minimumFractionDigits: 2})}`)
            .addClass('text-danger')
            .show();
            
        return; // ABSOLUTE HALT - STOPS AJAX DEAD IN ITS TRACKS
    }

    // 5. Prepare the Data Packet
    var formData = {
        date:         $('#m-date').val(),
        ref_no:       $('#m-ref').val() || '', 
        family_id:    selFamily,               
        cat_id:       $('#m-cat').val(),       
        type_id:      $('#m-subcat').val(),    
        bank_acc_id:  selAccount,              
        note:         $('#m-note').val(),
        qty:          qty,
        amount:       unitAmount
    };

    // 6. UI Feedback Button State Shift
    var $btn = $('#btn-save'); 
    var originalBtnHtml = $btn.html();
    $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

    // 7. The AJAX Call Execution Block
    $.ajax({
        url: '<?= site_url("Expense/save_expense_ajax") ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(res) {
            if (res.success || res.status == 'success') {
                
                // Close the modal container
                if (typeof closeModal === "function") closeModal(); 

                // Reset global tracking variables back to Step 1
                currentStep = 1; 
                selFamily = null;
                selAccount = null;

                // Sync UI layouts
                if (typeof resetModal === "function") resetModal();

                toast('Expense recorded and balance updated!', 's');
                
                // Asynchronously reload page grid tables
                if (typeof get_all_expenses === "function") get_all_expenses();
                
            } else {
                toast(res.message || 'Error saving data', 'e');
            }
        },
        error: function() {
            toast('Connection error. Please check your network.', 'e');
        },
        complete: function() {
            $btn.prop('disabled', false).html(originalBtnHtml);
        }
    });
	refreshDashboard();
}*/

function saveExpense() {
    // 1. Final Guard: Run Step 1 & Step 2 structural validation checkpoints
    if (typeof validateStep === "function") {
        if (!validateStep(1) || !validateStep(2)) return;
    }

    // 2. Ensure an account is physically selected in the UI tree
    if (!selAccount) { 
        $('#err-account').text('Please select a bank account to proceed.').show(); 
        return; 
    }

    //  3. EXTRACTION ZONE: Pull balance directly from the active DOM element
    var $selectedAccountEl = $(`#ao-${selAccount}`);
    var exactBankBalance = parseFloat($selectedAccountEl.data('balance')) || 
                           parseFloat($selectedAccountEl.attr('data-balance')) || 0;

    // Calculate dynamic total cost of current fields
    var qty = parseInt($('#m-qty').val()) || 1;
    var unitAmount = parseFloat($('#m-amount').val()) || 0;
    var totalExpenseCost = unitAmount * qty;

    //  4. CRITICAL BALANCE ENFORCEMENT GUARD
    if (totalExpenseCost > exactBankBalance) {
        toast(`Transaction Rejected: Insufficient Funds!`, 'e');
        
        $('#err-account')
            .text(`Insufficient balance! This account only has Rs. ${exactBankBalance.toLocaleString('en-US', {minimumFractionDigits: 2})}`)
            .addClass('text-danger')
            .show();
            
        return; //  ABSOLUTE HALT - STOPS THE AJAX PAYLOAD ENTIRELY
    }

    // 5. Prepare the Data Packet directly from Modal Inputs
    var formData = {
		project_id:   (typeof PROJECT !== 'undefined' && PROJECT.id) ? PROJECT.id : new URLSearchParams(window.location.search).get('project_id'),
        date:         $('#m-date').val(),
        ref_no:       $('#m-ref').val() || '', 
        family_id:    $('#m-subcat option:selected').data('family-id') || selFamily, // Read straight from dropdown context
        cat_id:       $('#m-cat').val(),       
        type_id:      $('#m-subcat').val(),    
        bank_acc_id:  selAccount, // Read from currently selected account id              
        note:         $('#m-note').val(),
        qty:          qty,
        amount:       unitAmount
    };

    // 6. UI Loading Feedback State Shift (Targets #btn-save submission node safely)
    var $btn = $('#btn-save').length ? $('#btn-save') : $('#btn-next'); 
    var originalBtnHtml = $btn.html();
    $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

    // 7. The AJAX Network Call
    $.ajax({
        url: '<?= site_url("Expense/save_expense_ajax") ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(res) {
            if (res.success || res.status == 'success') {
                
                // --- HARD RESET PROCESS FOR A 2-STEP MODAL FLOW ---
                
                // Close the modal container securely
                if (typeof closeModal === "function") {
                    closeModal();
                } else {
                    $('#expense-modal').modal('hide'); 
                }

                // Reset step tracking layers
                currentStep = 1; 
                if (typeof modalStep !== 'undefined') modalStep = 1; 

                // Reset form input values safely
                $('#m-cat').val('');
                $('#m-subcat').html('<option value="">— Select type —</option>').val('');
                $('#m-amount').val('');
                $('#m-qty').val(1);
                $('#m-ref').val('');
                $('#m-note').val('');
                if (typeof setTodayDate === "function") setTodayDate();

                // Clean error visual indicators and classes
                $('.err-msg').hide();
                $('.has-error').removeClass('has-error');
                $('#account-list .acc-option').removeClass('sel'); // Clear selection highlights cleanly

                // Explicitly reset view blocks back to Screen 1
                $('#step-1').show();
                $('#step-2').hide();
                
                // Sync circles/stepper UI layout indicators
                if (typeof updateStepUI === "function") updateStepUI();

                // Notification Toast
                toast('Expense recorded and balance updated!', 's');
                
                // Asynchronously refresh list data tables and layout views across the dashboard
                if (typeof get_all_expenses === "function") get_all_expenses();
                if (typeof renderAccountList === "function") renderAccountList(); 
                
            } else {
                // Catches explicit rejection states from CodeIgniter backend
                toast(res.message || 'Error saving data', 'e');
            }
        },
        error: function() {
            toast('Connection error. Please check your network.', 'e');
        },
        complete: function() {
            // Restore button properties if the transaction finished processing or crashed
            $btn.prop('disabled', false).html(originalBtnHtml);
        }
    });
}
/*function loadExpenses() {
    // Show a loading spinner in the table body while waiting
    $('#exp-tbody').html('<tr><td colspan="10" style="text-align:center; padding:50px;"><i class="fa-solid fa-spinner fa-spin fa-2x"></i></td></tr>');

    $.ajax({
        url: '<?= site_url("Expense/get_expenses_ajax") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Update the global EXPENSES variable used by other functions
            EXPENSES = data; 
            
            // Re-run the UI functions that depend on this data
            renderTable();
            renderKPIs();
            renderCatChart();
            renderTrendChart();
        },
        error: function() {
            $('#exp-tbody').html('<tr><td colspan="10" class="text-center text-danger">Failed to load data from server.</td></tr>');
        }
    });
}*/
$(document).ready(function() {
    console.log("Page ready, triggering data load..."); // Debugging line
    loadExpenses(); 
});
function loadExpenses() {
	console.log("loadExpenses function is now RUNNING...");
    $('#exp-tbody').html('<tr><td colspan="10" style="text-align:center; padding:50px;"><i class="fa-solid fa-spinner fa-spin fa-2x"></i></td></tr>');

    $.ajax({
        url: '<?= site_url("Expense/get_expenses_ajax") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Ensure data is an array
            EXPENSES = Array.isArray(data) ? data : []; 
            
            // Trigger all UI updates now that we have data
            renderTable();
            renderKPIs();
            
            // Only initialize charts if the data exists
            if (EXPENSES.length > 0) {
                renderCatChart();
                renderTrendChart();
            }
        },
        error: function(xhr) {
            console.error("Data Load Error:", xhr.responseText);
            $('#exp-tbody').html('<tr><td colspan="10" class="text-center text-danger">Failed to load data. Please check connection.</td></tr>');
        }
    });
}

// Helper to reload data
function refreshDashboard() {
    // If you still use the local EXPENSES array for charts, 
    // you should trigger a fresh fetch_expenses_ajax() here.
    renderKPIs();
    renderCatChart();
    renderTrendChart();
    renderTable();
    populateFilters();
	loadExpenses();
}

/* ─── DELETE ─── */
/*function deleteExp(id){
  if (!confirm('Delete this expense entry?')) return;
  EXPENSES = EXPENSES.filter(function(e){return e.id!==id;});
  renderKPIs(); renderCatChart(); renderTrendChart(); renderTable(); populateFilters();
  toast('Expense deleted','w');
}*/

/* ─── EXPORT ─── */
function exportExpenses(){ toast('Exporting expenses…','i'); /* AJAX */ }

/* ─── HELPERS ─── */
function fmt(n){ return Number(n).toLocaleString('en-LK',{minimumFractionDigits:2,maximumFractionDigits:2}); }
function shortNum(n){ if (n>=1000000) return (n/1000000).toFixed(1)+'M'; if (n>=1000) return (n/1000).toFixed(0)+'K'; return n; }
function capitalize(s){ return s.charAt(0).toUpperCase()+s.slice(1); }

function toast(msg,type){
  var map={s:['t-s','fa-check-circle'],w:['t-w','fa-triangle-exclamation'],e:['t-e','fa-circle-xmark'],i:['t-i','fa-circle-info']};
  var p=map[type]||map.i;
  var $t=$('<div class="t-item '+p[0]+'"><i class="fa-solid '+p[1]+'"></i>'+msg+'</div>');
  $('#toast-c').append($t);
  setTimeout(function(){$t.css({opacity:0,transform:'translateX(16px)',transition:'all .3s'});setTimeout(function(){$t.remove();},300);},2800);
}
</script>

