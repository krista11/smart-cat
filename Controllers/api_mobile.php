<?php
include "lampController.php";

$input_Json = file_get_contents("php://input");
$input = json_decode($input_Json, true);
if(isset($input["number"]))
{
    $number = $input["number"];
    $data = lampController::makeObject($number);
    $message = json_encode($data);
    echo $message;
}
else if(isset($input["action"])){
    if($input["action"] == "connect"){
        $result = lampController::makeConnection($input["id"], "disconnect", $input["place"]);
        echo $result;
    }
    else{
        $result = lampController::makeConnection($input["id"], "connect", $input["place"]);
        echo $result;
    }
}
else
{
    echo "connected";
}


?>