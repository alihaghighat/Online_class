<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<link rel="stylesheet" href="../../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="style/menu.css">

<?php
$presenter = getrecord("tblpresenter", "idpresenter = $_SESSION[idpresenter]")[0];
$presenterName = $presenter['name'] . " " . $presenter['lastname'];
?>
<div class="menu shadow">
    <div class="menu-header">
        <img src="../assets/defaults/mountain1.jpg" style="width: 100%;" />
        <div class="user-avatar">
            <div class="avatar-place shadow">
                <img src="../assets/defaults/avatar.png" width="100%" height="100%" />
            </div>
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
                    echo '<div class="sub-item"><div onclick="openLink(' . "'page/" . $key1["url"] . "'" . ')" >' . $key1["vlaue"] . '</div></div>';
                }
                echo '';
            }
        }
        ?>
        <div class="logout-btn" onclick="openLink('page/main?logout=1')"><i class="bi-power"></i> logout</div>
    </div>
</div>

<div class="modal fade" id="modd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="head"></div>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"> cancel </button>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-success" id="success-alert" style="position:fixed;width:100%;z-index:1200;top:0px;display:none;text-align:center;">
</div>
<div class="alert alert-danger" id="danger-alert" style="position:fixed;width:100%;z-index:1200;top:0px;display:none;text-align:center;">
</div>
<script src="js/menu.js"></script>