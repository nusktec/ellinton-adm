<?php
include "includes/Func.php";
$model = new Model();
$model->doLogin($_POST);
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Daily Notifications">
    <meta name="author" content="Revelation A.F">
    <link rel="shortcut icon" href="assets/img/correct-ellington.jpg"/>

    <!-- Title -->
    <title>Ellington - Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>

    <!-- Master CSS -->
    <link rel="stylesheet" href="assets/css/main.css"/>

</head>

<body class="authentication">

<!-- Container start -->
<div class="container">

    <form method="post" action="">
        <div class="row justify-content-md-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-screen">
                    <?php
                    flashAlert();
                    ?>
                    <div class="login-box">
                        <a href="#" class="login-logo">
                            <img src="assets/img/correct-ellington.jpg" alt="Ellington Logo"/>
                        </a>
                        <h5>Welcome back, <br/>Please Login to your Account.</h5>
                        <div class="form-group">
                            <input name="usr" type="text" class="form-control" placeholder="Username"/>
                        </div>
                        <div class="form-group">
                            <input name="psw" type="password" class="form-control" placeholder="Password"/>
                        </div>
                        <div class="actions mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember_pwd">
                                <label class="custom-control-label" for="remember_pwd">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <hr>
                        <div class="actions align-left">
                            <span class="additional-link">Strictly super admin only...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- Container end -->

</body>

</html>