<?php
include("../confing.php");
if(isset($_REQUEST['id'])) {
    $idchat = sqi($_REQUEST['id']);
    $isender = $_SESSION['idstudent'];
    $getchat=getrecord("tblchat","idcat=$idchat");
    $idclassHold=$getchat[0]['idclassHold'];
    $getchatsub=getrecord("tblchat","idclassHold=$idclassHold order by idcat desc");
    $idsub=$getchatsub[0]['idcat'];
    $iduser= $_SESSION['idstudent'];
    updaterecord("tblchat",array("kind_chat"=>1,"subid"=>$idsub),"idcat=$idchat and idsener=$iduser");
    echo $idchat;
}
?>