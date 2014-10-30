<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

$folder = $_POST["folder"];
if (!isset($folder)) {
	$folder = $_GET["folder"];
}
$folders = array();
foreach (new DirectoryIterator($folder) as $fileInfo) {
    if($fileInfo->isDot()) 
    	continue;
    if(!$fileInfo->isDir()) 
    	continue;
    $folders[] = $folder.'/'.$fileInfo->getFilename();
}
sort($folders, SORT_STRING);
echo json_encode($folders);
?>