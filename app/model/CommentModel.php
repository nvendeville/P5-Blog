<?php

namespace App\model;

class CommentModel
{
    private $idComment;
    private $idUser;
    private $idPost;
    private $creationDate;
    private $content;
    private $status;
    private $user;
    private $titlePost;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->idComment;
    }

    /**
     * @param mixed $idComment
     */
    public function setId($idComment)
    {
        $this->idComment = $idComment;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * @param mixed $idPost
     */
    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getTitlePost()
    {
        return $this->titlePost;
    }

    /**
     * @param mixed $titlePost
     */
    public function setTitlePost($titlePost)
    {
        $this->titlePost = $titlePost;
    }
}
