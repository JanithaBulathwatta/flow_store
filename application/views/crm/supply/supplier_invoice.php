    <style>
        :root {
            --primary: #5b5ea6;
            --primary-light: #eeeef7;
            --success: #1aaa6b;
            --success-light: #e3f6ef;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #0ea5e9;
            --info-light: #e0f2fe;
            --pink: #ec4899;
            --pink-light: #fce7f3;
            --body-bg: #f0f1f5;
            --card-bg: #ffffff;
            --sidebar-bg: #1e2139;
            --sidebar-width: 240px;
            --header-height: 60px;
            --text-default: #1e2139;
            --text-muted: #7b8191;
            --border-color: #e8e9f0;
            --font: 'DM Sans', sans-serif;
            --mono: 'DM Mono', monospace;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font);
            background: var(--body-bg);
            color: var(--text-default);
            font-size: 14px;
        }

        /* ── Sidebar stub ─────────────────────────── */
        .app-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 100;
            display: flex; flex-direction: column;
            transition: width .25s;
        }
        .sidebar-logo {
            height: var(--header-height);
            display: flex; align-items: center; gap: 10px;
            padding: 0 18px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            font-weight: 700; font-size: 17px; color: #fff;
            letter-spacing: -.3px;
        }
        .sidebar-logo span { color: var(--primary); }

        /* ── Header ───────────────────────────────── */
        .app-header {
            position: fixed; top: 0; left: var(--sidebar-width); right: 0;
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center;
            padding: 0 24px; gap: 12px;
            z-index: 99;
        }
        .header-title { font-weight: 600; font-size: 15px; color: var(--text-default); }
        .header-spacer { flex: 1; }
        .header-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--primary-light); color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; cursor: pointer;
        }

        /* ── Main content ─────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--header-height);
            min-height: 100vh;
        }
        .content-wrap { padding: 24px; }

        /* ── Breadcrumb ───────────────────────────── */
        .page-header-breadcrumb {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .page-title { font-size: 17px; font-weight: 700; }
        .breadcrumb { margin: 0; background: none; padding: 0; font-size: 12.5px; }
        .breadcrumb-item+.breadcrumb-item::before { content: "/"; color: var(--text-muted); }
        .breadcrumb-item a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb-item.active { color: var(--primary); }

        /* ── Stat cards ───────────────────────────── */
        .stat-cards { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card {
            background: var(--card-bg); border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 18px 20px;
            display: flex; align-items: center; gap: 14px;
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-label { font-size: 11.5px; color: var(--text-muted); margin-bottom: 3px; font-weight: 500; }
        .stat-value { font-size: 18px; font-weight: 700; line-height: 1; }
        .stat-sub { font-size: 11px; color: var(--text-muted); margin-top: 3px; }

        /* ── Card ─────────────────────────────────── */
        .custom-card {
            background: var(--card-bg); border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }
        .card-header-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap; gap: 10px;
        }
        .card-title-text { font-size: 14px; font-weight: 600; }

        /* ── Filter row ───────────────────────────── */
        .filter-row {
            display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
        }
        .filter-row input, .filter-row select {
            border: 1px solid var(--border-color); border-radius: 8px;
            padding: 6px 12px; font-size: 13px; font-family: var(--font);
            color: var(--text-default); background: #f8f8fc; outline: none;
            transition: border .2s;
        }
        .filter-row input:focus, .filter-row select:focus { border-color: var(--primary); }
        .filter-row input { width: 200px; }

        /* ── Btn ──────────────────────────────────── */
        .btn { font-family: var(--font); font-weight: 500; border: none; cursor: pointer; border-radius: 8px; transition: all .18s; }
        .btn-sm { font-size: 12.5px; padding: 5px 12px; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: #4e5192; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { background: #148f59; }
        .btn-outline-secondary { background: transparent; border: 1px solid var(--border-color); color: var(--text-muted); }
        .btn-outline-secondary:hover { background: var(--primary-light); color: var(--primary); }
        .btn-icon { width: 30px; height: 30px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 7px; font-size: 14px; }
        .btn-primary-light { background: var(--primary-light); color: var(--primary); }
        .btn-primary-light:hover { background: var(--primary); color: #fff; }
        .btn-success-light { background: var(--success-light); color: var(--success); }
        .btn-success-light:hover { background: var(--success); color: #fff; }
        .btn-warning-light { background: var(--warning-light); color: var(--warning); }
        .btn-warning-light:hover { background: var(--warning); color: #fff; }
        .btn-danger-light { background: var(--danger-light); color: var(--danger); }
        .btn-danger-light:hover { background: var(--danger); color: #fff; }
        .btn-info-light { background: var(--info-light); color: var(--info); }
        .btn-info-light:hover { background: var(--info); color: #fff; }

        /* ── Table ────────────────────────────────── */
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        thead th {
            background: #f8f8fc; padding: 11px 14px;
            font-size: 11.5px; font-weight: 600; text-transform: uppercase;
            letter-spacing: .5px; color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            position: sticky; top: 0;
        }
        tbody tr { border-bottom: 1px solid var(--border-color); transition: background .15s; }
        tbody tr:hover { background: #fafafe; }
        tbody td { padding: 12px 14px; font-size: 13px; vertical-align: middle; }
        tbody tr:last-child { border-bottom: none; }

        .form-check-input { width: 15px; height: 15px; cursor: pointer; accent-color: var(--primary); }

        /* invoice number pill */
        .inv-no {
            font-family: var(--mono); font-size: 12px; font-weight: 500;
            color: var(--primary); background: var(--primary-light);
            padding: 2px 8px; border-radius: 5px;
        }

        /* ── Badges ───────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11px; font-weight: 600; padding: 3px 9px;
            border-radius: 30px; letter-spacing: .2px;
        }
        .badge-success { background: var(--success-light); color: var(--success); }
        .badge-partial { background: var(--warning-light); color: #d97706; }
        .badge-unpaid { background: var(--danger-light); color: var(--danger); }
        .badge-cancelled { background: #f3f4f6; color: #9ca3af; }
        .badge-overdue { background: #fce7f3; color: var(--pink); }

        /* Aging pill */
        .aging-pill {
            font-size: 11px; font-weight: 600;
            padding: 2px 8px; border-radius: 20px;
            display: inline-block;
        }
        .aging-current { background: var(--success-light); color: var(--success); }
        .aging-soon { background: var(--warning-light); color: #d97706; }
        .aging-overdue { background: var(--danger-light); color: var(--danger); }

        /* supplier name */
        .supplier-name { font-weight: 600; font-size: 13px; color: var(--text-default); }
        .supplier-ref { font-size: 11.5px; color: var(--text-muted); margin-top: 1px; }

        /* amount cells */
        .amount { font-family: var(--mono); font-size: 12.5px; }
        .amount-total { font-weight: 600; }
        .amount-balance { color: var(--danger); font-weight: 600; }
        .amount-paid { color: var(--success); }

        /* ── Card footer pagination ───────────────── */
        .card-footer-bar {
            padding: 14px 20px; border-top: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 10px;
        }
        .pagination { display: flex; gap: 4px; list-style: none; margin: 0; padding: 0; }
        .page-item .page-link {
            width: 32px; height: 32px; display: flex; align-items: center;
            justify-content: center; border-radius: 7px; font-size: 13px;
            font-family: var(--font); font-weight: 500;
            border: 1px solid var(--border-color);
            color: var(--text-default); cursor: pointer;
            text-decoration: none; transition: all .15s;
        }
        .page-item.active .page-link { background: var(--primary); color: #fff; border-color: var(--primary); }
        .page-item .page-link:hover:not(.active) { background: var(--primary-light); color: var(--primary); }
        .page-item.disabled .page-link { color: #ccc; pointer-events: none; }

        /* ── Bulk action bar (hidden by default) ──── */
        .bulk-bar {
            display: none; align-items: center; gap: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, #4e5192 100%);
            color: #fff; padding: 10px 20px;
            font-size: 13px; font-weight: 500;
        }
        .bulk-bar.show { display: flex; }
        .bulk-bar .btn-bulk-pay {
            background: #fff; color: var(--primary); border-radius: 7px;
            padding: 6px 14px; font-size: 13px; font-weight: 600;
            cursor: pointer; border: none; font-family: var(--font);
            transition: all .15s;
        }
        .bulk-bar .btn-bulk-pay:hover { background: var(--primary-light); }
        .bulk-count { font-weight: 700; font-size: 14px; }

        /* ── Payment Modal ────────────────────────── */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(18,20,40,.5); backdrop-filter: blur(4px);
            z-index: 200; align-items: center; justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: #fff; border-radius: 16px;
            width: 560px; max-width: 95vw;
            max-height: 90vh; overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,.18);
            animation: slideUp .25s ease;
        }
        @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 22px; border-bottom: 1px solid var(--border-color);
        }
        .modal-title-text { font-size: 15px; font-weight: 700; }
        .modal-close {
            width: 30px; height: 30px; border-radius: 7px; border: none;
            background: var(--danger-light); color: var(--danger);
            font-size: 18px; cursor: pointer; display: flex;
            align-items: center; justify-content: center; transition: all .15s;
        }
        .modal-close:hover { background: var(--danger); color: #fff; }
        .modal-body-pad { padding: 20px 22px; }
        .modal-footer-bar {
            padding: 16px 22px; border-top: 1px solid var(--border-color);
            display: flex; justify-content: flex-end; gap: 10px;
        }

        /* form helpers */
        .form-label { font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .4px; margin-bottom: 5px; display: block; }
        .form-control {
            width: 100%; border: 1px solid var(--border-color); border-radius: 8px;
            padding: 8px 12px; font-family: var(--font); font-size: 13px;
            color: var(--text-default); background: #f9f9fc; outline: none;
            transition: border .2s;
        }
        .form-control:focus { border-color: var(--primary); background: #fff; }
        .mb-3 { margin-bottom: 14px; }
        .row { display: flex; gap: 12px; }
        .col-6 { flex: 1; min-width: 0; }
        .col-12 { flex: 0 0 100%; }

        /* payment method tabs */
        .pay-tabs { display: flex; gap: 6px; margin-bottom: 16px; }
        .pay-tab {
            flex: 1; padding: 9px 6px; border-radius: 9px; border: 1.5px solid var(--border-color);
            background: #f9f9fc; font-size: 12px; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            gap: 5px; transition: all .18s; color: var(--text-muted);
            font-family: var(--font);
        }
        .pay-tab.active { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }

        /* invoice allocation preview */
        .allocation-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .allocation-table th {
            background: #f4f4f8; padding: 7px 10px;
            font-size: 11px; font-weight: 700; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: .3px;
        }
        .allocation-table td { padding: 8px 10px; font-size: 12.5px; border-bottom: 1px solid #f0f0f5; }
        .allocation-table tr:last-child td { border-bottom: none; }
        .alloc-full { color: var(--success); font-weight: 600; }
        .alloc-partial { color: var(--warning); font-weight: 600; }
        .alloc-none { color: #bbb; }

        /* payment section cards */
        .pay-section { background: #f8f8fc; border-radius: 10px; padding: 14px 16px; margin-top: 14px; }
        .pay-section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); margin-bottom: 10px; }

        /* summary totals */
        .total-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 13px; }
        .total-row.grand { font-weight: 700; font-size: 14px; border-top: 1px dashed var(--border-color); margin-top: 4px; padding-top: 8px; }

        /* toast */
        .toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 8px; }
        .toast-item {
            background: #1e2139; color: #fff; padding: 12px 18px;
            border-radius: 10px; font-size: 13px; font-weight: 500;
            box-shadow: 0 8px 24px rgba(0,0,0,.2);
            display: flex; align-items: center; gap: 8px;
            animation: toastIn .3s ease;
        }
        @keyframes toastIn { from { transform: translateX(60px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* reference tag */
        .ref-tag {
            font-size: 11px; padding: 2px 7px; border-radius: 4px;
            font-weight: 600; display: inline-block;
        }
        .ref-grn { background: #e0f2fe; color: #0369a1; }
        .ref-manual { background: #ede9fe; color: #7c3aed; }

        /* Quick view detail row in modal */
        .detail-chip {
            display: inline-flex; align-items: center; gap: 4px;
            background: var(--primary-light); color: var(--primary);
            border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600;
            margin-right: 6px; margin-bottom: 6px;
        }

        @media (max-width: 768px) {
            .app-sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .app-header { left: 0; }
            .stat-cards { grid-template-columns: 1fr 1fr; }
        }
		
		// history modal CSS
		.history-timeline {
			max-height: 400px;
			overflow-y: auto;
			padding: 10px 5px;
		}
		.timeline-item:last-child {
			margin-bottom: 0;
		}
		.badge.bg-light {
			font-weight: 500;
			color: #444 !important;
		}
		
				
		/* CANCEL MODAL STYLES */
		.can-modal-overlay {
			position: fixed;
			top: 0; left: 0;
			width: 100%; height: 100%;
			background: rgba(0,0,0,0.35);
			display: flex;
			align-items: center;
			justify-content: center;
			z-index: 9999;
		}

		.can-modal-box {
			width: 260px;
			background: #fff;
			border-radius: 6px;
			box-shadow: 0 4px 14px rgba(0,0,0,0.2);
			overflow: hidden;
			font-family: Arial, sans-serif;
		}

		.can-modal-header {
			display:flex;
			justify-content:space-between;
			align-items:center;
			padding:8px 10px;
			border-bottom:1px solid #eee;
			font-size:13px !importeb;
			font-weight:600;
		}

		.can-modal-body {
			padding: 12px 10px;
			text-align: center;
		}

		.can-modal-footer {
			display: flex;
			gap: 6px;
			padding: 10px;
			border-top: 1px solid #eee;
		}

		.can-btn {
			flex: 1;
			padding: 6px 0;
			font-size: 12px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 4px;
		}

		.can-back { background: #e0e0e0; }

		/* Orange color for Cancel action */
		.can-confirm {
			background: rgb(46 142 247 / 90%); 
			color: #fff;
		}
		
		
    </style>
	
	
	<!-- ═══════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════════ -->
<div class="main-content">
    <div class="content-wrap">

        <!-- Breadcrumb -->
        <div class="page-header-breadcrumb">
            <h1 class="page-title">Purchase Invoice List</h1>
            <!--<nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Apps</a></li>
                    <li class="breadcrumb-item"><a href="#">Accounts Payable</a></li>
                    <li class="breadcrumb-item active">Invoice List</li>
                </ol>
            </nav>-->
        </div>

        <!-- ── Stat Cards ──────────────────────────── -->
        <div class="stat-cards">
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--primary-light);color:var(--primary)"><i class="ri-file-list-3-line"></i></div>
                <div>
                    <div class="stat-label">Total Invoices</div>
                    <div class="stat-value " id="statTotalCount">0</div>
                    <div class="stat-sub">This month</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--danger-light);color:var(--danger)"><i class="ri-money-dollar-circle-line"></i></div>
                <div>
                    <div class="stat-label">Outstanding</div>
                    <div class="stat-value" style="color:var(--danger)" id="statOutstandingSum">Rs0</div>
                    <div class="stat-sub" id="statOutstandingCount">0 unpaid invoices</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--warning-light);color:var(--warning)"><i class="ri-time-line"></i></div>
                <div>
                    <div class="stat-label">Overdue</div>
                    <div class="stat-value" style="color:#d97706" id="statOverdueSum">Rs0</div>
                    <div class="stat-sub" id="statOverdueCount">0 overdue invoices</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:var(--success-light);color:var(--success)"><i class="ri-checkbox-circle-line"></i></div>
                <div>
                    <div class="stat-label">Paid This Month</div>
                    <div class="stat-value" style="color:var(--success)" id="statPaidSum">Rs0</div>
                    <div class="stat-sub" id="statPaidCount">0 invoices cleared</div>
                </div>
            </div>
        </div>

        <!-- ── Invoice List Card ─────────────────── -->
        <div class="custom-card">
            <!-- Bulk action bar -->
            <div class="bulk-bar" id="bulkBar">
                <i class="ri-checkbox-multiple-line"></i>
                <span><span class="bulk-count" id="bulkCount">0</span> invoices selected</span>
                <span style="opacity:.6">|</span>
                <span>Total: <strong id="bulkTotal">Rs0.00</strong></span>
                <button class="btn-bulk-pay" onclick="openBulkPayModal()">
                    <i class="ri-bank-card-line" style="margin-right:4px"></i>Pay Selected
                </button>
                <button class="btn-bulk-pay" onclick="clearSelection()" style="margin-left:auto;background:rgba(255,255,255,.15);color:#fff">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <!-- Card header -->
            <div class="card-header-bar">
                <div class="card-title-text">All Supplier Invoices</div>
                <div class="filter-row">
                    <input type="text" placeholder="Search invoice / supplier…" id="searchInput" oninput="filterTable()">
                    <select onchange="filterTable()" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="partial">Partially Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <select onchange="filterTable()" id="agingFilter">
                        <option value="">All Aging</option>
                        <option value="Current">Current</option>
                        <option value="Due Soon">Due Soon</option>
                        <option value="Overdue">Overdue</option>
                    </select>
                    <button class="btn btn-sm btn-outline-secondary" onclick="filterTable()">
                        <i class="ri-filter-line"></i> Filter
                    </button>
                    <!--<a href="supplier-invoice-create.html" class="btn btn-sm btn-success">
                        <i class="ri-add-line"></i> New Invoice
                    </a>-->
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table id="invoiceTable">
                    <thead>
                        <tr>
                            <th style="width:38px"><input type="checkbox" class="form-check-input" id="checkAll" onclick="toggleAll(this)"></th>
                            <th>Invoice #</th>
                            <th>Supplier</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>                            
                            <th>Due Age</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceBody">
                        <!-- rows injected by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="card-footer-bar">
                <div style="font-size:13px;color:var(--text-muted)">
                    Showing <strong id="showingCount">1</strong> – <strong id="showingEnd">10</strong> of <strong id="totalCount">0</strong> invoices
                </div>
                <ul class="pagination" id="pagination"></ul>
            </div>
        </div>

    </div>
</div>

<!-- ═══════════════════════════════════════════
     PAYMENT MODAL
════════════════════════════════════════════ -->

<!-- new modifiation of payment maodal create at 05/08/2026 -->

<div class="modal-overlay" id="payModal">
    <div class="modal-box">
        <form id="paymentForm" method="POST">
            <!--<div class="modal-header-bar">
                <div class="modal-title-text" id="modalTitle">Make Payment</div>
                <button type="button" class="modal-close" onclick="closePayModal()"><i class="ri-close-line"></i></button>
            </div>-->
			
			<div class="modal-header-bar d-block">
				<div class="d-flex align-items-center justify-content-between w-100 mb-2">
					<div class="modal-title-text" id="modalTitle" style="margin-bottom: 0 !important;">Make Payment</div>
					<button type="button" class="modal-close" onclick="closePayModal()" style="position: static;"><i class="ri-close-line"></i></button>
				</div>
				
				<div class="d-flex align-items-center justify-content-between w-100 pt-1 border-top border-translucent">
					<div class="d-flex align-items-center gap-1">
						<span class="text-muted fs-12">Invoice:</span>
						<span class="badge bg-light text-dark border fs-12 fw-semibold" id="modalInvoiceNo"></span>
					</div>
					
					<div class="text-end">
						<span class="fs-15 text-muted fw-semibold me-1">Amount:</span>
						<span class="fs-15 fw-bold text-primary" id="modalInvoiceAmt">LKR 0.00</span>
					</div>
				</div>
			</div>
            
            <div class="modal-body-pad">

                <input type="hidden" name="payment_method" id="selectedPayMethod" value="cash">
				 <input type="hidden" name="selected_invoice_ids" id="selectedInvoiceIds">
				  <input type="hidden" name="supplier_id" id="supplier_id">
                
                <div id="selectedChips" style="margin-bottom:14px"></div>

                <div style="margin-bottom:4px">
                    <label class="form-label">Payment Method</label>
                </div>
                <div class="pay-tabs">
                    <button type="button" class="pay-tab active" name="method_btn" value="cash" onclick="setPayMode('cash',this)"><i class="ri-money-dollar-circle-line"></i>Cash</button>
                    <button type="button" class="pay-tab" name="method_btn" value="transfer" onclick="setPayMode('transfer',this)"><i class="ri-bank-transfer-line"></i>Bank Transfer</button>
                    <button type="button" class="pay-tab" name="method_btn" value="cheque" onclick="setPayMode('cheque',this)"><i class="ri-file-check-line"></i>Cheque</button>
                </div>
				            
                <div id="cashFields" class="pay-section mb-3">
				
					<div class="d-flex justify-content-end">
						<button type="button" class="modal-close close-payment" data-mode="cash" title="Clear Cash">
							<i class="ri-close-line"></i>
						</button>
					</div>
                    <div class="pay-section-title"><i class="ri-coin-line"></i> Cash Account</div>
					
                    <div class="mb-3">
					<div class="row">
						<div class="col-6 mb-3">
							<label class="form-label">Payment Date</label>
							<input type="date" class="form-control" id="cashPayDate" name="cash_payment_date" required>
						</div>
						
						<div class="col-6 mb-3">
							<label class="form-label">Amount</label>
							<input type="number" step="0.01" class="form-control" id="cashPayAmount" name="cash_payment_amount" placeholder="0.00" oninput="updateAllocation()" required>
						</div>
					</div>
                        <label class="form-label">Select Cash Account</label>
                        <!--<select class="form-control" name="cash_account_id" id="cash_account_id">
							<option value="">-- Choose Account --</option>
							<?php if (!empty($pay)): ?>
								<?php foreach ($pay as $acc): ?>
									<option value="<?= html_escape($acc->bank_acc_id) ?>">
										<?= html_escape($acc->account_name) ?> 
										(<?= html_escape($acc->account_number) ?>)
									</option>
								<?php endforeach; ?>
							<?php else: ?>
								<option value="" disabled>No Cash Accounts Found</option>
							<?php endif; ?>
						</select>-->
						<select class="form-control" name="cash_account_id" id="cash_account_id">
							<option value="">-- Choose Account --</option>
							<?php if (!empty($pay)): ?>
								<?php foreach ($pay as $acc): ?>
									<?php 
										$isSelected = (isset($default_account_id) && $acc->bank_acc_id == $default_account_id) ? 'selected' : ''; 
									?>
									<option value="<?= html_escape($acc->bank_acc_id) ?>" <?= $isSelected ?>>
										<?= html_escape($acc->account_name) ?> 
										(<?= html_escape($acc->account_number) ?>)
									</option>
								<?php endforeach; ?>
							<?php else: ?>
								<option value="" disabled>No Cash Accounts Found</option>
							<?php endif; ?>
						</select>
                    </div>
                </div>

                <div id="transferFields" class="pay-section mb-3" style="display:none">
					<div class="d-flex justify-content-end">
						<button type="button" class="modal-close close-payment" data-mode="transfer" title="Clear Transfer">
							<i class="ri-close-line"></i>
						</button>
					</div>
                    <div class="pay-section-title"><i class="ri-bank-line"></i> Bank Transfer</div>

                    <div class="row">
					               
							<div class="col-6 mb-3">
								<label class="form-label">Payment Date</label>
								<input type="date" class="form-control" id="transferPayDate" name="transfer_payment_date" required>
							</div>
							<div class="col-6 mb-3">
								<label class="form-label">Amount</label>
								<input type="number" step="0.01" class="form-control" id="transferPayAmount" name="transfer_payment_amount" placeholder="0.00" oninput="updateAllocation()" required>
							</div>
					</div>
					<div class="row">	
						<!--<div class="col-6 mb-3">
							<label class="form-label">Bank</label>
							<select class="form-control bankSelect" name="bank_name" id="transferBankSelect">
								<option value="">-- Select Bank --</option>
								<?php if (!empty($banks)): ?>
									<?php foreach ($banks as $bank): ?>
										<option value="<?= html_escape($bank->bank_name) ?>">
											<?= html_escape($bank->bank_name) ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>

						<div class="col-6 mb-3">
							<label class="form-label">Account</label>
							<select class="form-control accountSelect" name="transfer_bank_account_id" id="baccountSelect">
								<option value="">-- Select Account --</option>
								<?php if (!empty($banks_acc)): ?>
									<?php foreach ($banks_acc as $bank_ac): ?>
										<option value="<?= html_escape($bank_ac->bank_acc_id) ?>" 
												data-bank="<?= html_escape($bank_ac->bank_name) ?>" 
												class="acc-option" 
												style="display:none;">
											<?= html_escape($bank_ac->account_number) ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>-->
						<div class="col-12 mb-3">
						<label class="form-label">Bank</label>
							<select class="form-control accountSelect" name="transfer_bank_account_id" id="baccountSelect">
								<option value="">-- Select Account --</option>
								<?php if (!empty($banks_acc)): ?>
									<?php foreach ($banks_acc as $bank_ac): ?>
										<option value="<?= html_escape($bank_ac->bank_acc_id) ?>" 
												data-bank="<?= html_escape($bank_ac->bank_name) ?>" 
												class="acc-option">
											<?= html_escape($bank_ac->bank_name) ?> / <?= html_escape($bank_ac->account_number) ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>	
					</div>
					<div class="col-12 mb-3">
						<label class="form-label">Transaction Ref #</label>
						<input type="text" class="form-control" name="transfer_ref_no" placeholder="e.g. TXN-2024-0091">
					</div>
                   
                </div>

                <div id="chequeFields" class="pay-section mb-3" style="display:none">
				<div class="d-flex justify-content-end">
					<button type="button" class="modal-close close-payment" data-mode="cheque" title="Clear Cheque">
						<i class="ri-close-line"></i>
					</button>
				</div>
                    <div class="pay-section-title"><i class="ri-file-text-line"></i> Cheque Details</div>
					
						<div class="row">     
							<div class="col-6 mb-3">
								<label class="form-label">Cheque Number</label>
								<input type="text" class="form-control" id="cheque_no" name="cheque_no" placeholder="Enter CHQ-XXXXXX" required>
								<div id="cheque_msg" style="font-size: 11px; margin-top: 5px;"></div>
							</div>
							
							<div class="col-6 mb-3">
								<label class="form-label">Cheque Date</label>
								<input type="date" class="form-control" id="cheque_date" name="cheque_date" onchange="validateChequeDate()" required>
							</div>
						</div> 
						<div class="row">
							<div class="col-12 mb-3">
								<label class="form-label">Payee Name</label>
								<input type="text" class="form-control" id="Payee_nmae" name="Payee_name" placeholder="Enter Payee Name" required>
								<div id="cheque_msg" style="font-size: 11px; margin-top: 5px;"></div>
							</div>
						</div>	

						<div class="row">
							<div class="col-6 mb-3">
								<label class="form-label">Payment Date</label>
								<input type="date" class="form-control" id="chequePayDate" name="cheque_payment_date" required>
							</div>

							<div class="col-6 mb-3">
								<label class="form-label">Amount</label>
								<input type="number" step="0.01" class="form-control" id="chequePayAmount" name="cheque_payment_amount" placeholder="0.00" oninput="updateAllocation()" required>
							</div>
						</div>

						<div class="row">

						<label class="form-label">Cheque Meta Details (Auto)</label>
								<input type="text" class="form-control bg-light text-dark fw-bold" id="cheque_meta_details" name="cheque_meta_details" placeholder="Bank / Account / Book info..." readonly>
								<input type="hidden" id="hidden_account_id" name="account_id">
								<input type="hidden" id="hidden_bank_name" name="cheque_bank_name">
							
						</div>

						

                </div>

						<div class="mb-3">
							<label class="form-label">Notes (Optional)</label>
							<input type="text" class="form-control" name="payment_remarks" placeholder="Payment remarks…">
						</div>


                <!--<div id="allocationSection" style="display:none">
                    <div class="pay-section-title" style="margin-bottom:8px"><i class="ri-swap-line"></i> Allocation Preview</div>
                    <table class="allocation-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Balance</th>
                                <th>Allocated</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="allocationBody">
                            </tbody>
                    </table>
                </div>-->

                <div class="pay-section" style="margin-top:14px">
                    <div class="total-row">
                        <span>Total Selected</span>
                        <span class="amount" id="sumSelected">Rs0.00</span>
                        <input type="hidden" name="total_selected_sum" id="sumSelectedVal">
                    </div>
                    <div class="total-row">
                        <span>Payment Amount</span>
                        <span class="amount" id="sumPayment">Rs0.00</span>
                    </div>
                    <div class="total-row grand">
                        <span>Remaining After Payment</span>
                        <span class="amount" id="sumRemaining" style="color:var(--danger)">Rs0.00</span>
                        <input type="hidden" name="remaining_balance_after" id="sumRemainingVal">
                    </div>
                </div>

            </div>
            <div class="modal-footer-bar">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="closePayModal()">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary" id="btnConfirmPayment">
                    <i class="ri-check-line"></i>&nbsp;Confirm Payment
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ═══════════════════════════════════════════
     HISTORY MODAL
════════════════════════════════════════════ -->

<div class="modal-overlay" id="historyModal">
    <div class="modal-box" style="max-width: 600px; max-height: 90vh; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column;">
        
        <div class="modal-header-bar" style="padding: 15px 20px; background: #fff; border-bottom: 1px solid #eee; flex-shrink: 0;">
            <div class="modal-title-text" style="font-weight: 600; color: #333;">
                <i class="ri-history-line" style="margin-right: 8px; color: #3b82f6;"></i> 
                Invoice History: <span id="histInvoiceNo" style="color: #666;"></span>
            </div>
            <button type="button" class="modal-close" onclick="closeHistoryModal()"><i class="ri-close-line"></i></button>
        </div>
        
        <div class="modal-body-pad" style="padding: 20px; overflow-y: auto; flex-grow: 1;">
            
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded" style="background-color: #f8f9fa; border: 1px solid #edf2f7;">
                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px; margin-bottom: 2px;">Total Amount</small>
                    <strong id="histTotal" style="font-size: 1.25rem; color: #2d3748; line-height: 1.2;"></strong>
                </div>

                <div style="display: flex; flex-direction: column; align-items: flex-end; text-align: right;">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px; margin-bottom: 2px;">Current Balance</small>
                    <strong id="histBalance" class="text-danger" style="font-size: 1.25rem; line-height: 1.2;"></strong>
                </div>
            </div>

            <div class="history-timeline" id="historyTimeline" style="padding: 10px 5px;">
                </div>
        </div>

        <div class="modal-footer-bar" style="padding: 15px 20px; background: #f8f9fa; text-align: right; border-top: 1px solid #eee; flex-shrink: 0;">
            <button type="button" class="btn btn-secondary" onclick="closeHistoryModal()" style="padding: 6px 20px; font-size: 13px;">Close</button>
        </div>
    </div>
</div>


<!--Cancel modal-->
<div id="canModalOverlay" class="can-modal-overlay" style="display:none;">
    <div class="can-modal-box">
        <div class="can-modal-header">
            <span class="can-title">Cancel</span>
            <button class="can-close" style="border:none; background:none; cursor:pointer;">&times;</button>
        </div>

        <div class="can-modal-body">
            <h4 class="can-head">Cancel Item</h4>
            <p class="can-para">Are you sure?</p>
        </div>

        <div class="can-modal-footer">
            <button class="can-btn can-back">Close</button>
            <button class="can-btn can-confirm">
                <i class="ri-close-circle-line"></i> Confirm
            </button>
        </div>
    </div>
</div>

<!-- Toast container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ────────────────────────────────────────────────────────────
//  GLOBAL DATA & STATE
// ────────────────────────────────────────────────────────────
let invoices = [];       
let filteredData = [];   
let selectedIds = [];    
let payInvoiceIds = [];  

// Pagination settings
let currentPage = 1;
const perPage = 8;

$(document).ready(function () {
    
    loadInvoices();
	loadStats();

    // ────────────────────────────────────────────────────────────
    //  FORM SUBMISSION (Using your ajax_submit pattern)
    // ────────────────────────────────────────────────────────────
    $('#paymentForm').ajax_submit({
        url: '<?= site_url("Supply/process_payment"); ?>',
        rest: false,
        callback: function (res) {
            closePayModal();
            clearSelection();
            
            loadInvoices(); 
        }
    });

    // Search and Filter Listeners
    $('#invSearch, #invStatusFilter').on('keyup change', function() {
        applyFilters();
    });
	
	$(document).on('input', '#payAmount', function() {
        updateAllocation();
    });
});


function confirmPayment() {
    
    $('#paymentForm').submit();
}


function setPayMode(mode, el) {
    // 1. Force the active class to stay (don't use toggleClass)
    if (el) $(el).addClass('active');
    
    const sectionId = '#' + mode + 'Fields';
    const isHidden = $(sectionId).is(':hidden');

    // 2. Only run logic if the section is currently closed
    if (isHidden) {
        $(sectionId).show();
        setSectionRequired(mode, true);
        
        // Only validate/allocate when a new section is opened
        validateChequeDate();
        if (typeof updateAllocation === "function") {
            updateAllocation();
        }
    }
  
}

// Separate function to handle closing and clearing
function closePaymentSection(mode) {
    const sectionId = '#' + mode + 'Fields';
    
    // Hide the section
    $(sectionId).hide();
    
    $(sectionId).find('input, select').val('');
    
    setSectionRequired(mode, false);
    
    $(`.pay-tab[value="${mode}"]`).removeClass('active');
    
    if (typeof updateAllocation === "function") {
        updateAllocation();
    }
}

// Helper to manage "Required" logic
function setSectionRequired(mode, isRequired) {
    if (mode === 'cash') {
        $('input[name="cash_payment_date"], #cashPayAmount, #cash_account_id').prop('required', isRequired);
    } else if (mode === 'transfer') {
        // Use the new unique ID for transfer bank
        $('#transferPayDate, #transferPayAmount, #baccountSelect').prop('required', isRequired);
    } else if (mode === 'cheque') {
        // Use the new unique ID for cheque bank
        $('#chequePayDate, #chequePayAmount, #Payee_nmae, #cheque_no').prop('required', isRequired);
    }
}


// get the data-mode to the cancle function 
$('.close-payment').click(function(){
    const modeToClear = $(this).data('mode');

    $.confirmBox({
        title: 'Clear ' + modeToClear.toUpperCase(),
        head: 'Are you sure?',
        para: 'Current ' + modeToClear + ' data will be lost.',

        onConfirm: function(close){
            closePaymentSection(modeToClear); 
            close(); 
        }
    });
});


//clear sale
$('.clear-frm').click(function(){
    $.confirmBox({
        title: 'Clear All Payments',
        head: 'Are you sure?',
        para: 'All current payment data will be lost.',

        onConfirm: function(close){
            
            const modes = ['cash', 'transfer', 'cheque'];
            
            modes.forEach(function(mode) {
                closePaymentSection(mode);
            });

            close(); 
        }
    });
});

// ────────────────────────────────────────────────────────────
//  DATA FETCHING
// ────────────────────────────────────────────────────────────
function loadInvoices() {
    $.ajax({
        url: "<?= site_url('Supply/get_invoices'); ?>",
        type: "GET",
        dataType: "json",
        success: function (res) {
            invoices = res.data || [];
            filterTable(); 
        },
        error: function () {
            $('#invoiceBody').html('<tr><td colspan="13" class="text-center text-danger">Failed to load data.</td></tr>');
        }
    });
}


function loadStats() {
    $.ajax({
        url: "<?php echo site_url('Supply/get_stats'); ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            // Helper for currency formatting
            const fmt = (val) => 'Rs' + parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2});

            // Update Values
            $('#statTotalCount').text(res.total_count);
            
            $('#statOutstandingSum').text(fmt(res.outstanding_sum));
            $('#statOutstandingCount').text(res.outstanding_count + ' unpaid invoices');
            
            $('#statOverdueSum').text(fmt(res.overdue_sum));
            $('#statOverdueCount').text(res.overdue_count + ' overdue invoices');
            
            $('#statPaidSum').text(fmt(res.paid_month_sum));
            $('#statPaidCount').text(res.paid_month_count + ' invoices cleared');
        },
        error: function() {
            console.error('Failed to load invoice statistics');
        }
    });
}

// Helper to calculate aging status uniformly
function getAgingStatus(dueDateStr) {
    if (!dueDateStr) return 'Current';
    
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    const dueDate = new Date(dueDateStr);
    const timeDiff = today - dueDate;
    const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)); 

    // Positive daysDiff means the date has passed (Overdue)
    if (daysDiff > 0) return 'Overdue';
    if (daysDiff >= -3) return 'Due Soon'; 
    return 'Current';
}


function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const st = document.getElementById('statusFilter').value;
    const ag = document.getElementById('agingFilter').value;

    filteredData = invoices.filter(inv => {
        const matchQ = !q || 
                       inv.invoice_number?.toLowerCase().includes(q) || 
                       inv.supplier_name?.toLowerCase().includes(q);

        const matchSt = !st || inv.status.toLowerCase() === st.toLowerCase();

        // Use the helper here
        const currentInvAging = getAgingStatus(inv.due_date);
        const matchAg = !ag || currentInvAging === ag;

        return matchQ && matchSt && matchAg;
    });

    currentPage = 1;
    renderTable();
}


// ────────────────────────────────────────────────────────────
//  TABLE RENDERING
// ────────────────────────────────────────────────────────────


function renderTable() {
    const tbody = document.getElementById('invoiceBody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    const start = (currentPage - 1) * perPage;
    const end = start + perPage;
    const pageData = filteredData.slice(start, end);

    if (pageData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="13" style="text-align:center;padding:30px;color:var(--text-muted)"><i class="ri-file-search-line" style="font-size:24px;display:block;margin-bottom:6px"></i>No invoices found</td></tr>`;
        return;
    }

    pageData.forEach(inv => {
        // Data Mapping from DB Columns
        const total = parseFloat(inv.grand_total) || 0;
        const paid = parseFloat(inv.paid_amount) || 0;
        const balance = parseFloat(inv.balance_amount) || 0;
        const dbStatus = inv.status.toLowerCase(); 

        // 1. Status Badge Logic
        const statusBadge = {
            'paid': `<span class="badge badge-success"><i class="ri-check-line"></i>Paid</span>`,
            'partial': `<span class="badge badge-partial"><i class="ri-refresh-line"></i>Partial</span>`,
            'unpaid': `<span class="badge badge-unpaid"><i class="ri-time-line"></i>Unpaid</span>`,
            'cancelled': `<span class="badge badge-cancelled"><i class="ri-ban-line"></i>Cancelled</span>`,
        }[dbStatus] || '';

		
		const dueAgeStatus = getAgingStatus(inv.due_date);
		
		const dueAgeBadge = {
        'Current': `<span class="aging-pill aging-current">Current</span>`,
        'Due Soon': `<span class="aging-pill aging-soon">Due Soon</span>`,
        'Overdue': `<span class="aging-pill aging-overdue">Overdue</span>`,
		}[dueAgeStatus] || '';

        // 3. Invoice Aging (How old the invoice is since created_at)
        const invAgeStatus = inv.invoice_age > 30 ? 'Overdue' : (inv.invoice_age > 15 ? 'Due Soon' : 'Current');
        const invAgeBadge = {
            'Current': `<span class="aging-pill aging-current">Recent</span>`,
            'Due Soon': `<span class="aging-pill aging-soon">Aging</span>`,
            'Overdue': `<span class="aging-pill aging-overdue">Old</span>`,
        }[invAgeStatus] || '';

        
        const canPay = dbStatus !== 'paid' && dbStatus !== 'cancelled';

        tbody.innerHTML += `
        <tr class="invoice-row" data-status="${dbStatus}" data-id="${inv.id}">
            <td><input type="checkbox" class="form-check-input row-check" data-id="${inv.id}" data-supplier="${inv.supplier_id}" ${!canPay?'disabled':''} onclick="handleRowCheck(this)"></td>
            <td><span class="inv-no">${inv.invoice_number}</span></td>
            <td>
                <div class="supplier-name">${inv.supplier_name}</div>
                <div class="supplier-ref">${inv.source_type.toUpperCase()} · ${inv.reference_number || 'N/A'}</div>
            </td>
            <td style="color:var(--text-muted);font-size:12.5px">${inv.invoice_date}</td>
            <td style="color:${dueAgeStatus === 'Overdue' ? 'var(--danger)' : (dueAgeStatus === 'Due Soon' ? '#d97706' : 'var(--text-muted)')}; font-size:12.5px; font-weight:${dueAgeStatus !== 'Current' ? '600' : '400'}">
                ${inv.due_date || '-'}
            </td>
            <td class="amount amount-total">${total.toLocaleString()}</td>
            <td class="amount amount-paid">${paid.toLocaleString()}</td>
            <td class="amount amount-balance">${balance > 0 ?  balance.toLocaleString() : '—'}</td>
            <td>${statusBadge}</td>            
            <td>${dueAgeBadge}</td>
            <td>
                <div style="display:flex;gap:4px">
                    <a href="/Supply/supplier_profile?id=${inv.supplier_id}" 
					   class="btn btn-icon btn-primary-light" 
					   title="View">
					   <i class="ri-eye-line"></i>
					</a>
                    ${canPay ? `<button class="btn btn-icon btn-success-light" title="Pay Now" onclick="openSinglePayModal(${inv.id})"><i class="ri-bank-card-line"></i></button>` : ''}
                    <button class="btn btn-icon btn-info-light" title="History" onclick="openHistoryModal(${inv.id})"><i class="ri-history-line"></i></button>
                    
                </div>
            </td>
        </tr>`;
    });

    // Update Pagination Text
    document.getElementById('showingCount').textContent = filteredData.length > 0 ? start + 1 : 0;
    document.getElementById('showingEnd').textContent = Math.min(end, filteredData.length);
    document.getElementById('totalCount').textContent = filteredData.length;
    
    if (typeof renderPagination === "function") renderPagination();
}

// ────────────────────────────────────────────────────────────
//  PAYMENT MODAL LOGIC
// ────────────────────────────────────────────────────────────
function openSinglePayModal(id) {
    payInvoiceIds = [id];
    _openPayModal();
}

function openBulkPayModal() {
    payInvoiceIds = [...selectedIds];
    _openPayModal();
}

function _openPayModal() {
    // Get the first invoice to extract the supplier_id
    const firstInv = invoices.find(i => i.id == payInvoiceIds[0]);
    if (firstInv) {
        document.getElementById('supplier_id').value = firstInv.supplier_id;
    }
    
    // 1. VALIDATION: Check if IDs exist
    if (!payInvoiceIds || payInvoiceIds.length === 0) {
        alert("Please select at least one invoice.");
        return;
    }

    // 2. Assign the IDs to hidden input field
    document.getElementById('selectedInvoiceIds').value = payInvoiceIds.join(',');

    // 3. Calculate Total Balance
    const totalBal = payInvoiceIds.reduce((s, id) => {
        const inv = invoices.find(i => i.id == id);
        return s + (inv ? parseFloat(inv.balance_amount) : 0);
    }, 0);

    const today = new Date().toISOString().split('T')[0];
    
    // 4. Set Dates
    document.getElementById('cashPayDate').value = today;
    document.getElementById('transferPayDate').value = today;
    document.getElementById('chequePayDate').value = today;

    // 5. Reset Amounts to 0 first to prevent carry-over
    document.getElementById('cashPayAmount').value = totalBal.toFixed(2);
    document.getElementById('transferPayAmount').value = "0.00"; 
    document.getElementById('chequePayAmount').value = "0.00";

	// 6. Update UI Total Display
		const formattedAmountStr = 'LKR ' + totalBal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
		document.getElementById('sumSelected').textContent = formattedAmountStr;

		// ─── NEW MODAL HEADER INJECTION ───
		const invoiceNoBadge = document.getElementById('modalInvoiceNo');
		const invoiceAmtDisplay = document.getElementById('modalInvoiceAmt');

		if (invoiceNoBadge && invoiceAmtDisplay) {
			// Set Header Amount display matching your new currency layout
			invoiceAmtDisplay.textContent = formattedAmountStr;

			// Set Invoice Number text depending on single vs multiple select
			if (payInvoiceIds.length === 1 && firstInv) {
				// If your invoice object property is named something else like invoice_no, change it here
				invoiceNoBadge.textContent = firstInv.invoice_number ? '#' + firstInv.invoice_number : '#INV-' + firstInv.id;
			} else {
				invoiceNoBadge.textContent = 'Multiple (' + payInvoiceIds.length + ' Invoices)';
			}
		}
	// ──────────────────────────────────


    // --- NEW LOGIC START ---
    
    // 7. Reset the Tab UI (Clear previous active states)
    document.querySelectorAll('.pay-tab').forEach(t => t.classList.remove('active'));
    
    // 8. Hide Transfer and Cheque sections by default when opening
    $('#transferFields').hide();
    $('#chequeFields').hide();
    
    // 9. Force Open the Cash section
    // We find the cash button element to pass it to our setPayMode function
    const cashBtn = document.querySelector('.pay-tab[value="cash"]');
    
    // Explicitly show the cash fields
    $('#cashFields').show();
    if (cashBtn) cashBtn.classList.add('active');
    
    // Ensure "Required" attributes are set for Cash
    setSectionRequired('cash', true); 
    setSectionRequired('transfer', false);
    setSectionRequired('cheque', false);

    // --- NEW LOGIC END ---

    // 10. Trigger the allocation logic
    if (typeof updateAllocation === "function") {
        updateAllocation();
    }

    // 11. Show Modal
    document.getElementById('payModal').classList.add('show');
}

// Global variable to track cheque status
let isChequeValid = false; 

function updateAllocation() {
    // 1. Get amounts from ALL fields (Removed .is(':visible') check)
    // This allows split payments (e.g., some cash + some transfer)
    const cashAmt     = parseFloat(document.getElementById('cashPayAmount')?.value) || 0;
    const transferAmt = parseFloat(document.getElementById('transferPayAmount')?.value) || 0;
    const chequeAmt   = parseFloat(document.getElementById('chequePayAmount')?.value) || 0;
    
    // 2. Total combined payment amount
    const totalEntered = cashAmt + transferAmt + chequeAmt;
    const btn = document.getElementById('btnConfirmPayment');
    
    // 3. Calculate Total Balance of selected invoices
    // We use the global payInvoiceIds array
    const totalBal = payInvoiceIds.reduce((s, id) => {
        const inv = invoices.find(i => i.id == id);
        return s + (inv ? parseFloat(inv.balance_amount) : 0);
    }, 0);

    // 4. Validation Logic
    let errorMessage = "";
    let isInvalid = false;

    if (totalEntered <= 0) {
        isInvalid = true; 
    } else if (totalEntered > (totalBal + 0.01)) {
        isInvalid = true;
        errorMessage = "Amount exceeds balance!";
    } 
    
    // 5. Specific Cheque Validation (Only if cheque amount is entered)
    if (chequeAmt > 0 && !isChequeValid) {
        isInvalid = true;
        errorMessage = "Invalid Cheque Details";
    }

    // 6. Update UI
    const remainingDisp = document.getElementById('sumRemaining');
    const paymentDisp   = document.getElementById('sumPayment');
    const selectedDisp  = document.getElementById('sumSelected');

    paymentDisp.textContent = 'Rs ' + totalEntered.toLocaleString(undefined, {minimumFractionDigits: 2});
    selectedDisp.textContent = 'Rs ' + totalBal.toLocaleString(undefined, {minimumFractionDigits: 2});

    if (isInvalid) {
        btn.disabled = true;
        remainingDisp.textContent = errorMessage;
        remainingDisp.style.color = "red";
    } else {
        btn.disabled = false;
        const remaining = Math.max(0, totalBal - totalEntered);
        remainingDisp.textContent = 'Rs ' + remaining.toLocaleString(undefined, {minimumFractionDigits: 2});
        remainingDisp.style.color = "var(--danger)"; 
        
        // Update hidden field for backend
        document.getElementById('sumRemainingVal').value = remaining.toFixed(2);
    }
}



// ────────────────────────────────────────────────────────────
//  OTHER ACTIONS
// ────────────────────────────────────────────────────────────
function viewInvoice(id) {
    const inv = invoices.find(i=>i.id===id);
    showToast(`Viewing ${inv.no} – ${inv.supplier}`, 'ri-eye-line');
}

function cancelInvoice(id) {
    const inv = invoices.find(i=>i.id===id);
    if (confirm(`Cancel invoice ${inv.no}?`)) {
        inv.status = 'Cancelled';
        renderTable();
        showToast(`${inv.no} cancelled`, 'ri-ban-line', '#ef4444');
    }
}


function validateChequeDate() {
    const method = document.getElementById('selectedPayMethod').value;
    const dateInput = document.getElementsByName('cheque_date')[0]; 
    const btn = document.getElementById('btnConfirmPayment');
    
    if (method === 'cheque' && dateInput.value) {
        const selectedDate = new Date(dateInput.value);
        selectedDate.setHours(0,0,0,0);
        
        const today = new Date();
        today.setHours(0,0,0,0);

        if (selectedDate < today) {            
            dateInput.value = ""; 
            btn.disabled = true;
        } else {
            btn.disabled = false;
        }
    }
}

function closePayModal() {
    document.getElementById('payModal').classList.remove('show');
}


// ────────────────────────────────────────────────────────────
//  HISTORY MODAL LOGIC
// ────────────────────────────────────────────────────────────

function openHistoryModal(id) {
    const inv = invoices.find(i => i.id == id);
    if (!inv) return;

    // Set Header Details
    $('#histInvoiceNo').text(inv.invoice_number);
    $('#histTotal').text('$' + parseFloat(inv.grand_total).toLocaleString(undefined, {minimumFractionDigits: 2}));
    $('#histBalance').text('$' + parseFloat(inv.balance_amount).toLocaleString(undefined, {minimumFractionDigits: 2}));

    $.ajax({
        url: "<?php echo site_url('Supply/view_history?invId='); ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(data) {
            let html = '';
            if (!data || data.length === 0) {
                html = `
                    <div class="text-center p-5">
                        <i class="ri-file-search-line" style="font-size: 40px; color: #cbd5e0; display: block; margin-bottom: 10px;"></i>
                        <div class="text-muted">No history found for this invoice.</div>
                    </div>`;
            } else {
                data.forEach((log, index) => {
                    const date = new Date(log.created_at).toLocaleString('en-US', { 
                        year: 'numeric', month: 'short', day: 'numeric', 
                        hour: '2-digit', minute: '2-digit' 
                    });
                    
                    let icon = 'ri-information-line';
                    let color = '#a0aec0';
                    let actionText = log.action.replace('_', ' ');

                    // Specific styling for actions
                    if(log.action.toLowerCase().includes('paid')) { 
                        icon = 'ri-checkbox-circle-fill'; 
                        color = '#10b981'; 
                    } else if(log.action === 'cancelled') { 
                        icon = 'ri-close-circle-line'; 
                        color = '#ef4444'; 
                    } else if(log.action.toLowerCase().includes('allocated')) {
                        icon = 'ri-arrow-left-right-line';
                        color = '#3b82f6';
                    }

                    html += `
                    <div class="timeline-item" style="border-left: 2px solid #e2e8f0; padding-left: 25px; position: relative; padding-bottom: 25px;">
                        <div style="position: absolute; left: -11px; top: 0; background: #fff; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="${icon}" style="color: ${color}; font-size: 20px;"></i>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span style="font-weight: 600; color: #2d3748; text-transform: capitalize;">${actionText}</span>
                            <span style="font-size: 11px; color: #a0aec0;">${date}</span>
                        </div>
                        
                        <p class="mb-2" style="font-size: 13px; color: #4a5568; line-height: 1.5;">${log.note || 'Internal transaction update'}</p>
                        
						${log.payment_method ? `
							<div class="mt-2">
								<span style="font-size: 11px; background: #ebf4ff; color: #3182ce; padding: 3px 10px; border-radius: 4px; border: 1px solid #bee3f8; font-weight: 500; display: inline-flex; align-items: center;">
									<i class="${log.payment_method === 'cheque' ? 'ri-file-list-3-line' : (log.payment_method === 'cash' ? 'ri-money-dollar-circle-line' : 'ri-bank-line')}" style="margin-right: 4px;"></i>
									
									<span style="text-transform: uppercase; margin-right: 4px;">${log.payment_method}</span>

									${log.payment_method === 'cheque' && log.cheque_no ? 
										`<span style="color: #63b3ed; margin-left: 2px;">(No: ${log.cheque_no})</span>` : ''}
									
									${log.payment_method === 'transfer' && log.reference_no ? 
										`<span style="color: #63b3ed; margin-left: 2px;">(Ref: ${log.reference_no})</span>` : ''}
									
									${log.payment_method === 'cash' ? 
										`<span style="color: #63b3ed; margin-left: 2px;">(Handover)</span>` : ''}
								</span>
							</div>
						` : ''}
                        
                        <div style="font-size: 11px; color: #a0aec0; margin-top: 8px;">
                            <i class="ri-user-line" style="margin-right: 4px;"></i>By: <span style="color: #000000;">${log.staff_name || 'System'}</span></br>
							<i class="ri-money-dollar-circle-line" style="margin-right: 4px;"></i>Amount: <span style="color: #000000;">${log.allocated_amount}</span>
                        </div>
                    </div>`;
                });
            }
            $('#historyTimeline').html(html);
            $('#historyModal').addClass('show');
        }
    });
}

function closeHistoryModal() {
    $('#historyModal').removeClass('show');
}


// cancel function 
function cancelInvoice(id) {
    $('#canModalOverlay').can_modal({
        title : 'Cancel Invoice',
        head : 'Cancel Invoice: ' + id, 
        para  : 'Are you sure you want to cancel this invoice?',
        id    : id,
        url   : '<?= site_url("Supply/cancel_invoice?id="); ?>' + id,
        callback : function(res){
            if(res) {
    
                loadInvoices(); 
                loadStats();    
            }
        }
    });
}



// ────────────────────────────────────────────────────────────
//  SELECTION & UTILS
// ────────────────────────────────────────────────────────────
/*function handleRowCheck() {
    selectedIds = [];
    document.querySelectorAll('.row-check:checked').forEach(cb => selectedIds.push(+cb.dataset.id));
    
    const total = selectedIds.reduce((s, id) => {
        const inv = invoices.find(i => i.id == id);
        return s + (inv ? parseFloat(inv.balance_amount) : 0);
    }, 0);

    document.getElementById('bulkBar').classList.toggle('show', selectedIds.length > 0);
    document.getElementById('bulkCount').textContent = selectedIds.length;
    document.getElementById('bulkTotal').textContent = 'RS ' + total.toLocaleString();
}*/

function handleRowCheck(checkbox) {
    // 1. Get all currently checked checkboxes
    const checkedCheckboxes = document.querySelectorAll('.row-check:checked');
    
    // 2. SAME CUSTOMER VALIDATION
    if (checkedCheckboxes.length > 1) {
        const firstCustomerId = checkedCheckboxes[0].getAttribute('data-supplier');
        const currentCustomerId = checkbox.getAttribute('data-supplier');

        if (currentCustomerId !== firstCustomerId) {
            // Uncheck the box if it's a different customer
            checkbox.checked = false;
            
            return; // Stop execution here
        }
    }

    // 3. RE-CALCULATE TOTALS (Only if validation passed)
    selectedIds = [];
    checkedCheckboxes.forEach(cb => selectedIds.push(+cb.dataset.id));
    
    const total = selectedIds.reduce((s, id) => {
        const inv = invoices.find(i => i.id == id);
        return s + (inv ? parseFloat(inv.balance_amount) : 0);
    }, 0);

    // 4. SHOW/HIDE THE BULK BAR
    const bulkBar = document.getElementById('bulkBar');
    if (bulkBar) {
        bulkBar.classList.toggle('show', selectedIds.length > 0);
        document.getElementById('bulkCount').textContent = selectedIds.length;
        document.getElementById('bulkTotal').textContent = 'RS ' + total.toLocaleString();
    }
}

function clearSelection() {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = false);
    selectedIds = [];
    handleRowCheck();
}

</script>


<!-- new update if user select a Cheque Number the   -->
<script>
$(document).ready(function() {
    let typingTimer;
    const doneTypingInterval = 500;

    // Trigger lookup when typing in Cheque Number field
    $(document).on('keyup', '#cheque_no', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(checkChequeDetails, doneTypingInterval);
    });

    function checkChequeDetails() {
        const chequeNo = $('#cheque_no').val().trim();
        const submitBtn = $('#btnConfirmPayment');
        const msgContainer = $('#cheque_msg');
        const metaField = $('#cheque_meta_details');
        
        // Clear previous state inputs
        metaField.val('');
        $('#hidden_account_id').val('');
        $('#hidden_bank_name').val('');

        if (chequeNo.length > 0) {
            msgContainer.html('<span class="text-muted"><i class="ri-loader-4-line btn-loader"></i> Finding Leaf...</span>');

            $.ajax({
                url: "<?php echo site_url('Supply/check_cheque_availability'); ?>",
                type: "POST",
                data: { cheque_no: chequeNo },
                dataType: "json",
                success: function(response) {
                    if (response.available === true || response.available === "true") {
                        msgContainer.html('<span class="text-success"><i class="ri-check-line"></i> Valid Unused Cheque</span>');
                        
                        // Set composite view text format: Bank Name / Account No / Book ID
                        const displayDetails = response.bank_name + " / " + response.account_number + " / Book #" + response.cheque_book_id;
                        metaField.val(displayDetails);

                        // Save the raw technical values back to hidden form state items
                        $('#hidden_account_id').val(response.bank_account_id);
                        $('#hidden_bank_name').val(response.bank_name);

                        isChequeValid = true; 
                        submitBtn.prop('disabled', false).removeAttr('disabled');
                    } else {
                        msgContainer.html('<span class="text-danger"><i class="ri-error-warning-line"></i> ' + (response.message || 'Cheque invalid or already used') + '</span>');
                        isChequeValid = false; 
                        submitBtn.prop('disabled', true);
                    }

                    if(typeof updateAllocation === "function") {
                        setTimeout(updateAllocation, 100);
                    }
                },
                error: function() {
                    msgContainer.html('<span class="text-danger">Error verifying cheque details</span>');
                }
            });
        } else {
            submitBtn.prop('disabled', true);
            msgContainer.html('<span class="text-warning">Enter a Cheque Number to pull tracking data</span>');
        }
    }
});
</script>