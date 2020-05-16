<?php
include '..\Models\lamp.php';
include '..\Models\kettle.php';
include 'simpleResponse.php';
include 'basicCardResponse.php';
include 'lampController.php';
include 'kettleController.php';
include 'generalController.php';
class parameterController{
    public static function parseParameters($intent, $parameters, $id){
        $response = simpleResponse("Sorry, can't help with what.");
        if(isset($parameters["phrase"])){
            $user = new User($id, "", $parameters["email"], $parameters["phrase"]);
            $response = parameterController::setPhrase($user);
        }
        if(isset($parameters["open-notes"])){
            $response = basicCardResponse();
        }
        if($intent == "changeRoom"){
            $response = parameterController::changeRoom($parameters, $id);
        }
        if($intent == "changeBuilding"){
            $response = parameterController::changeBuilding($parameters, $id);
        }
        if($intent == "deviceSurvey"){
            switch($parameters["device"]){
                case "lamp":
                    $response = parameterController::actions_with_lamp($parameters, $id);
                    break;
                case "kettle":
                    $response = parameterController::actions_with_kettle($parameters, $id);
                    break;
                default:
                    $response = parameterController::actions_with_general_devices($parameters, $id);
            }
        }
        if($intent == "lamp-bright-intent"){
            $response = parameterController::lamp_bright($parameters, $id);
        }
        if($intent == "lamp-color-intent"){
            $response = parameterController::lamp_color($parameters, $id);
        }
        return $response;
    }
    public static function actions_with_lamp($parameters, $user_id)
    {
        $text = "";
        $action = $parameters["action"];
        $room = $parameters["room"];
        $id = $parameters["id"];
        $building = $parameters["building"];
        switch($action){
            case "turn on":
                $text = lampController::update_state($room, $id, "on", $user_id, $building);
                break;
            case "turn off":
                $text = lampController::update_state($room, $id, "off", $user_id, $building);
                break;
        }
        $response = simpleResponse($text);
        return $response;
    }
    public static function lamp_bright($parameters, $user_id)
    {
        $text = "";
        $brightness = $parameters["brightness"];
        $id = $parameters["id"];
        $room = $parameters["room"];
        $text = lampController::set_brightness($brightness, $id, $room, $user_id);
        $response = simpleResponse($text);
        return $response;
    }
    public static function lamp_color($parameters, $user_id){
        $text = "";
        $color = $parameters["color"];
        $id = $parameters["id"];
        $room = $parameters["room"];
        $text = lampController::set_color($color, $id, $room, $user_id);
        $response = simpleResponse($text);
        return $response;
    }
    public static function actions_with_kettle($parameters, $user_id)
    {
        $text = "";
        $action = $parameters["action"];
        $room = $parameters["room"];
        $id = $parameters["id"];
        $building = $parameters["building"];
        switch($action){
            case "turn on":
                $text = kettleController::update_state($room, $id, "on", $user_id, $building);
                break;
            case "turn off":
                $text = kettleController::update_state($room, $id, "off", $user_id, $building);
                break;
        }
        $response = simpleResponse($text);
        return $response;
    }
    public static function actions_with_general_devices($parameters, $user_id){
        $text = "";
        $action = $parameters["action"];
        $room = $parameters["room"];
        $id = $parameters["id"];
        $device = $parameters["device"];
        $building = $parameters["building"];
        switch($action){
            case "turn on":
                $text = generalController::update_state($room, $id, "on", $user_id, $device, $building);
                if($device == "all devices"){
                    kettleController::update_state($room, $id, "on", $user_id, $building);
                    lampController::update_state($room, $id, "on", $user_id, $building);
                    $text = "All connected devices are turned on.";
                }
                break;
            case "turn off":
                $text = generalController::update_state($room, $id, "off", $user_id, $device, $building);
                if($device == "all devices"){
                    kettleController::update_state($room, $id, "off", $user_id, $building);
                    lampController::update_state($room, $id, "off", $user_id, $building);
                    $text = "All connected devices are turned off.";
                }
                break;
        }
        $response = simpleResponse($text);
        return $response;
    }
    public static function setPhrase($user){
        $result = User::updateUser($user);
        if($result == TRUE){
            $text = "Phrase is setted succsesfully.";
        }else{
            $text = "Something goes wrong when you change a phrase.";
        }
        return simpleResponse($text);
    }
    public static function changeRoom($parameters, $user_id){
        $newRoom = $parameters["newRoom"];
        $id = $parameters["number"];
        switch($parameters["device"]){
            case "lamp":
                $text = lampController::change_room($newRoom, $id, $user_id);
                break;
            case "kettle":
                $text = kettleController::change_room($newRoom, $id, $user_id);
                break;
            default:
                $text = generalController::change_room($newRoom, $id, $user_id);
        }
        return simpleResponse($text);
    }
    public static function changeBuilding($parameters, $user_id){
        $newPlace = $parameters["building"];
        $id = $parameters["number"];
        switch($parameters["device"]){
            case "lamp":
                $text = lampController::change_building($newPlace, $id, $user_id);
                break;
            case "kettle":
                $text = kettleController::change_building($newPlace, $id, $user_id);
                break;
            default:
                $text = generalController::change_building($newPlace, $id, $user_id);
        }
        return simpleResponse($text);
    }
}


?>