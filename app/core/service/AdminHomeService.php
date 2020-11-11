<?php

namespace App\core\service;

use App\core\entity\AdminHomeEntity;
use App\model\AdminHomeModel;

class AdminHomeService extends AbstractService
{

    public function getModel(): array
    {
        $entity = AdminHomeEntity::getInstance()->one();
        $adminModel = new AdminHomeModel();
        $this->hydrate($entity, $adminModel);
        return ["header" => $this->getHeader(), "footer" => $this->getFooter()];
    }
}
