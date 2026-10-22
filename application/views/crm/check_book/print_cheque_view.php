<style>
    /* Ensure the screen matches the printer */
  @media print {
        
        @page { 
            margin: 0; 
        }

        .no-print { display: none !important; }
        
        .cheque-container { 
            border: none !important; 
            margin: 0 !important; 
            box-shadow: none !important;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        body { margin: 0; padding: 0; }
    }
    
    .cheque-container {
        position: relative;
        overflow: hidden;
        border: 1px dashed #ccc; /* Hide this in @media print */
        background-color: white;
        margin: 20px auto;
    }

    .field {
        position: absolute;
        font-family: 'Courier New', Courier, monospace; /* Typical cheque font */
        font-size: 14px;
        white-space: nowrap;
    }
	
	#pDate {
		display: flex;
		width: 48mm; 
		font-family: 'Courier New', Courier, monospace;
		font-size: 20px; 
		font-weight: bold;
	}

	#pDate span {
		display: inline-block;
		width: 6mm;      
		text-align: center;
	}

	/* Hide the '20' */
	.skip-digit {
		visibility: hidden; 
	}

	/* Ensure the field ID is assigned to the div */
	#pAmtWord {
		width: 110mm;
		white-space: normal;
		line-height: 1.2;
		display: block;
	}
</style>

<div class="no-print" style="background:#f4f4f4; padding:20px; text-align:center;">
    <label>Select Template:</label>
    <select id="templateSelector" onchange="applyTemplate(this.value)">
        <option value="">-- Choose Bank Template --</option>
        <?php foreach($templates as $t): ?>
            <option value='<?= json_encode($t); ?>'><?= $t->template_name ?></option>
        <?php endforeach; ?>
    </select>
    <button onclick="window.print()">Print Cheque</button>
</div>

<div id="printArea" class="cheque-container">

	<div id="pDate" class="field">
		<?php 
			
			$date_str = date("dmY", strtotime($cheque->cheque_date)); 
			$digits = str_split($date_str);
			
			foreach($digits as $index => $d) {
				
				$class = ($index == 4 || $index == 5) ? 'skip-digit' : 'print-digit';
				echo "<span class='$class'>$d</span>";
			}
		?>
	</div>
    <div id="pPayee" class="field"><?= $cheque->payee_name ?></div>
    <div id="pAmtWord" class="field"><?= convert_number_to_words($cheque->amount) ?></div>
    <div id="pAmtNum" class="field">**<?= number_format($cheque->amount, 2) ?>/=</div>
</div>

<script>
function applyTemplate(jsonStr) {
    if(!jsonStr) return;
    const t = JSON.parse(jsonStr);
    
    // Set container size
    const area = document.getElementById('printArea');
    area.style.width = t.width_mm + 'mm';
    area.style.height = t.height_mm + 'mm';
	


    // Position fields (X = left, Y = top)
    setPos('pDate', t.date_x, t.date_y);
    setPos('pPayee', t.payee_x, t.payee_y);
    setPos('pAmtWord', t.amt_word_x, t.amt_word_y);
    setPos('pAmtNum', t.amt_num_x, t.amt_num_y);
}

function setPos(id, x, y) {
    const el = document.getElementById(id);
    el.style.left = x + 'mm';
    el.style.top = y + 'mm';
}
</script>