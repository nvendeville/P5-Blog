<?php


namespace App\entity;


use App\Core\Database\DataAccessManager;
use App\model\PostModel;
use App\model\UserModel;

class PostEntity extends DataAccessManager
{
    protected static $table = 'posts';
    protected static $_instance;

    public function __construct() {
        parent::__construct();
    }

    protected function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new PostEntity();
        }
        return self::$_instance;
    }

    public function getAll () {
        $data = $this->getInstance()->all();
        $posts = [];
        foreach ($data as $post) {
            $postModel = new PostModel($post);
            $user = new UserModel(UserEntity::getInstance()->getById($postModel->id_user));
            $postModel->user = $user;
            array_push($posts, $postModel);
        }

        return $posts;
    }
}