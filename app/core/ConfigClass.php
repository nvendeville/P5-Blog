<?php

namespace App\core;

class ConfigClass
{

    private static $instance;
    private $settings = [];

    private function __construct()
    {
        $this->settings = require dirname(__DIR__) . '/core/config.php';
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new ConfigClass();
        }
        return self::$instance;
    }

    public function get(string $key): ?string
    {
        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }
}
