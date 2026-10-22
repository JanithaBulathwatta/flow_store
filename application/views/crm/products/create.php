<!--<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title mb-0">Create Product</h4>
            </div>

            <div class="card-body">
                <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <form method="post" action="<?= site_url('products/store'); ?>">

                    <div class="form-group">
                        <label>Product Name *</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="<?= set_value('name'); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"><?= set_value('description'); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="number"
                               step="0.01"
                               name="price"
                               class="form-control"
                               value="<?= set_value('price', '0.00'); ?>">
                    </div>

                    <div class="text-right">
                        <a href="<?= site_url('products'); ?>" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Product
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>-->


<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- PAGE TITLE -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <!--<div>
                <h4 class="fw-semibold mb-0">Create Product</h4>
            </div>-->
        </div>

        <!-- ROW -->
        <div class="row">

            <div class="col-xl-12">

                <!-- CARD -->
                <div class="card custom-card">

                    <!-- CARD HEADER -->
                    <div class="card-header">
                        <div class="card-title">
                            Create Product
                        </div>
                    </div>

                    <!-- CARD BODY -->
                    <div class="card-body">

                        <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                        <form method="post" action="<?= site_url('products/store'); ?>">

                            <div class="row gy-3">

                                <!-- PRODUCT NAME -->
                                <div class="col-xl-6">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text" name="name" class="form-control" value="<?= set_value('name'); ?>" required>
                                </div>

                                <!-- PRICE -->
                                <div class="col-xl-6">
                                    <label class="form-label">
                                        Price
                                    </label>
                                    <input type="number" step="0.01" name="price" class="form-control"  value="<?= set_value('price', '0.00'); ?>">
                                </div>

                                <!-- DESCRIPTION -->
                                <div class="col-xl-12">
                                    <label class="form-label">
                                        Description
                                    </label>
                                    <textarea name="description" class="form-control" rows="4"><?= set_value('description'); ?></textarea>
                                </div>

                                <!-- FORM ACTIONS -->
                                <div class="col-xl-12 text-end mt-3">

                                    <a href="<?= site_url('products'); ?>"
                                       class="btn btn-light">
                                        Cancel
                                    </a>

                                    <button type="submit"
                                            class="btn btn-primary ms-2">
                                        <i class="ri-save-line"></i>
                                        Save Product
                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>
                    <!-- END CARD BODY -->

                </div>
                <!-- END CARD -->

            </div>

        </div>
        <!-- END ROW -->

    </div>
</div>
<!-- End::app-content -->
