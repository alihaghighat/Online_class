<?php
include("../confing.php");
if(isset($_SESSION['class_student'])) {
    $idclass=sqi($_SESSION['class_student']);
    $getholdeclass=getrecord("tblclassHeld","idclass=$idclass order by idclassHeld desc");
    $idclassHoled=$getholdeclass[0]['idclassHeld'];
   $getrecor=getrecord("tbldataClass","idclassHold=$idclassHoled");
   $temp=str_replace( '\"','"',$getrecor[0]['value']);
   echo $temp ;
}
