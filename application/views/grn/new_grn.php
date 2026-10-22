<div class="main-content app-content">
    <div class="container-fluid">
		<form id="grn-frm">
			<div class="row">
		
				<div class="col-md-4 mt-3">
					<div class="card custom-card">
						<div class="card-header justify-content-between">
							<div class="fw-medium fs-16">Grn Details</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xl-4 mt-1">
									<label class="form-label">Store</label>
									<select id="store" name="fk_store_id" class="form-control form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example"  required>
										<option value=""> Select Store </option>
										<?php foreach ($store as $store): ?>
											<option value="<?= $store->store_id; ?>"><?= html_escape($store->store_name); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-xl-4 mt-1">
									<label class="form-label">Grn Date *</label>
									<input type="date"  name="grn_date" id="gdate" value="<?= date('Y-m-d'); ?>" class="form-control form-control-sm" required>
								</div>
								<div class="col-xl-4 mt-1">
									<label class="form-label">Ref No *</label>
									<input type="text"  name="ref_no" id="frfno" class="form-control form-control-sm" required>
								</div>
								<div class="col-xl-6 mt-1">
									<label class="form-label">Supplier</label>
									<select id="sup" name="fk_sup_id" class="form-control form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example" required>
										<option value=""> Select Supplier </option>
										<?php foreach ($sup as $supplier): ?>
											<option value="<?= $supplier->id; ?>"><?= html_escape($supplier->name); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-xl-6 mt-1">
									<label class="form-label">Recived</label>
									<select id="user" name="fk_user_id" class="form-control form-select form-select-sm js-example-basic-single" aria-label=".form-select-sm example" required>
										<option value=""> Select Recived </option>
										<?php foreach ($staff as $staff): ?>
											<option value="<?= $staff->user_id; ?>"><?= html_escape($staff->full_name); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-8 mt-3">
					<div class="card custom-card">
						<div class="card-header justify-content-between">
							<div class="fw-medium">Items Details</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xl-3 mt-1 mb-25">
									<label class="form-label">Item</label>
									<select class="form-select js-example-basic-single form-select-sm" id="pro" aria-label=".form-select-sm example">
										<option value=""> Select Item </option>
										<?php foreach ($products as $product): ?>
											<option value="<?= $product->id; ?>"><?= html_escape($product->name); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-xl-2 mt-1 mb-25">
									<label class="form-label">Purchase Price</label>
									<input type="text" id="pur_pri" class="form-control form-control-sm">
								</div>
								<div class="col-xl-2 mt-1 mb-25">
									<label class="form-label">Selling Price</label>
									<input type="text" id="sel_pri" class="form-control form-control-sm">
								</div>
								<div class="col-xl-1 mt-1 mb-25">
									<label class="form-label">Qty</label>
									<input type="text"  id="qty" class="form-control form-control-sm">
								</div>
								<div class="col-xl-2 mt-1 mb-25">
									<label class="form-label">Line Total</label>
									<input type="text"  id="line_tot" class="form-control form-control-sm">
								</div>
								<div class="col-xl-2 mt-1 mb-25">
									<button type="button" class="btn btn-success mt-1 w-100" id="add_grn_itm"><i class="fa-solid fa-circle-plus"></i> Add</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 mt-3">
					<table class="table text-nowrap table-sm" id="itemTable">
						<thead>
							<tr>
								<th scope="col">Item</th>
								<th scope="col">Purchase Price </th>
								<th scope="col">Selling Price</th>
								<th scope="col">QTY</th>
								<th scope="col">Line Total</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr id="def-td">
								<td></td>
								<td></td>
								<td><span class="text-center">No Items Added</span></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="col-md-4 mt-3">
					<div class="card custom-card">
						<div class="card-header justify-content-between">
							<div class="fw-medium fs-16">Payment Methods</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xl-4 mb-1">
									<label class="form-label">Cash Amount</label>
									<input type="text"  name="cash_amt" id="cash" class="form-control form-control-sm">
								</div>
								<div class="col-xl-4 mb-1">
									<label class="form-label">Card Amount</label>
									<input type="text"  name="card_amt" id="card" class="form-control form-control-sm">
								</div>
								<div class="col-xl-4 mb-1">
									<label class="form-label">Cheque Amount </label>
									<input type="text"  name="chq_amt" id="cheque" class="form-control form-control-sm">
								</div>
								
								<!--For Card Payments -->
								<div class="none" id="crd_pyment_sec">
									<div class="col-xl-6 mb-1">
										<label class="form-label">Expiration Date </label>
										<input type="Date"  name="crd_exp_date" class="form-control form-control-sm">
									</div>
									
									<div class="col-xl-6 mb-1">
										<label class="form-label">Card Number </label>
										<input type="number"  name="crd_numb" class="form-control form-control-sm">
									</div>
								</div>
								<!--End Card Payments-->
								
								<!--For Cheque Payments -->
								<div class="none" id="chq_det_sec">
									<div class="col-xl-6 mb-1">
										<label class="form-label">Cheque Number </label>
										<input type="text"  name="chq_no" id="chq_no" class="form-control form-control-sm">
									</div>
									
									<div class="col-xl-6 mb-1">
										<label class="form-label">Cheque Date </label>
										<input type="date"  name="chq_date" id="chq_date" class="form-control form-control-sm">
									</div>
								</div> 
								<!--End Cheque Payments-->
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-8 mt-3">
					<div class="card custom-card">
						<div class="card-body">
						
							<div class="row">
								<div class="col-xl-2 mt-1 mb-3">
									<label class="form-label">VAT(%)</label>
									<select id="vat" name="vat_rate" class="form-select form-select-sm" required>
										<option value="0">0%</option>
										<?php foreach ($vat as $vat): ?>
											<option value="<?= $vat->vat_rate; ?>"><?= html_escape($vat->vat_rate); ?>%</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-xl-2 mt-1 mb-3">
									<label class="form-label">NBT(%)</label>
									<select id="nbt" name="nbt_rate" class="form-select form-select-sm" required>
										<option value="0">0%</option>
										<?php foreach ($nbt as $nbt): ?>
											<option value="<?= $nbt->nbt_rate; ?>"><?= html_escape($nbt->nbt_rate); ?>%</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-xl-2 mt-1">
									<label class="form-label">Discount</label>
									<input type="Number"  name="discount" id="discount" value="0" class="form-control form-control-sm">
								</div>
								<div class="col-xl-2 mt-1">
									<label class="form-label">Total</label>
									<input type="readonly"  name="grn_amount" id="tot" value="0" class="form-control form-control-sm">
								</div>
								<div class="col-xl-2 mt-1">
									<label class="form-label">Grand Total</label>
									<input type="Number"  name="grnd_tot" id="grand_tot" value="0" class="form-control form-control-sm">
								</div>
								<div class="col-xl-2 mt-1">
									<label class="form-label">Due: </label>
									<input type="readonly"  name="due_amt" value="0.00" id="due" class="form-control form-control-sm" required>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="button-container mb-3">	
				<button type="reset" class="btn btn-danger mt-1">Cancel</button>
				<button type="submit" class="btn btn-primary mt-1 " id="btn-sub">Add GRN</button>		
			</div>
			
		</form>
	</div>
</div>


<script>
	$(document).ready(function(){

		/*Append function*/
		$("#add_grn_itm").click(function(){
			
			$('#def-td').hide();
			
			var itemId   = $("#pro").val();
			var itemName = $("#pro option:selected").text();
			var purPrice = $("#pur_pri").val();
			var selPrice = $("#sel_pri").val();
			var qty      = $("#qty").val();
			var lineTot  = $("#line_tot").val();

			if(itemId == ""){
				//alert("");
				toastr.warning("Please select an item");
				$('#def-td').show();
				return;
				
			}

			// check if item already exists
			var exists = false;

			$("#itemTable tbody tr").each(function(){
				if($(this).data("id") == itemId){
					exists = true;
				}
			});

			if(exists){
				//alert("Item already added!");
				toastr.warning("Item already added!");
				return;
			}

			var row = `<tr data-id="${itemId}">
							<td>${itemName}<input type="hidden" name="item_id[]" value="${itemId}"></td>
							<td>${purPrice}<input type="hidden" name="purchase_price[]" value="${purPrice}"></td>
							<td>${selPrice}<input type="hidden" name="selling_price[]" value="${selPrice}"></td>
							<td>${qty}<input type="hidden" name="qty[]" value="${qty}"></td>
							<td class="line-total">${lineTot}<input type="hidden" name="line_total[]" value="${lineTot}"></td>
							<td><div class="hstack gap-2 fs-15"><a class="btn btn-icon btn-sm btn-light btn-remove"><i class="fa fa-trash danger"></i></a></div></td>
						</tr>`;
			
			$("#itemTable tbody").append(row);

			// clear fields
			$("#pro").val("").trigger("change");
			$("#pur_pri").val("");
			$("#sel_pri").val("");
			$("#qty").val("");
			$("#line_tot").val("");
			
			updateTotal(); // update total
			
		});
		/*End of the append function*/

		// remove row
		$(document).on("click",".btn-remove",function(){
			$(this).closest("tr").remove();
			updateTotal();
		});
		
		//update total in payment summary section
		function updateTotal(){
			var total = 0;
			
			$("#itemTable tbody .line-total").each(function(){
				total += parseFloat($(this).text()) || 0;
			});
			$("#tot").val(total.toFixed(2));
			$("#grand_tot").val(total.toFixed(2));
		}

		//On change event for the load product price 
		$("#pro").on("change", function(){
			var product_id = $(this).val(); // get selected product id
			
			if(product_id != ""){
				$.ajax({
					url: "/Purchase/get_product_price", // your controller URL
					type: "POST",
					data: {product_id: product_id},
					dataType: "json",
					success: function(response){
						// set values to inputs
						$("#sel_pri").val(response.selling_price);
					}
				});
			}
		});
		//End of the On change event for the load product price
		
		/*This is for calculate line total based on selling price*QTY */
		$("#pur_pri, #qty").on("change keyup", function(){
			calculateTotal();
		});
		function calculateTotal(){
			var price = parseFloat($("#pur_pri").val()) || 0;
			var qty   = parseFloat($("#qty").val()) || 0;
			var total = price * qty;

			$("#line_tot").val(total.toFixed(2));
		}
		/*end of the line total calculation*/
		
		
		/*summary calculation section*/
		function calculateGrandTotal(){

			var total = parseFloat($("#tot").val()) || 0;
			var discount = parseFloat($("#discount").val()) || 0;
			var vatRate = parseFloat($("#vat").val()) || 0;
			var nbtRate = parseFloat($("#nbt").val()) || 0;

			// if all values are zero or not selected
			if(vatRate === 0 && nbtRate === 0 && discount === 0){
				$("#grand_tot").val(total.toFixed(2));
				calculateDue();
				return;
			}

			var vat = total * (vatRate / 100);
			var nbt = total * (nbtRate / 100);

			var grandTotal = total - discount + vat + nbt;

			$("#grand_tot").val(grandTotal.toFixed(2));

			calculateDue();
		}
		
		/*function calculateDue(){
			var grandTotal = parseFloat($("#grand_tot").val()) || 0;

			var cash = parseFloat($("#cash").val()) || 0;
			var card = parseFloat($("#card").val()) || 0;
			var cheque = parseFloat($("#cheque").val()) || 0;

			var paid = cash + card + cheque;

			var due = grandTotal - paid;

			$("#due").val(due.toFixed(2));
		}*/
		function calculateDue(){

			var grandTotal = parseFloat($("#grand_tot").val()) || 0;

			var cash = parseFloat($("#cash").val()) || 0;
			var card = parseFloat($("#card").val()) || 0;
			var cheque = parseFloat($("#cheque").val()) || 0;

			var paid = cash + card + cheque;

			var due = grandTotal - paid;

			// show due value
			$("#due").val(due.toFixed(2));

			// if due is negative disable submit
			if(due < 0){
				toastr.warning("Payment exceeds Grand Total");
				$("#btn-sub").prop("disabled", true);
			}else{
				$("#btn-sub").prop("disabled", false);
			}
		}
		
		$("#discount, #vat, #nbt").on("change keyup", function(){
			calculateGrandTotal();
		});

		$("#cash, #card, #cheque").on("keyup change", function(){
			calculateDue();
		});
		/*payment summary calculations End*/
		
		/*GRN Save*/
			$('#grn-frm').ajax_submit({
				url :'/Purchase/save_grn', 
				rest: false, 
				
				callback : function(id){
					$('#grn-frm')[0].reset();
					
					
					// Remove all appended rows
					$("#itemTable tbody").empty();

					// Add default row again
					$("#itemTable tbody").html(`
						<tr id="def-td">
							<td></td>
							<td></td>
							<td><span class="text-center">No Items Added</span></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					`);

					// Reset totals
					$("#tot").val("0");
					$("#grand_tot").val("0");
					$("#due").val("0"); 

					// Reset select2 dropdowns
					$(".js-example-basic-single").val(null).trigger("change");
			
				}
			});
		/*GRN Save*/
		
		
		// CARD SECTION SHOW + REQUIRED
		$("#card").on("focus", function(){
			$("#crd_pyment_sec").removeClass("none");

			$("input[name='crd_exp_date']").prop("required", true);
			$("input[name='crd_numb']").prop("required", true);
		});

		// CARD DATE VALIDATION
		$("input[name='crd_exp_date']").on("change", function(){

			var selectedDate = new Date($(this).val());
			var today = new Date();
			today.setHours(0,0,0,0);

			if(selectedDate <= today){
				toastr.warning("Card expiration date must be greater than today's date");
				$(this).val("");
			}
		});


		// CHEQUE SECTION SHOW + REQUIRED
		$("#cheque").on("focus", function(){
			$("#chq_det_sec").removeClass("none");

			$("#chq_no").prop("required", true);
			$("#chq_date").prop("required", true);
		});

		// CHEQUE DATE VALIDATION
		$("#chq_date").on("change", function(){

			var selectedDate = new Date($(this).val());
			var today = new Date();
			today.setHours(0,0,0,0);

			if(selectedDate <= today){
				toastr.warning("Cheque date must be greater than today's date");
				$(this).val("");
			}
		});
		
	});
</script>