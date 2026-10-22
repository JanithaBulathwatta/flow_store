<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title mb-0">Create Lead</h4>
            </div>

            <div class="card-body">
                <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <form method="post" action="<?= site_url('leads/store'); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer Name *</label>
                                <input type="text" name="customer_name" class="form-control"
                                       value="<?= set_value('customer_name'); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer Email</label>
                                <input type="email" name="customer_email" class="form-control"
                                       value="<?= set_value('customer_email'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer Phone</label>
                                <input type="text" name="customer_phone" class="form-control"
                                       value="<?= set_value('customer_phone'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Source</label>
                                <input type="text" name="source" class="form-control"
                                       value="<?= set_value('source'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product</label>
                                <select name="product_id" class="form-control">
                                    <option value="">-- Select Product --</option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product->id; ?>"
                                            <?= set_select('product_id', $product->id); ?>>
                                            <?= html_escape($product->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status *</label>
                                <select name="status_id" class="form-control" required>
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= $status->id; ?>"
                                            <?= set_select('status_id', $status->id); ?>>
                                            <?= html_escape($status->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Assign To *</label>
                                <select name="assigned_user_id" class="form-control" required>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user->id; ?>"
                                            <?= set_select('assigned_user_id', $user->id); ?>>
                                            <?= html_escape($user->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Priority</label>
                        <select name="priority" class="form-control">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="4"><?= set_value('notes'); ?></textarea>
                    </div>

                    <div class="text-right">
                        <a href="<?= site_url('leads'); ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Lead
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
