<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\TicketCoupon
 */
class TicketCoupon
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $tickets
     */
    private $tickets;

    /**
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @var datetime $expire_date
     */
    private $expire_date;

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
     * Set tickets
     *
     * @param integer $tickets
     */
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * Get tickets
     *
     * @return integer $tickets
     */
    public function getTickets()
    {
        return $this->tickets;
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