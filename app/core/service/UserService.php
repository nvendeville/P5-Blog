<?php

namespace App\core\service;

use App\core\entity\UserEntity;
use App\core\SessionManager;
use App\model\UserModel;

class UserService extends AbstractService
{

    private UserEntity $userEntity;
    private SessionManager $sessionManager;

    public function __construct()
    {
        parent::__construct();
        $this->sessionManager = new SessionManager();
        $this->userEntity = UserEntity::getInstance();
    }

    public function addUser(array $formAddUser): object
    {
        $userModel = new UserModel();
        $this->hydrateFromPostArray($formAddUser, $userModel);
        $this->userEntity->addUser($userModel);
        return $this->userEntity->getUserByEmail($userModel->getEmail());
    }

    public function userExist(string $email): bool
    {
        return $this->userEntity->userExist($email) != null;
    }


    public function signIn(string $email): ?object
    {
        $userModel = new UserModel();
        $user = $this->userEntity->getUserByEmail($email);
        if (isset($user)) {
            $this->hydrate($user, $userModel);
            return $userModel;
        }
        return null;
    }

    public function logout(): void
    {
        $this->sessionManager->sessionUnset('user', 'token', 'isAdmin');
    }

    public function controlPassword(string $password1, string $password2): bool
    {
        return $password1 == $password2;
    }

    public function updatePassword(string $newPassword, string $email): void
    {
        $this->userEntity->updatePassword($newPassword, $email);
    }
}
