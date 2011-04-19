<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Subscription")
 * @orm:Table(name="club_shop_subscription")
 */
class Subscription
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="date")
     *
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @orm:Column(type="date")
     *
     * @var datetime $expire_date
     */
    private $expire_date;

    /**
     * @orm:Column(type="integer")
     *
     * @var integer $allowed_pauses
     */
    private $allowed_pauses;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $auto_renewal
     */
    private $auto_renewal;

    /**
     * @orm:ManyToOne(targetEntity="Club\UserBundle\Entity\User", inversedBy="subscriptions")
     *
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

    public function setUser($user)
    {
      $this->user = $user;
    }

    public function getUser($user)
    {
      return $this->user;
    }
}
