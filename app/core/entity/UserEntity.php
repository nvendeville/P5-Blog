<?php

declare(strict_types=1);

namespace App\core\entity;

use App\core\database\DataAccessManager;
use App\model\UserModel;

class UserEntity extends DataAccessManager
{
    protected static string $table = 'users';

    public function addUser(UserModel $userModel): void
    {
        $statement = "INSERT INTO `users` (`firstname`, `lastname`, `avatar`, `password`, `email`, `isAdmin`) 
            VALUES (?,?,?,?,?,?)";
        $values = [$userModel->getFirstname(), $userModel->getLastname(), $userModel->getAvatar(),
            hashPassword($userModel->getPassword()), $userModel->getEmail(), $userModel->getIsAdmin()];
        $insert = self::getPdo()->prepare($statement);
        $insert->execute($values);
    }

    public function getUserByEmail(string $email): UserModel
    {
        $statement = "SELECT * FROM `users` WHERE email=?";
        $req = $this->prepare($statement, [$email], UserModel::class);

        return $req->fetch();
    }

    public function updatePassword(string $newPassword, string $email): void
    {
        $statement = "UPDATE `users` SET password=? WHERE email=?";
        $values = [hashPassword($newPassword), $email];
        $update = self::getPdo()->prepare($statement);
        $update->execute($values);
    }
}
