<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\CommentService;
use App\core\service\PostService;
use App\core\SessionManager;

class PostsController
{

    private Renderer $renderer;
    private PostService $postService;
    private CommentService $commentService;
    private SessionManager $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager();
        $this->renderer = new Renderer();
        $this->postService = new PostService();
        $this->commentService = new CommentService();
    }

    public function index(int $currentPage): void
    {
        $this->renderer->render("post.html.twig", $this->postService->getBlog($currentPage));
    }

    public function detail(int $postId): void
    {
        $this->renderer->render("postDetail.html.twig", $this->postService->getPostDetail($postId));
    }

    public function getPostsByCategory(string $categoryName, int $currentPage = 1): void
    {
        $category = str_replace('_', ' ', $categoryName);
        $this->renderer->render("post.html.twig", $this->postService->getPostsByCategory($category, $currentPage));
    }

    public function addComment(array $formAddComment): void
    {
        $this->commentService->addComment($formAddComment);
        $this->sessionManager->sessionSet('otherModel', ['addedComment' => true]);
        redirect("/P5-blog/posts/detail:" . $formAddComment["idPost"]);
    }
}
