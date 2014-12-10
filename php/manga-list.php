<?php
session_start();
error_reporting(0);
require_once '../phplib/HttpStatusCode.php';
require_once '../config/config.inc.php';
header('Content-Type: application/json; charset=utf-8');
$searchPhrase = filter_input(INPUT_POST, "searchPhrase");
$folder = "..".DS.MANGAS_FOLDER.DS;
$rows = array();
foreach (new DirectoryIterator($folder) as $dirInfo) {
    if ($dirInfo->isDot()) {
        continue;
    }
    if (!$dirInfo->isDir()) {
        continue;
    }
    $info = json_decode(utf8_encode(file_get_contents($folder.$dirInfo->getFilename().DS.'info'.DS.'info.json')), true);
    $row = array(
        "info"=>$info,
        "folder"=>$dirInfo->getFilename(),
        "creation"=>date("j/n/Y", $dirInfo->getMTime()),
        "folders"=>readFolder($dirInfo->getFilename())
    );
    array_push($rows, $row);
}
usort($rows, "compareByFolderAsc");
$response = array(
    "rows" => $rows,
    "total" => count($rows)
);
echo json_encode($response);

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
function folderCompare($a, $b){
    return strnatcmp($a["path"], $b["path"]);
}
function readFolder($folder) {
    $folders = array();
    foreach (new DirectoryIterator('..'.DS.MANGAS_FOLDER.DS.$folder) as $dirInfo) {
        if($dirInfo->isDot()) {
            continue;
        }
        if(!$dirInfo->isDir()) {
            continue;
        }
        if ($dirInfo->getFilename()==="info") {
            continue;
        }
        $path = DS.MANGAS_FOLDER.DS.$folder.DS.$dirInfo->getFilename();
        $info = json_decode(utf8_encode(file_get_contents('..'.DS.$path.".json")), true);
        $folders[] = array(
            "path" => $path,
            "info" => $info
        );
        usort($folders, "folderCompare");
    }
    return $folders;
}