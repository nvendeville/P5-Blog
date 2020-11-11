<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\PostService;

class PostController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index(int $currentPage): void
    {
        $service = new PostService();
        $this->renderer->render("post.html.twig", $service->getAll($currentPage));
    }

    public function detail(int $postId): void
    {
        $service = new PostService();
        $this->renderer->render("postDetail.html.twig", $service->getPost($postId));
    }

    public function getPostsByCategory(string $categoryName, int $currentPage): void
    {
        $service = new PostService();
        $this->renderer->render("post.html.twig", $service->getPostsByCategory($categoryName, $currentPage));
    }
}
