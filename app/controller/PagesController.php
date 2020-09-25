<?php
namespace App\Controller;

use App\core\Renderer;
use App\entity\FooterEntity;
use App\entity\HeaderEntity;
use App\entity\HomeEntity;
use App\entity\PostEntity;
use App\entity\UserEntity;
use App\Model\FooterModel;
use App\Model\HeaderModel;
use App\Model\HomeModel;
use App\model\PostModel;
use App\model\UserModel;



class PagesController {

    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();
    }



    public function posts() {
        $postEntity = new PostEntity();
        $posts = $postEntity->getAll();
        $models = ["common" => $this->common(), "posts" => $posts];
        $this->renderer->render("post.html.twig",$models);
    }

    public function comments() {
        $commentEntity = new CommentEntity();
        $comments = $commentEntity->getAll();
        $models = ["common" => $this->common(), "comments" => $comments];
        $this->renderer->render("post.html.twig",$models);

    }


}





