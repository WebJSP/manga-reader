<?php 
    define('DS'                         , DIRECTORY_SEPARATOR);
    define('APP_FOLDER'                 , '/');
    define('MANGAS_FOLDER'              , 'mangas');
    $ADMIN_IDs = array( 2807710899 );
    $requestScheme = filter_input(INPUT_SERVER, "REQUEST_SCHEME");
    $httpHost = filter_input(INPUT_SERVER, "HTTP_HOST");
    $config = array("base_url" => $requestScheme."://".$httpHost.APP_FOLDER."phplib/hybridauth/index.php", 
        "providers" => array ( 
            "Twitter" => array ( 
                "enabled" => true,
                "keys"    => array ( "key" => "uwFVJG4r4STZg8kgI13JDXZTO", 
                    "secret" => "dJvMmCwomGUbp19nwCTfVBJz3nAdCnt342mjuWwMpjg1BDdlsB" ) 
            ),
        ),
        // if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
        "debug_mode" => false,
        "debug_file" => "debug.log"
    );    

    function getFirstManga($dir) {
        foreach (new DirectoryIterator($dir.DS.MANGAS_FOLDER) as $dirInfo) {
            if ($dirInfo->isDot()) {
                continue;
            }
            if (!$dirInfo->isDir()) {
                continue;
            }
            return $dirInfo->getFilename();
        }
        return "";
    }