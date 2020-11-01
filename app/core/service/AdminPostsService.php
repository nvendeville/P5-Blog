<?php


namespace App\core\service;


use App\core\entity\AdminPostsEntity;
use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
use App\Model\AdminPostsModel;
use App\model\PostModel;
use App\model\UserModel;

class AdminPostsService extends AbstractService
{

    const NB_POSTS_PER_PAGE = 5;

    public function getModel()
    {
        $entity = AdminPostsEntity::getInstance()->one();
        $adminModel = new AdminPostsModel();
        $this->hydrate($entity, $adminModel);
        return ["header" => $this->getHeader(), "footer" => $this->getFooter()];
    }

    public function getPost($id)
    {
        $post = AdminPostsEntity::getInstance()->getById($id);
        $AdminPostModel = new AdminPostsModel();
        $this->hydrate($post, $AdminPostModel);
        $userEntity = UserEntity::getInstance()->getById($AdminPostModel->getIdUser());
        $userModel = new UserModel();
        $this->hydrate($userEntity, $userModel);
        $AdminPostModel->setUser($userModel);
        return ["header" => $this->getHeader(), "post" => $AdminPostModel];
    }

    public function addPost($formAddPost)
    {
        $postModel = new PostModel();
        $this->hydrateFromPostArray($formAddPost, $postModel);
        PostEntity::getInstance()->addPost($postModel);
    }

    public function validatePost($id, $currentPage)
    {
        AdminPostsEntity::getInstance()->validatePost($id);
        return $this->getAll($currentPage);
    }

    public function getAll($currentPage)
    {
        $nbPages = $this->getNbPage();
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;

        $entities = AdminPostsEntity::getInstance()->getPaginatedPosts($premier, self::NB_POSTS_PER_PAGE);
        $AdminPostsModel = [];
        foreach ($entities as $post) {
            $AdminPostModel = new AdminPostsModel();
            $this->hydrate($post, $AdminPostModel);
            array_push($AdminPostsModel, $AdminPostModel);
        }

        return ["header" => $this->getHeader(), "adminPosts" => $AdminPostsModel, "nbPages" => (int)$nbPages, "currentPage" => $currentPage];
    }

    private function getNbPage()
    {
        $nbPosts = AdminPostsEntity::getInstance()->getNbPosts();
        return ceil((int)$nbPosts->nbPosts / (int)self::NB_POSTS_PER_PAGE);
    }

    public function archivePost($id, $currentPage)
    {
        AdminPostsEntity::getInstance()->archivePost($id);
        return $this->getAll($currentPage);
    }

    public function modifyPost($formModifyPost, $id)
    {
        $adminPostModel = new AdminPostsModel();
        $this->hydrateFromPostArray($formModifyPost, $adminPostModel);
        AdminPostsEntity::getInstance()->modifyPost($adminPostModel, $id);
    }
}