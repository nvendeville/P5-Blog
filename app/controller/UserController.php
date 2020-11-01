<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\UserService;


class UserController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function addUser($formAddUser)
    {
        $userService = new UserService();
        $_SESSION['user'] = $userService->addUser($formAddUser);
        $_SESSION['token'] = generateToken();
    }

    public function signIn($signInForm)
    {
        $service = new UserService();
        $user = $service->signIn($signInForm['email']);
        if (isset($user) && $service->controlPassword(hashPassword($signInForm['password']), $user->getPassword())) {
            $_SESSION['user'] = $user;
            $_SESSION['token'] = generateToken();
        } else {
            $_SESSION['otherModel'] = ['wrongPassword' => true];
        }
    }

    public function resetPassword($email)
    {
        if ($this->userExist($email)) {
            /*
            $homeModel['resetPassword'] = true;
            $homeModel['email'] = $email;
            */
            $_SESSION['otherModel'] = ['resetPassword' => true, 'email' => $email];
        } else {
            //$homeModel['noUserExist'] = true;
            $_SESSION['otherModel'] = ['noUserExist' => true];
        }
    }

    public function userExist($email)
    {
        $service = new UserService();
        return $service->userExist($email);
    }

    public function controlPassword($password1, $password2)
    {
        $service = new UserService();
        return $service->controlPassword($password1, $password2);
    }

    public function updatePassword($newPassword, $email)
    {
        $userService = new UserService();
        $userService->updatePassword($newPassword, $email);
    }
}