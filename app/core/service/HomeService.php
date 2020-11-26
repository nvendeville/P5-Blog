<?php

namespace App\core\service;

use App\core\ConfigClass;
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

    private HeaderEntity $headerEntity;
    private FooterEntity $footerEntity;
    private HomeEntity $homeEntity;

    public function __construct()
    {
        parent::__construct();
        $this->headerEntity = HeaderEntity::getInstance();
        $this->footerEntity = new FooterEntity();
        $this->homeEntity = HomeEntity::getInstance();
    }

    public function getModel(): array
    {
        $homeModel = new HomeModel();
        $this->hydrate($this->homeEntity->getHome(), $homeModel);
        return ["header" => $this->getHeader(), "home" => $homeModel, "footer" => $this->getFooter()];
    }

    public function persoHomePage(array $persoHomeForm): void
    {
        $homeModel = new HomeModel();
        $headerModel = new HeaderModel();
        $footerModel = new FooterModel();
        $this->hydrateFromPostArray($persoHomeForm, $homeModel);
        $this->hydrateFromPostArray($persoHomeForm, $headerModel);
        $this->hydrateFromPostArray($persoHomeForm, $footerModel);
        $this->headerEntity->persoHeader($headerModel);
        $this->homeEntity->persoHomePage($homeModel);
        $this->footerEntity->persoFooter($footerModel);
    }

    public function sendContactRequest(array $contactForm): void
    {
        $message = 'Vous avez reçu un message de <br/>' . $contactForm['firstname'] . ' ' . $contactForm['lastname'] .
            ' : <br/>' . $contactForm['message'];
        $subject = 'Demande de contact';
        $config = ConfigClass::getInstance();
        $this->sendMail($subject, $message, $config->get('smtp_setFromMail'), $contactForm['email']);
    }
}
