<?php 
include('common.php');

?>
<html>
    <head>
        <style>
            .thing {
                display:grid;
                grid-template-columns: 1fr 1fr;
            }

            img {
                max-width:50vw;
            }

            .tags {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                max-width: 960px;
                margin: auto;
                padding: 2rem 0 1rem;
                list-style: none;
                border: 2px solid white;
                border-radius: 5px;
            }

            .tag {
                display: flex;
                align-items: center;
                margin: 0.25rem 1rem;
            }

            .tag__link {
                padding: 5px 5px 0;
                transition: 0.3s;
                text-decoration: none;
            }
        </style>
    </head>
<?php
$results = getResults();

foreach ($results as $image => $wordCounts) {
    echo '<div class="thing">';
    echo '<img src="' . $image . '">';
    echo '<ul class="tags">';

    // Discover the max count for this thing
    $maxCount = 0;
    foreach($wordCounts as $word => $count) {
        if ($count > $maxCount) {
            $maxCount = $count;
        }
    }
    foreach($wordCounts as $word => $count) {
        echo '<li class="tag" style="font-size: ' . ($count/$maxCount) * 4 . 'em">' . $word . ' (' . $count . ')</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '<hr>';
}

?>