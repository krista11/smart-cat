<?php
require_once('..\Models\general-device.php');
class generalController{

    public static function update_state($room, $number, $state, $user, $type, $building)
    {
        $rev_state ="on";
        if($state == "on"){
            $rev_state = "off";
        }

        if($type == "all devices"){
            $result = generalDevices::or_exist($room, $number, $rev_state, $user, "", $building);
        }
        else{
            $result = generalDevices::or_exist($room, $number, $rev_state, $user, $type, $building);
        }
        if(count($result)  == 0){
            return "There is no device I can ".$state.".";
        }
        for($i=0; $i< count($result) ; $i++){
            generalDevices::updateState($result[$i]["id"], $state);
        }
        if(count($result) == 1){
            if($state == "on"){
                return "Device is turned on.";
            }else{
                return "Device is turned off.";
            }
        }
        else{
            if($state == "on"){
                return "Devices are turned on.";
            }else{
                return "Devices are turned off.";
            }
        }
    }
    public static function makeObject($id)
    {
        $data = generalDevices::get($id);
        return $data;
    }
    public static function makeConnection($device_id, $connection, $room, $user_id, $type){
        if($connection == "connect"){
            //update available device 
            availableDevices::updateConnection("disconnect", $user_id, $device_id);
            //get device we want to connect
            $device = availableDevices::getById($device_id);
            //get all user general devices
            $generalDevices = generalDevices::getAll($user_id);
            $number = count($generalDevices) + 1;
            generalDevices::insert($device_id, $type, $device[0]["name"], $room, $user_id);
        }
        else{
            //delete from general device table 
            generalDevices::delete($device_id);
            //disconnect device from available devices table
            availableDevices::updateConnection("connect", -1, $device_id);
            //need to change numbers of general devices
            $devices = generalDevices::getAll($user_id);
            for($i=0; $i < count($devices); $i++){
                generalDevices::updateNumber($devices[$i]["id"], $i+1);
            }
        }
    }
    public static function change_room($newRoom, $id, $user_id){
        $result = generalDevices::change_room($newRoom, $id, $user_id);
        return $result;
    }
    public static function change_building($newPlace, $id, $user_id){
        $result = generalDevices::change_building($newPlace, $id, $user_id);
        return $result;
    }
}

?>