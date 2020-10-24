<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;

class HomeEntity extends DataAccessManager
{
    protected static $table = 'home';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new HomeEntity();
        }
        return self::$_instance;
    }

    public function persoHomePage($homeModel) {
        $statement =
            "UPDATE `home` SET `heroFirstname`=?, `heroLastname`=?, `heroLink`=?";
        $values=[$homeModel->getHeroFirstname(), 
                $homeModel->getHeroLastname(), 
                $homeModel->getHeroLink()];
        if ($homeModel->getHeroImg() != '') {
            $statement = $statement . ", `heroImg`=?";
            array_push($values, $homeModel->getHeroImg());
        }
        $statement = $statement . ", `cvLink`=?";
        array_push($values, $homeModel->getCvLink());
        if ($homeModel->getcvImg() != '') {
            $statement = $statement . ", `cvImg`=?";
            array_push($values, $homeModel->getcvImg());
        }
        $statement = $statement . ", `sectionTitle`=?, `sectionContent`=?";
        array_push($values, $homeModel->getSectionTitle(), $homeModel->getSectionContent());
        if ($homeModel->getGalleryImg1() != '') {
            $statement = $statement . ", `galleryImg1`=?";
            array_push($values, $homeModel->getGalleryImg1());
        }
        if ($homeModel->getGalleryImg2() != '') {
            $statement = $statement . ", `galleryImg2`=?";
            array_push($values, $homeModel->getGalleryImg2());
        }
        if ($homeModel->getGalleryImg3() != '') {
            $statement = $statement . ", `galleryImg3`=?";
            array_push($values, $homeModel->getGalleryImg3());
        }
        if ($homeModel->getGalleryImg4() != '') {
            $statement = $statement . ", `galleryImg4`=?";
            array_push($values, $homeModel->getGalleryImg4());
        }
        if ($homeModel->getDividerImg() != '') {
            $statement = $statement . ", `dividerImg`=?";
            array_push($values, $homeModel->getDividerImg());
        }
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }
}