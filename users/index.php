<?php
session_start();
require_once('../config/config.inc.php');
if (isset($_SESSION['admin_id']) && in_array($_SESSION['admin_id'], $ADMIN_IDs)) {
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
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../assets/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-social.css" rel="stylesheet" >
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
                </div>
            </p>
        </div>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
?>