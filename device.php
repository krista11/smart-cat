<?php
class Device{

    private $id;
    private $device;
    private $state;
    private $place;
    private $brain;

    function set_device($device){
        $this->device = $device;
    }
    function get_device(){
        return $this->device;
    }
    function set_state($state){
        $this->state = $state;
    }
    function get_state(){
        return $this->state;
    }
    function set_place($place){
        $this->place = $place;
    }
    function get_place(){
        return $this->place;
    }
    function set_brain($brain){
        $this->brain = $brain;
    }
    function get_brain(){
        return $this->brain;
    }

}


?>