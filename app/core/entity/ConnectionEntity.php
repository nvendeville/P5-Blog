<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;

class ConnectionEntity extends DataAccessManager
{
    protected static string $table = 'home';
    protected static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new ConnectionEntity();
        }
        return self::$instance;
    }
}