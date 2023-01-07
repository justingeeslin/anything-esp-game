<?php
// Wow, this feels awesome. I haven't done a pure PHP project is a loong time. Where's my Product Key for Windows XP Professional Edition? 
session_start();
$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// 
$configURL = 'configuration.json';
if (isset($_GET["config"])) {
    $configURL = $_GET["config"];
}


$configuration = json_decode(file_get_contents($configURL));
// var_export($configuration);

$images = $configuration->images;
// var_export($images);

$defaultPrompt = "Add words that describe the image below.";

if (isset($configuration->prompt)) {
    $prompt = $configuration->prompt;
}
else {
    $prompt = $defaultPrompt;
}

// Pick a random image
$imageRandomIndex = array_rand($images);
$image = $images[$imageRandomIndex];
// var_export($image);

if (!isset($_SESSION['userid'])) {
    $_SESSION['userid'] = uniqid("user", true);
}

?>
<html>
    <head>
        <style>
            body {
                text-align:center;
            }
            img {
                max-width:75vw;
                max-height:75vh;
            }
        </style>
    </head>
    <body>
        <h1 id="prompt"><?php echo $prompt ?></h1>
        <img src="<?php echo $image->url ?>" alt="<?php echo $image->alt ?>">
        <form method="POST" action="save.php">
            <input type="hidden" name="image" value="<?php echo $image->url ?>">
            <input type="hidden" name="config" value="<?php echo $configURL ?>">
            <input type="text" name="words" placeholder="">
            <br>
            <input type="submit">
        </form>
    </body>
</html>