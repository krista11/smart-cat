<?php
include '..\Models\lamp.php';
include '..\Models\kettle.php';
include 'simpleResponse.php';
include 'basicCardResponse.php';
include 'lampController.php';
include 'kettleController.php';
class parameterController{
    public static function parseParameters($intent, $parameters, $id){
        $response = null;
        if(isset($parameters["phrase"])){
            $user = new User($id, "", $parameters["email"], $parameters["phrase"]);
            $response = parameterController::setPhrase($user);
        }
        if(isset($parameters["open-notes"])){
            $response = basicCardResponse();
        }
        if(isset($parameters["device"])){
            switch($parameters["device"]){
                case "lamp":
                    $response = parameterController::actions_with_lamp($parameters, $id);
                    break;
                case "kettle":
                    $response = parameterController::actions_with_kettle($parameters, $id);
                    break;
            }
        }
        if($intent == "lamp-intent"){
            $response = parameterController::specific_lamp_actions($parameters, $id);
        }
        return $response;
    }
    public static function actions_with_lamp($parameters, $user_id)
    {
        $text = "Unknown action.";
        $action = $parameters["action"];
        $place = $parameters["place"];
        $id = $parameters["id"];
        switch($action){
            case "turn on":
                $text = lampController::update_state($place, $id, "on", $user_id);
                break;
            case "turn off":
                $text = lampController::update_state($place, $id, "off", $user_id);
                break;
            case "add":
                $text = lampController::add($place, $user_id);
                break;
        }
        $response = simpleResponse($text);
        return $response;
    }
    public static function specific_lamp_actions($parameters, $user_id){
        $brightness = $parameters["brightness"];
        $color = $parameters["color"];
        $id = $parameters["id"];
        $place = $parameters["place"];
        $action = $parameters["action"];
        switch($action){
            case "set brightness":
                $text = lampController::set_brightness($brightness, $id, $place, $user_id);
                break;
            case "set color":
                $text = lampController::set_color($color, $id, $place, $user_id);
                break;
        }
        $response = simpleResponse($text);
        return $response;
    }
    public static function actions_with_kettle($parameters, $user_id)
    {
        $text = "";
        $action = $parameters["action"];
        $place = $parameters["place"];
        $id = $parameters["id"];
        switch($action){
            case "turn on":
                $text = kettleController::update_state($place, $id, "on", $user_id);
                break;
            case "turn off":
                $text = kettleController::update_state($place, $id, "off", $user_id);
                break;
            case "add":
                $text = kettleController::add($place, $user_id);
                break;
        }
        $response = simpleResponse($text);
        return $response;
    }
    public static function setPhrase($user){
        $result = User::updateUser($user);
        if($result == TRUE){
            $text = "Phrase is setted.";
        }else{
            $text = "Something goes wrong when you change a phrase.";
        }
        return simpleResponse($text);
    }
}


?>