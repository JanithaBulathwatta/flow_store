<div class="row">
    <div class="col-md-8">

        <!-- Lead Details -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    Lead: <?= html_escape($lead->customer_name); ?>
                </h4>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> <?= html_escape($lead->customer_email); ?></p>
                <p><strong>Phone:</strong> <?= html_escape($lead->customer_phone); ?></p>
                <p><strong>Source:</strong> <?= html_escape($lead->source); ?></p>
                <p><strong>Product:</strong> <?= html_escape($lead->product_name ?? '-'); ?></p>

                <p>
                    <strong>Status:</strong>
                    <span class="badge"
                          style="background-color: <?= html_escape($lead->status_color); ?>">
                        <?= html_escape($lead->status_name); ?>
                    </span>
                </p>

                <p><strong>Assigned To:</strong> <?= html_escape($lead->assigned_user_name); ?></p>
                <p><strong>Created:</strong> <?= date('Y-m-d H:i', strtotime($lead->created_at)); ?></p>

                <?php if (!empty($lead->notes)): ?>
                    <hr>
                    <p><strong>Notes</strong></p>
                    <p><?= nl2br(html_escape($lead->notes)); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comments -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Comments</h4>
            </div>

            <div class="card-body">
                <div id="comments-container">
                    <p class="text-muted">Loading comments...</p>
                </div>

                <hr>

                <form id="commentForm">
                    <input type="hidden" name="lead_id" value="<?= (int)$lead->id; ?>">
                    <div class="form-group">
                        <textarea name="comment" class="form-control" rows="3"
                                  placeholder="Add a comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-comment"></i> Add Comment
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Right Sidebar -->
    <div class="col-md-4">

        <!-- Reassign Lead -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title mb-0">Reassign Lead</h4>
            </div>
            <div class="card-body">
                <form id="assignForm">
                    <input type="hidden" name="lead_id" value="<?= (int)$lead->id; ?>">

                    <div class="form-group">
                        <select name="assigned_user_id" class="form-control" required>
                            <?php foreach ($this->user->get_active_users() as $user): ?>
                                <option value="<?= $user->id; ?>"
                                    <?= $user->name === $lead->assigned_user_name ? 'selected' : ''; ?>>
                                    <?= html_escape($user->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fa fa-user"></i> Reassign
                    </button>
                </form>
            </div>
        </div>

        <!-- Assignment History -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Assignment History</h4>
            </div>
            <div class="card-body" id="assignment-history">
                <p class="text-muted">Loading history...</p>
            </div>
        </div>

    </div>
</div>

<script>
$(function () {

    // Load comments
    function loadComments() {
        $('#comments-container').load(
            "<?= site_url('leadcomments/list/'.$lead->id); ?>"
        );
    }

    // Load assignment history
    function loadHistory() {
        $('#assignment-history').load(
            "<?= site_url('leadassignments/history/'.$lead->id); ?>"
        );
    }

    loadComments();
    loadHistory();

    // Add comment
    $('#commentForm').on('submit', function (e) {
        e.preventDefault();

        $.post(
            "<?= site_url('leadcomments/store'); ?>",
            $(this).serialize(),
            function (res) {
                if (res.success) {
                    $('#commentForm')[0].reset();
                    loadComments();
                } else {
                    alert(res.message);
                }
            },
            'json'
        );
    });

    // Reassign lead
    $('#assignForm').on('submit', function (e) {
        e.preventDefault();

        $.post(
            "<?= site_url('leadassignments/assign'); ?>",
            $(this).serialize(),
            function (res) {
                if (res.success) {
                    loadHistory();
                } else {
                    alert(res.message);
                }
            },
            'json'
        );
    });

});
</script>
