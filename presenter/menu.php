<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>
<link rel="stylesheet" href="../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
<?php
$presenter = getrecord("tblpresenter", "idpresenter = $_SESSION[idpresenter]")[0];
$presenterName = $presenter['name'] . " " . $presenter['lastname'];
?>
<div class="menu shadow">
    <div class="menu-header">
        <img src="assets/defaults/mountain1.jpg" style="width: 100%;" />
        <div class="user-avatar">
            <div class="avatar-place shadow"></div>
            <div class="user-name"><?php echo $presenterName ?></div>
        </div>
    </div>
    <div class="menu-body">



        <?php
        $getme = getrecord("tblmenu", "kind=1 and subid=0");
        foreach ($getme as $key) {
            echo '<div class="head-item">' . $key["vlaue"] . '</div>';
            $idmenu = $key['idmenu'];
            $submenu = getrecord("tblmenu", "kind=1 and subid=$idmenu");
            if (count($submenu) > 0) {
                echo '';
                foreach ($submenu as $key1) {
                    echo '<div class="sub-item"><div onclick="openLink(' . "'" . $key1["url"] . "'" . ')" >' . $key1["vlaue"] . '</div></div>';
                }
                echo '';
            }
        }
        ?>
        <div class="logout-btn" onclick="openLink('?logout=1')"><i class="bi-power"></i> logout</div>


    </div>



</div>

<script>
    function openLink(url) {
        window.location = url;
    }
</script>
<style>
    .menu {


        height: 100%;
        background-color: #364254;
    }

    .col-2 {
        padding: 0px !important;
    }

    .menu-header {
        height: 260px;
        background-image: url("");

    }

    .user-avatar {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;


        position: absolute;
        margin-top: -50%;
        margin-left: 50%;
    }

    .avatar-place {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin-left: -70px;
        margin-top: -40px;
        background-color: whitesmoke;
    }

    .user-name {
        margin-left: -70px;
        color: whitesmoke;
        margin-top: 10px;
        font-size: 16px;

    }

    .menu-body {
        display: flex;
        flex-direction: column;
        width: 100%;
        padding: 10px 20px;
        color: whitesmoke;



    }

    .head-item {
        margin-top: 15px;
        padding: 15px 5px;

    }

    .sub-item {

        margin-left: 8px;
        margin-top: 10px;
        padding: 15px 5px;
        border-bottom: 1px solid #5a6373;
        border-radius: 10px;
    }



    .sub-item:hover {
        animation: sub-item-hover .3s forwards;
        cursor: pointer;
    }



    @keyframes sub-item-hover {
        from {
            background-color: #364254;
        }

        to {
            background-color: #7b8dad;
        }

    }

    .logout-btn {
        margin-left: 0 !important;
        color: #dc3545;
        margin-top: 10px;
        padding: 15px 5px;
        border-bottom: 1px solid #5a6373;
        border-radius: 10px;
    }

    .logout-btn:hover {
        animation: logout-btn-hover .3s forwards;
        cursor: pointer;
    }


    @keyframes logout-btn-hover {
        from {
            background-color: #364254;
            color: #dc3545;
        }

        to {
            color: #fff;
            background-color: #dc3545;
        }

    }
</style>


<div class="modal fade" id="modd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="head"></div>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"> لغو </button>
            </div>
        </div>
    </div>
</div>

<script>
    function hideLoading() {

        var loading = document.getElementById('loading-full-screen');
        loading.style.display = "none";

    }

    function shpopup(titlehtml, bodyhtml) {

        $('#modd .modal-dialog .modal-content .modal-header .head').html(titlehtml);
        $('#modd .modal-dialog .modal-content .modal-body').html(bodyhtml);
        $("#modd").modal();

    }
</script>