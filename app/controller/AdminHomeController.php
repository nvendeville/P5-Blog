<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\AdminHomeService;

class AdminHomeController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index(): void
    {
        $model = new AdminHomeService();
        $this->renderer->render("adminHome.html.twig", $model->getModel());
    }
}
