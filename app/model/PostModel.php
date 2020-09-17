<?php


namespace App\model;


class PostModel
{
    public $id;
    public $id_user;
    public $creation_date;
    public $title;
    public $header;
    public $content;
    public $status;
    public $category;
    public $user;

    public function __construct($postEntity)
    {
        foreach ($postEntity as $key => $value) {
            $this->$key = $postEntity->$key;
        }
    }
}