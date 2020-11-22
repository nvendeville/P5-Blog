<?php

namespace App\model;

class HeaderModel
{
    private int $idHeader;
    private string $blogTitle = "";

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->idHeader;
    }

    /**
     * @param int $idHeader
     */
    public function setId(int $idHeader): void
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
