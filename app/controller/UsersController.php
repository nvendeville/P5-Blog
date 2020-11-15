<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\UserService;
use App\core\SessionManager;

class UsersController
{
    use SessionManager;

    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function addUser(array $formAddUser): void
    {
        $userService = new UserService();
        $this->sessionSet('user', $userService->addUser($formAddUser));
        $this->sessionSet('token', generateToken());
    }

    public function login(array $signInForm): void
    {
        $service = new UserService();
        $user = $service->signIn($signInForm['email']);
        $this->sessionSet('otherModel', ['wrongPassword' => true]);
        if (isset($user) && $service->controlPassword(hashPassword($signInForm['password']), $user->getPassword())) {
            $this->sessionSet('user', $user);
            $this->sessionSet('token', generateToken());
            $this->sessionUnset('otherModel');
        }
        redirect($signInForm["redirect"]);
    }

    public function resetPassword(string $email): void
    {
        $this->sessionSet('otherModel', $this->userExist($email) ? ['resetPassword' => true,
                            'email' => $email] : ['noUserExist' => true]);
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
