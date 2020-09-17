<?php

namespace App\Model;

class FooterModel {
    public $id;
    public $firstname;
    public $lastname;
    public $address;
    public $phone_number;
    public $email;
    public $facebook_link;
    public $twitter_link;
    public $instagram_link;
    public $linkedin_link;
    public $github_link;

    public function __construct($footer_entity) {
        foreach ($this as $key => $value) {
           $this->$key = $footer_entity->$key;
        }
    }
}

