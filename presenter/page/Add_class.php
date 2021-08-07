<?php
include("../../confing.php");
date_default_timezone_set('Asia/Tehran');
require_once('../nusoap.php');
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
} else {
    $msg = '';
    $it_ok = 0;
    if (
        isset($_POST['name_class']) and isset($_POST['h_start']) and isset($_POST['m_start']) and isset($_POST['h_end'])
        and isset($_POST['m_end']) and isset($_POST['day'])
    ) {
        $name = sqi($_POST['name_class']);
        $h_start = sqi($_POST['h_start']);
        $m_start = sqi($_POST['m_start']);
        $h_end = sqi($_POST['h_end']);
        $m_end = sqi($_POST['m_end']);
        $day = $_POST['day'];
        $day_temp = '';
        $idprsenter = $_SESSION['idpresenter'];


        if ($name != '' and strlen($name) > 3) {
            if (0 + $h_start < 0 + $h_end) {

                if (count($day) == 0) {
                    $msg = '<div class="alert-danger">You have not chosen any day for the class</div>';
                } else {
                    $N = count($day);


                    for ($i = 0; $i < $N; $i++) {
                        $day_temp = $day_temp . '!' . $day[$i];
                    }
                    $day_ok = sqi($day_temp);
                    $time_strt = $h_start . ':' . $m_start;
                    $time_end = $h_end . ':' . $m_end;

                    // set rom for class
                    $api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmFwcGVhci5pbiIsImF1ZCI6Imh0dHBzOi8vYXBpLmFwcGVhci5pbi92MSIsImV4cCI6OTAwNzE5OTI1NDc0MDk5MSwiaWF0IjoxNjI2ODUxNjYxLCJvcmdhbml6YXRpb25JZCI6MTIxNTg4LCJqdGkiOiI5NWZkZmI4MS0xMzg0LTQzOGUtYjJiOS04YTQxMmRlMTQyMGUifQ.GA_dVm3FR36D6xEY0Cs47_VYvN5P8AqnLr6KaOzWxLk";
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


                    $d = addrecored("tblclass", array(
                        "name" => $name, "time_start" => $time_strt, "time_end" => $time_end, "kind" => 1, "dayweek" => $day_ok, "idprsenter" => $idprsenter, "url_room" => $url
                    ));

                    if ($d) {
                        $msg = '<div class="alert-success">Successfully registered</div>';
                    } else {
                        $msg = '<div class="alert-danger">A general error occurred</div>';
                    }
                }
            } else {
                $msg = '<div class="alert-danger">The time entered is incorrect</div>';
            }
        } else {
            $msg = '<div class="alert-danger">The name entered is incorrect</div>';
        }
    }
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="../../js/jquery-1.11.2.min.js"></script>
<!-- <script src="../../js/jquery.form.js"></script>
<script src="../../js/popper.min.js"></script> -->
<script src="../../bootstrap/js/bootstrap.js"></script>
<!-- <script src="../../js/test.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>


<link rel="stylesheet" href="../../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">


<div class="container-fluid">
    <div class="row" style="height: 100%;">
        <div class="col-2">
            <?php include('menu.php'); ?>
        </div>
        <div class="col-9">


            <div class="class-form shadow">
                <div class="class-from-header bg-info w-100 p-2 text-white">
                    <h4>Add class</h4>
                </div>

                <form method="post" class="p-2">
                    <?php

                    echo $msg;
                    ?>
                    <div class="">name class : </div>
                    <input type="text" name="name_class" placeholder="" class="form-control mb-3 mt-2" />
                    <div class="col-6">
                        <p>start time </p>
                        <div class="col-3">
                            <input name="h_start" type="number" min="0" max="24" placeholder="hour" class="form-control mb-3 mt-2" />

                        </div>
                        <div class="col-3">
                            <input name="m_start" type="number" min="0" max="60" placeholder="min" class="form-control mb-3 mt-2" />

                        </div>

                    </div>
                    <div class="col-6">
                        <p>end time </p>
                        <div class="col-3">
                            <input name="h_end" type="number" min="0" max="24" placeholder="hour" class="form-control mb-3 mt-2" />

                        </div>
                        <div class="col-3">
                            <input name="m_end" type="number" min="0" max="60" placeholder="min" class="form-control mb-3 mt-2" />

                        </div>

                    </div>



                    <div class="">Days of the Week: </div>
                    <div class="row">
                        <div class="col-3">
                            <input name="day[]" type="checkbox" class="mx-2" checked value="sunday" placeholder=" akf" />
                            <label for="vehicle1"> Sunday</label>
                        </div>
                        <div class="col-3">
                            <input name="day[]" type="checkbox" class="mx-2" value="monday" placeholder=" akf" />
                            <label for="vehicle1"> Monday</label>
                        </div>
                        <div class="col-3">
                            <input name="day[]" type="checkbox" class="mx-2" value="tuesday" placeholder=" akf" />
                            <label for="vehicle1"> Tuesday</label>
                        </div>
                        <div class="col-3">
                            <input name="day[]" type="checkbox" class="mx-2" value="wednesday" placeholder=" akf" />
                            <label for="vehicle1"> Wednesday</label>
                        </div>
                        <div class="col-3">
                            <input name="day[]" type="checkbox" class="mx-2" value="thursday" placeholder=" akf" />
                            <label for="vehicle1"> Thursday</label>
                        </div>
                        <div class="col-3">
                            <input name="day[]" type="checkbox" class="mx-2" value="friday" placeholder=" akf" />
                            <label for="vehicle1"> Friday</label>
                        </div>
                        <div class="col-3">
                            <input name="day[]" type="checkbox" class="mx-2" value="saturday" placeholder=" akf" />
                            <label for="vehicle1"> Saturday</label>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-9">

                        </div>
                        <div class="col-3">
                            <button class="btn btn-success  mr-3" type="submit">Create New Class <i class="bi-plus"></i></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>
<style>
    .class-form {
        width: 65%;
        margin: auto;
        border-radius: 10px;
        margin-top: 100px;
        overflow: hidden;
    }

    .form-control {
        min-width: 160px !important;
    }
</style>