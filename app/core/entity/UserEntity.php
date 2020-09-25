<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;

class UserEntity extends DataAccessManager
{
    protected static $table = 'users';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new UserEntity();
        }
        return self::$_instance;
    }
}