<?php

namespace App\controller;

use App\core\service\HomeService;

class HomeController extends AbstractController
{

    private HomeService $homeService;


    public function __construct()
    {
        parent::__construct();
        $this->homeService = new HomeService();
    }

    public function index(): void
    {
        $homeModel = $this->homeService->getModel();
        $this->renderer->render("home.html.twig", $homeModel);
    }

    public function sendContactRequest(array $contactForm): void
    {
        $this->homeService->sendContactRequest($contactForm);
        $this->sessionManager->sessionSet('otherModel', ['mailSent' => true]);
        redirect("/P5-Blog/");
    }
}
