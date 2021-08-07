<?php
include("../confing.php");
if (isset($_SESSION['idpresenter'])) {
    echo '<script>location.replace("../page/Class_list")</script>';
} else {
    $username = '';
    $pass = '';
    $pass_form = '';
    $masg_singup = '';
    $masg = '';
    if (isset($_POST['username']) and isset($_POST['pass'])) {
        $username = sqi($_POST['username']);
        $pass = md5(sqi($_POST['pass']));
        if (strlen($username) <= 3 or strlen($pass) <= 7) {
            $masg = '<div class="alert-danger">Enter the information correctly</div>';
        }
        $getuser = getrecord("tblpresenter", "username like '$username' and pass like '$pass'");
        if (count($getuser) > 0) {
            $_SESSION['idpresenter'] = $getuser[0][idpresenter];
            $idprzen = $getuser[0][idpresenter];
            $time = time();
            updaterecord("tblpresenter", array("lastActive" => $time), "idpresenter=$idprzen");
            echo '<script> location.reload();</script>';
        } else {
            $masg = '<div class="alert-danger">Wrong username and password</div>';
        }
    }

    if (isset($_POST['S_username']) and isset($_POST['S_pass']) and isset($_POST['S_pass_2']) and isset($_POST['S_name']) and isset($_POST['S_lastname'])) {
        $username = sqi($_POST['S_username']);
        $pass = md5(sqi($_POST['S_pass']));
        $pass2 = md5(sqi($_POST['S_pass_2']));
        $name = sqi($_POST['S_name']);
        $lastname = sqi($_POST['S_lastname']);

        if (strcmp($pass, $pass2) != 0) {

            $masg_singup = '<div class="alert-danger">The passwords are not the same</div>';
        }
        if (strlen($username) <= 3 or strlen($pass) <= 7) {

            $pass_form = $_POST['S_pass'];
            $masg_singup = '<div class="alert-danger">The password must be at least 8 digits and the half user must have more than 3 characters</div>';
        }
        $getuser = getrecord("tblpresenter", "username like '$username'");
        if (count($getuser) > 0) {
            $masg_singup = '<div class="alert-danger">Username is available</div>';
        }
        if (count($getuser) <= 0) {
            $lastactive = time();
            $d = addrecored("tblpresenter", array("username" => $username, "pass" => $pass, "kind" => 0, "lastActive" => $lastactive, "name" => $name, "lastname" => $lastname));
            if ($d) {
                $masg_singup = 'Successfully registered you can login';
            } else {
                $masg_singup = 'Error at high level performed';
            }
        }
    }
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="../../js/jquery-1.11.2.min.js"></script>

<script src="../../js/popper.min.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="../../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="login.css">


<div class='container'>
    <div class="frame shadow">
        <div class="login-card" id="login-card">
            <div class="login-card-content">
                <div class="login-card-header">
                    LogIn

                </div>
                <div class="login-card-body">
                    <div class=''>
                        <?php echo $masg ?>
                        <form method="post">
                            <div class="">UserName : </div>

                            <input name="username" placeholder="" class="form-control mb-3 mt-2" />

                            <div class="mt-2">Password : </div>

                            <input name="pass" type="password" class="form-control mb-3 mt-2" />

                            <button type="submit" class="btn btn-light my-4 btn-block w-100">LOGIN <i style="font-size: 20px;" class="bi-box-arrow-in-right"></i></button>
                        </form>
                        <div class="my-3">
                            <button class="btn btn-outline-info" onclick="showSignUpCard()">SignUp <i class="bi-arrow-right"></i></button>
                        </div>
                    </div>

                </div>
                <div class="login-card-footer">


                </div>
            </div>
        </div>
        <div class="signup-card">
            <div class="signup-card-content">
                <div class="signup-card-header">
                    signUp

                </div>
                <div class="signup-card-body">
                    <div class=''>
                        <?php echo $masg_singup; ?>
                        <form method="post">
                            <div class="">UserName : </div>

                            <input name="S_username" value="<?php echo $username ?>" class="form-control mb-3 mt-2" />

                            <div class="">name : </div>

                            <input name="S_name" value="<?php echo $name ?>" class="form-control mb-3 mt-2" />
                            <div class="">lastname : </div>

                            <input name="S_lastname" value="<?php echo $lastname ?>" class="form-control mb-3 mt-2" />

                            <div class="mt-2">Password : </div>

                            <input name="S_pass" value="<?php echo $pass_form ?>" type="password" class="form-control mb-3 mt-2" />

                            <div class="mt-2">Confirm Password : </div>

                            <input name="S_pass_2" type="password" value="<?php echo $pass_form ?>" class="form-control mb-3 mt-2" />

                            <button type="submit" class="btn btn-outline-success my-3 btn-block w-100">SIGN UP <i class="bi-plus"></i> </button>
                        </form>
                        <div class="my-3">
                            <button class="btn btn-outline-info" onclick="showLogInCard()">LogIn <i class="bi-arrow-right"></i></button>
                        </div>
                    </div>

                </div>
                <div class="signup-card-footer">

                </div>
            </div>
        </div>
    </div>

</div>



<script>
    function showSignUpCard() {
        document.getElementById("login-card").style.animation = "moveLoginCard .5s forwards";
        var signupHeight = ($('.signup-card-content').outerHeight())
        $(".frame").animate({
            height: signupHeight + "px"
        }, 500);

    }

    function showLogInCard() {
        document.getElementById("login-card").style.animation = "moveBackLoginCard .5s forwards";
        var loginHeight = ($('.login-card-content').outerHeight())
        $(".frame").animate({
            height: loginHeight + "px"
        }, 500);
    }


    $('.frame').height($('.login-card-content').outerHeight())
    <?php
    if (isset($_POST['S_username']) and isset($_POST['S_pass']) and isset($_POST['S_pass_2'])) {
        echo "showSignUpCard();";
    }
    ?>
</script>