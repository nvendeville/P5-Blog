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
    private CommentEntity $commentEntity;
    private UserEntity $userEntity;
    private PostEntity $postEntity;

    public function __construct()
    {
        parent::__construct();
        $this->commentEntity = CommentEntity::getInstance();
        $this->userEntity = UserEntity::getInstance();
        $this->postEntity = PostEntity::getInstance();
    }

    public function getCommentsByPostId(int $postId): array
    {
        $comments = $this->commentEntity->getCommentsByPostId($postId);
        $commentsModel = [];
        foreach ($comments as $comment) {
            $commentModel = new CommentModel();
            $this->hydrate($comment, $commentModel);
            $userEntity = $this->userEntity->getById($commentModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $commentModel->setUser($userModel);
            array_push($commentsModel, $commentModel);
        }
        return $commentsModel;
    }

    public function updateStatus(int $commentId, string $commentStatus, int $currentPage): array
    {
        $this->commentEntity->updateStatus($commentId, $commentStatus);
        return $this->getAll($currentPage);
    }

    public function getAll(int $currentPage): array
    {
        $entities = $this->commentEntity->getPaginatedComments();
        $commentsModel = [];
        foreach ($entities as $comment) {
            $commentModel = new CommentModel();
            $this->hydrate($comment, $commentModel);
            $userEntity = $this->userEntity->getById($commentModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $commentModel->setUser($userModel);
            $postEntity = $this->postEntity->getById($commentModel->getIdPost());
            $postModel = new PostModel();
            $this->hydrate($postEntity, $postModel);
            $commentModel->setTitlePost($postModel->getTitle());
            array_push($commentsModel, $commentModel);
        }
        return ["header" => $this->getHeader(), "comments" => $commentsModel, "currentPage" => $currentPage];
    }

    public function addComment(array $formAddComment): void
    {
        $commentModel = new CommentModel();
        $this->hydrateFromPostArray($formAddComment, $commentModel);
        $this->commentEntity->addComment($commentModel);
    }
}
