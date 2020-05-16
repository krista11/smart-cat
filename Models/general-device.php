<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class generalDevices{

    public static function getAll($id){
        $id = intval($id);
        $sql = "SELECT * FROM general_devices WHERE user_id = $id ORDER BY number ASC";
        return mysql::select($sql);
    }
    public static function getById($id){
        $id = intval($id);
        $sql = "SELECT * FROM general_devices WHERE id = $id";
        return mysql::select($sql);
    }
    public static function insert($id, $type, $name, $room, $user_id){
        $id = intval($id);
        $type = mysql::quote($type);
        $name = mysql::quote($name);
        $room = mysql::quote($room);
        $user_id = intval($user_id);
        $devices = generalDevices::getAll($user_id);
        $number = count($devices) +1;
        $sql = "INSERT INTO general_devices (id, type, name, number, state, building, room, user_id)
                VALUES($id, $type, $name, $number, 'off', 'home', $room, $user_id)";
        $result = mysql::query($sql);
        return mysql::query($sql);
    }
    public static function delete($id){
        $id = intval($id);
        $sql = "DELETE FROM general_devices WHERE id = $id";
        mysql::query($sql);
    }
    public static function updateNumber($id, $number){
        $id = intval($id);
        $number = intval($number);
        $sql = "UPDATE general_devices SET number = $number WHERE id = $id";
        mysql::query($sql);
    }
    public static function updateState($id, $state){
        $id = intval($id);
        $state = mysql::quote($state);
        $sql = "UPDATE general_devices SET state = $state WHERE id = $id";
        mysql::query($sql);
    }
    public static function or_exist($room, $number, $state, $user_id, $type, $building){
        $room = mysql::quote($room);
        $state = mysql::quote($state);
        $user_id = intval($user_id);
        $number = intval($number);
        $type = mysql::quote($type);
        $building = mysql::quote($building);
        if($building != "''" && $room == "''" && $type == "''"){
            $sql = "SELECT * FROM general_devices WHERE user_id = $user_id AND state = $state AND building = $building";
        }
        if($building != "''" && $room != "''" && $type == "''"){
            $sql = "SELECT * FROM general_devices WHERE user_id = $user_id AND state = $state AND building = $building AND room = $room";
        }
        if($building != "''" && $room != "''" && $type != "''"){
            $sql = "SELECT * FROM general_devices WHERE user_id = $user_id AND state = $state AND building = $building AND room = $room AND type = $type";
        }
        if($building != "''" && $room == "''"&& $type != "''"){
            $sql = "SELECT * FROM general_devices WHERE user_id = $user_id AND state = $state AND building = $building AND type = $type";
        }
        if($building == "''" && $room != "''" && $type == "''"){
            $sql = "SELECT * FROM general_devices WHERE user_id = $user_id AND state = $state AND room = $room";
        }
        if($building == "''" && $room == "''" && $type != "''"){
            $sql = "SELECT * FROM general_devices WHERE user_id = $user_id AND state = $state AND type = $type";
        }
        if($building == "''" && $room != "''" && $type != "''"){
            $sql = "SELECT * FROM general_devices WHERE user_id = $user_id AND state = $state AND type = $type AND room = $room";
        }
        if($building == "''" && $room == "''"&& $type == "''"){
            $sql = "SELECT * FROM general_devices WHERE user_id = $user_id AND state = $state";
        }
        if($number != ""){
            $sql = "SELECT * FROM general_devices WHERE number = $number  AND user_id = $user_id AND state = $state";
        }
        $result = mysql::select($sql);
        return $result;
    }
    public static function getByNumber($number, $user_id){
        $number = intval($number);
        $user_id = intval($user_id);
        $sql = "SELECT * FROM general_devices WHERE number = $number AND user_id = $user_id";
        return mysql::select($sql);
    }
    public static function change_room($newRoom, $number, $user_id){
        $newRoom = mysql::quote($newRoom);
        $result = generalDevices::getByNumber($number, $user_id);
        if(count($result) == 0){
            return "You don't have device with this identification number.";
        }
        else{
            $sql = "UPDATE general_devices SET room = $newRoom WHERE number = $number AND user_id = $user_id";
            mysql::query($sql);
        }
        return "Room changed successfully.";
    }
    public static function change_building($newBuilding, $number, $user_id){
        $newBuilding = mysql::quote($newBuilding);
        $result = generalDevices::getByNumber($number, $user_id);
        if(count($result) == 0){
            return "You don't have device with this identification number.";
        }
        else{
            $sql = "UPDATE general_devices SET building = $newBuilding WHERE number = $number AND user_id = $user_id";
            mysql::query($sql);
        }
        return "Building changed successfully.";
    }
    
}