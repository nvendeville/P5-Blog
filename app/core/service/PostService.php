<?php

namespace App\core\service;

use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
use App\model\AdminPostsModel;
use App\model\CategoryModel;
use App\model\PostModel;
use App\model\UserModel;

class PostService extends AbstractService
{
    private const NB_POSTS_PER_PAGE = 3;

    public function getModel(): array
    {
        $entity = PostEntity::getInstance()->one();
        $adminModel = new AdminPostsModel();
        $this->hydrate($entity, $adminModel);
        return ["header" => $this->getHeader(), "footer" => $this->getFooter()];
    }

    public function getBlog(int $currentPage): array
    {
        $nbPages = $this->getNbPage();
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;
        $entities = PostEntity::getInstance()->getPaginatedPosts($premier, self::NB_POSTS_PER_PAGE);
        $postsModel = [];
        foreach ($entities as $post) {
            $postModel = new PostModel();
            $this->hydrate($post, $postModel);
            $userEntity = UserEntity::getInstance()->getById($postModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $postModel->setUser($userModel);
            $postModel->setUrl("/P5-blog/posts/detail:" . $postModel->getId());
            $postModel->setNbComments(count($this->getComments($postModel->getId())));
            array_push($postsModel, $postModel);
        }
        return ["header" => $this->getHeader(), "posts" => $postsModel, "footer" => $this->getFooter(),
            "categories" => $this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "nbPages" => (int)$nbPages, "currentPage" => $currentPage];
    }

    public function getPosts(int $currentPage): array
    {
        $entities = PostEntity::getInstance()->getAllPosts();
        $adminPostsModel = [];
        foreach ($entities as $post) {
            $adminPostModel = new AdminPostsModel();
            $this->hydrate($post, $adminPostModel);
            array_push($adminPostsModel, $adminPostModel);
        }
        return ["header" => $this->getHeader(), "adminPosts" => $adminPostsModel, "currentPage" => $currentPage];
    }

    private function getNbPage(): int
    {
        $nbPosts = PostEntity::getInstance()->getPostedNbPosts();
        return ceil((int)$nbPosts->nbPosts / (int)self::NB_POSTS_PER_PAGE);
    }

    protected function getComments(int $postId): array
    {
        $comments = new CommentService();
        return $comments->getCommentsByPostId($postId);
    }

    protected function getCategories(): array
    {
        $categories = PostEntity::getInstance()->getCategories();
        $categoriesModel = [];
        foreach ($categories as $category) {
            $categoryModel = new CategoryModel();
            $this->hydrate($category, $categoryModel);
            array_push($categoriesModel, $categoryModel);
        }
        return $categoriesModel;
    }

    protected function getLatestCommentedPosts(): array
    {
        $commentedPosts = PostEntity::getInstance()->getLatestCommentedPosts();
        $commentedPostsModel = [];
        foreach ($commentedPosts as $commentedPost) {
            $commentedPostModel = new PostModel();
            $this->hydrate($commentedPost, $commentedPostModel);
            $commentedPostModel->setUrl("/P5-blog/posts/detail:" .
                $commentedPostModel->getId());
            array_push($commentedPostsModel, $commentedPostModel);
        }
        return $commentedPostsModel;
    }

    public function getPostsByCategory(string $categoryName, int $currentPage): array
    {
        $nbPages = $this->getNbPostsByCategories($categoryName);
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;
        $entities = PostEntity::getInstance()->getPostsByCategory($categoryName, $premier, self::NB_POSTS_PER_PAGE);
        $postsModel = [];
        foreach ($entities as $post) {
            $postModel = new PostModel();
            $this->hydrate($post, $postModel);
            $userEntity = UserEntity::getInstance()->getById($postModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $postModel->setUser($userModel);
            $postModel->setUrl("/P5-blog/posts/detail:" . $postModel->getId());
            $postModel->setNbComments(count($this->getComments($postModel->getId())));
            $categoryModel = new CategoryModel();
            $this->hydrate($post, $categoryModel);
            $categoryModel->setCategoryName($postModel);
            array_push($postsModel, $postModel);
        }
        return ["header" => $this->getHeader(), "posts" => $postsModel, "footer" => $this->getFooter(),
            "categories" => $this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "nbPages" => (int)$nbPages, "currentPage" => $currentPage,
            "urlParam" => $categoryName];
    }

    private function getNbPostsByCategories(string $categoryName): int
    {
        $nbPosts = PostEntity::getInstance()->getNbPostsByCategories($categoryName);
        return ceil((int)$nbPosts->nbPosts / (int)self::NB_POSTS_PER_PAGE);
    }

    public function getPostDetail(int $postId): array
    {
        $post = PostEntity::getInstance()->getById($postId);
        $postModel = new PostModel();
        $this->hydrate($post, $postModel);
        $userEntity = UserEntity::getInstance()->getById($postModel->getIdUser());
        $userModel = new UserModel();
        $this->hydrate($userEntity, $userModel);
        $postModel->setUser($userModel);
        return ["header" => $this->getHeader(), "post" => $postModel, "footer" => $this->getFooter(),
            "categories" => $this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "comments" => $this->getComments($postId)];
    }

    public function getPost(int $postId): array
    {
        $post = PostEntity::getInstance()->getById($postId);
        $adminPostModel = new AdminPostsModel();
        $this->hydrate($post, $adminPostModel);
        $userEntity = UserEntity::getInstance()->getById($adminPostModel->getIdUser());
        $userModel = new UserModel();
        $this->hydrate($userEntity, $userModel);
        $adminPostModel->setUser($userModel);
        return ["header" => $this->getHeader(), "post" => $adminPostModel];
    }

    public function addPost(array $formAddPost): void
    {
        $postModel = new PostModel();
        $this->hydrateFromPostArray($formAddPost, $postModel);
        PostEntity::getInstance()->addPost($postModel);
    }

    public function updateStatus($postId, $postStatus): void
    {
        PostEntity::getInstance()->updateStatus($postId, $postStatus);
    }

    public function modifyPost(array $formModifyPost, int $postId): void
    {
        $adminPostModel = new AdminPostsModel();
        $this->hydrateFromPostArray($formModifyPost, $adminPostModel);
        PostEntity::getInstance()->modifyPost($adminPostModel, $postId);
    }

    public function getHeaders(): array
    {
        return ["header" => $this->getHeader()];
    }
}
