<?php

namespace App\model;

class CategoryModel
{
    private string $categoryName;
    private int $nbPosts;



    public function getCategoryName(): string
    {
        return $this->categoryName;
    }


    public function setCategoryName(string $categoryName): void
    {
        $this->categoryName = $categoryName;
    }


    public function getNbPosts(): int
    {
        return $this->nbPosts;
    }


    public function setNbPosts(int $nbPosts): void
    {
        $this->nbPosts = $nbPosts;
    }
}
