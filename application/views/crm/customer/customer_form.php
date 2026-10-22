<style>
<style>
	.app-content, .main-content, .content-area {
		background: rgb(255, 255, 255) !important;
	}
</style>

	<form id="leadForm">		
		<input type="hidden" id="lead_id" name="lid">
		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Customer Name *<span class="text-danger"></span></label>
				<input type="text" name="name" id="name" class="form-control" required maxlength="100" required
				pattern="[A-Za-z\s]+" 
				title="Please enter letters and spaces only">
			</div>
			
			<div class="col-md-6 mb-3">
				<label class="form-label">Email</label>
				<input type="email" name="email" id="email" class="form-control" 
					   title="Please enter a valid email address">
			</div>
		</div>

			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label">Phone One *</label>
					<input type="text" name="phone" id="phone" class="form-control" required 
						   pattern="[0-9+\-\s]{10,15}" 
						   title="Please enter a valid phone number (10-15 digits)">
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label">Phone Two</label>
					<input type="text" name="phone_two" id="phone_two" class="form-control"  
						   pattern="[0-9+\-\s]{10,15}" 
						   title="Please enter a valid phone number (10-15 digits)">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label">Address *</label>
					<textarea name="address" id="address" class="form-control" rows="1" maxlength="255" required></textarea>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label">Company Name</label>
					<input type="text" name="company_name" id="company_name" class="form-control" maxlength="100" 
					pattern="[A-Za-z\s]+" 
					title="Please enter letters and spaces only">
				</div>
			</div>
			
			<h6 class="fw-bold mb-3 mt-2">Credit Details</h6>	
			<div class="row">
				<div class="col-md-12 mb-3">
					<label class="form-label d-block">Enable Credit?</label>
					<div class="form-check form-check-inline">
						<input class="form-check-input is_credit" type="radio" name="is_credit" id="credit_yes" value="1">
						<label class="form-check-label" for="credit_yes">Yes</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input is_credit" type="radio" name="is_credit" id="credit_no" value="0" checked>
						<label class="form-check-label" for="credit_no">No</label>
					</div>
				</div>
			</div>

			<div class="row" id="credit_fields" style="display: none;">
				<div class="col-md-6 mb-3">
					<label class="form-label">Current Credit Amount:</label>
					<input type="number" step="0.01" name="current_credit_amt" id="current_credit_amt" class="form-control" placeholder="0.00">
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label">Max Credit Limit:</label>
					<input type="number" step="0.01" name="max_credit_limit" id="max_credit_limit" class="form-control" placeholder="0.00">
				</div>
			</div>
			
			<button type="button" class="btn btn-light close-btn" data-bs-dismiss="modal">Cancel</button>
			<button type="submit" class="btn btn-primary" id="btn-sub"> <i class="ri-save-line me-1"></i> Save </button>
	</form>
</div>

<script>
	$(document).ready(function () {

		//Submit lead for save or Update
 		$('#leadForm').ajax_submit({
			url : '/Customer/store', 
			rest: false,
			callback : function(id){
				if(id!=''){
					$('#leadForm')[0].reset()
				}
			}
		});
		
		// credit info yes no button function 
		document.querySelectorAll('.is_credit').forEach((elem) => {
			elem.addEventListener("change", function(event) {
				const creditFields = document.getElementById("credit_fields");
				if (event.target.value === "1") {
					creditFields.style.display = "flex"; // Show fields
				} else {
					creditFields.style.display = "none"; // Hide fields
				}
			});
		});
	
		// adding value 
		$('.is_credit').on('change', function() {
			if ($(this).val() == '1') {
				$('#credit_fields').slideDown();
				$('#current_credit_amt').prop('required',true);
				$('#max_credit_limit').prop('required',true);
			} else {
				$('#credit_fields').slideUp();
				$('#current_credit_amt').prop('required',false);
				$('#max_credit_limit').prop('required',false);
			}
		});
		
		// check the create lint validation
		function checkCreditLimits() {
			const isCredit = $('input[name="is_credit"]:checked').val();
			const used = parseFloat($('#current_credit_amt').val()) || 0;
			const max = parseFloat($('#max_credit_limit').val()) || 0;
			const $submitBtn = $('#btn-sub');

			// Remove existing warning
			$('.credit-warning').remove();

			if (isCredit == "1" && used > max) {
				$submitBtn.prop('disabled', true);
				$('#credit_fields').after('<div class="col-12 credit-warning"><small class="text-danger">Error: Used amount cannot be greater than Max limit.</small></div>');
			} else {
				$submitBtn.prop('disabled', false);
			}
		}

		// Attach listeners to the inputs in the modal
		$(document).on('input', '#current_credit_amt, #max_credit_limit', checkCreditLimits);
		$(document).on('change', '.is_credit', checkCreditLimits);
		
	});
	
</script>