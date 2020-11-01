<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;

class UserEntity extends DataAccessManager
{
    protected static $table = 'users';
    protected static $_instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new UserEntity();
        }
        return self::$_instance;
    }

    public function addUser($userModel)
    {
        $statement =
            "INSERT INTO `users` (`firstname`, `lastname`, `avatar`, `password`, `email`, `isAdmin`) 
            VALUES (?,?,?,?,?,?)";
        $values = [$userModel->getFirstname(),
            $userModel->getLastname(),
            $userModel->getAvatar(),
            hashPassword($userModel->getPassword()),
            $userModel->getEmail(),
            $userModel->getIsAdmin()];
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }

    public function userExist($email)
    {
        $statement = "SELECT 1 as userExist FROM `users` WHERE email=?";
        return $this->prepareAndFetch($statement, [$email], get_called_class(), true);
    }


    public function getUserByEmail($email)
    {
        $statement = "SELECT * FROM `users` WHERE email=?";
        return $this->prepareAndFetch($statement, [$email], get_called_class(), true);

    }

    public function updatePassword($newPassword, $email)
    {
        $statement = "UPDATE `users` SET password=? WHERE email=?";
        $values = [hashPassword($newPassword), $email];
        $update = $this->pdo->prepare($statement);
        $update->execute($values);
    }
}