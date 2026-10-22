<div class="main-content app-content">
<div class="container-fluid">
<div class="row">


<!-- PAGE HEADER -->
<div class="col-md-12 mt-3">
<div class="card custom-card">
<div class="card-body">

<div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">

<div class="d-flex align-items-center">
<span class="fw-medium fs-16 me-2">Bank Accounts Management</span>
</div>

<div class="d-flex flex-wrap gap-2 align-items-center">
<button class="btn btn-success" id="btnAddAccount">
<i class="ri-add-line me-1 fw-medium align-middle"></i> Add New Account
</button>
</div>

</div>

</div>
</div>
</div>


<!-- TABLE -->
<div class="col-xl-12">

<div class="card custom-card">

<div class="card-header d-flex justify-content-between align-items-center">
<div class="card-title">Bank Accounts List</div>
</div>

<div class="card-body">

<div class="table-responsive">

<table id="bankTable" class="table table-stripe text-nowrap w-100 dataTable">

<thead>
<tr>

<th>#</th>
<th>Bank Name</th>
<th>Branch</th>
<th>Account Name</th>
<th>Account Number</th>
<th>current balance</th>
<th>OD Limit</th>
<th class="text-center">Actions</th>

</tr>
</thead>

<tbody></tbody>

</table>

</div>

</div>

</div>

</div>

</div>
</div>
</div>


<!-- MODAL -->

<div class="modal fade" id="accountModal">

<div class="modal-dialog modal-lg modal-dialog-centered">

<div class="modal-content">

<form id="accountForm">

<div class="modal-header">

<h6 class="modal-title" id="accountModalTitle">Bank Account</h6>

<button type="button" class="btn-close" data-bs-dismiss="modal"></button>

</div>


<div class="modal-body">

<input type="hidden" id="bank_acc_id" name="lid">

<div class="row gy-3">


<div class="col-xl-6">
    <label class="form-label">Bank *</label>
    <select name="bank_id" id="bank_id" class="form-control form-select-sm" required>
        <option value="">Select Bank</option>
        <?php foreach ($banks as $bank): ?>
            <option value="<?= $bank->bank_id ?>">
                <?= html_escape($bank->bank_name); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div class="invalid-feedback">Please select a bank</div>
</div>


<div class="col-xl-6">
<label class="form-label">Branch</label>

<input type="text"
name="branch_name"
id="branch_name"
class="form-control form-control-sm">

</div>


<div class="col-xl-6">
<label class="form-label">Account Name *</label>

<input type="text"
name="account_name"
id="account_name"
class="form-control form-control-sm">

</div>


<div class="col-xl-6">
<label class="form-label">Account Number *</label>

<input type="text"
name="account_number"
id="account_number"
class="form-control form-control-sm">

</div>

<div class="col-xl-6">
<label class="form-label">Account Nickname</label>

<input type="text"
name="account_nickname"
id="account_nickname"
class="form-control form-control-sm">

</div>


<div class="col-xl-6">
<label class="form-label">Account Type</label>

<select
name="account_type"
id="account_type"
class="form-control form-select-sm">

<option value="">Select Type</option>
<option value="current">Current</option>
<option value="savings">Savings</option>
<option value="od">OD</option>

</select>

</div>

<div class="col-xl-6">
<label class="form-label">Current balance</label>

<input type="number"
name="current_balance"
id="current_balance"
class="form-control form-control-sm">

</div>


<div class="col-xl-6">
<label class="form-label">OD Limit</label>

<input type="number"
name="od_limit"
id="od_limit"
class="form-control form-control-sm">

</div>


</div>

</div>


<div class="modal-footer">

<button type="button" class="btn btn-light" data-bs-dismiss="modal">
Cancel
</button>

<button type="submit" class="btn btn-primary">
<i class="ri-save-line me-1"></i> Save
</button>

</div>

</form>

</div>

</div>

</div>



<script>

$(document).ready(function(){

var table = initializeDataTable('#bankTable');

const formModal = new bootstrap.Modal(document.getElementById('accountModal'));

loadAccounts();

/* ADD ACCOUNT BUTTON */
$('#btnAddAccount').click(function(){
    $('#accountForm')[0].reset();
    $('#bank_acc_id').val('');
    $('#accountModalTitle').text('Add Bank Account');
    formModal.show();
});

/* SAVE ACCOUNT - Single submit handler */
$('#accountForm').on('submit', function(e) {
    e.preventDefault();
    
    // Validate bank selection
    var bankId = $('#bank_id').val();
    if (!bankId || bankId === '') {
        alert('Please select a bank');
        $('#bank_id').focus();
        return false;
    }
    
    // Validate account name
    var accountName = $('#account_name').val();
    if (!accountName || accountName.trim() === '') {
        alert('Account Name is required');
        $('#account_name').focus();
        return false;
    }
    
    // Validate account number
    var accountNumber = $('#account_number').val();
    if (!accountNumber || accountNumber.trim() === '') {
        alert('Account Number is required');
        $('#account_number').focus();
        return false;
    }
    
    // Get form data
    var formData = {
        lid: $('#bank_acc_id').val(),
        bank_id: $('#bank_id').val(),
        branch_name: $('#branch_name').val(),
        account_name: $('#account_name').val(),
        account_number: $('#account_number').val(),
        current_balance: $('#current_balance').val(),
        od_limit: $('#od_limit').val(),
        account_nickname: $('#account_nickname').val(),
        account_type: $('#account_type').val()
    };
    
    // Submit via AJAX
    $.ajax({
        url: '/Finance/store_account',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response && response.stt === 'error') {
                alert(response.msg);
            } else {
                $('#accountForm')[0].reset();
                formModal.hide();
                loadAccounts();
                // Show success message
                if (response && response.msg) {
                    alert(response.msg);
                }
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
            console.log('Response:', xhr.responseText);
            alert('An error occurred while saving. Please check console for details.');
        }
    });
});

/* LOAD TABLE */
function loadAccounts(){
    if ($.fn.DataTable.isDataTable('#bankTable')) {
        $('#bankTable').DataTable().clear().destroy();
    }
    
    $.ajax({
        url: "<?= site_url('Finance/get_accounts') ?>",
        type: "POST",
        dataType: "json",
        success: function(res){
            let tbody = '';
            if(res.data.length > 0){
                $.each(res.data, function(i, item){
                    tbody += `
                    <tr>
                        <td>${item.bank_acc_id}</td>
                        <td>${item.bank_name}</td>
                        <td>${item.branch_name ?? '-'}</td>
                        <td>${item.account_name}</td>
                        <td>${item.account_number}</td>
                        <td>${item.current_balance ?? 0}</td>
                        <td>${item.od_limit ?? 0}</td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-icon btn-warning-light btnEdit" data-id="${item.bank_acc_id}">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-sm btn-danger-light btn-icon btnDelete" data-id="${item.bank_acc_id}">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </td>
                    </tr>
                    `;
                });
            } else {
                tbody = `
                <tr>
                    <td colspan="8" class="text-center text-muted">No Bank Accounts Found</td>
                </tr>
                `;
            }
            $('#bankTable tbody').html(tbody);
            table = initializeDataTable('#bankTable');
        },
        error: function(xhr, status, error) {
            console.log('Error loading accounts:', error);
        }
    });
}

/* EDIT ACCOUNT */
$(document).on('click', '.btnEdit', function(){
    let id = $(this).data('id');
    $('#accountModalTitle').text('Edit Bank Account');
    $('#bank_acc_id').val(id);
    formModal.show();
    
    $.getJSON("<?= site_url('Finance/view_account?lid='); ?>" + id, function(res){
        let a = res.account;
        $('#bank_id').val(a.bank_id);
        $('#branch_name').val(a.branch_name);
        $('#account_name').val(a.account_name);
        $('#account_number').val(a.account_number);
        $('#current_balance').val(a.current_balance);
        $('#od_limit').val(a.od_limit);
        $('#account_nickname').val(a.account_nickname);
        $('#account_type').val(a.account_type);
    }).fail(function() {
        alert('Error loading account details');
    });
});

/* DELETE ACCOUNT */
$(document).on('click', '.btnDelete', function(){
    let id = $(this).data('id');
    if(confirm('Are you sure you want to delete this account?')) {
        $.ajax({
            url: '/Finance/delete_account?lid=' + id,
            type: 'GET', // or 'POST' depending on your server
            success: function(response) {
                loadAccounts();
            },
            error: function() {
                alert('Error deleting account');
            }
        });
    }
});

});



</script>