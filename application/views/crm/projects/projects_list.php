
<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            
            <!-- PAGE HEADER WITH STATUS CARDS (exactly like leads) -->
            <div class="col-md-12 mt-3">
                <div class="card custom-card card-bg mb-20">
                    <div class="card-body"> 
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
                            <div class="d-flex align-items-center"> 
                                <span class="card-title me-6">Projects</span>
                                
                                <div class="d-flex gap-2 flex-wrap" id="project-status-container"> 
                                   <!--<div class="stat-pill active status-filter" data-status="" id="pill-total">
										<span class="num" id="val-total">0</span>
										<span class="lbl">Total Projects</span>
									</div>
									<div class="stat-pill status-filter" data-status="Active" id="pill-active">
										<span class="num" id="val-active">0</span>
										<span class="lbl">Active</span>
									</div>
									<div class="stat-pill status-filter" data-status="Completed" id="pill-completed">
										<span class="num" id="val-completed">0</span>
										<span class="lbl">Completed</span>
									</div>
									<div class="stat-pill status-filter" data-status="Cancelled" id="pill-cancelled">
										<span class="num" id="val-cancelled">0</span>
										<span class="lbl">Cancelled</span>
									</div>-->
                                </div>
                            </div> 
                            
                            <div class="d-flex flex-wrap gap-2 align-items-center"> 
                                <button class="btn btn-add" id="btnAddProject">
                                    <i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Project
                                </button>
                            </div> 
                        </div> 
                    </div>
					
					<div class="summary-bar" id="summary-bar"></div>
					
                </div>
            </div>
        
            <!-- FILTER SECTION (exactly like leads with date range) -->
            <div class="col-xl-12">
                <form id="data-filter">
                    <div class="card mb-3">
                        <div class="card-body row g-3">
                            <div class="col-md-3">
                                <label class="text-black-normal label mb-1">Date Range</label>
                                <input type="text" class="date-range-input daterangepicker-field form-control-sm" 
                                       id="dateRange" placeholder="Select Date Range" />
                            </div>
                            
                            <div class="col-md-3">
                                <label class="text-black-normal label mb-1">Customer</label>
                                <select id="customer" class="form-select form-select-sm js-example-basic-single">
                                    <option value="">-- All Customers --</option>
                                    <?php foreach($customers as $c): ?>
                                        <option value="<?= $c->cus_id ?>"><?= html_escape($c->cus_name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="text-black-normal label mb-1">Status</label>
                                <select class="form-select form-select-sm js-example-basic-single" id="status" class="form-select form-select-sm">
                                    <option value="">-- All Status --</option>
                                    <option value="Active">Active</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-search w-100 mt-4" id="searchBtn">
                                    </i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
            <!-- PROJECTS TABLE -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!--<div class="card-title">Projects List</div>-->
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="projectsTable" class="table table-striped text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Project Name</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Customer</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD / EDIT PROJECT MODAL -->
<div class="modal fade" id="projectModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form id="projectForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title" id="projectModalTitle">Add New Project</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="lid" id="project_id">

                    <div class="row gy-3">
                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Project Name *</label>
                            <input type="text" name="project_name" id="project_name" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Customer</label>
                            <select name="fk_cus_id" id="fk_cus_id" class="form-control form-select-sm">
                                <option value="">-- Select Customer --</option>
                                <?php foreach($customers as $c): ?>
                                    <option value="<?= $c->cus_id ?>"><?= html_escape($c->cus_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date_form" class="form-control form-control-sm">
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date_form" class="form-control form-control-sm">
                        </div>
						
						<div class="col-xl-6 mt-1">
						<label class="form-label">Estimated Budget (Rs.) *</label>
						<div class="input-group input-group-sm">
						<!--  <span class="input-group-text bg-light">Rs.</span>-->
						<input type="number" 
							name="estimated_budget" 
							id="estimated_budget" 
							class="form-control" 
							placeholder="0.00" 
							step="0.01" 
							min="0" 
							max="999999999999.99"
							required>
						</div>
						<div class="invalid-feedback" id="err-budget" style="display:none;">Please enter a realistic, positive budget amount.</div>
						</div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Status</label>
                            <select name="project_status" id="project_status" class="form-control form-select-sm">
                                <option value="Active">Active</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="col-xl-6 mt-1">
                            <label class="form-label">Attachment</label>
                            <input type="file" name="attachment" id="attachment" class="form-control form-control-sm">
                            <small class="text-muted">Allowed: jpg, jpeg, png, pdf, doc, docx (Max: 2MB)</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                   <button type="button" class="btn btn-light" onclick="forceCloseModal('projectModal')">
						Cancel Project
					</button>
                    <button type="submit" class="btn btn-primary" id="btn-sub">
                        <i class="ri-save-line me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- VIEW PROJECT MODAL (Full project details) -->
<div class="modal fade" id="viewProjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Project Details</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Project ID:</strong> <span id="view_project_id"></span></p>
                        <p><strong>Project Name:</strong> <span id="view_project_name"></span></p>
                        <p><strong>Customer:</strong> <span id="view_customer"></span></p>
                        <p><strong>Start Date:</strong> <span id="view_start_date"></span></p>
                        <p><strong>End Date:</strong> <span id="view_end_date"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> <span id="view_status" class="badge"></span></p>
                        <p><strong>Attachment:</strong> <span id="view_attachment"></span></p>
                        <p><strong>Created Date:</strong> <span id="view_created_at"></span></p>
                        <p><strong>Last Updated:</strong> <span id="view_updated_at"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
// Define ajax_submit plugin first (exactly like Leads)
(function($) {
    $.fn.ajax_submit = function(options) {
        var settings = $.extend({
            url: '',
            rest: false,
            callback: null
        }, options);
        
        this.on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            var $form = $(this);
            var $modal = $form.closest('.modal');
            
            $.ajax({
                url: settings.url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if(response.stt === 'ok') {
                        toastr.success(response.msg);
                        
                        // Reset form
                        $form[0].reset();
                        
                        // Force close modal with multiple methods
                        if($modal.length) {
                            $modal.modal('hide');
                        } else {
                            $('#projectModal').modal('hide');
                        }
                        
                        // Remove modal backdrop completely
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('overflow', 'auto');
                        $('body').css('padding-right', '');
                        
                        // Refresh table and counts
                        setTimeout(function() {
                            if(typeof filter === 'function') {
                                filter();
                            }
                            if(typeof loadProjectCounts === 'function') {
                                loadProjectCounts();
                            }
                        }, 500);
                        
                        if(settings.callback) {
                            settings.callback(response.data);
                        }
                    } else {
                        toastr.error(response.msg || 'Error occurred');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('AJAX Error: ' + error);
                    console.error(xhr.responseText);
                }
            });
        });
        
        return this;
    };
})(jQuery);

// Define del_modal plugin (exactly like Leads)
$.fn.del_modal = function(options) {
    var settings = $.extend({
        title: 'Confirm Delete',
        head: 'Delete',
        para: 'Are you sure?',
        id: null,
        url: '',
        callback: null
    }, options);
    
    if (confirm(settings.para)) {
        $.ajax({
            url: settings.url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.stt === 'ok') {
                    toastr.success(response.msg);
                    
                    // Refresh table and counts
                    setTimeout(function() {
                        if(typeof filter === 'function') {
                            filter();
                        }
                        if(typeof loadProjectCounts === 'function') {
                            loadProjectCounts();
                        }
                    }, 500);
                    
                    if(settings.callback) {
                        settings.callback(response);
                    }
                } else {
                    toastr.error(response.msg || 'Error deleting item');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('AJAX Error: ' + error);
                console.error('Delete error:', xhr.responseText);
            }
        });
    }
    
    return this;
};

$(document).ready(function () {
    
    
    const formModal = new bootstrap.Modal(document.getElementById('projectModal'));
    const viewModal = new bootstrap.Modal(document.getElementById('viewProjectModal'));

    // Initialize date range picker
    $('#dateRange').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        }
		
    });

    $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    loadProjectCounts();
    filter();
     
    // Load project counts by status
	/*function loadProjectCounts() {
		$.ajax({
			url: "/Projects/get_project_counts_ajax",
			type: "GET",
			dataType: "json",
			success: function(response) {
				// Update the numbers
				$('#val-total').text(response.total || 0);
				$('#val-active').text(response.active || 0);
				$('#val-completed').text(response.completed || 0);
				$('#val-cancelled').text(response.cancelled || 0);
								
			},
			error: function(xhr) {
				console.error("Failed to load project counts");
			}
		});
	}*/
	
	
	/* ═══════════════════════ DATA ═══════════════════════ */
// AJAX call for GRN Dashboard
var GRN_ITEMS = [];
var STATUS_LABELS = {};
var STATUS_CSS    = {};
var STATUS_ICON   = {};

function loadProjectCounts() {
    $.ajax({
        url: "/Projects/get_project_counts_ajax",
        type: "GET",
        dataType: "json",
        success: function(res) {

            console.log(res);

            // Storing the original array response
            // Storing the original array response
            GRN_ITEMS = Object.keys(res).map(function(key) {
                return {
                    name: key,         // e.g. "active_count"
                    total: res[key]    // e.g. 58
                };
            });
            
            // Dynamic mappings based on your design style
            GRN_ITEMS.forEach(function(item) {
                var key = (item.name || '').toLowerCase();

                // STATUS LABELS (e.g., "settled" -> "Settled")
                if (!STATUS_LABELS[key]) {
                    STATUS_LABELS[key] = item.name.split('_')[0] + ' count';
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
    var totalGrns = GRN_ITEMS.reduce(function(acc, item) { return acc + parseInt(item.total || 0); }, 0);
    
    // Mapping config for display panels
    var itemsConfig = {
        active:  { icon: 'fa-check-double',  bg: 'var(--success-light)', ic: 'var(--success)', sub: 'Active Category' },
        cancelled:  { icon: 'fa-clock',         bg: 'var(--warning-light)', ic: 'var(--warning)', sub: 'Inactive Category' },
        total: { icon: 'fa-circle-check',  bg: 'var(--teal-light)',    ic: 'var(--teal)',    sub: 'Verified Documents' },
        deleted_count: { icon: 'fa-circle-xmark',  bg: 'var(--danger-light)',  ic: 'var(--danger)',  sub: 'Deleted Category' },
       
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
        lbl: 'Total Sub Catagory Records',
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
	
	
$(document).on('click', '.status-filter', function () {

    let status = $(this).attr('data-status');

    console.log("Clicked Project Status:", status);

    // set dropdown filter
    $('#status').val(status);

    // reload table
    filter();

});
    
// Submit form using ajax_submit (like Leads)
$('#projectForm').ajax_submit({
    url: '/Projects/store',
    rest: false,
    
   
    // Most custom wrappers look for a baseline conditional check or run standard validation first
    beforeSubmit: function(formData, jqForm, options) {
        var budgetInput = $('#estimated_budget').val();
        var budgetValue = parseFloat(budgetInput);

        if (isNaN(budgetValue) || budgetValue < 0) {
            $('#estimated_budget').addClass('is-invalid');
            $('#err-budget').text('Budget cannot be negative or empty!').show();
            
            return false; 
        }
        
        $('#estimated_budget').removeClass('is-invalid');
        $('#err-budget').hide();
    },
    
    callback: function(id) {
        // Everything is handled in the plugin now
        console.log('Project saved with ID:', id);
        
        // If your plugin doesn't auto-hide the modal or trigger table updates, handle it here:
        // $('#projectModal').modal('hide');
        // if (typeof refreshProjectList === 'function') refreshProjectList();
    }
});

    // Add new project button
    $('#btnAddProject').click(function () {
        $('#projectModalTitle').text('Add New Project');
        $('#btn-sub').text('Save');
        $('#projectForm')[0].reset();
        $('#project_id').val('');
        formModal.show();
    });

    // Edit project
    $(document).on('click', '.btnEditProject', function () {
        let id = $(this).data('id');
        
        $('#projectModalTitle').text('Edit Project');
        $('#btn-sub').text('Update');
        $('#project_id').val(id);
        
        $.getJSON("/Projects/view?lid=" + id, function (res) {
            let project = res.project;
            
            $('#project_name').val(project.project_name);
            $('#fk_cus_id').val(project.fk_cus_id);
            $('#start_date_form').val(project.start_date);
            $('#end_date_form').val(project.end_date);
            $('#project_status').val(project.project_status);
            $('#estimated_budget').val(project.estimated_budget);
        });
        
        formModal.show();
    });

    // View project details
    $(document).on('click', '.btnViewProject', function () {
        let id = $(this).data('id');
        
        $.getJSON("/Projects/view?lid=" + id, function (res) {
            let project = res.project;
            
            $('#view_project_id').text(project.project_id);
            $('#view_project_name').text(project.project_name);
            $('#view_customer').text(project.cus_name || '-');
            $('#view_start_date').text(project.start_date || '-');
            $('#view_end_date').text(project.end_date || '-');
            
            let statusBadge = $('#view_status');
            statusBadge.text(project.project_status);
            statusBadge.removeClass().addClass('badge');
            
            if(project.project_status === 'Active') statusBadge.addClass('bg-success');
            else if(project.project_status === 'Completed') statusBadge.addClass('bg-info');
            else if(project.project_status === 'Cancelled') statusBadge.addClass('bg-danger');
            
            if(project.attachment) {
                $('#view_attachment').html(`<a href="/uploads/projects/${project.attachment}" target="_blank" class="text-primary">${project.attachment}</a>`);
            } else {
                $('#view_attachment').text('No attachment');
            }
            
            $('#view_created_at').text(project.created_at || '-');
            $('#view_updated_at').text(project.updated_at || '-');
            
            viewModal.show();
        });
    });

    // Filter form submit
    $('#data-filter').on('submit', function (e) {
        e.preventDefault();
        filter();
    });

    // DELETE PROJECT - Using del_modal (like Leads)
    $(document).on('click', '.btnDeleteProject', function () {
        let id = $(this).data('id');
        
        $(this).del_modal({
            title: 'Delete',
            head: 'Delete Project',
            para: 'Do you want to delete this project?',
            id: id,
            url: '/Projects/delete?lid=' + id,
            callback: function(response) {
                // Refresh is already handled in the plugin
                console.log('Delete callback executed');
            }
        });
    });
    
    function filter() {
        if ($.fn.DataTable.isDataTable('#projectsTable')) {
            $('#projectsTable').DataTable().destroy();
        }

        // Parse date range
        let dateRange = $('#dateRange').val();
        let startDate = '', endDate = '';
        
        if (dateRange) {
            let dates = dateRange.split(' - ');
            startDate = dates[0] || '';
            endDate = dates[1] || '';
        }

        $.ajax({
            url: "/Projects/filter",
            type: "POST",
            data: {
                start_date: startDate,
                end_date: endDate,
                customer: $('#customer').val(),
                status: $('#status').val()
            },
            dataType: "json",
            success: function (res) {
                let tbody = '';

                if (res.data.length > 0) {
                    $.each(res.data, function (i, project) {
                        
                        let statusClass = project.project_status === 'Active' ? 'bg-success' :
                                         project.project_status === 'Completed' ? 'bg-info' :
                                         project.project_status === 'Cancelled' ? 'bg-danger' : 'bg-secondary';
                        
                        let actionBtns = `                          
							
							<!--<a href="<?= site_url('Projects/project_Dashboard/') ?>${project.project_id}" class="btn btn-sm btn-icon btn-info-light" title="View Dashboard">
								<i class="ri-eye-line"></i>
							</a>-->
							
							<a href="/Projects/project_Dashboard?project_id=${project.project_id}" class="btn btn-sm btn-icon btn-info-light" title="View Dashboard">
								<i class="ri-eye-line"></i>
							</a>
                            <button class="btn btn-sm btn-icon btn-warning-light btnEditProject" data-id="${project.project_id}" title="Edit">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-sm btn-danger-light btn-icon btnDeleteProject" data-id="${project.project_id}" title="Delete">
                                <i class="ri-delete-bin-line"></i>
                            </button>`;

                        tbody += `
                            <tr>
                                <td>${project.project_id}</td>
                                <td>${project.project_name || '-'}</td>
                                <td>${project.end_date || '-'}</td>
                                <td><span class="badge ${statusClass}">${project.project_status}</span></td>
                                <td>${project.cus_name || '-'}</td>
                                <td class="text-right ">${actionBtns}</td>
                            </tr>`;
                    });
                } else {
                    tbody = `<tr>
                                <td colspan="6" class="text-center text-muted">
                                    No projects found
                                </td>
                             </tr>`;
                }

                $('#projectsTable tbody').html(tbody);
                initializeDataTable('#projectsTable');
                loadProjectCounts();
            }
        });
    }
});

// Force close modal function
function forceCloseModal(modalId) {
    const modalEl = document.getElementById(modalId);
    const modal = bootstrap.Modal.getInstance(modalEl);
    
    if (modal) {
        modal.hide();
    }
    
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    $('body').css('overflow', 'auto');
}

// Reset form when modal is hidden
$('#projectModal').on('hidden.bs.modal', function () {
    $('#projectForm')[0].reset();
    $('#project_id').val('');
});

// DataTable initialization
function initializeDataTable(selector) {
    if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().destroy();
    }
    
    return $(selector).DataTable({
        "pageLength": 25,
        "ordering": true,
        "responsive": true,
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)"
        }
    });
}
</script>