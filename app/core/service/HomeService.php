<?php

namespace App\core\service;

use App\core\ConfigClass;
use App\core\entity\HomeEntity;
use App\core\Mailer;
use App\model\FooterModel;
use App\model\HeaderModel;
use App\model\HomeModel;

class HomeService extends AbstractService
{
    use Mailer;

    private HomeEntity $homeEntity;

    public function __construct()
    {
        parent::__construct();
        $this->homeEntity = new HomeEntity();
    }

    public function getModel(): array
    {
        $homeModel = $this->homeEntity->getHome();

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
