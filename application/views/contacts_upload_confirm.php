<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Contacts Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { padding: 20px; background-color: #f5f7fb; }
        .container { max-width: 1200px; }
        .table th { background-color: #f8f9fa; }
        .valid-row { background-color: #d4edda !important; }
        .invalid-row { background-color: #f8d7da !important; }
        .duplicate-row { background-color: #fff3cd !important; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-check-circle me-2"></i>Confirm Contacts Import
                </h4>
            </div>
            <div class="card-body">
                <?php if (!empty($note)): ?>
                    <div class="alert alert-info">
                        <strong>Note:</strong> <?php echo htmlspecialchars($note); ?>
                    </div>
                <?php endif; ?>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Review the contacts below. Only valid contacts will be imported.
                </div>
                
                <!-- Summary cards like your sample -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="mb-1"><?php echo $total_rows; ?></h5>
                                <small class="text-muted">Total Contacts</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h5 class="mb-1"><?php echo $valid_count; ?></h5>
                                <small>Valid Contacts</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h5 class="mb-1"><?php echo $invalid_count; ?></h5>
                                <small>Invalid</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h5 class="mb-1"><?php echo $duplicate_count; ?></h5>
                                <small>Duplicates</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form method="post" action="<?php echo site_url('welcome/save_contacts_import'); ?>">
                    <input type="hidden" name="upload_id" value="<?php echo $upload_id; ?>">
                    <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">Name</th>
                                    <th width="35%">Phone Number</th>
                                    <th width="25%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                    <?php
                                    $row_class = '';
                                    $badge_class = '';
                                    $icon = '';
                                    
                                    if ($contact['status'] == 'valid') {
                                        $row_class = 'valid-row';
                                        $badge_class = 'bg-success';
                                        $icon = 'fa-check';
                                    } elseif ($contact['status'] == 'invalid') {
                                        $row_class = 'invalid-row';
                                        $badge_class = 'bg-danger';
                                        $icon = 'fa-times';
                                    } elseif ($contact['status'] == 'duplicate') {
                                        $row_class = 'duplicate-row';
                                        $badge_class = 'bg-warning';
                                        $icon = 'fa-exclamation-triangle';
                                    }
                                    ?>
                                    <tr class="<?php echo $row_class; ?>">
                                        <td><?php echo $contact['row']; ?></td>
                                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                                        <td>
                                            <span class="badge <?php echo $badge_class; ?>">
                                                <i class="fas <?php echo $icon; ?> me-1"></i>
                                                <?php echo $contact['message']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="contacts[]" value="<?php echo htmlspecialchars(json_encode([
                                        'name' => $contact['name'],
                                        'phone' => $contact['phone_clean'],
                                        'status' => $contact['status']
                                    ])); ?>">
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?php echo site_url('welcome/group_screen?group_id=' . $group_id); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Group
                                </a>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-success" <?php echo ($valid_count == 0 ? 'disabled' : ''); ?>>
                                    <i class="fas fa-save me-2"></i>Import Valid Contacts (<?php echo $valid_count; ?>)
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>