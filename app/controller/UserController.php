<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\UserService;

class UserController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function addUser(array $formAddUser): void
    {
        $userService = new UserService();
        $_SESSION['user'] = $userService->addUser($formAddUser);
        $_SESSION['token'] = generateToken();
    }

    public function signIn(array $signInForm): void
    {
        $service = new UserService();
        $user = $service->signIn($signInForm['email']);
        $_SESSION['otherModel'] = ['wrongPassword' => true];
        if (isset($user) && $service->controlPassword(hashPassword($signInForm['password']), $user->getPassword())) {
            $_SESSION['user'] = $user;
            $_SESSION['token'] = generateToken();
            unset($_SESSION['otherModel']);
        }
    }

    public function resetPassword(string $email): void
    {
        $_SESSION['otherModel'] =
            $this->userExist($email) ? ['resetPassword' => true, 'email' => $email] : ['noUserExist' => true];
    }

    public function userExist(string $email): bool
    {
        $service = new UserService();
        return $service->userExist($email);
    }

    public function controlPassword(string $password1, string $password2): bool
    {
        $service = new UserService();
        return $service->controlPassword($password1, $password2);
    }

    public function updatePassword(string $newPassword, string $email): void
    {
        $userService = new UserService();
        $userService->updatePassword($newPassword, $email);
    }
}
