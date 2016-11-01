<?php
namespace NYPL\Starter;

class SierraHandler
{
    /**
     * @var string
     */
    public static $clientId = '';

    /**
     * @var string
     */
    public static $clientSecret = '';

    /**
     * @var string
     */
    public static $baseUrl = '';

    public static function initializeSierra(\stdClass $sierra)
    {
        self::setClientId($sierra->clientId);
        self::setClientSecret($sierra->clientSecret);
        self::setBaseUrl($sierra->baseUrl);
    }

    /**
     * @return string
     */
    public static function getClientId()
    {
        return self::$clientId;
    }

    /**
     * @param string $clientId
     */
    public static function setClientId($clientId)
    {
        self::$clientId = $clientId;
    }

    /**
     * @return string
     */
    public static function getClientSecret()
    {
        return self::$clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public static function setClientSecret($clientSecret)
    {
        self::$clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public static function getBaseUrl()
    {
        return self::$baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public static function setBaseUrl($baseUrl)
    {
        self::$baseUrl = $baseUrl;
    }
}
