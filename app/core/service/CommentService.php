<?php


namespace App\core\service;


use App\core\entity\CommentEntity;
use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
use App\model\CommentModel;
use App\model\PostModel;
use App\model\UserModel;

class CommentService extends AbstractService
{

    public function getCommentsByPostId ($postId) {
        $comments = CommentEntity::getInstance()->getCommentsByPostId($postId);
        $commentsModel = [];
        foreach ($comments as $comment) {
            // instanciation du CommentModel et hydratation du modèle
            $commentModel = new CommentModel();
            $this->hydrate($comment, $commentModel);
            // instanciation du UserModel et hydratation du modèle
            $userEntity = UserEntity::getInstance()->getById($commentModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            // le commentModel récupère les infos du user
            $commentModel->setUser($userModel);

            array_push($commentsModel, $commentModel);
        }

        return $commentsModel;
    }


}