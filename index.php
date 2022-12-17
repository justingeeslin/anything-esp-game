<?php
// Wow, this feels awesome. I haven't done a pure PHP project is a loong time. Where's my Product Key for Windows XP Professional Edition? 

$images = array(
    // "wife material"
    'https://www.pd.co.ke/wp-content/uploads/2020/03/Wife-material-1200x750.gif',
    // Ppl of walmart
    'https://i.redd.it/0f2y2kmsv1f31.jpg',
    // Darren hayes
    'https://www.aceshowbiz.com/display/images/photo/2022/07/05/00188465.jpg',
);

// Pick a random image
$image = array_rand(array_flip($images));

?>
<html>
    <head>
        <style>
            img {
                max-width:75vw;
                max-height:75vh;
            }
        </style>
    </head>
    <body>
        <img src="<?php echo $image ?>" alt="You tell me">
        <form method="POST" action="save.php">
            <input type="hidden" name="image" value="<?php echo $image ?>">
            <input type="text" name="words" placeholder="Words">
            <input type="submit">
        </form>
    </body>
</html>