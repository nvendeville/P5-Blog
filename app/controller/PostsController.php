<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\CommentService;
use App\core\service\PostService;
use App\core\SessionManager;

class PostsController
{
    use SessionManager;

    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function index(int $currentPage): void
    {
        $service = new PostService();
        $this->renderer->render("post.html.twig", $service->getBlog($currentPage));
    }

    public function detail(int $postId): void
    {
        $service = new PostService();
        $this->renderer->render("postDetail.html.twig", $service->getPostDetail($postId));
    }

    public function getPostsByCategory(string $categoryName, int $currentPage = 1): void
    {
        $category = str_replace('_', ' ', $categoryName);
        $service = new PostService();
        $this->renderer->render("post.html.twig", $service->getPostsByCategory($category, $currentPage));
    }

    public function addComment(array $formAddComment): void
    {
        $service = new CommentService();
        $service->addComment($formAddComment);
        $this->sessionSet('otherModel', ['addedComment' => true]);
        redirect("/P5-blog/posts/detail:" . $formAddComment["idPost"]);
    }
}
