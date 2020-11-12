<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;

class CommentEntity extends DataAccessManager
{
    protected static string $table = 'comments';

    protected static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new CommentEntity();
        }
        return self::$instance;
    }

    public function getCommentsByPostId(int $postId): array
    {
        $statement = "
        SELECT *
        FROM comments
        WHERE idPost = $postId AND status = 'validé'
        ORDER BY creationDate DESC";
        return $this->query($statement, get_called_class(), false);
    }


    public function getPaginatedComments(): array
    {
        $statement =
            "SELECT * FROM `comments` ORDER BY creationDate DESC";
        return $this->query($statement, get_called_class(), false);
    }


    public function getNbComments(): int
    {
        $statement =
            "SELECT COUNT(comments.id) as nbComments FROM comments";
        return $this->query($statement, get_called_class(), true);
    }

    public function addComment(object $commentModel): void
    {
        $statement =
            "INSERT INTO `comments` (`idUser`, `idPost`, `content`, `status`) 
            VALUES (?,?,?,?)";
        $values = [$commentModel->getIdUser(), $commentModel->getIdPost(),
            $commentModel->getContent(), $commentModel->getStatus()];
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }

    public function validateComment(int $commentId, string $commentStatus): void
    {
        $statement = $this->pdo->prepare("UPDATE `comments` SET `status`= ? WHERE comments.id=?");
        $statement->execute([$commentStatus, $commentId]);
    }

    public function rejectComment(int $commentId): void
    {
        $statement = $this->pdo->prepare("UPDATE `comments` SET `status`=3 WHERE comments.id=?");
        $statement->execute([$commentId]);
    }
}
