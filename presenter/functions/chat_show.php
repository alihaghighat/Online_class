<?php
include("../confing.php");
if (isset($_REQUEST['idclass'])) {
    $idclass = sqi($_REQUEST['idclass']);
    $getclass = getrecord("tblclass", "idclass=$idclass");
    $getidclassHold = getrecord("tblclassHeld", "idclass=$idclass and endtime='0' order by idclassHeld desc");
    $idclassHold = $getidclassHold[0]['idclassHeld'];
    $getchat = getrecord("tblchat", "dellet=0 and idclassHold=$idclassHold order by idcat asc");
    $data = '';
    $i = 0;
    // send of data
    $d = '';
    foreach ($getchat as $key) {
        $d = '';
        if ($key['kind_sender'] == 1) {
            $idsender = $key['idsener'];
            $getsender = getrecord("tblpresenter", "idpresenter=$idsender");
        }
        if ($key['kind_sender'] == 2) {
            $idsender = $key['idsener'];
            $getsender = getrecord("tblstudent", "idstudent=$idsender");
        }
        if ($key['kind_chat'] == 0 and $key['kind_sender'] == 1) {
            $data = $data . '
         <div class="chat shadow-sm" onclick="cnv_qustion(' . $key['idcat'] . ')" >
            <div class="chat-person-details">
                <div class="chat-person-icon chat-person-back">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path d="M12 4a2 2 0 1 1-4 0a2 2 0 0 1 4 0z" fill="white"></path><path d="M7 14.784V16.5A1.5 1.5 0 0 0 8.5 18h3a1.5 1.5 0 0 0 1.5-1.5v-1.716a.5.5 0 0 1 .153-.36l3.703-3.564a.5.5 0 0 0-.347-.86H3.49a.5.5 0 0 0-.346.86l3.702 3.564a.5.5 0 0 1 .154.36z" fill="white"></path><path d="M8.5 7A1.5 1.5 0 0 0 7 8.5V9h6v-.5A1.5 1.5 0 0 0 11.5 7h-3z" fill="white"></path></g></svg>
                </div>
                <div class="chat-person-name">
                   ' . $getsender[0]['name'] . '  ' . $getsender[0]['lastname'] . ' 
                </div>
            </div>
            <div class="chat-text">
                ' . $key['vlaue'] . '

            </div>
        </div>
        ';
        } else {
            if ($key['kind_chat'] == 1 and $key['kind_sender'] == 2 and $key['status'] == 0) {
                $data = $data . '
                     <div class="chat shadow-sm"  >
                        <div class="chat-person-details">
                            <div class="chat-person-icon chat-person-back">
                            <i class="bi-person-fill"></i>
                            </div>
                           
                            <div class="chat-person-name">
                               ' . $getsender[0]['name'] . '  ' . $getsender[0]['lastname'] . '
                            </div>
                             
                           <button class="btn btn-outline-success ml-2" onclick="Accept(' . $key['idcat'] . ')" ><i class="bi-check"></i></button>
                           <button class="btn btn-outline-danger ml-1" onclick="Reject(' . $key['idcat'] . ')" ><i class="bi-x"></i></button>
                        </div>
                        <div class="chat-text">
                            ' . $key['vlaue'] . '
            
                        </div>
                    </div>
                    ';
            } else {
                if ($key['kind_chat'] == 1 and $key['kind_sender'] == 2 and $key['status'] != 0) {
                    if ($key['status'] == 1) {
                        $status = '<i class="mx-2 mt-1 text-success bi-check-all"></i> ' . $key['scor'];
                    }
                    if ($key['status'] == 2) {
                        $status = '<i class="mx-2 mt-1 text-danger bi-x"></i>';
                    }
                    $data = $data . '
                     <div class="chat shadow-sm"  >
                        <div class="chat-person-details">
                            <div class="chat-person-icon chat-person-back">
                            <i class="bi-person-fill"></i>
                            </div>
                            
                            <div class="chat-person-name">
                               ' . $getsender[0]['name'] . '  ' . $getsender[0]['lastname'] . ' ' . $status . '
                            </div>
                        </div>
                        <div class="chat-text">
                            ' . $key['vlaue'] . '
            
                        </div>
                    </div>
                    ';
                } else {
                    if ($key['kind_chat'] == 1 and $key['kind_sender'] == 1) {
                        $d = '<i class="text-info ml-1 bi-question-square"></i>';
                    }
                    if ($key['kind_chat'] == 1 and $key['kind_sender'] == 0) {
                        $d = '';
                    }
                    $data = $data . '
                     <div class="chat shadow-sm" onclick="" >
                        <div class="chat-person-details">
                            <div class="chat-person-icon chat-person-back">
                            <i class="bi-person-fill"></i>
                            </div>
                            <div class="chat-person-name">
                               ' . $getsender[0]['name'] . '  ' . $getsender[0]['lastname'] . ' ' . $d . '
                            </div>
                        </div>
                        <div class="chat-text">
                            ' . $key['vlaue'] . '
            
                        </div>
                    </div>
                    ';
                }
            }
        }
    }
    echo $data;
} else {
    echo 'not ok';
}
