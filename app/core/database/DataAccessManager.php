<?php

namespace App\core\database;

use _HumbugBox50262afef792\Nette\Neon\Exception;
use App\core\ConfigClass;
use PDO;
use PDOStatement;

class DataAccessManager
{
    protected static PDO $pdo;
    protected static string $table;

    protected function __construct()
    {
    }

    public function one(string $statement): object
    {
        $req = self::getPdo()->query($statement);
        if ($req === false) {
            throw new Exception();
        }
        $req->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $req->fetch();
    }

    public function all(string $statement): array
    {
        $req = self::getPdo()->query($statement);
        if ($req === false) {
            throw new Exception();
        }
        $req->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return  $req->fetchall();
    }

    public static function getPdo(): PDO
    {
        if (!isset(self::$pdo)) {
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

    public function getById(int $idInTable): object
    {
        $req = self::getPdo()->query("
            SELECT *
            FROM " . static::$table . " 
            WHERE id = '" . $idInTable . "'");
        if ($req === false) {
            throw new Exception();
        }
        $req->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $req->fetch();
    }

    protected function prepare(string $statement, array $attributes, string $className): PDOStatement
    {
        $req = self::getPdo()->prepare($statement);
        if ($req == false) {
            throw new Exception();
        }
        $req->execute($attributes);
        $req->setFetchMode(PDO::FETCH_CLASS, $className);
        return $req;
    }
}
