<?php

namespace App\model;

class HomeModel
{
    private $idHome;
    private $heroFirstname;
    private $heroLastname;
    private $heroLink;
    private $heroImg;
    private $cvImg;
    private $sectionTitle;
    private $sectionContent;
    private $galleryImg1;
    private $galleryImg2;
    private $galleryImg3;
    private $galleryImg4;
    private $dividerImg;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->idHome;
    }

    /**
     * @param mixed $idHome
     */
    public function setId($idHome)
    {
        $this->idHome = $idHome;
    }

    /**
     * @return mixed
     */
    public function getHeroFirstname()
    {
        return $this->heroFirstname;
    }

    /**
     * @param mixed $heroFirstname
     */
    public function setHeroFirstname($heroFirstname)
    {
        $this->heroFirstname = $heroFirstname;
    }

    /**
     * @return mixed
     */
    public function getHeroLastname()
    {
        return $this->heroLastname;
    }

    /**
     * @param mixed $heroLastname
     */
    public function setHeroLastname($heroLastname)
    {
        $this->heroLastname = $heroLastname;
    }

    /**
     * @return mixed
     */
    public function getHeroLink()
    {
        return $this->heroLink;
    }

    /**
     * @param mixed $heroLink
     */
    public function setHeroLink($heroLink)
    {
        $this->heroLink = $heroLink;
    }

    /**
     * @return mixed
     */
    public function getHeroImg()
    {
        return $this->heroImg;
    }

    /**
     * @param mixed $heroImg
     */
    public function setHeroImg($heroImg)
    {
        $this->heroImg = $heroImg;
    }

    /**
     * @return mixed
     */
    public function getCvImg()
    {
        return $this->cvImg;
    }

    /**
     * @param mixed $cvImg
     */
    public function setCvImg($cvImg)
    {
        $this->cvImg = $cvImg;
    }

    /**
     * @return mixed
     */
    public function getSectionTitle()
    {
        return $this->sectionTitle;
    }

    /**
     * @param mixed $sectionTitle
     */
    public function setSectionTitle($sectionTitle)
    {
        $this->sectionTitle = $sectionTitle;
    }

    /**
     * @return mixed
     */
    public function getSectionContent()
    {
        return $this->sectionContent;
    }

    /**
     * @param mixed $sectionContent
     */
    public function setSectionContent($sectionContent)
    {
        $this->sectionContent = $sectionContent;
    }

    /**
     * @return mixed
     */
    public function getGalleryImg1()
    {
        return $this->galleryImg1;
    }

    /**
     * @param mixed $galleryImg1
     */
    public function setGalleryImg1($galleryImg1)
    {
        $this->galleryImg1 = $galleryImg1;
    }

    /**
     * @return mixed
     */
    public function getGalleryImg2()
    {
        return $this->galleryImg2;
    }

    /**
     * @param mixed $galleryImg2
     */
    public function setGalleryImg2($galleryImg2)
    {
        $this->galleryImg2 = $galleryImg2;
    }

    /**
     * @return mixed
     */
    public function getGalleryImg3()
    {
        return $this->galleryImg3;
    }

    /**
     * @param mixed $galleryImg3
     */
    public function setGalleryImg3($galleryImg3)
    {
        $this->galleryImg3 = $galleryImg3;
    }

    /**
     * @return mixed
     */
    public function getGalleryImg4()
    {
        return $this->galleryImg4;
    }

    /**
     * @param mixed $galleryImg4
     */
    public function setGalleryImg4($galleryImg4)
    {
        $this->galleryImg4 = $galleryImg4;
    }

    /**
     * @return mixed
     */
    public function getDividerImg()
    {
        return $this->dividerImg;
    }

    /**
     * @param mixed $dividerImg
     */
    public function setDividerImg($dividerImg)
    {
        $this->dividerImg = $dividerImg;
    }
}
