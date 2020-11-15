<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\CommentService;
use App\core\service\HomeService;
use App\core\service\PostService;

class AdminController
{
    private Renderer $renderer;
    private PostService $postService;
    private CommentService $commentService;
    private HomeService $homeService;

    public function __construct()
    {
        $this->renderer = new Renderer();
        $this->postService = new PostService();
        $this->commentService = new CommentService();
        $this->homeService = new HomeService();
    }

    public function createPost(array $formAddPost = []): void
    {
        if (empty($formAddPost)) {
            $this->renderer->render("adminAddPost.html.twig", $this->postService->getHeaders());
            return;
        }
        $this->postService->addPost($formAddPost);
        redirect("/P5-Blog/admin/listPost:1");
    }

    public function listPost(int $currentPage): void
    {
        $this->renderer->render("adminPosts.html.twig", $this->postService->getPosts($currentPage));
    }

    public function updatePost(int $postId, int $currentPage, ?array $formModifyPost = []): void
    {
        if (empty($formModifyPost)) {
            $post = $this->postService->getPost($postId);
            $post["currentPage"] = $currentPage;
            $this->renderer->render("adminModifyPost.html.twig", $post);
            return;
        }
        $this->postService->modifyPost($formModifyPost, $postId);
        redirect("/P5-Blog/admin/listPost:$currentPage");
    }

    public function updateStatusPost(int $postId, string $postStatus, int $currentPage): void
    {
        $this->postService->updateStatus($postId, $postStatus);
        redirect("/P5-Blog/admin/listPost:$currentPage");
    }

    public function listComment(int $currentPage): void
    {
        $this->renderer->render("adminComments.html.twig", $this->commentService->getAll($currentPage));
    }

    public function updateStatusComment(int $commentId, string $commentStatus, int $currentPage): void
    {
        $this->renderer->render(
            "adminComments.html.twig",
            $this->commentService->updateStatus($commentId, $commentStatus, $currentPage)
        );
    }

    public function updateHomePage(array $formUpdateHome = []): void
    {
        if (empty($formUpdateHome)) {
            $this->renderer->render("adminPerso.html.twig", $this->homeService->getModel());
            return;
        }
        $this->homeService->persoHomePage($formUpdateHome);
        redirect("/P5-Blog");
    }
}
