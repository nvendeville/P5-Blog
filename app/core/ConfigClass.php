<?php

namespace App\core;

class ConfigClass
{

    private static ConfigClass $instance;
    private array $settings;

    private function __construct()
    {
        $this->settings = require dirname(__DIR__) . '/core/config.php';
    }

    public static function getInstance(): ConfigClass
    {
        if (!isset(self::$instance)) {
            self::$instance = new ConfigClass();
        }
        return self::$instance;
    }

    public function get(string $key): string
    {
        return $this->settings[$key];
    }
}
