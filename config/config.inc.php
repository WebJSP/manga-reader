<?php 
    define('DS'                         , DIRECTORY_SEPARATOR);
    define('ADMIN_ID'                   , 2807710899);
    define('APP_FOLDER'                 , '/manga-reader');

    $config = array("base_url" => $_SERVER["REQUEST_SCHEME"]."://".$_SERVER['HTTP_HOST'].APP_FOLDER."/phplib/hybridauth/index.php", 
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
