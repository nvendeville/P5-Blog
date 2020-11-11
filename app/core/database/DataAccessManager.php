<?php

namespace App\core\database;

use App\core\ConfigClass;
use PDO;

class DataAccessManager
{

    protected PDO $pdo;
    private $dbName;
    private $dbUser;
    private $dbPass;
    private $dbHost;
    protected static string $table;

    protected function __construct()
    {

        $config = ConfigClass::getInstance();

        $this->dbName = $config->get("db_name");
        $this->dbUser = $config->get("db_user");
        $this->dbPass = $config->get("db_pass");
        $this->dbHost = $config->get("db_host");

        $this->connect();
    }

    private function connect(): void
    {
        $pdo = new PDO("mysql:dbname=$this->dbName;host=$this->dbHost", $this->dbUser, $this->dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
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
        $req = $this->pdo->query($statement);
        $req->setFetchMode(PDO::FETCH_CLASS, $className);
        return $one ? $req->fetch() : $req->fetchall();
    }

    public function getById(int $idInTable)
    {
        return self::query(
            "
            SELECT *
            FROM " . static::$table . " 
            WHERE id = '" . htmlspecialchars($idInTable) . "'",
            get_called_class(),
            true
        );
    }


    protected function prepareAndFetch(string $statement, array $attributes, string $className, bool $one)
    {
        $req = $this->pdo->prepare($statement);
        $req->execute($attributes);
        $req->setFetchMode(PDO::FETCH_CLASS, $className);
        return $one ? $req->fetch() : $req->fetchall();
    }
}
