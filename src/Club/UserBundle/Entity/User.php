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
     * @var string $username
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var string $language_id
     */
    private $language_id;

    /**
     * @var date $last_login_time
     */
    private $last_login_time;

    /**
     * @var string $last_login_ip
     */
    private $last_login_ip;

    /**
     * @var date $created_at
     */
    private $created_at;

    /**
     * @var date $updated_at
     */
    private $updated_at;

    /**
     * @var Club\UserBundle\Entity\Profile
     */
    private $profile;


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
     * Set language_id
     *
     * @param string $languageId
     */
    public function setLanguageId($languageId)
    {
        $this->language_id = $languageId;
    }

    /**
     * Get language_id
     *
     * @return string $languageId
     */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * Set last_login_time
     *
     * @param date $lastLoginTime
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->last_login_time = $lastLoginTime;
    }

    /**
     * Get last_login_time
     *
     * @return date $lastLoginTime
     */
    public function getLastLoginTime()
    {
        return $this->last_login_time;
    }

    /**
     * Set last_login_ip
     *
     * @param string $lastLoginIp
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->last_login_ip = $lastLoginIp;
    }

    /**
     * Get last_login_ip
     *
     * @return string $lastLoginIp
     */
    public function getLastLoginIp()
    {
        return $this->last_login_ip;
    }

    /**
     * Set created_at
     *
     * @param date $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param date $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
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
