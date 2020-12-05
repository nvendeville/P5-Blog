<?php

declare(strict_types=1);

namespace App\core;

class ConfigClass
{

    private static ConfigClass $instance;
    private array $settings;

    private function __construct()
    {
        $this->settings = getConfig();
    }

    public static function getInstance(): ConfigClass
    {
        if (!isset(self::$instance)) {
            self::$instance = new ConfigClass();
        }

        return self::$instance;
    }

    public function getString(string $key): string
    {
        return $this->settings[$key];
    }

    public function getBool(string $key): bool
    {
        return $this->settings[$key];
    }

    public function getInt(string $key): int
    {
        return $this->settings[$key];
    }
}
