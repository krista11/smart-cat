<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class Lamp{

    public static function getAll($id){
        $id = intval($id);
        $sql = "SELECT * FROM lamp WHERE user_id = $id ORDER BY number ASC";
        return mysql::select($sql);
    }
    public static function delete($id){
        $id = intval($id);
        $sql = "DELETE FROM lamp WHERE id = $id";
        mysql::query($sql);
    }
    public static function or_exist($room, $number, $state, $user_id, $building){
        $room = mysql::quote($room);
        $number = intval($number);
        $state = mysql::quote($state);
        $user_id = intval($user_id);
        $building = mysql::quote($building);
        if($building != "''" && $room == "''"){
            $sql = "SELECT * FROM lamp WHERE state = $state AND user_id = $user_id AND building = $building";
        }
        if($building != "''" && $room != "''"){
            $sql = "SELECT * FROM lamp WHERE state = $state AND user_id = $user_id AND building = $building AND room = $room";
        }
        if($building == "''" && $room == "''"){
            $sql = "SELECT * FROM lamp WHERE state = $state AND user_id = $user_id";
        }
        if($building == "''" && $room != "''"){
            $sql = "SELECT * FROM lamp WHERE room = $room AND state = $state AND user_id = $user_id";
        }
        if($number != ""){
            $_number = $number*1;
            $sql = "SELECT * FROM lamp WHERE number = $_number AND state = $state AND user_id = $user_id";
        }
        $result = mysql::select($sql);
        return $result;
    }
    public static function turnOn($id, $date){
        $id = intval($id);
        $date = mysql::quote($date);
        $state = mysql::quote("on");
        $sql = "UPDATE lamp SET state = $state, last_turned_on = $date WHERE id = $id";
        mysql::query($sql);                        
    }
    public static function turnOff($id){
        $id = intval($id);
        $state = mysql::quote("off");
        $sql = "UPDATE lamp SET state = $state WHERE id = $id";
        mysql::query($sql);
    }
    public static function updateUsedTime($h, $m, $s, $id){
        $sql = "UPDATE lamp SET used_time = '$h:$m:$s' WHERE id = $id";
        mysql::query($sql);
    }
    public static function updateBrightness($id, $brightness){
        $id = intval($id);
        $brightness = intval($brightness);
        $sql = "UPDATE lamp SET brightness = $brightness WHERE id = $id";
        mysql::query($sql);
    }
    public static function updateColor($id, $color){
        $id = intval($id);
        $color = mysql::quote($color);
        $sql = "UPDATE lamp SET color = $color WHERE id = $id";
        mysql::query($sql);
    }
    public static function insert($device_id, $name, $room, $user_id){
        $device_id = intval($device_id);
        $name = mysql::quote($name);
        $room = mysql::quote($room);
        $user_id = intval($user_id);
        $number = count(lamp::getAll($user_id))+1;
        $sql = "INSERT INTO lamp (id, name, number, brightness, color, building, room, state, last_turned_on, used_time, user_id)
                VALUES($device_id, $name, $number, 100, 'white', 'home', $room, 'off', '0000-00-00 00:00:00', '00:00:00', $user_id)";
        $result = mysql::query($sql);
    }
    public static function updateNumber($id, $number){
        $id = intval($id);
        $number = intval($number);
        $sql = "UPDATE lamp SET number = $number WHERE id = $id";
        mysql::query($sql);
    }
    public static function makeObject($id){
        $id = intval($id);
        $sql = "SELECT id, name, number, brightness, color, state FROM lamp WHERE id = $id";
        return mysql::select($sql);
    }
    public static function getByNumber($number, $user_id){
        $number = intval($number);
        $user_id = intval($user_id);
        $sql = "SELECT * FROM lamp WHERE number = $number AND user_id = $user_id";
        return mysql::select($sql);
    }
    public static function change_room($newRoom, $number, $user_id){
        $newRoom = mysql::quote($newRoom);
        $result = lamp::getByNumber($number, $user_id);
        if(count($result) == 0){
            return "You don't have lamp with this identification number.";
        }
        else{
            $sql = "UPDATE lamp SET room = $newRoom WHERE number = $number AND user_id = $user_id";
            mysql::query($sql);
        }
        return "Room changed successfully.";
    }
    public static function change_building($newBuilding, $number, $user_id){
        $newBuilding = mysql::quote($newBuilding);
        $result = lamp::getByNumber($number, $user_id);
        if(count($result) == 0){
            return "You don't have lamp with this identification number.";
        }
        else{
            $sql = "UPDATE lamp SET building = $newBuilding WHERE number = $number AND user_id = $user_id";
            mysql::query($sql);
        }
        return "Building changed successfully.";
    }
}

?>