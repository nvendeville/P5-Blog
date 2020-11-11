<?php

namespace App\core\service;

use App\core\entity\AdminPostsEntity;
use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
use App\model\AdminPostsModel;
use App\model\PostModel;
use App\model\UserModel;

class AdminPostsService extends AbstractService
{
    public function getModel(): array
    {
        $entity = AdminPostsEntity::getInstance()->one();
        $adminModel = new AdminPostsModel();
        $this->hydrate($entity, $adminModel);
        return ["header" => $this->getHeader(), "footer" => $this->getFooter()];
    }

    public function getPost(int $postId): array
    {
        $post = AdminPostsEntity::getInstance()->getById($postId);
        $adminPostModel = new AdminPostsModel();
        $this->hydrate($post, $adminPostModel);
        $userEntity = UserEntity::getInstance()->getById($adminPostModel->getIdUser());
        $userModel = new UserModel();
        $this->hydrate($userEntity, $userModel);
        $adminPostModel->setUser($userModel);
        return ["header" => $this->getHeader(), "post" => $adminPostModel];
    }

    public function addPost(array$formAddPost): void
    {
        $postModel = new PostModel();
        $this->hydrateFromPostArray($formAddPost, $postModel);
        PostEntity::getInstance()->addPost($postModel);
    }

    public function validatePost(int $postId, int $currentPage): array
    {
        AdminPostsEntity::getInstance()->validatePost($postId);
        return $this->getAll($currentPage);
    }

    public function getAll(int $currentPage): array
    {
        $entities = AdminPostsEntity::getInstance()->getPaginatedPosts();
        $adminPostsModel = [];
        foreach ($entities as $post) {
            $adminPostModel = new AdminPostsModel();
            $this->hydrate($post, $adminPostModel);
            array_push($adminPostsModel, $adminPostModel);
        }
        return ["header" => $this->getHeader(), "adminPosts" => $adminPostsModel,
            "currentPage" => $currentPage];
    }

    public function archivePost(int $postId, int $currentPage): array
    {
        AdminPostsEntity::getInstance()->archivePost($postId);
        return $this->getAll($currentPage);
    }

    public function modifyPost(array $formModifyPost, int $postId): void
    {
        $adminPostModel = new AdminPostsModel();
        $this->hydrateFromPostArray($formModifyPost, $adminPostModel);
        AdminPostsEntity::getInstance()->modifyPost($adminPostModel, $postId);
    }
}
