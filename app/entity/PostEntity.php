<?php


namespace App\entity;


use App\Core\Database\DataAccessManager;

class PostEntity extends DataAccessManager
{
    protected static $table = 'posts';

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new PostEntity();
        }
        return self::$_instance;
    }
}