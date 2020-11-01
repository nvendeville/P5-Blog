<?php


namespace App\model;


class CategoryModel
{
    private $categoryName;
    private $nbPosts;


    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * @param mixed $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    /**
     * @return mixed
     */
    public function getNbPosts()
    {
        return $this->nbPosts;
    }

    /**
     * @param mixed $nbPosts
     */
    public function setNbPosts($nbPosts)
    {
        $this->nbPosts = $nbPosts;
    }


}