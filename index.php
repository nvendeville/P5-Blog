<?php

declare(strict_types=1);

use App\core\Renderer;

spl_autoload_register(function ($className) {
    include $className . '.php';
});

session_start();

require 'vendor/autoload.php';
require 'app/core/tools.php';
require 'app/core/config.php';

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = generateToken();
}

try {
    $router = new App\router\Router(isset($_GET['uri']) ? $_GET['uri'] : 'home');
    $router->run();
} catch (\Exception $e) {
    $renderer = new Renderer();
    $renderer->render('404.html.twig', []);
}
