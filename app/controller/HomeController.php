<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\HomeService;
use App\entity\FooterEntity;
use App\entity\HeaderEntity;
use App\core\entity\HomeEntity;
use App\Model\FooterModel;
use App\Model\HeaderModel;
use App\Model\HomeModel;

class HomeController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index()
    {
        $model = new HomeService();
        $this->renderer->render("home.html.twig", $model->getModel());
    }
}