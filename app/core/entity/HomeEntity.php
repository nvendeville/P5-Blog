<?php

namespace App\core\entity;

use App\core\database\DataAccessManager;

class HomeEntity extends DataAccessManager
{
    protected static string $table = 'home';
    protected static HomeEntity $instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new HomeEntity();
        }
        return self::$instance;
    }

    public function persoHomePage(object $homeModel): void
    {
        $statement = "UPDATE `home` SET `heroFirstname`=?, `heroLastname`=?, `heroLink`=?";
        $values = [$homeModel->getHeroFirstname(), $homeModel->getHeroLastname(), $homeModel->getHeroLink()];
        if ($homeModel->getHeroImg() != '') {
            $statement = $statement . ", `heroImg`=?";
            array_push($values, $homeModel->getHeroImg());
        }
        //$statement = $statement . ", `cvLink`=?";
        //array_push($values, $homeModel->getCvLink());
        if ($homeModel->getCvImg() != '') {
            $statement = $statement . ", `cvImg`=?";
            array_push($values, $homeModel->getCvImg());
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
        $insert = self::getPdo()->prepare($statement);
        $insert->execute($values);
    }
}
