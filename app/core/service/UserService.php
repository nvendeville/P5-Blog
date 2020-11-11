<?php

namespace App\core\service;

use App\core\entity\UserEntity;
use App\model\UserModel;

class UserService extends AbstractService
{

    public function addUser(array $formAddUser): object
    {
        $userModel = new UserModel();
        $this->hydrateFromPostArray($formAddUser, $userModel);
        UserEntity::getInstance()->addUser($userModel);
        return UserEntity::getInstance()->getUserByEmail($userModel->getEmail());
    }

    public function userExist(string $email): bool
    {
        return UserEntity::getInstance()->userExist($email) != null;
    }


    public function signIn(string $email): ?object
    {
        $user = UserEntity::getInstance()->getUserByEmail($email);
        if (isset($user)) {
            $userModel = new UserModel();
            $this->hydrate($user, $userModel);
            return $userModel;
        }
        return null;
    }

    public function controlPassword(string $password1, string $password2): bool
    {
        return $password1 == $password2;
    }

    public function updatePassword(string $newPassword, string $email): void
    {
        UserEntity::getInstance()->updatePassword($newPassword, $email);
    }
}
