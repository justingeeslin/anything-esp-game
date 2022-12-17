<?php
// Wow, this feels awesome. I haven't done a pure PHP project is a loong time. Where's my Product Key for Windows XP Professional Edition? 

$GLOBALS['resultsFile'] = "results.csv";
$GLOBALS['formURL'] = "/index.php";

// Sanitize input
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
// var_export($_POST);

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