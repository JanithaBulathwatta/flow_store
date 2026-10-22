<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>
     
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	  
	<script src="assets/js/toasts.js"></script>

    
<script>
 
window.showToast = function(type, title, message, duration = 3000) {
     
    let container = document.getElementById('custom-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'custom-toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
     
    const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
    
     
    const typeClasses = {
        'success': 'bg-success text-white',
        'error': 'bg-danger text-white',
        'warning': 'bg-warning text-dark',
        'info': 'bg-info text-white',
        'primary': 'bg-primary text-white',
        'secondary': 'bg-secondary text-white'
    };
    
     
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header ${typeClasses[type] || 'bg-primary text-white'}">
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
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
        delay: duration
    });
    
     
    toastEl.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
    
    toast.show();
    
    return toast;
};

 
window.showSuccessToast = function(message, title = 'Success') {
    return showToast('success', title, message);
};

window.showErrorToast = function(message, title = 'Error') {
    return showToast('error', title, message);
};

window.showWarningToast = function(message, title = 'Warning') {
    return showToast('warning', title, message);
};

window.showInfoToast = function(message, title = 'Info') {
    return showToast('info', title, message);
};

 
$(document).ready(function() {
    console.log('showToast function ready:', typeof showToast);
});
</script>	
    
    <style>
         
        .icon-btn {
            background: none;
            border: none;
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        
         
        .icon-btn:hover {
            opacity: 0.8;
        }
        
         
        .dataTables_filter input {
            padding-left: 10px;
        }
        
         
        .action-buttons {
            gap: 8px;
        }
		
		
    </style>
</head>

<body>

     
    <div id="loader">
        <img src="../assets/images/media/loader.svg" alt="">
    </div>
     

    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                 

                <!-- Groups Management Card -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title">
                                    <i class="fas fa-users me-2"></i>Groups List
                                </div>
                                <!-- Updated Add New Group button with btn-w-xs btn-wave style -->
                                <button type="button" class="btn btn-primary btn-w-xs btn-wave btn-add-group" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                                    <i class="fas fa-plus-circle me-2"></i>Add New Group
                                </button>
                            </div>
                            <div class="card-body">

                                <!-- DATA TABLES SEARCH SECTION ADDED HERE -->
                                <div class="dataTables_wrapper dt-bootstrap5 no-footer">
    <div id="datatable-basic_filter" class="dataTables_filter text-end">
        <label class="position-relative">
            <i class="ri-search-line position-absolute top-50 translate-middle-y ms-3" style="font-size: 14px; left: 0;"></i>
            <input type="search" class="form-control form-control-sm ps-5 d-inline-block groups-search-input" placeholder="Search..." aria-controls="datatable-basic" style="width: 250px;">
        </label>
    </div>
</div>
                                <!-- END DATA TABLES SEARCH SECTION -->

                                <div class="table-responsive">
                                    <table id="groups-datatable" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                 
                                                <th>Group</th>
                                                <th>Participants</th>
                                                <th>Last Campaign</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
										
										
										
                                         <tbody>
                                          <?php if (isset($groups) && is_array($groups)): ?>
										  <?php $counter = 1; ?>
                                          <?php foreach ($groups as $group): ?>
                                          <tr>
                                             <td>
                                                 <div class="d-flex align-items-center">
                                                     <!-- Show sequential number -->
                                                     <div class="group-avatar me-3">G<?php echo $counter; ?></div>
                                                     <div>
                                                          <?php echo htmlspecialchars($group['group_name']); ?>
                                                      </div>
                                                  </div>
                                               </td>
                                               <td>
                                                   <span class="participants-text">
                                                       <?php echo isset($group['participant_count']) ? $group['participant_count'] : '0'; ?>
                                                   </span>
                                               </td>
                                               <td>
                                                  <span class="campaign-text">-</span>
                                               </td>
                                               <td>
                                                  <div class="action-buttons d-flex justify-content-center align-items-center">
                   <button class="icon-btn text-info" title="View" onclick="viewGroup(<?php echo $group['group_id']; ?>)">
                    <i class="ri-eye-line"></i>
                </button>
                <button class="icon-btn text-info mx-2" title="Edit" onclick="editGroup(<?php echo $group['group_id']; ?>)">
                    <i class="ri-edit-line"></i>
                </button>
                <button class="icon-btn text-danger" title="Delete" onclick="deleteGroup(<?php echo $group['group_id']; ?>)">
                    <i class="ri-delete-bin-5-line"></i>
                </button>
                <button class="btn btn-sm btn-success btn-w-xs btn-wave ms-2" title="Send" onclick="sendToGroup(<?php echo $group['group_id']; ?>)">
                    <i class="fas fa-paper-plane me-1"></i>Send
                </button>
            </div>
        </td>
    </tr>
	<?php $counter++; ?>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="4" class="text-center">No groups found</td>
    </tr>
    <?php endif; ?>
</tbody>     
</table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Groups Management Card -->

            </div>
        </div>
        <!-- End::app-content -->
    </div>

    <!-- Add Group Modal -->
    <div class="modal fade" id="addGroupModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Add New Group
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addGroupForm">
                        <div class="mb-3">
                            <label for="groupName" class="form-label">Group Name *</label>
                            <input type="text" class="form-control" id="groupName" placeholder="Enter group name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-w-xs btn-wave" id="createGroupBtn">
                        <i class="fas fa-save me-2"></i>Create Group
                    </button>
                </div>
            </div>
        </div>
    </div>
	
	<!-- Edit Group Modal -->
<div class="modal fade" id="editGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Group
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editGroupForm">
                    <input type="hidden" id="editGroupId" value="">
                    <div class="mb-3">
                        <label for="editGroupName" class="form-label">Group Name *</label>
                        <input type="text" class="form-control" id="editGroupName" placeholder="Enter group name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-w-xs btn-wave" id="updateGroupBtn">
                    <i class="fas fa-save me-2"></i>Update Group
                </button>
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {
             
            $('#createGroupBtn').click(function(e) {
                e.preventDefault();
                submitGroupForm();
            });

             
            $('#groupName').keypress(function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    submitGroupForm();
                }
            });
			
			$('#addGroupModal').on('hidden.bs.modal', function () {
                 $('.modal-backdrop').remove();
                 $('body').removeClass('modal-open');
            });

            function submitGroupForm() {
                 
                var groupName = $('#groupName').val().trim();
                
                 
                if (!groupName) {
                     
                    if (typeof showToast === 'function') {
                        showToast('error', 'Validation Error', 'Group name is required');
                    } else {
                        alert('Group name is required');
                    }
                    return;
                }
                
                if (groupName.length < 2) {
                    if (typeof showToast === 'function') {
                        showToast('error', 'Validation Error', 'Group name must be at least 2 characters');
                    } else {
                        alert('Group name must be at least 2 characters');
                    }
                    return;
                }
                
                if (groupName.length > 45) {
                    if (typeof showToast === 'function') {
                        showToast('error', 'Validation Error', 'Group name must be less than 45 characters');
                    } else {
                        alert('Group name must be less than 45 characters');
                    }
                    return;
                }
                
                 
                var originalText = $('#createGroupBtn').html();
                $('#createGroupBtn').prop('disabled', true).html('Creating...');
                
                 
                var formData = {
                    group_name: groupName
                };
                
                 
                $.ajax({
                    url: 'welcome/create_group',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                         
                        $('#createGroupBtn').prop('disabled', false).html(originalText);
                         
                        if (response.success) {
                             
                            if (typeof showToast === 'function') {
                                showToast('success', 'Success', response.message || 'Group created successfully!');
                            } else {
                                alert('Success: ' + (response.message || 'Group created successfully!'));
                            }
                            
                            
                            $('#groupName').val('');
                            
                             
                            $('#addGroupModal').modal('hide');
                            
                             
                            if (response.data && response.data.group) {
                                addGroupToTable(response.data.group);
                            }
                        } else {
                              
                            if (typeof showToast === 'function') {
                                showToast('error', 'Error', response.message || 'Failed to create group');
                            } else {
                                alert('Error: ' + (response.message || 'Failed to create group'));
                            }
                            
                             
                            if (response.errors && response.errors.group_name) {
                                if (typeof showToast === 'function') {
                                    showToast('error', 'Validation Error', response.errors.group_name);
                                } else {
                                    alert('Validation Error: ' + response.errors.group_name);
                                }
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                         
                        $('#createGroupBtn').prop('disabled', false).html(originalText);
                         
						 
                        if (typeof showToast === 'function') {
                            showToast('error', 'Server Error', 'An error occurred while creating the group');
                        } else {
                            alert('AJAX Error: ' + error);
                        }
                    }
                });
            }


           function addGroupToTable(groupData) {
				
	 			  
    var $firstRow = $('#groups-datatable tbody tr:first');
    if ($firstRow.length && $firstRow.find('td[colspan="4"]').length > 0) {
        $firstRow.remove();
    }
	
     
    var $rows = $('#groups-datatable tbody tr');
    var nextNumber = $rows.length + 1; // This gives us G1, G2, G3...
    
     
    var newRow = '<tr>' +
        '<td>' +
            '<div class="d-flex align-items-center">' +
                '<div class="group-avatar me-3">G' + nextNumber + '</div>' +
                '<div>' + (groupData.group_name || 'New Group') + '</div>' +
            '</div>' +
        '</td>' +
        '<td><span class="participants-text">' + (groupData.participant_count || '0')+ '</span></td>' +
        '<td><span class="campaign-text">-</span></td>' +
        '<td>' +
            '<div class="action-buttons d-flex justify-content-center align-items-center">' +
                '<button class="icon-btn text-info" title="View" onclick="viewGroup(' + groupData.group_id + ')"><i class="ri-eye-line"></i></button>' +
                '<button class="icon-btn text-info mx-2" title="Edit" onclick="editGroup(' + groupData.group_id + ')"><i class="ri-edit-line"></i></button>' +
                '<button class="icon-btn text-danger" title="Delete" onclick="deleteGroup(' + groupData.group_id + ')"><i class="ri-delete-bin-5-line"></i></button>' +
                '<button class="btn btn-sm btn-success btn-w-xs btn-wave ms-2" title="Send" onclick="sendToGroup(' + groupData.group_id + ')"><i class="fas fa-paper-plane me-1"></i>Send</button>' +
            '</div>' +
        '</td>' +
    '</tr>';
    
     
    $('#groups-datatable tbody').prepend(newRow);
	
	 
    updateGroupNumbers();
	
	  
     if (typeof showToast === 'function') {
           showToast('info', 'Updated', 'New group added to the list');
     }

	
}
});



  
function deleteGroup(groupId) {
     
    let container = document.getElementById('custom-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'custom-toast-container';
        container.className = 'toast-container position-fixed top-0 start-50 translate-middle-x p-3';
        container.style.zIndex = '9999';
		container.style.maxWidth = '500px';
		 
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
                <p>Are you sure you want to delete this group?</p>
                <div class="mt-3">
                    <button class="btn btn-sm btn-outline-secondary me-2" data-bs-dismiss="toast">Cancel</button>
                    <button class="btn btn-sm btn-danger" onclick="proceedDelete(${groupId}, '${toastId}')">Yes, Delete</button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', toastHtml);
    new bootstrap.Toast(document.getElementById(toastId)).show();
}




function proceedDelete(groupId, toastId) {
     
    if (toastId && document.getElementById(toastId)) {
        bootstrap.Toast.getInstance(document.getElementById(toastId))?.hide();
    }
    
     
    showInfoToast('Deleting group...', 'Please wait');
    
     
    var formData = {
        group_id: groupId
    };
    
     
    $.ajax({
        url: 'welcome/delete_group',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                 
                if (typeof showToast === 'function') {
                    showToast('success', 'Success', response.message || 'Group deleted successfully!');
                } else {
                    alert('Success: ' + (response.message || 'Group deleted successfully!'));
                }
                
                 
                removeGroupFromTable(groupId);
            } else {
                 
                if (typeof showToast === 'function') {
                    showToast('error', 'Error', response.message || 'Failed to delete group');
                } else {
                    alert('Error: ' + (response.message || 'Failed to delete group'));
                }
            }
        },
        error: function(xhr, status, error) {
             
            if (typeof showToast === 'function') {
                showToast('error', 'Server Error', 'An error occurred while deleting the group');
            } else {
                alert('AJAX Error: ' + error);
            }
        }
    });
}

function removeGroupFromTable(groupId) {
     
    $('button[onclick*="deleteGroup(' + groupId + ')"]').closest('tr').fadeOut(300, function() {
        $(this).remove();
        
         
        updateGroupNumbers();
        
         
        if ($('#groups-datatable tbody tr').length === 0) {
            $('#groups-datatable tbody').html('<tr><td colspan="4" class="text-center">No groups found</td></tr>');
        }
        
         
        if (typeof showToast === 'function') {
            showToast('info', 'Updated', 'Group removed from list');
        }
    });
}


 

 
function updateGroupNumbers() {
    $('#groups-datatable tbody tr').each(function(index) {
        var $row = $(this);
         
        if ($row.find('td[colspan="4"]').length === 0) {
            var newNumber = index + 1;
            var $avatarDiv = $row.find('.group-avatar');
            if ($avatarDiv.length) {
                $avatarDiv.text('G' + newNumber);
            }
        }
    });
}



 
function editGroup(groupId) {
    
    if (typeof showToast === 'function') {
        //showInfoToast('Loading group data...', 'Please wait');
    }
    
     
    var formData = {
        group_id: groupId
    };
    
     
    $.ajax({
        url: 'welcome/get_group_for_edit',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                 
                $('#editGroupId').val(response.data.group.group_id);
                $('#editGroupName').val(response.data.group.group_name);
                
                 
                $('#editGroupModal').modal('show');
                
                 
                if (typeof showToast === 'function') {
                    //showToast('success', 'Success', 'Group data loaded');
                }
            } else {
                 
                if (typeof showToast === 'function') {
                    showToast('error', 'Error', response.message || 'Failed to load group data');
                } else {
                    alert('Error: ' + (response.message || 'Failed to load group data'));
                }
            }
        },
        error: function(xhr, status, error) {
            // Show error toast
            if (typeof showToast === 'function') {
                showToast('error', 'Server Error', 'An error occurred while loading group data');
            } else {
                alert('AJAX Error: ' + error);
            }
        }
    });
}

 
$(document).ready(function() {
     
    $('#updateGroupBtn').click(function(e) {
        e.preventDefault();
        updateGroupForm();
    });

     
    $('#editGroupName').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            updateGroupForm();
        }
    });

     
    $('#editGroupModal').on('hidden.bs.modal', function () {
        $('#editGroupId').val('');
        $('#editGroupName').val('');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });
});

 
function updateGroupForm() {
     
    var groupId = $('#editGroupId').val();
    var groupName = $('#editGroupName').val().trim();
    
     
    if (!groupId) {
        if (typeof showToast === 'function') {
            showToast('error', 'Validation Error', 'Group ID is missing');
        } else {
            alert('Group ID is missing');
        }
        return;
    }
    
    if (!groupName) {
        if (typeof showToast === 'function') {
            showToast('error', 'Validation Error', 'Group name is required');
        } else {
            alert('Group name is required');
        }
        return;
    }
    
    if (groupName.length < 2) {
        if (typeof showToast === 'function') {
            showToast('error', 'Validation Error', 'Group name must be at least 2 characters');
        } else {
            alert('Group name must be at least 2 characters');
        }
        return;
    }
    
    if (groupName.length > 45) {
        if (typeof showToast === 'function') {
            showToast('error', 'Validation Error', 'Group name must be less than 45 characters');
        } else {
            alert('Group name must be less than 45 characters');
        }
        return;
    }
    
     
    var originalText = $('#updateGroupBtn').html();
    $('#updateGroupBtn').prop('disabled', true).html('Updating...');
    
     
    var formData = {
        group_id: groupId,
        group_name: groupName
    };
    
     
    $.ajax({
        url: 'welcome/update_group',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
             
            $('#updateGroupBtn').prop('disabled', false).html(originalText);
            
            if (response.success) {
                 
                if (typeof showToast === 'function') {
                    showToast('success', 'Success', response.message || 'Group updated successfully!');
                } else {
                    alert('Success: ' + (response.message || 'Group updated successfully!'));
                }
                
                 
                $('#editGroupModal').modal('hide');
                
                 
                updateGroupInTable(response.data.group);
            } else {
                 
                if (typeof showToast === 'function') {
                    showToast('error', 'Error', response.message || 'Failed to update group');
                } else {
                    alert('Error: ' + (response.message || 'Failed to update group'));
                }
                
                 
                if (response.errors && response.errors.group_name) {
                    if (typeof showToast === 'function') {
                        showToast('error', 'Validation Error', response.errors.group_name);
                    } else {
                        alert('Validation Error: ' + response.errors.group_name);
                    }
                }
            }
        },
        error: function(xhr, status, error) {
             
            $('#updateGroupBtn').prop('disabled', false).html(originalText);
            
             
            if (typeof showToast === 'function') {
                showToast('error', 'Server Error', 'An error occurred while updating the group');
            } else {
                alert('AJAX Error: ' + error);
            }
        }
    });
}

 
function updateGroupInTable(groupData) {
     
    $('#groups-datatable tbody tr').each(function() {
        var $row = $(this);
         
        var editBtn = $row.find('button[onclick*="editGroup(' + groupData.group_id + ')"]');
        if (editBtn.length > 0) {
             
            $row.find('.d-flex.align-items-center div:last').text(groupData.group_name);
            
             
            if (typeof showToast === 'function') {
                showToast('info', 'Updated', 'Group name updated in list');
            }
            
            return false;  
        }
    });
}

function viewGroup(groupId) {
     
    window.location.href = 'welcome/group_screen?group_id=' + groupId;
} 
 
 
 $(document).ready(function() {
     
    $('.dataTables_filter input').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        
        $('#groups-datatable tbody tr').each(function() {
            var row = $(this);
            var rowText = row.text().toLowerCase();
            
            if (rowText.indexOf(value) > -1) {
                row.show();
            } else {
                row.hide();
            }
        });
    });
});

function updateGroupParticipantCount(groupId, newCount) {
     
    $('#groups-datatable tbody tr').each(function() {
        var viewBtn = $(this).find('button[onclick*="viewGroup(' + groupId + ')"]');
        if (viewBtn.length > 0) {
            $(this).find('.participants-text').text(newCount);
            return false;  
        }
    });
}

window.viewGroup = viewGroup;


 
window.editGroup = editGroup;


 
window.deleteGroup = deleteGroup;
window.proceedDelete = proceedDelete;
window.removeGroupFromTable = removeGroupFromTable;
window.updateGroupNumbers = updateGroupNumbers;



         
    </script>
</body>
</html> 