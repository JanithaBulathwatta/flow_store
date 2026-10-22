
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Remix Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <!-- Toastr for notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Google Font: Nunito -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════
           CSS Variables (Rixzo palette)
        ══════════════════════════════════════ */
        :root {
            --sidebar-width: 250px;
            --topbar-height: 70px;
            --sidebar-bg: #405189;
            --sidebar-dark-bg: #3a4a7d;
            --sidebar-text: rgba(255,255,255,.65);
            --sidebar-text-hover: #fff;
            --sidebar-active-bg: rgba(255,255,255,.1);
            --sidebar-icon: rgba(255,255,255,.5);
            --topbar-bg: #fff;
            --topbar-shadow: 0 1px 0 rgba(0,0,0,.08);
            --body-bg: #f3f3f9;
            --primary: #405189;
            --primary-hover: #364474;
            --card-bg: #fff;
            --card-shadow: 0 1px 2px rgba(56,65,74,.15);
            --border-color: #e9ebec;
            --text-main: #343a40;
            --text-muted: #878a99;
            --font: 'Nunito', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body { height: 100%; }

        body {
            font-family: var(--font);
            font-size: 14px;
            background: var(--body-bg);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: left .25s ease;
            overflow: hidden;
        }

        /* Brand / Logo */
        .sidebar-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0 22px;
            background: var(--sidebar-dark-bg);
            flex-shrink: 0;
            text-decoration: none;
        }
        .sidebar-brand .brand-logo {
            width: 32px; height: 32px;
            background: #fff;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: var(--primary); font-weight: 800;
            margin-right: 10px; flex-shrink: 0;
        }
        .sidebar-brand .brand-name {
            font-size: 17px; font-weight: 700;
            color: #fff; letter-spacing: .3px;
        }
        .sidebar-brand .brand-name span { color: rgba(255,255,255,.55); font-weight: 400; font-size: 13px; display: block; line-height: 1; }

        /* Scroll area */
        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 10px 0 20px;
        }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

        /* Section labels */
        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,.3);
            padding: 18px 22px 6px;
        }

        /* Nav items */
        .sidebar-nav { list-style: none; padding: 0; }
        .sidebar-nav .nav-item { position: relative; }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 9px 22px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-radius: 0;
            transition: color .15s, background .15s;
            white-space: nowrap;
            gap: 10px;
        }
        .sidebar-nav .nav-link i {
            font-size: 17px;
            color: var(--sidebar-icon);
            flex-shrink: 0;
            transition: color .15s;
            width: 20px; text-align: center;
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: var(--sidebar-text-hover);
            background: var(--sidebar-active-bg);
        }
        .sidebar-nav .nav-link:hover i,
        .sidebar-nav .nav-link.active i { color: #fff; }

        .sidebar-nav .nav-link .badge {
            margin-left: auto;
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 20px;
            background: rgba(255,255,255,.15);
            color: #fff;
        }

        /* Active indicator bar */
        .sidebar-nav .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 4px; bottom: 4px;
            width: 3px;
            background: #fff;
            border-radius: 0 3px 3px 0;
        }

        /* Submenu */
        .sidebar-nav .sub-menu {
            list-style: none;
            padding: 2px 0 4px 52px;
            display: none;
        }
        .sidebar-nav .sub-menu.show { display: block; }
        .sidebar-nav .sub-menu .nav-link {
            font-size: 12.5px;
            padding: 6px 22px 6px 0;
            color: rgba(255,255,255,.5);
        }
        .sidebar-nav .sub-menu .nav-link::before {
            content: '•';
            margin-right: 8px;
            font-size: 16px;
            line-height: 0;
            vertical-align: middle;
            color: rgba(255,255,255,.3);
        }
        .sidebar-nav .sub-menu .nav-link:hover,
        .sidebar-nav .sub-menu .nav-link.active {
            color: #fff;
            background: none;
        }
        .sidebar-nav .sub-menu .nav-link.active::before { color: #fff; }

        /* Chevron */
        .sidebar-nav .nav-link .chevron {
            margin-left: auto;
            font-size: 13px;
            transition: transform .2s;
        }
        .sidebar-nav .nav-link[aria-expanded="true"] .chevron { transform: rotate(90deg); }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 14px 22px;
            border-top: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .sidebar-footer .avatar {
            width: 34px; height: 34px;
            background: rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: #fff; font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar-footer .user-info { flex: 1; min-width: 0; }
        .sidebar-footer .user-name { font-size: 13px; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-footer .user-role { font-size: 11px; color: rgba(255,255,255,.45); }
        .sidebar-footer .btn-logout { color: rgba(255,255,255,.45); font-size: 17px; text-decoration: none; transition: color .15s; }
        .sidebar-footer .btn-logout:hover { color: #fff; }

        /* ══════════════════════════════════════
           TOPBAR
        ══════════════════════════════════════ */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--topbar-bg);
            box-shadow: var(--topbar-shadow);
            z-index: 1030;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
        }

        /* Hamburger */
        #sidebarToggle {
            background: none; border: none; cursor: pointer;
            width: 36px; height: 36px;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px;
            border-radius: 6px;
            transition: background .15s;
            flex-shrink: 0;
        }
        #sidebarToggle:hover { background: #f3f3f9; }
        #sidebarToggle span {
            display: block; width: 20px; height: 2px;
            background: #495057; border-radius: 2px;
            transition: all .25s;
        }

        /* Search */
        .topbar-search {
            flex: 0 1 280px;
            position: relative;
        }
        .topbar-search input {
            width: 100%;
            height: 36px;
            border: 1px solid #e9ebec;
            border-radius: 20px;
            background: #f3f3f9;
            padding: 0 14px 0 36px;
            font-size: 13px;
            font-family: var(--font);
            outline: none;
            color: #495057;
            transition: border-color .15s, background .15s;
        }
        .topbar-search input:focus { border-color: var(--primary); background: #fff; }
        .topbar-search i {
            position: absolute;
            left: 12px; top: 50%; transform: translateY(-50%);
            color: #adb5bd; font-size: 15px;
        }

        .topbar-spacer { flex: 1; }

        /* Icon buttons */
        .topbar-icon-btn {
            position: relative;
            width: 38px; height: 38px;
            border-radius: 50%;
            background: none; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #6c757d; font-size: 20px;
            transition: background .15s, color .15s;
            text-decoration: none;
        }
        .topbar-icon-btn:hover { background: #f3f3f9; color: var(--primary); }
        .topbar-icon-btn .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: #f06548;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .topbar-icon-btn .badge-count {
            position: absolute;
            top: 4px; right: 2px;
            background: #f06548;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            padding: 1px 4px;
            border-radius: 10px;
            border: 1px solid #fff;
            line-height: 1.4;
        }

        /* User dropdown */
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 4px 10px 4px 4px;
            border-radius: 30px;
            border: none; background: none;
            transition: background .15s;
        }
        .topbar-user:hover { background: #f3f3f9; }
        .topbar-user .avatar {
            width: 36px; height: 36px;
            background: var(--primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; color: #fff; font-weight: 700;
        }
        .topbar-user .user-name { font-size: 13px; font-weight: 600; color: #343a40; }
        .topbar-user i { font-size: 14px; color: #adb5bd; }

        /* Dropdown menu */
        .topbar-dropdown {
            position: absolute;
            top: calc(var(--topbar-height) - 4px);
            right: 24px;
            width: 200px;
            background: #fff;
            border: 1px solid #e9ebec;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,.1);
            display: none;
            z-index: 1050;
            overflow: hidden;
        }
        .topbar-dropdown.show { display: block; }
        .topbar-dropdown .dropdown-header {
            padding: 14px 16px 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        .topbar-dropdown .dropdown-header .name { font-size: 13px; font-weight: 700; color: #343a40; }
        .topbar-dropdown .dropdown-header .role { font-size: 11.5px; color: #878a99; }
        .topbar-dropdown a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 16px;
            font-size: 13px; color: #495057;
            text-decoration: none;
            transition: background .12s;
        }
        .topbar-dropdown a i { font-size: 16px; color: #878a99; width: 18px; }
        .topbar-dropdown a:hover { background: #f8f9fa; }
        .topbar-dropdown .dropdown-divider { border-top: 1px solid #f0f0f0; margin: 4px 0; }
        .topbar-dropdown .text-danger { color: #f06548 !important; }
        .topbar-dropdown .text-danger i { color: #f06548 !important; }

        /* ══════════════════════════════════════
           PAGE CONTENT
        ══════════════════════════════════════ */
        #page-wrapper {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left .25s ease;
        }

        .page-content {
            flex: 1;
            padding: 24px;
        }

        /* Page title */
        .page-title-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 4px 0 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .page-title-box h4 { font-size: 18px; font-weight: 700; color: var(--text-main); margin: 0; }
        .breadcrumb { font-size: 12.5px; margin: 0; }
        .breadcrumb-item a { color: var(--primary); text-decoration: none; }
        .breadcrumb-item.active { color: var(--text-muted); }
        .breadcrumb-item + .breadcrumb-item::before { color: #ced4da; }

        /* ══════════════════════════════════════
           CARDS
        ══════════════════════════════════════ */
        .card {
            background: var(--card-bg);
            border: none;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }
        .card-header {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            border-radius: 8px 8px 0 0 !important;
            padding: 14px 20px;
            display: flex;
            align-items: center;
        }
        .card-header h6 { font-size: 14px; font-weight: 700; color: var(--text-main); margin: 0; flex: 1; }
        .card-header h6 i { color: var(--primary); margin-right: 6px; }
        .card-body { padding: 20px; border-radius: 0 0 8px 8px; }

        /* ══════════════════════════════════════
           FORM ELEMENTS
        ══════════════════════════════════════ */
        .form-label { font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 5px; display: block; }
        .form-control, .form-select {
            font-size: 13px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            color: #495057;
            transition: border-color .15s, box-shadow .15s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(64,81,137,.12);
            outline: none;
        }
        .form-control::placeholder { color: #adb5bd; }
        .form-control-sm { height: calc(1.5em + .5rem + 2px); padding: .25rem .5rem; }
        .form-select-sm { padding-top: .25rem; padding-bottom: .25rem; padding-left: .5rem; font-size: 13px; }

        .input-group-text {
            font-size: 13px; font-weight: 600;
            background: #f8f9fa; border-color: #ced4da; color: #6c757d;
        }
        small.text-muted, .form-text {
            font-size: 11.5px; color: #adb5bd !important; margin-top: 3px; display: block;
        }
        .invalid-feedback { font-size: 12px; color: #f06548; display: none; }
        .was-validated .invalid-feedback, .is-invalid ~ .invalid-feedback, .is-invalid .invalid-feedback { display: block; }
        .is-invalid, .was-validated :invalid {
            border-color: #f06548 !important;
        }

        /* ══════════════════════════════════════
           TRACKING CHECKBOX BOXES
        ══════════════════════════════════════ */
        .tracking-box {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 14px 16px;
            height: 100%;
            background: #fafafa;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }
        .tracking-box:hover { border-color: var(--primary); background: #f5f7ff; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
        .form-check-label { font-size: 13px; font-weight: 600; color: var(--text-main); cursor: pointer; }

        /* ══════════════════════════════════════
           WARRANTY SECTION
        ══════════════════════════════════════ */
        #warrantyFieldsContainer { display: none; }
        .warranty-divider { border: none; border-top: 1px dashed #dee2e6; margin: 20px 0 16px; }
        .section-badge {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .7px; color: var(--text-muted); margin-bottom: 14px;
        }

        /* ══════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════ */
        .btn { font-size: 13px; font-weight: 600; border-radius: 6px; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); }
        .btn-light { background: #eff2f7; border-color: #eff2f7; color: #495057; }
        .btn-light:hover { background: #e2e8f2; border-color: #e2e8f2; }

        .action-bar {
            display: flex; justify-content: flex-end; gap: 10px; padding-bottom: 10px;
        }

        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */
        #footer {
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12.5px;
            color: var(--text-muted);
            flex-wrap: wrap;
            gap: 6px;
        }
        #footer a { color: var(--primary); text-decoration: none; }
        #footer a:hover { text-decoration: underline; }

        /* ══════════════════════════════════════
           Select2 overrides
        ══════════════════════════════════════ */
        .select2-container--bootstrap-5 .select2-selection { font-size: 13px; border-color: #ced4da; }
        .select2-container--bootstrap-5.select2-container--focus .select2-selection {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(64,81,137,.12);
        }

        /* ══════════════════════════════════════
           RESPONSIVE — collapse sidebar
        ══════════════════════════════════════ */
        @media (max-width: 991px) {
            #sidebar { left: calc(-1 * var(--sidebar-width)); }
            #sidebar.show { left: 0; }
            #topbar { left: 0; }
            #page-wrapper { margin-left: 0; }
            .sidebar-overlay { display: block !important; }
        }

        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 1039;
        }

        /* Loading spinner */
        .loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
		
		.app-sidebar .main-sidebar-header {
			width: 15.6rem;
		}
		

    </style>
</head>
<body>


<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Loading Spinner -->
<div class="loading" id="loadingSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- ════════════════════════════════════════════════
     SIDEBAR
════════════════════════════════════════════════ -->
 
<!-- ════════════════════════════════════════════════
     TOPBAR
════════════════════════════════════════════════ -->
 

<!-- ════════════════════════════════════════════════
     PAGE WRAPPER
════════════════════════════════════════════════ -->
<div id="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="page-title-box">
                <h4><i class="ri-box-3-line me-2 align-middle" style="color:var(--primary);"></i><?php echo isset($is_edit) && $is_edit ? 'Edit Product' : 'Add Product'; ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('Dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('Product'); ?>">Products</a></li>
                    <li class="breadcrumb-item active"><?php echo isset($is_edit) && $is_edit ? 'Edit Product' : 'Add Product'; ?></li>
                </ol>
            </div>

            <!-- Form -->
            <form id="productForm" novalidate enctype="multipart/form-data">
                <input type="hidden" id="product_id" name="pid" value="<?php echo isset($product_id) ? $product_id : (isset($product['id']) ? $product['id'] : ''); ?>">
                <input type="hidden" id="form_status" name="status" value="active">

                <!-- Card 1: Basic Information -->
                <div class="card">
                    <div class="card-header">
                        <h6><i class="ri-information-line"></i>Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

						<!-- Super Category Dropdown -->
						<div class="col-md-6">
							<label class="form-label">Super Category <span class="text-danger">*</span></label>
							<select name="super_category_id" id="super_category_id" class="form-select form-select-sm js-example-basic-single" required>
								<option value="">Select Super Category</option>
								<?php if (isset($super_categories) && !empty($super_categories)): ?>
									<?php foreach ($super_categories as $cat): ?>
										<option value="<?php echo is_object($cat) ? $cat->id : $cat['id']; ?>" 
											<?php echo (isset($product['sub_category_id']) && $product['sub_category_id'] == (is_object($cat) ? $cat->id : $cat['id'])) ? 'selected' : ''; ?>>
											<?php echo htmlspecialchars(is_object($cat) ? $cat->name : $cat['name']); ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
							<div class="invalid-feedback" id="super_category_id-error"></div>
						</div>

						

						<!-- Product Category Dropdown -->
						<div class="col-md-6">
							<label class="form-label">Sub Category <span class="text-danger">*</span></label>
							<select name="category_id" id="category_id" class="form-select form-select-sm js-example-basic-single" required>
								<option value="">Select Sub Category</option>
								<?php if (isset($sub_categories) && !empty($sub_categories)): ?>
									<?php foreach ($sub_categories as $subcat): ?>
										<option value="<?php echo $subcat['id']; ?>" 
											<?php echo (isset($product['category_id']) && $product['category_id'] == $subcat['id']) ? 'selected' : ''; ?>
											data-super-category="<?php echo isset($subcat['super_category_id']) ? $subcat['super_category_id'] : ''; ?>">
											<?php echo htmlspecialchars($subcat['name']); ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
							<div class="invalid-feedback" id="category_id-error"></div>
						</div>
						
						<!-- Brand Dropdown -->
						<div class="col-md-6">
							<label class="form-label">Brand <span class="text-danger">*</span></label>
							<select name="brand_id" id="brand_id"
									class="form-select form-select-sm js-example-basic-single" required>
								<option value="">Select Brand</option>
								<?php if (isset($brands) && !empty($brands)): ?>
									<?php foreach ($brands as $brand): ?>
										<option value="<?php echo is_object($brand) ? $brand->brand_id : $brand['brand_id']; ?>" 
											<?php echo (isset($product['brand_id']) && $product['brand_id'] == (is_object($brand) ? $brand->brand_id : $brand['brand_id'])) ? 'selected' : ''; ?>>
											<?php echo htmlspecialchars(is_object($brand) ? $brand->brand_name : $brand['brand_name']); ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
							<div class="invalid-feedback" id="brand_id-error"></div>
						</div>

                            <div class="col-md-6">
                                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-sm"
                                       placeholder="Enter product name" 
                                       value="<?php echo isset($product['name']) ? htmlspecialchars($product['name']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback" id="name-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Product Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code"
                                       class="form-control form-control-sm"
                                       placeholder="Enter product code" 
                                       value="<?php echo isset($product['product_code']) ? htmlspecialchars($product['product_code']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback" id="code-error"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Reorder Level <span class="text-danger">*</span></label>
                                <input type="number" name="reorder_level" id="reorder_level"
                                       class="form-control form-control-sm"
                                       placeholder="Enter reorder level" min="0" 
                                       value="<?php echo isset($product['reorder_level']) ? $product['reorder_level'] : (isset($default_reorder_level) ? $default_reorder_level : 0); ?>"
                                       required>
                                <div class="invalid-feedback" id="reorder_level-error"></div>
                            </div>
							
							<!-- Measure Unit Dropdown - Dynamic from Database -->
							<div class="col-md-6">
								<label class="form-label">Measure Unit <span class="text-danger">*</span></label>
								<select name="measure_unit" id="measure_unit" class="form-select form-select-sm js-example-basic-single" required>
									<option value="">Select Measure Unit</option>
									<?php if (isset($units) && !empty($units)): ?>
										<?php foreach ($units as $unit): ?>
											<option value="<?php echo $unit['unit_id']; ?>" 
												<?php echo (isset($product['measure_unit']) && $product['measure_unit'] == $unit['unit_id']) ? 'selected' : ''; ?>>
												<?php echo htmlspecialchars($unit['unit_name']); ?> 
												  
											</option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
								<small class="text-muted">Unit of measurement for this product</small>
								<div class="invalid-feedback" id="measure_unit-error"></div>
							</div>

							<!-- NEW: Qty Per Pack -->
							<div class="col-md-6">
								<label class="form-label">Quantity Per Pack</label>
								<input type="number" name="qty_per_pack" id="qty_per_pack"
									   class="form-control form-control-sm"
									   placeholder="Enter quantity per pack" min="1" 
									   value="<?php echo isset($product['qty_per_pack']) ? $product['qty_per_pack'] : (isset($default_qty_per_pack) ? $default_qty_per_pack : 1); ?>">
								<small class="text-muted">Number of items in one pack</small>
							</div>
	

                        </div>
                    </div>
                </div>

                <!-- Card 2: Pricing - Compact Version -->
				<div class="card">
					<div class="card-header">
						<h6><i class="ri-price-tag-3-line"></i>Pricing</h6>
					</div>
					<div class="card-body">
						<div class="row g-2 align-items-end">
							<div class="col-md-4">
								<label class="form-label">Standard Price <span class="text-danger">*</span></label>
								<div class="input-group input-group-sm">
									<span class="input-group-text">LKR</span>
									<input type="number" name="selling_price" id="selling_price"
										   class="form-control" placeholder="0.00" step="0.01" min="0" 
										   value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>"
										   required>
								</div>
								<div class="invalid-feedback" id="selling_price-error"></div>
							</div>

							<div class="col-md-4">
								<label class="form-label">Wholesale Price</label>
								<div class="input-group input-group-sm">
									<span class="input-group-text">LKR</span>
									<input type="number" name="wholesale_price" id="wholesale_price"
										   class="form-control" placeholder="0.00" step="0.01" min="0"
										   value="<?php echo isset($product['wholesalePrice']) ? $product['wholesalePrice'] : ''; ?>">
								</div>
								<div class="invalid-feedback" id="wholesale_price-error"></div>
							</div>

							<div class="col-md-4">
								<label class="form-label">Minimum Price</label>
								<div class="input-group input-group-sm">
									<span class="input-group-text">LKR</span>
									<input type="number" name="special_price" id="special_price"
										   class="form-control" placeholder="0.00" step="0.01" min="0"
										   value="<?php echo isset($product['specialPrice']) ? $product['specialPrice'] : ''; ?>">
								</div>
								<div class="invalid-feedback" id="special_price-error"></div>
							</div>
						</div>
					</div>
				</div>
				 

				<!-- Card 4: Product Images Upload (NEW) -->
				<div class="card">
					<div class="card-header">
						<h6><i class="ri-image-line"></i>Product Images</h6>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<!-- Main Image Upload -->
								<div class="mb-3">
									<label class="form-label">Main Product Image</label>
									<input type="file" name="main_image" id="main_image" 
										   class="form-control form-control-sm" 
										   accept="image/jpeg,image/png,image/jpg,image/webp">
									<small class="text-muted">Upload main product image (Max: 2MB). Recommended size: 500x500px</small>
									<div id="main_image_preview" class="mt-2"></div>
								</div>

                 

								<!-- Images will be loaded by AJAX -->
				<div id="existingImagesContainer" class="mt-3"></div>
							</div>
						</div>
					</div>
				</div>

                <!-- Card 3: Tracking & Warranty -->
                <div class="card">
                    <div class="card-header">
                        <h6><i class="ri-shield-check-line"></i>Tracking &amp; Warranty</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                           <?php
							$configs = $this->session->userdata('sys_config');

							if (($configs['Pro_serial'] ?? '0') == '1'):
							?>
							<div class="col-md-6">
								<div class="tracking-box">
									<div class="form-check mb-1">
										<input type="checkbox"
											   name="is_serial_trk"
											   id="is_serial_trk"
											   value="1"
											   class="form-check-input"
											   <?= (!empty($product['is_serial_trk'])) ? 'checked' : ''; ?>>
										<label class="form-check-label" for="is_serial_trk">
											Enable Serial Number Tracking
										</label>
									</div>
									<small class="text-muted">
										Track individual serial numbers for this product
									</small>
								</div>
							</div>
							<?php
							endif;
							?>

                            <?php
							$configs = $this->session->userdata('sys_config');

							if (($configs['Expire_trk'] ?? '0') == '1'):
							?>
							<div class="col-md-6">
								<div class="tracking-box">
									<div class="form-check mb-1">
										<input type="checkbox"
											   name="is_expiry_trk"
											   id="is_expiry_trk"
											   value="1"
											   class="form-check-input"
											   <?= (!empty($product['is_expiry_trk'])) ? 'checked' : ''; ?>>
										<label class="form-check-label" for="is_expiry_trk">
											Enable Expiry Date Tracking
										</label>
									</div>
									<small class="text-muted">
										Track expiry dates for this product
									</small>
								</div>
							</div>
							<?php endif; ?>

                            <?php
							$configs = $this->session->userdata('sys_config');

							if (($configs['Pro_batch'] ?? '0') == '1'):
							?>
							<div class="col-md-6">
								<div class="tracking-box">
									<div class="form-check mb-1">
										<input type="checkbox"
											   name="is_batch"
											   id="is_batch"
											   value="1"
											   class="form-check-input"
											   <?= (!empty($product['is_batch'])) ? 'checked' : ''; ?>>
										<label class="form-check-label" for="is_batch">
											Enable Batch Tracking
										</label>
									</div>
									<small class="text-muted">
										Track products in batches (e.g., batch numbers, lot numbers)
									</small>
								</div>
							</div>
							<?php endif; ?>

                            <?php
							$configs = $this->session->userdata('sys_config');

							if (($configs['Pro_warranty'] ?? '0') == '1'):
							?>
							<div class="col-md-6">
								<div class="tracking-box">
									<div class="form-check mb-1">
										<input type="checkbox"
											   name="is_warranty_item"
											   id="is_warranty_item"
											   value="1"
											   class="form-check-input"
											   <?= (!empty($product['is_warranty_item'])) ? 'checked' : ''; ?>>
										<label class="form-check-label" for="is_warranty_item">
											This item has warranty
										</label>
									</div>
									<small class="text-muted">
										Product comes with warranty coverage
									</small>
								</div>
							</div>
							<?php endif; ?>

                        </div>

                        <!-- Warranty Fields -->
                        <div id="warrantyFieldsContainer" style="<?php echo (isset($product['is_warranty_item']) && $product['is_warranty_item'] == 1) ? 'display: block;' : 'display: none;'; ?>">
                            <hr class="warranty-divider">
                            <p class="section-badge">Warranty Details</p>
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Warranty Period <span class="text-danger">*</span></label>
                                    <select name="warranty_period" id="warranty_period" class="form-select form-select-sm">
                                        <option value="">Select Warranty Period</option>
                                        <option value="3 Months" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '3 Months') ? 'selected' : ''; ?>>3 Months</option>
                                        <option value="6 Months" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '6 Months') ? 'selected' : ''; ?>>6 Months</option>
                                        <option value="1 Year" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '1 Year') ? 'selected' : ''; ?>>1 Year</option>
                                        <option value="2 Years" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '2 Years') ? 'selected' : ''; ?>>2 Years</option>
                                        <option value="3 Years" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '3 Years') ? 'selected' : ''; ?>>3 Years</option>
                                        <option value="5 Years" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '5 Years') ? 'selected' : ''; ?>>5 Years</option>
                                        <option value="10 Years" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '10 Years') ? 'selected' : ''; ?>>10 Years</option>
                                        <option value="12 Years" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '12 Years') ? 'selected' : ''; ?>>12 Years</option>
                                        <option value="15 Years" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '15 Years') ? 'selected' : ''; ?>>15 Years</option>
                                        <option value="20 Years" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == '20 Years') ? 'selected' : ''; ?>>20 Years</option>
                                        <option value="Lifetime" <?php echo (isset($product['warranty_period']) && $product['warranty_period'] == 'Lifetime') ? 'selected' : ''; ?>>Lifetime</option>
                                    </select>
                                    <div class="invalid-feedback" id="warranty_period-error"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Warranty Type</label>
                                    <select name="warrantyType" id="warrantyType" class="form-select form-select-sm">
                                        <option value="">Select Warranty Type</option>
                                        <option value="Manufacturer" <?php echo (isset($product['warrantyType']) && $product['warrantyType'] == 'Manufacturer') ? 'selected' : ''; ?>>Manufacturer Warranty</option>
                                        <option value="Seller" <?php echo (isset($product['warrantyType']) && $product['warrantyType'] == 'Seller') ? 'selected' : ''; ?>>Seller Warranty</option>
                                        <option value="Extended" <?php echo (isset($product['warrantyType']) && $product['warrantyType'] == 'Extended') ? 'selected' : ''; ?>>Extended Warranty</option>
                                        <option value="Limited" <?php echo (isset($product['warrantyType']) && $product['warrantyType'] == 'Limited') ? 'selected' : ''; ?>>Limited Warranty</option>
                                        <option value="Lifetime" <?php echo (isset($product['warrantyType']) && $product['warrantyType'] == 'Lifetime') ? 'selected' : ''; ?>>Lifetime Warranty</option>
                                    </select>
                                    <small class="text-muted">Type of warranty coverage</small>
                                    <div class="invalid-feedback" id="warrantyType-error"></div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-bar">
                    <button type="button" class="btn btn-light btn-sm px-4" onclick="window.location.href='<?php echo base_url('Product'); ?>'">
                        <i class="ri-arrow-left-line me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-add btn-sm px-4" id="btn-sub">
                        <i class="ri-save-line me-1"></i> <?php echo isset($is_edit) && $is_edit ? 'Update Product' : 'Create Product'; ?>
                    </button>
                </div>

            </form>

        </div><!-- /container-fluid -->
    </div><!-- /page-content -->
 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function () {
	
	// Load product data when in edit mode
var productId = $('#product_id').val();
var isEditMode = <?php echo isset($is_edit) && $is_edit ? 'true' : 'false'; ?>;

if (isEditMode && productId) {
    loadProductData(productId);
	// Hide the Tracking & Warranty card
        //$('.card:has(.card-header:contains("Tracking & Warranty"))').hide();
}

function loadProductData(id) {
    $('#loadingSpinner').fadeIn(200);
    
    $.ajax({
        url: "<?php echo base_url('Product/get_product?id='); ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(response) {
            $('#loadingSpinner').fadeOut(200);
            
            if (response.success) {
                var product = response.product;
				
				$('#main_image_preview').empty();
                $('#main_image').val('');
                
                // Populate all form fields
                $('#super_category_id').val(product.sub_category_id).trigger('change');
                //$('#category_id').val(product.sub_category_id).trigger('change');
                $('#category_id').val(product.category_id).trigger('change');
                $('#brand_id').val(product.brand_id).trigger('change');
                $('#name').val(product.name);
                $('#code').val(product.product_code);
                $('#selling_price').val(product.price);
                $('#wholesale_price').val(product.wholesalePrice);
                $('#special_price').val(product.specialPrice);
                $('#min_price').val(product.min_price);
                $('#reorder_level').val(product.reorder_level);
				$('#measure_unit').val(product.unit_id).trigger('change');
                $('#qty_per_pack').val(product.qty_per_pack);
				
				$('#is_warranty_item').prop('checked', true);
                $('#warrantyFieldsContainer').show();
                $('#warranty_period').val(product.warranty_period);
                $('#warrantyType').val(product.warrantyType);
				
				// Load images dynamically
                if (product.images) {
                    var images = typeof product.images === 'string' ? JSON.parse(product.images) : product.images;
                    displayExistingImages(images);
                }
                
                // Handle checkboxes
                $('#is_serial_trk').prop('checked', product.is_serial_trk == 1);
                $('#is_expiry_trk').prop('checked', product.is_expiry_trk == 1);
                $('#is_batch').prop('checked', product.is_batch == 1);
                
                // Handle warranty
                if (product.is_warranty_item == 1) {
                    $('#is_warranty_item').prop('checked', true);
                    $('#warrantyFieldsContainer').show();
                    $('#warranty_period').val(product.warranty_period);
                    $('#warrantyType').val(product.warrantyType);
                } else {
                    $('#is_warranty_item').prop('checked', false);
                    //$('#warrantyFieldsContainer').hide();
                } 
                
                // Handle category filtering after super category is set
                setTimeout(function() {
                    if (product.category_id) {
                        $('#category_id').val(product.category_id).trigger('change');
                    }
                }, 500);
				
				 
                
                toastr.success('Product data loaded successfully');
            } else {
                toastr.error(response.message || 'Failed to load product data');
            }
        },
        error: function() {
            $('#loadingSpinner').fadeOut(200);
            toastr.error('Error loading product data');
        }
    });
}

// Function to display existing images
function displayExistingImages(images) {
    if (!images || images.length === 0) {
        $('#existingImagesContainer').html('');
        return;
    }
    
    var html = '<label class="form-label">Existing Images</label><div class="existing-images row">';
    
    for (var i = 0; i < images.length; i++) {
        var image = images[i];
        html += `
            <div class="col-md-3 col-sm-4 mb-2 position-relative" id="image_${md5(image)}">
                <img src="<?php echo base_url('uploads/products/'); ?>${image}" 
                     class="img-thumbnail" style="height: 100px; object-fit: cover; width: 100%;">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-image" 
                        data-image="${image}" style="border-radius: 50%;">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        `;
    }
    
    html += '</div>';
    $('#existingImagesContainer').html(html);
    
    // Re-bind remove image events
    $('.remove-image').off('click').on('click', function() {
        const imageName = $(this).data('image');
        const $imageContainer = $(this).closest('.col-md-3');
        
        if (confirm('Are you sure you want to remove this image?')) {
            // Add hidden input to mark image for deletion
            $('<input>').attr({
                type: 'hidden',
                name: 'delete_images[]',
                value: imageName
            }).appendTo('#productForm');
            
            $imageContainer.fadeOut(300, function() {
                $(this).remove();
            });
            
            toastr.info('Image will be deleted when form is submitted');
        }
    });
}

// Helper function for generating unique IDs
function md5(str) {
    // Simple hash for DOM IDs (you can use a proper MD5 if needed)
    return str.replace(/[^a-zA-Z0-9]/g, '_') + '_' + new Date().getTime();
}

  
     
    /* ── Select2 Init ── */
    $('.js-example-basic-single').select2({ theme: 'bootstrap-5', width: '100%' });

    /* ── Sidebar Toggle (desktop) ── */
    let sidebarCollapsed = false;
    $('#sidebarToggle').on('click', function () {
        if (window.innerWidth <= 991) {
            $('#sidebar').toggleClass('show');
            $('#sidebarOverlay').toggle();
        } else {
            sidebarCollapsed = !sidebarCollapsed;
            if (sidebarCollapsed) {
                document.documentElement.style.setProperty('--sidebar-width', '0px');
            } else {
                document.documentElement.style.setProperty('--sidebar-width', '250px');
            }
        }
    });

    /* ── Sidebar overlay close ── */
    $('#sidebarOverlay').on('click', function () {
        $('#sidebar').removeClass('show');
        $(this).hide();
    });

    /* ── Submenu toggle ── */
    $('.sidebar-nav .nav-link[data-bs-toggle="collapse"]').on('click', function (e) {
        e.preventDefault();
        const target = $(this).data('bs-target');
        const isExpanded = $(this).attr('aria-expanded') === 'true';
        $(this).attr('aria-expanded', !isExpanded);
        $(target).toggleClass('show');
    });

    /* ── User Dropdown ── */
    $('#userDropdownBtn').on('click', function (e) {
        e.stopPropagation();
        $('#userDropdown').toggleClass('show');
    });
    $(document).on('click', function () { $('#userDropdown').removeClass('show'); });

    /* ── Full Screen Toggle ── */
    $('#btnFullscreen').on('click', function () {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            $(this).find('i').removeClass('ri-fullscreen-line').addClass('ri-fullscreen-exit-line');
        } else {
            document.exitFullscreen();
            $(this).find('i').removeClass('ri-fullscreen-exit-line').addClass('ri-fullscreen-line');
        }
    });

    /* ── Warranty Fields Toggle ── */
    $('#is_warranty_item').on('change', function () {
    if ($(this).is(':checked')) {
        $('#warrantyFieldsContainer').slideDown(250);
        $('#warranty_period').prop('required', true);
        $('#warrantyType').prop('required', true);   
    } else {
        $('#warrantyFieldsContainer').slideUp(250);
        $('#warranty_period').prop('required', false);
        $('#warrantyType').prop('required', false);  
        $('#warranty_period').val('');
        $('#warrantyType').val('');
		
		$('#warranty_period').removeClass('is-invalid');
        $('#warrantyType').removeClass('is-invalid');
    }
});

    // Set initial required state for warranty period
    if ($('#is_warranty_item').is(':checked')) {
    $('#warranty_period').prop('required', true);
    $('#warrantyType').prop('required', true);
} else {
    $('#warranty_period').prop('required', false);
    $('#warrantyType').prop('required', false);
}
    
    
    
     

    /* ════════════════════════════════════════════════
       FILTER SUB CATEGORIES BY SUPER CATEGORY (IMPROVED)
    ════════════════════════════════════════════════ */
    
    // Store all sub category options
    var allSubOptions = [];
    
    // Save all sub category options on page load
    $('#category_id option').each(function() {
        if ($(this).val() !== '') {
            allSubOptions.push({
                value: $(this).val(),
                text: $(this).text(),
                superCategoryId: $(this).data('super-category')
            });
        }
    });
    
    // Function to filter sub categories
    function filterSubCategories(selectedSuperId, selectedSubCategoryId) {
        var $categorySelect = $('#category_id');
		
		
        
        // Clear current options
        $categorySelect.empty();
        $categorySelect.append('<option value="">Select Product Category</option>');
        
        // Filter and add matching options
        if (selectedSuperId && selectedSuperId !== '') {
            $.each(allSubOptions, function(index, option) {
                if (option.superCategoryId == selectedSuperId) {
                    $categorySelect.append('<option value="' + option.value + '">' + option.text + '</option>');
                }
            });
        } else {
            // Show all options
            $.each(allSubOptions, function(index, option) {
                $categorySelect.append('<option value="' + option.value + '">' + option.text + '</option>');
            });
        }
        
        // Restore selected value if provided
        if (selectedSubCategoryId && $categorySelect.find('option[value="' + selectedSubCategoryId + '"]').length > 0) {
            $categorySelect.val(selectedSubCategoryId);
        }
        
        // Refresh Select2
        $categorySelect.trigger('change.select2');
    }
    
    // Filter sub categories when super category changes
    $('#super_category_id').on('change', function() {
        var selectedSuperId = $(this).val();
        filterSubCategories(selectedSuperId, null);
    });
    
    // For Edit Mode: Trigger filter on page load with current values
    var isEditMode = <?php echo isset($is_edit) && $is_edit ? 'true' : 'false'; ?>;
    var currentSuperCategory = $('#super_category_id').val();
    var currentCategory = $('#category_id').val();
    
    if (isEditMode && currentSuperCategory) {
        // Small delay to ensure everything is loaded
        setTimeout(function() {
            filterSubCategories(currentSuperCategory, currentCategory);
        }, 100);
    }

     
    
	
	// Validate warranty fields
function validateWarrantyFields() {
    var isWarrantyChecked = $('#is_warranty_item').is(':checked');
    var warrantyPeriod = $('#warranty_period').val();
    var warrantyType = $('#warrantyType').val();
    var isValid = true;
    
    // Clear previous errors
    $('#warranty_period').removeClass('is-invalid');
    $('#warrantyType').removeClass('is-invalid');
    $('#warranty_period-error').html('');
    $('#warrantyType-error').html('');
    
    if (isWarrantyChecked) {
        // Validate Warranty Period
        if (!warrantyPeriod || warrantyPeriod === '') {
            $('#warranty_period').addClass('is-invalid');
            $('#warranty_period-error').html('Warranty period is required when warranty is enabled');
            isValid = false;
        }
        
        // Validate Warranty Type
        if (!warrantyType || warrantyType === '') {
            $('#warrantyType').addClass('is-invalid');
            $('#warrantyType-error').html('Warranty type is required when warranty is enabled');
            isValid = false;
        }
    }
    
    return isValid;
}

    /* ════════════════════════════════════════════════
       FORM SUBMIT HANDLER
    ════════════════════════════════════════════════ */

    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        
         
		
		if (!validateWarrantyFields()) {
        toastr.error('Please fill all warranty details');
        $('html, body').animate({
            scrollTop: $("#warranty_period").offset().top - 100
        }, 500);
        return false;
    }
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        
        // Show loading spinner
        $('#loadingSpinner').fadeIn(200);
        
        // Create FormData object for file uploads
        var formData = new FormData(this);
        
        $.ajax({
            url: "/Product/store",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,  // Don't process the data
            contentType: false,   // Don't set content type (let browser set it with boundary)
            success: function(response) {
    $('#loadingSpinner').fadeOut(200);
    
    if (response.stt === 'ok') {
        toastr.success(response.msg);
        setTimeout(function() {
            window.location.href = "<?php echo base_url('Product'); ?>";
        }, 1500);
    } else {
        // Display validation errors the same way as Super Category
        toastr.error(response.msg);
		
		if (response.errors) {
            $.each(response.errors, function(field, error) {
                let $field = $(`#${field}`);
                if ($field.length) {
                    $field.addClass('is-invalid');
                    $(`#${field}-error`).html(error);
                }
            });
        }
        
        // Clear previous validation styling
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').html('');
        
        // Parse and display individual field errors (like Super Category)
        let errorMsg = response.msg;
        
        // Check for product code already exists error
        if (errorMsg && errorMsg.toLowerCase().includes('product code already exists')) {
            $('#code').addClass('is-invalid');
            $('#code-error').html('Product code already exists');
        }
        
        // Check for warranty period error
        if (errorMsg && errorMsg.toLowerCase().includes('warranty period')) {
            $('#warranty_period').addClass('is-invalid');
            $('#warranty_period-error').html('Warranty period is required');
        }
        
        // Check for warranty type error
        if (errorMsg && errorMsg.toLowerCase().includes('warranty type')) {
            $('#warrantyType').addClass('is-invalid');
            $('#warrantyType-error').html('Warranty type is required');
        }
        
        // Handle image upload errors
        if (response.image_error) {
            toastr.error(response.image_error);
        }
    }
},
            error: function(xhr, status, error) {
                $('#loadingSpinner').fadeOut(200);
                console.error('Error:', error);
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    // Prevent Enter key from submitting form prematurely
    $(document).on('keypress', 'input, select', function(e) {
        if (e.which === 13 && e.target.tagName !== 'TEXTAREA' && !$(e.target).hasClass('select2-search__field')) {
            e.preventDefault();
            return false;
        }
    });
    
    /* ── Image Preview Functions ── */
    
    // Main image preview
    $('#main_image').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#main_image_preview').html(`
                    <div class="position-relative d-inline-block">
                        <img src="${e.target.result}" class="img-thumbnail" style="height: 120px; width: 120px; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-preview" style="border-radius: 50%;">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                `);
                
                // Remove preview functionality
                $('.remove-preview').on('click', function() {
                    $('#main_image_preview').empty();
                    $('#main_image').val('');
                });
            };
            reader.readAsDataURL(file);
        }
    });
    
    
    // Remove existing image (for edit mode)
    $('.remove-image').on('click', function() {
        const imageName = $(this).data('image');
        const $imageContainer = $(this).closest('.col-md-3');
        
        if (confirm('Are you sure you want to remove this image?')) {
            // Add hidden input to mark image for deletion
            $('<input>').attr({
                type: 'hidden',
                name: 'delete_images[]',
                value: imageName
            }).appendTo('#productForm');
            
            $imageContainer.fadeOut(300, function() {
                $(this).remove();
            });
            
            toastr.info('Image will be deleted when form is submitted');
        }
    });
});
</script>

</body>
</html>  