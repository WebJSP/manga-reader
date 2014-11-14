<?php
session_start();
require_once('../config/config.inc.php');
if (isset($_SESSION['email']) && $_SESSION['email']===ADMIN_EMAIL) {
    header("location: dashboard.php");
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manga Reader Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet" >
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1 class="text-center">Manga Reader Dashboard</h1>
            <p class="text-center">Please select an account to access the dashboard.<br></p>
            <p>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <a class="btn btn-block btn-social btn-twitter" 
                            href="login-with.php?provider=Twitter">
                            <i class="fa fa-twitter"></i>Sign in with Twitter
                        </a>
                    </div>
                    <div class="col-md-4 text-center">
                        <a class="btn btn-block btn-social btn-google-plus" 
                            href="login-with.php?provider=Google">
                            <i class="fa fa-google-plus"></i>Sign in with Google
                        </a>
                    </div>
                    <div class="col-md-4 text-center">
                        <a class="btn btn-block btn-social btn-facebook" 
                            href="login-with.php?provider=Facebook">
                            <i class="fa fa-facebook"></i>Sign in with Facebook
                        </a>
                    </div>
                </div>
            </p>
        </div>
        <p></p>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
?>