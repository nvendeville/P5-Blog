<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\CommentService;
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
        $this->renderer->render("post.html.twig", $service->getBlog($currentPage));
    }

    public function detail(int $postId): void
    {
        $service = new PostService();
        $this->renderer->render("postDetail.html.twig", $service->getPostDetail($postId));
    }

    public function getPostsByCategory(string $categoryName, int $currentPage): void
    {
        $service = new PostService();
        $this->renderer->render("post.html.twig", $service->getPostsByCategory($categoryName, $currentPage));
    }

    public function addComment(array $formAddComment): void
    {
        $service = new CommentService();
        $service->addComment($formAddComment);
        $postService = new PostService();
        $postModel = $postService->getPost($formAddComment['idPost']);
        $postModel['addedComment'] = true;
        $this->renderer->render("postDetail.html.twig", $postModel);
    }
}
