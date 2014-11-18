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
        
//        $langs = array();
//        $acceptLanguage = filter_input(INPUT_SERVER, "HTTP_ACCEPT_LANGUAGE");
//        if (isset($acceptLanguage)) {
//            // break up string into pieces (languages and q factors)
//            $lang_parse = preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $acceptLanguage);
//            if (count($lang_parse[1])) {
//                // create a list like “en” => 0.8
//                $langs = array_combine($lang_parse[1], $lang_parse[4]);
//                // set default to 1 for any without q factor
//                foreach ($langs as $lang => $val) {
//                    if ($val === "") {
//                        $langs[$lang] = 1;
//                    }
//                }
//                // sort list based on value
//                arsort($langs, SORT_NUMERIC);
//            }
//        }
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