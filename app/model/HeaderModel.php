<?php

namespace App\model;

class HeaderModel
{
    private int $idHeader;
    private string $blogTitle = "";

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->idHeader;
    }

    /**
     * @param mixed $idHeader
     */
    public function setId($idHeader)
    {
        $this->idHeader = $idHeader;
    }

    /**
     * @return string
     */
    public function getBlogTitle(): string
    {
        return $this->blogTitle;
    }

    /**
     * @param string $blogTitle
     */
    public function setBlogTitle(string $blogTitle): void
    {
        $this->blogTitle = $blogTitle;
    }

}
