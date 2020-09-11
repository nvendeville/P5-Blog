<?php

namespace App\Core;

// Singleton

class ConfigClass
{

    private $settings = [];

    private static $_instance;

    private function __construct()
    {
        $this->settings = require dirname(__DIR__) . '/core/config.php';
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new ConfigClass();
        }
        return self::$_instance;
    }

    public function get($key)
    {
        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }


}