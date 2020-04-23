<?php
session_start();
require_once('Models\lamp.php');
require_once('Models\kettle.php');

function makeTabs(){
    $id =  $_SESSION['user_id']*1;
    $lamps = Lamp::get($id);
    $kettles = Kettle::get($id);
    if($lamps != FALSE){?>
        <button id="lampTab" class="device_tab" onclick="openDevice('lampTab', 'lamp')">Lamp</button>
    <?php
    }
    if($kettles != FALSE){?>
        <button id="kettleTab" class="device_tab" onclick="openDevice('kettleTab', 'kettle')">Kettle</button>
    <?php
    }
}

function makeLampTable(){
    $id =  $_SESSION['user_id']*1;
    $lamps = Lamp::get($id);
    if($lamps == FALSE){
        echo "no lamp";
    }else{
        for($i=0; $i<count($lamps); $i++){
            $back_color = $lamps[$i]["color"];
            $color = "white";
            if($back_color == "white" || $back_color == "yellow"){
                $color = "black";
            }
            ?>
            <div id="lamp" class="table-wrapper">
                <table id="device">
                    <tr>
                        <th style="background-color:black; color:white;">Lamp #<?php echo $lamps[$i]["number"]; ?></th>
                    </tr>
                    <tr>
                        <th>Color</th>
                        <th style="background-color: <?php echo $back_color?>; color: <?php echo $color?>"><?php echo $lamps[$i]["color"] ?></th>
                    </tr>
                    <tr>
                        <th>Brigthness</th>
                        <th><?php echo $lamps[$i]["brightness"]; ?>%</th>
                    </tr>
                    <tr>
                        <th>Place</th>
                        <th><?php echo $lamps[$i]["place"]; ?></th>
                    </tr>
                    <tr>
                        <th>State</th>
                        <th><?php echo $lamps[$i]["state"]; ?></th>
                    </tr>
                    <tr>
                        <th>The time when the light was last turned on</th>
                        <th><?php echo $lamps[$i]["last_turned_on"]; ?></th>
                    </tr>
                    <tr>
                        <th>How long was the light been on last time</th>
                        <th><?php echo $lamps[$i]["used_time"]; ?></th>
                    </tr>
                </table>
            </div>
        <?php
        }
    }
}

function makeKettleTable(){
    $id =  $_SESSION['user_id']*1;
    $kettles = Kettle::get($id);
    if($kettles == FALSE){
        echo "no kettles";
    }else{
        for($i=0; $i<count($kettles); $i++){?>
            <div $id="kettle" class="table-wrapper">
                <table id="device">
                    <tr>
                        <th style="background-color:black; color:white;">Kettle #<?php echo $kettles[$i]["number"]; ?></th>
                    </tr>
                    <tr>
                        <th>Water temperature</th>
                        <th><?php echo $kettles[$i]["temperature"]; ?></th>
                    </tr>
                    <tr>
                        <th>Water level</th>
                        <th><?php echo $kettles[$i]["water"]; ?></th>
                    </tr>
                    <tr>
                        <th>Place</th>
                        <th><?php echo $kettles[$i]["place"]; ?></th>
                    </tr>
                    <tr>
                        <th>State</th>
                        <th><?php echo $kettles[$i]["state"]; ?></th>
                    </tr>
                </table>
            </div>


        <?php
        }
    }
}
?>