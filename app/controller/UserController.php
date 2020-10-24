<?php


namespace App\controller;



use App\core\Renderer;
use App\core\service\ConnectionService;
use App\core\service\HomeService;
use App\core\service\UserService;
use App\model\UserModel;


class UserController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function addUser($formAddUser) {
        $service = new HomeService();
        $userService = new UserService();
        $userService->addUser($formAddUser);
        $this->renderer->render("home.html.twig", $service->getModel());
    }

    public function userExist($email) {
        $service = new UserService();
        return $service->userExist($email);
    }

    public function signIn ($signInForm) {
        $service = new UserService();
        $user = $service->signIn($signInForm['email']);
        if (isset($user) && $service->controlPassword(hashPassword($signInForm['password']), $user->getPassword())) {
            $homeService = new HomeService();
            $_SESSION['user'] = $user;
            $_SESSION['token'] = generateToken();
            $this->renderer->render("home.html.twig", $homeService->getModel());
        }
        return null;
    }

    public function resetPassword ($email) {
        $model = new ConnectionService();
        $homeModel =  $model->getModel();
        if ($this->userExist($email)) {
            $homeModel['resetPassword'] = true;
            $homeModel['email'] = $email;
        } else {
            $homeModel['noUserExist'] = true;
        }
        $this->renderer->render("connection.html.twig", $homeModel);
    }

    public function controlPassword ($password1, $password2) {
        $service = new UserService();
        return $service->controlPassword($password1, $password2);
    }

    public function updatePassword ($newPassword, $email) {
        $userService = new UserService();
        $userService->updatePassword($newPassword, $email);
        $connectionService = new ConnectionService();
        $homeModel =  $connectionService->getModel();
        $this->renderer->render("connection.html.twig", $homeModel);
    }
}