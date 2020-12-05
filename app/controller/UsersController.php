<?php

declare(strict_types=1);

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
        $this->sessionManager->sessionSetArray(
            'otherModel',
            ['wrongPassword' => true]
        );
        if ($this->controlPassword($formAddUser['password'], $formAddUser['passwordConfirmed'])) {
            $user = $this->userService->addUser($formAddUser);
            $this->sessionManager->sessionSetUser('user', $user);
            $this->sessionManager->sessionSetString('token', generateToken());
            $this->sessionManager->sessionUnset('otherModel');
        }

        redirect($formAddUser["redirect"]);
    }

    public function login(array $signInForm): void
    {
        $this->sessionManager->sessionSetArray('otherModel', ['wrongPassword' => true]);
        $user = $this->userService->signIn($signInForm['email']);
        if ($this->userService->controlPassword(hashPassword($signInForm['password']), $user->getPassword())) {
            $this->sessionManager->sessionSetUser('user', $user);
            $this->sessionManager->sessionSetString('token', generateToken());
            $this->sessionManager->sessionUnset('otherModel');
        }
        redirect($signInForm["redirect"]);
    }

    public function logout(): void
    {
        $this->userService->logout();
        redirect('/P5-Blog');
    }

    public function resetPassword(array $resetPasswordForm): void
    {
        $this->sessionManager->sessionSetArray(
            'otherModel',
            $this->userExist($resetPasswordForm['email']) ? ['resetPassword' => true,
            'email' => $resetPasswordForm['email']] : ['noUserExist' => true]
        );

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

    public function updatePassword(array $updatePasswordForm): void
    {
        $this->sessionManager->sessionSetArray(
            'otherModel',
            ['wrongPassword' => true]
        );
        if ($this->controlPassword($updatePasswordForm['newPassword'], $updatePasswordForm['confirmedNewPassword'])) {
            $this->userService->updatePassword($updatePasswordForm['newPassword'], $updatePasswordForm['email']);
            $user = $this->userService->signIn($updatePasswordForm['email']);
            $this->sessionManager->sessionSetUser('user', $user);
            $this->sessionManager->sessionSetString('token', generateToken());
            $this->sessionManager->sessionUnset('otherModel');
        }
        redirect($updatePasswordForm["redirect"]);
    }
}
