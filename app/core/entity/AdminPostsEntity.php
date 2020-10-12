<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;

class AdminPostsEntity extends DataAccessManager
{
    protected static $table = 'posts';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new AdminPostsEntity();
        }
        return self::$_instance;
    }

    public function getPaginatedPosts ($from, $nbPost) {
        $statement =
            "SELECT * FROM `posts` ORDER BY `creationDate` DESC LIMIT $from, $nbPost";
        return $this->query($statement, get_called_class(), false);
    }

    public function getNbPosts() {
        $statement =
            "SELECT COUNT(posts.id) as nbPosts FROM posts";
        return $this->query($statement, get_called_class(), true);
    }
}