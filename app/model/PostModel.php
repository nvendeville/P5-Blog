<?php


namespace App\model;


class PostModel
{
    public $id_post;
    public $id_user;
    public $creation_date;
    public $title;
    public $header;
    public $content;
    public $status;
    public $category;
    public $blog_title;

    public function __construct($post_entity)
    {
        foreach ($this as $key => $value) {
            $this->$key = $post_entity->$key;
        }
    }
}