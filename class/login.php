<?php
include("confing.php");

if(isset($_SESSION['class_student']) and isset($_SESSION['idstudent'])){
    echo '<script>location.replace("../class/class")</script>';
}else{

    $username='';
    $pass='';
    $pass_form='';
    $masg_singup='';
    $masg='';
    if(isset($_REQUEST['classToken'])){

        $classToken=sqi($_REQUEST['classToken']);
        $idclass=$classToken/12305;
        $getclass=getrecord("tblclass","idclass=$idclass");
        if(count($getclass)>0){
            if(isset($_POST['username']) and isset($_POST['pass'])){
                $username=sqi($_POST['username']);
                $pass=md5(sqi($_POST['pass']));
                if(strlen($username)<=3 or strlen($pass)<=7){
                    $masg='<div class="alert-danger">Enter the information correctly</div>';
                }
                $getuser=getrecord("tblstudent","username like '$username' and pass like '$pass'");
                if(count($getuser)>0){
                    $idstudent=$getuser[0]['idstudent'];
                  $student_in_class=getrecord("tblstudtClass","idstudent=$idstudent and idclass=$idclass and kind=1");
                  if(count($student_in_class)>0){
                      $_SESSION['class_student']=$idclass.'';
                      $_SESSION['idstudent']=$idstudent;
                      $_SESSION['idstudtClass']=$student_in_class[0]['idstudtClass'];
                      $idstudtClass=$_SESSION['idstudtClass'];
                      $time=time();
                      $gettblclassHeld=getrecord("tblclassHeld","idclass=$idclass and endtime=0 order by idclassHeld desc");
                      $idclassHeld=$gettblclassHeld[0]['idclassHeld'];

                      $gettblstudtClassOnline=getrecord("tblstudtClassOnline","idstudtClass=$idstudtClass and (time_srart=$time or (time_end=0 and idclassHeld=$idclassHeld)) ");

                      if(count($gettblstudtClassOnline)>0){

                      }else{
                          addrecored("tblstudtClassOnline",array("mic"=>0,"time_end"=>'0',"time_srart"=>$time,"idstudtClass"=>$idstudtClass,"idclassHeld"=>$idclassHeld));

                      }
                        echo '<script>location.reload();</script>';


                  }else{
                      $masg='<div class="alert-danger">You are not allowed to access the class</div>';
                  }


                }else{
                    $masg='<div class="alert-danger">Wrong username and password</div>';
                }
            }
        }else{
            echo '<script> alert("There is no class with this specification");</script>';
        }

    }else{
        echo '<script> alert("There is no class with this specification");</script>';
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
                        <form method="post" >
                            <div class="">UserName : </div>

                            <input name="username" placeholder="" class="form-control mb-3 mt-2" />

                            <div class="mt-2">Password : </div>

                            <input name="pass"  type="password" class="form-control mb-3 mt-2" />

                            <button type="submit" class="btn btn-outline-success my-3 btn-block w-100">LOGIN <i style="font-size: 20px;" class="bi-box-arrow-in-right"></i></button>
                        </form>

                    </div>

                </div>
                <div class="login-card-footer">


                </div>
            </div>
        </div>

        </div>
    </div>

</div>


<style>
    .container {
        display: flex;
        align-items: center !important;
        justify-content: center !important;
        height: 100%;

    }

    .frame {
        border-radius: 10px;
        width: 330px;
        height: auto;
        overflow: hidden;
        display: flex;
    }

    .login-card {
        width: 330px;
        overflow: hidden;
    }

    .login-card-content {
        width: 330px;
    }

    .login-card-header {
        background: purple;
        padding: 10px;
        font-size: 20px;
        text-align: center;
        color: white;

    }

    .login-card-body {
        padding: 20px;

    }

    @keyframes moveLoginCard {
        from {
            width: 330px;
        }

        to {
            width: 0px;
        }

    }

    @keyframes moveBackLoginCard {
        from {
            width: 0px;
        }

        to {
            width: 330px;
        }

    }



    .signup-card {
        flex: 1;
        width: 330px;
        overflow: hidden;
    }

    .signup-card-content {
        width: 330px;
    }

    .signup-card-header {
        background: purple;
        padding: 10px;
        font-size: 20px;
        text-align: center;
        color: white;

    }

    .signup-card-body {
        padding: 20px;

    }
</style>
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
    if(isset($_POST['S_username']) and isset($_POST['S_pass']) and isset($_POST['S_pass_2'])){
        echo "showSignUpCard();";
    }
    ?>
</script>