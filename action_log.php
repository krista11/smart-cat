<?php
session_start();
include 'Views\header.php'; 
include 'Views\actionTable.php';
if(!isset($_SESSION["user_id"])){
    header("location: login");
}
?>
        <!-- <img src="images/top.png" alt="bossy-cat-cat"> -->
<!DOCTYPE html>
<html>
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
        <h1>Action log</h1>
    </div>
    <div class="content2">
        <div class="action-table-wrapper">
            <?php makeActionLogTable(); ?>
        </div>
    </div>
    </div>

    
</div>
</body>
</html>