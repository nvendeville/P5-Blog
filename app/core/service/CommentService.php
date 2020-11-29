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
        $this->commentEntity = new CommentEntity();
        $this->userEntity = new UserEntity();
        $this->postEntity = new PostEntity();
    }

    public function getCommentsByPostId(int $postId): array
    {
        $commentsModel = $this->commentEntity->getCommentsByPostId($postId);
        foreach ($commentsModel as $commentModel) {
            $commentModel->setUser($this->userEntity->getById($commentModel->getIdUser(), UserModel::class));
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
        $commentsModel = $this->commentEntity->getPaginatedComments();
        foreach ($commentsModel as $commentModel) {
            $commentModel->setUser($this->userEntity->getById($commentModel->getIdUser(), UserModel::class));
            $postModel = $this->postEntity->getById($commentModel->getIdPost(), PostModel::class);
            $commentModel->setTitlePost($postModel->getTitle());
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
