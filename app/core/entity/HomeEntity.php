<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;

class HomeEntity extends DataAccessManager
{
    protected static $table = 'home';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new HomeEntity();
        }
        return self::$_instance;
    }
}