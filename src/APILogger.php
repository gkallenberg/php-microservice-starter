<?php
namespace NYPL\Starter;

use Monolog\Handler\SlackHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use NYPL\Starter\Config;

class APILogger
{
    /**
     * @var Logger
     */
    public static $logger;

    /**
     * @var SlackHandler
     */
    public static $logHandler;

    /**
     * @return Logger
     */
    public static function getLogger()
    {
        return self::$logger;
    }

    /**
     * @param SlackHandler $logHandler
     */
    public static function initializeLogger(SlackHandler $logHandler)
    {
        $log = new Logger('API');

        //$log->pushHandler(new StreamHandler('error.log', Logger::DEBUG));

        $log->pushHandler($logHandler);

        self::setLogger($log);
    }

    /**
     * @param Logger $logger
     */
    public static function setLogger($logger)
    {
        self::$logger = $logger;
    }

    /**
     * @param int $httpCode
     * @param string $error
     * @param array $context
     *
     * @return bool
     */
    public static function addLog($httpCode = 0, $error = '', array $context = [])
    {
        if ($httpCode == 404) {
            return self::addInfo($error, $context);
        }

        return self::addError($error, $context);
    }

    /**
     * @param string $error
     * @param array $context
     *
     * @return bool
     */
    public static function addInfo($error = '', array $context = [])
    {
        self::getLogger()->addInfo($error, $context);

        return true;
    }

    /**
     * @param string $error
     * @param array $context
     *
     * @return bool
     */
    public static function addError($error = '', array $context = [])
    {
        self::getLogger()->addError($error, $context);

        return true;
    }
}
