<?php
namespace NYPL\Starter;

class ServiceCheck
{
    public function checkRequirements()
    {
        if (!file_exists(__DIR__ . '/app/config/config.yml')) {
            throw new \Exception('Configuration file is missing.');
        }
    }
}
