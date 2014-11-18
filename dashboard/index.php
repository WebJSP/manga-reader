<?php
session_start();
require_once('../config/config.inc.php');
if (isset($_SESSION['admin_id']) && in_array($_SESSION['admin_id'], $ADMIN_IDs)) {
    header("location: dashboard.php");
} else {
    $filteredNoAuth = filter_input(INPUT_GET, "noauth");
    $noauth = isset($filteredNoAuth) ? $filteredNoAuth : "0";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manga Reader Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-social.css" rel="stylesheet" >
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
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
        <?php if ($noauth==="1") {?>
        <script type="text/javascript">
            $(document).ready(function(){
                sweetAlertInitialize();
                sweetAlert({
                    title: "Warning!",
                    text: "You doesn't have enough rights to access Dashboard!",
                    type: "error",
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Ok'
                });
            });
        </script>
        <?php } ?>
    </div>
    <script src="../assets/js/sweet-alert.min.js"></script>
    <link href="../assets/css/sweet-alert.css" rel="stylesheet" >
</body>
</html>
<?php
}
?>