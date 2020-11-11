<?php

namespace App\model;

class FooterModel
{
    private int $idFooter;
    private $firstname;
    private $lastname;
    private $address;
    private $phoneNumber;
    private $email;
    private $facebookLink;
    private $twitterLink;
    private $instagramLink;
    private $linkedinLink;
    private $githubLink;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->idFooter;
    }

    /**
     * @param mixed $idFooter
     */
    public function setId($idFooter)
    {
        $this->idFooter = $idFooter;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    /**
     * @param mixed $facebookLink
     */
    public function setFacebookLink($facebookLink)
    {
        $this->facebookLink = $facebookLink;
    }

    /**
     * @return mixed
     */
    public function getTwitterLink()
    {
        return $this->twitterLink;
    }

    /**
     * @param mixed $twitterLink
     */
    public function setTwitterLink($twitterLink)
    {
        $this->twitterLink = $twitterLink;
    }

    /**
     * @return mixed
     */
    public function getInstagramLink()
    {
        return $this->instagramLink;
    }

    /**
     * @param mixed $instagramLink
     */
    public function setInstagramLink($instagramLink)
    {
        $this->instagramLink = $instagramLink;
    }

    /**
     * @return mixed
     */
    public function getLinkedinLink()
    {
        return $this->linkedinLink;
    }

    /**
     * @param mixed $linkedinLink
     */
    public function setLinkedinLink($linkedinLink)
    {
        $this->linkedinLink = $linkedinLink;
    }

    /**
     * @return mixed
     */
    public function getGithubLink()
    {
        return $this->githubLink;
    }

    /**
     * @param mixed $githubLink
     */
    public function setGithubLink($githubLink)
    {
        $this->githubLink = $githubLink;
    }
}
