<?php
include("../../confing.php");
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
} else {
    if (isset($_REQUEST['idclass']) and isset($_REQUEST['name'])) {
        $idclass = sqi($_REQUEST['idclass']);
        $name = sqi($_REQUEST['name']);
        $getclass = getrecord("tblclass", "idclass=$idclass");
        if (count($getclass) > 0) {
            if (isset($_REQUEST['student'])) {
                $idstudents = $_REQUEST['student'];
                if (count($idstudents) == 0) {
                    $msg = 'You have not chosen any student for the class';
                } else {
                    $N = count($idstudents);


                    for ($i = 0; $i < $N; $i++) {
                        $d = addrecored("tblstudtClass", array("idstudent" => $idstudents[$i], "idclass" => $idclass));


                        $msg = $msg . 'Successfully add ';
                    }
                }
            } else {
            }
        } else {

            echo '<script>alert("Parameter submission error");location.replace("../page/Class_list")</script>';
        }
    } else {
        if (isset($_REQUEST['student'])) {
        } else {
            echo '<script>location.replace("../login/login")</script>';
        }
    }
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="container-fluid">
    <div class="row" style="height: 100%;">

        <div class="col-12 mt-4">

            <h4>add student to <?php echo $getclass[0]['name'] . '-' . $getclass[0]['time_start'] . ' - ' . $getclass[0]['time_end'] ?> </h4>

            <table class="table shadow rounded overflow-hidden table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>name lastname</th>
                        <th>user name</th>
                        <th>phone</th>
                        <th>check box</th>

                    </tr>
                    <form id="form">
                        <?php
                        $getstudent = getrecord("tblstudent", "1 order by idstudent desc");
                        foreach ($getstudent as $key) {
                            $idstident = $key['idstudent'];
                            $getstudent_of_class = getrecord("tblstudtClass", "idstudent=$idstident and idclass=$idclass");
                            if (count($getstudent_of_class) > 0) {
                            } else {
                                echo '<tr>
                                <td>' . $key["name"] . ' ' . $key["lastname"] . '</td>
                                <td>' . $key["username"] . '</td>
                                <td>' . $key["phone"] . '</td>
                                <td><input name="student" class="student" type="checkbox" value="' . $key["idstudent"] . '"></td>
                               
                            </tr>';
                            }
                        }
                        ?>
                        <tr>
                            <td><input type="hidden" name="idclass" value="<?php echo $idclass; ?>">
                                <input type="hidden" name="name" value="<?php echo $getclass[0]['name']; ?>">
                                <button onclick="addStudentToClass()" class="btn btn-primary">Add +</button></>
                        </tr>
                    </form>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function addStudentToClass() {


        var checkedStudents = [];
        $('.student').each(function() {
            if (this.checked) {

                checkedStudents.push($(this).val())
            }
        })


        var stringed = JSON.stringify(checkedStudents);


        $.ajax({
            url: '../functions/add-student-to-class.php',
            type: "POST",

            data: {
                'idclass': <?php echo $_REQUEST['idclass'] ?>,
                'students': stringed,

            },
            success: function(data) {
                alert(data);
                location.replace("../page/Class_list");
            }

        });

    }
</script>