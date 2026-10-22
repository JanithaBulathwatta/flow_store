
<div class="row">
    <div class="col-md-6 col-sm-12 mx-auto mt-5">
        <div class="card bg-dark text-white border-secondary shadow">
            <div class="card-header border-secondary bg-black">
                <h4 class="card-title text-uppercase font-monospace mb-0 text-info">Data Migration Portal</h4>
            </div>
            <div class="card-body">
                <form id="migrationForm" enctype="multipart/form-data">
                    <div class="form-group mb-4">
                        <label class="text-warning fw-bold mb-2">SELECT CLEAN INTEGRATED SALES CSV DOCUMENT:</label>
                        <input type="file" name="sales_file" id="sales_file" class="form-control bg-secondary text-white border-dark" accept=".csv" required />
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-success font-monospace w-100 fw-bold">RUN DATABASE INGESTION</button>
                </form>
                <div id="migrationResponseLog" class="mt-3 font-monospace d-none alert"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$('#migrationForm').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    
    $('#submitBtn').prop('disabled', true).text('PROCESSING MULTI-TABLE INSERTS...');
    $('#migrationResponseLog').addClass('d-none').removeClass('alert-success alert-danger');

    // FIX: Safely targets the route relative to the domain origin root
    var cleanUrl = window.location.origin + '/index.php/Form_submition/import_sales';

    $.ajax({
        url: cleanUrl,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            $('#submitBtn').prop('disabled', false).text('RUN DATABASE INGESTION');
            $('#migrationResponseLog').removeClass('d-none').addClass('alert-success').html('<strong>SUCCESS:</strong> ' + response.message);
        },
        error: function(xhr) {
            $('#submitBtn').prop('disabled', false).text('RUN DATABASE INGESTION');

            var errorMsg = 'An unexpected server error occurred.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            } else if (xhr.responseText) {
                errorMsg = '<div class="text-start bg-black text-danger p-2 border border-danger font-monospace" style="max-height: 250px; overflow-y: auto;">' + xhr.responseText + '</div>';
            }

            $('#migrationResponseLog').removeClass('d-none').addClass('alert-danger').html('<strong>ERROR:</strong> ' + errorMsg);
        }
    });
});
</script>