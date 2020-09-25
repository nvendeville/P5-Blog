<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;

class PostEntity extends DataAccessManager
{
    protected static $table = 'posts';
    protected static $_instance;

    public function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new PostEntity();
        }
        return self::$_instance;
    }

    public function getPaginatedPosts ($from, $nbPost) {
        $statement =
            "SELECT * FROM `posts` ORDER BY `creationDate` DESC LIMIT $from, $nbPost";
        return $this->query($statement, get_called_class(), false);
    }

    public function getCategories() {
        $statement = 'SELECT  category as categoryName, COUNT(id) as nbPosts FROM `posts` group by category';
        return $this->query($statement, get_called_class(), false);
    }

    public function getLatestCommentedPosts() {
        $statement =
            "SELECT `posts`.`id`, `posts`.`idUser`, `comments`.`creationDate`, `posts`.`title`, `posts`.`header`, 
                    `posts`.`content`, `posts`.`img`, `posts`.`status`, `posts`.`category`, 
            count(comments.id) as nbComments 
            FROM `posts` 
            inner join comments on comments.idPost = posts.id and comments.status = 'validated'
            group by  `posts`.`id`, `posts`.`idUser`, `posts`.`title`, `posts`.`header`, 
                      `posts`.`content`, `posts`.`img`, `posts`.`status`, `posts`.`category` 
            order by comments.creationDate desc limit 3";
        return $this->query($statement, get_called_class(), false);
    }

    public function getNbPosts() {
        $statement =
            "SELECT COUNT(posts.id) as nbPosts FROM posts";
        return $this->query($statement, get_called_class(), true);
    }
}