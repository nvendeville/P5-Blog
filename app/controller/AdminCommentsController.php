<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\AdminCommentsService;
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
}