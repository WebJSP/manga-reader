<?php 
    define('DS'                         , DIRECTORY_SEPARATOR);
    define('APP_FOLDER'                 , '/');
    define('MANGAS_FOLDER'              , 'mangas');
    $ADMIN_IDs = array( 2807710899 );
    $languageCode = getUserLanguage();
    $phrases = getPhrases($languageCode);
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
        "debug_mode" => false,
        "debug_file" => "debug.log"
    );    

    function getPhrases($language) {
        $fileName = dirname(__DIR__).DS."assets".DS."locales".DS."locale.".$language.".json";
        if (!file_exists($fileName)) {
            $fileName = dirname(__DIR__).DS."assets".DS."locales".DS."locale.en.json";
        }
        return json_decode(utf8_encode(file_get_contents($fileName)), true);
    }
    
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
    
    function getUserLanguage() {
        $parts = explode(';', filter_input(INPUT_SERVER, "HTTP_ACCEPT_LANGUAGE"));
        $langs = explode(',', $parts[0]);        
        //extract most important (first)
        foreach ($langs as $lang) { 
            break; 
        }
        //if complex language simplify it
        if (stristr($lang,"-")) {
            $tmp = explode("-", $lang); 
            $lang = $tmp[0]; 
        }
        return $lang;
    }