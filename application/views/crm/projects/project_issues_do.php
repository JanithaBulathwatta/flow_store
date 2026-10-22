<style>
    /* ── Variables ── */
    :root {
      --ink: #111318;
      --mid: #6b7280;
      --rule: #d1d5db;
      --accent: #1a56db;
      --bg: #f9fafb;
      --white: #ffffff;
      --mono: 'IBM Plex Mono', monospace;
      --sans: 'IBM Plex Sans', sans-serif;
    }

    /* ── Reset ── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ── Screen wrapper ── */
    body {
      font-family: var(--sans);
      background: var(--bg);
      color: var(--ink);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem 1rem 4rem;
    }

    /* ── Toolbar (hidden on print) ── */
    .toolbar {
      display: flex;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
      width: 100%;
      max-width: 780px;
    }
    .btn {
      font-family: var(--mono);
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      padding: 0.55rem 1.2rem;
      border: 1.5px solid var(--ink);
      background: var(--white);
      color: var(--ink);
      cursor: pointer;
      transition: background 0.15s, color 0.15s;
    }
    .btn:hover { background: var(--ink); color: var(--white); }
    .btn.primary { background: var(--accent); border-color: var(--accent); color: var(--white); }
    .btn.primary:hover { background: #1240a8; border-color: #1240a8; }

    /* ── Paper ── */
    .paper {
      background: var(--white);
      width: 100%;
      max-width: 780px;
      padding: 2.5rem 2.75rem;
      border: 1px solid var(--rule);
      box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }

    /* ── Header band ── */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 2.5px solid var(--ink);
      padding-bottom: 1.25rem;
      margin-bottom: 1.75rem;
      gap: 1rem;
    }
    .brand-name {
      font-size: 1.6rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      line-height: 1.1;
	  
    }
    .brand-sub {
      font-family: var(--mono);
      font-size: 0.68rem;
      color: var(--mid);
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-top: 0.25rem;
    }
    .doc-title {
      text-align: right;
    }
    .doc-title h1 {
      font-family: var(--mono);
      font-size: 1.1rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--accent);
    }
    .doc-title .dn-number {
      font-family: var(--mono);
      font-size: 0.85rem;
      color: var(--ink);
      margin-top: 0.3rem;
    }

    /* ── Meta grid ── */
    .meta-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 1.5rem;
      margin-bottom: 1.75rem;
    }
    .meta-block label {
      font-family: var(--mono);
      font-size: 0.62rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--mid);
      display: block;
      margin-bottom: 0.3rem;
    }
    .meta-block .val {
      font-size: 0.88rem;
      font-weight: 600;
      line-height: 1.45;
    }
    .meta-block .val.light { font-weight: 400; }
    [contenteditable]:focus { outline: 1.5px dashed var(--accent); outline-offset: 2px; }

    /* ── Address row ── */
    .address-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
      padding: 1.2rem 1.4rem;
      background: var(--bg);
      border: 1px solid var(--rule);
      margin-bottom: 1.75rem;
    }
    .address-block label {
      font-family: var(--mono);
      font-size: 0.62rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--mid);
      display: block;
      margin-bottom: 0.4rem;
    }
    .address-block .addr {
      font-size: 0.85rem;
      line-height: 1.6;
    }

    /* ── Items table ── */
    .items-wrap { margin-bottom: 1.75rem; }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.85rem;
    }
    thead tr {
      background: var(--ink);
      color: var(--white);
    }
    thead th {
      font-family: var(--mono);
      font-size: 0.65rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      font-weight: 600;
      padding: 0.6rem 0.8rem;
      text-align: left;
    }
    thead th.r { text-align: right; }
    tbody tr { border-bottom: 1px solid var(--rule); }
    tbody tr:last-child { border-bottom: 2px solid var(--ink); }
    tbody tr:nth-child(even) td { background: #f5f6f8; }
    td {
      padding: 0.6rem 0.8rem;
      vertical-align: middle;
    }
    td.r { text-align: right; font-family: var(--mono); font-size: 0.82rem; }
    td.mono { font-family: var(--mono); font-size: 0.82rem; }
    .add-row-btn {
      font-family: var(--mono);
      font-size: 0.72rem;
      color: var(--accent);
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.5rem 0.8rem;
      letter-spacing: 0.06em;
      text-transform: uppercase;
    }
    .add-row-btn:hover { text-decoration: underline; }
    .del-btn {
      background: none;
      border: none;
      color: #e53e3e;
      cursor: pointer;
      font-size: 1rem;
      line-height: 1;
      padding: 0 0.2rem;
    }

    /* ── Totals ── */
    .totals {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 2rem;
    }
    .totals-box {
      width: 260px;
      border: 1.5px solid var(--ink);
    }
    .totals-row {
      display: flex;
      justify-content: space-between;
      padding: 0.45rem 0.9rem;
      font-size: 0.85rem;
      border-bottom: 1px solid var(--rule);
    }
    .totals-row:last-child {
      border-bottom: none;
      font-weight: 700;
      background: var(--ink);
      color: var(--white);
      font-size: 0.9rem;
    }
    .totals-row span:last-child { font-family: var(--mono); }

    /* ── Notes ── */
    .notes-section {
      margin-bottom: 2rem;
    }
    .notes-section label {
      font-family: var(--mono);
      font-size: 0.65rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--mid);
      display: block;
      margin-bottom: 0.4rem;
    }
    .notes-section .notes-box {
      border: 1px solid var(--rule);
      padding: 0.7rem 0.9rem;
      font-size: 0.83rem;
      line-height: 1.6;
      min-height: 2.8rem;
      color: var(--ink);
    }

    /* ── Signatures ── */
    .sig-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      margin-bottom: 1.5rem;
    }
    .sig-block label {
      font-family: var(--mono);
      font-size: 0.62rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--mid);
      display: block;
      margin-bottom: 2.5rem;
    }
    .sig-line {
      border-bottom: 1.5px solid var(--ink);
      padding-bottom: 0.25rem;
      font-size: 0.78rem;
      font-family: var(--mono);
      color: var(--mid);
    }

    /* ── Footer ── */
    .footer {
      border-top: 1px solid var(--rule);
      padding-top: 0.75rem;
      font-family: var(--mono);
      font-size: 0.62rem;
      color: var(--mid);
      letter-spacing: 0.06em;
      text-align: center;
      text-transform: uppercase;
    }

    /* ── Print styles ── */
    @media print {
      body { background: white; padding: 0; }
      .toolbar { display: none !important; }
      .paper {
        box-shadow: none;
        border: none;
        padding: 1.5cm 1.8cm;
        max-width: 100%;
      }
      .add-row-btn, .del-btn { display: none !important; }
      [contenteditable] { outline: none !important; }
      @page { margin: 0.8cm; size: A4; }
    }
  </style>
  
  <!-- Toolbar -->
  <div class="toolbar no-print">
    <button class="btn primary" onclick="window.print()">⎙ Print</button>
  </div>

  <!-- Paper -->
  <div class="paper" id="dn">

    <!-- Header -->
    <div class="header">
      <div>
		<!-- LOGO -->
		<?php 
			$com_logo = $this->session->userdata('company_logo');
			$com_name      = $this->session->userdata('company_name');
			$company_addr  = $this->session->userdata('company_addr');
			$sys_info = $this->session->userdata('sys_info');
		?>
		<img src="/uploads/<?php echo $com_logo; ?>" alt="logo" style="width:140px; height:60px; object-fit:cover; border-radius:6px;margin-left: -18px;">
        <div class="brand-name" contenteditable="false">
		</div>
        <div class="brand-sub" contenteditable="false"><?= $company_addr?> · <?= htmlspecialchars($sys_info->company_contact_1 ?? '') ?> <?= !empty($sys_info->company_contact_2) ? ' / ' . htmlspecialchars($sys_info->company_contact_2) : '' ?></div>
      </div>
      <div class="doc-title">
        <h1>Delivery Note</h1>
        <div class="dn-number" id="dnNum">DN-<?= $do['activity']->st_activity_id ?></div>
      </div>
    </div>

    <!-- Meta -->
    <div class="meta-grid">
      <div class="meta-block">
        <label>Date Issued</label>
        <div class="val" contenteditable="false" id="issueDate"><?= date('Y-m-d', strtotime($do['activity']->st_act_date)); ?></div>
      </div>
      <div class="meta-block">
        <label>Delivery Date</label>
        <div class="val" contenteditable="false" id="deliveryDate"><?= date('Y-m-d', strtotime($do['activity']->delivery_date)); ?></div>
      </div>
      <div class="meta-block">
        <label>Order / Invoice Ref.</label>
        <div class="val mono" contenteditable="false" id="invId">DN-<?= $do['activity']->st_activity_id ?></div>
      </div>
      <div class="meta-block">
        <label>Sales Rep.</label>
        <div class="val light" contenteditable="false"><?= $do['activity']->full_name ?></div>
      </div>
      <div class="meta-block">
        <label>Payment Terms</label>
        <div class="val light" contenteditable="false">Next 30 Days</div>
      </div>
      <div class="meta-block">
        <label>Delivery Method</label>
        <div class="val light" contenteditable="false">Own Vehicle</div>
      </div>
    </div>

    <!-- Addresses -->
    <div class="address-row">
      <div class="address-block">
        <label>Bill To</label>
        <div class="addr" contenteditable="true">
          <?= $do['activity']->cus_name ?><br>
          <?= $do['activity']->cus_address ?><br>
          <!--City, Province 00000<br>-->
          Tel: <?= $do['activity']->cus_phone ?><!--+94 __________-->
        </div>
      </div>
      <div class="address-block">
        <label>Ship To / Deliver To</label>
        <div class="addr" contenteditable="true">
          <?= $do['activity']->cus_name ?><br>
          <?= $do['activity']->cus_address ?><br>
          Tel:  <?= $do['activity']->cus_phone ?>		
        </div>
      </div>
    </div>

    <!-- Items Table -->
    <div class="items-wrap">
      <table id="itemTable">
        <thead>
          <tr>
            <th style="width:42px">#</th>
            <th>Description</th>
            <th class="r" style="width:80px">Qty</th>
            <!--<th class="r" style="width:90px">Unit Price</th>
            <th class="r" style="width:95px">Amount</th>-->

          </tr>
        </thead>
        <tbody id="itemBody">
          <!-- rows injected by JS -->
		  
			 <?php if (!empty($do['items'])): ?>

				<?php foreach ($do['items'] as $i => $item): ?>

					<tr>
						<td class="mono" style="color:var(--mid)">
							<?= str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?>
						</td>

						<td
							contenteditable="false"
							data-id="<?= htmlspecialchars($item->id ?? $item->product_id); ?>"
							data-field="desc"
							style="outline: none;"
						>
							<?= htmlspecialchars($item->name ?? '-'); ?>

							<?php if (!empty($item->product_code)): ?>
								[<?= htmlspecialchars($item->product_code); ?>]
							<?php endif; ?>
						</td>

						<td
							class="r"
							contenteditable="false"
							data-id="<?= htmlspecialchars($item->id ?? $item->product_id); ?>"
							data-field="qty"
							style="outline: none;"
						>
							<?= number_format((float)($item->qty ?? 0), 2); ?>
						</td>
					</tr>

				<?php endforeach; ?>

			<?php else: ?>

				<tr>
					<td colspan="3" style="text-align:center; color:var(--mid);">
						No items found
					</td>
				</tr>

			<?php endif; ?>
			
        </tbody>
      </table>

    </div>

    <!-- Totals -->
    <div class="totals" style="display:none;">
      <div class="totals-box">
        <div class="totals-row">
          <span>Subtotal</span>
          <span id="subtotal">0.00</span>
        </div>
        <div class="totals-row">
          <span>Discount (<span contenteditable="false" id="discPct">0</span>%)</span>
          <span id="discAmt">0.00</span>
        </div>
        <div class="totals-row">
          <span>Tax (<span contenteditable="false" id="taxPct">0</span>%)</span>
          <span id="taxAmt">0.00</span>
        </div>
        <div class="totals-row">
          <span>Total Due</span>
          <span id="total">0.00</span>
        </div>
      </div>
    </div>

    <!-- Notes -->
    <div class="notes-section">
      <label>Notes / Special Instructions</label>
      <div class="notes-box" contenteditable="false" id="note"><?= $do['activity']->note?><!--Please inspect goods upon receipt. Report any discrepancies within 48 hours.--></div>
    </div>

    <!-- Signatures -->
    <div class="sig-row">
      <div class="sig-block">
        <label>Dispatched By (Authorised Signatory)</label>
        <div class="sig-line">Name &amp; Signature / Date</div>
      </div>
      <div class="sig-block">
        <label>Received By (Customer Signature)</label>
        <div class="sig-line">Name &amp; Signature / Date</div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer" contenteditable="false">
      Thank you for your business · goods remain property of company until full payment received
    </div>

  </div><!-- /paper -->

 <!--<script>
    /* ── Seed dates ── */
    const today = new Date();
    const fmt = d => d.toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' });
    const futureDate = new Date(today); futureDate.setDate(today.getDate() + 3);
    
    // Initial static dates (will be overwritten if DB has dates)
    document.getElementById('issueDate').textContent = fmt(today);
    document.getElementById('deliveryDate').textContent = fmt(futureDate);

    /* ── Default rows (Fallback if no data found) ── */
    const defaultRows = [
        { desc: 'Product / Item Description', qty: 1, price: 0.00 },
        { desc: '', qty: '', price: '' },
        { desc: '', qty: '', price: '' },
    ];

    let rows = [];

    function createRow(data = {}) {
        return {
            id: Date.now() + Math.random(),
            desc: data.desc ?? '',
            qty: data.qty ?? '',
            price: data.price ?? '',
        };
    }

    function addRow(data) {
        rows.push(createRow(data));
        renderTable();
    }

    function deleteRow(id) {
        rows = rows.filter(r => r.id !== id);
        renderTable();
    }

    function renderTable() {
        const tbody = document.getElementById('itemBody');
        tbody.innerHTML = '';
        rows.forEach((row, i) => {
            const qty = parseFloat(row.qty) || 0;
            const price = parseFloat(row.price) || 0;
            const amount = qty * price;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="mono" style="color:var(--mid)">${String(i+1).padStart(2,'0')}</td>
                <td contenteditable="false" data-id="${row.id}" data-field="desc">${row.desc}</td>
                <td class="r" contenteditable="false" data-id="${row.id}" data-field="qty">${row.qty}</td>
                <!--<td class="r" contenteditable="false" data-id="${row.id}" data-field="price">${row.price}</td>
                <td class="r mono">${amount > 0 ? amount.toFixed(2) : '—'}</td>-->
            <!--`;
            tbody.appendChild(tr);
        });

        /* attach input listeners for live editing */
        tbody.querySelectorAll('[contenteditable][data-field]').forEach(el => {
            el.addEventListener('input', () => {
                const id = parseFloat(el.dataset.id);
                const field = el.dataset.field;
                const r = rows.find(r => r.id === id);
                if (r) { 
                    r[field] = el.textContent; 
                    recalc(); 
                }
            });
        });

        recalc();
    }

    function recalc() {
        let sub = 0;
        rows.forEach(r => {
            sub += (parseFloat(r.qty)||0) * (parseFloat(r.price)||0);
        });

        const discPct = parseFloat(document.getElementById('discPct').textContent) || 0;
        const taxPct  = parseFloat(document.getElementById('taxPct').textContent)  || 0;
        
        const disc = sub * discPct / 100;
        const afterDisc = sub - disc;
        const tax = afterDisc * taxPct / 100;
        const total = afterDisc + tax;

        document.getElementById('subtotal').textContent = sub.toFixed(2);
        document.getElementById('discAmt').textContent  = disc.toFixed(2);
        document.getElementById('taxAmt').textContent   = tax.toFixed(2);
        document.getElementById('total').textContent    = total.toFixed(2);
    }

    /* live recalc on disc/tax change */
    ['discPct','taxPct'].forEach(id => {
        document.getElementById(id).addEventListener('input', recalc);
    });

    function resetForm() {
        if (!confirm('Reset all fields to defaults?')) return;
        rows = [];
        defaultRows.forEach(d => addRow(d));
    }

async function loadInvoiceData() {
    const urlParams = new URLSearchParams(window.location.search);
    const invoiceId = urlParams.get('id');

    if (!invoiceId) return;

    try {
        const response = await fetch(`delivery_note_items?id=${invoiceId}`);
        const data = await response.json();

        if (data && data.invoice) {
            const inv = data.invoice;
            const sys = data.system; // Our new company data

            // --- 1. COMPANY HEADER (From sys_info) ---
            if (sys) {
               // document.querySelector('.brand-name').textContent = sys.company_name;
                document.querySelector('.brand-sub').innerHTML = `
                    ${sys.company_addr} · Tel: ${sys.company_contact_1} ${sys.company_contact_2 ? '/ ' + sys.company_contact_2 : ''}<br>
                    Email: ${sys.company_email_1} · Web: ${sys.company_web}
                `;
                // If you have a footer note in sys_info, you can map it here
                document.querySelector('.footer').textContent = `${sys.company_name} - ${sys.company_reg || ''} · Thank you for your business.`;
            }

            // --- 2. INVOICE META ---
            document.getElementById('dnNum').textContent = 'DN-' + inv.id;
            document.getElementById('invId').textContent = inv.invoice_no;
            
            const invDate = new Date(inv.invoice_date);
            document.getElementById('issueDate').textContent = invDate.toLocaleDateString('en-GB', { 
                day:'2-digit', month:'short', year:'numeric' 
            });

            // Sales Rep
            const repLabel = Array.from(document.querySelectorAll('.meta-block label')).find(el => el.textContent === "Sales Rep.");
            if (repLabel) {
                repLabel.nextElementSibling.textContent = inv.sales_rep_name || 'System';
            }

            // --- 3. CUSTOMER ADDRESS BLOCKS ---
            const customerHTML = `
                <strong>${inv.cus_name || 'Walking Customer'}</strong><br>
                ${inv.cus_company ? inv.cus_company + '<br>' : ''}
                ${inv.cus_address || 'No Address Provided'}<br>
                Tel: ${inv.cus_phone || '—'}
            `;
            document.querySelectorAll('.address-block .addr').forEach(box => {
                box.innerHTML = customerHTML;
            });
			
			
			// --- 	NOTES ---
			document.getElementById('note').textContent = inv.remarks;

            // --- 4. ITEMS TABLE ---
            rows = []; 
            if (data.items && data.items.length > 0) {
                data.items.forEach(item => {
                    addRow({
                        desc: `${item.prod_name || item.product_name} [${item.product_code}]`, 
                        qty: parseFloat(item.qty),
                        price: parseFloat(item.unit_price)
                    });
                });
            } else {
                addRow({ desc: 'No items linked to this record.', qty: 0, price: 0 });
            }

            // --- 5. TOTALS ---
            document.getElementById('subtotal').textContent = parseFloat(inv.subtotal).toFixed(2);
            document.getElementById('discAmt').textContent  = parseFloat(inv.line_discount_total).toFixed(2);
            document.getElementById('taxAmt').textContent   = parseFloat(inv.tax_total).toFixed(2);
            document.getElementById('total').textContent    = parseFloat(inv.grand_total).toFixed(2);

            // --- 6. LOCK ALL FIELDS (Remove Editability) ---
            document.querySelectorAll('[contenteditable]').forEach(el => {
                el.setAttribute('contenteditable', 'false');
                el.style.outline = 'none';
            });
        }
    } catch (error) {
        console.error("Error loading full UI data:", error);
    }
}

    /* ── Initialization ── */
    document.addEventListener('DOMContentLoaded', loadInvoiceData);

</script>-->