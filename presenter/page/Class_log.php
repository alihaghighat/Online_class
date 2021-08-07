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
                        <th scope="col">name last name</th>
                        <th scope="col">Data hold</th>
                        <th scope="col">time interval</th>
                        <th scope="col">time duration</th>


                    </tr>
                </thead>
                <tbody>
                <?php
                $gettimeclass=getrecord("tblclassHeld","idclassHeld=$idclassHeld order by idclassHeld desc");
                $getstudent=getrecord("tblstudtClass","idclass=$idclass");
                foreach ($getstudent as $key){
                    $idstudtClass=$key['idstudtClass'];
                    $date=date('Y-M-D',$gettimeclass[0]['starttime']);
                    $stime=$gettimeclass[0]['starttime'];
                    $etime=$gettimeclass[0]['endtime'];
                    $idstudent=$key['idstudent'];
                    $getstudent=getrecord("tblstudent","idstudent=$idstudent");
                    $getonlielog=getrecord("tblstudtClassOnline","idstudtClass=$idstudtClass and idclassHeld=$idclassHeld order by id desc");
                    foreach ($getonlielog as $key1){
                        $date1=date('Y-M-D h:i:sa',$key1['time_srart']);//vrod
                        $date2=date('Y-M-D h:i:sa',$stime);//shroe klas
                        $date3=date('H:i',$key1['time_srart']);//vrod sat
                        $date4=$key1['time_end'];//vrod sat
                        $date5=$key1['time_srart'];//khroj sat

                        $duration=round((($date4-$date5)/60))." min";

                        if($date1>=$date2){
                            echo '<tr>
                                <td>'.$getstudent[0]["name"].' '.$getstudent[0]["lastname"].'</td>
                                <td>'.$date.'</td>
                                <td>'.$date3.'</td>
                                <td>'.$duration.'</td>
   
                            </tr>';
                        }

                    }


                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
