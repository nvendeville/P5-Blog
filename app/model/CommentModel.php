<?php

namespace App\model;

class CommentModel
{
    private int $id;
    private int $idUser;
    private int $idPost;
    private string $creationDate;
    private string $content;
    private string $status;
    private UserModel $user;
    private string $titlePost;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdPost(): int
    {
        return $this->idPost;
    }

    /**
     * @param int $idPost
     */
    public function setIdPost(int $idPost): void
    {
        $this->idPost = $idPost;
    }

    /**
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     */
    public function setCreationDate(string $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \App\model\UserModel
     */
    public function getUser(): UserModel
    {
        return $this->user;
    }

    /**
     * @param \App\model\UserModel $user
     */
    public function setUser(UserModel $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getTitlePost(): string
    {
        return $this->titlePost;
    }

    /**
     * @param string $titlePost
     */
    public function setTitlePost(string $titlePost): void
    {
        $this->titlePost = $titlePost;
    }
}
