<?php

declare(strict_types=1);

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

    private function getTwigCoreExtension($twig): CoreExtension
    {
        return $twig->getExtension(CoreExtension::class);
    }

    public function render(string $pageName, array $models): void
    {
        $loader = new FilesystemLoader('app/view');
        $twig = new Environment($loader);
        $this->getTwigCoreExtension($twig)->setDateFormat('d/m/Y H:i', '%d days');
        $models['token'] = $this->sessionManager->sessionGetString('token');
        if ($this->sessionManager->sessionIsset('user')) {
            $models['logged'] = true;
            $models['isAdmin'] = getVal($this->sessionManager->sessionGetUser('user'), 'isAdmin', 'getIsAdmin') == '1';
            $models['firstname'] = getVal($this->sessionManager->sessionGetUser('user'), 'firstname', 'getFirstname');
            $models['idConnectedUser'] = getVal($this->sessionManager->sessionGetUser('user'), 'id', 'getId');
        }
        $models = $this->getOtherModel($models);

         echo $twig->render(htmlspecialchars($pageName), $models);
    }

    private function getOtherModel(array $models): array
    {
        if ($this->sessionManager->sessionIsset('otherModel')) {
            foreach ($this->sessionManager->sessionGetArray('otherModel') as $key => $value) {
                $models[$key] = $value;
            }
            $this->sessionManager->sessionUnset('otherModel');
        }

        return $models;
    }
}
