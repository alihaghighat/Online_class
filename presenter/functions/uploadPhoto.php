<?php include('../confing.php');
if (isset($_FILES['photo-file']) && $_FILES['photo-file']['name'] != '' && $_FILES['photo-file']['size'] != 0) {
    $file_name = $_FILES['photo-file']['name'];
    $file_size = $_FILES['photo-file']['size'];
    $file_tmp = $_FILES['photo-file']['tmp_name'];
    $file_type = $_FILES['photo-file']['type'];
    $files = $_FILES['photo-file']['name'];
    $files = explode('.', $files);
    $file_ext = strtolower(end($files));
    $extensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
    if (in_array($file_ext, $extensions) === false) {
        echo "false";
        return;
    }
    $folder = "../assets/";
    move_uploaded_file($file_tmp, $folder . $file_name);
    echo 'assets/' . $file_name;
    return;
}
