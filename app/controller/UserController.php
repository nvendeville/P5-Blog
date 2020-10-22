<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\HomeService;
use App\core\service\UserService;


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
}