<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;

class FooterEntity extends DataAccessManager
{
    protected static $table = 'footer';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new FooterEntity();
        }
        return self::$_instance;
    }
}