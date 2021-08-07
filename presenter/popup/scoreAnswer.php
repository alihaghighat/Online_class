<?php include("../confing.php");

if (!isset($_REQUEST['idchat'])) {
    echo "false";
    return;
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<input name="score" type="number" id="score" min='0' max='100' placeholder="score" class="form-control mb-3 mt-2" />
<button class="btn btn-success" onclick="addScore(<?php echo $_REQUEST['idchat'] ?>)">confirm</button>

<script src="popup/js/scoreAnswer.js"></script>