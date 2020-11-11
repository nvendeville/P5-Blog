<?php

namespace App\core\service;

use App\core\entity\FooterEntity;
use App\core\entity\HeaderEntity;
use App\model\FooterModel;
use App\model\HeaderModel;

class AbstractService
{

    protected function hydrateFromPostArray(array $source, object $target): void
    {
        foreach ($source as $key => $value) {
            $targetSetter = 'set' . ucfirst($key);
            if (method_exists($target, $targetSetter)) {
                $target->$targetSetter($value);
            }
        }
    }

    protected function getHeader(): object
    {
        $entity = HeaderEntity::getInstance()->all(true);
        $headerModel = new HeaderModel();
        $this->hydrate($entity, $headerModel);
        return $headerModel;
    }

    protected function hydrate(object $source, object $target): void
    {
        foreach ($source as $key => $value) {
            $targetSetter = 'set' . ucfirst($key);
            if (method_exists($target, $targetSetter)) {
                $target->$targetSetter($value);
            }
        }
    }

    protected function getFooter(): object
    {
        $entity = FooterEntity::getInstance()->all(true);
        $footerModel = new FooterModel();
        $this->hydrate($entity, $footerModel);
        return $footerModel;
    }
}
