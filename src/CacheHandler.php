<?php
namespace NYPL\Starter;

class CacheHandler
{
    /**
     * @var string
     */
    public static $cacheHost;

    /**
     * @var string
     */
    public static $cachePort;

    /**
     * @return string
     */
    public static function getCacheHost()
    {
        return self::$cacheHost;
    }

    /**
     * @param string $cacheHost
     */
    public static function setCacheHost($cacheHost)
    {
        self::$cacheHost = $cacheHost;
    }

    /**
     * @return string
     */
    public static function getCachePort()
    {
        return self::$cachePort;
    }

    /**
     * @param string $cachePort
     */
    public static function setCachePort($cachePort)
    {
        self::$cachePort = $cachePort;
    }
}
