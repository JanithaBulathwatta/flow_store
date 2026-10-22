
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-12 mt-3 ">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body"> 
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                            <div class="d-flex align-items-center"> 
                                <span class="card-title me-6">Purchase Order List </span>
                                <div class="d-flex gap-2 flex-wrap align-items-center" id="po-status-container">
									<!-- Total PO Pill -->
									<!--<div id="pill-total" class="stat-pill status-filter" data-status="" style="cursor: pointer;">
										<span class="num" id="val-total">0</span>
										<span class="lbl">Total PO</span>
									</div>

									<!-- Draft PO Pill -->
									<!--<div id="pill-draft" class="stat-pill status-filter" data-status="draft" style="cursor: pointer;">
										<span class="num" id="val-draft">0</span>
										<span class="lbl">Draft</span>
									</div>

									<!-- Submitted PO Pill -->
									<!--<div id="pill-submitted" class="stat-pill status-filter" data-status="submitted" style="cursor: pointer;">
										<span class="num" id="val-submitted">0</span>
										<span class="lbl">Submitted</span>
									</div>

									<!-- Approved PO Pill -->
									<!--<div id="pill-approved" class="stat-pill status-filter" data-status="approved" style="cursor: pointer;">
										<span class="num" id="val-approved">0</span>
										<span class="lbl">Approved</span>
									</div>

									<!-- Rejected PO Pill -->
									<!--<div id="pill-rejected" class="stat-pill status-filter" data-status="rejected" style="cursor: pointer;">
										<span class="num" id="val-rejected">0</span>
										<span class="lbl">Rejected</span>
									</div>-->
								</div>
                            </div> 
                            
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <a href="/Po/index">
                                    <button class="btn btn-add">
                                        <i class="ri-add-line me-1 fw-medium align-middle"></i> 
                                        Add New PO
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
                        
                            <div class="col-md-3">
                                <label class="text-black-normal label mb-1">Date Range</label>
                                <input type="text" class="date-range-input daterangepicker-field form-control-sm" placeholder="Select Date Range" data-bind="daterangepicker: dateRange, daterangepickerOptions: {opened:false}" />
                            </div>
                            
                            <div class="col-md-3">
                                <label class="text-black-normal label mb-1">Supplier</label>
                                <select id="sup" name="fk_sup_id" class="form-control form-select form-select-sm">
                                    <option value=""> Select Supplier </option>
                                    <?php foreach ($sup as $supplier): ?>
                                        <option value="<?= $supplier->id; ?>"><?= html_escape($supplier->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="text-black-normal label mb-1">Status</label>
                                <select id="po_status" name="po_status" class="form-control form-select form-select-sm">
                                    <option value=""> All Status </option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3 pt-4">
                                <button type="submit" class="btn btn-search w-100" id="data-filter">
                                     Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!--<div class="card-title"> Purchase Order List </div>-->
                        <div class="d-flex gap-4">
                            <div>
                                <strong>Total PO Amount :</strong>
                                <span id="totalPoAmount">0 LKR</span>
                            </div>
                            <div>
                                <!--<strong>Total POs :</strong>
                                <span id="totalPoCount">0</span>-->
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="PO_table" class="table table-stripe text-nowrap w-100 dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PO Number</th>
                                        <th>Order Date</th>
                                        <th>Supplier</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>PO Amount</th>
                                        <th>Items</th>
                                        <th class="text-center">Actions</th>
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
    function formatCurrency(value){
        return new Intl.NumberFormat('en-LK', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(parseFloat(value) || 0);
    }

    $(document).ready(function(){
        loadPoList();
        loadPoCounts();
        
        $('#data-filter').on('submit', function(e){
            e.preventDefault();
            loadPoList();
        });
    });

    function loadPoList(){ 
        if ($.fn.DataTable.isDataTable('#PO_table')) {
            let table = $('#PO_table').DataTable();
            table.clear().destroy();
        }

        $.ajax({
            url: "/Po/list",
            type: "GET",
            dataType: "json",
            data: {
                date_range: $('.date-range-input').val(),
                fk_sup_id: $('#sup').val(),
                po_status: $('#po_status').val()
            },
            success: function(res){
                let tbody = '';
                let totalAmount = 0;
                let totalCount = 0;

                if(res.data && res.data.length > 0){
                    $.each(res.data, function(i, po){
                        totalAmount += parseFloat(po.po_amount || 0);
                        totalCount++;

                        let statusClass = '';
                        switch(po.status) {
                            case 'draft': statusClass = 'badge-secondary'; break;
                            case 'submitted': statusClass = 'badge-warning'; break;
                            case 'approved': statusClass = 'badge-success'; break;
                            case 'rejected': statusClass = 'badge-danger'; break;
                            default: statusClass = 'badge-secondary';
                        }

                        tbody += `
                            <tr>
                                <td>${i+1}</td>
                                <td><strong>${po.po_number}</strong></td>
                                <td>${po.created_at ? po.created_at.split(' ')[0] : '-'}</td>
                                <td>${po.supplier_name ?? '-'}</td>
                                <td>${po.created_by_name ?? '-'}</td>
                                <td><span class="${statusClass}">${po.status}</span></td>
                                <td class="text-center fw-normal">${formatCurrency(po.po_amount)}</td>
                                <td class="text-center">
                                   
                                         ${po.item_count || 0}
                                    
                                </td>
                                <td class="text-center">
                                    <a href="/Po/index?id=${po.id}" class="btn btn-icon btn-sm btn-info-light">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <a href="/Po/print_po?id=${po.id}" class="btn btn-icon btn-sm btn-success-light" target="">
                                        <i class="ri-printer-line"></i>
                                    </a>
                                    ${po.status === 'draft' ? 
                                        `<button class="btn btn-icon btn-sm btn-danger-light delete-po" data-id="${po.id}">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>` : ''
                                    }
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbody = `<tr><td colspan="9" class="text-center text-muted">No Purchase Orders Found</td></tr>`;
                }

                $('#PO_table tbody').html(tbody);
                $('#totalPoAmount').text(formatCurrency(totalAmount) + ' LKR');
                $('#totalPoCount').text(totalCount);

                initializeDataTable('#PO_table');
            },
            error: function(xhr, status, error) {
                console.error('Error loading PO list:', error);
                $('#PO_table tbody').html('<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    // View PO Items
    $(document).on('click', '.btnViewItems', function () {
        let po_id = $(this).data('id');
        const modal = new bootstrap.Modal(document.getElementById('poItemsModal'));
        modal.show();

        $('#poItemsTableBody').html('<tr><td colspan="8" class="text-center">Loading...</td></tr>');
        $('#poTotalAmount').text('0');

        $.ajax({
            url: "/Po/get_po_items",
            type: "GET",
            data: {po_id: po_id},
            dataType: "json",
            success: function(res){
                let html = '';
                let totalAmount = 0;

                if(res.data && res.data.length > 0){
                    $.each(res.data, function(i, item){
                        totalAmount += parseFloat(item.line_total || 0);
                        html += `
                            <tr>
                                <td>${i + 1}</td>
                                <td>${item.product_name}</td>
                                <td>${item.product_code ?? '-'}</td>
                                <td class="text-center">${item.quantity}</td>
                                <td class="text-end">${formatCurrency(item.unit_price)}</td>
                                <td class="text-end">${formatCurrency(item.discount_value || 0)}</td>
                                <td class="text-end">${formatCurrency(item.tax_value || 0)}</td>
                                <td class="text-end">${formatCurrency(item.line_total)}</td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="8" class="text-center text-muted">No Items Found</td></tr>`;
                }

                $('#poItemsTableBody').html(html);
                $('#poTotalAmount').text(formatCurrency(totalAmount));
            },
            error: function() {
                $('#poItemsTableBody').html('<tr><td colspan="8" class="text-center text-danger">Error loading items</td></tr>');
            }
        });
    });

    // Delete PO
    $(document).on('click', '.delete-po', function () {
        let po_id = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this Purchase Order?')) {
            $.ajax({
                url: "/Po/delete_po",
                type: "POST",
                data: {po_id: po_id},
                dataType: "json",
                success: function(res){
                    if(res.status === 'success') {
                        showToast('PO deleted successfully', 'success');
                        loadPoList();
                        loadPoCounts();
                    } else {
                        showToast('Failed to delete PO', 'danger');
                    }
                },
                error: function() {
                    showToast('Error deleting PO', 'danger');
                }
            });
        }
    });

    /*function loadPoCounts() {
        $.ajax({
            url: "/Po/get_po_counts",
            type: "GET",
            dataType: "json",
            success: function(response){
                let html = '';
                response.forEach(function(item){
                    let bgClass = 'bg-primary';
                    let icon = 'bi-list-check';
                    
                    if(item.name === 'Draft'){
                        bgClass = 'bg-secondary';
                        icon = 'bi-file-earmark';
                    } else if(item.name === 'Submitted'){
                        bgClass = 'bg-warning';
                        icon = 'bi-send';
                    } else if(item.name === 'Approved'){
                        bgClass = 'bg-success';
                        icon = 'bi-check-circle';
                    } else if(item.name === 'Rejected'){
                        bgClass = 'bg-danger';
                        icon = 'bi-x-circle';
                    }

                    html += `
                        <div class="mini-card ${bgClass}">
                            <i class="bi ${icon}"></i>
                            ${item.total}
                            <span>${item.name} PO</span>
                        </div>
                    `;
                });
                $('#po-status-container').html(html);
            }
        });
    }*/
	
	/*function loadPoCounts() {
    $.ajax({
        url: "/Po/get_po_counts",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Check if response has the 'data' array based on your network reply
            const countData = response.data || response; 

            countData.forEach(function(item) {
                // Convert "Draft" to "draft" to match #val-draft
                let key = item.name.toLowerCase();
                
                // Target the specific span ID
                let targetSpan = $('#val-' + key);

                if (targetSpan.length) {
                    targetSpan.text(item.total);
                }
            });
        },
        error: function() {
            console.error('Failed to load PO counts');
        }
    });
}*/

/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadPoCounts() {
    $.ajax({
        url: "/Po/get_po_counts",
        type: "GET",
        dataType: "json",
        success: function(res) {

            console.log(res);

            // Storing the original array response
            GRN_ITEMS = res.data;
				
            
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
        approved:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Payment Completed' },
        submitted:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Awaiting Verification' },
        total: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
        rejected: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Needs Correction' },
        draft:    { icon: 'fa-file-lines',    bg: 'var(--primary-light)', ic: 'var(--primary)', sub: 'Saved Workspaces' }
    };

    // Generating array structure for your map generator loop
    var displayItems = GRN_ITEMS.map(function(item) {
        var key = (item.name || '').toLowerCase();
        var cfg = itemsConfig[key] || { icon: 'fa-boxes-stacked', bg: '#e2e8f0', ic: '#64748b', sub: 'Status Category' };
		
        return {
            icon: cfg.icon,
            ibg: cfg.bg,
            ic: cfg.ic,
            val: item.total,
            lbl: STATUS_LABELS[key] || item.name,
            sub: cfg.sub,
            extra: ''
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
</script>