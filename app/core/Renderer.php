<?php


namespace App\core;
require_once '../vendor/autoload.php';

class Renderer
{
    public function render($page_name, $models) {
        $loader = new \Twig\Loader\FilesystemLoader('../app/view');
        $twig = new \Twig\Environment($loader);
        echo $twig->render($page_name, $models);
    }
}