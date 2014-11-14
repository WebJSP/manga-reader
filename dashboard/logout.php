<?php
    session_start();
    require_once '../config/config.inc.php';
    session_unset();
    session_destroy();
    header("location: index.php");

