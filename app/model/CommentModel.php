<?php


namespace App\model;


class CommentModel
{
    public $id;
    public $id_user;
    public $id_post;
    public $creation_date;
    public $content;
    public $status;
    public $is_an_answer;
    public $id_answered_comment;
    public $user;

    public function __construct($commentEntity)
    {
        foreach ($commentEntity as $key => $value) {
            $this->$key = $commentEntity->$key;
        }
    }
}