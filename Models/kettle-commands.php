<?php
class Kettle_commands{

    public static function getCommands($id){
        $id = intval($id);
        $sql = "SELECT * FROM kettle_commands WHERE id = $id";
        return mysql::select($sql);
    }
}
?>