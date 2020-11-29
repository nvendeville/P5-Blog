<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;
use App\model\CommentModel;

class CommentEntity extends DataAccessManager
{
    protected static string $table = 'comments';

    public function getCommentsByPostId(int $postId): array
    {
        $statement = "
        SELECT *
        FROM comments
        WHERE idPost = $postId AND status = 'validé'
        ORDER BY creationDate DESC";
        return $this->all($statement, CommentModel::class);
    }

    public function getPaginatedComments(): array
    {
        $statement = "SELECT * FROM `comments` ORDER BY creationDate DESC";
        return $this->all($statement, CommentModel::class);
    }

    public function addComment(CommentModel $commentModel): void
    {
        $statement = "INSERT INTO `comments` (`idUser`, `idPost`, `content`, `status`) 
            VALUES (?,?,?,?)";
        $values = [$commentModel->getIdUser(), $commentModel->getIdPost(), $commentModel->getContent(),
            $commentModel->getStatus()];
        $insert = self::getPdo()->prepare($statement);
        $insert->execute($values);
    }

    public function updateStatus(int $commentId, string $commentStatus): void
    {
        $statement = self::getPdo()->prepare("UPDATE `comments` SET `status`= ? WHERE comments.id=?");
        $statement->execute([$commentStatus, $commentId]);
    }
}
