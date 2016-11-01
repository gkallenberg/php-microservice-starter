<?php
namespace NYPL\Starter;

class MessageHandler
{
    /**
     * @var string
     */
    public static $broker = '';

    public static function initializeBroker($broker)
    {
        self::setBroker($broker);
    }

    /**
     * @return string
     */
    public static function getBroker()
    {
        return self::$broker;
    }

    /**
     * @param string $broker
     */
    public static function setBroker($broker)
    {
        self::$broker = $broker;
    }
}
