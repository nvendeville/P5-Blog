<?php

namespace App\core;

use Twig\Environment;
use Twig\Extension\CoreExtension;
use Twig\Loader\FilesystemLoader;

class Renderer
{
    public function render(string $pageName, array $models): void
    {
        $loader = new FilesystemLoader('../app/view');
        $twig = new Environment($loader);
        $twig->getExtension(CoreExtension::class)->setDateFormat('d/m/Y H:i', '%d days');
        $models['token'] = $_SESSION['token'];
        if (isset($_SESSION['user'])) {
            $models['logged'] = true;
            $models['isAdmin'] = getVal($_SESSION['user'], 'is_admin', 'getIsAdmin') == '1';
            $models['firstname'] = getVal($_SESSION['user'], 'firstname', 'getFirstname');
            $models['idConnectedUser'] = getVal($_SESSION['user'], 'id', 'getId');
        }
        $models = $this->getOtherModel($models);
        echo $twig->render($pageName, $models);
    }

    private function getOtherModel($models)
    {
        if (isset($_SESSION['otherModel'])) {
            foreach ($_SESSION['otherModel'] as $key => $value) {
                $models[$key] = $value;
            }
            unset($_SESSION['otherModel']);
        }
        return $models;
    }
}
