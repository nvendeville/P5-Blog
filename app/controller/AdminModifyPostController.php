<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\AdminPostsService;

class AdminModifyPostController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function index(int $postId, int $currentPage): void
    {
        $service = new AdminPostsService();
        $post = $service->getPost($postId);
        $post["currentPage"] = $currentPage;
        $this->renderer->render("adminModifyPost.html.twig", $post);
    }

    public function modifyPost(array $formModifyPost, int $postId, int $currentPage): array
    {
        $service = new AdminPostsService();
        $service->modifyPost($formModifyPost, $postId);
        return $service->getAll($currentPage);
    }
}
