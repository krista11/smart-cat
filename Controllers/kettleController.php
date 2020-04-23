<?php
require_once('..\Models\kettle.php');
class kettleController{

    public static function or_exist($place, $id, $state, $user_id){
        if($state == "on"){
            if($place == "''"){
                $sql = "SELECT * FROM kettle WHERE water != 'empty' AND user_id = $user_id";
            }
            if($place != "''"){
                $sql = "SELECT * FROM kettle WHERE place = $place AND water != 'empty' AND user_id = $user_id";
            }
            if($id != ""){
                $_id = $id*1;
                $sql = "SELECT * FROM kettle WHERE id = $_id AND water != 'empty' AND user_id = $user_id";
            }
        }else{
            if($place == "''"){
                $sql = "SELECT * FROM kettle WHERE  user_id = $user_id";
            }
            if($place != "''"){
                $sql = "SELECT * FROM kettle WHERE place = $place AND user_id = $user_id";
            }
            if($id != ""){
                $_id = $id*1;
                $sql = "SELECT * FROM kettle WHERE id = $_id AND user_id = $user_id";
            }
        }
        $result = mysql::select($sql);
        return $result;
    }
    public static function update_state($place, $id, $state, $user){
        $_place = mysql::quote($place);
        $_state = mysql::quote($state);
        $user_id = $user*1;
        $result = kettleController::or_exist($_place, $id, $state, $user_id);
        if(count($result) == 0){
            return "You don’t have a kettle or it’s without water.";
        }
        if($state == "on")
        {
            if($_place == "''"){
                $sql = "UPDATE kettle SET state = $_state WHERE water != 'empty' AND  user_id = $user_id";
            }
            if($_place != "''"){
                $sql = "UPDATE kettle SET state = $_state 
                WHERE place = $_place AND water != 'empty' AND user_id = $user_id";
            }
            if($id != ""){
                $_id = $id*1;
                $sql = "UPDATE kettle SET state = $_state WHERE id = $_id AND water != 'empty' AND user_id = $user_id";
            }
        }else{
            if($_place == "''"){
                $sql = "UPDATE kettle SET state = $_state WHERE  user_id = $user_id";
            }
            if($_place != "''"){
                $sql = "UPDATE kettle SET state = $_state WHERE place = $_place AND user_id = $user_id";
            }
            if($id != ""){
                $_id = $id*1;
                $sql = "UPDATE kettle SET state = $_state WHERE id = $_id AND user_id = $user_id";
            }
        }
        $res = mysql::query($sql);
        if($res == TRUE){
            if($state == "on"){
                return "Kettle is turned  on.";
            }else{
                return "Kettle is turned off.";
            }
        }else{
            return "Something goes wrong when trying to update the kettle status. Maybe the kettle has no water.";
        }
    }
    public static function add($place, $user_id){
        $kettles = Kettle::get($user_id);
        $quantity = count($kettles);
        $kettle = new Kettle("", $quantity+1, 100, "empty", $place, "off", $user_id);
        $result = Kettle::add($kettle);
        if($result == TRUE){
            return "Kettle is added.";
        }
        else{
            return "Something goes wrong when trying to add kettle.";
        }
    }
}

?>