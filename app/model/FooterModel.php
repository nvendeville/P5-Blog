<?php

namespace App\Model;

class FooterModel
{
    private $id;
    private $firstname;
    private $lastname;
    private $address;
    private $phone_number;
    private $email;
    private $facebook_link;
    private $twitter_link;
    private $instagram_link;
    private $linkedin_link;
    private $github_link;

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
        return $this->phone_number;
    }

    /**
     * @param mixed $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
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
        return $this->facebook_link;
    }

    /**
     * @param mixed $facebook_link
     */
    public function setFacebookLink($facebook_link)
    {
        $this->facebook_link = $facebook_link;
    }

    /**
     * @return mixed
     */
    public function getTwitterLink()
    {
        return $this->twitter_link;
    }

    /**
     * @param mixed $twitter_link
     */
    public function setTwitterLink($twitter_link)
    {
        $this->twitter_link = $twitter_link;
    }

    /**
     * @return mixed
     */
    public function getInstagramLink()
    {
        return $this->instagram_link;
    }

    /**
     * @param mixed $instagram_link
     */
    public function setInstagramLink($instagram_link)
    {
        $this->instagram_link = $instagram_link;
    }

    /**
     * @return mixed
     */
    public function getLinkedinLink()
    {
        return $this->linkedin_link;
    }

    /**
     * @param mixed $linkedin_link
     */
    public function setLinkedinLink($linkedin_link)
    {
        $this->linkedin_link = $linkedin_link;
    }

    /**
     * @return mixed
     */
    public function getGithubLink()
    {
        return $this->github_link;
    }

    /**
     * @param mixed $github_link
     */
    public function setGithubLink($github_link)
    {
        $this->github_link = $github_link;
    }


}

