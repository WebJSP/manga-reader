<?php
require_once '../../config/config.inc.php';
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
?>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Folder</th>
            <th>Creation</th>
        </tr>
    </thead>
    <tbody>
<?php
$folder = "..".DS."..".DS."mangas".DS;
$rowNo = 1;
foreach (new DirectoryIterator($folder) as $dirInfo) {
    if ($dirInfo->isDot()) {
        continue;
    }
    if (!$dirInfo->isDir()) {
        continue;
    }
    $title = file_get_contents($folder.$dirInfo->getFilename().DS.'title.txt');
    echo "        <tr>\n";
    echo "            <td>".$rowNo++."</td>\n";
    echo "            <td>".htmlspecialchars($title, ENT_HTML5, "UTF-8")."</td>\n";
    echo "            <td>".htmlspecialchars($dirInfo->getFilename().DS, ENT_HTML5, "UTF-8")."</td>\n";
    echo "            <td>".htmlspecialchars(date("j/n/Y", $dirInfo->getMTime()), ENT_HTML5, "UTF-8")."</td>\n";
    echo "        </tr>\n";
}
?>
    </tbody>
</table>