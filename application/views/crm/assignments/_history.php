<?php if (!empty($history)): ?>
    <ul class="list-unstyled">
        <?php foreach ($history as $item): ?>
            <li class="media mb-3">
                <div class="media-body">
                    <h6 class="mt-0 mb-1">
                        <?= html_escape($item->assigned_to); ?>
                        <small class="text-muted">
                            · assigned by <?= html_escape($item->assigned_by); ?>
                        </small>
                    </h6>
                    <small class="text-muted">
                        <?= date('Y-m-d H:i', strtotime($item->assigned_at)); ?>
                    </small>
                </div>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="text-muted mb-0">No assignment history available.</p>
<?php endif; ?>
