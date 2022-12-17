<?php
// Wow, this feels awesome. I haven't done a pure PHP project is a loong time. Where's my Product Key for Windows XP Professional Edition? 

$GLOBALS['resultsFile'] = "results.csv";
$GLOBALS['formURL'] = "/index.php";

// Sanitize input
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
// var_export($_POST);

// Custom results file
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
echo stringifyURL("https://justin.geesl.in/config-alternate.json");


if (isset($_POST["config"])) {
    $GLOBALS['resultsFile'] = stringifyURL($_POST["config"]) . ".csv";
    // Create the results file
    $f = fopen($GLOBALS['resultsFile'], 'a');
    fclose($f);
}

//Determine whether their are any matches
// Get all the words for a particular image. 
// Read the CSV
$csv = array_map( 'str_getcsv', file( $GLOBALS['resultsFile'] ) );
// var_export($csv);

// Keep a running tally of all this image's words
$wordsStr = "";

foreach ($csv as $entry) {
    $image = $entry[0];
    $words = $entry[1];
    

    if ($image == $_POST["image"]) {
        $wordsStr .= "," . $words;
    }
}

// Wrangle the image's words keeping only a unique list
$imagesWordsAndCounts = array_count_values(explode(",", $wordsStr));
$imagesWords = array_keys($imagesWordsAndCounts);
// echo "<h3>Image's words:</h3>";
// var_export($imagesWords);

// Count the user-submitted words matches. 
$userWords = explode(",", $_POST["words"]);
$userWords = array_unique($userWords);
// echo "<h3>User words:</h3>";
// var_export($userWords);
$matchedWords = array_intersect($imagesWords, $userWords);

$numberOfMatches = count($matchedWords);
if ($numberOfMatches > 0) {
    echo "<h1>Great!</h1>";
    echo "<p>You found " . $numberOfMatches . " matches!</p>";

    echo "<h3>Matched words:</h3>";
    var_export($matchedWords);
    echo "<br>";

    echo '<a href="' . $GLOBALS['formURL'] . '">Keep going!</a>';
}
else {
    echo "<h1>No matches</h1>";
    echo '<a href="' . $GLOBALS['formURL'] . '">Try again</a>';
}
echo '<hr>';
function recordResults() {
    echo "Recording results… ";    
    $myfile = fopen($GLOBALS['resultsFile'], "a") or die("Unable to open file!");
    $data = '"' . $_POST["image"] . '", "' . $_POST["words"] . "\"\n";
    fwrite($myfile, $data);
    echo "Done!";
    fclose($myfile);
}

recordResults();



?>