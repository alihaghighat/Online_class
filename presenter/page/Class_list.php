<?php
include("../../confing.php");
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
} else {
    $msg = '';
    $idprsenter = $_SESSION['idpresenter'];
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="../../js/jquery-1.11.2.min.js"></script>
<!-- <script src="../../js/jquery.form.js"></script>
<script src="../../js/popper.min.js"></script> -->

<!-- <script src="../../js/test.js"></script> -->
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
        <div class="col-10">

            <h4>My Classes</h4>

            <table class="table shadow rounded overflow-hidden table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Start - End Time</th>
                        <th scope="col">Week Days</th>
                        <th scope="col">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getstudent = getrecord("tblclass", "idprsenter=$idprsenter order by idclass desc");
                    $i = 0;
                    foreach ($getstudent as $key) {
                        $i++;
                        $dayWeek = explode("!", $key['dayweek']);
                        $dayWeekShort = '';
                        foreach ($dayWeek as $day) {
                            if ($dayWeekShort == '') {
                                $dayWeekShort = $dayWeekShort . substr($day, 0, 3);
                            } else {
                                $dayWeekShort = $dayWeekShort . "-" . substr($day, 0, 3);
                            }
                        }

                        echo '<tr>
                                <td> ' . $i . '</td>
                                <td>' . $key["name"] . '</td>
                                <td>' . substr($key["date_cratee"], 0, 11) . '</td>
                                <td>' . $key["time_start"] . ' - ' . $key['time_end'] . '</td>
                                <td>' . $dayWeekShort . '</td>
                                <th> 
                                <div class="btn-group btn-group-toggle">
                                <button class="btn btn-info" onclick="addStudentToClass1(' . $key['idclass'] . ',' . "'" . $key['name'] . "'" . ')">Add Students</button>
                                <button class="btn btn-secondary" onclick="StudentToClass(' . $key['idclass'] . ',' . "'" . $key['name'] . "'" . ')"> Students</button>
                                <a class="btn btn-dark" target="_blank" href="http://project-web-shu.ir/class/login?classToken=' . ($key['idclass'] * 12305) . '"> Join link</a>
                                 <a class="btn btn-success" target="_blank" href="../index?classToken=' . ($key['idclass'] * 12305) . '"> Start Class</a>
                                 <button class="btn btn-warning"  onclick="Log(' . ($key['idclass'] * 12305) . ')" > Logs</button>
                                 </div>
                                </th>
                                
                                
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>

            <button class="btn btn-success float-right mr-3" onclick="openLink('page/Add_class')">New Class <i class="bi-plus"></i></button>





        </div>

    </div>
</div>
<script>
    function showLinkInPopUp(url, data) {
        $.ajax({
            url: "../" + url,
            type: 'post',
            data: data,
            success: function(data) {
                shpopup('', data);
            }
        });
    }

    function addStudentToClass1(idclass, name) {
        showLinkInPopUp('popup/addStudentToClass', {
            'idclass': idclass,
            'name': name
        });
    }

    function StudentToClass(idclass, name) {

        showLinkInPopUp('popup/listStudentOfClass', {
            'idcalss': idclass,
            'name': name
        });
    }

    function Log(idclass) {
        showLinkInPopUp('popup/classLog', {
            'classToken': idclass
        });
    }
</script>