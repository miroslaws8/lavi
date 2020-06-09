<?php

namespace bundle;

class Config
{
    private static $config = [];

    public static function get(string $key)
    {
        if (!empty(self::$config)) {
            return self::$config[$key];
        }

        $configFile = APP.'config.php';

        if (!file_exists($configFile)) {
            throw new \Exception("Configuration file doesn't exist");
        }

        self::$config = require $configFile. "";

        if (!array_key_exists($key, self::$config)) {
            throw new \Exception($key." in the config was not found");
        }

        return self::$config[$key];
    }
}