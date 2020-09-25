<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;

class HeaderEntity extends DataAccessManager
{
    protected static $table = 'header';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new HeaderEntity();
        }
        return self::$_instance;
    }
}