<?php

namespace App\Model;

class HomeModel {
    private $id;
    private $hero_firstname;
    private $hero_lastname;
    private $hero_link;
    private $hero_img;
    private $cv_link;
    private $cv_img;
    private $section_title;
    private $section_content;
    private $gallery_img1;
    private $gallery_img2;
    private $gallery_img3;
    private $gallery_img4;
    private $divider_img;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getHeroFirstname()
    {
        return $this->hero_firstname;
    }

    /**
     * @param mixed $hero_firstname
     */
    public function setHeroFirstname($hero_firstname)
    {
        $this->hero_firstname = $hero_firstname;
    }

    /**
     * @return mixed
     */
    public function getHeroLastname()
    {
        return $this->hero_lastname;
    }

    /**
     * @param mixed $hero_lastname
     */
    public function setHeroLastname($hero_lastname)
    {
        $this->hero_lastname = $hero_lastname;
    }

    /**
     * @return mixed
     */
    public function getHeroLink()
    {
        return $this->hero_link;
    }

    /**
     * @param mixed $hero_link
     */
    public function setHeroLink($hero_link)
    {
        $this->hero_link = $hero_link;
    }

    /**
     * @return mixed
     */
    public function getHeroImg()
    {
        return $this->hero_img;
    }

    /**
     * @param mixed $hero_img
     */
    public function setHeroImg($hero_img)
    {
        $this->hero_img = $hero_img;
    }

    /**
     * @return mixed
     */
    public function getCvLink()
    {
        return $this->cv_link;
    }

    /**
     * @param mixed $cv_link
     */
    public function setCvLink($cv_link)
    {
        $this->cv_link = $cv_link;
    }

    /**
     * @return mixed
     */
    public function getCvImg()
    {
        return $this->cv_img;
    }

    /**
     * @param mixed $cv_img
     */
    public function setCvImg($cv_img)
    {
        $this->cv_img = $cv_img;
    }

    /**
     * @return mixed
     */
    public function getSectionTitle()
    {
        return $this->section_title;
    }

    /**
     * @param mixed $section_title
     */
    public function setSectionTitle($section_title)
    {
        $this->section_title = $section_title;
    }

    /**
     * @return mixed
     */
    public function getSectionContent()
    {
        return $this->section_content;
    }

    /**
     * @param mixed $section_content
     */
    public function setSectionContent($section_content)
    {
        $this->section_content = $section_content;
    }

    /**
     * @return mixed
     */
    public function getGalleryImg1()
    {
        return $this->gallery_img1;
    }

    /**
     * @param mixed $gallery_img1
     */
    public function setGalleryImg1($gallery_img1)
    {
        $this->gallery_img1 = $gallery_img1;
    }

    /**
     * @return mixed
     */
    public function getGalleryImg2()
    {
        return $this->gallery_img2;
    }

    /**
     * @param mixed $gallery_img2
     */
    public function setGalleryImg2($gallery_img2)
    {
        $this->gallery_img2 = $gallery_img2;
    }

    /**
     * @return mixed
     */
    public function getGalleryImg3()
    {
        return $this->gallery_img3;
    }

    /**
     * @param mixed $gallery_img3
     */
    public function setGalleryImg3($gallery_img3)
    {
        $this->gallery_img3 = $gallery_img3;
    }

    /**
     * @return mixed
     */
    public function getGalleryImg4()
    {
        return $this->gallery_img4;
    }

    /**
     * @param mixed $gallery_img4
     */
    public function setGalleryImg4($gallery_img4)
    {
        $this->gallery_img4 = $gallery_img4;
    }

    /**
     * @return mixed
     */
    public function getDividerImg()
    {
        return $this->divider_img;
    }

    /**
     * @param mixed $divider_img
     */
    public function setDividerImg($divider_img)
    {
        $this->divider_img = $divider_img;
    }

}

