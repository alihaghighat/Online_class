<?php
include("../confing.php");
if(isset($_REQUEST['typedText']) and isset($_REQUEST['classToken'])) {
    $value = sqi($_REQUEST['typedText']);
    $classToken=sqi($_REQUEST['classToken']);
    $idclass=$classToken/12305;
    $isender = $_SESSION['idpresenter'];
    $time = time();
    $getidclassHold=getrecord("tblclassHeld","idclass=$idclass and endtime='0' order by idclassHeld desc");
    $idclassHold= $getidclassHold[0]['idclassHeld'];
    addrecored("tblchat",array("kind_sender"=>1,"idsener"=>$isender,"time"=>$time,"idclassHold"=>$idclassHold,"vlaue"=>$value));
    echo $getidclassHold[0]['idclassHeld'];
}
?>