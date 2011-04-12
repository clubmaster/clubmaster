<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\TicketCoupon")
 * @orm:Table(name="club_shop_ticket_coupon")
 */
class TicketCoupon
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
     * @orm:Column(type="integer")
     *
     * @var integer $tickets
     */
    private $tickets;

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
     * @orm:ManyToOne(targetEntity="Club\UserBundle\Entity\User")
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
