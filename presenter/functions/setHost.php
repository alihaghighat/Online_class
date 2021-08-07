<?php
include("../confing.php");
if(isset($_REQUEST['id'])) {
    $id = sqi($_REQUEST['id']);
    $getmic = getrecord("tblstudtClassOnline", "id=$id");
    if ($getmic[0]['Wboard'] == 0) {
        updaterecord("tblstudtClassOnline", array("Wboard" => 1), "id=$id");
        echo 'Host activated';
    } else {
        updaterecord("tblstudtClassOnline", array("Wboard" => 0), "id=$id");
        echo 'Host  disabled';
    }
}
?>