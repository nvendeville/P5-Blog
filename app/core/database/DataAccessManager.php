<?php

namespace App\Core\Database;

use App\Core\ConfigClass;
use \PDO;

class DataAccessManager
{

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    protected static $_instance;
    private $pdo;

    protected function __construct()
    {

        $config = ConfigClass::getInstance();

        $this->db_name = $config->get("db_name");
        $this->db_user = $config->get("db_user");
        $this->db_pass = $config->get("db_pass");
        $this->db_host = $config->get("db_host");

        $this->connect();
    }

    private static function getTable () {

        if (static::$table === null) {
            $class_name = explode('\\', get_called_class());
            static::$table = strtolower (end($class_name)) . 's';
        }
        return static::$table;
    }

    private function connect()
    {
        $pdo = new PDO("mysql:dbname=$this->db_name;host=$this->db_host", $this->db_user, $this->db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    public function all($one = false) {
        return self::query("
            SELECT *
            FROM " . static::getTable(), get_called_class(), $one);
    }

    protected function query($statement, $class_name, $one) {
        $req = $this->pdo->query($statement);
        $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchall();
        }
        return $data;
    }

    protected function prepare ($statement, $attributes, $class_name, $one = false) {
        $req = $this->pdo->prepare($statement);
        $req->execute($attributes);
        $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchall();
        }
        return $data;
    }
}