<?php include 'Views\deviceTable.php'; 
include 'Views\header.php'; 
if(!isset($_SESSION["user_id"])){
    header("location: login");
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<link rel="icon" type="image/png" sizes="32x32" href="bossy-cat/images/favicon-32x32.png">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Bossy Cat</title>
<link type="text/css" rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap">
</head>

<body>

<?php makeHeader(); ?>

<div class="page">
    <div class="content">
        <h1>YOUR DEVICES</h1>
        <p>Here you can see the available devices, their status and location.</p>
    </div>

    <div id="devices" class="content2">
        <div class="tabs_wrapper">
            <?php makeTabs(); ?>
        </div>
        <div id="all" class="device" style="display:block">
            <?php makeTable(); ?>
        </div>
        <div id="lamp" class="device" style="display:none">
            <?php makeLampTable(); ?>
        </div>
        <div id="kettle" class="device" style="display:none">
            <?php makeKettleTable(); ?>
        </div>
        <div id="general" class="device" style="display:none">
            <?php makeGeneralTable(); ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    setInterval(function(){
        $("#lamp.showing").load(location.href + " #lamp>*"+"");
        $("#kettle.showing").load(location.href + " #kettle>*"+"");
        $("#general.showing").load(location.href + " #general>*"+"");
        $("#all.showing").load(location.href + " #all>*"+"");
    }, 4000);
});
function openDevice(tab, deviceName) {
  var x = document.getElementsByClassName("device");
  for (var i = 0; i < x.length; i++) {
    x[i].style.display = "none";
    x[i].classList.remove("showing");
  }
  var y = document.getElementsByClassName("device_tab");
  for (var i = 0; i < y.length; i++) {
    y[i].classList.remove("active");
  }
  var element = document.getElementById(deviceName);
  element.style.display = "block";
  element.classList.add("showing");
  var tab_element = document.getElementById(tab);
  tab_element.classList.add("active");
}
</script>

</body>
</html>

