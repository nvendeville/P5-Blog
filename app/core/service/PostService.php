<?php

namespace App\core\service;

use App\core\entity\CommentEntity;
use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
use App\model\CategoryModel;
use App\model\PostModel;
use App\model\UserModel;

class PostService extends AbstractService
{
    private const NB_POSTS_PER_PAGE = 3;
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

    public function getBlog(int $currentPage): array
    {
        $nbPages = $this->getNbPage();
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;
        $entities = $this->postEntity->getPaginatedPosts($premier, self::NB_POSTS_PER_PAGE);
        $postsModel = [];
        foreach ($entities as $post) {
            $postModel = new PostModel();
            $this->hydrate($post, $postModel);
            $userModel = new UserModel();
            $this->hydrate($this->userEntity->getById($postModel->getIdUser()), $userModel);
            $postModel->setUser($userModel);
            $postModel->setUrl("/P5-blog/posts/detail:" . $postModel->getId());
            $postModel->setNbComments(count($this->getComments($postModel->getId())));
            array_push($postsModel, $postModel);
        }
        return ["header" => $this->getHeader(), "posts" => $postsModel, "footer" => $this->getFooter(),
            "categories" => $this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "nbPages" => (int)$nbPages, "currentPage" => $currentPage];
    }

    private function getNbPage(): int
    {
        $nbPosts = $this->postEntity->getPostedNbPosts();
        return ceil((int)$nbPosts->nbPosts / (int)self::NB_POSTS_PER_PAGE);
    }

    protected function getComments(int $postId): array
    {
        $comments = new CommentService();
        return $comments->getCommentsByPostId($postId);
    }

    protected function getCategories(): array
    {
        $categories = $this->postEntity->getCategories();
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
        $commentedPosts = $this->postEntity->getLatestCommentedPosts();
        $commentedPostsModel = [];
        foreach ($commentedPosts as $commentedPost) {
            $commentedPostModel = new PostModel();
            $this->hydrate($commentedPost, $commentedPostModel);
            $commentedPostModel->setUrl("/P5-blog/posts/detail:" . $commentedPostModel->getId());
            array_push($commentedPostsModel, $commentedPostModel);
        }
        return $commentedPostsModel;
    }

    public function getPosts(int $currentPage): array
    {
        $entities = $this->postEntity->getAllPosts();
        $postsModel = [];
        foreach ($entities as $post) {
            $postModel = new PostModel();
            $this->hydrate($post, $postModel);
            array_push($postsModel, $postModel);
        }
        return ["header" => $this->getHeader(), "adminPosts" => $postsModel, "currentPage" => $currentPage];
    }

    public function getPostsByCategory(string $categoryName, int $currentPage): array
    {
        $nbPages = $this->getNbPostsByCategories($categoryName);
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;
        $entities = $this->postEntity->getPostsByCategory($categoryName, $premier, self::NB_POSTS_PER_PAGE);
        $postsModel = [];
        foreach ($entities as $post) {
            $postModel = new PostModel();
            $this->hydrate($post, $postModel);
            $userModel = new UserModel();
            $this->hydrate($this->userEntity->getById($postModel->getIdUser()), $userModel);
            $postModel->setUser($userModel);
            $postModel->setUrl("/P5-blog/posts/detail:" . $postModel->getId());
            $postModel->setNbComments(count($this->getComments($postModel->getId())));
            $categoryModel = new CategoryModel();
            $this->hydrate($post, $categoryModel);
            $categoryModel->setCategoryName($postModel->getCategory());
            array_push($postsModel, $postModel);
        }
        return ["header" => $this->getHeader(), "posts" => $postsModel, "footer" => $this->getFooter(),
            "categories" => $this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "nbPages" => (int)$nbPages, "currentPage" => $currentPage, "urlParam" => $categoryName];
    }

    private function getNbPostsByCategories(string $categoryName): int
    {
        $nbPosts = $this->postEntity->getNbPostsByCategories($categoryName);
        return ceil((int)$nbPosts->nbPosts / (int)self::NB_POSTS_PER_PAGE);
    }

    public function getPostDetail(int $postId): array
    {
        $post = $this->postEntity->getById($postId);
        $postModel = new PostModel();
        $this->hydrate($post, $postModel);
        $userModel = new UserModel();
        $this->hydrate($this->userEntity->getById($postModel->getIdUser()), $userModel);
        $postModel->setUser($userModel);
        return ["header" => $this->getHeader(), "post" => $postModel, "footer" => $this->getFooter(),
            "categories" => $this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "comments" => $this->getComments($postId)];
    }

    public function getPost(int $postId): array
    {
        $postModel = new PostModel();
        $this->hydrate($this->postEntity->getById($postId), $postModel);
        $userModel = new UserModel();
        $this->hydrate($this->userEntity->getById($postModel->getIdUser()), $userModel);
        $postModel->setUser($userModel);
        return ["header" => $this->getHeader(), "post" => $postModel];
    }

    public function addPost(array $formAddPost): void
    {
        $postModel = new PostModel();
        $this->hydrateFromPostArray($formAddPost, $postModel);
        $this->postEntity->addPost($postModel);
    }

    public function updateStatus(int $postId, string $postStatus): void
    {
        $this->postEntity->updateStatus($postId, $postStatus);
    }

    public function modifyPost(array $formModifyPost, int $postId): void
    {
        $postModel = new PostModel();
        $this->hydrateFromPostArray($formModifyPost, $postModel);
        $this->postEntity->modifyPost($postModel, $postId);
    }

    public function getHeaders(): array
    {
        return ["header" => $this->getHeader()];
    }
}
