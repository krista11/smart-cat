<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class availableDevices{

    public static function getAll(){
        $sql = "SELECT * FROM available_devices";
        return mysql::select($sql);
    }
    public static function getConnected($id){
        $con = mysql::quote("disconnect");
        $sql = "SELECT * FROM available_devices WHERE connection = $con AND connectedBy = $id";
        return mysql::select($sql);
    }
    public static function updateConnection($connection, $user_id, $id)
    {
        $connection = mysql::quote($connection);
        $user_id = intval($user_id);
        $type = mysql::quote($type);
        $id = intval($id);
        $sql = "UPDATE available_devices set connection = $connection, connectedBy = $user_id WHERE id = $id";
        mysql::query($sql);
    }
    public static function getById($id){
        $id = intval($id);
        $type = mysql::quote($type);
        $sql = "SELECT * FROM available_devices WHERE id = $id";
        return mysql::select($sql);
    }
}