<?php

use App\router\RouterException;

session_start();

require_once 'vendor/autoload.php';
require_once 'app/core/tools.php';

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = generateToken();
}

    $router = new App\Router\Router(isset($_GET['uri']) ? $_GET['uri'] : 'home');
    $router->run();