<?php

namespace App\Model;

class HomeModel {
    public $id;
    public $firstname;
    public $lastname;
    public $address;
    public $phone_number;
    public $email;
    public $cv;
    public $blog_title;
    public $hero_link;
    public $section_title;
    public $section_content;
    public $hero_img;
    public $cv_img;
    public $gallery_img1;
    public $gallery_img2;
    public $gallery_img3;
    public $gallery_img4;
    public $divider_img;

    public function __construct($home_entity) {
        foreach ($this as $key => $value) {
           $this->$key = $home_entity->$key;
        }
    }
}

