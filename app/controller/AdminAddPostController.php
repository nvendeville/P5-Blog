<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\AdminAddPostService;
use App\entity\FooterEntity;
use App\entity\HeaderEntity;

class AdminAddPostController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index()
    {
        $model = new AdminAddPostService();
        $this->renderer->render("adminAddPost.html.twig", $model->getModel());
    }


}