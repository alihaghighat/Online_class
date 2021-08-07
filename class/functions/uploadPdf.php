<?php include('../confing.php');
if (isset($_FILES['pdf-file']) && $_FILES['pdf-file']['name'] != '' && $_FILES['pdf-file']['size'] != 0) {
    $file_name = $_FILES['pdf-file']['name'];
    $file_size = $_FILES['pdf-file']['size'];
    $file_tmp = $_FILES['pdf-file']['tmp_name'];
    $file_type = $_FILES['pdf-file']['type'];
    $files = $_FILES['pdf-file']['name'];
    $files = explode('.', $files);
    $file_ext = strtolower(end($files));
    if ($file_ext != 'pdf') {
        echo "false";
        return;
    }
    $folder = "../assets/";
    move_uploaded_file($file_tmp, $folder . $file_name);
    echo 'assets/' . $file_name;
    return;
}
