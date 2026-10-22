<style>
    :root {
      --rx-bg:        #f4f5fb;
      --rx-sidebar:   #1e2139;
      --rx-accent:    #5b73e8;
      --rx-accent-h:  #4561d4;
      --rx-accent-lt: #eef0fb;
      --rx-text:      #2f3346;
      --rx-muted:     #8c97a8;
      --rx-border:    #e4e6ef;
      --rx-card:      #ffffff;
      --font:         'Plus Jakarta Sans', sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: var(--font);
      background: var(--rx-bg);
      color: var(--rx-text);
      min-height: 100vh;
      display: flex;
    }

    /* ════ SIDEBAR ════ */
    .sidebar {
      width: 230px;
      min-height: 100vh;
      background: var(--rx-sidebar);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }
    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 22px 20px 18px;
      border-bottom: 1px solid rgba(255,255,255,.06);
    }
    .brand-icon {
      width: 32px; height: 32px;
      background: var(--rx-accent);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
    }
    .brand-icon i { color: #fff; font-size: 17px; }
    .brand-name { font-size: 15px; font-weight: 700; color: #fff; letter-spacing: .01em; }

    .nav-section { padding: 14px 0 4px; }
    .nav-section-label {
      font-size: 10px; font-weight: 700;
      letter-spacing: .08em; text-transform: uppercase;
      color: rgba(255,255,255,.28);
      padding: 0 20px 6px;
    }
    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 9px 20px;
      font-size: 13px; font-weight: 500;
      color: rgba(255,255,255,.55);
      cursor: pointer;
      border-left: 3px solid transparent;
      text-decoration: none;
      transition: background .15s, color .15s;
    }
    .nav-item i { font-size: 17px; flex-shrink: 0; }
    .nav-item:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.85); }
    .nav-item.active {
      background: rgba(91,115,232,.18);
      color: #fff;
      border-left-color: var(--rx-accent);
    }
    .nav-item .badge-nav {
      margin-left: auto;
      font-size: 10px; font-weight: 700;
      background: var(--rx-accent); color: #fff;
      padding: 1px 7px; border-radius: 20px;
    }

    /* ════ MAIN ════ */
    .main-wrap { flex: 1; display: flex; flex-direction: column; min-width: 0; }

    .topbar {
      background: #fff;
      border-bottom: 1px solid var(--rx-border);
      padding: 0 28px;
      height: 58px;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 100;
    }
    .page-title-text { font-size: 15px; font-weight: 700; color: var(--rx-text); }
    .breadcrumb-rx {
      display: flex; align-items: center; gap: 5px;
      font-size: 12px; color: var(--rx-muted);
    }
    .breadcrumb-rx span { color: var(--rx-text); font-weight: 500; }
    .topbar-right { display: flex; align-items: center; gap: 8px; }
    .tb-icon-btn {
      width: 34px; height: 34px;
      border: 1px solid var(--rx-border); border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      background: transparent; color: var(--rx-muted);
      cursor: pointer; font-size: 17px;
      transition: background .15s, color .15s; position: relative;
    }
    .tb-icon-btn:hover { background: var(--rx-bg); color: var(--rx-text); }
    .tb-notif::after {
      content: ''; width: 7px; height: 7px;
      background: #e84646; border-radius: 50%;
      position: absolute; top: 6px; right: 7px;
      border: 1.5px solid #fff;
    }
    .tb-avatar {
      width: 34px; height: 34px; border-radius: 50%;
      background: var(--rx-accent-lt); color: var(--rx-accent);
      font-size: 12px; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      border: 1px solid var(--rx-border); cursor: pointer;
    }
    .tb-divider { width: 1px; height: 22px; background: var(--rx-border); margin: 0 2px; }

    .content { padding: 26px 28px 40px; flex: 1; }

    /* ════ CUSTOM CARD ════ */
    .card.custom-card {
      background: var(--rx-card);
      border: 1px solid var(--rx-border);
      border-radius: 14px;
      box-shadow: 0 1px 4px rgba(0,0,0,.04);
    }
    .card.custom-card .card-body { padding: 0; }

    .cp-card-header {
      display: flex; align-items: center; gap: 9px;
      padding: 16px 22px;
      border-bottom: 1px solid var(--rx-border);
    }
    .cp-card-header i { font-size: 18px; color: var(--rx-accent); }
    .cp-card-header .ch-title { font-size: 13.5px; font-weight: 700; color: var(--rx-text); }
    .cp-card-header .ch-sub { font-size: 11.5px; color: var(--rx-muted); margin-left: auto; }

    .cp-grid {
      display: grid;
      grid-template-columns: 1fr 320px;
    }
    .cp-form-col {
      padding: 24px 22px;
      border-right: 1px solid var(--rx-border);
    }
    .cp-preview-col {
      background: #fafbff;
      border-radius: 0 0 0 0;
    }

    /* ════ FORM ════ */
    .section-label {
      font-size: 10px; font-weight: 700;
      text-transform: uppercase; letter-spacing: .07em;
      color: var(--rx-muted);
      margin-bottom: 14px; padding-bottom: 8px;
      border-bottom: 1px solid var(--rx-border);
    }
    .form-group { margin-bottom: 14px; }
    .form-label {
      display: block;
      font-size: 12px; font-weight: 600;
      color: #5a6278; margin-bottom: 5px;
    }
    .form-label .req { color: #e84646; margin-left: 2px; }

    .form-control {
      width: 100%;
      border: 1px solid var(--rx-border);
      border-radius: 8px;
      padding: 9px 12px;
      font-size: 13px; font-family: var(--font);
      color: var(--rx-text); background: #fff;
      outline: none;
      transition: border-color .18s, box-shadow .18s;
    }
    .form-control::placeholder { color: #c2c8d8; }
    .form-control:focus {
      border-color: var(--rx-accent);
      box-shadow: 0 0 0 3.5px rgba(91,115,232,.12);
    }
    .form-control.with-icon { padding-left: 36px; }
    textarea.form-control { resize: vertical; min-height: 82px; line-height: 1.6; }

    .input-wrap { position: relative; }
    .input-wrap .fi {
      position: absolute; left: 11px; top: 50%;
      transform: translateY(-50%);
      font-size: 15px; color: #b0bac9; pointer-events: none;
    }
    .input-wrap.ta-wrap .fi { top: 11px; transform: none; }

    .phone-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

    /* upload zone */
    .cp-upload-zone {
      position: relative;
      border: 1.5px dashed #d0d4e8; border-radius: 10px;
      padding: 18px 14px; text-align: center;
      background: #f8f9fe; cursor: pointer;
      transition: border-color .18s, background .18s;
    }
    .cp-upload-zone:hover { border-color: var(--rx-accent); background: var(--rx-accent-lt); }
    .cp-upload-zone input[type="file"] {
      position: absolute; inset: 0;
      opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .upload-icon {
      width: 42px; height: 42px;
      background: #eef0fb; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 10px;
    }
    .upload-icon i { font-size: 20px; color: var(--rx-accent); }
    .upload-text { font-size: 12.5px; color: #5a6278; margin-bottom: 3px; }
    .upload-text b { color: var(--rx-accent); font-weight: 600; }
    .upload-hint { font-size: 11px; color: var(--rx-muted); }

    /* file strip */
    .cp-file-strip {
      display: none; align-items: center; gap: 10px;
      background: #f4f5fb; border: 1px solid #e0e3f0;
      border-radius: 8px; padding: 9px 12px; margin-top: 10px;
    }
    .cp-file-strip.show { display: flex; }
    .cp-file-strip img {
      width: 40px; height: 40px; object-fit: contain;
      border-radius: 7px; border: 1px solid var(--rx-border); background: #fff;
    }
    .fi-info { flex: 1; min-width: 0; }
    .fi-name { font-size: 12px; font-weight: 600; color: var(--rx-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .fi-size { font-size: 11px; color: var(--rx-muted); }
    .btn-strip-remove {
      background: none; border: none;
      color: #e84646; font-size: 16px;
      cursor: pointer; padding: 3px 5px;
      border-radius: 6px; line-height: 1;
      transition: background .15s;
    }
    .btn-strip-remove:hover { background: #fdeaea; }

    /* actions */
    .cp-actions {
      display: flex; gap: 8px;
      padding: 16px 22px;
      border-top: 1px solid var(--rx-border);
      background: #fafbff;
      border-radius: 0 0 14px 14px;
    }
    .btn-save {
      background: var(--rx-accent); color: #fff;
      border: none; padding: 9px 20px;
      border-radius: 8px; font-size: 13px; font-weight: 600;
      font-family: var(--font);
      display: flex; align-items: center; gap: 6px;
      cursor: pointer;
      transition: background .18s, transform .1s;
    }
    .btn-save:hover { background: var(--rx-accent-h); }
    .btn-save:active { transform: scale(.97); }
    .btn-discard {
      background: #fff; color: var(--rx-muted);
      border: 1px solid var(--rx-border);
      padding: 9px 18px; border-radius: 8px;
      font-size: 13px; font-family: var(--font);
      cursor: pointer;
      transition: background .15s, color .15s;
    }
    .btn-discard:hover { background: var(--rx-bg); color: var(--rx-text); }

    /* ════ PREVIEW ════ */
    .prev-sticky { position: sticky; top: 58px; }

    .prev-topbar {
      display: flex; align-items: center; gap: 6px;
      padding: 13px 18px;
      border-bottom: 1px solid var(--rx-border);
    }
    .prev-topbar i { font-size: 15px; color: var(--rx-muted); }
    .prev-topbar .lbl { font-size: 12px; font-weight: 600; color: var(--rx-muted); }
    .badge-live {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 10px; font-weight: 700;
      background: #e8f7ee; color: #1a8a4a;
      padding: 3px 9px; border-radius: 20px; margin-left: auto;
    }
    .badge-live::before {
      content: ''; width: 5px; height: 5px;
      border-radius: 50%; background: currentColor;
    }

    .prev-cover {
      height: 72px;
      background: linear-gradient(135deg, #dde2f8 0%, #c8d0f5 100%);
    }

    .prev-avatar-wrap {
      display: flex; justify-content: center;
      margin-top: -32px; margin-bottom: 8px;
    }
    .prev-avatar {
      width: 64px; height: 64px; border-radius: 50%;
      background: #fff;
      border: 3px solid #fff;
      box-shadow: 0 2px 12px rgba(0,0,0,.1);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; font-weight: 700; color: var(--rx-muted);
      overflow: hidden;
    }
    .prev-avatar img { width: 100%; height: 100%; object-fit: contain; }

    .prev-identity {
      text-align: center;
      padding: 0 18px 14px;
      border-bottom: 1px solid var(--rx-border);
    }
    .prev-cname { font-size: 15px; font-weight: 700; color: var(--rx-text); margin-bottom: 3px; }
    .prev-cemail { font-size: 12px; color: var(--rx-muted); }

    .prev-meta { padding: 6px 18px 18px; }
    .prev-row {
      display: flex; align-items: flex-start; gap: 10px;
      padding: 9px 0;
      border-bottom: 1px solid #f0f1f8;
    }
    .prev-row:last-child { border-bottom: none; }
    .prev-row-ic {
      width: 30px; height: 30px; border-radius: 8px;
      background: var(--rx-accent-lt);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .prev-row-ic i { font-size: 14px; color: var(--rx-accent); }
    .prev-lbl {
      font-size: 10px; font-weight: 600;
      text-transform: uppercase; letter-spacing: .05em;
      color: var(--rx-muted); margin-bottom: 2px;
    }
    .prev-val { font-size: 13px; color: var(--rx-text); word-break: break-word; }
    .prev-val.empty { color: #c2c8d8; font-style: italic; }

    /* ════ RESPONSIVE ════ */
    @media (max-width: 860px) {
      .sidebar { display: none; }
      .cp-grid { grid-template-columns: 1fr; }
      .cp-form-col { border-right: none; border-bottom: 1px solid var(--rx-border); }
    }
</style>


<!-- Start::app-content -->
<div class="main-content app-content">
	<div class="container-fluid">

		<!-- Page Header -->
		<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
			<h1 class="page-title fw-semibold fs-18 mb-0">System Settings</h1>
			<div class="ms-md-1 ms-0">
				<nav>
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
						<li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
					</ol>
				</nav>
			</div>
		</div>
		<!-- Page Header Close -->

		<!-- Start::row-1 -->
		<div class="row">
			<div class="col-xl-12">
				<div class="card custom-card">
					<ul class="nav nav-tabs tab-style-8 scaleX rounded m-3 mb-0 profile-settings-tab gap-3" id="myTab4" role="tablist">
						<li class="nav-item me-1" role="presentation">
							<a href="javascript:void(0);" class="nav-link fs-16 fw-medium active" id="edit-profile" data-bs-toggle="tab" data-bs-target="#edit-profile-pane" role="tab" aria-controls="edit-profile-pane" aria-selected="true">Company Profile</a>
						</li>
						<li class="nav-item me-1" role="presentation">
							<a href="javascript:void(0);" class="nav-link fs-16 fw-medium" id="Other-settings-tab" data-bs-toggle="tab" data-bs-target="#Other-settings-tab-pane" role="tab" aria-controls="Other-settings-tab-pane" aria-selected="false"> Settings</a>
						</li>
					</ul>
					<div class="p-3 border-bottom border-top border-block-end-dashed tab-content">
						<div class="tab-pane pt-3 show active overflow-hidden p-0 border-0" id="edit-profile-pane" role="tabpanel" aria-labelledby="edit-profile" tabindex="0">
							<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-1 p-2 bg-primary-transparent rounded">
								<div class="fw-semibold d-block fs-17 text-white">Company Profile </div>
								<div class="btn btn-primary btn-sm"><i class="ri-loop-left-line lh-1 me-2"></i>Restore Changes</div>
							</div>
							
							
							
							<form id="com-profile-frm"> 
								<div class="row">
									<!-- LEFT SIDE : FORM -->
									<div class="col-xl-9">
										<form id="com-profile-frm" class="form-control">

											<!-- LOGO -->
											<div class="row mb-3">
												<div class="col-12">
													<div class="d-flex align-items-center flex-wrap gap-3 p-2 border border-dashed bg-light rounded-3">

														<span class="avatar avatar-xxl avatar-rounded">
															<img id="logoPreview" alt="">
														</span>

														<div>
															<input type="file" name="com_logo" id="logoUpload" accept="image/*" hidden>

															<label for="logoUpload" class="btn btn-sm btn-info rounded-pill btn-wave">
																<i class="ri-upload-2-line me-1"></i>Change Image
															</label>

															<span class="d-block fs-12 text-muted mt-2">
																Supported formats: JPEG, PNG, GIF.
															</span>
														</div>

													</div>
												</div>
											</div>


											<!-- COMPANY NAME -->
											<div class="row mb-3">
												<div class="col-12">
													<input type="text" name="com_name" class="form-control form-control-sm" placeholder="Enter Company Name">
												</div>
											</div>


											<!-- EMAIL -->
											<div class="row mb-3">
												<div class="col-12">
													<input type="email" name="com_email" class="form-control form-control-sm" placeholder="Enter Company Email">
												</div>
											</div>


											<!-- PHONE 1 -->
											<div class="row mb-3">
												<div class="col-12">
													<input type="tel" name="com_phone" class="form-control form-control-sm" placeholder="Enter Company Phone 1">
												</div>
											</div>


											<!-- PHONE 2 -->
											<div class="row mb-3">
												<div class="col-12">
													<input type="tel" name="com_phone2" class="form-control form-control-sm" placeholder="Enter Company Phone 2">
												</div>
											</div>


											<!-- WEBSITE -->
											<div class="row mb-3">
												<div class="col-12">
													<input type="url" name="com_web" class="form-control form-control-sm bg-light" placeholder="Enter Website URL">
												</div>
											</div>


											<!-- ADDRESS -->
											<div class="row mb-3">
												<div class="col-12">
													<textarea class="form-control form-control-sm" name="com_addr" rows="3" placeholder="Address"></textarea>
												</div>
											</div>


											<!-- BUTTONS -->
											<div class="card-footer border-top-0">
												<div class="p-2 bg-light d-flex gap-2 justify-content-between rounded">
													<button type="reset" class="btn btn-danger-light btn-wave"> Reset </button> 
													<button type="submit" class="btn btn-primary btn-wave"> Save Changes </button>
												</div>
											</div>

										</form>
									</div>



									<!-- RIGHT SIDE : INFO CARD -->
									<div class="col-sm-3">
									
										<div class="card custom-card">
											<div class="card-body">
												<!-- PREVIEW COLUMN -->
												<div class="cp-preview-col">
												  <div class="prev-sticky">
													<div class="prev-topbar">
													  <i class="ti ti-eye"></i>
													  <span class="lbl">Profile preview</span>
													  <span class="badge-live">Live</span>
													</div>

													<div class="prev-cover"></div>

													<div class="prev-avatar-wrap">
													  <div class="prev-avatar" id="prev-avatar">
														<span id="prev-initials">Loading...<img id="comlogo" class="profile_logo"/></span>
													  </div>
													</div>

													<div class="prev-identity">
													  <div class="prev-cname" id="comname"></div>
													  <div class="prev-cemail" id="prev-email">Loading...</div>
													</div>

													<div class="prev-meta">
													  <div class="prev-row">
														<div class="prev-row-ic"><i class="ti ti-phone"></i></div>
														<div>
														  <div class="prev-lbl">Primary phone</div>
														  <div class="prev-val empty" id="comcon1">Loading...</div>
														</div>
													  </div>
													  <div class="prev-row">
														<div class="prev-row-ic"><i class="ti ti-phone-plus"></i></div>
														<div>
														  <div class="prev-lbl">Secondary phone</div>
														  <div class="prev-val empty" id="comcon2">Loading...</div>
														</div>
													  </div>
													  <div class="prev-row">
														<div class="prev-row-ic"><i class="ti ti-world"></i></div>
														<div>
														  <div class="prev-lbl">Website</div>
														  <div class="prev-val empty web">Loading...</div>
														</div>
													  </div>
													  <div class="prev-row">
														<div class="prev-row-ic"><i class="ti ti-map-pin"></i></div>
														<div>
														  <div class="prev-lbl">Address</div>
														  <div class="prev-val empty" id="add">Loading...</div>
														</div>
													  </div>
													</div>
												  </div>
												</div>
												<!-- /PREVIEW COLUMN -->
											
											
											
												
											</div>
										</div>
									</div>
								</div>
							</form>
							
							
							
							
						</div>
						
						<div class="tab-pane pt-3 overflow-hidden p-0 border-0" id="Other-settings-tab-pane" role="tabpanel" aria-labelledby="Other-settings-tab" tabindex="0">
							<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-1 p-2 bg-primary-transparent rounded">
								<div class="fw-semibold d-block fs-17 text-white">System Settings </div>
								<div class="btn btn-primary btn-sm"><i class="ri-loop-left-line lh-1 me-2"></i>Restore Changes</div>
							</div>
							<form id="configForm">
								<!--<div class="row gx-5 gy-3">
									<div class="col-xl-12">
										<div class="d-flex align-items-top justify-content-between px-3">
											<div class="mail-notification-settings">
												<p class="fs-14 mb-1 fw-medium">Enable Push Alerts</p>
												<p class="fs-12 mb-0 text-muted">Stay updated with real-time notifications on your mobile or desktop.</p>
											</div>
											<div class="toggle on toggle-success mb-0 float-sm-end" id="push-notifications">
												<span></span>
											</div>
										</div>
										<div class="d-flex align-items-top justify-content-between px-3 mt-3">
											<div class="mail-notification-settings">
												<p class="fs-14 mb-1 fw-medium">Receive Email Alerts</p>
												<p class="fs-12 mb-0 text-muted">Get important updates sent directly to your email.</p>
											</div>
											<div class="toggle toggle-success mb-0 float-sm-end" id="email-notifications">
												<span></span>
											</div>
										</div>
										<div class="d-flex align-items-top justify-content-between px-3 mt-3">
											<div class="mail-notification-settings">
												<p class="fs-14 mb-1 fw-medium">Activate SMS Alerts</p>
												<p class="fs-12 mb-0 text-muted">Receive text message alerts on your mobile phone.</p>
											</div>
											<div class="toggle toggle-success on mb-0 float-sm-end" id="sms-notifications">
												<span></span>
											</div>
										</div>                                         
									</div>
								</div>-->
								<div class="row" id="configFields"></div>

								<div class="col-md-12">
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<!--End::row-1 -->

	</div>
</div>
<!-- End::app-content -->


<script>

	$(document).ready(function(){
		loadCompany();
		
		//Submit Company Info
		$('#com-profile-frm').ajax_submit({
			url :'/Settings/update_company_info',
			rest: false,
			callback : function(id){
				loadCompany(); // reload data
			}
		});
		
		//update system settings
		$('#configForm').ajax_submit({
			url :'/Settings/updateConfig',
			rest: false,
			callback : function(res){
				
			}
		});
		
		//load config form
		/*$.ajax({
			url: "/Settings/getConfigForm",
			type: "GET",
			dataType: "json",
			success: function(res) {

				if (res.stt === "ok") {

					let html = "";

					$.each(res.data, function(i, row) {

						let value = row.feild_value ?? "";
						let checked = row.is_enable == "1" ? "checked" : "";

						html += '<div class="col-md-6 mb-3">';
						html += '<label class="form-label">'+row.lable_name+'</label>';

						// TEXTAREA
						if(row.feild_name === "textarea"){

							html += '<textarea '+
									'class="'+row.class_name+'" '+
									'name="config['+row.s_c_id+']">'+
									value+
									'</textarea>';

						}

						// CHECKBOX
						else if(row.feild_name === "checkbox"){

							html += '<div class="form-check">';
							html += '<input type="checkbox" '+
									'class="'+row.class_name+'" '+
									'name="config['+row.s_c_id+']" '+
									'value="1" '+checked+'>';
							html += '</div>';

						}

						// OTHER INPUT TYPES
						else{

							html += '<input type="'+row.feild_name+'" '+
									'class="'+row.class_name+'" '+
									'name="config['+row.s_c_id+']" '+
									'value="'+value+'">';
						}

						html += '</div>';

					});

					$("#configFields").html(html);
				}

			}
		});*/
		
		$.ajax({
			url: "/Settings/getConfigForm",
			type: "GET",
			dataType: "json",
			success: function(res) {

				if (res.stt === "ok") {

					let textHtml = "";
					let checkboxHtml = "";
					let textareaHtml = "";

					$.each(res.data, function(i, row) {

						let value = row.feild_value ?? "";
						let checked = row.is_enable == "1" ? "checked" : "";

						let field = '<div class="col-md-3 mb-3">';
						field += '<label class="form-label">'+row.lable_name+'</label><br>';
						field += '<span class="red">'+row.description+'</span>';

						// TEXTAREA
						if(row.feild_name === "textarea"){

							field += '<textarea class="'+row.class_name+'" name="config['+row.s_c_id+']">'+value+'</textarea>';
							field += '</div>';

							textareaHtml += field;
						}

						// CHECKBOX
						else if(row.feild_name === "checkbox"){

							/*field += '<div class="form-check">';
							field += '<input type="checkbox" class="'+row.class_name+'" name="config['+row.s_c_id+']" value="1" '+checked+'>';
							field += '</div>';
							field += '</div>';*/
							field += '<div class="form-check form-switch">';
							field += '<input type="checkbox" role="switch" class="form-check-input '+row.class_name+'" id="switch_'+row.s_c_id+'" name="config['+row.s_c_id+']" value="1" '+checked+'>';
							field += '<label class="form-check-label" for="switch_'+row.s_c_id+'">'+row.lable_name+'</label>';
							field += '</div>';
							field += '</div>';

							checkboxHtml += field;
						}

						// TEXT / NUMBER / EMAIL etc
						else{

							field += '<input type="'+row.feild_name+'" class="'+row.class_name+'" name="config['+row.s_c_id+']" value="'+value+'">';
							field += '</div>';

							textHtml += field;
						}

					});

					let html = "";

					if(textHtml){
						html += '<div class="row">' + textHtml + '</div>';
					}

					if(checkboxHtml){
						html += '<div class="row">' + checkboxHtml + '</div>';
					}

					if(textareaHtml){
						html += '<div class="row">' + textareaHtml + '</div>';
					}

					$("#configFields").html(html);
				}

			}
		});
		
		
	});
	
	$('#logoUpload').on('change',function(){

		var reader = new FileReader();
		reader.onload = function(e){
			$('#logoPreview').attr('src',e.target.result);
		}
		reader.readAsDataURL(this.files[0]);

	});


	function loadCompany(){

		$.ajax({
			url:'/Settings/get_com_info',
			type:'GET',
			dataType:'json',
			success:function(res){

				$('[name="com_name"]').val(res.company_name);
				$('[name="com_email"]').val(res.company_email_1);
				$('[name="com_phone"]').val(res.company_contact_1);
				$('[name="com_phone2"]').val(res.company_contact_2);
				$('[name="com_web"]').val(res.company_web);
				$('[name="com_addr"]').val(res.company_addr);

				$('#old_logo').val(res.company_logo);
				
				$('#comname').html(res.company_name);
				$('#comemail').html(res.company_email_1);
				$('#comcon1').html(res.company_contact_1);
				$('#comcon2').html(res.company_contact_2);
				$('.web').html(res.company_web);
				$('#add').html(res.company_addr);

				if(res.company_logo){
					$('#logoPreview').attr('src','/uploads/'+res.company_logo);
					$('#comlogo').attr('src','/uploads/'+res.company_logo);
				}

			}
		});

	}

	document.getElementById("logoUpload").addEventListener("change", function(event) {
		const file = event.target.files[0];
		if (file) {
			const reader = new FileReader();
			reader.onload = function(e) {
				document.getElementById("logoPreview").src = e.target.result;
			};
			reader.readAsDataURL(file);
		}
	});

	function removeLogo() {
		document.getElementById("logoPreview").src = "../assets/images/faces/9.jpg";
		document.getElementById("logoUpload").value = "";
	}
</script>


	
</script>