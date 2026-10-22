<!DOCTYPE html>
<html>
<head>
    <title>Chart of Accounts</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background: #f5f7fa; }
        .card { border-radius: 10px; }
        .table th { background: #f8f9fc; }
        .badge-posting { background: #1ab394; }
        .badge-nonposting { background: #f8ac59; }
        .badge-control { background: #ed5565; }
    </style>
</head>

<body>


<div class="main-content app-content">
	<div class="container-fluid mt-4">

		<div class="card p-3">
			<div class="d-flex justify-content-between mb-3">
				<h4>Chart of Accounts</h4>
				<button class="btn btn-primary" id="btnAddAccount">+ New Account</button>
				<!--<a href="/Journal/create_account"><button class="btn btn-primary" id="btnAddAccount">+ New Account</button></a>-->
			</div>
			<table class="table table-hover" id="accountsTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Account No</th>
						<th>Name</th>
						<th>Type</th>
						<th>Posting</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

	</div>
</div>

<div class="modal fade" id="accountModal">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="accountModalTitle">Create Account</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>

			<form id="accountForm">
				<div class="modal-body">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Account Name</label>
							<input type="text" class="form-control" name="account_name" required>
						</div>

						<div class="form-group col-md-3">
							<label>Class</label>
							<select class="form-control" name="account_class">
								<option value="1">Assets</option>
								<option value="2">Liabilities</option>
								<option value="3">Equity</option>
								<option value="4">Revenue</option>
								<option value="5">Cost</option>
								<option value="6">Expense</option>
							</select>
						</div>

						<div class="form-group col-md-3">
							<label>Type</label>
							<select class="form-control" name="account_type">
								<option>ASSET</option>
								<option>LIABILITY</option>
								<option>EQUITY</option>
								<option>REVENUE</option>
								<option>EXPENSE</option>
							</select>
						</div>
					</div>

					<div class="form-row">

						<div class="form-group col-md-6">
							<label>Parent Account</label>
							<select class="form-control" name="parent_id" id="parentAccount">
								<option value="">-- None --</option>
							</select>
						</div>

						<div class="form-group col-md-3">
							<label>Posting Account</label>
							<select class="form-control" name="is_posting">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</div>

						<div class="form-group col-md-3">
							<label>Control Account</label>
							<select class="form-control" name="is_control_account">
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</div>
					</div>
				
				
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary" id="btn-sub">Save Account</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->

<script>

	//const API_BASE = "http://localhost/accounting/api/v1";
	const API_BASE = "https://medi.provioustech.com/";
	
	$(document).ready(function() {
		
		const formModal = new bootstrap.Modal(document.getElementById('accountModal'));
		
		$('#btnAddAccount').click(function () {
			formModal.show();
		});
		
		loadAccounts();
		loadParents();
		
		//Submit Accounts for save or Update
 		$('#accountForm').ajax_submit({
			//url :API_BASE + "Accounts/create", 
			url: API_BASE + "Account_charts/create",
			rest: false,
			callback : function(id){
				$('#accountForm')[0].reset();
				loadAccounts();
				loadParents();
			}
		});
		
		function loadParents() {
			$.ajax({
				url: API_BASE + "Accounts/list",
				method: "GET",
				headers: {
					"X-CLIENT-KEY": "your-client-key",
					"X-CLIENT-SECRET": "your-client-secret"
				},
				success: function(res) {
					let html = '<option value="">-- None --</option>';
					res.payload.forEach(acc => {
						html += `<option value="${acc.id}">
							${acc.account_number} - ${acc.account_name}
						</option>`;
					});
					$("#parentAccount").html(html);
				}
			});
		}

		function loadAccounts() {
			$.ajax({
				url: API_BASE + "Accounts/list",
				method: "GET",
				headers: {
					"X-CLIENT-KEY": "your-client-key",
					"X-CLIENT-SECRET": "your-client-secret"
				},
				success: function(res) {
					if (!res.status) {
						alert(res.result_desc);
						return;
					}

					let html = "";

					res.payload.forEach((acc, index) => {

						let postingBadge = acc.is_posting == 1
							? '<span class="badge badge-posting">Posting</span>'
							: '<span class="badge badge-nonposting">Non</span>';

						if (acc.is_control_account == 1) {
							postingBadge = '<span class="badge badge-control">Control</span>';
						}

						html += `
							<tr>
								<td>${index + 1}</td>
								<td>${acc.account_number}</td>
								<td>${acc.account_name}</td>
								<td>${acc.account_type}</td>
								<td>${postingBadge}</td>
								<td>${acc.is_active == 1 ? 'Active' : 'Inactive'}</td>
							</tr>
						`;
					});

					$("#accountsTable tbody").html(html);
				}
			});
		}
		
	});
	
	
</script>

</body>
</html>