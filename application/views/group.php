 <!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts Management</title>
    
    <!-- Add Remix Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
	<!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

	
	<style>
        :root {
            --primary-color: #4361ee;
            --danger-color: #e63946;
            --success-color: #2ecc71;
            --light-bg: #f8f9fa;
            --border-color: #e0e0e0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
            padding: 10px;
        }
        
        .card {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 10px;
        }
        
        /* Card header with multiple rows */
        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            border-radius: 8px 8px 0 0 !important;
            padding: 0.5rem 0.75rem;
        }
        
        /* First row: Info and buttons */
        .header-top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        /* Expanded group info - takes more horizontal space */
        .group-info-expanded {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #f8f9fa;
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
            border: 1px solid #e9ecef;
            font-size: 0.85rem;
            flex-grow: 1;
            margin-right: 1rem;
        }
        
        .group-title-expanded {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 2rem; /* Increased gap for more spacing */
        }
        
        .group-name {
            color: #2c3e50;
            font-weight: 600;
        }
        
        .group-date-separator {
            color: #adb5bd;
            font-size: 1rem;
        }
        
        .group-date {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 400;
        }
        
        .group-stats-expanded {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-left: auto;
        }
        
        .stat-item-expanded {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .stat-label-expanded {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        .stat-value-expanded {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.85rem;
        }
        
        /* Second row: Small Contacts title */
        .header-bottom-row {
            display: flex;
            align-items: center;
            padding-top: 0.25rem;
            border-top: 1px solid #f0f0f0;
        }
        
        .card-title-small {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.8rem; /* Smaller font */
            margin: 0;
            display: flex;
            align-items: center;
            line-height: 1;
        }
        
        /* Button styling */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
            border-radius: 6px;
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }
        
        .btn-primary:hover {
            background-color: #3a56d4;
            border-color: #3a56d4;
        }
        
        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            border-radius: 6px;
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }
        
        .btn-outline-secondary {
            border-radius: 6px;
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }
        
        .btn-outline-primary {
            border-radius: 6px;
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }
        
        .btn-outline-info {
            border-radius: 6px;
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }
        
        /* Table styling */
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            font-weight: 600;
            color: #495057;
            border-top: none;
            border-bottom: 1px solid var(--border-color);
            padding: 0.5rem 0.4rem;
            background-color: #f9fafc;
            font-size: 0.8rem;
        }
        
        .table td {
            padding: 0.5rem 0.4rem;
            vertical-align: middle;
            border-color: #f0f0f0;
            font-size: 0.85rem;
        }
        
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.02);
        }
        
        /* Clean name styling */
        .contact-name {
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.85rem;
        }
        
        .contact-phone {
            color: #6c757d;
            font-family: 'Courier New', monospace;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .contact-date {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 4px;
            align-items: center;
            justify-content: center;
        }
        
        .icon-btn {
            background: none;
            border: none;
            padding: 3px 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
        }
        
        .icon-btn:hover {
            background-color: rgba(0, 0, 0, 0.04);
        }
        
        .edit-btn {
            color: var(--primary-color);
        }
        
        .delete-btn {
            color: var(--danger-color);
        }
        
        /* Modal styling */
        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 0.8rem 1rem;
        }
        
        .modal-title {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .modal-body {
            padding: 0.8rem 1rem;
        }
        
        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 0.8rem 1rem;
        }
		
		.modal-backdrop {
    opacity: 0.5 !important;
    transition: opacity 0.15s linear !important;
}


.modal-backdrop.fade {
    opacity: 0 !important;
}
    

.modal-backdrop.show {
    opacity: 0.5 !important;
}

body.modal-open {
    overflow: hidden;
    padding-right: 0 !important;
}    
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
        }
        
        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 0.4rem 0.5rem;
            font-size: 0.85rem;
        }
        
        /* Button container */
        .header-buttons {
            display: flex;
            gap: 5px;
            align-items: center;
            flex-shrink: 0;
        }
        
        /* Card body - minimal padding */
        .card-body {
            padding: 0.5rem 0.75rem 0.75rem;
        }
        
        /* Table wrapper */
        .table-responsive {
            border-radius: 4px;
            border: 1px solid #edf2f9;
        }
        
        /* Container adjustments */
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .row {
            margin-left: -0.25rem;
            margin-right: -0.25rem;
        }
        
        .col-xl-12 {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        
        .form-text {
            font-size: 0.75rem !important;
        }
        
        /* Modal buttons */
        .modal-footer .btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.85rem;
        }
        
		
		.new-row-highlight {
    background-color: #e8f5e9 !important;
    transition: background-color 0.5s ease;
}



      /* Upload Modal Styles */
.modal-lg {
    max-width: 800px;
}

.custom-file-input {
    opacity: 0;
    position: absolute;
    z-index: 2;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    margin: 0;
    overflow: hidden;
}

.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    cursor: pointer;
}

.custom-file-label::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
    display: block;
    height: calc(1.5em + 0.75rem);
    padding: 0.375rem 0.75rem;
    line-height: 1.5;
    color: #495057;
    content: "Browse";
    background-color: #e9ecef;
    border-left: inherit;
    border-radius: 0 0.25rem 0.25rem 0;
}

/* Table styles for preview */
#previewTable th,
#confirmUploadTable th {
    background-color: #f8f9fa;
    font-weight: 600;
    font-size: 0.8rem;
}

#previewTable td,
#confirmUploadTable td {
    font-size: 0.85rem;
    padding: 0.4rem 0.5rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

/* Upload summary cards */
.card.bg-light,
.card.bg-success,
.card.bg-danger {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card.bg-success h5,
.card.bg-danger h5 {
    color: white !important;
}


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-top-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .group-info-expanded {
                width: 100%;
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
            
            .group-stats-expanded {
                margin-left: 0;
                width: 100%;
                justify-content: space-between;
            }
            
            .header-buttons {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 0.4rem;
            }
            
            .card-header {
                padding: 0.5rem 0.6rem;
            }
            
            .card-body {
                padding: 0.4rem;
            }
            
            .table td, .table th {
                padding: 0.4rem 0.3rem;
                font-size: 0.75rem;
            }
        }
        
        @media (max-width: 480px) {
            .group-info-expanded {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .group-stats-expanded {
                width: 100%;
                justify-content: space-between;
            }
            
            .header-buttons .btn {
                flex: 1;
                min-width: calc(50% - 5px);
                text-align: center;
                justify-content: center;
            }
        }
		
		#filterControls {
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

#filterControls .form-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.25rem;
}

#filterControls .form-control,
#filterControls .form-select {
    font-size: 0.8rem;
    border-color: #ced4da;
}

#filterControls .input-group-text {
    font-size: 0.8rem;
}

#filterCountBadge {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
}

@media (max-width: 768px) {
    #filterControls .col-md-4,
    #filterControls .col-md-3,
    #filterControls .col-md-2 {
        margin-bottom: 0.5rem;
    }
}

#custom-toast-container {
    position: fixed !important;
    top: 20px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    z-index: 9999 !important;
    max-width: 400px !important;
    width: 90% !important;
}
    </style>
</head>

<body>
    <!-- Loader -->
    <div id="loader" style="display: none;">
        <img src="../assets/images/media/loader.svg" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Contacts Management Card -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <!-- First row: Info and buttons -->
                                <div class="header-top-row">
								
                                    <!-- Expanded group info -->
                                    <div class="group-info-expanded">
									    
                                        <div class="group-title-expanded">
										   <?php if(isset($group)): ?>
                                            <span class="group-name"><?php echo htmlspecialchars($group['group_name']); ?></span>
                                             
                                             <span class="group-date">Date Created <?php echo date('Y.m.d', strtotime($group['created_date'])); ?></span>
                                              <?php endif; ?>
										  </div>
                                        <div class="group-stats-expanded">
                                            <div class="stat-item-expanded">
                                                <span class="stat-label-expanded">All Contacts:</span>
                                                <span class="stat-value-expanded"><?php echo isset($contact_count) ? $contact_count : '0'; ?></span>
                                            </div>
                                            <div class="stat-item-expanded">
                                                <span class="stat-label-expanded">Last campaign:</span>
                                                <span class="stat-value-expanded">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Action buttons -->
                                    <div class="header-buttons">
                                        <button type="button" class="btn btn-outline-primary" id="filterToggleBtn">
                                            <i class="fas fa-filter me-1"></i>Filter
                                        </button>
                                        <button type="button" class="btn btn-outline-info" id="uploadContactsBtn" data-bs-toggle="modal" data-bs-target="#uploadContactsModal">
                                             <i class="fas fa-file-upload me-1"></i>Upload
                                        </button>
                                        <button type="button" class="btn btn-primary btn-add-contact" data-bs-toggle="modal" data-bs-target="#addContactModal">
                                            <i class="fas fa-plus me-1"></i>Add Contact
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Second row: Small Contacts title -->
                                <div class="header-bottom-row">
                                    <div class="card-title-small">
                                        <i class="fas fa-address-book me-1" style="font-size: 0.75rem;"></i>Contacts 
                                    </div>
                                </div>
                            </div>
                            
							
							<!-- ============ ADD FILTER CONTROLS HERE ============ -->
<div id="filterControls" style="display: none; margin-top: 10px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
    <div class="row">
        <div class="col-md-4 mb-2">
            <label class="form-label small mb-1">Search</label>
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="searchFilter" class="form-control" placeholder="Name or phone...">
                <button class="btn btn-outline-secondary" type="button" id="clearSearchBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="col-md-3 mb-2">
            <label class="form-label small mb-1">Date</label>
            <select id="dateFilter" class="form-select form-select-sm">
                <option value="">All Dates</option>
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </select>
        </div>
        
        <div class="col-md-3 mb-2">
            <label class="form-label small mb-1">Sort By</label>
            <select id="sortFilter" class="form-select form-select-sm">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="name_asc">Name (A-Z)</option>
                <option value="name_desc">Name (Z-A)</option>
            </select>
        </div>
        
        <div class="col-md-2 mb-2 d-flex align-items-end">
            <div class="d-flex gap-2 w-100">
                <button class="btn btn-primary btn-sm flex-grow-1" id="applyFilterBtn">
                    <i class="fas fa-filter me-1"></i>Apply
                </button>
                <button class="btn btn-outline-secondary btn-sm" id="resetFilterBtn">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted" id="filterStatus">Ready to filter</small>
                <span id="filterCountBadge" class="badge bg-info" style="display: none;">0 results</span>
            </div>
        </div>
    </div>
</div>
<!-- ============ END FILTER CONTROLS ============ -->


                            <!-- Table -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="contacts-datatable" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone Number</th>
                                                <th>Created Date</th>
                                                <th class="text-center" style="width: 85px;">Options</th>
                                            </tr>
                                        </thead>
                                        <!-- Update the table body in group.php -->
<tbody>
    <?php if(isset($contacts) && !empty($contacts)): ?>
        <?php foreach($contacts as $contact): ?>
            <tr>
                <td>
                    <!-- Use contact_name (not name) -->
                    <div class="contact-name"><?php echo htmlspecialchars($contact['contact_name']); ?></div>
                </td>
                <td>
                    <!-- Use contact_number (not phone_number) -->
                    <span class="contact-phone"><?php echo htmlspecialchars($contact['contact_number']); ?></span>
                </td>
                <td>
                    <span class="contact-date"><?php echo date('Y.m.d', strtotime($contact['created_date'])); ?></span>
                </td>
                <td>
                    <div class="action-buttons">
                        <!-- Use contact_id -->
                        <button class="icon-btn edit-btn" title="Edit" onclick="editContact(<?php echo $contact['contact_id']; ?>)">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button class="icon-btn delete-btn" title="Delete" onclick="deleteContact(<?php echo $contact['contact_id']; ?>)">
                            <i class="ri-delete-bin-5-line"></i>
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center py-3">
                <div class="text-muted">No contacts found in this group.</div>
            </td>
        </tr>
    <?php endif; ?>
</tbody> 
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Contacts Management Card -->

            </div>
        </div>
        <!-- End::app-content -->
    </div>

    <!-- Add Contact Modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2" style="font-size: 0.9rem;"></i>Add New Contact
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addContactForm">
                        <div class="mb-3">
                            <label for="contactName" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="contactName" placeholder="Enter contact name" required>
                            <div class="form-text">Enter the full name of the contact.</div>
                        </div>
                        <div class="mb-3">
                            <label for="contactNumber" class="form-label">Contact Number *</label>
                            <input type="text" class="form-control" id="contactNumber" placeholder="Enter contact number" required>
                            <div class="form-text">Format: 071 1234567 or 078 1234567</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <div>
                        <button type="button" class="btn btn-success" id="saveContactBtn">
                            <i class="fas fa-save me-2"></i>Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<!-- Edit Contact Modal -->
<div class="modal fade" id="editContactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2" style="font-size: 0.9rem;"></i>Edit Contact
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editContactForm">
                    <input type="hidden" id="editContactId" value="">
                    <div class="mb-3">
                        <label for="editContactName" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="editContactName" placeholder="Enter contact name" required>
                        <div class="form-text">Enter the full name of the contact.</div>
                    </div>
                    <div class="mb-3">
                        <label for="editContactNumber" class="form-label">Contact Number *</label>
                        <input type="text" class="form-control" id="editContactNumber" placeholder="Enter contact number" required>
                        <div class="form-text">Format: 071 1234567 or 078 1234567</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <div>
                    <button type="button" class="btn btn-primary" id="updateContactBtn">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Upload Contacts Modal -->
<div class="modal fade" id="uploadContactsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-upload me-2" style="font-size: 0.9rem;"></i>Upload Contacts from Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Download the template file and fill in your contacts. Then upload it here.
                </div>
                
                <form id="uploadContactsForm" enctype="multipart/form-data">
                    <input type="hidden" id="uploadGroupId" value="<?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">CSV or Excel File *</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="excelFile" name="excel_file" accept=".csv,.xlsx,.xls" required>
                        </div>
                        <div class="form-text">
                            Supported formats: .xlsx, .xls (Max 5MB),.CSV
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Note (Optional)</label>
                        <input type="text" class="form-control" id="uploadNote" name="note" placeholder="Enter a note for this upload">
                        <div class="form-text">Add a description for this batch of contacts.</div>
                    </div>
                    
                    <div class="mb-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-download me-2 text-primary"></i>
                            <a href="#" id="downloadTemplate" class="text-decoration-none">
                                Download Excel Template
                            </a>
                        </div>
                    </div>
                </form>
                
                <!-- Preview Section (hidden by default) -->
                <div id="uploadPreview" style="display: none; margin-top: 20px;">
                    <hr>
                    <h6 class="mb-3">
                        <i class="fas fa-eye me-2"></i>Preview (First 5 rows)
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="previewTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preview rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted" id="totalRows"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <div>
                    <button type="button" class="btn btn-outline-primary" id="previewUploadBtn" style="display: none;">
                        <i class="fas fa-eye me-2"></i>Preview
                    </button>
                    <button type="button" class="btn btn-success" id="confirmUploadBtn">
                        <i class="fas fa-upload me-2"></i>Upload & Import
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Upload Modal -->
<div class="modal fade" id="confirmUploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2 text-success"></i>Confirm Contacts Upload
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Please review the contacts below before importing. Only valid contacts will be imported.
                </div>
                
                <div id="uploadSummary" class="mb-3">
                    <!-- Summary will be inserted here -->
                </div>
                
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover" id="confirmUploadTable">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Name</th>
                                <th width="35%">Phone Number</th>
                                <th width="25%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contacts will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel Upload
                </button>
                <div>
                    <button type="button" class="btn btn-primary" id="finalImportBtn">
                        <i class="fas fa-database me-2"></i>Import Selected Contacts
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

 <script>
  
function closeModalCleanly(modalId) {
     
    $('#' + modalId).modal('hide');
    
     
    setTimeout(function() {
         
        $('.modal-backdrop').remove();
         
        $('body').removeClass('modal-open');
         
        $('body').css('padding-right', '');
    }, 150);
}



function showToast(message, type = 'info', title = 'Info', duration = 3000, position = 'top-center' ) {
    let container = document.getElementById('custom-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'custom-toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
    const toastId = 'toast-' + Date.now();
    const typeClasses = {
        'success': 'bg-success text-white',
        'error': 'bg-danger text-white',
        'warning': 'bg-warning text-dark',
        'info': 'bg-info text-white',
        'loading': 'bg-info text-white'
    };
    
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header ${typeClasses[type] || 'bg-primary text-white'}">
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHtml);
    const toastEl = document.getElementById(toastId);
    
     
    const toast = new bootstrap.Toast(toastEl, {
        autohide: duration > 0,   
        delay: duration           
    });
    
    toastEl.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
    
    toast.show();
    return toast;
}

 
function showSuccessToast(message, title = 'Success') {
    return showToast(message, 'success', title, 3000);
}

function showErrorToast(message, title = 'Error') {
    return showToast(message, 'error', title, 5000);  
}

function showLoadingToast(message, title = 'Please wait') {
     
    let container = document.getElementById('custom-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'custom-toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
    const toastId = 'loading-toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-info text-white">
                <strong class="me-auto">${title}</strong>
                <div class="spinner-border spinner-border-sm text-light me-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHtml);
    const toastEl = document.getElementById(toastId);
    
     
    const toast = new bootstrap.Toast(toastEl, {
        autohide: true,
        delay: 3000
    });
    
    toast.show();
    
    return toast;
}

function showWarningToast(message, title = 'Warning') {
    return showToast(message, 'warning', title, 4000);
}

 function deleteContact(contactId) {
    console.log('Delete contact:', contactId);
    
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    
     
    let container = document.getElementById('custom-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'custom-toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
    const toastId = 'delete-confirm-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-header bg-warning text-dark">
                <strong class="me-auto">Confirm Delete</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                <p>Are you sure you want to delete this contact?</p>
                <div class="mt-3">
                    <button class="btn btn-sm btn-outline-secondary me-2" data-bs-dismiss="toast">Cancel</button>
                    <button class="btn btn-sm btn-danger" onclick="proceedWithDelete(${contactId}, ${groupId}, '${toastId}')">
                        <i class="ri-delete-bin-5-line me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHtml);
    new bootstrap.Toast(document.getElementById(toastId)).show();
}

function proceedWithDelete(contactId, groupId, toastId) {
     
    if (toastId && document.getElementById(toastId)) {
        const toastElement = document.getElementById(toastId);
        if (toastElement) {
            bootstrap.Toast.getInstance(toastElement)?.hide();
        }
    }
    
     
    showLoadingToast('Deleting contact...');
    
     
    const urls = [
        '../delete_contact',   
        '/welcome/delete_contact',   
        'delete_contact',   
        'welcome/delete_contact'   
    ];
    
     
    tryDelete(urls[0], contactId, groupId, 0, urls);
}



function tryDelete(url, contactId, groupId, index, urlList) {
    console.log('Trying URL:', url);
    
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            contact_id: contactId,
            group_id: groupId
        },
        dataType: 'json',
        success: function(response) {
            console.log('Success! Response:', response);
            
            if (response.success) {
                showSuccessToast('Contact deleted successfully!');
                
                 
                $(`button[onclick*="deleteContact(${contactId})"]`).closest('tr').fadeOut(300, function() {
                    $(this).remove();
                    
                     
                    if (response.contact_count !== undefined) {
                         
                        $('.stat-item-expanded').each(function() {
                            const label = $(this).find('.stat-label-expanded').text().trim();
                            if (label === 'All Contacts:') {
                                $(this).find('.stat-value-expanded').text(response.contact_count);
                                return false;
                            }
                        });
                    }
                    
					
					if (window.opener && !window.opener.closed) {
                        try {
                             
                            if (typeof window.opener.updateGroupParticipantCount === 'function') {
                                window.opener.updateGroupParticipantCount(groupId, response.contact_count);
                            }
                        } catch(e) {
                            console.log('Cannot access opener:', e);
                        }
                    }
					
					
                     
                    if ($('#contacts-datatable tbody tr').length === 0) {
                        $('#contacts-datatable tbody').html(
                            '<tr><td colspan="4" class="text-center py-3">' +
                            '<div class="text-muted">No contacts found in this group.</div>' +
                            '</td></tr>'
                        );
                    }
                });
            } else {
                showErrorToast(response.message || 'Failed to delete contact');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error with URL', url, ':', error);
            
             
            const nextIndex = index + 1;
            if (nextIndex < urlList.length) {
                tryDelete(urlList[nextIndex], contactId, groupId, nextIndex, urlList);
            } else {
                showErrorToast('Cannot connect to server. Please try again.');
                console.log('All URLs failed:', urlList);
            }
        }
    });
}


function testDeleteSystem() {
    console.log('=== Testing Delete System ===');
    
     
    console.log('jQuery:', typeof $ !== 'undefined' ? 'OK' : 'MISSING');
    
     
    console.log('Bootstrap:', typeof bootstrap !== 'undefined' ? 'OK' : 'MISSING');
    
     
    console.log('Current URL:', window.location.href);
    console.log('Current path:', window.location.pathname);
    
     
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    console.log('Group ID:', groupId);
    
     
    showSuccessToast('System test OK!');
    
     
    const firstBtn = $('button[onclick*="deleteContact"]').first();
    if (firstBtn.length) {
        const onclick = firstBtn.attr('onclick');
        const match = onclick.match(/deleteContact\((\d+)\)/);
        if (match) {
            console.log('First contact ID:', match[1]);
            console.log('Ready to delete!');
        }
    }
}

// ========================
// FILTER FUNCTIONALITY
// ========================

$(document).ready(function() {
     $('#filterToggleBtn').click(function() {
    const $filterControls = $('#filterControls');
    const isVisible = $filterControls.is(':visible');
    
    if (isVisible) {
        $filterControls.slideUp(300);
        $(this).removeClass('btn-primary').addClass('btn-outline-primary');
        $(this).find('i').removeClass('fa-times').addClass('fa-filter');
        $(this).find('span').text('Filter');
		
		resetFilters();
    } else {
        $filterControls.slideDown(300);
        $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        $(this).find('i').removeClass('fa-filter').addClass('fa-times');
        $(this).find('span').text('Close');
    }
});
    
     
    $('#clearSearchBtn').click(function() {
        $('#searchFilter').val('');
        applyFilters();
    });
    
     
    $('#applyFilterBtn').click(function() {
        applyFilters();
    });
    
     
    $('#resetFilterBtn').click(function() {
        resetFilters();
    });
    
     
    $('#searchFilter').keypress(function(e) {
        if (e.which === 13) {
            applyFilters();
        }
    });
    
     
    loadSavedFilters();
});

 
function loadSavedFilters() {
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    const savedFilters = localStorage.getItem(`contact_filters_${groupId}`);
    
    if (savedFilters) {
        const filters = JSON.parse(savedFilters);
        $('#searchFilter').val(filters.search || '');
        $('#dateFilter').val(filters.date || '');
        $('#sortFilter').val(filters.sort || 'newest');
        
        
        if (filters.search || filters.date || filters.sort !== 'newest') {
            applyFilters();
        }
    }
}

 
function saveFilters(search, date, sort) {
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    const filters = {
        search: search,
        date: date,
        sort: sort
    };
    localStorage.setItem(`contact_filters_${groupId}`, JSON.stringify(filters));
}

 
function applyFilters() {
    const searchTerm = $('#searchFilter').val().trim();
    const dateFilter = $('#dateFilter').val();
    const sortFilter = $('#sortFilter').val();
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    
     
    saveFilters(searchTerm, dateFilter, sortFilter);
    
     
     
    
     
    const filterData = {
        group_id: groupId,
        search: searchTerm,
        date_filter: dateFilter,
        sort_by: sortFilter
    };
    
     
    $.ajax({
        url: '/welcome/filter_contacts',   
        type: 'POST',
        data: filterData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                updateTableWithFilteredData(response.data.contacts);
                updateFilterStatus(response.data.filtered_count, response.data.total_count);
                showSuccessToast(`Showing ${response.data.filtered_count} of ${response.data.total_count} contacts`);
            } else {
                 
                clientSideFilter();
            }
        },
        error: function() {
             
            clientSideFilter();
        }
    });
}

 
function clientSideFilter() {
    const searchTerm = $('#searchFilter').val().trim().toLowerCase();
    const dateFilter = $('#dateFilter').val();
    const sortFilter = $('#sortFilter').val();
    
    const $rows = $('#contacts-datatable tbody tr');
    let visibleCount = 0;
    const totalCount = $rows.length;
    
    $rows.each(function() {
        const $row = $(this);
        const name = $row.find('.contact-name').text().toLowerCase();
        const phone = $row.find('.contact-phone').text().toLowerCase();
        const dateText = $row.find('.contact-date').text();
        
        let shouldShow = true;
        
         
        if (searchTerm) {
            if (!name.includes(searchTerm) && !phone.includes(searchTerm)) {
                shouldShow = false;
            }
        }
        
         
        if (shouldShow && dateFilter && dateText) {
            const contactDate = parseDateString(dateText);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            switch(dateFilter) {
                case 'today':
                    if (!isSameDay(contactDate, today)) shouldShow = false;
                    break;
                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1);
                    if (!isSameDay(contactDate, yesterday)) shouldShow = false;
                    break;
                case 'week':
                    const weekAgo = new Date(today);
                    weekAgo.setDate(weekAgo.getDate() - 7);
                    if (contactDate < weekAgo) shouldShow = false;
                    break;
                case 'month':
                    const monthAgo = new Date(today);
                    monthAgo.setDate(monthAgo.getDate() - 30);
                    if (contactDate < monthAgo) shouldShow = false;
                    break;
            }
        }
        
        if (shouldShow) {
            $row.show();
            visibleCount++;
        } else {
            $row.hide();
        }
    });
    
     
    applyClientSideSorting(sortFilter);
    
     
    updateFilterStatus(visibleCount, totalCount);
    showSuccessToast(`Showing ${visibleCount} of ${totalCount} contacts (client filter)`);
}

 
function parseDateString(dateStr) {
    if (!dateStr) return new Date();
    const parts = dateStr.split('.');
    if (parts.length === 3) {
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }
    return new Date();
}

 
function isSameDay(date1, date2) {
    return date1.getFullYear() === date2.getFullYear() &&
           date1.getMonth() === date2.getMonth() &&
           date1.getDate() === date2.getDate();
}

 
function applyClientSideSorting(sortBy) {
    const $table = $('#contacts-datatable');
    const $visibleRows = $table.find('tbody tr:visible').toArray();
    
    $visibleRows.sort(function(a, b) {
        const aName = $(a).find('.contact-name').text().toLowerCase();
        const bName = $(b).find('.contact-name').text().toLowerCase();
        const aDate = parseDateString($(a).find('.contact-date').text());
        const bDate = parseDateString($(b).find('.contact-date').text());
        
        switch(sortBy) {
            case 'oldest':
                return aDate - bDate;
            case 'name_asc':
                return aName.localeCompare(bName);
            case 'name_desc':
                return bName.localeCompare(aName);
            case 'newest':
            default:
                return bDate - aDate;
        }
    });
    
     
    $.each($visibleRows, function(index, row) {
        $table.find('tbody').append(row);
    });
}

 
function updateTableWithFilteredData(contacts) {
    const tbody = $('#contacts-datatable tbody');
    
    if (contacts.length === 0) {
        tbody.html(`
            <tr>
                <td colspan="4" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-search me-2"></i>
                        No contacts found matching your criteria
                    </div>
                </td>
            </tr>
        `);
        return;
    }
    
    let html = '';
    contacts.forEach(contact => {
        const dateStr = contact.created_date ? 
            contact.created_date.split(' ')[0].replace(/-/g, '.') : 
            contact.created_date || 'N/A';
            
        html += `
            <tr>
                <td>
                    <div class="contact-name">${contact.contact_name || 'N/A'}</div>
                </td>
                <td>
                    <span class="contact-phone">${contact.contact_number || 'N/A'}</span>
                </td>
                <td>
                    <span class="contact-date">${dateStr}</span>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="icon-btn edit-btn" title="Edit" onclick="editContact(${contact.contact_id})">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button class="icon-btn delete-btn" title="Delete" onclick="deleteContact(${contact.contact_id})">
                            <i class="ri-delete-bin-5-line"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.html(html);
}

 
function updateFilterStatus(filteredCount, totalCount) {
    const $badge = $('#filterCountBadge');
    const $status = $('#filterStatus');
    
    if (filteredCount === totalCount) {
        $badge.hide();
        $status.text('Showing all contacts');
    } else {
        $badge.text(`${filteredCount} of ${totalCount}`).show();
        $status.text('Filter applied');
    }
}

 function resetFilters() {
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    
     
    $('#searchFilter').val('');
    $('#dateFilter').val('');
    $('#sortFilter').val('newest');
    
     
    localStorage.removeItem(`contact_filters_${groupId}`);
    
     
     
    
     
    $.ajax({
        url: '/welcome/filter_contacts',   
        type: 'POST',
        data: { 
            group_id: groupId,
            reset_filters: true 
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                 
                updateTableWithFilteredData(response.data.contacts);
                updateFilterStatus(response.data.total_count, response.data.total_count);
                 
            } else {
                 
                fallbackReset();
            }
        },
        error: function() {
            fallbackReset();
        }
    });
}

 
function fallbackReset() {
    
    showErrorToast('Could not reset filters. Please refresh the page.');
}


// ========================
// EDIT CONTACT FUNCTIONS
// ========================

 
function editContact(contactId) {
    console.log('Edit contact:', contactId);
    
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    
     
     
    
     
    $.ajax({
        url: '/welcome/get_contact_for_edit',   
        type: 'POST',
        data: {
            contact_id: contactId,
            group_id: groupId
        },
        dataType: 'json',
        success: function(response) {
            console.log('Contact data:', response);
            
            if (response.success) {
                 
                $('#editContactId').val(response.data.contact.contact_id);
                $('#editContactName').val(response.data.contact.contact_name);
                $('#editContactNumber').val(response.data.contact.contact_number);
                
                 
                $('#editContactModal').modal('show');
                
                 
                //showSuccessToast('Contact loaded successfully');
            } else {
                showErrorToast(response.message || 'Failed to load contact');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading contact:', error);
            showErrorToast('Error loading contact details');
        }
    });
}

 
$(document).ready(function() {
    $('#updateContactBtn').click(function() {
        updateContact();
    });
    
     
    $('#editContactName, #editContactNumber').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            updateContact();
        }
    });
    
     
    $('#editContactModal').on('hidden.bs.modal', function() {
     
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
     
    $('#editContactForm')[0].reset();
    $('#editContactId').val('');
});
});

 
function updateContact() {
     
    const contactId = $('#editContactId').val();
    const contactName = $('#editContactName').val().trim();
    const contactNumber = $('#editContactNumber').val().trim();
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    
     
    if (!contactName) {
        showErrorToast('Contact name is required');
        $('#editContactName').focus();
        return;
    }
    
    if (!contactNumber) {
        showErrorToast('Contact number is required');
        $('#editContactNumber').focus();
        return;
    }
    
 
    const phoneRegex = /^0[0-9]{9}$/; // 0711234567 format
    const cleanNumber = contactNumber.replace(/\s/g, ''); // Remove spaces
    if (!phoneRegex.test(cleanNumber)) {
        showErrorToast('Please enter a valid phone number (10 digits starting with 0)');
        $('#editContactNumber').focus();
        return;
    }
    
     
    showLoadingToast('Updating contact...');
    
     
    const originalText = $('#updateContactBtn').html();
    $('#updateContactBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');
    
     
    $.ajax({
        url: '/welcome/update_contact',   
        type: 'POST',
        data: {
            contact_id: contactId,
            contact_name: contactName,
            contact_number: contactNumber,
            group_id: groupId
        },
        dataType: 'json',
        success: function(response) {
             
            $('#updateContactBtn').prop('disabled', false).html(originalText);
            
            if (response.success) {
                 
                showSuccessToast(response.message || 'Contact updated successfully!');
                
                // Close modal
               // $('#editContactModal').modal('hide');
                
				
				closeModalCleanly('editContactModal');
				
				
                 
                updateContactInTable(response.data.contact);
            } else {
                showErrorToast(response.message || 'Failed to update contact');
            }
        },
        error: function(xhr, status, error) {
             
            $('#updateContactBtn').prop('disabled', false).html(originalText);
            
            console.error('Update error:', error);
            showErrorToast('Error updating contact');
        }
    });
}

 
function updateContactInTable(contactData) {
     
    const rowSelector = `button[onclick*="editContact(${contactData.contact_id})"]`;
    const $row = $(rowSelector).closest('tr');
    
    if ($row.length) {
         
        $row.find('.contact-name').text(contactData.contact_name);
        $row.find('.contact-phone').text(contactData.contact_number);
        
         
        $row.addClass('table-info');
        setTimeout(() => {
            $row.removeClass('table-info');
        }, 1000);
        
        console.log('Contact updated in table:', contactData);
    }
}


// ========================
// ADD CONTACT FUNCTIONS
// ========================

 
$(document).ready(function() {
    $('#saveContactBtn').click(function() {
        addContact();
    });
    
     
    $('#contactName, #contactNumber').off('keypress').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            addContact();
        }
    });
    
    $('#addContactModal').on('show.bs.modal', function() {
        $('#addContactForm')[0].reset();
        
        $('#saveContactBtn').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Save');
    });
    
     
    $('#addContactModal').on('hidden.bs.modal', function() {
        $('#addContactForm')[0].reset();
    });
});

 
function addContact() {
     
    const contactName = $('#contactName').val().trim();
    const contactNumber = $('#contactNumber').val().trim();
    const groupId = <?php echo isset($group['group_id']) ? $group['group_id'] : '0'; ?>;
    
     
    if (!contactName) {
        showErrorToast('Contact name is required');
        $('#contactName').focus();
        return;
    }
    
    if (contactName.length < 2) {
        showErrorToast('Contact name must be at least 2 characters');
        $('#contactName').focus();
        return;
    }
    
    if (contactName.length > 45) {
        showErrorToast('Contact name must be less than 45 characters');
        $('#contactName').focus();
        return;
    }
    
    if (!contactNumber) {
        showErrorToast('Contact number is required');
        $('#contactNumber').focus();
        return;
    }
    
     
    const phoneRegex = /^0[0-9]{9}$/;
    const cleanNumber = contactNumber.replace(/\s/g, '');
    if (!phoneRegex.test(cleanNumber)) {
        showErrorToast('Please enter a valid phone number (10 digits starting with 0)');
        $('#contactNumber').focus();
        return;
    }
    
     
    showLoadingToast('Adding contact...');
    
     
    const originalText = $('#saveContactBtn').html();
    $('#saveContactBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
    
     
    const baseUrl = window.location.origin;
    const addContactUrl = baseUrl + '/welcome/add_contact';
    
     
    $.ajax({
        url: addContactUrl,
        type: 'POST',
        data: {
            contact_name: contactName,
            contact_number: cleanNumber,
            group_id: groupId
        },
        dataType: 'json',
        success: function(response) {
             
            $('#saveContactBtn').prop('disabled', false).html(originalText);
            
            if (response.success) {
                 
                hideToasts();
                
                 
                showSuccessToast(response.message || 'Contact added successfully!');
           
                /*const modal = bootstrap.Modal.getInstance(document.getElementById('addContactModal'));
				
                if (modal) {
                    modal.hide();
                } else {
                   // Fallback
                   $('#addContactModal').modal('hide');
                } 
				*/
				
				closeModalCleanly('addContactModal');
                
                
                if (response.data && response.data.contact) {
                     
                    setTimeout(function() {
                        addContactToTable(response.data.contact);
                    }, 300);
                }
                
                 
                if (response.contact_count !== undefined) {
                    updateContactCount(response.contact_count);
                }
            } else {
                showErrorToast(response.message || 'Failed to add contact');
            }
        },
        error: function(xhr, status, error) {
             
            $('#saveContactBtn').prop('disabled', false).html(originalText);
            
            console.error('Add contact error:', error);
            
             
            hideToasts();
            
             
            showErrorToast('Network error. Please check your connection and try again.');
            
               
        }
    });
}

function hideToasts() {
    $('.toast').toast('hide');
     
    setTimeout(function() {
        $('.toast-container').remove();
    }, 500);
}


function updateContactCount(count) {
     
    $('.stat-item-expanded').each(function() {
        const $label = $(this).find('.stat-label-expanded');
        if ($label.text().includes('All Contacts:')) {
            $(this).find('.stat-value-expanded').text(count);
        }
    });
}

 



 function addContactToTable(contactData) {
     
    const $firstRow = $('#contacts-datatable tbody tr:first');
    if ($firstRow.length && $firstRow.find('td[colspan="4"]').length > 0) {
        $firstRow.remove();
    }
    
    let dateStr;
    if (contactData.created_date) {
         
        const datePart = contactData.created_date.split(' ')[0]; // Get "2026-02-01"
        const parts = datePart.split('-'); // Split into [2026, 02, 01]
        if (parts.length === 3) {
            dateStr = `${parts[0]}.${parts[1]}.${parts[2]}`; // Format as "2026.02.01"
        } else {
             
            dateStr = datePart.replace(/-/g, '.');
        }
    } else {
         
        const today = new Date();
        dateStr = `${today.getFullYear()}.${String(today.getMonth() + 1).padStart(2, '0')}.${String(today.getDate()).padStart(2, '0')}`;
    }	
	 
	 
     
    const newRow = `
        <tr>
            <td>
                <div class="contact-name">${contactData.contact_name || 'New Contact'}</div>
            </td>
            <td>
                <span class="contact-phone">${contactData.contact_number || ''}</span>
            </td>
            <td>
                <span class="contact-date">${dateStr}</span>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="icon-btn edit-btn" title="Edit" onclick="editContact(${contactData.contact_id})">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="icon-btn delete-btn" title="Delete" onclick="deleteContact(${contactData.contact_id})">
                        <i class="ri-delete-bin-5-line"></i>
                    </button>
                </div>
            </td>
        </tr>
    `;
    
     
    $('#contacts-datatable tbody').prepend(newRow);
    
     
    const $newRow = $('#contacts-datatable tbody tr:first');
    $newRow.hide().fadeIn(500);
    $newRow.addClass('new-row-highlight');
    setTimeout(() => {
        $newRow.removeClass('new-row-highlight');
    }, 2000);
    
    console.log('Contact added to table:', contactData);
}

// ========================
// UPLOAD CONTACTS FUNCTIONS
// ========================

$(document).ready(function() {
     
    $('#uploadContactsBtn').click(function() {
         
        $('#uploadContactsForm')[0].reset();
        $('#uploadPreview').hide();
        $('#previewUploadBtn').hide();
        $('#confirmUploadBtn').show();
    });
    
     
    $('#downloadTemplate').click(function(e) {
        e.preventDefault();
        downloadTemplate();
    });
    
     
    $('#previewUploadBtn').click(function() {
        previewUpload();
    });
    
     
    $('#confirmUploadBtn').click(function() {
        confirmUpload();
    });
    
     
    $('#finalImportBtn').click(function() {
        importContacts();
    });
    
     
    $('#excelFile').change(function() {
        const file = this.files[0];
        if (file) {
             
            $('#previewUploadBtn').show();
            
             
            if (file.size > 5 * 1024 * 1024) {
                showErrorToast('File size must be less than 5MB');
                $(this).val('');
                $('#previewUploadBtn').hide();
                return;
            }
            
             
            const validExtensions = ['.csv', '.xlsx', '.xls'];
            const fileName = file.name.toLowerCase();
            const isValid = validExtensions.some(ext => fileName.endsWith(ext));
            
            if (!isValid) {
                showErrorToast('Please upload an Excel file (.xlsx or .xls)');
                $(this).val('');
                $('#previewUploadBtn').hide();
                return;
            }
        } else {
            $('#previewUploadBtn').hide();
        }
    });
});

 
function downloadTemplate() {
    showLoadingToast('Preparing template...');
    
     
    const csvContent = [
        // UTF-8 BOM + Headers
        '\ufeffName,Phone Number',
        // Sample data (Excel will preserve leading zeros in CSV)
        'John Doe,"0711234567"',
        'Jane Smith,"0789876543"', 
        'Robert Johnson,"0765551234"',
        '',
        'IMPORTANT NOTES:',
        '1. Keep headers in first row',
        '2. Name column is required',
        '3. Phone numbers in quotes to preserve leading zeros',
        '4. Do not change column order',
        '5. Maximum 1000 contacts per file',
        '',
        'HOW TO USE:',
        '1. Open in Excel or any text editor',
        '2. Add your contacts',
        '3. Save and upload here',
        '4. Phone numbers must be 10 digits starting with 0'
    ].join('\n');
    
    // Create and download CSV file
    const blob = new Blob([csvContent], { 
        type: 'text/csv;charset=utf-8;' 
    });
	
     
    const link = document.createElement('a');
    if (window.navigator.msSaveOrOpenBlob) {
        // For IE
        window.navigator.msSaveBlob(blob, 'Contacts_Template.csv');
    } else {
         
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.download = 'Contacts_Template.csv';
        document.body.appendChild(link);
        link.click();
        setTimeout(() => {
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        }, 100);
    }
    showSuccessToast('CSV Template downloaded!');
}    
    

 
function previewUpload() {
    const fileInput = $('#excelFile')[0];
    const file = fileInput.files[0];
    
    if (!file) {
        showErrorToast('Please select a CSV or Excel file first');
        return;
    }
    
    showLoadingToast('Reading file...');
    
    const reader = new FileReader();
	
    reader.onload = function(e) {
        try {
            let jsonData;
            const fileName = file.name.toLowerCase();
            
            if (fileName.endsWith('.csv')) {
                 
                jsonData = parseCSVAdvanced(e.target.result);
            } else if (fileName.endsWith('.xlsx') || fileName.endsWith('.xls')) {
                 
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
            } else {
                showErrorToast('Unsupported file format. Use CSV or Excel.');
                return;
            }
            
             
            if (jsonData.length <= 1) {
                showErrorToast('File is empty or has no data');
                return;
            }
            
             
            displayPreview(jsonData);
            //showSuccessToast('File preview loaded');
            
        } catch (error) {
            console.error('Error reading file:', error);
            showErrorToast('Error reading file. Please check the format.');
        }
    };
    
    reader.readAsArrayBuffer(file);
}

   
function parseCSVAdvanced(data) {
     
    if (data instanceof ArrayBuffer) {
        const decoder = new TextDecoder('utf-8');
        data = decoder.decode(data);
    }
    
     
    if (data.charCodeAt(0) === 0xFEFF) {
        data = data.substring(1);
    }
    
    const rows = [];
    let currentRow = [];
    let inQuotes = false;
    let currentField = '';
    
    for (let i = 0; i < data.length; i++) {
        const char = data[i];
        const nextChar = data[i + 1];
        
        if (char === '"') {
            if (inQuotes && nextChar === '"') {
                 
                currentField += '"';
                i++;  
            } else {
                 
                inQuotes = !inQuotes;
            }
        } else if (char === ',' && !inQuotes) {
             
            currentRow.push(currentField);
            currentField = '';
        } else if (char === '\n' && !inQuotes) {
             
            currentRow.push(currentField);
            rows.push(currentRow);
            currentRow = [];
            currentField = '';
        } else if (char === '\r') {
             
            continue;
        } else {
            currentField += char;
        }
    }
    
     
    if (currentField !== '' || currentRow.length > 0) {
        currentRow.push(currentField);
        rows.push(currentRow);
    }
    
    return rows;
}

 
 
function displayPreview(data) {
    const previewTbody = $('#previewTable tbody');
    previewTbody.empty();
    
     
    const previewRows = data.slice(1, 6);
    
    previewRows.forEach((row, index) => {
        if (row.length >= 2) {
            const tr = `<tr>
                <td>${row[0] || ''}</td>
                <td>${row[1] || ''}</td>
            </tr>`;
            previewTbody.append(tr);
        }
    });
    
     
    const totalRows = data.length - 1;  
    $('#totalRows').text(`Total contacts in file: ${totalRows} (showing first 5)`);
    
     
    $('#uploadPreview').show();
}

 
function confirmUpload() {
    const fileInput = $('#excelFile')[0];
    const file = fileInput.files[0];
    const note = $('#uploadNote').val().trim();
    const groupId = $('#uploadGroupId').val();
    
    if (!file) {
        showErrorToast('Please select an Excel file first');
        return;
    }
    
    showLoadingToast('Validating contacts...');
    
    const reader = new FileReader();
    reader.onload = function(e) {
        try {
            let jsonData;
            const fileName = file.name.toLowerCase();
            
            if (fileName.endsWith('.csv')) {
                 
                jsonData = parseCSVAdvanced(e.target.result);
            } else if (fileName.endsWith('.xlsx') || fileName.endsWith('.xls')) {
                 
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
            } else {
                showErrorToast('Unsupported file format. Please use CSV or Excel.');
                return;
            }
            
            if (jsonData.length <= 1) {
                showErrorToast('File has no contact data');
                return;
            }
            
             
            const validationResult = validateExcelData(jsonData);
            
             
            displayConfirmation(validationResult, note, groupId);
            
             
            $('#uploadContactsModal').modal('hide');
            setTimeout(() => {
                $('#confirmUploadModal').modal('show');
            }, 300);
            
        } catch (error) {
            console.error('Error:', error);
            showErrorToast('Error processing file: ' + error.message);
        }
    };
    
    reader.readAsArrayBuffer(file);
}

 
function validateExcelData(data) {
    const contacts = [];
    let validCount = 0;
    let invalidCount = 0;
    
     
    for (let i = 1; i < data.length; i++) {
        const row = data[i];
        if (!row || row.length < 2) continue;
        
         
        if (row.every(cell => !cell || cell.toString().trim() === '')) {
            continue;
        }
        
        const name = (row[0] || '').toString().trim();
        
         
        let phone = row[1];
        
        if (phone === null || phone === undefined) {
            phone = '';
        } else {
            phone = phone.toString().trim();
            
             
            if (phone.startsWith('"') && phone.endsWith('"')) {
                phone = phone.substring(1, phone.length - 1);
            }
            
             
            phone = phone.replace(/\D/g, '');
            
             
            if (phone.length === 9 && !phone.startsWith('0')) {
                phone = '0' + phone;
            }
        }
        
        const contact = {
            row: i + 1,
            name: name,
            phone: phone,
            status: 'pending'
        };
        
         
        if (!name || name.length < 2) {
            contact.status = 'invalid';
            contact.message = 'Name is required (min 2 chars)';
            invalidCount++;
        } else if (!phone || !/^0[0-9]{9}$/.test(phone)) {
            contact.status = 'invalid';
            contact.message = `Invalid phone: ${phone || 'empty'}. Must be 10 digits starting with 0`;
            invalidCount++;
        } else {
            contact.status = 'valid';
            contact.message = 'Ready to import';
            validCount++;
        }
        
        contacts.push(contact);
    }
    
    return {
        contacts: contacts,
        validCount: validCount,
        invalidCount: invalidCount,
        totalCount: contacts.length
    };
}


 
function displayConfirmation(result, note, groupId) {
    const summaryHtml = `
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="mb-1">${result.totalCount}</h5>
                        <small class="text-muted">Total Contacts</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="mb-1">${result.validCount}</h5>
                        <small>Valid Contacts</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h5 class="mb-1">${result.invalidCount}</h5>
                        <small>Invalid Contacts</small>
                    </div>
                </div>
            </div>
        </div>
        ${note ? `<div class="alert alert-info mt-3"><strong>Note:</strong> ${note}</div>` : ''}
    `;
    
    $('#uploadSummary').html(summaryHtml);
    
    // Display contacts in table
    const tbody = $('#confirmUploadTable tbody');
    tbody.empty();
    
    result.contacts.forEach(contact => {
        const statusClass = contact.status === 'valid' ? 'success' : 'danger';
        const statusIcon = contact.status === 'valid' ? 'fa-check' : 'fa-times';
        
        const tr = `
            <tr class="${contact.status === 'valid' ? 'table-success' : 'table-danger'}">
                <td>${contact.row}</td>
                <td>${contact.name}</td>
                <td>${contact.phone}</td>
                <td>
                    <span class="badge bg-${statusClass}">
                        <i class="fas ${statusIcon} me-1"></i>
                        ${contact.message}
                    </span>
                </td>
            </tr>
        `;
        tbody.append(tr);
    });
    
     
    $('#confirmUploadModal').data('importData', {
        contacts: result.contacts.filter(c => c.status === 'valid'),
        note: note,
        groupId: groupId
    });
}

 
function importContacts() {
    const importData = $('#confirmUploadModal').data('importData');
    
    if (!importData || importData.contacts.length === 0) {
        showErrorToast('No valid contacts to import');
        return;
    }
    
    showLoadingToast(`Importing ${importData.contacts.length} contacts...`);
    
     
    $('#finalImportBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Importing...');
    
     
    const formData = new FormData();
    formData.append('group_id', importData.groupId);
    formData.append('note', importData.note || '');
    formData.append('contacts', JSON.stringify(importData.contacts.map(c => ({
        name: c.name,
        phone: c.phone
    }))));
    
     
    $.ajax({
        url: '/welcome/import_contacts',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('.toast').toast('hide');
                
                 
                closeModalCleanly('confirmUploadModal');
                
                 
                if (response.contact_count !== undefined) {
                    updateContactCount(response.contact_count);
                }
                
                 
                if (response.data && response.data.imported_contacts) {
                    response.data.imported_contacts.forEach(contact => {
                        addContactToTable(contact);
                    });
                }
                
                 
                if (response.data && response.data.summary) {
                    const summary = response.data.summary;
                    showSuccessToast(
                        `Import completed: ${summary.imported} imported, ${summary.skipped} skipped`,
                        //'Import Summary'
                    );
                }
                
            } else {
                showErrorToast(response.message || 'Import failed');
            }
        },
        error: function(xhr, status, error) {
            console.error('Import error:', error);
            showErrorToast('Error during import. Please try again.');
        },
        complete: function() {
             
            $('#finalImportBtn').prop('disabled', false).html('<i class="fas fa-database me-2"></i>Import Selected Contacts');
        }
    });
}

 
 
 
 
window.addContact = addContact;
 
window.editContact = editContact;
window.updateContact = updateContact;


window.deleteContact = deleteContact;
window.proceedWithDelete = proceedWithDelete;
window.tryDelete = tryDelete;
window.testDeleteSystem = testDeleteSystem;

 
 
</script> 
 
</body> 
</html>