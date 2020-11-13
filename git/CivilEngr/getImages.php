<?php
    $DB_NAME = 'civileng';

    /* Database Host */
    $DB_HOST = 'localhost';
    $DB_USER = 'civileng';
    $DB_PASS = 'g0valp0';
    $DB_TABLE = 'image_url';

    /* Establish the database connection */
    $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $result = $mysqli->query('SELECT '.$DB_TABLE.' FROM civilrecords');
    $count = 0;
    $url = "";

    /* Extract the information from $result */
    foreach($result as $r) {
        if ($url != (string) $r['image_url']) { //No repeats
            $count += 1;
            $temp = (string) $r['image_url']; 
            $url = (string) $r['image_url']; 

            //echo HTML line of code to specify photo location
            echo "<img class=\"mySlides\" src=\"admin/assets/external_images/".$url."\" style=\"width:100%\">";
        }
    }



    //Add buttons to buttom of Slideshow
    echo "<div class=\"w3-center w3-section w3-large w3-text-white w3-display-bottommiddle\" style=\"width:100%\">";
    echo "<div class=\"w3-left w3-padding-left w3-hover-text-khaki\" id=\"backBtn\">&#10094;</div>";
    echo "<div class=\"w3-right w3-padding-right w3-hover-text-khaki\" id=\"nextBtn\">&#10095;</div>";

    for($i = 0; $i < $count; $i += 1) {
        echo "<span class=\"w3-badge demo w3-border w3-transparent\"></span>";
    }

    echo "</div>";
    echo "</div>";
?>
