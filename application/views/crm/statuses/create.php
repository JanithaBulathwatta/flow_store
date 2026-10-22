<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title mb-0">Create Lead Status</h4>
            </div>

            <div class="card-body">
                <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <form method="post" action="<?= site_url('leadstatuses/store'); ?>">

                    <div class="form-group">
                        <label>Status Name *</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="<?= set_value('name'); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Color</label>
                        <input type="color"
                               name="color"
                               class="form-control"
                               value="<?= set_value('color', '#6c757d'); ?>">
                        <small class="text-muted">
                            Used for status badge color
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number"
                               name="sort_order"
                               class="form-control"
                               value="<?= set_value('sort_order', 0); ?>">
                    </div>

                    <div class="text-right">
                        <a href="<?= site_url('leadstatuses'); ?>" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Status
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
