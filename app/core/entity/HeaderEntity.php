<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;
use App\model\HeaderModel;

class HeaderEntity extends DataAccessManager
{
    protected static string $table = 'header';
    protected static HeaderEntity $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): HeaderEntity
    {
        if (!isset(self::$instance)) {
            self::$instance = new HeaderEntity();
        }
        return self::$instance;
    }

    public function getHeader(): object
    {
        return $this->one("SELECT * FROM `header`", HeaderModel::class);
    }

    public function persoHeader(HeaderModel $headerModel): void
    {
        $statement = "UPDATE `header` SET `blogTitle`=?";
        $insert = self::getPdo()->prepare($statement);
        $insert->execute([$headerModel->getBlogtitle()]);
    }
}
