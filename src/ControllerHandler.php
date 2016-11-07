<?php
namespace NYPL\Starter;

class ControllerHandler
{
    /**
     * @var string
     */
    public static $identityHeader;

    public static function initializeIdentityHeader($identityHeader)
    {
        self::setIdentityHeader($identityHeader);
    }

    /**
     * @return string
     */
    public static function getIdentityHeader()
    {
        return self::$identityHeader;
    }

    /**
     * @param string $identityHeader
     */
    public static function setIdentityHeader($identityHeader)
    {
        self::$identityHeader = $identityHeader;
    }
}
