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
            $userController = new \App\controller\UserController();
            $email = $_POST['email'];
            if (!$userController->userExist($email)) {
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
                $userController->addUser($_POST);
            } else {
                $connectionController = new \App\controller\ConnectionController();
                $connectionController->index(true);
            }
            break;
        case "contact_form":
            $HomeController = new \App\controller\HomeController();
            $HomeController->generateContactEmail($_POST);
            break;
        case "modify_post":
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
            $id = $_POST['idPost'];
            $currentPage = (int)strip_tags($_GET['page']);
            $adminModifyPostController = new \App\controller\AdminModifyPostController();
            $adminModifyPostController->modifyPost($_POST, $id, $currentPage);
            break;
        case "perso-home":
            foreach ($_FILES as $key => $image) {
                if (
                    $_FILES[$key]['error'] == 0
                    and ($_FILES[$key]['size'] <= 1000000)
                ) {
                    $infoFileUploaded = pathinfo($_FILES[$key]['name']);
                    $extensionFileUploaded = $infoFileUploaded['extension'];
                    $authorizedExtensions = array('jpg', 'jpeg', 'gif', 'png');
                    if (in_array($extensionFileUploaded, $authorizedExtensions)) {
                        move_uploaded_file($_FILES[$key]['tmp_name'], './img/' . basename($_FILES[$key]['name']));
                    }
                    $_POST[$key] = $_FILES[$key]['name'];
                }
            }
            $homeController = new \App\controller\HomeController();
            $homeController->persoHomePage($_POST);
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
} elseif ($p == 'post' or $p == 'adminPosts' or $p == 'adminComments'
    or $p == 'adminModifyPost' && $method == 'index') {
    $currentPage = 1;
}

if (isset($_GET["article"])) {
    $controller->$method($_GET["article"], $currentPage);
} elseif (isset($_GET["commentaire"])) {
    $controller->$method($_GET["commentaire"], $currentPage);
} elseif (isset($_GET["adminArticle"])) {
    $controller->$method($_GET["adminArticle"], $currentPage);
}elseif (isset($_GET["categorie"])) {
    $controller->$method($_GET["categorie"], $currentPage);
} elseif (isset($currentPage)) {
    $controller->$method($currentPage);
} else {
    $controller->$method();
}

