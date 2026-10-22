<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Lead Statuses</h4>
                <a href="<?= site_url('leadstatuses/create'); ?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> New Status
                </a>
            </div>

            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="statusTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Color</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($statuses)): ?>
                                <?php foreach ($statuses as $status): ?>
                                    <tr>
                                        <td><?= html_escape($status->name); ?></td>

                                        <td>
                                            <span class="badge"
                                                  style="background-color: <?= html_escape($status->color); ?>">
                                                <?= html_escape($status->color); ?>
                                            </span>
                                        </td>

                                        <td><?= (int)$status->sort_order; ?></td>

                                        <td>
                                            <?php if ($status->is_active): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <a href="<?= site_url('leadstatuses/edit/'.$status->id); ?>"
                                               class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No statuses found
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

<script>
$(function () {
    $('#statusTable').DataTable({
        order: [[2, 'asc']],
        pageLength: 10
    });
});
</script>
