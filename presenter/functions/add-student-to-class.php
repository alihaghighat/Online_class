<?php include('../confing.php');
if (isset($_REQUEST['idclass'])) {
    $idclass = sqi($_REQUEST['idclass']);

    $getclass = getrecord("tblclass", "idclass=$idclass");
    if (count($getclass) > 0) {
        if (isset($_REQUEST['students'])) {
            $idstudents = json_decode($_REQUEST['students']);
            if (count($idstudents) == 0) {
                $msg = 'You have not chosen any student for the class';
            } else {
                $N = count($idstudents);


                for ($i = 0; $i < $N; $i++) {
                    $d = addrecored("tblstudtClass", array("idstudent" => $idstudents[$i], "idclass" => $idclass));

                    $msg = $msg . 'Successfully add';
                }
            }
            echo $msg;
        } else {
            echo "hi";
        }
    } else {

        echo '<script>alert("Parameter submission error");location.replace("Class_list")</script>';
    }
} else {
    if (isset($_REQUEST['student'])) {
    } else {
        echo '<script>location.replace("login/login")</script>';
    }
}
