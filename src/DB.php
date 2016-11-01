<?php
namespace NYPL\Starter;

use Slim\PDO\Database;

class DB
{
    /**
     * @var Database
     */
    public static $database;

    public static function initializeDatabase(Database $db)
    {
        self::setDatabase($db);
    }

    /**
     * @return Database
     */
    public static function getDatabase()
    {
        return self::$database;
    }

    /**
     * @param Database $database
     */
    public static function setDatabase($database)
    {
        self::$database = $database;
    }
}
