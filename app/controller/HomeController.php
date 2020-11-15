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
    use SessionManager;

    /**
     * @var \App\core\Renderer
     */
    private Renderer $renderer;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->renderer = new Renderer();
    }

    /**
     *
     */
    public function index(): void
    {
        $homeService = new HomeService();
        $homeModel = $homeService->getModel();
        $this->renderer->render("home.html.twig", $homeModel);
    }

    /**
     * @param array $contactForm
     */
    public function sendContactRequest(array $contactForm): void
    {
        $homeService = new HomeService();
        $homeService->sendContactRequest($contactForm);
        $this->sessionSet('otherModel', ['mailSent' => true]);
        redirect("/P5-Blog/");
    }
}
