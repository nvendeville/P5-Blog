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


    public function index()
    {
        $model = new ConnectionService();
        $this->renderer->render("connection.html.twig", $model->getModel());
    }
}