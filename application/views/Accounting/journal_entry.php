<!DOCTYPE html>
<html>
<head>
    <title>Journal Entry</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background: #f5f7fa; }
        .card { border-radius: 10px; }
        .table td { vertical-align: middle; }
        .total-box {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>

<body>



<div class="main-content app-content">

	<div class="container mt-4">

		<h4>Journal Entry</h4>

		<div class="card p-3 mt-3">

			<table class="table table-bordered" id="journalTable">
				<thead>
					<tr>
						<th>Account</th>
						<th width="150">Debit</th>
						<th width="150">Credit</th>
						<th width="50"></th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

			<button class="btn btn-sm btn-primary" onclick="addRow()">+ Add Row</button>

			<hr>

			<div class="row">
				<div class="col-md-6 total-box">Debit: <span id="totalDebit">0</span></div>
				<div class="col-md-6 total-box text-right">Credit: <span id="totalCredit">0</span></div>
			</div>

			<div class="mt-3">
				<textarea class="form-control" id="note" placeholder="Description"></textarea>
			</div>

			<button class="btn btn-success mt-3" onclick="submitJournal()">Post Journal</button>

		</div>

	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
//const API_BASE = "http://localhost/accounting/api/v1";
const API_BASE = "https://medi.provioustech.com/";
let accounts = [];

function loadAccounts() {
    $.ajax({
        url: API_BASE + "Accounts/list",
        method: "GET",
        headers: {
            "X-CLIENT-KEY": "your-client-key",
            "X-CLIENT-SECRET": "your-client-secret"
        },
        success: function(res) {
            accounts = res.payload;
            addRow();
        }
    });
}

function accountDropdown() {
    let html = '<select class="form-control account">';
    accounts.forEach(acc => {
        if (acc.is_posting == 1) {
            html += `<option value="${acc.id}">
                ${acc.account_number} - ${acc.account_name}
            </option>`;
        }
    });
    html += '</select>';
    return html;
}

function addRow() {
    let row = `
        <tr>
            <td>${accountDropdown()}</td>
            <td><input type="number" class="form-control debit" value="0"></td>
            <td><input type="number" class="form-control credit" value="0"></td>
            <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
        </tr>
    `;
    $("#journalTable tbody").append(row);
}

function removeRow(btn) {
    $(btn).closest("tr").remove();
    calculateTotals();
}

$(document).on("input", ".debit, .credit", calculateTotals);

function calculateTotals() {
    let debit = 0, credit = 0;

    $(".debit").each(function() { debit += parseFloat($(this).val()) || 0; });
    $(".credit").each(function() { credit += parseFloat($(this).val()) || 0; });

    $("#totalDebit").text(debit);
    $("#totalCredit").text(credit);
}

function submitJournal() {

    let lines = [];

    $("#journalTable tbody tr").each(function() {
        let acc = $(this).find(".account").val();
        let debit = parseFloat($(this).find(".debit").val()) || 0;
        let credit = parseFloat($(this).find(".credit").val()) || 0;

        if (debit > 0 || credit > 0) {
            lines.push({
                account_id: acc,
                debit: debit,
                credit: credit
            });
        }
    });

    let totalDebit = parseFloat($("#totalDebit").text());
    let totalCredit = parseFloat($("#totalCredit").text());

    if (totalDebit !== totalCredit) {
        toastr.warning("Journal not balanced!");
        return;
    }

    let payload = {
        function: "MANUAL_JV",
        note: $("#note").val(),
        payload: {
            lines: lines
        }
    };

    $.ajax({
        url: API_BASE + "Accounting/post",
        method: "POST",
        headers: {
            "X-CLIENT-KEY": "your-client-key",
            "X-CLIENT-SECRET": "your-client-secret",
            "X-IDEMPOTENCY-KEY": Date.now()
        },
        contentType: "application/json",
        data: JSON.stringify(payload),
        success: function(res) {
            toastr.success(res.result_desc);
        }
    });
}

$(document).ready(loadAccounts);
</script>

</body>
</html>-->