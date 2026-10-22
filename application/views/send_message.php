 <!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>
    <!-- Add Remix Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
	<script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
	 


    <style>
     
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    /* Main container styles */
    .send-message-container {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }
    
    .message-section {
        flex: 2;
    }
    
    .contacts-section {
        flex: 1;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        flex-direction: column;
    }
    
    /* Message composition area */
    .message-composition {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 16px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    
    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }
    
    .message-header h5 {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
        letter-spacing: -0.01em;
    }
    
    .message-stats {
        color: #666;
        font-size: 13px;
        font-weight: 400;
        letter-spacing: -0.01em;
    }
    
    .message-stats span {
        display: inline-block;
    }
    
    .message-stats span:first-child {
        margin-right: 16px;
    }
    
    .message-textarea {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 12px;
        font-size: 14px;
        line-height: 1.5;
        resize: vertical;
        min-height: 120px;
        margin-bottom: 12px;
        font-weight: 400;
        color: #333;
        background: #fff;
        letter-spacing: -0.01em;
    }
    
    .message-textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }
    
    /* Message Actions (Edit & Send buttons) */
    .message-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding-top: 12px;
        border-top: 1px solid #eee;
    }
    
    .edit-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .edit-btn:hover {
        background: #e5e7eb;
        color: #374151;
        transform: translateY(-1px);
    }
    
    /* UPDATED: Message send button - Light gray-green color */
    .message-send-btn {
        padding: 7px 16px; /* Smaller padding */
        font-size: 12px; /* Smaller font */
        font-weight: 500;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); /* Light gray-green gradient */
        border: 1px solid #a7f3d0; /* Light gray-green border */
        border-radius: 6px;
        color: #065f46; /* Dark green text */
        transition: all 0.2s;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }
    
    .message-send-btn:hover {
        background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%); /* Slightly darker gray-green on hover */
        color: #064e3b; /* Darker green text */
        border-color: #6ee7b7;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(6, 95, 70, 0.08);
    }
    
    .message-send-btn:active {
        transform: translateY(0);
    }
    
    /* SMS Contacts Section */
    .sms-contacts-section {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
		margin-bottom: 40px !important;
    }
    
    .sms-contacts-section h5 {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 12px;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
    }
    
    .sms-contacts-section h5 i {
        margin-right: 8px;
        color: #4f46e5;
    }
    
    /* Contacts Table Styles */
    .contacts-table-container {
        overflow-x: auto;
        margin-top: 12px;
    }
    
    .contacts-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    
    .contacts-table thead {
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .contacts-table th {
        padding: 10px 12px;
        text-align: left;
        font-weight: 600;
        color: #475569;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }
    
    .contacts-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s;
        cursor: pointer;
    }
    
    .contacts-table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .contacts-table tbody tr.selected {
        background-color: #f0f9ff;
        border-left: 3px solid #0ea5e9;
    }
    
    .contacts-table td {
        padding: 12px 12px;
        vertical-align: middle;
    }
    
    .contact-name {
        font-weight: 500;
        color: #1e293b;
        font-size: 14px;
        letter-spacing: -0.01em;
    }
    
    .contact-phone {
        color: #64748b;
        font-size: 13px;
        font-weight: 400;
        letter-spacing: -0.01em;
        display: block;
    }
    
    .contact-date {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 400;
        letter-spacing: -0.01em;
        white-space: nowrap;
    }
    
    /* Right Column Sections */
    .excel-section {
        background: white;
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #e5e7eb;
        margin-bottom: 12px;
    }
    
    .excel-section h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 12px;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        padding-bottom: 8px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .excel-section h5 i {
        margin-right: 8px;
        color: #10b981;
        font-size: 16px;
    }
    
    /* Compact Excel Upload */
    .compact-upload-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    
    .compact-upload-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .compact-upload-text {
        font-size: 13px;
        font-weight: 500;
        color: #1e293b;
        letter-spacing: -0.01em;
    }
    
    .compact-upload-icon {
        font-size: 18px;
        color: #10b981;
    }
    
    .compact-upload-btn {
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 500;
        background: transparent; 
        color: #10b981;
        border: 1px solid #10b981;
        border-radius: 0.375rem;
        transition: color 0.15s ease-in-out, 
                background-color 0.15s ease-in-out, 
                border-color 0.15s ease-in-out, 
                box-shadow 0.15s ease-in-out;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        line-height: 1.5;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        text-decoration: none;
        white-space: nowrap;
    }
    
    .compact-upload-btn:hover {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }
    
    .compact-upload-btn:focus {
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }

    .compact-upload-btn:active {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }

    /* For the icon inside */
    .compact-upload-btn i {
        font-size: 10px;
        margin-right: 4px;
    }
    
    /* File info display - Made smaller */
    .file-info {
        background: #f8fafc;
        border-radius: 4px;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #e5e7eb;
        display: none;
        font-size: 12px;
    }
    
    .file-info.show {
        display: block;
    }
    
    .file-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .file-name {
        font-weight: 500;
        color: #1e293b;
        font-size: 12px;
    }
    
    .file-size {
        color: #64748b;
        font-size: 11px;
    }
    
    .file-progress {
        width: 100%;
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        overflow: hidden;
        margin: 8px 0;
    }
    
    .file-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
        width: 0%;
        transition: width 0.3s;
    }
    
    .file-status {
        font-size: 11px;
        color: #64748b;
        text-align: center;
    }
    
    /* Groups Section */
    .groups-section {
        background: white;
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #f1f5f9;
        margin-bottom: 12px;
    }
    
    .groups-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .groups-title {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .groups-title i {
        color: #94a3b8;
        font-size: 16px;
    }
    
    .groups-title span {
        font-size: 14px;
        font-weight: 500;
        color: #64748b;
        letter-spacing: -0.01em;
    }
    
    .add-group-btn {
        width: 24px;
        height: 24px;
        border-radius: 4px;
        background: #e2e8f0;
        border: 1px solid #cbd5e1;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 12px;
    }
    
    .add-group-btn:hover {
        background: #cbd5e1;
        transform: scale(1.1);
    }
    
    .groups-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 300px;
        overflow-y: auto;
    }
    
    .group-item {
        padding: 10px;
        background: #f8fafc;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .group-item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateX(2px);
    }
    
    .group-item.selected {
        background: #fffbeb;
        border-color: #f59e0b;
        border-left: 3px solid #f59e0b;
    }
    
    .group-name {
        font-size: 13px;
        font-weight: 400;
        color: #64748b;
        letter-spacing: -0.01em;
    }
    
    .group-count {
        font-size: 11px;
        background: #e2e8f0;
        color: #64748b;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .group-item.selected .group-count {
        background: #94a3b8;
        color: white;
    }
    
    /* Add New Contact Section */
    .add-contact-section {
        background: white;
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #e5e7eb;
    }
    
    .add-contact-section h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e5e7eb;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
    }
    
    .add-contact-section h5 i {
        margin-right: 8px;
        color: #8b5cf6;
        font-size: 16px;
    }
    
    .add-contact-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
    }
    
    .form-label {
        font-size: 12px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 4px;
        letter-spacing: -0.01em;
    }
    
    .form-input {
        padding: 8px 10px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 13px;
        transition: all 0.2s;
        color: #374151;
        letter-spacing: -0.01em;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    .add-contact-btn {
        padding: 9px 12px;
        font-size: 13px;
        font-weight: 500;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        border-radius: 4px;
        color: white;
        transition: all 0.2s;
        letter-spacing: -0.01em;
        margin-top: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    
    .add-contact-btn:hover {
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        transform: translateY(-1px);
    }
    
    /* UPDATED: Main Send Button - Light gray-green color */
    .send-button {
        width: 100%;
        padding: 7px 12px; /* Smaller padding */
        font-size: 12px; /* Smaller font */
        font-weight: 500;
        margin-top: 20px;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); /* Light gray-green gradient */
        border: 1px solid #a7f3d0; /* Light gray-green border */
        border-radius: 4px;
        color: #065f46; /* Dark green text */
        transition: all 0.2s;
        letter-spacing: -0.01em;
        box-shadow: 0 1px 2px rgba(6, 95, 70, 0.05);
    }
    
    .send-button:hover {
        background: linear-gradient(135deg, #a7f3d0 0%, #6ee7b7 100%); /* Slightly darker gray-green on hover */
        color: #064e3b; /* Darker green text */
        border-color: #6ee7b7;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(6, 95, 70, 0.08);
    }
    
    .send-button:active {
        transform: translateY(0);
    }
    
    /* Card styling */
    .card.custom-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 20px;
    }
    
    .card-title h4 {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin: 0;
        letter-spacing: -0.01em;
    }
    
    .card-body {
        padding: 20px;
    }
    
    /* Contact Actions */
    .contact-actions {
        display: flex;
        gap: 8px;
    }
    
    .contact-action-btn {
        width: 28px;
        height: 28px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .contact-action-btn:hover {
        background: #f1f5f9;
        color: #475569;
    }
    
    .contact-action-btn.delete:hover {
        color: #ef4444;
        background: #fef2f2;
    }
    
    /* Loading animation */
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 20px;
        color: #64748b;
    }
    
    .loading-spinner.active {
        display: block;
    }
    
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #0ea5e9;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 0 auto 10px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    
    .empty-state p {
        margin: 0;
        font-size: 14px;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .send-message-container {
            flex-direction: column;
        }
        
        .contacts-section {
            margin-top: 20px;
        }
    }
    
    /* Additional styling */
    h1, h2, h3, h4, h5, h6 {
        font-weight: 600;
        line-height: 1.25;
        color: #111827;
    }
    
    body {
        color: #374151;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    /* Icon styling */
    i {
        font-size: 14px;
    }
    
    .fas, .far, .fab {
        font-size: 14px;
    }
	
	/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    animation: fadeIn 0.2s ease-out;
}

.group-modal {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    animation: slideIn 0.2s ease-out;
}

.modal-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-header h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

.modal-close-btn {
    background: none;
    border: none;
    font-size: 24px;
    color: #6b7280;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
}

.modal-close-btn:hover {
    background: #f3f4f6;
    color: #374151;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 16px 20px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.modal-cancel-btn {
    padding: 8px 16px;
    background: #f3f4f6;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.modal-cancel-btn:hover {
    background: #e5e7eb;
}

.modal-submit-btn {
    padding: 8px 20px;
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.modal-submit-btn:hover {
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    transform: translateY(-1px);
}

.modal-submit-btn:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { 
        opacity: 0;
        transform: translateY(-20px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

.contacts-table tbody tr[data-source="excel"] { border-left: 3px solid #10b981; }
.contacts-table tbody tr[data-source="manual"] { border-left: 3px solid #3b82f6; }
.contacts-table tbody tr[data-source="existing"] { border-left: 3px solid #ef4444; }

.contacts-table tbody tr.selected[data-source] { border-left-width: 5px; }

</style> 
</head>

<body>

    <!-- Loader -->
    <div id="loader">
        <img src="../assets/images/media/loader.svg" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Send Message Header -->
                <div class="row">
                    <div class col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4><i class="fas fa-paper-plane me-2"></i>SMS Campaign</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Send Message Main Content -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <!-- Main Form Wrapper -->
                                <form id="smsCampaignForm" class="sms-campaign-form" method="POST" action="/welcome/save_sms_campaign">
                                    
                                    <div class="send-message-container">
                                        
                                        <!-- Left Column: SMS Contacts -->
                                        
										<div class="message-section">
                                            <!-- SMS Contacts Section -->
                                            <div class="sms-contacts-section">
                                                <h5><i class="fas fa-address-book"></i> SMS Contacts</h5>
                                                
                                                <!-- Loading Spinner -->
                                                <div class="loading-spinner" id="contactsLoading">
                                                    <div class="spinner"></div>
                                                    <p>Loading contacts...</p>
                                                </div>
                                                
                                                <div class="contacts-table-container">
                                                    <table class="contacts-table" id="contactsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Phone Number</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="contactsTableBody">
                                                            <!-- Contacts will be loaded dynamically via AJAX -->
                                                            <tr>
                                                                <td colspan="3" class="empty-state">
                                                                    <i class="fas fa-users"></i>
                                                                    <p>Select a group to view contacts</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            <!-- Message Composition -->
                                            <div class="message-composition">
                                                <div class="message-header">
                                                    <h5 class="mb-0">Type your message:</h5>
                                                    <div class="message-stats">
                                                        <span>Time: <span id="currentTime">09.51</span></span>
                                                        <span><span id="wordCount">0</span> words</span>
                                                    </div>
                                                </div>
                                                <textarea name="message_content" class="message-textarea" placeholder="Type your SMS message here..." id="messageContent">
Hello Team,

This is a reminder about our upcoming meeting scheduled for tomorrow at 10 AM. Please come prepared with your progress reports.

Best regards,
Management
                                                </textarea>
                                                
                                                <!-- Edit and Send buttons -->
                                                <div class="message-actions">
                                                    <button type="button" class="edit-btn" title="Edit Message" id="editMessageBtn">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="message-send-btn" id="sendMessageBtn">
                                                        <i class="fas fa-paper-plane"></i>
                                                        Send
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Right Column: Excel Upload, Groups & Add New Contact -->
                                        <div class="contacts-section">
                                            <!-- Excel Upload Section - Compact Version -->
                                            <div class="excel-section">
                                               <div class="compact-upload-container">
                    <div class="compact-upload-left">
                        <i class="fas fa-file-excel compact-upload-icon"></i>
                        <span class="compact-upload-text">Excel Sheet Upload</span>
                    </div>
                    <div class="compact-upload-right">
                         
                        <button type="button" class="compact-upload-btn" id="compactBrowseBtn">
                            <i class="fas fa-upload"></i>
                            Upload
                        </button>
                    </div>
                </div>  
                                                <!-- Hidden file input -->
                                                <input type="file" id="excelFileInput" accept=".xlsx,.xls,.csv" style="display: none;">
                           
                                                  <!-- File Info Display - Compact -->
                                                <div class="file-info" id="compactFileInfo">
                                                    <div class="file-header">
                                                        <div class="file-name" id="compactFileName">contacts.xlsx</div>
                                                        <div class="file-size" id="compactFileSize">245 KB</div>
                                                    </div>
                                                    <div class="file-progress">
                                                        <div class="file-progress-bar" id="compactFileProgressBar"></div>
                                                    </div>
                                                    <div class="file-status" id="compactFileStatus">Uploading...</div>
                                                </div>
                                            </div>
                                            
                                            <!-- Groups Section -->
                                            <div class="groups-section">
                                                <div class="groups-header">
                                                    <div class="groups-title">
                                                        <i class="fas fa-users"></i>
                                                        <span>Groups</span>
                                                    </div>
                                                    <button type="button" class="add-group-btn" title="Add New Group" id="addGroupBtn">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Loading Spinner for Groups -->
                                                <div class="loading-spinner" id="groupsLoading">
                                                    <div class="spinner"></div>
                                                    <p>Loading groups...</p>
                                                </div>
                                                
                                                <div class="groups-list" id="groupsList">
                                                    <!-- Groups will be loaded dynamically via AJAX -->
                                                    <div class="empty-state" style="padding: 20px;">
                                                        <i class="fas fa-spinner fa-spin"></i>
                                                        <p>Loading groups...</p>
                                                    </div>
                                                </div>
                                                
                                                <!-- Hidden input for selected group -->
                                                <input type="hidden" name="selected_group_id" id="selectedGroupId" value="">
                                            </div>
                                            
                                            <!-- Add New Contact Section -->
                                            <div class="add-contact-section">
                                                <h5><i class="fas fa-user-plus"></i>Add New Contact</h5>
                                                
                                                <div class="add-contact-form">
                                                    <!-- Hidden input for current group ID -->
                                                    <input type="hidden" id="currentGroupId" value="">
                                                    
                                                    <div class="form-group">
                                                        <label class="form-label" for="contactName">Full Name</label>
                                                        <input type="text" class="form-input" id="contactName" placeholder="Enter full name">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="form-label" for="contactNumber">Phone Number</label>
                                                        <input type="text" class="form-input" id="contactNumber" placeholder="Enter phone number">
                                                    </div>
                                                    
                                                    <button type="button" class="add-contact-btn" id="addContactBtn" disabled>
                                                        <i class="fas fa-plus-circle"></i> Add Contact
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <!-- Hidden input for selected contacts -->
                                            <input type="hidden" name="selected_contacts" id="selectedContactsInput" value="">
                                            
                                            <!-- Main Send Button -->
                                            <button type="button" class="send-button" id="mainSendBtn">
                                                <i class="fas fa-paper-plane"></i> Send Message to Selected Contacts
                                            </button>
                                        </div>
                                        
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End::app-content -->
    </div>

    <!-- JavaScript for AJAX functionality -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script>
	  
	 $(document).ready(function() {
		 console.log('Document ready - mainSendBtn exists:', $('#mainSendBtn').length);
         
        var currentGroupId = null;
        var selectedContacts = [];
        
         
        function updateCurrentTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            $('#currentTime').text(`${hours}.${minutes}`);
        }
        
         
        function updateWordCount() {
            const text = $('#messageContent').val();
            const wordCount = text.trim().split(/\s+/).filter(word => word.length > 0).length;
            $('#wordCount').text(wordCount);
        }
        
         
        updateCurrentTime();
        updateWordCount();
        setInterval(updateCurrentTime, 60000);  
        
         
        $('#messageContent').on('input', updateWordCount);
        
         
        loadGroups();
		
		function initExcelUpload() {
     
    $('#compactBrowseBtn').off('click').on('click', function() {
        $('#excelFileInput').click();
    });
    
     
    $('#excelFileInput').off('change').on('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });
    
     
    initDragAndDrop();
}

// 3. Handle file selection
function handleFileSelect(file) {
     
    if (!currentGroupId) {
        showNotification('error', 'Please select a group first');
        return;
    }
    
     
    if (!validateExcelFile(file)) {
        return;
    }
    
     
    displayFileInfo(file);
    
     
    processExcelFile(file, currentGroupId);
}

// 4. File validation
function validateExcelFile(file) {
    const validExtensions = ['xlsx', 'xls', 'csv'];
    const fileExtension = file.name.split('.').pop().toLowerCase();
    
     
    if (!validExtensions.includes(fileExtension)) {
        showNotification('error', 'Please upload Excel (.xlsx, .xls) or CSV files only');
        return false;
    }
    
     
    const maxSize = 5 * 1024 * 1024;
    if (file.size > maxSize) {
        showNotification('error', 'File size must be less than 5MB');
        return false;
    }
    
    return true;
}


// 5. Display file info
function displayFileInfo(file) {
     
    $('#compactFileInfo').addClass('show');
    
     
    $('#compactFileName').text(file.name);
    $('#compactFileSize').text(formatFileSize(file.size));
    
     
    $('#compactFileProgressBar').css('width', '0%');
    $('#compactFileStatus').text('Processing...');
}

// 6. Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
}

// 7. Process Excel file
function processExcelFile(file, groupId) {
    const reader = new FileReader();
    const fileExtension = file.name.split('.').pop().toLowerCase();
    
    reader.onload = function(e) {
        try {
            let contacts = [];
            
            if (fileExtension === 'csv') {
                contacts = parseCSVData(e.target.result);
            } else {
				if (typeof XLSX === 'undefined') {
                        showNotification('error', 'Excel processing library not available. Please refresh page.');
                        resetFileUpload();
                        return;
                    }
                contacts = parseExcelData(e.target.result);
            }
            
            if (contacts.length === 0) {
                showNotification('error', 'No valid contacts found in the file');
                resetFileUpload();
                return;
            }
            
             
            $('#compactFileProgressBar').css('width', '60%');
            $('#compactFileStatus').text(`Found ${contacts.length} contacts`);
            
             
            uploadContactsToServer(contacts, groupId, file.name);
            
        } catch (error) {
            console.error('Error processing file:', error);
            showNotification('error', 'Error processing file');
            resetFileUpload();
        }
    };
    
    reader.onerror = function() {
        showNotification('error', 'Error reading file');
        resetFileUpload();
    };
    
    reader.readAsBinaryString(file);
    
     
    $('#compactFileProgressBar').css('width', '30%');
    $('#compactFileStatus').text('Reading file...');
}

// 8. Parse CSV data (simple version)
function parseCSVData(csvData) {
    const contacts = [];
    const rows = csvData.split('\n');
    
    for (let i = 1; i < rows.length; i++) {  
        const row = rows[i].trim();
        if (!row) continue;
        
        const cells = [];
            let inQuotes = false;
            let currentCell = '';
            
            for (let j = 0; j < row.length; j++) {
                const char = row[j];
                
                if (char === '"') {
                    inQuotes = !inQuotes;
                } else if (char === ',' && !inQuotes) {
                    cells.push(currentCell.trim());
                    currentCell = '';
                } else {
                    currentCell += char;
                }
            }
            cells.push(currentCell.trim());
        
        if (cells.length >= 2) {
            const name = cells[0].replace(/^"|"$/g, '');
            let phone = cells[1].replace(/^"|"$/g, '').replace(/\D/g, '');
            
             if (i === 0 && (name.toLowerCase() === 'name' || phone.toLowerCase() === 'phone')) {
                    continue;
                }
            
             
            if (name && phone && phone.length >= 10) {
                contacts.push({
                    name: name.substring(0, 45),  
                    phone: phone.substring(0, 12)  
                });
            }
        }
    }
    
    return contacts;
}

// 9. Parse Excel data (requires SheetJS)
function parseExcelData(data) {
     
    
    try {
        const workbook = XLSX.read(data, { type: 'binary' });
        const firstSheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[firstSheetName];
        const jsonData = XLSX.utils.sheet_to_json(worksheet);
        
        const contacts = [];
        
        jsonData.forEach(row => {
             
            let name = '';
            let phone = '';
            
            for (const key in row) {
                const lowerKey = key.toLowerCase();
                const value = String(row[key] || '').trim();
                
                if (lowerKey.includes('name') && !name) {
                    name = value;
                } else if ((lowerKey.includes('phone') || lowerKey.includes('mobile') || 
                           lowerKey.includes('number')) && !phone) {
                    phone = value.replace(/\D/g, '');
                }
            }
            
             
            if (name && phone && phone.length >= 10) {
                contacts.push({
                    name: name.substring(0, 45),
                    phone: phone.substring(0, 12)
                });
            }
        });
        
        return contacts;
        
    } catch (error) {
        console.error('Excel parse error:', error);
        return [];
    }
}

// 10. Upload contacts to server
function uploadContactsToServer(contacts, groupId, fileName) {
     const contactsWithSource = contacts.map(contact => ({
        ...contact,
        source: 'excel'  // Just add this
    }));
	
    $('#compactFileProgressBar').css('width', '80%');
    $('#compactFileStatus').text('Uploading...');
    
     
    const postData = {
        group_id: groupId,
        contacts: JSON.stringify(contacts),
        note: `Imported from: ${fileName}`
    };
    
     
    $.ajax({
        url: '/welcome/import_contacts',
        type: 'POST',
        data: postData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                 
                $('#compactFileProgressBar').css('width', '100%');
                $('#compactFileStatus').text('Upload complete!');
                
                 
                const imported = response.data?.summary?.imported || contacts.length;
                showNotification('success', `Imported ${imported} contacts`);
                
                 
                if (currentGroupId === groupId) {
                    const groupName = $(`[data-group-id="${groupId}"] .group-name`).text();
                    loadGroupContacts(groupId, groupName);
                }
                
                 
                setTimeout(resetFileUpload, 2000);
                
            } else {
                showNotification('error', response.message || 'Import failed');
                resetFileUpload();
            }
        },
        error: function(xhr, status, error) {
            console.error('Upload error:', error);
            showNotification('error', 'Server error during upload');
            resetFileUpload();
        }
    });
}

// 11. Reset upload state
function resetFileUpload() {
        $('#excelFileInput').val('');
        setTimeout(() => {
            $('#compactFileInfo').removeClass('show');
        }, 2000);
    }

    initExcelUpload();
	
	
// 12. Drag and drop initialization
function initDragAndDrop() {
    const dropArea = $('.excel-section')[0];
    
    if (!dropArea) return;
    
     
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
     
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    
     
    dropArea.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight() {
        dropArea.classList.add('highlight');
    }
    
    function unhighlight() {
        dropArea.classList.remove('highlight');
    }
    
    function handleDrop(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect(files[0]);
        }
    }
}

// 13. Download template
function initTemplateDownload() {
    $('#downloadTemplateBtn').off('click').on('click', function() {
        if (!currentGroupId) {
            showNotification('error', 'Please select a group first');
            return;
        }
        
         
        const link = document.createElement('a');
        link.href = '/welcome/download_template';
        link.download = 'Contacts_Template.xlsx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
}

initExcelUpload();
initTemplateDownload();

		function loadGroups() {
            $('#groupsLoading').addClass('active');
            
            $.ajax({
                url: '/welcome/get_all_groups_ajax',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#groupsLoading').removeClass('active');
                    
                    if (response.success && response.groups && response.groups.length > 0) {
                         
                        $('#groupsList').empty();
                        
                         
                        response.groups.forEach(function(group) {
                            var groupItem = `
                                <div class="group-item" data-group-id="${group.group_id}">
                                    <span class="group-name">${group.group_name}</span>
                                    <span class="group-count">${group.participant_count || 0}</span>
                                </div>
                            `;
                            $('#groupsList').append(groupItem);
                        });
                        
                         
                        $('.group-item').click(function() {
                             
                            $('.group-item').removeClass('selected');
                             
                            $(this).addClass('selected');
                            
                             
                            const groupId = $(this).data('group-id');
                            const groupName = $(this).find('.group-name').text();
                            
                             
                            currentGroupId = groupId;
                            
                             
                            $('#currentGroupId').val(groupId);
                            
                             
                            $('#addContactBtn').prop('disabled', false);
                            
                             
                            loadGroupContacts(groupId, groupName);
                        });
                        
                         
                        if (response.groups.length > 0) {
                            const firstGroup = $('#groupsList .group-item').first();
                            firstGroup.addClass('selected');
                            const firstGroupId = firstGroup.data('group-id');
                            const firstGroupName = firstGroup.find('.group-name').text();
                            currentGroupId = firstGroupId;
                            $('#currentGroupId').val(firstGroupId);
                            $('#addContactBtn').prop('disabled', false);
                            loadGroupContacts(firstGroupId, firstGroupName);
                        }
                        
                    } else {
                        $('#groupsList').html(`
                            <div class="empty-state" style="padding: 20px;">
                                <i class="fas fa-users"></i>
                                <p>No groups found</p>
                            </div>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    $('#groupsLoading').removeClass('active');
                    $('#groupsList').html(`
                        <div class="empty-state" style="padding: 20px; color: #ef4444;">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>Error loading groups</p>
                        </div>
                    `);
                    console.error('Error loading groups:', error);
                }
            });
        }
	
	    function loadGroupContacts(groupId, groupName) {
            $('#contactsLoading').addClass('active');
            
            $.ajax({
                url: '/welcome/get_group_contacts_ajax',
                type: 'POST',
                data: { group_id: groupId },
                dataType: 'json',
                success: function(response) {
                    $('#contactsLoading').removeClass('active');
                    
                    if (response.success) {
                         
                        $('.sms-contacts-section h5').html(`
                            <i class="fas fa-address-book"></i> SMS Contacts - ${groupName} (${response.contact_count})
                        `);
                        
                         
                        $('#contactsTableBody').empty();
                        
                        if (response.contacts && response.contacts.length > 0) {
                             
                            response.contacts.forEach(function(contact) {
                                let formattedDate = 'N/A';
                                if (contact.created_date) {
                                     const createdDate = new Date(contact.created_date);
                                     formattedDate = createdDate.toLocaleDateString('en-CA');
                                 }
								 
								 const source = contact.source || 'existing';
								 
                                const contactRow = `
    <tr data-contact-id="${contact.contact_id}" 
        data-phone="${contact.contact_number}"
        data-source="${source}">
        <td>
            <div class="contact-name">${contact.contact_name}</div>
        </td>
        <td>
            <span class="contact-phone">${contact.contact_number}</span>
        </td>
        <td>
            <span class="contact-date">${formattedDate}</span>
        </td>
    </tr>
`;

$('#contactsTableBody').append(contactRow);

  

function getSourceTitle(source) {
    switch(source) {
        case 'excel': return 'Imported from Excel';
        case 'manual': return 'Added via form';
        case 'existing': return 'Existing contact';
        default: return 'Unknown source';
    }
}
								
								
                                 
                            });
                            
                             
                            $('#contactsTableBody tr').click(function() {
                                $(this).toggleClass('selected');
                                
                                 
                                const contactId = $(this).data('contact-id');
                                const phone = $(this).data('phone');
                                
                                if ($(this).hasClass('selected')) {
                                    selectedContacts.push({ id: contactId, phone: phone });
                                } else {
                                    selectedContacts = selectedContacts.filter(c => c.id !== contactId);
                                }
                                
                                 
                                if (selectedContacts.length > 0) {
                                    $('#mainSendBtn').prop('disabled', false);
                                    $('#mainSendBtn').html(`
                                        <i class="fas fa-paper-plane"></i> Send Message to ${selectedContacts.length} Contact(s)
                                    `);
                                } else {
                                    $('#mainSendBtn').prop('disabled', true);
                                    $('#mainSendBtn').html(`
                                        <i class="fas fa-paper-plane"></i> Send Message to Selected Contacts
                                    `);
                                }
                            });
                            
                        } else {
                            $('#contactsTableBody').html(`
                                <tr>
                                    <td colspan="3" class="empty-state">
                                        <i class="fas fa-user-slash"></i>
                                        <p>No contacts found in this group</p>
                                    </td>
                                </tr>
                            `);
                        }
                        
                         
                        $(`[data-group-id="${groupId}"] .group-count`).text(response.contact_count);
                        
                    } else {
                        $('#contactsTableBody').html(`
                            <tr>
                                <td colspan="3" class="empty-state" style="color: #ef4444;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <p>${response.message || 'Error loading contacts'}</p>
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function(xhr, status, error) {
            $('#contactsLoading').removeClass('active');
            console.error('AJAX Error:', xhr.responseText, status, error);
            $('#contactsTableBody').html(`
                <tr>
                    <td colspan="3" class="empty-state" style="color: #ef4444;">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Error loading contacts. Check console for details.</p>
                    </td>
                </tr>
            `);
        }
            });
        }
        
         
        $('#addContactBtn').click(function() {
            const groupId = $('#currentGroupId').val();
            const contactName = $('#contactName').val().trim();
            const contactNumber = $('#contactNumber').val().trim();
            
            if (!groupId) {
                alert('Please select a group first');
                return;
            }
            
            if (!contactName) {
                alert('Please enter contact name');
                return;
            }
            
            if (!contactNumber) {
                alert('Please enter contact number');
                return;
            }
            
             
            const phoneRegex = /^0[0-9]{9,11}$/;
            if (!phoneRegex.test(contactNumber)) {
                alert('Please enter a valid Sri Lankan phone number (10-12 digits starting with 0)');
                return;
            }
            
             
            const originalText = $(this).html();
            $(this).html('<i class="fas fa-spinner fa-spin"></i> Adding...');
            $(this).prop('disabled', true);
            
            $.ajax({
                url: '/welcome/add_contact',
                type: 'POST',
                data: {
                    group_id: groupId,
                    contact_name: contactName,
                    contact_number: contactNumber,
					source: 'manual'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Clear form
                        $('#contactName').val('');
                        $('#contactNumber').val('');
						
						if (response.data && response.data.contact) {
                            const contact = response.data.contact;
                        
						const source = response.data.contact.source || 'manual'; 
						const newRow = `
    <tr data-contact-id="${contact.contact_id}" 
        data-phone="${contact.contact_number}"
        data-source="${source}">
        <td>
            <div class="contact-name">${contact.contact_name}</div>
        </td>
        <td>
            <span class="contact-phone">${contact.contact_number}</span>
        </td>
        <td>
            <span class="contact-date">${new Date().toLocaleDateString('en-CA')}</span>
        </td>
    </tr>
`;
			
			
			    if ($('#contactsTableBody tr').hasClass('empty-state')) {
                $('#contactsTableBody').html(newRow);
            } else {
                $('#contactsTableBody').append(newRow);
            }
			
			$('#contactsTableBody tr:last').click(function() {
                $(this).toggleClass('selected');
                updateSelectedCount();
            });
        }
		
		if (response.contact_count) {
            $(`[data-group-id="${groupId}"] .group-count`).text(response.contact_count);
			
			
                        const groupName = $(`[data-group-id="${groupId}"] .group-name`).text();
            $('.sms-contacts-section h5').html(`
                <i class="fas fa-address-book"></i> SMS Contacts - ${groupName} (${response.contact_count})
            `);
        }
                        
                         
                showNotification('success', 'Contact added successfully!');
    } else {
        showNotification('error', response.message || 'Error adding contact');
    }  
                     
                    $('#addContactBtn').html(originalText);
                    $('#addContactBtn').prop('disabled', false);
                }
            });
        });
        
         
        $('#editMessageBtn').click(function() {
            $('#messageContent').focus().select();
        });
        
         
        $('#sendMessageBtn').click(function() {
            const message = $('#messageContent').val().trim();
            if (!message) {
                alert('Please enter a message');
                return;
            }
            
            if (!currentGroupId) {
                alert('Please select a group');
                return;
            }
            
             
            if (confirm('Send this message to all contacts in the selected group?')) {
                 
                const originalText = $(this).html();
                $(this).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
                $(this).prop('disabled', true);
                
                 
                setTimeout(function() {
                    alert('Message sent successfully to all contacts in the group!');
                    $('#sendMessageBtn').html(originalText);
                    $('#sendMessageBtn').prop('disabled', false);
                }, 1500);
            }
        });
        
         $('#addGroupBtn').click(function() {
    showGroupModal();
});
          

$('#mainSendBtn').click(function() {
    const message = $('#messageContent').val().trim();
    if (!message) {
        alert('Please enter a message');
        return;
    }
    
    if (!currentGroupId) {
        alert('Please select a group');
        return;
    }
    
    // Get group name
    const groupName = $(`[data-group-id="${currentGroupId}"] .group-name`).text();
    
    // Ask for campaign title
    const campaignTitle = prompt('Enter Campaign Title:', `SMS to ${groupName} - ${new Date().toLocaleDateString()}`);
    
    if (!campaignTitle) {
        alert('Campaign title is required');
        return;
    }
    
    if (campaignTitle.length > 45) {
        alert('Campaign title must be less than 45 characters');
        return;
    }
    
    // Count all contacts in the group from the table
    const totalContacts = $('#contactsTableBody tr[data-contact-id]').length;
    
    if (totalContacts === 0) {
        alert('No contacts found in this group');
        return;
    }
    
    // Show confirmation with accurate count
    if (confirm(`Create campaign "${campaignTitle}" with ${totalContacts} contacts from ${groupName}?`)) {
        // Disable button and show loading
        const originalText = $(this).html();
        const originalDisabled = $(this).prop('disabled');
        $(this).html('<i class="fas fa-spinner fa-spin"></i> Creating Campaign...');
        $(this).prop('disabled', true);
        
        // Prepare data for submission
        const postData = {
            campaign_title: campaignTitle,
            message_content: message,
            group_id: currentGroupId,
            group_name: groupName
        };
        
        console.log('Sending campaign data:', postData);
        
        // Send AJAX request
        $.ajax({
            url: '/welcome/save_sms_campaign',
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('Campaign created successfully:', response);
                    
                    // Show detailed success message
                    alert(`✓ Campaign "${campaignTitle}" created successfully!\n` +
                          `✓ ${response.data.total_contacts} contacts saved.\n` +
                          `✓ Campaign ID: ${response.data.campaign_id}`);
                    
                    // Clear the message area
                    $('#messageContent').val('');
                    
                    // Redirect to campaigns page after 2 seconds
                    setTimeout(() => {
                        window.location.href = '/welcome/campaigns_screen';
                    }, 2000);
                } else {
                    alert('❌ Error: ' + response.message);
                    $('#mainSendBtn').html(originalText);
                    $('#mainSendBtn').prop('disabled', originalDisabled);
                }
            },
            error: function(xhr, status, error) {
                console.error('Server error:', error);
                console.error('Response:', xhr.responseText);
                
                let errorMsg = 'Server error. Please try again.';
                if (xhr.responseText) {
                    try {
                        const jsonResponse = JSON.parse(xhr.responseText);
                        errorMsg = jsonResponse.message || errorMsg;
                    } catch (e) {
                        errorMsg = xhr.responseText.substring(0, 100);
                    }
                }
                
                alert('❌ Error: ' + errorMsg);
                $('#mainSendBtn').html(originalText);
                $('#mainSendBtn').prop('disabled', originalDisabled);
            }
        });
    }
});


function showGroupModal() {
    // Reset form
    $('#groupNameInput').val('');
    $('#groupNameError').hide();
    $('#modalSubmitBtn').prop('disabled', false);
    
     
    $('#groupModalOverlay').fadeIn(200);
    
     
    setTimeout(() => {
        $('#groupNameInput').focus();
    }, 250);
}

function hideGroupModal() {
    $('#groupModalOverlay').fadeOut(200);
}

 
$('#modalCloseBtn, #modalCancelBtn').click(function() {
    hideGroupModal();
});

 
$('#groupModalOverlay').click(function(e) {
    if (e.target === this) {
        hideGroupModal();
    }
});

$('#groupNameInput').keypress(function(e) {
    if (e.which === 13) { // Enter key
        $('#modalSubmitBtn').click();
        return false;
    }
});

 
$('#modalSubmitBtn').click(function() {
    const groupName = $('#groupNameInput').val().trim();
    
     
    if (!groupName) {
        $('#groupNameError').text('Group name is required').show();
        return;
    }
    
    if (groupName.length < 2) {
        $('#groupNameError').text('Group name must be at least 2 characters').show();
        return;
    }
    
    if (groupName.length > 45) {
        $('#groupNameError').text('Group name must be less than 45 characters').show();
        return;
    }
    
    const originalText = $(this).html();
    $(this).html('<i class="fas fa-spinner fa-spin"></i> Creating...');
    $(this).prop('disabled', true);
    
     
    $.ajax({
        url: '/welcome/create_group',
        type: 'POST',
        data: { group_name: groupName },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                 
                hideGroupModal();
                
                 
                showNotification('success', 'Group created successfully!');
                
                 
                loadGroups();
                
                 
                setTimeout(function() {
                    if (response.data && response.data.group) {
                        const newGroupId = response.data.group.group_id;
                        $(`[data-group-id="${newGroupId}"]`).click();
                    }
                }, 500);
                
            } else {
                 
                $('#groupNameError').text(response.message || 'Error creating group').show();
                
                 
                $('#modalSubmitBtn').html(originalText);
                $('#modalSubmitBtn').prop('disabled', false);
                
                 
                $('#groupNameInput').addClass('error-shake');
                setTimeout(() => {
                    $('#groupNameInput').removeClass('error-shake');
                }, 500);
            }
        },
        error: function(xhr, status, error) {
             
            $('#modalSubmitBtn').html(originalText);
            $('#modalSubmitBtn').prop('disabled', false);
            
             
            $('#groupNameError').text('Error creating group. Please try again.').show();
            
             
            $('#groupNameInput').addClass('error-shake');
            setTimeout(() => {
                $('#groupNameInput').removeClass('error-shake');
            }, 500);
            
            console.error('Error creating group:', error);
        }
    });
});
        
         
        $('#compactBrowseBtn').click(function() {
            alert('Excel upload functionality would be implemented here');
        });
    });
	
	
const style = document.createElement('style');
style.textContent = `
    .error-shake {
        animation: shake 0.5s ease-in-out;
        border-color: #ef4444 !important;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);

function showNotification(type, message) {
     
    const notification = $(`
        <div class="notification notification-${type}" style="
            position: fixed;
            top: 24px;
            right: 24px;
            padding: 14px 18px;
            background: ${type === 'success' ? '#10b981' : '#ef4444'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            z-index: 1001;
            animation: slideInRight 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 320px;
            font-weight: 500;
            border-left: 4px solid ${type === 'success' ? '#059669' : '#dc2626'};
        ">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            ${message}
        </div>
    `);
    
     
    $('body').append(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}
	
	
function updateSelectedCount() {
    // Update selected contacts array
    selectedContacts = [];
    $('#contactsTableBody tr').click(function() {
    $(this).toggleClass('selected');
    updateSelectedCount();  // Use the helper function
});
    
    // Enable/disable send button based on selection
    if (selectedContacts.length > 0) {
        $('#mainSendBtn').prop('disabled', false);
        $('#mainSendBtn').html(`
            <i class="fas fa-paper-plane"></i> Send Message to ${selectedContacts.length} Contact(s)
        `);
    } else {
        $('#mainSendBtn').prop('disabled', true);
        $('#mainSendBtn').html(`
            <i class="fas fa-paper-plane"></i> Send Message to Selected Contacts
        `);
    }
}


 






 
  


// Add drag and drop CSS
const dragDropCSS = `
    .excel-section.highlight {
        border-color: #10b981 !important;
        background-color: rgba(16, 185, 129, 0.05);
        transform: translateY(-2px);
        transition: all 0.2s;
    }
    
    .file-progress-bar {
        background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
        transition: width 0.3s ease;
    }
`;

// Add CSS to page
if (!$('#drag-drop-css').length) {
    $('<style id="drag-drop-css">' + dragDropCSS + '</style>').appendTo('head');
}
	
 


		
	
</script>

<!-- Simple Modal for Adding New Group -->
<div class="modal-overlay" id="groupModalOverlay" style="display: none;">
    <div class="group-modal">
        <div class="modal-header">
            <h5>Create New Group</h5>
            <button class="modal-close-btn" id="modalCloseBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="groupNameInput">Group Name</label>
                <input type="text" id="groupNameInput" class="form-input" placeholder="Enter group name" autocomplete="off">
                <div class="error-message" id="groupNameError" style="color: #ef4444; font-size: 12px; margin-top: 4px; display: none;"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-cancel-btn" id="modalCancelBtn">Cancel</button>
            <button class="modal-submit-btn" id="modalSubmitBtn">Create Group</button>
        </div>
    </div>
</div>


</body>
</html>
