<style>
		/* kalhara 26.5.5*/
        /* ── Payment Modal ────────────────────────── */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(18,20,40,.5); backdrop-filter: blur(4px);
            z-index: 200; align-items: center; justify-content: center;
        }
		
		@keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 22px; border-bottom: 1px solid var(--border-color);
        }
		.modal-box {
            background: #fff; border-radius: 16px;
            width: 560px; max-width: 95vw;
            max-height: 90vh; overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,.18);
            animation: slideUp .25s ease;
        }
		.modal-title-text { font-size: 15px; font-weight: 700; }
		.modal-close {
            width: 30px; height: 30px; border-radius: 7px; border: none;
            background: var(--danger-light); color: var(--danger);
            font-size: 18px; cursor: pointer; display: flex;
            align-items: center; justify-content: center; transition: all .15s;
        }
		 .modal-body-pad { padding: 20px 22px; }
		.pay-tabs { display: flex; gap: 6px; margin-bottom: 16px; }
		.modal-footer-bar {
            padding: 16px 22px; border-top: 1px solid var(--border-color);
            display: flex; justify-content: flex-end; gap: 10px;
        }
		
		.modal-overlay.show {
			display: flex !important;
		}



	/* -- santhosh 05/06/2026 -- */	/* -- addimg missing payment css styles -- */
	
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
	
	.me-6 {
		margin-right: 1rem !important;
		margin-left: 6px !important;
	}
	
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

</style>


<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-12 mt-3">
				<div class="card custom-card card-bg mb-20">
					<div class="card-body"> 
						<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
							<div class="d-flex align-items-center"> 
								<span class="card-title me-6">Sales invoice List </span>
								<!--<div class="d-flex gap-2 flex-wrap" id="lead-status-container"></div>-->
								<div class="d-flex gap-2 flex-wrap align-items-center" id="lead-status-container">
									<!-- Total GRN Pill -->
									<!--<div id="pill-total" class="stat-pill status-filter" data-status="" style="cursor: pointer;">
										<span class="num" id="val-total">0</span>
										<span class="lbl">Total salesInvoices</span>
									</div>

									<!-- Settled GRN Pill -->
									<!--<div id="pill-settled" class="stat-pill status-filter" data-status="settled" style="cursor: pointer;">
										<span class="num" id="val-settled">0</span>
										<span class="lbl">Settled salesInvoices</span>
									</div>

									<!-- Outstanding GRN Pill -->
									<!--<div id="pill-outstanding" class="stat-pill status-filter" data-status="outstanding" style="cursor: pointer;">
										<span class="num" id="val-outstanding">0</span>
										<span class="lbl">Outstanding  salesInvoices</span>
									</div>
									
									<!-- Total Due -->
									<!--<div id="pill-outstanding" class="stat-pill status-filter" data-status="outstanding" style="cursor: pointer;">
										<!--<span class="num" id="totalDueAmount">0</span>-->
										<!--<span class="lbl">Total Due</span>
									</div>
									
									<!-- Sale Total -->
									<!--<div id="pill-outstanding" class="stat-pill status-filter" data-status="outstanding" style="cursor: pointer;">
										<!--<span class="num" id="totalAmount">0</span>-->
										<!--<span class="lbl">Sale total</span>
									</div>-->
								</div>
							</div> 
							
							<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<a href="/Sale_invoice"> 
									<button class="btn btn-add">
										<i class="ri-add-line me-1 fw-medium align-middle"></i> New Sale
									</button>
								</a>
							</div> 
						</div> 
					</div>
				</div>
				
				<div class="summary-bar" id="summary-bar">
				
				</div>
				
			</div>
		
			<div class="col-xl-12">
				<form id="data-filter">
					<div class="card mb-3">
						<div class="card-body row g-3">
							
						
						<!-- 🌟 New Info Message Container (Hidden by default) -->
						<div id="project-info-message" class="d-none p-2 text-center" style="background-color: #eef2f7; border-radius: 6px; border-left: 4px solid #5b5ea6;">
							<p class="mb-0 fw-medium text-dark" style="font-size: 14px;">
								<i class="ri-information-line me-1 align-middle" style="color: #5b5ea6; font-size: 16px;"></i> 
								Showing information of the project
							</p>
						</div>
							
						<div id="filter-inputs-row" class="row g-3">
							<!-- Date Range - Keep original working code -->
							<div class="col-md-3">
								<label class="text-black-normal label mb-1">Date Range</label>
								<input type="text" class="date-range-input daterangepicker-field form-control-sm w-100" 
									   placeholder="Select Date Range" 
									   data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" />
							</div>
							
							<!-- Select Staff -->
							<div class="col-md-3">
								<label class="text-black-normal label mb-1">Select Staff</label>
								<select id="user" name="fk_user_id" class="form-control form-select form-select-sm js-example-basic-single w-100">
									<option value=""> Select Staff </option>
									<?php foreach ($staff as $staff): ?>
										<option value="<?= $staff->staff_id; ?>"><?= html_escape($staff->full_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<!-- Invoice Status -->
							<div class="col-md-3">
								<label class="text-black-normal label mb-1">Invoice Status</label>
								<select id="invoice_status" name="invoice_status" class="form-control form-select form-select-sm js-example-basic-single w-100">
									<option value=""> All Status </option>
									<option value="DRAFT">Draft</option>
									<option value="COMPLETED">Completed</option>
									<option value="CANCELLED">Cancelled</option>
									<option value="RETURNED">Returned</option>
									<option value="PROJECT">project</option>
								</select>
							</div>
							
							<!-- Search Button -->
							<div class="col-md-3">
								<label class="text-black-normal label mb-1">&nbsp;</label>
								<button type="submit" class="btn btn-search w-100" style="background: #5b5ea6; color: white; border: none; padding: 6px 12px; border-radius: 6px; display: block">
									Search
								</button>
							</div>
						</div>	
					</div>
				</div>
			</form>
		</div>
		
            <div class="col-xl-12">

                <div class="card custom-card">
				
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

                    <!-- HEADER 
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!--<div class="card-title"> Sales invoice List </div>
                    
						<div class="d-flex gap-4">
							<div>
								<strong>Total Due :</strong>
								<span id="totalDueAmount">0 </span>
							</div>
							<div>
								<strong>Sale Total :</strong>
								<span id="totalAmount">0 </span>
							</div>
						</div>
					
					</div>-->

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="sales_inv_table" class="table table-stripe text-nowrap w-100 dataTable no-footer">

                                <thead>
                                <tr>
                                    <th style="width:38px"><input type="checkbox" class="form-check-input" id="checkAll" onclick="toggleAll(this)"></th>
                                    <th>Invoice no</th>
                                    <th>Customer</th>
                                    <th>Invoice Date</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    <th>Grand Total</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th class="text-center">Item Info</th>
                                </tr>
                                </thead>
								
                                <tbody></tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════
     PAYMENT MODAL									Supplier_invoice -> sales_list (pasted) santhosh
════════════════════════════════════════════ -->

<div class="modal-overlay" id="payModal">
    <div class="modal-box">
        <form id="paymentForm" method="POST">
            <!--<div class="modal-header-bar">
                <div class="modal-title-text" id="modalTitle">Make Payment</div>
                <button type="button" class="modal-close" onclick="closePayModal()"><i class="ri-close-line"></i></button>
            </div>-->
			
			<div class="modal-header-bar d-block">
				<div class="d-flex align-items-center justify-content-between w-100 mb-2">
					<div class="modal-title-text" id="modalTitle" style="margin-bottom: 0 !important;">Record Payment</div>
					<button type="button" class="modal-close" onclick="closePayModal()" style="position: static;"><i class="ri-close-line"></i></button>
				</div>
				
				<div class="d-flex align-items-center justify-content-between w-100 pt-1 border-top border-translucent">
					<div class="d-flex align-items-center gap-1">
						<span class="text-muted fs-12">Invoice:</span>
						<span class="badge bg-light text-dark border fs-12 fw-bold text-primary" id="modalInvoiceNo"></span>
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
                        <label class="form-label">Select Receiver Cash Account</label>
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
						</div>-->

						<div class="col-12 mb-3">
							<label class="form-label">Receiver Account</label>
							<!--<select class="form-control accountSelect" name="transfer_bank_account_id" id="baccountSelect">
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
							</select>-->
							
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
								<label class="form-label">Payment Date</label>
								<input type="date" class="form-control" id="chequePayDate" name="cheque_payment_date" required>
							</div>
							<div class="col-6 mb-3">
								<label class="form-label">Amount</label>
								<input type="number" step="0.01" class="form-control" id="chequePayAmount" name="cheque_payment_amount" placeholder="0.00" oninput="updateAllocation()" required>
							</div>
						</div>	
						<div class="row">	
							<div class="col-12 mb-3">
								<label class="form-label">Receiver Bank</label>
								<select class="form-control bankSelect" name="cheque_bank_name" id="chequeBankSelect">
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

							<!--<div class="col-6 mb-3">
								<label class="form-label">Account</label>
								<select class="form-control accountSelect" name="cheque_bank_account_id" id="accountSelect">
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
						</div>
					<div class ="row">		
                        <div class="col-6 mb-6">
                            <label class="form-label">Cheque Number</label>
                            <input type="text" class="form-control" id="cheque_no" name="cheque_no" placeholder="CHQ-XXXXXX">
							<div id="cheque_msg" style="font-size: 11px; margin-top: 5px;"></div>
                        </div>
                        <div class="col-6 mb-6">
                            <label class="form-label">Cheque Date</label>
                            <input type="date" class="form-control" name="cheque_date" onchange="validateChequeDate()">
                        </div>
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

<script>

// ────────────────────────────────────────────────────────────
//  GLOBAL DATA & STATE
// ────────────────────────────────────────────────────────────
      
let salesInvoices = [];
let payInvoiceIds = []; 
var salesData = [];

let selectedIds = [];    


	/* Currency Formatter */
	function formatCurrency(value){
		return new Intl.NumberFormat('en-LK', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		}).format(parseFloat(value) || 0);
	}

	$(document).ready(function(){
		project();
		loadInvoiceList();
		loadGrnCounts();
		//loadGrnCountss();
						
		$('#data-filter').on('submit', function(e){
			e.preventDefault();
			loadInvoiceList();
			
		});
		
	});


	var Total_Due = '0.00.Rs';
	var Sale_total = '0.00.Rs';

	function loadInvoiceList(){ 
		
		if ($.fn.DataTable.isDataTable('#sales_inv_table')) {
			let table = $('#sales_inv_table').DataTable();
			table.clear().destroy();
		}
		
		$.ajax({
			url: "/Sale_invoice/get_data",
			type: "GET",
			dataType: "json",
			
			data:{
				date_range: $('.date-range-input').val(),
				fk_user_id: $('#user').val(),
				invoice_status: $('#invoice_status').val(),
				productId : productId
			},

			
			success: function(res){
				
				console.log(res);
				
				salesInvoices = res;
				salesData = salesData = res;
				
				let tbody = '';
				let grandtotal = 0;
				let balance = 0;
				

				if(res && res.length > 0){
					
					$.each(res,function(i,invoice){
						
						grandtotal += parseFloat(invoice.grand_total);
						balance += parseFloat(invoice.balance_amount);
						
						let btn = '';
						if(invoice.status === 'DRAFT' || invoice.status === 'QUOTATION'){
							//btn = `<a href="/Sale?id=${invoice.id}" class="btn btn-sm btn-info-light"><i class="fa fa-shopping-cart"></i> Resume Sale</a>`;
							btn = `<a href="/Sale_invoice?id=${invoice.id}" class="btn btn-sm btn-info-light" title="Resume Sale"><i class="ri-shopping-bag-fill"></i></a>`;
						}

                     // ADD STATUS BADGE CODE -- wenusha 26/05/08
                    let statusBadge = '';
                    let status = invoice.status ? invoice.status.toUpperCase() : '';
					
					//alert(status);
					
                    if (status === 'DRAFT') {
                       statusBadge = '<span class="badge bg-danger">Draft</span>';   
                    } else if (status === 'COMPLETED') {
                       statusBadge = '<span class="badge bg-success">Completed</span>';   
                    } else if (status === 'CANCELLED') {
                       statusBadge = '<span class="badge bg-dark">Cancelled</span>';
                    } else if (status === 'RETURNED') {
                       statusBadge = '<span class="badge bg-dark">Returned</span>';
                    } else if (status === 'PROJECT') {
                       statusBadge = '<span class="badge bg-warning">Project</span>';
                    }
					else if (status === 'QUOTATION') {
                       statusBadge = '<span class="badge bg-dark">QUOTATION</span>';
                    }
					else {
                       statusBadge = '<span class="badge bg-secondary">' + (invoice.status || 'Unknown') + '</span>';
                    }		
					//---------------status badge
					
					let actionbtns ='';
					
					
					const balanceAmount = parseFloat(invoice.balance_amount) || 0;
					let payButton = '';

					if (balanceAmount > 0) {
						payButton = `
							<a class="btn btn-sm btn-info-light"
							   onclick="openSinglePayModal(${invoice.id})"
							   title="Pay Now">
								<i class="ri-bank-card-line"></i>
							</a>
						`;
					}
					
					
					if(invoice.status ==='PROJECT'){
						
						actionbtns = `
									<!--<a href="<?= site_url('Projects/project_Dashboard/')?>${invoice.project_id}" class="btn btn-sm btn-info-light" title="View Invoice">
										<i class="ri-eye-line"></i>
									</a>-->
									<a href="/Projects/project_Dashboard?project_id=${invoice.project_id}" class="btn btn-sm btn-info-light" title="View Invoice">
										<i class="ri-eye-line"></i>
									</a>
									<a  class="btn btn-sm btn-info-light" onclick="openSinglePayModal(${invoice.id})" target="_blank" title="Pay Now">
										<i class="ri-bank-card-line"></i>  
									</a>
								`;
					}
					if(invoice.status ==='QUOTATION'){
						
						actionbtns = `<a href="/Sale_invoice?id=${invoice.id}" class="btn btn-sm btn-info-light" title="Resume Sale"><i class="ri-shopping-bag-fill"></i></a>
									<a href="/Projects/project_Dashboard?project_id=${invoice.project_id}" class="btn btn-sm btn-info-light" title="View Invoice">
										<i class="ri-eye-line"></i>
									</a>
									<!-- NEW: Print Invoice Button -->
									<a href="/Sale_invoice/print_quotation?id=${invoice.id}" class="btn btn-sm btn-success-light" target="_blank" title="Print Invoice">
										<i class="ri-printer-line"></i>  
									</a>
								`;
					}
					else{
						
					actionbtns=`
									${btn}
									<a href="/Sale_invoice/view?id=${invoice.id}" class="btn btn-sm btn-info-light" title="View Invoice">
										<i class="ri-eye-line"></i>
									</a>
									<a href="/Sale_invoice/delivery_note?id=${invoice.id}" class="btn btn-sm btn-success-light" title="Generate Delivery Note">
										<i class="ri-file-copy-line"></i>
									</a>
									<!-- NEW: Print Invoice Button -->
									<a href="/Sale_invoice/print_invoice?id=${invoice.id}" class="btn btn-sm btn-success-light" target="_blank" title="Print Invoice">
										<i class="ri-printer-line"></i>  
									</a>
									<!-- NEW:  Invoice pay Button -->
									<!-- href="/Sale_invoice/print_invoice?id=${invoice.id}"  -->
									<!--<a  class="btn btn-sm btn-info-light" onclick="openSinglePayModal(${invoice.id})" target="_blank" title="Pay Now">
										<i class="ri-bank-card-line"></i>  
									</a>-->
									${payButton}
								`;
					}

					tbody += `
						<tr>
							<td><input type="checkbox" class="form-check-input row-check" data-id="${invoice.id}" data-customer="${invoice.customer_id}" onclick="handleRowCheck(this)"></td>
							<td>${invoice.invoice_no}</td>
							<td>${invoice.cus_name}</td>
							<td>
                               ${invoice.invoice_date ? invoice.invoice_date.split(' ')[0] : '-'}
                               <br/>
                               <!--<small class="text-muted" style="font-size: 11px;">
                                   ${invoice.invoice_date ? invoice.invoice_date.split(' ')[1] || '' : ''}
                               </small>-->
                            </td>
							<td>${invoice.created_by_name}</td>
							<td class="text-center">${statusBadge}
							<td class="text-center fw-normal">${formatCurrency(invoice.grand_total)} </td>
							<td class="text-center fw-normal">${formatCurrency(invoice.paid_amount)} </td>
							<td class="text-center fw-normal">${formatCurrency(invoice.balance_amount)} </td>
							 
							<!--<td class="">
								${btn}
								<a href="/Sale_invoice/view?id=${invoice.id}" class="btn btn-sm btn-info-light" title="View Invoice">
									<i class="ri-eye-line"></i>
								</a>
								<a href="/Sale_invoice/delivery_note?id=${invoice.id}" class="btn btn-sm btn-success-light" title="Generate Delivery Note">
									<i class="ri-file-copy-line"></i>
								</a>
								<!-- NEW: Print Invoice Button -->
                                <!--<a href="/Sale_invoice/print_invoice?id=${invoice.id}" class="btn btn-sm btn-success-light" target="_blank" title="Print Invoice">
                                    <i class="ri-printer-line"></i>  
                                </a>
								<!-- NEW:  Invoice pay Button -->
								<!-- href="/Sale_invoice/print_invoice?id=${invoice.id}"  -->
                                <!--<a  class="btn btn-sm btn-info-light" onclick="openSinglePayModal(${invoice.id})" target="_blank" title="Pay Now">
                                    <i class="ri-bank-card-line"></i>  
                                </a>
							</td>-->
							<td class="">
								${actionbtns}
							</td>
						</tr>
						`;
					});

				}else{
					
					$('#sales_inv_table').DataTable();
					
					tbody = `<tr>
								<td colspan="12" class="text-center text-muted">
									No Invoice Found
								</td>
							 </tr>`;
				}
				
				$('#totalAmount').text(formatCurrency(grandtotal) + '.Rs');
				$('#totalDueAmount').text(formatCurrency(balance) + '.Rs');
				
				Total_Due = formatCurrency(balance) + '.Rs';
				Sale_total = formatCurrency(grandtotal) + '.Rs';

				$('#sales_inv_table tbody').html(tbody);

				initializeDataTable('#sales_inv_table');
			}
		});


	}

	

	/* Currency Formatter */
	/*


	$(document).ready(function(){
		loadGrnList();
		loadGrnCounts();
		
		$('#data-filter').on('submit', function(e){
			e.preventDefault();
			loadGrnList();
		});
		
		
	});
	
	
/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadGrnCounts() {
    $.ajax({
        url: "/Sale_invoice/get_sale_counts",
        type: "GET",
        dataType: "json",
        success: function(res) {

            console.log(res);

            // Storing the original array response
            GRN_ITEMS = res;
            
            // Dynamic mappings based on your design style
            GRN_ITEMS.forEach(function(item) {
                var key = (item.name || '').toLowerCase();

                // STATUS LABELS (e.g., "settled" -> "Settled")
                if (!STATUS_LABELS[key]) {
                    STATUS_LABELS[key] = item.name + ' count';
                }

                // STATUS CSS (e.g., "st-settled")
                if (!STATUS_CSS[key]) {
                    STATUS_CSS[key] = 'st-' + key;
                }
            });

            // Status FontAwesome Icons mapping matching your structure
            STATUS_ICON = {
                settled: 'fa-check-double',
                pending: 'fa-clock',
                approved: 'fa-circle-check',
                rejected: 'fa-circle-xmark',
                draft: 'fa-file-lines',
                partial: 'fa-layer-group'
            };

            // Call structural rendering functions
            renderGrnSummaryBar();
            // renderAllGrnTabs(); // Uncomment if you use tab views
        },
        error: function() {
            console.error('Failed to load GRN counts');
        }
    });
}

/* ─── COMPACT SUMMARY BAR (GRN VERSION) ─── */
function renderGrnSummaryBar() {
    //var totalGrns = GRN_ITEMS.reduce(function(acc, item) { return acc + parseInt(item.total || 0); }, 0);
    
    // Mapping config for display panels
    var itemsConfig = {
        settled:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Payment Completed' },
        outstanding:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Awaiting Verification' },
        total: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
        rejected: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Needs Correction' },
        draft:    { icon: 'fa-file-lines',    bg: 'var(--primary-light)', ic: 'var(--primary)', sub: 'Saved Workspaces' }
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Category' };
		
		// Dynamic addition of spans for specific status types
        var extraHtml = '';
        if (key === 'settled') {
            // Adds placeholder span for Sale Total under Verified Documents
            extraHtml = '<div class="sbi-extra-amt" style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #475569;">'
                      + 'Sale Total: <span id="totalGrnAmount" style="color:' + cfg.ic + '">'+ Sale_total +'</span>'
                      + '</div>';
        } if (key === 'outstanding') {
            // Adds placeholder span for Total Due under Awaiting Verification
            extraHtml = '<div class="sbi-extra-amt" style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #475569;">'
                      + 'Total Due: <span id="totalDueAmount" style="color:' + cfg.ic + '">'+ Total_Due +'</span>'
                      + '</div>';
        }

        return {
            icon: cfg.icon,
            ibg: cfg.bg,
            ic: cfg.ic,
            val: item.total,
            lbl: STATUS_LABELS[key] || item.name,
            sub: cfg.sub,
            extra: extraHtml
        };
    });

    // Automatically inject a "Total" card at the front of the summary bar array
    /*displayItems.unshift({
        icon: 'fa-boxes-stacked',
        ibg: '#e0f2fe',
        ic: '#0369a1',
        val: totalGrns,
        lbl: 'Total GRN Records',
        sub: 'Overall generated entries',
        extra: ''
    });*/

    // Your template literal generator matching your UI layout exactly
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

    // Target element to render the dynamic markup
    $('#summary-bar').html(html);
}


	function loadGrnList(){ 
		
		if ($.fn.DataTable.isDataTable('#Grn_table')) {
			let table = $('#Grn_table').DataTable();
			table.clear().destroy();
		}

		$.ajax({
			url: "/Grn/list",
			type: "GET",
			dataType: "json",

			data:{
				date_range: $('.date-range-input').val(),
				fk_store_id: $('#store').val(),
				fk_sup_id: $('#sup').val(),
				fk_user_id: $('#user').val()
			},

			success: function(res){

				let tbody = '';
				let totalGrn = 0;
				let totalDue = 0;

				if(res.data.length > 0){

					$.each(res.data,function(i,grn){

						totalGrn += parseFloat(grn.grand_total);
						totalDue += parseFloat(grn.due_amount);

						tbody += `
						<tr>
							<td>${grn.id}</td>
							<td>${grn.grn_number}</td>
							<td>${grn.store_name ?? '-'}</td>
							<td>${grn.grn_date}</td>
							<td>${grn.supplier_name ?? '-'}</td>
							<td>${grn.received_by ?? '-'}</td>
							<td>${grn.status ?? '-'}</td>
							<td>${formatCurrency(grn.grand_total)} LKR</td>
							<td>${formatCurrency(grn.due_amount)} LKR</td>
							<td class="text-center">
									<a href="/Grn?id=${grn.id}" class="btn btn-sm btn-info-light">
										<i class="ri-eye-line"></i> View
									</a>
							<a href="" class="btn btn-sm btn-success-light">
								<i class="ri-printer-line"></i>
							</a>
								
							</td>
						</tr>
						`;
					});

				}else{
					
					$('#Grn_table').DataTable();
					
					tbody = `<tr>
								<td colspan="9" class="text-center text-muted">
									No GRN Found
								</td>
							 </tr>`;
				}

				$('#Grn_table tbody').html(tbody);

				$('#totalGrnAmount').text(formatCurrency(totalGrn) + ' LKR');
				$('#totalDueAmount').text(formatCurrency(totalDue) + ' LKR');

				initializeDataTable('#Grn_table');
			}
		});

	}
	
	
	// $(document).on('click', '.btnViewItems', function () {

		// let grn_id = $(this).data('id');

		// const modal = new bootstrap.Modal(document.getElementById('grnItemsModal'));
		// modal.show();

		// $('#grnItemsTableBody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
		// $('#grnTotalCost').text('0');

		// $.ajax({
			// url: "/Grn/get",
			// type: "GET",
			// data: {grn_id: grn_id},
			// dataType: "json",
			// success: function(res){

				// let html = '';
				// let totalCost = 0;

				// if(res.data.length > 0){

					// $.each(res.data,function(i,item){

						// totalCost += parseFloat(item.line_tot);

						// html += `
						// <tr>
							// <td>${item.id}</td>
							// <td>${item.product_name}</td>
							// <td>${item.product_code ?? '-'}</td>
							// <td>${formatCurrency(item.line_total)}</td>
							// <td>${formatCurrency(item.unit_price)}</td>
							// <td>${item.qty}</td>
							// <td>${formatCurrency(item.line_total)}</td>
						// </tr>
						// `;
					// });

				// }else{

					// html = `
					// <tr>
						// <td colspan="7" class="text-center text-muted">
							// No Items Found
						// </td>
					// </tr>
					// `;
				// }

				// $('#grnItemsTableBody').html(html);
				// $('#grnTotalCost').text(formatCurrency(totalCost));
			// }
		// });

	// });
	
	
	/*function loadGrnCounts() {

		$.ajax({
			url: "/Grn/get_grn_counts",
			type: "GET",
			dataType: "json",
			success: function(response){

				let html = '';

				response.forEach(function(item){

					let bgClass = 'bg-blue';
					let icon = 'bi-box';

					if(item.name === 'Total'){
						bgClass = 'bg-primary';
						icon = 'bi-list-check';
					}

					if(item.name === 'Settled'){
						bgClass = 'bg-green';
						icon = 'bi-check-circle';
					}

					if(item.name === 'Outstanding'){
						bgClass = 'bg-danger';
						icon = 'bi-exclamation-circle';
					}

					html += `
					<div class="mini-card ${bgClass}">
						<i class="bi ${icon}"></i>
						${item.total}
						<span>${item.name} GRN</span>
					</div>
					`;
				});

				$('#lead-status-container').html(html);

			}
		});
	}*/
	
	/*function loadGrnCounts() {
    $.ajax({
        url: "/Grn/get_grn_counts",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Loop through each item in the response array
            response.forEach(function(item) {
                // Normalize name to lowercase (e.g., "Settled" -> "settled")
                const key = (item.name || '').toLowerCase();
                
                // Update the text of the span with the matching ID
                if ($('#val-' + key).length) {
                    $('#val-' + key).text(item.total);
                }
            });
        },
        error: function() {
            console.error('Failed to load GRN counts');
        }
    });
}*/





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
    const firstInv = salesInvoices.find(i => i.id == payInvoiceIds[0]);
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
        const inv = salesInvoices.find(i => i.id == id);
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
    //document.getElementById('sumSelected').textContent = 'Rs ' + totalBal.toLocaleString(undefined, {minimumFractionDigits: 2});
	
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
				invoiceNoBadge.textContent = firstInv.invoice_no ? '#' + firstInv.invoice_no : '#INV-' + firstInv.id;
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
//let isChequeValid = false; 

function updateAllocation() {
    // 1. Get amounts from ALL fields (Removed .is(':visible') check)
    // This allows split payments (e.g., some cash + some transfer)
    const cashAmt     = parseFloat(document.getElementById('cashPayAmount')?.value) || 0;
    const transferAmt = parseFloat(document.getElementById('transferPayAmount')?.value) || 0;
    const chequeAmt   = parseFloat(document.getElementById('chequePayAmount')?.value) || 0;
    
    // 2. Total combined payment amount
    const totalEntered = cashAmt + transferAmt + chequeAmt;
    const btn = document.getElementById('btnConfirmPayment');
    
    // 3. Calculate Total Balance of selected salesInvoices
    // We use the global payInvoiceIds array
    const totalBal = payInvoiceIds.reduce((s, id) => {
        const inv = salesInvoices.find(i => i.id == id);
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
    /*if (chequeAmt > 0 && !isChequeValid) {
        isInvalid = true;
        errorMessage = "Invalid Cheque Details";
    }*/

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
    const inv = salesInvoices.find(i=>i.id===id);
    showToast(`Viewing ${inv.no} – ${inv.supplier}`, 'ri-eye-line');
}

function cancelInvoice(id) {
    const inv = salesInvoices.find(i=>i.id===id);
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
        $('#transferPayDate, #transferPayAmount, #transferBankSelect').prop('required', isRequired);
    } else if (mode === 'cheque') {
        // Use the new unique ID for cheque bank
        $('#chequePayDate, #chequePayAmount, #chequeBankSelect, #cheque_no').prop('required', isRequired);
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




// ────────────────────────────────────────────────────────────
//  FORM SUBMISSION (Using your ajax_submit pattern)
// ────────────────────────────────────────────────────────────
$('#paymentForm').ajax_submit({
	url: '<?= site_url("Sale_invoice/process_payment"); ?>',
	rest: false,
	callback: function (res) {
		closePayModal();
		
		
		loadInvoiceList();
	}
});

// ────────────────────────────────────────────────────────────
//  SELECTION & UTILS
// ────────────────────────────────────────────────────────────
/*function handleRowCheck() {
    selectedIds = [];
    document.querySelectorAll('.row-check:checked').forEach(cb => selectedIds.push(+cb.dataset.id));
    
    const total = selectedIds.reduce((s, id) => {
        const inv = salesInvoices.find(i => i.id == id);
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
        const firstCustomerId = checkedCheckboxes[0].getAttribute('data-customer');
        const currentCustomerId = checkbox.getAttribute('data-customer');

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
        const inv = salesInvoices.find(i => i.id == id);
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

 let productId = null;

function project (){
	const urlParams = new URLSearchParams(window.location.search);
	const id = urlParams.get('id');
	
	if(id){
		
		document.getElementById('filter-inputs-row').classList.add('d-none');
		document.getElementById('project-info-message').classList.remove('d-none');
		
		productId = id;
	}
}



</script>


