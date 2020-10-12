<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;

class AdminCommentsEntity extends DataAccessManager
{
    protected static $table = 'home';
    protected static $_instance;
    private $toValidate = 1;
    private $validated = 2;
    private $deleted = 3;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new AdminCommentsEntity();
        }
        return self::$_instance;
    }

    public function validateComment($id) {
        $statement = $this->pdo->prepare("UPDATE `comments` SET `status`=$this->validated WHERE comments.id=?");
        $statement->execute([$id]);
    }

    public function rejectComment($id) {
        $statement = $this->pdo->prepare("UPDATE `comments` SET `status`=$this->deleted WHERE comments.id=?");
        $statement->execute([$id]);
    }
}