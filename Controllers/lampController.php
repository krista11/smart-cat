<?php
require_once('..\Models\lamp.php');
class lampController{

    public static function or_exist($place, $number, $rev_state, $user){
        if($place == "''"){
            $sql = "SELECT * FROM lamp WHERE state = $rev_state AND user_id = $user";
        }
        if($place != "''"){
            $sql = "SELECT * FROM lamp WHERE place = $place AND state = $rev_state AND user_id = $user";
        }
        if($number != ""){
            $_number = $number*1;
            $sql = "SELECT * FROM lamp WHERE number = $_number AND state = $rev_state AND user_id = $user";
        }
        $result = mysql::select($sql);
        return $result;
    }
    public static function update_state($place, $id, $state, $user){
        $_place = mysql::quote($place);
        $_state = mysql::quote($state);
        $user_id = $user*1;
        $rev_state ="on";
        if($state == "on"){
            $rev_state = "off";
        }
        $r_state = mysql::quote($rev_state);
        $result = lampController::or_exist($_place, $id, $r_state, $user_id);
        if($result == FALSE){
            return "Something goes wrong when trying to update the lamp status.";
        }
        if(count($result) == 0){
            return "None of the lights are ".$rev_state." at this moment.";
        }
        if($state == "on"){
            date_default_timezone_set('Europe/Vilnius');
            $date = date("Y-m-d H:i:s");
            $_date = mysql::quote($date);
            if($_place == "''"){
                $sql = "UPDATE lamp SET state = $_state, last_turned_on = $_date 
                WHERE state = $r_state AND user_id = $user_id";
            }
            if($_place != "''"){
                $sql = "UPDATE lamp SET state = $_state, last_turned_on = $_date 
                WHERE place = $_place AND state = $r_state AND user_id = $user_id";
            }
            if($id != ""){
                $_id = $id*1;
                $sql = "UPDATE lamp SET state = $_state, last_turned_on = $_date 
                WHERE number = $_id AND state = $r_state AND user_id = $user_id";
            }
        }
        else{
            lampController::set_used_time($result);
            if($_place == "''"){
                $sql = "UPDATE lamp SET state = $_state WHERE state = $r_state AND user_id = $user_id";
            }
            if($_place != "''"){
                $sql = "UPDATE lamp SET state = $_state WHERE place = $_place AND state = $r_state AND user_id = $user_id";
            }
            if($id != ""){
                $_id = $id*1;
                $sql = "UPDATE lamp SET state = $_state WHERE number = $_id AND state = $r_state AND user_id = $user_id";
            }
        }
        $res = mysql::query($sql);
        if($res == TRUE){
            if($state == "on"){
                return "Lamp is turned  on.";
            }else{
                return "Lamp is turned off.";
            }
        }else{
            return "Something goes wrong when trying to update the lamp status.";
        }
    }
    public static function set_used_time($result){
        date_default_timezone_set('Europe/Vilnius');
        for($i=0; $i < count($result); $i++){
            if($result[$i]["last_turned_on"] != "00-00-00 00:00:00"){
                $id = $result[$i]["id"];
                $last_turned_on = new DateTime($result[$i]["last_turned_on"]);
                $now = new Datetime();
                $sek = $now->format('U') - $last_turned_on->format('U');
                $h = intdiv($sek, 3600);
                $m = intdiv(($sek - 3600 * $h), 60);
                $s = $sek - 3600 * $h - 60 * $m;
                $sql = "UPDATE lamp SET used_time = '$h:$m:$s' WHERE id = $id";
                mysql::query($sql);
            }            
        }
    }
    public static function add($place, $user_id){
        $lamps = Lamp::get($user_id);
        $quantity = count($lamps);
        $lamp = new Lamp("", $quantity+1, 50, "white", $place, "off", "0000-00-00 00:00:00", "00:00:00", $user_id);
        $result = Lamp::add($lamp);
        if($result == TRUE){
            return "Lamp is added.";
        }
        else{
            return "Something goes wrong when trying to add lamp.";
        }
    }
    public static function set_brightness($brightness, $number, $place, $user){
        //change the brightness of the turned on lamp
        $_state = mysql::quote("on");
        $_place = mysql::quote($place);
        $user_id = $user*1;
        $result = lampController::or_exist($_place, $number, $_state, $user_id);
        $_brightness = intval(rtrim($brightness, "%"));
        if($result == FALSE){
            return "There are no lights on here.";
        }else{
            for($i=0; $i<count($result); $i++){
                $id = $result[$i]["id"];
                $sql = "UPDATE lamp SET brightness = $_brightness WHERE id = $id";
                mysql::query($sql);
            }
        }
        return "Ok. Brightness was setted.";
    }
    public static function set_color($color, $number, $place, $user){
        //change the color of the turned on lamp
        $_state = mysql::quote("on");
        $_place = mysql::quote($place);
        $user_id = $user*1;
        $result = lampController::or_exist($_place, $number, $_state, $user_id);
        $_color = mysql::quote($color);
        if($result == false){
            return "There are no lights on here.";
        }else{
            for($i=0; $i<count($result); $i++){
                $id = $result[$i]["id"];
                $sql = "UPDATE lamp SET color = $_color WHERE id = $id";
                mysql::query($sql);
            }
        }
        return "Ok. Color was setted.";
    }
}

?>