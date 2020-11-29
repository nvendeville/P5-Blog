<?php

namespace App\core\service;

use App\core\entity\FooterEntity;
use App\core\entity\HeaderEntity;

class AbstractService
{
    private HeaderEntity $headerEntity;
    private FooterEntity $footerEntity;

    public function __construct()
    {
        $this->headerEntity = HeaderEntity::getInstance();
        $this->footerEntity = new FooterEntity();
    }

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
        return $this->headerEntity->getHeader();
    }

    protected function getFooter(): object
    {
         return $this->footerEntity->getFooter();
    }
}
