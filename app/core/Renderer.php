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
        }
        echo $twig->render($page_name, $models);
    }
}