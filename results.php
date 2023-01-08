<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="esp-game-results.csv"');
header('Cache-Control: max-age=0');

include('common.php');

$dir = new DirectoryIterator(dirname(__FILE__));
$users = array();

$results = array();

foreach ($dir as $fileinfo) {
    if (isResultsFile($fileinfo)) {
        
        // Read the CSV
        $csv = array_map( 'str_getcsv', file( $fileinfo->getFilename() ) );
        // var_export($csv);

        foreach ($csv as $entry) {
            $image = $entry[0];
            $words = $entry[1];

            // Make this one big long string of words for now. We'll explode and count values later.
            $results[$image] .= $words . ",";
        }
    }
}

// For each image count the words and replace that entry with an assoc array of word => count
foreach($results as $image => $words) {
    $results[$image] = array_count_values(explode(",", $words));
}

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