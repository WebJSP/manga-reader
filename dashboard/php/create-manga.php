<?php
require_once '../../phplib/HttpStatusCode.php';
require_once '../../config/config.inc.php';
header('Content-Type: application/json; charset=utf-8');
//error_reporting(0);
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
            mkdir($folder.$name, 0775);
            file_put_contents($folder.$name.DS."title.txt", utf8_encode($title));
        }
    }
}