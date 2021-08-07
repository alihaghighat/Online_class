<?php
include("../confing.php");
if(isset($_REQUEST['id'])) {
    $id = sqi($_REQUEST['id']);
    $getmic = getrecord("tblstudtClassOnline", "id=$id");
    if ($getmic[0]['mic'] == 0) {
        updaterecord("tblstudtClassOnline", array("mic" => 1), "id=$id");
        echo 'Microphone activated';
    } else {
        updaterecord("tblstudtClassOnline", array("mic" => 0), "id=$id");
        echo 'Microphone  disabled';
    }
}
?>