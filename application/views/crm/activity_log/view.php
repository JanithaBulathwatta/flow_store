<div class="row">
    <div class="col-md-8">

        <!-- Log Details -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    Activity Log #<?= (int)$log->activitylog_id; ?>
                </h4>
            </div>

            <div class="card-body">

                <p><strong>Module:</strong> <?= html_escape($log->module); ?></p>

                <p><strong>Action:</strong> <?= html_escape($log->action); ?></p>

                <p><strong>Action Type:</strong>
                    <span class="badge bg-primary">
                        <?= html_escape($log->action_type); ?>
                    </span>
                </p>

                <p><strong>Status:</strong>
                    <span class="badge bg-success">
                        <?= html_escape($log->status); ?>
                    </span>
                </p>

                <p><strong>User:</strong> <?= html_escape($log->full_name ?? $log->username); ?></p>

                <p><strong>User Type:</strong> <?= html_escape($log->user_type); ?></p>

                <p><strong>IP Address:</strong> <?= html_escape($log->ip_address); ?></p>

                <p><strong>Platform:</strong> <?= html_escape($log->platform); ?></p>

                <p><strong>Device:</strong> <?= html_escape($log->device_type); ?></p>

                <p><strong>Created:</strong> <?= date('Y-m-d H:i', strtotime($log->created_at)); ?></p>

            </div>
        </div>

        <!-- Request Details -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Request Details</h4>
            </div>

            <div class="card-body">

                <p><strong>Method:</strong> <?= html_escape($log->request_method); ?></p>

                <p><strong>URL:</strong> <?= html_escape($log->request_url); ?></p>

                <hr>

                <p><strong>Request Params</strong></p>
                <pre><?= json_encode(json_decode($log->request_params), JSON_PRETTY_PRINT); ?></pre>

                <p><strong>Headers</strong></p>
                <pre><?= json_encode(json_decode($log->request_headers), JSON_PRETTY_PRINT); ?></pre>

            </div>
        </div>

    </div>

    <!-- Right Sidebar -->
    <div class="col-md-4">

        <!-- Data Changes -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title mb-0">Changed Fields</h4>
            </div>

            <div class="card-body">

                <pre><?= json_encode(json_decode($log->changed_fields), JSON_PRETTY_PRINT); ?></pre>

            </div>
        </div>

        <!-- Old vs New Data -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Data Changes</h4>
            </div>

            <div class="card-body">

                <p><strong>Old Data</strong></p>
                <pre><?= json_encode(json_decode($log->old_data), JSON_PRETTY_PRINT); ?></pre>

                <hr>

                <p><strong>New Data</strong></p>
                <pre><?= json_encode(json_decode($log->new_data), JSON_PRETTY_PRINT); ?></pre>

            </div>
        </div>

    </div>
</div>