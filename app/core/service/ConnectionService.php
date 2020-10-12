<?php


namespace App\core\service;


use App\core\entity\ConnectionEntity;
use App\model\ConnectionModel;

class ConnectionService extends AbstractService
{

    public function getModel () {
        $entity = ConnectionEntity::getInstance()->one();
        $homeModel = new ConnectionModel();
        $this->hydrate($entity, $homeModel);
        return ["header" => $this->getHeader(), "home" => $homeModel, "footer" => $this->getFooter()];
    }
}