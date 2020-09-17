<?php


namespace App\entity;


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

    public function getAll () {
        $data = $this->getInstance()->all();
        $comments = [];
        foreach ($data as $comment) {
            $commentModel = new CommentModel($comment);
            $user = new UserModel(UserEntity::getInstance()->getById($commentModel->id_user));
            $commentModel->user = $user;
            array_push($comments, $commentModel);
        }

        return $comments;
    }
}