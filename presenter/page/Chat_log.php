<?php
include("../../confing.php");
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
}else{
    if(isset($_REQUEST['classToken']) and isset($_REQUEST['idclassHeld'])) {
        $classToken = sqi($_REQUEST['classToken']);
        $idclassHeld=sqi($_REQUEST['idclassHeld']);
        $idclass = $classToken / 12305;
        $gettimeclass=getrecord("tblclassHeld","idclassHeld=$idclassHeld order by idclassHeld desc");
        $time=$gettimeclass[0]['starttime'];
        $date=date('Y-m-d',$time);
        $_SESSION['class'] = $idclass;
        $getclass=getrecord("tblclass","idclass=$idclass");
    }else{

    }

}
?>

<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="../../js/jquery-1.11.2.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>

<link rel="stylesheet" href="../../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">

<div class="container-fluid">
    <div class="row" style="height: 100%;">
        <div class="col-2">
            <?php include('menu.php'); ?>
        </div>
        <div class="col-10 mt-4">

            <h4>log datile of <?php echo $getclass[0]['name'].' '.$date;?> <a onclick="window.close();" class="btn btn-group-toggle btn-danger"> Back</a></h4>

            <table class="table shadow rounded overflow-hidden table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>name last name sender</th>
                    <th>date</th>
                    <th>kind</th>
                    <th>text</th>
                    <th>status</th>
                    <th>scor</th>
                    <th>is clear?</th>


                </tr>
                <?php

                $getchat=getrecord("tblchat","idclassHold=$idclassHeld order by idcat desc");
                foreach ($getchat as $key){
                    $date=date('Y-M-D H:i',$key['time']);
                    if($key['kind_sender']==1){
                        $idsender=$key['idsener'];
                        $getsender=getrecord("tblpresenter","idpresenter=$idsender");
                    }if($key['kind_sender']==2){
                        $idsender=$key['idsener'];
                        $getsender=getrecord("tblstudent","idstudent=$idsender");
                    }
                    if($key['kind_chat']==1 and $key['kind_sender']==1){
                        $kindchat='question';
                    }if($key['kind_chat']==1 and $key['kind_sender']==2){
                        $kindchat='Answer';
                    }if($key['kind_chat']==0 and $key['kind_sender']==1){
                        $kindchat='chat';
                    }if($key['kind_chat']==0 and $key['kind_sender']==2){
                        $kindchat='chat';
                    }
                    if($key['status']==0){
                        $status='normal';
                    }if($key['status']==1){
                        $status='Accept';
                    }if($key['status']==2){
                        $status='Reject';
                    }
                    if($key['dellet']==0){
                        $clear='No';
                    }
                    if($key['dellet']==1){
                        $clear='Yes';
                    }
                    echo '
                        <tr>
                            <td>'.$getsender[0]['name'].'  '.$getsender[0]['lastname'].' </td>
                            <td>'.$date.'</td>
                            <td>'.$kindchat.'</td>
                            <td>'.$key['vlaue'].'</td>
                            <td>'.$status.'</td>
                            <td>'.$key['scor'].'</td>
                            <td>'.$clear.'</td>
        
        
                        </tr>
                    ';

                }
                ?>
                </tbody>
            </table>





        </div>

    </div>
</div>
