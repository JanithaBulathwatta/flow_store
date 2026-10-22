<?php 
$edit_mode = isset($edit_mode) && $edit_mode === true;
$staff_data = isset($staff) ? $staff : null;
?>
<style>

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;min-height:100vh;}
::-webkit-scrollbar{width:5px;height:5px;}
::-webkit-scrollbar-track{background:transparent;}
::-webkit-scrollbar-thumb{background:#c5cff7;border-radius:10px;}

/* Main Content - Will work with sidebar toggle */
.main-content {
  margin-left: var(--sidebar-w);
  margin-top: var(--header-h);
  padding: 0;
  transition: margin-left 0.3s ease;
  min-height: calc(100vh - var(--header-h));
}

/* When sidebar is collapsed */
.main-content.sidebar-collapsed,
.sidebar-collapsed .main-content {
  margin-left: 0;
}

body.sidebar-mini .main-content {
  margin-left: 70px;
}

.container-fluid {
  width: 100%;
  padding: 0;
  margin: 0;
}


.banner-inner{
  display:flex;
  gap:24px;
  align-items:flex-end;
  position:relative;
  z-index:1;
}

.banner-info .sub{
  font-size:13px;
  color:rgba(255,255,255,0.65);
  margin-bottom:10px;
}
.banner-actions{
  padding-bottom:10px;
  display:flex;
  gap:8px;
  flex-wrap:wrap;
  align-self:flex-end;
}

/* Buttons */
.btn{
  padding:9px 16px;
  border-radius:var(--radius-sm);
  font-family:inherit;
  font-size:13px;
  font-weight:700;
  cursor:pointer;
  border:none;
  transition:all var(--transition);
  display:inline-flex;
  align-items:center;
  gap:7px;
}
.btn-white{background:var(--white);color:var(--blue-dark);}
.btn-white:hover{background:var(--blue-soft);}
.btn-primary{background:linear-gradient(135deg,var(--blue-dark),var(--blue-normal));color:var(--white);box-shadow:0 4px 12px rgba(0, 123, 255, 0.28);}
.btn-primary:hover{transform:translateY(-1px);}
.btn-secondary{background:var(--white);color:var(--black-normal);border:1.5px solid var(--input-border);}
.btn-secondary:hover{border-color:var(--blue-dark);color:var(--blue-dark);}
.btn-sm{padding:6px 12px;font-size:12px;}

/* Body Layout */
.profile-body {
  padding: 0 28px 22px 28px;
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 20px;
  align-items: start;
}

/* Cards */
.card{
  background:var(--white);
  border:1px solid var(--input-border);
  border-radius:var(--radius-md);
  box-shadow:var(--shadow-sm);
  overflow:hidden;
  margin-bottom:18px;
}
.card-header{
  padding:13px 18px;
  border-bottom:1px solid var(--input-border);
  display:flex;
  align-items:center;
  gap:10px;
}
.section-icon{
  width:30px;
  height:30px;
  border-radius:var(--radius-sm);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:14px;
  flex-shrink:0;
}
.si-blue{background:var(--blue-soft);color:var(--blue-dark);}
.si-green{background:var(--green-soft);color:var(--green-dark);}
.si-purple{background:var(--purple-soft);color:var(--purple-dark);}
.si-orange{background:var(--orange-soft);color:var(--orange-dark);}
.si-teal{background:var(--green-soft);color:var(--green-dark);} /* Mapped teal to Green Dark based on your system */
.card-header h6{font-size:13px;font-weight:700;color:var(--black-dark);flex:1;margin:0;}
.card-body{padding:18px;}

/* Form Elements */
.form-label{
  font-size:11px;
  font-weight:700;
  color:var(--black-normal);
  display:block;
  margin-bottom:5px;
  text-transform:uppercase;
  letter-spacing:.4px;
}
.required-star{color:var(--red-dark);}
.form-control, .form-select{
  width:100%;
  padding:9px 12px;
  border:1.5px solid var(--input-border);
  border-radius:var(--radius-sm);
  background:var(--white);
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:13px;
  color:var(--black-dark);
  outline:none;
  transition:border-color var(--transition),box-shadow var(--transition);
  appearance:none;
}
.form-control:focus,.form-select:focus{border-color:var(--blue-dark);box-shadow:0 0 0 3px rgba(46, 142, 247, 0.12);}
.form-control.is-invalid{border-color:var(--red-dark);}
.form-control.is-valid{border-color:var(--green-dark);}
.form-control:read-only{background:var(--blue-soft);color:var(--black-normal);cursor:not-allowed;}
textarea.form-control{resize:vertical;min-height:70px;}

/* Grid Helpers */
.form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.form-grid-4{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:14px;}
.span-2{grid-column:span 2;}
.mb-14{margin-bottom:14px;}
.sdiv{display:flex;align-items:center;gap:10px;margin:16px 0 14px;}
.sdiv span{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:var(--black-normal);white-space:nowrap;}
.sdiv::before,.sdiv::after{content:'';flex:1;height:1px;background:var(--input-border);}

/* Avatar Upload */
.avatar-upload-wrap{display:flex;align-items:center;gap:20px;}
.avatar-preview{
  width:90px;
  height:90px;
  border-radius:50%;
  border:3px solid var(--blue-soft);
  background:var(--blue-soft);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:32px;
  color:var(--blue-dark);
  position:relative;
  cursor:pointer;
  flex-shrink:0;
  overflow:hidden;
}
.avatar-preview img{width:100%;height:100%;object-fit:cover;border-radius:50%;display:none;}
.avatar-preview .avatar-overlay{
  position:absolute;
  inset:0;
  background:rgba(46, 142, 247, 0.6);
  display:flex;
  align-items:center;
  justify-content:center;
  color:var(--white);
  font-size:12px;
  font-weight:700;
  opacity:0;
  transition:opacity var(--transition);
  border-radius:50%;
  flex-direction:column;
  gap:2px;
}
.avatar-preview:hover .avatar-overlay{opacity:1;}
#avatar-file-input{display:none;}

/* Role Cards */
.role-grid{display:grid;grid-template-columns:repeat(8,1fr);gap:8px;margin-bottom:14px;}
.role-card{
  border:2px solid var(--input-border);
  border-radius:var(--radius-sm);
  padding:10px 8px;
  text-align:center;
  cursor:pointer;
  transition:all var(--transition);
}
.role-card i{font-size:18px;display:block;margin-bottom:4px;color:var(--black-normal);}
.role-card span{font-size:11px;font-weight:700;color:var(--black-normal);display:block;}
.role-card.selected{border-color:var(--blue-dark);background:var(--blue-soft);}
.role-card.selected i,.role-card.selected span{color:var(--blue-dark);}

/* Password Box */
.pwd-gen-box{
  background:linear-gradient(135deg, var(--black-dark) 0%, var(--blue-dark) 100%);
  border-radius:var(--radius-sm);
  padding:14px 16px;
  display:flex;
  align-items:center;
  gap:12px;
}
.pwd-display{
  flex:1;
  font-family:'JetBrains Mono',monospace;
  font-size:15px;
  font-weight:600;
  color:var(--yellow-dark);
  letter-spacing:2px;
}
.btn-regen{
  padding:6px 12px;
  background:rgba(255,255,255,0.1);
  border:1px solid rgba(255,255,255,0.2);
  border-radius:var(--radius-sm);
  color:var(--white);
  font-size:11px;
  font-weight:700;
  cursor:pointer;
  display:flex;
  align-items:center;
  gap:5px;
}
.btn-regen:hover{background:rgba(255,255,255,0.2);}

/* Send Via */
.send-via-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px;}
.send-via-btn{
  padding:9px;
  border:2px solid var(--input-border);
  border-radius:var(--radius-sm);
  background:var(--white);
  cursor:pointer;
  text-align:center;
}
.send-via-btn i{font-size:16px;display:block;margin-bottom:3px;color:var(--black-normal);}
.send-via-btn span{font-size:11px;font-weight:700;color:var(--black-normal);}
.send-via-btn.selected{border-color:var(--blue-dark);background:var(--blue-soft);}
.send-via-btn.selected i,.send-via-btn.selected span{color:var(--blue-dark);}

/* Toggle Section */
.toggle-section{
  border:1.5px solid var(--input-border);
  border-radius:var(--radius-md);
  overflow:hidden;
  margin-bottom:18px;
}
.toggle-header{
  padding:14px 18px;
  display:flex;
  align-items:center;
  gap:12px;
  cursor:pointer;
  background:var(--white);
  transition:background var(--transition);
}
.toggle-header:hover{background:var(--blue-soft);}
.toggle-icon-wrap{
  width:36px;
  height:36px;
  border-radius:var(--radius-sm);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:16px;
  flex-shrink:0;
}
.ti-blue{background:var(--blue-soft);color:var(--blue-dark);}
.ti-green{background:var(--green-soft);color:var(--green-dark);}
.toggle-title{font-size:13px;font-weight:700;color:var(--black-dark);}
.toggle-subtitle{font-size:11px;color:var(--black-normal);margin-top:1px;}
.toggle-switch-wrap{margin-left:auto;display:flex;align-items:center;gap:10px;}
.toggle-switch{position:relative;width:42px;height:22px;flex-shrink:0;}
.toggle-switch input{opacity:0;width:0;height:0;position:absolute;}
.toggle-slider{
  position:absolute;
  inset:0;
  border-radius:22px;
  background:var(--input-border);
  cursor:pointer;
  transition:background var(--transition);
}
.toggle-slider::before{
  content:'';
  position:absolute;
  left:3px;
  top:3px;
  width:16px;
  height:16px;
  border-radius:50%;
  background:var(--white);
  box-shadow:0 1px 3px rgba(0,0,0,0.2);
  transition:transform var(--transition);
}
.toggle-switch input:checked+.toggle-slider{background:var(--green-dark);}
.toggle-switch input:checked+.toggle-slider::before{transform:translateX(20px);}
.toggle-chevron{color:var(--black-normal);font-size:14px;transition:transform var(--transition);}
.toggle-section.active .toggle-chevron{transform:rotate(180deg);}
.toggle-body{display:none;border-top:1px solid var(--input-border);padding:18px;animation:fadeSlide .2s ease;}
.toggle-section.active .toggle-body{display:block;}
@keyframes fadeSlide{from{opacity:0;transform:translateY(-6px);}to{opacity:1;transform:translateY(0);}}

/* Repeater Items */
.repeater-item{
  display:grid;
  grid-template-columns:1fr 150px 36px;
  gap:8px;
  align-items:center;
  padding:8px;
  background:var(--blue-soft);
  border-radius:var(--radius-sm);
  border:1px solid var(--input-border);
  margin-bottom:8px;
}
.btn-remove-repeater{
  width:32px;
  height:36px;
  border:1.5px solid var(--red-soft);
  background:none;
  border-radius:var(--radius-sm);
  color:var(--red-dark);
  cursor:pointer;
  display:flex;
  align-items:center;
  justify-content:center;
}
.btn-remove-repeater:hover{background:var(--red-dark);color:var(--white);}
.btn-add-repeater{
  padding:8px 14px;
  border:1.5px dashed var(--blue-normal);
  background:var(--blue-soft);
  color:var(--blue-dark);
  border-radius:var(--radius-sm);
  font-size:12px;
  font-weight:700;
  cursor:pointer;
  width:100%;
  margin-top:8px;
  display:flex;
  align-items:center;
  gap:6px;
  justify-content:center;
}
.btn-add-repeater.danger{border-color:var(--red-normal);background:var(--red-soft);color:var(--red-dark);}

/* EPF/ETF */
.epf-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}

/* Net Salary Display */
.net-salary-display{
  background:linear-gradient(135deg,var(--blue-dark) 0%,var(--black-dark) 100%);
  border-radius:var(--radius-md);
  padding:16px;
  color:var(--white);
  margin-top:14px;
}
.net-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;font-size:12px;}
.net-divider{height:1px;background:rgba(255,255,255,0.2);margin:10px 0;}
.net-total-row{display:flex;justify-content:space-between;align-items:center;}
.net-total-row .nl{font-size:14px;font-weight:800;}
.net-total-row .nv{font-size:20px;font-weight:800;font-family:'JetBrains Mono',monospace;}

/* Lock Toggle */
.lock-toggle-row{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:10px 14px;
  background:var(--green-soft);
  border:1.5px solid var(--green-dark);
  border-radius:var(--radius-sm);
  margin-top:12px;
}
.lock-toggle-row.locked{background:var(--red-soft);border-color:var(--red-normal);}

/* Right Column */
.right-col{
  display:flex;
  flex-direction:column;
  gap:16px;
  position:sticky;
  top:calc(var(--header-h) + 20px);
}
.staff-preview-card{text-align:center;padding:6px 0 10px;}
.preview-avatar{
  width:70px;
  height:70px;
  border-radius:50%;
  margin:0 auto 10px;
  background:linear-gradient(135deg,var(--blue-soft),var(--blue-normal));
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:26px;
  font-weight:800;
  color:var(--blue-dark);
  border:3px solid var(--blue-soft);
  overflow:hidden;
}
.preview-avatar img{width:100%;height:100%;object-fit:cover;display:none;}
.preview-name{font-size:15px;font-weight:800;color:var(--black-dark);}
.preview-calling{font-size:12px;color:var(--black-normal);margin-bottom:8px;}
.preview-tags{display:flex;flex-wrap:wrap;gap:6px;justify-content:center;margin-bottom:12px;}
.preview-tag{
  font-size:10px;
  font-weight:700;
  padding:2px 8px;
  border-radius:20px;
  text-transform:uppercase;
  letter-spacing:.4px;
}
.pt-dept{background:var(--blue-soft);color:var(--blue-dark);}
.pt-role{background:var(--purple-soft);color:var(--purple-dark);}
.pt-type{background:var(--green-soft);color:var(--green-dark);}
.pt-status{background:var(--green-soft);color:var(--green-dark);}
.preview-meta{display:flex;flex-direction:column;gap:6px;}
.preview-meta-row{
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:12px;
  padding:6px 0;
  border-bottom:1px solid var(--input-border);
}
.preview-meta-row:last-child{border-bottom:none;}
.preview-meta-row .pm-label{color:var(--black-normal);font-weight:600;}
.preview-meta-row .pm-value{font-weight:700;font-family:'JetBrains Mono',monospace;font-size:12px;}

/* Checklist */
.checklist-item{
  display:flex;
  align-items:center;
  gap:8px;
  padding:7px 0;
  border-bottom:1px solid var(--input-border);
  font-size:13px;
}
.checklist-item:last-child{border-bottom:none;}
.check-icon{
  width:20px;
  height:20px;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:10px;
  flex-shrink:0;
  background:var(--input-border);
  color:var(--black-normal);
}
.check-ok{background:var(--green-soft);color:var(--green-dark);}

/* Validation */
.validation-msg{font-size:11px;margin-top:4px;font-weight:600;display:none;}
.validation-msg.valid{color:var(--green-dark);display:block;}
.validation-msg.invalid{color:var(--red-dark);display:block;}
.field-hint{font-size:11px;color:var(--black-normal);margin-top:4px;}

/* Modal */
.modal-overlay{
  position:fixed;
  inset:0;
  background:rgba(35, 35, 35, 0.75);
  z-index:9999;
  display:none;
  align-items:center;
  justify-content:center;
}
.modal-card{
  background:var(--white);
  border-radius:var(--radius-lg);
  padding:40px;
  text-align:center;
  max-width:420px;
  width:90%;
  animation:popIn .4s cubic-bezier(.34,1.56,.64,1);
}
@keyframes popIn{from{opacity:0;transform:scale(0.8);}to{opacity:1;transform:scale(1);}}
.modal-icon{
  width:72px;
  height:72px;
  border-radius:50%;
  background:var(--green-soft);
  display:flex;
  align-items:center;
  justify-content:center;
  margin:0 auto 16px;
  font-size:32px;
  color:var(--green-dark);
}
.modal-card h3{font-size:20px;font-weight:800;margin-bottom:6px;color:var(--black-dark);}
.modal-card p{font-size:13px;color:var(--black-normal);margin-bottom:20px;}
.modal-info{
  background:var(--blue-soft);
  border-radius:var(--radius-sm);
  padding:14px;
  margin-bottom:20px;
  text-align:left;
}
.modal-info-row{display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px;color:var(--black-dark);}
.modal-actions{display:flex;gap:10px;justify-content:center;}

/* Action Bar */
.action-bar{
  position:sticky;
  bottom:0;
  background:var(--white);
  border-top:1px solid var(--input-border);
  padding:14px 24px;
  margin-top:24px;
  z-index:50;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:10px;
  border-radius:var(--radius-md);
  margin-left: 28px;
  margin-right: 28px;
  margin-bottom: 0;
}

/* Toast */
#toast-container{
  position:fixed;
  top:calc(var(--header-h) + 12px);
  right:24px;
  z-index:9999;
  display:flex;
  flex-direction:column;
  gap:8px;
  pointer-events:none;
}
.toast-item{
  padding:12px 18px;
  border-radius:var(--radius-sm);
  font-size:13px;
  font-weight:600;
  pointer-events:auto;
  display:flex;
  align-items:center;
  gap:8px;
  box-shadow:var(--shadow-lg);
  animation:toastIn .3s ease;
  max-width:320px;
}
@keyframes toastIn{from{opacity:0;transform:translateX(20px);}to{opacity:1;transform:translateX(0);}}
.toast-success{background:var(--green-dark);color:var(--white);}
.toast-warning{background:var(--yellow-dark);color:var(--white);}
.toast-danger{background:var(--red-dark);color:var(--white);}
.toast-info{background:var(--blue-dark);color:var(--white);}

/* Responsive */
@media(max-width:1100px){
  .profile-body{grid-template-columns:1fr;}
  .right-col{position:static;top:0;}
  .form-grid-3,.form-grid-4{grid-template-columns:1fr 1fr;}
}
@media(max-width:768px){
  .main-content{margin-left:0;}
  .form-grid-2,.form-grid-3,.form-grid-4{grid-template-columns:1fr;}
  .span-2{grid-column:span 1;}
  .role-grid{grid-template-columns:repeat(4,1fr);}
  .action-bar{margin-left: 16px;margin-right: 16px;flex-direction:column;}
  .profile-banner{padding:20px;}
  .profile-body{padding:16px;}
  .banner-inner{flex-direction:column;align-items:center;text-align:center;}
  .banner-actions{align-self:center;}
}

/* Workflow Steps */
.workflow-steps { 
    display: flex; 
    align-items: center; 
    gap: 0; 
    margin-top: 8px; 
}
.wf-step { 
    display: flex; 
    align-items: center; 
    gap: 6px; 
    font-size: 11px; 
    font-weight: 600; 
    padding: 4px 10px; 
    color: var(--black-normal); 
    position: relative; 
}
.wf-step::after { 
    content: '›'; 
    position: absolute; 
    right: -4px; 
    color: var(--input-border); 
    font-size: 14px; 
}
.wf-step:last-child::after { 
    display: none; 
}
.wf-step.done { 
    color: var(--green-dark); 
}
.wf-step.active { 
    color: var(--blue-dark); 
    font-weight: 700; 
}
.wf-step i { 
    font-size: 10px; 
}

/* Badges */
.emp-id-badge {
    display: inline-flex; 
    align-items: center; 
    gap: 6px;
    background: var(--blue-soft); 
    border: 1px solid var(--blue-normal);
    border-radius: var(--radius-sm); 
    padding: 3px 12px;
    font-family: 'JetBrains Mono', monospace; 
    font-size: 13px; 
    font-weight: 600; 
    color: var(--blue-dark); 
    margin-right: 8px;
}

.status-pill {
    display: inline-flex; 
    align-items: center; 
    gap: 5px;
    padding: 3px 10px; 
    border-radius: 20px; 
    font-size: 11px; 
    font-weight: 700; 
    text-transform: uppercase; 
    letter-spacing: .5px;
}
.status-new { 
    background: var(--blue-soft); 
    color: var(--blue-dark); 
}}

</style>

<div class="main-content">
    <div class="container-fluid">
<!-- PAGE HEADER -->
<div class="page-header" style="margin-top: 16px; margin-bottom: 16px; padding: 0 28px; display: flex; align-items: center; justify-content: space-between;">
    <div class="page-header-left">
        <h1 style="font-size: 22px; font-weight: 700; color: var(--text-dark);">Create New Staff Member</h1>
        <div style="display:flex;align-items:center;gap:8px;margin-top:8px;flex-wrap:wrap;">
            <span class="emp-id-badge"><i class="fa-solid fa-id-badge"></i> <span id="emp-id-display">EMP-2026-0042</span></span>
            <span class="status-pill status-new"><i class="fa-solid fa-circle" style="font-size:7px"></i> NEW RECORD</span>
            <div class="workflow-steps">
                <span class="wf-step done"><i class="fa-solid fa-check"></i> Init</span>
                <span class="wf-step active"><i class="fa-solid fa-pencil"></i> Basic Info</span>
                <span class="wf-step">Account</span>
                <span class="wf-step">Salary</span>
                <span class="wf-step">Save</span>
			</div>
        </div>
    </div>
	
	
    <div style="display:flex;gap:8px;">
        <button class="btn btn-secondary" onclick="resetForm()"><i class="fa-solid fa-rotate-left"></i> Reset</button>
    </div>
</div>
        <!-- BODY -->
        <div class="profile-body">
            <!-- LEFT COLUMN -->
            <div id="main-col">
                <!-- BASIC INFORMATION CARD -->
                <div class="card">
                    <div class="card-header">
                        <div class="section-icon si-blue"><i class="fa-solid fa-user"></i></div>
                        <h6>Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <!-- Profile Image -->
                        <div class="avatar-upload-wrap mb-14">
                            <div class="avatar-preview" id="avatar-preview" onclick="$('#avatar-file-input').click()">
                                <i class="fa-solid fa-user" id="avatar-placeholder"></i>
                                <img id="avatar-img" src="" alt="">
                                <div class="avatar-overlay"><i class="fa-solid fa-camera"></i><span>Change</span></div>
                            </div>
                            <input type="file" id="avatar-file-input" accept="image/*" onchange="handleAvatarUpload(this)">
                            <div>
                                <h6 style="font-size:13px;">Profile Photo <span style="font-size:9px;background:#f1f5f9;padding:1px 6px;border-radius:10px;">Optional</span></h6>
                                <p style="font-size:11px;color:var(--text-muted);">Upload a clear face photo. Max 2MB.</p>
                            </div>
                        </div>

                        <input type="hidden" id="staff_id" value="<?php echo $edit_mode ? $staff_data->staff_id : ''; ?>">
                        
                        <div class="sdiv"><span>Identity</span></div>
                        <div class="form-grid-3 mb-14">
                            <div class="span-2">
                                <label class="form-label">Full Name <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="full-name" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->full_name) : ''; ?>" placeholder="e.g. Kamal Priya Perera" oninput="syncPreview()">
                                <div class="validation-msg" id="full-name-msg"></div>
                            </div>
                            <div>
                                <label class="form-label">Calling Name <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="calling-name" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->calling_name) : ''; ?>" placeholder="e.g. Kamal" oninput="syncPreview()">
                            </div>
                        </div>

                        <div class="form-grid-4 mb-14">
                            <div>
                                <label class="form-label">Gender</label>
                                <select class="form-control form-select" id="gender" onchange="syncPreview()">
                                    <option value="">— Select —</option>
                                    <option value="Male" <?php echo ($edit_mode && $staff_data->gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($edit_mode && $staff_data->gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Other" <?php echo ($edit_mode && $staff_data->gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" value="<?php echo ($edit_mode && $staff_data->dob) ? $staff_data->dob : ''; ?>" onchange="calcAge()">
                                <div class="field-hint" id="age-display"></div>
                            </div>
                            <div>
                                <label class="form-label">NIC / Passport</label>
                                <input type="text" class="form-control" id="nic" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->nic_passport) : ''; ?>" placeholder="e.g. 901234567V">
                            </div>
                            <div>
                                <label class="form-label">Blood Group</label>
                                <select class="form-control form-select" id="blood-group">
                                    <option value="">— Unknown —</option>
                                    <?php $groups = ['A+','A-','B+','B-','AB+','AB-','O+','O-']; foreach($groups as $g): ?>
                                    <option value="<?php echo $g; ?>" <?php echo ($edit_mode && $staff_data->blood_group == $g) ? 'selected' : ''; ?>><?php echo $g; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="sdiv"><span>Contact</span></div>
                        <div class="form-grid-2 mb-14">
                            <div>
                                <label class="form-label">Contact Number 1 <span class="required-star">*</span></label>
                                <input type="tel" class="form-control" id="phone1" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->phone) : ''; ?>" placeholder="e.g. 0771234567" maxlength="10" oninput="syncPhone1();syncPreview()">
                                <div class="validation-msg" id="phone1-msg"></div>
                                <div class="field-hint"><i class="fa-solid fa-info-circle"></i> Used as login username</div>
                            </div>
                            <div>
                                <label class="form-label">Contact Number 2</label>
                                <input type="tel" class="form-control" id="phone2" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->phone2) : ''; ?>" placeholder="e.g. 0112334455" maxlength="10">
                            </div>
                            <div>
                                <label class="form-label">Email Address <span class="required-star">*</span></label>
                                <input type="email" class="form-control" id="email" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->email) : ''; ?>" placeholder="e.g. kamal@company.lk" oninput="syncPreview()">
                                <div class="validation-msg" id="email-msg"></div>
                            </div>
                            <div>
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->address) : ''; ?>" placeholder="Street, City">
                            </div>
                        </div>

                        <div class="sdiv"><span>Employment</span></div>
                        <div class="form-grid-4 mb-14">
                            <div>
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" id="emp-id-input" readonly>
                            </div>
                            <!--<div>
                                <label class="form-label">Department <span class="required-star">*</span></label>
                                <select class="form-control form-select" id="department" onchange="syncPreview()">
                                    <option value="">— Select —</option>
                                    <option <?php //echo ($edit_mode && $staff_data->branch_location == 'Head Office — Colombo') ? 'selected' : ''; ?>>Head Office — Colombo</option>
                                    <option <?php //echo ($edit_mode && $staff_data->branch_location == 'North Branch — Jaffna') ? 'selected' : ''; ?>>North Branch — Jaffna</option>
                                    <option <?php //echo ($edit_mode && $staff_data->branch_location == 'Kandy Outlet') ? 'selected' : ''; ?>>Kandy Outlet</option>
                                    <option <?php //echo ($edit_mode && $staff_data->branch_location == 'Galle Branch') ? 'selected' : ''; ?>>Galle Branch</option>
                                </select>
                            </div>-->
							 <div>
                                <label class="form-label">Branch <span class="required-star">*</span></label>
                                <select class="form-control form-select" id="branch" onchange="syncPreview()">
                                    <option value="">— Select Branch —</option>-
                                    <?php foreach($branch as $row): ?>
                                    <option value="<?php echo $row->branch_id; ?>" <?php echo ($edit_mode && $staff_data->branch_id == $row->branch_id) ? 'selected' : ''; ?>><?php echo $row->branch_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Designation <span class="required-star">*</span></label>
                                <select class="form-control form-select" id="designation" onchange="syncPreview()">
                                    <option value="">— Select Designation —</option>
                                    <?php foreach($designation as $row): ?>
                                    <option value="<?php echo $row->ut_id; ?>" <?php echo ($edit_mode && $staff_data->ut_id == $row->ut_id) ? 'selected' : ''; ?>><?php echo $row->ut_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Joining Date <span class="required-star">*</span></label>
                                <input type="date" class="form-control" id="joining-date" value="<?php echo ($edit_mode && $staff_data->joining_date) ? $staff_data->joining_date : ''; ?>">
                            </div>
                            <div>
                                <label class="form-label">Emergency Contact</label>
                                <input type="tel" class="form-control" id="emergency-contact" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->emergency_contact) : ''; ?>" placeholder="0771234567">
                            </div>
                            <div>
                                <label class="form-label">Status</label>
                                <select class="form-control form-select" id="staff-status" onchange="syncPreview()">
                                    <option value="active" <?php echo ($edit_mode && $staff_data->status == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($edit_mode && $staff_data->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    <option value="on_leave" <?php echo ($edit_mode && $staff_data->status == 'on_leave') ? 'selected' : ''; ?>>On Leave</option>
                                </select>
                            </div>
                        </div>

                        <div class="sdiv"><span>Bank Details</span></div>
                        <div class="form-grid-4 mb-14">
                            <div>
                                <label class="form-label">Bank Name <span class="required-star">*</span></label>
                                <select class="form-control form-select" id="bank_id" required>
                                    <option value="">— Select Bank —</option>
                                    <?php foreach($bank as $row): ?>
                                    <option value="<?php echo $row->bank_id; ?>" <?php echo ($edit_mode && $staff_data->bank_id == $row->bank_id) ? 'selected' : ''; ?>><?php echo $row->bank_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Branch Name <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="bank_branch" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->bank_branch) : ''; ?>" placeholder="e.g. Colombo Main" required>
                            </div>
                            <div>
                                <label class="form-label">Account Number <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="account_number" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->account_no) : ''; ?>" placeholder="e.g. 1234567890" required>
                            </div>
                            <div>
                                <label class="form-label">Account Name <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="account_holder" value="<?php echo $edit_mode ? htmlspecialchars($staff_data->account_name) : ''; ?>" placeholder="e.g. John Doe" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- USER ACCOUNT TOGGLE SECTION -->
                <div class="toggle-section" id="user-account-section">
                    <div class="toggle-header" onclick="toggleSection('user-account-section','user-account-toggle')">
                        <div class="toggle-icon-wrap ti-blue"><i class="fa-solid fa-lock-open"></i></div>
                        <div>
                            <div class="toggle-title">User Login Account</div>
                            <div class="toggle-subtitle">Allow this staff member to log into the system</div>
                        </div>
                        <div class="toggle-switch-wrap">
                            <span class="toggle-label-text" id="user-toggle-label">Disabled</span>
                            <label class="toggle-switch" onclick="event.stopPropagation()">
                                <input type="checkbox" id="user-account-toggle" onchange="onUserAccountToggle(this)">
                                <span class="toggle-slider"></span>
                            </label>
                            <i class="fa-solid fa-chevron-down toggle-chevron"></i>
                        </div>
                    </div>
                    <div class="toggle-body" id="user-account-body">
                        <div class="form-grid-2 mb-14">
                            <div>
                                <label class="form-label">Login Username</label>
                                <input type="text" class="form-control" id="username" readonly placeholder="Auto-filled from Contact No. 1">
                            </div>
                            <div>
                                <label class="form-label">Account Status</label>
                                <div class="lock-toggle-row unlocked" id="lock-toggle-row">
                                    <div class="lock-label"><i class="fa-solid fa-unlock-keyhole"></i> <span id="lock-label-text">Account Active</span></div>
                                    <label class="toggle-switch" onclick="toggleLock()">
                                        <input type="checkbox" id="account-locked">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <span class="form-label">User Role <span class="required-star">*</span></span>
                        <div class="role-grid" id="role-grid">
                            <div class="role-card" onclick="selectRole(this,'admin')"><i class="fa-solid fa-crown"></i><span>Admin</span></div>
                            <div class="role-card" onclick="selectRole(this,'manager')"><i class="fa-solid fa-user-tie"></i><span>Manager</span></div>
                            <div class="role-card selected" onclick="selectRole(this,'staff')"><i class="fa-solid fa-user"></i><span>Staff</span></div>
                            <div class="role-card" onclick="selectRole(this,'cashier')"><i class="fa-solid fa-cash-register"></i><span>Cashier</span></div>
                            <div class="role-card" onclick="selectRole(this,'warehouse')"><i class="fa-solid fa-warehouse"></i><span>Warehouse</span></div>
                            <div class="role-card" onclick="selectRole(this,'accountant')"><i class="fa-solid fa-calculator"></i><span>Accountant</span></div>
                            <div class="role-card" onclick="selectRole(this,'viewer')"><i class="fa-solid fa-eye"></i><span>Viewer</span></div>
                            <div class="role-card" onclick="selectRole(this,'custom')"><i class="fa-solid fa-sliders"></i><span>Custom</span></div>
                        </div>
                        <input type="hidden" id="selected-role" value="staff">

                        <span class="form-label" style="margin-top:14px;">Auto-Generated Password</span>
                        <div class="pwd-gen-box">
                            <div class="pwd-display" id="generated-password">••••••••••</div>
                            <button class="btn-regen" onclick="generatePassword()"><i class="fa-solid fa-arrows-rotate"></i> Regenerate</button>
                            <button class="btn-regen" onclick="toggleShowPassword()" id="toggle-pwd-btn"><i class="fa-solid fa-eye"></i> Show</button>
                        </div>

                        <span class="form-label" style="margin-top:14px;">Send Credentials Via <span class="required-star">*</span></span>
                        <div class="send-via-grid">
                            <button class="send-via-btn selected" id="send-sms-btn" onclick="selectSendVia('sms')">
                                <i class="fa-solid fa-mobile-screen-button"></i><span>SMS (Recommended)</span>
                            </button>
                           
                        </div>
                        <input type="hidden" id="send-via" value="sms">
                    </div>
                </div>

                <!-- SALARY TOGGLE SECTION -->
                <div class="toggle-section" id="salary-section">
                    <div class="toggle-header" onclick="toggleSection('salary-section','salary-toggle')">
                        <div class="toggle-icon-wrap ti-green"><i class="fa-solid fa-sack-dollar"></i></div>
                        <div>
                            <div class="toggle-title">Salary & Payroll Structure</div>
                            <div class="toggle-subtitle">Configure compensation, allowances & deductions</div>
                        </div>
                        <div class="toggle-switch-wrap">
                            <span class="toggle-label-text" id="salary-toggle-label">Disabled</span>
                            <label class="toggle-switch" onclick="event.stopPropagation()">
                                <input type="checkbox" id="salary-toggle" onchange="onSalaryToggle(this)">
                                <span class="toggle-slider"></span>
                            </label>
                            <i class="fa-solid fa-chevron-down toggle-chevron"></i>
                        </div>
                    </div>
                    <div class="toggle-body" id="salary-body">
                        <div class="form-grid-3 mb-14">
                            <div>
                                <label class="form-label">Employment Type</label>
                                <select class="form-control form-select" id="emp-type" onchange="syncPreview()">
                                    <option value="permanent">Permanent</option>
                                    <option value="full_time">Full-Time</option>
                                    <option value="contract">Contract</option>
                                    <option value="part_time">Part-Time</option>
                                    <option value="intern">Intern</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Basic Salary (LKR) <span class="required-star">*</span></label>
                                <input type="number" class="form-control" id="basic-salary" placeholder="0.00" step="0.01" oninput="calcNetSalary()">
                            </div>
                            <div>
                                <label class="form-label">Pay Frequency</label>
                                <select class="form-control form-select" id="pay-frequency">
                                    <option>Monthly</option>
                                    <option>Bi-Weekly</option>
                                    <option>Weekly</option>
                                </select>
                            </div>
                        </div>

                        <div class="sdiv"><span>Fixed Allowances</span></div>
                        <div id="allowances-list"></div>
                        <button class="btn-add-repeater" onclick="addAllowance()"><i class="fa-solid fa-plus"></i> Add Allowance</button>

                        <div class="sdiv"><span>Fixed Deductions</span></div>
                        <div id="deductions-list"></div>
                        <button class="btn-add-repeater danger" onclick="addDeduction()"><i class="fa-solid fa-minus"></i> Add Deduction</button>

                        <div class="sdiv"><span>EPF / ETF</span></div>
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                            <label class="toggle-switch">
                                <input type="checkbox" id="epf-toggle" onchange="onEpfToggle(this)">
                                <span class="toggle-slider"></span>
                            </label>
                            <span style="font-size:13px;font-weight:700;">Enable EPF / ETF Contributions</span>
                        </div>
                        <div id="epf-panel" style="display:none;">
                            <div class="epf-grid mb-14">
                                <div>
                                    <label class="form-label">EPF — Employee</label>
                                    <input type="number" class="form-control" id="epf-employee" value="8" step="0.5" oninput="calcNetSalary()">
                                </div>
                                <div>
                                    <label class="form-label">EPF — Employer</label>
                                    <input type="number" class="form-control" id="epf-employer" value="12" step="0.5" oninput="calcNetSalary()">
                                </div>
                                <div>
                                    <label class="form-label">ETF — Employer</label>
                                    <input type="number" class="form-control" id="etf" value="3" step="0.5" oninput="calcNetSalary()">
                                </div>
                            </div>
                        </div>

                        <div class="net-salary-display" id="net-salary-display">
                            <div class="net-row"><span class="nl">Basic Salary</span><span class="nv" id="ns-basic">LKR 0.00</span></div>
                            <div class="net-row"><span class="nl">Total Allowances</span><span class="nv" id="ns-allow">+ LKR 0.00</span></div>
                            <div class="net-row"><span class="nl">Total Deductions</span><span class="nv" id="ns-deduct" style="color:#fca5a5;">- LKR 0.00</span></div>
                            <div class="net-row" id="ns-epf-row" style="display:none;"><span class="nl">EPF (Employee)</span><span class="nv" id="ns-epf" style="color:#fca5a5;">- LKR 0.00</span></div>
                            <div class="net-divider"></div>
                            <div class="net-total-row"><span class="nl">Net Take-Home</span><span class="nv" id="ns-net">LKR 0.00</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="right-col">
                <div class="card">
                    <div class="card-header">
                        <div class="section-icon si-blue"><i class="fa-solid fa-id-card"></i></div>
                        <h6>Staff Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="staff-preview-card">
                            <div class="preview-avatar" id="preview-avatar">
                                <img id="preview-avatar-img" src="" alt="">
                                <span id="preview-initials">?</span>
                            </div>
                            <div class="preview-name" id="preview-name">—</div>
                            <div class="preview-calling" id="preview-calling">—</div>
                            <div class="preview-tags" id="preview-tags">
                                <span class="preview-tag pt-status">New</span>
                            </div>
                        </div>
                        <div class="preview-meta">
                            <div class="preview-meta-row"><span class="pm-label">ID</span><span class="pm-value" id="pm-id">—</span></div>
                            <div class="preview-meta-row"><span class="pm-label">Email</span><span class="pm-value" id="pm-email" style="font-family:inherit;">—</span></div>
                            <div class="preview-meta-row"><span class="pm-label">Phone</span><span class="pm-value" id="pm-phone">—</span></div>
                            <div class="preview-meta-row"><span class="pm-label">Dept</span><span class="pm-value" id="pm-dept">—</span></div>
                            <div class="preview-meta-row"><span class="pm-label">Status</span><span class="pm-value" id="pm-status">—</span></div>
                            <div class="preview-meta-row" id="pm-salary-row" style="display:none;"><span class="pm-label">Net Salary</span><span class="pm-value" id="pm-salary">—</span></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="section-icon si-green"><i class="fa-solid fa-shield-halved"></i></div>
                        <h6>Validation Checklist</h6>
                    </div>
                    <div class="card-body" style="padding:14px 18px;">
                        <div id="checklist">
                            <div class="checklist-item" id="chk-name"><div class="check-icon"><i class="fa-regular fa-circle"></i></div><span>Full name entered</span></div>
                            <div class="checklist-item" id="chk-phone"><div class="check-icon"><i class="fa-regular fa-circle"></i></div><span>Valid contact number</span></div>
                            <div class="checklist-item" id="chk-email"><div class="check-icon"><i class="fa-regular fa-circle"></i></div><span>Valid email address</span></div>
                            <!--<div class="checklist-item" id="chk-dept"><div class="check-icon"><i class="fa-regular fa-circle"></i></div><span>Department selected</span></div>-->
                            <div class="checklist-item" id="chk-desig"><div class="check-icon"><i class="fa-regular fa-circle"></i></div><span>Designation selected</span></div>
                            <div class="checklist-item" id="chk-joining"><div class="check-icon"><i class="fa-regular fa-circle"></i></div><span>Joining date set</span></div>
                            <div class="checklist-item" id="chk-role" style="display:none;"><div class="check-icon check-ok"><i class="fa-solid fa-check"></i></div><span>User role selected</span></div>
                            <div class="checklist-item" id="chk-salary" style="display:none;"><div class="check-icon"><i class="fa-regular fa-circle"></i></div><span>Basic salary entered</span></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="section-icon si-orange"><i class="fa-solid fa-note-sticky"></i></div>
                        <h6>Internal Notes</h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" id="internal-notes" rows="3" placeholder="Notes about this staff member (internal use only)…"><?php echo $edit_mode ? htmlspecialchars($staff_data->internal_notes) : ''; ?></textarea>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="section-icon si-purple"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <h6>Audit Information</h6>
                    </div>
                    <div class="card-body" style="padding:14px 18px;">
                        <div class="preview-meta">
                            <div class="preview-meta-row"><span class="pm-label">Created By</span><span class="pm-value">Admin User</span></div>
                            <div class="preview-meta-row"><span class="pm-label">Created On</span><span class="pm-value" id="audit-date"></span></div>
                            <div class="preview-meta-row"><span class="pm-label">System</span><span class="pm-value">Rixzo ERP v2.6</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ACTION BAR -->
        <!-- ACTION BAR -->
<div class="action-bar">
    <div class="action-bar-left">
        <button class="btn btn-secondary" onclick="resetForm()"><i class="fa-solid fa-rotate-left"></i> Reset</button>
        <button class="btn btn-secondary" onclick="saveAsDraft()"><i class="fa-regular fa-floppy-disk"></i> Save Draft</button>
    </div>
    <div class="action-bar-right">
        <button class="btn btn-primary" onclick="submitForm()"><i class="fa-solid <?php echo $edit_mode ? 'fa-pen' : 'fa-user-plus'; ?>"></i> <?php echo $edit_mode ? 'Update Staff Member' : 'Create Staff Member'; ?></button>
    </div>
</div>
        </div>
    </div>
</div>

<!-- MODALS & TOAST -->
<div class="modal-overlay" id="success-modal">
    <div class="modal-card">
        <div class="modal-icon"><i class="fa-solid fa-user-check"></i></div>
        <h3>Staff Member Created!</h3>
        <p>The staff record has been saved successfully.</p>
        <div class="modal-info">
            <div class="modal-info-row"><span class="mi-label">Employee ID</span><span class="mi-value" id="modal-emp-id"></span></div>
            <div class="modal-info-row"><span class="mi-label">Name</span><span class="mi-value" id="modal-name"></span></div>
            <div class="modal-info-row" id="modal-user-row"><span class="mi-label">Username</span><span class="mi-value" id="modal-username"></span></div>
            <div class="modal-info-row" id="modal-pwd-row"><span class="mi-label">Password Sent Via</span><span class="mi-value" id="modal-send-via"></span></div>
        </div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeModal()"><i class="fa-solid fa-plus"></i> Add Another</button>
            <button class="btn btn-primary" onclick="viewStaff()"><i class="fa-solid fa-eye"></i> View Profile</button>
        </div>
    </div>
</div>
<div id="toast-container"></div>

<script>
// State variables
var allowanceCount = 0, deductionCount = 0;
var generatedPwd = '', pwdVisible = false;
var selectedRole = 'staff', sendVia = 'sms';

// Toggle sections
function toggleSection(sectionId, inputId) {
    var section = $('#' + sectionId);
    var toggle = $('#' + inputId);
    if (!section.hasClass('active')) {
        section.addClass('active');
        toggle.prop('checked', true).trigger('change');
    } else {
        section.removeClass('active');
        toggle.prop('checked', false).trigger('change');
    }
}

function onUserAccountToggle(cb) {
    var isOn = $(cb).is(':checked');
    if (isOn) $('#user-account-section').addClass('active');
    else $('#user-account-section').removeClass('active');
    $('#user-toggle-label').text(isOn ? 'Enabled' : 'Disabled');
    if (isOn) { syncPhone1(); $('#chk-role').show(); } 
    else { $('#chk-role').hide(); }
    syncPreview();
}

function onSalaryToggle(cb) {
    var isOn = $(cb).is(':checked');
    if (isOn) $('#salary-section').addClass('active');
    else $('#salary-section').removeClass('active');
    $('#salary-toggle-label').text(isOn ? 'Enabled' : 'Disabled');
    if (isOn) { $('#chk-salary').show(); calcNetSalary(); $('#pm-salary-row').show(); }
    else { $('#chk-salary').hide(); $('#pm-salary-row').hide(); }
}

function onEpfToggle(cb) {
    $('#epf-panel').toggle($(cb).is(':checked'));
    $('#ns-epf-row').toggle($(cb).is(':checked'));
    calcNetSalary();
}

function syncPhone1() {
    var phone = $('#phone1').val().trim();
    $('#username').val(phone || '');
}

function selectRole(el, role) {
    $('.role-card').removeClass('selected');
    $(el).addClass('selected');
    selectedRole = role;
    $('#selected-role').val(role);
    syncPreview();
}

function toggleLock() {
    var isLocked = $('#account-locked').is(':checked');
    var row = $('#lock-toggle-row');
    row.toggleClass('locked', isLocked).toggleClass('unlocked', !isLocked);
    $('#lock-label-text').text(isLocked ? 'Account Locked' : 'Account Active');
}

function generatePassword() {
    var chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789@#!';
    var pwd = '';
    for (var i = 0; i < 10; i++) pwd += chars[Math.floor(Math.random() * chars.length)];
    generatedPwd = pwd;
    $('#generated-password').text(pwdVisible ? pwd : '••••••••••');
}

function toggleShowPassword() {
    pwdVisible = !pwdVisible;
    $('#generated-password').text(pwdVisible ? generatedPwd : '••••••••••');
    $('#toggle-pwd-btn').html(pwdVisible ? '<i class="fa-solid fa-eye-slash"></i> Hide' : '<i class="fa-solid fa-eye"></i> Show');
}

function selectSendVia(method) {
    sendVia = method;
    $('#send-via').val(method);
    $('#send-sms-btn, #send-email-btn').removeClass('selected');
    if (method === 'sms') $('#send-sms-btn').addClass('selected');
    else $('#send-email-btn').addClass('selected');
}

function addAllowance() {
    allowanceCount++;
    var id = allowanceCount;
    var html = `<div class="repeater-item" id="allow-${id}">
        <input type="text" class="form-control" placeholder="e.g. Transport Allowance" oninput="calcNetSalary()">
        <input type="number" class="form-control" placeholder="0.00" step="0.01" oninput="calcNetSalary()">
        <button class="btn-remove-repeater" onclick="removeRepeater('allow-${id}')"><i class="fa-solid fa-xmark"></i></button>
    </div>`;
    $('#allowances-list').append(html);
    calcNetSalary();
}

function addDeduction() {
    deductionCount++;
    var id = deductionCount;
    var html = `<div class="repeater-item" id="deduct-${id}">
        <input type="text" class="form-control" placeholder="e.g. Loan Deduction" oninput="calcNetSalary()">
        <input type="number" class="form-control" placeholder="0.00" step="0.01" oninput="calcNetSalary()">
        <button class="btn-remove-repeater" onclick="removeRepeater('deduct-${id}')"><i class="fa-solid fa-xmark"></i></button>
    </div>`;
    $('#deductions-list').append(html);
    calcNetSalary();
}

function removeRepeater(id) { 
    $('#' + id).fadeOut(200, function() { $(this).remove(); calcNetSalary(); }); 
}

function calcNetSalary() {
    var basic = parseFloat($('#basic-salary').val()) || 0;
    var totalAllow = 0;
    $('#allowances-list .repeater-item').each(function() {
        totalAllow += parseFloat($(this).find('input[type=number]').eq(0).val()) || 0;
    });
    var totalDeduct = 0;
    $('#deductions-list .repeater-item').each(function() {
        totalDeduct += parseFloat($(this).find('input[type=number]').eq(0).val()) || 0;
    });
    var gross = basic + totalAllow - totalDeduct;
    var epfEmpDeduct = 0;
    if ($('#epf-toggle').is(':checked')) {
        var epfPct = parseFloat($('#epf-employee').val()) || 8;
        epfEmpDeduct = basic * (epfPct / 100);
        $('#ns-epf').text('- LKR ' + fmtNum(epfEmpDeduct));
    }
    var net = gross - epfEmpDeduct;
    $('#ns-basic').text('LKR ' + fmtNum(basic));
    $('#ns-allow').text('+ LKR ' + fmtNum(totalAllow));
    $('#ns-deduct').text('- LKR ' + fmtNum(totalDeduct));
    $('#ns-net').text('LKR ' + fmtNum(net));
    $('#pm-salary').text('LKR ' + fmtNum(net));
}

function calcAge() {
    var dob = new Date($('#dob').val());
    if (!$('#dob').val()) { $('#age-display').text(''); return; }
    var today = new Date();
    var age = today.getFullYear() - dob.getFullYear();
    var m = today.getMonth() - dob.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
    if (age > 0 && age < 100) $('#age-display').text(age + ' years old');
    else $('#age-display').text('');
}

function handleAvatarUpload(input) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];
    if (file.size > 2 * 1024 * 1024) { toast('Image too large. Max 2MB.', 'warning'); return; }
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#avatar-img').attr('src', e.target.result).show();
        $('#avatar-placeholder').hide();
        $('#preview-avatar-img').attr('src', e.target.result).show();
        $('#preview-initials').hide();
        $('#banner-img').attr('src', e.target.result).show();
        $('#banner-initials').hide();
        toast('Photo uploaded', 'success');
    };
    reader.readAsDataURL(file);
}

function syncPreview() {
    var fn = $('#full-name').val().trim() || '—';
    var cn = $('#calling-name').val().trim() || '—';
    var email = $('#email').val().trim() || '—';
    var phone = $('#phone1').val().trim() || '—';
    //var dept = $('#department').val() || '—';
    var desig = $('#designation option:selected').text() || '—';
    var status = $('#staff-status').val() || 'active';
    var empType = $('#emp-type').find('option:selected').text() || '—';
    var staffNo = $('#emp-id-input').val();
    
    $('#preview-name').text(fn);
    $('#preview-calling').text(cn !== '—' ? '"' + cn + '"' + (desig !== '—' ? ' · ' + desig : '') : '—');
    $('#pm-email').text(email);
    $('#pm-phone').text(phone);
    //$('#pm-dept').text(dept);
    $('#pm-status').text(status.charAt(0).toUpperCase() + status.slice(1));
    $('#pm-id').text(staffNo);
    $('#banner-name').text(fn !== '—' ? fn : 'New Staff Member');
    $('#banner-emp-id').text(staffNo);
    //$('#banner-sub').text(desig !== '—' ? desig + ' · ' + dept : 'Complete the form below');
	$('#emp-id-display').text(staffNo);
    
    var initials = fn !== '—' ? fn.split(' ').map(function(w) { return w[0]; }).join('').substr(0, 2).toUpperCase() : '?';
    if (!$('#preview-avatar-img').is(':visible')) $('#preview-initials').text(initials);
    if (!$('#banner-img').is(':visible')) $('#banner-initials').text(initials);
    
    var tags = '';
   // if (dept !== '—') tags += `<span class="preview-tag pt-dept">${dept}</span>`;
    if ($('#user-account-toggle').is(':checked') && selectedRole) tags += `<span class="preview-tag pt-role">${selectedRole}</span>`;
    if ($('#salary-toggle').is(':checked')) tags += `<span class="preview-tag pt-type">${empType}</span>`;
    tags += `<span class="preview-tag pt-status">${status}</span>`;
    $('#preview-tags').html(tags);
}

function generateStaffNo() {
    $.ajax({
        url: '<?php echo base_url("staff/generateStaffNo"); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                var staffNo = response.data.staff_no;
                $('#emp-id-input').val(staffNo);
                $('#pm-id').text(staffNo);
                $('#banner-emp-id').text(staffNo);
				$('#emp-id-display').text(staffNo);
            }
        },
        error: function() {
            var year = new Date().getFullYear();
            var fallbackId = 'STF-' + year + '-0001';
            $('#emp-id-input').val(fallbackId);
            $('#pm-id').text(fallbackId);
            $('#banner-emp-id').text(fallbackId);
        }
    });
}

function runChecklist() {
    $('#chk-name .check-icon').html($('#full-name').val().trim().length >= 3 ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-regular fa-circle"></i>');
    $('#chk-phone .check-icon').html(/^0[1-9][0-9]{8}$/.test($('#phone1').val().trim()) ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-regular fa-circle"></i>');
    $('#chk-email .check-icon').html(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($('#email').val().trim()) ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-regular fa-circle"></i>');
    //$('#chk-dept .check-icon').html($('#department').val() !== '' ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-regular fa-circle"></i>');
    $('#chk-desig .check-icon').html($('#designation').val() !== '' ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-regular fa-circle"></i>');
    $('#chk-joining .check-icon').html($('#joining-date').val() !== '' ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-regular fa-circle"></i>');
    if ($('#salary-toggle').is(':checked')) {
        $('#chk-salary .check-icon').html((parseFloat($('#basic-salary').val()) || 0) > 0 ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-regular fa-circle"></i>');
    }
}

function allChecksPassed() {
    if ($('#full-name').val().trim().length < 3) return false;
    if (!/^0[1-9][0-9]{8}$/.test($('#phone1').val().trim())) return false;
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($('#email').val().trim())) return false;
    //if (!$('#department').val()) return false;
    if (!$('#designation').val()) return false;
    if (!$('#joining-date').val()) return false;
    return true;
}

function submitForm() {
    if (!allChecksPassed()) { toast('Please fill all required fields correctly', 'warning'); return; }
    if ($('#calling-name').val().trim() === '') { toast('Please enter a calling name', 'warning'); return; }
    var hasAccount = $('#user-account-toggle').is(':checked');
    if (hasAccount && !selectedRole) { toast('Please select a user role', 'warning'); return; }
    
    var allowances = [];
    $('#allowances-list .repeater-item').each(function() {
        var name = $(this).find('input[type=text]').val();
        var amount = $(this).find('input[type=number]').eq(0).val();
        if (name && amount) allowances.push({ name: name, amount: amount });
    });
    var deductions = [];
    $('#deductions-list .repeater-item').each(function() {
        var name = $(this).find('input[type=text]').val();
        var amount = $(this).find('input[type=number]').eq(0).val();
        if (name && amount) deductions.push({ name: name, amount: amount });
    });
    
    var formData = new FormData();
    formData.append('full_name', $('#full-name').val().trim());
    formData.append('calling_name', $('#calling-name').val().trim());
    formData.append('gender', $('#gender').val());
    formData.append('dob', $('#dob').val());
    formData.append('nic', $('#nic').val().trim());
    formData.append('blood_group', $('#blood-group').val());
    formData.append('phone1', $('#phone1').val().trim());
    formData.append('phone2', $('#phone2').val().trim());
    formData.append('email', $('#email').val().trim());
    formData.append('ut_id', $('#designation').val());
    formData.append('branch_id', $('#branch').val());
    formData.append('designation_text', $('#designation option:selected').text());
    formData.append('address', $('#address').val().trim());
    //formData.append('department', $('#department').val());
    formData.append('joining_date', $('#joining-date').val());
    formData.append('emergency_contact', $('#emergency-contact').val().trim());
    formData.append('status', $('#staff-status').val());
    formData.append('emp_type', $('#emp-type').val());
    formData.append('basic_salary', $('#basic-salary').val());
    formData.append('pay_frequency', $('#pay-frequency').val());
    formData.append('internal_notes', $('#internal-notes').val().trim());
    formData.append('allowances', JSON.stringify(allowances));
    formData.append('deductions', JSON.stringify(deductions));
    formData.append('epf_enabled', $('#epf-toggle').is(':checked') ? '1' : '0');
    formData.append('epf_employee_pct', $('#epf-employee').val());
    formData.append('epf_employer_pct', $('#epf-employer').val());
    formData.append('etf_employer_pct', $('#etf').val());
    formData.append('create_account', hasAccount ? '1' : '0');
    formData.append('user_role', selectedRole);
    formData.append('generated_password', generatedPwd);
    formData.append('account_locked', $('#account-locked').is(':checked') ? '1' : '0');
    formData.append('send_via', sendVia);
    formData.append('bank_id', $('#bank_id').val());
    formData.append('bank_branch', $('#bank_branch').val().trim());
    formData.append('account_number', $('#account_number').val().trim());
    formData.append('account_holder', $('#account_holder').val().trim());
    formData.append('lid', $('#staff_id').val());
    
    var fileInput = $('#avatar-file-input')[0];
    if (fileInput && fileInput.files.length > 0) formData.append('profile_photo', fileInput.files[0]);
    
    $.ajax({
        url: '<?php echo site_url("Staff/store"); ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.stt === 'ok') {
                $('#modal-emp-id').text(response.data.staff_no);
                $('#modal-name').text($('#full-name').val().trim());
                if (hasAccount) {
                    $('#modal-user-row, #modal-pwd-row').show();
                    $('#modal-username').text($('#phone1').val());
                    $('#modal-send-via').text(sendVia === 'sms' ? 'SMS sent to ' + $('#phone1').val() : 'Email sent to ' + $('#email').val());
                } else {
                    $('#modal-user-row, #modal-pwd-row').hide();
                }
                $('#success-modal').css('display', 'flex');
                toast(response.msg, 'success');
            } else {
                toast(response.msg, 'danger');
            }
        },
        error: function() { toast('Server error occurred', 'danger'); }
    });
}
function saveAsDraft() {
    // Set status to draft
    $('#staff-status').val('draft');
    
    // Validate basic required fields for draft (optional - you can make it less strict)
    if ($('#full-name').val().trim() === '') { 
        toast('Full name is required even for draft', 'warning'); 
        $('#staff-status').val('active');
        return; 
    }
    
    var allowances = [];
    $('#allowances-list .repeater-item').each(function() {
        var name = $(this).find('input[type=text]').val();
        var amount = $(this).find('input[type=number]').eq(0).val();
        if (name && amount) allowances.push({ name: name, amount: amount });
    });
    var deductions = [];
    $('#deductions-list .repeater-item').each(function() {
        var name = $(this).find('input[type=text]').val();
        var amount = $(this).find('input[type=number]').eq(0).val();
        if (name && amount) deductions.push({ name: name, amount: amount });
    });
    
    var formData = new FormData();
    formData.append('full_name', $('#full-name').val().trim());
    formData.append('calling_name', $('#calling-name').val().trim());
    formData.append('gender', $('#gender').val());
    formData.append('dob', $('#dob').val());
    formData.append('nic', $('#nic').val().trim());
    formData.append('blood_group', $('#blood-group').val());
    formData.append('phone1', $('#phone1').val().trim());
    formData.append('phone2', $('#phone2').val().trim());
    formData.append('email', $('#email').val().trim());
    formData.append('ut_id', $('#designation').val());
    formData.append('designation_text', $('#designation option:selected').text());
    formData.append('address', $('#address').val().trim());
    //formData.append('department', $('#department').val());
    formData.append('joining_date', $('#joining-date').val());
    formData.append('emergency_contact', $('#emergency-contact').val().trim());
    formData.append('status', 'draft');
    formData.append('emp_type', $('#emp-type').val());
    formData.append('basic_salary', $('#basic-salary').val());
    formData.append('pay_frequency', $('#pay-frequency').val());
    formData.append('internal_notes', $('#internal-notes').val().trim());
    formData.append('allowances', JSON.stringify(allowances));
    formData.append('deductions', JSON.stringify(deductions));
    formData.append('epf_enabled', $('#epf-toggle').is(':checked') ? '1' : '0');
    formData.append('epf_employee_pct', $('#epf-employee').val());
    formData.append('epf_employer_pct', $('#epf-employer').val());
    formData.append('etf_employer_pct', $('#etf').val());
    formData.append('create_account', '0');
    formData.append('user_role', selectedRole);
    formData.append('generated_password', generatedPwd);
    formData.append('account_locked', '0');
    formData.append('send_via', 'sms');
    formData.append('bank_id', $('#bank_id').val());
    formData.append('bank_branch', $('#bank_branch').val().trim());
    formData.append('account_number', $('#account_number').val().trim());
    formData.append('account_holder', $('#account_holder').val().trim());
    formData.append('lid', $('#staff_id').val());
    formData.append('is_draft', '1');
    
    var fileInput = $('#avatar-file-input')[0];
    if (fileInput && fileInput.files.length > 0) formData.append('profile_photo', fileInput.files[0]);
    
    $.ajax({
        url: '<?php echo site_url("Staff/store"); ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.stt === 'ok') {
                $('#staff_id').val(response.data.staff_id);
                toast('Draft saved successfully!', 'success');
            } else {
                toast(response.msg, 'danger');
            }
        },
        error: function() { toast('Server error occurred', 'danger'); }
    });
}

function resetForm() {
    $('input[type=text], input[type=email], input[type=tel], input[type=number], textarea').val('');
    $('select').prop('selectedIndex', 0);
    $('#allowances-list, #deductions-list').empty();
    allowanceCount = 0; deductionCount = 0;
    $('#user-account-section, #salary-section').removeClass('active');
    $('#user-account-toggle, #salary-toggle, #epf-toggle, #account-locked').prop('checked', false);
    $('#epf-panel').hide(); $('#ns-epf-row').hide();
    $('#user-toggle-label').text('Disabled'); $('#salary-toggle-label').text('Disabled');
    $('#lock-toggle-row').addClass('unlocked').removeClass('locked');
    $('#lock-label-text').text('Account Active');
    selectedRole = 'staff';
    $('.role-card').removeClass('selected'); $('.role-card:nth-child(3)').addClass('selected');
    $('#avatar-img').hide(); $('#avatar-placeholder').show();
    $('#preview-avatar-img').hide(); $('#preview-initials').text('?').show();
    $('#banner-img').hide(); $('#banner-initials').text('?').show();
    $('#joining-date').val(new Date().toISOString().split('T')[0]);
    $('#chk-role, #chk-salary').hide();
    $('#pm-salary-row').hide();
    generateStaffNo();
    generatePassword();
    calcNetSalary();
    syncPreview();
    toast('Form has been reset', 'info');
}

function closeModal() { $('#success-modal').css('display', 'none'); resetForm(); }
function viewStaff() { $('#success-modal').css('display', 'none'); toast('Navigating to staff profile…', 'info'); }
function fmtNum(n) { return Number(n).toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
function toast(msg, type) {
    type = type || 'info';
    var iconMap = { success: 'fa-check-circle', warning: 'fa-triangle-exclamation', danger: 'fa-circle-xmark', info: 'fa-circle-info' };
    var $t = $('<div class="toast-item toast-' + type + '"><i class="fa-solid ' + iconMap[type] + '"></i>' + msg + '</div>');
    $('#toast-container').append($t);
    setTimeout(function() {
        $t.css({ 'opacity': '0', 'transform': 'translateX(20px)', 'transition': 'all .3s' });
        setTimeout(function() { $t.remove(); }, 300);
    }, 3500);
}

// Listen for sidebar toggle events
$(document).on('click', '.sidebar-toggle', function() {
    $('body').toggleClass('sidebar-mini');
    $('.main-content').toggleClass('sidebar-collapsed');
});  

// Document ready
$(document).ready(function() {
    $('#audit-date').text(new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }));
    if (!$('#joining-date').val()) $('#joining-date').val(new Date().toISOString().split('T')[0]);
    <?php if(!$edit_mode): ?> generateStaffNo(); <?php else: ?> 
    $('#emp-id-input').val('<?php echo $staff_data->staff_no; ?>');
    $('#pm-id').text('<?php echo $staff_data->staff_no; ?>');
    $('#banner-emp-id').text('<?php echo $staff_data->staff_no; ?>');
    <?php endif; ?>
    generatePassword();
    syncPreview();
    runChecklist();
    //$('#full-name, #calling-name, #phone1, #email, #department, #designation, #joining-date, #basic-salary').on('input change', function() { runChecklist(); syncPreview(); });
    $('#full-name, #calling-name, #phone1, #email, #designation, #joining-date, #basic-salary').on('input change', function() { runChecklist(); syncPreview(); });
    $('#basic-salary').on('input', calcNetSalary);
});
</script>