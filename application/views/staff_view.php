<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Staff Custom Styles -->
        <style>
            .staff-status-badge { font-size: 0.75rem; padding: 0.35em 0.8em; border-radius: 30px; letter-spacing: 0.04em; }
            .staff-step-bar { display: flex; align-items: center; gap: 0; }
            .staff-step { display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; padding: 0.3rem 0.8rem; background: #f0f0f0; color: #888; }
            .staff-step.active { background: #405189; color: #fff; }
            .staff-step.done { background: #d4edda; color: #155724; }
            .staff-step:first-child { border-radius: 20px 0 0 20px; }
            .staff-step:last-child { border-radius: 0 20px 20px 0; }
            .staff-number-badge { background: #eef2ff; color: #3d52a0; border: 1px solid #c5cff7; border-radius: 8px; padding: 0.25rem 0.75rem; font-size: 0.875rem; font-weight: 600; font-family: monospace; }
            .section-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; }
            .section-header .section-icon { width: 32px; height: 32px; background: linear-gradient(135deg, #405189, #6172b0); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.875rem; flex-shrink: 0; }
            .section-header h6 { margin: 0; font-weight: 600; font-size: 0.925rem; }
            .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
            .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
            .form-grid-4 { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem; }
            .badge-active { background: #d1e7dd; color: #0f5132; }
            .badge-inactive { background: #f8d7da; color: #842029; }
            .badge-delete { background: #e9ecef; color: #495057; }
        </style>

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-semibold fs-18 mb-1">Staff Management</h1>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="staff-number-badge" id="staff-id-display">
                        <i class="ri-user-line me-1"></i>Loading...
                    </span>
                    <input type="hidden" id="hidden-staff-id" value="">
                    <span class="badge staff-status-badge badge-active" id="summary-status">New</span>
                    <div class="staff-step-bar ms-2">
                        <span class="staff-step done"><i class="ri-check-line me-1"></i>New</span>
                        <span class="staff-step active"><i class="ri-edit-line me-1"></i>Profile</span>
                        <span class="staff-step">Bank</span>
                        <span class="staff-step">Salary</span>
                        <span class="staff-step">Complete</span>
                    </div>
                </div>
            </div>
            <div class="ms-md-1 ms-0 mt-md-0 mt-2">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">HR</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Staff</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Start Staff Create Content -->
        <div class="row g-3">

            <!-- LEFT COLUMN (Main) -->
            <div class="col-xl-8 col-lg-12">

                <!-- SECTION 1: Personal Information -->
                <div class="card custom-card mb-3">
                    <div class="card-header">
                        <div class="section-header mb-0">
                            <span class="section-icon"><i class="ri-user-line"></i></span>
                            <h6>Personal Information</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-grid-2">
                            <div class="col-span-2">
                                <label class="form-label fw-medium fs-13">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="full-name" placeholder="Enter full name">
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" placeholder="example@company.com">
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" placeholder="0771234567">
                            </div>
                            <div class="col-span-2">
                                <label class="form-label fw-medium fs-13">Address</label>
                                <textarea class="form-control" id="address" rows="2" placeholder="Enter full address"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Employment Information -->
                <div class="card custom-card mb-3">
                    <div class="card-header">
                        <div class="section-header mb-0">
                            <span class="section-icon"><i class="ri-briefcase-line"></i></span>
                            <h6>Employment Information</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-grid-3">
                            <div>
                                <label class="form-label fw-medium fs-13">Designation <span class="text-danger">*</span></label>
                                <select class="form-control" id="designation">
                                    <option value="">-- Select Designation --</option>
                                    <?php foreach($designation as $item): ?>
                                        <option value="<?= $item->ut_id ?>"><?= $item->ut_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">Employee Type</label>
                                <select class="form-control" id="employee-type">
                                    <option value="permanent">Permanent</option>
                                    <option value="contract">Contract</option>
                                    <option value="probation">Probation</option>
                                    <option value="intern">Intern</option>
                                    <option value="temporary">Temporary</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">Status</label>
                                <select class="form-control" id="staff-status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">EPF Number</label>
                                <input type="text" class="form-control" id="epf-no" placeholder="EPF number">
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">Basic Salary (LKR)</label>
                                <input type="number" class="form-control" id="basic-salary" placeholder="0.00" step="0.01">
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">OT Enable</label>
                                <select class="form-control" id="ot-enable">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Bank Information -->
                <div class="card custom-card mb-3">
                    <div class="card-header">
                        <div class="section-header mb-0">
                            <span class="section-icon"><i class="ri-bank-line"></i></span>
                            <h6>Bank Information</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-grid-2">
                            <div>
                                <label class="form-label fw-medium fs-13">Bank Name</label>
                                <select class="form-control" id="bank-id">
                                    <option value="">-- Select Bank --</option>
                                    <?php foreach($bank as $item): ?>
                                        <option value="<?= $item->bank_id ?>"><?= $item->bank_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">Bank Branch</label>
                                <input type="text" class="form-control" id="bank-branch" placeholder="Branch name">
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">Account Name</label>
                                <input type="text" class="form-control" id="account-name" placeholder="Account holder name">
                            </div>
                            <div>
                                <label class="form-label fw-medium fs-13">Account Number</label>
                                <input type="text" class="form-control" id="account-number" placeholder="Account number">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <button class="btn btn-secondary" id="btn-save-draft">
                                <i class="ri-save-line me-1"></i> Save Draft
                            </button>
                            <button class="btn btn-primary" id="btn-submit">
                                <i class="ri-send-plane-line me-1"></i> Save & Submit
                            </button>
                            <div class="ms-auto d-flex gap-2">
                                <button class="btn btn-warning-light" id="btn-cancel">
                                    <i class="ri-close-line me-1"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (Sidebar) -->
            <div class="col-xl-4 col-lg-12">

                <!-- Staff Summary Card -->
                <div class="card custom-card mb-3">
                    <div class="card-header">
                        <div class="section-header mb-0">
                            <span class="section-icon"><i class="ri-information-line"></i></span>
                            <h6>Staff Summary</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Staff ID</span>
                                <span class="fw-semibold font-monospace" id="summary-staff-id">Loading...</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Full Name</span>
                                <span class="fw-semibold" id="summary-name">--</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Designation</span>
                                <span class="fw-semibold" id="summary-designation">--</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Email</span>
                                <span class="fw-semibold" id="summary-email">--</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Phone</span>
                                <span class="fw-semibold" id="summary-phone">--</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center fs-13">
                                <span class="text-muted">Basic Salary</span>
                                <span class="fw-bold text-primary fs-14" id="summary-salary">LKR 0.00</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Validation Checklist -->
                <div class="card custom-card mb-3">
                    <div class="card-header">
                        <div class="section-header mb-0">
                            <span class="section-icon bg-success" style="background:linear-gradient(135deg,#25b865,#1a9c52)!important;"><i class="ri-shield-check-line"></i></span>
                            <h6>Validation Checklist</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 fs-13" id="validation-checklist">
                            <li class="d-flex align-items-center gap-2 mb-2" data-check="name">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                <span>Full name entered</span>
                            </li>
                            <li class="d-flex align-items-center gap-2 mb-2" data-check="email">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                <span>Valid email address</span>
                            </li>
                            <li class="d-flex align-items-center gap-2 mb-2" data-check="phone">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                <span>Valid phone number</span>
                            </li>
                            <li class="d-flex align-items-center gap-2" data-check="designation">
                                <i class="ri-checkbox-circle-fill text-success"></i>
                                <span>Designation selected</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
// Global helper functions
function showToast(msg, type = 'primary') {
    const colors = { primary: '#405189', success: '#25b865', danger: '#dc3545', warning: '#f7b731', info: '#0dcaf0' };
    const container = document.getElementById('toast-container') || (() => {
        const d = document.createElement('div');
        d.id = 'toast-container';
        d.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;';
        document.body.appendChild(d);
        return d;
    })();
    const toast = document.createElement('div');
    toast.style.cssText = `background:${colors[type] || colors.primary};color:#fff;padding:12px 18px;border-radius:8px;font-size:13px;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,0.2);max-width:320px;opacity:0;transform:translateY(8px);transition:all 0.25s;z-index:9999;`;
    toast.innerHTML = `<i class="ri-checkbox-circle-line me-2"></i>${msg}`;
    container.appendChild(toast);
    requestAnimationFrame(() => { toast.style.opacity = 1; toast.style.transform = 'translateY(0)'; });
    setTimeout(() => { toast.style.opacity = 0; setTimeout(() => toast.remove(), 300); }, 3500);
}

function fmtLKR(n) {
    return 'LKR ' + parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Check if we're editing an existing staff
const urlParams = new URLSearchParams(window.location.search);
const staffId = urlParams.get('id');

let currentStaffId = null;

function collectStaffData() {
    return {
        staff_id: currentStaffId,
        full_name: document.getElementById('full-name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value,
        designation: document.getElementById('designation').value,
        employee_type: document.getElementById('employee-type').value,
        status: document.getElementById('staff-status').value,
        epf_no: document.getElementById('epf-no').value,
        basic_salary: parseFloat(document.getElementById('basic-salary').value) || 0,
        ot_enable: parseInt(document.getElementById('ot-enable').value) || 0,
        bank_id: document.getElementById('bank-id').value || null,
        bank_branch: document.getElementById('bank-branch').value,
        account_name: document.getElementById('account-name').value,
        account_no: document.getElementById('account-number').value
    };
}

function updateSummary() {
    const name = document.getElementById('full-name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const designationSelect = document.getElementById('designation');
    const designation = designationSelect.options[designationSelect.selectedIndex]?.text || '--';
    const salary = parseFloat(document.getElementById('basic-salary').value) || 0;
    
    document.getElementById('summary-name').textContent = name || '--';
    document.getElementById('summary-email').textContent = email || '--';
    document.getElementById('summary-phone').textContent = phone || '--';
    document.getElementById('summary-designation').textContent = designation;
    document.getElementById('summary-salary').textContent = fmtLKR(salary);
}

function updateValidationChecklist() {
    const nameValid = !!document.getElementById('full-name').value.trim();
    const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(document.getElementById('email').value);
    const phoneValid = /^[0-9]{10}$/.test(document.getElementById('phone').value);
    const designationValid = !!document.getElementById('designation').value;
    
    const checks = { name: nameValid, email: emailValid, phone: phoneValid, designation: designationValid };
    Object.keys(checks).forEach(key => {
        const li = document.querySelector(`[data-check="${key}"]`);
        if (li) {
            const text = li.querySelector('span')?.textContent || key;
            li.innerHTML = checks[key] ? `<i class="ri-checkbox-circle-fill text-success"></i><span>${text}</span>` : `<i class="ri-error-warning-fill text-warning"></i><span>${text}</span>`;
        }
    });
}

function generateStaffId() {
    if(staffId) {
        loadStaffData(staffId);
        return;
    }
    
    fetch('<?php echo site_url("Staff/generateStaffId"); ?>', {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            currentStaffId = data.data.staff_id;
            document.getElementById('staff-id-display').innerHTML = '<i class="ri-user-line me-1"></i>' + currentStaffId;
            document.getElementById('hidden-staff-id').value = currentStaffId;
            document.getElementById('summary-staff-id').textContent = currentStaffId;
        }
    })
    .catch(error => console.error('Error generating staff ID:', error));
}

function loadStaffData(id) {
    fetch('<?php echo site_url("Staff/getStaffById/"); ?>' + id, {
        method: 'GET',
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success' && data.data) {
            const staff = data.data;
            currentStaffId = staff.staff_id;
            
            document.getElementById('staff-id-display').innerHTML = '<i class="ri-user-line me-1"></i>' + currentStaffId;
            document.getElementById('hidden-staff-id').value = currentStaffId;
            document.getElementById('summary-staff-id').textContent = currentStaffId;
            
            document.getElementById('full-name').value = staff.full_name || '';
            document.getElementById('email').value = staff.email || '';
            document.getElementById('phone').value = staff.phone || '';
            document.getElementById('address').value = staff.address || '';
            document.getElementById('designation').value = staff.ut_id || '';
            document.getElementById('employee-type').value = staff.employee_type || 'permanent';
            document.getElementById('staff-status').value = staff.status || 'active';
            document.getElementById('epf-no').value = staff.epf_no || '';
            document.getElementById('basic-salary').value = staff.basic_salary || 0;
            document.getElementById('ot-enable').value = staff.ot_enable || 0;
            document.getElementById('bank-id').value = staff.bank_id || '';
            document.getElementById('bank-branch').value = staff.bank_branch || '';
            document.getElementById('account-name').value = staff.account_name || '';
            document.getElementById('account-number').value = staff.account_no || '';
            
            updateSummary();
            updateValidationChecklist();
            showToast('Staff data loaded', 'success');
        }
    })
    .catch(error => console.error('Error loading staff:', error));
}

// Event Listeners
$(document).ready(function() {
    generateStaffId();
    
    // Input listeners for real-time updates
    $('#full-name, #email, #phone, #designation, #basic-salary').on('input change', function() {
        updateSummary();
        updateValidationChecklist();
    });
    
    // Save Draft
    $('#btn-save-draft').on('click', function() {
        const staffData = collectStaffData();
        
        if (!staffData.full_name) {
            showToast('Please enter full name', 'warning');
            return;
        }
        if (!staffData.email) {
            showToast('Please enter email', 'warning');
            return;
        }
        if (!staffData.phone) {
            showToast('Please enter phone number', 'warning');
            return;
        }
        
        fetch('<?= site_url("Staff/store"); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(staffData),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                showToast('Staff saved successfully', 'success');
                if(!currentStaffId && data.data?.staff_id) {
                    currentStaffId = data.data.staff_id;
                    document.getElementById('staff-id-display').innerHTML = '<i class="ri-user-line me-1"></i>' + currentStaffId;
                    document.getElementById('hidden-staff-id').value = currentStaffId;
                }
            } else {
                showToast(data.msg || 'Save failed', 'danger');
            }
        })
        .catch(error => showToast('Save failed', 'danger'));
    });
    
    // Submit Button
    $('#btn-submit').on('click', function() {
        const staffData = collectStaffData();
        
        if (!staffData.full_name) { showToast('Please enter full name', 'warning'); return; }
        if (!staffData.email) { showToast('Please enter email', 'warning'); return; }
        if (!staffData.phone) { showToast('Please enter phone number', 'warning'); return; }
        if (!staffData.designation) { showToast('Please select designation', 'warning'); return; }
        
        fetch('<?= site_url("Staff/store"); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(staffData),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                showToast('Staff saved successfully', 'success');
                setTimeout(() => {
                    window.location.href = '<?= site_url("Staff/staff_list") ?>';
                }, 1500);
            } else {
                showToast(data.msg || 'Save failed', 'danger');
            }
        })
        .catch(error => showToast('Save failed', 'danger'));
    });
    
    // Cancel button
    $('#btn-cancel').on('click', function() {
        if(confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
            window.location.href = '<?= site_url("Staff/staff_list") ?>';
        }
    });
});
</script>