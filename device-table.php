<?php
function makeTable(){
    include "deviceController.php";
    $devices = getDevices();

    for($i=0; $i < count($devices); $i++){?>
        <tr>
            <th><?php echo $i+1; ?></th>
            <th><?php echo $devices[$i]->get_device()?></th>
            <th><?php echo $devices[$i]->get_state()?></th>
            <th><?php echo $devices[$i]->get_place()?></th>
        </tr>
    <?php
    }
}
?>
