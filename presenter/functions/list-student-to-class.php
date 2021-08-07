<?php
include("../confing.php");
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("login/login")</script>';
}else{
    if(isset($_REQUEST['idcalss'])){
        $idclass=sqi($_REQUEST['idcalss']);
        $name=sqi($_REQUEST['name']);
        $getclass=getrecord("tblclass","idclass=$idclass");
        if(count($getclass)>0){
            if(isset($_REQUEST['idstude']) and isset($_REQUEST['actions']) and $_REQUEST['actions']=='Bluck' ){

                $idstudents=$_REQUEST['idstude'];
                $getstudent_of_class=getrecord("tblstudtClass","idclass=$idclass and idstudent=$idstudents");
                if(count($getstudent_of_class)>0){
                    updaterecord("tblstudtClass",array("kind"=>-1),"idclass=$idclass and idstudent=$idstudents");
                 echo 'Successfully Blucked';
                }else{
                    echo'You have not chosen any student for the class';
                }


            }else{
                if(isset($_REQUEST['idstude']) and isset($_REQUEST['actions']) and $_REQUEST['actions']=='unBluck' ){

                    $idstudents=$_REQUEST['idstude'];
                    $getstudent_of_class=getrecord("tblstudtClass","idclass=$idclass and idstudent=$idstudents");
                    if(count($getstudent_of_class)>0){
                        updaterecord("tblstudtClass",array("kind"=>1),"idclass=$idclass and idstudent=$idstudents");
                        echo'Successfully Blucked';
                    }else{
                        echo'You have not chosen any student for the class';
                    }


                }
            }



        }else{

        }

    }else{
        if(isset($_REQUEST['student'])){

        }else{

        }

    }

}
?>