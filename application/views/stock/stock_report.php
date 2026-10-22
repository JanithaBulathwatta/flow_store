<style>
.kpi-card{border-radius:12px;padding:1.1rem 1.25rem;display:flex;align-items:center;gap:.9rem;position:relative;overflow:hidden;background:#fff;border:1px solid #e9ecef;}
.kpi-card .kpi-icon{width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;}
.kpi-card .kpi-val{font-size:1.45rem;font-weight:700;line-height:1;margin-bottom:3px;}
.kpi-card .kpi-lbl{font-size:.73rem;color:#64748b;font-weight:500;}
.kpi-card .kpi-sub{font-size:.68rem;color:#94a3b8;margin-top:2px;}

.stk-tbl{width:100%;border-collapse:separate;border-spacing:0;}
.stk-tbl thead th{background:#f8f9fb;font-size:.71rem;text-transform:uppercase;letter-spacing:.06em;color:#64748b;white-space:nowrap;padding:.65rem .875rem;border-bottom:2px solid #e9ecef;}
.stk-tbl td{padding:.6rem .875rem;border-bottom:1px solid #f1f5f9;vertical-align:middle;font-size:.8125rem;}
.stk-tbl tbody tr:hover td{background:#f8faff;}
.stk-tbl .num-col{text-align:right;font-variant-numeric:tabular-nums;}

.prod-name{font-weight:600;font-size:.8125rem;color:#1e293b;line-height:1.2;}
.prod-sku{font-size:.7rem;color:#94a3b8;margin-top:1px;}
.prod-cat{font-size:.68rem;color:#405189;background:#eff6ff;border-radius:4px;padding:0 5px;display:inline-block;margin-top:2px;}

.stk-status{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:600;white-space:nowrap;}
.st-normal{background:#dcfce7;color:#166534;}
.st-low{background:#fef9c3;color:#854d0e;}
.st-zero{background:#fee2e2;color:#991b1b;}
.st-neg{background:#fdf4ff;color:#7e22ce;}

.batch-chip{display:inline-flex;align-items:center;gap:2px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:5px;padding:1px 7px;font-size:.68rem;font-weight:600;color:#1e40af;cursor:pointer;transition:background .15s;}
.batch-chip:hover{background:#dbeafe;}

.val-chip{font-size:.78rem;font-weight:600;color:#405189;}
.tbl-scroll-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;}
</style>

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-semibold fs-18 mb-1">Stock Report</h1>
                <p class="text-muted fs-12 mb-0">
                    <i class="ri-store-3-line me-1"></i>Real-time inventory snapshot
                </p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap mt-md-0 mt-2">
                <button class="btn btn-primary btn-sm" onclick="openQuickAdjustment()">
                    <i class="ri-equalizer-line me-1"></i>Quick Adjustment
                </button>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                        <li class="breadcrumb-item active">Stock Report</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row g-3 mb-4" id="kpiRow">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background:#dcfce7;color:#166534;">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    <div>
                        <div class="kpi-val" id="totalValue">0.00</div>
                        <div class="kpi-lbl">Total Stock Value (LKR)</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background:#fef9c3;color:#854d0e;">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div>
                        <div class="kpi-val" id="lowStock">0</div>
                        <div class="kpi-lbl">Low Stock Items</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background:#fee2e2;color:#991b1b;">
                        <i class="ri-close-circle-line"></i>
                    </div>
                    <div>
                        <div class="kpi-val" id="zeroStock">0</div>
                        <div class="kpi-lbl">Zero Stock Items</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="kpi-card">
                    <div class="kpi-icon" style="background:#fdf4ff;color:#7e22ce;">
                        <i class="ri-error-warning-line"></i>
                    </div>
                    <div>
                        <div class="kpi-val" id="negativeStock">0</div>
                        <div class="kpi-lbl">Negative Stock Items</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card custom-card mb-3">
            <div class="card-body py-3">
                <div class="row g-2 align-items-end">
                    <div class="col-sm-6 col-md-4 col-xl-2">
                        <label class="form-label fw-medium fs-12 mb-1">Warehouse</label>
                        <select class="form-select form-select-sm" id="fWarehouse">
                            <option value="">All Warehouses</option>
                            <?php foreach($stores as $store): ?>
                                <option value="<?= $store->id ?>"><?= $store->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2">
                        <label class="form-label fw-medium fs-12 mb-1">Branch</label>
                        <select class="form-select form-select-sm" id="fBranch">
                            <option value="">All Branches</option>
                            <?php foreach($branches as $branch): ?>
                                <option value="<?= $branch->branch_id ?>"><?= $branch->branch_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2">
                        <label class="form-label fw-medium fs-12 mb-1">Category</label>
                        <select class="form-select form-select-sm" id="fCategory">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat->id ?>"><?= $cat->category ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2">
                        <label class="form-label fw-medium fs-12 mb-1">Stock Type</label>
                        <select class="form-select form-select-sm" id="fStockType">
                            <option value="">All Stock</option>
                            <option value="low">Low Stock</option>
                            <option value="zero">Zero Stock</option>
                            <option value="excludeZero">Exclude Zero</option>
                            <option value="negative">Negative Stock</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2">
                        <label class="form-label fw-medium fs-12 mb-1">Search</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white"><i class="ri-search-line text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" id="fSearch" placeholder="Product / SKU…">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm flex-fill" onclick="applyFilters()">
                                <i class="ri-filter-line me-1"></i>Apply
                            </button>
                            <button class="btn btn-light btn-sm" onclick="resetFilters()" title="Reset Filters">
                                <i class="ri-refresh-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card custom-card">
            <!--<div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0">
                    <i class="ri-table-line me-2 text-primary"></i>Stock Register
                    <span class="badge bg-primary-transparent text-primary ms-2 fs-11" id="rowCountBadge">0 items</span>
                </h6>
            </div>-->
            <div class="card-body p-0">
				<div class="table-responsive">
					<div class="tbl-scroll-wrap">
						<table class="stk-tbl table table-stripe text-nowrap w-100 dataTable no-footer" id="stockTable">
							<thead>
								<tr>
									<!--<th>#</th>-->
									<th>Product</th>
									<th>Category</th>
									<th class="num-col"> Number Of Warehouses</th>
									<th class="num-col">Total Qty</th>
									<th class="num-col">Avg Cost</th>
									<th class="num-col">Stock Value</th>
									<th>Batches</th>
									<th>Status</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody id="stockTbody"></tbody>
						</table>
					</div>
				</div>
            </div>
            <!--<div class="card-footer d-flex align-items-center justify-content-between flex-wrap gap-2 py-2">
                <div class="page-info fs-12 text-muted" id="pageInfo">
                    Showing <span id="showingFrom">0</span> to <span id="showingTo">0</span> of <span id="totalRecords">0</span> records
                </div>
            </div>-->
        </div>
    </div>
</div>

<div class="modal fade" id="batchModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h6 class="modal-title fw-semibold mb-1">
                        <i class="ri-archive-line me-2 text-primary"></i>
                        Batch Details — <span id="batchModalProduct">—</span>
                    </h6>
                    <p class="text-muted fs-12 mb-0">Batch-wise stock & expiry breakdown</p>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm fs-12 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Batch No.</th>
                                <th>Warehouse</th>
                                <th>Qty</th>
                                <th>Expiry Date</th>
                                <th>Days Left</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="batchTbody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="quickAdjModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="quickAdjForm">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-semibold">Quick Stock Adjustment</h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="qaProductId" name="product_id">
                    <input type="hidden" id="qaWarehouseId" name="warehouse_id">
                    
                    <div class="p-3 bg-light rounded mb-3" id="qaProductInfo"></div>
                    
                    <div class="row g-3">
                        <div class="col-12" id="warehouseSelectContainer" style="display:none;">
                            <label class="form-label fw-medium fs-13">Warehouse <span class="text-danger">*</span></label>
                            <select class="form-select" id="qaWarehouseSelect" onchange="updateCurrentStock()">
                                <option value="">Select Warehouse</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium fs-13">Adjustment Mode <span class="text-danger">*</span></label>
                            <select class="form-select" id="qaMode" name="mode" required>
                                <option value="ADD">Add Stock</option>
                                <option value="SUBTRACT">Subtract Stock</option>
                                <option value="SET">Set Stock</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium fs-13">Current Stock</label>
                            <input type="number" class="form-control bg-light" id="qaCurrentStock" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium fs-13">Adjustment Qty <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="qaQty" name="adjustment_qty" placeholder="0" step="0.01" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium fs-13">Reason / Remarks <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="2" id="qaRemarks" name="remarks" placeholder="Reason for adjustment…" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="ri-check-line me-1"></i>Apply Adjustment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const batchModal = new bootstrap.Modal(document.getElementById('batchModal'));
    const quickAdjModal = new bootstrap.Modal(document.getElementById('quickAdjModal'));
    
    console.log('Stock Report page loaded');
    
    // Load data on page load
    loadKPIData();
    applyFilters();
    
    console.log('Initial data load triggered');
    
    // Make functions global
    window.loadKPIData = loadKPIData;
    window.applyFilters = applyFilters;
    window.resetFilters = resetFilters;
    window.refreshTable = refreshTable;
    window.viewBatches = viewBatches;
    window.openQuickAdjustment = openQuickAdjustment;
    window.exportTable = exportTable;
    
    function loadKPIData() {
    $.ajax({
        url: "<?= site_url('Stock_report/get_kpi_data'); ?>",
        type: "GET",
        dataType: "json",
        success: function(data) {
            $('#totalValue').text( parseFloat(data.total_value || 0).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#lowStock').text(data.low_stock_count || 0);
            $('#zeroStock').text(data.zero_stock_count || 0);
            $('#negativeStock').text(data.negative_stock_count || 0);
        },
        error: function(xhr, status, error) {
            console.error('Failed to load KPI data');
            if (xhr.status === 401) {
                window.location.href = '<?= site_url("login") ?>';
            }
        }
    });
}

/*function applyFilters() {
    const filterData = {
        search: $('#fSearch').val(),
        warehouse_id: $('#fWarehouse').val(),
        branch_id: $('#fBranch').val(),
        category: $('#fCategory').val(),
        stock_type: $('#fStockType').val()
    };
    
    console.log('Applying filters:', filterData);
	  
    $.ajax({
        url: "<?= site_url('Stock_report/filter'); ?>",
        type: "POST",
        data: filterData,
        dataType: "json",
        success: function(res) {
            console.log('Filter response:', res);
            
            let tbody = '';
            
            if (res.data && res.data.length > 0) {
                $.each(res.data, function(index, item) {
                    let rowNumber = index + 1;
                    let statusClass = 'st-normal';
                    let statusText = 'Normal';
                    
                    if (item.total_qty < 0) {
                        statusClass = 'st-neg';
                        statusText = 'Negative';
                    } else if (item.total_qty == 0) {
                        statusClass = 'st-zero';
                        statusText = 'Zero';
                    } else if (item.total_qty <= item.reorder_level) {
                        statusClass = 'st-low';
                        statusText = 'Low Stock';
                    }
                    
                    let batchDisplay = '';
                    if (item.batch_count > 0) {
                        batchDisplay = `<span class="batch-chip" onclick="viewBatches(${item.product_id}, '${escapeHtml(item.product_name)}')">
                            <i class="ri-archive-line"></i>${item.batch_count} batch${item.batch_count > 1 ? 'es' : ''}
                        </span>`;
                    } else {
                        batchDisplay = '<span class="text-muted fs-12">No batches</span>';
                    }
                    
                    tbody += `
                    <tr>
                        <td>${rowNumber}</td>
                        <td>
                            <div class="prod-name"><a href="<?= base_url('Stock_detail?pid=') ?>${item.product_id}" class="text-decoration-none">${escapeHtml(item.product_name)}</a></div>
                            <div class="prod-sku">${escapeHtml(item.sku || '-')}</div>
                        </td>
                        <td><span class="prod-cat">${escapeHtml(item.category || '-')}</span></td>
                        <td class="num-col">${item.warehouse_count || 0}</td>
                        <td class="num-col">${parseFloat(item.total_qty || 0).toFixed(2)}</td>
                        <td class="num-col">₹${parseFloat(item.avg_cost || 0).toFixed(2)}</td>
                        <td class="num-col"><span class="val-chip">₹${parseFloat(item.stock_value || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span></td>
                        <td>${batchDisplay}</td>
                        <td><span class="stk-status ${statusClass}">${statusText}</span></td>
                        <td class="text-center">
                            <a href="<?= base_url('Stock_detail?pid=') ?>${item.product_id}" class="btn btn-sm btn-info-light btn-icon me-1" title="View Detail">
                                <i class="ri-eye-line"></i>
                            </a>
                            <button class="btn btn-sm btn-primary-light btn-icon" onclick="openQuickAdjustment(${item.product_id}, '${escapeHtml(item.product_name)}')" title="Quick Adjust">
                                <i class="ri-equalizer-line"></i>
                            </button>
                        </td>
                    </tr>`;
                });
                
                $('#rowCountBadge').text(res.data.length + ' items');
                
                // Update pagination info
                $('#showingFrom').text(res.data.length > 0 ? 1 : 0);
                $('#showingTo').text(res.data.length);
                $('#totalRecords').text(res.data.length);
            } else {
				
				$('#stockTable').DataTable();
				
                tbody = `<tr><td colspan="10" class="text-center text-muted py-4">No stock data found</td></tr>`;
                $('#rowCountBadge').text('0 items');
                $('#showingFrom').text(0);
                $('#showingTo').text(0);
                $('#totalRecords').text(0);
				
				
            }
            
            $('#stockTbody').html(tbody);
			initializeDataTable('#stockTable');
        },
        error: function(xhr, status, error) {
            console.error('Filter error:', error);
            console.error('Response:', xhr.responseText);
            
            if (xhr.status === 401) {
                toastr.error('Session expired. Please login again.');
                setTimeout(function() {
                    window.location.href = '<?= site_url("login") ?>';
                }, 2000);
            } else {
                toastr.error('Failed to load stock data');
            }
        }
    });
}*/
    
    function applyFilters() {
        const filterData = {
            search: $('#fSearch').val(),
            warehouse_id: $('#fWarehouse').val(),
            branch_id: $('#fBranch').val(),
            category: $('#fCategory').val(),
            stock_type: $('#fStockType').val()
        };
        
        console.log('Applying filters:', filterData);
		
		// --- STEP 1: Destroy existing DataTable before fetching new data ---
			if ($.fn.DataTable.isDataTable('#stockTable')) {
			let table = $('#stockTable').DataTable();
			table.clear().destroy();
		}
        
        $.ajax({
            url: "<?= site_url('Stock_report/filter'); ?>",
            type: "POST",
            data: filterData,
            dataType: "json",
            success: function(res) {
                console.log('Filter response:', res);
                
                let tbody = '';
                
                if (res.data && res.data.length > 0) {
                    $.each(res.data, function(index, item) {
                        let rowNumber = index + 1;
                        let statusClass = 'st-normal';
                        let statusText = 'Normal';
                        
                        if (item.total_qty < 0) {
                            statusClass = 'st-neg';
                            statusText = 'Negative';
                        } else if (item.total_qty == 0) {
                            statusClass = 'st-zero';
                            statusText = 'Zero';
                        } else if (item.total_qty <= item.reorder_level) {
                            statusClass = 'st-low';
                            statusText = 'Low Stock';
                        }
                        
                        let batchDisplay = '';
                        if (item.batch_count > 0) {
                            batchDisplay = `<span class="batch-chip" onclick="viewBatches(${item.product_id}, '${escapeHtml(item.product_name)}')">
                                <i class="ri-archive-line"></i>${item.batch_count} batch${item.batch_count > 1 ? 'es' : ''}
                            </span>`;
                        } else {
                            batchDisplay = '<span class="text-muted fs-12">No batches</span>';
                        }
                        
                        tbody += `
                        <tr>
                            <!--<td>${rowNumber}</td>-->
                            <td>
                                <div class="prod-name"><a href="<?= base_url('Stock_detail?pid=') ?>${item.product_id}" class="text-decoration-none">${escapeHtml(item.product_name)}</a></div>
                                <div class="prod-sku">${escapeHtml(item.sku || '-')}</div>
                            </td>
                            <td><span class="prod-cat">${escapeHtml(item.category || '-')}</span></td>
                            <td class="text-center">${item.warehouse_count || 0}</td>
                            <td class="num-col">${parseFloat(item.total_qty || 0).toFixed(2)} ${item.unit_name}</td>
                            <td class="num-col">${parseFloat(item.avg_cost || 0).toFixed(2)}</td>
                            <td class="num-col"><span class="val-chip">${parseFloat(item.stock_value || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span></td>
                            <td>${batchDisplay}</td>
                            <td><span class="stk-status ${statusClass}">${statusText}</span></td>
                            <td class="text-center">
                                <a href="<?= base_url('Stock_detail?pid=') ?>${item.product_id}" class="btn btn-sm btn-info-light btn-icon me-1" title="View Detail">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <button class="btn btn-sm btn-primary-light btn-icon" onclick="openQuickAdjustment(${item.product_id}, '${escapeHtml(item.product_name)}')" title="Quick Adjust">
                                    <i class="ri-equalizer-line"></i>
                                </button>
                            </td>
                        </tr>`;
                    });

                    
                    $('#rowCountBadge').text(res.data.length + ' items');
                    
                    // Update pagination info
                    $('#showingFrom').text(res.data.length > 0 ? 1 : 0);
                    $('#showingTo').text(res.data.length);
                    $('#totalRecords').text(res.data.length);
                } else {
                    $('#rowCountBadge').text('0 items');
                    $('#showingFrom').text(0);
                    $('#showingTo').text(0);
                    $('#totalRecords').text(0);
                }
                
                $('#stockTbody').html(tbody);
				initializeDataTable('#stockTable');
            },
            error: function(xhr, status, error) {
                console.error('Filter error:', error);
                console.error('Response:', xhr.responseText);
                toastr.error('Failed to load stock data');
            }
        });
    }
    
    function resetFilters() {
        $('#fSearch').val('');
        $('#fWarehouse').val('');
        $('#fBranch').val('');
        $('#fCategory').val('');
        $('#fStockType').val('');
        applyFilters();
    }
    
    function refreshTable() {
        $('#refreshBtn').find('i').addClass('ri-loader-4-line').removeClass('ri-refresh-line');
        applyFilters();
        loadKPIData();
        setTimeout(function() {
            $('#refreshBtn').find('i').removeClass('ri-loader-4-line').addClass('ri-refresh-line');
        }, 500);
    }
    
    function viewBatches(productId, productName) {
        $('#batchModalProduct').text(productName);
        $('#batchTbody').html('<tr><td colspan="7" class="text-center"><i class="ri-loader-4-line"></i> Loading...</td></tr>');
        batchModal.show();
        
        $.ajax({
            url: "<?= site_url('Stock_report/get_batch_details'); ?>",
            type: "GET",
            data: { product_id: productId },
            dataType: "json",
            success: function(res) {
                if (res.success && res.batches && res.batches.length > 0) {
                    let tbody = '';
                    $.each(res.batches, function(index, batch) {
                        let expiryBadge = '';
                        if (batch.expiry_status === 'EXPIRED') {
                            expiryBadge = '<span class="badge bg-danger-transparent">Expired</span>';
                        } else if (batch.expiry_status === 'NEAR') {
                            expiryBadge = '<span class="badge bg-warning-transparent">Near Expiry</span>';
                        } else {
                            expiryBadge = '<span class="badge bg-success-transparent">Valid</span>';
                        }
                        
                        tbody += `
                        <tr>
                            <td>${escapeHtml(batch.batch_no || '-')}</td>
                            <td>${escapeHtml(batch.warehouse_name || '-')}</td>
                            <td>${parseFloat(batch.qty || 0).toFixed(2)}</td>
                            <td>${batch.expiry_date || '-'}</td>
                            <td>${batch.days_left || '-'} days</td>
                            <td>${expiryBadge}</td>
                            <td>
                                <button class="btn btn-sm btn-primary-light btn-icon" onclick="openQuickAdjustment(${productId}, '${escapeHtml(productName)}')" title="Adjust">
                                    <i class="ri-equalizer-line"></i>
                                </button>
                            </td>
                        </tr>`;
                    });
                    $('#batchTbody').html(tbody);
                } else {
                    $('#batchTbody').html('<tr><td colspan="7" class="text-center text-muted py-3">No batches found</td></tr>');
                }
            },
            error: function() {
                $('#batchTbody').html('<tr><td colspan="7" class="text-center text-danger py-3">Failed to load batch details</td></tr>');
            }
        });
    }
    
    function openQuickAdjustment(productId, productName) {
        if (!productId) {
            toastr.error('Please select a product');
            return;
        }
        
        // Set product info
        $('#qaProductId').val(productId);
        $('#qaProductInfo').html(`<strong>${escapeHtml(productName || 'Product')}</strong>`);
        
        // Reset form
        $('#qaQty').val('');
        $('#qaRemarks').val('');
        $('#qaMode').val('ADD');
        $('#qaCurrentStock').val('Loading...');
        $('#qaWarehouseId').val('');
        $('#warehouseSelectContainer').hide();
        $('#qaWarehouseSelect').html('<option value="">Select Warehouse</option>');
        
        // Show modal
        quickAdjModal.show();
        
        // Store stock data globally for warehouse switching
        window.productStockData = [];
        
        // Fetch current stock for this product
        $.ajax({
            url: "<?= site_url('Stock_report/get_product_stock'); ?>",
            type: "GET",
            data: { product_id: productId },
            dataType: "json",
            success: function(res) {
                if (res.success && res.stock && res.stock.length > 0) {
                    window.productStockData = res.stock;
                    
                    if (res.stock.length === 1) {
                        // Single warehouse - auto select
                        let stock = res.stock[0];
                        $('#qaCurrentStock').val(parseFloat(stock.qty || 0).toFixed(2));
                        $('#qaWarehouseId').val(stock.warehouse_id);
                        $('#qaProductInfo').append(`<div class="text-muted fs-12 mt-1">Warehouse: ${stock.warehouse_name || 'N/A'}</div>`);
                    } else {
                        // Multiple warehouses - show selector
                        $('#warehouseSelectContainer').show();
                        res.stock.forEach(function(s) {
                            $('#qaWarehouseSelect').append(
                                `<option value="${s.warehouse_id}" data-qty="${s.qty}">
                                    ${s.warehouse_name || 'Warehouse ' + s.warehouse_id} - Stock: ${parseFloat(s.qty).toFixed(2)}
                                </option>`
                            );
                        });
                        // Auto-select first warehouse
                        $('#qaWarehouseSelect').val(res.stock[0].warehouse_id).trigger('change');
                    }
                } else {
                    $('#qaCurrentStock').val('0.00');
                    $('#qaWarehouseId').val(1); // Default warehouse
                    toastr.info('No stock found for this product. Creating new stock entry.');
                }
            },
            error: function() {
                $('#qaCurrentStock').val('0.00');
                $('#qaWarehouseId').val(1);
                toastr.error('Failed to load current stock');
            }
        });
    }
    
    // Update current stock when warehouse changes
    window.updateCurrentStock = function() {
        const selectedWarehouseId = $('#qaWarehouseSelect').val();
        if (selectedWarehouseId && window.productStockData) {
            const stock = window.productStockData.find(s => s.warehouse_id == selectedWarehouseId);
            if (stock) {
                $('#qaCurrentStock').val(parseFloat(stock.qty || 0).toFixed(2));
                $('#qaWarehouseId').val(stock.warehouse_id);
            }
        }
    };
    
    $('#quickAdjForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: "<?= site_url('Stock_report/quick_adjust'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    quickAdjModal.hide();
                    applyFilters();
                    loadKPIData();
                } else {
                    toastr.error(res.message || 'Failed to adjust stock');
                }
            },
            error: function() {
                toastr.error('Something went wrong');
            }
        });
    });
    
    function exportTable(format) { 
        let filters = {
            format: format,
            search: $('#fSearch').val(),
            warehouse_id: $('#fWarehouse').val(),
            branch_id: $('#fBranch').val(),
            category: $('#fCategory').val(),
            stock_type: $('#fStockType').val()
        };
        
        $.ajax({
            url: "<?= site_url('Stock_report/export'); ?>",
            type: "GET",
            data: filters,
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    toastr.info(res.message);
                } else {
                    toastr.error(res.message || 'Export failed');
                }
            },
            error: function() {
                toastr.error('Export failed');
            }
        });
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>
