<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\AdminHomeService;
use App\core\service\HomeService;
use App\entity\FooterEntity;
use App\entity\HeaderEntity;
use App\core\entity\HomeEntity;
use App\Model\FooterModel;
use App\Model\HeaderModel;
use App\Model\HomeModel;

class AdminHomeController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index()
    {
        $model = new AdminHomeService();
        $this->renderer->render("adminHome.html.twig", $model->getModel());
    }
}