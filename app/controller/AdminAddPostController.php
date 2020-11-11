<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\AdminPostsService;

class AdminAddPostController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index(): void
    {
        $model = new AdminPostsService();
        $this->renderer->render("adminAddPost.html.twig", $model->getModel());
    }
}
