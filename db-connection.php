<?php
function dbConnection(){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "smart-cat";

    $link = new mysqli($servername, $username, $password, $dbname);
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    return $link;
}


?>