<?php

require_once '../vendor/autoload.php';

$p = (isset($_GET["p"])) ? $_GET["p"] : "pages.home";

$p_exploded = explode(".", $p);

$controller_name = "App\Controller\\" . ucfirst($p_exploded[0]) . "Controller";

$controller = new $controller_name();
$method = $p_exploded[1];
$controller->$method();

