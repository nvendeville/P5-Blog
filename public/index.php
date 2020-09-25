<?php

require_once '../vendor/autoload.php';


if (isset($_POST) AND !empty($_POST)) {
    echo 'in $_post';
    if (
        isset($_FILES['postImg'])
        AND $_FILES['postImg']['error'] == 0
        AND($_FILES['postImg']['size'] <= 1000000)
    ) {
        $infoFileUploaded = pathinfo($_FILES['postImg']['name']);
        $extensionFileUploaded = $infoFileUploaded['extension'];
        $authorizedExtensions = array('jpg', 'jpeg', 'gif', 'png');
        if (in_array($extensionFileUploaded, $authorizedExtensions)) {
            move_uploaded_file($_FILES['postImg']['tmp_name'], 'P5-Blog/public/img' . basename($_FILES['postImg']['name']));
            echo "L'envoi a bien été effectué !";
        }
    }
} else {
// ternaire pour donner la page home en défault
    $p = (isset($_GET["p"])) ? $_GET["p"] : "home";

// indique par l'URL de la page vers quel controller aller
    $controllerName = "App\Controller\\" . ucfirst($p) . "Controller";
    $controller = new $controllerName();

//indique quelle méthode appeler du controller choisi
    $method = isset($_GET["action"]) ? $_GET["action"] : 'index';

    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    } elseif ($p == 'post' && $method=='index') {
        $currentPage = 1;
    }

    if (isset($_GET["article"])) {
        $controller->$method($_GET["article"]);
    } elseif (isset($currentPage)) {
        $controller->$method($currentPage);
    } else {
        $controller->$method();
    }
}





