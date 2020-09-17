<?php


namespace App\model;


class UserModel
{
    public $id;
    public $firstname;
    public $lastname;
    public $username;
    public $password;
    public $email;
    public $ok_newsletter;
    public $is_admin;

    public function __construct($user_entity)
    {
        foreach ($this as $key => $value) {
            $this->$key = $user_entity->$key;
        }
    }
}

