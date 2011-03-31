<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\User
 */
class User
{
    /**
     * @var integer $id
     */
    private $id;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var integer $profile_id
     */
    private $profile_id;

    /**
     * @var string $username
     */
    private $username;

    /**
     * @var email $email_address
     */
    private $email_address;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var Club\UserBundle\Entity\Profile
     */
    private $profile;


    /**
     * Set profile_id
     *
     * @param integer $profileId
     */
    public function setProfileId($profileId)
    {
        $this->profile_id = $profileId;
    }

    /**
     * Get profile_id
     *
     * @return integer $profileId
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email_address
     *
     * @param email $emailAddress
     */
    public function setEmailAddress(\email $emailAddress)
    {
        $this->email_address = $emailAddress;
    }

    /**
     * Get email_address
     *
     * @return email $emailAddress
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set profile
     *
     * @param Club\UserBundle\Entity\Profile $profile
     */
    public function setProfile(\Club\UserBundle\Entity\Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Get profile
     *
     * @return Club\UserBundle\Entity\Profile $profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}