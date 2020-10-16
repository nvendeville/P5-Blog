<?php


namespace App\core\service;


use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
use App\model\CategoryModel;
use App\Model\PostModel;
use App\model\UserModel;

class PostService extends AbstractService
{
    const NB_POSTS_PER_PAGE = 3;

    /*private userEntity $userInstance;

    public function __construct() {
        $this->userInstance = userEntity::getInstance();
    }*/

    public function getAll ($currentPage) {
        $nbPages = $this->getNbPage();
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;

        $entities = PostEntity::getInstance()->getPaginatedPosts($premier, self::NB_POSTS_PER_PAGE);
        $postsModel = [];
        foreach ($entities as $post) {
            $postModel = new PostModel();
            $this->hydrate($post, $postModel);
            $userEntity = UserEntity::getInstance()->getById($postModel->getIdUser());
            //$userEntity = $this->userInstance->getById($postModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $postModel->setUser($userModel);
            $postModel->setUrl("/P5-blog/public/?p=post&action=detail&article=" . $postModel->getId());
            $postModel->setNbComments(count($this->getComments( $postModel->getId())));
            array_push($postsModel, $postModel);
        }

        return ["header" => $this->getHeader(), "posts" => $postsModel, "footer" => $this->getFooter(),
            "categories" =>$this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "nbPages" => (int)$nbPages, "currentPage" => $currentPage];
    }

    public function getPostsByCategory ($categoryName, $currentPage) {
        $nbPages = $this->getNbPostsByCategories($categoryName);
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;

        $entities = PostEntity::getInstance()->getPostsByCategory($categoryName, $premier, self::NB_POSTS_PER_PAGE);
        $postsModel = [];
        foreach ($entities as $post) {
            $postModel = new PostModel();
            $this->hydrate($post, $postModel);
            $userEntity = UserEntity::getInstance()->getById($postModel->getIdUser());
            //$userEntity = $this->userInstance->getById($postModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $postModel->setUser($userModel);
            $postModel->setUrl("/P5-blog/public/?p=post&action=detail&article=" . $postModel->getId());
            $postModel->setNbComments(count($this->getComments($postModel->getId())));
            $categoryModel = new CategoryModel();
            $this->hydrate($post, $categoryModel);
            $categoryModel->setCategoryName($postModel);
            array_push($postsModel, $postModel);
        }

        return ["header" => $this->getHeader(), "posts" => $postsModel, "footer" => $this->getFooter(),
            "categories" =>$this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "nbPages" => (int)$nbPages, "currentPage" => $currentPage, "urlParam" => "&action=getPostsByCategory&categorie=$categoryName"];
    }

    private function getNbPage () {
        $nbPosts = PostEntity::getInstance()->getNbPosts();
        return ceil((int)$nbPosts->nbPosts / (int)self::NB_POSTS_PER_PAGE);
    }

    private function getNbPostsByCategories ($categoryName) {
        $nbPosts = PostEntity::getInstance()->getNbPostsByCategories($categoryName);
        return ceil((int)$nbPosts->nbPosts / (int)self::NB_POSTS_PER_PAGE);
    }

    public function getPost ($id) {
        $post = PostEntity::getInstance()->getById($id);
        $postModel = new PostModel();
        $this->hydrate($post, $postModel);
        $userEntity = UserEntity::getInstance()->getById($postModel->getIdUser());
        $userModel = new UserModel();
        $this->hydrate($userEntity, $userModel);
        $postModel->setUser($userModel);
        return ["header" => $this->getHeader(), "post" => $postModel, "footer" => $this->getFooter(),
            "categories" =>$this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "comments" => $this->getComments($id)];
    }

    protected function getComments($postId) {
        $comments = new CommentService();
        return $comments->getCommentsByPostId($postId);
    }

    protected function getCategories() {
        $categories = PostEntity::getInstance()->getCategories();
        $categoriesModel = [];
        foreach ($categories as $category) {
            $categoryModel = new CategoryModel();
            $this->hydrate($category, $categoryModel);
            array_push($categoriesModel, $categoryModel);
        }
        return $categoriesModel;
    }

    protected function getLatestCommentedPosts() {
        $latestCommentedPosts = PostEntity::getInstance()->getLatestCommentedPosts();
        $latestCommentedPostsModel = [];
        foreach ($latestCommentedPosts as $latestCommentedPost) {
            $latestCommentedPostModel = new PostModel();
            $this->hydrate($latestCommentedPost, $latestCommentedPostModel);
            $latestCommentedPostModel->setUrl("/P5-blog/public/?p=post&action=detail&article=" . $latestCommentedPostModel->getId());
            array_push($latestCommentedPostsModel, $latestCommentedPostModel);
        }
        return $latestCommentedPostsModel;
    }

    //
}