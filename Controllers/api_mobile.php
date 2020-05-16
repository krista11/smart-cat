<?php
include "lampController.php";
include "kettleController.php";
include "generalController.php";
include "..\Models\available-devices.php";

$input_Json = file_get_contents("php://input");
$input = json_decode($input_Json, true);
//$input["number"] = 1;
//$input["type"] = "lamp";
/*$input["id"] = 2;
$input["action"] = "disconnect";
$input["place"] = "living room";
$input["type"] = "general";*/
if(isset($input["number"]))
{   
    $number = $input["number"]*1;
    if($number > 0){
        switch($input["type"])
        {
            case "lamp":
                $data = lampController::makeObject($number);
                break;
            case "kettle":
                $data = kettleController::makeObject($number);
                break;
        }
    }
    else if($number == -2){
        $data = availableDevices::getAll();
    }
    else{
        $data = availableDevices::getConnected(28);
    }
    $message = json_encode($data);
    echo $message;
}
else if(isset($input["action"])){

    switch($input["type"]){
        case "lamp":
            $result = lampController::makeConnection($input["id"], $input["action"], $input["place"], 28);
            break;
        case "kettle":
            $result = kettleController::makeConnection($input["id"], $input["action"], $input["place"], 28);
            break;
        default:
            $result = generalController::makeConnection($input["id"], $input["action"], $input["place"], 28, $input["type"]);
    }
    echo $result;
}
else
{
    echo "connected";
}
?>