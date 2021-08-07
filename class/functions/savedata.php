<?php
include("../confing.php");
if(isset($_REQUEST['coordinates1'])) {
    $value=sqi($_REQUEST['coordinates1']);
    $idclass=$_SESSION['class_student'];
    $getholdeclass=getrecord("tblclassHeld","idclass=$idclass order by idclassHeld desc");
    $idclassHoled=$getholdeclass[0]['idclassHeld'];
    $getrecor=getrecord("tbldataClass","idclassHold=$idclassHoled");
    if(count($getrecor)>0){
        updaterecord("tbldataClass",array("value"=>$value),"idclassHold=$idclassHoled");
    }else{
        addrecored("tbldataClass",array("value"=>$value,"idclassHold"=>$idclassHoled));
    }
    echo $_REQUEST['coordinates1'];
}
?>