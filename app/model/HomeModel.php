<?php

namespace App\Model;

class HomeModel {
    public $id;
    public $hero_firstname;
    public $hero_lastname;
    public $hero_link;
    public $hero_img;
    public $cv_link;
    public $cv_img;
    public $section_title;
    public $section_content;
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

