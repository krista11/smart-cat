<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class Lamp{

    private $id;
    private $name;
    private $number;
    private $brightness;
    private $color;
    private $place;
    private $state;
    private $last_turned_on;
    private $used_time;
    private $user_id;
    private $commands;

    public function __construct($id, $name, $number, $brightness, $color, $place, $state, $last_turned_on, $used_time, $user_id, $commands)
    {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
        $this->brightness = $brightness;
        $this->color = $color;
        $this->place = $place;
        $this->state = $state;
        $this->last_turned_on = $last_turned_on;
        $this->used_time = $used_time;
        $this->user_id = $user_id;
        $this->commands = $commands;
    }

    function get_id(){
        return $this->id;
    }
    function get_name(){
        return $this->name;
    }
    function set_name($name){
        $this->name = $name;
    }
    function set_number($number){
        $this->number = $number;
    }
    function get_number(){
        return $this->number;
    }
    function set_brightness($brightness){
        $this->brightness = $brightness;
    }
    function get_brightness(){
        return $this->brightness;
    }
    function set_color($color){
        $this->color = $color;
    }
    function get_color(){
        return $this->color;
    }
    function set_place($place){
        $this->place = $place;
    }
    function get_place(){
        return $this->place;
    }
    function set_state($state){
        $this->state = $state;
    }
    function get_state(){
        return $this->state;
    }
    function set_last_turned_on($last_turned_on){
        $this->last_turned_on = $last_turned_on;
    }
    function get_last_turned_on(){
        return $this->last_turned_on;
    }
    function set_used_time($used_time){
        $this->used_time = $used_time;
    }
    function get_used_time(){
        return $this->used_time;
    }
    function set_user_id($user_id){
        $this->user_id = $user_id;
    }
    function get_user_id(){
        return $this->user_id;
    }
    public static function add(Lamp $lamp){
        $number = $lamp->get_number()*1;
        $name = mysql::quote($lamp->get_name());
        $brightness = $lamp->get_brightness()*1;
        $color = mysql::quote($lamp->get_color());
        $place = mysql::quote($lamp->get_place());
        $state = mysql::quote($lamp->get_state());
        $last_turned_on = mysql::quote($lamp->get_last_turned_on());
        $used_time = mysql::quote($lamp->get_used_time());
        $user_id = $lamp->get_user_id()*1;
        $sql = "INSERT INTO lamp (number, brightness, color, place, state, last_turned_on, used_time, user_id, name)
                VALUES($number, $brightness, $color, $place, $state, $last_turned_on, $used_time, $user_id, $name)";
        return mysql::query($sql);
    }
    public static function get($user_id){
        $id = $user_id * 1;
        $con = mysql::quote("disconnect");
        $sql = "SELECT * FROM lamp WHERE user_id = $id AND connection = $con ORDER BY number ASC";
        return mysql::select($sql);
    }
}
class Lamp_commands{
    private $state;
    private $color;
    private $brightness;

    public function __construct($state, $color, $brightness){
        $this->state = $state;
        $this->color = $color;
        $this->brightness = $brightness;
    }
    function set_state($state){
        $this->state = $state;
    }
    function get_state(){
        return $this->state;
    }
    function set_color($color){
        $this->color = $color;
    }
    function get_color(){
        return $this->color;
    }
    function set_brightness($brightness){
        $this->brightness = $brightness;
    }
    function get_brightness(){
        return $this->brightness;
    }
    public static function getCommands($device_id){
        $id = intval($device_id);
        $sql = "SELECT * FROM lamp_commands WHERE device_id = $id";
        return mysql::select($sql);
    }
}
?>