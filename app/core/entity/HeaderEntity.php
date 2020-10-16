<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;

class HeaderEntity extends DataAccessManager
{
    protected static $table = 'header';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new HeaderEntity();
        }
        return self::$_instance;
    }

    public function persoHeader($headerModel) {
        $statement = "UPDATE `header` SET `blogTitle`=?";
        $value= htmlspecialchars($headerModel->getBlogtitle());
        $insert = $this->pdo->prepare($statement);
        $insert->execute([$value]);
    }
}