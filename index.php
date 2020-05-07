<?php include 'Views\deviceTable.php'; 
include 'Views\header.php'; 
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
<title>Bossy Cat</title>
<link type="text/css" rel="stylesheet" href="styles.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
</head>

<body>

<?php makeHeader(); ?>

<div class="page">

    <div class="content">
        <h1>YOUR DEVICES</h1>
        <p>Here you can see the available devices, their status and location.</p>
    </div>
    <div class="content2">
        <div class="tabs_wrapper">
            <?php makeTabs(); ?>
        </div>

        <div id="lamp" class="device" style="display:none">
            <?php makeLampTable(); ?>
        </div>
        <div id="kettle" class="device" style="display:none">
            <?php makeKettleTable(); ?>
        </div>
    </div>
    
</div>
</body>
</html>

<script>
function openDevice(tab, deviceName) {
  var i;
  var x = document.getElementsByClassName("device");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none"; 
  }
  var y = document.getElementsByClassName("device_tab");
  for (i = 0; i < y.length; i++) {
    y[i].classList.remove("active");
  }
  var element = document.getElementById(deviceName);
  element.style.display = "block";
  var tab_element = document.getElementById(tab);
  tab_element.classList.add("active");
}
</script>