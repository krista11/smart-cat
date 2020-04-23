<?php
require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
class User{

    private $id;
    private $code;
    private $email;
    private $phrase;

    public function __construct($id, $code, $email, $phrase)
    {
        $this->id = $id;
        $this->code = $code;
        $this->email = $email;
        $this->phrase = $phrase;
    }

    function get_id(){
        return $this->id;
    }
    function set_code($code){
        $this->code = $code;
    }
    function get_code(){
        return $this->code;
    }
    function set_email($email){
        $this->email = $email;
    }
    function get_email(){
        return $this->email;
    }
    function set_phrase($phrase){
        $this->phrase = $phrase;
    }
    function get_phrase(){
        return $this->phrase;
    }
    public static function updateUser(User $user)
    {   
        $id = $user->get_id();
        $phrase = mysql::quote($user->get_phrase());
        $email = mysql::quote($user->get_email());
        $sql = "UPDATE user SET phrase = $phrase, email = $email WHERE id = $id";
        return mysql::query($sql);
    }
}
?>