<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class User_log{

    public static function addRequest($id, $request)
    {   
        $_id = intval($id);
        $_request = mysql::quote($request);
        date_default_timezone_set('Europe/Vilnius');
        $date = date("Y-m-d H:i:s");
        $_date = mysql::quote($date);
        $sql = "INSERT INTO user_log (user_id, request_text, date) VALUES ($id, $_request, $_date)";
        return mysql::query($sql);
    }
    public static function get($id){
        $_id = intval($id);
        $sql = "SELECT * FROM user_log WHERE user_id = $_id ORDER BY id DESC";
        return mysql::select($sql);
    }
    public static function delete(){
        date_default_timezone_set('Europe/Vilnius');
        $date = date("Y-m-d H:i:s", strtotime("-1 day"));
        $_date = mysql::quote($date);
        $sql = "DELETE FROM user_log WHERE date < $_date";
        $result = mysql::query($sql);
    }
}
?>