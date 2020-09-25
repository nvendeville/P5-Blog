<?php


namespace App\core\entity;


use App\Core\Database\DataAccessManager;
use App\model\PostModel;
use App\model\UserModel;

class CommentEntity extends DataAccessManager
{
    protected static $table = 'comments';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new CommentEntity();
        }
        return self::$_instance;
    }

    public function getCommentsByPostId ($postId) {
        $statement = "SELECT * FROM comments WHERE idPost = $postId AND status = 'validated' ORDER BY creationDate DESC";
        return $this->query($statement, get_called_class(), false);
    }
}