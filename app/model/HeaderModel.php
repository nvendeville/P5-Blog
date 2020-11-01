<?php

namespace App\Model;

class HeaderModel
{
    private $id;
    private $blog_title;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBlogTitle()
    {
        return $this->blog_title;
    }

    /**
     * @param mixed $blog_title
     */
    public function setBlogTitle($blog_title)
    {
        $this->blog_title = $blog_title;
    }


}

