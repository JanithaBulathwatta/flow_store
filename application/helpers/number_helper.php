<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('convert_number_to_words')) {
function convert_number_to_words($number) {
    // Inner function to handle the words without the "Only" suffix
    $words = function($num) use (&$words) {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $dictionary  = array(
            0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety',
            100 => 'Hundred', 1000 => 'Thousand', 1000000 => 'Million', 1000000000 => 'Billion'
        );

        if ($num < 21) {
            return $dictionary[$num];
        } elseif ($num < 100) {
            $tens = ((int)($num / 10)) * 10;
            $units = $num % 10;
            return $dictionary[$tens] . ($units ? $hyphen . $dictionary[$units] : '');
        } elseif ($num < 1000) {
            $hundreds = (int)($num / 100);
            $remainder = $num % 100;
            return $dictionary[$hundreds] . ' ' . $dictionary[100] . ($remainder ? $conjunction . $words($remainder) : '');
        } else {
            $baseUnit = pow(1000, floor(log($num, 1000)));
            $numBaseUnits = (int)($num / $baseUnit);
            $remainder = $num % $baseUnit;
            $res = $words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $res .= ($remainder < 100 ? $conjunction : $separator) . $words($remainder);
            }
            return $res;
        }
    };

    if (!is_numeric($number)) return false;

    // Split into Whole Number and Cents
    $parts = explode('.', number_format($number, 2, '.', ''));
    $mainNumber = (int)$parts[0];
    $cents = (int)$parts[1];

    $result = $words($mainNumber);

    // Standard Cheque Decimal Formatting
    if ($cents > 0) {
        $result .= ' and Cents ' . $words($cents);
    }

    return $result . ' Only';
}
}