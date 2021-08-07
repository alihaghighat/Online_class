<?php
include("confing.php");
include('colors.php');
if (isset($_SESSION['class_student']) and isset($_SESSION['idstudent'])) {
    $idclass = $_SESSION['class_student'];
    $id = $idclass * 12305;
    $getclassonHoled = getrecord("tblclassHeld", "idclass=$idclass and endtime='0'");
    if (count($getclassonHoled) > 0) {
        $getclass = getrecord("tblclass", "idclass=$idclass");
        $url_room = $getclass[0]['url_room'];
        $class_name = $getclass[0]['name'];
        $idstaudent = $_SESSION['idstudent'];
        $idclasshold = $getclassonHoled[0]['idclassHeld'];
        $studtClass = getrecord("tblstudtClass", "idclass=$idclass and idstudent=$idstaudent");
        $idstudtClass = $studtClass[0]['idstudtClass'];
        $statusstudend = getrecord("tblstudtClassOnline", "idclassHeld=$idclasshold and idstudtClass=$idstudtClass order by id desc");
        $mic = $statusstudend[0]['mic'];
        $Wboard = $statusstudend[0]['Wboard'];
        $Mic_acc = $statusstudend[0]['Mic_acc'];
    } else {
        unset($_SESSION['class_student']);
        unset($_SESSION['idstudent']);

        echo '<script>alert("The class is over");location.replace("../class/login?classToken=' . $id . '")</script>';
    }
} else {

    echo '<script>location.replace("../class/login")</script>';
}

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

<script>
    function getLocalStream() {
        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        }).then(stream => {
            window.localStream = stream; // A
            window.localAudio.srcObject = stream; // B
            window.localAudio.autoplay = true; // C
        }).catch(err => {
            console.log("u got an error:" + err)
        });
    }
    getLocalStream();
</script>
<link rel="stylesheet" href="../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
<div class="main">
    <div class="page">
        <div class="header header-color">
            <div class="avatar">
            </div>
            <div style="display: none" id="voic">

                <iframe id="iframe" src="<?php echo $url_room; ?>?embed&pipButton=off&video=off&displayName=ahamd&audio=off&settingsButton=off" allow="camera; microphone; fullscreen; speaker; display-capture"></iframe>
            </div>
            <div class="room-name">
                <?php echo $class_name ?>
            </div>
            <div class="header-control-buttons">

                <div id="mic-mycontrol">
                    <div class="button-place" <?php if ($Mic_acc == 1) echo 'onclick="MicUpdatePrsenter()'; ?> ">
                        <i id=" mic-icon" class="bi-mic control-button"></i>
                    </div>
                </div>

                <div class="button-place" onclick="speekerUpdate()">
                    <i id="speeker-icon" class="bi-volume-up control-button"></i>
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
            <!-- <div class="menu-button-place">
                <i onclick="openSideBar()" class="bi-list open-menu-button"></i>
            </div> -->
        </div>
        <div class="body">

            <div class="row">
                <div class="col-lg-9 col-sm-12">
                    <div class="content-share shadow">
                        <div class="content-share-header">
                            White Board
                            <button class="btn btn-light" onclick="window.open('fastReplay', '_blank').focus();" class="d-inline-block">
                                <i class="bi-bootstrap-reboot">

                                </i>
                            </button>
                        </div>
                        <div class="content-share-body">


                            <!-- <canvas id="myCanvas" style="width: 100%; height: 100%">
                                Sorry, your browser does not support HTML5 canvas technology.



                            </canvas> -->
                            <div id="white-board-new" style="width: 100%;height:100%">

                            </div>
                            <?php
                            if ($statusstudend[0]['Wboard'] == 0) {
                                echo " <script>
                                $.ajax({
                                    url: 'whiteboard.php',
                                    type: 'POST',
                                    data: {},
                                    success: function(data) {
                                        $('#white-board-new').html(data)
                                    }
                                });
                            </script>";
                            } else {
                                echo " <script>
                                $.ajax({
                                    url: '../presenter/whiteboard.php',
                                    type: 'POST',
                                    data: {},
                                    success: function(data) {
                                        $('#white-board-new').html(data)
                                    }
                                });
                            </script>";
                            }
                            ?>



                            <div id="divDraggable">
                                <div id="textCloseBtn">
                                    <img src="https://www.w3schools.com/images/lamp.jpg" alt="Lamp" width="16" height="16">
                                </div>
                                <!-- <input type='text' placeholder="type here..."/> -->
                                <!-- <textarea id="divResize" rows="2" cols="10" placeholder="type here..."> -->
                                <!-- <textarea id="textResize" rows="2" cols="8" placeholder="type here..."></textarea> -->
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


                    <div class="room-chats shadow">
                        <div class="room-chats-header room-chats-header-back room-chats-header-text">
                            Chats

                        </div>
                        <div class="room-chats-body room-chats-body-back room-chats-body-text" id="chat">

                        </div>
                        <div class="chat-input-box">
                            <input onkeyup="sendMasseg()" placeholder="Type something ..." class="chat-input" id="chat-input" />
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
    var mic = <?php echo ($mic); ?>;
    var Wboard = <?php echo ($Wboard); ?>;
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
                    console.log(data);
                    document.getElementById("speeker-icon").className = "bi-volume-up control-button";


                    $("#voic").html(data);
                    speeker = 1;

                }

            });

        }
    }

    function mic1(id) {

        $.ajax({

            url: 'functions/micupdate.php',

            type: 'post',

            data: 'id=' + id,

            success: function(data) {
                alert(data);





            }

        });
    }

    function MicUpdatePrsenter() {

        if (mic == 1) {
            mic = 0;
            mic1(<?php echo $idclasshold ?>);
            document.getElementById("mic-icon").className = "bi-mic-mute control-button";

        } else {
            mic = 1;
            mic1(<?php echo $idclasshold ?>);
            document.getElementById("mic-icon").className = "bi-mic control-button";

        }
    }

    function cnv_anser(id) {
        console.log(id);
        $.ajax({

            url: 'functions/cnv_anser.php',

            type: 'post',

            data: 'id=' + id,

            success: function(data) {
                console.log(data)




            }

        });
    }
    setInterval(check_hozar, 1000); //300000 MS == 5 minutes
    setInterval(chat, 1000);
    setInterval(check_endclass, 1000);
    setInterval(checkstatus, 1000);
    setInterval(check_acc_mic, 1000);

    function check_acc_mic() {
        $.ajax({

            url: 'functions/check_acc_mic.php',

            type: 'post',

            data: 'idH=<?php echo ($idclasshold); ?>',

            success: function(data) {
                $('#mic-mycontrol').html(data)
            }

        });
    }

    function checkstatus() {

        $.ajax({

            url: 'functions/checkstatus.php',

            type: 'post',

            data: 'mic=<?php echo ($mic); ?>&Wdoard=<?php echo ($Wboard); ?>',

            success: function(data) {

                var obj = JSON.parse(data);
                check_w_m(obj['mic'], obj['Wboard']);
            }

        });
    }

    function check_w_m(newMic, newWboard) {
        if (newWboard != Wboard) {

            Wboard = newWboard;
            if (Wboard == 1) {
                $.ajax({
                    url: '../presenter/whiteboard.php',
                    type: 'POST',
                    data: {},
                    success: function(data) {
                        $('#white-board-new').html(data)
                    }
                });
            } else {
                $.ajax({
                    url: 'whiteboard.php',
                    type: 'POST',
                    data: {},
                    success: function(data) {
                        $('#white-board-new').html(data)
                    }
                });
            }


        }

        if (newMic != mic) {
            mic = newMic;
            if (mic == 1) {
                $.ajax({

                    url: 'functions/iframeUnMute.php',

                    type: 'post',

                    data: 'id= <?php echo $url_room; ?>&mic=' + mic,

                    success: function(data) {

                        $("#voic").html(data);
                        console.log(speeker);
                        speeker = !speeker;
                        console.log(speeker);
                        speekerUpdate();
                    }

                });

            } else {
                $.ajax({

                    url: 'functions/iframeUnMute.php',

                    type: 'post',

                    data: 'id= <?php echo $url_room; ?>&mic=' + mic,

                    success: function(data) {

                        $("#voic").html(data);
                        console.log(speeker);
                        speeker = !speeker;
                        console.log(speeker);
                        speekerUpdate();

                    }

                });
            }

        }
    }



    function chat() {


        $.ajax({

            url: 'functions/chat_show.php',

            type: 'post',

            data: 'idclass=<?php echo ($_SESSION['class_student']); ?>',

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

    function check_endclass() {
        $.ajax({

            url: 'functions/check_endclass.php',

            type: 'post',

            data: 'idclass=<?php echo ($_SESSION['class_student']); ?>',

            success: function(data) {
                if (data == -1) {
                    alert("The class is over");
                    location.replace("../class/login?classToken=<?php echo $id; ?>");
                }

            }

        });
    }

    function check_hozar() {
        $.ajax({

            url: 'functions/check_hozar.php',

            type: 'post',

            data: 'idclass=<?php echo $_SESSION['class_student']; ?>',

            success: function(data) {
                // delete all white spaces in string;
                var string1 = data.split(/\s+/).join('');
                var string2 = $("#hozor").html().split(/\s+/).join('');

                //if data didn't change do nothing;
                if (!string1.localeCompare(string2)) {

                } else {
                    console.log(string1);
                    console.log(string2);

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

                    data: 'typedText=' + typedText,

                    success: function(data) {
                        console.log(data);

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

                data: 'typedText=' + typedText,

                success: function(data) {
                    console.log(data);

                    document.getElementById("chat-input").value = "";

                }

            });
        }

    }
    check_hozar();
    chat();
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



    /*chat box functions */

    function onChatInputChange() {
        var typedText = $('#chat-input').val();


        if (typedText.length == 0) {
            $('.send-text').animate({
                color: 'black'
            }, 500);
            $('.is-typing').hide();
        } else {
            $('.send-text').animate({
                color: 'green'
            }, 500);
            $('.is-typing').show();
        }
    }

    /* for simulating chat box*/
    var messages = []

    function onChatInputBlur() {
        $('.is-typing').hide();
    }
</script>

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

<?php include('../presenter/style/index.php') ?>
<script src="../js/whiteboard.js">
</script>