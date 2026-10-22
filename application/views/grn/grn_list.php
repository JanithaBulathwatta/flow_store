
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-12 mt-3">
				<div class="card custom-card card-bg mb-20">
					<div class="card-body"> 
						<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
							<div class="d-flex align-items-center"> 
								<span class="card-title me-6">GRN List </span>
								<div class="d-flex gap-2 flex-wrap align-items-center" id="lead-status-container">
								<!-- Total GRN Pill -->
								<!--<div id="pill-total" class="stat-pill status-filter" data-status="" style="cursor: pointer;">
									<span class="num" id="val-total">0</span>
									<span class="lbl">Total GRN</span>
								</div>

								<!-- Settled GRN Pill -->
								<!--<div id="pill-settled" class="stat-pill status-filter" data-status="settled" style="cursor: pointer;">
									<span class="num" id="val-settled">0</span>
									<span class="lbl">Settled</span>
								</div>

								<!-- Outstanding GRN Pill -->
								<!--<div id="pill-outstanding" class="stat-pill status-filter" data-status="outstanding" style="cursor: pointer;">
									<span class="num" id="val-outstanding">0</span>
									<span class="lbl">Outstanding</span>
								</div>-->
							</div>
							</div> 
							
							<div class="d-flex flex-wrap gap-2 align-items-center"> 
								<a href="/Purchase/new_grn">
									<button class="btn btn-add">
										<i class="ri-add-line me-1 fw-medium align-middle"></i> 
										Add New GRN
									</button>
								</a>
							</div> 
						</div> 
					</div>
				</div>
				
				<div class="summary-bar" id="summary-bar"></div>
				
			</div>
		
			<div class="col-xl-12">
				<form id="data-filter">
					<div class="card mb-3 ">
						<div class="card-body row g-3">
						
							<div class="col-md-4">
								<label class="text-black-normal label mb-1">Date Range</label>
								<input type="text" class="date-range-input daterangepicker-field form-control-sm" placeholder="Select Date Range" data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" />
							</div>
							<div class="col-md-2">
								<label class="text-black-normal label mb-1">Store</label>
								<select id="store" name="fk_store_id" class="form-control form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example">
									<option value=""> Select Store </option>
									<?php foreach ($store as $store): ?>
										<option value="<?= $store->store_id; ?>"><?= html_escape($store->store_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="col-md-2">
								<label class="text-black-normal label mb-1">Supplier</label>
								<select id="sup" name="fk_sup_id" class="form-control form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example">
									<option value=""> Select Supplier </option>
									<?php foreach ($sup as $supplier): ?>
										<option value="<?= $supplier->id; ?>"><?= html_escape($supplier->name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="col-md-2">
								<label class="text-black-normal label mb-1">Recived</label>
								<select id="user" name="fk_user_id" class="form-control form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example">
									<option value=""> Select Recived </option>
									<?php foreach ($staff as $staff): ?>
										<option value="<?= $staff->user_id; ?>"><?= html_escape($staff->full_name); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						
							<div class="col-md-2">
								<button type="submit" class="btn btn-search w-100 mb-1 mr-10 mt-1 right" id="data-filter">
									Search
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		
            <div class="col-xl-12">

                <div class="card custom-card">

                    <!-- HEADER -->
                    <!--<div class="card-header d-flex justify-content-between align-items-center">
                        <!--<div class="card-title"> GRN List </div>-->
                    
						<!--<div class="d-flex gap-4">
							<!--<div>
								<strong>Total Due :</strong>
								<span id="totalDueAmount">0 LKR</span>
							</div>
							<div>
								<strong>Total GRN :</strong>
								<span id="totalGrnAmount">0 LKR</span>
							</div>-->
						<!--</div>
					
					</div>-->

                    <!-- BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="Grn_table" class="table table-stripe text-nowrap w-100 dataTable no-footer">

                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ref no</th>
                                    <th>Store</th>
                                    <th>GRN Date</th>
                                    <th>Supplier</th>
                                    <th>Recived by</th>
                                    <th>Status</th>
                                    <th>Grn Amount</th>
                                    <th>Due Amount</th>
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






<script>

    /* Currency Formatter */
    function formatCurrency(value){
        return new Intl.NumberFormat('en-LK', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(parseFloat(value) || 0);
    }

    var Total_Due = '0.00 Rs';
    var Sale_total = '0.00 Rs';
    var currentStatus = '';

    $(document).ready(function(){
        loadGrnList();
        loadGrnCounts();
        
        $('#data-filter').on('submit', function(e){
            e.preventDefault();
            loadGrnList(currentStatus);
        });
        
        // Filter change events
        $('.date-range-input, #store, #sup, #user').on('change', function() {
            loadGrnList(currentStatus);
        });
    });
    
    $('.status-filter').on('click', function() {
        $('.status-filter').removeClass('active-pill');
        $(this).addClass('active-pill');
        currentStatus = $(this).data('status'); 
        loadGrnList(currentStatus);
    });

    function loadGrnList(status = ''){ 
        
        if ($.fn.DataTable.isDataTable('#Grn_table')) {
            let table = $('#Grn_table').DataTable();
            table.clear().destroy();
        }

        $.ajax({
            url: "/Grn/list",
            type: "GET",
            dataType: "json",
            data: {
                date_range: $('.date-range-input').val(),
                fk_store_id: $('#store').val(),
                fk_sup_id: $('#sup').val(),
                fk_user_id: $('#user').val(),
                status: status
            },
            success: function(res){
                let tbody = '';
                let totalGrn = 0;
                let totalDue = 0;

                if(res.data && res.data.length > 0){
                    $.each(res.data, function(i, grn){
                        totalGrn += parseFloat(grn.grand_total) || 0;
                        totalDue += parseFloat(grn.due_amount) || 0;

						var credit ='';
						
						if(formatCurrency(grn.due_amount == 0.00)){
							var credit ='<span style="font-size: 9px; padding: 2px 6px; margin-left: 6px;" class="badge bg-danger">Credit</span>';  
						}else{
							var credit ='<span style="font-size: 9px; padding: 2px 6px; margin-left: 6px;" class="badge bg-success">Paid</span>';
						}

                        tbody += `
                            <tr>
                                <td>${grn.id}</td>
                                <td>${grn.grn_number || '-'} ${credit}</td>
                                <td>${grn.store_name || '-'}</td>
                                <td>${grn.grn_date || '-'}</td>
                                <td>${grn.supplier_name || '-'}</td>
                                <td>${grn.received_by || '-'}</td>
                                <td>${grn.status || '-'}</td>
                                <td class="text-amount">${formatCurrency(grn.grand_total)}</td>
                                <td class="text-amount">${formatCurrency(grn.due_amount)}</td>
                                <td class="text-center">
                                    <a href="/Grn?id=${grn.id}" class="btn btn-sm btn-icon btn-info-light">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <a href="<?= base_url('Grn/print_view?grn='); ?>${grn.id}" class="btn btn-sm btn-icon btn-success-light">
                                        <i class="ri-printer-line"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbody = `<tr><td colspan="10" class="text-center text-muted">No GRN Found</td></tr>`;
                }

                $('#Grn_table tbody').html(tbody);
                $('#totalGrnAmount').text(formatCurrency(totalGrn) + ' LKR');
                $('#totalDueAmount').text(formatCurrency(totalDue) + ' LKR');
                
                Total_Due = formatCurrency(totalDue) + ' Rs';
                Sale_total = formatCurrency(totalGrn) + ' Rs';

                initializeDataTable('#Grn_table');
            },
            error: function(xhr, status, error) {
                console.error('Error loading GRN list:', error);
                $('#Grn_table tbody').html('<tr><td colspan="10" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    function loadGrnCounts() {
        $.ajax({
            url: "/Grn/get_grn_counts",
            type: "GET",
            dataType: "json",
            success: function(res) {
                GRN_ITEMS = res || [];
                renderGrnSummaryBar();
            },
            error: function() {
                console.error('Failed to load GRN counts');
            }
        });
    }

    var GRN_ITEMS = [];

    function renderGrnSummaryBar() {
        var itemsConfig = {
            settled:    { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Payment Completed' },
            outstanding:{ icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Awaiting Verification' },
            total:      { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
            rejected:   { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Needs Correction' },
            draft:      { icon: 'fa-file-lines',    bg: 'var(--primary-light)', ic: 'var(--primary)', sub: 'Saved Workspaces' }
        };

        var displayItems = GRN_ITEMS.map(function(item) {
            var key = (item.name || '').toLowerCase();
            var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Category' };
            
            var extraHtml = '';
            if (key === 'settled') {
                extraHtml = '<div class="sbi-extra-amt" style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #475569;">'
                          + 'Sale Total: <span id="totalGrnAmount" style="color:' + cfg.ic + '">'+ Sale_total +'</span>'
                          + '</div>';
            } 
            if (key === 'outstanding') {
                extraHtml = '<div class="sbi-extra-amt" style="margin-top: 4px; font-size: 11px; font-weight: 600; color: #475569;">'
                          + 'Total Due: <span id="totalDueAmount" style="color:' + cfg.ic + '">'+ Total_Due +'</span>'
                          + '</div>';
            }

            return {
                icon: cfg.icon,
                ibg: cfg.bg,
                ic: cfg.ic,
                val: item.total,
                lbl: item.name + ' count',
                sub: cfg.sub,
                extra: extraHtml
            };
        });

        var html = displayItems.map(function(item) {
            return '<div class="sb-item">'
                + '<div class="sbi-icon" style="background:' + item.ibg + ';color:' + item.ic + '"><i class="fa-solid ' + item.icon + '"></i></div>'
                + '<div class="sbi-main">'
                    + '<div class="sbi-val" style="color:' + item.ic + '">' + item.val + '</div>'
                    + '<div class="sbi-lbl">' + item.lbl + '</div>'
                    + item.extra
                + '</div>'
            + '</div>';
        }).join('');

        $('#summary-bar').html(html);
    }

    function initializeDataTable(selector) {
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().destroy();
        }
        $(selector).DataTable({
            responsive: true,
            language: {
                emptyTable: "No data available"
            }
        });
    }
</script>