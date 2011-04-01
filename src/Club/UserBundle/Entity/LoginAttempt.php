<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\LoginAttempt
 */
class LoginAttempt
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $user_id
     */
    private $user_id;

    /**
     * @var string $username
     */
    private $username;

    /**
     * @var string $session
     */
    private $session;

    /**
     * @var string $ip_address
     */
    private $ip_address;

    /**
     * @var string $hostname
     */
    private $hostname;

    /**
     * @var boolean $login_failed
     */
    private $login_failed;


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
     * Set user_id
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * Get user_id
     *
     * @return integer $userId
     */
    public function getUserId()
    {
        return $this->user_id;
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
     * Set session
     *
     * @param string $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * Get session
     *
     * @return string $session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set ip_address
     *
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ip_address = $ipAddress;
    }

    /**
     * Get ip_address
     *
     * @return string $ipAddress
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * Set hostname
     *
     * @param string $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * Get hostname
     *
     * @return string $hostname
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set login_failed
     *
     * @param boolean $loginFailed
     */
    public function setLoginFailed($loginFailed)
    {
        $this->login_failed = $loginFailed;
    }

    /**
     * Get login_failed
     *
     * @return boolean $loginFailed
     */
    public function getLoginFailed()
    {
        return $this->login_failed;
    }
}