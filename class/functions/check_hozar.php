<?php
include("../confing.php");
if (isset($_REQUEST['idclass'])) {
    $idclass = sqi($_REQUEST['idclass']);
    $getclass = getrecord("tblclass", "idclass=$idclass");
    $idprzenter = $getclass[0]['idprsenter'];
    $array = array();
    $gettimeclass = getrecord("tblclassHeld", "idclass=$idclass order by idclassHeld desc");
    $idclassHoled = $gettimeclass[0]['idclassHeld'];
    $getprzinter = getrecord("tblpresenter", "idpresenter=$idprzenter");
    $przenter = $getprzinter[0];
    $temp = array("name" => $przenter['name'], "kind" => "P", "lastname" => $przenter['lastname'], "mic" => 1);
    array_push($array, $temp);
    $getclassstudent = getrecord("tblstudtClass", "idclass=$idclass");
    foreach ($getclassstudent as $key) {
        $idOnline = $key['idstudtClass'];
        $getOnline = getrecord("tblstudtClassOnline", "idstudtClass=$idOnline and idclassHeld=$idclassHoled order by id desc");
        $mic = $getOnline[0]['mic'];
        $Wboard = $getOnline[0]['Wboard'];
        $idstudent = $key['idstudent'];
        $getstudent = getrecord("tblstudent", "idstudent=$idstudent");
        if (count($getOnline) > 0) {
            if ($getOnline[0]['time_end'] == 0) {
                $Onlinestudent = $getstudent[0];
                $temp = $temp = array("name" => $Onlinestudent['name'], "kind" => "L", "lastname" => $Onlinestudent['lastname'], "mic" => $mic, "Wbord" => $Wboard);
                array_push($array, $temp);
            } else {
                if (time() - $getOnline[0]['time_end'] < 10) {
                    $Onlinestudent = $getstudent[0];
                    $temp = $temp = array("name" => $Onlinestudent['name'], "kind" => "L", "lastname" => $Onlinestudent['lastname'], "mic" => $mic, "Wbord" => $Wboard);
                    array_push($array, $temp);
                }
            }
        }
    }

    // set last active me
    $idmystudent = $_SESSION['idstudent'];
    $getclassstudent = getrecord("tblstudtClass", "idclass=$idclass and idstudent=$idmystudent");
    $idclassOnlineme = $getclassstudent[0]['idstudtClass'];
    $getOnline = getrecord("tblstudtClassOnline", "idstudtClass=$idclassOnlineme order by id desc");
    $idonlineme = $getOnline[0]['id'];
    $gettimeclass = getrecord("tblclassHeld", "idclass=$idclass order by idclassHeld desc");
    $idclassHoled = $gettimeclass[0]['idclassHeld'];
    if ($getOnline[0]['time_end'] == 0) {
        $time = time();
        updaterecord("tblstudtClassOnline", array("time_end" => $time, "idclassHeld" => $idclassHoled), "id=$idonlineme");
    } else {
        if (time() - $getOnline[0]['time_end'] < 100) {
            $time = time();
            updaterecord("tblstudtClassOnline", array("time_end" => $time, "idclassHeld" => $idclassHoled), "id=$idonlineme");
        } else {
            $time = time();

            addrecored("tblstudtClassOnline", array("idstudtClass" => $idclassOnlineme, "idclassHeld" => $idclassHoled, "time_srart" => $time, "time_end" => 0, "mic" => 0));
        }
    }
    $data = '';
    $i = 0;
    // send of data
    foreach ($array as $key) {
        if ($key['kind'] == "P") {
            $userKind = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path d="M12 4a2 2 0 1 1-4 0a2 2 0 0 1 4 0z" fill="white"></path><path d="M7 14.784V16.5A1.5 1.5 0 0 0 8.5 18h3a1.5 1.5 0 0 0 1.5-1.5v-1.716a.5.5 0 0 1 .153-.36l3.703-3.564a.5.5 0 0 0-.347-.86H3.49a.5.5 0 0 0-.346.86l3.702 3.564a.5.5 0 0 1 .154.36z" fill="white"></path><path d="M8.5 7A1.5 1.5 0 0 0 7 8.5V9h6v-.5A1.5 1.5 0 0 0 11.5 7h-3z" fill="white"></path></g></svg>';
        } else {
            $userKind = '<i class="bi-person-fill"></i>';
        }
        $data = $data . '
       
        <div class="member-card">

            <div class="member-icon member-person-icon-back">
                ' . $userKind . '
            </div>
            <div class="member-name">
                ' . $key['name'] . ' ' . $key['lastname'] .  '
            </div>
            ';
        if ($key['mic'] == 1) {
            $data = $data . '<div class="member-access">
                <div class="mic-access">
                    <i class="bi-mic"></i>
                </div>
            </div>
            ';
        }
        if ($key['mic'] == 0) {
            $data = $data . '<div class="member-access">
                <div class="mic-access">
                    <i class="bi-mic-mute"></i>
                </div>
            </div>
            ';
        }
        if ($key['Wbord'] == 0) {
            $data = $data . '<div class="member-access">
                
            </div>
            ';
        }
        if ($key['Wbord'] == 1) {
            $data = $data . '<div class="member-access">
                <div class="mic-access">
                   <i class="bi-cast"></i>
                </div>
            </div>
            ';
        }

        if ($i != 0) {
            $data = $data . '
            <div class="kick-out-member">
                <i class="bi-x-circle"></i>
            </div>';
        }

        $data = $data . '
        </div>

        
        ';
    }
    echo $data;
} else {
    echo 'not ok';
}
