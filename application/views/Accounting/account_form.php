<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background: #f5f7fa; }
        .card { border-radius: 10px; }
        .form-control { border-radius: 6px; }
    </style>
</head>

<body>

<div class="main-content app-content">

	<div class="container mt-4">

		<h4>Create Account</h4>

		<div class="card p-4 mt-3">

			<form id="accountForm">

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

				<button type="submit" class="btn btn-primary">Save Account</button>

			</form>

		</div>

	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
//const API_BASE = "http://localhost/accounting/api/v1";
const API_BASE = "https://medi.provioustech.com/";
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

$("#accountForm").submit(function(e) {
    e.preventDefault();

    let data = $(this).serializeArray();
    let payload = {};

    data.forEach(i => payload[i.name] = i.value);

    $.ajax({
        url: API_BASE + "Accounts/create",
        method: "POST",
        headers: {
            "X-CLIENT-KEY": "your-client-key",
            "X-CLIENT-SECRET": "your-client-secret"
        },
        contentType: "application/json",
        data: JSON.stringify(payload),
        success: function(res) {
            alert(res.result_desc);
        }
    });
});

$(document).ready(loadParents);
</script>

</body>
</html>