<?php
require_once('..\Models\lamp.php');
require_once('..\Models\lamp-commands.php');
class lampController{

    public static function update_state($room, $id, $state, $user_id, $building){
        $rev_state ="on";
        if($state == "on"){         //jei paprašė įjungti lempą, ieškome išjungtų lempų
            $rev_state = "off";
        }
        $result = lamp::or_exist($room, $id, $rev_state, $user_id, $building);
        if(count($result) == 0){
            return "Can't find the lamp to turn it ".$state.".";
        }
        else{
            for($i=0; $i < count($result); $i++){
                $id = $result[$i]["id"];
                $commands = Lamp_commands::getCommands($id);
                if(!empty($commands)){
                    if(intval($commands[0]["state"]) == 1){
                        if($state == "on"){
                            date_default_timezone_set('Europe/Vilnius');
                            $date = date("Y-m-d H:i:s");
                            lamp::turnOn($id, $date);
                        }
                        else{
                            lamp::turnOff($id);
                            lampController::set_used_time($result[$i]);
                        }
                    }   
                }       
            }
        }
        if(count($result) == 1)
        {
            if($state == "on"){
                return "Lamp is turned on.";
            }else{
                return "Lamp is turned off.";
            }
        }else{
            if($state == "on"){
                return "Lamps are turned on.";
            }else{
                return "Lamps are turned off.";
            }
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
            lamp::updateUsedTime($h, $m, $s, $id);
        }            
    }
    public static function set_brightness($brightness, $number, $room, $user_id, $building){
        //change the brightness of the turned on lamp
        $_brightness = intval(rtrim($brightness, "%"));
        if($_brightness > 100 || $brightness < 20){
            return "Invalid brightness value. Brightness can be from 20 to 100%";
        }
        $result = lamp::or_exist($room, $number, "on", $user_id, $building);
        $counter = 0;
        if(count($result) == 0){
            return "Can't find the lamps turned on.";
        }else{
            for($i=0; $i<count($result); $i++){
                $id = $result[$i]["id"];
                $commands = Lamp_commands::getCommands($id);
                if(!empty($commands)){
                    if($commands[0]["brightness"]*1 == 1){
                        lamp::updateBrightness($id, $_brightness);
                        $counter++;
                    }
                }
            }
        }
        if($counter == 0){
            return "This device don't have this function.";
        }
        return "OK, brightness was setted.";
    }
    public static function set_color($color, $number, $room, $user_id, $building){
        //change the color of the turned on lamp
        $colors = array("white", "red", "green", "blue", "yellow");
        if(!in_array($color, $colors)){
            return "Device don't have ".$color." color. Try white, red, green, blue or yellow.";
        }
        $result = lamp::or_exist($room, $number, "on", $user_id, $building);
        $counter = 0;
        if($result == false){
            return "There are no lights on here.";
        }else{
            for($i=0; $i<count($result); $i++){
                $id = $result[$i]["id"];
                $commands = Lamp_commands::getCommands($id);
                if(!empty($commands)){
                    if($commands[0]["color"]*1 == 1){
                        lamp::updateColor($id, $color);
                        $counter++;
                    }
                }
            }
        }
        if($counter == 0){
            return "This device don't have this function.";
        }
        return "OK. Color was setted.";
    }
    public static function makeObject($id)
    {
        $data = lamp::makeObject($id);
        return $data;
    }
    public static function makeConnection($device_id, $connection, $room, $user_id){
        if($connection == "connect"){
            //update available device 
            availableDevices::updateConnection("disconnect", $user_id, $device_id);
            //get device we want to connect
            $device = availableDevices::getById($device_id);
            //get all user general devices
            $lamps = lamp::getAll($user_id);
            $number = count($lamps) + 1;
            lamp::insert($device_id, $device[0]["name"], $room, $user_id);
        }
        else{
            //delete from general device table 
            lamp::delete($device_id);
            //disconnect device from available devices table
            availableDevices::updateConnection("connect", -1, $device_id);
            //need to change numbers of general devices
            $devices = lamp::getAll($user_id);
            for($i=0; $i < count($devices); $i++){
                lamp::updateNumber($devices[$i]["id"], $i+1);
            }
        }
    }
    public static function change_room($newRoom, $id, $user_id){
        $result = lamp::change_room($newRoom, $id, $user_id);
        return $result;
    }
    public static function change_building($newPlace, $id, $user_id){
        $result = lamp::change_building($newPlace, $id, $user_id);
        return $result;
    }
 }