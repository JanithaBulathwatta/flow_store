<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your existing CSS styles */
        .btn-status {
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid transparent;
            min-width: 90px;
        }
        
        .btn-success-light {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
            border-color: rgba(25, 135, 84, 0.2);
        }
        
        .btn-primary-light {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border-color: rgba(13, 110, 253, 0.2);
        }
        
        .btn-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border-color: rgba(255, 193, 7, 0.2);
        }
        
        .btn-danger-light {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-color: rgba(220, 53, 69, 0.2);
        }
        
        .btn-info-light {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
            border-color: rgba(13, 202, 240, 0.2);
        }
        
        .accordion-toggle {
            cursor: pointer;
        }
        
        .accordion-toggle .expand-icon {
            transition: transform 0.3s ease;
            display: inline-block;
        }
        
        .accordion-toggle.collapsed .expand-icon {
            transform: rotate(-90deg);
        }
        
        .contacts-carousel {
            position: relative;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
		
		.contact-table-row {
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.2s;
}

.contact-table-row:hover {
    background-color: #f8f9fa;
}

.contact-table-cell {
    padding: 8px 10px;
    vertical-align: middle;
}

.contact-table-cell:first-child {
    padding-left: 0;
}

.contact-table-cell:last-child {
    padding-right: 0;
}

.contact-info-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.contact-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 13px;
    flex-shrink: 0;
}

.contact-details {
    flex: 1;
    min-width: 0;
}

.contact-name {
    font-weight: 500;
    color: #212529;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.contact-phone {
    color: #6c757d;
    font-size: 12px;
    white-space: nowrap;
}

.status-badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 500;
}

.status-pending {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-sent {
    background: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.contact-index {
    color: #6c757d;
    font-size: 12px;
    font-weight: 500;
    min-width: 25px;
    text-align: right;
}
        
        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease;
        }
        
        .carousel-item {
            min-width: 100%;
            padding: 10px;
            display: none;
        }
        
        .carousel-item.active {
            display: block;
        }
        
        .carousel-controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }
        
        .carousel-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .carousel-btn:hover {
            background: #f8f9fa;
            border-color: #0d6efd;
            color: #0d6efd;
        }
        
        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 15px;
        }
        
        .carousel-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #dee2e6;
            border: none;
            cursor: pointer;
            padding: 0;
        }
        
        .carousel-indicator.active {
            background: #0d6efd;
        }
        
        .contact-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e9ecef;
            transition: all 0.2s;
            height: 100%;
        }
        
        .contact-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .contact-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }
        
        .contact-info {
            flex: 1;
        }
        
        .contact-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 2px;
        }
        
        .contact-phone {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .contact-status {
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .status-sent {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .empty-contacts {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
        
        .empty-contacts i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        @media (max-width: 768px) {
            .contact-card {
                padding: 12px;
            }
            
            .carousel-controls {
                margin-top: 10px;
            }
        }
        
        .loading-spinner {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0d6efd;
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
		
		.contacts-carousel {
        /* Change from carousel to simple grid */
display: block !important;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 12px;
    max-height: 300px;
    overflow-y: auto;
    margin-top: 10px;
    }
	
	.contact-source-row {
    display: flex;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
    position: relative;
}

.contact-source-row:last-child {
    border-bottom: none;
}

.contact-source-row[data-source="excel"] {
    border-left: 4px solid #10b981; /* Green for Excel */
    background-color: rgba(16, 185, 129, 0.08);
	padding-left: 8px;
}

.contact-source-row[data-source="manual"] {
    border-left: 4px solid #3b82f6; /* Blue for Manual */
    background-color: rgba(59, 130, 246, 0.08);
	padding-left: 8px;
}

.contact-source-row[data-source="existing"] {
    border-left: 4px solid #ef4444; /* Red for Existing */
    background-color: rgba(239, 68, 68, 0.08);
	padding-left: 8px;
}

.contact-source-row[data-source="unknown"] {
    border-left: 4px solid #94a3b8; /* Gray for Unknown */
    padding-left: 8px;
}

.contact-source-info {
    flex: 1;
    min-width: 0;
}

.contact-source-name {
    font-weight: 500;
    color: #212529;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 14px;
}

.contact-source-phone {
    color: #6c757d;
    font-size: 13px;
    white-space: nowrap;
}

.contact-source-index {
    color: #6c757d;
    font-size: 12px;
    font-weight: 500;
    min-width: 25px;
    text-align: right;
    margin-right: 10px;
}
    
    .carousel-inner {
        /* Disable carousel sliding */
        display: block !important;
        transform: none !important;
        transition: none !important;
    }
    
    .carousel-item {
        /* Show all items at once */
        display: block !important;
        min-width: 100%;
        padding: 0;
    }
    
    .carousel-item.active {
        display: block !important;
    }
    
    /* Hide carousel controls */
    .carousel-controls,
    .carousel-indicators {
        display: none !important;
    }
	
	
    
    /* Change contact card to list item */
    .contact-card {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 8px;
    margin-bottom: 8px;
    background: white;
    }
    
    /* Hide the circular avatar */
    .contact-avatar {
        display: none !important;
    }
    
    /* Adjust contact info for single column */
    .contact-info {
        flex: 1;
        padding-left: 0 !important;
    }
    
    /* Make rows single column */
    .row.g-3 {
        display: block !important;
    }
    
    .col-12.col-sm-6.col-md-3 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
         
    }
    
     
    .contact-card:hover {
        background-color: #f8f9fa;
        transform: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
	/* Add this if using table version */
table tr[data-source="excel"] {
    border-left: 4px solid #10b981 !important;
}

table tr[data-source="manual"] {
    border-left: 4px solid #3b82f6 !important;
}

table tr[data-source="existing"] {
    border-left: 4px solid #ef4444 !important;
}

table tr[data-source="unknown"] {
    border-left: 4px solid #94a3b8 !important;
}

table tr {
    border-bottom: 1px solid #f0f0f0;
}

table tr:last-child {
    border-bottom: none;
}

table td {
    padding: 8px 0;
    vertical-align: middle;
}

.card.border-primary {
    border-width: 2px !important;
    border-color: #0d6efd !important;
}

.card.border-primary .card-header {
    background-color: #0d6efd !important;
    color: white !important;
}
	
    </style>
</head>

<body>

    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Campaign Management Card -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title">
                                    Campaign List
                                </div>
                                <button type="button" class="btn btn-primary btn-w-xs btn-wave" id="addCampaignBtn" onclick="window.location.href='/welcome/message_screen'">
    <i class="fas fa-plus-circle me-2"></i>New Campaign
</button>
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table id="campaign-datatable" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px;"></th>
                                                <th>Campaign Title</th>
                                                <th>Total Sent</th>
                                                <th>Sent Date</th>
                                                <th>Recipients</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($campaigns)): ?>
                                                <?php foreach ($campaigns as $index => $campaign): ?>
                                                    <?php 
                                                    $actual_status = $campaign['campaign_status'];
if ($campaign['campaign_status'] == 'Pending') {
    if ($campaign['sent_percentage'] >= 100) {
        $actual_status = 'Complete';
    } elseif ($campaign['sent_percentage'] > 0) {
        $actual_status = 'Active';
    }
}

// Now use $actual_status for your switch statement
switch($actual_status) {
    case 'Complete':
        $status_class = 'btn-success-light';
        $display_status = 'Completed';
        break;
    case 'Active':
        $status_class = 'btn-primary-light';
        $display_status = 'Active';
        break;
    case 'Pending':
        $status_class = 'btn-warning-light';
        $display_status = 'Pending';
        break;
    case 'Draft':
        $status_class = 'btn-info-light';
        $display_status = 'Draft';
        break;
    case 'Cancel':
        $status_class = 'btn-danger-light';
        $display_status = 'Cancelled';
        break;
    default:
        $status_class = 'btn-success-light';
        $display_status = $actual_status;
}
                                                    
                                                    // Format date
                                                    $formatted_date = date('Y-m-d', strtotime($campaign['campaign_date']));
                                                    
                                                    // Get contacts count for this campaign
                                                    $this->db->where('fk_campaign_id', $campaign['campaign_id']);
                                                    $contact_count = $this->db->count_all_results('campaign_numbers');
                                                    ?>
                                                    
                                                    <!-- Campaign Row - UPDATED with data attribute -->
                                                    <tr class="accordion-toggle campaign-row" 
                                                        data-campaign-id="<?php echo $campaign['campaign_id']; ?>">
                                                        <td class="text-center">
                                                            <i class="fas fa-chevron-down expand-icon"></i>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($campaign['campaign_title']); ?></td>
                                                        <td>
    <span class="badge 
        <?php 
            if ($campaign['sent_percentage'] >= 100) echo 'bg-success';
            elseif ($campaign['sent_percentage'] >= 75) echo 'bg-info';
            elseif ($campaign['sent_percentage'] >= 50) echo 'bg-warning';
            else echo 'bg-secondary';
        ?>">
        <?php echo $campaign['sent_percentage']; ?>%
    </span>
    <small class="text-muted ms-1">
        (<?php echo $campaign['total_sent']; ?>/<?php echo $campaign['total_recipients']; ?>)
    </small>
</td>
<td><?php echo $formatted_date; ?></td>
<td>
    <?php echo $campaign['total_recipients']; ?>
</td> 
                                                        <td>
                                                            <button class="btn btn-sm btn-status <?php echo $status_class; ?>">
                                                                <?php echo $display_status; ?>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    
                                                    <!-- Campaign Details (will be loaded dynamically) -->
                                                    <tr>
                                                        <td colspan="6" class="p-0 border-0">
                                                            <div id="campaign-contacts-<?php echo $campaign['campaign_id']; ?>" class="collapse" data-bs-parent="#campaign-datatable">
                                                                <div class="p-3">
																    <!-- Message Content Section -->
         
																
																
                                                                    <!-- Loading spinner -->
                                                                    <div class="loading-spinner" id="loading-<?php echo $campaign['campaign_id']; ?>">
                                                                        <div class="spinner"></div>
                                                                        <p>Loading contacts...</p>
                                                                    </div>
                                                                    
                                                                    <!-- Contacts Carousel Container -->
                                                                    <div id="carousel-<?php echo $campaign['campaign_id']; ?>" class="contacts-carousel" style="display: none;">
                                                                        <!-- Carousel content will be loaded here via AJAX -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No campaigns found in the database.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Load jQuery FIRST -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Then Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Define all functions in global scope BEFORE they're called
    window.loadCampaignContacts = function(campaignId, rowElement) {
        console.log('loadCampaignContacts called for campaign:', campaignId);
        
        const accordionElement = document.getElementById(`campaign-contacts-${campaignId}`);
        const loadingElement = document.getElementById(`loading-${campaignId}`);
        const carouselElement = document.getElementById(`carousel-${campaignId}`);
        
        if (!accordionElement) {
            console.error('Accordion element not found for campaign:', campaignId);
            return;
        }
        
        // Toggle accordion
        const bsCollapse = new bootstrap.Collapse(accordionElement, {
            toggle: true
        });
        
        // Toggle icon
        setTimeout(() => {
            const isShown = accordionElement.classList.contains('show');
            const icon = rowElement.querySelector('.expand-icon');
            
            if (isShown) {
                icon.style.transform = 'rotate(0deg)';
                rowElement.classList.remove('collapsed');
                
                // If carousel is empty, load contacts
               // if (!carouselElement || carouselElement.innerHTML.trim() === '') {
                    if (loadingElement) loadingElement.style.display = 'block';
                    if (carouselElement){ 
					     carouselElement.style.display = 'none';
                    
                          carouselElement.innerHTML = '';
					}
                    console.log('Loading contacts for campaign:', campaignId);
					
					
                    // Make AJAX request
                    $.ajax({
                        url: '/welcome/get_campaign_contacts_ajax',
                        type: 'POST',
                        data: { campaign_id: campaignId },
                        dataType: 'json',
                        beforeSend: function() {
                            console.log('AJAX request started for campaign:', campaignId);
                        },
                        success: function(response) {
                            console.log('AJAX response for campaign', campaignId, ':', response);
                            
                            if (response.success && response.contacts && response.contacts.length > 0) {
                                // Build carousel HTML
                                const carouselHTML = buildCarouselHTML(response.contacts, campaignId, response.message_content);
                                if (carouselElement) {
                                    carouselElement.innerHTML = carouselHTML;
                                }
								
								const messageElement = document.querySelector(`#message-content-${campaignId}`);
        if (messageElement && response.message_content) {
            messageElement.textContent = response.message_content;
        }
		
		
                                console.log('Carousel loaded with', response.contacts.length, 'contacts');
								console.log('Message:', response.message_content);
								
								
                            } else {
                                 
                                const emptyHTML = `
                                    <div class="empty-contacts">
                                        <i class="fas fa-users-slash"></i>
                                        <p>${response.message || 'No contacts found for this campaign'}</p>
                                    </div>
                                `;
                                if (carouselElement) {
                                    carouselElement.innerHTML = emptyHTML;
                                }
                                console.log('No contacts found');
                            }
                            
                             
                            if (loadingElement) loadingElement.style.display = 'none';
                            if (carouselElement) carouselElement.style.display = 'block';
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error for campaign', campaignId, ':', error);
                            console.error('Status:', status);
                            console.error('Response:', xhr.responseText);
                            
                            const errorHTML = `
                                <div class="empty-contacts" style="color: #dc3545;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <p>Error loading contacts</p>
                                    <small>${error}</small>
                                </div>
                            `;
                            
                            if (carouselElement) {
                                carouselElement.innerHTML = errorHTML;
                                carouselElement.style.display = 'block';
                            }
                            if (loadingElement) loadingElement.style.display = 'none';
                        },
                        complete: function() {
                            console.log('AJAX request complete for campaign:', campaignId);
                        }
                    });
                 
            } else {
                icon.style.transform = 'rotate(-90deg)';
                rowElement.classList.add('collapsed');
            }
        }, 10);
    };

     
    window.buildCarouselHTML = function(contacts, campaignId, messageContent) {
    console.log('buildCarouselHTML called with', contacts.length, 'contacts');
    console.log('Message content received:', messageContent);
    //console.log('Message type:', typeof messageContent);
	
     let html = '';
	 
	 if (messageContent && messageContent !== 'No message stored for this campaign') {
    console.log('✓ Displaying message'); 
    html += `
        <div class="alert alert-info mb-2 py-2 d-flex align-items-start" style="font-size: 13px;">
            <i class="fas fa-envelope me-2 mt-1"></i>
            <div style="flex: 1;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong style="font-size: 13px;">Message:</strong>
                    <small class="text-muted">${messageContent.length} chars</small>
                </div>
                <div style="max-height: 100px; overflow-y: auto; white-space: pre-wrap; font-size: 12.5px;">
                    ${messageContent}
                </div>
            </div>
        </div>
    `;
    } else {
        console.log('✗ No message to display');
        html += `
            <div class="alert alert-danger mb-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>DEBUG:</strong> No message content stored for this campaign
            </div>
        `;
    }
	
	if (!contacts || contacts.length === 0) {
        return `<div class="empty-contacts">
                    <i class="fas fa-users-slash"></i>
                    <p>No contacts found</p>
                </div>`;
    }
    
    let contactsHTML = '';
    
    // Build ALL contacts in single list - NO grouping into chunks
    contacts.forEach((contact, index) => {
        // Get first letter for avatar (but we'll hide it with CSS)
        const firstName = contact.contact_name || 'Unknown';
        const firstLetter = firstName.charAt(0).toUpperCase();
        const phone = contact.contact_number || 'N/A';
		const source = contact.source || 'unknown'; // Get source from contact data
		  
        
        contactsHTML += `
            <div class="contact-source-row" data-source="${source}">
                <span class="contact-source-index">${index + 1}.</span>
                <div class="contact-source-info">
                    <div class="contact-source-name" title="${firstName}">
                        ${firstName}
                    </div>
                    <div class="contact-source-phone">
                        ${phone}
                    </div>
                </div>
            </div>
        `;
    });
    
    // Return table format
    return html + `
    <div class="contact-source-list">
        ${contactsHTML}
    </div>
 ` ;
};

    // Carousel Functions
    window.prevSlide = function(carouselId) {
        const carousel = document.getElementById(carouselId);
        const items = carousel.querySelectorAll('.carousel-item');
        const indicators = carousel.querySelectorAll('.carousel-indicator');
        let currentIndex = 0;
        
        // Find current active slide
        items.forEach((item, index) => {
            if (item.classList.contains('active')) {
                currentIndex = index;
                item.classList.remove('active');
                indicators[index].classList.remove('active');
            }
        });
        
        // Calculate previous index
        const prevIndex = currentIndex === 0 ? items.length - 1 : currentIndex - 1;
        
        // Activate previous slide
        items[prevIndex].classList.add('active');
        indicators[prevIndex].classList.add('active');
    };
    
    window.nextSlide = function(carouselId) {
        const carousel = document.getElementById(carouselId);
        const items = carousel.querySelectorAll('.carousel-item');
        const indicators = carousel.querySelectorAll('.carousel-indicator');
        let currentIndex = 0;
        
        // Find current active slide
        items.forEach((item, index) => {
            if (item.classList.contains('active')) {
                currentIndex = index;
                item.classList.remove('active');
                indicators[index].classList.remove('active');
            }
        });
        
        // Calculate next index
        const nextIndex = currentIndex === items.length - 1 ? 0 : currentIndex + 1;
        
        // Activate next slide
        items[nextIndex].classList.add('active');
        indicators[nextIndex].classList.add('active');
    };
    
    window.goToSlide = function(carouselId, slideIndex) {
        const carousel = document.getElementById(carouselId);
        const items = carousel.querySelectorAll('.carousel-item');
        const indicators = carousel.querySelectorAll('.carousel-indicator');
        
        // Remove active from all
        items.forEach((item, index) => {
            item.classList.remove('active');
            indicators[index].classList.remove('active');
        });
        
        // Activate selected slide
        items[slideIndex].classList.add('active');
        indicators[slideIndex].classList.add('active');
    };

    // Event handler using event delegation
    $(document).ready(function() {
        console.log('Document ready - initializing campaign interactions');
        
        // Add click handler to campaign rows
        $(document).on('click', '.campaign-row', function(e) {
            // Don't trigger if clicking on the status button
            if ($(e.target).hasClass('btn-status') || $(e.target).closest('.btn-status').length) {
                return;
            }
            
            const campaignId = $(this).data('campaign-id');
            console.log('Campaign row clicked, ID:', campaignId);
            loadCampaignContacts(campaignId, this);
        });
        
        // Also keep the onclick attribute as backup
        // Convert onclick to jQuery event for existing rows
        $('.accordion-toggle').each(function() {
            if ($(this).hasClass('campaign-row')) return; // Skip if already handled
            
            const onclickAttr = $(this).attr('onclick');
            if (onclickAttr) {
                $(this).removeAttr('onclick');
                const campaignId = onclickAttr.match(/loadCampaignContacts\((\d+)/);
                if (campaignId && campaignId[1]) {
                    $(this).data('campaign-id', campaignId[1]);
                    $(this).addClass('campaign-row');
                }
            }
        });
        
         
        
        
        
         
    });
    </script>

</body>
</html>