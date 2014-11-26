<?php
define('DS', DIRECTORY_SEPARATOR);
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

$folder = filter_input(INPUT_POST, "folder");
if (isset($folder)) {
    $folders = array();
    foreach (new DirectoryIterator('..'.DS.$folder) as $dirInfo) {
        if($dirInfo->isDot()) {
            continue;
        }
        if(!$dirInfo->isDir()) {
            continue;
        }
        $path = $folder.DS.$dirInfo->getFilename();
        $files = array();
        foreach (new DirectoryIterator('..'.DS.$path) as $fileInfo) {
            if($fileInfo->isDot() || !$fileInfo->isFile()) {
                continue;
            }
            if($fileInfo->getExtension()=='json') {
                continue;
            }
            $files[] = $path.DS.$fileInfo->getFilename();
        }
        sort($files, SORT_STRING);
        $info = json_decode(utf8_encode(file_get_contents('..'.DS.$path.".json")), true);
        $folders[] = array(
            "path" => $path,
            "files" => $files,
            "info" => $info
        );
        usort($folders, "folderCompare");
    }
    echo json_encode($folders);
} else {
    echo "[]";
}

function folderCompare($a, $b){
    return strnatcmp($a["path"], $b["path"]);
}
