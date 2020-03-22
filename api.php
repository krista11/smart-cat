<?php
include "deviceController.php";
header('Content-Type: application/json');

$res = array(
    "fulfillmentText" => "This is a text response",
    "source" => "smart/api.php",
    "payload" => array(
        "google" => array(
            "expectUserResponse" => true,
            "richResponse" => array(
                "items" => array(
                    "simpleResponse" => array(
                        "textToSpeech" => "this is a simple response")
                    ),
                ),
            ),
        ),
    "outputContexts" => array(
        "name" => "projects/project-id/agent/sessions/session-id/contexts/context-name",
        "lifespanCount" => 5,
        "parameters" => array(
            "param-name" => "param-value"
        ),
    ),
);


function processMessage($update){

    $parameters = $update["queryResult"]["parameters"];
    $name = $update["queryResult"]["intent"]["name"];
   

   
    $data = new stdClass();
    $data = array("payload" => array("google" => array("expectUserResponse" => true, "richResponse"=> array("items"=>array("simpleResponse"=>array("textToSpeech"=>"speech from webhook", "displayText"=>"Writen from webhook"))))));
    $data["outputContext"]["name"] = $name;

    $data["fulfillmentText"] = parseParameters($parameters);

    $response = json_encode($data);
    echo $response;
}

$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);
processMessage($update);






?>