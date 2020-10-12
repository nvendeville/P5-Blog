<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\PostService;

class PostController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index($currentPage)
    {
        $service = new PostService();
        $this->renderer->render("post.html.twig", $service->getAll($currentPage));
    }

    public function detail($id) {
        $service = new PostService();
        $this->renderer->render("postdetail.html.twig", $service->getPost($id));
    }


}