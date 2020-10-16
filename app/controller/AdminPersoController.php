<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\AdminPersoService;
use App\core\service\HomeService;
use App\entity\FooterEntity;
use App\entity\HeaderEntity;

class AdminPersoController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index()
    {
        $model = new HomeService();
        $this->renderer->render("adminPerso.html.twig", $model->getModel());
    }
}