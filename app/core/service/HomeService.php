<?php


namespace App\core\service;


use App\core\entity\FooterEntity;
use App\core\entity\HeaderEntity;
use App\core\entity\HomeEntity;
use App\core\entity\UserEntity;
use App\Model\FooterModel;
use App\Model\HeaderModel;
use App\Model\HomeModel;
use App\model\UserModel;


class HomeService extends AbstractService
{

    public function getModel () {
        $entity = HomeEntity::getInstance()->one();
        $homeModel = new HomeModel();
        $this->hydrate($entity, $homeModel);
        return ["header" => $this->getHeader(), "home" => $homeModel, "footer" => $this->getFooter()];
    }

    public function persoHomePage ($persoHomeForm) {
        $homeModel = new HomeModel();
        $this->hydrateFromPostArray($persoHomeForm, $homeModel);
        $headerModel = new HeaderModel();
        $this->hydrateFromPostArray($persoHomeForm, $headerModel);
        $footerModel = new FooterModel();
        $this->hydrateFromPostArray($persoHomeForm, $footerModel);
        HeaderEntity::getInstance()->persoHeader ($headerModel);
        HomeEntity::getInstance()->persoHomePage ($homeModel);
        FooterEntity::getInstance()->persoFooter ($footerModel);
    }

}