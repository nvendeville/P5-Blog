<?php
namespace App\Controller;

use App\core\Renderer;
use App\entity\HomeEntity;
use App\entity\PostEntity;
use App\Model\HomeModel;
use App\model\PostModel;

require_once '../vendor/autoload.php';


class PagesController {

    private $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer();

    }

    public function home() {

        $data = HomeEntity::getInstance()->all(true);
        $this->renderer->render("index.html.twig", new HomeModel($data));
    }

    public function blog() {
        $data = PostEntity::getInstance()->all(true);
        $home = HomeEntity::getInstance()->all(true);
        $data->blog_title = $home->blog_title;
        $this->renderer->render("blog.html.twig", new PostModel($data));

    }
}





