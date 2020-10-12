<?php


namespace App\core\service;


use App\core\entity\AdminAddPostEntity;
use App\Model\AdminAddPostModel;

class AdminAddPostService extends AbstractService
{

    public function getModel () {
        $entity = AdminAddPostEntity::getInstance()->one();
        $adminModel = new AdminAddPostModel();
        $this->hydrate($entity, $adminModel);
        return ["header" => $this->getHeader(), "footer" => $this->getFooter()];
    }
}