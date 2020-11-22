<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;
use App\model\PostModel;

class PostEntity extends DataAccessManager
{
    private const ARCHIVED = 2;
    private const POSTED = 3;
    protected static string $table = 'posts';
    protected static PostEntity $instance;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): PostEntity
    {
        if (!isset(self::$instance)) {
            self::$instance = new PostEntity();
        }
        return self::$instance;
    }

    public function addPost(PostModel $postModel): void
    {
        $statement = "INSERT INTO `posts` (`idUser`, `title`, `header`, `content`, `img`, `status`, `category`) 
            VALUES (?,?,?,?,?,?,?)";
        $values = [$postModel->getIdUser(), $postModel->getTitle(), $postModel->getHeader(), $postModel->getContent(),
            $postModel->getImg(), $postModel->getStatus(), $postModel->getCategory()];
        $insert = self::getPdo()->prepare($statement);
        $insert->execute($values);
    }

    public function getPaginatedPosts(int $from, int $nbPost): array
    {
        $statement = "SELECT *
            FROM `posts`
            WHERE `status` = " . self::POSTED . "
            ORDER BY `creationDate` DESC
            LIMIT $from, $nbPost";
        return $this->all($statement);
    }

    public function getCategories(): array
    {
        $statement = "
        SELECT  `category` as categoryName, COUNT(id) as nbPosts
        FROM `posts`
        WHERE `status`=" . self::POSTED . "
        GROUP BY category";
        return $this->all($statement);
    }

    public function getPostsByCategory(string $categoryName, int $from, int $nbPost): array
    {
        $statement = "SELECT `posts`.`id`, `posts`.`idUser`, `posts`.`creationDate`, `posts`.`title`, `posts`.`header`, 
                    `posts`.`content`, `posts`.`img`, `posts`.`status`, `posts`.`category`, `posts`.`lastUpdate`
                    FROM `posts`
                    WHERE `posts`.`category`=? AND `status`=" . self::POSTED . "
                    ORDER BY `creationDate` DESC LIMIT $from, $nbPost";
        $req =  $this->prepare($statement, [$categoryName], get_called_class());
        return $req->fetchAll();
    }

    public function getLatestCommentedPosts(): array
    {
        $statement = "SELECT `posts`.`id`, `posts`.`idUser`, `comments`.`creationDate`, `posts`.`title`,
        `posts`.`header`, `posts`.`content`, `posts`.`img`, `posts`.`status`, `posts`.`category`, 
            count(comments.id) as nbComments 
            FROM `posts` 
            inner join comments on comments.idPost = posts.id and comments.status = 2
            group by  `posts`.`id`, `posts`.`idUser`, `posts`.`title`, `posts`.`header`, 
                      `posts`.`content`, `posts`.`img`, `posts`.`status`, `posts`.`category` 
            order by `comments`.`creationDate` desc limit 3";
        return $this->all($statement);
    }

    public function getPostedNbPosts(): object
    {
        $statement = "SELECT COUNT(posts.id) AS nbPosts FROM `posts` WHERE `status`=" . self::POSTED;
        return $this->one($statement);
    }

    public function getNbPostsByCategories(string $categoryName): object
    {
        $statement = "SELECT COUNT(posts.id) AS nbPosts
            FROM `posts`
            WHERE `status`=" . self::POSTED . " AND `posts`.`category`=?  ";
        $req = $this->prepare($statement, [$categoryName], get_called_class());
        return $req->fetch();
    }

    public function getAllPosts(): array
    {
        $statement = "SELECT * FROM `posts` ORDER BY `creationDate` DESC";
        return $this->all($statement);
    }

    public function updateStatus(int $postId, string $postStatus): void
    {
        $date = date("Y-m-d H:i:s");
        $statement = self::getPdo()->prepare("
        UPDATE `posts`
        SET `status`= ?, `lastUpdate`='$date'
        WHERE posts.id=?");
        $statement->execute([$postStatus, $postId]);
    }

    public function archivePost(int $postId): void
    {
        $statement = self::getPdo()->prepare("UPDATE `posts` SET `status`=" . self::ARCHIVED . " WHERE posts.id=?");
        $statement->execute([$postId]);
    }

    public function modifyPost(PostModel $adminPostModel, int $postId): void
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
        $insert = self::getPdo()->prepare($statement);
        $insert->execute($values);
    }
}
