<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\HomeService;

class HomeController
{
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }


    public function index(): void
    {
        $homeService = new HomeService();
        $homeModel = $homeService->getModel();
        $this->renderer->render("home.html.twig", $homeModel);
    }

    public function sendContactRequest(array $contactForm): void
    {
        $homeService = new HomeService();
        $homeService->sendContactRequest($contactForm);
        $_SESSION['otherModel'] = ['mailSent' => true];
    }

    public function persoHomePage(array $persoHomeForm): void
    {
        $homeService = new HomeService();
        $homeService->persoHomePage($persoHomeForm);
    }
}
