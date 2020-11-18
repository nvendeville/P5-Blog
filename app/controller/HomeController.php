<?php

namespace App\controller;

use App\core\Renderer;
use App\core\service\HomeService;
use App\core\SessionManager;

/**
 * Class HomeController
 * @package App\controller
 */
class HomeController
{

    /**
     * @var \App\core\Renderer
     */
    private Renderer $renderer;
    private HomeService $homeService;
    private SessionManager $sessionManager;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->sessionManager = new SessionManager();
        $this->renderer = new Renderer();
        $this->homeService = new HomeService();
    }

    /**
     *
     */
    public function index(): void
    {
        $homeModel = $this->homeService->getModel();
        $this->renderer->render("home.html.twig", $homeModel);
    }

    /**
     * @param array $contactForm
     */
    public function sendContactRequest(array $contactForm): void
    {
        $this->homeService->sendContactRequest($contactForm);
        $this->sessionManager->sessionSet('otherModel', ['mailSent' => true]);
        redirect("/P5-Blog/");
    }
}
