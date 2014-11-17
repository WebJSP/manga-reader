<?php
    require_once './config/config.inc.php';
    $location = "reader.php";
    $folder = filter_input(INPUT_GET, "manga");
    if (!isset($folder)) {
        $folder = getFirstManga(__DIR__);
    }
    $location.="?manga=".$folder;
    $volume = filter_input(INPUT_GET, "vol");
    if (!isset($volume)) {
        $volume = 1;
    }
    $location.="&vol=".$volume;
    $page = filter_input(INPUT_GET, "page");
    if (isset($page)) {
        $location.="#page/".$page;
    }

    header("Location: ".$location);
?>