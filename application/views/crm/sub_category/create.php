<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title mb-0"><?= isset($category) ? 'Edit' : 'Create'; ?> Sub Category</h4>
            </div>

            <div class="card-body">
                <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <form method="post" action="<?= site_url('Sub_category/store'); ?>">
                    
                    <input type="hidden" name="lid" value="<?= isset($category) ? $category->id : ''; ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Category Name *</label>
                                <input type="text" name="Category_name" class="form-control"
                                       value="<?= set_value('Category_name', isset($category) ? $category->name : ''); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Category Code *</label>
                                <input type="text" name="Category_code" class="form-control"
                                       value="<?= set_value('Category_code', isset($category) ? $category->code : ''); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Count</label>
                                <input type="number" name="Category_count" class="form-control"
                                       value="<?= set_value('Category_count', isset($category) ? $category->count : '0'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" <?= set_select('status', 'active', (isset($category) && $category->status == 'active')); ?>>Active</option>
                                    <option value="inactive" <?= set_select('status', 'inactive', (isset($category) && $category->status == 'inactive')); ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Super Category</label>
                                <select name="super_category_id" class="form-control">
                                    <option value="">-- Select Super Category --</option>
                                    </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="<?= site_url('Sub_category'); ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> <?= isset($category) ? 'Update' : 'Save'; ?> Category
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>