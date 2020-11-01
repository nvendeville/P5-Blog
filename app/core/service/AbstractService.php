<?php


namespace App\core\service;


use App\core\entity\FooterEntity;
use App\core\entity\HeaderEntity;
use App\Model\FooterModel;
use App\Model\HeaderModel;

class AbstractService
{

    protected function hydrateFromPostArray($source, $target)
    {
        foreach ($source as $key => $value) {
            $targetSetter = 'set' . ucfirst($key);
            if (method_exists($target, $targetSetter)) {
                $target->$targetSetter($source[$key]);
            }
        }
    }

    protected function getHeader()
    {
        $entity = HeaderEntity::getInstance()->all(true);
        $headerModel = new HeaderModel();
        $this->hydrate($entity, $headerModel);
        return $headerModel;
    }

    protected function hydrate($source, $target)
    {
        foreach ($source as $key => $value) {
            $targetSetter = 'set' . ucfirst($key);
            if (method_exists($target, $targetSetter)) {
                $target->$targetSetter($source->$key);
            }
        }
    }

    protected function getFooter()
    {
        $entity = FooterEntity::getInstance()->all(true);
        $footerModel = new FooterModel();
        $this->hydrate($entity, $footerModel);
        return $footerModel;
    }


}