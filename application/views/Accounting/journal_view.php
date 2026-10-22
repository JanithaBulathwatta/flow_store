<!DOCTYPE html>
<html>
<head>
    <title>Journal View</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background: #f5f7fa; }
        .card { border-radius: 10px; }
        .total-box { font-weight: bold; }
    </style>
</head>

<body>

<div class="main-content app-content">
	<div class="container mt-4">

		<h4>Journal Details</h4>

		<div class="card p-3 mt-3">

			<h5 id="journalNo"></h5>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Account</th>
						<th>Debit</th>
						<th>Credit</th>
					</tr>
				</thead>
				<tbody id="journalBody"></tbody>
			</table>

			<div class="row">
				<div class="col-md-6 total-box">Debit: <span id="totalDebit"></span></div>
				<div class="col-md-6 total-box text-right">Credit: <span id="totalCredit"></span></div>
			</div>

			<button class="btn btn-danger mt-3" onclick="reverseJournal()">Reverse Journal</button>

		</div>

	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
//const API_BASE = "http://localhost/accounting/api/v1";
const API_BASE = "https://medi.provioustech.com/";
const params = new URLSearchParams(window.location.search);
const journal_no = params.get("journal_no");

function loadJournal() {

    $("#journalNo").text("Journal: " + journal_no);

    $.ajax({
        url: API_BASE + "Reports/journal",
        method: "POST",
        headers: {
            "X-CLIENT-KEY": "your-client-key",
            "X-CLIENT-SECRET": "your-client-secret"
        },
        contentType: "application/json",
        data: JSON.stringify({ journal_no }),
        success: function(res) {

            let html = "";
            let debit = 0, credit = 0;

            res.payload.forEach(row => {

                debit += parseFloat(row.debit);
                credit += parseFloat(row.credit);

                html += `
                    <tr>
                        <td>${row.account_id}</td>
                        <td>${row.debit}</td>
                        <td>${row.credit}</td>
                    </tr>
                `;
            });

            $("#journalBody").html(html);
            $("#totalDebit").text(debit);
            $("#totalCredit").text(credit);
        }
    });
}

function reverseJournal() {

    if (!confirm("Are you sure to reverse this journal?")) return;

    $.ajax({
        url: API_BASE + "Accounting/reverse",
        method: "POST",
        headers: {
            "X-CLIENT-KEY": "your-client-key",
            "X-CLIENT-SECRET": "your-client-secret"
        },
        contentType: "application/json",
        data: JSON.stringify({ journal_no }),
        success: function(res) {
            alert(res.result_desc);
        }
    });
}

$(document).ready(loadJournal);
</script>

</body>
</html>