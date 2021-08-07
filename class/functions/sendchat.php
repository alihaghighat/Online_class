<?php
include("../confing.php");
if(isset($_REQUEST['typedText'])) {
    $value = sqi($_REQUEST['typedText']);
    $idclass=sqi($_SESSION['class_student']);
    $isender = sqi($_SESSION['idstudent']);
    $time = time();
    $getidclassHold=getrecord("tblclassHeld","idclass=$idclass and endtime='0' order by idclassHeld desc");
    $idclassHold= $getidclassHold[0]['idclassHeld'];
    addrecored("tblchat",array("kind_sender"=>2,"idsener"=>$isender,"time"=>$time,"idclassHold"=>$idclassHold,"vlaue"=>$value));
    echo $idclass;
}
?>