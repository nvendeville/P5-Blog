<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;

class AdminAddPostEntity extends DataAccessManager
{
    protected static $table = 'home';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new AdminAddPostEntity();
        }
        return self::$_instance;
    }
}