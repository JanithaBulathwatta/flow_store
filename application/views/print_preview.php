<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>PO / GRN — Minimal Print</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<style>
*{box-sizing:border-box;margin:0;padding:0}

:root{
  --ink:#111;
  --mid:#555;
  --lite:#999;
  --line:#ddd;
  --bg-row:#fafafa;
  --f:  'Inter',sans-serif;
  --fm: 'JetBrains Mono',monospace;
}

body{
  font-family:var(--f);
  font-size:12px;
  color:var(--ink);
  background:#d9d9d9;
  padding:20px 12px;
}

/* ── toolbar ── */
.bar{
  max-width:195mm;
  margin:0 auto 12px;
  display:flex;
  gap:6px;
  align-items:center;
}
.bar-title{
  font-family:var(--fm);
  font-size:10px;
  color:#666;
  letter-spacing:.08em;
  text-transform:uppercase;
  margin-right:auto;
}
.btn{
  font-family:var(--fm);
  font-size:10px;
  letter-spacing:.06em;
  text-transform:uppercase;
  border:1px solid #888;
  background:#fff;
  color:#333;
  padding:4px 12px;
  cursor:pointer;
  border-radius:2px;
  transition:all .12s;
}
.btn:hover,.btn.on{background:#111;color:#fff;border-color:#111}

/* ── page ── */
.page{
  max-width:195mm;
  margin:0 auto;
  background:#fff;
  padding:14mm 14mm 12mm;
  box-shadow:0 2px 20px rgba(0,0,0,.15);
}

/* ── header ── */
.hd{
  display:flex;
  justify-content:space-between;
  align-items:flex-end;
  padding-bottom:10px;
  border-bottom:1.5px solid var(--ink);
  margin-bottom:12px;
}
.co-name{font-size:15px;font-weight:700;letter-spacing:-.02em}
.co-sub{font-size:10px;color:var(--mid);margin-top:2px;line-height:1.6}
.doc-right{text-align:right}
.doc-type{
  font-family:var(--fm);
  font-size:9px;
  letter-spacing:.15em;
  text-transform:uppercase;
  color:var(--mid);
}
.doc-num{
  font-family:var(--fm);
  font-size:16px;
  font-weight:600;
  color:var(--ink);
  letter-spacing:-.02em;
}
.doc-date{font-size:10px;color:var(--mid);margin-top:1px}

/* ── meta row ── */
.meta{
  display:grid;
  grid-template-columns:1fr 1fr 1fr;
  gap:0;
  border:1px solid var(--line);
  margin-bottom:12px;
}
.meta-cell{
  padding:7px 10px;
  border-right:1px solid var(--line);
}
.meta-cell:last-child{border-right:none}
.mc-label{
  font-family:var(--fm);
  font-size:8px;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:var(--lite);
  margin-bottom:2px;
}
.mc-val{font-size:11px;font-weight:500;color:var(--ink)}

/* ── parties ── */
.parties{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px;
  margin-bottom:12px;
}
.party{padding:8px 10px;border:1px solid var(--line)}
.party-label{
  font-family:var(--fm);
  font-size:8px;
  letter-spacing:.15em;
  text-transform:uppercase;
  color:var(--lite);
  margin-bottom:5px;
}
.party-name{font-size:12px;font-weight:600;margin-bottom:2px}
.party-info{font-size:10.5px;color:var(--mid);line-height:1.65}

/* ── table ── */
.tbl{
  width:100%;
  border-collapse:collapse;
  margin-bottom:12px;
  font-size:11px;
}
.tbl thead th{
  font-family:var(--fm);
  font-size:8px;
  letter-spacing:.1em;
  text-transform:uppercase;
  color:var(--mid);
  padding:5px 7px;
  border-bottom:1.5px solid var(--ink);
  text-align:left;
  white-space:nowrap;
}
.tbl thead th.r{text-align:right}
.tbl tbody td{
  padding:6px 7px;
  border-bottom:1px solid var(--line);
  color:var(--ink);
  vertical-align:top;
}
.tbl tbody tr:last-child td{border-bottom:none}
.tbl tbody tr:nth-child(even) td{background:var(--bg-row)}
.tbl td.r{text-align:right;font-family:var(--fm);font-size:10.5px}
.tbl td.c{text-align:center}
.code{font-family:var(--fm);font-size:9.5px;color:var(--lite)}
.pname{font-size:11px;font-weight:500}
.pname small{display:block;font-size:9.5px;color:var(--mid);font-weight:400}

/* grn-only cols */
.g{display:none}
body.grn .g{display:table-cell}
body.grn .p{display:none}

/* ── bottom ── */
.bottom{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:16px;
}

.notes{flex:1;padding:8px 10px;border:1px solid var(--line);font-size:10.5px;color:var(--mid);line-height:1.7}
.notes-label{
  font-family:var(--fm);
  font-size:8px;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:var(--lite);
  margin-bottom:4px;
}

/* summary */
.summary{width:200px;flex-shrink:0}
.sum-row{
  display:flex;
  justify-content:space-between;
  padding:4px 0;
  border-bottom:1px solid var(--line);
  font-size:11px;
}
.sum-row:last-child{border-bottom:none}
.sum-label{color:var(--mid)}
.sum-val{font-family:var(--fm);font-weight:500;white-space:nowrap}
.sum-total{
  display:flex;
  justify-content:space-between;
  padding:7px 0 0;
  margin-top:4px;
  border-top:1.5px solid var(--ink);
  font-size:13px;
  font-weight:700;
}
.sum-total .sum-val{font-family:var(--fm)}

/* ── sigs ── */
.sigs{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:12px;
  margin-top:14px;
  padding-top:12px;
  border-top:1px solid var(--line);
}
.sig-box{padding-bottom:24px;border-bottom:1px solid var(--ink);margin-bottom:4px}
.sig-label{font-family:var(--fm);font-size:8px;letter-spacing:.1em;text-transform:uppercase;color:var(--lite)}
.sig-name{font-size:10px;color:var(--mid);margin-top:1px}

/* ── footer ── */
.ft{
  margin-top:12px;
  padding-top:7px;
  border-top:1px solid var(--line);
  display:flex;
  justify-content:space-between;
  font-family:var(--fm);
  font-size:8.5px;
  color:var(--lite);
}

/* ── print ── */
@media print{
  @page{size:A4 portrait;margin:10mm}
  body{background:#fff;padding:0}
  .bar{display:none!important}
  .page{max-width:100%;box-shadow:none;padding:0}
  thead{display:table-header-group}
  tr{page-break-inside:avoid}
  *{-webkit-print-color-adjust:exact;print-color-adjust:exact}
}
</style>
</head>
<body id="B" class="po">

<!-- toolbar -->
<div class="bar d-print-none">
  <span class="bar-title">Preview</span>
  <button class="btn on" id="bPO" onclick="sw('po')">PO</button>
  <button class="btn" id="bGRN" onclick="sw('grn')">GRN</button>
  <button class="btn" onclick="print()">Print / PDF</button>
</div>

<div class="page">

  <!-- header -->
  <div class="hd">
    <div>
      <div class="co-name">Nexora Supplies Ltd.</div>
      <div class="co-sub">42 Industrial Zone, Colombo 15 &nbsp;·&nbsp; +94 11 234 5678</div>
    </div>
    <div class="doc-right">
      <div class="doc-type" id="dType">Purchase Order</div>
      <div class="doc-num" id="dNum">PO-2024-00847</div>
      <div class="doc-date">10 January 2025</div>
    </div>
  </div>

  <!-- meta -->
  <div class="meta">
    <div class="meta-cell">
      <div class="mc-label">Prepared By</div>
      <div class="mc-val">Sanduni Rathnayake</div>
    </div>
    <div class="meta-cell">
      <div class="mc-label">Approved By</div>
      <div class="mc-val">Dinesh Fernando</div>
    </div>
    <div class="meta-cell p">
      <div class="mc-label">Payment Terms</div>
      <div class="mc-val">Net 30 Days</div>
    </div>
    <div class="meta-cell g" style="display:none">
      <div class="mc-label">PO Reference</div>
      <div class="mc-val">PO-2024-00847</div>
    </div>
  </div>

  <!-- parties -->
  <div class="parties">
    <div class="party">
      <div class="party-label">Supplier</div>
      <div class="party-name">Global Trade Imports Pvt Ltd</div>
      <div class="party-info">No. 78, Sea View Rd, Galle<br>+94 91 224 6600 &nbsp;·&nbsp; VAT: 4482910</div>
    </div>
    <div class="party">
      <div class="party-label p">Deliver To</div>
      <div class="party-label g" style="display:none">Received At</div>
      <div class="party-name">Main Warehouse, Peliyagoda</div>
      <div class="party-info">
        Lot 5B, Peliyagoda Industrial Area<br>
        <span class="p">Expected: 15 Jan 2025 &nbsp;·&nbsp; Attn: Kamal Perera</span>
        <span class="g" style="display:none">Received: 14 Jan 2025 &nbsp;·&nbsp; DN: DN-GTI-20240113</span>
      </div>
    </div>
  </div>

  <!-- items -->
  <table class="tbl">
    <thead>
      <tr>
        <th style="width:22px">#</th>
        <th style="width:68px">Code</th>
        <th>Product</th>
        <th class="r" style="width:36px">Unit</th>
        <th class="r p" style="width:40px">Qty</th>
        <th class="r g" style="width:46px;display:none">Ord.</th>
        <th class="r g" style="width:46px;display:none">Recv.</th>
        <th class="r g" style="width:44px;display:none">Free</th>
        <th class="r" style="width:72px">Unit Price</th>
        <th class="r" style="width:44px">Disc.</th>
        <th class="r" style="width:38px">Tax</th>
        <th class="r" style="width:80px">Total</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td><span class="code">PRD-001</span></td>
        <td><span class="pname">Stainless Steel Mixing Bowl Set<small>3-piece set</small></span></td>
        <td class="c">Set</td>
        <td class="r p">50</td>
        <td class="r g" style="display:none">50</td>
        <td class="r g" style="display:none">48</td>
        <td class="r g" style="display:none">2</td>
        <td class="r">2,450.00</td>
        <td class="r">5%</td>
        <td class="r">15%</td>
        <td class="r">134,066.25</td>
      </tr>
      <tr>
        <td>2</td>
        <td><span class="code">PRD-002</span></td>
        <td><span class="pname">Silicone Spatula<small>Pack of 12 — industrial grade</small></span></td>
        <td class="c">Pack</td>
        <td class="r p">120</td>
        <td class="r g" style="display:none">120</td>
        <td class="r g" style="display:none">120</td>
        <td class="r g" style="display:none">0</td>
        <td class="r">875.00</td>
        <td class="r">—</td>
        <td class="r">15%</td>
        <td class="r">120,750.00</td>
      </tr>
      <tr>
        <td>3</td>
        <td><span class="code">PRD-003</span></td>
        <td><span class="pname">Heavy Duty Cutting Board<small>Polypropylene</small></span></td>
        <td class="c">Pcs</td>
        <td class="r p">75</td>
        <td class="r g" style="display:none">75</td>
        <td class="r g" style="display:none">70</td>
        <td class="r g" style="display:none">5</td>
        <td class="r">1,200.00</td>
        <td class="r">10%</td>
        <td class="r">15%</td>
        <td class="r">87,975.00</td>
      </tr>
      <tr>
        <td>4</td>
        <td><span class="code">PRD-004</span></td>
        <td><span class="pname">Stainless Ladle 12oz<small>Commercial grade</small></span></td>
        <td class="c">Pcs</td>
        <td class="r p">200</td>
        <td class="r g" style="display:none">200</td>
        <td class="r g" style="display:none">200</td>
        <td class="r g" style="display:none">10</td>
        <td class="r">340.00</td>
        <td class="r">—</td>
        <td class="r">15%</td>
        <td class="r">78,200.00</td>
      </tr>
      <tr>
        <td>5</td>
        <td><span class="code">PRD-005</span></td>
        <td><span class="pname">Food Storage Container 10L<small>BPA Free</small></span></td>
        <td class="c">Pcs</td>
        <td class="r p">100</td>
        <td class="r g" style="display:none">100</td>
        <td class="r g" style="display:none">95</td>
        <td class="r g" style="display:none">0</td>
        <td class="r">680.00</td>
        <td class="r">5%</td>
        <td class="r">15%</td>
        <td class="r">70,414.00</td>
      </tr>
    </tbody>
  </table>

  <!-- bottom -->
  <div class="bottom">
    <div class="notes">
      <div class="notes-label">Notes</div>
      All items must meet quality standards. Substitutions require prior approval. Payment via bank transfer to BOC Acc 7800-12345678.
    </div>
    <div class="summary">
      <div class="sum-row"><span class="sum-label">Subtotal</span><span class="sum-val">462,500.00</span></div>
      <div class="sum-row"><span class="sum-label">Discount</span><span class="sum-val">− 27,625.00</span></div>
      <div class="sum-row"><span class="sum-label">Tax (15%)</span><span class="sum-val">+ 56,530.25</span></div>
      <div class="sum-total"><span>Total (LKR)</span><span class="sum-val">491,405.25</span></div>
    </div>
  </div>

  <!-- signatures -->
  <div class="sigs">
    <div>
      <div class="sig-box"></div>
      <div class="sig-label">Prepared By</div>
      <div class="sig-name">Sanduni Rathnayake</div>
    </div>
    <div>
      <div class="sig-box"></div>
      <div class="sig-label">Checked By</div>
      <div class="sig-name">Amara Silva</div>
    </div>
    <div>
      <div class="sig-box"></div>
      <div class="sig-label">Approved By</div>
      <div class="sig-name">Dinesh Fernando</div>
    </div>
    <div>
      <div class="sig-box"></div>
      <div class="sig-label p">Supplier Signature</div>
      <div class="sig-label g" style="display:none">Received By</div>
      <div class="sig-name p">Global Trade Imports</div>
      <div class="sig-name g" style="display:none">Kamal Perera</div>
    </div>
  </div>

  <!-- footer -->
  <div class="ft">
    <span id="fDate"></span>
    <span>System Generated — Nexora ERP</span>
    <span>Page 1 of 1</span>
  </div>

</div>

<script>
document.getElementById('fDate').textContent =
  'Printed: ' + new Date().toLocaleString('en-GB',{dateStyle:'medium',timeStyle:'short'});

function sw(m){
  const B=document.getElementById('B');
  B.className=m;
  document.getElementById('bPO').classList.toggle('on',m==='po');
  document.getElementById('bGRN').classList.toggle('on',m==='grn');
  document.getElementById('dType').textContent = m==='po'?'Purchase Order':'Goods Receipt Note';
  document.getElementById('dNum').textContent  = m==='po'?'PO-2024-00847':'GRN-2024-01293';

  // show/hide labelled elements
  document.querySelectorAll('.p').forEach(e=>e.style.display=m==='po'?'':'none');
  document.querySelectorAll('.g').forEach(e=>e.style.display=m==='grn'?'':'none');
}
</script>
</body>
</html>
