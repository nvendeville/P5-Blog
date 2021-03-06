<?php

declare(strict_types=1);

namespace App\core\database;

use _HumbugBox50262afef792\Nette\Neon\Exception;
use App\core\ConfigClass;
use PDO;
use PDOStatement;

class DataAccessManager
{
    protected static PDO $pdo;
    protected static string $table;

    public function __construct()
    {
    }

    public function one(string $statement, string $class): object
    {
        $req = self::getPdo()->query($statement);
        if ($req === false) {
            throw new Exception();
        }
        $req->setFetchMode(PDO::FETCH_CLASS, $class);

        return $req->fetch();
    }

    public function all(string $statement, string $class): array
    {
        $req = self::getPdo()->query($statement);
        if ($req === false) {
            throw new Exception();
        }
        $req->setFetchMode(PDO::FETCH_CLASS, $class);

        return  $req->fetchall();
    }

    public static function getPdo(): PDO
    {
        if (!isset(self::$pdo)) {
            $config = ConfigClass::getInstance();
            $dbName = $config->getString("db_name");
            $dbUser = $config->getString("db_user");
            $dbPass = $config->getString("db_pass");
            $dbHost = $config->getString("db_host");
            $pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo = $pdo;
        }

        return self::$pdo;
    }

    public function getById(int $idInTable, string $class): object
    {
        $req = self::getPdo()->query("
            SELECT *
            FROM " . static::$table . " 
            WHERE id = '" . $idInTable . "'");
        if ($req === false) {
            throw new Exception();
        }
        $req->setFetchMode(PDO::FETCH_CLASS, $class);

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
