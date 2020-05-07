<?php
include "mysql.php";
include "parameterController.php";
include "userController.php";
include "../Models/user_log.php";
header('Content-Type: application/json');

$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);
processMessage($update);

function processMessage($update){
    $request = $update["queryResult"]["queryText"];

    $parameters = $update["queryResult"]["parameters"];
    $code = $update["queryResult"]["intent"]["name"];
    $intent = $update["queryResult"]["intent"]["displayName"]; 

    $data = array();
    $id = userController::checkUser($code);
    if($id != NULL){
        User_log::addRequest($id, $request);
        $data = parameterController::parseParameters($intent, $parameters, $id);
    }else{
        $data = "Problem with autorization.";
    }
    array_push($data, array("outputContext" => array( 0 => array("name" => $code))));
    $response = json_encode($data);
    echo $response;
}
?>