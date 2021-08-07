<?php
include("../confing.php");
if(isset($_REQUEST['idH'])) {
    $id = sqi($_REQUEST['idH']);
    $getmic = getrecord("tblstudtClassOnline", "idclassHeld=$id order by id desc");
    if ($getmic[0]['Mic_acc'] == 0) {

        echo '';
    } else {
        if($getmic[0]['mic'] == 0){
            echo '<div class="button-place" onclick="MicUpdatePrsenter()" ">
                        <i id="mic-icon" class="bi-mic-mute control-button"></i>
                    </div>';
        }else{
            echo '<div class="button-place" onclick="MicUpdatePrsenter()" ">
                        <i id="mic-icon" class="bi-mic control-button"></i>
                    </div>';
        }

    }
}
?>