<?php


namespace App\core;
require_once '../vendor/autoload.php';

class Renderer
{
    public function render($page_name, $models) {
        $loader = new \Twig\Loader\FilesystemLoader('../app/view');
        $twig = new \Twig\Environment($loader);
        $twig->getExtension(\Twig\Extension\CoreExtension::class)->setDateFormat('d/m/Y H:i', '%d days');
        echo $twig->render($page_name, $models);
    }
}