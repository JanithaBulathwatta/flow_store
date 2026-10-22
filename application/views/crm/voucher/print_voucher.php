<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voucher #<?= $voucher->id; ?></title>

    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
            font-family: Arial, sans-serif;
        }

        body {
            padding: 0;
        }

        .print-area {
            width: 105mm;
            height: 148.5mm;
            padding: 8mm;
            border: 1px dashed #999;
            position: relative;
        }

        .voucher {
            width: 100%;
            height: 100%;
            border: 1px solid #222;
            padding: 6mm;
        }

        .company-name {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2mm;
        }

        .voucher-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #222;
            padding-bottom: 3mm;
            margin-bottom: 5mm;
        }

        .voucher-info {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .voucher-info td {
            padding: 2.5mm 1mm;
            vertical-align: top;
        }

        .label {
            width: 35%;
            font-weight: bold;
        }

        .amount-box {
            margin-top: 5mm;
            padding: 4mm;
            border: 1px solid #222;
            text-align: center;
        }

        .amount-label {
            font-size: 10px;
        }

        .amount {
            font-size: 20px;
            font-weight: bold;
            margin-top: 2mm;
        }

        .note {
            margin-top: 5mm;
            font-size: 11px;
        }

        .signature-area {
            position: absolute;
            left: 9mm;
            right: 9mm;
            bottom: 10mm;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            text-align: center;
        }

        .signature {
            width: 35%;
            border-top: 1px solid #222;
            padding-top: 2mm;
        }

        .print-button {
            margin: 20px;
        }

        @media print {
            .print-button {
                display: none;
            }

            .print-area {
                border: none;
            }
        }
    </style>
</head>

<body>

<button class="print-button" onclick="window.print()">
    Print Voucher
</button>

<div class="print-area">

    <div class="voucher">

        <div class="company-name">
            <?php
				$com_logo = $this->session->userdata('company_logo');
			?>
			<img src="/uploads/<?php echo $com_logo; ?>" alt="logo" style="width:140px; height:60px; object-fit:cover; border-radius:6px;margin-left: -18px;">
        </div>

        <div class="voucher-title">
            Payment Voucher
        </div>

        <table class="voucher-info">

            <tr>
                <td class="label">Voucher No:</td>
                <td><?= htmlspecialchars($voucher->id); ?></td>
            </tr>

            <tr>
                <td class="label">Date:</td>
                <td>
                    <?= date('d-m-Y', strtotime($voucher->voucher_date)); ?>
                </td>
            </tr>

            <tr>
                <td class="label">Receiver:</td>
                <td>
                    <?= htmlspecialchars($voucher->emp_name); ?>
                </td>
            </tr>

        </table>

        <div class="amount-box">

            <div class="amount-label">
                VOUCHER AMOUNT
            </div>

            <div class="amount">
                Rs. <?= number_format($voucher->amount, 2); ?>
            </div>

        </div>

        <div class="note">
            <strong>Note:</strong><br>
            <?= nl2br(htmlspecialchars($voucher->note ?? '-')); ?>
        </div>

        <div class="signature-area">

            <div class="signature">
                Prepared By
            </div>

            <div class="signature">
                Receiver Signature
            </div>

        </div>

    </div>

</div>

</body>
</html>