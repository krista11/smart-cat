<?php
require_once('..\Models\user.php');
class userController{
    //patikrina ar egzistuoja vartotojas
    public static function checkUser($code)
    {
        $parts = explode('/', $code);
        $code = mysql::quote($parts[1]);
        $sql = "SELECT * FROM user WHERE code = $code";
        $result = mysql::select($sql);
        if(sizeof($result) == 0){
            return $result = userController::addUser($code);
        }
        return intval($result[0]["id"]);
    }
    public static function addUser($code)
    {
        $sql = "INSERT INTO user (code) VALUES ($code)";
        mysql::query($sql);
        $sql = "SELECT id FROM user WHERE code = $code";
        $result = mysql::select($sql);
        return intval($result[0]["id"]);
    }
}

?>