<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class Kettle{

    public static function getAll($user_id){
        $user_id = intval($user_id);
        $sql = "SELECT * FROM kettle WHERE user_id = $user_id ORDER BY number ASC";
        return mysql::select($sql);
    }
    public static function delete($id){
        $id = intval($id);
        $sql = "DELETE FROM kettle where id = $id";
        mysql::query($sql);
    }
    public static function or_exist($room, $number, $state, $user_id, $building){
        $room = mysql::quote($room);
        $number = intval($number);
        $state = mysql::quote($state);
        $user_id = intval($user_id);
        $building = mysql::quote($building);
        if($building != "''" && $room == "''"){
            $sql = "SELECT * FROM kettle WHERE waterLevel != 'empty' AND user_id = $user_id AND state = $state AND building = $building";
        }
        if($building != "''" && $room != "''"){
            $sql = "SELECT * FROM kettle WHERE waterLevel != 'empty' AND user_id = $user_id AND state = $state AND building = $building AND room = $room";
        }
        if($building == "''" && $room == "''"){
            $sql = "SELECT * FROM kettle WHERE waterLevel != 'empty' AND user_id = $user_id AND state = $state";
        }
        if($building == "''" && $room != "''"){
            $sql = "SELECT * FROM kettle WHERE room = $room AND waterLevel != 'empty' AND user_id = $user_id AND state = $state";
        }
        if($number != ""){
            $sql = "SELECT * FROM kettle WHERE number = $number AND waterLevel != 'empty' AND user_id = $user_id AND state = $state";
        }
        $result = mysql::select($sql);
        return $result;
    }
    public static function updateState($id, $state){
        $id = intval($id);
        $state = mysql::quote($state);
        $sql = "UPDATE kettle SET state = $state WHERE id = $id";
        mysql::query($sql);
    }
    public static function insert($device_id, $name, $room, $user_id){
        $device_id = intval($device_id);
        $name = mysql::quote($name);
        $room = mysql::quote($room);
        $user_id = intval($user_id);
        $kettles = kettle::getAll($user_id);
        $number = count($kettles) + 1;
        $sql = "INSERT INTO kettle (id, name, number, temperature, waterLevel, building, room, state, user_id)
        VALUES($device_id, $name, $number, 75, 'empty', 'home', $room, 'off', $user_id)";
        mysql::query($sql);
    }
    public static function updateNumber($id, $number){
        $id = intval($id);
        $number = intval($number);
        $sql = "UPDATE kettle SET number = $number WHERE id = $id";
        mysql::query($sql);
    }
    public static function makeObject($id){
        $id = intval($id);
        $sql = "SELECT * FROM kettle WHERE id = $id";
        return mysql::select($sql);
    }
    public static function getByNumber($number, $user_id){
        $number = intval($number);
        $user_id = intval($user_id);
        $sql = "SELECT * FROM kettle WHERE number = $number AND user_id = $user_id";
        return mysql::select($sql);
    }
    public static function change_room($newRoom, $number, $user_id){
        $newRoom = mysql::quote($newRoom);
        $result = kettle::getByNumber($number, $user_id);
        if(count($result) == 0){
            return "You don't have kettle with this identification number.";
        }
        else{
            $sql = "UPDATE kettle SET room = $newRoom WHERE number = $number AND user_id = $user_id";
            mysql::query($sql);
        }
        return "Room changed successfully.";
    }
    public static function change_building($newBuilding, $number, $user_id){
        $newBuilding = mysql::quote($newBuilding);
        $result = kettle::getByNumber($number, $user_id);
        if(count($result) == 0){
            return "You don't have kettle with this identification number.";
        }
        else{
            $sql = "UPDATE kettle SET building = $newBuilding WHERE number = $number AND user_id = $user_id";
            mysql::query($sql);
        }
        return "Building changed successfully.";
    }
}
?>