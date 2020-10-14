<?php


namespace App\core\service;


use App\core\entity\HomeEntity;
use App\Model\HomeModel;



class HomeService extends AbstractService
{

    public function getModel () {
        $entity = HomeEntity::getInstance()->one();
        $homeModel = new HomeModel();
        $this->hydrate($entity, $homeModel);
        return ["header" => $this->getHeader(), "home" => $homeModel, "footer" => $this->getFooter()];
    }

}