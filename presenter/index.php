<?php
include('confing.php');
include('colors.php');


if (isset($_REQUEST['classToken']) and isset($_SESSION['idpresenter'])) {
    $classToken = sqi($_REQUEST['classToken']);
    $idclass = $classToken / 12305;
    $_SESSION['class'] = $idclass;
    $getclass = getrecord("tblclass", "idclass=$idclass");
    $url_room = $getclass[0]['url_room'];
    $class_name = $getclass[0]['name'];
    $getstarat = getrecord("tblclassHeld", "idclass=$idclass and endtime=0");
    if (count($getstarat)) {



        $idtime = $getstarat[0]['idclassHeld'];
        if (isset($_REQUEST['endclass']) and $_REQUEST['endclass'] == 1) {
            $time = time();
            updaterecord("tblclassHeld", array("endtime" => $time), "idclassHeld=$idtime");
            echo '<script>location.replace("page/Class_list");</script>';
        }
    } else {
        $time = time();

        // set rom for class
        $api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmFwcGVhci5pbiIsImF1ZCI6Imh0dHBzOi8vYXBpLmFwcGVhci5pbi92MSIsImV4cCI6OTAwNzE5OTI1NDc0MDk5MSwiaWF0IjoxNjI3NTM3NTE5LCJvcmdhbml6YXRpb25JZCI6MTIxNTg4LCJqdGkiOiIzNmZmMWY1ZS0xNjkwLTRjMGItYTJkZi03MTUwNWM2NGIzODMifQ._az3fboW2OcjRYnDaILnntd1aQcGNIT82EpwzKi_mPo";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.whereby.dev/v1/meetings');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            '{
                              "startDate": "2021-07-21T08:23:00.000Z",
                              "endDate": "2021-07-22T08:22:00.000Z",
                              "fields": ["bamplus.whereby.com"]}'
        );

        $headers = [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        $data = json_decode($response);
        $url = $data->{'roomUrl'};
        ///
        updaterecord("tblclass", array("url_room" => $url), "idclass=$idclass");
        addrecored("tblclassHeld", array("idclass" => $idclass, "starttime" => $time, "endtime" => '0'));
        echo '<script>location.reload();</script>';
    }
} else {
    echo '<script>location.replace("login/login");</script>';
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">



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
<script>
    function hidepopup() {
        $('#modd').modal('hide');
    }

    function shpopup(titlehtml, bodyhtml) {

        $('#modd .modal-dialog .modal-content .modal-header .head').html(titlehtml);
        $('#modd .modal-dialog .modal-content .modal-body').html(bodyhtml);
        $("#modd").modal('show');

    }
</script>
<div class="alert alert-success" id="success-alert" style="position:fixed;width:100%;z-index:1200;top:0px;display:none;text-align:center;">
</div>
<div class="alert alert-danger" id="danger-alert" style="position:fixed;width:100%;z-index:1200;top:0px;display:none;text-align:center;">
</div>

<script>
    function showSuccessAlert(text) {
        document.getElementById("success-alert").innerHTML = text;
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
    }

    function showDangerAlert(text) {
        document.getElementById("danger-alert").innerHTML = text;
        $("#danger-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#danger-alert").slideUp(500);
        });
    }
</script>



<div class="main">
    <div class="page">
        <div class="header header-color">
            <div class="avatar">
            </div>
            <div class="room-name">
                <?php echo $class_name ?>
            </div>
            <div style="display: none; height:0px;" id="voic">
                <iframe src="<?php echo $url_room; ?>?embed&pipButton=off&video=off&displayName=ahamd&audio=on&settingsButton=off" allow="camera; microphone; fullscreen; speaker; display-capture"></iframe>
            </div>
            <div class="header-control-buttons">

                <div class="button-place" onclick="MicUpdatePrsenter()">
                    <i id="mic-icon" class="bi-mic control-button"></i>
                </div>
                <div class="button-place" onclick="speekerUpdate()">
                    <i id="speeker-icon" class="bi-volume-up control-button"></i>
                </div>
                <div class="button-place">
                    <?php $endUrl = 'index?classToken=' . $_REQUEST['classToken'] . '&endclass=1'; ?>
                    <div class="control-button" onclick="window.location = '<?php echo $endUrl ?>'"><i class="bi-stop"></i></div>
                </div>
            </div>


            <table class="tabBlock" onload="showTime()" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td class="clock" id="dc"></td> <!-- THE DIGITAL CLOCK. -->
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0">

                            <!-- HOUR IN 'AM' AND 'PM'. -->
                            <tr>
                                <td class="clocklg" id="dc_hour"></td>
                            </tr>

                            <!-- SHOWING SECONDS. -->
                            <tr>
                                <td class="clocklg" id="dc_second"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
        <div class="body">

            <div class="row">
                <div class="col-lg-9 col-sm-12">
                    <div class="content-share shadow">
                        <div class="content-share-header">
                            White Board

                        </div>
                        <div class="content-share-body">

                            <div id="white-board-new" style="width: 100%;height:100%;">

                            </div>
                            <script>
                                $.ajax({
                                    url: 'whiteboard.php',
                                    type: 'POST',
                                    data: {},
                                    success: function(data) {
                                        $('#white-board-new').html(data)
                                    }
                                });
                            </script>
                            <div id="divDraggable">
                                <div id="textCloseBtn">
                                    <img src="https://www.w3schools.com/images/lamp.jpg" alt="Lamp" width="16" height="16">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 pl-0 room-details">
                    <div class="room-members shadow">
                        <div class="room-members-header room-members-header-back room-members-header-text">
                            Members

                        </div>
                        <div class="room-members-body room-members-body-back room-members-body-text" id="hozor">


                        </div>


                    </div>
                    <script>
                        function showTime() {
                            var date = new Date();
                            var h = date.getHours(); // 0 - 23
                            var m = date.getMinutes(); // 0 - 59
                            var s = date.getSeconds(); // 0 - 59
                            var session = "AM";

                            if (h == 0) {
                                h = 12;
                            }

                            if (h > 12) {
                                h = h - 12;
                                session = "PM";
                            }

                            h = (h < 10) ? "0" + h : h;
                            m = (m < 10) ? "0" + m : m;
                            s = (s < 10) ? "0" + s : s;

                            var time = h + ":" + m + ":" + s + " " + session;
                            /* document.getElementById("MyClockDisplay").innerText = time;
                            document.getElementById("MyClockDisplay").textContent = time; */
                            document.getElementById("dc").innerText = h + ' : ' + m;
                            document.getElementById("dc_hour").innerText = session;
                            document.getElementById("dc_second").innerText = s;


                            setTimeout(showTime, 1000);

                        }

                        showTime();
                    </script>



                    <div class="room-chats shadow">
                        <div class="room-chats-header room-chats-header-back room-chats-header-text">
                            Chats

                            <div class="access-place d-inline-block float-right p-1 rounded" onclick="delletchat()"><i class="access-button m-2 bi-trash"></i></div>

                        </div>
                        <div class="room-chats-body room-chats-body-back room-chats-body-text" id='chat'>

                        </div>
                        <div class="chat-input-box">
                            <input onkeyup="sendMasseg()" onchange="sendMessage()" placeholder="Type something ..." class="chat-input" id="chat-input" />
                            <div class="send-text">
                                <div onclick="sendM()">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                                        <g fill="none">
                                            <path d="M1.724 1.053a.5.5 0 0 0-.714.545l1.403 4.85a.5.5 0 0 0 .397.354l5.69.953c.268.053.268.437 0 .49l-5.69.953a.5.5 0 0 0-.397.354l-1.403 4.85a.5.5 0 0 0 .714.545l13-6.5a.5.5 0 0 0 0-.894l-13-6.5z" fill="currentColor" />
                                        </g>
                                    </svg>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>


        </div>
    </div>
    <div class="side-bar" id="side-bar">
        <div class="close-side-bar-button-place">
            <i onclick="closeSideBar()" class="bi-x close-side-bar-button"></i>
        </div>

    </div>




</div>
<script>
    var mic = 1;
    var speeker = 1;


    function speekerUpdate() {

        if (speeker == 1) {
            $("#voic").html('');
            document.getElementById("speeker-icon").className = "bi-volume-mute control-button";
            speeker = 0;
        } else {
            $.ajax({

                url: 'functions/iframeUnMute.php',

                type: 'post',

                data: 'id= <?php echo $url_room; ?>&mic=' + mic,

                success: function(data) {


                    $("#voic").html(data);
                    document.getElementById("speeker-icon").className = "bi-volume-up control-button";
                    speeker = 1;

                }

            });

        }
    }

    function MicUpdatePrsenter() {

        if (mic == 1) {
            mic = 0;
            $.ajax({

                url: 'functions/iframeUnMute.php',

                type: 'post',

                data: 'id= <?php echo $url_room; ?>&mic=' + mic,

                success: function(data) {
                    document.getElementById("mic-icon").className = "bi-mic-mute control-button";

                    $("#voic").html(data);

                }

            });

        } else {
            mic = 1;
            $.ajax({

                url: 'functions/iframeUnMute.php',

                type: 'post',

                data: 'id= <?php echo $url_room; ?>&mic=' + mic,

                success: function(data) {

                    $("#voic").html(data);
                    document.getElementById("mic-icon").className = "bi-mic control-button";

                }

            });
        }
    }




    function delletchat() {
        $.ajax({

            url: 'functions/clear_chat.php',

            type: 'post',

            data: 'idclass=<?php echo $_SESSION['class']; ?>',

            success: function(data) {
                $("#chat").html("");


            }

        });
    }

    function cnv_qustion(id) {

        $.ajax({

            url: 'functions/cnv_qustion.php',

            type: 'post',

            data: 'id=' + id,

            success: function(data) {





            }

        });
    }

    function showModal(id) {

        $.ajax({
            url: 'popup/scoreAnswer.php',
            type: 'post',
            data: {
                'idchat': id,
            },
            success: function(data) {
                shpopup('Question Score', data);
            }
        });

    }

    function setHost(id) {


        $.ajax({

            url: 'functions/setHost.php',

            type: 'post',

            data: 'id=' + id,

            success: function(data) {

                showSuccessAlert(data);



            }

        });

    }

    function Accept(id) {


        $.ajax({

            url: 'functions/Accept.php',

            type: 'post',

            data: 'id=' + id,

            success: function(data) {
                showModal(id);



            }

        });

    }

    function mic1(id) {
        $.ajax({

            url: 'functions/micupdate.php',

            type: 'post',

            data: 'id=' + id,

            success: function(data) {

                showSuccessAlert(data);




            }

        });
    }


    function Reject(id) {


        $.ajax({

            url: 'functions/Reject.php',

            type: 'post',

            data: 'id=' + id,

            success: function(data) {





            }

        });

    }

    setInterval(check_hozar, 1000);
    setInterval(chat, 1000);

    function chat() {
        $.ajax({

            url: 'functions/chat_show.php',

            type: 'post',

            data: 'idclass=<?php echo $_SESSION['class']; ?>',

            success: function(data) {



                var string1 = data.split(/\s+/).join('');
                var string2 = $("#chat").html().split(/\s+/).join('');

                //if data didn't change do nothing;
                if (!string1.localeCompare(string2)) {

                } else {


                    $("#chat").html(data);
                    var element = document.getElementsByClassName("room-chats-body")[0];
                    element.scrollTop = element.scrollHeight;
                }




            }

        });
    }

    function check_hozar() {
        $.ajax({

            url: 'functions/check_hozar.php',

            type: 'post',

            data: 'idclass=<?php echo $_SESSION['class']; ?>',

            success: function(data) {
                // delete all white spaces in string;
                var string1 = data.split(/\s+/).join('');
                var string2 = $("#hozor").html().split(/\s+/).join('');

                //if data didn't change do nothing;
                if (!string1.localeCompare(string2)) {

                } else {


                    $("#hozor").html(data);
                }





            }

        });
    }



    function sendMasseg() {


        var typedText = $('#chat-input').val();
        if (typedText.length != 0) {
            $(".send-text").css("color", "black");
        } else {
            $(".send-text").css("color", "#6f7580");
        }
        if (event.keyCode == 13) {
            if (typedText != '') {
                $.ajax({

                    url: 'functions/sendchat.php',

                    type: 'post',

                    data: 'typedText=' + typedText + '&classToken=<?php echo $_REQUEST['classToken'] ?>',

                    success: function(data) {


                        document.getElementById("chat-input").value = "";

                    }

                });
            }
        }

    }

    function sendM() {
        var typedText = $('#chat-input').val();

        if (typedText != '') {
            $.ajax({

                url: 'functions/sendchat.php',

                type: 'post',

                data: 'typedText=' + typedText + '&classToken=<?php echo $_REQUEST['classToken'] ?>',

                success: function(data) {


                    document.getElementById("chat-input").value = "";

                }

            });
        }

    }
    check_hozar();
</script>


<script>
    function openSideBar() {
        $('#side-bar').animate({
            width: '300px'
        }, 'slow');
    }

    function closeSideBar() {
        $('#side-bar').animate({
            width: '0px'
        }, 'slow');
    }


    function whiteBoardToolToggle() {
        if ($(".white-board-tool-buttons").css('display') == "none") {
            $(".white-board-tool-buttons").show(800);
            document.getElementById("white-board-tool-toggle").style.animation = "fullRotate 1s forwards";
        } else {
            $(".white-board-tool-buttons").hide(800);
            document.getElementById("white-board-tool-toggle").style.animation = "backRotate 1s forwards";
        }
    }
</script>

<?php include('style/index.php'); ?>

<script src="../js/whiteboard.js"></script>