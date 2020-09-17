<?php

require_once '../vendor/autoload.php';

// $p = (isset($_GET["p"])) ? $_GET["p"] : "pages.home";
var_dump($_SERVER);
die();
$p = $_SERVER['REQUEST_URI'];

$pExploded = explode("/", $p);

$controllerName = "App\Controller\\" . ucfirst($pExploded[1]) . "Controller";

$controller = new $controllerName();
$method = $p_exploded[1];
$controller->$method();

