<?php 
error_reporting(0);

$configURL = 'configuration.json';
if (isset($_GET["config"])) {
    $configURL = $_GET["config"];
}

function stringifyURL($string) {
    setlocale(LC_CTYPE, 'en_US.UTF8');
    $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    $string = str_replace(' ', '-', $string);
    // Remove the protocol
    $string = str_replace('https://', '', $string);
    $string = str_replace('http://', '', $string);
    $string = str_replace('.', '-', $string);
    $string = str_replace('/', '_', $string);
    return $string;
}

function isResultsFile($fileinfo) {
    global $configURL;
    $filename = $fileinfo->getFilename();
    return !$fileinfo->isDot() && strpos($filename, stringifyURL($configURL)) !== FALSE && strpos($fileinfo->getFilename(), '-RESULTS.csv') !== FALSE;
}

// Makes an array of things, their words and the counts.
function getResults() {
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
    
    return $results;
}

?>