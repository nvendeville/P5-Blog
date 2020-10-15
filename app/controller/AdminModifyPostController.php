<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\AdminPostsService;

class AdminModifyPostController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function index($id, $currentPage) {
        $service = new AdminPostsService();
        $post = $service->getPost($id);
        $post["currentPage"] = $currentPage;
        $this->renderer->render("adminModifyPost.html.twig", $post);

    }

    public function modifyPost($formModifyPost, $id, $currentPage) {
        $service = new AdminPostsService();
        $service->modifyPost($formModifyPost, $id);
        return $service->getAll($currentPage);

    }



}