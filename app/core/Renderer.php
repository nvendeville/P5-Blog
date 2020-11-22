<?php

namespace App\core;

use Twig\Environment;
use Twig\Extension\CoreExtension;
use Twig\Loader\FilesystemLoader;

class Renderer
{
    private SessionManager $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager();
    }

    public function render(string $pageName, array $models): void
    {
        $loader = new FilesystemLoader('app/view');
        $twig = new Environment($loader);
        $twig->getExtension(CoreExtension::class)->setDateFormat('d/m/Y H:i', '%d days');
        $models['token'] = $this->sessionManager->sessionGet('token');
        if ($this->sessionManager->sessionIsset('user')) {
            $models['logged'] = true;
            $models['isAdmin'] = getVal($this->sessionManager->sessionGet('user'), 'isAdmin', 'getIsAdmin') == '1';
            $models['firstname'] = getVal($this->sessionManager->sessionGet('user'), 'firstname', 'getFirstname');
            $models['idConnectedUser'] = getVal($this->sessionManager->sessionGet('user'), 'idUser', 'getId');
        }
        $models = $this->getOtherModel($models);
        echo $twig->render($pageName, $models);
    }

    private function getOtherModel(array $models): array
    {
        if ($this->sessionManager->sessionIsset('otherModel')) {
            foreach ($this->sessionManager->sessionGet('otherModel') as $key => $value) {
                $models[$key] = $value;
            }
            $this->sessionManager->sessionUnset('otherModel');
        }
        return $models;
    }
}
