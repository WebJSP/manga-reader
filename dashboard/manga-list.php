<?php
session_start();
error_reporting(0);
require_once '../phplib/HttpStatusCode.php';
require_once '../config/config.inc.php';
header('Content-Type: application/json; charset=utf-8');
if (isset($_SESSION['admin_id']) && in_array($_SESSION['admin_id'], $ADMIN_IDs)) {
    $current = filter_input(INPUT_POST, "current");
    $rowCount = filter_input(INPUT_POST, "rowCount");
    $searchPhrase = filter_input(INPUT_POST, "searchPhrase");
    $sort = null;
    $params = filter_input_array(INPUT_POST);
    foreach($params as $param => $value) {
        if ($param==="sort") {
            $key = array_keys($value)[0];
            $sort = array(
                "field" => $key, 
                "direction" => $value[$key]
            ); 
            continue;
        }
    }
    if (isset($sort)) {
        $comparableName = "compareBy".ucwords($sort["field"]).ucwords($sort["direction"]);
    }
    $response = array(
        "current" => $current,
        "rowCount" => $rowCount
    );
    $folder = "..".DS."mangas".DS;
    $rowNo = 1;
    $rows = array();
    foreach (new DirectoryIterator($folder) as $dirInfo) {
        if ($dirInfo->isDot()) {
            continue;
        }
        if (!$dirInfo->isDir()) {
            continue;
        }
        $title = file_get_contents($folder.$dirInfo->getFilename().DS.'info'.DS.'title.txt');
        
        $row = array(
            "id"=>$rowNo++,
            "title"=>$title,
            "folder"=>$dirInfo->getFilename(),
            "creation"=>date("j/n/Y", $dirInfo->getMTime()),
            "mtime" => $dirInfo->getMTime()
        );
        array_push($rows, $row);
    }
    if (isset($sort)) {
        usort($rows, $comparableName);
    }
    $response["rows"] = array_slice($rows, $current-1, $rowCount);
    $response["total"] = $rowNo-1;
    echo json_encode($response);
} else {
    http_response_code(HttpStatusCode::FORBIDDEN);
}

function compareByFolderAsc($a, $b){
    return strnatcmp($a["folder"], $b["folder"]);
}
function compareByFolderDesc($a, $b){
    return -compareByFolderAsc($a, $b);
}
function compareByTitleAsc($a, $b){
    return strnatcmp($a["title"], $b["title"]);
}
function compareByTitleDesc($a, $b){
    return -compareByTitleAsc($a, $b);
}
function compareByDateAsc($a, $b){
    return $a["mtime"] - $b["mtime"];
}
function compareByDateDesc($a, $b){
    return -compareByDateAsc($a, $b);
}
