<?php
include("../confing.php");
if(isset($_SESSION['class'])) {
    $idclass=sqi($_SESSION['class']);
    $getholdeclass=getrecord("tblclassHeld","idclass=$idclass order by idclassHeld desc");
    $idclassHoled=$getholdeclass[0]['idclassHeld'];
   $getrecor=getrecord("tbldataClass","idclassHold=$idclassHoled");
   $temp=str_replace( '\"','"',$getrecor[0]['value']);
   echo $temp ;
}
