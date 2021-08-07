<?php
include("../../confing.php");
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
} else {
    if (isset($_REQUEST['idcalss']) and isset($_REQUEST['name'])) {
        $idclass = sqi($_REQUEST['idcalss']);
        $name = sqi($_REQUEST['name']);
        $getclass = getrecord("tblclass", "idclass=$idclass");
        if (count($getclass) > 0) {
            if (isset($_REQUEST['idstude']) and isset($_REQUEST['actions']) and $_REQUEST['actions'] == 'Block') {

                $idstudents = $_REQUEST['idstude'];
                $getstudent_of_class = getrecord("tblstudtClass", "idclass=$idclass and idstudent=$idstudents");
                if (count($getstudent_of_class) > 0) {
                    updaterecord("tblstudtClass", array("kind" => -1), "idclass=$idclass and idstudent=$idstudents");
                    $msg = '<div class="alert-danger">Successfully Blocked</div>';
                } else {
                    $msg = '<div class="alert-danger">You have not chosen any student for the class</div>';
                }
            } else {
                if (isset($_REQUEST['idstude']) and isset($_REQUEST['actions']) and $_REQUEST['actions'] == 'unBlock') {

                    $idstudents = $_REQUEST['idstude'];
                    $getstudent_of_class = getrecord("tblstudtClass", "idclass=$idclass and idstudent=$idstudents");
                    if (count($getstudent_of_class) > 0) {
                        updaterecord("tblstudtClass", array("kind" => 1), "idclass=$idclass and idstudent=$idstudents");
                        $msg = '<div class="alert-danger">Successfully Blocked</div>';
                    } else {
                        $msg = '<div class="alert-danger rounded p-2">You have not chosen any student for the class</div>';
                    }
                }
            }
        }
    }
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="container-fluid">
    <div class="row" style="height: 100%;">

        <div class="col-12 mt-4">

            <h4>log datile of <?php echo $getclass[0]['name'] . ' ' . $date; ?> </h4>

            <table class="table shadow rounded overflow-hidden table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>name lastname</th>
                        <th>user name</th>
                        <th>phone</th>
                        <th>kind</th>
                        <th>options</th>

                    </tr>

                    <?php
                    $getstudent = getrecord("tblstudent", "1 order by idstudent desc");
                    foreach ($getstudent as $key) {
                        $idstident = $key['idstudent'];
                        $getstudent_of_class = getrecord("tblstudtClass", "idstudent=$idstident and idclass=$idclass");
                        if (count($getstudent_of_class) > 0) {

                            if ($getstudent_of_class[0]['kind'] == 1) {
                                $kind = 'ok';
                            }
                            if ($getstudent_of_class[0]['kind'] == -1) {
                                $kind = 'bluck';
                            }
                            echo '<tr>
                                <td>' . $key["name"] . ' ' . $key["lastname"] . '</td>
                                <td>' . $key["username"] . '</td>
                                <td>' . $key["phone"] . '</td>
                                <td>' . $kind . '</td>';
                            if ($getstudent_of_class[0]['kind'] == 1) {
                                echo '<td><a class="btn btn-danger" onclick="BulckStudentToClass(' . $idstident . ')" >block</a></td>';
                            } else {
                                echo '<td><a class="btn btn-primary" onclick="UnBulckStudentToClass(' . $idstident . ')">unblock</a></td>';
                            }
                            echo '</tr>';
                        } else {
                        }
                    }
                    ?>
                    </tbody>
            </table>





        </div>

    </div>
</div>
<script>
    function BulckStudentToClass(id) {



        $.ajax({
            url: '../functions/list-student-to-class.php',
            type: "POST",

            data: {
                'idcalss': <?php echo $_REQUEST['idcalss'] ?>,
                'idstude': id,
                'actions': 'Bluck',

            },
            success: function(data) {
                showSuccessAlert(data);
                location.reload();


            }

        });

    }

    function UnBulckStudentToClass(id) {



        $.ajax({
            url: '../functions/list-student-to-class.php',
            type: "POST",

            data: {
                'idcalss': <?php echo $_REQUEST['idcalss'] ?>,
                'idstude': id,
                'actions': 'unBluck',

            },
            success: function(data) {
                showSuccessAlert(data);
                location.reload();


            }

        });

    }
</script>