<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

$path = $_POST["path"];
if (!isset($path)) {
	$folder = $_POST["folder"];
	$volume = $_POST["volume"];
	$path = $folder.'/volume'.$volume;
}
$files = array();
foreach (new DirectoryIterator($path) as $fileInfo) {
    if($fileInfo->isDot() || !$fileInfo->isFile()) 
    	continue;
    if($fileInfo->getExtension()=='json')
    	continue;
    $files[] = $path.'/'.$fileInfo->getFilename();
}
sort($files, SORT_STRING);
echo json_encode($files);
?>