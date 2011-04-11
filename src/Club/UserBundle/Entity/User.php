<?php

namespace Club\UserBundle\Entity;

use DateTime;

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
     * @var date $last_login_time
     */
    private $last_login_time;

    /**
     * @var string $last_login_ip
     */
    private $last_login_ip;

    /**
     * @var boolean $enabled
     */
    private $enabled;

    /**
     * @var string $algorithm
     */
    private $algorithm;

    /**
     * @var string $salt
     */
    private $salt;

    /**
     * @var boolean $locked
     */
    private $locked;

    /**
     * @var boolean $expired
     */
    private $expired;

    /**
     * @var date $expires_at
     */
    private $expires_at;

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
     * @var Club\UserBundle\Entity\Language
     */
    private $language;

    /**
     * @var Club\MailBundle\Entity\Mail
     */
    private $mails;

    public function __construct()
    {
        $this->mails = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set algorithm
     *
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Get algorithm
     *
     * @return string $algorithm
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * Get locked
     *
     * @return boolean $locked
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    /**
     * Get expired
     *
     * @return boolean $expired
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set expires_at
     *
     * @param date $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expires_at = $expiresAt;
    }

    /**
     * Get expires_at
     *
     * @return date $expiresAt
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
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

    /**
     * Set language
     *
     * @param Club\UserBundle\Entity\Language $language
     */
    public function setLanguage(\Club\UserBundle\Entity\Language $language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return Club\UserBundle\Entity\Language $language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Add mails
     *
     * @param Club\MailBundle\Entity\Mail $mails
     */
    public function addMails(\Club\MailBundle\Entity\Mail $mails)
    {
        $this->mails[] = $mails;
    }

    /**
     * Get mails
     *
     * @return Doctrine\Common\Collections\Collection $mails
     */
    public function getMails()
    {
        return $this->mails;
    }
    /**
     * @orm:prePersist
     */
    public function prePersist()
    {
      // Add your code here
      $this->setPassword('1234');
      $this->setSalt(hash('sha1',uniqid()));
      $this->setUsername(1);
      $this->setEnabled(1);
      $this->setAlgorithm('sha512');
      $this->setLocked(0);
      $this->setExpired(0);
      $this->setCreatedAt(new DateTime());
      $this->setUpdatedAt(new DateTime());
    }

    public function toArray()
    {
      return array(
        'id' => $this->getId(),
        'username' => $this->getUsername(),
        'created_at' => $this->getCreatedAt(),
        'updated_at' => $this->getUpdatedAt(),
        'profile' => array(
          'first_name' => $this->getProfile()->getFirstName(),
          'last_name' => $this->getProfile()->getLastName()
        )
      );
    }
}
