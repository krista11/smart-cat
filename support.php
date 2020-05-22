<?php
session_start();
include 'Views\header.php'; 
if(!isset($_SESSION["user_id"])){
    header("location: login");
}
?>
        <!-- <img src="images/top.png" alt="bossy-cat-cat"> -->
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Bossy Cat Support</title>
<link type="text/css" rel="stylesheet" href="styles.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
</head>

<body>

<?php makeHeader(); ?>

<div class="page">
    <div class="content">
        <h1>Support</h1>
    </div>
    <div class="content2">
        <div class="action-table-wrapper">
            <h2> General operations</h2>
            <h3> Turn on / on </h3>
            <p>
                You can turn the device on by mentioning its type and location or its number.<br>
                If you do not mention the device number or location, all mentioned type devices will be turned on.<br><br>
                <span>For Example:</span>
                <br><br>
                Turn on lamp. (All lamp-type devices will turn on if turned off lamps are found) <br>
                Turn on lamp in the kitchen. (All lamp-type devices will be turned on if they are found in the kitchen) <br>
                Turn on lamp number 2. (Lamp number 2 will be turned on)<br><br>
                <span>Exceptional case: </span>
                You can turn on all devices by saying : "Turn on all devices" or "Turn on everything".
            </p>
            <h3> Turn off / off </h3>
            <p>
                You can turn the device off by mentioning its type and location or its number.<br>
                If you do not mention the device number or location, all mentioned type devices will be turned off.<br><br>
                <span>For Example:</span>
                <br><br>
                Turn off lamp. (All lamp-type devices will turn off if turned on lamps are found) <br>
                Turn off lamp in the kitchen. (All lamp-type devices will be turned off if they are found in the kitchen) <br>
                Turn off lamp number 2. (Lamp number 2 will be turned off)<br><br>
                <span>Exceptional case: </span>
                You can turn off all devices by saying : "Turn off all devices" or "Turn off everything".
            </p>
            <h2> Additional operations with lamp type devices</h2>
            <h3> Set color / change color </h3>
            <p>
                You can change lamp color by mentioning its location or its number.<br>
                If you do not mention the lamp number or location, all lamps will change their color if they have this function.<br><br>
                <span>For Example:</span>
                <br><br>
                Set color to red. (All lamp-type devices will change color into red if turned on lamps are found) <br>
                Set the color of the lamp in the kitchen to red. (All lamp-type devices will change color into red if they are found in the kitchen) <br>
                Set color for lamp number 1 to red. (Lamp number 1 will change color into red)<br>
            </p>
            <h3> Set brightness / set bright / change brightness / change bright</h3>
            <p>
                You can change lamp brightness by mentioning its location or its number.<br>
                If you do not mention the lamp number or location, all lamps will change their brightness if they have this function.<br><br>
                <span>For Example:</span>
                <br><br>
                Set brightness to 50%. (All lamp-type devices will change color into red if turned on lamps are found) <br>
                Set brightness in the kitchen to 50%. (All lamp-type devices will change color into red if they are found in the kitchen) <br>
                Set brightness for lamp number 1 to 50%. (Lamp number 1 will change color into red)<br>
            </p>
        </div>
    </div>    
</div>
</body>
</html>