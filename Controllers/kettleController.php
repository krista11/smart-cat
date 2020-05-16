<?php
require_once('..\Models\kettle.php');
require_once('..\Models\kettle-commands.php');
class kettleController{

    public static function update_state($room, $id, $state, $user_id, $building){
        $rev_state ="on";
        if($state == "on"){
            $rev_state = "off";
        }
        $result = kettle::or_exist($room, $id, $rev_state, $user_id, $building);
        if(count($result) == 0){
            return "There is no kettle I can ".$state." or it’s without water.";
        }
        else{
            for($i=0; $i < count($result); $i++){
                $id = $result[$i]["id"];
                $commands = Kettle_commands::getCommands($id);
                if(!empty($commands)){
                    if(intval($commands[0]["state"]) == 1){
                        if($state == "on"){
                            kettle::updateState($id, "on");
                        }
                        else{
                            kettle::updateState($id, "off");
                        }
                    }   
                }       
            }
        }
        if(count($result) == 1){
            if($state == "on"){
                return "Kettle is turned on.";
            }else{
                return "Kettle is turned off.";
            }
        }else{
            if($state == "on"){
                return "Kettles are turned on.";
            }else{
                return "Kettles are turned off.";
            }
        }
    }
    public static function makeObject($id)
    {
        $data = kettle::makeObject($id);
        return $data;
    }
    public static function makeConnection($device_id, $connection, $room, $user_id){
        if($connection == "connect"){
            //update available device 
            availableDevices::updateConnection("disconnect", $user_id, $device_id);
            //get device we want to connect
            $device = availableDevices::getById($device_id);
            //get all user general devices
            $kettles = kettle::getAll($user_id);
            $number = count($kettles) + 1;
            kettle::insert($device_id, $device[0]["name"], $room, $user_id);
        }
        else{
            //delete from general device table 
            kettle::delete($device_id);
            //disconnect device from available devices table
            availableDevices::updateConnection("connect", -1, $device_id);
            //need to change numbers of general devices
            $devices = kettle::getAll($user_id);
            for($i=0; $i < count($devices); $i++){
                kettle::updateNumber($devices[$i]["id"], $i+1);
            }
        }
    }
    public static function change_room($newRoom, $id, $user_id){
        $result = kettle::change_room($newRoom, $id, $user_id);
        return $result;
    }
    public static function change_building($newPlace, $id, $user_id){
        $result = kettle::change_building($newPlace, $id, $user_id);
        return $result;
    }
}

?>