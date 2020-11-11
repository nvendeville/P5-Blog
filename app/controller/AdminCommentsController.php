<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\AdminCommentsService;
use App\core\service\PostService;

class AdminCommentsController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    public function index(int $currentPage): void
    {
        $service = new AdminCommentsService();
        $this->renderer->render("adminComments.html.twig", $service->getAll($currentPage));
    }

    public function validateComment(int $commentId, int $currentPage): void
    {
        $service = new AdminCommentsService();
        $this->renderer->render("adminComments.html.twig", $service->validateComment($commentId, $currentPage));
    }

    public function rejectComment(int $commentId, int $currentPage): void
    {
        $service = new AdminCommentsService();
        $this->renderer->render("adminComments.html.twig", $service->rejectComment($commentId, $currentPage));
    }

    public function addComment(array $formAddComment): void
    {
        $service = new AdminCommentsService();
        $service->addComment($formAddComment);
        $postService = new PostService();
        $postModel = $postService->getPost($formAddComment['idPost']);
        $postModel['addedComment'] = true;
        $this->renderer->render("postDetail.html.twig", $postModel);
    }
}
