<?php

namespace App\core\service;

use App\core\entity\CommentEntity;
use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
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
        $this->commentEntity = new CommentEntity();
        $this->userEntity = new UserEntity();
        $this->postEntity = new PostEntity();
    }

    public function getBlog(int $currentPage): array
    {
        $nbPages = $this->getNbPage();
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;
        $postsModel = $this->postEntity->getPaginatedPosts($premier, self::NB_POSTS_PER_PAGE);
        foreach ($postsModel as $postModel) {
            $postModel->setUser($this->userEntity->getById($postModel->getIdUser(), UserModel::class));
            $postModel->setUrl("/P5-blog/posts/detail:" . $postModel->getId());
            $postModel->setNbComments(count($this->getComments($postModel->getId())));
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
        return $this->postEntity->getCategories();
    }

    protected function getLatestCommentedPosts(): array
    {
        $commentedPostsModel = $this->postEntity->getLatestCommentedPosts();
        foreach ($commentedPostsModel as $commentedPostModel) {
            $commentedPostModel->setUrl("/P5-blog/posts/detail:" . $commentedPostModel->getId());
        }
        return $commentedPostsModel;
    }

    public function getPosts(int $currentPage): array
    {
        $posts = $this->postEntity->getAllPosts();

        return ["header" => $this->getHeader(), "adminPosts" => $posts, "currentPage" => $currentPage];
    }

    public function getPostsByCategory(string $categoryName, int $currentPage): array
    {
        $nbPages = $this->getNbPostsByCategories($categoryName);
        $premier = ($currentPage * self::NB_POSTS_PER_PAGE) - self::NB_POSTS_PER_PAGE;
        $postsModel = $this->postEntity->getPostsByCategory($categoryName, $premier, self::NB_POSTS_PER_PAGE);
        foreach ($postsModel as $postModel) {
            $postModel->setUser($this->userEntity->getById($postModel->getIdUser(), UserModel::class));
            $postModel->setUrl("/P5-blog/posts/detail:" . $postModel->getId());
            $postModel->setNbComments(count($this->getComments($postModel->getId())));
        }
        return ["header" => $this->getHeader(), "posts" => $postsModel, "footer" => $this->getFooter(),
            "categories" => $this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "nbPages" => (int)$nbPages, "currentPage" => $currentPage, "urlParam" => $categoryName];
    }

    private function getNbPostsByCategories(string $categoryName): int
    {
        $nbPosts = $this->postEntity->getNbPostsByCategories($categoryName);
        return ceil((int)$nbPosts->getNbPosts() / (int)self::NB_POSTS_PER_PAGE);
    }

    public function getPostDetail(int $postId): array
    {
        $postModel = $this->postEntity->getById($postId, PostModel::class);
        $postModel->setUser($this->userEntity->getById($postModel->getIdUser(), UserModel::class));
        return ["header" => $this->getHeader(), "post" => $postModel, "footer" => $this->getFooter(),
            "categories" => $this->getCategories(), "latestCommentedPosts" => $this->getLatestCommentedPosts(),
            "comments" => $this->getComments($postId)];
    }

    public function getPost(int $postId): array
    {
        $postModel = $this->postEntity->getById($postId, PostModel::class);
        $postModel->setUser($this->userEntity->getById($postModel->getIdUser(), UserModel::class));
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
