<?php

namespace App\core\service;

use App\core\ConfigClass;
use App\core\entity\UserEntity;
use App\core\Mailer;
use App\core\SessionManager;
use App\model\UserModel;

class UserService extends AbstractService
{
    use Mailer;

    private UserEntity $userEntity;
    private SessionManager $sessionManager;

    public function __construct()
    {
        parent::__construct();
        $this->sessionManager = new SessionManager();
        $this->userEntity = UserEntity::getInstance();
    }

    public function addUser(array $formAddUser): object
    {
        $userModel = new UserModel();
        $this->hydrateFromPostArray($formAddUser, $userModel);
        $this->userEntity->addUser($userModel);
        $this->sendAddedUserConfirmation($formAddUser);
        return $this->userEntity->getUserByEmail($userModel->getEmail());
    }

    public function sendAddedUserConfirmation(array $formAddUser): void
    {
        $message = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .flex-direction {
            display: flex;
            flex-direction: column;
        }
        .padding-404 {
            padding-left: 10em;
            padding-top: 10em;
        }
        .text-orange {
            color: #fd7e14;
        }
    </style>
</head>

<body> 
<div style="background: url(http://localhost/P5-Blog/img/404.jpg); background-size: cover; background-position: center center; height: 600px !important;">
        <div class="flex-direction padding-404">
            <div>
                <h1 class="text-orange">Bienvenue sur mon Blog</h1>
            </div>
            <div>
                <h4 class="text-orange">Cher(e) ' . $formAddUser['firstname'] . ',</h4>
            </div>
            <div>
                <p>Je vous confirme votre inscription et suis impatiente de vous retrouver bient&ocirc;t sur mon blog pour partager avec vous.</p>
                <p>Nathalie</p>
            </div>
        </div>
    </div>
</body>
</html>';
        $subject = "Confirmation d'inscription";
        $config = ConfigClass::getInstance();
        $this->sendMail($subject, $message, $formAddUser['email'], $config->get("smtp_setFromMail"));
    }

    public function userExist(string $email): bool
    {
        return $this->userEntity->userExist($email) != null;
    }


    public function signIn(string $email): ?object
    {
        $userModel = new UserModel();
        $user = $this->userEntity->getUserByEmail($email);
        if (isset($user)) {
            $this->hydrate($user, $userModel);
            return $userModel;
        }
        return null;
    }

    public function logout(): void
    {
        $this->sessionManager->sessionUnset('user', 'token', 'isAdmin');
    }

    public function controlPassword(string $password1, string $password2): bool
    {
        return $password1 == $password2;
    }

    public function updatePassword(string $newPassword, string $email): void
    {
        $this->userEntity->updatePassword($newPassword, $email);
    }
}
