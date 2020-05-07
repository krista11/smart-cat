<?php
require_once('Models\user_log.php');
function makeActionLogTable(){
    $id =  $_SESSION['user_id']*1;
    User_log::delete();
    $actions = User_log::get($id);
    ?>
    
    <table>
        <tr>
            <th>Nr.</th>
            <th>Action</th>
            <th>Date</th>
        </tr>
    <?php
    for($i=0; $i < count($actions); $i++){?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $actions[$i]["request_text"]; ?></td>
            <td><?php echo $actions[$i]["date"]; ?></td>
        </tr>
    <?php
    }
    ?>
    </table>
<?php
}
?>