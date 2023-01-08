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

?>