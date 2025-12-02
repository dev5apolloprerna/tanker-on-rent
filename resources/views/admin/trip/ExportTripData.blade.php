<?php

$filename = 'Trip_Report_' . date('d-m-Y_H-i-s') . '.xls';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename);

ob_end_clean();

// Excel Header Row
echo
"Sr.No"
."\t"."Trip Date"
."\t"."Source"
."\t"."Destination"
."\t"."Driver"
."\t"."Truck Name"
."\t"."Truck Number"
."\t"."No Of Bags"
."\t"."Weight (KG)"
."\t"."Weight (TON)"
."\n";

$i = 1;
$totalKg = 0;

// Helper: normalize weight exactly like controller
function normalizeWeightExport($value) {
    $v = strtolower(trim($value));

    preg_match('/([0-9]*\.?[0-9]+)/', $v, $match);
    $num = isset($match[1]) ? (float)$match[1] : 0;

    if (strpos($v, 'ton') !== false || preg_match('/\bt\b/', $v)) {
        return $num * 1000; // convert TON → KG
    }

    return $num; // default KG
}

foreach ($trips as $row) {

    // Convert weight to KG
    $kg = normalizeWeightExport($row->weight);

    // Convert to TON
    $ton = $kg / 1000;

    // Add to total
    $totalKg += $kg;

    echo 
        $i
        ."\t".date('d-m-Y', strtotime($row->trip_date))
        ."\t".$row->source
        ."\t".$row->destination
        ."\t".$row->driver->driver_name
        ."\t".$row->truck->truck_name
        ."\t".$row->truck->truck_number
        ."\t".$row->no_of_bags
        ."\t".$kg
        ."\t".number_format($ton, 3)
        ."\n";

    $i++;
}

// FINAL TOTAL ROW
echo 
"\n"
."TOTAL"
."\t\t\t\t\t\t\t\t"
.$totalKg . " KG"
."\t". number_format($totalKg / 1000, 3) . " (ટન) ";
