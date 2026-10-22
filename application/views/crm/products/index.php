<!--<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Products</h4>
                <a href="<?= site_url('products/create'); ?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> New Product
                </a>
            </div>

            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="productsTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= html_escape($product->name); ?></td>

                                        <td><?= number_format($product->price, 2); ?></td>

                                        <td>
                                            <?php if ($product->is_active): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?= date('Y-m-d', strtotime($product->created_at)); ?>
                                        </td>

                                        <td class="text-center">
                                            <a href="<?= site_url('products/edit/'.$product->id); ?>"
                                               class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No products found
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
    $('#productsTable').DataTable({
        order: [[3, 'desc']],
        pageLength: 10
    });
});
</script>-->

<style>
    .mt-1{
        margin-top: 1rem !important;
    }
	
	#toast-container * {
	  -moz-box-sizing: border-box;
	  -webkit-box-sizing: border-box;
	  box-sizing: border-box;
	  color: #0c0c0c;
	}
</style>

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card mt-1">
					<!-- HEADER -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            Products List
                        </div>

                        <button class="btn btn-primary btn-sm" id="btnAddProduct">
							<i class="ri-add-line me-1"></i> New Product
						</button>
                    </div>

                    <!-- CARD BODY -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="productsTable" class="table table-bordered text-nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                        <tr>

                                            <td><?= html_escape($product->name); ?></td>

                                            <td><?= number_format($product->price, 2); ?> LKR</td>

                                            <td>
                                                <?php if ($product->is_active): ?>
                                                    <span class="badge bg-success-transparent">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary-transparent">Inactive</span>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= date('Y-m-d', strtotime($product->created_at)); ?></td>

                                            <td class="text-center">
                                                <div class="btn-list justify-content-center">
                                                    <button class="btn btn-sm btn-icon btn-warning-light btnEditProduct" data-id="<?= $product->id; ?>"> <i class="ri-edit-line"></i></button>
													<button class="btn btn-sm btn-danger-light btn-icon product-delete" data-id="<?= $product->id; ?>"> <i class="ri-delete-bin-line"></i> </button>
												</div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <form id="productForm">
                <div class="modal-header">
                    <h6 class="modal-title" id="productModalTitle">Product</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row gy-3">
                        <input type="hidden" id="product_id">

                        <div class="col-xl-6">
                            <label class="form-label">Product Name *</label>
                            <input type="text" id="product_name" class="form-control" required>
                        </div>

                        <div class="col-xl-6">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" id="product_price" class="form-control">
                        </div>

                        <div class="col-xl-12">
                            <label class="form-label">Description</label>
                            <textarea id="product_description" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="col-xl-6">
                            <label class="form-label">Status</label>
                            <select id="product_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btn-submit" class="btn btn-primary"><i class="ri-save-line me-1"></i> Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
	$(document).ready(function () {

		// Initialize DataTable (COMMON FUNCTION)
		var table = initializeDataTable('#productsTable');

		const modal = new bootstrap.Modal(document.getElementById('productModal'));

		// ==============================
		// OPEN CREATE MODAL
		// ==============================
		$('#btnAddProduct').click(function () {

			$('#productModalTitle').text('New Product');
			$('#productForm')[0].reset();
			$('#product_id').val('');
			$('#btn-submit').html('Save');
			modal.show();
		});

		// ==============================
		// OPEN EDIT MODAL
		// ==============================
		$(document).on('click', '.btnEditProduct', function () {

			let id = $(this).data('id');

			$('#productModalTitle').text('Edit Product');
			$('#product_id').val(id);

			modal.show();

			$.getJSON("<?= site_url('products/get'); ?>/" + id, function (res) {

				$('#product_name').val(res.name);
				$('#product_price').val(res.price);
				$('#product_description').val(res.description);
				$('#product_status').val(res.is_active);
				$('#btn-submit').html('Update');
		
			});

		});

		// ==============================
		// OPEN EDIT MODAL
		// ==============================
		$(document).on('click', '.product-delete', function () {

			let id = $(this).data('id');
			if (!id) return;

			toastr.warning(`
				<div class="mb-2">Delete this product?</div>
				<div class="text-end">
					<button class="btn btn-sm btn-danger confirmDelete" data-id="${id}">
						Yes Delete
					</button>
					<button class="btn btn-sm btn-light toastr-clear">
						Cancel
					</button>
				</div>
			`, "Confirm", {
				timeOut: 0,
				extendedTimeOut: 0,
				allowHtml: true,
				closeButton: true
			});
		});

		$(document).on('click', '.confirmDelete', function () {

			let id = $(this).data('id');
			toastr.clear();

			$.ajax({
				url: "<?= site_url('Products/delete'); ?>/" + id,
				type: "POST",
				dataType: "json",
				success: function (res) {

					if (res.success) {
						toastr.success(res.message);
						setTimeout(function () {
							location.reload();
						}, 600);
						
					} else {
						toastr.error(res.message);
					}
				},
				error: function () {
					toastr.error("Server error");
				}
			});
		});


		$(document).on('click', '.toastr-clear', function () {
			toastr.clear();
		});

		
		$(document).on('click', '.toastr-clear', function () {
			toastr.clear();
		});
		

		// ==============================
		// SAVE PRODUCT (CREATE + UPDATE)
		// ==============================
		$('#productForm').submit(function (e) {

			e.preventDefault();

			let id = $('#product_id').val();

			let url = id
				? "<?= site_url('products/update'); ?>/" + id
				: "<?= site_url('products/store'); ?>";

			$.ajax({
				url: url,
				type: "POST",
				dataType: "json",
				data: {
					name: $('#product_name').val(),
					price: $('#product_price').val(),
					description: $('#product_description').val(),
					is_active: $('#product_status').val()
				},
				success: function (response) {
					toastr.success(response.message);

					modal.hide();

					setTimeout(function () {
						location.reload();
					}, 800);

				},
				error: function () {

					toastr.error("Something went wrong");

				}
			});

		});

	});
</script>
