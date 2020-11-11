<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;

class HeaderEntity extends DataAccessManager
{
    protected static string $table = 'header';
    protected static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new HeaderEntity();
        }
        return self::$instance;
    }

    public function persoHeader(object $headerModel): void
    {
        $statement = "UPDATE `header` SET `blogTitle`=?";
        $insert = $this->pdo->prepare($statement);
        $insert->execute([$headerModel->getBlogtitle()]);
    }
}
