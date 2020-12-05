<?php

declare(strict_types=1);

namespace App\controller;

use App\core\service\CommentService;
use App\core\service\PostService;

class PostsController extends AbstractController
{

    private PostService $postService;
    private CommentService $commentService;

    public function __construct()
    {
        parent::__construct();
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
        $this->sessionManager->sessionSetArray('otherModel', ['addedComment' => true]);
        redirect("/P5-blog/posts/detail:" . $formAddComment["idPost"]);
    }
}
