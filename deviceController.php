<?php
require_once('device.php');
include "db-connection.php";

function parseParameters($parameters){
    $data = new Device();

    $action = $parameters["action"];
    $data->set_place($parameters["place"]);
    $data->set_device($parameters["device"]);
    $data->set_brain("Google");

    $response = null;

    switch($action){
        case "add":
            $response = actionAdd($data);
            break;
        case "turn on":
            $response = actionTurnOn($data);
            break;
        case "turn off":
            $response = actionTurnOff($data);
            break;

    }

    return $response;
}

function actionAdd($data)
{
    $data->set_state("OFF");
    $response = "I will remember that you have " . $data->get_device() . ". ";
    if($data->get_place() == "")
    {   
        $response = $response . "Your " . $data->get_device() . " location is not setted.";
        $data->set_place(" not setted");
        addDevice($data);
        return $response;
    }
    addDevice($data);
    return $response . "Your " . $data->get_device() . " is in the " . $data->get_place() . ".";
}
//pirma patikrinu ar yra ką įjungti
//jei yra, įrenginių būsenos atnaujinamos ir formuojamas atsakymas
function actionTurnOn($data)
{
    $response = null;
    $orExist = orExist($data);
    if($orExist == FALSE){
        $response = "You don't have any " . $data->get_device() . " devices.";
        return $response;
    }
    $data->set_state("ON");
    updateDevice($data);
    if($data->get_place() == ""){
        $response = "All " . $data->get_device() . " devices are on.";
    }else{
        $response = "The " . $data->get_device() . " device is turned on in the " . $data->get_place() . ".";
    }
    return $response;
}
//pirma patikrinu ar yra ką įjungti
//jei yra, įrenginių būsenos atnaujinamos ir formuojamas atsakymas
function actionTurnOff($data)
{
    $response = null;
    $orExist = orExist($data);
    if($orExist == FALSE){
        $response = "You don't have any " . $data->get_device() . " devices.";
        return $response;
    }
    $data->set_state("OFF");
    updateDevice($data);
    if($data->get_place() == ""){
        $response = "All " . $data->get_device() . " devices are off.";
    }else{
        $response = "The " . $data->get_device() . " device is turned off in the " . $data->get_place() . ".";
    }
    return $response;
}
// jei nenustatyta vieta, visas tų įrenginių būsenas keičiame
// kitu atveju, keičiame tik to įrenginio būseną, kurio vieta nustatyta
function updateDevice(Device $device)
{
    $state = $device->get_state();
    $place = $device->get_place();
    $d = $device->get_device();
    if($place == "")
    {
        $sql = "UPDATE Devices SET state = '$state' WHERE device = '$d'";
    }else{
        $sql = "UPDATE Devices SET state = '$state' WHERE device = '$d' AND place = '$place'";
    }
    $conn = dbConnection();
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}
function orExist($data)
{
    $place = $data->get_place();
    $d = $data->get_device();
    if($place == ""){
        $sql = "SELECT * FROM Devices WHERE device = '$d'";
    }else{
        $sql = "SELECT * FROM Devices WHERE device = '$d' AND place = '$place'";
    }
    $conn = dbConnection();
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0)
    {
        return TRUE;
    }
    return FALSE;
}
function addDevice(Device $device)
{
    $conn = dbConnection();

    $d = $device->get_device();
    $state = $device->get_state();
    $place = $device->get_place();
    $brain = $device->get_brain();

    $sql = "INSERT INTO Devices (device, state, place, brain)
    VALUES ('$d', '$state', '$place', '$brain')";

    if(mysqli_query($conn, $sql)){
        //echo "Records added successfully";
    }
    else{
        echo "Error";
    }
    mysqli_close($conn);
}

function getDevices()
{
    $conn = dbConnection();

    $sql = "SELECT * FROM Devices";
    $conn = dbConnection();
    $result = mysqli_query($conn, $sql);

    
    $data = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $device = new Device();
            $device->set_device($row["device"]);
            $device->set_state($row["state"]);
            $device->set_place($row["place"]);
            
            $data[] = $device;
        }
    } 
    return $data;
}

?>