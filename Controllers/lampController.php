<?php
require_once('..\Models\lamp.php');
class lampController{

    public static function or_exist($place, $number, $rev_state, $user){
        $con = mysql::quote("disconnect");
        if($place == "''"){
            $sql = "SELECT * FROM lamp WHERE state = $rev_state AND user_id = $user AND connection = $con";
        }
        if($place != "''"){
            $sql = "SELECT * FROM lamp WHERE place = $place AND state = $rev_state AND user_id = $user AND connection = $con";
        }
        if($number != ""){
            $_number = $number*1;
            $sql = "SELECT * FROM lamp WHERE number = $_number AND state = $rev_state AND user_id = $user AND connection = $con";
        }
        $result = mysql::select($sql);
        return $result;
    }
    public static function update_state($place, $id, $state, $user){
        $_place = mysql::quote($place);
        $_state = mysql::quote($state);
        $user_id = $user*1;
        $rev_state ="on";
        if($state == "on"){         //jei paprašė įjungti lempą, ieškome išjungtų lempų
            $rev_state = "off";
        }
        $r_state = mysql::quote($rev_state);
        $result = lampController::or_exist($_place, $id, $r_state, $user_id);
        if($result == FALSE){
            return "None of the lights are ".$rev_state." at this moment.";
        }
        else{
            for($i=0; $i < count($result); $i++){
                $id = $result[$i]["id"];
                $commands = Lamp_commands::getCommands($id);
                if(!empty($commands)){
                    if($commands[0]["state"]*1 == 1){
                        if($state == "on"){
                            date_default_timezone_set('Europe/Vilnius');
                            $date = date("Y-m-d H:i:s");
                            $_date = mysql::quote($date);
                            $sql = "UPDATE lamp SET state = $_state, last_turned_on = $_date WHERE id = $id";
                        }
                        else{
                            $sql = "UPDATE lamp SET state = $_state WHERE id = $id";
                            lampController::set_used_time($result[$i]);
                        }
                        mysql::query($sql);
                    }   
                }       
            }
        }
        if($state == "on"){
            return "Lamp is turned on.";
        }else{
            return "Lamp is turned off.";
        }
    }
    public static function set_used_time($result){
        date_default_timezone_set('Europe/Vilnius');
        if($result["last_turned_on"] != "00-00-00 00:00:00"){
            $id = $result["id"];
            $last_turned_on = new DateTime($result["last_turned_on"]);
            $now = new Datetime();
            $sek = $now->format('U') - $last_turned_on->format('U');
            $h = intdiv($sek, 3600);
            $m = intdiv(($sek - 3600 * $h), 60);
            $s = $sek - 3600 * $h - 60 * $m;
            $sql = "UPDATE lamp SET used_time = '$h:$m:$s' WHERE id = $id";
            mysql::query($sql);
        }            
    }
    public static function set_brightness($brightness, $number, $place, $user){
        //change the brightness of the turned on lamp
        $_state = mysql::quote("on");
        $_place = mysql::quote($place);
        $user_id = $user*1;
        $result = lampController::or_exist($_place, $number, $_state, $user_id);
        $_brightness = intval(rtrim($brightness, "%"));
        $counter = 0;
        if($result == FALSE){
            return "There are no lights on here.";
        }else{
            for($i=0; $i<count($result); $i++){
                $id = $result[$i]["id"];
                $commands = Lamp_commands::getCommands($id);
                if(!empty($commands)){
                    if($commands[0]["brightness"]*1 == 1){
                        $sql = "UPDATE lamp SET brightness = $_brightness WHERE id = $id";
                        mysql::query($sql);
                        $counter++;
                    }
                }
            }
        }
        if($counter == 0){
            return "This device don't have this function";
        }
        return "OK, brightness was setted";
    }
    public static function set_color($color, $number, $place, $user){
        //change the color of the turned on lamp
        $_state = mysql::quote("on");
        $_place = mysql::quote($place);
        $user_id = $user*1;
        $result = lampController::or_exist($_place, $number, $_state, $user_id);
        $_color = mysql::quote($color);
        $counter = 0;
        if($result == false){
            return "There are no lights on here.";
        }else{
            for($i=0; $i<count($result); $i++){
                $id = $result[$i]["id"];
                $commands = Lamp_commands::getCommands($id);
                if(!empty($commands)){
                    if($commands[0]["color"]*1 == 1){
                        $sql = "UPDATE lamp SET color = $_color WHERE id = $id";
                        mysql::query($sql);
                        $counter++;
                    }
                }
            }
        }
        if($counter == 0){
            return "This device don't have this function";
        }
        return "Ok. Color was setted.";
    }
    public static function makeObject($id)
    {
        $_id = $id * 1;
        //return all available devices
        if($_id == -2){
            $sql = "SELECT * FROM lamp ORDER BY number ASC";
        }
        //return all connected devices
        else if($_id == -1){
            $sql = "SELECT * FROM lamp Where connection = 'disconnect' ORDER BY number ASC";
        }
        //return one device
        else{
            $sql = "SELECT * FROM lamp WHERE number = $_id";
        }
        $data = mysql::select($sql);
        return $data;
    }
    public static function makeConnection($device_number, $connection, $place){
        $number = $device_number * 1;
        $_connection = mysql::quote($connection);
        $_place = mysql::quote($place);
        $sql = "UPDATE lamp SET connection = $_connection, place = $_place WHERE number = $number";
        $result = mysql::query($sql);
        if($result == TRUE){
            return "Done";
        }
        else{
            return "Something goes wrong.";
        }
    }
 }