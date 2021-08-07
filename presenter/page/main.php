<?php
include("../../confing.php");
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
} else {
    if (isset($_REQUEST['logout'])) {
        unset($_SESSION['idpresenter']);
        echo '<script>location.reload();</script>';
    }
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
    window.location = 'Class_list';
</script>
<div class="container-fluid">
    <div class="row" style="height: 100%;">
        <div class="col-2">
            <?php include('menu.php'); ?>
        </div>
        <div class="col-10">


        </div>

    </div>
</div>


<style>

</style>