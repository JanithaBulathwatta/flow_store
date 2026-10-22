<style>
#invoice-modal .modal-box {
    max-width: 620px;
}
#invoice-modal .form-grid2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
#invoice-modal .form-grid3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}
#invoice-modal .divider {
    margin: 16px 0;
    height: 1px;
    background: var(--card-border);
}
#invoice-modal input[type="number"].fc {
    text-align: right;
    font-family: 'JetBrains Mono', monospace;
    font-size: 13px;
}
#invoice-modal .ig .fc {
    padding-left: 36px;
}
#invoice-modal .form-row {
    margin-bottom: 14px;
}
#invoice-modal.modal-bg {
    transition: opacity var(--tr);
}
#invoice-modal .fc.has-error {
    border-color: var(--danger) !important;
    background-color: #fffdfd;
}
#invoice-modal .err-msg {
    font-size: 11px;
    color: var(--danger);
    font-weight: 600;
    margin-top: 4px;
    display: none;
}
#invoice-modal input[type="datetime-local"].fc,
#invoice-modal input[type="date"].fc {
    color: var(--text-dark);
}
</style>

<div class="modal-bg" id="invoice-modal" data-project-id="" data-on-success="">
  <div class="modal-box">
    
    <div class="mb-head">
      <h4><i class="fa-solid fa-file-invoice-dollar" style="color:var(--primary);margin-right:8px;"></i>Record Sales Invoice</h4>
      <button type="button" class="mb-close" onclick="closeInvoiceModal()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    
    <div class="mb-body">
      <div id="inv-single-step-form">
        
        <div class="form-grid2">
          <div class="form-row">
            <label class="form-lbl">Invoice No <span>*</span></label>
            <input type="text" class="fc" id="inv-no" style="background-color: #f1f5f9; cursor: not-allowed;" readonly placeholder="Generating sequence...">
            <div class="err-msg" id="err-inv-no">Please enter a unique invoice number.</div>
          </div>
          <div class="form-row">
            <label class="form-lbl">Warehouse <span>*</span></label>
            <select class="fc" id="inv-warehouse-id">
              <option value="">— Select Warehouse —</option>
              <option value="1">Main Warehouse</option>
              <option value="2">Sub Warehouse</option>
            </select>
            <div class="err-msg" id="err-inv-warehouse">Please select a source warehouse.</div>
          </div>
        </div>

        <div class="form-grid2">
          <div class="form-row">
            <label class="form-lbl">Invoice Date <span>*</span></label>
            <input type="datetime-local" class="fc" id="inv-date">
            <div class="err-msg" id="err-inv-date">Please pick the invoice timestamp.</div>
          </div>
          <div class="form-row">
            <label class="form-lbl">Due Date</label>
            <input type="date" class="fc" id="inv-due-date">
            <div class="err-msg" id="err-inv-due-date">Due Date must be later than or equal to Invoice Date.</div>
          </div>
        </div>

        <div class="divider"></div>

        <div class="form-grid3">
          <div class="form-row">
            <label class="form-lbl">Subtotal <span>*</span></label>
            <div class="ig">
              <span class="ipfx">Rs.</span>
              <input type="number" class="fc" id="inv-subtotal" placeholder="0.00" step="0.01" oninput="calculateInvoiceGrandTotal()">
            </div>
            <div class="err-msg" id="err-inv-subtotal">Enter valid subtotal.</div>
          </div>
          <div class="form-row">
            <label class="form-lbl">Line Discount</label>
            <div class="ig">
              <span class="ipfx">Rs.</span>
              <input type="number" class="fc" id="inv-line-discount" value="0.00" step="0.01" oninput="calculateInvoiceGrandTotal()">
            </div>
          </div>
          <div class="form-row">
            <label class="form-lbl">Tax Total</label>
            <div class="ig">
              <span class="ipfx">Rs.</span>
              <input type="number" class="fc" id="inv-tax-total" value="0.00" step="0.01" oninput="calculateInvoiceGrandTotal()">
            </div>
          </div>
        </div>

        <div class="form-grid3">
          <div class="form-row">
            <label class="form-lbl">Bill Disc Type</label>
            <select class="fc" id="inv-bill-discount-type" onchange="calculateInvoiceGrandTotal()">
              <option value="AMOUNT">Fixed Amount</option>
              <option value="PERCENT">Percentage</option>
            </select>
          </div>
          <div class="form-row">
            <label class="form-lbl">Bill Disc Value</label>
            <input type="number" class="fc" id="inv-bill-discount-value" value="0.00" step="0.01" oninput="calculateInvoiceGrandTotal()">
          </div>
          <div class="form-row">
            <label class="form-lbl">Paid Amount</label>
            <div class="ig">
              <span class="ipfx">Rs.</span>
              <input type="number" class="fc" id="inv-paid-amount" value="0.00" step="0.01" oninput="calculateInvoiceGrandTotal()">
            </div>
          </div>
        </div>

        <div class="form-row">
          <label class="form-lbl">Remarks / Notes</label>
          <textarea class="fc" id="inv-remarks" rows="2" placeholder="Write any specific rules..."></textarea>
        </div>

        <div style="background:var(--primary-light); border-radius:var(--r-sm); padding:14px; margin-top:8px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
            <span style="font-size:12px; font-weight:600; color:var(--text-muted);">Invoice Code Context</span>
            <span style="font-size:12px; font-weight:700; font-family:'JetBrains Mono',monospace; color:var(--text-dark);" id="confirm-inv-no">—</span>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
            <span style="font-size:12px; font-weight:600; color:var(--text-muted);">Grand Total</span>
            <span style="font-size:15px; font-weight:800; color:var(--text-dark); font-family:'JetBrains Mono',monospace;" id="confirm-inv-grand">Rs. 0.00</span>
          </div>
          <div style="height:1px; background:var(--primary-mid); margin:8px 0;"></div>
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:13px; font-weight:800; color:var(--danger);">Balance Liability Outstanding</span>
            <span style="font-size:20px; font-weight:800; color:var(--danger); font-family:'JetBrains Mono',monospace;" id="confirm-inv-balance">Rs. 0.00</span>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-foot">
      <button type="button" class="btn btn-outline btn-sm" onclick="closeInvoiceModal()">Cancel</button>
      <button type="button" class="btn btn-success btn-sm" id="inv-btn-save" onclick="saveSalesInvoice()"><i class="fa-solid fa-check me-1"></i>Save Invoice</button>
    </div>

  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    /**
     * Auto-ID Controller Sequence
     */
    window.newinvid = function() {
        $.ajax({
            url: "/Sale_invoice/get_invoice_number",     
            type: "GET",              
            dataType: "json",          
            success: function(response) {
                $('#inv-no').val(response);
                $('#confirm-inv-no').text(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error fetching sequence identifier vector:", error);
            }
        });
    };

    /**
     * Reusable Initialization Hook
     */
    window.openInvoiceModal = function(projectId, successCallback) {
        if (!projectId) {
            console.error("Context Error: Project missing.");
            return;
        }

        var $modal = $('#invoice-modal');
        $modal.data('project-id', projectId);
        $modal.data('on-success', typeof successCallback === 'function' ? successCallback : null);

        // Reset all text and configuration vectors cleanly
        $modal.find('input, select, textarea').val('');
        $('#inv-line-discount, #inv-tax-total, #inv-bill-discount-value, #inv-paid-amount').val('0.00');
        $('#inv-bill-discount-type').val('AMOUNT');

        // Execute automatic ID generation pipe
        window.newinvid();

        // Calculate and balance timezone-accurate timestamps
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        var isoString = now.toISOString();
        
        $('#inv-date').val(isoString.slice(0, 16));
        $('#inv-due-date').val(isoString.slice(0, 10)).attr('min', isoString.slice(0, 10));
        
        $('.fc').removeClass('has-error');
        $('.err-msg').hide();

        // Fire display updates to output feedback figures
        calculateInvoiceGrandTotal();

        $modal.addClass('show');
    };

    window.closeInvoiceModal = function() {
        $('#invoice-modal').removeClass('show');
    };

    /**
     * Real-Time Date Constraint Listener Rules
     */
    $(document).on('change', '#inv-date, #inv-due-date', function() {
        var invDateVal = $('#inv-date').val();
        var dueDateVal = $('#inv-due-date').val();

        if (invDateVal && dueDateVal) {
            var invDate = new Date(invDateVal.slice(0, 10));
            var dueDate = new Date(dueDateVal);

            if (dueDate < invDate) {
                $('#inv-due-date').addClass('has-error');
                $('#err-inv-due-date').show();
                $('#inv-btn-save').prop('disabled', true);
            } else {
                $('#inv-due-date').removeClass('has-error');
                $('#err-inv-due-date').hide();
                $('#inv-btn-save').prop('disabled', false);
            }
        }
    });

    /**
     * Live Mathematical Grand Total & Outstanding Processing Core
     */
    window.calculateInvoiceGrandTotal = function() {
        var subtotal = parseFloat($('#inv-subtotal').val()) || 0;
        var lineDiscount = parseFloat($('#inv-line-discount').val()) || 0;
        var taxTotal = parseFloat($('#inv-tax-total').val()) || 0;
        var billDiscType = $('#inv-bill-discount-type').val();
        var billDiscVal = parseFloat($('#inv-bill-discount-value').val()) || 0;
        var paidAmount = parseFloat($('#inv-paid-amount').val()) || 0;

        var intermediateBase = subtotal - lineDiscount;
        var billDiscountCalculation = (billDiscType === 'PERCENT') ? intermediateBase * (billDiscVal / 100) : billDiscVal;

        var grandTotal = (intermediateBase - billDiscountCalculation) + taxTotal;
        if (grandTotal < 0) grandTotal = 0;
        var balanceAmount = grandTotal - paidAmount;

        $('#confirm-inv-no').text($('#inv-no').val() || '—');
        $('#confirm-inv-grand').text('Rs. ' + grandTotal.toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2}));
        $('#confirm-inv-balance').text('Rs. ' + balanceAmount.toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2}));
        
        $('#invoice-modal').data('computed-grand', grandTotal).data('computed-balance', balanceAmount);
    };

    /**
     * Submit Transaction Event Processing
     */
    window.saveSalesInvoice = function() {
        var valid = true;

        // Perform foundational system balance checks
        if (!(parseFloat($('#inv-subtotal').val()) > 0)) {
            $('#inv-subtotal').addClass('has-error');
            $('#err-inv-subtotal').show();
            valid = false;
        } else {
            $('#inv-subtotal').removeClass('has-error');
            $('#err-inv-subtotal').hide();
        }

        if (!$('#inv-warehouse-id').val()) {
            $('#inv-warehouse-id').addClass('has-error');
            $('#err-inv-warehouse').show();
            valid = false;
        } else {
            $('#inv-warehouse-id').removeClass('has-error');
            $('#err-inv-warehouse').hide();
        }

        if (!$('#inv-date').val()) {
            $('#inv-date').addClass('has-error');
            $('#err-inv-date').show();
            valid = false;
        } else {
            $('#inv-date').removeClass('has-error');
            $('#err-inv-date').hide();
        }

        if (!valid) return;

        var $modal = $('#invoice-modal');

        var payload = {
            project_id: $modal.data('project-id'),
            invoice_no: $('#inv-no').val().trim(),
            warehouse_id: $('#inv-warehouse-id').val(),
            invoice_date: $('#inv-date').val(),
            due_date: $('#inv-due-date').val() ? $('#inv-due-date').val() : null,
            
            // Defaulted backend properties mapping because manual items inputs were removed
            total_items: 0,
            total_qty: 0,
            total_free_qty: 0,
            
            subtotal: parseFloat($('#inv-subtotal').val()) || 0,
            line_discount_total: parseFloat($('#inv-line-discount').val()) || 0,
            bill_discount_value: parseFloat($('#inv-bill-discount-value').val()) || 0,
            bill_discount_type: $('#inv-bill-discount-type').val(),
            tax_total: parseFloat($('#inv-tax-total').val()) || 0,
            grand_total: $modal.data('computed-grand') || 0,
            paid_amount: parseFloat($('#inv-paid-amount').val()) || 0,
            balance_amount: $modal.data('computed-balance') || 0,
            remarks: $('#inv-remarks').val().trim()
        };

        $.ajax({
            url: '<?php echo site_url("Projects/commit_sales_invoice_ajax"); ?>',
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    closeInvoiceModal();
                    var callback = $modal.data('on-success');
                    if (typeof callback === 'function') {
                        callback();
                    }
                    alert("Sales Invoice successfully recorded.");
                } else {
                    alert("Error: " + res.message);
                }
            },
            error: function() {
                alert("Critical system processing failure.");
            }
        });
    };
});
</script>