<?php

namespace App\Model;

class HeaderModel {
    public $id;
    public $blog_title;

    public function __construct($header_entity) {
        foreach ($this as $key => $value) {
           $this->$key = $header_entity->$key;
        }
    }
}

