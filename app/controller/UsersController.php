<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\UserService;
use App\core\SessionManager;

class UsersController
{

    private Renderer $renderer;
    private UserService $userService;
    private SessionManager $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager();
        $this->renderer = new Renderer();
        $this->userService = new UserService();
    }

    public function addUser(array $formAddUser): void
    {
        $this->sessionManager->sessionSet('user', $this->userService->addUser($formAddUser));
        $this->sessionManager->sessionSet('token', generateToken());
    }

    public function login(array $signInForm): void
    {
        $user = $this->userService->signIn($signInForm['email']);
        $this->sessionManager->sessionSet('otherModel', ['wrongPassword' => true]);
        if (isset($user) && $this->userService->controlPassword(hashPassword($signInForm['password']), $user->getPassword())) {
            $this->sessionManager->sessionSet('user', $user);
            $this->sessionManager->sessionSet('token', generateToken());
            $this->sessionManager->sessionUnset('otherModel');
        }
        redirect($signInForm["redirect"]);
    }

    public function logout()
    {
        $this->userService->logout();
        redirect('/P5-Blog');
    }

    public function resetPassword(string $email): void
    {
        $this->sessionManager->sessionSet('otherModel', $this->userExist($email) ? ['resetPassword' => true,
                            'email' => $email] : ['noUserExist' => true]);
    }

    public function userExist(string $email): bool
    {
        return $this->userService->userExist($email);
    }

    public function controlPassword(string $password1, string $password2): bool
    {
        return $this->userService->controlPassword($password1, $password2);
    }

    public function updatePassword(string $newPassword, string $email): void
    {
        $this->userService->updatePassword($newPassword, $email);
    }
}
