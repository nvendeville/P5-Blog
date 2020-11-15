<?php

namespace App\core;

use Twig\Environment;
use Twig\Extension\CoreExtension;
use Twig\Loader\FilesystemLoader;

class Renderer
{
    use SessionManager;

    public function render(string $pageName, array $models): void
    {
        $loader = new FilesystemLoader('app/view');
        $twig = new Environment($loader);
        $twig->getExtension(CoreExtension::class)->setDateFormat('d/m/Y H:i', '%d days');
        $models['token'] = $this->sessionGet('token');
        if ($this->sessionIsset('user')) {
            $models['logged'] = true;
            $models['isAdmin'] = getVal($this->sessionGet('user'), 'isAdmin', 'getIsAdmin') == '1';
            $models['firstname'] = getVal($this->sessionGet('user'), 'firstname', 'getFirstname');
            $models['idConnectedUser'] = getVal($this->sessionGet('user'), 'idUser', 'getId');
        }
        $models = $this->getOtherModel($models);
        echo $twig->render($pageName, $models);
    }

    private function getOtherModel($models)
    {
        if ($this->sessionIsset('otherModel')) {
            foreach ($this->sessionGet('otherModel') as $key => $value) {
                $models[$key] = $value;
            }
            $this->sessionUnset('otherModel');
        }
        return $models;
    }
}
