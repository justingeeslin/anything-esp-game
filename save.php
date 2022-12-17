<?php
// Wow, this feels awesome. I haven't done a pure PHP project is a loong time. Where's my Product Key for Windows XP Professional Edition? 
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
echo "Recording results…";
var_export($_POST);
$myfile = fopen("results.csv", "a") or die("Unable to open file!");
$data = '"' . $_POST["image"] . '", "' . $_POST["words"] . "\"\n";
fwrite($myfile, $data);
fclose($myfile);
?>