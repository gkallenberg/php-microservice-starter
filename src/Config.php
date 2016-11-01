<?php
namespace NYPL\Starter;

class Config
{
    public static function load()
    {
        return \Noodlehaus\Config::load(__DIR__ . '/app/config/config.yml');
    }
}
