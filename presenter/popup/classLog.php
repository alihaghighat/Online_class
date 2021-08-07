<?php
include("../../confing.php");
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
}else{
    if(isset($_REQUEST['classToken'])) {
        $classToken = sqi($_REQUEST['classToken']);
        $idclass = $classToken / 12305;
        $_SESSION['class'] = $idclass;
        $getclass=getrecord("tblclass","idclass=$idclass");
    }else{

    }

}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="container-fluid">
    <div class="row" style="height: 100%;">

        <div class="col-12 ">

            <h4>log datile of <?php echo $getclass[0]['name'];?> </h4>

            <table class="table shadow rounded overflow-hidden table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>name</th>
                    <th>Data hold</th>
                    <th>time start</th>
                    <th>time end</th>
                    <th>see datile</th>

                </tr>
                <?php
                $getstudent=getrecord("tblclassHeld","idclass=$idclass order by idclassHeld desc");
                foreach ($getstudent as $key){
                    $date=date('Y-M-D',$key['starttime']);
                    $stime=date('h:i:sa',$key['starttime']);
                    $etime=date('h:i:sa',$key['endtime']);
                    if($key['endtime']==0){
                        $etime='On performing';
                    }

                    echo '<tr>
                                <td>'.$getclass[0]['name'].'</td>
                                <td>'.$date.'</td>
                                <td>'.$stime.'</td>
                                <td>'.$etime.'</td>
                                <td> <a class="btn btn-primary" target="_blank"  href="Class_log?classToken='.($key['idclass']*12305).'&idclassHeld='.$key['idclassHeld'].'"> list box log</a>
                                <a class="btn btn-outline-success" target="_blank" href="Chat_log?classToken='.($key['idclass']*12305).'&idclassHeld='.$key['idclassHeld'].'">chat box log</a>
                                </td>
                                
                                
                                
                            </tr>';
                }
                ?>
                </tbody>
            </table>

        </div>

    </div>
</div>