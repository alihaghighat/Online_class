<?php
include("../../confing.php");
date_default_timezone_set('Asia/Tehran');
require_once('../nusoap.php');
if (!isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../login/login")</script>';
} else {
    $msg = '';
    if (isset($_POST['name']) and isset($_POST['lastname']) and isset($_POST['username']) and isset($_POST['phone']) and isset($_POST['pass'])) {
        $name = sqi($_POST['name']);
        $lastname = sqi($_POST['lastname']);
        $username = sqi($_POST['username']);
        $pass = md5(sqi($_POST['pass']));
        $pass1 = sqi($_POST['pass']);
        $phone = sqi($_POST['phone']);
        $getstudent = getrecord("tblstudent", "name like '$name' and lastname like '$lastname' and username like '$username'");
        if (count($getstudent) > 0) {
            $msg = '<div class="alert-danger">Previously registered student</div>';
        } else {
            $d = addrecored("tblstudent", array("name" => $name, "lastname" => $lastname, "username" => $username, "pass" => $pass, "phone" => $phone));
            if ($d) {
                $msg = '<div class="alert-success">Successfully registered</div>';
                $webServiceURL  = "http://sms.Parsgreen.ir/Api/SendSMS.asmx?wsdl";
                $webServiceSignature = "0FB4572E-1AAF-4E19-9092-A71B7E4FC626";
                $webServicetoMobile   = "" . $phone;
                $webServicetextMessage = "نام کاربری شما:$username و پسورد :$pass1 .  شما با موفقیت در پروژه دانشجویی وب ثبت نام شدید. ";

                $client = new nusoap_client($webServiceURL, true);
                $client->soap_defencoding = 'UTF-8';
                $err = $client->getError();
                if ($err) {
                    echo 'Constructor error' . $err;
                }
                $parameters['signature'] = $webServiceSignature;
                $parameters['toMobile'] = $webServicetoMobile;
                $parameters['smsBody'] = $webServicetextMessage;
                $parameters['retStr'] = "";

                $result = $client->call('Send', $parameters);
            } else {
                $msg = '<div class="alert-danger">Public error occurred</div>';
            }
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
        <div class="col-10">

            <div class="form shadow">
                <div class="form-header bg-secondary p-2 text-white">
                    <h4>Add student</h4>
                </div>

                <form method="post" class="form-body p-3">

                    <?php
                    function randomPassword()
                    {
                        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                        $pass = array(); //remember to declare $pass as an array
                        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                        for ($i = 0; $i < 8; $i++) {
                            $n = rand(0, $alphaLength);
                            $pass[] = $alphabet[$n];
                        }
                        return implode($pass); //turn the array into a string
                    }
                    echo $msg;
                    ?>
                    <div class="">name : </div>
                    <input type="text" name="name" placeholder="" class="form-control mb-3 mt-2" />

                    <div class="">last name : </div>
                    <input name="lastname" type="lastname" placeholder="" class="form-control mb-3 mt-2" />

                    <div class="">username : </div>
                    <input name="username" type="text" placeholder="" class="form-control mb-3 mt-2" />

                    <div class="">password </div>
                    <input name="pass" type="password" placeholder="" value="<?php echo $pass = randomPassword(); ?>" class="form-control mb-3 mt-2" />

                    <div class="">phone </div>
                    <input name="phone" type="text" placeholder="" maxlength="11" class="form-control mb-3 mt-2" />

                    <button class="btn btn-success" type="submit">Add Student <i style="font-size: 17px;" class="bi-plus"></i></button>
                </form>


            </div>





        </div>

    </div>
</div>

<style>
    .form {
        border-radius: 10px;
        overflow: hidden;
        width: 50%;
        margin: auto;
        margin-top: 100px;

    }
</style>