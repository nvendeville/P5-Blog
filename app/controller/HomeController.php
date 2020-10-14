<?php


namespace App\controller;


use App\core\Mailer;
use App\core\Renderer;
use App\core\service\HomeService;

class HomeController
{
    use Mailer;
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index()
    {
        $model = new HomeService();
        $this->renderer->render("home.html.twig", $model->getModel());
    }

    public function generateContactEmail ($contactForm) {
        $this->sendMail($contactForm);
        return $this->index();
    }
}