<?php


namespace App\controller;


use App\core\Renderer;
use App\core\service\HomeService;

class HomeController
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index()
    {
        $homeService = new HomeService();
        $homeModel = $homeService->getModel();
        $this->renderer->render("home.html.twig", $homeModel);
    }

    public function sendContactRequest ($contactForm) {
        $homeService = new HomeService();
        $homeService->sendContactRequest($contactForm);
        $_SESSION['otherModel'] = ['mailSent' => true];
    }

    public function persoHomePage ($persoHomeForm) {
        $homeService = new HomeService();
        $homeService->persoHomePage($persoHomeForm);
    }
}