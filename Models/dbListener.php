<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class dbListener{

    public static function get(){
        $sql = "SELECT * FROM dbListener";
        return mysql::select($sql);
    }
    public static function update(){
        $listener = dbListener::get();
        $id = intval($listener[0]["id"]);
        $number = intval($listener[0]["number"]) + 1;
        $sql = "UPDATE dbListener SET number = $number WHERE id = $id";
        mysql::query($sql);
    }
    public static function clean(){
        $listener = dbListener::get();
        $id = intval($listener[0]["id"]);
        $sql = "UPDATE dbListener SET number = 0 WHERE id = $id";
        mysql::query($sql);
    }
}