<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\AdminPostsService;

class AdminPostsController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function index($currentPage)
    {
        $service = new AdminPostsService();
        $this->renderer->render("adminPosts.html.twig", $service->getAll($currentPage));
    }

    public function detail($id) {
        $service = new AdminPostsService();
        $this->renderer->render("postdetail.html.twig", $service->getPost($id));
    }

    public function addPost($formAddPost) {
        $service = new AdminPostsService();
        $service->addPost($formAddPost);
        $this->renderer->render("adminPosts.html.twig", $service->getAll(1));

    }

}