<?php
class Lamp_commands{

    public static function getCommands($id){
        $id = intval($id);
        $sql = "SELECT * FROM lamp_commands WHERE id = $id";
        return mysql::select($sql);
    }
}
?>