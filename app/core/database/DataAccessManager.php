<?php

namespace App\core\database;

use App\core\ConfigClass;
use PDO;

class DataAccessManager
{
    protected static PDO $pdo;
    protected static string $table;

    protected function __construct()
    {
    }

    public function one()
    {
        return $this->all(true);
    }

    public function all($one, $order = "")
    {
        return self::query("
            SELECT *
            FROM " . static::$table . " $order", get_called_class(), $one);
    }

    protected function query($statement, $className, $one)
    {
        $req = self::getPdo()->query($statement);
        $req->setFetchMode(PDO::FETCH_CLASS, $className);
        return $one ? $req->fetch() : $req->fetchall();
    }

    public static function getPdo(): PDO
    {
        if (is_null(self::$pdo)) {
            $config = ConfigClass::getInstance();
            $dbName = $config->get("db_name");
            $dbUser = $config->get("db_user");
            $dbPass = $config->get("db_pass");
            $dbHost = $config->get("db_host");
            $pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo = $pdo;
        }
        return self::$pdo;
    }

    public function getById(int $idInTable)
    {
        return self::query("
            SELECT *
            FROM " . static::$table . " 
            WHERE id = '" . htmlspecialchars($idInTable) . "'", get_called_class(), true);
    }

    protected function prepareAndFetch(string $statement, array $attributes, string $className, bool $one)
    {
        $req = self::getPdo()->prepare($statement);
        $req->execute($attributes);
        $req->setFetchMode(PDO::FETCH_CLASS, $className);
        return $one ? $req->fetch() : $req->fetchall();
    }
}
