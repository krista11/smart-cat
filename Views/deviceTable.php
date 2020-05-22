<?php
session_start();
require_once('Models\lamp.php');
require_once('Models\kettle.php');
require_once('Models\general-device.php');
require_once('Models\lamp-commands.php');
require_once('Models\kettle-commands.php');
require_once('Models\dbListener.php');
function cleanListener(){
    dbListener::clean();
}
function getChangesCounter(){
    $listener = dbListener::get();
    return $listener[0]["number"];
}
function makeTabs(){
    $id =  $_SESSION['user_id']*1;
    $lamps = Lamp::getAll($id);
    $kettles = Kettle::getAll($id);
    $generalDevices = generalDevices::getAll($id);
    if(count($lamps) != 0){?>
        <button id="allTab" class="device_tab active" onclick="openDevice('allTab', 'all')">All</button>
    <?php
    }
    if(count($lamps) != 0){?>
        <button id="lampTab" class="device_tab" onclick="openDevice('lampTab', 'lamp')">Lamp</button>
    <?php
    }
    if(count($kettles) != 0){?>
        <button id="kettleTab" class="device_tab" onclick="openDevice('kettleTab', 'kettle')">Kettle</button>
    <?php
    }
    if(count($generalDevices) != 0){?>
        <button id="generalTab" class="device_tab" onclick="openDevice('generalTab', 'general')">Other</button>
    <?php
    }
}
function makeTable(){
    $id =  $_SESSION['user_id']*1;
    $lamps = Lamp::getAll($id);
    $kettles = Kettle::getAll($id);
    $general = generalDevices::getAll($id);
    $counter = 1;
    ?>
    <div class="pc_table">
    <table id="device" class="allDevices">
        <tr>
            <th>No.</th>
            <th>Type</th>
            <th>No. and Name</th>
            <th>Building</th>
            <th>Room</th>
            <th>State</th>
        </tr>
        <?php
        for($i=0; $i<count($lamps); $i++){
        ?>
        <tr>
            <td><?php echo $counter++; ?></td>
            <td>Lamp</th>
            <td>#<?php echo $lamps[$i]["number"]." ".$lamps[$i]["name"]; ?></td>
            <td><?php echo $lamps[$i]["building"]; ?></td>
            <td><?php echo $lamps[$i]["room"]; ?></td>
            <td><?php echo $lamps[$i]["state"]; ?></td>
        </tr>
        <?php
        }
        for($i=0; $i<count($kettles); $i++){
            ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td>Kettle</td>
                <td>#<?php echo $kettles[$i]["number"]." ".$kettles[$i]["name"]; ?></td>
                <td><?php echo $kettles[$i]["building"]; ?></td>
                <td><?php echo $kettles[$i]["room"]; ?></td>
                <td><?php echo $kettles[$i]["state"]; ?></td>
            </tr>
            <?php
        }
        for($i=0; $i<count($general); $i++){
            ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo $general[$i]["type"]; ?></td>
                <td>#<?php echo $general[$i]["number"]." ".$general[$i]["name"]; ?></td>
                <td><?php echo $general[$i]["building"]; ?></td>
                <td><?php echo $general[$i]["room"]; ?></td>
                <td><?php echo $general[$i]["state"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    </div>
    <?php
}

function makeLampTable(){
    $id =  $_SESSION['user_id']*1;
    $lamps = Lamp::getAll($id);
    if(count($lamps) == 0){
        echo "no lamp";
    }else{
        for($i=0; $i<count($lamps); $i++){
            $commands = Lamp_commands::getCommands($lamps[$i]["id"]);
            $back_color = $lamps[$i]["color"];
            ?>
            <div  class="table-wrapper">
                <table id="device">
                    <tr>
                        <th colspan="2" style="background-color:black; color:white;">Lamp #<?php echo $lamps[$i]["number"]." ".$lamps[$i]["name"]; ?></th>
                    </tr>

                    <?php if($commands[0]["color"] == "1"){ ?>
                    <tr>
                        <td>Color</td>
                        
                        <td><div class="circle" style="background-color:<?php echo $back_color?>"></div><?php echo $back_color ?></td>
                    </tr>
                    <?php } ?>

                    <?php if($commands[0]["brightness"] == "1"){ ?>
                    <tr>
                        <td>Brigthness</td>
                        <td><?php echo $lamps[$i]["brightness"]; ?>%</td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>Building</td>
                        <td><?php echo $lamps[$i]["building"]; ?></td>
                    </tr>
                    <tr>
                        <td>Room</td>
                        <td><?php echo $lamps[$i]["room"]; ?></td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td><?php echo $lamps[$i]["state"]; ?></td>
                    </tr>
                    <tr>
                        <td>The time when the light was last turned on</td>
                        <td><?php echo $lamps[$i]["last_turned_on"]; ?></td>
                    </tr>
                    <tr>
                        <td>How long was the light been on last time</th>
                        <td><?php echo $lamps[$i]["used_time"]; ?></th>
                    </tr>
                </table>
            </div>
        <?php
        }
    }
}

function makeKettleTable(){
    $id =  $_SESSION['user_id']*1;
    $kettles = Kettle::getAll($id);
    if(count($kettles) == 0){
        echo "no kettles";
    }else{
        for($i=0; $i<count($kettles); $i++){?>
            <div class="table-wrapper">
                <table id="device">
                    <tr>
                        <th colspan="2" style="background-color:black; color:white;">Kettle #<?php echo $kettles[$i]["number"]." ".$kettles[$i]["name"]; ?></th>
                    </tr>
                    <tr>
                        <td>Water temperature</td>
                        <td><?php echo $kettles[$i]["temperature"]; ?></td>
                    </tr>
                    <tr>
                        <td>Water level</td>
                        <td><?php echo $kettles[$i]["waterLevel"]; ?></td>
                    </tr>
                    <tr>
                        <td>Building</td>
                        <td><?php echo $kettles[$i]["building"]; ?></td>
                    </tr>
                    <tr>
                        <td>Room</td>
                        <td><?php echo $kettles[$i]["room"]; ?></td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td><?php echo $kettles[$i]["state"]; ?></td>
                    </tr>

                </table>
            </div>
        <?php
        }
    }
}
function makeGeneralTable(){
    $id =  $_SESSION['user_id']*1;
    $devices = generalDevices::getAll($id);
    if(count($devices) == 0){
        echo "no general devices";
    }else{
        for($i=0; $i<count($devices); $i++){?>
            <div class="general-devices-table">
                <table id="device">
                    <tr>
                        <th colspan="2" style="background-color:black; color:white;">#<?php echo $devices[$i]["number"]." ".$devices[$i]["name"]; ?></th>
                    </tr>
                    <tr>
                        <td>Type</td>
                        <td><?php echo $devices[$i]["type"]; ?></td>
                    </tr>
                    <tr>
                        <td>Building</td>
                        <td><?php echo $devices[$i]["building"]; ?></td>
                    </tr>
                    <tr>
                        <td>Room</td>
                        <td><?php echo $devices[$i]["room"]; ?></td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td><?php echo $devices[$i]["state"]; ?></td>
                    </tr>
                </table>
                
            </div>
            <?php
        }
    }
}
?>