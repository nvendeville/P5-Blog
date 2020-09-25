<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;

class AdminHomeEntity extends DataAccessManager
{
    protected static $table = 'home';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new AdminHomeEntity();
        }
        return self::$_instance;
    }
}