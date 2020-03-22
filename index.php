<?php include 'device-table.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Smart Cat</title>
<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
<div class="page">
    <div class="header">
        <img src="images/top.png" alt="smart-cat">
    </div>
    <div class="content">
        <h1>YOUR DEVICES</h1>
        <p>Here you can see the available devices, their status and location.</p>
        <table>
        <tr>
            <th>Nr.</th>
            <th>Device type</th>
            <th>State</th>
            <th>Place</th>
        </tr>

        <?php makeTable(); ?>

        </table>
    </div>
</div>
</body>
</html>
