<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;

class UserEntity extends DataAccessManager
{
    protected static string $table = 'users';
    protected static UserEntity $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new UserEntity();
        }
        return self::$instance;
    }

    public function addUser(object $userModel): void
    {
        $statement = "INSERT INTO `users` (`firstname`, `lastname`, `avatar`, `password`, `email`, `isAdmin`) 
            VALUES (?,?,?,?,?,?)";
        $values = [$userModel->getFirstname(), $userModel->getLastname(), $userModel->getAvatar(),
            hashPassword($userModel->getPassword()), $userModel->getEmail(), $userModel->getIsAdmin()];
        $insert = self::getPdo()->prepare($statement);
        $insert->execute($values);
    }

    public function userExist(string $email)
    {
        $statement = "SELECT 1 as userExist FROM `users` WHERE email=?";
        return $this->prepareAndFetch($statement, [$email], get_called_class(), true);
    }

    public function getUserByEmail($email)
    {
        $statement = "SELECT * FROM `users` WHERE email=?";
        return $this->prepareAndFetch($statement, [$email], get_called_class(), true);
    }

    public function updatePassword(string $newPassword, string $email): void
    {
        $statement = "UPDATE `users` SET password=? WHERE email=?";
        $values = [hashPassword($newPassword), $email];
        $update = self::getPdo()->prepare($statement);
        $update->execute($values);
    }
}
