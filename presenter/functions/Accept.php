<?php
include("../confing.php");
if(isset($_REQUEST['id'])) {
    $idchat = sqi($_REQUEST['id']);
    $isender = $_SESSION['idpresenter'];
    updaterecord("tblchat",array("status"=>1),"idcat=$idchat");
    echo $idchat;
}
?>