<?php
include("../confing.php");
if(isset($_REQUEST['mic']) and isset($_REQUEST['Wdoard'])){
    $mic=sqi($_REQUEST['mic']);
    $Wdoard=sqi($_REQUEST['Wdoard']);
    $idclass = $_SESSION['class_student'];
    $id = $idclass * 12305;
    $getclassonHoled = getrecord("tblclassHeld", "idclass=$idclass and endtime='0'");
    if (count($getclassonHoled) > 0) {
        $idstaudent=$_SESSION['idstudent'];
        $idclasshold=$getclassonHoled[0]['idclassHeld'];
        $studtClass=getrecord("tblstudtClass","idclass=$idclass and idstudent=$idstaudent");
        $idstudtClass=$studtClass[0]['idstudtClass'];
        $statusstudend=getrecord("tblstudtClassOnline","idclassHeld=$idclasshold and idstudtClass=$idstudtClass order by id desc");
        $mic=$statusstudend[0]['mic']+0;
        $Wboard=$statusstudend[0]['Wboard']+0;
        echo json_encode(array("mic"=>$mic,"Wboard"=>$Wboard))  ;
    }



}else{
    echo 'not ok';
}
?>
