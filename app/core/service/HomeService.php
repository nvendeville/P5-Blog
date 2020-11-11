<?php

namespace App\core\service;

use App\core\entity\FooterEntity;
use App\core\entity\HeaderEntity;
use App\core\entity\HomeEntity;
use App\core\Mailer;
use App\model\FooterModel;
use App\model\HeaderModel;
use App\model\HomeModel;

class HomeService extends AbstractService
{
    use Mailer;

    public function getModel(): array
    {
        $entity = HomeEntity::getInstance()->one();
        $homeModel = new HomeModel();
        $this->hydrate($entity, $homeModel);
        return ["header" => $this->getHeader(), "home" => $homeModel, "footer" => $this->getFooter()];
    }

    public function persoHomePage(array $persoHomeForm): void
    {
        $homeModel = new HomeModel();
        $this->hydrateFromPostArray($persoHomeForm, $homeModel);
        $headerModel = new HeaderModel();
        $this->hydrateFromPostArray($persoHomeForm, $headerModel);
        $footerModel = new FooterModel();
        $this->hydrateFromPostArray($persoHomeForm, $footerModel);
        HeaderEntity::getInstance()->persoHeader($headerModel);
        HomeEntity::getInstance()->persoHomePage($homeModel);
        FooterEntity::getInstance()->persoFooter($footerModel);
    }

    public function sendContactRequest(array $contactForm): void
    {
        $message = 'Vous avez reçu un message de <br/>' . $contactForm['firstname'] . ' ' . $contactForm['lastname'] .
            ' : <br/>' . $contactForm['message'];
        $subject = 'Demande de contact';
        $this->sendMail($subject, $message, $contactForm['email']);
    }
}
