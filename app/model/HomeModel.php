<?php

namespace App\model;

class HomeModel
{
    private int $idHome;
    private string $heroFirstname;
    private string $heroLastname;
    private string $heroLink;
    private string $heroImg;
    private string $cvImg;
    private string $sectionTitle;
    private string $sectionContent;
    private string $galleryImg1;
    private string $galleryImg2;
    private string $galleryImg3;
    private string $galleryImg4;
    private string $dividerImg;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->idHome;
    }

    /**
     * @param int $idHome
     */
    public function setId(int $idHome): void
    {
        $this->idHome = $idHome;
    }

    /**
     * @return string
     */
    public function getHeroFirstname(): string
    {
        return $this->heroFirstname;
    }

    /**
     * @param string $heroFirstname
     */
    public function setHeroFirstname(string $heroFirstname): void
    {
        $this->heroFirstname = $heroFirstname;
    }

    /**
     * @return string
     */
    public function getHeroLastname(): string
    {
        return $this->heroLastname;
    }

    /**
     * @param string $heroLastname
     */
    public function setHeroLastname(string $heroLastname): void
    {
        $this->heroLastname = $heroLastname;
    }

    /**
     * @return string
     */
    public function getHeroLink(): string
    {
        return $this->heroLink;
    }

    /**
     * @param string $heroLink
     */
    public function setHeroLink(string $heroLink): void
    {
        $this->heroLink = $heroLink;
    }

    /**
     * @return string
     */
    public function getHeroImg(): string
    {
        return isset($this->heroImg) ? $this->heroImg : '';
    }

    /**
     * @param string $heroImg
     */
    public function setHeroImg(string $heroImg): void
    {
        $this->heroImg = $heroImg;
    }

    /**
     * @return string
     */
    public function getCvImg(): string
    {
        return isset($this->cvImg) ? $this->cvImg : '';
    }

    /**
     * @param string $cvImg
     */
    public function setCvImg(string $cvImg): void
    {
        $this->cvImg = $cvImg;
    }

    /**
     * @return string
     */
    public function getSectionTitle(): string
    {
        return $this->sectionTitle;
    }

    /**
     * @param string $sectionTitle
     */
    public function setSectionTitle(string $sectionTitle): void
    {
        $this->sectionTitle = $sectionTitle;
    }

    /**
     * @return string
     */
    public function getSectionContent(): string
    {
        return $this->sectionContent;
    }

    /**
     * @param string $sectionContent
     */
    public function setSectionContent(string $sectionContent): void
    {
        $this->sectionContent = $sectionContent;
    }

    /**
     * @return string
     */
    public function getGalleryImg1(): string
    {
        return isset($this->galleryImg1) ? $this->galleryImg1 : '';
    }

    /**
     * @param string $galleryImg1
     */
    public function setGalleryImg1(string $galleryImg1): void
    {
        $this->galleryImg1 = $galleryImg1;
    }

    /**
     * @return string
     */
    public function getGalleryImg2(): string
    {
        return isset($this->galleryImg2) ? $this->galleryImg2 : '';
    }

    /**
     * @param string $galleryImg2
     */
    public function setGalleryImg2(string $galleryImg2): void
    {
        $this->galleryImg2 = $galleryImg2;
    }

    /**
     * @return string
     */
    public function getGalleryImg3(): string
    {
        return isset($this->galleryImg3) ? $this->galleryImg3 : '';
    }

    /**
     * @param string $galleryImg3
     */
    public function setGalleryImg3(string $galleryImg3): void
    {
        $this->galleryImg3 = $galleryImg3;
    }

    /**
     * @return string
     */
    public function getGalleryImg4(): string
    {
        return isset($this->galleryImg4) ? $this->galleryImg4 : '';
    }

    /**
     * @param string $galleryImg4
     */
    public function setGalleryImg4(string $galleryImg4): void
    {
        $this->galleryImg4 = $galleryImg4;
    }

    /**
     * @return string
     */
    public function getDividerImg(): string
    {
        return isset($this->dividerImg) ? $this->dividerImg : '';
    }

    /**
     * @param string $dividerImg
     */
    public function setDividerImg(string $dividerImg): void
    {
        $this->dividerImg = $dividerImg;
    }
}
