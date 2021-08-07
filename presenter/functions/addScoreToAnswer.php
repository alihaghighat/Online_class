<?php include('../confing.php');
    if(isset($_REQUEST['idchat']) && isset($_REQUEST['score'])){
        updaterecord("tblchat",array("scor" => $_REQUEST['score']),"idcat = $_REQUEST[idchat]");
        echo "true";
        return;
    }
    echo "$_REQUEST[idchat]  -- $_REQUEST[score]";
    echo 'false';
    return;

?>