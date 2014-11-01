<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

$folder = filter_input(INPUT_POST, "folder");
if (!isset($folder)) {
    $folder = filter_input(INPUT_GET, "folder");
}

if (isset($folder)) {
    $folders = array();
    foreach (new DirectoryIterator('../'.$folder) as $dirInfo) {
        if($dirInfo->isDot()) 
            continue;
        if(!$dirInfo->isDir()) 
            continue;
        $path = $folder.'/'.$dirInfo->getFilename();
        $files = array();
        foreach (new DirectoryIterator('../'.$path) as $fileInfo) {
            if($fileInfo->isDot() || !$fileInfo->isFile()) 
                continue;
            if($fileInfo->getExtension()=='json')
                continue;
            $files[] = $path.'/'.$fileInfo->getFilename();
        }
        sort($files, SORT_STRING);
        $info = json_decode(utf8_encode(file_get_contents('../'.$path.".json")), true);
        $contents = array();
        $contents["path"]=$path;
        $contents["files"]=$files;
        $contents["info"]=$info;
        $folders[] = $contents;
        usort($folders, "folderCompare");
    }
    //sort($folders, SORT_STRING);
    echo json_encode($folders);
} else {
    echo "[]";
}

function folderCompare($a, $b){
    return strnatcmp($a["path"], $b["path"]);
}
