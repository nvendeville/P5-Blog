<?php


namespace App\core;


require_once '../vendor/autoload.php';

class Renderer
{
    public function render($page_name, $models) {
        $loader = new \Twig\Loader\FilesystemLoader('../app/view');
        $twig = new \Twig\Environment($loader);
        $twig->getExtension(\Twig\Extension\CoreExtension::class)->setDateFormat('d/m/Y H:i', '%d days');
        $models['token'] = $_SESSION['token'];
        if (isset($_SESSION['user'])) {
            $models['logged'] = true;
            $models['isAdmin'] = getVal($_SESSION['user'], 'is_admin', 'getIsAdmin') == '1';
            $models['firstname'] = getVal($_SESSION['user'], 'firstname', 'getFirstname');
            $models['idConnectedUser'] = getVal($_SESSION['user'], 'id', 'getId');
        }
        $models= $this->getOtherModel($models);
        echo $twig->render($page_name, $models);
    }

    private function  getOtherModel($models) {
        if (isset($_SESSION['otherModel'])) {
            foreach ($_SESSION['otherModel'] as $key => $value) {
                $models[$key] = $value;
            }
            unset($_SESSION['otherModel']);
        }
        return $models;
    }
}