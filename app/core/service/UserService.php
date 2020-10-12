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
    }

}