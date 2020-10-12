<?php


namespace App\core\service;


use App\core\entity\AdminPersoEntity;
use App\Model\AdminPersoModel;

class AdminPersoService extends AbstractService
{

    public function getModel () {
        $entity = AdminPersoEntity::getInstance()->one();
        $adminModel = new AdminPersoModel();
        $this->hydrate($entity, $adminModel);
        return ["header" => $this->getHeader(), "footer" => $this->getFooter()];
    }
}