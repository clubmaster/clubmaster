<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\Subscription
 */
class Subscription
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @var datetime $expire_date
     */
    private $expire_date;

    /**
     * @var integer $allowed_pauses
     */
    private $allowed_pauses;

    /**
     * @var boolean $auto_renewal
     */
    private $auto_renewal;

    /**
     * @var Club\UserBundle\Entity\User
     */
    private $user;


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
     * Set start_date
     *
     * @param datetime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    }

    /**
     * Get start_date
     *
     * @return datetime $startDate
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set expire_date
     *
     * @param datetime $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;
    }

    /**
     * Get expire_date
     *
     * @return datetime $expireDate
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * Set allowed_pauses
     *
     * @param integer $allowedPauses
     */
    public function setAllowedPauses($allowedPauses)
    {
        $this->allowed_pauses = $allowedPauses;
    }

    /**
     * Get allowed_pauses
     *
     * @return integer $allowedPauses
     */
    public function getAllowedPauses()
    {
        return $this->allowed_pauses;
    }

    /**
     * Set auto_renewal
     *
     * @param boolean $autoRenewal
     */
    public function setAutoRenewal($autoRenewal)
    {
        $this->auto_renewal = $autoRenewal;
    }

    /**
     * Get auto_renewal
     *
     * @return boolean $autoRenewal
     */
    public function getAutoRenewal()
    {
        return $this->auto_renewal;
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }
}