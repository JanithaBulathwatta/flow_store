<style>
/* CANCEL MODAL STYLES */
.can-modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.can-modal-box {
    width: 260px;
    background: #fff;
    border-radius: 6px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    overflow: hidden;
    font-family: Arial, sans-serif;
}

.can-modal-header {
	display:flex;
	justify-content:space-between;
	align-items:center;
	padding:8px 10px;
	border-bottom:1px solid #eee;
	font-size:13px !importeb;
	font-weight:600;
}

.can-modal-body {
    padding: 12px 10px;
    text-align: center;
}

.can-modal-footer {
    display: flex;
    gap: 6px;
    padding: 10px;
    border-top: 1px solid #eee;
}

.can-btn {
    flex: 1;
    padding: 6px 0;
    font-size: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.can-back { background: #e0e0e0; }

/* Orange color for Cancel action */
.can-confirm {
    background: rgb(46 142 247 / 90%); 
    color: #fff;
}
</style>

<link rel="stylesheet" type="text/css" href="/assets/css/header.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-12 mt-3">
				<div class="card custom-card card-bg mb-20">
					<div class="card-body"> 
						<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between"> 
							<div class="d-flex align-items-center"> 
								<span class="card-title me-6">Voucher List For Approval </span>
								<div class="d-flex gap-2 flex-wrap" id="supplier-status-container"></div>
								<div class="d-flex gap-2 flex-wrap" id="lead-status-container"> </div>
							</div> 
						</div> 
					</div>
					<div class="summary-bar" id="summary-bar"></div>
				</div>
			</div>
		

            <div class="col-xl-12">
                <div class="card custom-card">
                    <!-- HEADER -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title"> Voucher List For Approval </div>
                    </div>
                    <!-- BODY -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="leadsTable" class="table table-stripe text-nowrap w-100 dataTable no-footer" aria-describedby="datatable-basic_info">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voucher Name</th>
                                    <th>Voucher Amount</th>
                                    <th>Note</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
								
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function () {

		var table = initializeDataTable('#leadsTable');
	
		filter();
		
		function filter(status = 'all') {
			$.ajax({
				url: "<?= site_url('Voucher/get_data_for_approval'); ?>",
				type: "POST", // Logic to filter by status
				dataType: "json",
				success: function (res) {
					let tbody = '';

					// 1. Destroy existing DataTable before updating rows
					if ($.fn.DataTable.isDataTable('#leadsTable')) {
						$('#leadsTable').DataTable().clear().destroy();
						$('#leadsTable tbody').empty();
					}

					console.log(res);

					if (res.data && res.data.length > 0) {
						$.each(res.data, function (i, item) {
							
							const isCencel = item.status === 'cancel';
							const isDeleted = item.status === 'delete';
							const isActive  = item.status === 'active';
							
							let editDisabled = (isDeleted) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '';
							let deleteDisabled = (isDeleted) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '';
							let cancelDisabled = (isCencel || isDeleted) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '';
							
							let actionBtns = `
								<button class="btn btn-sm btn-icon btn-success-light approve_btn" data-id="${item.id}"><i class="ri-checkbox-circle-fill"></i></button>
								<button class="btn btn-sm btn-danger-light btn-icon reject_btn" data-id="${item.id}"><i class="ri-close-circle-line"></i></button>`;
							tbody += `
							<tr>
								<td>${item.id}</td>
								<td><span class="fw-medium">${item.emp_name}</span></td>
								<td>${item.amount ?? '-'}</td>
								<td>${item.note ?? '-'}</td>	
								<td class="text-center">
									${actionBtns}
								</td>
							</tr>`;
						});
					}

					
					// Update HTML
					$('#leadsTable tbody').html(tbody);
					initializeDataTable('#leadsTable');

				},
				error: function() {
					console.error("Failed to fetch data.");
				}
			});
		}
		
		
		$(document).on('click', '.approve_btn', function () {
			
			const id = $(this).data('id');
			
			$('body').app_modal({
				title : 'Approve Voucher',
				head : 'Approve voucher',
				para: 'Do you want to Approve this?',
				id : id,
				url : '/Voucher/approve?lid='+id,
				callback : function(res){
					 
					if(res != ''){
						filter();
						loadSubCounts();
						closeModal();
					}
				}
			});
		});
		
		$(document).on('click', '.reject_btn', function () {

			const id = $(this).data('id');

			console.log('Reject ID:', id);

			$('body').rej_modal({
				title: 'Reject Voucher',
				head: 'Reject Voucher',
				para: 'Do you want to reject this voucher?',
				id: id,
				url: '<?= site_url("Voucher/reject"); ?>?lid=' + id,
				callback: function(res) {
					console.log('Reject response:', res);
					
					if (res != '') {
						filter();
						loadSubCounts();
						closeModal();
					}
				}
			});
		});
		
		
	});

</script>