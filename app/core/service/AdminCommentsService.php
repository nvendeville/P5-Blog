<?php


namespace App\core\service;


use App\core\entity\AdminCommentsEntity;
use App\core\entity\CommentEntity;
use App\core\entity\PostEntity;
use App\core\entity\UserEntity;
use App\Model\AdminCommentsModel;
use App\model\CommentModel;
use App\model\PostModel;
use App\model\UserModel;

class AdminCommentsService extends AbstractService
{

    const NB_COMMENTS_PER_PAGE = 6;

    public function getModel () {
        $entity = AdminCommentsEntity::getInstance()->one();
        $adminModel = new AdminCommentsModel();
        $this->hydrate($entity, $adminModel);
        return ["header" => $this->getHeader(), "footer" => $this->getFooter()];
    }

    public function getAll ($currentPage) {
        $nbPages = $this->getNbPage();
        $premier = ($currentPage * self::NB_COMMENTS_PER_PAGE) - self::NB_COMMENTS_PER_PAGE;

        $entities = CommentEntity::getInstance()->getPaginatedComments($premier, self::NB_COMMENTS_PER_PAGE);
        $commentsModel = [];
        foreach ($entities as $comment) {
            $commentModel = new CommentModel();
            $this->hydrate($comment, $commentModel);

            $userEntity = UserEntity::getInstance()->getById($commentModel->getIdUser());
            //$userEntity = $this->userInstance->getById($postModel->getIdUser());
            $userModel = new UserModel();
            $this->hydrate($userEntity, $userModel);
            $commentModel->setUser($userModel);

            $postEntity = PostEntity::getInstance()->getById($commentModel->getIdPost());
            $postModel = new PostModel();
            $this->hydrate($postEntity, $postModel);
            $commentModel->setTitlePost($postModel->getTitle());

            array_push($commentsModel, $commentModel);
        }

        return ["header" => $this->getHeader(), "adminComments" => $commentsModel, "nbPages" => (int)$nbPages, "currentPage" => $currentPage];
    }


    public function validateComment ($id, $currentPage) {
        AdminCommentsEntity::getInstance()->validateComment($id);
        return $this->getAll($currentPage);
    }

    public function rejectComment ($id, $currentPage) {
        AdminCommentsEntity::getInstance()->rejectComment($id);
        return $this->getAll($currentPage);
    }

    public function addComment($formAddComment) {
        $commentModel = new commentModel();
        $this->hydrateFromPostArray($formAddComment, $commentModel);
        CommentEntity::getInstance()->addComment($commentModel);
    }

    private function getNbPage () {
        $nbComments = CommentEntity::getInstance()->getNbComments();
        return ceil((int)$nbComments->nbComments / (int)self::NB_COMMENTS_PER_PAGE);
    }

}