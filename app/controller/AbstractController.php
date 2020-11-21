<?php

namespace App\controller;

use App\core\Renderer;
use App\core\SessionManager;

class AbstractController
{
    protected Renderer $renderer;
    protected SessionManager $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager();
        $this->renderer = new Renderer();
    }
}