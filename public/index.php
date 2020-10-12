<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../app/core/token.php';


if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = generateToken();
}

if (isset($_POST) and !empty($_POST)) {
    if (!isset($_POST['token']) or $_POST['token'] != $_SESSION['token']) {
        echo "Vous n'êtes pas authorisé à accéder à cette fonctionnalité";
    }
    switch ($_POST["type"]) {
        case "add_post":
            if (
                isset($_FILES['img'])
                and $_FILES['img']['error'] == 0
                and ($_FILES['img']['size'] <= 1000000)
            ) {
                $infoFileUploaded = pathinfo($_FILES['img']['name']);
                $extensionFileUploaded = $infoFileUploaded['extension'];
                $authorizedExtensions = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extensionFileUploaded, $authorizedExtensions)) {
                    move_uploaded_file($_FILES['img']['tmp_name'], './img/' . basename($_FILES['img']['name']));
                }
                $_POST["img"] = $_FILES['img']['name'];
            }
            $adminPostsController = new \App\controller\AdminPostsController();
            $adminPostsController->addPost($_POST);
            break;
        case "add_comment":
            $adminCommentsController = new \App\controller\AdminCommentsController();
            $adminCommentsController->addComment($_POST);
            break;
        case "add_user":
            if (
                isset($_FILES['avatar'])
                and $_FILES['avatar']['error'] == 0
                and ($_FILES['avatar']['size'] <= 1000000)
            ) {
                $infoFileUploaded = pathinfo($_FILES['avatar']['name']);
                $extensionFileUploaded = $infoFileUploaded['extension'];
                $authorizedExtensions = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extensionFileUploaded, $authorizedExtensions)) {
                    move_uploaded_file($_FILES['avatar']['tmp_name'], './img/' . basename($_FILES['avatar']['name']));
                }
                $_POST["avatar"] = $_FILES['avatar']['name'];
            }
            $userController = new \App\controller\UserController();
            $userController->addUser($_POST);

            echo "default";die();
            break;
        default:
            // nothing to do
    }
}
// ternaire pour donner la page home en défault
$p = (isset($_GET["p"])) ? $_GET["p"] : "home";

// indique par l'URL de la page vers quel controller aller
$controllerName = "App\Controller\\" . ucfirst($p) . "Controller";
$controller = new $controllerName();

//indique quelle méthode appeler du controller choisi
$method = isset($_GET["action"]) ? $_GET["action"] : 'index';

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int)strip_tags($_GET['page']);
} elseif ($p == 'post' or $p == 'adminPosts' or $p = 'adminComments' or $p='connection' && $method == 'index') {
    $currentPage = 1;
}

if (isset($_GET["article"])) {
    $controller->$method($_GET["article"]);
} elseif (isset($_GET["commentaire"])) {
    $controller->$method($_GET["commentaire"], $currentPage);
} elseif (isset($currentPage)) {
    $controller->$method($currentPage);
} else {
    $controller->$method();
}

