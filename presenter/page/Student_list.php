<?php
include("../../confing.php");
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
} else {
    $msg = '';
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

            <h4>Student List</h4>

            <table class="table shadow rounded overflow-hidden table-hover mt-4">
                <thead class="thead-dark">


                    <tr>
                        <th>#</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Data Cretee</th>
                        <th>username</th>
                        <th>phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getstudent = getrecord("tblstudent", "1 order by idstudent desc");
                    $i = 0;
                    foreach ($getstudent as $key) {
                        $i++;
                        echo '<tr>
                                <td>' . $i . '</td>
                                <td>' . $key["name"] . '</td>
                                <td>' . $key["lastname"] . '</td>
                                <td>' . $key["date_cratee"] . '</td>
                                <td>' . $key["username"] . '</td>
                                <td>' . $key["phone"] . '</td>
                                
                                
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>