<?php

use App\core\Renderer;
use App\router\RouterException;

session_start();

require_once 'vendor/autoload.php';
require_once 'app/core/tools.php';

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = generateToken();
}

try {
    $router = new App\router\Router(isset($_GET['uri']) ? $_GET['uri'] : 'home');
    $router->run();
} catch (\Exception $e) {
    var_dump($e);
    $renderer = new Renderer();
    $renderer->render('404.html.twig', []);
}
