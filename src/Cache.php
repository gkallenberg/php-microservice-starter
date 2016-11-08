<?php
namespace NYPL\Starter;

class Cache
{
    /**
     * @var \Redis
     */
    public static $cache;

    protected static function initializeCache()
    {
        $redis = new \Redis();
        $redis->connect(CacheHandler::getCacheHost(), CacheHandler::getCachePort());

        self::setCache($redis);
    }

    /**
     * @return \Redis
     */
    public static function getCache()
    {
        if (!self::$cache) {
            self::initializeCache();
        }

        return self::$cache;
    }

    /**
     * @param \Redis $cache
     */
    public static function setCache($cache)
    {
        self::$cache = $cache;
    }
}
