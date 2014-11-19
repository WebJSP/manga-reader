<?php
session_start();
require_once '../../phplib/HttpStatusCode.php';
require_once '../../config/config.inc.php';
header('Content-Type: application/json; charset=utf-8');
//error_reporting(0);
if (isset($_SESSION['admin_id']) && in_array($_SESSION['admin_id'], $ADMIN_IDs)) {
    $name = filter_input(INPUT_POST, "manga-name");
    if (!isset($name)) {
        http_response_code(HttpStatusCode::BAD_REQUEST);
    } else {
        $title = filter_input(INPUT_POST, "manga-title");
        if (!isset($title)) {
            http_response_code(HttpStatusCode::BAD_REQUEST);
        } else {
            $folder = "..".DS."..".DS."mangas".DS;
            if (file_exists($folder.$name)) {
                http_response_code(HttpStatusCode::NOT_ACCEPTABLE);
            } else {
                try {
                    mkdir($folder.$name, 0775);
                    file_put_contents($folder.$name.DS."title.txt", utf8_encode($title));
                    echo json_encode(array(
                        "success" => true,
                        "name" => utf8_encode($name),
                        "title" => utf8_encode($title)
                    ));
                } catch (Exception $exc) {
                    echo json_encode(array(
                        "success" => false,
                        "error" => utf8_encode($exc->getMessage())
                    ));
                }
            }
        }
    }
} else {
    http_response_code(HttpStatusCode::FORBIDDEN);
}