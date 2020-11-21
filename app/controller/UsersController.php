<?php

namespace App\controller;

use App\core\service\UserService;

class UsersController extends AbstractController
{

    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    public function addUser(array $formAddUser): void
    {
        $user = $this->userService->addUser($formAddUser);
        $this->sessionManager->sessionSet('user', $user);
        $this->sessionManager->sessionSet('token', generateToken());
        redirect($formAddUser["redirect"]);
    }

    public function login(array $signInForm): void
    {
        $this->sessionManager->sessionSet('otherModel', ['wrongPassword' => true]);
        $user = $this->userService->signIn($signInForm['email']);
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

    public function resetPassword(array $resetPasswordForm): void
    {
        $this->sessionManager->sessionSet('otherModel', $this->userExist($resetPasswordForm['email']) ? ['resetPassword' => true,
                            'email' => $resetPasswordForm['email']] : ['noUserExist' => true]);

        redirect($resetPasswordForm["redirect"]);
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
