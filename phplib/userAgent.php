<?php

/**
 * Class that parses information about browser.
 * Based on user agent.
 *
 * Examples (Os, browser, version):
 * Window chrome 32 - Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 Safari/537.36
 *
 */
class UserAgent
{

    /**
     * Platform Windows
     */
    const PLATFORM_WINDOWS = 'windows';

    /**
     * Platform Android
     */
    const PLATFORM_ANDROID = 'android';

    /**
     * Platform Linux
     */
    const PLATFORM_LINUX = 'linux';

    /**
     * Platform Mac
     */
    const PLATFORM_MAC = 'mac';

    /**
     * Platform Robot
     */
    const PLATFORM_BOT = 'bot';

    /**
     * Platform Internet Explorer
     */
    const BROWSER_IE = 'ie';

    /**
     * Browser Firefox
     */
    const BROWSER_FIREFOX = 'firefox';

    /**
     * Browser Chrome
     */
    const BROWSER_CHROME = 'chrome';

    /**
     * Browser Opera
     */
    const BROWSER_OPERA = 'opera';

    /**
     * Browser Netscape
     */
    const BROWSER_NETSCAPE = 'netscape';

    /**
     * Browser Unknown
     */
    const BROWSER_UNKNOWN = '?';

    /**
     * User agent
     * @var string
     */
    protected $userAgent = UserAgent::BROWSER_UNKNOWN;

    /**
     * Platform
     *
     * @var string
     */
    protected $platform = UserAgent::BROWSER_UNKNOWN;

    /**
     * Complete name
     *
     * @var string
     */
    protected $completeName = UserAgent::BROWSER_UNKNOWN;

    /**
     * Browser name
     *
     * @var string
     */
    protected $name = UserAgent::BROWSER_UNKNOWN;

    /**
     * Ub
     *
     * @var string
     */
    protected $ub = UserAgent::BROWSER_UNKNOWN;

    /**
     * Version
     *
     * @var string
     */
    protected $version = UserAgent::BROWSER_UNKNOWN;

    /**
     * Simple version
     * @var string
     */
    protected $simpleVersion = UserAgent::BROWSER_UNKNOWN;

    /**
     * Get some information about browser, base on user agent
     *
     * @param string $userAgent
     *
     * @return \UserAgent
     */
    function __construct( $userAgent = NULL )
    {
        //if not passed try to get from server
        if ( !$userAgent && isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) )
        {
            $userAgent = $_SERVER[ 'HTTP_USER_AGENT' ];
        }

        if ( $userAgent )
        {
            $this->userAgent = $userAgent;
            $this->parsePlatform();
            $this->parseBrowser();
            $this->parseVersion();
        }
    }

    /**
     * Parse the platform from string
     */
    protected function parsePlatform()
    {
        //TODO add Ipad, Iphone
        if ( preg_match( '/android/i', $this->userAgent ) )
        {
            $this->platform = self::PLATFORM_ANDROID;
        }
        if ( preg_match( '/linux/i', $this->userAgent ) )
        {
            $this->platform = self::PLATFORM_LINUX;
        }
        elseif ( preg_match( '/macintosh|mac os x/i', $this->userAgent ) )
        {
            $this->platform = self::PLATFORM_MAC;
        }
        elseif ( preg_match( '/windows|win32/i', $this->userAgent ) )
        {
            $this->platform = self::PLATFORM_WINDOWS;
        }
    }

    /**
     * Parse browser name from userAgent
     */
    protected function parseBrowser()
    {
        // Next get the name of the useragent yes seperately and for good reason
        if ( preg_match( '/MSIE/i', $this->userAgent ) && !preg_match( '/Opera/i', $this->userAgent ) )
        {
            $this->completeName = 'Internet Explorer';
            $this->ub = "MSIE";
            $this->name = 'ie';
        }
        elseif ( preg_match( '/Firefox/i', $this->userAgent ) )
        {
            $this->completeName = 'Mozilla Firefox';
            $this->ub = "Firefox";
            $this->name = 'firefox';
        }
        elseif ( preg_match( '/Chrome/i', $this->userAgent ) )
        {
            $this->completeName = 'Google Chrome';
            $this->ub = "Chrome";
            $this->name = 'chrome';
        }
        elseif ( preg_match( '/Safari/i', $this->userAgent ) )
        {
            $this->completeName = 'Apple Safari';
            $this->ub = "Safari";
            $this->name = 'safari';
        }
        elseif ( preg_match( '/Opera/i', $this->userAgent ) )
        {
            $this->completeName = 'Opera';
            $this->ub = "Opera";
            $this->opera = 'opera';
        }
        elseif ( preg_match( '/Netscape/i', $this->userAgent ) )
        {
            $this->completeName = 'Netscape';
            $this->ub = "Netscape";
            $this->name = 'netscape';
        }
        elseif ( preg_match( '/Baiduspider/i', $this->userAgent ) )
        {
            $this->completeName = 'Baiduspider (Robot)';
            $this->ub = "Baiduspider";
            $this->name = 'baiduspider';
            $this->platform = UserAgent::PLATFORM_BOT;
        }
        elseif ( preg_match( '/Googlebot/i', $this->userAgent ) )
        {
            $this->completeName = 'Googlebot (Robot)';
            $this->ub = "Googlebot";
            $this->name = 'googlebot';
            $this->platform = UserAgent::PLATFORM_BOT;
        }
        elseif ( preg_match( '/WebIndex/i', $this->userAgent ) )
        {
            $this->completeName = 'WebIndex (Robot)';
            $this->ub = "WebIndex";
            $this->name = 'webIndex';
            $this->platform = UserAgent::PLATFORM_BOT;
        }
    }

    /**
     * finally get the correct version number
     */
    public function parseVersion()
    {
        $known = array( 'Version', $this->ub, 'other' );
        $pattern = '#(?<browser>' . join( '|', $known ) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        $matches = NULL;

        preg_match( $pattern, $this->userAgent, $matches );

        $this->version = $matches[ 'version' ];

        // check if we have a number
        if ( $this->version == NULL || $this->version == "" )
        {
            $this->version = "?";
        }

        $this->simpleVersion = $this->getSimpleVersion();
    }

    /**
     * This function try to detect if is an old browser
     *
     * @return boolean
     */
    public function isOldBrowser()
    {
        if ( $this->name == UserAgent::BROWSER_IE && $this->version < 8 )
        {
            return TRUE;
        }

        if ( $this->name == UserAgent::BROWSER_FIREFOX && $this->version < 4 )
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Return the userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Return the platform
     *
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Return the version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Return the simple version
     * Normally a int number
     *
     * @return string
     */
    public function getSimpleVersion()
    {
        $version = $this->version;

        if ( mb_stripos( $version, '.' ) > 0 )
        {
            $explode = explode( '.', $version );
            return $explode[ 0 ];
        }

        return $version;
    }

    /**
     * Return the complete name of the browser
     *
     * @return string
     */
    public function getCompleteName()
    {
        return $this->completeName;
    }

    /**
     * Return the simplified name of browser
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}
