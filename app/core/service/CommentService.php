<?php

namespace App\core\service;

use App\core\entity\CommentEntity;
use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
use App\model\CommentModel;
use App\model\PostModel;
use App\model\UserModel;

class CommentService extends AbstractService
{

    public function getCommentsByPostId(int $postId): array
    {
        $comments = CommentEntity::getInstance()->getCommentsByPostId($postId);
        $commentsModel = [];
        foreach ($comments as $comment) {
            $commentModel = new CommentModel();
            $this->hydrate($comment, $commentModel);
            $userEntity = UserEntity::getInstance()->getById($commentModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $commentModel->setUser($userModel);

            array_push($commentsModel, $commentModel);
        }

        return $commentsModel;
    }

    public function updateStatus(int $commentId, string $commentStatus, int $currentPage): array
    {
        CommentEntity::getInstance()->updateStatus($commentId, $commentStatus);
        return $this->getAll($currentPage);
    }

    public function getAll(int $currentPage): array
    {
        $entities = CommentEntity::getInstance()->getPaginatedComments();
        $commentsModel = [];
        foreach ($entities as $comment) {
            $commentModel = new CommentModel();
            $this->hydrate($comment, $commentModel);

            $userEntity = UserEntity::getInstance()->getById($commentModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $commentModel->setUser($userModel);

            $postEntity = PostEntity::getInstance()->getById($commentModel->getIdPost());
            $postModel = new PostModel();
            $this->hydrate($postEntity, $postModel);
            $commentModel->setTitlePost($postModel->getTitle());

            array_push($commentsModel, $commentModel);
        }

        return ["header" => $this->getHeader(),
            "comments" => $commentsModel,
            "currentPage" => $currentPage];
    }

    public function rejectComment(int $commentId, int $currentPage): array
    {
        CommentEntity::getInstance()->rejectComment($commentId);
        return $this->getAll($currentPage);
    }

    public function addComment(array $formAddComment): void
    {
        $commentModel = new commentModel();
        $this->hydrateFromPostArray($formAddComment, $commentModel);
        CommentEntity::getInstance()->addComment($commentModel);
    }
}
