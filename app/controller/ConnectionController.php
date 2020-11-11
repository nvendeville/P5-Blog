<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\ConnectionService;

class ConnectionController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index(): void
    {
        $model = new ConnectionService();
        $homeModel = $model->getModel();
        $this->renderer->render("connection.html.twig", $homeModel);
    }
}
