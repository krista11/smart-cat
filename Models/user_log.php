<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class User_log{

    private $id;
    private $user_id;
    private $request_text;
    private $date;

    public function __construct($id, $user_id, $request_text, $date)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->request_text = $request_text;
        $this->date = $date;
    }

    function get_id(){
        return $this->id;
    }
    function set_user_id($user_id){
        $this->user_id = $user_id;
    }
    function get_user_id(){
        return $this->user_id;
    }
    function set_request_text($text){
        $this->request_text = $text;
    }
    function get_request_text(){
        return $this->request_text;
    }
    function set_date($date){
        $this->date = $date;
    }
    function get_date(){
        return $this->date;
    }
    public static function addRequest($id, $request)
    {   
        $_id = $id * 1;
        $_request = mysql::quote($request);
        date_default_timezone_set('Europe/Vilnius');
        $date = date("Y-m-d H:i:s");
        $_date = mysql::quote($date);
        $sql = "INSERT INTO user_log (user_id, request_text, date) VALUES ($id, $_request, $_date)";
        return mysql::query($sql);
    }
    public static function get($id){
        $sql = "SELECT * FROM user_log WHERE user_id = $id ORDER BY id DESC";
        return mysql::select($sql);
    }
    public static function delete(){
        date_default_timezone_set('Europe/Vilnius');
        $date = date("Y-m-d H:i:s", strtotime("-1 day"));
        $_date = mysql::quote($date);
        $sql = "DELETE FROM user_log WHERE  date < $date";
    }
}
?>