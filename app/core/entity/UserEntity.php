<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;

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

    public function addUser($userModel) {
        $statement =
            "INSERT INTO `users` (`firstname`, `lastname`, `avatar`, `username`, `password`, `email`, `isAdmin`) 
            VALUES (?,?,?,?,?,?,?)";
        $values=[];
        array_push($values, htmlspecialchars($userModel->getFirstname()));
        array_push($values, htmlspecialchars($userModel->getLastname()));
        array_push($values, htmlspecialchars($userModel->getAvatar()));
        array_push($values, htmlspecialchars($userModel->getUsername()));
        array_push($values, htmlspecialchars($userModel->getPassword()));
        array_push($values, htmlspecialchars($userModel->getEmail()));
        array_push($values, htmlspecialchars($userModel->getIsAdmin()));
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }
}