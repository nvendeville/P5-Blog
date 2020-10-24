<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;
use App\model\PostModel;
use App\model\UserModel;

class CommentEntity extends DataAccessManager
{
    protected static $table = 'comments';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new CommentEntity();
        }
        return self::$_instance;
    }

    public function getCommentsByPostId ($postId) {
        $statement = "SELECT * FROM comments WHERE idPost = $postId AND status = 'validated' ORDER BY creationDate DESC";
        return $this->query($statement, get_called_class(), false);
    }

    public function getPaginatedComments ($from, $nbComment) {
        $statement =
            "SELECT * FROM `comments` ORDER BY `creationDate` DESC LIMIT $from, $nbComment";
        return $this->query($statement, get_called_class(), false);
    }

    public function getNbComments() {
        $statement =
            "SELECT COUNT(comments.id) as nbComments FROM comments";
        return $this->query($statement, get_called_class(), true);
    }

    public function addComment($commentModel) {
        $statement =
            "INSERT INTO `comments` (`idUser`, `idPost`, `content`, `status`) 
            VALUES (?,?,?,?)";
        $values=[$commentModel->getIdUser(), $commentModel->getIdPost(),
            $commentModel->getContent(), $commentModel->getStatus()];
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }
}