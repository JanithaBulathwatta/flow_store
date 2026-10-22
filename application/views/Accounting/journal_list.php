<!--<!DOCTYPE html>
<html>
<head>
    <title>Journal List</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background: #f5f7fa; }
        .card { border-radius: 10px; }
        .table th { background: #f8f9fc; }
    </style>
</head>

<body>

<div class="main-content app-content">
	<div class="container mt-4">

		<h4>Journal List</h4>

		<div class="card p-3 mt-3">

			<table class="table table-hover" id="journalTable">
				<thead>
					<tr>
						<th>Journal No</th>
						<th>Date</th>
						<th>Description</th>
						<th width="150">Action</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>

		</div>

	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
//const API_BASE = "http://localhost/accounting/api/v1";
const API_BASE = "https://medi.provioustech.com/";

var accountId = '1';

function loadJournals() {

    $.ajax({
        url: API_BASE + "Reports/ledger",
        method: "POST",
        headers: {
            "X-CLIENT-KEY": "your-client-key",
            "X-CLIENT-SECRET": "your-client-secret"
        },
        contentType: "application/json",
        data: JSON.stringify(),
        success: function(res) {

            let grouped = {};

            res.payload.forEach(row => {
                if (!grouped[row.journal_no]) {
                    grouped[row.journal_no] = row;
                }
            });

            let html = "";

            Object.values(grouped).forEach(j => {
                html += `
                    <tr>
                        <td>${j.journal_no}</td>
                        <td>${j.transaction_date}</td>
                        <td>${j.description || ''}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="viewJournal('${j.journal_no}')">View</button>
                        </td>
                    </tr>
                `;
            });

            $("#journalTable tbody").html(html);
        }
    });
}

function viewJournal(journal_no) {
    window.location = "journal_view.php?journal_no=" + journal_no;
}

$(document).ready(loadJournals);
</script>

</body>
</html>-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Journal List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background: #f5f7fa; }
        .card { border-radius: 10px; }
        .table th { background: #f8f9fc; }
    </style>
</head>
<body>

<div class="main-content app-content">
	<div class="container-fluid mt-4">
		<div class="card p-3">
			<div class="d-flex justify-content-between mb-3">
				<h4>Journal List</h4>
				<a href="/Journal/journal_entry"><button class="btn btn-primary">+ Journal Entry</button></a>
			</div>
			
			<!-- Hidden field or dynamic source for account_id -->
			<input type="hidden" id="accountIdInput" value="1">

			<div class="card p-3 mt-3">
				<table class="table table-hover" id="journalTable">
					<thead>
						<tr>
							<th>Journal No</th>
							<th>Date</th>
							<th>Description</th>
							<th width="150">Action</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>

	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
const API_BASE = "https://medi.provioustech.com/";

function loadJournals(accountId) {
    console.log("Loading journals for account_id:", accountId);

    $.ajax({
        url: API_BASE + "Reports/ledger",
        method: "POST",
        headers: {
            "X-CLIENT-KEY": "your-client-key",
            "X-CLIENT-SECRET": "your-client-secret"
        },
        contentType: "application/json",
        data: JSON.stringify({ account_id: accountId }),
        success: function(res) {
            if (!res || !res.payload) {
                console.warn("No payload returned");
                $("#journalTable tbody").html("<tr><td colspan='4'>No data available</td></tr>");
                return;
            }

            let grouped = {};
            res.payload.forEach(row => {
                if (!grouped[row.journal_no]) {
                    grouped[row.journal_no] = row;
                }
            });

            let html = "";
            Object.values(grouped).forEach(j => {
                html += `
                    <tr>
                        <td>${j.journal_no}</td>
                        <td>${j.transaction_date}</td>
                        <td>${j.description || ''}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="viewJournal('${j.journal_no}')">View</button>
                        </td>
                    </tr>
                `;
            });

            $("#journalTable tbody").html(html);
        },
        error: function(xhr, status, error) {
            console.error("Error loading journals:", status, error, xhr.responseText);
            $("#journalTable tbody").html("<tr><td colspan='4'>Error loading data</td></tr>");
        }
    });
}

function viewJournal(journal_no) {
    //window.location = "journal_view.php?journal_no=" + encodeURIComponent(journal_no);
    window.location = "/Journal/journal_view?journal_no=" + encodeURIComponent(journal_no);
}

$(document).ready(function() {
    // Get accountId dynamically (from hidden input, session, or server-side injection)
    var accountId = $("#accountIdInput").val();
    loadJournals(accountId);
});
</script>

</body>
</html>