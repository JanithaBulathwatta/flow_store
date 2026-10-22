<!DOCTYPE html>
<html>
<head>
    <title>Accounts Tree</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background: #f5f7fa; }
        .tree ul {
            list-style-type: none;
            padding-left: 20px;
        }

        .tree li {
            margin: 5px 0;
            cursor: pointer;
        }

        .tree-node {
            padding: 6px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .tree-node:hover {
            background: #eef2f7;
        }

        .badge-posting { background: #1ab394; }
        .badge-nonposting { background: #f8ac59; }
    </style>
</head>

<body>

<div class="main-content app-content">
	<div class="container mt-4">
		<h4>Chart of Accounts - Tree</h4>

		<div class="card p-3 mt-3">
			<div id="treeContainer" class="tree"></div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
//const API_BASE = "http://localhost/accounting/api/v1";
const API_BASE = "https://medi.provioustech.com/";

/*function buildTree(accounts, parent = null) {
    let html = "<ul>";

    accounts
        .filter(acc => acc.parent_id == parent)
        .forEach(acc => {

            let badge = acc.is_posting == 1
                ? '<span class="badge badge-posting ml-2">P</span>'
                : '<span class="badge badge-nonposting ml-2">NP</span>';

            html += `
                <li>
                    <div class="tree-node">
                        ${acc.account_number} - ${acc.account_name}
                        ${badge}
                    </div>
                    ${buildTree(accounts, acc.id)}
                </li>
            `;
        });

    html += "</ul>";
    return html;
}

function loadTree() {
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

            let treeHtml = buildTree(res.payload);
            $("#treeContainer").html(treeHtml);
        }
    });
}*/

function buildTree(accounts, parent) {
    let html = "<ul>";

    accounts
        .filter(acc => acc.parent_id == parent && acc.id != parent)
        .forEach(acc => {

            let badge = acc.is_posting == 1
                ? '<span class="badge badge-posting ml-2">P</span>'
                : '<span class="badge badge-nonposting ml-2">NP</span>';
            html += `
                <li>
                    <div class="tree-node">
                        ${acc.account_number} - ${acc.account_name}
                        ${badge}
                    </div>
                    ${buildTree(accounts, acc.id)}
                </li>
            `;
        });

    html += "</ul>";
    return html;
}

function loadTree() {
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

            let accounts = res.payload;

            // Find roots (id == parent_id)
            let roots = accounts.filter(acc => acc.id == acc.parent_id);

            let html = "<ul>";

            roots.forEach(root => {
                html += `
                    <li>
                        <div class="tree-node">
                            ${root.account_number} - ${root.account_name}
                        </div>
                        ${buildTree(accounts, root.id)}
                    </li>
                `;
            });

            html += "</ul>";

            $("#treeContainer").html(html);
        }
    });
}

$(document).ready(function() {
    loadTree();
});
</script>

</body>
</html>