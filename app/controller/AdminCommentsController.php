<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\AdminCommentsService;
use App\core\service\AdminPostsService;
use App\core\service\PostService;

class AdminCommentsController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index($currentPage)
    {
        $service = new AdminCommentsService();
        $this->renderer->render("adminComments.html.twig", $service->getAll($currentPage));
    }

    public function validateComment($id, $currentPage)
    {
        $service = new AdminCommentsService();
        $this->renderer->render("adminComments.html.twig", $service->validateComment($id, $currentPage));
    }

    public function rejectComment($id, $currentPage)
    {
        $service = new AdminCommentsService();
        $this->renderer->render("adminComments.html.twig", $service->rejectComment($id, $currentPage));
    }

    public function addComment($formAddComment) {
        $service = new AdminCommentsService();
        $service->addComment($formAddComment);
        $postService = new PostService();
        $this->renderer->render("postdetail.html.twig", $postService->getPost($formAddComment['idPost']));
    }
}