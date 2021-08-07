<?php
include("../confing.php");
if(isset($_REQUEST['idclass'])) {
    $idclass = sqi($_REQUEST['idclass']);
    $getidclassHold=getrecord("tblclassHeld","idclass=$idclass and endtime='0' order by idclassHeld desc");
    $idclassHold= $getidclassHold[0]['idclassHeld'];
    updaterecord("tblchat",array("dellet"=>1),"idclassHold=$idclassHold");
    echo $idclass;
}
?>