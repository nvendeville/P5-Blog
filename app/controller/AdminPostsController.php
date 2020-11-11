<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\AdminPostsService;

class AdminPostsController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function index(int $currentPage): void
    {
        $service = new AdminPostsService();
        $this->renderer->render("adminPosts.html.twig", $service->getAll($currentPage));
    }

    public function detail(int $postId): void
    {
        $service = new AdminPostsService();
        $this->renderer->render("postDetail.html.twig", $service->getPost($postId));
    }

    public function addPost(array $formAddPost): void
    {
        $service = new AdminPostsService();
        $service->addPost($formAddPost);
        $this->renderer->render("adminPosts.html.twig", $service->getAll(1));
    }


    public function validatePost(int $postId, int $currentPage): void
    {
        $service = new AdminPostsService();
        $this->renderer->render("adminPosts.html.twig", $service->validatePost($postId, $currentPage));
    }

    public function archivePost(int $postId, int $currentPage): void
    {
        $service = new AdminPostsService();
        $this->renderer->render("adminPosts.html.twig", $service->archivePost($postId, $currentPage));
    }
}
