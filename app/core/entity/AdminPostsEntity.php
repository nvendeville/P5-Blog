<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;



class AdminPostsEntity extends DataAccessManager
{
    protected static $table = 'posts';
    protected static $_instance;
    private $draft = 1;
    private $archived = 2;
    private $posted = 3;

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


    public function validatePost($id) {
        $date= date("Y-m-d H:i:s");
        $statement = $this->pdo->prepare("UPDATE `posts` SET `status`=$this->posted, `lastUpdate`='$date' WHERE posts.id=?");
        $statement->execute([$id]);
    }

    public function archivePost($id) {
        $statement = $this->pdo->prepare("UPDATE `posts` SET `status`=$this->archived WHERE posts.id=?");
        $statement->execute([$id]);
    }

    public function modifyPost($adminPostModel, $id) {
        $date= date("Y-m-d H:i:s");
        $statement = "UPDATE `posts` SET `title`=?, `header`=?, `content`=?";
        $values=[];
        array_push($values, htmlspecialchars($adminPostModel->getTitle()));
        array_push($values, htmlspecialchars($adminPostModel->getHeader()));
        array_push($values, htmlspecialchars($adminPostModel->getContent()));
        if ($adminPostModel->getImg() != '') {
            $statement = $statement . ", `img`=?";
            array_push($values, htmlspecialchars($adminPostModel->getImg()));
        }
        $statement = $statement . ",`status`=?, `category`=?, `lastUpdate`=?
            WHERE id=?";
        array_push($values, htmlspecialchars($adminPostModel->getStatus()));
        array_push($values, htmlspecialchars($adminPostModel->getCategory()));
        array_push($values, $date);
        array_push($values, htmlspecialchars($id));
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }
}