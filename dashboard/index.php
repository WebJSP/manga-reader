<?php
require_once('../config/config.inc.php');

session_start();
if (isset($_SESSION['id']) && $_SESSION['id']===ADMIN_USER_ID) {
    header("location: dashboard.php");
} else {
    header("location: login_with_twitter.php");
}
