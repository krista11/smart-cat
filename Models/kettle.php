<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class Kettle{

    private $id;
    private $number;
    private $temperature;
    private $water;
    private $place;
    private $state;
    private $user_id;

    public function __construct($id, $number, $temperature, $water, $place, $state, $user_id)
    {
        $this->number = $number;
        $this->id = $id;
        $this->temperature = $temperature;
        $this->water = $water;
        $this->place = $place;
        $this->state = $state;
        $this->user_id = $user_id;
    }

    function get_id(){
        return $this->id;
    }
    function set_number($number){
        $this->number = $number;
    }
    function get_number(){
        return $this->number;
    }
    function set_temperature($temperature){
        $this->temperature = $temperature;
    }
    function get_temperature(){
        return $this->temperature;
    }
    function set_water($water){
        $this->water = $water;
    }
    function get_water(){
        return $this->water;
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
    function set_user_id($user_id){
        $this->user_id = $user_id;
    }
    function get_user_id(){
        return $this->user_id;
    }
    function add(Kettle $kettle){
        $number = $kettle->get_number()*1;
        $temperature = $kettle->get_temperature()*1;
        $water = mysql::quote($kettle->get_water());
        $place = mysql::quote($kettle->get_place());
        $state = mysql::quote($kettle->get_state());
        $user_id = $kettle->get_user_id()*1;
        $sql = "INSERT INTO kettle (number, temperature, water, place, state, user_id)
                VALUES($number, $temperature, $water, $place, $state, $user_id)";
        return mysql::query($sql);
    }
    public static function get($user_id){
        $id = $user_id * 1;
        $sql = "SELECT * FROM kettle WHERE user_id = $id ORDER BY number ASC";
        return mysql::select($sql);
    }
}
?>