<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="../js/jquery-1.11.2.min.js"></script>

<script src="../js/popper.min.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="../bootstrap/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">


<div class='container'>


    <div class="login-card shadow">
        <div class="login-card-header">
            LogIn

        </div>
        <div class="login-card-body">
            <div class=''>
                <div class="">UserName : </div>

                <input class="form-control mb-3 mt-2" />

                <div class="mt-2">Password : </div>

                <input type="password" class="form-control mb-3 mt-2" />

                <button class="btn btn-outline-primary btn-block">LOGIN <i style="font-size: 20px;" class="bi-box-arrow-in-right"></i></button>
            </div>

        </div>
        <div class="login-card-footer">


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

    .login-card {
        border-radius: 10px;
        width: 330px;
        overflow: hidden;
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
</style>