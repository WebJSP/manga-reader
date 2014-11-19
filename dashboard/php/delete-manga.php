<?php
session_start();
require_once '../../phplib/HttpStatusCode.php';
require_once '../../phplib/deleteFolder.php';
require_once '../../config/config.inc.php';
header('Content-Type: application/json; charset=utf-8');
//error_reporting(0);
if (isset($_SESSION['admin_id']) && in_array($_SESSION['admin_id'], $ADMIN_IDs)) {
    $name = filter_input(INPUT_POST, "name");
    if (!isset($name)) {
        http_response_code(HttpStatusCode::BAD_REQUEST);
    } else {
        $folder = "..".DS."..".DS."mangas".DS;
        if (file_exists($folder.$name)) {
            try {
                $success = deleteDirectory($folder.$name);
                echo json_encode(array(
                    "success" => $success
                ));
            } catch (Exception $exc) {
                echo json_encode(array(
                    "success" => false,
                    "error" => utf8_encode($exc->getMessage())
                ));
            }
        }
    }
} else {
    http_response_code(HttpStatusCode::FORBIDDEN);
}