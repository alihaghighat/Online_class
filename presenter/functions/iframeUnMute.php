<?php
include("../confing.php");
if(isset($_REQUEST['id']) and isset($_REQUEST['mic'])) {
    $mic=sqi($_REQUEST['mic']);
    $id=sqi($_REQUEST['id']);
    if($mic==1){
       echo '<iframe id="iframe"
        src="'.$id.'?embed&pipButton=off&video=off&displayName=ahamd&audio=on&settingsButton=off"
        allow="camera; microphone; fullscreen; speaker; display-capture"
></iframe>';
    }else{
        echo '<iframe id="iframe"
        src="'.$id.'?embed&pipButton=off&video=off&displayName=ahamd&audio=off&settingsButton=off"
        allow="camera; microphone; fullscreen; speaker; display-capture"
></iframe>';

    }



}
?>
