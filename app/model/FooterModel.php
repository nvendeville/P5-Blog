<?php

declare(strict_types=1);

namespace App\model;

class FooterModel
{
    private int $idFooter;
    private string $firstname;
    private string $lastname;
    private string $address;
    private string $phoneNumber;
    private string $email;
    private string $facebookLink;
    private string $twitterLink;
    private string $instagramLink;
    private string $linkedinLink;
    private string $githubLink;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->idFooter;
    }

    /**
     * @param int $idFooter
     */
    public function setId(int $idFooter): void
    {
        $this->idFooter = $idFooter;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFacebookLink(): string
    {
        return $this->facebookLink;
    }

    /**
     * @param string $facebookLink
     */
    public function setFacebookLink(string $facebookLink): void
    {
        $this->facebookLink = $facebookLink;
    }

    /**
     * @return string
     */
    public function getTwitterLink(): string
    {
        return $this->twitterLink;
    }

    /**
     * @param string $twitterLink
     */
    public function setTwitterLink(string $twitterLink): void
    {
        $this->twitterLink = $twitterLink;
    }

    /**
     * @return string
     */
    public function getInstagramLink(): string
    {
        return $this->instagramLink;
    }

    /**
     * @param string $instagramLink
     */
    public function setInstagramLink(string $instagramLink): void
    {
        $this->instagramLink = $instagramLink;
    }

    /**
     * @return string
     */
    public function getLinkedinLink(): string
    {
        return $this->linkedinLink;
    }

    /**
     * @param string $linkedinLink
     */
    public function setLinkedinLink(string $linkedinLink): void
    {
        $this->linkedinLink = $linkedinLink;
    }

    /**
     * @return string
     */
    public function getGithubLink(): string
    {
        return $this->githubLink;
    }

    /**
     * @param string $githubLink
     */
    public function setGithubLink(string $githubLink): void
    {
        $this->githubLink = $githubLink;
    }
}
