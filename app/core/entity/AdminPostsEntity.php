<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;

class AdminPostsEntity extends DataAccessManager
{
    private const ARCHIVED = 2;
    private const POSTED = 3;
    protected static string $table = 'posts';
    protected static $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new AdminPostsEntity();
        }
        return self::$instance;
    }

    public function getPaginatedPosts(): array
    {
        $statement = "SELECT * FROM `posts` ORDER BY `creationDate` DESC";
        return $this->query($statement, get_called_class(), false);
    }

    public function getNbPosts(): int
    {
        $statement = "SELECT COUNT(posts.id) as nbPosts FROM posts";
        return $this->query($statement, get_called_class(), true);
    }

    public function validatePost(int $postId): void
    {
        $date = date("Y-m-d H:i:s");
        $statement = $this->pdo->prepare("
        UPDATE `posts`
        SET `status`=" . self::POSTED . ", `lastUpdate`='$date'
        WHERE posts.id=?");
        $statement->execute([$postId]);
    }

    public function archivePost(int $postId): void
    {
        $statement = $this->pdo->prepare("UPDATE `posts` SET `status`=" . self::ARCHIVED . " WHERE posts.id=?");
        $statement->execute([$postId]);
    }

    public function modifyPost(object $adminPostModel, int $postId): void
    {
        $date = date("Y-m-d H:i:s");
        $statement = "UPDATE `posts` SET `title`=?, `header`=?, `content`=?";
        $values = [$adminPostModel->getTitle(), $adminPostModel->getHeader(), $adminPostModel->getContent()];
        if ($adminPostModel->getImg() != '') {
            $statement = $statement . ", `img`=?";
            array_push($values, $adminPostModel->getImg());
        }
        $statement = $statement . ",`status`=?, `category`=?, `lastUpdate`=?
            WHERE id=?";
        array_push($values, $adminPostModel->getStatus(), $adminPostModel->getCategory(), $date, $postId);
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }
}
