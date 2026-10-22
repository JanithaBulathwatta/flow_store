<?php if (!empty($comments)): ?>
    <ul class="list-unstyled">
        <?php foreach ($comments as $comment): ?>
            <li class="media mb-3">
                <div class="media-body">
                    <h6 class="mt-0 mb-1">
                        <?= html_escape($comment->commented_by); ?>
                        <small class="text-muted">
                            · <?= date('Y-m-d H:i', strtotime($comment->created_at)); ?>
                        </small>
                    </h6>
                    <p class="mb-0">
                        <?= nl2br(html_escape($comment->comment)); ?>
                    </p>
                </div>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="text-muted mb-0">No comments yet.</p>
<?php endif; ?>
