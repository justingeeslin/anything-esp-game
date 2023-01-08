<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="esp-game-results.csv"');
header('Cache-Control: max-age=0');

include('common.php');

$results = getResults();

// var_export($results);
$out = fopen('php://output', 'w');

// Header row
fputcsv($out, array("Thing", "Word", "Count"));

foreach ($results as $image => $wordCounts) {
    foreach($wordCounts as $word => $count) {
        fputcsv($out, array($image, $word, $count));
    }
}

fclose($out);
?>