<?php
// Wow, this feels awesome. I haven't done a pure PHP project is a loong time. Where's my Product Key for Windows XP Professional Edition? 
session_start();
$GLOBALS['resultsFile'] = "results.csv";
$GLOBALS['formURL'] = "/index.php";

// Sanitize input
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
// var_export($_POST);

require_once('common.php');

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
else {
    $userid = 0;
}

if (isset($_POST["config"])) {
    $GLOBALS['resultsFile'] = stringifyURL($_POST["config"]) . "-" . $userid . "-RESULTS.csv";
    // Create the results file
    $f = fopen($GLOBALS['resultsFile'], 'a');
    fclose($f);

    // Tailor the Try Again link to include the configuration
    $GLOBALS['formURL'] = $GLOBALS['formURL'] . "?config=" . $_POST["config"];
}

//Determine whether their are any matches
// Get all the words for a particular image from the matched user
$GLOBALS['matchedUserResultsFile'] = stringifyURL($_POST["config"]) . "-user" . $_POST["matchedUser"] . "-RESULTS.csv";
// Read the CSV
$csv = array_map( 'str_getcsv', file( $GLOBALS['matchedUserResultsFile'] ) );
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

// Count the user-submitted words matches. 
$userWords = explode(",", $_POST["words"]);
$userWords = array_unique($userWords);

$matchedWords = array_intersect($imagesWords, $userWords);

$numberOfMatches = count($matchedWords);
if ($numberOfMatches > 0) {
    echo "<h1>Great!</h1>";
    echo "<p>You found " . $numberOfMatches . " matches!</p>";
    echo '<a href="' . $GLOBALS['formURL'] . '">Keep going!</a>';
}
else {
    echo "<h1>No matches</h1>";
    echo '<a href="' . $GLOBALS['formURL'] . '">Try again</a>';
}
echo '<hr>';

echo "<details open>";
echo "<h3>Matched words:</h3>";
var_export($matchedWords);
echo "<hr>";
echo "<h3>" . $_POST['matchedUser'] . "'s words:</h3>";
var_export($imagesWords);
echo "<hr>";
echo "<h3>Your words:</h3>";
var_export($userWords);

echo "</details>";

function recordResults() {
    // echo "Recording results??? "; 
    $myfile = fopen($GLOBALS['resultsFile'], "a") or die("Unable to open file!");
    $data = '"' . $_POST["image"] . '", "' . $_POST["words"] . "\"\n";
    fwrite($myfile, $data);
    // echo "Done!";
    fclose($myfile);
}

recordResults();



?>