<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\ConnectionService;

class ConnectionController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index($userExist = false)
    {
        $model = new ConnectionService();
        $homeModel =  $model->getModel();
        $homeModel['userExist'] = $userExist;
        $this->renderer->render("connection.html.twig", $homeModel);
    }
}