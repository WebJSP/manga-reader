<?php
    require_once '../config/config.inc.php';
    //session_start();
    unset($_SESSION['access_token']);
    unset($_SESSION['access_token_secret']);
    unset($_SESSION['client_id']);
    unset($_SESSION['client_secret']);
    unset($_SESSION['id']);
    unset($_SESSION['name']);
    unset($_SESSION['screen_name']);
    session_destroy();
    header("location: ..".DS."index.php");

