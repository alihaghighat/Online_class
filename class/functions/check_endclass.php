<?php
include("../confing.php");
if(isset($_REQUEST['idclass'])){
    $idclass=sqi($_REQUEST['idclass']);
    $getclass=getrecord("tblclass","idclass=$idclass");
    $idprzenter=$getclass[0]['idprsenter'];
    $array=array();
    $gettimeclass=getrecord("tblclassHeld","idclass=$idclass and endtime='0' order by idclassHeld desc");
    if(count($gettimeclass)>0){
        echo 1;

    }else{
        unset($_SESSION['class_student']);
        unset($_SESSION['idstudent']);
        echo -1;
    }



}else{
    echo 0;
}
?>
