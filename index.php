<?php
header('Content-Type: application/sjson'); 

$requestBody = file_get_contents("php://input");
    $json = json_decode($requestBody);

    $text = $json->inputs->rawInputs->query;

    switch($text)
    {
        case 'hi':
            $speech = "Hi, nice to meet you";;
            break;
        case 'bye':
            $speech = "Bye, see you soon";
            break;

        default:
            $speech = "Sorry, I didn't get that. Please ask me some else.";
            break;
    }

    $response = new \stdClass();
    $response->speech = "";
    $response->displayText = "";
    $response->source = "webhook";
    echo json_encode($response);



?>