<?php


namespace App\core\service;


use App\core\entity\UserEntity;
use App\model\UserModel;

class UserService extends AbstractService
{

    public function addUser($formAddUser) {
        $userModel = new UserModel();
        $this->hydrateFromPostArray($formAddUser, $userModel);
        UserEntity::getInstance()->addUser($userModel);
        return UserEntity::getInstance()->getUserByEmail($userModel->getEmail());
    }

    public function userExist ($email) {
        return UserEntity::getInstance()->userExist($email) != null;
    }


    public function signIn ($email) {
        $user =  UserEntity::getInstance()->getUserByEmail($email);
        if (isset($user)) {
            $userModel = new UserModel();
            $this->hydrate($user, $userModel);
            return $userModel;
        }
        return null;
    }

    public function controlPassword ($password1, $password2) {
        return $password1 == $password2;
    }

    public function updatePassword ($newPassword, $email) {
        UserEntity::getInstance()->updatePassword($newPassword, $email);
    }
}